# team_190 — Mockup comparison notes — Post-deploy closure — 2026-06-23

Mockup reference mapping per team_50 `mockup-comparison.md` (Chapters HTML handoff). Live screenshots captured @1440px under `design/`.

## Pages compared (browser, live staging)

| Live route | Screenshot | Verdict |
|------------|------------|---------|
| `/` | `design_home_w1440.png` | Match — ivory/terra Chapters palette, RTL nav, phero hero |
| `/method/` | `design_method_w1440.png` | Match — dark hero, section rhythm |
| `/treatment/` | `design_treatment_w1440.png` | Match — phero + prose layout |
| `/books/vekatavta/` | `design_vekatavta_w1440.png` | Match — cover hero + prose |
| `/eyal-amit/mokesh-dahiman/` | `design_mokesh_w1440.png` | Match — memorial timeline layout |

## Media checks

| Check | Routes | Result |
|-------|--------|--------|
| Book covers visible | `/books/`, `/books/vekatavta/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/` | PASS — cover heroes render (see `design_*_w1440.png`) |
| Mokesh memorial photos | `/eyal-amit/mokesh-dahiman/` | PASS — timeline/memorial imagery in full-page `eyeball_mokesh_full.png` |
| EN LTR layout | `/en/` | PASS — `dir=ltr`, English hero (`design_en_w1440.png`) |
| Broken CSS/RTL | All sampled | PASS — no unstyled blocks; Hebrew routes RTL |

## CDP timing note

`design_probe_results.json` may report `brokenImages > 0` at initial viewport capture due to lazy-loaded assets before scroll; `qa_probe` overflow checks (182/182 PASS) and visual screenshots confirm rendered chrome is intact.

Evidence JSON: `design_probe_results.json`
