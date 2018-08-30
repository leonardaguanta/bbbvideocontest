<?php
/*
Template name: Showmore
*/
status_header(200);
//get_header();
$ppp = (isset($_GET["ppp"])) ? $_GET["ppp"] : 6;
$page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 1;
$vidIds = (isset($_GET['vidIds'])) ? $_GET['vidIds'] : '';

$schools = (isset($_GET['schools'])) ? $_GET['schools'] : '';
$schoolExplode = explode(",", $schools);
$authors = "";

$sort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

$year = (isset($_GET['year'])) ? $_GET['year'] : '';

$action = (isset($_GET['action'])) ? $_GET['action'] : '';

$likes = array();
$views = array();

if($schools){
    $userArg = array(
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'school',
                'value' => $schoolExplode,
                'type' => 'NUMERIC'
            ),
        )
    );
    $user_search = new WP_User_Query( $userArg );
    $listers = $user_search->get_results();
    $lister_ids = array();
    foreach($listers as $lister) {
        $lister_ids[] = $lister->ID;
    }
    $authors = implode(',', $lister_ids);
    if(!$authors){
        $authors = 1;
    }
}else{
    $authors = 0;
}

if($sort == 'likes'){
    //unset($_SESSION['seed']);
   // remove_filter('posts_orderby', 'edit_posts_orderby');
    $likes = array(
        'key'     => '_vid_liked',
        'compare' => 'IN',
        'type' => 'NUMERIC'
    );
	$ppp = -1;
}
elseif($sort == 'views'){
   // unset($_SESSION['seed']);
    //remove_filter('posts_orderby', 'edit_posts_orderby');
    $views = array(
        'key'     => '_custom_video_view',
        'compare' => 'IN',
        'type' => 'NUMERIC'
    );
		$ppp = -1;
}else{
    if(isset($_SESSION['seed'])){
    //    $views = $_SESSION['seed'];
    }
}
$role = array(
          'key' => 'video-user-role',
          'value' => 'student',
        );

$args = array( 
	'post_type' => 'flowplayer5',
	'author' => ($authors), 
	'posts_per_page' => $ppp,
	'paged' =>  $page, 
	'post_status' => 'publish',
	'order' => 'DESC', 
	'orderby' => 'meta_value_num'
	,'meta_query' => array(
        'relation' => 'AND',$likes
    )
			 );
$videos = new WP_Query( $args );
$videoCounter = 1;
echo '<input type="hidden" value="'. $videos->max_num_pages .'" id="video_max_page"/>';

if( $videos->have_posts() ) : ?>
	  <div class="my-posts clearfix videos-page" id="ajax-posts">
<?php
while( $videos->have_posts() ) : $videos->the_post(); ?>
	<?php
		// $href = get_post_meta(get_the_ID(), "fp5-mp4-video", TRUE);
		$href = home_url( '/video-frame/?vid_id=' . get_the_ID() );
		$title = get_the_title();
		$author = get_the_author_meta( "display_name" , get_the_author_id() );
		$schoolId = get_user_meta( get_the_author_id(), 'school_4', true );
		$school = get_the_title( $schoolId );
		// $views = do_shortcode('[show-video-watch-count postId='. get_the_ID() .']');
		$views = get_post_meta(get_the_ID(), '_custom_video_view', true);
		$votes = do_shortcode('[simplevoteme_votes postId='. get_the_ID() .']');
		$description = get_post_meta(get_the_ID(), "fp5-video-description", TRUE);
		$hide = 0;
		global $flowplayer5_shortcode; 

	?>

	                <div class="video-feed et_pb_column et_pb_column_1_3  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough" data-href="<?php the_permalink(); ?>" data-id="<?php get_the_ID(); ?>" data-url="<?php echo $href; ?>" title="<?php
        echo get_the_title();
?>" data-modal-id="modal-video" data-link="<?php the_permalink(); ?>">                
                	<div class="et_pb_module et_pb_image et_pb_image_0 et_always_center_on_mobile et_pb_has_overlay">

						<?php if (has_post_thumbnail()) { ?>

							<span class="et_pb_image_wrap video-thumbnail">
								<img src="<?php the_field('fp5-splash-image');?>" alt="<?php the_title(); ?>">
								<span class="et_overlay et_pb_inline_icon" data-icon="E"></span>
							</span>
							

						<?php } ?>

               		</div>
    
    				<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
                		<div class="et_pb_text_inner">					
                    		<h3 class="video-title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h3>
							<span class="video-author"><?php echo the_author_meta('display_name', $postData[0]->post_author);?></span><span class="video-votes"> 	<?php echo do_shortcode('[simplevoteme postid='.  get_the_ID().']');?></span>
							<!--<span class="video-views">-->
							<?php// echo get_post_meta( get_the_ID(), '_custom_video_view', true);?> 
							<!-- Views</span> -->
						</div>
            		</div> <!-- .et_pb_text -->
    			</div>

    							<?php
					if($videoCounter == 6) { ?>
						</div>
				<?php } $videoCounter++; ?>
            <?php endwhile; ?>
       </div>
       	<?php else: ?>
        <?php if ($action != 'load_more_videos'){ ?>
            <div class="no-result-container">
            <h3>Oops!!</h3>
            <?php if ($year){ ?>
                <h4>We couldn't find any videos from <strong> <?php echo $year; ?></strong>.</h4></div>
            <?php }else{ ?>
                <h4>We couldn't find matching results. Please try refining your search.</h4>
            <?php } ?>
        <?php } ?>
    <?php endif; ?>

   
</div>
