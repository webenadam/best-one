<?php

// =======================
// Helper Functions
// =======================

// Helper function to get the theme URI
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
