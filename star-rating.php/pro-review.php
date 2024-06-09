<?php

// Function to render the pro review
function pro_review($post_id, $dark = false)
{

    // Get the custom fields and taxonomies
    $name = get_the_title($post_id);
    $pro_review_business_date = get_field('pro_review_business_date', $post_id);
    $pro_review_place = get_field('pro_review_place', $post_id);
    $pro_review_quality = get_field('pro_review_quality', $post_id);
    $pro_review_price = get_field('pro_review_price', $post_id);
    $pro_review_timing = get_field('pro_review_timing', $post_id);
    $pro_review_human = get_field('pro_review_human', $post_id);
    $pro_review_total = get_field('pro_review_total', $post_id);

    // Get the avatar URL from the featured image
    if (has_post_thumbnail($post_id)) {
        $avatar_url = get_the_post_thumbnail_url($post_id, 'full');
    } else {
        $avatar_url = get_template_directory_uri() . '/img/avatar.jpg'; // Default placeholder image
    }

    // Add dark class if the dark option is set to true
    $box_class = $dark ? 'shadow-l dark' : 'shadow-l';

    // Dark mode borders
    $borders_color = $dark ? 'var(--light-gray)' : 'var(--soft-background)';
    $borders_width = $dark ? '1px' : '2px';

?>
    <box class="<?= esc_attr($box_class); ?> flex gap-l" style="width:750px;">
        <right>
            <avatar-xl style="background-image: url('<?= esc_url($avatar_url); ?>')"></avatar-xl>
        </right>
        <left>
            <p><?= get_the_content($post_id); ?></p>
            <h3 class="name" style="font-weight: var(--font-w-600);">
                <h6 class="place flex align-center" style="gap: 5px">
                    <?= svg_icon('place'); ?>
                    <?= get_term($pro_review_place)->name; ?>
                </h6> | <?= esc_html($name); ?>
            </h3>
            <div class="flex review-datas gap-m" style="font-size:var(--font-s); color:var(--gray);">
                <style>
                    .review-datas span {
                        color: var(--blue);
                    }
                </style>
                <div>יחס: <span><?= $pro_review_human; ?></span></div>
                <div>איכות: <span><?= $pro_review_quality; ?></span></div>
                <div>מחיר: <span><?= $pro_review_price; ?></span></div>
                <div>זמנים: <span><?= $pro_review_timing; ?></span></div>
            </div>
        </left>
        <h6 class="absolute review-date-ago" style="top:var(--gap-s);left:var(--gap-m);"><?= hebrew_date_difference($pro_review_business_date); ?></h6>
    </box>

<?php
}
?>
