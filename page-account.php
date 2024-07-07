<?php get_header(); ?>

<?php
$current_user_id = get_current_user_id();
$args = array(
    'post_type' => 'pros',
    'author' => $current_user_id,
    'posts_per_page' => 1,
);
$query = new WP_Query($args);
if ($query->have_posts()) {
    $query->the_post();
    $pro_post_id = $query->post->ID;
?>

    <?php get_template_part('templates/me-hero', null, array('pro_post_id' => $pro_post_id, 'page_title' => 'פרטי מנוי')) ?>

    <section id="about">
        <inner style="padding-left: 30%; padding-top:var(--gap-m); padding-bottom:860px;">
            <div class="subscribe-status bottom-gap-m">מנוי נוכחי: <span style="color:var(--gray);">לא מפורסם</span></div>
            <div class="box border shadow-l">
                <h2>חבילת פרסום בסיסי</h2>
                <p class="bottom-gap-m">
                    רוצה להתחיל לקבל לקוחות רציניים? בחר חבילת פרסום עכשיו ותתחיל לעבוד!
                </p>
                <div class="subscription-features bottom-gap-l">
                    <style>
                        h4.check {
                            color: var(--blue);
                            font-weight: 700;
                            font-size: var(--font-s);
                            width: 300px;
                            position: relative;
                            padding-right: var(--gap-m);
                        }

                        h4.check::before {
                            content: url('data:image/svg+xml;charset=utf-8,%3Csvg%20width%3D%2218%22%20height%3D%2213%22%20viewBox%3D%220%200%2018%2013%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%0A%20%20%3Cpath%20d%3D%22M6.57216%2012.4615C6.2614%2012.4615%205.95124%2012.3449%205.71392%2012.1109L0%206.47876L1.71648%204.78623L6.57216%209.57245L16.2835%200L18%201.69253L7.4304%2012.1109C7.19308%2012.3449%206.88292%2012.4615%206.57216%2012.4615Z%22%20fill%3D%22%23473BF0%22%20%2F%3E%0A%3C%2Fsvg%3E');
                            position: absolute;
                            top: 0;
                            right: 0;
                        }
                    </style>
                    <div class="grid-2 gap-m">
                        <h4 class="check">דף עסק דיגיטלי מעוצב, עם כל המידע החשוב על העסק שלך ועליך.</h4>
                        <h4 class="check">נוכחות בולטת ברשת מטורפת לגולשים שמחפשים אותך.</h4>
                        <h4 class="check">ממשק לעדכון עצמאי של דף העסק הכולל ציונים על איכות הפרסום שלך + הצעות לשיפור ויעול.</h4>
                        <h4 class="check">סידרת טיפים למקסום הנוכחות שלך ברשת.</h4>
                        <h4 class="check">אפשרות לפרסם בדף העסק מוצרים, קופונים ומחירונים.</h4>
                        <h4 class="check">הצגת דירוגים וחוות דעת של לקוחות עם אפשרות מענה בדף העסק שלכם.</h4>
                        <h4 class="check">מעקב אחרי ביצועי העמוד שלכם</h4>
                        <h4 class="check">עדכון תוכן אישי הכולל מאמרים ותוכן מקצועי שיהפכו אותך לאוטוריטה בתחומך.</h4>
                    </div>
                </div>
                <style>
                    .payment-plans {
                        border:1px solid var(--light-gray);
                        border-radius: var(--radius-m);
                    }
                    .payment-plans .plan {
                        padding: var(--gap-s) var(--gap-m);
                        align-items: center;
                        gap:0;
                    }
                    .payment-plans .plan:not(:last-child){
                        border-bottom:1px solid var(--light-gray);
                    }
                
                    .payment-plans .plan-title {
                        font-size: var(--font-m);
                        font-weight: 700;
                    }
                    .payment-plans .plan-price, .payment-plans .plan-saving {
                        font-size: var(--font-m);
                        font-weight: 700;
                        color: var(--blue);
                        text-align: center;
                    }
                    .payment-plans .plan-saving {
                        font-size: var(--font-m);
                        font-weight: 500;
                        color: var(--green);
                    }
                    .payment-plans .plan-price::before, .payment-plans .plan-saving::before {
                        content:"₪";
                    }
                    .payment-plans .plan-button {
                        margin-right:auto;
                    }
                </style>
                <div class="payment-plans">
                        <div class="plan grid-4">
                        <div class="plan-title">מסלול חודשי</div>
                        <div class="plan-price">499</div>
                        <div class="plan-saving" style="color:var(--red);">0</div>
                        <div class="plan-button"><a class="button">הרשם עכשיו</a></div>
                        </div>
                        <div class="plan grid-4">
                        <div class="plan-title">מסלול חצי שנתי</div>
                        <div class="plan-price">399</div>
                        <div class="plan-saving">600</div>
                        <div class="plan-button"><a class="button">הרשם עכשיו</a></div>
                        </div>
                        <div class="plan grid-4">
                        <div class="plan-title">מסלול שנתי</div>
                        <div class="plan-price">249</div>
                        <div class="plan-saving">3108</div>
                        <div class="plan-button"><a class="button spark">הרשם עכשיו</a></div>
                        </div>
                </div>
            </div>

        </inner>
    </section>





<?php
} else {
    echo '<p>לא נמצא בעל מקצוע עבור המשתמש הנוכחי.</p>';
}
?>

<?php get_footer(); ?>
