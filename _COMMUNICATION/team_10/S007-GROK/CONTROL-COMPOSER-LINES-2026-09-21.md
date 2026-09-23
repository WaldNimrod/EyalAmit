# CONTROL — Composer lines vs SSOT (Team-10 diffs)

**Repo:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/`  
**Scope:** Uncommitted `git diff` for theme files + as‑made. No code changes performed.  
**As‑made referenced:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ASMADE-DA-NAV-BURGER-2026-09-21.md`

## Executive status (SSOT claims)

- **SSOT Q-DA-NAV-BRIEF / N1 / DA-NAV-01**: **PASS** (burger inline-start, drawer same edge, logo opposite; no desktop L1 restructure; only padding guard on `/en/` + GP orphans).
- **SSOT Q-LEARNING-PHOTOS / C1**: **PASS** (3 `photo-slot` sections added to `/learning/` defaults with required IDs).
- **Typography canon (no new component `font-size`)**: **PASS** in this diff set (no new `font-size` declarations introduced by these hunks; existing `1.2rem/.85rem` in `tpl-chapters-en.php` is pre-existing).
- **T‑NAV‑HOLD (canonical nav items unchanged)**: **PASS** (`git diff` shows **no changes** to `inc/ea-canonical-nav.php`).

## Findings (ranked)

### P0 — patch now (live QA fail)

- **None found** in the specified diff set.

### P1 — should patch / confirm before live QA

- **Learning photo-slots introduce user-visible placeholder copy (if photos not yet set)**
  - **Why it matters**: The new `/learning/` slots render a visible label string on the front-end by design. If the intent is “empty reservation placeholders” only, this will still show real text blocks on the live page until editors replace them with actual photos (or until the part is redesigned).
  - **Evidence**
    - Defaults add labels + IDs: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/learning-defaults.php` (lines **37–41**, **52–56**, **67–71** via grep)
    - Front-end prints the label visibly: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/photo-slot.php` (line **18** shows `<span><?php echo esc_html( $label ); ?></span>`)
  - **Ops recommendation**: If `/learning/` is expected to ship with actual photos immediately, treat this as a **content-readiness gate**: ensure the 3 slots are replaced with real images (or alter `photo-slot` rendering so labels are non-visible / admin-only).

### P2 — watch items (not proven broken, but worth verifying)

- **`/en/` padding precedence at ~390px is a deliberate override (start=72, end=24)**
  - **Risk being checked**: `@media(max-width:600px){padding-inline:24px}` vs later `@media(max-width:1023px){padding-inline-start:72px}`.
  - **What actually happens at 390px**: both rules apply; later rule overrides **only** `padding-inline-start`, leaving `padding-inline-end` at 24px. Net result: start padding 72px, end padding 24px.
  - **Evidence**: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-en.php` (lines **39–40**).
  - **Ops recommendation**: Visual verify on `/en/` at 390px that the site title/brand doesn’t look “over-indented” (but this appears consistent with DA‑NAV‑01’s non-overlap padding intent).

### Note — verified “Hunt” items are OK (no action)

- **(1) Desktop L1 broken by mobile-only rules leaking**: not observed.
  - `chapters.css` burger/logo re-order is gated at `@media(max-width:1180px)`; desktop unaffected.  
    Evidence: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/chapters.css` (lines **834–841**).
  - Wave2 control cluster re-order is gated at `@media (max-width:1023px)` and `.ea-mnav-controls` is `display:none` outside that breakpoint.  
    Evidence: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-mobile-nav.css` (lines **21–23**, **41–60**).

- **(3) `--ea-nd-tx` sign vs `inset-inline-start` consistency**: consistent after the flip.
  - Drawer is anchored to inline-start and uses `translate: var(--ea-nd-tx) 0` when closed; `translate:0 0` when open; starting-style animates from `--ea-nd-tx`.  
    Evidence: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-nav-drawer.css` (lines **35–36**, **121–136**).

- **(4) Wave2 `.ea-mnav-controls{order:-1}` + RTL row-reverse leakage to desktop**: not observed (scoped to the mobile media query).  
  Evidence: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-mobile-nav.css` (lines **41–60**).

- **(5) New `font-size` introduced in diff**: not found in the shown hunks for the specified files.

- **(7) T‑NAV‑HOLD breach**: not observed in diff scope.
  - **No diff** for `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php`.
  - `section-nav.php` change is comment-only around the burger trigger.  
    Evidence: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-nav.php` (lines **32–40**).

## Ops action list (now vs accept)

- **Patch now (P0)**: none.
- **Confirm/patch before live QA (P1)**:
  - Decide if `/learning/` is allowed to show **visible placeholder labels**; if not, adjust `photo-slot` rendering or ensure images are populated before QA.
- **Accept with verification (P2)**:
  - Visual check `/en/` at small widths for the asymmetric padding effect (start 72 / end 24) and confirm it matches the intended burger overlap-prevention.

