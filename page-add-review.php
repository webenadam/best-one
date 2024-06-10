<?php get_header(); ?>

<?php
$pro_param = isset($_GET['pro']) ? $_GET['pro'] : null;
if ($pro_param) {
    $pro_post = get_post($pro_param);
}
if ($pro_post && $pro_post->post_type == 'pros') {
    $page_title = 'הוספת המלצה ל' . $pro_post->post_title;
} else {
    $page_title = 'הוספת המלצה';
}
?>

<?php get_template_part('template-parts/singular-hero', null, array('page_title' => $page_title)); ?>

<section id="main_content">
    <inner style="padding-left: 30%; padding-top:30px; padding-bottom:160px;">

        <?php

        // Check if a post with the 'pro' ID exists in the 'pros' post type
        if ($pro_post && $pro_post->post_type == 'pros') {
            // If the 'pro' parameter exists and a valid post is found, display the form
            acfe_form('add-review');
        } else {
            // If 'pro' parameter exists but no valid post is found, display an error message
            echo '<p>כדי להוסיף המלצה לבעל מקצוע יש <a href="' . site_url() . '/#main-feed">לבחור בעל מקצוע</a>.</p>';
        }

        ?>

    </inner>
</section>

<section id="featured-pros" class="light align-center">
    <inner>
        <h2 style="margin-bottom: 30px;">בעלי מקצוע מומלצים</h2>
        <grid class="grid-3">
            <?php
            $featured_pros = get_field('home_featured_pros', 'option');
            $args = array(
                'post_type' => 'pros',
                'post__in' => $featured_pros,
                'orderby' => 'post__in',
                'posts_per_page' => -1,
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    profile_box(get_the_ID(), $dark_mode = false);
                }
            } else {
                echo '<p>לא נמצאו בעלי מקצוע מומלצים.</p>';
            }
            wp_reset_postdata();
            ?>
        </grid>
    </inner>
</section>

<?php get_footer(); ?>
