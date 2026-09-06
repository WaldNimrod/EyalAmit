# MANDATE — team_100 subagent · W2 QR (fill ROW / PATH / TITLE)

**מנהל:** team_100 · **בנאי:** Cursor Grok · **לא מאמת E2E. לא FTP.**
**מדיניות URL:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/team-100-preplanning/QR-URL-POLICY.md`
**אסור 301** מכתובת QR מודפסת.

שורה ראשונה: `RECOMMEND: VERIFY_DONE|COPY_DONE|ASK_NIMROD`

## זהות

```
שורה: {ROW}
עמוד: {TITLE}
נתיב מודפס: {PATH}
גל: W2
סוג: QR-העתקה
מקור: https://www.eyalamit.co.il{PATH} (האתר הישן/חי — SSoT לכתובת)
סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link{PATH}
```

## מה לעשות

1. HEAD+GET הישן והסטייג'ינג לאותו path. ילד QR חייב **200 בלי 301 החוצה**. `/qr/` שער: לתעד מה חי (בפרודקשן historically 302; בסטייג'ינג 200) — **אל תשבור ילדים**.
2. אם הסטייג'ינג 200 בכתובת המודפסת והגוף אינו כרטיס ריק — `VERIFY_DONE`. אין ניסוח. אין «שיפור».
3. אם הסטייג'ינג 404 / 301 לכתובת אחרת — `ASK_NIMROD`. אל תמציא slug.
4. אם הסטייג'ינג ריק והישן יש גוף — העתק מילה-במילה לערוץ QR הקיים בלבד (`ea-w2-07-qr-content-data.php` הוא GENERATED — אל תערוך ביד; אם חסר תוכן, אסקלציה). עדיף ASK_NIMROD על עריכת generated.
5. דוח: `_COMMUNICATION/team_100/S006/VERIFY-{ROW}-W2-2026-08-25.md`

## אסור

videoblk.php · block-faq-list.php · wp-admin · FTP · git · טופס סבב 1 · 23 עמודי סבב 1 · שינוי slug.
