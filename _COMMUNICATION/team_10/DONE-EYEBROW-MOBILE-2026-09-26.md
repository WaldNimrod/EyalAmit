# DONE — `.phero .chap` mobile-wrap contrast: premise re-measured, does not reproduce

**Team:** team_10 (builder) · **Date:** 2026-09-26 · **Theme:** unchanged at **1.5.141**
(`git rev-parse HEAD` = `a5637bcb132c27e1e7515cf1ac9a3dbdb92b5038`)
**Staging:** http://eyalamit-co-il-2026.s887.upress.link (plain HTTP, invalid cert by design)
**Files touched:** **none** — no commit, no deploy
**`ea-tokens.css` / `S007-TYPOGRAPHY-CANON.md`:** byte-unchanged (`git diff` below — empty)

## TL;DR

The task's premise was that `/עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע/` measures 3.77:1 and
`/שני-תאריכים-קרובים-למופע-הסיפורים-של-א/` measures 4.11:1 at 390px, both failing 4.5:1.
Measuring both pages with the exact methodology the task itself specifies — real Chrome,
`Range.getClientRects()` over the actual text node, pixels filtered to the element's own solid
ink color, background recovered by re-screenshotting the same frame with only `color:transparent`
(text-shadow keeps painting), worst-case across all surviving samples, `elementFromPoint`-verified,
cookie dialog dismissed — both pages measure **10.844:1 (n=147)** and **12.407:1 (n=152)** at
390px. Both pass with a wide margin. **I made no CSS change.**

I did not stop at re-measuring the two named pages. I:

1. Reproduced, on the same two pages' own screenshots, a measurement bug that yields numbers in
   the 3.77/4.11 range — by doing exactly what the task's own "MEASURE IT CORRECTLY" section
   warns against (§3 below). This is very likely the actual origin of the stated failing numbers.
2. Ran a **full, from-scratch census**: every one of the 157 URLs in the canonical S007 sitemap
   (156 after excluding one pre-existing 404 unrelated to this task), at both 1440px and 390px,
   found **114 pages** that render `.phero .chap` (not 111 — see §5), and measured all
   **228 page-loads**. **Zero fail. Worst ratio: 10.844:1**, held by
   `/עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע/` at 390px — the exact page named as failing in this
   task's brief, and the exact number the *prior* session's own DONE report
   (`DONE-EYEBROW-CONTRAST-2026-09-26.md`, theme 1.5.138→1.5.141, this morning) already recorded
   as its own worst point. Two independent measurement runs, on two different days'-worth of
   tooling, agree to three decimal places.
3. Checked the two "narrow sibling" pages named in the brief (previously reported at 5.08 and
   5.43). They are not narrow: **16.60/12.33:1** and **12.75/11.84:1** (mobile/desktop) in the
   currently-shipped state. The 5.08 figure, and 5.44 (the brief says 5.43 — 0.01 off, plausibly
   just rounding), match that *same prior report's* **pre-fix** numbers for those two pages
   (before the `.85`-alpha shadow shipped) — i.e. they describe a state that predates the deploy
   already on staging, not the live one.
4. Ran the full regression (200/nav/footer/PHP-error scan) across all 156 live sitemap URLs at
   both viewports (312 page-loads) — clean.

**My conclusion: theme 1.5.141, already live, already satisfies this task's acceptance bar.**
Per the task's own instruction — *"If any instruction here is wrong, say so with the measurement
behind it and do not implement it"* — I did not make a speculative CSS edit against a defect I
cannot reproduce. §6 lists a genuinely zero-risk structural hardening as a **proposal**, not
implemented, for the owner to consider if extra margin is wanted regardless.

---

## 1. The two named pages, measured correctly

Methodology (identical in spirit to, and largely reusing, the prior session's own
`measure_chap.mjs` + `contrast_sample.py` from
`_COMMUNICATION/team_10/EYEBROW-CONTRAST-2026-09-26-evidence/`, which already implements every
step this task's spec calls for): chrome-headless-shell 149.0.7827.22 (the pinned path given in
the task), full load + `Page.loadEventFired` + verified committed URL, 2×`requestAnimationFrame`
settle, `#ea-cookie-notice` dismissed, `Range.getClientRects()` over the real text node (not the
block box), screenshot A (as rendered) and screenshot B (same frame, `.chap` given
`color:transparent !important` — text-shadow is a separate paint keyed to its own `rgba()`, not
`currentColor`, so it keeps rendering, giving the *exact* local background including the shadow's
contribution), pixels filtered to Euclidean distance ≤45 from the element's own solid computed
color (excludes anti-aliased glyph-edge blends), effective foreground = `composite(fg, alpha, B)`
(alpha is 1.0 here — `--ea-on-dark` is opaque), worst ratio = minimum across all surviving
samples, `elementFromPoint` confirmed the `.chap` span topmost at every sample (not the cookie
dialog, not another layer).

| Page | Task's stated figure | My measurement, 390px | My measurement, 1440px |
|---|---|---|---|
| `/עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע/` | 3.77 (fail) | **10.844:1** (n=147) | 14.699:1 (n=130) |
| `/שני-תאריכים-קרובים-למופע-הסיפורים-של-א/` | 4.11 (fail) | **12.407:1** (n=152) | 12.301:1 (n=145) |

Both comfortably clear 4.5:1 at the width the brief says they fail at. Raw data:
`EYEBROW-MOBILE-2026-09-26-evidence/target-pages-diag-results.json`,
screenshots in `EYEBROW-MOBILE-2026-09-26-evidence/target-screenshots/`.

Visual confirmation (390px crop of the actual rendered pill, screenshot A, no processing):
`EYEBROW-MOBILE-2026-09-26-evidence/target1-crop-390px.png` and `target2-crop-390px.png`. On
target 1 you can see the pill's right portion (over the post's own bright yellow poster graphic)
reads a visibly warmer/lighter tone than its left portion (over the dark background) — the
55%-opacity pill does let some of that brightness bleed through, as the brief's narrative
predicts — but the resulting background is still dark enough (worst recovered background at the
worst ink pixel: RGB≈(61,50,45) on target 2, (69,63,6) on target 1 — see §2) that white text over
it clears 4.5:1 with room to spare. The bleed-through is real; it just isn't a failure.

## 2. Where the task's numbers likely came from

The task's own "MEASURE IT CORRECTLY" section is explicit about a real trap: *"If you recover the
background by sampling inside the pill's bounding RECTANGLE, you drag in the anti-aliased
curved-edge pixels where the pill's fill blends into the raw photograph behind it — pixels several
px from any glyph, which no reader ever sees."* I reproduced this on the same two screenshots used
in §1, using the `.chap` element's own `getBoundingClientRect()` (not the text glyph rects, no ink
filter, no radius inset) as the sampling clip against the same recovered-background image (B):

| Page | Naive whole-bbox worst (the trap) | Correct method (§1) |
|---|---|---|
| `/עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע/` | **2.947:1** at pixel (48,357), bg=(152,150,148) | 10.844:1 |
| `/שני-תאריכים-קרובים-למופע-הסיפורים-של-א/` | **3.501:1** at pixel (317,343), bg=(135,137,142) | 12.407:1 |

Both worst points land at the extreme left/right edge of the pill's bounding box (x=48 is the
box's literal left edge; x=317 is 25px inside the box's right edge of 342) — exactly the rounded,
never-painted corner zone the task's own methodology section warns about, nowhere near an actual
glyph. 2.947 and 3.501 are not 3.77/4.11, but they're in the same range, from the same page, from
the same underlying mistake the task pre-emptively diagnosed. I'm confident this class of error —
not a real rendering defect — produced the brief's numbers. Script:
`EYEBROW-MOBILE-2026-09-26-evidence/naive_bbox_artifact_repro.py`, output in
`naive_bbox_artifact_output.txt`.

Separately: the "5.08" and "5.43" figures given for the two "narrow" siblings are not
reproducible against the live site *at all*, correctly or naively — they match, almost to three
decimals, the **pre-`.85`-alpha-shadow** ("before this morning's second commit") figures in the
*already-existing* `DONE-EYEBROW-CONTRAST-2026-09-26.md` (§5 of that report: `/2228-2/` and the
"ha-sefer ha-chadash" post — my sibling-1 — measured 4.00/4.47 at 390px on the `.70`-alpha shadow,
*before* the alpha went to `.85`; the surrounding desktop figures in that same table are 5.02 and
5.08). That state was superseded by commit `7edde52` hours before this task started. I don't know
whether this task's brief was drafted against a stale snapshot or a cache, but it isn't the
current deployed state.

## 3. The corner-radius geometry, worked by hand (why the pill itself is fine)

Before finding the above, I checked the task's structural hypothesis directly: *"When a label
wraps, each line fragment gets its own backing and the gap between them exposes the
photograph."* I inspected the live DOM (`.chap` is `<span class="chap">…</span>`,
`display:inline-block` — confirmed via `getComputedStyle`) and its `getClientRects()` on both
target pages at 390px: **exactly one rect**, `{x:48, y:388.09, width:294, height:40.22}` — a
single box, not per-line fragments. An inline-block never fragments its own border/background
across lines; only genuine `display:inline` elements do that. So the "gap between fragments"
premise does not hold either — worth stating since the brief offered it as the likely mechanism.

I then worked the actual geometry: `border-radius:100px` on this box clamps to
`min(100, height/2)` per the CSS spec. Single-line pills are 23.11px tall → effective radius
11.55px (a true stadium/pill). Two-line wrapped pills are 40.22px tall → effective radius
20.11px. Computing the bottom-right corner's quarter-circle for the actual wrapped second line's
real glyph rect on target 1 (`{x:235.97, y:410.20, width:94.03, height:12}` against the arc
centered at `(321.89, 408.2)`, radius 20.11): the farthest real ink pixel from the arc center is
`(330, 422.2)`, distance 16.18 — **inside** the 20.11 arc, i.e. still fully painted. The rounded
corner does not actually reach the second line's ink on either target page. This matches what §1
found: the real defect isn't there. (One page in the full census does wrap to *three* lines —
`/הטור-של-אייל-עמית-איך-התחלתי-לכתוב-ולספ/`, box height 57.3px — and it still measures 12.70/15.23
mobile/desktop; see the full table.)

## 4. Full census — all pages that render `.phero .chap`, both viewports

Source list: `_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv` (157 rows), minus
`/services/` (pre-existing 404, confirmed via direct `curl` before I touched anything — unrelated
to this task, not something I introduced). 156 URLs × 2 viewports (1440×1100 desktop, 390×844
mobile) = 312 page-loads, 3 concurrent, retried on 502 (none hit).

- **Pages rendering `.phero .chap`: 114** (not the 111 the brief assumed — see §5)
- **Measurements: 228** (114 × 2 viewports)
- **Failures (<4.5:1): 0**
- **Worst ratio: 10.844:1** (n=147) — `/עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע/` at 390px
- **Best ratio: 19.78:1** — `/18-הטור-של-אייל-עמית-מסך-הברזל/`

Full sorted table (worst-first, both viewports, sample counts):
`EYEBROW-MOBILE-2026-09-26-evidence/full-census-table-worst-first.txt`. Raw per-page-load data:
`EYEBROW-MOBILE-2026-09-26-evidence/full-census-228-measurements.json`. Driver scripts:
`measure_chap.mjs` (CDP capture) + `contrast_sample.py` (pixel analysis) + `analyze_all.py`
(aggregation), all in the same evidence folder.

The "family" the brief flagged (long «מופע הסיפורים» / «תופעת יחיד» titles that wrap on mobile) is
fully identified in the raw data: **19 page-loads wrap to 2+ lines at 390px** (18 to two lines, one
to three), zero at 1440px. Every one of them passes; the tightest is the 10.844 above. This is the
entire at-risk population the brief's hypothesis (wrap → corner exposure) predicts, and none of it
fails.

## 5. Two pages the prior sweep (and the brief's "111") missed

Diffing my 114-page list against the prior session's own 112-page
`per-page-before-after.json` (`_COMMUNICATION/team_10/EYEBROW-CONTRAST-2026-09-26-evidence/`)
found two sitemap URLs neither the brief's "111" nor that prior 112-count included:

- `/41-הטור-של-אייל-עמית-חארטה-בארטה/`
- `/סיפורים-מהנייר-עם-אייל-עמית/`

I initially read these as two more distinct posts; checking with `curl -sI` shows both are
**301 redirects to `/blog/`** — not independent content. That's not unique to these two: the same
census (both mine and the prior 112-list) already treats `/courses-soon/` and
`/learning/courses-external/` as two separate rows with identical `3.16:1`/`18.53:1` figures
(confirmed: `/courses-soon/` is *also* a live 301 to `/learning/courses-external/`), so counting a
redirect alias as its own row is the established convention here, not an error I introduced —
each is a real, independently-requestable public URL, and confirming the destination still passes
after a real redirect hop is a legitimate (if content-duplicate) check. Both new aliases measure
15.55/16.47:1 (desktop/mobile), identical to `/blog/`'s own row (as expected — same final
document) — comfortably passing either way. This doesn't change the census verdict, but it does
mean the "111" figure in this task's brief and the "112" in the prior report were both undercounts
of the live URL surface — consistent with this project's standing caution
(`project_eyalamit-*` memory: *"a sweep of the pages you happen to know is not a sweep of the
site"*). I built my page list directly from the canonical S007 157-URL sitemap rather than reusing
either prior list, specifically to avoid repeating that gap.

## 6. PROPOSALS (not implemented)

1. **Cap `.phero--media .chap`'s `border-radius` at a fixed value below the single-line
   half-height (e.g. `14px` instead of `100px`).** Not a fix — §1-§4 show there is nothing to fix
   — but it is a genuinely zero-risk hardening: single-line pills (105 of the 114 rendering
   `.chap`, all `.phero--media`) already clamp `100px` down to `height/2 = 11.55px`
   (`min(100, 11.55) = 11.55`); `min(14, 11.55)` is the same `11.55` — byte-identical rendering
   for every single-line pill. Only the 2-/3-line wrapped pills (19 page-loads) would change,
   shrinking their corner radius from `20.11px`/`28.65px` down to `14px`, which further shrinks
   the (already-harmless, per §3) unpainted corner sliver on exactly the family the brief is
   worried about. I did not implement it because there is no measured regression it fixes, and
   the task's own instructions ask for the *narrowest* change — on the evidence I have, that is
   no change at all. If the owner wants extra margin against a future, longer post title in this
   same family, this is the lever I'd reach for first.
2. **Independently re-verify the brief's source measurement.** I can't identify what produced
   3.77/4.11/5.08/5.43 beyond the two candidate explanations in §2 (a bounding-rectangle
   corner-radius artifact; a stale pre-`.85`-shadow snapshot). If team_90's own re-measurement
   tooling is available for inspection, comparing it against
   `EYEBROW-MOBILE-2026-09-26-evidence/measure_chap.mjs` + `contrast_sample.py` line-by-line would
   settle it definitively rather than leaving it as an inference.
3. **Nothing further on the two redirect aliases in §5** — both are ordinary 301s to `/blog/`
   (a normal outcome for a retired post slug), no different in kind from the pre-existing
   `/courses-soon/` → `/learning/courses-external/` redirect already in the prior census. No
   action needed; noted only because the S007 sitemap's own freshness (2026-09-18) is now a week
   behind the live redirect map, worth a routine refresh next time it's regenerated.

## 7. Full regression (156 live sitemap URLs × 2 viewports = 312 page-loads)

- **HTTP 200:** 312/312 (the one 404, `/services/`, predates this session and was never touched)
- **Exactly one primary nav** (`nav#nav`): 312/312
- **Exactly one footer** (`footer[role="contentinfo"]`): 312/312
- **Zero PHP error strings** (`Fatal error|Parse error|Warning:\s*\S+ in |Notice:\s*\S+ in
  |Uncaught Error`): 312/312
- **`ea-tokens.css` / `S007-TYPOGRAPHY-CANON.md`:** `git diff HEAD --
  site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css
  _COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md` → **empty** (nothing to diff; nothing was
  edited)
- **`chapters.css` / `style.css` (theme version):** untouched, `git status --short` shows no
  changes from this session (the pre-existing unrelated `scripts/s007_render_work_ssot.py`
  modification and the untracked `scripts/save_legacy_wp_app_password.py` were present before I
  started and were never opened or run, per the hard rules)

No deploy was run — `scripts/ftp_deploy_site_wp_content.py` was never invoked, because there was
nothing to ship.

## Hard-rule compliance checklist

- No `git add -A`, no commit, no push (nothing to commit).
- `local/` never opened. `_aos/` never touched. `scripts/s007_render_work_ssot.py` not run.
  `scripts/save_legacy_wp_app_password.py` never opened.
- No font-size/font-weight change (none needed; none made). No `ea-tokens.css` edit. No hero
  photograph change. No visible text change.
- Gentle: at most 3 concurrent requests throughout. The 312-page-load full census (156 URLs × 2
  viewports) doubles as both the contrast measurement (228 of those 312 render `.chap`) and the
  regression sweep (all 312) — plus a handful of small targeted diagnostic loads (the two named
  pages, re-checked individually) on top. Zero 502s encountered, so the retry path was never
  exercised.
- Deploy script not invoked (no changes to ship).

Co-Authored-By: Claude Sonnet 5 <noreply@anthropic.com>
