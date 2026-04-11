# הגשות ותשובות — CEO אייל עמית

תיקייה ייעודית לכל מה ש**יוצא לאייל** ולכל מה ש**חוזר ממנו** (אישור, חתימה, הערות).  
מטרה: ארכיון אחד, ברור לחיפוש ולצוותים — בלי לערבב עם טיוטות מחקר או מקורות Markdown פנימיים.

## מבנה

**קאנון מלא:** [`EYAL-CORRESPONDENCE-CANON.md`](./EYAL-CORRESPONDENCE-CANON.md).

| תיקייה | תפקיד |
|--------|--------|
| [`from-eyal/`](./from-eyal/) | **נכנס** — תשובות מאייל (Word/PDF/סריקות). לוגו: [`from-eyal/LOGO-ASSETS-AND-FORMAT-SPEC.md`](./from-eyal/LOGO-ASSETS-AND-FORMAT-SPEC.md). |
| [`to-eyal/`](./to-eyal/) | **יוצא** — גלי הגשה: `YYYY-MM-DD--topic/` (Word, `md-sources/`, `assets` לגל). מוקאפי HTML משותפים: [`to-eyal/_shared-assets/`](./to-eyal/_shared-assets/). |
| [`archive/`](./archive/) | כל מה ש**לא עדכני** — ראו [`archive/README.md`](./archive/README.md). |
| [`for-eyal/`](./for-eyal/) | **Stub בלבד** — מפנה לקאנון; **אין** ליצור כאן חומר חדש. |
| [`INDEX.html`](./INDEX.html) | **אינדקס לאייל בדפדפן** — קישורים ל־Word / HTML / טקסט בלבד (**ללא** `.md`) |
| [`INDEX.md`](./INDEX.md) | סדר עבודה + קישורי Markdown לצוות |

**נעילות CEO** (לא לסמן מחדש טופס כ«פתוח»): [`MEETING-MINUTES-EYAL-2026-03-31.md`](../team-100-preplanning/MEETING-MINUTES-EYAL-2026-03-31.md) §13.

## שמות קבצים (מומלץ)

פורמט עקבי ל־Git ולמיון:

```text
YYYY-MM-DD--short-topic--vN.ext
```

דוגמאות:

- `2026-03-29--executive-summary-approval--v1.docx`
- `2026-04-01--sitemap-draft--v1.pdf`
- `2026-04-05--executive-summary--signed-scan.pdf` (ב־`from-eyal/`)

אם יש כמה קבצים לאותה הגשה: אותו קידומת תאריך + סיומת תיאורית (`--appendix-notes.pdf`).

## מקור אמת נוכחי (אחרי נעילת 2026-03-30)

לעבודה שוטפת — **לא** להסתמך על טבלאות טרום-נעילה כ"רשימת פתוחים":

- [`../team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md`](../team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md) — אפיון מחייב  
- [`../team-100-preplanning/SPEC-V1.2-DECISIONS-LOCK-2026-03-30.md`](../team-100-preplanning/SPEC-V1.2-DECISIONS-LOCK-2026-03-30.md) — יומן נעילה  
- [`FOR-EYAL-CHOICES-v1.2-2026-03-30.md`](./to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/FOR-EYAL-CHOICES-v1.2-2026-03-30.md) — ייצוא Word; **סעיפים 1–6, 8 נעולים**; **פתוח:** §7 דף בית בלבד  

מסמכים מסומנים **LEGACY** בתיקייה זו וב־[`../team-100-preplanning/LEGACY-DOCUMENTS-INDEX-2026-03-30.md`](../team-100-preplanning/LEGACY-DOCUMENTS-INDEX-2026-03-30.md).

## קשר לצוות 100

- **מקור עריכה פנימי (Markdown):** נשאר ב־[`team-100-preplanning/`](../team-100-preplanning/) (למשל `EYAL-EXECUTIVE-SUMMARY-FOR-APPROVAL.md`).
- **ייצור Word (חבילה מלאה):** [`scripts/build_eyal_ceo_deliverables.py`](../../../scripts/build_eyal_ceo_deliverables.py) — כותב **רק** ל־`to-eyal/YYYY-MM-DD--final-spec-package-for-eyal/` (שישה קבצי docx + README). משכפל תקציר ל־`team-100-preplanning/EYAL-EXECUTIVE-SUMMARY-FOR-EYAL.docx`.  
  פקודה: `python3 scripts/build_eyal_ceo_deliverables.py` מתוך **שורש מאגר זה** (`EyalAmit.co.il-2026`). מאגר האתר הישן (`eyalamit.co.il-legacy`) נשאר ל־WordPress / ארכיון בלבד.  
  **תקציר בלבד (תאימות לאחור):** [`scripts/build_eyal_approval_docx.py`](../../../scripts/build_eyal_approval_docx.py) או `python3 scripts/build_eyal_approval_docx.py --all`.
- **PDF מ-Word:** [`team-100-preplanning/README-PDF-FROM-WORD.txt`](../team-100-preplanning/README-PDF-FROM-WORD.txt).

## אינדקס (מלאו ידנית אחרי כל הגשה / תשובה)

| תאריך | כיוון | נושא | קובץ | הערות |
|--------|--------|------|------|--------|
| 2026-03-29 | to-eyal (ארכיון) | סבב הגשה ראשון — שלושת ה־docx | [`archive/to-eyal/2026-03-29-outbound/`](./archive/to-eyal/2026-03-29-outbound/) | הועבר מ־`to-eyal/` בשורש |
| 2026-03-29 | from-eyal | משוב אייל (הערות בגוף) על סבב 29.3 | [`from-eyal/2026-03-29--executive-summary--v1.docx`](./from-eyal/2026-03-29--executive-summary--v1.docx) וכו' | **העתקים המקוריים** — אם יש סבב חדש, הוסיפו קבצים מתוארכים |
| 2026-03-30 | פנימי (ארכיון) | **טבלת סינתזה — משוב (LEGACY)** | [`archive/md-legacy/EYAL-FEEDBACK-RESPONSE-TABLE-2026-03-30.md`](./archive/md-legacy/EYAL-FEEDBACK-RESPONSE-TABLE-2026-03-30.md) | קובעים נעילה + FINAL אם יש סתירה |
| 2026-03-30 | פנימי (ארכיון) | **שאלות פתוחות (LEGACY)** | [`archive/md-legacy/OPEN-QUESTIONS-PRE-SPEC-v1.2-2026-03-30.md`](./archive/md-legacy/OPEN-QUESTIONS-PRE-SPEC-v1.2-2026-03-30.md) | טבלאות א–ד = טרום-נעילה |
| 2026-03-30 | md-sources (מקור MD) | **טופס בחירות לאייל v1.2** | [`to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/FOR-EYAL-CHOICES-v1.2-2026-03-30.md`](./to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/FOR-EYAL-CHOICES-v1.2-2026-03-30.md) | ייצוא Word/PDF להגשה |
| 2026-03-30 | md-sources (מקור MD) | **חשבונית ירוקה — תקציר ובדיקות לאייל** | [`to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/FOR-EYAL-GREEN-INVOICE-ACTION-SHEET-2026-03-30.md`](./to-eyal/2026-03-30--final-spec-package-for-eyal/md-sources/FOR-EYAL-GREEN-INVOICE-ACTION-SHEET-2026-03-30.md) | ייצוא Word; חבילת final-spec |
| 2026-03-30 | to-eyal | **חבילת אפיון סופית (Word)** | [`to-eyal/2026-03-30--final-spec-package-for-eyal/`](./to-eyal/2026-03-30--final-spec-package-for-eyal/) | `build_eyal_ceo_deliverables.py` — README בתיקייה |

---

**סמכות:** תיקייה זו היא **ארכיון רשמי** של חומר שמול ה-CEO; אין להגיש לאייל קבצי `.md` — ראו `docs/sop/SSOT.md` גרסה 12.2+.

**נקודת כניסה לאייל:** [`INDEX.md`](./INDEX.md) — סדר מסודר לכל החומר העדכני (מוקאפים, מפה, מיפוי, חבילת Word).
