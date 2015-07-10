<?php 
/**
 * Template Name: 100% Full Width
 *
 * The template for creating 100% full width page
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
 
get_header();

$meta = get_post_custom( get_the_ID() );
$background = "";
if( $meta['delve_meta_page_bg_color'][0] ) {
	$background = "style = 'background-color : ".$meta['delve_meta_page_bg_color'][0].";'";
}
?>
 	
<section>
	<div id="full_width" class="row delve-main" <?php echo $background; ?>>
		<div id="content" class="row full-width-container">
			<div class="col-md-12 delve_content">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <article>
                    	<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 
							$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );?>
							<div class="delve-page-thumbnnail">
								<a href="<?php echo $link[0]; ?>" data-gal="prettyphoto"><?php the_post_thumbnail(); ?></a>
							</div>
						<?php endif;
						
						the_content();
						bootstrap_link_pages(); ?>
					</article>
				<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.','delve'); ?></p>
				<?php endif; ?>
			</div>
		</div> <!-- #content -->     
	</div><!-- /#page -->	
</section><!-- /.section -->

<?php get_footer(); ?>