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

<?php get_template_part('templates/singular-hero', null, array('page_title' => $page_title)); ?>

<section id="main-content">
    <inner>

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

<?php get_template_part('templates/featured-pros') ?>

<?php get_footer(); ?>
<style class="page-specific-styles">
    #main-content inner {
        padding-left: 30%;
        padding-top: 30px;
        padding-bottom: 160px;
    }

    @media (max-width: 780px) {
        #main-content inner {
            padding-left: 2%;
        }
    }
</style>
