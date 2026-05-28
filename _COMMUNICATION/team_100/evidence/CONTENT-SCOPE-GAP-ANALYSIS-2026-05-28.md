# Content Scope Gap Analysis — Eyal 25.5.26 vs Wave2 WPs
**Date:** 2026-05-28
**Auditor:** team_100 sub-agent (Sonnet)
**Eyal content folder:** docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/
**WP source:** _COMMUNICATION/team_100/WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md

---

## 1. Complete Content Inventory (Eyal 25.5.26)

16 items total (15 .md files + 1 .docx). All folders enumerated below.

| # | Folder | File | Page type |
|---|--------|------|-----------|
| 1 | דף הבית | homepage1-3 v2.md | Home |
| 2 | דף FAQ | FAQ FINAL.md | FAQ (unified, 4 categories, ~36 Qs) |
| 3 | השיטה | method.md | Service/method page |
| 4 | טיפול בדיג'רידו | treatment.md | Service page |
| 5 | סאונדהילינג | sound_healing_final.md | Service page |
| 6 | שיעורי נגינה | lesons.md | Service page |
| 7 | מוזה הוצאה לאור - ספרים | MUZZA.md | Books catalogue (publisher page) |
| 8 | וכתבת | vekatavta.md | Individual book detail |
| 9 | כושי בלאנטיס | kushi_full.md | Individual book detail |
| 10 | צבע בכחול וזרוק לים | eyal_tsva_FINAL.md | Individual book detail |
| 11 | כלים למכירה | buy didgeridoo.md | Shop product |
| 12 | תיקים לדיג'רידו | bags for didg.md | Shop product |
| 13 | סטנדים לדיג'רידו לאחסון | stend for hanging.md | Shop product |
| 14 | סטנד רצפתי לנגינה בישיבה נמוכה | stend for playing.md | Shop product |
| 15 | תיקון כלי דיג'רידו | build didg.md | Service (repair) |
| 16 | מוקש דהימן | ומה היום.docx | Background asset (not a standalone page) |

**Content areas NOT submitted (expected from other sources):**
- אודות אייל (`/about`) — migration 1:1 from legacy site (per Q10/E1)
- כתבות עיתונות (`/press`) — extraction from legacy site (per Q11/D5)
- 49 עמודי QR (`/qr/qr1/`..`/qr/qr49/`) — migration 1:1 from legacy site
- בלוג (54 posts) — migration 1:1 from legacy site (per D3)
- עמוד EN (`/en`) — new content, team-authored

---

## 2. Manifest File Summaries

### INDEX-CONTENT-2026-05-25.md
Maps all 16 items to site-tree pageIds and proposed slugs. Notes that 4 content areas (וכתבת, כושי בלאנטיס, צבע בכחול, מוזה) had April 2026 predecessor packages now superseded. No media files included in the submission — confirmed blocker for pixel implementation. Recommends canonical package split into 16 `EYAL-CONTENT-PKG-2026-05-25-<slug>/` units.

### MEETING-DECISIONS-2026-05-26.md
Records 21 closed decisions from Eyal+Nimrod session. Key decisions relevant to gap analysis:
- **Q2:** No separate `/books/bundle` page — bundle is a block inside `/books` (מוזה page). Confirmed 1 catalogue + 3 individual book pages.
- **Q3:** 5 shop pages + repair are IN scope and require `site-tree.json` addition (they were not in sitemap v2.3).
- **Q5:** Moksh doc → assigned to `/about/moksha` (sub-page, not a standalone top-level page). **E2** revised this to a dedicated URL `/about/moksha`.
- **D2:** EN page is IN Wave2 scope (not deferred).
- **D3:** Full blog migration (all 54 posts) is IN scope.
- **E1:** 25.5.26 files = SSOT; anything missing → 1:1 from legacy site.

### QUESTIONS-AND-GAPS-2026-05-26.md
Pre-meeting gap list: Hero A/B/C choice, bundle page, shop IA, FAQ duplication, Moksh placement, delta vs April packages, media absence (all pages), meta-data absence, operational gaps (forms, social links). Most closed in the meeting. Residual open: media files (all 16 pages), Green Invoice links for books/shop.

### OPEN-QUESTIONS-FINAL-2026-05-26.md
21 operational sub-questions (A–F), all closed by Eyal in same session. Confirmed: WhatsApp CTA A/B/C test, contact form fields (CF7), Green Invoice payment flow for shop and books, media sourcing from Eyal, blog migration all 54 posts, press extraction from legacy site.

---

## 3. WP Scope Summary (Wave2 W2-01 through W2-09)

| WP | Name | Pages IN scope | Key OUT |
|----|------|---------------|---------|
| W2-01 | תשתית עיצוב D-14 + טופס + פוטר + Analytics | Design system, form, footer, analytics — no content pages | All content pages |
| W2-02 | ליבת תוכן | Home, Method, Treatment, About, FAQ, Contact | Books, SH, Lessons, Shop, Blog, Press, EN |
| W2-03 | מוזה + 3 ספרים | /books (catalogue) + /books/vekatavta, /books/kushi-blantis, /books/tsva-bekahol | Additional books (none exist) |
| W2-04 | סאונד הילינג + שיעורי נגינה | /sound-healing, /lessons | Treatment (W2-02), Method (W2-02) |
| W2-05 | שופ: 4 מוצרים + תיקון + /shop | /didgeridoos, /bags, /stands-storage, /stand-floor, /repair, /shop catalogue | WooCommerce, new products |
| W2-06 | בלוג | 54 posts, 6 categories, 126 tags | New blog content |
| W2-07 | כתבות + מוקש + 49 QR + עדויות FB | /press (or /about section), /about/moksha, /qr/qr1..49, testimonials | Content rewrite |
| W2-08 | עמוד EN | /en (single landing page) | Full site translation, EN blog |
| W2-09 | סינון מדיה + 301 + cutover prep | Media filter, 301 rules, cutover checklist | Cutover execution itself |

---

## 4. Coverage Matrix

| # | Content Area | Implied page | Covered by WP | Explicit in WP scope? | Gap? |
|---|-------------|-------------|--------------|----------------------|------|
| 1 | דף הבית | Home `/` | W2-02 | YES — homepage1-3 v2.md cited by name | No gap |
| 2 | דף FAQ | FAQ `/faq` | W2-02 | YES — FAQ FINAL.md cited by name | No gap |
| 3 | השיטה | Method `/method` | W2-02 | YES — method.md cited by name | No gap |
| 4 | טיפול בדיג'רידו | Service `/treatment` | W2-02 | YES — treatment.md cited by name | No gap |
| 5 | סאונדהילינג | Service `/sound-healing` | W2-04 | YES — sound_healing_final.md cited by name | No gap |
| 6 | שיעורי נגינה | Service `/lessons` | W2-04 | YES — lesons.md cited by name | No gap |
| 7 | מוזה הוצאה לאור - ספרים | Books catalogue `/books` | W2-03 | YES — MUZZA.md cited by name | No gap |
| 8 | וכתבת | Book detail `/books/vekatavta` | W2-03 | YES — vekatavta.md cited by name | No gap |
| 9 | כושי בלאנטיס | Book detail `/books/kushi-blantis` | W2-03 | YES — kushi_full.md cited by name | No gap |
| 10 | צבע בכחול וזרוק לים | Book detail `/books/tsva-bekahol` | W2-03 | YES — eyal_tsva_FINAL.md cited by name | No gap |
| 11 | כלים למכירה | Shop product `/didgeridoos` | W2-05 | YES — buy didgeridoo.md cited by name | No gap |
| 12 | תיקים לדיג'רידו | Shop product `/bags` | W2-05 | YES — bags for didg.md cited by name | No gap |
| 13 | סטנדים לדיג'רידו לאחסון | Shop product `/stands-storage` | W2-05 | YES — stend for hanging.md cited by name | No gap |
| 14 | סטנד רצפתי לנגינה בישיבה נמוכה | Shop product `/stand-floor` | W2-05 | YES — stend for playing.md cited by name | No gap |
| 15 | תיקון כלי דיג'רידו | Service `/repair` | W2-05 | YES — build didg.md cited by name | No gap |
| 16 | מוקש דהימן (ומה היום.docx) | Background asset → `/about/moksha` | W2-07 | YES — ומה היום.docx cited; /about/moksha in scope | No gap |

**Result: All 16 content areas Eyal submitted have a clear WP home. Zero scope gaps (no orphaned content areas).**

---

## 5. WP Claims vs. Eyal Submissions — Content Gap Check

Content areas claimed by WPs that Eyal did NOT submit directly (relying on legacy migration or team authoring):

| WP | Claimed scope not in 25.5.26 | Source | Risk |
|----|------------------------------|--------|------|
| W2-02 | אודות אייל (`/about`) | Legacy site 1:1 migration (Q10/E1) | LOW — explicit decision, clear source |
| W2-06 | בלוג — 54 posts, 6 categories, 126 tags | Legacy site migration (D3) | LOW — explicit decision |
| W2-07 | כתבות עיתונות (`/press`) | Legacy site extraction (Q11/D5) | MEDIUM — "lots of junk in legacy media", filtering required |
| W2-07 | 49 QR pages (`/qr/qr1..49`) | Legacy site migration | LOW — all 49 verified live 200 (2026-05-26) |
| W2-07 | עדויות FB Top 5 | Embedded in 25.5.26 md files, need image-fetch | LOW — text already in files, images need fetch |
| W2-08 | עמוד EN | Team-authored (D2) | MEDIUM — no EN content from Eyal, team writes from scratch |

No WP claims content that is completely unavailable — all gaps have a designated source or authoring plan.

---

## 6. Special Focus Areas

### 6.1 Books — Exact Count

**Eyal submitted content for 3 distinct books + 1 publisher page:**
1. וכתבת (`/books/vekatavta`) — vekatavta.md, 14 blocks
2. כושי בלאנטיס (`/books/kushi-blantis`) — kushi_full.md, 14 blocks
3. צבע בכחול וזרוק לים (`/books/tsva-bekahol`) — eyal_tsva_FINAL.md, 14 blocks
4. מוזה הוצאה לאור — MUZZA.md = publisher/catalogue page (12 blocks), NOT a 4th book

**W2-03 scope:** `/books` (catalogue) + 3 book detail pages. Bundle = block inside `/books`, NOT a separate page (per Q2 decision). **W2-03 scope exactly matches the 3 books + catalogue Eyal sent. No over-claim, no under-claim.**

> Note: `MUZZA.md` includes a bundle block (3-book set), but per Q2 decision this is rendered as a section inside `/books` — no separate `/books/bundle` page required. W2-03 OUT scope explicitly states "no separate bundle page."

### 6.2 Shop Products — Exact Count

**Eyal submitted 5 distinct shop/service items:**
1. כלים למכירה — didgeridoos for sale (`/didgeridoos`)
2. תיקים לדיג'רידו — bags (`/bags`)
3. סטנדים לדיג'רידו לאחסון — storage stands (`/stands-storage`)
4. סטנד רצפתי לנגינה בישיבה נמוכה — floor stand for playing (`/stand-floor`)
5. תיקון כלי דיג'רידו — repair service (`/repair`)

**W2-05 scope:** All 5 above + `/shop` catalogue page = 6 URLs total. **Exact match. No over-claim or under-claim.**

> Important: These 5 pages were NOT in sitemap v2.3 (APPROVED 2026-03-31). Per Q3/MEETING-DECISIONS, their addition to `site-tree.json` is an explicit deliverable of W2-05 (listed in W2-05 תוצרים: "עדכון `site-tree.json` עם 6 נכסים חדשים"). This is tracked, not a gap.

### 6.3 Services — Coverage Check

| Service | Submitted? | WP | Explicit? |
|---------|-----------|-----|-----------|
| השיטה (cbDIDG Method) | YES — method.md | W2-02 | YES |
| טיפול בדיג'רידו (Treatment) | YES — treatment.md | W2-02 | YES |
| סאונד הילינג (Sound Healing) | YES — sound_healing_final.md | W2-04 | YES |
| שיעורי נגינה (Music Lessons) | YES — lesons.md | W2-04 | YES |
| תיקון כלים (Repair) | YES — build didg.md | W2-05 | YES |

All 5 service types covered. No service left without a WP.

### 6.4 מוקש דהימן (Moksh Dahiman)

- **Content:** `ומה היום.docx` — ~1,500 chars on Moksh family 2026 status. Background/context asset.
- **Decision (E2/MEETING-DECISIONS §1.A):** Dedicated sub-page `/about/moksha` with own URL for sharing. Listed in navigation under `/about` only.
- **WP assignment:** W2-07 — explicitly named: "עמוד מוקש דהימן (E2) — תוכן מ-ומה היום.docx + תמונות".
- **Status:** CLEAR. No gap.

### 6.5 וכתבת / Press / Journalism

- **וכתבת** = a book title (Eyal's journalism workbook), NOT press coverage. Assigned to W2-03.
- **כתבות עיתונות** (press clippings) = separate item, NOT submitted in 25.5.26. Decision D5: extract from legacy site. Assigned to W2-07 (`/press` or section in `/about`).
- **No collision:** the word "וכתבת" in the book context and "כתבות" in press context are distinct items in distinct WPs.

---

## 7. Summary Scoreboard

| Metric | Count |
|--------|-------|
| Total content areas Eyal submitted | 16 |
| Content areas with a clear WP home | 16 |
| Scope gaps (content with no WP home) | **0** |
| Content gaps (WP claims content Eyal didn't send) | 6 (all have designated sources — legacy migration or team authoring; none are unresolved) |
| Distinct books submitted | **3** (+ 1 publisher catalogue page) |
| Distinct shop products submitted | **5** (+ 1 catalogue page added by W2-05) |
| WPs covering submitted content | W2-02, W2-03, W2-04, W2-05, W2-07 |
| WPs NOT covering Eyal-submitted content (infra/migration/other) | W2-01, W2-06, W2-08, W2-09 |

---

## 8. Findings and Recommendations

**No blocking scope gaps found.** All 16 content areas Eyal submitted map to exactly one WP with an explicit file-level citation in the WP scope.

**Minor items to watch (not blockers):**

1. **site-tree.json not yet updated** — 5 shop pages + repair were added to scope via Q3 decision but sitemap v2.3 was approved without them. W2-05 deliverables include the `site-tree.json` update — ensure this runs before W2-09.

2. **Media is entirely absent** from the 25.5.26 submission — confirmed in INDEX-CONTENT §2 and QUESTIONS-AND-GAPS §2. Every single page (all 16) is a media blocker. This is not a WP scope gap, but it is an execution risk across W2-02 through W2-07. Mitigation: placeholder assets defined in W2-01/02; actual media expected from Eyal + legacy site.

3. **Green Invoice links for books and shop** — Eyal confirmed mechanism (C1) but actual per-product links not yet received. W2-03 and W2-05 both list this as a pending deliverable from Eyal. Not a scope gap, but a dependency that must arrive before AC-03 can pass in each WP.

4. **Blog migration (W2-06)** — 54 posts rely on legacy WP export. Shortcode-heavy posts (Elementor etc.) flagged as HIGH risk in W2-06. Recommend a quick shortcode audit of legacy posts before W2-06 begins.

5. **Press clippings (W2-07)** — Eyal's warning ("המון זבל שאסור שיעבור") applies to both media AND press. Recommend `usage_count > 0` filter be applied to press items as well, and that press list be shown to Eyal for approval before publication.

---

*Generated by team_100 sub-agent (Sonnet 4.6) — read-only analysis, no files modified.*
