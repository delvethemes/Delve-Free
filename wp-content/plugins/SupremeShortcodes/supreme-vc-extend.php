<?php

global $shortname;
global $supreme_vc_map;

// don't load directly
if (!defined('ABSPATH')) die('-1');


/* Load admin plugin css and javascript files */
add_action('admin_enqueue_scripts', 'SupremeShortcodes__admin_extend_js_css');
function SupremeShortcodes__admin_extend_js_css() {

	wp_enqueue_style( 'ss-extend-admin', plugins_url('/css/vc_st_extend_admin.css', __FILE__) );
	wp_enqueue_style('ss-font-awesome', plugins_url( '/css/font-awesome.min.css' , __FILE__ ));

}


/* LIGHT */

add_action('wp_ajax_nopriv_ss_contact_form_light', 'SupremeShortcodes__contact_form_l');
add_action('wp_ajax_ss_contact_form_light', 'SupremeShortcodes__contact_form_l');
function SupremeShortcodes__contact_form_l(){

	global $shortname, $post;

    $sitename = get_bloginfo('name');
    $siteurl  = home_url();
    $to      = isset($_POST['to']) ? trim($_POST['to']) : '';
    $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    
    $error = false;
    if ($to === '' || $email === '' || $content === '' || $name === '') {
          $error = true;
    }
    if (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email)) {
          $error = true;
    }
    if (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $to)) {
          $error = true;
    }
    
    if ($error == false) {
          $subject = sprintf(__('%1$s\'s message from %2$s', $shortname), $sitename, $name);
          $body    = __('Site: ', $shortname) . $sitename . ' (' . $siteurl . ')' . "\n\n";
          $body .= __('Name: ', $shortname) . $name . "\n\n";
          $body .= __('Email: ', $shortname) . $email . "\n\n";
          $body .= __('Messages: ', $shortname) . $content;
          $headers = "From: $name <$email>\r\n";
          $headers .= "Reply-To: $email\r\n";
          
          if (wp_mail($to, $subject, $body, $headers)) {
                echo 'Message sent successfully';
          } else {
                echo 'Message Could not be sent';
          }
          die();
    }
}

if ( !function_exists( 'SupremeShortcodes__contact_helper_light' ) ) {
	function SupremeShortcodes__contact_helper_light() {
		global $post;
		$post_id = $post->ID;

		$output = '';

		$output .= '<div class="quick-button-container">
						<a href="#" class="ss-quick-contact-link"><i class="ss-li-mail"></i></a>
					</div>';
		$output .= '<div class="ss-quick-contact-overlay test-skin">';
		$output .= '	<a href="#" class="ss-quick-contact-close"><i class="ss-icon-times"></i></a>';
		$output .= '	<div class="ss-quick-contact-wrapper">';
		$output .= '		<div class="ss-quick-contact-inset">';
		$output .= 			do_shortcode( '[st_contact_form_light email="'.get_option('admin_email').'"]' );
		$output .= '		</div>';
		$output .= '	</div>'; 
		$output .= '</div>';
		
		return $output;
	}
}

add_action( 'ss_contact_light', 'SupremeShortcodes__contact_helper_light' );
//do_action( 'ss_contact_light');

/* DARK */

add_action('wp_ajax_nopriv_ss_contact_form_dark', 'SupremeShortcodes__contact_form_d');
add_action('wp_ajax_ss_contact_form_dark', 'SupremeShortcodes__contact_form_d');
function SupremeShortcodes__contact_form_d(){

	global $shortname, $post;

    $sitename = get_bloginfo('name');
    $siteurl  = home_url();
    $to      = isset($_POST['to']) ? trim($_POST['to']) : '';
    $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    
    $error = false;
    if ($to === '' || $email === '' || $content === '' || $name === '') {
          $error = true;
    }
    if (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email)) {
          $error = true;
    }
    if (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $to)) {
          $error = true;
    }
    
    if ($error == false) {
          $subject = sprintf(__('%1$s\'s message from %2$s', $shortname), $sitename, $name);
          $body    = __('Site: ', $shortname) . $sitename . ' (' . $siteurl . ')' . "\n\n";
          $body .= __('Name: ', $shortname) . $name . "\n\n";
          $body .= __('Email: ', $shortname) . $email . "\n\n";
          $body .= __('Messages: ', $shortname) . $content;
          $headers = "From: $name <$email>\r\n";
          $headers .= "Reply-To: $email\r\n";
          
          if (wp_mail($to, $subject, $body, $headers)) {
                echo 'Message sent successfully';
          } else {
                echo 'Message Could not be sent';
          }
          die();
    }
}

if ( !function_exists( 'SupremeShortcodes__contact_helper_dark' ) ) {
	function SupremeShortcodes__contact_helper_dark() {
		global $post;
		$post_id = $post->ID;

		$output = '';

		$output .= '<div class="quick-button-container">
						<a href="#" class="ss-quick-contact-link"><i class="ss-li-mail"></i></a>
					</div>';
		$output .= '<div class="ss-quick-contact-overlay test-skin">';
		$output .= '	<a href="#" class="ss-quick-contact-close"><i class="ss-icon-times"></i></a>';
		$output .= '	<div class="ss-quick-contact-wrapper">';
		$output .= '		<div class="ss-quick-contact-inset">';
		$output .= 			do_shortcode( '[st_contact_form_dark email="'.get_option('admin_email').'"' );
		$output .= '		</div>';
		$output .= '	</div>'; 
		$output .= '</div>';
		
		return $output;
	}
}


add_action( 'ss_contact_dark', 'SupremeShortcodes__contact_helper_dark' );
//do_action( 'ss_contact_dark');


/*---------------------------------
		SUPREME PARAMS 
---------------------------------*/

/* EXTEND ROW */
if (function_exists('vc_add_param')) {
	vc_add_param("vc_row", array(
		'type' => 'checkbox',
		'heading' => __( 'Wrap this row in a container?', $shortname ),
		'param_name' => 'row_container',
		'description' => __( 'Supreme Shortcodes: If selected, it wraps a row in a container. Usefull for narrowing content in 100% width pages.', $shortname ),
		'value' => array( __( 'Yes, please', $shortname ) => 'yes' )
	));
}

add_filter('SupremeShortcodes__row_container_before_filter', 'SupremeShortcodes__row_container_before', 10, 2);
add_filter('SupremeShortcodes__row_container_after_filter', 'SupremeShortcodes__row_container_after', 10, 2);
	
// Before row
function SupremeShortcodes__row_container_before($output, $atts, $content='') {
	ob_start();
	extract(shortcode_atts( array(
		'row_container' => ''
	), $atts));
	
	$output = "";

	if ($row_container == 'yes') {
		$output .= '<!-- BEFORE -->';
		$output .= '<div class="vc_container container">';
	}

	echo $output;

	$ssbeforevariable = ob_get_clean();
	return $ssbeforevariable;
}

// After row
function SupremeShortcodes__row_container_after($output, $atts, $content='') {
	ob_start();
	extract(shortcode_atts( array(
		'row_container' => ''
	), $atts));
	
	$output = "";

	if ($row_container == 'yes') {
		$output .= '</div>';
		$output .= '<!-- AFTER -->';
	}

	echo $output;

	$ssaftervariable = ob_get_clean();
	return $ssaftervariable;
}

if (!function_exists('vc_theme_before_vc_row')){
	function vc_theme_before_vc_row($atts, $content = null) {
		return apply_filters( 'SupremeShortcodes__row_container_before_filter', '', $atts, $content );
	}
}
if ( !function_exists( 'vc_theme_after_vc_row' ) ) {
	function vc_theme_after_vc_row($atts, $content = null) {
		return apply_filters( 'SupremeShortcodes__row_container_after_filter', '', $atts, $content );
	}
}

/* EXTEND INNER ROW */
if (function_exists('vc_add_param')) {
	vc_add_param("vc_row_inner", array(
		'type' => 'checkbox',
		'heading' => __( 'Wrap this row in a container?', $shortname ),
		'param_name' => 'row_container_inner',
		'description' => __( 'Supreme Shortcodes: If selected, it wraps a row in a container. Usefull for narrowing content in 100% width pages.', $shortname ),
		'value' => array( __( 'Yes, please', $shortname ) => 'yes' )
	));
}

add_filter('SupremeShortcodes__row_container_before_inner_filter', 'SupremeShortcodes__row_container_before_inner', 10, 2);
add_filter('SupremeShortcodes__row_container_after_inner_filter', 'SupremeShortcodes__row_container_after_inner', 10, 2);
	
// Before row
function SupremeShortcodes__row_container_before_inner($output, $atts, $content='') {
	ob_start();
	extract(shortcode_atts( array(
		'row_container_inner' => ''
	), $atts));
	
	$output = "";

	if ($row_container_inner == 'yes') {
		$output .= '<!-- BEFORE -->';
		$output .= '<div class="vc_container_inner container">';
	}

	echo $output;

	$ssbeforevariable_inner = ob_get_clean();
	return $ssbeforevariable_inner;
}

// After row
function SupremeShortcodes__row_container_after_inner($output, $atts, $content='') {
	ob_start();
	extract(shortcode_atts( array(
		'row_container_inner' => ''
	), $atts));
	
	$output = "";

	if ($row_container_inner == 'yes') {
		$output .= '</div>';
		$output .= '<!-- AFTER -->';
	}

	echo $output;

	$ssaftervariable_inner = ob_get_clean();
	return $ssaftervariable_inner;
}

if (!function_exists('vc_theme_before_vc_row_inner')){
	function vc_theme_before_vc_row_inner($atts, $content = null) {
		return apply_filters( 'SupremeShortcodes__row_container_before_inner_filter', '', $atts, $content );
	}
}
if ( !function_exists( 'vc_theme_after_vc_row_inner' ) ) {
	function vc_theme_after_vc_row_inner($atts, $content = null) {
		return apply_filters( 'SupremeShortcodes__row_container_after_inner_filter', '', $atts, $content );
	}
}



/* LIST PAGES */
function SupremeShortcodes__pages($settings, $value) {

	$dependency = vc_generate_dependencies_attributes($settings);
	$ipages = get_pages(array('sort_order' => 'ASC'));

	$output = '';

    $output .= '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" ' . $dependency . '>';
		foreach($ipages as $ipage):
			$output .= '<option value="'.get_permalink($ipage->ID).'">'.$ipage->post_title.'</option>';
		endforeach;
	$output .= '</select>';

	return $output;

}
add_shortcode_param('supreme_pages', 'SupremeShortcodes__pages');


/* CHOOSE FONT AWESOME ICONS */
function SupremeShortcodes__icon_fields($settings, $value){
	$dependency = vc_generate_dependencies_attributes($settings);
	$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
	$class = isset($settings['class']) ? $settings['class'] : '';
	$icons = array('none', 'adjust', 'adn', 'align-center', 'align-justify', 'align-left', 'align-right', 'ambulance', 'anchor', 'android', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'apple', 'archive', 'arrow-circle-down', 'arrow-circle-left', 'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right', 'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'arrows', 'arrows-alt', 'arrows-h', 'arrows-v', 'asterisk', 'backward', 'ban', 'bar-chart-o', 'barcode', 'bars', 'beer', 'bell', 'bell-o', 'bitbucket', 'bitbucket-square', 'bitcoin', 'bold', 'bolt', 'book', 'bookmark', 'bookmark-o', 'briefcase', 'btc', 'bug', 'building-o', 'bullhorn', 'bullseye', 'calendar', 'calendar-o', 'camera', 'camera-retro', 'caret-down', 'caret-left', 'caret-right', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'caret-up', 'certificate', 'chain', 'chain-broken', 'check', 'check-circle', 'check-circle-o', 'check-square', 'check-square-o', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'circle', 'circle-o', 'clipboard', 'clock-o', 'cloud', 'cloud-download', 'cloud-upload', 'cny', 'code', 'code-fork', 'coffee', 'cog', 'cogs', 'columns', 'comment', 'comment-o', 'comments', 'comments-o', 'compass', 'compress', 'copy', 'credit-card', 'crop', 'crosshairs', 'css3', 'cut', 'cutlery', 'dashboard', 'dedent', 'desktop', 'dollar', 'dot-circle-o', 'download', 'dribbble', 'dropbox', 'edit', 'eject', 'ellipsis-h', 'ellipsis-v', 'envelope', 'envelope-o', 'eraser', 'eur', 'euro', 'exchange', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'expand', 'external-link', 'external-link-square', 'eye', 'eye-slash', 'facebook', 'facebook-square', 'fast-backward', 'fast-forward', 'female', 'fighter-jet', 'file', 'file-o', 'file-text', 'file-text-o', 'files-o', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash', 'flask', 'flickr', 'floppy-o', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'font', 'forward', 'foursquare', 'frown-o', 'gamepad', 'gavel', 'gbp', 'gear', 'gears', 'gift', 'github', 'github-alt', 'github-square', 'gittip', 'glass', 'globe', 'google-plus', 'google-plus-square', 'group', 'h-square', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hdd-o', 'headphones', 'heart', 'heart-o', 'home', 'hospital-o', 'html5', 'inbox', 'indent', 'info', 'info-circle', 'inr', 'instagram', 'italic', 'jpy', 'key', 'keyboard-o', 'krw', 'laptop', 'leaf', 'legal', 'lemon-o', 'level-down', 'level-up', 'lightbulb-o', 'link', 'linkedin', 'linkedin-square', 'linux', 'list', 'list-alt', 'list-ol', 'list-ul', 'location-arrow', 'lock', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'magic', 'magnet', 'mail-forward', 'mail-reply', 'mail-reply-all', 'male', 'map-marker', 'maxcdn', 'medkit', 'meh-o', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mobile', 'mobile-phone', 'money', 'moon-o', 'music', 'none', 'outdent', 'pagelines', 'paperclip', 'paste', 'pause', 'pencil', 'pencil-square', 'pencil-square-o', 'phone', 'phone-square', 'picture-o', 'pinterest', 'pinterest-square', 'plane', 'play', 'play-circle', 'play-circle-o', 'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'power-off', 'print', 'puzzle-piece', 'qrcode', 'question', 'question-circle', 'quote-left', 'quote-right', 'random', 'refresh', 'renren', 'repeat', 'reply', 'reply-all', 'retweet', 'rmb', 'road', 'rocket', 'rotate-left', 'rotate-right', 'rouble', 'rss', 'rss-square', 'rub', 'ruble', 'rupee', 'save', 'scissors', 'search', 'search-minus', 'search-plus', 'share', 'share-square', 'share-square-o', 'shield', 'shopping-cart', 'sign-in', 'sign-out', 'signal', 'sitemap', 'skype', 'smile-o', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-up', 'spinner', 'square', 'square-o', 'stack-exchange', 'stack-overflow', 'star', 'star-half', 'star-half-empty', 'star-half-full', 'star-half-o', 'star-o', 'step-backward', 'step-forward', 'stethoscope', 'stop', 'strikethrough', 'subscript', 'suitcase', 'sun-o', 'superscript', 'table', 'tablet', 'tachometer', 'tag', 'tags', 'tasks', 'terminal', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'ticket', 'times', 'times-circle', 'times-circle-o', 'tint', 'toggle-down', 'toggle-left', 'toggle-right', 'toggle-up', 'trash-o', 'trello', 'trophy', 'truck', 'try', 'tumblr', 'tumblr-square', 'turkish-lira', 'twitter', 'twitter-square', 'umbrella', 'underline', 'undo', 'unlink', 'unlock', 'unlock-alt', 'unsorted', 'upload', 'usd', 'user', 'user-md', 'users', 'video-camera', 'vimeo-square', 'vk', 'volume-down', 'volume-off', 'volume-up', 'warning', 'weibo', 'wheelchair', 'windows', 'won', 'wrench', 'xing', 'xing-square', 'youtube', 'youtube-play', 'youtube-square', 'angellist', 'area-chart', 'at', 'bell-slash', 'bell-slash-o', 'bicycle', 'binoculars', 'birthday-cake', 'bus', 'calculator', 'cc', 'cc-amex', 'cc-discover', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'copyright', 'eyedropper', 'futbol-o', 'google-wallet', 'ils', 'ioxhost', 'lastfm', 'lastfm-square', 'line-chart', 'meanpath', 'newspaper-o', 'paint-brush', 'paypal', 'pie-chart', 'plug', 'ils', 'slideshare', 'futbol-o', 'toggle-off', 'toggle-on', 'trash', 'tty', 'twitch', 'wifi', 'yelp', 'spotify');

	$output .= '<input type="hidden" name="'.$param_name.'" class="wpb_vc_param_value '.$param_name.' '.$type.' '.$class.'" value="'.$value.'" id="ss-trace"/>';
	$output .= '<div class="ss-icon-preview"><i class=" fa fa-'.$value.'"></i></div>';
	$output .= '<input class="ss-search" type="text" placeholder="Search icon" />';
	$output .= '<div id="ss-icon-dropdown" >';
	$output .= '<ul class="ss-icon-list">';
	$n = 1;
	foreach($icons as $icon){
		$selected = ($icon == $value) ? 'class="selected"' : '';
		$id = 'icon-'.$n;
		$output .= '<li '.$selected.' data-icon="'.$icon.'"><i class="icon fa fa-'.$icon.'"></i><label class="icon">'.$icon.'</label></li>';
		$n++;
	}
	$output .='</ul>';
	$output .='</div>';
	$output .= '<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(".ss-search").keyup(function(){
					var filter = jQuery(this).val(), count = 0;
					jQuery(".ss-icon-list li").each(function(){
						if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
							jQuery(this).fadeOut();
						} else {
							jQuery(this).show();
							count++;
						}
					});
				});
			});

			jQuery("#ss-icon-dropdown li").click(function() {
				jQuery(this).attr("class","selected").siblings().removeAttr("class");
				var icon = jQuery(this).attr("data-icon");
				jQuery("#ss-trace").val(icon);
				jQuery(".ss-icon-preview").html("<i class=\'icon fa fa-"+icon+"\'></i>");
			});
	</script>';
	return $output;
}
add_shortcode_param('supreme_choose_icons', 'SupremeShortcodes__icon_fields');


/* CHOOSE MELON ICONS */
function SupremeShortcodes__icon_melon_fields($settings, $value){
	$dependency = vc_generate_dependencies_attributes($settings);
	$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
	$type = isset($settings['type']) ? $settings['type'] : '';
	$class = isset($settings['class']) ? $settings['class'] : '';
	$icons = array('arrow-target', 'barbeque-eat-food', 'barista-coffee-espresso', 'bag-shopping', 'armchair-chair', 'book-download', 'bomb-bug', 'brush-paint', 'backpack-trekking', 'browser-window', 'book-read', 'caddle-shop-shopping', 'caddle-shopping', 'bubble-love-talk', 'bubble-comment', 'camera-photo-polaroid', 'camera-photo', 'camera-video', 'chef-food-restaurant', 'chaplin-hat-movie', 'coffee', 'cocktail-mojito', 'clock-time', 'computer-macintosh-vintage', 'computer-imac', 'computer', 'computer-imac1', 'cook-pan-pot', 'crop', 'crown-king', 'computer-network', 'dashboard-speed', 'danger-death-delete-destroy-sull', 'design-graphic-tablet', 'design-pencil-rule', 'database', 'delete-garbage', 'drug-medecine-syringue', 'diving-leisure-sea-sport', 'earth-globe', 'eat-food-hotdog', 'eat-food-fork-knife', 'edit-modify', 'factory-lift-warehouse', 'envelope-mail', 'eye-dropper', 'email-mail', 'first-aid-medecine-shield', 'food-ice-cream', 'frame-picture', 'handle-vector', 'grid-lines', 'happy-smiley', 'ink-pen', 'headset-sound', 'home-house', 'ibook-laptop', 'ipad', 'iphone', 'ipod-mini-music', 'ipod', 'japan-tea', 'ipod-music', 'laptop-macbook', 'like-love', 'link', 'macintosh', 'lock-locker', 'locker-unlock', 'map-user', 'micro-record', 'magic-magic-wand', 'man-people-user', 'map-pin', 'monocle-mustache', 'music-speaker', 'paint-bucket', 'music-note', 'notebook', 'painting-pallet', 'pen-feather', 'painting-roll', 'pen', 'pen-big-feather', 'receipt-shopping', 'magnet', 'remote-control', 'picture-stock', 'picture', 'settings-toolkit', 'shoes-snickers-keds', 'settings-adjustments', 'speech-talk-user', 'suitcase-travel', 'synk-refresh-rotate', 'umbrella-weather', 'stamp', 'stock', 'settings-gear', 'friends', 'main-logo', 'sprout', 'sun', 'git', 'invest', 'almost-full-battery', 'archive', 'arrow-both-sides', 'brush', 'arrow-left-1', 'arrow-left-2', 'arrow-right-1', 'bag', 'arrow-right-2', 'bulb', 'cart', 'calendar', 'calculator', 'cinema-camera', 'cassette', 'check', 'cloud-rain', 'cloud-ray', 'close', 'clip', 'cloud-sun', 'diamond', 'crown', 'cloud', 'compact-disc', 'compass', 'download', 'expand', 'dollar', 'empty-battery', 'eye', 'flag', 'flame', 'full-battery', 'folder', 'globe', 'full-screen', 'heart', 'headphones', 'home', 'images', 'inbox', 'label', 'leaf', 'link-2', 'link-1', 'mail-1', 'load', 'mail-2', 'low-charged-battery', 'map', 'magnifying-glass', 'megaphone', 'mute-speaker', 'newspaper', 'menu', 'microphone', 'mid-charged-battery', 'music-note', 'node', 'padlock-open', 'padlock', 'paper-glass', 'paper', 'pencil', 'prize', 'phone-1', 'photo-camera', 'phone-2', 'picture', 'pointer', 'scissors', 'ray', 'reload', 'ribbon', 'setup', 'snow', 'shape76', 'speaker', 'stamp', 'statics', 'speech-balloon', 'speech-balloon-empty', 'speech-balloon-dialogue', 'star', 'tools', 'sun', 't-shirt', 'target', 'umbrella', 'trash-can', 'video-camera', 'user', 'wallet', 'watch', 'wifi', 'repeat', 'target', 'arrow-right', 'arrow-right1', 'ghost', 'twitter', 'facebook', 'search', 'infinity', 'book', 'music-note1', 'image', 'twitter-chicken', 'document', 'todo-list', 'bubble-speech', 'link1', 'tag', 'connect', 'skull', 'message', 'calendar', 'tag1', 'folder', 'heart', 'clock', 'star', 'ribbon', 'video', 'sound', 'photo', 'home', 'ebay', 'b', 'google-plus', 'windows', 'soundcloud', 'skype', 'android', 'vimeo', 'paypal', 'linkedin', 'deviantart', 'pinterest', 'instagram', 'flickr', 'google-drive', 'dropbox', 'dribbble', 'behance', 'tumblr', 'wordpress', 'youtube', 'youtube-2', 'facebook1', 'twitter1', 'ebay1', 'b1', 'soundcloud1', 'windows1', 'vimeo1', 'google-plus1', 'android1', 'skype1', 'paypal1', 'linkedin1', 'devianart', 'pinterest1', 'instagram1', 'flickr1', 'google-drive1', 'behance1', 'dribbble1', 'dropbox1', 'tumblr1', 'wordpress1', 'youtube1', 'youtube2', 'facebook2', 'twitter2', 'alcohol', 'anchor-3', 'anchor-2', 'buoy-2', 'buoy', 'anchor', 'directions', 'flag', 'flag-2', 'knot-2', 'knot', 'eye-patch', 'paper-boat', 'lighthouse', 'oars', 'sail-boat', 'pegleg', 'pirate-hook', 'shark-fin', 'skull-and-crossbones', 'ship-wheel', 'skull1', 'sunrise', 'water', 'treasure-map', 'amsterdam', 'austin', 'cape-town', 'dublin', 'berlin', 'paris', 'san-francisco', 'london', 'stockholm', 'sydney', 'tokyo', 'barcelona', 'wellington', 'new-york', 'clip', 'tablet', 'pc', 'unlock', 'smartphone', 'gear', 'lock', 'lifebuoy', 'tag2', 'calendar1', 'rss', 'upload', 'folder1', 'open-folder-', 'window', 'users', 'eye', 'download', 'phone', 'joystick', 'photo1', 'user', 'load', 'cloud', 'menu1', 'home1', 'info', 'question', 'alert', 'align-left', 'align-right', 'grid', 'align-center', 'align-left-2', 'list', 'grid-2', 'trash', 'stock-graph', 'pie', 'like', 'signal', 'star1', 'heart1', 'message1', 'printer', 'edit', 'bubble-speech1', 'dialog', 'document1', 'text-document', 'move', 'search1', 'close', 'minus', 'map', 'plus', 'check', 'geotag', 'direction', 'arrows', 'arrow-left', 'arrow-right2', 'reply', 'share', 'forward', 'arrow-right-2', 'arrow-left-2', 'share-2', 'rotate', 'repeat-one', 'repeat-all', 'return', 'shuffle', 'music', 'mute', 'microphone', 'loud', 'headphones', 'pause', 'record', 'previous', 'next', 'stop', 'play', 'lamp', 'lamp-2', 'chair', 'chair-2', 'chair-3', 'chair-4', 'chair-5', 'armchair-3', 'armchair', 'armchair-2', 'lounge-chair', 'lounge-chair-2', 'lamp-3', 'table', 'table-2', 'table-3', 'table-4', 'day-bed', 'lamp-4', 'table-5', 'sofa', 'table-6', 'sofa-2', 'lamp-5', 'table-7', 'anchor1', 'diamond', 'heart2', 'needle', 'dagger', 'power-supply', 'swallow', 'mexican-skull', 'mode', 'eye1', 'dropdown', 'folder2', 'gramophone', 'library', 'pen1', 'playlist', 'repeat1', 'rewind', 'shuffle1', 'user1', 'add-card', 'add-document', 'additional-services-card', 'add-user', 'air', 'all-atm', 'analytics', 'archive-cards', 'arrow-bottom', 'arrow-left1', 'arrow-top', 'arrow-right3', 'attach-card', 'billings', 'atm', 'attach-file', 'barcode', 'basket', 'branch-bank', 'callback', 'calendar-day', 'card-details', 'calendar-month', 'cards', 'communications', 'close-1', 'close-2', 'compass', 'cvv2', 'conversion', 'copy', 'dashboard', 'delivery', 'document-csv', 'document-pdf', 'document-html', 'document-txt', 'education-1', 'edit1', 'dollar', 'download1', 'dustbin', 'education-2', 'environment', 'entertainment', 'electronic-money', 'euro', 'exit', 'external-translation', 'eye-open', 'eye-closed', 'facebook3', 'favorites-off', 'favorites-on', 'file', 'financial-services', 'filling', 'forgot-your-password', 'forward-letter', 'foursquare', 'handset', 'history-operations', 'hotels', 'internet', 'housing', 'info1', 'latest-payments', 'jewelry', 'letter', 'lock-open', 'list1', 'lock-closed', 'logo', 'mastercard', 'medicine', 'messages', 'metro-moscow', 'metro-spb', 'money-orders', 'mobile', 'mode1', 'money', 'notification-attention', 'notification-error', 'operator', 'notification-question', 'notification-successfully', 'phone1', 'other', 'paying-regular-repeat', 'payments', 'personal-transport', 'phonebook', 'public-services', 'pin', 'plus1', 'print', 'rent-car', 'rent', 'repeat-payment', 'reply-letter', 'restaurants', 'ruble', 'search2', 'selecting-from-list', 'service', 'sms-notification', 'settings', 'taxes', 'share1', 'shopping', 'transaction-on-card', 'transaction', 'templates', 'transfer-friend', 'transfer-between-own-accounts', 'transfer-other-bank-cards', 'transfer', 'translation-between-accounts-conversion', 'translation-card-conversion', 'travel', 'transport', 'translation-card', 'trolley', 'tv', 'twitter3', 'undefined-transaction', 'undefined-action', 'undefined-service', 'user-1', 'unload', 'user-2', 'virtual-card', 'visa', 'vkontakte', 'webcam', 'ac', 'ae', 'br', 'apple-computer', 'au', 'ai', 'fb', 'download2', 'dw', 'en', 'id', 'finder', 'fl', 'me', 'fw', 'pr', 'ps', 'pl', 'sg', 'settings1', 'sunrise1', 'cloud-rain-moon', 'east', 'north', 'south', 'west', 'cloud-drizzle-sun', 'cloud-drizzle-sun-alt', 'cloud-drizzle-moon', 'cloud-drizzle-moon-alt', 'cloud-download', 'cloud-dizzle', 'cloud-drizzle', 'cloud-fog-sun-alt', 'cloud-fog-sun', 'cloud-fog-moon', 'cloud-fog-moon-alt', 'cloud-fog-alt', 'cloud-hail-alt', 'cloud-hail-moon-alt', 'cloud-hail-moon', 'cloud-fog', 'cloud-hail-sun-alt', 'cloud-hail-sun', 'cloud-hail', 'cloud-lightning-sun', 'cloud-lightning-moon', 'cloud-rain-sun-alt', 'cloud-moon', 'cloud-lightning', 'cloud-rain-alt', 'cloud-rain-moon-alt', 'cloud-rain-sun', 'cloud-snow-moon-alt', 'cloud-rain', 'cloud-refresh', 'cloud-snow-moon', 'cloud-snow-sun-alt', 'cloud-snow-alt', 'cloud-snow-sun', 'cloud-sun', 'cloud-wind-moon', 'cloud-wind', 'cloud-snow', 'cloud-upload', 'cloud1', 'compass1', 'degrees-celcius', 'moon-first-quarter', 'degrees-fahrenheit', 'moon-full', 'moon-new', 'moon-last-quarter', 'moon-waning-crescent', 'moon-waxing-crescent', 'moon-waning-gibbous', 'moon-waxing-gibbous', 'moon', 'shades', 'sun1', 'snowflake', 'sun-low', 'sunset', 'sun-lower', 'thermometer-25', 'cloud-wind-sun', 'thermometer-50', 'thermometer-75', 'thermometer-zero', 'thermometer', 'tornado', 'umbrella', 'wind', 'thermometer-100', 'address-book-2', 'add', 'address-book', 'alarm-clock', 'align-horizontal-centers', 'align-left-edges', 'align-right-edges', 'align-top', 'align-vertical-centers', 'align-bottom', 'anchor2', 'arrow-down', 'arrow-left2', 'arrow-up', 'arrow-right4', 'asterisk', 'attachment-2', 'attachment', 'audio-high', 'audio-mid', 'audio-low', 'battery-20-2', 'battery-20', 'battery-40-2', 'battery-40', 'battery-60-2', 'audio-mute', 'battery-60', 'battery-80-2', 'battery-80', 'battery-100-2', 'battery-100', 'battery-charge', 'battery-empty-2', 'battery-empty', 'bell-2', 'bell-mute-2', 'battery-charge-2', 'bell-mute', 'bell', 'bin-3', 'bin-2', 'bin', 'book-2', 'book-lines', 'book1', 'brightness-high', 'brightness-low', 'browser-close-2', 'browser-close', 'browser-download-2', 'browser-download', 'browser-2', 'browser-minimize-2', 'browser-new-window-2', 'browser-minimize', 'browser-new-window', 'book-lines-2', 'browser-upload', 'browser-upload-2', 'browser-windows-2', 'browser-windows', 'browser', 'bulb-2', 'bulb', 'bullhorn', 'bullhorn-2', 'camera-2', 'calendar2', 'bullet', 'camera-3', 'clipboard-2', 'camera', 'cassette', 'clipboard', 'clock1', 'cloud-add-2', 'cloud-add', 'cloud-download1', 'cloud-remove-2', 'cloud2', 'cmd', 'commit', 'code', 'cloud-upload1', 'compass2', 'compose-2', 'compose-4', 'compose-3', 'cloud-remove', 'compose', 'contract-2', 'contract-3', 'contrast', 'contract', 'converge', 'credit-card-2', 'credit-card-3', 'crate', 'credit-card-4', 'credit-card', 'crop1', 'cross', 'curlybrace-2', 'database-add', 'database-remove', 'database1', 'curlybrace', 'delete', 'distribute-bottom-edges', 'distribute-horizontal-centers', 'distribute-left-edges', 'distribute-right-edges', 'distribute-vertical-centers', 'document-add', 'document-remove', 'document2', 'distribute-top-edges', 'droplet', 'ellipsis', 'envelope', 'exclude', 'expand-2', 'expand', 'expand-3', 'eye-2', 'eye2', 'fast-forward', 'flag-3', 'flag1', 'flask-full', 'flask-empty', 'floppy', 'flux', 'folder-2', 'folder-add-2', 'folder-add', 'folder-duplicate', 'folder-remove-2', 'folder-remove', 'folder-duplicate-2', 'folder3', 'fork', 'grid-3', 'grid1', 'headphones1', 'heart-full', 'heart-empty', 'heart-half', 'home-2', 'home-3', 'home2', 'icon0', 'in', 'image1', 'inbox-2', 'inbox', 'infinity1', 'intersect', 'key-2', 'layout-column-center', 'keys', 'layout-content-left-2', 'key', 'layout-content-left', 'layout-content-right-2', 'layout-content-right', 'layout-sidebar-left', 'layout-sidebar-right', 'link2', 'list-2', 'link-2', 'list2', 'locked', 'mail-2', 'mail-3', 'mail-4', 'mail-outgoing', 'mail', 'map-2', 'mail-incoming', 'map1', 'marquee-download', 'marquee-minus', 'marquee-plus', 'marquee-upload', 'maximise', 'marquee', 'menu-2', 'menu-pull-down', 'menu-pull-up', 'menu2', 'microphone-2', 'minus1', 'mixer', 'microphone1', 'newspaper-2', 'newspaper', 'next1', 'nib', 'nope', 'options', 'out', 'outbox-2', 'notes', 'outbox', 'outgoing-2', 'paper-ripped', 'outgoing', 'paper-roll-ripped', 'paragraph-center-2', 'paper-roll', 'paragraph-center', 'paragraph-justify-2', 'paragraph-justify', 'paragraph-left-2', 'paragraph-left', 'paragraph-right', 'pen2', 'pause1', 'paragraph-right-2', 'pencil', 'pin-2', 'pin1', 'play1', 'plus2', 'podcast', 'polaroid-2', 'podcast-2', 'polaroid', 'power', 'previous1', 'print1', 'pull', 'quill', 'refresh', 'quill-2', 'reminder', 'remove', 'repeat-2', 'repeat2', 'reply-all', 'return1', 'revert', 'rewind1', 'rulers', 'safe', 'search-2', 'search3', 'settings-2', 'settings-3', 'section', 'settings2', 'settings-4', 'shred', 'shuffle2', 'sleep', 'reply1', 'spam-2', 'spam', 'speech-bubble-center-2', 'speech-bubble-center-3', 'speech-bubble-center', 'speech-bubble-left-3', 'speech-bubble-left-4', 'speech-bubble-left-2', 'speech-bubble-left', 'speech-bubble-right-2', 'speech-bubble-right-3', 'speech-bubble-right-4', 'speech-bubble-right', 'spinner-3', 'spinner', 'split-2', 'spinner-2', 'split', 'spool', 'square-brackets', 'stamp-2', 'stamp1', 'star2', 'stiffy', 'star-2', 'stop1', 'stopwatch', 'store-2', 'store', 'support-3', 'subtract', 'support', 'support-2', 'swap-2', 'switch-off', 'swatch', 'swatches', 'swap', 'switch-on', 'tag-2', 'tag-3', 'tag-4', 'tag3', 'terminal-2', 'terminal', 'terminal-3', 'tick', 'tilde', 'timeline', 'toggle-off', 'toggle-on', 'transfer1', 'tray', 'unite', 'unlocked', 'unwatch', 'user-2-add', 'user-3', 'user-4-add', 'user-4', 'user-4-remove', 'user-2-remove', 'user-5', 'user-card', 'users1', 'user2', 'video-2', 'vinyl', 'video1', 'voicemail', 'wallet-2', 'wallet', 'watch-2', 'watch', 'wave', 'wave-2', 'wifi-high', 'wifi-low', 'wifi-mid', 'wiggle', 'windows2', 'zoom-in', 'zoom-out-2', 'zoom-out', 'zoom-in-2', 'vertical-swipe-2', 'triple-tap-2', 'vertical-swipe', 'vertical-drag', 'swipe-up-2', 'tap-2', 'swipe-right-2', 'swipe-left-2', 'omnidi-swipe-2', 'swipe-down-2', 'triple-tap', 'horizontal-swipe', 'double-tap-2', 'drag', 'tap', 'swipe-right', 'swipe-left', 'swipe-down', 'rotate-counter-clockwise', 'rotate-clockwise', 'spread', 'pinch', 'omnidir-swipe', 'onmidir-drag', 'horizontal-swipe1', 'horizontal-drag', 'drag-left', 'drag-down', 'double-tap', 'drag-right', 'drag-up', 'vertical-flick', 'omnidir-flick', 'horizontal-flick', 'flick-right', 'flick-left', 'flick-up', 'flick-down', 'swipe-up', 'backpack', 'backpack-2', 'bill', 'bookmark', 'briefcase', 'bookshelf', 'bus', 'calc', 'car', 'chalkboard', 'clock2', 'candy', 'cloud-check', 'cloud-down', 'cloud-error', 'cloud-refresh1', 'cloud-up', 'donut', 'hamburger', 'flag2', 'eye3', 'glasses', 'glove', 'drop', 'hand', 'knife', 'map2', 'label', 'map3', 'hotdog', 'marker', 'mcfly', 'mountain', 'medicine1', 'open-letter', 'muffin', 'paper-plane', 'piggy', 'photo-2', 'packman', 'pizza', 'pin2', 'r2d2', 'rocket', 'store1', 'sale', 'skull2', 'speakers', 'toaster', 'train', 'tactic', 'watch1', 'www', 'umbrella1', 'minus2', 'plus3', 'arrow-down1', 'arrow-right5', 'arrow-left3', 'arrow-top1', 'other1', 'download3', 'other2', 'paint-roll', 'image2', 'image3', 'soother', 'indesign-doc', 'doc', 'text-doc', 'illustrator-doc', 'photoshop-doc', 'message-empty', 'book2', 'message-middle', 'message-full', 'envelope-open', 'note-book', 'envelope1', 'safe1', 'search4', 'mailbox', 'deal', 'briefcase1', 'law', 'office', 'house', 'coffee1', 'computer-mouse', 'washing-machine', 'joystick1', 'joystick2', 'light', 'laptop', 'camera1', 'fax', 'tv1', 'imac', 'tablet1', 'microphone2', 'smartphone1', 'photo-camera', 'radio', 'battery-empty1', 'battery-middle', 'chemistry', 'medicine2', 'battery-full', 'calculator', 'syringe', 'chemistry1', 'termometer', 'chemistry2', 'light-bulb', 'pen3', 'paint-brush', 'pen4', 'paper-knife', 'paint-brush1', 'glue', 'paint-roll1', 'marker1', 'pencil1', 'ruler', 'gifts', 'santa', 'gingerbread', 'gifts1', 'song', 'elf', 'calendar3', 'price-tag', 'santa-hat', 'sledge', 'sock', 'bird', 'angel', 'candy-stick', 'candle', 'ornament', 'star3', 'penguin', 'ornament1', 'ornament2', 'candy1', 'bell1', 'ornament3', 'ornament4', 'candy2', 'deer', 'christmas-tree', 'ornament5', 'gift', 'snowflake1', 'snowman', 'ornament6', 'christmas-tree1', 'santa1', 'garland', 'ornament7', 'candle1', 'ornament8', 'snowflake2', 'sock1', 'gift1', 'deer1', 'santa-hat1', 'christmas-wreath', 'cake', 'forest', 'deer2', 'santa2', 'heart3', 'bow-tie', 'snowman1', 'snowflake3', 'gingerbread1', 'bell2', 'gloves', 'ornament9', 'sock2', 'star4', 'santa-hat2', 'christmas-tree2', 'gift2', 'candy-stick1', 'ornament10', 'shopping-cart', 'barcode1', 'message2', 'money1', 'message3', 'moneybox', 'shipping', 'baggage', 'package', 'credit-card1', 'money2', 'money3', 'shopping-cart1', 'gift3', 'like1', 'package1', 'package-open', 'open-sign', 'calculator1', 'wallet1', 'money4', 'window1', 'console', 'map4', 'map5', 'search5', 'joystick3', 'direction-size', 'map6', 'direction-size1', 'flag3', 'direction-size2', 'road-turn', 'microphone3', 'equalizer', 'map-tag', 'pin3', 'globe', 'globe1', 'graph-pie', 'compass3', 'tag4', 'tag5', 'play-pause', 'volume-loud', 'sound1', 'microphone4', 'rewind2', 'play-pause1', 'play2', 'volume-mute', 'volume', 'volume-up', 'pin4', 'arrow-left4', 'arrow-right6', 'align-right1', 'align-left1', 'align-center1', 'ribbon1', 'book3', 'book4', 'book-open', 'calendar4', 'briefcase2', 'calendar5', 'presentation', 'presentation1', 'contacts', 'blank-document', 'document3', 'briefcas', 'bubble-speach', 'bubble-speach1', 'bubble-speach2', 'bubble-speach3', 'bubble-speach4', 'mailbox1', 'folder4', 'bubble-speach5', 'mail1', 'mail2', 'mail3', 'mail4', 'documents', 'documents1', 'documents2', 'upload1', 'download4', 'documents3', 'mail5', 'calculator2', 'laptop1', 'folders', 'speed', 'mouse', 'presentation2', 'type', 'type-cursor', 'grid2', 'notepad', 'search6', 'graph-pie1', 'graph', 'cd', 'cd1', 'floppy-disk', 'edit2', 'edit3', 'image4', 'image5', 'bell3', 'cord', 'medal', 'alarm-clock1', 'photo2', 'photo3', 'photo4', 'light-bulb1', 'light-bulb2', 'rotate1', 'arrow-right7', 'flag4', 'arrow-left5', 'right-arrow', 'left-arrow', 'close1', 'check1', 'heart4', 'list3', 'gear1', 'love-talk', 'love-chat', 'love-thoughts', 'add-love', 'love-more', 'multiply-love', 'love-again', 'view-love', 'subtract-love', 'love-2-way-street', 'loveppriciate', 'loverror', 'love-bow', 'win-love', 'lovexlamation', 'love-25-', 'love-50-', 'love-75-', 'love-100-', 'love-link-up', 'love-connect', 'lovers-wifi', 'verbal-love', 'silent-love', 'search-love', 'add-love1', 'multiply-love1', 'subtract-love1', 'lucky-in-love', 'trash-love', 'lovetimate', 'time-for-some-love', 'wait-for-love', 'love-bought', 'love-burst', 'love-play', 'love-there', 'love-here', 'open-to-love', 'closed-to-love', 'love-lit', 'love-light', 'love-edit', 'snowflake-04', 'snowflake-02', 'snowflake-03', 'snowflake-06', 'snowflake-05', 'snowflake-07', 'snowflake-08', 'snowflake-10', 'snowflake-12', 'snowflake-09', 'snowflake-13', 'snowflake-14', 'snowflake-15', 'snowflake-16', 'snowflake-11', 'snowflake-17', 'snowflake-18', 'snowflake-19', 'snowflake-20', 'snowflake-22', 'snowflake-21', 'snowflake-23', 'snowflake-24', 'snowflake-26', 'snowflake-27', 'snowflake-25', 'snowflake-29', 'snowflake-28', 'snowflake-30', 'snowflake-31', 'snowflake-32', 'snowflake-33', 'snowflake-34', 'snowflake-35', 'snowflake-36', 'snowflake-37', 'snowflake-38', 'snowflake-39', 'snowflake-41', 'snowflake-40', 'snowflake-42', 'snowflake-43', 'snowflake-44', 'snowflake-45', 'snowflake-47', 'snowflake-49', 'snowflake-46', 'snowflake-48', 'snowflake-50', 'snowflake-51', 'snowflake-53', 'snowflake-54', 'snowflake-52', 'snowflake-55', 'snowflake-56', 'snowflake-57', 'snowflake-58', 'snowflake-59', 'snowflake-60', 'snowflake-61', 'snowflake-62', 'snowflake-63', 'snowflake-64', 'snowflake-65', 'snowflake-66', 'snowflake-67', 'snowflake-68', 'snowflake-69', 'snowflake-70', 'snowflake-71', 'smartphone2', 'printer1', 'map7', 'pin5', 'mail6', 'airplane', 'gear2', 'share2', 'like2', 'globe2', 'tools', 'bomb', 'zip', 'image6', 'cloud3', 'graph1', 'briefcase3', 'list4', 'folder5', 'bookmark1', 'funds', 'cart', 'gist', 'coffee2', 'chicken', 'apple', 'icecream', 'music1', 'pipe', 'diamond1', 'robo', 'facebook4', 'gplus', 'twitter4', 'dribbble2', 'github', 'math', 'graph2', 'discuss', 'work', 'professor', 'diploma', 'work1', 'calendar6', 'recycle', 'tools1', 'lab', 'botanica', 'ufology', 'chemistry3', 'net', 'ornithology', 'economics', 'stort', 'exam', 'chemistry4', 'airplane1', 'pharma', 'history', 'internet1', 'geography', 'pin6', 'calculator3', 'school-bus', 'dna', 'gravity', 'astrology', 'brain', 'formula', 'graph3', 'glasses1', 'arheology', 'flag5', 'crop2', 'image7', 'flag6', 'move1', 'stop2', 'download5', 'rain', 'upload2', 'equalizer1', 'snow', 'sun2', 'partial-sun', 'rain1', 'cloud4', 'thunder', 'clip1', 'tag6', 'on', 'folder6', 'chain', 'briefcase4', 'wallet2', 'mail7', 'user3', 'mail8', 'lifebuoy1', 'map8', 'map9', 'geotag1', 'recieved', 'send', 'battery-low', 'battery-middle1', 'battery-full1', 'battery-died', 'error', 'success', 'map-direction', 'cursor', 'photo5', 'smartphone3', 'tablet2', 'cassette1', 'laptop2', 'desktop', 'mouse1', 'house1', 'conversation', 'speech', 'speech1', 'search7', 'star5', 'document4', 'documents4', 'document5', 'edit4', 'edit5', 'trash1', 'trash2', 'rotate2', 'rotate3', 'unlock1', 'lock1', 'grid3', 'grid4', 'clock3', 'compass4', 'ribbon2', 'wifi', 'eye4', 'menu3', 'sound2', 'loud1', 'mute1', 'pause2', 'stop3', 'rewind3', 'play3', 'forward1');

	$output .= '<input type="hidden" name="'.$param_name.'" class="wpb_vc_param_value '.$param_name.' '.$type.' '.$class.'" value="'.$value.'" id="ss-trace-melon"/>';
	$output .= '<div class="ss-icon-preview icon_melon"><div class="iconmelon icon"><svg viewBox="0 0 32 32"><use xlink:href="#'.$value.'"></use></svg></div></div>';
	$output .= '<input class="ss-search" type="text" placeholder="Search icon" />';
	$output .= '<div id="ss-icon-dropdown" class="melon-dropdown">';
	$output .= '<ul class="ss-icon-list">';
	$n = 1;
	foreach($icons as $icon){
		$selected = ($icon == $value) ? 'class="selected"' : '';
		$id = 'icon-'.$n;
		$output .= '<li '.$selected.' data-icon="'.$icon.'">';
		$output .= '<div class="iconmelon icon"><svg viewBox="0 0 32 32"><use xlink:href="#'.$icon.'"></use></svg></div>';
		$output .= '<label class="icon">'.$icon.'</label>';
		$output .= '</li>';
		$n++;
	}
	$output .='</ul>';
	$output .='</div>';
	$output .= '<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(".ss-search").keyup(function(){
					var filter = jQuery(this).val(), count = 0;
					jQuery(".ss-icon-list li").each(function(){
						if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
							jQuery(this).fadeOut();
						} else {
							jQuery(this).show();
							count++;
						}
					});
				});
			});

			jQuery("#ss-icon-dropdown.melon-dropdown li").click(function() {
				jQuery(this).attr("class","selected").siblings().removeAttr("class");
				var icon = jQuery(this).attr("data-icon");
				jQuery("#ss-trace-melon").val(icon);
				jQuery(".ss-icon-preview.icon_melon").html("<div class=\'iconmelon icon\'><svg viewBox=\'0 0 32 32\'><use xlink:href=\'#"+icon+"\'></use></svg></div>");
			});
	</script>';
	return $output;
}
add_shortcode_param('supreme_choose_icons_melon', 'SupremeShortcodes__icon_melon_fields');



/* POST TYPES DROPDOWN */
function SupremeShortcodes__post_types($settings, $value) {

	$dependency = vc_generate_dependencies_attributes($settings);

	$output = '';

	$args = array(
	   'public'   => true,
	   '_builtin' => false,
	   'query_var' => true
	);
	$post_types = get_post_types( $args, 'names' ); 

	$output .= '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" ' . $dependency . '>';
		$output .= '<option value="post">post</option>';
		$output .= '<option value="page">page</option>';
		foreach ( $post_types as $post_type ) {
			$output .= '<option value="'.$post_type.'">' . $post_type . '</option>';
		}
	$output .= '</select>';

	return $output;

}
add_shortcode_param('supreme_post_types', 'SupremeShortcodes__post_types');



/*---------------------------------
		SUPREME ARRAYS 
---------------------------------*/

$button_size_arr = array(__("Small", $shortname) => "small", __("Normal", $shortname) => "normal", __("Large", $shortname) => "large", __("Jumbo", $shortname) => "jumbo");
$button_target_arr = array(__("Same window", $shortname) => "_self", __("New window", $shortname) => "_blank");
$dividers_arr = array(__('Dotted', $shortname) => "divider_dotted", __('Dashed', $shortname) => "divider_dashed", __('To Top', $shortname) => "divider_top", __('Shadow', $shortname) => "divider_shadow");

$vc_st_animation = array(
	"type" => "dropdown",
	"heading" => __("CSS Animation", $shortname),
	"param_name" => "vc_st_css_animation",
	"admin_label" => true,
	"value" => array(__("No", $shortname) => '', __("Top to bottom", $shortname) => "top-to-bottom", __("Bottom to top", $shortname) => "bottom-to-top", __("Left to right", $shortname) => "left-to-right", __("Right to left", $shortname) => "right-to-left", __("Appear from center", $shortname) => "appear"),
	"description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", $shortname)
);


/*---------------------------------
		SUPREME SHORTCODES 
---------------------------------*/

/* SUPREME BUTTON */

function SupremeShortcodes__ColorDarken($color, $dif=20){
 
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return '000000'; }
    $rgb = '';
 
    for ($x=0;$x<3;$x++){
        $c = hexdec(substr($color,(2*$x),2)) - $dif;
        $c = ($c < 0) ? 0 : dechex($c);
        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
    }
 
    return '#'.$rgb;
}

add_shortcode( 'vc_st_button', 'SupremeShortcodes__button' );
function SupremeShortcodes__button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'color'       => '#ffffff',
		'link'        => '',
		'background'  => '',
		'size'        => '',
		'type'        => '',
		'target'      => '',
		'icon'        => '',
		'icon_size'   => '',
		'border_radius'   => '',
        'icon_spin'		=> ''
	), $atts));

	$content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

	$spin = '';
	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	$final_size = str_replace("icon-", "st-size-", $icon_size);

	if ($icon !== 'none') {
		$btn_icon = '<i class="fa fa-'.$icon.$spin.' '.$final_size.'"></i>';
	}else{
		$btn_icon = '';
	}

	if ($border_radius !== '') {
		$styles[] = '-webkit-border-radius:' . $border_radius;
		$styles[] = '-moz-border-radius:' . $border_radius;
		$styles[] = 'border-radius:' . $border_radius;
	}else{
		$styles[] = '-webkit-border-radius: 2px';
		$styles[] = '-moz-border-radius: 2px';
		$styles[] = 'border-radius: 2px';
	}

	for ($x=1; $x < 20; $x++){
		// Start color: 
		$c = SupremeShortcodes__ColorDarken($background, ($x * 3));
	}

	if($color != '') {
		$styles[] = 'color:' . $color;
	}
	if($background != '') {
		$styles[] = 'background:' . $background;
		$styles[] = 'border-color:' . $background;
		$styles[] = 'box-shadow: 0 4px ' . $c;
	}

	$cStyles = (is_array($styles)) ? ' style="'.implode("; ", $styles).'"' : '';

	return "<a href='{$link}' class='ss-btn {$size}' {$cStyles} target='{$target}'>{$btn_icon}{$content}</a>";
}



$supreme_vc_map["3D Button"] = array(
	"name" => __("3D Button", $shortname),
	"base" => "vc_st_button",
	"icon" => "icon-wpb-vc_st_button",
	"category" => array(__('Content', $shortname), __('Social', $shortname), __('Supreme', $shortname) ),
	"description" => __('Beautiful 3D buttons, unlimited colors.', $shortname),
	"params" => array(
	    array(
			"type" => "textfield",
			"heading" => __("Button Text", $shortname),
			"param_name" => "content",
			"value" => __("Button text goes here", $shortname),
			"description" => __("Text to show in button.", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Button Link", $shortname),
			"param_name" => "link",
			"value" => __("http://", $shortname),
			"description" => __("Text to show in button.", $shortname),
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Button size", $shortname),
			"param_name" => "size",
			"value" => $button_size_arr,
			"description" => __("Select button size.", $shortname),
			"admin_label" => true
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Target", $shortname),
			"param_name" => "target",
			"value" => $button_target_arr,
			"dependency" => Array('element' => "link", 'not_empty' => true)
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Background color", $shortname),
			"param_name" => "background",
			"value" => '#3498db', //Default Red color
			"description" => __("Choose button background color", $shortname)
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Text color", $shortname),
			"param_name" => "color",
			"value" => '#ffffff', //Default Red color
			"description" => __("Choose button text color", $shortname)
	    ),
	    array(
			"type" => "supreme_choose_icons",
			"heading" => __("Icon", $shortname),
			"param_name" => "icon",
			"value" => 'none'
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Icon size", $shortname),
			"param_name" => "icon_size",
			"value" => array(__("1", $shortname) => "icon-1", __("2", $shortname) => "icon-2", __("3", $shortname) => "icon-3", __("4", $shortname) => "icon-4", __("5", $shortname) => "icon-5", __("6", $shortname) => "icon-6",),
			"dependency" => Array('element' => "icon", 'not_empty' => true)
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Spin?", $shortname),
			"param_name" => "icon_spin",
			"value" => array(
					__("No", $shortname) => "no",
					__("Yes", $shortname) => "yes"
				),
			"description" => __("If yes, icon will rotate clockwise.", $shortname)
	    )
  	)
);


/* SUPREME DIVIDERS */

add_shortcode( 'vc_st_divider', 'SupremeShortcodes__divider' );
function SupremeShortcodes__divider( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'divider_style' => ''
	), $atts));

	$output = '';

	$shadow_img = plugins_url('images/divider_shadow.png', __FILE__);

	if ($divider_style == 'divider_top') {
		$divider_content = '<a href="#" class="to-top">'.__('top', $shortname).' <i class="fa-angle-up st-size-1"></i></a>';
	}else if($divider_style == 'divider_shadow'){
		$divider_content = '<img alt="Shadow Divider" src="'.$shadow_img.'" />';
	}else{
		$divider_content = '';
	}
  
  	$output = '<div class="'.$divider_style.'">'.$divider_content.'</div>';

  	return $output;
}

$supreme_vc_map["Dividers"] = array(
	"name" => __("Dividers", $shortname),
	"base" => "vc_st_divider",
	"icon" => "icon-wpb-vc_st_divider",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Horizontal separator line with various styles.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Divider style", $shortname),
			"param_name" => "divider_style",
			"value" => $dividers_arr,
			"description" => __("Select divider style.", $shortname),
			"admin_label" => true
		)
  	)
);



/* SUPREME READ MORE */

add_shortcode( 'vc_st_read_more', 'SupremeShortcodes__read_more' );
function SupremeShortcodes__read_more( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'text' => '',
		'link' => '',
		'target' => ''
	), $atts));
  
  $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

  return "<a href='{$link}' class='ss-btn more'>{$text}</a><div class='clear'></div>";
}


$supreme_vc_map["Button More"] = array(
	"name" => __("Button More", $shortname),
	"base" => "vc_st_read_more",
	"icon" => "icon-wpb-vc_st_read_more",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Read more button, custom text.', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			
			"heading" => __("Button Text", $shortname),
			"param_name" => "text",
			"value" => __("Button text goes here", $shortname),
			"description" => __("Text to show in button.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			
			"heading" => __("Button Link", $shortname),
			"param_name" => "link",
			"value" => __("http://", $shortname),
			"description" => __("Text to show in button.", $shortname)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Target", $shortname),
			"param_name" => "target",
			"value" => $button_target_arr,
			"dependency" => Array('element' => "link", 'not_empty' => true)
		)
  	)
);


/* SUPREME LOGIN - LOGOUT BUTTON */

add_shortcode( 'vc_st_login_out', 'SupremeShortcodes__loginout' );
function SupremeShortcodes__loginout($atts, $content = null) {
	extract(shortcode_atts(array(
		'login_msg'   => 'Log In',
		'logout_msg'  => 'Log Out',
		'text_color'  => '',
		'background'  => '',
		'size'        => 'ss-btn',
		'type'        => 'empty'
	), $atts));

	$output = '';

	if ($size == 'btn') {
		$size = 'ss-btn';
	}else{
		$size = $size;
	}

	for ($x=1; $x < 20; $x++){
		// Start color: 
		$c = SupremeShortcodes__ColorDarken($background, ($x * 3));
	}

	if($text_color != '') {
		$styles[] = 'color:' . $text_color;
	}
	if($background != '') {
		$styles[] = 'background:' . $background;
		$styles[] = 'border-color:' . $background;
		$styles[] = 'box-shadow: 0 4px ' . $c;
	}

	$cStyles = (is_array($styles)) ? ' style="'.implode("; ", $styles).'"' : '';

	if (!is_user_logged_in()) {
		$output = '<a href="' . esc_url(wp_login_url()) . '" class="ss-btn '.$size.'"'.$cStyles.'>' . $login_msg . '</a>';
	} else {
		$output = '<a href="' . esc_url(wp_logout_url()) . '" class="ss-btn '.$size.'"'.$cStyles.'>' . $logout_msg . '</a>';
	}
	return ($output);
}


$supreme_vc_map["Login/Out"] = array(
	"name" => __("Login/Out", $shortname),
	"base" => "vc_st_login_out",
	"icon" => "icon-wpb-vc_st_login_out",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Quick login/logout button, unlimited styles.', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			
			"heading" => __("Login Text", $shortname),
			"param_name" => "login_msg",
			"value" => __("Login", $shortname),
			"description" => __("Text to show in button when user is logged out.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			
			"heading" => __("Logout Text", $shortname),
			"param_name" => "logout_msg",
			"value" => __("Logout", $shortname),
			"description" => __("Text to show in button when user is logged in.", $shortname)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button size", $shortname),
			"param_name" => "size",
			"value" => $button_size_arr,
			"description" => __("Select button size.", $shortname)
		),
		array(
			"type" => "colorpicker",
			
			"heading" => __("Background color", $shortname),
			"param_name" => "background",
			"value" => '#3498db', //Default Red color
			"description" => __("Choose button background color", $shortname)
		),
		array(
			"type" => "colorpicker",
			
			"heading" => __("Text color", $shortname),
			"param_name" => "text_color",
			"value" => '#ffffff', //Default Red color
			"description" => __("Choose button text color", $shortname)
		)
  	)
);


/* SUPREME SECTION */

add_shortcode('vc_st_section','SupremeShortcodes__section');
function SupremeShortcodes__section( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'background'        => '',
        'text_color'        => '',
        'type'              => '',
        'bg_attachment'     => '',
        'bg_image_repeat'   => '',
        'bg_image_position' => '',
        'bg_image'          => '',
        'bg_size'           => '',
        'padding'           => ''
    ), $atts ) );

    $output = '';

    $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

    $id = rand(100,1000);

	// if bg color
	if ($background !== '') {
		$background_color = 'background-color:'.$background.'; ';
	}else{
		$background_color = 'background-color: transparent; ';
	}

	// if color
	if ($color !== '') {
		$text_color = 'color:'.$color.';';
	}else{
		$text_color = 'color: #333333;';
	}

	// padding
	if ($padding !== '') {
    	$divStyle = ' style="padding: '.$padding.';"';
    }else{
    	$divStyle = '';
    }

    // if bg_size
    if ($bg_size !== '') {
    	$background_size = ' background-size:'.$bg_size.'; -webkit-background-size: '.$bg_size.'; -moz-background-size: '.$bg_size.'; -o-background-size: '.$bg_size.'; background-size: '.$bg_size.'; ';
    }else{
    	$background_size = ' background-size: initial; ';
    }

    // if bg image
    $has_image = false;
    if((int)$bg_image > 0 && ($image_url = wp_get_attachment_url( $bg_image, 'large' )) !== false) {
        $has_image = true;
        $photo_url = $image_url;
    }

	// if parallax
	if ($type == 'section_parallax') {
		$section_attributes = $background_color.'background-image: url('.$photo_url.'); background-position: '.$bg_image_position.'; background-repeat: '.$bg_image_repeat.'; background-attachment: fixed; '.$background_size;
		$parallax_class = ' full-width-section parallax_section';
	}else if($type == 'section_image'){
		$section_attributes = $background_color.'background-image: url('.$photo_url.'); background-position: '.$bg_image_position.'; background-repeat: '.$bg_image_repeat.'; background-attachment: '.$bg_attachment.' !important; '.$background_size;
		$parallax_class = '';
	}else{
		$section_attributes = $background_color;
		$parallax_class = '';
	}

    $output .= '<section id="'.$id.'" class="content-section'.$parallax_class.'" style="'.$text_color.$section_attributes.'"><div'.$divStyle.'>' .$content. '</div></section>';

    return $output;
}

$supreme_vc_map["Section"] = array(
	"name" => __("Section", $shortname),
	"base" => "vc_st_section",
	"is_container" => true,
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-vc_st_section",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Color or Image with parallax effects.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Section type", $shortname),
			"param_name" => "type",
			"value" => array(__("Color", $shortname) => "section_color", __("Image", $shortname) => "section_image", __("Parallax", $shortname) => "section_parallax"),
			"description" => __("Select color or Section Image.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "attach_image",
			"heading" => __("Background image", $shortname),
			"param_name" => "bg_image",
			"value" => "",
			"description" => __("Select image from media library.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('section_image', 'section_parallax'))
		),
		array(
			"type" => "dropdown",
			"heading" => __('Background Repeat', $shortname),
			"param_name" => "bg_image_repeat",
			"value" => array(
		                __("Repeat", $shortname) => 'repeat',
		                __("No Repeat", $shortname) => 'no-repeat',
		                __('Repeat Horizontaly', $shortname) => 'repeat-x',
		                __('Repeat Vertically', $shortname) => 'repeat-y'
		              ),
			"description" => __("Select how a background image will be repeated", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('section_image', 'section_parallax'))
		),
		array(
			"type" => "dropdown",
			"heading" => __('Background Attachment', $shortname),
			"param_name" => "bg_attachment",
			"value" => array(
		                __("Fixed", $shortname) => 'fixed',
		                __("Scroll", $shortname) => 'scroll'
		              	),
			"description" => __("Select weather background image will scroll or be fixed to the page.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('section_image'))
		),
		array(
			"type" => "dropdown",
			"heading" => __('Background Size', $shortname),
			"param_name" => "bg_size",
			"value" => array(
		                __("Cover", $shortname) => 'cover',
		                __("Initial", $shortname) => 'initial'
		              	),
			"description" => __("Select weather background image will cover the width of the element or not.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('section_parallax'))
		),
		array(
			"type" => "dropdown",
			"heading" => __('Background Position', $shortname),
			"param_name" => "bg_image_position",
			"value" => array(
		                __("left top", $shortname) => 'left top',
		                __("left center", $shortname) => 'left center',
		                __("left bottom", $shortname) => 'left bottom',
		                __("right top", $shortname) => 'right top',
		                __("right center", $shortname) => 'right center',
		                __("right bottom", $shortname) => 'right bottom',
		                __("center top", $shortname) => 'center top',
		                __("center center", $shortname) => 'center center',
		                __("center bottom", $shortname) => 'center bottom'
		              ),
			"description" => __("Select background image position.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('section_image'))
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Background color", $shortname),
			"param_name" => "background",
			"value" => '#3498db', //Default Red color
			"description" => __("Choose button background color", $shortname)
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Text color", $shortname),
			"param_name" => "text_color",
			"value" => '#ffffff', //Default Red color
			"description" => __("Choose text color", $shortname)
		),
		array(
			"type" => "textfield",
			"heading" => __("Padding", $shortname),
			"param_name" => "padding",
			"description" => __("Choose padding in pixels or precents. Example: 20px", $shortname)
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => __("Text", $shortname),
			"param_name" => "content",
			"value" => __("<p>I am text block.</p>", $shortname)
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", $shortname),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", $shortname)
		)

  	)
);


/* SUPREME BOX */

add_shortcode('vc_st_box','SupremeShortcodes__box');
function SupremeShortcodes__box( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'type'  	  	=> '',
        'color'       	=> '#ffffff',
		'link'        	=> '',
		'background'  	=> '',
		'size'        	=> '',
		'btn_text'    	=> '',
		'target'      	=> '',
		'icon'        	=> '',
		'icon_size'   	=> '',
		'vc_st_css_animation' => ''
    ), $atts ) );

    $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

    $output = '';

	$final_size = str_replace("icon-", "st-size-", $icon_size);

    if ($icon !== 'none') {
		$btn_icon = '<i class="fa fa-'.$icon.' '.$final_size.'"></i>';
	}else{
		$btn_icon = '';
	}

	for ($x=1; $x < 20; $x++){
		// Start color: 
		$c = SupremeShortcodes__ColorDarken($background, ($x * 3));
	}

	if($color != '') {
		$styles[] = 'color:' . $color;
	}
	if($background != '') {
		$styles[] = 'background:' . $background;
		$styles[] = 'border-color:' . $background;
		$styles[] = 'box-shadow: 0 4px ' . $c;
	}

	if ($vc_st_css_animation !== '') {
		$animated_class = ' wpb_animate_when_almost_visible wpb_'.$vc_st_css_animation;
	}else{
		$animated_class = '';
	}


	$cStyles = (is_array($styles)) ? ' style="'.implode("; ", $styles).'"' : '';

	if ($type == 'ss-callout') {
		$output .= '<div class="ss-callout row row-fluid">';
		$output .= '<div class="col-md-9 callout-body">';
		$output .= '<h3>'.$title.'</h3>';
		$output .= '<p>'.do_shortcode( $content ).'</p>';
		$output .= '</div>';
		$output .= '<div class="col-md-3">';
		$output .= '<a class="ss-btn btn-callout '.$size.' pull-right" href="'.$link.'" target="'.$target.'"'.$cStyles.'>'.$btn_icon.$btn_text.'</a>';
		$output .= '</div>';
		$output .= '</div>';
    }else{
    	$output .= '<div class="'.$animated_class.'"><div class="vc-alert-message '.$type.'">'.$content.'</div></div>';
    }


    return $output;
}


$supreme_vc_map["Message Box"] = array(
	"name" => __("Message Box", $shortname),
	"base" => "vc_st_box",
	"icon" => "icon-wpb-vc_st_box",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Four notification boxes. Success, Error, Info or Warning.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Message box type", $shortname),
			"param_name" => "type",
			"value" => array(__('Info', $shortname) => "info", __('Warning', $shortname) => "warning", __('Success', $shortname) => "success", __('Alert', $shortname) => "error", __('Callout', $shortname) => "ss-callout"),
			"description" => __("Select message type.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "messagebox_text",
			"heading" => __("Message text", $shortname),
			"param_name" => "content",
			"value" => __("<p>I am message box.</p>", $shortname)
		),
		array(
			"type" => "textfield",
			
			"heading" => __("Button Text", $shortname),
			"param_name" => "btn_text",
			"value" => __("Button text goes here", $shortname),
			"description" => __("Text to show in button.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('ss-callout'))
	    ),
	    array(
			"type" => "textfield",
			
			"heading" => __("Button Link", $shortname),
			"param_name" => "link",
			"value" => __("http://", $shortname),
			"description" => __("Link for button.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('ss-callout'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Target", $shortname),
			"param_name" => "target",
			"value" => $button_target_arr,
			"dependency" => Array('element' => "type", 'value' => array('ss-callout'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Button size", $shortname),
			"param_name" => "size",
			"value" => $button_size_arr,
			"description" => __("Select button size.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('ss-callout'))
	    ),
	    array(
			"type" => "colorpicker",
			
			"heading" => __("Background color", $shortname),
			"param_name" => "background",
			"value" => '#3498db', //Default Red color
			"description" => __("Choose button background color", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('ss-callout'))
	    ),
	    array(
			"type" => "colorpicker",
			
			"heading" => __("Text color", $shortname),
			"param_name" => "color",
			"value" => '#ffffff', //Default Red color
			"description" => __("Choose button text color", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('ss-callout'))
	    ),
	    array(
			"type" => "supreme_choose_icons",
			"heading" => __("Icon", $shortname),
			"param_name" => "icon",
			"value" => 'ambulance',
			"dependency" => Array('element' => "type", 'value' => array('ss-callout'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Icon size", $shortname),
			"param_name" => "icon_size",
			"value" => array(__("1", $shortname) => "icon-1", __("2", $shortname) => "icon-2", __("3", $shortname) => "icon-3", __("4", $shortname) => "icon-4", __("5", $shortname) => "icon-5", __("6", $shortname) => "icon-6",),
			"dependency" => Array('element' => "type", 'value' => array('ss-callout'))
	    ),
		$vc_st_animation,
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", $shortname),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", $shortname)
		)
	)
);


/* SUPREME ICONS */

add_shortcode('vc_st_icon','SupremeShortcodes__icon');
function SupremeShortcodes__icon( $params ) {
    extract( shortcode_atts( array(
            'type'      => '',
            'icon_size'      => '',
            'icon'     => '',
            'icon_melon_name'     => '',
            'icon_type'     => '',
            'icon_color'     => '',
            'icon_bg_color'     => '',
            'icon_border_color'     => '',
            'social_icon'     => '',
            'link'     => '',
            'align'     => '',
            'target'     => '',
            'vc_st_css_animation'     => '',
        	'icon_spin'  	=> ''
        ), $params ) );

    $output = '';
    $padding = '';
    $dimensions = '';
    $spin = '';

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

    $final_size = str_replace("icon-", "st-size-", $icon_size);

    if ($align && $align !== 'ss-none') {
		$final_align = $align;
	}else{
		$final_align = 'ss-no-align';
	}

    if ($vc_st_css_animation !== '') {
		$animated_class = ' wpb_animate_when_almost_visible wpb_'.$vc_st_css_animation.' '.$final_align;
	}else{
		$animated_class = $final_align;
	}

	if ($icon_type !== 'normal') {
    	$final_icon_type = $icon_type;
    }else{
    	$final_icon_type = '';
    }

    if ($icon_bg_color == '' || $icon_type == 'normal') {
    	$bg_color = 'transparent';
    }else{
    	$bg_color = $icon_bg_color;
    }

    if ($icon_border_color == '' || $icon_type == 'normal') {
    	$border = 'transparent';
    }else{
    	$border = $icon_border_color;
    }

    if (empty($icon_bg_color) && empty($icon_border_color) || $icon_type == 'normal') {
    	$padding = ' padding: 0px; ';
    	$dimensions = 'width: auto; height: auto; margin-right: 5px;';
    }

    // FONT AWESOME
    if ($type == 'font_awesome') {

    	$output = '<div class="'.$animated_class.'"><span class="'.$final_align.'"><span class="'.$final_icon_type.' iconwrapp size-'.$final_size.'" style="'.$dimensions.$padding.'border: 1px solid '.$border.'; background: '.$bg_color.';"><i class="fa fa-'.$icon.$spin.' '.$final_size.'" style="color:'.$icon_color.'"></i></span></span></div>';
   
   	}else if ($type == 'icon_melon'){

    	$output = '<div class="'.$animated_class.'"><span class="'.$final_align.'"><span class="'.$final_icon_type.' iconwrapp size-'.$final_size.'" style="'.$dimensions.$padding.'border: 1px solid '.$border.'; background: '.$bg_color.';"><div class="iconmelon icon '.$final_size.'"><svg viewBox="0 0 32 32" style="fill:'.$icon_color.'"><use xlink:href="#'.$icon_melon_name.'"></use></svg></div></span></span></div>';

   	// SOCIAL
    }else{

    	$output = '<div class="'.$animated_class.'"><span class="'.$final_align.'"><a class="'.$social_icon.' st-social-icons " href="'.$link.'" target="'.$target.'"></a></span></div>';

    }

    return $output;
    
}

$supreme_vc_map["Icons"] = array(
	"name" => __("Icons", $shortname),
	"base" => "vc_st_icon",
	"icon" => "icon-wpb-vc_st_icon",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Font awesome, Icon Melon and Social icons', $shortname),
	"admin_enqueue_js" => array(plugins_url().'/SupremeShortcodes/js/iconmelon/icons.js'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Icon type", $shortname),
			"param_name" => "type",
			"value" => array(__('Font awesome', $shortname) => "font_awesome", __('Icon Melon', $shortname) => "icon_melon", __('Social', $shortname) => "social"),
			"description" => __("Select icon type.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "dropdown",
			"heading" => __("Social Icon", $shortname),
			"param_name" => "social_icon",
			"value" => array(
				__("Facebook", $shortname) => "social_facebook", 
				__("Twitter", $shortname) => "social_twitter",
				__("YouTube", $shortname) => "social_youtube",
				__("Google+", $shortname) => "social_google",
				__("Pinterest", $shortname) => "social_pinterest",
				__("LinkedIn", $shortname) => "social_linkedin",
				__("Blogger", $shortname) => "social_blogger",
				__("Flickr", $shortname) => "social_flickr",
				__("LastFM", $shortname) => "social_lastfm",
				__("Myspace", $shortname) => "social_myspace",
				__("Reddit", $shortname) => "social_reddit",
				__("Vimeo", $shortname) => "social_vimeo",
				__("Instagram", $shortname) => "social_instagram",
				__("Dribble", $shortname) => "social_dribble",
				__("RSS", $shortname) => "social_rss",
				__("Dropbox", $shortname) => "social_dropbox",
				__("Yahoo", $shortname) => "social_yahoo",
				__("Behance", $shortname) => "social_behance",
				__("Picasa", $shortname) => "social_picasa",
				__("Skype", $shortname) => "social_skype",
				__("Soundcloud", $shortname) => "social_soundcloud",
				__("Grooveshark", $shortname) => "social_gshark",
				__("Digg", $shortname) => "social_digg",
				__("Tumbler", $shortname) => "social_tumblr",
				__("Apple Store", $shortname) => "social_applestore",
				__("Deviantart", $shortname) => "social_dart",
				__("Stumbleupon", $shortname) => "social_stumble",
				__("WordPress", $shortname) => "social_wp",
				__("Wikki", $shortname) => "social_wiki",
				__("Github", $shortname) => "social_github",
				__("Android", $shortname) => "social_android",
				__("Mixcloud", $shortname) => "social_mixcloud"
			),
			"dependency" => Array('element' => "type", 'value' => array('social')),
			"admin_label" => true
	    ),
		array(
			"type" => "textfield",
			
			"heading" => __("Social Button Link", $shortname),
			"param_name" => "link",
			"value" => __("http://", $shortname),
			"description" => __("Link to the network.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('social'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Target", $shortname),
			"param_name" => "target",
			"value" => $button_target_arr,
			"dependency" => Array('element' => "type", 'value' => array('social'))
	    ),
	    array(
			"type" => "supreme_choose_icons",
			"heading" => __("Icon", $shortname),
			"param_name" => "icon",
			"value" => 'ambulance',
			"dependency" => Array('element' => "type", 'value' => array('font_awesome'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Spin?", $shortname),
			"param_name" => "icon_spin",
			"value" => array(
					__("No", $shortname) => "no",
					__("Yes", $shortname) => "yes"
				),
			"description" => __("If yes, icon will rotate clockwise.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('font_awesome'))
	    ),
	    array(
			"type" => "supreme_choose_icons_melon",
			"heading" => __("Icon", $shortname),
			"param_name" => "icon_melon_name",
			"value" => 'arrow-target',
			"dependency" => Array('element' => "type", 'value' => array('icon_melon'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "icon_type",
			"value" => array(__("Normal", $shortname) => "normal", __("Circle", $shortname) => "circle", __("Square", $shortname) => "square" ),
			"dependency" => Array('element' => "type", 'value' => array('font_awesome', 'icon_melon'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Icon size", $shortname),
			"param_name" => "icon_size",
			"value" => array(__("1", $shortname) => "icon-1", __("2", $shortname) => "icon-2", __("3", $shortname) => "icon-3", __("4", $shortname) => "icon-4", __("5", $shortname) => "icon-5", __("6", $shortname) => "icon-6",),
			"dependency" => Array('element' => "type", 'value' => array('font_awesome', 'icon_melon'))
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Icon color", $shortname),
			"param_name" => "icon_color",
			"value" => '#333333', //Default
			"description" => __("Choose icon color", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('font_awesome', 'icon_melon'))
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Background color", $shortname),
			"param_name" => "icon_bg_color",
			"value" => '', //Default
			"description" => __("Note: This applies only for Icon Type circle or square.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('font_awesome', 'icon_melon'))
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Border color", $shortname),
			"param_name" => "icon_border_color",
			"value" => '', //Default
			"description" => __("Note: This applies only for Icon Type circle or square.", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('font_awesome', 'icon_melon'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Align", $shortname),
			"param_name" => "align",
			"value" => array(__("None", $shortname) => "ss-none", __("Left", $shortname) => "ss-left", __("Center", $shortname) => "ss-center", __("Right", $shortname) => "ss-right")
	    ),
		$vc_st_animation
	)
);


/* SUPREME SHARE */

add_shortcode('vc_st_share','SupremeShortcodes__share');
function SupremeShortcodes__share( $params ) {
    extract( shortcode_atts( array(
            'type'       => '',
            'tw_style'   => '',
            'url'      	 => '',
            'source'     => '',
            'related'    => '',
            'text'       => '',
            'lang'       => '',
            'title'      => '',
            'fb_style'   => '',
            'show_faces' => '',
            'width'      => '',
            'verb'       => '',
            'font'       => '',
            'dig_style'  => '',
            'li_style'   => '',
            'g_style'    => '',
            'size'       => '',
            'pin_style'  => '',
            'tumb_style' => ''
        ), $params ) );


    // TWITTER
    if ($type == 'share_twitter') {
    	if ( $url )
			$output .= ' data-url="'.$url.'"';
			
		if ( $source )
			$output .= ' data-via="'.$source.'"';
		
		if ( $text ) 
			$output .= ' data-text="'.$text.'"';

		if ( $related ) 			
			$output .= ' data-related="'.$related.'"';

		if ( $lang ) 			
			$output .= ' data-lang="'.$lang.'"';

    	return "<div class='theme-twitter'><a href='http://twitter.com/share' class='twitter-share-button' {$output} data-count='{$tw_style}'>Tweet</a><script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script></div>";
    
    // DIGG
    }else if($type == 'share_digg'){

    	global $post;

		$supremeshortcodes_path = plugins_url('images/', __FILE__);
		
		// Add custom title
		if ( $title ){
			$final_title = '&amp;title='.urlencode( $title );
		}
			
		// Add custom URL
		if ( $url !== '' ) {
			$final_link = ' href="http://digg.com/submit?phase=2&url='.urlencode( $url ).$final_title.'"';
		}else{
			$url = get_permalink( $post->ID );
			$final_link = ' href="http://digg.com/submit?phase=2&url='.urlencode( $url ).$final_title.'"';
		}
			
		return "{$output}<div class='theme-digg'><a class='DiggThisButton Digg{$dig_style}'{$final_link} target='_blank'><img alt='Digg' src='{$supremeshortcodes_path}digg-button-{$dig_style}.gif' /></a></div>";


    // FACEBOOK LIKE
    }else if($type == 'share_fb_like'){

		global $post;
		
		if ( ! $post ) {
			
			$post = new stdClass();
			$post->ID = 0;
			
		} // End IF Statement
		
		$allowed_styles = array( 'standard', 'button_count', 'box_count' );
		
		if ( ! in_array( $fb_style, $allowed_styles ) ) { $fb_style = 'standard'; } // End IF Statement		
		
		if ( !$url )
			$url = get_permalink($post->ID);
		
		$height = '60';	
		if ( $show_faces == 'true')
			$height = '100';
		
		if ( ! $width || ! is_numeric( $width ) ) { $width = 450; } // End IF Statement

    	return "<iframe src='http://www.facebook.com/plugins/like.php?href=".$url."&amp;layout=".$fb_style."&amp;show_faces=".$show_faces."&amp;action=like&amp;colorscheme=light' scrolling='no' frameborder='0' allowTransparency='true'></iframe>";

    // FACEBOOK SHARE
    }else if($type == 'share_fb'){

    	global $post;

		if ($url == '') { 
			$url = get_permalink($post->ID); 
		}

    	return "<a class='fb_share' name='fb_share' type='box_count' href='#' onclick='window.open(\"https://www.facebook.com/sharer/sharer.php?u=\"+encodeURIComponent(location.href), \"facebook-share-dialog\", \"width=626,height=436\"); return false;'>FB Share</a>";

    // LINKEDIN
    }else if($type == 'share_linkedin'){

		global $float;
		
		$allowed_floats = array( 'left' => 'fl', 'right' => 'fr', 'none' => '' );
		$allowed_styles = array( 'top' => ' data-counter="top"', 'right' => ' data-counter="right"', 'none' => '' );
		
		if ( ! in_array( $float, array_keys( $allowed_floats ) ) ) { $float = 'none'; }
		if ( ! in_array( $li_style, array_keys( $allowed_styles ) ) ) { $li_style = 'none'; }
		
		if ( $url ) { $url = ' data-url="' . esc_url( $url ) . '"'; }
		
		$output = '';
		
		if ( $float == 'none' ) {} else { $output .= '<div class="shortcode-linkedin_share ' . $allowed_floats[$float] . '">' . "\n"; }
		
		$output .= '<div class="theme-lishare"><script type="IN/Share" ' . $url . $allowed_styles[$li_style] . '></script></div>' . "\n";
		
		if ( $float == 'none' ) {} else { $output .= '</div>' . "\n"; }
		
		// Enqueue the LinkedIn button JavaScript from their API.
		add_action( 'wp_footer', 'SupremeShortcodes__linkedin_js' );

    	return $output;

    // GOOGLE PLUS
    }else if($type == 'share_gplus'){

		$output = '';

		// Style
		if ( $g_style == "inline" ){
			$annotation = 'data-annotation="inline"';
			$width = 'data-width="300"';
		}elseif ( $g_style == "bubble" ){
			$annotation = '';
			$width = '';
		}elseif ( $g_style == "none" ){
			$annotation = 'data-annotation="none"';
			$width = '';
		}else{}

		// Size
		if ( $size == "small" ){
			$data_size = 'data-size="small"';
		}elseif ( $size == "medium" ){
			$data_size = 'data-size="medium"';
		}elseif ( $size == "standard" ){
			$data_size = '';
		}elseif ( $size == "tall" ){
			$data_size = 'data-size="tall"';
		}else{}


		$output .= '<div class="g-plusone" '.$data_size.' '.$annotation.' '.$width.'></div>';
		$output .= '<script type="text/javascript">
					  (function() {
					    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
					    po.src = \'https://apis.google.com/js/plusone.js\';
					    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>';

		return $output;

    // PINTEREST
    }else if($type == 'share_pinterest'){

		$output = '';

		global $post;

		if ( $pin_style == "above" ){
			$config = 'above';
		}elseif ( $pin_style == "beside" ){
			$config = 'beside';
		}elseif ( $pin_style == "none" ){
			$config = 'none';
		}else{}

		$output = '<a href="//pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&media='.urlencode(the_post_thumbnail($post->ID)).'" data-pin-do="buttonPin" data-pin-config="'.$config.'"><img alt="Pin" src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';

		return $output;

    // TUMBLER
    }else if($type == 'share_tumblr'){

		$output = '';

		global $post;

		if ( $tumb_style == "plus" ){
			$img = 'share_1';
			$width = '81';
		}elseif ( $tumb_style == "standard" ){
			$img = 'share_2';
			$width = '61';
		}elseif ( $tumb_style == "icon_text" ){
			$img = 'share_3';
			$width = '129';
		}elseif ( $tumb_style == "icon" ){
			$img = 'share_4';
			$width = '20';
		}else{}

		$output = '<a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:'.$width.'px; height:20px; background:url(\'http://platform.tumblr.com/v1/'.$img.'.png\') top left no-repeat transparent;">Share on Tumblr</a>';

		return $output;

    }
    
}

function SupremeShortcodes__linkedin_js () {
	echo '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>' . "\n";
}

$supreme_vc_map["Share Buttons"] = array(
	"name" => __("Share Buttons", $shortname),
	"base" => "vc_st_share",
	"icon" => "icon-wpb-vc_st_share",
	"category" => array(__('Social', $shortname), __('Supreme', $shortname)),
	"description" => __('Social sharing buttons such as: Facebook, Twitter, Google + etc', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Sharing platform", $shortname),
			"param_name" => "type",
			"value" => array(
						__('Twitter', $shortname) => "share_twitter", 
						__('Digg', $shortname) => "share_digg", 
						__('Facebook Like', $shortname) => "share_fb_like", 
						__('Facebook Share', $shortname) => "share_fb", 
						__('LinkedIn', $shortname) => "share_linkedin", 
						__('Google+', $shortname) => "share_gplus", 
						__('Pinterest', $shortname) => "share_pinterest", 
						__('Tumbler', $shortname) => "share_tumblr"
			),
			"description" => __("Select sharing platform.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			
			"heading" => __("URL", $shortname),
			"param_name" => "url",
			"value" => __("http://", $shortname),
			"description" => __("Specify URL directly. (Optional. Defaults to the page/post URL.)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('share_twitter', 'share_digg', 'share_fb_like', 'share_fb', 'share_linkedin'))
	    ),
		//Twitter
		array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "tw_style",
			"value" => array(__('Vertical (default)', $shortname) => "vertical", __('Horizontal', $shortname) => "horizontal"),
			"dependency" => Array('element' => "type", 'value' => array('share_twitter'))
	    ),
	    array(
			"type" => "textfield",
			
			"heading" => __("Source", $shortname),
			"param_name" => "source",
			"value" => __("", $shortname),
			"description" => __("Username to mention in tweet. (Optional)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('share_twitter'))
	    ),
	    array(
			"type" => "textfield",
			
			"heading" => __("Related", $shortname),
			"param_name" => "related",
			"value" => __("", $shortname),
			"description" => __("Related account. (Optional)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('share_twitter'))
	    ),
	    array(
			"type" => "textfield",
			
			"heading" => __("Text", $shortname),
			"param_name" => "text",
			"value" => __("", $shortname),
			"description" => __("Tweet text (Optional, default: title of page).", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('share_twitter'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Language", $shortname),
			"param_name" => "lang",
			"value" => array(__('English (default)', $shortname) => "en", __('French', $shortname) => "fr", __('Deutch', $shortname) => "de", __('Spain', $shortname) => "es", __('Japanise', $shortname) => "js"),
			"dependency" => Array('element' => "type", 'value' => array('share_twitter'))
	    ),
	    //Facebook
	    array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "fb_style",
			"value" => array(__('Standard (default)', $shortname) => "standard", __('Button count', $shortname) => "button_count", __('Box count', $shortname) => "box_count" ),
			"dependency" => Array('element' => "type", 'value' => array('share_fb_like'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Show faces?", $shortname),
			"param_name" => "faces",
			"value" => array(__('Yes', $shortname) => "true", __('No', $shortname) => "false"),
			"dependency" => Array('element' => "type", 'value' => array('share_fb_like'))
	    ),
	    array(
			"type" => "textfield",
			"holder" => "div",
			"heading" => __("Width", $shortname),
			"param_name" => "width",
			"value" => __("", $shortname),
			"description" => __("Set the width of this button in pixels. Note: numbers only. Eg: 200", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('share_fb_like'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Verb to display", $shortname),
			"param_name" => "verb",
			"value" => array(__('Like (default)', $shortname) => "like", __('Recommend', $shortname) => "recommend"),
			"dependency" => Array('element' => "type", 'value' => array('share_fb_like'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Choose font", $shortname),
			"param_name" => "font",
			"value" => array(__('Arial (default)', $shortname) => "arial", __('Lucida Grande', $shortname) => "lucida grande", __('Segoe Ui', $shortname) => "segoe ui", __('Tahoma', $shortname) => "tahoma", __('Trebuchet MS', $shortname) => "trebuchet ms", __('Verdana', $shortname) => "verdana"),
			"dependency" => Array('element' => "type", 'value' => array('share_fb_like'))
	    ),
	    //Digg
	    array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "dig_style",
			"value" => array(__('Medium (default)', $shortname) => "medium", __('Large', $shortname) => "large", __('Compact', $shortname) => "compact", __('Icon', $shortname) => "icon"),
			"dependency" => Array('element' => "type", 'value' => array('share_digg'))
	    ),
	    array(
			"type" => "textfield",
			
			"heading" => __("Title", $shortname),
			"param_name" => "title",
			"value" => __("", $shortname),
			"description" => __("Specify title directly (Optional, must add link also).", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('share_digg'))
	    ),
	    //LinkedIn
	    array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "li_style",
			"value" => array(__('No counter (default)', $shortname) => "none", __('Top', $shortname) => "top", __('Right', $shortname) => "right"),
			"dependency" => Array('element' => "type", 'value' => array('share_linkedin'))
	    ),
	    //Google Plus
	    array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "g_style",
			"value" => array(__('Inline', $shortname) => "inline", __('Bubble', $shortname) => "bubble", __('None', $shortname) => "none"),
			"dependency" => Array('element' => "type", 'value' => array('share_gplus'))
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "size",
			"value" => array(__('Small', $shortname) => "small", __('Medium', $shortname) => "medium", __('Standard', $shortname) => "standard", __('Tall', $shortname) => "tall"),
			"dependency" => Array('element' => "type", 'value' => array('share_gplus'))
	    ),
	    //Pinterest
	    array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "pin_style",
			"value" => array(__('Above', $shortname) => "above", __('Beside', $shortname) => "beside", __('None', $shortname) => "none"),
			"dependency" => Array('element' => "type", 'value' => array('share_pinterest'))
	    ),
	    //Tumbler
	    array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "tumb_style",
			"value" => array(__('Plus', $shortname) => "plus", __('Standard', $shortname) => "standard", __('Icon + Text', $shortname) => "icon_text", __('Icon', $shortname) => "icon" ),
			"dependency" => Array('element' => "type", 'value' => array('share_tumblr'))
	    )
	)
);


/* SUPREME CONTACT FORM */

add_shortcode('vc_st_contact','SupremeShortcodes__contact_form');
function SupremeShortcodes__contact_form( $params ) {
    extract( shortcode_atts( array(
                'type'      	=> '',
                'email'      	=> '',
                'vc_st_css_animation' => ''
            ), $params ) );

    global $shortname, $post;

    if ($vc_st_css_animation !== '') {
		$animated_class = ' wpb_animate_when_almost_visible wpb_'.$vc_st_css_animation;
	}else{
		$animated_class = '';
	}

	$id = uniqid();
    $tabindex_1 = $id;
    $tabindex_2 = $id + 1;
    $tabindex_3 = $id + 2;
    $tabindex_4 = $id + 3;
    $tabindex_5 = $id + 4;
    $name_str = __( 'NAME ', $shortname );
    $email_str = __( 'EMAIL', $shortname );
    $submit_str = __( 'SUBMIT', $shortname );
    $content_str = __( 'MESSAGE', $shortname );
    $enter_captcha = __( 'CAPTCHA', $shortname );

    $email = antispambot($email);

	// CONTACT FORM LIGHT
    if ($type == 'contact_form_light') {

	    $output .= '<div id="contact-form-'.$id.'" class="ss-contact-form-wrapper classic-style ss-light-style">';
	    $output .= '    <form class="contact_form_light ss-contact-form" method="post" novalidate="novalidate">';
	    $output .= '        <div class="ss-form-row row-left">
	                            <input placeholder="'.$name_str.'" type="text" required="required" name="contact_name" class="text-input" value="" tabindex="'.$tabindex_1.'" />
	                        </div>';
	    $output .= '        <div class="ss-form-row row-right">
	                            <input placeholder="'.$email_str.'" type="email" required="required" name="contact_email" class="text-input" value="" tabindex="'.$tabindex_2.'" />
	                            </div>';
	    $output .= '        <textarea required="required" placeholder="'.$content_str.'" name="contact_content" class="ss-textarea" tabindex="'.$tabindex_4.'"></textarea>';
	    
	   
	    // CAPTCHA 
	    $output .= '<div class="ss-form-row">
	                    <input placeholder="'.$enter_captcha.'" type="text" name="captcha" class="captcha-form text-input full" required="required" autocomplete="off" />
	                        <img src="'.plugins_url().'/SupremeShortcodes/captcha/captcha.php" class="captcha-image" alt="captcha txt"> 
	                        <a href="#" class="captcha-change-image"></a>
	                </div>';   

	    $output .= '        <div class="button-row">
	                            <button tabindex="'.$tabindex_5.'" class="ss-progress-button ss-button  outline-button medium" data-style="move-up">
	                                <span class="ss-progress-button-content">'.$submit_str.'</span>
	                                <span class="ss-progress">
	                                    <span class="ss-progress-inner"></span>
	                                </span>
	                                <span class="state-success"><i class="ss-icon-check"></i></span>
	                                <span class="state-error"><i class="ss-icon-times"></i></span>
	                            </button>
	                        </div>';
	    $output .= '        <i class="ss-contact-loading ss-icon-refresh"></i>';
	    $output .= '        <i class="ss-contact-success ss-theme-icon-tick"></i>';
	    $output .= '        <input type="hidden" value="'.$email.'" name="contact_to"/>';
	    $output .= '    </form>';
	    $output .= '    <div class="clearboth"></div>';
	    $output .= '</div>';

		return "<div class='{$animated_class}'>{$output}</div>";

    }else{

	    $output .= '<div id="contact-form-'.$id.'" class="ss-contact-form-wrapper classic-style ss-dark-style">';
	    $output .= '    <form class="contact_form_dark ss-contact-form" method="post" novalidate="novalidate">';
	    $output .= '        <div class="ss-form-row row-left">
	                            <input placeholder="'.$name_str.'" type="text" required="required" name="contact_name" class="text-input" value="" tabindex="'.$tabindex_1.'" />
	                        </div>';
	    $output .= '        <div class="ss-form-row row-right">
	                            <input placeholder="'.$email_str.'" type="email" required="required" name="contact_email" class="text-input" value="" tabindex="'.$tabindex_2.'" />
	                            </div>';
	    $output .= '        <textarea required="required" placeholder="'.$content_str.'" name="contact_content" class="ss-textarea" tabindex="'.$tabindex_4.'"></textarea>';
	    
	   
	    // CAPTCHA 
	    $output .= '<div class="ss-form-row">
	                    <input placeholder="'.$enter_captcha.'" type="text" name="captcha" class="captcha-form text-input full" required="required" autocomplete="off" />
	                        <img src="'.plugins_url().'/SupremeShortcodes/captcha/captcha.php" class="captcha-image" alt="captcha txt"> 
	                        <a href="#" class="captcha-change-image"></a>
	                </div>';   

	    $output .= '        <div class="button-row">
	                            <button tabindex="'.$tabindex_5.'" class="ss-progress-button ss-button outline-button medium" data-style="move-up">
	                                <span class="ss-progress-button-content">'.$submit_str.'</span>
	                                <span class="ss-progress">
	                                    <span class="ss-progress-inner"></span>
	                                </span>
	                                <span class="state-success"><i class="ss-icon-check"></i></span>
	                                <span class="state-error"><i class="ss-icon-times"></i></span>
	                            </button>
	                        </div>';
	    $output .= '        <i class="ss-contact-loading ss-icon-refresh"></i>';
	    $output .= '        <i class="ss-contact-success ss-theme-icon-tick"></i>';
	    $output .= '        <input type="hidden" value="'.$email.'" name="contact_to"/>';
	    $output .= '    </form>';
	    $output .= '    <div class="clearboth"></div>';
	    $output .= '</div>';

    	return "<div class='{$animated_class}'>{$output}</div>";
    }
    
}

$supreme_vc_map["Contact Forms"] = array(
	"name" => __("Contact Form", $shortname),
	"base" => "vc_st_contact",
	"icon" => "icon-wpb-vc_st_contact",
	"category" => array(__('Content', $shortname),__('Supreme', $shortname) ),
	"description" => __('Light and dark contact form, with captcha.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Color", $shortname),
			"param_name" => "type",
			"value" => array(__('Light', $shortname) => "contact_form_light", __('Dark', $shortname) => "contact_form_dark"),
			"description" => __("Select form styling.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			
			"heading" => __("Email", $shortname),
			"param_name" => "email",
			"value" => __("your-email@domain.com", $shortname),
			"description" => __("Email where submitted form will go to.", $shortname)
	    ),
		$vc_st_animation
	)
);



/* SUPREME GOOGLE MAPS */

add_shortcode('vc_st_google_maps','SupremeShortcodes__google_maps');
function SupremeShortcodes__google_maps( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'width' => '400',
		'height' => '300',
		'longitute' => '',
		'latitude' => '',
		'color' => '',
		'zoom'	=> '',
		'html' => '',
		'maptype' => ''
	), $atts));

	$output = '';

	$id = rand(100,1000);

	if ($maptype == 'ROADMAP') {
  		$mapActive = 'MY_MAPTYPE_ID_'.$id;
  	}else{
  		$mapActive = 'google.maps.MapTypeId.'.$maptype;
  	};


	$output .= '<script>';
	$output .= '      	var map;'."\r\n".'';
	$output .= '      	var supremeCoords_'.$id.' = new google.maps.LatLng('.$latitude.', '.$longitute.');'."\r\n".'';

	$output .= '      	var MY_MAPTYPE_ID_'.$id.' = "custom_style_'.$id.'";'."\r\n".'';


	$output .= '      	function initialize() {'."\r\n".'';

	$output .= '	        var featureOpts = ['."\r\n".'';
	$output .= '	          	{'."\r\n".'';
	$output .= '			      	stylers: ['."\r\n".'';
	$output .= '				        	{ hue: "'.$color.'" },'."\r\n".'';
	$output .= '				        	{ saturation: -20 }'."\r\n".'';
	$output .= '				      	]'."\r\n".'';
	$output .= '				}'."\r\n".'';
	$output .= '	        ];'."\r\n".'';

	$output .= '	        var mapOptions = {'."\r\n".'';
	$output .= '	          	zoom: '.$zoom.','."\r\n".'';
	$output .= '	          	center: supremeCoords_'.$id.','."\r\n".'';
	$output .= '	          	scrollwheel: false,'."\r\n".'';
	$output .= '	          	mapTypeControl: true,'."\r\n".'';
	$output .= '	          	mapTypeControlOptions: {'."\r\n".'';
	$output .= '	            	mapTypeIds: [google.maps.MapTypeId.'.$maptype.', MY_MAPTYPE_ID_'.$id.']'."\r\n".'';
	$output .= '	          	},'."\r\n".'';
	$output .= '				zoomControl: true,'."\r\n".'';
	$output .= '				zoomControlOptions: {'."\r\n".'';
	$output .= '					style: google.maps.ZoomControlStyle.SMALL'."\r\n".'';
	$output .= '				},'."\r\n".'';
	$output .= '				panControl: true,'."\r\n".'';
	$output .= '			    scaleControl: true,'."\r\n".'';
	$output .= '	          	mapTypeId: '.$mapActive."\r\n".'';
	$output .= '	        };'."\r\n".'';

	$output .= '	       	map = new google.maps.Map(document.getElementById("map-canvas_'.$id.'"),mapOptions);'."\r\n".'';

	$output .= '	        var styledMapOptions = {'."\r\n".'';
	$output .= '	          	name: "Supreme Map"'."\r\n".'';
	$output .= '	        };'."\r\n".'';

	$output .= '        	var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);'."\r\n".'';

	$output .= '       		map.mapTypes.set(MY_MAPTYPE_ID_'.$id.', customMapType);'."\r\n".'';


	$output .= '  			var infowindow = new google.maps.InfoWindow({'."\r\n".'';
	$output .= '      			content: \''.$html.'\', '."\r\n".'';
	$output .= '  			});'."\r\n".'';

	$output .= '  			var marker = new google.maps.Marker({'."\r\n".'';
	$output .= '      			position: supremeCoords_'.$id.','."\r\n".'';
	$output .= '      			map: map,'."\r\n".'';
	$output .= '				animation: google.maps.Animation.DROP'."\r\n".'';
	$output .= '  			});'."\r\n".'';

	if ($html !== '') {
		$output .= '			infowindow.open(map, marker);';
	}

	$output .= '  			google.maps.event.addListener(marker, \'click\', function() {'."\r\n".'';
	$output .= '    			infowindow.open(map,marker);'."\r\n".'';
	$output .= '  			});'."\r\n".'';


	$output .= '    	}'."\r\n".'';

	$output .= '    	google.maps.event.addDomListener(window, "load", initialize);'."\r\n".'';

	$output .= '    </script>'."\r\n".'';
	$output .= '    <style>'."\r\n".'';
	$output .= '    	#map-canvas_'.$id.' img { '."\r\n".'';
	$output .= '			width: auto; '."\r\n".'';
	$output .= '			display: inline; '."\r\n".'';
	$output .= '			max-width: none;'."\r\n".'';
	$output .= '		}'."\r\n".'';
	$output .= '   </style>'."\r\n".'';
	$output .= '	<div id="map-canvas_'.$id.'" style="width: '.$width.'px; height: '.$height.'px;"></div>'."\r\n".'';


	return $output;

}

$supreme_vc_map["Google Maps"] = array(
	"name" => __("Google Maps", $shortname),
	"base" => "vc_st_google_maps",
	"icon" => "icon-wpb-vc_st_google_maps",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Amazing google maps in four style and unlimited colors.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "maptype",
			"value" => array(__('Road map', $shortname) => "ROADMAP", __('Satellite', $shortname) => "SATELLITE", __('Hybrid', $shortname) => "HYBRID", __('Terrain', $shortname) => "TERRAIN"),
			"description" => __("Select map type.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("Width", $shortname),
			"param_name" => "width",
			"value" => __("", $shortname),
			"description" => __("(Optional)", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Height", $shortname),
			"param_name" => "height",
			"value" => __("", $shortname),
			"description" => __("(Optional)", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Latitude", $shortname),
			"param_name" => "latitude",
			"value" => __("", $shortname),
			"description" => __("Example: 51.519586", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("longitute", $shortname),
			"param_name" => "longitute",
			"value" => __("", $shortname),
			"description" => __("Example: -0.102474 <br><br><br>To convert an address into latitude & longitude please use this converter: <br><a href=\"http://www.latlong.net/convert-address-to-lat-long.html\" target=\"_blank\">Convert address to latitude and longotude.</a>", $shortname)
	    ),
	    array(
			"type" => "colorpicker",
			
			"heading" => __("Map color", $shortname),
			"param_name" => "color",
			"value" => '#3498db',
			"description" => __("Choose map color.", $shortname),
			"dependency" => Array('element' => "maptype", 'value' => array('ROADMAP'))
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Zoom", $shortname),
			"param_name" => "zoom",
			"value" => __("", $shortname),
			"description" => __("Zoom value from 1 to 19.", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Content for the marker", $shortname),
			"param_name" => "html",
			"value" => __("", $shortname),
			"description" => __("Content for the marker. (Optional)", $shortname)
	    )

	)
);


/* SUPREME GOOGLE TRENDS */

add_shortcode('vc_st_google_trends','SupremeShortcodes__google_trends');
function SupremeShortcodes__google_trends( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'width' => '665',
		'height' => '330',
		'query' => '',
		'geo' => 'US'
	), $atts));

	$output = '';

	$output = '<script type="text/javascript" src="http://www.google.com/trends/embed.js?hl=en-US&q='.$query.'&geo='.$geo.'&cmpt=q&content=1&cid=TIMESERIES_GRAPH_0&export=5&w='.$width.'&h='.$height.'"></script>';

	return $output;

}

$supreme_vc_map["Google Trends"] = array(
	"name" => __("Google Trends", $shortname),
	"base" => "vc_st_google_trends",
	"icon" => "icon-wpb-vc_st_google_trends",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Explore Google trending search topics.', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Width", $shortname),
			"param_name" => "width",
			"value" => __("", $shortname),
			"description" => __("(Optional)", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Height", $shortname),
			"param_name" => "height",
			"value" => __("", $shortname),
			"description" => __("(Optional)", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Query", $shortname),
			"param_name" => "query",
			"value" => __("", $shortname),
			"description" => __("Example: facebook, pinterest, twitter", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Geo", $shortname),
			"param_name" => "geo",
			"value" => __("", $shortname),
			"description" => __("Example: US", $shortname)
	    )

	)
);


/* SUPREME GOOGLE DOCS */

add_shortcode('vc_st_google_docs','SupremeShortcodes__google_docs');
function SupremeShortcodes__google_docs( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'width' => '500',
		'height' => '900',
		'url' => ''
	), $atts));

	$output = '';

	$output = '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" src="'.$url.'?embedded=true"></iframe>';

	return $output;

}

$supreme_vc_map["Google Docs"] = array(
	"name" => __("Google Docs", $shortname),
	"base" => "vc_st_google_docs",
	"icon" => "icon-wpb-vc_st_google_docs",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Insert Google Doc with a simple click.', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Width", $shortname),
			"param_name" => "width",
			"value" => __("", $shortname),
			"description" => __("(Optional)", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Height", $shortname),
			"param_name" => "height",
			"value" => __("", $shortname),
			"description" => __("(Optional)", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("URL", $shortname),
			"param_name" => "url",
			"value" => __("", $shortname),
			"description" => __("Required", $shortname)
	    )

	)
);


/* SUPREME GOOGLE CHARTS */

add_shortcode('vc_st_google_charts','SupremeShortcodes__google_charts');
function SupremeShortcodes__google_charts( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'gchart_title' => '',
		'type' => '',
		'pie_data' => '',
		'combo_data' => '',
		'area_data' => '',
		'geo_data' => '',
		'bubble_data' => '',
		'org_data' => '',
		'bar_data' => '',
		'primary' => 'green',
		'secondary' => '#EBE5D8',
		'vaxis' => '',
		'haxis' => '',
		'series' => ''
	), $atts));

	$output = '';

	$id = rand(100,1000);

	if ($type == 'chart_pie') {

		$data = $pie_data;
		$final_data = str_replace(array("(", ")"), array("[","]"), $atts["pie_data"]);

		$output .= '	<script type="text/javascript">';
		$output .= '      google.load("visualization", "1", {packages:["corechart"]});';
		$output .= '      google.setOnLoadCallback(drawChart);';
		$output .= '      function drawChart() {';
		$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
		$output .= '        var options = {';
		$output .= '          title: "'.$gchart_title.'",';
		$output .= '          is3D: true,';
		$output .= '        };';
		$output .= '        var chart = new google.visualization.PieChart(document.getElementById("piechart_'.$id.'"));';
		$output .= '        chart.draw(data, options);';
		$output .= '      }';
		$output .= '    </script>';
		$output .= '    <div id="piechart_'.$id.'" class="google-chart"></div>';

		return $output;

	}else if($type == 'chart_bar'){

		$data = $bar_data;
		$final_data = str_replace(array("(", ")"), array("[","]"), $atts["bar_data"]);

		$output .= '	<script type="text/javascript">';
		$output .= '      google.load("visualization", "1", {packages:["corechart"]});';
		$output .= '      google.setOnLoadCallback(drawChart);';
		$output .= '      function drawChart() {';
		$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
		$output .= '        var options = {';
		$output .= '          title: "'.$gchart_title.'",';
		$output .= '          vAxis: {title: "'.$vaxis.'",  titleTextStyle: {color: "red"}},';
		$output .= '          hAxis: {title: "'.$haxis.'",  titleTextStyle: {color: "blue"}}';
		$output .= '        };';
		$output .= '        var chart = new google.visualization.BarChart(document.getElementById("chart_'.$id.'"));';
		$output .= '        chart.draw(data, options);';
		$output .= '      }';
		$output .= '    </script>';
		$output .= '    <div id="chart_'.$id.'" class="google-chart"></div>';


		return $output;

	}else if($type == 'chart_area'){

		$data = $area_data;
		$final_data = str_replace(array("(", ")"), array("[","]"), $atts["area_data"]);
		
		$output .= '	<script type="text/javascript">';
		$output .= '      google.load("visualization", "1", {packages:["corechart"]});';
		$output .= '      google.setOnLoadCallback(drawChart);';
		$output .= '      function drawChart() {';
		$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
		$output .= '        var options = {';
		$output .= '          title: "'.$gchart_title.'",';
		$output .= '          vAxis: {title: "'.$vaxis.'",  titleTextStyle: {color: "red"}},';
		$output .= '          hAxis: {title: "'.$haxis.'",  titleTextStyle: {color: "blue"}}';
		$output .= '        };';
		$output .= '        var chart = new google.visualization.AreaChart(document.getElementById("areachart_'.$id.'"));';
		$output .= '        chart.draw(data, options);';
		$output .= '      }';
		$output .= '    </script>';
		$output .= '    <div id="areachart_'.$id.'" class="google-chart"></div>';

		return $output;

	}else if($type == 'chart_geo'){

		$data = $geo_data;
		$final_data = str_replace(array("(", ")"), array("[","]"), $atts["geo_data"]);
		
		$output .= '	<script type="text/javascript">';
		$output .= '      google.load("visualization", "1", {packages:["geochart"]});';
		$output .= '      google.setOnLoadCallback(drawRegionsMap);';
		$output .= '      function drawRegionsMap() {';
		$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
		$output .= '        var options = {';
		$output .= '        	colorAxis: {colors: [\''.$primary.'\', \''.$secondary.'\']}';
		$output .= '        };';
		$output .= '        var chart = new google.visualization.GeoChart(document.getElementById("geochart_'.$id.'"));';
		$output .= '        chart.draw(data, options);';
		$output .= '      }';
		$output .= '    </script>';
		$output .= '    <div id="geochart_'.$id.'" class="google-chart"></div>';

		return $output;

	}else if($type == 'chart_combo'){

		$data = $combo_data;
		$final_data = str_replace(array("(", ")"), array("[","]"), $atts["combo_data"]);

		$final_data = strip_tags($final_data);
		
		$output .= '	<script type="text/javascript">';
		$output .= '      	google.load("visualization", "1", {packages:["corechart"]});';
		$output .= '	    function drawVisualization() {';
		$output .= '	      	var data = google.visualization.arrayToDataTable(['.$final_data.']);';
		$output .= '	        var options = {';
		$output .= '	        	title: "'.$gchart_title.'",';
		$output .= '	          	vAxis: {title: "'.$vaxis.'"},';
		$output .= '	          	hAxis: {title: "'.$haxis.'"},';
		$output .= '				seriesType: "bars",';
		$output .= '	          	series: {'.$series.': {type: "line"}}';
		$output .= '	        };';
		$output .= '	        var chart = new google.visualization.ComboChart(document.getElementById("combo_'.$id.'"));';
		$output .= '	        chart.draw(data, options);';
		$output .= '	    }';
		$output .= '	    google.setOnLoadCallback(drawVisualization);';
		$output .= '    </script>';
		$output .= '    <div id="combo_'.$id.'" class="google-chart"></div>';

		return $output;

	}else if($type == 'chart_org'){

		$data = $org_data;
		$final_data = str_replace(array("(", ")"), array("[","]"), $atts["org_data"]);
		
		$output .= '	<script type="text/javascript">';
		$output .= '      	google.load("visualization", "1", {packages:["orgchart"]});';
		$output .= '      	google.setOnLoadCallback(drawChart);';
		$output .= '	    function drawChart() {';
		$output .= '	        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
		$output .= '	        var chart = new google.visualization.OrgChart(document.getElementById("org_'.$id.'"));';
		$output .= '	        chart.draw(data, {allowHtml:true});';
		$output .= '	    }';
		$output .= '    </script>';
		$output .= '    <div id="org_'.$id.'" class="google-chart"></div>';

		return $output;

	}else if($type == 'chart_bubble'){

		$data = $bubble_data;
		$final_data = str_replace(array("(", ")"), array("[","]"), $atts["bubble_data"]);
		
		$output .= '	<script type="text/javascript">';
		$output .= '      google.load("visualization", "1", {packages:["corechart"]});';
		$output .= '      google.setOnLoadCallback(drawRegionsMap);';
		$output .= '      function drawRegionsMap() {';
		$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
		$output .= '        var options = {';
		$output .= '        	title: "'.$gchart_title.'",';
		$output .= '        	colorAxis: {colors: [\''.$primary.'\', \''.$secondary.'\']}';
		$output .= '        };';
		$output .= '        var chart = new google.visualization.BubbleChart(document.getElementById("bubble_'.$id.'"));';
		$output .= '        chart.draw(data, options);';
		$output .= '      }';
		$output .= '    </script>';
		$output .= '    <div id="bubble_'.$id.'" class="google-chart"></div>';

		return $output;

	}

	return $output;

}

$supreme_vc_map["Google Charts"] = array(
	"name" => __("Google Charts", $shortname),
	"base" => "vc_st_google_charts",
	"icon" => "icon-wpb-vc_st_google_charts",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Various google charts all in one place.', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Title", $shortname),
			"param_name" => "gchart_title",
			"value" => __("", $shortname),
			"description" => __("Optional. Example: My Google Chart", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_bubble', 'chart_pie', 'chart_area', 'chart_combo'))
	    ),
		array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "type",
			"value" => array(
					__('Pie', $shortname) => "chart_pie", 
					__('Bar', $shortname) => "chart_bar", 
					__('Area', $shortname) => "chart_area", 
					__('Geo', $shortname) => "chart_geo", 
					__('Combo', $shortname) => "chart_combo", 
					__('Org', $shortname) => "chart_org", 
					__('Bubble', $shortname) => "chart_bubble"
			),
			"description" => __("Select map type.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textarea",
			"heading" => __("Data", $shortname),
			"param_name" => "pie_data",
			"value" => __("", $shortname),
			"description" => __("Example: ('Task', 'Hours per Day'),('Work', 11),('Sleep', 7),('Eat', 2),('Commute', 3)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_pie'))
	    ),
	    array(
			"type" => "textarea",
			"heading" => __("Data", $shortname),
			"param_name" => "combo_data",
			"value" => __("", $shortname),
			"description" => __("Example: ('Month','Bolivia','Ecuador','Madagascar','Papua New Guinea','Rwanda','Average'),<br>('2004/05',165,938,522,998,450,614.6),<br>('2005/06',135,1120,599,1268,288,682),<br>('2006/07',157,1167,587,807,397,623),<br>('2007/08',139,1110,615,968,215,609.4),<br>('2008/09',136,691,629,1026,366,569.6)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_combo'))
	    ),
	    array(
	    	"type" => "textarea",
			"heading" => __("Data", $shortname),
			"param_name" => "bar_data",
			"value" => __("", $shortname),
			"description" => __("Example: ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_bar'))
	    ),
	    array(
	    	"type" => "textarea",
			"heading" => __("Data", $shortname),
			"param_name" => "area_data",
			"value" => __("", $shortname),
			"description" => __("Example: ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_area'))
	    ),
	    array(
	    	"type" => "textarea",
			"heading" => __("Data", $shortname),
			"param_name" => "geo_data",
			"value" => __("", $shortname),
			"description" => __("Example: ('Country', 'Popularity'),('Germany', 200),('United States', 300),('Brazil', 400),('Canada', 500),('France', 600),('RU', 700)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_geo'))
	    ),
	    array(
	    	"type" => "textarea",
			"heading" => __("Data", $shortname),
			"param_name" => "org_data",
			"value" => __("", $shortname),
			"description" => __("Example: ('Name','Manager','Tooltip'),('Mike',null,'The President'),( 'Jim', 'Mike', null),('Alice', 'Mike', null), ('Alice2', 'Mike', null),('Bob','Jim', 'Bob Sponge'),('Carol', 'Bob', null),('Carol2', 'Bob', null)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_org'))
	    ),
	    array(
	    	"type" => "textarea",
			"heading" => __("Data", $shortname),
			"param_name" => "bubble_data",
			"value" => __("", $shortname),
			"description" => __("Example: ('ID', 'X', 'Y', 'Temperature'),('',80,167,120),('',79,136,130),('',78,184,50),('',72,278,230),('',81,200,210),('',72,170,100),('',68,477,80)", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_bubble'))
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Primary Color", $shortname),
			"param_name" => "primary",
			"value" => '#ede50e',
			"description" => __("Default: #ede50e", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_bubble', 'chart_geo'))
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Secondary Color", $shortname),
			"param_name" => "secondary",
			"value" => '#e00000',
			"description" => __("Default: #e00000", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_bubble', 'chart_geo'))
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Haxis", $shortname),
			"param_name" => "haxis",
			"value" => __("", $shortname),
			"description" => __("Example: Month", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_combo', 'chart_area'))
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Vaxis", $shortname),
			"param_name" => "vaxis",
			"value" => __("", $shortname),
			"description" => __("Example: Cups", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_combo', 'chart_area'))
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Series", $shortname),
			"param_name" => "series",
			"value" => __("", $shortname),
			"description" => __("Example: 5", $shortname),
			"dependency" => Array('element' => "type", 'value' => array('chart_combo'))
	    )
	)

);


/* SUPREME TOOLTIP */

add_shortcode('vc_st_tooltip','SupremeShortcodes__tooltip');
function SupremeShortcodes__tooltip( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'position' => '',
		'text' => '',
		'tooltip_text' => ''
	), $atts));
	
	return "<span class='tooltip_wrap'><a class='tooltipa' href='#' data-toggle='tooltip' data-placement='{$position}' title='' data-original-title='{$tooltip_text}'>{$text}</a></span>";

}

$supreme_vc_map["Tooltip"] = array(
	"name" => __("Tooltip", $shortname),
	"base" => "vc_st_tooltip",
	"icon" => "icon-wpb-vc_st_tooltip",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Twitter Bootstrap tooltip. Four positions.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Position", $shortname),
			"param_name" => "position",
			"value" => array(
					__('Top', $shortname) => "top", 
					__('Right', $shortname) => "right", 
					__('Bottom', $shortname) => "bottom", 
					__('Left', $shortname) => "left"
			),
			"description" => __("Select tooltip position. Tooltip will be visible on hover.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("Text", $shortname),
			"param_name" => "text",
			"value" => __("", $shortname)
	    ),
	    array(
			"type" => "textarea",
			"heading" => __("Tooltip text", $shortname),
			"param_name" => "tooltip_text",
			"value" => __("", $shortname)
	    )

	)

);


/* SUPREME POPOVER */

add_shortcode('vc_st_popover','SupremeShortcodes__popover');
function SupremeShortcodes__popover( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'position' => '',
		'title' => '',
		'popover_text' => '',
		'button_text' => ''
	), $atts));

	return "<a href='#' class='ss-btn popovers' data-toggle='popover' data-placement='{$position}' data-content='{$popover_text}' title='' data-original-title='{$title}'>{$button_text}</a>";	

}

$supreme_vc_map["Popover"] = array(
	"name" => __("Popover", $shortname),
	"base" => "vc_st_popover",
	"icon" => "icon-wpb-vc_st_popover",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Twitter Bootstrap popover. Four positions.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Position", $shortname),
			"param_name" => "position",
			"value" => array(
					__('Top', $shortname) => "top", 
					__('Right', $shortname) => "right", 
					__('Bottom', $shortname) => "bottom", 
					__('Left', $shortname) => "left"
			),
			"description" => __("Select popover position. Popover will be visible on click.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("Button text", $shortname),
			"param_name" => "button_text",
			"value" => __("", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Title", $shortname),
			"param_name" => "title",
			"value" => __("", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Popover text", $shortname),
			"param_name" => "popover_text",
			"value" => __("", $shortname)
	    )

	)

);

/* SUPREME MODAL */

add_shortcode('vc_st_modal','SupremeShortcodes__modal');
function SupremeShortcodes__modal( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'modal_title' => '',
		'modal_text' => '',
		'modal_link' => '',
		'primary_text' => '',
		'primary_link' => ''
	), $atts));

	$output = '';
	$primary_btn = '';
	
	$rnd = mt_rand();

	if ($primary_link && $primary_text !== '') {
		$primary_btn = '<a href="'.$primary_link.'" class="ss-btn primary">'.$primary_text.'</a>';
	}
	
	$output .= '<a data-toggle="modal" data-target="#'.$rnd.'" class="ss-btn primary btn-large ss-modal">'.$modal_link.'</a>';

	$output .= '<div class="modal fade" id="'.$rnd.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	$output .= '<div class="modal-dialog">';
	$output .= '<div class="modal-content">';

	$output .= '<div class="modal-header">';
	$output .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
	$output .= '<h3>'.$modal_title.'</h3>';
	$output .= '</div>';
	$output .= '<div class="modal-body"><p>'.do_shortcode( $content ).'</p></div>';
	$output .= '<div class="modal-footer"><a class="ss-btn secondary" data-dismiss="modal" aria-hidden="true">Close</a>'.$primary_btn.'</div>';

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}

$supreme_vc_map["Modal"] = array(
	"name" => __("Modal", $shortname),
	"base" => "vc_st_modal",
	"icon" => "icon-wpb-vc_st_modal",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Twitter Bootstrap popover. Four positions.', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Modal button text", $shortname),
			"param_name" => "modal_link",
			"value" => __("", $shortname),
			"description" => __("Example: Launch this modal.", $shortname)
	    ),
		array(
			"type" => "textfield",
			"heading" => __("Modal window Title", $shortname),
			"param_name" => "modal_title",
			"value" => __("", $shortname)
	    ),
	    array(
			"type" => "textarea",
			"heading" => __("Modal window text", $shortname),
			"param_name" => "modal_text",
			"value" => __("", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Primary button text", $shortname),
			"param_name" => "primary_text",
			"value" => __("", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Primary button link", $shortname),
			"param_name" => "primary_link",
			"value" => __("", $shortname),
			"description" => __("Example: http://www.google.com", $shortname)
	    )

	)

);


/* SUPREME PROGRESS BAR */

add_shortcode('vc_st_progress_bar','SupremeShortcodes__progress_bar');
function SupremeShortcodes__progress_bar( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'width' => '',
		'style' => '',
		'striped' => '',
		'active' => '',
	), $atts));

	$output = '';

	if ($striped == 'yes') {
		$prog_striped = ' progress-striped';
	}else{
		$prog_striped = '';
	}

	if ($active == 'yes'){
		$prog_active = ' active';
	}else{
		$prog_active = '';
	}

	$output .= '<div class="progress'.$prog_striped.$prog_active.'">';
	$output .= '<div class="progress-bar progress-bar-'.$style.'" role="progressbar" aria-valuenow="'.$width.'" aria-valuemin="0" aria-valuemax="100%" style="width: '.$width.';">';
	$output .= do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}

$supreme_vc_map["Progress Bar"] = array(
	"name" => __("Progress Bar", $shortname),
	"base" => "vc_st_progress_bar",
	"icon" => "icon-wpb-vc_st_progress_bar",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Animated progress bars. Four styles.', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Progress bar width", $shortname),
			"param_name" => "width",
			"value" => __("", $shortname),
			"description" => __("With procent sign. Example: 80%.", $shortname)
	    ),
		array(
			"type" => "dropdown",
			"heading" => __("Style", $shortname),
			"param_name" => "style",
			"value" => array(
					__('Info', $shortname) => "info", 
					__('Success', $shortname) => "success", 
					__('Warning', $shortname) => "warning", 
					__('Danger', $shortname) => "danger"
			),
			"description" => __("Select progress bar style/color.", $shortname),
			"admin_label" => true
		),
		array(
            "type" => 'checkbox',
            "heading" => __("Striped", $shortname),
            "param_name" => "striped",
            "description" => __("Put stripes or leave plain color.", $shortname),
            "value" => Array(__("Yes, please", $shortname) => 'yes')
        ),
        array(
            "type" => 'checkbox',
            "heading" => __("Active?", $shortname),
            "param_name" => "active",
            "description" => __("Makes progress bar animated.", $shortname),
            "value" => Array(__("Yes, please", $shortname) => 'yes'),
            "dependency" => Array('element' => "striped", 'value' => 'yes')
        ),

	)

);


/* SUPREME ANIMATED */

add_shortcode('vc_st_animated','SupremeShortcodes__animated');
function SupremeShortcodes__animated( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'precent' => '',
		'trigger' => '',
		'type' => ''
	), $atts));

	$output = '';

	$animations_that_start_hidden = array( "flipInX", "flipInY", "fadeIn", "fadeInUp", "fadeInDown", "fadeInLeft", "fadeInRight", "fadeInUpBig", "fadeInDownBig", "fadeInLeftBig", "fadeInRightBig","bounceIn", "bounceInDown", "bounceInUp", "bounceInLeft", "bounceInRight", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "lightSpeedIn", "rollIn" );
	$animations_that_end_hidden = array( "flipOutX", "flipOutY", "fadeOut", "fadeOutUp", "fadeOutDown", "fadeOutLeft", "fadeOutRight", "fadeOutUpBig", "fadeOutDownBig", "fadeOutLeftBig", "fadeOutRightBig", "bounceOut", "bounceOutDown", "bounceOutUp", "bounceOutLeft", "bounceOutRight", "rotateOut", "rotateOutDownLeft", "rotateOutDownRight", "rotateOutUpLeft", "rotateOutUpRight", "lightSpeedOut", "rollOut", "hinge" );

	$starthidden = false;
	$endhidden = false;

	if ( in_array( $type, $animations_that_start_hidden ) ) {
		$starthidden = true;
	}

	if ( in_array( $type, $animations_that_end_hidden ) ) {
		$endhidden = true;
	}

	$output .= '<div class="'.$trigger.'-animated"' . ( $starthidden ? ' style="display:none;"' : '' ) . ' data-scrollpercent="'.$precent.'" data-starthidden="'.$starthidden.'" data-endhidden="'.$endhidden.'" data-animation="'.$type.'">' . do_shortcode( $content ) . '</div>';

	return $output;

}

$supreme_vc_map["Animated"] = array(
	"name" => __("Animated", $shortname),
	"base" => "vc_st_animated",
	"icon" => "icon-wpb-vc_st_animated",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Animated elements. Animate anything!', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Trigger", $shortname),
			"param_name" => "trigger",
			"value" => array(
					__('Scroll', $shortname) => "scroll", 
					__('Click', $shortname) => "click", 
					__('Hover', $shortname) => "hover"
			),
			"description" => __("When to animate element.", $shortname),
		),
		array(
			"type" => "dropdown",
			"heading" => __("Precent", $shortname),
			"param_name" => "precent",
			"value" => array( "0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100" ),
			'dependency' => array('element' => 'trigger','value' => array( 'scroll' )),
			"description" => __("Animate when % of item is in view.", $shortname)
	    ),
		array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "type",
			"value" => array( "flash", "bounce", "shake", "tada", "swing", "wobble", "wiggle", "pulse", "flash", "bounce", "shake", "tada", "swing", "wobble", "wiggle", "pulse", "fadeIn", "fadeInUp", "fadeInDown", "fadeInLeft", "fadeInRight", "fadeInUpBig", "fadeInDownBig", "fadeInLeftBig", "fadeInRightBig", "fadeOut", "fadeOutUp", "fadeOutDown", "fadeOutLeft", "fadeOutRight", "fadeOutUpBig", "fadeOutDownBig", "fadeOutLeftBig", "fadeOutRightBig", "bounceIn", "bounceInDown", "bounceInUp", "bounceInLeft", "bounceInRight", "bounceOut", "bounceOutDown", "bounceOutUp", "bounceOutLeft", "bounceOutRight", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "rotateOut", "rotateOutDownLeft", "rotateOutDownRight", "rotateOutUpLeft", "rotateOutUpRight", "lightSpeedIn", "lightSpeedOut", "hinge", "rollIn", "rollOut" ),
			"description" => __("Select animation.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textarea_html",
			
			"heading" => __( "Animated Content", $shortname ),
			"param_name" => "content",
			"value" => ""
		)
	)

);



/* SUPREME ANIMATED */

add_shortcode('vc_st_media','SupremeShortcodes__media');
function SupremeShortcodes__media( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'type' => '',
		'video_type' => '',
		'audio_type' => '',
		'color' => '',
		'audio_width' => '',
		'audio_height' => '',
		'soundcloud_url' => '',
		'mixcloud_url' => '',
		'hosted_url' => '',
		'video_width' => '',
		'video_height' => '',
		'poster' => '',
		'mp4' => '',
		'ogg' => '',
		'webm' => '',
		'youtube_clip_id' => '',
		'vimeo_clip_id' => '',
		'daily_clip_id' => '',
		'flash_src' => ''
	), $atts));

	$output = '';

	$rnd = mt_rand();
	$str= ltrim ($color,'#');

	if ($title !== '') {
		$output .= '<h3>'.$title.'</h3>';
	}else{

	}

	// if bg image
    $has_image = false;
    if((int)$poster > 0 && ($image_url = wp_get_attachment_url( $poster, 'large' )) !== false) {
        $has_image = true;
        $photo_url = $image_url;
    }

	// AUDIO
	if ($type == 'audio') {
	
		if ($audio_type == 'soundcloud') {
			$output .= '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$soundcloud_url.'&amp;color='.$str.'&amp;auto_play=false&amp;show_artwork=true"></iframe>';
		}else if($audio_type == 'mixcloud'){
			$output .= '<iframe width="'.$audio_width.'" height="'.$audio_height.'" src="//www.mixcloud.com/widget/iframe/?feed='.$mixcloud_url.'" frameborder="0"></iframe>';
		}else if($audio_type == 'hosted_audio'){
			$output .= '<div class="audio-wrap"><audio style="width: 100%;" class="full_width" src="'.$hosted_url.'" preload="auto" controls="controls" id="audio_'.$rnd.'"></audio></div>';
			$output .= '<script type="text/javascript">jQuery(document).ready(function($) {$("#audio_'.$rnd.'").mediaelementplayer();});</script>';
		}

	// VIDEO
	}else{

		if($video_type == 'html5') {
			// html5 //
			$output .=  '<video width="'.$video_width.'" height="'.$video_height.'" controls="controls" id="video_'.$rnd.'" name="media" poster="'.$photo_url.'">';
			$output .=	'<source src="'.$mp4.'"  type=\'video/mp4\'></source>';
			$output .=	'<source src="'.$webm.'" type=\'video/webm\'></source>';
			$output .=	'<source src="'.$ogg.'"  type=\'video/ogg\'></source>';
			$output .=  '</video>';
			$output .=	'<script type="text/javascript">jQuery(document).ready(function($) {$("#video_'.$rnd.'").mediaelementplayer();});</script>';
		} elseif ($video_type == 'flash') {
			// flash //
			$output .=  '<h3>'.$title.'</h3>';
			$output = '<div class="ss-video-container"><object width="'.$video_width.'" height="'.$height.'"><param name="movie" value="'.$flash_src.'"><embed src="'.$flash_src.'" width="'.$video_width.'" height="'.$video_height.'"></embed></object></div>';

		} else {
			// youtube, vimeo, dailymotion //
			switch($video_type) {
				case 'youtube':
					$source = 'http://www.youtube.com/embed/'. $youtube_clip_id . '?autohide=2&amp;controls=1&amp;disablekb=0&amp;fs=1&amp;hd=0&amp;loop=0&amp;rel=0&amp;showinfo=0&amp;showsearch=0&amp;wmode=transparent';
					break;
				case 'vimeo':
					$source = 'http://player.vimeo.com/video/' . $vimeo_clip_id;
					break;
				case 'dailymotion':
					$source = 'http://www.dailymotion.com/embed/video/'. $daily_clip_id;
					break;
			}
			$output .= '<div class="ss-video-container"><iframe width="'.$video_width.'" height="'.$video_height.'" frameborder="0" src="'.$source.'"></iframe></div>';
		}

	}

	return $output;

}

$supreme_vc_map["Media"] = array(
	"name" => __("Media", $shortname),
	"base" => "vc_st_media",
	"icon" => "icon-wpb-vc_st_media",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Soundcloud, Mixcloud, HTML5, YouTube, Vimeo, Dailymotion..', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Title", $shortname),
			"param_name" => "title",
			"value" => __("", $shortname),
			"description" => __("Example: My cool video/audio. (Optional)", $shortname)
	    ),
		array(
			"type" => "dropdown",
			"heading" => __("Media type", $shortname),
			"param_name" => "type",
			"value" => array(
					__('Audio', $shortname) => "audio", 
					__('Video', $shortname) => "video"
			),
			"description" => __("Choose media type.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "dropdown",
			"heading" => __("Audio type", $shortname),
			"param_name" => "audio_type",
			"value" => array(
					__('Soundcloud', $shortname) => "soundcloud", 
					__('Mixcloud', $shortname) => "mixcloud",
					__('Hosted Audio', $shortname) => "hosted_audio"
			),
			"description" => __("Choose audio type.", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'audio')
		),
		array(
			"type" => "colorpicker",
			"heading" => __("Player color", $shortname),
			"param_name" => "color",
			"value" => '#ff5500',
			"description" => __("Choose soundcloud player color.", $shortname),
			"dependency" => Array('element' => "audio_type", 'value' => 'soundcloud')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Width", $shortname),
			"param_name" => "audio_width",
			"value" => __("", $shortname),
			"description" => __("In pixels. Example: 500.", $shortname),
			"dependency" => Array('element' => "audio_type", 'value' => 'mixcloud')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Height", $shortname),
			"param_name" => "audio_height",
			"value" => __("", $shortname),
			"description" => __("In pixels. Example: 450.", $shortname),
			"dependency" => Array('element' => "audio_type", 'value' => 'mixcloud')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("URL", $shortname),
			"param_name" => "soundcloud_url",
			"value" => __("", $shortname),
			"description" => __("Example: https://soundcloud.com/puresoul/puresoul-x-step-mini-av-mix", $shortname),
			"dependency" => Array('element' => "audio_type", 'value' => 'soundcloud')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("URL", $shortname),
			"param_name" => "mixcloud_url",
			"value" => __("", $shortname),
			"description" => __("Example: http://www.mixcloud.com/puresoul/puresoul-x-step-mini-av-mix/", $shortname),
			"dependency" => Array('element' => "audio_type", 'value' => 'mixcloud')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Source/URL", $shortname),
			"param_name" => "hosted_url",
			"value" => __("", $shortname),
			"description" => __("Example: http://www.domain.com/assets/music/some-track.mp3", $shortname),
			"dependency" => Array('element' => "audio_type", 'value' => 'hosted_audio')
	    ),
		array(
			"type" => "dropdown",
			"heading" => __("Video type", $shortname),
			"param_name" => "video_type",
			"value" => array(
					__('YouTube', $shortname) => "youtube", 
					__('Vimeo', $shortname) => "vimeo",
					__('Dailymotion', $shortname) => "dailymotion",
					__('HTML5', $shortname) => "html5",
					__('Flash', $shortname) => "flash"
			),
			"description" => __("Choose video type.", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'video')
		),
		array(
			"type" => "textfield",
			"heading" => __("Width", $shortname),
			"param_name" => "video_width",
			"value" => __("", $shortname),
			"description" => __("In pixels. Example: 500", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'video')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Height", $shortname),
			"param_name" => "video_height",
			"value" => __("", $shortname),
			"description" => __("In pixels. Example: 350", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'video')
	    ),
		array(
			"type" => "attach_image",
			"heading" => __("Poster", $shortname),
			"param_name" => "poster",
			"value" => "",
			"description" => __("Select image from media library.", $shortname),
			"dependency" => Array('element' => "video_type", 'value' => 'html5')
		),
		array(
			"type" => "textfield",
			"heading" => __("Mp4", $shortname),
			"param_name" => "mp4",
			"value" => __("", $shortname),
			"description" => __("URL. Example: http://www.domain.com/assets/video.mp4", $shortname),
			"dependency" => Array('element' => "video_type", 'value' => 'html5')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Ogg", $shortname),
			"param_name" => "ogg",
			"value" => __("", $shortname),
			"description" => __("URL. Example: http://www.domain.com/assets/video.ogv", $shortname),
			"dependency" => Array('element' => "video_type", 'value' => 'html5')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Webm", $shortname),
			"param_name" => "webm",
			"value" => __("", $shortname),
			"description" => __("URL. Example: http://www.domain.com/assets/video.webm", $shortname),
			"dependency" => Array('element' => "video_type", 'value' => 'html5')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Clip ID", $shortname),
			"param_name" => "youtube_clip_id",
			"value" => __("", $shortname),
			"description" => __("Example: ayX4LqLF4e8", $shortname),
			"dependency" => Array('element' => "video_type", 'value' => 'youtube')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Clip ID", $shortname),
			"param_name" => "vimeo_clip_id",
			"value" => __("", $shortname),
			"description" => __("Example: 85202007", $shortname),
			"dependency" => Array('element' => "video_type", 'value' => 'vimeo')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Clip ID", $shortname),
			"param_name" => "daily_clip_id",
			"value" => __("", $shortname),
			"description" => __("Example: xyclod_despicable-me-2-3d-theatrical-trailer_shortfilms", $shortname),
			"dependency" => Array('element' => "video_type", 'value' => 'dailymotion')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("URL/Source", $shortname),
			"param_name" => "flash_src",
			"value" => __("", $shortname),
			"description" => __("URL. Example: http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf", $shortname),
			"dependency" => Array('element' => "video_type", 'value' => 'flash')
	    )
	)

);


/* SUPREME FANCYBOX */

add_shortcode('vc_st_fancybox','SupremeShortcodes__fancybox');
function SupremeShortcodes__fancybox( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'type' => '',
		'image_title' => '',
		'image' => '',
		'thumb' => '',
		'thumb_width' => '',
		'group' => '',
		'inline_link' => '',
		'inline_title' => '',
		'inline_content' => '',
		'iframe_title' => '',
		'iframe_link' => '',
		'page_link_title' => '',
		'page_page' => '',
		'swf_link_title' => '',
		'swf' => ''
	), $atts));

	$output = '';
	$rand = rand(100,1000);

	// if image
    $has_image = false;
    if((int)$image > 0 && ($photo_url = wp_get_attachment_url( $image, 'large' )) !== false) {
        $has_image = true;
        $image_url = $photo_url;
    }

    // if thumb
    if((int)$thumb > 0 && ($photo_url = wp_get_attachment_url( $thumb, 'large' )) !== false) {
        $has_image = true;
        $thumb_url = $photo_url;
    }

	$group = ($group != '') ? $group : 'fancybox_' . mt_rand();
	$display_title = (trim($display_title) != '') ? $display_title : $image_title;

	if ($thumb !== '') {
		if ($thumb_width !== '') {
			$t_width = $thumb_width;
		}else{
			$t_width = '150';
		}
		$thumbnail = '<img alt="Fancybox Image" width="'.$t_width.'" src="'.$thumb_url.'">';
	}else{
		$thumbnail = $display_title;
	}

    if ($type == 'image') {
    	
		$output .= '<a title="'.$image_title.'" href="'.$image_url.'" class="fancybox" data-fancybox-group="'.$group.'">'.$thumbnail.'</a>';		

    }else if($type == 'inline'){

		$output .= '<a class="fancybox" href="#inline-'.$rand.'">'.$inline_link.'</a>';
		$output .= '<div id="inline-'.$rand.'" class="fancybox-inline-content" style="display:none;">';
		$output .= '<h2>'.$inline_title.'</h2>';
		$output .= '<p>'.$inline_content.'</p>';
		$output .= '</div>';

    }else if($type == 'iframe'){
    	
    	$output .= '<a class="fancybox fancybox.iframe" href="'.$iframe_link.'">'.$iframe_title.'</a>';

    }else if($type == 'page'){
    	
    	$output .= '<a class="fancybox fancybox.iframe" href="'.$page_page.'">'.$page_link_title.'</a>';	

    }else if($type == 'swf'){
    	
    	$output .= '<a class="fancybox" href="'.$swf.'">'.$swf_link_title.'</a>';	

    }


    return $output;

}


$supreme_vc_map["Fancybox"] = array(
	"name" => __("Fancybox", $shortname),
	"base" => "vc_st_fancybox",
	"icon" => "icon-wpb-vc_st_fancybox",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Image, text, iframe, page or swf in fancybox.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "type",
			"value" => array(
					__('Image', $shortname) => "image", 
					__('Inline', $shortname) => "inline",
					__('Iframe', $shortname) => "iframe",
					__('Page', $shortname) => "page",
					__('SWF', $shortname) => "swf"
			),
			"description" => __("Choose fancybox type.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("Title", $shortname),
			"param_name" => "image_title",
			"value" => __("", $shortname),
			"description" => __("Image title. Example: Funny cat", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'image')
	    ),
	    array(
			"type" => "attach_image",
			"heading" => __("Image", $shortname),
			"param_name" => "image",
			"value" => "",
			"description" => __("Select image from media library.", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'image')
		),
		array(
			"type" => "attach_image",
			"heading" => __("Thumbnail", $shortname),
			"param_name" => "thumb",
			"value" => "",
			"description" => __("Select image from media library.", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'image')
		),
		array(
			"type" => "textfield",
			"heading" => __("Thumbnail width", $shortname),
			"param_name" => "thumb_width",
			"value" => "",
			"description" => __("Default 150. Value is in pixels", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'image')
		),
		array(
			"type" => "textfield",
			"heading" => __("Group", $shortname),
			"param_name" => "group",
			"value" => __("", $shortname),
			"description" => __("Group fancybox as gallery. Example: Put the same value here for each image you wish to put in a group.", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'image')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Link", $shortname),
			"param_name" => "inline_link",
			"value" => __("", $shortname),
			"description" => __("Text for the link. Example: Click here", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'inline')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Title", $shortname),
			"param_name" => "inline_title",
			"value" => __("", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'inline')
	    ),
	    array(
			"type" => "textarea",
			"heading" => __("Content", $shortname),
			"param_name" => "inline_content",
			"value" => __("", $shortname),
			"description" => __("Example: Write some text", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'inline')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Title", $shortname),
			"param_name" => "iframe_title",
			"value" => __("", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'iframe')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("URL/Link", $shortname),
			"param_name" => "iframe_link",
			"value" => __("", $shortname),
			"description" => __("Example: http://www.google.com", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'iframe')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Title", $shortname),
			"param_name" => "page_link_title",
			"value" => __("", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'page')
	    ),
	    array(
			"type" => "supreme_pages",
			"heading" => __("Page", $shortname),
			"param_name" => "page_page",
			"value" => __("", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'page')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Title", $shortname),
			"param_name" => "swf_link_title",
			"value" => __("", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'swf')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("URL/Link", $shortname),
			"param_name" => "swf",
			"value" => __("", $shortname),
			"description" => __("Example: http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'swf')
	    )


	)

);



/* SUPREME RELATED */

add_shortcode('vc_st_related','SupremeShortcodes__related');
function SupremeShortcodes__related( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'type' => '',
		'limit' => '',
		'of' => '',
		'exclude' => ''
	), $atts));

	global $wpdb, $post, $table_prefix;
	$output = '';

	// RELATED POSTS
	if ($type == 'related_posts') {

		
		if ($post->ID) {
			$retval = '<ul class="supreme_related_posts">';
	 		// Get tags
			$tags = wp_get_post_tags($post->ID);
			$tagsarray = array();
			foreach ($tags as $tag) {
				$tagsarray[] = $tag->term_id;
			}
			$tagslist = implode(',', $tagsarray);
			// Do the query
			$q = "SELECT p.*, count(tr.object_id) as count
				FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id 
					AND tr.object_id  = p.ID 
					AND tt.term_id IN ($tagslist) 
					AND p.ID != $post->ID
					AND p.post_status = 'publish'
					AND p.post_date_gmt < NOW()
	 			GROUP BY tr.object_id
				ORDER BY count DESC, p.post_date_gmt DESC
				LIMIT $limit;";
			$related = $wpdb->get_results($q);
	 		if ( $related ) {
				foreach($related as $r) {
					$excerpt = substr(strip_tags($r->post_content), 0, 385);
					$excerpt_final = strip_shortcodes($excerpt);
					$retval .= "\n" . '<li><div class="pull-left">'.get_the_post_thumbnail( $r->ID, 'medium').'</div><h3><a title="'.$r->post_title.'" href="'.get_permalink($r->ID).'">'.$r->post_title.'</a></h3><p>'.$excerpt_final.'...</p><div class="clear"></div></li>' . "\n";
				}
			} else {
				$retval .= "\n" . '<li>No related posts found</li>' . "\n";
			}
			$retval .= '</ul>' . "\n";
			$output .= '<h2 class="share-word"><span>'.__('Related posts', $shortname).'</span></h2>'."\n".$retval;
		}

	// SIBLINGS
	}else if($type == 'siblings'){

		$children = get_pages(array('child_of' => $post->post_parent,'sort_order' => 'ASC'));
		if ($children) {
			$output = '<div class="alone"><ul class="list-group">';
				foreach($children as $child): $class = ($child->ID == $post->ID) ? ' current_page_item' : '';
					$output .= '<li class="list-group-item '.$class.'"><a href="'.$child->guid.'"><i class="fa fa-angle-right icon-1"></i> '.$child->post_title.'</a></li>';
				endforeach;
				$output .= '</ul><div class="clear"></div></div>';
		}else{
			$output .= '<h4>'.__('No siblings found.', $shortname).'</h4>';
		}

	// CHILDREN
	}else if($type == 'children'){

		$children = get_pages(array('parent' => $of, 'hierarchical' => 0, 'sort_column' => 'menu_order', 'sort_order' => 'ASC', 'post_status' => 'publish', 'exclude' => $exclude));
		if ($children) {
			$output = '<div class="alone"><ul class="list-group">';
			foreach($children as $child): $class = ($child->ID == $post->ID) ? ' current_page_item' : '';
				$output .= '<li class="list-group-item '.$class.'"><a href="'.$child->guid.'"><i class="fa fa-angle-right icon-1"></i> '.$child->post_title.'</a></li>';
			endforeach;
			$output .= '</ul><div class="clear"></div></div>';
		}else{
			$output .= '<h4>'.__('No children found.', $shortname).'</h4>';
		}

	}else{
		//
	}

    return $output;

}


$supreme_vc_map["Related"] = array(
	"name" => __("Related", $shortname),
	"base" => "vc_st_related",
	"icon" => "icon-wpb-vc_st_related",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Display related posts, siblings or children.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "type",
			"value" => array(
					__('Related Posts', $shortname) => "related_posts", 
					__('Siblings', $shortname) => "siblings",
					__('Children', $shortname) => "children"
			),
			"description" => __("Choose type. Note: Related posts works only on Posts, not on Pages.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("Limit", $shortname),
			"param_name" => "limit",
			"value" => __("", $shortname),
			"description" => __("Related Posts limit. How many to display? In numbers.", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'related_posts')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Children of/Post/Page ID", $shortname),
			"param_name" => "of",
			"value" => __("", $shortname),
			"description" => __("Page or Post ID", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'children')
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Exclude", $shortname),
			"param_name" => "exclude",
			"value" => __("", $shortname),
			"description" => __("List of Page ID's to exclude. Separate with coma ','", $shortname),
			"dependency" => Array('element' => "type", 'value' => 'children')
	    )


	)

);


/* SUPREME CAROUSEL */

add_shortcode('vc_st_carousel','SupremeShortcodes__carousel');
function SupremeShortcodes__carousel( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'type' 		=> '',
		'posts' 	=> '',
		'number' 	=> '',
		'category'	=> '',
		'display_title' => ''
	), $atts));

	global $post;

	$output = '';

	if($number == ''){ $numb = -1; }else{ $numb = $number; }

	$args = array(
		'post_type' => $posts,
		'post_status' => 'publish',
		'posts_per_page' => $numb,
		'cat' => $category
	);

	if ($display_title == 'yes') {
		$titleClass = 'with-title';
	}else{
		$titleClass = 'without-title';
	}


	// FLEXSLIDER
	if ($type == 'flexslider') {
	
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {

			$id = rand(100,1000);

			$output .= '<div class="flexslider-wrap" id='.$id.'><div class="flexslider-posts '.$titleClass.'"><ul class="slides">';
			while ( $query->have_posts() ) {

				$query->the_post();

				if (strlen($post->post_title) > 17) {
					$final_title = substr(get_the_title($before = '', $after = '', FALSE), 0, 17) . '...'; 
				} else {
					$final_title = get_the_title($post->ID);
				}

				if (!has_post_thumbnail()) {
					$show_title = '<h3><a href="'.get_permalink().'">'.$final_title.'</a></h3>';
					$content = get_the_content();
					$content_clean = strip_shortcodes($content);
					$excerpt = substr(strip_tags($content_clean), 0, 95);
					$show_text = '<a class="ss-btn more" href="'.get_permalink().'">'.__('Read More', $shortname).'</a>';
					$hover_div = '';
					$title_div = '';
				}else{
					$show_title = '';
					$show_text = '';
					$content = get_the_content();
					$content_clean = strip_shortcodes($content);
					$excerpt = substr(strip_tags($content_clean), 0, 47);

					if ($display_title == 'no' || $display_title == '') {

						$hover_div = '<div class="hover_div"><h3><a href="'.get_permalink().'">'.$final_title.'</a></h3><a class="ss-btn more" href="'.get_permalink().'">'.__('Read More', $shortname).'</a></div>';
						$title_div = '';

					}else{

						$hover_div = '<div class="hover_div"><h3><a class="ss-btn more st-center-btn" href="'.get_permalink().'">'.__('Read More', $shortname).'</a></h3></div>';
						$title_div = '<div class="title_active"><h3><a href="'.get_permalink().'">'.$final_title.'</a></h3></div>';

					}

				}
				$output .= '<li>'. get_the_post_thumbnail( $post->ID, 'carousel' ) . $show_title . $show_text. $hover_div. $title_div.'</li>';
			}
				
			$output .= '</ul></div></div>';
		} else {
			$output .= '<h3>'.__('No Posts found.', $shortname).'</h3>';
		}
		/* Restore original Post Data */
		wp_reset_postdata();

	// SWIPER
	}else if($type == 'swiper'){

		$querySwipe = new WP_Query( $args );

		if ( $querySwipe->have_posts() ) {

			$id = rand(100,1000);

			$output .= '<div id="swipe-'.$id.'"><div class="st-swiper-container '.$titleClass.'"><div class="swiper-wrapper">';


			while ( $querySwipe->have_posts() ) {

				$querySwipe->the_post();

				if (strlen($post->post_title) > 17) {
					$final_title = substr(get_the_title($before = '', $after = '', FALSE), 0, 17) . '...'; 
				} else {
					$final_title = get_the_title($post->ID);
				}

				
				if (!has_post_thumbnail()) {
					$show_title = '<h3><a href="'.get_permalink().'">'.$final_title.'</a></h3>';
					$content = get_the_content();
					$content_clean = strip_shortcodes($content);
					$excerpt = substr(strip_tags($content_clean), 0, 95);
					$show_text = '<a class="ss-btn more" href="'.get_permalink().'">'.__('Read More', $shortname).'</a>';
					$hover_div = '';
					$title_div = '';
				}else{
					$show_title = '';
					$show_text = '';
					$content = get_the_content();
					$content_clean = strip_shortcodes($content);
					$excerpt = substr(strip_tags($content_clean), 0, 47);

					if ($display_title == 'no' || $display_title == '') {

						$hover_div = '<div class="hover_div"><h3><a href="'.get_permalink().'">'.$final_title.'</a></h3><a class="ss-btn more" href="'.get_permalink().'">'.__('Read More', $shortname).'</a></div>';
						$title_div = '';

					}else{

						$hover_div = '<div class="hover_div"><h3><a class="ss-btn more st-center-btn" href="'.get_permalink().'">'.__('Read More', $shortname).'</a></h3></div>';
						$title_div = '<div class="title_active"><h3><a href="'.get_permalink().'">'.$final_title.'</a></h3></div>';

					}

				}
				$output .= '<div class="swiper-slide">'. get_the_post_thumbnail( $post->ID, 'swiper' ) . $show_title . $show_text. $hover_div. $title_div.'</div>';
			}

				
			$output .= '<div class="pagination"></div></div></div></div>';
			$output .= '<div class="clear"></div>';
		} else {
			$output .= '<h3>'.__('No Posts found.', $shortname).'</h3>';
		}
		/* Restore original Post Data */
		wp_reset_postdata();

	}else{
		//
	}

    return $output;

}


$supreme_vc_map["Carousel"] = array(
	"name" => __("Carousel", $shortname),
	"base" => "vc_st_carousel",
	"icon" => "icon-wpb-vc_st_carousel",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Flexslider carousel and beautiful Swiper.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "type",
			"value" => array(
					__('Flexslider', $shortname) => "flexslider", 
					__('Swiper', $shortname) => "swiper"
			),
			"description" => __("Flexslider or Swiper.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "supreme_post_types",
			"heading" => __("Post Type", $shortname),
			"param_name" => "posts",
			"description" => __("Choose Post Type.", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Number", $shortname),
			"param_name" => "number",
			"value" => __("", $shortname),
			"description" => __("How many to show. If empty, it will display all published.", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Category ID", $shortname),
			"param_name" => "category",
			"value" => __("", $shortname),
			"description" => __("To exclude a certain category, put minus(-) before the category ID(number). Separate them with coma(,)", $shortname),
			"dependency" => Array('element' => "posts", 'value' => 'post')
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Display title?", $shortname),
			"param_name" => "display_title",
			"value" => array(
					__('Yes', $shortname) => "yes", 
					__('No', $shortname) => "no"
			),
			"description" => __("Show title below the image?", $shortname)
		)


	)

);


/* SUPREME DROPCAP */

add_shortcode('vc_st_dropcap','SupremeShortcodes__dropcap');
function SupremeShortcodes__dropcap( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'type' => '',
		'letter' => ''
	), $atts));

	$output = '';

	$output = '<span class="dropcap '.$type.'">'.$letter. '</span>';

    return $output;

}

$supreme_vc_map["Dropcap"] = array(
	"name" => __("Dropcap", $shortname),
	"base" => "vc_st_dropcap",
	"icon" => "icon-wpb-vc_st_dropcap",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Style your first letter with four different styles.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "type",
			"value" => array(
					__('Light', $shortname) => "light", 
					__('Light circled', $shortname) => "light_circled", 
					__('Dark', $shortname) => "dark", 
					__('Dark circled', $shortname) => "dark_circled"
			),
			"description" => __("Choose the first letter style.", $shortname),
			"admin_label" => true
		),
		array(
			"type" => "textfield",
			"heading" => __("Letter", $shortname),
			"param_name" => "letter"
	    )


	)

);


/* SUPREME QUOTE */

add_shortcode('vc_st_quote','SupremeShortcodes__quote');
function SupremeShortcodes__quote( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'author' => '',
		'text' => ''
	), $atts));

	$output = '';

	$cite = "";

	if ($author != "") {
		$cite = "<cite>".$author."</cite>";
	}
	$output =  '<blockquote class="QUOTE"><p>' .$text. '</p>'.$cite.'</blockquote>';

    return $output;

}

$supreme_vc_map["Quote"] = array(
	"name" => __("Quote", $shortname),
	"base" => "vc_st_quote",
	"icon" => "icon-wpb-vc_st_quote",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Insert a quote and cite. Useful for testimonials.', $shortname),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Author", $shortname),
			"param_name" => "author"
	    ),
	    array(
			"type" => "textarea_html",
			"heading" => __("Text", $shortname),
			"param_name" => "text"
	    )


	)

);

/* SUPREME HIGHLIGHT */

add_shortcode('vc_st_highlight','SupremeShortcodes__highlight');
function SupremeShortcodes__highlight( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'background_color' => '',
		'text_color' => '',
		'highlighted_text' => ''
	), $atts));

	$output = '';

	$output =  '<span class="highlight" style="background: '.$background_color.'; color: '.$text_color.';">' . $highlighted_text . '</span>';

    return $output;

}

$supreme_vc_map["Highlight"] = array(
	"name" => __("Highlight", $shortname),
	"base" => "vc_st_highlight",
	"icon" => "icon-wpb-vc_st_highlight",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Insert hightlighted text. Unlimited colors.', $shortname),
	"params" => array(
		array(
			"type" => "colorpicker",
			"heading" => __("Background color", $shortname),
			"param_name" => "background_color",
			"value" => '#3498db', //Default
			"description" => __("Choose background color", $shortname)
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Text color", $shortname),
			"param_name" => "text_color",
			"value" => '#ffffff', //Default
			"description" => __("Choose text color", $shortname)
	    ),
	    array(
			"type" => "textarea",
			"heading" => __("Text", $shortname),
			"param_name" => "highlighted_text"
	    )


	)

);

/* SUPREME LABEL */

add_shortcode('vc_st_label','SupremeShortcodes__label');
function SupremeShortcodes__label( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'type' => '',
		'label_text' => ''
	), $atts));

	$output = '';

	$output = '<span class="label '.$type.'">' .$label_text. '</span>';

    return $output;

}

$supreme_vc_map["Label"] = array(
	"name" => __("Label", $shortname),
	"base" => "vc_st_label",
	"icon" => "icon-wpb-vc_st_label",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Five flat colored labels to choose.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "type",
			"value" => array(
					__('Default', $shortname) => "default", 
					__('Success', $shortname) => "success", 
					__('Warning', $shortname) => "warning", 
					__('Important', $shortname) => "important",
					__('Notice', $shortname) => "notice"
			),
			"description" => __("Choose the first letter style.", $shortname),
			"admin_label" => true
		),
	    array(
			"type" => "textfield",
			"heading" => __("Label text", $shortname),
			"param_name" => "label_text"
	    )


	)

);

/* SUPREME ABBR */

add_shortcode('vc_st_abbr','SupremeShortcodes__abbrevation');
function SupremeShortcodes__abbrevation( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'abbr_text' => ''
	), $atts));

	$output = '';

	$output = '<abbr title="'.$title.'">' . $abbr_text . '</abbr>';

    return $output;

}

$supreme_vc_map["Abbreviation"] = array(
	"name" => __("Abbreviation", $shortname),
	"base" => "vc_st_abbr",
	"icon" => "icon-wpb-vc_st_abbr",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Simple abbreviation text.', $shortname),
	"params" => array(
	    array(
			"type" => "textfield",
			"heading" => __("Text", $shortname),
			"param_name" => "title",
			"description" => __("The full, unabbreviated, text.", $shortname)
	    ),
	    array(
			"type" => "textarea",
			"heading" => __("Abbreviation", $shortname),
			"param_name" => "abbr_text",
			"description" => __("The abbreviated text.", $shortname)
	    )


	)

);


/* SUPREME SVG */

add_shortcode('vc_st_svg_drawing','SupremeShortcodes__svg_drawing');
function SupremeShortcodes__svg_drawing( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'type' => '',
		'image_id' => '',
		'color' => ''
	), $atts));


	$output = '';

	$id = rand(100,1000);

	$photo_info = wp_get_attachment_image_src( $image_id, 'full' );
    $photo_url = $photo_info[0];

	if ($color == '') {
		$final_color = '#fff';
		$output .= '<style>#drawing-'.$id.' .line-drawing path{stroke:'.$final_color.'}</style>';
	}else{
		$final_color = $color;
		$output .= '<style>#drawing-'.$id.' .line-drawing path{stroke:'.$final_color.'}</style>';
	}

	$output .= '<div class="main">';

	if ($type == 'imac') {

		$output .= '<figure>';
		$output .= '	<div class="drawings mac" id="drawing-'.$id.'">';
		$output .= '		<img class="illustration" src="'.$photo_url.'" alt="iMac Illustration" />';
		$output .= '		<svg class="line-drawing" id="mac" width="100%" height="600" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600">';
		$output .= '			<path d="M 257.85024,158.16843 754.90716,35.953537 731.06035,405.57906 228.78695,448.8014 z" />';
		$output .= '			<path d="m 259.83736,136.30872 c 0,0 -6.74232,0.97288 -11.61303,5.46502 -3.96751,3.659 -6.12527,9.40831 -7.01729,20.86596 l -36.5158,346.77284 c 0,0 -3.47753,13.41382 10.68151,14.15903 l 517.67468,-21.11485 c 0,0 18.38216,0.74522 19.87257,-19.62369 L 784.07068,11.384991 c 0,0 0.059,-13.07475 -23.20111,-7.2266959 L 259.83736,136.30872 z" />';
		$output .= '			<path d="m 211.29271,522.89381 c 0,0 12.5259,6.63947 19.72988,5.64573 l 513.45197,-19.12737 c 0,0 18.87884,0.74557 21.61112,-18.87848 l 29.5596,-462.528221 c 0,0 1.49047,-10.184447 -13.54272,-21.4997553" />';
		$output .= '			<path d="M 208.59466,472.34637 756.27723,432.02629" />';
		$output .= '			<path d="m 591.36015,515.11602 11.15099,41.36862 c 0,0 8.62435,33.16197 -11.15099,33.16197 l -55.35924,4.26821 c 0,0 -9.65275,0.58387 -13.08781,0.58387 -1.35069,0 -5.16991,0.0265 -5.16991,0.0265 l -149.57016,-0.0347 c 0,0 -1.45726,0.12035 -1.52173,-0.0853 -0.14195,-0.4531 1.2173,-0.44973 1.2173,-0.44973 l 93.42473,-4.68143 c 0,0 23.85536,1.49042 23.85127,-27.57288 l -2.70885,-42.52741" />';
		$output .= '			<path d="m 595.82547,514.94947 11.52956,43.3982 c 0,0 8.23944,32.78936 -11.52956,38.00586 h -58.52044 l -12.10971,0.99374 -16.58099,-0.61332 -128.7355,0.17849 c 0,0 -10.74373,-0.45795 -13.22753,-2.50727" />';
		$output .= '			<path d="m 486.38703,90.292617 c -0.3846,2.126175 -1.9686,3.619643 -3.5379,3.335758 -1.5693,-0.283875 -2.5297,-2.237606 -2.1451,-4.363775 0.38461,-2.12617 1.96859,-3.619642 3.53789,-3.335762 1.56931,0.283879 2.52971,2.23761 2.14511,4.363779 z" />';
		$output .= '			<path d="m 483.95449,571.8934 120.41968,0" />';
		$output .= '			<path class="line-round" d="m 783.49986,166.74023 -9.12881,133.48624" />';
		$output .= '			<path class="line-round" d="m 773.91008,309.26031 -1.81646,29.43591" />';
		$output .= '		</svg>';
		$output .= '	</div>';
		$output .= '</figure>';

	}else if($type == 'ipad'){

		$output .= '<figure>';
		$output .= '	<div class="drawings ipad" id="drawing-'.$id.'">';
		$output .= '		<img class="illustration" src="'.$photo_url.'" alt="iPad Illustration" />';
		$output .= '		<svg class="line-drawing" id="ipad" width="100%" height="600" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600">';
		$output .= '			<path d="m 119.21227,317.3823 c -14.7712,15.1851 5.88505,25.59207 5.88505,25.59207 0.40139,0.20208 1.05981,0.52884 1.46365,0.72599 L 416.1869,485.12665 c 0.40383,0.19714 1.05955,0.52933 1.45709,0.7385 0,0 9.89696,5.20239 19.33671,5.20239 10.02979,0 21.16627,-6.20065 21.16627,-6.20065 0.39239,-0.21867 1.03419,-0.57756 1.42577,-0.79787 L 875.52126,250.20545 c 0.39157,-0.22029 1.01766,-0.60506 1.39068,-0.85502 0,0 3.76458,-2.52182 6.28676,-5.9447 4.64984,-6.31148 4.67435,-16.20216 -6.96533,-21.61914" />';
		$output .= '			<path d="m 575.54015,111.04772 c 0.42726,0.13914 1.12167,0.38012 1.54344,0.53508 l 295.83425,108.82565 c 0.42173,0.15492 1.11261,0.40654 1.53524,0.55877 0,0 8.74562,3.15059 8.74562,7.68883 0,4.90148 -6.23222,7.96165 -6.23222,7.96165 -0.40304,0.19795 -1.05387,0.53972 -1.44597,0.75944 L 459.57383,470.45511 c -0.39182,0.21977 -1.02655,0.59091 -1.41001,0.8251 0,0 -10.10904,6.17208 -21.18286,6.17208 -11.34614,0 -20.00816,-4.0849 -20.00816,-4.0849 -0.40628,-0.19138 -1.06961,-0.5089 -1.4737,-0.70524 L 123.6865,330.99352 c -0.40409,-0.19636 -1.05544,-0.53646 -1.44756,-0.75595 0,0 -5.53406,-3.09773 -5.53406,-8.40769 0,-4.01646 6.48005,-7.1404 6.48005,-7.1404 0.40464,-0.19523 1.06771,-0.51303 1.47317,-0.70637 L 548.2304,111.96156 c 0.40544,-0.19333 1.07644,-0.49396 1.49058,-0.66796 0,0 5.62258,-2.36114 13.70077,-2.36114 5.62771,2.8e-4 12.1184,2.11529 12.1184,2.11529 l 0,-3e-5 z" />';
		$output .= '			<path d="m 543.26166,127.71414 c 0.40435,-0.19552 1.07938,-0.22491 1.4993,-0.0657 l 293.28845,111.24782 c 0.41989,0.15925 0.4425,0.46837 0.0499,0.68649 L 460.50648,449.50474 c -0.39264,0.21839 -1.04619,0.23966 -1.45219,0.0473 L 166.04957,310.69751 c -0.406,-0.1925 -0.40736,-0.50975 -0.002,-0.7055 L 543.26166,127.71414 z" />';
		$output .= '			<path class="stroke-medium" d="m 706.15488,173.08318 c 0,0.91484 -1.4935,1.65644 -3.33577,1.65644 -1.8422,0 -3.3357,-0.7416 -3.3357,-1.65644 0,-0.91483 1.4935,-1.65642 3.3357,-1.65642 1.84227,0 3.33577,0.74159 3.33577,1.65642 z" />';
		$output .= '			<path class="stroke-medium" d="m 278.50454,390.30812 3.53696,1.68339 c 0,0 0.76955,0.50214 1.67738,0.50214 0.86243,0 1.65319,-0.50676 1.65319,-0.50676 l 4.13305,-2.11962 c 0,0 0.72489,-0.34475 0.7434,-0.69248 0.0191,-0.35727 -0.70364,-0.67122 -0.70364,-0.67122 l -3.58517,-1.86828 c 0,0 -0.96451,-0.44825 -1.60931,-0.45586 -0.63722,-0.007 -1.65291,0.55277 -1.65291,0.55277 l -3.56175,1.90399 c 0,0 -1.14669,0.5217 -1.26023,0.86183 -0.14841,0.44469 0.62903,0.8101 0.62903,0.8101 z" />';
		$output .= '			<path d="m 299.03452,387.07281 c 0.45135,4.3632 -5.93332,8.59855 -14.26055,9.46 -8.32723,0.86146 -15.44369,-1.97728 -15.89506,-6.34047 -0.45136,-4.36317 5.93329,-8.59856 14.26054,-9.46 8.32726,-0.86145 15.4437,1.97726 15.89507,6.34047 z" />';
		$output .= '			<path class="stroke-medium" d="m 799.36443,293.02437 c 0,0 -0.94359,-2.05808 3.27714,-4.39419 4.22078,-2.33608 12.93454,-7.30568 12.93454,-7.30568 0,0 3.5378,-1.43367 3.87817,0.40437 l -20.08985,11.2955 z" />';
		$output .= '			<path class="stroke-medium" d="m 821.14882,280.77064 c 0,0 -0.94354,-2.05806 3.27723,-4.3942 4.22072,-2.3361 11.30066,-6.48872 11.30066,-6.48872 0,0 3.53775,-1.43369 3.87814,0.40435 l -18.45603,10.4786 z" />';
		$output .= '			<path class="stroke-medium" d="m 857.50023,260.3377 -5.55012,3.1206 c 0,0 -2.80392,-1.04376 2.02106,-3.57782 3.75892,-1.97422 3.52906,0.45723 3.52906,0.45723 z" />';
		$output .= '			<path class="stroke-thin" d="m 273.28038,410.96467 c 0.5299,0.28482 0.72866,0.94516 0.44384,1.47508 l 0,0 c -0.28457,0.5296 -0.94489,0.72867 -1.47507,0.44386 l -16.13,-7.94862 c -0.52991,-0.28481 -0.72869,-0.94515 -0.44413,-1.47482 l 0,0 c 0.28483,-0.52988 0.94515,-0.72868 1.47508,-0.44411 l 16.13028,7.94861 z" />';
		$output .= '			<path class="stroke-thin" d="m 116.07477,321.73853 c 0,0 -5.31512,6.9721 6.48467,12.73596 l 290.68577,141.59869 c 0,0 21.30792,13.2068 46.5642,-0.81691 L 880.65707,239.30382 c 0,0 8.75949,-4.49304 2.54167,-11.43679" />';
		$output .= '		</svg>';
		$output .= '	</div>';
		$output .= '</figure>';

	}else if($type == 'iphone'){

		$output .= '<figure>';
		$output .= '	<div class="drawings iphone" id="drawing-'.$id.'">';
		$output .= '		<img class="illustration" src="'.$photo_url.'" alt="iPhone Illustration" />';
		$output .= '		<svg class="line-drawing" id="iphone" width="100%" height="600" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600">';
		$output .= '			<path d="m 579.44258,124.24714 c 0,0 26.94592,-21.17898 59.75842,0 l 123.29566,73.28106 c 0,0 33.20953,17.10157 -6.16339,38.18122 l -333.2977,213.97805 c 0,0 -27.64185,18.89166 -61.05094,-5.96649 L 237.49608,357.2156 c 0,0 -29.23265,-17.89804 0,-36.591 l 341.9465,-196.37746 z" />';
		$output .= '			<path d="m 279.79799,312.77734 c -0.40628,-0.27771 -0.39017,-0.70636 0.0358,-0.95245 L 570.0171,144.0838 c 0.42621,-0.24639 1.12037,-0.24103 1.54248,0.0122 l 159.74292,95.72926 c 0.42206,0.25297 0.42768,0.67595 0.0122,0.93994 L 443.55324,423.67047 c -0.41553,0.26401 -1.08759,0.25296 -1.49417,-0.0247 L 279.79799,312.77734 z"/>';
		$output .= '			<path d="m 352.14146,381.97442 c 0,7.66059 -10.04974,13.87073 -22.44674,13.87073 -12.39698,0 -22.44672,-6.21014 -22.44672,-13.87073 0,-7.66058 10.04974,-13.87075 22.44672,-13.87075 12.397,0 22.44674,6.21017 22.44674,13.87075 z" id="ellipse38" />';
		$output .= '			<path d="m 764.95436,199.01191 c 18.61572,9.73636 15.39026,23.07615 15.39026,23.07615 l -1.04407,15.6605 c 0.29834,10.73863 -14.76562,18.4943 -14.76562,18.4943 L 430.59319,472.2088 c -40.41904,26.99573 -69.05539,3.43039 -69.05539,3.43039 L 228.05057,380.78125 c 0,0 -8.20313,-6.33878 -8.57601,-15.13849 l 0,-22.22303 c 0,0 -1.58065,-11.40978 17.20182,-22.26028" />';
		$output .= '			<path d="m 688.91731,169.48872 c 0,1.64745 -2.22589,2.98296 -4.97168,2.98296 -2.74579,0 -4.97168,-1.33551 -4.97168,-2.98296 0,-1.64745 2.22589,-2.98296 4.97168,-2.98296 2.74579,0 4.97168,1.33551 4.97168,2.98296 z" />';
		$output .= '			<path d="m 650.93416,162.32963 c 0,1.09835 -1.42462,1.98874 -3.18189,1.98874 -1.75732,0 -3.18194,-0.89039 -3.18194,-1.98874 0,-1.09835 1.42462,-1.98874 3.18194,-1.98874 1.75727,0 3.18189,0.89038 3.18189,1.98874 z" />';
		$output .= '			<path d="m 686.33144,185.74344 c -0.56708,0.94053 -1.78949,1.24299 -2.72998,0.67594 l -27.41663,-16.53482 c -0.94055,-0.56736 -1.24304,-1.78978 -0.67596,-2.73001 l 0,0 c 0.56707,-0.94052 1.78918,-1.24328 2.72998,-0.67593 l 27.41668,16.53482 c 0.9408,0.56706 1.24298,1.78947 0.67591,2.73 l 0,0 z" />';
		$output .= '			<path class="stroke-medium" d="m 588.24153,363.77246 c -1.16809,1.61905 -2.84607,2.40411 -3.74792,1.75345 -0.90186,-0.65064 -0.68604,-2.49057 0.48205,-4.10965 1.16803,-1.61902 2.84607,-2.40409 3.74793,-1.75345 0.90185,0.65063 0.68597,2.49063 -0.48206,4.10965 z" />';
		$output .= '			<path class="stroke-medium" d="m 230.85085,325.2605 c 0,0 -25.27755,17.82824 3.35882,36.83322 l 127.5213,89.33947 c 0,0 31.91761,23.56534 63.98438,2.38639 L 763.08748,238.30111 c 0,0 30.27698,-17.59944 4.41241,-36.22798" />';
		$output .= '			<path class="stroke-medium" d="m 239.70497,371.23965 c 2.18652,4.51798 2.5224,10.31534 -0.64343,11.84769 -2.85379,1.38113 -7.19249,-1.68387 -9.69042,-6.84586 -2.49882,-5.16202 -2.21067,-10.466 0.64313,-11.84741 2.85349,-1.3811 7.19218,1.68359 9.69072,6.84558 z" />';
		$output .= '			<path class="stroke-medium" d="m 759.60561,233.86953 2.9519,4.4088 -0.37286,19.48467" />';
		$output .= '			<path class="stroke-medium" d="m 429.98912,444.76443 2.95194,4.40879 -0.67981,21.95693" />';
		$output .= '			<path class="stroke-medium" d="m 285.82054,406.03701 c 0,0 14.24539,9.73667 18.89194,13.125 1.89477,1.38172 5.44391,4.16361 3.38058,8.75019 -0.30545,0.67892 -1.55352,1.34234 -3.7287,-0.44742 l -18.54412,-13.27417 c 0,0 -4.22596,-2.83411 -3.7287,-6.31403 3e-4,0 0.19928,-3.67917 3.729,-1.83957 z" />';
		$output .= '			<path class="stroke-medium" d="m 277.22832,400.84362 c 0.92495,2.05231 0.48422,4.2526 -0.98441,4.91449 -1.4686,0.66193 -3.409,-0.46521 -4.33395,-2.51751 -0.92496,-2.05228 -0.48426,-4.2526 0.98437,-4.91449 1.46863,-0.6619 3.40903,0.46524 4.33399,2.51751 z" />';
		$output .= '			<path class="stroke-medium" d="m 318.65367,430.76556 c 0.92496,2.05231 0.50604,4.24277 -0.9357,4.89255 -1.44177,0.64978 -3.36035,-0.48715 -4.28531,-2.53946 -0.92495,-2.05228 -0.50604,-4.24277 0.9357,-4.89255 1.44177,-0.64978 3.36035,0.48718 4.28531,2.53946 z" />';
		$output .= '		</svg>';
		$output .= '	</div>';
		$output .= '</figure>';

	}else{
		//
	}

	$output .= '</div>';	

    return $output;

}

$supreme_vc_map["SVG Drawing"] = array(
	"name" => __("SVG Drawing", $shortname),
	"base" => "vc_st_svg_drawing",
	"icon" => "icon-wpb-vc_st_svg_drawing",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Fun SVG drawing art. Choose iMac, iPad or iPhone style.', $shortname),
	"params" => array(
		array(
			"type" => "attach_image",
			"heading" => __("Image", $shortname),
			"param_name" => "image_id",
			"value" => "",
			"description" => __("Select image from media library.", $shortname)
		),
	    array(
			"type" => "dropdown",
			"heading" => __("Type", $shortname),
			"param_name" => "type",
			"value" => array(
					__('imac', $shortname) => "imac", 
					__('ipad', $shortname) => "ipad", 
					__('iphone', $shortname) => "iphone"
			),
			"description" => __("Choose which shape to draw before displaying the actual image.", $shortname),
			"admin_label" => true
		),
	    array(
			"type" => "colorpicker",
			"heading" => __("Drawing color", $shortname),
			"param_name" => "color",
			"value" => '#ffffff', //Default
			"description" => __("Choose the drawing color. Default is white: #ffffff.", $shortname)
	    ),


	)

);




/* SUPREME HOVER BUTTONS */

add_shortcode( 'vc_st_hover_button', 'SupremeShortcodes__hover_buttons' );
function SupremeShortcodes__hover_buttons( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'hover_effect'		=> 'fill-in',
		'text_color'       	=> '#ffffff',
		'link'        		=> '',
		'background'  		=> '',
		'size'        		=> '',
		'target'      		=> '',
		'icon'        		=> '',
		'border_radius'   	=> '',
		'hover_background' 	=> '',
		'hover_direction' 	=> '',
		'icon_color' 		=> '',
		'icon_background' 	=> '',
		'icon_position' 	=> '',
		'icon_separator' 	=> '',
		'arrow_direction' 	=> '',
		'icon_direction' 	=> '',
		'border_type' 		=> '',
        'icon_spin'  		=> ''
	), $atts));

	$output = '';

	$spin = '';
    
	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	$id = mt_rand();

	if ($content !== '' && $icon !== '') {
		$spacer = '<span class="spacer"></span>';
	}else{
		$spacer = '';
	}

	$content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content


	if ($border_radius !== '') {
		$styles[] = '-webkit-border-radius:' . $border_radius;
		$styles[] = '-moz-border-radius:' . $border_radius;
		$styles[] = 'border-radius:' . $border_radius;
	}else{
		$styles[] = '-webkit-border-radius: 2px';
		$styles[] = '-moz-border-radius: 2px';
		$styles[] = 'border-radius: 2px';
	}

	// FILL IN
	if ($hover_effect == 'fill-in') {

			if ($icon == '') {
				$btn_icon = '';
			}elseif($icon !== 'none'){
				$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
			}else{
				$btn_icon = '';
			}

			if ($hover_direction == 'ss-fade-in') {
				$dirCSS = '  ';
				$dirCSShoverAfter = '  ';
				$dirCSSbg = ' background-color: '.$hover_background.'; ';
			}elseif($hover_direction == 'ss-top-to-bottom'){
				$dirCSS = ' width: 100%; height: 0; top: 0; left: 0; ';
				$dirCSShoverAfter = ' height: 100%; ';
				$dirCSSbg = 'background-color: transparent;';
			}elseif($hover_direction == 'ss-left-to-right'){
				$dirCSS = ' width: 0; height: 100%; top: 0; left: 0; ';
				$dirCSShoverAfter = ' width: 100%; ';
				$dirCSSbg = 'background-color: transparent;';
			}elseif($hover_direction == 'ss-expand-h'){
				$dirCSS = ' width: 0; height: 103%; top: 50%; left: 50%; opacity: 0; -webkit-transform: translateX(-50%) translateY(-50%); -moz-transform: translateX(-50%) translateY(-50%); -ms-transform: translateX(-50%) translateY(-50%); transform: translateX(-50%) translateY(-50%); ';
				$dirCSShoverAfter = ' width: 90%; opacity: 1; ';
				$dirCSSbg = 'background-color: transparent;';
			}elseif($hover_direction == 'ss-expand-v'){
				$dirCSS = ' width: 101%; height: 0; top: 50%; left: 50%; opacity: 0; -webkit-transform: translateX(-50%) translateY(-50%); -moz-transform: translateX(-50%) translateY(-50%); -ms-transform: translateX(-50%) translateY(-50%); transform: translateX(-50%) translateY(-50%); ';
				$dirCSShoverAfter = ' height: 75%; opacity: 1; ';
				$dirCSSbg = 'background-color: transparent;';
			}elseif($hover_direction == 'ss-expand-c'){
				$dirCSS = ' width: 100%; top: 50%; left: 50%; opacity: 0; -webkit-transform: translateX(-50%) translateY(-50%) rotate(45deg); -moz-transform: translateX(-50%) translateY(-50%) rotate(45deg); -ms-transform: translateX(-50%) translateY(-50%) rotate(45deg); transform: translateX(-50%) translateY(-50%) rotate(45deg); ';
				$dirCSShoverAfter = ' opacity: 1; ';
				$dirCSSbg = 'background-color: transparent;';
			}else{
				//
			}

			if($text_color != '') {
				$styles[] = 'color:' . $text_color;
				$styles[] = 'border: 3px solid ' . $hover_background;
			}

			$cStyles = (is_array($styles)) ? ' '.implode("; ", $styles).'' : '';

			$output .= '<style type="text/css">';
			$output .= '#hover-fill-'.$id.'{ '.$cStyles.'; z-index: 1; overflow: hidden; background: '.$background.'; }';
			$output .= '#hover-fill-'.$id.':hover{ color: '.$background.'; '.$dirCSSbg.' }';
			$output .= '#hover-fill-'.$id.':after{ background: '.$hover_background.'; '.$dirCSS.' }';
			$output .= '#hover-fill-'.$id.':hover:after{ '.$dirCSShoverAfter.' }';
			$output .= '</style>';

			$output .= '<a class="eff-wrap" href="'.$link.'" target="'.$target.'"><button id="hover-fill-'.$id.'" class="eff-btn '.$size.' '.$hover_direction.'">'.$btn_icon.$spacer.do_shortcode($content).'</button></a>';


	// FANCY ICON
	}elseif($hover_effect == 'fancy-icon'){

			if ($icon_position == 'ss-icon-left') {
				$btn_icon_top = '';
				$btn_icon_left = '<i class="fa fa-'.$icon.$spin.'"></i>';
				$btn_icon_right = '';
			}elseif($icon_position == 'ss-icon-right'){
				$btn_icon_top = '';
				$btn_icon_left = '';
				$btn_icon_right = '<i class="fa fa-'.$icon.$spin.'"></i>';
			}elseif($icon_position == 'ss-icon-top'){
				$btn_icon_top = '<div class="ss-top-icon"><i class="fa fa-'.$icon.$spin.'"></i></div>';
				$btn_icon_left = '';
				$btn_icon_right = '';
			}	

			if($text_color != '') {
				$styles[] = 'color:' . $text_color;
			}
			if($background != '') {
				$spanBG = 'background:' . $background;
			}
			if($icon_color != '') {
				$iconColor = 'color:' . $icon_color;
			}else{
				$iconColor = 'color: #ffffff';
			}
			if($icon_background != '') {
				$iconBG = 'background:' . $icon_background;
			}else{
				$iconBG = 'background: #333333';
			}

			for ($x=1; $x < 20; $x++){
			    // Start color: 
			    $c = SupremeShortcodes__ColorDarken($background, ($x * 2));
			    $c_lighter = SupremeShortcodes__ColorDarken($background, ($x * 1));
			    $c_darker = SupremeShortcodes__ColorDarken($background, ($x * 3));
			}


			if($icon_position !== 'ss-icon-top'){

				if ($icon_separator == 'ss-sep-transparent') {

					if ($icon_position == 'ss-icon-left'){
						$borderSep = 'margin-right: 2px;';
					}elseif($icon_position == 'ss-icon-right'){
						$borderSep = 'margin-left: 2px;';
					}else{
						$borderSep = '';
					}
					
				}

				if ($icon_separator == 'ss-sep-arrow') {
					
					if ($icon_position == 'ss-icon-left'){
						$borderArrowLeft = '<div class="ss-arrow"></div>';
						$borderArrowRight = '';
					}elseif($icon_position == 'ss-icon-right'){
						$borderArrowLeft = '';
						$borderArrowRight = '<div class="ss-arrow"></div>';
					}else{
						$borderArrowLeft = '';
						$borderArrowRight = '';
					}

				}

				if ($icon_separator == 'ss-sep-diagonal') {
					
					if ($icon_position == 'ss-icon-left'){
						$borderArrowLeft = '<div class="ss-diagonal"></div>';
						$borderArrowRight = '';
					}elseif($icon_position == 'ss-icon-right'){
						$borderArrowLeft = '';
						$borderArrowRight = '<div class="ss-diagonal"></div>';
					}else{
						$borderArrowLeft = '';
						$borderArrowRight = '';
					}

				}

			}else{

				$borderSep = '';

			}
			

			if($icon_position == 'ss-icon-top'){
				if($background != '') {
					$styles[] = '-webkit-box-shadow: 0 4px ' . $c;
					$styles[] = '-moz-box-shadow: 0 4px ' . $c;
					$styles[] = 'box-shadow: 0 4px ' . $c;
				}
			}

			$cStyles = (is_array($styles)) ? ' '.implode("; ", $styles).'' : '';

			$output .= '<style type="text/css">';
			$output .= '#hover-fancy-'.$id.'{ '.$cStyles.'; }';
			$output .= '#hover-fancy-'.$id.' span:hover{ background: '.$c_lighter.'; }';
			$output .= '#hover-fancy-'.$id.' span:active{ background: '.$c_darker.'; }';
			$output .= '#hover-fancy-'.$id.' i{ '.$iconBG.'; '.$borderSep.$iconColor.'}';
			$output .= '#hover-fancy-'.$id.' .ss-top-icon{ '.$iconBG.'}';
			$output .= '#hover-fancy-'.$id.' span{ '.$spanBG.'; }';
			$output .= '#hover-fancy-'.$id.'.ss-icon-left .ss-arrow{ border-color: transparent transparent transparent '.$icon_background.'; }';
			$output .= '#hover-fancy-'.$id.'.ss-icon-right .ss-arrow{ border-color: transparent '.$icon_background.' transparent transparent; }';
			$output .= '#hover-fancy-'.$id.' .ss-diagonal{ background: '.$icon_background.'; }';
			$output .= '</style>';

			$output .= '<a class="eff-wrap" href="'.$link.'" target="'.$target.'"><button id="hover-fancy-'.$id.'" class="eff-btn '.$size.' hover-fancy '.$icon_position.' '.$icon_separator.'">'.$btn_icon_top.$btn_icon_left.$borderArrowLeft.'<span>'.do_shortcode($content).'</span>'.$borderArrowRight.$btn_icon_right.'</button></a>';

	// WITH ARROWS
	}elseif($hover_effect == 'with-arrows'){

			if ($icon == '') {
				$btn_icon = '';
			}elseif($icon !== 'none'){
				$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
			}else{
				$btn_icon = '';
			}

			for ($x=1; $x < 20; $x++){
			    // Start color: 
			    $c = SupremeShortcodes__ColorDarken($background, ($x * 3));
			}

			if($text_color != '') {
				$styles[] = 'color:' . $text_color;
			}

			if($background != '') {
				$styles[] = 'background:' . $background;
				$hoverBG = 'background:' . $c;
			}else{
				$styles[] = 'background: transparent';
				$hoverBG = 'background: rgba(0, 0, 0, 0.08)';
			}

			$cStyles = (is_array($styles)) ? ' '.implode("; ", $styles).'' : '';

			$output .= '<style type="text/css">';
			$output .= '#hover-arrow-'.$id.'{ '.$cStyles.'; border: 3px solid '.$text_color.' }';
			$output .= '#hover-arrow-'.$id.':hover{ '.$hoverBG.'; }';
			$output .= '</style>';

			$output .= '<a class="eff-wrap" href="'.$link.'" target="'.$target.'"><button id="hover-arrow-'.$id.'" class="eff-btn hover-arrow '.$size.' '.$arrow_direction.'">'.$btn_icon.$spacer.do_shortcode($content).'</button></a>';


	// ICON ON HOVER
	}elseif($hover_effect == 'icon-on-hover'){

			if ($icon == '') {
				$btn_icon = '';
			}elseif($icon !== 'none'){
				$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
			}else{
				$btn_icon = '';
			}

			for ($x=1; $x < 20; $x++){
			    // Start color: 
			    $c = SupremeShortcodes__ColorDarken($background, ($x * 3));
			}

			if($text_color != '') {
				$styles[] = 'color:' . $text_color;
			}
			if($background != '') {
				$styles[] = 'background:' . $background;
			}

			$cStyles = (is_array($styles)) ? ' '.implode("; ", $styles).'' : '';

			$output .= '<style type="text/css">';
			$output .= '#hover-icon-'.$id.'{ '.$cStyles.'; border: 4px '.$border_style.' '.$background.' }';
			$output .= '#hover-icon-'.$id.':hover{ background: '.$background.'; }';
			$output .= '</style>';

			$output .= '<a class="eff-wrap" href="'.$link.'" target="'.$target.'"><button id="hover-icon-'.$id.'" class="eff-btn hover-icon '.$size.' '.$icon_direction.'">'.'<div class="ss-icon-on-hover">'.$btn_icon.'</div><span>'.do_shortcode($content).'</span></button></a>';


	// BORDERED
	}elseif($hover_effect == 'bordered'){

			if ($icon == '') {
				$btn_icon = '';
			}elseif($icon !== 'none'){
				$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
			}else{
				$btn_icon = '';
			}

			if ($border_type == 'ss-thick') {
				$border_style = 'solid';
			}elseif($border_type == 'ss-dashed'){
				$border_style = 'dashed';
			}elseif($border_type == 'ss-dotted'){
				$border_style = 'dotted';
			}elseif($border_type == 'ss-double'){
				$border_style = 'double';
			}

			if($text_color != '') {
				$styles[] = 'color:' . $text_color;
			}
			if($background != '') {
				$styles[] = 'background:' . $background;
				$styles[] = 'border-color:' . $background;
			}

			$cStyles = (is_array($styles)) ? ' '.implode("; ", $styles).'' : '';

			$output .= '<style type="text/css">';
			$output .= '#hover-bordered-'.$id.'{ '.$cStyles.'; border: 4px '.$border_style.' '.$background.' }';
			$output .= '#hover-bordered-'.$id.':hover{ color: '.$background.'; background: transparent; }';
			$output .= '</style>';

			$output .= '<a class="eff-wrap" href="'.$link.'" target="'.$target.'"><button id="hover-bordered-'.$id.'" class="eff-btn '.$size.' '.$border_type.'">'.$btn_icon.$spacer.do_shortcode($content).'</button></a>';


	}else{
		//
	}


	return $output;

}



$supreme_vc_map["Hover Button"] = array(
	"name" => __("Hover Button", $shortname),
	"base" => "vc_st_hover_button",
	"icon" => "icon-wpb-vc_st_hover_button",
	"category" => array(__('Content', $shortname), __('Social', $shortname), __('Supreme', $shortname) ),
	"description" => __('Beautiful buttons vith various hover effect.', $shortname),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Hover effect", $shortname),
			"param_name" => "hover_effect",
			"value" => array(
					__("Fill In", $shortname) => "fill-in", 
					__("Fancy Icon", $shortname) => "fancy-icon", 
					__("With arrows", $shortname) => "with-arrows", 
					__("Icon on hover", $shortname) => "icon-on-hover", 
					__("Bordered", $shortname) => "bordered"
				),
			"admin_label" => true
	    ),
	    array(
			"type" => "textfield",
			
			"heading" => __("Button Text", $shortname),
			"param_name" => "content",
			"value" => __("Button text goes here", $shortname),
			"description" => __("Text to show in button.", $shortname)
	    ),
	    array(
			"type" => "textfield",
			
			"heading" => __("Button Link", $shortname),
			"param_name" => "link",
			"value" => __("http://", $shortname),
			"description" => __("Text to show in button.", $shortname)
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Button size", $shortname),
			"param_name" => "size",
			"value" => $button_size_arr,
			"description" => __("Select button size.", $shortname),
			"admin_label" => true
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Target", $shortname),
			"param_name" => "target",
			"value" => $button_target_arr,
			"dependency" => Array('element' => "link", 'not_empty' => true)
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Background color", $shortname),
			"param_name" => "background",
			"value" => '#3498db', //Default Red color
			"description" => __("Choose button background color", $shortname)
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Text color", $shortname),
			"param_name" => "text_color",
			"value" => '#ffffff', //Default Red color
			"description" => __("Choose button text color", $shortname)
	    ),
	    array(
			"type" => "supreme_choose_icons",
			"heading" => __("Icon", $shortname),
			"param_name" => "icon",
			"value" => 'none'
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Spin?", $shortname),
			"param_name" => "icon_spin",
			"value" => array(
					__("No", $shortname) => "no",
					__("Yes", $shortname) => "yes"
				),
			"description" => __("If yes, icon will rotate clockwise.", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Border radius", $shortname),
			"param_name" => "border_radius",
			"value" => __("4px", $shortname),
			"description" => __("Example: 4px. The greater number of pixels, more roundness to the button.", $shortname)
	    ),

		array(
			"type" => "dropdown",
			"heading" => __("Hover direction", $shortname),
			"param_name" => "hover_direction",
			"value" => array(
					__("Simple Fade In", $shortname) => "ss-fade-in", 
					__("Top to bottom", $shortname) => "ss-top-to-bottom", 
					__("Left to right", $shortname) => "ss-left-to-right", 
					__("Center expand horizontal", $shortname) => "ss-expand-h", 
					__("Center expand vertical", $shortname) => "ss-expand-v", 
					__("Center expand to corners", $shortname) => "ss-expand-c", 
				),
			"dependency" => Array('element' => "hover_effect", 'value' => 'fill-in')
	    ),
		array(
			"type" => "colorpicker",
			"heading" => __("Hover background color", $shortname),
			"param_name" => "hover_background",
			"value" => '#3498db',
			"description" => __("Background color when button is hovered.", $shortname),
			"dependency" => Array('element' => "hover_effect", 'value' => 'fill-in')
	    ),

		array(
			"type" => "colorpicker",
			"heading" => __("Icon color", $shortname),
			"param_name" => "icon_color",
			"value" => '#3498db',
			"description" => __("Color for icon. Default: #ffffff - white", $shortname),
			"dependency" => Array('element' => "hover_effect", 'value' => 'fancy-icon')
	    ),
		array(
			"type" => "colorpicker",
			"heading" => __("Icon background color", $shortname),
			"param_name" => "icon_background",
			"value" => '#3498db',
			"description" => __("Background color for icon. Default: #333333", $shortname),
			"dependency" => Array('element' => "hover_effect", 'value' => 'fancy-icon')
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Icon position", $shortname),
			"param_name" => "icon_position",
			"value" => array(
					__("Left", $shortname) => "ss-icon-left",  
					__("Right", $shortname) => "ss-icon-right",  
					__("Top", $shortname) => "ss-icon-top",  
				),
			"dependency" => Array('element' => "hover_effect", 'value' => 'fancy-icon')
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Separator", $shortname),
			"param_name" => "icon_separator",
			"value" => array(
					__("None", $shortname) => "ss-sep-none", 
					__("Transparent", $shortname) => "ss-sep-transparent", 
					__("Arrow", $shortname) => "ss-sep-arrow", 
					__("Diagonal", $shortname) => "ss-sep-diagonal", 
				),
			"description" => __("Note: This does not apply for Icon Position: Top", $shortname),
			"dependency" => Array('element' => "hover_effect", 'value' => 'fancy-icon')
	    ),

	    array(
			"type" => "dropdown",
			"heading" => __("Arrow direction", $shortname),
			"param_name" => "arrow_direction",
			"value" => array(
					__("Fly in right", $shortname) => "fly-in-right",
					__("Fly in left", $shortname) => "fly-in-left",
					__("Fly out right", $shortname) => "fly-out-right",
					__("Fly out left", $shortname) => "fly-out-left",
				),
			"description" => __("Choose arrow direction.", $shortname),
			"dependency" => Array('element' => "hover_effect", 'value' => 'with-arrows')
	    ),

	    array(
			"type" => "dropdown",
			"heading" => __("Arrow direction", $shortname),
			"param_name" => "icon_direction",
			"value" => array(
					__("Top to bottom", $shortname) => "top-to-bottom",
					__("Left to right", $shortname) => "left-to-right",
				),
			"description" => __("Choose icon direction.", $shortname),
			"dependency" => Array('element' => "hover_effect", 'value' => 'icon-on-hover')
	    ),

	    array(
			"type" => "dropdown",
			"heading" => __("Border type", $shortname),
			"param_name" => "border_type",
			"value" => array(
					__("Thick", $shortname) => "ss-thick",
					__("Dashed", $shortname) => "ss-dashed",
					__("Dotted", $shortname) => "ss-dotted",
					__("Double", $shortname) => "ss-double",
				),
			"description" => __("Choose border style.", $shortname),
			"dependency" => Array('element' => "hover_effect", 'value' => 'bordered')
	    ),
	    


  	)
);


/* SUPREME ICON BOX */

add_shortcode('vc_st_icon_box','SupremeShortcodes__icon_box');
function SupremeShortcodes__icon_box( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'background'    => '',
		'opacity'    	=> '',
        'border_color'  => '',
        'icon'    		=> '',
        'icon_color'    => '',
        'icon_bg'  		=> '',
        'icon_position' => '',
        'icon_shape'  	=> '',
        'icon_spin'  	=> ''
	), $atts));

	$output = '';

	$spin = '';

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	$content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

	$id = mt_rand();

	$output .= '<div id="ss-icon-box-'.$id.'" class="ss-icon-box-wrap '.$icon_position.'">';
	$output .= '<div class="ss-icon-box '.$icon_shape.'"><i class="fa fa-'.$icon.' ss-icon'.$spin.'"></i></div>';
	$output .= '<div class="ss-icon-box-bg" style="background: '.$background.'; opacity: '.$opacity.';"></div>';
	$output .= '<div class="ss-icon-box-content" style="border: 1px solid '.$border_color.'">';
	$output .= do_shortcode( $content );
	$output .= '<div class="clear"></div>';
	$output .= '</div>';
	$output .= '</div>';

	$output .= '<style type="text/css">';
	$output .= '#ss-icon-box-'.$id.' .ss-icon-box{ background:'.$icon_bg.'; border: 1px solid '.$icon_bg.'; }';
	$output .= '#ss-icon-box-'.$id.' .ss-icon-box i{ color:'.$icon_color.'; }';
	$output .= '#ss-icon-box-'.$id.':hover .ss-icon-box{ background:'.$icon_color.'; border: 1px solid '.$border_color.'; }';
	$output .= '#ss-icon-box-'.$id.':hover .ss-icon-box i{ color:'.$icon_bg.'; }';
	$output .= '</style>';

	return $output;

}

$supreme_vc_map["Icon Box"] = array(
	"name" => __("Icon Box", $shortname),
	"base" => "vc_st_icon_box",
	"icon" => "icon-wpb-vc_st_icon_box",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Insert beautiful icon boxes. Unlimited colors.', $shortname),
	"params" => array(
		array(
			"type" => "colorpicker",
			"heading" => __("Background color", $shortname),
			"param_name" => "background",
			"value" => '#ffffff', //Default
			"description" => __("Choose background color", $shortname)
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Background transparency", $shortname),
			"param_name" => "opacity",
			"value" => array(
					__("0.1", $shortname) => "0.1",
					__("0.2", $shortname) => "0.2",
					__("0.3", $shortname) => "0.3",
					__("0.4", $shortname) => "0.4",
					__("0.5", $shortname) => "0.5",
					__("0.6", $shortname) => "0.6",
					__("0.7", $shortname) => "0.7",
					__("0.8", $shortname) => "0.8",
					__("0.9", $shortname) => "0.9",
					__("1", $shortname) => "1",
				),
			"description" => __("Choose background transparency.", $shortname)
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Border color", $shortname),
			"param_name" => "border_color",
			"value" => '#eeeeee', //Default
			"description" => __("Choose border color", $shortname)
	    ),
	    array(
			"type" => "supreme_choose_icons",
			"heading" => __("Icon", $shortname),
			"param_name" => "icon",
			"value" => 'ambulance'
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Icon color", $shortname),
			"param_name" => "icon_color",
			"value" => '#444444', //Default
			"description" => __("Choose icon color", $shortname)
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Icon background color", $shortname),
			"param_name" => "icon_bg",
			"value" => '#ffffff', //Default
			"description" => __("Choose icon background color", $shortname)
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Icon shape", $shortname),
			"param_name" => "icon_shape",
			"value" => array(
					__("Circle", $shortname) => "icon-circle",
					__("Square", $shortname) => "icon-square"
				),
			"description" => __("Circle or Square icon.", $shortname)
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Icon position", $shortname),
			"param_name" => "icon_position",
			"value" => array(
					__("Top", $shortname) => "icon-top",
					__("Right", $shortname) => "icon-right",
					__("Bottom", $shortname) => "icon-bottom",
					__("Left", $shortname) => "icon-left",
				),
			"description" => __("Choose the position of the icon.", $shortname)
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Spin?", $shortname),
			"param_name" => "icon_spin",
			"value" => array(
					__("No", $shortname) => "no",
					__("Yes", $shortname) => "yes"
				),
			"description" => __("If yes, icon will rotate clockwise.", $shortname)
	    ),
	    array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => __("Icon Box Content", $shortname),
			"param_name" => "content",
			"value" => __("<p>I am text block.</p>", $shortname)
		),
	    

	)

);

/* SUPREME IMAGE SCROLLER */

add_shortcode('vc_st_img_scroller','SupremeShortcodes__img_scroller');
function SupremeShortcodes__img_scroller( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'img_height' => '',
		'img_speed' => '',
		'img_url' => '',
		'img_border' => '',
		'img_border_color' => ''
	), $atts));

	$output = '';

	// if bg image
    $has_image = false;
    if((int)$img_url > 0 && ($image_url = wp_get_attachment_url( $img_url, 'large' )) !== false) {
        $has_image = true;
        $photo_url = $image_url;
    }

	$border_style = ' style="border: '.$img_border.' solid '.$img_border_color.'"';

	$output .= '<div class="st-img-scroller" data-speed="'.$img_speed.'" data-height="'.$img_height.'" onclick="return true" '.$border_style.'>';
	$output .= '<div class="image-holder" style="height:'.$img_height.'px"><img alt="Scrolling Image" src="'.$photo_url.'"></div><div class="clearfix"></div></div>';

	return $output;

}

$supreme_vc_map["Image Scroller"] = array(
	"name" => __("Image Scroller", $shortname),
	"base" => "vc_st_img_scroller",
	"icon" => "icon-wpb-vc_st_img_scroller",
	"category" => array(__('Content', $shortname), __('Supreme', $shortname) ),
	"description" => __('Image scroll on hover. Choose border.', $shortname),
	"params" => array(
	    array(
			"type" => "attach_image",
			"heading" => __("Image URL", $shortname),
			"param_name" => "img_url",
			"value" => "",
			"description" => __("Select image from media library.", $shortname)
		),
	    array(
			"type" => "textfield",
			"heading" => __("Height", $shortname),
			"param_name" => "img_height",
			"value" => __("300", $shortname),
			"description" => __("In pixels. Examlpe: 300.", $shortname)
	    ),
		array(
			"type" => "textfield",
			"heading" => __("Animation Speed", $shortname),
			"param_name" => "img_speed",
			"value" => __("2500", $shortname),
			"description" => __("In miliseconds.", $shortname)
	    ),
	    array(
			"type" => "textfield",
			"heading" => __("Border thickness", $shortname),
			"param_name" => "img_border",
			"value" => __("8px", $shortname),
			"description" => __("Border thickness in pixels.", $shortname)
	    ),
	    array(
			"type" => "colorpicker",
			"heading" => __("Border color", $shortname),
			"param_name" => "img_border_color",
			"value" => '#ffffff', //Default
			"description" => __("Choose border color", $shortname)
	    ),
	)

);