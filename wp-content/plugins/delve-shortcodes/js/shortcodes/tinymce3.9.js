(function() {
"use strict";
	
	tinymce.PluginManager.add("delve_shortcodes", function(editor, url) {
		var g_url = url;
    	editor.addButton('delve_shortcodes_button', {
			type: 'listbox',
			title: 'Delve',
			text: 'Delve',
	        icon: 'delve',
			classes: 'mce-btn delve-class',
			tooltip: 'Delve Shortcodes',
        	onclick: function() {
        	},
			menu : [
				//{ text: "Shortcodes", classes: "mceMenuItemTitle", disabled: true },
					// columns
					{text:'Icon Box',onclick: function(){setcontentfun(editor,"delve_icon_box");}},
					{text:'Pie Progress',onclick: function(){setcontentfun(editor,"delve_pie_progress");}},
					{text:'Contact Info',onclick: function(){setcontentfun(editor,"delve_contact_info");}},
					{text:'Counter Box',onclick: function(){setcontentfun(editor,"delve_counter_box");}},
					{text:'Recent Posts',onclick: function(){setcontentfun(editor,"delve_recent_post");}},
					{text:'Magazine Style Posts',onclick: function(){setcontentfun(editor,"delve_magazine_style");}},
					{text:'Delve Slider',onclick: function(){setcontentfun(editor,"delve_slider");}},
					{text:'Ourteam', onclick: function(){setcontentfun(editor,"delve_ourteam");}},
					{text:'Delve Testimonials', onclick: function(){setcontentfun(editor, "delve_testimonials")}},
					{text:'Testimonial Slider', onclick: function(){setcontentfun(editor,"delve_testimonial_slider");}},
					{text:'Skillbar', onclick: function(){setcontentfun(editor,"delve_skillbar");}},
					{text:'Pricing Table', onclick: function(){setcontentfun(editor,"delve_pricing_table");}},
					{text:'Gallery', onclick: function(){setcontentfun(editor,"delve_gallery");}},
			]
 	   });
	
		setTimeout(function() {
			jQuery('.mce-widget.mce-btn').each(function() {
				var btn = jQuery(this);
				/*if (btn.attr('aria-label')=="Delve Shortcode")
					btn.find('span').css({padding:"10px 20px 10px 10px"});*/
			});
			jQuery('.mce-toolbar .mce-mce-btn.mce-delve-class > button > span').css({'display':'none'});
			jQuery('.mce-toolbar .mce-mce-btn.mce-delve-class i.mce-ico.mce-i-delve').css('background','url('+g_url+'/dicon.png) no-repeat scroll 0 0 transparent');
			
			jQuery('.mce-toolbar .mce-mce-btn.mce-delve-class').css({'direction':'ltr', 'background':'#fff', 'border':'1px solid #ddd', '-webkit-box-shadow':'inset 0 1px 1px -1px rgba(0,0,0,.2)', 'box-shadow':'inset 0 1px 1px -1px rgba(0,0,0,.2)',
 'padding':'3px', 'width':'40px', 'float':'left', 'margin-left':'3px'});
		
		},100);
		
	});
	
 	function setcontentfun(ed, id) {
		
		// Selected content
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
					
		// Add highlighted content inside the shortcode when possible - yay!
		if ( mceSelected ) {
			var delveDummyContent = mceSelected;
		} else {
			var delveDummyContent = 'Your content goes here...';
		}
		
		
		if(id == "delve_icon_box") {
			ed.insertContent('[delve_icon_box title="Delve" icon="wordpress" icon_position="top/left" background="#9CA4A9" color="#FFF"]'+delveDummyContent+'[/delve_icon_box]');
		}
		
		if(id == "delve_pie_progress") {
			ed.insertContent('[delve_pie_progress label="delve" icon="" bar_color="#1abc9c" inner_bg="" per_color="" color="#33353e" target_value="85" size="2"]');
		}
		
		if(id == "delve_contact_info") {
			ed.insertContent('[delve_contact_info title="Contact Information"] <h6> BUSINESS HOURS </h6>Our support Hotline is available 24 Hours a day: (0) 123 456 789<br />Monday-Friday : 8am to 6pm<br />Saturday : 10am to 2pm<br />Sunday : Closed<h6>BUILDING ADDRESS</h6>Here, You Can add your office/building Address...<h6>EMAIL</h6><ul><li><a href="mailto:yourmail@domain.com">yourmail@domain.com</a></li><li><a href="mailto:yourmail@domain.com">yourmail@domain.com</a></li></ul><h6>CELLPHONE</h6>+0 123 456 789.[/delve_contact_info]');
		}
		
		if(id == "delve_counter_box") {
			ed.insertContent('[delve_counter_box title="delve" color="#1abc9c" number="1,234,567"]');
		}
		
		if(id == "delve_recent_post") {
			ed.insertContent('[delve_recent_post post_type="post" category="" no_of_post="6" column="3" show_title="yes/no" show_excerpt="yes/no" class="" style=""]');
		}
		
		if(id == "delve_slider") {
			ed.insertContent('[delve_slider type="basic/thumbnail" animation="fade/slide" border="yes/no"][delve_slide url="" link=""][delve_slide url="" link=""][/delve_slider]');
		}
		
		if(id == "delve_magazine_style") {
			ed.insertContent('[delve_magazine_style post_type="post" category="" no_of_post="4" show_first_large="yes/no" large_post_on="left /top"]');
		}
		
		if(id == "delve_ourteam") {
			ed.insertContent('[delve_ourteam column="4" show_members="-1"]');
		}
		
		if(id == "delve_testimonial_slider") {
			ed.insertContent('[delve_testimonial_slider no_of_testimonials="-1" img_position="top/left"]');
		}
		
		if(id == "delve_skillbar") {
			ed.insertContent('[delve_skillbar title="Delve" percentage="80%" background="#1abc9c"]');
		}
		
		if(id == "delve_pricing_table") {
			ed.insertContent('[delve_pricing_table title="STANDARD" price="199" per="month" btn_color="" btn_text="BUY NOW" btn_text_color="" btn_src="" featured="no"]<ul><li>First Item</li></ul>[/delve_pricing_table]');
		}
		
		if(id == "delve_testimonials"){
			ed.insertContent('[delve_testimonials category="" column="2" per_page="4" class="" style=""]');
		}
		
		if( id == "delve_gallery" ) {
			ed.insertContent('[delve_gallery category="" effect="1 to 10" per_page="-1"]');
		}
		
	return false;
	}
})();
