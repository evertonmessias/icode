# Arquivo: /var/www/icode/ia/queryia.py

import sys
import json
import psycopg2
import requests
import re
import os
import time
import threading
import unicodedata
from datetime import datetime
from psycopg2 import sql
from bs4 import BeautifulSoup

# ==============================
# CONFIG
# ==============================

WP_CONFIG_PATH = "/var/www/icode/wp-config.php"
OLLAMA_URL = "http://localhost:11434/"
EMBED_MODEL = "nomic-embed-text"

TOP_K = 8
REQUEST_TIMEOUT = 600

INTRANET_DOCENTES = "https://intranet.ic.unicamp.br/pub/docentes/siteic/html"
INTRANET_FUNCIONARIOS = "https://intranet.ic.unicamp.br/pub/funcionarios/siteic/html"

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
DEBUG_LOG = os.path.join(BASE_DIR, "debug.log")

# ==============================
# LOGGER
# ==============================

def log_debug(msg):
    timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    with open(DEBUG_LOG, "a", encoding="utf-8") as f:
        f.write(f"[{timestamp}] {msg}\n")

# ==============================
# NORMALIZAR TEXTO
# ==============================

def normalizar(texto):
    texto = texto.lower()
    texto = unicodedata.normalize("NFD", texto)
    texto = texto.encode("ascii", "ignore").decode("utf-8")
    return texto.strip()

# ==============================
# EXTRAIR NOME DA PERGUNTA
# ==============================

def extrair_nome(pergunta):

    pergunta = pergunta.lower()

    remover = [
        "professor",
        "professora",
        "docente",
        "funcionario",
        "funcionário",
        "funcionaria",
        "funcionária",
        "quem é",
        "cargo",
        "do ic",
        "do instituto"
    ]

    for r in remover:
        pergunta = pergunta.replace(r, "")

    return pergunta.strip()

# ==============================
# SPINNER
# ==============================

class Spinner:
    def __init__(self):
        self.running = False
        self.thread = None

    def spin(self):
        chars = ["⠋","⠙","⠹","⠸","⠼","⠴","⠦","⠧","⠇","⠏"]
        i = 0
        while self.running:
            sys.stdout.write("\r" + chars[i % len(chars)])
            sys.stdout.flush()
            time.sleep(0.08)
            i += 1

    def start(self):
        self.running = True
        self.thread = threading.Thread(target=self.spin)
        self.thread.start()

    def stop(self):
        self.running = False
        if self.thread:
            self.thread.join()
        sys.stdout.write("\r \r")
        sys.stdout.flush()

# ==========================================
# DETECTAR PERGUNTA SOBRE PESSOA
# ==========================================

def pergunta_sobre_pessoa(pergunta):

    padroes = [
        r"\bprofessor\b",
        r"\bdocente\b",
        r"\bfuncion[aá]rio\b",
        r"\bquem é\b",
        r"\bcargo\b"
    ]

    pergunta_lower = pergunta.lower()

    for p in padroes:
        if re.search(p, pergunta_lower):
            log_debug("Detectado como pergunta sobre pessoa.")
            return True

    return False

# ==========================================
# BUSCAR NA INTRANET
# ==========================================

def buscar_intranet(pergunta):

    log_debug("Iniciando consulta dinâmica intranet")

    nome_busca = normalizar(extrair_nome(pergunta))
    log_debug(f"Nome extraído para busca: {nome_busca}")

    if not nome_busca:
        log_debug("Nome vazio após extração.")
        return None

    urls = [
        ("DOCENTE", INTRANET_DOCENTES),
        ("FUNCIONARIO", INTRANET_FUNCIONARIOS)
    ]

    for tipo, url in urls:

        log_debug(f"Acessando URL: {url}")

        try:
            response = requests.get(url, timeout=30)
            response.raise_for_status()

            soup = BeautifulSoup(response.text, "html.parser")
            pessoas = soup.select(".people-item")

            log_debug(f"{len(pessoas)} pessoas encontradas em {tipo}")

            for pessoa in pessoas:

                nome_tag = pessoa.select_one(".name a")
                if not nome_tag:
                    continue

                nome = nome_tag.get_text(strip=True)
                nome_norm = normalizar(nome)

                if nome_busca in nome_norm:

                    log_debug(f"Match encontrado: {nome}")

                    cargos = pessoa.select(".cargo")
                    niveis = pessoa.select(".nivel")

                    lista = []

                    for c in cargos:
                        lista.append(c.get_text(strip=True))

                    for n in niveis:
                        lista.append(n.get_text(strip=True))

                    cargo_completo = " ".join(lista)

                    log_debug(f"Cargos consolidados: {cargo_completo}")

                    return f"{nome}\n{cargo_completo}"

        except Exception as e:
            log_debug(f"Erro intranet {tipo}: {str(e)}")

    log_debug("Nenhum resultado encontrado na intranet.")
    return None

# ==========================================
# LER WP CONFIG
# ==========================================

def carregar_wp_config(caminho):

    with open(caminho, "r", encoding="utf-8") as f:
        conteudo = f.read()

    def extrair(chave):
        padrao = rf"define\(\s*['\"]{chave}['\"]\s*,\s*['\"](.*?)['\"]\s*\)"
        match = re.search(padrao, conteudo)
        return match.group(1) if match else None

    return {
        "pg_host": extrair("POSTGRE_HOST"),
        "pg_user": extrair("POSTGRE_USER"),
        "pg_data": extrair("POSTGRE_DATA"),
        "pg_pass": extrair("POSTGRE_PASS"),
        "pg_tabl": extrair("POSTGRE_TABL")
    }

# ==============================
# GERAR EMBEDDING
# ==============================

def gerar_embedding(texto):

    log_debug("Gerando embedding")

    payload = {
        "model": EMBED_MODEL,
        "input": texto
    }

    r = requests.post(
        OLLAMA_URL + "api/embed",
        json=payload,
        timeout=REQUEST_TIMEOUT
    )

    r.raise_for_status()
    return r.json()["embeddings"][0]

# ==============================
# BUSCA VETORIAL
# ==============================

def buscar_contextos(embedding):

    log_debug("Iniciando busca vetorial")

    wp_config = carregar_wp_config(WP_CONFIG_PATH)
    embedding_str = "[" + ",".join(map(str, embedding)) + "]"

    textos = []

    with psycopg2.connect(
        host=wp_config['pg_host'],
        user=wp_config['pg_user'],
        password=wp_config['pg_pass'],
        dbname=wp_config['pg_data']
    ) as conn:

        with conn.cursor() as cur:

            query = sql.SQL("""
                SELECT conteudo, url
                FROM {tabela}
                ORDER BY embedding <-> %s::vector
                LIMIT %s
            """).format(
                tabela=sql.Identifier(wp_config['pg_tabl'])
            )

            cur.execute(query, (embedding_str, TOP_K))
            resultados = cur.fetchall()

            log_debug(f"{len(resultados)} resultados vetoriais encontrados")

            for conteudo, url in resultados:

                bloco = conteudo
                if url:
                    bloco += f"\n[FONTE: {url}]"

                textos.append(bloco)

    return "\n\n---\n\n".join(textos)

# ==============================
# STREAMING RESPOSTA
# ==============================

def gerar_resposta_stream(modelo, pergunta, contexto):

    log_debug("Iniciando geração LLM")

    prompt = f"""
Use exclusivamente o contexto abaixo.
Se não encontrar a resposta, diga que não encontrou.

CONTEXTO:
{contexto}

PERGUNTA:
{pergunta}

RESPOSTA:
"""

    payload = {
        "model": modelo,
        "prompt": prompt,
        "stream": True,
        "options": {
            "temperature": 0.2
        }
    }

    spinner = Spinner()
    spinner.start()
    first_token = True

    with requests.post(
        OLLAMA_URL + "api/generate",
        json=payload,
        stream=True,
        timeout=REQUEST_TIMEOUT
    ) as r:

        r.raise_for_status()

        for linha in r.iter_lines():

            if not linha:
                continue

            try:
                data = json.loads(linha.decode("utf-8"))
            except:
                continue

            if "response" in data:

                if first_token:
                    spinner.stop()
                    first_token = False

                print(data["response"], end="", flush=True)

            if data.get("done"):
                break

    print("\n")

# ==============================
# MAIN
# ==============================

if __name__ == "__main__":

    if len(sys.argv) < 3:
        print("Uso: python3 queryia.py <modelo> \"Pergunta\"")
        sys.exit(1)

    modelo = sys.argv[1]
    pergunta = sys.argv[2]

    log_debug("--------------------------------------------------")
    log_debug(f"Pergunta recebida: {pergunta}")

    try:

        # 🔹 Consulta direta na intranet
        if pergunta_sobre_pessoa(pergunta):

            resposta = buscar_intranet(pergunta)

            if resposta:
                print("\n" + resposta + "\n")
                sys.exit(0)

        # 🔹 Caso contrário → RAG vetorial
        embedding = gerar_embedding(pergunta)
        contexto = buscar_contextos(embedding)

        if not contexto.strip():
            print("Nenhum contexto encontrado.")
            sys.exit(1)

        gerar_resposta_stream(modelo, pergunta, contexto)

    except Exception as e:
        log_debug(f"Erro geral: {str(e)}")
        print(f"Erro: {str(e)}")
        sys.exit(1)
