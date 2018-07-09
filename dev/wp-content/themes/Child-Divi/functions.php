<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
add_shortcode( 'schools', 'display_schools' );
function display_schools() {
	ob_start();
    include 'shortcodes/functions-schools.php';
    $ret = ob_get_contents();
    ob_end_clean();
	return $ret;
}

?>