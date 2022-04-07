<?php

class historicocongrega
{
	public function __construct()
	{
		add_action('init', array($this, 'create_custom_post_type_historicocongrega'));
		add_action('init', array($this,'create_historicocongrega_taxonomies'));
	}

	public function create_custom_post_type_historicocongrega()
	{
		$labels = [
			'name'					=> __('Histórico Congrega', 'Histórico Congrega', 'text_domain'),
			'singular_name'			=> __('Histórico Congrega', 'Histórico Congrega', 'text_domain'),
			'menu_name'				=> __('Histórico Congrega', 'text_domain'),
			'name_admin_bar'		=> __('Histórico Congrega', 'text_domain'),
			'add_new_item'			=> __('Criar novo Histórico Congrega', 'text_domain'),
			'edit_item'				=> __('Editar Histórico Congrega', 'text_domain'),
			'description'           => __('Descrição Histórico Congrega', 'text_domain') 
		];
		$args = [			
			'labels'				=> $labels,
			'supports'              => ['title' , 'editor'  /*, 'thumbnail', 'author', 'excerpt'*/],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'			=> true,			
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'     	=> array('post', 'historicocongrega'),
			'map_meta_cap'        => true,
		];
		register_post_type('historicocongrega', $args);
	}

	function create_historicocongrega_taxonomies() {
		$labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Categories' ),
			'all_items'         => __( 'All Categories' ),
			'parent_item'       => __( 'Parent Category' ),
			'parent_item_colon' => __( 'Parent Category:' ),
			'edit_item'         => __( 'Edit Category' ),
			'update_item'       => __( 'Update Category' ),
			'add_new_item'      => __( 'Adicionar nova Categoria do Histórico Congrega da Congregação' ),
			'new_item_name'     => __( 'New Category Name' ),
			//'menu_name'         => __( 'Categories' ),
		);
	
		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,			
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true
		);	
		register_taxonomy( 'historicocongrega_categories','historicocongrega', $args );
	}	

	public function activate()
	{
		//remove_role('subscriber');
		remove_role('contributor');
		remove_role('author');
		$this->create_custom_post_type_historicocongrega();			
		flush_rewrite_rules();		
	}

	public function deactivate()
	{
		flush_rewrite_rules();
	}
}

//Add in submenu
function type_historicocongrega(){
  add_submenu_page(
	  'tools.php', 
	  'Histórico', 
	  'Histórico', 
	  'edit_posts',
	  'edit.php?post_type=historicocongrega',
	  '',
	  0
	);
}
add_action( 'admin_menu', 'type_historicocongrega' );


//Roles for Admin, Editor
function role_caps_historicocongrega()
{
	$roles = array('editor','administrator');
	foreach ($roles as $the_role) {
		$role = get_role($the_role);
		$role->add_cap('read');
		$role->add_cap('read_historicocongrega');
		$role->add_cap('read_private_historicocongrega');
		$role->add_cap('edit_historicocongrega');
		$role->add_cap('edit_others_historicocongrega');
		$role->add_cap('edit_published_historicocongrega');
		$role->add_cap('publish_historicocongrega');
		$role->add_cap('delete_others_historicocongrega');
		$role->add_cap('delete_private_historicocongrega');
		$role->add_cap('delete_published_historicocongrega');
	}
}
add_action('admin_init', 'role_caps_historicocongrega',999);

// POSTMETA ************************************************
//include ABSPATH . '/wp-content/plugins/cegrapi/includes/types/postmeta-historicocongrega.php';
