//jQuery to collapse the navbar on scroll
jQuery(window).scroll(function() {
    if (jQuery(".navbar").offset().top > 50) {
        jQuery(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        jQuery(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
});

//jQuery for page scrolling feature - requires jQuery Easing plugin
jQuery(function() {
    jQuery('a.page-scroll').bind('click', function(event) {
        var $anchor = jQuery(this);
		
		jQuery('a.page-scroll').parent('li').removeClass('active');
		jQuery(this).parent('li').addClass('active');
		
        jQuery('html, body').stop().animate({
            scrollTop: jQuery($anchor.attr('href')).offset().top-40
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});
