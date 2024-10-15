<?php

namespace ALERTLY\Includes;

use ALERTLY\Includes\Traits\Singleton;


/**
 * Class Alertly_Email_Logger
 * Handles logging of email notifications.
 */
class Alertly_Email_Logger {
    use Singleton; // Use Singleton trait for single instance

    /**
     * Private constructor to prevent multiple instances.
     */
    private function __construct() {
        // Initialize logging if needed
    }

    /**
     * Logs the email notification details.
     *
     * @param array $email_log Array containing log details.
     */
    public static function log_email($email_log) {
        // Retrieve all email logs from the database
        $all_email_logs = get_option('alertly_email_logs', array());

        // Append the new log entry
        $all_email_logs[] = $email_log;

        // Update the option in the database
        update_option('alertly_email_logs', $all_email_logs);
    }
}
