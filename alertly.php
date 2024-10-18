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

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alertly_create_campaign_nonce']) && wp_verify_nonce($_POST['alertly_create_campaign_nonce'], 'alertly_create_campaign')) {
    $campaign_name = sanitize_text_field($_POST['campaign_name']);
    $campaign_description = sanitize_textarea_field($_POST['campaign_description']);

    // Save to the session or database as the first step
    $_SESSION['alertly_campaign'] = array(
        'name' => $campaign_name,
        'description' => $campaign_description
    );

    // Redirect to the next step (e.g., select post type)
    wp_redirect(admin_url('admin.php?page=alertly-select-post-type'));
    exit;
}
