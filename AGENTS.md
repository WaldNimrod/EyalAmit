# AGENTS — EyalAmit.co.il פרויקט 2026

מסמך לסוכני AI (Cursor) ולבני אדם. **נקודת כניסה מרכזית:** [`docs/PROJECT-ENTRY.md`](docs/PROJECT-ENTRY.md). **נוהל תפעול מלא:** [`docs/sop/SSOT.md`](docs/sop/SSOT.md).

## מאגר ונתיב

שורש עבודה מומלץ ב-Cursor: תיקיית **`EyalAmit.co.il-2026`** (כדי שכללי `.cursor/rules` ייטענו).  
קוד WordPress קיים נשאר במאגר נפרד: `../eyalamit.co.il-legacy/`.

## שלב נוכחי

תכנון — **צוות 100**, אפיון סופי / חבילת v2. אין מעבר מלא ל-Build והשקה עד **אישור אייל** (תקציר, מפת אתר, מדיניות QR).

## הגשה ל-CEO אייל

**אסור** להגיש `.md`. כל מה שיוצא **מול אייל** — **Word (.docx) או PDF בלבד**.  
ארכיון מול אייל: `docs/project/eyal-ceo-submissions-and-responses/` — `to-eyal/…/final-spec-package-for-eyal/` (הגשה עדכנית), `from-eyal/` (חזר מאייל), `archive/` (ישן / כפול / LEGACY).  
**סקריפטים (`scripts/*.py`, `pip install`, `docker compose`, בדיקות):** הסוכן **מריץ בעצמו** בסביבה עם shell — **אין** להפנות את המשתמש להריץ פקודות כשאפשר להריץ כאן. ייצוא חבילת Word: `python3 scripts/build_eyal_ceo_deliverables.py` + תלות `scripts/requirements-docx.txt` — **לבצע מהצד של הסוכן**, לא להשאיר הוראה "תריץ אתה".

## יעדים בקצרה

WordPress רזה; SEO ונגישות; סליקה חיצונית; שימור QR; בלוג; מותגים מרובים תחת דומיין אחד — פירוט ומקורות אמת ב-[`docs/PROJECT-ENTRY.md`](docs/PROJECT-ENTRY.md).

## היררכיית מקורות אמת (בסתירה)

1. החלטות אייל  
2. מסמכי צוות 100 מסונכרנים  
3. דוחות מחקר בשורש `Eyal Amit/` — עזר בלבד  

→ [`docs/project/team-100-preplanning/RESEARCH-SYNC-AND-SOURCE-OF-TRUTH-v2.md`](docs/project/team-100-preplanning/RESEARCH-SYNC-AND-SOURCE-OF-TRUTH-v2.md)

## תקשורת בין-צוותים

דוחות ותוכניות צוות — **רק** תחת [`_communication/`](_communication/README.md). מודל ארגוני 2026: [`docs/ORGANIZATION-TEAMS-2026.md`](docs/ORGANIZATION-TEAMS-2026.md).  
אונבורד לפי צוות: `_communication/team_XX/onboard_teamXX.md`.

## אינדקס מסמכים

| נושא | נתיב |
|------|------|
| צוות 100 | `docs/project/team-100-preplanning/README.md` |
| אפיון סופי | `docs/project/team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md` |
| מפת אתר | `docs/project/team-100-preplanning/SITEMAP-NEW-SITE-v2-DRAFT.md` |
| מיגרציה | `docs/project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md` |
| נטיב טכני — צעדים ומשימות תשתית (DB, WP, סטייג'ינג) | [`_communication/team_20/M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md`](_communication/team_20/M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md) |
| M2 runbook סביבה (צוות 20 / G1) | [`_communication/team_20/M2-RUNBOOK-ENV-2026-03-31.md`](_communication/team_20/M2-RUNBOOK-ENV-2026-03-31.md) |
| M2 מסירה לצוות 10 (G1→G2) | [`_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md) |
| M2 סיכום יישום G2 (צוות 10) | [`_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) |
| M2 אימות G2 + המשך (20/100) | [`_communication/team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](_communication/team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md) |
| uPress — נתונים לחיבור, Git/FTP, צ'קליסט פאנל | [`_communication/team_20/UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md`](_communication/team_20/UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md) |
| uPress — סטייג'ינג URL, PHP, מדריך Git (לא לשכפל מונוריפו ל־/) | [`_communication/team_20/UPRESS-STAGING-SITE-RECORD-2026-03-31.md`](_communication/team_20/UPRESS-STAGING-SITE-RECORD-2026-03-31.md) |
| FTP / wp-admin — העברה מאובטחת (לא בצ'אט, לא ב-Git) | [`_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md`](_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md) · `local/staging.credentials.example.md` |
| phpMyAdmin / DB — נוהל עבודה | [`_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md`](_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md) |
| מפת צוותים (מספרים, תפקידים) | [`docs/ORGANIZATION-TEAMS-2026.md`](docs/ORGANIZATION-TEAMS-2026.md) · [`_communication/README.md`](_communication/README.md) |

## Cursor — שורש workspace

כללי `.cursor/rules` נטענים כששורש ה-workspace הוא **`EyalAmit.co.il-2026`**. אם פתוח רק תיקיית האב `Eyal Amit`, ראו [`docs/WORKSPACE-POINTER.md`](docs/WORKSPACE-POINTER.md).

## Git — רק מאגר 2026

Push של **פרויקט 2026** (אפיון, `_communication/`, סביבה תחת `local/`, וכו') — **רק** ל־[`WaldNimrod/EyalAmit`](https://github.com/WaldNimrod/EyalAmit). **לא** לערבב עם מחזור ה־Git של `eyalamit.co.il`.

## WordPress skills

סקילים לסוכן: [`.cursor/skills/README.md`](.cursor/skills/README.md).

ענף Git במאגר הישן (יישום WP): ראו SSOT; לעדכן שם כשמשתנה.
