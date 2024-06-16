<?php get_header(); ?>

<?php
$total_pros = wp_count_posts('pros')->publish;
?>

<section id="hero" class="header-padding" style="height:673px;background-image: url('<?= theme_uri('/img/hero_bg.jpg'); ?>');background-position: top right;background-repeat: no-repeat;background-color:var(--soft-background);overflow:hidden;">
  <inner class="relative flex align-center">
    <div class="right" style="z-index:1;">
      <h1 class="title" style="width:450px; margin-bottom:20px;">מצא את בעל המקצוע הטוב ביותר עבורך!</h1>
      <p class="subtitle" style="width:480px;">
        בעלי המקצוע הטובים ביותר מרוכזים במקום אחד, קל ונוח לחיפוש, כך שלא
        צריך להתרוצץ. מצאתם.
      </p>
      <div class="search-form_parent-container">
        <div class="flex search-form background-blue radius-s" style="padding:20px 20px; background-color: var(--blue); gap: 15px; width: 410px; margin-bottom:10px;">
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
          <select name="experties">
            <option value=""><?php _e('כל התחומים', 'textdomain'); ?></option>
            <?php foreach ($expert_terms as $expert_term) : ?>
              <option value="<?= esc_attr($expert_term->term_id); ?>"><?= esc_html($expert_term->name); ?></option>
            <?php endforeach; ?>
          </select>
          <a href="#main-feed" class="button dark">חפש בעל מקצוע</a>
        </div>
        <h6>התחל חיפוש ראשוני. הגדר סינון נוסף בהמשך.</h6>
      </div>
    </div>
    <div class="left">
      <img class="hero_guy absolute" style="bottom:0;left:0;" src="<?= theme_uri('/img/HeroGuy.png'); ?>" alt="בעלי מקצוע מומלצים">
    </div>

  </inner>
</section>

<section id="expert-terms" class="dark full">
  <inner>
    <h2>סנן לפי תחום</h2>
    <grid class="grid-3" style="margin-bottom:10px">
      <a href="#" class="category-block accent">
        <h3>כל התחומים</h3>
        <h6><?= $total_pros; ?> בעלי מקצוע</h6>
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
          <a href="<?= esc_url(get_term_link($expert_term)); ?>" class="category-block">
            <h3><?= esc_html($expert_term->name); ?></h3>
            <h6><?= esc_html($expert_term->count); ?> בעלי מקצוע</h6>
          </a>
      <?php
        }
      }
      ?>

    </grid>
    <a class="show-all-link" style="color:var(--green); float:left; font-size:var(--font-s); font-weight:var(--font-w-600);">הצג את כל התחומים <?= svg_icon('left-arrow'); ?></a>
  </inner>
</section>

<section id="featured-pros" class="light align-center">
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

          profile_box(get_the_ID(), $dark_mode = false, $featured = true);
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

<section id="site-datas" style="border-bottom:1px solid var(--soft-background);">
  <inner style="padding:var(--gap-l)">
    <grid class="home-stats grid-3 gap-l">
      <style>
        .home-stats stat {
          display: flex;
          align-items: center;
          gap: var(--gap-m);
          font-size: var(--font-xxl);
          font-weight: var(--font-w-700);
        }

        .home-stats number {
          font-size: var(--font-xxl);
          font-weight: var(--font-w-700);
        }

        .home-stats title {
          display: inline-block;
          font-size: var(--font-xs);
          font-weight: var(--font-w-400);
          color: var(--gray);
        }
      </style>
      <stat>
        <number><?= $total_pros; ?></number>
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

<section id="features">
  <inner class="flex gap-l align-center" style="padding-bottom:0;">
    <right class="flex"><img src="<?= theme_uri('/img/whyus_man.jpg'); ?>" alt="למה אצלנו?"></right>
    <left style="margin-top:-10px;">
      <h2>למה אצלנו?</h2>
      <p style="color:var(--dark-gray); width:480px;margin-bottom: 40px;">באתר BEST1 תמצאו את כל בעלי המקצוע הטובים ביותר מסודרים בצורה נוחה וקלה לחיפוש בכל התחומים.</p>
      <grid class="grid-2 gap-s">
        <style>
          #features h3.check::before {
            content: url('data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%2218%22%20height%3D%2213%22%20viewBox%3D%220%200%2018%2013%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%0A%20%20%3Cpath%20d%3D%22M6.57216%2012.4615C6.2614%2012.4615%205.95124%2012.3449%205.71392%2012.1109L0%206.47876L1.71648%204.78623L6.57216%209.57245L16.2835%200L18%201.69253L7.4304%2012.1109C7.19308%2012.3449%206.88292%2012.4615%206.57216%2012.4615Z%22%20fill%3D%22%23473BF0%22%20%2F%3E%0A%3C%2Fsvg%3E');
            margin-left: 13px;

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

<section id="advertise-now" style="background-color:var(--green);">
  <inner class="flex gap-l justify-center align-center" style="padding:var(--gap-l);">
    <h2 style="color:white;margin-bottom:0;">בעל מקצוע, רוצה לקבל חשיפה רצינית?</h2>
    <span href="#" class="button light" style="width:220px;" lightbox-type="content" lightbox-content="#signin-signup-pop">פרסם עכשיו</span>
  </inner>
</section>

<section id="blog" class="light" style="padding-top:50px;">
  <inner class="flex-column align-center" style="text-align:center;">
    
    <h2 style="color: var(--black);"><a href="<?= get_permalink(430); ?>">הבלוג שלנו</a></h2>
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
    <a class="show-all-link" style="align-self:flex-end; margin-top:var(--gap-m); color:var(--green); float:left; font-size:var(--font-s); font-weight:var(--font-w-600);">הצג את כל המאמרים <?= svg_icon('left-arrow'); ?></a>
  </inner>
</section>

<section id="we-here" class="dark">
  <style>
    #we-here {
      color: var(--dark-white);
      font-size: var(--font-m);
      padding: var(--gap-l);
      padding-bottom:0;
    }

    #we-here h3 {
      color: white;
    }
  </style>
  <inner class="flex tablet-flex-column gap-l">
    <right class="flex-column flex-1">
      <h2 style="color:white;font-size:var(--font-xxl);">אנחנו כאן בשבילכם.</h2>
      <p style="width: 350px;">חשוב לנו שתקבלו את כל המידע שאתם צריכים כדי להיות רגועים ובטוחים שאתם מקבלים את הטוב ביותר.</p>
      <check class="flex gap-l" style="margin-top:40px;margin-bottom:30px">
        <div style="width: 30px;">
          <?= svg_icon('circle_check'); ?>
        </div>

        <div>
          <h3>רק בעלי מקצוע מוסמכים</h3>
          <p>כל בעלי המקצוע באתר בעלי הסמכה ותעודה בתוקף.<br/>זה תנאי סף אצלנו.</p>
        </div>
      </check>
      <check class="flex gap-l" style="margin-bottom:30px">
      <div style="width: 30px;">
          <?= svg_icon('circle_check'); ?>
        </div>        <div>
          <h3>אימות נתונים ועדכון תדיר</h3>
          <p>אנחנו מאמתים את הנתונים ועושים בדיקות תקופתיות כדי לוודא שתקבלו מידע מעודכן ואמין.</p>
        </div>
      </check>
      </div>
    </right>

    <left class="flex-1">
      <?php
      $accordionItems = [];
      if (have_rows('home_faq', 'option')) :
        while (have_rows('home_faq', 'option')) : the_row();
          $accordionItems[] = [
            'title' => get_sub_field('home_faq_q'),
            'content' => get_sub_field('home_faq_a')
          ];
        endwhile;
      endif;

      echo accordion($accordionItems, 1);
      ?>

    </left>

  </inner>
</section>

<script>

jQuery(document).ready(function($) {
    // Function to sync the select inputs
    function syncSelectInputs(source, target) {
        var selectedValue = $(source).val();
        $(target).val(selectedValue);
    }

    // Event listener for changes on the #hero select input
    $('#hero .search-form select[name="experties"]').on('change', function() {
        syncSelectInputs(this, '#main-feed select.expert_select');
        $('#main-feed select.expert_select').trigger('change');
    });

    // Event listener for changes on the #main-feed select input
    $('#main-feed .expert_select').on('change', function() {
        syncSelectInputs(this, '#hero .search-form select[name="experties"]');
    });
});
</script>

<?php get_footer(); ?>
