<?php /* Template Name: BBB Admin Statistics */ ?>

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
                        <a  class="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header">Last 90 Days</div>
                        <?php get_template_part( 'partials/content', 'videoadstat-admin' ); ?>
                    </div>

                  <!--  <div class="card mb-3">
                        <div class="card-header">External Traffic</div>
						 <?php get_template_part( 'partials/content', 'external' ); ?>
                    </div>-->
                </div>
            </div>
		
            <div class="row"><!--
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">Most Search Terms</div>
                    </div>
                </div>-->
                <div class="col-lg-4">
                    <div class="card mb-3 stats-card stats-visitors">
                        <div class="card-header">Visitors</div>
                        <?php get_template_part( 'partials/content', 'videoadstatvisitors' ); ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-3 stats-card">
                        <div class="card-header">Uploaded Videos</div>
                        <?php get_template_part( 'partials/content', 'uploadedvideos' ); ?>
                    </div>
                </div>
                <!-- <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">Video Views</div>
                        <?php get_template_part( 'partials/content', 'videoadviews' ); ?>
                    </div>
                </div> -->
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