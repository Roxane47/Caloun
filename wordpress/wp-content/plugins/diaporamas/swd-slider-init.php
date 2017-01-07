<?php

// INIT
function swdSliders_init()
{
	// LANGAGE
	load_plugin_textdomain( 'diaporamas', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	// Active les miniatures (thumbnails) si elle ne le sont pas.
	if(!current_theme_supports('post-thumbnails')) { add_theme_support('post-thumbnails'); }
	$thumb_diapo_w = get_option('swd_sliders_thumbnail_size_w');
	$thumb_diapo_h = get_option('swd_sliders_thumbnail_size_h');
	add_image_size('minidiapo', $thumb_diapo_w, $thumb_diapo_h, true);
	
	// Menu Diaporama
  	$sliders_labels = array( 
	'name' => __('Sliders', 'diaporamas'), 
	'singular_name' => __('Slider', 'diaporamas'),
	'all_items' => __('All Sliders', 'diaporamas'), 	
	'add_new' => __('Add New Slider', 'diaporamas'), 
	'add_new_item' => __('Add New Slider', 'diaporamas'), 
	'edit_item' => __('Edit Slider', 'diaporamas'), 
	'new_item' => __('New Slider', 'diaporamas'), 
	'view_item' => __('View Slider', 'diaporamas'), 
	'search_items' => __('Search Sliders', 'diaporamas'), 
	'not_found' =>  __('No sliders found', 'diaporamas'), 
	'not_found_in_trash' => __('No sliders found in Trash', 'diaporamas'), 
	'parent_item_colon' => '', 
	);
	
	$sliders_args = array(
		'labels' 				=> $sliders_labels,
		'public' 				=> false,
		'publicly_queryable' 	=> true,
		'_builtin'             => false,
		'show_ui'              => true,
		'query_var'            => true,
		'rewrite'              => apply_filters( 'swdSliders_post_type_rewrite', array( "slug" => "sliders" )),
		'capability_type'      => 'post',
		'capabilities' => array(
		        'publish_posts' 		=> 'publish_pages',
		        'edit_posts' 			=> 'publish_pages',
		        'edit_others_posts' 	=> 'publish_pages',
		        'delete_posts' 			=> 'publish_pages',
		        'delete_others_posts' 	=> 'publish_pages',
		        'read_private_posts' 	=> 'publish_pages',
		        'edit_post' 			=> 'publish_pages',
		        'delete_post' 			=> 'publish_pages',
		        'read_post' 			=> 'publish_pages',
		    ),
			
		'hierarchical'         => false,
		'menu_position'        => 26.1,
		'supports'             => array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
		'taxonomies'           => array(),
		'has_archive'          => true,
		'show_in_nav_menus'    => false,
	);
					
	register_post_type( 'sliders', $sliders_args );
	
	
	
	// Menu Image
	$slides_labels = array( 
	'name' => __( 'Slides', 'diaporamas' ), 
	'singular_name' => __( 'Slide', 'diaporamas' ), 
	'all_items' => __( 'All Slides', 'diaporamas' ), 
	'add_new' => __( 'Add New Slide', 'diaporamas' ), 
	'add_new_item' => __( 'Add New Slide', 'diaporamas' ), 
	'edit_item' => __( 'Edit Slide', 'diaporamas' ), 
	'new_item' => __( 'New Slide', 'diaporamas' ),
	'view_item' => __( 'View Slide', 'diaporamas' ),
	'search_items' => __( 'Search Slides', 'diaporamas' ),
	'not_found' => __( 'No Slide found', 'diaporamas' ), 
	'not_found_in_trash' => __( 'No Slide found in Trash', 
	'diaporamas' ), 'parent_item_colon' => '' );
	
	$slides_args = array(
		'labels'               => $slides_labels,
		'public'               => false,
		'publicly_queryable'   => false,
		'show_ui'              => true,
		'show_in_menu'		   => false,
		'query_var'            => true,
		'rewrite' 				=> array( 'with_front' => false ),
		'capability_type'      => 'post',
		'capabilities' => array(
		        'publish_posts' 		=> 'publish_pages',
		        'edit_posts' 			=> 'publish_pages',
		        'edit_others_posts' 	=> 'publish_pages',
		        'delete_posts' 			=> 'publish_pages',
		        'delete_others_posts' 	=> 'publish_pages',
		        'read_private_posts' 	=> 'publish_pages',
		        'edit_post' 			=> 'publish_pages',
		        'delete_post' 			=> 'publish_pages',
		        'read_post' 			=> 'publish_pages',
		    ),
		'hierarchical'         => false,
		'menu_position'        => 26.2,
		'supports'             => array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
		'exclude_from_search'  => true,
		'has_archive'          => false,
		'show_in_menu'  		=> 'edit.php?post_type=sliders',
	);
	register_post_type( 'slides', $slides_args );
	
	
//add_image_size('slider', 1000, 300, true);
	
	// Initialise les options dans la BD
	$miniature_l = get_option('thumbnail_size_w');
	$miniature_h = get_option('thumbnail_size_h');
	$val = get_option( 'swd_sliders_thumbnail_size_w' );
	
	if ( $val < 1){	
		update_option( 'swd_sliders_thumbnail_size_w', $miniature_l );
		update_option( 'swd_sliders_thumbnail_size_h', $miniature_h );
	}
}