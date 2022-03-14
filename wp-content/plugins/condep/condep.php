<?php

/**
 * Plugin Name: CONDEP
 * Plugin URI: https://ic.unicamp.br/~everton
 * Description: Plugin CONDEP, include CONGREGA, CI & DEPTOS
 * Author: EvM.
 * Version: 1.0
 * Text Domain: CONDEP
 * Plugin CONDEP
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// FUNCTIONS ************************************************
include ABSPATH . '/wp-content/plugins/condep/includes/functions.php';

// TYPES ************************************************
include ABSPATH . '/wp-content/plugins/condep/includes/types/congrega.php';
include ABSPATH . '/wp-content/plugins/condep/includes/types/historicocongrega.php';


// SETTINGS ************************************************
include ABSPATH . '/wp-content/plugins/condep/includes/settings.php';

// POSTMETA POST ************************************************
//include ABSPATH . '/wp-content/plugins/condep/includes/postmeta-post.php';


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
