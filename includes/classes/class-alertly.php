<?php

namespace ALERTLY\Includes;

use ALERTLY\Includes\Traits\Singleton;

/**
 * Main class that initializes all other classes in the plugin.
 */
class Alertly {

    use Singleton;

    /**
     * Constructor.
     * Initialize other classes.
     */
    protected function __construct() {
        // Call the get_instance() method of all other classes to initialize them
        Alertly_Email::get_instance();
        Alertly_Admin::get_instance();
        Alertly_Subscriber::get_instance();
        Alertly_Email_Logger::get_instance();
    }
}
