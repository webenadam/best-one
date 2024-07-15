<?php

function site_url_shortcode() {
    return site_url();
}
add_shortcode('site_url', 'site_url_shortcode');
