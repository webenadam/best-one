<?php $clean_page = get_query_var('cleanpage'); ?>
<?php if (!$clean_page) { ?>
    <!-- Accessibility Icon and Toolbar -->
    <div id="accessibility-icon" onclick="toggleAccessibilityToolbar()" title="כלים לנגישות">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
            <title>wheelchair-ramp</title>
            <g fill="#ffffff">
                <rect x="0.92" y="27.5" width="30.16" height="2" transform="translate(-2.95 1.87) rotate(-6.125)" fill="#ffffff"></rect>
                <circle cx="10" cy="3" r="3" fill="#ffffff"></circle>
                <path d="M20.649,17.9l2.269,6.112,1.9-.633L22.686,16.1a1.245,1.245,0,0,0-1.381-.838l-5.367.682L14.061,9.365,21,9V7l-9.5.01a2.461,2.461,0,0,0-.687.086A2.5,2.5,0,0,0,9.1,10.187l2,7a2.5,2.5,0,0,0,2.768,1.787Z" fill="#ffffff"></path>
                <path d="M16.731,20.545a4.987,4.987,0,1,1-8.217-5.118l-.6-2.1A7,7,0,1,0,18.889,20.2Z" fill="#ffffff"></path>
            </g>
        </svg>
    </div>
    <div id="accessibility-toolbar" class="radius-m shadow-s">
        <button class="button radius-s" onclick="resizeText(1.2)" title="הגדל טקסט">הגדל טקסט +</button>
        <button class="button radius-s" onclick="resetTextSize()" title="טקסט בגודל רגיל">אפס טקסט</button>
        <button class="button radius-s" onclick="resizeText(0.8)" title="הקטן טקסט">הקטן טקסט-</button>
        <button class="button radius-s" id="contrast-button" onclick="toggleContrast()" title="ניגודיות גבוהה">הפעל ניגודיות</button>
    </div>
    <script>
        let currentFontSize = 20;

        function toggleAccessibilityToolbar() {
            var toolbar = document.getElementById('accessibility-toolbar');
            if (toolbar.classList.contains('active')) {
                toolbar.classList.remove('active');
            } else {
                toolbar.classList.add('active');
            }
        }

        function resizeText(multiplier) {
            currentFontSize *= multiplier;
            document.body.style.fontSize = currentFontSize + 'px';
        }

        function resetTextSize() {
            currentFontSize = 20;
            document.body.style.fontSize = currentFontSize + 'px';
        }

        function toggleContrast() {
            var body = document.body;
            var button = document.getElementById('contrast-button');
            body.classList.toggle('hc');
            if (body.classList.contains('hc')) {
                localStorage.setItem('highContrast', 'enabled');
                button.textContent = 'כבה ניגודיות';
            } else {
                localStorage.removeItem('highContrast');
                button.textContent = 'הפעל ניגודיות';
            }
        }

        window.onload = function() {
            if (localStorage.getItem('highContrast') === 'enabled') {
                document.body.classList.add('hc');
                document.getElementById('contrast-button').textContent = 'כבה ניגודיות';
            }
        };
    </script>


    <footer id="site-footer" style="background-color: white;">
        <inner class="flex gap-m mobile-flex-column">
            <!-- Column 1: Site Logo, About Paragraph, and Social Icons -->
            <div class="footer-column flex-1" style="margin: 0 10px;">
                <img class="logo" src="<?= theme_uri(); ?>/img/Logo.png" alt="Site Logo" style="max-width: 100%; height: auto;">
                <p style="margin: 10px 0;"><?= get_bloginfo('description'); ?></p>
                <div class="social-icons flex gap-m">
                    <!-- Replace with your social links -->
                    <a href="#"><img src="<?= theme_uri(); ?>/img/icons/facebook.svg" alt="Facebook" style="width: 18px; height: 18px;"></a>
                    <a href="#"><img src="<?= theme_uri(); ?>/img/icons/twitter.svg" alt="Twitter" style="width: 18px; height: 18px;"></a>
                    <a href="#"><img src="<?= theme_uri(); ?>/img/icons/instagram.svg" alt="Instagram" style="width: 18px; height: 18px;"></a>
                </div>
                <div class="app-links">
                    <img style="margin-top:15px;" src="<?= theme_uri(); ?>/img/googleplayandappstore.png" alt="app-links-banners" class="app-links-banners">
                </div>
            </div>
            <!-- Columns 2-5: Category Links using ACF Repeaters -->
            <?php for ($i = 1; $i <= 4; $i++) : ?>
                <?php if (have_rows('footer_column_' . $i, 'option')) : ?>
                    <div class="footer-column flex-1" style="margin: 0 10px;">
                        <ul class="list-reset" style="list-style: none; padding: 0;">
                            <?php while (have_rows('footer_column_' . $i, 'option')) : the_row(); ?>
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
        <inner class="flex justify-between align-center tablet-flex-column" style="padding: var(--gap-s) 0px;">
            <div>©<?= date("Y"); ?> כל הזכויות שמורות לבסט-1.</div>
            <div><a href="https://benadam.co.il" target="_blank">נבנה באהבה על-ידי בנאדם</a></div>

        </inner>
    </subfooter>
<?php } ?>



<?php wp_footer(); ?>
<style>
    #accessibility-icon {
        position: fixed;
        z-index: 1001;
        bottom: 20px;
        left: 20px;
        background-color: var(--blue);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    #accessibility-icon:hover {
        position: fixed;
        z-index: 1001;
        bottom: 20px;
        left: 20px;
        background-color: var(--dark-blue);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow-m);
    }

    #accessibility-toolbar {
        position: fixed;
        z-index: 1000;
        bottom: 70px;
        left: 20px;
        background: white;
        border: 1px solid var(--blue);
        padding: 0px;
        border-radius: var(--radius-m);
        display: flex;
        flex-direction: column;
        gap: var(--gap-s);
        overflow: hidden;
        transition: all 0.2s ease-in-out;
        max-height: 0px;
        opacity: 0;
    }

    #accessibility-toolbar.active {
        padding: var(--gap-s);
        max-height: 400px;
        opacity: 1;
    }

    #accessibility-toolbar button {
        min-width: 180px;
    }

    .hc *:not(svg):not(#accessibility-icon):not(avatar):not(avatar-s):not(avatar-m):not(avatar-l):not(avatar-xl) {
        color: #fff !important;
        border-color: white !important;
    }

    .hc *:not(span):not(svg):not(#accessibility-icon):not(avatar):not(avatar-s):not(avatar-m):not(avatar-l):not(avatar-xl) {
        background-color: #000 !important;
        background-image: none;
    }

    .hc .button {
        background-color: #000 !important;
        background-image: none;
    }

    .hc .button:hover {
        filter: invert(1);
    }

    .hc img,
    .hc avatar,
    .hc avatar-s,
    .hc avatar-m,
    .hc avatar-l,
    .hc avatar-xl,
    .hc .post-thumbnail {
        filter: grayscale(1);
    }

    .hc box,
    .hc .box,
    .hc button,
    .hc .button,
    .hc tag {
        border: 1px solid;
    }

    .hc section {
        border-bottom: 1px solid;
    }

    .hc exprties::before,
    .hc .accordion::before {
        display: none;
    }

    .hc .logo,
    .hc svg,
    .hc .social-icons img {
        filter: grayscale(1) brightness(9.5);
    }

    .hc a {
        color: #fd0 !important;
    }
</style>
</body>

</html>
