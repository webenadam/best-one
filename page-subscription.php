<?php get_header(); ?>

<?php

    function generate_subscription_box($title, $subscription_id, $term_id = null, $featured = false)
    {

        global $current_user_id;
        // Fetch subscription details
        $subscription_type = get_field('subscription_type', $subscription_id);
        $subscription_commitment = get_field('subscription_commitment', $subscription_id);
        $subscription_billed_period = get_field('subscription_billed_period', $subscription_id);
        $subscription_price = get_field('subscription_price', $subscription_id);
        $subscription_saving_amount = get_field('subscription_saving_amount', $subscription_id);

        // Determine if the plan should be marked as featured
        $featured_class = $featured ? 'featured' : '';
        $spark_class = $featured ? 'spark' : '';

        // Placeholder for payment link generation function - ensure you define this elsewhere
        $paymentLink = generateCardcomLink($current_user_id, $subscription_id, $term_id);

        // Start HTML output
?>
        <div class="box stripes plan flex-column gap-s align-center <?php echo $featured_class; ?>">
            <div class="plan-title"><?php echo $title; ?></div>
            <div class="plan-price"><?php echo $subscription_price; ?></div>
            <tag class="plan-saving <?php echo $subscription_saving_amount ? '' : 'empty'; ?>">
                <?php echo $subscription_saving_amount ? $subscription_saving_amount : '-'; ?>
            </tag>
            <div class="plan-button" style="align-self: stretch;">
                <button lightbox-type="iframe" lightbox-content="<?php echo $paymentLink; ?>" class="button green full-width <?php echo $spark_class; ?>">קדם עכשיו</button>
            </div>
        </div>
    <?php
    }


    ?>




    <section id="subscriptions" class="main-content">
        <inner>

                <!-- Subscription options -->
                <div class="box stripes subscription bottom-gap-l">

                    <h2>חבילת פרסום בסיסי</h2>
                    <p class="bottom-gap-m">
                        רוצה להתחיל לקבל לקוחות רציניים? בחר חבילת פרסום עכשיו ותתחיל לעבוד!
                    </p>

                    <div class="payment-plans grid-3 bottom-gap-l">
                        <div class="dots_ico absolute" style="top: 330px;left: -26px;">
                            <?= svg_icon('dots'); ?>
                        </div>

                        <div class="sauqre_ico absolute" style="top: 230px;right: -126px;">
                            <?= svg_icon('square'); ?>
                        </div>

                        <?php generate_subscription_box('חודשי', 831); ?>
                        <?php generate_subscription_box('חצי שנתי', 832); ?>
                        <?php generate_subscription_box('שנתי', 834, null, $featured = true); ?>



                        <div class="subscription-features bottom-gap-l" style="width: 900px;">

                            <div class="flex-column gap-m">
                                <h3 class="check">דף עסק דיגיטלי מעוצב, עם כל המידע החשוב על העסק שלך ועליך</h3>
                                <h3 class="check">נוכחות בולטת ברשת מטורפת לגולשים שמחפשים אותך</h3>
                                <h3 class="check">ממשק לעדכון עצמאי של דף העסק הכולל ציונים על איכות הפרסום שלך + הצעות לשיפור ויעול</h3>
                                <h3 class="check">סידרת טיפים למקסום הנוכחות שלך ברשת</h3>
                                <h3 class="check">אפשרות לפרסם בדף העסק מוצרים, קופונים ומחירונים</h3>
                                <h3 class="check">הצגת דירוגים וחוות דעת של לקוחות עם אפשרות מענה בדף העסק שלכם</h3>
                                <h3 class="check">מעקב אחרי ביצועי העמוד שלכם</h3>
                                <h3 class="check">עדכון תוכן אישי הכולל מאמרים ותוכן מקצועי שיהפכו אותך לאוטוריטה בתחומך</h3>
                            </div>
                        </div>


                    </div>


        </inner>
    </section>






<?php get_footer(); ?>

<style class="page-specific-styles">
    .term-subscription h2 span {
        color: var(--blue);
    }

    .subscription-features h3 {
        font-weight: 700;
    }

    .subscription-features .check {
        display: flex;
        color: var(--blue);
        font-size: var(--font-m);
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

    .payment-plans .plan-price::before,
    .payment-plans .plan-saving:after {
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

        #subscriptions .dots_ico {
            top: 630px !important;
        }


        .box.subscription h2,
        .box.subscription p {
            text-align: center;
        }


        .box.subscription h2,
        .box.subscription p {
            text-align: center;
        }

        #subscriptions .dots_ico {
            top: 630px !important;
        }
    }
</style>
