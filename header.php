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