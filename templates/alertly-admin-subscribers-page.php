<?php
/**
 * Alertly Admin Subscribers Page Template
 *
 * This template is used to manage subscribers in the WordPress admin area.
 *
 * @package Alertly
 */

if (!defined('ABSPATH'))
 {
    exit; // Exit if accessed directly.
}
?>

<div class="wrap">
    <h1>Manage Subscribers</h1>

    <h2>Add New Subscriber</h2>
    <form method="POST">
        <?php wp_nonce_field('alertly_add_subscriber', 'alertly_add_subscriber_nonce'); ?>
        <table class="form-table">
            <tr>
                <th><label for="name">Name</label></th>
                <td><input type="text" id="name" name="name" class="regular-text" required></td>
            </tr>
            <tr>
                <th><label for="email">Email</label></th>
                <td><input type="email" id="email" name="email" class="regular-text" required></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="Add Subscriber">
        </p>
    </form>

    <h2>Subscribers List</h2>
    <table class="widefat fixed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subscribers)): ?>
                <?php foreach ($subscribers as $subscriber): ?>
                    <tr>
                        <td><?php echo esc_html($subscriber->id); ?></td>
                        <td><?php echo esc_html($subscriber->name); ?></td>
                        <td><?php echo esc_html($subscriber->email); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <?php wp_nonce_field('alertly_delete_subscriber', 'alertly_delete_subscriber_nonce'); ?>
                                <input type="hidden" name="subscriber_id" value="<?php echo esc_attr($subscriber->id); ?>">
                                <input type="submit" class="button button-secondary" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No subscribers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
