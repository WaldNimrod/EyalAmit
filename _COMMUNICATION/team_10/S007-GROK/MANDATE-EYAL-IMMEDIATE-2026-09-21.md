# מנדט צוות 10 — מיידי מאייל (בלי תפריט) · 2026-09-21

**מזמין:** מנהל מבצע.  
**מבצע:** צוות 10 — Composer.  
**מאמת:** מנוע אחר אחרי FTP (Iron Rule #1).  
**שער:** **STOP** אם חסר  
[`DEEP-AUDIT-ATTACK-2026-09-21.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/DEEP-AUDIT-ATTACK-2026-09-21.md).  
אין FTP במקביל לביקורת עומק.

צ'קפוינט: [CHECKPOINT-EYAL-IMMEDIATE-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/CHECKPOINT-EYAL-IMMEDIATE-2026-09-21.md)  
גלריה: [GALLERY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html)  
JSON: [WORKING-UNION-FROM-C.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/WORKING-UNION-FROM-C.json)

סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link (HTTP). תמה חיה **1.5.99**. bump ל־**1.5.100** ב־`style.css` אחרי קריאת Version. FTP `python3 scripts/ftp_deploy_site_wp_content.py`. בלי `git add -A`, בלי `local/`, בלי `_aos/`, בלי `--fs-*`.

**לפני קוד:** צילומי בסיס ל־`tmp/qa/eyal-immediate-baseline/` לפי הצ'קפוינט. אם הביקורת עדיין רצה — STOP.

**חרגת תפריט:** לא `ea-canonical-nav.php`, לא drawer, לא `section-nav.php`, לא `block-topnav.php`. T1/T2/T3/E2/E7 מחוץ למנדט.

אונבורד: קרא במלואו `_communication/team_10/onboard_team10.md` ואמור «אונבורד צוות 10 הושלם.»

---

## EI-A4 תודה

נוסח אייל כלשונו ב־`/thank-you/` (היום placeholder GP, אין מיפוי chapters):

```
תודה שפנית אליי 🙏
הפרטים התקבלו ואחזור אליך בהקדם.
```

לוודא שטופס `/contact/` מפנה ל־`/thank-you/`. לא להכניס לתפריט.

הצלחה: GET 200; שתי השורות ב־`<main>`; אין «placeholder».

## EI-B1 וידאו בית

ב־`section-home-03-video.php` + `home-defaults.php`: להחליף פלייסהולדר lorem ב־iframe

`https://www.youtube.com/embed/wDQoJauqsRM`

16:9, title נגיש. כותרת «וידאו» נשארת. נימרוד אישר embed פשוט (לא שער CMP על הסרטון).

הצלחה: אין «כאן ייכנס וידאו» / «ממתין לאישור» בפרק 03; iframe עם אותו id.

## EI-D1 המלצות כלים

ב־`didgeridoos-defaults.php` להסיר את `part => testimonials` ואת ה־CTA «לכל העדויות וההמלצות» מיד אחריו. לא לגעת בהמלצות דף הבית (D2 = 15, אין פעולה).

הצלחה: `/didgeridoos/` בלי קרוסלה ובלי הכפתור הזה.

## EI-D3 FAQ

`inc/data/ea-faq-seed.json` מפתח `general-12`: `/cbDidg-therapy-training` → `/learning/therapist-training/`. mu-plugin once (דפוס `ea-wave-b-faq-href-once.php`) דוחף ל־`ea_faq` החי. לא דומיין סטייג'ינג קשיח. C2 — בלי שינוי נוסח הכשרות.

הצלחה: קישור FAQ יחסי לעמוד ההכשרות, 200.

## EI-F3 אסתמה

`אסטמה` → `אסתמה` בברירות תמה חיות (`home-defaults.php`, `method-defaults.php`, `wave2-stage-b.php` אם חיה). לא `ea-testimonials-fb.json` (ציטוט לקוח). לא `asthma`. לא ארכיון `_COMMUNICATION`. mu-plugins once שכבר רצו — לא חובה אלא אם התוכן החי עדיין משם.

הצלחה: grep תמה חיה בלי `אסטמה` בברירות; `/` ו־`/method/` מציגים אסתמה.

## EI-L1–L3 משפטי

להסיר `part => pending-note` מ־`accessibility-defaults.php`, `privacy-defaults.php`, `terms-defaults.php`. בגוף, «טיוטה זו» / תאריך טיוטה → נוסח מאושר 2026-09-21 בלי שכתוב משפטי. **לא** באנר Draft של `/en/`. מדידה נשארת (CMP).

הצלחה: שלושת העמודים בלי «ממתין לאישור» / WP-EI-05.

## EI-T18 מחיקות

P016 `/סיפורים-מהנייר-עם-אייל-עמית/` — trash + 301 ל־`/blog/`.  
P045 `/41-הטור-של-אייל-עמית-חארטה-בארטה/` — כנ״ל.  
לא QR. GET בלי follow חייב 301 (או 410), לא 200 תוכן.

## EI-T19 חריגי בלוג

מדיה **מהאתר המקורי בלבד**. בלי המצאת טקסט.

- P002 `/מורה-לדיגרידו-מודה-למוריו-תלמידיו-ומט/` — הירו + עדכון hrefs ישנים.
- P006 ריברסינג (slug ב־JSON) — הירו + hrefs.
- P008 `/נשים-מנגנות-בדיגרידו-אישה-מנגנת-בדיג/` — הירו + תמונות הנשים שאושרו במקור + מחיקת שורות שהן רק `.` (רווח במקום). לא למחוק את הפוסט.
- P048 `/34-הטור-של-אייל-עמית-הלב/` — הירו + קישור ל־`/books/kushi-blantis/` (לא slug עברי). אם כושי 404 — קישור ל־`/books/` ולרשום חריג ב־as-made. לא לבנות עמוד.

## אחרי FTP

כתוב as-made: `_COMMUNICATION/team_10/S007-GROK/EYAL-IMMEDIATE-ASMADE-2026-09-21.md` עם Version, קבצים, hashes, חריגים. הודעה קצרה בעברית. בלי לאמת את עצמך.
