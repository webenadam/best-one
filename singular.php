<?php get_header(); ?>

<?php get_template_part('template-parts/singular-hero') ?>

<section id="main_content">
    <inner style="padding-left: 30%; padding-top:30px; padding-bottom:160px;">
            <?php the_content(); ?>
        
        <div id="certificates">
            <grid class="grid-2 gap-l">
                <?php
                $certificates = get_field('pro_certs');
                if ($certificates) {
                    foreach ($certificates as $certificate) {
                        $image_id = $certificate['pro_cert_img'];
                        $image_url = wp_get_attachment_image_url($image_id, 'full');
                        $image_thumb = wp_get_attachment_image_url($image_id, array(300, 300));
                ?>
                        <div class="box border certificate-box shadow-l float-up" lightbox-type="image" lightbox-content="<?= esc_url($image_url); ?>" style="padding:var(--gap-s);">
                            <div class="cert_img radius-s" style="height:300px;background-image: url('<?= esc_url($image_thumb); ?>');background-size:cover;background-position:top center; margin-bottom:10px;"></div>
                            <h5><?= esc_attr($certificate['pro_cert_title']); ?></h5>
                        </div>
                <?php
                    }
                }
                ?>
            </grid>
        </div>
    </inner>
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
