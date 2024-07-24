<?php


// Function to render the tag label
function tag_label($title, $link = null, $style = null) {

echo '<tag ' . ($style ? ('class="' . $style .'"') : '') . '>';
if ($link) {
    echo '<a href="' . $link . '">' . $title . '</a>';
} else {
    echo $title;
}
echo '</tag>';

}
