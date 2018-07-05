<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Real Time Validation for Gravity Forms
 * Plugin URI:        https://wisetr.com
 * Description:       This plugin ensures that users gets the feedback on each field as he types even before form is submitted. Specific validation messages shown to user help him quickly rectify the mistakes.
 * Version:           1.0.16
 * Author:            Wisetr
 * Author URI:        https://wisetr.com
 * Text Domain:       gravity-lv
 * 
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/* ----------------------------------------------------------------------------*
 * Public-Facing Functionality
 * ---------------------------------------------------------------------------- */



define('LV_ROOT', plugin_dir_path(__FILE__));
define('LV_ROOT_URL', plugin_dir_url(__FILE__));

require_once( plugin_dir_path(__FILE__) . 'public/class-gravity-forms-live-validation.php' );

add_action('init','lv_init_domain');

add_action('plugins_loaded', array('Gravity_Forms_Live_Validation', 'get_instance'));

function lv_validation_install($plugin) {

    if ($plugin == plugin_basename(__FILE__)) {
        wp_redirect(add_query_arg(array('page' => 'gf_edit_forms', 'lv_install_complete' => 'y'), admin_url('admin.php')));
        exit;
    }
}

add_action('activated_plugin', 'lv_validation_install');

/**
 * Handling support plugin installations
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (!is_plugin_active('gravityforms/gravityforms.php')) {
    $plugin = plugin_basename(__FILE__);
    if (is_plugin_active($plugin)) {
        deactivate_plugins($plugin);
        $plugin_data = get_plugin_data(__FILE__, false);
        wp_die("<strong>" . $plugin_data['Name'] . "</strong> requires <strong>Gravity Forms</strong> plugin, and has been deactivated! Please install or activate Gravity Forms and try again.<br /><br />Back to the WordPress <a href='" . get_admin_url(null, 'plugins.php') . "'>Plugins page</a>.");
    }
}
/* ----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 * ---------------------------------------------------------------------------- */


if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX )) {

    require_once( plugin_dir_path(__FILE__) . 'admin/class-gravity-forms-live-validation-admin.php' );
    add_action('plugins_loaded', array('Gravity_Forms_Live_Validation_Admin', 'get_instance'));
}

function lv_init_domain(){
     load_plugin_textdomain('lv-validation', FALSE, plugin_basename( dirname( __FILE__ ) ) . '/languages');
}