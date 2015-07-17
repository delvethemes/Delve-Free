<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.5
 */ 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $woocommerce, $product; 
$attachment_count   = count( $product->get_gallery_attachment_ids() );				
?>
 
<!-- main slider carousel -->
<div class="images">
	<div id="singleProductSlider" class="carousel slide">
		
        <!-- main slider carousel items -->
		<div class="carousel-inner">
			<?php if ( has_post_thumbnail() ) {
				$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
				
				$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(	'title' => $image_title ), array( 'title' => $image_title ) );
				
				if ( $attachment_count > 0 ) {
					$gallery = '[product-gallery]';
				} else {
					$gallery = '';
				}
									
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="active item" data-slide-number="0"><a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-gal="prettyPhoto' . $gallery . '">%s</a></div>', $image_link, $image_title, $image ), $post->ID );
				/**
				 * From product-thumbnails.php
				*/
				$attachment_ids = $product->get_gallery_attachment_ids();
				$loop = 0;
				foreach ( $attachment_ids as $attachment_id ) {	
					
					$classes[] = 'image-'.$attachment_id;
					$image_link = wp_get_attachment_url( $attachment_id );
					if ( ! $image_link )
						continue;
					// modified image size to shop_single from thumbnail
					$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_single' ) );
					$image_class = esc_attr( implode( ' ', $classes ) );
					$image_title = esc_attr( get_the_title( $attachment_id ) );
						
					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="item" data-slide-number="%s"><a href="%s" itemprop="image" class="woocommerce-item-image zoom" title="%s" data-gal="prettyPhoto' . $gallery . '">%s</a></div>',$loop+1, $image_link, $image_title, $image ), $attachment_id, $post->ID, $image_class );
					
					$loop++;
				}
			} else {
				
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="item active" data-slide-number="0"><img src="%s" alt="Placeholder" /></div>', wc_placeholder_img_src() ), $post->ID );
			}?> 
            </div>
        
		<?php if ( $attachment_count > 0 ) {?>
				<a class="carousel-control left" href="#singleProductSlider" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#singleProductSlider" data-slide="next">&rsaquo;</a>
        <?php } ?>
	</div>
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div><!--/main slider carousel-->