---
id: EVIDENCE-COMPOSER-LIVE-VERIFY-2026-09-22
schema_version: aos_v1_team_messaging
type: EVIDENCE
from: team_10
to: [team_110, team_100]
date: 2026-09-22
validator: Composer 2.5 (not the builder)
staging_theme_at_measure: 1.5.106
status: MEASURED
---

# Live verify — Chapters align-sweep (staging)

Validator: Composer 2.5, CDP on staging `http://eyalamit-co-il-2026.s887.upress.link`.  
Theme on the server at measure time: **1.5.106**.  
`main` later merged the same sweep into **1.5.108** (`7f7d762`). This file is the 1.5.106 measure, not a re-measure of 1.5.108.

PNG files were written under the isolated tree `EyalAmit.co.il-2026-align-sweep`, which is no longer a git worktree. Those PNGs are **not on disk**. Do not treat the old `tmp/qa/align-sweep/verify/*.png` paths as evidence.

## Verdict

**9 / 10** page × viewport cells **PASS** on the Chapters layout canon.  
**1 FAIL:** post `100-100-100-toda` at 1440×900 — an in-content H2 is **34px**. The shell (wrap, reading column, H1) matches canon. That H2 is pasted content, not the theme token (**24.65px**).

Blog archive and blog single use **`main.chapters-main` only**. No live `ea-wave2-blog-*` on those URLs.  
Home `/` unchanged: wrap 1200, intro 775.3, H1 716.5 centered at 1440.

## Page × viewport

| Page | 1440×900 | 390×844 | Computed @1440 |
|---|---|---|---|
| `/2228-2/` | PASS | PASS | `main` 1440, max-width none; wrap **1200** + pad **48**; `.ea-post-content` **775.3**; H1 width **786.6** start **44.2px**; H2 **24.65px**; H3 **15.3px**; sec **88px**; overflow **0**; body **17px** |
| `/100-100-100-toda/` | **FAIL** | PASS | Same shell as `/2228-2/`. **`.ea-post-content h2` = 34px** (canon H2 token 24.65px) |
| `/blog/` | PASS | PASS | `chapters-main`; wrap **1200**; H1 **786.6** / **44.2px**; card H2 **15.3px** (card, not a layout fail); sec **88** / **40** @390; overflow **0** |
| `/snoring-sleep-apnea/` | PASS | PASS | Widest wrap **1200**; `.intro-body` **775.3**; H1/H2 tokens OK. @390 content `section.sec` **40px** (first section is TOC `ea-toc__sec` **0** — expected) |
| `/` home | PASS | PASS | wrap **1200**; intro **775.3** / **294** @390; H1 **716.5** center @1440 / **310** center @390; body **17px** |

Mobile H1/H2 scale (for example H1 **32.3px**) is the responsive token, not a fail. Judged on overflow, section padding, and home widths.

## What the layout shows

- No 960px cage on the updated blog single or archive. One reading column **775.3px** inside wrap **1200**.
- Cookie / GA banner sat on some hero captures. Metrics were taken with the banner present. It does not change the width numbers above.
- Nested `.wrap.lede` on snoring (~267px) is not the page shell. The canon check uses the widest wrap (**1200**).

## URLs measured

- http://eyalamit-co-il-2026.s887.upress.link/2228-2/
- http://eyalamit-co-il-2026.s887.upress.link/100-100-100-toda/
- http://eyalamit-co-il-2026.s887.upress.link/blog/
- http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/
- http://eyalamit-co-il-2026.s887.upress.link/
