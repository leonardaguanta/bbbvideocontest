<?php

/*----HIDE LABEL OPTIONS on Gravity Forms ----*/
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}


/*---------- SHORTCODES ------------*/

add_shortcode( 'schools', 'display_schools' );
function display_schools() {
	ob_start();
    include 'shortcodes/functions-schools.php';
    $ret = ob_get_contents();
    ob_end_clean();
	return $ret;
}

add_shortcode( 'schools_home', 'display_schools_home' );
function display_schools_home() {
	ob_start();
    include 'shortcodes/functions-schools-home.php';
    $ret = ob_get_contents();
    ob_end_clean();
	return $ret;
}
?>