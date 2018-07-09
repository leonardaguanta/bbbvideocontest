<?php

 add_shortcode( 'schools', 'display_schools' );

    function display_schools(){

        $args = array( 'post_type' => 'student_schools',  'post_status' => 'publish','order'=>'ASC' );
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() && !(is_admin()) ) :
        while ( $loop->have_posts() ) : $loop->the_post(); ?>
         
         
         <div class="et_pb_column et_pb_column_1_2  et_pb_column_0 et_pb_css_mix_blend_mode_passthrough">
				
				
	<div class="et_pb_module et_pb_image et_pb_image_0 et_always_center_on_mobile">				
			<span class="et_pb_image_wrap">
            	<?php if( get_field('school_logo') ): ?>
            <img src="<?php the_field('school_logo'); ?>" alt="">
                <?php endif; ?>
            </span>
			</div><div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_0">
				
				
				<div class="et_pb_text_inner">
					<h2><?php echo get_the_title(); ?></h2>
				</div>
			</div> <!-- .et_pb_text --><div class="et_pb_module et_pb_image et_pb_image_1 et_always_center_on_mobile">
				
				
				<span class="et_pb_image_wrap">
                 <?php if ( has_post_thumbnail() ) { ?>

                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

                <?php } ?>
               </span>
			</div><div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_1">
				
				
				<div class="et_pb_text_inner">
					<p><?php echo the_excerpt(); ?></p>
				</div>
			</div> <!-- .et_pb_text --><div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_2">
				
				
				<div class="et_pb_text_inner">
					<p><strong><a href="<?php echo get_post_permalink(); ?>">Show more</a></strong></p>
				</div>
			</div> <!-- .et_pb_text -->
			</div>

        <?php endwhile;

    endif;
    wp_reset_postdata();

    }



?>