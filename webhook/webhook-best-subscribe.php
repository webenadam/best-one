<?php

/**
 * best webhook subscription function (after userid, subscription id, term id (optional) checks)
 */

global $log_file;
$log_file = WP_CONTENT_DIR . '/webhook.log';

function best_subscribe($user_id, $subscription_id, $term_id = null, $lowprofilecode = null, $account_id = null, $recurring_id = null, $operation = 'create')
{
    global $log_file, $pros_post_id;

    // ==========================================
    // STEP 1: GATHER AND SET ALL DATA
    // ==========================================

    $lowprofilecode = $lowprofilecode; // LowProfileDealGuid

    // Fetch user details
    $user_info = get_userdata($user_id);
    $client_email = $user_info ? $user_info->user_email : null;
    $client_name = $user_info ? $user_info->display_name : null;
    $client_id = $user_id;

    $subscription_id = $subscription_id;
    $product_description = get_the_title($subscription_id);

    $args = array(
        'post_type' => 'pros',
        'author' => $client_id,
        'posts_per_page' => 1,
        'post_status' => 'publish'
    );
    $pros_query = new WP_Query($args);

    if ($pros_query->have_posts()) {
        $pros_query->the_post();
        $pros_post_id = get_the_ID();
    }

    // ==========================================
    // STEP 2: CHECK FOR ERRORS
    // ==========================================

    if (!$user_info) {
        $log_data = date('Y-m-d H:i:s') . "[webhook-best-subscribe] - User not found for ID: $user_id" . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        echo "User not found.";
        return;
    }

    if (!$subscription_id || !get_post($subscription_id)) {
        $log_data = date('Y-m-d H:i:s') . "[webhook-best-subscribe] - Invalid subscription ID: $subscription_id" . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        echo "Invalid subscription.";
        return;
    }

    if (!$pros_post_id) {
        $log_data = date('Y-m-d H:i:s') . "[webhook-best-subscribe] - Pro's post not found for author user ID: $user_id" . PHP_EOL;
        file_put_contents($log_file, $log_data, FILE_APPEND);
        echo "Pro post not found.";
        return;
    }

    // ==========================================
    // STEP 3: DECIDE WHICH OPERATION TO RUN
    // ==========================================

    switch ($operation) {
        case 'create':
            best_create_subscription($client_id, $subscription_id, $term_id, $lowprofilecode);
            break;
        case 'update':
            best_update_subscription($client_id, $subscription_id, $term_id, $lowprofilecode, $account_id, $recurring_id);
            break;
        default:
            $log_data = date('Y-m-d H:i:s') . "[webhook-best-subscribe] - Invalid operation: $operation" . PHP_EOL;
            file_put_contents($log_file, $log_data, FILE_APPEND);
            echo "Invalid operation.";
            return;
    }

    // ==========================================
    // STEP 4: LOG OPERATION
    // ==========================================

    $log_data = date('Y-m-d H:i:s') . "[webhook-best-subscribe] - best_subscribe $operation operation completed for user_id: $user_id, subscription_id: $subscription_id, term_id: $term_id, lowprofilecode: $lowprofilecode, account_id: $account_id, recurring_id: $recurring_id" . PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);
}

function best_create_subscription($client_id, $subscription_id, $term_id, $lowprofilecode)
{
    // Implementation for creating a new subscription
    global $pros_post_id, $log_file;

    // Check if a row already exists with the same details (praventing duplicate subscriptions)
    if (have_rows('ad_subscriptions', $pros_post_id)) {
        while (have_rows('ad_subscriptions', $pros_post_id)) {
            the_row();
            $advertise_plan_field = get_sub_field('ad_subscription_advertise_plan');
            $lowprofilecode_field = get_sub_field('ad_subscription_lowprofilecode');
            $expert_term_field = get_sub_field('ad_subscription_expert_term');

            if ($advertise_plan_field == $subscription_id && $lowprofilecode_field == $lowprofilecode && (!$term_id || $expert_term_field == $term_id)) {
                $log_data = date('Y-m-d H:i:s') . "[webhook-best-subscribe] - Subscription already exists for user_id: $client_id, subscription_id: $subscription_id, term_id: $term_id, lowprofilecode: $lowprofilecode" . PHP_EOL;
                file_put_contents($log_file, $log_data, FILE_APPEND);
                echo "Subscription already exists.";
                return;
            }
        }
    }

    // Create a new row in ACF repeater "ad_subscriptions" with initial data
    $subscription_price = get_field('subscription_price', $subscription_id);
    $subscription_length = intval(get_field('subscription_commitment', $subscription_id));
    
    $new_row = array(
        'ad_subscription_advertise_plan' => $subscription_id,
        'ad_subscription_expert_term' => $term_id,
        'ad_subscription_start_date' => date('d/m/Y'),
        'ad_subscription_end_date' => date('d/m/Y', strtotime("+$subscription_length months")),
        'ad_subscription_state' => '0',
        'ad_subscription_lowprofilecode' => $lowprofilecode,
        'ad_subscription_price' => $subscription_price,
    );

    add_row('ad_subscriptions', $new_row, $pros_post_id);

    // Reset post data
    wp_reset_postdata();
}

function best_update_subscription($client_id, $subscription_id, $term_id, $lowprofilecode, $account_id, $recurring_id)
{
    global $pros_post_id, $log_file;


    // Get the rows of the ACF repeater field "ad_subscriptions"
    if (have_rows('ad_subscriptions', $pros_post_id)) {
        while (have_rows('ad_subscriptions', $pros_post_id)) {
            the_row();
            $advertise_plan = get_sub_field('ad_subscription_advertise_plan');
            $lowprofilecode_field = get_sub_field('ad_subscription_lowprofilecode');
            $expert_term = get_sub_field('ad_subscription_expert_term');

            // Check if the row matches the given criteria
            if ($advertise_plan == $subscription_id && $lowprofilecode_field == $lowprofilecode && (!$term_id || $expert_term == $term_id)) {
                // Update subscription details
                update_sub_field('ad_subscription_state', '1');
                update_sub_field('ad_subscription_cardcom_client_id', $account_id);
                update_sub_field('ad_subscription_cardcom_subscription_id', $recurring_id);
                update_sub_field('ad_subscription_account_id', $account_id);
                update_sub_field('ad_subscription_recurring_id', $recurring_id);
                break;
            }
        }
    }

    // Reset post data
    wp_reset_postdata();
}
