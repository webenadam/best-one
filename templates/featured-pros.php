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
