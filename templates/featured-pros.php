<style>
  .leaves_left,
  .leaves_right {
    position: absolute;
    top: 80px;
  }

  .leaves_left svg,
  .leaves_right svg {
    width: 250px;
    fill: var(--blue);
  }

  .leaves_left svg path,
  .leaves_right svg path {
    fill: var(--light-green);
  }

  .leaves_right {
    right: 5%;
    animation: slight-rotate 7s infinite ease-in-out;
  }

  .leaves_left {
    left: 5%;
    animation: slight-rotate-reverse 7s infinite ease-in-out;
  }


  #featured-pros .profile-box {
    z-index: 90;
  }

  @media (min-width: 850px) {
    #featured-pros .profile-box {
      animation: wave 2.5s infinite ease-in-out;
    }

    #featured-pros .profile-box:nth-child(2) {
      animation-delay: 0s;
    }

    #featured-pros .profile-box:nth-child(3) {
      animation-delay: 0.2s;
    }

    #featured-pros .profile-box:nth-child(4) {
      animation-delay: 0.4s;
    }

    #featured-pros .profile-box:hover {
      border-color: var(--green);
    }
  }

  @keyframes wave {

    0%,
    33.33%,
    100% {
      transform: translateY(0);
    }

    16.67% {
      transform: translateY(-10px);
    }
  }

  @keyframes slight-rotate {
    0% {
      transform: rotateZ(5deg) rotateY(5deg);
    }

    50% {
      transform: rotateZ(-5deg) rotateY(-28deg);
    }

    100% {
      transform: rotateZ(5deg) rotateY(5deg);
    }
  }

  @keyframes slight-rotate-reverse {
    0% {
      transform: rotateZ(-5deg) rotateY(-5deg);
    }

    50% {
      transform: rotateZ(5deg) rotateY(28deg);
    }

    100% {
      transform: rotateZ(-5deg) rotateY(-5deg);
    }
  }

  @keyframes shine {
    0% {
      background-position: -200% 0;
    }

    100% {
      background-position: 200% 0;
    }
  }

  #featured-pros {
    background: linear-gradient(100deg, var(--soft-background), #68d5854a, var(--soft-background));
    background-size: 200% 100%;
    animation: shine 6s linear infinite;
    overflow: hidden;
  }

  #featured-pros::after {
    content: '';
    background: var(--soft-background);
    width: 140%;
    position: absolute;
    bottom: -60px;
    left: -20%;
    right: -20%;
    height: 250px;
    filter: blur(85px);
    pointer-events: none;
    opacity: 1;
  }

  @media (max-width: 850px) {
    #featured-pros::after {
      display: none;
    }

    #featured-pros {
      background: inherit;
      overflow:visible;
    }

    #featured-pros .circle {
      top: 60% !important;
    }

    .leaves_left,
    .leaves_right {
      top: -20px;
    }

    .leaves_left svg,
    .leaves_right svg {
      width: 120px;
    }

    .leaves_left svg path,
    .leaves_right svg path {
      fill: var(--light-green);
    }

    .leaves_right {
      right: -3%;
    }

    .leaves_left {
      left: -3%;
    }
  }
</style>
<?php
$section_classes = isset($args['section_classes']) ? $args['section_classes'] : '';
?>
<section id="featured-pros" class="align-center relative <?php echo $section_classes; ?>">
  <inner>
    <span class="leaves_right"><?= svg_icon('leaves', null, 'flip-h'); ?></span>
    <span class="leaves_left"><?= svg_icon('leaves'); ?></span>
    <h2 class="black font-800 text-center">המומלצים שלנו ל-<?php echo date('Y'); ?></h2>
    <grid class="grid-3 relative">
      <div class="circle absolute grow-shrink" style="z-index:40;top:180px; right:60%; width:235px;height:235px;border-radius:50%;background:var(--light-green);"></div>
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
