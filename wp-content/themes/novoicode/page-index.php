<?php
/**
 * Arquivo: wp-content/themes/novoicode/page-index.php
 * Page Index - Indexação Automática de PDFs
 * Acessível apenas via IPs autorizados
 */

// Carrega o WordPress
require_once('wp-load.php');

// IPs autorizados
$ips_autorizados = ['143.106.16.153','143.106.7.69'];
$ip_cliente = $_SERVER['REMOTE_ADDR'];

// Verifica se o IP está autorizado
if (!in_array($ip_cliente, $ips_autorizados)) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Acesso negado. IP não autorizado: ' . $ip_cliente;
    error_log('❌ page-index.php - Tentativa de acesso de IP não autorizado: ' . $ip_cliente);
    exit;
}

// Verifica se o agendamento automático está ativado
$agendamento_ativo = get_option('novoicode_agendamento_ativo');
if (!$agendamento_ativo) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Indexação automática desativada. Ative a opção "Ativar Indexação Automática" no painel administrativo.';
    error_log('❌ page-index.php - Tentativa de execução com agendamento desativado - IP: ' . $ip_cliente);
    exit;
}

// Define que é uma execução via cron
if (!defined('DOING_CRON')) {
    define('DOING_CRON', true);
}

error_log('🚀 page-index.php - Iniciando indexação automática via cron do Linux - IP: ' . $ip_cliente);

// Função para executar a indexação automática em background COM CONTROLE DE MEMÓRIA
function executar_indexacao_automatica_background() {
    global $wpdb;
    
    error_log('📁 page-index.php - Iniciando indexação automática em background com controle de memória');
    
    // Obter tipos de conteúdo configurados
    $tipos_conteudo_str = get_option('portal_input_7');
    
    if (empty($tipos_conteudo_str)) {
        error_log('❌ page-index.php - Nenhum tipo de conteúdo configurado no portal_input_7');
        return array('sucesso' => false, 'mensagem' => 'ERRO: Nenhum tipo de conteúdo configurado');
    }
    
    $tipos_conteudo = array_map('trim', explode(',', $tipos_conteudo_str));
    $ano_atual = date('Y');
    
    error_log('🔍 page-index.php - Tipos a processar: ' . implode(', ', $tipos_conteudo));
    
    $total_pdfs = 0;
    $total_indexados = 0;
    $erros = 0;
    $pdfs_para_processar = [];
    
    // PRIMEIRO: Coletar todos os PDFs sem processar ainda
    foreach ($tipos_conteudo as $tipo) {
        $base_dir = ABSPATH . "wp-content/uploads/$tipo/$ano_atual";
        
        if (!file_exists($base_dir)) {
            error_log("📂 page-index.php - Diretório não encontrado: $base_dir");
            continue;
        }
        
        error_log("📂 page-index.php - Coletando PDFs do diretório: $base_dir");
        
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
                        $arquivo_path = (string) $arquivo;
                        $subpath = str_replace(ABSPATH, '', $arquivo_path);
                        $url_pdf = '/' . str_replace('\\', '/', $subpath);
                        
                        // Verificar se já existe ANTES de adicionar à lista
                        $existe = $wpdb->get_var($wpdb->prepare(
                            "SELECT id FROM {$wpdb->prefix}pdf_index WHERE arquivo = %s OR url = %s",
                            $arquivo_path, $url_pdf
                        ));
                        
                        if (!$existe) {
                            $pdfs_para_processar[] = [
                                'arquivo' => $arquivo_path,
                                'url' => $url_pdf,
                                'tipo' => $tipo,
                                'ano' => $ano_atual,
                                'id_post' => $id_post
                            ];
                        }
                        
                        $total_pdfs++;
                    }
                }
            } catch (Exception $e) {
                error_log("❌ page-index.php - Erro ao escanear $full_path: " . $e->getMessage());
                $erros++;
                continue;
            }
        }
    }
    
    error_log("📊 page-index.php - PDFs encontrados: $total_pdfs | PDFs para processar: " . count($pdfs_para_processar));
    
    // SEGUNDO: Processar os PDFs em lotes para economizar memória
    $lote_atual = 0;
    $tamanho_lote = 10; // Processa 10 PDFs por lote
    
    foreach (array_chunk($pdfs_para_processar, $tamanho_lote) as $lote) {
        $lote_atual++;
        error_log("🔄 page-index.php - Processando lote $lote_atual com " . count($lote) . " PDFs");
        
        foreach ($lote as $pdf) {
            // Liberar memória antes de processar cada PDF
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
            
            $memoria_antes = memory_get_usage(true);
            
            // Processar o PDF
            if (processar_pdf_com_controle_memoria($pdf['arquivo'], $pdf['url'], $pdf['tipo'], $pdf['ano'], $pdf['id_post'])) {
                $total_indexados++;
            } else {
                $erros++;
            }
            
            $memoria_depois = memory_get_usage(true);
            $memoria_usada = round(($memoria_depois - $memoria_antes) / 1024 / 1024, 2);
            
            error_log("📄 page-index.php - PDF processado: " . basename($pdf['arquivo']) . " | Memória: {$memoria_usada}MB");
            
            // Pequena pausa para evitar sobrecarga
            usleep(100000); // 100ms
        }
        
        // Pausa maior entre lotes
        sleep(1);
    }
    
    $resultado = array(
        'sucesso' => true,
        'total_pdfs' => $total_pdfs,
        'total_indexados' => $total_indexados,
        'erros' => $erros,
        'mensagem' => "✅ Indexação automática concluída! PDFs encontrados: $total_pdfs | Novos indexados: $total_indexados | Erros: $erros"
    );
    
    error_log('✅ page-index.php - ' . $resultado['mensagem']);
    
    return $resultado;
}

// Função para processar PDF com controle de memória
function processar_pdf_com_controle_memoria($arquivo, $url_pdf, $tipo, $ano, $id_post) {
    global $wpdb;
    
    try {
        if (!file_exists($arquivo)) {
            error_log("❌ page-index.php - Arquivo não encontrado: $arquivo");
            return false;
        }
        
        // Verificar tamanho do arquivo antes de processar
        $tamanho_arquivo = filesize($arquivo);
        $tamanho_maximo = 50 * 1024 * 1024; // 50MB
        
        if ($tamanho_arquivo > $tamanho_maximo) {
            error_log("⚠️ page-index.php - PDF muito grande, pulando: " . basename($arquivo) . " (" . round($tamanho_arquivo / 1024 / 1024, 2) . "MB)");
            
            // Inserir no banco sem texto para registrar a tentativa
            $wpdb->insert(
                "{$wpdb->prefix}pdf_index",
                array(
                    'arquivo' => $arquivo,
                    'url' => $url_pdf,
                    'texto' => '',
                    'tipo' => $tipo,
                    'ano' => $ano,
                    'id_post' => $id_post
                ),
                array('%s', '%s', '%s', '%s', '%d', '%d')
            );
            
            return true;
        }
        
        // Extrair texto do PDF com tratamento de erro
        $texto_pdf = '';
        try {
            $texto_pdf = novoicode_extrair_texto_pdf($arquivo);
        } catch (Exception $e) {
            error_log("❌ page-index.php - Erro ao extrair texto do PDF {$arquivo}: " . $e->getMessage());
            $texto_pdf = '';
        }
        
        if (empty($texto_pdf)) {
            error_log("⚠️ page-index.php - Texto vazio extraído: " . basename($arquivo));
            $texto_pdf = '';
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
            error_log("✅ page-index.php - PDF indexado com sucesso: " . basename($arquivo));
            return true;
        } else {
            error_log("❌ page-index.php - Erro ao inserir no banco: " . basename($arquivo) . " - " . $wpdb->last_error);
            return false;
        }
        
    } catch (Exception $e) {
        error_log("❌ page-index.php - Exception em " . basename($arquivo) . ": " . $e->getMessage());
        return false;
    }
}

// Executar a indexação
header('Content-Type: text/plain; charset=utf-8');
echo "=== INDEXAÇÃO AUTOMÁTICA DE PDFS ===\n";
echo "IP autorizado: " . $ip_cliente . "\n";
echo "Data/Hora: " . date('Y-m-d H:i:s') . "\n";
echo "Agendamento ativo: " . ($agendamento_ativo ? 'SIM' : 'NÃO') . "\n";
echo "Memória limite: " . ini_get('memory_limit') . "\n";
echo "\nIniciando processo...\n\n";

$inicio = microtime(true);
$memoria_inicio = memory_get_usage(true);

$resultado = executar_indexacao_automatica_background();

$fim = microtime(true);
$memoria_fim = memory_get_usage(true);

$tempo_execucao = round($fim - $inicio, 2);
$memoria_usada = round(($memoria_fim - $memoria_inicio) / 1024 / 1024, 2);

if ($resultado['sucesso']) {
    echo "✅ " . $resultado['mensagem'] . "\n";
    echo "📊 Estatísticas:\n";
    echo "   - Total de PDFs encontrados: " . $resultado['total_pdfs'] . "\n";
    echo "   - PDFs indexados com sucesso: " . $resultado['total_indexados'] . "\n";
    echo "   - Erros durante o processo: " . $resultado['erros'] . "\n";
    echo "   - Tempo de execução: " . $tempo_execucao . " segundos\n";
    echo "   - Memória utilizada: " . $memoria_usada . " MB\n";
} else {
    echo "❌ " . $resultado['mensagem'] . "\n";
}

echo "\nProcesso concluído em: " . date('Y-m-d H:i:s') . "\n";
echo "====================================\n";
?>