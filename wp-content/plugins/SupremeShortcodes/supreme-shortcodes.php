<?php
/*
		Plugin Name: Supreme Shortcodes
		Plugin URI: http://supremewptheme.com/plugins/supreme-shortcodes/
		Description: Supreme Shortcodes plugin contains more than <strong>100 shortcodes</strong>. This plugin works perfect as an addition to the <strong>Visual Composer</strong>, but it also <strong>works beautiful as a standalone</strong>. You can choose from static elements such as: <strong>Boxes, Responsive rows and columns, Lines and dividers</strong> to animated elements such as: <strong>3D Buttons, Modals and Popovers or Toggles and Tabs</strong>. Pretty much <strong>anything needed</strong> for todays modern web presentation.
		Version: 0.2.6
		Author: Supremefactory
		Author URI: http://supremewptheme.com
		License: Copyright (c) 2014 Supremefactory. All rights reserved.

		Copyright 2014  SUPREMEFACTORY

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License, version 2, as
		published by the Free Software Foundation.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, <http://www.gnu.org/licenses/>.
*/

	$shortname = 'SupremeShortcodes'; // must be the same as theme folder name //

	$supremeshortcodes_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodes');


	// ADD IMAGE SIZE SUPPORT
	add_image_size( 'carousel', 266, 155, true );
	add_image_size( 'swiper', 600, 450, true );


	// UPDATER
	if ( is_admin() ){
		require dirname(__FILE__) . '/update-notifier.php';
	}

	// TRANSLATION SUPPORT
	add_action( 'plugins_loaded', 'SupremeShortcodes__load_textdomain' );
	function SupremeShortcodes__load_textdomain(){
		load_plugin_textdomain( 'SupremeShortcodes', false,  dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/*
 * Adds WP ajax library path.
 */
if (!function_exists('SupremeShortcodes__add_ajax_library')) {
      function SupremeShortcodes__add_ajax_library(){
            $html = '<script type="text/javascript">';
            $html .= 'var ajaxurl = "' . admin_url('admin-ajax.php') . '"';
            $html .= '</script>';
            echo $html;
      }
}

add_action('wp_enqueue_scripts', 'SupremeShortcodes__add_ajax_library');


	// ALL SHORTCODES
	require_once dirname(__FILE__) . '/shortcodes.php';

	// ADD FUNCTIONS
	require_once dirname(__FILE__) . '/includes/functions.php';

	// ADD ADMIN MENU
	require_once dirname(__FILE__) . '/admin/supreme-shortcodes-admin.php';

	// CHANGE COLORS
	if ( ! function_exists( 'SupremeShortcodes__change_colors' ) ) {
		function SupremeShortcodes__change_colors() {
		    require_once dirname(__FILE__) . '/includes/supreme-shortcodes-change-colors.php';
		}
	}
	add_action('wp_head', 'SupremeShortcodes__change_colors', '99');

	// CUSTOM CSS
	if ( ! function_exists( 'SupremeShortcodes__user_css' ) ) {
		function SupremeShortcodes__user_css() {
			$custom_css = stripslashes(get_option('SupremeShortcodes__custom_css'));
			echo '<style type="text/css">'.$custom_css.'</style>';
		}
	}
	add_action('wp_head', 'SupremeShortcodes__user_css');

	// MAKE PLUGIN TRANSLATABLE
	load_plugin_textdomain('SupremeShortcodes', false, basename( dirname( __FILE__ ) ) . '/languages' );

	// FRONT END STYLES AND SCRIPTS
	function SupremeShortcodes__shortcodes_stylesheet() {
		global $post, $shortname;

		?>
		<script type="text/javascript">
			var stPluginUrl = "<?php echo plugins_url(); ?>/SupremeShortcodes",
				ss_theme_dir = "<?php echo plugins_url(); ?>/SupremeShortcodes",
				ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>",
				ss_captcha_placeholder = "<?php echo _e('CAPTCHA', $shortname) ?>",
				ss_captcha_invalid_txt = "<?php echo _e('Invalid. Try again.', $shortname) ?>",
				ss_captcha_correct_txt = "<?php echo _e('Captcha correct.', $shortname) ?>";
		</script>
		<?php

		$loadJquery = get_option('SupremeShortcodes__load_jquery');
		$loadTwitterBootstrap = get_option('SupremeShortcodes__load_bootstrap');
		$loadFontAwesome = get_option('SupremeShortcodes__load_font_awesome');
		$loadSwiper = get_option('SupremeShortcodes__load_swiper');
		$loadAnimate = get_option('SupremeShortcodes__load_animate');
		$loadMediaelement = get_option('SupremeShortcodes__load_mediaelement');
		$loadFlexslider = get_option('SupremeShortcodes__load_flexslider');
		$loadGcharts = get_option('SupremeShortcodes__load_g_charts');
		$loadGmaps = get_option('SupremeShortcodes__load_g_maps');
		$loadPinterest = get_option('SupremeShortcodes__load_pinterest');
		$loadTumbler = get_option('SupremeShortcodes__load_tumbler');
		$loadFancybox = get_option('SupremeShortcodes__load_fancybox');
		$loadSVGDrawings = get_option('SupremeShortcodes__load_svg_drawings');
		$loadIconMelon = get_option('SupremeShortcodes__load_iconmelon');


		if ($loadJquery == 'yes') {
			wp_enqueue_script( 'jquery' );
		}else{}

		if ($loadTwitterBootstrap == 'yes') {
			wp_enqueue_script( 'bootstrap-js-supreme-shortcodes', plugins_url( '/js/bootstrap-elements.js', __FILE__ ), array('jquery') );
			wp_enqueue_style( 'bootstrap-css-supreme-shortcodes', plugins_url( '/css/bootstrap-elements.css', __FILE__ ) );
		}
    
		if ($loadFontAwesome == 'yes') {
			wp_enqueue_style('ss-font-awesome', plugins_url( '/css/font-awesome.min.css' , __FILE__ ));
		}else{}

		if ($loadSwiper == 'yes') {
			wp_enqueue_script( 'swiper-js', plugins_url( '/js/swiper/idangerous.swiper-2.1.min.js', __FILE__ ), array('jquery') );
			wp_enqueue_script( 'swiper-call', plugins_url( '/js/call-swiper.js', __FILE__ ), array('jquery', 'swiper-js') );
			wp_enqueue_style( 'swiper-style', plugins_url( '/js/swiper/idangerous.swiper.css', __FILE__ ) );
		}else{}

		if ($loadAnimate == 'yes') {
			wp_enqueue_script( 'animated-js', plugins_url('/js/animated/animated.js', __FILE__ ), array('jquery') );
			wp_enqueue_style( 'animated-css', plugins_url('/js/animated/animate.css', __FILE__ ) );
		}else{}

		if ($loadMediaelement == 'yes') {
			wp_enqueue_script( 'wp-mediaelement');
			wp_enqueue_style('mediaelement');
		}else{}

		if ($loadFlexslider == 'yes') {
			wp_enqueue_script( 'flexslider-js', plugins_url( '/js/flexslider/jquery.flexslider-min.js', __FILE__ ), array('jquery') );
			wp_enqueue_script( 'flexslider-call', plugins_url( '/js/call-flexslider.js', __FILE__ ), array('jquery', 'flexslider-js') );
			wp_enqueue_style( 'flexslider-css', plugins_url( '/js/flexslider/flexslider.css', __FILE__ ) );
		}else{}

		if ($loadGcharts == 'yes') {
			wp_enqueue_script( 'supreme-charts', '//www.google.com/jsapi');
		}else{}

		if ($loadGmaps == 'yes') {
			wp_enqueue_script( 'gmap-js', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '', false );
		}else{}

		if ($loadPinterest == 'yes') {
			wp_enqueue_script( 'pinterest-js', '//assets.pinterest.com/js/pinit.js', array(), '', true );
		}else{}

		if ($loadTumbler == 'yes') {
			wp_enqueue_script( 'tumblr-js', '//platform.tumblr.com/v1/share.js', array(), '', true );
		}else{}

		if ($loadFancybox == 'yes') {
			wp_enqueue_script( 'fancybox-js', plugins_url( '/js/fancybox/source/jquery.fancybox.js', __FILE__ ), array('jquery')  );
			wp_enqueue_script( 'fancybox-call', plugins_url( '/js/call-fancybox.js', __FILE__ ), array('jquery', 'fancybox-js') );
			wp_enqueue_style( 'fancybox-css', plugins_url( '/js/fancybox/source/jquery.fancybox.css', __FILE__ ) );
		}else{}

		if ($loadIconMelon == 'yes') {
			wp_enqueue_script( 'supreme-melon-js', plugins_url( '/js/iconmelon/icons.js', __FILE__ ), '', '', true  );
			wp_enqueue_style( 'supreme-melon-css', plugins_url( '/js/iconmelon/icons.css', __FILE__ ) );
		}else{}

		if ($loadSVGDrawings == 'yes') {
			wp_enqueue_script( 'classie-js', plugins_url( '/js/svg/classie.js', __FILE__ ), array(), '', true );
			wp_enqueue_script( 'svganimations-js', plugins_url( '/js/svg/svganimations.js', __FILE__ ), array('classie-js'), '1.0', true );
			wp_enqueue_style( 'svg-css', plugins_url( '/js/svg/svg.css', __FILE__ ) );
		}else{}

		/* Supreme Shortcodes mandatory scripts and styles */
		wp_enqueue_script( 'supreme-all', plugins_url( '/js/supreme-all.min.js', __FILE__ ), array('jquery'), '1.0', true  );
		wp_enqueue_style( 'supreme-shortcodes-style', plugins_url( '/css/shortcodes.min.css', __FILE__ ));

	}
	add_action( 'wp_enqueue_scripts', 'SupremeShortcodes__shortcodes_stylesheet' );


	// BACKEND STYLES AND SCRIPTS
	function SupremeShortcodes__shortcodes_generate_stylesheet() {
		global $my_admin_page;
		$screen = get_current_screen();
	
		if($screen->base == 'post') {

			wp_enqueue_script('wp-mediaelement');
			wp_enqueue_style('mediaelement');

		    wp_enqueue_script('minicolors', plugins_url( '/js/jquery-miniColors/jquery.minicolors.js', __FILE__ ), array('jquery') );
			wp_enqueue_style('minicolors-css', plugins_url( '/js/jquery-miniColors/jquery.minicolors.css', __FILE__ ) );

			// Shortcode preview
			wp_enqueue_script( 'ss-bootstrap-js-admin', plugins_url( '/js/bootstrap-elements.js', __FILE__ ), array('jquery') );
			wp_enqueue_script( 'gmap-js-admin', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '', false );
			wp_enqueue_style( 'ss-font-awesome', plugins_url( '/css/font-awesome.min.css' , __FILE__ ) );

	    	wp_enqueue_style( 'supreme-shortcodes-generator', plugins_url( '/css/shortcode-generator.css', __FILE__ ) );

	    	/* ICONMELON */
			wp_enqueue_style( 'supreme-melon-css', plugins_url( '/js/iconmelon/icons.css', __FILE__ ) );

		}
		
	}
	add_action( 'admin_enqueue_scripts', 'SupremeShortcodes__shortcodes_generate_stylesheet' );



	// ADD TINYMCE BUTTON
	function SupremeShortcodes__action_register_tinymce() {	
		if(get_user_option('rich_editing') == 'true') {
			add_filter('mce_buttons', 'SupremeShortcodes__filter_tinymce_button');
			add_filter('mce_external_plugins', 'SupremeShortcodes__filter_tinymce_plugin');
		}
	}
	function SupremeShortcodes__filter_tinymce_button($buttons) {
		array_push($buttons, '|', 'themeShortcuts' );
		return $buttons;
	}

	function SupremeShortcodes__filter_tinymce_plugin($plugin_array) {
		global $themename;
		?>
		<script type="text/javascript">
			var stPluginUrl = "<?php echo plugins_url(); ?>/SupremeShortcodes";
		</script>
		<?php
		$plugin_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodes/');
		$plugin_array['themeShortcuts'] = $plugin_path . 'js/editor_plugin.js';
		return $plugin_array;
	}



	// VISUAL COMPOSER
	add_action('after_setup_theme', 'SupremeShortcodes__visual_composer');
	function SupremeShortcodes__visual_composer() {

		//check to see if visual composer is enabled
		if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || function_exists('vc_set_as_theme') ) {

			if ( function_exists( "vc_map" ) ) {

				global $supreme_vc_map;
				$supreme_vc_map = array();

			    require_once dirname(__FILE__) . '/supreme-vc-extend.php';

				ksort( $supreme_vc_map );
				foreach ( $supreme_vc_map as $key => $value ) {
					vc_map( $value );
				}

			}

		}
		
	}


	// register tinymce button and menu 
	add_action('init', 'SupremeShortcodes__action_register_tinymce');	


	// Add shortcode support in excerpt and widgets
	add_filter('the_excerpt', 'shortcode_unautop');
	add_filter('the_excerpt', 'do_shortcode');
	add_filter('get_the_excerpt', 'do_shortcode');

	add_filter('wp_nav_menu_items', 'do_shortcode');

	add_filter('widget_text', 'shortcode_unautop');
	add_filter('widget_text', 'do_shortcode');

?>