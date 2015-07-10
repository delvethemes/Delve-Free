<?php
/**
 * The Header for theme.
 *
 * Displays all of the <head> section and everything up till <div id="wrapper">
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
    <nav id="top_nav" class="navbar navbar-inverse" role="navigation">
    	<?php if( $data['topbar-switch'] && ( $data['topbar-left'] != "" || $data['topbar-right'] != "" ) ) { ?>
        <div class="delve-top-nav">
        	<div class="row container">
            	<div class="col-md-6 delve-top-nav-left">
                <?php if( $data['topbar-left'] == 'secondary-menu' ) {
						delve_secondary_nav(); 
				} else if( $data['topbar-left'] == 'social-icons' ) {
						 delve_social_icon();
				} else if( $data['topbar-left'] == 'contact-details'){ 
                	if( $data['contact-number'] ) { ?>
                	<span class="top-nav-opt top-nav-cotact"><i class="fa fa-mobile-phone fa-lg"></i> 
                    	Call us: <?php echo $data['contact-number']; ?></span>
					<?php } if( $data['mail-addr'] ) { ?>
                    <span class="top-nav-opt top-nav-email"><i class="fa fa-envelope-o fa-lg"></i> 
						<?php echo $data['mail-addr']; ?></span>
                <?php } }?>
                </div>
                
                <div class="col-md-6 delve-top-nav-right">
					<?php if( $data['topbar-right'] == 'contact-details' ) { ?>
						<span class="top-nav-opt top-nav-cotact"><i class="fa fa-mobile-phone fa-lg"></i> 
							Call us: <?php echo $data['contact-number']; ?></span>
						<span class="top-nav-opt top-nav-email"><i class="fa fa-envelope-o fa-lg"></i> 
							<?php echo $data['mail-addr']; ?></span>
					<?php } else if( $data['topbar-right'] == 'social-icons' ) {
						 delve_social_icon();
					} else if( $data['topbar-right'] == 'secondary-menu' ){
						delve_secondary_nav(); 
					}?>
                    
                    <?php if( $data['place_cart_icon']['cart_top_bar'] ) { 
							 if ( class_exists( 'WooCommerce' ) ) {
								global $woocommerce;
									
								if( isset($data['topbar-right']) && $data['topbar-right'] != 'social-icons' ) {
				 ?>
									<ul class="topbar-cart-menu" >
										<li class="menu-item menu-item-has-children dropdown delve-cart-btn">
											<span class="cart-btn"><a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i></a></span>
										
											<ul class="dropdown-menu">
												<li class="dropdown">
													<div class="cart-contents">
														<ul>
															<li class="cart-content"></li>
														</ul>
													</div>
												</li>
											</ul>
										</li>
									</ul>
						 <?php   } 
					          }
				   		   }?>
                </div>
            </div>
       </div>
       <?php } ?>
        
           <?php global $data;
			$item_wrap='<ul id="main-menu" class="%2$s nav navbar-nav menu-menu">%3$s</ul>';
			$theme_loc='primary-menu';
	
			if ( is_page_template('page-templates/single-page.php') ) {
				$item_wrap='<ul id="main-menu" class="%2$s nav navbar-nav menu-menu"><li class="hidden">
                        <a href="#page-top"></a>
                    </li><li><a href="#top_nav" class="page-scroll">Home</a></li>%3$s</ul>';
				$theme_loc='singlepage-menu';
			}
				
			$delve_nav_menu = array(
				'theme_location'  => $theme_loc,
				'menu'            => '',
				'depth'			  => 2,
				'container'       => '',
				'container_class' => 'menu-header',
				'container_id'    => '',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => 'delve_nav_fallback',
				'before'          => '',
				'after'           => '',
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => $item_wrap,
				'depth'           => 0,
				'walker'          => new delve_nav_walker()/*new delve_nav_walker()*/
			); 
			$header_version= "header-v1.php";

		    if($data['header-versions'])
		    	$header_version= $data['header-versions'].".php";

           include( locate_template( 'inc/headers/'.$header_version ) ); ?>
	</nav>
    <?php 	include(locate_template('inc/headers/sticky-header.php'));
    if( is_page() ) { ?>
	    <div id="page-slider" class="page-slider">
			<?php
				$meta = get_post_custom(get_the_ID()); 
			
				if( isset($meta['delve_meta_rev_slider'][0] )) {
					$delve_slider = '[rev_slider ' .$meta['delve_meta_rev_slider'][0]. ']';
					echo do_shortcode( $delve_slider ); 
				} ?>
		</div>
    <?php } 
	
	delve_titlebar($c_page_ID); 
	
	?>
<div id="wrapper" class="wrapper clearfix">