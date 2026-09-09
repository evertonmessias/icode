<?php

// OBS.: ANTES DESSE SCRIPT, RODAR O COMANDO: 
// ALTER TABLE wp_pdf_index ADD COLUMN documento varchar(20) NOT NULL DEFAULT '' AFTER id_post;

/*

if (!defined('ABSPATH')) {
    require_once(__DIR__ . '/../../../wp-load.php');
}

global $wpdb;

echo "<h2>Atualizando coluna 'documento'...</h2>";
echo "<pre>";

$tabela = $wpdb->prefix . 'pdf_index';

// Buscar todos registros
$registros = $wpdb->get_results("SELECT id, url FROM $tabela");

$total = count($registros);
$atualizados = 0;

foreach ($registros as $registro) {

    $id  = $registro->id;
    $url = $registro->url;

    if (empty($url)) {
        continue;
    }

    // Remove possível barra inicial
    $url_limpa = ltrim($url, '/');

    // Divide por /
    $partes = explode('/', $url_limpa);

    // Precisamos da posição 5 (índice 5) após remover a barra inicial
    // porque agora o array começa em:
    // [0] wp-content
    // [1] uploads
    // [2] cdi
    // [3] 2025
    // [4] 1189
    // [5] deliberacoes  ← queremos este

    if (isset($partes[5])) {

        $documento = sanitize_text_field($partes[5]);

        // Atualiza banco
        $wpdb->update(
            $tabela,
            ['documento' => $documento],
            ['id' => $id],
            ['%s'],
            ['%d']
        );

        echo "ID {$id} → {$documento}\n";
        $atualizados++;
    }
}

echo "\n-------------------------\n";
echo "Total registros: {$total}\n";
echo "Atualizados: {$atualizados}\n";
echo "Finalizado.\n";
echo "</pre>";
*/