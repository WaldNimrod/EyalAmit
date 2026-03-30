# נקודת כניסה מרכזית — פרויקט EyalAmit.co.il 2026

מסמך זה הוא **האינדקס הקבוע** לפתיחת עבודה ב-Cursor או בצוות: יעדים, עקרונות, סביבה, ומסמכי מצב. לפרטים תפעוליים מלאים ראו [`docs/sop/SSOT.md`](sop/SSOT.md).

---

## 1. יעדים (רמת מוצר)

- אתר **WordPress** רזה, ממוקד המרה, **SEO** ו**נגישות** (ישראל, אתר פרטי קטן).
- **ללא** עגלה ותשלום פנימי — סליקה חיצונית (חשבונית ירוקה / מסלול מאושר).
- שימור **כל כתובות ה-QR המודפסות** — אין שבירת סריקה; מדיניות: [`docs/project/team-100-preplanning/QR-URL-POLICY.md`](project/team-100-preplanning/QR-URL-POLICY.md).
- מותגים מרובים תחת אותו דומיין; מרכז חווייתי: סטודיו / נשימה / דידג'רידו; הוצאה ומופע כארכיון משני.
- **בלוג** כנכס SEO; אירועים עם בלוק "אירוע הבא"; עמוד נחיתה באנגלית בנוסף לעברית.

## 2. עקרונות עבודה (סוכני AI ואנשים)

1. **החלטות אייל** גוברות על הכל (במיוחד אחרי חתימה על מסמכי **docx/PDF**, לא על `.md`).
2. **מסמכי צוות 100** המסונכרנים עם אייל = מקור מחייב לתכנון.
3. **דוחות מחקר** בשורש תיקיית `Eyal Amit/` = עזר בלבד — ראו [`RESEARCH-SYNC-AND-SOURCE-OF-TRUTH-v2.md`](project/team-100-preplanning/RESEARCH-SYNC-AND-SOURCE-OF-TRUTH-v2.md).

**הגשה ל-CEO אייל:** רק **Word (.docx) או PDF**. **אסור** להעביר לאייל קבצי Markdown. Markdown = עבודה פנימית, Git, Cursor.

**קוד WordPress (כשעובדים על המאגר הישן):** קידומת `ea_`; שינויים ב־child theme / `mu-plugins` בלבד — פירוט ב־SSOT.

## 3. סביבה ומאגרים

| מה | נתיב / הערה |
|----|----------------|
| **מאגר זה (Cursor — ברירת מחדל לפרויקט 2026)** | שורש `EyalAmit.co.il-2026` |
| מסמכי פרויקט | `docs/project/` |
| SSOT מנהלי | `docs/sop/SSOT.md` |
| ייצוא Word ללקוח | `python3 scripts/build_eyal_ceo_deliverables.py` משורש המאגר; תלות: `pip install -r scripts/requirements-docx.txt` |
| סביבה מקומית (עתידי) | תיקייה `local/` — לא ל־commit סודות |
| **מאגר WordPress קיים** | `../eyalamit.co.il/` (GitHub: `EYALAMIT1/eyalamit.co.il`) |

## 4. מצב שלב נוכחי (מתעדכן ב-SSOT)

**תכנון — צוות 100, חבילת v2 / אפיון סופי 2026-03-30.** Build, מיגרציה והשקה **אחרי** אישור אייל (תקציר, מפת אתר, QR וכו').

## 5. מסמכי ליבה — קישורים ישירים

| נושא | קובץ |
|------|------|
| אינדקס צוות 100 | [`docs/project/team-100-preplanning/README.md`](project/team-100-preplanning/README.md) |
| אפיון סופי (canonical לבנייה) | [`SITE-SPECIFICATION-FINAL-2026-03-30.md`](project/team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md) |
| מפת אתר (טיוטה לאישור) | [`SITEMAP-NEW-SITE-v2-DRAFT.md`](project/team-100-preplanning/SITEMAP-NEW-SITE-v2-DRAFT.md) |
| Keep / Merge / Drop | [`CONTENT-DECISIONS-KEEP-MERGE-DROP-v2.md`](project/team-100-preplanning/CONTENT-DECISIONS-KEEP-MERGE-DROP-v2.md) |
| תהליך ואפיון | [`07-PROCESS-PRINCIPLES-AND-SITE-SPECIFICATION.md`](project/team-100-preplanning/07-PROCESS-PRINCIPLES-AND-SITE-SPECIFICATION.md) |
| מיגרציה והשקה | [`06-IMPLEMENTATION-MIGRATION-PACK.md`](project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md) |
| הגשות / תשובות אייל | [`docs/project/eyal-ceo-submissions-and-responses/README.md`](project/eyal-ceo-submissions-and-responses/README.md) |
| בלוג | [`BLOG-REVIVAL-PLAN.md`](project/BLOG-REVIVAL-PLAN.md) |

## 6. קונטקסט ל-Cursor (קבצים שכדאי שיהיו טעונים)

- [`AGENTS.md`](../AGENTS.md) — הוראות לסוכני AI (מקוצר מול SSOT).
- [`.cursor/rules/eyalamit-2026-project-context.mdc`](../.cursor/rules/eyalamit-2026-project-context.mdc) — כלל שורש (תמיד פעיל).
- [`.cursor/rules/eyalamit-docs-spec.mdc`](../.cursor/rules/eyalamit-docs-spec.mdc) — כללים בעת עריכת `docs/`.

## 7. מחקר מחוץ למאגר (עזר בלבד)

- `/Users/nimrod/Documents/Eyal Amit/CLIENT-DECISION-REPORT-EYALAMIT-2026-03-29.md`
- `/Users/nimrod/Documents/Eyal Amit/PRELIMINARY-PLANNING-EYALAMIT-2026-03-29.md`
