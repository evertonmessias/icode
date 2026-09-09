<!-- Arquivo: wp-content/plugins/novoicode/includes/pages/pdfparser.php -->
<style>
    .card {
        border: none;
        border-radius: 10px;
        max-width: 100% !important;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        font-weight: 600;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    #agendamento_ativo{
        margin-top: 7px;
    }

    .alert {
        border-radius: 8px;
        border: none;
    }

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    font-size: 0.9rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

.card .card-body.py-3 {
    padding: 1rem !important;
}

.card .card-title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.card .card-text {
    font-size: 1.5rem;
}
</style>


<div class="row">

        <div class="col-6">
            <!-- Card de Indexação Manual -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-file-pdf me-2"></i>Indexação Manual de PDFs</h4>
                </div>
                <div class="card-body">

                    <form method="post" class="row g-3">
                        <?php wp_nonce_field('indexar_pdfs_action', 'indexar_pdfs_nonce'); ?>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipo de Post:</label>
                            <select name="tipo" class="form-select" required>
                                <option value="">Selecione um tipo</option>
                                <?php
                                $args = array('public' => true);
                                $post_types = get_post_types($args, 'objects');
                                $excluir = array('post', 'page', 'attachment');
                                foreach ($post_types as $post_type) {
                                    if (in_array($post_type->name, $excluir))
                                        continue;
                                    $selected = isset($_POST['tipo']) && $_POST['tipo'] === $post_type->name ? 'selected' : '';
                                    echo '<option value="' . esc_attr($post_type->name) . '" ' . $selected . '>' . esc_html($post_type->label) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ano:</label>
                            <select name="ano" class="form-select" required>
                                <option value="">Selecione um ano</option>
                                <?php
                                $ano_atual = date('Y');
                                for ($ano = $ano_atual; $ano >= 2008; $ano--) {
                                    $selected = isset($_POST['ano']) && $_POST['ano'] == $ano ? 'selected' : '';
                                    echo '<option value="' . $ano . '" ' . $selected . '>' . $ano . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <button type="submit" name="indexar_pdfs" class="btn btn-primary">
                                <i class="fas fa-play me-2"></i>Iniciar Indexação
                            </button>
                        </div>
                    </form>
                    <?php
                    // Processar indexação manual
                    if (isset($_POST['indexar_pdfs']) && wp_verify_nonce($_POST['indexar_pdfs_nonce'], 'indexar_pdfs_action')) {
                        $tipo = sanitize_text_field($_POST['tipo']);
                        $ano = sanitize_text_field($_POST['ano']);

                        if (empty($tipo) || empty($ano)) {
                            echo '<div class="alert alert-danger mt-4"><i class="fas fa-exclamation-triangle me-2"></i>Por favor, selecione um tipo e ano.</div>';
                        } else {
                            novoicode_processar_indexacao_manual($tipo, $ano);
                        }
                    }
                    ?>

                </div>
            </div>

        </div>

        <div class="col-6">
            <!-- Card de Agendamento Automático -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-clock me-2"></i>Agendamento Automático</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="row g-3">
                        <?php wp_nonce_field('salvar_agendamento_action', 'salvar_agendamento_nonce'); ?>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="agendamento_ativo" 
                                       id="agendamento_ativo" value="1" 
                                       <?php checked(get_option('novoicode_agendamento_ativo'), '1'); ?>>
                                <label class="form-check-label fw-bold" for="agendamento_ativo">
                                    Ativar Indexação Automática
                                </label>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-end">
                            <button type="submit" name="salvar_agendamento" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Salvar Configuração
                            </button>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-info">
                                <small>
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informação:</strong> A indexação automática processará todos os tipos de
                                    conteúdo configurados no sistema (apenas ano atual).
                                    <?php
                                    $tipos_automaticos_str = get_option('portal_input_7');
                                    if (!empty($tipos_automaticos_str)) {
                                        $tipos_automaticos = array_map('trim', explode(',', $tipos_automaticos_str));
                                        echo '<br>Tipos: ' . implode(', ', $tipos_automaticos);
                                    } else {
                                        echo '<br>Nenhum tipo configurado no portal_input_7.';
                                    }
                                    ?>
                                </small>
                            </div>
                        </div>
                    </form>

                    <?php
                    // Status do Agendamento
                    $agendamento_ativo = get_option('novoicode_agendamento_ativo');
                    if ($agendamento_ativo) {
                        echo '<div class="alert alert-warning mt-3">';
                        echo '<i class="fas fa-sync-alt me-2"></i>';
                        echo '<strong>Agendamento Ativo!</strong> A indexação automática está configurada.';
                        
                        // Botão "Executar Agora"
                        echo '<form method="post" style="display:inline;" class="ms-2">';
                        wp_nonce_field('executar_agora_action', 'executar_agora_nonce');
                        echo '<button type="submit" name="executar_agora" class="btn btn-sm btn-outline-primary">';
                        echo '<i class="fas fa-play me-1"></i>Executar Agora';
                        echo '</button>';
                        echo '</form>';
                        
                        echo '</div>';
                    }

                    // Processar configuração do agendamento
                    if (isset($_POST['salvar_agendamento']) && wp_verify_nonce($_POST['salvar_agendamento_nonce'], 'salvar_agendamento_action')) {
                        $agendamento_ativo = isset($_POST['agendamento_ativo']) ? '1' : '0';
                        update_option('novoicode_agendamento_ativo', $agendamento_ativo);
                        
                        if ($agendamento_ativo) {
                            echo '<div class="alert alert-success mt-3"><i class="fas fa-check-circle me-2"></i>Agendamento ativado com sucesso.</div>';
                        } else {
                            echo '<div class="alert alert-success mt-3"><i class="fas fa-check-circle me-2"></i>Agendamento desativado com sucesso.</div>';
                        }
                    }

                    // Execução manual via "Executar Agora"
                    if (isset($_POST['executar_agora']) && wp_verify_nonce($_POST['executar_agora_nonce'], 'executar_agora_action')) {
                        echo executar_indexacao_manual_interface();
                    }
                    ?>
                </div>
            </div>
        </div>

</div>

  
<div class="row">
    <div class="col-12">
        <!-- Histórico de Indexação -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-history me-2"></i>Histórico de Indexação</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Data/Hora</th>
                                <th>Status</th>
                                <th>PDFs Encontrados</th>
                                <th>Novos Indexados</th>
                                <th>Arquivos com Problema</th>
                                <th>Tempo</th>
                                <th>Memória</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $log_file = '/var/log/icode-pdf-indexacao.log';
                            $historico = array();
                            
                            if (file_exists($log_file)) {
                                $conteudo = file_get_contents($log_file);
                                $sessoes = explode('=== Indexação finalizada em', $conteudo);
                                
                                foreach ($sessoes as $sessao) {
                                    if (empty(trim($sessao))) continue;
                                    
                                    // Extrair dados da sessão
                                    $dados = array(
                                        'data_inicio' => '',
                                        'data_fim' => '',
                                        'pdfs_encontrados' => 0,
                                        'novos_indexados' => 0,
                                        'erros' => 0,
                                        'tempo_execucao' => '',
                                        'memoria_utilizada' => '',
                                        'status' => 'success'
                                    );
                                    
                                    // Data de início
                                    if (preg_match('/=== Indexação iniciada em (.+?) ===/', $sessao, $matches)) {
                                        $dados['data_inicio'] = trim($matches[1]);
                                    }
                                    
                                    // Data de fim
                                    if (preg_match('/(.+?)$/', $sessao, $matches)) {
                                        $dados['data_fim'] = trim($matches[1]);
                                    }
                                    
                                    // Estatísticas
                                    if (preg_match('/PDFs encontrados: (\d+)/', $sessao, $matches)) {
                                        $dados['pdfs_encontrados'] = intval($matches[1]);
                                    }
                                    
                                    if (preg_match('/Novos indexados: (\d+)/', $sessao, $matches)) {
                                        $dados['novos_indexados'] = intval($matches[1]);
                                    }
                                    
                                    if (preg_match('/Erros: (\d+)/', $sessao, $matches)) {
                                        $dados['erros'] = intval($matches[1]);
                                    }
                                    
                                    if (preg_match('/Tempo de execução: ([0-9.]+) segundos/', $sessao, $matches)) {
                                        $dados['tempo_execucao'] = $matches[1] . 's';
                                    }
                                    
                                    if (preg_match('/Memória utilizada: ([0-9.]+) MB/', $sessao, $matches)) {
                                        $dados['memoria_utilizada'] = $matches[1] . ' MB';
                                    }
                                    
                                    // Status sempre será OK (o sistema funcionou)
                                    $dados['status'] = 'success';
                                    
                                    if (!empty($dados['data_inicio'])) {
                                        $historico[] = $dados;
                                    }
                                }
                                
                                // Ordenar por data (mais recente primeiro)
                                $historico = array_reverse($historico);
                                
                                // Exibir apenas as últimas 10 execuções
                                $historico = array_slice($historico, 0, 10);
                                
                                if (empty($historico)) {
                                    echo '<tr><td colspan="7" class="text-center text-muted py-4">';
                                    echo '<i class="fas fa-info-circle me-2"></i>Nenhum registro de indexação encontrado.';
                                    echo '</td></tr>';
                                } else {
                                    foreach ($historico as $registro) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '<small class="text-muted">' . esc_html($registro['data_inicio']) . '</small>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<span class="badge bg-success">';
                                        echo '<i class="fas fa-check-circle me-1"></i>OK';
                                        echo '</span>';
                                        echo '</td>';
                                        echo '<td><span class="fw-bold">' . $registro['pdfs_encontrados'] . '</span></td>';
                                        echo '<td>';
                                        if ($registro['novos_indexados'] > 0) {
                                            echo '<span class="badge bg-success">' . $registro['novos_indexados'] . '</span>';
                                        } else {
                                            echo '<span class="badge bg-secondary">' . $registro['novos_indexados'] . '</span>';
                                        }
                                        echo '</td>';
                                        echo '<td>';
                                        if ($registro['erros'] > 0) {
                                            echo '<span class="badge bg-warning">' . $registro['erros'] . ' arquivo(s)</span>';
                                        } else {
                                            echo '<span class="badge bg-secondary">0</span>';
                                        }
                                        echo '</td>';
                                        echo '<td><small class="text-muted">' . $registro['tempo_execucao'] . '</small></td>';
                                        echo '<td><small class="text-muted">' . $registro['memoria_utilizada'] . '</small></td>';
                                        echo '</tr>';
                                    }
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center text-muted py-4">';
                                echo '<i class="fas fa-exclamation-triangle me-2"></i>';
                                echo 'Arquivo de log não encontrado: ' . esc_html($log_file);
                                echo '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Resumo Estatístico -->
                <?php if (!empty($historico)): ?>
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white text-center">
                            <div class="card-body py-3">
                                <h5 class="card-title mb-1">
                                    <i class="fas fa-file-pdf"></i>
                                </h5>
                                <p class="card-text mb-0 fw-bold"><?php echo count($historico); ?></p>
                                <small>Execuções Registradas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white text-center">
                            <div class="card-body py-3">
                                <h5 class="card-title mb-1">
                                    <i class="fas fa-plus-circle"></i>
                                </h5>
                                <?php
                                $total_novos = array_sum(array_column($historico, 'novos_indexados'));
                                ?>
                                <p class="card-text mb-0 fw-bold"><?php echo $total_novos; ?></p>
                                <small>Total de Novos PDFs</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white text-center">
                            <div class="card-body py-3">
                                <h5 class="card-title mb-1">
                                    <i class="fas fa-bolt"></i>
                                </h5>
                                <?php
                                $tempos = array_map(function($item) {
                                    return floatval(str_replace('s', '', $item['tempo_execucao']));
                                }, $historico);
                                $tempo_medio = count($tempos) > 0 ? array_sum($tempos) / count($tempos) : 0;
                                ?>
                                <p class="card-text mb-0 fw-bold"><?php echo number_format($tempo_medio, 2); ?>s</p>
                                <small>Tempo Médio</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-secondary text-white text-center">
                            <div class="card-body py-3">
                                <h5 class="card-title mb-1">
                                    <i class="fas fa-file-excel"></i>
                                </h5>
                                <?php
                                $total_erros = array_sum(array_column($historico, 'erros'));
                                ?>
                                <p class="card-text mb-0 fw-bold"><?php echo $total_erros; ?></p>
                                <small>Arquivos com Problema</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Botão para atualizar o histórico -->
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-outline-info" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>Atualizar Histórico
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// Inicializar tooltips do Bootstrap
if (typeof bootstrap !== 'undefined') {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}
</script>