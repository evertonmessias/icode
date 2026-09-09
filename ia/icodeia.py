# Arquivo: /var/www/icode/ia/icodeia.py

import re
import requests
import pymysql
import psycopg2
from psycopg2.extras import execute_values
from tqdm import tqdm
import hashlib
import time
from requests.exceptions import RequestException


# ==========================================
# CONFIG
# ==========================================

WP_CONFIG_PATH = "/var/www/icode/wp-config.php"

POST_TYPES = ['congrega', 'ci', 'dsc', 'dsi', 'dtc', 'cdi']

OLLAMA_URL = "http://192.168.0.10:11434/"
OLLAMA_MODEL = "nomic-embed-text"

ANO_MINIMO = 2026

CHUNK_SIZE = 1000
EMBED_BATCH_SIZE = 20
DB_BATCH_SIZE = 200
EMBED_TIMEOUT = 120
MAX_RETRIES = 5
REQUEST_DELAY = 0.3


# ==========================================
# UTIL
# ==========================================

def log(msg):
    print(f"[{time.strftime('%H:%M:%S')}] {msg}")


def gerar_hash(texto):
    return hashlib.sha256(texto.encode("utf-8")).hexdigest()


def limpar_texto(texto):
    if not texto:
        return ""
    texto = re.sub(r'<[^>]+>', '', texto)
    texto = re.sub(r'\s+', ' ', texto)
    return texto.strip()


def chunk_texto(texto):
    return [texto[i:i + CHUNK_SIZE] for i in range(0, len(texto), CHUNK_SIZE)]


# ==========================================
# WP CONFIG
# ==========================================

def carregar_wp_config(caminho):
    with open(caminho, "r", encoding="utf-8") as f:
        conteudo = f.read()

    def extrair(chave):
        padrao = rf"define\(\s*['\"]{chave}['\"]\s*,\s*['\"](.*?)['\"]\s*\)"
        match = re.search(padrao, conteudo)
        return match.group(1) if match else None

    return {
        "host": extrair("DB_HOST"),
        "user": extrair("DB_USER"),
        "password": extrair("DB_PASSWORD"),
        "database": extrair("DB_NAME"),
        "pg_host": extrair("POSTGRE_HOST"),
        "pg_user": extrair("POSTGRE_USER"),
        "pg_data": extrair("POSTGRE_DATA"),
        "pg_pass": extrair("POSTGRE_PASS"),
        "pg_tabl": extrair("POSTGRE_TABL")
    }


# ==========================================
# COLETAR DADOS
# ==========================================

def gerar_dados():

    wp_config = carregar_wp_config(WP_CONFIG_PATH)

    conn = pymysql.connect(
        host=wp_config["host"],
        user=wp_config["user"],
        password=wp_config["password"],
        database=wp_config["database"],
        charset="utf8mb4"
    )

    cursor = conn.cursor(pymysql.cursors.DictCursor)
    dados = []

    for post_type in POST_TYPES:

        cursor.execute("""
            SELECT ID, post_title, post_content
            FROM wp_posts
            WHERE post_type=%s
              AND post_status='publish'
        """, (post_type,))

        posts = cursor.fetchall()

        for post in tqdm(posts, desc=f"{post_type}", unit="post"):

            assuntos = limpar_texto(post["post_content"])
            titulo = limpar_texto(post["post_title"])

            cursor.execute("""
                SELECT texto, ano, url
                FROM wp_pdf_index
                WHERE id_post=%s
                  AND texto IS NOT NULL
                  AND ano >= %s
            """, (post["ID"], ANO_MINIMO))

            documentos = cursor.fetchall()

            for d in documentos:

                texto_doc = limpar_texto(d["texto"])
                if not texto_doc:
                    continue

                texto_completo = f"""
                    TIPO: {post_type}
                    TÍTULO: {titulo}
                    ANO: {d['ano']}

                    ASSUNTOS:
                    {assuntos}

                    DOCUMENTO:
                    {texto_doc}

                    FONTE:
                    {d['url']}
                    """

                dados.append({
                    "projeto_id": post["ID"],
                    "ano": d["ano"],
                    "url": d["url"],
                    "texto": texto_completo
                })

    cursor.close()
    conn.close()

    return dados


# ==========================================
# EMBEDDING
# ==========================================

def gerar_embeddings_batch(textos):

    payload = {
        "model": OLLAMA_MODEL,
        "input": textos
    }

    delay = 3

    for tentativa in range(1, MAX_RETRIES + 1):

        try:
            response = requests.post(
                OLLAMA_URL + "api/embed",
                json=payload,
                timeout=EMBED_TIMEOUT
            )

            response.raise_for_status()
            data = response.json()

            if "embeddings" not in data:
                raise Exception("Resposta inválida do Ollama.")

            return data["embeddings"]

        except RequestException as e:
            log(f"Erro embedding tentativa {tentativa}: {e}")

            if tentativa == MAX_RETRIES:
                log("Falha definitiva no batch. Tentando fallback unitário...")
                break

            time.sleep(delay)
            delay *= 2

    # Fallback: processar um por um
    embeddings = []
    for texto in textos:
        try:
            emb = gerar_embeddings_batch([texto])
            embeddings.append(emb[0])
            time.sleep(REQUEST_DELAY)
        except:
            log("Falha definitiva em chunk isolado. Pulando.")
            embeddings.append(None)

    return embeddings


# ==========================================
# SALVAR EMBEDDINGS
# ==========================================

def salvar_embeddings(dados):

    wp_config = carregar_wp_config(WP_CONFIG_PATH)

    conn_pg = psycopg2.connect(
        host=wp_config['pg_host'],
        user=wp_config['pg_user'],
        password=wp_config['pg_pass'],
        dbname=wp_config['pg_data']
    )

    cursor_pg = conn_pg.cursor()

    log("Carregando hashes existentes...")
    cursor_pg.execute(f"SELECT chunk_hash FROM {wp_config['pg_tabl']}")
    hashes_existentes = {row[0] for row in cursor_pg.fetchall()}
    log(f"{len(hashes_existentes)} chunks já indexados.")

    novos_chunks = []

    for item in dados:
        for chunk in chunk_texto(item["texto"]):
            h = gerar_hash(chunk)
            if h not in hashes_existentes:
                novos_chunks.append((item, chunk, h))

    log(f"{len(novos_chunks)} novos chunks para processar.")

    if not novos_chunks:
        log("Nada novo para indexar.")
        return

    db_batch = []
    embed_texts = []
    embed_meta = []

    with tqdm(total=len(novos_chunks), desc="Vetorizando", unit="chunk") as pbar:

        for item, chunk, chunk_hash in novos_chunks:

            embed_texts.append(chunk)
            embed_meta.append((item, chunk_hash))

            if len(embed_texts) >= EMBED_BATCH_SIZE:

                embeddings = gerar_embeddings_batch(embed_texts)

                for emb, (meta, h), txt in zip(embeddings, embed_meta, embed_texts):

                    if emb is None:
                        continue

                    db_batch.append((
                        meta["projeto_id"],
                        meta["ano"],
                        emb,
                        h,
                        txt,
                        meta["url"]
                    ))

                embed_texts.clear()
                embed_meta.clear()
                time.sleep(REQUEST_DELAY)

            if len(db_batch) >= DB_BATCH_SIZE:
                execute_values(
                    cursor_pg,
                    f"""
                    INSERT INTO {wp_config['pg_tabl']}
                    (projeto_id, ano, embedding, chunk_hash, conteudo, url)
                    VALUES %s
                    ON CONFLICT (chunk_hash) DO NOTHING
                    """,
                    db_batch
                )
                conn_pg.commit()
                db_batch.clear()

            pbar.update(1)

        # flush final
        if embed_texts:
            embeddings = gerar_embeddings_batch(embed_texts)

            for emb, (meta, h), txt in zip(embeddings, embed_meta, embed_texts):
                if emb is None:
                    continue

                db_batch.append((
                    meta["projeto_id"],
                    meta["ano"],
                    emb,
                    h,
                    txt,
                    meta["url"]
                ))

        if db_batch:
            execute_values(
                cursor_pg,
                f"""
                INSERT INTO {wp_config['pg_tabl']}
                (projeto_id, ano, embedding, chunk_hash, conteudo, url)
                VALUES %s
                ON CONFLICT (chunk_hash) DO NOTHING
                """,
                db_batch
            )
            conn_pg.commit()

    cursor_pg.close()
    conn_pg.close()

    log("Indexação concluída.")


# ==========================================
# MAIN
# ==========================================

if __name__ == "__main__":

    inicio = time.time()

    log("Iniciando processo...")

    dados = gerar_dados()

    log(f"Total registros coletados: {len(dados)}")

    salvar_embeddings(dados)

    log(f"Tempo total: {(time.time() - inicio)/60:.1f} minutos")
    log("Processo finalizado.")
