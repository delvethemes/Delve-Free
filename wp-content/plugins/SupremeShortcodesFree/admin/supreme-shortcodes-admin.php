<?php 

global $shortname;
global $SupremeShortcodesFree__;



// admin options with default values
	$SupremeShortcodesFree__['options'] = array(
		array('load_jquery', 'no'),
		array('load_mediaelement', 'yes')
	);

	$SupremeShortcodesFree__['checkboxes'] = array(
		'notify',
		'load_jquery',
		'load_mediaelement'
	);



/* Add admin menu page */
add_action( 'admin_menu', 'SupremeShortcodesFree__register_menu_page' );
function SupremeShortcodesFree__register_menu_page(){
	global $shortname;
    add_menu_page( 'SupremeShortcodes', 'Supreme', 'manage_options', $shortname, 'SupremeShortcodesFree__custom_menu_page', plugins_url( '../images/supremetheme-logo-19x19.png', __FILE__ ), '4.5' ); 
}


function SupremeShortcodesFree__init_default_options() {
	global $SupremeShortcodesFree__, $_POST, $shortname;


	if (get_option("SupremeShortcodesFree__init", "") != "yes") {

		foreach ($SupremeShortcodesFree__['options'] as $option) {
			if (get_option($option[0], null) == null) {
				update_option('SupremeShortcodesFree__'.$option[0], $option[1]);
			}
		}
		update_option("SupremeShortcodesFree__init", "yes");

	} else {

		foreach ($SupremeShortcodesFree__['options'] as $option) {

			if ( get_option( 'SupremeShortcodesFree__'.$option[0] ) == false ) {

			    $deprecated = null;
			    $autoload = 'yes';
			    add_option( 'SupremeShortcodesFree__'.$option[0], $option[1], $deprecated, $autoload );

			}

		}

	}

}

function SupremeShortcodesFree__custom_menu_page(){
	global $shortname;
	global $post;
	global $SupremeShortcodesFree__;

	SupremeShortcodesFree__init_default_options();

    if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	wp_enqueue_style( 'SupremeShortcodesFree-admin-css', plugins_url( '/css/admin-style.css', __FILE__ ) );
	wp_enqueue_script( 'SupremeShortcodesFree-admin-js', plugins_url( '/js/admin-script.js', __FILE__ ) );


	/* Update options */
	if ( (isset($_POST['Submit']) && $_POST['Submit'] == 'Update Options') ) {

		global $SupremeShortcodesFree__;

		foreach ($SupremeShortcodesFree__['options'] as $option) {

			if (in_array($option[0], $SupremeShortcodesFree__["checkboxes"])) {

				if ( (isset($_POST['SupremeShortcodesFree'][$option[0]]) && $_POST['SupremeShortcodesFree'][$option[0]] == "yes") ) {
					update_option('SupremeShortcodesFree__' . $option[0], "yes"); 
				} else {
					update_option('SupremeShortcodesFree__' . $option[0], "no"); 
				} 
			} else if(isset($_POST['SupremeShortcodesFree'][$option[0]])) {
				update_option('SupremeShortcodesFree__' . $option[0], $_POST['SupremeShortcodesFree'][$option[0]]); 
			}
		} 
	}

?>

	<div class="supreme_wrap"> 

	    <span id="shortcodes_head">
			<ul id="pre_menu">
				<li class="website"><a href="http://supremewptheme.com/plugins/supreme-shortcodes/" target="_blank"><?php _e('Supreme Shortcodes', $shortname); ?></a></li>
				<li class="docs"><a href="http://supremewptheme.com/docs/supremeshortcodes/" target="_blank"><?php _e('Docs', $shortname); ?></a></li>
				<li class="support"><a href="http://supremewptheme.com/supreme-support/" target="_blank"><?php _e('Support', $shortname); ?></a></li>
				<li class="go-pro"><a href="http://codecanyon.net/item/supreme-shortcodes-wordpress-plugin/6340769?ref=supremefactory&license=regular&open_purchase_for_item_id=6340769&purchasable=source" target="_blank"><?php _e('GO PRO', $shortname); ?></a></li>
			</ul>

			<?php echo "<h2>" . __( 'Supreme Shortcodes FREE &#8594; Settings', $shortname ) . "</h2>"; ?> 
			<div class="clear"></div>
		</span>

	    <form name="shortcodes_options" id="shortcodes-form" action="admin.php?page=<?php echo $shortname; ?>" method="post">  
 
	        <ul id="tabs-titles">
			    <li class="current"><?php _e('General Settings', $shortname); ?></li>
			    <li><?php _e('Colors', $shortname); ?></li>
			    <li><?php _e('Custom CSS', $shortname); ?></li>
			    <li><?php _e('Page Snippets', $shortname); ?></li>
			    <li><?php _e('Video Tutorials', $shortname); ?></li>
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
			        	<h4><span><?php _e('Twitter Bootstrap', $shortname); ?></span></h4>
			        	<div>
				        	<label><?php _e("Load jQuery?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodesFree[load_jquery]" value="yes" <?php echo (get_option('SupremeShortcodesFree__load_jquery') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already loads jquery, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Load Mediaelements?", $shortname ); ?> </label>
					        <input type="checkbox" name="SupremeShortcodesFree[load_mediaelement]" value="yes" <?php echo (get_option('SupremeShortcodesFree__load_mediaelement') == 'yes') ? ' checked="checked"' : ''; ?> /></p>  
					        <div class="option_description"><small><em><?php _e('If your theme already use Mediaelelements, there is no need to load it twice.', $shortname); ?></em></small></div>
					        <div class="clear"></div>
			        	</div>
			        	<div>
				        	<label><?php _e("Unlock more options?", $shortname ); ?> </label>
					        <div class="option_description"><small><em><a href="http://codecanyon.net/item/supreme-shortcodes-wordpress-plugin/6340769?ref=supremefactory&license=regular&open_purchase_for_item_id=6340769&purchasable=source"><?php _e('Upgrade to PRO', $shortname); ?></a></em></small></div>
					        <div class="clear"></div>
			        	</div>

			        </div>
			    </li>
			    <li>
			        <div class="content">
			        	<h4><span><?php _e('Changable Shortcode Colors', $shortname); ?></span></h4>
			        	<p><?php _e('We understand the need of the ability to choose any color for your website to match your Business Setup and your style.', $shortname); ?></p>
						<p><?php _e('We\'ve included an Option to choose unlimited colors for various shortcodes straight from admin options panel. Change them any time. It is important that our plugin follows your website look and feel.', $shortname); ?></p>
             			<p><?php _e('Please upgrade to <a href="http://codecanyon.net/item/supreme-shortcodes-wordpress-plugin/6340769?ref=supremefactory&license=regular&open_purchase_for_item_id=6340769&purchasable=source">PRO</a> to reveal this feature.', $shortname); ?></p>
			        </div>
			    </li>
			    <li>
			        <div class="content">
			        	<h4><span><?php _e('Custom CSS', $shortname); ?></span></h4>
			        	<p><?php _e('Sometimes it\'s necessary to make small amendments or you need a quick fix for various elements. No problem. We can offer you an option in our admin panel where you can enter your own CSS rules.', $shortname); ?></p>
			        	<p><?php _e('This also benefits if you wish to change your theme style, but would rather skip digging into code.', $shortname); ?></p>
			        	<p><?php _e('Please upgrade to <a href="http://codecanyon.net/item/supreme-shortcodes-wordpress-plugin/6340769?ref=supremefactory&license=regular&open_purchase_for_item_id=6340769&purchasable=source">PRO</a> to reveal this feature.', $shortname); ?></p>
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



?>