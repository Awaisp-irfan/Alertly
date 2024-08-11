<?php
/**
 * Alertly Admin Log Page Template
 *
 * This template is used to display the email notification logs
 * in the WordPress admin area.
 *
 * @package Alertly
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<div class="wrap">
    <h1>Email Notification Logs</h1>
    <?php if (!empty($all_email_logs)): ?>
        <table class="widefat fixed">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Post Title</th>
                    <th>From Email</th>
                    <th>Emails Sent</th>
                    <th>Emails Skipped</th>
                    <th>Success</th>
                    <th>Failure</th>
                    <th>View Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_email_logs as $index => $log): ?>
                    <tr>
                        <td><a href="<?php echo get_permalink($log['post_id']); ?>" target="_blank"><?php echo esc_html($log['post_id']); ?></a></td>
                        <td><a href="<?php echo get_permalink($log['post_id']); ?>" target="_blank"><?php echo esc_html($log['post_title']); ?></a></td>
                        <td><?php echo esc_html($log['from_email']); ?></td>
                        <td><?php echo esc_html($log['sent_to']); ?></td>
                        <td><?php echo esc_html($log['skipped']); ?></td>
                        <td><?php echo esc_html($log['success']); ?></td>
                        <td><?php echo esc_html($log['failure']); ?></td>
                        <td><a href="<?php echo admin_url('admin.php?page=alertly-log-details&log_index=' . $index); ?>">View Details</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <!-- <tbody>
                <?php foreach ($all_email_logs as $index => $log): ?>
                    <tr>
                        <td><a href="<?php echo get_permalink($log['post_id']); ?>" target="_blank"><?php echo esc_html($log['post_id']); ?></a></td>
                        <td><a href="<?php echo get_permalink($log['post_id']); ?>" target="_blank"><?php echo esc_html($log['post_title']); ?></a></td>
                        <td><?php echo esc_html($log['from_email']); ?></td>
                        <td><?php echo esc_html($log['sent_to']); ?></td>
                        <td><?php echo esc_html($log['skipped']); ?></td>
                        <td><?php echo esc_html($log['success']); ?></td>
                        <td><?php echo esc_html($log['failure']); ?></td>
                        <td><a href="<?php echo admin_url('admin.php?page=alertly-log-details&log_index=' . $index); ?>">View Details</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody> -->
        </table>
    <?php else: ?>
        <p>No email logs found.</p>
    <?php endif; ?>
</div>
