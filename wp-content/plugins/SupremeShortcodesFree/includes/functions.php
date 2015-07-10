<?php 
/* ADMIN NOTICE FOR GO PRO */
add_action('admin_notices', 'SupremeShortcodesFree__admin_notice_go_pro');
function SupremeShortcodesFree__admin_notice_go_pro() {
	global $current_user ;
        $user_id = $current_user->ID;
	if ( ! get_user_meta($user_id, 'SupremeShortcodesFree__go_pro_ignore_notice') ) {
		parse_str($_SERVER['QUERY_STRING'], $params);
		echo '<style type="text/css">div.updated.supreme-notice{ border-top: 1px solid #F599AB;border-right: 1px solid #F599AB;border-bottom: 1px solid #F599AB;border-left: 4px solid #DB4360;}</style>';
        echo '<div class="updated supreme-notice"><p>'; 
        printf(__('Reveal more features with <a href="http://codecanyon.net/item/supreme-shortcodes-wordpress-plugin/6340769?ref=supremefactory&license=regular&open_purchase_for_item_id=6340769&purchasable=source">Supreme Shortcodes PRO</a> - WordPress plugin.'), '?' . http_build_query(array_merge($params, array('SupremeShortcodesFree__nag_ignore'=>'0'))));
        echo "</p></div>";
	}
}

add_action('admin_init', 'SupremeShortcodesFree__nag_ignore');
function SupremeShortcodesFree__nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        if ( isset($_GET['SupremeShortcodesFree__nag_ignore']) && '0' == $_GET['SupremeShortcodesFree__nag_ignore'] ) {
            add_user_meta($user_id, 'SupremeShortcodesFree__go_pro_ignore_notice', 'true', true);
	}
}
?>