<footer id="site-footer" style="background-color: white;">
    <inner class="flex gap-m mobile-flex-column">
        <!-- Column 1: Site Logo, About Paragraph, and Social Icons -->
        <div class="footer-column flex-1" style="margin: 0 10px;">
            <img src="<?= theme_uri(); ?>/img/Logo.png" alt="Site Logo" style="max-width: 100%; height: auto;">
            <p style="margin: 10px 0;"><?= get_bloginfo('description'); ?></p>
            <div class="social-icons flex gap-m">
                <!-- Replace with your social links -->
                <a href="#"><img src="<?= theme_uri(); ?>/img/icons/facebook.svg" alt="Facebook" style="width: 18px; height: 18px;"></a>
                <a href="#"><img src="<?= theme_uri(); ?>/img/icons/twitter.svg" alt="Twitter" style="width: 18px; height: 18px;"></a>
                <a href="#"><img src="<?= theme_uri(); ?>/img/icons/instagram.svg" alt="Instagram" style="width: 18px; height: 18px;"></a>
            </div>
        </div>
        <!-- Columns 2-5: Category Links using ACF Repeaters -->
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <?php if (have_rows('footer_column_' . $i, 'option')): ?>
                <div class="footer-column flex-1" style="margin: 0 10px;">
                    <ul class="list-reset" style="list-style: none; padding: 0;">
                        <?php while (have_rows('footer_column_' . $i, 'option')): the_row(); ?>
                        <?php
    $type = get_sub_field('link_type');
    $title = get_sub_field('link_title') ?: '';
    $url = '';

    if ($type === 'עמוד' && $post = get_sub_field('link_url_page')) {
        $url = get_permalink($post->ID);
        $title = $title ?: get_the_title($post->ID);
    } elseif ($type === 'פוסט' && $post = get_sub_field('link_url_post')) {
        $url = get_permalink($post->ID);
        $title = $title ?: get_the_title($post->ID);
    } elseif ($type === 'תחום (בעלי מקצוע)' && $term_id = get_sub_field('link_url_expert')) {
        $term = get_term($term_id);
        $url = get_term_link($term);
        $title = $title ?: $term->name;
    } elseif ($type === 'קטגוריה (מאמרים)' && $term_id = get_sub_field('link_url_category')) {
        $term = get_term($term_id);
        $url = get_term_link($term);
        $title = $title ?: $term->name;
    } elseif ($type === 'קישור מותאם') {
        $url = get_sub_field('link_url_custom');
    }

    if ($type === 'כותרת' || empty($url)) {
        echo "<li><h3>" . esc_html($title) . "</h3></li>";
    } else {
        echo "<li><a href='" . esc_url($url) . "'>" . esc_html($title) . "</a></li>";
    }
?>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endfor; ?>
    </inner>
</footer>
<subfooter style="background-color: white; border-top:1px solid var(--light-gray); color: var(--gray); font-size:var(--font-xs);">
    <inner class="flex justify-between align-center" style="padding: var(--gap-s) 0px;">
    <div>©<?= date("Y"); ?> כל הזכויות שמורות לבסט-1.</div>
        <div><a href="https://benadam.co.il">האתר נבנה באהבה על-ידי בנאדם</a></div>
        
    </inner>
</subfooter>
<?php wp_footer(); ?>
</body>
</html>
