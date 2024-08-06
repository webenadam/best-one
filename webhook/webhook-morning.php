<?php

global $log_file, $token_file;
$log_file = WP_CONTENT_DIR . '/webhook.log'; // Log file path
$token_file = WP_CONTENT_DIR . '/morning_token.json'; // Token file path

// Function to get the Morning token
function getMorningToken($api_key, $api_secret) {
    global $token_file, $log_file;

    // Request a new token
    $url = 'https://sandbox.d.greeninvoice.co.il/api/v1/account/token'; // API endpoint for token

    $data = [
        'id' => $api_key, // API key
        'secret' => $api_secret // API secret
    ];

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set POST fields

    $response = curl_exec($ch); // Execute cURL request
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch); // Capture cURL error
    }
    curl_close($ch);

    if (isset($error_msg)) {
        // Log error if cURL fails
        $log_data = date('Y-m-d H:i:s') . " [getMorningToken] - Error getting token. Error: " . $error_msg . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        return null;
    }

    $response = json_decode($response, true); // Decode JSON response

    // Log the full response for debugging
    $log_data = date('Y-m-d H:i:s') . " [getMorningToken] - Token response: " . json_encode($response) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    if (isset($response['token'])) {
        // Log the token expiration assumption for debugging
        $expires_in = isset($response['expires_in']) ? $response['expires_in'] : 86400; // Use 'expires_in' if provided, default to 24 hours
        $log_data = date('Y-m-d H:i:s') . " [getMorningToken] - Token expires in: " . $expires_in . " seconds" . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);

        // Save new token and its expiry time
        $token_data = [
            'token' => $response['token'],
            'expires_at' => time() + $expires_in // Use provided 'expires_in' value
        ];
        file_put_contents($token_file, json_encode($token_data));
        return $response['token']; // Return new token
    }

    // Log error if token response is invalid
    $log_data = date('Y-m-d H:i:s') . " [getMorningToken] - Error in token response: " . json_encode($response) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    return null;
}


// Function to create a receipt
function createReceipt($user_id, $subscription_id, $term_id = null, $lowprofilecode = null)
{
    global $log_file;

    // ==========================================
    // STEP 1: GATHER AND SET ALL DATA
    // ==========================================

    // Static Variables
    $api_key = '4e26e833-89d2-411b-bd50-4034edbc552a'; // API key
    $api_secret = 'YNDcEpVRhJ_ATxShsdkp1A'; // API secret
    $webhook_url = 'https://best-1.co.il/webhook'; // Webhook URL

    // Get Token
    $token = getMorningToken($api_key, $api_secret);
    if (!$token) {
        echo "Error obtaining token.";
        return;
    }

    // Green Invoice API endpoint for creating documents
    $url = 'https://sandbox.d.greeninvoice.co.il/api/v1/documents';

    // Fetch user details
    $user_info = get_userdata($user_id);
    if (!$user_info) {
        // Log error if user is not found
        $log_data = date('Y-m-d H:i:s') . " [webhook-morning.php] - User not found for ID: $user_id" . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        echo "User not found.";
        return;
    }

    // Gather client details and product information
    $client_email = $user_info->user_email; // Client's email
    $client_name = $user_info->display_name; // Client's name
    $product_description = get_field('subscription_english_description', $subscription_id); // Product description
    $amount = number_format((float)get_field('subscription_price', $subscription_id), 2, '.', ''); // Subscription price formatted to 2 decimal places
    

    // ==========================================
    // STEP 2: PREPARE AND LOG DATA
    // ==========================================

    // Prepare data for the receipt
    $data = [
        'client' => [
            'name' => $client_name, // Client's name
            'emails' => [$client_email], // Client's email
        ],
        'income' => [
            [
                'description' => $product_description, // Description of the service/product
                'price' => (float)$amount, // Amount in ILS formatted to 2 decimal places as a float
                'currency' => 'ILS', // Currency code
                'vatType' => 2, // Ensuring VAT type is included for each item
                'quantity' => 1,
            ]
        ],
        'type' => 320, // Document type: 320 (Tax Invoice Receipt)
        'vatType' => 2, // VAT type: 2 (Excluding VAT, will be added by the system)
        'date' => date('Y-m-d'), // Document date
        'signed' => true, // Whether the document is signed
        'attachment' => true, // Whether to attach the document
        'lang' => 'he', // Language of the document
        'payment' => [
            'type' => 3, // Payment method: 3 (Credit Card)
            'date' => date('Y-m-d'), // Payment date
            'price' => (float)$amount,
            'currency' => 'ILS',
        ],
        'footer' => 'כאן בשביל הקידום שלך - בסט-1.', // Footer text for the document
        'rounding' => false, // Whether to round the total amount (optional)
        'discount' => 0, // Discount amount (optional)
        'currency' => 'ILS', // Currency code
        'currencyRate' => 1, // Currency exchange rate: 1 indicates no exchange rate is applied
        'webhook' => $webhook_url, // Webhook URL for receiving updates
        'remarks' => 'קוד תשלום בקארדקום: ' . $lowprofilecode // Adding lowprofilecode as a note (optional)
    ];

    // Log request data
    $log_data = date('Y-m-d H:i:s') . " [webhook-morning.php] - Sending data to Green Invoice: " . json_encode($data) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    // ==========================================
    // STEP 3: SEND REQUEST TO GREEN INVOICE
    // ==========================================

    // Send request using cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set POST fields

    $response = curl_exec($ch); // Execute cURL request
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP response code
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch); // Capture cURL error
    }
    curl_close($ch);

    // ==========================================
    // STEP 4: LOG AND PROCESS RESPONSE
    // ==========================================

    // Log and process response
    if (isset($error_msg)) {
        // Log error if cURL fails
        $log_data = date('Y-m-d H:i:s') . " [webhook-morning.php] - Error creating receipt for User ID: $user_id, Subscription ID: $subscription_id. HTTP Code: $http_code. Error: " . $error_msg . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        return 'Error creating receipt';
    }

    $response = json_decode($response, true); // Decode JSON response
    if (isset($response['errorMessage'])) {
        // Log error if response contains an error message
        $log_data = date('Y-m-d H:i:s') . " [webhook-morning.php] - Error from Green Invoice API: " . $response['errorMessage'] . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        return 'Error creating receipt';
    }

    // Log success response
    $log_data = date('Y-m-d H:i:s') . " [webhook-morning.php] - Receipt created successfully for User ID: $user_id, Subscription ID: $subscription_id. Response: " . json_encode($response) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    return $response;
}
