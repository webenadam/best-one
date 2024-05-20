<?php get_header();?>

<?php
$total_pros = wp_count_posts('pros')->publish;
?>

  <section class="section-hero" style="height:673px;background-image: url('<?php echo theme_uri('/img/hero_bg.jpg'); ?>');background-position: top right;background-repeat: no-repeat;background-color:var(--soft-background);overflow:hidden;">
    <inner style="padding:0;">
      <div class="header flex justify-between align-center" style="padding:20px 0; z-index:1;">
        <a class="float-up" href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/Logo.png" alt="Logo" /></a>
        <nav>
          <ul>
          <?php if (have_rows('top_nav_links', 'option')): ?>
      <?php while (have_rows('top_nav_links', 'option')): the_row();?>
								        <?php
    // Get the link title
    $link_title = get_sub_field('top_nav_link_title');
    // Get the link type
    $link_type = get_sub_field('top_nav_link_type');
    // Determine the URL based on the link type
    if ($link_type == 'עמוד') {
        $link_url = get_permalink(get_sub_field('top_nav_link_page'));
    } elseif ($link_type == 'פוסט') {
    $link_url = get_permalink(get_sub_field('top_nav_link_post'));
} elseif ($link_type == 'קישור מותאם') {
    $link_url = get_sub_field('top_nav_link_custom');
} else {
    $link_url = '#';
}
?>
        <li><a href="<?php echo esc_url($link_url); ?>"><?php echo esc_html($link_title); ?></a></li>
      <?php endwhile;?>
    <?php endif;?>
            <li><a class="button">הוסף בעל מקצוע / התחבר</a></li>
          </ul>
        </nav>
      </div>
      <div class="hero-content relative flex align-center" style="height: calc(100% - 85px);">
        <div class="right" style="z-index:1;">
          <h1 class="title" style="width:450px; margin-bottom:20px;">מצא את בעל המקצוע הטוב ביותר עבורך!</h1>
          <p class="subtitle" style="width:480px;">
            בעלי המקצוע הטובים ביותר מרוכזים במקום אחד, קל ונוח לחיפוש, כך שלא
            צריך להתרוצץ. מצאתם.
          </p>
          <div class="search-form_parent-container flex-column align-end" style="gap:15px;">
            <div class="flex search-form background-blue radius-s" style="padding:20px 20px; background-color: var(--blue); gap: 15px;">
            <?php
// Get used places terms
$places_terms = get_terms(array(
    'taxonomy' => 'places',
    'hide_empty' => true, // Only show terms that are used by posts
));

// Get used expert terms
$expert_terms = get_terms(array(
    'taxonomy' => 'expert',
    'hide_empty' => true, // Only show terms that are used by posts
));
?>
              <select name="places">
            <option value=""><?php _e('בחר מיקום...', 'textdomain');?></option>
            <?php foreach ($places_terms as $place_term): ?>
                <option value="<?php echo esc_attr($place_term->slug); ?>"><?php echo esc_html($place_term->name); ?></option>
            <?php endforeach;?>
        </select>
              <select name="experties">
            <option value=""><?php _e('כל התחומים', 'textdomain');?></option>
            <?php foreach ($expert_terms as $expert_term): ?>
                <option value="<?php echo esc_attr($expert_term->slug); ?>"><?php echo esc_html($expert_term->name); ?></option>
            <?php endforeach;?>
        </select>
              <button class="button dark">חפש בעל מקצוע</button>
            </div>
            <h6>התחל חיפוש ראשוני. הגדר סינון נוסף בהמשך.</h6>
          </div>
        </div>
        <div class="left">
          <img class="hero_guy absolute" style="bottom:0;left:0;" src="<?php echo theme_uri('/img/HeroGuy.png'); ?>" alt="בעלי מקצוע מומלצים">
        </div>
      </div>
    </inner>
  </section>
  <section class="section-categories dark full">
    <inner>
      <h2>סנן לפי תחום</h2>
      <grid class="grid-3" style="margin-bottom:10px">
        <a href="#" class="category-block accent">
          <h3>כל התחומים</h3>
          <h6><?php echo $total_pros; ?> בעלי מקצוע</h6>
        </a>
        <?php

// Get featured pros from site settings
$featured_expert_terms = get_field('home_featured_expert_terms', 'option');

// Get used expert terms, limited to 5
$expert_terms = get_terms(array(
    'taxonomy' => 'expert',
    'include' => $featured_expert_terms,
    'hide_empty' => true, // Only show terms that are used by posts
    'number' => 5, // Limit to 5 terms
));

// Sort terms by the order they are set in the ACF field
usort($expert_terms, function ($a, $b) use ($featured_expert_terms) {
    $pos_a = array_search($a->term_id, $featured_expert_terms);
    $pos_b = array_search($b->term_id, $featured_expert_terms);
    return $pos_a - $pos_b;
});

if (!empty($expert_terms) && !is_wp_error($expert_terms)) {
    foreach ($expert_terms as $expert_term) {
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
      <a class="show-all-link" style="color:var(--green); float:left; font-size:var(--font-s); font-weight:var(--font-w-600);">הצג את כל התחומים <?php echo get_svg_icon('left-arrow'); ?>
    </inner>
  </section>

  <section class="setcion-featured light align-center">
    <inner>
      <h2 style="margin-bottom:30px;">המומלצים שלנו</h2>
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
  <section class="setcion-datas" style="border-bottom:2px solid var(--soft-background);">
    <inner style="padding:var(--gap-l)">
      <grid class="home-stats grid-3 gap-l">
        <style>
          .home-stats stat {
            display: flex;
            align-items: center;
            gap: var(--gap-m);
            font-size: var(--font-xl);
            font-weight: var(--font-w-700);
          }
          .home-stats number {
            font-size: var(--font-xl);
            font-weight: var(--font-w-700);
          }

          .home-stats title {
            display: inline-block;
            font-size:var(--font-xs);
            font-weight: var(--font-w-400);
            color: var(--gray);
          }
        </style>
        <stat>
          <number><?php echo $total_pros; ?></number>
          <title>בעלי מקצוע מנוסים ומוכשרים לרשותכם באתר</title>
        </stat>
        <stat>
          <number>23</number>
          <title>תחומי מקצועות שונים לבחירה וסינון בעלי המקצוע על-פיהם</title>
        </stat>
        <stat>
          <number>120</number>
          <title>המלצות מלקוחות בעלי המקצוע שכבר בחרו לעצמם מקצוען אמיתי!</title>
        </stat>
      </grid>
    </inner>
  </section>

<?php // Main feed
get_template_part('template-parts/main-feed', null, array('featured_pros' => $featured_pros));
?>


  <section class="setcion-features">
    <inner class="flex gap-l align-center" style="padding-bottom:0;">
      <right class="flex"><img src="<?php echo theme_uri('/img/whyus_man.jpg'); ?>" alt="למה אצלנו?"></right>
      <left style="margin-top:-10px;">
        <h2>למה אצלנו?</h2>
        <p style="color:var(--dark-gray); width:480px;margin-bottom: 40px;">באתר BEST1 תמצאו את כל בעלי המקצוע הטובים ביותר מסודרים בצורה נוחה וקלה לחיפוש בכל התחומים.</p>
        <grid class="grid-2 gap-s">
          <style>
            .setcion-features h3.check::before {
              content: url('data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%2218%22%20height%3D%2213%22%20viewBox%3D%220%200%2018%2013%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%0A%20%20%3Cpath%20d%3D%22M6.57216%2012.4615C6.2614%2012.4615%205.95124%2012.3449%205.71392%2012.1109L0%206.47876L1.71648%204.78623L6.57216%209.57245L16.2835%200L18%201.69253L7.4304%2012.1109C7.19308%2012.3449%206.88292%2012.4615%206.57216%2012.4615Z%22%20fill%3D%22%23473BF0%22%20%2F%3E%0A%3C%2Fsvg%3E');
              margin-left:13px;

            }
          </style>
          </style>
          <h3 class="check">רק בעלי מקצוע מוסכמים</h3>
          <h3 class="check">רק עם תעודה בתוקף</h3>
          <h3 class="check">סינון קל ונוח לפי תחומים</h3>
          <h3 class="check">פרטים מלאים כל כל בעל מקצוע</h3>
          <h3 class="check">יצירת קשר ישירה</h3>
          <h3 class="check">פרטים מעודכנים תמיד</h3>
        </grid>
      </left>
    </inner>
  </section>
  <section class="setcion-advertise-now" style="background-color:var(--green);">
    <inner class="flex gap-l justify-center align-center" style="padding:var(--gap-l);">
      <h2 style="color:white;margin-bottom:0;">בעל מקצוע, רוצה לקבל חשיפה רצינית?</h2>
      <a href="#" class="button light" style="width:220px;">פרסם עכשיו</a>
    </inner>
  </section>
  <section class="setcion-blog light" style="padding-top:50px;">
    <inner class="flex-column align-center" style="text-align:center;">
    <?php // Function to display post block
function post_block($post_id)
{
    $post = get_post($post_id);
    $categories = get_the_category($post_id);
    $category_list = array();

    foreach ($categories as $category) {
        $category_list[] = '<h6><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></h6>';
    }

    $category_terms = implode(', ', $category_list);
    ?>
  <box class="box post-box radius-l flex-column no-padding float-up">
    <?php if (has_post_thumbnail($post_id)): ?>
        <a class="post-thumbnail" href="<?php echo get_permalink($post_id); ?>" style="background-size:cover;background-image:url('<?php echo get_the_post_thumbnail_url($post_id, array(420, 9999)); ?>');height:220px;width:100%;display:block;">

        </a>
    <?php endif;?>
    <div class="post-content" style="padding:var(--gap-m);text-align:right;">
      <div class="post-categories" style="margin-top:-3px;margin-bottom:6px;">
        <?php echo $category_terms; ?>
      </div>
      <h3 class="post-title">
        <a href="<?php echo get_permalink($post_id); ?>">
          <?php echo get_the_title($post_id); ?>
        </a>
      </h3>
    </div>
  </box>
  <?php
}
?>
      <h2 style="color: var(--black);"><a href="#">הבלוג שלנו</a></h2>
      <p style="width:530px; color:var(--gray); margin-bottom:50px;">
      כל המאמרים המקצועיים ביותר, המעודנים ביותר והחמים ביותר בנושאי שמאות רכוש, שמאות נזקים, שמאות חקלאות ועוד...
          </p>
          <grid class="grid-3">
            <?php
// Query to get the latest 3 posts
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
);
$query = new WP_Query($args);

// Loop through the posts
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        post_block(get_the_ID());
    }
} else {
    echo '<p>לא נמצאו פוסטים.</p>';
}

// Restore original post data
wp_reset_postdata();
?>
        </grid>
    </inner>
  </section>
  <section class="setcion-we-here dark">
    <style>.setcion-we-here {color:var(--dark-white); font-size:var(--font-s);} .setcion-we-here h3 {color:white;}</style>
    <inner class="flex gap-l">


      <right class="flex-column flex-1"><h2 style="color:white;font-size:var(--font-xl);">אנחנו כאן בשבילכם.</h2>
      <p style="width: 350px;">חשוב לנו שתקבלו את כל המידע שאתם צריכים כדי להיות רגועים ובטוחים שאתם מקבלים את הטוב ביותר.</p>
      <check>
      <h3>רק בעלי מקצוע מוסמכים</h3>
      <p>כל בעלי המקצוע באתר בעלי הסמכה ותעודה בתוקף. זה תנאי סף אצלנו.</p>
          </check>
          <check>
      <h3>רק בעלי מקצוע מוסמכים</h3>
      <p>כל בעלי המקצוע באתר בעלי הסמכה ותעודה בתוקף. זה תנאי סף אצלנו.</p>
          </check>
          </right>


      <left class="flex-1">
        <div class="accordion">
          <div class="accordion-item">
            <h3 class="accordion-title">האם כל בעלי המקצוע באתר מוסמכים?</h3>
            <div class="accordion-content">
              <p>אנחנו מפרסמים רק שמאים מוסמכים באתר ולכן אתם יכולים לבחור שמאי בבטחה ללא שום חשש לגבי הכשרתו. בנוסף אנחנו מציגים לכם את כל הנתונים לגבי נסיונו והכשרתו.</p>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-title">האם ניתן ליצור קשר ישיר עם בעלי המקצוע?</h3>
            <div class="accordion-content">
            <p>אנחנו מפרסמים רק שמאים מוסמכים באתר ולכן אתם יכולים לבחור שמאי בבטחה ללא שום חשש לגבי הכשרתו. בנוסף אנחנו מציגים לכם את כל הנתונים לגבי נסיונו והכשרתו.</p>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-title">האם הנתונים באתר מעודכנים?</h3>
            <div class="accordion-content">
            <p>אנחנו מפרסמים רק שמאים מוסמכים באתר ולכן אתם יכולים לבחור שמאי בבטחה ללא שום חשש לגבי הכשרתו. בנוסף אנחנו מציגים לכם את כל הנתונים לגבי נסיונו והכשרתו.</p>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-title">האם כל אחד יכול לפרסם באתר?</h3>
            <div class="accordion-content">
            <p>אנחנו מפרסמים רק שמאים מוסמכים באתר ולכן אתם יכולים לבחור שמאי בבטחה ללא שום חשש לגבי הכשרתו. בנוסף אנחנו מציגים לכם את כל הנתונים לגבי נסיונו והכשרתו.</p>
            </div>
          </div>
        </div>
      </left>

    </inner>
  </section>


<?php get_footer();?>