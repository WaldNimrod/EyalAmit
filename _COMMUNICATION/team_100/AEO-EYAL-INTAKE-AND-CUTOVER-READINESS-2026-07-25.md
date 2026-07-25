# AEO — מוכנות קליטת אייל + Cutover מהיר (בלי go-live)

| Field | Value |
|-------|--------|
| from | team_100 |
| date | 2026-07-25 |
| status | **READY-WAITING-ON-EYAL** — machine AEO green; content/media gated |
| staging | http://eyalamit-co-il-2026.s887.upress.link |
| team_90 | PASS — `_COMMUNICATION/team_90/VERDICT-AEO-SEO-PROBE-RATIFICATION-2026-07-25.md` |
| do_not | Swap production robots / remove prod noindex until explicit GO |

## 0. מצב נוכחי

- שכבת AEO טכנית על סטייג'ינג: **ירוקה** (21/21 + team_90 PASS).
- אייל משקיע במדיה ודיוק טקסטים — **ממתינים**; לא ממציאים תוכן.
- מטרת המסמך: ביום שהחומרים מגיעים — מעבר ל-deploy+verify בתוך שעות, ואז WP012 רק אחרי GO.

---

## B1 — מפת קליטה (מה מחכים → איפה נכנס → מי מבצע)

מקורות: `hub/data/eyal-needs.json` (P0-CANON, P1, P0-TEXT) + סמני `.ea-pending-approval` ב-defaults.

| חומר מאייל | Hub / ערוץ | קבצים / מערכת | מבצע | AC אחרי קליטה |
|------------|------------|---------------|------|----------------|
| URL חשבונית ירוקה — 3 ספרים + 5 מוצרים | tasks / materials-intake | chapters commerce fields / meta | 10/110 | CTA href חי ≠ placeholder; smoke purchase URL |
| גלריות ספרים / תמונות מוצר | materials-intake / media-intake | `assets/images/...` + gallery slots | 10/110 | אין placeholder; qa image sample |
| מדיה עוגן מכבי.jpg + יוני.jpg + אישור סיפור יוני | media-intake + סימון בעמוד | `snoring-sleep-apnea-defaults.php` — הסרת `.ea-pending-approval` | 10/110 | 0 pending על `/snoring-sleep-apnea/`; images 200 |
| P0-TEXT (מחיר FAQ, 1999, CPAP, rebirthing, cbDIDG) | what-we-need / סימון זוהר באתר | defaults + FAQ CPT / DB | 10 + seed אם צריך | 0 `.ea-pending-approval` על המסלולים; FAQ schema תואם טקסט |
| BN-03 — החלטת meta cbDIDG ל-5 עמודים | D-EYAL-META-SWAP | Yoast metadesc / seo-head | 10/110 | בדיקת meta יחיד + אורך |
| BLOG-01..04 — אישור פרסום טיוטות | wp-admin / content | publish drafts | 10 | posts ב-sitemap; Article schema |
| תקצירי 48 עדויות | materials-intake קבוצה I | testimonials JSON | 10 | אין «זמני» בתקציר |
| AC-12 inbox smoke | טופס + מייל אייל | CF7 / generate_lead | 20/10 + אייל מאשר | lead בתיבה (לא ספאם) |

**Defaults עם pending כיום (repo grep):**  
`snoring-sleep-apnea`, `treatment`, `method`, `vekatavta`, `tsva-bekahol`, `kushi-blantis`, `workshops`, `lectures`, `therapist-training`.

---

## B2 — Runbook «יום שהחומרים הגיעו» (שעות, לא ימים)

```mermaid
flowchart LR
  intake[Intake_Eyal_assets]
  patch[Patch_defaults_or_DB]
  deploy[FTP_deploy_site]
  verify[Gate_seo_plus_content]
  cutover[WP012_when_GO]
  intake --> patch --> deploy --> verify --> cutover
```

### T+0 — קליטה (team_10 / 110)

1. שמירת קבצי מדיה תחת `site/wp-content/themes/ea-eyalamit/assets/...` (או uploads לפי נוהל).
2. עדכון defaults / FAQ / meta **רק** לפי טקסט מאושר — בלי המצאה.
3. הסרת `.ea-pending-approval` / `.gfig--pending` מהפריטים שאושרו.

### T+1 — פריסה

```bash
cd /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026
python3 scripts/ftp_deploy_site_wp_content.py
curl -sS -o /dev/null -w "%{http_code}\n" "http://eyalamit-co-il-2026.s887.upress.link/"
```

### T+2 — שער מהיר (חובה לפני בקשת GO)

1. שער מסלולי AEO (כמו `post_redeploy/gate_all_routes.json`) — expect PASS.
2. `/snoring-sleep-apnea/`: עדיין Article+FAQPage; 0 pending אם המדיה אושרה.
3. דגימת עמודי שירות שהיו עם pending טקסט.
4. אופציונלי: `content-diff` על המסלולים שנגעו.

### T+3 — בקשת GO → WP012

רק אחרי team_00 / אייל: «מאשר עלייה». אז להריץ [`docs/cutover/WP012-CUTOVER-CHECKLIST.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/cutover/WP012-CUTOVER-CHECKLIST.md) + §7 המלא מתוכנית האימות.

---

## B3 — Pre-flight יום-עלייה (תפעולי; לא לבצע עכשיו)

### robots-production.txt — UA list (verified in-repo 2026-07-25)

File: [`docs/cutover/robots-production.txt`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/cutover/robots-production.txt)

| # | User-agent | Present |
|---|------------|---------|
| 1 | Googlebot | yes |
| 2 | Bingbot | yes |
| 3 | GPTBot | yes |
| 4 | OAI-SearchBot | yes |
| 5 | ChatGPT-User | yes |
| 6 | ClaudeBot | yes |
| 7 | Claude-SearchBot | yes |
| 8 | Claude-User | yes |
| 9 | PerplexityBot | yes |
| 10 | Perplexity-User | yes |
| * | `User-agent: *` + `Allow: /` | yes |
| Sitemap | `https://www.eyalamit.co.il/sitemap_index.xml` | yes |

**At cutover:** re-check vendor UA tokens online (tokens drift) before swap.

### Day-of checklist (copy/paste order)

1. Pre-conditions WP012 §1 (prod theme/mu-plugins parity; real WP_HOME; TLS).
2. Identify live docroot `robots.txt` (FTP inspect — C-1).
3. Upload [`robots-production.txt`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/cutover/robots-production.txt) to **site root only** (never via hub publish scripts).
4. Confirm hub `/ea-eyal-hub/robots.txt` still block-all (unrelated).
5. Remove production noindex / staging guards (`ea-staging-noindex` must not fire on www).
6. AI-UA matrix (WP012 §3) on `/`, `/treatment/`, **`/snoring-sleep-apnea/`** (slug fixed 2026-07-25).
7. Submit `sitemap_index.xml` to GSC.
8. Analytics: confirm `utm_source=chatgpt.com` visible in GA4 reports within days.
9. Full §7 15-point checklist + `final_pre_cutover_check.sh` if applicable + team_190/00 sign-off.

---

## B4 — מה לא עושים בזמן ההמתנה

- לא מחליפים robots בפרודקשן.
- לא מפרסמים blog drafts בלי אישור אייל.
- לא מסירים pending-glow בלי חומר/אישור.
- **F-SEO-01** (seo_probe sitemap HEAD retry) — רק **אחרי** חתימת חבילת מוכנות זו; מנדט נפרד ל-110.

---

## Done criteria for «readiness»

- [x] team_90 PASS on seo_probe expectations  
- [x] WP012 pillar slug corrected  
- [x] Intake map + day-of runbook published  
- [x] robots UA inventory documented  
- [ ] Eyal materials received (external)  
- [ ] Day-of runbook executed  
- [ ] WP012 GO  
