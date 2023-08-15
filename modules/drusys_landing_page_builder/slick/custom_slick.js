/**
 * @file
 * Global utilities.
 *
 */
(function ($) {
  $(document).ready(function() {

	  $('.ds-lpb-wrapper.ds-hero-slider').slick();
	  $('.ds-carousel .card-items').slick({
		  dots: true,
		  infinite: true,
		  speed: 300,
		  slidesToShow: 3,
		  centerMode: false,
		  autoplay: true    	
    });

  });
})(jQuery);
