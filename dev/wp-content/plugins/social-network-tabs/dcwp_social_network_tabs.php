<?php
/*
		Plugin Name: Social Network Tabs
		Plugin URI: http://www.designchemical.com/blog/index.php/premium-wordpress-plugins/premium-wordpress-plugin-social-network-tabs/
		Tags: facebook, twitter, google +1, rss, linkedin, digg, delicious, flickr, youtube, last.fm, pinterest, dribbble, vimeo, stumbleupon, deviantart, tumblr, instagram, social networks, jquery, tabs
		Description: Add feeds & profiles from your favorite social networks in slick slide out or static tabs - facebook like box, facebook recommendations, twitter, google +1, rss, digg, linkedin, delicious, flickr, youtube, last.fm, pinterest, stumbleupon, dribbble, vimeo, deviantart, instagram & tumblr.
		Author: Lee Chestnutt
		Version: 1.7.3
		Author URI: http://www.designchemical.com/blog/
*/
global $wpdb;

error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

require_once('inc/dcwp_admin.php');
require_once('inc/dcwp_functions.php');
require_once('inc/dcwp_shortcodes.php');

class dc_jqsocialtabs {

	function __construct() {
	
		add_filter('init', array(&$this,'dcsnt_init'));
		add_action( 'wp_head', array('dc_jqsocialtabs', 'header') );
		add_action( 'wp_footer', array('dc_jqsocialtabs', 'footer') );
		
		// Add shortcodes
		add_shortcode('dc_social_tabs', 'dc_social_tabs_shortcode');
		add_shortcode('dc_social_tabs_link', 'dc_social_tabs_link_shortcode');
		
		// Scripts
		add_action("wp_enqueue_scripts",array(&$this,'add_dcsnt_styles'));
		add_action("wp_enqueue_scripts",array(&$this,'add_dcsnt_scripts'));

	}
	
	function add_dcsnt_styles() {

		if(get_dcsnt_default('skin') == 'true'){
			wp_enqueue_style( 'dcsnt', dc_jqsocialtabs::get_plugin_directory() . '/css/dcsnt.css');
		}

	}

	function add_dcsnt_scripts() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'dcsnt', dc_jqsocialtabs::get_plugin_directory() . '/js/jquery.social.media.tabs.1.7.3.min.js' );

	}
		
	function dcsnt_init(){

		if(is_admin()) {

			$dc_jqsocialtabs_admin = new dc_jqsocialtabs_admin();
		}

	}
	
	/*
	 * Add custom CSS
	 */
	function header(){

		echo dcsnt_custom_css();
		
		return;
	}
	
	function footer(){
		
		$show = dcsnt_show();
		
		if($show == 1){
			echo do_shortcode('[dc_social_tabs]');
		}
		
		return;
	}
	
	function get_plugin_directory(){
		return plugins_url() . '/social-network-tabs';	
	}
}

// Initialize the plugin.
$dcjqsocialtabs = new dc_jqsocialtabs();

?>