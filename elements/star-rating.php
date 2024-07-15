<?php

// Function to render the star rating
function star_rating($number = 0, $from = 5) {
    // Initialize an empty string to store the result
    $output = '';

    // Loop to add filled stars
    for ($i = 0; $i < $number; $i++) {
        $output .= svg_icon('star');
    }

    // Loop to add gray stars
    for ($i = $number; $i < $from; $i++) {
        $output .= svg_icon('star', '#E0E0E0');
    }

    // Return the generated stars
    return '<div class="star-rating flex" style="gap:7px;margin-bottom:10px;">' . $output . '</div>';
}

?>
