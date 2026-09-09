<?php
// Arquivo: wp-content/themes/novoicode/page-novo.php
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

// Obtém o tipo, a categoria e o novoid da URL
$tipo = $_GET['tipo'];
$cat = $_GET['cat'];
$novoid = $_GET['novoid'];

// Verifica se o tipo foi passado e é válido
if (!$tipo || !$novoid) {
    echo '<div class="alert alert-danger">Tipo de post ou novo ID não especificado.</div>';
    get_footer();
    exit;
}

?>

<main id="main" class="main">

    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Criar Reunião:&ensp;<?php echo print_type($tipo,'nome') . " - " . $cat; ?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Criar Post</li>
                </ol>
            </nav>
        </div>
        <div class="btn-editors">
            <a class="btn btn-light" href="/<?php echo $tipo . '/' . $cat ?>"><i
                    class="bi bi-skip-backward-fill"></i>&ensp;Voltar</a>&emsp;
        </div>
    </div>

    <section class="section">

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
        </style>

        <div class="row">

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="editar_post">
                <input type="hidden" name="id" value="<?php echo $novoid; ?>">
                <input type="hidden" name="tipo" value="<?php echo esc_attr($tipo); ?>">
                <input type="hidden" name="cat" value="<?php echo esc_attr($cat); ?>">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label"><strong>Título do Post</strong></label>
                                    <input type="text" placeholder="" id="titulo" name="titulo" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label for="data" class="form-label"><strong>Data da Reunião</strong></label>
                                    <input id="data" type="datetime-local" class="form-control"
                                        name="<?php echo $tipo; ?>_date" required />
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
                                    <input type="text" name="slug" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <?php
                            $value_member = do_shortcode('[icapi tipo="composicao_' . $tipo . '" saida="html/?modo=short"]');
                            ?>
                            <div class="mb-3">
                                <label class="form-label"><strong>Membros</strong></label>
                                <textarea id="membro" name="member"><?php echo $value_member; ?></textarea>
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
                                    name="conteudo"><?php echo esc_textarea($post->post_content); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary"><i
                                        class="bi bi-floppy"></i>&emsp;Salvar&emsp;</button>
                                <small>( Depois de <b>Salvar</b>, o sistema criará a estrutura de diretórios do post e
                                    você poderá anexar os documentos )</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

</main>

<script src="/wp-content/themes/novoicode/assets/vendor/ckeditor/ckeditor.js"></script>

<script>

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
        });

        // Inicializar CKEditor 4 no campo "conteudo"
        CKEDITOR.replace('conteudo', {            
            contentsCss: '/wp-content/themes/novoicode/assets/css/style.css',
            bodyClass: 'conteudo-editor',
            extraPlugins: 'justify,autogrow',
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
        });

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