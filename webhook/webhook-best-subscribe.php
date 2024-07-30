<?php

/**
 * best webhook subscription function (after userid, subscription id, term id (optional) checks
 */

global $log_file;
$log_file = WP_CONTENT_DIR . '/webhook.log';

function best_subscribe($user_id, $subscription_id, $term_id = null, $lowprofilecode = null)
{
    global $log_file;

    // Subscribe

    # Dynamic Vars:
    $lowprofilecode = $lowprofilecode; #(Same as lowProfileCode)

    // Fetch user details
    $user_info = get_userdata($user_id);
    if (!$user_info) {
        echo "User not found."; // Handle the error appropriately
        return; // Exit the function if user is not found
    }

    $client_email = $user_info->user_email; // User's email
    $client_name = $user_info->display_name; // User's display name. Can also use $user_info->first_name and $user_info->last_name
    $client_id = $user_id;

    $subscription_id = $subscription_id;
    $product_description = get_the_title($subscription_id);


    // Log stuff


    $log_data = date('Y-m-d H:i:s') . "[webhook-best-subscribe] - best_subscribe triggered with user_id: $user_id, subscription_id: $subscription_id, term_id: $term_id, lowprofilecode: $lowprofilecode" . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);



}
