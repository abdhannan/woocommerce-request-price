<?php
class WRP_Product_Admin {
    public function __construct() {
        add_action('woocommerce_product_options_general_product_data', array($this, 'add_poa_option'));
        add_action('woocommerce_process_product_meta', array($this, 'save_poa_option'));
    }

    /**
     * Add custom fields to the product admin page.
     */
    public function add_poa_option() {
        global $post;

        echo '<div class="options_group">';

        // Enable POA
        woocommerce_wp_checkbox(array(
            'id' => '_wrp_enable_poa',
            'label' => __('Enable POA (Price on Application)', 'woocommerce-request-price'),
            'description' => __('Check this box to show "Request Price" instead of the regular price.', 'woocommerce-request-price'),
        ));

        // Button Text
        woocommerce_wp_text_input(array(
            'id' => '_wrp_poa_button_text',
            'label' => __('POA Button Text', 'woocommerce-request-price'),
            'description' => __('Enter the text for the "Request Price" button. Leave empty to use the default.', 'woocommerce-request-price'),
            'desc_tip' => true,
            'placeholder' => __('Request Price', 'woocommerce-request-price'),
        ));

        echo '</div>';
    }

    /**
     * Save the custom fields' values.
     */
    public function save_poa_option($post_id) {
        // Save the checkbox value.
        $enable_poa = isset($_POST['_wrp_enable_poa']) ? 'yes' : 'no';
        update_post_meta($post_id, '_wrp_enable_poa', $enable_poa);

        // Save the custom button text.
        if (isset($_POST['_wrp_poa_button_text'])) {
            update_post_meta($post_id, '_wrp_poa_button_text', sanitize_text_field($_POST['_wrp_poa_button_text']));
        }
    }
}
