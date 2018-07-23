	<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );
$hide = 0;
$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>
<div id="main-content">

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if (et_get_option('divi_integration_single_top') <> '' && et_get_option('divi_integrate_singletop_enable') == 'on') echo(et_get_option('divi_integration_single_top')); ?>
<?php //  print_r( get_post_meta(get_the_ID(), '_simplevotedate', true) ); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
					<?php if ( ( 'off' !== $show_default_title && $is_page_builder_used ) || ! $is_page_builder_used ) { ?>
					<div id="video-player-container">
					<?php
						/* the_content(); */

						echo do_shortcode('[flowplayer id="'.get_the_ID().'"]');
						
						
						wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div>
<?php
	/*echo do_shortcode('[likebtn counter_show="1" white_label="1" icon_dislike_show="0" icon_like_show="0" dislike_enabled="0" like_enabled="0"]');*/
?>
					<div class="left-content student-schools-left individual-video-details">
						<div class="et_post_meta_wrapper">
							<div class="et_pb_bg_layout_light et_pb_text_align_left box-bt-brdr">				
								<span>VIDEO DETAILS</span>
							</div>
						<?php
							if ( ! post_password_required() ) :
								$thumb = '';
								$width = (int) apply_filters( 'et_pb_index_blog_image_width', 820 );

								$height = (int) apply_filters( 'et_pb_index_blog_image_height', 385 );
								$classtext = 'et_featured_image';
								$titletext = get_the_title();
								$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
								$thumb = $thumbnail["thumb"];

								$post_format = et_pb_post_format();
								if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) {
									printf(
										'<div class="et_main_video_container">
											%1$s
										</div>',
										$first_video
									);
								} else if ( ! in_array( $post_format, array( 'gallery', 'link', 'quote' ) ) && 'on' === et_get_option( 'divi_thumbnails', 'on' ) && '' !== $thumb ) {
									// print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
								} else if ( 'gallery' === $post_format ) {
									et_gallery_images();
								}
							?>
							<?php endif; ?>
						
					
					</div> <!-- .et_post_meta_wrapper -->
				<?php  } ?>

					<div class="entry-content video-entry-content">
					<?php //echo do_shortcode('[simplevoteme]');?>
					
					<div id="indVidStats-container" class="clearfix">
						<div class="indVidInfo">
							<h1><?php the_title(); ?></h1>
							<p class="indVidAuthor"><?php the_author(); ?></p>
							<p class="indVidDate"><?php echo get_the_date("F j, Y"); ?></p>
						</div>
						<div class="indVidStats" >
							<p class="indVidViews">
								<?php 
									// echo do_shortcode('[show-video-watch-count postId='.$post->ID.']');
									//echo get_post_meta($post->ID, '_custom_video_view', true);
								?>
							</p>
							<p class="indVidView">
								<?php 
									echo get_post_meta($post->ID, '_custom_video_view', true);
								?>
							</p>
				
							<?php if($hide == 1){ ?>
								<p class="indVidLikes">
									<?php 
										// echo do_shortcode('[simplevoteme_votes postId='.$post->ID.']');
									?>
								</p>
							<?php } ?>
							<div class="indVidVotes">
								<?php echo do_shortcode('[simplevoteme postId='. $post->ID .']'); ?>
							</div>
						</div>
					</div>
					<p class="indVidContent"><?php echo get_post_meta( $post->ID, 'fp5-video-description', TRUE ); ?></p>
					
					</div> <!-- .entry-content -->
					<div class="et_post_meta_wrapper">
					<?php
					if ( et_get_option('divi_468_enable') == 'on' ){
						echo '<div class="et-single-post-ad">';
						if ( et_get_option('divi_468_adsense') <> '' ) echo( et_get_option('divi_468_adsense') );
						else { ?>
							<a href="<?php echo esc_url(et_get_option('divi_468_url')); ?>"><img src="<?php echo esc_attr(et_get_option('divi_468_image')); ?>" alt="468" class="foursixeight" /></a>
				<?php 	}
						echo '</div> <!-- .et-single-post-ad -->';
					}
				?>
					<div id="indiviual-vid-socials">
						<div class="tweet-btn"><a class="twitter-share-button" href="<?php echo $_SERVER['PHP_SELF'];?>">Tweet</a></div>
						<div class="fb-like individual-vid-like" data-href="<?php echo $_SERVER['PHP_SELF'];?>" data-width="70" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>

						<div class="g-plus-btn"><g:plusone></g:plusone></div>
					</div>

					<?php //echo do_shortcode('[show-other-videosToLike]'); ?>
					<?php
						//if ( ( comments_open() || get_comments_number() ) && 'on' == et_get_option( 'divi_show_postcomments', 'on' ) )
							comments_template( '', true );
					?>
					</div> <!-- .et_post_meta_wrapper -->

				</div> <!-- .student-schools-left-->
 
				<div class="right-content student-schools-right videos-right">
					<?php dynamic_sidebar('student-video-sidebar'); ?>
				</div> <!-- .videos-right-->
				</article> <!-- .et_pb_post -->

				<?php if (et_get_option('divi_integration_single_bottom') <> '' && et_get_option('divi_integrate_singlebottom_enable') == 'on') echo(et_get_option('divi_integration_single_bottom')); ?>
			<?php endwhile; ?>
			</div> <!-- #left-area -->

			<?php /*dynamic_sidebar('video-sidebar');*/ ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>
