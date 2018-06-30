<?php

GFForms::include_payment_addon_framework();

class GFPayPalPaymentsPro extends GFPaymentAddOn {
	protected $_version = GF_PAYPALPAYMENTSPRO_VERSION;
	protected $_min_gravityforms_version = '1.9.16';
	protected $_slug = 'gravityformspaypalpaymentspro';
	protected $_path = 'gravityformspaypalpaymentspro/paypalpaymentspro.php';
	protected $_full_path = __FILE__;
	protected $_url = 'http://www.gravityforms.com';
	protected $_title = 'Gravity Forms PayPal Payments Pro Add-On';
	protected $_short_title = 'PayPal Payments Pro';
	protected $_supports_callbacks = true;
    protected $_requires_credit_card = true;
	protected $_enable_rg_autoupgrade = true;

	/**
	 * Members plugin integration
	 */
	protected $_capabilities = array(
			'gravityforms_paypalpaymentspro',
			'gravityforms_paypalpaymentspro_uninstall',
			'gravityforms_paypalpaymentspro_plugin_page'
	);

	/**
	 * Permissions
	 */
	protected $_capabilities_settings_page = 'gravityforms_paypalpaymentspro';
	protected $_capabilities_form_settings = 'gravityforms_paypalpaymentspro';
    protected $_capabilities_uninstall = 'gravityforms_paypalpaymentspro_uninstall';
	protected $_capabilities_plugin_page = 'gravityforms_paypalpaymentspro_plugin_page';
	
	private static $_instance = null;

	/**
	 * Get an instance of this class.
	 *
	 * @return GFPayPalPaymentsPro
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFPayPalPaymentsPro();
		}

		return self::$_instance;
	}

	// # ADMIN FUNCTIONS -----------------------------------------------------------------------------------------------

	// ------- Plugin settings -------

	/**
	 * Configures the settings which should be rendered on the add-on settings tab.
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {
		$description = '<p style="text-align: left;">' . sprintf( esc_html__( 'PayPal Payments Pro is a merchant account and gateway in one. Use Gravity Forms to collect payment information and automatically integrate to your PayPal Payments Pro account. If you don\'t have a PayPal Payments Pro account, you can %ssign up for one here%s', 'gravityformspaypalpaymentspro' ), '<a href="https://registration.paypal.com/welcomePage.do?bundleCode=C3&country=US&partner=PayPal" target="_blank">', '</a>' ) . '</p>';
		return array(
			array(
				'description' => $description,
				'fields'      => array(
					array(
						'name'    		=> 'mode',
						'label'   		=> esc_html__( 'API', 'gravityformspaypalpaymentspro' ),
						'type'    		=> 'radio',
						'default_value' => 'production',
						'choices'       => array(
							array(
								'label' 	=> esc_html__( 'Live', 'gravityformspaypalpaymentspro' ),
								'value' 	=> 'production',
							),
							array(
								'label'    	=> esc_html__( 'Sandbox', 'gravityformspaypalpaymentspro' ),
								'value'    	=> 'test',
							),
						),
						'horizontal'    => true,
					),
					array(
						'name'    	 		=> 'username',
						'label'    			=> esc_html__( 'Username', 'gravityformspaypalpaymentspro' ),
						'type'	   			=> 'text',
						'class'    			=> 'medium',
						'feedback_callback' => array( $this, 'is_valid_api_credentials' ),
					),
					array(
						'name'     => 'password',
						'label'    => esc_html__( 'Password', 'gravityformspaypalpaymentspro' ),
						'type'	   => 'password',
						'class'    => 'medium',
						'feedback_callback'	=> array( $this, 'check_valid_api_credential_setting' ),
					),
					array(
						'name'     => 'vendor',
						'label'    => esc_html__( 'Vendor (optional)', 'gravityformspaypalpaymentspro' ),
						'type'	   => 'vendor',
						'class'    => 'medium',
						'feedback_callback'	=> array( $this, 'check_valid_api_credential_setting' ),
					),
					array(
						'name'     		=> 'partner',
						'label'    		=> esc_html__( 'Partner', 'gravityformspaypalpaymentspro' ),
						'type'	   		=> 'partner',
						'class'    		=> 'medium',
						'default_value'	=> 'PayPal',
						'feedback_callback'	=> array( $this, 'check_valid_api_credential_setting' ),
					),
				),
			),
		);
	}

	/**
	 * Define the markup for the password type field.
	 *
	 * @param array $field The field properties.
	 * @param bool|true $echo Should the setting markup be echoed.
	 *
	 * @return string|void
	 */
	public function settings_password( $field, $echo = true ) {

		$field['type'] = 'text';

		$password_field = $this->settings_text( $field, false );

		//switch type="text" to type="password" so the password is not visible
		$password_field = str_replace( 'type="text"','type="password"', $password_field );

		if ( $echo ) {
			echo $password_field;
		}

		return $password_field;

	}

	/**
	 * Define the markup for the vendor type field.
	 *
	 * @param array $field The field properties.
	 * @param bool|true $echo Should the setting markup be echoed.
	 *
	 * @return string|void
	 */
	public function settings_vendor( $field, $echo = true ) {

		$field['type'] = 'text';

		$vendor_field = $this->settings_text( $field, false );

		$caption = '<small>' . sprintf( esc_html__( 'Your merchant login ID if different from Username above.', 'gravityformspaypalpaymentspro' ) ) . '</small>';

		if ( $echo ) {
			echo $vendor_field . '</br>' . $caption;
		}

		return $vendor_field . '</br>' . $caption;

	}

	/**
	 * Define the markup for the partner type field.
	 *
	 * @param array $field The field properties.
	 * @param bool|true $echo Should the setting markup be echoed.
	 *
	 * @return string|void
	 */
	public function settings_partner( $field, $echo = true ) {

		$field['type'] = 'text';

		$partner_field = $this->settings_text( $field, false );

		$caption = '<small>' . sprintf( esc_html__( 'If you have registered with a PayPal Reseller, enter their ID above.', 'gravityformspaypalpaymentspro' ) ) . '</small>';

		if ( $echo ) {
			echo $partner_field . '</br>' . $caption;
		}

		return $partner_field . '</br>' . $caption;

	}

	//-------- Form Settings ---------

	/**
	 * Prevent feeds being listed or created if the api keys aren't valid.
	 *
	 * @return bool
	 */
	public function can_create_feed() {
		return $this->is_valid_api_credentials();
	}

	/**
	 * Configures the settings which should be rendered on the feed edit page.
	 *
	 * @return array The feed settings.
	 */
	public function feed_settings_fields() {
		$default_settings = parent::feed_settings_fields();

		//remove default options before adding custom
		$default_settings = parent::remove_field( 'options', $default_settings );
		$default_settings = parent::remove_field( 'billingCycle', $default_settings );
		$default_settings = parent::remove_field( 'trial', $default_settings );

		//add pay period if subscription
		if ( $this->get_setting( 'transactionType' ) == 'subscription' ) {
			$pay_period_field = array(
				'name'     => 'payPeriod',
				'label'    => esc_html__( 'Pay Period', 'gravityformspaypalpaymentspro' ),
				'type'     => 'select',
				'choices' => array(
								array( 'label' => esc_html__( 'Weekly', 'gravityformspaypalpaymentspro' ), 'value' => 'WEEK' ),
								array( 'label' => esc_html__( 'Every Two Weeks', 'gravityformspaypalpaymentspro' ), 'value' => 'BIWK' ),
								array( 'label' => esc_html__( 'Twice Every Month', 'gravityformspaypalpaymentspro' ), 'value' => 'SMMO' ),
								array( 'label' => esc_html__( 'Every Four Weeks', 'gravityformspaypalpaymentspro' ), 'value' => 'FRWK' ),
								array( 'label' => esc_html__( 'Monthly', 'gravityformspaypalpaymentspro' ), 'value' => 'MONT' ),
								array( 'label' => esc_html__( 'Quarterly', 'gravityformspaypalpaymentspro' ), 'value' => 'QTER' ),
								array( 'label' => esc_html__( 'Twice Every Year', 'gravityformspaypalpaymentspro' ), 'value' => 'SMYR' ),
								array( 'label' => esc_html__( 'Yearly', 'gravityformspaypalpaymentspro' ), 'value' => 'YEAR' ),
							),
				'tooltip'  => '<h6>' . esc_html__( 'Pay Period', 'gravityformspaypalpaymentspro' ) . '</h6>' . esc_html__( 'Select pay period.  This determines how often the recurring payment should occur.', 'gravityformspaypalpaymentspro' ),
			);
			$default_settings = $this->add_field_after( 'recurringAmount', $pay_period_field, $default_settings );

			//Add post fields if form has a post
			$form = $this->get_current_form();

			if ( GFCommon::has_post_field( $form['fields'] ) ) {
				$post_settings = array(
						'name'    => 'post_checkboxes',
						'label'   => esc_html__( 'Posts', 'gravityformspaypalpaymentspro' ),
						'type'    => 'checkbox',
						'tooltip' => '<h6>' . esc_html__( 'Posts', 'gravityformspaypalpaymentspro' ) . '</h6>' . esc_html__( 'Enable this option if you would like to change the post status when a subscription is cancelled.', 'gravityformspaypalpaymentspro' ),
						'choices' => array(
								array(
										'label'    => esc_html__( 'Update Post when subscription is cancelled.', 'gravityformspaypalpaymentspro' ),
										'name'     => 'change_post_status',
										'onChange' => 'var action = this.checked ? "draft" : ""; jQuery("#update_post_action").val(action);',
								),
						),
				);

				$default_settings = $this->add_field_after( 'billingInformation', $post_settings, $default_settings );
			}
		}

		$fields = array(
			array(
				'name'      => 'apiSettingsEnabled',
				'label'     => esc_html__( 'API Settings', 'gravityformspaypalpaymentspro' ),
				'type'      => 'checkbox',
				'tooltip' 	=> '<h6>' . esc_html__( 'API Settings', 'gravityformspaypalpaymentspro' ) . '</h6>' . esc_html__( 'Override the settings provided on the PayPal Payments Pro Settings page and use these instead for this feed.', 'gravityformspaypalpaymentspro' ),
				'onchange' => "if(jQuery(this).prop('checked')){
										jQuery('#gaddon-setting-row-overrideMode').show();
										jQuery('#gaddon-setting-row-overrideUsername').show();
										jQuery('#gaddon-setting-row-overridePassword').show();
										jQuery('#gaddon-setting-row-overrideVendor').show();
										jQuery('#gaddon-setting-row-overridePartner').show();
									} else {
										jQuery('#gaddon-setting-row-overrideMode').hide();
										jQuery('#gaddon-setting-row-overrideUsername').hide();
										jQuery('#gaddon-setting-row-overridePassword').hide();
										jQuery('#gaddon-setting-row-overrideVendor').hide();
										jQuery('#gaddon-setting-row-overridePartner').hide();
										jQuery('#overrideUsername').val('');
										jQuery('#overridePassword').val('');
										jQuery('#overrideVendor').val('');
										//jQuery('#overridePartner').val('');
										jQuery('i').removeClass('icon-check fa-check gf_valid');
									}",
				'choices' 	=> array(
					array(
						'label' => 'Override Default Settings',
						'name'	=> 'apiSettingsEnabled',
					),
				)
			),
			array(
				'name'    		=> 'overrideMode',
				'label'   		=> esc_html__( 'API', 'gravityformspaypalpaymentspro' ),
				'type'    		=> 'radio',
				'hidden'  		=> ! $this->get_setting( 'apiSettingsEnabled' ),
				'tooltip' 		=> '<h6>' . esc_html__( 'API', 'gravityformspaypalpaymentspro' ) . '</h6>' . esc_html__( 'Select either Production or Sandbox API to override the chosen mode on the PayPal Payments Pro Settings page.', 'gravityformspaypalpaymentspro' ),
				'choices'       => array(
					array(
						'label' 	=> esc_html__( 'Production', 'gravityformspaypalpaymentspro' ),
						'value' 	=> 'production',
					),
					array(
						'label'    	=> esc_html__( 'Sandbox', 'gravityformspaypalpaymentspro' ),
						'value'    	=> 'test',
					),
				),
				'horizontal'    => true,
			),
			array(
				'name'     => 'overrideUsername',
				'label'    => esc_html__( 'Username', 'gravityformspaypalpaymentspro' ),
				'type'     => 'text',
				'class'    => 'medium',
				'hidden'  		=> ! $this->get_setting( 'apiSettingsEnabled' ),
				'tooltip' 		=> '<h6>' . esc_html__( 'Username', 'gravityformspaypalpaymentspro' ) . '</h6>' . esc_html__( 'Enter a new value to override the Username on the PayPal Payments Pro Settings page.', 'gravityformspaypalpaymentspro' ),
				'feedback_callback' => array( $this, 'is_valid_override_credentials' ),
			),
			array(
				'name'     => 'overridePassword',
				'label'    => esc_html__( 'Password', 'gravityformspaypalpaymentspro' ),
				'type'     => 'password',
				'class'    => 'medium',
				'hidden'  		=> ! $this->get_setting( 'apiSettingsEnabled' ),
				'tooltip' 		=> '<h6>' . esc_html__( 'Password', 'gravityformspaypalpaymentspro' ) . '</h6>' . esc_html__( 'Enter a new value to override the Password on the PayPal Payments Pro Settings page.', 'gravityformspaypalpaymentspro' ),
				'feedback_callback' => array( $this, 'check_valid_override_credential_setting' ),
			),
			array(
				'name'     => 'overrideVendor',
				'label'    => esc_html__( 'Vendor (optional)', 'gravityformspaypalpaymentspro' ),
				'type'     => 'vendor',
				'class'    => 'medium',
				'hidden'  		=> ! $this->get_setting( 'apiSettingsEnabled' ),
				'tooltip' 		=> '<h6>' . esc_html__( 'Vendor', 'gravityformspaypalpaymentspro' ) . '</h6>' . esc_html__( 'Enter a new value to override the Vendor on the PayPal Payments Pro Settings page.', 'gravityformspaypalpaymentspro' ),
				'feedback_callback' => array( $this, 'check_valid_override_credential_setting' ),
			),
			array(
				'name'			=> 'overridePartner',
				'label'    		=> esc_html__( 'Partner', 'gravityformspaypalpaymentspro' ),
				'type'     		=> 'partner',
				'class'    		=> 'medium',
				'hidden'  		=> ! $this->get_setting( 'apiSettingsEnabled' ),
				'tooltip' 		=> '<h6>' . esc_html__( 'Partner', 'gravityformspaypalpaymentspro' ) . '</h6>' . esc_html__( 'Enter a new value to override the Partner on the PayPal Payments Pro Settings page.', 'gravityformspaypalpaymentspro' ),
				'default_value'	=> 'PayPal',
				'feedback_callback' => array( $this, 'check_valid_override_credential_setting' ),
			),
		);

		$default_settings = $this->add_field_after( 'conditionalLogic', $fields, $default_settings );

		return $default_settings;
	}

	/**
	 * Returns the markup for the change post status checkbox item.
	 *
	 * @param array $choice The choice properties.
	 * @param string $attributes The attributes for the input tag.
	 * @param string $value Currently selection (1 if field has been checked. 0 or null otherwise).
	 * @param string $tooltip The tooltip for this checkbox item.
	 *
	 * @return string
	 */
	public function checkbox_input_change_post_status( $choice, $attributes, $value, $tooltip ) {
		$markup = $this->checkbox_input( $choice, $attributes, $value, $tooltip );

		$dropdown_field = array(
			'name'     => 'update_post_action',
			'choices'  => array(
				array( 'label' => '' ),
				array( 'label' => esc_html__( 'Mark Post as Draft', 'gravityformspaypalpaymentspro' ), 'value' => 'draft' ),
				array( 'label' => esc_html__( 'Delete Post', 'gravityformspaypalpaymentspro' ), 'value' => 'delete' ),

			),
			'onChange' => "var checked = jQuery(this).val() ? 'checked' : false; jQuery('#change_post_status').attr('checked', checked);",
		);
		$markup .= '&nbsp;&nbsp;' . $this->settings_select( $dropdown_field, false );

		return $markup;
	}

	/**
	 * Prepend the name fields to the default billing_info_fields added by the framework.
	 *
	 * @return array
	 */
	public function billing_info_fields() {
		$fields = array(
				array(
						'name'     => 'lastName',
						'label'    => esc_html__( 'Last Name', 'gravityformspaypalpaymentspro' ),
						'required' => false
				),
				array(
						'name'     => 'firstName',
						'label'    => esc_html__( 'First Name', 'gravityformspaypalpaymentspro' ),
						'required' => false
				)
		);

		return array_merge( $fields, parent::billing_info_fields() );
	}

	/**
	 * Add supported notification events.
	 *
	 * @param array $form The form currently being processed.
	 *
	 * @return array
	 */
	public function supported_notification_events( $form ) {
		if ( ! $this->has_feed( $form['id'] ) ) {
			return false;
		}

		return array(
				'complete_payment'          => esc_html__( 'Payment Completed', 'gravityformspaypalpaymentspro' ),
				'create_subscription'       => esc_html__( 'Subscription Created', 'gravityformspaypalpaymentspro' ),
				'cancel_subscription'       => esc_html__( 'Subscription Canceled', 'gravityformspaypalpaymentspro' ),
				'expire_subscription'       => esc_html__( 'Subscription Expired', 'gravityformspaypalpaymentspro' ),
				'add_subscription_payment'  => esc_html__( 'Subscription Payment Added', 'gravityformspaypalpaymentspro' ),
		);
	}

	//-------- Entry Detail ---------

	/**
	 * Handle cancelling the subscription from the entry detail page.
	 *
	 * @param array $entry The entry object currently being processed.
	 * @param array $feed The feed object currently being processed.
	 *
	 * @return bool
	 */
	public function cancel( $entry, $feed ) {

		$args = array( 'TRXTYPE'       => 'R',
		               'TENDER'        => 'C',
		               'ORIGPROFILEID' => $entry['transaction_id'],
		               'ACTION'        => 'C'
		);

		$settings = $this->get_plugin_settings();
		$response = $this->post_to_payflow( $args, $settings, $entry['form_id'] );

		if ( ! empty( $response ) && $response['RESULT'] == '0' ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the current entry was processed by this add-on.
	 *
	 * @param int $entry_id The ID of the current Entry.
	 *
	 * @return bool
	 */
	public function is_payment_gateway( $entry_id ) {

		if ( $this->is_payment_gateway ) {
			return true;
		}

		$gateway = gform_get_meta( $entry_id, 'payment_gateway' );

		return in_array( $gateway, array( 'paypalpaymentspro', $this->_slug ) );
	}


	// # SUBMISSION ----------------------------------------------------------------------------------------------------

	/**
	 * Authorize and capture the transaction for the product & services type feed.
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array
	 */
	public function authorize( $feed, $submission_data, $form, $entry ) {

		// Credit Card Information
		$args = $this->prepare_credit_card_transaction( $feed, $submission_data, $form, $entry );

		// setting up sale transaction parameters
		$args['TRXTYPE'] = 'S';

		/**
		 * Filter the transaction properties for the product and service feed.
		 *
		 * @since 1.0.0
		 * @since 2.0.0 Added the $submission_data, $feed, and $entry parameters.
		 *
		 * @param array $args The transaction properties.
		 * @param int $form_id The ID of the form currently being processed.
		 * @param array $submission_data The customer and transaction data.
		 * @param array $feed The feed object currently being processed.
		 * @param array $entry The entry object currently being processed.
		 */
		$args = apply_filters( 'gform_paypalpaymentspro_args_before_payment', $args, $form['id'], $submission_data, $feed, $entry );

		$settings = $this->get_plugin_settings();
		$response = $this->post_to_payflow( $args, $settings, $form['id'] );

		if ( isset( $response['RESULT'] ) && $response['RESULT'] == 0 ) {
			$this->log_debug( __METHOD__ . "(): Funds captured successfully. Amount: {$args['AMT']}. Transaction Id: {$response['PNREF']}." );
			$captured_payment = array( 'is_success'     => true,
			                           'error_message'  => '',
			                           'transaction_id' => $response['PNREF'],
			                           'amount'         => $args['AMT']
			);
			$auth             = array( 'is_authorized'    => true,
			                           'transaction_id'   => $response['PNREF'],
			                           'captured_payment' => $captured_payment
			);

			$config = $this->get_config( $feed, $submission_data );

			// deprecated
			do_action( 'gform_paypalpaymentspro_post_capture', $args['AMT'], $entry, $form, $config );

		} else {
			$this->log_error( __METHOD__ . '(): Funds could not be captured.' );
			$auth = array( 'is_success'     => false,
			               'transaction_id' => $response['PNREF'],
			               'error_message'  => $response['RESPMSG']
			);
		}

		return $auth;

	}

	/**
	 * Create a recurring profile for the user and return any errors which occur.
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array
	 */
	public function subscribe( $feed, $submission_data, $form, $entry ) {

		$subscription = $this->prepare_credit_card_transaction( $feed, $submission_data, $form, $entry );

		//setting up recurring transaction parameters
		$subscription['TRXTYPE'] = 'R';
		$subscription['ACTION']  = 'A';

		$subscription['START']             = date( 'mdY', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) + 1, date( 'y' ) ) );
		$subscription['PROFILENAME']       = $subscription['FIRSTNAME'] . " " . $subscription['LASTNAME'];
		$subscription['MAXFAILEDPAYMENTS'] = '0';
		$subscription['PAYPERIOD']         = $feed['meta']['payPeriod'];
		$subscription['TERM']              = $feed['meta']['recurringTimes'];
		$subscription['AMT']               = $submission_data['payment_amount'];

		if ( $feed['meta']['setupFee_enabled'] && ! empty( $submission_data['setup_fee'] ) && $submission_data['setup_fee'] > 0 ) {
			$subscription['OPTIONALTRX']    = 'S';
			$subscription['OPTIONALTRXAMT'] = $submission_data['setup_fee'];
		} else {
			$subscription['OPTIONALTRX'] = 'A';
		}

		/**
		 * Filter the subscription transaction properties.
		 *
		 * @since 1.0.0
		 * @since 2.0.0 Added the $submission_data, $feed, and $entry parameters.
		 *
		 * @param array $subscription The subscription transaction properties.
		 * @param int $form_id The ID of the form currently being processed.
		 * @param array $submission_data The customer and transaction data.
		 * @param array $feed The feed object currently being processed.
		 * @param array $entry The entry object currently being processed.
		 */
		$subscription = apply_filters( 'gform_paypalpaymentspro_args_before_subscription', $subscription, $form['id'], $submission_data, $feed, $entry );

		$this->log_debug( __METHOD__ . '(): Creating recurring profile.' );
		$settings = $this->get_plugin_settings();
		$response = $this->post_to_payflow( $subscription, $settings, $form['id'] );

		if ( $response['RESULT'] == 0 ) {

			$subscription_id = $response['PROFILEID'];
			$this->log_debug( __METHOD__ . "(): Subscription created successfully. Subscription Id: {$subscription_id}" );

			if ( $feed['meta']['setupFee_enabled'] ) {
				$captured_payment    = array(
						'is_success'     => true,
						'transaction_id' => rgar( $response, 'RPREF' ),
						'amount'         => $submission_data['setup_fee']
				);
				$subscription_result = array(
						'is_success'       => true,
						'subscription_id'  => $subscription_id,
						'captured_payment' => $captured_payment,
						'amount'           => $subscription['AMT']
				);
			} else {
				$subscription_result = array( 'is_success'      => true,
				                              'subscription_id' => $subscription_id,
				                              'amount'          => $subscription['AMT']
				);
			}

		} else {
			$this->log_error( __METHOD__ . '(): There was an error creating Subscription.' );
			$error_message       = $this->get_error_message( $response );
			$subscription_result = array( 'is_success' => false, 'error_message' => $error_message );
		}

		return $subscription_result;
	}


	// # CRON JOB ------------------------------------------------------------------------------------------------------

	/**
	 * Check subscription status; Active subscriptions will be checked to see if their status needs to be updated.
	 */
	public function check_status() {
		// this is where we will check subscription status and update as needed
		$this->log_debug( __METHOD__ . '(): Checking subscription status.' );

		// getting all PayPal Payments Pro subscription feeds
		$recurring_feeds = $this->get_feeds_by_slug( $this->_slug );

		foreach ( $recurring_feeds as $feed ) {

			// process renewal's if authorize.net feed is subscription feed
			if ( $feed['meta']['transactionType'] == 'subscription' ) {

				$form_id   = $feed['form_id'];
				$querytime = strtotime( gmdate( 'Y-m-d' ) );
				$querydate = gmdate( 'mdY', $querytime );

				// finding leads with a late payment date
				global $wpdb;

				$results = $wpdb->get_results( "SELECT l.id, l.transaction_id, m.meta_value as payment_date
                                                FROM {$wpdb->prefix}rg_lead l
                                                INNER JOIN {$wpdb->prefix}rg_lead_meta m ON l.id = m.lead_id
                                                WHERE l.form_id={$form_id}
                                                AND payment_status = 'Active'
                                                AND meta_key = 'subscription_payment_date'
                                                AND meta_value < '{$querydate}'" );

				$this->log_debug( __METHOD__ . '(): Leads with late payment.' );
				foreach ( $results as $result ) {

					$this->log_debug( print_r( $result ) );

					//Getting entry
					$entry_id = $result->id;
					$entry    = GFAPI::get_entry( $entry_id );

					$subscription_id = $result->transaction_id;
					// Get the subscription profile status
					$profile_status_request                  = array();
					$profile_status_request['TRXTYPE']       = 'R';
					$profile_status_request['TENDER']        = 'C';
					$profile_status_request['ACTION']        = 'I';
					$profile_status_request['ORIGPROFILEID'] = $subscription_id;
					//$profile_status_request['PAYMENTHISTORY'] = 'Y';

					$settings       = $this->get_plugin_settings();
					$profile_status = $this->post_to_payflow( $profile_status_request, $settings, $form_id );

					$status          = $profile_status['STATUS'];
					$subscription_id = $profile_status['PROFILEID'];

					switch ( strtolower( $status ) ) {
						case 'active' :

							// getting new payment date and count
							$new_payment_date   = $profile_status['NEXTPAYMENT'];
							$new_payment_count  = $profile_status['NEXTPAYMENTNUM'] - 1;
							$new_payment_amount = $profile_status['AMT'];

							if ( $new_payment_date > $querydate ) {

								// update subscription payment and lead information
								gform_update_meta( $entry_id, 'subscription_payment_count', $new_payment_count );
								gform_update_meta( $entry_id, 'subscription_payment_date', $new_payment_date );

								$action = array( 'amount'          => $new_payment_amount,
								                 'subscription_id' => $subscription_id,
								);
								$this->add_subscription_payment( $entry, $action );

								//deprecated
								do_action( 'gform_paypalpaymentspro_after_subscription_payment', $entry, $subscription_id, $profile_status['AMT'] );
							}

							break;

						case 'expired' :

							$action = array( 'subscription_id' => $subscription_id );
							$this->expire_subscription( $entry, $action );

							//deprecated
							do_action( 'gform_paypalpaymentspro_subscription_expired', $entry, $subscription_id );

							break;

						case 'too many failures':
						case 'deactivated by merchant':
							$this->cancel_subscription( $entry, $feed );
							do_action( 'gform_paypalpaymentspro_subscription_canceled', $entry, $subscription_id );
							break;

						default:
							$this->cancel_subscription( $entry, $feed );
							do_action( 'gform_paypalpaymentspro_subscription_canceled', $entry, $subscription_id );
							break;
					}

				}

			}

		}
	}


	// # HELPERS -------------------------------------------------------------------------------------------------------

	/**
	 * Maybe validate the override credentials.
	 *
	 * @return bool
	 */
	public function is_valid_override_credentials() {
		//get override credentials
		global $valid_override_username;
		$valid_override_username = false;

		$apiSettingsEnabled = $this->get_setting( 'apiSettingsEnabled' );
		if ( $apiSettingsEnabled ) {
			$custom_settings['mode']     = $this->get_setting( 'overrideMode' );
			$custom_settings['username'] = $this->get_setting( 'overrideUsername' );
			$custom_settings['password'] = $this->get_setting( 'overridePassword' );
			$custom_settings['vendor']   = $this->get_setting( 'overrideVendor' );
			$custom_settings['partner']  = $this->get_setting( 'overridePartner' );

			$valid_override_username = $this->is_valid_credentials( $custom_settings );
		}

		return $valid_override_username;
	}

	/**
	 * Validate the API credentials.
	 *
	 * @return bool
	 */
	public function is_valid_api_credentials() {
		//get api credentials
		$settings = $this->get_plugin_settings();
		global $valid_username;
		$valid_username = $this->is_valid_credentials( $settings );

		return $valid_username;
	}

	/**
	 * Validate the credentials.
	 *
	 * @param array $settings The plugin settings.
	 *
	 * @return bool
	 */
	public function is_valid_credentials( $settings ) {
		$args = array( 'TRXTYPE' => 'A', 'TENDER' => 'C' );

		if ( ! empty( $settings ) ) {
			$response = $this->post_to_payflow( $args, $settings );
		}

		if ( ! empty( $response ) && $response['RESULT'] != '1' && $response['RESPMSG'] != 'User authentication failed' ) {
			//$valid_username = true;
			return true;
		} else {
			//$valid_username = false;
			return false;
		}

	}

	/**
	 * Helper to check if the vendor, partner and password settings are valid.
	 *
	 * @return bool
	 */
	public function check_valid_api_credential_setting() {
		global $valid_username;

		return $valid_username;
	}

	/**
	 * Helper to check if the override vendor, partner and password settings are valid.
	 *
	 * @return bool
	 */
	public function check_valid_override_credential_setting() {
		global $valid_override_username;

		return $valid_override_username;
	}

	/**
	 * Post to the Payflow API.
	 *
	 * @param array $nvp The transaction arguments.
	 * @param array $settings The plugin settings.
	 * @param null|int $form_id The ID of the current Form.
	 *
	 * @return array
	 */
	public function post_to_payflow( $nvp = array(), $settings = array(), $form_id = null ) {
		// Set up your API credentials and PayFlow Pro end point.
		if ( ! empty( $settings ) ) {
			$API_UserName = $settings['username'];
			$API_Password = $settings['password'];
			$Vendor       = $settings['vendor'];
			$Vendor       = empty( $Vendor ) ? $API_UserName : $Vendor;
			$Partner      = $settings['partner'];
			$Partner      = empty( $Partner ) ? 'PayPal' : $Partner;
			$mode         = $settings['mode'];

			$API_Endpoint = $mode == 'test' ? 'https://pilot-payflowpro.paypal.com' : 'https://payflowpro.paypal.com';

			$api_info = compact( 'API_Endpoint', 'API_UserName', 'API_Password', 'Vendor', 'Partner' );
			$api_info = apply_filters( 'gform_paypalpaymentspro_api_before_send', $api_info, $form_id );
			extract( $api_info );

			// Set the curl parameters.
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $API_Endpoint );
			curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_POST, 1 );

			$nvp = apply_filters( 'gform_paypalpaymentspro_args_before_send', $nvp, $form_id );

			$nvpstr = '';
			if ( is_array( $nvp ) ) {
				foreach ( $nvp as $key => $value ) {
					if ( is_array( $value ) ) {
						foreach ( $value as $item ) {
							if ( strlen( $nvpstr ) > 0 ) {
								$nvpstr .= '&';
							}
							$nvpstr .= "$key=" . $item;
						}
					} else {
						if ( strlen( $nvpstr ) > 0 ) {
							$nvpstr .= '&';
						}
						$nvpstr .= "$key=" . $value;
					}
				}
			}

			//add the bn code (build notation code)
			$nvpstr = "BUTTONSOURCE=Rocketgenius_SP&$nvpstr";

			// Set the API operation, version, and API signature in the request.
			$nvpreq = "VENDOR=$Vendor&PARTNER=$Partner&PWD=$API_Password&USER=$API_UserName&$nvpstr";

			$this->log_debug( __METHOD__ . "(): Sending request to PayPal - URL: {$API_Endpoint} Request: {$nvpreq}" );

			// Set the request as a POST FIELD for curl.
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $nvpreq );

			// Get response from the server.
			$httpResponse = curl_exec( $ch );

			// Extract the response details.
			$httpParsedResponseAr = array();
			if ( $httpResponse ) {
				$httpResponseAr = explode( '&', $httpResponse );
				foreach ( $httpResponseAr as $i => $value ) {
					$tmpAr = explode( '=', urldecode( $value ) );
					if ( sizeof( $tmpAr ) > 1 ) {
						$httpParsedResponseAr[ $tmpAr[0] ] = $tmpAr[1];
					}
				}
			}
			$write_response_to_log = true;
			if ( $nvp['TRXTYPE'] == 'A' && $httpParsedResponseAr['RESULT'] == '23' ) {
				$write_response_to_log = false;
			}
			if ( $write_response_to_log ) {
				$this->log_debug( __METHOD__ . '(): Response from PayPal: ' . $httpResponse );
				$this->log_debug( __METHOD__ . '(): Friendly view of response: ' . print_r( $httpParsedResponseAr, true ) );
			}

			return $httpParsedResponseAr;
		}
	}

	/**
	 * Prepare the transaction arguments.
	 *
	 * @param array $feed The feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form The form object currently being processed.
	 * @param array $entry The entry object currently being processed.
	 *
	 * @return array
	 */
	public function prepare_credit_card_transaction( $feed, $submission_data, $form, $entry ) {

		// Billing Information
		$card_number     = $submission_data['card_number'];
		$expiration_date = str_pad( $submission_data['card_expiration_date'][0], 2, '0', STR_PAD_LEFT ) . substr( $submission_data['card_expiration_date'][1], - 2 );; // ?? correct format ??
		$country               = $submission_data['country'];
		$country               = GFCommon::get_country_code( $country );
		$args                  = array();
		$args['ACCT']          = $card_number;
		$args['EXPDATE']       = $expiration_date;
		$args['CVV2']          = $submission_data['card_security_code'];
		$args['STREET']        = $submission_data['address'];
		$args['BILLTOSTREET2'] = $submission_data['address2'];
		$args['CITY']          = $submission_data['city'];
		$args['STATE']         = $submission_data['state'];
		$args['ZIP']           = $submission_data['zip'];
		$args['BILLTOCOUNTRY'] = $country == 'UK' ? 'GB' : $country;
		$args['CURRENCY']      = GFCommon::get_currency();

		// Customer Information
		$args['FIRSTNAME'] = $submission_data['firstName'];
		$args['LASTNAME']  = $submission_data['lastName'];
		$args['EMAIL']     = $submission_data['email'];

		// Product Information
		$i            = 0;
		$args['DESC'] = '';
		foreach ( $submission_data['line_items'] as $line_item ) {
			if ( $feed['meta']['transactionType'] == 'product' ) {
				$args["L_NAME$i"]   = $line_item['name'];
				$args["L_DESC$i"]   = $line_item['description'];
				$args["L_AMT$i"]    = $line_item['unit_price'];
				$args["L_NUMBER$i"] = $i + 1;
				$args["L_QTY$i"]    = $line_item['quantity'];
			} else {
				$args['DESC'] .= $i > 1 ? ', ' . $line_item['name'] : $line_item['name']; // ?? TO DO figure out why there is warning that desc is undefined
			}
			$i ++;

		}

		$args['AMT']    = $submission_data['payment_amount'];
		$args['TENDER'] = 'C';

		return $args;
	}

	/**
	 * Prepare the appropriate error message for the transaction result.
	 *
	 * @param array $response The response from the Payflow API.
	 *
	 * @return string
	 */
	public function get_error_message( $response ) {
		$code = $response['RESULT'];

		switch ( $code ) {
			case '50' :
				$message = esc_html__( 'This credit card has been declined by your bank. Please use another form of payment.', 'gravityformspaypalpaymentspro' );
				break;

			case '24' :
				$message = esc_html__( 'The credit card has expired.', 'gravityformspaypalpaymentspro' );
				break;

			case '1021' :
				$message = esc_html__( 'The merchant does not accept this type of credit card.', 'gravityformspaypalpaymentspro' );
				break;

			case "12" :
			case "23" :
				$message = esc_html__( 'There was an error processing your credit card. Please verify the information and try again.', 'gravityformspaypalpaymentspro' );
				break;

			default :
				$message = esc_html__( 'There was an error processing your request. Your credit card was not charged. Please try again.', 'gravityformspaypalpaymentspro' );
		}

		$message = '<!-- Error: ' . $code . ' -->' . $message;

		return $message;
	}

	/**
	 * Convert feed into config for hooks backwards compatibility.
	 *
	 * @param array $feed The current feed object.
	 * @param array $submission_data The customer and transaction data.
	 *
	 * @return array
	 */
	private function get_config( $feed, $submission_data ) {

		$config = array();

		$config['id']        = $feed['id'];
		$config['form_id']   = $feed['form_id'];
		$config['is_active'] = $feed['is_active'];

		$config['meta']['type']               = rgar( $feed['meta'], 'transactionType' );
		$config['meta']['update_post_action'] = rgar( $feed['meta'], 'update_post_action' );

		$config['meta']['paypalpaymentspro_conditional_enabled'] = rgar( $feed['meta'], 'feed_condition_conditional_logic' );
		if ( $feed['meta']['feed_condition_conditional_logic'] ) {
			$config['meta']['paypalpaymentspro_conditional_field_id'] = $feed['meta']['feed_condition_conditional_logic_object']['conditionalLogic']['rules'][0]['fieldId'];
			$config['meta']['paypalpaymentspro_conditional_operator'] = $feed['meta']['feed_condition_conditional_logic_object']['conditionalLogic']['rules'][0]['operator'];
			$config['meta']['paypalpaymentspro_conditional_value']    = $feed['meta']['feed_condition_conditional_logic_object']['conditionalLogic']['rules'][0]['value'];
		}

		$config['meta']['api_settings_enabled'] = rgar( $feed['meta'], 'apiSettingsEnabled' );
		$config['meta']['api_mode']             = rgar( $feed['meta'], 'overrideMode' );
		$config['meta']['api_username']         = rgar( $feed['meta'], 'overrideUsername' );
		$config['meta']['api_password']         = rgar( $feed['meta'], 'overridePassword' );
		$config['meta']['api_vendor']           = rgar( $feed['meta'], 'overrideVendor' );
		$config['meta']['api_partner']          = rgar( $feed['meta'], 'overridePartner' );

		$config['meta']['customer_fields']['email']    = rgar( $feed['meta'], 'billingInformation_email' );
		$config['meta']['customer_fields']['address1'] = rgar( $feed['meta'], 'billingInformation_address' );
		$config['meta']['customer_fields']['address2'] = rgar( $feed['meta'], 'billingInformation_address2' );
		$config['meta']['customer_fields']['city']     = rgar( $feed['meta'], 'billingInformation_city' );
		$config['meta']['customer_fields']['state']    = rgar( $feed['meta'], 'billingInformation_state' );
		$config['meta']['customer_fields']['zip']      = rgar( $feed['meta'], 'billingInformation_zip' );
		$config['meta']['customer_fields']['country']  = rgar( $feed['meta'], 'billingInformation_country' );

		return $config;

	}


	// # TO FRAMEWORK MIGRATION ----------------------------------------------------------------------------------------

	/**
	 * Initialize the admin specific hooks.
	 */
	public function init_admin() {
		parent::init_admin();

		add_filter( 'gform_addon_navigation', array( $this, 'maybe_create_menu' ) );
	}

	/**
	 * Maybe add the temporary plugin page to the menu.
	 *
	 * @param array $menus
	 *
	 * @return array
	 */
	public function maybe_create_menu( $menus ) {

		$current_user                   = wp_get_current_user();
		$dismiss_paypalpaymentspro_menu = get_metadata( 'user', $current_user->ID, 'dismiss_paypalpaymentspro_menu', true );
		if ( $dismiss_paypalpaymentspro_menu != '1' ) {
			$menus[] = array( 'name'       => $this->_slug,
			                  'label'      => $this->get_short_title(),
			                  'callback'   => array( $this, 'temporary_plugin_page' ),
			                  'permission' => $this->_capabilities_form_settings
			);
		}

		return $menus;
	}

	/**
	 * Initialize the AJAX hooks.
	 */
	public function init_ajax() {
		parent::init_ajax();

		add_action( 'wp_ajax_gf_dismiss_paypalpaymentspro_menu', array( $this, 'ajax_dismiss_menu' ) );
	}

	/**
	 * Update the user meta to indicate they shouldn't see the temporary plugin page again.
	 */
	public function ajax_dismiss_menu() {

		$current_user = wp_get_current_user();
		update_metadata( 'user', $current_user->ID, 'dismiss_paypalpaymentspro_menu', '1' );
	}

	/**
	 * Display a temporary page explaining how feeds are now managed.
	 */
	public function temporary_plugin_page() {
		?>
		<script type="text/javascript">
			function dismissMenu() {
				jQuery('#gf_spinner').show();
				jQuery.post(ajaxurl, {
							action: "gf_dismiss_paypalpaymentspro_menu"
						},
						function (response) {
							document.location.href = '?page=gf_edit_forms';
							jQuery('#gf_spinner').hide();
						}
				);

			}
		</script>

		<div class="wrap about-wrap">
			<h1><?php esc_html_e( 'PayPal Payments Pro Add-On v2.0', 'gravityformspaypalpaymentspro' ) ?></h1>

			<div class="about-text"><?php esc_html_e( 'Thank you for updating! The new version of the Gravity Forms PayPal Payments Pro Add-On makes changes to how you manage your PayPal Payments Pro integration.', 'gravityformspaypalpaymentspro' ) ?></div>
			<div class="changelog">
				<hr/>
				<div class="feature-section col two-col">
					<div class="col-1">
						<h3><?php esc_html_e( 'Manage PayPal Payments Pro Contextually', 'gravityformspaypalpaymentspro' ) ?></h3>

						<p><?php esc_html_e( 'PayPal Payments Pro Feeds are now accessed via the PayPal Payments Pro sub-menu within the Form Settings for the Form with which you would like to integrate PayPal Payments Pro.', 'gravityformspaypalpaymentspro' ) ?></p>
					</div>
					<div class="col-2 last-feature">
						<img src="http://gravityforms.s3.amazonaws.com/webimages/AddonNotice/NewPayPalPaymentsPro2.png">
					</div>
				</div>

				<hr/>

				<form method="post" id="dismiss_menu_form" style="margin-top: 20px;">
					<input type="checkbox" name="dismiss_paypalpaymentspro_menu" value="1" onclick="dismissMenu();">
					<label><?php esc_html_e( 'I understand this change, dismiss this message!', 'gravityformspaypalpaymentspro' ) ?></label>
					<img id="gf_spinner" src="<?php echo GFCommon::get_base_url() . '/images/spinner.gif' ?>" alt="<?php esc_html_e( 'Please wait...', 'gravityformspaypalpaymentspro' ) ?>" style="display:none;"/>
				</form>

			</div>
		</div>
		<?php
	}

	/**
	 * Checks if a previous version was installed and if the feeds need migrating to the framework structure.
	 *
	 * @param string $previous_version The version number of the previously installed version.
	 */
	public function upgrade( $previous_version ) {
		if ( empty( $previous_version ) ) {
			$previous_version = get_option( 'gf_paypalpaymentspro_version' );
		}
		$previous_is_pre_addon_framework = ! empty( $previous_version ) && version_compare( $previous_version, '2.0.dev1', '<' );

		if ( $previous_is_pre_addon_framework ) {
			$this->log_debug( __METHOD__ . '(): Copying over data to new table structure.' );
			$old_feeds = $this->get_old_feeds();

			if ( ! $old_feeds ) {
				$this->log_debug( __METHOD__ . '(): No old feeds found to copy.' );

				return;
			}

			$counter = 1;
			foreach ( $old_feeds as $old_feed ) {
				$feed_name       = 'Feed ' . $counter;
				$form_id         = $old_feed['form_id'];
				$is_active       = $old_feed['is_active'];
				$customer_fields = rgar( $old_feed['meta'], 'customer_fields' );

				$new_meta = array(
						'feedName'           => $feed_name,
						'transactionType'    => rgar( $old_feed['meta'], 'type' ),
						'change_post_status' => rgar( $old_feed['meta'], 'update_post_action' ) ? '1' : '0',
						'update_post_action' => rgar( $old_feed['meta'], 'update_post_action' ),
						'recurringAmount'    => rgar( $old_feed['meta'], 'recurring_amount_field' ) == 'all' ? 'form_total' : rgar( $old_feed['meta'], 'recurring_amount_field' ),
						'recurringTimes'     => rgar( $old_feed['meta'], 'recurring_times' ),
						'payPeriod'          => rgar( $old_feed['meta'], 'pay_period' ),
						'paymentAmount'      => 'form_total', //default to this for new field in framework version
						'setupFee_enabled'   => rgar( $old_feed['meta'], 'setup_fee_enabled' ),
						'setupFee_product'   => rgar( $old_feed['meta'], 'setup_fee_amount_field' ),

						'billingInformation_firstName' => rgar( $customer_fields, 'first_name' ),
						'billingInformation_lastName'  => rgar( $customer_fields, 'last_name' ),
						'billingInformation_email'     => rgar( $customer_fields, 'email' ),
						'billingInformation_address'   => rgar( $customer_fields, 'address1' ),
						'billingInformation_address2'  => rgar( $customer_fields, 'address2' ),
						'billingInformation_city'      => rgar( $customer_fields, 'city' ),
						'billingInformation_state'     => rgar( $customer_fields, 'state' ),
						'billingInformation_zip'       => rgar( $customer_fields, 'zip' ),
						'billingInformation_country'   => rgar( $customer_fields, 'country' ),

						'apiSettingsEnabled' => rgar( $old_feed['meta'], 'api_settings_enabled' ),
						'overrideMode'       => rgar( $old_feed['meta'], 'api_mode' ),
						'overrideUsername'   => rgar( $old_feed['meta'], 'api_username' ),
						'overridePassword'   => rgar( $old_feed['meta'], 'api_password' ),
						'overrideVendor'     => rgar( $old_feed['meta'], 'api_vendor' ),
						'overridePartner'    => rgar( $old_feed['meta'], 'api_partner' ),
				);

				$optin_enabled = rgar( $old_feed['meta'], 'paypalpaymentspro_conditional_enabled' );
				if ( $optin_enabled ) {
					$new_meta['feed_condition_conditional_logic']        = 1;
					$new_meta['feed_condition_conditional_logic_object'] = array(
							'conditionalLogic' => array(
									'actionType' => 'show',
									'logicType'  => 'all',
									'rules'      => array(
											array(
													'fieldId'  => $old_feed['meta']['paypalpaymentspro_conditional_field_id'],
													'operator' => $old_feed['meta']['paypalpaymentspro_conditional_operator'],
													'value'    => $old_feed['meta']['paypalpaymentspro_conditional_value'],
											),
									)
							)
					);
				} else {
					$new_meta['feed_condition_conditional_logic'] = 0;
				}

				$this->insert_feed( $form_id, $is_active, $new_meta );
				$counter ++;

			}

			$old_settings = get_option( 'gf_paypalpaymentspro_settings' );

			if ( ! empty( $old_settings ) ) {
				$this->log_debug( __METHOD__ . '(): Copying plugin settings.' );
				$new_settings = array(
						'mode'     => rgar( $old_settings, 'mode' ),
						'username' => rgar( $old_settings, 'username' ),
						'password' => rgar( $old_settings, 'password' ),
						'vendor'   => rgar( $old_settings, 'vendor' ),
						'partner'  => rgar( $old_settings, 'partner' ),
				);

				parent::update_plugin_settings( $new_settings );
			}

			//copy existing transactions to new table
			$this->copy_transactions();

		}

	}

	/**
	 * Retrieve any old feeds which need migrating to the framework,
	 *
	 * @return bool|array
	 */
	public function get_old_feeds() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'rg_paypalpaymentspro';

		if ( ! $this->table_exists( $table_name ) ) {
			return false;
		}

		$form_table_name = GFFormsModel::get_form_table_name();
		$sql             = "SELECT s.id, s.is_active, s.form_id, s.meta, f.title as form_title
					FROM {$table_name} s
					INNER JOIN {$form_table_name} f ON s.form_id = f.id";

		$results = $wpdb->get_results( $sql, ARRAY_A );

		$count = sizeof( $results );

		$this->log_debug( __METHOD__ . '(): ' . $count . ' feed(s) found to copy.' );

		for ( $i = 0; $i < $count; $i ++ ) {
			$results[ $i ]['meta'] = maybe_unserialize( $results[ $i ]['meta'] );
		}

		return $results;
	}

	/**
	 * Copy transactions from the old add-on table to the framework table.
	 * 
	 * @return bool
	 */
	public function copy_transactions() {
		global $wpdb;
		$old_table_name = $this->get_old_transaction_table_name();
		if ( ! $this->table_exists( $old_table_name ) ) {
			return false;
		}
		$this->log_debug( __METHOD__ . '(): Copying old PayPal Payments Pro transactions into new table structure.' );

		$new_table_name = $this->get_new_transaction_table_name();

		$sql = "INSERT INTO {$new_table_name} (lead_id, transaction_type, transaction_id, is_recurring, amount, date_created)
					SELECT entry_id, transaction_type, transaction_id, is_renewal, amount, date_created FROM {$old_table_name}";

		$wpdb->query( $sql );

		$this->log_debug( __METHOD__ . "(): transactions: {$wpdb->rows_affected} rows were added." );
	}

	/**
	 * Returns the name of the old table used to store transactions.
	 * 
	 * @return string
	 */
	public function get_old_transaction_table_name() {
		global $wpdb;

		return $wpdb->prefix . 'rg_paypalpaymentspro_transaction';
	}

	/**
	 * Returns the name of the framework table used to store transactions.
	 * 
	 * @return string
	 */
	public function get_new_transaction_table_name() {
		global $wpdb;

		return $wpdb->prefix . 'gf_addon_payment_transaction';
	}

}