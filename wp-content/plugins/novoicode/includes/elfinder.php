<?php
// Arquivo: wp-content/plugins/novoicode/includes/elfinder.php

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if (!is_user_logged_in()) {
    http_response_code(403);
    exit('Acesso negado');
}

require_once ABSPATH . 'wp-content/plugins/novoicode/includes/elFinder/php/autoload.php';

use elFinder;
use elFinderConnector;
use elFinderVolumeLocalFileSystem;

$current_user = wp_get_current_user();
$user_roles = $current_user->roles;

$is_admin = in_array('administrator', $user_roles);
$is_editor = in_array('editor', $user_roles);
$is_subscriber = in_array('subscriber', $user_roles);

$post_id_raw = $_GET['post_id'] ?? '';
$ano = $_GET['ano'] ?? '';
$tipo = sanitize_text_field($_GET['tipo'] ?? '');

// DEBUG: Log dos parâmetros recebidos
error_log("elFinder Params - tipo: $tipo, ano: $ano, post_id: $post_id_raw");

$modo_geral = empty($tipo) && empty($ano) && empty($post_id_raw);

// CORREÇÃO: Admin e editor têm acesso a todos os tipos
if ($is_admin || $is_editor) {
    $tipos_permitidos = get_tipos_configurados(); // Todos os tipos configurados
    $user_membro_arquivo_privado = get_tipos_configurados(); // Acesso total a arquivos privados
} else {
    $tipos_permitidos = get_user_meta($current_user->ID, 'membro', true);
    if (!is_array($tipos_permitidos)) {
        $tipos_permitidos = [];
    }
    
    $membro_arquivo_privado = get_user_meta($current_user->ID, 'membro_arquivo_privado', true);
    $user_membro_arquivo_privado = is_array($membro_arquivo_privado) ? $membro_arquivo_privado : [];
}

$wp_upload_dir = wp_upload_dir();
$roots = [];

// MODO GERAL - Exibe diretórios dos tipos
if ($modo_geral) {
    error_log("elFinder: Modo Geral Ativado");
    
    foreach ($tipos_permitidos as $tipo_dir) {
        $tipo_path = trailingslashit($wp_upload_dir['basedir']) . $tipo_dir . '/';
        $tipo_url = trailingslashit($wp_upload_dir['baseurl']) . $tipo_dir . '/';

        if (!is_dir($tipo_path)) {
            error_log("elFinder: Diretório não encontrado - $tipo_path");
            continue;
        }

        $roots[] = [
            'driver' => 'LocalFileSystem',
            'path' => $tipo_path,
            'URL' => $tipo_url,
            'uploadDeny' => ['all'],
            'uploadAllow' => ['application/pdf'],
            'uploadOrder' => ['deny', 'allow'],
            'accessControl' => function ($attr, $path, $data, $volume) use ($modo_geral, $is_admin, $is_editor, $is_subscriber) {
                if (strpos(basename($path), '.') === 0) {
                    return !($attr === 'read' || $attr === 'write');
                }

                // Verifica se é uma pasta "privado"
                if (strpos($path, '/privado') !== false) {
                    // CORREÇÃO: Admin e editor têm acesso total a privado
                    if ($is_admin || $is_editor) {
                        return null; // Acesso total
                    }
                    
                    $membro_arquivo_privado = get_user_meta(wp_get_current_user()->ID, 'membro_arquivo_privado', true);
                    // Bloqueia acesso total se não tiver permissão
                    if (!$membro_arquivo_privado) {
                        return false;
                    }
                }

                if ($modo_geral) {
                    if ($is_admin) {
                        return null;
                    }
                    if ($is_subscriber || $is_editor) {
                        return $attr === 'read'; // somente leitura
                    }
                }

                return null;
            },
            'attributes' => [
                [
                    'pattern' => '/\.php$/i',
                    'read' => false,
                    'write' => false,
                    'hidden' => true,
                    'locked' => true,
                ]
            ],
        ];
    }
} else {
    // MODO DIRECIONADO
    error_log("elFinder: Modo Direcionado - tipo: $tipo, ano: $ano, post_id: $post_id_raw");
    
    // VALIDAÇÃO CORRIGIDA: Mais flexível
    if (empty($tipo) || empty($ano) || empty($post_id_raw)) {
        error_log("elFinder: Parâmetros insuficientes para modo direcionado");
        http_response_code(400);
        exit('Parâmetros insuficientes');
    }
    
    // CORREÇÃO: Admin e editor não passam por validação de tipo
    if (!$is_admin && !$is_editor) {
        // Verifica se o usuário normal tem acesso ao tipo
        if (!in_array($tipo, $tipos_permitidos)) {
            error_log("elFinder: Usuário não tem acesso ao tipo $tipo. Tipos permitidos: " . implode(',', $tipos_permitidos));
            http_response_code(403);
            exit('Acesso negado para este tipo');
        }
    }

    // TRATAMENTO CORRIGIDO do post_id
    $post_id_str = ($post_id_raw === 'outros') ? 'outros' : $post_id_raw;
    
    // Valida se é numérico ou 'outros'
    if ($post_id_str !== 'outros' && !is_numeric($post_id_str)) {
        error_log("elFinder: post_id inválido - $post_id_raw");
        http_response_code(400);
        exit('Parâmetro post_id inválido');
    }

    $basePath = trailingslashit($wp_upload_dir['basedir']) . "$tipo/$ano/$post_id_str/";
    $baseURL = trailingslashit($wp_upload_dir['baseurl']) . "$tipo/$ano/$post_id_str/";

    error_log("elFinder: Base Path - $basePath");

    if (!is_dir($basePath)) {
        error_log("elFinder: Criando diretório - $basePath");
        $created = wp_mkdir_p($basePath);
        if (!$created || !is_dir($basePath)) {
            error_log("elFinder: Falha ao criar diretório - $basePath");
            http_response_code(500);
            exit("Falha ao criar diretório base: $basePath");
        }
    }

    // Cria subdiretórios padrão se não existirem
    $subdirs_padrao = ['ata', 'deliberacoes', 'pautas', 'privado'];
    foreach ($subdirs_padrao as $subdir) {
        $subdir_path = $basePath . $subdir . '/';
        if (!is_dir($subdir_path)) {
            wp_mkdir_p($subdir_path);
        }
    }

    $subdirs = array_filter(glob($basePath . '*'), 'is_dir');
    error_log("elFinder: Subdiretórios encontrados - " . implode(', ', $subdirs));

    foreach ($subdirs as $subdir) {
        $nomePasta = basename($subdir);

        // CORREÇÃO: Admin e editor têm acesso a todas as pastas privado
        if ($nomePasta === 'privado') {
            if (!$is_admin && !$is_editor) {
                // Usuário normal: verifica permissão
                if (!in_array($tipo, $user_membro_arquivo_privado)) {
                    error_log("elFinder: Usuário não tem acesso à pasta privado do tipo $tipo");
                    continue;
                }
            }
            // Admin e editor: sempre têm acesso
        }

        $path = trailingslashit($subdir);
        $url = trailingslashit($baseURL . $nomePasta);

        error_log("elFinder: Adicionando root - $path");

        $roots[] = [
            'driver' => 'LocalFileSystem',
            'alias' => $nomePasta, // Nome amigável para exibição
            'path' => $path,
            'URL' => $url,
            'uploadDeny' => ['all'],
            'uploadAllow' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            'uploadOrder' => ['deny', 'allow'],
            'accessControl' => function ($attr, $path, $data, $volume) use ($is_admin, $is_editor) {
                if (strpos(basename($path), '.') === 0) {
                    return !($attr === 'read' || $attr === 'write');
                }

                // Fora do modo geral: editor/admin pode editar, outros só leitura
                if (!$is_admin && !$is_editor) {
                    return $attr === 'read';
                }

                return null;
            },
            'attributes' => [
                [
                    'pattern' => '/\.php$/i',
                    'read' => false,
                    'write' => false,
                    'hidden' => true,
                    'locked' => true,
                ]
            ],
        ];
    }
}

// ===================== PERMISSÕES DE COMANDOS =====================
$disabledCommands = [];

if ($modo_geral) {
    if ($is_admin) {
        $disabledCommands = []; // Total acesso
    } elseif ($is_editor) {
        $disabledCommands = ['mkdir']; 
    } else {
        // assinante (ou outro papel): somente leitura
        $disabledCommands = ['mkdir', 'mkfile', 'paste', 'rm', 'rename', 'upload', 'copy', 'cut'];
    }
} else {
    // fora do modo geral: apenas assinante tem bloqueios
    if (!$is_admin && !$is_editor) {
        $disabledCommands = ['mkdir', 'mkfile', 'paste', 'rm', 'rename', 'upload', 'copy', 'cut'];
    }
}

error_log("elFinder: Comandos desabilitados - " . implode(', ', $disabledCommands));
error_log("elFinder: Número de roots - " . count($roots));

// ===================== INICIALIZA =====================
if (empty($roots)) {
    error_log("elFinder: Nenhum root configurado - retornando 404");
    http_response_code(404);
    exit('Nenhum diretório disponível para acesso');
}

$opts = [
    'roots' => $roots,
    'disabled' => $disabledCommands,
    'debug' => true, // Ativa debug do elFinder
];

try {
    $connector = new elFinderConnector(new elFinder($opts));
    $connector->run();
} catch (Exception $e) {
    error_log("elFinder Exception: " . $e->getMessage());
    http_response_code(500);
    exit('Erro interno do servidor');
}