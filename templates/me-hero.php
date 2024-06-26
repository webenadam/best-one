<?php
// Get featured pros
$page_title = isset($args['page_title']) ? $args['page_title'] : '';
$pro_post_id = isset($args['pro_post_id']) ? $args['pro_post_id'] : '';
$pro_custom_background = get_field('pro_background_image', $pro_post_id);


if ($pro_custom_background) {
    $full_image_url = esc_url(wp_get_attachment_image_url($pro_custom_background, 'full'));
    $medium_image_url = esc_url(wp_get_attachment_image_url($pro_custom_background, 'medium_large'));
    $thumbnail_image_url = esc_url(wp_get_attachment_image_url($pro_custom_background, 'medium'));
    $default_position = 'center center';
    $default_size = 'cover';
    $tablet_size = 'auto 440px';
} else {
    $full_image_url = $medium_image_url = $thumbnail_image_url = theme_uri('/img/hero_bg.jpg');
    $default_position = 'top right';
    $default_size = 'auto';
    $tablet_size = $default_size;
}
?>


<style>
    #hero {
        background-image: <?= $pro_custom_background ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$full_image_url}')" : "url('{$full_image_url}')" ?>;
        background-position: <?= $default_position ?>;
        background-size: <?= $default_size ?>;
        background-repeat: no-repeat;
        background-color: var(--soft-background);
        overflow: visible;
        height: 290px;
        z-index: 5;
    }

    @media (max-width: 780px) {

        /* Tablet */
        #hero {
            height: unset;
            background-image: <?= $pro_custom_background ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$medium_image_url}')" : "url('{$medium_image_url}')" ?>;
            background-position: top center;
            background-size: <?= $tablet_size ?>;
        }

        #hero inner {
            padding-bottom: var(--gap-xl);
        }
    }

    @media (max-width: 550px) {

        /* Mobile */
        #hero {
            background-image: <?= $pro_custom_background ? "linear-gradient(to left, #F8F8F8, #f8f8f887), url('{$thumbnail_image_url}')" : "url('{$thumbnail_image_url}')" ?>;
        }
    }
</style>

<section id="hero" class="header-padding">
    <inner class="relative flex justify-between">
        <div class="right hide-tablet" style="margin-top: 33px; width: 80%;">

            <h2 class="" style="font-size: var(--font-xxl); margin-top: -20px; margin-bottom:0px;">איזור אישי</h2>
            <h3 style="margin-top:-7px;margin-bottom:25px;color:var(--blue);"><?= $page_title; ?></h3>


        </div>
        <style>
            @media (max-width: 780px) {
                #hero .left {
                    width: 100%;
                }
            }
        </style>
        <div class="left">
            <span class="hide-mobile" style="position: absolute; top: 24px; left: -30px;"><?= svg_icon('dots'); ?></span>
            <div class="box border shadow-l" style="margin-top: 23px; margin:auto; width: 347px; max-width:100%; background-color: white; padding: 20px; border-radius: 10px; display: flex; flex-direction: column; align-items: center;">
                <div class="profile-image-wrap relative" style="text-align: center;">
                <h2 class="hide-desktop" style="font-size: var(--font-xxl); margin-top: -20px; margin-bottom:0px;">איזור אישי</h2>
                <h3 class="hide-desktop" style="margin-top:-7px;margin-bottom:25px;color:var(--blue);"><?= $page_title; ?></h3>
                    <?php
                    $featured_image = get_the_post_thumbnail_url($pro_post_id, 'full');
                    if (empty($featured_image)) {
                        $featured_image = get_avatar_url($current_user_id);
                    }
                    ?>
                    <img src="<?= $featured_image; ?>" alt="Profile Picture" style="width: 247px; height: 247px; max-width: 40vw; max-height: 40vw; border-radius: 50%; margin-bottom: 15px; object-fit: cover;">
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
                    <a href="<?= get_permalink(350); ?>">עריכת פרטים</a>
                    <a href="<?= get_permalink(353); ?>">פרטי מנוי</a>
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
    <grid-2 class="share-links-grid gap-s">
    <a class="button green" target="_blank" href="https://api.whatsapp.com/send?text=<?= str_replace('+', '%20', urlencode('בדקו את המקצוען הזה: ' . get_the_title($pro_post_id))); ?>%20<?= get_permalink($pro_post_id); ?>">
        <?= svg_icon('whatsapp', null, null, 19, 19); ?> שתף בוואטסאפ
    </a>
    <a class="button green" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink($pro_post_id); ?>">
        <?= svg_icon('facebook', null, null, 19, 19); ?> שתף בפייסבוק
    </a>
    <a class="button green" target="_blank" href="https://twitter.com/intent/tweet?text=<?= str_replace('+', '%20', urlencode('בדקו את המקצוען הזה: ' . get_the_title($pro_post_id))); ?>%20<?= get_permalink($pro_post_id); ?>">
        <?= svg_icon('twitter', null, null, 19, 19); ?> שתף בטוויטר
    </a>
    <a class="button green" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?= get_permalink($pro_post_id); ?>&title=<?= urlencode(get_the_title($pro_post_id)); ?>&summary=<?= urlencode('בדקו את המקצוען הזה'); ?>&source=YourWebsite">
        <?= svg_icon('linkedin', null, null, 19, 19); ?> שתף בלינקדאין
    </a>
    <a class="button green" target="_blank" href="mailto:?subject=<?= str_replace('+', '%20', urlencode('בדקו את המקצוען הזה')); ?>&body=<?= str_replace('+', '%20', urlencode('בדקו את המקצוען הזה: ' . get_the_title($pro_post_id))); ?>%20<?= get_permalink($pro_post_id); ?>">
        <?= svg_icon('email', null, null, 19, 19); ?> שתף באימייל
    </a>
    </grid-2>
</div>



        </div></div>
