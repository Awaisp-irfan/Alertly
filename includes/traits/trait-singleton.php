<?php

namespace ALERTLY\Includes\Traits;

trait Singleton {

    /**
     * Collection of instances.
     *
     * @var array
     */
    private static $instance = [];

    /**
     * Get the singleton instance of the class.
     *
     * @return self
     */
    final public static function get_instance() {
        $called_class = get_called_class();

        if ( ! isset( self::$instance[ $called_class ] ) ) {
            self::$instance[ $called_class ] = new $called_class();

            do_action( sprintf( 'alertly_singleton_init_%s', $called_class ) );
        }

        return self::$instance[ $called_class ];
    }

    /**
     * Prevent the instance from being cloned.
     */
     private function __clone() {}

    /**
     * Prevent the instance from being unserialized.
     */
     public function __wakeup() {}

    /**
     * Private constructor to prevent multiple instances.
     */
     private function __construct() {
        // Initialization code if needed
    }
}
