<div class="wrap">
    <h1>Domain & SMTP Health Check</h1>
    
    <h2>Hosting Provider</h2>
    <p><?php echo esc_html($hosting_provider); ?></p>

    <!-- <h2>Domain Registrar</h2>
    <p>
     
    <?php /** echo esc_html($domain_registrar); */?> 
    
    </p> -->

    <h2>SMTP Status</h2>
    <p><?php echo esc_html($smtp_status); ?></p>

    <h2>SPF Record</h2>
    <p><?php echo esc_html($spf_record); ?></p>

    <h2>DKIM Record</h2>
    <p><?php echo esc_html($dkim_record); ?></p>

    <h2>DMARC Record</h2>
    <p><?php echo esc_html($dmarc_record); ?></p>

     <!-- Add a button to refresh the health check -->
     <!-- <form method="post">
        <input type="hidden" name="alertly_health_check_refresh" value="1" />
        <?php submit_button('Refresh Health Check'); ?>
    </form> -->
</div>
