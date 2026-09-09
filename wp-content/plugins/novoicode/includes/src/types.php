<?php
// Arquivo: wp-content/plugins/novoicode/includes/src/types.php

add_action('init', 'create_custom_post_types_dinamicos');
function create_custom_post_types_dinamicos()
{
    $nomes = explode(',', get_option('portal_input_6'));
    $slugs = explode(',', get_option('portal_input_7'));

    if (count($nomes) !== count($slugs)) {
        return;
    }

    foreach ($slugs as $i => $slug) {
        $nome = trim($nomes[$i]);
        $slug = trim($slug);

        $labels = [
            'name'               => _x($nome, 'post type general name'),
            'singular_name'      => _x($nome, 'post type singular name'),
            'add_new'            => _x('Adicionar', $nome),
            'add_new_item'       => __('Adicionar novo ' . $nome),
            'edit_item'          => __('Editar ' . $nome),
            'new_item'           => __('Novo ' . $nome),
            'view_item'          => __('Ver ' . $nome),
            'search_items'       => __('Buscar ' . $nome),
            'not_found'          => __('Nada encontrado'),
            'not_found_in_trash' => __('Nada encontrado na lixeira'),
            'parent_item_colon'  => ''
        ];

        $args = [
            'labels'             => $labels,
            'supports'           => ['title', 'editor', 'revisions'],
            'hierarchical'       => false,
            'taxonomies'         => ['category'],
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => false,
            'query_var'          => true,
            'menu_position'      => 0,
            'show_in_admin_bar'  => true,
            'rewrite'            => ['slug' => $slug . '/%category%', 'with_front' => false],
            'show_in_nav_menus'  => true,
            'can_export'         => true,
            'menu_icon'          => 'dashicons-groups',
            'has_archive'        => true,
            'exclude_from_search'=> false,
            'publicly_queryable' => true,
            'capability_type'    => array('post', $slug),
            'map_meta_cap'       => true,
        ];

        register_post_type($slug, $args);
    }
}

add_action('admin_menu', 'add_custom_post_types_submenus');
function add_custom_post_types_submenus()
{
    $nomes = explode(',', get_option('portal_input_6'));
    $slugs = explode(',', get_option('portal_input_7'));

    if (count($nomes) !== count($slugs)) {
        return;
    }

    foreach ($slugs as $i => $slug) {
        $nome = trim($nomes[$i]);
        $slug = trim($slug);

        add_submenu_page(
            'icode',
            $nome,
            $nome,
            'edit_posts',
            'edit.php?post_type=' . $slug
        );
    }
}

add_action('admin_init', 'add_capabilities_to_roles_custom_types', 999);
function add_capabilities_to_roles_custom_types()
{
    $slugs = explode(',', get_option('portal_input_7'));

    $roles = ['editor', 'administrator'];

    foreach ($slugs as $slug) {
        $slug = trim($slug);

        foreach ($roles as $role_name) {
            $role = get_role($role_name);
            if ($role) {
                $role->add_cap('read');
                $role->add_cap('read_' . $slug);
                $role->add_cap('read_private_' . $slug);
                $role->add_cap('edit_' . $slug);
                $role->add_cap('edit_others_' . $slug);
                $role->add_cap('edit_published_' . $slug);
                $role->add_cap('publish_' . $slug);
                $role->add_cap('delete_others_' . $slug);
                $role->add_cap('delete_private_' . $slug);
                $role->add_cap('delete_published_' . $slug);
            }
        }
    }
}

// Meta boxes dinâmicos para todos os tipos
add_action('add_meta_boxes', 'add_dynamic_meta_boxes');
function add_dynamic_meta_boxes()
{
    $slugs = explode(',', get_option('portal_input_7'));
    
    foreach ($slugs as $slug) {
        $slug = trim($slug);
        
        // Meta box para campo privado
        add_meta_box(
            $slug . '_privado_id', 
            'Reunião Privada', 
            'render_privado_field', 
            $slug, 
            'side',
            'default',
            ['slug' => $slug]
        );
        
        // Meta box para data
        add_meta_box(
            $slug . '_date_id', 
            'Data da Reunião', 
            'render_date_field', 
            $slug, 
            'advanced',
            'default',
            ['slug' => $slug]
        );
        
        // Meta box para membros
        add_meta_box(
            $slug . '_member_id', 
            'Membros <small>( preenchimento automático via Intranet )&emsp;</small>', 
            'render_member_field', 
            $slug, 
            'advanced',
            'default',
            ['slug' => $slug]
        );
    }
}

// Render campo privado
function render_privado_field($post, $metabox)
{
    $slug = $metabox['args']['slug'];
    $value = get_post_meta($post->ID, $slug . '_privado', true);
    ?>
    <label>
        <input type="checkbox" name='<?php echo $slug; ?>_privado' value="1" <?php checked($value, '1'); ?>>
        Marcar como reunião privada
    </label>
    <?php
}

// Render campo data
function render_date_field($post, $metabox)
{
    $slug = $metabox['args']['slug'];
    $value = get_post_meta($post->ID, $slug . '_date', true);
    ?>
    <i id="scrollToTop" class='bx bxs-up-arrow-square'></i>
    <input type="datetime-local" name="<?php echo $slug; ?>_date" value="<?php echo $value; ?>">
    <?php
}

// Render campo membros
function render_member_field($post, $metabox)
{
    $slug = $metabox['args']['slug'];
    
    if (get_post_meta($post->ID, $slug . '_member', true) == "") {
        $value = do_shortcode('[icapi tipo="composicao_' . $slug . '" saida="html/?modo=short"]');
    } else {
        $value = get_post_meta($post->ID, $slug . '_member', true);
    }

    $args = array(
        'textarea_name' => $slug . '_member',
        'media_buttons' => false,
        'quicktags' => false,
        'tinymce' => array(
            'toolbar2' => FALSE,
            'media_buttons' => false,
        ),
    );

    wp_editor($value, 'field_' . $slug . '_member_id', $args);
}

// Move metaboxes (mantido igual)
add_action('edit_form_after_title', function () {
    global $post, $wp_meta_boxes;
    if (isset($wp_meta_boxes[get_post_type($post)]['advanced'])) {
        do_meta_boxes(get_current_screen(), 'advanced', $post);
        unset($wp_meta_boxes[get_post_type($post)]['advanced']);
    }
});

add_action('edit_form_after_editor', function () {
    global $post, $wp_meta_boxes;
    if (isset($wp_meta_boxes[get_post_type($post)]['default'])) {
        do_meta_boxes(get_current_screen(), 'default', $post);
        unset($wp_meta_boxes[get_post_type($post)]['default']);
    }
});

// Save post meta dinâmico
add_action('save_post', 'save_dynamic_postmeta');
function save_dynamic_postmeta($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (is_int(wp_is_post_revision($post_id))) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $slugs = explode(',', get_option('portal_input_7'));
    $current_post_type = get_post_type($post_id);
    
    // Verifica se o post type atual está na lista de slugs
    if (!in_array($current_post_type, $slugs)) return;

    // Salva campo privado
    $privado = isset($_POST[$current_post_type . '_privado']) ? '1' : '0';
    update_post_meta($post_id, $current_post_type . '_privado', $privado);

    // Salva data
    if (isset($_POST[$current_post_type . '_date'])) {
        $date_value = sanitize_text_field($_POST[$current_post_type . '_date']);
        update_post_meta($post_id, $current_post_type . '_date', $date_value);
    }

    // Salva membros
    if (isset($_POST[$current_post_type . '_member'])) {
        $member_value = wp_kses_post($_POST[$current_post_type . '_member']);
        update_post_meta($post_id, $current_post_type . '_member', $member_value);
    }
}