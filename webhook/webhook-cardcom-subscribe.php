<?php

/**
 * Cardcom webhook subscription function (after userid, subscription id, term id (optional) checks)
 */

global $log_file;
$log_file = WP_CONTENT_DIR . '/webhook.log';

function cardcom_subscribe($user_id, $subscription_id, $term_id = null, $lowprofilecode = null)
{
    global $log_file;

    // ==========================================
    // STEP 1: GATHER AND SET ALL DATA
    // ==========================================

    // Static Variables
    $TerminalNumber = 1000; // Company terminal
    $UserName = 'test2025'; // API User
    $OperationAdd = "NewAndUpdate"; // Operation type

    // Dynamic Variables
    $lowprofilecode = $lowprofilecode; // LowProfileDealGuid

    // Fetch user details
    $user_info = get_userdata($user_id);
    if (!$user_info) {
        $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php] - User not found for ID: $user_id" . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        echo "User not found.";
        return;

    }

    $client_email = $user_info->user_email;
    $client_name = $user_info->display_name;
    $client_id = $user_id;
    $product_description = get_field('subscription_english_description', $subscription_id);
    $subscription_length = get_field('subscription_commitment', $subscription_id);

    // Prepare data for CardCom
    $vars = array(
        'terminalnumber' => $TerminalNumber,
        'UserName' => $UserName,
        'codepage' => '65001', // Unicode
        'Operation' => $OperationAdd,
        'LowProfileDealGuid' => $lowprofilecode,
        'Account.Email' => $client_email,
        'Account.CompanyName' => $client_name,
        'RecurringPayments.InternalDecription' => $product_description,
        'RecurringPayments.FlexItem.InvoiceDescription' => $product_description,
        'RecurringPayments.FlexItem.Price' => get_field('subscription_price', $subscription_id),
        'RecurringPayments.NextDateToBill' => date("d/m/Y", strtotime("+1 month")),
        'RecurringPayments.TotalNumOfBills' => $subscription_length, // TODO: or do we want it 99999 ?
        'RecurringPayments.FinalDebitCoinId' => '1',
        'RecurringPayments.ReturnValue' => "cardcom_subscribed-$client_id-$subscription_id" . ($term_id ? "-$term_id" : ''),
        'RecurringPayments.FlexItem.IsPriceIncludeVat' => 'false'
    );

    // ==========================================
    // STEP 2: LOG PREPARED DATA
    // ==========================================

    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php] - Sending data to CardCom: " . json_encode($vars) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    // ==========================================
    // STEP 3: SEND REQUEST TO CARDCOM
    // ==========================================

    $r = PostVars($vars, 'https://secure.cardcom.solutions/Interface/RecurringPayment.aspx');
    parse_str($r, $responseArray);

    // ==========================================
    // STEP 4: LOG AND PROCESS RESPONSE
    // ==========================================

    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php] - CardCom response: " . json_encode($responseArray) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    // Check for errors in response
    if (strpos($r, 'Object_moved') !== false) {
        $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php] - CardCom response error (Object_moved): " . $r . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
    }

    // ==========================================
    // STEP 5: EVALUATE RESPONSE AND RETURN RESULT
    // ==========================================

    if ($responseArray['ResponseCode'] == "0") {
        echo "Recurring Payment created successfully.";
        best_subscribe($client_id, $subscription_id, $term_id, $lowprofilecode, $responseArray['AccountId'], $responseArray['Recurring0_RecurringId'], 'update');
    } else {
        $error_message = isset($responseArray['Description']) ? $responseArray['Description'] : 'Unknown error';
        echo "Error creating Recurring Payment: " . $error_message;
    }
}

function PostVars($vars, $PostVarsURL)
{
    global $log_file;

    // ==========================================
    // STEP 1: PREPARE REQUEST
    // ==========================================

    $urlencoded = http_build_query($vars);
    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php-PostVars()] - Data: " . $urlencoded . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    // ==========================================
    // STEP 2: SEND REQUEST USING CURL
    // ==========================================

    if (function_exists("curl_init")) {
        $CR = curl_init();
        curl_setopt($CR, CURLOPT_URL, $PostVarsURL);
        curl_setopt($CR, CURLOPT_POST, 1);
        curl_setopt($CR, CURLOPT_FAILONERROR, true);
        curl_setopt($CR, CURLOPT_POSTFIELDS, $urlencoded);
        curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($CR, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($CR, CURLOPT_VERBOSE, true);

        $response = curl_exec($CR);
        $curl_error = curl_error($CR);
        $curl_info = curl_getinfo($CR);


        // ==========================================
        // STEP 3: HANDLE ERRORS AND RETURN RESPONSE
        // ==========================================

        if (!empty($curl_error)) {
            echo $curl_error;
            die();
        }

        curl_close($CR);
        return $response;
    } else {
        $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php-PostVars()] - cURL not available." . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        echo "No curl_init";
        die();
    }
}
