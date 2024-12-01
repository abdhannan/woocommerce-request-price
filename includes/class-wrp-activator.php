<?php
class WRP_Activator {
    public static function activate() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wrp_requests';
        $charset_collate = $wpdb->get_charset_collate();
    
        $sql = "CREATE TABLE $table_name (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            product_id BIGINT(20) UNSIGNED NOT NULL,
            quantity INT(11) DEFAULT 1, /* New column for quantity */
            customer_name VARCHAR(255) NOT NULL,
            customer_company VARCHAR(255) DEFAULT '',
            customer_email VARCHAR(100) NOT NULL,
            customer_phone VARCHAR(50) DEFAULT '',
            customer_enquiry TEXT DEFAULT '',
            date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
}
