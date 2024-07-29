<?php

/**
 * Cardcom webhook handling logic
 * This script processes incoming webhook requests, logs them, and more.
 */

// Ensure the request data is correctly initialized based on the method
$request_data = '';
$content_type = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

// Process different content types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strpos($content_type, 'application/json') !== false) {
        // Handle JSON POST data
        $request_data = json_decode(file_get_contents('php://input'), true);
    } elseif (strpos($content_type, 'application/x-www-form-urlencoded') !== false || strpos($content_type, 'multipart/form-data') !== false) {
        // Handle form-encoded data
        $request_data = $_POST;
    } else {
        // Handle any other raw POST data
        $request_data = file_get_contents('php://input');
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET data
    $request_data = $_GET;
}

// Log the request data
$log_file = WP_CONTENT_DIR . '/webhook.log';
$log_data = date('Y-m-d H:i:s') . " - " . json_encode($request_data) . PHP_EOL;
file_put_contents($log_file, $log_data, FILE_APPEND);

// Check if ReturnValue starts with "subscribe"
if (isset($request_data['ReturnValue']) && strpos($request_data['ReturnValue'], 'subscribe') === 0) {
    // Split ReturnValue into parts
    $parts = explode('-', $request_data['ReturnValue']);
    $user_id = $parts[1] ?? null;
    $subscription_id = $parts[2] ?? null;
    $term_id = $parts[3] ?? null;

    // Check for user
    if (!$user_id || !get_user_by('ID', $user_id)) {
        $log_data = "no user found by the given user_id";
        file_put_contents($log_file, $log_data, FILE_APPEND);
        exit;
    }

    // Check for subscription
    $subscription = get_post($subscription_id);
    if (!$subscription || $subscription->post_type != 'subscriptions') {
        $log_data = "no subscription is matching the returned subscription_id";
        file_put_contents($log_file, $log_data, FILE_APPEND);
        exit;
    }

    // Check for term (optional)
    if ($term_id) {
        $term = get_term_by('id', $term_id, 'expert');
        if (!$term) {
            $log_data = "there is no matching expert term to the term_id returned";
            file_put_contents($log_file, $log_data, FILE_APPEND);
            exit;
        }
    }


    // All checks passed, run subscribe function
    subscribe($user_id, $subscription_id, $term_id);
} else {
    // Log if ReturnValue does not start with "subscribe"
    if (isset($request_data['ReturnValue'])) {
        $log_data = "payment without 'subscribed' in ReturnValue";
        file_put_contents($log_file, $log_data, FILE_APPEND);
    }
}

function subscribe($user_id, $subscription_id, $term_id = null)
{
    $log_file = WP_CONTENT_DIR . '/webhook.log';
    $log_data = "user: $user_id, has been subscribed to the $subscription_id subscription";
    if ($term_id) {
        $log_data .= " for the term: $term_id";
    }
    $log_data .= PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);
}
