<?php

namespace ALERTLY\Includes;

use ALERTLY\Includes\Traits\Singleton;


/**
 * Class Alertly_Email
 * Handles email notifications for new posts.
 */
class Alertly_Email {
    use Singleton; // Use Singleton trait for single instance

    /**
     * Private constructor to prevent multiple instances.
     * Adds the action hook for sending emails on post publish.
     */
    private function __construct() {
        add_action('publish_post', array($this, 'send_email_notifications'), 10, 2);
    }

    /**
     * Sends email notifications when a new post is published.
     * 
     * @param int $ID Post ID.
     * @param WP_Post $post Post object.
     */
    public function send_email_notifications($ID, $post) {
        static $notified = false;

        if ($notified) {
            return;
        }
        $notified = true;

        error_log("Alertly: Processing post ID $ID.");

        $users = get_users(array('fields' => array('user_email')));
        $admin_email = get_option('admin_email');
        $subject = 'New Post Published: ' . $post->post_title;
        $featured_image = get_the_post_thumbnail_url($ID);
        $author_name = 'Awais Irfan';
        $publish_date = get_the_date('', $ID);

        $template_path = ALERTLY_TEMPLATES_DIR . 'alertly-email-template.php';
        if (file_exists($template_path)) {
            ob_start(); // Start output buffering
            include $template_path;
            $message = ob_get_clean(); // Get the content and clean the buffer
            error_log("Alertly: Loaded email template for post ID $ID.");
        } else {
            error_log("Alertly: Email template not found at $template_path for post ID $ID.");
            return;
        }

        // Replace placeholders in the template with actual data
        $message = str_replace('{featured_image}', $featured_image, $message);
        $message = str_replace('{post_title}', $post->post_title, $message);
        $message = str_replace('{post_content}', apply_filters('the_content', $post->post_content), $message);
        $message = str_replace('{author_name}', $author_name, $message);
        $message = str_replace('{publish_date}', $publish_date, $message);
        $message = str_replace('{post_link}', get_permalink($ID), $message);
        $message = str_replace('{year}', date('Y'), $message);
        $headers = array('From: ' . $admin_email, 'Content-Type: text/html; charset=UTF-8');

        $email_log = array(
            'post_id' => $ID,
            'post_title' => $post->post_title,
            'from_email' => $admin_email,
            'sent_to' => count($users),
            'emails' => array(),
            'skipped' => 0,
            'success' => 0,
            'failure' => 0,
            'log_details' => array(),
        );

        foreach ($users as $user) {
            if (is_email($user->user_email)) {
                $result = wp_mail($user->user_email, $subject, $message, $headers);
                if ($result) {
                    error_log("Alertly: Email sent to {$user->user_email}.");
                    $email_log['success']++;
                    $email_log['emails'][] = $user->user_email;
                    $email_log['log_details'][] = 'Email sent to: ' . $user->user_email;
                } else {
                    error_log("Alertly: Failed to send email to {$user->user_email}. Error: " . error_get_last()['message']);
                    $email_log['failure']++;
                    $email_log['log_details'][] = 'Failed to send email to: ' . $user->user_email . '. Error: ' . error_get_last()['message'];
                    $this->add_admin_notice("Failed to send email to {$user->user_email}. Please check the mail server settings.");
                }
            } else {
                error_log("Alertly: Invalid email skipped: {$user->user_email}.");
                $email_log['skipped']++;
                $email_log['log_details'][] = 'Invalid email skipped: ' . $user->user_email;
            }
        }

        Alertly_Email_Logger::log_email($email_log);
    }

    /**
     * Adds an admin notice for error messages.
     * 
     * @param string $message The error message to display.
     */
    private function add_admin_notice($message) {
        add_action('admin_notices', function() use ($message) {
            echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($message) . '</p></div>';
        });
    }

    
}
