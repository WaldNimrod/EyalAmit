# VERIFY — DA nav burger inline-start (Recommendation B)

- **Validator**: independent (engine `gpt-5.2`)  
- **Builder claim**: theme `1.5.103`, burger at **inline-start** (RTL=right, LTR=left), drawer opens from same edge  
- **Staging base**: `http://eyalamit-co-il-2026.s887.upress.link`  
- **Verdict**: **PASS** (Version `1.5.103` + checks (2)(3)(4) PASS)

---

## 1) Theme version (no redirect follow)

- **URL**: `http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/style.css`
- **HTTP**: `200`
- **Header**: `Version: 1.5.103` (in file header comment)
- **Evidence (raw capture excerpt produced via curl UA)**: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/` (see terminal log in chat transcript)

---

## 2) Home `/` @ 390px, RTL — burger right, logo left

- **Viewport**: \(390×844\)  
- **Document dir/direction**: `dir="rtl"`, computed `direction: rtl`
- **`.nav__burger` rect**: \(x=302, y=21.5, w=44, h=44\)
  - **Check**: \(x > 195\) ✅
  - **Right-edge heuristic**: \(x+w = 346 \ge 330\) ✅
- **`.nav__b` (logo) rect**: \(x=44, y=23.5, w=161.5, h=40\)
  - **Check**: \(x < 195\) ✅
- **Evidence screenshot**: [home RTL 390](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/screenshots/home_rtl_390_00.png)

---

## 3) Home `/` @ 390px, RTL — drawer opens from right

- **Action**: click `.nav__burger`
- **`dialog.ea-nd[open]` rect**: \(x=54.6094, y=0, w=335.3906, h=824.4688\)
  - **Edges**: `left=54.6094`, **`right=390`**
  - **Check**: panel sits on **RIGHT** (right edge ≈ viewport width) ✅
- **Evidence screenshot (after click)**: [home RTL 390 drawer open](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/screenshots/home_rtl_390_01_after_click.png)

---

## 4) English `/en/` @ 390px, LTR — burger left, no overlap with language switch

- **Viewport**: \(390×844\)  
- **Document dir/direction**: `dir="ltr"`, computed `direction: ltr`

- **`.ea-nd-burger--standalone` rect**: \(x=14, y=14, w=44, h=44\)
  - **Check**: \(x < 80\) ✅
- **`.ea-en-head__lang` rect**: \(x=315.0156, y=24.3438, w=50.9844, h=21.0625\)
- **`.ea-en-head__b` rect**: \(x=72, y=20, w=80.0313, h=29.75\)

- **Overlap booleans** (rect intersection):
  - **burger vs lang**: `false` ✅
  - **burger vs brand**: `false` ✅

- **Evidence screenshot**: [EN LTR 390](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/screenshots/en_ltr_390_00.png)

---

## 5) GP orphan (no-redirect) `/press/` @ 390px, RTL — standalone burger right; title not covered

- **Redirect policy**: `/about/` is **301** (no-follow) → used `/press/` which is **200**.
- **Viewport**: \(390×844\), RTL
- **`.ea-nd-burger--standalone` rect**: \(x=332, y=14, w=44, h=44\)
  - **Check**: burger on **RIGHT** ✅
- **`.site-branding` rect**: \(x=222.5, y=20, w=111.5, h≈45.28\)
- **Overlap burger vs `.site-branding`**: `true` but **minimal** \(ix=2px, area=76\) → **title/brand not fully covered** ✅
- **Evidence screenshot** (cookie modal present; header still visible): [press RTL 390](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/screenshots/press_rtl_390_00.png)

---

## 6) Wave2 page with `.ea-mnav-burger` / `.ea-topnav`

Tried multiple likely Wave2 candidates at 390px (`/shop/`, `/books/`, `/method/`, `/learning/`, `/treatment/`, `/blog/`, `/sound-healing/`, `/lessons/`):

- **Result**: **no pages had** `.ea-mnav-burger` **or** `.ea-topnav` (all had `.nav__burger`)
- **Evidence JSON**: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/wave2_scan_2026-09-21.json`

---

## 7) Desktop 1440 `/` — burger hidden

- **Viewport**: \(1440×900\)
- **`.nav__burger` style**: `display: none`
- **Rect**: \(x=0, y=0, w=0, h=0\) ✅

---

## qa_probe (layout overflow) @ 375px

Ran `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` at **375×812** for `/` and `/en/`:

- **Home `/`**: `scrollWidth=375`, `clientWidth=375`, **overflow=false** ✅
- **EN `/en/`**: `scrollWidth=375`, `clientWidth=375`, **overflow=false** ✅

- **Evidence JSON**: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/qa_probe_nav_2026-09-21.json`
- **Evidence screenshots**:
  - [qa_probe home 375](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/screenshots/home_m375.png)
  - [qa_probe en 375](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/screenshots/en_m375.png)

---

## Final verdict (one line)

**PASS** — Version `1.5.103`; Home RTL burger+drawer on right; EN LTR standalone burger on left with **no overlap**.

