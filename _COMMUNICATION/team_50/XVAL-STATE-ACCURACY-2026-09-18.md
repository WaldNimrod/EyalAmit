Cross-engine falsification pass on `_COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md`, everything above its ARCHIVE line, requested before that session compacted. Five focused Grok lines (`cursor-grok-4.6-high`, one topic each, serial with a pause, same runner/timeout discipline as the accessibility wave earlier today). None were given the document's conclusions — each got the specific claim, asked to falsify it, and was told to report its own number even where that disagrees with the claim.

Prompts: `tmp/qa/xval-2026-09-18/S{1,2,3,4,5}-*.txt` (gitignored, same convention as the earlier B/C wave). Raw per-line outputs kept at `tmp/qa/xval-2026-09-18/S{1,2,3,4,5}.out.md` (also gitignored) — this file is the one committed record.

## Verdict summary

| Line | Topic | Verdict |
|---|---|---|
| S1 | Git + deploy state | CONFIRMED in substance. Two wording flags (below), neither operationally wrong. |
| S2 | Accessibility-closure completeness | **FALSIFIED.** The four-item open list was incomplete; one "Landed" closure cited stale evidence. |
| S3 | Typography facts | **FALSIFIED**, extensively — most specific numbers were off, and one claim (H1 font-family) was backwards. |
| S4 | Preview-tool behaviour | **FALSIFIED** on two words ("only," "clamped") and the last decimal of two numbers. No actual safety gap — the tool is inert off-staging and rejects out-of-range input safely either way. |
| S5 | Row-rhythm numbers | **CONFIRMED**, all four claims as stated. One disagreement found in a different file (below), not in the four claims. |

The handoff document has been corrected accordingly and committed (see below); this file is the evidence trail for that edit.

## S1 — git and deploy state

CONFIRMED: all of `HEAD`, `s006/tracker-integrity`, `main`, `origin/main`, `origin/s006/tracker-integrity`, and both branches' GitHub API tips resolve to `18b716b16e8c2c1e4f1b70dd2bd36e47ed8ba566`. Zero unpushed commits anywhere in this clone (checked every local branch against its own `origin/<name>`, not just the two named branches). Live theme version (HTTP header, enqueued handle, and a direct byte-for-byte fetch of `style.css`, sha256-identical to the working tree) = **1.5.40**, matching the claim.

Two wording flags, neither a real problem:
- "Both remotes" is imprecise — this clone has **one** remote (`origin`); the claim meant two remote-tracking *refs*, not two remotes.
- "Zero divergence anywhere" is false if read as the whole clone: an unrelated branch, `feat/s006-a11y-close`, is 1 commit behind its own `origin/feat/s006-a11y-close` (not ahead — nothing unpushed, just a stale local copy of a branch nobody named in the claim).

## S2 — accessibility-closure completeness

**FALSIFIED.** Reading the nine `XVAL-*` files already on disk (no fresh crawl), the line found two open items the four-item list did not name, and one "Landed" line whose cited evidence does not actually support it as currently written:

- **Missing: 200% text/zoom clipping.** `XVAL-CONSOLIDATED`'s confirmed defect 5 and `XVAL-C2` directly: the 0px overflow metric hides real clipping (skip link over the brand, home `h1` at y=−150, FAQ heading over the nav, `zoom:2` pushing the burger/EN 100+px off-screen).
- **Missing: the published statement still asserts false things.** `XVAL-C3` marked FALSE: "full keyboard nav, visible focus on every control," "contrast adapted including keyboard focus," and the 200%-no-clipping claim above.
- **Focus-ring item was under-scoped.** Item 1 named only the skip link (1.06:1) and `.btn--terra` (1.65:1). `XVAL-B1` also measured the brand link at 2.54:1 and the EN toggle at 2.90–3.00:1 — both under the same 3:1 floor. Same defect class, just two more instances than named.
- **"The last failing contrast chip" (Landed) does not hold as cited, but the underlying thing IS actually fixed.** `XVAL-B2` (theme 1.5.39) measured the `/treatment/` + `/lessons/` active tag chip at 4.2573:1 FAIL. S2's own live spot-check, run today after that XVAL wave, found the theme had moved to **1.5.40** and the same chip now measures **4.6255:1 PASS** (new fill colour `--terra-btn #B05F38` replacing `--terra`). So: real fix, real close — just not provable from the cited XVAL file, which predates it. A fresh cross-engine artifact for 1.5.40 does not exist.
- **The statement now has the SAME chip claim wrong in the opposite direction.** S2's spot-check found `/accessibility/` still names "the selected topic tag" as a current failure in its limitations section — false as of 1.5.40, for the reverse reason: the chip now passes.
- **Four "Landed" bullets are not measured by any of the nine XVAL files at all** (submenu `aria-expanded`, Hebrew CF7 validation, the D-8 blank prompt, duplicate-photo removal) — not falsified, just not re-confirmed by this evidence pool. Flagged as COULD NOT MEASURE from this evidence, not as wrong.

## S3 — typography facts

**FALSIFIED**, on nearly every specific number, though the general narrative direction (no type scale, real weight/family inconsistencies) survives.

- **242 + 21 declaration count: wrong on both halves.** 242 turned out to be a raw substring count across three CSS files that never all load together on the same page (`chapters.css` 114 + `ea-atoms.css` 95 incl. 2 comments + `books-v2.css` 33, and `books-v2.css` doesn't load on `/` or `/method/` at all). What actually loads on `/` carries **247** hardcoded `font-size` declarations. `style.css`'s 21 is real as a total, but only 7 are hardcoded — the other 14 are `font-size: var(...)`, which the claim's "plus 21 more" wording counted as if they were additional hardcoded sizes.
- **"The only `font-size:var()` rule": there are 14, not 1** — all in `style.css` lines 147–237, all scoped to `body.ea-home-dashboard …`. The "matches zero live elements" half is correct (confirmed: nothing adds that body class).
- **Nav size is not one designed/live pair.** Two competing rules give **different live sizes to different nav elements**: `<a>` items render 12.8px (`.nav__l a` wins), the two `<button class="nav__dd">` dropdown triggers render 12.48px (`.nav__dd` wins there instead, since the higher-specificity rule doesn't match a button). The "not smaller than designed" conclusion still holds; the specific pairing does not.
- **Weight histogram is close but wrong, and is one file, not "live."** `chapters.css` alone: 500×**26** (not 27), 300×14, 400×9, 600×**8** (not 7 — a same-day `h3{font-weight:600}` addition), 700×2, 800×2. Adding the other loaded sheet (`ea-atoms.css`) changes the distribution substantially. Headings-vs-design: h1 and h2 really are 3–4 steps over the D-14 100–400 tokens; **h3 is only 1 step over**, not 3–4 — the blanket phrasing overstated h3. Body/nav weight 300 confirmed live; `.lead` is declared 300 but has **zero live elements** on either page checked.
- **Font-family claim was backwards on H1.** Every sampled `<h1>` renders in **Heebo**, not Frank Ruhl Libre. `--hf`/`--bf` are indeed declared identically (confirmed: the heading/body font distinction is fictional). Frank Ruhl Libre **is** live — via `--display` on `.fstep__t` / `.mag-list__t` / `.btile__t`, and via `--serif` directly on `.bookcard__t` (book titles, which render as real `h2`/`h3`) — just not on headings generally, so "every other heading renders in Heebo" also overstates it. Carousel arrows falling through to the OS system font, and Rubik fetched-but-unused (faces stay `unloaded`): both confirmed as stated.
- **Bonus, while measuring:** the "last combination shown" example in the typography section rounds two of its five outputs (h2, nav) to a value the PHP doesn't actually emit — it emits 24.65 and 18.36; the document said 24.6 and 18.4. h1/h3/body matched exactly.
- **Also observed, not one of the five claims:** `style.css` was seen enqueued under a `?ver=1.5.42` handle during this line's pass, after S1 and S2 (run earlier in this same batch) had both independently confirmed **1.5.40** with byte-level evidence. Not reconciled — noted as a live version possibly moving again during this very verification window. Re-measure fresh; do not trust 1.5.40, 1.5.42, or any other number here as current without re-checking.

## S4 — preview-tool behaviour

**FALSIFIED** on wording, not on safety. The activation gate (`ty` required) and the host restriction (`/\.upress\.link$/i`, end-anchored, case-insensitive, no path found that admits a non-staging host) are both exactly as claimed — **CONFIRMED**, and no production-affecting gap was found.

- **"Emits only a `<style>` block": not quite.** With `grid=1` it also emits a second `<style>` plus a `<div id="ea-typro">` debug HUD; with `demo=1` (an unlisted parameter in the same file) it injects a small script. Neither writes to the database, a file, or any other request — that part of the safety claim holds; the word "only" does not.
- **"Every parameter is clamped": mechanism is different, safety holds.** Out-of-range input is **rejected to the coded default**, not snapped to the nearest bound — `?ty=10` and `?ty=29` both fall back to 17 (the default), not to 11 or 28. Confirmed for every listed parameter; no path was found that lets a value through unsanitized, and a literal CSS-injection attempt (`?ty=17;}body{background:red`) produced no injected rule. One file-comment error found in passing: the code's real range for `navc` is 50–100; the comment says 60–100.
- **The worked example: h1/h3/body matched; h2 and nav did not, at the rounding level** (24.65 not 24.6, 18.36 not 18.4 — see S3's bonus note above, same pair of numbers, found independently by two different lines).

## S5 — row-rhythm numbers

**CONFIRMED**, all four claims as written in the handoff document, both by static analysis (reading the 33 defaults files and the actual render loop) and by a live sample of 5 pages that matched the static picture exactly. The render loop (`page-templates/tpl-chapters-*.php`, not `chapters-render.php`) genuinely has no index/parity-based logic; exactly 4 of 33 defaults files set a truthy `alt`/`dark` flag; 6 of the 24 non-hero body-part templates have no live include anywhere (schema/ACF leftovers reference their names, but nothing renders them).

One disagreement found, not in the four claims and not in the handoff document itself — it's in the underlying findings doc, `_COMMUNICATION/team_100/S006/FOUND-ROW-RHYTHM-GAP-2026-09-18.md`, which is outside this correction's scope: that file says "only three [pages] reach as many as three [alternating rows]"; independent counting found **four** (lessons 3, mokesh 3, snoring-sleep-apnea 3, and media/testimonials **4**). Flagged here for whoever owns that file; not corrected by this pass.

## What changed in the handoff document

See the commit that accompanies this file. Corrected: the accessibility open-item list (widened from four items to six, one "Landed" closure re-dated with a currency caveat, four unmeasured "Landed" bullets flagged as such), the typography bullet list (numbers replaced with S3's measured ones, the H1 font-family claim corrected), and the "both remotes" wording in the git section. Not touched: the row-rhythm section (nothing to correct) and the specific `navc` comment / example-rounding in `ea-type-preview-staging.php` itself (a code comment and a display-rounding nit, not a state-document claim — left for whoever next touches that file).
