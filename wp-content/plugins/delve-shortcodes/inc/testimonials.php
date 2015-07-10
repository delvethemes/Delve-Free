<?php
/*
 Custom post type for testimonials functionality
*/

add_action( 'init', 'register_cpt_testimonials' );
function register_cpt_testimonials() {
    $labels = array(
        'name' => _x( 'Testimonials', 'testimonials' ,'delve' ),
        'singular_name' => _x( 'Testimonial', 'testimonials' ,'delve' ),
        'add_new' => _x( 'Add New Testimonial', 'testimonials' ,'delve' ),
        'add_new_item' => _x( 'Add New Testimonial', 'testimonials' ,'delve' ),
        'edit_item' => _x( 'Edit Testimonial', 'testimonials' ,'delve' ),
        'new_item' => _x( 'New Testimonial', 'testimonials' ,'delve' ),
        'view_item' => _x( 'View Testimonial', 'testimonials' ,'delve' ),
        'search_items' => _x( 'Search Testimonials', 'testimonials' ,'delve' ),
        'not_found' => _x( 'No Testimonials found', 'testimonials' ),
        'not_found_in_trash' => _x( 'No Testimonials found in Trash', 'testimonials' ,'delve' ),
        'parent_item_colon' => _x( 'Parent Tetimonials:', 'testimonials' ,'delve' ),
        'menu_name' => _x( 'Testimonials', 'testimonials' ,'delve' ),
    );
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'A post type for Testimonial add Testimonials shortcode in description field.',
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'testimonial-categories' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 12,
		'menu_icon' => 'dashicons-testimonial',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' =>  array('slug' => 'delve-testimonials'),
        'capability_type' => 'page'
    );
    register_post_type( 'Testimonials', $args );
}

// register testimonials categories
add_action( 'init', 'register_taxonomy_testimonial_categories' );
function register_taxonomy_testimonial_categories() {
    $labels = array( 
        'name' => _x( 'Testimonial Categories', 'testimonial_categories', 'testimonials', 'delve' ),
        'singular_name' => _x( 'Testimonial Category', 'testimonial_categories' ,'delve' ),
        'search_items' => _x( 'Search Testimonial Categories', 'testimonial_categories' ,'delve' ),
        'popular_items' => _x( 'Popular Testimonial Categories', 'testimonial_categories' ,'delve' ),
        'all_items' => _x( 'All Testimonial Categories', 'testimonial_categories' ,'delve' ),
        'parent_item' => _x( 'Parent Testimonial Category', 'testimonial_categories' ,'delve' ),
        'parent_item_colon' => _x( 'Parent Testimonial Category:', 'testimonial_categories' ,'delve' ),
        'edit_item' => _x( 'Edit Testimonial Category', 'testimonial_categories' ,'delve' ),
        'update_item' => _x( 'Update Testimonial Category', 'testimonial_categories' ,'delve' ),
        'add_new_item' => _x( 'Add New Testimonial Category', 'testimonial_categories' ,'delve' ),
        'new_item_name' => _x( 'New Testimonial Category', 'testimonial_categories' ,'delve' ),
        'separate_items_with_commas' => _x( 'Separate Testimonial Categories with commas', 'testimonial_categories' ,'delve' ),
        'add_or_remove_items' => _x( 'Add or remove Testimonial Categories', 'testimonial_categories' ,'delve' ),
        'choose_from_most_used' => _x( 'Choose from the most used Testimonial Categories', 'testimonial_categories' ,'delve' ),
        'menu_name' => _x( 'Testimonial Categories', 'testimonial_categories' ,'delve' ),
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
    register_taxonomy( 'testimonial_categories', array('testimonials'), $args );
}

add_shortcode('delve_testimonial_slider', 'delve_testimonial_slider_function');
function delve_testimonial_slider_function($atts) {
	$atts = shortcode_atts(
		array (
			'no_of_testimonials'	=> '-1',
			'img_position'			=> 'top',
			'style'					=> '',
			'class'					=> '',
		),$atts	);
		
	$wp_testimonials = null;
	$wp_testimonials = new WP_Query(array('post_type' => 'testimonials', 'posts_per_page' => $atts['no_of_testimonials'] ));
	
	$style = "";
	if( $atts['style'] != '') {
		$style = 'style="'.$atts['style'].'"';
	}
	
    ob_start();
	echo '<div id="t_slider" class="testimonials-slider-container '.$atts['img_position'].' '.$atts['class'].'" '.$style.'>';
	echo '<div class="testimonials-slider"><ul class="slides">';
	
	while ( $wp_testimonials->have_posts()) : $wp_testimonials->the_post();
		
		$postId = get_the_ID();
		$meta = get_post_custom($postId);
		
		echo '<li><span class="testimonial_image">';
		if(has_post_thumbnail())
			echo get_the_post_thumbnail( $postId, 'thumbnail' ).'</span>';
		else
			echo '<img width="150" height="60" src="'.DELVE_SHORTCODES_URL.'/images/testimonial.jpg" alt="Testimonial"/></div>';
		
		echo the_content();
		echo '<h5>'.get_the_title().'</h5>';
		if( isset($meta['delve_meta_testimonial'][0] ))
			echo '<p>'.$meta['delve_meta_testimonial'][0].'</p></li>';
	endwhile;
	
	echo '</ul></div></div>';
	wp_reset_query();
    $content = ob_get_clean();
    return $content;
}


add_shortcode('delve_testimonials', 'delve_testimonials_function');
function delve_testimonials_function($atts) {
	$atts = shortcode_atts(
		array (
			'column'	=> '2',
			'per_page'	=> '-1',
			'category'	=> '',
		),$atts	);
		
	if( $atts['column'] == 1 ) { $column_class = 'col-md-12'; }
	else if( $atts['column'] == 3 ) { $column_class = 'col-md-4'; }
	else if( $atts['column'] == 4 ) { $column_class = 'col-md-3'; }
	else if( $atts['column'] == 5 ) { $column_class = 'col-md-15 col-sm-3'; }
	else if( $atts['column'] == 6 ) { $column_class = 'col-md-2'; }
	else { $column_class = 'col-md-6'; }
		
	$wp_testimonials = null;
	$catWise = "";

	if( $atts['category'] ) {
		$catWise = array(
			array(
				'taxonomy' => 'testimonial_categories',
				'field'    => 'slug',
				'terms'    => $atts['category'],
			),
		);
	}
	
	$args = array(
		'post_type' => 'testimonials',
		'posts_per_page' => $atts['per_page'],
		'tax_query' => $catWise,
	);
	
	$wp_testimonials = new WP_Query($args);
	ob_start();
		
	echo '<div class="testimonials-container"><div id="delve-testimonials" class="testimonials">';
	while ( $wp_testimonials->have_posts()) : $wp_testimonials->the_post();
		
		$postId = get_the_ID();
		$meta = get_post_custom($postId);
		echo '<div class="'.$column_class.' testimonial-item-container">';
		echo '<div class="testimonial-item"><div class="testimonial-thumb">';
		if( get_the_post_thumbnail( $postId, 'thumbnail' ) )
			echo get_the_post_thumbnail( $postId, 'thumbnail' )."</div>";
		else
			echo '<img src="'.DELVE_SHORTCODES_URL.'/images/testimonial.jpg" alt="Testimonial"/></div>';
		echo '<div class="testimonial-content"><h3>'.get_the_title().'</h3>';
		echo '<p>'.$meta['delve_meta_testimonial'][0].'</p>';
		echo the_content();
		echo '</div></div></div>';
		
	endwhile;
	echo '</div></div>';
	
	wp_reset_query();
    $content = ob_get_clean();
    return $content;
}
