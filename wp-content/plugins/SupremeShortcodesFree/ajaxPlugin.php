<?php 
	require('../../../wp-blog-header.php');

	if (!is_user_logged_in()){
		die("You are not logged in! Please log in to use Supreme Shortcodes FREE plugin!");
	} 

	header('HTTP/1.1 200 OK');

	if($_GET['act'] == 'preview') {
		echo do_shortcode(stripslashes($_POST['data']));
		die();
	}

	global $shortname;
?>


<!-- These kind of scripts (are in this file only and) can not be wp_enqueue_script -ed, since the whole file is called by AJAX for Live Preview shortcode -->
<script type="text/javascript">

	// Upload Image button function
	function loadImageFrame(callback) {
	    var originalZIndex;

	    // Create the media frame.
	    var frame = wp.media.frames.file_frame = wp.media({
	        title: jQuery(this).data('uploader_title'),
	        button: {
	            text: jQuery(this).data('uploader_button_text'),
	        },
	        library: {
	            type: 'image'
	        },
	        multiple: false // Set to true to allow multiple files to be selected
	    });

	    // When an image is selected, run a callback.
	    frame.on('select', function() {
	        // We set multiple to false so only get one image from the uploader
	        var attachment = frame.state().get('selection').first().toJSON();

	        if (callback) {
	            jQuery(".media-modal").css("z-index", originalZIndex);
	            callback(attachment);
	        }
	    });

	    // Finally, open the modal
	    frame.open();

	    originalZIndex = jQuery(".media-modal").css("z-index");
	    jQuery(".media-modal").css("z-index", 500001);
	}

	(function($) {
		//////////////////////////////////
		//	New Color Picker
		//////////////////////////////////
		function newColorPicker(){
			var lastColorInput;

			$('.pickcolor').each( function() {
				var hiddenInput = $(this).parent().find(".color");
				$(this).minicolors({
					change: function(hex, opacity) {
				        lastColorInput = hex;
	      				hiddenInput.val(lastColorInput);
				    }
				});
			});

		}
		newColorPicker();

		// Upload Image button
		$('.upload_image_button').each(function(){
		    $(this).live('click', function (event){

		    	formfield = $(this).parent().find('.imageField');

		    	event.preventDefault();
			    window.parent.loadImageFrame(function(attachment) {
			    	jQuery("#imageid").val(attachment.id);
			    	jQuery("#image_id").val(attachment.id);
			    	formfield.val(attachment.url);
			    	jQuery("#imagethumb").attr("src", attachment.sizes.thumbnail.url);
			    });

		    });
		});


		$(".ss-search").keyup(function(){
			var filter = $(this).val(), count = 0;
			$(".ss-icon-list li").each(function(){
				if ($(this).text().search(new RegExp(filter, "i")) < 0) {
					$(this).fadeOut();
				} else {
					$(this).show();
					count++;
				}
			});
		});

		$("#ss-icon-dropdown li").click(function() {
			$(this).attr("class","selected").siblings().removeAttr("class");
			var icon = $(this).attr("data-icon");
			$("#name").val(icon);
			$(".ss-icon-preview").html("<i class=\'icon fa fa-"+icon+"\'></i>");
		});


		// set the displayWidth/Height to be 90% of the window
		var displayWidth = $(window).width() * 0.9;
		//var displayHeight = $(window).height() * 0.9;
		var displayHeight = $(window).height() - 100 + 'px';
		// Animate the thickbox window to the new size
		$("#TB_ajaxContent").animate({
		    height: displayHeight,
		    width: 100 + '%'
		}, {
		    duration: 200
		});


	})(jQuery);
</script>


<div class="clear" id="options-buttons">
	<div class="alignleft">
		<input type="button" accesskey="C" value="<?php _e('Cancel', $shortname); ?>" name="cancel" class="button" id="cancel">
	</div>
	<div class="alignright">
		<input type="button" accesskey="I" value="<?php _e('Insert', $shortname); ?>" name="insert" class="button-primary" id="insert">
	</div>
	<?php if(isset($_GET['preview']) && $_GET['preview']!= 'remove'){ ?>
	<div class="alignright">
		<input type="button" accesskey="P" value="<?php _e('Preview', $shortname); ?>" name="preview" class="button-primary" id="preview">
	</div>
	<?php } ?>
	<div class="clear"></div>
</div><!-- #options-buttons -->

<div class="clear"></div>

<div id="options">
	<form id="shortcodes">
	<?php 
		$act = $_GET['act'];
		if($act == 'createTable') {
	?>
	<script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#cols, #rows').keyup(function() {
				var colsEl = $("#cols");
				var rowsEl = $("#rows");
				var table = '';
				var tag = 'td';
				var j;
				if($(colsEl).val() != '' && $(rowsEl).val() != '') {
					for(var i=0; i<$(rowsEl).val(); i++) {
				        if(i == 0) {
				                table += '<thead>' + "\n";
				                tag = 'th';
				        } else if (i==1) {
								table += '<tfoot>'+ "\n";
								tag = 'td';
						} else {
				                table += '<tr>' + "\n";
				                tag = 'td';
				        }
						if (i!=1) {
							for(j=0; j<$(colsEl).val(); j++) {
								var value = ($('#input_'+i+''+j).val() != undefined) ? $('#input_'+i+''+j).val() : '';
								table += '<'+tag+'><input type="text" class="medium" name="input['+i+']['+j+']" id="input_'+i+''+j+'" value="'+value+'"></'+tag+'>' + "\n";
							}
						} else {
							j =0;
							var value = ($('#input_'+i+''+j).val() != undefined) ? $('#input_'+i+''+j).val() : '';
							table += '<'+tag+' colspan="'+$(colsEl).val()+'"><input type="text" class="medium" name="input['+i+']['+j+']" id="input_'+i+''+j+'" value="'+value+'" style="float: none; text-align:center"></'+tag+'>' + "\n";
						}
						if(i == 0) {
				          table += '</thead>' + "\n";
				        } else if (i==1) {
								table += '</tfoot>'+ "\n";
						} else {
				                table += '</tr>' + "\n";
				        }
					}
					$('.tableHolder').empty().append('<div class="box empty"></div>').find('.box').append($('<table>').attr('class', 'TABLEtheme').append(table));
				}
                return false;
            });
        });
	</script>
	<h3><?php _e('Create table shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
        <label for="cols"><?php _e('Columns', $shortname); ?></label>
        <input type="text" class="small" id="cols" name="cols" />
    </div>
    <div class="inputs">
        <label for="rows"><?php _e('Rows', $shortname); ?></label>
        <input type="text" class="small" id="rows" name="rows" />
	</div>
	<div class="clear"></div>
	<div class="tableHolder"></div>



<?php } elseif($act == 'readMore') { ?>
	<h3><?php _e('Insert read more button shortcode', $shortname); ?></h3>
	<hr>
	<div class="inputs req">
		<label for="btn_more_src"><?php _e('Link', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="btn_more_src" name="btn_more_src" />
		<span class="help"><?php _e('URL to page', $shortname); ?>.</span>
	</div>



<?php } elseif($act == 'insertButton') { ?>
	<h3><?php _e('Insert button shortcode', $shortname); ?></h3>
	<hr>
	<div class="inputs req">
		<label for="text"><?php _e('Text', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="text" name="text" />
		<span class="help"><?php _e('The button text', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="color"><?php _e('Text Color', $shortname); ?></label>
		<input type="text" size="4" id="color" name="color" value="#ffffff" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Color of text (Optional, default: #ffffff)', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="link"><?php _e('Link', $shortname); ?></label>
		<input type="text" id="link" name="link" />
		<span class="help"><?php _e('Button link (Optional, e.g. http://www.supremefactory.net, default: #)', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="target"><?php _e('Target', $shortname); ?></label>
		<select name="target" id="target">
			<option value="_self"><?php _e('_self', $shortname); ?></option>
			<option value="_blank"><?php _e('_blank', $shortname); ?></option>
			<option value="_parent"><?php _e('_parent', $shortname); ?></option>
			<option value="_top"><?php _e('_top', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="bg"><?php _e('Background Color', $shortname); ?></label>
		<input type="text" size="4" id="bg" name="bg" value="#247de3" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Background color (Optional)', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="size"><?php _e('Size', $shortname); ?></label>
		<select name="size" id="size">
			<option value="small"><?php _e('Small', $shortname); ?></option>
			<option valuw="normal"><?php _e('Normal', $shortname); ?></option>
			<option value="large"><?php _e('Large', $shortname); ?></option>
			<option value="jumbo"><?php _e('Jumbo', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="border_radius"><?php _e('Border Radius', $shortname); ?></label>
		<input type="text" id="border_radius" name="border_radius" />
		<span class="help"><?php _e('Example: 4px. The greater number of pixels, more roundness to the button.', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="name"><?php _e('Choose icon', $shortname); ?>:</label>
		<?php 
			$icons = array('none', 'adjust', 'adn', 'align-center', 'align-justify', 'align-left', 'align-right', 'ambulance', 'anchor', 'android', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'apple', 'archive', 'arrow-circle-down', 'arrow-circle-left', 'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right', 'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'arrows', 'arrows-alt', 'arrows-h', 'arrows-v', 'asterisk', 'backward', 'ban', 'bar-chart-o', 'barcode', 'bars', 'beer', 'bell', 'bell-o', 'bitbucket', 'bitbucket-square', 'bitcoin', 'bold', 'bolt', 'book', 'bookmark', 'bookmark-o', 'briefcase', 'btc', 'bug', 'building-o', 'bullhorn', 'bullseye', 'calendar', 'calendar-o', 'camera', 'camera-retro', 'caret-down', 'caret-left', 'caret-right', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'caret-up', 'certificate', 'chain', 'chain-broken', 'check', 'check-circle', 'check-circle-o', 'check-square', 'check-square-o', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'circle', 'circle-o', 'clipboard', 'clock-o', 'cloud', 'cloud-download', 'cloud-upload', 'cny', 'code', 'code-fork', 'coffee', 'cog', 'cogs', 'columns', 'comment', 'comment-o', 'comments', 'comments-o', 'compass', 'compress', 'copy', 'credit-card', 'crop', 'crosshairs', 'css3', 'cut', 'cutlery', 'dashboard', 'dedent', 'desktop', 'dollar', 'dot-circle-o', 'download', 'dribbble', 'dropbox', 'edit', 'eject', 'ellipsis-h', 'ellipsis-v', 'envelope', 'envelope-o', 'eraser', 'eur', 'euro', 'exchange', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'expand', 'external-link', 'external-link-square', 'eye', 'eye-slash', 'facebook', 'facebook-square', 'fast-backward', 'fast-forward', 'female', 'fighter-jet', 'file', 'file-o', 'file-text', 'file-text-o', 'files-o', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash', 'flask', 'flickr', 'floppy-o', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'font', 'forward', 'foursquare', 'frown-o', 'gamepad', 'gavel', 'gbp', 'gear', 'gears', 'gift', 'github', 'github-alt', 'github-square', 'gittip', 'glass', 'globe', 'google-plus', 'google-plus-square', 'group', 'h-square', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hdd-o', 'headphones', 'heart', 'heart-o', 'home', 'hospital-o', 'html5', 'inbox', 'indent', 'info', 'info-circle', 'inr', 'instagram', 'italic', 'jpy', 'key', 'keyboard-o', 'krw', 'laptop', 'leaf', 'legal', 'lemon-o', 'level-down', 'level-up', 'lightbulb-o', 'link', 'linkedin', 'linkedin-square', 'linux', 'list', 'list-alt', 'list-ol', 'list-ul', 'location-arrow', 'lock', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'magic', 'magnet', 'mail-forward', 'mail-reply', 'mail-reply-all', 'male', 'map-marker', 'maxcdn', 'medkit', 'meh-o', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mobile', 'mobile-phone', 'money', 'moon-o', 'music', 'none', 'outdent', 'pagelines', 'paperclip', 'paste', 'pause', 'pencil', 'pencil-square', 'pencil-square-o', 'phone', 'phone-square', 'picture-o', 'pinterest', 'pinterest-square', 'plane', 'play', 'play-circle', 'play-circle-o', 'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'power-off', 'print', 'puzzle-piece', 'qrcode', 'question', 'question-circle', 'quote-left', 'quote-right', 'random', 'refresh', 'renren', 'repeat', 'reply', 'reply-all', 'retweet', 'rmb', 'road', 'rocket', 'rotate-left', 'rotate-right', 'rouble', 'rss', 'rss-square', 'rub', 'ruble', 'rupee', 'save', 'scissors', 'search', 'search-minus', 'search-plus', 'share', 'share-square', 'share-square-o', 'shield', 'shopping-cart', 'sign-in', 'sign-out', 'signal', 'sitemap', 'skype', 'smile-o', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-up', 'spinner', 'square', 'square-o', 'stack-exchange', 'stack-overflow', 'star', 'star-half', 'star-half-empty', 'star-half-full', 'star-half-o', 'star-o', 'step-backward', 'step-forward', 'stethoscope', 'stop', 'strikethrough', 'subscript', 'suitcase', 'sun-o', 'superscript', 'table', 'tablet', 'tachometer', 'tag', 'tags', 'tasks', 'terminal', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'ticket', 'times', 'times-circle', 'times-circle-o', 'tint', 'toggle-down', 'toggle-left', 'toggle-right', 'toggle-up', 'trash-o', 'trello', 'trophy', 'truck', 'try', 'tumblr', 'tumblr-square', 'turkish-lira', 'twitter', 'twitter-square', 'umbrella', 'underline', 'undo', 'unlink', 'unlock', 'unlock-alt', 'unsorted', 'upload', 'usd', 'user', 'user-md', 'users', 'video-camera', 'vimeo-square', 'vk', 'volume-down', 'volume-off', 'volume-up', 'warning', 'weibo', 'wheelchair', 'windows', 'won', 'wrench', 'xing', 'xing-square', 'youtube', 'youtube-play', 'youtube-square', 'angellist', 'area-chart', 'at', 'bell-slash', 'bell-slash-o', 'bicycle', 'binoculars', 'birthday-cake', 'bus', 'calculator', 'cc', 'cc-amex', 'cc-discover', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'copyright', 'eyedropper', 'futbol-o', 'google-wallet', 'ils', 'ioxhost', 'lastfm', 'lastfm-square', 'line-chart', 'meanpath', 'newspaper-o', 'paint-brush', 'paypal', 'pie-chart', 'plug', 'ils', 'slideshare', 'futbol-o', 'toggle-off', 'toggle-on', 'trash', 'tty', 'twitch', 'wifi', 'yelp', 'spotify');

			echo '<input type="hidden" name="name" value="fa fa-'.$value.'" id="name" />';
			echo '<div class="ss-icon-preview"><i class=" fa fa-'.$value.'"></i></div>';
			echo '<input class="ss-search" type="text" placeholder="Search icon" />';
			echo '<div id="ss-icon-dropdown">';
			echo '<ul class="ss-icon-list">';
			$n = 1;
			foreach($icons as $icon){
				$selected = ($icon == $value) ? 'class="selected"' : '';
				$id = 'icon-'.$n;
				echo '<li '.$selected.' data-icon="'.$icon.'"><i class="icon fa fa-'.$icon.'"></i><label class="icon">'.$icon.'</label></li>';
				$n++;
			}
			echo '</ul>';
			echo '</div>';
		?>
	</div>
	<div class="inputs">
		<label for="icon_spin"><?php _e('Spin?', $shortname); ?></label>
		<select name="icon_spin" id="icon_spin">
			<option value="no"><?php _e('No', $shortname); ?></option>
			<option value="yes"><?php _e('Yes', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('If yes, icon will rotate clockwise.', $shortname); ?></span>
	</div>


<?php } elseif($act == 'createUnorderedList') { ?>
	<h3><?php _e('Select List icon', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="listicon"><?php _e('Icons', $shortname); ?></label>
		<select name="listicon" id="listicon">
			<option value="success" id="list_success"><?php _e('Success', $shortname); ?></option>
			<option value="info" id="list_info"><?php _e('Info', $shortname); ?></option>
			<option value="green plus" id="list_green_plus"><?php _e('Green plus', $shortname); ?></option>
			<option value="red minus" id="list_red_minus"><?php _e('Red minus', $shortname); ?></option>
			<option value="warning" id="list_warning"><?php _e('Warning', $shortname); ?></option>
			<option value="star" id="list_star"><?php _e('Star', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>

	
<?php } elseif($act == 'insertBox') { ?>
	<h3><?php _e('Insert box shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs req">
		<label for="box_title"><?php _e('Title', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="box_title" name="box_title" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs req">
		<label for="text"><?php _e('Text', $shortname); ?> <span style="color:red;">*</span></label>
		<textarea name="text" id="text"></textarea>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="box_type"><?php _e('Type', $shortname); ?></label>
		<select name="box_type" id="box_type">
			<option value="info"><?php _e('Info', $shortname); ?></option>
			<option value="warning"><?php _e('Warning', $shortname); ?></option>
			<option value="success"><?php _e('Success', $shortname); ?></option>
			<option value="error"><?php _e('Alert', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>

	
<?php } elseif($act == 'createTabs') { ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
		jQuery('#tabs').keyup(function() {
			var tabs = ''; 
			tabs += '<div class="box"><div class="inputs"></div></div>';
	        if($('#tabs').val() != '') {
                for(var i=0; i<$('#tabs').val(); i++) {
                	var titleVal = (jQuery("#title_" + i).val() != undefined) ? jQuery("#title_" + i).val() : '';
                	var textVal = (jQuery("#text_" + i).val() != undefined) ? jQuery("#text_" + i).val() : '';
                        tabs += '<div class="box">Tab #'+(i+1)+'<br/><div class="inputs"><label for="title_'+i+'">Title:</label><input type="text" id="title_'+i+'" name="title_'+i+'" value="'+titleVal+'"></div><div class="inputs"><label for="content_'+i+'">Content:</label><textarea id="text_'+i+'" name="text_'+i+'">'+textVal+'</textarea></div><div class="clear"></div></div>' + "\n";
                }
                $('.tabsHolder').empty().append(tabs);
	        }
	        return false;
		});
    });
</script>
<h3><?php _e('Create tabbed content shortcode', $shortname); ?></h3>
<hr />
<div class="inputs">
    <label for="tabs"><?php _e('Number of Tabs', $shortname); ?></label>
    <input type="text" class="small" id="tabs" name="tabs" />
</div>
<div class="clear"></div>
<div class="tabsHolder"></div>


<?php } elseif($act == 'toggle') { ?>
	<script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery('#accs').keyup(function() {
            	var accs = ''; 
                if($('#accs').val() != '') {
                        for(var i=0; i<$('#accs').val(); i++) {
                        	var titleVal = (jQuery("#title_" + i).val() != undefined) ? jQuery("#title_" + i).val() : '';
                        	var textVal = (jQuery("#text_" + i).val() != undefined) ? jQuery("#text_" + i).val() : '';
                        	var stateVal = (jQuery("#state_" + i).val() != undefined) ? jQuery("#state_" + i).val() : '';
                                accs += '<div class="box">Panel #'+(i+1)+'<br/><div class="inputs"><label for="title_'+i+'">Title:</label><input type="text" id="title_'+i+'" name="title_'+i+'" value="'+titleVal+'"></div><div class="inputs"><label for="content_'+i+'">Content:</label><textarea id="text_'+i+'" name="text_'+i+'">'+textVal+'</textarea></div><div class="inputs"><label for="state">State:</label><select name="state_'+i+'" id="state_'+i+'"><option value="closed">closed</option><option value="open">open</option></select></div><div class="clear"></div></div>' + "\n";
                        }
                        $('.accHolder').empty().append(accs);
                }
                return false;
            });
        });
	</script>
	<h3><?php _e('Create toggle shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
        <label for="accs"><?php _e('Number of Panels', $shortname); ?></label>
        <input type="text" class="small" id="accs" name="accs" />
	</div>
	<div class="clear"></div>
	<div class="accHolder"></div>


<?php } elseif($act == 'progress_bar') { ?>
	<h3><?php _e('Create Progress Bar shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs req">
        <label for="width"><?php _e('Width', $shortname); ?></label>
        <input type="text" id="width" name="width" />
        <span class="help"><?php _e('Example: 80%', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="style"><?php _e('Style', $shortname); ?></label>
		<select name="style" id="style">
			<option value="info"><?php _e('Blue', $shortname); ?></option>
			<option value="success"><?php _e('Green', $shortname); ?></option>
			<option value="warning"><?php _e('Yellow', $shortname); ?></option>
			<option value="danger"><?php _e('Red', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="striped"><?php _e('Striped', $shortname); ?></label>
		<select name="striped" id="striped">
			<option value="striped"><?php _e('Striped', $shortname); ?></option>
			<option value="no_stripes"><?php _e('No Stripes', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="active"><?php _e('Active', $shortname); ?></label>
		<select name="active" id="active">
			<option value="yes"><?php _e('Yes', $shortname); ?></option>
			<option value="no"><?php _e('No', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="clear"></div>


<?php } elseif($act == 'highlight') { ?>
	<h3><?php _e('Create Highlighted Text', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="background_color"><?php _e('Background color', $shortname); ?></label>
		<input type="text" size="4" id="background_color" name="background_color" value="#ffffff" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Background color (Optional, default: #ffffff)', $shortname); ?></span>
	</div>
	<div class="clear"></div>
	<div class="inputs">
		<label for="text_color"><?php _e('Text color', $shortname); ?></label>
		<input type="text" size="4" id="text_color" name="text_color" value="#444444" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Text color (Optional, default: #444444)', $shortname); ?></span>
	</div>
	<div class="clear"></div>
		

<?php } elseif($act == 'related') { ?>
	<h3><?php _e('Insert related posts shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="limit"><?php _e('Number of related posts to show', $shortname); ?></label>
		<input type="text" id="limit" name="limit" class="small" />
		<span class="help"><?php _e('Number of posts to show (default: 5)', $shortname); ?></span>
	</div>


<?php } elseif($act == 'twitter') { ?>
	<h3><?php _e('Insert twitter button shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="style"><?php _e('Style', $shortname); ?></label>
		<select name="style" id="style">
			<option value="vertical"><?php _e('vertical (default)', $shortname); ?></option>
			<option value="horizontal"><?php _e('horizontal', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="url"><?php _e('Url', $shortname); ?></label>
		<input type="text" id="url" name="url" />
		<span class="help"><?php _e('Specify URL directly. (Optional)', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="source"><?php _e('Source', $shortname); ?></label>
		<input type="text" id="source" name="source" />
		<span class="help"><?php _e('Username to mention in tweet. (Optional)', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="related"><?php _e('Related', $shortname); ?></label>
		<input type="text" id="related" name="related" />
		<span class="help"><?php _e('Related account. (Optional)', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="text"><?php _e('Text', $shortname); ?></label>
		<input type="text" id="text" name="text" />
		<span class="help"><?php _e('Tweet text (Optional, default: title of page)', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="lang"><?php _e('Lang', $shortname); ?></label>
		<select name="lang" id="lang">
			<option value="en"><?php _e('english (default)', $shortname); ?></option>
			<option value="fr"><?php _e('french', $shortname); ?></option>
			<option value="de"><?php _e('deutch', $shortname); ?></option>
			<option value="es"><?php _e('spain', $shortname); ?></option>
			<option value="js"><?php _e('japanise', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>

	
<?php } elseif($act == 'digg') { ?>
	<h3><?php _e('Insert digg button shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="style"><?php _e('Style', $shortname); ?></label>
		<select name="style" id="style">
			<option value="medium"><?php _e('medium (default)', $shortname); ?></option>
			<option value="large"><?php _e('large', $shortname); ?></option>
			<option value="compact"><?php _e('compact', $shortname); ?></option>
			<option value="icon"><?php _e('icon', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="digg_title"><?php _e('Title', $shortname); ?></label>
		<input type="text" id="digg_title" name="digg_title" />
		<span class="help"><?php _e('Specify title directly (Optional, must add link also)', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="digg_link"><?php _e('Link', $shortname); ?></label>
		<input type="text" id="digg_link" name="digg_link" />
		<span class="help"><?php _e('Specify link directly. (Optional)', $shortname); ?></span>
	</div>

	
<?php } elseif($act == 'fblike') { ?>
	<h3><?php _e('Insert facebook like button shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="url"><?php _e('Url', $shortname); ?></label>
		<input type="text" id="url" name="url" />
		<span class="help"><?php _e('Optionally place the URL you want viewers to "Like" here.<br />Defaults to the page/post URL.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="style"><?php _e('Style', $shortname); ?></label>
		<select name="style" id="style">
			<option value="standard"><?php _e('standard (Default)', $shortname); ?></option>
			<option value="button_count"><?php _e('button_count', $shortname); ?></option>
			<option value="box_count"><?php _e('box_count', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="show_faces"><?php _e('Show faces', $shortname); ?></label>
		<select name="show_faces" id="show_faces">
			<option value="false"><?php _e('false (Default)', $shortname); ?></option>
			<option value="true"><?php _e('true', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('Show the faces of Facebook users who "Like" your URL', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="width"><?php _e('Width', $shortname); ?></label>
		<input type="text" id="width" name="width" class="small" />
		<span class="help"><?php _e('Set the width of this button in pixels. Note: numbers only. Eg: 200', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="verb_to_display"><?php _e('Verb to display', $shortname); ?></label>
		<select name="verb_to_display" id="verb_to_display">
			<option value="like"><?php _e('like (Default)', $shortname); ?></option>
			<option value="recommend"><?php _e('recommend', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('The verb to display with this button', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="font"><?php _e('Font', $shortname); ?></label>
		<select name="font" id="font">
			<option value="arial"><?php _e('arial (Default)', $shortname); ?></option>
			<option value="lucida grande"><?php _e('lucida grande', $shortname); ?></option>
			<option value="segoe ui"><?php _e('segoe ui', $shortname); ?></option>
			<option value="tahoma"><?php _e('tahoma', $shortname); ?></option>
			<option value="trebuchet ms"><?php _e('trebuchet ms', $shortname); ?></option>
			<option value="verdana"><?php _e('verdana', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('The font to use when displaying this button', $shortname); ?>.</span>
	</div>
	

<?php } elseif($act == 'fbshare') { ?>
	<h3><?php _e('Insert facebook share button shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="link"><?php _e('Url', $shortname); ?></label>
		<input type="text" id="link" name="link" />
		<span class="help"><?php _e('Optionally place the URL you want viewers to "Like" here.<br />Defaults to the page/post URL', $shortname); ?>.</span>
	</div>


<?php } elseif($act == 'lishare') { ?>
	<h3><?php _e('Insert linked in share button shortcode', $shortname); ?></h3>
	<hr />
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="link"><?php _e('Url', $shortname); ?></label>
			<input type="text" id="link" name="link" />
			<span class="help"><?php _e('Optionally place the URL you want viewers to "Like" here.<br />Defaults to the page/post URL', $shortname); ?>.</span>
		</div>
		<div class="inputs">
			<label for="style"><?php _e('Style', $shortname); ?></label>
			<select name="style" id="style">
			<option value="none"><?php _e('no counter (Default)', $shortname); ?></option>
				<option value="top"><?php _e('top', $shortname); ?></option>
				<option value="right"><?php _e('right', $shortname); ?></option>
			</select>
			<span class="help">&nbsp;</span>
		</div>
	</div>


<?php } elseif($act == 'gplus') { ?>
	<h3><?php _e('Insert google plus button shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="style"><?php _e('Style', $shortname); ?></label>
		<select name="style" id="style">
			<option value="inline"><?php _e('Inline', $shortname); ?></option>
			<option value="bubble"><?php _e('Bubble', $shortname); ?></option>
			<option value="none"><?php _e('None', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="size"><?php _e('Size', $shortname); ?></label>
		<select name="size" id="size">
			<option value="small"><?php _e('Small', $shortname); ?></option>
			<option value="medium"><?php _e('Medium', $shortname); ?></option>
			<option value="standard"><?php _e('Standard', $shortname); ?></option>
			<option value="tall"><?php _e('Tall', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'pinterest_pin') { ?>
	<h3><?php _e('Insert pinterest button shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="style"><?php _e('Style', $shortname); ?></label>
		<select name="style" id="style">
			<option value="above"><?php _e('Above', $shortname); ?></option>
			<option value="beside"><?php _e('Beside', $shortname); ?></option>
			<option value="none"><?php _e('None', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'tumblr') { ?>
	<h3><?php _e('Insert tumbler button shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="style"><?php _e('Style', $shortname); ?></label>
		<select name="style" id="style">
			<option value="plus"><?php _e('Plus', $shortname); ?></option>
			<option value="standard"><?php _e('Standard', $shortname); ?></option>
			<option value="icon_text"><?php _e('Icon + Text', $shortname); ?></option>
			<option value="icon"><?php _e('Icon', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'gmap')  { ?>
	<h3><?php _e('Google Map shortcode', $shortname); ?></h3>
	<hr />
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="gwidth"><?php _e('Width', $shortname); ?>:</label>
			<input id="gwidth" name="gwidth" type="text" />
			<span class="help"><?php _e('(Optional) Example: 500 - In pixels.', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="gheight"><?php _e('Height', $shortname); ?>:</label>
			<input id="gheight" name="gheight" type="text" />
			<span class="help"><?php _e('(Optional) Example: 250 - In pixels.', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="latitude"><?php _e('Latitude', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="latitude" name="latitude" type="text" />
			<span class="help"><?php _e('Exapmle', $shortname); ?>: 51.519586</span>
		</div>
		<div class="inputs">
			<label for="longitute"><?php _e('Longitute', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="longitute" name="longitute" type="text" />
			<span class="help"><?php _e('Exapmle', $shortname); ?>: -0.102474</span>
		</div>
		<div class="inputs">
			<label></label>
			<span class="help"><?php _e('To convert an address into latitude & longitude please use this converter: <br><a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Convert address to latitude and longotude.</a>', $shortname); ?></span>
		</div>
		<div class="inputs req">
			<label for="zoom"><?php _e('Zoom value', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="zoom" name="zoom" type="text" size="3" />
			<span class="help"><?php _e('Zoom value from 1 to 19', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="html"><?php _e('Content for the marker', $shortname); ?>:</label>
			<input id="html" name="html" type="text" />
		</div>
		<div class="inputs">
			<label for="maptype"><?php _e('Map type', $shortname); ?></label>
			<select name="maptype" id="maptype">
				<option value="ROADMAP"><?php _e('Road map', $shortname); ?></option>
				<option value="SATELLITE"><?php _e('Satellite', $shortname); ?></option>
				<option value="HYBRID"><?php _e('Hybrid', $shortname); ?></option>
				<option value="TERRAIN"><?php _e('Terrain', $shortname); ?></option>
			</select>
		</div>
		<div class="inputs">
			<label for="color"><?php _e('Color', $shortname); ?>:</label>
			<br><input id="color" name="color" type="text" value="" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('NOTE: Applies only for Road Map.', $shortname); ?></span>
		</div>
	</div>


<?php } elseif($act == 'trends')  { ?>
	<h3><?php _e('Google Trends shortcode', $shortname); ?></h3>
	<hr />
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="width"><?php _e('Width', $shortname); ?>:</label>
			<input id="width" name="width" type="text" />
			<span class="help"><?php _e('Default', $shortname); ?>: 500</span>
		</div>
		<div class="inputs">
			<label for="height"><?php _e('Height', $shortname); ?>:</label>
			<input id="height" name="height" type="text" />
			<span class="help"><?php _e('Default', $shortname); ?>: 330</span>
		</div>
		<div class="inputs">
			<label for="query"><?php _e('Query', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="query" name="query" type="text" />
			<span class="help"><?php _e('Exapmle', $shortname); ?>: wordpress, theme, supremefactory</span>
		</div>
		<div class="inputs">
			<label for="geo"><?php _e('Geo', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="geo" name="geo" type="text" />
			<span class="help"><?php _e('Default', $shortname); ?>: US</span>
		</div>
	</div>


<?php } elseif($act == 'children') {
		$tpages = get_pages(array('sort_order' => 'ASC'));
	?>
	<h3><?php _e('Page children shortcode', $shortname); ?></h3>
	<hr />
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="page"><?php _e('Parent page', $shortname); ?></label>
			<select name="page" id="page">
				<?php foreach($tpages as $tpage): ?>
					<option value="<?php echo $tpage->ID; ?>"><?php echo $tpage->post_title ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>


<?php } elseif($act == 'contact_form_light') { ?>
	<h4><?php _e('Contact form shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs req">
			<label for="email_l"><?php _e('Email', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="email_l" name="email_l" type="text" />
			<span class="help"><?php _e('Email where submitted form will go to', $shortname); ?></span>
		</div>
	</div>


<?php } elseif($act == 'video') { ?>
	<h4><?php _e('Video shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder" id="video_id">
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var rnd = 1;
				var display_id = '#display';
				var videotype_id = '#video_type';
				var parent = $('#video_id');
				$(display_id, $(parent)).bind('change', function() {
					var value = $(this).val();
					$('.display_type', $(parent)).css('display', 'none');
					$('.' + value, $(parent)).css('display', 'block');
				});
				$(display_id, $(parent)).trigger('change');
				
				$(videotype_id, $(parent)).bind('change', function() {
					var value = $(this).val();
					$('.video_type', $(parent)).css('display', 'none');
					$('.' + value, $(parent)).css('display', 'block');
				});
				$(videotype_id, $(parent)).trigger('change');
			});
		</script>
		<div class="inputs">
			<label for="video_title"><?php _e('Title', $shortname); ?>:</label>
			<input class="widefat" id="video_title" name="video_title" type="text" />
		</div>		
		<div class="inputs req">
			<label for="width"><?php _e('Width', $shortname); ?>:</label>
			<input class="widefat" id="width" name="width" type="text" value="" />
			<span class="help"><?php _e('Example: 500', $shortname); ?></span>
		</div>
		<div class="inputs req">
			<label for="height"><?php _e('Height', $shortname); ?>:</label>
			<input class="widefat" id="height" name="height" type="text" value="" />
			<span class="help"><?php _e('Example: 300', $shortname); ?></span>
		</div>
		
		<div class="inputs">
			<label for="video_type"><?php _e('Type', $shortname); ?></label>
			<select name="video_type" id="video_type">
				<option value="youtube"><?php _e('YouTube', $shortname); ?></option>
				<option value="vimeo"><?php _e('Vimeo', $shortname); ?></option>
			</select>
		</div>
		
		<div class="youtube vimeo video_type">
			<div class="inputs">
				<label for="clip_id"><?php _e('Clip id', $shortname); ?>:</label>
				<input class="widefat" id="clip_id" name="clip_id" type="text" value="" />
			</div>
		</div>
	</div>


<?php } elseif($act == 'soundcloud') { ?>
	<h4><?php _e('Soundcloud shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="sound_src"><?php _e('URL', $shortname); ?>:</label>
			<input id="sound_src" name="sound_src" type="text" />
			<span class="help">Example: https://soundcloud.com/puresoul/puresoul-x-step-mini-av-mix</span>
		</div>
		<div class="inputs">
			<label for="sound_color"><?php _e('Color', $shortname); ?>:</label>
			<input id="sound_color" name="sound_color" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help">&nbsp;</span>
		</div>
	</div>


<?php } elseif($act == 'mixcloud') { ?>
	<h4><?php _e('Mixcloud shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="mix_width"><?php _e('Width', $shortname); ?>:</label>
			<input id="mix_width" name="mix_width" type="text" />
		</div>
		<div class="inputs">
			<label for="mix_height"><?php _e('Height', $shortname); ?>:</label>
			<input id="mix_height" name="mix_height" type="text" />
		</div>
		<div class="inputs">
			<label for="mix_src"><?php _e('URL', $shortname); ?>:</label>
			<input id="mix_src" name="mix_src" type="text" />
			<span class="help">Example: http://www.mixcloud.com/puresoul/puresoul-x-step-mini-av-mix/</span>
		</div>
	</div>


<?php } elseif($act == 'icon') { ?>
	<h4><?php _e('Icon shortcode', $shortname); ?></h4>
	<hr>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="name"><?php _e('Choose icon', $shortname); ?>:</label>
			<?php 
				$icons = array('none', 'adjust', 'adn', 'align-center', 'align-justify', 'align-left', 'align-right', 'ambulance', 'anchor', 'android', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'apple', 'archive', 'arrow-circle-down', 'arrow-circle-left', 'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right', 'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'arrows', 'arrows-alt', 'arrows-h', 'arrows-v', 'asterisk', 'backward', 'ban', 'bar-chart-o', 'barcode', 'bars', 'beer', 'bell', 'bell-o', 'bitbucket', 'bitbucket-square', 'bitcoin', 'bold', 'bolt', 'book', 'bookmark', 'bookmark-o', 'briefcase', 'btc', 'bug', 'building-o', 'bullhorn', 'bullseye', 'calendar', 'calendar-o', 'camera', 'camera-retro', 'caret-down', 'caret-left', 'caret-right', 'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up', 'caret-up', 'certificate', 'chain', 'chain-broken', 'check', 'check-circle', 'check-circle-o', 'check-square', 'check-square-o', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'circle', 'circle-o', 'clipboard', 'clock-o', 'cloud', 'cloud-download', 'cloud-upload', 'cny', 'code', 'code-fork', 'coffee', 'cog', 'cogs', 'columns', 'comment', 'comment-o', 'comments', 'comments-o', 'compass', 'compress', 'copy', 'credit-card', 'crop', 'crosshairs', 'css3', 'cut', 'cutlery', 'dashboard', 'dedent', 'desktop', 'dollar', 'dot-circle-o', 'download', 'dribbble', 'dropbox', 'edit', 'eject', 'ellipsis-h', 'ellipsis-v', 'envelope', 'envelope-o', 'eraser', 'eur', 'euro', 'exchange', 'exclamation', 'exclamation-circle', 'exclamation-triangle', 'expand', 'external-link', 'external-link-square', 'eye', 'eye-slash', 'facebook', 'facebook-square', 'fast-backward', 'fast-forward', 'female', 'fighter-jet', 'file', 'file-o', 'file-text', 'file-text-o', 'files-o', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash', 'flask', 'flickr', 'floppy-o', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'font', 'forward', 'foursquare', 'frown-o', 'gamepad', 'gavel', 'gbp', 'gear', 'gears', 'gift', 'github', 'github-alt', 'github-square', 'gittip', 'glass', 'globe', 'google-plus', 'google-plus-square', 'group', 'h-square', 'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hdd-o', 'headphones', 'heart', 'heart-o', 'home', 'hospital-o', 'html5', 'inbox', 'indent', 'info', 'info-circle', 'inr', 'instagram', 'italic', 'jpy', 'key', 'keyboard-o', 'krw', 'laptop', 'leaf', 'legal', 'lemon-o', 'level-down', 'level-up', 'lightbulb-o', 'link', 'linkedin', 'linkedin-square', 'linux', 'list', 'list-alt', 'list-ol', 'list-ul', 'location-arrow', 'lock', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'magic', 'magnet', 'mail-forward', 'mail-reply', 'mail-reply-all', 'male', 'map-marker', 'maxcdn', 'medkit', 'meh-o', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square', 'minus-square-o', 'mobile', 'mobile-phone', 'money', 'moon-o', 'music', 'none', 'outdent', 'pagelines', 'paperclip', 'paste', 'pause', 'pencil', 'pencil-square', 'pencil-square-o', 'phone', 'phone-square', 'picture-o', 'pinterest', 'pinterest-square', 'plane', 'play', 'play-circle', 'play-circle-o', 'plus', 'plus-circle', 'plus-square', 'plus-square-o', 'power-off', 'print', 'puzzle-piece', 'qrcode', 'question', 'question-circle', 'quote-left', 'quote-right', 'random', 'refresh', 'renren', 'repeat', 'reply', 'reply-all', 'retweet', 'rmb', 'road', 'rocket', 'rotate-left', 'rotate-right', 'rouble', 'rss', 'rss-square', 'rub', 'ruble', 'rupee', 'save', 'scissors', 'search', 'search-minus', 'search-plus', 'share', 'share-square', 'share-square-o', 'shield', 'shopping-cart', 'sign-in', 'sign-out', 'signal', 'sitemap', 'skype', 'smile-o', 'sort', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc', 'sort-numeric-desc', 'sort-up', 'spinner', 'square', 'square-o', 'stack-exchange', 'stack-overflow', 'star', 'star-half', 'star-half-empty', 'star-half-full', 'star-half-o', 'star-o', 'step-backward', 'step-forward', 'stethoscope', 'stop', 'strikethrough', 'subscript', 'suitcase', 'sun-o', 'superscript', 'table', 'tablet', 'tachometer', 'tag', 'tags', 'tasks', 'terminal', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up', 'ticket', 'times', 'times-circle', 'times-circle-o', 'tint', 'toggle-down', 'toggle-left', 'toggle-right', 'toggle-up', 'trash-o', 'trello', 'trophy', 'truck', 'try', 'tumblr', 'tumblr-square', 'turkish-lira', 'twitter', 'twitter-square', 'umbrella', 'underline', 'undo', 'unlink', 'unlock', 'unlock-alt', 'unsorted', 'upload', 'usd', 'user', 'user-md', 'users', 'video-camera', 'vimeo-square', 'vk', 'volume-down', 'volume-off', 'volume-up', 'warning', 'weibo', 'wheelchair', 'windows', 'won', 'wrench', 'xing', 'xing-square', 'youtube', 'youtube-play', 'youtube-square', 'angellist', 'area-chart', 'at', 'bell-slash', 'bell-slash-o', 'bicycle', 'binoculars', 'birthday-cake', 'bus', 'calculator', 'cc', 'cc-amex', 'cc-discover', 'cc-mastercard', 'cc-paypal', 'cc-stripe', 'cc-visa', 'copyright', 'eyedropper', 'futbol-o', 'google-wallet', 'ils', 'ioxhost', 'lastfm', 'lastfm-square', 'line-chart', 'meanpath', 'newspaper-o', 'paint-brush', 'paypal', 'pie-chart', 'plug', 'ils', 'slideshare', 'futbol-o', 'toggle-off', 'toggle-on', 'trash', 'tty', 'twitch', 'wifi', 'yelp', 'spotify');

				echo '<input type="hidden" name="name" value="fa fa-'.$value.'" id="name" />';
				echo '<div class="ss-icon-preview"><i class=" fa fa-'.$value.'"></i></div>';
				echo '<input class="ss-search" type="text" placeholder="Search icon" />';
				echo '<div id="ss-icon-dropdown">';
				echo '<ul class="ss-icon-list">';
				$n = 1;
				foreach($icons as $icon){
					$selected = ($icon == $value) ? 'class="selected"' : '';
					$id = 'icon-'.$n;
					echo '<li '.$selected.' data-icon="'.$icon.'"><i class="icon fa fa-'.$icon.'"></i><label class="icon">'.$icon.'</label></li>';
					$n++;
				}
				echo '</ul>';
				echo '</div>';
    		?>
		</div>
		<div class="inputs">
			<label for="size"><?php _e('Size', $shortname); ?></label>
			<select name="size" id="size">
				<option value="icon-1"><?php _e('1x', $shortname); ?></option>
				<option value="icon-2"><?php _e('2x', $shortname); ?></option>
				<option value="icon-3"><?php _e('3x', $shortname); ?></option>
				<option value="icon-4"><?php _e('4x', $shortname); ?></option>
				<option value="icon-5"><?php _e('5x', $shortname); ?></option>
				<option value="icon-6"><?php _e('6x', $shortname); ?></option>
			</select>
			<span class="help">&nbsp;</span>
		</div>
		<div class="inputs">
			<label for="icon_type"><?php _e('Type', $shortname); ?></label>
			<select name="icon_type" id="icon_type">
				<option value="normal"><?php _e('Normal', $shortname); ?></option>
				<option value="circle"><?php _e('Circle', $shortname); ?></option>
				<option value="square"><?php _e('Square', $shortname); ?></option>
			</select>
			<span class="help">&nbsp;</span>
		</div>
		<div class="inputs">
			<label for="icon_color"><?php _e('Color', $shortname); ?>:</label>
			<input id="icon_color" name="icon_color" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default is: #444444', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="icon_bg_color"><?php _e('Background', $shortname); ?>:</label>
			<input id="icon_bg_color" name="icon_bg_color" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Leave empty for transparent background.', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="icon_border_color"><?php _e('Border color', $shortname); ?>:</label>
			<input id="icon_border_color" name="icon_border_color" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Leave empty for transparent borders', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="align"><?php _e('Align', $shortname); ?></label>
			<select name="align" id="align">
				<option value="ss-none"><?php _e('none', $shortname); ?></option>
				<option value="ss-left"><?php _e('left', $shortname); ?></option>
				<option value="ss-center"><?php _e('center', $shortname); ?></option>
				<option value="ss-right"><?php _e('right', $shortname); ?></option>
			</select>
			<span class="help">&nbsp;</span>
		</div>
		<div class="inputs">
			<label for="icon_spin"><?php _e('Spin?', $shortname); ?></label>
			<select name="icon_spin" id="icon_spin">
				<option value="no"><?php _e('No', $shortname); ?></option>
				<option value="yes"><?php _e('Yes', $shortname); ?></option>
			</select>
			<span class="help"><?php _e('If yes, icon will rotate clockwise.', $shortname); ?></span>
		</div>
	</div>


<?php } ?>

	</form><!-- #shortcodes -->
</div><!-- #options -->

<div class="clear"></div>
<div class="previewHolder">
	<?php 
		$shortcode = trim( $_GET['preview'] ); 
		if(isset($_GET['preview']) && $_GET['preview']!= 'remove'){ 
	?>
		<div class="alignleft">
			<h3><?php _e('Preview', $shortname); ?></h3>
			<span class="help"><?php _e('Please click on Preview button each time you make changes in above section.', $shortname); ?></span>
		</div>
		<div class="alignright">
			<input type="button" accesskey="I" value="<?php _e('Insert', $shortname); ?>" name="insert" class="button-primary" id="insert">
		</div>
		<?php if(isset($_GET['preview']) && $_GET['preview']!= 'remove'){ ?>
			<div class="alignright">
				<input type="button" accesskey="P" value="<?php _e('Preview', $shortname); ?>" name="preview" class="button-primary" id="preview">
			</div>
		<?php } ?>
		<div class="clear"></div>
		<hr>
		<br>
		<div id="previewDiv"><?php echo do_shortcode( $shortcode )?></div>
</div><!-- .previewHolder -->

<?php } ?>
<div class="clear"></div>
