<?php get_header(); 
 add_filter( 'show_admin_bar', '__return_false', PHP_INT_MAX );
?>
<?php
$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && '' != $user_logo
? $user_logo
: $template_directory_uri . '/images/logo.png';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Student Dashboard</title>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">google.load('visualization', '1.0', {'packages':['corechart']});</script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">

    <a  class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="<?php echo esc_url( home_url( '/student-home' ) ); ?>">
            <i class="fa fa-fw fa-info-circle"></i>
            <span class="nav-link-text">Group Information</span>
          </a>
        </li>
		
		  

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="<?php echo esc_url( home_url( '/student-home/our-video/' ) ); ?>">
            <i class="fa fa-fw fa-film"></i>
            <span class="nav-link-text">Videos</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="<?php echo esc_url( home_url( '/student-home/student-edit-profile/' ) ); ?>">
            <i class="fa fa-fw fa-link"></i>
            <span class="nav-link-text">Edit Profile</span>
          </a>
        </li>
		  
       <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
             <!-- <i class="fa fa-fw fa-angle-left"></i>
          <span class="nav-link-text">Collapse Menu</span>-->
          </a>
        </li>
      </ul>
              <ul class="navbar-nav sidenav-toggler">
           <li class="nav-item">

          <a class="nav-link text-center nav-link-collapse collapsed" id="sidenavToggler"  data-toggle="collapse" href="#collapseProfile" data-parent="#exampleAccordion" aria-expanded="false">
                        <?php
               $user = wp_get_current_user();
 
if ( $user ) :
    ?>
    <img class="profile-picture" src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>"/>
<?php endif; ?>
               
              
              <span class="nav-link-text">
                  <?php
                  global $current_user;
                   echo $current_user->user_login;
                  ?> </span>

            <i class="fa fa-fw fa-angle-down"></i>
          </a>
        </li>
                      <ul class="sidenav-second-level collapse" id="collapseProfile" style="">

            <li>
              <a href="<?php echo wp_logout_url(); ?>">Logout</a>
            </li>
          </ul>   

      </ul>
      <ul class="navbar-nav ml-auto">
 
              <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                  <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                </li>
              </ul>
            </div>
          </nav>