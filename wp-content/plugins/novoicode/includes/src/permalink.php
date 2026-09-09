<?php
// Arquivo: wp-content/plugins/novoicode/includes/src/permalink.php

// Função para substituir %category% no permalink
function replace_category_in_permalink($permalink, $post)
{
    // Só faz algo se o post tiver uma categoria e for custom post type
    if (!is_object($post) || $post->post_type === 'post') {
        return $permalink;
    }

    $terms = get_the_terms($post->ID, 'category');
    if ($terms && !is_wp_error($terms)) {
        $category_slug = $terms[0]->slug;
    } else {
        $category_slug = 'sem-categoria';
    }

    return str_replace('%category%', $category_slug, $permalink);
}
add_filter('post_type_link', 'replace_category_in_permalink', 10, 2);

// Função para regras de rewrite dinâmicas baseadas nos tipos - COM PRIORIDADE MAIS BAIXA
function custom_rewrite_rules_for_all_post_types()
{
    $post_types = get_post_types(['public' => true, '_builtin' => false], 'names');

    foreach ($post_types as $pt) {
        $post_type_slug = $pt;

        // Regra para a página de arquivo do tipo de post
        add_rewrite_rule(
            '^' . $post_type_slug . '/?$',
            'index.php?post_type=' . $post_type_slug,
            'top' // Mantém como 'top' para páginas de arquivo
        );

        // Regra para posts individuais com categoria - PRIORIDADE MAIS BAIXA
        add_rewrite_rule(
            '^' . $post_type_slug . '/([^/]+)/([^/]+)/?$',
            'index.php?post_type=' . $post_type_slug . '&category_name=$1&name=$2',
            'bottom' // Muda para 'bottom' para não conflitar com categorias
        );
    }
}
add_action('init', 'custom_rewrite_rules_for_all_post_types');

// Função para regras específicas dos tipos do ICODE - PRIORIDADE BAIXA
function custom_rewrite_rules_for_types()
{
    // Obter slugs dinamicamente do portal_input_7
    $slugs_array = explode(',', get_option('portal_input_7'));
    $slugs_array = array_map('trim', $slugs_array);

    foreach ($slugs_array as $slug) {
        if (!empty($slug)) {
            // Regra para a página principal do tipo
            add_rewrite_rule(
                '^' . $slug . '/?$',
                'index.php?post_type=' . $slug,
                'top'
            );
            
            // Regra para posts com categoria - PRIORIDADE BAIXA
            add_rewrite_rule(
                '^' . $slug . '/([^/]+)/([^/]+)/?$',
                'index.php?post_type=' . $slug . '&category_name=$1&name=$2',
                'bottom' // Prioridade baixa para não conflitar
            );
        }
    }
}
add_action('init', 'custom_rewrite_rules_for_types');

// CORREÇÃO: Adicionar regra para garantir que categorias normais funcionem
function fix_category_rewrite_rules()
{
    // Regra para categorias normais (anos) - PRIORIDADE ALTA
    add_rewrite_rule(
        '^category/([^/]+)/?$',
        'index.php?category_name=$1',
        'top'
    );
    
    // Regra para anos diretos (ex: /2024/) - se você usa essa estrutura
    add_rewrite_rule(
        '^([0-9]{4})/?$',
        'index.php?category_name=$1',
        'top'
    );
}
add_action('init', 'fix_category_rewrite_rules');

// Função para limpar e reconstruir as regras corretamente
function flush_rewrite_rules_properly()
{
    $current_slugs = get_option('portal_input_7');
    $last_flush = get_option('last_rewrite_flush_properly');
    
    if ($current_slugs !== $last_flush) {
        // Primeiro remove todas as regras
        delete_option('rewrite_rules');
        
        // Depois reconstrói
        flush_rewrite_rules();
        update_option('last_rewrite_flush_properly', $current_slugs);
        
        error_log('Rewrite rules flushed properly');
    }
}
add_action('init', 'flush_rewrite_rules_properly');