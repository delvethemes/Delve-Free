<?php
/**
 * Template Name: Blog Timeline View
 *
 * The template for displaying blog/posts in timeline view
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */

get_header(); 

$d_cl = delve_content_layout( get_the_ID() );
$meta = get_post_custom( $c_page_ID );
$columns = $meta['delve_meta_page_columns'][0];
?> 

<section>
	<div id="blog-timeline" class="row container" <?php echo $d_cl['background']; ?>>
		<div class="<?php echo $d_cl['c_class']; ?> delve_content blog_layout" <?php echo $d_cl['c_style']; ?>>
			<?php if ( have_posts() ) :
					$wp_query= null;
					$wp_query = new WP_Query();
					$wp_query->query('post_type=post'.'&posts_per_page=-1');
					$post_count = 1;
                    ?>
					
                    <div class="row timeline-item-container">
						<?php while ( $wp_query->have_posts() ) : $wp_query->the_post() ?>
                        	<?php
							$post_timestamp = strtotime($post->post_date);
							$post_month = date('n', $post_timestamp);
							$post_year = get_the_date('o');
							$current_date = get_the_date('o-n'); ?>
                            
							<?php if($prev_post_month != $post_month): ?>
								<div class="timeline-date">
                                	<h6 class="timeline-title">
										<?php echo get_the_date('F Y'); ?>
                                     </h6>
                                 </div>
							<?php endif; ?>
                            <?php 
								if(($post_count % 2)>0) {
									$post_count_class = " timeline-align-left ";
									$tclass = "right";
								} else {
									$post_count_class = " timeline-align-right ";
									$tclass = "left";
								} ?>
                                
							<article id="post-<?php the_ID(); ?>" <?php post_class($post_class.$post_count_class.' clearfix') ?>>
								<header class="delve-entry-header"> <?php 
									if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 
										
										$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );?>
										<div class="blog_animation">
                                            	<div class="blog_anim_info_container">
                                                    <div class="blog_anim_info">
                                                    	<a href="<?php echo $link[0]; ?>" data-gal="prettyPhoto[blog]">
                                                        	<i class="fa fa-search"></i>
                                                    	</a>
                                                    	<a href="<?php echo esc_url( get_permalink() ); ?>">
                                                        	<i class="fa fa-link"></i>
                                                    	</a>
                                                    	<h5><?php the_title(); ?></h5>
                                                    </div>
                                                </div>
                                            </div>
										<div class="delve-entry-thumbnail">
											<?php the_post_thumbnail(); ?>
										</div>
									<?php endif; ?>
								</header><!-- .entry-header -->	
                                    
								<div class="tooltipa timeline-circle" data-placement="<?php echo $tclass ?>" data-original-title="<?php the_time('d M, Y'); ?>"></div>
								<div class="timeline-arrow"></div>
                                    
                                    <?php the_title( '<div class="timeline-post-title"><h2 class="delve-entry-title">
									<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>
									</div>' ); ?>
                                    
                                    <?php edit_post_link( __( 'Edit', 'delve' ), '<span class="edit-link">
										<i class="fa fa-edit"></i>', '</span>' ); ?>
                                        
                                     <div class="post_meta">
										<span class="post-icon"><i class="fa fa-user"></i></span> <?php
										echo __('By ', 'delve'); 
										the_author_posts_link(); ?>
                                        
                                        <?php
                                        if( $d_cl['columns'] != 'col-md-3 delve-col-4') { ?>
                                        	<span class="post-icon"><i class="fa fa-file-text"></i></span> <?php 
                                        	the_category(', '); 
										}?>
                                        
									</div> 
                                    
									<div class="time-line-entry-content">
                                         <?php echo string_limit_words( get_the_excerpt(), 12 ); ?> ...
                                    </div><!-- .entry-content -->
                                    
                                    <footer class="entry-meta"> <?php
										if ( comments_open() && ! is_single() ) :
											echo do_shortcode('[st_button_more href="'.get_permalink( get_the_ID()).'"]'); 
										endif; ?>
                                	</footer><!-- .entry-meta --> 
                                    
                                    <div class="post_date">
										<span class="post-icon"><i class="fa fa-calendar"></i></span> <?php
										the_date('F Y');
                                        echo " - ";
                                        the_time(); ?>
                                        
                                        <span class="post-icon"><i class="fa fa-comments"></i></span> 
										<?php comments_popup_link(__('0', 'delve'),	__('1', 'delve'), '%'); ?>
									</div>  
							</article>
						<?php 
						$prev_post_timestamp = $post_timestamp;
						$prev_post_month = $post_month;
						$post_count++;
						endwhile; ?>
					</div>  
				
                    
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
              
		</div><!-- /.delve_content /.col-md-12 -->
		<div class="col-md-3 delve-sidebar" <?php echo $d_cl['s_style']; ?>>
            <aside>
				<?php generated_dynamic_sidebar(); ?> 
            </aside>
		</div>
	</div><!-- /.delve_content -->
</section>   <!-- /.section -->
    
<?php get_footer(); ?>