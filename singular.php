<?php get_header(); ?>

<?php get_template_part('templates/singular-hero') ?>

<style>
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
<section id="main-content">

    <inner>
        <?php the_content(); ?>
    </inner>
</section>

<?php get_template_part('templates/featured-pros') ?>



<?php get_footer(); ?>
