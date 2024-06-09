<?php

// AJAX handler for filtering and sorting posts
function filter_sort_posts()
{
    // Check if necessary POST parameters are set
    if (!isset($_POST['expert'])) {
        wp_send_json_error('Missing parameters: expert');
        wp_die();
    }

    // Sanitize input parameters
    $place_input = isset($_POST['place']) ? sanitize_text_field($_POST['place']) : '';
    $expert = isset($_POST['expert']) ? intval($_POST['expert']) : '';
    $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : '';
    $loaded_post_ids = isset($_POST['loaded_post_ids']) ? array_map('intval', $_POST['loaded_post_ids']) : array();
    $current_post_count = isset($_POST['current_post_count']) ? intval($_POST['current_post_count']) : 9;



    // Determine the number of posts per load
    $posts_per_load = max(9 - $current_post_count, 3);

    // Arguments for WP_Query
    $args = array(
        'post_type' => 'pros',
        'posts_per_page' => $posts_per_load,
        'post__not_in' => $loaded_post_ids,
    );

    // Initialize tax query array
    $tax_query = array();
// error_log('Place Input before places: ' . $place_input);
    // Fetch matching place and area terms and add their IDs to the query if a place is chosen
    if (!empty($place_input)) {
        $matching_places = get_terms(array(
            'taxonomy' => 'places',
            'search' => $place_input, // Use wildcard to match terms that start with the input
            'fields' => 'ids'
        ));

        $matching_areas = get_terms(array(
            'taxonomy' => 'areas',
            'search' => $place_input, // Use wildcard to match terms that start with the input
            'fields' => 'ids'
        ));
        // Debugging to verify parameters
        // error_log('Expert ID: ' . $expert);
        // error_log('Sort By: ' . $sort_by);
        // error_log('Loaded Post IDs: ' . implode(', ', $loaded_post_ids));
        // error_log('Current Post Count: ' . $current_post_count);
        // error_log('place input: ' . $place_input);

        // error_log('Matching Places: ' . print_r($matching_places, true));
        // error_log('Matching Areas: ' . print_r($matching_areas, true));

        // Initialize a relation OR for the tax query
        $tax_query = array('relation' => 'AND');

        if (!empty($matching_places) && !is_wp_error($matching_places)) {
            $tax_query[] = array(
                'taxonomy' => 'places',
                'field' => 'term_id',
                'terms' => $matching_places,
                'operator' => 'IN'
            );
        }

        if (!empty($matching_areas) && !is_wp_error($matching_areas)) {
            $tax_query[] = array(
                'taxonomy' => 'areas',
                'field' => 'term_id',
                'terms' => $matching_areas,
                'operator' => 'IN'
            );
        }

        if (empty($matching_places) && empty($matching_areas)) {
            // If no matching places or areas, ensure no posts are returned
            $tax_query[] = array(
                'taxonomy' => 'places',
                'field' => 'term_id',
                'terms' => array(0), // Invalid term ID to return no posts
                'operator' => 'IN'
            );
        }
    }


    // Tax query for expert
    if (!empty($expert)) {
        $tax_query[] = array(
            'taxonomy' => 'expert',
            'field' => 'term_id',
            'terms' => $expert,
        );
    }

    // Add tax query to arguments if not empty
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    // Sort by meta value
    if (!empty($sort_by)) {
        if ($sort_by == 'pro_total_rate' || $sort_by == 'pro_recommended_count') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = $sort_by;
            $args['order'] = 'DESC';
        } else {
            $args['orderby'] = 'rand';
        }
    }

    // Debugging the final query arguments
    // error_log('Query Args: ' . print_r($args, true));

    // Execute the query
    $query = new WP_Query($args);

    // error_log('Query Result Count: ' . $query->found_posts);
    // Check if there are posts
    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            profile_box(get_the_ID(), true); // Assuming $dark_mode = true
        }
        $posts_html = ob_get_clean();

        // Calculate total posts count
        $total_posts = $query->found_posts;
        $no_more_posts = (count($loaded_post_ids) + $posts_per_load) >= $total_posts;

        $response = array(
            'html' => $posts_html,
            'no_more_posts' => $no_more_posts,
            'loaded_post_ids' => array_merge($loaded_post_ids, wp_list_pluck($query->posts, 'ID'))
        );
        wp_send_json_success($response);
    }  
            // If no posts found with both filters, try only with the expert filter
           else if (!empty($expert)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'expert',
                        'field' => 'term_id',
                        'terms' => $expert,
                    ),
                );
        
                // Execute the query again with only the expert filter
                $query = new WP_Query($args);
        
                if ($query->have_posts()) {
                    ob_start();
                    while ($query->have_posts()) {
                        $query->the_post();
                        profile_box(get_the_ID(), true); // Assuming $dark_mode = true
                    }
                    $posts_html = ob_get_clean();
        
                    // Calculate total posts count
                    $total_posts = $query->found_posts;
                    $no_more_posts = (count($loaded_post_ids) + $posts_per_load) >= $total_posts;
        
                    $response = array(
                        'html' => $posts_html,
                        'no_more_posts' => $no_more_posts,
                        'loaded_post_ids' => array_merge($loaded_post_ids, wp_list_pluck($query->posts, 'ID')),
                        'place_filter_removed' => true, // Indicate that the place filter was removed
                        'notification' => '<div class="notification info" style="margin-bottom: var(--gap-s);">איזה באסה. לא מצאנו בעלי מקצוע בדיוק במקום שחיפשת. אבל הנה בעלי מקצוע ממקומות נוספים:</div>'
                    );
                    wp_send_json_success($response);
                } }  else {
        wp_send_json_error('No posts found');
    }

    wp_die();
}
add_action('wp_ajax_filter_sort_posts', 'filter_sort_posts');
add_action('wp_ajax_nopriv_filter_sort_posts', 'filter_sort_posts');
