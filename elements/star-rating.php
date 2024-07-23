<?php

// Function to convert a 0-100 score to a 0-5 score
function convert_to_star_rating($score) {
    // Ensure the score is within the range 0-100
    $score = max(0, min(100, $score));

    // Convert score from 0-100 to 0-5
    $star_rating = round($score / 20); // 20 is 100/5

    return $star_rating;
}

// Function to render the star rating
function star_rating($score = 0, $from = 5) {
    // Convert 0-100 score to a 0-5 score
    $number = convert_to_star_rating($score);

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
