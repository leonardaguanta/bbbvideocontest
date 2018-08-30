<?php /* Template Name: bbb student home */ ?>

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
            <div class="col-lg-7">
                <div class="card mb-3">
                    <div class="card-header">Group Information</div>
                    <?php 
                        $authid = get_current_user_id( ); 
                        $user_nicename = get_the_author_meta('user_nicename',$authid);
                        $user_school_id = get_the_author_meta('school',$authid);//gets schoold id of user
                        $school = get_post($user_school_id); // gets school 
                        $school_name = $school->post_title;
                        $members = get_user_meta( $authid, 'student' , true );
                        $someArray = json_decode($members, true);
                    ?>
                    <div class=" et_pb_row et_pb_row_1 school-admin-row">
                        <div class="et_pb_column et_pb_column_4_4  et_pb_column_2 et_pb_css_mix_blend_mode_passthrough">
                            <div class="username">Username/Groupname: <?php echo $user_nicename;?></div>
                            <div class="school">School: <?php echo $school_name;?></div>
                            <div class="members">Members:
                                <?php
                                    foreach ($someArray as $key => $value) {
                                        echo $value["Name"] . " - " . $value["Email"] . "<br>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
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