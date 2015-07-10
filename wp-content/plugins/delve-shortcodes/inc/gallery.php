<?php
/*
 Custom post type for ourteam functionality
*/

add_action( 'init', 'register_cpt_gallery' );
function register_cpt_gallery() {
    $labels = array(
        'name' => _x( 'Gallery', 'gallery' ,'delve' ),
        'singular_name' => _x( 'Gallery', 'gallery' ,'delve' ),
        'add_new' => _x( 'Add New Image', 'gallery' ,'delve' ),
        'add_new_item' => _x( 'Add New Image', 'gallery' ,'delve' ),
        'edit_item' => _x( 'Edit Image', 'gallery' ,'delve' ),
        'new_item' => _x( 'New Image', 'gallery' ,'delve' ),
        'view_item' => _x( 'View Image', 'gallery' ,'delve' ),
        'search_items' => _x( 'Search Image', 'gallery' ,'delve' ),
        'not_found' => _x( 'No Image found', 'gallery', 'delve' ),
        'not_found_in_trash' => _x( 'No Image found in Trash', 'gallery' ,'delve' ),
        'parent_item_colon' => _x( 'Parent Gallery:', 'gallery', 'delve' ),
        'menu_name' => _x( 'Gallery', 'gallery' ,'delve' ),
    );
	
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'To display Gallery at frontend add [delve_gallery] shortcode in description field.',
        'supports' => array( 'title', 'thumbnail', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'gallery-categories' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 14,
		'menu_icon' => 'dashicons-format-gallery',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' =>  array('slug' => 'delve-gallery'),
        'capability_type' => 'page'
    );
    register_post_type( 'Gallery', $args );
}

// register Ourteam categories
add_action( 'init', 'register_taxonomy_gallery_categories' );
function register_taxonomy_gallery_categories() {
    $labels = array( 
        'name' => _x( 'Gallery categories', 'gallery_categories' ,'delve' ),
        'singular_name' => _x( 'Gallery Category', 'gallery_categories' ,'delve' ),
        'search_items' => _x( 'Search Gallery categories', 'gallery_categories' ,'delve' ),
        'popular_items' => _x( 'Popular Gallery categories', 'gallery_categories' ,'delve' ),
        'all_items' => _x( 'All Gallery categories', 'gallery_categories' ,'delve' ),
        'parent_item' => _x( 'Parent Gallery Category', 'gallery_categories' ,'delve' ),
        'parent_item_colon' => _x( 'Parent Gallery Category:', 'gallery_categories' ,'delve' ),
        'edit_item' => _x( 'Edit Gallery Category', 'gallery_categories' ,'delve' ),
        'update_item' => _x( 'Update Gallery Category', 'gallery_categories' ,'delve' ),
        'add_new_item' => _x( 'Add New Gallery Category', 'gallery_categories' ,'delve' ),
        'new_item_name' => _x( 'New Gallery Category', 'gallery_categories' ,'delve' ),
        'separate_items_with_commas' => _x( 'Separate Gallery categories with commas', 'gallery_categories' ,'delve' ),
        'add_or_remove_items' => _x( 'Add or remove Gallery categories', 'gallery_categories' ,'delve' ),
        'choose_from_most_used' => _x( 'Choose from the most used Gallery categories', 'gallery_categories' ,'delve' ),
        'menu_name' => _x( 'Gallery categories', 'gallery_categories', 'delve' ),
    );
    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,
        'rewrite' => array('with_front' => false, 'hierarchical' => true),
        'query_var' => true
    );
    register_taxonomy( 'gallery_categories', array('gallery'), $args );
}

add_shortcode('delve_gallery', 'delve_gallery_function');
function delve_gallery_function($atts) {
	$atts = shortcode_atts(
		array (
			'effect'	=> "1",
			'category'	=> "",
			'per_page'	=> "-1",
		),$atts	);
		
    ob_start();
    delve_gallery_view($atts);
    $content = ob_get_clean();
    return $content;
}

function delve_gallery_view($atts = array()) {
    include( DELVE_SHORTCODES_DIR . "/inc/disp/view_gallery.php");
}