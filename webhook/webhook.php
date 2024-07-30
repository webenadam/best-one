<?php

/**
 * Create a custom endpoint for the webhook.
 */
add_action('init', 'create_webhook_endpoint');
function create_webhook_endpoint() {
    // Add a rewrite rule for the endpoint /webhook
    add_rewrite_rule('^webhook/?$', 'index.php?webhook=1', 'top');
}

/**
 * Add the webhook query variable so WordPress recognizes it.
 */
add_filter('query_vars', 'add_webhook_query_var');
function add_webhook_query_var($vars) {
    // Add the 'webhook' query variable
    $vars[] = 'webhook';
    return $vars;
}

/**
 * Handle the webhook request by processing the request data and redirecting to appropriate handler files.
 */
add_action('template_redirect', 'handle_webhook_request');
function handle_webhook_request() {
    global $wp_query, $log_file;

    $log_file = WP_CONTENT_DIR . '/webhook.log';

    // Check if the 'webhook' query variable is set
    if (isset($wp_query->query_vars['webhook'])) {
        // Initialize request data
        $request_data = [];

        // Determine if it's a POST or GET request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $request_data = json_decode(file_get_contents('php://input'), true);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $request_data = $_GET;
        }

        // Log the raw request data
        $log_data = date('Y-m-d H:i:s') . " - Raw request data: " . json_encode($request_data) . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);

        // Route the request to the appropriate handler file
        if (isset($request_data['TerminalNumber']) && isset($request_data['ReturnValue'])) {
            // Use webhook-cardcom.php file to handle the request
            include_once get_template_directory() . '/webhook/webhook-cardcom.php';
        } else {
            // Use webhook-listener.php file for general handling
            include_once get_template_directory() . '/webhook/webhook-listener.php';
        }

        // Send a 200 OK response
        http_response_code(200);

        // Output a response if necessary
        echo 'Webhook processed successfully.';

        // Stop further execution to ensure response is handled by the included file
        exit;
    }
}

// Flush rewrite rules upon theme activation to ensure the new endpoint is recognized
add_action('after_switch_theme', 'flush_rewrite_rules');
