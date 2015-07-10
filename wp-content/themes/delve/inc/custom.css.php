<?php
/**
 * The set up custom css for all pages
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
//header('Content-Type: text/css');
//include_once("../../../../wp-load.php"); 	
global $data;
$delve_pattern_thumb = "../images/pattern/";
/******* Custom Css *******/
if( $data['delve-dark'] == 'none' ) {
	echo "h1, h2, h3, h4, h5, h6 { color:#2c3e50; }";
} else if ( $data['delve-dark'] == 'dark.css' ) {
	echo "h1, h2, h3, h4, h5, h6 { color:#FFF; }";
}
/*********************************************************************
******* Body Customization *******************************************/
if( $data['theme-layout'] == 'box' ) {
	echo ".wrapper, .navbar, .container-header, .page-slider, footer { max-width:1280px; }";
	
	$bg_data = $data['body-bg'];
	$body_style = "body {";
	
	if( $data['bg-patterns'] != 'none' && $data['body-bg-type'] == 'pattern' ) { $body_style .= 'background:url('. $data['bg-patterns'].") repeat;"; }
	else if( $bg_data['background-image'] && $data['body-bg-type'] == 'bg-image' ) { $body_style .= 'background-image:'.$bg_data['background-image'].";"; }
	
	if( $data['body-bg-type'] == 'bg-image' ) {
		if( $bg_data['background-color'] ) 		{ $body_style .= 'background-color:'.$bg_data['background-color'].";"; }
		if( $bg_data['background-repeat'] ) 	{ $body_style .= 'background-repeat:'.$bg_data['background-repeat'].";"; }
		if( $bg_data['background-size'] ) 		{ $body_style .= 'background-size:'.$bg_data['background-size'].";"; }
		if( $bg_data['background-attachment'] ) { $body_style .= 'background-attachment:'.$bg_data['background-attachment'].";"; }
		if( $bg_data['background-position'] ) 	{ $body_style .= 'background-position:'.$bg_data['background-position'].";"; }
	}
	
	$body_style .= "}  ";
	echo $body_style;
}
/*********************************************************************
******* Header Customization *****************************************/
$from = '#FFF';
$to = '#FFF';
if ( $data['header-bg-type'] == 'gradient' ) {
	
	if( !empty($data['header-gradient-color']['to'] )  && !empty($data['header-gradient-color']['from'] ) ) {
		$from = $data['header-gradient-color']['from'];
		$to = $data['header-gradient-color']['to'];
		
		echo " .navbar {
			background: $from; /* Old browsers */
			background: -moz-linear-gradient($from,$to); /* FF3.6+ */
			background: -webkit-gradient($from,$to); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient($from,$to); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient($from,$to); /* Opera 11.10+ */
			background: -ms-linear-gradient($from,$to); /* IE10+ */
			background: linear-gradient($from,$to); /* W3C */
		}";
	}
} else if ( $data['header-bg-type'] == 'pattern' ) {
		
	echo ".navbar {
			background: url(".$data['header-patterns'].") repeat;
		}";
}
/*********************************************************************
******* Footer Widget Customization **********************************/
if ( $data['footer-widget-type'] == 'pattern' ) {		
	echo "footer .footer-widget {
			background: url(".$data['footer-widget-patterns'].") repeat;
		}";
}
/*********************************************************************
******* Footer Customization *****************************************/
$from = '#FFF';
$to = '#FFF';
if ( $data['footer-bg-type'] == 'gradient' ) {
	
	if( !empty($data['footer-bg-gradient']['from']) && !empty($data['footer-bg-gradient']['to']) ) {
		$from = $data['footer-bg-gradient']['from'];
		$to = $data['footer-bg-gradient']['to'];
		
		echo " .footer {
			background: $from; /* Old browsers */
			background: -moz-linear-gradient($from,$to); /* FF3.6+ */
			background: -webkit-gradient($from,$to); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient($from,$to); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient($from,$to); /* Opera 11.10+ */
			background: -ms-linear-gradient($from,$to); /* IE10+ */
			background: linear-gradient($from,$to); /* W3C */
		}";
	}
} else if ( $data['footer-bg-type'] == 'pattern' ) {
		
	echo ".footer {
			background: url(".$data['footer-bg-patterns'].") repeat;
		}";
}
/******* Custom css for all pages *******/
if( is_page() ) {
		$delveID = get_the_ID();
	}
	if( class_exists( 'Woocommerce' ) ){
		if( is_shop() ) {	
			$delveID  = get_option('woocommerce_shop_page_id');
		}
	}
if( isset( $delveID ) ) {
	$meta = get_post_custom( $delveID );
	
	if ( isset($meta['delve_meta_page_bg_color'][0])) {
		echo '.wrapper {
			background: '.$meta['delve_meta_page_bg_color'][0].'!important;
		}';	
	}
}
/*Set logo and menu css according to header type*/
if( isset($data['header-versions']) && $data['header-versions'] == "header-v5"){
?>
 .container_header_main,
.navbar-header {
	width:100%;
	height:100%;
	text-align:center;
}
.sticky-header .navbar-header {
	display:none;
}
.menu-menu {
	clear:both;
	position:relative;
	width:100%;
	text-align:center;
}
.menu-menu li{
	float:none;
	display:inline-block;
	position:relative;
}
.menu-menu .dropdown-menu li {
	display:block;
}
.menu-menu a{
	display:block;
	text-decoration:none;
}
.navbar > .container_header .navbar-brand {
	position:relative;
	float:none;
	display:inline-block;
}
.navbar-nav > li > a,
.delve-cart-btn .cart-btn a {
	line-height:45px;
}
.navbar-collapse {
	width:100%;
}
<?php	
}
?>
@media only screen and (max-width : 767px) {
<?php
if( $data['hide-email'] == 0  ){
	echo '.delve-top-nav span.top-nav-email{display:none !important;}';
}
if( $data['hide-contact-no'] == 0  ){
	echo '.delve-top-nav span.top-nav-cotact{display:none !important;}';
}
if( $data['hide-social-icons'] == 0  ){
	echo '.delve-top-nav .social-icon-container{display:none !important;}';
}
if( $data['hide-secondary-menu'] == 0  ){
	echo '.delve-top-nav .delve-secondary-nav-container{display:none !important;}';
}
?>	
}

@media only screen and (max-width : 480px) {
<?php
	if($data['topbar-right'] == 'contact-details' && $data['place_cart_icon']['cart_top_bar'] == 1) 
		echo '.delve-top-nav-right span.top-nav-email {width:88%;}';
	
	else
		echo '.delve-top-nav-left .top-nav-opt i, .delve-top-nav .delve-social i { padding-left:10px; }';	
?>
}

@media only screen and (max-width : 320px) {
<?php
	
	if($data['topbar-right']=='contact-details')
		echo '.delve-top-nav-right span.top-nav-email {width:73%;}';
	
	if(isset($data['place_cart_icon']['cart_top_bar']))
		echo '.delve-secondary-nav-container {width:82%;}';
?>
}

<?php
if( $data['header-versions'] ){
	switch($data['header-versions']){
		case "header-v1":
			echo '.container_header { margin-top:0; }';
		break;
		case "header-v2":
			echo '.navbar-header{float:right;}.navbar-collapse{float:left;padding-left:0}.container_header{margin-top:0;}.navbar-nav > li:first-child{padding-left:2px}';
		break;
		
		case "header-v3":
			echo '.container_header_main,.navbar-header{width:100%;height:100%}.navbar > .container_header .navbar-brand{position:relative;left:50%;float:left}.navbar > .container_header .navbar-brand span,.navbar > .container_header .navbar-brand img{position:relative;float:none;right:50%}.navbar-nav > li > a,.delve-cart-btn .cart-btn a{line-height:45px}.navbar-collapse{width:100%}.container.container_header_main{border-bottom:1px solid #eceff2}';
		break;
		
		case "header-v4":
			echo '.navbar-header{float:right}.container_header_main,.navbar-header{width:100%;height:100%}.menu-menu{float:left}.navbar > .container_header .navbar-brand{position:relative;left:50%;float:left}.navbar > .container_header .navbar-brand span,.navbar > .container_header .navbar-brand img{position:relative;float:none;right:50%}.navbar-nav > li > a,.delve-cart-btn .cart-btn a{line-height:45px}.navbar-collapse{width:100%}.container.container_header_main{border-bottom:1px solid #eceff2}.navbar-nav > li:first-child{padding:0 17px}';
		break;
		
		case "header-v5":
			echo '.container_header_main,.navbar-header{width:100%;height:100%;text-align:center}.sticky-header .navbar-header{display:none}.menu-menu{clear:both;position:relative;width:100%;text-align:center}.menu-menu li{float:none;display:inline-block;position:relative}.menu-menu .dropdown-menu li{display:block}.menu-menu a{display:block;text-decoration:none}.navbar > .container_header .navbar-brand{position:relative;float:none;display:inline-block}.navbar-nav > li > a,.delve-cart-btn .cart-btn a{line-height:45px}.navbar-collapse{width:100%}.container.container_header_main{border-bottom:1px solid #eceff2}';
		break;
		
		case "header-v6":
			echo '.container_header_main,.navbar-header{height:100%}.navbar > .container_header .navbar-brand{width:100%}.navbar-nav > li > a,.delve-cart-btn .cart-btn a{line-height:45px}.navbar-collapse{width:100%}.container.container_header_main{border-bottom:1px solid #eceff2}.navbar .container .navbar-brand{text-align:left}.logo-container .navbar-header{padding:0 17px}';
		break;
		
		case "header-v7":	
			echo '.container_header_main,.navbar-header{height:100%}.menu-menu{float:left}.sticky-header .navbar-header{float:right}.navbar > .container_header .navbar-brand{width:100%}.container.container_header_main{border-bottom:1px solid #eceff2}.navbar-nav > li > a,.delve-cart-btn .cart-btn a{line-height:45px}.navbar-collapse{width:100%}.navbar > .container_header .navbar-brand{text-align:left;padding:0}.logo-container .navbar-header {padding-left:1px}.navbar-nav > li:first-child{padding:0 8px}.nav-container.container{padding:0 6px}';
		break;
		
		case "header-v8":
			echo '.container_header_main,.navbar-header{height:100%}.sticky-header .navbar-header{display:none}.menu-menu{clear:both;position:relative;width:100%;text-align:center}.menu-menu li{float:none;display:inline-block;position:relative}.menu-menu .dropdown-menu li{display:block}.menu-menu a{display:block;text-decoration:none}.navbar > .container_header .navbar-brand{width:100%}.container.container_header_main{border-bottom:1px solid #eceff2}.navbar-nav > li > a,.delve-cart-btn .cart-btn a{line-height:45px}.navbar-collapse{width:100%}.navbar > .container_header .navbar-brand{text-align:left;padding:0}.logo-container .navbar-header{padding:0 17px}';
		break;
		
		case "header-v9":
			echo '.container_header_main,.navbar-header{height:100%}.navbar-header{float:right}.sticky-header .navbar-header{float:left}.navbar > .container_header .navbar-brand{width:100%}.container.container_header_main{border-bottom:1px solid #eceff2}.navbar-nav > li > a,.delve-cart-btn .cart-btn a{line-height:45px}.navbar-collapse{width:100%}';
		break;
		
		case "header-v10":
			echo '.container_header_main,.navbar-header{height:100%}.navbar-header{float:right}.menu-menu{float:left}.navbar > .container_header .navbar-brand{width:100%}.container.container_header_main{border-bottom:1px solid #eceff2}.navbar-nav > li > a,.delve-cart-btn .cart-btn a{line-height:45px}.navbar-collapse{width:100%}.navbar-nav > li:first-child{padding-left:17px}';
		break;
		
		case "header-v11":
			echo '.container_header_main,.navbar-header {height:100%;}.navbar-header {float:right;}.sticky-header .navbar-header {	display:none;}.menu-menu {clear:both;position:relative;width:100%;text-align:center;}.menu-menu li{	float:none;	display:inline-block;position:relative;}.menu-menu .dropdown-menu li {display:block;}.menu-menu a{display:block;text-decoration:none;}.navbar > .container_header .navbar-brand {width:100%;}.container.container_header_main{border-bottom:1px solid #eceff2}.navbar-nav > li > a,.delve-cart-btn .cart-btn a {	line-height:45px;}';
		break;
		
		default:
	}
}//endif