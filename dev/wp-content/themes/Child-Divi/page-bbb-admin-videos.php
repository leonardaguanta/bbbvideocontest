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
$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo ? $user_logo : $template_directory_uri . '/images/logo.png';
global $post;
$args = array(
    'post_type' => 'flowplayer5',
    'posts_per_page' => -1,
    'post_status' => 'pending',
												'meta_query' => array(
												array(
												  'key' => 'video-user-role',
												  'value' => 'student',
												))
    );

$pendingVid = new WP_Query( $args );
$pendingVid_for_modal = new WP_Query( $args );

?>
<?php get_template_part( 'partials/content', 'header' ); ?>

<div class="content-wrapper admin-wrapper">
    <div class="container-fluid admin-fluid">
        <div class="row logo-row">
            <div class="col-lg-2">
                <div class="card mb-3">
                    <a class="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
                    </a>
                </div>
            </div>
			<div class="col-lg-8">
                <div class="card mb-3"><h2 style="padding-top: 55px;">PENDING VIDEOS</h2></div>
            </div>
        </div>
        <div class="row">

                                    <?php if( $pendingVid->have_posts() ) : ?>
			 <?php while( $pendingVid_for_modal->have_posts() ) : $pendingVid_for_modal->the_post();	 ?>
			   <?php 
                    $extra_video_info = get_post_meta(get_the_ID);
                    $post_id = get_the_ID(); 
                    $user_data = get_user_by('id',get_the_author_meta('ID'));

                    ?>
                                <!-- MESSAGE STUDENT MODAL -->
                <div class="modal fade student-messageModal2 bd-example-modal-lg" id="bbbAdminSendEmail<?php echo $post_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">  
							      <div class="modal-header">
									
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
                            <div class="modal-body">
                                <?php echo do_shortcode('[gravityform id="10" title="false" field_values="email='.$user_data->user_email.'"]')?>
                            </div>

                        </div>
                    </div>
                </div>
			<?php endwhile; ?>
            <div class="col-lg-8">

                <div class="et_pb_section approve-videosRow et_pb_section_2 et_section_regular">
                    <div class=" et_pb_row et_pb_row_2 active-videoRow">
                        <div class="et_pb_column et_pb_column_4_4  et_pb_column_3 et_pb_css_mix_blend_mode_passthrough et-last-child">
                            <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left video-module et_pb_text_1">
                                <div class="et_pb_text_inner">
                                    <video controls src="" id="approved-heroVid"></video>                                       
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class=" et_pb_row et_pb_row_3 video-paginationRow">
                        <div class="et_pb_column et_pb_column_1_2  et_pb_column_4 et_pb_css_mix_blend_mode_passthrough">
                            <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_2">
                                <div class="et_pb_text_inner">
                                    <div class="submitted-videoStatus submitted-pendingStatus">
                                        <p class="action-buttons"><span class="toApprove"><a id="apprv" class="approve">Approve</a></span>  <span class="toMessage"><a class="" href=""  data-toggle="modal" data-target="">Message</a></span> <span class="toReject"><a href="">Reject</a></span>
											
                                        </p>
										
                                    </div>
                                    <p class="submitted-videoTitle"></p>
                                    <p class="submitted-videoAuthor"></p>
                                </div>
                            </div>
                        </div>
                        <div class="et_pb_column et_pb_column_1_2  et_pb_column_5 et_pb_css_mix_blend_mode_passthrough et-last-child">
                            <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center video-paginationCol et_pb_text_3">
                                <div class="et_pb_text_inner">


                                        <?php while( $pendingVid->have_posts() ) : $pendingVid->the_post();	 ?>

                                            <?php 
                                            $extra_video_info = get_post_meta(get_the_ID);
                                            $post_id = get_the_ID(); 
                                            $user_data = get_user_by('id',get_the_author_meta('ID'));
			 								$user_nickname = get_the_author_meta('nickname',get_the_author_meta('ID'));
                                            ?>

                                            <div class="approved-videoData" video-url="<?php echo get_post_meta(get_the_ID(), 'fp5-mp4-video', TRUE); ?>" video-id="<?php the_ID(); ?>" video-title="<?php the_title(); ?>" video-author="<?php echo $user_nickname; ?>" video-delete="<?php echo get_delete_post_link($post_id); ?>" 
                                              video-approved-html="<form action='' class='approve-video-prompt' method='POST' name='front_end_publish'><input id='pid' type='hidden' name='pid' value='<?php echo $post_id;?>' /><input id='FE_PUBLISH' type='hidden' name='FE_PUBLISH' value='FE_PUBLISH' /><div class='col-two icon-desc'><input class='c-btn' type='image' src='http://bbbvideocontest.platypustest.info/dev/wp-content/uploads/2018/08/thumb-up-button-1.png' alt='Submit' id='submit' type='submit' name='submit'><a id='apprv' class='approve'> Approve</a></span></div></form>" video-send-message='#bbbAdminSendEmail<?php echo $post_id; ?>'>
                                              <span class="approvedPlay" data-icon="E"></span>
												
		
                                              <!--<a class="video-info-buttons video-icon thickbox" >
                                                 <div id="approvedSendEmail-<?php// echo $post_id;?>" style="display:none;"><?php // echo do_shortcode('[gravityform id="10" title="false" field_values="email='.$user_data->user_email.'"]')?></div>
                                             </a>-->
                                            <?php if( get_post_meta(get_the_ID(), 'fp5-splash-image', TRUE) ): ?>
                                                <img src="<?php echo get_post_meta(get_the_ID(), 'fp5-splash-image', TRUE); ?>" alt="<?php echo get_the_title(); ?>"/>
                                            <?php else: ?>
                                                <img src="<?php echo home_url(); ?>/wp-content/uploads/2018/09/school-default.png" alt="<?php echo get_the_title(); ?>">
                                            <?php endif; ?>
                                         </div>
                                         <?php// echo videoStatsDisplay($post_id); ?>

                                     <?php endwhile; ?>

                             </div>
                             <div id="pops"></div>
                         </div>
                     </div>
                 </div>
             </div>
               <?php wp_reset_postdata(); ?>
  <?php else:?>
                           
                <div class="card col-lg-8 no-pending" style="padding: 15px;">
                               <p >No pending video entries.</p> 
                
            </div>

            <?php endif; ?>
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
<?php if($_REQUEST['message'] == 'sent' ) { ?>
<script>
    jQuery(".container-fluid").prepend("<div id=\'messageSent\'></div>");
    jQuery("#messageSent").html("<h2>Message Sent</h2><br><button>OK</button>");

    jQuery("#messageSent").click( function() {
        jQuery("#messageSent").remove();
        var uri = window.location.toString();

        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }
    });
</script>
<?php } ?>
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