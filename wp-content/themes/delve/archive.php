<?php 
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */

get_header(); ?>  
 	
<section>
	<div id="archive" class="col-md-12">
		<div id="content" class="row container">
			<div class="col-md-9 delve_content">
				<?php 
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile;
      
				else :
					get_template_part( 'content', 'none' );
				endif; ?>
			</div>
			
			<div class="col-md-3 delve-sidebar">
				<aside><?php generated_dynamic_sidebar(); ?></aside>
			</div>
		</div> <!-- #content -->
            
	</div><!-- /#archive -->	
</section><!-- /.section -->

<?php get_footer(); ?>