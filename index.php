<?php get_header(); ?>

<?php
$total_pros = wp_count_posts('pros')->publish;
$featured_pros = get_field('home_featured_pros', 'option');
?>
<style>
  #hero {
    height: 673px;
    background-image: url('<?= theme_uri('/img/hero_bg.jpg'); ?>');
    background-position: top right;
    background-repeat: no-repeat;
    background-color: var(--soft-background);
    overflow: hidden;
  }

  #hero h1 {
    width: 446px;
  }

  #hero p {
    width: 540px;
  }

  #hero .search-form {
    padding: var(--gap-s);
    background-color: var(--blue);
    gap: var(--gap-s);
    width: 410px;
  }

  #hero .left img {
    max-width: 57vw;
  }


  @media (max-width: 550px) {
    #hero {
      height: 850px;
    }

    #hero h1 {
      font-size: var(--font-l);
      width: 80%;
      line-height: var(--font-xl);
    }

    #hero p {
      width: 80%;
    }

    #hero .search-form {
      padding: var(--gap-s);
      width: 100%;
    }

    #hero select,
    #hero .button {
      width: 100%;
    }

    #hero .left img {
      max-width: 100%;
    }

  }
</style>
<section id="hero" class="header-padding">

  <inner class="relative flex align-center mobile-flex-column">
    <div class="right" style="z-index:1;">
      <h1 class="title bottom-gap-xs">הפורטל המוביל למומחי נדל״ן פיננסים ושמאות בישראל</h1>
      <p class="subtitle bottom-gap-l">הפלטפורמה שלך לבחירת אנשי המקצוע הטובים ביותר בתחום
      </p>
      <div class="search-form_parent-container">
        <div class="flex mobile-flex-column search-form background-blue radius-s bottom-gap-xs">
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

<section id="expert-terms" class="dark full no-bottom-padding">
  <inner>
    <h2>סנן לפי תחום</h2>
    <grid class="grid-3 bottom-gap-s">
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


<?php get_template_part('templates/featured-pros', null, array('section_classes' => 'light')); ?>

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

        @media (max-width: 550px) {
          .home-stats stat {
            flex-direction: column;
            gap: 0;
            font-size: var(--font-l);
            font-weight: var(--font-w-700);
            text-align: center;
          }
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
get_template_part('templates/main-feed', null, array('featured_pros' => $featured_pros));
?>



<?php get_template_part('templates/features');?>

<?php get_template_part('templates/advertise-now');?>

<section id="blog" class="light" style="padding-top:50px;">
  <inner class="flex-column align-center" style="text-align:center;">

    <h2 style="color: var(--black);"><a href="<?= get_permalink(430); ?>">הבלוג שלנו</a></h2>
    <p class="bottom-gap-l" style="width:530px; max-width: 95%; color:var(--gray);">
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

<section id="we-here" class="dark no-bottom-padding">
  <style>
    #we-here {
      color: var(--dark-white);
      font-size: var(--font-m);
      padding: var(--gap-l);
    }

    #we-here h3 {
      color: white;
    }

    @media (max-width: 780px) {
      #we-here {
        padding: var(--gap-s);
      }

      #we-here h2,
      #we-here .desc {
        text-align: center;
        margin: auto;
      }
    }
  </style>
  <inner class="flex tablet-flex-column gap-l">
    <right class="flex-column flex-1">
      <h2 style="color:white;font-size:var(--font-xxl);">אנחנו כאן בשבילכם.</h2>
      <p class="desc" style="width: 350px; max-width:80%;">חשוב לנו שתקבלו את כל המידע שאתם צריכים כדי להיות רגועים ובטוחים שאתם מקבלים את הטוב ביותר.</p>
      <check class="flex gap-l bottom-gap-l" style="margin-top:40px;">
        <div style="width: 30px;">
          <?= svg_icon('circle_check'); ?>
        </div>

        <div>
          <h3>רק בעלי מקצוע מוסמכים</h3>
          <p>כל בעלי המקצוע באתר בעלי הסמכה ותעודה בתוקף.<br />זה תנאי סף אצלנו.</p>
        </div>
      </check>
      <check class="flex gap-l bottom-gap-l">
        <div style="width: 30px;">
          <?= svg_icon('circle_check'); ?>
        </div>
        <div>
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
