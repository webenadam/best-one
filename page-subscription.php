<?php get_header(); ?>
<?php get_template_part('templates/singular-hero') ?>
<?php global $current_user_id;
$current_user_id = get_current_user_id(); ?>



<section id="features">
    <inner class="flex mobile-flex-column-reverse gap-l align-center" style="padding-bottom:var(--gap-xl);">
        <right style="width:70%">
            <h2 class="bottom-gap-m">למה BEST-1?</h2>
            <grid class="grid-1 gap-s">
                <h3 class="check">נבחרת העילית: רק בעלי מקצוע העומדים בסטנדרטים הגבוהים ביותר נכללים באתר ולכן , גם הלקוחות שלך יהיו כאלו.</h3>
                <h3 class="check">מגוון תחומים: מתווכים, יועצי משכנתאות, מאתרי ליקויי בניה, שמאים ועוד</h3>
                <h3 class="check">בקרת איכות: בדיקה מתמדת של שירות, מקצועיות, מחיר וזמינות מה שמעלה את הסמכות שלך בשת.</h3>
                <h3 class="check">חשיפה ממוקדת: הזרמת תנועה איכותית דרך פעילות אורגנית וממומנת ישירות אליך</h3>
                <h3 class="check">פרופיל עשיר: הצגת ניסיון, המלצות, הסמכות ואזורי שירות מה שיגדיל את נפח החיפושים שלך ויזרים לך יותר לקוחות.</h3>
            </grid>
        </right>
        <left class="flex">
            <div class="men-container relative">
                <div class="circle absolute grow-shrink"></div><img src="<?= theme_uri('/img/2men3.png'); ?>" alt="למה אצלנו?">
            </div>
        </left>
    </inner>
    <div class="sauqre_ico absolute" style="top: 230px;right: -126px; z-index:90;">
        <?= svg_icon('square'); ?>
    </div>
</section>


<section id="how-it-works" class="light">
    <inner>
        <h2>איך זה עובד?</h2>
        <div class="flow-list grid-3 gap-m">
            <div class="box flow-item">
                <div class="step-number">1</div>
                <div class="step-description">
                    <h3 class="title">הצטרפות</h3>
                    <div class="description">בחר את חבילת המנוי המתאימה לך - כל החבילות במחיר השקה כרגע.</div>
                </div>
            </div>
            <div class="box flow-item">
                <div class="step-number">2</div>
                <div class="step-description">
                    <h3 class="title">בניית פרופיל</h3>
                    <div class="description">צור פרופיל מקצועי ומושקע המציג את כל יתרונותיך שימשוך אליך עוד לקוחות.</div>
                </div>
            </div>
            <div class="box flow-item">
                <div class="step-number">3</div>
                <div class="step-description">
                    <h3 class="title">בקרת איכות</h3>
                    <div class="description">עבור את תהליך בקרת האיכות שלנו.</div>
                </div>
            </div>
            <div class="box flow-item">
                <div class="step-number">4</div>
                <div class="step-description">
                    <h3 class="title">חשיפה</h3>
                    <div class="description">קבל חשיפה לקהל יעד איכותי המחפש את שירותיך.</div>
                </div>
            </div>
            <div class="box flow-item">
                <div class="step-number">5</div>
                <div class="step-description">
                    <h3 class="title">צמיחה</h3>
                    <div class="description">הגדל את מאגר הלקוחות שלך.</div>
                </div>
            </div>
        </div>
    </inner>
</section>



<section id="subscriptions" class="dark weird-background">
    <inner style="z-index:90;"> 

        <!-- Subscription options -->
            <h2 class="text-center">בחר את החבילה המתאימה לך - מחירי השקה!</h2>

            <div class="payment-plans grid-3 bottom-gap-l">
                <div class="dots_ico absolute" style="top: 330px;left: -26px;">
                    <?= svg_icon('dots'); ?>
                </div>

                <div class="sauqre_ico absolute" style="top: 230px;right: -126px;">
                    <?= svg_icon('square'); ?>
                </div>

                <?php generate_subscription_box(925); ?>
                <?php generate_subscription_box(923); ?>
                <?php generate_subscription_box(834, null, $featured = true); ?>



            </div>


    </inner>

    <!-- Add sprinkle elements -->
    <?php for ($i = 0; $i < 180; $i++) :
      $size = rand(2, 11);
      $animation_class = 'sprinkle';
      switch (rand(0, 4)) {
        case 1:
          $animation_class = 'sprinkle-b';
          break;
        case 2:
          $animation_class = 'sprinkle-c';
          break;
        case 3:
          $animation_class = 'sprinkle-d';
          break;
        case 4:
          $animation_class = 'sprinkle-e';
          break;
      }
    ?>
      <div class="<?= $animation_class; ?>" style="
      opacity: <?= mt_rand(0, 10) / 10; ?>;
      filter:blur(<?= rand(0, 11) ?>px);
        top: <?= rand(0, 100); ?>%;
        left: <?= rand(0, 100); ?>%;
        width: <?= $size; ?>px;
        height: <?= $size; ?>px;
        background: <?= rand(0, 1) ? (rand(0, 1) ? 'var(--light-blue)' : 'white') : (rand(0, 1) ? 'var(--blue)' : 'var(--dark-blue)'); ?>;">
      </div>
    <?php endfor; ?>
</section>






<?php get_footer(); ?>

<style class="page-specific-styles">
    .term-subscription h2 span {
        color: var(--blue);
    }

    h3.check {
        font-weight: 700;
    }

    .box.flow-item {
        position: relative;
        height: 135px;
        padding: var(--gap-s) var(--gap-m);
        border-bottom: 3px solid var(--light-green);
    }

    .flow-list .step-description {
        position: relative;
        z-index: 1;
    }

    .flow-list .step-number {
        position: absolute;
        right: -12px;
        top: -2px;
        font-size: 90px;
        color: var(--light-gray);
        font-weight: bold;
        z-index: 0;
    }

    h3.check {
        display: flex;
        color: var(--blue);
        font-size: var(--font-m);
        position: relative;
        max-width: 90%;
    }

    .check:not(:nth-child(3)) {
        width: 780px;
    }

    .plan-features {
        width: 100%;
    }

    .plan-features .check {
        width: auto;
        padding-left: 26px;
        margin-right: var(--gap-s);
    }

    .tooltip-mark {
        display: block;
        color: var(--light-green);
        border: 1px solid;
        border-radius: 50%;
        width: 27px;
        height: 27px;
        text-align: center;
        line-height: 23px;
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


    #features .man-details {
        position: absolute;
        right: 450px;
        bottom: 20px;
        width: 500px;
    }

    #features {
        overflow: visible;
        height: 473px;
    }


    #features .men-container.relative {
        margin-bottom: -134px;
        margin-top: -247px;
    }

    #features .circle.absolute.grow-shrink {
        top: 220px;
        right: -70px;
        width: 235px;
        height: 235px;
        border-radius: 50%;
        background: var(--green);
    }

    #features img {
        position: relative;
        z-index: 5;
        width: 400px;
    }

    #features left h2 {
        margin-top: -200px;
    }

    #features p {
        color: var(--dark-gray);
        max-width: 80%;
    }

    .check::before {
        content: '';
        display: inline-block;
        background-image: <?= svg_icon('circle_check', null, null, null, null, true); ?>;
        margin-left: 13px;
        height: 30px;
        width: 30px;
        vertical-align: middle;
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


    /* Weird Background */

    .leaves_left,
  .leaves_right {
    position: absolute;
    top: 80px;
  }

  .leaves_left svg,
  .leaves_right svg {
    width: 250px;
    fill: var(--blue);
  }

  .leaves_left svg path,
  .leaves_right svg path {
    fill: #342bb2;
    opacity: 1;
  }

  .leaves_right {
    right: 0.1%;
    animation: slight-rotate 7s infinite ease-in-out;
  }

  .leaves_left {
    left: 0.1%;
    animation: slight-rotate-reverse 7s infinite ease-in-out;
  }

  .weird-background .profile-box {
    z-index: 90;
  }

  .weird-background h2 {
    text-shadow: 0 0 45px #ffffff85;
  }

  @media (min-width: 850px) {
    .weird-background .profile-box {
      animation: wave 2.5s infinite ease-in-out;
    }

    .weird-background .profile-box:nth-child(2) {
      animation-delay: 0s;
    }

    .weird-background .profile-box:nth-child(3) {
      animation-delay: 0.2s;
    }

    .weird-background .profile-box:nth-child(4) {
      animation-delay: 0.4s;
    }

    .weird-background .profile-box:hover {
      border-color: var(--green);
    }
  }

  @keyframes wave {

    0%,
    33.33%,
    100% {
      transform: translateY(0);
    }

    16.67% {
      transform: translateY(-10px);
    }
  }

  @keyframes slight-rotate {
    0% {
      transform: rotateZ(5deg) rotateY(5deg);
    }

    50% {
      transform: rotateZ(-5deg) rotateY(-28deg);
    }

    100% {
      transform: rotateZ(5deg) rotateY(5deg);
    }
  }

  @keyframes slight-rotate-reverse {
    0% {
      transform: rotateZ(-5deg) rotateY(-5deg);
    }

    50% {
      transform: rotateZ(5deg) rotateY(28deg);
    }

    100% {
      transform: rotateZ(-5deg) rotateY(-5deg);
    }
  }

  @keyframes shine {
    0% {
      background-position: -200% 0;
    }

    100% {
      background-position: 200% 0;
    }
  }

  @keyframes sprinkle {
    0% {
      transform: translateY(0) translateX(0) scale(0.5);
    }

    50% {
      transform: translateY(-30px) translateX(3px) scale(1);
    }

    100% {
      transform: translateY(0) translateX(0) scale(0.5);
    }
  }

  @keyframes sprinkle-b {
    0% {
      transform: translateY(0) translateX(0) scale(1);
    }

    50% {
      transform: translateY(80px) translateX(-23px) scale(0.5);
    }

    100% {
      transform: translateY(0) translateX(0) scale(1);
    }
  }

  @keyframes sprinkle-c {
    0% {
      transform: translateY(0) translateX(0) scale(0.5);
    }

    50% {
      transform: translateY(-50px) translateX(10px) scale(1.2);
    }

    100% {
      transform: translateY(0) translateX(0) scale(0.5);
    }
  }

  @keyframes sprinkle-d {
    0% {
      transform: translateY(0) translateX(0) scale(0.8);
    }

    50% {
      transform: translateY(40px) translateX(-15px) scale(1.1);
    }

    100% {
      transform: translateY(0) translateX(0) scale(0.8);
    }
  }

  @keyframes sprinkle-e {
    0% {
      transform: translateY(0) translateX(0) scale(0.6);
    }

    50% {
      transform: translateY(-20px) translateX(5px) scale(1.3);
    }

    100% {
      transform: translateY(0) translateX(0) scale(0.6);
    }
  }

  .weird-background {
    background: linear-gradient(100deg, var(--dark-blue), var(--light-blue), var(--dark-blue));
    background-size: 200% 100%;
    animation: shine 6s linear infinite;
    overflow: hidden;
    position: relative;
  }

  .weird-background::after {
    content: '';
    background: var(--dark-blue);
    width: 140%;
    position: absolute;
    bottom: -90px;
    left: -20%;
    right: -20%;
    height: 360px;
    filter: blur(125px);
    pointer-events: none;
    opacity: 0.8;
    z-index: 10;
  }

  .weird-background::before {
    content: '';
    background: var(--black);
    width: 140%;
    position: absolute;
    bottom: -120px;
    left: -20%;
    right: -20%;
    height: 300px;
    filter: blur(125px);
    pointer-events: none;
    opacity: 0.8;
    z-index: 20;
  }


  @media (max-width: 850px) {
    .weird-background::after {
      display: none;
    }

    .weird-background {
      background: inherit;
      overflow: visible;
    }

    .weird-background .circle {
      top: 80% !important;
    }

    .leaves_left,
    .leaves_right {
      top: -20px;
    }

    .leaves_left svg,
    .leaves_right svg {
      width: 120px;
    }

    .leaves_right {
      right: -3%;
    }

    .leaves_left {
      left: -3%;
    }
  }

  .sprinkle,
  .sprinkle-b,
  .sprinkle-c,
  .sprinkle-d,
  .sprinkle-e {
    position: absolute;
    border-radius: 50%;
    opacity: 0.8;
    z-index: 40;
  }

  .sprinkle {
    animation: sprinkle 3s infinite ease-in-out;
  }

  .sprinkle-b {
    animation: sprinkle-b 5s infinite ease-in-out;
  }

  .sprinkle-c {
    animation: sprinkle-c 4s infinite ease-in-out;
  }

  .sprinkle-d {
    animation: sprinkle-d 6s infinite ease-in-out;
  }

  .sprinkle-e {
    animation: sprinkle-e 5.5s infinite ease-in-out;
  }

  .sprinkle:nth-child(odd) {
    animation-duration: 2.5s;
  }

  .sprinkle:nth-child(even) {
    animation-duration: 3.5s;
  }

  .sprinkle-b:nth-child(odd) {
    animation-duration: 1.5s;
  }

  .sprinkle-b:nth-child(even) {
    animation-duration: 6.5s;
  }

  .sprinkle-c:nth-child(odd) {
    animation-duration: 2s;
  }

  .sprinkle-c:nth-child(even) {
    animation-duration: 5s;
  }

  .sprinkle-d:nth-child(odd) {
    animation-duration: 3s;
  }

  .sprinkle-d:nth-child(even) {
    animation-duration: 4.5s;
  }

  .sprinkle-e:nth-child(odd) {
    animation-duration: 2.5s;
  }

  .sprinkle-e:nth-child(even) {
    animation-duration: 6s;
  }

  .weird-background .text-shine {
    background: linear-gradient(281deg, #04060a 30%, #2a334d 50%, #04060a 70%);
    background-size: 200%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: text-shine 9s linear infinite;
    text-shadow: 0 3px 25px #ffffff29;
  }

  @keyframes text-shine {
    0% {
      background-position: -200% 0;
    }

    40% {
      background-position: 200% 0;
    }

    50% {
      background-position: 200% 0;
    }

    90% {
      background-position: -200% 0;
    }

    100% {
      background-position: -200% 0;
    }
  }



</style>



<?php

function generate_subscription_box($subscription_id, $term_id = null, $featured = false)
{

    global $current_user_id;
    // Fetch subscription details
    $subscription_type = get_field('subscription_type', $subscription_id);
    $subscription_commitment = get_field('subscription_commitment', $subscription_id);
    $subscription_billed_period = get_field('subscription_billed_period', $subscription_id);
    $subscription_price = get_field('subscription_price', $subscription_id);
    $subscription_saving_amount = get_field('subscription_saving_amount', $subscription_id);
    $title = get_the_title($subscription_id);

    // Determine if the plan should be marked as featured
    $featured_class = $featured ? 'featured' : '';
    $spark_class = $featured ? 'spark' : '';

    // Placeholder for payment link generation function - ensure you define this elsewhere
    $paymentLink = generateCardcomLink($current_user_id, $subscription_id, $term_id);

    // Start HTML output
?>
    <div class="box stripes plan flex-column gap-s align-center <?php echo $featured_class; ?>">
        <div class="plan-title bottom-gap-s"><?php echo $title; ?></div>
        <div class="plan-features">
            <?php if (have_rows('subscription_features', $subscription_id)) : ?>
                <ul class="flex-column gap-s bottom-gap-m">
                    <?php while (have_rows('subscription_features', $subscription_id)) : the_row(); ?>
                        <li class="relative">
                            <h3 class="check"><?php the_sub_field('feature_title'); ?></h3><span class="tooltip-mark absolute" style="top:4px;left:0;" tooltip="<?= get_sub_field('feature_explain'); ?>">?</span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="plan-button" style="align-self: stretch;">
            <button lightbox-type="iframe" lightbox-content="<?php echo $paymentLink; ?>" class="button green full-width <?php echo $spark_class; ?>">קדם עכשיו</button>
        </div>
    </div>
<?php
}


?>
