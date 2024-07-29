<?php

// =======================
// Helper Functions
// =======================

// ********** GET THE THEME URI **********

function theme_uri($path = '')
{
    return get_template_directory_uri() . $path;
}

// Get professional date
function get_pro_date($post_id, $data = 'age')
{
    $date_field = ($data == 'age' || $data == null) ? 'pro_birthday' : 'pro_started_date';

    $date_value = get_field($date_field, $post_id);
    $dob = DateTime::createFromFormat('d/m/Y', $date_value);
    $now = new DateTime();
    $age = $now->diff($dob)->y;

    return $age;
}

// Calculate date difference in Hebrew
function hebrew_date_difference($date)
{
    if (!$date) {
        return;
    }

    $date = DateTime::createFromFormat('d/m/Y', $date);
    $now = new DateTime();
    $interval = $now->diff($date);
    $diff_days = $interval->days;
    $diff_months = $interval->m + ($interval->y * 12);
    $diff_years = $interval->y;

    if ($diff_days == 0) {
        return 'היום';
    } elseif ($diff_days == 1) {
        return 'אתמול';
    } elseif ($diff_days < 30) {
        return "לפני $diff_days ימים";
    } elseif ($diff_months < 12) {
        return "לפני $diff_months חודשים";
    } else {
        return "לפני $diff_years שנים";
    }
}


// ********** UPDATE PRO STATS **********
// Usage example
// $post_id = get_the_ID(); // Replace with your post ID logic
// update_pro_stats('page_views', $post_id); // Call the function with the desired stat type and post ID

// Make sure to include this line if it's not already included in your file
date_default_timezone_set('Asia/Jerusalem'); // Set the time zone to Israel

function update_pro_stats($stat_type, $post_id) {

    // Check if the user is logged in
    if (is_user_logged_in()) {
        return; // Exit the function if the user is logged in
    }
    
    // Define the fields based on the stat type
    $fields = [
        'page_views' => [
            'total' => 'pro_stat_page_views_total',
            'year' => 'pro_stat_page_views_year',
            'month' => 'pro_stat_page_views_month',
            'last_update' => 'pro_stat_page_views_last_update',
        ],
        'cube_views' => [
            'total' => 'pro_stat_cube_views_total',
            'year' => 'pro_stat_cube_views_year',
            'month' => 'pro_stat_cube_views_month',
            'last_update' => 'pro_stat_cube_views_last_update',
        ],
        'form_sent' => [
            'total' => 'pro_stat_form_sent_total',
            'year' => 'pro_stat_form_sent_year',
            'month' => 'pro_stat_form_sent_month',
            'last_update' => 'pro_stat_form_sent_month_last_update',
        ],
    ];

    if (!array_key_exists($stat_type, $fields)) {
        return; // Invalid stat type
    }

    // Get the current date and time
    $current_date = new DateTime();
    $current_month = $current_date->format('m');
    $current_year = $current_date->format('Y');
    $current_timestamp = $current_date->format('d/m/Y H:i:s');

    // Get the last update date
    $last_update = get_field($fields[$stat_type]['last_update'], $post_id);

    if ($last_update) {
        $last_update_date = DateTime::createFromFormat('d/m/Y H:i:s', $last_update);
        if ($last_update_date) {
            $last_update_month = $last_update_date->format('m');
            $last_update_year = $last_update_date->format('Y');

            // Reset the monthly view count if the last update was in the previous month
            if ($last_update_month != $current_month) {
                update_field($fields[$stat_type]['month'], 0, $post_id);
            }

            // Reset the yearly view count if the last update was in the previous year
            if ($last_update_year != $current_year) {
                update_field($fields[$stat_type]['year'], 0, $post_id);
            }
        }
    }

    // Update the total, yearly, and monthly counts
    $total_views = get_field($fields[$stat_type]['total'], $post_id) ?: 0;
    $yearly_views = get_field($fields[$stat_type]['year'], $post_id) ?: 0;
    $monthly_views = get_field($fields[$stat_type]['month'], $post_id) ?: 0;

    update_field($fields[$stat_type]['total'], $total_views + 1, $post_id);
    update_field($fields[$stat_type]['year'], $yearly_views + 1, $post_id);
    update_field($fields[$stat_type]['month'], $monthly_views + 1, $post_id);

    // Update the last update field with the current timestamp
    update_field($fields[$stat_type]['last_update'], $current_timestamp, $post_id);
}

// Create CardCom Payment Link
function generateCardcomLink($user_id, $subscription_id, $term_id = null) {
    // Define static variables
    $codepage = 65001; // Unicode encoding type for system compatibility
    $operation = 2; // Type of operation (1 - charge, 2 - charge and create token, 3 - create token, 4 - delayed charge)
    $terminalNumber = 1000; // Your terminal number provided by Cardcom
    $userName = "test2025"; // Username for API access
    $coinID = 1; // Currency type (1 for ILS)
    $language = "he"; // Language of the interface (he for Hebrew)
    $apiLevel = 10; // API version, latest is 10
    $successRedirectUrl = site_url('/payment-success'); // URL to redirect upon success
    $errorRedirectUrl = site_url('/payment-failed'); // URL to redirect upon failure
    $indicatorUrl = site_url('/webhook'); // Server-side endpoint to receive transaction details before redirect
    $returnValue = "Orderid1234"; // Custom value to pass through and receive back, typically an order ID
    $autoRedirect = "true"; // Whether to auto-redirect user after payment processing

    // Define dynamic variables
    $returnValue = 'subscribe-'. $user_id . '-' . $subscription_id . ($term_id ? '-'. $term_id : ''); // Custom value to pass through and receive back, typically an order ID
    $sumToBill = get_field('subscription_price', $subscription_id); // Amount to bill the user

 

    // Build the query URL (static stuff)
    $queryUrl = "https://secure.cardcom.solutions/Interface/LowProfile.aspx?";
    $queryUrl .= "codepage=" . urlencode($codepage);
    $queryUrl .= "&Operation=" . urlencode($operation);
    $queryUrl .= "&TerminalNumber=" . urlencode($terminalNumber);
    $queryUrl .= "&UserName=" . urlencode($userName);
    $queryUrl .= "&CoinID=" . urlencode($coinID);
    $queryUrl .= "&Language=" . urlencode($language);
    $queryUrl .= "&APILevel=" . urlencode($apiLevel);
    $queryUrl .= "&SuccessRedirectUrl=" . urlencode($successRedirectUrl);
    $queryUrl .= "&ErrorRedirectUrl=" . urlencode($errorRedirectUrl);
    $queryUrl .= "&IndicatorUrl=" . urlencode($indicatorUrl);
    $queryUrl .= "&AutoRedirect=" . urlencode($autoRedirect);

    // Continue Building the query URL (dynamic stuff)
    $queryUrl .= "&ReturnValue=" . urlencode($returnValue);
    $queryUrl .= "&SumToBill=" . urlencode($sumToBill);


    // Return the generated link
    return $queryUrl;
}
