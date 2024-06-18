<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    if (current_user_can('administrator') || current_user_can('editor')) {
    ?>
        <?php
        $current_post = get_queried_object();
        if ($current_post && ($current_post->post_type === 'post' || $current_post->post_type === 'page')) {
            $edit_link = get_edit_post_link($current_post->ID);
            $title = 'עריכה';
        ?>
            <a class="wp-link" href="<?= esc_url($edit_link); ?>" style="font-size: var(--font-s); position: fixed; top: 0; left: 0; background: #0000001a; padding: 10px 26px; border-radius: 0 0 10px 0; opacity:0; transition:all 0.2s ease-in-out;z-index:999;"><?= $title; ?></a>

    <?php }
    } ?>

    <header>
        <inner class="flex justify-between align-center mobile-flex-row">
            <span class="menu-toggle flex hide-desktop" self-toggle-class="active" toggle-class="#header-nav.active" style="z-index:10; cursor:pointer;"><?= svg_icon('hamburger'); ?></span>
            <a class="float-up logo" style="height:33px;" href="<?= home_url(); ?>"><img src="<?= get_template_directory_uri(); ?>/img/Logo.png" alt="Logo" /></a>
            <nav id="header-nav">
                <ul class="flex align-center gap-m">
                    <?php if (have_rows('top_nav_links', 'option')) : ?>
                        <?php while (have_rows('top_nav_links', 'option')) : the_row(); ?>
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
                            <li><a href="<?= esc_url($link_url); ?>"><?= esc_html($link_title); ?></a></li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <li>
                        <?php
                        if (!is_user_logged_in()) {
                            // User is not logged in
                        ?>
                            <div lightbox-type="content" lightbox-content="#signin-signup-pop" class="button"><span style="vertical-align: -4px; margin-left:13px;"><?= svg_icon('profile', null, null, 19, 19); ?></span>התחבר / פרסם עכשיו</div>
                            <?php
                        } else {
                            // User is logged in
                            $current_user = wp_get_current_user();

                            if (in_array('administrator', $current_user->roles)) {
                                // User is an administrator
                            ?>
                                <a href="<?= admin_url('/admin.php?page=site-settings'); ?>" class="button"><span style="vertical-align: -4px; margin-left:13px;"><?= svg_icon('profile', null, null, 19, 19); ?></span>ניהול אתר</a>
                            <?php
                            } else {
                                // User is logged in but not an administrator
                            ?>
                                <a href="<?= home_url('/me'); ?>" class="button"><span style="vertical-align: -4px; margin-left:13px;"><?= svg_icon('profile', null, null, 19, 19); ?></span>איזור אישי</a>
                        <?php
                            }
                        }
                        ?>
                    </li>
                </ul>
            </nav>
        </inner>
    </header>
    <div id="signin-signup-pop" class="lightbox-overlay">
        <div class="lightbox-content" style="width:440px;">

            <div class="tabs-container">
                <div class="tabs">
                    <div class="slider button"></div>
                    <div class="tab-button active" data-tab="signin">התחבר</div>
                    <div class="tab-button" data-tab="signup">פרסם עכשיו</div>
                </div>
                <div class="tab-content active" id="tab-signin">
                    <form name="loginform" id="loginform" action="<?= esc_url(home_url('wp-login.php', 'login_post')); ?>" method="post" style="text-align:center;">
                        <input type="text" name="log" autocomplete="username" id="user_login" class="input" placeholder="דואר אלקטרוני" value="" size="20" />
                        <input type="password" name="pwd" autocomplete="current-password" id="user_pass" class="input" placeholder="סיסמה" value="" size="20" />
                        <input type="submit" name="wp-submit" id="wp-submit" class="button" value="התחבר" />
                        <a href="<?= esc_url(wp_lostpassword_url()); ?>" style="color:var(--blue);font-size:var(--font-s);"><?php _e('שכחת את הסיסמה?', 'text-domain'); ?></a>

                    </form>
                </div>

                <div class="tab-content" id="tab-signup" style="text-align:center;">
                    <h4>רוצה לקבל לקוחות חדשים?</h4>
                    <h6>ממלאים פרטים ומתחילים לקבל לידים חמים!</h6>
                    <gap-m></gap-m>
                    <?php acfe_form('signup-new-pro'); ?>
                </div>
            </div>
        </div>
    </div>
