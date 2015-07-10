<?php

/**

 * The template for displaying all pages

 *

 * This is the template that displays all pages by default.

 * Please note that this is the WordPress construct of pages and that

 * other 'pages' on your WordPress site will use a different template.

 *

 * @package WordPress

 * @subpackage Delve_Theme

 * @since Delve Theme 1.0

 */



get_header();



$d_cl = delve_content_layout( get_the_ID() ); ?>



<section>

	<div id="page" class="row delve-main">

		<div id="content" class="row container">

			<div class="<?php echo $d_cl['c_class']; ?> delve_content" <?php echo $d_cl['c_style']; ?>>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <article>

						<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 

							$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );?>

							<div class="delve-page-thumbnnail">

								<a href="<?php echo $link[0]; ?>" data-gal="prettyPhoto"><?php the_post_thumbnail(); ?></a>

							</div>

						<?php endif; ?>

						

						<?php the_content();

						bootstrap_link_pages(); ?>

					</article>

				<?php endwhile; else: ?>

					<p><?php _e('Sorry, no posts matched your criteria.','delve'); ?></p>

				<?php endif; ?>

			</div>



			<div class="col-md-3 delve-sidebar" <?php echo $d_cl['s_style']; ?>>

				<aside><?php generated_dynamic_sidebar(); ?></aside>

			</div>

			

		</div> <!-- #content -->     

	</div><!-- /#page -->	

</section><!-- /.section -->



<?php get_footer(); ?>