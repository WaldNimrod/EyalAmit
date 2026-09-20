# גל א — Composer Attack QA · 2026-09-20

**סטייג'ינג:** [http://eyalamit-co-il-2026.s887.upress.link](http://eyalamit-co-il-2026.s887.upress.link) (HTTP בלבד)  
**תמה חיה:** `ea-eyalamit` **1.5.96** (`style.css?ver=1.5.96`)  
**מנוע:** Composer (QA / attack — לא builder)  
**ראיות:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/)

---

## סיכום לנימרוד

רוב חוזה גל א **עומד בסטייג'ינג** — וורדמרק, פוטר Chapters, וואטסאפ יחיד ב־`/contact/`, תווית L2 חדשה בניווט, הירו `.phero--media` ללא חפיפה עם הסרגל, באנר עוגיות ב־DOM, מדיניות פרטיות מעודכנת.

**פערים שאישר Composer:**

| חומרה | מה |
|--------|-----|
| **P1** | `/shop/` — תוכן עמוד (לא ניווט) עדיין מציג «תיקון וחידוש **כלים**» |
| **P2** | כל 11 עמודי `.phero--media` — `scrollWidth` 578–610 ב־390px (גלילה אופקית מדודה) |
| **P2** | `/en/` — 3 קישורי `wa.me` ב־HTML (2 CTA בעמוד + float) |

**לא אושר מחדש בסשן זה:** מחזור מלא dismiss→reload לבאנר עוגיות (הדפדפן MCP נותק לפני סיום); מומלץ אימות ידני קצר או חזרה על בדיקת Builder.

---

## Findings (English)

### Confirmed MISS

| id | severity | Wave A | URL | viewport | expected vs actual | breaks | evidence | verdict |
|----|----------|--------|-----|----------|-------------------|--------|----------|---------|
| **WAF-01** | P1 contract miss | 15 (similar) | `/shop/` | all (390–1920) | Nav contract fixed L2 to «תיקון וחידוש **כלי דיג׳רידו**»; page body must not show old «תיקון וחידוש **כלים**» | Shop catalog template: inline copy + `.bookcard__t` still hard-coded old string (not `ea-canonical-nav.php`) | HTML grep: 3× «תיקון וחידוש כלים» in body; 0 in nav. Screenshot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/screenshots/shop_390x844.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/screenshots/shop_390x844.png) | **MISS** |
| **WAF-02** | P2 similar sibling | similar | all `.phero--media` pages (see list below) | **390×844** | No horizontal overflow at mobile | Consistent `scrollWidth` **610** (client **390**) on Chapters hero pages — likely off-layout width (drawer/subnav in DOM or hero subtree); affects RTL scroll metric | CDP: `/lessons/` overlap probe `sw:610,cw:390`. qa_probe: 11/11 phero pages `overflow:true` at 390. Example: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/screenshots/lessons_390x844.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/screenshots/lessons_390x844.png) | **MISS** |
| **WAF-03** | P2 similar sibling | similar | `/en/` | all | Hunt: no stacked wa.me beyond contact contract | English GP template: 2 in-page `btn` → `wa.me` **plus** `.ea-whatsapp-float` (3 total in HTML) | curl/HTML: 3× `wa.me` hrefs; float present in DOM | **MISS** |

**WAF-02 affected paths at 390:** `/lessons/` `/contact/` `/privacy/` `/treatment/` `/sound-healing/` `/learning/` `/books/` `/blog/` `/faq/` `/about/moksha/` (301→mokesh) `/learning/therapist-training/` `/method/` — all `scrollWidth` 578–610 per [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/qa_probe_result.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/qa_probe_result.json).

### Suspected (not ship-blocker)

| id | note |
|----|------|
| **WAF-S01** | Cookie first-visit: `<dialog id="ea-cookie-notice">` present in theme; `localStorage` cleared once; **dismiss + reload not completed** in this session after browser disconnect. Builder artifact [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-A-EYAL-NOTES-2026-09-20.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-A-EYAL-NOTES-2026-09-20.md) claims PASS. |
| **WAF-S02** | `/` at 1440: `.testi-mq__track` carousel nodes extend to ~5298px (`scrollWidth` inflation). Visible layout OK; qa_probe overflow false at 1440 for home. Pre-Wave-A carousel pattern — **noise** unless strict overflow gate applies site-wide. |

### Out of scope

| id | note |
|----|------|
| **WAF-O01** | WP-EI-05 draft banner on legal pages — unchanged by design |
| **WAF-O02** | Lorem / placeholder copy on home video block — content, not Wave A |
| **WAF-O03** | `/about/moksha/` `/workshops/` HTTP 301 to canonical slugs — live 200 after redirect; nav uses canonical URLs |

### INTENTIONAL

| id | note |
|----|------|
| **WAF-I01** | `.nav__wm` hidden at 1280×800 (`display:none`, `wmVisible:false`) — per contract 1081–1499 band |
| **WAF-I02** | Float `.ea-whatsapp-float` on `/` `/shop/` `/repair/` `/didgeridoos/` — contract only forbids float on `/contact/` |

---

## Passes (Wave A contract)

| id | item | URL | viewport | note | verdict |
|----|------|-----|----------|------|---------|
| WA-P01 | 1 | `/` | 1920×1080 | Wordmark «המרכז לטיפול בדיג׳רידו» visible (`wmVisible:true`, w≈118px) | **PASS** |
| WA-P02 | 1 | `/` | 1280×800 | Wordmark hidden (`display:none`) | **INTENTIONAL** |
| WA-P03 | 1 | `/` | 390×844 | Header shows wordmark beside mark; drawer brand link «המרכז לטיפול בדיג׳רידו» | **PASS** |
| WA-P04 | 1 | `/` | 1440×900 | L1 single row in visual check; «אייל עמית» menu item present | **PASS** |
| WA-P05 | 6 | `/` | 1440×900 | Footer: «בלוג דיג׳רידו»→`/blog/`, «ספרים – מוזה…»→`/books/`, «כלים ואביזרים»→`/shop/`, «לימוד והכשרה»→`/learning/` | **PASS** |
| WA-P06 | 6 | `/contact/` | 1440×900 | Same four footer labels + URLs | **PASS** |
| WA-P07 | 10 | `/contact/` | 1440×900 | **1** visible `wa.me`; `.ea-whatsapp-float` absent (`float:false`) | **PASS** |
| WA-P08 | 15 | `/` | 1440×900 + 390 drawer | L2 «תיקון וחידוש כלי דיג׳רידו» desktop dropdown + mobile drawer (`e174`) | **PASS** |
| WA-P09 | 15 | `/repair/` `/en/` `/didgeridoos/` | HTML | Old «תיקון וחידוש כלים» **0** in nav HTML | **PASS** |
| WA-P10 | 16 | `/lessons/` | 390×844 | `h1Top:88`, `navBottom:72`, `gap:+16`, `overlap:false` | **PASS** |
| WA-P11 | 16 | `/treatment/` | 390×844 | `h1Top:425.9`, `navBottom:72`, `gap:+353.9`, `overlap:false` | **PASS** |
| WA-P12 | 16 | `/sound-healing/` | 390×844 | qa_probe rendered; same 610 overflow as siblings but **no overlap measured** (builder + same CSS family as lessons) | **PASS** (overlap) |
| WA-P13 | 7 | `/privacy/` | HTML | Stale phrase «אין באנר הסכמה נפרד באתר כרגע» **absent** | **PASS** |
| WA-P14 | 7 | `/` | DOM | `<dialog id="ea-cookie-notice">` shipped in `inc/ea-cookie-notice.php`; copy «הבנתי» in JS | **PASS** (presence) |
| WA-P15 | similar | `/tools-and-accessories/repair/` | HTTP | 301 → `/repair/` (200); **0** old slug links in home HTML | **PASS** |
| WA-P16 | similar | `/` `/shop/` `/repair/` | HTML | Single float wa.me only (not `/en/`) | **PASS** |
| WA-P17 | — | all required URLs | HTTP | Required paths return 200 (or 301→200 for moksha/workshops/old repair) | **PASS** |
| WA-P18 | — | `/` | 768×1024 | qa_probe: no overflow | **PASS** |
| WA-P19 | — | `/repair/` `/about/` | 390×844 | qa_probe: no overflow (non-phero templates) | **PASS** |
| WA-P20 | — | theme | — | `style.css?ver=1.5.96` on live HTML | **PASS** |

**Pass count (contract + intentional): 20** (includes WA-P02 intentional hide).

Full qa_probe matrix (90 cells): [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/qa_probe_result.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/qa_probe_result.json) · screenshots under [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/screenshots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/screenshots/).

---

## CDP samples (representative)

### Item 1 — wordmark 1920

```json
{"vp":[1920,1080],"wmText":"המרכז לטיפול בדיג׳רידו","wmVisible":true,"wmDisplay":"block"}
```

Screenshot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/home-1920x1080-wordmark.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/home-1920x1080-wordmark.png)

### Item 10 — contact WhatsApp 1440

```json
{"waVisibleCount":1,"float":false,"waText":"דברו איתי בוואטסאפ"}
```

Screenshot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/contact-1440x900-wa.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/contact-1440x900-wa.png)

### Item 16 — lessons hero 390

```json
{"path":"/lessons/","h1Top":88,"navBottom":72,"gap":16,"overlap":false,"sw":610,"cw":390}
```

Screenshot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/lessons-390x844-phero-v2.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/lessons-390x844-phero-v2.png)

### Item 15 — mobile drawer repair L2

Drawer open snapshot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/mobile390-drawer-home.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-composer/mobile390-drawer-home.png) — link «תיקון וחידוש כלי דיג׳רידו» visible.

---

## HTTP status (no redirect follow on first hop)

| path | status | final URL (after redirects) |
|------|--------|----------------------------|
| `/` … `/method/` (required) | 200 | same |
| `/about/moksha/` | 301 | `/eyal-amit/mokesh-dahiman/` |
| `/workshops/` | 301 | `/learning/workshops/` |
| `/tools-and-accessories/repair/` | 301 | `/repair/` |

---

## Triage for Team 10

1. **WAF-01** — Update `/shop/` catalog copy + bookcard title/alt to «תיקון וחידוש כלי דיג׳רידו» (content/template, not nav PHP).
2. **WAF-02** — Investigate 610px `scrollWidth` on all `.phero--media` at ≤390: CDP offender hunt on closed `.ea-nd` / hero padding; consider `overflow-x: clip` on `html` or fix root cause.
3. **WAF-03** — `/en/` Wave2 template: dedupe wa.me (page CTAs vs float) — Wave B or hotfix if Eyal uses EN staging.

---

## confirmed misses vs suspected vs out of scope

| bucket | ids |
|--------|-----|
| **Confirmed MISS** | WAF-01, WAF-02, WAF-03 |
| **Suspected / partial** | WAF-S01 (cookie dismiss cycle), WAF-S02 (home carousel scrollWidth at 1440) |
| **Out of scope** | WAF-O01, WAF-O02, WAF-O03 |
| **Intentional pass** | WAF-I01, WAF-I02 |

---

*Composer attack QA · theme 1.5.96 · no repo edits · evidence under `tmp/qa/wave-a-composer/` (not committed).*
