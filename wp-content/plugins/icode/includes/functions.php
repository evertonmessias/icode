<?php

//***************** Add General Configuration Roles
function general_configuration_role_caps()
{
	$roles = array('editor');
	foreach ($roles as $the_role) {
		$role = get_role($the_role);
		$role->remove_cap('list_users');
		$role->remove_cap('create_users');
		$role->remove_cap('remove_users');
		$role->remove_cap('promote_users');
		$role->remove_cap('edit_users');
		$role->add_cap('manage_options');
	}
}
add_action('admin_init', 'general_configuration_role_caps', 999);




//***************** Add Remove menu page Admin
function wpdocs_remove_menus()
{
	if (current_user_can('editor') || current_user_can('administrator')) {
		remove_menu_page('index.php'); //Dashboard		
		//remove_menu_page('themes.php'); //Appearance
		remove_menu_page('edit-comments.php');
		remove_menu_page('plugins.php'); //Plugins
		//remove_menu_page('users.php'); //Users
		//remove_menu_page('tools.php'); //Tools
		//remove_menu_page('profile.php'); //Profile
		//remove_menu_page('options-general.php'); //Settings
		remove_menu_page('edit.php?post_type=page'); // Pages
	}
}
add_action('admin_menu', 'wpdocs_remove_menus');





// ***************** Add style & script for Admin
function style_and_script()
{
?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
<?php
	wp_enqueue_style('stilos', '/wp-content/plugins/icode/assets/icode.css');
	wp_enqueue_script('scripts', '/wp-content/plugins/icode/assets/icode.js');
}
add_action('admin_enqueue_scripts', 'style_and_script');





//Rename menu iten Admin
function wd_admin_menu_rename()
{
	if(get_current_blog_id() != 1){
	global $menu;
	$menu[5][0] = 'Reuniões';
	}
}
add_action('admin_menu', 'wd_admin_menu_rename');





// ***************** Add in NETWORK Menu
function menu_icode()
{
	add_menu_page('ICODE', 'ICODE', 'edit_posts', 'icode', 'function_about', 'dashicons-screenoptions', 5);
}
add_action('network_admin_menu', 'menu_icode');
// ***************** Add Page About
function function_about()
{
	include ABSPATH . '/wp-content/plugins/icode/includes/about.php';
}
add_action('function_about', 'function_about');
// ***************** Add Page Access
function page_access()
{
	add_submenu_page('icode', 'Acessos', 'Acessos', 'edit_posts', 'acessos', 'function_access', 2);
}
add_action('network_admin_menu', 'page_access');
// ***************** Include Page Access
function function_access()
{
	include ABSPATH . '/wp-content/plugins/icode/includes/access.php';
}
add_action('function_access', 'function_access');





// ***************** Add Media
function load_media_files()
{
	wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'load_media_files');




//************* Remove thumbnails
remove_theme_support('post-thumbnails', array('post'));



//************* Remove tags support from posts
function myprefix_unregister_tags()
{
  unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'myprefix_unregister_tags');



//************* Data Base
function registerdb($ip) // register in db
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'access';
	$resp = $wpdb->insert($table_name, array('ipadress' => $ip, 'time' => current_time('mysql')));
	if ($resp == 1) {
		return "register db: SUCESS";
	} else {
		return "register db: ERROR";
	}
}
add_action('registerdb','registerdb');
function list_access($item) // list access
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'access';
	$results = $wpdb->get_results(
		"SELECT $item FROM $table_name"
	);
	return $results;
}
add_action('list_access','list_access');




//************* Login_redirect
function admin_default_page()
{
  return '/wp-admin';
}
add_filter('login_redirect', 'admin_default_page');




//************* Admin Login Logo
function tf_wp_admin_login_logo()
{ ?>
  <style type="text/css">
    #login h1 a {
      background-image: url('<?php echo get_option('portal_input_2'); ?>');
    }

    #login .galogin-powered {
      display: none;
    }
    .language-switcher{
      display: none;
    }
  </style>
<?php }
add_action('login_enqueue_scripts', 'tf_wp_admin_login_logo');




//************* Admin Login Logo Link URL
function tf_wp_admin_login_logo_url()
{
  return home_url();
}
add_filter('login_headerurl', 'tf_wp_admin_login_logo_url');




//************* Admin Login Logo's Title
function tf_wp_admin_login_logo_title($headertext)
{
  $headertext = esc_html__(get_bloginfo('name'), 'plugin-textdomain');
  return $headertext;
}
add_filter('login_headertext', 'tf_wp_admin_login_logo_title');




//************* Hide admin bar
function remove_admin_bar()
{
  if (current_user_can('administrator')) {
    //show_admin_bar(false);
  }
}
add_action('after_setup_theme', 'remove_admin_bar');



//************* IC - APIs

function icapi1()
{
    return file_get_contents(get_option('icapi_1'));
}
add_shortcode('icapi1', 'icapi1');

function icapi2()
{
    return file_get_contents(get_option('icapi_2'));
}
add_shortcode('icapi2', 'icapi2');

function icapi3()
{
    return file_get_contents(get_option('icapi_3'));
}
add_shortcode('icapi3', 'icapi3');

function icapi4()
{
    return file_get_contents(get_option('icapi_4'));
}
add_shortcode('icapi4', 'icapi4');