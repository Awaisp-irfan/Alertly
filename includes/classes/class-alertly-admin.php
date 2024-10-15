<?php

namespace ALERTLY\Includes;

use ALERTLY\Includes\Traits\Singleton;


/**
 * Class Alertly_Admin
 * Manages admin-related functionalities for the Alertly plugin.
 */
class Alertly_Admin {
    use Singleton; // Use Singleton trait

    /**
     * Private constructor to prevent multiple instances.
     * Adds the action hook for admin menus.
     */
    private function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_menu', array($this, 'highlight_current_menu'), 999);
    }

    /**
     * Adds menu and submenu pages for the plugin in the WordPress admin.
     */
    public function add_admin_menu() {
        // Add main menu item
        add_menu_page(
            'Alertly',
            'Alertly',
            'manage_options',
            'alertly-log',
            array($this, 'display_log_page'),
            'dashicons-email-alt',
            100
        );

        // Add submenu item for email logs
        add_submenu_page(
            'alertly-log',
            'Email Logs',
            'Email Logs',
            'manage_options',
            'alertly-log',
            array($this, 'display_log_page')
        );

        // Add hidden submenu item for log details (to ensure permissions check)
        add_submenu_page(
            'alertly-log',
            'Email Log Details',
            '', // Hidden, no title in the submenu
            'manage_options',
            'alertly-log-details',
            array($this, 'display_log_details_page')
        );

        // Add submenu item for managing subscribers
        add_submenu_page(
            'alertly-log',
            'Manage Subscribers',
            'Manage Subscribers',
            'manage_options',
            'alertly-subscribers',
            array($this, 'display_subscribers_page')
        );

         // Add submenu item for Domain & SMTP Health Check
        add_submenu_page(
            'alertly-log',
            'Domain & SMTP Health Check', // Page title
            'Health Check',               // Menu title
            'manage_options',             // Capability
            'alertly-checks',             // Menu slug
            array($this, 'display_health_check_page') // Callback function
        );
    
    }

    /**
     * Display the health check page.
     */
    public function display_health_check_page() {
        // Call the display function in Alertly_Checks class to handle the logic and display
        Alertly_Checks::get_instance()->display_checks_page();
    }


    /**
     * Displays the log page in the admin dashboard.
     */
    public function display_log_page() {
        $all_email_logs = get_option('alertly_email_logs', array());
        include ALERTLY_TEMPLATES_DIR . 'alertly-admin-log-page.php';
    }

    /**
     * Displays detailed log information in the admin dashboard.
     */
    public function display_log_details_page() {
        $all_email_logs = get_option('alertly_email_logs', array());
        include ALERTLY_TEMPLATES_DIR . 'alertly-admin-log-details-page.php';
    }

    /**
     * Displays the subscribers management page in the admin dashboard.
     */
    public function display_subscribers_page() {
        // Get the instance of Alertly_Subscriber
        $subscriber_manager = Alertly_Subscriber::get_instance();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alertly_add_subscriber_nonce']) && wp_verify_nonce($_POST['alertly_add_subscriber_nonce'], 'alertly_add_subscriber')) {
            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);
            $subscriber_manager->add_subscriber($name, $email); // Non-static call
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alertly_delete_subscriber_nonce']) && wp_verify_nonce($_POST['alertly_delete_subscriber_nonce'], 'alertly_delete_subscriber')) {
            $subscriber_id = intval($_POST['subscriber_id']);
            $subscriber_manager->remove_subscriber($subscriber_id); // Non-static call
        }

        $subscribers = $subscriber_manager->get_subscribers(); // Non-static call
        include ALERTLY_TEMPLATES_DIR . 'alertly-admin-subscribers-page.php';
    }

    /**
     * Ensures the correct top-level menu is highlighted in the admin dashboard.
     */
    public function highlight_current_menu() {
        global $parent_file;

        // Highlight the "Alertly" top-level menu for relevant subpages
        if (isset($_GET['page']) && in_array($_GET['page'], ['alertly-log', 'alertly-log-details', 'alertly-subscribers'])) {
            $parent_file = 'alertly-log';
        }
    }
}

