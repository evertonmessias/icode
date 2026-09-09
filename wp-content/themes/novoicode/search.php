<?php
// Arquivo: /wp-content/themes/novoicode/search.php
get_header();

// Verificar aceite do usuário
if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false) {
    echo '<script>window.location.href = "/perfil";</script>';
    exit;
}
?>

<?php
// ==============================================
// DETECÇÃO DO TIPO DE BUSCA
// ==============================================

// Determinar tipo de busca - AGORA USANDO 'consulta' EM VEZ DE 'modoconsulta'
$is_modoconsulta = isset($_GET['consulta']);
$pergunta = isset($_GET['s']) ? trim($_GET['s']) : '';
$search_terms = '';

// Se for modo consulta, usar o 's' como pergunta
if ($is_modoconsulta && !empty($pergunta)) {
    $search_terms = $pergunta;
    $busca_tipo = 'modoconsulta';
} else {
    $search_terms = get_search_query();
    $busca_tipo = 'busca_simples';
}

// Se não houver termos de busca, redirecionar
if (empty($search_terms)) {
    // Se for modo consulta sem termos, vai para página de consulta
    if ($is_modoconsulta) {
        wp_redirect(home_url('/?as=1&consulta=1'));
        exit;
    }
    // Caso contrário, vai para home
    wp_redirect(home_url('/'));
    exit;
}
?>

<?php
// ==============================================
// FUNÇÃO: Extrair intenção da pergunta
// ==============================================
function extrair_intencao_pergunta($pergunta)
{
    // Normalização
    $texto = mb_strtolower($pergunta, 'UTF-8');
    $texto = trim($texto);
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
    $texto = preg_replace('/[^a-z0-9\/\s]/', ' ', $texto);
    $texto = preg_replace('/\s+/', ' ', $texto);

    // Estrutura base
    $intencao = [
        'tipo' => 'desconhecida',
        'acao' => null,
        'post_type' => null,
        'documento' => null,
        'ano' => null,
        'mes' => null,
        'data' => null,
        'palavras' => []
    ];

    $palavras = explode(' ', $texto);
    $intencao['palavras'] = array_values(array_filter($palavras));

    // Detectar AÇÃO
    if (preg_match('/\b(mostrar|mostre|exibir|exiba|ver|veja)\b/', $texto)) {
        $intencao['acao'] = 'mostrar';
        $intencao['tipo'] = 'consulta';
    } elseif (preg_match('/\b(listar|liste|listem)\b/', $texto)) {
        $intencao['acao'] = 'listar';
        $intencao['tipo'] = 'consulta';
    } elseif (preg_match('/\b(buscar|busque|procurar|pesquisar)\b/', $texto)) {
        $intencao['acao'] = 'buscar';
        $intencao['tipo'] = 'consulta';
    } elseif (preg_match('/\b(quantos|quantidade|total|conte|contar)\b/', $texto)) {
        $intencao['acao'] = 'contar';
        $intencao['tipo'] = 'consulta';
    }

    // Detectar POST TYPE
    if (preg_match('/\b(congregacao|congrega|congregacoes)\b/', $texto)) {
        $intencao['post_type'] = 'congrega';
    } elseif (preg_match('/\bci\b/', $texto)) {
        $intencao['post_type'] = 'ci';
    } elseif (preg_match('/\bdsc\b/', $texto)) {
        $intencao['post_type'] = 'dsc';
    } elseif (preg_match('/\bdsi\b/', $texto)) {
        $intencao['post_type'] = 'dsi';
    } elseif (preg_match('/\bdtc\b/', $texto)) {
        $intencao['post_type'] = 'dtc';
    } elseif (preg_match('/\bcdi\b/', $texto)) {
        $intencao['post_type'] = 'cdi';
    }

    // Detectar TIPO DE DOCUMENTO
    if (preg_match('/\b(pautas?)\b/', $texto)) {
        $intencao['documento'] = 'pauta';
    } elseif (preg_match('/\b(deliberacao|deliberacoes|deliberações)\b/', $texto)) {
        $intencao['documento'] = 'deliberacao';
    } elseif (preg_match('/\b(atas?)\b/', $texto)) {
        $intencao['documento'] = 'ata';
    }

    // Detectar DATA COMPLETA
    if (preg_match('/\b(\d{2})\/(\d{2})\/(\d{4})\b/', $texto, $m)) {
        $intencao['data'] = "{$m[3]}-{$m[2]}-{$m[1]}";
        $intencao['ano'] = (int) $m[3];
        $intencao['mes'] = (int) $m[2];
    }

    // Detectar ANO
    if (!$intencao['ano'] && preg_match('/\b(19|20)\d{2}\b/', $texto, $m)) {
        $intencao['ano'] = (int) $m[0];
    }

    // Detectar MÊS
    $mapaMeses = [
        'janeiro' => 1,
        'jan' => 1,
        'fevereiro' => 2,
        'fev' => 2,
        'marco' => 3,
        'mar' => 3,
        'março' => 3,
        'abril' => 4,
        'abr' => 4,
        'maio' => 5,
        'mai' => 5,
        'junho' => 6,
        'jun' => 6,
        'julho' => 7,
        'jul' => 7,
        'agosto' => 8,
        'ago' => 8,
        'setembro' => 9,
        'set' => 9,
        'outubro' => 10,
        'out' => 10,
        'novembro' => 11,
        'nov' => 11,
        'dezembro' => 12,
        'dez' => 12,
    ];

    foreach ($mapaMeses as $nome => $num) {
        if (preg_match('/\b' . $nome . '\b/', $texto)) {
            $intencao['mes'] = $num;
            break;
        }
    }

    // mês numérico solto
    if (!$intencao['mes'] && preg_match('/\b(0?[1-9]|1[0-2])\b/', $texto, $m)) {
        $intencao['mes'] = (int) $m[0];
    }

    // Fallback inteligente
    if ($intencao['tipo'] === 'desconhecida' && $intencao['post_type']) {
        $intencao['tipo'] = 'consulta';
        $intencao['acao'] = $intencao['acao'] ?? 'listar';
    }

    return $intencao;
}

// ==============================================
// FUNÇÃO: Buscar documentos modo consulta
// ==============================================
function buscar_documentos_modo_consulta(array $intencao, $tipos_selecionados)
{
    global $wpdb;

    if ($intencao['tipo'] !== 'consulta' || empty($tipos_selecionados)) {
        return [
            'sucesso' => false,
            'erro' => 'Não foi possível interpretar a solicitação.',
            'dados' => []
        ];
    }

    // Usar o primeiro tipo selecionado (ou o detectado se for específico)
    $post_type = $intencao['post_type'] ?? $tipos_selecionados[0];
    $meta_key = $post_type . '_date';

    // Nome do documento para exibição
    $nomes_documento = [
        'pauta' => 'pautas',
        'deliberacao' => 'deliberações',
        'ata' => 'atas'
    ];

    $documento_nome = isset($nomes_documento[$intencao['documento']]) ?
        $nomes_documento[$intencao['documento']] :
        ($intencao['documento'] ?? '');

    // =============================
    // 1️⃣ Buscar reuniões
    // =============================
    $args = [
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'orderby' => 'meta_value',
        'meta_key' => $meta_key,
        'order' => 'ASC'
    ];

    // Adicionar filtro por data
    if ($intencao['ano']) {
        $args['meta_query'] = [
            [
                'key' => $meta_key,
                'value' => [
                    sprintf('%04d-%02d-01 00:00:00', $intencao['ano'], $intencao['mes'] ?? 1),
                    sprintf('%04d-%02d-31 23:59:59', $intencao['ano'], $intencao['mes'] ?? 12)
                ],
                'compare' => 'BETWEEN',
                'type' => 'DATETIME'
            ]
        ];
    }

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return [
            'sucesso' => false,
            'erro' => 'Nenhuma reunião encontrada para o período.',
            'periodo' => [
                'ano' => $intencao['ano'],
                'mes' => $intencao['mes'] ?? 'todos'
            ],
            'dados' => []
        ];
    }

    // =============================
    // 2️⃣ CASO A: Sem documento específico (mostrar lista de reuniões)
    // =============================
    if (!$intencao['documento']) {
        $reunioes = [];

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Buscar data
            $data_custom = get_post_meta($post_id, $meta_key, true);
            $data_formatada = '';
            $data_iso = '';

            if ($data_custom) {
                $data = DateTime::createFromFormat('Y-m-d\TH:i', $data_custom);
                if ($data) {
                    $data_formatada = $data->format('d/m/Y, H:i') . ' h';
                    $data_iso = $data->format('Y-m-d H:i');
                }
            }

            $conteudo = '';
            if ($intencao['acao'] === 'mostrar') {
                $conteudo = apply_filters('the_content', get_the_content());
                if (strlen($conteudo) > 5000) {
                    $conteudo = substr(strip_tags($conteudo), 0, 5000) . '... [conteúdo truncado]';
                }
            }

            $reunioes[] = [
                'id' => $post_id,
                'titulo' => get_the_title(),
                'permalink' => get_permalink(),
                'data_formatada' => $data_formatada,
                'data_iso' => $data_iso,
                'conteudo' => $intencao['acao'] === 'mostrar' ? $conteudo : null
            ];
        }

        wp_reset_postdata();

        return [
            'sucesso' => true,
            'tipo_resposta' => 'reunioes',
            'acao' => $intencao['acao'],
            'post_type' => $post_type,
            'total_reunioes' => count($reunioes),
            'reunioes' => $reunioes
        ];
    }

    // =============================
    // 3️⃣ CASO B: Com documento específico
    // =============================
    $post_ids = wp_list_pluck($query->posts, 'ID');
    $tabela = $wpdb->prefix . 'pdf_index';

    if (empty($post_ids)) {
        return [
            'sucesso' => false,
            'erro' => "Nenhuma reunião encontrada para buscar documentos.",
            'dados' => []
        ];
    }

    // Mapear documento para padrão de caminho
    $padroes_documento = [
        'pauta' => ['/pauta', '/pautas'],
        'deliberacao' => ['/deliberacoes', '/deliberacao'],
        'ata' => ['/ata', '/atas']
    ];

    if (!isset($padroes_documento[$intencao['documento']])) {
        return [
            'sucesso' => false,
            'erro' => "Tipo de documento não reconhecido.",
            'dados' => []
        ];
    }

    $padroes_busca = $padroes_documento[$intencao['documento']];

    // Buscar PDFs
    $placeholders = implode(',', array_fill(0, count($post_ids), '%d'));
    $sql = "SELECT * FROM $tabela WHERE id_post IN ($placeholders) ORDER BY arquivo ASC";
    $query_sql = $wpdb->prepare($sql, $post_ids);
    $pdfs = $wpdb->get_results($query_sql);

    if (!$pdfs) {
        return [
            'sucesso' => false,
            'erro' => "Nenhum documento do tipo '$documento_nome' encontrado.",
            'dados' => []
        ];
    }

    // Filtrar PDFs pelo tipo
    $pdfs_filtrados = [];
    foreach ($pdfs as $pdf) {
        foreach ($padroes_busca as $padrao) {
            if (stripos($pdf->arquivo, $padrao) !== false) {
                $pdfs_filtrados[] = $pdf;
                break;
            }
        }
    }

    if (empty($pdfs_filtrados)) {
        return [
            'sucesso' => false,
            'erro' => "Nenhum documento do tipo '$documento_nome' encontrado.",
            'dados' => []
        ];
    }

    // Agrupar PDFs por reunião
    $pdfs_por_reuniao = [];
    foreach ($pdfs_filtrados as $pdf) {
        $pdfs_por_reuniao[$pdf->id_post][] = $pdf;
    }

    // Buscar informações das reuniões
    $reunioes_com_documentos = [];
    $total_documentos = 0;

    foreach ($post_ids as $post_id) {
        if (isset($pdfs_por_reuniao[$post_id])) {
            $reuniao = get_post($post_id);
            if ($reuniao) {
                $data_custom = get_post_meta($post_id, $meta_key, true);
                $data_formatada = '';
                $data_iso = '';

                if ($data_custom) {
                    $data = DateTime::createFromFormat('Y-m-d\TH:i', $data_custom);
                    if ($data) {
                        $data_formatada = $data->format('d/m/Y, H:i') . ' h';
                        $data_iso = $data->format('Y-m-d H:i');
                    }
                }

                $documentos_reuniao = [];
                foreach ($pdfs_por_reuniao[$post_id] as $pdf) {
                    // URL do PDF
                    $url = !empty($pdf->url) ? $pdf->url : site_url(str_replace(ABSPATH, '/', $pdf->arquivo));
                    $nome_arquivo = basename($pdf->arquivo);

                    // Conteúdo do PDF (se ação for "mostrar")
                    $conteudo_pdf = null;
                    if ($intencao['acao'] === 'mostrar' && !empty($pdf->texto)) {
                        $conteudo = $pdf->texto;
                        $conteudo = preg_replace('/\n{3,}/', "\n\n", $conteudo);
                        if (strlen($conteudo) > 10000) {
                            $conteudo = substr($conteudo, 0, 10000) . '... [conteúdo truncado]';
                        }
                        $conteudo_pdf = $conteudo;
                    }

                    $documentos_reuniao[] = [
                        'id' => $pdf->id,
                        'nome_arquivo' => $nome_arquivo,
                        'url' => $url,
                        'ano' => $pdf->ano,
                        'conteudo' => $conteudo_pdf
                    ];

                    $total_documentos++;
                }

                $reunioes_com_documentos[] = [
                    'id' => $post_id,
                    'titulo' => $reuniao->post_title,
                    'permalink' => get_permalink($post_id),
                    'data_formatada' => $data_formatada,
                    'data_iso' => $data_iso,
                    'total_documentos' => count($pdfs_por_reuniao[$post_id]),
                    'documentos' => $documentos_reuniao
                ];
            }
        }
    }

    // Ordenar reuniões por data
    usort($reunioes_com_documentos, function ($a, $b) {
        return strcmp($a['data_iso'] ?? '', $b['data_iso'] ?? '');
    });

    return [
        'sucesso' => true,
        'tipo_resposta' => 'documentos',
        'acao' => $intencao['acao'],
        'post_type' => $post_type,
        'documento_tipo' => $intencao['documento'],
        'documento_nome' => $documento_nome,
        'total_reunioes' => count($reunioes_com_documentos),
        'total_documentos' => $total_documentos,
        'periodo' => [
            'ano' => $intencao['ano'],
            'mes' => $intencao['mes'] ?? 'todos'
        ],
        'reunioes' => $reunioes_com_documentos
    ];
}

// ==============================================
// PROCESSAMENTO PRINCIPAL
// ==============================================

// Verificar se é busca avançada (com parâmetro 'as')
$is_busca_avancada = isset($_GET['as']);
$busca_exata = isset($_GET['exato']) && $_GET['exato'] == '1';

// Determinar os tipos de conteúdo para buscar
$tipos_selecionados = [];

// CASO 1: Busca avançada com tipos selecionados
if ($is_busca_avancada && isset($_GET['tipos']) && !empty($_GET['tipos'])) {
    $tipos_selecionados = is_array($_GET['tipos']) ? $_GET['tipos'] : [$_GET['tipos']];
}
// CASO 2: Modo consulta - extrair do texto
elseif ($busca_tipo === 'modoconsulta') {
    $intencao = extrair_intencao_pergunta($search_terms);
    if ($intencao['post_type']) {
        $tipos_selecionados = [$intencao['post_type']];
    } else {
        // Se não detectar post_type, usar todos os tipos permitidos
        $tipos_selecionados = get_user_meta(wp_get_current_user()->ID, 'membro', true);
        if (!is_array($tipos_selecionados)) {
            $tipos_selecionados = [$tipos_selecionados];
        }
    }
}
// CASO 3: Busca padrão - usar todos os tipos permitidos
else {
    $tipos_selecionados = get_user_meta(wp_get_current_user()->ID, 'membro', true);
    if (!is_array($tipos_selecionados)) {
        $tipos_selecionados = [$tipos_selecionados];
    }
}

// Validar tipos selecionados
if (empty($tipos_selecionados)) {
    $no_tipo_selected = true;
} else {
    $no_tipo_selected = false;
}

// Criar subtítulo para exibição
$subtitle = implode(", ", $tipos_selecionados);

// Verificar se é uma busca complexa
$is_busca_complexa = false;
if ($busca_tipo === 'busca_simples') {
    $intencao_teste = extrair_intencao_pergunta($search_terms);
    $is_busca_complexa = ($intencao_teste['tipo'] === 'consulta' && $intencao_teste['post_type']);
}

// Processar modo consulta se necessário
$resultado_modo_consulta = null;
if ($busca_tipo === 'modoconsulta') {
    $intencao = extrair_intencao_pergunta($search_terms);
    $resultado_modo_consulta = buscar_documentos_modo_consulta($intencao, $tipos_selecionados);
}
?>

<main id="main" class="main">

    <!-- ======= Page Title & Breadcrumbs ======= -->
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <?php if ($busca_tipo === 'modoconsulta'): ?>
                <h1 class="page-title">Modo Consulta: <u><?php echo esc_html($search_terms); ?></u></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Início</a></li>
                        <li class="breadcrumb-item active">Consulta Inteligente</li>
                    </ol>
                </nav>
            <?php else: ?>
                <h1 class='page-title'>Busca:&ensp;<u><?php echo esc_html($search_terms); ?></u></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Início</a></li>
                        <li class="breadcrumb-item active">Busca</li>
                    </ol>
                </nav>
            <?php endif; ?>
        </div>
        <div class="btn-editors">
            <a class="btn btn-light" href="/"><i class="bi bi-skip-backward-fill"></i>&ensp;Voltar</a>&emsp;
            <?php if ($is_busca_complexa && $busca_tipo !== 'modoconsulta'): ?>
                <a class="btn btn-info"
                    href="<?php echo home_url('/?s=' . urlencode($search_terms) . '&as=1&consulta=1&pergunta=' . urlencode($search_terms)); ?>">
                    <i class="bi bi-search-heart"></i> Modo Consulta
                </a>
            <?php endif; ?>
            <?php if ($busca_tipo === 'modoconsulta'): ?>
                <a class="btn btn-secondary" href="/?as=1&consulta=1"><i class="bi bi-arrow-repeat"></i>&ensp;Nova
                    Consulta</a>
            <?php endif; ?>
        </div>
    </div><!-- End Page Title & Breadcrumbs -->

    <?php if ($is_busca_complexa && $busca_tipo !== 'modoconsulta'): ?>
        <div class="alert alert-info alert-dismissible fade show mb-3 mx-3" role="alert">
            <i class="bi bi-lightbulb me-2"></i>
            <strong>Busca inteligente detectada!</strong>
            <p class="mb-0 mt-1">Parece que você está tentando fazer uma busca complexa como
                "<?php echo esc_html($search_terms); ?>".
                Para este tipo de consulta, recomendamos usar o <a
                    href="<?php echo home_url('/?s=' . urlencode($search_terms) . '&as=1&consulta=1&pergunta=' . urlencode($search_terms)); ?>"
                    class="alert-link">Modo Consulta</a> que entende frases naturais.</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <section class="section icode-search">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <?php if ($busca_tipo === 'modoconsulta' && $resultado_modo_consulta): ?>
                            <!-- ==============================================
                                 RENDERIZAÇÃO DO MODO CONSULTA COM CARDS
                                 ============================================== -->

                            <!-- Cabeçalho da Consulta -->
                            <div class="text-center mb-4">                                
                                <h4 class="card-title">Consulta Inteligente</h4>
                                <p class="text-muted mb-0">"<?php echo esc_html($search_terms); ?>"</p>

                                <?php if ($resultado_modo_consulta['sucesso']): ?>
                                    <div class="mt-3">
                                        <span class="badge bg-info me-2">
                                            <i
                                                class="bi bi-gear me-1"></i><?php echo strtoupper($resultado_modo_consulta['post_type'] ?? 'GERAL'); ?>
                                        </span>
                                        <?php if ($intencao['documento']): ?>
                                            <span class="badge bg-success me-2">
                                                <i
                                                    class="bi bi-file-earmark me-1"></i><?php echo ucfirst($resultado_modo_consulta['documento_nome']); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($intencao['ano']): ?>
                                            <span class="badge bg-warning me-2">
                                                <i class="bi bi-calendar me-1"></i><?php echo $intencao['ano']; ?>
                                                <?php if ($intencao['mes']): ?>
                                                    / <?php echo str_pad($intencao['mes'], 2, '0', STR_PAD_LEFT); ?>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (!$resultado_modo_consulta['sucesso']): ?>
                                <!-- ERRO -->
                                <div class="text-center py-5">
                                    <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
                                    <h4 class="text-warning mt-4"><?php echo esc_html($resultado_modo_consulta['erro']); ?></h4>
                                    <p class="text-muted mt-3">
                                        Não foi possível encontrar resultados para sua consulta.
                                    </p>
                                    <div class="mt-4">
                                        <a href="/" class="btn btn-primary me-2">
                                            <i class="bi bi-house-door"></i> Voltar para início
                                        </a>
                                        <a href="/?as=1&consulta=1" class="btn btn-outline-primary">
                                            <i class="bi bi-arrow-repeat"></i> Nova consulta
                                        </a>
                                    </div>
                                </div>

                            <?php elseif ($resultado_modo_consulta['tipo_resposta'] === 'reunioes'): ?>
                                <!-- RESULTADOS: LISTA DE REUNIÕES -->
                                <div class="alert alert-success mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                        <div>
                                            <h5 class="alert-heading mb-1">Consulta processada com sucesso!</h5>
                                            <p class="mb-0">
                                                Encontradas
                                                <strong><?php echo $resultado_modo_consulta['total_reunioes']; ?></strong>
                                                reuniões<?php echo $intencao['ano'] ? ' em ' . $intencao['ano'] : ''; ?>.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <?php foreach ($resultado_modo_consulta['reunioes'] as $reuniao): ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-header bg-light">
                                                    <h5 class="card-title mb-0">
                                                        <i class="bi bi-calendar-event text-primary me-2"></i>
                                                        <?php echo esc_html($reuniao['titulo']); ?>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <?php if ($reuniao['data_formatada']): ?>
                                                        <div class="mb-3">
                                                            <small class="text-muted">
                                                                <i class="bi bi-clock me-1"></i>
                                                                <?php echo esc_html($reuniao['data_formatada']); ?>
                                                            </small>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if ($reuniao['conteudo'] && $intencao['acao'] === 'mostrar'): ?>
                                                        <div class="mb-3 p-3 bg-light rounded">
                                                            <small class="text-muted">
                                                                <?php echo wp_kses_post($reuniao['conteudo']); ?>
                                                            </small>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="card-footer bg-white">
                                                    <a href="<?php echo esc_url($reuniao['permalink']); ?>"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Ver reunião completa
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            <?php elseif ($resultado_modo_consulta['tipo_resposta'] === 'documentos'): ?>
                                <!-- RESULTADOS: DOCUMENTOS ESPECÍFICOS -->
                                <div class="alert alert-success mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                        <div>
                                            <h5 class="alert-heading mb-1">Consulta processada com sucesso!</h5>
                                            <p class="mb-0">
                                                Encontradas
                                                <strong><?php echo $resultado_modo_consulta['total_reunioes']; ?></strong>
                                                reuniões
                                                com <strong><?php echo $resultado_modo_consulta['total_documentos']; ?></strong>
                                                <?php echo $resultado_modo_consulta['documento_nome']; ?>.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <?php foreach ($resultado_modo_consulta['reunioes'] as $index => $reuniao): ?>
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h5 class="card-title mb-0">
                                                        <i class="bi bi-calendar-check text-primary me-2"></i>
                                                        <?php echo esc_html($reuniao['titulo']); ?>
                                                    </h5>
                                                    <?php if ($reuniao['data_formatada']): ?>
                                                        <small class="text-muted">
                                                            <i class="bi bi-clock me-1"></i>
                                                            <?php echo esc_html($reuniao['data_formatada']); ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <span class="badge bg-info">
                                                        <?php echo $reuniao['total_documentos']; ?> documento(s)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <?php foreach ($reuniao['documentos'] as $documento): ?>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card border h-100">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-start">
                                                                    <div class="me-3">
                                                                        <i class="bi bi-file-pdf text-danger fs-2"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <h6 class="card-title">
                                                                            <a href="<?php echo esc_url($documento['url']); ?>"
                                                                                target="_blank" class="text-decoration-none">
                                                                                <?php echo esc_html($documento['nome_arquivo']); ?>
                                                                            </a>
                                                                        </h6>
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center mt-2">
                                                                            <small class="text-muted">
                                                                                <i class="bi bi-calendar3 me-1"></i>
                                                                                Ano: <?php echo esc_html($documento['ano']); ?>
                                                                            </small>
                                                                            <a href="<?php echo esc_url($documento['url']); ?>"
                                                                                target="_blank" class="btn btn-sm btn-outline-danger">
                                                                                <i class="bi bi-download"></i> Baixar
                                                                            </a>
                                                                        </div>
                                                                        <?php if ($documento['conteudo'] && $intencao['acao'] === 'mostrar'): ?>
                                                                            <div class="mt-3 p-2 bg-light rounded">
                                                                                <small class="text-muted d-block">
                                                                                    <strong>Conteúdo extraído:</strong>
                                                                                </small>
                                                                                <small class="text-muted">
                                                                                    <?php echo nl2br(esc_html($documento['conteudo'])); ?>
                                                                                </small>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <div class="text-end">
                                                <a href="<?php echo esc_url($reuniao['permalink']); ?>"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Ver reunião completa
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            <?php endif; ?>

                            <!-- Botões de Ação -->
                            <div class="mt-4 pt-4 border-top text-center">
                                <a href="/?as=1&consulta=1" class="btn btn-primary me-2">
                                    <i class="bi bi-search-heart"></i> Nova Consulta
                                </a>
                                <a href="/" class="btn btn-outline-secondary">
                                    <i class="bi bi-house-door"></i> Voltar para Início
                                </a>
                            </div>

                        <?php else: ?>

                            <!-- ==============================================
                                 RENDERIZAÇÃO DA BUSCA TRADICIONAL (COM TABELAS)
                                 ============================================== -->

                            <!-- Exibir tipos selecionados -->
                            <?php if ($is_busca_avancada && !empty($tipos_selecionados)): ?>
                                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                                    <i class="bi bi-filter me-2"></i>
                                    <strong>Tipos selecionados:</strong>
                                    <?php echo $subtitle; ?>
                                    <?php if ($busca_exata): ?>
                                        <br><i class="bi bi-check-circle me-2"></i><strong>Modo:</strong> Busca por frase exata
                                    <?php else: ?>
                                        <br><i class="bi bi-search me-2"></i><strong>Modo:</strong> Busca por palavras individuais
                                    <?php endif; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if ($no_tipo_selected): ?>
                                <!-- Nenhum tipo selecionado -->
                                <div class="text-center py-4">
                                    <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
                                    <h5 class="text-muted mt-3">Nenhum tipo de conteúdo selecionado</h5>
                                    <p class="text-muted">
                                        Por favor, selecione pelo menos um tipo de conteúdo na busca avançada.
                                    </p>
                                    <a href="/" class="btn btn-primary mt-3">
                                        <i class="bi bi-arrow-left"></i> Voltar para busca avançada
                                    </a>
                                </div>
                            <?php else: ?>
                                <!-- Navegação por Abas -->
                                <ul class="nav nav-tabs" id="searchTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="posts-tab" data-bs-toggle="tab"
                                            data-bs-target="#posts-tab-pane" type="button" role="tab"
                                            aria-controls="posts-tab-pane" aria-selected="true">
                                            <i class="bi bi-file-earmark-text me-2"></i>Posts
                                            <span class="badge bg-primary ms-2" id="posts-count">0</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pdfs-tab" data-bs-toggle="tab"
                                            data-bs-target="#pdfs-tab-pane" type="button" role="tab"
                                            aria-controls="pdfs-tab-pane" aria-selected="false">
                                            <i class="bi bi-file-pdf me-2"></i>PDFs
                                            <span class="badge bg-primary ms-2" id="pdfs-count">0</span>
                                        </button>
                                    </li>
                                </ul>

                                <!-- Conteúdo das Abas -->
                                <div class="tab-content" id="searchTabContent">

                                    <!-- Aba de Posts -->
                                    <div class="tab-pane fade show active" id="posts-tab-pane" role="tabpanel"
                                        aria-labelledby="posts-tab" tabindex="0">
                                        <br>
                                        <h4>Resultados em Posts</h4>
                                        <p class="text-muted">Encontrados em: <?php echo $subtitle; ?></p>

                                        <?php
                                        global $wpdb;
                                        $posts_count = 0;

                                        if ($busca_exata) {
                                            // BUSCA EXATA: Procura pela frase completa
                                            $tipos_placeholders = implode(',', array_fill(0, count($tipos_selecionados), '%s'));

                                            $query_titulo = $wpdb->prepare("
                    SELECT ID FROM {$wpdb->posts} 
                    WHERE post_type IN ($tipos_placeholders) 
                    AND post_status = 'publish'
                    AND (post_title LIKE %s OR post_content LIKE %s)
                    ORDER BY post_date DESC
                ", array_merge($tipos_selecionados, ['%' . $wpdb->esc_like($search_terms) . '%', '%' . $wpdb->esc_like($search_terms) . '%']));

                                            $query_meta = $wpdb->prepare("
                    SELECT post_id FROM {$wpdb->postmeta} 
                    WHERE meta_value LIKE %s
                ", '%' . $wpdb->esc_like($search_terms) . '%');

                                            $post_ids_titulo = $wpdb->get_col($query_titulo);
                                            $post_ids_meta = $wpdb->get_col($query_meta);
                                            $post_ids = array_unique(array_merge($post_ids_titulo, $post_ids_meta));

                                        } else {
                                            // BUSCA FLEXÍVEL: Procura por palavras individuais
                                            $tipos_placeholders = implode(',', array_fill(0, count($tipos_selecionados), '%s'));

                                            $words = explode(' ', $search_terms);
                                            $conditions = array();
                                            $params = $tipos_selecionados;

                                            foreach ($words as $word) {
                                                if (strlen(trim($word)) > 2) {
                                                    $conditions[] = "(post_title LIKE %s OR post_content LIKE %s)";
                                                    $params[] = '%' . $wpdb->esc_like($word) . '%';
                                                    $params[] = '%' . $wpdb->esc_like($word) . '%';
                                                }
                                            }

                                            if (!empty($conditions)) {
                                                $where_conditions = implode(' OR ', $conditions);

                                                $query_flex = $wpdb->prepare("
                        SELECT ID FROM {$wpdb->posts} 
                        WHERE post_type IN ($tipos_placeholders) 
                        AND post_status = 'publish'
                        AND ($where_conditions)
                        ORDER BY post_date DESC
                    ", $params);

                                                $post_ids = $wpdb->get_col($query_flex);
                                            } else {
                                                $post_ids = array();
                                            }
                                        }

                                        if (!empty($post_ids)) {
                                            $args = array(
                                                'post__in' => $post_ids,
                                                'post_type' => $tipos_selecionados,
                                                'posts_per_page' => -1,
                                                'orderby' => 'date',
                                                'order' => 'DESC'
                                            );
                                        } else {
                                            $args = array(
                                                's' => $search_terms,
                                                'post_type' => $tipos_selecionados,
                                                'posts_per_page' => -1,
                                                'orderby' => 'date',
                                                'order' => 'DESC',
                                                'exact' => $busca_exata,
                                            );
                                        }

                                        $query = new WP_Query($args);

                                        if ($query->have_posts()) {
                                            ?>
                                            <table class="table table-striped table-hover tcategory">
                                                <thead>
                                                    <tr>
                                                        <th>Título</th>
                                                        <th>Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($query->have_posts()) {
                                                        $query->the_post();
                                                        $post_id = get_the_ID();
                                                        $current_post_type = get_post_type($post_id);

                                                        $posts_count++;
                                                        ?>
                                                        <tr>
                                                            <td class="td1">
                                                                <h5><a href="<?php the_permalink(); ?>">
                                                                        <i class="bi bi-file-earmark-text"></i>&ensp;
                                                                        <?php
                                                                        // Destacar termos no título
                                                                        $titulo = get_the_title();
                                                                        if ($busca_exata) {
                                                                            $titulo = preg_replace("/(" . preg_quote($search_terms) . ")/i", '<strong>$1</strong>', $titulo);
                                                                        } else {
                                                                            $words = explode(' ', $search_terms);
                                                                            foreach ($words as $word) {
                                                                                if (strlen(trim($word)) > 2) {
                                                                                    $titulo = preg_replace("/(" . preg_quote($word) . ")/i", '<strong>$1</strong>', $titulo);
                                                                                }
                                                                            }
                                                                        }
                                                                        echo $titulo;
                                                                        ?>
                                                                    </a></h5>
                                                                <small><?php
                                                                $content = get_the_content();
                                                                $clean_content = wp_strip_all_tags($content);
                                                                $excerpt = '';

                                                                if ($busca_exata) {
                                                                    // Busca pela frase completa
                                                                    $position = stripos($clean_content, $search_terms);
                                                                    if ($position !== false) {
                                                                        $start = max(0, $position - 100);
                                                                        $end = $position + strlen($search_terms) + 100;
                                                                        $excerpt = substr($clean_content, $start, $end - $start);
                                                                        if ($start > 0)
                                                                            $excerpt = '... ' . $excerpt;
                                                                        if ($end < strlen($clean_content))
                                                                            $excerpt .= ' ...';
                                                                        $excerpt = preg_replace("/(" . preg_quote($search_terms) . ")/i", '<strong>$1</strong>', $excerpt);
                                                                    } else {
                                                                        if (strlen($clean_content) > 200) {
                                                                            $excerpt = substr($clean_content, 0, 200) . '...';
                                                                        } else {
                                                                            $excerpt = $clean_content;
                                                                        }
                                                                    }
                                                                } else {
                                                                    // Busca por palavras individuais
                                                                    $words = explode(' ', $search_terms);
                                                                    $found_position = false;
                                                                    $found_word = '';

                                                                    foreach ($words as $word) {
                                                                        if (strlen(trim($word)) > 2 && stripos($clean_content, $word) !== false) {
                                                                            $found_position = stripos($clean_content, $word);
                                                                            $found_word = $word;
                                                                            break;
                                                                        }
                                                                    }

                                                                    if ($found_position !== false) {
                                                                        $start = max(0, $found_position - 100);
                                                                        $end = $found_position + strlen($found_word) + 100;
                                                                        $excerpt = substr($clean_content, $start, $end - $start);
                                                                        if ($start > 0)
                                                                            $excerpt = '... ' . $excerpt;
                                                                        if ($end < strlen($clean_content))
                                                                            $excerpt .= ' ...';
                                                                        $excerpt = preg_replace("/(" . preg_quote($found_word) . ")/i", '<strong>$1</strong>', $excerpt);

                                                                        // Destacar também outras palavras no excerpt
                                                                        foreach ($words as $word) {
                                                                            if (strlen(trim($word)) > 2 && $word !== $found_word) {
                                                                                $excerpt = preg_replace("/(" . preg_quote($word) . ")/i", '<strong>$1</strong>', $excerpt);
                                                                            }
                                                                        }
                                                                    } else {
                                                                        if (strlen($clean_content) > 200) {
                                                                            $excerpt = substr($clean_content, 0, 200) . '...';
                                                                        } else {
                                                                            $excerpt = $clean_content;
                                                                        }
                                                                        // Destacar palavras no excerpt normal
                                                                        foreach ($words as $word) {
                                                                            if (strlen(trim($word)) > 2) {
                                                                                $excerpt = preg_replace("/(" . preg_quote($word) . ")/i", '<strong>$1</strong>', $excerpt);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                echo $excerpt;
                                                                ?></small><br>
                                                            </td>

                                                            <?php
                                                            $data_formatada = '';
                                                            $data_iso = '';

                                                            $data_custom = get_post_meta($post_id, $current_post_type . '_date', true);
                                                            if ($data_custom) {
                                                                $data_iso = $data_custom;
                                                                $data = DateTime::createFromFormat('Y-m-d\TH:i', $data_custom);
                                                                if ($data) {
                                                                    $data_formatada = $data->format('d/m/Y, H:i') . ' h';
                                                                }
                                                            }
                                                            ?>
                                                            <td class="td2" data-order="<?php echo esc_attr($data_iso); ?>">
                                                                <?php if ($data_formatada): ?>
                                                                    <i class="bi bi-calendar-event"></i>&emsp;<?php echo $data_formatada; ?>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="text-center py-4">
                                                <i class="bi bi-search display-1 text-muted"></i>
                                                <h5 class="text-muted mt-3">Nenhum post encontrado</h5>
                                                <p class="text-muted">
                                                    <?php if ($busca_exata): ?>
                                                        Não foram encontrados posts contendo a frase exata
                                                        "<?php echo esc_html($search_terms); ?>"
                                                    <?php else: ?>
                                                        Não foram encontrados posts contendo os termos buscados
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <?php
                                        }
                                        wp_reset_postdata();
                                        ?>
                                        <script>
                                            document.getElementById('posts-count').textContent = '<?php echo $posts_count; ?>';
                                        </script>
                                    </div>

                                    <!-- Aba de PDFs -->
                                    <div class="tab-pane fade" id="pdfs-tab-pane" role="tabpanel" aria-labelledby="pdfs-tab"
                                        tabindex="0">
                                        <br>
                                        <h4>Resultados em PDFs</h4>
                                        <p class="text-muted">Encontrados em: <?php echo $subtitle; ?></p>

                                        <?php
                                        global $wpdb;
                                        $tabela = $wpdb->prefix . 'pdf_index';
                                        $pdfs_count = 0;

                                        if (count($tipos_selecionados) > 0) {
                                            $placeholders = implode(',', array_fill(0, count($tipos_selecionados), '%s'));

                                            if ($busca_exata) {
                                                // BUSCA EXATA: Procura pela frase completa
                                                $search_pattern = '%' . $wpdb->esc_like($search_terms) . '%';
                                                $query_pdf = $wpdb->prepare("
                        SELECT * FROM $tabela 
                        WHERE tipo IN ($placeholders) 
                        AND LOWER(texto) LIKE LOWER(%s)
                        ORDER BY ano DESC
                    ", array_merge($tipos_selecionados, [$search_pattern]));
                                            } else {
                                                // BUSCA FLEXÍVEL: Procura por palavras individuais
                                                $words = explode(' ', $search_terms);
                                                $word_conditions = array();
                                                $word_params = $tipos_selecionados;

                                                foreach ($words as $word) {
                                                    if (strlen(trim($word)) > 2) {
                                                        $word_conditions[] = 'LOWER(texto) LIKE LOWER(%s)';
                                                        $word_params[] = '%' . $wpdb->esc_like($word) . '%';
                                                    }
                                                }

                                                if (!empty($word_conditions)) {
                                                    $word_query = ' AND (' . implode(' OR ', $word_conditions) . ')';
                                                    $query_pdf = $wpdb->prepare("
                            SELECT * FROM $tabela 
                            WHERE tipo IN ($placeholders) $word_query
                            ORDER BY ano DESC
                        ", $word_params);
                                                } else {
                                                    $query_pdf = '';
                                                }
                                            }

                                            if (!empty($query_pdf)) {
                                                $resultados_pdf = $wpdb->get_results($query_pdf);

                                                if ($resultados_pdf) {
                                                    ?>
                                                    <table class="table table-striped table-hover tcategory">
                                                        <thead>
                                                            <tr>
                                                                <th>Arquivo</th>
                                                                <th>Ano</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($resultados_pdf as $r) {
                                                                $pdfs_count++;
                                                                $url_site = site_url();
                                                                $url = $url_site . str_replace(ABSPATH, '/', $r->arquivo);
                                                                $arquivo_nome = basename($r->arquivo);
                                                                ?>
                                                                <tr>
                                                                    <td class="td1">
                                                                        <h5>
                                                                            <a href="<?php echo $url; ?>" target="_blank">
                                                                                <i class="bi bi-file-pdf"></i>&ensp;
                                                                                <?php
                                                                                // Destacar termos no nome do arquivo
                                                                                if ($busca_exata) {
                                                                                    $arquivo_nome_display = preg_replace("/(" . preg_quote($search_terms) . ")/i", '<strong>$1</strong>', $arquivo_nome);
                                                                                } else {
                                                                                    $arquivo_nome_display = $arquivo_nome;
                                                                                    $words = explode(' ', $search_terms);
                                                                                    foreach ($words as $word) {
                                                                                        if (strlen(trim($word)) > 2) {
                                                                                            $arquivo_nome_display = preg_replace("/(" . preg_quote($word) . ")/i", '<strong>$1</strong>', $arquivo_nome_display);
                                                                                        }
                                                                                    }
                                                                                }
                                                                                echo $arquivo_nome_display;
                                                                                ?>
                                                                            </a>
                                                                        </h5>
                                                                        <small>
                                                                            <?php
                                                                            $texto = $r->texto;
                                                                            $excerpt = '';

                                                                            if ($busca_exata) {
                                                                                // Busca pela frase completa
                                                                                $position = stripos($texto, $search_terms);
                                                                                if ($position !== false) {
                                                                                    $start = max(0, $position - 100);
                                                                                    $end = $position + strlen($search_terms) + 100;
                                                                                    $excerpt = substr($texto, $start, $end - $start);
                                                                                    if ($start > 0)
                                                                                        $excerpt = '... ' . $excerpt;
                                                                                    if ($end < strlen($texto))
                                                                                        $excerpt .= ' ...';
                                                                                    $excerpt = preg_replace("/(" . preg_quote($search_terms) . ")/i", '<strong>$1</strong>', $excerpt);
                                                                                } else {
                                                                                    if (strlen($texto) > 200) {
                                                                                        $excerpt = substr($texto, 0, 200) . '...';
                                                                                    } else {
                                                                                        $excerpt = $texto;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                // Busca por palavras individuais
                                                                                $words = explode(' ', $search_terms);
                                                                                $found_position = false;
                                                                                $found_word = '';

                                                                                foreach ($words as $word) {
                                                                                    if (strlen(trim($word)) > 2 && stripos($texto, $word) !== false) {
                                                                                        $found_position = stripos($texto, $word);
                                                                                        $found_word = $word;
                                                                                        break;
                                                                                    }
                                                                                }

                                                                                if ($found_position !== false) {
                                                                                    $start = max(0, $found_position - 100);
                                                                                    $end = $found_position + strlen($found_word) + 100;
                                                                                    $excerpt = substr($texto, $start, $end - $start);
                                                                                    if ($start > 0)
                                                                                        $excerpt = '... ' . $excerpt;
                                                                                    if ($end < strlen($texto))
                                                                                        $excerpt .= ' ...';
                                                                                    $excerpt = preg_replace("/(" . preg_quote($found_word) . ")/i", '<strong>$1</strong>', $excerpt);

                                                                                    // Destacar também outras palavras no excerpt
                                                                                    foreach ($words as $word) {
                                                                                        if (strlen(trim($word)) > 2 && $word !== $found_word) {
                                                                                            $excerpt = preg_replace("/(" . preg_quote($word) . ")/i", '<strong>$1</strong>', $excerpt);
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    if (strlen($texto) > 200) {
                                                                                        $excerpt = substr($texto, 0, 200) . '...';
                                                                                    } else {
                                                                                        $excerpt = $texto;
                                                                                    }
                                                                                    // Destacar palavras no excerpt normal
                                                                                    foreach ($words as $word) {
                                                                                        if (strlen(trim($word)) > 2) {
                                                                                            $excerpt = preg_replace("/(" . preg_quote($word) . ")/i", '<strong>$1</strong>', $excerpt);
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                            echo $excerpt;
                                                                            ?>
                                                                        </small><br>
                                                                    </td>
                                                                    <td class="td2" data-order="<?php echo esc_attr($r->ano); ?>">
                                                                        <a href="<?php echo get_permalink($r->id_post); ?>">
                                                                            <i class="bi bi-calendar3"></i>&ensp;<?php echo $r->ano; ?>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="text-center py-4">
                                                        <i class="bi bi-file-pdf display-1 text-muted"></i>
                                                        <h5 class="text-muted mt-3">Nenhum PDF encontrado</h5>
                                                        <p class="text-muted">
                                                            <?php if ($busca_exata): ?>
                                                                Não foram encontrados PDFs contendo a frase exata
                                                                "<?php echo esc_html($search_terms); ?>"
                                                            <?php else: ?>
                                                                Não foram encontrados PDFs contendo os termos buscados
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="text-center py-4">
                                                    <i class="bi bi-file-pdf display-1 text-muted"></i>
                                                    <h5 class="text-muted mt-3">Nenhum PDF encontrado</h5>
                                                    <p class="text-muted">Não foi possível realizar a busca nos PDFs</p>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <script>
                                            document.getElementById('pdfs-count').textContent = '<?php echo $pdfs_count; ?>';
                                        </script>
                                    </div>

                                </div>
                            <?php endif; ?>


                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<script>
    jQuery(document).ready(function ($) {
        var dataConfig = {
            order: [[1, 'desc']],
            columnDefs: [
                {
                    targets: 1,
                    type: 'date',
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return data;
                        }
                        return $(data).data('order') || data;
                    }
                }
            ],
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            buttons: [],
            pageLength: 25,
            lengthMenu: [[25, 50, 75, 100, -1], [25, 50, 75, 100, "Todos"]],
            language: {
                emptyTable: "Nenhum conteúdo disponível",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros no total)",
                lengthMenu: "Mostrar _MENU_ registros por página",
                loadingRecords: "Carregando...",
                processing: "Processando...",
                search: "Pesquisar:",
                zeroRecords: "Nenhum registro encontrado",
                paginate: {
                    first: "Primeiro",
                    last: "Último",
                    next: "Próximo",
                    previous: "Anterior"
                }
            },
            paging: true,
            searching: true,
            info: true,
            autoWidth: false,
            responsive: true
        };

        function initDataTables() {
            $('.tcategory').each(function () {
                if (!$.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable(dataConfig);
                }
            });
        }

        initDataTables();

        $('#searchTabs button').on('click', function () {
            setTimeout(function () {
                initDataTables();
            }, 100);
        });

        $(window).on('resize', function () {
            $('.tcategory').DataTable().columns.adjust().responsive.recalc();
        });
    });
</script>

<?php get_footer(); ?>