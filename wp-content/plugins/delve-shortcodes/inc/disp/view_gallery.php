<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
?>

<div class="row delveGalleryContainer">
	<?php 

/*	if ( 5 == $atts['column'] ) {
		$col="15 col-sm-3";
	}
*/	
	$spinner = "";$mask="";
	$class = "circle colored effect1";
	
	if( $atts['effect'] <= 5 ) {
		$class = "circle colored";
	} else if( $atts['effect'] > 5 && $atts['effect'] <= 10 ) {
		$class = "square colored";
	}
		
	if( $atts['effect'] == 1 ) {
		$spinner = '<div class="spinner"></div>';
		$class .= " effect1";
	} else if( $atts['effect'] == 2 ) {
		$class .= " effect2 left_to_right";
	} else if( $atts['effect'] == 3 ) {
		$class .= " effect3 left_to_right";
	} else if( $atts['effect'] == 4 ) {
		$class .= " effect16 right_to_left";
	} else if( $atts['effect'] == 5 ) {
		$class .= " effect20 top_to_bottom";
	} else if( $atts['effect'] == 6 ) {
		$class .= " effect3 bottom_to_top";
	} else if( $atts['effect'] == 7 ) {
		$mask = '<div class="mask1"></div><div class="mask2"></div>';
		$class .= " effect4";
	} else if( $atts['effect'] == 8 ) {
		$class .= " effect9 bottom_to_top";
	} else if( $atts['effect'] == 9 ) {
		$class .= " effect10 right_to_left";
	} else if( $atts['effect'] == 10 ) {
		$class .= " effect12 top_to_bottom";
	}

	if( $atts['category'] ) {
		$catWise = array(
			array(
				'taxonomy' => 'gallery_categories',
				'field'    => 'slug',
				'terms'    => $atts['category'],
			),
		);
	}	
	
	if(empty($catWise))
		$catWise = "";
		
	$args = array(
		'post_type' => 'gallery',
		'posts_per_page' => $atts['per_page'],
		'tax_query' => $catWise,
	);
	
	$gallery = new WP_Query($args);
	 
	while ($gallery->have_posts()) : $gallery->the_post(); 
	
		$meta = get_post_custom(get_the_ID());
		
		$info = '<div class="info">';
		if( $atts['effect'] == 5 || $atts['effect'] == 8 ) 	$info .= '<div class="info-back">';
		$info .= '<h3>'.get_the_title().'</h3><p>'.$meta['delve_meta_g_tag_line'][0].'</p>';
		if( $atts['effect'] == 5 || $atts['effect'] == 8 ) 	$info .= '</div>';
		$info .= '</div>';
		
		$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
            	
		<div class="col-md-3 delveGalleryItem">
			<div class="ih-item <?php echo $class; ?>">  
				<a href="<?php echo $img_url[0]; ?>" data-gal="prettyPhoto[delve_gallery]">		
					<?php echo $spinner; ?>
					<div class="img"><?php the_post_thumbnail(); ?></div>
					<?php echo $mask;
						echo $info; ?>
				</a>
			</div>
		</div>
	<?php endwhile; ?>
    
</div>