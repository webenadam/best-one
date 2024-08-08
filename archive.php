<?php
/*
Template Name: Archive Page
*/
// Get the current taxonomy term
$term = get_queried_object();

get_header(); ?>

<?php get_template_part('templates/singular-hero', null, array('page_title' => $term->name)) ?>

<?php

// Query for the featured post in the current taxonomy
$featured_args = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => $term->taxonomy,
            'field' => 'term_id',
            'terms' => $term->term_id,
        ),
    ),
    'meta_key' => 'is_featured',
    'meta_value' => '1'
);
$featured_query = new WP_Query($featured_args);

if ($featured_query->have_posts()) {
    while ($featured_query->have_posts()) {
        $featured_query->the_post();
?>
        <div class="featured-post">
            <?php post_block(get_the_ID()); ?>
        </div>
<?php
    }
    wp_reset_postdata();
}
?>

<?php
// Query for the latest posts in the current taxonomy
$cat_args = array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'tax_query' => array(
        array(
            'taxonomy' => $term->taxonomy,
            'field' => 'term_id',
            'terms' => $term->term_id,
        ),
    ),
);
$cat_query = new WP_Query($cat_args);

if ($cat_query->have_posts()) {
?>
    <section class="category-section">
        <inner>
            <grid class="grid-3" style="margin-bottom:var(--gap-l);">
                <?php
                while ($cat_query->have_posts()) {
                    $cat_query->the_post();
                    post_block(get_the_ID());
                }
                ?>
            </grid>
            <a class="show-all-link" href="<?= get_term_link($term); ?>" style="color:var(--green); align-self: end; font-size:var(--font-s); font-weight:var(--font-w-600);">
                הצג את כל הפוסטים בקטגוריה <?= $term->name; ?> <?= svg_icon('left-arrow'); ?>
            </a>
        </inner>
    </section>
<?php
    wp_reset_postdata();
}
?>

<?php get_footer(); ?>
