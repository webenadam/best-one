<?php

/**
 * Create a custom endpoint for the webhook
 */
add_action('init', 'create_webhook_endpoint');
function create_webhook_endpoint() {
    // Add a rewrite rule for the endpoint /webhook
    add_rewrite_rule('^webhook/?$', 'index.php?webhook=1', 'top');
}

/**
 * Add the webhook query variable so WordPress recognizes it
 */
add_filter('query_vars', 'add_webhook_query_var');
function add_webhook_query_var($vars) {
    // Add the 'webhook' query variable
    $vars[] = 'webhook';
    return $vars;
}

/**
 * Handle the webhook request by processing the request data and sending an email
 */
add_action('template_redirect', 'handle_webhook_request');
function handle_webhook_request() {
    global $wp_query;

    // Check if the 'webhook' query variable is set
    if (isset($wp_query->query_vars['webhook'])) {
        // Set the email address where the webhook data will be sent
        $email_to = "ben@benadam.co.il";

        // Initialize request data
        $request_data = '';

        // Check if it is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the raw POST data sent to the webhook
            $request_data = file_get_contents('php://input');
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Get the GET data
            $request_data = http_build_query($_GET);
        }

        // Set the email subject
        $email_subject = "Webhook Notification";

        // Set the email headers
        $headers = "From: no-reply@" . $_SERVER['SERVER_NAME'] . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send the email with the webhook data
        if (mail($email_to, $email_subject, $request_data, $headers)) {
            // If email is successfully sent, return a 200 OK response
            http_response_code(200);
            echo "Webhook received and email sent.";
        } else {
            // If email sending fails, return a 500 Internal Server Error response
            http_response_code(500);
            echo "Failed to send email.";
        }

        // Stop further execution
        exit;
    }
}

// Flush rewrite rules upon theme activation to ensure the new endpoint is recognized
add_action('after_switch_theme', 'flush_rewrite_rules');
