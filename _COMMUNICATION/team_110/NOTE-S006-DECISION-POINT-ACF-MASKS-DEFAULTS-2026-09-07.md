---
id: NOTE-S006-DECISION-POINT-ACF-MASKS-DEFAULTS-2026-09-07
schema_version: aos_v1_team_messaging
from_team: team_110
to_team: team_100
cc: [team_00]
date: 2026-09-07
type: decision-point (not a mandate · not to be opened)
milestone: S006
status: RECORDED — resolves itself at the next home-defaults deploy
---

# נקודת הכרעה · שכבת ACF עלולה להסתיר את ערוץ הכתיבה של אבן הדרך

**נרשם לבקשת team_100. זה לא מנדט ואין לפתוח אותו כמנדט.**

## הממצא (קוד — אומת, 2026-09-07)

`ea_chapters_field_or( $name, $default )` מחזיר את ערך ה-ACF כשאינו ריק, ורק אחרת את
ה-default מקובץ `*-defaults.php`. כלומר **ערך ב-DB גובר על ערוץ הכתיבה של S006.**

`chapters-render.php` מכיל רשימת עקיפה מפורשת בשני מסלולי ה-overlay —
שורה **602** (phero, `return` לפני כל קריאה ל-ACF) ושורה **644** (sections, `continue`
לפני אותו בלוק). ההערה בשורה 600–601 נוקבת ב-R1-10 מפורשות.

| | טיפוסים | משמעות |
|---|---|---|
| **מוגנים** — 18 | about · bags · didgeridoos · faq · kushi-blantis · lessons · method · mokesh · muzza · repair · **shop** · snoring-sleep-apnea · sound-healing · stand-floor · stands-storage · treatment · tsva-bekahol · vekatavta | defaults תמיד מנצחים. ACF לא נקרא כלל |
| **חשופים** — 15 | accessibility · contact · en · galleries · **home** · learning · lectures · media · privacy · qr · qr-hub · terms · therapist-training · treatment-eyal · workshops | ערך ACF לא-ריק גובר על ה-defaults |

## מה כבר הוכרע ואינו פתוח

- **`/shop/` (R1-10) — סגור.** ברשימת העקיפה. M-01 אומת חי אחרי הפריסה.
- **`contact` (M-02) — לא רלוונטי מבנית.** השינוי היה ב-`contact.php`, שהוא template part;
  שכבת ה-overlay חלה על ערכי תוכן מ-`*-defaults.php` ולא על מרקאפ בתבנית. נמדד חי:
  `ea-cf-topic` = 0.

## מה נשאר פתוח — `home` בלבד

לא ניתן להכריע בלי גישת DB (אין WP-CLI ב-uPress). team_100 ניסה שתי דרכים עקיפות ושתיהן
היו מזוהמות: מחרוזות ה-`alt` קיימות גם כ-fallback ב-`ea_chapters_content_img_alt()`,
ואין מחרוזת ייחודית ל-`home-defaults` שאינה קיימת גם בקורפוס ה-fb.

**ההכרעה: לא שורפים מנדט על זה. המבחן ייעשה מעצמו.**
כשתתווסף המלצה 16 ל-`home-defaults.php` (אחרי תשובת אייל על H-16) והפריסה תרוץ:

- **הופיעה חי** → ה-defaults מניעים את `home`. הנושא נסגר.
- **לא הופיעה** → ACF מסתיר. הפתרון הוא mu-plugin `-once` לפי הדפוס הקיים בריפו.

## גבול הבדיקה — במפורש

אומת **הקוד**: מי קורא ל-ACF ומי לא, ומי נמצא ברשימת העקיפה.
**לא** אומת אם קיימים בפועל ערכי ACF ב-DB של הסטייג'ינג לאיזה מ-15 החשופים.
כל טענה חזקה מזו אינה נתמכת בראיה.
