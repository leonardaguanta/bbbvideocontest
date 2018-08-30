<?php
/*
Template name: VideoFrame
*/
//add_filter('show_admin_bar', '__return_false');
    $videoId = isset($_GET['vid_id']) ? $_GET['vid_id'] : '';

//  echo "<link rel='stylesheet' id='flowplayer5-skins-css' href='http://releases.flowplayer.org/5.5.2/commercial/skin/all-skins.css?ver=5.5.2' type='text/css' media='all' />";
//  echo "<link rel='stylesheet' id='flowplayer5-logo-origin-css' href='http://www.bbbvideocontest.org/dallas/wp-content/plugins/flowplayer5/frontend/assets/css/public-concat.min.css?ver=1.11.2' type='text/css' media='all' />";
//  echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery.js?ver=1.11.3'></script>";
//  echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>";
//  echo "<script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/flowplayer5/frontend/assets/flowplayer/flowplayer.js?ver=4.9.6'></script>";

    get_header();
    echo "<link rel='stylesheet' id='flowplayer5-skins-css' href='https://releases.flowplayer.org/5.5.2/commercial/skin/all-skins.css' type='text/css' media='all' />";
    echo "<link rel='stylesheet' id='flowplayer5-logo-origin-css' href='https://d3vzs1kv29k6gk.cloudfront.net/dallas/wp-content/plugins/flowplayer5/frontend/assets/css/public-concat.min.css?x75485' type='text/css' media='all' />";
    echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery.js?ver=1.11.3'></script>";
    echo "<script type='text/javascript' src='http://www.bbbvideocontest.org/dallas/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>";
    echo "<script type='text/javascript' src='https://d3vzs1kv29k6gk.cloudfront.net/dallas/wp-content/plugins/flowplayer5/frontend/assets/flowplayer/flowplayer.js?x75485'></script>";
//  echo "<script src='http://bbbvideocontest.platypustest.info/dev/wp-includes/js/zxcvbn.min.js' type='text/javascript'></script><script src='//w.likebtn.com/js/w/widget.js'></script><script src='//w.likebtn.com/js/w/widget.js'></script>";
    echo "<link rel='stylesheet' id='simplevotemestyle-css' href='http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/simple-vote-me/css/simplevoteme.css?ver=4.9.6' type='text/css' media='all'>";

    echo '<script type="text/javascript">
        /* <![CDATA[ */
        var gtsimplevotemeajax = {"ajaxurl":"http:\/\/bbbvideocontest.platypustest.info\/dev\/wp-admin\/admin-ajax.php"};
        /* ]]> */
        </script>';
    echo '<script type="text/javascript" src="http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/simple-vote-me/js/simple-vote-me.js?ver=4.9.6"></script>'; ?>

<script type="text/javascript">
//flowplayer.conf.embed = false;
//flowplayer.conf.fullscreen = true;
</script>

    <div class="et_pb_section pop-videosSection et_pb_section_3 et_section_regular">
        <div class=" et_pb_row et_pb_row_4">
            <div class="et_pb_column et_pb_column_4_4  et_pb_column_6 et_pb_css_mix_blend_mode_passthrough et-last-child">
                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left video-module et_pb_text_4">
                    <div class="et_pb_text_inner">
                        <input value="1" id="popup-video-ni" type="hidden"/>

                        <?php if($videoId){ ?>
                            <?php echo do_shortcode('[flowplayer id="'. $videoId .'" pre-post-ad-video=1 autoplay="true" preload="auto"]'); ?>
                            <script>
                                jQuery(window).load(function(){
                                    setTimeout(function(){
                                        jQuery('.flowplayer .fp-ui').trigger('click');
                                    }, 2000);
                                });
                            </script>
                        <?php              
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
                    </div>
                </div>
            </div>
        </div>
        <div class=" et_pb_row et_pb_row_5">
            <div class="et_pb_column et_pb_column_2_3  et_pb_column_7 et_pb_css_mix_blend_mode_passthrough">
                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_5">
                    <div class="et_pb_text_inner">
                        <h3 class="pop-videoTitle"><span class="pop-vidTitle"><?php echo get_the_title( $videoId );?></span> by 
							<span class="pop-videoAuthor"><?php echo $user_nicename;?></span></h3>
                        <p class="school-video "><?php echo $school_name; ?></p>
                    </div>
                </div>
            </div>
            <div class="et_pb_column et_pb_column_1_3  et_pb_column_8 et_pb_css_mix_blend_mode_passthrough et-last-child">
                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_6">
                    <div class="et_pb_text_inner">
                        <?php echo do_shortcode('[simplevoteme postid='. $videoId .']'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class=" et_pb_row et_pb_row_6">
            <div class="et_pb_column et_pb_column_4_4  et_pb_column_9 et_pb_css_mix_blend_mode_passthrough et-last-child">
                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_7">
                    <div class="et_pb_text_inner">
                        <?php echo get_field( "fp5-video-description", $videoId );?>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- <div class="progress hide" style="width: 100%;"></div> -->

<?php
	//echo get_post_meta($videoId, '_custom_video_view', true);
    }else{
        echo "<h5>No Video found.</h5>";
    }
?>