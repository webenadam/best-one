<?php get_header(); ?>

<?php
// Add this to the top of your page-add-pro.php file
function add_pro_page_scripts() {
    error_log('Enqueueing scripts');
    wp_enqueue_script('my-custom-script', get_template_directory_uri() . '/js/my-custom-script.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'add_pro_page_scripts');
?>

<a href="<?= get_home_url(); ?>" class="back-home-button absolute" style="top: 150px; right: 0px; background-color: var(--black); color: white; 
           border-radius: 99px 0px 0px 99px; padding: 1px 14px; font-size: var(--font-s);">
    <?= svg_icon('left-arrow', '#fff', 'flip-h'); ?>
    חזרה לדף הבית
</a>
<style>
    .class {
        color: var(--black);
    }
</style>


<section id="hero" class="header-padding" style="height: 423px; background-image: url('<?= theme_uri('/img/hero_bg.jpg'); ?>'); 
background-position: top right; background-repeat: no-repeat; background-color: var(--soft-background); overflow: visible;">
    <inner class="relative flex justify-between">
        <div class="right" style="margin-top: 33px; width: 80%;">

            <h2 class="" style="font-size: var(--font-xxl); margin-top: 0px; margin-bottom:10px;"><?= get_the_title(); ?></h2>
            <div id="expert-tags" class="flex gap-s" style="margin-bottom:80px;">
                <?php
                // Get the terms for the current post in the "expert" taxonomy
                $experts = get_the_terms(get_the_ID(), 'expert');

                // Check if terms are found and are not empty
                if ($experts && !is_wp_error($experts)) {
                    // Loop through each term
                    foreach ($experts as $expert) {
                        // Get the term permalink
                        $expert_link = get_term_link($expert);
                        // Echo the term with the specified format
                        tag_label(esc_html($expert->name), esc_url($expert_link), 'big green');
                    }
                }
                ?>
            </div>

           
        </div>
        <div class="left">
            <span style="position: absolute; top: 24px; left: -30px;"><?= svg_icon('dots'); ?></span>
         
        </div>
    </inner>
</section>

<section id="form">
    <inner style="padding-left: 30%; padding-top:100px; padding-bottom:160px;">
        <?php acfe_form('add-pro'); ?>

    </inner>
    </inner>
</section>

<section id="expert-terms" class="full relative" style="overflow:visible; background-color: var(--blue); background-image: url('<?= theme_uri('/img/squares_bg.png'); ?>'); background-repeat: no-repeat; background-position: left center;">
    <div class="absolute square-thing" style="bottom:-100px;right:-100px;"><?= svg_icon('square'); ?></div>
    <inner>
        <h2 style="color: white;">תחומי התמחות</h2>
        <grid class="grid-3" style="margin-bottom: 10px;">
            <?php
            if (!empty($experts) && !is_wp_error($experts)) {
                foreach ($experts as $expert_term) {
            ?>
                    <a href="<?= esc_url(get_term_link($expert_term)); ?>" class="category-block">
                        <h3><?= esc_html($expert_term->name); ?></h3>
                        <h6><?= esc_html($expert_term->count); ?> בעלי מקצוע</h6>
                    </a>
            <?php
                }
            }
            ?>
        </grid>
    </inner>
</section>

<section id="reviews" class="light" style="padding-top: 50px;">
    <inner class="flex-column align-center" style="text-align: center;">
        <h2 style="color: var(--green); width: 500px; margin-bottom:70px;"><span style="border-bottom: 2px solid var(--blue);"><?= get_field('pro_recommended_count'); ?>
                אנשים</span> שיתפו את החוויה שלהם עם <?= get_the_title(); ?></h2>
        <?php
        $current_post_id = get_the_ID();
        $args = array(
            'post_type' => 'pro_reviews',
            'meta_query' => array(
                array(
                    'key' => 'pro_review_pro_is',
                    'value' => $current_post_id,
                    'compare' => '=',
                ),
            ),
        );

        $review_query = new WP_Query($args);
        if ($review_query->have_posts()) {
        ?>
            <div class="flex-column gap-l"><?php
                                            while ($review_query->have_posts()) {
                                                $review_query->the_post();
                                                pro_review(get_the_ID());
                                            }
                                            wp_reset_postdata();
                                            ?></div>
        <?php } else {
            echo 'טרם נוספו המלצות לבעל המקצוע הזה.';
        }
        ?>
    </inner>
</section>

<section id="featured-pros" class="light align-center">
    <inner>
        <h2 style="margin-bottom: 30px;">בעלי מקצוע נוספים בתחום</h2>
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
