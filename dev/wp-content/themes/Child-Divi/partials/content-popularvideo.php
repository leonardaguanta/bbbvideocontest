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
               <div class="video-feed" data-video-name="<?php echo $videoName;?>" data-href="<?php the_permalink(); ?>" data-id="<?php get_the_ID(); ?>" data-url="<?php echo $href; ?>" title="<?php
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

 <!-- .et_pb_text -->
              </div>

              <?php
              if($videoCounter == 6) { ?>
              </div>
              <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_0 home-ad">
                <div class="et_pb_text_inner">                  
                  <?php echo do_shortcode('[pro_ad_display_adzone id="120"]'); ?>
                </div>
              </div>
              <?php } $videoCounter++; ?>
          </div>
<div class="card-footer">
                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
                  <div class="et_pb_text_inner">                  
                    <h3 class="video-title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h3>
                    <span class="video-author"><?php echo the_author_meta('display_name', $postData[0]->post_author);?></span> | <span class="video-votes">     <?php echo do_shortcode('[simplevoteme postid='.  get_the_ID().']');?></span>
                  </div>
                </div>
</div>
            <?php endwhile; ?>


        <?php endif; ?>