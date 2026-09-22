---
id: TO-TEAM10-GO-BLOG-QR-2026-09-22
from: team_110
to: team_10
date: 2026-09-22
verb: GO
---

# GO — תבנית בלוג ואז QR

סבב פתוח עלה לחי **תמה 1.5.108**. אתם מממשים עכשיו. **אל תעלו** מהעץ הישן `align-sweep`.

## מי דוחף / ממזג (מה שכבר נעשה)

| פעולה | בעלות |
|---|---|
| FTP התמה 1.5.108 | צוות 110, מעץ open-round |
| מיזוג ל-`main` + push | צוות 110 (אחרי הקובץ הזה) |
| העץ `EyalAmit.co.il-2026-align-sweep` | לא בשימוש. להקים עץ חדש מ-`main` אחרי ה-push |

## לפני קוד

1. `git fetch origin` ואז worktree חדש מ-`origin/main` (או `main` אחרי שהמיזוג נדחף).  
   לא להעתיק מ-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep` — חסר שם הסבב הפתוח, ו-`_COMMUNICATION` שם הוא symlink.
2. לא לגעת ב-`inc/ea-canonical-nav.php` (L1 נעול).
3. לא לגעת ב-`/` (בית) מעבר למה שכבר חי.
4. permalink `/qr/qrN/` לא זז.

## המשימה

1. תבנית פוסט חדש לפי  
   [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md)  
   וסקיצה שאושרה  
   [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-NEW-POST-DUMMY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-NEW-POST-DUMMY.html)
2. דמה JSON:  
   [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/post-template/DUMMY-WEEK-OF-BREATH.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/post-template/DUMMY-WEEK-OF-BREATH.json)
3. היסטורי as-is. לא ממירים ל-JSON.
4. אחר כך תבנית QR.  
   [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/PHASE-2-BLOG-QR-AFTER-SKETCH.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/PHASE-2-BLOG-QR-AFTER-SKETCH.md)
5. FTP רק מה-worktree החדש. bump מעל 1.5.108. אין FTP מהעץ הראשי.

קאנון יישור = דום נשימה (wrap 1200 / 82ch). אין `font-size` בקומפוננטה.

`STATUS.md`: `phase: implement` · `last` = GO בלוג+QR · `theme` = להתחיל מ-1.5.108.  
פינג: `TO-TEAM110-…`. לא UUID.
