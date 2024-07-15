<?php
get_header();
?>

<main id="site-content" role="main">
    <section class="section-404" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/hero_bg.jpg');">
        <inner class="flex flex-column align-center justify-center" style="padding: var(--gap-m); text-align: center;">
            <h1 class="error-title"><?php _e('הדף לא נמצא', 'best-one'); ?></h1>
            <p class="error-message"><?php _e('מצטערים, הדף שחיפשת לא קיים. ייתכן שהוא הועבר או נמחק.', 'best-one'); ?></p>
            <a class="button" href="<?php echo esc_url(home_url('/')); ?>"><?php _e('חזרה לדף הבית', 'best-one'); ?></a>
        </inner>
    </section>
</main>

<style>
.section-404 {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
    background-size: cover;
    background-position: center;
}

.error-title {
    font-size: var(--font-xl);
    color: var(--black);
    margin-bottom: var(--gap-m);
}

.error-message {
    font-size: var(--font-m);
    color: var(--gray);
    margin-bottom: var(--gap-m);
}
</style>

<?php
get_footer();
?>
