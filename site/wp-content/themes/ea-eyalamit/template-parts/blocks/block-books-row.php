<?php
/**
 * Block: books-row — D-14/POC Wave2.
 *
 * WP-W2-15-CR1 — carries the home source SECTIONS 08 (הסטודיו והמרחב) +
 * 09 (הצצה נוספת לחוויה) VERBATIM from docs/.../דף הבית/homepage1-3 v2.md.
 * Reuses the locked ea-content-section atoms only. No new token.
 */
defined( 'ABSPATH' ) || exit;
?>
<section class="ea-content-section ea-content-section--alt" data-block="books-row" aria-label="הסטודיו והמרחב">
      <div class="ea-content-section__inner">

        <!-- SECTION 08 — הסטודיו והמרחב -->
        <h2 class="ea-content-section__heading ea-entrance--breath">הסטודיו והמרחב</h2>
        <div class="ea-content-section__body">
          <p>הסטודיו שבו מתקיימת העבודה תוכנן מתוך הבנה עמוקה של סאונד ואקוסטיקה.</p>
          <p>החלל מאפשר עבודה מדויקת עם צליל ותדר, ותומך בתהליך גם בטיפול וגם בסאונד הילינג.</p>
          <p>הסטודיו ממוקם בלב חצר מטופחת, מוקפת ירוק, עצי פרי בוגרים, שבילי עץ, שדרת במבוקים וגינת ירק מלבלבת. תחושה של מרחב חי ונושם.</p>
          <p>רבים מדווחים כי כבר בכניסה למקום, משהו בקצב משתנה והלב נפתח, עוד לפני שהמפגש מתחיל.</p>
        </div>
        <div class="ea-block-cta-end">
          <a class="ea-cta-pill ea-cta-pill--ghost" href="<?php echo esc_url( home_url( '/sound-healing' ) ); ?>">למידע נוסף על סאונד הילינג</a>
        </div>

        <!-- SECTION 09 — הצצה נוספת לחוויה -->
        <h2 class="ea-content-section__heading ea-entrance--breath">הצצה נוספת לחוויה</h2>
        <div class="ea-content-section__body">
          <p>החוויה משלבת בין תרגול, הקשבה ונוכחות.</p>
          <p>זהו מרחב שמאפשר לעצור, להתבונן פנימה ולפתח קשר מודע יותר עם הנשימה.</p>
          <p>עבור רבים, זו הפעם הראשונה שהם פוגשים את הנשימה שלהם בצורה כזו.</p>
        </div>
        <div class="ea-block-cta-end">
          <a class="ea-cta-pill ea-cta-pill--ghost" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">לתיאום שיחת היכרות</a>
        </div>
      </div>
    </section>
