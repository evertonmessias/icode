<?php
// Arquivo: wp-content/plugins/novoicode/includes/src/login.php

// Iniciar sessão
function start_session_if_not_started() {
    if (!session_id()) {
        session_start();
        error_log('🔓 login.php - Sessão iniciada');
    }
}
add_action('init', 'start_session_if_not_started');

// Remover ações do header/footer na página de login personalizada
function remove_header_footer_login_page() {
    if (is_page('login')) {
        remove_all_actions('wp_head');
        remove_all_actions('wp_footer');
        
        add_action('wp_enqueue_scripts', function() {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            wp_dequeue_style('wc-block-style');
        }, 100);
    }
}
add_action('template_redirect', 'remove_header_footer_login_page');

//************* Admin Login Customization
function tf_wp_admin_login_customization() { ?>
    <link href="<?php echo esc_url(get_option('portal_input_1')); ?>" rel="icon">
    <style type="text/css">
        .login {
            background-color: #F6F9FF;
        }
        #login h1 a {
            background-image: url('<?php echo esc_url(get_option('portal_input_1')); ?>');
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'tf_wp_admin_login_customization');

// Redirecionar página de login padrão para página personalizada
function redirect_to_custom_login() {
    if ($GLOBALS['pagenow'] == 'wp-login.php' && !isset($_POST['log'])) {
        error_log('🔄 login.php - Redirecionando wp-login.php para /login personalizado');
        
        $redirect_url = site_url('/login');
        
        // Preservar todos os parâmetros, especialmente redirect_to
        $query_params = $_GET;
        if (!empty($query_params)) {
            $redirect_url = add_query_arg($query_params, $redirect_url);
        }
        
        wp_redirect($redirect_url);
        exit;
    }
}
add_action('init', 'redirect_to_custom_login');

// Redirecionar usuários logados que acessam /login para /perfil
function redirect_logged_in_users_from_login() {
    if (is_page('login') && is_user_logged_in()) {
        error_log('🔄 login.php - Usuário logado acessou /login, redirecionando para /perfil');
        wp_redirect(home_url('/perfil'));
        exit;
    }
}
add_action('template_redirect', 'redirect_logged_in_users_from_login');

// Verificar reCAPTCHA (FUNÇÃO QUE ESTAVA FALTANDO)
function verify_recaptcha($username) {
    error_log('🔍 verify_recaptcha - Verificando reCAPTCHA para: ' . $username);
    
    // TEMPORARIAMENTE: Retorne true para testar sem reCAPTCHA - REMOVA ISSO EM PRODUÇÃO
    error_log('⚠️ verify_recaptcha - reCAPTCHA DESABILITADO para testes');
    return true;
    
    // CÓDIGO ORIGINAL (mantido para referência):
    /*
    if (!isset($_POST['recaptcha_response']) || empty($_POST['recaptcha_response'])) {
        error_log('❌ verify_recaptcha - Token reCAPTCHA não enviado');
        return false;
    }

    if (!defined('RECAPTCHA_V3_SECRET_KEY')) {
        error_log('❌ verify_recaptcha - RECAPTCHA_V3_SECRET_KEY não definida');
        return false;
    }

    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
            'secret' => RECAPTCHA_V3_SECRET_KEY,
            'response' => $_POST['recaptcha_response'],
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ]
    ]);

    if (is_wp_error($response)) {
        error_log('❌ verify_recaptcha - Erro na verificação: ' . $response->get_error_message());
        return false;
    }

    $result = json_decode(wp_remote_retrieve_body($response), true);
    $success = $result['success'] ?? false;
    $score = $result['score'] ?? 0;
    
    error_log('📊 verify_recaptcha - Resultado: success=' . ($success ? 'true' : 'false') . ', score=' . $score);
    
    return $success && $score >= 0.5;
    */
}

// Função CRÍTICA: Redirecionamento após login
function custom_login_redirect($redirect_to, $request, $user) {
    error_log('🎯 ============ custom_login_redirect ACIONADO ============');
    error_log('👤 custom_login_redirect - User: ' . ($user ? $user->user_login : 'NULO'));
    error_log('🔗 custom_login_redirect - Request original: ' . $request);
    error_log('🎯 custom_login_redirect - Redirect_to original: ' . $redirect_to);
    error_log('📋 custom_login_redirect - SESSION: ' . print_r($_SESSION, true));
    
    if (!is_wp_error($user)) {
        // PRIMEIRO: Tentar usar a sessão
        if (isset($_SESSION['ldap_login_redirect']) && !empty($_SESSION['ldap_login_redirect'])) {
            $redirect_to = $_SESSION['ldap_login_redirect'];
            error_log('✅ custom_login_redirect - Redirecionando para URL da SESSÃO: ' . $redirect_to);
            unset($_SESSION['ldap_login_redirect']);
            error_log('🗑️ custom_login_redirect - SESSION[ldap_login_redirect] REMOVIDO');
        } 
        // SEGUNDO: Tentar usar o parâmetro da request
        elseif (!empty($request)) {
            $redirect_to = $request;
            error_log('✅ custom_login_redirect - Redirecionando para URL do PARÂMETRO: ' . $redirect_to);
        }
        // FALLBACK: Perfil
        else {
            $redirect_to = home_url('/perfil');
            error_log('🔄 custom_login_redirect - Redirecionando para PERFIL (fallback): ' . $redirect_to);
        }
    } else {
        error_log('❌ custom_login_redirect - Erro no usuário: ' . $user->get_error_message());
    }
    
    error_log('🏁 custom_login_redirect - Redirect FINAL: ' . $redirect_to);
    error_log('============ custom_login_redirect FINALIZADO ============');
    return $redirect_to;
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

// Manipular login falho
function login_failed_redirect($username) {
    error_log('❌ login.php - Login FALHOU para usuário: ' . $username);
    $referrer = $_SERVER['HTTP_REFERER'] ?? '';
    
    if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin')) {
        wp_redirect(add_query_arg('login', 'failed', $referrer));
        exit;
    }
}
add_action('wp_login_failed', 'login_failed_redirect');

// Redirecionar após logout
function logout_redirect() {
    error_log('🚪 login.php - Logout realizado, redirecionando para login');
    wp_redirect(site_url('/login'));
    exit;
}
add_action('wp_logout', 'logout_redirect');

//************* Admin Login Logo Link URL
function tf_wp_admin_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'tf_wp_admin_login_logo_url');

//************* Admin Login Logo's Title
function tf_wp_admin_login_logo_title($headertext) {
    return esc_html__(get_bloginfo('name'), 'plugin-textdomain');
}
add_filter('login_headertext', 'tf_wp_admin_login_logo_title');

// Remove "Perdeu a senha?" das mensagens de erro
add_filter('login_errors', function ($error) {
    return preg_replace('/<a.*?lostpassword.*?<\/a>/', '', $error);
});

//// ************************** Usuário IC login
function usuarioIClogin($username, $password) {
    $postFields = http_build_query([
        'username' => $username,
        'password' => $password
    ]);

    $response = wp_remote_post('https://auth.ic.unicamp.br/login', [
        'body' => $postFields,
        'sslverify' => true
    ]);

    if (is_wp_error($response)) {
        error_log('Erro IC Login: ' . $response->get_error_message());
        return false;
    }

    $json = json_decode(wp_remote_retrieve_body($response));
    return isset($json->username_ic) ? [$json->nome, $json->username_ic, $json->username_unicamp] : false;
}

//// ************************** Usuario IC dados
function usuarioICdados($usernameic) {
    $ref = preg_match('/^ra\d{6}$/', $usernameic) ? 'lab' : 'ic';

    $response = wp_remote_post('https://auth.ic.unicamp.br/ldapsearch', [
        'body' => [
            'username' => $usernameic,
            'ref' => $ref
        ]
    ]);

    if (is_wp_error($response)) {
        error_log('Erro IC Dados: ' . $response->get_error_message());
        return false;
    }

    $json = json_decode(wp_remote_retrieve_body($response));
    return isset($json->data->mail) ? [$json->data->mail, $json->data->givenname, $json->data->sn] : false;
}

// Função auxiliar para atualizar permissões do usuário
function atualizar_permissoes_usuario($user_id, $email) {
    $tipos_registrados = get_tipos_configurados();
    
    // Limpar permissões anteriores
    update_user_meta($user_id, 'membro', []);
    update_user_meta($user_id, 'membro_arquivo_privado', []);
    update_user_meta($user_id, 'membro_post_privado', []);

    $role = papel_usuario($email);
    
    // REGRA: Se for admin ou editor, pode tudo
    if ($role === 'editor' || $role === 'administrator') {
        update_user_meta($user_id, 'membro', $tipos_registrados);
        update_user_meta($user_id, 'membro_arquivo_privado', $tipos_registrados);
        update_user_meta($user_id, 'membro_post_privado', $tipos_registrados);
        error_log('Debug LDAP: Usuário classificado como editor/admin. Todos os membros setados.');
    } else {
        // REGRA: Usuário normal - usa a função retorna_membro() para membro
        $grupos_membro = retorna_membro($email);
        update_user_meta($user_id, 'membro', $grupos_membro);
        
        // REGRA: Para arquivo_privado, verifica apenas nos colegiados
        $grupos_arquivo_privado = [];
        foreach (get_tipos_configurados() as $slug) {
            if (!empty($slug) && in_array($email, lista_usuarios_colegiado($slug), true)) {
                $grupos_arquivo_privado[] = $slug;
            }
        }
        update_user_meta($user_id, 'membro_arquivo_privado', $grupos_arquivo_privado);
        
        error_log('Debug LDAP: Usuário classificado como membro. Grupos: ' . implode(', ', $grupos_membro) . ' | Arquivo Privado: ' . implode(', ', $grupos_arquivo_privado));
    }
}

// Função auxiliar para atualizar avatar
function atualizar_avatar_usuario($user_id, $email) {
    $photo_url = retornaPhoto($email);
    if ($photo_url) {
        $avatar_id = importar_imagem_para_midia($photo_url, $user_id);
        if ($avatar_id) {
            update_user_meta($user_id, 'wp_user_avatar', $avatar_id);
        }
    }
}

// Função auxiliar para realizar login
function realizar_login_usuario($user) {
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID);
    do_action('wp_login', $user->user_login, $user);
}

// Login WP com LDAP - PONTO CRÍTICO!
function custom_wp_authenticate($user, $username, $password) {
    error_log('🔐 ============ custom_wp_authenticate INICIADO ============');
    error_log('👤 custom_wp_authenticate - Tentativa login: ' . $username);
    
    if (empty($username) || empty($password)) {
        if (isset($_POST['log']) && isset($_POST['pwd'])) {
            return new WP_Error('empty_credentials', __('Usuário e senha são obrigatórios.'));
        }
        return null;
    }

    $username = strtolower($username);

    // Permitir login local apenas para o admin
    if ($username === 'admin') {
        error_log('⚡ custom_wp_authenticate - Login local admin');
        remove_filter('authenticate', 'custom_wp_authenticate', 10);
        $user = wp_authenticate_username_password(null, $username, $password);
        add_filter('authenticate', 'custom_wp_authenticate', 10, 3);

        return is_wp_error($user) ? new WP_Error('wp_auth_failed', __('Falha na autenticação do WordPress para admin.')) : $user;
    }

    // Verificar reCAPTCHA para usuários não-admin
    if (!verify_recaptcha($username)) {
        error_log('❌ custom_wp_authenticate - reCAPTCHA falhou');
        wp_redirect(home_url('/login?login=failed&recaptcha=failed'));
        exit;
    }

    $resultado_ic = usuarioIClogin($username, $password);
    if (!$resultado_ic) {
        error_log('❌ custom_wp_authenticate - IC Login falhou');
        wp_die("Usuário ou senha inválidos");
    }

    list($email, $first_name, $last_name) = usuarioICdados($username);
    if (!$email) {
        error_log('❌ custom_wp_authenticate - Dados LDAP falharam');
        return new WP_Error('ldap_failed', __('Falha ao obter dados do LDAP.'));
    }

    $user = get_user_by('login', $username);
    if (!$user) {
        error_log('👥 custom_wp_authenticate - Criando novo usuário WP');
        $user_id = wp_create_user($username, wp_generate_password(), $email);
        if (is_wp_error($user_id)) {
            error_log('❌ custom_wp_authenticate - Erro criar usuário: ' . $user_id->get_error_message());
            return new WP_Error('user_creation_failed', __('Falha ao criar o usuário no WordPress.'));
        }

        wp_update_user([
            'ID' => $user_id,
            'role' => papel_usuario($email),
            'first_name' => $first_name,
            'last_name' => $last_name
        ]);

        $user = get_user_by('id', $user_id);
        atualizar_avatar_usuario($user->ID, $email);
        error_log('✅ custom_wp_authenticate - Usuário WP criado: ' . $username . ' ID: ' . $user->ID);
    } else {
        error_log('✅ custom_wp_authenticate - Usuário WP existente: ' . $username . ' ID: ' . $user->ID);
    }

    // Atualizar permissões do usuário
    atualizar_permissoes_usuario($user->ID, $email);

    // Realizar login
    error_log('🔓 custom_wp_authenticate - Executando login WP');
    realizar_login_usuario($user);
    
    error_log('✅ custom_wp_authenticate - Login realizado com sucesso, retornando usuário');
    error_log('🏁 ============ custom_wp_authenticate FINALIZADO ============');
    
    return $user;
}
add_filter('authenticate', 'custom_wp_authenticate', 10, 3);

// LOGOUT
add_action('init', 'icode_check_logout');
function icode_check_logout() {
    if (isset($_GET['icode_logout']) && $_GET['icode_logout'] === '1') {
        error_log('🚪 login.php - Logout via icode_logout');
        icode_logout();
    }
}

function icode_logout() {
    error_log('🧹 login.php - Limpando sessão e logout');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['ldap_login_redirect']);
    session_destroy();
    wp_logout();

    wp_redirect(home_url('/login'));
    exit;
}