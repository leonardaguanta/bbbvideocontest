<?php
/*
Plugin Name: Platypus - Common Modules
Plugin URI: http://www.platypuslocal.com
Description: Platypus - Common Modules
Author: Platypus - Len
Version: 0.1
Author URI: http://www.platypuslocal.com/
*/

require('ga-analytics.php');


add_action( 'wp_loaded', 'wp_pro_ads_ajax_platypus_api');


function wp_pro_ads_ajax_platypus_api() {
	global $pro_ads_statistics;
	
	if(isset( $_GET['platypus_adszone'] ) && !empty( $_GET['platypus_adszone'] )) {
		error_log("STATS IS WORKING!: ". print_r($_GET,true));
		$pro_ads_statistics->save_impression( $_GET['banner_id'], $_GET['adzone_id'], $_GET['ref_url'] );	
	}
} 

?>
