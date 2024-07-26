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
    fill: var(--dark-blue);
    opacity: 1;
  }

  .leaves_right {
    right: 0.1%;
    animation: slight-rotate 7s infinite ease-in-out;
  }

  .leaves_left {
    left: 0.1%;
    animation: slight-rotate-reverse 7s infinite ease-in-out;
  }

  #featured-pros .profile-box {
    z-index: 90;
  }

  #featured-pros h2 {
    text-shadow: 0 0 45px #ffffff85;
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

  @keyframes sprinkle {
    0% {
      transform: translateY(0) translateX(0) scale(0.5);
    }

    50% {
      transform: translateY(-30px) translateX(3px) scale(1);
    }

    100% {
      transform: translateY(0) translateX(0) scale(0.5);
    }
  }

  @keyframes sprinkle-b {
    0% {
      transform: translateY(0) translateX(0) scale(1);
    }

    50% {
      transform: translateY(80px) translateX(-23px) scale(0.5);
    }

    100% {
      transform: translateY(0) translateX(0) scale(1);
    }
  }

  @keyframes sprinkle-c {
    0% {
      transform: translateY(0) translateX(0) scale(0.5);
    }

    50% {
      transform: translateY(-50px) translateX(10px) scale(1.2);
    }

    100% {
      transform: translateY(0) translateX(0) scale(0.5);
    }
  }

  @keyframes sprinkle-d {
    0% {
      transform: translateY(0) translateX(0) scale(0.8);
    }

    50% {
      transform: translateY(40px) translateX(-15px) scale(1.1);
    }

    100% {
      transform: translateY(0) translateX(0) scale(0.8);
    }
  }

  @keyframes sprinkle-e {
    0% {
      transform: translateY(0) translateX(0) scale(0.6);
    }

    50% {
      transform: translateY(-20px) translateX(5px) scale(1.3);
    }

    100% {
      transform: translateY(0) translateX(0) scale(0.6);
    }
  }

  #featured-pros {
    background: linear-gradient(100deg, var(--dark-blue), var(--light-blue), var(--dark-blue));
    background-size: 200% 100%;
    animation: shine 6s linear infinite;
    overflow: hidden;
    position: relative;
  }

  #featured-pros::after {
    content: '';
    background: var(--dark-blue);
    width: 140%;
    position: absolute;
    bottom: -90px;
    left: -20%;
    right: -20%;
    height: 360px;
    filter: blur(125px);
    pointer-events: none;
    opacity: 0.8;
    z-index: 10;
  }

  #featured-pros::before {
    content: '';
    background: var(--black);
    width: 140%;
    position: absolute;
    bottom: -120px;
    left: -20%;
    right: -20%;
    height: 300px;
    filter: blur(125px);
    pointer-events: none;
    opacity: 0.8;
    z-index: 20;
  }


  @media (max-width: 850px) {
    #featured-pros::after {
      display: none;
    }

    #featured-pros {
      background: inherit;
      overflow: visible;
    }

    #featured-pros .circle {
      top: 80% !important;
    }

    .leaves_left,
    .leaves_right {
      top: -20px;
    }

    .leaves_left svg,
    .leaves_right svg {
      width: 120px;
    }

    .leaves_right {
      right: -3%;
    }

    .leaves_left {
      left: -3%;
    }
  }

  .sprinkle,
  .sprinkle-b,
  .sprinkle-c,
  .sprinkle-d,
  .sprinkle-e {
    position: absolute;
    border-radius: 50%;
    opacity: 0.8;
    z-index: 40;
  }

  .sprinkle {
    animation: sprinkle 3s infinite ease-in-out;
  }

  .sprinkle-b {
    animation: sprinkle-b 5s infinite ease-in-out;
  }

  .sprinkle-c {
    animation: sprinkle-c 4s infinite ease-in-out;
  }

  .sprinkle-d {
    animation: sprinkle-d 6s infinite ease-in-out;
  }

  .sprinkle-e {
    animation: sprinkle-e 5.5s infinite ease-in-out;
  }

  .sprinkle:nth-child(odd) {
    animation-duration: 2.5s;
  }

  .sprinkle:nth-child(even) {
    animation-duration: 3.5s;
  }

  .sprinkle-b:nth-child(odd) {
    animation-duration: 1.5s;
  }

  .sprinkle-b:nth-child(even) {
    animation-duration: 6.5s;
  }

  .sprinkle-c:nth-child(odd) {
    animation-duration: 2s;
  }

  .sprinkle-c:nth-child(even) {
    animation-duration: 5s;
  }

  .sprinkle-d:nth-child(odd) {
    animation-duration: 3s;
  }

  .sprinkle-d:nth-child(even) {
    animation-duration: 4.5s;
  }

  .sprinkle-e:nth-child(odd) {
    animation-duration: 2.5s;
  }

  .sprinkle-e:nth-child(even) {
    animation-duration: 6s;
  }

  #featured-pros .text-shine {
    background: linear-gradient(281deg, #04060a 30%, #2a334d 50%, #04060a 70%);
    background-size: 200%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: text-shine 9s linear infinite;
  }

  @keyframes text-shine {
    0% {
      background-position: -200% 0;
    }

    40% {
      background-position: 200% 0;
    }

    50% {
      background-position: 200% 0;
    }

    90% {
      background-position: -200% 0;
    }

    100% {
      background-position: -200% 0;
    }
  }
</style>
<section id="featured-pros" class="align-center relative <?php echo $section_classes; ?>">
  <inner>
    <span class="leaves_right"><?= svg_icon('leaves', null, 'flip-h'); ?></span>
    <span class="leaves_left"><?= svg_icon('leaves'); ?></span>
    <h2 class="black font-800 text-center">המומלצים שלנו ל-<span class="text-shine"><?php echo date('Y'); ?></span></h2>
    <grid class="grid-3 relative">
      <div class="circle absolute grow-shrink" style="display:none;z-index:40;top:180px; right:60%; width:235px;height:235px;border-radius:50%;background:var(--light-green);"></div>
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

    <!-- Add sprinkle elements -->
    <?php for ($i = 0; $i < 180; $i++) : 
      $size = rand(2, 11); 
      $animation_class = 'sprinkle';
      switch (rand(0, 4)) {
        case 1:
          $animation_class = 'sprinkle-b';
          break;
        case 2:
          $animation_class = 'sprinkle-c';
          break;
        case 3:
          $animation_class = 'sprinkle-d';
          break;
        case 4:
          $animation_class = 'sprinkle-e';
          break;
      }
      ?>
      <div class="<?= $animation_class; ?>" style="
      opacity: <?= mt_rand(0, 10) / 10; ?>;
      filter:blur(<?= rand(0, 11) ?>px);
        top: <?= rand(0, 100); ?>%;
        left: <?= rand(0, 100); ?>%;
        width: <?= $size; ?>px;
        height: <?= $size; ?>px;
        background: <?= rand(0, 1) ? (rand(0, 1) ? 'var(--light-blue)' : 'white') : (rand(0, 1) ? 'var(--blue)' : 'var(--dark-blue)'); ?>;">
      </div>
    <?php endfor; ?>
  </inner>
</section>
