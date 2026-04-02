# AGENTS — EyalAmit.co.il פרויקט 2026

מסמך לסוכני AI (Cursor) ולבני אדם. **נקודת כניסה מרכזית:** [`docs/PROJECT-ENTRY.md`](docs/PROJECT-ENTRY.md). **נוהל תפעול מלא:** [`docs/sop/SSOT.md`](docs/sop/SSOT.md).

## מאגר ונתיב

שורש עבודה מומלץ ב-Cursor: תיקיית **`EyalAmit.co.il-2026`** (כדי שכללי `.cursor/rules` ייטענו).  
קוד WordPress קיים נשאר במאגר נפרד: `../eyalamit.co.il-legacy/`.

## שלב נוכחי

תכנון — **צוות 100**, אפיון סופי / חבילת v2. אין מעבר מלא ל-Build והשקה עד **אישור אייל** (תקציר, מפת אתר, מדיניות QR).

**תפקיד ברירת־מחדל של סוכן AI במאגר זה:** **צוות 100** (אדריכלות) — [`.cursor/rules/eyalamit-team-100-architect-role.mdc`](.cursor/rules/eyalamit-team-100-architect-role.mdc) · אונבורד: [`_communication/team_100/onboard_team100.md`](_communication/team_100/onboard_team100.md). **צוות אחר (10 / 20 / 30 / 50 / 90):** לקרוא **במלואו** את קובץ `onboard_teamXX.md` מהטבלה ב־[`_communication/README.md#onboarding-prompts`](_communication/README.md#onboarding-prompts), או שהמשתמש מגדיר במפורש בתחילת הסשן / מדביק את תוכן האונבורד.

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
| M2 runbook סביבה (צוות 20 / G1) · צ׳ק־ליסט פאנל+WP §13 | [`_communication/team_20/M2-RUNBOOK-ENV-2026-03-31.md`](_communication/team_20/M2-RUNBOOK-ENV-2026-03-31.md) |
| M2 מסירה לצוות 10 (G1→G2) | [`_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md) |
| M2 סיכום יישום G2 (צוות 10) | [`_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) |
| M2 G2 — בקשת QA (צוות 50) | [`_communication/team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md`](_communication/team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md) |
| M2 — בקרת תשתית + דוח 50 | [`_communication/team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md`](_communication/team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md) · [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](_communication/team_50/M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md) |
| M2 — תיקון QA + בדיקה חוזרת (100) | [`_communication/team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md`](_communication/team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md) |
| M2 G2 — השלמת סטייג'ינג P0 (10) | [`_communication/team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md`](_communication/team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md) · [`M2-G2-STAGING-P0-DONE-2026-04-04.md`](_communication/team_10/M2-G2-STAGING-P0-DONE-2026-04-04.md) · אימות 100: [`M2-G2-P0-TEAM10-VERIFICATION-BY-100-2026-04-04.md`](_communication/team_100/M2-G2-P0-TEAM10-VERIFICATION-BY-100-2026-04-04.md) |
| M2 — קליטת תוכן מאייל (10) | [`_communication/team_10/M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md`](_communication/team_10/M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md) |
| M2 G2 — אימות ארטיפקטי מאגר | [`scripts/verify_m2_g2_repo_artifacts.sh`](scripts/verify_m2_g2_repo_artifacts.sh) |
| M2 — אימות WP-CLI בתמונת Docker מקומית (Q3) | [`scripts/verify_local_wp_cli.sh`](scripts/verify_local_wp_cli.sh) |
| M2 אימות G2 + המשך (20/100) | [`_communication/team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](_communication/team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md) |
| M2 G2 — תיקון שער 20-A + GO לצוות 10 | [`_communication/team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md`](_communication/team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md) |
| M2 G2 — דוח השלמת תשתית 20→100 | [`_communication/team_20/M2-INFRA-COMPLETION-REPORT-TO-TEAM100-2026-04-01.md`](_communication/team_20/M2-INFRA-COMPLETION-REPORT-TO-TEAM100-2026-04-01.md) |
| M2 G2 — אינדקס סדר מנדטים (20→10) | [`_communication/team_100/M2-G2-MANDATE-SEQUENCE-INDEX-2026-04-02.md`](_communication/team_100/M2-G2-MANDATE-SEQUENCE-INDEX-2026-04-02.md) |
| M2 G2 — מנדט צוות 20 | [`_communication/team_20/M2-MANDATE-G2-PREREQ-TEAM20-2026-04-02.md`](_communication/team_20/M2-MANDATE-G2-PREREQ-TEAM20-2026-04-02.md) |
| M2 G2 — מנדט צוות 10 | [`_communication/team_10/M2-MANDATE-G2-TEAM10-2026-04-02.md`](_communication/team_10/M2-MANDATE-G2-TEAM10-2026-04-02.md) |
| M2 — תוספי uPress (בחינה 100) | [`_communication/team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](_communication/team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) |
| uPress — נתונים לחיבור, Git/FTP, צ'קליסט פאנל | [`_communication/team_20/UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md`](_communication/team_20/UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md) |
| uPress — סטייג'ינג URL, PHP, מדריך Git (לא לשכפל מונוריפו ל־/) | [`_communication/team_20/UPRESS-STAGING-SITE-RECORD-2026-03-31.md`](_communication/team_20/UPRESS-STAGING-SITE-RECORD-2026-03-31.md) |
| FTP / wp-admin — העברה מאובטחת (לא בצ'אט, לא ב-Git) | [`_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md`](_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md) · `local/staging.credentials.example.md` |
| phpMyAdmin / DB — נוהל עבודה | [`_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md`](_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md) |
| מפת צוותים (מספרים, תפקידים) | [`docs/ORGANIZATION-TEAMS-2026.md`](docs/ORGANIZATION-TEAMS-2026.md) · [`_communication/README.md`](_communication/README.md) |

## סביבת סוכן — תקן מחייב (Cursor)

כל סוכן AI בפרויקט חייב לעמוד ב-[**`docs/sop/AGENT-WORKSPACE-STANDARD.md`**](docs/sop/AGENT-WORKSPACE-STANDARD.md): שורש workspace, **התקנת הרחבות (§3.1–3.2 — איפה הקובץ וצעדים ב-Cursor)**, טבלת **Agent Skills**, שימוש ב-**MCP דפדפן** לאימות אתר, זרימת **מקומי ↔ סטייג'ינג**, והרצת סקריפטים דרך ה-shell כשאפשר. קונטקסט מאגרים: [`.cursor/rules/eyalamit-2026-project-context.mdc`](.cursor/rules/eyalamit-2026-project-context.mdc). כללי Cursor נוספים: [`.cursor/rules/eyalamit-agent-workspace-mandatory.mdc`](.cursor/rules/eyalamit-agent-workspace-mandatory.mdc).

## Cursor — שורש workspace

כללי `.cursor/rules` נטענים כששורש ה-workspace הוא **`EyalAmit.co.il-2026`**. אם פתוח רק תיקיית האב `Eyal Amit`, ראו [`docs/WORKSPACE-POINTER.md`](docs/WORKSPACE-POINTER.md).

## Git — רק מאגר 2026

Push של **פרויקט 2026** (אפיון, `_communication/`, סביבה תחת `local/`, וכו') — **רק** ל־[`WaldNimrod/EyalAmit`](https://github.com/WaldNimrod/EyalAmit). **לא** לערבב עם מחזור ה־Git של `eyalamit.co.il`.

## WordPress skills

סקילים לסוכן (כולל `wp-block-development`, `wp-block-themes`, `eyalamit-staging-ftp`): [`.cursor/skills/README.md`](.cursor/skills/README.md).

ענף Git במאגר הישן (יישום WP): ראו SSOT; לעדכן שם כשמשתנה.
