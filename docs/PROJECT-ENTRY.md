# נקודת כניסה מרכזית — פרויקט EyalAmit.co.il 2026

מסמך זה הוא **האינדקס הקבוע** לפתיחת עבודה ב-Cursor או בצוות: יעדים, עקרונות, סביבה, ומסמכי מצב. לפרטים תפעוליים מלאים ראו [`docs/sop/SSOT.md`](sop/SSOT.md).

---

## 1. יעדים (רמת מוצר)

- אתר **WordPress** רזה, ממוקד המרה, **SEO** ו**נגישות** (ישראל, אתר פרטי קטן).
- **ללא** עגלה ותשלום פנימי — סליקה חיצונית (חשבונית ירוקה / מסלול מאושר).
- שימור **כל כתובות ה-QR המודפסות** — אין שבירת סריקה; מדיניות: [`docs/project/team-100-preplanning/QR-URL-POLICY.md`](project/team-100-preplanning/QR-URL-POLICY.md).
- מותגים מרובים תחת אותו דומיין; מרכז חווייתי: סטודיו / נשימה / דידג'רידו; **ספרים והוצאה** כמדור פעיל; **הופעות ומורשת מופע** בניווט משני (לא כ"ארכיון" ראשי לספרים).
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
| **מאגר WordPress (ישן — נפרד מריפו 2026)** | `../eyalamit.co.il-legacy/` מקומית; Git: `EYALAMIT1/eyalamit.co.il` — **לא** חלק מ־[WaldNimrod/EyalAmit](https://github.com/WaldNimrod/EyalAmit) |
| **תקשורת ודוחות צוותים** | [`_communication/`](../_communication/README.md) — כל צוות כותב רק לתיקיית `team_XX` שלו |
| **WordPress Agent Skills (Cursor)** | [`.cursor/skills/`](../.cursor/skills/README.md) — סקילים ממאגר WordPress הרשמי |

### 3.1 שורש workspace ב-Cursor (חשוב)

כללי **`.cursor/rules`** נטענים לפי **שורש ה-workspace**. **מומלץ** לפתוח ב-Cursor את התיקייה **`EyalAmit.co.il-2026`** כ־Open Folder. אם ה-workspace הוא רק תיקיית האב **`Eyal Amit`**, הכללים תחת `.cursor/rules/` **לא** יופעלו — פתחו את תת־התיקייה כפרויקט או קראו [`WORKSPACE-POINTER.md`](WORKSPACE-POINTER.md).

## 4. מצב שלב נוכחי (מתעדכן ב-SSOT)

**ביצוע — לפי מפת דרכים 2026 ([`ROADMAP-2026.md`](project/ROADMAP-2026.md) v12.1):** מתקדמים לפי אפיון פנימי CANONICAL ואבני דרך M1–M7; **מעטפת אתר (M2)** יכולה להתקדם על בסיס **SITEMAP DRAFT** מסונכרן — ראו מדיניות בראש הרודמאפ. **חתימת אייל** על תקציר (docx/PDF) ו־**מפת אתר `APPROVED`** נדרשים ל**מיגרציית תוכן מלאה** ול־**cutover** — ראו [`06-IMPLEMENTATION-MIGRATION-PACK.md`](project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md) §0 (מדורג). **מסירת האתר לאייל** = אבן דרך **M7**. תקציר מנהלים פנימי **v2.0** (מסונכרן טופס בחירות + CANONICAL): [`EYAL-EXECUTIVE-SUMMARY-FOR-APPROVAL.md`](project/team-100-preplanning/EYAL-EXECUTIVE-SUMMARY-FOR-APPROVAL.md).

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

## 6. מבנה צוותים ואונבורד

מודל ארגוני 2026 (מול SSOT ישן): [`docs/ORGANIZATION-TEAMS-2026.md`](ORGANIZATION-TEAMS-2026.md).

| צוות | אונבורד (קראו לפני משימה) |
|------|----------------------------|
| 100 | [`_communication/team_100/onboard_team100.md`](../_communication/team_100/onboard_team100.md) |
| 10 | [`_communication/team_10/onboard_team10.md`](../_communication/team_10/onboard_team10.md) |
| 20 | [`_communication/team_20/onboard_team20.md`](../_communication/team_20/onboard_team20.md) |
| 30 | [`_communication/team_30/onboard_team30.md`](../_communication/team_30/onboard_team30.md) |
| 50 | [`_communication/team_50/onboard_team50.md`](../_communication/team_50/onboard_team50.md) |
| 90 | [`_communication/team_90/onboard_team90.md`](../_communication/team_90/onboard_team90.md) |

## 7. קונטקסט ל-Cursor (קבצים שכדאי שיהיו טעונים)

- [`AGENTS.md`](../AGENTS.md) — הוראות לסוכני AI (מקוצר מול SSOT).
- [`.cursor/rules/eyalamit-2026-project-context.mdc`](../.cursor/rules/eyalamit-2026-project-context.mdc) — כלל שורש (תמיד פעיל).
- [`.cursor/rules/eyalamit-docs-spec.mdc`](../.cursor/rules/eyalamit-docs-spec.mdc) — כללים בעת עריכת `docs/`.
- [`.cursor/skills/README.md`](../.cursor/skills/README.md) — סקילי WordPress לסוכן.

## 8. מחקר מחוץ למאגר (עזר בלבד)

- `/Users/nimrod/Documents/Eyal Amit/CLIENT-DECISION-REPORT-EYALAMIT-2026-03-29.md`
- `/Users/nimrod/Documents/Eyal Amit/PRELIMINARY-PLANNING-EYALAMIT-2026-03-29.md`
