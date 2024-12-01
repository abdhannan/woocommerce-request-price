<?php
class WRP_Settings {
    public static function register_settings() {
        register_setting('wrp_settings_group', 'wrp_request_button_text');
        register_setting('wrp_settings_group', 'wrp_admin_email');
    }

    public static function settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('WooCommerce Request Price Settings', 'woocommerce-request-price'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('wrp_settings_group');
                do_settings_sections('wrp_settings_group');
                ?>
                <table class="form-table">
                    <tr>
                        <th><?php esc_html_e('Request Button Text', 'woocommerce-request-price'); ?></th>
                        <td>
                            <input type="text" name="wrp_request_button_text" value="<?php echo esc_attr(get_option('wrp_request_button_text', 'Request Price')); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><?php esc_html_e('Admin Email', 'woocommerce-request-price'); ?></th>
                        <td>
                            <input type="email" name="wrp_admin_email" value="<?php echo esc_attr(get_option('wrp_admin_email', get_option('admin_email'))); ?>">
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
