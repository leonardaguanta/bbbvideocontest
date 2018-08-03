<?php /* Template Name: BBB Admin Videos */ ?>

<?php get_header(); 
add_filter('show_admin_bar', '__return_false');
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
?>
<?php
$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
? $user_logo
: $template_directory_uri . '/images/logo.png';

?>
<?php get_template_part( 'partials/content', 'header' ); ?>

          <div class="content-wrapper">
            <div class="container-fluid">
              <!-- Breadcrumbs-->
<!--       <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Blank Page</li>
      </ol> -->
      <div class="row">
       <div class="col-lg-12">
        <div class="card mb-3">
          <a  class="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
          </a>
          <a> Visit Site </a>

        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-3">
          <div class="card-header">
          Videos Pending For Approval</div>

			
			<?php
			
			
			
global $post;
    		$args = array(
        		'post_type' => 'flowplayer5',
        		'posts_per_page' => -1,
        		'public' => true,
        		'post_status' => 'pending'
    		);
   
    		$posts = get_posts($args);

    		if ($posts) {
            		$theVideo = '<div class="pending-vid-container">';

        		foreach($posts as $postVideo) {
				$extra_video_info = get_post_meta($postVideo->ID);
                                if($extra_video_info['fp5-video-school-id'][0]) {
                                        $schoolPost = get_post($extra_video_info['fp5-video-school-id'][0]);
                                        $schoolName = $schoolPost->post_title;
                                } else {
                                        $schoolName = '';
                                }
                                $user_data = get_user_by('id',intval($postVideo->post_author));
                                $school_id = get_user_meta(intval($postVideo->post_author),'school_4',true);
                                $school_name = ! empty($school_id) ? get_the_title($school_id) : "N/A";
                                $school_name = ! empty($school_name) ? $school_name : "N/A"; 

            			$theVideo .= '      <div class="main-container2 no-border">
                                    <div class="row-one">

                                        <div class="main-video">';

                   // $theVideo .= do_shortcode('[flowplayer id="'.$postVideo->ID.'"]');
                    $theVideo .= do_shortcode('[flowplayer id="'.$postVideo->ID.'" pre-post-ad-video=1 autoplay="true" preload="auto]');

            				$theVideo .= '              </div>

                                        <div class="main-video-info">';
            				$theVideo .= '                  <h3>' .$postVideo->post_title. '</h3>';
            				$theVideo .= '                  <p><span class="yellow">Owner: </span>' . $user_data->data->display_name . '</p>';
            				$theVideo .= '                  <p><span class="yellow">Date Published: </span>' .get_the_date("F j, Y", $postVideo->ID). '</p>';
            				$theVideo .= '                  <p><span class="yellow">School:</span>  '.$school_name.'</p>
                                            <p class="rejected"><span class="yellow">Status: </span>Pending for Approval</p>';
            				$theVideo .= '                  <p class="vid-desc"><span class="yellow">Info: </span>'.wp_trim_words($extra_video_info['fp5-video-description'][0],60).'</p>

                                            <div class="row-one boxshadow custom-mrgbtm">';
                            
            					$theVideo .= '                      <form action="" class="approve-video-prompt" method="POST" name="front_end_publish"><input id="pid" type="hidden" name="pid" value="'.$postVideo->ID.'" />';
            					$theVideo .= '                          <input id="FE_PUBLISH" type="hidden" name="FE_PUBLISH" value="FE_PUBLISH" />

                                                    <div class="col-one icon-width">
                                                        <input class="c-btn" type="image" src="//platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/07/28223252/bbb-checkmark.png" alt="Submit"  id="submit" type="submit" name="submit">
                                                    </div>

                                                    <div class="col-two icon-desc">
                                                        <input class="video-info-buttons video-icon" id="submit" type="submit" name="submit" value="APPROVE VIDEO" />
                                                    </div>
                                                </form>';
            				$theVideo .='                   </div>

                                            <div class="row-one boxshadow custom-mrgbtm">
                                                <div class="col-one icon-width">
                                                    <a href="' .get_delete_post_link( $postVideo->ID ). '"><img class="aligncenter size-full wp-image-1253" src="//platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/09/03062334/remove-video-icon.png" alt="bbb-view" width="22" height="16" /></a>
                                                </div>

                                                <div class="col-two icon-desc">
                                                    <a class="reject-video-prompt video-info-buttons video-icon" href="' .get_delete_post_link( $postVideo->ID ). '">REJECT VIDEO</a>
                                                </div>
                                            </div>

                                            <div class="row-one boxshadow custom-mrgbtm">
                                                <div class="col-one icon-width">
                                                    <a href="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/08/28064659/message-icon.png"><img class="aligncenter size-full wp-image-1195" src="//platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/08/28064659/message-icon.png" alt="message-icon" width="22" height="16" /></a>
                                                </div>

                                                <div class="col-two icon-desc">
                                                    <a class="video-info-buttons video-icon thickbox" href="#TB_inline?height=680&width=650&inlineId=pendingSendEmail-'.$postVideo->ID.'">SEND MESSAGE </a>
                                                </div>
                                               <div id="pendingSendEmail-' . $postVideo->ID  .  '" style="display:none;">'. do_shortcode('[gravityform id="21" title="false" field_values="email='.$user_data->data->user_email.'"]') . '</div>
                                            </div>

                                        </div>
                                    </div>

                                </div>';
                            
        		}

        	$theVideo .= '</div>';
        	echo $theVideo;
    	} else {
		$output .= "<div class='pending-vid-container'>";
                $output .= "<div class='vid-upload-btn'>";
                $output .= "<h2>No pending video entries yet</h2>";
                $output .= "</div>";
		$output .= "</div>";
		echo $output;
	}
		
			
			
			
			
			
			
			
			
			
			?>
			
			

        
      </div>
    </div>
    </div>
 
</div>
  <!-- /.container-fluid-->
  <!-- /.content-wrapper-->
  <footer class="sticky-footer">
    <div class="container">
      <div class="text-center">
        <small>Copyright © Your Website 2018</small>
      </div>
    </div>
  </footer>
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
    </div><!--
    <script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/themes/Child-Divi/vendor/jquery/jquery.min.js?ver=4.9.6'></script>
    <script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/themes/Child-Divi/vendor/bootstrap/js/bootstrap.bundle.min.js?ver=4.9.6'></script>
<script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/themes/Child-Divi/vendor/jquery-easing/jquery.easing.min.js?ver=4.9.6'></script>
<script type='text/javascript' src='http://bbbvideocontest.platypustest.info/dev/wp-content/themes/Child-Divi/js/sb-admin.min.js?ver=4.9.6'></script>-->
</div>
</body>

</html>
<?php get_footer(); ?>