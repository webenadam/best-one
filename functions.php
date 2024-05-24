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




// Require Elements (from /elements folder)
$elements_path = get_template_directory() . '/elements/';
$php_files = glob($elements_path . '*.php');
foreach ($php_files as $file) {
    require_once $file;
}



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







