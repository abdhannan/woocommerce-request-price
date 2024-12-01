<?php
class WRP_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array('WRP_Settings', 'register_settings'));
    }

    public function add_admin_menu() {
        add_menu_page(
            __('WooCommerce Request Price', 'woocommerce-request-price'),
            __('Request Price', 'woocommerce-request-price'),
            'manage_options',
            'wrp-settings',
            array('WRP_Settings', 'settings_page'),
            'dashicons-tag',
            56
        );

        add_submenu_page(
            'wrp-settings',
            __('Price Requests', 'woocommerce-request-price'),
            __('Price Requests', 'woocommerce-request-price'),
            'manage_options',
            'wrp-price-requests',
            array($this, 'price_requests_page')
        );
    }

    public function price_requests_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wrp_requests';
        $requests = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_submitted DESC");
        include WRP_PLUGIN_DIR . 'templates/wrp-requests-list.php';
    }
}
