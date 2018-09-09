<?php /* Template Name: BBB Admin Client Student Info */ ?>

<?php get_header(); 
add_filter('show_admin_bar', '__return_false');
?>
<?php
$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
? $user_logo
: $template_directory_uri . '/images/logo.png';

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
            </div>

            <div class="row">
                <div class="col-lg-7">
                    <div class="card mb-3">
                        <div class="card-header student-header">
                            <h3 class="info-header">Student Information</h3>
                            <h3 class="export-header"><a href="<?php echo admin_url( '/admin.php?page=download_report&download_report' ); ?>" class="export-csv-btn">Export CSV of All Contacts</a></h3>
                        </div>

                        <?php
                            $allusers = get_users( shortcode_atts( array( 'fields' => 'all', 'role' => 'Subscriber', 'orderby' => ID ), $atts) );

                            if ($allusers) { ?>
                                <div class="studentInfo-container with-scroll">
                                <?php foreach ( $allusers as $user ) {
                                    $list_of_usergroup = array();
                                    $user_meta = get_user_meta($user->ID);
                                    $user_usergroups = wp_get_object_terms($user->ID,'user-group',array('fields'=>'ids'));
                                    $user_info = get_user_by('id',$user->ID); 
									$members = get_user_meta( $user->ID, 'student' , true );
                        			$someArray = json_decode($members, true);
									
									?>
									
                                    <div class=" et_pb_row et_pb_row_7 student-info student-basic-info">
                                        <div class="et_pb_column et_pb_column_1_4  et_pb_column_10 et_pb_css_mix_blend_mode_passthrough">
                                            <div class="et_pb_module et_pb_image et_pb_image_1 et_always_center_on_mobile et_pb_text_align_center">
                                                <span class="et_pb_image_wrap">
                                                    <?php if( get_avatar( $user->ID, 120 ) ) { ?>
                                                        <img src="<?php echo home_url(); ?>/wp-content/uploads/2018/08/user-avatar.png" alt="<?php echo $user_meta['nickname'][0]; ?>"/>
                                                    <?php } ?>
                                                </span>
                                            </div>                           
                                        </div>
                                        <div class="et_pb_column et_pb_column_3_4  et_pb_column_11 et_pb_css_mix_blend_mode_passthrough et-last-child">
                                            <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_8">
                                                <div class="et_pb_text_inner">
                                                    <?php
                                                        $user_school_id = get_the_author_meta('school',$user->ID);
                                                        $school = get_post($user_school_id);
                                                        $username = $user_meta['nickname'][0];                                               
                                                    ?>
                                                    <h3 class="uname-info"><?php echo $username; ?></h3>
                                                    <p class="uname-school"><?php echo $school->post_title; ?></p>

                                                    <!-- FOR THICKBOX BUTTONS -->
                                                    <!-- <div class="editProfile">
                                                        <a title="<?php echo $user->display_name; ?>" href="#TB_inline?height=580&amp;width=650&amp;inlineId=bbbAdminViewProfile-<?php echo $user->ID; ?>" class="thickbox">View Profile</a> <span class="pipe-separator">|</span> <a href="#TB_inline?height=580&amp;width=400&amp;inlineId=bbbAdminSendEmail-<?php echo $user->ID; ?>" class="thickbox">Send Email</a> <span class="pipe-separator">|</span> <a href="#" class="bbbAdminDeleteUser" data-id="<?php echo $user->ID; ?>" data-nonce="<?php echo wp_create_nonce('bbb-admin-delete-'.$user->ID); ?>">Delete</a>
                                                    </div> -->

                                                    <div class="editProfile">
                                                        <a href="#" class="" data-toggle="modal" data-target="#bbbAdminViewProfile<?php echo $user->ID; ?>">View Profile</a> <span class="pipe-separator">|</span> <a href="#" class="" data-toggle="modal" data-target="#bbbAdminSendEmail<?php echo $user->ID; ?>">Send Email</a> <span class="pipe-separator">|</span> <a href="#" class="bbbAdminDeleteUser" data-id="<?php echo $user->ID; ?>" data-nonce="<?php echo wp_create_nonce('bbb-admin-delete-'.$user->ID); ?>">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FOR THICKBOX POPUP -->

                                        <div id="bbbAdminViewProfile-<?php echo $user->ID; ?>" class="thickbox" style="display:none;">
                                            <p>School Name: <span class="studentInfo-school"><?php echo $school->post_title; ?></span></p>
                                            <p>User/Group Name: <span class="studentInfo-user"><?php echo $username; ?></span></p>
                                            <p>Members: <span class="studentInfo-members"> </span></p>
                                        </div>

                                        <div id="bbbAdminSendEmail-<?php echo $user->ID; ?>" style="display:none;"><?php echo do_shortcode('[gravityform id="21" title="false" field_values="email='.$user_info->data->user_email.'"]'); ?></div>

                                        <!--/ END FOR THICKBOX POPUP -->

                                        <!-- STUDENT INFO MODAL -->
                                        <div class="modal fade student-infoModal2 bd-example-modal-lg" id="bbbAdminViewProfile<?php echo $user->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog " role="document">
                                                <div class="modal-content">  
													      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
                                                    <div class="modal-body">
                                                        <p><span class="label">School Name: </span> <span class="studentInfo-school"><?php echo $school->post_title; ?></span></p>
                                                        <p><span class="label">User/Group Name: </span><span class="studentInfo-user"><?php echo $username; ?></span></p>
                                                        <p><span class="label">Members: </span> <br><span class="studentInfo-members"><?php
                                    foreach ($someArray as $key => $value) {
                                        echo $value["Name"] . " - " . $value["Email"] . "<br>";
                                    }
                                ?></span></p>
                                                    </div>
     
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- MESSAGE STUDENT MODAL -->
                                        <div class="modal fade student-messageModal2 bd-example-modal-lg" id="bbbAdminSendEmail<?php echo $user->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">  
																										      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
                                                    <div class="modal-body">
                                                        <?php echo do_shortcode('[gravityform id="9" title="false" field_values="email='.$user_info->user_email.'"]')?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php

                // $theStudents .= '<div class="student-basic-info">';
                // $theStudents .= '<div class="col1">';
                // $theStudents .= get_avatar( $user->ID, 120 );
                // $theStudents .= '<h3>' .$user->display_name. '</h3>';
                // $theStudents .= "<p><span>School: </span> ";
                // $theStudents .= $user_meta['student_school'][0] ? $user_meta['student_school'][0]  : "n/a";
                // $theStudents .= "</p>";

                // // foreach ($user_usergroups as $term_id):
                // //   $usergroup_data = get_term($term_id,'user-group');
                // //   $list_of_usergroup[] = $usergroup_data->name;
                // // endforeach;

                //                 // $theStudents .= '<p><span>Group Name: </span>'.implode(" ,",$list_of_usergroup).'</p>';
                // $theStudents .= "<p class='student-lbl2' style='text-align: center;'>GROUP</p>";
                // $theStudents .= '</div>';
                // $theStudents .= '<div class="col2">';
                // $theStudents .= '<p class="student-bio"><span>Bio: </span>' . $user->description . '</p>';
                // $theStudents .='<div class="file-btns">';
                // $theStudents .= '<a title="'. $user->display_name .'" href="#TB_inline?height=580&amp;width=650&amp;inlineId=bbbAdminViewProfile-' . $user->ID . '" class="thickbox">View Profile</a>';
                //                 // $theStudents .= '<a href="#TB_inline?height=580&amp;width=400&amp;inlineId=bbbAdminEditProfile-' . $user->ID . '" class="thickbox">Edit Profile</a>';
                // $theStudents .= '<a href="#TB_inline?height=580&amp;width=400&amp;inlineId=bbbAdminSendEmail-' . $user->ID . '" class="thickbox">Send Email</a>';
                // $theStudents .= '<a href="#" class="bbbAdminDeleteUser" data-id="'.$user->ID.'" data-nonce="'.wp_create_nonce('bbb-admin-delete-'.$user->ID).'" style="padding: 5px 35px;">Delete</a>';
                // $theStudents .='</div>';
                // $theStudents .= '</div>';
                // $theStudents .= '</div>';
                // $theStudents .= '<div id="bbbAdminEditProfile-' . $user->ID  .  '" style="display:none;">' . do_shortcode('[gravityform id="20" field_values="school='.current($user_meta['school_4']).'&bio=' . current(  $user_meta['description'] ) .  '&userid='.$user->ID .'&group='.implode(",",$user_usergroups).'"]') . '</div>';
                $theStudents .= '<div id="bbbAdminViewProfile-OLD' . $user->ID  .  '" class="thickbox" style="display:none;">';
                $username = $user_meta['nickname'][0];

                $user_school_id = get_the_author_meta('school',$user->ID);//gets schoold id of user
                $school = get_post($user_school_id); // gets school 
                $school_name = $school->post_title;

                $school = $school_name;
               // var_dump($school);
                $students = $user_meta['students'];
                $students = maybe_unserialize(maybe_unserialize($students[0]));
                $student_details = "<div class='info-container-popup'>";
                $student_details .= "<div class='student-information-container-popup'>";
                $student_details .= "<p><span style='color: #EFA017;'>School: </span>$school</p>";
                $student_details .= "<p><span style='color: #EFA017;'>Username or Group name: </span>$username</p>";
                $student_details .= "<p><span style='color: #EFA017;'>Members: </span></p>";
                $student_details .= "<ul>";
                if(count($students[1][24]) > 0){
                  foreach( $students as $student ){
                    $student_details .= "<li>" . $student[25][0] . " " . $student[25][1] . " - <a href='mailto:". $student[24][0] ."'>". $student[24][0] ."</a></li>";
                  }
                }
                $student_details .= "</ul>";
                $student_details .= "</div>";
                $student_details .= "</div>";
                $theStudents .= $student_details;
                $theStudents .= '</div>';

                                //$fep_form = fep_main_class::init();

                //$theStudents .= '<div id="bbbAdminSendEmail-' . $user->ID  .  '" style="display:none;">'. $fep_form->new_message() . '</div>';
                                } ?>
                            </div>
                            <?php echo $theStudents; } ?>
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