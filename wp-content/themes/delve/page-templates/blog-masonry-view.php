<?php
/**
 * Template Name: Blog Masonry View
 *
 * The template for displaying blog/posts in masonry view
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
	<div id="blog-masonry" class="row container" <?php echo $d_cl['background']; ?>>
		<div class="<?php echo $d_cl['c_class']; ?> delve_content blog_layout" <?php echo $d_cl['c_style']; ?>>
			<?php if ( have_posts() ) :
					$wp_query= null;
					$wp_query = new WP_Query();
					$wp_query->query('post_type=post'.'&paged='.$paged); ?>
					
                    <div class="row blog_item_container">
						<?php while ( $wp_query->have_posts() ) : $wp_query->the_post() ?>
                    		<div class="<?php echo $d_cl['columns']; ?>">
								<?php //get_template_part( 'content', 'blog' ); ?> 
                                    
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<header class="delve-entry-header"> <?php 
										if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) :  
										
											$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
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
    
									<?php the_title( '<div class="delve_heading"><h2 class="delve-entry-title">
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
                                        
                                        <?php
                                        if( $d_cl['columns'] == 'col-md-12 delve-col-1' || 
											$d_cl['columns'] == 'col-md-6 delve-col-2' ) { ?>
                                        	<span class="post-icon"><i class="fa fa-calendar"></i></span> <?php
											the_date('F j, Y');
                                        	echo " - ";
                                        	the_time(); 
										} ?>
                                        
										<?php if( get_tags() && $d_cl['columns'] == 'col-md-12 delve-col-1' ) { 
											the_tags('<i class="fa fa-tags"></i> ',', ','.'); 
										} ?> 
                                        
                                        <span class="post-icon"><i class="fa fa-comments"></i></span> <?php 
                                        comments_popup_link(__('No Comments', 'delve'), __('1 Comment', 'delve'), 
											'% '.__('Comments', 'delve')); ?>
									</div> 

                                    <div class="entry-content">
                                         <?php
										 	if( $columns == 'col-md-12 delve-col-1' ) {	$string = 80; }
											if( $columns == 'col-md-6 delve-col-2' ) { $string = 50; }
											if( $columns == 'col-md-4 delve-col-3' ) { $string = 28; }
											if( $columns == 'col-md-3 delve-col-4' ) { $string = 15; }
										 
										 echo string_limit_words( get_the_excerpt(), $string ); ?> ...
                                    </div><!-- .entry-content -->
    
                                 	<footer class="entry-meta">
                                            
                                    	<?php if ( comments_open() && ! is_single() ) : ?>
                                        	<div class="comments-link">
                                            	<?php /* comments_popup_link( ' ' . __( 'Leave a comment', 'delve' ) . ' '
                                                 , __( 'One comment so far', 'delve' ), __( 'View all % comments', 'delve' ) );*/ ?>
                                                   
                                                <?php 
													echo do_shortcode('[st_button_more href="'.get_permalink( get_the_ID()).'"]');
												?>
                                        	</div><!-- .comments-link -->
                                    	<?php endif; ?>
                                    
                                	</footer><!-- .entry-meta -->
								</article> 
							</div>
						<?php endwhile; ?>
					</div>  
				<?php delve_pagination(); ?>
                    
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