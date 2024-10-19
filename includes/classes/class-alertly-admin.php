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
        // add_menu_page(
        //     'Alertly',
        //     'Alertly',
        //     'manage_options',
        //     'alertly-dashboard',
        //     array($this, 'display_log_page'),
        //     'dashicons-email-alt',
        //     100
        // );

        // Add submenu item for email logs
        add_submenu_page(
            'alertly-dashboard',
            'Email Logs',
            'Email Logs',
            'manage_options',
            'alertly-log',
            array($this, 'display_log_page')
        );

        // Add hidden submenu item for log details (to ensure permissions check)
        add_submenu_page(
            'alertly-dashboard',
            'Email Log Details',
            '', // Hidden, no title in the submenu
            'manage_options',
            'alertly-log-details',
            array($this, 'display_log_details_page')
        );

        // Add submenu item for managing subscribers
        // add_submenu_page(
        //     'alertly-dashboard',
        //     'Manage Subscribers',
        //     'Manage Subscribers',
        //     'manage_options',
        //     'alertly-subscribers',
        //     array($this, 'display_subscribers_page')
        // );

         // Add submenu item for Domain & SMTP Health Check
        add_submenu_page(
            'alertly-dashboard',
            'Domain & SMTP Health Check', 
            'Health Check',               
            'manage_options',             
            'alertly-checks',             
            array($this, 'display_health_check_page') 
        );




        add_submenu_page(
            'alertly-dashboard',                 // Parent slug
            'Available Post Types',        // Page title
            'Post Types',                  // Menu title
            'manage_options',              // Capability
            'alertly-post-types',          // Menu slug
            array($this, 'display_post_types_page') // Callback function
        );

         // Dashboard submenu
    add_submenu_page(
        'alertly-dashboard',
        'Dashboard',
        'Dashboard',
        'manage_options',
        'alertly-dashboard',
        array($this, 'display_dashboard_page')
    );

    // Subscription Forms submenu
    add_submenu_page(
        'alertly-dashboard',
        'Subscription Forms',
        'Subscription Forms',
        'manage_options',
        'alertly-subscription-forms',
        array($this, 'display_subscription_forms_page')
    );

    // Email Subscribers submenu
    add_submenu_page(
        'alertly-dashboard',
        'Email Subscribers',
        'Email Subscribers',
        'manage_options',
        'alertly-subscribers',
        array($this, 'display_subscribers_page')
    );

    // Email Campaigns submenu
    add_submenu_page(
        'alertly-dashboard',
        'Email Campaigns',
        'Email Campaigns',
        'manage_options',
        'alertly-campaigns',
        array($this, 'display_campaigns_page')
    );

    // Automation Rules submenu
    add_submenu_page(
        'alertly-dashboard',
        'Automation Rules',
        'Automation Rules',
        'manage_options',
        'alertly-automation-rules',
        array($this, 'display_automation_rules_page')
    );

    // Settings submenu
    add_submenu_page(
        'alertly-dashboard',
        'Settings',
        'Settings',
        'manage_options',
        'alertly-settings',
        array($this, 'display_settings_page')
    );

    // Tools submenu
    add_submenu_page(
        'alertly-dashboard',
        'Tools',
        'Tools',
        'manage_options',
        'alertly-tools',
        array($this, 'display_tools_page')
    );

    // Extensions submenu
    add_submenu_page(
        'alertly-dashboard',
        'Extensions',
        'Extensions',
        'manage_options',
        'alertly-extensions',
        array($this, 'display_extensions_page')
    );

    // Documentation submenu
    add_submenu_page(
        'alertly-dashboard',
        'Documentation',
        'Documentation',
        'manage_options',
        'alertly-documentation',
        array($this, 'display_documentation_page')
    );

        
        
    
    }

    public function display_campaigns_page() {
        echo '<div class="wrap">';
        echo '<h1>' . __('Email Campaigns', 'alertly') . '</h1>';
        
        echo '<h2 class="nav-tab-wrapper">';
        echo '<a href="?page=alertly-campaigns&tab=newsletters" class="nav-tab">Newsletters</a>';
        echo '<a href="?page=alertly-campaigns&tab=automated" class="nav-tab">Automated Emails</a>';
        echo '<a href="?page=alertly-campaigns&tab=sequences" class="nav-tab">Sequences/Courses</a>';
        echo '</h2>';
    
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'newsletters';
    
        switch ($current_tab) {
            case 'newsletters':
                include ALERTLY_TEMPLATES_DIR . 'alertly-newsletters-tab.php';
                break;
            case 'automated':
                include ALERTLY_TEMPLATES_DIR . 'alertly-automated-emails-tab.php';
                break;
            case 'sequences':
                include ALERTLY_TEMPLATES_DIR . 'alertly-sequences-tab.php';
                break;
            default:
                include ALERTLY_TEMPLATES_DIR . 'alertly-newsletters-tab.php';
                break;
        }
    
        echo '</div>';
    }
    

    public function display_post_types_page() {
        $post_types = get_post_types(array('public' => true), 'objects');
    
        echo '<div class="wrap"><h1>' . __('Available Post Types', 'alertly') . '</h1>';
        echo '<ul>';
        foreach ($post_types as $post_type) {
            echo '<li>' . esc_html($post_type->labels->name) . ' (' . esc_html($post_type->name) . ')</li>';
        }
        echo '</ul>';
        echo '</div>';
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

