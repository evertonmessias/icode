<?php get_header(); ?>

<?php
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}
?>

<?php
$current_user = wp_get_current_user();
$saved_aceite = get_user_meta($current_user->ID, 'aceite', true);

if (empty($saved_aceite)) {
    ?>
    <div class="container">
        <style>
            #aceite {
                transform: scale(1.5);
            }
        </style>
        <div class="row">
            <div class="col-lg-12"><br><br><br>
                <div class="card mb-3">
                    <div class="card-body">
                        <br>
                        <?php echo get_option('portal_input_5'); ?>                 
                        <hr>
                        <br>
                        <form method="post">
                            <p>Obs.: Você receberá um email de confirmação em
                                <b><?php echo $current_user->user_email; ?></b>
                            </p>
                            <br>
                            <div class="d-flex gap-3">
                                <button class="btn btn-success" name="btn_save" value="1">Continuar</button>
                            </div>
                        </form>


                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['btn_save'])) {
        $aceite_valor = $_POST['btn_save'];
        update_user_meta($current_user->ID, 'aceite', $aceite_valor);

        $conteudo = get_option('portal_input_5');

        $para = $current_user->user_email;
        $assunto = 'Confirmação de criação de conta';
        $mensagem = wpautop("<h4>Usuário: " . $current_user->user_email . "</h4><br>" . $conteudo);
        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'Cc: icti@unicamp.br'
        ];

        wp_mail($para, $assunto, $mensagem, $headers);

        if ($aceite_valor === '1') {
            $redirect_to = $_SESSION['ldap_login_redirect'];
            error_log('Redirecionando para :' . $redirect_to);
            echo '<script>window.location.href = "' . $redirect_to . '";</script>';
        } else {
            wp_logout();
            echo '<script>window.location.href = "/login";</script>';
        }
        exit;
    }


} else {

    $username = $current_user->user_login;
    registerdb($username, $_SERVER['REMOTE_ADDR'], $_SERVER['REQUEST_URI']);

    $tipos_membro_usuario = get_user_meta($current_user->ID, 'membro', true);
    $membro = is_array($tipos_membro_usuario) && !empty($tipos_membro_usuario) ? implode(', ', $tipos_membro_usuario) : '';

    $membro_post_privado = get_user_meta(wp_get_current_user()->ID, 'membro_post_privado', true);
    $tipos_membro_post_privado = is_array($membro_post_privado) && !empty($membro_post_privado) ? implode(', ', $membro_post_privado) : '';

    $membro_arquivo_privado = get_user_meta(wp_get_current_user()->ID, 'membro_arquivo_privado', true);
    $tipos_membro_arquivo_privado = is_array($membro_arquivo_privado) && !empty($membro_arquivo_privado) ? implode(', ', $membro_arquivo_privado) : '';

    $avatar_id = get_user_meta($current_user->ID, 'wp_user_avatar', true);
    $current_user_avatar = $avatar_id ? wp_get_attachment_url($avatar_id) : get_avatar_url($current_user->ID);

    ?>

    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-person"></i>&ensp;Perfil do Usuário</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><a
                                href="/<?php echo url_active()[1]; ?>"><?php echo url_active()[1]; ?></a></li>
                        <li class="breadcrumb-item active"><a
                                href="/<?php echo url_active()[1] . '/' . url_active()[2]; ?>"><?php echo url_active()[2]; ?></a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="btn-editors">
                <a class="btn btn-light" href="/"><i class="bi bi-skip-backward-fill"></i>&ensp;Voltar</a>&emsp;
            </div>
        </div>

        <section class="section">
            <style>
                ul.triangulo {
                    list-style: none;
                    padding-left: 1em;
                }

                ul.triangulo li::before {
                    content: "►";
                    color: #000;
                    display: inline-block;
                    width: 1em;
                    margin-left: -1em;
                }

                ul.triangulo li ul {
                    list-style: none;
                    padding-left: 1.5em;
                    margin-top: 0.3em;
                }

                ul.triangulo li ul li::before {
                    content: "●";
                    color: #000;
                    display: inline-block;
                    width: 1em;
                    margin-left: -1em;
                }

                ul.triangulo li strong {
                    color: #000;
                }
            </style>

            <div class="row">
                <!-- INFORMAÇÕES -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="perfil-container">
                                <h4 class="card-title">Perfil de:
                                    <strong><?php echo $current_user->display_name; ?></strong>
                                </h4>
                                <br>

                                <ul class="triangulo">
                                    <li><strong>Nome:</strong> <?php echo $current_user->user_firstname; ?></li>
                                    <li><strong>Sobrenome:</strong> <?php echo $current_user->user_lastname; ?></li>
                                    <li><strong>Email:</strong> <?php echo $current_user->user_email; ?></li>
                                    <li><strong>Papel:</strong>
                                        <?php echo traduz_papel(implode(', ', $current_user->roles)); ?></li>
                                    <li>
                                        <strong>Membro:</strong> <?php echo $membro; ?>
                                        <?php if (!empty($tipos_membro_post_privado) || !empty($tipos_membro_arquivo_privado)) { ?>
                                            <ul>
                                                <?php if (!empty($tipos_membro_post_privado)) { ?>
                                                    <li><strong>Posts Privados:</strong> <?php echo $tipos_membro_post_privado; ?>
                                                    </li>
                                                <?php } ?>
                                                <?php if (!empty($tipos_membro_arquivo_privado)) { ?>
                                                    <li><strong>Arquivos Privados:</strong>
                                                        <?php echo $tipos_membro_arquivo_privado; ?></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                </ul>
                                <br>
                                <p><a class="btn btn-primary"
                                        href="<?php echo esc_url(site_url('?icode_logout=1')); ?>">&ensp;Sair&ensp;</a></p>
                            </div>
                            <div class="avatar-container">
                                <img src="<?php echo esc_url($current_user_avatar); ?>" alt="Avatar" class="rounded-circle"
                                    style="width: 100px; height: 100px; border: 3px solid #ddd;">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ALTERAR PERFIL -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <div class="alterar-perfil">
                                <h4 class="card-title">Alterar Perfil</h4>
                                <form method="post" enctype="multipart/form-data" class="mt-4">
                                    <input type="hidden" name="action" value="atualizar_perfil_usuario">
                                    <div class="mb-3">
                                        <input type="text" placeholder="Nome" name="novo_nome" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" placeholder="Sobrenome" name="novo_sobrenome"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="novo_avatar" class="form-control">
                                        <small class="form-text text-muted">Escolha uma imagem para seu Avatar (jpg, jpeg,
                                            png)</small>
                                    </div><br>
                                    <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                                </form> <br>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </section>
    </main>

<?php } ?>

<script>

    document.querySelector(".alterar-perfil form").addEventListener("submit", function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            body: formData,
        }).then(res => res.json())
            .then(data => {
                const alertContainer = document.createElement("div");
                alertContainer.classList.add("mt-3");

                if (data.success) {
                    alertContainer.innerHTML = `<div class="alert alert-info">${data.data.message}</div>`;
                    if (data.data.avatar_url) {
                        document.querySelector(".avatar-container img").src = data.data.avatar_url;
                    }
                } else {
                    alertContainer.innerHTML = `<div class="alert alert-danger">${data.data.message}</div>`;
                }

                form.after(alertContainer);
                setTimeout(() => alertContainer.remove(), 5000);
            });
    });

</script>

<?php get_footer(); ?>