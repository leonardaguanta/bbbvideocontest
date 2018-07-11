<?php

$args = array( 'post_type' => 'student_schools',  'post_status' => 'publish','order'=>'ASC' );
$loop = new WP_Query( $args );

if ( $loop->have_posts() && !(is_admin()) ) :
	while ( $loop->have_posts() ) : $loop->the_post(); ?>
                 
    	<div class="et_pb_column et_pb_column_1_2  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough schools-home">								
			<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_0">	
				<div class="et_pb_text_inner">
					<div class="s-logo">
						<a href="<?php echo get_the_permalink(); ?>">
							<?php if( get_field('school_logo') ): ?>							
								<img src="<?php the_field('school_logo'); ?>" alt="<?php echo get_the_title(); ?>">							
							<?php endif; ?>
						</a>
					</div>
					<p><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></p>
				</div>
			</div> <!-- .et_pb_text -->			
		</div>

    <?php endwhile;

endif;
wp_reset_postdata();

?>