<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
 
?>

<div class="portfolioFilter">
    <a href="#" data-filter="*" class="current">All</a>
    <?php delve_portfolio_list_categories(); ?>
</div>

<div class="row portfolioContainer">
<?php 

	$col=3;
	if($atts['column']) {
		$col=12/$atts['column'];
	}
	//$col = ceil( $col );
	if ( 5 == $atts['column'] )
	{
		$col="15 col-sm-3";
	}
	$portfolio = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => '-1'));
 	$i=1;
	while ($portfolio->have_posts()) : $portfolio->the_post();
		
		$postid = get_the_ID();
		$main_class = delve_portfolio_add_classes($postid);
		$meta = get_post_custom($postid);
		$pf_url=$meta['delve_admin_portfolio_link'][0];
	
		if($meta['delve_admin_video_link'][0])
			$link=$meta['delve_admin_video_link'][0];  ?>
            
	<div class="col-md-<?php echo $col; ?> portfolio_item <?php echo delve_portfolio_add_classes($postid); ?>" >
    	
         <div class="portfolio_design">
         	<div class="portfolio_icons">
            	<a href="<?php echo $link; ?>" rel="prettyphoto['portfolio']">
            		<i class="fa fa-search"></i>
            	</a>
            	<a href="<?php echo $pf_url; ?>">
            		<i class="fa fa-link"></i>
            	</a>
            </div>
         </div>
			<?php the_post_thumbnail(); ?> 
    </div>
    	
<?php endwhile; ?>

</div>
