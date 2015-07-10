<?php

$ss_hover_div = stripslashes(get_option('SupremeShortcodes__hover_div', ''));
$ss_ol_bg = stripslashes(get_option('SupremeShortcodes__ol_bg', ''));
$ss_primary_button = stripslashes(get_option('SupremeShortcodes__primary_button', ''));
$ss_secondary_button = stripslashes(get_option('SupremeShortcodes__secondary_button', ''));
$ss_toggle_bg = stripslashes(get_option('SupremeShortcodes__toggle_bg', ''));
$ss_audio_rail_bg = stripslashes(get_option('SupremeShortcodes__audio_rail', ''));
$ss_to_top = stripslashes(get_option('SupremeShortcodes__to_top', ''));
$ss_contact_button = stripslashes(get_option('SupremeShortcodes__contact_button', ''));
$ss_tabs_bg = stripslashes(get_option('SupremeShortcodes__tab_bg', ''));
$ss_tabs_text = stripslashes(get_option('SupremeShortcodes__tab_text', ''));

// Darker than primary color
function SupremeShortcodes__DarkenPrimaryColor($color, $dif=10){
 
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

for ($x=1; $x < 10; $x++){
    // Start color: 
    $c = SupremeShortcodes__DarkenPrimaryColor($ss_primary_button, ($x * 3));
}

?>

<!-- PRINT CUSTOM STYLES -->
<style type="text/css">

	/* SS CUSTOM STYLE */

	.flexslider-posts .slides > li .hover_div,
	.swiper-slide .hover_div,
	.flexslider-posts .slides > li .title_active,
	.swiper-slide .title_active{
		background-color: <?php echo $ss_hover_div; ?> !important; 
	}

	.entry-content .LISTstyled ol > li::before,
	.LISTstyled ol > li::before{
		background-color: <?php echo $ss_ol_bg;  ?>;
	}

	.ss-btn.primary, .ss-btn.primary:hover, .ss-btn.primary:active, .ss-btn.primary:focus{
		background: none repeat scroll 0 0  <?php echo $ss_primary_button;  ?>;
		border: 1px solid <?php echo $ss_primary_button;  ?>;
		-webkit-box-shadow: 0 4px <?php echo $c; ?>;
		-moz-box-shadow: 0 4px <?php echo $c; ?>;
		box-shadow: 0 4px <?php echo $c; ?>;
	}

	.divider_top .to-top{
		background: <?php echo $ss_to_top; ?>;
	}


	.mejs-controls .mejs-time-rail .mejs-time-loaded{
		background: <?php echo $ss_audio_rail_bg;  ?>;
	}

	.st-accordion .panel-heading i{
		background: none repeat scroll 0 0  <?php echo $ss_toggle_bg;  ?>;
	}

	.ss-contact-form-wrapper .ss-button{
		background-color: <?php echo $ss_contact_button;  ?>;
		border-color: <?php echo $ss_contact_button;  ?>;
		outline: none;
	}

	.st-tabs .active > a, 
	.st-tabs .active > a:hover,
	.tab-content{
		background-color: <?php echo $ss_tabs_bg;  ?>;
		color: <?php echo $ss_tabs_text;  ?>;
	}


</style>
