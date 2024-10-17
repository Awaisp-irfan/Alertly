<?php

namespace ALERTLY\Includes;

use ALERTLY\Includes\Traits\Singleton;

/**
 * Class Alertly_Checks
 * Handles the health checks for hosting, domain, SMTP, SPF, DKIM, and DMARC.
 */
class Alertly_Checks {
    use Singleton;

    /**
     * Display the checks page.
     */
    public function display_checks_page() {
        // Fetch data for hosting provider, domain registrar, SMTP, SPF, DKIM, DMARC
        $hosting_provider = $this->get_hosting_provider();
        // $domain_registrar = $this->get_domain_registrar();
        $smtp_status = $this->check_smtp_connection();
        $spf_record = $this->get_spf_record();
        $dkim_record = $this->get_dkim_record();
        $dmarc_record = $this->get_dmarc_record();

        // Include the template to display the results
        include ALERTLY_TEMPLATES_DIR . 'alertly-checks-page.php';
    }

    /**
     * Get Hosting Provider using an external API (e.g., ipinfo.io)
     */
    private function get_hosting_provider() {
        $ip = $_SERVER['SERVER_ADDR']; // Get server IP
        $response = wp_remote_get('https://ipinfo.io/' . $ip . '/json');
        $data = wp_remote_retrieve_body($response);
        return json_decode($data, true)['org'] ?? 'Unknown';
    }

    /**
     * Get Domain Registrar using WHOIS data
     */
    // private function get_domain_registrar() {
    //     $domain = $_SERVER['SERVER_NAME'];
    
    //     // Replace with your actual API key from WhoisXML API
    //     $api_key = 'your_api_key_here';
        
    //     // WhoisXML API URL with the API key and domain query
    //     $url = 'https://www.whoisxmlapi.com/whoisserver/WhoisService?apiKey=' . $api_key . '&domainName=' . $domain . '&outputFormat=json';
    
    //     // Make the API request
    //     $response = wp_remote_get($url);
    
    //     // Check if the response contains an error
    //     if (is_wp_error($response)) {
    //         return 'Error fetching domain registrar: ' . $response->get_error_message();
    //     }
    
    //     // Retrieve the body of the response
    //     $data = wp_remote_retrieve_body($response);
    
    //     // Decode the JSON response into an associative array
    //     $decoded = json_decode($data, true);
    
    //     // Check if registrar information is present
    //     if (!empty($decoded['WhoisRecord']['registrarName'])) {
    //         return $decoded['WhoisRecord']['registrarName'];
    //     } else {
    //         return 'Unknown registrar';
    //     }
    // }
    
    

    /**
     * Check SMTP connection
     */
    private function check_smtp_connection() {
        // Set up the test email
        $to = get_option('admin_email'); // Send email to the site admin
        $subject = 'SMTP Test';
        $message = 'This is a test email to check the SMTP configuration.';
        $headers = ['Content-Type: text/html; charset=UTF-8'];
    
        // Use wp_mail to send the test email
        $result = wp_mail($to, $subject, $message, $headers);
    
        // Check if wp_mail returned true (successful)
        if ($result) {
            return 'SMTP is connected ';
        } else {
            return 'SMTP connection failed';
        }
    }
    
    
    

    /**
     * Check for SPF record
     */
    private function get_spf_record() {
        $domain = $_SERVER['SERVER_NAME'];
        $records = dns_get_record($domain, DNS_TXT);
    
        foreach ($records as $record) {
            // Check for the SPF string in the TXT record
            if (isset($record['txt']) && strpos($record['txt'], 'v=spf1') === 0) {
                // return 'SPF Record: ' . $record['txt'];
                return 'SPF Record is found ' ;
            }
        }
    
        // If no SPF record is found
        return 'No SPF record found.';
    }
    

    /**
     * Check for DKIM record
     */
    private function get_dkim_record() {
        $domain = $_SERVER['SERVER_NAME'];
    
        // First, check if the user has set a custom DKIM selector
        $custom_selector = get_option('dkim_selector', '');  // Fetch from plugin settings
        $selectors = [];
    
        // If a custom selector is provided, use it first
        if (!empty($custom_selector)) {
            $selectors[] = $custom_selector;
        }
    
        // Add common selectors (used by various email providers like Google, Microsoft, and others)
        $selectors = array_merge($selectors, ['default', 'mail', 'selector1', 'selector2', 'google', 'hostingermail-a', 'hostingermail-b', 'hostingermail-c']);
    
        foreach ($selectors as $selector) {
            $dkim_domain = $selector . '._domainkey.' . $domain;
    
            // Step 1: Try fetching DKIM directly as a TXT record
            $txt_records = dns_get_record($dkim_domain, DNS_TXT);
            if (!empty($txt_records)) {
                // return 'DKIM Record for selector (' . $selector . '): ' . $txt_records[0]['txt'];
                return 'DKIM Record is found ';
            }
    
            // Step 2: If no TXT record, try fetching a CNAME record
            $cname_records = dns_get_record($dkim_domain, DNS_CNAME);
            if (!empty($cname_records) && isset($cname_records[0]['target'])) {
                $target_domain = $cname_records[0]['target'];
    
                // Step 3: Fetch the TXT record from the target domain (following the CNAME)
                $dkim_txt_records = dns_get_record($target_domain, DNS_TXT);
                if (!empty($dkim_txt_records)) {
                    // return 'DKIM Record for selector (' . $selector . '): ' . $dkim_txt_records[0]['txt'];
                    return 'DKIM Record is found';
                }
            }
    
            // Log that no DKIM record was found for this selector (for debugging purposes)
            error_log("No DKIM record found for selector: $selector (on domain: $dkim_domain)");
        }
    
        // Step 4: If no records found for any selector, return a user-friendly message
        return 'No DKIM record found. Please check your DKIM setup ';
    }
    
    
    
    

    /**
     * Check for DMARC record
     */
    private function get_dmarc_record() {
        $domain = '_dmarc.' . $_SERVER['SERVER_NAME'];
        $records = dns_get_record($domain, DNS_TXT);
    
        if (!empty($records)) {
            foreach ($records as $record) {
                // Check if it's a DMARC policy record
                if (isset($record['txt']) && strpos($record['txt'], 'v=DMARC1') === 0) {
                    // return 'DMARC Record: ' . $record['txt'];
                    return 'DMARC Record is found';
                }
            }
        }
    
        // If no DMARC record is found
        return 'No DMARC record found. ';
    }
    /**
     * This function will be utilized to display all the available post types while creating or editing campaigns.
     */
    // public function get_all_post_types(){
    //     $args = [
    //         'public' => true , 
    //         '_button' => false,
    //     ];
    
    //     return get_post_types($args, 'objects');
    // }
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alertly_health_check_refresh'])) {
    // Re-run the checks if the refresh button is clicked
    $hosting_provider = $this->get_hosting_provider();
    // $domain_registrar = $this->get_domain_registrar();
    $smtp_status = $this->check_smtp_connection();
    $spf_record = $this->get_spf_record();
    $dkim_record = $this->get_dkim_record();
    $dmarc_record = $this->get_dmarc_record();
}


