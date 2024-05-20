<?php


// Function to render the profile box
function profile_box($post_id, $dark = false) {

    // Enqueue the CSS for the profile box (only once even when used multiple times on page)
    if (!wp_style_is('profile-box-styles', 'enqueued')) {
        wp_enqueue_style('profile-box-styles', get_template_directory_uri() . '/elements/profile-box.css');
    }

    // Get the custom fields and taxonomies
    $name = get_the_title($post_id);

    // Get the location from the "places" taxonomy
    $location_terms = get_the_terms($post_id, 'places');
    $location = ($location_terms && !is_wp_error($location_terms)) ? $location_terms[0]->name : 'Unknown location';

    // Get the recommendations and rating from custom fields
    $recommendations = get_field('pro_recommended_count', $post_id);
    $rating = get_field('pro_total_rate', $post_id);

    // Get the avatar URL from the featured image
    if (has_post_thumbnail($post_id)) {
        $avatar_url = get_the_post_thumbnail_url($post_id, 'full');
    } else {
        $avatar_url = get_template_directory_uri() . '/img/avatar.jpg'; // Default placeholder image
    }

    // Get the expertise from the "expert" taxonomy
    $expertise_terms = get_the_terms($post_id, 'expert');
    $expertise = ($expertise_terms && !is_wp_error($expertise_terms)) ? wp_list_pluck($expertise_terms, 'name') : array();

    // Add dark class if the dark option is set to true
    $box_class = $dark ? 'profile-box shadow-l flex-column float-up dark' : 'profile-box shadow-l flex-column float-up';

    // Dark mode borders
    $borders_color = $dark ? 'var(--light-gray)' : 'var(--soft-background)';
    $borders_width = $dark ? '1px' : '2px';

    ?>
    <box class="<?php echo esc_attr($box_class); ?>">
        <a href="<?php echo get_permalink($post_id); ?>" class="absolute" style="top: 20px; left: 20px">
            <?php echo get_svg_icon('link'); ?>
        </a>
        <a href="<?php echo get_permalink( $post_id ); ?>" class="top flex" style="gap: 20px; margin-top:5px;">
            <avatar style="background-image: url('<?php echo esc_url($avatar_url); ?>')"></avatar>
            <datas style="margin-bottom: 30px">
                <h3 class="name" style="font-weight: var(--font-w-600)">
                    <?php echo esc_html($name); ?>
                </h3>
                <h6 class="place flex align-center" style="gap: 5px">
                    <?php echo get_svg_icon('place'); ?>
                    <?php echo esc_html($location); ?>
                </h6>
            </datas>
        </a>
        <bottom class="radius-s" style="border: <?php echo $borders_width; ?> solid <?php echo $borders_color; ?>;">
            <bottom-top class="flex" style="width:100%;border-bottom:<?php echo $borders_width; ?> solid <?php echo $borders_color; ?>;">
                <data style="border-left:<?php echo $borders_width; ?> solid <?php echo $borders_color; ?>;">
                    <h6 style="color:var(--black);">המלצות</h6>
                    <h3 style="color:var(--green);"><?php echo esc_html($recommendations); ?></h3>
                </data>
                <data>
                    <h6 style="color:var(--black);">דירוג משוכלל</h6>
                    <h3 style="color:var(--blue);"><?php echo esc_html($rating); ?></h3>
                </data>
            </bottom-top>
            <bottom-bottom>
                <data>
                    <h6 style="color:var(--black);margin-bottom:10px;">תחומי התמחות</h6>
                    <exprties>
                        <?php foreach ($expertise as $expert): ?>
                            <tag><?php echo esc_html($expert); ?></tag>
                        <?php endforeach; ?>
                    </exprties>
                </data>
            </bottom-bottom>
        </bottom>
    </box>

    <?php }
    ?>