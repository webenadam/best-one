<?php get_header(); ?>

<?php
$current_user_id = get_current_user_id();
$args = array(
    'post_type' => 'pros',
    'author' => $current_user_id,
    'posts_per_page' => 1,
);
$query = new WP_Query($args);
if ($query->have_posts()) {
    $query->the_post();
    $pro_post_id = $query->post->ID;
?>

<?php get_template_part('templates/me-hero', null, array('pro_post_id' => $pro_post_id, 'page_title' => 'פרטי מנוי')) ?>

    <section id="about">
        <inner style="padding-left: 30%; padding-top:var(--gap-m); padding-bottom:860px;">
            פה יהיו פרטי מנוי

        </inner>
    </section>





<?php
} else {
    echo '<p>לא נמצא בעל מקצוע עבור המשתמש הנוכחי.</p>';
}
?>

<?php get_footer(); ?>
