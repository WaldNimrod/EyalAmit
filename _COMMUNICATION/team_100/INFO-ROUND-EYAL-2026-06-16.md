# Info round from Eyal — intake log (2026-06-16)

**Received by:** team_00 → team_100 · **Channel:** WhatsApp message + Google Drive + a video file.

## Materials received
1. **Homepage video (draft/"sketch"):** `~/Downloads/סרטון לאתר של אבא .mov`
   - Source: HEVC (h265), 1920×1080, 30 fps, **42.9 s**, 10.8 Mbps, **57.9 MB**.
   - Not web-universal (HEVC) and too heavy for a hero. Working compressions produced in
     `local/video-work/` (NOT deployed — draft for presentation):
     - `ea-home-hero-720-muted.mp4` — H.264, muted, 720p, faststart → **6.1 MB** (presentation-ready hero loop)
     - `ea-home-hero-1080-muted.mp4` — H.264, muted, 1080p → 13.7 MB
     - `ea-home-hero-poster.jpg` — poster frame
2. **Doc package (Drive):** https://drive.google.com/drive/folders/1dQsLA5hhNVagXFSTdz2hs5ilkMLKfCsA
   - This folder **syncs locally** to `docs/.../from-eyal/תוכן לאתר 25.5.26/` — verified: it is the
     SAME `25.5.26` source set we built CR1–CR4 from (the `.md` files are unchanged in git since our
     build; only Drive `Icon` sync-metadata touched 2026-06-13). **No new/changed source docs.**

## Eyal's 9 feedback points (verbatim summary)
1. Pages show only 3 FAQ; the docs have more.
2. Only 3 testimonials per page; wants more + a left/right moving carousel.
3. Full FAQ page needs clearer section separation + a small top menu (TOC) that jumps to each topic.
4. "מוזה הוצאה לאור" content isn't what he sent.
5. The 3 books (צבע בכחול / כושי בלאנטיס / וכתבת) — content isn't what he sent.
6. Blog bottom pagination — pages 2,3,4,5 show no content (only page 1).
7. "אייל עמית" page is missing; full content is in the docs.
8. Mokesh page — content was invented, not what he sent.
9. Re-review ALL his docs — more pages not entered yet (stands, floor stand, repair, selling instruments).

## Critical reconciliation
Points 4,5,7,9 describe pre-CR1–CR4 (mockup) state. **CR1–CR4 (merged, triple-PASS 2026-06-05)
rebuilt all those pages verbatim from these exact docs.** Live verification (2026-06-16) confirms the
content is now present — so Eyal's view for those points is **stale / pre-rebuild / cached**. See the
mapping in the team_100 reply for the per-point status + actions.
