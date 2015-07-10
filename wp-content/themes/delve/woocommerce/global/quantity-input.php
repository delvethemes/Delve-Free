<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="input-group quantity">
	<span class="input-group-btn">
		<button title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" type="button" class="minus btn-number" data-type="minus" data-field="<?php echo esc_attr( $input_name ); ?>">
			<span class="minus">-</span>
		</button>
	</span>
		  
	<input type="text" step="<?php echo esc_attr( $step ); ?>" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" name="<?php echo esc_attr( $input_name ); ?>" class="qty form-control input-number" value="<?php echo esc_attr( $input_value ); ?>" <?php if ( is_numeric( $min_value ) ) : ?>min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?> <?php if ( is_numeric( $max_value ) ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?>>
          
	<span class="input-group-btn">
		<button type="button" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" class="plus btn-number" data-type="plus" data-field="<?php echo esc_attr( $input_name ); ?>">
			<span class="plus">+</span>
		</button>
	</span>
</div>
