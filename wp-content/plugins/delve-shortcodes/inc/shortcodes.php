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
// icon boxe
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
			$atts['animation'] = "fade";
		if( $atts['border'] == "yes/no" )
			$atts['animation'] = "yes";			
		
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