<?php // Function to display post block
    function post_block($post_id)
    {
      $post = get_post($post_id);
      $categories = get_the_category($post_id);
      $category_list = array();

      foreach ($categories as $category) {
        $category_list[] = '<h6><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></h6>';
      }

      $category_terms = implode('/', $category_list);
    ?>
      <box class="box post-box radius-l flex-column no-padding float-up">
        <?php if (has_post_thumbnail($post_id)) : ?>
          <a class="post-thumbnail" href="<?= get_permalink($post_id); ?>" style="background-size:cover;background-image:url('<?= get_the_post_thumbnail_url($post_id, array(420, 9999)); ?>');height:220px;width:100%;display:block;">

          </a>
        <?php endif; ?>
        <div class="post-content" style="padding:var(--gap-m);text-align:right;">
          <div class="post-categories flex gap-xs light-green align-center" style="margin-top:-3px;margin-bottom:6px;">
            <?= $category_terms; ?>
          </div>
          <h3 class="post-title font-m">
            <a href="<?= get_permalink($post_id); ?>">
              <?= get_the_title($post_id); ?>
            </a>
          </h3>
        </div>
      </box>
    <?php
    }
    ?>
