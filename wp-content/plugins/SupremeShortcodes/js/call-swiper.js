jQuery(document).ready(function(){

	/* SWIPER SLIDER */
	function supremeSwipeSlider() {


		jQuery(".st-swiper-container").each(function() {

			var swiperWidth = jQuery('.swiper-container').width();
			var swiperParentID = jQuery(this).parent().attr('id');
			var swiperWraperWidth = document.getElementById(swiperParentID).offsetWidth;


			if(swiperWraperWidth < 330){
				var slidesNumber = 1;
			}else if(swiperWraperWidth < 600){
				var slidesNumber = 2;
			}else if(swiperWraperWidth < 850){
				var slidesNumber = 3;
			}else if(swiperWraperWidth < 810){
				var slidesNumber = 4;
			}else{
				var slidesNumber = 5;
			}

			jQuery(this).swiper({
				mode:'horizontal',
			    slidesPerView: slidesNumber,
			    calculateHeight : true
			});

		});


		function piVertCenter() {
			jQuery('.st-swiper-container.without-title').each(function(){
				var $colHeight = jQuery(this).find('.swiper-slide').height();
				var $infoHeight = jQuery(this).find('.swiper-slide h3').height();
				
				//30px away from being centered so we can transition to center point on hover
				jQuery(this).find('.swiper-slide h3').css('margin-top', (($colHeight / 2) - ($infoHeight / 2 )) - 40 );
			});	
		}
		
		jQuery(window).load(function(){
		 	 piVertCenter();
		});
		 
		jQuery(window).resize(function(){
			 piVertCenter();
		});

		
	}
	supremeSwipeSlider();

});