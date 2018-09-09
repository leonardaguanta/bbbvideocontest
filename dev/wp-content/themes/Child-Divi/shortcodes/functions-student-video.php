<div class="entry-content">
	<?php
	
	
	function studentSchools(){
		global $post;
		$args = array(
			'post_type' => 'student_schools',
			'posts_per_page' => -1,
			'post_status' => 'publish'
			);
		$schools = get_posts($args);
		$sc = '<ul class="student-video-sort">';
		$col = 1;
		foreach ($schools as $key => $school) {
			$sc .= '<li ><input type="checkbox" class="school-sort" name="'. $school->ID .'" value="'. $school->ID .'"/>'. $school->post_title .'</li>';
			$col++;
		}
		$sc .= '</ul>';
		$sc .= '<div class="clear"></div>';
		$sc .= '<button disabled="disabled" class="button button-filter" id="video-filter">Filter</button>';
		return $sc;
	}
	if( ! get_query_var( 'paged' ) || get_query_var( 'paged' ) == 0 || get_query_var( 'paged' ) == 1 ) {
		if( isset( $_SESSION['seed'] ) ) {
			unset( $_SESSION['seed'] );
		}
	}
	$seed = $_SESSION['seed'];

	$args = array(
		'post_type' => 'flowplayer5',
		'post_status' => 'publish',
		//'orderby' => 'rand',
		'posts_per_page' => 6,
		'paged' => 1,
		 'meta_query' => array(
        array(
          'key' => 'video-user-role',
          'value' => 'student',
        )
		));

	$my_posts = new WP_Query($args);
	$see = 1;
	$videoCounter = 1;?>
	<div class="Filters">
		<div class="et_pb_column et_pb_column_2_3  et_pb_column_16 et_pb_css_mix_blend_mode_passthrough">			
			<h4 class="heading-title"><?php _e('Filter'); ?></h4>
			<?php echo studentSchools(); ?>
		</div> <!-- .et_pb_column -->
		<div class="et_pb_column et_pb_column_1_3  et_pb_column_17 et_pb_css_mix_blend_mode_passthrough et-last-child">
			<div class="sort-box">
				<span><?php _e('Sort by'); ?></span>
				<select id="student-video-sort" name="student-video-sort">
					<option><?php _e('Default'); ?></option>
					<option value="likes"><?php _e('Most Votes'); ?></option>
				</select>
			</div>
		</div> <!-- .et_pb_column -->

		<div class="et_pb_column et_pb_column_4_4  et_pb_column_18 et_pb_css_mix_blend_mode_passthrough et-last-child">	
			<?php if ($my_posts->have_posts()): ?>
				<div class="my-posts clearfix videos-page " id="ajax-posts" data-page="<?php echo $my_posts->max_num_pages; ?>">
				<?php while ($my_posts->have_posts()): $my_posts->the_post(); 
					$href = home_url( '/video-frame/?vid_id=' . get_the_ID() );
					$extra_video_info = get_post_meta(get_the_ID());
					$videoName = $extra_video_info['fp5-mp4-video'][0];
					$videoName = basename($videoName, ".mp4");
				?>
					<input type="hidden" value="<?php echo $my_posts->max_num_pages; ?>" class="video_max_page"/>
					<div class="video-feed et_pb_column et_pb_column_1_3  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough" data-video-name="<?php echo $videoName;?>" data-href="<?php the_permalink(); ?>" data-id="<?php get_the_ID(); ?>" data-url="<?php echo $href; ?>" title="<?php
				echo get_the_title();
				?>" data-modal-id="modal-video" data-link="<?php the_permalink(); ?>">                
						<div class="et_pb_module et_pb_image et_pb_image_0 et_always_center_on_mobile et_pb_has_overlay">
							<?php if ( get_field('fp5-splash-image') ) { ?>
								<span class="et_pb_image_wrap video-thumbnail">
									<img src="<?php the_field('fp5-splash-image');?>" alt="<?php echo get_the_title(); ?>">
									<span class="et_overlay et_pb_inline_icon" data-icon="E"></span>
								</span>
							<?php } else { ?>
								<span class="et_pb_image_wrap video-thumbnail">
									<img src="<?php echo home_url(); ?>/wp-content/uploads/2018/09/school-default.png" alt="<?php echo get_the_title(); ?>">
									<span class="et_overlay et_pb_inline_icon" data-icon="E"></span>
								</span>
							<?php } ?>								
						</div>
				
						<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
							<div class="et_pb_text_inner">					
								<h3 class="video-title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title();?></a></h3>
								<span class="video-author"><?php echo the_author_meta('nickname', $postData[0]->post_author);?></span> <span class="video-votes"> 	<?php 
										   $status = get_option( 'voting_status' );
										   if ( $status == 'ON'){
											   echo do_shortcode('[simplevoteme postid='. get_the_ID() .']');
										   }; 
						?></span>
							</div>
						</div> 
					</div>

					<?php if($videoCounter == 6) { ?>
				</div>
				
				<div class="loadmore">See More Videos</div>
				<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_0 home-ad">
					<div class="et_pb_text_inner">					
						<?php echo do_shortcode('[pro_ad_display_adzone id="120"]'); ?>
					</div>
				</div>
					
					<?php } $videoCounter++; $see++; ?>

				<?php endwhile; ?>
			</div>
					<?php endif; ?>
		</div>
	</div>

</div>
