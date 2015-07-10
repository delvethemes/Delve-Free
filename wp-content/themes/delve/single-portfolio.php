<?php
/**
 * The template for display Single Portfolio
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
 
get_header(); $content_class = 'col-md-9';
$sidebar_pos = 'right';
$content_style = '';
$sidebar_style = '';
$meta = get_post_custom( get_the_ID() );
if( isset($meta['delve_meta_sidebar_position'][0]))
	$sidebar_pos = $meta['delve_meta_sidebar_position'][0];

if( $sidebar_pos == 'none' ) {
	$content_class = 'col-md-12';
	$sidebar_style = 'style="display:none"';
} else if( $sidebar_pos == 'left' ) {
	$sidebar_style = 'style="float:left"';
	$content_style = 'style="float:right"';
}
?> 

<section>
	<div id="page" class="col-md-12 delve-main">
		<?php while ( have_posts() ) : the_post(); ?>
						
			<div id="content" class="row container">
            	<div class="col-md-12 portfolio-nav">
                <?php echo previous_post_link('%link', 'Previous');
						echo next_post_link('%link', 'Next'); ?>
                </div>
                
                <article>
					<div class="row delve_content" <?php echo $content_style; ?>>
						<div class="col-md-8 portfolio-single-thumb">
							<?php 
							$meta = get_post_custom( get_the_ID() );
							
							the_post_thumbnail(); ?>
						</div>
					
						<div class="col-md-4 delve-sidebar" <?php echo $sidebar_style; ?>>
							
                            	<?php the_title( '<h2 class="delve-entry-title">', '</h2>' ); ?>
                                    
							<div class="portfolio_content">
                                
                         		<div class="portfolio_info">
                                	<?php if( isset($meta['delve_meta_customer_name'] )) { ?>
										<div class="pinfo pcustomer_name">
                                    		<span>Customer : </span>
                                        	<span><?php echo $meta['delve_meta_customer_name'][0]; ?></span>
                                    	</div>
                                    <?php } ?>
                                    
                                    <?php if( isset($meta['delve_meta_portfolio_link'] )) { ?>
										<div class="pinfo plive_demo">
                                    		<span>Live Demo : </span>
                                        	<span><?php echo '<a href="http://'.$meta['delve_meta_portfolio_link'][0].'" 
													 target="_blank">'.$meta['delve_meta_portfolio_link'][0].'</a>';?></span>
                                    	</div>
                                    <?php } ?>
                                    
                                    <?php if( isset($meta['delve_meta_portfolio_link'] )) { ?>
										<div class="pinfo pcategory">
                                    		<span>Category : </span>
                                        	<span><?php echo delve_single_pf_cat(); ?></span>
                                    	</div>
                                    <?php } ?>
                                    
                                    <?php if( isset($meta['delve_meta_skills'] )) { ?>
										<div class="pinfo pcategory">
                                    		<span>Skills : </span>
                                        	<span><?php echo $meta['delve_meta_skills'][0]; ?></span>
                                    	</div>
                                    <?php } ?>
                                    
                                    <?php if( isset($meta['delve_meta_project_date'] )) { ?>
										<div class="pinfo pcategory">
                                    		<span>Date Post : </span>
                                        	<span><?php echo $meta['delve_meta_project_date'][0]; ?></span>
                                    	</div>
                                    <?php } ?>
                           	
									<?php the_tags('<div class="pinfo ptags"><span>Tags : </span><span> ',', ','.</span></div>'); ?>
                     
                                </div>
                                
                                <div class="portfolio-buttons">                                	
                                    
                                    <?php 
									if( isset($meta['delve_meta_portfolio_link'][0]))
										echo '<a href="http://'.$meta['delve_meta_portfolio_link'][0].'" class="portfolio-live-project">Live Project</a>'; ?>
                                </div>
							</div>
						</div>
                        <div class="col-md-12 no-padding-left">
                        	<?php the_content(); ?>
                        </div>
				</div> <!-- #content -->
            </article>
		<?php endwhile; ?>
	</div><!-- /#page -->	
</section><!-- /.section -->
<?php get_footer(); ?>