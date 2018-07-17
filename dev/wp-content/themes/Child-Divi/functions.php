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
	
	wp_localize_script( 'custom-js', 'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );



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
add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');
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
?></a></h3><span class="video-author"><?php echo the_author_meta( 'display_name', $postData[0]->post_author ) ?></span> | <span class="video-votes"> Votes
				</span></div>
			</div> <!-- .et_pb_text -->
	</div>
		<?php endwhile ?>
		<?php
	endif;

	wp_die();
}





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


function admin_default_page() {
  return '/new-dashboard-url';
}

add_filter('login_redirect', 'admin_default_page');




?>