<?php

function dcsnt_networks($a)
{

	$networks = Array();
	$networks = Array('twitter' => 'Twitter', 'facebook' => 'Facebook', 'fblike' => 'Facebook Like Box', 'fbrec' => 'Recent Activity','google' => 'Google +1','rss' => 'RSS Feed','flickr' => 'Flickr Feed','delicious' => 'Delicious','youtube' => 'YouTube','digg' => 'Digg','pinterest' => 'Pinterest','lastfm' => 'last.fm','dribbble' => 'Dribbble','vimeo' => 'Vimeo','stumbleupon' => 'Stumbleupon','deviantart' => 'Deviantart','tumblr' => 'Tumblr','linkedin' => 'LinkedIn','instagram' => 'Instagram');
	
	$Ids = Array();
	$Ids = Array('twitter' => 'Enter twitter username, list ID or search terms', 'facebook' => 'Enter Facebook Page ID/username', 'fblike' => 'Enter Facebook Page ID', 'fbrec' => 'Enter Domain URL Recommendations','google' => 'Enter Google +1 User ID','rss' => 'Enter RSS Feed URL','flickr' => 'Enter Flickr User ID','delicious' => 'Enter Delicious Username','youtube' => 'Enter YouTube Channel ID','digg' => 'Enter Digg Username','pinterest' => 'Enter Pinterest Username','lastfm' => 'Enter last.fm Username','dribbble' => 'Enter Dribbble Username','vimeo'=> 'Enter Vimeo username','stumbleupon'=> 'Enter Stumbleupon username','deviantart' => 'Enter Deviantart username','tumblr' => 'Enter Tumblr username','linkedin' => 'Enter LinkedIn profile URL and/or company ID','instagram' => 'Enter user ID, location ID, search tag or location');
	
	$settings = Array();
	$settings = Array(
		'share' => 'true',
		'tweetId' => '',
		'external' => 'true',
		'loc' => 5,
		'location' => 'right',
		'align' => 'top',
		'offset' => 30,
		'speed' => 0.6,
		'loadOpen' => 'false',
		'autoClose' => 'false',
		'width' => 360,
		'height' => 600,
		'start' => 0,
		'controls' => 'true',
		'rotate_direction' => 'down',
		'rotate_delay' => 6,
		'zopen' => 1000,
		'imagePath' => '');
		
	$defaults = Array();
	$defaults['twitter'] = Array('title' => 'Latest Tweets', 'follow' => 'Follow on Twitter', 'followId' => '', 'limit' => 10, 'retweets' => 'false', 'replies' => 'false', 'images' => '', 'consumer_key' => '', 'consumer_secret' => '', 'access_token' => '', 'access_token_secret' => '');
	$defaults['facebook'] = Array('title' => 'Facebook', 'follow' => 'Follow on Facebook', 'limit' => 10, 'fb_app_id' => '', 'fb_app_secret' => '');
	$defaults['fblike'] = Array('limit' => 24, 'stream' => 'false', 'header' => 'true');
	$defaults['fbrec'] = Array('feed' => 'all', 'header' => 'true');
	$defaults['google'] = Array('title' => 'Google +1', 'follow' => 'Add to Circles', 'header' => 0, 'pageId' => '', 'image_width' => 75, 'image_height' => 75, 'api_key' => 'AIzaSyB1UZNnscjMDjjH-pi_XbnLRld2wAqi3Ek', 'limit' => 10);
	$defaults['youtube'] = Array('limit' => 10, 'feed' => 'uploads', 'api_key' => 'AIzaSyB1UZNnscjMDjjH-pi_XbnLRld2wAqi3Ek');
	$defaults['flickr'] = Array('title' => 'Flickr', 'follow' => '', 'limit' => 20);
	$defaults['delicious'] = Array('title' => 'Delicious', 'follow' => 'Follow on Delicious', 'limit' => 10);
	$defaults['digg'] = Array('title' => 'Latest Diggs','limit' => 10);
	$defaults['pinterest'] = Array('title' => 'Pinterest', 'follow' => 'Follow on Pinterest', 'limit' => 10);
	$defaults['rss'] = Array('title' => 'Subscribe to our RSS', 'follow' => 'Subscribe', 'limit' => 10, 'text' => 'contentSnippet');
	$defaults['lastfm'] = Array('title' => 'Last.fm', 'follow' => '', 'limit' => 10, 'feed' => 'recenttracks');
	$defaults['dribbble'] = Array('title' => 'Dribbble', 'follow' => 'Follow on Dribbble', 'limit' => 10, 'feed' => 'shots');
	$defaults['vimeo'] = Array('title' => 'Vimeo', 'follow' => 'Follow on Vimeo', 'limit' => 10, 'feed' => 'likes', 'thumb' => 'small');
	$defaults['stumbleupon'] = Array('title' => 'Stumbleupon', 'follow' => 'Follow', 'limit' => 10, 'feed' => 'favorites');
	$defaults['deviantart'] = Array('title' => 'Deviantart', 'follow' => 'Follow', 'limit' => 10);
	$defaults['tumblr'] = Array('title' => 'Tumblr', 'follow' => 'Follow', 'limit' => 10, 'thumb' => 250, 'video' => 250);
	$defaults['linkedin'] = Array('plugins' => 'CompanyProfile,MemberProfile', 'MemberProfile' => 'true', 'CompanyProfile' => 'true');
	$defaults['instagram'] = Array('title' => 'Instagram', 'limit' => 10, 'thumb' => 'low_resolution', 'accessToken' => '', 'redirectUrl' => '', 'clientId' => '', 'comments' => 3, 'likes' => 8);
	
	
	$help = Array();
	$help['twitter'] = Array('id' => 'Enter a twitter username without the "@"<br />To use a twitter list enter the username followed by "/" then the list ID - e.g. designchemical/123456<br />To display a twitter search enter "#" followed by the search term - e.g. #designchemical', 'title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'followId' => 'Enter the twitter user name to be used for the follow button if using a search or list', 'limit' => 'Maximum number of results', 'retweets' => 'Include retweets', 'replies' => 'Include replies', 'images' => 'Include Twitter images', 'consumer_key' => 'Required (See plugin documentation - FAQ -> Twitter API Credentials)', 'consumer_secret' => 'Required', 'access_token' => 'Required', 'access_token_secret' => 'Required');
	$help['facebook'] = Array('id' => 'Enter your facebook page ID/username', 'title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results', 'fb_app_id' => 'Required (See plugin documentation Social Network APIs & Authentication -> Facebook APP Details)', 'fb_app_secret' => 'Required');
	$help['fblike'] = Array('id' => 'Enter your facebook page ID', 'limit' => 'Maximum number of results', 'stream' => 'Include facebook stream', 'header' => 'Include facebook header');
	$help['fbrec'] = Array('id' => 'Enter the domain URL - e.g. http://www.designchemical.com', 'header' => 'Include facebook header', 'feed' => 'Select facebook plugin type');
	$help['google'] = Array('id' => 'Enter your Google +1 profile ID', 'title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'header' => 'Include Google +1 page widget - requires Page ID', 'pageId' => 'Google +1 ID for page', 'image_width' => 'Thumbnail width in pixels', 'image_height' => 'Thumbnail height in pixels', 'api_key' => 'Google API KEY - required', 'limit' => 'Maximum number of results');
	$help['youtube'] = Array('id' => 'Enter a Youtube Channel ID', 'api_key' => 'Youtube API KEY - required', 'limit' => 'Maximum number of results');
	$help['flickr'] = Array('id' => '1. Enter a Flickr username ID<br />2. To use a flickr group enter "/" followed by the group ID - e.g. /646972@N21', 'title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results');
	$help['delicious'] = Array('id' => 'Enter a Delicious username','title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results');
	$help['digg'] = Array('id' => 'Enter a Digg username', 'title' => 'Text for header', 'limit' => 'Maximum number of results');
	$help['pinterest'] = Array('id' => '1. Enter a Pinterest username<br />2. To show a Pinterest board enter the username, then "/" followed by the board name - e.g. designchemical/designchemical-premium-plugins', 'title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results');
	$help['rss'] = Array('id' => 'Enter the URL for the RSS feed', 'title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results', 'text' => 'Show full post text or snippet');
	$help['lastfm'] = Array('id' => 'Enter a last.fm username', 'title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results', 'feed' => 'Data feed to be shown');
	$help['dribbble'] = Array('id' => 'Enter a Dribbble username','title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results', 'feed' => 'Data feed to be shown');
	$help['vimeo'] = Array('id' => 'Enter a Vimeo username','title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results', 'feed' => 'Data feed to be shown', 'thumb' => 'Size of thumbnail image');
	$help['stumbleupon'] = Array('id' => 'Enter a Stumbleupon username','title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results', 'feed' => 'Data feed to be shown');
	$help['deviantart'] = Array('id' => 'Enter a Deviantart username','title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results');
	$help['tumblr'] = Array('id' => 'Enter a Tumblr username','title' => 'Text for header - leave blank to remove header', 'follow' => 'Text for follow button - leave blank to remove button', 'limit' => 'Maximum number of results', 'thumb' => 'Select thumbnail size', 'video' => 'Select video size');
	$help['linkedin'] = Array('id' => 'The LinkedIn tab can contain up to 4 linkedin widgets, each requiring its own ID:<br /> - MemberProfile - LinkedIn user public profile URL - e.g. http://www.linkedin.com/in/leechestnutt<br /> - CompanyProfile, CompanyInsider & JYMBII - Company ID - e.g. 162479<br />Enter the IDs separated by a comma in the same order as the widgets - e.g.<br />http://www.linkedin.com/in/leechestnutt,162479,162479,162479', 'plugins' => 'The plugins to be shown in the the order in which they appear separated by a comma.<br />Options are: CompanyProfile, MemberProfile, CompanyInsider, JYMBII', 'MemberProfile' => 'Select true to include list of profile connections for Member Profile widget', 'CompanyProfile' => 'Select true to include list of profile connections for Company Profile widget');
	$help['instagram'] = Array('id' => 'Enter a user ID starting with a "!" - e.g. !12345<br />To search by tag start with the character "#" followed by the tag - e.g. #london<br />To show latest posts by a location ID start with a "@" followed by the ID - e.g. @12345<br />To search by geographical location start with the character "?" followed by the latitude, longitude and distance in meters<br />(up to a maximum of 5000) all separated by a "/" - e.g. ?55.5/0/20','title' => 'Text for header - leave blank to remove header', 'limit' => 'Maximum number of results', 'thumb' => 'Select thumbnail size', 'comments' => 'Number of comments to display', 'likes' => 'Number of likes to display', 'accessToken' => 'Enter API access token', 'redirectUrl' => 'Enter API redirect_uri', 'clientId' => 'Enter API client ID');
	
	if($a == 'networks'){
		return $networks;
	} else if($a == 'defaults'){
		return $defaults;
	} else if($a == 'settings'){
		return $settings;
	} else if($a == 'help'){
		return $help;
	} else {
		return $Ids;
	}
}

function dcsnt_default_pickers()
{
	$out = Array('twitter' => '#4ec2dc', 'facebook' => '#3b5998', 'fblike' => '#3b5998', 'fbrec' => '#3b5998','google' => '#2d2d2d','rss' => '#FF9800','flickr' => '#f90784','delicious' => '#3271CB','youtube' => '#DF1F1C','digg' => '#195695','pinterest' => '#CB2528','lastfm' => '#C90E12','dribbble' => '#F175A8', 'vimeo' => '#4EBAFF', 'stumbleupon' => '#EB4924', 'deviantart' => '#B8C529', 'tumblr' => '#365472', 'linkedin' => '#006DA7', 'instagram' => '#413A33');
	return $out;
}

function dcsnt_custom_css()
{

	$options = get_option('dcsnt_options');
	$networks = dcsnt_networks('networks');
	$out = '';
	
	// networks
	foreach($networks as $k => $v){
		$c = $options['color_'.$k] != '' ? $options['color_'.$k] : $def_color[$k];
		$out .= '.tab-'.$k.',.tab-'.$k.' .dcsmt-btn, li.active.dcsmt-'.$k.', li.dcsmt-'.$k.':hover{background-color:'.$c.';}';
	}
		
	// tabs
	$c = $options['color_tab'] != '' ? $options['color_tab'] : '#777';
	$out .= '.social-tabs li {background:'.$c.';}';
		
	// custom css
	$out .= $options['css'] != '' ? $options['css'] . "\n" : '' ;
	
	// hide mobile
	if($options['hide_mobile'] == 'true'){
		$out .= '@media only screen and (max-width: 400px) {.dcsnt {display: none;}}';
	}

	// Output styles
	if ($out != '') {
		$out = $out != '' ? "<!-- Custom Styling Social Network Tabs -->\n<style type=\"text/css\">\n" . $out . "</style>\n" : '' ;
	}
		
	return $out;
}

function get_dcsnt_default($option)
{
	$options = get_option('dcsnt_options');
	return $options[$option];
}

function dcsnt_switch($v, $name, $id = null)
{
	$out = '<div class="dcsnt-switch-link">';
	$out .= '<a href="#" rel="true" class="link-true ';
	$out .= $v == 'true' ? 'active' : '' ;
	$out .= '"></a>';
	$out .= '<a href="#" rel="false" class="link-false ';
	$out .= $v == 'false' ? 'active' : '' ;
	$out .= '"></a></div>';
	$out .= '<input id="'.$id.'" name="'.$name.'" class="dc-switch-value" type="hidden" value="'.$v.'" />';
	
	return $out;
}

function dcsnt_select($f, $k, $v, $o)
{
	
	$out = '<select name="dcsnt_options['.$f.']['.$k.']" id="dcsnt_'.$f.'_'.$k.'" class="select">';
	
	foreach($o as $opt => $name){
		$select = $v == $opt ? ' selected="selected"' : '' ;
		$out .= '<option value="'.$opt.'"'.$select.'>'.$name.'</option>';
	}
	$out .= '</select>';
	
	return $out;
}

function dcsnt_show()
{
	global $post;
	$options = get_option('dcsnt_options');
	$meta = get_post_meta($post->ID, 'dc_social_tabs', true);
	$show = '0';
	
	if($meta)
	{
		if($meta == 'true'){
			$show = 1;
		} else if($meta == 'false'){
			$show = 0;
		}
	}
	else
	{
		if(is_single()){
			$show = $options['show_post'] == 'true' ? 1 : 0;
		}
		if(is_page()){
			$show = $options['show_page'] == 'true' ? 1 : 0;
		}
		if(is_front_page()){
			$show = $options['show_home'] == 'true' ? 1 : 0;
		}
		if(is_home()){
			$show = $options['show_blog'] == 'true' ? 1 : 0;
		}
		if(is_category()){
			$show = $options['show_category'] == 'true' ? 1 : 0;
		}
		if(is_archive()){
			$show = $options['show_archive'] == 'true' ? 1 : 0;
		}
	}
		
	return $show;
}

/* Time since function taken from WordPress.com */
if (!function_exists('dctsp_wpcom_time_since')) :

function dcsnt_wpcom_time_since( $original, $do_more = 0 ) {
        // array of time period chunks
        $chunks = array(
                array(60 * 60 * 24 * 365 , 'yr'),
                array(60 * 60 * 24 * 30 , 'month'),
                array(60 * 60 * 24 * 7, 'week'),
                array(60 * 60 * 24 , 'day'),
                array(60 * 60 , 'hr'),
                array(60 , 'min'),
        );

        $today = time();
        $since = $today - $original;

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
                $seconds = $chunks[$i][0];
                $name = $chunks[$i][1];

                if (($count = floor($since / $seconds)) != 0)
                    break;
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

        if ($i + 1 < $j) {
                $seconds2 = $chunks[$i + 1][0];
                $name2 = $chunks[$i + 1][1];

                // add second item if it's greater than 0
                if ( (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) && $do_more )
                        $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        }
        $print = $print == '42 yrs' ? '' : $print ;
		return $print;
}
endif;

?>