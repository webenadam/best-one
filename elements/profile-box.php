<?php

// Function to render the profile box
function profile_box($pro_post_id, $dark = false, $featured = false)
{
    // Enqueue the CSS for the profile box (only once even when used multiple times on page)
    if (!wp_style_is('profile-box-styles', 'enqueued')) {
        wp_enqueue_style('profile-box-styles', get_template_directory_uri() . '/elements/profile-box.css');
    }

    // Get the custom fields and taxonomies
    $name = get_the_title($pro_post_id);

    // Get the location from the "places" taxonomy
    $location_terms = get_the_terms($pro_post_id, 'areas');
    $location = ($location_terms && !is_wp_error($location_terms)) ? $location_terms[0]->name : 'מקום לא ידוע';

    // Get the recommendations and rating from custom fields
    $recommendations = get_field('pro_recommended_count', $pro_post_id);
    $rating = get_field('pro_total_rate', $pro_post_id);

    // Get the avatar URL from the featured image
    if (has_post_thumbnail($pro_post_id)) {
        $avatar_url = get_the_post_thumbnail_url($pro_post_id, 'full');
    } else {
        $avatar_url = get_template_directory_uri() . '/img/avatar.jpg'; // Default placeholder image
    }

    // Get the expertise from the "expert" taxonomy
    $expertise_terms = get_the_terms($pro_post_id, 'expert');
    $expertise = ($expertise_terms && !is_wp_error($expertise_terms)) ? $expertise_terms : array();

    // Set basic classes
    $box_class = 'profile-box flex-column float-up';

    // Add dark class if the dark option is set to true
    if ($dark) {
        $box_class .= ' dark';
    }

    // Add featured class if the featured option is set to true
    if ($featured) {
        $box_class .= ' featured';
    }

    // Dark mode borders
    $borders_color = $dark ? 'var(--light-gray)' : 'var(--soft-background)';
    $borders_width = $dark ? '1px' : '2px';

?>
    <box class="<?= esc_attr($box_class); ?> stripes">
        <a href="<?= get_permalink($pro_post_id); ?>" class="absolute" style="top: 20px; left: 20px">
            <?php if ($featured) {
                echo svg_icon('link', "#473BF0");
            } else {
                echo svg_icon('link');
            } ?>
        </a>
        <div class="top flex" style="gap: 20px; margin-top:5px; padding-right: var(--gap-s);">
            <a href="<?= get_permalink($pro_post_id); ?>" style="position: relative;">
                <?php if (!$featured) { ?>
                    <avatar style="background-image: url('<?= esc_url($avatar_url); ?>')"></avatar>
                <?php } else { ?>
                    <span class="featured_trophy" style="
    position: absolute;
    top: -1px;
    right: -7px;
"><?= svg_icon('trophy'); ?></span>
                    <avatar style="background-image: url('<?= esc_url($avatar_url); ?>')"></avatar>
                <?php } ?>
            </a>
            <datas style="margin-bottom: 30px">
                <h3 class="name">
                    <a href="<?= get_permalink($pro_post_id); ?>"><?= esc_html($name); ?></a>
                </h3>
                <h6 class="place flex align-center" style="gap: 5px">
                    <a href="<?= get_term_link($location_terms[0]); ?>">
                        <?= svg_icon('place'); ?>
                        <?= esc_html($location); ?>
                    </a>
                </h6>
            </datas>
        </div>
        <bottom class="radius-s" style="border: <?= $borders_width; ?> solid <?= $borders_color; ?>;">
            <bottom-top class="flex" style="width:100%;border-bottom:<?= $borders_width; ?> solid <?= $borders_color; ?>;">
                <data style="border-left:<?= $borders_width; ?> solid <?= $borders_color; ?>;">
                    <h6 style="color:var(--black);">המלצות</h6>
                    <h3 style="color:var(--green);"><?= esc_html($recommendations); ?></h3>
                </data>
                <data>
                    <h6 style="color:var(--black);">דירוג משוכלל</h6>
                    <h3 style="color:var(--blue);"><?= esc_html($rating); ?></h3>
                </data>
            </bottom-top>
            <bottom-bottom>
                <data>
                    <h6 style="color:var(--black);margin-bottom:10px;">תחומי התמחות</h6>
                    <exprties>
                        <?php
                        foreach ($expertise as $expert) :
                            $expert_link = get_term_link($expert);
                            tag_label(esc_html($expert->name), esc_url($expert_link));
                        endforeach;
                        ?>
                    </exprties>
                </data>
            </bottom-bottom>
        </bottom>
    </box>

<?php

// update cube view counts for this pro
update_pro_stats('cube_views', $pro_post_id);



}
?>
