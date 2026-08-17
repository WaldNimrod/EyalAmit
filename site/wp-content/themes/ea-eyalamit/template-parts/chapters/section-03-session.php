<?php
/**
 * Chapters — 07 SESSION («מה קורה במפגש טיפול בדיג'רידו»).
 *
 * S006 · H-10 · מקור: סקירה דף הבית.xlsx · C13.
 *
 * הסקשן היה ארבעה כרטיסי hover-reveal שכותרותיהם הומצאו («סביבה שקטה ונעימה»,
 * «תרגול מעשי», «הקשבה ונוכחות», «מפגש ראשון עם הנשימה» — אף אחת מהן אינה מופיעה
 * במסמכי אייל), ושניים מהם שכפלו את הטקסט של פרק 09. אייל הורה שהסקשן יציג את
 * שלוש הפסקאות שלו כטקסט רץ ואחריהן קישור ל-/treatment/.
 *
 * הרינדור מועבר ל-parts/prose.php — אותו חלק שמשרת כבר את פרקים 02 ו-09 — כדי
 * שהעמוד ישמור על שפה ויזואלית אחת. הרקע הכהה (sec--dark) נשמר. ה-CTA של אייל
 * יושב בתוך הגוף כפסקה אחרונה עם class="tlink" (כמו ב-'about_body'), כי prose
 * אינו מקבל CTA נפרד — וכך לא מומצא מבנה חדש.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$body = (string) ea_chapters_field( 'session_body' );
if ( '' === trim( $body ) ) {
	return;
}

get_template_part(
	'template-parts/chapters/parts/prose',
	null,
	array(
		'id'    => 'session',
		'chap'  => ea_chapters_field( 'session_chap' ),
		'title' => ea_chapters_field( 'session_title' ),
		'body'  => $body,
		'dark'  => true,
	)
);
