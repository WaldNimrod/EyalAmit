## VERIFY — Phase 1 (Archive fill + Hub form) — 2026-09-21

- **Role**: Independent validator (not builder)
- **Repo**: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`
- **Staging base (HTTP)**: `http://eyalamit-co-il-2026.s887.upress.link` (TLS invalid by design; not used here)
- **Hub form**: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html`
- **Theme claimed live**: `1.5.104` (**confirmed** via HTML asset version strings)
- **SSOT sha12 (claimed)**: `111e2f9f079a` (not mutated in this validation)
- **Hard rules complied**: GET **without redirects** (`curl` no `-L`) + browser UA; layout validated via `qa_probe.mjs` (not curl)

### Verdict (overall)

**FAIL** — due to `qa_probe.mjs` horizontal overflow on `/historical-articles/` at both 375 and 1440 widths.

### PASS/FAIL table (short)

- **A / HTTP GET + content assertions**: **PASS**
- **B / `qa_probe.mjs` overflow at 375 & 1440**: **FAIL** (2/8 failures; both on `/historical-articles/`)
- **C / Browser visual checks**: **PASS**

---

## A) GET (no-follow) + UA — required checks

**Evidence bundle (headers+HTML+codes)**:
- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/http_fullnet/`
- Note: no `Location:` headers were observed in the saved header files (no redirect-following was performed).

### A1) `/press/`

- **GET status**: **200** (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/http_fullnet/press.code.txt`)
- **Theme version**: **1.5.104 present in HTML** (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/http_fullnet/press.html`)
- **Required strings present (all TRUE)**:
  - `המקומון גבעתיים` ✅
  - `גבעתיים` ✅
  - `רואי פרסול` ✅
  - `מרקוביץ` ✅
  - `המלצות על המופע` ✅
  - `אברהם טל` ✅

### A2) `/historical-articles/`

- **GET status**: **200** (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/http_fullnet/historical.code.txt`)
- **Required strings present**:
  - `מופע הסיפורים של אייל עמית` ✅
  - `assets/images/archive/GIVATAIM.jpg` ✅

### A3) `/shows-heritage/`

- **GET status**: **200** (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/http_fullnet/shows_heritage.code.txt`)
- **Must NOT contain** `מופע הסיפורים של אייל עמית` as filled archive body: **NOT FOUND** ✅

### A4) `/` (homepage link counts + learning parent)

- **GET status**: **200** (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/http_fullnet/home.code.txt`)
- **Homepage `href` counts (must all be 0)** — **all 0** ✅
  - `/shows-heritage/` → 0
  - `/press/` → 0
  - `/historical-articles/` → 0
  - `/services/` → 0
- **Learning parent is NOT a link to `/learning/`**: ✅
  - The “לימוד והכשרה” parent renders as a button/dropdown (no `href=/learning/` in the immediate snippet).
  - The child `/learning/courses-external/` **is present** (allowed).

### A5) Hub form GET 200 + content assertions

- **GET status**: **200** (`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/http_fullnet/hub_form.code.txt`)
- **Contains** `חלק י · עץ התפריט הראשי`: ✅
- **Contains** `data-id="M1"`: ✅
- **A2 closed**: `data-id="A2"` + `data-status="closed"` present ✅ (and “נסגר” appears)
- **C1 must NOT ask to connect nav bar**: ✅ (no “לחבר את סרגל הניווט” / “connect nav bar” language found)

---

## B) `qa_probe.mjs` — overflow at 375 and 1440

**Runner**: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs`

**Command used** (default viewports = 375×812 + 1440×900):

`node file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /,/press/,/historical-articles/,/shows-heritage/ --out file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/qa_probe_run --shots`

**Result JSON**:
- `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/qa_probe_run/qa_probe_result.json`

**Summary**:
- **verdict**: **FAIL**
- **failures**: **2** / total **8**
- **Both failures are overflow** on `/historical-articles/`:
  - **mobile**: `scrollWidth=985` vs `clientWidth=375` → overflow=true
  - **desktop**: `scrollWidth=2978` vs `clientWidth=1440` → overflow=true

**`qa_probe` screenshots (rendered evidence)**:
- mobile `/historical-articles/`: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/qa_probe_run/screenshots/_historical_articles__mobile.png`
- desktop `/historical-articles/`: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/qa_probe_run/screenshots/_historical_articles__desktop.png`

---

## C) Browser (Cursor IDE browser MCP) — required visuals

**Browser screenshots saved (repo-local)**:
- Drawer / L1 labels (mobile): `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/browser/home_drawer_mobile.png`
  - **No new L1 items** for `press` / `historical-articles` / `shows-heritage` observed ✅
- `/press/` recommendations visible: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/browser/press_recommendations_mobile.png` ✅
- `/historical-articles/` clipping scan visible (GIVATAIM): `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/browser/historical_article_givataim_mobile.png` ✅
  - Heading + scan (same viewport): `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/browser/historical_heading_and_scan_mobile.png`
- `/shows-heritage/` placeholder/empty body visible: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/browser/shows_heritage_mobile.png` ✅
- Hub form M1 section visible: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/browser/hub_form_M1.png` ✅

---

## RETEST (post-overflow remediation) — 2026-09-21

### A) GET (no-follow) + UA — `/historical-articles/`

- **GET status**: **200**
- **Theme version strings found in HTML**: `w2-07-heritage.css?ver=1.5.105` (also `style.css?ver=1.5.105`)
- **Required strings present**:
  - `מופע הסיפורים של אייל עמית` ✅
  - `assets/images/archive/GIVATAIM.jpg` ✅
- **Evidence (headers + HTML)**:
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/manual/historical-articles.headers.txt`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/manual/historical-articles.html`

### B) `qa_probe.mjs` — regression scan (375 + 1440)

**Command used**:
`node file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /,/press/,/historical-articles/,/shows-heritage/ --out file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/qa_probe_retest105 --shots`

- **Result**: **PASS** (0/8 failures)
- **`/historical-articles/` overflow metrics**:
  - **mobile (375)**: overflow=false; `scrollWidth=375` vs `clientWidth=375`
  - **desktop (1440)**: overflow=false; `scrollWidth=1440` vs `clientWidth=1440`
- **Evidence**:
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/qa_probe_retest105/qa_probe_result.json`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/qa_probe_retest105/screenshots/_historical_articles__mobile.png`
  - `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/s007_verify_2026-09-21/qa_probe_retest105/screenshots/_historical_articles__desktop.png`

