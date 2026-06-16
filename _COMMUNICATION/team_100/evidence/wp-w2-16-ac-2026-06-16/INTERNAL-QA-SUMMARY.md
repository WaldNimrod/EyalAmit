# Internal QA — WP-W2-16-A (hero video) + 16-C (FAQ TOC)

**Date:** 2026-06-16 · **By:** team_100 (Claude Code, builder) · **Branch:** wp-w2-16 · **Theme ver:** 1.4.8
**Staging:** http://eyalamit-co-il-2026.s887.upress.link · **Status:** INTERNAL PASS (pre-dual-PASS)

> Builder-side gate only. External cross-engine dual-PASS (team_50 → team_190) is the
> 16-F step and gates any "ready" to Eyal. NOT yet sent.

## 16-A — Home hero background video (D-EYAL-VIDEO-13 = ב)
- Live: `class="ea-hero__video"` + `<source ea-home-hero-720-muted.mp4>` + poster on `/`; `home-front.css?ver=1.4.8`.
- Treatment: muted, full-length loop, no sound control. No `autoplay` attr — JS starts playback only when
  `prefers-reduced-motion: no-preference`; reduced-motion users keep the static poster. Gradient = fallback.
- Shipped 720p only (6.1MB) + poster; `<source media>` is ignored inside `<video>`, and 1080 (14MB) is wasteful
  for a muted overlay-darkened bg loop. 1080 kept in `local/video-work/` for an optional later desktop upgrade.
- Screenshot home_w768.png: garden poster renders as hero bg with text overlay intact. ✓

## 16-C — FAQ topic navigation / TOC (Eyal #3)
- Live: sticky `<nav class="ea-faq-toc">` with **10/10** topic chips (`data-faq-toc-link`) matching **10/10**
  section anchors (`id="faq-topic-*"`); `faq-toc.css` + `ea-faq-toc.js` at `?ver=1.4.8`.
- Old `<select id="ea-faq-cat">` filter removed (0 occurrences live); `ea-faq-filter.js` retired.
- Screenshots: desktop chip bar wraps, scroll-spy active state (terracotta) on first topic; mobile (360)
  chips scroll horizontally in one row, label hidden, no page overflow. ✓
- Works without JS (chips are native `#faq-topic-*` anchor links); `?topic=<slug>` deep-link scroll-on-load.

## Gates
| Gate | Result |
|---|---|
| `validate_aos .` | 32 PASS / 20 SKIP / **0 FAIL** |
| `php -l` (all touched PHP) | clean |
| `node --check` (ea-hero.js, ea-faq-toc.js) | clean |
| qa_probe overflow @360/390/414/768 (home + /faq) | **0 overflow**, all pass |
| axe (14 routes incl / and /faq) | **0 critical / 0 serious** |
| Markup live + cache-busted | confirmed (ver=1.4.8) |

## Commits (branch wp-w2-16)
- `2726e9b` WP-W2-16-A hero video
- `1fc919e` WP-W2-16-C FAQ TOC
- `fb11c0a` version bump 1.4.7 → 1.4.8
- (base `82236f8` WP-W2-15 CR-FINAL closure on main)
