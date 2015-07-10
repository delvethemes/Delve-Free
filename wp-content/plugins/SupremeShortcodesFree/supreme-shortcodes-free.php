<?php
/*
		Plugin Name: Supreme Shortcodes FREE
		Plugin URI: http://supremewptheme.com/plugins/supreme-shortcodes/
		Description: Supreme Shortcodes FREE plugin contains more than <strong>100 shortcodes</strong>. This plugin works perfect as an addition to the <strong>Visual Composer</strong> (PRO version only), but it also <strong>works beautiful as a standalone</strong>. You can choose from static elements such as: <strong>Boxes, Responsive rows and columns, Lines and dividers</strong> to animated elements such as: <strong>3D Buttons, Modals and Popovers or Toggles and Tabs</strong>. Pretty much <strong>anything needed</strong> for todays modern web presentation. <a href="http://codecanyon.net/item/supreme-shortcodes-wordpress-plugin/6340769?ref=supremefactory&license=regular&open_purchase_for_item_id=6340769&purchasable=source&license=regular&open_purchase_for_item_id=6340769&purchasable=source">Upgrade to PRO</a> to unlock all features.
		Version: 0.1.0
		Author: Supreme Factory
		Author URI: http://www.supremewptheme.com
		License: Copyright (c) 2013 SupremeFactory. All rights reserved.

		Copyright 2013  SUPREMEFACTORY

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

	$shortname = 'SupremeShortcodesFree'; // must be the same as theme folder name //

	$supremeshortcodes_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodesFree');

	$currentFile = __FILE__;
	$currentFolder = dirname($currentFile);

	// TRANSLATION SUPPORT
	add_action( 'plugins_loaded', 'SupremeShortcodesFree__load_textdomain' );
	function SupremeShortcodesFree__load_textdomain(){
		load_plugin_textdomain( 'SupremeShortcodesFree', false,  dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	// ALL SHORTCODES
	require_once dirname(__FILE__) . '/shortcodes.php';

	// ADD FUNCTIONS
	require_once dirname(__FILE__) . '/includes/functions.php';

	// ADD ADMIN MENU
	require_once dirname(__FILE__) . '/admin/supreme-shortcodes-admin.php';


	// FRONT END STYLES AND SCRIPTS
	function SupremeShortcodesFree__shortcodes_stylesheet() {
		global $post;

		?>
		<script type="text/javascript">
			var stPluginUrl = "<?php echo plugins_url(); ?>/SupremeShortcodesFree";
		</script>
		<?php

		$loadJquery = get_option('SupremeShortcodesFree__load_jquery');
		$loadMediaelement = get_option('SupremeShortcodesFree__load_mediaelement');

		if ($loadJquery == 'yes') {
			wp_enqueue_script( 'jquery' );
		}else{}

		if ($loadMediaelement == 'yes') {
			wp_enqueue_script( 'wp-mediaelement');
			wp_enqueue_style('mediaelement');
		}else{}

		wp_enqueue_script( 'bootstrap-js-supreme-shortcodes', plugins_url( '/js/bootstrap-elements.js', __FILE__ ), array('jquery') );
		wp_enqueue_style( 'bootstrap-css-supreme-shortcodes', plugins_url( '/css/bootstrap-elements.css', __FILE__ ) );
		wp_enqueue_style('ss-font-awesome', plugins_url( '/css/font-awesome.min.css' , __FILE__ ));

		wp_enqueue_script( 'gmap-js', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '', false );
		wp_enqueue_script( 'pinterest-js', '//assets.pinterest.com/js/pinit.js', array(), '', true );
		wp_enqueue_script( 'tumblr-js', '//platform.tumblr.com/v1/share.js', array(), '', true );

		/* Supreme Shortcodes mandatory scripts and styles */
		wp_enqueue_script( 'supreme-all', plugins_url( '/js/supreme-all.js', __FILE__ ), array('jquery'), '1.0', true  );
		wp_enqueue_style( 'supreme-shortcodes-style', plugins_url( '/css/shortcodes.css', __FILE__ ));

	}
	add_action( 'wp_enqueue_scripts', 'SupremeShortcodesFree__shortcodes_stylesheet' );


	// BACKEND STYLES AND SCRIPTS
	function SupremeShortcodesFree__shortcodes_generate_stylesheet() {
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
		}
		
	}
	add_action( 'admin_enqueue_scripts', 'SupremeShortcodesFree__shortcodes_generate_stylesheet' );



	// Add tinymce button
	function SupremeShortcodesFree__action_register_tinymce() {	
		if(get_user_option('rich_editing') == 'true') {
			add_filter('mce_buttons', 'SupremeShortcodesFree__filter_tinymce_button');
			add_filter('mce_external_plugins', 'SupremeShortcodesFree__filter_tinymce_plugin');
		}
	}
	function SupremeShortcodesFree__filter_tinymce_button($buttons) {
		array_push($buttons, '|', 'themeShortcuts' );
		return $buttons;
	}

	function SupremeShortcodesFree__filter_tinymce_plugin($plugin_array) {
		?>
		<script type="text/javascript">
			var stPluginUrl = "<?php echo plugins_url(); ?>/SupremeShortcodesFree";
		</script>
		<?php
		$plugin_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodesFree/');
		$plugin_array['themeShortcuts'] = $plugin_path . 'js/editor_plugin.js';
		return $plugin_array;
	}


	// registers tinymce button and menu 
	add_action('init', 'SupremeShortcodesFree__action_register_tinymce');	


	// Add shortcode support in excerpt and widgets
	add_filter('the_excerpt', 'shortcode_unautop');
	add_filter('the_excerpt', 'do_shortcode');
	add_filter('get_the_excerpt', 'do_shortcode');

	add_filter('wp_nav_menu_items', 'do_shortcode');

	add_filter('widget_text', 'shortcode_unautop');
	add_filter('widget_text', 'do_shortcode');

?>