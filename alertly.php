<?php
/*
Plugin Name: Alertly
Description: Sends an email to users whenever a new post is published and provides a log of sent notifications.
Version: 1.0
Author: Awais Irfan
*/

defined('ABSPATH') || exit;

/**
 * Define constants for paths
 */
define('ALERTLY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ALERTLY_INCLUDES_DIR', ALERTLY_PLUGIN_DIR . 'includes/');
define('ALERTLY_TEMPLATES_DIR', ALERTLY_PLUGIN_DIR . 'templates/');

/**
 * Include required files
 */
// require_once ALERTLY_INCLUDES_DIR . 'traits/trait-singleton.php'; // Include the Singleton trait
// require_once ALERTLY_INCLUDES_DIR . 'classes/class-alertly-email.php';
// require_once ALERTLY_INCLUDES_DIR . 'classes/class-alertly-email-logger.php';
// require_once ALERTLY_INCLUDES_DIR . 'classes/class-alertly-admin.php';
// require_once ALERTLY_INCLUDES_DIR . 'classes/class-alertly-subscriber.php';

/**
 * Include the autoloader
 */
require_once ALERTLY_PLUGIN_DIR . 'includes/helpers/autoloader.php';


/**
 * Call the main class to initialize the plugin
 */

 function alertly_get_theme_instacnce(){

     ALERTLY\Includes\Alertly::get_instance();
 }

 alertly_get_theme_instacnce();