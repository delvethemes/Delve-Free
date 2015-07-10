<?php
/**
 * The template to register widgets and call all custom widgets
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
?>
<?php
// Register widget locations
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id' => 'delve-blog-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget_heading"><i class="fa fa-star"></i>',
		'after_title' => '</div>',
	));
	global $data;
	$col = 4;
	$col = $data['opt-fcolumn'];
	for($sidebar=1; $sidebar<=$col; $sidebar++){
		register_sidebar(array(
			'name' => 'Footer Widget '.$sidebar,
			'id' => 'delve-footer-widget-'.$sidebar,
			'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
			'after_widget' => '<div class="clear"></div></div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));
	}	
}// register sidebar function exists
include_once('tab-widget.php');
include_once('flickr-widget.php');
include_once('facebook-like-widget.php');
include_once('125_125.php');
include_once('social_links.php');
include_once('contact_info.php');
include_once('recent-works-widget.php');