<?php

// Set review pro id
add_filter('acf/load_field/name=pro_review_pro_is', 'set_pro_review_pro_is_default_value');
function set_pro_review_pro_is_default_value($field) {
    // Check if the 'pro' URL parameter exists
    if (isset($_GET['pro'])) {
        // Sanitize the URL parameter
        $field['default_value'] = sanitize_text_field($_GET['pro']);
    }
    return $field;
}
