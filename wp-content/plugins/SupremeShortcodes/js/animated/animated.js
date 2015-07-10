/*!
 * Animated Initializer
 * Copyright (c) 2013 Intense Visions, Inc.
 */

var $scrollAnimatedElements = null;

function isScrolledIntoView(el) {
	var $placeholder;

	if (jQuery(el).data('starthidden')) {
		$placeholder = jQuery(el).next('.animation-placeholder');
	} else {
		$placeholder = jQuery(el);
	}

	if ($placeholder.length > 0) {
		var docViewTop = jQuery(window).scrollTop();
		var docViewBottom = docViewTop + jQuery(window).height();
		var elTop = $placeholder.offset().top;
		var elBottom = $placeholder.offset().top + $placeholder.outerHeight();
		var scrollPercent = (parseInt(jQuery(el).data('scrollpercent'), 10) / 100);
		var height = elBottom - elTop;
		var amountVisible = docViewBottom - elTop;
		var neededAmountVisible = height * scrollPercent;

		//console.log("amount visible: " + amountVisible + " | needed: " + neededAmountVisible + " (" + scrollPercent+ ")");

		return amountVisible >= neededAmountVisible;
	} else {
		return false;
	}
}

jQuery(function($) {
	$(window).load(function() {
		var isIE9 = $("#intense-browser-check").hasClass('ie9');
		var isOldIE = $("#intense-browser-check").hasClass('oldie') && !isIE9;

		$scrollAnimatedElements = $('.scroll-animated');

		// Show the items that start hidden so you can 
		// calculate top positions correctly later.
		// Replace the hidden item with a placeholder
		$scrollAnimatedElements.each(function(index, el) {
			var $el = $(el);

			if ($el.data('starthidden')) {
				$el.show();
				$('<div class="animation-placeholder" style="height: ' + $el.outerHeight() + 'px; width: ' + $el.outerWidth() + 'px;">').insertAfter($el);
				$el.hide();
			}
		});

		// show items that are already visible on page
		$scrollAnimatedElements.each(function(index, el) {
			var $el = $(el);
			if (isScrolledIntoView(this)) {
				setTimeout(function() {
					var animation = $el.data('animation');

					$el.next('.animation-placeholder').remove();
					$el.show().addClass('animated').addClass(animation);

					if (isIE9 && $el.data('endhidden')) {
						$el.hide();
					}
				}, 700);
			}
		});

		if (isOldIE) {
			$scrollAnimatedElements.each(function(index, el) {
				var $el = $(el);

				if ($el.data('starthidden')) {
					$('.animation-placeholder').hide();
					$el.show();
				} else {
					$el.hide();
				}
			});
		}

		$('.click-animated, .hover-animated').each(function(index, el) {
			var $el = $(el);

			if ($el.data('starthidden')) {
				$el.show();
			}
		});

		$('.click-animated').click(function() {
			var animation = $(this).data('animation');
			$(this).addClass('animated').addClass(animation);
		});

		if (!isOldIE) {
			$(document).scroll(function() {

				$scrollAnimatedElements.each(function() {
					if (isScrolledIntoView(this)) {
						var $el = $(this);
						var animation = $(this).data('animation');

						$el.next('.animation-placeholder').remove();
						$el.show().addClass('animated').addClass(animation);

						if (isIE9 && $el.data('endhidden')) {
							$el.hide();
						}
					}
				});
			});
		}

		$('.hover-animated').mouseenter(function() {
			var animation = $(this).data('animation');
			$(this).addClass('animated').addClass(animation);
		});

		$('.hover-animated').mouseleave(function() {
			var animation = $(this).data('animation');

			if (!$(this).data('endhidden')) {
				$(this).removeClass('animated').removeClass(animation);
			}
		});
	});
});