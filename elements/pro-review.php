<?php

// Function to render the pro review
function pro_review($post_id, $dark = false)
{
    // Get the custom fields and taxonomies
    $review_user_name = get_field('pro_review_user_name', $post_id) ? get_field('pro_review_user_name', $post_id) : get_the_title($post_id);
    $pro_review_business_date = get_field('pro_review_business_date', $post_id);
    $pro_review_place = get_field('pro_review_place', $post_id);
    $pro_review_quality = get_field('pro_review_quality', $post_id);
    $pro_review_price = get_field('pro_review_price', $post_id);
    $pro_review_timing = get_field('pro_review_timing', $post_id);
    $pro_review_human = get_field('pro_review_human', $post_id);
    $pro_review_total = get_field('pro_review_total', $post_id);
    $pro_review_email = get_field('pro_review_email', $post_id);

    // Get the avatar URL from the featured image
    if ($avatar_url = get_avatar_url($pro_review_email)) {
        $avatar_url = get_avatar_url($pro_review_email);
    } else {
        $avatar_url = get_template_directory_uri() . '/img/avatar.jpg'; // Default placeholder image
    }


    // Add dark class if the dark option is set to true
    $box_class = $dark ? 'dark' : '';

    // Dark mode borders
    $borders_color = $dark ? 'var(--light-gray)' : 'var(--soft-background)';
    $borders_width = $dark ? '1px' : '2px';

?>
    <box class="review <?= esc_attr($box_class); ?> flex gap-l mobile-gap-s" style="width:min(100%,750px);">
        <right>
            <avatar-s style="background-image: url('<?= esc_url($avatar_url); ?>')"></avatar-s>
        </right>
        <left>
            <?= star_rating($pro_review_total); ?>

            <p style="margin-bottom:6px;"><?= get_the_content($post_id); ?></p>
            <h6 class="place flex align-center" style="gap: 5px; margin-bottom:25px;">
                <?= svg_icon('place'); ?>
                <?= get_term($pro_review_place)->name; ?> | <?= esc_html($review_user_name); ?>
            </h6>
            <div class="flex review-datas gap-m" style="font-size:var(--font-s); color:var(--gray);">
                <style>
                    .review-datas span {
                        color: var(--blue);
                    }
                </style>
                <div>יחס: <span><?= $pro_review_human; ?></span>/5</div>
                <div>איכות: <span><?= $pro_review_quality; ?></span>/5</div>
                <div>מחיר: <span><?= $pro_review_price; ?></span>/5</div>
                <div>זמנים: <span><?= $pro_review_timing; ?></span>/5</div>
            </div>
        </left>
        <h6 class="absolute review-date-ago" style="top:var(--gap-s);left:var(--gap-m);"><?= hebrew_date_difference($pro_review_business_date); ?></h6>
    </box>

<?php
}
?>
