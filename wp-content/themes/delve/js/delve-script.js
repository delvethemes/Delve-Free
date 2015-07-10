jQuery(document).ready( function(){

	

	// ----------- Tabs Init --------------//

	jQuery(function(jQuery){

		jQuery('.delve-tabs-wrapper').tabs({ show: { effect: "clip", duration: 600 } });

	});

	

	// ----------- Isotop function for Square Portfolio. -----

	jQuery(window).load(function(){

    	var $square_container = jQuery('#portfolio-square .portfolioContainer');

    	$square_container.isotope({

        	filter: '*',

			layoutMode : 'fitRows',

    	});

 

		jQuery('.portfolioFilter a').click(function(){

			jQuery('.portfolioFilter .current').removeClass('current');

        	jQuery(this).addClass('current');

 

			var selector = jQuery(this).attr('data-filter');

			$square_container.isotope({

				filter: selector,

				layoutMode : 'fitRows',

			});

			return false;

		});

		

		// ----------- Isotop function for Masonry Portfolio. -----

		var $masonry_container = jQuery('#portfolio-masonry .portfolioContainer');

    	$masonry_container.isotope({

        	filter: '*',

			layoutMode : 'masonry',

    	});

 

		jQuery('.portfolioFilter a').click(function(){

			jQuery('.portfolioFilter .current').removeClass('current');

        	jQuery(this).addClass('current');

 

			var selector = jQuery(this).attr('data-filter');

			$masonry_container.isotope({

				filter: selector,

				layoutMode : 'masonry',

			});

			return false;

		});

		

		// ----------- Isotop function for Blog. -----

		jQuery('#blog-masonry .blog_item_container').isotope({

			layoutMode : 'masonry',

		});

		

		jQuery('#blog-classic .blog_item_container').isotope({

			layoutMode : 'fitRows',

		});

	});

	

	// ----------- PrettyPhoto Initilzation. -----

	jQuery("a[data-gal^='prettyPhoto']").prettyPhoto();

	

	// ----------- Drop Down Menu Slide Effects. -----

	function menuDropdown() {

		var ww = document.body.clientWidth;

		if (ww < 767) {

			jQuery('.navbar .dropdown').unbind('mouseenter mouseleave');

			jQuery('.navbar li a.dropdown-toggle .caret').click(function(e) {

				jQuery(this).parent().next('.dropdown-menu').stop(true, true).slideToggle();

				e.stopImmediatePropagation();

				jQuery(this).parent().toggleClass( 'open' )

				return false;

			});

		} else {

			//

			jQuery('.navbar .dropdown').hover(function() {

				jQuery(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);

				}, function() {

				jQuery(this).find('.dropdown-menu').first().stop(true, true).slideUp(150);

			});

		}

	}

	

	menuDropdown();



	jQuery(window).resize( function() {

		jQuery('.navbar .dropdown').unbind( "click" );

		menuDropdown();

	});

	

	// ----------- Portfolio Add Colors Class. -----

	jQuery(".alternative_css:even").addClass("portfolio-1st-bg");

    jQuery(".alternative_css:odd").addClass("portfolio-2nd-bg");

	

	// ----------- TOp Scroll Effects. -----

	jQuery(window).scroll(function() {

		var screenTop = jQuery(document).scrollTop();

		if( screenTop > 150 ) {

			jQuery( '#back-to-top' ).fadeIn( 'slow' );

		} else {

			jQuery( '#back-to-top' ).fadeOut( 'slow' );

		}

	});

	

	// ----------- Pie Progress Initilzation. -----

	if( jQuery('.pie_progress').length ) {

		jQuery('.pie_progress').asPieProgress({

			'namespace': 'pie_progress'

		});

	}

	// jQuery('.pie_progress').asPieProgress('start');



	jQuery(window).scroll(function() {	

		// ----------- Pie Progress Effect Start. -----

		if( jQuery('.pie_progress').length ) {

			jQuery('.pie_progress:in-viewport').asPieProgress('start');

		}

		

		// ----------- Sticky Header. -----

		if(jQuery(window).scrollTop() > (jQuery("#top_nav").height()-40) ) {

			jQuery(".sticky-header").css("display","block");

		}else {

			jQuery(".sticky-header").css("display","none");

		}

	});

	

	// ----------- Full Width Box Shortcode. -----

	jQuery('div.delve-full-width-box-container').height( jQuery('div.delve-full-width-box').height()+70 );

	if( jQuery('div.delve-full-width-box-container')[0] ) {

		var $margin = jQuery('div.delve-full-width-box-container').offset().left;

	}

	var $width = jQuery('div.delve-full-width-box').width() + $margin + $margin;

	jQuery('div.delve-full-width-box').css({ 'margin-left' : ( 0 - $margin ), 'width' : $width });

	

	

	<!-- add to cart button -->

	jQuery('a.add_to_cart_button').click(function(e) {

		var link = this;

		jQuery(link).closest('.product').find('.cart-loading').find('i').removeClass('fa-check-square-o').addClass('fa-rotate-right fa-spin');

		jQuery(this).closest('.product').find('.cart-loading').fadeIn();

		setTimeout(function(){

			jQuery(link).closest('.product').find('.product-images img').animate({opacity: 0.8});

			jQuery(link).closest('.product').find('.cart-loading').find('i').hide().removeClass('fa-rotate-right fa-spin').addClass('fa-check-square-o').fadeIn();



			setTimeout(function(){

				jQuery(link).closest('.product').find('.cart-loading').fadeOut().closest('.product').find('.product-images img').animate({opacity: 1});

			}, 2000); 

		}, 2000); 

	});

	

	jQuery('li.product').mouseenter(function() {

		if(jQuery(this).find('.cart-loading').find('i').hasClass('fa-check-square-o')) {

			jQuery(this).find('.cart-loading').fadeIn();

		}

	}).mouseleave(function() {

		if(jQuery(this).find('.cart-loading').find('i').hasClass('fa-check-square-o')) {

			jQuery(this).find('.cart-loading').fadeOut();

		}

	});

	

	/****** Product slider test ******/

	jQuery('#singleProductSlider').carousel({

		interval: false

	});



	// Handles the carousel thumbnails

	jQuery('[id^=carousel-selector-]').click( function(){

		var id_selector = jQuery(this).attr("id");

		var id = id_selector.substr(id_selector.length -1);

		id = parseInt(id);

		jQuery('#singleProductSlider').carousel(id);

		jQuery('[id^=carousel-selector-]').removeClass('selected');

		jQuery(this).addClass('selected');

	});

	

	// #singleProductSlider .carousel-control

	jQuery('#singleProductSlider .carousel-control').click( function() {

		

		var id = jQuery('#singleProductSlider .item.active').data('slide-number');

		id = parseInt(id);

		jQuery('[id=carousel-selector-'+id+']').removeClass('selected');

		

		if(id == (jQuery('[id^=carousel-selector-]').length-1) ) id = 0;

		else id += 1;

		//alert(id);

		jQuery('[id=carousel-selector-'+id+']').addClass('selected');

	});

	

	

	// My Account Page

	

	jQuery('.delve-myaccount-data h2, .delve-myaccount-data .digital-downloads, .delve-myaccount-data .my_account_orders, .delve-myaccount-data .myaccount_address, .delve-myaccount-data .addresses, .delve-myaccount-data .edit-account-heading, .delve-myaccount-data .edit-account-form').hide();

	

	var delve_myaccount_active = jQuery('.delve-myaccount-nav').find('.active a');



	if(delve_myaccount_active.hasClass('address') ) {

		jQuery('.delve-myaccount-data .edit_address_heading').fadeIn();

	} else {

		jQuery('.delve-myaccount-data h2:nth-of-type(1)').fadeIn();

	}



	if(delve_myaccount_active.hasClass('downloads') ) {

		jQuery('.delve-myaccount-data .digital-downloads').fadeIn();

	} else if(delve_myaccount_active.hasClass('orders') ) {

		jQuery('.delve-myaccount-data .my_account_orders').fadeIn();

	} else if(delve_myaccount_active ) {

		jQuery('.delve-myaccount-data .myaccount_address, .delve-myaccount-data .addresses').fadeIn();

	}

	

	

	jQuery('.delve-myaccount-nav a').click(function(e) {

		e.preventDefault();

		

		jQuery('.delve-myaccount-data h2, .delve-myaccount-data .digital-downloads, .delve-myaccount-data .my_account_orders, .delve-myaccount-data .myaccount_address, .delve-myaccount-data .addresses, .delve-myaccount-data .edit-account-heading, .delve-myaccount-data .edit-account-form').hide();



		if(jQuery(this).hasClass('downloads') ) {

			jQuery('.delve-myaccount-data h2:nth-of-type(1), .delve-myaccount-data .digital-downloads').fadeIn();

		} else if(jQuery(this).hasClass('orders') ) {



			if( jQuery(this).parents('.delve-myaccount-nav').find('.downloads').length ) {

				heading = jQuery('.delve-myaccount-data h2:nth-of-type(2)');

			} else {

				heading = jQuery('.delve-myaccount-data h2:nth-of-type(1)');

			}



			heading.fadeIn();

			jQuery('.delve-myaccount-data .my_account_orders').fadeIn();

		} else if(jQuery(this).hasClass('address') ) {



			if( jQuery(this).parents('.delve-myaccount-nav').find('.downloads').length && jQuery(this).parents('.delve-myaccount-nav').find('.orders').length ) {

				heading = jQuery('.delve-myaccount-data h2:nth-of-type(3)');

			} else if( jQuery(this).parents('.delve-myaccount-nav').find('.downloads').length || jQuery(this).parents('.delve-myaccount-nav').find('.orders').length ) {

				heading = jQuery('.delve-myaccount-data h2:nth-of-type(2)');

			} else {

				heading = jQuery('.delve-myaccount-data h2:nth-of-type(1)');

			}



			heading.fadeIn();

			jQuery('.delve-myaccount-data .myaccount_address, .delve-myaccount-data .addresses').fadeIn();

		} else if(jQuery(this).hasClass('account') ) {

			jQuery('.delve-myaccount-data .edit-account-heading, .delve-myaccount-data .edit-account-form').fadeIn();

		}



		jQuery('.delve-myaccount-nav li').removeClass('active');

		jQuery(this).parent().addClass('active');

	});

	// and of my account page style

	

	/***** Order product menu script *******/

	if ('ontouchstart' in document.documentElement || navigator.msMaxTouchPoints) {

		jQuery('.nav-holder li.menu-item-has-children > a, .order-dropdown > li .current-li').on("click", function (e) {

			var link = jQuery(this);

			if (link.hasClass('hover')) {

				link.removeClass("hover");

				return true;

			} else {

				link.addClass("hover");

				jQuery('.nav-holder li.menu-item-has-children > a, .order-dropdown > li .current-li').not(this).removeClass("hover");

				e.preventDefault();

				return false;

			}

		});



		jQuery('.sub-menu li, .mobile-nav-item li').not('li.menu-item-has-children').find('a').on("click", function (e) {

			var link = jQuery(this).attr('href');

			window.location = link;



      		return true;

		});

	}

	

	jQuery('.catalog-ordering .orderby .current-li a').html(jQuery('.catalog-ordering .orderby ul li.current a').html());

	jQuery('.catalog-ordering .sort-count .current-li a').html(jQuery('.catalog-ordering .sort-count ul li.current a').html());

	

	/****** added bootstrap Quantity button to woocommerce *******/

	jQuery('.btn-number').click(function(e){

		e.preventDefault();

		

		fieldName = jQuery(this).attr('data-field');

		type      = jQuery(this).attr('data-type');

		var input = jQuery("input[name='"+fieldName+"']");

		var currentVal = parseInt(input.val());

		if (!isNaN(currentVal)) {

			if(type == 'minus') {

				

				if(currentVal > input.attr('min')) {

					input.val(currentVal - 1).change();

				} 

				if(parseInt(input.val()) == input.attr('min')) {

					jQuery(this).attr('disabled', true);

				}

	

			} else if(type == 'plus') {

				if( input.attr('max') ) {

					if(currentVal < input.attr('max')) {

						input.val(currentVal + 1).change();

					}

				} else {

					input.val(currentVal + 1).change();

				}

				

				if(parseInt(input.val()) == input.attr('max')) {

					jQuery(this).attr('disabled', true);

				}

	

			}

		} else {

			input.val(0);

		}

	});

	

	jQuery('.input-number').focusin(function(){

	   jQuery(this).data('oldValue', jQuery(this).val());

	});

	

	jQuery('.input-number').change(function() {

		

		minValue =  parseInt(jQuery(this).attr('min'));

		maxValue =  parseInt(jQuery(this).attr('max'));

		valueCurrent = parseInt(jQuery(this).val());

		

		name = jQuery(this).attr('name');

		if(valueCurrent >= minValue) {

			jQuery(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')

		} else {

			alert('Sorry, the minimum value was reached');

			jQuery(this).val(jQuery(this).data('oldValue'));

		}

		

		if(maxValue) {

			if(valueCurrent <= maxValue) {

				jQuery(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')

			} else {

				alert('Sorry, the maximum value was reached');

				jQuery(this).val(jQuery(this).data('oldValue'));

			}

		}	

	});

	

	jQuery(".input-number").keydown(function (e) {

		// Allow: backspace, delete, tab, escape, enter and .

		if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||

			// Allow: Ctrl+A

			(e.keyCode == 65 && e.ctrlKey === true) || 

			// Allow: home, end, left, right

			(e.keyCode >= 35 && e.keyCode <= 39)) {

				// let it happen, don't do anything

				return;

		}

		// Ensure that it is a number and stop the keypress

		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

			e.preventDefault();

		}

	});



});

/* Animate X for toggle menu */

jQuery(document).ready(function () {

	 jQuery(".navbar-toggle").on("click", function () {

			jQuery(this).toggleClass("active");

	  });
	 
	 /* Add table class to all tables */
	 jQuery( "table" ).addClass("table"); 	 1
	 jQuery( "table" ).wrap( "<div class='table-responsive'></div>" );

});

/* Modal for Our Team */

jQuery('#myModal').modal('toggle')

jQuery('#myModal').on('shown.bs.modal', function () {
  jQuery('#myInput').focus()
})

.modal('show');
jQuery('#myModal').modal('handleUpdate');