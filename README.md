# 🧩 NOVOICODE — Documentação Técnica

## 📘 Visão Geral

O **NOVOICODE** é um projeto WordPress personalizado que inclui:

* Um **plugin** exclusivo (`novoicode`);
* Um **tema** customizado (`novoicode`);
* Um sistema de **controle de acesso a arquivos PDF**;
* Um **tutorial estático em HTML e imagens**, servindo como documentação do uso do sistema.

---

## CI/CD Gitlab Runner

O projeto tem acesso ao runner do icode.ic.unicamp.br e o mesmo está para substituir:

    - cat ./.htaccess > /var/www/html/icode2/.htaccess
    - cat ./file.php > /var/www/html/icode2/file.php
    - rsync -av --delete ./tutorial/ /var/www/html/icode2/tutorial/
    - rsync -av --delete ./wp-content/plugins/novoicode /var/www/html/icode2/wp-content/plugins/novoicode
    - rsync -av --delete ./wp-content/themes/novoicode /var/www/html/icode2/wp-content/themes/novoicode

Fora isso as configurações precisam ser feitas diretamente no servidor.

---

## 📂 Estrutura do Projeto

```
/wp-content/
├── plugins/
│   └── novoicode/         # Plugin desenvolvido por Everton
│
├── themes/
│   └── novoicode/         # Tema desenvolvido por Everton
│
└── uploads/               # Diretório padrão do WordPress para armazenar dados e arquivos enviados
```

---

## 🔌 Plugin: `novoicode`

**Autor:** Everton
**Local:** `wp-content/plugins/novoicode`

### 🧠 Funções Principais

* Adiciona funcionalidades personalizadas ao site NOVOICODE.
* Pode incluir:

  * Shortcodes,
  * Custom post types,
  * Integrações com APIs,
  * Campos personalizados,
  * Lógica de acesso a arquivos.

### ⚙️ Instalação

1. Copie a pasta `novoicode` para `wp-content/plugins/`.
2. Acesse o painel do WordPress → **Plugins → Instalados**.
3. Ative o plugin **NOVOICODE**.

### 📁 Estrutura Interna Sugerida

```
novoicode/
├── novoicode.php        # Arquivo principal do plugin
├── includes/            # Funções auxiliares
├── assets/              # Scripts, CSS e JS
└── templates/           # Templates customizados (opcional)
```

---

## 🎨 Tema: `novoicode`

**Autor:** Everton
**Local:** `wp-content/themes/novoicode`

### 🧩 Descrição

Tema WordPress desenvolvido exclusivamente para o projeto NOVOICODE, controlando layout, design e estrutura de exibição.

### ⚙️ Instalação

1. Copie a pasta `novoicode` para `wp-content/themes/`.
2. Acesse o painel do WordPress → **Aparência → Temas**.
3. Ative o tema **NOVOICODE**.

### 📁 Estrutura Interna Sugerida

```
novoicode/
├── style.css             # Cabeçalho e estilos principais
├── functions.php         # Funções e configurações do tema
├── header.php, footer.php, index.php
├── page.php, single.php
└── assets/
    ├── css/
    └── js/
```

---

## 📖 Tutorial Estático

O projeto inclui uma **documentação/tutorial estático** em formato **HTML e imagens**, que explica:

* Como utilizar o sistema NOVOICODE;
* Etapas de configuração e uso das funcionalidades;
* Referência visual e exemplos de interface.

### 📁 Localização

O tutorial estático pode ser hospedado dentro do tema ou em um diretório separado, por exemplo:

```
/wp-content/themes/novoicode/tutorial/
```

ou

```
/tutorial/
```

### 📦 Conteúdo

* Páginas HTML (ex: `index.html`, `guia-instalacao.html`)
* Imagens ilustrativas (`/img/`)
* Arquivos CSS e JS para estilo e navegação entre páginas

---

## 🔒 Controle de Acesso a Arquivos

### 📄 Arquivo: `file.php`

Responsável por **controlar o acesso a arquivos PDF** protegidos pelo `.htaccess`.

### 🧱 Funcionamento

* PDFs são bloqueados contra acesso direto via URL.
* Toda requisição a um PDF passa por `file.php`, que verifica se o usuário tem permissão (login, token, etc.).
* Somente usuários autorizados podem visualizar ou baixar os arquivos.

### 🧰 Estrutura

```
/
├── .htaccess
└── file.php
```

**Exemplo de regra no `.htaccess`:**

```apache
<FilesMatch "\.pdf$">
  Deny from all
</FilesMatch>

RewriteEngine On
RewriteRule ^wp-content/(.*)\.pdf$ /file.php?file=$1 [L,QSA]
```

**Exemplo simplificado de `file.php`:**

```php
<?php
require_once(dirname(__FILE__) . '/wp-load.php');

// Configurações iniciais
$upload_dir = wp_upload_dir();
$base_upload_path = $upload_dir['basedir'];

// Obter o parâmetro do arquivo
$file_path = isset($_GET['file']) ? $_GET['file'] : '';

// Decodificar a URL corretamente
$decoded_path = urldecode($file_path);

// Construir os caminhos completos
$full_path = realpath($base_upload_path . '/' . $decoded_path);
$url_completa = home_url("/wp-content/uploads/" . $file_path);

error_log('************************ file.php ********************************');

// Verificar se o usuário está logado
if (!is_user_logged_in()) {
    $_SESSION['ldap_login_redirect'] = $url_completa;
    error_log('Iniciada SESSION no file.php ==> ' . $_SESSION['ldap_login_redirect']);
    wp_redirect(wp_login_url(home_url($_SESSION['ldap_login_redirect'])));
    exit;
} else {
    // Verificar permissões do usuário
    if (!permite_url($url_completa, wp_get_current_user()->ID)) {
        wp_die('Acesso somente para Membros.<br><a href="/">Voltar</a>');
    } else {
        registerdb(wp_get_current_user()->user_login, $_SERVER['REMOTE_ADDR'], "/wp-content/uploads/" . $file_path);
        // Enviar o arquivo PDF
        if (file_exists($full_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($full_path) . '"');
            header('Content-Length: ' . filesize($full_path));
            readfile($full_path);
            exit;
        } else {
            status_header(404);
            wp_die('O arquivo solicitado não foi encontrado no servidor.');
        }
    }
}
```

---

## 💾 Armazenamento de Dados

Todos os **arquivos enviados e dados gerados** pelo sistema (imagens, PDFs, uploads de usuários, etc.) ficam armazenados no diretório padrão do WordPress:

```
wp-content/uploads/
```

Esse diretório é utilizado tanto pelo WordPress quanto pelo plugin e tema para armazenar:

* PDFs protegidos,
* Imagens do tutorial,
* Arquivos de mídia de posts e páginas,
* Outros dados temporários.

---

## 👨‍💻 Desenvolvedor Responsável

**Nome:** Everton
**Função:** Desenvolvimento do plugin, tema e controle de acesso

---

## 🧾 Histórico de Versões

| Versão | Data       | Alterações                                                                          |
| ------ | ---------- | ----------------------------------------------------------------------------------- |
| 1.0.0  | 2025-10-07 | Criação inicial do plugin, tema, controle de acesso e documentação estática em HTML |

---
