<?php get_header(); ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <div id="main-content">
            <article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> page type-page status-draft hentry">
                <div class="entry-content">
                    <div class="et_pb_section indSchool-section et_pb_section_4 et_section_regular">
                        <div class=" et_pb_row et_pb_row_8 et_pb_gutters2">
                            <div class="et_pb_column et_pb_column_2_3  et_pb_column_12 et_pb_css_mix_blend_mode_passthrough">
                                <div class="et_pb_module et_pb_image et_pb_image_2 et_always_center_on_mobile">
                                    <span class="et_pb_image_wrap">
                                        <?php if( has_post_thumbnail() ) : ?>
                                            <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                                        <?php else: ?>
                                            <img src="<?php echo home_url(); ?>/wp-content/uploads/2018/09/school-default.png" alt="<?php the_title(); ?>">
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_9">
                                    <div class="et_pb_text_inner">
                                        <h1><?php the_title(); ?></h1>
                                        <p class="schoolAuthor"><?php the_author(); ?> | <?php the_date('M j, Y'); ?></p>
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="et_pb_column et_pb_column_1_3  et_pb_column_13 et_pb_css_mix_blend_mode_passthrough et-last-child">
                                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left contact-info et_pb_text_10">
                                    <div class="et_pb_text_inner">
                                        <h3>BBB Serving North Central Texas | Dallas</h3>
                                        <p class="contact-address">1601 Elm Street, Suite 1600, Dallas, TX 75201.</p>
                                        <p>Email: <a href="mailto:marketing@dallas.bbb.org" class="custom-link">marketing@dallas.bbb.org</a>
                                            <br>Phone: <a href="tel:1.214.220.2000" class="custom-link">1 (214) 220-2000</a>
                                            <br>9:00 AM – 3:00 PM Monday – Friday</p>
                                    </div>
                                </div>
                                <div class="et_pb_text et_pb_module et_pb_bg_layout_dark et_pb_text_align_center participate-sidebar et_pb_text_11">
                                    <div class="et_pb_text_inner">
                                        <h2>Does your school want to <span class="participate">participate?</span></h2>
                                    </div>
                                </div>
                                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_12">
                                    <div class="et_pb_text_inner">
                                        <p><a href="/dev/schools/" class="custom-link">View this year’s participants</a></p>
                                    </div>
                                </div>
                                <ul class="et_pb_social_media_follow et_pb_module et_pb_bg_layout_dark contact-social et_pb_social_media_follow_0 clearfix et_pb_text_align_center">
                                    <li class="et_pb_social_icon et_pb_social_network_link et-social-facebook et_pb_social_media_follow_network_0">
                                        <a href="<?php echo esc_url( et_get_option( 'divi_facebook_url', '#' ) ); ?>" class="icon et_pb_with_border" title="Facebook" target="_blank"><span class="et_pb_social_media_follow_network_name">Facebook</span></a>
                                    </li>
                                    <li class="et_pb_social_icon et_pb_social_network_link et-social-instagram et_pb_social_media_follow_network_1">
                                        <a href="<?php echo esc_url( et_get_option( 'divi_rss_url', '#' ) ); ?>" class="icon et_pb_with_border" title="Instagram" target="_blank"><span class="et_pb_social_media_follow_network_name">Instagram</span></a>
                                    </li>
                                    <li class="et_pb_social_icon et_pb_social_network_link et-social-linkedin et_pb_social_media_follow_network_2">
                                        <a href="<?php echo esc_url( et_get_option( 'divi_google_url', '#' ) ); ?>" class="icon et_pb_with_border" title="LinkedIn" target="_blank"><span class="et_pb_social_media_follow_network_name">LinkedIn</span></a>
                                    </li>
                                    <li class="et_pb_social_icon et_pb_social_network_link et-social-twitter et_pb_social_media_follow_network_3">
                                        <a href="<?php echo esc_url( et_get_option( 'divi_twitter_url', '#' ) ); ?>" class="icon et_pb_with_border" title="Twitter" target="_blank"><span class="et_pb_social_media_follow_network_name">Twitter</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    <?php endwhile; ?>
<?php get_footer(); ?>