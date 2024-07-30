<?php

/**
 * Cardcom webhook subscription function (after userid, subscription id, term id (optional) checks)
 */

global $log_file;
$log_file = WP_CONTENT_DIR . '/webhook.log';

function cardcom_subscribe($user_id, $subscription_id, $term_id = null, $lowprofilecode = null)
{
    global $log_file;

    // Static Vars
    $TerminalNumber = 1000; // Company terminal
    $UserName = 'test2025'; // API User
    $OperationAdd = "NewAndUpdate"; // Operation type

    // Dynamic Vars
    $lowprofilecode = $lowprofilecode; // LowProfileDealGuid

    // Fetch user details
    $user_info = get_userdata($user_id);
    if (!$user_info) {
        echo "User not found.";
        return;
    }

    $client_email = $user_info->user_email; // User's email
    $client_name = $user_info->display_name; // User's display name
    $client_id = $user_id;
    $product_description = get_the_title($subscription_id);

    // Add New Account, new Payment Info, new recurring payment
    $vars = array(
        'TerminalNumber' => $TerminalNumber,
        'RecurringPayments.ChargeInTerminal' => $TerminalNumber,
        'UserName' => $UserName,
        'codepage' => '65001', // Unicode
        'Operation' => $OperationAdd,
        'LowProfileDealGuid' => $lowprofilecode,
        'Account.CompanyName' => $client_name, // Name of the account/company
        'Account.Email' => $client_email,
        'RecurringPayments.InternalDecription' => $product_description, // Internal description for the recurring payment
        'RecurringPayments.FlexItem.InvoiceDescription' => $product_description, // Invoice description
        'RecurringPayments.NextDateToBill' => date("d/m/Y", strtotime("+1 month")), // Next billing date
        'RecurringPayments.TotalNumOfBills' => '999999', // Number of times to bill the account
        'RecurringPayments.FinalDebitCoinId' => '1', // Currency: 1 - NIS, 2 - USD, else ISO currency
        'RecurringPayments.ReturnValue' => "subscribed-$client_id-$subscription_id" . ($term_id ? "-$term_id" : '') . "-createdoncardcom",
        'RecurringPayments.FlexItem.Price' => get_field('subscription_price', $subscription_id), // Billing amount
        'RecurringPayments.FlexItem.IsPriceIncludeVat' => 'false' // VAT inclusion
    );

    // Log the data being sent
    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php] - Sending data to CardCom: " . json_encode($vars) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    // Send Data To CardCom Server
    $r = PostVars($vars, 'https://secure.cardcom.solutions/Interface/RecurringPayment.aspx');
    parse_str($r, $responseArray);

    // Log the response from CardCom
    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php] - CardCom response: " . json_encode($responseArray) . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    if (strpos($r, 'Object_moved') !== false) {
        $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php] - CardCom response error: " . $r . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
    }

    if ($responseArray['ResponseCode'] == "0") {
        echo "Recurring Payment created successfully.";
    } else {
        echo "Error creating Recurring Payment: " . $responseArray['Description'];
    }
}

function PostVars($vars, $PostVarsURL)
{
    global $log_file;
    $log_data = date('Y-m-d H:i:s') . "[webhook-cardcom-subscribe.php] - PostVars Function ran for returnvalue: " . $vars['RecurringPayments.ReturnValue'];
    $log_data .= PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);

    $urlencoded = http_build_query($vars);
    if (function_exists("curl_init")) {
        $CR = curl_init();
        curl_setopt($CR, CURLOPT_URL, $PostVarsURL);
        curl_setopt($CR, CURLOPT_POST, 1);
        curl_setopt($CR, CURLOPT_FAILONERROR, true);
        curl_setopt($CR, CURLOPT_POSTFIELDS, $urlencoded);
        curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($CR, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

        $r = curl_exec($CR);
        $error = curl_error($CR);
        if (!empty($error)) {
            echo $error;
            die();
        }
        curl_close($CR);
        return $r;
    } else {
        echo "No curl_init";
        die();
    }
}
