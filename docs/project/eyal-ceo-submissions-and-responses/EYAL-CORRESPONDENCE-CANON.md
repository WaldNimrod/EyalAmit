# קאנון תכתובות מול אייל עמית — מבנה תיקיות + ממשק

**תאריך קאנון:** 2026-04-29  
**מיקום:** `docs/project/eyal-ceo-submissions-and-responses/`  
**ניווט אנושי:** [`INDEX.md`](./INDEX.md) · [`INDEX.html`](./INDEX.html) (ללא קישורי `.md`)

---

## ממשק פרוס (FTP) מול SSOT JSON

| שכבה | מיקום | תפקיד |
|------|--------|--------|
| **View (תצוגה משותפת)** | **[`hub/`](../../../hub/)** בשורש המאגר — נבנה ל־`hub/dist/` ומפורסם ב־FTP (`UPRESS_EYAL_HUB_PATH`; נוהל: [`UPRESS_WORDPRESS_STANDARD_v2.md`](../UPRESS_WORDPRESS_STANDARD_v2.md); סטנדרט Hub: [`../../CLIENT_HUB_STANDARD_v1.md`](../../CLIENT_HUB_STANDARD_v1.md)) | אינדקס, מפת דרכים, **משימות והחלטות** (`tasks.html`), ייצוא JSON. `pending.html` מפנה ל־`tasks.html`. |
| **SSOT למשוב/החלטות מובנות** | [`hub/ssot/`](../../../hub/ssot/) — `responses/*.json` אחרי קליטה | מקור אמת לתשובות מובנות; ראו [`../../../hub/EYAL-HUB-SSOT-WORKFLOW.md`](../../../hub/EYAL-HUB-SSOT-WORKFLOW.md) · נספח [`../../CLIENT_HUB_APPENDIX_EYAL.md`](../../CLIENT_HUB_APPENDIX_EYAL.md). |
| **קבצים ב־`files/`** | בתוך `hub/dist/` אחרי `build_eyal_client_hub.py --mirror-docs` | עותקי docx/txt/pdf מהממשק; מקור ניהולי ב־`to-eyal/` / `from-eyal/`. |

**סקריפטים:** `scripts/build_eyal_client_hub.py` · `scripts/ftp_publish_eyal_client_hub.py` · `scripts/ingest_eyal_feedback_json.py`

**סטייג'ינג (גלישה):** אין תעודת SSL ציבורית תקינה על sandbox — פתחו את ה־Hub ב־**`http://`**; בפרודקשן בלבד **HTTPS** עם תעודה. פירוט: [`CLIENT_HUB_APPENDIX_EYAL.md`](../../CLIENT_HUB_APPENDIX_EYAL.md).

---

## שני שורשים בלבד

| שורש | כיוון | תוכן |
|------|--------|------|
| **`from-eyal/`** | נכנס ממנו | Word / PDF / סריקות מהלקוח. שמות מומלץ: `YYYY-MM-DD--topic-slug--from-eyal.ext` — ראו [`from-eyal/README.md`](./from-eyal/README.md). |
| **`to-eyal/`** | יוצא אליו | **כל** מה שמיועד לאייל או נלווה לגל הגשה: רק תיקיות `YYYY-MM-DD--topic-kebab-case/` (תאריך = תאריך הגל — מסירה או נעילת חבילה). |

**אין תיקיית `for-eyal/` חדשה.** שם ישן הוחלף ב־stub [`for-eyal/README.md`](./for-eyal/README.md) שמפנה לכאן.

---

## מבנה פנימי של כל `to-eyal/YYYY-MM-DD--topic/`

| פריט | תפקיד |
|------|--------|
| **`README.txt`** | מה נשלח לאייל (מייל/Drive) לעומת מה פנימי לצוות. |
| **`deliverables/`** | אופציונלי: Word/PDF להגשה (אם לא בשורש התיקייה). |
| **`md-sources/`** | אופציונלי: Markdown לייצוא Word — צוות בלבד. |
| **`assets/`** | אופציונלי: נכסים ששייכים **לאותו גל** בלבד. |

קבצים: `YYYY-MM-DD--topic--vN.ext` כפי שב־[`README.md`](./README.md) השורשי.

---

## `_shared-assets/` (חוצה גלים)

תחת `to-eyal/_shared-assets/` נשמרים **מוקאפי HTML** ונכסים שמשרתים כמה גלי הגשה (דף בית, EN, KMD וכו') — לא תחת גל תאריכי יחיד. ראו [`to-eyal/_shared-assets/README.txt`](./to-eyal/_shared-assets/README.txt).

---

## איפה נשארים מסמכי צוות 100

**לא** בתיקיית `to-eyal/`: אפיון, מפת אתר Markdown, פרוטוקולים — ב־[`../team-100-preplanning/`](../team-100-preplanning/).  
**כן** ב־`to-eyal/`: ייצוא Word, מקורות MD שמזינים ייצוא לאייל, ותיקיות גל מתוארכות.

---

## סקריפטים

| סקריפט | פלט טיפוסי |
|--------|------------|
| `scripts/build_eyal_ceo_deliverables.py` | `to-eyal/{date}--final-spec-package-for-eyal/` |
| `scripts/build_eyal_deploy_dual_track_docx.py` | `to-eyal/{date}--infrastructure-policy-for-eyal/` |
| `scripts/build_eyal_meeting_brief_docx.py` | `to-eyal/{date}--meeting-brief/` |
| `scripts/build_eyal_aeo_geo_client_report_docx.py` | `to-eyal/{date}--aeo-geo-client-report/` |
| `scripts/build_eyal_sitemap_seo_alignment_feedback_docx.py` | `to-eyal/{date}--sitemap-seo-aeo-geo-feedback/` |

---

## ארכיון

[`archive/`](./archive/) — LEGACY, כפילויות, stubs; לא SSOT נוכחי. ראו [`archive/README.md`](./archive/README.md).
