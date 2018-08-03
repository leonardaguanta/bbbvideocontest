<?php
    $likes = array();
    $likes = array(
        'key'     => '_vid_liked',
        'compare' => 'IN',
        'type' => 'NUMERIC'
    );

    $args = array( 
        'post_type' => 'flowplayer5',
        'posts_per_page'=>1,
        'post_status' => 'publish',
        'order' => 'DESC', 
        'orderby' => 'meta_value_num',
        'meta_query' => array(
            'relation' => 'AND',$likes
            )
    );

    $my_posts = new WP_Query( $args );

    if( $my_posts->have_posts() ) : ?>
        <div class="my-posts clearfix videos-page" id="ajax-posts" data-page="<?php echo $my_posts->max_num_pages; ?>">

        <?php while ($my_posts->have_posts()): $my_posts->the_post(); 
            $href = home_url( '/video-frame/?vid_id=' . get_the_ID() );
            $extra_video_info = get_post_meta(get_the_ID());
            $videoName = $extra_video_info['fp5-mp4-video'][0];
            $videoName = basename($videoName, ".mp4");
        ?>
            <input type="hidden" value="<?php echo $my_posts->max_num_pages; ?>" id="video_max_page"/>
            <div class="video-feed popular-videofeed">                
                <div class="et_pb_module et_pb_image et_pb_image_0 et_always_center_on_mobile et_pb_has_overlay">

                    <?php if (has_post_thumbnail()) { ?>

                    <span class="et_pb_image_wrap video-thumbnail">
                        <img src="<?php the_field('fp5-splash-image');?>" alt="<?php the_title(); ?>">
                        <span class="et_overlay et_pb_inline_icon" data-icon="E"></span>
                    </span>

                    <?php } ?>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
                <div class="et_pb_text_inner">                  
                    <h3 class="video-title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h3>

                    <!-- <p class="popvideo-counts"><?php echo the_author_meta('display_name', $postData[0]->post_author);?> <span class="count-separator">|</span> <span class="video-votes"><?php echo do_shortcode('[simplevoteme postid='.  get_the_ID().']'); ?></span> <span class="count-separator">|</span> <span class="video-views"><?php echo get_post_meta( get_the_ID(), '_custom_video_view', true);?> Views</span></p> -->
                    
                    <span class="video-author"><?php echo the_author_meta('display_name', $postData[0]->post_author);?></span> <span class="count-separator">|</span> <span class="video-votes"><?php echo do_shortcode('[simplevoteme postid='.  get_the_ID().']');?></span> <span class="count-separator">|</span> <span class="video-views"><?php echo get_post_meta( get_the_ID(), '_custom_video_view', true);?> Views</span>                
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php endif; ?>