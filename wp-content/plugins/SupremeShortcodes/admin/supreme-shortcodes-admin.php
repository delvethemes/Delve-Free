<?php 

global $shortname;
global $SupremeShortcodes__;



// admin options with default values
$SupremeShortcodes__['options'] = array(
	array('load_jquery', 'no'),
	array('load_bootstrap', 'yes'),
	array('load_font_awesome', 'yes'),
	array('load_swiper', 'yes'),
	array('load_animate', 'yes'),
	array('load_mediaelement', 'yes'),
	array('load_flexslider', 'yes'),
	array('load_g_charts', 'yes'),
	array('load_g_maps', 'yes'),
	array('load_pinterest', 'yes'),
	array('load_tumbler', 'yes'),
	array('load_fancybox', 'yes'),
	array('load_svg_drawings', 'yes'),
	array('load_iconmelon', 'yes'),
	array('custom_css', '')
);

$SupremeShortcodes__['checkboxes'] = array(
	'notify',
	'load_jquery',
	'load_bootstrap',
	'load_font_awesome',
	'load_swiper',
	'load_animate',
	'load_mediaelement',
	'load_flexslider',
	'load_g_charts',
	'load_g_maps',
	'load_pinterest',
	'load_tumbler',
	'load_fancybox',
	'load_svg_drawings',
	'load_iconmelon'
);

$colorPickers = array(
	array('ID' => 'SupremeShortcodes__hover_div', 'label' => 'Hover Div', 'default_color' => '#3498db', 'description' => 'Background color for Carousel and Swiper shortcodes.'),
	array('ID' => 'SupremeShortcodes__ol_bg', 'label' => 'Ordered List', 'default_color' => '#3498db', 'description' => 'Background color for styled ordered list shortcode.'),
	array('ID' => 'SupremeShortcodes__primary_button', 'label' => 'Modal button', 'default_color' => '#3498db', 'description' => 'Button used for modal shortcode.'),
	array('ID' => 'SupremeShortcodes__to_top', 'label' => 'To-Top line', 'default_color' => '#ffffff', 'description' => 'Background for to-top shortcode.'),
	array('ID' => 'SupremeShortcodes__toggle_bg', 'label' => 'Toggle heading', 'default_color' => '#3498db', 'description' => 'Background color for icon in toggle and accordion heading shortcode.'),
	array('ID' => 'SupremeShortcodes__audio_rail', 'label' => 'Audio and Video rail', 'default_color' => '#3498db', 'description' => 'Background color for rail track of audio and video shortcodes.'),
	array('ID' => 'SupremeShortcodes__contact_button', 'label' => 'Contact button', 'default_color' => '#3498db', 'description' => 'Background color for submit button in contact form shortcode.'),
	array('ID' => 'SupremeShortcodes__tab_bg', 'label' => 'Tabs Content', 'default_color' => '#ffffff', 'description' => 'Background color for tabs shortcode.'),
	array('ID' => 'SupremeShortcodes__tab_text', 'label' => 'Tabs Text', 'default_color' => '#333333', 'description' => 'Text color for tabs shortcode.'),
);



/* Add admin menu page */
function SupremeShortcodes__register_menu_page(){
	global $shortname;
    add_menu_page( 'SupremeShortcodes', 'Supreme', 'manage_options', $shortname, 'SupremeShortcodes__custom_menu_page', plugins_url( '../images/supremetheme-logo-19x19.png', __FILE__ ), '4.4' ); 
}


function SupremeShortcodes__init_default_options() {
	global $SupremeShortcodes__, $_POST, $shortname;

	if (get_option("SupremeShortcodes__init", "") != "yes") {

		foreach ($SupremeShortcodes__['options'] as $option) {
			if (get_option($option[0], null) == null) {
				update_option('SupremeShortcodes__'.$option[0], $option[1]);
			}
		}
		update_option("SupremeShortcodes__init", "yes");

	} else {

		foreach ($SupremeShortcodes__['options'] as $option) {

			if ( get_option( 'SupremeShortcodes__'.$option[0] ) == false ) {

			    $deprecated = null;
			    $autoload = 'yes';
			    add_option( 'SupremeShortcodes__'.$option[0], $option[1], $deprecated, $autoload );

			}

		}

	}

}

function SupremeShortcodes__custom_menu_page(){
	global $shortname;
	global $post;
	global $SupremeShortcodes__;

	SupremeShortcodes__init_default_options();

    if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.', $shortname ) );
	}

	?>
	<script type="text/javascript">
		var stPluginUrl = "<?php echo plugins_url(); ?>/SupremeShortcodes";
		var restHeading = '<?php echo _e("Please wait while window finishes restoring data.", $shortname); ?>';
		var restText = '<?php echo _e("It shouldn\'t last more than 30 sec.", $shortname); ?>';
		var alertConfirm = '<?php echo _e("Are you sure you want to restore settings? All current settings will be lost.", $shortname); ?>';
		var alertError = '<?php echo _e("There was an error with restoring plugin options! Please try again.", $shortname); ?>';
		var msgSuccess = '<?php echo _e("Settings have been successfully restored!", $shortname); ?>';
	</script>
	<?php

	wp_enqueue_style( 'SupremeShortcodes-admin-css', plugins_url( '/css/admin-style.css', __FILE__ ) );
	wp_enqueue_script( 'SupremeShortcodes-admin-js', plugins_url( '/js/admin-script.js', __FILE__ ) );

	wp_enqueue_script('wp-color-picker');
    wp_enqueue_style( 'wp-color-picker' );

    if(function_exists( 'wp_enqueue_media' )){
	    wp_enqueue_media();
	}

	wp_enqueue_script( 'fancybox-js', plugins_url( '../js/fancybox/source/jquery.fancybox.js', __FILE__ ), array('jquery') );
	wp_enqueue_style( 'fancybox-css', plugins_url( '../js/fancybox/source/jquery.fancybox.css', __FILE__ ) );


	/* Update options */
	if ( (isset($_POST['Submit']) && $_POST['Submit'] == 'Update Options') ) {

		global $SupremeShortcodes__;
		global $colorPickers;

		foreach($colorPickers as $colorPicker) {
			update_option($colorPicker['ID'], esc_html($_POST[$colorPicker['ID']]));
		}

		foreach ($SupremeShortcodes__['options'] as $option) {

			if (in_array($option[0], $SupremeShortcodes__["checkboxes"])) {

				if ( (isset($_POST['SupremeShortcodes'][$option[0]]) && $_POST['SupremeShortcodes'][$option[0]] == "yes") ) {
					update_option('SupremeShortcodes__' . $option[0], "yes"); 
				} else {
					update_option('SupremeShortcodes__' . $option[0], "no"); 
				} 
			} else if(isset($_POST['SupremeShortcodes'][$option[0]])) {
				update_option('SupremeShortcodes__' . $option[0], $_POST['SupremeShortcodes'][$option[0]]); 
			}
		} 
	}

?>

	<div class="supreme_wrap"> 

	    <span id="shortcodes_head">
			<ul id="pre_menu">
				<li class="website"><a href="http://supremewptheme.com/plugins/supreme-shortcodes/" target="_blank"><?php _e('Supreme Shortcodes', $shortname); ?></a></li>
				<li class="docs"><a href="http://supremewptheme.com/docs/supremeshortcodes/" target="_blank"><?php _e('Docs', $shortname); ?></a></li>
				<li class="support"><a href="http://supremewptheme.com/support/" target="_blank"><?php _e('Support', $shortname); ?></a></li>
			</ul>

			<?php echo "<h2>" . __( 'Supreme Shortcodes &#8594; Settings', $shortname ) . "</h2>"; ?> 
			<div class="clear"></div>
		</span>

	    <form name="shortcodes_options" id="shortcodes-form" action="admin.php?page=<?php echo $shortname; ?>" method="post">  
 
	        <ul id="tabs-titles">
			    <li class="current"><?php _e('General Settings', $shortname); ?></li>
			    <li><?php _e('Colors', $shortname); ?></li>
			    <li><?php _e('Custom CSS', $shortname); ?></li>
			    <li><?php _e('Page Snippets', $shortname); ?></li>
			    <li><?php _e('Video Tutorials', $shortname); ?></li>
			    <li><?php _e('Backup/Restore', $shortname); ?></li>
			</ul>
			<ul id="tabs-contents">
			    <li>
			        <div class="content">
			        	<h4><span><?php _e('Welcome', $shortname); ?></span></h4>
			        	<h3><?php _e('Welcome to Supreme Shortcodes Options Panel!', $shortname); ?></h3>
			        	<p><?php _e('This plugin adds 100+ extra functionalities to your website. You can choose from static elements such as: Boxes, Responsive rows and columns, Lines and dividers to animated elements such as: 3D Buttons, Modals and Popovers or Toggles and Tabs. Pretty much anything needed for todays modern web presentation.', $shortname); ?></p>
			        </div>
			        <br>
			        <div class="content">
			        	<h4><span><?php _e('Loading JavaScript and CSS files', $shortname); ?></span></h4>
			        	<div>
				        	<label><?php _e("Load jQuery?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_jquery]" value="yes" <?php echo (get_option('SupremeShortcodes__load_jquery') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already loads jquery, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Bootstrap elements?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_bootstrap]" value="yes" <?php echo (get_option('SupremeShortcodes__load_bootstrap') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Bootstrap v3.2.0, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Font Awesome?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_font_awesome]" value="yes" <?php echo (get_option('SupremeShortcodes__load_font_awesome') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Font Awesome (v4.2.0), there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Swiper?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_swiper]" value="yes" <?php echo (get_option('SupremeShortcodes__load_swiper') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use iDangero Swiper, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Animate.CSS?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_animate]" value="yes" <?php echo (get_option('SupremeShortcodes__load_animate') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Animate.css, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Mediaelements?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_mediaelement]" value="yes" <?php echo (get_option('SupremeShortcodes__load_mediaelement') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Mediaelelements, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Flexslider?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_flexslider]" value="yes" <?php echo (get_option('SupremeShortcodes__load_flexslider') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Flexslider, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Google Charts API?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_g_charts]" value="yes" <?php echo (get_option('SupremeShortcodes__load_g_charts') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Google Charts API, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Google Maps API?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_g_maps]" value="yes" <?php echo (get_option('SupremeShortcodes__load_g_maps') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Google Maps API, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Pinterest?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_pinterest]" value="yes" <?php echo (get_option('SupremeShortcodes__load_pinterest') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Pinterest API, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Tumbler?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_tumbler]" value="yes" <?php echo (get_option('SupremeShortcodes__load_tumbler') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Tumbler API, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load FancyBox?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_fancybox]" value="yes" <?php echo (get_option('SupremeShortcodes__load_fancybox') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use FancyBox, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load SVG Drawings?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_svg_drawings]" value="yes" <?php echo (get_option('SupremeShortcodes__load_svg_drawings') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already loads SVG Drwaings, or you simply don\'t want to use it, there is no need to load it.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Iconmelon?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodes[load_iconmelon]" value="yes" <?php echo (get_option('SupremeShortcodes__load_iconmelon') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already loads Iconmelon, or you simply don\'t want to use it, there is no need to load it.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        </div>
			    </li>
			    <li>
			        <div class="content">
			        	<h4><span><?php _e('Changable Shortcode Colors', $shortname); ?></span></h4>
             			<?php
             				global $colorPickers;

							foreach($colorPickers as $colorPicker):

								$colorOption = get_option($colorPicker['ID']);
								if (empty($colorOption) || $colorOption == ''):
									add_option($colorPicker['ID'], $colorPicker['default_color']);
								endif;
								?>
								<div>
									<label for="<?php echo $colorPicker['ID']; ?>"><?php _e($colorPicker['label']); ?></label>
									<input type="text" id="<?php echo $colorPicker['ID']; ?>" class="colorPicker" value="<?php echo get_option($colorPicker['ID']); ?>" name="<?php echo $colorPicker['ID']; ?>" />
									<div id="<?php echo $colorPicker['ID']; ?>_color"></div>
									<div class="option_description"><small><em><?php _e($colorPicker['description']); ?></em></small></div>
								</div>
								<hr />

						<?php endforeach; ?>
			        </div>
			    </li>
			    <li>
			        <div class="content">
			        	<h4><span><?php _e('Custom CSS', $shortname); ?></span></h4>
             			
             			<code style="font-size:10px; float: left;">Without: &lt;style&nbsp;type='text/css'></code>
						<textarea name="SupremeShortcodes[custom_css]" id="custom_css" cols="55" rows="18" placeholder="#tabs { margin-left: 20px; }"><?php echo stripslashes(get_option('SupremeShortcodes__custom_css', '')) ?></textarea>
			        </div>
			    </li>
			    <li>
			        <div class="content">
			        	<h4><span><?php _e('Pre-built Page Snippets', $shortname); ?></span></h4>
		        		<p><?php _e('We\'ve created all those page snippets to show you that building exceptional pages can be really easy.<br>Use them as a base to start creating your awesome stuff.<br> Copy/Paste desired Page Snippet into your WordPress text editor.', $shortname); ?></p>
		        		<p><?php _e('<strong>NOTE: </strong>It is probably better to paste them with the Text mode turned on, insted of Visual Mode.', $shortname); ?></p>
		        		<br>
		        		<table>
		        			<tbody>
		        				<tr>
		        					<td><strong><?php _e('About Us', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/about-us/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-about-us.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        				<tr>
		        					<td><strong><?php _e('Meet The Team', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/meet-the-team/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-meet-the-team.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        				<tr>
		        					<td><strong><?php _e('We Are Hiring', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/hiring/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-we-are-hiring.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        				<tr>
		        					<td><strong><?php _e('Services Page', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/services-page/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-services-page.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        				<tr>
		        					<td><strong><?php _e('F.A.Q.', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/faq/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-faq.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        				<tr>
		        					<td><strong><?php _e('Process Page', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/process-page/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-process-page.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        				<tr>
		        					<td><strong><?php _e('Pricing Page', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/pricing-page/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-pricing-page.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        				<tr>
		        					<td><strong><?php _e('History Page', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/history-page/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-history-page.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        				<tr>
		        					<td><strong><?php _e('Contact Us', $shortname); ?></strong></td>
		        					<td>&nbsp;</td>
		        					<td><a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/contact-us/" target="_blank"><?php _e('Demo', $shortname); ?></a></td>
		        					<td>|</td>
		        					<td><a href="http://supremewptheme.com/docs/supremeshortcodes/snippets/supreme-theme-page-snippet-contact.txt" target="_blank"><?php _e('Download', $shortname); ?></a></td>
		        				</tr>
		        			</tbody>
		        		</table>
		        		<br>
		        		<p><?php _e('And many more to come.', $shortname); ?> <a href="http://supremewptheme.com/plugins/supreme-shortcodes/page-snippets/" target="_blank"><?php _e('See them all here.', $shortname); ?></a></p>
		        	</div>
			    </li>
			    <li>
			        <div class="content">
			        	<h4><span><?php _e('Tutorials and How-To', $shortname); ?></span></h4>
			        	<p><?php _e('Browse the YouTube playlist. More videos and How-To\'s coming very soon.', $shortname); ?></p>
			        	<div>
					        <iframe width="640" height="360" src="//www.youtube.com/embed/videoseries?list=PLZI9jM76lUximFwTfussCPzDNEQ_PvJEN" frameborder="0" allowfullscreen></iframe>
			        	</div>
			        </div>
			    </li>
			    <li>
			    	<div class="content ss-half first">
						<h4><?php _e('Backup your settings', $shortname); ?></h4>
			    		<p><?php _e('The backup .txt file will be downloaded to your computer, so feel free to make as many backups as you wish.', $shortname); ?></p>
						<?php SupremeShortcodes__create_export_download_link(true); ?>
						<br>
			    	</div>
			    	<div class="content ss-half">
						<h4><?php _e('Restore your settings', $shortname); ?></h4>
						<p><?php echo _e('Upload the .txt file you would like to restore.', $shortname); ?></p>
						<div class="inputs">
							<input type="text" name="SupremeShortcodes[restore_file]" class="super_small imageField" id="restore_file" size="38"/> 
							<input type="button" class="button ss_media_upload upload_file" value="<?php _e('Upload file', $shortname); ?>" name="browse" />
							<input type="submit" class="button-primary restore" value="<?php _e('Restore', $shortname); ?>" name="Submit" style="display:none;margin-right:10px;" />
						</div>
			    	</div>
			    </li>
			</ul>

			<div class="clear"></div>
	      
	        <p class="submit">  
	        	<input class="button button-primary alignright" type="submit" name="Submit" value="<?php _e('Update Options', $shortname ) ?>" />  
	        </p> 
	        <div class="clear"></div>
	        <br>

	    </form> 


	</div><!-- .supreme_wrap -->


<?php
}

add_action('admin_menu', 'SupremeShortcodes__register_menu_page');
add_action('after_setup_theme', 'SupremeShortcodes__init_default_options');	

?>