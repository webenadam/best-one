<?php get_header(); ?>
<?php
$pro_custom_background = get_field('pro_background_image');
$pro_reviews_count = get_field('pro_recommended_count');
$pro_post_id = get_the_ID();
$experts = get_the_terms($pro_post_id, 'expert');


if ($pro_custom_background) {
    $full_image_url = esc_url(wp_get_attachment_image_url($pro_custom_background, 'full'));
    $medium_image_url = esc_url(wp_get_attachment_image_url($pro_custom_background, 'medium_large'));
    $thumbnail_image_url = esc_url(wp_get_attachment_image_url($pro_custom_background, 'medium'));
    $default_position = 'center center';
    $default_size = 'cover';
    $tablet_size = 'auto 440px';
} else {
    $full_image_url = $medium_image_url = $thumbnail_image_url = theme_uri('/img/hero_bg.jpg');
    $default_position = 'top right';
    $default_size = 'auto';
    $tablet_size = $default_size;
}
?>

<style>
    #hero {
        background-image: <?= $pro_custom_background ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$full_image_url}')" : "url('{$full_image_url}')" ?>;
        background-position: <?= $default_position ?>;
        background-size: <?= $default_size ?>;
        background-repeat: no-repeat;
        background-color: var(--soft-background);
        overflow: visible;
        height: 423px;
        z-index: 5;
    }

    @media (max-width: 780px) {

        /* Tablet */
        #hero {
            height: unset;
            background-image: <?= $pro_custom_background ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$medium_image_url}')" : "url('{$medium_image_url}')" ?>;
            background-position: top center;
            background-size: <?= $tablet_size ?>;
        }

        #hero inner {
            padding-bottom: var(--gap-xl);
        }
    }

    @media (max-width: 550px) {

        /* Mobile */
        #hero {
            background-image: <?= $pro_custom_background ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$thumbnail_image_url}')" : "url('{$thumbnail_image_url}')" ?>;
        }
    }
</style>

<section id="hero" class="header-padding relative">
    <inner class="relative flex justify-between">
        <div class="right hide-tablet" style="margin-top: 33px; width: 80%;">



            <div class="areas">
                <?php $location_terms = get_the_terms($pro_post_id, 'areas');

                if ($location_terms && !is_wp_error($location_terms)) {
                    foreach ($location_terms as $location_term) {
                        $location = $location_term->name;
                ?>
                        <span class="area" style="color:var(--dark-gray);"><?= svg_icon('place'); ?>
                            <?= $location; ?></span>
                    <?php
                    }
                } else {
                    ?>
                    <span class="area"><?= svg_icon('place'); ?> מקום לא ידוע</span>
                <?php
                }
                ?>
            </div>
            <h1 class="pro-name bottom-gap-s" style="font-size: var(--font-xxl); margin-top: 0px;"><?= get_the_title(); ?></h1>
            <div id="expert-tags" class="flex gap-s" style="margin-bottom:85px;">
                <?php
                // Check if terms are found and are not empty
                if ($experts && !is_wp_error($experts)) {
                    // Loop through each term
                    foreach ($experts as $expert) {
                        // Get the term permalink
                        $expert_link = get_term_link($expert);
                        // Echo the term with the specified format
                        tag_label(esc_html($expert->name), esc_url($expert_link), 'big blue');
                    }
                }
                ?>
            </div>

            <style>
                .stat-item {
                    flex: 1;
                    padding: var(--gap-s) var(--gap-m);
                    border-left: 1px solid var(--soft-background);
                }

                .stat-label {
                    font-size: var(--font-s);
                    margin-top: -4px;
                    margin-bottom: -5px;
                }

                .stat-value {
                    font-size: var(--font-l);
                    font-weight: var(--font-w-700);
                    color: var(--green);

                }

                @media (max-width: 780px) {
                    .stat-item {
                        padding: var(--gap-xs) var(--gap-xs);
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                        align-items: center;
                    }

                    .stat-label {
                        font-size: var(--font-xs);

                    }
                }
            </style>
            <div>
                <div id="stats-box" class="box flex no-padding" style="width: 550px; height: 90px; float:right;margin-left:30px;">
                    <div class="stat-item">
                        <p class="stat-label"><a href="#reviews">המלצות</a></p>
                        <p class="stat-value"><?= get_field('pro_recommended_count'); ?></p>
                    </div>
                    <div class="stat-item">
                        <p class="stat-label">שנות נסיון</p>
                        <p class="stat-value"><?= get_pro_date($pro_post_id, 'exp'); ?></p>
                    </div>
                    <div class="stat-item">
                        <p class="stat-label">תחומי התמחויות</p>
                        <p class="stat-value"><?= count($experts); ?></p>
                    </div>

                </div>
                <div class="stat-item" style="flex: unset; width: 220px; float: right; border-left: unset;">
                    <p class="stat-label" style="font-weight:var(--font-w-600);"><a href="#reviews">דירוג משוקלל</a></p>
                    <?php $pro_review_total = get_field('pro_total_rate'); ?>
                    <div class="pro_rating">
                        <style>
                            .pro_rating .star-rating {
                                margin-bottom: 2px !important;
                                margin-right: 10px;
                            }
                        </style>
                        <a href="#reviews" class="flex align-center">
                            <p class="stat-value" style="color: var(--blue);"><?= $pro_review_total; ?></p>

                            <?= star_rating($pro_review_total); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <style>
            @media (max-width: 780px) {
                #hero .left {
                    width: 100%;
                }
            }
        </style>
        <div class="left">
            <style>
                .profile-image-wrap svg {
                    max-width: 18vw;
                    max-height:16vw
                }
            </style>
            <span class="hide-tablet" style="position: absolute; top: 24px; left: -30px;"><?= svg_icon('dots'); ?></span>
            <div class="box" style="margin-top: 23px; margin:auto; width: 347px; max-width:100%; background-color: white; padding: 20px; border-radius: 10px; display: flex; flex-direction: column; align-items: center;">
            <div class="profile-image-wrap relative" style="text-align: center;">
                <h2 class="hide-desktop" style="font-size: var(--font-xxl); margin-top: -20px; margin-bottom:0px;">איזור אישי</h2>
                <h3 class="hide-desktop" style="margin-top:-7px;margin-bottom:25px;color:var(--blue);"><?= $page_title; ?></h3>
                    <?php
                    $featured_image = get_the_post_thumbnail_url($pro_post_id, 'full');
                    if (empty($featured_image)) {
                        $featured_image = get_avatar_url($current_user_id);
                    }
                    ?>
                    <img src="<?= $featured_image; ?>" alt="Profile Picture" style="width: 304px;height: 247px;max-width: 60vw;max-height: 44vw;border-radius: 8px;margin-bottom: 15px;object-fit: cover;">
                    <span class="absolute" style="bottom: -28px; left: -17px"><?= svg_icon('circles'); ?></span>
                    <span class="absolute" style="bottom: 144px; right: -5px;"><?= svg_icon('twirl'); ?></span>


                </div>
                <h2 class="pro-name hide-desktop" style="font-size: var(--font-l); margin-top: 0px; margin-bottom:10px;"><?= get_the_title(); ?></h2>

                <div class="social-icons bottom-gap-s" style="display: flex; gap: var(--gap-m);">
                    <?php if ($twitter = get_field('pro_twitter')) { ?>
                        <a href="<?= $twitter; ?>" target="_blank" style="text-decoration: none;"><img src="<?= theme_uri('/img/icons/twitter.svg'); ?>" alt="Twitter" style="width: 18px; height: 18px;"></a>
                    <?php } ?>
                    <?php if ($facebook = get_field('pro_facebook')) { ?>
                        <a href="<?= $facebook; ?>" target="_blank" style="text-decoration: none;"><img src="<?= theme_uri('/img/icons/facebook.svg'); ?>" alt="Facebook" style="width: 18px; height: 18px;"></a>
                    <?php } ?>
                    <?php if ($linkedin = get_field('pro_linkedin')) { ?>
                        <a href="<?= $linkedin; ?>" target="_blank" style="text-decoration: none;"><img src="<?= theme_uri('/img/icons/linkedin.svg'); ?>" alt="LinkedIn" style="width: 18px; height: 18px;"></a>
                    <?php } ?>
                </div>
                <div id="expert-tags" class="flex gap-s justify-center bottom-gap-s hide-desktop" style="flex-wrap: wrap;">
                    <?php
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
                <div id="stats-box" class="box flex no-padding hide-desktop mobile bottom-gap-s" style="width: 90%;">
                    <div class="stat-item">
                        <p class="stat-label"><a href="#reviews">המלצות</a></p>
                        <p class="stat-value"><?= get_field('pro_recommended_count'); ?></p>
                    </div>
                    <div class="stat-item">
                        <p class="stat-label">שנות נסיון</p>
                        <p class="stat-value"><?= get_pro_date($pro_post_id, 'exp'); ?></p>
                    </div>
                    <div class="stat-item">
                        <p class="stat-label">התמחויות</p>
                        <p class="stat-value"><?= count($experts); ?></p>
                    </div>

                </div>
                <div class="stat-item hide-desktop" style="border-left: unset;">
                    <p class="stat-label" style="font-weight:var(--font-w-600);"><a href="#reviews">דירוג משוקלל</a></p>
                    <?php $pro_review_total = get_field('pro_total_rate'); ?>
                    <div class="pro_rating">
                        <style>
                            .pro_rating .star-rating {
                                margin-bottom: 2px !important;
                                margin-right: 10px;
                            }
                        </style>
                        <a href="#reviews" class="flex align-center">
                            <p class="stat-value" style="color: var(--blue);"><?= $pro_review_total; ?></p>

                            <?= star_rating($pro_review_total); ?>
                        </a>
                    </div>
                </div>
                <?php if ($pro_cert_card = get_field('pro_cert_card')) { ?>
                    <div class="certificate">
                        <img src="<?= wp_get_attachment_image_url($pro_cert_card, 'medium'); ?>" alt="תעודת הסמכה" class="float-up" style="width:170px;" lightbox-type="image" lightbox-content="<?= wp_get_attachment_image_url($pro_cert_card, 'full'); ?>">

                    </div>
                <?php } ?>
                <form id="pro-contact-form" action="/submit" method="post" class="bottom-gap-xs">
                    <style>
                        #pro-contact-form {
                            width: 100%;
                            display: flex;
                            flex-direction: column;
                            gap: var(--gap-xs);
                            max-height: 0;
                            overflow: hidden;
                            opacity: 0;
                            transition: all 0.4s ease-in-out;
                        }

                        #pro-contact-form.active {
                            max-height: 700px;
                            opacity: 1;
                        }

                        #pro-contact-form input,
                        #pro-contact-form textarea {
                            text-align: right;
                            width: 100%;
                        }
                    </style>
                    <input type="text" name="fullName" placeholder="שם מלא" required>
                    <input type="tel" name="phone" placeholder="טלפון" required>
                    <input type="email" name="email" placeholder="מייל" required>
                    <select name="subject" required>
                        <option value="" disabled selected>נושא הפניה</option>
                        <?php
                        if ($experts && !is_wp_error($experts)) {
                            foreach ($experts as $term) {
                                echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </form>
                <button id="pro_form_submit" class="button big" toggle-class="#pro-contact-form.active-1" style="width: 100%;">שלח פניה ל<?= get_the_title(); ?></button>
            </div>
        </div>
    </inner>
</section>

<section id="about">
    <style>
        #about {
            padding-top:var(--gap-xl);
        }

        #about inner {
            padding-left: 30%;
        }
        @media (max-width: 780px) {
            #about {
                padding-top: 0;
            }
            #about inner {
                padding-left:2%;
            }
}
    </style>
    <inner style="padding-bottom:160px;">
        <h2>קצת עליי</h2>
        <p style="color: var(--light-black);" class="bottom-gap-xl">
            <?= get_field('pro_about'); ?>
        </p>
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
                        <div class="box certificate-box float-up" lightbox-type="image" lightbox-content="<?= esc_url($image_url); ?>" style="padding:var(--gap-s); max-width: min(100%, 300px);">
                            <div class="cert_img radius-s bottom-gap-xs" style="height:300px;background-image: url('<?= esc_url($image_thumb); ?>');background-size:cover;background-position:top center"></div>
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


<section id="reviews" class="light" style="padding-top: 50px;">
    <inner class="flex-column align-center" style="text-align: center;">
        <?php if ($pro_reviews_count > 0) { ?>
            <h2 style="color: var(--green); width: 500px; max-width:95%;" class="bottom-gap-l"><span style="border-bottom: 2px solid var(--blue);"><?= $pro_reviews_count; ?>
                    אנשים</span> שיתפו את החוויה שלהם עם <?= get_the_title(); ?></h2>
        <?php } ?>
        <?php
        $current_post_id = $pro_post_id;
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
            <div class="reviews-loop flex-column align-center gap-l bottom-gap-l"><?php
                                                        while ($review_query->have_posts()) {
                                                            $review_query->the_post();
                                                            $review_post_id = get_the_ID();
                                                            pro_review($review_post_id);
                                                        }
                                                        wp_reset_postdata();

                                                        ?></div>
        <?php } else { ?>
            <div class="bottom-gap-m">טרם נוספו המלצות ל<?= get_the_title(); ?></div>
        <?php } ?>
        <a href="<?= site_url('/add-review/?pro=') . $pro_post_id; ?>" class="button ">הוסף המלצה ל<?= get_the_title(); ?></a>
    </inner>
</section>

<?php get_template_part('templates/featured-pros', null, array('section_classes' => 'light')); ?>

<section id="more-pros" class="light align-center">
    <inner>
        <h2>בעלי מקצוע נוספים בתחום</h2>
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
                    profile_box($pro_post_id, $dark_mode = false);
                }
            } else {
                echo '<p>לא נמצאו בעלי מקצוע מומלצים.</p>';
            }
            wp_reset_postdata();
            ?>
        </grid>
    </inner>
</section>

<section id="expert-terms" class="full relative" style="overflow:visible; background-color: var(--blue); background-image: url('<?= theme_uri('/img/squares_bg.png'); ?>'); background-repeat: no-repeat; background-position: left center;">
    <div class="absolute square-thing" style="bottom:-100px;right:-100px;"><?= svg_icon('square'); ?></div>
    <inner>
        <h2 style="color: white;">תחומי התמחות</h2>
        <grid class="grid-3 bottom-gap-xs">
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


<?php 
// update page view counts for this pro
update_pro_stats('page_views', $pro_post_id);

?>

<?php get_footer(); ?>
