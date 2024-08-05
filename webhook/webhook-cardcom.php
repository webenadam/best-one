<?php

/**
 * Cardcom webhook handling logic
 * This script processes incoming webhook requests, logs them, and more.
 */

// Include required functions
include_once get_template_directory() . '/webhook/webhook-cardcom-subscribe.php';
include_once get_template_directory() . '/webhook/webhook-best-subscribe.php';
include_once get_template_directory() . '/webhook/webhook-morning.php';

global $log_file;
$log_file = WP_CONTENT_DIR . '/webhook.log';

// ==========================================
// STEP 1: INITIALIZE AND GATHER DATA
// ==========================================

// Initialize request data
$request_data = '';
$content_type = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

// Process different content types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strpos($content_type, 'application/json') !== false) {
        $request_data = json_decode(file_get_contents('php://input'), true);
    } elseif (strpos($content_type, 'application/x-www-form-urlencoded') !== false || strpos($content_type, 'multipart/form-data') !== false) {
        $request_data = $_POST;
    } else {
        $request_data = file_get_contents('php://input');
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request_data = $_GET;
}



// ==========================================
// STEP 2: ERROR CHECKING AND VALIDATION
// ==========================================

// Check if ResponseCode is present and not 0
if (isset($request_data['ResponseCode']) && $request_data['ResponseCode'] !== '0') {
    $to = 'ben@benadam.co.il';
    $subject = 'Cardcom Webhook Error';
    $message = 'Raw request data: ' . print_r($request_data, true);
    $headers = 'From: webhook@example.com' . "\r\n" .
        'Reply-To: webhook@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - Error email sent for non-zero ResponseCode" . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);
}

// Check if lowprofilecode is provided
if (!isset($request_data['lowprofilecode']) || empty($request_data['lowprofilecode'])) {
    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - no lowprofilecode provided" . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);
    exit;
}

// ==========================================
// STEP 3: PROCESS RETURN VALUE
// ==========================================

if (isset($request_data['ReturnValue']) || isset($request_data['Recurring0_ReturnValue'])) {
    $returnValue = isset($request_data['ReturnValue']) ? $request_data['ReturnValue'] : $request_data['Recurring0_ReturnValue'];
    $startWithFirstPayment = strpos($returnValue, 'first_payment') === 0;
    $startWithCardcomSubscribed = strpos($returnValue, 'cardcom_subscribed') === 0;

    if ($startWithFirstPayment || $startWithCardcomSubscribed) {
        // Extract data from ReturnValue
        $parts = explode('-', $returnValue);
        $user_id = $parts[1] ?? null;
        $subscription_id = $parts[2] ?? null;
        $term_id = $parts[3] ?? null;
        $lowprofilecode = $request_data['lowprofilecode'] ?? null;
        $account_id = $request_data['AccountId'] ?? null;
        $recurring_id = $request_data['Recurring0_RecurringId'] ?? null;

        // ==========================================
        // STEP 4: VALIDATE EXTRACTED DATA
        // ==========================================

        if (!$user_id || !get_user_by('ID', $user_id)) {
            $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - no user found by the given user_id" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            exit;
        }

        $subscription = get_post($subscription_id);
        if (!$subscription || $subscription->post_type != 'subscriptions') {
            $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - no subscription is matching the returned subscription_id" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            exit;
        }
        

        if ($term_id) {
            $term = get_term_by('id', $term_id, 'expert');
            if (!$term) {
                $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - there is no matching expert term to the term_id returned" . PHP_EOL;
                file_put_contents($log_file, $log_data, FILE_APPEND);
                exit;
            }
        }

        // ==========================================
        // STEP 5: EXECUTE APPROPRIATE FUNCTIONS
        // ==========================================

        if ($startWithFirstPayment) {
            $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - Triggering cardcom_subscribe" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            
            best_subscribe($user_id, $subscription_id, $term_id, $lowprofilecode, $account_id, $recurring_id, $operation = 'create');
            cardcom_subscribe($user_id, $subscription_id, $term_id, $lowprofilecode);
            createReceipt($user_id, $subscription_id, $term_id, $lowprofilecode);
        } elseif ($startWithCardcomSubscribed) {
            $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - Triggering best_subscribe" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            best_subscribe($user_id, $subscription_id, $term_id, $lowprofilecode, $account_id, $recurring_id, $operation = 'update');
        }
    } else {
        $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - payment without 'first_payment' or 'cardcom_subscribed' in ReturnValue" . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
    }
} else {
    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom.php] - ReturnValue not provided" . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);
}
