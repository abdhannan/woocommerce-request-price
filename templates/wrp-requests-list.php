<div class="wrap">
    <h1><?php esc_html_e('Price Requests', 'woocommerce-request-price'); ?></h1>
    
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php esc_html_e('Product', 'woocommerce-request-price'); ?></th>
                <th><?php esc_html_e('Quantity', 'woocommerce-request-price'); ?></th>
                <th><?php esc_html_e('Customer Name', 'woocommerce-request-price'); ?></th>
                <th><?php esc_html_e('Company', 'woocommerce-request-price'); ?></th>
                <th><?php esc_html_e('Email', 'woocommerce-request-price'); ?></th>
                <th><?php esc_html_e('Phone', 'woocommerce-request-price'); ?></th>
                <th><?php esc_html_e('Enquiry', 'woocommerce-request-price'); ?></th>
                <th><?php esc_html_e('Date Submitted', 'woocommerce-request-price'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($requests)) : ?>
                <?php foreach ($requests as $request) : ?>
                    <tr>
                        <td>
                            <a href="<?php echo esc_url(get_edit_post_link($request->product_id)); ?>" target="_blank">
                                <?php echo esc_html(get_the_title($request->product_id)); ?>
                            </a>
                        </td>
                        <td><?php echo esc_html($request->quantity); ?></td> <!-- Display quantity -->
                        <td><?php echo esc_html($request->customer_name); ?></td>
                        <td><?php echo esc_html($request->customer_company); ?></td>
                        <td>
                            <a href="mailto:<?php echo esc_attr($request->customer_email); ?>">
                                <?php echo esc_html($request->customer_email); ?>
                            </a>
                        </td>
                        <td><?php echo esc_html($request->customer_phone); ?></td>
                        <td><?php echo esc_html($request->customer_enquiry); ?></td>
                        <td><?php echo esc_html(date('Y-m-d H:i:s', strtotime($request->date_submitted))); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8"><?php esc_html_e('No requests found.', 'woocommerce-request-price'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
