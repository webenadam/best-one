<?php
// =======================
// Theme Setup
// =======================

// Initialize theme setup
function best_one_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'best-one'),
    ));
}
add_action('after_setup_theme', 'best_one_setup');


// =======================
// Enqueue \ Require Styles and Scripts
// =======================

// Include php functions
$elements_path = get_template_directory() . '/php/';
$php_files = glob($elements_path . '*.php');
foreach ($php_files as $file) {
    require_once $file;
}

// Include required elements
$elements_path = get_template_directory() . '/elements/';
$php_files = glob($elements_path . '*.php');
foreach ($php_files as $file) {
    require_once $file;
}

// Ensure jQuery is loaded
function enqueue_jquery()
{
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_jquery', 1);

// Enqueue combined scripts and localize data
function main_feed_ajax_scripts()
{
    // Enqueue Typeahead script
    wp_enqueue_script('typeahead', 'https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js', array('jquery'), null, true);

    // Enqueue custom combined script
    wp_enqueue_script('main-feed-ajax', get_template_directory_uri() . '/js/main-feed-ajax.js', array('jquery', 'typeahead'), null, true);

    // Retrieve "places" taxonomy terms
    $places_terms = get_terms(array(
        'taxonomy' => 'places',
        'hide_empty' => true, // Only show terms that are used by posts
    ));

    // Retrieve "areas" taxonomy terms
    $areas_terms = get_terms(array(
        'taxonomy' => 'areas',
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

    foreach ($areas_terms as $term) {
        $places[] = array(
            'id' => $term->term_id,
            'name' => $term->name,
        );
    }

    // Pass the taxonomy terms and ajax URL to JavaScript
    wp_localize_script('main-feed-ajax', 'mainFeedAjaxData', array(
        'places' => $places,
        'ajax_url' => admin_url('admin-ajax.php') // Correct property name
    ));
}
add_action('wp_enqueue_scripts', 'main_feed_ajax_scripts');



// Enqueue styles and scripts with versioning
function best_one_styles()
{
    $theme_version = wp_get_theme()->get('Version');
    $reset_css_version = filemtime(get_template_directory() . '/style-reset.css');
    $base_css_version = filemtime(get_template_directory() . '/style-base.css');
    $style_css_version = filemtime(get_stylesheet_directory() . '/style.css');

    wp_enqueue_style('best-one-reset', get_template_directory_uri() . '/style-reset.css', array(), $reset_css_version);
    wp_enqueue_style('best-one-base', get_template_directory_uri() . '/style-base.css', array(), $base_css_version);
    wp_enqueue_style('best-one-style', get_stylesheet_uri(), array(), $style_css_version);
}
add_action('wp_enqueue_scripts', 'best_one_styles');


// Enqueue mini-scripts script
function enqueue_mini_scripts()
{
    wp_enqueue_script('mini-scripts', get_template_directory_uri() . '/js/mini-scripts.js', array('jquery'), null, true);
    wp_localize_script('mini-scripts', 'miniScriptsData', array(
        'current_post_id' => get_the_ID(),
        'ajax_url' => admin_url('admin-ajax.php'),
        'test' => 'test',
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_mini_scripts');


// Enqueue Lightbox script
function enqueue_lightbox_script()
{
    wp_enqueue_script('lightbox', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_script');


// Enqueue ACF Form steps script
function enqueue_acf_form_steps_script()
{
    wp_enqueue_script('acf-form-steps', get_template_directory_uri() . '/js/acf-form-steps.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_acf_form_steps_script');





// Enqueue custom login page styles
function custom_login_styles()
{
    wp_enqueue_style('custom-login-styles', get_template_directory_uri() . '/css/login-styles.css');
}
add_action('login_enqueue_scripts', 'custom_login_styles');

// =======================
// Disable/Remove Unwanted Features
// =======================

// Disable emojis
function disable_emojis()
{
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

// Remove TinyMCE emoji plugin
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

// Remove emoji CDN hostname from DNS prefetching hints
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
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

// Remove WordPress version number from head
remove_action('wp_head', 'wp_generator');

// Disable admin bar on the front end
add_filter('show_admin_bar', '__return_false');

// Dequeue global and classic styles
function dequeue_global_and_classic_styles()
{
    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'dequeue_global_and_classic_styles', 100);

// =======================
// Custom Functions
// =======================



// Update 'pro_review_total' field on save
function update_pro_review_total($post_id)
{
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }
    if (get_post_type($post_id) !== 'pro_reviews') {
        return;
    }

    $quality = get_field('pro_review_quality', $post_id);
    $price = get_field('pro_review_price', $post_id);
    $timing = get_field('pro_review_timing', $post_id);
    $human = get_field('pro_review_human', $post_id);

    $average = ($quality + $price + $timing + $human) / 4;
    $rounded_average = round($average);

    update_field('pro_review_total', $rounded_average, $post_id);

    $pro_id = get_field('pro_review_pro_is', $post_id);

    if ($pro_id) {
        $reviews_query = new WP_Query([
            'post_type' => 'pro_reviews',
            'meta_query' => [
                [
                    'key' => 'pro_review_pro_is',
                    'value' => $pro_id,
                    'compare' => '='
                ]
            ]
        ]);

        $review_count = $reviews_query->found_posts;
        $total_rating = 0;
        $total_count = 0;

        if ($reviews_query->have_posts()) {
            while ($reviews_query->have_posts()) {
                $reviews_query->the_post();
                $total = get_field('pro_review_total', get_the_ID());
                if ($total) {
                    $total_rating += $total;
                    $total_count++;
                }
            }
            wp_reset_postdata();
        }

        $average_rating = ($total_count > 0) ? ($total_rating / $total_count) : 0;

        update_field('pro_recommended_count', $review_count, $pro_id);
        update_field('pro_total_rate', round($average_rating), $pro_id);
    }
}
add_action('save_post', 'update_pro_review_total');


// Generate the title and slug from ACF fields on save
function set_pros_title_and_slug_from_acf($post_id)
{


    // Check if this is a "pros" post type
    if (get_post_type($post_id) != 'pros') {
        return;
    }

    // Check if the ACF fields are set
    if (!isset($_POST['acf'])) {
        return;
    }

    // Get the ACF fields
    $first_name = get_field('pro_first_name', $post_id);
    $last_name = get_field('pro_last_name', $post_id);

    // Generate the title and slug
    if ($first_name && $last_name) {
        $new_title = $first_name . ' ' . $last_name;
        $new_slug = sanitize_title($new_title);

        // Update the post title and slug
        $post_data = array(
            'ID'         => $post_id,
            'post_title' => $new_title,
            'post_name'  => $new_slug,
        );

        // Remove the action to avoid infinite loop
        remove_action('save_post', 'set_pros_title_and_slug_from_acf');

        // Update the post
        wp_update_post($post_data);

        // Re-add the action
        add_action('save_post', 'set_pros_title_and_slug_from_acf');
    }
}
add_action('save_post', 'set_pros_title_and_slug_from_acf');



// =======================
// Disable wordpress comments
// =======================

// Disable support for comments and trackbacks in post types
function disable_comments_post_types_support()
{
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'disable_comments_post_types_support');

// Close comments on the front-end
function disable_comments_status()
{
    return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

// Hide existing comments
function disable_comments_hide_existing_comments($comments)
{
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function disable_comments_admin_menu()
{
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

// Redirect any user trying to access comments page
function disable_comments_admin_menu_redirect()
{
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function disable_comments_dashboard()
{
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'disable_comments_dashboard');

// Remove comments links from admin bar
function disable_comments_admin_bar()
{
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'disable_comments_admin_bar');

// Function to completely unregister the "tags" taxonomy
function unregister_tags_taxonomy()
{
    global $wp_taxonomies;

    // Remove the taxonomy from the global $wp_taxonomies array
    unset($wp_taxonomies['post_tag']);
}
add_action('init', 'unregister_tags_taxonomy', 20);

function redirect_users_on_login($redirect_to, $request, $user)
{
    // Check if the user object is valid
    if (isset($user->roles) && is_array($user->roles)) {
        // Check if the user has the 'administrator' or 'editor' role
        if (in_array('administrator', $user->roles) || in_array('editor', $user->roles)) {
            // Redirect to the admin settings page
            return admin_url('admin.php?page=site-settings');
        } else {
            // Redirect other roles to the home_url('/me')
            return home_url('/me');
        }
    }
    // Return the original redirect URL if the user is not properly set
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_users_on_login', 10, 3);


// Function to set logout redirect to homepage
function custom_logout_redirect($logout_url, $redirect)
{
    // Append the redirect_to parameter to the logout URL
    $logout_url = add_query_arg('redirect_to', home_url(), $logout_url);
    return $logout_url;
}
add_filter('logout_url', 'custom_logout_redirect', 10, 2);


// Function to remove the "Remember Me" option from the wp_login_form()
function remove_remember_me($args)
{
    $args['remember'] = false;
    return $args;
}
add_filter('login_form_defaults', 'remove_remember_me');


// Function to replace login labels with placeholders
function replace_login_labels_with_placeholders()
{
?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Select the username and password input fields
            var usernameField = document.getElementById('user_login');
            var passwordField = document.getElementById('user_pass');

            // Set the placeholder attribute to the label text
            usernameField.setAttribute('placeholder', 'דואר אלקטרוני');
            passwordField.setAttribute('placeholder', 'סיסמה');

            // Hide the login labels (optional)
            var usernameLabel = document.querySelector('label[for="user_login"]');
            var passwordLabel = document.querySelector('label[for="user_pass"]');
            if (usernameLabel && passwordLabel) {
                usernameLabel.style.display = 'none';
                passwordLabel.style.display = 'none';
            }
        });
    </script>
<?php
}
add_action('login_enqueue_scripts', 'replace_login_labels_with_placeholders');



// Function to set placeholders to ACF fields based on field labels
function set_acf_field_placeholders($field)
{
    // Check if the field has a label and if it's not empty
    if ($field['label'] && !empty($field['label'])) {
        // Set the "placeholder" attribute to the field label
        $field['placeholder'] = $field['label'];
    }
    return $field;
}
add_filter('acf/load_field', 'set_acf_field_placeholders');

// Unregister default image sizes
function custom_unregister_image_sizes()
{
    remove_image_size('1536x1536');
    remove_image_size('2048x2048');
}
add_action('init', 'custom_unregister_image_sizes');


// Add shortcode support for acf specific fields:
add_filter('acf/format_value/name=top_nav_link_custom', 'do_shortcode');

// Show template file on console (when on local enviorment)
add_action('wp_head', 'show_template_file_in_console');

function show_template_file_in_console() {
    if (WP_DEBUG && ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1')) {
        global $template;
        $template_file = basename($template);
        echo "<script>console.log('Current Template: {$template_file}');</script>";
    }
}
