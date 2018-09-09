<?php
    $likes = array(
        'key'     => '_vid_liked',
        'compare' => 'IN',
        'type' => 'NUMERIC'
    );
    $args = array( 
        'post_type' => 'flowplayer5',
        'posts_per_page'=>-1 ,
        'post_status' => 'publish',
        'order' => 'DESC', 
        'orderby' => 'meta_value_num',
        'meta_query' => array(
            'relation' => 'AND',$likes
        )
    );

    $videos = new WP_Query( $args );

    if( $videos->have_posts() ) : ?>

        <div class="my-posts clearfix videos-page video-ranks-container" id="ajax-posts" data-page="<?php echo $videos->max_num_pages; ?>">

        <?php while ($videos->have_posts()): $videos->the_post(); 
            $href = home_url( '/video-frame/?vid_id=' . get_the_ID() );
            $extra_video_info = get_post_meta(get_the_ID());
            $videoName = $extra_video_info['fp5-mp4-video'][0];
            $videoName = basename($videoName, ".mp4");
        ?>
            <input type="hidden" value="<?php echo $videos->max_num_pages; ?>" id="video_max_page"/>
            <div class="video-rankfeed video-feed" data-href="<?php the_permalink(); ?>" data-id="<?php get_the_ID(); ?>" data-url="<?php echo $href; ?>" title="<?php echo get_the_title();
?>" data-modal-id="modal-video" data-link="<?php the_permalink(); ?>">                               
                <div class="et_pb_blurb et_pb_module et_pb_bg_layout_light et_pb_text_align_left rank-video et_pb_blurb_0 et_pb_blurb_position_left">
                    <div class="et_pb_blurb_content">
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="et_pb_main_blurb_image"><span class="et_pb_image_wrap"><img src="<?php the_field('fp5-splash-image');?>" alt="<?php the_title(); ?>" class="et-waypoint et_pb_animation_off"></span></div>
                        <?php } else { ?>
                            <div class="et_pb_main_blurb_image"><span class="et_pb_image_wrap"><img src="http://placehold.it/120x80" alt="<?php the_title(); ?>" class="et-waypoint et_pb_animation_off"></span></div>
                        <?php } ?>

                        <div class="et_pb_blurb_container">
                            <h4 class="et_pb_module_header"><?php the_title(); ?></h4>
                            <div class="et_pb_blurb_description">
                                <p><?php echo the_author_meta('nickname', $postData[0]->post_author);?></p>
                               <?php 
										   $status = get_option( 'voting_status' );
										   if ( $status == 'ON' || user_can( wp_get_current_user(), 'administrator' ) ){
											   ?>
								 <span class="rank-divider"> | </span>
                                <span class="video-votes">
											<?php
											   echo do_shortcode('[simplevoteme postid='. $videoId .']');?>
								</span><?php
										   }; 
						?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    <?php endif; ?>