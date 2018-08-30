<?php
 echo "<link rel='stylesheet' id='simplevotemestyle-css' href='http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/simple-vote-me/css/simplevoteme.css?ver=4.9.6' type='text/css' media='all'>";

    echo '<script type="text/javascript">
        /* <![CDATA[ */
        var gtsimplevotemeajax = {"ajaxurl":"http:\/\/bbbvideocontest.platypustest.info\/dev\/wp-admin\/admin-ajax.php"};
        /* ]]> */
        </script>';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
    echo '<script type="text/javascript" src="http://bbbvideocontest.platypustest.info/dev/wp-content/plugins/simple-vote-me/js/simple-vote-me.js?ver=4.9.6"></script>'; 
get_header(); ?>

    <?php while ( have_posts() ) : the_post(); ?>
        <div id="main-content">
            <article id="post-370" class="post-370 page type-page status-publish hentry">
                <div class="entry-content">
                    <div class="et_pb_section et_pb_section_0 et_section_specialty indVid-section">
                        <div class="et_pb_row">
                            <div class="et_pb_column et_pb_column_2_3  et_pb_column_0 et_pb_specialty_column et_pb_css_mix_blend_mode_passthrough">
                                <div class=" et_pb_row_inner et_pb_row_inner_0" style="padding: 0;">
                                    <div class="et_pb_column et_pb_column_4_4 et_pb_column_inner  et_pb_column_inner_0 et-last-child">
                                        <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left video-entry et_pb_text_0">
                                            <div class="et_pb_text_inner">
                                                <?php echo do_shortcode('[flowplayer id="'.get_the_ID().'" pre-post-ad-video=1 autoplay="true" preload="auto"]'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" et_pb_row_inner et_pb_row_inner_1 videostats-row" style="padding-bottom: 0;">
                                    <div class="et_pb_column et_pb_column_1_3 et_pb_column_inner  et_pb_column_inner_1">
                                        <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left video-details et_pb_text_1">
                                            <div class="et_pb_text_inner">
                                                <h2><?php the_title(); ?></h2>
                                                <p class="indVidAuthor"><?php the_author(); ?></p>
                                                <p class="indVidDate"><?php echo get_the_date("F j, Y"); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="et_pb_column et_pb_column_1_3 et_pb_column_inner  et_pb_column_inner_2 et-last-child">
                                        <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_right video-counters et_pb_text_2">
                                            <div class="et_pb_text_inner clearfix">
                                                </span> <span class="video-votes"><?php echo do_shortcode('[simplevoteme postid='.  get_the_ID().']');?></span> <span class="count-separator"></span> <!--<span class="video-views">--><?php //echo get_post_meta( get_the_ID(), '_custom_video_view', true);?><!-- Views</span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" et_pb_row_inner et_pb_row_inner_2">
                                    <div class="et_pb_column et_pb_column_4_4 et_pb_column_inner  et_pb_column_inner_3 et-last-child">
                                        <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left video-description et_pb_text_3">
                                            <div class="et_pb_text_inner">
                                                <p><?php echo get_post_meta( $post->ID, 'fp5-video-description', TRUE ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="et_pb_column et_pb_column_1_3  et_pb_column_1 et_pb_css_mix_blend_mode_passthrough">
                                <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left video-sidebar et_pb_text_4">
                                    <div class="et_pb_text_inner">
                                        <?php get_template_part( 'partials/content', 'videoranks-scroll' ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>

    <?php endwhile; ?>
<?php get_footer() ?>