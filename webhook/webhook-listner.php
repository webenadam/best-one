<?php
/**
 * General webhook handling logic
 * This script processes incoming webhook requests and logs them.
 */

// Ensure the request data is correctly initialized based on the method
$request_data = '';
$content_type = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

// Process different content types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strpos($content_type, 'application/json') !== false) {
        // Handle JSON POST data
        $request_data = file_get_contents('php://input');
    } elseif (strpos($content_type, 'application/x-www-form-urlencoded') !== false || strpos($content_type, 'multipart/form-data') !== false) {
        // Handle form-encoded data
        $request_data = http_build_query($_POST);
    } else {
        // Handle any other raw POST data
        $request_data = file_get_contents('php://input');
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET data
    $request_data = http_build_query($_GET);
}

// Log the request data
$log_file = WP_CONTENT_DIR . '/webhook.log';
$log_data = date('Y-m-d H:i:s') . " - " . $request_data . PHP_EOL;
file_put_contents($log_file, $log_data, FILE_APPEND);
