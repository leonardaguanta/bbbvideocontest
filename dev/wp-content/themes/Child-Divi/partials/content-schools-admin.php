<?php
global $current_user;
get_currentuserinfo();
$args = array('post_type' => 'student_schools', 
  'posts_per_page' => -1, 
  'order' => 'DESC');

$mySchools = new WP_Query($args); ?>

<?php if ( $mySchools->have_posts() ) : ?>
    <div class=" et_pb_row et_pb_row_1 school-admin-row with-scroll">
		<div class="et_pb_column et_pb_column_4_4  et_pb_column_2 et_pb_css_mix_blend_mode_passthrough">
            <div class="header-tab">
				</div>
           <!-- <div class="header-tab"><a class="dallas-btn thickbox" href="#TB_inline?height=680&amp;width=650&amp;inlineId=NewSchoolPopup" style="top:5px;">Add School</a></div>-->
			                         

            <?php while ( $mySchools->have_posts() ) : $mySchools->the_post(); ?>
                <div class="et_pb_blurb et_pb_module et_pb_bg_layout_light et_pb_text_align_left school-admin et_pb_blurb_1 et_pb_blurb_position_left">
                    <div class="et_pb_blurb_content">
                        <div class="et_pb_main_blurb_image">
                            <span class="et_pb_image_wrap">
                                <?php if( get_field('school_logo') ) : ?>
                                    <img src="<?php the_field('school_logo'); ?>" alt="<?php the_title(); ?>" class="et-waypoint et_pb_animation_off">
                                <?php else: ?>
                                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2018/09/school-default.png" alt="<?php the_title(); ?>" class="et-waypoint et_pb_animation_off">
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="et_pb_blurb_container">
                            <h4 class="et_pb_module_header"><?php the_title(); ?></h4>
                            <div class="et_pb_blurb_description">
                                <?php
                                    $titlecontent = apply_filters('the_content', get_the_content());
                                    $theCategory = get_the_category( $post->ID );
                                    $titlecontent = wp_trim_words($titlecontent, 40);
                                ?>
                                <p><?php echo $titlecontent; ?></p>
                                <div class="edit-schools">
                                    <?php echo wp_view_post_link('View', get_the_ID()); ?> <span class="edit-divider">|</span> 
									<!--<a class="thickbox edit-school-btn" href="#TB_inline?height=680&amp;width=650&amp;inlineId=NewVideoPopup--><?php //the_ID(); ?><!--">Edit</a> -->
									 <?php edit_post_link('Edit'); ?>
									
									<span class="edit-divider">|</span> <?php echo wp_delete_school_link('Delete',get_the_ID()); ?>
                                </div>

                                <div id="NewVideoPopup<?php the_ID(); ?>" style="display: none;">
                                    <div id="postbox">
                                        <?php echo do_shortcode('[gravityform id=8 update="'.get_the_ID().'"]'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
