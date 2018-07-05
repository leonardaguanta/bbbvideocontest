<?php

/* Social Network Tabs */
function dc_social_tabs_shortcode( $atts, $content = null ){

	extract( shortcode_atts( array(
	'style' => 'slide',
	'position' => 'fixed',
	'width' => 360,
	'height' => 600
	), $atts ));
	
	$out = '';
	$options = get_option('dcsnt_options');
	$networks = dcsnt_networks('networks');
	$settings = dcsnt_networks('settings');

	if($options['dcsnt_order'] != ''){
		$dcsnt_order = $options['dcsnt_order'];
	} else {
		$i = 0;
		$dcsnt_order = '';
		foreach($networks as $k=>$v){
			$dcsnt_order .= $i > 0 ? ',' : '' ;
			$dcsnt_order .= $k;
			$i++;
		}
	}
	$i = 0;
	$widgets = 'widgets: "';
	$ids = '';
	$params = '';
	$opt = '';
	
	$order = explode(',', $dcsnt_order);
					
	foreach($order as $function){
					
		if($function != '' && $options[$function.'_inc'] == 'true'){
			$widgets .= $i > 0 ? ','.$function : $function ;
			$ids .= ','.$function.'Id: "'.$options[$function.'Id'].'"';
			$p = Array();
			$p = $options[$function];
			$params .= ','.$function.': {';
			$j = 0;
			$t1 = 0;
			foreach($p as $k=>$v){
			
				if($function == 'twitter' && $t1 == 0){
					$url_p = '?1='.$options['twitter']['consumer_key'].'&2='.$options['twitter']['consumer_secret'].'&3='.$options['twitter']['access_token'].'&4='.$options['twitter']['access_token_secret'];
				// trim option
				//	$url_p = '?1='.trim($options['settings']['consumer_key']).'&2='.trim($options['settings']['consumer_secret']).'&3='.trim($options['settings']['access_token']).'&4='.trim($options['settings']['access_token_secret']);
					$params .= 'url: "'.dc_jqsocialtabs::get_plugin_directory() . '/inc/dcwp_twitter.php'.$url_p.'",';
					$t1 = 1;
				}
				
				if($function == 'facebook' && $t1 == 0){
					$params .= 'url: "'.plugins_url() . '/social-network-tabs/inc/dcwp_facebook.php",';
					$t1 = 1;
				}
				
				if($function == 'google' && $k == 'header'){
					$params .= $j > 0 ? ','.$k.': '.$v : $k.': '.$v;
				} else if($function == 'twitter' && $k == 'thumb'){
					$params .= $j > 0 ? ','.$k.': '.$v : $k.': '.$v ;
				} else if($function == 'facebook' && $k == 'fb_app_id'){
					$params .= '';
				} else if($function == 'facebook' && $k == 'fb_app_secret'){
					$params .= '';
				} else if($function == 'twitter' && $k == 'retweets'){
					$params .= $j > 0 ? ','.$k.': '.$v : $k.': '.$v ;
				} else if($function == 'twitter' && $k == 'replies'){
					$params .= $j > 0 ? ','.$k.': '.$v : $k.': '.$v ;
				} else if($function == 'linkedin' && $k == 'MemberProfile'){
					$params .= $j > 0 ? ','.$k.': '.$v : $k.': '.$v ;
				} else if($function == 'linkedin' && $k == 'CompanyProfile'){
					$params .= $j > 0 ? ','.$k.': '.$v : $k.': '.$v ;
				} else if($function == 'instagram' && $k == 'likes'){
					$params .= $j > 0 ? ','.$k.': '.$v : $k.': '.$v ;
				} else if($function == 'instagram' && $k == 'comments'){
					$params .= $j > 0 ? ','.$k.': '.$v : $k.': '.$v ;
				} else {
					$params .= $j > 0 ? ','.$k.': "'.$v.'"': $k.': "'.$v.'"' ;
					if($k == 'title' && $v == '')
					{
						$params .= ',link: false';
					}
				}
				$j++;
			}
			$params .= '}';
			$i++;
		}
	}

	// get settings
	$opt .= ',method: "'.$style.'"';
	$opt .= ',position: "'.$position.'"';
	foreach($options['settings'] as $k => $v)
	{
		switch($k)
		{
			case 'speed':
			$v = $v * 1000;
			$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
			break;
			case 'width':
			if(isset($atts[$k])){
				$opt .= ',width: '.$atts[$k] ;
			} else {
				$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
			}
			break;
			case 'height':
			if(isset($atts[$k])){
				$opt .= ',height: '.$atts[$k] ;
			} else {
				$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
			}
			break;
			case 'tweetId':
			if(isset($atts[$k])){
				$opt .= ',tweetId: "'.$atts[$k].'"' ;
			} else {
				$opt .= $v != $settings[$k] ? ','.$k.': "'.$v.'"' : '' ;
			}
			break;
			case 'zopen':
			$v = $v == 'auto' ? '"auto"' : $v ;
			$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
			break;
			case 'rotate_delay':
			break;
			case 'rotate_direction':
			break;
			case 'loc':
				switch($v)
				{
					case 1:
					$opt .= ',location: "top"';
					$opt .= ',align: "right"';
					break;
					case 2:
					$opt .= ',location: "top"';
					$opt .= ',align: "left"';
					break;
					case 3:
					$opt .= ',location: "bottom"';
					$opt .= ',align: "right"';
					break;
					case 4:
					$opt .= ',location: "bottom"';
					$opt .= ',align: "left"';
					break;
					case 5:
					$opt .= ',location: "right"';
					$opt .= ',align: "top"';
					break;
					case 6:
					$opt .= ',location: "left"';
					$opt .= ',align: "top"';
					break;
				}
			break;
			default:
			$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
			break;
		}
	}
	
	$opt .= ',rotate: {delay: ';
	$v = $options['settings']['rotate_delay'] * 1000;
	$opt .= $v != $settings['rotate_delay'] ? $v : $settings['rotate_delay'];
	$opt .= ', direction: "';
	if(isset($options['settings']['rotate_direction'])){
		$opt .= $options['settings']['rotate_direction'] != $settings['rotate_direction'] ? $options['settings']['rotate_direction'] : $settings['rotate_direction'];
	}
	$opt .= '"}';
	
	$classes = ',wrapper: "dcsnt",';
	$classes .= 'content: "dcsnt-content",';
	$classes .= 'slider: "dcsnt-slider",';
	$classes .= 'classOpen: "dcsnt-open",';
	$classes .= 'classClose: "dcsnt-close",';
	$classes .= 'classToggle: "dcsnt-toggle",';
	$classes .= 'classSlide: "dcsnt-slide",';
	
	$config = '{'.$widgets.'"'.$ids.$params.$opt.$classes;
	$config .= 'imagePath: "'.dc_jqsocialtabs::get_plugin_directory().'/images/icons/"}';
	
	$out .='<script type="text/javascript">jQuery(document).ready(function($){';
	$out .= 'var config = '.$config.';';
	$out .= 'if(!jQuery().dcSocialTabs) { $.getScript("'.dc_jqsocialtabs::get_plugin_directory().'/js/jquery.social.media.tabs.1.7.3.min.js", function(){$("#social-tabs").dcSocialTabs(config);}); } else {';
	$out .= '$("#social-tabs").dcSocialTabs(config);}});</script>'."\n";
	$out .= '<div id="social-tabs"></div>';

    return $out;
}

/* Social Network Tabs Links */
function dc_social_tabs_link_shortcode( $atts, $content = null ){

	extract(shortcode_atts( array(
		'tab' => 1,
		'action' => 'toggle'
	), $atts));
	
	$tab = $tab - 1;
	$out = '<a href="#" class="dcsnt-'.$action.'" rel="'.$tab.'">' . do_shortcode($content) . '</a>';
	
	return $out;
}
?>