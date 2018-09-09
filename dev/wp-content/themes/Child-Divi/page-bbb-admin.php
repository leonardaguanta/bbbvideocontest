<?php /* Template Name: bbb admin home */ ?>

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
              <!-- Breadcrumbs-->
<!--       <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Blank Page</li>
      </ol> -->
    <div class="row logo-row">
        <div class="col-lg-2">
            <div class="card mb-3">
                <a class="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
                </a>
            </div>
        </div>
    </div>

<div class="voting-status alert alert-success" style="display:none">
  <strong>Updated Voting Status! - </strong><span id="voting-stat"></span> 
</div>
		<div class="row ">

    </div>
    <div class="row popvideo-row">
        <div class="col-lg-4 col-md-12">
            <!-- Most Popular Video -->
            <div class="card mb-3 popvideo-card">
            <div class="card-header">Most Popular Video</div>
                <?php get_template_part( 'partials/content', 'popularvideo-admin' ); ?>       
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
        <!-- Daily Tren-->
            <div class="card mb-3 graph-card">
            <div class="card-header">Daily Trend</div>
                <?php get_template_part( 'partials/content', 'charts' ); ?>
            </div>
            </div>
        </div>
	</div>
    <div class="row">
        <div class="col-lg-5">
            <div class="card mb-3 activity-card">
                <div class="card-header">Activity Log</div>
                <?php get_template_part( 'partials/content', 'activitylogs-scroll' ); ?>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card mb-3 rank-card">
                <div class="card-header">Video Rank as of Today</div>
                <?php get_template_part( 'partials/content', 'videoranks-scroll' ); ?>
            </div>
        </div>
		        <div class="col-lg-2">
            <div class="card mb-3 vote-card">
                         <div class="card-header">Voting Switch</div>
				<div class="checkbox voting">
  <label>
    <input type="checkbox" id="toggle-event" data-toggle="toggle">
 
  </label>
</div>
				
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