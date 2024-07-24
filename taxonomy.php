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
        echo '<h2 class="" style="font-size: var(--font-xxxl); margin-top: 10px;">' . $term_title . '</h2>';
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

<?php get_template_part('templates/featured-pros');?>

<?php // Main feed
get_template_part('templates/main-feed', null, array('featured_pros' => $featured_pros));
?>

<?php get_template_part('templates/features'); ?>


<?php get_footer(); ?>
