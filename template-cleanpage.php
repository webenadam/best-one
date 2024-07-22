<?php
/*
Template Name: דף נקי
*/
?>
<?php set_query_var('cleanpage', true); ?>
<?php get_header(); ?>
<style>
    html, body {
        width:100%;
        height: 100%;
    }
</style>
<section class="flex justify-center align-center" style="width:100%; height:100%;">
    <inner class="flex justify-center align-center" style="width:100%; height:100%;">
        <?php the_content(); ?>

    </inner>
</section>

<?php get_footer(); ?>
