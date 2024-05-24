<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head();?>
</head>
<body <?php body_class();?>>
<?php
if (current_user_can('administrator') || current_user_can('editor')) {
    ?>
    <a class="wp-link" href="<?php echo esc_url(admin_url()); ?>" style="font-size: var(--font-s); position: fixed; top: 0; left: 2%; background: #0000001a; padding: 10px 26px; border-radius: 0 0 10px 10px; opacity:0; transition:all 0.2s ease-in-out;z-index:999;">כניסה לניהול</a>
    <?php
}

?>
<header>
    <inner class=" flex justify-between align-center" style="padding:20px 0; z-index:1;">
        <a class="float-up" style="height:33px;" href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/Logo.png" alt="Logo" /></a>
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
      </inner>
</header>
