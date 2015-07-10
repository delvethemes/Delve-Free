<?php
/**
 * The template for displaying Author archive pages
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
 
get_header(); ?>

<section>
	<div id="author" class="col-md-12 delve-main">
		<div id="content" class="row container">
			<div class="col-md-9 delve_content">
				<article>
                   	<?php
					if ( have_posts() ) :
						
						$author_id    = get_the_author_meta('ID');
						$name         = get_the_author_meta('display_name', $author_id);
						$avatar       = get_avatar( get_the_author_meta('email', $author_id), '82' );
						$description  = get_the_author_meta('description', $author_id);
							
						if(empty($description)) {
							$description  = __("This author has not yet filled in any details.", 'delve' );
							$description .= '</br>'.sprintf( __( 'So far %s has created %s entries.', 'delve' ),
								 $name, count_user_posts( $author_id ) );
						} ?>
                     
						<div class="author_info">
							<div class="avatar"><?php echo $avatar ?></div>
							
                            <div class="author_description">
								<h3 class='author_title'>
									<?php echo '<i class="fa fa-user"></i>  '.get_the_author_link(); ?>
									<?php if(current_user_can('edit_users') || get_current_user_id() == $author_id): ?>
										<span class="edit_profile">
                                			<a href="<?php echo admin_url( 'profile.php?user_id=' . $author_id ); ?>">
											<?php echo __( 'Edit profile', 'delve' ) ?></a>
										</span>
									<?php endif; ?>
								</h3>
								<?php echo $description; ?>
							</div>
						</div>
                    	
						<?php rewind_posts();
						
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
				<aside>	<?php generated_dynamic_sidebar(); ?> </aside>
			</div>
			
		</div> <!-- #content -->    
	</div><!-- /#page -->	
</section><!-- /.section -->

<?php get_footer(); ?>