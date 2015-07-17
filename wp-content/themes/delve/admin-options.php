<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */
if (!class_exists('Redux_Framework_sample_config')) {
    class Redux_Framework_sample_config {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;
        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }
        public function initSettings() {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        /**
          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.
         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }
              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }
        /**
          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.
          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'delve'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'delve'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**
          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments($args) {
            //$args['dev_mode'] = false;
            return $args;
        }
        /**
          Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';
            return $defaults;
        }
        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }
        public function setSections() {
            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();
			$img_path = get_template_directory_uri()."/images/";
            if (is_dir($sample_patterns_path)) :
                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();
                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {
                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;
            ob_start();
            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'delve'), $this->theme->display('Name'));  ?>
            
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>
                <h4><?php echo $this->theme->display('Name'); ?></h4>
                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'delve'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'delve'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'delve') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'delve'), $this->theme->parent()->display('Name'));
            }
            ?>
                </div>
            </div>
            <?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }
			
			$img_path = get_template_directory_uri()."/images/";
// ACTUAL DECLARATION OF SECTIONS
/******* home settings ******/
$this->sections[] = array(
	'title'     => __('General Settings', 'delve'),
	'icon'      => 'el-icon-home',
	'fields'    => array(
		array(
			'id'        => 'logo-favicon',
			'type'      => 'info',
			'title'		=> __('Logo & Favicon', 'delve'),
			'desc'      => __('Upload proper images.', 'delve')
		),			
		array(
			'id'        => 'site-logo',
			'type'      => 'media',
			'title'     => __('Logo', 'delve'),
			'desc'      => __('', 'delve'),
			'subtitle'  => __('Upload an image for logo.', 'delve'),
		),
		array(
			'id'        => 'site-logo-navigation',
			'type'      => 'text',
			'title'     => __('Logo Navigation URL', 'delve'),
			'desc'      => __('By default it will take user to Homepage.', 'delve'),
			'subtitle'  => __('Enter the URL where the page should be redirected when logo is clicked.', 'delve'),
		),
		
		array(
    'id'             => 'logo-spacing',
    'type'           => 'spacing',
    'output'         => '.navbar .container .navbar-brand',
    'mode'           => 'margin',
    'units'          => array('em', 'px'),
    'units_extended' => 'false',
    'title'          => __('Logo Margin', 'delve'),
    'subtitle'       => __('Specify the logo spacing from top,right,bottom and left.', 'redux-framework-demo'),
    'desc'           => __('', 'delve'),
    'default'            => array(
        'margin-top'     => '15px', 
        'margin-right'   => '15px', 
        'margin-bottom'  => '15px', 
        'margin-left'    => '0',
        'units'          => 'px', 
    )
),
		array(
			'id'        => 'site-tagline',
			'type'      => 'text',
			'title'     => __('Site Tag Line', 'delve'),
			'desc'      => __('', 'delve'),
			'subtitle'  => __('Enter tag line for site.', 'delve'),		
		),
		
		array(
			'id'        => 'site-tagline-font',
			'type'      => 'typography',
			'output'	=> '.tagline',
			'title'     => __('Tagline Font', 'delve'),
			'subtitle'  => __('Specify the font properties for tag line.', 'delve'),
			'google'    => true,
			'default'   => array(
				'color'         => '#a1b1bc',
				'font-size'     => '16px',
				'line-height'	=> '28px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal',
			),
		),
		
		array(
			'id'        => 'sitename-font',
			'type'      => 'typography',
			'output'	=> '.navbar-header a.navbar-brand span',
			'title'     => __('Sitename Font', 'delve'),
			'subtitle'  => __('Specify the font properties for sitename if the logo is not specified.', 'delve'),
			'google'    => true,
			'default'   => array(
				'color'         => '#a1b1bc',
				'font-size'     => '30px',
				'line-height'	=> '28px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal',
			),
		),
					
		array(
			'id'        => 'site-favicon',
			'type'      => 'media',
			'title'     => __('Favicon Icon', 'delve'),
			'desc'      => __('Size should be 16 x 16 or 32 x 32,', 'delve'),
			'subtitle'  => __('Upload an image that needs to be displayed as favicon.', 'delve'),
		),
		
		array(
		'id'       => 'hide-back-to-top-button',
		'type'     => 'checkbox',
		'title'    => __('Hide Back to Top Button', 'delve'),    
		'subtitle'     => __('Check this box if you want to hide back to top button.','delve'),
	),
		array(
			'id'        => 'plugin-customization',
			'type'      => 'info',
			'title'		=> __('Features Availability Settings', 'delve'),
			'desc'      => __('Note: Delve Shortcodes plugin must be active to apply these settings.', 'delve')
		),
		
		array (
			'id'		=> 'portfolio-switch',
			'type'		=> 'switch',
			'title'		=> __('Portfolio Enable/Disable', 'delve'),
			'subtitle'	=> __('Enable/Disable Portfolio custom post type.', 'delve'),
			'desc'		=> __('', 'delve'),
			'on'        => 'Enabled',
			'off'       => 'Disabled',
			'default'   => 1
		),
		
		array (
			'id'		=> 'ourteam-switch',
			'type'		=> 'switch',
			'title'		=> __('Team Enable/Disable', 'delve' ),
			'subtitle'	=> __('Enable/Disable Team custom post type.', 'delve'),
			'desc'		=> __('', 'delve'),
			'on'        => 'Enabled',
			'off'       => 'Disabled',
			'default'   => 1
		),
		
		array (
			'id'		=> 'testimonials-switch',
			'type'		=> 'switch',
			'title'		=> __('Testimonials Enable/Disable', 'delve'),
			'subtitle'	=> __('Enable/Disable Testimonials custom post type.', 'delve'),
			'desc'		=> __('', 'delve'),
			'on'        => 'Enabled',
			'off'       => 'Disabled',
			'default'   => 1
		),
		
		array (
			'id'		=> 'gallery-switch',
			'type'		=> 'switch',
			'title'		=> __('Gallery Enable/Disable', 'delve'),
			'subtitle'	=> __('Enable/Disable Gallery custom post type.', 'delve'),
			'desc'		=> __('', 'delve'),
			'on'        => 'Enabled',
			'off'       => 'Disabled',
			'default'   => 1
		),
	),
);
$this->sections[] = array(
	'type' => 'divide',
);
/******* header option ******/			
$this->sections[] = array(
	'icon'      => 'el-icon-credit-card',
	'title'     => __('Header Settings', 'delve'),
	'fields'    => array(
					
		array(
			'id'        => 'header-versions',
			'type'      => 'image_select',
			'title'     => __('Header Layout', 'delve'),
			'subtitle'  => __('Please choose a header layout.', 'delve'),
			'desc'      => __('', 'delve'),
                        
			//Must provide key => value(array:title|img) pairs for radio options
			'options'   => array(
				'header-v1' => array('title' => '', 'img' => $img_path.'headers/m1.jpg'),
				'header-v2' => array('title' => '', 'img' => $img_path.'headers/m2.jpg'),
				'header-v3' => array('title' => '', 'img' => $img_path.'headers/m3.jpg'),
				'header-v4' => array('title' => '', 'img' => $img_path.'headers/m4.jpg'),
				'header-v5' => array('title' => '', 'img' => $img_path.'headers/m5.jpg'),
				'header-v6' => array('title' => '', 'img' => $img_path.'headers/m6.jpg'),
				'header-v7' => array('title' => '', 'img' => $img_path.'headers/m7.jpg'),
				'header-v8' => array('title' => '', 'img' => $img_path.'headers/m8.jpg'),
				'header-v9' => array('title' => '', 'img' => $img_path.'headers/m9.jpg'),
				'header-v10' => array('title' => '', 'img' => $img_path.'headers/m10.jpg'),
				'header-v11' => array('title' => '', 'img' => $img_path.'headers/m11.jpg'),
			), 
			'default'   => 'header-v1'
		),
		
		array(
			'id'        => 'header-bg-type',
			'type'      => 'select',
			//'required'  => array('transparent-menu', '=', 0),
			'title'     => __('Header Background', 'delve'),
			'subtitle'  => __('Set Header Menu background pattern or color.', 'delve'),
			'desc'      => __('', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'gradient'	=> 'Gradient', 
				'pattern'	=> 'Pattern',
				'custom-bg'	=> 'Custom'
			),
			'default'   => ''
		),
		
		array(
			'id'        => 'header-gradient-color',
			'type'      => 'color_gradient',
			'required'  => array('header-bg-type', '=', 'gradient'),
			//'output'    => array('.navbar'),
			'title'     => __('Header Background Color', 'delve'),
			'subtitle'  => __('Set Header Menu background gradient color', 'delve'),
		),
		
		array(
			'id'        => 'header-patterns',
			'type'      => 'image_select',
			'title'     => __('Background Patterns', 'delve'),
			'required'  => array('header-bg-type', '=', 'pattern'),
			//'output'    => array('.navbar'),
			'subtitle'  => __('Set Header Menu background pattern.', 'delve'),
			'desc'      => __('', 'delve'),
			'options'   => array(
				null => array('title' => '', 'img' => $img_path.'pattern/thumbnails/none.jpg'),
				$img_path.'pattern/1.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/1.jpg'),
				$img_path.'pattern/2.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/2.jpg'),
				$img_path.'pattern/3.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/3.jpg'),
				$img_path.'pattern/4.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/4.jpg'),
				$img_path.'pattern/5.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/5.jpg'),
				$img_path.'pattern/6.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/6.jpg'),
				$img_path.'pattern/7.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/7.jpg'),
				$img_path.'pattern/8.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/8.jpg'),
				$img_path.'pattern/9.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/9.jpg'),
				$img_path.'pattern/10.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/10.jpg')                            
			), 
			'default'   => null
		),
		
		array(
			'id'        => 'header-bg',
			'type'      => 'background',
			'required'  => array('header-bg-type', '=', 'custom-bg'),
			'title'     => __('Header Title Background', 'delve'),
			'subtitle'  => __('It will shown behind the logo and menu section.', 'delve'),
			'output'    =>	array('.navbar'),
		),
		
		array(
			'id'        => 'menu-font-style',
			'type'      => 'typography',
			'output'	=> '.navbar-inverse .navbar-nav > li > a, .dropdown-menu > li > a',
			'title'     => __('Menu Font Style', 'delve'),
		),
		
		array(
			'id'        => 'menu-font-hover-style',
			'type'      => 'color',
			'output'	=> '.navbar-inverse .navbar-nav > li > a:hover, .dropdown-menu > li > a:hover',
			'title'     => __('Menu Font Hover Color', 'delve'),
		),
		array(
			'id'        => 'menu-hover-background-color',
			'type'      => 'color',
			'output'    => array('background-color' => '.dropdown-menu > li > a:hover', 
								 'border-top' => '.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .dropdown-menu > .active > a'),
			'title'     => __('Menu Hover Background Color', 'delve'),
		),
		
		array (
			'id'		=> 'topbar-switch',
			'type'		=> 'switch',
			'title'		=> __('Topbar Enable/Disable', 'delve'),
			'subtitle'	=> __('Specify whether you want a top bar or not.', 'delve'),
			'desc'		=> __('', 'delve'),
			'on'        => 'Enabled',
			'off'       => 'Disabled',
		),
		
		array(
			'id'        => 'topbar-left',
			'type'      => 'select',
			'required'	=> array('topbar-switch', '=', 1),
			'title'     => __('Topbar Left Side', 'delve'),
			'subtitle'  => __('Choose a section that should be on left side of top bar.', 'delve'),
			'desc'      => __('', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'contact-details'	=> 'Contact Details', 
				'social-icons'	=> 'Social Icons',
				'secondary-menu' => 'Secondary Menu'
			),
		),
		
		array(
			'id'        => 'topbar-right',
			'type'      => 'select',
			'title'     => __('Topbar Right Side', 'delve'),
			'subtitle'  => __('Choose a section that should be on right side of top bar.', 'delve'),
			'desc'      => __('', 'delve'),
			'required'	=> array('topbar-switch', '=', '1'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'contact-details'	=> 'Contact Details', 
				'social-icons'	=> 'Social Icons',
				'secondary-menu' => 'Secondary Menu'
			),
		),
		
		array(
			'id'        => 'topbar-bg',
			'type'      => 'background',
			'required'	=> array('topbar-switch', '=', '1'),
			'title'     => __('Topbar Background', 'delve'),
			'subtitle'  => __('Topbar background with image, color, etc.', 'delve'),
			'output'    =>	'div.delve-top-nav',
		),
		
		array(
		'id'        => 'topbar-social-icons-cart-menu-color',
		'type'      => 'color',
		'title'     => __('Topbar Social Icons,Top Menu Color', 'delve'),
		'subtitle'  => __('Choose social icons color and Top Menu for top bar.', 'delve'),
		'output'	=> array( '.delve-social li i','.topbar-cart-menu i' ),
		),
		
		array(
		'id'        => 'topbar-contact-details-menu',
		'type'      => 'color',
		'title'     => __('Topbar Secondary Menu, Contact Details Color', 'delve'),
		'subtitle'  => __('Choose secondary menu and contact details', 'delve'),
		'output'	=> array( '.delve-top-nav span.top-nav-opt','.top-nav-opt.top-nav-cotact i','.delve-secondary-nav-container div ul.menu li a','.top-nav-opt.top-nav-email i' ),
		),
		
		
		array(
			'id'		=> 'contact-number',
			'type'		=> 'text',
			'required'	=> array('topbar-switch', '=', '1'),
			'title'		=> __('Contact Number', 'delve')
		),
		array(
			'id'		=> 'mail-addr',
			'type'		=> 'text',
			'required'	=> array('topbar-switch', '=', '1'),
			'title'		=> __('Mail Address', 'delve')
		),
		array(
		'id'       => 'show-page-title-bar',
		'type'     => 'checkbox',
		'title'    => __('Show Page Title Bar', 'delve'),    
		'subtitle'     => __('Check the box to show the page title bar. This is a global option for every page or post, and this can be overridden by individual page/post options.','delve'),
		),
		array(
			'id'		=> 'hide-contact-no',
			'type'		=> 'switch',
			'title'		=> __('Hide contact no. in mobile view', 'delve'),
			'subtitle'	=> __('Specify whether you want to show contact no or not.', 'delve'),
			'desc'		=> __('If visible is selected then only mobile will display contact no in topbar.', 'delve'),
			'required'	=> array('topbar-switch', '=', '1'),
			'on'        => 'Visible',
			'off'       => 'Hidden',
			'default'   => 1
		),
		array(
			'id'		=> 'hide-social-icons',
			'type'		=> 'switch',
			'title'		=> __('Hide social icons in mobile view', 'delve'),
			'subtitle'	=> __('Specify whether you want to show social icons or not.', 'delve'),
			'desc'		=> __('If visible is selected then only mobile will display social icons in topbar.', 'delve'),
			'required'	=> array('topbar-switch', '=', '1'),
			'on'        => 'Visible',
			'off'       => 'Hidden',
			'default'   => 1
		),
		array(
			'id'		=> 'hide-email',
			'type'		=> 'switch',
			'title'		=> __('Hide email text in mobile view', 'delve'),
			'subtitle'	=> __('Specify whether you want to show email or not.', 'delve'),
			'desc'		=> __('If visible is selected then only mobile will display email in topbar.', 'delve'),
			'required'	=> array('topbar-switch', '=', '1'),
			'on'        => 'Visible',
			'off'       => 'Hidden',
			'default'   => 1
		),
		array(
			'id'		=> 'hide-secondary-menu',
			'type'		=> 'switch',
			'title'		=> __('Hide secondary menu in mobile view', 'delve'),
			'subtitle'	=> __('Specify whether you want to show secondary menu or not.', 'delve'),
			'desc'		=> __('If visible is selected then only mobile will display secondary menu in topbar.', 'delve'),
			'required'	=> array('topbar-switch', '=', '1'),
			'on'        => 'Visible',
			'off'       => 'Hidden',
			'default'   => 1
		),
	)
);
			
/******* background options ******/
$this->sections[] = array(
	'icon'      => 'el-icon-picture',
	'title'     => __('Background Settings', 'delve'),
	'fields'    => array(
				
		array(
			'id'        => 'theme-layout',
			'type'      => 'select',
			'title'     => __('Layout', 'delve'),
			'subtitle'  => __('Choose a global layout of the site.', 'delve'),
			'desc'      => __('Body background will be visible in BOX mode only.', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'wide' => 'Wide', 
				'box' => 'Box'
			),
			'default'   => 'wide'
		),
		
		array(
			'id'        => 'body-bg-type',
			'type'      => 'select',
			'required'  => array('theme-layout', '=', 'box'),
			'title'     => __('Body Background', 'delve'),
			'subtitle'  => __('', 'delve'),
			'desc'      => __('', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'bg-image'	=> 'Custom Background', 
				'pattern'	=> 'Pattern'
			),
			'default'   => 'pattern'
		),
					
		array(
			'id'        => 'body-bg',
			'type'      => 'background',
			'output'    => array('body'),
			'required'  => array('body-bg-type', '=', 'bg-image'),
			'title'     => __('Background', 'delve'),
			'subtitle'  => __('Body background with image, color, etc.', 'delve'),
			//'default'   => '#FFFFFF',
		),
				
		array(
			'id'        => 'bg-patterns',
			'type'      => 'image_select',
			'title'     => __('Background Patterns', 'delve'),
			'required'  => array('body-bg-type', '=', 'pattern'),
			//'output'    => array('body'),
			'subtitle'  => __('No validation can be done on this field type', 'delve'),
			'desc'      => __('', 'delve'),
			'options'   => array(
				null => array('title' => '', 'img' => $img_path.'pattern/thumbnails/none.jpg'),
				$img_path.'pattern/1.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/1.jpg'),
				$img_path.'pattern/2.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/2.jpg'),
				$img_path.'pattern/3.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/3.jpg'),
				$img_path.'pattern/4.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/4.jpg'),
				$img_path.'pattern/5.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/5.jpg'),
				$img_path.'pattern/6.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/6.jpg'),
				$img_path.'pattern/7.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/7.jpg'),
				$img_path.'pattern/8.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/8.jpg'),
				$img_path.'pattern/9.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/9.jpg'),
				$img_path.'pattern/10.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/10.jpg')                            
			), 
			'default'   => null
		),
		
		array(
			'id'        => 'ptitle-bg-type',
			'type'      => 'select',
			'title'     => __('Page Title Background', 'delve'),
			'subtitle'  => __('', 'delve'),
			'desc'      => __('Choose which type of background you want. Custom color + image or readymade patterns', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'bg-image'	=> 'Custom Background', 

				'pattern'	=> 'Pattern'
			),
			'default'   => 'pattern'
		),
			
				
		array(
			'id'        => 'ptitle-bg',
			'type'      => 'background',
			'required'	=>	array('ptitle-bg-type','=','bg-image'),
			'title'     => __('Page Title Custom Background', 'delve'),
			'subtitle'  => __('Body background with image, color, etc.', 'delve'),
			'output'    =>	array('.container-header'),
		),
		
					
		array(
			'id'        => 'ptitle-patterns',
			'type'      => 'image_select',
			'output'    =>	array('.container-header'),
			'required'	=>	array('ptitle-bg-type','=','pattern'),
			'title'     => __('Page Title Background Patterns', 'delve'),
			'subtitle'  => __('No validation can be done on this field type', 'delve'),
			'desc'      => __('', 'delve'),
			'options'   => array(
				null => array('title' => '', 'img' => $img_path.'pattern/thumbnails/none.jpg'),
				$img_path.'pattern/1.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/1.jpg'),
				$img_path.'pattern/2.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/2.jpg'),
				$img_path.'pattern/3.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/3.jpg'),
				$img_path.'pattern/4.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/4.jpg'),
				$img_path.'pattern/5.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/5.jpg'),
				$img_path.'pattern/6.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/6.jpg'),
				$img_path.'pattern/7.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/7.jpg'),
				$img_path.'pattern/8.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/8.jpg'),
				$img_path.'pattern/9.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/9.jpg'),
				$img_path.'pattern/10.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/10.jpg')                            
			), 
			'default'   => null
		),
	/*	array(
			'id'        => 'page',
			'type'      => 'background',
			'required'	=>	array('content-bg-type','=','bg-image'),
			'output'    => array('#wrapper'),
			'title'     => __('Content Background', 'delve'),
			'subtitle'  => __('Content background with image, color, etc.', 'delve'),
			//'default'   => '#FFFFFF',
		),*/
		array(
			'id'        => 'content-bg-type',
			'type'      => 'select',
			'title'     => __('Content Background', 'delve'),
			'subtitle'  => __('Set background color for content area.', 'delve'),
			'desc'      => __('', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'bg-image'	=> 'Custom Background', 
				'pattern'	=> 'Pattern'
			),
			'default'   => 'pattern'
		),
					
		array(
			'id'        => 'content-bg',
			'type'      => 'background',
			'required'	=>	array('content-bg-type','=','bg-image'),
			'output'    => array('#wrapper'),
			'title'     => __('Content Background', 'delve'),
			'subtitle'  => __('Content background with image, color, etc.', 'delve'),
			//'default'   => '#FFFFFF',
		),
					
		array(
			'id'        => 'content-patterns',
			'type'      => 'image_select',
			'required'	=>	array('content-bg-type','=','pattern'),
			'output'    => array('#wrapper'),
			'title'     => __('Content Background Patterns', 'delve'),
			'subtitle'  => __('No validation can be done on this field type', 'delve'),
			'desc'      => __('', 'delve'),
			'options'   => array(
				null => array('title' => '', 'img' => $img_path.'pattern/thumbnails/none.jpg'),
				$img_path.'pattern/1.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/1.jpg'),
				$img_path.'pattern/2.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/2.jpg'),
				$img_path.'pattern/3.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/3.jpg'),
				$img_path.'pattern/4.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/4.jpg'),
				$img_path.'pattern/5.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/5.jpg'),
				$img_path.'pattern/6.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/6.jpg'),
				$img_path.'pattern/7.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/7.jpg'),
				$img_path.'pattern/8.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/8.jpg'),
				$img_path.'pattern/9.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/9.jpg'),
				$img_path.'pattern/10.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/10.jpg')                            
			), 
			'default'   => null
		),
		
			array(
			'id'        => 'footer-widget-type',
			'type'      => 'select',
			'required'  => array('switch-fwidgets', "=", 1),
			'title'     => __('Footer Widget Background', 'delve'),
			'subtitle'  => __('', 'delve'),
			'desc'      => __('', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'bg-image'	=> 'Custom Background', 
				'pattern'	=> 'Pattern'
			),
			'default'   => ''
		),
					
		array(
			'id'        => 'footer-widget-bg',
			'type'      => 'background',
			'required'	=>	array('footer-widget-type','=','bg-image'),
			'output'    => array('footer .footer-widget'),
			'title'     => __('Footer Widget Background', 'delve'),
			'subtitle'  => __('Footer widget background with image, color, etc.', 'delve'),
			//'default'   => '#FFFFFF',
		),
					
		array(
			'id'        => 'footer-widget-patterns',
			'type'      => 'image_select',
			'required'	=>	array('footer-widget-type','=','pattern'),
			//'output'    => array('footer .footer-widget'),
			'title'     => __('Footer Widget Background Patterns', 'delve'),
			'subtitle'  => __('Select pattern to set it as footer widget background.', 'delve'),
			'desc'      => __('', 'delve'),
			'options'   => array(
				null => array('title' => '', 'img' => $img_path.'pattern/thumbnails/none.jpg'),
				$img_path.'pattern/1.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/1.jpg'),
				$img_path.'pattern/2.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/2.jpg'),
				$img_path.'pattern/3.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/3.jpg'),
				$img_path.'pattern/4.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/4.jpg'),
				$img_path.'pattern/5.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/5.jpg'),
				$img_path.'pattern/6.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/6.jpg'),
				$img_path.'pattern/7.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/7.jpg'),
				$img_path.'pattern/8.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/8.jpg'),
				$img_path.'pattern/9.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/9.jpg'),
				$img_path.'pattern/10.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/10.jpg')
			), 
			'default'   => null
		),
		
			array(
			'id'        => 'footer-bg-type',
			'type'      => 'select',
			'required'	=>	array('switch-fcb','=','1'),
			'title'     => __('Footer Background', 'delve'),
			'subtitle'  => __('', 'delve'),
			'desc'      => __('', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'gradient'	=> 'Gradient',
				'pattern'	=> 'Pattern',
				'bg-image'	=> 'Custom Background'
			),
			'default'   => ''
		),
					
		array(
			'id'        => 'footer-bg',
			'type'      => 'background',
			'required'	=>	array('footer-bg-type','=','bg-image'),
			'output'    => array('.footer'),
			'title'     => __('Footer Background', 'delve'),
			'subtitle'  => __('Footer background with image, color, etc.', 'delve'),
			//'default'   => '#FFFFFF',
		),
					
		array(
			'id'        => 'footer-bg-patterns',
			'type'      => 'image_select',
			'required'	=>	array('footer-bg-type','=','pattern'),
			//'output'    => array('.footer'),
			'title'     => __('Footer Background Patterns', 'delve'),
			'subtitle'  => __('Select pattern to set it as a footer background.', 'delve'),
			'desc'      => __('', 'delve'),
			'options'   => array(
				null => array('title' => '', 'img' => $img_path.'pattern/thumbnails/none.jpg'),
				$img_path.'pattern/1.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/1.jpg'),
				$img_path.'pattern/2.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/2.jpg'),
				$img_path.'pattern/3.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/3.jpg'),
				$img_path.'pattern/4.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/4.jpg'),
				$img_path.'pattern/5.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/5.jpg'),
				$img_path.'pattern/6.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/6.jpg'),
				$img_path.'pattern/7.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/7.jpg'),
				$img_path.'pattern/8.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/8.jpg'),
				$img_path.'pattern/9.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/9.jpg'),
				$img_path.'pattern/10.jpg' => array('title' => '', 'img' => $img_path.'pattern/thumbnails/10.jpg')
			), 
			'default'   => null
		),
		
		array(
			'id'        => 'footer-bg-gradient',
			'type'      => 'color_gradient',
			'required'	=>	array('footer-bg-type','=','gradient'),
			//'output'    => array('.footer'),
			'title'     => __('Footer Background Color', 'delve'),
			'subtitle'  => __('Set footer background gradient color', 'delve'),
			'desc'      => __('', 'delve'),
		),
		
	)
);
/******* styling settings ******/
$this->sections[] = array(
	'icon'      => 'el-icon-website',
	'title'     => __('Styling Settings', 'delve'),
	//'subsection' => true,
	'fields'    => array(
	
		array(
			'id'        => 'delve-dark',
			'type'      => 'select',
			'title'     => __('Select Light or Dark Theme Version.', 'delve'),
			'subtitle'  => __('', 'delve'),
			'desc'      => __('', 'delve'),
                  
			//Must provide key => value pairs for select options
			'options'   => array(
				'none'		=> 'Light', 
				'dark.min.css'	=> 'Dark'
			),
			'default'   => 'none'
		),
	
		array(
			'id'        => 'delve-skins',
			'type'      => 'image_select',
			'compiler'  => true,
			'title'     => __('Theme Color Skins', 'delve'),
			'subtitle'  => __('Choose a color skin.', 'delve'),
			'options'   => array(
				'default.min.css'	=> array('img' => $img_path . 'skins/default.jpg'),
				'blue.min.css'		=> array('img' => $img_path . 'skins/blue.jpg'),
				'darkgrey.min.css'		=> array('img' => $img_path . 'skins/darkgrey.jpg'),
				'pink.min.css'		=> array('img' => $img_path . 'skins/pink.jpg'),
				'purple.min.css'		=> array('img' => $img_path . 'skins/purple.jpg'),
			),
			'default'   => 'default.min.css'
		), 
				
		array(
			'id'        => 'body-font',
			'type'      => 'typography',
			'output'	=> 'body',
			'title'     => __('Body Font', 'delve'),
			'subtitle'  => __('Specify the body font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'color'         => '#65727B',
				'font-size'     => '14px',
				'line-height'	=> '22px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal',
			),
		),
					
		array(
			'id'        => 'link-colors',
			'type'      => 'link_color',
			'output'	=> 'a',
			'title'     => __('Links Color', 'delve'),
			'subtitle'  => __('', 'delve'),
			'desc'      => __('', 'delve'),
			//'regular'   => false, // Disable Regular Color
			//'hover'     => true, // Disable Hover Color
		),
		array(
			'id'        => 'pagetitle-style-info',
			'type'      => 'info',
			'desc'      => __('PAGE TITLE SECTION', 'delve')
		),
		array(
			'id'        => 'ptitle-color',
			'type'      => 'typography',
			'output'	=> '.page-title-container h2',
			'title'     => __('Page Title Properties', 'delve'),
			'subtitle'  => __('Specify the header title font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'font-size'     => '22px',
				'line-height'	=> '75px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal'
			),
		),		
		array(
			'id'        => 'breadcrumb-color',
			'type'      => 'typography',
			'output'	=> '.page-title ul li, .page-title ul li a, .page-title ul li:hover, .container-header .page-title .delve-breadcrumb ul li a',
			'title'     => __('Breadcrumb Properties', 'delve'),
			'subtitle'  => __('Specify the breadcrumb font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'font-size'     => '13px',
				'line-height'	=> '75px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal'
			),
		),		
		array(
			'id'        => 'htag-style-info',
			'type'      => 'info',
			'desc'      => __('HEADER TAG STYLE', 'delve')
		),
		
		array(
			'id'        => 'h1tag-style',
			'type'      => 'typography',
			'output'	=> 'h1',
			'title'     => __('H1 Tag', 'delve'),
			'subtitle'  => __('Specify the H1 font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'font-size'     => '26px',
				'line-height'	=> '28px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal'
			),
		),
		
		array(
			'id'        => 'h2tag-style',
			'type'      => 'typography',
			'output'	=> 'h2',
			'title'     => __('H2 Tag', 'delve'),
			'subtitle'  => __('Specify the H2 font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'font-size'     => '24px',
				'line-height'	=> '26px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal'
			),
		),
		
		array(
			'id'        => 'h3tag-style',
			'type'      => 'typography',
			'output'	=> 'h3',
			'title'     => __('H3 Tag', 'delve'),
			'subtitle'  => __('Specify the H3 font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'font-size'     => '22px',
				'line-height'	=> '24px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal'
			),
		),
		
		array(
			'id'        => 'h4tag-style',
			'type'      => 'typography',
			'output'	=> 'h4',
			'title'     => __('H4 Tag', 'delve'),
			'subtitle'  => __('Specify the H4 font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'font-size'     => '20px',
				'line-height'	=> '22px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal'
			),
		),
		
		array(
			'id'        => 'h5tag-style',
			'type'      => 'typography',
			'output'	=> 'h5',
			'title'     => __('H5 Tag', 'delve'),
			'subtitle'  => __('Specify the H5 font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'font-size'     => '18px',
				'line-height'	=> '20px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal'
			),
		),
		
		array(
			'id'        => 'h6tag-style',
			'type'      => 'typography',
			'output'	=> 'h6',
			'title'     => __('H6 Tag', 'delve'),
			'subtitle'  => __('Specify the H6 font properties.', 'delve'),
			'google'    => true,
			'default'   => array(
				'font-size'     => '16px',
				'line-height'	=> '20px',
				'font-family'   => 'Lato',
				'font-weight'   => 'Normal'
			),
		),
	)
);
/******* woo options ******/
global $wp_registered_sidebars;
$sidebar_options['none'] = 'None';
for($i=0;$i<1;$i++){
	$sidebars = $wp_registered_sidebars;// sidebar_generator::get_sidebars();
	//var_dump($sidebars);
	if(is_array($sidebars) && !empty($sidebars)){
		foreach($sidebars as $sidebar){
			$sidebar_options[$sidebar['name']] = $sidebar['name'];
		}
	}
	$sidebars = sidebar_generator::get_sidebars();
	if(is_array($sidebars) && !empty($sidebars)){
		foreach($sidebars as $key => $value){
			$sidebar_options[$value] = $value;
		}
	}
}
$this->sections[] = array(
	'icon'      => 'el-icon-wordpress',
	'title'     => __('WooCommerce', 'delve'),
	'fields'    => array(
		
		array(
			'id'	=> 'place_cart_icon',
			'type'	=> 'checkbox',
			'title'	=> __('Show Cart Button At', 'delve'),
			'options'   => array(
					'cart_top_bar'	=> 'Topbar',
					'cart_menu'	=> 'Menu',
			),
			'subtitle' => 'Choose a location where to display Cart Icon.',
			'default'   => array(
				'cart_top_bar' => '1', 
				'cart_menu' => '0', 
			)
		),
		
		array(
			'id'		=> 'p_per_page',
			'type'		=> 'text',
			'title'		=> __('Product Per Page', 'delve'),
			'desc'		=> __('In shop page, how many products you want to display?', 'delve'),
			'default'	=> 12
		),
		array(
			'id'        => 's_shop_page_columns',
			'type'      => 'select',
			'compiler'  => true,
			'title'     => __('Shop Page Columns', 'delve'),
			'subtitle'  => __('Choose Shop/Store page, Product archive page columns.', 'delve'),
			'options'   => array(
					'1'	=> 'One',
					'2'	=> 'Two',
					'3'	=> 'Three',
					'4'	=> 'Four'
			),
			'default'   => '4'
		),
		array(
		'id'       => 'p_display_related_products',
		'type'     => 'checkbox',
		'title'    => __('Display related products?', 'delve'),    
		'subtitle'     => __('Check this box if you want to display related products in product page.','delve'),
		),		
		
		array(
			'id'	=> 's_product_info',
			'type'	=> 'info',
			'desc'	=> 'Single product page options customization.'
		),
		
		array(
			'id'        => 's_product-sidebar-position',
			'type'      => 'select',
			'compiler'  => true,
			'title'     => __('Single Product Sidebar Position', 'delve'),
			'subtitle'  => __('Choose a sidebar position in product page if you want a sidebar.', 'delve'),
			'options'   => array(
					'none'	=> 'Full Width',
					'right'	=> 'Right',
					'left'	=> 'Left'
			),
			'default'   => 'none'
		),
		
		array(
			'id'        => 's_product-sidebar',
			'type'      => 'select',
			'compiler'  => true,
			'title'     => __('Single Product Sidebar', 'delve'),
			'subtitle'  => __('Choose a sidebar that you want to display.', 'delve'),
			'options'   => $sidebar_options,
			'default'   => 'none'
		),
		
		array(
			'id'	=> 'a_product_info',
			'type'	=> 'info',
			'desc'	=> 'Product archive pages ( category/tag ) options customization.'
		),
		
		array(
			'id'        => 'a_product-sidebar-position',
			'type'      => 'select',
			'compiler'  => true,
			'title'     => __('Archive Sidebar Position', 'delve'),
			'subtitle'  => __('Choose a sidebar position in archive(category/tag) page if you want a sidebar.', 'delve'),
			'options'   => array(
					'none'	=> 'Full Width',
					'right'	=> 'Right',
					'left'	=> 'Left'
			),
			'default'   => 'none'
		),
		
		array(
			'id'        => 'a_product-sidebar',
			'type'      => 'select',
			'compiler'  => true,
			'title'     => __('Archive Product Sidebar', 'delve'),
			'subtitle'  => __('Choose a sidebar that you want to display.', 'delve'),
			'options'   => $sidebar_options,
			'default'   => 'none'
		),
	
	),
);
/******* custom style ******/
$this->sections[] = array(
	'icon'      => 'el-icon-css',
	'title'     => __('Custom Styling', 'delve'),
	'fields'    => array(
	
		array(
			'id'        => 'custom-css',
			'type'      => 'ace_editor',
			'title'     => __('CSS Code', 'delve'),
			'subtitle'  => __('Quickly add some CSS to your site by adding it to this block.', 'delve'),
			'mode'      => 'css',
			'theme'     => 'monokai',
			//'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
			'default'   => ".your-class {\n\tbackground:#FFF;\n}"
		),
		
		array(
			'id'        => 'custom-header-js',
			'type'      => 'ace_editor',
			'title'     => __('JS Code In Header', 'delve'),
			'subtitle'  => __('Paste your JS code here.', 'delve'),
			'mode'      => 'javascript',
			'theme'     => 'chrome',
			//'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
			'default'   => "jQuery(document).ready(function(){\n\n});"
		),

		
		array(
			'id'        => 'custom-footer-js',
			'type'      => 'ace_editor',
			'title'     => __('JS Code In Footer', 'delve'),
			'subtitle'  => __('Paste your JS code here.', 'delve'),
			'mode'      => 'javascript',
			'theme'     => 'chrome',
			//'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
			'default'   => "jQuery(document).ready(function(){\n\n});"
		),
	
	),
);
global $delve_social;
$delve_social = array(	'social-facebook' 		=> 'Facebook',
						'social-twitter'		=> 'Twitter',
						'social-pinterest'		=> 'Pinterest',
						'social-google-plus'	=> 'GooglePlus',
						'social-tumblr'			=> 'Tumblr',
						'social-stumbleupon'	=> 'StumbleUpon',
						'social-instagram'		=> 'Instagram',
						'social-dribbble'		=> 'Dribbble',
						'social-youtube'		=> 'YouTube',
						'social-be'				=> 'Be' );
$delve_social_fields[] = array(
			'id'        => 'switch-social',
			'type'      => 'switch',
			'title'     => __('Social Icons', 'delve'),
			'subtitle'  => __('Specify your social links.(Enter URL starting from http:// or https://)', 'delve'),
			'default'   => 0,
			'on'        => 'Enabled',
			'off'       => 'Disabled',
		);
		
$delve_social_fields[] = array(
    'id'       => 'social-icons-in-new-tab',
    'type'     => 'checkbox',
    'title'    => __('Social Icons in New Tab', 'delve'),    
    'desc'     => __('Check this box if you want to open the social sites in new tab when icon is clicked.','delve'),
);
		
foreach( $delve_social as $key => $value ) {
	$delve_social_fields[] =  
		array(
			'id'        => $key,
			'type'      => 'text',
			'required'  => array('switch-social', "=", 1),
			'title'     => __($value, 'delve'),
			'subtitle'  => __('', 'delve'),
			'desc'      => __('', 'delve'),
		);
}
/******* Social Options ******/          
$this->sections[] = array(
	'title'     => __('Social Icons Settings', 'delve'),
	'icon'      => 'el-icon-myspace',
	'fields'    => $delve_social_fields
);
/******* footer Options ******/          
$this->sections[] = array(
	'title'     => __('Footer Settings', 'delve'),
	'icon'      => 'el-icon-list-alt',
	'fields'    => array(
	
		array(
			'id'        => 'switch-fwidgets',
			'type'      => 'switch',
			'title'     => __('Footer Widgets', 'delve'),
			'subtitle'  => __('Show/Hide footer widget.', 'delve'),
			'default'   => 1,
			'on'        => 'Enabled',
			'off'       => 'Disabled',
		),
		
		array(
			'id'        => 'opt-fcolumn',
			'type'      => 'select',
			'required'  => array('switch-fwidgets', "=", 1),
			'title'     => __('Footer Widgets Columns', 'delve'),
			'subtitle'  => __('Manage number of columns at footer', 'delve'),
			'desc'      => __('', 'delve'),
                        
			'options'   => array(
				'1' => '1', 
				'2' => '2', 
				'3' => '3',
				'4' => '4'
			),
			'default'   => '3'
		),		
	
		array(
			'id'		=> 'footer-widget-font-color',
			'type'		=> 'color',
			'required'  => array('switch-fwidgets', "=", 1),
			'title'		=> __('Footer Widget Font Color', 'delve'),
			'output'	=> array( '.footer-widget', '.footer-widget a' ),
		),
		
		array(
			'id'        => 'switch-fcb',
			'type'      => 'switch',
			'title'     => __('Copyright Bar', 'delve'),
			'subtitle'  => __('Show/Hide copyright bar at footer.', 'delve'),
			'default'   => 1,
			'on'        => 'Enabled',
			'off'       => 'Disabled',
		),		
	
		array(
			'id'		=> 'footer-font-color',
			'type'		=> 'color',
			'required'	=>	array('switch-fcb','=','1'),
			'title'		=> __('Footer Font Color', 'delve'),
			'output'	=> array( '.footer', '.footer a' ),
		),
		
		array(
			'id'		=> 'footer-social-icons-color',
			'type'		=> 'color',
			'title'		=> __('Footer Social Icons Color', 'delve'),
			'output'	=> array( '.footer', '.footer .delve-social li i' ),
		),
		
		array(
			'id'		=> 'footer-link-color',
			'type'		=> 'color',
			'title'		=> __('Footer Link Color', 'delve'),
			'output'	=> array( '.footer-container a' ),
		),
		
		array(
			'id'	=> 'footer-right-side',
			'type'	=> 'select',
			'title'	=> __('Add to Right Side', 'delve'),
			'desc'	=> __('', 'delve'),
                  
			'options'   => array(
				NULL			=> 'None', 
				'social_icons'	=> 'Social Icons',
				'footer_menu'		=> 'Footer Menu'
			),
			'default'   => NULL
		),
		
		array(
			'id'        => 'fcb-txt',
			'type'      => 'textarea',
			'required'  => array('switch-fcb', "=", 1),
			'title'     => __('Copyright Bar Text', 'delve'),
			'subtitle'  => __('HTML Allowed', 'delve'),
			'desc'      => __('', 'delve'),
			'validate'  => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
			'default'   => '&copy to Delve Themes'
		),
		
		array(
			'id'        => 'tracking',
			'type'      => 'textarea',
			'title'     => __('Tracking Code', 'delve'),
			'subtitle'  => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'delve'),
			'validate'  => 'js',
			'desc'      => 'Validate that it\'s javascript!',
		),
	),
);
         
$theme_info  = '<div class="redux-framework-section-desc">';
$theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'delve') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'delve') . $this->theme->get('Author') . '</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'delve') . $this->theme->get('Version') . '</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
$tabs = $this->theme->get('Tags');
	if (!empty($tabs)) {
		$theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'delve') . implode(', ', $tabs) . '</p>';
	}
	
$theme_info .= '</div>';
/*
if (file_exists(dirname(__FILE__) . '/../README.md')) {
	$this->sections['theme_docs'] = array(
		'icon'      => 'el-icon-list-alt',
		'title'     => __('Documentation', 'delve'),
		'fields'    => array(
			array(
				'id'        => '17',
				'type'      => 'raw',
				'markdown'  => true,
				'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
			),
		),
	);
}
*/         
/******* import/export ******/          
$this->sections[] = array(
	'title'     => __('Import / Export', 'delve'),
	'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'delve'),
	'icon'      => 'el-icon-refresh',
	'fields'    => array(
		
		array(
			'id'            => 'opt-import-export',
			'type'          => 'import_export',
			'title'         => 'Import Export',
			'subtitle'      => 'Save and restore your Redux options',
			'full_width'    => false,
		),
	),
);                     
                    
$this->sections[] = array(
	'type' => 'divide',
);
/******* theme information ******/
$this->sections[] = array(
	'icon'      => 'el-icon-info-sign',
	'title'     => __('Theme Information', 'delve'),
	'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'delve'),
	'fields'    => array(
		array(
			'id'        => 'opt-raw-info',
			'type'      => 'raw',
			'content'   => $item_info,
		)
	),
);
/*
if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
	$tabs['docs'] = array(
		'icon'      => 'el-icon-book',
		'title'     => __('Documentation', 'delve'),
		'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
	);
}
*/
}
        public function setHelpTabs() {
            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'delve'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'delve')
            );
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'delve'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'delve')
            );
            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'delve');
        }
        /**
          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'data',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Delve Options', 'delve'),
                'page_title'        => __('Delve Options', 'delve'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true, 
				'ajax_save'         => true,          // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
                // OPTIONAL -> Give you extra features
                'page_priority'     => 61,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => get_template_directory_uri().'/images/dicon.png',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE
                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );
            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            /*$this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );*/
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Delve-Themes/776773272383256',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://twitter.com/delvethemes',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            /*$this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );*/
            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p style="color: green;font-size: 20px;background-color: lemonchiffon;font-weight: bold;">To Purchase Premium Delve Theme <a href="http://free.delvethemes.com/product/delve-theme/">Click here</a> and For Demo <a href="http://free.delvethemes.com/">Click here</a></p>', 'delve') );
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'delve');
            }
            // Add content after the form.
          /*  $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'delve');*/
        }
    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}
/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;
/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation
          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;