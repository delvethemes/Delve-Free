<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.5
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product;

if ( ! $product->is_purchasable() ) return;

// Availability
$availability      = $product->get_availability();
$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
	
echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );

if ( $product->is_in_stock() ) : 
	do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
	 	if ( ! $product->is_sold_individually() )
	 		woocommerce_quantity_input( array(
	 			'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 			'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
		 	) ); ?>

	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
           
        <button id="hover-icon-add-to-cart" type="submit" class="single_add_to_cart_button eff-btn hover-icon normal top-to-bottom"><div class="ss-icon-on-hover"><i class="fa fa-shopping-cart"></i></div><span><?php echo $product->single_add_to_cart_text(); ?></span></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>
    
	<?php do_action( 'woocommerce_after_add_to_cart_form' );
endif; ?>