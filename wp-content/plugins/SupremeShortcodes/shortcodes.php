<?php

$supremeshortcodes_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodes');
$currentFile = __FILE__;
$currentFolder = dirname($currentFile);

global $shortname;

$output = '';


// Clean empty <p> tags inside shortcodes
function SupremeTheme__cleanup_shortcode($content) {   
	 $array = array (
	    '<p>[' => '[',
	    ']</p>' => ']',
	    ']<br />' => ']'
	);

	$content = strtr( $content, $array );

	return $content;
}
add_filter('the_content', 'SupremeTheme__cleanup_shortcode', 10);


///////////////////////////////////////////
//				SHORTCODES 				 //
///////////////////////////////////////////

function SupremeTheme__no_texturized_shortcodes_filter( $shortcodes ) {
	$shortcodes[] = 'code';
	$shortcodes[] = 'precode';
	return $shortcodes;
}

function SupremeTheme__code( $atts, $content = null ) {
	return '<code>' . do_shortcode( $content ) . '</code>';
}


function SupremeTheme__dropcap($atts, $content = null) {
	 extract(shortcode_atts(array(
		'type' => 'light'
	), $atts)); 
	return '<span class="dropcap '.$type.'">' . do_shortcode( $content ) . '</span>';
}

function SupremeTheme__highlight($atts, $content = null) {
	 extract(shortcode_atts(array(
		'text_color' => '',
		'background_color' => ''
	), $atts)); 	
	return '<span class="highlight" style="background: '.$background_color.'; color: '.$text_color.';">' . do_shortcode( $content ) . '</span>';
}

function SupremeTheme__label($atts, $content = null) {
	 extract(shortcode_atts(array(
		'type' => 'default'
	), $atts)); 	
	return '<span class="label '.$type.'">' . do_shortcode( $content ) . '</span>';
}

function SupremeTheme__table( $atts ) {
	extract(shortcode_atts(array(
		'cols' => 'none',
		'data' => 'none',
	), $atts));

	$output = '';

	$cols = explode('||',$cols);
	$data = explode('||',$data);
	$total = count($cols);

	$output .= '<div class="table-responsive">';
	$output .= '<table class="table table-hover table-bordered table-striped"><thead><tr>';
	foreach($cols as $col) {
		$output .= '<th>'.$col.'</th>';
	}
	$output .= '</tr></thead>';
	$counter = 1;
	$footer = '';
	$curr_row = 0;

	foreach($data as $drow) {

		if ($curr_row == 0) {
			$footer = do_shortcode( $drow );
			if ($footer != "") {
				$output .= '<tfoot><tr><td colspan="'.$total.'">'.$footer.'</td></tr></tfoot>';
			}
			$output .= "<tbody><tr>";
			$curr_row++;
		} else {
			$output .= '<td>'.do_shortcode( $drow ).'</td>';
			if($counter%$total==1) {
				$output .= '</tr>';
			};
		}
		$counter++;
	}
	$output .= '</tbody></table>';
	$output .= '</div>';

	return $output;
}

function ColorDarken($color, $dif=20){
 
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


function SupremeTheme__button($atts, $content = null) {
	extract(shortcode_atts(array(
		'text_color' => '#ffffff',
		'link' => '',
		'background' => '',
		'size' => '',
		'type' => '',
		'icon' => '',
		'target' => '',
		'border_radius' => '',
        'icon_spin'		=> ''
	), $atts));

	$output = '';
	$spin = '';

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	if ($content !== '' && $icon !== '') {
		$spacer = '<span class="spacer"></span>';
	}else{
		$spacer = '';
	}

	if ($size == 'btn' || $size == 'n') {
		$size = 'ss-btn';
	}else{
		$size = $size;
	}

	if ($icon == '') {
		$btn_icon = '';
	}elseif($icon !== 'none'){
		$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
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
	    $c = ColorDarken($background, ($x * 3));
	}

	if($text_color != '') {
		$styles[] = 'color:' . $text_color;
	}
	if($background != '') {
		$styles[] = 'background:' . $background;
		$styles[] = 'border-color:' . $background;
		$styles[] = '-webkit-box-shadow: 0 4px ' . $c;
		$styles[] = '-moz-box-shadow: 0 4px ' . $c;
		$styles[] = 'box-shadow: 0 4px ' . $c;
	}

	$cStyles = (is_array($styles)) ? ' style="'.implode("; ", $styles).'"' : '';
	$output = '<a href="'.$link.'" class="ss-btn '.$size.'"'.$cStyles.' target="'.$target.'">'.$btn_icon.$spacer.do_shortcode($content).'</a>';
	return $output;
}


function SupremeTheme__hover_fill_button($atts, $content = null) {
	extract(shortcode_atts(array(
		'text_color' => '#ffffff',
		'link' => '',
		'background' => '',
		'hover_background' => '',
		'size' => '',
		'icon' => '',
		'target' => '',
		'hover_direction' => '',
		'border_radius' => '',
        'icon_spin'		=> ''
	), $atts));

	$output = '';
	$spin = '';

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	$id = mt_rand();

	if ($content !== '' && $icon !== 'fa fa-') {
		$spacer = '<span class="spacer"></span>';
	}else{
		$spacer = '';
	}

	if ($icon == '') {
		$btn_icon = '';
	}elseif($icon !== 'none'){
		$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
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
	$output .= '#hover-fill-'.$id.'{ '.$cStyles.'; z-index: 1; overflow: hidden; }';
	$output .= '#hover-fill-'.$id.':hover{ color: '.$background.'; '.$dirCSSbg.' }';
	$output .= '#hover-fill-'.$id.':after{ background: '.$hover_background.'; '.$dirCSS.' }';
	$output .= '#hover-fill-'.$id.':hover:after{ '.$dirCSShoverAfter.' }';
	$output .= '</style>';

	$output .= '<a class="eff-wrap" href="'.$link.'" target="'.$target.'"><button id="hover-fill-'.$id.'" class="eff-btn '.$size.' '.$hover_direction.'">'.$btn_icon.$spacer.do_shortcode($content).'</button></a>';

	return $output;
}



function SupremeTheme__hover_fancy_icon_button($atts, $content = null) {
	extract(shortcode_atts(array(
		'text_color' => '#ffffff',
		'link' => '',
		'background' => '',
		'size' => '',
		'icon' => '',
		'target' => '',
		'icon_color' => '',
		'icon_background' => '',
		'icon_position' => '',
		'icon_separator' => '',
		'border_radius' => '',
        'icon_spin'		=> ''
	), $atts));

	$output = '';
	$spin = '';

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	$id = mt_rand();


	if ($icon == '') {
		$btn_icon = '';
	}elseif($icon !== 'none'){
		$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
	}else{
		$btn_icon = '';
	}

	if ($icon_position == 'ss-icon-left') {
		$btn_icon_top = '';
		$btn_icon_left = '<i class="fa fa-'.$icon.'"></i>';
		$btn_icon_right = '';
	}elseif($icon_position == 'ss-icon-right'){
		$btn_icon_top = '';
		$btn_icon_left = '';
		$btn_icon_right = '<i class="fa fa-'.$icon.'"></i>';
	}elseif($icon_position == 'ss-icon-top'){
		$btn_icon_top = '<div class="ss-top-icon"><i class="fa fa-'.$icon.'"></i></div>';
		$btn_icon_left = '';
		$btn_icon_right = '';
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

	if($text_color != '') {
		$styles[] = 'color:' . $text_color;
		//$iconBG = ' background:' . $text_color. '; ';
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
	    $c = ColorDarken($background, ($x * 2));
	    $c_lighter = ColorDarken($background, ($x * 1));
	    $c_darker = ColorDarken($background, ($x * 3));
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

	return $output;
}



function SupremeTheme__hover_arrows_button($atts, $content = null) {
	extract(shortcode_atts(array(
		'text_color' => '#ffffff',
		'link' => '',
		'background' => '',
		'size' => '',
		'icon' => '',
		'target' => '',
		'border_radius' => '',
		'arrow_direction' => '',
        'icon_spin'		=> ''
	), $atts));

	$output = '';
	$spin = '';

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	$id = mt_rand();

	if ($content !== '' && $icon !== 'fa fa-') {
		$spacer = '<span class="spacer"></span>';
	}else{
		$spacer = '';
	}

	if ($icon == '') {
		$btn_icon = '';
	}elseif($icon !== 'none'){
		$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
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
	    $c = ColorDarken($background, ($x * 3));
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

	return $output;
}



function SupremeTheme__hover_icon_button($atts, $content = null) {
	extract(shortcode_atts(array(
		'text_color' => '#ffffff',
		'link' => '',
		'background' => '',
		'size' => '',
		'icon' => '',
		'target' => '',
		'icon_direction' => '',
		'border_radius' => '',
        'icon_spin'		=> ''
	), $atts));

	$output = '';
	$spin = '';

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	$id = mt_rand();

	if ($icon == '') {
		$btn_icon = '';
	}elseif($icon !== 'none'){
		$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
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
	    $c = ColorDarken($background, ($x * 3));
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

	return $output;
}


function SupremeTheme__hover_bordered_button($atts, $content = null) {
	extract(shortcode_atts(array(
		'text_color' => '#ffffff',
		'link' => '',
		'background' => '',
		'size' => '',
		'icon' => '',
		'target' => '',
		'border_radius' => '',
		'border_type' => '',
        'icon_spin'		=> ''
	), $atts));

	$output = '';
	$spin = '';

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

	$id = mt_rand();

	if ($content !== '' && $icon !== 'fa fa-') {
		$spacer = '<span class="spacer"></span>';
	}else{
		$spacer = '';
	}

	if ($icon == '') {
		$btn_icon = '';
	}elseif($icon !== 'none'){
		$btn_icon = '<i class="fa fa-'.$icon.$spin.'"></i>';
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

	return $output;
}



function SupremeTheme__unordered( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'listicon' => '1'
	), $atts));
	$output = '';
	$output = '<div class="unordered_list '.$listicon.'">'.$content.'</div>';
	return $output;
}

function SupremeTheme__box( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'type' => '',
		'icon' => ''
	), $atts));

	$output = '';

	if($icon != '') {
		$styles = '<img alt="" src="' . $icon .'" width="50" />';
	}else{
		$styles = '';
	}

	$output = '<div class="alert-message '.$type.'">'.$styles.'<h3>'.$title.'</h3><p>'.do_shortcode( $content ).'</p></div>';
	return $output;
}


function SupremeTheme__callout( $atts, $content = null ){
	extract(shortcode_atts(array(
		'title' => '',
		'text' => '',
		'button_text' => '',
		'link' => '',
		'text_color' => '',
		'background' => '',
	), $atts));

	$output = '';

	for ($x=1; $x < 20; $x++){
	    // Start color: 
	    $c = ColorDarken($background, ($x * 3));
	}

	if($text_color != '') {
		$styles[] = 'color:' . $text_color;
	}
	if($background != '') {
		$styles[] = 'background:' . $background;
		$styles[] = 'border-color:' . $background;
		$styles[] = 'box-shadow: 0 4px ' . $c;
	}

	$cStyles = (is_array($styles)) ? 'style="'.implode("; ", $styles).'"' : '';
	
	$output .= '<div class="ss-callout row row-fluid">';
	$output .= '<div class="col-md-9 callout-body">';
	$output .= '<h3>'.$title.'</h3>';
	$output .= '<p>'.do_shortcode( $content ).'</p>';
	$output .= '</div>';
	$output .= '<div class="col-md-3">';
	$output .= '<a class="ss-btn btn-callout large pull-right" '.$cStyles.' href="'.$link.'">'.$button_text.'</a>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}

function SupremeTheme__tooltip( $atts, $content = null ){
	extract(shortcode_atts(array(
		'type' => '',
		'text' => '',
		'tooltip_text' => ''
	), $atts));

	$output = '';
	
	$output .= '<span class="tooltip_wrap"><a class="tooltipa" href="#" data-toggle="tooltip" data-placement="'.$type.'" title="" data-original-title="'.$tooltip_text.'">'.do_shortcode( $content ).'</a></span>';

	return $output;
}

function SupremeTheme__popover( $atts, $content = null ){
	extract(shortcode_atts(array(
		'type' => '',
		'text' => '',
		'popover_title' => ''
	), $atts));
	
	$output = '';

	$output .= '<a href="#" class="ss-btn popovers" data-toggle="popover" data-placement="'.$type.'" data-content="'.$text.'" title="" data-original-title="'.$popover_title.'">'.do_shortcode( $content ).'</a>';
	return $output;
}

function SupremeTheme__modal( $atts, $content = null ){
	extract(shortcode_atts(array(
		'modal_title' => '',
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

	$output .= '<div class="ss-modal modal fade" id="'.$rnd.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
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


function SupremeTheme__ordered( $atts, $content = null ) {

	return '<div class="LISTstyled">' . do_shortcode( $content ) . '</div>';
		
}



// this variable will hold your divs
$tabs_divs = '';

function SupremeTheme__tabs( $atts, $content ) {
    global $tabs_divs;

    $output = '';

    // reset divs
    $tabs_divs = '';

    extract(shortcode_atts(array(  
        'id' => '',
        'class' => ''
    ), $atts)); 

    $tabs_id = rand(100,1000); 

    $output = '<ul id="'.$tabs_id.'" class="st-tabs" data-tabs="tab"  ';

    if(!empty($id))
        $output .= 'id="'.$id.'"';

    $output.='>'.do_shortcode($content).'</ul>';
    $output.= '<div id="my-tab-content-'.$tabs_id.'" class="tab-content">'.$tabs_divs.'</div>';

    return $output;  
}  


function SupremeTheme__tab($atts, $content) {  
    global $tabs_divs;

    extract(shortcode_atts(array(  
        'id' => '',
        'title' => '',
        'active'=>'n' 
    ), $atts));  

    $output = '';

    if(empty($id))
        $id = 'tab_item_'.rand(100,999);

    $activeClass = $active == 'y' ? 'active' :'';
    $output = '
        <li class="'.$activeClass.'">
            <a href="#'.$id.'">'.$title.'</a>
        </li>
    ';

    $tabs_divs.= '<div class="tab-pane fade in '.$activeClass.'" id="'.$id.'">'.do_shortcode( $content ).'</div>';

    return $output;
}



function SupremeTheme__panel( $atts, $content ) {
	global $post;

	$output = '';
	
	extract(shortcode_atts(array(
				'title' => '',
				'state' => ''
			), $atts) );

	$id = base_convert(microtime(), 10, 36); // a random id generated for each tab group.

	$output = '';

	if ($state == 'closed') {
		$finale_state = 'collapsed';
		$finale_icon = 'plus';
		$finale_in = '';
	} else{
		$finale_state = '';
		$finale_icon = 'minus';
		$finale_in = 'in';
	}

	$output .= '	<div class="panel panel-default">';
	$output .= '		<div class="panel-heading">';
	$output .= '			<h4 class="panel-title">';
	$output .= '				<a data-toggle="collapse" data-parent="#accordion-'.$id.'" href="#collapse-'.$id.'" class="st-toggle '.$finale_state.'"><i class="fa fa-'.$finale_icon.' st-size-2"></i> <span>'.$title.'</span></a>';
	$output .= '			</h4>';
	$output .= '		</div>';
	$output .= '		<div id="collapse-'.$id.'" class="panel-collapse collapse '.$finale_in.'">';
	$output .= '			<div class="panel-body">';
	$output .= 					do_shortcode( $content );
	$output .= '			</div>';
	$output .= '		</div>';
	$output .= '	</div>';

	return $output;
}



function SupremeTheme__toggle( $atts, $content ) {
	if( is_string($atts) )
		$atts = array();

	$output = '';
	$id = base_convert(microtime(), 10, 36);

	$output .= '<div class="panel-group st-accordion" id="accordion-'.$id.'">'.do_shortcode( $content ).'</div>';

	return $output;
}


function SupremeTheme__acc_panel( $atts, $content ) {
	global $post;

	$output = '';
	
	extract(shortcode_atts(array(
				'title' => '',
				'state' => ''
			), $atts) );

	$id = base_convert(microtime(), 10, 36); // a random id generated for each tab group.

	$output = '';

	if ($state == 'closed') {
		$finale_state = 'collapsed';
		$finale_icon = 'plus';
		$finale_in = '';
	} else{
		$finale_state = '';
		$finale_icon = 'minus';
		$finale_in = 'in';
	}

	$output .= '	<div class="panel panel-default">';
	$output .= '		<div class="panel-heading">';
	$output .= '			<h4 class="panel-title">';
	$output .= '				<a data-toggle="collapse" data-parent="#init" href="#collapse-'.$id.'" class="st-toggle '.$finale_state.'"><i class="fa fa-'.$finale_icon.' st-size-2"></i> <span>'.$title.'</span></a>';
	$output .= '			</h4>';
	$output .= '		</div>';
	$output .= '		<div id="collapse-'.$id.'" class="panel-collapse collapse '.$finale_in.'">';
	$output .= '			<div class="panel-body">';
	$output .= 					do_shortcode( $content );
	$output .= '			</div>';
	$output .= '		</div>';
	$output .= '	</div>';

	return $output;
}

function SupremeTheme__accordion( $atts, $content ) {
	if( is_string($atts) )
		$atts = array();

	$output = '';

	$id = base_convert(microtime(), 10, 36);

	$output .= '<div class="panel-group st-accordion ss-accordion" id="accordion-'.$id.'">'.do_shortcode( $content ).'</div>';

	return $output;
}


function SupremeTheme__related_posts($atts) {
	extract(shortcode_atts(array(
		'limit' => '5',
	), $atts));

	global $shortname;
	
	global $wpdb, $post, $table_prefix;
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
			$retval .= "\n" . '<li>'.__('No related posts found', $shortname).'</li>' . "\n";
		}
		$retval .= '</ul>' . "\n";
		return '<h2 class="share-word"><span>'.__('Related posts', $shortname).'</span></h2>'."\n".$retval;
	}
	return;
}


function SupremeTheme__loginout($atts, $content = null) {
	extract(shortcode_atts(array(
		'login_msg' => 'Log In',
		'logout_msg' => 'Log Out',
		'text_color' => '#ffffff',
		'background' => '',
		'size' => 'ss-btn',
		'type' => 'empty'
	), $atts));

	$output = '';

	for ($x=1; $x < 20; $x++){
	    // Start color: 
	    $c = ColorDarken($background, ($x * 3));
	}

	if ($size == 'btn') {
		$size = 'ss-btn';
	}else{
		$size = $size;
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
	// from includes/general-template.php, wp_loginout()
	if (!is_user_logged_in()) {
		$output = '<a href="' . esc_url(wp_login_url()) . '" class="ss-btn '.$size.'"'.$cStyles.'>' . $login_msg . '</a>';
	} else {
		$output = '<a href="' . esc_url(wp_logout_url()) . '" class="ss-btn '.$size.'"'.$cStyles.'>' . $logout_msg . '</a>';
	}
	return ($output);
}

function SupremeTheme__quote($atts, $content = null) {
	extract(shortcode_atts(array(
		'author' => ''
	), $atts));
	$cite = "";
	$type = '';
	if ($author != "") {
		$cite = "<cite>".$author."</cite>";
	}
	return '<blockquote class="QUOTE '.$type.'"><p>' . do_shortcode($content) . '</p>'.$cite.'</blockquote>';
}


function SupremeTheme__text_color( $atts, $content = null ) {
    extract( shortcode_atts( array(
            'color'     => ''
        ), $atts ) );

    if ($color == '') {
    	$final_color = '#444444';
    }else{
    	$final_color = $color;
    }

    return '<span style="color:'.$final_color.'">' . do_shortcode($content) . '</span>';
}



function SupremeTheme__abbr($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => ''
	), $atts));
	$output = '';
	$output = '<abbr title="'.$title.'">' . do_shortcode($content) . '</abbr>';
	return ($output);
}
function SupremeTheme__fblike($atts, $content = null) {
   	extract(shortcode_atts(array(
		'url' => '',
		'style' => '',
		'showfaces' => '',
		'width' => '',
		'verb' => '',
		'colorscheme' => '',
		'font' => 'arial'), $atts));
		
	global $post;

	$output = '';
	
	if ( ! $post ) {
		
		$post = new stdClass();
		$post->ID = 0;
		
	} // End IF Statement
	
	$allowed_styles = array( 'standard', 'button_count', 'box_count' );
	
	if ( ! in_array( $style, $allowed_styles ) ) { $style = 'standard'; } // End IF Statement		
	
	if ( !$url )
		$url = get_permalink($post->ID);
	
	$height = '60';	
	if ( $showfaces == 'true')
		$height = '100';
	
	if ( ! $width || ! is_numeric( $width ) ) { $width = 450; } // End IF Statement

	$output = "<iframe src='http://www.facebook.com/plugins/like.php?href=".$url."&amp;layout=".$style."&amp;show_faces=".$show_faces."&amp;action=".$like."&amp;colorscheme=".$colorscheme."' scrolling='no' frameborder='0' allowTransparency='true'></iframe>";

	return $output;

}
function SupremeTheme__digg($atts, $content = null) {
   	extract(shortcode_atts(array(	
   		'link' => '',
		'title' => '',
		'style' => ''
	), $atts));

	$output = '';
	global $post;

	$supremeshortcodes_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodes');
	
	// Add custom title
	if ( $title ){
		$final_title = '&amp;title='.urlencode( $title );
	}
		
	// Add custom URL
	if ( $link !== '' ) {
		$final_link = ' href="http://digg.com/submit?phase=2&url='.urlencode( $link ).$final_title.'"';
	}else{
		$link = get_permalink( $post->ID );
		$final_link = ' href="http://digg.com/submit?phase=2&url='.urlencode( $link ).$final_title.'"';
	}
		
	$output .= '<div class="theme-digg"><a class="DiggThisButton Digg'.$style.'"'.$final_link.' target="_blank"><img alt="Digg" src="'.$supremeshortcodes_path.'/images/digg-button-'.$style.'.gif" /></a></div>';

	return $output;

}
function SupremeTheme__twitter($atts, $content = null) {
   	extract(shortcode_atts(array(
   		'url' => '',
		'style' => 'vertical',
		'source' => '',
		'text' => '',
		'related' => '',
		'lang' => ''), $atts));
	$output = '';

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
	
	$output = '<div class="theme-twitter"><a href="http://twitter.com/share" class="twitter-share-button"'.$output.' data-count="'.$style.'">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>';	
	return $output;

}


function SupremeTheme__fbshare($atts, $content = null) {
	extract(shortcode_atts(array( 
		'url' => ''
		), $atts));

	$output = '';
				
	global $post;
	
	if ($url == '') { 
		$url = get_permalink(); 
	}
	
	$output = '<a class="fb_share" name="fb_share" type="box_count" href="#" onclick="window.open(\'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(location.href), \'facebook-share-dialog\', \'width=626,height=436\'); return false;">FB Share</a>';

	return $output;
}


function SupremeTheme__linkedin_share ( $atts, $content = null ) {

	$defaults = array( 'url' => '', 'style' => 'none');

	extract( shortcode_atts( $defaults, $atts ) );

	global $float;
	
	$allowed_floats = array( 'left' => 'fl', 'right' => 'fr', 'none' => '' );
	$allowed_styles = array( 'top' => ' data-counter="top"', 'right' => ' data-counter="right"', 'none' => '' );
	
	if ( ! in_array( $float, array_keys( $allowed_floats ) ) ) { $float = 'none'; }
	if ( ! in_array( $style, array_keys( $allowed_styles ) ) ) { $style = 'none'; }
	
	if ( $url ) { $url = ' data-url="' . esc_url( $url ) . '"'; }
	
	$output = '';
	
	if ( $float == 'none' ) {} else { $output .= '<div class="shortcode-linkedin_share ' . $allowed_floats[$float] . '">' . "\n"; }
	
	$output .= '<div class="theme-lishare"><script type="IN/Share" ' . $url . $allowed_styles[$style] . '></script></div>' . "\n";
	
	if ( $float == 'none' ) {} else { $output .= '</div>' . "\n"; }
	
	// Enqueue the LinkedIn button JavaScript from their API.
	add_action( 'wp_footer', 'SupremeTheme__linkedin_js' );
	
	return $output . "\n";

}
function SupremeTheme__linkedin_js () {
	echo '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>' . "\n";
}


function SupremeTheme__gplus( $atts, $content = null ){
	extract(shortcode_atts(array(
		'style' => 'bubble',
		'size' => 'tall'
	), $atts));

	$output = '';

	// Style
	if ( $style == "inline" ){
		$annotation = 'data-annotation="inline"';
		$width = 'data-width="300"';
	}elseif ( $style == "bubble" ){
		$annotation = '';
		$width = '';
	}elseif ( $style == "none" ){
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
}


function SupremeTheme__pinterest_pin( $atts, $content = null ){
	extract(shortcode_atts(array(
		'style' => 'beside'
	), $atts));

	$output = '';

	global $post;

	if ( $style == "above" ){
		$config = 'above';
	}elseif ( $style == "beside" ){
		$config = 'beside';
	}elseif ( $style == "none" ){
		$config = 'none';
	}else{}

	$output = '<a href="//pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&media='.urlencode(the_post_thumbnail($post->ID)).'" data-pin-do="buttonPin" data-pin-config="'.$config.'"><img alt="Pin" src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';

	return $output;

}


function SupremeTheme__tumblr( $atts, $content = null ){
	extract(shortcode_atts(array(
		'style' => 'standard'
	), $atts));

	$output = '';

	global $post;

	if ( $style == "plus" ){
		$img = 'share_1';
		$width = '81';
	}elseif ( $style == "standard" ){
		$img = 'share_2';
		$width = '61';
	}elseif ( $style == "icon_text" ){
		$img = 'share_3';
		$width = '129';
	}elseif ( $style == "icon" ){
		$img = 'share_4';
		$width = '20';
	}else{}

	$output = '<a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:'.$width.'px; height:20px; background:url(\'http://platform.tumblr.com/v1/'.$img.'.png\') top left no-repeat transparent;">Share on Tumblr</a>';

	return $output;

}


function SupremeTheme__pricing_table( $atts, $content = null ) {
	global $shortcode_pricing_table;
	extract(shortcode_atts(array(
		'columns' => '3'
	), $atts));

	$columnsClass = '';

	// class for number of selected columns
	switch ($columns) {
		case '2':
			$columnsClass .= 'two-column-table';
			break;
		case '3':
			$columnsClass .= 'three-column-table';
			break;
		case '4':
			$columnsClass .= 'four-column-table';
			break;
		case '5':
			$columnsClass .= 'five-column-table';
			break;
		case '6':
			$columnsClass .= 'six-column-table';
			break;
	}

	// get each column (stored to global $shortcode_tabs)
	do_shortcode($content);
	
	$columnContent = '';
	// create the columns
	if (is_array($shortcode_pricing_table)) {
		// loop through column content
		for ($i = 0; $i < count($shortcode_pricing_table); $i++) {
			$colClass = 'price-column'; $n = $i + 1;
			// column classes
			$colClass .= ( $n % 2 ) ?  '' : ' even-column';
			$colClass .= ( $shortcode_pricing_table[$i]['highlight'] ) ?  ' highlight-column' : '';
			$colClass .= ( $n == count($shortcode_pricing_table) ) ?  ' last-column' : '';
			$colClass .= ( $n == 1 ) ?  ' first-column' : '';
			// column details
			$columnContent .= '<div class="'.$colClass.'">'; 
			$columnContent .= '<h3 class="column-title">'.$shortcode_pricing_table[$i]['title'].'</h3>'; 
			$columnContent .= str_replace(array("\r\n", "\n", "\r"), array("", "", ""), $shortcode_pricing_table[$i]['content']); 
							//str_replace('<p></p>', '', $shortcode_pricing_table[$i]['content']); //$shortcode_pricing_table[$i]['content'];
			$columnContent .= '</div>'; 
		}
		// put all the parts together
		$finished_table = '<div class="price-table '.$columnsClass.'">'.$columnContent.'</div><div class="clear"></div>';
	}
	$shortcode_pricing_table = '';
	
	return $finished_table;
	
}
function SupremeTheme__pricing_column( $atts, $content = null ) {
	global $shortcode_pricing_table;
	extract(shortcode_atts(array(
		'title' => '',
		'highlight' => 'false'
	), $atts));

	$highlight = strtolower($highlight);
	
	// get elements
	$column['title'] = $title;
	$column['highlight'] = ( $highlight == 'true' || $highlight == 'yes' || $highlight == '1' ) ? true : false;
	$column['content'] = do_shortcode($content);
	
	$shortcode_pricing_table[] = $column;

	//return $shortcode_pricing_table;
	
}
// Price Info
//...............................................
function SupremeTheme__price_info( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'cost' => ''
	), $atts));

	$price_info = '<div class="price-info">';
	if ($cost) $price_info .= '<div class="cost">'. $cost .'</div>';
	if ($content) $price_info .= '<div class="details">'. do_shortcode($content) .'</div>';
	$price_info .= '</div>';
	

	return $price_info;
	
}
function SupremeTheme__youtube($atts, $content = null) {  
	extract(shortcode_atts(array(
		"url" => '',
		"width" => '420',
		"height" => '315'
	), $atts));


	parse_str( parse_url( $url, PHP_URL_QUERY ), $shortcode_atts );
	$url = $shortcode_atts['v'];    

	return '<div class="ss-video-container"><iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$url.'" frameborder="0" allowfullscreen></iframe></div>';
}


function SupremeTheme__row( $atts, $content = null ) {
	return '<div class="row">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span1( $atts, $content = null ) {
	return '<div class="col-sm-1">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span2( $atts, $content = null ) {
	return '<div class="col-sm-2">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span3( $atts, $content = null ) {
	return '<div class="col-sm-3">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span4( $atts, $content = null ) {
	return '<div class="col-sm-4">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span5( $atts, $content = null ) {
	return '<div class="col-sm-5">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span6( $atts, $content = null ) {
	return '<div class="col-sm-6">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span7( $atts, $content = null ) {
	return '<div class="col-sm-7">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span8( $atts, $content = null ) {
	return '<div class="col-sm-8">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span9( $atts, $content = null ) {
	return '<div class="col-sm-9">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span10( $atts, $content = null ) {
	return '<div class="col-sm-10">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span11( $atts, $content = null ) {
	return '<div class="col-sm-11">' . do_shortcode($content) . '</div>';
}

function SupremeTheme__span12( $atts, $content = null ) {
	return '<div class="col-sm-12">' . do_shortcode($content) . '</div>';
}



function SupremeTheme__googlemap($atts, $content = null, $code) {
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
$output .= '	<div id="map-canvas_'.$id.'" style="width: '.$width.'px; height: '.$height.'px;" class="ss-google-maps"></div>'."\r\n".'';


	return $output;
}


function SupremeTheme__google_trends( $atts, $content = null ){
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


function SupremeTheme__page_siblings( $atts, $content = null ) {
	global $post;

	$output = '';

	$children = get_pages(array('child_of' => $post->post_parent,'sort_order' => 'ASC'));
	if ($children) {
		$output = '<div class="alone"><ul class="list-group">';
			foreach($children as $child): $class = ($child->ID == $post->ID) ? ' current_page_item' : '';
				$output .= '<li class="list-group-item '.$class.'"><a href="'.$child->guid.'"><i class="fa fa-angle-right st-size-1"></i> '.$child->post_title.'</a></li>';
			endforeach;
			$output .= '</ul><div class="clear"></div></div>';
	}

	return $output;
	
}


function SupremeTheme__page_children( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'of' => '',
		'exclude' => ''
	), $atts));

	global $post;

	$output = '';

	$children = get_pages(array('parent' => $of, 'hierarchical' => 0, 'sort_column' => 'menu_order', 'sort_order' => 'ASC', 'post_status' => 'publish', 'exclude' => $exclude));

	if ($children) {
		$output = '<div class="alone"><ul class="list-group">';
		foreach($children as $child): $class = ($child->ID == $post->ID) ? ' current_page_item' : '';
			$output .= '<li class="list-group-item '.$class.'"><a href="'.$child->guid.'"><i class="fa fa-angle-right st-size-1"></i> '.$child->post_title.'</a></li>';
		endforeach;
		$output .= '</ul><div class="clear"></div></div>';
	}

	return $output;
	
}



/* CONTACT FORM LIGHT */

function SupremeTheme__contact_form_light( $atts, $content = null ){
    extract( shortcode_atts( array(
        'email' => '',
    ), $atts ) );

    global $shortname;

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

    return $output;

}

/*
 * Contact Form ajax light
 */

add_action('wp_ajax_nopriv_st_contact_form_light', 'SupremeTheme__contact_form_l');
add_action('wp_ajax_st_contact_form_light', 'SupremeTheme__contact_form_l');

function SupremeTheme__contact_form_l(){

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


/**
 * Contact Form Helper Light
 *
 */
if ( !function_exists( 'SupremeTheme__contact_helper_light' ) ) {
	function SupremeTheme__contact_helper_light() {
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


add_action( 'st_contact_light', 'SupremeTheme__contact_helper_light' );
do_action( 'st_contact_light');



/* CONTACT FORM DARK */

function SupremeTheme__contact_form_dark( $atts, $content = null ){
    extract( shortcode_atts( array(
        'email' => '',
    ), $atts ) );

    global $shortname;

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

    return $output;

}

/*
 * Contact Form ajax dark
 */

add_action('wp_ajax_nopriv_st_contact_form_dark', 'SupremeTheme__contact_form_d');
add_action('wp_ajax_st_contact_form_dark', 'SupremeTheme__contact_form_d');

function SupremeTheme__contact_form_d(){

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


/**
 * Contact Form Helper Dark
 *
 */
if ( !function_exists( 'SupremeTheme__contact_helper_dark' ) ) {
	function SupremeTheme__contact_helper_dark() {
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


add_action( 'st_contact_dark', 'SupremeTheme__contact_helper_dark' );
do_action( 'st_contact_dark');



function SupremeTheme__fancyboxImages( $atts, $content = null) {
	extract(shortcode_atts(array(
		'href' => '',
		'group' => '',
		'title' => '',
		'thumb' => '',
		'thumb_width' => ''
	), $atts));

	$output = '';

	$group = ($group != '') ? $group : 'fancybox_' . mt_rand();
	$content = (trim($content) != '') ? $content : $title;

	if ($thumb !== '') {
		if ($thumb_width !== '') {
			$t_width = $thumb_width;
		}else{
			$t_width = '150';
		}
		$thumbnail = '<img alt="" width="'.$t_width.'" src="'.$thumb.'">';
	}else{
		$thumbnail = $content;
	}
 
	$output .= '<a title="'.$title.'" href="'.$href.'" class="fancybox" data-fancybox-group="'.$group.'">'.$thumbnail.'</a>';		

	return $output;
}

function SupremeTheme__fancyboxInline( $atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'href' => '',
		'content_title' => '',
		'content' => ''
	), $atts));

	$output = '';

	$rand = rand(100,1000);

	$output .= '<a class="fancybox" href="#inline-'.$rand.'">'.$title.'</a>';
	$output .= '<div id="inline-'.$rand.'" class="fancybox-inline-content" style="display:none;">';
	$output .= '<h2>'.$content_title.'</h2>';
	$output .= '<p>'.$content.'</p>';
	$output .= '</div>';

	return $output;
}


function SupremeTheme__fancyboxIframe( $atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'href' => ''
	), $atts));

	$output = '';
 
	$output .= '<a class="fancybox fancybox.iframe" href="'.$href.'">'.$title.'</a>';		

	return $output;
}

function SupremeTheme__fancyboxPage( $atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'href' => ''
	), $atts));

	$output = '';
 
	$output .= '<a class="fancybox fancybox.iframe" href="'.$href.'">'.$title.'</a>';		

	return $output;
}

function SupremeTheme__fancyboxSwf( $atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'href' => ''
	), $atts));

	$output = '';
 
	$output .= '<a class="fancybox" href="'.$href.'">'.$title.'</a>';		

	return $output;
}


function SupremeTheme__chart_pie( $atts, $content = null) {
   extract(shortcode_atts(array(
       'data' => '',
       'title' => ''
   ), $atts));

   $output = '';

   	$data = $data;
	$final_data = str_replace(array("(", ")"), array("[","]"), $atts["data"]);
	$id = rand(100,1000);


$output .= '	<script type="text/javascript">';
$output .= '      google.load("visualization", "1", {packages:["corechart"]});';
$output .= '      google.setOnLoadCallback(drawChart);';
$output .= '      function drawChart() {';
$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
$output .= '        var options = {';
$output .= '          title: "'.$title.'",';
$output .= '          is3D: true,';
$output .= '        };';
$output .= '        var chart = new google.visualization.PieChart(document.getElementById("piechart_'.$id.'"));';
$output .= '        chart.draw(data, options);';
$output .= '      }';
$output .= '    </script>';
$output .= '    <div id="piechart_'.$id.'" class="google-chart ss-google-chart-pie"></div>';

	return $output;
}


function SupremeTheme__chart_bar( $atts, $content = null) {
   extract(shortcode_atts(array(
       'data' => '',
       'title' => '',
       'vaxis' => '',
       'haxis' => ''
   ), $atts));

   $output = '';

   	$data = $data;
	$final_data = str_replace(array("(", ")"), array("[","]"), $atts["data"]);
	$id = rand(100,1000);


$output .= '	<script type="text/javascript">';
$output .= '      google.load("visualization", "1", {packages:["corechart"]});';
$output .= '      google.setOnLoadCallback(drawChart);';
$output .= '      function drawChart() {';
$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
$output .= '        var options = {';
$output .= '          title: "'.$title.'",';
$output .= '          vAxis: {title: "'.$vaxis.'",  titleTextStyle: {color: "red"}},';
$output .= '          hAxis: {title: "'.$haxis.'",  titleTextStyle: {color: "blue"}}';
$output .= '        };';
$output .= '        var chart = new google.visualization.BarChart(document.getElementById("chart_'.$id.'"));';
$output .= '        chart.draw(data, options);';
$output .= '      }';
$output .= '    </script>';
$output .= '    <div id="chart_'.$id.'" class="google-chart ss-google-chart-bar"></div>';


	return $output;
}



function SupremeTheme__chart_area( $atts, $content = null) {
   extract(shortcode_atts(array(
       'data' => '',
       'title' => '',
       'vaxis' => '',
       'haxis' => ''
   ), $atts));

   $output = '';

   	$data = $data;
	$final_data = str_replace(array("(", ")"), array("[","]"), $atts["data"]);
	$id = rand(100,1000);


$output .= '	<script type="text/javascript">';
$output .= '      google.load("visualization", "1", {packages:["corechart"]});';
$output .= '      google.setOnLoadCallback(drawChart);';
$output .= '      function drawChart() {';
$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
$output .= '        var options = {';
$output .= '          title: "'.$title.'",';
$output .= '          vAxis: {title: "'.$vaxis.'",  titleTextStyle: {color: "red"}},';
$output .= '          hAxis: {title: "'.$haxis.'",  titleTextStyle: {color: "blue"}}';
$output .= '        };';
$output .= '        var chart = new google.visualization.AreaChart(document.getElementById("areachart_'.$id.'"));';
$output .= '        chart.draw(data, options);';
$output .= '      }';
$output .= '    </script>';
$output .= '    <div id="areachart_'.$id.'" class="google-chart ss-google-chart-area"></div>';


	return $output;
}


function SupremeTheme__chart_geo( $atts, $content = null) {
   extract(shortcode_atts(array(
       'data' => '',
       'title' => '',
       'primary' => 'green',
       'secondary' => '#EBE5D8'
   ), $atts));

   $output = '';

   	$data = $data;
	$final_data = str_replace(array("(", ")"), array("[","]"), $atts["data"]);
	$id = rand(100,1000);


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
$output .= '    <div id="geochart_'.$id.'" class="google-chart ss-google-chart-geo"></div>';


	return $output;
}



function SupremeTheme__chart_combo( $atts, $content = null) {
   extract(shortcode_atts(array(
       'data' => '',
       'title' => '',
       'vaxis' => '',
       'haxis' => '',
       'series' => ''
   ), $atts));

   $output = '';

   	$data = $data;
	$final_data = str_replace(array("(", ")"), array("[","]"), $atts["data"]);
	$id = rand(100,1000);


$output .= '	<script type="text/javascript">';
$output .= '      	google.load("visualization", "1", {packages:["corechart"]});';
$output .= '	    function drawVisualization() {';
$output .= '	      	var data = google.visualization.arrayToDataTable(['.$final_data.']);';
$output .= '	        var options = {';
$output .= '	        	title: "'.$title.'",';
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
$output .= '    <div id="combo_'.$id.'" class="google-chart ss-google-chart-combo"></div>';


	return $output;
}


function SupremeTheme__chart_org( $atts, $content = null) {
   extract(shortcode_atts(array(
       'data' => '',
       'title' => ''
   ), $atts));

   $output = '';

   	$data = $data;
	$final_data = str_replace(array("(", ")"), array("[","]"), $atts["data"]);
	$id = rand(100,1000);


$output .= '	<script type="text/javascript">';
$output .= '      	google.load("visualization", "1", {packages:["orgchart"]});';
$output .= '      	google.setOnLoadCallback(drawChart);';
$output .= '	    function drawChart() {';
$output .= '	        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
$output .= '	        var chart = new google.visualization.OrgChart(document.getElementById("org_'.$id.'"));';
$output .= '	        chart.draw(data, {allowHtml:true});';
$output .= '	    }';
$output .= '    </script>';
$output .= '    <div id="org_'.$id.'" class="google-chart ss-google-chart-org"></div>';


	return $output;
}


function SupremeTheme__chart_bubble( $atts, $content = null) {
   extract(shortcode_atts(array(
       'data' => '',
       'title' => '',
       'primary' => 'green',
       'secondary' => '#EBE5D8'
   ), $atts));

   $output = '';

   	$data = $data;
	$final_data = str_replace(array("(", ")"), array("[","]"), $atts["data"]);
	$id = rand(100,1000);


$output .= '	<script type="text/javascript">';
$output .= '      google.load("visualization", "1", {packages:["corechart"]});';
$output .= '      google.setOnLoadCallback(drawRegionsMap);';
$output .= '      function drawRegionsMap() {';
$output .= '        var data = google.visualization.arrayToDataTable(['.$final_data.']);';
$output .= '        var options = {';
$output .= '        	title: "'.$title.'",';
$output .= '        	colorAxis: {colors: [\''.$primary.'\', \''.$secondary.'\']}';
$output .= '        };';
$output .= '        var chart = new google.visualization.BubbleChart(document.getElementById("bubble_'.$id.'"));';
$output .= '        chart.draw(data, options);';
$output .= '      }';
$output .= '    </script>';
$output .= '    <div id="bubble_'.$id.'" class="google-chart ss-google-chart-bubble"></div>';


	return $output;
}


function SupremeTheme__gdocs($atts, $content = null){
	extract(shortcode_atts(array(
       'url' => '',
       'width' => '',
       'height' => ''
   ), $atts));

	$output = '';

	$output = '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" src="'.$url.'?embedded=true"></iframe>';
	return $output;

}


function SupremeTheme__video($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'src' => '',
		'webm' => '',
		'ogg' => '',
		'mp4' => '',
		'width' => '',
		'height' => '',
		'poster' => '',
		'type' => 'html5'
	), $atts));

	$output = '';

	$rnd = mt_rand();

	if($type == 'html5') {
		// html5 //
		$output .=  '<h3>'.$title.'</h3>';
		$output .=  '<video width="'.$width.'" height="'.$height.'" controls="controls" id="video_'.$rnd.'" name="media" poster="'.$poster.'">';
		$output .=	'<source src="'.$mp4.'"  type=\'video/mp4\'></source>';
		$output .=	'<source src="'.$webm.'" type=\'video/webm\'></source>';
		$output .=	'<source src="'.$ogg.'"  type=\'video/ogg\'></source>';
		$output .=  '</video>';
		$output .=	'<script type="text/javascript">jQuery(document).ready(function($) {$("#video_'.$rnd.'").mediaelementplayer();});</script>';
	} elseif ($type == 'flash') {
		// flash //
		$output = '<div class="ss-video-container"><object width="'.$width.'" height="'.$height.'"><param name="movie" value="'.$src.'"><embed src="'.$src.'" width="'.$width.'" height="'.$height.'"></embed></object></div>';

	} else {
		// youtube, vimeo, dailymotion //
		switch($type) {
			case 'youtube':
				$source = 'http://www.youtube.com/embed/'. $src . '?autohide=2&amp;controls=1&amp;disablekb=0&amp;fs=1&amp;hd=0&amp;loop=0&amp;rel=0&amp;showinfo=0&amp;showsearch=0&amp;wmode=transparent';
				break;
			case 'vimeo':
				$source = 'http://player.vimeo.com/video/' . $src;
				break;
			case 'dailymotion':
				$source = 'http://www.dailymotion.com/embed/video/'. $src;
				break;
		}
		$output = '<div class="ss-video-container"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" src="'.$source.'"></iframe></div>';
	}
	return $output;
}

function SupremeTheme__audio($atts, $content=null) {
	extract(shortcode_atts(array(
		'title' => '',
		'src' => ''
	), $atts));

	$output = '';

	$rnd = mt_rand();

	$output .= '<h3>'.$title.'</h3>';
	$output .= '<div class="audio-wrap"><audio style="width: 100%;" class="full_width" src="'.$src.'" preload="auto" controls="controls" id="audio_'.$rnd.'"></audio></div>';
	$output .= '<script type="text/javascript">jQuery(document).ready(function($) {$("#audio_'.$rnd.'").mediaelementplayer();});</script>';
	return $output;
}


function SupremeTheme__soundcloud( $atts, $content=null ){
	extract(shortcode_atts(array(
		'src' => '',
		'color' => ''
	), $atts));

	$str= ltrim ($color,'#');

	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$src.'&amp;color='.$str.'&amp;auto_play=false&amp;show_artwork=true"></iframe>';
}


function SupremeTheme__mixcloud( $atts, $content=null ){
	extract(shortcode_atts(array(
		'src' => '',
		'width' => '',
		'height' => ''
	), $atts));

	return '<iframe width="'.$width.'" height="'.$height.'" src="//www.mixcloud.com/widget/iframe/?feed='.$src.'" frameborder="0"></iframe>';
}


function SupremeTheme__button_more($atts, $content = null) {
	extract(shortcode_atts(array(
		'text' => 'Read More',
		'href' => ''
	), $atts));

	$output = '';

	$output = '<a href="'.$href.'" class="ss-btn more">'.$text.'</a><div class="clear"></div>';

	return $output;
}

function SupremeTheme__horizontal_line($atts, $content = null) {
	
	return '<hr class="hr">'.$content;
}

function SupremeTheme__break_line($atts, $content = null) {
	
	return '<br>'.$content;
}

function SupremeTheme__div_clear($atts, $content = null) {
	
	return '<div class="clear"></div>'.$content;
}

function SupremeTheme__separator($atts, $content = null) {

	return '<div class="ss-separator"></div>'.$content;
}

function SupremeTheme__divider_dotted($atts, $content = null) {
	
	return '<div class="divider_dotted"></div>'.$content;
}

function SupremeTheme__divider_dashed($atts, $content = null) {
	
	return '<div class="divider_dashed"></div>'.$content;
}

function SupremeTheme__divider_top($atts, $content = null) {
	
	return '<div class="divider_top"><a href="#" class="to-top">'.__('top').' <i class="fa fa-angle-up st-size-1"></i></a></div>'.$content;
}

function SupremeTheme__divider_shadow($atts, $content = null) {
	
	return '<div class="divider_shadow"><img alt="Shadow" src="'.trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodes/').'images/divider_shadow.png"></div>'.$content;
}

function SupremeTheme__divider_text($atts, $content = null) {
	extract(shortcode_atts(array(
		'text' => '',
		'position' => ''
	), $atts));

	if ($position == 'center') {
		$help = 'center-help';
	}else{
		$help = '';
	}
	
	return '<div class="divider_lines"><div class="divider_text '.$position.'"><div class="'.$help.'">'.$text.'</div></div></div>';
}


function SupremeTheme__posts_carousel($atts, $content = null){
	extract(shortcode_atts(array(
		'posts' => '',
		'number' => '',
		'exclude' => '',
		'display_title' => '',
		'cat' => ''
	), $atts));

	$output = '';

	global $shortname;
	global $post;

	if($number == ''){
		$numb = 5;
	}else{
		$numb = $number;
	}

	if ($display_title == 'yes') {
		$titleClass = 'with-title';
	}else{
		$titleClass = '';
	}


	$args = array(
		'post_type' => $posts,
		'post_status' => 'publish',
		'posts_per_page' => $numb,
		'cat' => $cat
	);


	// The Query
	$query = new WP_Query( $args );

	// The Loop 
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
		// no posts found
		$output .= '<h3>'.__('No posts found', $shortname).'</h3>';
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	return $output;
}


function SupremeTheme__icon( $params ) {
    extract( shortcode_atts( array(
                'name'      => '',
                'size'      => '',
                'color'     => '',
                'type'      => '',
                'background'  => '',
                'align'  	=> '',
                'border_color'  => ''
            ), $params ) );

    $padding = '';
    $dimensions = '';

    if ($align && $align !== 'ss-none') {
		$final_align = $align;
	}else{
		$final_align = 'ss-no-align';
	}

    if ($type !== 'normal') {
    	$icon_type = $type;
    }else{
    	$icon_type = '';
    }

    $final_size = str_replace("icon-", "st-size-", $size);

    if ($background == '' || $type == 'normal') {
    	$bg_color = 'transparent';
    }else{
    	$bg_color = $background;
    }

    if ($border_color == '' || $type == 'normal') {
    	$border = 'transparent';
    }else{
    	$border = $border_color;
    }

    if (empty($background) && empty($border_color) || $type == 'normal') {
    	$padding = ' padding: 0px; ';
    	$dimensions = 'width: auto; height: auto; margin-right: 5px;';
    }

    return '<span class="'.$final_align.'"><span class="'.$icon_type.' iconwrapp size-'.$final_size.'" style="'.$dimensions.$padding.'border: 1px solid '.$border.'; background: '.$bg_color.';"><i class="fa fa-'.$name.' '.$final_size.'" style="color:'.$color.'"></i></span></span>';
}




function SupremeTheme__icon_melon( $params ) {
    extract( shortcode_atts( array(
                'name'      => '',
                'size'      => '',
                'color'     => '',
                'type'      => '',
                'background'  => '',
                'align'  	=> '',
                'border_color'  => ''
            ), $params ) );

    $output = '';
    $padding = '';
    $dimensions = '';

    if ($align && $align !== 'ss-none') {
		$final_align = $align;
	}else{
		$final_align = 'ss-no-align';
	}

    if ($type !== 'normal') {
    	$icon_type = $type;
    }else{
    	$icon_type = '';
    }

    $final_size = str_replace("icon-", "st-size-", $size);

    if ($background == '') {
    	$bg_color = 'transparent';
    }else{
    	$bg_color = $background;
    }

    if ($border_color == '') {
    	$border = 'transparent';
    }else{
    	$border = $border_color;
    }

    if (empty($background) && empty($border_color) || $type == 'normal') {
    	$padding = ' padding: 0px; ';
    	$dimensions = 'width: auto; height: auto;';
    }


    $output .= '<span class="'.$final_align.'"><span class="'.$icon_type.' iconwrapp size-'.$final_size.'" style="'.$dimensions.$padding.'border: 1px solid '.$border.'; background: '.$bg_color.';">';
    $output .= '<div class="iconmelon icon '.$final_size.'"><svg viewBox="0 0 32 32" style="fill:'.$color.'"><use xlink:href="#'.$name.'"></use></svg></div>';
    $output .= '</span></span>';

    return $output; 
}


function SupremeTheme__progress_bar($atts, $content = null){
	extract(shortcode_atts(array(
		'width' => '',
		'style' => '',
		'striped' => '',
		'active' => ''
	), $atts));

	$output = '';

	if ($striped == 'striped') {
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


function SupremeTheme__social_icon($atts, $content = null){
	extract(shortcode_atts(array(
		'name' => '',
		'href' => '',
		'align' => '',
		'target' => ''
	), $atts));

	if ($align && $align !== 'ss-none') {
		$final_align = $align;
	}else{
		$final_align = 'ss-no-align';
	}

	return '<span class="'.$final_align.'"><a class="'.$name.' st-social-icons" href="'.$href.'" target="'.$target.'"></a></span>';
}


function SupremeTheme__container($atts, $content = null) {

    return '<div class="container"><div>' . do_shortcode($content) . '</div></div>';

}


function SupremeTheme__section_color( $atts, $content = null ) {
    extract( shortcode_atts( array(
            'color'     => '',
            'padding'  => ''
        ), $atts ) );

    if ($padding !== '') {
    	$divStyle = ' style="padding: '.$padding.'"';
    }else{
    	$divStyle = '';
    }

    return '<section class="content-section" style="background-color:'.$color.'"><div'.$divStyle.'>' . do_shortcode($content) . '</div></section>';
}


function SupremeTheme__section_image( $atts, $content = null ) {
    extract( shortcode_atts( array(
            'image_id'   => '',
            'bg_position'   => '',
            'repeat'     => '',
            'bg_color' => '',
            'type'		 => '',
            'padding'		 => '',
            'bg_size' => ''
        ), $atts ) );

    $output = '';

    if ($padding !== '') {
    	$divStyle = ' style="padding: '.$padding.'"';
    }else{
    	$divStyle = '';
    }

    // if bg color
    if ($bg_color !== '') {
    	$background_color = ' background-color:'.$bg_color.';';
    }else{
    	$background_color = ' background-color: transparent;';
    }
    // if bg_size
    if ($bg_size !== '') {
    	$background_size = ' background-size:'.$bg_size.'; -webkit-background-size: '.$bg_size.'; -moz-background-size: '.$bg_size.'; -o-background-size: '.$bg_size.'; background-size: '.$bg_size.'; ';
    }else{
    	$background_size = ' background-size: initial; ';
    }

    $photo_info = wp_get_attachment_image_src( $image_id, 'full' );
    $photo_url = $photo_info[0];

    $id = rand(100,1000);

    // if parallax
    if ($type == 'parallax') {
    	$section_attributes = ' style="background-image: url('.$photo_url.'); background-position: '.$bg_position.'; background-attachment: fixed;  background-repeat: '.$repeat.'; '.$background_size.$background_color.'"';
    	$parallax_class = 'full-width-section parallax_section';
    }else{
    	$section_attributes = ' style="background-image: url('.$photo_url.'); background-position: '.$bg_position.'; background-attachment: '.$type.' !important; background-repeat: '.$repeat.'; '.$background_color.'"';
    	$parallax_class = '';
    }


    $output .= '<section id="'.$id.'" class="content-section '.$parallax_class.'" '.$section_attributes.'><div'.$divStyle.'>' . do_shortcode($content) . '</div></section>';

    return $output;
}


function SupremeTheme__swiper( $atts, $content = null){
	extract(shortcode_atts(array(
		'posts' => '',
		'number' => '',
		'display_title' => '',
		'category' => ''
	), $atts));

	$output = '';

	global $shortname;
	global $post;

	if($number == ''){
		$numb = -1;
	}else{
		$numb = $number;
	}

	if ($display_title == 'yes') {
		$titleClass = 'with-title';
	}else{
		$titleClass = 'without-title';
	}


	$args = array(
		'post_type' => $posts,
		'post_status' => 'publish',
		'posts_per_page' => $numb,
		'cat' => $category
	);



	// The Query
	$querySwipe = new WP_Query( $args );

	// The Loop 
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
			$output .= '<div class="swiper-slide">'. get_the_post_thumbnail( $post->ID, 'swiper' ) . $show_title . $show_text. $hover_div.$title_div.'</div>';
		}

			
		$output .= '<div class="pagination"></div></div></div></div>';
		$output .= '<div class="clear"></div>';
	} else {
		// no posts found
		$output .= '<h3>'.__('No posts found', $shortname).'</h3>';
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	return $output;
}


function SupremeTheme__testimonials($atts, $content = null){
	extract(shortcode_atts(array(
		'posts' => 'testimonial',
		'number' => '',
		'color' => ''
	), $atts));

	$output = '';

	global $shortname;
	global $post;

	if ($color == '') {
		$final_color = '#444444';
	}else{
		$final_color = $color;
	}

	if ($number == '') {
		$final_number = '-1';
	}else{
		$final_number = $number;
	}


	$args = array(
		'post_type' => $posts,
		'post_status' => 'publish',
		'posts_per_page' => $final_number,
		'orderby' => 'menu_order title'
	);



	// The Query
	$query = new WP_Query( $args );

	// The Loop 
	if ( $query->have_posts() ) {

		$id = rand(100,1000);

		$output .= '<style type="text/css">#flex-'.$id.' .flex-control-paging li a{ background: '.$final_color.'; }</style>';

		$output .= '<div class="flexslider-wrap testimonial-wrap" id="flex-'.$id.'">';
		$output .= '<div class="flexslider-testimonials">';
		$output .= '<ul class="slides">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$testAuthorName = get_post_meta($post->ID, 'page__test_author_name', true);
		    $testCompanyName = get_post_meta($post->ID, 'page__test_company_name', true);
		    $testAuthorQuote = get_post_meta($post->ID, 'page__test_author_quote', true);
		    $clientImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

			
			$output .= '<li>';
			if ($clientImg) {
				$output .= '<img alt="'.$testAuthorName.'" src="'.$clientImg[0].'" alt="'.$testAuthorName.'" class="img-responsive img-circle img-testimonial" width="150">';
			}

			if (!empty($testAuthorQuote)) {
				$output .= '<p style="color: '.$final_color.'">'.$testAuthorQuote.'</p>';
			}
			
			$output .= '<div class="author" style="color: '.$final_color.'">';
			
			if (!empty($testAuthorName)) {
				$output .= ' ~ '.$testAuthorName;
			}

			if (!empty($testCompanyName)) {
				$output .= ', '.$testCompanyName;
			}
			$output .= '</div>';
			$output .= '</li>';
		}
			
		$output .= '</ul></div></div>';

	} else {
		// no posts found
		$output .= '<h3>'.__('No Testimonials found.', $shortname).'</h3>';
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	return $output;
}


function SupremeTheme__icon_box($atts, $content = null){
	extract(shortcode_atts(array(
		'background'    => '',
		'opacity'    	=> '',
        'border_color'  => '',
        'icon'    		=> '',
        'icon_color'    => '',
        'icon_bg'  		=> '',
        'icon_shape'  	=> '',
        'icon_position' => '',
        'icon_spin'		=> ''
	), $atts));

	$output = '';
	$spin = '';

	$id = mt_rand();

	if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

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



function SupremeTheme__countdown($atts, $content = null){
	extract(shortcode_atts(array(
		'id' => '',
		'align' => ''
	), $atts));

	$output = '';

	if ($align && $align !== 'countdown-none') {
		$final_align = $align;
	}else{
		$final_align = 'ss-no-align';
	}

	global $shortname;
	global $post;

	$args = array(
		'post_type' => 'events',
		'post_status' => 'publish',
		'p' => $id
	);


	// The Query
	$query = new WP_Query( $args );

	// The Loop 
	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {

			$query->the_post();

			$event_date = explode('-', get_post_meta($post->ID, 'page__event_day', true));
            $event_time = explode(':', get_post_meta($post->ID, 'page__event_time', true));

            $output .= '<div class="'.$final_align.'">';
			$output .= '<ul class="countdown-holder countdown-'.$post->ID.'"></ul>';
			$output .= '</div>';

            if(count($event_date) > 1 && count($event_time) > 1){ ?>
                <script type="text/javascript">
                        jQuery(document).ready(function($){
                            $('.countdown-<?php echo $post->ID?>').countdown({alwaysExpire: true, expiryText: '<?php echo $event_expiry; ?>', until: new Date(<?php echo $event_date[2]?>, <?php echo $event_date[1]?>-1, <?php echo $event_date[0]?>, <?php echo $event_time[0]?>, <?php echo $event_time[1]?>, 00), layout: '<li><span>{dn}</span> <p><?php _e("days", $shortname)?></p></li> <li><span>{hnn}</span> <p><?php _e("hours", $shortname)?></p></li> <li><span>{mnn}</span> <p><?php _e("minutes", $shortname)?></p></li> <li><span>{snn}</span> <p><?php _e("seconds", $shortname)?></p></li>', compact: true, timezone:0});

                        });
                </script>
            <?php }

            $output .= '<div class="clear"></div>';
		}
			

	} 

	/* Restore original Post Data */
	wp_reset_postdata();

	return $output;
}



function SupremeTheme__animated($atts, $content = null){
	extract(shortcode_atts(array(
		'type' => '',
		'trigger' => '',
		'precent' => ''
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

function SupremeTheme__svg_drawing($atts, $content = null){
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

function SupremeTheme__img_scroll($atts, $content = null){
	extract(shortcode_atts(array(
		'height' => '',
		'speed' => '',
		'img' => '',
		'border' => '',
		'border_color' => ''
	), $atts));

	$output = '';

	if ($border !== '' && $border_color !== '') {
		$border_style = ' style="border: '.$border.' solid '.$border_color.'"';
	}else{ $border_style = ''; }

	$output .= '<div class="st-img-scroller" data-speed="'.$speed.'" data-height="'.$height.'" onclick="return true" '.$border_style.'>';
	$output .= '<div class="image-holder" style="height:'.$height.'px"><img alt="" src="'.$img.'"></div><div class="clearfix"></div></div>';

	return $output;
}


/* Scroll */
add_shortcode('st_img_scroller', 'SupremeTheme__img_scroll');

/* Code */
add_shortcode('st_code', 'SupremeTheme__code');

/* Fancy buttons */
add_shortcode('st_hover_fill_button', 'SupremeTheme__hover_fill_button');
add_shortcode('st_hover_fancy_icon_button', 'SupremeTheme__hover_fancy_icon_button');
add_shortcode('st_hover_arrows_button', 'SupremeTheme__hover_arrows_button');
add_shortcode('st_hover_icon_button', 'SupremeTheme__hover_icon_button');
add_shortcode('st_hover_bordered_button', 'SupremeTheme__hover_bordered_button');

/* Socail Icons */
add_shortcode('st_social_icon', 'SupremeTheme__social_icon');

/* Media */
add_shortcode('st_video', 'SupremeTheme__video');
add_shortcode('st_youtube', 'SupremeTheme__youtube');  
add_shortcode('st_audio', 'SupremeTheme__audio');
add_shortcode('st_soundcloud', 'SupremeTheme__soundcloud');
add_shortcode('st_mixcloud', 'SupremeTheme__mixcloud');

/* Google */
add_shortcode('st_gmap','SupremeTheme__googlemap');
add_shortcode('st_trends','SupremeTheme__google_trends');
add_shortcode('st_gdocs', 'SupremeTheme__gdocs');
add_shortcode('st_chart_pie', 'SupremeTheme__chart_pie');
add_shortcode('st_chart_bar', 'SupremeTheme__chart_bar');
add_shortcode('st_chart_area', 'SupremeTheme__chart_area');
add_shortcode('st_chart_geo', 'SupremeTheme__chart_geo');
add_shortcode('st_chart_combo', 'SupremeTheme__chart_combo');
add_shortcode('st_chart_org', 'SupremeTheme__chart_org');
add_shortcode('st_chart_bubble', 'SupremeTheme__chart_bubble');

/* Fancybox */
add_shortcode('st_fancyboxImages','SupremeTheme__fancyboxImages');
add_shortcode('st_fancyboxInline','SupremeTheme__fancyboxInline');
add_shortcode('st_fancyboxIframe','SupremeTheme__fancyboxIframe');
add_shortcode('st_fancyboxPage','SupremeTheme__fancyboxPage');
add_shortcode('st_fancyboxSwf','SupremeTheme__fancyboxSwf');

/* Contact Forms */
add_shortcode('st_contact_form_dark','SupremeTheme__contact_form_dark');
add_shortcode('st_contact_form_light','SupremeTheme__contact_form_light');

/* Related */
add_shortcode('st_related_posts', 'SupremeTheme__related_posts');
add_shortcode('st_children','SupremeTheme__page_children');
add_shortcode('st_siblings','SupremeTheme__page_siblings');

/* Responsive */
add_shortcode('st_row', 'SupremeTheme__row');
add_shortcode('st_column1', 'SupremeTheme__span1');
add_shortcode('st_column2', 'SupremeTheme__span2');
add_shortcode('st_column3', 'SupremeTheme__span3');
add_shortcode('st_column4', 'SupremeTheme__span4');
add_shortcode('st_column5', 'SupremeTheme__span5');
add_shortcode('st_column6', 'SupremeTheme__span6');
add_shortcode('st_column7', 'SupremeTheme__span7');
add_shortcode('st_column8', 'SupremeTheme__span8');
add_shortcode('st_column9', 'SupremeTheme__span9');
add_shortcode('st_column10', 'SupremeTheme__span10');
add_shortcode('st_column11', 'SupremeTheme__span11');
add_shortcode('st_column12', 'SupremeTheme__span12');

/* Tables */
add_shortcode('st_pricing_column', 'SupremeTheme__pricing_column');
add_shortcode('st_pricing_table', 'SupremeTheme__pricing_table');
add_shortcode('st_price_info', 'SupremeTheme__price_info');
add_shortcode('st_table', 'SupremeTheme__table');

/* Buttons */
add_shortcode('st_button', 'SupremeTheme__button');
add_shortcode('st_loginout', 'SupremeTheme__loginout');
add_shortcode('st_button_more', 'SupremeTheme__button_more');

/* Sharing */
add_shortcode('st_linkedin_share', 'SupremeTheme__linkedin_share');
add_shortcode('st_fbshare', 'SupremeTheme__fbshare');
add_shortcode('st_tweetmeme', 'SupremeTheme__tweetmeme');
add_shortcode('st_twitter', 'SupremeTheme__twitter');
add_shortcode('st_digg', 'SupremeTheme__digg');
add_shortcode('st_fblike', 'SupremeTheme__fblike');
add_shortcode('st_gplus', 'SupremeTheme__gplus');
add_shortcode('st_pinterest_pin', 'SupremeTheme__pinterest_pin');
add_shortcode('st_tumblr', 'SupremeTheme__tumblr');

/* Typography */
add_shortcode('st_abbr', 'SupremeTheme__abbr');
add_shortcode('st_highlight', 'SupremeTheme__highlight');
add_shortcode('st_label', 'SupremeTheme__label');
add_shortcode('st_dropcap', 'SupremeTheme__dropcap');
add_shortcode('st_quote', 'SupremeTheme__quote');
add_shortcode('st_text_color', 'SupremeTheme__text_color');

/* Tabs, Accordions */
add_shortcode('st_tabs', 'SupremeTheme__tabs' );
add_shortcode('st_tab', 'SupremeTheme__tab');
add_shortcode('st_toggle', 'SupremeTheme__toggle');
add_shortcode('st_panel', 'SupremeTheme__panel');
add_shortcode('st_accordion', 'SupremeTheme__accordion');
add_shortcode('st_acc_panel', 'SupremeTheme__acc_panel');

/* Lists */
add_shortcode('st_unordered', 'SupremeTheme__unordered');
add_shortcode('st_ordered', 'SupremeTheme__ordered');

/* Boxes */
add_shortcode('st_box', 'SupremeTheme__box');
add_shortcode('st_callout', 'SupremeTheme__callout');
add_shortcode('st_icon_box', 'SupremeTheme__icon_box');

/* Actions */
add_shortcode('st_tooltip', 'SupremeTheme__tooltip');
add_shortcode('st_popover', 'SupremeTheme__popover');
add_shortcode('st_modal', 'SupremeTheme__modal');

/* Lines and Brakes*/
add_shortcode('st_horizontal_line', 'SupremeTheme__horizontal_line');
add_shortcode('st_break_line','SupremeTheme__break_line');
add_shortcode('st_clear','SupremeTheme__div_clear');

/* Dividers */
add_shortcode('st_divider_dotted','SupremeTheme__divider_dotted');
add_shortcode('st_divider_dashed','SupremeTheme__divider_dashed');
add_shortcode('st_divider_top','SupremeTheme__divider_top');
add_shortcode('st_divider_shadow','SupremeTheme__divider_shadow');
add_shortcode('st_divider_text','SupremeTheme__divider_text');

/* Carousel */
add_shortcode('st_posts_carousel','SupremeTheme__posts_carousel');
add_shortcode('st_testimonials','SupremeTheme__testimonials');

/* Countdown */
add_shortcode('st_countdown','SupremeTheme__countdown');

/* Swiper */
add_shortcode('st_swiper','SupremeTheme__swiper');

/* SVG */
add_shortcode('st_svg_drawing','SupremeTheme__svg_drawing');

// Animated elements
add_shortcode('st_animated', 'SupremeTheme__animated');

/* Section */
add_shortcode('st_section_image','SupremeTheme__section_image');
add_shortcode('st_section_color','SupremeTheme__section_color');

/* Container */
add_shortcode('st_container','SupremeTheme__container');

// Fontawesome icons
add_shortcode('st_icon', 'SupremeTheme__icon');
add_shortcode('st_icon_melon', 'SupremeTheme__icon_melon');

// Progress bar
add_shortcode('st_progress_bar', 'SupremeTheme__progress_bar');


// Filter CODE and PRECODE shortcodes
add_filter('no_texturize_shortcodes', 'SupremeTheme__no_texturized_shortcodes_filter');
?>