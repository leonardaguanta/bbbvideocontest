<?php
class Pro_Ads_Shortcodes {	

	public function __construct() 
	{
		add_shortcode('pro_ad_display_adzone', array($this, 'sc_display_adzone'));
		add_shortcode('pro_ad_display_banner', array($this, 'sc_display_banner'));
		add_shortcode('hide_post_ads', array($this, 'sc_hide_post_ads'));
	}
	
	
	
	
	
	public function default_atts( $adzone_id = 1 )
	{
		global $pro_ads_responsive;
		
		$device = $pro_ads_responsive->get_device_type();
		
		// Shortcode options
		$defaults = array(
			'id'                 => $adzone_id,
			'screen'             => $device['prefix'],
			'class'              => '',
			'ajax_load'          => 0,
			'align'              => '',
			'fixed'              => '',
			'fixed_item'         => '',
			'fixed_till'         => '',
			//'fixed_cont'         => '',
			'border'             => '',
			'border_color'       => '',
			'padding'            => '',
			'background_color'   => '',
			'background_pattern' => '',
			'border_radius'      => '',
			'border'             => '',
			'border_color'       => '',
			'popup'              => 0,
			'exit_popup'         => 0,
			'popup_bg'           => '',
			'popup_opacity'      => '',
			'flyin'              => 0,
			'flyin_delay'        => 3,
			'flyin_position'     => 'bottom-right',
			'cookie'             => 0,
			'background'         => '',
			'corner_curl'        => 0,
			'corner_small'       => 26,
			'corner_big'         => 100,
			'corner_animate'     => 1,
			'container'          => '',
			'repeat'             => '',
			'stretch'            => '',
			'bg_color'           => '',
			'info_text'          => '',
			'info_text_img'      => '',
			'info_text_url'      => '',
			'info_text_position' => 'above',
			'font_size'          => 11,
			'font_color'         => '#C0C0C0',
			'text_decoration'    => 'none',
			'no_impression'	     => '0',
			'hide_if_loggedin'   => 0
		);	
		
		return apply_filters( 'wp_pro_ads_extend_shortcode_atts', $defaults );
	}
	
	
	
	
	
	
	/*
	 * Shortcode function - [pro_ad_display_adzone id="1" popup="0"]
	 *
	 * @access public
	 * @return array
	*/
	public function sc_display_adzone( $atts, $content = null ) 
	{	
		global $pro_ads_codex, $pro_ads_templates, $pro_ads_adzones, $pro_ads_responsive, $pro_ads_multisite;

		//$atts = wp_parse_args($atts, $this->default_atts());
		$atts = shortcode_atts( $this->default_atts(), $atts, 'pro_ad_display_adzone' );
   
  	extract($atts);
		/***
		 * Multisite ___________________________________________________________________ */
		$pro_ads_multisite->wpproads_wpmu_load_from_main_start();
		
		wp_enqueue_style( 'wp_pro_add_style' );
		
		// Check if cookies script needs to be loaded.
		if( esc_attr($cookie) )
		{
			wp_enqueue_script( 'wppas_jquery_cookie' );
		}
		wp_enqueue_script( 'wp_pro_add_js_functions' );
	        if( !empty($fixed_cont))
		{
			wp_enqueue_script( 'wp_pro_add_scrolltofixed' );
		}
		
		// Check if adzone is popup
		if( esc_attr($popup) )
		{
			if( $pro_ads_codex->wpproads_adzone_is_grid( $id ) )
			{
				// popup grid
				$adzone = $pro_ads_templates->pro_ad_popup_screen( 
					array(
						'html' => $pro_ads_adzones->display_adzone_grid( esc_attr($id), $atts ), 
						'adzone_id' => $id,
						'exit_popup' => $exit_popup,
						'popup_bg'  => $popup_bg,
						'popup_opacity' => $popup_opacity,
						'atts' => $atts
					) 
				);
			}
			else
			{
				// popup banner
				$adzone = $pro_ads_templates->pro_ad_popup_screen( 
					array(
						'html' => $pro_ads_adzones->display_adzone( esc_attr($id), $atts ), 
						'adzone_id' => $id,
						'exit_popup' => $exit_popup,
						'popup_bg'  => $popup_bg,
						'popup_opacity' => $popup_opacity ,
						'atts' => $atts
					) 
				);
			}
		}
		// Check if adzone is fly in
		elseif( esc_attr($flyin) )
		{
			if( $pro_ads_codex->wpproads_adzone_is_grid( $id ) )
			{
				// fly in grid
				$adzone = $pro_ads_templates->pro_ad_fly_in( 
					array(
						'html' => $pro_ads_adzones->display_adzone_grid( esc_attr($id), $atts ), 
						'adzone_id' => $id,
						'delay' => $flyin_delay,
						'position' => $flyin_position,
						'atts' => $atts
					) 
				);
			}
			else
			{
				// fly in banner
				$adzone = $pro_ads_templates->pro_ad_fly_in( 
					array(
						'html' => $pro_ads_adzones->display_adzone( esc_attr($id), $atts ), 
						'adzone_id' => $id,
						'delay' => $flyin_delay,
						'position' => $flyin_position,
						'atts' => $atts
					) 
				);
			}
		}
		// Check if adzone is background ad
		elseif( esc_attr($background) )
		{
			$adzone = $pro_ads_adzones->display_adzone_as_background( $atts );
		}
		// Check if adzone is corner peeler
		elseif( esc_attr($corner_curl) )
		{
			$adzone = $pro_ads_adzones->display_adzone_as_corner_curl( $atts );
		}
		// Normal adzone
		else
		{
			if( $pro_ads_codex->wpproads_adzone_is_grid( $id ) )
			{
				// ad grid
				$adzone = $pro_ads_adzones->display_adzone_grid( esc_attr($id), $atts );
			}
			else
			{
                           	// normal
				
				$adzone = $pro_ads_adzones->display_adzone( esc_attr($id), $atts );
			}
		}
		
		//restore_current_blog();	
		
		/***
		 * Multisite ___________________________________________________________________ */
		$pro_ads_multisite->wpproads_wpmu_load_from_main_stop();
		return $adzone;
	}
	
	
	
	
	
	
	
	/*
	 * Shortcode function - [pro_ad_display_banner id=""]
	 *
	 * @access public
	 * @return null
	*/
	public function sc_display_banner( $atts, $content = null )
	{
		global $pro_ads_banners, $pro_ads_multisite;
		
		/***
		 * Multisite ___________________________________________________________________ */
		$pro_ads_multisite->wpproads_wpmu_load_from_main_start();
	
		//wp_enqueue_style("wp_pro_add_style", WP_ADS_TPL_URL."/css/wpproadds.min.css", false, WP_ADS_VERSION, "all");
		wp_enqueue_style( 'wp_pro_add_style' );	
		extract( shortcode_atts( array(
			'id'        => 1,
			'aid'       => 0,
			'container' => 1
		), $atts ) );
		
		$single_banner = $pro_ads_banners->get_banner_item( array('id' => $id, 'aid' => $aid, 'container' => $container) );
		
		/***
		 * Multisite ___________________________________________________________________ */
		$pro_ads_multisite->wpproads_wpmu_load_from_main_stop();
		
		return $single_banner;
	}
	
	
	
	
	
	
	/*
	 * Shortcode function - [sc_hide_post_ads]
	 *
	 * @access public
	 * @return null
	*/
	public function sc_hide_post_ads()
	{
		return '';
	}
}
?>
