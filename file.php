<?php
// Arquivo: /file.php

require_once(dirname(__FILE__) . '/wp-load.php');

// Iniciar sessão se necessário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações iniciais
$upload_dir = wp_upload_dir();
$base_upload_path = $upload_dir['basedir'];
$file_path = isset($_GET['file']) ? $_GET['file'] : '';
$url_completa = home_url("/wp-content/uploads/" . $file_path);

error_log('🚀 file.php - Usuário NÃO logado, redirecionando para: ' . $url_completa);

// Verificar se o usuário está logado
if (!is_user_logged_in()) {
    $_SESSION['ldap_login_redirect'] = $url_completa;
    error_log('💾 file.php - SESSION[ldap_login_redirect] = ' . $url_completa);
    
    wp_redirect(wp_login_url($url_completa));
    exit;
} else {
    // Usuário já está logado - servir arquivo
    if (!permite_url($url_completa, wp_get_current_user()->ID)) {
        wp_die('Acesso somente para Membros.');
    } else {
        registerdb(wp_get_current_user()->user_login, $_SERVER['REMOTE_ADDR'], "/wp-content/uploads/" . $file_path);
        
        $full_path = realpath($base_upload_path . '/' . urldecode($file_path));
        if (file_exists($full_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($full_path) . '"');
            readfile($full_path);
            exit;
        } else {
            status_header(404);
            wp_die('Arquivo não encontrado.');
        }
    }
}