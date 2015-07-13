<?php
/*
 All Shortcodes Generated here.
*/
/******* Add tinyMCE Button ******/
class DELVE_TinyMCE_Buttons {
	function __construct() {
    	add_action( 'init', array(&$this,'init') );
    }
    function init() {
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;		
		if ( get_user_option('rich_editing') == 'true' ) {  
			add_filter( 'mce_external_plugins', array(&$this, 'add_plugin') );  
			add_filter( 'mce_buttons', array(&$this,'register_button') ); 
		}  
    }  
	function add_plugin($plugin_array) {  
	 	global $wp_version;
		if($wp_version <= 3.8) {
	   		$plugin_array['delve_shortcodes'] = DELVE_SHORTCODES_URL.'/js/shortcodes/tinymce.js';
	   		return $plugin_array; 
		}
		else {
			$plugin_array['delve_shortcodes'] = DELVE_SHORTCODES_URL.'/js/shortcodes/tinymce3.9.js';
	   		return $plugin_array; 
		}
	}
	function register_button($buttons) {  
	   array_push($buttons, "delve_shortcodes_button");
	   return $buttons; 
	} 	
}
$delveshortcode = new DELVE_TinyMCE_Buttons;
/****** tinyMCE Button Over *******/
/**
* Don't auto-p wrap shortcodes that stand alone
*/
function delve_shortcodes_stylesheet() {
	$delve_shortcodes_style = DELVE_SHORTCODES_URL . '/css/shortcodes.css';
    $delve_shortcodes_file = DELVE_SHORTCODES_DIR . '/css/shortcodes.css';
    if ( file_exists($delve_shortcodes_file) ) {
        wp_register_style( 'delve_shortcodes', $delve_shortcodes_style );
        wp_enqueue_style( 'delve_shortcodes');
   }
}
add_action( 'wp_enqueue_scripts', 'delve_shortcodes_stylesheet' );
/**
* Don't auto-p wrap shortcodes that stand alone
*/
function delve_base_unautop() {
	add_filter( 'the_content', 'shortcode_unautop' );
}
add_action( 'init', 'delve_base_unautop' );
/**
* Add the shortcodes
*/
function delve_shortcodes() {
	add_filter( 'the_content', 'shortcode_unautop' );
	
	add_shortcode( 'delve_icon_box', 'fun_delve_icon_box' );
	add_shortcode( 'delve_pie_progress', 'fun_delve_pie_progress' );
	add_shortcode( 'delve_contact_info', 'fun_delve_contact_info' );
	add_shortcode( 'delve_counter_box', 'fun_delve_counter_box' );
	add_shortcode( 'delve_recent_post', 'fun_delve_recent_post' );
	add_shortcode( 'delve_slider', 'fun_delve_slider' );
	add_shortcode( 'delve_slide', 'fun_delve_slide' );
	add_shortcode( 'delve_magazine_style', 'fun_delve_magazine_style' );
	add_shortcode( 'delve_skillbar', 'fun_delve_skillbar' );
	add_shortcode( 'delve_pricing_table', 'fun_delve_pricing_table' );
	
	// Long posts should require a higher limit, see http://core.trac.wordpress.org/ticket/8553
	@ini_set( 'pcre.backtrack_limit', 500000 );
}
add_action( 'wp_head', 'delve_shortcodes' );
/*
 * Functions for Shortcodes
*/

function delve_vc_shortcode_icon() {

	   echo '<style type="text/css">
			.delve-vc {	background-image:url('. plugins_url( '../images/delve-themes-16x16.png', __FILE__ ).') !important;	}
		 </style>';  
}

add_action('admin_head', 'delve_vc_shortcode_icon');


// skillbars
if ( !function_exists( 'fun_delve_skillbar' ) ) {
	function fun_delve_skillbar( $atts ) {
		$atts = shortcode_atts(
			array(
				'percentage'	=> '80%',
				'title'			=> 'Delve',
				'background'	=> '#1abc9c',
			), $atts);
	
		$delve_sidebar  = '<div class="delve-skillbar clearfix " data-percent="'.$atts['percentage'].'">';
		$delve_sidebar .= '<div class="skillbar-title"><span>'.$atts['title'].'</span></div>';
		$delve_sidebar .= '<div class="skillbar-bar" style="background:'.$atts['background'].';"></div>';
		$delve_sidebar .= '<div class="skill-bar-percent">'.$atts['percentage'].'</div></div>';
		
		return $delve_sidebar;
	}
}

if( !function_exists( 'fun_delve_pricing_table' ) ) {
	function fun_delve_pricing_table($atts,$content) {
		$atts = shortcode_atts(
			array(
				'title'				=> 'STANDARD',
				'price'				=> '199',
				'per'				=> 'year',
				'btn_color'			=> '#1abc9c',
				'btn_text'			=> 'BUY NOW',
				'btn_text_color'	=> '#FFF',
				'btn_src'			=> '#',
				'featured'			=> 'no',
		), $atts);
		
		$featured = '';
		$f_img = '';
		if( $atts['featured'] == 'yes' || $atts['featured'] == 'Yes' ) {
			$featured = 'delve-featured';
			$f_img = '<img class="pf_image" src="'.DELVE_SHORTCODES_URL.'/images/hot.png" alt="hot"/>';
		}
		
		$delve_ptable  = '<div class="delve_pricing_container '.$featured.'">';
		$delve_ptable .= $f_img;
		$delve_ptable .= '<div class="delve_pricing"><div class="pricing_title">';
		$delve_ptable .= '<h2>'.$atts['title'].'</h2></div><div class="item_price">';
		$delve_ptable .= '<sup>$</sup><span>'.$atts['price'].'</span><sub>/'.$atts['per'].'</sub></div>';
		$delve_ptable .= $content;
		$delve_ptable .= '<br><a href="'.$atts['btn_src'].'" class="portfolio-live-project" style="color:'.$atts['btn_text_color'].'; background-color:'.$atts['btn_color'].'; border-color:'.$atts['btn_color'].'" >'.$atts['btn_text'].'</a><br>&nbsp;';
		$delve_ptable .= '</div></div>';
		
		return $delve_ptable;
	}
}

// delve magazine style
if( !function_exists( 'fun_delve_magazine_style' ) ) {
	function fun_delve_magazine_style($atts) {
		$atts = shortcode_atts(
			array(
				'post_type'			=> 'post',
				'show_first_large'	=> 'yes',
				'no_of_post'	=> '4',
				'large_post_on'		=> 'left',
				'category'			=> '',
			), $atts);
			
		$first_post = $atts['show_first_large'];	
					
		$ms_query= null;
		$ms_query = new WP_Query(array('post_type' => $atts['post_type'], 'posts_per_page' => $atts['no_of_post'],'category_name'    => $atts['category'] ));		
		
		$d_m_output = '<div class="'. $post_class .' row magazin-style-container">';
		$i = 1;
		while ( $ms_query->have_posts()) : $ms_query->the_post(); 
			
		if($i <= 2 && $first_post == "yes"){$d_m_output .= '<div class="col-md-6 delve-first-large '.$atts['large_post_on'].'" >';}		
		$d_m_output .= '<div class="magazine-style" >';
				
				if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 
                    $d_m_output .= '<div class="delve-magazine-thumbnail">';
					if( $i <= 1 && $first_post == "yes" ) { $d_m_output .= get_the_post_thumbnail( $ms_query->ID, 'full' ); }
					
					else { $d_m_output .= get_the_post_thumbnail( $ms_query->ID, 'thumbnail' ); }
					$d_m_output .= '</div>';
				endif;
					
					if( $i <= 1 && $first_post == "yes" ) { $d_m_output .= '<div class="delve-magazine-info">'; }
					$d_m_output .= '<h6 class="delve-magazine-title">
										<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">'.get_the_title().'</a></h6>';					
					$d_m_output .= '<p class="delve-magazine-meta">';
					$d_m_output .= '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.
									get_the_author_meta( 'display_name' ).'</a>';
                    $d_m_output .= ' | ';
					$d_m_output .= get_the_date('F j, Y'); 
					$d_m_output .= ' | ';
					 
					$categories = get_the_category();
					$separator = ', ';
					$output = '';
					$k = 1;
						
					if($categories){
						foreach($categories as $category) {
							if( $k != 1 ) { $d_m_output .= $separator; }
							$d_m_output .= '<a href="'.get_category_link( $category->term_id ).'">'.$category->cat_name.'</a>';
							$k++;
						}
						$d_m_output .= trim($output, $separator);
					}
									   
					$d_m_output .= '</p>';
					if( $i <= 1 && $first_post == "yes" ) { $d_m_output .= '</div>'; }//delve-magazine-info
					
					if( $i > 1 || $first_post != "yes" ) {
						$d_m_output .= '<p class="delve-magazine-content">';
						$d_m_output .= string_limit_chars( get_the_excerpt(), 150 );
						$d_m_output .= ' ...</p>';
					}
					
				$d_m_output .= '</div>';//magazine-style
				if( $i <= 1 && $first_post == 'yes' ) { $d_m_output .= '</div>'; }// first large
				$i++;
			endwhile;
			
		if( $first_post == 'yes' ) { $d_m_output .= '</div>'; }
		$d_m_output .= '</div><div class="clear"></div>'; //magazin-style-container
		
		wp_reset_query();
		return $d_m_output;
	}
}

// counter box
if( !function_exists( 'fun_delve_counter_box' ) ) {
	function fun_delve_counter_box( $atts ) {
		$atts = shortcode_atts( 
			array(
				'number'	=> 1,234,456,
				'title'		=> 'Delve',
				'color'		=> '',
			), $atts);
			
		return '<div class="delve_counter_box" style="color:'.$atts['color'].';">
					<div class="delve_counter_container">
						<div class="delve_num_counter">'.$atts['number'].'</div>
					</div>
				<div class="delve_counter_title">'.$atts['title'].'</div></div>';
	}
}

//pie progress
if ( !function_exists( 'fun_delve_pie_progress' ) ) {
	function fun_delve_pie_progress($atts, $content) {
		$atts = shortcode_atts(
			array(
				'bar_color'		=> '#1abc9c',
				'color'			=> '#2e3340',
				'inner_bg'		=> 'transparent',
				'per_color'		=> '#2e3340',
				'min_value'		=> '0',
				'max_value'		=> '100',
				'target_value'	=> '80',
				'width'			=> '100%',
				'size'			=> "3",
				'label'			=> '',
				'icon'			=> '',
			), $atts);
			
		$pie_output = '<div class="pie_progress_container"><div class="pie_progress" role="progressbar" data-goal="'.$atts['target_value'].'" data-barcolor="'.$atts['bar_color'].'" data-barsize="'.$atts['size'].'" aria-valuemin="'.$atts['min_value'].'" aria-valuemax="'.$atts['max_value'].'" style="width:'.$atts['width'].';" >';
			
		$pie_output .= '<div class="pie_inner"><div class="pie_circle"><div class="pie_circle_number">';
			
		if( $atts['icon'] && $atts['icon'] != "no" ) {
			$pie_output .= '<div class="pie_icon" style="background:'.$atts['inner_bg'].';color:'.$atts['per_color'].';"><i class="fa fa-'.$atts['icon'].' fa-lg" style="color:'.$atts['per_color'].';"></i></div>';
		} else {
			$pie_output .= '<div class="pie_progress__number" style="background:'.$atts['inner_bg'].';color:'.$atts['per_color'].';">0%</div>';
		}
			
		$pie_output .='</div></div></div></div>';
		$pie_output .='<div class="pie_progress_content"><h3 style="color:'.$atts['color'].';">'.$atts['label'].'</h3></div></div>';
				
		return $pie_output;
	}
}

// icon box
if ( !function_exists( 'fun_delve_icon_box' ) ) {
	function fun_delve_icon_box($atts, $content) {
		$atts = shortcode_atts(
			array(
				'background'	=> '#9CA4A9',
				'color'			=> '#FFF',
				'title'			=> 'Delve',
				'icon'			=> 'wordpress',
				'icon_position'	=> 'top'
			), $atts);
			
		if( $atts['icon_position'] == "top/left" ) {
			$atts['icon_position'] = "top";
		}
			
		return '<div class="delve-icon-box style-'.$atts['icon_position'].'">
				<div class="delve-icon '.$atts['icon_position'].'">'.
				'<div class="delve_diamond" style="background:'.$atts['background'].';">
					<i style="color:'.$atts['color'].';" class="fa fa-'.$atts['icon'].'"></i>'.
				'</div><div class="box-title">'
					.$atts['title'].'</div></div><div class="box-content">'.do_shortcode( $content ).'</div></div>';
	}
}

// recent post
if( !function_exists( 'fun_delve_recent_post' ) ) {
	function fun_delve_recent_post($atts, $content) {
		$atts = shortcode_atts(
			array(
				'post_type'		=> 'post',
				'show_title'	=> 'yes',
				'show_excerpt'	=> 'yes',
				'column'		=> '3',
				'no_of_post'	=> '6',
				'class'			=> '',
				'style'			=> '',
				'category'		=> '',
			), $atts);
		//print_r($atts); 	
		if( $atts['column'] == '1' ) { $class = 'col-md-12'; }
		else if ( $atts['column'] == '2' ) { $class = 'col-md-6'; }
		else if ( $atts['column'] == '4' ) { $class = 'col-md-3'; }
		else if ( $atts['column'] == '5' ) { $class = 'col-md-15 col-sm-3'; }
		else if ( $atts['column'] == '6' ) { $class = 'col-md-2'; }
		else { $class = 'col-md-4'; }
			
		if( $atts['class'] ) { $class .= " ".$atts['class']; }
			
		$rp_query= null;
		$rp_query = new WP_Query(array('post_type' => $atts['post_type'], 'posts_per_page' => $atts['no_of_post'],'category_name'    => $atts['category'], 'ignore_sticky_posts' => true ));
	
		$recent_posts =	'<div class="recent_post_container" style="'.$atts['style'].'"><div class="row delve_recent_post delve-columns-'.$atts['column'].'">';
		
		while ( $rp_query->have_posts()) : $rp_query->the_post(); 
				
			$recent_posts .= '<div class="'. $class .' recent-post_item_container"  >';
			$recent_posts .= '<div class="recent-post_item"  >';
				
			if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 
							
				$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
					
				$recent_posts .= '<header class="delve-entry-header">';
				$recent_posts .= '<div class="post_animation">';
				$recent_posts .= '<div class="post_anim_info_container">';
				$recent_posts .= '<div class="post_anim_info">';
				$recent_posts .= '<a href="'.$link[0].'" data-gal="prettyPhoto[\'recent_post\']">
									<i class="fa fa-search"></i></a>
								<a href="'.esc_url( get_permalink() ).'">
									<i class="fa fa-link"></i></a>';
										
				$recent_posts .= '<h5>'.get_the_title().'</h5>';
				$recent_posts .= '</div></div></div>';	
				$recent_posts .= '<div class="delve-entry-thumbnail">';
				$recent_posts .= get_the_post_thumbnail();
				$recent_posts .= '</div></header>';		
			endif;
			
			if( $atts['show_title'] == 'yes/no' ) 
				 $atts['show_title'] = 'yes' ;
				 
			if( $atts['show_title'] == 'yes' ) {
	
				$recent_posts .= '<div class="post_heading"><h3 class="delve-entry-title">
									<a href="'. esc_url( get_permalink() ) .'" rel="bookmark">'.get_the_title().'</a></h3></div>';					
				$recent_posts .= '<div class="post_meta"><span class="post-icon"><i class="fa fa-user"></i></span> By ';
				$recent_posts .= '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.
										get_the_author_meta( 'display_name' ).'</a>';
				$recent_posts .= '<span class="post-icon"><i class="fa fa-file-text"></i></span> ';
					 
				$categories = get_the_category();
				$separator = ' ';
				$output = '';
				
				if($categories){
					foreach($categories as $category) {
						$recent_posts .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
					}
					echo trim($output, $separator);
				}
									   
				$recent_posts .= '</div>';
			}
			
			if( $atts['show_excerpt'] == 'yes/no' )
				$atts['show_excerpt'] = 'yes';
				
			if( $atts['show_excerpt'] == 'yes' ) {
				$recent_posts .= '<div class="recent-post-content">';
				$recent_posts .= string_limit_chars( get_the_excerpt(), 150 );
				$recent_posts .= ' ...</div>';
			}
			$recent_posts .= '</div></div>';
			
		endwhile;
			
		$recent_posts .= '</div></div>';
		
		wp_reset_query();
		return $recent_posts;
	}
}

$slider_type = ''; 
// delve slider
if( !function_exists( 'fun_delve_slider' ) ) {
	function fun_delve_slider($atts, $content) {
		$atts = shortcode_atts(
			array(
				'type'		=> 'basic',
				'animation' => 'slide',
				'border' => 'yes',
				'id'	=> ""
			), $atts);
			
		if( $atts['type'] == "basic/thumbnail" )
			$atts['type'] = "basic";	
		if( $atts['animation'] == "fade/slide" )
			$atts['animation'] = "slide";
		if( $atts['border'] == "yes/no" )
			$atts['animation'] = "yes";			
		if( $atts['animation'] == "fadeIn" )
			$atts['animation'] = "fade";
		
		global $slider_type;
		$border = "";
		$slider_type = $atts['type'];
		if( $atts['border'] == "no" )
			$border = " no-border";
			
		$d_s_output = '<div class="delve-flexslider delve-flexslider-'.$slider_type.' delve-'.$atts['animation'].' flexslider '.$border.'">';
		$d_s_output .= '<ul class="slides">';
		$d_s_output .= do_shortcode( $content );
		$d_s_output .= '</ul></div>';
	
		return $d_s_output;
	}
}


// slide
if( !function_exists( 'fun_delve_slide' ) ) {
	function fun_delve_slide($atts) {
		$atts = shortcode_atts(
			array(
				'url'	=> '',
				'link' => ''
			), $atts);
		
		global $slider_type;
		if( $slider_type == 'thumbnail' ) { $delve_slide_output = '<li data-thumb="'.$atts['url'].'">'; }
		else { $delve_slide_output = '<li>'; }
		if( $atts['link'] )
		$delve_slide_output .= '<a href="'.$atts['link'].'">';
		
		$delve_slide_output .= '<img class="delve_slide" src="'.$atts['url'].'" alt="Slider Image"/></a></li>';
		if( $atts['link'] )
		$delve_slide_output .= '</a>';
		
		return $delve_slide_output;
	}
}

// contact info
if( !function_exists( 'fun_delve_contact_info' ) ) {
	function fun_delve_contact_info($atts, $content) {
		$atts = shortcode_atts (
			array(
				'title'	=> 'Contact Information',
			), $atts);
		
		return '<div class="delve-contact-info-container"><h3>'.$atts["title"].'</h3><div class="delve-contact-info">
				'.$content.'
				</div></div>';
	}
}

add_action( 'vc_before_init', 'Delve_VC_Shortcodes' );
function Delve_VC_Shortcodes() {
   vc_map( array(
      "name" => __( "Delve Skillbar", "delve" ),
      "base" => "delve_skillbar",
	  "icon" => "delve-vc",
      "class" => "",
      "category" => __( "Delve", "delve"),
       "params" => array(
	     array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Title", "delve" ),
            "param_name" => "title",
            "value" => __( "Delve", "delve" ),
            "description" => __( "It wil be displayed at left side of the skilbar.", "delve" ),
         ),
         array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Percentage", "delve" ),
            "param_name" => "percentage",
            "value" => __( "80%", "delve" ),
            "description" => __( "Enter value along with % sign.", "delve" ),
         ),		
		  array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Background", "delve" ),
            "param_name" => "background",
            "value" => __( "#1abc9c", "delve" ),
            "description" => __( "Color for the background of skillbar..", "delve" ),
         ),
		)
	  )
	);
	
	// Pricing Table
	 vc_map( array(
      "name" => __( "Delve Pricing Table", "delve" ),
      "base" => "delve_pricing_table",
	  "icon" => "delve-vc",
      "class" => "",
	  "category" => __( "Delve", "delve"),
      "params" => array(
	     array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Title", "delve" ),
            "param_name" => "title",
            "value" => __( "STANDARD", "delve" ),
            "description" => __( "Title of the pricing table that will be displayed at the top of the pricing table.", "delve" ),
         ),
         array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Price", "delve" ),
            "param_name" => "price",
            "value" => __( "199", "delve" ),
            "description" => __( "Price you want to display for this item.", "delve" ),
         ),		
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Per", "delve" ),
            "param_name" => "per",
            "value" => __( "year", "delve" ),
            "description" => __( "Specify the time period for that you have entered the price for e.g. month,year.", "delve" ),
         ),
		  array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Button Color", "delve" ),
            "param_name" => "btn_color",
            "value" => __( "#1abc9c", "delve" ),
            "description" => __( "Specify the button color.", "delve" ),
         ),
         array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Button Text", "delve" ),
            "param_name" => "btn_text",
            "value" => __( "BUY NOW", "delve" ),
            "description" => __( "Specify the text that you want to display on button.(For e.g. PURCHASE).", "delve" ),
         ),		
		  array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Button Text Color", "delve" ),
            "param_name" => "btn_text_color",
            "value" => __( "#FFF", "delve" ),
            "description" => __( "Specify the text color of the button.", "delve" ),
         ),
		   array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Button Source", "delve" ),
            "param_name" => "btn_src",
            "value" => __( "#", "delve" ),
            "description" => __( "Specify the url of the page where the user should be redirected when the user click on the button.", "delve" ),
         ),		
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Is Featured", "delve" ),
            "param_name" => "featured",
            "value" => array("yes","no"),
            "description" => __( " Specify if the item is featured or not. If you specify it as featured, it will have a bar texted with 'hot' at the top side of the item. Possible two options are yes or no.", "delve" ),
         ),	
		 array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => __("Text", delve),
			"param_name" => "content",
			"value" => __("<ul>	<li>First Item</li> </ul>", delve)
		),	 
		)
	  )
	);
	
	// Magazine Style Posts
	vc_map( array(
      "name" => __( "Delve Magazine Style Posts", "delve" ),
      "base" => "delve_magazine_style",
	  "icon" => "delve-vc",
      "class" => "",
	  "category" => __( "Delve", "delve"),
      "params" => array(
	     array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Post Type", "delve" ),
            "param_name" => "post_type",
            "value" => __( "post", "delve" ),
            "description" => __( "Specify the name of any custom post type or you can just give 'post' to display blog posts.", "delve" ),
         ),
		   array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Category", "delve" ),
            "param_name" => "category",
            "value" => __( " ", "delve" ),
            "description" => __( "Specify a category of above specified post type. Posts of only that categories will be displayed.", "delve" ),
         ),		
		   array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Number of Posts", "delve" ),
            "param_name" => "no_of_post",
            "value" => __( "4", "delve" ),
            "description" => __( "Specify the number of posts that should be displayed. (Only digits allowed)", "delve" ),
         ),
         array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Show First Post Large", "delve" ),
            "param_name" => "show_first_large",
             "value" => array("yes","no"),
            "description" => __( "Possible values are yes or no. Give yes if the first post should be large and the rest should be displayed below that.", "delve" ),
         ),				
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Large Post Position", "delve" ),
            "param_name" => "large_post_on",
            "value" => array("left","top"),
            "description" => __( "Give left if the large post should be on the left and the rest should be in the right. Give top if the large post should be displayed on the top and the rest will be below it.", "delve" ),
         ),
		)
	  )
	);
	
	// Counter Box
	 vc_map( array(
      "name" => __( "Delve Counter Box", "delve" ),
      "base" => "delve_counter_box",
	  "icon" => "delve-vc",
      "class" => "",
      "category" => __( "Delve", "delve"),
       "params" => array(
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Title", "delve" ),
            "param_name" => "title",
            "value" => __( "Delve", "delve" ),
            "description" => __( "The text that need to be displayed below the figures to denote the title of the figures.", "delve" ),
         ),		   	
		  array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Color", "delve" ),
            "param_name" => "color",
            "value" => __( "#1abc9c", "delve" ),
            "description" => __( "Color for figures and its title.", "delve" ),
         ),
		   array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Number", "delve" ),
            "param_name" => "number",
            "value" => __( "1,234,456", "delve" ),
            "description" => __( "The ultimate count that you want to display after changing numbers.", "delve" ),
         ),       
		)
	  )
	);
	
	// Pie progress
	vc_map( array(
      "name" => __( "Delve Pie Progress", "delve" ),
      "base" => "delve_pie_progress",
	  "icon" => "delve-vc",
      "class" => "",
	  "category" => __( "Delve", "delve"),
      "params" => array(
	    array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Label", "delve" ),
            "param_name" => "label",
            "value" => __( " ", "delve" ),
            "description" => __( "The text that is to be displayed below the circle. Generally it is used to denote the title of the skill or the subject for what the progress is displayed.", "delve" ),
         ),
		   array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Icon", "delve" ),
            "param_name" => "icon",
            "value" => __( " ", "delve" ),
            "description" => __( "You can display any Font Awesome Icon at the center of the circle to fuocus the skill more easily.", "delve" ),
         ),
	   	   array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Bar Color", "delve" ),
            "param_name" => "bar_color",
            "value" => __( "#1abc9c", "delve" ),
            "description" => __( "You can specify the color of the circle bar.", "delve" ),
         ),
		   array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Circle Background", "delve" ),
            "param_name" => "inner_bg",
            "value" => __( "#fff", "delve" ),
            "description" => __( "The background color of the circle. Default would be white.", "delve" ),
         ),
		  array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Percentage Color", "delve" ),
            "param_name" => "per_color",
            "value" => __( "#2e3340", "delve" ),
            "description" => __( "The color of the text that denotes the percentage. If the icon is specified, this color will be the backgrond color of the icon.", "delve" ),
         ),		
		   array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Color", "delve" ),
            "param_name" => "color",
            "value" => __( "#2e3340", "delve" ),
            "description" => __( "Color of the text displayed as a label.", "delve" ),
         ),				         		
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Target Value", "delve" ),
            "param_name" => "target_value",
            "value" => __( "80", "delve" ),
            "description" => __( "A digit (without % sign) should be specified. The progress will be stopped at this position.", "delve" ),
         ),
		 array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Size", "delve" ),
            "param_name" => "size",
            "value" => __( "2", "delve" ),
            "description" => __( "hickness of the bar. Starting from 1 to 14.", "delve" ),
         ),								
		)
	  )
	);
	
	// Icon Box
	 vc_map( array(
      "name" => __( "Delve Icon Box", "delve" ),
      "base" => "delve_icon_box",
	  "icon" => "delve-vc",
      "class" => "",
      "category" => __( "Delve", "delve"),
       "params" => array(
	      array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Title", "delve" ),
            "param_name" => "title",
            "value" => __( "Delve", "delve" ),
            "description" => __( "Title of the block that will be displayed below the icon and above the content.", "delve" ),
         ),   
          array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Icon", "delve" ),
            "param_name" => "icon",
            "value" => __( "wordpress", "delve" ),
            "description" => __( "Icon to be displayed in the square. Font Awesome icons can be used.", "delve" ),
         ),		
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Icon Position", "delve" ),
            "param_name" => "icon_position",
            "value" => array("left","top"),
            "description" => __( "Title of the block that will be displayed below the icon and above the content.", "delve" ),
         ),   
		  array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Background", "delve" ),
            "param_name" => "background",
            "value" => __( "#9CA4A9", "delve" ),
            "description" => __( "Background color of the icon square can be set.", "delve" ),
         ),
		  array(
            "type" => "colorpicker",           
            "class" => "",
            "heading" => __( "Color", "delve" ),
            "param_name" => "color",
            "value" => __( "#FFF", "delve" ),
            "description" => __( "Color of the icon can be specified.", "delve" ),
         ),	
		 array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => __("Text", $shortname),
			"param_name" => "content",
			"value" => __("Your content goes here...", $shortname)
		),	   			    		   			    
		)
	  )
	);
	
	// Recent Post
	 vc_map( array(
      "name" => __( "Delve Recent Post", "delve" ),
      "base" => "delve_recent_post",
	  "icon" => "delve-vc",
      "class" => "",
      "category" => __( "Delve", "delve"),
       "params" => array(
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Post Type", "delve" ),
            "param_name" => "post_type",
            "value" => __( "post", "delve" ),
            "description" => __( "Specify the name of any custom post type or you can just give 'post' to display blog posts", "delve" ),
         ),
		   array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Category", "delve" ),
            "param_name" => "category",
            "value" => __( " ", "delve" ),
            "description" => __( "Specify a slug of above specified post type category. Posts of only that categories will be displayed.", "delve" ),
         ),   
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Number of posts", "delve" ),
            "param_name" => "no_of_post",
            "value" => __( "6", "delve" ),
            "description" => __( "Specify the number of posts that should be displayed. (Only digits allowed)", "delve" ),
         ),  
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Columns", "delve" ),
            "param_name" => "column",
             "value" => __( "3", "delve" ),
            "description" => __( "Specify number of columns in which all posts should be arranged.", "delve" ),
         ),		    
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Show Title?", "delve" ),
            "param_name" => "show_title",
            "value" => array("yes","no"),
            "description" => __( "Possible values are yes or no. Yes to display the title of the post and no for not displaying it.", "delve" ),
         ),		   	
		 array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Show Excerpt?", "delve" ),
            "param_name" => "show_excerpt",
            "value" => array("yes","no"),
            "description" => __( "Possible values are yes or no. Yes to display the excerpt of the post and no for not displaying it.", "delve" ),
         ),	
		  
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "CSS Class", "delve" ),
            "param_name" => "class",
             "value" => __( " ", "delve" ),
            "description" => __( "You can give a css class if you want to customize it and give it new styles.", "delve" ),
         ),		   	
		 array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "CSS Styles", "delve" ),
            "param_name" => "style",
            "value" => __( " ", "delve" ),
            "description" => __( "Custom css can be assigned also.", "delve" ),
         ),    
		 
		)
	  )
	);
	
	// Gallery
	 vc_map( array(
      "name" => __( "Delve Gallery", "delve" ),
      "base" => "delve_gallery",
	  "icon" => "delve-vc",
      "class" => "",
      "category" => __( "Delve", "delve"),
       "params" => array(
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Category", "delve" ),
            "param_name" => "category",
            "value" => __( " ", "delve" ),
            "description" => __( "Specify a category of gallery. Galleries of only that category will be displayed.", "delve" ),
         ),
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Effect", "delve" ),
            "param_name" => "effect",
            "value" => __( "Delve", "delve" ),
            "description" => __( "Specify a digit denoting the effect type of the category. Check out all effects of galleries and choose a suitable digit for that effect.(1 to 10).", "delve" ),
         ),		   	
		 array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Per Page", "delve" ),
            "param_name" => "per_page",
            "value" => __( "-1", "delve" ),
            "description" => __( "Specify how many galleries you want to display in a single page.", "delve" ),
         ),       
		)
	  )
	);
	
	// Our Team
	  vc_map( array(
      "name" => __( "Delve Our Team", "delve" ),
      "base" => "delve_ourteam",
	  "icon" => "delve-vc",
      "class" => "",
      "category" => __( "Delve", "delve"),
       "params" => array(
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Column", "delve" ),
            "param_name" => "column",
            "value" => __( "4", "delve" ),
            "description" => __( "Number of columns in which the team members' details will be displayed(1 - 4).", "delve" ),
         ),		
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Show members?", "delve" ),
            "param_name" => "show_members",
            "value" => __( "-1", "delve" ),
            "description" => __( "Specify the number of members that you want to display. -1 id the default and it means display all members.", "delve" ),
         ),
		   		    
		)
	  )
	);
	
	// Testimonial Slider
	 vc_map( array(
      "name" => __( "Delve Testimonial Slider", "delve" ),
      "base" => "delve_testimonial_slider",
	  "icon" => "delve-vc",
      "class" => "",
      "category" => __( "Delve", "delve"),
       "params" => array(
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Number of Testimonials", "delve" ),
            "param_name" => "no_of_testimonials",
            "value" => __( "-1", "delve" ),
            "description" => __( "Specify the number of testimonials you want to include in the slider. Default is -1 means display all testimonials.", "delve" ),
         ),		
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Image Position", "delve" ),
            "param_name" => "img_position",
            "value" => array("top","left"),
            "description" => __( " Available two options are top or left. Set top if you want to set client image at the top or left if the image should be at the left side.", "delve" ),
         ),
		   		    
		)
	  )
	);
	
	 vc_map( array(
      "name" => __( "Delve Testimonials", "delve" ),
      "base" => "delve_testimonials",
	  "icon" => "delve-vc",
      "class" => "",
      "category" => __( "Delve", "delve"),
       "params" => array(
	    array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Category", "delve" ),
            "param_name" => "category",
            "value" => __( " ", "delve" ),
            "description" => __( "Specify a category of a testimonial to be displayed. Testimonial of only that categories will be displayed only.", "delve" ),
         ),		
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Columns", "delve" ),
            "param_name" => "column",
            "value" => array("1","2","3","4"),
            "description" => __( "Number of columns in which the team members' details will be displayed(1 - 4).", "delve" ),
         ),		
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Per Page", "delve" ),
            "param_name" => "per_page",
            "value" => __( "-1", "delve" ),
            "description" => __( "Number of maximum testimonials to be displayed in single page.", "delve" ),
         ),		 
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "CSS Class", "delve" ),
            "param_name" => "class",
             "value" => __( " ", "delve" ),
            "description" => __( "You can give a css class if you want to customize it and give it new styles.", "delve" ),
         ),		   	
		 array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "CSS Styles", "delve" ),
            "param_name" => "style",
            "value" => __( " ", "delve" ),
            "description" => __( "Custom css can be assigned also.", "delve" ),
         ),       		    
		)
	  )
	);
	
	 vc_map( array(
      "name" => __( "Delve Contact Info", "delve" ),
      "base" => "delve_contact_info",
	  "icon" => "delve-vc",
      "class" => "",
  	  "category" => __( "Delve", "delve"),
      "params" => array(
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Title", "delve" ),
            "param_name" => "title",
            "value" => __( "Contact Information", "delve" ),
            "description" => __( "Title of the contact information section.", "delve" ),
         ),		
		  array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => __("Text", delve),
			"param_name" => "content",
			"value" => __("<h6>BUSINESS HOURS</h6>
Our support Hotline is available 24 Hours a day: (0) 123 456 789
Monday-Friday : 8am to 6pm
Saturday : 10am to 2pm
Sunday : Closed
<h6>BUILDING ADDRESS</h6>
Here, You Can add your office/building Address...
<h6>EMAIL</h6>
<ul>
	<li><a href='mailto:yourmail@domain.com'>yourmail@domain.com</a></li>
	<li><a href='mailto:yourmail@domain.com'>yourmail@domain.com</a></li>
</ul>
<h6>CELLPHONE</h6>
+0 123 456 789.", 'delve')
		),	  		 	    
		)
	  )
	);
	
	vc_map( array(
    "name" => __("Delve Slider", "delve"),
    "base" => "delve_slider",
    "as_parent" => array('only' => 'delve_slide'), 
	"icon" => "delve-vc",     
    "content_element" => true,
    "show_settings_on_create" => false,
    "category" => __( "Delve", "delve"),     
	"params" => array(
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Type", "delve" ),
            "param_name" => "type",
            "value" => array("basic","thumbnail"),
            "description" => __( "In basic slider all slides are displayed one by one. In thumbnail type, the thumbnails of other slides are displyed at bottom side of current slide.", "delve" ),
         ),		
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Animation", "delve" ),
            "param_name" => "animation",
            "value" => array("slide","fadeIn"),
            "description" => __( "Possible two options are fade and slide.", "delve" ),
         ),		
		  array(
            "type" => "dropdown",           
            "class" => "",
            "heading" => __( "Border", "delve" ),
            "param_name" => "border",
            "value" => array("yes","no"),
            "description" => __( "Possible two options are yes or no. Set yes to display border and no for borderless slides.", "delve" ),
         ),				 	    
		),
    "js_view" => 'VcColumnView'
) );
vc_map( array(
    "name" => __("Delve Slide", "delve"),
    "base" => "delve_slide",
	"icon" => "delve-vc",        
    "content_element" => true,
    "as_child" => array('only' => 'delve_slider'), // Use only|except attributes to limit parent (separate multiple values with comma)
      "params" => array(
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "URL", "delve" ),
            "param_name" => "url",
            "value" => __( " ", "delve" ),
            "description" => __( "Provide the url of the image.", "delve" ),
         ),		
		  array(
            "type" => "textfield",           
            "class" => "",
            "heading" => __( "Link", "delve" ),
            "param_name" => "link",
            "value" => __( " ", "delve" ),
            "description" => __( "Provide the url where the user should be redirected when this image is clicked.", "delve" ),
         ),		 		 	    
		)    
) );
//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Delve_Slider extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Delve_Slide extends WPBakeryShortCode {
    }
}
}

?>