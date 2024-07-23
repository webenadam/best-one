<?php get_header(); ?>

<?php
// Pro id
$current_user_id = get_current_user_id();
$args = array(
    'post_type' => 'pros',
    'author' => $current_user_id,
    'posts_per_page' => 1,
    'post_status'    => 'any'
);

// Pro post (pro profile)
$query = new WP_Query($args);
if ($query->have_posts()) {
    $query->the_post();
    $pro_post_id = $query->post->ID;


    // Pro posts (articles)
    $args = array(
        'post_type'      => 'post',
        'author'         => $current_user_id,
        'post_status'    => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
        'posts_per_page' => -1 // To get all posts
    );

    // Create a new WP_Query
    $pro_posts = new WP_Query($args);

?>

    <?php get_template_part('templates/me-hero', null, array('pro_post_id' => $pro_post_id, 'page_title' => 'עריכת פרטים')) ?>

    <section id="edit-form" class="main-content">
        <inner>
            <div class="pro_edit_form bottom-gap-l">
                <?php acfe_form('edit-pro', array(
                    'post_id' => $pro_post_id
                )); ?>
            </div>
            <h3 class="bottom-gap-xs">מדד איכות הפרופיל שלך</h3>
            <h4>(בעלי מקצוע עם ציון מעל 90 מקבלים יותר לקוחות)</h4>
            <div id="profile-progress-container">
                <div id="profile-progress-bar">
                    <span id="profile-progress-text"></span>
                </div>
                <span id="profile-progress-message"></span>
            </div>
            <div id="status-list" class="flex-column gap-s"></div>
        </inner>
    </section>



    <section id="reviews" class="light" style="padding-top: 50px;">
        <inner class="reviews-loop flex-column align-center gap-l bottom-gap-l" style="text-align: center;">
            <h2 class="bottom-gap-m" style="color: var(--green); width: 500px; max-width:95%;"><span style="border-bottom: 2px solid var(--blue);"><?= get_field('pro_recommended_count', $pro_post_id); ?> אנשים</span> שיתפו את החוויה שלהם איתך</h2>
            <?php
            $args = array(
                'post_type' => 'pro_reviews',
                'meta_query' => array(
                    array(
                        'key' => 'pro_review_pro_is',
                        'value' => $pro_post_id,
                        'compare' => '=',
                    ),
                ),
            );

            $review_query = new WP_Query($args);
            if ($review_query->have_posts()) {
            ?>
                <div class="reviews-loop flex-column align-center gap-l bottom-gap-l">
                    <?php
                    while ($review_query->have_posts()) {
                        $review_query->the_post();
                        pro_review(get_the_ID());
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            <?php } else {
                echo 'טרם נוספו המלצות לבעל המקצוע הזה.';
            }
            ?>
            <div class="button flex align-center gap-xs" copy="<?= site_url('/add-review/?pro=' . $pro_post_id); ?>">
                <?= svg_icon('profile', null, null, 19, 19); ?> העתק לינק להוספת המלצה
            </div>
        </inner>
    </section>



<?php
} else {
    echo '<p>לא נמצא בעל מקצוע עבור המשתמש הנוכחי.</p>';
}
?>


<style>
    #profile-progress-container {
        width: 100%;
        background-color: var(--soft-background);
        border-radius: var(--radius-l);
        overflow: hidden;
        margin: var(--gap-m) 0;
        position: relative;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #profile-progress-bar {
        height: 30px;
        width: 0;
        background: linear-gradient(90deg, var(--red) 0%, var(--light-green) 100%);
        text-align: left;
        line-height: 30px;
        color: var(--black);
        padding-left: var(--gap-xs);
        transition: width 0.4s, background 0.4s;
        border-radius: var(--radius-l) 0 0 var(--radius-l);
    }

    #profile-progress-text {
        position: absolute;
        left: var(--gap-s);
        top: 0;
        height: 30px;
        line-height: 30px;
        color: var(--red);
    }

    #profile-progress-message {
        position: absolute;
        right: var(--gap-s);
        top: 0;
        height: 30px;
        line-height: 30px;
        color: white;
    }

    .checked,
    .unchecked {
        display: flex;
        font-size: var(--font-s);
        align-items: center;
        background-repeat: no-repeat;
        background-position: right center;
        padding-right: var(--gap-l);
    }

    .checked {
        color: var(--green);
        background-image: url('data:image/svg+xml;base64,<?= base64_encode(svg_icon("circle_check", null, null, 25, 25)) ?>');
    }

    .unchecked {
        color: var(--red);
        background-image: url('data:image/svg+xml;base64,<?= base64_encode(svg_icon("circle_cross", null, null, 25, 25)) ?>');


    }
</style>

<script>
    jQuery(document).ready(function($) {
        /**
         * Profile completeness score is calculated as follows:
         * - 10 points if pro_about has more than 700 letters
         * - 10 points if pro_cert_card is provided
         * - 10 points if the title of the $pro_post_id "expert" taxonomy terms are found in pro_about (divided among terms)
         * - 10 points if pro_promo_video is provided
         * - 5 points if the user has authored at least one "post" post type
         * - 5 points if there is at least one customer review
         * - 50 points divided among the remaining form fields
         */

        function updateProfileScore() {
            let score = 0;
            let checkedList = '';
            let uncheckedList = '';

            // pro_about letter count check
            let aboutText = $('div[data-name="pro_about"] textarea').val() || '';
            let letterCount = aboutText.length;
            if (letterCount > 700) {
                score += 10;
                checkedList += `<span class="checked">יותר מ-700 אותיות בטקסט ״קצת עליי״</span>`;
            } else {
                uncheckedList += `<span class="unchecked">יותר מ-700 אותיות בטקסט ״קצת עליי״</span>`;
            }

            // pro_cert_card check
            if ($('div[data-name="pro_cert_card"] input').val()) {
                score += 10;
                checkedList += `<span class="checked">כרטיס הסמכה</span>`;
            } else {
                uncheckedList += `<span class="unchecked">כרטיס הסמכה</span>`;
            }

            // pro_about contains expert terms
            let expertTerms = [];
            $('div[data-name="pro_expert_terms"] select option:selected').each(function() {
                expertTerms.push($(this).text());
            });

            expertTerms.forEach(term => {
                if (aboutText.includes(term)) {
                    score += Math.round(10 / expertTerms.length);
                    checkedList += `<span class="checked">המונח ${term} מופיע בטקסט ״קצת עליי״</span>`;
                } else {
                    uncheckedList += `<span class="unchecked">המונח ${term} לא מופיע בטקסט ״קצת עליי״</span>`;
                }
            });

            // pro_promo_video check
            if ($('div[data-name="pro_promo_video"] input').val()) {
                score += 10;
                checkedList += `<span class="checked">וידאו שיווקי</span>`;
            } else {
                uncheckedList += `<span class="unchecked">וידאו שיווקי</span>`;
            }

            // Current user is author of at least one "post" post type post
            let userHasPosts = <?php echo json_encode($pro_posts->have_posts()); ?>;
            if (userHasPosts) {
                score += 5;
                checkedList += `<span class="checked">לפחות פוסט אחד</span>`;
            } else {
                uncheckedList += `<span class="unchecked">לפחות פוסט אחד</span>`;
            }

            // Check if there is at least one customer review
            let userHasReviews = <?php echo json_encode($review_query->have_posts()); ?>;
            if (userHasReviews) {
                score += 5;
                checkedList += `<span class="checked">יש לפחות ביקורת לקוחות אחת</span>`;
            } else {
                uncheckedList += `<span class="unchecked">אין ביקורות לקוחות עדיין.  <span lightbox-type="content" lightbox-content="#share-pop" style="margin-right:5px;text-decoration:underline;">שתף לינק להוספת המלצה</span></span>`;
            }



            // All other fields
            let excludedFields = 'div[data-name="pro_cert_card"] input, div[data-name="pro_promo_video"] input, div[data-name="pro_expert_terms"] select';
            let totalFields = $('input[type="text"], input[type="email"], input[type="url"], select, textarea').not(excludedFields).length;
            let fieldsFilled = 0;

            $('input[type="text"], input[type="email"], input[type="url"], select, textarea').not(excludedFields).each(function() {
                if ($(this).val() !== '') {
                    fieldsFilled++;
                }
            });

            if (fieldsFilled === totalFields) {
                score += 50;
                checkedList += `<span class="checked">כל השדות הבסיסיים מלאים</span>`;
            } else {
                let partialScore = (fieldsFilled / totalFields) * 50;
                score += partialScore;
                uncheckedList += `<span class="unchecked">לא כל השדות מלאים</span>`;
            }

            updateScoreAndList(score, checkedList, uncheckedList);
        }

        function updateScoreAndList(score, checkedList, uncheckedList) {
            let progressColor;
            if (score <= 50) {
                progressColor = 'var(--red)';
            } else if (score <= 70) {
                progressColor = 'var(--green)';
            } else {
                progressColor = 'var(--blue)';
            }

            $('#profile-progress-bar').css({
                'width': Math.round(score) + '%',
                'background': `linear-gradient(90deg, ${progressColor} 0%, var(--light-green) 100%)`
            });

            $('#profile-progress-text').text(Math.round(score) + '%').css('color', progressColor);

            let progressMessage;
            if (score <= 50) {
                progressMessage = 'התחלה יפה';
            } else if (score <= 70) {
                progressMessage = 'כמעט שם';
            } else if (score <= 90) {
                progressMessage = 'יפה מאוד';
            } else {
                progressMessage = 'מדהים!';
            }
            $('#profile-progress-message').text(progressMessage);

            $('#status-list').html(checkedList + uncheckedList);
        }

        $(document).on('input change', 'input, textarea, select', function() {
            updateProfileScore();
        });

        updateProfileScore(); // Initial call
    });
</script>


</script>



<?php get_footer(); ?>
