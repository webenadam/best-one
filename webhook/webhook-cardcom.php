<?php

/**
 * Cardcom webhook handling logic
 * This script processes incoming webhook requests, logs them, and more.
 */

// Include cardcom subscription creation function
include_once get_template_directory() . '/webhook/webhook-cardcom-subscribe.php';

// Include Best subscription creation function
include_once get_template_directory() . '/webhook/webhook-best-subscribe.php';

global $log_file;
$log_file = WP_CONTENT_DIR . '/webhook.log';

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
$log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - Request data: " . json_encode($request_data) . PHP_EOL;
file_put_contents($log_file, $log_data, FILE_APPEND);

// Check if lowprofilecode is provided
if (!isset($request_data['lowprofilecode']) || empty($request_data['lowprofilecode'])) {
    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - no lowprofilecode provided" . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);
    exit;
}

// Check if ReturnValue starts with "first_payment" or "subscribed"
if (isset($request_data['ReturnValue'])) {
    $startWithFirstPayment = strpos($request_data['ReturnValue'], 'first_payment') === 0;
    $startWithSubscribed = strpos($request_data['ReturnValue'], 'subscribed') === 0;

    if ($startWithFirstPayment || $startWithSubscribed) {
        // Split ReturnValue into parts
        $parts = explode('-', $request_data['ReturnValue']);
        $user_id = $parts[1] ?? null;
        $subscription_id = $parts[2] ?? null;
        $term_id = $parts[3] ?? null;
        $lowprofilecode = $request_data['lowprofilecode'] ?? null;

        // Check for user
        if (!$user_id || !get_user_by('ID', $user_id)) {
            $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - no user found by the given user_id" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            exit;
        }

        // Check for subscription
        $subscription = get_post($subscription_id);
        if (!$subscription || $subscription->post_type != 'subscriptions') {
            $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - no subscription is matching the returned subscription_id" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            exit;
        }

        // Check for term (optional)
        if ($term_id) {
            $term = get_term_by('id', $term_id, 'expert');
            if (!$term) {
                $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - there is no matching expert term to the term_id returned" . PHP_EOL;
                file_put_contents($log_file, $log_data, FILE_APPEND);
                exit;
            }
        }

        // All checks passed, determine the action based on the starting keyword of ReturnValue
        if ($startWithFirstPayment) {
            $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - Triggering cardcom_subscribe" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            cardcom_subscribe($user_id, $subscription_id, $term_id, $lowprofilecode);
        } elseif ($startWithSubscribed) {
            $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - Triggering best_subscribe" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            best_subscribe($user_id, $subscription_id, $term_id, $lowprofilecode);
        }
    } else {
        // Log if ReturnValue does not start with "first_payment" or "subscribed"
        $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - payment without 'first_payment' or 'subscribed' in ReturnValue" . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
    }
} else {
    // Handle cases where ReturnValue is not set at all
    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - ReturnValue not provided" . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);
}
