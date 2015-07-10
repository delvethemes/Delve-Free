<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */
add_filter( 'rwmb_meta_boxes', 'one_page_theme_register_meta_boxes' );
/**
 * Register meta boxes
 *
 * @return void
 */
 
function one_page_theme_register_meta_boxes( $meta_boxes ) {

$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
$all_menu[NULL] = 'Select Menu';
foreach ( $menus as $menu ):
	$all_menu[$menu->name] = $menu->name;
endforeach; 

global $wpdb;
$revsliders[NULL] = "Select a Slider";
if(function_exists('putRevSlider')){
$get_sliders = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'revslider_sliders');
if($get_sliders) {
	foreach($get_sliders as $slider) {
		$revsliders[$slider->alias] = $slider->title;
	}
}
}//if function exists
        /**
         * Prefix of meta keys (optional)
         * Use underscore (_) at the beginning to make keys hidden
         * Alt.: You also can make prefix empty to disable it
         */
        // Better has an underscore as last sign
        $prefix = 'delve_meta_';
        // 1st meta box
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'standard',
                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Delve Theme Settings', 'rwmb' ),
                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page'),
                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',
                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',
                // Auto save: true, false (default). Optional.
                'autosave' => true,
                // List of meta fields
                'fields' => array(
				
				// checkbox		
				array(
					'name' => __( 'Display Page Heading', 'cmb' ),
					'desc' => __( 'Check This For Display Page Heading.', 'cmb' ),
					'id'   => "{$prefix}show_heading",
					'std'   => "checked",
					'type' => 'checkbox',
				 ),
				 
				// COLOR
				array(
                	'name' => __( 'Page Background', 'rwmb' ),
					'desc' => __( 'Select Color to Set of Page Background.', 'cmb' ),
                    'id'   => "{$prefix}page_bg_color",
                	'type' => 'color',
				),
						
				//textbox
				array(
					'name'	=> __('Page Title', 'rwmn'),
					'id'	=> "{$prefix}page-heading",
					'desc' => __( 'Here, You can add page title, This will work only in single page theme.', 'cmb' ),
					'type'	=> "text"
				),
				
				array(
					'name'  => __( 'Tag Line', 'rwmb' ),
					'id'    => "{$prefix}tag-line",
					'desc' => __( 'Short description about the page, This will work only in single page theme.', 'cmb' ),
					'type'  => 'textarea',
				),
				
				array(
					'name'     => __( 'Select Revolution Slider', 'rwmb' ),
					'id'       => "{$prefix}rev_slider",
					'desc' => __( 'Select slider as top of the page content, this will not display in single page theme, you have to add shortcode.', 'cmb' ),
					'type'     => 'select',
					'options'  => $revsliders,
					'multiple'    => false,
					'std'         => '-1',
					//'placeholder' => __( 'Select a Slider', 'rwmb' ),
				),
				
				array(
					'name'     => __( 'Select Sidebar Position', 'rwmb' ),
					'id'       => "{$prefix}sidebar_position",
					'desc' => __( 'Select a sidebar position for page, set Full Width for set as Full Width page.', 'cmb' ),
					'type'     => 'select',
					'options'  => array( 'right' => 'Right', 'left' => 'Left', 'none' => 'Full Width' ),
					'multiple'    => false,
					'std'         => 'none',
				),
				
				array(
					'name'     => __( 'Select Sidebar Menu', 'rwmb' ),
					'id'       => "{$prefix}side_nav_menu",
					'desc'	   => __( 'Choose menu to display in Side Navigation page template.', 'cmb' ),
					'type'     => 'select',
					'options'  => $all_menu,
					'multiple'    => false,
					'std'         => 'right',
				),
				
				array(
					'name'     => __( 'Select Columns', 'rwmb' ),
					'id'       => "{$prefix}page_columns",
					'desc'	   => __( 'Choose columns to display in portfolio and blog page.', 'cmb' ),
					'type'     => 'select',
					'options'  => array (
										'col-md-12 delve-col-1'	=> '1 Column',
										'col-md-6 delve-col-2'	=> '2 Column',
										'col-md-4 delve-col-3'	=> '3 Column',
										'col-md-3 delve-col-4'	=> '4 Column',
									),
					'multiple'    => false,
					'std'         => 'col-md-12 delve-col-1',
				),
				
            ),
        );
		
		$meta_boxes[] = array(
                'id' => 'portfolio',
                'title' => __( 'Delve Theme Settings', 'rwmb' ),
                'pages' => array( 'portfolio'),
                'context' => 'normal',
                'priority' => 'high',
                'autosave' => true,
                'fields' => array(
                       
				//textbox
				array(
					'name'  => __( 'Customer Name', 'rwmb' ),
					'id'    => "{$prefix}customer_name",
					'type'  => 'text',
				),
	
				array(
					'name'  => __( 'Live Demo', 'rwmb' ),
					'id'    => "{$prefix}portfolio_link",
					'type'  => 'text',
				),
				
				array(
					'name'  => __( 'Skills', 'rwmb' ),
					'id'    => "{$prefix}skills",
					'type'  => 'text',
				),
				
				array(
					'name'  => __( 'Date of Project', 'rwmb' ),
					'id'    => "{$prefix}project_date",
					'type'  => 'text',
				),
						
            ),
        );
		
		/******* ourteam metabox *******/
		$meta_boxes[] = array(
                'id' => 'ourteam',
                'title' => __( 'Delve Theme Settings', 'rwmb' ),
                'pages' => array( 'ourteam'),
                'context' => 'normal',
                'priority' => 'high',
                'autosave' => true,
                'fields' => array(
				
				array(
					'name'  => __( 'Description', 'rwmb' ),
					'id'    => "{$prefix}ourteam_description",
					'type'  => 'textarea',
				),
				
				array(
					'name'  => __( 'Designation', 'rwmb' ),
					'id'    => "{$prefix}ourteam_designation",
					'type'  => 'text',
				),
				
				array(
					'name'  => __( 'Facebook :', 'rwmb' ),
					'id'    => "{$prefix}ot_facebook",
					'type'  => 'text',
				),
				
				array(
					'name'  => __( 'Twitter : ', 'rwmb' ),
					'id'    => "{$prefix}ot_twitter",
					'type'  => 'text',
				),
				
				array(
					'name'  => __( 'Google Plus : ', 'rwmb' ),
					'id'    => "{$prefix}ot_gplus",
					'type'  => 'text',
				),
				
				array(
					'name'  => __( 'Linked In : ', 'rwmb' ),
					'id'    => "{$prefix}ot_linkedin",
					'type'  => 'text',
				),
						
            ),
        );
		
		//Testimonials metaboxes
		$meta_boxes[] = array(
                'id' => 'testimonials',
                'title' => __( 'Delve Theme Settings', 'rwmb' ),
                'pages' => array( 'testimonials'),
                'context' => 'normal',
                'priority' => 'high',
                'autosave' => true,
                'fields' => array(
				
				array(
					'name'  => __( 'Designation / Position / Location / Other ', 'rwmb' ),
					'id'    => "{$prefix}testimonial",
					'type'  => 'text',
				),
				
			),
		);
		
		// Gallery		
		$meta_boxes[] = array(
                'id' => 'gallery',
                'title' => __( 'Delve Theme Settings', 'rwmb' ),
                'pages' => array( 'gallery'),
                'context' => 'normal',
                'priority' => 'high',
                'autosave' => true,
                'fields' => array(
				
				array(
					'name'  => __( 'Tag Line', 'rwmb' ),
					'id'    => "{$prefix}g_tag_line",
					'type'  => 'text',
				),
				
			),
		);		
		
		// Product
		$meta_boxes[] = array(
                'id' => 'product',
                'title' => __( 'Delve Theme Settings', 'rwmb' ),
                'pages' => array( 'product'),
                'context' => 'normal',
                'priority' => 'high',
                'autosave' => true,
                'fields' => array(
					array(
						'name' => __( 'Display Product Title', 'cmb' ),
						'desc' => __( 'Check This To Display Product Title.', 'cmb' ),
						'id'   => "{$prefix}show_product_title",
						'std'   => "checked",
						'type' => 'checkbox',
				 	),
				
				),
			);
        
        return $meta_boxes;
}