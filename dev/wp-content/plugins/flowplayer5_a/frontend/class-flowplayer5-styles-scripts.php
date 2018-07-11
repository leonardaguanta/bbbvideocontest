<?php
/**
 * Flowplayer 5 for WordPress
 *
 * @package   Flowplayer5_Frontend
 * @author    Ulrich Pogson <ulrich@pogson.ch>
 * @license   GPL-2.0+
 * @link      https://flowplayer.org/
 * @copyright 2013 Flowplayer Ltd
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Initial Flowplayer Frontend class
 *
 * @package Flowplayer5_Frontend
 * @author  Ulrich Pogson <ulrich@pogson.ch>
 *
 * @since 2.0.0
 */
class Flowplayer5_Styles_Scripts {

	public function run() {
		$plugin               = Flowplayer5::get_instance();
		$this->plugin_version = $plugin->get_plugin_version();
		$this->player_version = $plugin->get_player_version();
		$settings             = fp5_get_settings();

		$flowplayer_shortcode = new Flowplayer5_Shortcode();
		$shortcodes = $flowplayer_shortcode->video_shortcode_atts();

		if ( ! is_array( $shortcodes ) || ! count( $shortcodes ) ) {
			return;
		}

		// In archives shortcodes end up in nested arrays
		if( ! array_key_exists( 'id' , $shortcodes[0] ) && ! array_key_exists( 'playlist' , $shortcodes[0] ) ) {
			$shortcodes = call_user_func_array( 'array_merge' , $shortcodes );
		}

		$atts = array();
		foreach ( $shortcodes as $shortcode ) {
			if ( isset( $shortcode['playlist'] ) ) {
				$playlist_id = Flowplayer5_Playlist::wp_get_split_term( $shortcode['playlist'] );
				$atts = Flowplayer5_Playlist::get_videos_by_id( $playlist_id );
			} else {
				$atts[] = Flowplayer5_Parse::get_shortcode_attr( $shortcode );
			}
		}

		$config = $this->get_config( $atts, $settings, $flowplayer_shortcode );

		if ( $config['has_shortcode'] ) {
			$this->register_styles( $config );
			$this->enqueue_styles( $config );
			$this->register_scripts( $config );
			$this->enqueue_scripts( $config );
		}
	}

	public function get_config( $atts, $settings, $flowplayer_shortcode ) {
		$first_video = reset( $atts );

		$config = array(
			'plugin_version'   => $this->plugin_version,
			'player_version'   => $this->player_version,
			'cdn'              => ! empty ( $settings['cdn_option'] ) ? $settings['cdn_option'] : false,
			'key'              => ! empty ( $settings['key'] ) ? $settings['key'] : false,
			'fp_dir'           => ! empty ( $settings['directory'] ) ? $settings['directory'] : false,
			'asf_js'           => ! empty ( $settings['asf_js'] ) ? $settings['asf_js'] : false,
			'vast_js'          => ! empty ( $settings['vast_js'] ) ? $settings['vast_js'] : false,
			'suffix'           => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min',
			'has_shortcode'    => $flowplayer_shortcode->has_flowplayer_shortcode(),
			'is_hls'           => $flowplayer_shortcode->get_attr_value( 'application/x-mpegurl', $flowplayer_shortcode->get_attr_value( 'formats', $atts ) ) && $flowplayer_shortcode->get_attr_value( 'hls_plugin', $atts ),
			'is_lightbox'      => $flowplayer_shortcode->get_attr_value( 'lightbox', $atts ) && ! isset( $first_video['playlist'] ),
			'qualities'        => $flowplayer_shortcode->get_video_qualities( $atts ),
			'qs_dir'           => 'fp7' === $settings['fp_version'] ? 'vod-quality-selector/flowplayer.vod-' : 'quality-selector/flowplayer.',
			'fp_6'             => 'fp6' === $settings['fp_version'] ? '-v6' : '',
			'fp_7'             => 'fp7' === $settings['fp_version'] ? '-v7' : '',
			'fp_directory'     => trailingslashit( $this->get_flowplayer_directory( $settings ) ),
			'assets_directory' => trailingslashit( $this->get_assets_directory( $settings ) ),
			'use_drive_analytics' => ! empty ( $settings['drive_analytics'] ) && boolval( $settings['drive_analytics'] ),
			'is_viewport_autoplay' => $flowplayer_shortcode->get_attr_value( 'autoplay_viewport', $atts ),
		);

		return $config;
	}

	private function get_flowplayer_directory( $settings = array()  ) {
		$flowplayer5_commercial = trailingslashit( WP_CONTENT_DIR ) . 'flowplayer-commercial';

		if ( is_file( $flowplayer5_commercial ) && ! $settings['cdn_option'] && $settings['key'] ) {
  		// Use files from the 'flowplayer-commercial' default folder
			$flowplayer5_directory = $flowplayer5_commercial;
		} elseif ( ! empty( $settings['directory'] ) && ! $settings['cdn_option'] ) {
  		// Use files from a specified (commercial) folder
			$flowplayer5_directory = $settings['directory'];
		} elseif ( ! $settings['cdn_option'] ) {
  		// Use the local assets
  		switch ( $settings['fp_version'] ) {
  			case 'fp7':
					$assets_postfix = '-v7';
					break;
  			case 'fp6':
					$assets_postfix = '-v6';
					break;
				default:
					$assets_postfix = '';
					break;
			}

			$flowplayer5_directory = plugins_url( '/assets/flowplayer' . $assets_postfix, __FILE__  );
		} else {
  		// Use the CDN assets (default)
			$flowplayer5_directory = '//releases.flowplayer.org/' . $this->player_version . '/'. ( $settings['key'] ? 'commercial' : '' );
		}

		return apply_filters( 'flowplayer_directory', $flowplayer5_directory );
	}

	private function get_assets_directory( $settings ) {
		if ( $settings['cdn_option'] ) {
			$assets_directory = '//releases.flowplayer.org/';
		} else {
			$assets_directory = plugins_url( '/assets', __FILE__ );
		}
		return apply_filters( 'fp5_assets_directory', $assets_directory );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	private function register_styles( $config ) {
		// Register stylesheets
		wp_register_style( 'flowplayer5-skins', $config['fp_directory'] . 'skin/' . ( $config['fp_7'] == '-v7' ? 'skin.css' : 'all-skins.css' ), array(), $config['plugin_version'] );
		wp_register_style( 'flowplayer5-logo-origin', plugins_url( '/assets/css/public-concat' . $config['suffix'] . '.css', __FILE__ ), array(), $config['plugin_version'] );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	private function enqueue_styles( $config ) {
		wp_enqueue_style( 'flowplayer5-skins' );
		wp_enqueue_style( 'flowplayer5-logo-origin' );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	private function register_scripts( $config ) {
		// Register JavaScript so that they can be enqueued later
 		wp_register_script( 'flowplayer5-script', $config['fp_directory'] . 'flowplayer' . $config['suffix'] . '.js', array( 'jquery' ), $config['plugin_version'], false );
		wp_register_script( 'flowplayer5-ima3', '//s0.2mdn.net/instream/html5/ima3.js', array(), null, false );
		wp_register_script( 'flowplayer5-asf', esc_url( $config['asf_js'] ), array( 'flowplayer5-ima3' ), null, false );
		wp_register_script( 'flowplayer5-vast', esc_url( $config['vast_js'] ), array( 'flowplayer5-ima3' ), null, false );
		wp_register_script( 'flowplayer5-hlsjs', 'https://cdnjs.cloudflare.com/ajax/libs/hls.js/0.9.1/hls.light.min.js', array(), null, false );
		wp_register_script( 'flowplayer5-quality-selector', $config['assets_directory'] . $config['qs_dir'] . 'quality-selector' . $config['suffix'] . '.js', array( 'flowplayer5-script' ), '4f2e08f', false );
		wp_register_script( 'flowplayer5-magnific-popup', plugins_url( '/assets/magnific-popup/magnific-popup' . $config['suffix'] . '.js', __FILE__ ), array( 'jquery' ), '1.0.0', false );
		wp_register_script( 'flowplayer5-drive-analytics', '//releases.flowplayer.org/drive-analytics/flowplayer.drive-analytics.min.js', array( 'flowplayer5-script' ), null, false );
		wp_register_script( 'flowplayer5-viewport-autoplay', $config['assets_directory'] . 'viewport-autoplay/flowplayer.viewport-autoplay' . $config['suffix'] . '.js', array( 'flowplayer5-script' ), '60dd8fc', false );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	private function enqueue_scripts( $config ) {
		if ( $config['is_hls'] ){
			wp_enqueue_script( 'flowplayer5-hlsjs' );
		}

		wp_enqueue_script( 'flowplayer5-script' );

		if ( $config['use_drive_analytics'] ){
			wp_enqueue_script( 'flowplayer5-drive-analytics' );
		}
		if ( $config['asf_js'] ){
			wp_enqueue_script( 'flowplayer5-asf' );
		}
		if ( $config['vast_js'] ){
			wp_enqueue_script( 'flowplayer5-vast' );
		}
		if ( $config['qualities'] ){
			wp_enqueue_script( 'flowplayer5-quality-selector' );
		}
		if ( $config['is_lightbox'] ){
			wp_enqueue_script( 'flowplayer5-magnific-popup' );
		}
		if ( $config['is_viewport_autoplay'] ){
			wp_enqueue_script( 'flowplayer5-viewport-autoplay' );
		}
	}

}
