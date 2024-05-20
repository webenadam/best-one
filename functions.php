<?php
// Theme setup
function best_one_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'best-one'),
    ));
}
add_action('after_setup_theme', 'best_one_setup');

// Enqueue styles and scripts
function best_one_styles()
{
    // Get the theme version
    $theme_version = wp_get_theme()->get('Version');

    // Get the file modification times
    $reset_css_version = filemtime(get_template_directory() . '/style-reset.css');
    $base_css_version = filemtime(get_template_directory() . '/style-base.css');
    $style_css_version = filemtime(get_stylesheet_directory() . '/style.css');

    // Enqueue styles with version parameters
    wp_enqueue_style('best-one-reset', get_template_directory_uri() . '/style-reset.css', array(), $reset_css_version);
    wp_enqueue_style('best-one-base', get_template_directory_uri() . '/style-base.css', array(), $base_css_version);
    wp_enqueue_style('best-one-style', get_stylesheet_uri(), array(), $style_css_version);
}
add_action('wp_enqueue_scripts', 'best_one_styles');

// Helper function to get the theme URI
function theme_uri($path = '') {
    return get_template_directory_uri() . $path;
}



// Disable the emoji's
function disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');    
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

// Filter function used to remove the tinymce emoji plugin.
function disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

// Remove emoji CDN hostname from DNS prefetching hints.
function disable_emojis_remove_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' == $relation_type) {
        $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
        foreach ($urls as $key => $url) {
            if (strpos($url, $emoji_svg_url_bit) !== false) {
                unset($urls[$key]);
            }
        }
    }
    return $urls;
}

// Remove WordPress version number
remove_action('wp_head', 'wp_generator');


// Hook into 'init' action to create the new role
add_action('init', 'add_pro_role');

function add_pro_role() {
    // Add a new role with the ID 'pro' and the display name 'בעל מקצוע'
    add_role(
        'pro', // Role ID
        __('בעל מקצוע', 'textdomain'), // Display name with translation support
        array(
            'read' => true,  // Allow this role to read content
            // Add other capabilities as needed
        )
    );
}



// Add custom column to "pros" post type
function add_pros_thumbnail_column($columns) {
    $new_columns = array('thumbnail' => ''); // Add the new column with an empty title
    return array_merge($new_columns, $columns); // Merge the new column to be the first
}
add_filter('manage_pros_posts_columns', 'add_pros_thumbnail_column');

// Display the featured image in the custom column
function display_pros_thumbnail_column($column, $post_id) {
    if ($column === 'thumbnail') {
        $thumbnail_id = get_post_thumbnail_id($post_id);
        if ($thumbnail_id) {
            $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, array(52, 52));
            if ($thumbnail_url) {
                echo '<img src="' . esc_url($thumbnail_url) . '" alt="" style="width:52px; height:52px; border-radius:50%;" />';
            }
        }
    }
}
add_action('manage_pros_posts_custom_column', 'display_pros_thumbnail_column', 10, 2);

// Ensure the column has a fixed width and is styled correctly
function pros_admin_columns_styles() {
    echo '<style>
        .column-thumbnail {
            width: 60px;
        }
        .column-thumbnail img {
            display: block;
            margin: 0 auto;
        }
    </style>';
}
add_action('admin_head', 'pros_admin_columns_styles');


// Disable the admin bar for everyone on the front end
add_filter('show_admin_bar', '__return_false');

// Enque login page styles
function custom_login_styles() {
    wp_enqueue_style('custom-login-styles', get_template_directory_uri() . '/css/login-styles.css');
}
add_action('login_enqueue_scripts', 'custom_login_styles');

// Custom login logo URL to point to the site's homepage
function custom_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'custom_login_logo_url');

// Custom login logo title to show the site's name
function custom_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'custom_login_logo_url_title');



// Enqueue combined scripts and localize data
function feed_ajax_scripts() {
    // Enqueue Typeahead script
    wp_enqueue_script('typeahead', 'https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js', array('jquery'), null, true);

    // Enqueue custom combined script
    wp_enqueue_script('feed-ajax', get_template_directory_uri() . '/js/feed-ajax.js', array('jquery', 'typeahead'), null, true);

    // Retrieve "places" taxonomy terms
    $places_terms = get_terms(array(
        'taxonomy' => 'places',
        'hide_empty' => true, // Only show terms that are used by posts
    ));

    // Prepare terms for JavaScript
    $places = array();
    foreach ($places_terms as $term) {
        $places[] = array(
            'id' => $term->term_id,
            'name' => $term->name,
        );
    }

    // Pass the taxonomy terms and ajax URL to JavaScript
    wp_localize_script('feed-ajax', 'data', array(
        'places' => $places,
        'ajax_url' => admin_url('admin-ajax.php') // Correct property name
    ));
}
add_action('wp_enqueue_scripts', 'feed_ajax_scripts');




// Get SVG Icons
function get_svg_icon($icon_name, $icon_color = null) {
    $icons = array(
        'place' => '<svg width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.33333 0C2.71184 0 0 1.97836 0 5.28889C0 8.79978 4.90259 13.702 5.11153 13.9088C5.1702 13.9673 5.2502 14 5.33333 14C5.41647 14 5.49647 13.9673 5.55514 13.9088C5.76408 13.702 10.6667 8.79978 10.6667 5.28889C10.6667 1.97836 7.95482 0 5.33333 0ZM5.33548 7.15557C4.29736 7.15557 3.45312 6.31837 3.45312 5.28891C3.45312 4.25944 4.29736 3.42224 5.33548 3.42224C6.3736 3.42224 7.21783 4.25944 7.21783 5.28891C7.21783 6.31837 6.3736 7.15557 5.33548 7.15557Z"
                            fill="'. ($icon_color ?  $icon_color : '#68D585') .'"/>
                    </svg>',
        'link' => '<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M0.594645 1.36382C0.594645 0.926668 0.949413 0.571899 1.38657 0.571899H6.98415C7.42131 0.571899 7.77607 0.926668 7.77607 1.36382C7.77607 1.80097 7.42131 2.15574 6.98415 2.15574H3.29778L8.66375 7.52172C8.97324 7.83121 8.97324 8.33219 8.66375 8.64094C8.35426 8.95043 7.85329 8.95043 7.54454 8.64094L2.17856 3.27495V6.96134C2.17856 7.39849 1.82379 7.75325 1.38664 7.75325C0.949489 7.75325 0.594721 7.39849 0.594721 6.96134L0.594645 1.36382ZM11.8573 16.417H5.14192C4.50437 16.417 3.97891 16.417 3.55066 16.3821C3.10534 16.3457 2.69641 16.2678 2.3127 16.0718C1.71673 15.7683 1.23282 15.2836 0.928513 14.6876C0.732585 14.3032 0.654647 13.8942 0.618281 13.4497C0.583399 13.0214 0.583399 12.4952 0.583399 11.8577V11.2706C0.583399 10.8335 0.938167 10.4787 1.37532 10.4787C1.81247 10.4787 2.16724 10.8335 2.16724 11.2706V11.8251C2.16724 12.5034 2.16798 12.9643 2.19693 13.3206C2.22513 13.6679 2.27708 13.8453 2.34017 13.9692C2.49158 14.2669 2.73427 14.5096 3.03188 14.661C3.15583 14.724 3.3332 14.7753 3.68056 14.8042C4.03681 14.8331 4.49771 14.8339 5.17607 14.8339H11.8261C12.5044 14.8339 12.9653 14.8331 13.3216 14.8042C13.6689 14.776 13.8463 14.724 13.9703 14.661C14.2679 14.5095 14.5106 14.2669 14.662 13.9692C14.7251 13.8453 14.7763 13.6679 14.8045 13.3206C14.8334 12.9643 14.8342 12.5034 14.8342 11.8251V5.17505C14.8342 4.49669 14.8334 4.03579 14.8045 3.67954C14.7763 3.3322 14.7251 3.15482 14.662 3.03086C14.5098 2.73325 14.2679 2.49054 13.9703 2.33915C13.8463 2.27606 13.6689 2.22485 13.3216 2.19665C12.9653 2.1677 12.5044 2.16696 11.8261 2.16696H11.2717C10.8345 2.16696 10.4797 1.81219 10.4797 1.37504C10.4797 0.937889 10.8345 0.583121 11.2717 0.583121H11.8587C12.4963 0.583121 13.0217 0.583121 13.4507 0.618003C13.896 0.654371 14.305 0.732299 14.6887 0.928235C15.2846 1.2318 15.7693 1.71643 16.0729 2.31242C16.2688 2.69687 16.3467 3.10583 16.3831 3.55039C16.418 3.97863 16.418 4.50483 16.418 5.14238V11.8577C16.418 12.4953 16.418 13.0207 16.3831 13.4497C16.3467 13.8951 16.2688 14.304 16.0729 14.6877C15.7693 15.2837 15.2847 15.7683 14.6887 16.0719C14.3042 16.2678 13.8953 16.3457 13.4507 16.3821C13.0225 16.417 12.4963 16.417 11.8587 16.417L11.8573 16.417Z"
              fill="'. ($icon_color ?  $icon_color : '#979797') .'"/>
    </svg>',
    'left-arrow' => '<svg width="14" height="11" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M16 7.99998L1 7.77776" stroke="'. ($icon_color ?  $icon_color : '#68D585') .'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    <path d="M8 15L0.999999 8L8 1" stroke="'. ($icon_color ?  $icon_color : '#68D585') .'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
  </svg></a>',
  'dots' => '<svg width="107" height="109" viewBox="0 0 107 109" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path opacity="0.797991" fill-rule="evenodd" clip-rule="evenodd" d="M70.5034 104H70.4898C69.9123 104 69.4058 104.229 68.9841 104.558C68.9028 104.623 68.8012 104.66 68.7283 104.733C68.3235 105.14 68.0898 105.697 68.039 106.304C68.0339 106.372 68 106.431 68 106.501C68 106.81 68.0728 107.098 68.1762 107.37C68.21 107.458 68.2524 107.534 68.2947 107.617C68.3862 107.795 68.4963 107.96 68.6284 108.111C68.6927 108.186 68.7503 108.262 68.8232 108.328C69.023 108.51 69.2432 108.669 69.4939 108.779H69.4956C69.8056 108.917 70.1443 109 70.5034 109C71.6162 109 72.5257 108.26 72.8493 107.251C72.9356 107.02 72.9949 106.779 72.9966 106.514C72.9966 106.509 73 106.506 73 106.501C73 105.118 71.8821 104 70.5034 104ZM105.43 74.1883C105.188 74.0865 104.918 74.0475 104.642 74.0288C104.593 74.0271 104.554 74 104.503 74H104.49C103.111 74 102 75.1194 102 76.5017C102 76.8375 102.071 77.1547 102.191 77.443C102.276 77.6499 102.415 77.8161 102.545 77.9908C102.6 78.057 102.63 78.1384 102.688 78.1995C103.103 78.6404 103.675 78.9118 104.315 78.9627C104.319 78.9627 104.322 78.9644 104.326 78.9661V78.9644C104.387 78.9695 104.441 79 104.503 79C105.882 79 107 77.8806 107 76.5017C107 75.4501 106.348 74.558 105.43 74.1883ZM19.5034 30H19.4898C18.1111 30 17 31.1194 17 32.5C17 33.8789 18.1247 35 19.5034 35C20.8804 35 22 33.8789 22 32.5C22 31.1194 20.8804 30 19.5034 30ZM19.5034 89H19.4898C18.1111 89 17 90.1181 17 91.5008C17 92.8802 18.1247 94 19.5034 94C20.8804 94 22 92.8802 22 91.5008C22 90.1181 20.8804 89 19.5034 89ZM36.5034 50C37.8821 50 39 48.8789 39 47.5C39 46.1177 37.8821 45 36.5034 45H36.4915C35.1111 45 34 46.1177 34 47.5C34 48.8789 35.1247 50 36.5034 50ZM19.5034 15H19.4898C18.1111 15 17 16.1194 17 17.5C17 18.8806 18.1247 20 19.5034 20C20.8804 20 22 18.8806 22 17.5C22 16.1194 20.8804 15 19.5034 15ZM19.5034 59H19.4898C18.1111 59 17 60.1194 17 61.5C17 62.8806 18.1247 64 19.5034 64C20.8804 64 22 62.8806 22 61.5C22 60.1194 20.8804 59 19.5034 59ZM19.5034 74H19.4898C18.1111 74 17 75.1194 17 76.5017C17 77.8806 18.1247 79 19.5034 79C20.8804 79 22 77.8806 22 76.5017C22 75.1194 20.8804 74 19.5034 74ZM36.5034 20C37.8821 20 39 18.8806 39 17.5C39 16.1194 37.8821 15 36.5034 15H36.4915C35.1111 15 34 16.1194 34 17.5C34 18.8806 35.1247 20 36.5034 20ZM36.5034 35C37.8821 35 39 33.8789 39 32.5C39 31.1194 37.8821 30 36.5034 30H36.4915C35.1111 30 34 31.1194 34 32.5C34 33.8789 35.1247 35 36.5034 35ZM36.5034 5C37.8821 5 39 3.8806 39 2.5C39 1.1194 37.8821 0 36.5034 0H36.4915C35.1111 0 34 1.1194 34 2.5C34 3.8806 35.1247 5 36.5034 5ZM19.5034 45H19.4898C18.1111 45 17 46.1177 17 47.5C17 48.8789 18.1247 50 19.5034 50C20.8804 50 22 48.8789 22 47.5C22 46.1177 20.8804 45 19.5034 45ZM2.50508 59H2.48984C1.11111 59 0 60.1194 0 61.5C0 62.8806 1.12636 64 2.50508 64C3.88381 64 5 62.8806 5 61.5C5 60.1194 3.88381 59 2.50508 59ZM2.50508 45H2.48984C1.11111 45 0 46.1177 0 47.5C0 48.8789 1.12636 50 2.50508 50C3.88381 50 5 48.8789 5 47.5C5 46.1177 3.88381 45 2.50508 45ZM2.50424 74H2.48899C2.17553 74 1.88241 74.0712 1.60962 74.1798C1.47069 74.2324 1.35547 74.3172 1.23009 74.3935C1.12504 74.4596 1.0183 74.519 0.923416 74.6021C0.759065 74.7361 0.630295 74.8921 0.504914 75.0651C0.481193 75.1007 0.457472 75.133 0.433751 75.172C0.298204 75.3823 0.198238 75.6028 0.130464 75.8504L0.12877 75.8521V75.8538C0.0711623 76.0641 0 76.271 0 76.5017C0 77.4854 0.584548 78.3182 1.41308 78.7252V78.7269H1.41477C1.74517 78.8881 2.10098 78.9949 2.49068 78.9966C2.49576 78.9966 2.49915 79 2.50424 79C3.88343 79 5 77.8806 5 76.5017C5 76.1557 4.93053 75.8267 4.80346 75.5282C4.42562 74.6309 3.53778 74 2.50424 74ZM87.5034 45H87.4898C86.1111 45 85 46.1177 85 47.5C85 48.8789 86.1247 50 87.5034 50C88.8821 50 90 48.8789 90 47.5C90 46.1177 88.8821 45 87.5034 45ZM2.50424 30H2.48899C2.20434 30 1.94171 30.0628 1.69434 30.1611C1.46899 30.2391 1.27245 30.3562 1.08268 30.4919C1.08099 30.4919 1.08099 30.4919 1.0793 30.4936C0.440529 30.9464 0 31.6554 0 32.5C0 32.6069 0.0474415 32.6967 0.0609963 32.8019H0.0593019C0.0593019 32.8053 0.0609963 32.807 0.0626906 32.8087C0.14063 33.4176 0.413419 33.9552 0.848865 34.3453C0.908167 34.3996 0.982718 34.4301 1.04541 34.4776C1.21654 34.6031 1.38089 34.7337 1.58251 34.8134C1.86547 34.9305 2.17384 35 2.50424 35C3.53778 35 4.42562 34.3708 4.80346 33.4718C4.93053 33.1733 5 32.8443 5 32.5C5 32.1557 4.93053 31.8267 4.80346 31.5282C4.42562 30.6292 3.53778 30 2.50424 30ZM87.5034 59H87.4898C86.1111 59 85 60.1194 85 61.5C85 62.8806 86.1247 64 87.5034 64C88.8821 64 90 62.8806 90 61.5C90 60.1194 88.8821 59 87.5034 59ZM87.5034 30H87.4898C86.1111 30 85 31.1194 85 32.5C85 33.8789 86.1247 35 87.5034 35C88.8821 35 90 33.8789 90 32.5C90 31.1194 88.8821 30 87.5034 30ZM87.5034 89H87.4898C86.1111 89 85 90.1181 85 91.5008C85 92.8802 86.1247 94 87.5034 94C88.8821 94 90 92.8802 90 91.5008C90 90.1181 88.8821 89 87.5034 89ZM87.5034 74H87.4898C86.1111 74 85 75.1194 85 76.5017C85 77.8806 86.1247 79 87.5034 79C88.8821 79 90 77.8806 90 76.5017C90 75.1194 88.8821 74 87.5034 74ZM70.5042 5C71.8825 5 73 3.8806 73 2.5C73 2.5 72.9983 2.4983 72.9983 2.49661C72.9983 2.09125 72.8798 1.7232 72.7071 1.38399C72.6901 1.35176 72.6681 1.32802 72.6495 1.29749C72.4683 0.976934 72.2211 0.710651 71.9214 0.496947H71.9197C71.5117 0.20692 71.041 0 70.5042 0H70.4907C69.1124 0 68 1.1194 68 2.5C68 3.8806 69.126 5 70.5042 5ZM87.5034 15H87.4898C86.1111 15 85 16.1194 85 17.5C85 18.8806 86.1247 20 87.5034 20C88.8821 20 90 18.8806 90 17.5C90 16.1194 88.8821 15 87.5034 15ZM70.5034 30H70.4898C69.1111 30 68 31.1194 68 32.5C68 33.8789 69.1247 35 70.5034 35C71.8821 35 73 33.8789 73 32.5C73 31.1194 71.8821 30 70.5034 30ZM70.5034 74H70.4898C69.1111 74 68 75.1194 68 76.5017C68 77.8806 69.1247 79 70.5034 79C71.8821 79 73 77.8806 73 76.5017C73 75.1194 71.8821 74 70.5034 74ZM70.5034 59H70.4898C69.1111 59 68 60.1194 68 61.5C68 62.8806 69.1247 64 70.5034 64C71.8821 64 73 62.8806 73 61.5C73 60.1194 71.8821 59 70.5034 59ZM70.5034 45H70.4898C69.1111 45 68 46.1177 68 47.5C68 48.8789 69.1247 50 70.5034 50C71.8821 50 73 48.8789 73 47.5C73 46.1177 71.8821 45 70.5034 45ZM70.5034 89H70.4898C69.1111 89 68 90.1181 68 91.5008C68 92.8802 69.1247 94 70.5034 94C71.8821 94 73 92.8802 73 91.5008C73 90.1181 71.8821 89 70.5034 89ZM36.5034 64C37.8821 64 39 62.8806 39 61.5C39 60.1194 37.8821 59 36.5034 59H36.4915C35.1111 59 34 60.1194 34 61.5C34 62.8806 35.1247 64 36.5034 64ZM38.2683 104.733C38.1938 104.658 38.0921 104.621 38.0091 104.558C37.5874 104.229 37.081 104 36.5034 104H36.4898C35.1111 104 34 105.118 34 106.501C34 107.18 34.2761 107.79 34.7165 108.242C34.7182 108.243 34.7182 108.245 34.7199 108.245C35.1738 108.71 35.8039 109 36.5034 109C36.6355 109 36.749 108.946 36.876 108.925C36.8777 108.925 36.8794 108.924 36.8811 108.924C37.4705 108.832 37.9854 108.561 38.3598 108.131C38.4207 108.065 38.4563 107.984 38.5088 107.911C38.6223 107.75 38.7425 107.597 38.8171 107.412C38.9289 107.135 38.9949 106.833 38.9966 106.511C38.9966 106.508 39 106.506 39 106.501C39 105.866 38.7442 105.303 38.3564 104.862C38.3208 104.821 38.3056 104.769 38.2683 104.733ZM103.53 34.8033C103.83 34.9305 104.159 35 104.504 35C104.869 35 105.209 34.9135 105.521 34.7728C105.531 34.7677 105.538 34.7592 105.548 34.7542C105.853 34.6117 106.116 34.4117 106.338 34.1641C106.741 33.7216 107 33.1451 107 32.5008C107 31.1207 105.882 30 104.504 30H104.491C103.111 30 102 31.1207 102 32.5008C102 33.5351 102.632 34.4235 103.53 34.8033ZM104.504 50C105.882 50 107 48.8789 107 47.5C107 46.1177 105.882 45 104.504 45H104.491C103.111 45 102 46.1177 102 47.5C102 48.8789 103.123 50 104.504 50ZM104.504 64C105.882 64 107 62.8806 107 61.5C107 60.1194 105.882 59 104.504 59H104.491C103.111 59 102 60.1194 102 61.5C102 62.8806 103.123 64 104.504 64ZM53.5034 30H53.4915C52.1128 30 51 31.1194 51 32.5C51 33.8789 52.1247 35 53.5034 35C54.8821 35 56 33.8789 56 32.5C56 31.1194 54.8821 30 53.5034 30ZM53.5034 15H53.4915C52.1128 15 51 16.1194 51 17.5C51 18.8806 52.1247 20 53.5034 20C54.8821 20 56 18.8806 56 17.5C56 16.1194 54.8821 15 53.5034 15ZM53.5034 0H53.4915C52.1128 0 51 1.1194 51 2.5C51 3.8806 52.1247 5 53.5034 5C54.8821 5 56 3.8806 56 2.5C56 1.1194 54.8821 0 53.5034 0ZM36.5034 94C37.8821 94 39 92.8802 39 91.5008C39 90.1181 37.8821 89 36.5034 89H36.4915C35.1111 89 34 90.1181 34 91.5008C34 92.8802 35.1247 94 36.5034 94ZM36.5034 79C37.8821 79 39 77.8806 39 76.5017C39 75.1194 37.8821 74 36.5034 74H36.4915C35.1111 74 34 75.1194 34 76.5017C34 77.8806 35.1247 79 36.5034 79ZM53.5034 45H53.4915C52.1128 45 51 46.1177 51 47.5C51 48.8789 52.1247 50 53.5034 50C54.8821 50 56 48.8789 56 47.5C56 46.1177 54.8821 45 53.5034 45ZM70.5034 15H70.4898C69.1111 15 68 16.1194 68 17.5C68 18.8806 69.1247 20 70.5034 20C71.8821 20 73 18.8806 73 17.5C73 16.1194 71.8821 15 70.5034 15ZM53.5034 89H53.4915C52.1128 89 51 90.1181 51 91.5008C51 92.8802 52.1247 94 53.5034 94C54.8821 94 56 92.8802 56 91.5008C56 90.1181 54.8821 89 53.5034 89ZM53.5034 104H53.4915C52.1128 104 51 105.12 51 106.501C51 107.882 52.1247 109 53.5034 109C54.8821 109 56 107.882 56 106.501C56 105.12 54.8821 104 53.5034 104ZM53.5034 74H53.4915C52.1128 74 51 75.1194 51 76.5017C51 77.8806 52.1247 79 53.5034 79C54.8821 79 56 77.8806 56 76.5017C56 75.1194 54.8821 74 53.5034 74ZM53.5034 59H53.4915C52.1128 59 51 60.1194 51 61.5C51 62.8806 52.1247 64 53.5034 64C54.8821 64 56 62.8806 56 61.5C56 60.1194 54.8821 59 53.5034 59Z" fill="'. ($icon_color ? $icon_color : '#161C2D') .'" />
</svg>',
    );

    return isset($icons[$icon_name]) ? $icons[$icon_name] : '';
}


// Add Elements
require_once get_template_directory() . '/elements/profile-box.php';


// Add Ajax Functions
require_once get_template_directory() . '/ajax/ajax-functions.php';





// Hook into the ACF taxonomy field query
add_filter('acf/fields/taxonomy/query/name=home_featured_expert_terms', 'filter_taxonomy_terms', 10, 3);

function filter_taxonomy_terms($args, $field, $post_id) {
    // Modify the query to only include terms that are associated with posts
    $args['hide_empty'] = true; // Only show terms with posts assigned

    return $args;
}

function dequeue_global_and_classic_styles() {
    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'dequeue_global_and_classic_styles', 100);
