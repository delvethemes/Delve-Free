<?php

$supremeshortcodes_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodesFree');
$currentFile = __FILE__;
$currentFolder = dirname($currentFile);

global $shortname;

$output = '';


// Clean empty <p> tags inside shortcodes
function SupremeShortcodesFree__cleanup_shortcode($content) {   
	 $array = array (
	    '<p>[' => '[',
	    ']</p>' => ']',
	    ']<br />' => ']'
	);

	$content = strtr( $content, $array );

	return $content;
}
add_filter('the_content', 'SupremeShortcodesFree__cleanup_shortcode', 10);


///////////////////////////////////////////
//				SHORTCODES 				 //
///////////////////////////////////////////

function SupremeShortcodesFree__no_texturized_shortcodes_filter( $shortcodes ) {
	$shortcodes[] = 'code';
	$shortcodes[] = 'precode';
	return $shortcodes;
}

function SupremeShortcodesFree__code( $atts, $content = null ) {
	return '<code>' . do_shortcode( $content ) . '</code>';
}


function SupremeShortcodesFree__dropcap($atts, $content = null) {
	 extract(shortcode_atts(array(
		'type' => 'light'
	), $atts)); 
	return '<span class="dropcap '.$type.'">' . do_shortcode( $content ) . '</span>';
}

function SupremeShortcodesFree__highlight($atts, $content = null) {
	 extract(shortcode_atts(array(
		'text_color' => '',
		'background_color' => ''
	), $atts)); 	
	return '<span class="highlight" style="background: '.$background_color.'; color: '.$text_color.';">' . do_shortcode( $content ) . '</span>';
}

function SupremeShortcodesFree__label($atts, $content = null) {
	 extract(shortcode_atts(array(
		'type' => 'default'
	), $atts)); 	
	return '<span class="label '.$type.'">' . do_shortcode( $content ) . '</span>';
}

function SupremeShortcodesFree__table( $atts ) {
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


function SupremeShortcodesFree__button($atts, $content = null) {
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

function SupremeShortcodesFree__unordered( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'listicon' => '1'
	), $atts));
	$output = '';
	$output = '<div class="unordered_list '.$listicon.'">'.$content.'</div>';
	return $output;
}

function SupremeShortcodesFree__box( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'type' => '',
		'icon' => ''
	), $atts));

	$output = '';

	if($icon != '') {
		$styles = '<img src="' . $icon .'" width="50" />';
	}else{
		$styles = '';
	}

	$output = '<div class="alert-message '.$type.'">'.$styles.'<h3>'.$title.'</h3><p>'.do_shortcode( $content ).'</p></div>';
	return $output;
}

function SupremeShortcodesFree__ordered( $atts, $content = null ) {

	return '<div class="LISTstyled">' . do_shortcode( $content ) . '</div>';
		
}


// this variable will hold your divs
$tabs_divs = '';

function SupremeShortcodesFree__tabs( $atts, $content ) {
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


function SupremeShortcodesFree__tab($atts, $content) {  
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



function SupremeShortcodesFree__panel( $atts, $content ) {
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


function SupremeShortcodesFree__toggle( $atts, $content ) {
	if( is_string($atts) )
		$atts = array();

	$output = '';
	$id = base_convert(microtime(), 10, 36);

	$output .= '<div class="panel-group st-accordion" id="accordion-'.$id.'">'.do_shortcode( $content ).'</div>';

	return $output;
}

function SupremeShortcodesFree__fblike($atts, $content = null) {
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
function SupremeShortcodesFree__digg($atts, $content = null) {
   	extract(shortcode_atts(array(	
   		'link' => '',
		'title' => '',
		'style' => ''
	), $atts));

	$output = '';
	global $post;

	$supremeshortcodes_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodesFree');
	
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
		
	$output .= '<div class="theme-digg"><a class="DiggThisButton Digg'.$style.'"'.$final_link.' target="_blank"><img src="'.$supremeshortcodes_path.'/images/digg-button-'.$style.'.gif" /></a></div>';

	return $output;

}
function SupremeShortcodesFree__twitter($atts, $content = null) {
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


function SupremeShortcodesFree__fbshare($atts, $content = null) {
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


function SupremeShortcodesFree__linkedin_share ( $atts, $content = null ) {

	$defaults = array( 'url' => '', 'style' => 'none');

	extract( shortcode_atts( $defaults, $atts ) );

	global $float;
	
	$allowed_floats = array( 'left' => 'fl', 'right' => 'fr', 'none' => '' );
	$allowed_styles = array( 'top' => ' data-counter="top"', 'right' => ' data-counter="right"', 'none' => '' );
	
	if ( ! in_array( $float, array_keys( $allowed_floats ) ) ) { $float = 'none'; }
	if ( ! in_array( $style, array_keys( $allowed_styles ) ) ) { $style = 'none'; }
	
	if ( $url ) { 
		$url = ' data-url="' . esc_url( $url ) . '"'; 
	}else{
		$url = ' data-url="' . the_permalink() . '"'; 
	}
	
	$output = '';
	
	if ( $float == 'none' ) {} else { $output .= '<div class="shortcode-linkedin_share ' . $allowed_floats[$float] . '">' . "\n"; }
	
	$output .= '<div class="theme-lishare"><script type="IN/Share" ' . $url . $allowed_styles[$style] . '></script></div>' . "\n";
	
	if ( $float == 'none' ) {} else { $output .= '</div>' . "\n"; }
	
	return $output . "\n";

}

function SupremeShortcodesFree__gplus( $atts, $content = null ){
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


function SupremeShortcodesFree__pinterest_pin( $atts, $content = null ){
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

	$output = '<a href="//pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&media='.urlencode(the_post_thumbnail($post->ID)).'" data-pin-do="buttonPin" data-pin-config="'.$config.'"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';

	return $output;

}


function SupremeShortcodesFree__tumblr( $atts, $content = null ){
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

function SupremeShortcodesFree__youtube($atts, $content = null) {  
	extract(shortcode_atts(array(
		"url" => '',
		"width" => '420',
		"height" => '315'
	), $atts));


	parse_str( parse_url( $url, PHP_URL_QUERY ), $shortcode_atts );
	$url = $shortcode_atts['v'];    

	return '<div class="ss-video-container"><iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$url.'" frameborder="0" allowfullscreen></iframe></div>';
}


function SupremeShortcodesFree__row( $atts, $content = null ) {
	return '<div class="row">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span1( $atts, $content = null ) {
	return '<div class="col-sm-1">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span2( $atts, $content = null ) {
	return '<div class="col-sm-2">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span3( $atts, $content = null ) {
	return '<div class="col-sm-3">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span4( $atts, $content = null ) {
	return '<div class="col-sm-4">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span5( $atts, $content = null ) {
	return '<div class="col-sm-5">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span6( $atts, $content = null ) {
	return '<div class="col-sm-6">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span7( $atts, $content = null ) {
	return '<div class="col-sm-7">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span8( $atts, $content = null ) {
	return '<div class="col-sm-8">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span9( $atts, $content = null ) {
	return '<div class="col-sm-9">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span10( $atts, $content = null ) {
	return '<div class="col-sm-10">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span11( $atts, $content = null ) {
	return '<div class="col-sm-11">' . do_shortcode($content) . '</div>';
}

function SupremeShortcodesFree__span12( $atts, $content = null ) {
	return '<div class="col-sm-12">' . do_shortcode($content) . '</div>';
}



function SupremeShortcodesFree__googlemap($atts, $content = null, $code) {
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


function SupremeShortcodesFree__google_trends( $atts, $content = null ){
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


function SupremeShortcodesFree__page_siblings( $atts, $content = null ) {
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


function SupremeShortcodesFree__page_children( $atts, $content = null ) {
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


function SupremeShortcodesFree__contact_form_light( $atts, $content = null ) {
	global $shortname, $post;

	$output = '';
	$nameError = '';
	$emailError = '';
	$captchaError = '';
	$commentError = '';

	$supremeshortcodes_path = trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodesFree');

	$id = rand(100,1000);

	extract(shortcode_atts(array(
		'email' => ''
	), $atts));

	// If the form is submitted
	if(isset($_POST['submittedLight'])) {

		if(session_id()=='')
		ob_start();
		session_start();
		ob_end_clean();
		
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactNameLight']) === '') {
			$nameError = 'You forgot to enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactNameLight']);
		}
		
		// Check to make sure sure that a valid email address is submitted
		if(trim($_POST['user_email_light']) === '')  {
			$emailError = 'You forgot to enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['user_email_light']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$user_email_light = trim($_POST['user_email_light']);
		}
			
		// Check to make sure comments were entered	
		if(trim($_POST['comments_light']) === '') {
			$commentError = 'You forgot to enter your message.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments_light = stripslashes(trim($_POST['comments_light']));
			} else {
				$comments_light = trim($_POST['comments_light']);
			}
		}

		// Check captcha
		if(empty($_SESSION['captcha']) || strtolower(trim($_REQUEST['captcha'])) != $_SESSION['captcha']) {
			$captchaError = 'Invalid Captcha!';
			$hasError = true;
		}

			
		// If there is no error, send the email
		if(!isset($hasError)) {
			$emailTo = $email;
			$blog_title = get_bloginfo('name');
			$subject = $blog_title.' - Contact Form Submission from '.$name;
			$body = "Name: $name \n\nEmail: $user_email_light \n\nMessage: $comments_light";
			$headers = 'From: <'.$user_email_light.'>' . "\r\n" . 'Reply-To: ' . $user_email_light;
			mail($emailTo, $subject, $body, $headers);
			$emailSent = true;
		}

	} 

	$submitText = (__('Submit', $shortname));
	$action = get_permalink($post->ID);

	$output .= '<div class="c_form">';

				if(isset($emailSent) && $emailSent == true) { 

					$output .= '<div class="c_form"><div class="thanks"><h1>Thanks,' .$name.'</h1><span>'.__('Your email was successfully sent', $shortname).'.</span></div></div>';
				
				} else { 

				 	if(isset($hasError)) { $output .= '<span class="error">'.__('There was an error submitting the form', $shortname).'.</span>'; }
				 	if($nameError != '') { $output .=' <span class="error">' .$nameError.'</span>';}
				 	if($emailError != '') { $output .= '<span class="error">'. $emailError.'</span>';}
				 	if($commentError != '') { $output .= '<span class="error">'. $commentError.'</span>'; }
				 	if($captchaError != '') { $output .= '<span class="error">'. $captchaError.'</span>'; } 

					$output .=	'<form class="contact_form_light" action="'.$action.'" id="contactFormLight" method="post"><div class="forms"><div><label for="contactNameLight"></label><input type="text" name="contactNameLight" id="contactNameLight" ';

					if(isset($_POST['contactNameLight'])) { $output .= 'value="'.$_POST['contactNameLight'].'"'; }
								
					$output .=  'class="requiredField" required="required" placeholder="'.__('Name', $shortname).'" size="22" tabindex="21" />';
					$output .='</div>';
					$output .= '<div><label for="user_email_light"></label><input type="text" name="user_email_light" id="user_email_light"';
					if(isset($_POST['user_email_light'])) {$output .= 'value="'.$_POST['user_email_light'].'"';}
					$output .= 'class="requiredField user_email_light" required="required" placeholder="'.__('Email', $shortname).'" size="22" tabindex="21" />';
					
					$output .= '</div><div class="textarea"><label for="commentsText"></label><textarea name="comments_light" id="commentsText" rows="10" cols="30" class="requiredField" required="required" placeholder="'.__('Message', $shortname).'" cols="30" rows="5" tabindex="23">';

					if(isset($_POST['comments_light'])) { 
						if(function_exists('stripslashes')) { 
							$output .= stripslashes($_POST['comments_light']); 
						} else { 
							$output .= $_POST['comments_light']; 
						} 
					} 
					
					$output .= '</textarea>';

					/* CAPCHA */
					$output .= '<div class="contact-captcha"><img src="'.$supremeshortcodes_path.'/captcha/captcha.php" id="captcha'.$id.'" />';
                    $output .= '<div class="bg-input captcha-holder">';
                    $output .= '<input type="text" name="captcha" id="captcha-form2" required="required" placeholder="Captcha" autocomplete="off" />';
                    $output .= '<div class="refresh-text">';
                    $output .= '<a onclick="document.getElementById(\'captcha'.$id.'\').src=\''.$supremeshortcodes_path.'/captcha/captcha.php?\'+Math.random(); document.getElementById(\'captcha-form2\').focus();" id="change-image" class="captcha-refresh"></a>';
                    $output .= '</div></div>';
                    $output .= '</div>';
                    /* CAPCHA */

					$output .= '</div><input type="hidden" name="submittedLight" id="submittedLight" value="true" /><button type="submit" class="ss-btn more"><span>' .$submitText.'</span></button><br /></div></form>';
				}
			$output .= '</div>';

	return $output;	
}


function SupremeShortcodesFree__video($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'src' => '',
		'width' => '',
		'height' => '',
		'type' => ''
	), $atts));

	$output = '';

	$rnd = mt_rand();

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

	return $output;
}

function SupremeShortcodesFree__soundcloud( $atts, $content=null ){
	extract(shortcode_atts(array(
		'src' => '',
		'color' => ''
	), $atts));

	$str= ltrim ($color,'#');

	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$src.'&amp;color='.$str.'&amp;auto_play=false&amp;show_artwork=true"></iframe>';
}


function SupremeShortcodesFree__mixcloud( $atts, $content=null ){
	extract(shortcode_atts(array(
		'src' => '',
		'width' => '',
		'height' => ''
	), $atts));

	return '<iframe width="'.$width.'" height="'.$height.'" src="//www.mixcloud.com/widget/iframe/?feed='.$src.'" frameborder="0"></iframe>';
}


function SupremeShortcodesFree__button_more($atts, $content = null) {
	extract(shortcode_atts(array(
		'text' => 'Read More',
		'href' => ''
	), $atts));

	$output = '';

	$output = '<a href="'.$href.'" class="ss-btn more">'.$text.'</a><div class="clear"></div>';

	return $output;
}

function SupremeShortcodesFree__horizontal_line($atts, $content = null) {
	
	return '<hr class="hr">'.$content;
}

function SupremeShortcodesFree__break_line($atts, $content = null) {
	
	return '<br>'.$content;
}

function SupremeShortcodesFree__div_clear($atts, $content = null) {
	
	return '<div class="clear"></div>'.$content;
}

function SupremeShortcodesFree__separator($atts, $content = null) {

	return '<div class="ss-separator"></div>'.$content;
}

function SupremeShortcodesFree__divider_dotted($atts, $content = null) {
	
	return '<div class="divider_dotted"></div>'.$content;
}

function SupremeShortcodesFree__divider_dashed($atts, $content = null) {
	
	return '<div class="divider_dashed"></div>'.$content;
}

function SupremeShortcodesFree__divider_top($atts, $content = null) {
	
	return '<div class="divider_top"><a href="#" class="to-top">'.__('top').' <i class="fa fa-angle-up st-size-1"></i></a></div>'.$content;
}

function SupremeShortcodesFree__divider_shadow($atts, $content = null) {
	
	return '<div class="divider_shadow"><img src="'.trailingslashit(rtrim(WP_PLUGIN_URL, '/') . '/SupremeShortcodesFree/').'images/divider_shadow.png"></div>'.$content;
}


function SupremeShortcodesFree__icon( $params ) {
    extract( shortcode_atts( array(
        'name'      => '',
        'size'      => '',
        'color'     => '',
        'type'      => '',
        'background'  => '',
        'align'  	=> '',
        'border_color'  => '',
        'icon_spin' => ''
    ), $params ) );

    $padding = '';
    $dimensions = '';

    if ($icon_spin == 'yes') {
		$spin = ' fa-spin';
	}else{
		$spin = '';
	}

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

    return '<span class="'.$final_align.'"><span class="'.$icon_type.' iconwrapp size-'.$final_size.'" style="'.$dimensions.$padding.'border: 1px solid '.$border.'; background: '.$bg_color.';"><i class="fa fa-'.$name.' '.$final_size.' '.$spin.'" style="color:'.$color.'"></i></span></span>';
}


function SupremeShortcodesFree__progress_bar($atts, $content = null){
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

function SupremeShortcodesFree__container($atts, $content = null) {

    return '<div class="container"><div>' . do_shortcode($content) . '</div></div>';

}


/* Code */
add_shortcode('st_code', 'SupremeShortcodesFree__code');

/* Media */
add_shortcode('st_video', 'SupremeShortcodesFree__video');
add_shortcode('st_youtube', 'SupremeShortcodesFree__youtube');  
add_shortcode('st_soundcloud', 'SupremeShortcodesFree__soundcloud');
add_shortcode('st_mixcloud', 'SupremeShortcodesFree__mixcloud');

/* Google */
add_shortcode('st_gmap','SupremeShortcodesFree__googlemap');
add_shortcode('st_trends','SupremeShortcodesFree__google_trends');

/* Contact Forms */
add_shortcode('st_contact_form_light','SupremeShortcodesFree__contact_form_light');

/* Related */
add_shortcode('st_children','SupremeShortcodesFree__page_children');
add_shortcode('st_siblings','SupremeShortcodesFree__page_siblings');

/* Responsive */
add_shortcode('st_row', 'SupremeShortcodesFree__row');
add_shortcode('st_column1', 'SupremeShortcodesFree__span1');
add_shortcode('st_column2', 'SupremeShortcodesFree__span2');
add_shortcode('st_column3', 'SupremeShortcodesFree__span3');
add_shortcode('st_column4', 'SupremeShortcodesFree__span4');
add_shortcode('st_column5', 'SupremeShortcodesFree__span5');
add_shortcode('st_column6', 'SupremeShortcodesFree__span6');
add_shortcode('st_column7', 'SupremeShortcodesFree__span7');
add_shortcode('st_column8', 'SupremeShortcodesFree__span8');
add_shortcode('st_column9', 'SupremeShortcodesFree__span9');
add_shortcode('st_column10', 'SupremeShortcodesFree__span10');
add_shortcode('st_column11', 'SupremeShortcodesFree__span11');
add_shortcode('st_column12', 'SupremeShortcodesFree__span12');

/* Tables */
add_shortcode('st_table', 'SupremeShortcodesFree__table');

/* Buttons */
add_shortcode('st_button', 'SupremeShortcodesFree__button');
add_shortcode('st_button_more', 'SupremeShortcodesFree__button_more');

/* Sharing */
add_shortcode('st_linkedin_share', 'SupremeShortcodesFree__linkedin_share');
add_shortcode('st_fbshare', 'SupremeShortcodesFree__fbshare');
add_shortcode('st_tweetmeme', 'SupremeShortcodesFree__tweetmeme');
add_shortcode('st_twitter', 'SupremeShortcodesFree__twitter');
add_shortcode('st_digg', 'SupremeShortcodesFree__digg');
add_shortcode('st_fblike', 'SupremeShortcodesFree__fblike');
add_shortcode('st_gplus', 'SupremeShortcodesFree__gplus');
add_shortcode('st_pinterest_pin', 'SupremeShortcodesFree__pinterest_pin');
add_shortcode('st_tumblr', 'SupremeShortcodesFree__tumblr');

/* Typography */
add_shortcode('st_highlight', 'SupremeShortcodesFree__highlight');
add_shortcode('st_label', 'SupremeShortcodesFree__label');
add_shortcode('st_dropcap', 'SupremeShortcodesFree__dropcap');

/* Tabs, Accordions */
add_shortcode('st_tabs', 'SupremeShortcodesFree__tabs' );
add_shortcode('st_tab', 'SupremeShortcodesFree__tab');
add_shortcode('st_toggle', 'SupremeShortcodesFree__toggle');
add_shortcode('st_panel', 'SupremeShortcodesFree__panel');

/* Lists */
add_shortcode('st_unordered', 'SupremeShortcodesFree__unordered');
add_shortcode('st_ordered', 'SupremeShortcodesFree__ordered');

/* Boxes */
add_shortcode('st_box', 'SupremeShortcodesFree__box');

/* Lines and Brakes*/
add_shortcode('st_horizontal_line', 'SupremeShortcodesFree__horizontal_line');
add_shortcode('st_break_line','SupremeShortcodesFree__break_line');
add_shortcode('st_clear','SupremeShortcodesFree__div_clear');

/* Dividers */
add_shortcode('st_divider_dotted','SupremeShortcodesFree__divider_dotted');
add_shortcode('st_divider_dashed','SupremeShortcodesFree__divider_dashed');
add_shortcode('st_divider_top','SupremeShortcodesFree__divider_top');
add_shortcode('st_divider_shadow','SupremeShortcodesFree__divider_shadow');

/* Container */
add_shortcode('st_container','SupremeShortcodesFree__container');

// Fontawesome icons
add_shortcode('st_icon', 'SupremeShortcodesFree__icon');

// Progress bar
add_shortcode('st_progress_bar', 'SupremeShortcodesFree__progress_bar');


// Filter CODE and PRECODE shortcodes
add_filter('no_texturize_shortcodes', 'SupremeShortcodesFree__no_texturized_shortcodes_filter');
?>