<?php

/*----HIDE LABEL OPTIONS on Gravity Forms ----*/
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

function my_scripts_method() {
    wp_enqueue_script('custom-script',get_stylesheet_directory_uri() . '/script.js',
					  array( 'jquery' )
    );
	wp_enqueue_style('fancybox-css', '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css');
	wp_enqueue_script( 'fancyboxes-js', '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js' );
	wp_enqueue_script( 'extra-js', get_stylesheet_directory_uri() . '/js/extra.js', array( 'jquery' ), false, true );

	wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css');
	wp_enqueue_style('fa', get_stylesheet_directory_uri() . '/vendor/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('sb', get_stylesheet_directory_uri() . '/css/sb-admin.css');
		wp_enqueue_script( 'sb0-js', get_stylesheet_directory_uri() . '/vendor/jquery/jquery.min.js' );

	//	wp_enqueue_script( 'sb1-js', get_stylesheet_directory_uri() . '/vendor/bootstrap/js/bootstrap.bundle.min.js' );
	//	wp_enqueue_script( 'sb2-js', get_stylesheet_directory_uri() . '/vendor/jquery-easing/jquery.easing.min.js' );
		//wp_enqueue_script( 'sb3-js', get_stylesheet_directory_uri() . '/js/sb-admin.min.js' );

	wp_enqueue_script('sb0-js', get_stylesheet_directory_uri() . '/vendor/jquery/jquery.min.js', '', '1.0.0', true);
	wp_enqueue_script('sb1-js', get_stylesheet_directory_uri() . '/vendor/bootstrap/js/bootstrap.bundle.min.js', '', '1.0.0', true);
	wp_enqueue_script('sb2-js', get_stylesheet_directory_uri() . '/vendor/jquery-easing/jquery.easing.min.js', '', '1.0.0', true);
	wp_enqueue_script('sb3-js', get_stylesheet_directory_uri() . '/js/sb-admin.min.js', '', '1.0.0', true);

	wp_localize_script( 'custom-script', 'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );


add_action( 'init', 'init_theme_method' );
function init_theme_method() {
	add_thickbox();
}

/*---------- Video Form Submission--------- */

add_action( 'gform_after_submission_5', 'set_splash_img', 10, 2 );
function set_splash_img( $entry, $form ){
	$postId = $entry["post_id"];
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id( $postId ) );
	update_post_meta( $postId, 'fp5-splash-image', $feat_image, get_post_meta( $post_id, 'fp5-splash-image', true ) );
}


/*---------- SHORTCODES ------------*/

add_shortcode( 'schools', 'display_schools' );
function display_schools() {
	ob_start();
    include 'shortcodes/functions-schools.php';
    $ret = ob_get_contents();
    ob_end_clean();
	return $ret;
}

add_shortcode( 'schools_home', 'display_schools_home' );
function display_schools_home() {
	ob_start();
    include 'shortcodes/functions-schools-home.php';
    $ret = ob_get_contents();
    ob_end_clean();
	return $ret;
}
add_shortcode( 'videos-home', 'videos_home' );
function videos_home() {
	ob_start();
    include 'shortcodes/functions-video-home.php';
    $ret = ob_get_contents();
    ob_end_clean();
	return $ret;

}
add_shortcode( 'student-videos', 'student_videos' );
function student_videos() {
	ob_start();
    include 'shortcodes/functions-student-video.php';
    $ret = ob_get_contents();
    ob_end_clean();
	return $ret;

}


/*---- Video Load More -----*/
//add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
//add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');
function load_posts_by_ajax_callback() {
	check_ajax_referer('load_more_posts', 'security');
	$paged = $_POST['page'];
	$args = array(
		'post_type' => 'flowplayer5',
		'post_status' => 'publish',
		'posts_per_page' => '3',
		'paged' => $paged,
	);
	$my_posts = new WP_Query( $args );
	if ( $my_posts->have_posts() ) :
		?>
		<?php while ( $my_posts->have_posts() ) : $my_posts->the_post();

$href = home_url( '/video-frame/?vid_id=' . get_the_ID() );
?>
	<div class="video-feed et_pb_column et_pb_column_1_3  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough" data-href="<?php the_permalink(); ?>" data-id="<?php get_the_ID(); ?>" data-url="<?php echo $href; ?>" title="<?php
        echo get_the_title();
?>" data-modal-id="modal-video" data-link="<?php the_permalink(); ?>">				
				<div class="et_pb_module et_pb_image et_pb_image_0 et_always_center_on_mobile">
				<?php if ( has_post_thumbnail() ) { ?>
                    <span class="et_pb_image_wrap video-thumbnail"><img src="<?php the_field('fp5-splash-image'); ?>" alt=""></span>
				<?php } ?>
			    </div>
	
	<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
				
				
				<div class="et_pb_text_inner">
					<h3 class="video-title"><a href="<?php the_permalink(); ?>"><?php
        echo get_the_title();
?></a></h3><span class="video-author"><?php echo the_author_meta( 'display_name', $postData[0]->post_author ) ?></span> | <span class="video-votes"> 	<?php echo do_shortcode('[simplevoteme postid='.  get_the_ID().']');?>
				</span></div>
			</div> <!-- .et_pb_text -->
	</div>
		<?php endwhile ?>
		<?php
	endif;

	wp_die();
}
function save_view_meta(){
	
	$video_id = (isset($_POST["video_id"])) ? $_POST["video_id"] : 0;
	if($video_id) {
		$extra_video_info = get_post_meta($video_id);
		$videoName = $extra_video_info['fp5-mp4-video'][0];
		$videoName = basename($videoName, ".mp4");
		
		$ga1 = new Platypus_GA();
		$analytics = $ga1->getService();
		$profile = $ga1->getFirstProfileId($analytics);

		$results = $ga1->getVideoWatchCount($analytics, $profile, $videoName);
		$rows = $results->getRows();
		$videoViews = $rows[0][1];
		
		if(!$videoViews) {
			$videoViews = "0";
		}
	} else {
		$videoViews ="0";
	} 
	
	if ( ! add_post_meta( $video_id, '_custom_video_view', $videoViews, true ) ) { 
		update_post_meta( $video_id, '_custom_video_view', $videoViews );
	}
	echo $video_id;
	wp_die();
	
}
add_action( 'wp_ajax_save_view_meta', 'save_view_meta' );
add_action( 'wp_ajax_nopriv_save_view_meta', 'save_view_meta' ); 

function showVideoWatchCount($atts) {
	if($atts['postid']) {
			$views = get_post_meta($atts['postid'], '_custom_video_view', true);

	} else {
		$views ="0";
	}
	return $views;
}

add_shortcode('show-video-watch-count', 'showVideoWatchCount');


add_filter( 'wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2 );

function wti_loginout_menu_link( $items, $args ) {
   if ($args->theme_location == 'primary-menu') {
      if (is_user_logged_in()) {
         $items .= '<li class="right get-started"><a href="'. wp_logout_url() .'">'. __("Log Out") .'</a></li>';
      } else {
        // $items .= '<li class="right"><a href="'. wp_login_url(get_permalink()) .'">'. __("Log In") .'</a></li>';
      }
   }
   return $items;
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

//function to update post status
function change_post_status( $post_id, $status ) {
        $current_post                = get_post( $post_id, 'ARRAY_A' );
        $current_post['post_status'] = $status;
        wp_update_post( $current_post, true );
}
add_action('wp_ajax_approve_video_ajax', 'approve_video_ajax');
add_action('wp_ajax_nopriv_approve_video_ajax', 'approve_video_ajax');
function approve_video_ajax(){
   if ( isset( $_REQUEST['FE_PUBLISH'] ) && $_REQUEST['FE_PUBLISH'] == 'FE_PUBLISH' ) {
        if ( isset( $_REQUEST['pid'] ) && ! empty( $_REQUEST['pid'] ) ) {
                $current_post = get_post( $_REQUEST['pid'], 'ARRAY_A' );
	 	$current_post_meta = get_post_meta($_REQUEST['pid']);
		$schoolPost = get_post($current_post_meta['fp5-video-school-id'][0]);
                $schoolName = $schoolPost->post_title;

                if($current_post['post_type']=='flowplayer5') {
			$title = $current_post['post_title'];
		//	$categoryStudentVideo = get_cat_ID('Student Video');
		//	$catSlugStudentVideo = get_category($categoryStudentVideo);
        	//	$categorySchool = get_cat_ID("$schoolName");
			//$catSlugSchool = get_category($categorySchool);
// "/".$catSlugStudentVideo->slug."/".$catSlugSchool->slug."/$title",
                        $new_page = array(
                                'post_content'  => '[flowplayer id="'.$current_post['ID'].'"]',
				'post_title'	=> "$title",
				'post_name'	=> "$title",
				'post_status'	=> 'publish',
				'ping_status'	=> 'closed',
				'comment_status'	=> 'open',
				'post_category'	=> array($categoryStudentVideo,$categorySchool)
                        );
			//error_log("NEW POST: ".print_r($new_page,true));
			//wp_insert_post( $new_page );
                }
                change_post_status( (int) $_REQUEST['pid'], 'publish' );
        }
   }
wp_die();
}

?>