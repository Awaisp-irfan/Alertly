<?php

/**
 * Class Alertly_Email_Logger
 * Handles logging of email notifications.
 */
class Alertly_Email_Logger {
    private static $instance = null;

    /**
     * Private constructor to prevent multiple instances.
     */
    private function __construct() {
        // Initialize logging if needed
    }

    /**
     * Singleton pattern to get the single instance of the class.
     *
     * @return Alertly_Email_Logger|null
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Logs the email notification details.
     *
     * @param array $email_log Array containing log details.
     */
    public static function log_email($email_log) {
        $all_email_logs = get_option('alertly_email_logs', array());
        $all_email_logs[] = $email_log;
        update_option('alertly_email_logs', $all_email_logs);
    }
}
