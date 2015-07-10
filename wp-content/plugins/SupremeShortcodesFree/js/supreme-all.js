jQuery(document).ready(function($){


	/* TABS */
	jQuery(function($){
		
		$(".st-tabs").each(function() {
			$(this).find('li').first().addClass('active');
		});
		$(".tab-content").each(function(){
			$(this).find('div').first().addClass('active');
		});

		$('.st-tabs a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});

	});

	// TOGGLE
    jQuery(function($){
		$('.st-toggle').click(function() {

			if($(this).hasClass('collapsed')){
		    	$(this).find('i').attr('class', 'fa fa-minus st-size-2');
		    }else{
		    	$(this).find('i').attr('class', 'fa fa-plus st-size-2');
		    }

		});
    });
    

    // TO TOP BUTTON
	jQuery(function($){

		var offset = 220;
	    var duration = 500;
	    
	    $('.to-top').click(function(event) {
	        event.preventDefault();
	        $('html, body').animate({scrollTop: 0}, duration);
	        return false;
	    });

	});
    

});