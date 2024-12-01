<div id="wrp-modal" style="display:none;">
    <div class="wrp-modal-content">
        <button id="wrp-close-modal">&times;</button>
        <h2><?php esc_html_e('Request Price', 'woocommerce-request-price'); ?></h2>
        
        <!-- Loader -->
        <div id="wrp-loader">
            <img src="<?php echo esc_url(WRP_PLUGIN_URL . 'assets/images/loader.gif'); ?>" alt="Loading...">
        </div>

        <!-- Customer Details Form -->
        <form id="wrp-request-price-form">
            <?php wp_nonce_field('wrp_request_price_action', 'wrp_request_price_nonce'); ?>
            <input type="hidden" name="product_id" id="wrp-product-id">

            <!-- Product Details Section -->
            <div id="wrp-product-details">
                <img id="wrp-product-image" src="" alt="">
                <div>
                    <h3 id="wrp-product-title"></h3>
                    <label for="wrp-product-quantity"><?php esc_html_e('Quantity', 'woocommerce-request-price'); ?></label>
                    <input type="number" id="wrp-product-quantity" name="quantity" value="1" min="1" required>
                </div>
            </div>

            <!-- Customer Fields -->
            <div>
                <label><?php esc_html_e('Full Name', 'woocommerce-request-price'); ?></label>
                <input type="text" name="customer_name" required>
            </div>
            <div>
                <label><?php esc_html_e('Company', 'woocommerce-request-price'); ?></label>
                <input type="text" name="customer_company">
            </div>
            <div>
                <label><?php esc_html_e('Email', 'woocommerce-request-price'); ?></label>
                <input type="email" name="customer_email" required>
            </div>
            <div>
                <label><?php esc_html_e('Phone', 'woocommerce-request-price'); ?></label>
                <input type="text" name="customer_phone">
            </div>
            <div>
                <label><?php esc_html_e('Enquiry', 'woocommerce-request-price'); ?></label>
                <textarea name="customer_enquiry" rows="4"></textarea>
            </div>
            <button type="submit"><?php esc_html_e('Submit Request', 'woocommerce-request-price'); ?></button>
        </form>
    </div>
</div>
