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

**סוכני AI ב-Cursor:** תקן מחייב — [`docs/sop/AGENT-WORKSPACE-STANDARD.md`](sop/AGENT-WORKSPACE-STANDARD.md) (סקילים, MCP דפדפן, הרחבות, זרימת עבודה). **ברירת מחדל לתפקיד סוכן במאגר:** צוות **100** — [`.cursor/rules/eyalamit-team-100-architect-role.mdc`](../.cursor/rules/eyalamit-team-100-architect-role.mdc) · [`_communication/team_100/onboard_team100.md`](../_communication/team_100/onboard_team100.md).

## 3. סביבה ומאגרים

| מה | נתיב / הערה |
|----|----------------|
| **מאגר זה (Cursor — ברירת מחדל לפרויקט 2026)** | שורש `EyalAmit.co.il-2026` |
| מסמכי פרויקט | `docs/project/` |
| SSOT מנהלי | `docs/sop/SSOT.md` |
| ייצוא Word ללקוח | `python3 scripts/build_eyal_ceo_deliverables.py` משורש המאגר; תלות: `pip install -r scripts/requirements-docx.txt` |
| ממשק תקשורת לאייל (Hub) | **`hub/`** (Standard v1.1): `python3 scripts/build_eyal_client_hub.py` · `ftp_publish_eyal_client_hub.py`; SSOT: `hub/ssot/` · נוהל: [`docs/CLIENT_HUB_STANDARD_v1.md`](CLIENT_HUB_STANDARD_v1.md) · נספח: [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](CLIENT_HUB_APPENDIX_EYAL.md) · זרימת עבודה: [`hub/EYAL-HUB-SSOT-WORKFLOW.md`](../hub/EYAL-HUB-SSOT-WORKFLOW.md) · כניסה: [`hub/README.md`](../hub/README.md) · טיוטת פלטפורמה (SUPERSEDED לעומת הנוהל הנעול): [`docs/project/client-hub-platform/CLIENT-HUB-PLATFORM-SPEC-DRAFT.md`](project/client-hub-platform/CLIENT-HUB-PLATFORM-SPEC-DRAFT.md) |
| סביבה מקומית (Docker) | [`local/README.md`](../local/README.md) — `.env` לא ב־Git; PHP מיושר ל־uPress לפי צוות 20 |
| פריסה קנונית (מה שעולה לשרת) | [`site/README.md`](../site/README.md) — לא מעלים `_communication/` או `docs/` |
| מדיניות מסלולים כפולים + uPress | [`docs/project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](project/WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md) |
| נטיב טכני — משימות DB / WP / סטייג'ינג | [`_communication/team_20/M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md`](../_communication/team_20/M2-TECHNICAL-INFRA-TRACK-NEXT-STEPS-2026-03-29.md) |
| M2 runbook סביבה (G1) | [`_communication/team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../_communication/team_20/M2-RUNBOOK-ENV-2026-03-31.md) |
| M2 מסירה 20→10 (G2) | [`_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md`](../_communication/team_10/M2-HANDOFF-FROM-20-2026-03-31.md) |
| M2 סיכום יישום G2 (10) | [`_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../_communication/team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md) |
| M2 G2 — בקשת QA לצוות 50 | [`_communication/team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md`](../_communication/team_50/M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md) |
| M2 — בקרת תשתית לפני תוכן (צוות 50) | [`_communication/team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md`](../_communication/team_50/M2-INFRA-READY-QA-REQUEST-TEAM50-2026-04-03.md) |
| M2 — תיקון QA + בדיקה חוזרת (צוות 100) | [`_communication/team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md`](../_communication/team_100/M2-QA-REMEDIATION-AND-RETEST-PLAN-2026-04-04.md) |
| M2 — מנדט ריטסט QA 50 (תשתית Q3 + G2 contact/מטמון) | [`_communication/team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md`](../_communication/team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md) |
| M2 — בקשת ריטסט QA 50 אחרי purge uPress | [`_communication/team_50/M2-QA-RETEST-REQUEST-TEAM50-2026-04-07.md`](../_communication/team_50/M2-QA-RETEST-REQUEST-TEAM50-2026-04-07.md) |
| M2 — משוב QA קנוני 50 (סטייג'ינג / TLS / G2) | [`_communication/team_50/M2-QA-CANONICAL-FEEDBACK-TEAM50-STAGING-TLS-G2-2026-04-02.md`](../_communication/team_50/M2-QA-CANONICAL-FEEDBACK-TEAM50-STAGING-TLS-G2-2026-04-02.md) |
| M2 — GO תשתית לקליטת תוכן (100) | [`_communication/team_100/M2-CONTENT-INTAKE-INFRASTRUCTURE-GO-TEAM100-2026-04-08.md`](../_communication/team_100/M2-CONTENT-INTAKE-INFRASTRUCTURE-GO-TEAM100-2026-04-08.md) |
| M2 — בקשת QA: מוכנות סטייג'ינג אחרי UPRESS v2 (`.env.upress`, FTPS, hub, REST) | [`_communication/team_50/M2-STAGING-V2-READINESS-QA-REQUEST-2026-04-09.md`](../_communication/team_50/M2-STAGING-V2-READINESS-QA-REQUEST-2026-04-09.md) |
| M2 — דף בית מוקאפ דשבורד (יישום 10) | [`_communication/team_10/M2-HOME-DASHBOARD-IMPLEMENTATION-STATUS-2026-04-08.md`](../_communication/team_10/M2-HOME-DASHBOARD-IMPLEMENTATION-STATUS-2026-04-08.md) |
| M2 — נגישות: WP Accessibility (הגדרות + QA 50) | [`_communication/team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md`](../_communication/team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md) · תכנון ת"י: [`docs/project/team-100-preplanning/LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md`](project/team-100-preplanning/LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md) |
| M2 G2 — השלמת סטייג'ינג P0 (צוות 10) | [`_communication/team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md`](../_communication/team_10/M2-G2-STAGING-P0-COMPLETION-2026-04-04.md) · דוח ביצוע: [`M2-G2-STAGING-P0-DONE-2026-04-04.md`](../_communication/team_10/M2-G2-STAGING-P0-DONE-2026-04-04.md) · **אימות 100:** [`_communication/team_100/M2-G2-P0-TEAM10-VERIFICATION-BY-100-2026-04-04.md`](../_communication/team_100/M2-G2-P0-TEAM10-VERIFICATION-BY-100-2026-04-04.md) |
| M2 — קליטת תוכן מאייל (צוות 10) | [`_communication/team_10/M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md`](../_communication/team_10/M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md) |
| M2 אימות G2 + המשך (20/100) | [`_communication/team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md`](../_communication/team_20/M2-G2-VERIFICATION-AND-NEXT-STEPS-2026-04-01.md) |
| M2 G2 — תיקון שער 20-A + GO ל־10 | [`_communication/team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md`](../_communication/team_100/M2-GATE-20A-AMENDMENT-AND-GO-TEAM10-2026-04-02.md) |
| M2 G2 — דוח השלמת תשתית 20→100 | [`_communication/team_20/M2-INFRA-COMPLETION-REPORT-TO-TEAM100-2026-04-01.md`](../_communication/team_20/M2-INFRA-COMPLETION-REPORT-TO-TEAM100-2026-04-01.md) |
| M2 G2 — אינדקס סדר מנדטים | [`_communication/team_100/M2-G2-MANDATE-SEQUENCE-INDEX-2026-04-02.md`](../_communication/team_100/M2-G2-MANDATE-SEQUENCE-INDEX-2026-04-02.md) |
| M2 G2 — מנדט צוות 20 | [`_communication/team_20/M2-MANDATE-G2-PREREQ-TEAM20-2026-04-02.md`](../_communication/team_20/M2-MANDATE-G2-PREREQ-TEAM20-2026-04-02.md) |
| M2 G2 — מנדט צוות 10 | [`_communication/team_10/M2-MANDATE-G2-TEAM10-2026-04-02.md`](../_communication/team_10/M2-MANDATE-G2-TEAM10-2026-04-02.md) |
| M2 — תוספי uPress (המלצות 100) | [`_communication/team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../_communication/team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) |
| uPress — נוהל ארגוני WordPress (קנון v2) | [`docs/project/UPRESS_WORDPRESS_STANDARD_v2.md`](project/UPRESS_WORDPRESS_STANDARD_v2.md) · משתני סביבה: [`docs/project/EYAL_ENV_VARS_REFERENCE.md`](project/EYAL_ENV_VARS_REFERENCE.md) (§2 → `.env.upress`) |
| uPress — נתונים לחיבור (Git/FTP), בדיקות פאנל | [`_communication/team_20/UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md`](../_communication/team_20/UPRESS-CONNECTION-DATA-CHECKLIST-2026-03-29.md) |
| uPress — סטייג'ינג, PHP, מדריך Git | [`_communication/team_20/UPRESS-STAGING-SITE-RECORD-2026-03-31.md`](../_communication/team_20/UPRESS-STAGING-SITE-RECORD-2026-03-31.md) |
| העברת FTP / WP בצורה מאובטחת | [`_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md`](../_communication/team_20/CREDENTIALS-HANDOFF-SECURE-2026-03-31.md) · שדות uPress: [`docs/project/EYAL_ENV_VARS_REFERENCE.md`](project/EYAL_ENV_VARS_REFERENCE.md) §2 |
| phpMyAdmin — נוהל עבודה (בלי "להציק") | [`_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md`](../_communication/team_20/DB-AND-PHPMYADMIN-WORKFLOW-2026-03-31.md) |
| **מאגר WordPress (ישן — נפרד מריפו 2026)** | `../eyalamit.co.il-legacy/` מקומית; Git: `EYALAMIT1/eyalamit.co.il` — **לא** חלק מ־[WaldNimrod/EyalAmit](https://github.com/WaldNimrod/EyalAmit) |
| **תקשורת ודוחות צוותים** | [`_communication/`](../_communication/README.md) — כל צוות כותב רק לתיקיית `team_XX` שלו · **פרומט הקמה לפי צוות:** [אונבורד ופרומט ראשון](../_communication/README.md#onboarding-prompts) |
| **WordPress Agent Skills (Cursor)** | [`.cursor/skills/`](../.cursor/skills/README.md) — סקילים ממאגר WordPress הרשמי + בלוקים/FSE |
| **תקן סביבת סוכן (מחייב)** | [`docs/sop/AGENT-WORKSPACE-STANDARD.md`](sop/AGENT-WORKSPACE-STANDARD.md) — הרחבות, MCP דפדפן, סקילים, זרימת עבודה |
| **הרחבות Cursor מומלצות** | [`.vscode/extensions.json`](../.vscode/extensions.json) (Intelephense, EditorConfig, PHP Debug, GitLens); **מול ~8 המלצות ב-Cursor:** [§3.4](sop/AGENT-WORKSPACE-STANDARD.md); **איך להתקין:** [§3.1–3.2](sop/AGENT-WORKSPACE-STANDARD.md) (⌘⇧P → `Extensions: Show Recommended Extensions`); דיבוג PHP: [`.vscode/launch.json`](../.vscode/launch.json) + Xdebug בסביבה |

### 3.1 שורש workspace ב-Cursor (חשוב)

כללי **`.cursor/rules`** נטענים לפי **שורש ה-workspace**. **מומלץ** לפתוח ב-Cursor את התיקייה **`EyalAmit.co.il-2026`** כ־Open Folder. אם ה-workspace הוא רק תיקיית האב **`Eyal Amit`**, הכללים תחת `.cursor/rules/` **לא** יופעלו — פתחו את תת־התיקייה כפרויקט או קראו [`WORKSPACE-POINTER.md`](WORKSPACE-POINTER.md).

## 4. מצב שלב נוכחי (מתעדכן ב-SSOT)

**ביצוע — לפי מפת דרכים 2026 ([`ROADMAP-2026.md`](project/ROADMAP-2026.md) v12.3):** מתקדמים לפי אפיון פנימי CANONICAL ואבני דרך M1–M7; **מעטפת אתר (M2)** יכולה להתקדם על בסיס **SITEMAP DRAFT** מסונכרן — ראו מדיניות בראש הרודמאפ. **חתימת אייל** על תקציר (docx/PDF) ו־**מפת אתר `APPROVED`** נדרשים ל**מיגרציית תוכן מלאה** ול־**cutover** — ראו [`06-IMPLEMENTATION-MIGRATION-PACK.md`](project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md) §0 (מדורג). **מסירת האתר לאייל** = אבן דרך **M7**. תקציר מנהלים פנימי **v2.0** (מסונכרן טופס בחירות + CANONICAL): [`EYAL-EXECUTIVE-SUMMARY-FOR-APPROVAL.md`](project/team-100-preplanning/EYAL-EXECUTIVE-SUMMARY-FOR-APPROVAL.md).

## 5. מסמכי ליבה — קישורים ישירים

| נושא | קובץ |
|------|------|
| אינדקס צוות 100 | [`docs/project/team-100-preplanning/README.md`](project/team-100-preplanning/README.md) |
| אפיון סופי (canonical לבנייה) | [`SITE-SPECIFICATION-FINAL-2026-03-30.md`](project/team-100-preplanning/SITE-SPECIFICATION-FINAL-2026-03-30.md) |
| מפת אתר v2.3 (**מאושרת**; שם קובץ DRAFT היסטורי) | [`SITEMAP-NEW-SITE-v2-DRAFT.md`](project/team-100-preplanning/SITEMAP-NEW-SITE-v2-DRAFT.md) |
| **איפה כל מסמכי אייל / מפה / אפיון / אישורים (אינדקס)** | [`EYAL-DOCS-FINDER-2026-04-04.md`](project/eyal-ceo-submissions-and-responses/EYAL-DOCS-FINDER-2026-04-04.md) |
| מסמך אייל (אפריל) — ניתוח מול v2.3 + M2 | [`M2-EYAL-SITEMAP-SEO-AEO-GEO-ALIGNMENT-2026-04-04.md`](../_communication/team_100/M2-EYAL-SITEMAP-SEO-AEO-GEO-ALIGNMENT-2026-04-04.md) |
| Keep / Merge / Drop | [`CONTENT-DECISIONS-KEEP-MERGE-DROP-v2.md`](project/team-100-preplanning/CONTENT-DECISIONS-KEEP-MERGE-DROP-v2.md) |
| תהליך ואפיון | [`07-PROCESS-PRINCIPLES-AND-SITE-SPECIFICATION.md`](project/team-100-preplanning/07-PROCESS-PRINCIPLES-AND-SITE-SPECIFICATION.md) |
| מיגרציה והשקה | [`06-IMPLEMENTATION-MIGRATION-PACK.md`](project/team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md) |
| **מה נדרש מאייל (תוכן) לפי שלב** | [`EYAL-CLIENT-OBLIGATIONS-BY-PHASE.md`](project/EYAL-CLIENT-OBLIGATIONS-BY-PHASE.md) |
| הגשות / תשובות אייל | [`INDEX.html`](project/eyal-ceo-submissions-and-responses/INDEX.html) (ללא `.md`) · [`INDEX.md`](project/eyal-ceo-submissions-and-responses/INDEX.md) · [`README.md`](project/eyal-ceo-submissions-and-responses/README.md) |
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
