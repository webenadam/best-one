<?php
$page_title = isset($args['page_title']) ? $args['page_title'] : get_the_title();

if (has_post_thumbnail()) {
    $full_image_url = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full'));
    $medium_image_url = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium_large'));
    $thumbnail_image_url = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium'));
    $default_position = 'center center';
    $default_size = 'cover';
} else {
    $full_image_url = $medium_image_url = $thumbnail_image_url = theme_uri('/img/hero_bg.jpg');
    $default_position = 'top right';
    $default_size = 'auto';
}
?>

<style>
    #hero {
        background-image: <?= has_post_thumbnail() ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$full_image_url}')" : "url('{$full_image_url}')" ?>;
        background-position: <?= $default_position ?>;
        background-size: <?= $default_size ?>;
        background-repeat: no-repeat;
        background-color: var(--soft-background);
        overflow: visible;
    }

    @media (max-width: 1024px) {

        /* Tablet */
        #hero {
            background-image: <?= has_post_thumbnail() ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$medium_image_url}')" : "url('{$medium_image_url}')" ?>;
        }
    }

    @media (max-width: 768px) {

        /* Mobile */
        #hero {
            background-image: <?= has_post_thumbnail() ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$thumbnail_image_url}')" : "url('{$thumbnail_image_url}')" ?>;
        }
    }
</style>


<section id="hero" class="header-padding" style="position:relative; z-index:5; height: 323px;">
    <inner class="relative flex justify-between">
        <div class="right" style="margin-top: 33px; width: 80%;">
        <style>
            #hero h2 {
                font-size: var(--font-xxxl);
                margin-top: 0px;
                margin-bottom: 10px;
            }
            @media (max-width: 780px) {
                #hero h2 {
                    font-size: var(--font-xl);
                }
            }
        </style>
        <div class="dots_ico absolute hide-tablet" style="top: -40px;left: -26px;">
        <?= svg_icon('dots'); ?>
    </div>
            <h2>
                <?= $page_title;
                ?>
            </h2>

            <div id="category-tags" class="flex gap-s" style="margin-bottom:80px;">
                <?php
                // Get the terms for the current post in the "category" taxonomy
                $categories = get_the_terms(get_the_ID(), 'category');

                // Check if terms are found and are not empty
                if ($categories && !is_wp_error($categories)) {
                    // Loop through each term
                    foreach ($categories as $category) {
                        // Get the term permalink
                        $category_link = get_term_link($category);
                        // Echo the term with the specified format
                        tag_label(esc_html($category->name), esc_url($category_link), 'big green');
                    }
                }
                ?>
            </div>

        </div>
        <div class="left">

        </div>
    </inner>
</section>
