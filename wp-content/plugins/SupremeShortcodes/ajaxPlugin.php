<?php 
	require('../../../wp-blog-header.php');

	if (!is_user_logged_in()){
		die("You are not logged in! Please log in to use Supreme Shortcodes plugin!");
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

		$("#ss-icon-dropdown.melon-dropdown li").click(function() {
			$(this).attr("class","selected").siblings().removeAttr("class");
			var icon = $(this).attr("data-icon");
			$("#name").val(icon);
			$(".ss-icon-preview.icon_melon").html("<div class=\"iconmelon icon\"><svg viewBox=\"0 0 32 32\"><use xlink:href=\"#"+icon+"\"></use></svg></div>");
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
		<input type="text" id="link1" name="link" />
		<span class="help"><?php _e('Button link (Example: http://www.supremefactory.net)', $shortname); ?>.</span>
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



<?php } elseif($act == 'insertHoverFillButton') { ?>
	<h3><?php _e('Insert button with hover effect shortcode', $shortname); ?></h3>
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
		<input type="text" id="link2" name="link" />
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
		<input type="text" size="4" id="bg" name="bg" value="#ffffff" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Background color.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="hover_bg"><?php _e('Hover Background Color', $shortname); ?></label>
		<input type="text" size="4" id="hover_bg" name="hover_bg" value="#247de3" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Background color when button is hovered.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="size"><?php _e('Size', $shortname); ?></label>
		<select name="size" id="size">
			<option value="small"><?php _e('Small', $shortname); ?></option>
			<option value="normal"><?php _e('Normal', $shortname); ?></option>
			<option value="large"><?php _e('Large', $shortname); ?></option>
			<option value="jumbo"><?php _e('Jumbo', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="hover_direction"><?php _e('Hover Direction', $shortname); ?></label>
		<select name="hover_direction" id="hover_direction">
			<option value="ss-fade-in"><?php _e('Simple Fade In', $shortname); ?></option>
			<option value="ss-top-to-bottom"><?php _e('Top to bottom', $shortname); ?></option>
			<option value="ss-left-to-right"><?php _e('Left to right', $shortname); ?></option>
			<option value="ss-expand-h"><?php _e('Center expand horizontal', $shortname); ?></option>
			<option value="ss-expand-v"><?php _e('Center expand vertical', $shortname); ?></option>
			<option value="ss-expand-c"><?php _e('Center expand to corners', $shortname); ?></option>
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
	


<?php } elseif($act == 'insertHoverFancyIconButton') { ?>
	<h3><?php _e('Insert button with hover effect shortcode', $shortname); ?></h3>
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
		<input type="text" id="link3" name="link" />
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
			<option value="normal"><?php _e('Normal', $shortname); ?></option>
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
	<br>
	<div class="inputs">
		<label for="icon_spin"><?php _e('Spin?', $shortname); ?></label>
		<select name="icon_spin" id="icon_spin">
			<option value="no"><?php _e('No', $shortname); ?></option>
			<option value="yes"><?php _e('Yes', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('If yes, icon will rotate clockwise.', $shortname); ?></span>
	</div>
	<br>
	<div class="inputs">
		<label for="icon_color"><?php _e('Icon Color', $shortname); ?></label>
		<input type="text" size="4" id="icon_color" name="icon_color" value="#ffffff" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Color for icon. Default: #ffffff - white', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="icon_bg"><?php _e('Icon Background Color', $shortname); ?></label>
		<input type="text" size="4" id="icon_bg" name="icon_bg" value="#333333" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Background color for icon. Default: #333333', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="icon_pos"><?php _e('Icon Position', $shortname); ?></label>
		<select name="icon_pos" id="icon_pos">
			<option value="ss-icon-left"><?php _e('Left', $shortname); ?></option>
			<option value="ss-icon-right"><?php _e('Right', $shortname); ?></option>
			<option value="ss-icon-top"><?php _e('Top', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="icon_sep"><?php _e('Separator', $shortname); ?></label>
		<select name="icon_sep" id="icon_sep">
			<option value="ss-sep-none"><?php _e('None', $shortname); ?></option>
			<option value="ss-sep-transparent"><?php _e('Transparent', $shortname); ?></option>
			<option value="ss-sep-arrow"><?php _e('Arrow', $shortname); ?></option>
			<option value="ss-sep-diagonal"><?php _e('Diagonal', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('This does not apply for Icon Position: Top', $shortname); ?></span>
	</div>
	


<?php } elseif($act == 'insertHoverArrowsButton') { ?>
	<h3><?php _e('Insert button with hover effect shortcode', $shortname); ?></h3>
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
		<input type="text" id="link4" name="link" />
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
		<span class="help"><?php _e('Leave empty for transparent effect.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="size"><?php _e('Size', $shortname); ?></label>
		<select name="size" id="size">
			<option value="small"><?php _e('Small', $shortname); ?></option>
			<option value="normal"><?php _e('Normal', $shortname); ?></option>
			<option value="large"><?php _e('Large', $shortname); ?></option>
			<option value="jumbo"><?php _e('Jumbo', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
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
	<br>
	<div class="inputs">
		<label for="icon_spin"><?php _e('Spin?', $shortname); ?></label>
		<select name="icon_spin" id="icon_spin">
			<option value="no"><?php _e('No', $shortname); ?></option>
			<option value="yes"><?php _e('Yes', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('If yes, icon will rotate clockwise.', $shortname); ?></span>
	</div>
	<br>
	<div class="inputs">
		<label for="border_radius"><?php _e('Border Radius', $shortname); ?></label>
		<input type="text" id="border_radius" name="border_radius" />
		<span class="help"><?php _e('Example: 4px. The greater number of pixels, more roundness to the button.', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="arrow_direction"><?php _e('Arrow direction', $shortname); ?></label>
		<select name="arrow_direction" id="arrow_direction">
			<option value="fly-in-right"><?php _e('Fly in - right', $shortname); ?></option>
			<option value="fly-in-left"><?php _e('Fly in - left', $shortname); ?></option>
			<option value="fly-out-right"><?php _e('Fly out - right', $shortname); ?></option>
			<option value="fly-out-left"><?php _e('Fly out - left', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>



<?php } elseif($act == 'insertHoverIconOnHoverButton') { ?>
	<h3><?php _e('Insert button with hover effect shortcode', $shortname); ?></h3>
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
		<input type="text" id="link5" name="link" />
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
			<option value="normal"><?php _e('Normal', $shortname); ?></option>
			<option value="large"><?php _e('Large', $shortname); ?></option>
			<option value="jumbo"><?php _e('Jumbo', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
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
	<br>
	<div class="inputs">
		<label for="icon_spin"><?php _e('Spin?', $shortname); ?></label>
		<select name="icon_spin" id="icon_spin">
			<option value="no"><?php _e('No', $shortname); ?></option>
			<option value="yes"><?php _e('Yes', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('If yes, icon will rotate clockwise.', $shortname); ?></span>
	</div>
	<br>
	<div class="inputs">
		<label for="border_radius"><?php _e('Border Radius', $shortname); ?></label>
		<input type="text" id="border_radius" name="border_radius" />
		<span class="help"><?php _e('Example: 4px. The greater number of pixels, more roundness to the button.', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="icon_direction"><?php _e('Icon direction', $shortname); ?></label>
		<select name="icon_direction" id="icon_direction">
			<option value="top-to-bottom"><?php _e('Top to bottom', $shortname); ?></option>
			<option value="left-to-right"><?php _e('Left to right', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>




<?php } elseif($act == 'insertHoverBorderedButton') { ?>
	<h3><?php _e('Insert button with hover effect shortcode', $shortname); ?></h3>
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
		<input type="text" id="link6" name="link" />
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
			<option value="normal"><?php _e('Normal', $shortname); ?></option>
			<option value="large"><?php _e('Large', $shortname); ?></option>
			<option value="jumbo"><?php _e('Jumbo', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="border_type"><?php _e('Border Type', $shortname); ?></label>
		<select name="border_type" id="border_type">
			<option value="ss-thick"><?php _e('Thick', $shortname); ?></option>
			<option value="ss-dashed"><?php _e('Dashed', $shortname); ?></option>
			<option value="ss-dotted"><?php _e('Dotted', $shortname); ?></option>
			<option value="ss-double"><?php _e('Double', $shortname); ?></option>
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
	

<?php } elseif($act == 'dividerText') { ?>
	<h3><?php _e('Insert divider with text shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs req">
		<label for="text"><?php _e('Text', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="text" name="text" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="divider_type"><?php _e('Position', $shortname); ?></label>
		<select name="divider_type" id="divider_type">
			<option value="left"><?php _e('Left', $shortname); ?></option>
			<option value="center"><?php _e('Center', $shortname); ?></option>
			<option value="right"><?php _e('Right', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>



<?php } elseif($act == 'insertCallout') { ?>
	<h3><?php _e('Insert callout shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="callout_title"><?php _e('Title', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="callout_title" name="callout_title" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs req">
		<label for="text"><?php _e('Text', $shortname); ?> <span style="color:red;">*</span></label>
		<textarea name="text" id="text"></textarea>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="btn_text"><?php _e('Button text', $shortname); ?></label>
		<input type="text" id="btn_text" name="btn_text" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="btn_link"><?php _e('Button link', $shortname); ?></label>
		<input type="text" id="btn_link" name="btn_link" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="color"><?php _e('Text Color', $shortname); ?></label>
		<input type="text" size="4" id="color" name="color" value="#444444" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Color of text (Optional, default: #444444)', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="bg"><?php _e('Background Color', $shortname); ?></label>
		<input type="text" size="4" id="bg" name="bg" value="#fafafa" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Background color (Optional, default: #fafafa)', $shortname); ?></span>
	</div>



<?php } elseif($act == 'insertTooltip') { ?>
	<h3><?php _e('Insert tooltip shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label><?php _e('Position', $shortname); ?></label>
		<select id="tooltip_type">
			<option value="top"><?php _e('Top', $shortname); ?></option>
			<option value="right"><?php _e('Right', $shortname); ?></option>
			<option value="bottom"><?php _e('Bottom', $shortname); ?></option>
			<option value="left"><?php _e('Left', $shortname); ?></option>
		</select>
	</div>
	<div class="inputs req">
		<label for="text"><?php _e('Text', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="text" name="text" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="tooltip_text"><?php _e('Tooltip text', $shortname); ?></label>
		<input type="text" id="tooltip_text" name="tooltip_text" />
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'insertPopover') { ?>
	<h3><?php _e('Insert popover shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label><?php _e('Position', $shortname); ?></label>
		<select id="popover_type">
			<option value="top"><?php _e('Top', $shortname); ?></option>
			<option value="right"><?php _e('Right', $shortname); ?></option>
			<option value="bottom"><?php _e('Bottom', $shortname); ?></option>
			<option value="left"><?php _e('Left', $shortname); ?></option>
		</select>
	</div>
	<div class="inputs req">
		<label for="popover_title"><?php _e('Title', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="popover_title" name="popover_title" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="popover_text"><?php _e('Popover text', $shortname); ?></label>
		<textarea name="popover_text" id="popover_text"></textarea>
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'insertModal') { ?>
	<h3><?php _e('Insert modal shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="modal_link"><?php _e('Modal button title', $shortname); ?>: </label>
		<input type="text" id="modal_link" name="modal_link" />
		<span class="help"><?php _e('Example: Launch this modal', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="modal_title"><?php _e('Modal title', $shortname); ?>: </label>
		<input type="text" id="modal_title" name="modal_title" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="modal_text"><?php _e('Modal content', $shortname); ?></label>
		<textarea name="modal_text" id="modal_text"></textarea>
		<span class="help"><?php _e('HTML tags allowed!', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="primary"><?php _e('Primary button text', $shortname); ?>: </label>
		<input type="text" id="primary" name="primary" />
		<span class="help"><?php _e('Optional.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="primary_link"><?php _e('Primary button Link', $shortname); ?>: </label>
		<input type="text" id="primary_link" name="primary_link" />
		<span class="help"><?php _e('Button link (Optional, e.g. http://www.supremefactory.net)', $shortname); ?>.</span>
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


<?php } elseif($act == 'createAccordion') { ?>
	<script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery('#ss-accs').keyup(function() {
            	var ssAccs = ''; 
                if($('#ss-accs').val() != '') {
                        for(var i=0; i<$('#ss-accs').val(); i++) {
                        	var titleVal = (jQuery("#title_" + i).val() != undefined) ? jQuery("#title_" + i).val() : '';
                        	var textVal = (jQuery("#text_" + i).val() != undefined) ? jQuery("#text_" + i).val() : '';
                        	var stateVal = (jQuery("#state_" + i).val() != undefined) ? jQuery("#state_" + i).val() : '';
                                ssAccs += '<div class="box">Panel #'+(i+1)+'<br/><div class="inputs"><label for="title_'+i+'">Title:</label><input type="text" id="title_'+i+'" name="title_'+i+'" value="'+titleVal+'"></div><div class="inputs"><label for="content_'+i+'">Content:</label><textarea id="text_'+i+'" name="text_'+i+'">'+textVal+'</textarea></div><div class="inputs"><label for="state">State:</label><select name="state_'+i+'" id="state_'+i+'"><option value="closed">closed</option><option value="open">open</option></select></div><div class="clear"></div></div>' + "\n";
                        }
                        $('.ss-accHolder').empty().append(ssAccs);
                }
                return false;
            });
        });
	</script>
	<h3><?php _e('Create accordion shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
        <label for="ss-accs"><?php _e('Number of Panels', $shortname); ?></label>
        <input type="text" class="small" id="ss-accs" name="ss-accs" />
	</div>
	<div class="clear"></div>
	<div class="ss-accHolder"></div>


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


<?php } elseif($act == 'section_image') { ?>
	<h3><?php _e('Create Image Section', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label class="control-label" for="imageid"><?php _e('Image ID:', $shortname); ?></label>
		<div class="alignleft">
			<input type="text" id="imageid" name="imageid" size="18" />
		</div>
		<div class="alignleft">
			<input type="submit" class="upload_image_button btn button" data-uploader_title="Select Image" data-uploader_button_text="Select" value="<?php _e( "Select Image", $shortname ); ?>" />
		</div>
	</div>
	<br><br>
	<div class="clear"></div>
	<div class="inputs">
		<label for="section_image_type"><?php _e('Image type', $shortname); ?></label>
		<select name="section_image_type" id="section_image_type" class="type">
			<option value="parallax"><?php _e('Parallax', $shortname); ?></option>
			<option value="fixed"><?php _e('Fixed', $shortname); ?></option>
			<option value="scroll"><?php _e('Scroll', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('Note: Parallax type will cover the section background with the entire image and display with parallax effect.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="repeat"><?php _e('Image repeat', $shortname); ?></label>
		<select name="repeat" id="repeat" class="repeat">
			<option value="repeat"><?php _e('Repeat', $shortname); ?></option>
			<option value="no-repeat"><?php _e('No Repeat', $shortname); ?></option>
			<option value="repeat-x"><?php _e('Repeat Horizontaly', $shortname); ?></option>
			<option value="repeat-y"><?php _e('Repeat Vertically', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('Note: Doesn\'t apply on parallax type.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="bg_position"><?php _e('Image position', $shortname); ?></label>
		<select name="bg_position" id="bg_position" class="bg_position">
			<option value="left top"><?php _e('left top', $shortname); ?></option>
			<option value="left center"><?php _e('left center', $shortname); ?></option>
			<option value="left bottom"><?php _e('left bottom', $shortname); ?></option>
			<option value="right top"><?php _e('right top', $shortname); ?></option>
			<option value="right center"><?php _e('right center', $shortname); ?></option>
			<option value="right bottom"><?php _e('right bottom', $shortname); ?></option>
			<option value="center top"><?php _e('center top', $shortname); ?></option>
			<option value="center center"><?php _e('center center', $shortname); ?></option>
			<option value="center bottom"><?php _e('center bottom', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('Note: Doesn\'t apply on parallax type.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="bg_size"><?php _e('Background size', $shortname); ?></label>
		<select name="bg_size" id="bg_size" class="bg_size">
			<option value="cover"><?php _e('cover', $shortname); ?></option>
			<option value="initial"><?php _e('initial', $shortname); ?></option>
		</select>
		<span class="help"><?php _e('Note: It applies only on parallax type.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="bg_color"><?php _e('Background Color', $shortname); ?></label>
		<input type="text" size="4" id="bg_color" name="bg_color" value="#ffffff" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Optional.', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="img_padding"><?php _e('Inner padding', $shortname); ?></label>
		<input type="text" id="img_padding" name="img_padding" class="small" />
		<span class="help"><?php _e('Choose padding in pixels or precents. Example: 20px', $shortname); ?></span>
	</div>



<?php } elseif($act == 'section_color') { ?>
	<h3><?php _e('Create Color Section', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="color"><?php _e('Background Color', $shortname); ?></label>
		<input type="text" size="4" id="color" name="color" value="#ffffff" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Background color (Optional, default: #ffffff)', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="col_padding"><?php _e('Inner padding', $shortname); ?></label>
		<input type="text" id="col_padding" name="col_padding" class="small" />
		<span class="help"><?php _e('Choose padding in pixels or precents. Example: 20px', $shortname); ?></span>
	</div>
	<div class="clear"></div>


<?php } elseif($act == 'text_color') { ?>
	<h3><?php _e('Create Colored Text', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="color"><?php _e('Color', $shortname); ?></label>
		<input type="text" size="4" id="color" name="color" value="#ffffff" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Color (Optional, default: #444444)', $shortname); ?></span>
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


<?php } elseif($act == 'social_icon') { ?>
	<h3><?php _e('Insert Social icon shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="name"><?php _e('Choose', $shortname); ?></label>
		<select name="name" id="name">
			<option value="social_facebook"><?php _e('Facebook', $shortname); ?></option>
			<option value="social_twitter"><?php _e('Twitter', $shortname); ?></option>
			<option value="social_google"><?php _e('Google+', $shortname); ?></option>
			<option value="social_youtube"><?php _e('YouTube', $shortname); ?></option>
			<option value="social_pinterest"><?php _e('Pinterest', $shortname); ?></option>
			<option value="social_linkedin"><?php _e('LinkedIn', $shortname); ?></option>
			<option value="social_blogger"><?php _e('Blogger', $shortname); ?></option>
			<option value="social_flickr"><?php _e('Flickr', $shortname); ?></option>
			<option value="social_lastfm"><?php _e('LastFM', $shortname); ?></option>
			<option value="social_myspace"><?php _e('Myspace', $shortname); ?></option>
			<option value="social_reddit"><?php _e('Reddit', $shortname); ?></option>
			<option value="social_vimeo"><?php _e('Vimeo', $shortname); ?></option>
			<option value="social_instagram"><?php _e('Instagram', $shortname); ?></option>
			<option value="social_dribble"><?php _e('Dribble', $shortname); ?></option>
			<option value="social_rss"><?php _e('RSS', $shortname); ?></option>
			<option value="social_dropbox"><?php _e('Dropbox', $shortname); ?></option>
			<option value="social_yahoo"><?php _e('Yahoo', $shortname); ?></option>
			<option value="social_picasa"><?php _e('Picasa', $shortname); ?></option>
			<option value="social_behance"><?php _e('Behance', $shortname); ?></option>
			<option value="social_skype"><?php _e('Skype', $shortname); ?></option>
			<option value="social_soundcloud"><?php _e('Soundcloud', $shortname); ?></option>
			<option value="social_gshark"><?php _e('Groove Shark', $shortname); ?></option>
			<option value="social_digg"><?php _e('Digg', $shortname); ?></option>
			<option value="social_tumblr"><?php _e('Tumblr', $shortname); ?></option>
			<option value="social_applestore"><?php _e('Apple Store', $shortname); ?></option>
			<option value="social_dart"><?php _e('Deviant Art', $shortname); ?></option>
			<option value="social_stumble"><?php _e('Stumble Upon', $shortname); ?></option>
			<option value="social_wp"><?php _e('WordPress', $shortname); ?></option>
			<option value="social_wiki"><?php _e('Wikipedia', $shortname); ?></option>
			<option value="social_github"><?php _e('Github', $shortname); ?></option>
			<option value="social_android"><?php _e('Android', $shortname); ?></option>
			<option value="social_mixcloud"><?php _e('Mixcloud', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="href"><?php _e('URL', $shortname); ?></label>
		<input type="text" id="href" name="href" />
		<span class="help"><?php _e('Url)', $shortname); ?></span>
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
		<label for="align"><?php _e('Align', $shortname); ?></label>
		<select name="align" id="align">
			<option value="ss-none"><?php _e('none', $shortname); ?></option>
			<option value="ss-left"><?php _e('left', $shortname); ?></option>
			<option value="ss-center"><?php _e('center', $shortname); ?></option>
			<option value="ss-right"><?php _e('right', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'shorturl') { ?>
	<h3><?php _e('Insert shorteren url shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="s_title"><?php _e('Link title', $shortname); ?></label>
		<input type="text" id="s_title" name="s_title" />
		<span class="help">&nbsp;</span>
	</div>
	<div class="inputs">
		<label for="url"><?php _e('Full url', $shortname); ?></label>
		<input type="text" id="url" name="url" />
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'logInOut') { ?>
	<h3><?php _e('Insert login/out button shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs req">
		<label for="login_msg"><?php _e('Log in text', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="login_msg" name="login_msg" />
		<span class="help"><?php _e('Link title when visitor is not logged in', $shortname); ?>.</span>
	</div>
	<div class="inputs req">
		<label for="logout_msg"><?php _e('Log out text', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="logout_msg" name="logout_msg" />
		<span class="help"><?php _e('Link title when visitor is logged in', $shortname); ?>.</span>
	</div>
	<div class="inputs">
		<label for="color"><?php _e('Text Color', $shortname); ?></label>
		<input type="text" size="4" id="color" name="color" value="#ffffff" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Color of text (Optional, default: #ffffff)', $shortname); ?></span>
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
	

<?php } elseif($act == 'quote') { ?>
	<h3><?php _e('Insert quoted text shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="author"><?php _e('Author', $shortname); ?></label>
		<input type="text" name="author-name" id="author-name"/>
		<span class="help">&nbsp;</span>
	</div> 
	<div class="inputs req">
		<label for="text"><?php _e('Text', $shortname); ?> <span style="color:red;">*</span></label>
		<textarea name="text" id="text"></textarea>
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'abbreviation') { ?>
	<h3><?php _e('Insert abbreviation shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs req">
		<label for="text"><?php _e('Text', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="text" name="text" />
		<span class="help"><?php _e('The full, unabbreviated, text', $shortname); ?>.</span>
	</div>
	<div class="inputs req">
		<label for="abbreviation"><?php _e('Abbreviation', $shortname); ?> <span style="color:red;">*</span></label>
		<input type="text" id="abbreviation" name="abbreviation" />
		<span class="help"><?php _e('The abbreviated text', $shortname); ?>.</span>
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
		<input type="text" id="linkfb" name="link" />
		<span class="help"><?php _e('Optionally place the URL you want viewers to "Like" here.<br />Defaults to the page/post URL', $shortname); ?>.</span>
	</div>


<?php } elseif($act == 'lishare') { ?>
	<h3><?php _e('Insert linked in share button shortcode', $shortname); ?></h3>
	<hr />
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="link"><?php _e('Url', $shortname); ?></label>
			<input type="text" id="linkli" name="link" />
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


	

<?php } elseif($act == 'pricingTable') { ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var option = '';
			$("#columns").bind('change', function() {
				var maximum = $(this).val();
				for(i=0;i<=maximum;i++) {
					option += '<option value="'+i+'">'+i+'</option>' + "\n";
				}
				$("#highlighted").empty().html(option);
			});
		});
	</script>
	<h3><?php _e('Pricing table shortcode', $shortname); ?></h3>
	<hr />
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="columns"><?php _e('Columns', $shortname); ?></label>
			<select name="columns" id="columns">
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
			</select>
			<span class="help"><?php _e('How manu columns your pricing table should have', $shortname); ?>.</span>
		</div>
		<div class="inputs">
			<label for="highlighted"><?php _e('Style', $shortname); ?></label>
			<select name="highlighted" id="highlighted">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
			</select>
			<span class="help"><?php _e('Which column should be highlighted', $shortname); ?>.</span>
		</div>
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



<?php } elseif($act == 'gdocs')  { ?>
	<h3><?php _e('Google Docs shortcode', $shortname); ?></h3>
	<hr />
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="width"><?php _e('Width', $shortname); ?>:</label>
			<input id="width" name="width" type="text" />
			<span class="help"><?php _e('(Optional)', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="height"><?php _e('Height', $shortname); ?>:</label>
			<input id="height" name="height" type="text" />
			<span class="help"><?php _e('(Optional)', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="url"><?php _e('Url', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="url" name="url" type="text" />
			<span class="help">&nbsp;</span>
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
		<!-- <div class="inputs">
			<label for="exclude"><?php //_e('Exclude Posts/Pages', $shortname); ?>: </label>
			<input id="exclude" name="exclude" type="text" />
			<span class="help"><?php //_e('Coma separated Page or Post ID you wish to exclude (4,5,723)', $shortname); ?></span>
		</div> -->
	</div>
	


<?php } elseif($act == 'contact_form_dark') { ?>
	<h43><?php _e('Contact form shortcode', $shortname); ?></h3>
	<hr />
	<div class="transHalf noBorder">
		<div class="inputs req">
			<label for="email_d"><?php _e('Email', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="email_d" name="email_d" type="text" />
			<span class="help"><?php _e('Email where submitted form will go to', $shortname); ?></span>
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


<?php } elseif($act == 'fancyboxImages') { ?>
	<h4><?php _e('Fancybox single image and image gallery shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="title_lb"><?php _e('Title', $shortname); ?>: </label>
			<input id="title_lb" name="title_lb" type="text" />
			<span class="help"><?php _e('link title', $shortname); ?></span>
		</div>
		<div class="inputs req">
			<label class="control-label" for="href"><?php _e('Image URL:', $shortname); ?></label>
			<input type="text" id="href" name="href" size="18" class="imageField alignleft" />
			<input type="submit" class="upload_image_button btn button alignleft" data-uploader_title="Select Image" data-uploader_button_text="Select" value="<?php _e( "Select Image", $shortname ); ?>" />
		</div>
		<div class="inputs">
			<label class="control-label" for="thumb"><?php _e('Thumbnail URL:', $shortname); ?></label>
			<input type="text" id="thumb" name="thumb" size="18" class="imageField alignleft" />
			<input type="submit" class="upload_image_button btn button alignleft" data-uploader_title="Select Thumbnail" data-uploader_button_text="Select" value="<?php _e( "Select Thumbnail", $shortname ); ?>" />
		</div>
		<div class="inputs">
			<label for="thumb_width"><?php _e('Thumbnail width', $shortname); ?>:</label>
			<input id="thumb_width" name="thumb_width" type="text" />
			<span class="help"><?php _e('Example: 200 (Default 150. Value is in pixels)', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="group"><?php _e('Group', $shortname); ?>:</label>
			<input id="group" name="group" type="text" />
			<span class="help"><?php _e('Group fancybox as gallery', $shortname); ?></span>
		</div>
	</div>


<?php } elseif($act == 'fancyboxInline') { ?>
	<h4><?php _e('Fancybox Inline content shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="in_title"><?php _e('Title', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="in_title" name="in_title" type="text" />
			<span class="help"><?php _e('Link title', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="content_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="content_title" name="content_title" type="text" />
			<span class="help"><?php _e('Content title', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="in_content"><?php _e('Content', $shortname); ?>:</label>
			<textarea id="in_content" name="in_content"></textarea>
			<span class="help"><?php _e('Example: Write some text', $shortname); ?></span>
		</div>
	</div>


<?php } elseif($act == 'fancyboxIframe') { ?>
	<h4><?php _e('Fancybox Iframe shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="iframe_title"><?php _e('Title', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="iframe_title" name="iframe_title" type="text" />
			<span class="help"><?php _e('Link title', $shortname); ?></span>
		</div>
		<div class="inputs req">
			<label for="iframe_href"><?php _e('Link', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="iframe_href" name="iframe_href" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: http://www.supremefactory.net</span>
		</div>
	</div>		


<?php } elseif($act == 'fancyboxPage') { 
	$ipages = get_pages(array('sort_order' => 'ASC'));
?>
	<h4><?php _e('Choose an existing page from your website', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="ipage_title"><?php _e('Link title', $shortname); ?>:</label>
			<input type="text" name="ipage_title" id="ipage_title" />
		</div>
		<div class="inputs">
			<label for="ipage"><?php _e('Select a page', $shortname); ?>:</label>
			<select name="ipage" id="ipage">
				<?php foreach($ipages as $ipage): ?>
					<option value="<?php echo get_permalink($ipage->ID); ?>"><?php echo $ipage->post_title ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	</div>


<?php } elseif($act == 'fancyboxSwf') { ?>
	<h4><?php _e('Fancybox Flash video shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="swf_title"><?php _e('Title', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="swf_title" name="swf_title" type="text" />
			<span class="help"><?php _e('Link title', $shortname); ?></span>
		</div>
		<div class="inputs req">
			<label for="swf"><?php _e('Link', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="swf" name="swf" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf</span>
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
				<option value="html5"><?php _e('HTML5', $shortname); ?></option>
				<option value="flash"><?php _e('Flash', $shortname); ?></option>
				<option value="youtube"><?php _e('YouTube', $shortname); ?></option>
				<option value="vimeo"><?php _e('Vimeo', $shortname); ?></option>
				<option value="dailymotion"><?php _e('Dailymotion', $shortname); ?></option>
			</select>
		</div>
		
		<div class="youtube vimeo dailymotion video_type">
			<div class="inputs">
				<label for="clip_id"><?php _e('Clip id', $shortname); ?>:</label>
				<input class="widefat" id="clip_id" name="clip_id" type="text" value="" />
			</div>
		</div>
		
		<div class="flash video_type">
			<div class="inputs">
				<label for="src"><?php _e('Source', $shortname); ?>:</label>
				<input class="widefat" id="src" name="src" type="text" value="" />
			</div>
		</div>
		
		<div class="html5 video_type inputs">
			<div class="inputs">
				<label for="poster"><?php _e('Poster', $shortname); ?>:</label>
				<input class="widefat" id="poster" name="poster" type="text" value="" />
				<span class="help"><?php _e('Example: http://example.com/assets/image.jpg', $shortname); ?></span>
			</div>
			
			<div class="inputs">
				<label for="mp4 inputs"><?php _e('Mp4', $shortname); ?>:</label>
				<input class="widefat" id="mp4" name="mp4" type="text" value="" />
			</div>
			
			<div class="inputs">
				<label for="webm inputs"><?php _e('Webm', $shortname); ?>:</label>
				<input class="widefat" id="webm" name="webm" type="text" value="" />
			</div>
			
			<div class="inputs">
				<label for="ogg inputs"><?php _e('Ogg', $shortname); ?>:</label>
				<input class="widefat" id="ogg" name="ogg" type="text" value="" />
			</div>
		</div>
	</div>


<?php } elseif($act == 'audio') { ?>
	<h4><?php _e('Audio shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="audio_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="audio_title" name="audio_title" type="text" />
		</div>
		<div class="inputs">
			<label for="audio_src"><?php _e('Source', $shortname); ?>:</label>
			<input id="audio_src" name="audio_src" type="text" />
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



<?php } elseif($act == 'posts_carousel') { ?>
	<h4><?php _e('Post types carousel shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="posts"><?php _e('Choose posts', $shortname); ?>:</label>
			<select id="posts" name="posts">
				<?php 
					$args = array(
					   'public'   => true,
					   '_builtin' => false
					);
					$post_types = get_post_types( $args, 'names' ); 

					echo '<option value="post">post</option>';
					echo '<option value="page">page</option>';
					foreach ( $post_types as $post_type ) {
							echo '<option value="'.$post_type.'">' . $post_type . '</option>';
						}
				?>
			</select>
		</div>
		<div class="inputs">
			<label for="number"><?php _e('Number', $shortname); ?>:</label>
			<input id="number" name="number" type="text" />
			<span class="help">Default: 5</span>
		</div>
		<div class="inputs">
			<label for="cat"><?php _e('Catogory ID\'s', $shortname); ?>:</label>
			<input id="cat" name="cat" type="text" />
			<span class="help"><?php _e('To exclude a certain category, put minus(-) before the category ID(number). Separate them with coma(,)', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="display_title"><?php _e('Show title', $shortname); ?>:</label>
			<select id="display_title" name="display_title">
				<option value="yes"><?php _e('yes', $shortname); ?></option>
				<option value="no"><?php _e('no', $shortname); ?></option>
			</select>
		</div>
	</div>



<?php } elseif($act == 'swiper') { ?>
	<h3><?php _e('Swiper Carousel shortcode', $shortname); ?></h3>
	<hr>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="swiper_posts"><?php _e('Choose posts', $shortname); ?>:</label>
			<select id="swiper_posts" name="swiper_posts">
				<?php 
					$args = array(
					   'public'   => true,
					   '_builtin' => false,
					   'query_var' => true
					);
					$post_types = get_post_types( $args, 'names' ); 

					echo '<option value="post">post</option>';
					echo '<option value="page">page</option>';
					foreach ( $post_types as $post_type ) {
							echo '<option value="'.$post_type.'">' . $post_type . '</option>';
						}
				?>
			</select>
		</div>
		<div class="inputs">
			<label for="swiper_number"><?php _e('Number', $shortname); ?>:</label>
			<input id="swiper_number" name="swiper_number" type="text" />
			<span class="help"><?php _e('Default: All', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="category"><?php _e('Catogory ID\'s', $shortname); ?>:</label>
			<input id="category" name="category" type="text" />
			<span class="help"><?php _e('To exclude a certain category, put minus(-) before the category ID(number). Separate them with coma(,)', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="display_title"><?php _e('Show title', $shortname); ?>:</label>
			<select id="display_title" name="display_title">
				<option value="yes"><?php _e('yes', $shortname); ?></option>
				<option value="no"><?php _e('no', $shortname); ?></option>
			</select>
		</div>
	</div>


<?php } elseif($act == 'eventCountdown') { ?>
	<h3><?php _e('Insert Event countdown shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="event_id"><?php _e('Choose upcoming Event', $shortname); ?></label>
		<select name="event_id" id="event_id">
			<?php
				$type = 'events';
				$args = array(
				  'post_type' => $type,
				  'post_status' => 'publish',
				  'posts_per_page' => -1,
				  'caller_get_posts'=> 1
				);

				$my_query = null;
				$my_query = new WP_Query($args);
				global $post;
				if( $my_query->have_posts() ) {
				  	while ($my_query->have_posts()) : $my_query->the_post(); ?>
				  		<option value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
				    <?php
				  endwhile;
				}
				wp_reset_query();  // Restore global post data stomped by the_post().
			?>
		</select>
	</div>
	<div class="inputs">
		<label for="countdown_align"><?php _e('Align', $shortname); ?></label>
		<select name="countdown_align" id="countdown_align">
			<option value="countdown-none"><?php _e('none', $shortname); ?></option>
			<option value="countdown-left"><?php _e('left', $shortname); ?></option>
			<option value="countdown-center"><?php _e('center', $shortname); ?></option>
			<option value="countdown-right"><?php _e('right', $shortname); ?></option>
		</select>
		<span class="help">&nbsp;</span>
	</div>


<?php } elseif($act == 'testimonials') { ?>
	<h3><?php _e('Insert Testimonials shortcode', $shortname); ?></h3>
	<hr />
	<div class="inputs">
		<label for="color"><?php _e('Text Color', $shortname); ?>:</label>
		<input id="color" name="color" type="text" class="pickcolor" />
		<input type="hidden" class="color" />
		<span class="help"><?php _e('Default: #444444', $shortname); ?></span>
	</div>
	<div class="inputs">
		<label for="number"><?php _e('Number', $shortname); ?>:</label>
		<input type="text" id="number" name="number" class="small" />
		<span class="help"><?php _e('If empty, all published testimonials will be displayed.', $shortname); ?></span>
	</div>
	


<?php } elseif($act == 'animated') { ?>
	<h3><?php _e('Animated Element shortcode', $shortname); ?></h3>
	<hr>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="trigger"><?php _e('Trigger', $shortname); ?></label>
			<select name="trigger" id="trigger">
				<option value="scroll">Scroll</option>
				<option value="click">Click</option>
				<option value="hover">Hover</option>
			</select>
		</div>
		<div class="inputs">
			<label class="control-label" for="precent"><?php _e('Scroll Percentage', $shortname); ?></label>
			<select name="precent" id="precent">
				<option>0</option>
				<option selected>10</option>
				<option>20</option>
				<option>30</option>
				<option>40</option>
				<option>50</option>
				<option>60</option>
				<option>70</option>
				<option>80</option>
				<option>90</option>
				<option>100</option>
			</select>
			<span class="help"><?php _e('Animate when % of item is in view', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="animated_type"><?php _e('Animation', $shortname); ?></label>
			<select name="animated_type" id="animated_type">
				<optgroup label="Attention Seekers">
					<option value="flash">flash</option>
					<option value="bounce">bounce</option>
					<option value="shake">shake</option>
					<option value="tada">tada</option>
					<option value="swing">swing</option>
					<option value="wobble">wobble</option>
					<option value="wiggle">wiggle</option>
					<option value="pulse">pulse</option>
				</optgroup>
				<optgroup label="<?php _e('Flippers (currently Webkit, Firefox, &amp; IE10 only)', $shortname); ?>">
					<option value="flash">flash</option>
					<option value="bounce">bounce</option>
					<option value="shake">shake</option>
					<option value="tada">tada</option>
					<option value="swing">swing</option>
					<option value="wobble">wobble</option>
					<option value="wiggle">wiggle</option>
					<option value="pulse">pulse</option>
				</optgroup>
				<optgroup label="<?php _e('Fading entrances', $shortname); ?>">
					<option value="fadeIn">fadeIn</option>
					<option value="fadeInUp">fadeInUp</option>
					<option value="fadeInDown">fadeInDown</option>
					<option value="fadeInLeft">fadeInLeft</option>
					<option value="fadeInRight">fadeInRight</option>
					<option value="fadeInUpBig">fadeInUpBig</option>
					<option value="fadeInDownBig">fadeInDownBig</option>
					<option value="fadeInLeftBig">fadeInLeftBig</option>
					<option value="fadeInRightBig">fadeInRightBig</option>
				</optgroup>
				<optgroup label="<?php _e('Fading exits', $shortname); ?>">
					<option value="fadeOut">fadeOut</option>
					<option value="fadeOutUp">fadeOutUp</option>
					<option value="fadeOutDown">fadeOutDown</option>
					<option value="fadeOutLeft">fadeOutLeft</option>
					<option value="fadeOutRight">fadeOutRight</option>
					<option value="fadeOutUpBig">fadeOutUpBig</option>
					<option value="fadeOutDownBig">fadeOutDownBig</option>
					<option value="fadeOutLeftBig">fadeOutLeftBig</option>
					<option value="fadeOutRightBig">fadeOutRightBig</option>
				</optgroup>
				<optgroup label="<?php _e('Bouncing entrances', $shortname); ?>">
					<option value="bounceIn">bounceIn</option>
					<option value="bounceInDown">bounceInDown</option>
					<option value="bounceInUp">bounceInUp</option>
					<option value="bounceInLeft">bounceInLeft</option>
					<option value="bounceInRight">bounceInRight</option>
				</optgroup>
				<optgroup label="<?php _e('Bouncing exits', $shortname); ?>">
					<option value="bounceOut">bounceOut</option>
					<option value="bounceOutDown">bounceOutDown</option>
					<option value="bounceOutUp">bounceOutUp</option>
					<option value="bounceOutLeft">bounceOutLeft</option>
					<option value="bounceOutRight">bounceOutRight</option>
				</optgroup>
				<optgroup label="<?php _e('Rotating entrances', $shortname); ?>">
					<option value="rotateIn">rotateIn</option>
					<option value="rotateInDownLeft">rotateInDownLeft</option>
					<option value="rotateInDownRight">rotateInDownRight</option>
					<option value="rotateInUpLeft">rotateInUpLeft</option>
					<option value="rotateInUpRight">rotateInUpRight</option>
				</optgroup>
				<optgroup label="<?php _e('Rotating exits', $shortname); ?>">
					<option value="rotateOut">rotateOut</option>
					<option value="rotateOutDownLeft">rotateOutDownLeft</option>
					<option value="rotateOutDownRight">rotateOutDownRight</option>
					<option value="rotateOutUpLeft">rotateOutUpLeft</option>
					<option value="rotateOutUpRight">rotateOutUpRight</option>
				</optgroup>
				<optgroup label="<?php _e('Lightspeed', $shortname); ?>">
					<option value="lightSpeedIn">lightSpeedIn</option>
					<option value="lightSpeedOut">lightSpeedOut</option>
				</optgroup>
				<optgroup label="<?php _e('Specials', $shortname); ?>">
					<option value="hinge">hinge</option>
					<option value="rollIn">rollIn</option>
					<option value="rollOut">rollOut</option>
				</optgroup>
			</select>
		</div>
	</div>


<?php } elseif($act == 'svg_drawing') { ?>
	<h3><?php _e('Insert SVG drawing shortcode', $shortname); ?></h3>
	<hr>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="drawing_type"><?php _e('Type', $shortname); ?></label>
			<select name="drawing_type" id="drawing_type">
				<option value="imac">iMac</option>
				<option value="ipad">iPad</option>
				<option value="iphone">iPhone</option>
			</select>
		</div>
		<div class="inputs">
			<label for="image_id"><?php _e('Image ID:', $shortname); ?></label>
			<div class="alignleft">
				<input type="text" id="image_id" name="image_id" size="18" />
			</div>
			<div class="alignleft">
				<input type="submit" class="upload_image_button btn button" data-uploader_title="Select Image" data-uploader_button_text="Select" value="<?php _e( "Select Image", $shortname ); ?>" />
			</div>
			<br><br>
			<div class="clear"></div>
			<span class="help"><?php _e('Recommended image size is 1000 pixels wide and 600 pixels heigh.', $shortname); ?></span>
			<span class="help"><?php _e('Download free PSD mockups <a href="http://supremewptheme.com/support/" target="_blank">here</a>.', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="drawing_color"><?php _e('Drawing Color', $shortname); ?>:</label>
			<input type="text" size="4" id="drawing_color" name="drawing_color" value="#ffffff" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default: #ffffff - white', $shortname); ?></span>
		</div>
	</div>


<?php } elseif($act == 'createIconBox') { ?>
	<h4><?php _e('Icon Box shortcode', $shortname); ?></h4>
	<hr>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="icon_box_bg"><?php _e('Box background color', $shortname); ?>:</label>
			<input type="text" size="4" id="icon_box_bg" name="icon_box_bg" value="#ffffff" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default is: #ffffff', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="bg_opacity"><?php _e('Bg transparency', $shortname); ?>:</label>
			<select name="bg_opacity" id="bg_opacity">
				<option value="0.1">0.1</option>
				<option value="0.2">0.2</option>
				<option value="0.3">0.3</option>
				<option value="0.4">0.4</option>
				<option value="0.5">0.5</option>
				<option value="0.6">0.6</option>
				<option value="0.7">0.7</option>
				<option value="0.8">0.8</option>
				<option value="0.9">0.9</option>
				<option value="1">1</option>
			</select>
			<span class="help"><?php _e('Default is: 1', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="border_color"><?php _e('Border Color', $shortname); ?>:</label>
			<input type="text" size="4" id="border_color" name="border_color" value="#eeeeee" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default is: #eeeeee', $shortname); ?></span>
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
			<label for="icon_color"><?php _e('Icon color', $shortname); ?>:</label>
			<input type="text" size="4" id="icon_color" name="icon_color" value="#444444" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default is: #444444', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="icon_bg"><?php _e('Icon background color', $shortname); ?>:</label>
			<input type="text" size="4" id="icon_bg" name="icon_bg" value="#ffffff" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default is: #ffffff.', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="icon_shape"><?php _e('Icon style', $shortname); ?></label>
			<select name="icon_shape" id="icon_shape">
				<option value="icon-circle"><?php _e('Circle', $shortname); ?></option>
				<option value="icon-square"><?php _e('Square', $shortname); ?></option>
			</select>
			<span class="help"><?php _e('Circle or Square Icon.', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="icon_pos"><?php _e('Icon position', $shortname); ?></label>
			<select name="icon_pos" id="icon_pos">
				<option value="icon-top"><?php _e('Top', $shortname); ?></option>
				<option value="icon-right"><?php _e('Right', $shortname); ?></option>
				<option value="icon-bottom"><?php _e('Bottom', $shortname); ?></option>
				<option value="icon-left"><?php _e('Left', $shortname); ?></option>
			</select>
			<span class="help"><?php _e('Position of the icon.', $shortname); ?></span>
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


<?php } elseif($act == 'melonIcon') { ?>
	<h4><?php _e('Icon Melon shortcode', $shortname); ?></h4>
	<hr>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="name"><?php _e('Choose icon', $shortname); ?>:</label>
			<?php 
				$icons = array('arrow-target', 'barbeque-eat-food', 'barista-coffee-espresso', 'bag-shopping', 'armchair-chair', 'book-download', 'bomb-bug', 'brush-paint', 'backpack-trekking', 'browser-window', 'book-read', 'caddle-shop-shopping', 'caddle-shopping', 'bubble-love-talk', 'bubble-comment', 'camera-photo-polaroid', 'camera-photo', 'camera-video', 'chef-food-restaurant', 'chaplin-hat-movie', 'coffee', 'cocktail-mojito', 'clock-time', 'computer-macintosh-vintage', 'computer-imac', 'computer', 'computer-imac1', 'cook-pan-pot', 'crop', 'crown-king', 'computer-network', 'dashboard-speed', 'danger-death-delete-destroy-sull', 'design-graphic-tablet', 'design-pencil-rule', 'database', 'delete-garbage', 'drug-medecine-syringue', 'diving-leisure-sea-sport', 'earth-globe', 'eat-food-hotdog', 'eat-food-fork-knife', 'edit-modify', 'factory-lift-warehouse', 'envelope-mail', 'eye-dropper', 'email-mail', 'first-aid-medecine-shield', 'food-ice-cream', 'frame-picture', 'handle-vector', 'grid-lines', 'happy-smiley', 'ink-pen', 'headset-sound', 'home-house', 'ibook-laptop', 'ipad', 'iphone', 'ipod-mini-music', 'ipod', 'japan-tea', 'ipod-music', 'laptop-macbook', 'like-love', 'link', 'macintosh', 'lock-locker', 'locker-unlock', 'map-user', 'micro-record', 'magic-magic-wand', 'man-people-user', 'map-pin', 'monocle-mustache', 'music-speaker', 'paint-bucket', 'music-note', 'notebook', 'painting-pallet', 'pen-feather', 'painting-roll', 'pen', 'pen-big-feather', 'receipt-shopping', 'magnet', 'remote-control', 'picture-stock', 'picture', 'settings-toolkit', 'shoes-snickers-keds', 'settings-adjustments', 'speech-talk-user', 'suitcase-travel', 'synk-refresh-rotate', 'umbrella-weather', 'stamp', 'stock', 'settings-gear', 'friends', 'main-logo', 'sprout', 'sun', 'git', 'invest', 'almost-full-battery', 'archive', 'arrow-both-sides', 'brush', 'arrow-left-1', 'arrow-left-2', 'arrow-right-1', 'bag', 'arrow-right-2', 'bulb', 'cart', 'calendar', 'calculator', 'cinema-camera', 'cassette', 'check', 'cloud-rain', 'cloud-ray', 'close', 'clip', 'cloud-sun', 'diamond', 'crown', 'cloud', 'compact-disc', 'compass', 'download', 'expand', 'dollar', 'empty-battery', 'eye', 'flag', 'flame', 'full-battery', 'folder', 'globe', 'full-screen', 'heart', 'headphones', 'home', 'images', 'inbox', 'label', 'leaf', 'link-2', 'link-1', 'mail-1', 'load', 'mail-2', 'low-charged-battery', 'map', 'magnifying-glass', 'megaphone', 'mute-speaker', 'newspaper', 'menu', 'microphone', 'mid-charged-battery', 'music-note', 'node', 'padlock-open', 'padlock', 'paper-glass', 'paper', 'pencil', 'prize', 'phone-1', 'photo-camera', 'phone-2', 'picture', 'pointer', 'scissors', 'ray', 'reload', 'ribbon', 'setup', 'snow', 'shape76', 'speaker', 'stamp', 'statics', 'speech-balloon', 'speech-balloon-empty', 'speech-balloon-dialogue', 'star', 'tools', 'sun', 't-shirt', 'target', 'umbrella', 'trash-can', 'video-camera', 'user', 'wallet', 'watch', 'wifi', 'repeat', 'target', 'arrow-right', 'arrow-right1', 'ghost', 'twitter', 'facebook', 'search', 'infinity', 'book', 'music-note1', 'image', 'twitter-chicken', 'document', 'todo-list', 'bubble-speech', 'link1', 'tag', 'connect', 'skull', 'message', 'calendar', 'tag1', 'folder', 'heart', 'clock', 'star', 'ribbon', 'video', 'sound', 'photo', 'home', 'ebay', 'b', 'google-plus', 'windows', 'soundcloud', 'skype', 'android', 'vimeo', 'paypal', 'linkedin', 'deviantart', 'pinterest', 'instagram', 'flickr', 'google-drive', 'dropbox', 'dribbble', 'behance', 'tumblr', 'wordpress', 'youtube', 'youtube-2', 'facebook1', 'twitter1', 'ebay1', 'b1', 'soundcloud1', 'windows1', 'vimeo1', 'google-plus1', 'android1', 'skype1', 'paypal1', 'linkedin1', 'devianart', 'pinterest1', 'instagram1', 'flickr1', 'google-drive1', 'behance1', 'dribbble1', 'dropbox1', 'tumblr1', 'wordpress1', 'youtube1', 'youtube2', 'facebook2', 'twitter2', 'alcohol', 'anchor-3', 'anchor-2', 'buoy-2', 'buoy', 'anchor', 'directions', 'flag', 'flag-2', 'knot-2', 'knot', 'eye-patch', 'paper-boat', 'lighthouse', 'oars', 'sail-boat', 'pegleg', 'pirate-hook', 'shark-fin', 'skull-and-crossbones', 'ship-wheel', 'skull1', 'sunrise', 'water', 'treasure-map', 'amsterdam', 'austin', 'cape-town', 'dublin', 'berlin', 'paris', 'san-francisco', 'london', 'stockholm', 'sydney', 'tokyo', 'barcelona', 'wellington', 'new-york', 'clip', 'tablet', 'pc', 'unlock', 'smartphone', 'gear', 'lock', 'lifebuoy', 'tag2', 'calendar1', 'rss', 'upload', 'folder1', 'open-folder-', 'window', 'users', 'eye', 'download', 'phone', 'joystick', 'photo1', 'user', 'load', 'cloud', 'menu1', 'home1', 'info', 'question', 'alert', 'align-left', 'align-right', 'grid', 'align-center', 'align-left-2', 'list', 'grid-2', 'trash', 'stock-graph', 'pie', 'like', 'signal', 'star1', 'heart1', 'message1', 'printer', 'edit', 'bubble-speech1', 'dialog', 'document1', 'text-document', 'move', 'search1', 'close', 'minus', 'map', 'plus', 'check', 'geotag', 'direction', 'arrows', 'arrow-left', 'arrow-right2', 'reply', 'share', 'forward', 'arrow-right-2', 'arrow-left-2', 'share-2', 'rotate', 'repeat-one', 'repeat-all', 'return', 'shuffle', 'music', 'mute', 'microphone', 'loud', 'headphones', 'pause', 'record', 'previous', 'next', 'stop', 'play', 'lamp', 'lamp-2', 'chair', 'chair-2', 'chair-3', 'chair-4', 'chair-5', 'armchair-3', 'armchair', 'armchair-2', 'lounge-chair', 'lounge-chair-2', 'lamp-3', 'table', 'table-2', 'table-3', 'table-4', 'day-bed', 'lamp-4', 'table-5', 'sofa', 'table-6', 'sofa-2', 'lamp-5', 'table-7', 'anchor1', 'diamond', 'heart2', 'needle', 'dagger', 'power-supply', 'swallow', 'mexican-skull', 'mode', 'eye1', 'dropdown', 'folder2', 'gramophone', 'library', 'pen1', 'playlist', 'repeat1', 'rewind', 'shuffle1', 'user1', 'add-card', 'add-document', 'additional-services-card', 'add-user', 'air', 'all-atm', 'analytics', 'archive-cards', 'arrow-bottom', 'arrow-left1', 'arrow-top', 'arrow-right3', 'attach-card', 'billings', 'atm', 'attach-file', 'barcode', 'basket', 'branch-bank', 'callback', 'calendar-day', 'card-details', 'calendar-month', 'cards', 'communications', 'close-1', 'close-2', 'compass', 'cvv2', 'conversion', 'copy', 'dashboard', 'delivery', 'document-csv', 'document-pdf', 'document-html', 'document-txt', 'education-1', 'edit1', 'dollar', 'download1', 'dustbin', 'education-2', 'environment', 'entertainment', 'electronic-money', 'euro', 'exit', 'external-translation', 'eye-open', 'eye-closed', 'facebook3', 'favorites-off', 'favorites-on', 'file', 'financial-services', 'filling', 'forgot-your-password', 'forward-letter', 'foursquare', 'handset', 'history-operations', 'hotels', 'internet', 'housing', 'info1', 'latest-payments', 'jewelry', 'letter', 'lock-open', 'list1', 'lock-closed', 'logo', 'mastercard', 'medicine', 'messages', 'metro-moscow', 'metro-spb', 'money-orders', 'mobile', 'mode1', 'money', 'notification-attention', 'notification-error', 'operator', 'notification-question', 'notification-successfully', 'phone1', 'other', 'paying-regular-repeat', 'payments', 'personal-transport', 'phonebook', 'public-services', 'pin', 'plus1', 'print', 'rent-car', 'rent', 'repeat-payment', 'reply-letter', 'restaurants', 'ruble', 'search2', 'selecting-from-list', 'service', 'sms-notification', 'settings', 'taxes', 'share1', 'shopping', 'transaction-on-card', 'transaction', 'templates', 'transfer-friend', 'transfer-between-own-accounts', 'transfer-other-bank-cards', 'transfer', 'translation-between-accounts-conversion', 'translation-card-conversion', 'travel', 'transport', 'translation-card', 'trolley', 'tv', 'twitter3', 'undefined-transaction', 'undefined-action', 'undefined-service', 'user-1', 'unload', 'user-2', 'virtual-card', 'visa', 'vkontakte', 'webcam', 'ac', 'ae', 'br', 'apple-computer', 'au', 'ai', 'fb', 'download2', 'dw', 'en', 'id', 'finder', 'fl', 'me', 'fw', 'pr', 'ps', 'pl', 'sg', 'settings1', 'sunrise1', 'cloud-rain-moon', 'east', 'north', 'south', 'west', 'cloud-drizzle-sun', 'cloud-drizzle-sun-alt', 'cloud-drizzle-moon', 'cloud-drizzle-moon-alt', 'cloud-download', 'cloud-dizzle', 'cloud-drizzle', 'cloud-fog-sun-alt', 'cloud-fog-sun', 'cloud-fog-moon', 'cloud-fog-moon-alt', 'cloud-fog-alt', 'cloud-hail-alt', 'cloud-hail-moon-alt', 'cloud-hail-moon', 'cloud-fog', 'cloud-hail-sun-alt', 'cloud-hail-sun', 'cloud-hail', 'cloud-lightning-sun', 'cloud-lightning-moon', 'cloud-rain-sun-alt', 'cloud-moon', 'cloud-lightning', 'cloud-rain-alt', 'cloud-rain-moon-alt', 'cloud-rain-sun', 'cloud-snow-moon-alt', 'cloud-rain', 'cloud-refresh', 'cloud-snow-moon', 'cloud-snow-sun-alt', 'cloud-snow-alt', 'cloud-snow-sun', 'cloud-sun', 'cloud-wind-moon', 'cloud-wind', 'cloud-snow', 'cloud-upload', 'cloud1', 'compass1', 'degrees-celcius', 'moon-first-quarter', 'degrees-fahrenheit', 'moon-full', 'moon-new', 'moon-last-quarter', 'moon-waning-crescent', 'moon-waxing-crescent', 'moon-waning-gibbous', 'moon-waxing-gibbous', 'moon', 'shades', 'sun1', 'snowflake', 'sun-low', 'sunset', 'sun-lower', 'thermometer-25', 'cloud-wind-sun', 'thermometer-50', 'thermometer-75', 'thermometer-zero', 'thermometer', 'tornado', 'umbrella', 'wind', 'thermometer-100', 'address-book-2', 'add', 'address-book', 'alarm-clock', 'align-horizontal-centers', 'align-left-edges', 'align-right-edges', 'align-top', 'align-vertical-centers', 'align-bottom', 'anchor2', 'arrow-down', 'arrow-left2', 'arrow-up', 'arrow-right4', 'asterisk', 'attachment-2', 'attachment', 'audio-high', 'audio-mid', 'audio-low', 'battery-20-2', 'battery-20', 'battery-40-2', 'battery-40', 'battery-60-2', 'audio-mute', 'battery-60', 'battery-80-2', 'battery-80', 'battery-100-2', 'battery-100', 'battery-charge', 'battery-empty-2', 'battery-empty', 'bell-2', 'bell-mute-2', 'battery-charge-2', 'bell-mute', 'bell', 'bin-3', 'bin-2', 'bin', 'book-2', 'book-lines', 'book1', 'brightness-high', 'brightness-low', 'browser-close-2', 'browser-close', 'browser-download-2', 'browser-download', 'browser-2', 'browser-minimize-2', 'browser-new-window-2', 'browser-minimize', 'browser-new-window', 'book-lines-2', 'browser-upload', 'browser-upload-2', 'browser-windows-2', 'browser-windows', 'browser', 'bulb-2', 'bulb', 'bullhorn', 'bullhorn-2', 'camera-2', 'calendar2', 'bullet', 'camera-3', 'clipboard-2', 'camera', 'cassette', 'clipboard', 'clock1', 'cloud-add-2', 'cloud-add', 'cloud-download1', 'cloud-remove-2', 'cloud2', 'cmd', 'commit', 'code', 'cloud-upload1', 'compass2', 'compose-2', 'compose-4', 'compose-3', 'cloud-remove', 'compose', 'contract-2', 'contract-3', 'contrast', 'contract', 'converge', 'credit-card-2', 'credit-card-3', 'crate', 'credit-card-4', 'credit-card', 'crop1', 'cross', 'curlybrace-2', 'database-add', 'database-remove', 'database1', 'curlybrace', 'delete', 'distribute-bottom-edges', 'distribute-horizontal-centers', 'distribute-left-edges', 'distribute-right-edges', 'distribute-vertical-centers', 'document-add', 'document-remove', 'document2', 'distribute-top-edges', 'droplet', 'ellipsis', 'envelope', 'exclude', 'expand-2', 'expand', 'expand-3', 'eye-2', 'eye2', 'fast-forward', 'flag-3', 'flag1', 'flask-full', 'flask-empty', 'floppy', 'flux', 'folder-2', 'folder-add-2', 'folder-add', 'folder-duplicate', 'folder-remove-2', 'folder-remove', 'folder-duplicate-2', 'folder3', 'fork', 'grid-3', 'grid1', 'headphones1', 'heart-full', 'heart-empty', 'heart-half', 'home-2', 'home-3', 'home2', 'icon0', 'in', 'image1', 'inbox-2', 'inbox', 'infinity1', 'intersect', 'key-2', 'layout-column-center', 'keys', 'layout-content-left-2', 'key', 'layout-content-left', 'layout-content-right-2', 'layout-content-right', 'layout-sidebar-left', 'layout-sidebar-right', 'link2', 'list-2', 'link-2', 'list2', 'locked', 'mail-2', 'mail-3', 'mail-4', 'mail-outgoing', 'mail', 'map-2', 'mail-incoming', 'map1', 'marquee-download', 'marquee-minus', 'marquee-plus', 'marquee-upload', 'maximise', 'marquee', 'menu-2', 'menu-pull-down', 'menu-pull-up', 'menu2', 'microphone-2', 'minus1', 'mixer', 'microphone1', 'newspaper-2', 'newspaper', 'next1', 'nib', 'nope', 'options', 'out', 'outbox-2', 'notes', 'outbox', 'outgoing-2', 'paper-ripped', 'outgoing', 'paper-roll-ripped', 'paragraph-center-2', 'paper-roll', 'paragraph-center', 'paragraph-justify-2', 'paragraph-justify', 'paragraph-left-2', 'paragraph-left', 'paragraph-right', 'pen2', 'pause1', 'paragraph-right-2', 'pencil', 'pin-2', 'pin1', 'play1', 'plus2', 'podcast', 'polaroid-2', 'podcast-2', 'polaroid', 'power', 'previous1', 'print1', 'pull', 'quill', 'refresh', 'quill-2', 'reminder', 'remove', 'repeat-2', 'repeat2', 'reply-all', 'return1', 'revert', 'rewind1', 'rulers', 'safe', 'search-2', 'search3', 'settings-2', 'settings-3', 'section', 'settings2', 'settings-4', 'shred', 'shuffle2', 'sleep', 'reply1', 'spam-2', 'spam', 'speech-bubble-center-2', 'speech-bubble-center-3', 'speech-bubble-center', 'speech-bubble-left-3', 'speech-bubble-left-4', 'speech-bubble-left-2', 'speech-bubble-left', 'speech-bubble-right-2', 'speech-bubble-right-3', 'speech-bubble-right-4', 'speech-bubble-right', 'spinner-3', 'spinner', 'split-2', 'spinner-2', 'split', 'spool', 'square-brackets', 'stamp-2', 'stamp1', 'star2', 'stiffy', 'star-2', 'stop1', 'stopwatch', 'store-2', 'store', 'support-3', 'subtract', 'support', 'support-2', 'swap-2', 'switch-off', 'swatch', 'swatches', 'swap', 'switch-on', 'tag-2', 'tag-3', 'tag-4', 'tag3', 'terminal-2', 'terminal', 'terminal-3', 'tick', 'tilde', 'timeline', 'toggle-off', 'toggle-on', 'transfer1', 'tray', 'unite', 'unlocked', 'unwatch', 'user-2-add', 'user-3', 'user-4-add', 'user-4', 'user-4-remove', 'user-2-remove', 'user-5', 'user-card', 'users1', 'user2', 'video-2', 'vinyl', 'video1', 'voicemail', 'wallet-2', 'wallet', 'watch-2', 'watch', 'wave', 'wave-2', 'wifi-high', 'wifi-low', 'wifi-mid', 'wiggle', 'windows2', 'zoom-in', 'zoom-out-2', 'zoom-out', 'zoom-in-2', 'vertical-swipe-2', 'triple-tap-2', 'vertical-swipe', 'vertical-drag', 'swipe-up-2', 'tap-2', 'swipe-right-2', 'swipe-left-2', 'omnidi-swipe-2', 'swipe-down-2', 'triple-tap', 'horizontal-swipe', 'double-tap-2', 'drag', 'tap', 'swipe-right', 'swipe-left', 'swipe-down', 'rotate-counter-clockwise', 'rotate-clockwise', 'spread', 'pinch', 'omnidir-swipe', 'onmidir-drag', 'horizontal-swipe1', 'horizontal-drag', 'drag-left', 'drag-down', 'double-tap', 'drag-right', 'drag-up', 'vertical-flick', 'omnidir-flick', 'horizontal-flick', 'flick-right', 'flick-left', 'flick-up', 'flick-down', 'swipe-up', 'backpack', 'backpack-2', 'bill', 'bookmark', 'briefcase', 'bookshelf', 'bus', 'calc', 'car', 'chalkboard', 'clock2', 'candy', 'cloud-check', 'cloud-down', 'cloud-error', 'cloud-refresh1', 'cloud-up', 'donut', 'hamburger', 'flag2', 'eye3', 'glasses', 'glove', 'drop', 'hand', 'knife', 'map2', 'label', 'map3', 'hotdog', 'marker', 'mcfly', 'mountain', 'medicine1', 'open-letter', 'muffin', 'paper-plane', 'piggy', 'photo-2', 'packman', 'pizza', 'pin2', 'r2d2', 'rocket', 'store1', 'sale', 'skull2', 'speakers', 'toaster', 'train', 'tactic', 'watch1', 'www', 'umbrella1', 'minus2', 'plus3', 'arrow-down1', 'arrow-right5', 'arrow-left3', 'arrow-top1', 'other1', 'download3', 'other2', 'paint-roll', 'image2', 'image3', 'soother', 'indesign-doc', 'doc', 'text-doc', 'illustrator-doc', 'photoshop-doc', 'message-empty', 'book2', 'message-middle', 'message-full', 'envelope-open', 'note-book', 'envelope1', 'safe1', 'search4', 'mailbox', 'deal', 'briefcase1', 'law', 'office', 'house', 'coffee1', 'computer-mouse', 'washing-machine', 'joystick1', 'joystick2', 'light', 'laptop', 'camera1', 'fax', 'tv1', 'imac', 'tablet1', 'microphone2', 'smartphone1', 'photo-camera', 'radio', 'battery-empty1', 'battery-middle', 'chemistry', 'medicine2', 'battery-full', 'calculator', 'syringe', 'chemistry1', 'termometer', 'chemistry2', 'light-bulb', 'pen3', 'paint-brush', 'pen4', 'paper-knife', 'paint-brush1', 'glue', 'paint-roll1', 'marker1', 'pencil1', 'ruler', 'gifts', 'santa', 'gingerbread', 'gifts1', 'song', 'elf', 'calendar3', 'price-tag', 'santa-hat', 'sledge', 'sock', 'bird', 'angel', 'candy-stick', 'candle', 'ornament', 'star3', 'penguin', 'ornament1', 'ornament2', 'candy1', 'bell1', 'ornament3', 'ornament4', 'candy2', 'deer', 'christmas-tree', 'ornament5', 'gift', 'snowflake1', 'snowman', 'ornament6', 'christmas-tree1', 'santa1', 'garland', 'ornament7', 'candle1', 'ornament8', 'snowflake2', 'sock1', 'gift1', 'deer1', 'santa-hat1', 'christmas-wreath', 'cake', 'forest', 'deer2', 'santa2', 'heart3', 'bow-tie', 'snowman1', 'snowflake3', 'gingerbread1', 'bell2', 'gloves', 'ornament9', 'sock2', 'star4', 'santa-hat2', 'christmas-tree2', 'gift2', 'candy-stick1', 'ornament10', 'shopping-cart', 'barcode1', 'message2', 'money1', 'message3', 'moneybox', 'shipping', 'baggage', 'package', 'credit-card1', 'money2', 'money3', 'shopping-cart1', 'gift3', 'like1', 'package1', 'package-open', 'open-sign', 'calculator1', 'wallet1', 'money4', 'window1', 'console', 'map4', 'map5', 'search5', 'joystick3', 'direction-size', 'map6', 'direction-size1', 'flag3', 'direction-size2', 'road-turn', 'microphone3', 'equalizer', 'map-tag', 'pin3', 'globe', 'globe1', 'graph-pie', 'compass3', 'tag4', 'tag5', 'play-pause', 'volume-loud', 'sound1', 'microphone4', 'rewind2', 'play-pause1', 'play2', 'volume-mute', 'volume', 'volume-up', 'pin4', 'arrow-left4', 'arrow-right6', 'align-right1', 'align-left1', 'align-center1', 'ribbon1', 'book3', 'book4', 'book-open', 'calendar4', 'briefcase2', 'calendar5', 'presentation', 'presentation1', 'contacts', 'blank-document', 'document3', 'briefcas', 'bubble-speach', 'bubble-speach1', 'bubble-speach2', 'bubble-speach3', 'bubble-speach4', 'mailbox1', 'folder4', 'bubble-speach5', 'mail1', 'mail2', 'mail3', 'mail4', 'documents', 'documents1', 'documents2', 'upload1', 'download4', 'documents3', 'mail5', 'calculator2', 'laptop1', 'folders', 'speed', 'mouse', 'presentation2', 'type', 'type-cursor', 'grid2', 'notepad', 'search6', 'graph-pie1', 'graph', 'cd', 'cd1', 'floppy-disk', 'edit2', 'edit3', 'image4', 'image5', 'bell3', 'cord', 'medal', 'alarm-clock1', 'photo2', 'photo3', 'photo4', 'light-bulb1', 'light-bulb2', 'rotate1', 'arrow-right7', 'flag4', 'arrow-left5', 'right-arrow', 'left-arrow', 'close1', 'check1', 'heart4', 'list3', 'gear1', 'love-talk', 'love-chat', 'love-thoughts', 'add-love', 'love-more', 'multiply-love', 'love-again', 'view-love', 'subtract-love', 'love-2-way-street', 'loveppriciate', 'loverror', 'love-bow', 'win-love', 'lovexlamation', 'love-25-', 'love-50-', 'love-75-', 'love-100-', 'love-link-up', 'love-connect', 'lovers-wifi', 'verbal-love', 'silent-love', 'search-love', 'add-love1', 'multiply-love1', 'subtract-love1', 'lucky-in-love', 'trash-love', 'lovetimate', 'time-for-some-love', 'wait-for-love', 'love-bought', 'love-burst', 'love-play', 'love-there', 'love-here', 'open-to-love', 'closed-to-love', 'love-lit', 'love-light', 'love-edit', 'snowflake-04', 'snowflake-02', 'snowflake-03', 'snowflake-06', 'snowflake-05', 'snowflake-07', 'snowflake-08', 'snowflake-10', 'snowflake-12', 'snowflake-09', 'snowflake-13', 'snowflake-14', 'snowflake-15', 'snowflake-16', 'snowflake-11', 'snowflake-17', 'snowflake-18', 'snowflake-19', 'snowflake-20', 'snowflake-22', 'snowflake-21', 'snowflake-23', 'snowflake-24', 'snowflake-26', 'snowflake-27', 'snowflake-25', 'snowflake-29', 'snowflake-28', 'snowflake-30', 'snowflake-31', 'snowflake-32', 'snowflake-33', 'snowflake-34', 'snowflake-35', 'snowflake-36', 'snowflake-37', 'snowflake-38', 'snowflake-39', 'snowflake-41', 'snowflake-40', 'snowflake-42', 'snowflake-43', 'snowflake-44', 'snowflake-45', 'snowflake-47', 'snowflake-49', 'snowflake-46', 'snowflake-48', 'snowflake-50', 'snowflake-51', 'snowflake-53', 'snowflake-54', 'snowflake-52', 'snowflake-55', 'snowflake-56', 'snowflake-57', 'snowflake-58', 'snowflake-59', 'snowflake-60', 'snowflake-61', 'snowflake-62', 'snowflake-63', 'snowflake-64', 'snowflake-65', 'snowflake-66', 'snowflake-67', 'snowflake-68', 'snowflake-69', 'snowflake-70', 'snowflake-71', 'smartphone2', 'printer1', 'map7', 'pin5', 'mail6', 'airplane', 'gear2', 'share2', 'like2', 'globe2', 'tools', 'bomb', 'zip', 'image6', 'cloud3', 'graph1', 'briefcase3', 'list4', 'folder5', 'bookmark1', 'funds', 'cart', 'gist', 'coffee2', 'chicken', 'apple', 'icecream', 'music1', 'pipe', 'diamond1', 'robo', 'facebook4', 'gplus', 'twitter4', 'dribbble2', 'github', 'math', 'graph2', 'discuss', 'work', 'professor', 'diploma', 'work1', 'calendar6', 'recycle', 'tools1', 'lab', 'botanica', 'ufology', 'chemistry3', 'net', 'ornithology', 'economics', 'stort', 'exam', 'chemistry4', 'airplane1', 'pharma', 'history', 'internet1', 'geography', 'pin6', 'calculator3', 'school-bus', 'dna', 'gravity', 'astrology', 'brain', 'formula', 'graph3', 'glasses1', 'arheology', 'flag5', 'crop2', 'image7', 'flag6', 'move1', 'stop2', 'download5', 'rain', 'upload2', 'equalizer1', 'snow', 'sun2', 'partial-sun', 'rain1', 'cloud4', 'thunder', 'clip1', 'tag6', 'on', 'folder6', 'chain', 'briefcase4', 'wallet2', 'mail7', 'user3', 'mail8', 'lifebuoy1', 'map8', 'map9', 'geotag1', 'recieved', 'send', 'battery-low', 'battery-middle1', 'battery-full1', 'battery-died', 'error', 'success', 'map-direction', 'cursor', 'photo5', 'smartphone3', 'tablet2', 'cassette1', 'laptop2', 'desktop', 'mouse1', 'house1', 'conversation', 'speech', 'speech1', 'search7', 'star5', 'document4', 'documents4', 'document5', 'edit4', 'edit5', 'trash1', 'trash2', 'rotate2', 'rotate3', 'unlock1', 'lock1', 'grid3', 'grid4', 'clock3', 'compass4', 'ribbon2', 'wifi', 'eye4', 'menu3', 'sound2', 'loud1', 'mute1', 'pause2', 'stop3', 'rewind3', 'play3', 'forward1');

				echo '<input type="hidden" name="name" value="fa fa-'.$value.'" id="name" />';
				echo '<div class="ss-icon-preview icon_melon"><div class="iconmelon icon"><svg viewBox="0 0 32 32"><use xlink:href="#'.$value.'"></use></svg></div></div>';
				echo '<input class="ss-search" type="text" placeholder="Search icon" />';
				echo '<div id="ss-icon-dropdown" class="melon-dropdown">';
				echo '<ul class="ss-icon-list">';
				$n = 1;
				foreach($icons as $icon){
					$selected = ($icon == $value) ? 'class="selected"' : '';
					$id = 'icon-'.$n;
					echo '<li '.$selected.' data-icon="'.$icon.'">';
					echo '<div class="iconmelon icon"><svg viewBox="0 0 32 32"><use xlink:href="#'.$icon.'"></use></svg></div>';
					echo '<label class="icon">'.$icon.'</label></li>';
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

		<script>
	      	var url = stPluginUrl+'/js/iconmelon/icons.svg';
	      	var c=new XMLHttpRequest(); c.open('GET', url, false); c.setRequestHeader('Content-Type', 'text/xml'); c.send();
	      	document.body.insertBefore(c.responseXML.firstChild, document.body.firstChild)
	    </script>
	</div>


<?php } elseif($act == 'gchart') { ?>
	<h4><?php _e('Google Charts shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="g_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="g_title" name="g_title" type="text" />
		</div>
		<div class="inputs req">
			<label for="data"><?php _e('Data', $shortname); ?>: <span style="color:red;">*</span></label>
			<textarea name="data" id="data"></textarea>
			<span class="help"><?php _e('Example', $shortname); ?>: ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)</span>
		</div>
		<div class="inputs">
			<label for="width"><?php _e('Width', $shortname); ?>:</label>
			<input id="width" name="width" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: 500</span>
		</div>
		<div class="inputs">
			<label for="height"><?php _e('Height', $shortname); ?>:</label>
			<input id="height" name="height" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: 300</span>
		</div>
		<div class="inputs">
			<label for="gchart_type"><?php _e('Type', $shortname); ?>: <span style="color:red;">*</span></label>
			<input id="gchart_type" name="gchart_type" type="text" />
			<span class="help"><?php _e('Options', $shortname); ?>: pie, column, area, line, bar, geochart, candlestick, combo, scatter, table, treemap or gauge.</span>
		</div>
		<br />
		<h4><?php _e('Additional options for: ', $shortname); ?>combo, scatter, area, bar, column</h4>
		<div class="inputs">
			<label for="vAxis"><?php _e('vAxis title', $shortname); ?>:</label>
			<input id="vAxis" name="vAxis" type="text" />
			<span class="help"><?php _e('Example: Month', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="hAxis"><?php _e('hAxis title', $shortname); ?>:</label>
			<input id="hAxis" name="hAxis" type="text" />
			<span class="help"><?php _e('Example: Year', $shortname); ?></span>
		</div>
		<h4><?php _e('Additional options for: combo', $shortname); ?></h4>
		<div class="inputs">
			<label for="series_type"><?php _e('Series Type', $shortname); ?>:</label>
			<input id="series_type" name="series_type" type="text" />
			<span class="help"><?php _e('Options', $shortname); ?>: line, area, bars, candlesticks and steppedArea</span>
		</div>
		<h4><?php _e('Additional options for', $shortname); ?>: gauge</h4>
		<div class="inputs">
			<label for="red_from"><?php _e('Red from', $shortname); ?>:</label>
			<input id="red_from" name="red_from" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: 90</span>
		</div>
		<div class="inputs">
			<label for="red_to"><?php _e('Red to', $shortname); ?>:</label>
			<input id="red_to" name="red_to" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: 100</span>
		</div>
		<div class="inputs">
			<label for="yellow_from"><?php _e('Yellow from', $shortname); ?>:</label>
			<input id="yellow_from" name="yellow_from" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: 75</span>
		</div>
		<div class="inputs">
			<label for="yellow_to"><?php _e('Yellow to', $shortname); ?>:</label>
			<input id="yellow_to" name="yellow_to" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: 90</span>
		</div>
		<div class="inputs">
			<label for="gauge_minor_ticks"><?php _e('Minor Ticks', $shortname); ?>:</label>
			<input id="gauge_minor_ticks" name="gauge_minor_ticks" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: 5</span>
		</div>
	</div>


<?php } elseif($act == 'chart_pie') { ?>
	<h4><?php _e('Google Chart - Pie shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="pie_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="pie_title" name="pie_title" type="text" />
		</div>
		<div class="inputs req">
			<label for="data"><?php _e('Data', $shortname); ?>: <span style="color:red;">*</span></label>
			<textarea name="data" id="data"></textarea>
			<span class="help"><?php _e('Example', $shortname); ?>: ('Task', 'Hours per Day'),('Work', 11),('Sleep', 7),('Eat', 2),('Commute', 3)</span>
		</div>
	</div>


<?php } elseif($act == 'chart_bar') { ?>
	<h4><?php _e('Google Chart - Bar shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="bar_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="bar_title" name="bar_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Company Performance</span>
		</div>
		<div class="inputs req">
			<label for="data"><?php _e('Data', $shortname); ?>: <span style="color:red;">*</span></label>
			<textarea name="data" id="data"></textarea>
			<span class="help"><?php _e('Example', $shortname); ?>: ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)</span>
		</div>
		<div class="inputs">
			<label for="haxis_title"><?php _e('hAxis', $shortname); ?>:</label>
			<input id="haxis_title" name="haxis_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Amount</span>
		</div>
		<div class="inputs">
			<label for="vaxis_title"><?php _e('vAxis', $shortname); ?>:</label>
			<input id="vaxis_title" name="vaxis_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Year</span>
		</div>
	</div>


<?php } elseif($act == 'chart_area') { ?>
	<h4><?php _e('Google Chart - Area shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="area_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="area_title" name="area_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Company Performance</span>
		</div>
		<div class="inputs req">
			<label for="data"><?php _e('Data', $shortname); ?>: <span style="color:red;">*</span></label>
			<textarea name="data" id="data"></textarea>
			<span class="help"><?php _e('Example', $shortname); ?>: ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)</span>
		</div>
		<div class="inputs">
			<label for="haxis_title"><?php _e('hAxis', $shortname); ?>:</label>
			<input id="haxis_title" name="haxis_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Amount</span>
		</div>
		<div class="inputs">
			<label for="vaxis_title"><?php _e('vAxis', $shortname); ?>:</label>
			<input id="vaxis_title" name="vaxis_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Year</span>
		</div>
	</div>



<?php } elseif($act == 'chart_geo') { ?>
	<h4><?php _e('Google Chart - Geo shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="geo_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="geo_title" name="geo_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Popularity</span>
		</div>
		<div class="inputs req">
			<label for="data"><?php _e('Data', $shortname); ?>: <span style="color:red;">*</span></label>
			<textarea name="data" id="data"></textarea>
			<span class="help"><?php _e('Example', $shortname); ?>: ('Country', 'Popularity'),('Germany', 200),('United States', 300),('Brazil', 400),('Canada', 500),('France', 600),('RU', 700)</span>
		</div>
		<div class="inputs">
			<label for="primary"><?php _e('Primary color', $shortname); ?>:</label>
			<input id="primary" name="primary" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default: green', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="secondary"><?php _e('Secondary color', $shortname); ?>:</label>
			<input id="secondary" name="secondary" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default', $shortname); ?>: #EBE5D8</span>
		</div>
	</div>


<?php } elseif($act == 'chart_combo') { ?>
	<h4><?php _e('Google Chart - Combo shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="combo_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="combo_title" name="combo_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Monthly Coffee Production by Country</span>
		</div>
		<div class="inputs req">
			<label for="data"><?php _e('Data', $shortname); ?>: <span style="color:red;">*</span></label>
			<textarea name="data" id="data"></textarea>
			<span class="help"><?php _e('Example', $shortname); ?>: ('Month','Bolivia','Ecuador','Madagascar','Papua New Guinea','Rwanda','Average'),('2004/05',165,938,522,998,450,614.6),('2005/06',135,1120,599,1268,288,682),('2006/07',157,1167,587,807,397,623),('2007/08',139,1110,615,968,215,609.4),('2008/09',136,691,629,1026,366,569.6)</span>
		</div>
		<div class="inputs">
			<label for="haxis_title"><?php _e('hAxis', $shortname); ?>:</label>
			<input id="haxis_title" name="haxis_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Month</span>
		</div>
		<div class="inputs">
			<label for="vaxis_title"><?php _e('vAxis', $shortname); ?>:</label>
			<input id="vaxis_title" name="vaxis_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Cups</span>
		</div>
		<div class="inputs">
			<label for="series"><?php _e('Series', $shortname); ?>:</label>
			<input id="series" name="series" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: 5</span>
		</div>
	</div>


<?php } elseif($act == 'chart_org') { ?>
	<h4><?php _e('Google Chart - Organizational shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs req">
			<label for="data"><?php _e('Data', $shortname); ?>: <span style="color:red;">*</span></label>
			<textarea name="data" id="data"></textarea>
			<span class="help"><?php _e('Example', $shortname); ?>: ('Name','Manager','Tooltip'),('Mike',null,'The President'),( 'Jim', 'Mike', null),('Alice', 'Mike', null), ('Alice2', 'Mike', null),('Bob','Jim', 'Bob Sponge'),('Carol', 'Bob', null),('Carol2', 'Bob', null)</span>
		</div>
	</div>


<?php } elseif($act == 'chart_bubble') { ?>
	<h4><?php _e('Google Chart - Bubble shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs">
			<label for="bubble_title"><?php _e('Title', $shortname); ?>:</label>
			<input id="bubble_title" name="bubble_title" type="text" />
			<span class="help"><?php _e('Example', $shortname); ?>: Popularity</span>
		</div>
		<div class="inputs req">
			<label for="data"><?php _e('Data', $shortname); ?>: <span style="color:red;">*</span></label>
			<textarea name="data" id="data"></textarea>
			<span class="help"><?php _e('Example', $shortname); ?>: ('ID', 'X', 'Y', 'Temperature'),('',80,167,120),('',79,136,130),('',78,184,50),('',72,278,230),('',81,200,210),('',72,170,100),('',68,477,80)</span>
		</div>
		<div class="inputs">
			<label for="primary"><?php _e('Primary color', $shortname); ?>:</label>
			<input id="primary" name="primary" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default: yellow', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="secondary"><?php _e('Secondary color', $shortname); ?>:</label>
			<input id="secondary" name="secondary" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default: red', $shortname); ?></span>
		</div>
	</div>



<?php } elseif($act == 'imgScroller') { ?>
	<h4><?php _e('Image Scroller shortcode', $shortname); ?></h4>
	<div class="transHalf noBorder">
		<div class="inputs req">
			<label class="control-label" for="img_url"><?php _e('Image URL:', $shortname); ?></label>
			<input type="text" id="img_url" name="img_url" size="18" class="imageField alignleft" />
			<input type="submit" class="upload_image_button btn button alignleft" data-uploader_title="Select Image" data-uploader_button_text="Select" value="<?php _e( "Select Image", $shortname ); ?>" />
		</div>
		<div class="inputs req">
			<label for="img_height"><?php _e('Height', $shortname); ?>:</label>
			<input id="img_height" name="img_height" type="text" />
			<span class="help"><?php _e('In pixels. Example: 350', $shortname); ?></span>
		</div>
		<div class="inputs req">
			<label for="speed"><?php _e('Animation speed', $shortname); ?>:</label>
			<input id="img_speed" name="speed" type="text" />
			<span class="help"><?php _e('In miliseconds. For example 2 secundes would be: 2500', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="img_border"><?php _e('Border thickness', $shortname); ?>:</label>
			<input id="border_thickness" name="img_border" type="text" />
			<span class="help"><?php _e('In pixels. Example: 10px', $shortname); ?></span>
		</div>
		<div class="inputs">
			<label for="border_color"><?php _e('Border color', $shortname); ?>:</label>
			<input id="img_border_color" name="border_color" type="text" class="pickcolor" />
			<input type="hidden" class="color" />
			<span class="help"><?php _e('Default: none', $shortname); ?></span>
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
