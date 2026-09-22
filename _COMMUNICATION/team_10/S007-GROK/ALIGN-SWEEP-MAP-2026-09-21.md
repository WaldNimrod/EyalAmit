# ALIGN-SWEEP-MAP — 2026-09-21

---
id: ALIGN-SWEEP-MAP-2026-09-21
schema_version: aos_v1_team_messaging
type: MAP (team_10)
from: team_10
to: [team_100, team_110]
date: 2026-09-22
status: MEASURED
engine: cursor-grok-4.6 (builder)
theme_live: 1.5.105
worktree: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep
raw: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/tmp/qa/align-sweep/raw.json
summary: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/tmp/qa/align-sweep/summary.json
---

אונבורד צוות 10 הושלם. `/` excluded. CDP 1440×900 + 390×844. UA Chrome 128. GET `redirect:manual` before CDP. Layout from CDP only.

Canon `/snoring-sleep-apnea/` live this run: wrap **1200**, intro-body **775.3**, H2 **1104**, main max **none**, overflow 390 **0**.

## 0. Coverage

| item | n |
|---|---:|
| TSV URLs except `/` | 156 |
| CDP rows (2 viewports) | 312 |
| CDP missing | 0 |
| overflow >1px @390 | 0 |
| dual-class on main (`chapters-main` + `ea-wave2-*`) | 55 |
| `classList.remove` released cage | 55 |
| HTTP 200 (no follow) | 136 |
| HTTP 301 (no follow) | 19 |
| HTTP 404 (no follow) | 1 |

301s are aliases (old slugs → canonical). CDP followed them (browser). Two TSV posts 301 to `/blog/` (deleted/merged). `/services/` is 404.

## 1. Families (desktop 1440)

| family | n | main max-width | wrap | reading | wave2 on main | cage proof |
|---|---:|---|---|---|---|---|
| **F-CHAP-82CH** | 36 | none×36 | 1200 | 775.3 | — | no dual / no release |
| **F-PRESS-W2** | 1 | none×1 | — | — | ea-wave2-editorial×1 | no dual / no release |
| **F-QR-CHAP** | 48 | none×48 | 1200 | 775.3 | — | no dual / no release |
| **F-QR-HUB** | 1 | none×1 | 1200 | — | — | no dual / no release |
| **F-CHAP-SPECIAL** | 9 | none×9 | 1200 | 516 | — | no dual / no release |
| **F-CHAP-OTHER** | 3 | none×3 | — | — | — | no dual / no release |
| **F-GP** | 3 | none×3 | — | — | — | no dual / no release |
| **F-BLOG-ARCHIVE** | 3 | 1200px×3 | 1136 | — | ea-wave2-blog-archive×3 | 3/3 released |
| **F-BLOG-SINGLE** | 52 | 960px×52 | 896 | — | ea-wave2-blog-single×52 | 52/52 released |

N sums to 156 (every TSV row except `/`). 301 aliases inherit the target family.

### F-CHAP-82CH (n=36)

Already matches snoring canon (wrap 1200 + 82ch). No Wave2 class on main. Do not edit.

Paths:
- `/snoring-sleep-apnea/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/repair/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/stand-floor/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/stands-storage/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/bags/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/didgeridoos/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/books/tsva-bekahol/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/books/vekatavta/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/about/moksha/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/eyal-amit/mokesh-dahiman/
- `/about/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/eyal-amit/
- `/muzza/vekatavt/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/books/vekatavta/
- `/books/kushi-blantis/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/muzza/tsva-bechol-ve-zorek-layam/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/books/tsva-bekahol/
- `/muzza/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/books/
- `/privacy/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/muzeh/vekatavt/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/books/vekatavta/
- `/muzeh/kushi-blantis/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/books/kushi-blantis/
- `/muzeh/tsva-bechol-ve-zorek-layam/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/books/tsva-bekahol/
- `/muzeh/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/books/
- `/tools-and-accessories/repair/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/repair/
- `/tools-and-accessories/instruments/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/didgeridoos/
- `/learning/workshops/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/learning/lectures/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/learning/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/sound-healing/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/treatment/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/thank-you/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/terms/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/accessibility/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/en/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/learning/therapist-training/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/books/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/eyal-amit/mokesh-dahiman/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/eyal-amit/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/services/handmade-instruments/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/didgeridoos/
- `/services/didgeridoo-treatment-breath/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px 301→/treatment/

### F-PRESS-W2 (n=1)

ea-wave2-editorial, no .wrap. classList.remove did NOT change geometry. Do not invent Chapters.

Paths:
- `/press/` — main=`ea-wave2-editorial` wrap=— intro=— post=— phero=— secPad=—

### F-QR-CHAP (n=48)

tpl-chapters-qr.php. wrap 1200 + intro 775.3. Permalinks locked. No dual class. No layout edit.

Paths:
- `/qr/qr48/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr47/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr46/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr45/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr44/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr43/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr42/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr41/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr40/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr39/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr38/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr37/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr36/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr35/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr34/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr33/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr32/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr31/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr30/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr29/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr28/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr27/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr26/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr25/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr24/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr23/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr22/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr21/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr20/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr19/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr18/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr17/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr16/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr15/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr14/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr13/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr12/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr11/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr10/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr9/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr8/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr7/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr6/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr5/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr4/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr3/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr2/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px
- `/qr/qr1/` — main=`chapters-main` wrap=1200 intro=775.3 post=— phero=1440 secPad=88px

### F-QR-HUB (n=1)

tpl-chapters-page qr-hub. wrap 1200, catalog not 82ch column. No dual.

Paths:
- `/qr/` — main=`chapters-main` wrap=1200 intro=— post=— phero=1440 secPad=88px

### F-CHAP-SPECIAL (n=9)

Chapters chrome 1200. First row is split 516/516 (legal second atom) or catalog/form. Not a Wave2 cage.

Paths:
- `/testimonials/` — main=`chapters-main` wrap=1200 intro=— post=— phero=1440 secPad=88px
- `/galleries/` — main=`chapters-main` wrap=1200 intro=— post=— phero=1440 secPad=88px
- `/tools-and-accessories/` — main=`chapters-main` wrap=1200 intro=— post=— phero=1440 secPad=88px 301→/shop/
- `/lessons/` — main=`chapters-main` wrap=1200 intro=516 post=— phero=1440 secPad=88px
- `/method/` — main=`chapters-main` wrap=1200 intro=516 post=— phero=1440 secPad=88px
- `/shop/` — main=`chapters-main` wrap=1200 intro=— post=— phero=1440 secPad=88px
- `/contact/` — main=`chapters-main` wrap=1200 intro=— post=— phero=1440 secPad=88px
- `/hashita/` — main=`chapters-main` wrap=1200 intro=516 post=— phero=1440 secPad=88px 301→/method/
- `/services/didgeridoo-lessons/` — main=`chapters-main` wrap=1200 intro=516 post=— phero=1440 secPad=88px 301→/lessons/

### F-CHAP-OTHER (n=3)

chapters-main full 1440, no 82ch column (FAQ 820 list / pending pages).

Paths:
- `/faq/` — main=`chapters-main` wrap=— intro=— post=— phero=1440 secPad=—
- `/learning/courses-external/` — main=`chapters-main` wrap=— intro=— post=— phero=1440 secPad=—
- `/courses-soon/` — main=`chapters-main` wrap=— intro=— post=— phero=1440 secPad=— 301→/learning/courses-external/

### F-GP (n=3)

GeneratePress site-main ~820. No ea-wave2 on main. Do not invent Chapters.

Paths:
- `/historical-articles/` — main=`site-main` wrap=— intro=— post=— phero=— secPad=—
- `/shows-heritage/` — main=`site-main` wrap=— intro=— post=— phero=— secPad=—
- `/services/` — main=`site-main` wrap=— intro=— post=— phero=— secPad=— HTTP 404

### F-BLOG-ARCHIVE (n=3)

DUAL: chapters-main + ea-wave2-blog-archive. main max 1200 cages hero. remove() → main 1440 / wrap 1200 / phero 1440.

Paths:
- `/blog/` — main=`chapters-main.ea-wave2-blog-archive` wrap=1136 intro=— post=— phero=1136 secPad=88px
- `/%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%9e%d7%94%d7%a0%d7%99%d7%99%d7%a8-%d7%a2%d7%9d-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa/` — main=`chapters-main.ea-wave2-blog-archive` wrap=1136 intro=— post=— phero=1136 secPad=88px 301→/blog/
- `/41-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%97%d7%90%d7%a8%d7%98%d7%94-%d7%91%d7%90%d7%a8%d7%98%d7%94/` — main=`chapters-main.ea-wave2-blog-archive` wrap=1136 intro=— post=— phero=1136 secPad=88px 301→/blog/

### F-BLOG-SINGLE (n=52)

DUAL: chapters-main + ea-wave2-blog-single. main max 960 cages hero+body. remove() → main 1440 / wrap 1200 / phero 1440. .ea-post-content stays 66ch/624 until a second pattern.

Paths:
- `/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%9e%d7%95%d7%a8%d7%94-%d7%9c%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9e%d7%95%d7%93%d7%94-%d7%9c%d7%9e%d7%95%d7%a8%d7%99%d7%95-%d7%aa%d7%9c%d7%9e%d7%99%d7%93%d7%99%d7%95-%d7%95%d7%9e%d7%98/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a2%d7%95%d7%93-%d7%a8%d7%92%d7%a2-%d7%9e%d7%97%d7%99%d7%99%d7%95-%d7%a9%d7%9c-%d7%9e%d7%95%d7%a8%d7%94-%d7%9c%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%91%d7%90%d7%9e%d7%a6%d7%a2%d7%95%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%9c%d7%9c%d7%9e%d7%95%d7%93-%d7%9c/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a8%d7%99%d7%91%d7%a8%d7%a1%d7%99%d7%a0%d7%92-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%9e%d7%a2%d7%92%d7%9c%d7%99%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%9e%d7%a2%d7%92%d7%9c%d7%99%d7%aa-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%a8%d7%99%d7%a4%d7%95%d7%99-%d7%a2%d7%a6/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a0%d7%a9%d7%99%d7%9d-%d7%9e%d7%a0%d7%92%d7%a0%d7%95%d7%aa-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%90%d7%99%d7%a9%d7%94-%d7%9e%d7%a0%d7%92%d7%a0%d7%aa-%d7%91%d7%93%d7%99%d7%92/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a1%d7%93%d7%a0%d7%aa-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a7%d7%91%d7%95%d7%a6%d7%aa%d7%99%d7%aa-%d7%9e%d7%a7%d7%99%d7%a4%d7%94-%d7%95%d7%99%d7%99%d7%97%d7%95%d7%93%d7%99%d7%aa-%d7%9c/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%aa%d7%9c%d7%9e%d7%99%d7%93%d7%99%d7%9d-%d7%95%d7%9e%d7%98%d7%95%d7%a4%d7%9c%d7%99%d7%9d-%d7%9e%d7%9e%d7%9c%d7%99%d7%a6%d7%99%d7%9d-%d7%a2%d7%9c-%d7%94%d7%9e%d7%a8%d7%9b%d7%96-%d7%9c%d7%98%d7%99/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%98%d7%99%d7%a4%d7%95%d7%9c-%d7%91%d7%a4%d7%95%d7%a1%d7%98-%d7%98%d7%a8%d7%90%d7%95%d7%9e%d7%94-%d7%9c%d7%97%d7%99%d7%99%d7%9c-%d7%9e%d7%a9%d7%95%d7%97%d7%a8%d7%a8-%d7%9e%d7%92%d7%95%d7%9c%d7%a0/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%9e%d7%95%d7%a7%d7%a9-%d7%93%d7%94%d7%99%d7%9e%d7%9f-%d7%9e%d7%90%d7%a1%d7%98%d7%a8-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a6%d7%99%d7%95%d7%a8-%d7%9e%d7%a7%d7%95%d7%a8%d7%99-%d7%97/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%9b%d7%aa%d7%91%d7%94-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9e%d7%95%d7%a8%d7%94-%d7%95%d7%9e%d7%98%d7%a4%d7%9c-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%95%d7%a1%d7%99%d7%a4%d7%a8%d7%aa%d6%b8%d6%bc-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%a4%d7%95%d7%a7%d7%9f-%d7%a1%d7%98%d7%95%d7%a8%d7%99%d7%96-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%90%d7%aa-%d7%94%d7%a1%d7%a4%d7%a8-%d7%94%d7%97%d7%93%d7%a9-%d7%a9%d7%9c%d7%99-%d7%9c%d7%90-%d7%aa%d7%9e%d7%a6%d7%90%d7%95-%d7%91%d7%a8%d7%a9%d7%aa%d7%95%d7%aa-%d7%94%d7%a1%d7%a4%d7%a8%d7%99%d7%9d/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%94%d7%a9%d7%a7%d7%aa-%d7%94%d7%a1%d7%a4%d7%a8-%d7%94%d7%97%d7%93%d7%a9-%d7%95%d7%9b%d7%aa%d7%91%d7%aa%d6%b8-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%9b%d7%aa%d7%91%d7%94-%d7%a2%d7%9c-%d7%aa%d7%95%d7%a4%d7%a2%d7%aa-%d7%99%d7%97%d7%99%d7%93-%d7%91-%d7%94%d7%9e%d7%a7%d7%95%d7%9e%d7%95%d7%9f-%d7%92%d7%91%d7%a2%d7%aa%d7%99%d7%99%d7%9d-%d7%a8/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%aa%d7%95%d7%a4%d7%a2%d7%aa-%d7%99%d7%97%d7%99%d7%93-%d7%9e%d7%95%d7%a4%d7%a2-%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-spoken-stories-15/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%aa%d7%95%d7%a4%d7%a2/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a9%d7%99%d7%a9%d7%99-23-10-15-%d7%91%d7%aa%d7%99%d7%90/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9b%d7%aa%d7%91%d7%94-%d7%9e%d7%90%d7%aa-%d7%a8%d7%95/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/2228-2/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a9%d7%a0%d7%99-%d7%aa%d7%90%d7%a8%d7%99%d7%9b%d7%99%d7%9d-%d7%a7%d7%a8%d7%95%d7%91%d7%99%d7%9d-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a9%d7%a0%d7%94-%d7%9c%d7%97%d7%95%d7%a7-%d7%94%d7%a1%d7%a4%d7%a8%d7%99%d7%9d-%d7%a6%d7%a0%d7%99%d7%97%d7%94-%d7%a9%d7%9c-35-%d7%91%d7%9e%d7%9b%d7%99%d7%a8%d7%95%d7%aa-%d7%a9%d7%9c-%d7%a1%d7%a4/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%93%d7%a3-%d7%a4%d7%99%d7%99%d7%a1%d7%91%d7%95%d7%a7-%d7%97%d7%93%d7%a9-%d7%9c%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%96%d7%9e%d7%a0%d7%94-%d7%9c%d7%a9%d7%a0%d7%99-%d7%94%d7%9e%d7%95%d7%a4%d7%a2%d7%99/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-15-11-14-%d7%91%d7%aa/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%94%d7%95%d7%a4%d7%a2%d7%94-%d7%91%d7%9e%d7%95%d7%a6%d7%a9-%d7%94%d7%a7%d7%a8%d7%95%d7%91-13-9-14-%d7%91%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/2-8-%d7%9e%d7%95%d7%a4%d7%a2-%d7%91%d7%a6%d7%95%d7%95%d7%aa%d7%90-20-%d7%9e%d7%94%d7%9e%d7%a7%d7%95%d7%9e%d7%95%d7%aa-%d7%91%d7%90%d7%95%d7%9c%d7%9d-%d7%97%d7%99%d7%a0%d7%9d-%d7%9c%d7%aa%d7%95%d7%a9/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%9a-%d7%94%d7%aa%d7%97%d7%9c%d7%aa%d7%99-%d7%9c%d7%9b%d7%aa%d7%95%d7%91-%d7%95%d7%9c%d7%a1%d7%a4/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%9c%d7%90-%d7%91%d7%a2%d7%95%d7%93-%d7%a8%d7%92%d7%a2-%d7%9c%d7%90-%d7%91%d7%a2%d7%95%d7%93-%d7%a9%d7%a0%d7%99%d7%99%d7%94-%d7%a2-%d7%9b-%d7%a9-%d7%99-%d7%95/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%91%d7%99%d7%a7%d7%95%d7%a8%d7%95%d7%aa-%d7%92%d7%95%d7%9c%d7%a9%d7%99%d7%9d-%d7%90%d7%95%d7%93%d7%95%d7%aa-%d7%a2%d7%9b%d7%a9%d7%99%d7%95-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a1%d7%a8%d7%98%d7%99%d7%9d-%d7%9e%d7%94%d7%97%d7%99%d7%99%d7%9d-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/100-100-100-%d7%aa%d7%95%d7%93%d7%94/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%a2%d7%9e%d7%99%d7%aa-%d7%91%d7%99%d6%b8%d7%93%d6%b4%d7%99%d7%aa-%d7%9e%d7%95%d7%a4%d7%a2-%d7%94%d7%a1%d7%99%d7%a4%d7%95%d7%a8%d7%99%d7%9d-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%94%d7%a1%d7%a4%d7%a8-%d7%94%d7%97%d7%93%d7%a9-%d7%a9%d7%9c%d7%99-%d7%96%d7%a7%d7%95%d7%a7-%d7%9c/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%a4%d7%a8%d7%93%d7%a1-%d7%97%d7%a0%d7%94-%d7%a1%d7%98%d7%95%d7%93%d7%99%d7%95-%d7%9c%d7%91%d7%a0%d7%99%d7%99%d7%94-%d7%95%d7%a0%d7%92%d7%99%d7%a0/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/60-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%99%d7%99-%d7%90%d7%9d-%d7%91%d7%a7/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/51-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%a7%d7%a1%d7%98%d7%a8%d7%99%d7%9d-%d7%96%d7%94-%d7%a0%d7%a2%d7%99%d7%9d/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/49-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a7%d7%95%d7%9e%d7%99%d7%a7-%d7%a8%d7%9c%d7%99%d7%a3/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/47-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%96%d7%9e%d7%9f-%d7%97%d7%9c%d7%95%d7%9d/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/45-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a4%d7%a8%d7%95%d7%a4%d7%95%d7%a8%d7%a6%d7%99%d7%95%d7%aa/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/43-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%93%d7%95%d7%9f-%d7%a1%d7%9c%d7%99%d7%97%d7%95%d7%aa/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/42-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%97%d7%93-%d7%91%d7%a1%d7%a4%d7%98%d7%9e%d7%91%d7%a8/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/40-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a4%d7%a8%d7%a1%d7%95%d7%9e%d7%aa-%d7%90%d7%97%d7%aa-%d7%95%d7%97%d7%96%d7%a8%d7%a0%d7%95/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/36-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a9%d7%99%d7%98%d7%aa-%d7%94%d7%a9%d7%a7%d7%a9%d7%95%d7%a7%d7%94/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/34-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%94%d7%9c%d7%91/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/32-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%90%d7%9d-%d7%90%d7%99%d7%9f-%d7%90%d7%a0%d7%99-%d7%9c%d7%99-%d7%9e%d7%99-%d7%9c%d7%99/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/29-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%a8%d7%99%d7%99%d7%91-%d7%a9%d7%91%d7%95%d7%a2-%d7%94%d7%a1%d7%a4%d7%a8/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/27-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%97%d7%9b%d7%9e%d7%aa-%d7%94%d7%a4%d7%a8%d7%a6%d7%95%d7%a3/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-24-%d7%99%d7%9c%d7%93-%d7%90%d7%a1%d7%95%d7%a8-%d7%99%d7%9c%d7%93-%d7%9e%d7%95%d7%aa%d7%a8/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/23-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9c%d7%a6%d7%99%d7%99%d7%aa-%d7%90%d7%95-%d7%9c%d7%97%d7%a9%d7%95%d7%91/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px
- `/18-%d7%94%d7%98%d7%95%d7%a8-%d7%a9%d7%9c-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-%d7%9e%d7%a1%d7%9a-%d7%94%d7%91%d7%a8%d7%96%d7%9c/` — main=`chapters-main.ea-wave2-blog-single` wrap=896 intro=— post=624 phero=896 secPad=88px

## 2. Cage proof (desktop, no reload)

Method: getComputedStyle snapshot → `main.classList.remove(ea-wave2-*)` → snapshot → restore.

### P-BLOG-SINGLE representative `/2228-2/`

| metric | before | after remove `ea-wave2-blog-single` | canon |
|---|---:|---:|---:|
| mainW | 960 | 1440 | 1440 |
| mainMax | 960px | none | none |
| wrapW | 896 | 1200 | 1200 |
| pheroW | 896 | 1440 | 1440 |
| postW | 624 | 624 | 775.3 |
| h2W | 800 | 864 | 1104 |

released=True. wrap/phero/main jump to snoring chrome. **postW stays 624 (66ch)** — separate pattern P-POST-66CH.

Same dual class + same 960 cage on all 52 F-BLOG-SINGLE URLs (template `tpl-chapters-blog-single.php` line 25).

### P-BLOG-ARCHIVE representative `/blog/`

| metric | before | after remove `ea-wave2-blog-archive` | canon |
|---|---:|---:|---:|
| mainW | 1200 | 1440 | 1440 |
| mainMax | 1200px | none | none |
| wrapW | 1136 | 1200 | 1200 |
| pheroW | 1136 | 1440 | 1440 |

released=True.

### `/press/` — remove `ea-wave2-editorial`
before mainW=1440 wrap=None h1W=596; after identical. **Not a dual-on-Chapters cage.** Do not delete the class to invent a wrap.

## 3. Typography vs tokens (desktop)

Tokens: body 17 / h1 44.2 / h2 24.65 / h3 18.7. F-CHAP-82CH: **0** size defects.
type_off rows: 23 — almost all blog `h3` via `--ea-type-h3` (= `--fs-sm` 15.3px) and a few card h2s. Not a Wave2 width cage.

## 4. Mobile 390

All 156: overflow=0. F-CHAP-82CH / F-QR-CHAP wrap=390, pad 48, inner 294, `--sec` 40px (measured on snoring). Blog singles wrap=326 because `.ea-wave2-blog-single` padding-inline 32px cages main — same dual class.

## 5. Home

`/` was **not** requested in this census (excluded). Baseline GET for regression happens at implement time. No family in this map is `tpl-chapters-home.php`.

## 6. Static template grep (confirms family, not a substitute)

| template | live main class | TSV family |
|---|---|---|
| `tpl-chapters-page.php` / method / en / mokesh / qr | `chapters-main` | F-CHAP-* / F-QR-* |
| `tpl-chapters-blog-single.php:25` | `chapters-main ea-wave2-blog-single` | F-BLOG-SINGLE |
| `tpl-chapters-blog-archive.php:48` | `chapters-main ea-wave2-blog-archive` | F-BLOG-ARCHIVE |
| `tpl-content.php:36` | `ea-wave2-editorial` | F-PRESS-W2 (`/press/`) |
| GP default | `site-main` | F-GP |
| legacy `tpl-blog-single.php` / `tpl-blog-archive.php` | Wave2-only | not winning (chapters router priority 105) |

