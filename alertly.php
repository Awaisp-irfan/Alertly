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
require_once ALERTLY_INCLUDES_DIR . 'class-alertly-email.php';
require_once ALERTLY_INCLUDES_DIR . 'class-alertly-email-logger.php';
require_once ALERTLY_INCLUDES_DIR . 'class-alertly-admin.php';
require_once ALERTLY_INCLUDES_DIR . 'class-alertly-subscriber.php'; // Add this line

/**
 * Initialize the plugin
 */
Alertly_Email::get_instance();
Alertly_Email_Logger::get_instance();
Alertly_Admin::get_instance();
Alertly_Subscriber::get_instance(); // Initialize the subscriber class
?>
