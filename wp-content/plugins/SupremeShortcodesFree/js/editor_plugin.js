(function() {
	var preview = true;
	var themeShortcuts = {
		
		insert: function(where) {
	
			switch(where) {
				case 'st_button_more':
					var href = jQuery("#btn_more_src").val();
					var what = '[st_button_more href="'+href+'"]';
					break;
				case 'st_button':
					var text = jQuery("#text").val();
					var text_color = jQuery("#color").val();
					var link = jQuery("#link").val();
					var bg = jQuery("#bg").val();
					var size = jQuery("#size").val();
					var icon = jQuery("#name").val();
					var target = jQuery("#target").val();
					var border_radius = jQuery("#border_radius").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = '[st_button text_color="'+text_color+'" link="'+link+'" background="'+bg+'" size="'+size+'" target="'+target+'" icon="'+icon+'" icon_spin="'+icon_spin+'" border_radius="'+border_radius+'"]'+text+'[/st_button]';
					break;
				case 'st_unordered':
					var list = '<li>First list item</li>';
					var listicon = jQuery("#listicon").val();
					var what = '[st_unordered listicon="'+listicon+'"]'+list+'[/st_unordered]';
					break;	
				case 'st_box':
					var title = jQuery("#box_title").val();
					var text = jQuery("#text").val();
					var type = jQuery("#box_type").val();
					var what = '[st_box title="'+title+'" type="'+type+'"]'+text+'[/st_box]';
					break;		
				case 'st_tables':
					var colsEl = jQuery("#cols");
					var rowsEl = jQuery("#rows");
					var cols = new Array();
					var rows = new Array();
					for(var i=0; i<jQuery(rowsEl).val(); i++) {
						for(var j=0; j<jQuery(colsEl).val(); j++) {
							if(i == 0) {
								cols.push(jQuery('#input_'+i+''+j).val());
							} else if (i == 1) {
								rows.push(jQuery('#input_'+i+''+j).val());
								j = jQuery(colsEl).val();
							} else {
								rows.push(jQuery('#input_'+i+''+j).val());
							}
						}
					}
					var what = '[st_table cols="'+cols.join('||')+'" data="'+rows.join('||')+'"]';
					break;
				case 'st_tabs':
					var tabs = '';
					var boxes = jQuery(".box");
					boxes.splice(0,1);
					
					jQuery(boxes).each(function() {
						var title = jQuery(this).find('input').val();
						var text = jQuery(this).find('textarea').val();
						tabs += '[st_tab title="'+title+'"]'+text+'[/st_tab]';
					});
					var what = '[st_tabs]'+tabs+'[/st_tabs]';
					break;
				case 'st_toggle':
					var accs = '';
					var boxes = jQuery(".box");
					jQuery(boxes).each(function() {
						var title = jQuery(this).find('input').val();
						var text = jQuery(this).find('textarea').val();
						var state = jQuery(this).find('select').val();
						accs += '[st_panel title="'+title+'" state="'+state+'"]'+text+'[/st_panel]<br />';
					});
					var what = '[st_toggle]<br />'+accs+'[/st_toggle]';
					break;
				case 'st_progress_bar':
					var width = jQuery("#width").val();
					var style = jQuery("#style").val();
					var striped = jQuery("#striped").val();
					var active = jQuery("#active").val();
					var what = '[st_progress_bar width="'+width+'" style="'+style+'" striped="'+striped+'" active="'+active+'"]';
					break;
				case 'st_highlight':
					var background_color = jQuery("#background_color").val();
					var text_color = jQuery("#text_color").val();
					var what = '[st_highlight background_color="'+background_color+'" text_color="'+text_color+'"]Highlighted text[/st_highlight]';
					break;
				case 'st_twitter':
					var style = jQuery("#style").val();
					var url = jQuery("#url").val();
					var sourceVal = jQuery("#source").val();
					var related = jQuery("#related").val();
					var text = jQuery("#text").val();
					var lang = jQuery("#lang").val();
					var what = '[st_twitter style="'+style+'" url="'+url+'" source="'+sourceVal+'" related="'+related+'" text="'+text+'" lang="'+lang+'"]';
					break;
				case 'st_digg':
					var style = jQuery("#style").val();
					var link = jQuery("#digg_link").val();
					var title = jQuery("#digg_title").val();
					var what = '[st_digg style="'+style+'" title="'+title+'" link="'+link+'"]';
					break;
				case 'st_fblike':
					var style = jQuery("#style").val();
					var url = jQuery("#url").val();
					var show_faces = jQuery("#show_faces").val();
					var width = jQuery("#width").val();
					var verb = jQuery("#verb_to_display").val();
					var font = jQuery("#font").val();
					var what = '[st_fblike url="'+url+'" style="'+style+'" showfaces="'+show_faces+'" width="'+width+'" verb="'+verb+'" font="'+font+'"]';
					break;
				case 'st_fbshare':
					var url = jQuery("#link").val();
					var what = '[st_fbshare url="'+url+'"]';
					break;
				case 'st_lishare':
					var style = jQuery("#style").val();
					var url = jQuery("#link").val();
					var sourceVal = jQuery("#source").val();
					var related = jQuery("#related").val();
					var text = jQuery("#text").val();
					var lang = jQuery("#lang").val();
					var what = '[st_linkedin_share url="'+url+'" style="'+style+'"]';
					break;
				case 'st_gplus':
					var style = jQuery("#style").val();
					var size = jQuery("#size").val();
					var what = '[st_gplus style="'+style+'" size="'+size+'"]';
					break;
				case 'st_pinterest_pin':
					var style = jQuery("#style").val();
					var what = '[st_pinterest_pin style="'+style+'"]';
					break;
				case 'st_tumblr':
					var style = jQuery("#style").val();
					var what = '[st_tumblr style="'+style+'"]';
					break;
				case 'st_gmap':
					var additional = '';

					additional = (jQuery("#latitude").val() != '') ? additional + ' latitude="'+ jQuery("#latitude").val() +'"' : additional;
					additional = (jQuery("#longitute").val() != '') ? additional + ' longitute="'+ jQuery("#longitute").val() +'"' : additional;
					additional = (jQuery("#html").val() != '') ? additional + ' html="'+ jQuery("#html").val() +'"' : additional;
					additional = (jQuery("#zoom").val() != '') ? additional + ' zoom="'+ jQuery("#zoom").val() +'"' : additional;
					additional = (jQuery("#gheight").val() != '') ? additional + ' height="'+ jQuery("#gheight").val() +'"' : additional;
					additional = (jQuery("#gwidth").val() != '') ? additional + ' width="'+ jQuery("#gwidth").val() +'"' : additional;
					additional = (jQuery("#maptype").val() != '') ? additional + ' maptype="'+ jQuery("#maptype").val() +'"' : additional;
					additional = (jQuery("#color").val() != '') ? additional + ' color="'+ jQuery("#color").val() +'"' : additional;

					var what = '[st_gmap '+additional+']';
					break;
				case 'st_trends':
					var width = jQuery("#width").val();
					var height = jQuery("#height").val();
					var query = jQuery("#query").val();
					var geo = jQuery("#geo").val();
					var what = '[st_trends width="'+width+'" height="'+height+'" query="'+query+'" geo="'+geo+'"]';
					break;
				case 'st_children':
					var parent = jQuery("#page").val();
					var what = "[st_children of='"+ parent +"']";
					break;
				case 'st_contact_form_light':
					var email_l = jQuery("#email_l").val();
					var what = "[st_contact_form_light email='"+ email_l +"']";
					break;
				case 'st_video':
					var title = jQuery("#video_title").val();
					var display = jQuery("#display").val();
					var width = jQuery("#width").val();
					var height = jQuery("#height").val();
					var type = jQuery("#video_type").val();
					var src = jQuery("#clip_id").val();
					var what = "[st_video title='"+title+"' type='"+ type +"' width='"+width+"' height='"+height+"' src='"+src+"']";
					var group = jQuery("#group").val();
					var title = jQuery("#title_lb").val();
					break;
				case 'st_audio':
					var title = jQuery("#audio_title").val();
					var src = jQuery("#audio_src").val();
					var what = "[st_audio title='"+title+"' src='"+src+"']";
					break;
				case 'st_soundcloud':
					var src = jQuery("#sound_src").val();
					var color = jQuery("#sound_color").val();
					var what = "[st_soundcloud color='"+color+"' src='"+src+"']";
					break;
				case 'st_mixcloud':
					var src = jQuery("#mix_src").val();
					var width = jQuery("#mix_width").val();
					var height = jQuery("#mix_height").val();
					var what = "[st_mixcloud width='"+width+"' height='"+height+"' src='"+src+"']";
					break;
				case 'st_icon':
					var name = jQuery("#name").val();
					var size = jQuery("#size").val();
					var type = jQuery("#icon_type").val();
					var color = jQuery("#icon_color").val();
					var bg_color = jQuery("#icon_bg_color").val();
					var border_color = jQuery("#icon_border_color").val();
					var align = jQuery("#align").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = "[st_icon name='"+name+"' size='"+size+"' color='"+color+"' type='"+type+"' background='"+bg_color+"' border_color='"+border_color+"' align='"+align+"' icon_spin='"+icon_spin+"']";
					break;
			}
			if(this.validate()) {

				if(preview === true) {
					var values = {
						'data': what
					};
					
					jQuery.ajax({
						url: stPluginUrl + '/ajaxPlugin.php?act=preview',
						type: 'POST',
						data: values,
						loading: function() {
							jQuery("#previewDiv").empty().html('<div class="loading">&nbsp;</div>')
						},
						success: function(response) {
							jQuery("#previewDiv").empty().html(response);
						}
					});
				} else {
					tinyMCE.activeEditor.execCommand('mceInsertContent', 0, what);
				}
			}
		},
		validate: function() {
			ret = true;
			jQuery('.req').each(function() {
				if(jQuery(this).find('input').val() == '') {
					ret = false;
					jQuery(this).find('input').addClass('errorInput');
				} else {
					jQuery(this).find('input').removeClass('errorInput');
				}
				if(jQuery(this).find('textarea').val() == '') {
					ret = false;
					jQuery(this).find('textarea').addClass('errorInput');
				} else {
					jQuery(this).find('textarea').removeClass('errorInput');
				}
			});
			return ret;
		},
		readMore: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=readMore&preview');
			what = 'st_button_more';
		},
		breakLine: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_break_line]");
		},
		horizontalLine: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_horizontal_line]");
		},
		divClear: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_clear]");
		},
		createDividerDotted: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_divider_dotted]");
		},
		createDividerDashed: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_divider_dashed]");
		},
		createDividerTop: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_divider_top]");
		},
		createDividerShadow: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_divider_shadow]");
		},
		insertButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertButton&preview');
			what = 'st_button';
		},
		insertBox: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertBox&preview');
			what = 'st_box';
		},
		createTabs: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=createTabs&preview=remove');
			what = 'st_tabs';
		},
		createUnorderedList: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=createUnorderedList&preview');
			what = 'st_unordered';
		},
		createOrderedList: function() {
			var content = (tinyMCE.activeEditor.selection.getContent() != '') ? tinyMCE.activeEditor.selection.getContent() : '<ol><li>First list item</li></ol>';
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_ordered]"+ content +"[/st_ordered]");
		},
		createToggle: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=toggle&preview=remove');
			what = 'st_toggle';
		},
		createProgressBar: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=progress_bar&preview');
			what = 'st_progress_bar';
		},
		createTables: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=createTable&preview');
			what = 'st_tables';
		},
		dropCap: function(type) {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_dropcap type='"+type+"']"+ tinyMCE.activeEditor.selection.getContent() +"[/st_dropcap]");
		},
		highlight: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=highlight&preview');
			what = 'st_highlight';
		},
		labels: function(type) {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_label type='"+type+"']"+ tinyMCE.activeEditor.selection.getContent() +"[/st_label]");
		},
		createTwitterButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=twitter&preview');
			what = 'st_twitter';
		},
		createDiggButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=digg&preview');
			what = 'st_digg';
		},
		createFBlikeButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=fblike&preview');
			what = 'st_fblike';
		},
		createFBShareButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=fbshare&preview');
			what = 'st_fbshare';
		},
		createLIShareButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=lishare&preview=remove');
			what = 'st_lishare';
		},
		createGplusButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=gplus&preview');
			what = 'st_gplus';
		},
		createPinButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=pinterest_pin&preview');
			what = 'st_pinterest_pin';
		},
		createTumblrButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=tumblr&preview');
			what = 'st_tumblr';
		},
		createVideo: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=video&preview');
			what = 'st_video';
		},
		createAudio: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=audio&preview');
			what = 'st_audio';
		},
		createSoundcloud: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=soundcloud&preview');
			what = 'st_soundcloud';
		},
		createMixcloud: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=mixcloud&preview');
			what = 'st_mixcloud';
		},
		createContainer: function(){
			var currentVal = 'Put your content here';
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_container]"+ currentVal +"[/st_container]");
		},
		createRow: function(){
			var currentVal = 'Put your columns here';
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_row]"+ currentVal +"[/st_row]");
		},
		createColumnLayout: function(n) {
			var col = '';
			var values = {
				'st_column1': 'st_column1',
				'st_column2': 'st_column2',
				'st_column3': 'st_column3',
				'st_column4': 'st_column4',
				'st_column5': 'st_column5',
				'st_column6': 'st_column6',
				'st_column7': 'st_column7',
				'st_column8': 'st_column8',
				'st_column9': 'st_column9',
				'st_column10': 'st_column10',
				'st_column11': 'st_column11',
				'st_column12': 'st_column12',
			}
			col = values[n];
			var currentVal = 'Your content goes here';
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "["+col+"]"+ currentVal +"[/"+col+"]");
		},
		createGoogleMaps: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=gmap&preview=remove');
			what = 'st_gmap';
		},
		createGoogleTrends: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=trends&preview=remove');
			what = 'st_trends';
		},
		pageSiblings: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_siblings]");
		},
		children: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=children&preview');
			what = 'st_children';
		},
		contactFormLight: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=contact_form_light&preview');
			what = 'st_contact_form_light';
		},
		createIcon: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=icon&preview');
			what = 'st_icon';
		},
		createCode: function() {
			var currentVal = 'Put your code here';
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_code]"+ currentVal +"[/st_code]");
		}

	};

	var what = '';
	jQuery('#insert').live('click', function(e) {
		preview = false;
		e.preventDefault();
		themeShortcuts.insert(what);
		tb_remove();
		return false;
	});
	jQuery('#preview').live('click', function(e) {
		preview = true;
		e.preventDefault();
		themeShortcuts.insert(what);
		return false;
	});
	jQuery('#SupremeSocialTheme_preview input').live('blur', function() {
		preview = true;
		setTimeout(function() {
			themeShortcuts.insert(what);
		}, 300);
	});
	jQuery('#SupremeSocialTheme_preview select').live('change', function() {
		preview = true;
		setTimeout(function() {
			themeShortcuts.insert(what);
		}, 300);
	});
	jQuery('#cancel').live('click', function(e) {
		tb_remove();
		return false;
	});



	///////////////////////////////////////
	//	CHECK THE VERSION OF TINYMCE !!
	///////////////////////////////////////
	
	if (tinymce.majorVersion < 4) {
		
		//////////////////////////////
		//	IF IS TINYMCE VERSION 3
		//////////////////////////////
		tinymce.create('tinymce.plugins.themeShortcuts', {
			init: function(ed, url) {
				
			},
			
			createControl: function(n, cm) {
				switch (n) {
					case 'themeShortcuts':
						var c = cm.createSplitButton('themeShortcuts', {
							title : 'Theme shortcuts',
							image : stPluginUrl + '/images/supremetheme-logo-19x19.png',
							onclick : function() {
								c.showMenu();
							}
						});
						c.onRenderMenu.add(function(c,m) {
							
							e = m.addMenu({title : 'Lines'});
								e.add({title : 'Break Line', onclick : themeShortcuts.breakLine});
								e.add({title : 'Horizontal Line', onclick : themeShortcuts.horizontalLine});
								e.add({title : 'Clear', onclick : themeShortcuts.divClear});
								var ea = e.addMenu({title : 'Dividers'});
									ea.add({title : 'Dotted', onclick : themeShortcuts.createDividerDotted});
									ea.add({title : 'Dashed', onclick : themeShortcuts.createDividerDashed});
									ea.add({title : 'To Top', onclick : themeShortcuts.createDividerTop});
									ea.add({title : 'Shadow', onclick : themeShortcuts.createDividerShadow});

							b = m.addMenu({title : 'Buttons'});
								b.add({title : 'Button', onclick : function() { themeShortcuts.insertButton() }});
								b.add({title : 'Read More', onclick : themeShortcuts.readMore});
								var be = b.addMenu({title : 'Share Buttons'});
									be.add({title: 'Twitter', onclick : themeShortcuts.createTwitterButton});
									be.add({title: 'Digg', onclick : themeShortcuts.createDiggButton});
									be.add({title: 'Facebook Like', onclick : themeShortcuts.createFBlikeButton});
									be.add({title: 'Facebook Share', onclick : themeShortcuts.createFBShareButton});
									be.add({title: 'LinkedIn', onclick : themeShortcuts.createLIShareButton});
									be.add({title: 'Google+', onclick : themeShortcuts.createGplusButton});
									be.add({title: 'Pinterest', onclick : themeShortcuts.createPinButton});
									be.add({title: 'Tumbler', onclick : themeShortcuts.createTumblrButton});

							i = m.addMenu({title : 'Boxes'});
								i.add({title : 'Box', onclick : themeShortcuts.insertBox});

							p = m.addMenu({title : 'Icons'});
								p.add({title : 'Font Awesome', onclick : themeShortcuts.createIcon});

							s = m.addMenu({title : 'Elements'});
								s.add({title : 'Tabs', onclick : themeShortcuts.createTabs});
								s.add({title : 'Toggle', onclick : themeShortcuts.createToggle});
								s.add({title : 'Progress Bar', onclick : themeShortcuts.createProgressBar});

							m.add({title : 'Container', onclick : themeShortcuts.createContainer});					

							h = m.addMenu({title : 'Responsive'});
								h.add({title : 'Row', onclick : themeShortcuts.createRow});
								h.add({title: '1 column', onclick : function() { themeShortcuts.createColumnLayout('st_column1') }});
								h.add({title: '2 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column2') }});
								h.add({title: '3 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column3') }});
								h.add({title: '4 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column4') }});
								h.add({title: '5 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column5') }});
								h.add({title: '6 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column6') }});
								h.add({title: '7 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column7') }});
								h.add({title: '8 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column8') }});
								h.add({title: '9 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column9') }});
								h.add({title: '10 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column10') }});
								h.add({title: '11 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column11') }});
								h.add({title: '12 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column12') }});

							d = m.addMenu({title : 'Google'});
								d.add({title : 'Google Maps', onclick : themeShortcuts.createGoogleMaps});
								d.add({title : 'Google Trends', onclick : themeShortcuts.createGoogleTrends});

							f = m.addMenu({title: 'Lists'});
								f.add({title : 'Unordered list', onclick : themeShortcuts.createUnorderedList});
								f.add({title : 'Ordered list', onclick : themeShortcuts.createOrderedList});

							o = m.addMenu({title: 'Tables'});
								o.add({title : 'Styled table', onclick : themeShortcuts.createTables});
							
							l = m.addMenu({title : 'Media'});
								l.add({title : 'Video', onclick : themeShortcuts.createVideo});
								var la = l.addMenu({title : 'Audio'});
									la.add({title : 'Soundcloud', onclick : themeShortcuts.createSoundcloud});
									la.add({title : 'Mixcloud', onclick : themeShortcuts.createMixcloud});

							d = m.addMenu({title: 'Typography'});
								var dc = d.addMenu({title : 'Dropcap'});
									dc.add({title : 'Light', onclick : function() { themeShortcuts.dropCap('light') }});
									dc.add({title : 'Light Circled', onclick : function() {themeShortcuts.dropCap('light_circled')}});
									dc.add({title : 'Dark', onclick : function() {themeShortcuts.dropCap('dark')}});
									dc.add({title : 'Dark Circled', onclick : function() {themeShortcuts.dropCap('dark_circled')}}); 
							d.add({title : 'Highlight', onclick : themeShortcuts.highlight});
								var df = d.addMenu({title: 'Label'});
									df.add({title : 'Default', onclick : function() { themeShortcuts.labels('default') }});
									df.add({title : 'New', onclick : function() {themeShortcuts.labels('success')}});
									df.add({title : 'Warning', onclick : function() {themeShortcuts.labels('warning')}});
									df.add({title : 'Important', onclick : function() {themeShortcuts.labels('important')}});
									df.add({title : 'Notice', onclick : function() {themeShortcuts.labels('notice')}});

							p = m.addMenu({title : 'Related'});
								p.add({title : 'Siblings', onclick : themeShortcuts.pageSiblings});
								p.add({title : 'Children', onclick : themeShortcuts.children});

							m.add({title : 'Contact form', onclick : themeShortcuts.contactFormLight});
							m.add({title : 'Code', onclick : themeShortcuts.createCode});
							
						});
					return c;
				}
				return null;
			},
		});

	}else{
		
		//////////////////////////////
		//	IF IS TINYMCE VERSION 4+
		//////////////////////////////
		tinymce.create('tinymce.plugins.themeShortcuts', {

			init : function(ed, url) {

				ed.addButton( 'themeShortcuts', {
	                type: 'listbox',
	                text: 'Supreme',
	                icon: 'supreme',
	                classes: 'mce-btn supreme-class',
	                tooltip: 'Supreme Shortcodes',
	                onselect: function(e) {
	                }, 
	                values: [

	                    { 
				            type: 'listbox', 
				            text: 'Lines',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{ text: 'Break Line', onclick : themeShortcuts.breakLine},
				            	{ text: 'Horizontal Line', onclick : themeShortcuts.horizontalLine},
				            	{ text: 'Clear', onclick : themeShortcuts.divClear},
				            	{ 
						            type: 'listbox', 
						            text: 'Dividers',
						            icon: false,
						            classes: 'has-dropdown',
						            values: [ 

						            	{ text: 'Dotted', onclick : function() {
						            		tinymce.execCommand('mceInsertContent', false, '[st_divider_dotted]');
						            	}},
						            	{ text: 'Dashed', onclick : function() {
						            		tinymce.execCommand('mceInsertContent', false, '[st_divider_dashed]');
						            	}},
						            	{ text: 'To Top', onclick : function() {
						            		tinymce.execCommand('mceInsertContent', false, '[st_divider_top]');
						            	}},
						            	{ text: 'Shadow', onclick : function() {
						            		tinymce.execCommand('mceInsertContent', false, '[st_divider_shadow]');
						            	}},

						            ]

						    	},

				            ]

				    	},

				    	{ 
				            type: 'listbox', 
				            text: 'Buttons',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Button', onclick : function() { themeShortcuts.insertButton() }},
			                    {text: 'Read more', onclick : themeShortcuts.readMore},
			                    { 
						            type: 'listbox', 
						            text: 'Share buttons',
						            icon: false,
						            classes: 'has-dropdown',
						            values: [ 

						            	{ text: 'Twitter', onclick : themeShortcuts.createTwitterButton},
						            	{ text: 'Digg', onclick : themeShortcuts.createDiggButton},
						            	{ text: 'Facebook Like', onclick : themeShortcuts.createFBlikeButton},
						            	{ text: 'Facebook Share', onclick : themeShortcuts.createFBShareButton},
						            	{ text: 'LinkedIn', onclick : themeShortcuts.createLIShareButton},
						            	{ text: 'Google+', onclick : themeShortcuts.createGplusButton},
						            	{ text: 'Pinterest', onclick : themeShortcuts.createPinButton},
						            	{ text: 'Tumbler', onclick : themeShortcuts.createTumblrButton},

						            ]

						    	},

				            ]

				    	},

	                    {classes: 'no-dropdown', text: 'Info Box', onclick : themeShortcuts.insertBox},
	                    {classes: 'no-dropdown', text: 'Font Awesome', onclick : themeShortcuts.createIcon},

	                    { 
				            type: 'listbox', 
				            text: 'Elements',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 
				            	{text: 'Tabs', onclick : themeShortcuts.createTabs},
				            	{text: 'Toggle', onclick : themeShortcuts.createToggle},
				            	{text: 'Progress Bar', onclick : themeShortcuts.createProgressBar},
				            ]

				    	},

				    	{classes: 'no-dropdown', text: 'Container', onclick : themeShortcuts.createContainer},
	                    
	                    { 
				            type: 'listbox', 
				            text: 'Responsive',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Row', onclick : themeShortcuts.createRow},
				            	{text: '1 column', onclick : function() { themeShortcuts.createColumnLayout('st_column1') }},
				            	{text: '2 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column2') }},
				            	{text: '3 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column3') }},
				            	{text: '4 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column4') }},
				            	{text: '5 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column5') }},
				            	{text: '6 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column6') }},
				            	{text: '7 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column7') }},
				            	{text: '8 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column8') }},
				            	{text: '9 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column9') }},
				            	{text: '10 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column10') }},
				            	{text: '11 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column11') }},
				            	{text: '12 columns', onclick : function() { themeShortcuts.createColumnLayout('st_column12') }},

				            ]

				    	},
				    	
	                    { 
				            type: 'listbox', 
				            text: 'Google',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Google Maps', onclick : themeShortcuts.createGoogleMaps},
				            	{text: 'Google Trends', onclick : themeShortcuts.createGoogleTrends},

				            ]

				    	},

	                    { 
				            type: 'listbox', 
				            text: 'Lists',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Unordered list', onclick : themeShortcuts.createUnorderedList},
				            	{text: 'Ordered list', onclick : themeShortcuts.createOrderedList},

				            ]

				    	},

				    	{classes: 'no-dropdown', text: 'Styled table', onclick : themeShortcuts.createTables},

	                    { 
				            type: 'listbox', 
				            text: 'Media',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Video', onclick : themeShortcuts.createVideo},
				            	{ 
						            type: 'listbox', 
						            text: 'Audio',
						            icon: false,
						            classes: 'has-dropdown',
						            values: [ 

						            	{text: 'Soundcloud', onclick : themeShortcuts.createSoundcloud},
						            	{text: 'Mixcloud', onclick : themeShortcuts.createMixcloud},

						            ]

						    	},

				            ]

				    	},

	                    { 
				            type: 'listbox', 
				            text: 'Typography',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [

				            	{ 
						            type: 'listbox', 
						            text: 'Dropcap',
						            icon: false,
						            values: [ 

						            	{text: 'Light', onclick : function() {themeShortcuts.dropCap('light')}},
						            	{text: 'Light Circled', onclick : function() {themeShortcuts.dropCap('light_circled')}},
						            	{text: 'Dark', onclick : function() {themeShortcuts.dropCap('dark')}},
						            	{text: 'Dark Circled', onclick : function() {themeShortcuts.dropCap('dark_circled')}},

						            ]

						    	},
						    	{text: 'Highlight', onclick : themeShortcuts.highlight},
						    	{ 
						            type: 'listbox', 
						            text: 'Label',
						            icon: false,
						            classes: 'has-dropdown',
						            values: [ 

						            	{text: 'Default', onclick : function() { themeShortcuts.labels('default') }},
						            	{text: 'New', onclick : function() { themeShortcuts.labels('success') }},
						            	{text: 'Warning', onclick : function() { themeShortcuts.labels('warning') }},
						            	{text: 'Important', onclick : function() { themeShortcuts.labels('important') }},
						            	{text: 'Notice', onclick : function() { themeShortcuts.labels('notice') }},

						            ]

						    	},
				            ]

				    	},

	                    { 
				            type: 'listbox', 
				            text: 'Related',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Siblings', onclick : themeShortcuts.pageSiblings},
				            	{text: 'Children', onclick : themeShortcuts.children},

				            ]

				    	},

				    	{classes: 'no-dropdown', text: 'Contact form', onclick : themeShortcuts.contactFormLight},
				    	{classes: 'no-dropdown', text: 'Code', onclick : themeShortcuts.createCode},

	                ]
	     
	            });		

			},


		});


	};//end else

	
	tinymce.PluginManager.add('themeShortcuts', tinymce.plugins.themeShortcuts);
})()