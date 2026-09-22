---
id: TO-TEAM10-HOLD-FILE-LOCK-OPEN-ROUND-2026-09-22
from: team_110
to: team_10
date: 2026-09-22
verb: HOLD
---

# נעילת קבצים — סבב פתוח במקביל ליישור

לא לעצור את T-ALIGN-SWEEP. זה נעילת **קבצים**, לא HOLD על המשימה.

סשן 110 מיישם עכשיו בעץ  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-open-round`  
(`build/s007-open-round`). בסיס התמה הועתק ממצבכם הנוכחי (1.5.106 + הסרת `ea-wave2-blog-*` + DA-NAV-01). אין FTP מהסשן הזה עד מיזוג.

## אתם ממשיכים לגעת רק ב

- `assets/css/chapters.css`
- `assets/css/ea-blog.css`
- `assets/css/ea-atoms.css`
- `assets/css/w2-*.css`
- הסרת מחלקות `ea-wave2-*` מ-`main` בתבניות שטרם ניקיתם
- `ALIGN-SWEEP-*.md` ו-`STATUS.md`

## מעכשיו לא לגעת ב

כבר לקחנו את הבייטים הנוכחיים שלכם כבסיס. עריכה נוספת כאן = דריסה במיזוג.

- `template-parts/chapters/section-nav.php`
- `assets/css/ea-mobile-nav.css`
- `assets/css/ea-nav-drawer.css`
- `page-templates/tpl-chapters-en.php`
- `page-templates/tpl-content.php`
- `page-templates/tpl-chapters-home.php` + `section-home-*` + `section-07-how-to-start.php`
- `inc/chapters/defaults/home-defaults.php` + `acf-fields-home.php`
- `inc/wave2-stage-b.php`
- `assets/css/ea-open-round.css` (חדש אצלנו)
- `page-templates/tpl-chapters-blog-single.php` — אתם כבר הסרתם את המחלקה הכפולה; אל תערכו שוב. יש לנו שינוי וואטסאפ נפרד עליו.

`style.css` Version: אל תעלו מספר אחרי 1.5.106. המיזוג יעשה bump אחד.

## FTP

מותר FTP יישור **רק** מהעץ שלכם, ורק קבצים ברשימת «אתם ממשיכים». אחרי DONE של שני הסשנים: מיזוג ענפים ואז FTP תמה יחיד. לפני FTP הבא שלכם אחרי שהמיזוג קיים — למשוך את `build/s007-open-round` כדי לא להחזיר את הסבב הפתוח.

פינג: `TO-TEAM110-…`. לא UUID.
