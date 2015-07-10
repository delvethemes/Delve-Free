<?php
/**
 * The template for displaying Search Results pages
 *
 * Contains footer content and the closing of the #wrapper div elements.
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
 
get_header(); ?>
 	
<section>
	<div id="search" class="col-md-12 delve-main">
		<div id="content" class="row container">
			<div class="col-md-9 delve_content">
				<article>
					<?php if ( have_posts() ) :
						// Start the Loop.
						while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_format() );
						endwhile;
					
					else :
						// If no content, include the "No posts found" template.
						get_template_part( 'content', 'none' );
					endif; ?>
				</article>
			</div>

			<div class="col-md-3 delve-sidebar">
				<aside>
					<?php generated_dynamic_sidebar(); ?>
				</aside>
			</div>
		</div> <!-- #content -->
            
	</div><!-- /#page -->	
</section><!-- /.section -->

<?php get_footer(); ?>