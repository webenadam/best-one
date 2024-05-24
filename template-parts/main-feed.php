<!-- template-parts/main-feed.php -->
<?php
// Get featured pros
$featured_pros = isset($args['featured_pros']) ? $args['featured_pros'] : '';

// Get used places terms
$places_terms = get_terms(array(
    'taxonomy' => 'places',
    'hide_empty' => true, // Only show terms that are used by posts
));

// Get used expert terms
$expert_terms = get_terms(array(
    'taxonomy' => 'expert',
    'hide_empty' => true, // Only show terms that are used by posts
));

// Query the "pros" post type
$args = array(
    'post_type' => 'pros',
    'post__not_in' => $featured_pros,
    'posts_per_page' => 9, // Retrieve initial posts
);
$query = new WP_Query($args);

// Collect the IDs of initially loaded posts
$initial_post_ids = array();
?>
<section class="section-main-feed relative" style="overflow:hidden;">
    <div class="dots_ico absolute" style="top: 330px;left: -26px;">
        <?php echo svg_icon('dots'); ?>
    </div>
    <inner>
        <filters class="flex gap-m" style="width:100%; margin-bottom:40px;">
            <input class="places-input places-typeahead autocomplete-input" name="place" dir="rtl" type="text" placeholder="בחר מיקום"/>
            <select class="expert_select" name="experties">
                <option value=""><?php _e('כל התחומים', 'textdomain'); ?></option>
                <?php foreach ($expert_terms as $expert_term): ?>
                    <option value="<?php echo esc_attr($expert_term->term_id); ?>"><?php echo esc_html($expert_term->name); ?></option>
                <?php endforeach; ?>
            </select>
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
            <button class="button load_more_main_feed">טען בעלי מקצוע נוספים <?php echo svg_icon('left-arrow', 'white'); ?></button>
        </div>
    </inner>
</section>

<script type="text/javascript">
    var initialLoadedPostIds = <?php echo json_encode($initial_post_ids); ?>;
</script>
