<?php
// Get featured pros
$featured_pros = isset($args['featured_pros']) ? $args['featured_pros'] : '';

// Get used expert terms
$expert_terms = get_terms(array(
    'taxonomy' => 'expert',
    'hide_empty' => true, // Only show terms that are used by posts
));

// Initialize query arguments
$args = array(
    'post_type' => 'pros',
    'post__not_in' => $featured_pros,
    'posts_per_page' => 9, // Retrieve initial posts
);

// Initialize variables for pre-filling inputs
$place_input_value = '';
$expert_select_value = '';

// Check if there are expert and place parameters in the URL
$expert_param = isset($_GET['feed_expert']) ? intval($_GET['feed_expert']) : '';
$place_param = isset($_GET['feed_place']) ? sanitize_text_field($_GET['feed_place']) : '';

// Add taxonomy query if params are present
if ($expert_param || $place_param) {
    $tax_query = array('relation' => 'AND');
    
    if ($expert_param) {
        $tax_query[] = array(
            'taxonomy' => 'expert',
            'field' => 'term_id',
            'terms' => $expert_param,
        );
        $expert_select_value = $expert_param;
    }

    if ($place_param) {
        // Fetch matching place and area terms
        $matching_places = get_terms(array(
            'taxonomy' => 'places',
            'search' => $place_param, // Use wildcard to match terms that start with the input
            'fields' => 'ids'
        ));
        
        $matching_areas = get_terms(array(
            'taxonomy' => 'areas',
            'search' => $place_param, // Use wildcard to match terms that start with the input
            'fields' => 'ids'
        ));
        
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

        $place_input_value = $place_param;
    }

    $args['tax_query'] = $tax_query;
}

// Check if it's a taxonomy archive page
if (is_tax()) {
    $current_term = get_queried_object();
    if ($current_term) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $current_term->taxonomy,
                'field' => 'term_id',
                'terms' => $current_term->term_id,
            ),
        );

        // Pre-fill inputs based on taxonomy
        if ($current_term->taxonomy == 'places' || $current_term->taxonomy == 'areas') {
            $place_input_value = $current_term->name;
        } elseif ($current_term->taxonomy == 'expert') {
            $expert_select_value = $current_term->term_id;
        }
    }
}

// Query the "pros" post type
$query = new WP_Query($args);

// Collect the IDs of initially loaded posts
$initial_post_ids = array();
?>
<section id="main-feed" class="relative" style="overflow:hidden;">
    <div class="dots_ico absolute hide-tablet" style="top: 330px;left: -26px;">
        <?= svg_icon('dots'); ?>
    </div>
    <inner>
        <filters class="flex gap-m tablet-flex-column" style="width:100%; margin-bottom:40px;">
            <select class="expert_select" name="experties">
                <option value=""><?php _e('כל התחומים', 'textdomain'); ?></option>
                <?php foreach ($expert_terms as $expert_term): ?>
                    <option value="<?= esc_attr($expert_term->term_id); ?>" <?php selected($expert_select_value, $expert_term->term_id); ?>><?= esc_html($expert_term->name); ?></option>
                <?php endforeach; ?>
            </select>
            <input class="places-input places-typeahead autocomplete-input" name="place" dir="rtl" type="text" placeholder="בחר מיקום" value="<?= esc_attr($place_input_value); ?>"  />
            <select class="sort_by" style="margin-right:auto;">
                <option value="">סנן לפי</option>
                <option value="pro_total_rate">דירוג משוכלל</option>
                <option value="pro_recommended_count">המלצות</option>
            </select>
        </filters>
        <grid class="main-feed grid-3 relative ajax-done">
            <?php
            // Check if there are posts
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $initial_post_ids[] = get_the_ID();
                    profile_box(get_the_ID(), $dark_mode = true);
                }
            } else {
                echo '<p>לא נמצאו בעלי מקצוע מומלצים.</p>';
            }
            // Restore original post data
            wp_reset_postdata();
            ?>
        </grid>
        <div class="load_more_section flex justify-center" style="margin-top:75px;">
            <button class="button load_more_main_feed">טען בעלי מקצוע נוספים <?= svg_icon('left-arrow', 'white'); ?></button>
        </div>
    </inner>
</section>


<script type="text/javascript">
    var initialLoadedPostIds = <?= json_encode($initial_post_ids); ?>;
    jQuery(document).ready(function($) {
        function togglePlacesInput() {
            if ($('.expert_select').val()) {
                $('.places-input').show();
            } else {
                $('.places-input').hide();
            }
        }

        // Initial check
        togglePlacesInput();

        // Check on change
        $('.expert_select').change(function() {
            togglePlacesInput();
        });
    });
</script>
