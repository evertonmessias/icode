<?php

// ADD field DATE in POST

// Data **********************************

function field_box_post_date()
{
    add_meta_box('post_date_id', 'Date', 'field_post_date', 'post');
}
add_action('add_meta_boxes', 'field_box_post_date');

function field_post_date($post)
{
    $value = get_post_meta($post->ID, 'post_date', true);
?>
    <input type="date" name="post_date" value="<?php echo $value; ?>">
<?php
}

// SAVE **********************************

function save_postmeta_post($post_id)
{
    if (isset($_POST['post_date'])) {
        $post_date = sanitize_text_field($_POST['post_date']);
        update_post_meta($post_id, 'post_date', $post_date);
    }

    if (isset($_POST['post_content'])) {
        $post_content = $_POST['post_content'];
        update_post_meta($post_id, 'post_content', $post_content);
    }
}
add_action('save_post', 'save_postmeta_post');
