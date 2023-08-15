/**
 * @file
 * Global utilities.
 *
 */
(function ($) {

	$(document).ready(function(){
    wow = new WOW({
      boxClass:     'animate__animated',      // default wow
      animateClass: 'animate__animated', // default
      offset:       100,          // default
      mobile:       true,       // default
      live:         true        // default
    });
    wow.init();
  });


})(jQuery);
