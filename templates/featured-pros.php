<?php
$section_classes = isset($args['section_classes']) ? $args['section_classes'] : '';
?>
<section id="featured-pros" class="align-center <?php echo $section_classes;?>">
  <inner>
    <h2 class="black"><span class="sparkle" style=" margin-right: -25px; margin-bottom: 25px; display: inline-block; transform: translateY(-14px); "><?= svg_icon('sparkle'); ?></span>המומלצים שלנו</h2>
    <grid class="grid-3 relative">
    <div class="circle absolute" style="top:180px; right:60%; width:235px;height:235px;border-radius:50%;background:var(--light-green);"></div>
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
