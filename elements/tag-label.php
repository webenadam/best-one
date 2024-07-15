<?php


// Function to render the tag label
function tag_label($title, $link = null, $style = null) {

echo '<tag ' . ($style ? ('class="' . $style .'"') : '') . '><a href="' . ($link ? $link : '#') . '">' . $title . '</a></tag>';


}