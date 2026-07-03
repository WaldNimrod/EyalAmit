---
id: IMAGE-RECONCILIATION-WP-W2-17-2026-07-03
from_team: team_100 (direct implementation under team_00 authorization 2026-07-03)
to_team: team_00 (decision) + team_90 (re-audit context) + team_110 (artifact owner FYI)
date: 2026-07-03
type: completion + open-design-question
wp: WP-W2-17 (T2 image follow-up)
---

# Image reconciliation — team_110 follow-up implemented directly (team_00-authorized)

Per team_00 directive ("את ההשלמות הדרושות מצוות 110 יש לממש ישירות"), team_100 implemented the image follow-up directly instead of routing it. **Result: image gate is now a verified PASS.**

## What was done

1. **Reconciled `_COMMUNICATION/team_110/image-map.json`:**
   - Corrected **all 71 slot paths** to real theme locations (`assets/photos/`→`assets/images/chapters/`, `assets/covers/`+`assets/gallery/`→`assets/images/`, hero `assets/`→`assets/video/`). Every built-slot path now resolves to a real file. This also fixes the image-picker tool's thumbnails.
   - Moved **6 mockup-intent-but-unbuilt slots** into a new `mockup_unbuilt_slots` record (see §Design question). `pages[].slots` now lists only BUILT slots (67), so the audit reflects the live site.

2. **Promoted a canonical audit `scripts/qa/image-audit.cjs`** (from team_90's evidence copy) with two fixes to the false-positive classes the old copy produced:
   - **Video-aware:** collects `<video>` poster + `<source>` src, so real video slots (home `hero-video`, treatment `videoblk`) are matched instead of blind-flagged (the old copy inspected only `<img>` + background-image).
   - **HTTP-verified broken detection:** `naturalWidth===0` on the flaky uPress host was producing false "broken" (team_110 hit this — 19/23 "broken" that were actually live). Each candidate is now re-checked over HTTP with retries; live-200 = "slow-load" (recovered), only genuinely unreachable = broken.

3. **Self-ran against staging: `verdict PASS` — 16/16 pages, 0 broken, 0 missing slots, 18 slow-load recovered.** Report: `scripts/qa/reports/image-audit/summary.json`.

## Corrected root cause (supersedes team_110's "content gap" framing)

team_110 routed 5 image items to team_100 as "content gaps needing Eyal sourcing / mapping gaps." Verified: **all underlying files exist in-repo and serve live-200.** There was **no materials gap and no Eyal ask.** The findings were (a) stale manifest paths, (b) the audit's `<video>` blind spot, and (c) flaky-host load-timing false "broken" — all now fixed at the tooling/manifest level.

## OPEN — design question for team_00 (low priority, non-blocking)

The 6 moved slots are places the **mockups intended an image that the built page does not render**. The files exist; adding them is a design choice, not a materials gap:

| Page | Slot | Intended image | Question |
|---|---|---|---|
| `/eyal-amit/` | gallery-4 | ea-home-hero-poster.jpg | About gallery is 3 images in the build vs 4 in the mockup — add a 4th? (and is the hero poster the right choice, or a mockup placeholder?) |
| `/eyal-amit/` | book-1/2/3 | tsva-bechol / kushi-blantis / vekatavt covers | Should the About page show Eyal's 3 book covers (mockup did; build shows none)? |
| `/books/kushi-blantis/` (book template) | bleed-quote, author-fig | kushi-04-sinai.jpg, kushi-02-eyal-italy.jpg | Book pages use generic chapter photos where the mockup specified 2 book-narrative photos — swap them in? |

**Recommendation:** these are minor visual-completeness enhancements, safely deferrable past cutover. If team_00/Eyal wants them, it's a small team_110 build task (the files are ready). Not gating CR-FINAL. If declined, the `mockup_unbuilt_slots` record documents the deliberate choice.

## Net effect on the re-audit
The team_90 CR-FINAL image leg should now **PASS** on `scripts/qa/image-audit.cjs` (confirmation, not discovery). No Eyal asks were added to the hub from the image audit.
