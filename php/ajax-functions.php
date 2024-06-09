<?php


// =======================
// AJAX and Script-related Functions
// =======================


function create_lead() {
    // Check if all required fields are present
    if (isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['lead_source_type'], $_POST['lead_source_url'], $_POST['lead_pro'], $_POST['title'])) {
        $firstName = sanitize_text_field($_POST['firstName']);
        $lastName = sanitize_text_field($_POST['lastName']);
        $email = sanitize_email($_POST['email']);
        $lead_source_type = sanitize_text_field($_POST['lead_source_type']);
        $lead_source_url = esc_url_raw($_POST['lead_source_url']);
        $lead_pro = intval($_POST['lead_pro']);
        $title = sanitize_text_field($_POST['title']);
        $subject = intval($_POST['subject']);

        // Create a new post of type 'leads'
        $post_id = wp_insert_post([
            'post_title' => $title,
            'post_type' => 'leads',
            'post_status' => 'publish',
        ]);

        if ($post_id) {
            // Update ACF fields
            update_field('lead_first_name', $firstName, $post_id);
            update_field('lead_last_name', $lastName, $post_id);
            update_field('lead_mail', $email, $post_id);
            update_field('lead_source_type', $lead_source_type, $post_id);
            update_field('lead_source_url', $lead_source_url, $post_id);
            update_field('lead_pro', $lead_pro, $post_id);
            update_field('lead_experts', $subject, $post_id);

            wp_send_json_success(['message' => 'הטופס נשלח בהצלחה!']);
        } else {
            wp_send_json_error(['message' => 'שגיאה בשליחת הטופס']);
        }
    } else {
        wp_send_json_error(['message' => 'נא להשלים את השדות החסרים.']);
    }
}
add_action('wp_ajax_create_lead', 'create_lead');
add_action('wp_ajax_nopriv_create_lead', 'create_lead');
