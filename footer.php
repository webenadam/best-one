<footer id="site-footer" style="background-color: white;">
    <inner class="flex gap-m" style="max-width: 1200px; margin: 0 auto;">
        <!-- Column 1: Site Logo, About Paragraph, and Social Icons -->
        <div class="footer-column flex-1" style="margin: 0 10px;">
            <img src="<?php echo theme_uri(); ?>/img/Logo.png" alt="Site Logo" style="max-width: 100%; height: auto;">
            <p style="margin: 10px 0;"><?php echo get_bloginfo('description'); ?></p>
            <div class="social-icons flex gap-m">
                <!-- Replace with your social links -->
                <a href="#"><img src="<?php echo theme_uri(); ?>/img/icons/facebook.svg" alt="Facebook" style="width: 18px; height: 18px;"></a>
                <a href="#"><img src="<?php echo theme_uri(); ?>/img/icons/twitter.svg" alt="Twitter" style="width: 18px; height: 18px;"></a>
                <a href="#"><img src="<?php echo theme_uri(); ?>/img/icons/instagram.svg" alt="Instagram" style="width: 18px; height: 18px;"></a>
            </div>
        </div>
        <!-- Columns 2-5: Category Links using ACF Repeaters -->
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <?php if (have_rows('footer_column_' . $i, 'option')): ?>
                <div class="footer-column flex-1" style="margin: 0 10px;">
                    <ul class="list-reset" style="list-style: none; padding: 0;">
                        <?php while (have_rows('footer_column_' . $i, 'option')): the_row(); ?>
                            <?php
                            $link_title = get_sub_field('top_nav_link_title');
                            $link_type = get_sub_field('top_nav_link_type');
                            $link_url = '';

                            switch ($link_type) {
                                case 'עמוד':
                                    $link_url = get_permalink(get_sub_field('top_nav_link_page'));
                                    break;
                                case 'פוסט':
                                    $link_url = get_permalink(get_sub_field('top_nav_link_post'));
                                    break;
                                case 'תחום':
                                    $link_url = get_term_link(get_sub_field('top_nav_link_expert'));
                                    break;
                                case 'קישור מותאם':
                                    $link_url = get_sub_field('top_nav_link_custom');
                                    break;
                                case 'כותרת':
                                    echo '<h3 class="font-lg font-bold" style="font-size: var(--font-m); font-weight: var(--font-w-700);">' . esc_html($link_title) . '</h3>';
                                    continue 2;
                            }
                            ?>
                            <li style="margin-bottom: 5px;">
                                <a href="<?php echo esc_url($link_url); ?>" style="color: var(--dark-gray); text-decoration: none;" class="hover:text-blue">
                                    <?php echo esc_html($link_title); ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endfor; ?>
    </inner>
</footer>
<?php wp_footer(); ?>
</body>
</html>