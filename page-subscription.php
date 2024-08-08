<?php get_header(); ?>
<?php get_template_part('templates/singular-hero') ?>
<?php global $current_user_id;
$current_user_id = get_current_user_id(); 


global $_wp_additional_image_sizes;



?>



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
                <div class="circle absolute grow-shrink"></div><img src="<?= theme_uri('/img/medium/2men3.png'); ?>" alt="למה אצלנו?">
            </div>
        </left>
    </inner>
    <div class="sauqre_ico absolute scroll-rotate" style="top: 230px;right: -126px; z-index:90;">
        <?= svg_icon('square'); ?>
    </div>
</section>


<section id="how-it-works" class="light">
    <inner>
        <h2>איך זה עובד?</h2>
        <div class="flow-list grid-3 gap-m">
            <div class="box flow-item float-up">
                <div class="step-number">1</div>
                <div class="step-description">
                    <h3 class="title">הצטרפות</h3>
                    <div class="description">בחר את חבילת המנוי המתאימה לך - כל החבילות במחיר השקה כרגע.</div>
                </div>
            </div>
            <div class="box flow-item float-up">
                <div class="step-number">2</div>
                <div class="step-description">
                    <h3 class="title">בניית פרופיל</h3>
                    <div class="description">צור פרופיל מקצועי ומושקע המציג את כל יתרונותיך שימשוך אליך עוד לקוחות.</div>
                </div>
            </div>
            <div class="box flow-item float-up">
                <div class="step-number">3</div>
                <div class="step-description">
                    <h3 class="title">בקרת איכות</h3>
                    <div class="description">עבור את תהליך בקרת האיכות שלנו.</div>
                </div>
            </div>
            <div class="box flow-item float-up">
                <div class="step-number">4</div>
                <div class="step-description">
                    <h3 class="title">חשיפה</h3>
                    <div class="description">קבל חשיפה לקהל יעד איכותי המחפש את שירותיך.</div>
                </div>
            </div>
            <div class="box flow-item float-up">
                <div class="step-number">5</div>
                <div class="step-description">
                    <h3 class="title">צמיחה</h3>
                    <div class="description">הגדל את מאגר הלקוחות שלך.</div>
                </div>
            </div>
        </div>
    </inner>
</section>



<section id="subscriptions" class="dark weird-background" style="border-bottom:1px solid white">
    <inner style="z-index:90;">

        <!-- Subscription options -->
        <h2 class="text-center">בחר את החבילה המתאימה לך - מחירי השקה!</h2>

        <div class="payment-plans grid-3 bottom-gap-l">
            <div class="dots_ico absolute" style="top: 330px;left: -26px;">
                <?= svg_icon('dots'); ?>
            </div>

            <div class="sauqre_ico absolute scroll-rotate" style="top: 230px;right: -126px;">
                <?= svg_icon('square'); ?>
            </div>

            <?php generate_subscription_box(931); ?>
            <?php generate_subscription_box(930); ?>
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




<section id="you-get" class="dark relative stripes overflow-hidden">
    <inner style="z-index:10;">
        <h2>מה מקבלים המצטרפים ל-best-1?</h2>
        <div class="flow-list flow-list-icons grid-3 gap-m">
            <div class="box flow-item float-up">
                <div class="step-number" style="transform: scale(5);top: -116px;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="currentColor">
                            <path d="M23.444,10.239C21.905,8.062,17.708,3,12,3S2.1,8.062.555,10.24a3.058,3.058,0,0,0,0,3.52h0C2.1,15.938,6.292,21,12,21s9.905-5.062,11.445-7.24A3.058,3.058,0,0,0,23.444,10.239ZM12,17a5,5,0,1,1,5-5A5,5,0,0,1,12,17Z" fill="currentColor"></path>
                        </g>
                    </svg></div>
                <div class="step-description">
                    <h3 class="title">נראות מקסימלית</h3>
                    <div class="description">פרופיל מקצועי מקיף המציג את כל יתרונותיך</div>
                </div>
            </div>
            <div class="box flow-item float-up">
                <div class="step-number" style="transform: scale(3.2);top: -39px;"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g fill="currentColor"><path d="M23,39.668a3.24,3.24,0,0,0-3.464-.727,3.541,3.541,0,0,0-4.38-4.679,3.5,3.5,0,0,0-4.6-4.769,3.523,3.523,0,0,0-5.809-3.685l-.713.713A3.523,3.523,0,0,0,7.719,32.33,3.513,3.513,0,0,0,12.2,37.071a3.552,3.552,0,0,0,4.677,4.567A3.238,3.238,0,0,0,22.2,45.05L23,44.256A3.244,3.244,0,0,0,23,39.668Z" fill="currentColor"></path> <path d="M35.815,17.441A10.837,10.837,0,0,1,32.382,18a10.534,10.534,0,0,1-5.734-1.652L19.659,20.7a4.755,4.755,0,0,1-5.945-7.33l7.831-8.155c.19-.19.391-.364.592-.538A8.876,8.876,0,0,0,18.739,4H15.414L13.707,2.293a1,1,0,0,0-1.414,0l-11,11a1,1,0,0,0,0,1.414L3,16.414v3.461a8.359,8.359,0,0,0,1.079,3.907,5.505,5.505,0,0,1,8.573,3.424,5.5,5.5,0,0,1,4.864,5.03,5.546,5.546,0,0,1,4.206,4.582,5.236,5.236,0,0,1,2.765,8.759,4.078,4.078,0,0,0,3.982-1.083,4.155,4.155,0,0,0,1.207-2.774,3.4,3.4,0,0,0,5.2-4.081,4.16,4.16,0,0,0,5.41-5.113,4.172,4.172,0,0,0,3.49-7.1Z" fill="currentColor"></path> <path d="M46.707,13.293l-11-11a1,1,0,0,0-1.414,0L32.586,4H29.261a8.877,8.877,0,0,0-6.274,2.6l-7.831,8.157a2.756,2.756,0,0,0,.334,4.113h0A2.756,2.756,0,0,0,18.6,19l8.16-5.085A8.381,8.381,0,0,0,32.382,16a8.686,8.686,0,0,0,3.908-.912L45,23.825V16.414l1.707-1.707A1,1,0,0,0,46.707,13.293Z" fill="currentColor"></path></g></svg></div>
                <div class="step-description">
                    <h3 class="title">אמינות מוכחת</h3>
                    <div class="description">חלק מקהילת המקצוענים המובילה בישראל</div>
                </div>
            </div>
            <div class="box flow-item float-up">
                <div class="step-number" style="transform: scale(2.5);"><svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64"><g fill="currentColor"><path d="M39.551,40.165a1,1,0,0,0-.945-.084L32,42.912l-6.606-2.831a.992.992,0,0,0-.945.084A1,1,0,0,0,24,41v6a1,1,0,0,0,1,1,.982.982,0,0,0,.394-.081L32,45.088l6.606,2.831A.982.982,0,0,0,39,48a1,1,0,0,0,1-1V41A1,1,0,0,0,39.551,40.165Z" fill="currentColor"></path><circle cx="32" cy="51.5" r="1.5" fill="currentColor"></circle><circle cx="32" cy="58.5" r="1.5" fill="currentColor"></circle><path d="M45.707,48.707,43.414,51l2.293,2.293a1,1,0,0,1,0,1.414L37.414,63H60a1,1,0,0,0,1-1V54.033a9,9,0,0,0-6.527-8.653L42.1,41.845l3.734,5.6A1,1,0,0,1,45.707,48.707Z" fill="currentColor"></path><path d="M26.586,63l-8.293-8.293a1,1,0,0,1,0-1.414L20.586,51l-2.293-2.293a1,1,0,0,1-.125-1.262l3.707-5.56L9.527,45.38A9.039,9.039,0,0,0,3,54.034V62a1,1,0,0,0,1,1Z" fill="currentColor"></path><path d="M24,15H40a8.985,8.985,0,0,1,7,3.355V12a8.01,8.01,0,0,0-7.488-7.983L36.8.4A1,1,0,0,0,35.684.052L24.521,3.773A10.984,10.984,0,0,0,17,14.208v4.147A8.985,8.985,0,0,1,24,15Z" fill="currentColor"></path><path d="M40,17H24a7.012,7.012,0,0,0-6.859,5.6C18.165,32.917,25.184,39,32,39s13.836-6.083,14.859-16.4A7.012,7.012,0,0,0,40,17Z" fill="currentColor"></path></g></svg></div>
                <div class="step-description">
                    <h3 class="title">לקוחות איכותיים</h3>
                    <div class="description">חשיפה לקהל יעד ממוקד המחפש את שירותיך</div>
                </div>
            </div>
            <div class="box flow-item float-up">
                <div class="step-number" style="transform: scale(7.5);top: -162px;right: 34px;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><g fill="currentColor"><rect x="12.5" y="2" width="4" height="14" rx="1.75" ry="1.75" fill="currentColor"></rect><rect x="7" y="7" width="4" height="9" rx="1.75" ry="1.75" fill="currentColor"></rect><rect x="1.5" y="11" width="4" height="5" rx="1.75" ry="1.75" fill="currentColor"></rect><path d="M2.75,9.5c.192,0,.384-.073,.53-.22l4.72-4.72v.689c0,.414,.336,.75,.75,.75s.75-.336,.75-.75V2.75c0-.414-.336-.75-.75-.75h-2.5c-.414,0-.75,.336-.75,.75s.336,.75,.75,.75h.689L2.22,8.22c-.293,.293-.293,.768,0,1.061,.146,.146,.338,.22,.53,.22Z" fill="currentColor"></path></g></svg></div>
                <div class="step-description">
                    <h3 class="title">שיפור מתמיד</h3>
                    <div class="description">משוב ובקרה לשיפור השירות והמקצועיות שלך</div>
                </div>
            </div>
            <div class="box flow-item float-up">
                <div class="step-number" style="transform: scale(3.3);top: -33px;"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g fill="currentColor"><path d="M18.258,30a16.02,16.02,0,0,1,5.054-11.726,1,1,0,0,1,1.376,0A16.02,16.02,0,0,1,29.742,30a16.2,16.2,0,0,1-.651,4.518A24.966,24.966,0,0,0,24.667,2.487a1,1,0,0,0-1.334,0,24.966,24.966,0,0,0-4.424,32.031A16.2,16.2,0,0,1,18.258,30Z" fill="currentColor"></path><ellipse cx="24" cy="30" rx="3.742" ry="9.577" fill="currentColor"></ellipse><path d="M20.071,41.637A23.923,23.923,0,0,1,5.506,33.3a16.076,16.076,0,0,0-4.4,2.884,1,1,0,0,0-.125,1.33A16.027,16.027,0,0,0,12.33,43.932q.74.069,1.477.068a15.992,15.992,0,0,0,7.873-2.1Z" fill="currentColor"></path><path d="M13,21.116a26.832,26.832,0,0,1,.512-5.177A21.835,21.835,0,0,0,3.7,12.183a.993.993,0,0,0-1.1.762A21.888,21.888,0,0,0,20.4,39.664,27.031,27.031,0,0,1,13,21.116Z" fill="currentColor"></path><path d="M27.929,41.638A23.923,23.923,0,0,0,42.494,33.3a16.076,16.076,0,0,1,4.4,2.884,1,1,0,0,1,.125,1.33A16.027,16.027,0,0,1,35.67,43.933Q34.93,44,34.193,44a15.992,15.992,0,0,1-7.873-2.1Z" fill="currentColor"></path><path d="M35,21.116a26.832,26.832,0,0,0-.512-5.177A21.835,21.835,0,0,1,44.3,12.183a.993.993,0,0,1,1.1.762A21.888,21.888,0,0,1,27.6,39.664,27.031,27.031,0,0,0,35,21.116Z" fill="currentColor"></path></g></svg></div>
                <div class="step-description">
                    <h3 class="title">צמיחה עסקית</h3>
                    <div class="description">הזדמנות להרחיב את מעגל הלקוחות ולהגדיל הכנסות</div>
                </div>
            </div>
        </div>
    </inner>
    <img class="subscription_man absolute" style="bottom:0;left:5%;" src="<?= theme_uri('/img/small/man2.png'); ?>" alt="man">"

     <!-- Add sprinkle elements -->
     <?php for ($i = 0; $i < 180; $i++) :
        $size = rand(2, 8);
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
      opacity: <?= mt_rand(0, 3) / 10; ?>;
      filter:blur(<?= rand(0, 11) ?>px);
        top: <?= rand(0, 100); ?>%;
        left: <?= rand(0, 100); ?>%;
        width: <?= $size; ?>px;
        height: <?= $size; ?>px;
        background: <?= rand(0, 1) ? (rand(0, 1) ? 'var(--light-blue)' : 'white') : (rand(0, 1) ? 'var(--blue)' : 'var(--dark-blue)'); ?>;">
        </div>
    <?php endfor; ?>
    <div class="sauqre_ico absolute scroll-rotate" style="top: 230px;left: -126px; z-index:90;">
        <?= svg_icon('square'); ?>
    </div>
</section>

<section id="we-here" class="light no-bottom-padding">

  <inner class="flex tablet-flex-column gap-l">
    <right class="flex-column flex-1">
      <h2 style="font-size:var(--font-xxxl);line-height: var(--font-xxxl);" class="top-gap-l bottom-gap-m">מוכן להצטרף לאליטה המקצועית של ישראל?</h2>
      <p class="desc" style="max-width:80%;">אל תפספס את ההזדמנות להיות חלק מהפלטפורמה המובילה לבעלי מקצוע איכותיים. הצטרף עכשיו ל-best-1 וקח את העסק שלך לשלב הבא!</p>
      </div>
    </right>

    <left class="flex-1">
      <?php
      $accordionItems = [
        [
            'title' => 'איך נבחרים בעלי המקצוע לאתר?',
            'content' => 'אנו מבצעים תהליך בקרה קפדני הבוחן שירות, מקצועיות, מחיר וזמינות.'
        ],
        [
            'title' => 'האם יש התחייבות לתקופה מינימלית?',
            'content' => 'לא, תוכל לבחור את החבילה המתאימה לך, החל מ-3 חודשים.'
        ],
        [
            'title' => 'איך אני יכול למקסם את החשיפה שלי באתר?',
            'content' => 'על ידי עדכון שוטף של הפרופיל, קבלת ביקורות חיוביות וכתיבת תוכן איכותי.'
        ]
    ];

      echo accordion($accordionItems, 1);
      ?>

    </left>

  </inner>
</section>

<?php get_footer(); ?>

<style class="page-specific-styles">
    #hero h2 {
        font-weight: 600;
    }

    #hero h3 {
        font-weight: 300;
    }

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

    .flow-list-icons .step-number {
        right: -7px;
        top: -13px;
    }
    
    .flow-item .step-number svg {
        transition: transform 0.3s ease-in-out;
    }
    .flow-item:hover .step-number svg {
        transform: scale(1.2);
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

    li.false .check::before {
        background-image: <?= svg_icon('x', '#B8B8B8', null, null, null, true); ?>;
    }

    .plan-features li.false h3.check,
    .plan-features li.false .tooltip-mark,
    .plan-features li.false h3.check,
    .plan-features li.false svg {
        color: var(--gray);
        fill: var(--gray);
        opacity: 0.6;
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
        text-shadow: 0 0 45px #00000085;
        font-weight: 600;
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
    <div class="box stripes plan flex-column gap-s align-center float-up <?= $featured_class; ?>">
        <div class="plan-title top-gap-s">חבילת <?= $title; ?></div>
        <h6 class="text-center bottom-gap-s"><?= get_field('subscription_slogen', $subscription_id); ?></h6>
        <div class="plan-features">
            <?php if (have_rows('subscription_features', $subscription_id)) : ?>
                <ul class="flex-column gap-s bottom-gap-m">
                    <?php while (have_rows('subscription_features', $subscription_id)) : the_row(); ?>
                        <?php $true = get_sub_field('feature_true'); ?>
                        <li class="relative <?= $true ? '' : 'false'; ?>">
                            <h3 class="check"><?php the_sub_field('feature_title'); ?></h3><span class="tooltip-mark absolute" style="top:4px;left:0;" tooltip="<?= get_sub_field('feature_explain'); ?>">?</span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="plan-button" style="align-self: stretch;">
            <button lightbox-type="iframe" lightbox-content="<?= $paymentLink; ?>" class="button green full-width <?= $spark_class; ?>">קדם עכשיו</button>
        </div>
    </div>
<?php
}


?>
