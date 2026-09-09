<?php
// Arquivo: wp-content/plugins/novoicode/includes/src/pdf.php
//Search PDF *************************************************************************************
add_filter('pre_get_posts', function ($query) {
    if ($query->is_search() && $query->is_main_query()) {
        $termo = $query->get('s');

        global $wpdb;
        $tabela = $wpdb->prefix . 'pdf_index';

        $resultados = $wpdb->get_results($wpdb->prepare("
            SELECT arquivo FROM $tabela WHERE texto LIKE %s
        ", '%' . $wpdb->esc_like($termo) . '%'));

        if ($resultados) {
            add_filter('the_content', function ($content) use ($resultados, $termo) {
                $lista = "<h3>Resultados nos PDFs:</h3><ul>";
                foreach ($resultados as $r) {
                    $lista .= "<li><a href='/wp-content/uploads/pdfs/{$r->arquivo}' target='_blank'>{$r->arquivo}</a></li>";
                }
                $lista .= "</ul>";
                return $lista . $content;
            });
        }
    }
    return $query;
});


// Converter PDF ****************************************************************************
function novoicode_converter_pdf()
{
    if (!isset($_POST['paths']) || !isset($_POST['destino'])) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Parâmetros ausentes.']);
    }

    $paths = json_decode(stripslashes($_POST['paths']), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $paths = is_array($_POST['paths']) ? $_POST['paths'] : (array) $_POST['paths'];
    }

    $paths = array_filter((array) $paths);
    $pdfsParaJuntar = [];

    foreach ($paths as $path) {
        $cleanPath = realpath(trim(stripslashes($path), '"\''));
        if ($cleanPath && file_exists($cleanPath)) {
            $ext = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
            if ($ext === 'doc' || $ext === 'docx') {
                $pdfsParaJuntar[] = '"' . $cleanPath . '"';
            }
        }
    }

    if (empty($pdfsParaJuntar)) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Nenhum DOC válido encontrado.']);
    }

    $destino = trim(stripslashes($_POST['destino']), '"\'');
    $destPath = dirname($destino);

    if (!file_exists($destPath)) {
        wp_mkdir_p($destPath);
    }

    if (!is_writable($destPath)) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Diretório de destino não tem permissão de escrita.']);
    }

    $strPDFsParaJuntar = implode(" ", $pdfsParaJuntar);


    // Comando para conversão
    exec("export HOME=/var/www && export XDG_CONFIG_HOME=/var/www/.config && export XDG_CACHE_HOME=/var/www/.cache && soffice --headless --convert-to pdf --outdir $destPath $strPDFsParaJuntar 2>&1", $output, $retorno);

    if ($retorno !== 0) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Erro ao executar script: ' . implode("\n", $output)]);
    }

    wp_send_json([
        'sucesso' => true,
        'arquivos' => count($pdfsParaJuntar)
    ]);
}
add_action('wp_ajax_novoicode_converter_pdf', 'novoicode_converter_pdf');




// Juntar PDF ****************************************************************************
function novoicode_exportar_pdf()
{
    if (!isset($_POST['paths']) || !isset($_POST['destino'])) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Parâmetros ausentes.']);
    }

    $paths = json_decode(stripslashes($_POST['paths']), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $paths = is_array($_POST['paths']) ? $_POST['paths'] : (array) $_POST['paths'];
    }

    $paths = array_filter((array) $paths);
    $pdfsParaJuntar = [];

    foreach ($paths as $path) {
        $cleanPath = realpath(trim(stripslashes($path), '"\''));
        if ($cleanPath && file_exists($cleanPath)) {
            $ext = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $pdfsParaJuntar[] = '"' . $cleanPath . '"';
            }
        }
    }

    if (empty($pdfsParaJuntar)) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Nenhum PDF válido encontrado.']);
    }

    $destino = trim(stripslashes($_POST['destino']), '"\'');
    $destPath = dirname($destino);

    if (!file_exists($destPath)) {
        wp_mkdir_p($destPath);
    }

    if (!is_writable($destPath)) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Diretório de destino não tem permissão de escrita.']);
    }

    $destFile = $destino;

    // Se o destino já existir, adiciona ele como o primeiro da fusão
    if (file_exists($destFile)) {
        $pdfsParaJuntar = array_merge(['"' . realpath($destFile) . '"'], $pdfsParaJuntar);
    }

    // Cria um arquivo temporário para saída
    $tempOutput = tempnam(sys_get_temp_dir(), 'pdfmerge_') . '.pdf';
    $destPath = escapeshellarg($tempOutput);

    // Comando Ghostscript para fusão
    $cmd = "gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=$destPath " . implode(' ', $pdfsParaJuntar);

    exec($cmd, $output, $retorno);

    if ($retorno !== 0 || !file_exists($tempOutput)) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Erro ao executar Ghostscript: ' . implode("\n", $output)]);
    }

    // Move o arquivo temporário para o destino, sobrescrevendo
    if (!rename($tempOutput, $destFile)) {
        wp_send_json(['sucesso' => false, 'mensagem' => 'Falha ao mover PDF gerado para o destino.']);
    }

    $relPath = str_replace(ABSPATH, '', $destFile);
    $urlFinal = site_url('/') . str_replace(DIRECTORY_SEPARATOR, '/', $relPath);

    wp_send_json([
        'sucesso' => true,
        'url' => $urlFinal,
        'caminho' => $destFile,
        'arquivos' => count($pdfsParaJuntar)
    ]);
}
add_action('wp_ajax_novoicode_exportar_pdf', 'novoicode_exportar_pdf');




// Indexar PDF ****************************************************************************
use Smalot\PdfParser\Parser;
function novoicode_indexar_pdf()
{

    if (!isset($_POST['arquivo'], $_POST['url'], $_POST['tipo'], $_POST['ano'], $_POST['id'])) {
        wp_send_json_error(['msg' => 'Parâmetros ausentes']);
    }

    // Set maximum execution time to prevent timeouts
    set_time_limit(300); // 5 minutos

    $parser = new Parser();
    $arquivo = sanitize_text_field($_POST['arquivo']);
    $url = esc_url_raw($_POST['url']);
    $tipo = sanitize_text_field($_POST['tipo']);
    $ano = sanitize_text_field($_POST['ano']);
    $id = intval($_POST['id']);

    $path = ABSPATH . "wp-content/uploads/$tipo/$ano/";

    $subdirs = [];

    foreach (scandir($path) as $item) {
        if ($item === '.' || $item === '..')
            continue;

        if (is_dir($path . $item)) {
            $subdirs[] = $item;
        }
    }

    global $wpdb;
    $tabela = $wpdb->prefix . 'pdf_index';

    $sql = $wpdb->prepare(
        "SELECT * FROM $tabela WHERE tipo = %s AND ano = %d",
        $tipo,
        $ano
    );

    $results = $wpdb->get_results($sql);

    $all_subdirs = [];

    foreach ($results as $item) {
        $all_subdirs[] = $item->id_post;
    }

    // Remove duplicatas
    $all_subdirs_unicos = array_unique($all_subdirs);

    // Descobre quais id_post estão no array2 mas não no array1
    $id_post_para_apagar = array_diff($all_subdirs_unicos, $subdirs);

    if (!empty($id_post_para_apagar)) { // Se houver itens para apagar
        // Prepara os placeholders para a cláusula IN
        $placeholders = implode(',', array_fill(0, count($id_post_para_apagar), '%d'));
        $sql = "DELETE FROM $tabela WHERE id_post IN ($placeholders)";
        $wpdb->query($wpdb->prepare($sql, ...$id_post_para_apagar));
    }

    // Busca todos os arquivos indexados
    $arquivos = $wpdb->get_results("SELECT arquivo FROM $tabela where id_post = $id");

    foreach ($arquivos as $item) {
        $caminhoArquivo = $item->arquivo;
        // Se o arquivo não existir mais, remove do banco
        if (!file_exists($caminhoArquivo)) {
            $wpdb->delete($tabela, ['arquivo' => $caminhoArquivo]);
        }
    }

    // Verifica se já foi indexado
    $jaIndexado = $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(*) FROM $tabela WHERE arquivo = %s", $arquivo)
    );

    if ($jaIndexado > 0) {
        // Verifica se o arquivo ainda existe
        if (!file_exists($arquivo)) {
            // Arquivo foi removido, deleta a indexação
            $wpdb->delete($tabela, ['arquivo' => $arquivo]);
            wp_send_json_success(['msg' => 'Indexação removida, arquivo não existe mais']);
        } else {
            wp_send_json_success(['msg' => 'Já existia']);
        }
    } else {
        // Arquivo não indexado ainda, tenta processar
        if (!file_exists($arquivo)) {
            wp_send_json_error(['msg' => 'Arquivo não encontrado']);
        }

        try {
            $pdf = $parser->parseFile($arquivo);
            $texto = $pdf->getText();
            $texto = substr($texto, 0, 100000); // Limita o tamanho do texto

            $wpdb->insert($tabela, [
                'arquivo' => $arquivo,
                'url' => $url,
                'texto' => $texto,
                'tipo' => $tipo,
                'ano' => $ano,
                'id_post' => $id
            ]);
            wp_send_json_success(['msg' => 'Indexado']);
        } catch (Exception $e) {
            wp_send_json_error(['msg' => 'Erro ao processar PDF: ' . $e->getMessage()]);
        }
    }
}
add_action('wp_ajax_novoicode_indexar_pdf', 'novoicode_indexar_pdf');




// Listar PDF ****************************************************************************
function novoicode_listar_pdfs()
{
    if (!isset($_POST['tipo'], $_POST['ano'])) {
        wp_send_json_error(['msg' => 'Parâmetros ausentes']);
    }

    $tipo = sanitize_text_field($_POST['tipo']);
    $ano = sanitize_text_field($_POST['ano']);
    $base_dir = ABSPATH . "wp-content/uploads/$tipo/$ano";

    if (!file_exists($base_dir)) {
        wp_send_json_error(['msg' => 'Diretório não encontrado']);
    }

    $arquivos = [];
    $urls = [];
    $ids = [];

    $subdirs = scandir($base_dir);
    foreach ($subdirs as $subdir) {
        if ($subdir === '.' || $subdir === '..')
            continue;

        $full_path = $base_dir . '/' . $subdir;
        if (!is_dir($full_path))
            continue;

        $id_post = is_numeric($subdir) ? intval($subdir) : 0;

        $directory = new RecursiveDirectoryIterator($full_path, RecursiveDirectoryIterator::SKIP_DOTS);
        $filter = new RecursiveCallbackFilterIterator($directory, function ($fileInfo) {
            return !($fileInfo->isDir() && $fileInfo->getFilename() === 'privado');
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
    }

    wp_send_json_success([
        'arquivos' => $arquivos,
        'urls' => $urls,
        'ids' => $ids,
        'total' => count($arquivos),
    ]);
}
add_action('wp_ajax_novoicode_listar_pdfs', 'novoicode_listar_pdfs');


