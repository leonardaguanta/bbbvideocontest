<?php 
/*
Plugin Name: reCaptcha Resize
Author:George Platypuslocal
Plugin URI: https://www.platypuslocal.com
*/


function georgina(){
?>
<script type="text/javascript">jQuery(document).ready(function(){
function scaleCaptcha(elementWidth) {
  // Width of the reCAPTCHA element, in pixels
  var reCaptchaWidth = 304;
  // Get the containing element's width
	var containerWidth = jQuery('.gfield').width();
  
  // Only scale the reCAPTCHA if it won't fit
  // inside the container
  if(reCaptchaWidth > containerWidth) {
    // Calculate the scale
    var captchaScale = containerWidth / reCaptchaWidth;
    // Apply the transformation
    jQuery('.ginput_recaptcha').css({
      'transform':'scale('+captchaScale+')',
       'transform-origin' : 0
    });
  }
}


 
  // Initialize scaling
  scaleCaptcha();
  
  // Update scaling on window resize
  // Uses jQuery throttle plugin to limit strain on the browser
  jQuery(window).resize( scaleCaptcha );
  
});
</script>
<?php
}

add_action('wp_footer', 'georgina');