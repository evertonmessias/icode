<?php

// Data **********************************

function field_box_congrega_date()
{
    add_meta_box('congrega_date_id', 'Date da Reunião', 'field_congrega_date', 'post','congrega_date','high',null);
}
add_action('add_meta_boxes', 'field_box_congrega_date');

function field_congrega_date($post)
{
    $value = get_post_meta($post->ID, 'congrega_date', true);
?>
    <input type="datetime-local" name="congrega_date" value="<?php echo $value; ?>">
<?php
}

function move_postmeta_to_top() {
    global $post, $wp_meta_boxes;
    do_meta_boxes( get_current_screen(), 'congrega_date', $post );
    unset($wp_meta_boxes['post']['congrega_date']);
}
add_action('edit_form_after_title', 'move_postmeta_to_top');


// SAVE ALL **********************************

function save_postmeta_congrega($post_id)
{
    if (isset($_POST['congrega_date'])) {
        $congrega_date = sanitize_text_field($_POST['congrega_date']);
        update_post_meta($post_id, 'congrega_date', $congrega_date);
    }   
}
add_action('save_post', 'save_postmeta_congrega');
