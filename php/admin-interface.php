<?php

// =======================
// Login Customization
// =======================

// Custom login logo URL to point to the site's homepage
function custom_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'custom_login_logo_url');

// Custom login logo title to show the site's name
function custom_login_logo_url_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertext', 'custom_login_logo_url_title');


// =======================
// User Roles and Custom Columns
// =======================

// Add 'pro' user role
function add_pro_role()
{
    add_role(
        'pro',
        __('בעל מקצוע', 'textdomain'),
        array('read' => true)
    );
}
add_action('init', 'add_pro_role');

// Add custom thumbnail column to "pros" post type
function add_pros_thumbnail_column($columns)
{
    $new_columns = array('thumbnail' => '');
    return array_merge($new_columns, $columns);
}
add_filter('manage_pros_posts_columns', 'add_pros_thumbnail_column');

// Display featured image in custom column
function display_pros_thumbnail_column($column, $post_id)
{
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

// Style the custom column
function pros_admin_columns_styles()
{
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


// =======================
// Taxonomy Export and Custom Columns
// =======================

// Function to export custom taxonomy terms
function export_custom_taxonomy_terms()
{
    if (isset($_GET['export_terms']) && isset($_GET['taxonomy'])) {
        $taxonomy = sanitize_text_field($_GET['taxonomy']);
        $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false));

        if (!empty($terms) && !is_wp_error($terms)) {
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . $taxonomy . '_terms.txt"');

            foreach ($terms as $term) {
                echo $term->name . ' - ' . $term->term_id . PHP_EOL;
            }
            exit;
        }
    }
}
add_action('admin_init', 'export_custom_taxonomy_terms');

// Add export button to each taxonomy terms list screen
function add_export_button_to_taxonomy_screens()
{
    $taxonomies = get_taxonomies(array('public' => true), 'objects');

    foreach ($taxonomies as $taxonomy) {
        add_action('admin_notices', function() use ($taxonomy) {
            global $pagenow;
            if ($pagenow == 'edit-tags.php' && isset($_GET['taxonomy']) && $_GET['taxonomy'] == $taxonomy->name) {
                export_terms_button($taxonomy->name);
            }
        });
    }
}
add_action('admin_menu', 'add_export_button_to_taxonomy_screens');

// Display export button on taxonomy terms list page
function export_terms_button($taxonomy)
{
?>
    <div class="notice notice-success is-dismissible">
        <p>
            <a href="<?= esc_url(admin_url('edit-tags.php?taxonomy=' . $taxonomy . '&export_terms=1')); ?>" class="button button-primary">Export <?= esc_html(ucfirst($taxonomy)); ?> Terms</a>
        </p>
    </div>
<?php
}


// Add custom columns to "areas" taxonomy list
function add_custom_areas_columns($columns)
{
    $columns['area_child_places'] = __('מקומות משנה');
    $columns['area_child_areas'] = __('איזורי משנה');
    $posts = $columns['posts'];
    unset($columns['posts']);
    $columns['posts'] = $posts;
    return $columns;
}
add_filter('manage_edit-areas_columns', 'add_custom_areas_columns');

// Populate custom columns with data
function populate_custom_areas_columns($content, $column_name, $term_id)
{
    if ($column_name == 'area_child_places') {
        $child_places = get_field('area_child_places', 'areas_' . $term_id);
        if ($child_places) {
            $child_places = array_filter($child_places);
            $links = array_map(function ($place_id) {
                $place = get_term($place_id, 'places');
                return $place ? '<a href="' . get_edit_term_link($place_id, 'places') . '">' . $place->name . '</a>' : '';
            }, $child_places);
            $links = array_filter($links);
            $content = implode(', ', $links);
        } else {
            $content = '';
        }
    } elseif ($column_name == 'area_child_areas') {
        $child_areas = get_field('area_child_areas', 'areas_' . $term_id);
        if ($child_areas) {
            $child_areas = array_filter($child_areas);
            $links = array_map(function ($area_id) {
                $area = get_term($area_id, 'areas');
                return $area ? '<a href="' . get_edit_term_link($area_id, 'areas') . '">' . $area->name . '</a>' : '';
            }, $child_areas);
            $links = array_filter($links);
            $content = implode(', ', $links);
        } else {
            $content = '';
        }
    }
    return $content;
}
add_filter('manage_areas_custom_column', 'populate_custom_areas_columns', 10, 3);

// Add custom columns to "places" taxonomy list
function add_custom_places_column($columns)
{
    $columns['place_parent_areas'] = __('איזורי אב');
    $posts = $columns['posts'];
    unset($columns['posts']);
    $columns['posts'] = $posts;
    return $columns;
}
add_filter('manage_edit-places_columns', 'add_custom_places_column');

// Populate custom columns with data
function populate_custom_places_column($content, $column_name, $term_id)
{
    if ($column_name == 'place_parent_areas') {
        $parent_areas = get_field('place_parent_areas', 'places_' . $term_id);
        if ($parent_areas) {
            $parent_areas = array_filter($parent_areas);
            $links = array_map(function ($area_id) {
                $area = get_term($area_id, 'areas');
                return $area ? '<a href="' . get_edit_term_link($area_id, 'areas') . '">' . $area->name . '</a>' : '';
            }, $parent_areas);
            $links = array_filter($links);
            $content = implode(', ', $links);
        } else {
            $content = '';
        }
    }
    return $content;
}
add_filter('manage_places_custom_column', 'populate_custom_places_column', 10, 3);



// Hide the title input field on the "pros" post type edit page
function hide_pros_title_input() {
    global $post_type;
    if ($post_type == 'pros') {
        echo '<style>
            #titlewrap {
                display: none;
            }
        </style>';
    }
}
add_action('admin_head', 'hide_pros_title_input');

// Hide the title input field on the "pros" post type edit page
function global_admin_custom_styles() {
    global $post_type;
        echo '<style>
        .acf-accordion .acf-accordion-title .acf-accordion-icon {
            transform: scaleX(-1);
        }
        </style>';
    }

add_action('admin_head', 'global_admin_custom_styles');
