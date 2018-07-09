<?php
/**
 * Flowplayer 5 for WordPress
 *
 * @package   Flowplayer 5 for WordPress
 * @author    Ulrich Pogson <ulrich@pogson.ch>
 * @license   GPL-2.0+
 * @link      http://flowplayer.org/
 * @copyright 2013 Flowplayer Ltd
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Flowplayer Output Class
 *
 * @package Flowplayer5_Shortcode
 * @author  Ulrich Pogson <ulrich@pogson.ch>
 *
 * @since 1.3.0
 */
class Flowplayer5_Output {
 
	public function adzone_id($type){
		switch(true){
			case is_page(47) || is_page(2796):
				if($type === 'pre'){
					return 1890;
				} else {
					return 1891;
				}
				break;
			case is_front_page():
				if($type === 'pre'){
					return 1822;
				} else {
					return 1823;
				}
				break;
			default:
				if($type === 'pre'){
				return 1892;
				} else {
				return 1893;
				}
				break;
		}
	}
	/**
	 * Create Flowplayer Video HTML Output
	 *
	 * Retrieves a media files and settings to display a video.
	 *
	 * @since    1.3.0
	 *
	 * @param    array $atts Shortcode attributes
	 */
	public function video_output( $atts ) {
  		global $pro_ads_codex;
                 


		//print "WORKING???<br><br>";
		//$adzone_data = $pro_ads_codex->wpproads_load_adzone_data( "1822" );
		//print_r($adzone_data);
		//print "<BR>DONE<BR>";
		//print_r($pro_ads_codex->wpproads_load_adzone_banners( $adzone_data ));
		//$pro_ads_statistics->save_impression( "1827", "1822", "http://www.shane.com" );

        // $adzone_data = $pro_ads_codex->wpproads_load_adzone_data( "1228" );
        // $ad = array_rand($adzone_data['linked_banner_ids'],1);
        // echo '<pre style="background:#fff;">';
        // print_r( $adzone_data );

		if ( isset( $atts['playlist'] ) ) {
                        // var_dump('playlist');
			$playlist_id = $atts['playlist'];
			$playlist_options = get_option( 'playlist_' . absint( $playlist_id ) );
			// Check if old id is being used in the shortcode
			if ( ! $playlist_options && function_exists( 'wp_get_split_term' ) ) {
				$new_term_id = wp_get_split_term( absint( $playlist_id ), 'playlist' );
				$playlist_options = get_option( 'playlist_' . absint( $new_term_id ) );
				if ( $playlist_options ) {
					$playlist_id = $new_term_id;
				}
			}
			if ( ! $playlist_options ) {
				return;
			}
			ob_start();
			require( 'views/display-playlist.php' );
			$html = ob_get_clean();
			return $html;
		} elseif( isset( $atts['pre-post-ad-video'] ) ) {
                        //var_dump('pre post ad');
                        $pre_adzone_id = $this->adzone_id('pre');
                        $post_azone_id = $this->adzone_id();
			$adzone_data = $pro_ads_codex->wpproads_load_adzone_data( $pre_adzone_id );
                        $ad = array_rand($adzone_data['linked_banner_ids'],1);
                        $pre_banner_id = $adzone_data['linked_banner_ids'][$ad];
                        //var_dump($adzone_data);
			if (!$pre_banner_id) {
				error_log('No pre_banner_id found');
				return self::single_video_output( $atts );
			}
			$ad_post = get_post_custom($pre_banner_id);
                        preg_match('/\d+/',$ad_post['_banner_html'][0],$matches); 
                        $post_custom_id = intval($matches[0]); 
			$custom_fields  = get_post_custom($post_custom_id);
			$pre_ad = self::get_custom_fields( $custom_fields, 'fp5-mp4-video', $atts, 'mp4' );
			$adzone_data = $pro_ads_codex->wpproads_load_adzone_data( $post_adzone_id );
                        $ad = array_rand($adzone_data['linked_banner_ids'],1);
                        $post_banner_id = $adzone_data['linked_banner_ids'][$ad];
                          
			if (!$post_banner_id) {
				error_log('No post_banner_id found');
                                // var_dump($pre_banner_id);
				return self::single_video_output( $atts, $pre_ad, $pre_banner_id );
			}
                        $ad_post = get_post_custom($post_banner_id);
                        preg_match('/\d+/',$ad_post['_banner_html'][0],$matches); 
                        $post_custom_id = intval($matches[0]); 
			$custom_fields  = get_post_custom($post_custom_id);
			$post_ad = self::get_custom_fields( $custom_fields, 'fp5-mp4-video', $atts, 'mp4' );
                        // var_dump($pre_ad);
                        // var_dump($pre_banner_id);
			return self::single_video_output( $atts, $pre_ad, $pre_banner_id, $post_ad, $post_banner_id);
		} elseif( isset( $atts['pre-ad-video'] ) ) {
                        //var_dump('pre ad video');
			$adzone_data = $pro_ads_codex->wpproads_load_adzone_data( $pre_adzone_id );
			$ad = array_rand($adzone_data['linked_banner_ids'],1);
			$pre_banner_id = $adzone_data['linked_banner_ids'][$ad];
			$ad_post = get_post_custom($pre_banner_id);
                        $custom_fields  = get_post_custom( $ad_post['_banner_html'][0] );
                        $pre_ad = self::get_custom_fields( $custom_fields, 'fp5-mp4-video', $atts, 'mp4' );
			return self::single_video_output( $atts, $pre_ad, $pre_banner_id);
		} elseif( isset( $atts['post-ad-video'] ) ) {
                        //var_dump('post ad video');
			$adzone_data = $pro_ads_codex->wpproads_load_adzone_data( $post_adzone_id );
                        $ad = array_rand($adzone_data['linked_banner_ids'],1);
                        $post_banner_id = $adzone_data['linked_banner_ids'][$ad];
                        $ad_post = get_post_custom($post_banner_id);
                        $custom_fields  = get_post_custom( $ad_post['_banner_html'][0] );
                        $post_ad = self::get_custom_fields( $custom_fields, 'fp5-mp4-video', $atts, 'mp4' );
			return self::single_video_output( $atts, NULL, NULL, $post_ad, $post_banner_id );
		} else {
                       // var_dump('else video');
			return self::single_video_output( $atts );
		}
	}

	/**
	 * Create Flowplayer Video HTML Output
	 *
	 * Retrieves a media files and settings to display a video.
	 *
	 * @since    1.3.0
	 *
	 * @param    array $atts Shortcode attributes
	 */
	private static function single_video_output( $atts, $pre_ad=NULL, $pre_banner_id=NULL, $post_ad=NULL, $post_banner_id=NULL ) {

		global $pro_ads_statistics;
          
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'banners',
		);
		$adzone_array = array();
		foreach(get_posts($args) as $post){
			if(in_array(FP5_WPPAS_ID,(array) get_post_meta($post->ID,'_linked_adzones',true))){
				$player_sc = get_post_meta($post->ID, '_banner_html', true);
				$player_id = preg_replace("/\[|\]|[a-zA-Z]|\s|=|\"|\'/",'',$player_sc);
				$adzone_array[] = array(
					'banner_id' => $post->ID, 
					'url' => get_post_meta($player_id,'fp5-mp4-video', true)
				);
			}
		}
		

		$rand_key = array_rand($adzone_array,1);
		$pre_ad = $adzone_array[$rand_key]['url'];
		$current_url = home_url().$_SERVER['REQUEST_URI'];
		$pre_banner_id = intval($adzone_array[$rand_key]['banner_id']);
		$pro_ads_statistics->save_impression($pre_banner_id,intval(FP5_WPPAS_ID),$current_url);
		
		/**
		 * flowplayer shortcode
		 *
		 * @example [flowplayer id="123" splash="trailer_1080p.jpg" webm="trailer_1080p.webm" mp4="trailer_1080p.mp4" ogg="trailer_1080p.ogv" width="1920" height="1080" skin="functional" autoplay="true" loop="true" fixed="false" subtitles="bunny-en.vtt" fixed_controls="true" coloring="default" preload="auto"]
		 */

		$shortcode_defaults = array(
			'id'              => '',
			'mp4'             => '',
			'webm'            => '',
			'ogg'             => '',
			'flash'           => '',
			'hls'             => '',
			'loop'            => '',
			'autoplay'        => '',
			'preload'         => '',
			'poster'          => '',
			'skin'            => '',
			'splash'          => '',
			'subtitles'       => '',
			'max_width'       => '',
			'width'           => '',
			'height'          => '',
			'ratio'           => '',
			'fixed'           => '',
			'rtmp'            => '',
			'quality'         => '',
			'qualities'       => '',
			'coloring'        => '',
			'fixed_controls'  => '',
			'background'      => '',
			'aside_time'      => '',
			'show_title'      => '',
			'no_hover'        => '',
			'no_mute'         => '',
			'no_volume'       => '',
			'no_embed'        => '',
			'live'            => '',
			'play_button'     => '',
			'ads_time'        => '',
			'ad_type'         => '',
			'description_url' => '',

		);

		$atts = array_filter( shortcode_atts(
			$shortcode_defaults,
			$atts,
			'flowplayer'
		) );

		if ( ! empty( $atts['id'] ) ) {

			$id = $atts['id'];

			// get the meta from the post type
			$custom_fields  = get_post_custom( $id );
			$title          = get_the_title( $id );
		} else {
			$id = substr( md5( serialize( $atts ) ), 0, 5 );
			$custom_fields = array();
		}

		$loop           = self::get_custom_fields( $custom_fields, 'fp5-loop', $atts, 'loop' );
		$autoplay       = self::get_custom_fields( $custom_fields, 'fp5-autoplay', $atts, 'autoplay' );
		$preload        = self::get_custom_fields( $custom_fields, 'fp5-preload', $atts, 'preload' );
		$poster         = self::get_custom_fields( $custom_fields, 'fp5-poster', $atts, 'poster' );
		$skin           = self::get_custom_fields( $custom_fields, 'fp5-select-skin', $atts, 'skin', 'minimalist' );

		if( is_page('approved-videos') ){
			$splash  = wp_get_attachment_url( get_post_thumbnail_id($id), 'admin-video-thumb' );
		}else{
			$splash = self::get_custom_fields( $custom_fields, 'fp5-splash-image', $atts, 'splash' );
		}

		$formats        = array(
			'application/x-mpegurl' => self::get_custom_fields( $custom_fields, 'fp5-hls-video', $atts, 'hls' ),
			'video/webm'            => self::get_custom_fields( $custom_fields, 'fp5-webm-video', $atts, 'webm' ),
			'video/mp4'             => self::get_custom_fields( $custom_fields, 'fp5-mp4-video', $atts, 'mp4' ),
			'video/ogg'             => self::get_custom_fields( $custom_fields, 'fp5-ogg-video', $atts, 'ogg' ),
			'video/flash'           => self::get_custom_fields( $custom_fields, 'fp5-flash-video', $atts, 'flash' ),
		);
		$subtitles       = self::get_custom_fields( $custom_fields, 'fp5-vtt-subtitles', $atts, 'subtitles' );
		$max_width       = self::get_custom_fields( $custom_fields, 'fp5-max-width', $atts, 'max_width' );
		$width           = self::get_custom_fields( $custom_fields, 'fp5-width', $atts, 'width' );
		$height          = self::get_custom_fields( $custom_fields, 'fp5-height', $atts, 'height' );
		$ratio           = self::get_custom_fields( $custom_fields, 'fp5-aspect-ratio', $atts, 'ratio' );
		$fixed           = self::get_custom_fields( $custom_fields, 'fp5-fixed-width', $atts, 'fixed' );
		$data_rtmp       = self::get_custom_fields( $custom_fields, 'fp5-data-rtmp', $atts, 'rtmp' );
		$quality         = self::get_custom_fields( $custom_fields, 'fp5-default-quality', $atts, 'quality' );
		$qualities       = self::get_custom_fields( $custom_fields, 'fp5-qualities', $atts, 'qualities' );
		$coloring        = self::get_custom_fields( $custom_fields, 'fp5-coloring', $atts, 'coloring' );
		$fixed_controls  = self::get_custom_fields( $custom_fields, 'fp5-fixed-controls', $atts, 'fixed_controls' );
		$background      = self::get_custom_fields( $custom_fields, 'fp5-no-background', $atts, 'background' );
		$aside_time      = self::get_custom_fields( $custom_fields, 'fp5-aside-time', $atts, 'aside_time' );
		$show_title      = self::get_custom_fields( $custom_fields, 'fp5-show-title', $atts, 'show_title' );
		$no_hover        = self::get_custom_fields( $custom_fields, 'fp5-no-hover', $atts, 'no_hover' );
		$no_mute         = self::get_custom_fields( $custom_fields, 'fp5-no-mute', $atts, 'no_mute' );
		$no_volume       = self::get_custom_fields( $custom_fields, 'fp5-no-volume', $atts, 'no_volume' );
		$no_embed        = self::get_custom_fields( $custom_fields, 'fp5-no-embed', $atts, 'no_embed' );
		$live            = self::get_custom_fields( $custom_fields, 'fp5-live', $atts, 'live' );
		$play_button     = self::get_custom_fields( $custom_fields, 'fp5-play-button', $atts, 'play_button' );
		$ads_time        = self::get_custom_fields( $custom_fields, 'fp5-ads-time', $atts, 'ads_time' );
		$ad_type         = self::get_custom_fields( $custom_fields, 'fp5-ad-type', $atts, 'ad_type' );
		$description_url = self::get_custom_fields( $custom_fields, 'fp5-description-url', $atts, 'description_url', get_permalink() );


		// Global settings

		// set the options for the shortcode - pulled from the register-settings.php
		$options       = fp5_get_settings();
		$key           = ( isset( $options['key'] ) ) ? $options['key'] : '';
		$ga_account_id = ( isset( $options['ga_account_id'] ) ) ? $options['ga_account_id'] : '';
		$logo          = ( isset( $options['logo'] ) ) ? $options['logo'] : '';
		$logo_origin   = ( isset( $options['logo_origin'] ) ) ? $options['logo_origin'] : '';
		$brand_text    = ( isset( $options['brand_text'] ) ) ? $options['brand_text'] : '';
		$text_origin   = ( isset( $options['text_origin'] ) ) ? $options['text_origin'] : '';
		$asf_test      = ( isset( $options['asf_test'] ) ) ? $options['asf_test'] : '';
		$asf_js        = ( isset( $options['asf_js'] ) ) ? $options['asf_js'] : '';
		$fp_version    = ( isset( $options['fp_version'] ) ) ? $options['fp_version'] : '';

		// Shortcode processing
		$ratio = ( ( $width != 0 && $height != 0 ) ? intval( $height ) / intval( $width ) : '' );
		if ( $fixed == 'true' && $width != '' && $height != '' ) {
			$size = 'width:' . $width . 'px; height:' . $height . 'px; ';
		} elseif ( $max_width != 0 ) {
			$size = 'max-width:' . $max_width . 'px; ';
		} else {
			$size = '';
		}
		$style = array(
			$size,
			'background-image: url(' . esc_url( $splash ) . ');',
		);

		// Prepare div data config
		$data_config = array();
		if ( has_filter( 'fp5_filter_flowplayer_data' ) ) {
			$data_config = array(
				( 0 < strlen( $key ) ? 'data-key="' . esc_attr( $key ) . '"' : '' ),
				( 0 < strlen( $key ) && 0 < strlen( $logo ) ? 'data-logo="' . esc_url( $logo ) . '"' : '' ),
				( 0 < strlen( $ga_account_id ) ? 'data-analytics="' . esc_attr( $ga_account_id ) . '"' : '' ),
				( $ratio != 0 ? 'data-ratio="' . esc_attr( $ratio ) . '"' : '' ),
				( ! empty ( $data_rtmp ) ? 'data-rtmp="' . esc_attr( $data_rtmp ) . '"' : '' ),
				( ! empty ( $quality ) ? 'data-default-quality="' . esc_attr( $quality ) . '"' : '' ),
				( ! empty ( $qualities ) ? 'data-qualities="' . esc_attr( $qualities ) . '"' : '' ),
			);
		}

		// Prepare video tag data config
		$video_data_config = array();
		if ( ! empty ( $title ) && ! empty ( $show_title ) ) {
			$video_data_config['title'] = esc_attr( $title );
		}
		$video_data_config = apply_filters( 'fp5_video_data_config', $video_data_config, $id );

		// Prepare JS config
		$js_config = array();
		if ( 0 == $width && 0 == $height ) {
			$js_config['adaptiveRatio'] = 'true';
		}
		if ( 'true' == $live ) {
			$js_config['live'] = esc_attr( $live );
		}
		if ( 'true' == $no_embed ) {
			$js_config['embed'] = 'false';
		}
		if ( 0 < strlen( $key ) ) {
			$js_config['key'] = esc_attr( $key );
		}
		if ( 0 < strlen( $key ) && 0 < strlen( $logo ) ) {
			$js_config['logo'] = esc_url( $logo );
		}
		if ( 0 < strlen( $ga_account_id ) ) {
			$js_config['analytics'] = esc_attr( $ga_account_id );
		}
		if ( $ratio != 0 ) {
			$js_config['ratio'] = esc_attr( $ratio );
		}
		if ( ! empty ( $data_rtmp ) ) {
			$js_config['rtmp'] = esc_attr( $data_rtmp );
		}
		if ( ! empty ( $quality ) ) {
			$js_config['defaultQuality'] = esc_attr( $quality );
		}
		if ( ! empty ( $qualities ) ) {
			$js_config['qualities'] = esc_attr( $qualities );
		}
		$js_config = apply_filters( 'fp5_js_config', $js_config, $id );

		$js_brand_config = array();
		if ( ! empty ( $brand_text ) ) {
			$js_brand_config['text'] = esc_attr( $brand_text );
		}
		if ( 'true' == $text_origin ) {
			$js_brand_config['showOnOrigin'] = esc_attr( $text_origin );
		}
		$js_brand_config = apply_filters( 'fp5_js_brand_config', $js_brand_config, $id );

		$classes = array(
			'flowplayer-video flowplayer-video-' . $id,
			$skin,
			( ! empty ( $splash ) ? 'is-splash' : '' ),
			( ! empty ( $logo_origin ) ? 'commercial' : '' ),
			( isset( $id ) ? 'flowplayer-' . $id : '' ),
			( 'default' != $coloring ? $coloring : '' ),
			( $fixed_controls ? 'fixed-controls' : '' ),
			( $background ? 'no-background' : '' ),
			( $aside_time ? 'aside-time' : '' ),
			( $no_hover ? 'no-hover' : '' ),
			( $no_mute ? 'no-mute' : '' ),
			( $no_volume ? 'no-volume' : '' ),
			( $play_button ? 'play-button' : '' ),
		);

		$attributes = array(
			( ( $autoplay == 'true' ) ? 'autoplay' : '' ),
			( ( $loop == 'true' ) ? 'loop' : '' ),
			( ! empty ( $preload ) ? 'preload="' . esc_attr( $preload ) . '"' : '' ),
			( ( $poster == 'true' ) ? 'poster' : '' ),
		);

		$asf_test = ( ! empty( $asf_test ) ? 'on' : 'off' );
		$ads_time = ( isset( $ads_time ) ? $ads_time : '' );
		$ads_time = ( 0 == $ads_time ? 0.01 : $ads_time );
		$ad_type  = ( ! empty( $ad_type ) ? esc_attr( $ad_type ) : '' );

		$source = array();
		foreach ( $formats as $format => $src ) {
			if ( ! empty( $src ) ) {
				$source[ $format ] = '<source type="' . esc_attr( $format ) . '" src="' . esc_attr( apply_filters( 'fp5_filter_video_src', $src, $format, $id ) ) . '">';
			}
		}

		if ( '' != $subtitles ) {
			$track = '<track src="' . esc_url( $subtitles ) . '"/>';
		} else {
			$track = '';
		}

		// Check if a video has been added before output
		if ( $formats['video/webm'] || $formats['video/mp4'] || $formats['video/ogg'] || $formats['video/flash'] || $formats['application/x-mpegurl'] ) {
			if($pre_ad && $post_ad) {

                                // var_dump('pre & pas');
				ob_start();
                                require( 'views/display-pre-post-ad-video.php' );
                                $html = ob_get_clean();
                                return $html;
			} elseif($pre_ad) {
                                // var_dump('pre');
				ob_start();
                                require( 'views/display-pre-ad-video.php' );
                                $html = ob_get_clean();
                                return $html;
			} elseif($post_ad) {
                                // var_dump('post');                       
				ob_start();
                                require( 'views/display-post-ad-video.php' );
                                $html = ob_get_clean();
                                return $html;
			} else {
                                // var_dump('else');
				ob_start();
				require( 'views/display-single-video.php' );
				$html = ob_get_clean();
				return $html;
			}
		}

	}

	/**
	 * Check if option exists
	 *
	 * @since    1.9.0
	 */
	private static function get_custom_fields( $custom_fields, $key, $override, $override_key, $else = '' ) {
		if ( ! empty( $override[ $override_key ] ) ) {
			return $override[ $override_key ];
		} elseif ( ! empty( $custom_fields[ $key ][0] ) ) {
			return $custom_fields[ $key ][0];
		} else {
			return $else;
		}
	}

	private static function trim_implode( $values ) {
		return trim( implode( ' ', array_filter( $values ) ) );
	}

	private static function process_data_config( $values ) {
		if ( empty( $values ) ) {
			return;
		}
		foreach ( $values as $key => $value ) {
			$output[] = 'data-' . esc_html( $key ) . '="' . esc_html( $value ) . '" ';
		}
		return implode( ' ', $output );
	}

	private static function process_js_config( $values ) {
		if ( empty( $values ) ) {
			return;
		}
		foreach ( $values as $key => $value ) {
			if ( 'embed' == $key ) {
				$output[] = esc_html( $key ) . ':' . esc_html( $value ) . ',';
			} else {
				$output[] = esc_html( $key ) . ':"' . esc_html( $value ) . '",';
			}
		}
		return rtrim( implode( ' ', $output ), ',' );
	}

}
