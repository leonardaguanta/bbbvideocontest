<?php
/*
Template name: VideoFrame
*/
//add_filter('show_admin_bar', '__return_false');
$videoId = isset($_GET['vid_id']) ? $_GET['vid_id'] : '';

      //   echo "<link rel='stylesheet' id='flowplayer5-skins-css' href='http://releases.flowplayer.org/5.5.2/commercial/skin/all-skins.css?ver=5.5.2' type='text/css' media='all' />";
       //  echo "<link rel='stylesheet' id='flowplayer5-logo-origin-css' href='http://www.bbbvideocontest.org/dallas/wp-content/plugins/flowplayer5/frontend/assets/css/public-concat.min.css?ver=1.11.2' type='text/css' media='all' />";
  //       echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery.js?ver=1.11.3'></script>";
  //       echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>";
      //   echo "<script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/flowplayer5/frontend/assets/flowplayer/flowplayer.js?ver=4.9.6'></script>";

        get_header();
        echo "<link rel='stylesheet' id='flowplayer5-skins-css' href='https://releases.flowplayer.org/5.5.2/commercial/skin/all-skins.css' type='text/css' media='all' />";
        echo "<link rel='stylesheet' id='flowplayer5-logo-origin-css' href='https://d3vzs1kv29k6gk.cloudfront.net/dallas/wp-content/plugins/flowplayer5/frontend/assets/css/public-concat.min.css?x75485' type='text/css' media='all' />";
        echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery.js?ver=1.11.3'></script>";
        echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>";
        echo "<script type='text/javascript' src='https://d3vzs1kv29k6gk.cloudfront.net/dallas/wp-content/plugins/flowplayer5/frontend/assets/flowplayer/flowplayer.js?x75485'></script>";
      // echo "<script src='http://bbbvideocontest.platypustest.info/dev/wp-includes/js/zxcvbn.min.js' type='text/javascript'></script><script src='//w.likebtn.com/js/w/widget.js'></script><script src='//w.likebtn.com/js/w/widget.js'></script>";
        echo "<link rel='stylesheet' id='simplevotemestyle-css' href='http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/simple-vote-me/css/simplevoteme.css?ver=4.9.6' type='text/css' media='all'>";

        echo '<script type="text/javascript">
            /* <![CDATA[ */
            var gtsimplevotemeajax = {"ajaxurl":"http:\/\/bbbvideocontest.platypustest.info\/dev\/wp-admin\/admin-ajax.php"};
            /* ]]> */
            </script>';
        echo '<script type="text/javascript" src="http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/simple-vote-me/js/simple-vote-me.js?ver=4.9.6"></script>';

  echo '<input value="1" id="popup-video-ni" type="hidden"/>';
        if($videoId){
            echo do_shortcode('[flowplayer id="'. $videoId .'" pre-post-ad-video=1 autoplay="true" preload="auto"]'); 
            echo "<script>";
                echo "jQuery(window).load(function(){";
                    echo "setTimeout(function(){";
                        echo "jQuery('.flowplayer .fp-ui').trigger('click');";
                    echo "}, 2000);";
                echo "});";
            echo "</script>";

            $extra_video_info = get_post_meta($videoId);
            $videoName = $extra_video_info['fp5-mp4-video'][0];
            $videoName = basename($videoName, ".mp4");
			$auth = get_post($videoId); // gets author from post
			$authid  = $auth->post_author; // gets author id for the post
            $user_nicename = get_the_author_meta('user_nicename',$authid);
			$user_school_id = get_the_author_meta('school',$authid);//gets schoold id of user
			$school = get_post($user_school_id); // gets school 
			$school_name = $school->post_title;
			$extra_video_info = get_post_meta($videoId);
            $videoName = $extra_video_info['fp5-mp4-video'][0];
            $videoName = basename($videoName, ".mp4");	
			
            $ga1 = new Platypus_GA();
            $analytics = $ga1->getService();
			$profile = $ga1->getFirstProfileId($analytics);

		
           

           $results = $ga1->getVideoWatchCount($analytics, $profile, $videoName);
           $rows = $results->getRows();
           $videoViews = $rows[0][1];

           if(!$videoViews) {
               $videoViews = "0";
            }
           if ( ! add_post_meta( $videoId, '_custom_video_view', $videoViews, true ) ) { 
               update_post_meta( $videoId, '_custom_video_view', $videoViews );
           }
?>


<div id="video-details" class="video-details row" style="display: block;">
	<div class="progress hide" style="width: 100%;"></div>

<div class="col-md-8"><h5 class="video-title"><a href="" ><?php echo get_the_title( $videoId );?></a> by <span class="video-author"><?php echo $user_nicename;?></span></h5><h5 class="video-school"><?php echo $school_name;?></h5></div>

<div class="clear"></div><div class="col-md-12"><div class="video-description"><?php echo get_field( "fp5-video-description", $videoId );?>
</div></div></div>
 <script>
	

	
	 
</script>
	



<?php
						echo do_shortcode('[simplevoteme postid='. $videoId .']');
						echo get_post_meta($videoId, '_custom_video_view', true);


			
        }else{
            echo "<h5>No Video found.</h5>";
        }
      //  get_footer();

?>