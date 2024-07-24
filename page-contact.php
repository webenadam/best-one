<?php get_header(); ?>

<?php get_template_part('templates/singular-hero') ?>
<?php
$total_pros = wp_count_posts('pros')->publish;
?>
<section id="we-here" class="dark no-bottom-padding">
  <style>
    #we-here {
      color: var(--dark-white);
      font-size: var(--font-m);
      padding: var(--gap-l);
    }

    #we-here h3 {
      color: white;
    }

    #we-here h3 span {
      font-weight:400;
    }

    @media (max-width: 780px) {
      #we-here {
        padding: var(--gap-s);
      }

      #we-here h2,
      #we-here .desc {
        text-align: center;
        margin: auto;
      }
    }
  </style>
  <inner class="flex tablet-flex-column gap-l">
    <right class="flex-column flex-1">
      <h2 style="color:white;font-size:var(--font-xxxl);">אנחנו כאן בשבילכם.</h2>
      <p class="desc" style="width: 350px; max-width:80%;">צרו איתנו קשר בדרך שנוחה לכם.</p>
      <check class="flex gap-m bottom-gap-s">
        <div style="width: 30px;">
          <?= svg_icon('email'); ?>
        </div>

        <div>
          <h3>מייל: <span>site@best-1.co.il</span></h3>
        </div>
      </check>
      <check class="flex gap-m bottom-gap-s">
        <div style="width: 30px;">
          <?= svg_icon('whatsapp'); ?>
        </div>
        <div>
          <h3>וטסאפ: <span>053-777-7777</span></h3>
        </div>
      </check>
      </div>
    </right>

    <left class="flex-1">
    <form id="pro-contact-form" action="/submit" method="post" class="bottom-gap-xs">
                    <style>
                        #pro-contact-form {
                            width: 100%;
                            display: flex;
                            flex-direction: column;
                            gap: var(--gap-xs);
                            transition: all 0.4s ease-in-out;
                        }

                        #pro-contact-form input,
                        #pro-contact-form textarea {
                            text-align: right;
                            width: 100%;
                        }
                    </style>
                    <input type="text" name="fullName" placeholder="שם מלא" required>
                    <input type="tel" name="phone" placeholder="טלפון" required>
                    <input type="email" name="email" placeholder="מייל" required>
                    <textarea name="message" placeholder="הודעה" required></textarea>
                </form>
                <button id="pro_form_submit" class="button big" toggle-class="#pro-contact-form.active-1" style="width: 100%;">שלח</button>

    </left>

  </inner>
</section>


<?php get_template_part('templates/features');?>

<?php get_template_part('templates/advertise-now');?>

<script>
  jQuery(document).ready(function($) {
    // Function to sync the select inputs
    function syncSelectInputs(source, target) {
      var selectedValue = $(source).val();
      $(target).val(selectedValue);
    }

    // Event listener for changes on the #hero select input
    $('#hero .search-form select[name="experties"]').on('change', function() {
      syncSelectInputs(this, '#main-feed select.expert_select');
      $('#main-feed select.expert_select').trigger('change');
    });

    // Event listener for changes on the #main-feed select input
    $('#main-feed .expert_select').on('change', function() {
      syncSelectInputs(this, '#hero .search-form select[name="experties"]');
    });
  });
</script>

<?php get_footer(); ?>
