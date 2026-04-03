# צ'קליסט השקה — אתר חדש (2026)

**גרסה:** 1.3  
**תאריך:** 2026-04-02  
**פרויקט:** אייל עמית — WordPress רזה  

---

## מעבר מלא ל‑HTTPS (SSL) בפרודקשן — כל ענפי הפרויקט

חובה כ**חלק מפריסת הפרודקשן** ומסגירת **M7** (הכנה ורשימת נכסים ב־**M5**). בסטייג'ינג נשארים ב־HTTP לפי מדיניות sandbox; בדומיין החי — **רק HTTPS תקין**.

- [ ] **אתר WordPress:** כל URL ציבורי ו־`wp-admin` ב־`https://`; תעודה תקינה; הפניות `http→https`; בדיקת mixed content (מדיה, סקריפטים, iframe).
- [ ] **Client Hub:** פריסת `hub/dist/` נגישה ב־`https://` על הדומיין/נתיב המאושר; עדכון `local/.env.upress` (או מקביל פרודקשן) — `UPRESS_PUBLIC_BASE` / בסיסי REST ב־**https**; ראו [`CLIENT_HUB_APPENDIX_EYAL.md`](../CLIENT_HUB_APPENDIX_EYAL.md).
- [ ] **REST / Application Password:** `UPRESS_WP_REST_BASE` וכל סקריפט אוטומציה — רק מעל HTTPS בפרודקשן ([`UPRESS_WORDPRESS_STANDARD_v2.md`](./UPRESS_WORDPRESS_STANDARD_v2.md) §7).
- [ ] **FTP / פריסה:** חיבור **FTPS** לפרודקשן לפי v2 §2.1 (לא plain FTP בלי חריג מתועד).
- [ ] **תיעוד וקישורים חיצוניים:** מסמכי מאגר, מיילים ללקוח, QR חדשים — אין הפניות שגרתיות ל־`http://` על הדומיין החי.
- [ ] **אימות:** `curl`/דפדפן על דגימת עמודים (בית, צור קשר, EN, Hub) — סטטוס 200 ב־HTTPS בלי אזהרת תעודה.

מפת דרכים: [`ROADMAP-2026.md`](./ROADMAP-2026.md) — סעיף «מעבר מלא ל‑HTTPS».

---

## לפני cutover

- [ ] **טופס צור קשר — אימות סופי בפרודקשן:** נמען נכון, שליחת בדיקה, קבלה בתיבה או אימות ב־`WP Mail Logging` / SMTP פרודקשן (בסטייג'ינג — מספיק PASS WITH NOTES לפי [`M2-WEEK0-CLOSEOUT-TEAM100-2026-03-29.md`](../../_communication/team_100/M2-WEEK0-CLOSEOUT-TEAM100-2026-03-29.md))
- [ ] אישור תקציר מנהלים **חתום** — הקובץ שיצא **ב-docx או PDF** (לא `.md`; ראו `EYAL-EXECUTIVE-SUMMARY-FOR-EYAL.docx` ו-[`README-PDF-FROM-WORD.txt`](./team-100-preplanning/README-PDF-FROM-WORD.txt))
- [ ] [`GREEN-INVOICE-LINK-MAP.md`](./team-100-preplanning/GREEN-INVOICE-LINK-MAP.md) ממולא
- [ ] בדיקת דגימה מ-[`QR-URL-INVENTORY.csv`](./team-100-preplanning/QR-URL-INVENTORY.csv) — אין שינוי slug
- [ ] [`LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md`](./team-100-preplanning/LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md) — צ'קליסט הושלם
- [ ] עמוד הצהרת נגישות + קישור בפוטר
- [ ] עמוד EN פעיל + `lang` / `hreflang` לפי החלטה
- [ ] OG / Twitter לכל תבנית ליבה
- [ ] Sitemap XML + שליחה ל-Search Console
- [ ] `robots.txt` נכון; staging ללא אינדקס אם רלוונטי

---

## הפניות 301 (רק היכן מותר)

- [ ] **לא** לגעת ב-URLי QR (מדיניות [`QR-URL-POLICY.md`](./team-100-preplanning/QR-URL-POLICY.md))
- [ ] `/shop/`, `/shop/cart/`, `/shop/checkout/`, `/shop/my-account/` — יעד לפי החלטת אייל (לאחר בדיקת קישורים חיצוניים)
- [ ] תיעוד כל 301 בטבלה (Yoast Redirects / שרת)

---

## אחרי השקה (48–72 שעות)

- [ ] **רוטציית סיסמאות** — WP, DB, SFTP, שירותים (מתועד ב־runbook צוות 20; מדיניות: [`WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md`](./WORDPRESS-DEPLOY-AND-DUAL-TRACK-2026-03-29.md) §6)
- [ ] Search Console — שגיאות סריקה / 404
- [ ] בדיקת שיתוף פייסבוק / וואטסאפ לדף הבית ושירות
- [ ] Lighthouse (בית + צור קשר + EN)
- [ ] גיבוי אתר ישן שמור; גיבוי ראשון לאתר חדש

---

## אחרי 30 יום

- [ ] סקירת תנועה אורגנית ועמודי נחיתה
- [ ] תכנון גל 2 לבלוג לפי [`BLOG-REVIVAL-PLAN.md`](./BLOG-REVIVAL-PLAN.md)
