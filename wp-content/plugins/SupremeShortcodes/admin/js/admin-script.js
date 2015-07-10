/* COOKIES */
function getCookie(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
	    {
	    return unescape(y);
	    }
	  }
}

function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}


/* DOCUMENT READY */
jQuery(document).ready(function($){

	/* COOKIES */
	var curr_tab = 0;
	if (getCookie("curr_tab") != "") {
		curr_tab = getCookie("curr_tab");
	}

	/* MENU - TABS */
	var tabs = $('#tabs-titles li'); //grab tabs
	var contents = $('#tabs-contents li'); //grab contents

	tabs.bind('click',function(){

		var curr_tab = $(this).index();
		setCookie("curr_tab", curr_tab, 180);

		contents.hide(); //hide all contents
		tabs.removeClass('current'); //remove 'current' classes
		$(contents[$(this).index()]).show(); //show tab content that matches tab title index
		$(this).addClass('current'); //add current class on clicked tab title

	}).eq(curr_tab).click();


	///////////////////
	//	Color Picker
	///////////////////
   	function ColorPicker(){

   		var lastColorInput;
		var hiddenInput = $(this).parent().parent().find(".hidden_color_value");

        lastColorInput = $(this).parent().parent().find('.colorPicker');

   		var myOptions = {
		    // you can declare a default color here,
		    // or in the data-default-color attribute on the input
		    defaultColor: false,
		    // a callback to fire whenever the color changes to a valid color
		    change: function() {
      				hiddenInput.val(lastColorInput);
			    },
		    // a callback to fire when the input is emptied or an invalid color
		    clear: function() {},
		    // hide the color picker controls on load
		    hide: true,
		    // show a group of common colors beneath the square
		    // or, supply an array of colors to customize further
		    palettes: true
		};

		

		$('.colorPicker').each( function() {
			$(this).wpColorPicker(myOptions);
		});

	}
	ColorPicker();



	/////////////////////////
	//	Media uploader
	/////////////////////////
	function SSMediaUploader(html){
		// Uploading files
		var file_frame;

		jQuery('.ss_media_upload').live('click', function( event ){

			event.preventDefault();

			formfield = $(this).parent().find('.imageField');

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: jQuery( this ).data( 'uploader_title' ),
				button: {
					text: jQuery( this ).data( 'uploader_button_text' ),
				},
				multiple: false  // Set to true to allow multiple files to be selected
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				attachment = file_frame.state().get('selection').first().toJSON();

				// Do something with attachment.id and/or attachment.url here
				formfield.val(attachment.url);

				if (formfield.attr("name") == "SupremeShortcodes[restore_file]"){

					var href = attachment.url;
					$(formfield).attr('value', href);


					/////////////////////////////
					//	RESTORING PLUGIN OPTIONS
					/////////////////////////////
					
					setTimeout(function() {

						if (!confirm(alertConfirm)) return;

						$.fancybox(
						'<img class="img_center" src="'+stPluginUrl+'/images/framework/ajax-loader.gif" /><br /><h3>'+restHeading+'</h3><br /><p style="text-align: center;">'+restText+'</p>',
							{
								'autoDimensions'	: false,
								'width'         	: 350,
								'height'        	: 'auto',
								'transitionIn'		: 'none',
								'transitionOut'		: 'none',
								'hideOnOverlayClick': false,
								'hideOnContentClick': false,
								'modal'				: true

							}
						);


						settingsBusy = true;

						$.ajax({
							type: "GET",
							url: stPluginUrl+'/admin/ajaxReq.php?act=ss_restore_plugin_options',
							data: {
								file : $("#restore_file").val()
							}
						}).done(function() {

							settingsBusy = false;

							$.fancybox(
							'<img class="img_center" src="'+stPluginUrl+'/images/framework/icon-success.png" />&nbsp;<h3 class="left">'+msgSuccess+'</h3>',
								{
									'autoDimensions'	: false,
									'width'         	: 400,
									'height'        	: 'auto',
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'hideOnOverlayClick': false,
									'hideOnContentClick': false,
									'modal'				: true

								}
							);

							setTimeout(function(){
								//reload window
								window.location.reload();
							}, 3000);

						}).fail(function() { 
							settingsBusy = false;
							alert(alertError); 
						});

					}, 180);
					//////////////////////////////////
					//	END RESTORING THEME OPTIONS
					//////////////////////////////////

				}

				var settingsBusy = false;		


			});

			// Finally, open the modal
			file_frame.open();
		});
	}
	SSMediaUploader();	



});