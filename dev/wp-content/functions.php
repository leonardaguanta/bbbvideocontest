<?php

require_once( 'functions-student.php' );
require_once( 'functions-video.php' );
require_once( 'functions-images.php' );
require_once( 'functions-about.php' );
require_once( 'functions-school.php' );
require_once( 'functions-snippets.php' );

function is_bbb_admin(){
  $current_user_data = get_userdata(get_current_user_id());
  $current_user_roles = $current_user_data->roles;
  return is_user_logged_in() && (in_array('administrator',$current_user_roles) || in_array('editor',$current_user_roles));
}

function is_bbb_student(){
 
  $current_user_data = get_userdata(get_current_user_id());
  $current_user_roles = $current_user_data->roles;
  return is_user_logged_in() && (in_array('administrator',$current_user_roles) || in_array('editor',$current_user_roles) || in_array('subscriber',$current_user_roles));
}

function redirect_page_workout(){
  $current_user_data = get_userdata(get_current_user_id());
  $current_user_roles = $current_user_data->roles;
  if(is_user_logged_in()){
    switch(true){
      case in_array('administrator',$current_user_roles):
      case in_array('editor',$current_user_roles):
        wp_redirect(home_url('/dallas/bbb-admin-dashboard'));
	exit;
      case in_array('subscriber',$current_user_roles):
        wp_redirect(home_url('/dallas/student-home'));
        exit;
      default:
        wp_redirect(home_url());
        exit;
   }
  }else {
    wp_redirect(home_url());
    exit;
  }
}

add_action('template_redirect','ssl_redirect');
function ssl_redirect(){
   if(is_page(2655) && !is_ssl()){
      wp_redirect(get_the_permalink(2655));
      exit();
  }
  if(!is_ssl() && get_the_ID()){
     wp_redirect(get_the_permalink(get_the_ID()));
     exit();      
  }
}




add_action( 'wp_ajax_dbbb_custom_validation', 'dbbb_custom_validation' );
add_action( 'wp_ajax_nopriv_dbbb_custom_validation', 'dbbb_custom_validation' );

function dbbb_custom_validation(){

	if ( isset( $_REQUEST['email'] ) ) {
		$email_val = $_REQUEST['email'];
		if ( email_exists( $email_val ) ) {
			echo json_encode(
				array(
					'val' => 'true' ,
					'message' => 'Sorry, email already exist!'
				)
			);
		} elseif ( ! email_exists( $email_val ) && ! is_email( $email_val )  ) {
			echo json_encode(
				array(
					'val' => 'true' ,
					'message' => 'Sorry, not a valid email address!'
				)
			);
		} elseif ( ! email_exists( $email_val ) && is_email( $email_val )  ) {
			echo json_encode(
				array(
					'val' => 'false'
				)
			);
		}
	} 

 	die();
}

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

add_action( 'init', 'init_theme_method' );
function init_theme_method() {
	add_thickbox();
}

function custom_divi_child_scripts() {

	/*wp_deregister_script('jquery');
	wp_register_script('jquery', get_bloginfo('stylesheet_directory').'/js/jquery.js', false, '1.0', true);
  	wp_enqueue_script('jquery');*/
	
//	wp_enqueue_script( 'google_location_auto', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places', array(), false, false );
	wp_enqueue_script( 'sweetalert-js', get_bloginfo( 'stylesheet_directory' ) . '/js/sweetalert.min.js', array('jquery'), false, true );
	wp_enqueue_script( 'extra-js', get_stylesheet_directory_uri() . '/js/extra.js', array( 'jquery' ), false, true );

	wp_register_script( 'toggle-js', get_bloginfo( 'stylesheet_directory' ) . '/js/toggle.js', 'jquery', '1.0', true );
	wp_enqueue_script( 'toggle-js' );

	wp_register_script( 'confirm-js', get_bloginfo( 'stylesheet_directory' ) . '/js/confirm.js', 'jquery', '1.0', true );
	wp_enqueue_script( 'confirm-js' );

	wp_register_script( 'simplemodal-js', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery.simplemodal.js', 'jquery', '1.0', true );

	wp_enqueue_script( 'simplemodal-js' );

	wp_enqueue_script( 'student-admin', get_stylesheet_directory_uri() . '/js/student_admin.js', array( 'jquery' ), false, true );

	//wp_enqueue_script( 'handle', get_stylesheet_directory_uri().'/js/custom_registration.js', array(),  false, true );
	
	wp_enqueue_style('sweetalert-css', get_bloginfo( 'stylesheet_directory' ) . '/css/sweetalert.css', array(), false);
	wp_enqueue_style('sweetalert-twitter', get_bloginfo( 'stylesheet_directory' ) . '/css/alert-twitter.css', array('sweetalert-css'), false);

	wp_enqueue_script( 'mixitup', get_stylesheet_directory_uri() . '/js/jquery.mixitup.js');

	wp_enqueue_style('bootstrap-grid', get_stylesheet_directory_uri() . '/css/bootstrap-grid.css');
}

add_action( 'wp_enqueue_scripts', 'custom_divi_child_scripts' ); //Hook


function custom_divi_admin_scripts() {

	//wp_enqueue_script( 'google_location_auto', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places', array(), false, false );
	wp_enqueue_script( 'admin_custom', get_stylesheet_directory_uri() . '/js/custom_admin.js', array(
		'google_location_auto',
		'jquery'
	), false, false );
}

add_action( 'admin_enqueue_scripts', 'custom_divi_admin_scripts' );

///add_action('gform_validation_5', 'validate_submission_file_size');
function validate_submission_file_size($validation_result){
  //$input_id = 0;
  $form = $validation_result['form'];

  foreach($_FILES as $key => $file){
    //var_dump($file);
    if(empty($file['name']) && $file['error'] < 1){
      continue;
    }
    $file_size_video = ($file['size'] / 1000) / 1000; //convert to mb
    if($file_size_video < 2){
      $validation_result['is_valid'] = true;
    } else {
      $validation_result['is_valid'] = false;
      $input_id = intval(str_replace('input_','',$key));
    }
  }

 /* if($input_id >= 1){
    foreach($form['form']['fields'] as $fields){
      if($fields['id'] == $input_id){
         $fields['failed_validation'] = true;
         $fields['validation_message'] = 'Unable to upload video. File size exceeded 50MB.';
      }
    }
  }*/
  $validation_result[ 'form' ] = $form;  

  return $validation_result;
}
add_action( "gform_after_submission_5", "acf_post_submission", 10, 2 );

function acf_post_submission( $entry, $form ) {
	$post_id = $entry["post_id"];

        ///var_dump($entry);
	$values  = get_post_custom_values( 'input_4', $post_id );
	update_field( "field_55f91b7d4d4fb", $values, $post_id );
}

add_action( 'after_setup_theme', 'remove_admin_bar' );
function remove_admin_bar() {
	if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {

		show_admin_bar( false );
	}
}


/*add_action('admin_init', 'allow_subscriber_uploads');
function allow_subscriber_uploads() {
    $subscriber = get_role('subscriber');
    $subscriber->add_cap('upload_files');
}*/


/**
 * Init call for Custom Registration Form Builder Plugin
 */

add_action( 'init', function(){
	if ( isset( $_REQUEST['submit'] ) && $_REQUEST['submit'] == 'Create Account' ) {
		echo '<div id="modal-created-user-account"  class="modal-created-user-account simplemodal-container" style="position: absolute; z-index: 9999999; height: auto; width: 25%; right: 60px; top: 170px;"><a class="modalCloseImg simplemodal-close" title="Close"></a><div tabindex="-1" class="simplemodal-wrap" style="height: 100%; outline: 0px; width: 100%; overflow: visible;"><div id="delete-success" style="" class="simplemodal-data"><h2>Your account has been created! Please Login.</h2></div></div></div>';
		return;
		
	}

} );



/*-------------------------------------------------*/
/*--------------Custom User Try-------------------*/
/*-----------------------------------------------*/

/*function thecustom_user() {
	$role = get_role( 'custom_student' );
	// create if neccesary
	if ( ! $role ) {
		$role = add_role( 'custom_student', 'Custom Student' );
	}
	// add theme specific roles
	//$role->add_cap( 'delete_posts' );
	$role->add_cap( 'edit_posts' );
	//$role->add_cap( 'delete_published_posts' );
	//$role->add_cap( 'edit_published_posts' );
	//$role->add_cap( 'publish_posts' );
	$role->add_cap( 'read' );
	$role->add_cap( 'upload_files' );
	//$role->add_cap( 'activate_plugins' );
}

add_action( 'admin_init', 'thecustom_user' );*/
function custom_dallas_subscriber_cap(){
  remove_role('subscriber');
 add_role(
 'subscriber',
 'Subscriber',
  array(
	'edit_posts' => true,
	'read' => true,
	'upload_files' => true
 ));
}
add_action( 'admin_init', 'custom_dallas_subcriber_cap' );

function login_required() {
	if ( ! is_user_logged_in() ) {
		if ( is_page_template( 'page-template-admin.php' ) ) {
			if ( ! is_user_logged_in() ) {
				wp_redirect( home_url() );
				exit;
			} else {
				if ( ( ! current_user_can( 'administrator' ) ) || ( ! current_user_can( 'contributor' ) ) ) {
					wp_redirect( home_url() );
					exit;
				}
			}
		}
	}
}

add_action( 'template_redirect', 'login_required' );


/*-------------------------------------------------*/
/*--------------GROUP MEMBER'S LIST---------------*/
/*-----------------------------------------------*/



/*-------------------------------------------------*/
/*--------------GET CURRENT DATE------------------*/
/*-----------------------------------------------*/

function mydate_func( $atts ) {

	$pfx_date = "<div class='date-container'>";
		$pfx_date .= "<div class='cal-con'>";
			$pfx_date .= "<p class='cal-break'> </p>";
			$pfx_date .= "<h1 class='d-day'>" . $showdate = date( 'j' ) . "</h1>";
		$pfx_date .= "</div>";
		$pfx_date .= "<p>" . $showdate = date( 'l' ) . "</p>";
		$pfx_date .= "<h1>" . $showdate = date( 'F j, Y' ) . "</h1>";
	$pfx_date .= "</div>";

	return $pfx_date;
}

add_shortcode( 'bbb-date', 'mydate_func' );


/*-------------------------------------------------*/
/*--------------GROUP INFO------------------------*/
/*-----------------------------------------------*/


add_shortcode( 'school-group-name', 'myGroup_func' );

function myGroup_func( $atts ) {
	$user_id     = get_current_user_id();  // Get current user Id
	$user_gro = get_term_by('id', intval($atts['id']),'user-group' );
	//check if class exist which is a plugin under User Group
	if ( class_exists( 'KWS_User_Groups' ) ) {
		$user_id = get_current_user_id();
		$user_meta = get_user_meta($user_id);
		

			$user_leader_data = get_user_by( 'id', KWS_User_Groups::get_meta( 'group_leader', $user_gro->term_id) );

			$content = "<div class='group-container'>";
			$content .= "<div class='group-row clearfix'>";
			$content .= "<div class='group-col1'>";
			$content .= ( function_exists( 'z_taxonomy_image' ) && ! is_null( z_taxonomy_image( $user_gro->term_id, $size = 'full', $attr = NULL, $echo = false ) ) ? z_taxonomy_image( $user_gro->term_id, $size = 'full', $attr = NULL, $echo = false ) : '<img src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/08/26013550/school-logo.png">' );
			$content .= "</div>";
			$content .= "<div class='group-col2'>";
			$content .= "<h3>" . $user_gro->name . "</h3>";
			$content .= "<input type='hidden' id='group-info-termid' value='".$user_gro->term_id."'>";
			$content .= wp_nonce_field( 'group_info_action', 'group_info_nonce' );
			$content .= "<p class='group-location group-info-field'>" . KWS_User_Groups::get_meta( 'group_location', $user_gro->term_id ) . "</p>";
			$content .= "<p class='group-location group-info-input' style='display:none'><input type='text' id='group-info-location' class='group-input-block' value='" . KWS_User_Groups::get_meta( 'group_location', $user_gro->term_id ) . "'></p>";
			$content .= "<p class='left-con'><span>Number of Members:</span> " . $user_gro->count . "</p>";
			$content .= "<p class='left-con'><span>Group Leader:</span> " . $user_leader_data->data->display_name . "</p>";
			$content .= "<p class='left-con group-info-field'><span>School Phone:</span> " . KWS_User_Groups::get_meta( 'group_phone', $user_gro->term_id ) . "</p>";
			$content .= is_current_user_a_leader() ? "<p class='left-con group-info-input group' style='display:none'><span>School Phone:</span> <input type='text' id='group-info-phone' class='group-input-block' value='" . KWS_User_Groups::get_meta( 'group_phone', $user_gro->term_id ) . "'></p>" : "";
			$content .= "</div>";
			$content .= "<div class='group-col3'>";
			$content .= "<p class='group-desc group-info-field'><span>About " . $user_gro->name . ": </span>" . $user_gro->description . "</p>";
			$content .= is_current_user_a_leader() ? "<p class='group-desc group-info-input' style='display:none'><span>About " . $user_gro->name . ": </span><textarea id='group-info-desc' class='group-input-block' cols='30' rows='5'>" . $user_gro->description . "</textarea></p>" : "";
			$content .= "<div class='group-btn-wrapper'>";
			$content .= is_current_user_a_leader() ? "<a href='#TB_inline?height=680&amp;width=650&amp;inlineId=groupInfoAddUser-".$user_gro->term_id."' class='thickbox edit-group-btn student-add-user' data-termid='".$user_gro->term_id."' >Add Users to Group</a><br>" : "";
			$content .= is_current_user_a_leader() ? "<a href='#TB_inline?height=680&amp;width=650&amp;inlineId=groupEditInfo-".$user_gro->term_id."' class='edit-group-btn thickbox'>Edit Info</a><br>" : "";
			global $post;
			$group_args = array(
			    'action' => 'delete_usergroup',
			    'nonce' => wp_create_nonce('delete_usergroup_'.$user_gro->term_id),
			    'term_id' => $user_gro->term_id,
			    'http' => esc_url(get_the_permalink($post->ID))

			);
			$content .= is_current_user_a_leader() ? "<a href='" .add_query_arg($group_args,admin_url('admin-post.php')). "' class='view-entry-btn delete-usergroup-student'>Delete Group</a>" : "" ;
			$content .= "</div>";
			$content .= "</div>";
			$content .= "</div>";
			$content .= "</div>";
			$content .= '<div id="groupEditInfo-'.$user_gro->term_id.'" style="display:none;">' . do_shortcode('[gravityform id="23" field_values="id='.$user_gro->term_id.'&amp;location='.KWS_User_Groups::get_meta('group_location',$user_gro->term_id).'&amp;phone='.KWS_User_Groups::get_meta('group_phone',$user_gro->term_id).'&amp;about='.$user_gro->description.'"]'). '</div>';
	} else {
		$content = "";
	}

	return $content;
}


/*function add_media_upload_scripts() {
	if ( is_page( 'student-home' ) || is_page ( 'student-admin-edit-profile' ) ) {
		return;
	}
	wp_enqueue_media();
}

add_action( 'wp_enqueue_scripts', 'add_media_upload_scripts' );*/


/*-------------------------------------------------*/
/*--------------Latest Comment Shortcode----------*/
/*-----------------------------------------------*/

function latestCommentDisplay( $atts ) {
	global $post;

	if ( isset( $atts['filter']))  {
                if ( $atts['filter'] == 'blog') {
                        $args = array(
                                'status'        => 'hold',
                                'post_type'     => 'post',
                                'order'         => 'ASC',
                        );
                } elseif ( $atts['filter'] == 'video') {
                        $args = array(
				'status'        => 'hold',
                                'post_type'     => 'flowplayer5',
                                'order'         => 'ASC',
                        );
                } else {
                        $args = array(
                                'status'        => 'hold',
                                'post_type'     => 'post',
                                'order'         => 'ASC',
                        );
                }
        } else {
                $args = array(
                        'status'        => 'hold',
                        'post_type'     => 'post',
                        'order'         => 'ASC',
                );
        }

	$comments = get_comments( $args );
	if ( $comments ) {
		$theComment = '<div class="header-tab-2">LATEST COMMENTS</div>';
		$theComment .= '<div class="the-comments et_pb_module"><ul>';
		foreach ( $comments as $comment ) {
			$theComment .= '<li>';
			$theComment .= '<h3>' . $comment->post_title . '</h3>';
			$theComment .= '<p class="comment-author">by: ' . $comment->comment_author . '</p>';
			$theComment .= '<p><span>"</span>' . $comment->comment_content . '</p>';
			$theComment .= '<div class="comments-btn">';
			$theComment .= admin_approve_comment( $comment->comment_ID );
			$theComment .= admin_reject_comment( $comment->comment_ID );
			$theComment .= admin_reply_comment( $comment->comment_ID, $comment->comment_post_ID );
			$theComment .= '</div>';
			$theComment .= '</li>';

		}
		$theComment .= '</ul></div>';
	} else {
		$theComment = '<div class="header-tab-2">LATEST COMMENTS</div>';
                $theComment .= '<div class="the-comments et_pb_module">';
		$theComment .= '<h3>NO COMMENTS</h3>';
		$theComment .= "</div>";
	}

	return $theComment;
}

add_shortcode( 'show-unapprove-comments', 'latestCommentDisplay' );


//add_filter( 'simplemodal_login_form', 'mytheme_login_form' );
function mytheme_login_form( $form ) {
	$users_can_register = get_option( 'users_can_register' ) ? true : false;
	$options            = get_option( 'simplemodal_login_options' );

	$output = sprintf( '
<form name="loginform" id="loginform" action="%s" method="post">
        <input type="button" class="simplemodal-close" value="x" tabindex="101" />
	<img src="%s/wp-content/uploads/2015/07/dallas-bbb.png">
        <div class="title"><h3>%s</h3></div>
        <div class="simplemodal-login-fields">
        <p>
                <input type="text" name="log" class="user_login input" value="" placeholder="%s" size="20" tabindex="10" />
        </p>
        <p>
                <input type="password" name="pwd" class="user_pass input" value="" placeholder="%s" size="20" tabindex="20" />
        </p>
	<p><input id="wp-submit" type="submit" name="wp-submit" class="submit-btn2" value="%s" tabindex="100" /></p>',
		MARKETNAME_DIR,
		site_url( 'wp-login.php', 'login_post' ),
		__( 'Login', 'simplemodal-login' ),
		__( 'Username', 'simplemodal-login' ),
		__( 'Password', 'simplemodal-login' ),
		__( 'Login', 'simplemodal-login' )
	);

	ob_start();
	do_action( 'login_form' );
	$output .= ob_get_clean();

	$output .= sprintf( '
        <p class="submit">
                <input id="wp-submit" type="submit" name="wp-submit" class="submit-btn" value="Login" tabindex="100" />
                <input type="button" class="simplemodal-close" value="%s" tabindex="101" />
                <input type="hidden" name="testcookie" value="1" />
        </p>
        <p class="nav">',
		__( 'Remember Me', 'simplemodal-login' ),
		__( 'Cancel', 'simplemodal-login' )
	);

	if ( $users_can_register && $options['registration'] ) {
		$output .= sprintf( '<a class="simplemodal-register" href="%s">%s</a>',
			site_url( 'wp-login.php?action=register', 'login' ),
			__( 'Register', 'simplemodal-login' )
		);
	}

	if ( ( $users_can_register && $options['registration'] ) && $options['reset'] ) {
		$output .= ' | ';
	}

	if ( $options['reset'] ) {
		$output .= sprintf( '<a class="simplemodal-forgotpw" href="%s" title="%s">%s</a>',
			site_url( 'wp-login.php?action=lostpassword', 'login' ),
			__( 'Password Lost and Found', 'simplemodal-login' ),
			__( 'Lost your password?', 'simplemodal-login' )
		);
	}

	$output .= '
        </p>
        </div>
        <div class="simplemodal-login-activity" style="display:none;"></div>
</form>';

	return $output;
}

/*-------------------------------------------------*/
/*--------------BBB Admin Blog Controls-----------*/
/*-----------------------------------------------*/


/* Delete */
function wp_delete_post_link( $link = 'Delete This', $postId ) {
	$link = "<a onclick='confirm(\"Are you sure you want to delete?\");' class='sortStatsButton' href='" . wp_nonce_url( get_bloginfo( 'url' ) . "/wp-admin/post.php?action=delete&amp;post=" . $postId, 'delete-post_' . $postId ) . "'>" . $link . "</a>";

	return $link;
}

/* Edit */
function wp_edit_post_link( $postId ) {
	$link = "<a class='sortStatsButton' href='#' onclick='editWindow()'>Edit Content</a>";

	return $link;
}


/* View */
function wp_view_post_link( $link = 'View', $postId ) {
	$link = "<a class='sortStatsButton' href='" . get_post_permalink( $postId ) . "' onclick='window.open(\"" . get_post_permalink( $postId ) . "\", \"newwindow\", \"width=1200, height=850\"); return false;'>" . $link . "</a>";

	return $link;
}

/*-------------------------------------------------*/
/*-----------BBB Admin Comment Controls-----------*/
/*-----------------------------------------------*/

/* Approve */
function admin_approve_comment( $postId ) {
	$approve_nonce = esc_html( '_wpnonce=' . wp_create_nonce( "approve-comment_$postId" ) );
	$url           = "/dallas/wp-admin/comment.php?c=$postId";
	$approve_url = esc_url( $url . "&action=approvecomment&$approve_nonce" );
	$link          = "<a href='" . $approve_url . "' data-wp-lists='delete:the-comment-list:comment-" . $postId . ":e7e7d3:action=dim-comment&amp;new=approved' class='vim-a vim-destructive' title='" . esc_attr__( 'Approve this comment' ) . "'><img style='padding: 8px 44px 7px;' src='http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/09/08015152/check.png'></a>";

	return $link;
}

/* Decline */
function admin_reject_comment( $postId ) {
	$del_nonce  = esc_html( '_wpnonce=' . wp_create_nonce( "delete-comment_$postId" ) );
	$url        = "/dallas/wp-admin/comment.php?c=$postId";
	$delete_url = esc_url( $url . "&action=deletecomment&$del_nonce" );
	$link       = "<a href='" . $delete_url . "' data-wp-lists='delete:the-comment-list:comment-$postId::delete=1' class='delete vim-d vim-destructive'><img style='padding: 5px 44px 7px;' src='http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/09/08015149/xmark1.png'></a>";

	return $link;
}

/* Reply */
function admin_reply_comment( $commentId, $postId ) {
	$html = '<a class="thickbox replyComment-btn" href="#TB_inline?height=680&amp;width=650&amp;inlineId=ReplyToComment_'.$commentId.'">REPLY</a>';
	$html .= "<div id='ReplyToComment_".$commentId."' style='display: none;'><h2>Comment Reply</h2>";
        $html .= "<div id='postbox'>";
	ob_start();
	$atts = array(  'label_submit'	=> esc_attr__( 'Reply', 'Divi' ), 
			'title_reply'	=> ' ', 
			'logged_in_as'	=> ' ', 
			'title_reply_to' => esc_attr__( 'Leave a Reply to %s', 'Divi' ), 
			'class_submit' => 'submit et_pb_button',
			'label_submit' => __('Submit')
		);
	comment_form( $atts, $postId );
	$comment_form = ob_get_clean();
	$html .= str_replace("id='comment_parent' value='0'", "id='comment_parent' value='".$commentId."'", $comment_form);
	//preg_match('/\"comment_parent\"/i', $comment_form, $matches);
	//error_log("MATCHES: ".print_r($matches,true));
        $html .= "</div>";
        $html .= '</div>';
	
	return $html;	
}


/*-------------------------------------------------*/
/*-----------BBB Admin Custom Functions-----------*/
/*-----------------------------------------------*/
/**
 * Adds class to the to main nav of the BBB Admin
 *
 * @param $page
 *
 * @return bool
 */
if ( ! function_exists( 'class_current_menu_item' ) ) {
	function class_current_menu_item( $page ) {
		$current_parent_page = get_ancestors( get_queried_object()->ID, 'page' );
		if ( is_page( $page ) || in_array( get_page_by_path( $page )->ID, $current_parent_page ) ) {
			return 'class="current-menu-item"';
		}
	}
}


/*-------------------------------------------------*/
/*-----------Gravity forms school param-----------*/
/*-----------------------------------------------*/
/**
 * Add custom variable to video insert that is the school id
 *
 * @param $value
 *
 * @return $value
 */


/*-------------------------------------------------*/
/*----------OTHER VIDEOS TO LIKE SHORTCODE--------*/
/*-----------------------------------------------*/

function otherBlogToLikeDisplay () {
	global $post;
	$args = array(
		'post_type' => 'post',
		'number' => '3',
		'orderby' => 'rand',
		'category_name' => 'BLOG'

	);
	$posts = get_posts($args);

	if ($posts) {

			$theVideo = '<div class="other-videos">';
			$theVideo .= '<h4>RELATED POSTS</h4>';

		foreach($posts as $post) {
			$comments = wp_count_comments( $post->ID );
			$theVideo .= '<div id="other-vid-container">';
			$theVideo .= '<div id="other-vid-thumb">';
			if(wp_get_attachment_url( get_post_thumbnail_id($post->ID))) {
 				$theVideo .= '<img src="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID)).'">';
			}else {
				$theVideo .= '<img src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/11/10060216/default-splash-img1.png">';
			}
			$theVideo .= '</div>';
			$theVideo .= '<div id="vid-desc">';
			$theVideo .= '<h5>' .$post->post_title. '</h5>';
			$theVideo .= '<span class="otherVidDate">'.get_the_date("F j, Y", $post->ID). '</span><span class="otherVidComment">' .$comments->approved. ' Comments</span>';
			$theVideo .= '<p class="otherVidDesc otherBlogDesc">' .wp_trim_words( $post->post_content, 15, '...' ). '</p>';
			$theVideo .= '</div>';
			$theVideo .= '<a class="otherVidLinks" href="'.post_permalink($post->ID).'">Read More</a>';
			$theVideo .= '</div>';
			
		}
			$theVideo .= '</div>';

		return $theVideo;
	}
}
add_shortcode('show-other-blogToLike', 'otherBlogToLikeDisplay');


/*-------------------------------------------------*/
/*--------------EDIT PROFILE FUNCTION-------------*/
/*-----------------------------------------------*/

function editProfileRedirect() {
	if(isset($_POST['updateuser'])) {
		if( current_user_can('contributor')){
			wp_redirect(MARKETNAME_DIR.'/bbb-admin-dashboard');
		}else {
			wp_redirect(MARKETNAME_DIR.'/student-home');
		}
	}
}
add_action('init', 'editProfileRedirect');



add_action( 'user_register', 'my_registration_save', 10, 1 );

function my_registration_save( $user_id ) {

    if ( isset( $_POST['firstname_8'] ) ){
        update_user_meta($user_id, 'first_name', $_POST['firstname_8']);
	}

    if ( isset( $_POST['lastname_9'] ) ){
        update_user_meta($user_id, 'last_name', $_POST['lastname_9']);
	}

}


/*add_action('gform_field_input','bbb_admin_edit_profile');
function bbb_admin_edit_profile($input,$field,$value,$lead_id,$form_id){
  //var_dump($form_id);

}
*/
add_filter( 'gform_pre_render_20', 'school_populate_posts' );
add_filter( 'gform_pre_validation_20', 'school_populate_posts' );
add_filter( 'gform_pre_submission_filter_20', 'school_populate_posts' );
add_filter( 'gform_admin_pre_render_20', 'school_populate_posts' );
function school_populate_posts( $form ) {

    foreach ( $form['fields'] as &$field ) {

        if ( $field->type !== 'select' && strpos( $field->cssClass, 'bbb-admin-group' ) === false ) {
            continue;
        }
	
	
	if ( strpos( $field->cssClass, 'bbb-admin-group' ) !== false ) { 
		$user_groups = get_terms( 'user-group');
		$choices = array();
		
		foreach ( $user_groups as $user_group ) {
			$choices[] = array( 'text' => $user_group->name, 'value' => $user_group->term_id);
		}

		// update 'Select a Post' to whatever you'd like the instructive option to be
		$field->placeholder = 'Select a Group';
		$field->choices = $choices;
	}
    }

    return $form;
}

add_action('gform_pre_submission_20', 'bbb_admin_gform_edit');
function bbb_admin_gform_edit( $form  ){
	$user_id = intval($_REQUEST['input_12']);
	$school_input_id = intval($_REQUEST['input_8']);
	$groups_id = array_map('intval', $_REQUEST['input_10']);
	$bio = sanitize_text_field( $_REQUEST['input_4']);
	
	update_user_meta($user_id,'school_4', $school_input_id);

	
	update_user_meta($user_id,'description',$bio,get_user_meta($user_id,'description',true));
	
	wp_set_object_terms($user_id,$groups_id,'user-group');
}
add_action( 'gform_after_submission_20', function( $entry ){
     GFAPI::delete_entry( $entry['id'] );
} );
//Create Account
add_action('gform_pre_submission_19','new_student_registration');
function new_student_registration($form){
   $username = rgpost('input_3');
   $pass = rgpost('input_2');
   $confirm_pass = rgpost('input_2_2');
   $first_name = rgpost('input_1_3');
   $last_name  = rgpost('input_1_6');
   $email_ad   = rgpost('input_7');
   $phone = rgpost('input_4');
   $location = rgpost('input_5');
   $school = rgpost('input_6');

   if(!username_exists($username) && !email_exists($email_ad) && $pass == $confirm_pass){
      $userdata = array(
        'user_login' => $username,
         'user_pass' => $pass,
         'user_email' => $email_ad,
         'first_name' => $first_name,
         'last_name' => $last_name,
         'display_name' => $first_name . ' ' . $last_name
      );
      $user_id = wp_insert_user($userdata);
      if(!is_wp_error($user_id)){
        update_user_meta($user_id,'phone',$phone);
        update_user_meta($user_id,'location',$location);
        update_user_meta($user_id,'school_4',$school);
      }
   }
}


add_action('gform_after_submission_19',function($entry){
    GFAPI::delete_entry($entry['id']);
});
/**
 * Account Sign In Hook on Gform
 */
add_filter( 'gform_validation_26', 'bbb_account_sign_in' );
function bbb_account_sign_in($validation_result){
    $form = $validation_result['form'];
    $username = rgpost('input_3');
    $pass = rgpost('input_4');
    $user_data = get_user_by('login', $username);
    $remember = rgpost('input_5') ? true : false;

    if ( username_exists($username)  && wp_check_password($pass,$user_data->data->user_pass,$user_data->ID)) { 
        $validation_result['is_valid'] = true;    
    } else { 
        $validation_result['is_valid'] = false;
        foreach($form['fields'] as &$field ) {
            if ( ! in_array($field->id,array(3,4)) ) {
                continue;
            } 
            $field->failed_validation = true;
            $field->validation_message = 'Incorrect Username or Password. Please try again.';
        }
    }
    $validation_result['form'] = $form;
    return $validation_result;
}

/**
 * Delete submission on account signin
 */
add_action('gform_after_submission_26',function($entry){
    GFAPI::delete_entry($entry['id']);
});

add_filter('gform_confirmation_26', 'account_sign_in_redirect');
function account_sign_in_redirect($confirmation,$form,$entry,$ajax ){
    $creds['user_login'] = rgpost('input_3');
    $creds['user_password'] = rgpost('input_4');
    $creds['remember'] = rgpost('input_5') ? true : false;
    $user_login = wp_signon($creds, is_ssl());

    $user_data = get_user_by('login',$creds['user_login']);
    if (!is_wp_error($user_login)){
        if (in_array('subscriber',$user_data->roles) || in_array('custom_student',$user_data->roles)){
            $confirmation = array( 'redirect' => get_the_permalink(888) );
        } elseif (in_array('contributor',$user_data->roles) || in_array('editor',$user_data->roles)) {
            $confirmation = array('redirect'=>get_the_permalink(986));
        } elseif ( in_array('administrator', $user_data->roles) ) {
            $confirmation = array('redirect' => admin_url());
        }else {
            $confirmation = array('redirect' => home_url());
        } 
    }else {
        wp_die('Something went wrong!');
    }
    return $confirmation;
}

add_action('gform_pre_submission_21', 'bbb_admin_send_email');
function bbb_admin_send_email($form){
	$email = sanitize_email($_REQUEST['input_4']);
	$subject = sanitize_text_field($_REQUEST['input_2']);
       	$body = sanitize_text_field($_REQUEST['input_3']);
        $user_data = get_user_by('email',$email);
        $fep_class = fep_main_class::init();

        $_POST["message_to"] = $user_data->data->user_login;
        $_POST["message_top"] = $user_data->data->display_name;
        $_POST["message_title"] = $subject;	
        $_POST["message_content"] = $body;
        $_POST["message_from"] = strval(get_current_user_id());
        $_POST["parent_id"] = "0";
        $_POST["token"] = fep_create_nonce('new_message'); 
        $_POST["new_message"] = "Send Message";
        $fep_class->check_message();
        //$send_email = wp_mail($email,$subject,$body);
	if ( is_wp_error($send_email)){
		wp_die( $send_email->get_error_message());
	}
}

add_action('gform_after_submission_21', function($entry){

	GFAPI::delete_entry( $entry['id'] );
}); 


add_action('wp_ajax_admin_delete_user','admin_delete_user');
add_action('wp_ajax_nopriv_admin_delete_user','admin_delete_user');
function admin_delete_user(){
  $user_id = intval($_REQUEST['id']);
  check_ajax_referer('bbb-admin-delete-'.$user_id, 'nonce');

  $delete_respond = wp_delete_user($user_id);

  echo json_encode(array( 'result' => $delete_respond));
  die();

}

add_action('admin_menu','wphidenag');
function wphidenag() {
	remove_action( 'admin_notices', 'update_nag', 3 );
}

add_action('add_meta_boxes', 'noSEO', 99);
function noSEO(){
    if (current_user_can('editor')) {
	remove_meta_box('wpseo_meta', 'advertisers', 'normal');
        remove_meta_box('wpseo_meta', 'campaigns', 'normal');
	remove_meta_box('wpseo_meta', 'banners', 'normal');
	?>
	<style>
	#minor-publishing {
        	display: none;
	}
	</style>
	<?php

    }
}

function fp5_has_shortcode( $has_shortcode ) {
        return true;
}
add_filter( 'fp5_filter_has_shortcode', 'fp5_has_shortcode' );


function custom_script() {
	wp_enqueue_style('bootstrap-modal-style', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css');
	wp_enqueue_script('bootstrap-modal-script', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js');

	wp_enqueue_script('mouse-wheel','//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js');
	wp_enqueue_style('fancybox-css', '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css');
	wp_enqueue_script( 'fancyboxes-js', '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js' );
	wp_enqueue_script( 'lazy-load', '//cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js' );
	wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', false );
	wp_enqueue_script( 'ajax-scripts-js', get_stylesheet_directory_uri() . '/js/ajax-scripts.js', false );

	wp_localize_script( 'custom-js', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	wp_enqueue_style( 'font-awesome', '//opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css' );
	wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/css/custom.css?'. time(), array(), false);
	wp_enqueue_style('responsive-style', get_stylesheet_directory_uri() . '/css/responsive.css?'. time(), array(), false);

}

add_action( 'wp_enqueue_scripts', 'custom_script' );

function modify_video_search($form){
  if(is_page(47)){
    $form = str_replace('</form>','<input type="hidden" name="post_type" value="flowplayer5"></form>',$form);
  }
  return $form;
}
add_filter('get_search_form','modify_video_search');
//will validate if the user is a superadmin and will allow access to dashboard
function validation_for_dashboard_access(){
  $is_redirect_404 = false; 
  switch(true){
    case in_array($GLOBALS['pagenow'], array('wp-login.php','wp-register.php')) && ! is_user_logged_in():
       $is_redirect_404 = true;
       break;
    case is_user_logged_in() && is_admin() && ! is_super_admin(get_current_user_id()) && ! isset($_GET['action']) && $_GET['action'] !== 'logout':
       $is_redirect_404 = true;
       break;
  }
  if($is_redirect_404) {
    wp_redirect(home_url('404'),302);exit;  
  }

}
//add_action('init','validation_for_dashboard_access');

function filter_logout_redirect_url($logout_url,$redirect){
  return add_query_arg(array('redirect_to' => home_url() ), $logout_url);

}
add_filter('logout_url', 'filter_logout_redirect_url');


/*------------------------------------------------------------------------*/
/*--------------UPDATE SPLASH IMAGE VALUE FROM POST THUMBNAIL-------------*/
/*------------------------------------------------------------------------*/

add_action( 'gform_after_submission_5', 'set_splash_img', 10, 2 );
add_action( 'gform_after_submission_13', 'set_splash_img', 10, 2 );

function set_splash_img( $entry, $form ){
	$postId = $entry["post_id"];
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $postId ) );
	update_post_meta( $postId, 'fp5-splash-image', $feat_image, get_post_meta( $post_id, 'fp5-splash-image', true ) );
}

function add_thumbnail_to_flowplayer5() {
	add_post_type_support( 'flowplayer5', 'thumbnail' );
}
add_action( 'init', 'add_thumbnail_to_flowplayer5' );


//add_action('init','catch_the_user');
function catch_the_user(){
  $userdata = wp_get_current_user();
  //var_dump($userdata);
}


function wpd_date_404_template( $template = '' ){
    global $wp_query;
    if( isset($wp_query->query['year']) ){
		$template = locate_template( 'page-showmore.php', false );
    }
    return $template;
}
add_filter( '404_template', 'wpd_date_404_template' );