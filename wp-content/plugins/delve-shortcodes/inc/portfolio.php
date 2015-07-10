<?php
/*
 Costum post type for portfolio functionality
*/
 
add_action( 'init', 'register_cpt_portfolio' );
function register_cpt_portfolio() {
    $labels = array(
        'name' => _x( 'Portfolio', 'portfolio' ,'delve' ),
        'singular_name' => _x( 'Portfolio', 'portfolio' ,'delve' ),
        'add_new' => _x( 'Add New Portfolio', 'portfolio' ,'delve' ),
        'add_new_item' => _x( 'Add New Portfolio', 'portfolio' ,'delve' ),
        'edit_item' => _x( 'Edit Portfolio', 'portfolio' ,'delve' ),
        'new_item' => _x( 'New Portfolio', 'portfolio' ,'delve' ),
        'view_item' => _x( 'View Portfolio', 'portfolio' ,'delve' ),
        'search_items' => _x( 'Search Portfolio', 'portfolio' ,'delve' ),
        'not_found' => _x( 'No portfolio found', 'portfolio' ,'delve' ),
        'not_found_in_trash' => _x( 'No portfolio found in Trash', 'portfolio' ,'delve' ),
        'parent_item_colon' => _x( 'Parent portfolio:', 'portfolio' ,'delve' ),
        'menu_name' => _x( 'Portfolio', 'portfolio' ,'delve' ),
    );
	
	$rewrite = array(
    	'slug'                => 'delve_portfolio',
    	'with_front'          => true,
    	'pages'               => true,
    	'feeds'               => true,
	);
	
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'A post type for portfolio add Portfolio short code in description field.',
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'portfolio-categories', 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 10,
		'menu_icon' => 'dashicons-portfolio',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' =>  $rewrite,
        'capability_type' => 'page'
    );
    register_post_type( 'portfolio', $args );
}
// register portfolio categories
add_action( 'init', 'register_taxonomy_portfolio_categories' );
function register_taxonomy_portfolio_categories() {
    $labels = array( 
        'name' => _x( 'portfolio categories', 'portfolio_categories' ,'portfolio' ,'delve' ),
        'singular_name' => _x( 'Portfolio Category', 'portfolio_categories' ,'delve' ),
        'search_items' => _x( 'Search portfolio categories', 'portfolio_categories' ,'delve' ),
        'popular_items' => _x( 'Popular portfolio categories', 'portfolio_categories' ,'delve' ),
        'all_items' => _x( 'All Portfolio categories', 'portfolio_categories' ,'delve' ),
        'parent_item' => _x( 'Parent Portfolio Category', 'portfolio_categories' ,'delve' ),
        'parent_item_colon' => _x( 'Parent Portfolio Category:', 'portfolio_categories' ,'delve' ),
        'edit_item' => _x( 'Edit Portfolio Category', 'portfolio_categories' ,'delve' ),
        'update_item' => _x( 'Update Portfolio Category', 'portfolio_categories' ,'delve' ),
        'add_new_item' => _x( 'Add New Portfolio Category', 'portfolio_categories' ,'delve' ),
        'new_item_name' => _x( 'New Portfolio Category', 'portfolio_categories' ,'delve' ),
        'separate_items_with_commas' => _x( 'Separate portfolio categories with commas', 'portfolio_categories' ,'delve' ),
        'add_or_remove_items' => _x( 'Add or remove portfolio categories', 'portfolio_categories' ,'delve' ),
        'choose_from_most_used' => _x( 'Choose from the most used portfolio categories', 'portfolio_categories' ,'delve' ),
        'menu_name' => _x( 'Portfolio categories', 'portfolio_categories' ,'delve' ),
    );
    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );
    register_taxonomy( 'portfolio_categories', array('portfolio'), $args );
}
add_shortcode('delve_portfolio', 'delve_portfolio_function');
function delve_portfolio_function($atts = array()) {
    ob_start();
    delve_portfolio_view($atts);
    $content = ob_get_clean();
    return $content;
}

function delve_portfolio_view($atts = array()) {
    require_once( DELVE_PORTFOLIO_DIR . "/inc/view_portfolio.php");
}

function delve_portfolio_list_categories() {
    $_categories = get_categories('taxonomy=portfolio_categories');
    foreach ($_categories as $_cat) {
        ?>
            <a href="#" data-filter="<?php echo ".".$_cat->slug; ?>"><?php echo $_cat->name; ?></a>
        <?php
    }
}

function delve_portfolio_add_classes($post_id = null) {
	$retu = "";
    if ($post_id === null)
        return;
    $_terms = wp_get_post_terms($post_id, 'portfolio_categories');
    foreach ($_terms as $_term) {
        $retu.=$_term->slug." ";
    }
	return $retu;
}