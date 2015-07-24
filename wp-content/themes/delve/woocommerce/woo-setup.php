<?php
/**
 * Delve Theme woo commerce configration file
 *
 * WARNING: This file is part of the Delve Core Framework.
 * Do not edit the core files.
 *
 * @package  Delve/Template
 * @author   Delvethemes
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    die;
}

global $data;

// Don't duplicate me!
if( ! class_exists( 'DelveTemplateWoo' ) ) {

    /**
     * Class to apply woocommerce templates
     *
     * @since 4.0.0
     */
    class DelveTemplateWoo {

    	function __construct() {
			
			add_filter( 'woocommerce_show_page_title', array( $this, 'shop_title'), 10 );

    		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			add_action('woocommerce_before_main_content', array( $this, 'delve_wrapper_start' ), 10);
			add_action('woocommerce_after_main_content', array( $this, 'delve_wrapper_end' ), 10);
			
			/**
			 * Sidebar
			*/
			remove_action( 'woocommerce_sidebar' , 'woocommerce_get_sidebar', 10 );
    		add_action( 'woocommerce_sidebar', array( $this, 'add_sidebar' ), 10 );
			
			/**
    		 * Products Loop
    		 */
    		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'before_shop_item_buttons' ), 9 );
    		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'after_shop_item_buttons' ), 11 );

    		/**
    		 * Single Product Page
    		 */
    		add_action( 'woocommerce_single_product_summary', array( $this, 'add_product_border' ), 19 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );

    	} // end __construct();
		
		
		
		
		
		function delve_wrapper_start() {
			
			$d_cl = delve_content_layout( get_option( 'woocommerce_shop_page_id' ) );
			
			echo '<div id="woocommerce" class="col-md-12 delve-main"><div id="content" class="row container">
						<div class="'.$d_cl['c_class'].' delve_content delve_woo_content"'.$d_cl['c_style'].'>';
		}
		
		function shop_title() {
			return false;
		}

		function delve_wrapper_end() {
			echo '</div>';
		}
		
		function add_sidebar() {
			global $data;
			$c_page_ID = get_option( 'woocommerce_shop_page_id' );
			$d_cl = delve_content_layout( $c_page_ID );

			echo '<div class="col-md-3 delve-sidebar" '.$d_cl['s_style'].'><aside>';

			wp_reset_query();
			if(is_product()) {
				generated_dynamic_sidebar( $data['s_product-sidebar'] );
			} elseif(is_product_category() || is_product_tag()) {
				generated_dynamic_sidebar( $data['a_product-sidebar'] );
			} else {
				$shop_page_id = get_option('woocommerce_shop_page_id');
				$name = get_post_meta($shop_page_id, 'sbg_selected_sidebar_replacement', true);
				if($name) {
					generated_dynamic_sidebar($name[0]);
				}
			}

			echo '</aside></div></div></div>';
		} /******* Add sidebar over *********/

		function before_shop_item_buttons() {
			echo '<div class="product-buttons"><div class="product-buttons-container">';
		}

		function after_shop_item_buttons() {
			echo '<a href="' . get_permalink() . '" class="button show_details_button">' . __( 'Details', 'Delve' ) . '</a></div></div>';
		}
		
		function add_product_border() {
			echo '<div class="product-border"></div>';
		}

    } // end DelveTemplateWoo() class

}
new DelveTemplateWoo();

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

add_action('woocommerce_before_shop_loop_item_title', 'delve_woocommerce_thumbnail', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
function delve_woocommerce_thumbnail() {
	global $product, $woocommerce;

	$items_in_cart = array();

	if($woocommerce->cart->get_cart() && is_array($woocommerce->cart->get_cart())) {
		foreach($woocommerce->cart->get_cart() as $cart) {
			$items_in_cart[] = $cart['product_id'];
		}
	}

	$id = get_the_ID();
	$in_cart = in_array($id, $items_in_cart);
	$size = 'shop_catalog';
	$thumb_image = get_the_post_thumbnail($id , $size);
	

	echo '<div class="delve-poduct_img">';
	echo $thumb_image;
	if($in_cart) {
		echo '<span class="cart-loading"><i class="fa fa-check-square-o"></i></span>';
	} else {
		echo '<span class="cart-loading"><i class="fa fa-rotate-right fa-spin"></i></span>';
	}
	echo '</div>';
}

add_filter('loop_shop_per_page', 'delve_loop_shop_per_page');
function delve_loop_shop_per_page() {
	
	global $data;
	parse_str($_SERVER['QUERY_STRING'], $params);
	if($data['p_per_page']) {
		$per_page = $data['p_per_page'];
	} else {
		$per_page = 12;
	}

	$product_per_page = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	return $product_per_page;
}

/* cart hooks */
add_action('woocommerce_before_cart_table', 'delve_woocommerce_before_cart_table', 20);
function delve_woocommerce_before_cart_table( $args ) {
	global $woocommerce;
	$html = '<div class="woocommerce-cart-list">';
	$html .= '<h3 style="margin-top:0">' . sprintf( __( 'You Have %d Items In Your Cart', 'delve' ), $woocommerce->cart->cart_contents_count ) . '</h3><br>';
	echo $html;
}

add_action('woocommerce_after_cart_table', 'delve_woocommerce_after_cart_table', 20);
function delve_woocommerce_after_cart_table($args) {
	$html = '</div>';

	echo $html;
}

function cart_shipping_calc() {
	global $woocommerce;

	if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' ||  ! WC()->cart->needs_shipping() ) {
		return;
	}?>

	<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>

	<div class="shipping_calculator" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
		<h2><?php _e( 'Calculate Shipping', 'woocommerce' ); ?></h2>

		<section class="delve-shipping-calculator-form">

			<p class="delve-form-country">
				<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
					<option value=""><?php _e( 'Select a country&hellip;', 'woocommerce' ); ?></option>
					<?php
						foreach( WC()->countries->get_shipping_countries() as $key => $value )
							echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
					?>
				</select><span class="select-arrow"></span>
			</p>

			<p class="delve-shipping-calc-field delve-select-parent">
				<?php
					$current_cc = WC()->customer->get_shipping_country();
					$current_r  = WC()->customer->get_shipping_state();
					$states     = WC()->countries->get_states( $current_cc );

					// Hidden Input
					if ( is_array( $states ) && empty( $states ) ) {

						?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e( 'State / county', 'woocommerce' ); ?>" /><?php

					// Dropdown Input
					} elseif ( is_array( $states ) ) {

						?><span>
							<select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e( 'State / county', 'woocommerce' ); ?>">
								<option value=""><?php _e( 'Select a state&hellip;', 'woocommerce' ); ?></option>
								<?php
									foreach ( $states as $ckey => $cvalue )
										echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . __( esc_html( $cvalue ), 'woocommerce' ) .'</option>';
								?>
							</select>
						</span><?php

					// Standard Input
					} else {

						?><input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php _e( 'State / county', 'woocommerce' ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php

					}
				?>
			</p>

			<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

				<p class="delve-shipping-calc-field">
					<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php _e( 'City', 'woocommerce' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
				</p>

			<?php endif; ?>

			<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

				<p class="delve-shipping-calc-field">
					<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php _e( 'Postcode / Zip', 'woocommerce' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
				</p>

			<?php endif; ?>

			<p><button type="submit" name="calc_shipping" value="1" class="update-totals button default"><?php _e( 'Update Totals', 'woocommerce' ); ?></button></p>

			<?php wp_nonce_field( 'woocommerce-cart' ); ?>
		</section>
	</div>

	<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>

	<?php
}

add_action('woocommerce_cart_collaterals', 'delve_woocommerce_cart_collaterals', 5);
function delve_woocommerce_cart_collaterals($args)
{
	global $woocommerce;
	?>
	<div class="shipping-calculator">
		<?php echo cart_shipping_calc();?>
	</div>
	<?php
}

add_action('woocommerce_before_cart_totals', 'delve_woocommerce_before_cart_totals', 20);
function delve_woocommerce_before_cart_totals($args) {
	global $woocommerce; ?>

	<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
<?php }

add_action('woocommerce_after_cart', 'delve_woocommerce_after_cart');
function delve_woocommerce_after_cart($args) { ?>
	</form>
<?php }

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action('woocommerce_after_single_product_summary', 'delve_woocommerce_output_related_products', 15);
function delve_woocommerce_output_related_products() {
	
	$rp_column = 3;
	global $data;
	if( $data['s_product-sidebar-position']  == 'none' ) {
		$rp_column = 4;
	}
	
	$args = array(
		'posts_per_page' => $rp_column,
		'columns' => $rp_column,
		'orderby' => 'rand'
	);

	woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
}

/* end cart hooks */

/* begin my-account hooks */
add_action('woocommerce_before_customer_login_form', 'delve_woocommerce_before_customer_login_form');
function delve_woocommerce_before_customer_login_form() {
	
	global $woocommerce;
	if ( get_option( 'woocommerce_enable_myaccount_registration' ) !== 'yes' ) : ?>
		<div id="customer_login" class="woocommerce-small-box">
	<?php endif;
}

add_action('woocommerce_after_customer_login_form', 'delve_woocommerce_after_customer_login_form');
function delve_woocommerce_after_customer_login_form() {

	global $woocommerce;
	if ( get_option( 'woocommerce_enable_myaccount_registration' ) !== 'yes' ) : ?>
		</div>
	<?php endif;
}

add_action('woocommerce_before_my_account', 'delve_woocommerce_before_my_account');
function delve_woocommerce_before_my_account( $order_count, $edit_address = false) {
	
	global $smof_data, $woocommerce, $current_user;
	$edit_address = is_wc_endpoint_url('edit-address'); ?>
	<p class="delve_myaccount_user">
		<span class="myaccount_user_container">
			<span class="username">
				<?php
				printf(
					__( 'Hello, %s:', 'delve' ),
					$current_user->display_name
				); ?>
			</span>
	
			<span class="view-cart">
				<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id'));?>"><?php _e('View Cart', 'delve' );?></a>
			</span>
		</span>
	</p>
	
    <div class="woocommerce-tabs" >
		<ul class="woocommerce-side-nav delve-myaccount-nav">
			<?php if( $downloads = WC()->customer->get_downloadable_products() ) : ?>
                <li <?php if( ! $edit_address ) { echo 'class="active"'; } ?>>
                    <a class="downloads" href="#"><?php _e('View Downloads' , 'delve' ); ?></a>
                </li>
            <?php endif;
		
			$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
				'numberposts' => $order_count,
				'meta_key'    => '_customer_user',
				'meta_value'  => get_current_user_id(),
				'post_type'   => 'shop_order',
				'post_status' => 'publish'
			) ) );		

			if ( $customer_orders ) : ?>
				<li <?php if( ! $edit_address && ! WC()->customer->get_downloadable_products() ) { echo 'class="active"'; } ?>>
					<a class="orders" href="#">	<?php _e('View Orders' , 'delve' ); ?></a>
				</li>
			<?php endif; ?>
			
			<li <?php if( $edit_address || ! WC()->customer->get_downloadable_products() && ! $customer_orders ) 
			  { echo 'class="active"'; } ?>>
				<a class="address" href="#"><?php _e('Change Address' , 'delve' ); ?></a>
			</li>
			
			<li><a class="account" href="#"><?php _e('Edit Account' , 'delve' ); ?></a></li>
		</ul>

	<div class="woocommerce-full-box delve-myaccount-data">
<?php }

add_action('woocommerce_after_my_account', 'delve_woocommerce_after_my_account');
function delve_woocommerce_after_my_account($args) {
	
	global $woocommerce, $wp;
	$user = wp_get_current_user();	?>
	<h2 class="edit-account-heading"><?php _e( 'Edit Account', 'delve' ); ?></h2>

	<form class="edit-account-form" action="" method="post">
		<p class="form-row form-row-first">
			<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php esc_attr_e( $user->first_name ); ?>" /></p>
        
		<p class="form-row form-row-last">
			<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php esc_attr_e( $user->last_name ); ?>" /></p>
        
		<p class="form-row form-row-wide">
			<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="email" class="input-text" name="account_email" id="account_email" value="<?php esc_attr_e( $user->user_email ); ?>" /></p>
        
		<p class="form-row form-row-first">
			<label for="password_1"><?php _e( 'Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_1" id="password_1" /></p>
        
		<p class="form-row form-row-last">
			<label for="password_2"><?php _e( 'Confirm new password', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_2" id="password_2" />
		</p><div class="clear"></div>

		<p><input type="submit" class="profile-save button default medium alignright" name="save_account_details" value="<?php _e( 'Save changes', 'woocommerce' ); ?>" /></p>

		<?php wp_nonce_field( 'save_account_details' ); ?>
		<input type="hidden" name="action" value="save_account_details" />
		<div class="clearboth"></div>
	</form>
</div>
<?php }
/* end my-account hooks */

/**
 * Custom icon for PayPal payment option on WooCommerce checkout page.
*/
function delve_extended_paypal_icon() {
    return get_template_directory_uri().'/images/paypal-payments.jpg';
}
add_filter( 'woocommerce_paypal_icon', 'delve_extended_paypal_icon' );


/****** ordering ******/
add_filter( 'get_product_search_form' , 'delve_product_search_form' );
function delve_product_search_form( $form ) {
	$form  = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/' ) ) . '"> <div>';
	$form .= '<input type="text" value="'.get_search_query().'" name="s" id="s" placeholder="'. __( 'Search...', 'delve' ).'" />';
	$form .= '<input type="hidden" name="post_type" value="product" /></div></form>';

	return $form;
}


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action('woocommerce_before_shop_loop', 'delve_woocommerce_catalog_ordering', 30);
function delve_woocommerce_catalog_ordering() {
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);
	$query_string = '?'.$_SERVER['QUERY_STRING'];

	// replace it with theme option
	if($data['p_per_page']) {
		$per_page = $data['p_per_page'];
	} else {
		$per_page = 12;
	}

	$pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	if( ! empty( $params['product_order'] ) ) {
		$po = $params['product_order'];
	} else {
		switch($pob) {
			case 'date':
				$po = 'desc';
			break;
			case 'price':
				$po = 'asc';
			break;
			case 'popularity':
				$po = 'asc';
			break;
			case 'rating':
				$po = 'desc';
			break;
			case 'name':
				$po = 'asc';
			break;
			case 'default':
				$po = 'asc';
			break;				
		}
	}
	
	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering">';

	$html .= '<div class="orderby-order-container">';

	$html .= '<ul class="orderby order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><span class="current-li-content"><a aria-haspopup="true">'.__('Sort by', 'delve').' <strong>'.__('Default Order', 'delve').'</strong></a></span></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pob == 'default') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'default').'">'.__('Sort by', 'delve').' <strong>'.__('Default Order', 'delve').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'name') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'name').'">'.__('Sort by', 'delve').' <strong>'.__('Name', 'delve').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'price') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'price').'">'.__('Sort by', 'delve').' <strong>'.__('Price', 'delve').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'date') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'date').'">'.__('Sort by', 'delve').' <strong>'.__('Date', 'delve').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'popularity') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'popularity').'">'.__('Sort by', 'delve').' <strong>'.__('Popularity', 'delve').'</strong></a></li>';
	$html .= '<li class="'.(($pob == 'rating') ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_orderby', 'rating').'">'.__('Sort by', 'delve').' <strong>'.__('Rating', 'delve').'</strong></a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';


	$html .= '<ul class="order">';
	if($po == 'desc'):
	$html .= '<li class="desc"><a aria-haspopup="true" href="'.tf_addURLParameter($query_string, 'product_order', 'asc').'"><i class="fa fa-arrow-up"></i></a></li>';
	endif;
	if($po == 'asc'):
	$html .= '<li class="asc"><a aria-haspopup="true" href="'.tf_addURLParameter($query_string, 'product_order', 'desc').'"><i class="fa fa-arrow-down"></i></a></li>';
	endif;
	$html .= '</ul>';

	$html .= '</div>';

	$html .= '<ul class="sort-count order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a aria-haspopup="true">'.__('Show', 'delve').' <strong>'.$per_page.' '.__(' Products', 'delve').'</strong></a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_count', $per_page).'">'.__('Show', 'delve').' <strong>'.$per_page.' '.__('Products', 'delve').'</strong></a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_count', $per_page*2).'">'.__('Show', 'delve').' <strong>'.($per_page*2).' '.__('Products', 'delve').'</strong></a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.tf_addURLParameter($query_string, 'product_count', $per_page*3).'">'.__('Show', 'delve').' <strong>'.($per_page*3).' '.__('Products', 'delve').'</strong></a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	$html .= '</div>';

	echo $html;
}

if( ! isset($smof_data['woocommerce_delve_ordering'] )) {
	add_action('woocommerce_get_catalog_ordering_args', 'delve_woocommerce_get_catalog_ordering_args', 20);
}
function delve_woocommerce_get_catalog_ordering_args($args)
{
	global $woocommerce;
	parse_str($_SERVER['QUERY_STRING'], $params);
	$pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	$po = !empty($params['product_order'])  ? $params['product_order'] : 'asc';

	switch($pob) {
		case 'date':
			$orderby = 'date';
			$order = 'desc';
			$meta_key = '';
		break;
		case 'price':
			$orderby = 'meta_value_num';
			$order = 'asc';
			$meta_key = '_price';
		break;
		case 'popularity':
			$orderby = 'meta_value_num';
			$order = 'asc';
			$meta_key = 'total_sales';
		break;
		case 'rating':
			$orderby = 'meta_value_num';
			$order = 'desc';
			$meta_key = 'average_rating';
		break;
		case 'name':
			$orderby = 'title';
			$order = 'asc';
			$meta_key = '';
		break;
		case 'default':
			return $args;
		break;
	}

	switch($po) {
		case 'desc':
			$order = 'desc';
		break;
		case 'asc':
			$order = 'asc';
		break;
		default:
			$order = 'asc';
		break;
	}

	$args['orderby'] = $orderby;
	$args['order'] = $order;
	$args['meta_key'] = $meta_key;

	if( $pob == 'rating' ) {
		$args['orderby']  = 'menu_order title';
		$args['order']    = $po == 'desc' ? 'desc' : 'asc';
		$args['order']	  = strtoupper( $args['order'] );
		$args['meta_key'] = '';

		add_filter( 'posts_clauses', 'order_by_rating_post_clauses' );
	}

	return $args;
}

function tf_addURLParameter($url, $paramName, $paramValue) {
     $url_data = parse_url($url);
     if(!isset($url_data["query"]))
         $url_data["query"]="";

     $params = array();
     parse_str($url_data['query'], $params);
     $params[$paramName] = $paramValue;

     if( $paramName == 'product_count' ) {
     	$params['paged'] = '1';
     }

     $url_data['query'] = http_build_query($params);
     return tf_build_url($url_data);
}

function tf_build_url($url_data) {
     $url="";
     if(isset($url_data['host']))
     {
         $url .= $url_data['scheme'] . '://';
         if (isset($url_data['user'])) {
             $url .= $url_data['user'];
                 if (isset($url_data['pass'])) {
                     $url .= ':' . $url_data['pass'];
                 }
             $url .= '@';
         }
         $url .= $url_data['host'];
         if (isset($url_data['port'])) {
             $url .= ':' . $url_data['port'];
         }
     }
     if (isset($url_data['path'])) {
     	$url .= $url_data['path'];
     }
     if (isset($url_data['query'])) {
         $url .= '?' . $url_data['query'];
     }
     if (isset($url_data['fragment'])) {
         $url .= '#' . $url_data['fragment'];
     }
     return $url;
}
 
/**
 * order_by_rating_post_clauses function.
 *
 * @access public
 * @param array $args
 * @return array
 */
function order_by_rating_post_clauses( $args ) {
	global $wpdb;

	$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating, SUM( $wpdb->comments.comment_approved ) as sum_of_comments_approved ";

	$args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";
	//$args['where'] .= " AND $wpdb->comments.comment_approved = 1";

	$args['join'] .= "
		LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
		LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
	";

	parse_str($_SERVER['QUERY_STRING'], $params);
	$order = ! empty($params['product_order']) ? $params['product_order'] : 'desc';
	$order = strtoupper($order);

	$args['orderby'] = "sum_of_comments_approved DESC, average_rating {$order}, $wpdb->posts.post_date DESC";
	$args['groupby'] = "$wpdb->posts.ID";
	
	return $args;
}

/****** Thank you page *******/
remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
add_action('woocommerce_thankyou', 'delve_woocommerce_view_order', 10);


function delve_woocommerce_view_order( $order_id ) { 
	global $woocommerce;
	$order = new WC_Order( $order_id ); ?>
    
	<div class="delve-order-details woocommerce-content-box full-width">
		<h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
		<table class="shop_table order_details">
			<thead>
				<tr>
					<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
					<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
					<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
				</tr>
			</thead>
        
            <tfoot> <?php
                if ( $totals = $order->get_order_item_totals() ) foreach ( $totals as $total ) : ?>
                    <tr>
                        <td class="filler-td">&nbsp;</td>
                        <th scope="row"><?php echo $total['label']; ?></th>
                        <td class="product-total"><?php echo $total['value']; ?></td>
                    </tr>
                <?php endforeach;	?>
            </tfoot>
		
            <tbody>	<?php
                if ( sizeof( $order->get_items() ) > 0 ) {
    
                    foreach( $order->get_items() as $item ) {
                        
                        $_product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item($item), $item );
                        $item_meta = new WC_Order_Item_Meta( $item['item_meta'] ); ?>
                        
                        <tr class="<?php echo esc_attr(apply_filters('woocommerce_order_item_class','order_item',$item,$order));?>">
                            <td class="product-name">
                                <span class="product-thumbnail"> <?php
                                
                                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image() );
                                    if ( ! $_product->is_visible() )
                                        echo $thumbnail;
                                    else
                                        printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail ); ?>
                                </span>
                                
                                <div class="product-info"> <?php
                                
                                    if ( $_product && ! $_product->is_visible() )
                                        echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );
                                    else
                                        echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['product_id'] ), $item['name'] ), $item );
    
                                    $item_meta->display();
                                    if ( $_product && $_product->exists() && $_product->is_downloadable() && $order->is_download_permitted() ) {
    
                                        $download_files = $order->get_item_downloads( $item );
                                        $i = 0; $links = array();
    
                                        foreach ( $download_files as $download_id => $file ) {
                                            $i++;
    
                                            $links[] = '<small><a href="' . esc_url( $file['download_url'] ) . '">' . sprintf( __( 'Download file%s', 'woocommerce' ), ( count( $download_files ) > 1 ? ' ' . $i . ': ' : ': ' ) ) . esc_html( $file['name'] ) . '</a></small>';
                                        }
    
                                        echo '<br/>' . implode( '<br/>', $links );
                                    } ?>
                                </div>
                            </td>
                            
                            <td class="product-quantity">
                                <?php echo apply_filters( 'woocommerce_order_item_quantity_html', $item['qty'], $item ); ?>
                            </td>
                            
                            <td class="product-total">
                                <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                            </td>
                        </tr> <?php
    
                        if ( in_array( $order->status, array( 'processing', 'completed' ) ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) ) { ?>
                        
                            <tr class="product-purchase-note">
                                <td colspan="3"><?php echo apply_filters( 'the_content', $purchase_note ); ?></td>
                            </tr> <?php
                        }
                    }
                }
    
                do_action( 'woocommerce_order_items_table', $order );?>
            </tbody>
		</table>
	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</div><!-- /.delve-order-details -->

<div class="delve-customer-details woocommerce-full-box">
	<header><h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2></header>
    
	<dl class="customer_details">
		<?php
		if ( $order->billing_email ) echo '<dt>'.__( 'Email :', 'woocommerce' ).'</dt> <dd>'.$order->billing_email.'</dd><br />';
		if ( $order->billing_phone ) echo '<dt>'.__( 'Telephone :', 'woocommerce' ).'</dt> <dd>'.$order->billing_phone.'</dd>';

		// Additional customer details hook
		do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
	</dl>

	<?php //if ( get_option( 'woocommerce_ship_to_billing_address_only' ) === 'no' && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

	<div class="row addresses">
		<div class="col-md-6">
	<?php //endif; ?>
			<header class="title"><h2><?php _e( 'Billing Address', 'woocommerce' ); ?></h2></header>
            
			<address><p>
				<?php if ( ! $order->get_formatted_billing_address() ) _e( 'N/A', 'woocommerce' ); 
					else echo $order->get_formatted_billing_address(); ?>
			</p></address>

	<?php //if ( get_option( 'woocommerce_ship_to_billing_address_only' ) === 'no' && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>
		</div><!-- /.col-md-6 -->

		<div class="col-md-6">
			<header class="title"><h2><?php _e( 'Shipping Address', 'woocommerce' ); ?></h2></header>
			<address><p>
				<?php if ( ! $order->get_formatted_shipping_address() ) _e( 'N/A', 'woocommerce' );
					else echo $order->get_formatted_shipping_address(); ?>
			</p></address>
		</div><!-- /.col-md-6-->
	</div><!-- /.row -->
	<?php //endif; ?>
	<div class="clear"></div>
	</div><br /><br />
<?php }

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	
	global $woocommerce;
	$cart_url = $woocommerce->cart->get_cart_url();
	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
	$cart_contents_count = $woocommerce->cart->cart_contents_count;
	$cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'delve'), $cart_contents_count);
	$cart_total = $woocommerce->cart->get_cart_total();
	
	ob_start(); ?>
    	<div class="cart-contents">
		<?php foreach($woocommerce->cart->cart_contents as $cart_item): ?>
				<li class="cart-content">
                    <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                        <?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
                        <?php echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail'); ?>
                        <div class="cart-desc">
                            <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                            <span class="product-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
            
            <li>
                <div class="cart-checkout">
                    <div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('View Cart', 'delve'); ?></a></div>
                    <div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'delve'); ?></a></div>
                </div>
            </li>
            </div>

<?php
	$fragments['div.cart-contents'] = ob_get_clean();
	return $fragments;
}

function woocommerce_template_single_sharing()
{
	global $smof_data;
	$nofollow = ' rel="nofollow"';

	$social = '<h3 style="text-align:left">'.__('Share This Product','Delve').'</h3><div style="clear:both;"></div>';	
		$social .= '<ul class="social-share clearfix">
			<li class="facebook">
				<a href="http://www.facebook.com/sharer.php?s=100&p&#91;url&#93;=' . get_permalink() . '&p&#91;title&#93;=' . wp_strip_all_tags(get_the_title(), true) .'" target="_blank"' . $nofollow .'>
					<i class="fa square-yes fa-facebook"></i>
				</a>
			</li>
			<li class="twitter">
				<a href="https://twitter.com/share?text=' . wp_strip_all_tags(get_the_title(), true) .' ' . get_permalink() . '" target="_blank"' . $nofollow .'>
					<i class="fa square-yes fa-twitter"></i>
				</a>
			</li>
			<li class="googleplus">
				<a href="https://plus.google.com/share?url=' . wp_strip_all_tags(get_the_title(), true) .' ' . get_permalink() . '" target="_blank"' . $nofollow .'>
					<i class="fa square-yes fa-google-plus"></i>					
				</a>
			</li>			
			<li class="email">
				<a href="mailto:?subject=' . wp_strip_all_tags(get_the_title(), true) . '&amp;body=' . get_permalink() . '" target="_blank"' . $nofollow .'>
					<i class="fa square-yes fa-envelope"></i>					
				</a>
			</li>
		</ul>';

	echo $social;
}