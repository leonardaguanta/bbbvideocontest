<div style="<?php echo esc_attr( self::trim_implode( $style ) ); ?>" class="<?php echo esc_attr( self::trim_implode( $classes ) ); ?>" <?php echo  fp5_deprecated_flowplayer_data( self::trim_implode( $data_config ) ); ?>>

	<?php if ( $asf_js ) : ?>
		<!-- Flowplayer Ads -->
		<script>
			flowplayer_ima.conf({
				adsense: {
					request: {
						adtest: "<?php echo esc_attr( $asf_test ); ?>"
					}
				},
				ads: [{
					time: "<?php echo esc_attr( $ads_time ); ?>",
					request: {
						ad_type: "<?php echo esc_attr( $ad_type ); ?>",
						description_url: "<?php echo esc_html( $description_url ); ?>"
					}
				}]
			});
		</script>
	<?php endif; ?>

	<?php do_action( 'fp5_video_top', $id ); ?>

	<!--<video <?php echo self::process_data_config( $video_data_config ); ?><?php echo self::trim_implode( $attributes ); ?>>
		<?php echo self::trim_implode( $source ); ?>
		<?php echo esc_textarea( $track ); ?>
	</video>-->
	<video preload="metadata" class="fp-engine" src="<?php print $pre_ad;?>"></video>

	<div class="fp-playlist">
		<a class="is-advert" href="<?php print $pre_ad;?>"></a>
		<a href="<?php print self::get_custom_fields( $custom_fields, 'fp5-mp4-video', $atts, 'mp4' );?>"></a>
	</div>

	<?php do_action( 'fp5_video_bottom', $id ); ?>

</div>
<!-- Flowplayer Single Config -->
<script>
jQuery( document ).ready( function( $ ) {
	$(".flowplayer-video-<?php echo esc_attr( $id ); ?>").flowplayer({
		<?php if ( 0 < strlen( $key ) ) { ?>
		brand: {
			<?php echo self::process_js_config( $js_brand_config ); ?>
		},
		<?php } ?>
		<?php do_action( 'fp5_video_config', $id ); ?>
		<?php echo self::process_js_config( $js_config ); ?>
	});
	$(".flowplayer-video-<?php echo esc_attr( $id ); ?>").bind("finish", function(e, api) {
		if (api.video.index == 0) {
			$.post("<?php echo admin_url('admin-ajax.php'); ?>",{
                            action : 'fp5_adzone_click_stat',
                            banner_id : '<?php echo $pre_banner_id; ?>',
                            ref_url : '<?php echo esc_url(home_url() . $_SERVER['REQUEST_URI']);?>',
                         });
                        api.disable(false);

		}
        });
	$(".flowplayer-video-<?php echo esc_attr( $id ); ?>").bind("resume", function(e, api) {
		if (api.video.index == 0) {
			api.disable(true);
		} else if (api.video.index == 1) {
			api.disable(false);
		}
        });
});
</script>
