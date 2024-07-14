<?php get_header(); ?>

<?php
$current_user_id = get_current_user_id();
$args = array(
    'post_type' => 'pros',
    'author' => $current_user_id,
    'posts_per_page' => 1,
    'post_status'    => 'any'
);

$query = new WP_Query($args);
$pro_subscribed = false;  // Default to false
$pro_subscription = false; // Default to false


// Check if the current user has an active subscription
if ($query->have_posts()) {
    $query->the_post();
    $pro_post_id = $query->post->ID;

    if (have_rows('ad_subscriptions', $pro_post_id)) {
        while (have_rows('ad_subscriptions', $pro_post_id)) {
            the_row();
            $end_date = get_sub_field('ad_subscription_end_date');
            $date_object = DateTime::createFromFormat('d/m/Y', $end_date);
            $current_date = new DateTime('now');

            if ($date_object >= $current_date) {
                $pro_subscribed = true;
                $pro_subscription = get_sub_field('ad_subscription_advertise_plan')['label'];
                break;  // Stop the loop if a valid subscription is found
            }
        }
    }
?>

    <?php get_template_part('templates/me-hero', null, array('pro_post_id' => $pro_post_id, 'page_title' => 'פרטי מנוי')) ?>


    <style>
        .term-subscription h2 span {
            color:var(--blue);
        }
        .check {
            display: flex;
            color: var(--blue);
            font-weight: 700;
            font-size: var(--font-s);
            position: relative;
            margin-right: var(--gap-m);
            max-width: 90%;
        }

        .check:not(:nth-child(3)) {
            width: 580px;
        }

        .term-subscription .check {
            width: auto;
        }

        .check::before {
            content: '';
            display: block;
            background-image: <?= svg_icon('circle_check', null, null, null, null, true); ?>;
            height: 30px;
            width: 30px;
            min-width: 30px;
            /* for mobile flex issue */
        }


        .payment-plans .plan-title {
            font-size: var(--font-m);
            font-weight: 700;
            margin-bottom: -20px;
            position: relative;
            width: 100%;
            text-align: center;
        }

        .payment-plans .plan.featured {
            position: relative;
        }

        .payment-plans .plan.featured::after {
            content: 'המומלץ ביותר!';
            position: absolute;
            top: 0;
            right: 0px;
            left: 0;
            margin: auto;
            font-size: var(--font-xs);
            font-weight: 500;
            color: var(--blue);
            text-align: center;
            background: var(--soft-background);
            width: 170px;
            padding-bottom: 2px;
            border-radius: 0px 0px var(--radius-s) var(--radius-s);
        }

        .payment-plans .plan-price::before {
            content: "₪";
        }

        .payment-plans .plan-price {
            font-size: var(--font-l);
            font-weight: 700;
            color: var(--blue);
        }

        .payment-plans .plan-saving.empty {
            opacity: 0;
        }


        .box.subscription {
            position: relative;
        }

        .box.subscription::after {
            content: '';
            background-image: url('<?= theme_uri('/img/man2.png'); ?>');
            pointer-events: none;
            position: absolute;
            bottom: -17px;
            left: -44px;
            width: 347px;
            height: 336px;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: bottom center;
        }

        @media (max-width: 550px) {
            .subscribe-status {
                text-align: center;
            }

            .box.subscription::after {
                bottom: -17px;
                left: -84px;
                height: 292px;
            }

            h4.check:last-child,
            h4.check:nth-last-child(2) {
                width: 60%;
            }
        }
    </style>

    <section id="subscriptions" class="main-content">
        <inner>
            <div class="subscribe-status bottom-gap-m">מנוי נוכחי: <?= $pro_subscribed ? '<span style="color:var(--blue);">' . $pro_subscription . '</span>' : '<span style="color:var(--gray);">לא מפורסם</span></div>'; ?></div>
            <?php if (!$pro_subscribed) { ?>
            <!-- Subscription options -->
            <div class="box stripes subscription bottom-gap-l">
                <style>
                    @media (max-width: 550px) {

                        .box.subscription h2,
                        .box.subscription p {
                            text-align: center;
                        }
                    }
                </style>
                <h2>חבילת פרסום בסיסי</h2>
                <p class="bottom-gap-m">
                    רוצה להתחיל לקבל לקוחות רציניים? בחר חבילת פרסום עכשיו ותתחיל לעבוד!
                </p>

                <div class="payment-plans grid-3 bottom-gap-l">
                    <div class="dots_ico absolute" style="top: 330px;left: -26px;">
                        <?= svg_icon('dots'); ?>
                    </div>
                    <style>
                        @media (max-width: 550px) {

                            #subscriptions .dots_ico {
                                top: 630px !important;
                            }
                        }
                    </style>
                    <div class="sauqre_ico absolute" style="top: 230px;right: -126px;">
                        <?= svg_icon('square'); ?>
                    </div>
                    <div class="box stripes plan flex-column gap-s align-center">
                        <div class="plan-title">חודשי</div>
                        <div class="plan-price">499</div>
                        <tag class="plan-saving empty">-</tag>
                        <div class="plan-button" style="align-self: stretch;"><a class="button green full-width">פרסם עכשיו</a></div>
                    </div>
                    <div class="box stripes plan flex-column gap-s align-center">
                        <div class="plan-title">חצי שנתי</div>
                        <div class="plan-price">399</div>
                        <tag class="plan-saving">חסכון של ₪600</tag>
                        <div class="plan-button" style="align-self: stretch;"><a class="button green full-width">פרסם עכשיו</a></div>
                    </div>
                    <div class="box stripes plan flex-column gap-s align-center featured">
                        <div class="plan-title">שנתי</div>
                        <div class="plan-price">249</div>
                        <tag class="plan-saving">חסכון של ₪3108</tag>
                        <div class="plan-button" style="align-self: stretch;"><a class="button full-width spark">פרסם עכשיו!</a></div>
                    </div>
                </div>


                <div class="subscription-features bottom-gap-l">

                    <div class="flex-column gap-m">
                        <h4 class="check">דף עסק דיגיטלי מעוצב, עם כל המידע החשוב על העסק שלך ועליך</h4>
                        <h4 class="check">נוכחות בולטת ברשת מטורפת לגולשים שמחפשים אותך</h4>
                        <h4 class="check">ממשק לעדכון עצמאי של דף העסק הכולל ציונים על איכות הפרסום שלך + הצעות לשיפור ויעול</h4>
                        <h4 class="check">סידרת טיפים למקסום הנוכחות שלך ברשת</h4>
                        <h4 class="check">אפשרות לפרסם בדף העסק מוצרים, קופונים ומחירונים</h4>
                        <h4 class="check">הצגת דירוגים וחוות דעת של לקוחות עם אפשרות מענה בדף העסק שלכם</h4>
                        <h4 class="check">מעקב אחרי ביצועי העמוד שלכם</h4>
                        <h4 class="check">עדכון תוכן אישי הכולל מאמרים ותוכן מקצועי שיהפכו אותך לאוטוריטה בתחומך</h4>
                    </div>
                </div>


            </div>
            <?php } else { ?>


            <!--Term Subscription options -->
            <?php
            // Get the terms for the 'expert' taxonomy
$terms = get_the_terms($pro_post_id, 'expert');

if ($terms && !is_wp_error($terms)) {
    
    foreach ($terms as $term) { ?>


<div class="box stripes subscription term-subscription bottom-gap-l">
                <style>
                    @media (max-width: 550px) {

                        .box.subscription h2,
                        .box.subscription p {
                            text-align: center;
                        }
                    }
                </style>
                <h2>קידום למומלצים בתחום <span><?= esc_html($term->name); ?></span></h2>
                <p class="bottom-gap-m">
                    תבלוט בתחום שלך. תהיה ראשון. תקבל את הלקוחות ראשון.
                </p>

                <div class="payment-plans grid-3 bottom-gap-m">
                    <div class="dots_ico absolute" style="top: 330px;left: -26px;">
                        <?= svg_icon('dots'); ?>
                    </div>
                    <style>
                        @media (max-width: 550px) {

                            #subscriptions .dots_ico {
                                top: 630px !important;
                            }
                        }
                    </style>
                    <div class="sauqre_ico absolute" style="top: 230px;right: -126px;">
                        <?= svg_icon('square'); ?>
                    </div>
                    <div class="box stripes plan flex-column gap-s align-center">
                        <div class="plan-title">חודשי</div>
                        <div class="plan-price">499</div>
                        <tag class="plan-saving empty">-</tag>
                        <div class="plan-button" style="align-self: stretch;"><a class="button green full-width">קדם עכשיו</a></div>
                    </div>
                    <div class="box stripes plan flex-column gap-s align-center">
                        <div class="plan-title">חצי שנתי</div>
                        <div class="plan-price">399</div>
                        <tag class="plan-saving">חסכון של ₪600</tag>
                        <div class="plan-button" style="align-self: stretch;"><a class="button green full-width">קדם עכשיו</a></div>
                    </div>
                    <div class="box stripes plan flex-column gap-s align-center featured">
                        <div class="plan-title">שנתי</div>
                        <div class="plan-price">249</div>
                        <tag class="plan-saving">חסכון של ₪3108</tag>
                        <div class="plan-button" style="align-self: stretch;"><a class="button full-width spark">קדם עכשיו!</a></div>
                    </div>
                </div>


                <div class="subscription-features bottom-gap-l">

                    <div class="flex-column gap-m">
                        <h4 class="check">הופעה במומלצים בדפי התחום ״<?= esc_html($term->name); ?>״</h4>
                        <h4 class="check">ראשון בכל תוצאות החיפושים בתחום ״<?= esc_html($term->name); ?>״</h4>
                        <h4 class="check">הופעה במומלצים בדף הבית</h4>
                    </div>
                </div>


            </div>





<?php
    }
    }
} ?>
        



        </inner>
    </section>





<?php
} else {
    echo '<p>לא נמצא בעל מקצוע עבור המשתמש הנוכחי.</p>';
}
?>

<?php get_footer(); ?>
