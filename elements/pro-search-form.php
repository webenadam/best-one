<?php

function pros_search_form()
{ ?>

    <div class="search-form_parent-container">
        <div class="flex mobile-flex-column gap-xs pro-search-form background-blue radius-s bottom-gap-xs">
            <?php
            // Get used places terms
            $places_terms = get_terms(array(
                'taxonomy' => 'places',
                'hide_empty' => true, // Only show terms that are used by posts
            ));

            // Get used expert terms
            $expert_terms = get_terms(array(
                'taxonomy' => 'expert',
                'hide_empty' => true, // Only show terms that are used by posts
            ));
            ?>
            <select id="pro-serach-form-expert" name="experties">
                <option value=""><?php _e('כל התחומים', 'textdomain'); ?></option>
                <?php foreach ($expert_terms as $expert_term) : ?>
                    <option value="<?= esc_attr($expert_term->term_id); ?>"><?= esc_html($expert_term->name); ?></option>
                <?php endforeach; ?>
            </select>
            <input id="pro-serach-form-place" class="places-input places-typeahead autocomplete-input" name="place" dir="rtl" type="text" placeholder="בחר מיקום" />
            <a id="pro-search-form-submit" href="<?= site_url(); ?>/#main-feed" class="button dark">חפש בעל מקצוע</a>
        </div>
        <h6>התחל חיפוש ראשוני. הגדר סינון נוסף בהמשך.</h6>
    </div>

<?php }



// Enqueue styles at footer to overide
function pro_search_form_styles()
{     ?>

    <style>
        .pro-search-form {
            padding: var(--gap-s);
            background-color: var(--blue);
            gap: var(--gap-s);
            width: fit-content;
        }

        .pro-search-form select,
        .pro-search-form .button {
            width: 100%;
        }

        .pro-search-form .places-input {
            background-color: white;
            width: 212px;
        }


        @media (max-width: 550px) {


            .pro-search-form {
                padding: var(--gap-s);
                width: 100%;
            }
        }
    </style>

<script class="search-form-specific">
    jQuery(document).ready(function($) {
        function updateButtonHref() {
            var expert = $('#pro-serach-form-expert').val();
            var place = $('#pro-serach-form-place').val();
            var baseUrl = '<?= site_url(); ?>/?';
            var params = [];

            if (expert) {
                params.push('feed_expert=' + expert);
            } else {
                $('#pro-serach-form-place').val(''); // Clear place input if expert is reset
                place = ''; // Ensure place is cleared
            }

            if (place) {
                params.push('feed_place=' + encodeURIComponent(place));
            }

            var newHref = baseUrl;
            if (params.length > 0) {
                newHref += params.join('&') + '#main-feed';
            } else {
                newHref += '#main-feed';
            }

            $('#pro-search-form-submit').attr('href', newHref);
        }

        $('#pro-serach-form-place, #pro-serach-form-expert').on('change keyup', updateButtonHref);
    });
</script>




<?php
}
add_action('wp_footer', 'pro_search_form_styles', 990);
/* make my styles load last to override others */
?>
