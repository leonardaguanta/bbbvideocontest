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


   echo "<link rel='stylesheet' id='flowplayer5-skins-css' href='https://releases.flowplayer.org/5.5.2/commercial/skin/all-skins.css' type='text/css' media='all' />";
        echo "<link rel='stylesheet' id='flowplayer5-logo-origin-css' href='https://d3vzs1kv29k6gk.cloudfront.net/dallas/wp-content/plugins/flowplayer5/frontend/assets/css/public-concat.min.css?x75485' type='text/css' media='all' />";
         echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery.js?ver=1.11.3'></script>";
         echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>";
        echo "<script type='text/javascript' src='https://d3vzs1kv29k6gk.cloudfront.net/dallas/wp-content/plugins/flowplayer5/frontend/assets/flowplayer/flowplayer.js?x75485'></script>";


     //   get_header();
  echo '<input value="1" id="popup-video-ni" type="hidden"/>';
        if($videoId){
            echo do_shortcode('[flowplayer id="'. $videoId .'" autoplay="true" preload="auto"]'); 
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

            // $ga1 = new Platypus_GA();
            // $analytics = $ga1->getService();
            // $profile = $ga1->getFirstProfileId($analytics);

            // $results = $ga1->getVideoWatchCount($analytics, $profile, $videoName);
            // $rows = $results->getRows();
            // $videoViews = $rows[0][1];

            // if(!$videoViews) {
            //     $videoViews = "0";
            // }
            // if ( ! add_post_meta( $videoId, '_custom_video_view', $videoViews, true ) ) { 
            //     update_post_meta( $videoId, '_custom_video_view', $videoViews );
            // }

        }else{
            echo "<h5>No Video found.</h5>";
        }
      //  get_footer();

?>