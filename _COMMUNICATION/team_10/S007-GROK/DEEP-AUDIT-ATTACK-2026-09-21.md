# בקרת מערכת מעמיקה — צוות 10 Attack · 2026-09-21

**זהות:** צוות 10 · תוקף/מודד בלבד · אין יישום, אין FTP, אין חתימת QA (50), אין החלטת מוצר (100).  
**סטייג'ינג:** [http://eyalamit-co-il-2026.s887.upress.link](http://eyalamit-co-il-2026.s887.upress.link) (HTTP; TLS לא תקין בכוונה — לא באג).  
**תמה חיה:** `ea-eyalamit` **1.5.99** (`style.css?ver=1.5.99` + sibling CSS/JS `?ver=1.5.99`) — שער **PASS**.  
**מנוע מדידה:** Cursor Grok (MCP browser, tab `a2f5d0`) + `chrome-headless-shell` 149 על פורט 9444. **לא** Chrome.app — נסגר אחרי קריסה בסשן; לא הופעל מחדש.  
**רף מחייב:** ת״י 5568 = WCAG 2.0 AA. 2.1/2.2 ו־axe/LH = עזר בלבד.  
**מפה:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv)  
**תוכנית:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/PLAN-S007-DEEP-AUDIT-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/PLAN-S007-DEEP-AUDIT-2026-09-21.md)  
**ראיות (לא Git):** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/)  
**CDP JSON:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/cdp-probe.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/cdp-probe.json)  
**מפקד 157:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/census-157.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/census-157.json)

---

## סיכום לנימרוד

שער התמה **1.5.99** חי. מפקד 157: **141×200 / 16×301 / 0×4xx-5xx**. רגרסיית גלילה אופקית WAF-02 **לא חזרה** — 20/20 `.phero--media` ב־390 `ov=false sw=390`. סרגל 88→56, מרווח H1 ב־`/lessons/` 50.2≥16, `/contact/` בלי צף, CMP שני כפתורים במסך, viewport בלי `user-scalable=no`.

**תקלות שאושרו במדידה + תצפית בעלים (2026-09-21):** כפתור וואטסאפ קבוע שמאל, 54×54. סרגל מובייל לא אחיד (4 כרומים). עברית: תפריט משמאל / לוגו מימין. לוגו טקסט ולא סמל ב־GP/EN. **כפתור EN במובייל עצמאי בכותרת** (`.nav__en` 47×35) למרות שכבר יש EN בתוך המגירה (`.ea-nd__pill`). בבית: Lorem. P2-A2/A3/A4 עדיין חיים.

VoiceOver, axe/Lighthouse, ניגודיות P2-A5 וגזירת פוקוס P2-A6 — **לא נסגרו** בסשן זה (Chrome.app לא הופעל מחדש).

---

## Findings (English)

### Confirmed MISS

| id | severity | criterion | binding 2.0 AA | URL | viewport | expected vs actual | breaks | evidence | verdict |
|----|----------|-----------|----------------|-----|----------|-------------------|--------|----------|---------|
| **DA-WA-01** | P2 visual/UX (owner-reported 2026-09-21, then measured) | Product chrome: float should sit on the reading-safe side, stay subtle on mobile, with a tight icon-in-circle; must not compete with hero CTA / body text | **no** (not a WCAG 2.0 SC; 44px floor is 2.5.5 AAA helper) | sitewide float except `/contact/` — measured `/` `/lessons/` `/shop/`; probe 54×54 on all other family URLs that have the float | **390×844** (also 414/768 probe size 54×54) | Not locked to physical left; smaller/more delicate on mobile; more icon-to-circle tightness; must not sit in the primary CTA row | Live: `left:22px` (`cssLeft=22px`, `getBoundingClientRect().left=22`) on RTL pages. Size **54.1–54.2 × 54.1–54.2**. Icon **25×25**, padX **~14.5px**. Background `rgba(14,9,5,.82)` glass circle, green glyph `#25D366`. `/lessons/` 390: float band top 768–822 vs primary CTA «לתיאום שיעור ראשון» top 766–822, left 147–342 — **same row**, no geometric overlap but shares the hero bottom chrome. `/` 390: overlays the hero photo next to carousel chevrons + mute. Probe: float present 54×54 on every family URL except `/contact/` (`float:false`, `waN:1`). | MCP CDP + shots: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/wa-float-home-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/wa-float-home-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/wa-float-lessons-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/wa-float-lessons-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/wa-float-shop-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/wa-float-shop-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/wa-float-measure.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/wa-float-measure.json) | **MISS** |
| **DA-NAV-01** | P2 visual/RTL (owner-reported 2026-09-21, then measured) | Mobile header sides: menu on the **right**, logo on the **left** | **no** | Hebrew Chapters `/shop/` (same chrome as `/` `/lessons/`); GP `/about/`; contrast `/en/` | **390×844** | RTL mobile: burger/menu at physical **right**; logo at physical **left** | Hebrew live is the **inverse** of the owner call (LTR chrome on `dir=rtl`): `/shop/` burger left **44–88**, EN 113–160, mark right **306–346**. `/about/` screenshot: hamburger **left**, «eyal amit» **right**. `/en/` (`dir=ltr`) already has burger right **332–376** and brand left **24–104** — sides match the sentence, but the burger **overlaps** «עברית →» (lang 315–366 vs burger 332–376). Note: Wave A / Team 35 (2026-06) had specified brand-right + burger-left; this 2026-09-21 owner call **contradicts** that older brief. Attack records the new call vs live. | Shots: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-shop-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-shop-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-about-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-about-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-en-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-en-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/nav-rtl-logo-measure.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/nav-rtl-logo-measure.json) | **MISS** |
| **DA-LOGO-01** | P2 visual/brand (owner-reported 2026-09-21, then measured) | Logo slot = **mark/symbol only**, never the text «eyal amit» | **no** | `/about/` `/press/` (GP site title); Chapters `.nav__wm`; `/en/` `.ea-en-head__b` | **390×844** (GP/EN also at other widths) | Always `ea-logo-mark` (or equivalent symbol). No «eyal amit» / «Eyal Amit» word as the logo. | `/about/`: no `<img>` logo; `.main-title` text **«eyal amit»** at left 253–360, plus tagline «המרכז לטיפול בדיג׳רידו». `/shop/` Chapters: mark **is** present 40×40, **and** `.nav__wm` «המרכז לטיפול בדיג׳רידו» still visible (`display:block` at 390; Wave A WA-P03 had **passed** wordmark-beside-mark at 390 — this owner call **supersedes** that as the desired mobile chrome). `/en/`: text **«Eyal Amit»** only, no mark. | Same shots + JSON as DA-NAV-01 | **MISS** |
| **DA-NAV-02** | P2 visual (owner expansion 2026-09-21 of DA-NAV-01/DA-LOGO-01) | Mobile top chrome must be **one fixed header on every page** — not a different bar per template family | **no** | 16-family sample at 390 (home eval once failed; remaining 15 parsed) | **390×844** | Same header shell sitewide: same height, same sides, same logo treatment, same EN/burger | **4 distinct live fingerprints** (plus home CMP `not-string`). **A. Chapters** `nav\|burgerL\|mark\|wm\|noTextBrand\|en` — 11 URLs (`/lessons/` `/shop/` `/repair/` `/contact/` `/faq/` `/learning/therapist-training/` `/books/tsva-bekahol/` `/blog/` `/2228-2/` `/qr/qr1/` `/eyal-amit/mokesh-dahiman/`): `navH=88`, transparent dark, burger left 44, mark 40px + wordmark, EN pill. **B. GP about/press** `site-header…\|burgerL\|noMark\|wm\|textBrand\|noEn` — `/about/` `/press/`: `navH=85`, **white** `rgb(255,255,255)`, burger left 14, **no mark**, text brand «eyal amit», no EN. **C. GP courses-external** `…\|noMark\|noWm\|textBrand\|noEn` — `/learning/courses-external/`: `navH=70`, white, burger left 14, text «eyal amit», no wordmark, no EN. **D. EN** `ea-en-head\|burgerR\|noMark\|noWm\|textBrand\|en` — `/en/`: `navH=70`, burger **right** 332, text «Eyal Amit», lang link overlaps burger. | JSON: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/header-chrome-390.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/header-chrome-390.json) · clips: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/header/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/header/) · MCP: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-shop-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-shop-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-about-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-about-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-chrome-press-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-chrome-press-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-en-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/nav-rtl-en-390.png) | **MISS** |
| **DA-NAV-03** | P2 visual (owner-reported 2026-09-21) | Mobile English control lives **inside the menu**, not as a standalone header chip | **no** | Chapters header (11 sampled URLs with `.nav__en` visible); `/lessons/` drawer walk | **390×844** | Header has burger + logo only. EN is a drawer item (already shipped as `.ea-nd__pill`). | Live duplicate: header `.nav__en` **visible** at left **112.7**, 47×35, `display:block` while drawer closed. Drawer already contains `.ea-nd__pill` EN (hidden until open: w=0). After burger click: drawer EN visible at left **265.6** top **686.6**, 45.8×44 — **and** header `.nav__en` stays vis=true. Header census: EN chip on all Chapters paths; **absent** from GP `/about/` `/press/` `/learning/courses-external/` (those pages have no header EN at all — another chrome split). `/en/` header shows «עברית →» as a standalone lang control (overlaps burger, DA-NAV-01). | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/en-standalone-header-lessons-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/en-standalone-header-lessons-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/en-inside-drawer-lessons-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/en-inside-drawer-lessons-390.png) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/en-header-vs-drawer-390.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/en-header-vs-drawer-390.json) | **MISS** |
| **DA-P1-01** | P1 content | Census forbidden term `Lorem` (plan Layer A) | **no** (content, not WCAG) | `/` | all | No placeholder / Lorem in published HTML | Visible home video block: «Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.» + «כאן ייכנס וידאו 16:9». Census `forbidden: [{path:'/', terms:['Lorem']}]`. MCP snapshot heading «וידאו» refs e73/e74. | [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/census-157.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/census-157.json) · MCP `/` snapshot 2026-09-21 | **MISS** |
| **DA-P2-A2** | P2 a11y (open package, remasured live) | SC 3.1.2 Language of Parts | **yes** | `/en/` | 390 / 768 / 1440 | Hebrew runs on `lang=en` marked `lang=he` | `html lang=en dir=ltr` correct. Probe `heRuns` still include unmarked Hebrew: «טיפול בדיג׳רידו», «נחירות ודום נשימה בשינה», «השיטה», «שיעורי דיג׳רידו», «סאונד הילינג», «הכשרות למטפלים» (capped at 6). Float accessible name still Hebrew «שלח הודעה בוואטסאפ». `waN=2` (in-page + float). | `cdp-probe.json` family `/en/` ×3 · MCP earlier `/en/` walk | **MISS** |
| **DA-P2-A3** | P2 a11y (open package, remasured live) | SC 1.1.1 Non-text Content | **yes** | `/` (section `.st3`; same pattern expected on treatment/method) | 768 / 1440 (home 390 family eval failed once) | Decorative step SVGs `aria-hidden=true` | Probe `/` : `st3=3`, parent `DIV`, `st3aria: [null,null,null,null,null,null]`. | `cdp-probe.json` extra/family `/` | **MISS** |
| **DA-P2-A4** | P2 a11y (open package, remasured live) | SC 1.3.1 Info and Relationships | **yes** | `/` | 768 / 1440 | How-to-start steps exposed as a list | `st3=3` sibling `DIV`s, not `ul/ol` / `role=list`. | `cdp-probe.json` family `/` | **MISS** |
| **DA-P2-05** | P2 quality (P2-B2 remasured; not a 2.4.2 fail) | SC 2.4.2 Page Titled — title *identifies* the page, admin wording is quality | **no** (package B2: not a failure) | `/shop/` | all | Visitor-facing title | Live `<title>` «עמוד קטלוג ראשי - eyal amit». H1 «כלים בעבודת יד ואביזרים». Old body string «תיקון וחידוש כלים» = **0** (Wave A WAF-01 closed). | MCP `/shop/` snapshot; probe `title` | **MISS** (quality only) |
| **DA-P2-06** | P2 similar sibling to WAF-03 | Hunt: stacked `wa.me` | **no** | `/2228-2/` (blog post) | all family VPs | One visible WA pattern unless page is contact | Probe `waN=2` + float 54×54 (in-post link + site float). `/en/` also `waN=2` (already DA-P2-A2). | `cdp-probe.json` family `/2228-2/` | **MISS** |

**P0:** none. Theme gate held. No 4xx/5xx on the 157 GET census.

### PASS (measured this session)

| id | item | URL | viewport | note | verdict |
|----|------|-----|----------|------|---------|
| DA-P01 | Theme version | all 141 HTTP 200 | — | Child `1.5.99` in `child_vers`. `ver_bad_200=[]`. | **PASS** |
| DA-P02 | Census HTTP | 157 TSV rows | — | 141×200, 16×301 canonical aliases, 0×4xx/5xx. GET without `-L`. | **PASS** |
| DA-P03 | WAF-02 overflow regression | 20 `.phero--media` paths + family 390 | **390** | All `ov=false` `sw=390`. Home 390 family eval once `not-string`; **re-PASS** on mobile loop `/` 390 `ov=false sw=390`. | **PASS** |
| DA-P04 | Nav rest / scrolled | `/` `/lessons/` `/method/` `/contact/` `/shop/` `/qr/qr1/` `/books/tsva-bekahol/` `/learning/therapist-training/` | 390 / 414 / 768 | `navRest=88` `navScrolled=56` after `scrollTo(0,400)`. `/en/` has no `.nav` (`navH=null`) — GP. | **PASS** |
| DA-P05 | H1 vs nav gap | `/lessons/` | 390 | `gap=50.2` `overlap=false` (contract ≥16). Other chapters gaps 74–581, none overlapping. | **PASS** |
| DA-P06 | Crumbs | `/lessons/` `/shop/` `/contact/` `/method/` | 390 | Present; home / EN / QR **no crumbs** (contract). `/about/` no crumbs. `/press/` crumbs «בית עיתונות». | **PASS** |
| DA-P07 | nowrap cbDIDG | `/lessons/` `/method/` `/` | 390–1440 | `.ea-nowrap` «שיטת cbDIDG» `white-space:nowrap`; height 48–65, not a clip flag in probe. Visual `/lessons/` 390: phrase visible in hero. | **PASS** |
| DA-P08 | `/contact/` float + form | `/contact/` | 390 / 768 / 1440 | `float=false` `waN=1` `unlabeled=[]` `h1n=1` skip `#main`. MCP: wrapping `<label>`s; tel `+972524822842`. | **PASS** |
| DA-P09 | CMP first visit | `/` | 390 | `<dialog id="ea-cookie-notice" open>`: privacy link + «אישור מדידה» + «המשך בלי מדידה», all `in:true` (inside viewport). `ov=false`. Shot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/cmp-home-390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/cmp-home-390.png). MCP: Esc leaves dialog open; reject dismisses. | **PASS** |
| DA-P10 | Skip link | `/` `/lessons/` `/contact/` `/faq/` | 390 | `.ea-skiplink` `href=#main` in DOM. MCP: programmatic focus+click lands `MAIN#main` (element is 40px above viewport until focused — expected clip-until-focus). | **PASS** |
| DA-P11 | Viewport meta | family + mobile set | 390–1440 | `width=device-width, initial-scale=1`. `noScale=false` (no `user-scalable=no` / `maximum-scale=1`). | **PASS** |
| DA-P12 | P2-A1 `href="#"` קורסים | home / shop / faq HTML + probe `hashCourses` | all | **0** matches live. | **PASS** (closed vs 17.9 package) |
| DA-P13 | Shop old L2 copy in body | `/shop/` | all | «תיקון וחידוש כלים» = 0; «כלי דיג׳רידו» present. WAF-01 closed. | **PASS** |
| DA-P14 | FAQ semantics | `/faq/` | 390 MCP | Native `<details><summary>` (133); `aria-expanded` null is OK for details. Skip + crumbs present. | **PASS** |
| DA-P15 | Drawer a11y (MCP, not headless selector) | `/lessons/` `/` | 390 | Burger name «תפריט», `aria-expanded` collapsed→expanded in a11y tree. Headless probe burger selector `.nav__burger,.nav__b` returned `null` — CDP drawer extra **not** used as PASS. | **PASS** (MCP only) |
| DA-P16 | Zoom 200% helper | `/` `/lessons/` `/contact/` | 390 + `setPageScaleFactor(2)` | `ov=false` `sw=390` `overlap=false`. Helper only (not 1.4.4 full reflow proof). | **PASS** (helper) |
| DA-P17 | Probe network | session CDP | — | `failed=[]` `exceptions=[]` on captured events. | **PASS** (this session) |
| DA-P18 | `/privacy/` CMP copy | `/privacy/` | HTML/MCP | Phrase «ניתן לאשר או לדחות מדידה» present. WP-EI-05 draft banner out of scope. | **PASS** (copy) |
| DA-P19 | QR no crumbs + H1 present | `/qr/qr1/` `/qr/qr48/` | 390–1440 | `crumb=false` `h1n=1` `float=true 54×54`. Visual `/qr/qr1/` shot in evidence dir. DOM H1 strings are odd mixed bidi («והקדמת – qr1», «qr48 -וסיימת») — see suspected. | **PASS** (no-crumb contract) |

### INTENTIONAL / out of scope

| id | note |
|----|------|
| **DA-I01** | `https://www.eyalamit.co.il/` parking on `/learning/courses-external/` — Wave B intentional (2× production). 14 other www hits are `db-post-content` in posts, not theme chrome. |
| **DA-I02** | 16× HTTP 301 = canonical aliases (`/muzeh/`→`/books/`, `/hashita/`→`/method/`, `/about/moksha/`→`/eyal-amit/mokesh-dahiman/`, …). Live 200 after follow is out of this GET-no-`-L` census. |
| **DA-O01** | WP-EI-05 draft banner on legal / EN — unchanged by design. |
| **DA-O02** | Staging TLS invalid — not a defect. |
| **DA-O03** | P2-B1 / B3 / B4 not re-litigated as compliance. B3 `/en/` is a self-contained landing (still has DA-P2-A2). |

### Suspected (not ship-blocker / not fully closed)

| id | note |
|----|------|
| **DA-S01** | `/about/` MCP a11y tree: **two** skip links (`.ea-skiplink` «דלג לתוכן» `#main` + GP `skip-link` «לדלג לתוכן» `#content`). Probe only records the first `#main`. Duplicate skip is quality, not a 2.4.1 fail. GeneratePress credit still in footer. |
| **DA-S02** | QR H1 `textContent` «והקדמת – qr1» / «qr48 -וסיימת» — mixed bidi. Screenshot `/qr/qr1/` exists; full readability vs printed QR promise **not** re-read as a user holding the card. |
| **DA-S03** | `/learning/courses-external/` skip `href=#content` (not `#main`) — other family is `#main`. |
| **DA-S04** | Touch targets `<44px` ubiquitous (`smallN` capped at 12/page: skip 37px, EN 35px, crumb «בית» 22×22). **Not WCAG 2.0 AA.** Helper 2.5.5 / 2.5.8 only. |
| **DA-S05** | Headless drawer shot / `burgerExp=null` — selector miss. Do not treat CDP drawer extra as evidence either way. |
| **DA-S06** | Home 390 **family** loop `ERR=not-string` (likely CMP still open when first eval ran). Later mobile loop on `/` 390 succeeded. |

---

## Layer A — census 157

GET, no follow-redirects, browser UA. JSON: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/census-157.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/census-157.json).

| metric | value |
|--------|-------|
| rows | 157 |
| HTTP 200 | 141 — all `child_vers` contain **1.5.99** |
| HTTP 301 | 16 — aliases listed in JSON `redirects` |
| 4xx / 5xx | **0** |
| forbidden term | **1** — `/` Lorem (**DA-P1-01**) |
| `.phero--media` HTML | 23 paths (incl. `/en/`) |
| `www.eyalamit.co.il` pages | 15 — 1 parking (`/learning/courses-external/`), 14 `db-post-content` |

First census attempt from the sandbox returned **403×157** (WAF). Re-run with full network: numbers above.

---

## Layer B — visual (390 / 768 / 1440)

Family probe: 21 paths × 3 viewports = 63 records (home 390 missing parsed metrics). Representative shots under [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/deep-audit-2026-09-21/shots/).

MCP visual (Cursor tab, Emulation 390): `/` `/lessons/` `/shop/` `/contact/` `/faq/` `/about/` `/qr/qr1/` `/en/` (earlier in session). `/press/` MCP CDP threw `Cannot read properties of null (reading 'split')` — **headless family still measured `/press/`** `ov=false` `h1n=1` `float 54×54` at 390/768/1440.

Tint-vs-footer Wave B contract: **not independently re-scored** this session (see prior [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-B-TINT-VERIFY-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-B-TINT-VERIFY-2026-09-21.md)).

---

## Layer C — accessibility (deep)

**Keyboard (MCP, partial):**

| page | done | result |
|------|------|--------|
| `/` | skip (JS activate), CMP Tab/Esc/reject, sample links | skip→`#main` PASS; CMP Esc keeps dialog open PASS; reject dismisses |
| `/lessons/` | burger, crumbs, skip | drawer `aria-expanded` PASS; crumbs wrap PASS |
| `/contact/` | labels, skip, no float | PASS |
| `/faq/` | details/summary sample | PASS native disclosure |
| `/shop/` `/privacy/` `/en/` `/qr/qr1/` | visual + DOM, **not** full Tab order | incomplete |

**VoiceOver `/` + `/contact/`:** **NEED-HUMAN** — not enabled on this Mac.

**P2 open package** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/A11Y-P2-OPEN-PACKAGE.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/A11Y-P2-OPEN-PACKAGE.md) remasured live:

| item | live 2026-09-21 |
|------|-----------------|
| A1 `#` קורסים | **gone** (PASS) |
| A2 EN Hebrew unmarked | **still live** (MISS) |
| A3 st3 aria-hidden | **still live** (MISS) |
| A4 st3 not a list | **still live** (MISS) |
| A5 contrast near-misses | **not remasured** (NEED-HUMAN / next engine) |
| A6 focus clip `.bookcard`/`.rcard` | **not remasured** |

**axe / Lighthouse:** not run. `scripts/qa/http-qa-axe.cjs` launches Chrome.app — forbidden after the crash. A clean scan would not have been PASS anyway.

---

## Layer D — mobile deep (390 / 414 / 768)

9 paths × 3 viewports = 27 mobile records in `cdp-probe.json`.

| check | result |
|-------|--------|
| overflow after CMP dismiss | `ov=false` matching `sw` to width on all 27 |
| nav 88 rest / 56 scrolled | PASS on Chapters paths; EN/GP `navH=null` |
| `/lessons/` gap ≥16 | 50.2 at 390/414; 272 at 768 |
| crumbs wrap | `/lessons/` visual PASS |
| CMP in viewport | PASS (cmpBtns all `in:true`) |
| WA vs CTA | **MISS DA-WA-01** — same bottom row on `/lessons/` 390 |
| `/contact/` no float | PASS |
| no `user-scalable=no` | PASS |
| QR readable | H1 present; bidi string suspected (DA-S02) |
| 44px helper | many sub-44 controls (DA-S04), not 2.0 AA |

---

## Console / network

Headless session `Network.enable` + `Runtime.exceptionThrown`: **0** HTTP ≥400, **0** exceptions in the captured event buffer.

Not a substitute for DevTools on Chrome.app (not relaunched).

---

## מה לא נבדק / NEED-HUMAN

1. **VoiceOver** על `/` ו־`/contact/` — אל תפעילו VO על המק של נימרוד בלי בקשה.  
2. **axe-core + Lighthouse a11y** — תלוי Chrome.app; נחסם אחרי הקריסה.  
3. **מקלדת מלאה** ל־`/shop/` `/privacy/` `/en/` `/qr/qr1/` (רק DOM/ויזואלי).  
4. **P2-A5 ניגודיות** ו־**P2-A6 גזירת פוקוס** — לא נמדדו מחדש חי.  
5. **Wave B tint-vs-footer** — לא ניקוד חוזר בסשן זה.  
6. **`/press/` MCP** — כשל CDP בטאב; יש מדידת headless בלבד.  
7. **בית 390 family-loop** — eval `not-string` פעם אחת; הושלם בלופ המובייל.

---

## MISS counts (for the closing note)

| severity | count | ids |
|----------|-------|-----|
| P0 | **0** | — |
| P1 | **1** | DA-P1-01 (Lorem `/`) |
| P2 | **10** | DA-WA-01, DA-NAV-01, DA-NAV-02, DA-NAV-03, DA-LOGO-01, DA-P2-A2, DA-P2-A3, DA-P2-A4, DA-P2-05 (quality), DA-P2-06 |
| binding WCAG 2.0 AA among those | **3** | A2, A3, A4 |

Owner visual calls this session: **DA-WA-01**, **DA-NAV-01**, **DA-NAV-02**, **DA-NAV-03**, **DA-LOGO-01** (none are WCAG 2.0 AA).
