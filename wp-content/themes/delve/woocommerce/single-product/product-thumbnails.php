<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.5
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;
$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) { ?>
	
    <div id="singleProductCarousel" class="product-thumbnails">
		<ul class="list-inline delve-sp-thumbnails">
			<?php // From product-image.php
			if ( has_post_thumbnail() ) {
				
				$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_thumbnail' ), array( 'title' => $image_title ) );

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a id="carousel-selector-0" class="selected">%s</a></li>', $image ), $attachment_id, $post->ID, $image_class );
			}

			$loop = 0;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
			
			foreach ( $attachment_ids as $attachment_id ) {
				
				$classes[] = 'image-'.$attachment_id." img-responsive";
				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail') );
				$image_class = esc_attr( implode( ' ', $classes ) );

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a id="carousel-selector-%s">%s</a></li>', $loop+1, $image ), $attachment_id, $post->ID, $image_class );

				$loop++;
			} ?>
		</ul>
	</div>
<?php }