<?php
// Get featured pros
$page_title = isset($args['page_title']) ? $args['page_title'] : '';
$pro_post_id = isset($args['pro_post_id']) ? $args['pro_post_id'] : '';
?>
<section id="hero" class="header-padding" style="height: 290px; background-image: url('<?= theme_uri('/img/hero_bg.jpg'); ?>'); background-position: top right; background-repeat: no-repeat; background-color: var(--soft-background); overflow: visible;">
    <inner class="relative flex justify-between">
        <div class="right" style="margin-top: 33px; width: 80%;">

            <h2 class="" style="font-size: var(--font-xxl); margin-top: -20px; margin-bottom:0px;">איזור אישי</h2>
            <h3 style="margin-top:-7px;margin-bottom:25px;color:var(--blue);"><?= $page_title; ?></h3>


        </div>
        <div class="left">
            <span style="position: absolute; top: 24px; left: -30px;"><?= svg_icon('dots'); ?></span>
            <div class="box border shadow-l" style="margin-top: 23px; width: 347px; background-color: white; padding: 20px; border-radius: 10px; display: flex; flex-direction: column; align-items: center;">
                <div class="profile-image-wrap relative" style="text-align: center;">
                    <?php
                    $featured_image = get_the_post_thumbnail_url($pro_post_id, 'full');
                    if (empty($featured_image)) {
                        $featured_image = get_avatar_url($current_user_id);
                    }
                    ?>
                    <img src="<?= $featured_image; ?>" alt="Profile Picture" style="width: 247px; height: 247px; border-radius: 50%; margin-bottom: 15px; object-fit: cover;">
                    <span class="absolute" style="bottom: 0; left: -10px"><?= svg_icon('circles'); ?></span>
                    <span class="absolute" style="bottom: 44px; right: 12px;"><?= svg_icon('twirl'); ?></span>


                </div>
                <div style="color: var(--gray); margin-bottom: 19px;"><a href="<?= get_permalink($pro_post_id); ?>" class="flex gap-s align-center" style="">

                        <?= get_the_title($pro_post_id); ?><?= svg_icon('link'); ?></a></div>
                <div id="me-links" class="flex-column gap-s" style="margin-bottom: 24px; text-align: center;">
                    <style>
                        #me-links a {
                            color: var(--blue);
                        }

                        #me-links a:active {
                            color: red;
                        }
                    </style>
                    <a href="<?= home_url('/me'); ?>">עריכת פרטים</a>
                    <a href="<?= home_url('/me-account'); ?>">פרטי מנוי</a>
                    <a href="<?= wp_logout_url(); ?>" style="color: var(--red);">התנתק</a>

                </div>
                <bottom class="radius-s" style="border: 1px solid var(--light-gray);width:100%; margin-bottom: var(--gap-m);">
                    <bottom-top class="flex" style="width:100%;border-bottom:1px solid var(--light-gray);">
                        <style>
                            data {
                                padding: var(--gap-xs) var(--gap-s);
                            }
                        </style>
                        <data style="border-left:1px solid var(--light-gray); flex:1;">
                            <h6 style="color:var(--black);">חשיפות</h6>
                            <h3 style="color:var(--green);">0</h3>
                        </data>
                        <data style="flex:1;">
                            <h6 style="color:var(--black);">קליקים</h6>
                            <h3 style="color:var(--green);">0</h3>
                        </data>
                    </bottom-top>
                    <bottom-bottom class="flex" style="width:100%;">
                        <data style="border-left:1px solid var(--light-gray); flex:1;">
                            <h6 style="color:var(--black);">שליחות טופס</h6>
                            <h3 style="color:var(--green);">0</h3>
                        </data>
                        <data style="flex:1;">
                            <h6 style="color:var(--black);">דירוג משוקלל</h6>
                            <h3 style="color:var(--blue);"><?= get_field('pro_total_rate', $pro_post_id); ?></h3>
                        </data>
                    </bottom-bottom>
                </bottom>
                <div lightbox-type="content" lightbox-content="#share-pop" class="button"><span style="vertical-align: -4px; margin-left:13px;"><?= svg_icon('share', null, null, 19, 19); ?></span>שתף את העמוד שלך</div>
            </div>
        </div>
    </inner>
</section>
<div id="share-pop" class="lightbox-overlay">
        <div class="lightbox-content" style="width:440px;">
            <h3 class="flex justify-center align-center gap-xs"><?= svg_icon('share', '#000', null, 19, 19); ?> שתפו את העמוד שלכם!</h3>
            <gap-m></gap-m>

            <style>
                #share-pop .sharing-links {
                    display: flex;
                    flex-direction: column;
                    gap: var(--gap-s);
                }

                #share-pop .sharing-links .button {
                    display: flex;
                    gap: var(--gap-s);
                    align-items: center;
                }
                
            </style>
     <div class="sharing-links">
    <div class="button" copy="<?= site_url('/add-review/?pro=' . $pro_post_id); ?>">
        <?= svg_icon('profile', null, null, 19, 19); ?> העתק לינק להוספת המלצה
    </div>
    <gap-s class="line"></gap-s>
    <div class="button green" copy="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink($pro_post_id); ?>">
        <?= svg_icon('facebook', null, null, 19, 19); ?> העתק לינק לשיתוף בפייסבוק
    </div>
    <div class="button green" copy="https://twitter.com/intent/tweet?text=<?= urlencode('בדקו את המקצוען הזה: ' . get_the_title($pro_post_id)); ?>%20<?= get_permalink($pro_post_id); ?>">
        <?= svg_icon('twitter', null, null, 19, 19); ?> העתק לינק לשיתוף בטוויטר
    </div>
    <div class="button green" copy="https://www.linkedin.com/shareArticle?mini=true&url=<?= get_permalink($pro_post_id); ?>&title=<?= urlencode(get_the_title($pro_post_id)); ?>&summary=<?= urlencode('בדקו את המקצוען הזה'); ?>&source=YourWebsite">
        <?= svg_icon('linkedin', null, null, 19, 19); ?> העתק לינק לשיתוף בלינקדאין
    </div>
    <div class="button green" copy="https://api.whatsapp.com/send?text=<?= urlencode('בדקו את המקצוען הזה: ' . get_the_title($pro_post_id)); ?>%20<?= get_permalink($pro_post_id); ?>">
        <?= svg_icon('whatsapp', null, null, 19, 19); ?> העתק לינק לשיתוף בוואטסאפ
    </div>
    <div class="button green" copy="https://t.me/share/url?url=<?= get_permalink($pro_post_id); ?>&text=<?= urlencode('בדקו את המקצוען הזה: ' . get_the_title($pro_post_id)); ?>">
        <?= svg_icon('telegram', null, null, 19, 19); ?> העתק לינק לשיתוף בטלגרם
    </div>
    <div class="button green" copy="mailto:?subject=<?= urlencode('בדקו את המקצוען הזה'); ?>&body=<?= urlencode('בדקו את המקצוען הזה: ' . get_the_title($pro_post_id)); ?>%20<?= get_permalink($pro_post_id); ?>">
        <?= svg_icon('email', null, null, 19, 19); ?> העתק לינק לשיתוף באימייל
    </div>
</div>


        </div></div>
