# קליטת תוכן ועץ אתר מאייל — תבנית עבודה (צוות **10**)

**תאריך:** 2026-04-03  
**עדכון GO תשתית:** 2026-04-08 — [`../team_100/M2-CONTENT-INTAKE-INFRASTRUCTURE-GO-TEAM100-2026-04-08.md`](../team_100/M2-CONTENT-INTAKE-INFRASTRUCTURE-GO-TEAM100-2026-04-08.md) (**מותר להתחיל קליטת תוכן**; הערת F2 מייל — לא חוסמת).  
**הקשר:** חומר סופי צפוי מאייל (תוכן + עץ אתר מעודכן) — יישום ב־WordPress ללא ערבוב עם מקור אמת ישן.  
**מקורות מצב נוכחי:** [`SITEMAP-NEW-SITE-v2-DRAFT.md`](../../docs/project/team-100-preplanning/SITEMAP-NEW-SITE-v2-DRAFT.md) (v2.3 APPROVED) · [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) §4–§5 · [`site/exports/m2-pages-seed.wxr`](../../site/exports/m2-pages-seed.wxr).

---

## 1. לפני הזנה ל־WP

1. לשמור **עותק** של החומר מאייל (docx/PDF/מייל) — **לא** ב־Git אם מכיל מידע פרטי; אינדקס שם קובץ + תאריך ב־`_communication/team_10/` או אצל מנהל הפרויקט.  
2. **השוואה:** לעבור על כל פריט בעץ החדש מול עמודות §4 (מזהה Pxx, slug, הורה).  
3. אם יש **שינוי slug / הורה / מחיקת עמוד** — לעדכן את טבלת §4 **במסמך זה** (סעיף 3) ואז להפיק WXR מחדש או לייצר עמודים ידנית — **לא** לשבור QR / P22 בלי אישור 100 (ראו runbook slugs).

---

## 2. טבלת מיפוי (להעתקה ומילוי כשמגיע החומר)

| סעיף בעץ מאייל | מזהה פנימי (Pxx) | slug יעד | הורה ב־WP | תבנית / הערות | פעולה (WXR / ידני / דחייה) |
|----------------|------------------|----------|-----------|----------------|-----------------------------|
| _דוגמה: דף בית_ | P01 | `home` | — | סטטי | |
| | | | | | |

---

## 3. ייצור מחדש של WXR (כשהמבנה משתנה)

```bash
cd EyalAmit.co.il-2026
python3 scripts/m2_emit_pages_wxr.py
```

לעדכן את [`site/README.md`](../../site/README.md) אם שם קובץ הייצוא או תהליך הייבוא משתנים.  
**ייבוא:** סטייג'ינג / מקומי — כלי → ייבוא; או WP-CLI מקומי (ראו [`local/README.md`](../../local/README.md)).

---

## 4. אחרי הזנה

1. **הגדרות → קריאה** — בית סטטי / בלוג (כמתועד בסיכום M2).  
2. **תפריטים** T1–T6 — לעדכן אם העץ השתנה.  
3. **Yoast** — P15 noindex וכו' לפי סיכום.  
4. לבקש **QA מצוות 50** — [`M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md`](../team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md) או בריף M2 G2 המעודכן.

---

## 5. שלב אנגלי (P19)

לוודא slug **`en`** או **`english`** עקבי עם [`site/wp-content/themes/ea-eyalamit/functions.php`](../../site/wp-content/themes/ea-eyalamit/functions.php) (`ea-lang-en`).
