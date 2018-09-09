<?php /* Template Name: bbb student video */ ?>

<?php get_header(); 
add_filter('show_admin_bar', '__return_false');
?>
<?php
$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
? $user_logo
: $template_directory_uri . '/images/logo.png';

?>
<?php get_template_part( 'partials/content', 'header-student' ); ?>

    <div class="content-wrapper admin-wrapper">
        <div class="container-fluid admin-fluid">
            <div class="row logo-row">
                <div class="col-lg-2">
                    <div class="card mb-3">
                        <a  class="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header">Our Video</div>
                            <?php 
                                global $current_user, $post;
                                get_currentuserinfo();
                                $args = array(
                                    'post_type' => 'flowplayer5',
                                    'posts_per_page' => -1,
                                    'public' => true,
                                    'post_status' => 'publish, draft, pending, trash',
                                    'author' => $current_user->ID,
                                );
                                $video_posts = get_posts($args);

                            if (count($video_posts)>0) {

                                //$output .= "DATA: ".print_r($posts, true);
                                $output .= '<div class="header-tab"><a class="dallas-btn thickbox" href="#TB_inline?height=680&amp;width=650&amp;inlineId=NewVideoPopup"><span class="newVid-btn">UPLOAD VIDEO</span></a></div>';
                                $output .= '<div class="student-vid-container">';
                                
                                if($_REQUEST['submission'] == 'new' ) {
                                    $output .= '
                                        <script>
                                            jQuery(".header-tab").append("<div id=\'approvalReminder\'></div>");
                                            jQuery("#approvalReminder").html("<h2>VIDEO UPLOAD SUCCESSFUL</h2><p>Your video will need to be approved by the contest administration before being live on the website.Once submitted, it will take up to 72 hours to review your submission. Please log back into your account to check the status of the submission.<br>Thank you for submitting your video!<br></p><br><button>OK</button>");

                                            jQuery("#approvalReminder").click( function() {
                                                jQuery("#approvalReminder").remove();
                                                var uri = window.location.toString();

                                                if (uri.indexOf("?") > 0) {
                                                    var clean_uri = uri.substring(0, uri.indexOf("?"));
                                                    window.history.replaceState({}, document.title, clean_uri);
                                                }
                                            });
                                        </script>
                                    ';
                                }
                        foreach($video_posts as $postVideo) {
                                $extra_video_info = get_post_meta($postVideo->ID);
                                
                                if($extra_video_info['fp5-video-school-id'][0]) {
                                        $schoolPost = get_post($extra_video_info['fp5-video-school-id'][0]);
                                        $schoolName = $schoolPost->post_title;
                                } else {
                                        $schoolName = '';
                                }

                                $author_id = get_post_field('post_author', $postVideo->ID);
                                $author = get_the_author_meta( "display_name" , $author_id );
                                $schoolId = get_user_meta( $author_id, 'school_4', true );
                                $schoolTitle = get_the_title($schoolId);
                                $schoolName = empty($schoolTitle) ? "N/A" : $schoolTitle;
                                $video_url = get_post_meta($postVideo->ID, 'fp5-mp4-video', TRUE);
                                //$output .= "Data: ". print_r($post,true);
                                //$output .= "<br><br>Extra Data: ". print_r(get_post_meta($post->ID),true);
                                $output .= '<div class="pending-vid-container">';
                                $output .= '<div class="main-container2 no-border">
                                        <div class="row-one">

                                    <div class="main-video">
                        <div class=" et_pb_row et_pb_row_2 active-videoRow">
                            <div class="et_pb_column et_pb_column_4_4  et_pb_column_3 et_pb_css_mix_blend_mode_passthrough et-last-child">
                                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left video-module et_pb_text_1">
                                    <div class="et_pb_text_inner">
                                        <video controls src="'.$video_url.'" id="approved-heroVid"></video>                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                                    ';
            //$output .=              do_shortcode('[video width="670" height="400" mp4="'.wp_get_attachment_url( $post->ID ).'"][/video]');
                                 //   var_dump( $video_url);
                               // $output .= do_shortcode('[flowplayer id="'.$postVideo->ID.'"]');
                                $output .= '            </div>

                                    <div class="main-video-info">';
                                $output .= '                <h3>' .$postVideo->post_title. '</h3>';
                                $output .= '                <p><span class="yellow">Owner: </span>' .get_the_author_meta("display_name",$current_user->ID). '</p>';
                                $output .= '                <p><span class="yellow">Date Published: </span>' .get_the_date("F j, Y", $postVideo->ID). '</p>';
                                $output .= '                <p></p>';
                                if($postVideo->post_status == 'pending') {
                                        $videoStatus = "Pending Approval";
                                        $videoStatusDescription = '<p class="status">YOUR VIDEO IS PENDING APPROVAL</p>';
                                        $submitIconDescr = "";
                                        $social = ''; 
                                } elseif($postVideo->post_status == 'trash') {
                                        $videoStatus = "Rejected";
                                        $videoStatusDescription = '<p class="status rejected">YOUR VIDEO IS REJECTED BY ADMIN</p>';
                                        $submitIconDescr = "";
                                        $social = '';
                                } elseif($postVideo->post_status == 'publish') {
                                        $videoStatus = "Approved";
                                        $videoStatusDescription = '';
                                        $submitIconDescr = "VISIT VIDEO PAGE";
                                        $social = '
                                        <div class="row-one">
                                            <div class="social"><div class="fb-like" data-href="'.esc_url( get_permalink( $postVideo->ID ) ).'" data-width="70px" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></div>
                                        </div>';
                                } else {
                                        $videoStatus = "Draft";
                                        $videoStatusDescription = '<p class="status">DRAFT</p>';
                                        $submitIconDescr = "REQUEST FOR APPROVAL";
                                        $social = '';
                                }


                                        $output .= '                <p class="rejected"><span class="yellow">Status: </span>'.$videoStatus.'</p>
                                        <p class="vid-desc"><span class="yellow">Info: </span>'.wp_trim_words($extra_video_info['fp5-video-description'][0],60).'</p>
'.$videoStatusDescription;
                                        if($submitIconDescr=='REQUEST FOR APPROVAL') {
                                                $output .= '
                                        <div class="row-one boxshadow custom-mrgbtm">
                                                <form action="" method="POST" name="front_end_publish"><input id="pid" type="hidden" name="pid" value="'.$postVideo->ID.'" />
                                                <input id="FE_REQUEST_APPROVAL" type="hidden" name="FE_REQUEST_APPROVAL" value="FE_REQUEST_APPROVAL" /> 
                                            <div class="col-one icon-width">
                                                <input class="c-btn" type="image" src="//platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/08/28064702/video-icon.png" alt="Submit"  id="submit" type="submit" name="submit">
                                            </div>
                                            <div class="col-two icon-desc">
                                                <input class="video-info-buttons video-icon" id="submit" type="submit" name="submit" value="'.$submitIconDescr.'" />
                                            </div>
                                                </form>
                                        </div>';
                                        } elseif($submitIconDescr=='VISIT VIDEO PAGE') {
                                                $output .= '
                                        <div class="row-one boxshadow custom-mrgbtm">
                                            <div class="col-one icon-width">
                                                <a href="'.get_permalink($postVideo->ID).'" target="_blank"><img src="//platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/08/28064702/video-icon.png" class="c-btn"></a>                                            </div>
                                            <div class="col-two icon-desc">
                                                <a class="video-info-buttons" href="'.get_permalink($postVideo->ID).'" target="_blank">'.$submitIconDescr.'</a>
                                            </div>
                                        </div>
                                        <div class="row-one boxshadow custom-mrgbtm">
                                            <div class="col-one icon-width">
                                                <a class="thickbox" href="#TB_inline?height=680&width=650&inlineId=ApprovedVideoStatPopup_'.$postVideo->ID.'"><img class="aligncenter size-full wp-image-1253" src="//platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/11/05033712/stats.png" alt="bbb-view" width="22" height="16" /></a>
                                            </div>

                                            <div class="col-two icon-desc">
                                                <a class="video-info-buttons video-icon thickbox" href="#TB_inline?height=680&width=650&inlineId=ApprovedVideoStatPopup_'.$postVideo->ID.'">VIEW STATISTICS</a>
                                            </div>
                                        </div>
                                        ';
                                        }
                                        $output .= '
                                        <div class="row-one boxshadow custom-mrgbtm">


                                         </div>

                                        </div>
                                        '.$social.'
                                    </div>
                                </div>';
                        if($postVideo->post_status == 'publish') {
                                //$output .= '<div class="approved-vid-btn">
                                //        <a id="toggleBtn" class="thickbox" href="#TB_inline?height=680&width=650&inlineId=ApprovedVideoStatPopup_'.$postVideo->ID.'">view statistics</a>
                                //      </div>';
                                $output .= videoStatsDisplay_student($postVideo);
                        }




      $output .= '</div>';
            }
      $output .= "<div id='NewVideoPopup' style='display: none;'><h2>New Video Submission</h2>";
      $output .= "<div id='postbox'>";
      $output .= do_shortcode("[gravityform id=5 ajax='true']");
                        // $theVideo .= "** Max Upload of 50MB. <br>";
                        $output .= "Do not close page - once video upload is complete you will be redirected automatically";
      $output .= "</div>";


      $output .= "</div>";
          } else {
                        $output .= '<div class="header-tab">';
                        $output .= ( count($video_posts) >= 1 ? '<a class="dallas-btn thickbox" href="#TB_inline?height=680&amp;width=650&amp;inlineId=NewVideoPopup"><span class="newVid-btn">UPLOAD NEW VIDEO</span></a>' : '' );
                        $output .= '</div>';
                        $output .= '<div class="student-vid-container">';
      $output .= "<div class='vid-upload-btn'>";
                  $output .= "<h2>You have not uploaded a video entry yet</h2>";
                  $output .= "<div id='wp-content-media-buttons' class='wp-media-buttons'><a class='thickbox' title='Add Media' href='#TB_inline?height=680&amp;width=650&amp;inlineId=NewVideoPopup'>UPLOAD FILE</a></div>";
                  $output .= "</div>";
      $output .= "</div></div>";
      $output .= "<div id='NewVideoPopup' style='display: none;'><h2>New Video Submission</h2>";
                        $output .= "<div id='postbox'>";
                        $output .= do_shortcode("[gravityform id=5 ajax='true' title=false description=false]");
                        // $theVideo .= "** Max Upload of 50MB. <br>";
                        $output .= "Do not close page - once video upload is complete you will be redirected automatically";
                        $output .= "</div>";

                        $output .= "</div>";
    }
          echo $output;
            ?>




                </div>
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