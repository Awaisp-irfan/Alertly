<div class="wrap">
    <h1><?php _e('Create New Campaign', 'alertly'); ?></h1>
    <form method="post" action="">
        <?php wp_nonce_field('alertly_create_campaign', 'alertly_create_campaign_nonce'); ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="campaign_name"><?php _e('Campaign Name', 'alertly'); ?></label></th>
                <td>
                    <input type="text" id="campaign_name" name="campaign_name" class="regular-text" required />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="campaign_description"><?php _e('Campaign Description', 'alertly'); ?></label></th>
                <td>
                    <textarea id="campaign_description" name="campaign_description" rows="5" class="large-text"></textarea>
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="submit" name="submit_campaign_overview" class="button-primary" value="<?php _e('Next Step', 'alertly'); ?>" />
        </p>
    </form>
</div>
