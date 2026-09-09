<?php
/**
 * Arquivo: wp-content/themes/novoicode/page-googlelogin.php
 * 
 * Template Name: Google Login
 * 
 * Processa a autenticação via Google OAuth 2.0
 */

// Iniciar sessão se necessário
if (!session_id()) {
    session_start();
}

// DEBUG: Log do estado inicial
error_log('🔐 ============ GOOGLE LOGIN INICIADO ============');
error_log('📋 Google Login - SESSION: ' . print_r($_SESSION, true));
error_log('📋 Google Login - GET: ' . print_r($_GET, true));

// Se não tem código, redireciona para auth do Google
if (!isset($_GET['code'])) {
    error_log('🔄 Google Login - Iniciando OAuth, redirecionando para Google');
    
    $redirect_params = [
        'client_id' => GOOGLE_CLIENT_ID,
        'redirect_uri' => home_url('/googlelogin'),
        'response_type' => 'code',
        'scope' => 'email profile',
        'access_type' => 'online',
        'prompt' => 'select_account'
    ];
    
    $auth_url = GOOGLE_AUTH_URL . http_build_query($redirect_params);
    wp_redirect($auth_url);
    exit;
}

// Processar o retorno com o código de autorização
try {
    error_log('🔄 Google Login - Processando código de autorização');

    // Trocar código por token de acesso
    $token_params = [
        'code' => $_GET['code'],
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => home_url('/googlelogin'),
        'grant_type' => 'authorization_code'
    ];

    $response = wp_remote_post(GOOGLE_TOKEN_URL, [
        'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ],
        'body' => http_build_query($token_params),
        'timeout' => 30
    ]);

    if (is_wp_error($response)) {
        error_log('❌ Google Login - Erro na requisição do token: ' . $response->get_error_message());
        throw new Exception('Falha na comunicação com Google: ' . $response->get_error_message());
    }

    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);
    
    error_log('📨 Google Login - Resposta Token - Código: ' . $response_code);

    if ($response_code !== 200) {
        throw new Exception('Erro HTTP ' . $response_code . ' ao obter token: ' . $response_body);
    }

    $token_data = json_decode($response_body, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Resposta JSON inválida do Google: ' . $response_body);
    }

    if (!isset($token_data['access_token'])) {
        error_log('❌ Google Login - Token de acesso não recebido');
        throw new Exception('Token de acesso não recebido do Google.');
    }

    error_log('✅ Google Login - Token de acesso recebido com sucesso');

    // Obter informações do usuário
    $userinfo_response = wp_remote_get(GOOGLE_USERINFO_URL, [
        'headers' => [
            'Authorization' => 'Bearer ' . $token_data['access_token'],
            'Content-Type' => 'application/json'
        ],
        'timeout' => 30
    ]);

    if (is_wp_error($userinfo_response)) {
        throw new Exception('Falha ao obter informações do usuário: ' . $userinfo_response->get_error_message());
    }

    $userinfo_body = wp_remote_retrieve_body($userinfo_response);
    $userinfo = json_decode($userinfo_body, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Resposta JSON inválida do userinfo: ' . $userinfo_body);
    }

    if (!isset($userinfo['email'])) {
        throw new Exception('E-mail não disponível no perfil do Google');
    }

    $email = strtolower($userinfo['email']);
    error_log('✅ Google Login - Autenticação bem-sucedida para: ' . $email);

    // Verificar domínio permitido
    $dominio = substr(strrchr($email, "@"), 1);
    $emails_excecao = get_option('portal_input_3', []);

    if ($dominio !== 'unicamp.br' && $dominio !== 'dac.unicamp.br' && !in_array($email, (array) $emails_excecao)) {
        wp_die('Acesso negado.<br>Somente e-mails @unicamp.br, @dac.unicamp.br ou convidados podem acessar o sistema.');
    }

    // Processar autenticação no WordPress    
    $username = preg_replace('/@.*/', '', $email); // Remove domínio do email para username
    $first_name = $userinfo['given_name'] ?? '';
    $last_name = $userinfo['family_name'] ?? '';

    // Permitir login local apenas para o admin (similar ao LDAP)
    if ($username === 'admin') {
        wp_die('Login de admin não permitido via Google');
    }

    $user = get_user_by('email', $email);

    if (!$user) {
        // Criar novo usuário
        error_log('👤 Google Login - Criando novo usuário: ' . $username);
        
        $user_id = wp_create_user($username, wp_generate_password(), $email);

        if (is_wp_error($user_id)) {
            throw new Exception('Falha ao criar usuário: ' . $user_id->get_error_message());
        }

        // Atualizar informações do usuário
        wp_update_user([
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => papel_usuario($email) // Reutilizando sua função existente
        ]);

        $user = get_user_by('id', $user_id);

        // Se houver imagem no perfil do Google, importa como avatar
        if (!empty($userinfo['picture'])) {
            $avatar_id = importar_imagem_para_midia($userinfo['picture'], $user->ID);
            if ($avatar_id) {
                update_user_meta($user->ID, 'wp_user_avatar', $avatar_id);
            }
        }
        
        error_log('✅ Google Login - Usuário criado: ' . $username . ' ID: ' . $user->ID);
    } else {
        error_log('✅ Google Login - Usuário existente: ' . $username . ' ID: ' . $user->ID);
    }

    // Atualizar permissões do usuário (usando a mesma função do login.php)
    atualizar_permissoes_usuario($user->ID, $email);

    // Autenticar o usuário
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID);
    do_action('wp_login', $user->user_login, $user);

    error_log('🔓 Google Login - Usuário autenticado: ' . $username);

    // ✅✅✅ CORREÇÃO CRÍTICA: Lógica de redirecionamento igual ao login LDAP ✅✅✅
    $redirect_to = home_url('/perfil'); // Fallback padrão
    
    // PRIMEIRO: Verificar se há URL de redirecionamento na SESSÃO
    if (isset($_SESSION['ldap_login_redirect']) && !empty($_SESSION['ldap_login_redirect'])) {
        $redirect_to = $_SESSION['ldap_login_redirect'];
        error_log('🎯 Google Login - Redirecionando para URL da SESSÃO: ' . $redirect_to);
        unset($_SESSION['ldap_login_redirect']);
        error_log('🗑️ Google Login - SESSION[ldap_login_redirect] REMOVIDO');
    } 
    // SEGUNDO: Verificar se há parâmetro redirect_to na URL
    elseif (isset($_GET['redirect_to']) && !empty($_GET['redirect_to'])) {
        $redirect_to = $_GET['redirect_to'];
        error_log('🎯 Google Login - Redirecionando para URL do PARÂMETRO: ' . $redirect_to);
    }
    // FALLBACK: Perfil
    else {
        error_log('🔄 Google Login - Redirecionando para PERFIL (fallback): ' . $redirect_to);
    }

    error_log('🏁 Google Login - Redirecionamento FINAL: ' . $redirect_to);

    wp_redirect($redirect_to);
    exit;

} catch (Exception $e) {
    error_log('❌ ERRO NO LOGIN GOOGLE: ' . $e->getMessage());
    wp_die('Erro no login via Google: ' . $e->get_message() . '<br><a href="' . home_url('/login') . '">Voltar para o login</a>');
}