<?php
// Arquivo: wp-content/plugins/novoicode/includes/src/usermeta.php

// Miscelânea de USER ***********************************************************************************************


// ************* Retorna Avatar
function retornaPhoto($email)
{
    $photo_url = "";

    // Busca em docentes
    $docentes = json_decode(lista_docentes_intranet(), true);
    foreach ($docentes as $docente) {
        if (isset($docente['email']) && $docente['email'] === $email) {
            return $docente['photo_url'] ?? "";
        }
    }

    // Busca em funcionários
    $funcionarios = json_decode(lista_funcionarios_intranet(), true);
    foreach ($funcionarios as $funcionario) {
        if (isset($funcionario['email']) && $funcionario['email'] === $email) {
            return $funcionario['photo_url'] ?? "";
        }
    }

    return $photo_url;
}
add_action("retornaPhoto", "retornaPhoto");



// ************* Importar Avatar imagem para midia
function importar_imagem_para_midia($image_url, $user_id)
{
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $tmp = download_url($image_url);
    if (is_wp_error($tmp))
        return false;

    $file_array = [
        'name' => basename(parse_url($image_url, PHP_URL_PATH)),
        'tmp_name' => $tmp
    ];

    $attachment_id = media_handle_sideload($file_array, 0);
    if (is_wp_error($attachment_id)) {
        @unlink($tmp);
        return false;
    }

    return $attachment_id;
}


// ********** custom_user_avatar_if_available
function custom_user_avatar_if_available($avatar, $id_or_email, $size, $default, $alt)
{
    $user = false;

    if (is_numeric($id_or_email)) {
        $user = get_user_by('id', $id_or_email);
    } elseif (is_object($id_or_email) && isset($id_or_email->user_id)) {
        $user = get_user_by('id', $id_or_email->user_id);
    } elseif (is_string($id_or_email)) {
        $user = get_user_by('email', $id_or_email);
    }

    if ($user) {
        $avatar_id = get_user_meta($user->ID, 'wp_user_avatar', true);
        if ($avatar_id) {
            $avatar_url = wp_get_attachment_image_url($avatar_id, 'thumbnail');
            if ($avatar_url) {
                return "<img alt='" . esc_attr($alt) . "' src='" . esc_url($avatar_url) . "' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
            }
        }
    }

    return $avatar;
}
add_filter('get_avatar', 'custom_user_avatar_if_available', 10, 5);



// *************** Papel do Usuário
function papel_usuario($email)
{
    $emails_editores = array_map('strtolower', (array) get_option('portal_input_2', []));
    $emails_admin = array_map('strtolower', (array) get_option('portal_input_4', []));

    if (in_array($email, $emails_admin, true)) {
        return 'administrator';
    } elseif (in_array($email, $emails_editores, true)) {
        return 'editor';
    }

    return 'subscriber';
}
add_action('papel_usuario', 'papel_usuario');



// ************************** Tradução Roles/Papel
function traduz_papel($role)
{
    $traducoes = [
        'administrator' => 'Administrador',
        'editor' => 'Editor',
        'subscriber' => 'Assinante'
    ];

    return $traducoes[$role] ?? $role;
}
add_action('traduz_papel', 'traduz_papel');



// ************************** Permite URL
function permite_url($url, $user_id)
{
    $partes_url = explode("/", $url);
    $url_membro = $partes_url[5] ?? '';
    $url_membro_arquivo_privado = $partes_url[8] ?? '';

    $grupo_user_membro = (array) get_user_meta($user_id, 'membro', true);
    $grupo_user_privado = (array) get_user_meta($user_id, 'membro_arquivo_privado', true);

    $tem_acesso_membro = in_array($url_membro, $grupo_user_membro, true);
    $tem_acesso_privado = in_array($url_membro, $grupo_user_privado, true);

    if ($url_membro_arquivo_privado === 'privado') {
        $permitido = $tem_acesso_membro && $tem_acesso_privado;
    } else {
        $permitido = $tem_acesso_membro;
    }

    $log_msg = $permitido ? "Permitido OK para " : "Permissão Negada para ";
    $log_msg .= get_userdata($user_id)->user_login;
    error_log($log_msg);

    return $permitido;
}
add_action('permite_url', 'permite_url');


// Função auxiliar para obter tipos dinamicamente
function get_tipos_membro_dinamicos($tipo = 'membro')
{
    $slugs_array = explode(',', get_option('portal_input_7'));
    $slugs_array = array_map('trim', $slugs_array);
    $nomes_array = explode(',', get_option('portal_input_6'));
    $nomes_array = array_map('trim', $nomes_array);

    $tipos = [];

    foreach ($slugs_array as $index => $slug) {
        if (!empty($slug)) {
            $nome = isset($nomes_array[$index]) ? $nomes_array[$index] : ucfirst($slug);

            switch ($tipo) {
                case 'membro':
                    $tipos[$slug] = $nome;
                    break;
                case 'post_privado':
                    $tipos[$slug] = 'Acesso a posts privados do ' . $nome;
                    break;
                case 'arquivo_privado':
                    $tipos[$slug] = 'Acesso a arquivos privados do ' . $nome;
                    break;
            }
        }
    }

    return $tipos;
}

/**
 * Adiciona um campo "Membro" (checkboxes) ao perfil do usuário.
 */
function adicionar_campo_membro_perfil_checkbox($user)
{
    $tipos_membro = get_tipos_membro_dinamicos('membro');
    $membros_usuario = get_user_meta($user->ID, 'membro', true);
    if (!is_array($membros_usuario)) {
        $membros_usuario = array(); // Garante que seja um array mesmo que não haja valores salvos
    }
    ?>

    <br>
    <hr>

    <h3>Informações de <u>Membro</u></h3>

    <table class="form-table">
        <tr>
            <th>Tipos de Membro</th>
            <td>
                <?php foreach ($tipos_membro as $slug => $nome): ?>
                    <label for="membro_<?php echo esc_attr($slug); ?>">
                        <input
                            style="border:1px solid #444;pointer-events: none;opacity: 1 !important;accent-color: #0066cc;cursor: default;"
                            type="checkbox" disabled name="membro[]" id="membro_<?php echo esc_attr($slug); ?>"
                            value="<?php echo esc_attr($slug); ?>" <?php checked(in_array($slug, $membros_usuario)); ?> />
                        <?php echo esc_html($nome); ?>
                    </label><br />
                <?php endforeach; ?>
                <br><span class="description">(seleção automática, fonte: Intranet)</span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'adicionar_campo_membro_perfil_checkbox');
add_action('edit_user_profile', 'adicionar_campo_membro_perfil_checkbox');


function salvar_campo_membro_perfil_checkbox($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return;
    }
    if (isset($_POST['membro']) && is_array($_POST['membro'])) {
        $membros_sanitizados = array_map('sanitize_text_field', $_POST['membro']);
        update_user_meta($user_id, 'membro', $membros_sanitizados);
    } else {
        delete_user_meta($user_id, 'membro'); // Remove a meta se nenhum checkbox estiver selecionado
    }
}
add_action('personal_options_update', 'salvar_campo_membro_perfil_checkbox');
add_action('edit_user_profile_update', 'salvar_campo_membro_perfil_checkbox');


/**
 * Adiciona um campo "Membro Post Privado" (checkboxes) ao perfil do usuário. (quais 'posts privados' o membro pode ler)
 */
function adicionar_campo_membro_post_privado_perfil_checkbox($user)
{
    $tipos_membro_post_privado = get_tipos_membro_dinamicos('post_privado');
    $membro_post_privados_usuario = get_user_meta($user->ID, 'membro_post_privado', true);
    if (!is_array($membro_post_privados_usuario)) {
        $membro_post_privados_usuario = array(); // Garante que seja um array mesmo que não haja valores salvos
    }
    ?>

    <br>
    <hr>

    <h3>Informações de <u>Membro de <b>Posts</b> Privados</u></h3>

    <table class="form-table">
        <tr>
            <th><label><?php esc_html_e('Tipos de Membro'); ?></label></th>
            <td>
                <?php foreach ($tipos_membro_post_privado as $slug => $nome): ?>
                    <label for="membro_post_privado_<?php echo esc_attr($slug); ?>">
                        <input
                            style="border:1px solid #444;pointer-events: none;opacity: 1 !important;accent-color: #0066cc;cursor: default;"
                            type="checkbox" disabled name="membro_post_privado[]"
                            id="membro_post_privado_<?php echo esc_attr($slug); ?>" value="<?php echo esc_attr($slug); ?>" <?php checked(in_array($slug, $membro_post_privados_usuario)); ?> />
                        <?php echo esc_html($nome); ?>
                    </label><br />
                <?php endforeach; ?>
                <br><span class="description"><?php esc_html_e('(seleção automática, fonte: Intranet)'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'adicionar_campo_membro_post_privado_perfil_checkbox');
add_action('edit_user_profile', 'adicionar_campo_membro_post_privado_perfil_checkbox');

function salvar_campo_membro_post_privado_perfil_checkbox($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return;
    }
    if (isset($_POST['membro_post_privado']) && is_array($_POST['membro_post_privado'])) {
        $membro_post_privados_sanitizados = array_map('sanitize_text_field', $_POST['membro_post_privado']);
        update_user_meta($user_id, 'membro_post_privado', $membro_post_privados_sanitizados);
    } else {
        delete_user_meta($user_id, 'membro_post_privado'); // Remove a meta se nenhum checkbox estiver selecionado
    }
}
add_action('personal_options_update', 'salvar_campo_membro_post_privado_perfil_checkbox');
add_action('edit_user_profile_update', 'salvar_campo_membro_post_privado_perfil_checkbox');


/**
 * Adiciona um campo "Membro Arqvivo Privado" (checkboxes) ao perfil do usuário. (quais 'arquivos privados' o membro pode ler)
 */
function adicionar_campo_membro_arquivo_privado_perfil_checkbox($user)
{
    $tipos_membro_arquivo_privado = get_tipos_membro_dinamicos('arquivo_privado');
    $membro_arquivo_privados_usuario = get_user_meta($user->ID, 'membro_arquivo_privado', true);
    if (!is_array($membro_arquivo_privados_usuario)) {
        $membro_arquivo_privados_usuario = array(); // Garante que seja um array mesmo que não haja valores salvos
    }
    ?>

    <br>
    <hr>

    <h3>Informações de <u>Membro de <b>Arquivos</b> Privados</u></h3>

    <table class="form-table">
        <tr>
            <th><label>Tipos de Membro</label></th>
            <td>
                <?php foreach ($tipos_membro_arquivo_privado as $slug => $nome): ?>
                    <label for="membro_arquivo_privado_<?php echo esc_attr($slug); ?>">
                        <input
                            style="border:1px solid #444;pointer-events: none;opacity: 1 !important;accent-color: #0066cc;cursor: default;"
                            type="checkbox" disabled name="membro_arquivo_privado[]"
                            id="membro_arquivo_privado_<?php echo esc_attr($slug); ?>" value="<?php echo esc_attr($slug); ?>"
                            <?php checked(in_array($slug, $membro_arquivo_privados_usuario)); ?> />
                        <?php echo esc_html($nome); ?>
                    </label><br />
                <?php endforeach; ?>
                <br><span class="description"><?php esc_html_e('(seleção automática, fonte: Intranet)'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'adicionar_campo_membro_arquivo_privado_perfil_checkbox');
add_action('edit_user_profile', 'adicionar_campo_membro_arquivo_privado_perfil_checkbox');

function salvar_campo_membro_arquivo_privado_perfil_checkbox($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return;
    }
    if (isset($_POST['membro_arquivo_privado']) && is_array($_POST['membro_arquivo_privado'])) {
        $membro_arquivo_privados_sanitizados = array_map('sanitize_text_field', $_POST['membro_arquivo_privado']);
        update_user_meta($user_id, 'membro_arquivo_privado', $membro_arquivo_privados_sanitizados);
    } else {
        delete_user_meta($user_id, 'membro_arquivo_privado'); // Remove a meta se nenhum checkbox estiver selecionado
    }
}
add_action('personal_options_update', 'salvar_campo_membro_arquivo_privado_perfil_checkbox');
add_action('edit_user_profile_update', 'salvar_campo_membro_arquivo_privado_perfil_checkbox');


// ******************************************* Adiciona o campo "Aceite" ao perfil do usuário.
function adicionar_campo_aceite_perfil($user)
{
    $valor_aceite = get_user_meta($user->ID, 'aceite', true);
    ?>

    <br>
    <hr>

    <h3><?php esc_html_e('Termo de Aceite ICODE'); ?></h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="aceite"><strong><?php esc_html_e('Você concorda com todos os termos?'); ?></strong></label>
            </th>
            <td>
                <input type="checkbox" name="aceite" id="aceite" value="1" <?php checked($valor_aceite, '1'); ?> />
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'adicionar_campo_aceite_perfil');
add_action('edit_user_profile', 'adicionar_campo_aceite_perfil');


function salvar_campo_aceite_perfil($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return;
    }

    $valor_aceite = isset($_POST['aceite']) ? '1' : '0';
    update_user_meta($user_id, 'aceite', $valor_aceite);
}
add_action('personal_options_update', 'salvar_campo_aceite_perfil');
add_action('edit_user_profile_update', 'salvar_campo_aceite_perfil');