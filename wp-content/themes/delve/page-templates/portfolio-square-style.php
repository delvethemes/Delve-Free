<?php
/**
 * Template Name:  Portfolio Square Style
 *
 * The template for displaying square style portfolio
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */

get_header();

$d_cl = delve_content_layout( get_the_ID() );
?>  
 	
<section>
	<div id="portfolio-square" class="row container" <?php echo $d_cl['background']; ?>>
		<div class="<?php echo $d_cl['c_class']; ?> delve_content" <?php echo $d_cl['c_style']; ?>>
        	<?php if( $data['portfolio-switch'] ): ?>
			<div class="portfolioFilter">
				<a href="#" data-filter="*" class="current">All</a>
				<?php delve_portfolio_list_categories(); ?>
			</div>

			<div class="row portfolioContainer">
				<?php
				$portfolio = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => '-1'));
 				$i=1;
	
				while ($portfolio->have_posts()) : $portfolio->the_post();
					$main_class=delve_portfolio_add_classes(get_the_ID());					
					$meta = get_post_custom(get_the_ID());
					$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
					
					if(isset($meta['delve_admin_video_link'][0])) {
						$link=$meta['delve_admin_video_link'][0]; } ?>           		
          
            		<div class="<?php echo $d_cl['columns']; ?> portfolio-item-container <?php echo $main_class; ?>">
						<div class="portfolio-item">
         					<div class="portfolio-design">
         						<div class="portfolio_info_container">
                                	<span class="portfolio_info">
            						<a href="<?php echo $link[0]; ?>" data-gal="prettyPhoto['portfolio']">
            							<i class="fa fa-search"></i>
            						</a>
            						<a href="<?php echo esc_url( get_permalink() ); ?>">
            							<i class="fa fa-link"></i>
            						</a>
                                    </span>
            					</div>
         					</div>
							<?php the_post_thumbnail(); ?> 
    					</div>
                        
						<div class="portfolio-content alternative_css" >
							<span class="pcontent">
								<span class="portfolio-title"><strong><?php the_title(); ?></strong></span>
								<?php echo string_limit_words( get_the_content(), $d_cl['string'] ); ?> ...
                       		</span>
						</div>
                    </div>
				<?php endwhile; ?>
			</div>
            <?php else:?>
            	<p>Please activate Portfolio plugin from Plugins section and enable option from Delve Options > Home Settings</p>
            <?php endif;?>
		</div> <!-- .delve_content -->
        
		<div class="col-md-3 delve-sidebar" <?php echo $d_cl['s_style']; ?>>
			<aside><?php generated_dynamic_sidebar(); ?></aside>
		</div>
	</div> <!-- #portfolio -->       	
</section><!-- /.section -->
<br /><br />
<?php get_footer(); ?>