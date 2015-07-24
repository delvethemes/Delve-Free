<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
 
get_header(); ?>

<section>
	<div id="404" class="col-md-12 delve-main">
		<div id="content" class="row container">
			<div class="col-md-12 page-not-found delve_content">
				<article>
					<h3><?php _e( 'Oops, This Page Could Not Be Found!', 'delve' ); ?></h3>
					<p> <?php _e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'delve' ) ?> </p>
                    <div class="image-404">
                 		<?php 					
                 	   	if( isset( $data['image-404']['url'] ) && $data['image-404']['url'] != "" )
							echo '<img src="' .$data['image-404']['url'] .'" alt="404 Not Found" />';
						else
							echo '<img src="' .TEMPLATE_PATH .'/images/404.png" alt="404 Not Found" />';
						?>                        
                       
                    </div>
					<div class="search-404">
						<?php get_search_form(); ?>
                    </div>
				</article><br /><br />
			</div>
		</div> <!-- #content -->
            
	</div><!-- /#404 -->	
</section><!-- /.section -->
<?php get_footer(); ?>