(function() {	
	tinymce.create('tinymce.plugins.delveShortcodeMce', {
		init : function(ed, url){
			tinymce.plugins.delveShortcodeMce.theurl = url;
		},
		createControl : function(btn, e) {
			if ( btn == "delve_shortcodes_button" ) {
				var a = this;	
				var btn = e.createSplitButton('delve_button', {
	                title: "Insert Shortcode",
					image: tinymce.plugins.delveShortcodeMce.theurl +"/shortcodes.png",
					icons: false,
	            });
	            btn.onRenderMenu.add(function (c, b) {
					
					b.add({title : 'delve Shortcodes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					
					// Columns
					c = b.addMenu({title:"Boxes"});
				
						a.render( c, "Icon Box", "delve_icon_box" );
						a.render( c, "Pie Progress", "delve_pie_progress" );
						a.render( c, "Contact Info", "delve_contact_info" );
						a.render( c, "Counter Box", "delve_counter_box" );
						a.render( c, "Recent Posts", "delve_recent_post" );
						a.render( c, "Magazine Style Posts", "delve_magazine_style" );
						a.render( c, "Delve Slider", "delve_slider" );
						a.render( c, "Ourteam", "delve_ourteam" );
						a.render( c, "Testimonials", "delve_testimonials");
						a.render( c, "Testimonial Slider", "delve_testimonial_slider" );
						a.render( c, "Skillbar", "delve_ourteam" );
						a.render( c, "Pricing Table", "delve_pricing_table");
						a.render( c, "Gallery", "delve_gallery" );
					b.addSeparator();
					
				});
	            
	          return btn;
			}
			return null;               
		},
		render : function(ed, title, id) {
			ed.add({
				title: title,
				onclick: function () {
					
					// Selected content
					var mceSelected = tinyMCE.activeEditor.selection.getContent();
					
					// Add highlighted content inside the shortcode when possible - yay!
					if ( mceSelected ) {
						var delveDummyContent = mceSelected;
					} else {
						var delveDummyContent = 'Your content goes here...';
					}
					
					// 
					if(id == "delve_icon_box") {
						tinyMCE.activeEditor.selection.setContent('[delve_icon_box title="Delve" icon_position="top/left" icon="wordpress" background="#9CA4A9" color="#FFF"]'+delveDummyContent+'[/delve_icon_box]');
					}
					
					if(id == "delve_pie_progress") {
						tinyMCE.activeEditor.selection.setContent('[delve_pie_progress label="delve" icon="" bar_color="#1abc9c" inner_bg="" per_color="" color="#33353e" target_value="85" size="2"]');
					}
					
					if(id == "delve_contact_info") {
						tinyMCE.activeEditor.selection.setContent('[delve_contact_info title="Contact Information"] <h6> BUSINESS HOURS </h6>Our support Hotline is available 24 Hours a day: (0) 123 456 789<br />Monday-Friday : 8am to 6pm<br />Saturday : 10am to 2pm<br />Sunday : Closed<h6>BUILDING ADDRESS</h6>Here, You Can add your office/building Address...<h6>EMAIL</h6><ul><li><a href="mailto:yourmail@domain.com">yourmail@domain.com</a></li><li><a href="mailto:yourmail@domain.com">yourmail@domain.com</a></li></ul><h6>CELLPHONE</h6>+0 123 456 789.[/delve_contact_info]');
					}
					
					if(id == "delve_counter_box") {
		  				tinyMCE.activeEditor.selection.setContent('[delve_counter_box title="delve" color="#1abc9c" number="1,234,567"]');
					}
					
					if(id == "delve_recent_post" ) {
						tinyMCE.activeEditor.selection.setContent('[delve_recent_post post_type="post" category="" no_of_post="6" column="3" show_title="yes/no" show_excerpt="yes/no" class="" style=""]');
					}
					
					if(id == "delve_slider" ) {
						tinyMCE.activeEditor.selection.setContent('[delve_slider type="basic/thumbnail" animation="fade/slide" border="yes/no"][delve_slide url="" link=""][delve_slide url="" link=""][/delve_slider]');
					}
					
					if(id == "delve_magazine_style" ) {
						tinyMCE.activeEditor.selection.setContent('[delve_magazine_style post_type="post" category="" no_of_post="4" show_first_large="yes/no" large_post_on="left /top"]');
					}
					
					if(id == "delve_ourteam") {
						tinyMCE.activeEditor.selection.setContent('[delve_ourteam column="4" show_members="-1"]');
					}
					
					if(id == "delve_testimonial_slider") {
						tinyMCE.activeEditor.selection.setContent('[delve_testimonial_slider no_of_testimonials="-1" img_position="top/left"]');
					}
					
					if(id == "delve_skillbar") {
						tinyMCE.activeEditor.selection.setContent('[delve_skillbar title="Delve" percentage="80%" background="#1abc9c"]');
					}
					
					if(id == "delve_pricing_table") {
						tinyMCE.activeEditor.selection.setContent('[delve_pricing_table title="STANDARD" price="199" per="month" btn_color="" btn_text="BUY NOW" btn_text_color="" btn_src="" featured="no"]<ul><li>First Item</li></ul>[/delve_pricing_table]');
					}
					
					if(id == "delve_testimonials") {
						tinyMCE.activeEditor.selection.setContent('[delve_testimonials category="" column="2" per_page="4" class="" style=""]');
					}
					
					if(id == "delve_gallery") {
						tinyMCE.activeEditor.selection.setContent('[delve_gallery category="" effect="1 to 10" per_page="-1"]');
					}

					return false;
				}
			})
		}
	});
	tinymce.PluginManager.add("delve_shortcodes", tinymce.plugins.delveShortcodeMce);
})();