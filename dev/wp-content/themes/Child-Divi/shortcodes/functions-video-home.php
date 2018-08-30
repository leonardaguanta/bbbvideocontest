<?php

$args = array( 'post_type' => 'flowplayer5',  'post_status' => 'publish','order'=>'DESC','posts_per_page' => 6,
			        'meta_query' => array(
        array(
          'key' => 'video-user-role',
          'value' => 'student',
        ))
			 );
$loop = new WP_Query( $args );

if ( $loop->have_posts() && !(is_admin()) ) :
	while ( $loop->have_posts() ) : $loop->the_post(); 

$href = home_url( '/video-frame/?vid_id=' . get_the_ID() );
   $extra_video_info = get_post_meta(get_the_ID());
            $videoName = $extra_video_info['fp5-mp4-video'][0];
            $videoName = basename($videoName, ".mp4");
?>
                

		<div class="et_pb_column et_pb_column_1_3  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough videos-home" data-href="<?php the_permalink(); ?>" data-id="<?php get_the_ID(); ?>" data-video-name="<?php echo $videoName;?>" data-url="<?php echo $href; ?>" title="<?php
        echo get_the_title();
?>" data-modal-id="modal-video" data-link="<?php the_permalink(); ?>">				
			<div class="et_pb_module et_pb_image et_pb_image_0 et_always_center_on_mobile et_pb_has_overlay">
			<?php if ( has_post_thumbnail() ) { ?>
				<span class="et_pb_image_wrap video-thumbnail">
					<img src="<?php the_field('fp5-splash-image'); ?>" alt="">
					<span class="et_overlay et_pb_inline_icon" data-icon="E"></span>
				</span>
			<?php } ?>
			</div>
	
			<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
				<div class="et_pb_text_inner">
					<p class="video-title">
						<a href="<?php the_permalink(); ?>">
							<?php echo get_the_title(); ?>
						</a>
					</p>
					<span class="video-author"><?php echo the_author_meta( 'display_name', $postData[0]->post_author ) ?></span><span class="info-bar"> | </span><span class="video-votes">
					<?php echo do_shortcode('[simplevoteme postid='.  get_the_ID().']');?></span>
				</div>
			</div> <!-- .et_pb_text -->
		</div>

		<a class="popvideo" href="<?php the_permalink(); ?>" data-id="<?php get_the_ID(); ?>" data-url="<?php echo $href; ?>" title="<?php  echo get_the_title();?>" data-modal-id="modal-video"></a>

    <?php endwhile;

endif;
wp_reset_postdata();

?>