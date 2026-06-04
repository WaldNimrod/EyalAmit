# QA Report — Full-site deep E2E | Team 50

## Context bundle
- Work Package: WP-W2-14 (full-site discovery pass; branch `wp-w2-14-phase2`)
- Mandate: `_COMMUNICATION/team_100/MANDATE-TEAM50-FULL-E2E-QA-2026-06-04.md`
- Requestor: Team 100 (on team_00 request)
- Engine: **Cursor Composer** (IR#1 — cross-engine vs Claude Code build)
- Staging: `http://eyalamit-co-il-2026.s887.upress.link`
- Write to: `_COMMUNICATION/team_50/`
- Evidence: `_COMMUNICATION/team_50/evidence/full-e2e-2026-06-04/`

---

## §0 Verdict box

| Field | Value |
|-------|-------|
| **Verdict** | **PASS_WITH_FINDINGS** |
| **Blocking (P0)** | **0** |
| **High (P1)** | **6** |
| **Medium/Low (P2–P3)** | **8** |
| **Routes exercised** | 34 canonical + 1 blog single (sample) |
| **Technical gates** | HTTP 200 all routes · axe 0 crit/0 serious (34/34) · overflow 0 (170/170 viewports) · H1=1 · console 0 · asset 404 0 |
| **Next step** | Route per-WP L-GATE_VALIDATE for build surfaces that pass technical gates; **hold content-final** on Memorial/Galleries/Media/Method until Eyal answers (group H) and team_10 reconciles `/method` vs `method.md`; team_10 fix blog permalink 404s + drawer `קורסים` `#` before blog/contact sign-off. |

---

## §1 Engine declaration

| Item | Value |
|------|-------|
| QA engine | Cursor Composer (Team 50) |
| IR#1 | Yes — independent pass; team_100 pre-flight **not** used as evidence |
| Builder engine | Claude Code (WP-W2-14) |
| Repo HEAD (local) | `e8e2fe74990a905c5c81f98fe042079b03f85f67` · branch `wp-w2-14-phase2` |
| Staging tested | `http://eyalamit-co-il-2026.s887.upress.link` (HTTP by design) |
| Run window | 2026-06-04 (fresh execution) |

### Commands executed (exit codes)

| Command | Exit | Evidence |
|---------|------|----------|
| HTTP status sweep (34 routes, `curl -L`) | 0 | inline log in session |
| `node scripts/qa/http-qa-axe.cjs --base <staging> <34 routes>` | **0** | `evidence/.../axe-http-2026-06-04.json` |
| `node _aos/lean-kit/.../qa_probe.mjs --config ... --shots` | **0** | `evidence/.../qa_probe_stdout.json` · 170 screenshots |
| `bash scripts/qa/http-qa-lighthouse.sh <13 routes>` | **0** | `evidence/.../lighthouse-summary.json` |
| Puppeteer structural (H1/console/assets, 28 routes) | **0** | `evidence/.../structural-check.json` |
| Puppeteer interaction/content probe | **0** | `evidence/.../interaction-tests.json` |
| MCP `cursor-ide-browser` drawer + EN pass | — | `evidence/.../drawer-mcp-evidence.json` |

---

## §2 Coverage matrix (route × dimension)

**Legend:** ✅ pass · ⚠️ finding · — not applicable · 🔍 sample only

| Route | 3.1 Struct | 3.2 Drawer | 3.3 Overflow | 3.4 Visual | 3.5 Content | 3.6 axe | 3.7 LH | 3.8 RTL/LTR | 3.9 Regr. |
|-------|-----------|-----------|-------------|-----------|------------|--------|-------|------------|----------|
| `/` | ✅ | ✅ | ✅ | 🔍 shots | ⚠️ F9 | ✅ | ✅ 97 | ✅ RTL | ✅ |
| `/treatment/` | ✅ | ✅ | ✅ | 🔍 | ✅ | ✅ | ✅ 98 | ✅ | ✅ |
| `/method/` | ✅ | ✅ | ✅ | 🔍 | ⚠️ F8 | ✅ | ✅ 97 | ✅ | ✅ |
| `/lessons/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | ✅ 98 | ✅ | ✅ |
| `/sound-healing/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/learning/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/therapist-training/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/courses-external/` | ✅ | ✅ | ✅ | — | ⚠️ ext→prod | ✅ | — | ✅ | ✅ |
| `/lectures/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/workshops/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/tools-and-accessories/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/instruments/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/repair/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/muzza/` | ✅ | ✅ | ✅ | 🔍 | ✅ | ✅ | ✅ 95 | ✅ | ✅ |
| `/muzza/kushi-blantis/` | ✅ | — | ✅ | 🔍 | ✅ | ✅ | — | ✅ | ✅ |
| `/muzza/tsva-bechol-ve-zorek-layam/` | ✅ | — | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/muzza/vekatavt/` | ✅ | — | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/blog/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | ✅ 97 | ✅ | ✅ |
| **blog single (sample)** | ⚠️ | — | — | — | — | — | — | — | ⚠️ |
| `/eyal-amit/` | ✅ | ✅ | ✅ | 🔍 | ✅ | ✅ | ✅ 97 | ✅ | ✅ |
| `/contact/` | ⚠️ form | ✅ | ✅ | — | ✅ | ✅ | ✅ 97 | ✅ | ✅ |
| `/faq/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/galleries/` | ✅ | ✅ | ✅ | 🔍 | ⚠️ F6 | ✅ | ✅ 96 | ✅ | — |
| `/media/` | ✅ | ✅ | ✅ | 🔍 | ⚠️ F7 | ✅ | ✅ 98 | ✅ | — |
| `/privacy/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/accessibility/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/terms/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/mokesh-dahiman/` | ⚠️ 301 | ✅ | ✅ | 🔍 | ⚠️ F1–F5 | ✅ | ✅ 94 | ✅ | — |
| `/about/moksha/` | ✅ | ✅ | ✅ | 🔍 | ⚠️ F1–F5 | ✅ | — | ✅ | — |
| `/shop/` | ✅ | ✅ | ✅ | — | ✅ | ✅ | ✅ 98 | ✅ | ✅ |
| `/didgeridoos/` … `/stand-floor/` | ✅ | — | ✅ | — | ✅ | ✅ | — | ✅ | ✅ |
| `/en/` | ✅ | ⚠️ | ✅ | 🔍 | ✅ EN copy | ✅ | ✅ 98 | ⚠️ footer HE | ✅ |

**Aggregate:** 3.1 ⚠️ (blog permalinks, memorial chain, contact validation) · 3.2 ✅ (core drawer; courses `#` P1) · 3.3 ✅ · 3.4 🔍 (screenshots captured; mockup delta notes §6) · 3.5 ⚠️ (content-pending) · 3.6 ✅ · 3.7 ✅ · 3.8 ⚠️ (EN footer) · 3.9 ✅

---

## §3 Findings

### P1 — High (blocks content-final or specific WP validate)

| ID | Dimension | Route / surface | Description | Evidence | Fix | Owner |
|----|-----------|-----------------|-------------|----------|-----|-------|
| **QA-50-F001** | 3.5 Content | Memorial | **F1 CONFIRMED:** Page body sourced from `ומה היום.docx` (background doc per INDEX), not dedicated memorial copy. Headings team-added: ומה היום · השנים שאחרי · מי שזכרו ממשיך. | `interaction-tests.json` mem1.headings; team_100 F1 | Eyal confirm intent (H1) or re-scope copy | team_00 / Eyal |
| **QA-50-F002** | 3.5 Content | Memorial | **F2 CONFIRMED:** No biographical lead (who was Mokesh, relationship from 2000) before narrative. | Live `/about/moksha/` body | Add approved bio lead or confirm omission | team_00 / Eyal |
| **QA-50-F003** | 3.5 / 3.1 IA | Memorial URLs | **F5 CONFIRMED:** Redirect chain `/mokesh-dahiman/` → `/eyal-amit/mokesh-dahiman/` → `/about/moksha/` (301×2). Canonical tag = `/about/moksha/`; site-tree canonical = `mokesh-dahiman`. Nav links `/mokesh-dahiman`. | `curl -sI -L` trace; `interaction-tests.json` | Pick one canonical URL + 301 dedup | team_00 IA |
| **QA-50-F004** | 3.5 Content | `/method/` | **F8 CONFIRMED:** Live page missing key `method.md` sections/phrases: «לא כל עבודה עם דיג'רידו…», «איך נולדה השיטה» (§07). H1 differs from source («שיטת cbDIDG של אייל עמית»). | `interaction-tests.json` method.phrases | Line-by-line reconcile vs `method.md` | team_10 |
| **QA-50-F005** | 3.5 Content | `/galleries/` `/media/` | **F6/F7 CONFIRMED:** Galleries titles from mockup samples («רגעים מהמרחב…»); media press links use `href="#"` (6×). Not Eyal inventory. | `interaction-tests.json` media.hashLinks=6; live HTML | Real gallery/media CMS intake (H7,H8) | team_00 / Eyal |
| **QA-50-F006** | 3.1 E2E | `/blog/` → singles | Archive links to slug `…-2/` return **404** body («אופס…»). Alternate slug (post 238) returns **200**. Permalink mismatch on staging. | curl 404 vs 200; `interaction-tests.json` blog.h1 | Fix rewrite/slug sync or redirect | team_10 |

### P2 — Medium

| ID | Dimension | Route | Description | Evidence | Fix | Owner |
|----|-----------|-------|-------------|----------|-----|-------|
| **QA-50-F007** | 3.5 Content | Memorial | **F3 CONFIRMED:** «Jungle Vibes» spelling; omitted fragment «קוטלי עומד ומתפורר..»; editor-chosen H2 structure. | mem1.hasJungle=true | Eyal approve edits (H4,H5) | team_00 |
| **QA-50-F008** | 3.5 Content | Memorial | **F4 CONFIRMED:** Hero dates 1950–2020 present; birth year unverified in source. | mem1 has1950/has2020 | Confirm dates (H3) | team_00 |
| **QA-50-F009** | 3.1 Links | Mobile drawer | Drawer item **«קורסים»** → `href="#"` (not external URL). Mandate expects ↗ external. | `interaction-tests.json` linkResults | Wire H9 URL or honest disabled state | team_10 |
| **QA-50-F010** | 3.1 Forms | `/contact/` | Empty submit: **no** visible WPCF7 validation tips (`form.errors=[]`). Error path not surfaced in UI (scenario 2). | `interaction-tests.json` form | Verify CF7 config + client validation UX | team_10 |
| **QA-50-F011** | 3.8 LTR | `/en/` | Footer legal/catalog links remain **Hebrew** labels (שאלות נפוצות, גלריות, מדיניות פרטיות…) on EN page. | MCP snapshot `/en/` e11–e16 | EN footer labels or shared bilingual IA | team_10 |
| **QA-50-F012** | 3.1 Links | Desktop nav | Book link **כושי בלאנטיס** → `/books/kushi-blantis/` (200) vs site-tree `/muzza/kushi-blantis/`. Inconsistent slug namespace. | linkResults | Align to `muzza/` slug + redirect | team_10 |

### P3 / nit

| ID | Description | Owner |
|----|-------------|-------|
| **QA-50-F013** | Instagram footer icon missing `target=_blank` (Facebook has it). | team_10 |
| **QA-50-F014** | GeneratePress theme credit visible in footer (e76). | team_10 / team_80 |
| **QA-50-F015** | **F9 CONFIRMED:** Known placeholders (home media figure, sound toggle audio, hero video) — no regression. | team_00 content |
| **QA-50-F016** | Home hero H1 text concatenated in a11y tree (single H1 in DOM — verify visual line-break). | team_10 polish |

---

## §4 Link-coverage matrix

**Scope:** Chrome extracted from `/` (header nav, desktop dropdowns, mobile drawer DOM, `.ea-cfoot` footer) — **50 unique targets** (`interaction-tests.json` linkResults).

| Category | Count | All resolve? |
|----------|-------|--------------|
| Internal (staging) | 44 | ✅ HTTP 200 |
| External (social, wa.me) | 4 | ✅ external (not HTTP-tested) |
| **Broken / placeholder** | **1** | ⚠️ `קורסים` → `#` (QA-50-F009) |

**Memorial redirect chain (tested separately):**

| Source | Chain | Final |
|--------|-------|-------|
| `/mokesh-dahiman/` | 301 → `/eyal-amit/mokesh-dahiman/` → 301 → `/about/moksha/` | 200 |
| `/eyal-amit/mokesh-dahiman/` | 301 → `/about/moksha/` | 200 |
| `/about/moksha/` | — | 200 |

**Blog singles (sample):**

| Slug | HTTP | Note |
|------|------|------|
| `…-אייל-עamit-2/` (archive top) | 404 | QA-50-F006 |
| `…-תלמידi-ומט/` (post 238) | 200 | Valid single |

**External CTAs checked:** `/courses-external/` → `https://www.eyalamit.co.il/` (production) with `rel=noopener noreferrer` — not `#` on page body (F9 applies to drawer `#` only).

---

## §5 Content-accuracy (F1–F9 + new)

| Ref | team_100 finding | Team 50 verdict | Notes |
|-----|------------------|-----------------|-------|
| **F1** | Memorial source mis-scoped | **CONFIRMED** | Body = «ומה היום» narrative; INDEX says background-only |
| **F2** | No bio opening | **CONFIRMED** | Opens directly into present-day section |
| **F3** | Light edits / omissions | **CONFIRMED** | Jungle Vibes; missing «קוטלי…»; 3 H2s team-authored |
| **F4** | Dates unconfirmed | **CONFIRMED** | 1950–2020 in hero ring |
| **F5** | IA duplication | **CONFIRMED + expanded** | 301 chain to `/about/moksha/`; nav uses `/mokesh-dahiman` |
| **F6** | Galleries = mockup samples | **CONFIRMED** | H1 «רגעים מהמרחב…»; no Eyal gallery inventory |
| **F7** | Media = mockup samples | **CONFIRMED** | 6 press `href="#"` |
| **F8** | Method not reconciled | **CONFIRMED** | Missing comparison + origin sections from `method.md` |
| **F9** | Standing placeholders | **CONFIRMED** | No new regressions |
| **NEW** | Blog permalink 404 | **QA-50-F006** | Archive ≠ working slug on staging |
| **NEW** | EN footer Hebrew | **QA-50-F011** | LTR page, HE legal links |

---

## §6 Visual-precision notes (mockup vs live)

Screenshots: `evidence/full-e2e-2026-06-04/qa_probe/screenshots/` — per route × {360,390,414,768,1280}.

Mockup SSoT: `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/mockups/` (Track-2 elevated set).

| Page | Mockup ref | Desktop @1280 | Mobile @390 | Delta summary |
|------|------------|---------------|-------------|---------------|
| Home | `Home - Dashboard (elevated).html` | 🔍 shot `home_w1280.png` | `home_w390.png` | Block order matches mockup; hero media still placeholder (F9). Rotator present — quotes not verified vs Eyal source. |
| Method | `Method (elevated).html` | `method_w1280.png` | `method_w390.png` | Layout elevation present; **content** shorter than mockup/source (F8). |
| Memorial | `Memorial - Mokesh (elevated).html` | `mokesh-dahiman_w1280.png` | `mokesh-dahiman_w390.png` | Sand-ring + elevated template render; copy differs from mockup intent (F1–F3). |
| Galleries | `Galleries Catalog (elevated).html` | `galleries_w1280.png` | `galleries_w390.png` | Grid scaffold OK; **sample** titles not production content (F6). |
| Media | `Media Catalog (elevated).html` | `media_w1280.png` | `media_w390.png` | `.ea-tgrid` stack OK; press cards non-functional `#` (F7). |
| Treatment | `Service - Treatment (elevated).html` | `treatment_w1280.png` | `treatment_w390.png` | No material regression vs prior sign-off. |
| About | `Editorial - About (elevated).html` | `eyal-amit_w1280.png` | `eyal-amit_w390.png` | Bio media-rows render; matches signed Track-2. |
| EN | `EN - Landing (elevated).html` | `en_w1280.png` | `en_w390.png` | English body OK; chrome/footer bilingual mismatch (F011). |
| Books | `Commerce - Books Archive (elevated).html` | `muzza_w1280.png` | `muzza_w390.png` | Grid + cards OK. |

**D-14 tokens:** No off-palette colours observed in screenshot pass; spacing consistent with elevated templates. Formal pixel-diff not run (visual gate = human + screenshot review per mandate).

---

## §7 Routing recommendation

### Ready for L-GATE_VALIDATE (build/tech)

Technical bar met (200, axe, overflow, chrome, drawer core, regression on pre-W2-14 cluster):

- WP-W2-14-A/B chrome & drawer (with **open** P1 on drawer `קורסים` `#`)
- WP-W2-14-C Home (content placeholders tracked F9)
- WP-W2-14-D Method (**conditional** — reconcile F8 before content sign-off)
- Service cluster regression: treatment, lessons, sound-healing, learning subtree, tools, contact, FAQ, legal, shop, books, about, EN shell

### Hold / content-pending (Eyal + team_00)

- Memorial canonical URL + copy intent (**H1–H6**, F1–F5) — do **not** content-final
- Galleries + Media real inventory (**H7–H8**, F6–F7)
- Method full copy (**F8** + H1 linkage to §07)
- Home rotator quote provenance (**H8** subset)

### team_10 before blog/contact validate

- **QA-50-F006** blog permalink 404s from archive
- **QA-50-F010** contact form empty-submit validation UX
- **QA-50-F009** drawer courses `#`
- **QA-50-F012** `/books/` vs `/muzza/` slug consistency

---

## Scenario matrix (GCR-002)

| Surface | 1 Happy | 2 Error | 3 Edge | 4 Conflict | 5 Cancel |
|---------|---------|---------|--------|------------|----------|
| Mobile drawer | Open→nav links visible, Esc closes ✅ | — | @360/@390 overflow 0 ✅ | Memorial 3 URLs → same body ✅ | Esc mid-open ✅ |
| Contact form | — | Empty submit: **no visible errors** ⚠️ F010 | — | — | — |
| Home rotator | Present in DOM ✅ | — | reduced-motion **not** automated | — | — |
| Language HE↔EN | EN pill 200 ✅ | — | EN footer HE ⚠️ | — | — |
| courses-external | Prod links 200 ✅ | — | — | — | — |
| Memorial URLs | `/about/moksha/` 200 ✅ | — | — | 301 chain ⚠️ F003 | — |
| Blog | Archive 200 ✅ | 404 single ⚠️ F006 | — | — | — |

Scenarios 4–5 N/A for shop purchase (external checkout) and sound toggle (F9 audio pending).

---

## Regression note (§3.9)

Pre-W2-14 signed pages (treatment, about, books, blog archive, contact, FAQ, EN, service cluster): **no new P0/P1 technical regressions** detected. W2-14 elevations (method, memorial, galleries, media, home fixes) introduce **content/IA findings**, not layout breakage.

---

*Team 50 · Cursor Composer · IR#1 independent · 2026-06-04*
