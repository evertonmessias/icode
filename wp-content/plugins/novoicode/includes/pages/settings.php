<?php

// Arquivo: wp-content/plugins/novoicode/includes/settings.php

// Settings *************************************************

flush_rewrite_rules();

function portal_page_html()
{ ?>
    <div class="container mt-5 settings-novoicode">
        <h3 class="mb-4">Configurações</h3>
        <hr>
        <form method="post" action="options.php">
            <?php settings_fields('portal_option_grupo'); ?>

            <!-- Nome do Site ********************************** -->
            <br>
            <div class="mb-3">
                <label for="portal_input_0" class="form-label">
                    <h5>Nome do Site: <span class="text-danger">*</span></h5>
                </label>
                <input type="text" id="portal_input_0" name="portal_input_0" class="form-control" required
                    value="<?php echo esc_attr(get_option('portal_input_0')); ?>" />
                <small class="form-text text-muted">(Campo obrigatório)</small>
            </div><br>

            <!-- Logo *************************************** -->
            <hr><br>
            <?php $image = get_option('portal_input_1'); ?>
            <div class="mb-3">
                <h5 class="form-label">Logo: <span class="text-danger">*</span></h5>
                <table class="table table-borderless">
                    <tr>
                        <td><a href="#" onclick="upload_image(1);"
                                class="btn btn-secondary"><?php _e('Upload Image'); ?></a></td>
                        <td><input type="text" name="portal_input_1" id="portal_input_1" class="form-control" required
                                value="<?php echo esc_attr($image); ?>" /></td>
                        <td class="text-center"><a href="<?php echo esc_url($image); ?>" target="_blank"><img
                                    style="height:30px" id="preview_portal_input_1" alt="preview" title="preview"
                                    src="<?php echo esc_url($image); ?>" /></a></td>
                    </tr>
                </table>
                <span class="form-text">(Tamanho ideal: 100x100 px) <span class="text-danger">* Campo obrigatório</span></span>
            </div><br>

            <!-- E-Mail dos Editores *************************************** -->
            <hr><br>
            <div class="mb-3">
                <label for="portal_input_2" class="form-label">
                    <h5>E-Mails dos Editores</h5>
                </label>
                <?php
                $emails_array = get_option('portal_input_2', []);
                $emails_str = is_array($emails_array) ? implode(', ', $emails_array) : '';
                ?>
                <textarea id="portal_input_2" name="portal_input_2"
                    class="form-control"><?php echo esc_attr($emails_str); ?></textarea>
                <small class="form-text text-muted">(Separe com vírgulas)</small>
            </div><br>

            <!-- E-Mail dos Administradores *************************************** -->
            <hr><br>
            <div class="mb-3">
                <label for="portal_input_4" class="form-label">
                    <h5>E-Mails dos Administradores</h5>
                </label>
                <?php
                $emails_array = get_option('portal_input_4', []);
                $emails_str = is_array($emails_array) ? implode(', ', $emails_array) : '';
                ?>
                <textarea id="portal_input_4" name="portal_input_4"
                    class="form-control"><?php echo esc_attr($emails_str); ?></textarea>
                <small class="form-text text-muted">(Separe com vírgulas)</small>
            </div><br>

            <!-- Texto ********************************** -->
            <hr><br>
            <div class="mb-3">
                <label for="portal_input_5" class="form-label">
                    <h5>Texto:</h5>
                </label>
                <?php
                $portal5 = get_option('portal_input_5');
                wp_editor($portal5, 'portal_input_5', array('textarea_name' => 'portal_input_5'));
                ?>
            </div><br>

            <!-- Tipos ********************************** -->
            <hr><br>
            <h5>Tipos Registrados: <span class="text-danger">*</span></h5><br>
            <div class="mb-3">
                <label for="portal_input_6" class="form-label"><h5>Nomes <span class="text-danger">*</span></h5></label>
                <input type="text" id="portal_input_6" name="portal_input_6" class="form-control" required
                    value="<?php echo esc_attr(get_option('portal_input_6')); ?>" />
                <small class="form-text text-muted">Ex: Congrega,CI,DSC,DSI,DTC,CDI</small>
            </div>
            <div class="mb-3">
                <label for="portal_input_7" class="form-label"><h5>Slugs <span class="text-danger">*</span></h5></label>
                <input type="text" id="portal_input_7" name="portal_input_7" class="form-control" required
                    value="<?php echo esc_attr(get_option('portal_input_7')); ?>" />
                <small class="form-text text-muted">Ex: congrega,ci,dsc,dsi,dtc,cdi</small>
            </div>
            <div class="mb-3">
                <label for="portal_input_8" class="form-label"><h5>Icones <span class="text-danger">*</span></h5></label>
                <input type="text" id="portal_input_8" name="portal_input_8" class="form-control" required
                    value="<?php echo esc_attr(get_option('portal_input_8')); ?>" />
                <small class="form-text text-muted">Ex: bi bi-people-fill,bi bi-person-lines-fill,bi bi-person-vcard,bi bi-person-vcard,bi bi-person-vcard,bi bi-person-video</small>
            </div>
            <div class="mb-3">
                <label for="portal_input_9" class="form-label"><h5>Textos <span class="text-danger">*</span></h5></label>
                <textarea rows="3" id="portal_input_9" name="portal_input_9" class="form-control" required><?php echo esc_textarea(get_option('portal_input_9')); ?></textarea>
                <small class="form-text text-muted">Ex: Congregação,Conselho Interdepartamental,Departamento de Sistemas de Computação,Departamento de Sistemas de Informação,Departamento de Teoria da Computação,Comissão Diretora de Informática</small>
            </div>
            <small class="mb-4"><b>Obs.:</b> Os valores dos campos devem ter o mesmo número de elementos, separados por vírgulas. <span class="text-danger">* Campos obrigatórios</span></small>	
            
            <!-- Tipos Obrigatórios ********************************** -->
            <br><hr><br>
            <div class="mb-3">
                <label for="portal_input_10" class="form-label">
                    <h5>Slug dos Tipos Obrigatórios: <span class="text-danger">*</span></h5>
                </label>
                <input type="text" id="portal_input_10" name="portal_input_10" class="form-control" required
                    value="<?php echo esc_attr(get_option('portal_input_10', 'congrega,ci')); ?>" />
                <small class="form-text text-muted">Ex: congrega,ci <span class="text-danger">* Campo obrigatório</span></small>
            </div><br>
            
            <hr>
            <br>
            <div class="text-center">
                <?php submit_button(); ?>
            </div>
        </form>
    </div>
    
    <script>
    // Validação client-side para garantir que os arrays tenham o mesmo número de elementos
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(e) {
            const campos = ['portal_input_6', 'portal_input_7', 'portal_input_8', 'portal_input_9'];
            const valores = {};
            let isValid = true;
            
            // Coleta os valores
            campos.forEach(function(campo) {
                valores[campo] = document.getElementById(campo).value.split(',').map(item => item.trim()).filter(item => item !== '');
            });
            
            // Verifica se todos têm o mesmo número de elementos
            const tamanhos = Object.values(valores).map(arr => arr.length);
            const todosIguais = tamanhos.every(tamanho => tamanho === tamanhos[0]);
            
            if (!todosIguais) {
                e.preventDefault();
                alert('❌ Erro: Todos os campos de Tipos Registrados devem ter o mesmo número de elementos separados por vírgulas!');
                isValid = false;
            }
            
            // Verifica campos obrigatórios
            const obrigatorios = ['portal_input_0', 'portal_input_1', 'portal_input_6', 'portal_input_7', 'portal_input_8', 'portal_input_9', 'portal_input_10'];
            obrigatorios.forEach(function(campo) {
                if (!document.getElementById(campo).value.trim()) {
                    e.preventDefault();
                    alert('❌ Erro: O campo "' + document.querySelector('label[for="' + campo + '"]').textContent.replace('*', '').trim() + '" é obrigatório!');
                    isValid = false;
                }
            });
            
            return isValid;
        });
    });
    </script>
    <?php
}

// Adiciona submenu na área de administração
function portal_options_page()
{
    add_submenu_page('icode', 'Configurações', 'Configurações', 'edit_posts', 'pagina-inicial', 'portal_page_html', 1);
}
add_action('admin_menu', 'portal_options_page');

//************************ DB Fields com validações

function portal_settings0()
{
    register_setting('portal_option_grupo', 'portal_input_0', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'ICODE'
    ]);
}
add_action('admin_init', 'portal_settings0');

function portal_settings1()
{
    register_setting('portal_option_grupo', 'portal_input_1', [
        'type' => 'string',
        'sanitize_callback' => 'esc_url_raw',
        'default' => ''
    ]);
}
add_action('admin_init', 'portal_settings1');

function portal_settings2()
{
    register_setting('portal_option_grupo', 'portal_input_2', [
        'type' => 'array',
        'sanitize_callback' => 'portal_sanitize_emails_array',
        'default' => [],
    ]);
}
add_action('admin_init', 'portal_settings2');

function portal_settings3()
{
    register_setting('portal_option_grupo', 'portal_input_3', [
        'type' => 'array',
        'sanitize_callback' => 'portal_sanitize_emails_array',
        'default' => [],
    ]);
}
add_action('admin_init', 'portal_settings3');

function portal_settings4()
{
    register_setting('portal_option_grupo', 'portal_input_4', [
        'type' => 'array',
        'sanitize_callback' => 'portal_sanitize_emails_array',
        'default' => [],
    ]);
}
add_action('admin_init', 'portal_settings4');

function portal_settings5()
{
    register_setting('portal_option_grupo', 'portal_input_5', [
        'type' => 'string',
        'sanitize_callback' => 'wp_kses_post',
        'default' => ''
    ]);
}
add_action('admin_init', 'portal_settings5');

function portal_settings6()
{
    register_setting('portal_option_grupo', 'portal_input_6', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'Congrega,CI,DSC,DSI,DTC,CDI'
    ]);
}
add_action('admin_init', 'portal_settings6');

function portal_settings7()
{
    register_setting('portal_option_grupo', 'portal_input_7', [
        'type' => 'string',
        'sanitize_callback' => 'portal_sanitize_slugs',
        'default' => 'congrega,ci,dsc,dsi,dtc,cdi'
    ]);
}
add_action('admin_init', 'portal_settings7');

function portal_settings8()
{
    register_setting('portal_option_grupo', 'portal_input_8', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'bi bi-people-fill,bi bi-person-lines-fill,bi bi-person-vcard,bi bi-person-vcard,bi bi-person-vcard,bi bi-person-video'
    ]);
}
add_action('admin_init', 'portal_settings8');

function portal_settings9()
{
    register_setting('portal_option_grupo', 'portal_input_9', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => 'Congregação,Conselho Interdepartamental,Departamento de Sistemas de Computação,Departamento de Sistemas de Informação,Departamento de Teoria da Computação,Comissão Diretora de Informática'
    ]);
}
add_action('admin_init', 'portal_settings9');

function portal_settings10()
{
    register_setting('portal_option_grupo', 'portal_input_10', [
        'type' => 'string',
        'sanitize_callback' => 'portal_sanitize_slugs',
        'default' => 'congrega,ci'
    ]);
}
add_action('admin_init', 'portal_settings10');

// Funções de sanitização
function portal_sanitize_emails_array($input)
{
    if (is_string($input)) {
        $emails = array_map('trim', explode(',', $input));
    } elseif (is_array($input)) {
        $emails = $input;
    } else {
        return [];
    }

    return array_filter($emails, function ($email) {
        return is_email($email);
    });
}

function portal_sanitize_slugs($input)
{
    $slugs = array_map('trim', explode(',', $input));
    $slugs = array_map('sanitize_title', $slugs);
    return implode(',', array_filter($slugs));
}

// Validação server-side para garantir consistência nos arrays
function portal_validate_tipos_consistency($input)
{
    $campos_tipos = ['portal_input_6', 'portal_input_7', 'portal_input_8', 'portal_input_9'];
    $valores = [];
    
    foreach ($campos_tipos as $campo) {
        if (isset($input[$campo])) {
            $valores[$campo] = array_map('trim', explode(',', $input[$campo]));
            $valores[$campo] = array_filter($valores[$campo]); // Remove vazios
        }
    }
    
    $tamanhos = array_map('count', $valores);
    $tamanho_unico = count(array_unique($tamanhos)) === 1;
    
    if (!$tamanho_unico) {
        add_settings_error(
            'portal_option_grupo',
            'tipos_inconsistentes',
            '❌ Erro: Todos os campos de Tipos Registrados devem ter o mesmo número de elementos separados por vírgulas!'
        );
    }
    
    return $input;
}
add_filter('pre_update_option_portal_input_6', 'portal_validate_tipos_consistency');
add_filter('pre_update_option_portal_input_7', 'portal_validate_tipos_consistency');
add_filter('pre_update_option_portal_input_8', 'portal_validate_tipos_consistency');
add_filter('pre_update_option_portal_input_9', 'portal_validate_tipos_consistency');