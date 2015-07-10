<?php 

/************************************
	EXPORT/IMPORT Plugin Options
************************************/
//first  add a new query var
if ( ! function_exists( 'SupremeShortcodes__add_query_var_vars' ) ) {
	function SupremeShortcodes__add_query_var_vars() {
	    global $wp;
	    $wp->add_query_var('ss_plugin_export_options');
	}
}

//then add a template redirect which looks for that query var and if found calls the download function
if ( ! function_exists( 'SupremeShortcodes__admin_redirect_download_files' ) ) {
	function SupremeShortcodes__admin_redirect_download_files(){
	    global $wp;
	    global $wp_query;
	    //download theme export
	    if (array_key_exists('ss_plugin_export_options', $wp->query_vars) && $wp->query_vars['ss_plugin_export_options'] == 'safe_download'){
	        SupremeShortcodes__download_file();
	        die();
	    }
	}
}
//add hooks for these functions
add_action('template_redirect', 'SupremeShortcodes__admin_redirect_download_files');
add_filter('init', 'SupremeShortcodes__add_query_var_vars');

//then define the function that will take care of the actual download
if ( ! function_exists( 'SupremeShortcodes__download_file' ) ) {
	function SupremeShortcodes__download_file($content = null, $file_name = null){
	    global $wpdb;
	    global $SupremeTheme__;

	    if (! wp_verify_nonce($_REQUEST['nonce'], 'ss_plugin_export_options') ) 
	        wp_die('Security check'); 

	    //here you get the options to export and set it as content, ex:
	    $qeShortcodes =  "SELECT * FROM  $wpdb->options WHERE option_name REGEXP ('^SupremeShortcodes__')";

	    $options = array();

	   	$shortcodeoptions = $wpdb->get_results($qeShortcodes);
	    foreach($shortcodeoptions as $shortcodeoption) {
	        $retval .= "\r\n(" .$shortcodeoption->option_id. ", '" .$shortcodeoption->option_name. "', '" .$shortcodeoption->option_value. "', '" .$shortcodeoption->autoload. "'), " ;
	        $curr_option = array("name"=>$shortcodeoption->option_name, "value"=>$shortcodeoption->option_value, "autoload"=>$shortcodeoption->autoload);
	        array_push($options,$curr_option);
	    }

	    $content = json_encode($options);

	    $currentDate = date('l-jS-F-Y');

	    $file_name = 'SupremeShortcodes-Export-'.$currentDate.'.txt';
	    header('HTTP/1.1 200 OK');


	    if ( !current_user_can('edit_themes') ){
	        wp_die('<p>'.__('You do not have sufficient permissions to be here.').'</p>');
	    }
	    if ($content === null || $file_name === null){
	        wp_die('<p>'.__('Error Downloading file.').'</p>');     
	    }

	    $fsize = strlen($content);
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	   // header('Content-Description: File Transfer');
	    header("Content-Disposition: attachment; filename=" . $file_name);
	    header("Content-Length: ".$fsize);
	    header("Expires: 0");
	    header("Pragma: public");
	    echo $content;
	    exit;
	}
}

//and last a simple function to create the download export url / link
if ( ! function_exists( 'SupremeShortcodes__create_export_download_link' ) ) {
	function SupremeShortcodes__create_export_download_link($echo = false){
		$shortname = 'SupremeShortcodes';

	    $site_url = home_url();
	    $args = array(
	        'ss_plugin_export_options' => 'safe_download',
	        'nonce' => wp_create_nonce('ss_plugin_export_options')
	    );
	    $export_url = esc_url(add_query_arg($args, $site_url));
	    
	    if ($echo === true)
	        echo '<a class="button-secondary blue" href="'.$export_url.'" target="_blank" style="margin-right:10px;margin-bottom: 3px;">'.__('Backup', $shortname).'</a>';
	    elseif ($echo == 'url')
	        return $export_url;
	    return '<a class="button-secondary blue" href="'.$export_url.'" target="_blank" style="margin-right:10px;margin-bottom: 3px;">'.__('Backup', $shortname).'</a>';
	}
}
/************************************
	END EXPORT/IMPORT Plugin Options
************************************/

?>