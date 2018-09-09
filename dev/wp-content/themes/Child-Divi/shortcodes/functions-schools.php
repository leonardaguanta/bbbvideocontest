<?php

$args = array( 'post_type' => 'student_schools',  'post_status' => 'publish','order'=>'ASC' );
$loop = new WP_Query( $args );

if ( $loop->have_posts() && !(is_admin()) ) :
	while ( $loop->have_posts() ) : $loop->the_post(); ?>
                 
    	<div class="et_pb_column et_pb_column_1_2  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough">								
			<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0 schools-container">	
				<div class="et_pb_text_inner clearfix">
					<div class="school-logo">
						<?php if( get_field('school_logo') ): ?>
							<img src="<?php the_field('school_logo'); ?>" alt="<?php echo get_the_title(); ?>">
						<?php else: ?>
							<img src="<?php echo home_url(); ?>/wp-content/uploads/2018/09/school-default.png" alt="<?php echo get_the_title(); ?>">
						<?php endif; ?>
					</div>
					<div class="school-name">
						<h4><?php echo get_the_title(); ?></h4>
					</div>
				</div>
			</div> <!-- .et_pb_text -->			
			<div class="et_pb_module et_pb_image et_pb_image_1 et_always_center_on_mobile schools-image">							
				<span class="et_pb_image_wrap">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				<?php else: ?>
					<a href="<?php the_permalink(); ?>"><img src="<?php echo home_url(); ?>/wp-content/uploads/2018/09/school-default.png" alt="<?php echo get_the_title(); ?>"></a>
				<?php endif; ?>
				</span>
			</div>				
			<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_1">					
				<div class="et_pb_text_inner">
					<?php the_excerpt(); ?>
				</div>
			</div> <!-- .et_pb_text -->
			
			<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_2">										
				<div class="et_pb_text_inner">
					<p><strong><a href="<?php echo get_post_permalink(); ?>" class="custom-link">Show more</a></strong></p>
				</div>
			</div> <!-- .et_pb_text -->
		</div>

    <?php endwhile;

endif;
wp_reset_postdata();

?>