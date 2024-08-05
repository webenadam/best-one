<?php

/**
 * WEBHOOK HANDLER
 * This file sets up and processes incoming webhook requests.
 */

// ==========================================
// STEP 1: SET UP WEBHOOK ENDPOINT
// ==========================================
// Configure WordPress to recognize our custom webhook URL

add_action('init', 'create_webhook_endpoint');
function create_webhook_endpoint() {
    add_rewrite_rule('^webhook/?$', 'index.php?webhook=1', 'top');
}

add_filter('query_vars', 'add_webhook_query_var');
function add_webhook_query_var($vars) {
    $vars[] = 'webhook';
    return $vars;
}


// ==========================================
// STEP 2: HANDLE WEBHOOK REQUEST
// ==========================================
// Process incoming requests to our webhook endpoint

add_action('template_redirect', 'handle_webhook_request');
function handle_webhook_request() {
    global $wp_query, $log_file;

    // Check if this is a webhook request
    if (!isset($wp_query->query_vars['webhook'])) {
        return;
    }

    $log_file = WP_CONTENT_DIR . '/webhook.log';

    // ==========================================
    // STEP 3: GATHER REQUEST DATA
    // ==========================================
    // Collect the incoming webhook data

    $request_data = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $request_data = json_decode(file_get_contents('php://input'), true);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $request_data = $_GET;
    }

    // ==========================================
    // STEP 4: LOG REQUEST DATA
    // ==========================================
    // Record the raw request data for debugging

    $log_data = date('Y-m-d H:i:s') . " [webhook.php] - Raw request data: " . json_encode($request_data) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    // ==========================================
    // STEP 5: ROUTE REQUEST
    // ==========================================
    // Determine which specific webhook handler to use

    if (isset($request_data['terminalnumber']) && (isset($request_data['ReturnValue']) || isset($request_data['Recurring0_ReturnValue']))) {
        // Cardcom-specific webhook
        include_once get_template_directory() . '/webhook/webhook-cardcom.php';
    } else {
        // General webhook listener
        include_once get_template_directory() . '/webhook/webhook-listener.php';
    }

    // ==========================================
    // STEP 6: SEND RESPONSE
    // ==========================================
    // Confirm successful processing of the webhook

    http_response_code(200);
    echo 'Webhook processed successfully.';
    exit;
}

// ==========================================
// STEP 7: UPDATE REWRITE RULES
// ==========================================
// Ensure WordPress recognizes our custom endpoint when the theme is activated

add_action('after_switch_theme', 'flush_rewrite_rules');
