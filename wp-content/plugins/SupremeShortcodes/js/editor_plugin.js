(function() {
	var preview = true;
	var themeShortcuts = {
		
		insert: function(where) {
	
			switch(where) {
				case 'st_img_scroller':
					var img = jQuery("#img_url").val();
					var border = jQuery("#border_thickness").val();
					var border_color = jQuery("#img_border_color").val();
					var height = jQuery("#img_height").val();
					var speed = jQuery("#img_speed").val();
					var what = '[st_img_scroller img="'+img+'" border="'+border+'" border_color="'+border_color+'" height="'+height+'" speed="'+speed+'"]';
					break;
				case 'st_button_more':
					var href = jQuery("#btn_more_src").val();
					var what = '[st_button_more href="'+href+'"]';
					break;
				case 'st_button':
					var text = jQuery("#text").val();
					var text_color = jQuery("#color").val();
					var link = jQuery("#link1").val();
					var bg = jQuery("#bg").val();
					var size = jQuery("#size").val();
					var icon = jQuery("#name").val();
					var target = jQuery("#target").val();
					var border_radius = jQuery("#border_radius").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = '[st_button text_color="'+text_color+'" link="'+link+'" background="'+bg+'" size="'+size+'" target="'+target+'" icon="'+icon+'" icon_spin="'+icon_spin+'" border_radius="'+border_radius+'"]'+text+'[/st_button]';
					break;
				case 'st_hover_fill_button':
					var text = jQuery("#text").val();
					var text_color = jQuery("#color").val();
					var link = jQuery("#link2").val();
					var bg = jQuery("#bg").val();
					var hover_bg = jQuery("#hover_bg").val();
					var size = jQuery("#size").val();
					var icon = jQuery("#name").val();
					var target = jQuery("#target").val();
					var hover_direction = jQuery("#hover_direction").val();
					var border_radius = jQuery("#border_radius").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = '[st_hover_fill_button text_color="'+text_color+'" link="'+link+'" background="'+bg+'" hover_background="'+hover_bg+'" size="'+size+'" target="'+target+'" icon="'+icon+'" icon_spin="'+icon_spin+'" border_radius="'+border_radius+'" hover_direction="'+hover_direction+'"]'+text+'[/st_hover_fill_button]';
					break;
				case 'st_hover_fancy_icon_button':
					var text = jQuery("#text").val();
					var text_color = jQuery("#color").val();
					var link = jQuery("#link3").val();
					var bg = jQuery("#bg").val();
					var size = jQuery("#size").val();
					var icon = jQuery("#name").val();
					var icon_color = jQuery("#icon_color").val();
					var icon_bg = jQuery("#icon_bg").val();
					var target = jQuery("#target").val();
					var icon_position = jQuery("#icon_pos").val();
					var icon_separator = jQuery("#icon_sep").val();
					var border_radius = jQuery("#border_radius").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = '[st_hover_fancy_icon_button text_color="'+text_color+'" link="'+link+'" background="'+bg+'" size="'+size+'" target="'+target+'" icon="'+icon+'" icon_spin="'+icon_spin+'" icon_color="'+icon_color+'" icon_background="'+icon_bg+'" icon_position="'+icon_position+'" icon_separator="'+icon_separator+'" border_radius="'+border_radius+'"]'+text+'[/st_hover_fancy_icon_button]';
					break;
				case 'st_hover_arrows_button':
					var text = jQuery("#text").val();
					var text_color = jQuery("#color").val();
					var link = jQuery("#link4").val();
					var bg = jQuery("#bg").val();
					var size = jQuery("#size").val();
					var icon = jQuery("#name").val();
					var target = jQuery("#target").val();
					var border_radius = jQuery("#border_radius").val();
					var arrow_direction = jQuery("#arrow_direction").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = '[st_hover_arrows_button text_color="'+text_color+'" link="'+link+'" background="'+bg+'" size="'+size+'" target="'+target+'" icon="'+icon+'" icon_spin="'+icon_spin+'" border_radius="'+border_radius+'" arrow_direction="'+arrow_direction+'"]'+text+'[/st_hover_arrows_button]';
					break;
				case 'st_hover_icon_button':
					var text = jQuery("#text").val();
					var text_color = jQuery("#color").val();
					var link = jQuery("#link5").val();
					var bg = jQuery("#bg").val();
					var size = jQuery("#size").val();
					var icon = jQuery("#name").val();
					var target = jQuery("#target").val();
					var border_radius = jQuery("#border_radius").val();
					var icon_direction = jQuery("#icon_direction").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = '[st_hover_icon_button text_color="'+text_color+'" link="'+link+'" background="'+bg+'" size="'+size+'" target="'+target+'" icon="'+icon+'" icon_spin="'+icon_spin+'" icon_direction="'+icon_direction+'" border_radius="'+border_radius+'"]'+text+'[/st_hover_icon_button]';
					break;
				case 'st_hover_bordered_button':
					var text = jQuery("#text").val();
					var text_color = jQuery("#color").val();
					var link = jQuery("#link6").val();
					var bg = jQuery("#bg").val();
					var size = jQuery("#size").val();
					var icon = jQuery("#name").val();
					var target = jQuery("#target").val();
					var border_type = jQuery("#border_type").val();
					var border_radius = jQuery("#border_radius").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = '[st_hover_bordered_button text_color="'+text_color+'" link="'+link+'" background="'+bg+'" size="'+size+'" target="'+target+'" icon="'+icon+'" icon_spin="'+icon_spin+'" border_radius="'+border_radius+'" border_type="'+border_type+'"]'+text+'[/st_hover_bordered_button]';
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
				case 'st_callout':
					var title = jQuery("#callout_title").val();
					var text = jQuery("#text").val();
					var btn_text = jQuery("#btn_text").val();
					var btn_link = jQuery("#btn_link").val();
					var text_color = jQuery("#color").val();
					var bg = jQuery("#bg").val();
					var what = '[st_callout title="'+title+'" button_text="'+btn_text+'" link="'+btn_link+'" text_color="'+text_color+'" background="'+bg+'"]'+text+'[/st_callout]';
					break;
				case 'st_tooltip':
					var text = jQuery("#text").val();
					var tooltip_text = jQuery("#tooltip_text").val();
					var type = jQuery("#tooltip_type").val();
					var what = '[st_tooltip type="'+type+'" tooltip_text="'+tooltip_text+'"]'+text+'[/st_tooltip]';
					break;
				case 'st_popover':
					var content = 'Your text here';
					var title = jQuery("#popover_title").val();
					var text = jQuery("#popover_text").val();
					var type = jQuery("#popover_type").val();
					var what = '[st_popover type="'+type+'" popover_title="'+title+'" text="'+text+'"]'+content+'[/st_popover]';
					break;
				case 'st_modal':
					var title = jQuery("#modal_title").val();
					var content = jQuery("#modal_text").val();
					var modal_link = jQuery("#modal_link").val();
					var primary_text = jQuery("#primary").val();
					var primary_link = jQuery("#primary_link").val();
					var what = '[st_modal modal_link="'+modal_link+'" primary_text="'+primary_text+'" primary_link="'+primary_link+'" modal_title="'+title+'"]'+content+'[/st_modal]';
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
				case 'st_accordion':
					var accs = '';
					var boxes = jQuery(".box");
					jQuery(boxes).each(function() {
						var title = jQuery(this).find('input').val();
						var text = jQuery(this).find('textarea').val();
						var state = jQuery(this).find('select').val();
						accs += '[st_acc_panel title="'+title+'" state="'+state+'"]'+text+'[/st_acc_panel]<br />';
					});
					var what = '[st_accordion]<br />'+accs+'[/st_accordion]';
					break;
				case 'st_progress_bar':
					var width = jQuery("#width").val();
					var style = jQuery("#style").val();
					var striped = jQuery("#striped").val();
					var active = jQuery("#active").val();
					var what = '[st_progress_bar width="'+width+'" style="'+style+'" striped="'+striped+'" active="'+active+'"]';
					break;
				case 'st_related_posts':
					var limit = jQuery("#limit").val();
					var what = '[st_related_posts limit="'+limit+'"]';
					break;
				case 'st_highlight':
					var background_color = jQuery("#background_color").val();
					var text_color = jQuery("#text_color").val();
					var what = '[st_highlight background_color="'+background_color+'" text_color="'+text_color+'"]Highlighted text[/st_highlight]';
					break;
				case 'st_loginout':
					var text_col = jQuery("#color").val();
					var bg = jQuery("#bg").val();
					var size = jQuery("#size").val();
					var type = jQuery("#login_type").val();
					var target = jQuery("#target").val();
					var login_msg = jQuery("#login_msg").val();
					var logout_msg = jQuery("#logout_msg").val();
					var what = '[st_loginout text_col="'+text_col+'" background="'+bg+'" size="'+size+'" login_msg="'+login_msg+'" logout_msg="'+logout_msg+'"]';
					break;
				case 'st_quote':
					var author = jQuery("#author-name").val();
					var content = jQuery("#text").val();
					var what = '[st_quote author="'+author+'"]' +content+ '[/st_quote]';
					break;
				case 'st_abbreviation':
					var text = jQuery("#text").val();
					var abbreviation = jQuery("#abbreviation").val();
					var what = '[st_abbr title="'+abbreviation+'"]' + text + '[/st_abbr]';
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
					var url = jQuery("#linkfb").val();
					var what = '[st_fbshare url="'+url+'"]';
					break;
				case 'st_lishare':
					var style = jQuery("#style").val();
					var url = jQuery("#linkli").val();
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
				case 'st_pricingTable':
					var content = '';
					var columns = jQuery("#columns").val();
					var highlighted = jQuery("#highlighted").val();
					for(x=0;x<columns;x++) {
						var highlight = ((x+1) == highlighted) ? " highlight='true'" : '';
						content += "\n[st_pricing_column title='Column " + (x+1) + "'" + highlight + "]\n[st_price_info cost='$14.99/month'][/st_price_info]<ul><li>Item description and details...</li>\n<li>Item description and details...</li>\n<li>Some more info...</li>\n<li>[st_button text_color='#444444' link='#' background='#E6E6E6' size='small' target='_blank' icon='none' icon_spin='no' border_radius='2px']Button text[/st_button]</li></ul>\n[/st_pricing_column]\n";
					}
					var what = "[st_pricing_table columns='"+columns+"']\n" + content + "\n[/st_pricing_table]";
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
				case 'st_gchart':
					var data = jQuery("#data").val();
					var title = jQuery("#g_title").val();
					var width = jQuery("#width").val();
					var height = jQuery("#height").val();
					var series_type = jQuery("#series_type").val();
					var vAxis = jQuery("#vAxis").val();
					var hAxis = jQuery("#hAxis").val();
					var type = jQuery("#gchart_type").val();

					var red_from = jQuery("#red_from").val();
					var red_to = jQuery("#red_to").val();
					var yellow_from = jQuery("#yellow_from").val();
					var yellow_to = jQuery("#yellow_to").val();
					var gauge_minor_ticks = jQuery("#gauge_minor_ticks").val();
					var what = '[st_chart title="'+title+'" data="'+data+'" width="'+width+'" height="'+height+'" type="'+type+'" series_type="'+series_type+'" vAxis="'+vAxis+'" hAxis="'+hAxis+'" red_from="'+red_from+'" red_to="'+red_to+'" yellow_from="'+yellow_from+'" yellow_to="'+yellow_to+'" gauge_minor_ticks="'+gauge_minor_ticks+'"]';
					break;
				case 'st_chart_pie':
					var data = jQuery("#data").val();
					var title = jQuery("#pie_title").val();
					var what = '[st_chart_pie title="'+title+'" data="'+data+'"]';
					break;
				case 'st_chart_bar':
					var data = jQuery("#data").val();
					var title = jQuery("#bar_title").val();
					var vaxis = jQuery("#vaxis_title").val();
					var haxis = jQuery("#haxis_title").val();
					var what = '[st_chart_bar title="'+title+'" data="'+data+'" vaxis="'+vaxis+'" haxis="'+haxis+'"]';
					break;
				case 'st_chart_area':
					var data = jQuery("#data").val();
					var title = jQuery("#area_title").val();
					var vaxis = jQuery("#vaxis_title").val();
					var haxis = jQuery("#haxis_title").val();
					var what = '[st_chart_area title="'+title+'" data="'+data+'" vaxis="'+vaxis+'" haxis="'+haxis+'"]';
					break;
				case 'st_chart_geo':
					var data = jQuery("#data").val();
					var title = jQuery("#geo_title").val();
					var primary = jQuery("#primary").val();
					var secondary = jQuery("#secondary").val();
					var what = '[st_chart_geo title="'+title+'" data="'+data+'" primary="'+primary+'" secondary="'+secondary+'"]';
					break;
				case 'st_chart_combo':
					var data = jQuery("#data").val();
					var title = jQuery("#combo_title").val();
					var vaxis = jQuery("#vaxis_title").val();
					var haxis = jQuery("#haxis_title").val();
					var series = jQuery("#series").val();
					var what = '[st_chart_combo title="'+title+'" data="'+data+'" vaxis="'+vaxis+'" haxis="'+haxis+'" series="'+series+'"]';
					break;
				case 'st_chart_org':
					var data = jQuery("#data").val();
					var what = '[st_chart_org data="'+data+'"]';
					break;
				case 'st_chart_bubble':
					var data = jQuery("#data").val();
					var title = jQuery("#bubble_title").val();
					var primary = jQuery("#primary").val();
					var secondary = jQuery("#secondary").val();
					var what = '[st_chart_bubble title="'+title+'" data="'+data+'" primary="'+primary+'" secondary="'+secondary+'"]';
					break;
				case 'st_gdocs':
					var url = jQuery("#url").val();
					var width = jQuery("#width").val();
					var height = jQuery("#height").val();
					var what = "[st_gdocs width='"+width+"' height='"+height+"' url='"+ url +"']";
					break;
				case 'st_children':
					var parent = jQuery("#page").val();
					var what = "[st_children of='"+ parent +"']";
					break;
				case 'st_contact_form_dark':
					var email_d = jQuery("#email_d").val();
					var what = "[st_contact_form_dark email='"+ email_d +"']";
					break;
				case 'st_contact_form_light':
					var email_l = jQuery("#email_l").val();
					var what = "[st_contact_form_light email='"+ email_l +"']";
					break;					
				case 'st_fancyboxImages':
					var href = jQuery("#href").val();
					var thumb = jQuery("#thumb").val();
					var thumb_width = jQuery("#thumb_width").val();
					var group = jQuery("#group").val();
					var title = jQuery("#title_lb").val();
					var what = "[st_fancyboxImages href='"+ href +"' thumb='"+thumb+"' thumb_width='"+thumb_width+"' group='"+group+"' title='"+title+"']";
					break;
				case 'st_fancyboxInline':
					var title = jQuery("#in_title").val();
					var content_title = jQuery("#content_title").val();
					var content = jQuery("#in_content").val();
					var what = "[st_fancyboxInline title='"+title+"' content_title='"+content_title+"' content='"+content+"']";
					break;
				case 'st_fancyboxIframe':
					var title = jQuery("#iframe_title").val();
					var href = jQuery("#iframe_href").val();
					var what = "[st_fancyboxIframe title='"+title+"' href='"+ href +"']";
					break;
				case 'st_fancyboxPage':
					var title = jQuery("#ipage_title").val();
					var href = jQuery("#ipage").val();
					var what = "[st_fancyboxPage title='"+title+"' href='"+ href +"']";
					break;
				case 'st_fancyboxSwf':
					var title = jQuery("#swf_title").val();
					var href = jQuery("#swf").val();
					var what = "[st_fancyboxSwf title='"+title+"' href='"+href+"']";
					break;
				case 'st_video':
					var title = jQuery("#video_title").val();
					var display = jQuery("#display").val();
					var width = jQuery("#width").val();
					var height = jQuery("#height").val();
					var type = jQuery("#video_type").val();

					if (type == 'flash') {
						var src = jQuery("#src").val();
						var what = "[st_video title='"+title+"' type='"+ type +"' width='"+width+"' height='"+height+"' src='"+src+"']";
					} else if (type == 'html5') {
						var poster = jQuery("#poster").val();
						var mp4 = jQuery("#mp4").val();
						var webm = jQuery("#webm").val();
						var ogg = jQuery("#ogg").val();
						var what = "[st_video title='"+title+"' type='"+ type +"' width='"+width+"' height='"+height+"' poster='"+poster+"' mp4='"+mp4+"' webm='"+webm+"' ogg='"+ogg+"']";
					} else {
						var src = jQuery("#clip_id").val();
						var what = "[st_video title='"+title+"' type='"+ type +"' width='"+width+"' height='"+height+"' src='"+src+"']";
					}
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
				case 'st_section_image':
					var image_id = jQuery("#imageid").val();
					var bg_color = jQuery("#bg_color").val();
					var type = jQuery("#section_image_type").val();
					var bg_position = jQuery("#bg_position").val();
					var bg_size = jQuery("#bg_size").val();
					var repeat = jQuery("#repeat").val();
					var padding = jQuery("#img_padding").val();
					var what = "[st_section_image image_id='"+image_id+"' bg_color='"+bg_color+"' type='"+type+"' position='"+bg_position+"' bg_size='"+bg_size+"' repeat='"+repeat+"' padding='"+padding+"']Section content goes here[/st_section_image]";
					break;
				case 'st_section_color':
					var color = jQuery("#color").val();
					var padding = jQuery("#col_padding").val();
					var what = "[st_section_color color='"+color+"' padding='"+padding+"']Section content goes here[/st_section_color]";
					break;
				case 'st_text_color':
					var color = jQuery("#color").val();
					var what = "[st_text_color color='"+color+"']Text goes here[/st_text_color]";
					break;
				case 'st_posts_carousel':
					var posts = jQuery("#posts").val();
					var number = jQuery("#number").val();
					var cat = jQuery("#cat").val();
					var display_title = jQuery("#display_title").val();
					var what = "[st_posts_carousel posts='"+posts+"' number='"+number+"' cat='"+cat+"' display_title='"+display_title+"']";
					break;
				case 'st_swiper':
					var posts = jQuery("#swiper_posts").val();
					var number = jQuery("#swiper_number").val();
					var category = jQuery("#category").val();
					var display_title = jQuery("#display_title").val();
					var what = "[st_swiper posts='"+posts+"' number='"+number+"' category='"+category+"' display_title='"+display_title+"']";
					break;
				case 'st_animated':
					var type = jQuery("#animated_type").val();
					var trigger = jQuery("#trigger").val();
					var precent = jQuery("#precent").val();
					var what = "[st_animated type='"+type+"' trigger='"+trigger+"' precent='"+precent+"']Animated element goes here[/st_animated]";
					break;
				case 'st_svg_drawing':
					var type = jQuery("#drawing_type").val();
					var image_id = jQuery("#image_id").val();
					var color = jQuery("#drawing_color").val();
					var what = "[st_svg_drawing type='"+type+"' image_id='"+image_id+"' color='"+color+"']";
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
				case 'st_icon_melon':
					var name = jQuery("#name").val();
					var size = jQuery("#size").val();
					var type = jQuery("#icon_type").val();
					var color = jQuery("#icon_color").val();
					var bg_color = jQuery("#icon_bg_color").val();
					var border_color = jQuery("#icon_border_color").val();
					var align = jQuery("#align").val();
					var what = "[st_icon_melon name='"+name+"' size='"+size+"' color='"+color+"' type='"+type+"' background='"+bg_color+"' border_color='"+border_color+"' align='"+align+"']";
					break;
				case 'st_social_icon':
					var name = jQuery("#name").val();
					var href = jQuery("#href").val();
					var target = jQuery("#target").val();
					var align = jQuery("#align").val();
					var what = "[st_social_icon name='"+name+"' href='"+href+"' target='"+target+"' align='"+align+"']";
					break;
				case 'st_divider_text':
					var type = jQuery("#divider_type").val();
					var text = jQuery("#text").val();
					var what = "[st_divider_text position='"+type+"' text='"+text+"']";
					break;
				case 'st_countdown':
					var id = jQuery("#event_id").val();
					var align = jQuery("#countdown_align").val();
					var what = "[st_countdown id='"+id+"' align='"+align+"']";
					break;
				case 'st_testimonials':
					var color = jQuery("#color").val();
					var number = jQuery("#number").val();
					var what = "[st_testimonials color='"+color+"' number='"+number+"']";
					break;
				case 'st_icon_box':
					var background = jQuery("#icon_box_bg").val();
					var opacity = jQuery("#bg_opacity").val();
					var border_color = jQuery("#border_color").val();
					var icon = jQuery("#name").val();
					var icon_color = jQuery("#icon_color").val();
					var icon_bg = jQuery("#icon_bg").val();
					var icon_pos = jQuery("#icon_pos").val();
					var icon_spin = jQuery("#icon_spin").val();
					var what = "[st_icon_box background='"+background+"' opacity='"+opacity+"' border_color='"+border_color+"' icon='"+icon+"' icon_color='"+icon_color+"' icon_bg='"+icon_bg+"' icon_position='"+icon_pos+"' icon_spin='"+icon_spin+"']Content goes here[/st_icon_box]";
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
		imgScroller: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=imgScroller&preview=remove');
			what = 'st_img_scroller';
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
		insertHoverFillButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertHoverFillButton&preview');
			what = 'st_hover_fill_button';
		},
		insertHoverFancyIconButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertHoverFancyIconButton&preview');
			what = 'st_hover_fancy_icon_button';
		},
		insertHoverArrowsButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertHoverArrowsButton&preview');
			what = 'st_hover_arrows_button';
		},
		insertHoverIconOnHoverButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertHoverIconOnHoverButton&preview');
			what = 'st_hover_icon_button';
		},
		insertHoverBorderedButton: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertHoverBorderedButton&preview');
			what = 'st_hover_bordered_button';
		},
		insertBox: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertBox&preview');
			what = 'st_box';
		},
		dividerText: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=dividerText&preview');
			what = 'st_divider_text';
		},
		eventCountdown: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=eventCountdown');
			what = 'st_countdown';
		},
		createTestimonials: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=testimonials');
			what = 'st_testimonials';
		},
		createIconBox: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=createIconBox&preview');
			what = 'st_icon_box';
		},
		insertCallout: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertCallout&preview');
			what = 'st_callout';
		},
		insertTooltip: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertTooltip&preview=remove');
			what = 'st_tooltip';
		},
		insertPopover: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertPopover&preview=remove');
			what = 'st_popover';
		},
		insertModal: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=insertModal&preview=remove');
			what = 'st_modal';
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
		createAccordion: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=createAccordion&preview=remove');
			what = 'st_accordion';
		},
		createProgressBar: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=progress_bar&preview');
			what = 'st_progress_bar';
		},
		createTables: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=createTable&preview');
			what = 'st_tables';
		},
		relatedPosts: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=related&preview=remove');
			what = 'st_related_posts';
		},
		logInOut: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=logInOut&preview');
			what = 'st_loginout';
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
		quote: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=quote&preview');
			what = 'st_quote';
		},
		abbreviation: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=abbreviation&preview');
			what = 'st_abbreviation';
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
		createSocialIcon: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=social_icon&preview');
			what = 'st_social_icon';
		},
		createPricingTables:  function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=pricingTable&preview');
			what = 'st_pricingTable';
		},
		createFancyboxImages: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=fancyboxImages&preview=remove');
			what = 'st_fancyboxImages';
		},
		createFancyboxInline: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=fancyboxInline&preview=remove');
			what = 'st_fancyboxInline';
		},
		createFancyboxIframe: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=fancyboxIframe&preview=remove');
			what = 'st_fancyboxIframe';
		},
		createFancyboxPage: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=fancyboxPage&preview=remove');
			what = 'st_fancyboxPage';
		},
		createFancyboxSwf: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=fancyboxSwf&preview=remove');
			what = 'st_fancyboxSwf';
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
		createSectionImage: function(){
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=section_image&preview=remove');
			what = 'st_section_image';
		},
		createSectionColor: function(){
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=section_color&preview=remove');
			what = 'st_section_color';
		},
		createContainer: function(){
			var currentVal = 'Put your content here';
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_container]"+ currentVal +"[/st_container]");
		},
		createTextColor: function(){
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=text_color&preview=remove');
			what = 'st_text_color';
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
		createChartPie: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=chart_pie&preview=remove');
			what = 'st_chart_pie';
		},
		createChartBar: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=chart_bar&preview=remove');
			what = 'st_chart_bar';
		},
		createChartArea: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=chart_area&preview=remove');
			what = 'st_chart_area';
		},
		createChartGeo: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=chart_geo&preview=remove');
			what = 'st_chart_geo';
		},
		createChartCombo: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=chart_combo&preview=remove');
			what = 'st_chart_combo';
		},
		createChartOrg: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=chart_org&preview=remove');
			what = 'st_chart_org';
		},
		createChartBubble: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=chart_bubble&preview=remove');
			what = 'st_chart_bubble';
		},
		createGoogleDocs: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=gdocs&preview=remove');
			what = 'st_gdocs';
		},
		pageSiblings: function() {
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[st_siblings]");
		},
		children: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=children&preview');
			what = 'st_children';
		},
		contactFormDark: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=contact_form_dark&preview');
			what = 'st_contact_form_dark';
		},
		contactFormLight: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=contact_form_light&preview');
			what = 'st_contact_form_light';
		},
		createCarousel: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=posts_carousel&preview=remove');
			what = 'st_posts_carousel';
		},
		createSwiper: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=swiper&preview=remove');
			what = 'st_swiper';
		},
		insertAnimated: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=animated&preview=remove');
			what = 'st_animated';
		},
		insertDrawing: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=svg_drawing&preview=remove');
			what = 'st_svg_drawing';
		},
		createIcon: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=icon&preview');
			what = 'st_icon';
		},
		createIconMelon: function() {
			tb_show('', stPluginUrl + '/ajaxPlugin.php?act=melonIcon&preview');
			what = 'st_icon_melon';
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
									ea.add({title : 'Text', onclick : themeShortcuts.dividerText});

							b = m.addMenu({title : 'Buttons'});
								b.add({title : 'Button', onclick : function() { themeShortcuts.insertButton() }});
								var ba = b.addMenu({title : 'Hover Buttons'});
									ba.add({title: 'Fill In', onclick : themeShortcuts.insertHoverFillButton});
									ba.add({title: 'Fancy Icon', onclick : themeShortcuts.insertHoverFancyIconButton});
									ba.add({title: 'Arrows', onclick : themeShortcuts.insertHoverArrowsButton});
									ba.add({title: 'Icon on hover', onclick : themeShortcuts.insertHoverIconOnHoverButton});
									ba.add({title: 'Bordered', onclick : themeShortcuts.insertHoverBorderedButton});
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
								b.add({title : 'Log in / out button', onclick : themeShortcuts.logInOut});

							i = m.addMenu({title : 'Boxes'});
								i.add({title : 'Box', onclick : themeShortcuts.insertBox});
								i.add({title : 'Callout', onclick : themeShortcuts.insertCallout});

							p = m.addMenu({title : 'Icons'});
								p.add({title : 'Font Awesome', onclick : themeShortcuts.createIcon});
								p.add({title : 'Icon Melon', onclick : themeShortcuts.createIconMelon});
								p.add({title : 'Social Icons', onclick : themeShortcuts.createSocialIcon});

							m.add({title : 'Icon Box', onclick : themeShortcuts.createIconBox});
							m.add({title : 'Image Scroller', onclick : themeShortcuts.imgScroller});
							m.add({title : 'Animated', onclick : themeShortcuts.insertAnimated});
							m.add({title : 'SVG Drawing', onclick : themeShortcuts.insertDrawing});

							s = m.addMenu({title : 'Elements'});
								s.add({title : 'Tooltip', onclick : themeShortcuts.insertTooltip});
								s.add({title : 'Popover', onclick : themeShortcuts.insertPopover});
								s.add({title : 'Modal', onclick : themeShortcuts.insertModal});
								s.add({title : 'Tabs', onclick : themeShortcuts.createTabs});
								s.add({title : 'Toggle', onclick : themeShortcuts.createToggle});
								s.add({title : 'Accordion', onclick : themeShortcuts.createAccordion});
								s.add({title : 'Progress Bar', onclick : themeShortcuts.createProgressBar});

							r = m.addMenu({title : 'Section'});
								r.add({title : 'Image', onclick : themeShortcuts.createSectionImage});
								r.add({title : 'Color', onclick : themeShortcuts.createSectionColor});
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
								d.add({title : 'Google Docs', onclick : themeShortcuts.createGoogleDocs});
								var da = d.addMenu({title : 'Google Charts'});
									da.add({title : 'Pie', onclick : themeShortcuts.createChartPie});
									da.add({title : 'Bar', onclick : themeShortcuts.createChartBar});
									da.add({title : 'Area', onclick : themeShortcuts.createChartArea});
									da.add({title : 'Geo', onclick : themeShortcuts.createChartGeo});
									da.add({title : 'Combo', onclick : themeShortcuts.createChartCombo});
									da.add({title : 'Org', onclick : themeShortcuts.createChartOrg});
									da.add({title : 'Bubble', onclick : themeShortcuts.createChartBubble});

							f = m.addMenu({title: 'Lists'});
								f.add({title : 'Unordered list', onclick : themeShortcuts.createUnorderedList});
								f.add({title : 'Ordered list', onclick : themeShortcuts.createOrderedList});

							o = m.addMenu({title: 'Tables'});
								o.add({title : 'Styled table', onclick : themeShortcuts.createTables});
								o.add({title : 'Pricing table', onclick : themeShortcuts.createPricingTables});
							
							l = m.addMenu({title : 'Media'});
								l.add({title : 'Video', onclick : themeShortcuts.createVideo});
								var la = l.addMenu({title : 'Audio'});
									la.add({title : 'Soundcloud', onclick : themeShortcuts.createSoundcloud});
									la.add({title : 'Mixcloud', onclick : themeShortcuts.createMixcloud});
									la.add({title : 'Other', onclick : themeShortcuts.createAudio});

							d = m.addMenu({title: 'Typography'});
								var dc = d.addMenu({title : 'Dropcap'});
									dc.add({title : 'Light', onclick : function() { themeShortcuts.dropCap('light') }});
									dc.add({title : 'Light Circled', onclick : function() {themeShortcuts.dropCap('light_circled')}});
									dc.add({title : 'Dark', onclick : function() {themeShortcuts.dropCap('dark')}});
									dc.add({title : 'Dark Circled', onclick : function() {themeShortcuts.dropCap('dark_circled')}}); 
							d.add({title : 'Quote', onclick : themeShortcuts.quote});
							d.add({title : 'Highlight', onclick : themeShortcuts.highlight});
								var df = d.addMenu({title: 'Label'});
									df.add({title : 'Default', onclick : function() { themeShortcuts.labels('default') }});
									df.add({title : 'New', onclick : function() {themeShortcuts.labels('success')}});
									df.add({title : 'Warning', onclick : function() {themeShortcuts.labels('warning')}});
									df.add({title : 'Important', onclick : function() {themeShortcuts.labels('important')}});
									df.add({title : 'Notice', onclick : function() {themeShortcuts.labels('notice')}});
							d.add({title : 'Colored Text', onclick : themeShortcuts.createTextColor});
							d.add({title : 'Abbreviation', onclick : themeShortcuts.abbreviation});

							p = m.addMenu({title : 'Related'});
								p.add({title : 'Related posts', onclick : themeShortcuts.relatedPosts});
								p.add({title : 'Siblings', onclick : themeShortcuts.pageSiblings});
								p.add({title : 'Children', onclick : themeShortcuts.children});

							k = m.addMenu({title : 'Fancybox'});
								k.add({title : 'Images', onclick : themeShortcuts.createFancyboxImages});
								k.add({title : 'Inline', onclick : themeShortcuts.createFancyboxInline});
								k.add({title : 'iFrame', onclick : themeShortcuts.createFancyboxIframe});
								k.add({title : 'Page', onclick : themeShortcuts.createFancyboxPage});
								k.add({title : 'Swf', onclick : themeShortcuts.createFancyboxSwf});

							j = m.addMenu({title : 'Contact form'});
								j.add({title : 'Light', onclick : themeShortcuts.contactFormLight});
								j.add({title : 'Dark', onclick : themeShortcuts.contactFormDark});

							t = m.addMenu({title : 'Carousel'});
								t.add({title : 'Post Carousel', onclick : themeShortcuts.createCarousel});
								t.add({title : 'Swiper', onclick : themeShortcuts.createSwiper});
								//t.add({title : 'Testimonial', onclick : themeShortcuts.createTestimonials});
							
							//m.add({title : 'Countdown', onclick : themeShortcuts.eventCountdown});
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
						            	{text: 'Text', onclick : function() {
					                        tb_show('', stPluginUrl + '/ajaxPlugin.php?act=dividerText&preview');
											what = 'st_divider_text';
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
				            	{ 
						            type: 'listbox', 
						            text: 'Hover Button',
						            icon: false,
						            classes: 'has-dropdown',
						            values: [ 

						            	{text: 'Fill In', onclick : function() { themeShortcuts.insertHoverFillButton() }},
						            	{text: 'Fancy Icon', onclick : function() { themeShortcuts.insertHoverFancyIconButton() }},
						            	{text: 'Arrows', onclick : function() { themeShortcuts.insertHoverArrowsButton() }},
						            	{text: 'Icon on hover', onclick : function() { themeShortcuts.insertHoverIconOnHoverButton() }},
						            	{text: 'Bordered', onclick : function() { themeShortcuts.insertHoverBorderedButton() }},

						            ]

						    	},
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
						    	{text: 'Log in / out button', onclick : themeShortcuts.logInOut},

				            ]

				    	},
				    	
				    	{ 
				            type: 'listbox', 
				            text: 'Boxes',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Info Box', onclick : themeShortcuts.insertBox},
			                    {text: 'Callout', onclick : themeShortcuts.insertCallout},

				            ]

				    	},

				    	{ 
				            type: 'listbox', 
				            text: 'Icons',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Font Awesome', onclick : themeShortcuts.createIcon},
				            	{text: 'Icon Melon', onclick : themeShortcuts.createIconMelon},
			                    {text: 'Social Icons', onclick : themeShortcuts.createSocialIcon},

				            ]

				    	},

	                    {classes: 'no-dropdown', text: 'Icon Box', onclick : themeShortcuts.createIconBox},
	                    {classes: 'no-dropdown', text: 'Image Scroller', onclick : themeShortcuts.imgScroller},
	                    {classes: 'no-dropdown', text: 'Animated', onclick : themeShortcuts.insertAnimated},
	                    {classes: 'no-dropdown', text: 'SVG Drawing', onclick : themeShortcuts.insertDrawing},

	                    { 
				            type: 'listbox', 
				            text: 'Elements',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Tooltip', onclick : themeShortcuts.insertTooltip},
				            	{text: 'Popover', onclick : themeShortcuts.insertPopover},
				            	{text: 'Modal', onclick : themeShortcuts.insertModal},
				            	{text: 'Tabs', onclick : themeShortcuts.createTabs},
				            	{text: 'Toggle', onclick : themeShortcuts.createToggle},
				            	{text: 'Accordion', onclick : themeShortcuts.createAccordion},
				            	{text: 'Progress Bar', onclick : themeShortcuts.createProgressBar},
				            ]

				    	},

				    	{ 
				            type: 'listbox', 
				            text: 'Section',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Image', onclick : themeShortcuts.createSectionImage},
				            	{text: 'Color', onclick : themeShortcuts.createSectionColor},

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
				            	{text: 'Google Docs', onclick : themeShortcuts.createGoogleDocs},
				            	{ 
						            type: 'listbox', 
						            text: 'Google Charts',
						            icon: false,
						            classes: 'has-dropdown',
						            values: [ 

						            	{text: 'Pie', onclick : themeShortcuts.createChartPie},
						            	{text: 'Bar', onclick : themeShortcuts.createChartBar},
						            	{text: 'Area', onclick : themeShortcuts.createChartArea},
						            	{text: 'Geo', onclick : themeShortcuts.createChartGeo},
						            	{text: 'Combo', onclick : themeShortcuts.createChartCombo},
						            	{text: 'Org', onclick : themeShortcuts.createChartOrg},
						            	{text: 'Bubble', onclick : themeShortcuts.createChartBubble},

						            ]

						    	},

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

	                    { 
				            type: 'listbox', 
				            text: 'Tables',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Styled table', onclick : themeShortcuts.createTables},
				            	{text: 'Pricing table', onclick : themeShortcuts.createPricingTables},

				            ]

				    	},

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
						            	{text: 'Other', onclick : themeShortcuts.createAudio},

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
						    	{text: 'Quote', onclick : themeShortcuts.quote},
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
						    	{text: 'Colored Text', onclick : themeShortcuts.createTextColor},
						    	{text: 'Abbreviation', onclick : themeShortcuts.abbreviation},

				            ]

				    	},

	                    { 
				            type: 'listbox', 
				            text: 'Related',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Related posts', onclick : themeShortcuts.relatedPosts},
				            	{text: 'Siblings', onclick : themeShortcuts.pageSiblings},
				            	{text: 'Children', onclick : themeShortcuts.children},

				            ]

				    	},

	                    { 
				            type: 'listbox', 
				            text: 'Fancybox',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Images', onclick : themeShortcuts.createFancyboxImages},
				            	{text: 'Inline', onclick : themeShortcuts.createFancyboxInline},
				            	{text: 'iFrame', onclick : themeShortcuts.createFancyboxIframe},
				            	{text: 'Page', onclick : themeShortcuts.createFancyboxPage},
				            	{text: 'Swf', onclick : themeShortcuts.createFancyboxSwf},

				            ]

				    	},

	                    { 
				            type: 'listbox', 
				            text: 'Contact form',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Light', onclick : themeShortcuts.contactFormLight},
				            	{text: 'Dark', onclick : themeShortcuts.contactFormDark},

				            ]

				    	},

	                    { 
				            type: 'listbox', 
				            text: 'Carousel',
				            icon: false,
				            classes: 'has-dropdown',
				            values: [ 

				            	{text: 'Post Carousel', onclick : themeShortcuts.createCarousel},
				            	{text: 'Swiper', onclick : themeShortcuts.createSwiper},
				            	//{text: 'Testimonial', onclick : themeShortcuts.createTestimonials},

				            ]

				    	},

				    	//{classes: 'no-dropdown', text: 'Countdown', onclick : themeShortcuts.eventCountdown},
				    	{classes: 'no-dropdown', text: 'Code', onclick : themeShortcuts.createCode},

	                ]
	     
	            });		

			},


		});


	};//end else

	
	tinymce.PluginManager.add('themeShortcuts', tinymce.plugins.themeShortcuts);
})()