<?php

/**
 * Plugin Name: icode
 * Plugin URI: https://ic.unicamp.br/~everton
 * Description: Plugin icode, include CONGREGA, CI & DEPTOS
 * Author: EvM.
 * Version: 1.0
 * Text Domain: icode
 * Plugin icode
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// FUNCTIONS ************************************************
include ABSPATH . '/wp-content/plugins/icode/includes/functions.php';

// TYPES ************************************************
include ABSPATH . '/wp-content/plugins/icode/includes/types/congrega.php';
include ABSPATH . '/wp-content/plugins/icode/includes/types/historicocongrega.php';


// SETTINGS ************************************************
include ABSPATH . '/wp-content/plugins/icode/includes/settings.php';

// POSTMETA POST ************************************************
//include ABSPATH . '/wp-content/plugins/icode/includes/postmeta-post.php';


// OBJECTS *************************************************
$congrega = new congrega();
$historicocongrega = new historicocongrega();

register_activation_hook(__FILE__, array(    
    $congrega, 'activate',   
    $historicocongrega, 'activate',
));

register_deactivation_hook(__FILE__, array(
    $congrega, 'deactivate', 
    $historicocongrega, 'deactivate',    
));
