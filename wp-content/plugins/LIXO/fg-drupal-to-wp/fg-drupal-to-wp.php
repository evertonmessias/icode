<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/fg-drupal-to-wp/
 * @since             1.0.0
 * @package           FG_Drupal_to_WordPress
 *
 * @wordpress-plugin
 * Plugin Name:       FG Drupal to WordPress
 * Plugin URI:        https://wordpress.org/plugins/fg-drupal-to-wp/
 * Description:       A plugin to migrate articles, pages, categories, tags, images from Drupal to WordPress
 * Version:           3.25.0
 * Author:            Frédéric GILLES
 * Author URI:        https://www.fredericgilles.net/
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fg-drupal-to-wp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'FGD2WP_PLUGIN_VERSION', '3.25.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fg-drupal-to-wp-activator.php
 */
function activate_fg_drupal_to_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fg-drupal-to-wp-activator.php';
	FG_Drupal_to_WordPress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fg-drupal-to-wp-deactivator.php
 */
function deactivate_fg_drupal_to_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fg-drupal-to-wp-deactivator.php';
	FG_Drupal_to_WordPress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fg_drupal_to_wordpress' );
register_deactivation_hook( __FILE__, 'deactivate_fg_drupal_to_wordpress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fg-drupal-to-wp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fg_drupal_to_wordpress() {

	$plugin = new FG_Drupal_to_WordPress();
	$plugin->run();

}
run_fg_drupal_to_wordpress();
