<?php

function accordion($items, $activeIndex = 0) {
    if (empty($items)) {
        return '';
    }

    $activeIndex = $activeIndex - 1;
    
    $output = '<div class="accordion">';
    foreach ($items as $index => $item) {
        $title = htmlspecialchars($item['title']);
        $content = htmlspecialchars($item['content']);
        $isActive = $index === $activeIndex ? ' active' : '';
        $isContentVisible = $index === $activeIndex ? ' style="display: block;"' : '';

        $output .= "<div class='accordion-item'>";
        $output .= "<h2 class='accordion-title{$isActive}'>{$title}</h2>";
        $output .= "<div class='accordion-content'{$isContentVisible}><p>{$content}</p></div>";
        $output .= "</div>";
    }
    $output .= '</div>';

    return $output;
}

?>
