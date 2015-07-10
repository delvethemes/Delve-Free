<?php
/*
 Custom post type for ourteam functionality
*/

add_action( 'init', 'register_cpt_Ourteam' );
function register_cpt_Ourteam() {
    $labels = array(
        'name' => _x( 'Ourteam', 'Ourteam' ,'delve' ),
        'singular_name' => _x( 'Ourteam', 'Ourteam' ,'delve' ),
        'add_new' => _x( 'Add New Member', 'Ourteam' ,'delve' ),
        'add_new_item' => _x( 'Add New Ourteam', 'Ourteam' ,'delve' ),
        'edit_item' => _x( 'Edit Member', 'Ourteam' ,'delve' ),
        'new_item' => _x( 'New Member', 'Ourteam' ,'delve' ),
        'view_item' => _x( 'View Member', 'Ourteam' ,'delve' ),
        'search_items' => _x( 'Search Member', 'Ourteam' ,'delve' ),
        'not_found' => _x( 'No Member found', 'Ourteam' ),
        'not_found_in_trash' => _x( 'No Member found in Trash', 'Ourteam' ,'delve' ),
        'parent_item_colon' => _x( 'Parent Ourteam:', 'Ourteam' ,'delve' ),
        'menu_name' => _x( 'Ourteam', 'Ourteam' ,'delve' ),
    );
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'To display members at frontend add [ourteam] shortcode in description field.',
        'supports' => array( 'title', 'thumbnail', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'ourteam-categories' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 11,
		'menu_icon' => 'dashicons-nametag',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' =>  array('slug' => 'delve-ourteam'),
        'capability_type' => 'page'
    );
    register_post_type( 'Ourteam', $args );
}

// register Ourteam categories
add_action( 'init', 'register_taxonomy_Ourteam_categories' );
function register_taxonomy_Ourteam_categories() {
    $labels = array( 
        'name' => _x( 'Ourteam categories', 'Ourteam_categories' ,'delve' ),
        'singular_name' => _x( 'Ourteam Category', 'Ourteam_categories' ,'delve' ),
        'search_items' => _x( 'Search Ourteam categories', 'Ourteam_categories' ,'delve' ),
        'popular_items' => _x( 'Popular Ourteam categories', 'Ourteam_categories' ,'delve' ),
        'all_items' => _x( 'All Ourteam categories', 'Ourteam_categories' ,'delve' ),
        'parent_item' => _x( 'Parent Ourteam Category', 'Ourteam_categories' ,'delve' ),
        'parent_item_colon' => _x( 'Parent Ourteam Category:', 'Ourteam_categories' ,'delve' ),
        'edit_item' => _x( 'Edit Ourteam Category', 'Ourteam_categories' ,'delve' ),
        'update_item' => _x( 'Update Ourteam Category', 'Ourteam_categories' ,'delve' ),
        'add_new_item' => _x( 'Add New Ourteam Category', 'Ourteam_categories' ,'delve' ),
        'new_item_name' => _x( 'New Ourteam Category', 'Ourteam_categories' ,'delve' ),
        'separate_items_with_commas' => _x( 'Separate Ourteam categories with commas', 'Ourteam_categories' ,'delve' ),
        'add_or_remove_items' => _x( 'Add or remove Ourteam categories', 'Ourteam_categories' ,'delve' ),
        'choose_from_most_used' => _x( 'Choose from the most used Ourteam categories', 'Ourteam_categories' ,'delve' ),
        'menu_name' => _x( 'Ourteam categories', 'Ourteam_categories' ,'delve' ,'delve' ),
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
    register_taxonomy( 'Ourteam_categories', array('Ourteam'), $args );
}

add_shortcode('delve_ourteam', 'delve_Ourteam_function');
function delve_Ourteam_function($atts) {
	$atts = shortcode_atts(
		array (
			'show_members'	=> -1,
			'column'		=> 4,
		),$atts	);
		
    ob_start();
    delve_Ourteam_view($atts);
    $content = ob_get_clean();
    return $content;
}

function delve_Ourteam_view($atts = array()) {
    require_once( DELVE_SHORTCODES_DIR . "/inc/disp/view_ourteam.php");
}