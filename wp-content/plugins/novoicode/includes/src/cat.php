<?php
// Arquivo: wp-content/plugins/novoicode/includes/src/cat.php
// ********************* YEAR (Gerar categorias de ano se não existirem) *******************
function create_year_categories()
{
    $start_year = 2004;
    $current_year = date('Y');

    for ($year = $start_year; $year <= $current_year; $year++) {
        if (!term_exists($year, 'category')) {
            wp_insert_term($year, 'category', [
                'slug' => $year,
            ]);
        }
    }
}
add_action('init', 'create_year_categories');



// ********************* METABOX COM SELECT DE ANOS PARA O POST TYPE  *********************
function add_year_category_metabox()
{
    // Obter todos os tipos dinamicamente do portal_input_7
    $slugs_array = explode(',', get_option('portal_input_7'));
    $slugs_array = array_map('trim', $slugs_array);
    
    if (empty($slugs_array)) {
        return;
    }

    add_meta_box(
        'year_category_select',
        'Ano',
        'render_year_category_metabox',
        $slugs_array,
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_year_category_metabox');

function render_year_category_metabox($post)
{
    $selected = '';
    $terms = wp_get_post_terms($post->ID, 'category', ['fields' => 'slugs']);
    if (!empty($terms)) {
        $selected = $terms[0];
    }

    $start_year = 2004;
    $current_year = date('Y');

    echo '<select name="year_category_select" style="width:100%;">';
    echo '<option value="">-- Selecione o Ano --</option>';

    for ($year = $current_year; $year >= $start_year; $year--) {
        $is_selected = ($selected == $year) ? 'selected' : '';
        echo "<option value='{$year}' {$is_selected}>{$year}</option>";
    }

    echo '</select>';
    // Campo nonce para segurança
    wp_nonce_field('save_year_category_metabox', 'year_category_metabox_nonce');
}


// ********************* SALVAR SELEÇÃO *******************************************************
function save_year_category_selection($post_id)
{
    // Verificações de segurança
    if (
        !isset($_POST['year_category_metabox_nonce']) ||
        !wp_verify_nonce($_POST['year_category_metabox_nonce'], 'save_year_category_metabox')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;

    // Verificar se é um dos tipos do ICODE
    $slugs_array = explode(',', get_option('portal_input_7'));
    $slugs_array = array_map('trim', $slugs_array);
    $current_post_type = get_post_type($post_id);
    
    if (!in_array($current_post_type, $slugs_array)) {
        return;
    }

    if (isset($_POST['year_category_select']) && $_POST['year_category_select'] !== '') {
        $year_slug = sanitize_text_field($_POST['year_category_select']);
        $term = get_term_by('slug', $year_slug, 'category');
        if ($term) {
            wp_set_post_terms($post_id, [$term->term_id], 'category');
        }
    }
}
add_action('save_post', 'save_year_category_selection');



// ********************* PRÉ SELECT CAT ******************************************************
function preselect_category_for_custom_type($post_ID, $post, $update)
{
    // Obter todos os tipos dinamicamente do portal_input_7
    $slugs_array = explode(',', get_option('portal_input_7'));
    $slugs_array = array_map('trim', $slugs_array);
    
    if (empty($slugs_array)) {
        return;
    }

    // Verificar se é um dos tipos do ICODE e se é um novo post
    if (!$update && in_array($post->post_type, $slugs_array)) {
        $current_year = date('Y');
        $term = get_term_by('slug', $current_year, 'category');

        if ($term) {
            wp_set_post_terms($post_ID, [$term->term_id], 'category');
        }
    }
}
add_action('wp_insert_post', 'preselect_category_for_custom_type', 10, 3);