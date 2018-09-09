<?php

require get_stylesheet_directory() . '/lib/wp_bootstrap_pagination.php';

/*----HIDE LABEL OPTIONS on Gravity Forms ----*/
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'fixes-style', get_stylesheet_directory_uri() . '/style-fixes.css' );

}
add_filter( 'edit_post_link', function( $link, $post_id, $text )
{
    // Add the target attribute 
    if( false === strpos( $link, 'target=' ) )
        $link = str_replace( '<a ', '<a target="_blank" ', $link );

    return $link;
}, 10, 3 );



function my_scripts_method() {
	 if ( 
		 is_page_template( 'page-bbb-admin.php' ) || 
		 is_page_template( 'page-bbb-admin-account-registration.php' ) ||
		 is_page_template( 'page-bbb-admin-pages.php' ) ||
		 is_page_template( 'page-bbb-admin-videos-approved2.php' ) ||
		 is_page_template( 'page-bbb-admin-videos-approved.php' ) ||
		 is_page_template( 'page-bbb-admin-sponsors.php' ) ||
		 is_page_template( 'page-student-home-video.php' ) ||
		 is_page_template( 'page-student-home-video2.php' ) ||
		 is_page_template( 'page-bbb-admin-videos.php' ) ||
		 is_page_template( 'page-bbb-admin-statistics.php' ) ||
		 is_page_template( 'page-student-home.php' ) ||
		 is_page_template( 'page-bbb-admin-client-student.php' ) ||
		 is_page_template( 'page-student-edit-profile.php' )		||
		 is_page_template( 'page-admin-edit-profile.php' )		
		)  {
  wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css');
	wp_enqueue_style('fa', get_stylesheet_directory_uri() . '/vendor/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('sb', get_stylesheet_directory_uri() . '/css/sb-admin.css');
		wp_enqueue_script( 'sb0-js', get_stylesheet_directory_uri() . '/vendor/jquery/jquery.min.js' );

	wp_enqueue_script('sb0-js', get_stylesheet_directory_uri() . '/vendor/jquery/jquery.min.js', '', '1.0.0', true);
	wp_enqueue_script('sb1-js', get_stylesheet_directory_uri() . '/vendor/bootstrap/js/bootstrap.bundle.min.js', '', '1.0.0', true);
	wp_enqueue_script('sb2-js', get_stylesheet_directory_uri() . '/vendor/jquery-easing/jquery.easing.min.js', '', '1.0.0', true);
	wp_enqueue_script('sb3-js', get_stylesheet_directory_uri() . '/js/sb-admin.min.js', '', '1.0.0', true);
		 
		wp_enqueue_script('msc-js', get_stylesheet_directory_uri() . '/js/msc-script.js', '', '1.0.0', true);	 
		 	wp_enqueue_style('msc-css', get_stylesheet_directory_uri() . '/css/msc-style.css');

		 

  }
	
	
    wp_enqueue_script('custom-script',get_stylesheet_directory_uri() . '/script.js',
					  array( 'jquery', 'slick-js' )
    );
//	wp_enqueue_style('fancybox-css', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.css');
	//wp_enqueue_script('fancyboxes-js', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.js');
		wp_enqueue_style('fancybox-css', '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css');
	wp_enqueue_script( 'fancyboxes-js', '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js' );
	wp_enqueue_script( 'extra-js', get_stylesheet_directory_uri() . '/js/extra.js', array( 'jquery' ), false, true );


	wp_enqueue_style( 'slick-css', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
	wp_enqueue_script( 'slick-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), false, true );

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
	update_post_meta( $postId, 'fp5-splash-image', $feat_image, get_post_meta( $postId, 'fp5-splash-image', true ) );
	$inputvideo = get_post_meta( $postId, 'fp5-mp4-video', true );
	//var_dump($inputvideo);
	$output_path= "/var/www/www.bbbvideocontest.org/dev/wp-content/themes/Child-Divi/compressed/";
	//$dirid = uniqid();
	//$file = basename($inputvideo);  
	//$output = $output_path.$dirid.$file;
//	var_dump($file);
//	var_dump($output);
	
$dirid = uniqid();
$file = basename($inputvideo);  
$uniquedir = $dirid.$file;


$output_path = "/var/www/www.bbbvideocontest.org/dev/wp-content/uploads/compressed/".$uniquedir;
$video_url = get_home_url().'/wp-content/uploads/compressed/'.$uniquedir;
	
	
	
	//$compress = shell_exec("ffmpeg -i $inputvideo -vcodec h264 -acodec mp3 $output_path 2>&1 &"); //orig
	$compress = shell_exec("ffmpeg -i $inputvideo -vcodec h264 -acodec copy $output_path 2>&1 &"); 
	
	

	
	// echo $compress;
	update_post_meta( $postId, 'fp5-mp4-video', $video_url, get_post_meta( $postId, 'fp5-mp4-video', true ) );
	
	//$upload_dir = wp_upload_dir();
//echo $upload_dir['path'];
	//	var_dump($upload_dir['path']);
	 
	//$b = shell_exec("ffmpeg -i http://bbbvideocontest.platypustest.info/dev/wp-content/uploads/gravity_forms/5-5d56ef895adebe8f7baf7de030995dec/2018/08/StudentVideoContest2018_Generic8.mp4 -vcodec h264 -acodec mp3 /var/www/www.bbbvideocontest.org/dev/wp-content/themes/Child-Divi/output7.mp4 2>&1 & ");
   //  echo $b;
	
		
	//$b = shell_exec("ffmpeg -i http://bbbvideocontest.platypustest.info/dev/wp-content/uploads/gravity_forms/5-5d56ef895adebe8f7baf7de030995dec/08/2018/25034.MP4 -vcodec h264 -acodec mp3 /var/www/www.bbbvideocontest.org/dev/wp-content/themes/Child-Divi/compressed/25034.MP4 2>&1 & ");
    // echo $b;
	
	//$string = "ffmpeg -i $inputvideo -vcodec h264 -acodec mp3 '".$output." 2>&1 & '";
	//var_dump($string);
//	$compress = shell_exec("ffmpeg -i '".$file."' -vcodec h264 -acodec mp3 '".$output." 2>&1 & '");
	//var_dump($compress);
	//shell_exec("ffmpeg -i $inputvideo -vcodec h264 -acodec mp3 output3.mp4");
	//shell_exec("ffmpeg -i http://bbbvideocontest.platypustest.info/dev/wp-content/uploads/gravity_forms/5-5d56ef895adebe8f7baf7de030995dec/2018/08/StudentVideoContest2018_Generic8.mp4 -vcodec h264 -acodec mp3 /home/leonarda/output5.mp4");
	//var_dump($test);
//ffmpeg -i test.mp4 -vcodec h264 -acodec mp3 output2.mp4

if( ! add_post_meta( $postId, 'video-user-role', 'student', true ) ){
                     update_post_meta( $postId, 'video-user-role', 'student');
                  }
	
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
	$link = "<a onclick='confirm(\"Are you sure you want to delete?\");' class='sortStatsButton delete-class' href='" . wp_nonce_url( get_bloginfo( 'url' ) . "/wp-admin/post.php?action=delete&amp;post=" . $postId, 'delete-post_' . $postId ) . "'>" . $link . "</a>";

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


function videoStatsDisplay_student($postVideo) {
	$comments = wp_count_comments( $postVideo->ID );

	$extra_video_info = get_post_meta($postVideo->ID);
	$videoName = $extra_video_info['fp5-mp4-video'][0];
	$videoName = basename($videoName, ".mp4");
	
	$ga = new Platypus_GA();
	$analytics = $ga->getService();
	$profile = $ga->getFirstProfileId($analytics);
	
	try {
		$day = 6;
		$dataView='';
		$lowestValue = array();
		$highestValue = array();
		while($day>=0) {
			$date = date('Y-m-d', strtotime("-$day days"));
			$dayOfTheWeek = date('l', strtotime("-$day days"));
			if($dayOfTheWeek=='Thursday') {
				$dayString = "TH";
			} else {
				$dayString = substr($dayOfTheWeek,0,1);
			}
			$results = $ga->getVideoWatchCountPerDate($analytics, $profile, $videoName, $date, $date);
				$rows = $results->getRows();
				$videoViews = $rows[0][1];
				if(!$videoViews) {
					$videoViews = "0";
				}
			$day--;
			if(empty($lowestValue)) {
				$lowestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
			} elseif($lowestValue['view']>=$videoViews) {
				$lowestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
			}

			if(empty($highestValue)) {
				$highestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
			} elseif($highestValue['view']<=$videoViews) {
				$highestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
			}
			$dataView .= "[\"$dayString\", $videoViews],";
		}
		$dataView = rtrim($dataView, ",");

		// New vs Returning
		$results = $ga->getVideoNewVsReturningCount($analytics, $profile, str_replace(home_url(), '', get_permalink( $postVideo->ID )));
			$rows = $results->getRows();
		if($rows[0][0]=='New Visitor') {
					$newVisitorData = $rows[0][1];
			} elseif($rows[0][0]=='Returning Visitor') {
					$returnVisitorData = $rows[0][1];
			}
			if($rows[1][0]=='New Visitor') {
					$newVisitorData = $rows[1][1];
			} elseif($rows[1][0]=='Returning Visitor') {
					$returnVisitorData = $rows[1][1];
			}
		if(!$newVisitorData) {
			$newVisitorData = 0;
		}
		if(!$returnVisitorData) {
					$returnVisitorData = 0;
			}

		// Average View Duration
		$results = $ga->getVideoWatchAvgDuration($analytics, $profile, $videoName);
		$rows = $results->getRows();
		$avgDuration = $rows[0][1];
		$output = '
				<div class="modal fade student-videoModal bd-example-modal-lg" id="ApprovedVideoStatPopup_'.$postVideo->ID.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">                                               
                            <div class="modal-body">
					<div class="main-container">
							<div class="row-one student-video-row">
									<div class="col-one">
											<div class="vid-chart">
						<div id="chart_div_'.$postVideo->ID.'" style="width: 244px; height: 158px;"></div>
													<script>
													google.setOnLoadCallback(drawChart);
													function drawChart() {
									var data = google.visualization.arrayToDataTable([
																		["days", "Views" ],
										'.$dataView.'
																]);
									var options = {
																	hAxis: {titleTextStyle: {color: "#333"}},
																	vAxis: {viewWindow:{min:0}},
										chartArea:{ left: "10%", top: "5%", width: "87%", height: "85%" },
										height: 158,
										width: 244,
																	legend: {position: "none"}
															};
															var chart = new google.visualization.AreaChart(document.getElementById("chart_div_'.$postVideo->ID.'"));
															chart.draw(data, options);
													}
										</script>
												</div>
												<div class="vid-stats">
													<p><span class="yellow">HIGHEST:<br>
													</span>'.$highestValue['view'].' views('.$highestValue['day'].')</p>
													<p><span class="yellow">LOWEST:<br>
													</span>'.$lowestValue['view'].' views('.$lowestValue['day'].')</p>
												</div>
										</div>
										<div class="col-two">
											<table class="custom-table-video">
													<tbody>
															<tr>
																<td class="likes">'.do_shortcode('[simplevoteme postId='.$postVideo->ID.']').'</td>
																
															</tr>
															<tr>
																<td class="views">'. get_post_meta($postVideo->ID, '_custom_video_view', true) /*do_shortcode('[show-video-watch-count postId='.$postVideo->ID.']')*/ .' total views</td>
																
															</tr>
													</tbody>
												</table>
										</div>
						</div>
								<div class="row-one student-video-row">
									<div class="col-one">
												<div class="col-one pie-col-one">
													<div class="piechart" id="piechart_'.$postVideo->ID.'">
													</div>
							<script type="text/javascript">
									google.load("visualization", "1", {packages:["corechart"]});
									google.setOnLoadCallback(drawChart);
									function drawChart() {
										var data = google.visualization.arrayToDataTable([
											["Type", "Views"],
											["New Views",   '.$newVisitorData.'],
											["Returning Views", '.$returnVisitorData.']
										]);

										var options = {
											title: "New Vs. Returning",
										width: 320
										};
										var chart = new google.visualization.PieChart(document.getElementById("piechart_'.$postVideo->ID.'"));
										chart.draw(data, options);
									}
								</script>
												</div>
												<!-- <div class="col-two pie-col-two">
													<div class="view-duration">Avg. View Duration<br>
															<span class="yellow">00:07:16</span><br>
															<span class="video-view-graph"><a href="#"><img class="aligncenter size-full wp-image-1232" src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/07/28223252/video-view-graph.png" height="26" width="111"></a></span>
													</div>
													<div class="new-views">% News Views<br>
															<span class="yellow">00:07:16</span><br>
															<span class="video-view-graph"><a href="#"><img class="aligncenter size-full wp-image-1232" src="http://platypus-dallas.s3.amazonaws.com/wp-content/uploads/2015/07/28223252/video-view-graph.png" alt="video-view-graph" height="26" width="111"></a></span>
													</div>
												</div> -->

										</div>
										<div class="col-two">
												<div class="col-one dest-col-one">
													<p class="share-title">VIEW DURATION</p>
							<p> Average Views</p>
							<!-- <p>Less than 10 seconds</p>
							<p>0 - 10 Seconds</p>
							<p>0 - 60 Seconds</p>
							<p>60 - 600 Seconds</p>
							<p>600 - 1801+ Seconds</p>-->
												</div>
												<div class="col-two dest-col-two">	
							<p>'.number_format($avgDuration,2).'</p>
							<!-- <p>4</p><p>5</p><p>24</p><p>61</p><p>12</p> -->
												</div>
										</div>
							</div>
						</div>
						</div>
						</div>
						</div>
				</div>';
		return $output;
    } catch (\Exception $e) { // <<<<<<<<<<< You must use the backslash
      	return "<h5 style='margin-top: 10px; text-align: center; font-weight: bold; color: red;'>Google_Service_Exception - Quota Error: has exceeded the daily request limit.</h5>";
    }


	
}

add_action('gform_pre_submission_10', 'bbb_admin_send_email_pending');
function bbb_admin_send_email_pending($form){
	$to = sanitize_email($_REQUEST['input_1']);
	$subject = sanitize_text_field($_REQUEST['input_2']);
    $message = sanitize_text_field($_REQUEST['input_3']);

wp_mail( $to, $subject, $message );
}

add_action('gform_pre_submission_9', 'bbb_admin_send_email');
function bbb_admin_send_email($form){
		$to = sanitize_email($_REQUEST['input_1']);
	$subject = sanitize_text_field($_REQUEST['input_2']);
       	$message = sanitize_text_field($_REQUEST['input_3']);

wp_mail( $to, $subject, $message );
}

add_action('gform_after_submission_9', function($entry){

	//GFAPI::delete_entry( $entry['id'] );
}); 
add_action('wp_ajax_admin_delete_school','admin_delete_school');
add_action('wp_ajax_nopriv_admin_delete_school','admin_delete_school');
function admin_delete_school(){
  $school_id = intval($_REQUEST['id']);
 // check_ajax_referer('bbb-admin-delete-'.$school_id, 'nonce');

  $delete_respond = wp_trash_post($school_id);

  echo json_encode(array( 'result' => $delete_respond));
  die();

}
/* Delete */
function wp_delete_school_link( $link = 'Delete This', $postId ) {
	$nonce = wp_create_nonce('bbb-admin-delete-'.$postId);
	$link = "<a class='sortStatsButton delete-school delete-class' data-id='".$postId."' data-nonce='".$nonce."'>Delete</a>";

	return $link;
}
add_action('wp_ajax_admin_delete_user','admin_delete_user');
add_action('wp_ajax_nopriv_admin_delete_user','admin_delete_user');
function admin_delete_user(){
  $user_id = intval($_REQUEST['id']);
  check_ajax_referer('bbb-admin-delete-'.$user_id, 'nonce');

  $delete_respond = wp_delete_user($user_id);

  echo json_encode(array( 'result' => $delete_respond));
  die();

}
add_action('wp_ajax_admin_deactivate_video','admin_deactivate_video');
add_action('wp_ajax_nopriv_admin_deactivate_video','admin_deactivate_video');
function admin_deactivate_video(){
	 $post_id = intval($_POST['id'] );

	// Update post 37
  $my_post = array(
      'ID'           => $post_id,
      'post_status'   =>  'pending',
  );
 
// Update the post into the database
  wp_update_post( $my_post );
if (is_wp_error( $post_id )) {
    $errors = $post_id->get_error_messages();
 $response['result'] =  $errors;
}	
	
        $response['id'] = $post_id;
	    wp_send_json( $response );

 // die();

}
add_action('wp_ajax_viewstat','viewstat');
add_action('wp_ajax_nopriv_viewstat','viewstat');
function viewstat(){
 $post_id = intval($_POST['id'] );
	
 $comments = wp_count_comments( $post_id);

  $extra_video_info = get_post_meta($post_id);
  $videoName = $extra_video_info['fp5-mp4-video'][0];
  $videoName = basename($videoName, ".mp4");
  
  $ga = new Platypus_GA();
  $analytics = $ga->getService();
  $profile = $ga->getFirstProfileId($analytics);
  
 
    $day = 6;
    $dataView='';
    $lowestValue = array();
    $highestValue = array();
    while($day>=0) {
      $date = date('Y-m-d', strtotime("-$day days"));
      $dayOfTheWeek = date('l', strtotime("-$day days"));
      if($dayOfTheWeek=='Thursday') {
        $dayString = "TH";
      } else {
        $dayString = substr($dayOfTheWeek,0,1);
      }
      $results = $ga->getVideoWatchCountPerDate($analytics, $profile, $videoName, $date, $date);
        $rows = $results->getRows();
        $videoViews = $rows[0][1];
        if(!$videoViews) {
          $videoViews = "0";
        }
      $day--;
      if(empty($lowestValue)) {
        $lowestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
      } elseif($lowestValue['view']>=$videoViews) {
        $lowestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
      }

      if(empty($highestValue)) {
        $highestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
      } elseif($highestValue['view']<=$videoViews) {
        $highestValue = array('day' => $dayOfTheWeek, 'view' => $videoViews);
      }
      $dataView .= "[\"$dayString\", $videoViews],";
    }
    $dataView = rtrim($dataView, ",");

    // New vs Returning
    $results = $ga->getVideoNewVsReturningCount($analytics, $profile, str_replace(home_url(), '', get_permalink( $post_id )));
      $rows = $results->getRows();
    if($rows[0][0]=='New Visitor') {
          $newVisitorData = $rows[0][1];
      } elseif($rows[0][0]=='Returning Visitor') {
          $returnVisitorData = $rows[0][1];
      }
      if($rows[1][0]=='New Visitor') {
          $newVisitorData = $rows[1][1];
      } elseif($rows[1][0]=='Returning Visitor') {
          $returnVisitorData = $rows[1][1];
      }
    if(!$newVisitorData) {
      $newVisitorData = 0;
    }
    if(!$returnVisitorData) {
          $returnVisitorData = 0;
      }

    // Average View Duration
    $results = $ga->getVideoWatchAvgDuration($analytics, $profile, $videoName);
    $rows = $results->getRows();
    $avgDuration = $rows[0][1];	
	
	$highlow = '<div class="col-one">

												<div class="vid-stats">
													<p><span class="yellow">HIGHEST:<br>
													</span>'.$highestValue['view'].' views('.$highestValue['day'].')</p>
													<p><span class="yellow">LOWEST:<br>
													</span>'.$lowestValue['view'].' views('.$lowestValue['day'].')</p>
												</div>
										</div>';
		//$highlow = 'WAT';
	  $response['avgDuration'] =  $avgDuration;
	  $response['highlow'] =  $highlow;
	  $response['highestValue'] =  $highestValue;
	  $response['lowestValue'] =  $lowestValue;
	  $response['newVisitorData'] =  $newVisitorData;
	  $response['returnVisitorData'] =  $returnVisitorData;
	  $response['dataView'] = $dataView;
	  $response['votes'] =  do_shortcode('[simplevoteme postId='.$post_id.']');
	
	    wp_send_json( $response );
	
	
	
	
	
}

class CSVExport
{
    /**
     * Constructor
     */
    public function __construct()
    {
        if (isset($_GET['download_report'])) {
            $csv = $this->generate_csv();
           // $csv = $this->download_report();
          header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"BBB Video Contest Student Info-". date('Y-m-d') .".csv\";");
            header("Content-Transfer-Encoding: binary");
            
           echo $csv;
           exit;
        }
        
        // Add extra menu items for admins
        add_action('admin_menu', array(
            $this,
            'admin_menu'
        ));
        
        // Create end-points
        add_filter('query_vars', array(
            $this,
            'query_vars'
        ));
        add_action('parse_request', array(
            $this,
            'parse_request'
        ));
    }
    
    /**
     * Add extra menu items for admins
     */
    public function admin_menu()
    {
        // add_menu_page('Download Report', 'Download Report', 'manage_options', 'download_report', array(
        //     $this,
        //     'download_report'
        // ));
    }
    
    /**
     * Allow for custom query variables
     */
    public function query_vars($query_vars)
    {
        $query_vars[] = 'download_report';
        return $query_vars;
    }
    
    /**
     * Parse the request
     */
    public function parse_request(&$wp)
    {
        if (array_key_exists('download_report', $wp->query_vars)) {
            $this->download_report();
            exit;
        }
    }
    
    /**
     * Download report
     */
    public function download_report()
    {

    }
    
    /**
     * Converting data to CSV
     */
    public function generate_csv()
    {	
		/*
		$blogusers = get_users( 'orderby=nicename&role=subscriber' );
		$output = "Primary Email,School,Location,Students,User Registered \n";
		$student_list = "";
		foreach ( $blogusers as $user ) {
			$location = $user->student_location;
			$school = $user->student_school;
			$primary_email = $user->user_email;
			$reg_date = $user->user_registered;
			$students = maybe_unserialize( $user->students );
			foreach ($students as $student) {
				$student_list .=  $student[25][0] . ' ' . $student[25][1] . ' (' . $student[24][0] . ')' . "\n";
			}
			$output .= "$primary_email,$school,$location,\"$student_list\",$reg_date \n";
		}
        
        return $output;
		*/



$blogusers = get_users( 'orderby=nicename&role=subscriber' );

$output = "Name, Email ,Groupname, Primary Email, School\n";
$student_list = "";
foreach ( $blogusers as $user ) {
	$primary_email = $user->user_email;
	 $user_meta = get_user_meta($user->ID);
	$groupname = $user_meta['nickname'][0];
	$members = get_user_meta( $user->ID, 'student' , true );
	$someArray = json_decode($members, true);
	$user_school_id = get_the_author_meta('school',$user->ID);

	$school = get_post($user_school_id)->post_title;



		//	echo $school;
	foreach ($someArray as $key => $value) {
		$student_list .=  $value["Name"] . ", " . $value["Email"] . ", " . $groupname . ", ". $primary_email . ", "  . $school ."\n";
	}

	$output  .=  "$student_list";
}
		echo $output;
    }
}

// Instantiate a singleton of this plugin
$csvExport = new CSVExport();



function get_archives_link_mod ( $link_html ) {
    preg_match ("/value='(.+?)'/", $link_html, $url);
    preg_match("/value='(.+?)'>(.*?)</", $link_html, $output_array);

	$link_html = '<option value="'. trim($output_array[2]) .'">'. $output_array[2] .'</option>';
    return $link_html;
}
add_action('wp_ajax_voting_status','voting_status');
add_action('wp_ajax_nopriv_voting_status','voting_status');
function voting_status () {
	
 
	$option_name = 'voting_status' ;
	$new_value = $_POST['value'];

if ( get_option( $option_name ) !== false ) {

    // The option already exists, so we just update it.
    update_option( $option_name, $new_value );
	   $response['status'] = $new_value;
	    wp_send_json( $response );

	
} else {

    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
    $deprecated = null;
    $autoload = 'no';
    add_option( $option_name, $new_value, $deprecated, $autoload );
	   $response['status'] = $new_value;
	    wp_send_json( $response );
}

}

add_action('wp_ajax_get_voting_status','get_voting_status');
add_action('wp_ajax_nopriv_get_voting_status','get_voting_status');
function get_voting_status () {
	wp_send_json( get_option( 'voting_status' ) );
}






?>