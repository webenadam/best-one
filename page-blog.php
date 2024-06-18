<?php
/*
Template Name: Blog Page
*/

get_header(); ?>

<?php get_template_part('templates/singular-hero') ?>

        <?php
        // Query for the featured post
        $featured_args = array(
            'post_type' => 'post',
            'posts_per_page' => 1,
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
        // Get all categories
        $categories = get_categories(array(
            'hide_empty' => true,
        ));
        $i = 0;
        foreach ($categories as $category) {
            // Query for the latest 3 posts in each category
            $cat_args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'cat' => $category->term_id,
            );
            $cat_query = new WP_Query($cat_args);

            if ($cat_query->have_posts()) {
                ?>
                <section class="category-section <?php echo ($i % 2 == 1) ? 'dark' : 'light'; ?>">
                <inner>
                    <h2 class="category-title" style="margin-bottom:var(--gap-s);">
                        <a href="<?php echo get_category_link($category->term_id); ?>">
                            <?php echo $category->name; ?>
                        </a>
                    </h2>
                    <grid class="grid-3" style="margin-bottom:var(--gap-l);">
                        <?php
                        while ($cat_query->have_posts()) {
                            $cat_query->the_post();
                            post_block(get_the_ID());
                        }
                        ?>
                    </grid>
                    <a class="show-all-link" href="<?php echo get_category_link($category->term_id); ?>" style="color:var(--green); align-self: end; font-size:var(--font-s); font-weight:var(--font-w-600);">
                        הצג את כל הפוסטים בקטגוריה <?php echo $category->name; ?> <?php echo svg_icon('left-arrow'); ?>
                    </a>
                    </inner>
                </section>
                <?php
                $i++;
                wp_reset_postdata();
            }
        }
        ?>

<?php get_footer(); ?>
