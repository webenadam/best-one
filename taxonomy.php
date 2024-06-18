<?php get_header(); ?>

<?php
$term = get_queried_object();

?>

<section id="hero" class="header-padding" style="height: 423px; background-image: url('<?= theme_uri('/img/hero_bg.jpg'); ?>'); 
background-position: top right; background-repeat: no-repeat; background-color: var(--soft-background); overflow: visible;">
  <inner class="relative flex justify-between">
    <div class="right" style="margin-top: 33px; width: 80%;">

      <?php
      if ($term) {
        $term_title = $term->name;
        echo '<h2 class="" style="font-size: var(--font-xxl); margin-top: 10px;">' . $term_title . '</h2>';
      }
      ?>
      <div class="count" style="margin-bottom:78px;">
     
            <span class="count" style="color:var(--dark-gray);"><?= $term->count; ?> בעלי מקצוע ב<?= $term->name; ?></span>
     
      </div>

    </div>
    <div class="left">
      <span style="position: absolute; top: 24px; left: -30px;"><?= svg_icon('dots'); ?></span>
  
    </div>
  </inner>
</section>

<section id="featured-pros" class="align-center dark">
  <inner>
    <h2 style="margin-bottom:30px;">המומלצים שלנו ב<?= $term->name; ?></h2>
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

<?php // Main feed
get_template_part('templates/main-feed', null, array('featured_pros' => $featured_pros));
?>

<section id="features" style="border-bottom:1px solid var(--light-gray);">
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

<?php get_footer(); ?>
