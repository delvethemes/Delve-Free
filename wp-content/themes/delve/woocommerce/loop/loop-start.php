<?php
/**
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.5
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $data;

// Store column count for displaying the grid
if( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 1 );
}

	$sidebar_pos ="";
// Reset according to sidebar or fullwidth pages
if( is_shop() || is_product_category() || is_product_tag() ) {
	
	$meta = get_post_custom( get_option( 'woocommerce_shop_page_id' ) );
	if(isset($meta['delve_meta_sidebar_position'][0]))
		$sidebar_pos = $meta['delve_meta_sidebar_position'][0];
	
	
	if( is_product_category() || is_product_tag() ) {
		$sidebar_pos = $data['a_product-sidebar-position'];
	}
	
	if( is_shop() || ( is_product_category() || is_product_tag() )) {
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	} else {
		$woocommerce_loop['columns'] = 3;
	}

}
?>
<ul class="products clearfix product-columns-<?php echo $woocommerce_loop['columns']; ?>">