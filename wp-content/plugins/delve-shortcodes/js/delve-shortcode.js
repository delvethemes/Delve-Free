/*
 * Delve Shortcodes
 *
*/
jQuery(document).ready(function( $ ) {
	
	// Number counter shortcode JS
	jQuery('.delve_num_counter').counterUp({
		delay: 10,
		time: 1000
	});
	
	
	// flex slider initialization
	jQuery(window).load(function() {
		
		// Basic slider settings
		jQuery('.delve-flexslider-basic.delve-slide').flexslider({
			animation: "slide",
			smoothHeight: true,
			useCSS: false
		});
		
		jQuery('.delve-flexslider-basic.delve-fade').flexslider({
			animation: "fade",
			smoothHeight: true,
			useCSS: false
		});
		
		// Slider with thumbnail 
		jQuery('.delve-flexslider-thumbnail.delve-slide').flexslider({
			animation: "slide",
			controlNav: "thumbnails",
			smoothHeight: true,
			useCSS: false
		});
		
		// Slider with thumbnail 
		jQuery('.delve-flexslider-thumbnail.delve-fade').flexslider({
			animation: "fade",
			controlNav: "thumbnails",
			smoothHeight: false,
		});
		
		jQuery('.testimonials-slider').flexslider({
			animation: "fade",
			smoothHeight: false,
			useCSS: true
		});
	}); // flex slider initialization
	
	// Skillbars Initilization
	/*jQuery('.delve-skillbar').each(function(){
		jQuery(this).find('.skillbar-bar').animate({
			width:jQuery(this).attr('data-percent')
		},6000);
	});*/
	
	jQuery(".delve-skillbar").inViewport(function(px){
    	if(px) {
			jQuery(this).find('.skillbar-bar').css({
					width:jQuery(this).attr('data-percent')
			});
		}
	});
	
	
	//ihover responsive JS.
	/*iHover_resp();
	jQuery( window ).resize(function() {
		iHover_resp();
	});
	
	function iHover_resp() {
		var conWidth = jQuery('.delveGalleryItem').width();
		
		jQuery('.ih-item.circle').css({'width':conWidth-10+'px','height':conWidth-10+'px'});
		jQuery('.ih-item.circle .spinner').css({'width':conWidth+'px','height':conWidth+'px'});
	}*/
	
});