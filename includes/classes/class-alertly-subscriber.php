<?php

namespace ALERTLY\Includes;

use ALERTLY\Includes\Traits\Singleton;


/**
 * Class Alertly_Subscriber
 * Handles the management of email subscribers.
 */
class Alertly_Subscriber {
    use Singleton; // Use Singleton trait for single instance

    private function __construct() {
        // Initialize hooks and actions
        add_action('init', array($this, 'create_subscribers_table'));
    }

    /**
     * Creates the subscribers database table.
     */
    public function create_subscribers_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'alertly_subscribers';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            email varchar(100) NOT NULL,
            status varchar(20) DEFAULT 'pending' NOT NULL,
            confirmation_key varchar(100) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Adds a new subscriber to the database.
     *
     * @param string $name Subscriber's name.
     * @param string $email Subscriber's email.
     */
    public function add_subscriber($name, $email) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'alertly_subscribers';

        // Generate a unique confirmation key
        $confirmation_key = wp_generate_uuid4();

        // Insert subscriber into the database
        $wpdb->insert($table_name, array(
            'name' => $name,
            'email' => $email,
            'status' => 'pending',
            'confirmation_key' => $confirmation_key
        ));

        // Send confirmation email
        $this->send_confirmation_email($email, $confirmation_key);
    }

    /**
     * Removes a subscriber from the database.
     *
     * @param string $email Subscriber's email.
     */
    public function remove_subscriber($email) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'alertly_subscribers';
        $wpdb->delete($table_name, array('email' => $email));
    }

    /**
     * Retrieves all subscribers from the database.
     *
     * @return array List of subscribers.
     */
    public static function get_subscribers() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'alertly_subscribers';
        return $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    }

    /**
     * Sends a confirmation email to the new subscriber.
     *
     * @param string $email Subscriber's email.
     * @param string $confirmation_key Unique confirmation key.
     */
    private function send_confirmation_email($email, $confirmation_key) {
        $confirmation_link = add_query_arg(array(
            'action' => 'confirm_subscription',
            'email' => $email,
            'key' => $confirmation_key
        ), home_url());

        $message = "Please confirm your subscription by clicking the following link: " . $confirmation_link;

        wp_mail($email, 'Confirm Your Subscription', $message);
    }
}

// Initialize the Alertly Subscriber class.
Alertly_Subscriber::get_instance();
