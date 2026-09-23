---
validator_role: independent
engine: gpt-5.2
repo: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026
ssot: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json
staging_base: http://eyalamit-co-il-2026.s887.upress.link
probe_artifact: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/qa_probe_result.json
date: 2026-09-21
---

One-line verdict: **PARTIAL** (1 DRIFT: `E3` SSOT `live.check` text is stale vs live; all other measured items MATCH; `qa_probe` overflow PASS; theme `1.5.103` confirmed).

### DRIFT first — `id | claimed | measured | MATCH/DRIFT`

| id | claimed (SSOT / brief) | measured (LIVE staging; no-follow GET + DOM checks) | MATCH/DRIFT |
|---|---|---|---|
| **E3** | `GET /services/ still 200 until unpublish` + nav has no `/services/` | **GET `/services/` = 404** (no `Location`) + homepage HTML **does not contain** `/services/` href | **DRIFT** (GET part stale; nav part MATCH) |
| A1 | `GET /services/ 404 no Location` | **GET `/services/` = 404**, **no `Location`** | MATCH |
| A4 | `GET /thank-you/ 200` + thank-you has 2 Eyal lines | **GET `/thank-you/` = 200** and contains **`תודה שפנית אליי`** + **`הפרטים התקבלו ואחזור אליך בהקדם`** | MATCH |
| B1 | homepage has `iframe youtube.com/embed/wDQoJauqsRM` | **GET `/` = 200** and contains **`youtube.com/embed/wDQoJauqsRM`** | MATCH |
| C2 | `GET /learning/therapist-training/ 200` | **GET `/learning/therapist-training/` = 200** | MATCH |
| D1 | `/didgeridoos/` has **no testimonials section** + no `כל העדויות` CTA | **GET `/didgeridoos/` = 200**; **no `כל העדויות`**; no testimonial-item/swiper markup detected (only global CSS includes + footer link `/testimonials`) | MATCH |
| D3 | `/faq/` links to `/learning/therapist-training/` | **GET `/faq/` = 200** and contains **`/learning/therapist-training/`** | MATCH |
| E7 | homepage has `קורסים` href → `/learning/courses-external/` (real URL, not `#`) | **GET `/` = 200** and contains **`/learning/courses-external/`**; **GET `/learning/courses-external/` = 200** | MATCH |
| F1 | `GET /about/ 301 Location=/eyal-amit/` | **GET `/about/` = 301** with **`Location: http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/`** | MATCH |
| F2 | `/eyal-amit/` contains sentence `הקשר שלי עם מוקש התחיל בשנת 2000` | **GET `/eyal-amit/` = 200** and contains **`הקשר שלי עם מוקש התחיל בשנת 2000`** | MATCH |
| L1 | `/accessibility/ 200` + no draft banner | **GET `/accessibility/` = 200**; no `ea-pending-note` / `draft` / `טיוט` markers in HTML | MATCH |
| L2 | `/privacy/ 200` | **GET `/privacy/` = 200** (also: no `ea-pending-note` / `draft` / `טיוט` markers) | MATCH |
| L3 | `/terms/ 200` + no draft banner | **GET `/terms/` = 200**; no `ea-pending-note` / `draft` / `טיוט` markers in HTML | MATCH |
| P016 | `GET <path> 301 → /blog/` | **GET `/%d7%a1.../` = 301** with **`Location: http://eyalamit-co-il-2026.s887.upress.link/blog/`** | MATCH |
| P045 | `GET <path> 301 → /blog/` | **GET `/41-%d7%.../` = 301** with **`Location: http://eyalamit-co-il-2026.s887.upress.link/blog/`** | MATCH |
| T-EN-NOW | `/en/ 200` + **5 photo slots** + no `WP-EI-06` | **GET `/en/` = 200**; **`ea-photo-slot` count = 5**; `WP-EI-06` not present; internal note not present | MATCH |
| T-LEARNING-PHOTOS | `/learning/ 200` + **3× ea-photo-slot** + ids lessons/lectures/training | **GET `/learning/` = 200**; **`ea-photo-slot` count = 3**; contains ids **`learning-photo-lessons`**, **`learning-photo-lectures`**, **`learning-photo-training`** | MATCH |
| style.css | theme Version **1.5.103** | **GET `/wp-content/themes/ea-eyalamit/style.css` = 200**; header `Version: 1.5.103` | MATCH |
| qa_probe | overflow must be absent at **375 + 1440** on `/`, `/en/`, `/learning/`, `/contact/`, `/press/`, `/eyal-amit/` | `qa_probe.mjs` summary: **PASS** (`failures=0`, no overflow across all 12 (page,viewport) checks) | MATCH |
| N1 / DA-NAV-01 | mobile header: `/` RTL burger right + `/en/` LTR burger left; no overlap; drawer opens from same side | **CDP @ 390**: `/` `dir=rtl` burger **x=302 w=44**; logo **x=44**; after open, drawer right-edge **390**; burger/logo overlap-x **0**. `/en/` `dir=ltr` burger **x=14 w=44**; lang link **x=315 w≈50.98**; burger/lang overlap-x **0**; after open, drawer left-edge **0** | MATCH |

### Spot-check WAITING items that claim “already on site”

| id | claimed | measured | MATCH/DRIFT |
|---|---|---|---|
| A5 | `/learning/courses-external/` is live (coming-soon) + nav href exists | **GET `/learning/courses-external/` = 200** and contains **`יעלה בקרוב`**; homepage contains **`/learning/courses-external/`** | MATCH |
| C1 | `/learning/` has 3 photo slots | **`ea-photo-slot` count = 3** on `/learning/` | MATCH |
| C3 | `/en/` has 5 photo slots; draft banner absent; no `WP-EI-06`; no internal note | **`ea-photo-slot` count = 5**; `WP-EI-06` absent; internal note absent | MATCH |

