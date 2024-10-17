<div class="wrap">
    <h1><?php _e('Manage Campaigns', 'alertly'); ?></h1>
    <form method="post">
        <?php wp_nonce_field('alertly_add_campaign', 'alertly_add_campaign_nonce'); ?>
        <label for="campaign_name"><?php _e('Campaign Name:', 'alertly'); ?></label>
        <input type="text" name="campaign_name" id="campaign_name" required />

        <h3><?php _e('Assign Post Types:', 'alertly'); ?></h3>
        <?php foreach ($post_types as $post_type): ?>
            <label>
                <input type="checkbox" name="post_types[]" value="<?php echo esc_attr($post_type->name); ?>">
                <?php echo esc_html($post_type->labels->name); ?>
            </label><br>
        <?php endforeach; ?>

        <label for="email_subject"><?php _e('Email Subject:', 'alertly'); ?></label>
        <input type="text" name="email_subject" id="email_subject" required />

        <label for="email_template"><?php _e('Email Template:', 'alertly'); ?></label>
        <textarea name="email_template" id="email_template" rows="10" required></textarea>

        <input type="submit" value="<?php _e('Create Campaign', 'alertly'); ?>" class="button button-primary" />
    </form>

    <h2><?php _e('Existing Campaigns', 'alertly'); ?></h2>
    <?php if (!empty($campaigns)): ?>
        <ul>
            <?php foreach ($campaigns as $campaign): ?>
                <li><?php echo esc_html($campaign['name']); ?> (<?php echo implode(', ', $campaign['post_types']); ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><?php _e('No campaigns found.', 'alertly'); ?></p>
    <?php endif; ?>
</div>
