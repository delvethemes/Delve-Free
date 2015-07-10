<?php
/**
 * Delve functions and definitions
 *
 * Include some plugins files define variables and other helping files for delve theme
 * Include function files which contain hook, filter and other functions
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */

define( 'TEMPLATE_PATH',get_template_directory_uri() );
define( 'DELVE_SHORTCODE_DIR', get_template_directory()."/plugins" );

/*
 * plugins
*/
include( 'plugins/TGM-Plugin-Activation-master/class-tgm-plugin-activation.php' );
include( 'plugins/TGM-Plugin-Activation-master/example.php' );
include( 'plugins/meta-box/meta-box.php' );
include( 'plugins/prettyphoto/prettyphoto.php' );
include( 'inc/widgets/unlimited-sidebars.php' );
include( 'inc/pagination.php' );

/*
 * widgets settings
*/
include( 'inc/widgets/widgets.php' );

/*
 * functions
*/
include( 'inc/functions.php' );

/*
 * redux framework
*/
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/admin-options.php' ) ) {
    require_once( 'admin-options.php' );
}