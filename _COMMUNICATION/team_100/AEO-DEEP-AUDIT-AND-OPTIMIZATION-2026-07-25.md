# AEO Deep Audit + Optimization — 2026-07-25

| Field | Value |
|-------|--------|
| from_team | team_100 |
| date | 2026-07-25 |
| staging | http://eyalamit-co-il-2026.s887.upress.link |
| evidence | `_COMMUNICATION/team_100/evidence/aeo-deep-audit-2026-07-25/` |
| checklist | `evidence/.../AEO-CHECKLIST.md` |

## Verdict

**מספיק לשלב → לאחר פריסה 2026-07-25: שכבת המכונה AEO על סטייג'ינג עוברת שער מסלולים מלא (21/21), כולל עמוד העוגן.**

שכבת המכונה על סטייג'ינג **עובדת** במסלולי ליבה (Person + ProfessionalService + GeoCircle + Service + FAQPage + Book במקומות הנכונים; meta/OG יחידים; איסורים נקיים). פער העוגן `/snoring-sleep-apnea/` (Article+FAQPage) **תוקן בקוד ונפרס** — מאומת חי: FAQPage עם 6 שאלות + Article. נותרים בעיקר תוכן Eyal-gated, מדידה ב־cutover, וחיזוק `seo_probe` מול sitemap HEAD (F-SEO-01).

## Evidence index

| Artifact | Role |
|----------|------|
| `AEO-CHECKLIST.md` | C1–C13 merged skill+SSOT |
| `jsonld_matrix.json` | Per-route @types / FAQ / GeoCircle / prohibitions |
| `content_aeo_pass.json` | H2-as-questions, FAQ samples, NAP phone/street |
| `seo_probe/robots.txt` | Staging block-all (expected) |
| `seo_probe/sitemap_head_sample.txt` | Sample page-sitemap HEADs (incl. 000 anomalies) |
| Note | Full `seo_probe.mjs` HEADs every sitemap URL (~200+) — too slow for session; lite evidence + matrix used. F-SEO-01 still open. |

## Checklist results (staging)

| ID | Result | Notes |
|----|--------|-------|
| C1 Crawl/AI UAs | PASS (staging) | `Disallow: /` + noindex — intentional. Prod = cutover WP012 |
| C2 Answer-first | PASS | treatment/sound-healing/lessons/method/snoring lead with direct answers |
| C3 FAQ visible | PASS core / PASS snoring | Snoring: 6 `<details>` via `dd` part |
| C4 FAQPage schema | PASS core / **FAIL snoring** | treatment 20Q, method 9, faq 110, snoring **0** |
| C5 Entity graph | PASS | Service only on treatment/sound-healing/lessons; method no Service |
| C6 GeoCircle | PASS | lat≈32.46 lon≈34.98 r=45000 |
| C7 Meta unique | PASS (sampled) | 1 meta description on matrix routes |
| C8 Canonical+OG | PASS (sampled) | 1 og:image |
| C9 Prohibitions | PASS | No AggregateRating / Israel / HealthAndBeauty |
| C10 EEAT Person | PASS | Person + sameAs + /eyal-amit/ |
| C11 Pillar AEO | **PASS** (post-redeploy) | Article + FAQPage (6) live on `/snoring-sleep-apnea/` |
| C12 NAP | PASS hard / P1 soft | Schema phone `+972-52-482-2842` + street `עמל 8 ב'` match footer; FAQ address deliberately omits street ("ניתנת לאחר תיאום") — not a wrong-number bug |
| C13 Measurement | cutover-only | WP012 / GSC / utm chatgpt |

## Findings table

| Sev | ID | Route / area | Finding | Ownership | Class |
|-----|-----|--------------|---------|-----------|-------|
| P0 | AEO-01 | `/snoring-sleep-apnea/` | Visible FAQ without FAQPage / no Article — **FIXED + deployed 2026-07-25** | team_100 | **closed** |
| P0 | AEO-02 | `seo_probe.config.json` | expectedTypes omit FAQPage/Book — **FIXED** | team_100 | **closed** |
| P0 | AEO-03 | `seo_probe.mjs` | No GeoCircle assert — **FIXED** (check 7b) | team_100 | **closed** |
| P1 | AEO-04 | `/faq/` price | "מדיניות מחיר — ממתין להכרעת אייל" | Eyal / team_00 | **Eyal-gated** |
| P1 | AEO-05 | `/faq/` geo | Address FAQ soft vs footer NAP (privacy vs full street) — align copy when Eyal decides | Eyal + team_10 | **Eyal-gated** |
| P1 | AEO-06 | pending markers | `.ea-pending-approval` on treatment/method/snoring/faq/books | Eyal | **Eyal-gated** |
| P1 | AEO-07 | sitemap | Sample HEAD `000` on `/services/`, `/books/` — investigate redirect shells / HEAD support | team_110 | **buildable-now** (ops) |
| P1 | AEO-08 | F-SEO-01 | Full seo_probe sitemap HEAD flaky/slow | team_110 | **buildable-now** |
| P2 | AEO-09 | production robots | Artifact ready; not live until WP012 | cutover | **cutover-only** |
| P2 | AEO-10 | off-site | GBP / Wikidata | Eyal / ops | **Eyal-gated** |
| P2 | AEO-11 | blog spokes | Draft-only content program | Eyal + 10 | **Eyal-gated** |

## Optimization executed this session (P0)

Implemented in-repo (see Optimization log). Staging live verify of AEO-01 **blocked on FTP timeout**.


## Optimization log

| Item | Status | Evidence |
|------|--------|----------|
| AEO-01 schema: Article + FAQPage from Chapters `dd` on `/snoring-sleep-apnea/` | **Code done in repo** — [`ea-w2-seo-schema.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/mu-plugins/ea-w2-seo-schema.php) | Live staging still missing Article/FAQPage on pillar (`post_p0_verify.json`) because **FTP deploy timed out** (connect errno 60) — see `ftp_deploy_stdout.txt` |
| AEO-02 `seo_probe.config.json` FAQPage/Book/Article assertions + snoring route | **Done** | config updated |
| AEO-03 GeoCircle check 7b in `seo_probe.mjs` | **Done** | probe updated; subset gate passes on treatment/faq/method/books/home |
| AEO-04/05 NAP hard mismatch | **No code change** — phone/street match footer; FAQ address soft-omit is Eyal policy | `content_aeo_pass.json` |
| Staging FTP redeploy | **DONE** 2026-07-25 — `Done: FTP deploy site/wp-content` incl. `ea-w2-seo-schema.php` | `ftp_deploy_stdout.txt` + `post_redeploy/` |
| Post-redeploy gate | **21/21 PASS** (expectedTypes + GeoCircle; sitemap HEAD skipped F-SEO-01) | `post_redeploy/gate_all_routes.json` |
| Pillar `/snoring-sleep-apnea/` live | **Article + FAQPage (6 Q)** + GeoCircle | `post_redeploy/jsonld_matrix.json` |

**Post-redeploy AC:** met (Article+FAQPage+≥6 FAQ on pillar; full route gate green).

## Handoff (remaining)

### Immediate (ops — FTP)

- ~~Restore FTP / deploy schema~~ — **completed 2026-07-25**.

### Cutover-only (WP012 / team_20+100)

- Swap root `robots.txt` → [`docs/cutover/robots-production.txt`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/cutover/robots-production.txt)
- Remove staging noindex posture on production domain
- Day-one AI-UA curl matrix + GSC sitemap submit
- Document `utm_source=chatgpt.com` in analytics reporting

### Eyal-gated (team_00 → Eyal)

- Price FAQ wording (AEO-04)
- Soft NAP address FAQ policy (AEO-05)
- Clear `.ea-pending-approval` claims/media (AEO-06)
- Blog spokes publish + BN-03 titles if still deferred

### Buildable follow-ups (team_110)

- Sitemap HEAD anomalies (AEO-07) + F-SEO-01 retry/timeout wrapper (AEO-08)
- After P0 live on staging: team_90 cross-engine ratification of updated `seo_probe` expectations (Iron Rule #1)
