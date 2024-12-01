<?php
/*
Plugin Name: WooCommerce Request Price
Description: A WooCommerce plugin to allow customers to request pricing for products.
Version: 1.0
Author: Abd Hannan
Author URI: https://abdhannan.codes
Text Domain: woocommerce-request-price
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define constants.
define('WRP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WRP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files.
require_once WRP_PLUGIN_DIR . 'includes/class-wrp-activator.php';
require_once WRP_PLUGIN_DIR . 'includes/class-wrp-settings.php';
require_once WRP_PLUGIN_DIR . 'includes/class-wrp-product-admin.php';
require_once WRP_PLUGIN_DIR . 'includes/class-wrp-requests.php';
require_once WRP_PLUGIN_DIR . 'includes/class-wrp-admin.php';
require_once WRP_PLUGIN_DIR . 'includes/class-wrp-frontend.php';

// Activate the plugin.
register_activation_hook(__FILE__, array('WRP_Activator', 'activate'));

// Initialize the plugin.
function wrp_init() {
    if (class_exists('WooCommerce')) {
        new WRP_Admin();
        new WRP_Product_Admin();
        new WRP_Frontend();
    } else {
        add_action('admin_notices', function () {
            echo '<div class="error"><p><strong>WooCommerce Request Price</strong> requires WooCommerce to be installed and active.</p></div>';
        });
    }
}
add_action('plugins_loaded', 'wrp_init');
