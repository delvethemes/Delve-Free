<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
 
get_header(); 
//$d_cl = delve_content_layout( get_the_ID() );
?>
<section>
	<div id="single" class="col-md-12 delve-main">
		<div id="content" class="row container">
            <?php while ( have_posts() ) : the_post(); 
				$next_post = get_next_post();
				$prev_post = get_previous_post(); ?>
				
                <div class="col-md-9 delve_content">
               		<?php if( !empty( $next_post )  || !empty( $prev_post ) ) { ?>   
						<div class="post_nxtprv_btn">
                        	<!--<div class="post_prv_btn">
								<?php previous_post_link( '%link', _x( 'Previous', 'Previous post link', 'delve' ) ); ?>
							</div>
							<div class="post_nxt_btn">
								<?php next_post_link( '%link', _x( 'Next', 'Next post link', 'delve' ) ); ?>
							</div>  -->
						</div>
					<?php } ?>
                    
                    <?php get_template_part( 'content', get_post_format() ); ?>   
                   	<?php comments_template(); ?>
				</div>
			<?php endwhile; ?>
			<div class="col-md-3 delve-sidebar">
				<aside>	<?php generated_dynamic_sidebar(); ?></aside>
			</div>
            
		</div> <!-- /#content -->
	</div><!-- /#single -->	
</section><!-- /.section -->
<?php get_footer(); ?>