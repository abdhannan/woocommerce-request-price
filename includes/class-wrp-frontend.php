<?php
class WRP_Frontend {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_filter('woocommerce_get_price_html', array($this, 'replace_price_with_poa'), 10, 2);
        add_action('wp_footer', array($this, 'add_modal'));
        add_action('wp_ajax_wrp_request_price', array($this, 'handle_request_price'));
        add_action('wp_ajax_nopriv_wrp_request_price', array($this, 'handle_request_price'));
        
        // Initialize single product modifications
        $this->modify_single_product_view();
    }
    

    public function enqueue_scripts() {
        wp_enqueue_script('wrp-scripts', WRP_PLUGIN_URL . 'assets/js/wrp-scripts.js', array('jquery'), '1.0', true);
        wp_enqueue_style('wrp-styles', WRP_PLUGIN_URL . 'assets/css/wrp-styles.css');
        wp_localize_script('wrp-scripts', 'wrp_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    public function replace_price_with_poa($price, $product) {
        if ('yes' === get_post_meta($product->get_id(), '_wrp_enable_poa', true)) {
            // Replace price with "POA" text
            return '<span class="wrp-poa-text">' . __('POA (Price on Application)', 'woocommerce-request-price') . '</span>';
        }
        return $price;
    }
    

    public function modify_single_product_view() {
        add_action('woocommerce_single_product_summary', array($this, 'add_request_price_button'), 35);
        add_filter('woocommerce_is_purchasable', array($this, 'make_product_unpurchasable'), 10, 2);
    }
    
    /**
     * Hide Add to Cart button and add Request Price button.
     */
    public function add_request_price_button() {
        global $product;
    
        if ('yes' === get_post_meta($product->get_id(), '_wrp_enable_poa', true)) {
            // Remove Add to Cart button
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    
            // Get product details
            $button_text = get_post_meta($product->get_id(), '_wrp_poa_button_text', true);
            $button_text = $button_text ?: get_option('wrp_request_button_text', __('Request Price', 'woocommerce-request-price'));
            $product_image = wp_get_attachment_url($product->get_image_id());
            $product_title = $product->get_name();
    
            // Add Request Price button with data attributes
            echo '<button class="wrp-request-price-button" 
                data-product-id="' . esc_attr($product->get_id()) . '" 
                data-product-title="' . esc_attr($product_title) . '" 
                data-product-image="' . esc_url($product_image) . '">'
                . esc_html($button_text) . 
                '</button>';
        }
    }
    
    
    /**
     * Prevent product from being purchasable if POA is enabled.
     */
    public function make_product_unpurchasable($purchasable, $product) {
        if ('yes' === get_post_meta($product->get_id(), '_wrp_enable_poa', true)) {
            return false; // Make product unpurchasable
        }
        return $purchasable;
    }
    
    

    public function add_modal() {
        include WRP_PLUGIN_DIR . 'templates/wrp-modal.php';
    }

    public function handle_request_price() {
        // Verify nonce
        if (!isset($_POST['wrp_request_price_nonce']) || !wp_verify_nonce($_POST['wrp_request_price_nonce'], 'wrp_request_price_action')) {
            wp_send_json_error(__('Nonce verification failed', 'woocommerce-request-price'));
            wp_die();
        }
    
        // Get form data
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']); // Capture quantity
        $customer_name = sanitize_text_field($_POST['customer_name']);
        $customer_company = sanitize_text_field($_POST['customer_company']);
        $customer_email = sanitize_email($_POST['customer_email']);
        $customer_phone = sanitize_text_field($_POST['customer_phone']);
        $customer_enquiry = sanitize_textarea_field($_POST['customer_enquiry']);


        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Default to 1 if not set
        error_log('Quantity Received: ' . $quantity); // Log the quantity for debugging

    
        // Save request to the database
        global $wpdb;
        $table_name = $wpdb->prefix . 'wrp_requests';
        $wpdb->insert($table_name, array(
            'product_id' => $product_id,
            'quantity' => $quantity, // Save quantity
            'customer_name' => $customer_name,
            'customer_company' => $customer_company,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'customer_enquiry' => $customer_enquiry,
        ));
    
        // Send email to admin
        $admin_email = get_option('wrp_admin_email', get_option('admin_email'));
        $product_title = get_the_title($product_id);
        $message = sprintf(__('You have received a price request for %s (Quantity: %d)', 'woocommerce-request-price'), $product_title, $quantity) . "\n\n";
        $message .= __('Customer Details:', 'woocommerce-request-price') . "\n";
        $message .= "Name: $customer_name\nCompany: $customer_company\nEmail: $customer_email\nPhone: $customer_phone\nEnquiry: $customer_enquiry\n";
    
        wp_mail($admin_email, __('Price Request Submitted', 'woocommerce-request-price'), $message);
    
        wp_send_json_success(__('Your request has been submitted successfully!', 'woocommerce-request-price'));
    }
    
    
}
