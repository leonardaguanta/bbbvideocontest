<?php /* Template Name: bbb student video 2 */ ?>

<?php get_header(); 
add_filter('show_admin_bar', '__return_false');
 add_filter( 'show_admin_bar', '__return_false', PHP_INT_MAX );
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
                <div class="col-lg-10">
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

                            if ( count( $video_posts ) > 0 ) { ?>

                                <div class="header-tab studentVideo-headerTab"><a class="dallas-btn" href="#" data-toggle="modal" data-target="#studentProfileVideo<?php echo $user->ID; ?>"><span class="newVid-btn">UPLOAD VIDEO</span></a></div>
                                <div class="et_pb_section studentVideo-section et_pb_section_5 et_section_regular with-scroll">

                                <?php if($_REQUEST['submission'] == 'new' ) { ?>
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
                                <?php } 

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
                                    $video_url = get_post_meta($postVideo->ID, 'fp5-mp4-video', TRUE); ?>
                                    
                                    <div class="et_pb_row et_pb_row_9 et_pb_gutters2">
                                        <div class="et_pb_column et_pb_column_2_3  et_pb_column_14 et_pb_css_mix_blend_mode_passthrough">
                                            <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left video-module et_pb_text_13">
                                                <div class="et_pb_text_inner">
                                                    <video controls src="<?php echo $video_url; ?>" id="approved-heroVid"></video>      
                                                </div>
                                            </div>
                                        </div>
                                        <div class="et_pb_column et_pb_column_1_3  et_pb_column_15 et_pb_css_mix_blend_mode_passthrough et-last-child">
                                            <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left studentVideo-details et_pb_text_14">
                                                <div class="et_pb_text_inner">
                                                    <h2><?php echo $postVideo->post_title; ?></h2>
                                                    <p><span class="details-title">Owner:</span> <?php echo $author; ?></p>
                                                    <p><span class="details-title">Date Published:</span> <?php echo get_the_date("F j, Y", $postVideo->ID); ?></p>
                                                    <?php
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
                                                    ?>
                                                    <p><span class="details-title">Status:</span> <?php echo $videoStatus; ?></p>
                                                    <p><span class="details-title">Info:</span> <?php echo wp_trim_words( $extra_video_info['fp5-video-description'][0],60 ); ?></p>
                                                    <p><?php echo $videoStatusDescription; ?></p>

                                                    <?php 
                                                        if($postVideo->post_status == 'publish') {
                                                            echo '<p><a class="studentVid-stats" href="#" data-toggle="modal" data-target="#ApprovedVideoStatPopup_'.$postVideo->ID.'">View Stats</a></p>';
                                                           
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- VIDEO MODAL -->
                                        <div class="modal fade student-videoModal bd-example-modal-lg" id="studentProfileVideo<?php echo $user->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">                                               
                                                    <div class="modal-body">
                                                        <?php echo do_shortcode("[gravityform id=5 ajax='true' title=false description=false]"); ?>
                                                        <p class="vidUpload-note">Do not close page - once video upload is complete you will be redirected automatically</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php  echo videoStatsDisplay_student($postVideo); } ?>
                                </div>
                            <?php } else { ?>
                                 <div class="header-tab studentVideo-headerTab"><a class="dallas-btn" href="#" data-toggle="modal" data-target="#studentProfileVideo<?php echo $user->ID; ?>"><span class="newVid-btn">UPLOAD VIDEO</span></a></div>
                                                                         <!-- VIDEO MODAL -->
                                        <div class="modal fade student-videoModal bd-example-modal-lg" id="studentProfileVideo<?php echo $user->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">                                               
                                                    <div class="modal-body">
                                                        <?php echo do_shortcode("[gravityform id=5 ajax='true' title=false description=false]"); ?>
                                                        <p class="vidUpload-note">Do not close page - once video upload is complete you will be redirected automatically</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                  <?php } ?>                
                    </div>
                </div>
            </div>
        </div>
  <!-- /.container-fluid-->
  <!-- /.content-wrapper-->

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