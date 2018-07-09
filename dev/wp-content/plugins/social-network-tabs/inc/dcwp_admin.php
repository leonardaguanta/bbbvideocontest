<?php
require_once('dcwp_plugin_admin.php');

if(!class_exists('dc_jqsocialtabs_admin')) {
	
	class dc_jqsocialtabs_admin extends dcwp_plugin_admin_dcsnt {
	
		var $hook = 'social-network-tabs';
		var $longname = 'Social Network Tabs Configuration';
		var $shortname = 'Social Network Tabs';
		var $filename = 'social-network-tabs/dcwp_social_network_tabs.php';
		var $imageurl = 'http://www.designchemical.com/media/images/social_network_tabs.png';
		var $homepage = 'http://www.designchemical.com/blog/index.php/premium-wordpress-plugins/premium-wordpress-plugin-social-network-tabs/';
		var $homeshort = 'http://bit.ly/GN6UuY';
		var $twitter = 'designchemical';
		var $title = 'Wordpress Premium Plugin Social Network Tabs';
		var $description = 'Combine all of your favorite social networks profiles & feeds into slick slide out or static tabs. Twitter Latest Tweets, Facebook Like Box & Recommendations Google +1 Feed, Tumblr, Instagram feed or search, RSS Feed, Delicious, Latest Diggs, Stumbleupon, Pinterest, Youtube Latest Uploads or Favorites, Flickr, last.fm loved tracks, recent tracks or reply tracker, Deviantart, Dribble shots/likes & vimeo likes, videos, appears_in, all_videos, albums, channels or groups';
		
		function __construct() {
		
			parent::__construct();
			add_action('admin_init', array(&$this,'settings_init'));
			add_action("admin_init",array(&$this,'add_dcsnt_option_styles'));
			add_action("admin_init",array(&$this,'add_dcsnt_option_scripts'));
			add_action('wp_ajax_dcsnt_update', array(&$this,'dcsnt_ajax_update'));
			
		}
		 
		function settings_init() {
		
			register_setting('dcsnt_options_group', 'dcsnt_options');
		}

		// AJAX updates for settings
		function dcsnt_ajax_update(){
		
			$option_name = $_POST['option_name'];
			$newvalue = $_POST['option_value'];
			
			if ( get_option( $option_name ) != $newvalue ) {
				update_option( $option_name, $newvalue );
			} else {
				$deprecated = ' ';
				$autoload = 'no';
				add_option( $option_name, $newvalue, $deprecated, $autoload );
			}
			
			if(isset($_POST['option_name1'])){
				$option_name1 = $_POST['option_name1'];
				$newvalue1 = $_POST['option_value1'];
				
				if ( get_option( $option_name1 ) != $newvalue1 ) {
					update_option( $option_name1, $newvalue1 );
				} else {
					$deprecated = ' ';
					$autoload = 'no';
					add_option( $option_name1, $newvalue1, $deprecated, $autoload );
				}
			}
			
			exit;
		}
		
		function option_page() {
			
			global $wpdb;
			$this->setup_admin_page('Social Network Tabs Settings','Social Networks');
		?>
		
		<script type="text/javascript">
		(function($){
			var initLayout = function() {
			$('.color-selector').each(function(){
				var o = $(this);
				var c = $(this).next('.input-color');
				$(this).ColorPicker({
					color: c.val(),
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						var hx = $('.colorpicker_hex input',colpkr).val();
						var id = o.attr('id');
						$('#'+id+'_input').val('#'+hx);
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$('div',o).css('backgroundColor', '#' + hex);
					}
				});
			});
		};
	
		EYE.register(initLayout, 'init');
})(jQuery)

jQuery(document).ready(function($) {
				var loadOrder = [];
	$("#dcsnt-sortable li").each(function(){
		var rel = $(this).attr('rel');
		var i = $(this).index('#dcsnt-sortable li');
		loadOrder.push(rel);
	});
	
	$('#dcsnt-order').val(loadOrder);
			$("#dcsnt-sortable").sortable({
				placeholder: "sort-holder",
				stop: function(event, ui) {
					var sortOrder = [];
					$("#dcsnt-sortable li.dcsnt-sortable-li").each(function(){
						var rel = $(this).attr('rel');
						var i = $(this).index('#dcsnt-sortable li.dcsnt-sortable-li');
						sortOrder.push(rel);
					});
					$('#dcsnt-order').val(sortOrder);
				}
			});
			$( "#dcsnt-sortable" ).disableSelection();
			$('#dcsnt-sortable input').bind('click.sortable mousedown.sortable',function(ev){
				ev.target.focus();
			});
		});
		</script>
		
			<?php 
				//delete_option('dcsnt_options');
				settings_fields('dcsnt_options_group'); $options = get_option('dcsnt_options');
				$networks = dcsnt_networks('networks');
				$titles = dcsnt_networks('Ids');
				$defaults = dcsnt_networks('defaults');
				$settings = dcsnt_networks('settings');
				$helptext = dcsnt_networks('help');
				$colors = dcsnt_default_pickers();
				
				$all_networks = '';
				$i = 0;
				foreach($networks as $k=>$v){
					$all_networks .= $i > 0 ? ',' : '' ;
					$all_networks .= $k;
					$i++;
				}
				
				if($options['dcsnt_order'] != ''){
				
					$dcsnt_order = $options['dcsnt_order'];
					
					// Check for new networks
					$check = explode(',', $all_networks);
					foreach($check as $function){
					
						if($function != '' && !strlen(strstr($dcsnt_order, $function))>0){
							
							$dcsnt_order .= ','.$function;
						}
					}
				} else {
					$dcsnt_order = $all_networks;
				}
				
				if(!isset($options['skin'])){
					$options['skin'] = 'true';
				}
				$skin = $options['skin'];
				$help = '<a href="#" class="dcsnt-help"><img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/help.png" alt="?" /></a>';
				$close = '<a href="#" class="dcsnt-close"><img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/close.png" alt="x" /></a>';
				$close_1 = '<img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/close_1.png" alt="?" />';
				$close_2 = '<img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/close_2_off.png" alt="?" class="img-swap" />';
				$load = '<img src="'.dc_jqsocialtabs::get_plugin_directory().'/images/loading.gif" alt="Loading" />';

				if(!isset($options['settings']['loc'])){
					$options['settings']['loc'] = '';
				}
		if(!isset($options['settings']['location'])){
			$options['settings']['location'] = '';
			}
		if(!isset($options['settings']['align'])){
		$options['settings']['align'] = '';
		}
		if(!isset($options['settings']['offset'])){
		$options['settings']['offset']='';
		}
		if(!isset($options['settings']['speed'])){
		$options['settings']['speed']='';
		}
		if(!isset($options['settings']['loadOpen'])){
		$options['settings']['loadOpen']='';
		}
		if(!isset($options['settings']['autoClose'])){
		$options['settings']['autoClose']='';
		}
		if(!isset($options['settings']['width'])){
		$options['settings']['width']='';
		}
		if(!isset($options['settings']['height'])){
		$options['settings']['height']='';
		}
		if(!isset($options['settings']['start'])){
		$options['settings']['start']='';
		}
		if(!isset($options['settings']['controls'])){
		$options['settings']['controls']='';
		}
		if(!isset($options['settings']['rotate_direction'])){
		$options['settings']['rotate_direction']='';
		}
		if(!isset($options['settings']['rotate_delay'])){
		$options['settings']['rotate_delay']='';
		}
		if(!isset($options['settings']['zopen'])){
		$options['settings']['zopen']='';
		}
		if(!isset($options['settings']['zclosed'])){
		$options['settings']['zclosed']='';
		}

			?>
			<p style="padding:10px 15px;">Click the "On" switch to include the social network. Drag/drop the icons to change the display order<?php echo $help; ?></p>
			
			<div class="dcsnt-help-text">
				<h3>Help<?php echo $close; ?></h3>
				<h4>Social Networks</h4>
				<p>This section allows you to select and set up the social networks that you want to include on the front-end tabs. To add a social network click on the relevant icon and set the "On/Off" switch to "on".</p>
				<p>Complete the relevant details for the network - the most critical being the "ID". If a valid ID is not used the network tab may not work.</p>
				<h4>Change Display Order</h4>
				<p>The social network tabs will be displayed in the same order that the icons appear below. To change the order drag/drop the relevant icon to its new position</p>
				<p>Note: make sure that the "save changes" buttons is clicked whenever updates are made.</p>
			</div>
			<div>
			</div>
			<ul class="dcsnt-plugin" id="dcsnt-sortable">
			
			<?php
				$css = '';
				$count_networks = 0;
				$order = explode(',', $dcsnt_order);
					
				foreach($order as $function){
					
					if($function != ''){

						$css .= '.dcsnt-sortable-li.li-'.$function.' a:hover, .dcsnt-sortable-li.li-'.$function.'.active a {background:'.$colors[$function].';}';
					?>
						<li rel="<?php echo $function; ?>" class="dcsnt-sortable-li li-<?php echo $function; ?>">
							<?php
							
								$src = dc_jqsocialtabs::get_plugin_directory().'/images/icons/'.$function.'.png';
								echo '<a href="#" class="icon-bg"><img src="'.$src.'" alt="" id="img-icon-'.$function.'" /></a>';
							
							?>
						</li>
					<?php
						$count_networks++;
					}
				}
			?>
			</ul>
			<style><?php echo $css; ?></style>
			<div id="network-tab-container">
			<?php
			foreach($order as $function){
					
					if($function != ''){
					
						$src = dc_jqsocialtabs::get_plugin_directory().'/images/icons/'.$function.'.png';
						$h4 = '<img src="'.$src.'" alt="" style="background:'.$colors[$function].';" />';
						$val = $options[$function.'_inc'] ? $options[$function.'_inc'] : 'false' ;
						
						?>
						<div class="network-tab" rel="<?php echo $function; ?>">
							<div class="network-header">
								<h4><?php echo $h4 . $networks[$function]; ?></h4>
								<div class="dcsnt-switch-link">
									<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
									<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
								</div>
								<input id="dcsnt_<?php echo $function; ?>" name="dcsnt_options[<?php echo $function; ?>_inc]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
							</div>
							<div class="network-options">
								<?php
									$idv = $options[$function.'Id'] != '' ? $options[$function.'Id'] : '' ;
									$dClass = $idv == '' ? 'defaultText' : 'defaultText defaultTextActive' ;
								?>
								<ul>
								<li class="icon-row">
									<label>ID:</label>
									<input id="dcsnt_<?php echo $function.'Id'; ?>" name="dcsnt_options[<?php echo $function.'Id'; ?>]" class="text-input-id <?php echo $dClass; ?> text-input" type="text" value="<?php echo $idv; ?>" title="<?php echo $titles[$function]; ?>" />
									<span class="help-text"><?php echo $helptext[$function]['id']; ?></span>
								</li>
								<?php
									$list = '';
									
									foreach($defaults[$function] as $k=>$v){
										
										$label = $k == 'limit' ? '# posts' : $k ;
										if($options['new_install'] == 'no'){
											$idv = $options[$function][$k];
										} else {
											$idv = $options[$function][$k] != '' ? $options[$function][$k] : $v ;
										}
										$e = '<input id="dcsnt_'.$function.'_'.$k.'" name="dcsnt_options['.$function.']['.$k.']" class="text-input" type="text" value="'.$idv.'" />';
										
										if($function == 'google'){
											if($k == 'image_width'){
												$label = 'image width';
											} else if($k == 'image_height'){
												$label = 'image height';
											} else if($k == 'pageId'){
												$label = 'page ID';
											} else if($k == 'header'){
												$o = Array(0 => 'None', 1 => 'Small', 2 => 'Standard');
												$e = dcsnt_select($function, $k, $idv, $o);
											}
										} else if($function == 'twitter'){
											if($k == 'thumb'){
												$o = Array('false' => 'No Image', 'true' => 'Include Image');
												$e = dcsnt_select($function, $k, $idv, $o);
											} else if($k == 'replies'){
												$o = Array('false' => 'No Replies', 'true' => 'Include Replies');
												$e = dcsnt_select($function, $k, $idv, $o);
											} else if($k == 'retweets'){
												$o = Array('false' => 'No Retweets', 'true' => 'Include Retweets');
												$e = dcsnt_select($function, $k, $idv, $o);
											} else if($k == 'images'){
												$o = Array('' => 'None', 'thumb' => 'Thumb - w: 150px h: 150px', 'small' => 'Small - w: 340px h 150px', 'medium' => 'Medium - w: 600px h: 264px', 'large' => 'Large - w: 786px h: 346px');
												$e = dcsnt_select($function, $k, $idv, $o);
											} else if($k == 'consumer_key'){
												$label = 'consumer key';
											} else if($k == 'consumer_secret'){
												$label = 'consumer secret';
											} else if($k == 'access_token'){
												$label = 'access token';
											} else if($k == 'access_token_secret'){
												$label = 'access token secret';
											}
											
										} else if($function == 'rss' && $k == 'text'){
											$o = Array('contentSnippet' => 'Snippet', 'content' => 'All Text');
											$e = dcsnt_select($function, $k, $idv, $o);
										}  else if($function == 'facebook'){
											if($k == 'fb_app_id'){
												$label = 'FB App ID';
											} else if($k == 'fb_app_secret'){
												$label = 'App Secret';
											}
										} else if($function == 'fblike'){
											if($k == 'header' || $k == 'stream'){
												$e = dcsnt_switch($idv, 'dcsnt_options['.$function.']['.$k.']', 'dcsnt_'.$function.'_'.$k); 
											}
										} else if($function == 'fbrec'){
											if($k == 'header'){
												$e = dcsnt_switch($idv, 'dcsnt_options['.$function.']['.$k.']', 'dcsnt_'.$function.'_'.$k); 
											} else if($k == 'feed'){
												$o = Array('all' => 'Activity + Recommendations', 'activity' => 'Recent Activity', 'recommendations' => 'Recommendations');
												$e = dcsnt_select($function, $k, $idv, $o);
											}
									//	} else if($function == 'youtube' && $k == 'feed'){
									//		$o = Array('uploads' => 'Uploads', 'favorites' => 'Favorites');
									//		$e = dcsnt_select($function, $k, $idv, $o);
										} else if($function == 'lastfm' && $k == 'feed'){
											$o = Array('recenttracks' => 'Recent Tracks', 'lovedtracks' => 'Loved Tracks', 'replytracker' => 'Reply Tracker');
											$e = dcsnt_select($function, $k, $idv, $o);
										} else if($function == 'dribbble' && $k == 'feed'){
											$o = Array('shots' => 'Shots', 'likes' => 'Likes');
											$e = dcsnt_select($function, $k, $idv, $o);
										} else if($function == 'stumbleupon' && $k == 'feed'){
											$o = Array('favorites' => 'Favorites', 'reviews' => 'Reviews');
											$e = dcsnt_select($function, $k, $idv, $o);
										} else if($function == 'vimeo'){
											if($k == 'feed'){
												$o = Array('likes' => 'Most recent likes','videos' => 'Videos created by user','appears_in' => 'Videos that the user appears in','all_videos' => 'Videos that the user appears in and created','albums' => 'Albums the user has created','channels' => 'Channels the user has created and subscribed to','groups' => 'Groups the user has created and joined');
												$e = dcsnt_select($function, $k, $idv, $o);
											} else if($k == 'thumb'){
												$o = Array('small' => 'Small 100px wide', 'medium' => 'Medium 200px wide', 'large' => 'Large 640px wide');
												$e = dcsnt_select($function, $k, $idv, $o);
											}
										} else if($function == 'tumblr'){
											if($k == 'video'){
												$o = Array('250' => '250px wide', '400' => '400px wide', '500' => '500px wide');
												$e = dcsnt_select($function, $k, $idv, $o);
											} else if($k == 'thumb'){
												$o = Array('250' => '250px wide', '75' => '75px wide', '100' => '100px wide', '400' => '400px wide', '500' => '500px wide', '1280' => '1280px wide');
												$e = dcsnt_select($function, $k, $idv, $o);
											}
										} else if($function == 'linkedin'){
											if($k == 'MemberProfile' || $k == 'CompanyProfile'){
												$idv = $idv == '' ? 'true' : $idv ;
												$label = $k == 'MemberProfile' ? 'Member Profile' : 'Company Profile' ;
												$e = dcsnt_switch($idv, 'dcsnt_options['.$function.']['.$k.']', 'dcsnt_'.$function.'_'.$k); 
											}
										} else if($function == 'instagram' && $k == 'thumb'){
											$o = Array('low_resolution' => '306 px', 'thumbnail' => '150 px', 'standard_resolution' => '612 px');
											$e = dcsnt_select($function, $k, $idv, $o);
										}
										$list .= '<li><label>'.$label.':</label>'.$e.'<span class="help-text">'.$helptext[$function][$k].'</span></li>';
									}
									echo $list;
								?>
								</ul>
							</div>
						</div>
				<?php 
				}
			}
			?>
			</div>
			<input type="hidden" value="<?php echo $dcsnt_order; ?>" name="dcsnt_options[dcsnt_order]" id="dcsnt-order" />
			
			<div class="clear"></div>
			</div></div></div></div>
			
			<!-- Start Widget -->
			<div class="metabox-holder">
				  <div class="meta-box-sortables min-low">
				    <div class="postbox dcwp">
					  <h3 class="hndle"><span>Settings</span><?php echo $help; ?></h3>
					  <div class="inside">
					  <div class="dcsnt-help-text">
						<h3>Help<?php echo $close; ?></h3>
						<h4>Settings</h4>
						<p>The settings section allows you to configure the overall features of the social network tabs:</p>
						<ul>
							<li class="clear"><label>Location:</label> The location is only relevant for "slide out" tabs. This lets you select where the tabs will be located in the browser window.</li>
							<li><label>Offset:</label>The number of pixels from the edge of the browser window.</li>
							<li class="clear"><label>Width:</label>The width of the tabs in pixels</li>
							<li><label>Height:</label>The height of the tabs in pixels</li>
							<li class="clear"><label>Rotate Delay:</label>Enter the number of seconds between each feed item. To disable the rotating feed option set the delay to zero.</li>
							<li><label>Rotate Direction:</label>Sets the rotating feed direction to either "up" or "down"</li>
							<li class="clear"><label>Share Links:</label>Set to "on" to include facebook & twitter share links in each post</li>
							<li class="clear"><label>Twitter ID:</label>Enter the twitter username to use in twitter share links - will appear at the end of tweets as "via @username"</li>
							<li class="clear"><label>Load Open:</label>When set to "on" the "slide out" tabs will automatically open when the page loads.</li>
							<li><label>Auto Close:</label>When set to "on" the "slide out" tabs will automatically close if the user clicks anywhere outside of the tabs.</li>
							<li class="clear"><label>Animation Speed:</label>The speed (in seconds) for the slide out animation.</li>
							<li><label>Start Tab:</label>Select which tab you would like to show when first loaded.</li>
							<li class="clear"><label>Controls:</label>When set to "on" a control bar will appear at the bottom of each tab when the user hovers over the content. The control navigation allows the user to stop/start the rotating feed, go to next/previous entry or close the slide out tabs.</li>
							<li><label>Open Links In New Window:</label>Select "on" to open all links in a new browser window</li>
							<li class="clear"><label>z-index Open:</label>z-index of the network tabs when open.</li>
						</ul>
						<div class="clear"></div>
					</div>
				
				<ul class="list-styles half list-switches">
					<li>
						<label>Location:</label>
						<?php $val = $options['settings']['loc'] != '' ? $options['settings']['loc'] : 5 ; ?>
						<select name="dcsnt_options[settings][loc]" id="dcsnt_setting_loc" class="select">
							<option value="1" <?php if ($val == 1) { echo 'selected="selected"'; }?>>Top Right</option>
							<option value="2" <?php if ($val == 2) { echo 'selected="selected"'; }?>>Top Left</option>
							<option value="3" <?php if ($val == 3) { echo 'selected="selected"'; }?>>Bottom Right</option>
							<option value="4" <?php if ($val == 4) { echo 'selected="selected"'; }?>>Bottom Left</option>
							<option value="5" <?php if ($val == 5) { echo 'selected="selected"'; }?>>Right</option>
							<option value="6" <?php if ($val == 6) { echo 'selected="selected"'; }?>>Left</option>
						</select>
				  </li>
				  <li>
					<label>Offset:</label>
					<?php $val = $options['settings']['offset'] != '' ? $options['settings']['offset'] : 30 ; ?>
					<input id="dcsnt_setting_offset" name="dcsnt_options[settings][offset]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
					<li>
					<label>Width:</label>
					<?php $val = $options['settings']['width'] != '' ? $options['settings']['width'] : 360 ; ?>
					<input id="dcsnt_setting_width" name="dcsnt_options[settings][width]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Height:</label>
					<?php $val = $options['settings']['height'] != '' ? $options['settings']['height'] : 490 ; ?>
					<input id="dcsnt_setting_height" name="dcsnt_options[settings][height]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Rotate Delay:</label>
					<?php $val = $options['settings']['rotate_delay'] != '' ? $options['settings']['rotate_delay'] : 6 ; ?>
					<input id="dcsnt_setting_rotate_delay" name="dcsnt_options[settings][rotate_delay]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Rotate Direction:</label>
					<?php $val = $options['settings']['rotate_direction'] != '' ? $options['settings']['rotate_direction'] : 'down' ; ?>
					<input type="radio" class="radio" value="up" name="dcsnt_options[settings][rotate_direction]" <?php if ($val == 'up') { echo 'checked="checked"'; }?> /> Up 
					<input type="radio" class="radio" value="down" name="dcsnt_options[settings][rotate_direction]" <?php if ($val == 'down') { echo 'checked="checked"'; }?>/> Down
				  </li>
				  <li>
					<label>Share Links:</label>
					<?php
						$val = $options['settings']['share'] != '' ? $options['settings']['share'] : 'true' ;
					?>
					<div class="dcsnt-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcsnt_setting_share" name="dcsnt_options[settings][share]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				  
				  <li>
					<label>Twitter ID:</label>
					<?php $val = $options['settings']['tweetId'] != '' ? $options['settings']['tweetId'] : '' ; ?>
					<input id="dcsnt_setting_tweetId" name="dcsnt_options[settings][tweetId]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				</ul>
				<ul class="list-styles half list-switches">
				  <li>
					<label>Load Open:</label>
					<?php
						$val = $options['settings']['loadOpen'] != '' ? $options['settings']['loadOpen'] : 'false' ;
					?>
					<div class="dcsnt-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcsnt_setting_loadOpen" name="dcsnt_options[settings][loadOpen]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Auto Close:</label>
					<?php
						$val = $options['settings']['autoClose'] != '' ? $options['settings']['autoClose'] : 'false' ;
					?>
					<div class="dcsnt-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcsnt_setting_autoClose" name="dcsnt_options[settings][autoClose]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Controls:</label>
					<?php
						$val = $options['settings']['controls'] != '' ? $options['settings']['controls'] : 'true' ;
					?>
					<div class="dcsnt-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcsnt_setting_controls" name="dcsnt_options[settings][controls]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Animation Speed:</label>
					<?php $val = $options['settings']['speed'] != '' ? $options['settings']['speed'] : 0.6 ; ?>
					<input id="dcsnt_setting_speed" name="dcsnt_options[settings][speed]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Start Tab:</label>
					<?php $val = $options['settings']['start'] != '' ? $options['settings']['start'] : 0 ; ?>
					<select name="dcsnt_options[settings][start]" id="dcsnt_setting_start" class="select">
					
						<?php
							$start_opt = 1;
							while($start_opt <= $count_networks)
							{
								$opt_val = $start_opt - 1;
								$selected = $val == $opt_val ? ' selected="selected"' : '' ;
								echo '<option value="'.$opt_val.'"'.$selected.'>Tab '.$start_opt.'</option>';
								$start_opt++;
							}
						?>
					</select>
				  </li>
				  <li class="tall">
					<label>Open Links In New Window:</label>
					<?php
						$val = $options['settings']['external'] != '' ? $options['settings']['external'] : 'true' ;
					?>
					<div class="dcsnt-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcsnt_setting_external" name="dcsnt_options[settings][external]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				</ul>
				<div class="clear"></div>
				<h4>Advanced Settings - Only adjust these values if necessary.</h4>
				<ul class="list-styles half list-switches">
					<li>
						<label>z-index Open:</label>
						<?php $val = $options['settings']['zopen'] != '' ? $options['settings']['zopen'] : 1000 ; ?>
						<input id="dcsnt_setting_zopen" name="dcsnt_options[settings][zopen]" class="text-input" type="text" value="<?php echo $val; ?>" />
					</li>
				</ul>
				
				<input id="dcsnt_setting_imagePath" name="dcsnt_options[settings][imagePath]" type="hidden" value="" />
				<div class="clear"></div>
			</div></div></div></div>
			
			<?php 
				// styling
				$skin = $options['skin'] != '' ? $options['skin'] : 'true' ;
				$hide_mobile = $options['hide_mobile'] != '' ? $options['hide_mobile'] : 'false' ;
				$def_color = dcsnt_default_pickers(); 
			?>
					  
			<div class="metabox-holder">
				  <div class="meta-box-sortables">
				    <div class="postbox dcwp">
					  <h3 class="hndle"><span>Styling</span><?php echo $help; ?></h3>
					  <div class="inside">
					  <div class="dcsnt-help-text">
						<h3>Help<?php echo $close; ?></h3>
						<h4>Default Skin</h4>
						<p>Switch the default skin option to "Off" to stop the loading of the default CSS file.</p>
						<h4>Hide on Mobile</h4>
						<p>Switch to "On" to hide the tabs on screen sizes < 400px.</p>
						<h4>Default Tab Color</h4>
						<p>To change the default background color of the inactive tabs click on the colored box - a colorpicker should now appear. Select the new color and then click elsewhere on the screen to close the colorpicker widget. The colored box should now be updated using the new color.</p>
						<h4>Social Network Colors</h4>
						<p>These show the background colors used for the individual social networks. To change one of the network colors click on the relevant colored box - a colorpicker should now appear. Select the new color and then click elsewhere on the screen to close the colorpicker widget. The colored box should now be updated using the new color.</p>
						<h4>Custom CSS</h4>
						<p>Custom CSS for styling the social media tabs can be entered into the text field. Any CSS rules included in this text area will automatically be inserted into the page.</p>
					</div>

				<ul class="margin-bottom float-left">
					<li>
					  <label for="dcsnt_skin">Default Skin:</label>
					  <div class="dcsnt-switch-link link-skin">
						<a href="#" rel="true" class="link-true <?php echo $skin == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $skin == 'false' ? 'active' : '' ; ?>"></a>
						</div>
						<input id="dcsnt_skin" name="dcsnt_options[skin]" class="dc-switch-value" type="hidden" value="<?php echo $skin; ?>" />
					</li>
					<li>
					  <label for="dcsnt_hide_mobile">Hide on Mobile:</label>
					  <div class="dcsnt-switch-link link-hide-mobile">
						<a href="#" rel="true" class="link-true <?php echo $hide_mobile == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $hide_mobile == 'false' ? 'active' : '' ; ?>"></a>
						</div>
						<input id="dcsnt_hide_mobile" name="dcsnt_options[hide_mobile]" class="dc-switch-value" type="hidden" value="<?php echo $hide_mobile; ?>" />
					</li>
				</ul>
				
				<div class="default-styles <?php echo $skin; ?>">
					
					<h4>Default Tab Color</h4>
					<ul class="list-styles list-picker">
						<?php
							$c = $options['color_tab'] != '' ? $options['color_tab'] : '#777';
						?>
						<li><div id="picker_tab" class="color-selector"><div style="background-color: <?php echo $c; ?>;"></div></div>';
							<span>Background</span>
							<input class="input-color" name="dcsnt_options[color_tab]" id="picker_tab_input" type="hidden" value="<?php echo $c; ?>" />
						</li>
					</ul>
					
					<h4>Social Network Colors</h4>
					<ul class="list-styles list-picker">
						<?php
							foreach($networks as $k => $v){
								$c = $options['color_'.$k] != '' ? $options['color_'.$k] : $def_color[$k];
								echo '<li><div id="picker_'.$k.'" class="color-selector"><div style="background-color: '.$c.';"></div></div>';
								echo '<span>'.$v.'</span>';
								echo '<input class="input-color" name="dcsnt_options[color_'.$k.']" id="picker_'.$k.'_input" type="hidden" value="'.$c.'" /></li>';
							}
						?>
					</ul>
				</div>
				<ul class="clear">
					<li>
						<label for="dcsnt_css">Custom CSS:</label>
						<textarea class="dcwp-textarea" name="dcsnt_options[css]" id="dcsnt_css" rows="5"><?php echo $options['css']; ?></textarea>
					</li>
				</ul>
			</div></div></div></div>
			
			<div class="metabox-holder">
				  <div class="meta-box-sortables min-low">
				    <div class="postbox dcwp">
					  <h3 class="hndle"><span>Display</span><?php echo $help; ?></h3>
					  <div class="inside">
					  <div class="dcsnt-help-text">
						<h3>Help<?php echo $close; ?></h3>
						<p>The "Displaying" section allows you to quickly and easily add the social network tabs to various areas of your website.</p>
						<p>Note: Using these settings will only add the "slide out" version of the tabs. To use "static" or inline slide out tabs use the shortcode (see documentation). If using a shortcode please disable any relevant display sections to prevent problems with conflicting tabs.</p>
						<h4>Home Page</h4>
						<p>Add to your home page - only relevant if your home page has been set up in Wordpress as a static page, otherwise use the "Posts Page" option.</p>
						<h4>Pages</h4>
						<p>Add the social network tabs to all pages.</p>
						<h4>Posts Page</h4>
						<p>Adds the social network tabs to your posts page.</p>
						<h4>Category Pages</h4>
						<p>Add the social network tabs to category pages.</p>
						<h4>Posts</h4>
						<p>Add the social network tabs to all individual post pages.</p>
						<h4>Archive Pages</h4>
						<p>Add the social network tabs to archive pages.</p>
					</div>
					<p>Select the areas where you wish the social network tabs to appear:</p>
					<ul class="list-styles list-switches">
			<?php 
			
				$content = Array();
				$content = Array('Home Page' => 'show_home', 'Pages' => 'show_page', 'Posts Page' => 'show_blog', 'Category Pages' => 'show_category', 'Posts' => 'show_post', 'Archive Pages' => 'show_archive');
				
				foreach($content as $type => $v) {
		
						if($type != ''){
							?>
								<li rel="<?php echo $v; ?>">
									<label><?php echo $type; ?>:</label>
									<?php $val = $options[$v] != '' ? $options[$v] : 'false' ; ?>
									
									<div class="dcsnt-switch-link dcsnt-types-link">
										<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
										<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
									</div>
									<input id="dcsnt_<?php echo $type; ?>" name="dcsnt_options[<?php echo $v; ?>]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" rel="<?php echo $v; ?>" />
									
								</li>
							<?php
						}
				}
			?> 
			
			</ul>

			<?php 
				
				$this->close_admin_page();
		}
		
		function add_dcsnt_option_styles() {

		//	if (isset($_GET['page']) && ($_GET['page'] == $filename)){ 
				wp_enqueue_style("dcsnt_option_css", dc_jqsocialtabs::get_plugin_directory(). "/css/colorpicker.css");
		//	}
		}

		function add_dcsnt_option_scripts() {

		//	if (isset($_GET['page']) && ($_GET['page'] == $filename)){ 
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('dcsnt_option_eye', dc_jqsocialtabs::get_plugin_directory(). '/inc/js/eye.js');
				wp_enqueue_script('dcsnt_option_colorpicker', dc_jqsocialtabs::get_plugin_directory(). '/inc/js/colorpicker.js');
		//	}
		}
	}
}