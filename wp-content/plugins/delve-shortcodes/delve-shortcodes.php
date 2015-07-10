<?php
/*
  Plugin Name: Delve Shortcodes
  Description: Delve Shortcodes
  Version: 1.0
  Author: Delvethemes
  Author URI: http://themeforest.net/user/delvethemes
  License: GNU General Public License
*/
function delve_shortcodes_init() {
	define ( 'DELVE_SHORTCODES_DIR', dirname(__FILE__) );
	define ( 'DELVE_SHORTCODES_URL', plugins_url().'/'.plugin_basename(DELVE_SHORTCODES_DIR) );
}
add_action( 'init', 'delve_shortcodes_init' );
global $data;
$data = get_option( 'data' );
function delve_stylesheets() {
	//css
	wp_enqueue_style('delve_flexslider', DELVE_SHORTCODES_URL . "/css/flexslider.css", '', ''); //flexslider
	wp_enqueue_style('delve_shortcodes', DELVE_SHORTCODES_URL . "/delve-shortcodes.css", '', '');
	wp_enqueue_style('delve_ihover', DELVE_SHORTCODES_URL . "/css/ihover.min.css", '', '');
	
	//js
	// flex slider
	wp_enqueue_script('delve-flex-js', DELVE_SHORTCODES_URL. '/js/jquery.flexslider-min.js' , array('jquery') );
	
	//pai-progress JS
	wp_enqueue_script('delve-pie-progress', DELVE_SHORTCODES_URL. '/js/shortcodes/jquery-asPieProgress.min.js' , array('jquery') );
	wp_enqueue_script('delve-pie-viewport', DELVE_SHORTCODES_URL. '/js/shortcodes/isInViewport.min.js' , array('jquery') );
	
	//number counter JS
	wp_enqueue_script('delve-waypoints', 'http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js', array('jquery'));
	wp_enqueue_script('delve-num-counter', DELVE_SHORTCODES_URL. '/js/shortcodes/jquery.counterup.js' , array('jquery') );
	
	wp_enqueue_script('delve-shortcode', DELVE_SHORTCODES_URL. '/js/delve-shortcode.js' , array('jquery') );
	
}
add_action( 'wp_enqueue_scripts', 'delve_stylesheets' );
include('inc/shortcodes.php');
if( $data['portfolio-switch'] ) { include('inc/portfolio.php'); }
if( $data['ourteam-switch'] ) { include('inc/ourteam.php'); }
if( $data['testimonials-switch'] ) { include('inc/testimonials.php'); }
// gallery in progress
if( $data['gallery-switch'] ) { include('inc/gallery.php'); }