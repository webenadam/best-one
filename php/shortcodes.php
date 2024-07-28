<?php

function site_url_shortcode()
{
    return site_url();
}
add_shortcode('site_url', 'site_url_shortcode');


function pros_search_form_shortcode()
{
    ob_start();
    pros_search_form();
    return ob_get_clean();
}

add_shortcode('pros_search_form', 'pros_search_form_shortcode');
