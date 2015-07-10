<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
?>
<?php
if (!function_exists('dynamic_sidebar') || !is_active_sidebar('delve-blog-sidebar')): ?>
	<div id="secondary">
		<?php
		$name = get_bloginfo( 'name', 'display' );
		$description = get_bloginfo( 'description', 'display' ); ?>
		<h3><?php echo esc_html( $name ); ?></h3>
		
		<?php if ( ! empty ( $description ) ) : ?>
            <span><?php echo esc_html( $description ); ?></span>
		<?php endif; ?>
   		<?php get_search_form(); ?>
        <span class="default-sidebar-notice">
        	This is default sidebar, You can create your own sidebar from backend widget option avalable "Blog Sideabar".
        </span>
        
	</div><!-- #secondary -->
<?php
else:
	generated_dynamic_sidebar('delve-blog-sidebar');
endif; ?>