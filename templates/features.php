<style>
  #features .man-details {
    position:absolute;
    right: 450px;
    bottom:20px;
    width:500px;
  }
  #features {
    overflow:visible;
    padding-top: var(--gap-l);
  }
  #features .flex.mobile-flex-column-reverse.gap-l.align-center {
    padding-bottom:0;
  }
  #features .men-container.relative {
    margin-bottom:-6px;
    margin-top:-247px;
  }
  #features .circle.absolute.grow-shrink {
    top:220px;
    right:-70px;
    width:235px;
    height:235px;
    border-radius:50%;
    background:var(--green);
  }
  #features img {
    position:relative;
    z-index:5;
    width:400px;
  }
  #features left h2 {
    margin-top:-200px;
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
</style>
<section id="features">
  <inner class="flex mobile-flex-column-reverse gap-l align-center">
    <right class="flex"><div class="men-container relative"><div class="circle absolute grow-shrink"></div><img src="<?= theme_uri('/img/2men3.png'); ?>" alt="למה אצלנו?"><div class="man-details">
      <h5>נתנאל קטרי</h5>
      <h6>שמאי רכוש, שמאי חקלאות, סוקר תכולות, שמאי אמנות, עד מומחה, מאתר נזילות</h6>
    </div></div>
  </right>
    <left>
      <h2>למה אצלנו?</h2>
      <p class="bottom-gap-s">אצלנו תמצאו את כל בעלי המקצוע הטובים ביותר מסודרים בצורה נוחה וקלה לחיפוש בכל התחומים.</p>
      <grid class="grid-2 gap-s">
        <h3 class="check">רק בעלי מקצוע מוסכמים</h3>
        <h3 class="check">רק עם תעודה בתוקף</h3>
        <h3 class="check">סינון קל ונוח לפי תחומים</h3>
        <h3 class="check">פרטים מלאים כל כל בעל מקצוע</h3>
        <h3 class="check">יצירת קשר ישירה</h3>
        <h3 class="check">פרטים מעודכנים תמיד</h3>
      </grid>
    </left>
  </inner>
</section>
