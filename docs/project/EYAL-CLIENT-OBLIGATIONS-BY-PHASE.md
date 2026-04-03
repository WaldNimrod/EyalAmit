# מה נדרש מאייל עמית — לפי שלב (נטיב תוכן מול טכני)

**גרסה:** 1.0  
**תאריך:** 2026-03-29  
**קהל:** CEO / לקוח — וצוות פנימי המסביר מול אייל.

**הקשר:** מפת דרכים טכנית מפורטת ב־[`ROADMAP-2026.md`](ROADMAP-2026.md). מסמך זה משלים אותה ב־**מה צריך להגיע מאייל** ובאיזה **פורמט**, בלי לשכפל את כל אבני הדרך.

**כלל הגשה מול אייל:** רק **Word (.docx) או PDF** לחתימה / קריאה רשמית — ראו [`docs/sop/SSOT.md`](../sop/SSOT.md). מסמכי Markdown במאגר = פנימי. **ממשק Hub** (ייצוא JSON, הערות בעץ) = תוספת תפעולית; עדיין מומלץ לאחסן עותק docx/PDF ב־`from-eyal/` כשיש החלטה רשמית.

---

## טבלת חובות לפי אבן דרך

| שלב | מה נדרש מאייל | פורמט מומלץ | מסמכי עזר / נוהל |
|-----|----------------|-------------|-------------------|
| **מקביל ל־M2 (מעטפת אתר)** | אישור תפעולי על **עץ האתר** בממשק Hub (`site-tree.html`): הערות לכל עמוד, ייצוא JSON; אם אין שינוי — עדיין ייצוא לאישור «קראתי». | JSON מ־Hub + אופציונלי מייל/docx קצר | בניית Hub: [`hub/README.md`](../../hub/README.md) → `site-tree.html` · מקור קנוני IA: [`SITEMAP-NEW-SITE-v2-DRAFT.md`](team-100-preplanning/SITEMAP-NEW-SITE-v2-DRAFT.md) |
| **מקביל ל־M2** | **דף בית:** בחירה / משוב על **מוקאפים** (כיוונים ויזואליים) — עדיין פתוח לפי [`MEETING-MINUTES-EYAL-2026-03-31.md`](team-100-preplanning/MEETING-MINUTES-EYAL-2026-03-31.md). | קישור Hub למוקאפים + הערות או docx | [`HOME-PAGE-DIRECTIONS-v1.2.md`](team-100-preplanning/HOME-PAGE-DIRECTIONS-v1.2.md) |
| **מקביל ל־M2–M3** | **קליטת תוכן לעמוד:** לכל עמוד — טקסטים/מדיה דרך טופס Hub (`content-intake.html`) או docx; **קבצים גדולים** — העלאה ל־**Google Drive** (מסתנכרן ל־`from-eyal/`) ורישום **שם קובץ או קישור** בטופס בלבד. | JSON מ־Hub ו/או docx + קבצים ב־Drive | [`from-eyal/README.md`](eyal-ceo-submissions-and-responses/from-eyal/README.md) · [`CLIENT_HUB_APPENDIX_EYAL.md`](../CLIENT_HUB_APPENDIX_EYAL.md) |
| **לפני מיגרציית תוכן מלאה (M3)** | **תקציר מנהלים חתום** (גרסה מעודכנת לפי הצוות). | docx/PDF | [`06-IMPLEMENTATION-MIGRATION-PACK.md`](team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md) §0.2 · [`EYAL-EXECUTIVE-SUMMARY-FOR-APPROVAL.md`](team-100-preplanning/EYAL-EXECUTIVE-SUMMARY-FOR-APPROVAL.md) |
| **לפני מיגרציית תוכן מלאה** | **מילוי / אישור היקף SSOT** (או waiver מ־100): [`CONTENT-SSOT-INVENTORY.csv`](team-100-preplanning/CONTENT-SSOT-INVENTORY.csv) לפי [`02-CONTENT-SSOT-GUIDE.md`](team-100-preplanning/02-CONTENT-SSOT-GUIDE.md). | Excel/CSV או הערות בdocx | KMD: [`CONTENT-DECISIONS-KEEP-MERGE-DROP-v2.md`](team-100-preplanning/CONTENT-DECISIONS-KEEP-MERGE-DROP-v2.md) |
| **M3** | חומר סופי מסודר לפי מבנה העץ החדש — מיפוי ל־Pxx/slug (צוות 10 מזין ל־WP). | docx/PDF + טבלת מיפוי אם השתנה העץ | [`M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md`](../../_communication/team_10/M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md) |
| **לכל עמוד (שיטה מומלצת)** | עותק אחד של [`PAGE-SPECS-TEMPLATE.md`](team-100-preplanning/PAGE-SPECS-TEMPLATE.md) (או שורה בגיליון) — מטרה, CTA, מקור תוכן. | גיליון / docx | — |
| **לפני cutover (M7)** | אישור יעדי 301 / סופי מול [`03-SCOPE-MATRIX.md`](team-100-preplanning/03-SCOPE-MATRIX.md) (אם נדרש חידוש). | docx/PDF או חתימה על טבלה | [`06-IMPLEMENTATION-MIGRATION-PACK.md`](team-100-preplanning/06-IMPLEMENTATION-MIGRATION-PACK.md) §0.3 |

---

## ממשקים לאייל (Hub)

| עמוד | מטרה |
|------|------|
| `index.html` | כניסה, עדכונים, קישורים למוקאפים |
| `roadmap.html` | אבני דרך + תזכורת קצרה לחובות לקוח |
| `site-tree.html` | עץ ויזואלי, הערות, ייצוא `eyal-site-tree-feedback` |
| `content-intake.html` | בחירת עמוד, שדות לפי טיפוס תבנית, קישור ל־Drive, ייצוא `eyal-page-content-intake` |
| `tasks.html` | משימות והחלטות + ייצוא משוב קיים |

בנייה: `python3 scripts/build_eyal_client_hub.py` — ראו [`hub/README.md`](../../hub/README.md).

---

## קישורים מהירים

- מסלול כפול טכני/תוכן: [`WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md)  
- זרימת SSOT אחרי ייצוא JSON: [`hub/EYAL-HUB-SSOT-WORKFLOW.md`](../../hub/EYAL-HUB-SSOT-WORKFLOW.md)
