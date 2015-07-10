<?php 
	require('../../../../wp-blog-header.php');
	if (!is_user_logged_in()){
		die("You are not logged in! Please log in to use Supreme Shortcodes Admin Panel!");
	} 

	header('HTTP/1.1 200 OK');
	
	
	//Restore Theme Options
	if($_GET['act'] == 'ss_restore_plugin_options' && isset($_GET["file"]) ) {

		$file_text = file_get_contents(urldecode($_GET["file"]));

	    $options = json_decode($file_text);

	    $log = "";

	    for ($i = 0; $i < count($options); $i++) {
	        $opt_name = $options[$i]->name;
	        $opt_val = $options[$i]->value;
	        $opt_auto = $options[$i]->autoload;


	        delete_option( $opt_name );

	        $deprecated = ' ';
	        $autoload = 'no';
	        add_option( $opt_name, $opt_val, $deprecated, $autoload );

	        $log .= $opt_name." ::: ".$opt_val."\n\n";
	        
	    }

	    die('{"success":1}');
	    
	}

?>
