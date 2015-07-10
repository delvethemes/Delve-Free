<?php
/**
 * Template Name: Single Page
 *
 * The template for creating single page/one page theme
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
?>
<?php get_header(); ?>
<div id="delve-single-page-theme" class="row delve-main">
<?php
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		the_content();
	} // end while
} // end if
?>
<?php
$menu_location = 'singlepage-menu';
$menu_locations = get_nav_menu_locations();
$menu_object = (isset($menu_locations[$menu_location]) ? wp_get_nav_menu_object($menu_locations[$menu_location]) : null);
$menu_name = (isset($menu_object->name) ? $menu_object->name : '');
if ( ($menu = wp_get_nav_menu_object( $menu_name ) ) && ( isset($menu) ) ) {
	$i=0;
	$menu_items = wp_get_nav_menu_items($menu->term_id);
	$sid=1;
	foreach ( (array) $menu_items as $key => $menu_item ) {
		$objid=$menu_item->object_id;
		$page_data=get_post($objid);
		
		if( $menu_item->object!="custom" ) {
			$id=$page_data->post_name."-".$page_data->ID;
			$content=apply_filters('the_content',$page_data->post_content);
			$meta=get_post_custom( $objid );
			/*$color=$meta[ 'delve_meta_page_color' ][0];
			$iconIndex=$meta[ 'delve_meta_top_icon' ][0];*/
			
			$background = "";
			if( $meta['delve_meta_page_bg_color'][0] ) {
				$background = "style = 'background-color : ".$meta['delve_meta_page_bg_color'][0].";'";
			}
			$arr[]=$page_data->post_name;
			?>
            
			<div id="<?php echo $page_data->ID; ?>" class="col-md-12 singlepage-container <?php echo $id; ?> " <?php echo $background; ?>>				
            <section>
            <div id="content" class="row container">
                <div class="col-md-12 singlepage-header">
					<?php 
                    if( $meta['delve_meta_page-heading'][0] ) { ?>
						<h1><?php echo $meta['delve_meta_page-heading'][0]; ?></h1>
                    <?php } else { ?>
                    	<?php echo "<h1>" . $page_data->post_title . "</h1>"; ?>
                    <?php } ?>
					<?php if( $meta['delve_meta_tag-line'][0] ) {	
								echo "<span class='tag-line'>".$meta['delve_meta_tag-line'][0]."</span>"; }?>
                </div>
                
                <div class="col-md-12 inner_content">        
					<?php //echo do_shortcode( $content );
							//echo apply_filters('siteorigin_panels_render',$content);
							if(function_exists('siteorigin_panels_render'))
								echo siteorigin_panels_render( $objid );
							else
								echo $content;
					 ?>
				</div>                
			</div>
            </section> </div><?php
		} else if( $menu_item->object == "custom" ) { ?>
			<div class="section s<?php echo $sid; $sid++; ?> rsec"></div>
		<?php }
	}
} ?>
</div>
<?php get_footer(); ?>