---
id: TO-TEAM10-GO-REPAIR-SKETCH-2026-09-23
from: team_110
to: team_10
date: 2026-09-23
verb: GO
---

# GO — סקיצת עמוד תיקון כלים

מאת: צוות 110. אל: צוות 10.  
ה-HOLD הקודם מבוטל **רק** למנדט הזה. שאר האתר נשאר אצל 110 על המיין.

בלוק לנימרוד, להדבקה בצ'אט החדש:

```
מאת: 110
אל: 10
קרא: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/TO-TEAM10-GO-REPAIR-SKETCH-2026-09-23.md
צ'קאאוט: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-repair-sketch
```

## זהות

אתה צוות 10 (יישום). קרא במלואו את  
[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_communication/team_10/onboard_team10.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_communication/team_10/onboard_team10.md)  
ואז את הקובץ הזה. אין החלטת מוצר מעבר למה שכתוב כאן. אין עריכת SSOT. אין QA חתום של צוות 50.

## פעולה ראשונה

1. New Agent הזה הוא הסשן. אין `Task resume`.
2. הקם worktree מ-HEAD של `main` בלי השינויים הלא-מקומטים של 110:

```
git fetch origin
git worktree add -b team10/repair-sketch-2026-09-23 /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-repair-sketch main
```

3. `move_agent_to_root` אל `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-repair-sketch` לפני כל כתיבה. כל עריכה רק בתוך העץ הזה.
4. אל תיגע בצ'קאאוט `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`.

## המשימה

עמוד הדוגמה החי: `http://eyalamit-co-il-2026.s887.upress.link/repair/`  
מקור התוכן: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/repair-defaults.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/repair-defaults.php)

דיוק עיצוב ושילוב תמונות על העמוד הזה. הטקסט של אייל לא נכתב מחדש.

### תמונות

רק `status=need` ו-`assignedPage` בדיוק «תיקון וחידוש כלים» מתוך  
[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/ea-media-filter-2026-09-21T13-51-27-450Z.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/ea-media-filter-2026-09-21T13-51-27-450Z.json)

תשע, לאורך העמוד, חוץ מאחת:

- EA-000298.jpg
- EA-000238.jpeg
- EA-000239.jpeg
- EA-000214.jpeg
- EA-000268.jpeg
- EA-000220.jpeg
- EA-000237.jpeg
- EA-000242.jpeg
- EA-000161.jpg — ההערה «גלריה כללית בתחתית העמוד». רק היא בתחתית.

לא נכנסות, גם אם יש עליהן הערה: EA-000155.jpg, EA-000300.jpg, EA-000299.jpg, EA-000154.jpg (`status=no`).

הקבצים יושבים תחת `ea-eyal-hub/files/team40/ea-legacy-curated/media/` לפי שדה `src` בייצוא. מעתיקים לנכסי התמה בעץ שלך. לא ממציאים תמונה.

### פלטה — על העמוד הזה בלבד

מקור: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/EYAL-SITE-COLOR-PALETTE.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/EYAL-SITE-COLOR-PALETTE.md)

אייל: הבלוקים השחורים נראים כמו פוטר. להחליף אותם בחום מהפלטה.  
הפוטר `#0E0905` נשאר. לא משנים את `:root` ב-`chapters.css`. הצבע החדש חל רק על בלוקי הקריאה של `/repair/` (היום `.cta-band` עם `--dark-grad`).

מועמדים מהפלטה שננעלה: `#5C3A2E`, `#8A5A44`, `#A44E2B`, `#AB3A2B`.  
`#9A4F2B` הוא `--terra-dk` החי, לא צבע בפלטה, ולא מועמד.  
`#B5663D` עם טקסט לבן הוא 4.3:1. לא לטקסט רגיל.

בוחרים חום אחד, שמים אותו על הבלוקים של העמוד החי, ורושמים את ה-HEX ואת הניגוד. זה קאנון שימוש לעמוד הזה. הוא לא עולה לשאר האתר עד ש-110 מקבל אישור מנימרוד.

## איך זה עולה לחי

FTP מדורג של קבצי התיקון בלבד. לא `ftp_deploy_site_wp_content.py` על כל התמה.

מותר להעלות:

- `inc/chapters/defaults/repair-defaults.php`
- קובץ CSS חדש שנטען רק כשסוג הפרק הוא `repair`
- שורת טעינה אחת לקובץ הזה, בלי שינוי אחר באותו קובץ
- תמונות התיקון תחת `assets/images/`

אסור להעלות: `style.css`, `chapters.css`, `ea-atoms.css`, צור קשר, תפריט, בלוג, QR, עוגיות, מוקש.

אחרי ההעלאה: דפדפן על `http://eyalamit-co-il-2026.s887.upress.link/repair/` ב-390 וב-1440. גלילה עד הפוטר. הבלוק החום לא נראה כמו הפוטר. התשע נראות. אין גלילה אופקית.

## אסור

- `S007-WORK-SSOT.json` וכל HTML נגזר ממנו
- `inc/ea-canonical-nav.php`
- QR, בלוג, עוגיות, צור קשר, מוקש, גלריות של עמודים אחרים
- מיזוג ל-`main`, push, קומיט בלי בקשה מנימרוד
- `:root` גלובלי

## החזרה

דורסים את  
[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/STATUS.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/STATUS.md)

וכותבים  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/TO-TEAM110-DONE-REPAIR-SKETCH-2026-09-23.md`

חובה בדוח: כתובת חיה, רשימת קבצים שעלו, ה-HEX שנבחר ואיפה הוא חל, תשע התמונות ואיפה כל אחת, צילומי 390 ו-1440. זו סקיצה. היא לא קאנון לאתר עד שנימרוד מאשר ל-110.
