

<?php
/**
 * Alertly Admin Log Details Page Template
 *
 * This template displays detailed information about a specific email notification log in the WordPress admin area.
 * It includes details such as the post ID, title, email statistics, and more.
 *
 * @package Alertly
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Display detailed log information if available.
 */
if (isset($_GET['log_index'])): ?>
    <?php
    $log_index = intval($_GET['log_index']);
    if (isset($all_email_logs[$log_index])) {
        $log = $all_email_logs[$log_index];
    ?>
    <div class="wrap">
        <h1>Email Log Details for Post ID: <a href="<?php echo get_permalink($log['post_id']); ?>" target="_blank"><?php echo esc_html($log['post_id']); ?></a></h1>
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
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="<?php echo get_permalink($log['post_id']); ?>" target="_blank"><?php echo esc_html($log['post_id']); ?></a></td>
                    <td><a href="<?php echo get_permalink($log['post_id']); ?>" target="_blank"><?php echo esc_html($log['post_title']); ?></a></td>
                    <td><?php echo esc_html($log['from_email']); ?></td>
                    <td><?php echo esc_html($log['sent_to']); ?></td>
                    <td><?php echo esc_html($log['skipped']); ?></td>
                    <td><?php echo esc_html($log['success']); ?></td>
                    <td><?php echo esc_html($log['failure']); ?></td>
                </tr>
            </tbody>
        </table>
        <h2>Emails Sent To</h2>
        <ul>
            <?php foreach ($log['emails'] as $email): ?>
                <li><?php echo esc_html($email); ?></li>
            <?php endforeach; ?>
        </ul>
        <h2>Log Details</h2>
        <ul>
            <?php foreach ($log['log_details'] as $detail): ?>
                <li><?php echo esc_html($detail); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php } ?>
<?php endif; ?>
