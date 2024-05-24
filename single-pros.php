<?php get_header();?>

<?php
$total_pros = wp_count_posts('pros')->publish;
?>
<a href="<?php echo get_site_url(); ?>" class="back-home-button absolute" style="top:160px;right:0px;background-color:var(--black);color:white;border-radius: 99px 0px 0px  99px;padding: 1px 14px;font-size:var(--font-s);">
<?php echo svg_icon('left-arrow', '#fff', 'flip-h'); ?>
חזרה לדף הבית
</a>

<section id="hero" class="header-padding" style="height:467px;background-image: url('<?php echo theme_uri('/img/hero_bg.jpg'); ?>');background-position: top right;background-repeat: no-repeat;background-color:var(--soft-background);overflow:visible;">
    <inner class="relative flex justify-between">
        <div class="right" style="
    margin-top: 43px; width:80%
">
          <div id="expert-tags" class="flex gap-s">
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

<h2 style="font-size:var(--font-xl);margin-top:10px;"><?php echo get_the_title(); ?></h2>
        <style>
            .stat-item {
                flex:1;
            }
            .stat-label {
                font-size: var(--font-s);
            }
            .stat-value {
                font-size: var(--font-l);
                font-weight:var(--font-w-700);
                color: var(--green);
            }
        </style>
        <div id="stats-box" class="box flex" style="width:80%; height:100px;border:1px solid var(--soft-background);">
            <div class="stat-item">
            <p class="stat-label">המלצות</p>

                <p class="stat-value">7</p>
            </div>
            <div class="stat-item">
            <p class="stat-label">שנות נסיון</p>

                <p class="stat-value">6</p>
            </div>
            <div class="stat-item">
            <p class="stat-label">גיל</p>

                <p class="stat-value">37</p>
            </div>
            <div class="stat-item">
            <p class="stat-label">דירוג משוקלל</p>

                <p class="stat-value" style="color:var(--blue);">9</p>
            </div>
        </div>
        </div>
        <div class="left">
          <span style="
    position: absolute;
    top: 24px;
    left: -30px;
"><?php echo svg_icon('dots'); ?></span>
        <div class="box" style="margin-top: 23px; width:347px; border: 1px solid var(--light-gray); background-color: white; padding: 20px; border-radius: 10px; display: flex; flex-direction: column; align-items: center;">
            <div class="profile-image-wrap relative" style=" text-align: center; ">
            <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="Profile Picture" style="width: 247px;height: 247px;border-radius: 50%;margin-bottom: 15px;object-fit: cover;">
           <span class="absolute" style="bottom:0;left:-10px"><?php echo svg_icon('circles'); ?></span>
           <span class="absolute" style="bottom: 44px;right: 12px;"><?php echo svg_icon('twirl'); ?></span>

          </div>
            <div class="social-icons" style="display: flex; gap: var(--gap-m); margin-bottom: 24px;">
                <a href="#" style="text-decoration: none;"><img src="<?php echo theme_uri('/img/icons/twitter.svg'); ?>" alt="Twitter" style="width: 18px; height: 18px;"></a>
                <a href="#" style="text-decoration: none;"><img src="<?php echo theme_uri('/img/icons/facebook.svg'); ?>" alt="Facebook" style="width: 18px; height: 18px;"></a>
                <a href="#" style="text-decoration: none;"><img src="<?php echo theme_uri('/img/icons/linkedin.svg'); ?>" alt="LinkedIn" style="width: 18px; height: 18px;"></a>
            </div>
            <a href="#" class="contact-email" style="color: var(--gray);margin-bottom: 19px;"><?php echo get_field('pro_email'); ?></a>
            <a href="tel:054398787" class="contact-phone" style="color: var(--gray);margin-bottom: 50px;"><?php echo get_field('pro_phone'); ?></a>

            <button class="button big" style="width:100%">שלח פניה ל<?php echo get_the_title(); ?></button>
        </div>
</div>
    </inner>
</section>

<section id="about">
  <inner style=" padding-left: 30%; ">
<h2>קצת עליי</h2>
<p style="color:var(--light-black);">
  <?php echo get_field('pro_about'); ?>
</p>
  </inner>
</section>

<section id="expert-terms" class="full" style="background-color:var(--blue);background-image: url('<?php echo theme_uri('/img/squares_bg.png'); ?>'); background-repeat: no-repeat;background-position: left center;" >
    <inner>
      <h2 style="color:white;">תחומי התמחות</h2>
      <grid class="grid-3" style="margin-bottom:10px">
        <?php

if (!empty($experts) && !is_wp_error($experts)) {
    foreach ($experts as $expert_term) {
        // Output the category block
        ?>
        <a href="<?php echo esc_url(get_term_link($expert_term)); ?>" class="category-block">
            <h3><?php echo esc_html($expert_term->name); ?></h3>
            <h6><?php echo esc_html($expert_term->count); ?> בעלי מקצוע</h6>
        </a>
        <?php
}
}
?>
      </grid>

    </inner>
</section>
<section id="client_reviews" class="light" style="padding-top:50px;">
    <inner class="flex-column align-center" style="text-align:center;">
      <h2 style="color: var(--green);width:500px;"><span style="border-bottom:2px solid var(--blue);">4 אנשים</span> שיתפו את החוויה שלהם עם <?php echo get_the_title(); ?></h2>
      <?php
// Get the current post ID
$current_post_id = get_the_ID();

// Set up the query arguments
$args = array(
    'post_type' => 'pro_reviews',
    'meta_query' => array(
        array(
            'key' => 'pro_review_pro_is', // The ACF field name
            'value' => $current_post_id,
            'compare' => '=',
        ),
    ),
);

// Execute the query
$review_query = new WP_Query($args);

// Check if there are any posts
if ($review_query->have_posts()) {
    // Loop through the posts
    while ($review_query->have_posts()) {
        $review_query->the_post();
        // Output the post title and a link to the post
        echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a><br>';
    }
    // Restore original post data
    wp_reset_postdata();
} else {
    echo 'טרם נוספו המלצות לבעל המקצוע הזה.';
}
?>
    </inner>
</section>
<section id="featured-pros" class="light align-center">
    <inner>
      <h2 style="margin-bottom:30px;">בעלי מקצוע נוספים בתחום</h2>
      <grid class="grid-3">
<?php
// Get featured pros from site settings
$featured_pros = get_field('home_featured_pros', 'option');

// Query the "pros" post type
$args = array(
    'post_type' => 'pros',
    'post__in' => $featured_pros,
    'orderby' => 'post__in',
    'posts_per_page' => -1,
);
$query = new WP_Query($args);

// Check if there are posts
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();

        profile_box(get_the_ID(), $dark_mode = false);

    }
} else {
    echo '<p>לא נמצאו בעלי מקצוע מומלצים.</p>';
}

// Restore original post data
wp_reset_postdata();
?>
</grid>

    </inner>
</section>



<?php get_footer();?>
