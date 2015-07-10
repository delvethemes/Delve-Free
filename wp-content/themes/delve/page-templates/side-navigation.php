<?php

/**

 * Template Name: Side Navigation

 *

 * The template for displaying content width side navigation/menu

 *

 * @package WordPress

 * @subpackage Delve_Theme

 * @since Delve Theme 1.0

 */



get_header();



$content_class = 'col-md-9';

$sidebar_pos = 'right';

$content_style = '';

$sidebar_style = '';

$meta = get_post_custom( get_the_ID() );

$sidebar_pos = $meta['delve_meta_sidebar_position'][0];



$side_nav_pos ="side-nav-right";

if( $sidebar_pos == 'left' ) {

	$sidebar_style = 'style="float:left;"';

	$content_style = 'style="float:right"';

	$side_nav_pos = "side-nav-left";

}



$background = "";

if( $meta['delve_meta_page_bg_color'][0] ) {

	$background = "style = 'background-color : ".$meta['delve_meta_page_bg_color'][0].";'";

}

?>  

 	

<section>

	<div id="side-navigation" class="row delve-main" <?php echo $background; ?>>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="content" class="row container">

				<div class="<?php echo $content_class; ?> delve_content" <?php echo $content_style; ?>>

					<article>

						<?php 

						if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 

							$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );?>

							<div class="delve-page-thumbnnail">

								<a href="<?php echo $link[0]; ?>" data-gal="prettyPhoto"><?php the_post_thumbnail(); ?></a>

							</div>

						<?php endif;

												

						the_content();

						bootstrap_link_pages();	?>

					</article>

					<?php endwhile; else: ?>

						<p><?php _e('Sorry, no posts matched your criteria.','delve'); ?></p>

					<?php endif; ?>

				</div>



				<div id="delve-side-navbar" class="col-md-3 delve-side-navbar" <?php echo $sidebar_style; ?>>

					<aside>

                    	<div class="side-navbar-menu <?php echo $side_nav_pos; ?>">

							<?php 

							$meta = get_post_custom( get_the_ID() );

							$menu_name = $meta['delve_meta_side_nav_menu'][0];

							wp_nav_menu(  array('menu' => $menu_name) ); ?>

                        </div>

					</aside>

				</div>

			</div> <!-- #content -->

            

	</div><!-- /#page -->	

</section><!-- /.section -->

<br /><br />

<?php get_footer(); ?>