<?php

/**

 * Template Name: Only Container

 *

 * The template for creating a page without header and footer.

 *

 * @package WordPress

 * @subpackage Delve_Theme

 * @since Delve Theme 1.0

 */

?>



<!DOCTYPE HTML>

<html xmlns="http<?php echo (is_ssl())? 's' : ''; ?>://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />

    <!--[if IE]>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1" />



    <!--<title><?php wp_title('|', true, 'right'); ?></title>-->

    

    <!-- Favicon Icon -->

    <?php global $data;?>

	<?php if( isset($data['site-favicon']) && $data['site-favicon']['url'] ): ?>

		<link rel="favicon icon" href="<?php echo $data['site-favicon']['url']; ?>" type="image/x-icon" />

	<?php endif;

	

	$object_id = get_queried_object_id();

	if((get_option('show_on_front') && get_option('page_for_posts') && is_home()) ||

	    (get_option('page_for_posts') && is_archive() && !is_post_type_archive()) && !(is_tax('product_cat') || is_tax('product_tag')) || (get_option('page_for_posts') && is_search())) {

		$c_page_ID = get_option('page_for_posts');

	} else {

		if(isset($object_id)) {

			$c_page_ID = $object_id;

		}



		if(class_exists('Woocommerce')) {

			if(is_shop() || is_tax('product_cat') || is_tax('product_tag')) {

				$c_page_ID = get_option('woocommerce_shop_page_id');

			}

		}

	}

	

    wp_head(); ?>

	

	<!--[if lte IE 9]>

		<script src="<?php echo TEMPLATE_PATH; ?>/js/html5shiv.js" type="text/javascript"></script>

		<script src="<?php echo TEMPLATE_PATH; ?>/js/respond.js" type="text/javascript"></script>

	<![endif]-->

    

	<style type="text/css"><?php echo $data['custom-css'];	?></style>

    

    <script type="text/javascript"><?php echo $data['custom-header-js'];?></script>

</head>



<body  <?php body_class(); ?>>    

    <?php 

	 

    if( is_page() ) { ?>

	    <div id="page-slider" class="page-slider">

			<?php

				$meta = get_post_custom(get_the_ID()); 

			

				if( $meta['delve_meta_rev_slider'][0] ) {

					$delve_slider = '[rev_slider ' .$meta['delve_meta_rev_slider'][0]. ']';

					echo do_shortcode( $delve_slider ); 

				} ?>

		</div>

    <?php } 

	

	delve_titlebar($c_page_ID); 

	

	?>



    

<div id="wrapper" class="wrapper clearfix">

<?php

$meta = get_post_custom( get_the_ID() );

$background = "";

if( $meta['delve_meta_page_bg_color'][0] ) {

	$background = "style = 'background-color : ".$meta['delve_meta_page_bg_color'][0].";'";

}



$d_cl = delve_content_layout( get_the_ID() ); ?>



<section>

	<div id="page" class="row delve-main">

		<div id="content" class="row container">

			<div class="<?php echo $d_cl['c_class']; ?> delve_content" <?php echo $d_cl['c_style']; ?>>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <article>

						<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 

							$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );?>

							<div class="delve-page-thumbnnail">

								<a href="<?php echo $link[0]; ?>" data-gal="prettyPhoto"><?php the_post_thumbnail(); ?></a>

							</div>

						<?php endif; ?>

						

						<?php the_content();

						bootstrap_link_pages(); ?>

					</article>

				<?php endwhile; else: ?>

					<p><?php _e('Sorry, no posts matched your criteria.','delve'); ?></p>

				<?php endif; ?>

			</div>



			<div class="col-md-3 delve-sidebar" <?php echo $d_cl['s_style']; ?>>

				<aside><?php generated_dynamic_sidebar(); ?></aside>

			</div>

			

		</div> <!-- #content -->     

	</div><!-- /#page -->	

</section><!-- /.section -->



</div> <!-- Wrapper -->

<?php wp_footer(); ?>

<script><?php echo $data['custom-footer-js'];	?></script>

</body>

</html>