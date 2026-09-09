<?php
// Arquivo: wp-content/themes/novoicode/page-editar.php
get_header();
?>
<?php if (get_user_meta(wp_get_current_user()->ID, 'aceite', true) == false)
    echo '<script>window.location.href = "/perfil";</script>'; ?>

<?php

$current_user = wp_get_current_user();
$allowed_roles = ['administrator', 'editor']; // Permitir apenas Admins e Editores

if (!array_intersect($allowed_roles, $current_user->roles)) {
    wp_redirect('/404');
    exit;
}

// Registra acesso no banco (caso tenha essa função no seu tema)
registerdb($current_user->user_login, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);

if (!isset($_GET['id'])) {
    echo '<div class="alert alert-danger">ID não especificado.</div>';
    get_footer();
    exit;
}

$post = get_post(intval($_GET['id']));

if (!$post) {
    echo '<div class="alert alert-danger">Post não encontrado.</div>';
    get_footer();
    exit;
}

$tipo = get_post_type($post->ID);
$cat = get_the_category($post->ID)[0]->name;

$base_dir = ABSPATH . "wp-content/uploads/$tipo/$cat/{$post->ID}";

$arquivos = [];
$urls = [];

if (file_exists($base_dir)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base_dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $arquivo) {
        if (pathinfo($arquivo, PATHINFO_EXTENSION) === 'pdf') {
            $arquivos[] = (string) $arquivo;
            $subpath = str_replace(ABSPATH, '', (string) $arquivo);
            $url_pdf = '/' . str_replace('\\', '/', $subpath);
            $urls[] = esc_url($url_pdf);
        }
    }
}

?>

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Editar Post do Tipo: <?php echo print_type($tipo,'nome'); ?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Editar Post</li>
                </ol>
            </nav>
        </div>
        <div class="btn-editors">
            <a class="btn btn-light" href="/<?php echo $tipo . '/' . $cat ?>"><i
                    class="bi bi-skip-backward-fill"></i>&ensp;Voltar</a>&emsp;
            <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-secondary"><i
                    class="bi bi-eye"></i>&ensp;Ver Post</a>
        </div>
    </div>

    <section class="section page-editar">

        <style>
            .box-privado {
                padding-top: 25px;
                text-align: center;
            }

            .privado-toggle {
                display: block;
                margin-top: -10px;
                font-size: 2.1rem;
                cursor: pointer;
                user-select: none;
                transition: color 0.3s;
            }

            .privado-toggle.locked {
                color: #c00;
            }

            .privado-toggle.unlocked {
                color: #000;
            }

            #privado {
                display: none;
            }

            .cgerenciador {
                background: #666;
                margin-bottom: 5px;
                color: #fff;
                padding-top: 20px;
            }
        </style>

        <div class="row">

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="editar_post">
                <input type="hidden" name="id" value="<?php echo $post->ID; ?>">
                <input type="hidden" name="tipo" value="<?php echo esc_attr($tipo); ?>">
                <input type="hidden" name="cat" value="<?php echo esc_attr($cat); ?>">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Título</strong></label>
                                    <input type="text" placeholder="Coloque data para facilitar a busca" id="titulo"
                                        name="titulo" class="form-control"
                                        value="<?php echo esc_attr($post->post_title); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label for="data" class="form-label"><strong>Data da Reunião</strong></label>
                                    <input type="datetime-local" class="form-control" name="<?php echo $tipo; ?>_date"
                                        value="<?php echo get_post_meta($post->ID, $tipo . '_date', true); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="box-privado mb-3">
                                    <label class="form-label"><strong>Privado</strong></label>
                                    <?php $value = get_post_meta($post->ID, $tipo . '_privado', true); ?>
                                    <input type="checkbox" id="privado" name="<?php echo $tipo; ?>_privado" value="1"
                                        <?php checked($value, '1'); ?> />

                                    <i id="togglePrivado"
                                        class="privado-toggle bi <?php echo $value == '1' ? 'bi-lock-fill locked' : 'bi-unlock-fill unlocked'; ?>"
                                        title="Post Privado">
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Link Permanente</strong></label>
                                <div class="input-group">
                                    <span
                                        class="input-group-text"><?php echo esc_url(home_url('/')) . $tipo . '/' . $cat . '/'; ?></span>
                                    <input type="text" name="slug" class="form-control"
                                        value="<?php echo esc_attr($post->post_name); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <?php
                            if (get_post_meta($post->ID, $tipo . '_member', true) == "") {
                                $value_member = do_shortcode('[icapi tipo="composicao_' . $tipo . '" saida="html/?modo=short"]');
                            } else {
                                $value_member = get_post_meta($post->ID, $tipo . '_member', true);
                            }
                            $membros = apply_filters('the_content', $value_member);

                            ?>
                            <div class="mb-3">
                                <label class="form-label"><strong>Membros</strong></label>
                                <textarea id="membro"
                                    name="<?php echo $tipo; ?>_member"><?php echo $membros; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Conteúdo</strong></label>
                                <textarea id="conteudo"
                                    name="conteudo"><?php echo apply_filters('the_content', $post->post_content); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i>&ensp;Salvar
                                    Alterações</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <br>

        <?php
        if (is_dir($base_dir)) { ?>

            <hr><br><br>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card cgerenciador">
                        <div class="card-body">
                            <strong style="color:#fff;">Gerenciador de Anexos</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <iframe
                        src="/arquivos?tipo=<?php echo $tipo; ?>&ano=<?php echo $cat; ?>&post_id=<?php echo $post->ID; ?>"
                        style="width: 100%; height: 600px; border: none;"></iframe>
                </div>
            </div>
            <br><br><br>

            <!-- Modal para seleção de PDF -->
            <div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="modalArquivosLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Inserir PDF no Post</h5>
                            <button type="button" title="Fechar" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe id="iframeArquivos"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal resposta para correção de links -->
            <div class="modal fade" id="modalCorrecao" tabindex="-1" aria-labelledby="modalCorrecaoLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Correção de Links PDF no Post</h5>
                            <button type="button" title="Fechar" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div class="modal-body p-0">
                            <!-- RESPOSTA AQUI, TIRAR O ALERT E COLOCAR A RESPOSTA AQUI -->
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-4">
                    <strong>Revisões</strong>
                    <br> <br>
                    <?php
                    $revisions = wp_get_post_revisions($post->ID);

                    if (!empty($revisions)) {
                        echo '<ul>';
                        foreach ($revisions as $revision) {
                            $autor = get_the_author_meta('display_name', $revision->post_author);
                            $data = get_the_date('d/m/Y H:i', $revision);
                            echo '<li>';
                            echo '<strong>' . esc_html($autor) . '</strong> em ' . esc_html($data);
                            //echo ' — <a href="' . esc_url(get_edit_post_link($revision->ID)) . '">Ver revisão</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>Nenhuma revisão disponível.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </section>

</main>

<script src="/wp-content/themes/novoicode/assets/vendor/ckeditor/ckeditor.js"></script>

<script>

    // CKEDITOR
    document.addEventListener('DOMContentLoaded', function () {

        // Inicializar CKEditor 4 no campo "membro"
        CKEDITOR.replace('membro', {
            contentsCss: '/wp-content/themes/novoicode/assets/css/style.css',
            bodyClass: 'conteudo-editor',
            extraPlugins: 'autogrow',
            autoGrow_maxHeight: Infinity,
            removePlugins: 'resize',
            toolbar: [
                ['Bold', 'Italic', '-', 'Undo', 'Redo']
            ],
            on: {
                instanceReady: function (evt) {
                    evt.editor.execCommand('autogrow');
                }
            }
        });


        // Inicializar CKEditor 4 no campo "conteudo"
        CKEDITOR.replace('conteudo', {
            allowedContent: true,
            contentsCss: [
                '/wp-content/themes/novoicode/assets/css/style.css',
                '/wp-content/themes/novoicode/assets/css/novoicode.css',
                'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'
            ],
            bodyClass: 'conteudo-editor',
            extraPlugins: 'inserirpdf,corrigirlinks,justify,autogrow',
            autoGrow_maxHeight: Infinity,
            removePlugins: 'resize',
            toolbar: [
                { name: 'insert', items: ['InserirPDF', 'CorrigirLinks'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'] },
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'insert', items: ['Table'] },
                //{ name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                //{ name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                { name: 'about', items: ['-', 'Source'] },
            ],
            on: {
                instanceReady: function (evt) {
                    evt.editor.execCommand('autogrow');
                }
            }
        });

    });



    CKEDITOR.plugins.add('inserirpdf', {
        icons: 'inserirpdf',
        init: function (editor) {
            editor.addCommand('abrirModalPDF', {
                exec: function (editor) {
                    const tipo = '<?php echo $tipo; ?>';
                    const ano = '<?php echo $cat; ?>';
                    const postId = '<?php echo $post->ID; ?>';

                    const iframe = document.getElementById('iframeArquivos');
                    iframe.src = `/arquivos?tipo=${tipo}&ano=${ano}&post_id=${postId}&modo=selecionar`;

                    const modal = new bootstrap.Modal(document.getElementById('modalArquivos'));
                    modal.show();

                    window.addEventListener('message', function inserirPDFListener(event) {
                        if (event.origin !== window.location.origin) return;

                        const file = event.data;
                        if (file && file.name && file.url) {
                            const diretorio = file.url.split('/')[8];

                            let link;
                            if (diretorio === "privado") {
                                link = `<p><small class="itemprivado">(para membros)</small>&nbsp;<a href="${file.url}" target="_blank">${file.name}</a></p>`;
                            } else {
                                link = `<p><a href="${file.url}" target="_blank">${file.name}</a></p>`;
                            }

                            editor.insertHtml(link);
                            modal.hide();
                            window.removeEventListener('message', inserirPDFListener);
                        }
                    }, { once: true });
                }
            });

            editor.ui.addButton('InserirPDF', {
                label: 'Inserir PDF no Post',
                command: 'abrirModalPDF',
                toolbar: 'insert',
                icon: '/wp-content/themes/novoicode/assets/img/file-earmark-pdf.svg'
            });
        }
    });



    CKEDITOR.plugins.add('corrigirlinks', {
        icons: 'corrigirlinks',
        init: function (editor) {
            editor.addCommand('corrigirLinksArquivos', {
                exec: function (editor) {
                    const content = editor.getData();
                    const tipo = '<?php echo $tipo; ?>';
                    const ano = '<?php echo $cat; ?>';
                    const postId = '<?php echo $post->ID; ?>';

                    console.log('Iniciando correção de links...');
                    console.log('Tipo:', tipo, 'Ano:', ano, 'Post ID:', postId);

                    // Mostrar mensagem de processamento no modal
                    const modalBody = document.querySelector('#modalCorrecao .modal-body');
                    modalBody.innerHTML = '<div class="p-4"><div class="d-flex align-items-center"><div class="spinner-border text-primary me-3" role="status"><span class="visually-hidden">Carregando...</span></div><p class="mb-0">Processando e corrigindo links de arquivos... Aguarde.</p></div></div>';

                    // Abrir o modal
                    const modal = new bootstrap.Modal(document.getElementById('modalCorrecao'));
                    modal.show();

                    // Preparar os dados para a requisição
                    const formData = new URLSearchParams();
                    formData.append('action', 'corrigir_links_arquivos');
                    formData.append('post_id', postId);
                    formData.append('tipo', tipo);
                    formData.append('ano', ano);
                    formData.append('conteudo', content);

                    console.log('Enviando requisição para o servidor...');

                    // Enviar solicitação para o servidor
                    fetch('/wp-admin/admin-ajax.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        },
                        body: formData,
                        credentials: 'same-origin'
                    })
                        .then(response => {
                            console.log('Resposta recebida, status:', response.status);
                            if (!response.ok) {
                                throw new Error('Erro na resposta do servidor: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Dados recebidos:', data);

                            if (data && typeof data.changes !== 'undefined') {
                                if (data.changes > 0) {
                                    editor.setData(data.content);
                                    // Atualizar modal com sucesso
                                    modalBody.innerHTML = `
                                    <div class="p-4">
                                        <div class="alert alert-success d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                                            <div>
                                                <h5 class="alert-heading mb-2">Links corrigidos com sucesso!</h5>
                                                <p class="mb-0">${data.changes} links foram atualizados.</p>
                                                <p class="mb-0 mt-2"><strong>Não esqueça de salvar as alterações.</strong></p>
                                            </div>
                                        </div>
                                        <div class="d-grid mt-3">
                                            <button class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                `;
                                } else {
                                    editor.setData(content); // Restaurar conteúdo original
                                    // Atualizar modal com aviso
                                    modalBody.innerHTML = `
                                    <div class="p-4">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                                            <div>
                                                <h5 class="alert-heading mb-2">Nenhuma alteração necessária</h5>
                                                <p class="mb-0">Nenhum link para corrigir foi encontrado ou os links já estão atualizados.</p>
                                            </div>
                                        </div>
                                        <div class="d-grid mt-3">
                                            <button class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                `;
                                }
                            } else {
                                throw new Error('Resposta do servidor inválida');
                            }
                        })
                        .catch(error => {
                            console.error('Erro na requisição:', error);
                            editor.setData(content); // Restaurar conteúdo original
                            // Atualizar modal com erro
                            modalBody.innerHTML = `
                            <div class="p-4">
                                <div class="alert alert-danger d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                                    <div>
                                        <h5 class="alert-heading mb-2">Erro ao corrigir links</h5>
                                        <p class="mb-0">${error.message}</p>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        `;
                        });
                }
            });

            editor.ui.addButton('CorrigirLinks', {
                label: 'Corrigir Links de Arquivos',
                command: 'corrigirLinksArquivos',
                toolbar: 'insert',
                icon: '/wp-content/themes/novoicode/assets/img/gear.svg'
            });
        }
    });


    document.addEventListener('DOMContentLoaded', function () {

        const checkbox = document.getElementById('privado');
        const icon = document.getElementById('togglePrivado');

        icon.addEventListener('click', function () {
            checkbox.checked = !checkbox.checked;
            icon.classList.remove('bi-lock-fill', 'bi-unlock-fill', 'locked', 'unlocked');
            if (checkbox.checked) {
                icon.classList.add('bi-lock-fill', 'locked');
            } else {
                icon.classList.add('bi-unlock-fill', 'unlocked');
            }
        });

        // Link Permanente Automatico
        const titulo = document.getElementById('titulo');
        const slug = document.querySelector('input[name="slug"]');
        function gerarSlug(texto) {
            return texto
                .toLowerCase()
                .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
        function sugerirSlug() {
            if (slug.value.trim() === '') {
                const textoTitulo = titulo.value;
                const slugSugerido = gerarSlug(textoTitulo);
                slug.value = slugSugerido;
            }
        }
        slug.addEventListener('focus', sugerirSlug);
        titulo.addEventListener('blur', sugerirSlug);

    });

</script>

<?php get_footer(); ?>