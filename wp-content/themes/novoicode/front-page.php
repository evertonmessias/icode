<?php
//Arquivo: /wp-content/themes/novoicode/front-page.php
get_header();
?>

<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
    echo '<script>window.location.href = "/perfil";</script>'; ?>

<main id="main" class="main">

    <section class="section front-search">
        <div class="row">
            <div class="col-lg-12">                
                <div class="card main-card-container">
                    <div class="card-body">
                        
                        <!-- Navegação por Abas -->
                        <ul class="nav nav-tabs mb-4" id="searchModeTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="busca-avancada-tab" data-bs-toggle="tab"
                                    data-bs-target="#busca-avancada-pane" type="button" role="tab" 
                                    aria-controls="busca-avancada-pane" aria-selected="true">
                                    <i class="bi bi-search me-2"></i>Busca Avançada
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="modo-consulta-tab" data-bs-toggle="tab" 
                                    data-bs-target="#modo-consulta-pane" type="button" role="tab" 
                                    aria-controls="modo-consulta-pane" aria-selected="false">
                                    <i class="bi bi-chat-left-text me-2"></i>Modo Consulta
                                </button>
                            </li>
                        </ul>

                        <!-- Conteúdo das Abas -->
                        <div class="tab-content" id="searchModeTabContent">
                            
                            <!-- Aba de Busca Avançada -->
                            <div class="tab-pane fade show active" id="busca-avancada-pane" role="tabpanel"
                                aria-labelledby="busca-avancada-tab" tabindex="0">
                                
                                <!-- Cabeçalho da Busca Avançada -->
                                <div class="text-center mb-4">
                                    <h4 class="mb-3">Busca Avançada no <span class="text-primary">ICODE</span></h4>
                                    <p class="text-muted">Selecione os conteúdos e encontre rapidamente o que você precisa.</p>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-lg-8 search-body">
                                        <form class="search-form d-flex align-items-center mb-4" method="get" action="<?php echo home_url('/'); ?>">
                                            <div class="row form-advanced">                                                    
                                                <div class="col-12 tipos-container justify-content-center">
                                                    <div class="tipo-item">
                                                        <input type="checkbox" id="chk_todos">
                                                        <label for="chk_todos">Todos</label> 
                                                    </div>
                                                    <?php 
                                                    $tiposPermitidos = get_user_meta(wp_get_current_user()->ID, 'membro', true);
                                                    if (!empty($tiposPermitidos) && is_array($tiposPermitidos)): ?>
                                                            <?php foreach ($tiposPermitidos as $tipo): 
                                                                $is_congrega = strtolower(trim($tipo)) === 'congrega';
                                                            ?>
                                                                <div class="tipo-item">
                                                                    <input type="checkbox" name="tipos[]"
                                                                        value="<?php echo esc_attr($tipo); ?>"
                                                                        id="chk_<?php echo esc_attr($tipo); ?>"
                                                                        <?php echo $is_congrega ? 'checked' : ''; ?>>
                                                                    <label for="chk_<?php echo esc_attr($tipo); ?>">
                                                                        <?php echo strtoupper($tipo); ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                </div>                                                    
                                                
                                                <div class="col-12 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center"
                                                        style="width: 100%; max-width: 600px;">
                                                        <input type="text" required name="s" id="search"
                                                            placeholder="Digite sua pesquisa..." title="Pesquisar"
                                                            value="<?php the_search_query(); ?>" class="form-control" />
                                                        <!-- Adicionar parâmetro as para identificar que veio do front-page -->
                                                        <input type="hidden" name="as" value="1" />
                                                        <button type="submit" title="Pesquisar"
                                                            class="btn btn-primary ms-2">
                                                            <i class="bi bi-search"></i>
                                                        </button>                                                            
                                                        <div class="tipo-item exato" title="Correspondência exata">
                                                            <input type="checkbox" id="chk_exato" name="exato" value="1" checked>
                                                            <label for="chk_exato">Precisão</label> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="text-center">
                                            <small class="text-muted">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Busque por documentos, PDFs e conteúdos específicos
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Aba de Modo Consulta -->
                            <div class="tab-pane fade" id="modo-consulta-pane" role="tabpanel"
                                aria-labelledby="modo-consulta-tab" tabindex="0">
                                
                                <!-- Cabeçalho do Modo Consulta -->
                                <div class="text-center mb-4">
                                    <h4 class="mb-3">Modo Consulta <span class="text-primary">ICODE</span></h4>
                                    <p class="text-muted">Digite uma frase e encontre documentos de forma inteligente.</p>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-lg-8 search-body">
                                        <!-- Alterado: Agora vai para a mesma página de busca com parâmetro consulta -->
                                        <form class="search-form d-flex align-items-center mb-4" method="get" 
                                              action="<?php echo home_url('/'); ?>">
                                            <div class="row form-advanced w-100">                                                    
                                                
                                                <div class="col-12 d-flex justify-content-center">
                                                    <div class="d-flex align-items-center"
                                                        style="width: 100%; max-width: 700px;">
                                                        <input type="text" required name="s" id="consulta"
                                                            placeholder="Pergunte aqui ..." 
                                                            title="Digite sua consulta" class="form-control" />
                                                        <!-- Parâmetro para identificar como modo consulta -->
                                                        <input type="hidden" name="consulta" value="1" />
                                                        <button type="submit" title="Consultar"
                                                            class="btn btn-primary ms-2">
                                                            <i class="bi bi-search-heart"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12 mt-3">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-10">
                                                            <div class="card border-0 bg-light">
                                                                <div class="card-body p-3">
                                                                    <h6 class="card-title text-primary mb-2">
                                                                        <i class="bi bi-lightbulb me-2"></i>Exemplos de consultas:
                                                                    </h6>
                                                                    <ul class="list-unstyled mb-0">
                                                                        <li class="mb-1">
                                                                            <small><i class="bi bi-arrow-right-short text-success"></i> 
                                                                            "Atas Congregação 2026"</small>
                                                                        </li>
                                                                        <li class="mb-1">
                                                                            <small><i class="bi bi-arrow-right-short text-success"></i> 
                                                                            "Liste as Pautas DSC maio 2025"</small>
                                                                        </li>
                                                                        <li class="mb-1">
                                                                            <small><i class="bi bi-arrow-right-short text-success"></i> 
                                                                            "Mostre a Ata da Congregação de Novembro de 2025"</small>
                                                                        </li>                                                                        
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="text-center mt-3">
                                            <small class="text-muted">
                                                <i class="bi bi-info-circle me-1"></i>
                                                O sistema entende frases naturais e busca documentos automaticamente
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>
                        <hr>

                        <div class="latest-publications">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0">Últimas Publicações</h5>
                                <div>
                                    <button class="btn btn-outline-primary btn-sm me-2 carousel-prev"
                                        id="carouselPrev">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm carousel-next"
                                        id="carouselNext">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="publicationsCarousel" class="carousel slide" data-bs-ride="carousel"
                                data-bs-interval="4000">
                                <div class="carousel-inner">
                                    <?php
                                    $post_types = explode(',', get_option('portal_input_7'));
                                    $post_icon = explode(',', get_option('portal_input_8'));
                                    $posts_data = [];
                                    function retorna_icon($post_types, $post_icon, $post_type)
                                    {
                                        $posicao = array_search($post_type, $post_types);
                                        if ($posicao !== false && isset($post_icon[$posicao])) {
                                            return $post_icon[$posicao];
                                        }
                                        return '';
                                    }

                                    // Coleta todos os posts
                                    foreach ($post_types as $post_type):
                                        $args = [
                                            'post_type' => $post_type,
                                            'posts_per_page' => 1,
                                            'post_status' => 'publish',
                                        ];
                                        $query = new WP_Query($args);
                                        if ($query->have_posts()):
                                            while ($query->have_posts()):
                                                $query->the_post();
                                                $posts_data[] = [
                                                    'post_type' => $post_type,
                                                    'post_type_label' => get_post_type_object($post_type)->labels->singular_name,
                                                    'permalink' => get_permalink(),
                                                    'title' => get_the_title(),
                                                    'time_ago' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás',
                                                    'icon' => retorna_icon($post_types, $post_icon, $post_type)
                                                ];
                                            endwhile;
                                        endif;
                                        wp_reset_postdata();
                                    endforeach;

                                    // Divide os posts em grupos de 2 para o carousel
                                    $chunked_posts = array_chunk($posts_data, 2);
                                    $is_first = true;

                                    foreach ($chunked_posts as $post_group):
                                        ?>
                                        <div class="carousel-item <?php echo $is_first ? 'active' : ''; ?>">
                                            <div class="row">
                                                <?php foreach ($post_group as $post_data): ?>
                                                    <div class="col-6">
                                                        <div class="card border-0 shadow h-100 publication-card">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <div
                                                                        class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                                        <i
                                                                            class="<?php echo $post_data['icon']; ?>"></i>
                                                                    </div>
                                                                    <span
                                                                        class="badge bg-light text-dark"><?php echo esc_html($post_data['post_type_label']); ?></span>
                                                                </div>
                                                                <h6 class="card-title">
                                                                    <a href="<?php echo esc_url($post_data['permalink']); ?>"
                                                                        class="text-dark text-decoration-none">
                                                                        <?php echo $post_data['title']; ?>
                                                                    </a>
                                                                </h6>
                                                                <div class="text-muted small mt-2">
                                                                    <i class="bi bi-clock me-1"></i>
                                                                    <?php echo $post_data['time_ago']; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php
                                        $is_first = false;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Front BOXs Section -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Configuração dos botões do carousel
            const carousel = new bootstrap.Carousel(document.getElementById('publicationsCarousel'), {
                interval: 4000,
                wrap: true
            });

            // Botão anterior
            document.getElementById('carouselPrev').addEventListener('click', function () {
                carousel.prev();
            });

            // Botão próximo
            document.getElementById('carouselNext').addEventListener('click', function () {
                carousel.next();
            });

            // Pausa o carousel quando o mouse está sobre ele
            const carouselElement = document.getElementById('publicationsCarousel');
            carouselElement.addEventListener('mouseenter', function () {
                carousel.pause();
            });

            // Retoma o carousel quando o mouse sai
            carouselElement.addEventListener('mouseleave', function () {
                carousel.cycle();
            });

            // Swipe para o carrossel em dispositivos móveis
            if (carouselElement && window.innerWidth <= 768) {
                let touchStartX = 0;
                let touchEndX = 0;

                carouselElement.addEventListener('touchstart', function (e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, false);

                carouselElement.addEventListener('touchend', function (e) {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, false);

                function handleSwipe() {
                    const swipeThreshold = 50;

                    if (touchEndX < touchStartX - swipeThreshold) {
                        // Swipe para esquerda - próximo
                        document.getElementById('carouselNext').click();
                    }

                    if (touchEndX > touchStartX + swipeThreshold) {
                        // Swipe para direita - anterior
                        document.getElementById('carouselPrev').click();
                    }
                }
            }

            // Controle do checkbox "Todos" (apenas para Busca Avançada)
            const checkboxTodos = document.getElementById('chk_todos');
            
            if (checkboxTodos) {
                // Adiciona evento de clique no checkbox "Todos"
                checkboxTodos.addEventListener('change', function() {
                    // Seleciona todos os checkboxes exceto o próprio "Todos"
                    const checkboxesTipos = document.querySelectorAll('#busca-avancada-pane .tipos-container input[name="tipos[]"]');
                    
                    // Marca ou desmarca todos os checkboxes conforme o estado do "Todos"
                    checkboxesTipos.forEach(function(checkbox) {
                        checkbox.checked = checkboxTodos.checked;
                    });
                    
                    // Se estiver desmarcando o "Todos", também desmarca o congrega se estava marcado por padrão
                    if (!checkboxTodos.checked) {
                        const checkboxCongrega = document.querySelector('#busca-avancada-pane input[name="tipos[]"][value="congrega"]');
                        if (checkboxCongrega) {
                            checkboxCongrega.checked = false;
                        }
                    }
                });
                
                // Adiciona eventos nos checkboxes individuais para controlar o estado do "Todos"
                const checkboxesTipos = document.querySelectorAll('#busca-avancada-pane .tipos-container input[name="tipos[]"]');
                
                checkboxesTipos.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        // Verifica se todos os checkboxes estão marcados
                        const todosMarcados = Array.from(checkboxesTipos).every(cb => cb.checked);
                        
                        // Verifica se nenhum checkbox está marcado
                        const nenhumMarcado = Array.from(checkboxesTipos).every(cb => !cb.checked);
                        
                        // Atualiza o estado do checkbox "Todos"
                        if (todosMarcados) {
                            checkboxTodos.checked = true;
                            checkboxTodos.indeterminate = false;
                        } else if (nenhumMarcado) {
                            checkboxTodos.checked = false;
                            checkboxTodos.indeterminate = false;
                        } else {
                            // Alguns estão marcados, outros não (estado indeterminado)
                            checkboxTodos.checked = false;
                            checkboxTodos.indeterminate = true;
                        }
                    });
                });
                
                // Verifica o estado inicial dos checkboxes
                const checkboxesTiposArray = Array.from(checkboxesTipos);
                const todosMarcadosInicial = checkboxesTiposArray.every(cb => cb.checked);
                const nenhumMarcadoInicial = checkboxesTiposArray.every(cb => !cb.checked);
                
                // Configura o estado inicial do checkbox "Todos"
                if (todosMarcadosInicial) {
                    checkboxTodos.checked = true;
                } else if (!nenhumMarcadoInicial) {
                    checkboxTodos.indeterminate = true;
                }
                
                // Adiciona estilo visual para o estado indeterminado
                const style = document.createElement('style');
                style.textContent = `
                    input[type="checkbox"]:indeterminate {
                        background-color: #0d6efd;
                        border-color: #0d6efd;
                    }
                    input[type="checkbox"]:indeterminate::before {
                        content: "—";
                        display: block;
                        color: white;
                        text-align: center;
                        font-weight: bold;
                        line-height: 1.2;
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Salvar a aba ativa no localStorage
            const searchModeTabs = document.querySelectorAll('#searchModeTabs button[data-bs-toggle="tab"]');
            
            searchModeTabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function (event) {
                    const activeTab = event.target.id;
                    localStorage.setItem('activeSearchTab', activeTab);
                });
            });
            
            // Restaurar a aba ativa ao carregar a página
            const activeTab = localStorage.getItem('activeSearchTab');
            if (activeTab) {
                const tabElement = document.getElementById(activeTab);
                if (tabElement) {
                    const tab = new bootstrap.Tab(tabElement);
                    tab.show();
                }
            }
            
            // Foco automático no campo de consulta quando mudar para a aba de Modo Consulta
            document.getElementById('modo-consulta-tab').addEventListener('shown.bs.tab', function () {
                setTimeout(() => {
                    const consultaInput = document.getElementById('consulta');
                    if (consultaInput) {
                        consultaInput.focus();
                    }
                }, 300);
            });
            
            // Foco automático no campo de busca quando mudar para a aba de Busca Avançada
            document.getElementById('busca-avancada-tab').addEventListener('shown.bs.tab', function () {
                setTimeout(() => {
                    const searchInput = document.getElementById('search');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }, 300);
            });
            
            // Ajustes para dispositivos móveis
            if (window.innerWidth <= 768) {
                const searchInputs = [document.getElementById('search'), document.getElementById('consulta')];
                
                searchInputs.forEach(input => {
                    if (input) {
                        input.addEventListener('focus', function () {
                            // Adiciona classe para indicar foco
                            this.parentElement.classList.add('focused');
                            // Scroll suave para o input se necessário
                            setTimeout(() => {
                                this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }, 300);
                        });

                        input.addEventListener('blur', function () {
                            this.parentElement.classList.remove('focused');
                        });
                    }
                });
            }
            
            // Sugestões automáticas para o Modo Consulta
            const consultaInput = document.getElementById('consulta');
            if (consultaInput) {
                consultaInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        const form = this.closest('form');
                        if (form) {
                            form.submit();
                        }
                    }
                });
            }
        });
    </script>

</main><!-- End #main -->

<?php get_footer(); ?>