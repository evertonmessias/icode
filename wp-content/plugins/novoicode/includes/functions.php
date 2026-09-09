<?php
// Arquivo: wp-content/plugins/novoicode/includes/functions.php

// Session
function iniciar_sessao_personalizada() {
    if (!session_id()) {
        session_start();
        error_log('🔓 functions.php - Sessão iniciada');
        //
    }
}
add_action('init', 'iniciar_sessao_personalizada');

// Redirect ***********************************************************************************
function icode_redirect() {
    error_log('🔄 functions.php - icode_redirect() ACIONADO');
    error_log('📋 functions.php - REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
    
    // ✅ EXCEÇÃO: Permitir acesso às páginas /index e /icodeia sem login
    if ($_SERVER['REQUEST_URI'] == '/index' || $_SERVER['REQUEST_URI'] == '/index/' ||
    $_SERVER['REQUEST_URI'] == '/wp-content/uploads/icodeia/icodeia.json') {
        error_log('✅ functions.php - Página index, acesso permitido sem login');
        return;
    }
    
    if (
        !is_user_logged_in() &&
        !is_page('login') &&
        !is_page('googlelogin') &&
        !is_admin() &&
        !(defined('DOING_AJAX') && DOING_AJAX) &&
        !(defined('REST_REQUEST') && REST_REQUEST) &&
        !wp_doing_cron()
    ) {
        error_log('🎯 functions.php - REDIRECIONAMENTO NECESSÁRIO');
        
        // Se for a página inicial, redireciona para /perfil após login
        if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '' || $_SERVER['REQUEST_URI'] == '/favicon.ico') {
            $redirect_to = home_url('/perfil');
            error_log('🏠 functions.php - Página inicial, redirecionar para perfil');
        } else {
            $redirect_to = home_url($_SERVER['REQUEST_URI']);
            error_log('🎯 functions.php - Página específica, redirecionar para: ' . $redirect_to);
        }

        if (empty($_SESSION['ldap_login_redirect'])) {
            $_SESSION['ldap_login_redirect'] = $redirect_to;
            error_log('💾 functions.php - SESSION[ldap_login_redirect] SETADO: ' . $_SESSION['ldap_login_redirect']);
        } else {
            error_log('📌 functions.php - SESSION[ldap_login_redirect] JÁ existia: ' . $_SESSION['ldap_login_redirect']);
        }

        $login_url = home_url('/login') . '?redirect_to=' . urlencode($_SESSION['ldap_login_redirect']);
        error_log('🔗 functions.php - URL de login com redirect: ' . $login_url);

        wp_redirect($login_url);
        exit;
    } else {
        error_log('✅ functions.php - Redirecionamento NÃO necessário');
    }
}
add_action('template_redirect', 'icode_redirect');



// Add style & script for Admin ************************************************************************

function styles_and_scripts_plugin()
{
    wp_enqueue_script("jquery");
    wp_enqueue_style("datatable-css", "https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css");
    wp_enqueue_style("datatable-buttons-css", "https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css");
    wp_enqueue_style("bootstrap5-css", "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css");
    wp_enqueue_style("custom-css", "/wp-content/plugins/novoicode/assets/css/novoicode.css");

    wp_enqueue_script("datatable-js", "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js", array("jquery"), null, true);
    wp_enqueue_script("datatable-buttons-js", "https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js", array("jquery"), null, true);
    wp_enqueue_script("datatable-buttons-html5-js", "https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js", array("jquery"), null, true);
    wp_enqueue_script("bootstrap5-js", "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js", array("jquery"), null, true);
    wp_enqueue_script("custom-js", "/wp-content/plugins/novoicode/assets/js/novoicode.js", array("jquery"), null, true);
}
add_action("admin_enqueue_scripts", "styles_and_scripts_plugin");


//***************** Add General Configuration Roles **************************************************
function general_configuration_role_caps()
{
    $roles = array('editor');
    foreach ($roles as $the_role) {
        $role = get_role($the_role);

        // Removendo permissões de gerenciamento de usuários
        $role->remove_cap('list_users');
        $role->remove_cap('create_users');
        $role->remove_cap('remove_users');
        $role->remove_cap('promote_users');
        $role->remove_cap('edit_users');

        // Adicionando permissões de gerenciamento geral
        $role->add_cap('manage_options');

        // Adicionando permissões para criar, editar e excluir qualquer post
        $role->add_cap('edit_posts');
        $role->add_cap('edit_others_posts');
        $role->add_cap('publish_posts');
        $role->add_cap('delete_posts');
        $role->add_cap('delete_others_posts');
        $role->add_cap('edit_published_posts');
        $role->add_cap('delete_published_posts');
    }
}
add_action('admin_init', 'general_configuration_role_caps', 999);


//Rename menu iten Admin *********************************************************
function wd_admin_menu_rename()
{
    global $menu;
    //$menu[5][0] = 'Blog IC';
}
add_action('admin_menu', 'wd_admin_menu_rename');


// Admin Bar
add_action('after_setup_theme', function () {
    if (current_user_can('administrator')) {
        show_admin_bar(false);
    } else {
        show_admin_bar(false);
    }
});


// Bloquear acesso ao /wp-admin para editores, exceto admin-post.php
function bloquear_acesso_admin()
{
    if (is_admin() && !current_user_can('administrator')) {
        // Permitir acesso ao admin-post.php para processar os formulários
        $pagina_permitida = strpos($_SERVER['REQUEST_URI'], 'admin-post.php') !== false;

        if (!$pagina_permitida && !(defined('DOING_AJAX') && DOING_AJAX)) {
            wp_redirect(home_url('/404'));
            exit;
        }
    }
}
add_action('init', 'bloquear_acesso_admin');


// ************************************************************************************* SMTP
function configurar_smtp()
{
    add_action('phpmailer_init', 'wp_smtp');
}

function wp_smtp($phpmailer)
{
    $phpmailer->isSMTP();
    $phpmailer->Host = SMTP_HOST;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Username = SMTP_USER;
    $phpmailer->Password = SMTP_PASS;
    $phpmailer->SMTPSecure = SMTP_SECURE;
    $phpmailer->Port = SMTP_PORT;
    $phpmailer->From = SMTP_FROM;
    $phpmailer->FromName = SMTP_NAME;
}

add_action('init', 'configurar_smtp');

function registerdb($user = NULL, $ip = NULL, $url = NULL) // register in db
{
    global $wpdb;

    if ($user == NULL) {
        $user = " --- ";
    }
    if ($url == NULL) {
        $url = "/";
    }
    $table_name = $wpdb->prefix . 'acessos';
    $wpdb->insert($table_name, array('user' => $user, 'ipadress' => $ip, 'url' => $url, 'time' => current_time('mysql')));
}
add_action('registerdb', 'registerdb');


//************* IC - APIs ***************************************************************
function icapi($attr)
{
    if ($attr['tipo'] == "" || $attr['saida'] == "") {

        return "<h4 class='center red'>ERRO!</h4>";
    } else {

        $tipo = "/" . $attr['tipo'];

        $saida = "/" . $attr['saida'];

        $string = INTRANET . $tipo . $saida;

        $url = file_get_contents($string);

        return $url . "<h1>&nbsp;</h1><small class='fonte'><b>Fonte</b>:&ensp;<a href='" . $string . "' target='_blank'>" . $string . "</a></small>";
    }
}
add_shortcode('icapi', 'icapi');



//************* Indexação de PDF ***************************************************************
// Função para executar indexação manual pela interface
function executar_indexacao_manual_interface() {
    // Verificar permissões
    if (!current_user_can('edit_posts')) {
        return '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Sem permissão para executar esta ação.</div>';
    }

    // Obter tipos de conteúdo
    $tipos_conteudo_str = get_option('portal_input_7');
    $tipos_conteudo = array_map('trim', explode(',', $tipos_conteudo_str));
    $ano_atual = date('Y');

    if (empty($tipos_conteudo)) {
        return '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Nenhum tipo de conteúdo configurado no portal_input_7.</div>';
    }

    $arquivos_totais = [];
    $urls_totais = [];
    $ids_totais = [];
    $tipos_totais = [];
    $anos_totais = [];

    // Coletar todos os arquivos PDF (mesma lógica da page-index.php)
    foreach ($tipos_conteudo as $tipo) {
        $base_dir = ABSPATH . "wp-content/uploads/$tipo/$ano_atual";

        if (!file_exists($base_dir)) {
            continue;
        }

        $subdirs = scandir($base_dir);
        foreach ($subdirs as $subdir) {
            if ($subdir === '.' || $subdir === '..') continue;

            $full_path = $base_dir . '/' . $subdir;
            if (!is_dir($full_path)) continue;

            $id_post = is_numeric($subdir) ? intval($subdir) : 0;

            try {
                $directory = new RecursiveDirectoryIterator($full_path, RecursiveDirectoryIterator::SKIP_DOTS);
                $filter = new RecursiveCallbackFilterIterator($directory, function ($fileInfo, $key, $iterator) {
                    if ($fileInfo->isDir() && $fileInfo->getFilename() === 'privado') {
                        return false;
                    }
                    return true;
                });
                $iterator = new RecursiveIteratorIterator($filter);

                foreach ($iterator as $arquivo) {
                    if (pathinfo($arquivo, PATHINFO_EXTENSION) === 'pdf') {
                        $arquivos_totais[] = (string) $arquivo;
                        $subpath = str_replace(ABSPATH, '', (string) $arquivo);
                        $url_pdf = '/' . str_replace('\\', '/', $subpath);
                        $urls_totais[] = esc_url($url_pdf);
                        $ids_totais[] = $id_post;
                        $tipos_totais[] = $tipo;
                        $anos_totais[] = $ano_atual;
                    }
                }
            } catch (Exception $e) {
                continue;
            }
        }
    }

    if (empty($arquivos_totais)) {
        return '<div class="alert alert-warning"><i class="fas fa-info-circle me-2"></i>Nenhum PDF encontrado para indexação automática.</div>';
    }

    // Exibir interface de progresso (igual à anterior)
    $output = '<div class="card mt-4" id="progresso-automatico-box">';
    $output .= '<div class="card-header bg-warning text-white">';
    $output .= '<h5 class="mb-0"><i class="fas fa-play-circle me-2"></i>Execução da Indexação Automática</h5>';
    $output .= '</div>';
    $output .= '<div class="card-body">';
    $output .= '<p><strong>Modo:</strong> Indexação Automática</p>';
    $output .= '<p><strong>Tipos Processados:</strong> ' . implode(', ', $tipos_conteudo) . '</p>';
    $output .= '<p><strong>Ano:</strong> ' . $ano_atual . '</p>';
    $output .= '<p><strong>Total de PDFs:</strong> ' . count($arquivos_totais) . '</p>';

    $output .= '<div class="progress mb-3" style="height: 25px;">';
    $output .= '<div id="progresso-automatico" class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
    $output .= '</div>';

    $output .= '<div id="status-automatico" class="alert alert-secondary">';
    $output .= '<i class="fas fa-spinner fa-spin me-2"></i>Preparando para iniciar indexação automática...';
    $output .= '</div>';
    $output .= '</div></div>';

    $output .= '<script>
    const arquivosAuto = ' . json_encode($arquivos_totais) . ';
    const urlsAuto = ' . json_encode($urls_totais) . ';
    const idsAuto = ' . json_encode($ids_totais) . ';
    const tiposAuto = ' . json_encode($tipos_totais) . ';
    const anosAuto = ' . json_encode($anos_totais) . ';
    const totalAuto = arquivosAuto.length;
    let indexAuto = 0;

    async function indexarProximoAuto() {
        if (indexAuto >= totalAuto) {
            document.getElementById("status-automatico").innerHTML = \'<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><strong>Indexação automática concluída!</strong> Todos os PDFs foram processados.</div>\';
            document.getElementById("progresso-automatico").classList.remove("progress-bar-animated");
            return;
        }

        const arquivoAtual = arquivosAuto[indexAuto];
        const urlAtual = urlsAuto[indexAuto];
        const idAtual = idsAuto[indexAuto];
        const tipoAtual = tiposAuto[indexAuto];
        const anoAtual = anosAuto[indexAuto];

        const porc = Math.round(((indexAuto + 1) / totalAuto) * 100);
        document.getElementById("progresso-automatico").style.width = porc + "%";
        document.getElementById("progresso-automatico").setAttribute("aria-valuenow", porc);
        document.getElementById("progresso-automatico").textContent = porc + "%";
        
        const nomeArquivo = arquivoAtual.split(/[\\\\/]/).pop();
        document.getElementById("status-automatico").innerHTML = \'<i class="fas fa-spinner fa-spin me-2"></i>Processando: <strong>\' + nomeArquivo + \'</strong> (\' + (indexAuto + 1) + \'/\' + totalAuto + \') - <small>\' + tipoAtual + \'/\' + anoAtual + \'</small>\';

        try {
            const formData = new URLSearchParams({
                action: "novoicode_indexar_pdf",
                arquivo: arquivoAtual,
                url: urlAtual,
                tipo: tipoAtual,
                ano: anoAtual,
                id: idAtual,
                nonce: "' . wp_create_nonce('novoicode_indexar_pdf') . '"
            });

            const response = await fetch("' . esc_url_raw(admin_url("admin-ajax.php")) . '", {
                method: "POST",
                body: formData
            });

            if (!response.ok) throw new Error("Erro na requisição");

            const result = await response.json();
            if (!result.success) {
                throw new Error(result.data);
            }
        } catch (error) {
            console.error("Erro ao indexar, pulando arquivo:", error);
            document.getElementById("status-automatico").innerHTML += \' <span class="text-danger"><strong>(Pulado devido a erro)</strong></span>\';
        } finally {
            indexAuto++;
            setTimeout(indexarProximoAuto, 100);
        }
    }

    // Iniciar após 1 segundo
    setTimeout(indexarProximoAuto, 1000);
    </script>';

    return $output;
}

function novoicode_processar_indexacao_manual($tipo, $ano)
{
    $base_dir = ABSPATH . "wp-content/uploads/$tipo/$ano";

    if (!file_exists($base_dir)) {
        echo '<div class="alert alert-danger mt-4"><i class="fas fa-exclamation-triangle me-2"></i>Diretório não encontrado: ' . esc_html($base_dir) . '</div>';
        return;
    }

    $arquivos = [];
    $urls = [];
    $ids = [];

    // Scan the year directory
    $subdirs = scandir($base_dir);
    foreach ($subdirs as $subdir) {
        if ($subdir === '.' || $subdir === '..')
            continue;

        $full_path = $base_dir . '/' . $subdir;
        if (!is_dir($full_path))
            continue;

        // Determine ID based on subdirectory name
        $id_post = is_numeric($subdir) ? intval($subdir) : 0;

        try {
            $directory = new RecursiveDirectoryIterator($full_path, RecursiveDirectoryIterator::SKIP_DOTS);
            $filter = new RecursiveCallbackFilterIterator($directory, function ($fileInfo, $key, $iterator) {
                // Ignora o diretório 'privado'
                if ($fileInfo->isDir() && $fileInfo->getFilename() === 'privado') {
                    return false;
                }
                return true;
            });
            $iterator = new RecursiveIteratorIterator($filter);

            foreach ($iterator as $arquivo) {
                if (pathinfo($arquivo, PATHINFO_EXTENSION) === 'pdf') {
                    $arquivos[] = (string) $arquivo;
                    $subpath = str_replace(ABSPATH, '', (string) $arquivo);
                    $url_pdf = '/' . str_replace('\\', '/', $subpath);
                    $urls[] = esc_url($url_pdf);
                    $ids[] = $id_post;
                }
            }
        } catch (Exception $e) {
            // Continua mesmo se houver erro em um subdiretório
            continue;
        }
    }

    if (empty($arquivos)) {
        echo '<div class="alert alert-warning mt-4"><i class="fas fa-info-circle me-2"></i>Nenhum PDF encontrado no diretório: ' . esc_html($base_dir) . '</div>';
        return;
    }

    echo '<div class="card mt-4" id="progresso-box">';
    echo '<div class="card-header bg-info text-white">';
    echo '<h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Progresso da Indexação</h5>';
    echo '</div>';
    echo '<div class="card-body">';
    echo '<p><strong>Diretório:</strong> ' . esc_html($base_dir) . '</p>';
    echo '<p><strong>Total de PDFs:</strong> ' . count($arquivos) . '</p>';

    echo '<div class="progress mb-3" style="height: 25px;">';
    echo '<div id="progresso" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>';
    echo '</div>';

    echo '<div id="status" class="alert alert-secondary">';
    echo '<i class="fas fa-spinner fa-spin me-2"></i>Preparando para iniciar...';
    echo '</div>';
    echo '</div></div>';

    echo '<script>
    const arquivos = ' . json_encode($arquivos) . ';
    const urls = ' . json_encode($urls) . ';
    const ids = ' . json_encode($ids) . ';
    const tipo = ' . json_encode($tipo) . ';
    const ano = ' . json_encode($ano) . ';
    const total = arquivos.length;
    let index = 0;

    async function indexarProximo() {
        if (index >= total) {
            document.getElementById("status").innerHTML = \'<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><strong>Indexação concluída!</strong> Todos os PDFs foram processados.</div>\';
            document.getElementById("progresso").classList.remove("progress-bar-animated");
            return;
        }

        const arquivoAtual = arquivos[index];
        const urlAtual = urls[index];
        const idAtual = ids[index];

        const porc = Math.round(((index + 1) / total) * 100);
        document.getElementById("progresso").style.width = porc + "%";
        document.getElementById("progresso").setAttribute("aria-valuenow", porc);
        document.getElementById("progresso").textContent = porc + "%";
        
        const nomeArquivo = arquivoAtual.split(/[\\\\/]/).pop();
        document.getElementById("status").innerHTML = \'<i class="fas fa-spinner fa-spin me-2"></i>Processando: <strong>\' + nomeArquivo + \'</strong> (\' + (index + 1) + \'/\' + total + \')\';

        try {
            const formData = new URLSearchParams({
                action: "novoicode_indexar_pdf",
                arquivo: arquivoAtual,
                url: urlAtual,
                tipo: tipo,
                ano: ano,
                id: idAtual,
                nonce: "' . wp_create_nonce('novoicode_indexar_pdf') . '"
            });

            const response = await fetch("' . esc_url_raw(admin_url("admin-ajax.php")) . '", {
                method: "POST",
                body: formData
            });

            if (!response.ok) throw new Error("Erro na requisição");

            const result = await response.json();
            if (!result.success) {
                throw new Error(result.data);
            }
        } catch (error) {
            console.error("Erro ao indexar, pulando arquivo:", error);
            document.getElementById("status").innerHTML += \' <span class="text-danger"><strong>(Pulado devido a erro)</strong></span>\';
        } finally {
            index++;
            setTimeout(indexarProximo, 100);
        }
    }

    // Iniciar após 1 segundo
    setTimeout(indexarProximo, 1000);
    </script>';
}

// Handler AJAX para indexação de PDF
add_action('wp_ajax_novoicode_indexar_pdf', 'novoicode_ajax_indexar_pdf');
function novoicode_ajax_indexar_pdf() {
    // Verificar nonce
    if (!wp_verify_nonce($_POST['nonce'], 'novoicode_indexar_pdf')) {
        wp_die('Erro de segurança');
    }

    $arquivo = sanitize_text_field($_POST['arquivo']);
    $url = esc_url_raw($_POST['url']);
    $tipo = sanitize_text_field($_POST['tipo']);
    $ano = intval($_POST['ano']);
    $id_post = intval($_POST['id']);

    $resultado = novoicode_indexar_pdf_direct($arquivo, $url, $tipo, $ano, $id_post);
    
    if ($resultado) {
        wp_send_json_success('PDF indexado com sucesso');
    } else {
        wp_send_json_error('Erro ao indexar PDF');
    }
}

// Função para indexar PDF diretamente (completa)
function novoicode_indexar_pdf_direct($arquivo, $url_pdf, $tipo, $ano, $id_post) {
    global $wpdb;
    
    try {
        if (!file_exists($arquivo)) {
            error_log("Novoicode PDF Index: Arquivo não encontrado - $arquivo");
            return false;
        }

        // Verificar se já existe na tabela - CORREÇÃO: verificar por arquivo E url
        $existe = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}pdf_index WHERE arquivo = %s OR url = %s",
            $arquivo, $url_pdf
        ));

        if ($existe) {
            error_log("Novoicode PDF Index: PDF já indexado - $arquivo");
            return true; // Já existe, considerar sucesso
        }

        // Extrair texto do PDF
        $texto_pdf = novoicode_extrair_texto_pdf($arquivo);
        
        if (empty($texto_pdf)) {
            error_log("Novoicode PDF Index: Não foi possível extrair texto - $arquivo");
            $texto_pdf = ''; // Inserir mesmo vazio para registrar a tentativa
        }

        // Inserir no banco de dados
        $resultado = $wpdb->insert(
            "{$wpdb->prefix}pdf_index",
            array(
                'arquivo' => $arquivo,
                'url' => $url_pdf,
                'texto' => $texto_pdf,
                'tipo' => $tipo,
                'ano' => $ano,
                'id_post' => $id_post
            ),
            array('%s', '%s', '%s', '%s', '%d', '%d')
        );

        if ($resultado) {
            error_log("Novoicode PDF Index: Sucesso - $arquivo (ID: {$wpdb->insert_id})");
            return true;
        } else {
            error_log("Novoicode PDF Index: Erro no banco - $arquivo - " . $wpdb->last_error);
            return false;
        }

    } catch (Exception $e) {
        error_log("Novoicode PDF Index: Exception - $arquivo - " . $e->getMessage());
        return false;
    }
}


// Função para extrair texto do PDF
function novoicode_extrair_texto_pdf($caminho_arquivo) {
    // Verifica se a biblioteca Smalot PDF Parser está disponível
    if (class_exists('Smalot\PdfParser\Parser')) {
        try {
            $parser = new Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($caminho_arquivo);
            $texto = $pdf->getText();
            
            // Limpa o texto - remove múltiplos espaços e quebras de linha excessivas
            $texto = preg_replace('/\s+/', ' ', $texto);
            $texto = trim($texto);
            
            return $texto;
        } catch (Exception $e) {
            error_log("❌ Erro ao extrair texto PDF com Smalot: " . $e->getMessage());
        }
    }
    
    // Fallback: tentar comando shell pdftotext se disponível
    if (function_exists('shell_exec') && is_executable('/usr/bin/pdftotext')) {
        try {
            $arquivo_temp = tempnam(sys_get_temp_dir(), 'pdf_text');
            $comando = "/usr/bin/pdftotext -layout \"{$caminho_arquivo}\" \"{$arquivo_temp}\" 2>/dev/null";
            shell_exec($comando);
            
            if (file_exists($arquivo_temp)) {
                $texto = file_get_contents($arquivo_temp);
                unlink($arquivo_temp);
                
                if (!empty($texto)) {
                    $texto = preg_replace('/\s+/', ' ', $texto);
                    $texto = trim($texto);
                    return $texto;
                }
            }
        } catch (Exception $e) {
            error_log("❌ Erro ao extrair texto PDF com pdftotext: " . $e->getMessage());
        }
    }
    
    // Último fallback: tentar com TCPDF se disponível
    if (class_exists('TCPDF')) {
        try {
            // Implementação com TCPDF aqui
            error_log("⚠️ TCPDF disponível mas não implementado para extração");
        } catch (Exception $e) {
            error_log("❌ Erro ao extrair texto PDF com TCPDF: " . $e->getMessage());
        }
    }
    
    error_log("⚠️ Não foi possível extrair texto do PDF: {$caminho_arquivo}");
    return ''; // Retorna vazio se não conseguir extrair
}


// Cron
add_action('init', function() {
    if (defined('DOING_CRON') && DOING_CRON) {
        error_log('🕒 WP-Cron executado via servidor: ' . date('Y-m-d H:i:s'));
    }
});



// ************************************************************** FIM ******************************************
function adicionar_linha_espaco($user)
{
    ?>
    <br><br>
    <?php
}
add_action('show_user_profile', 'adicionar_linha_espaco');
add_action('edit_user_profile', 'adicionar_linha_espaco');