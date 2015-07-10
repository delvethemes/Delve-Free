<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */

get_header(); ?> 

<section>
   	<div id="index" class="row container">
		<div class="col-md-9 delve_content"> <?php 
			if ( have_posts() ) : 
						
				while ( have_posts() ) : the_post(); 
					get_template_part( 'content', 'blog' );
				endwhile; 
					delve_pagination();
				
			else : 
				get_template_part( 'content', 'none' );
			endif; ?>
		</div><!-- /.delve_content /.col-md-9 -->
           
		<div class="col-md-3 delve-sidebar">
			<aside>	<?php generated_dynamic_sidebar(); ?> </aside>
		</div>
           
	</div><!-- /.container-->
</section>   <!-- /.section -->

<?php get_footer(); ?>