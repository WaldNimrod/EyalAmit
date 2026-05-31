# Asset Manifest — WP-W2-10-B (Editorial cluster)

**team_35 · S1 · 2026-05-31 v1** · Status legend: ✅ exists · 🟡 optional enhancement · 🔴 Eyal must provide (blocking AC)

## Real content (already on staging — verbatim, no asset gap)
| Asset | Source | Status |
|-------|--------|--------|
| /about copy (H1, lede, הדרך, הסטודיו, CTA) | staging `/about/` (HTTP 200) | ✅ |
| /press clips list (years 2009–2016, publications, links) | staging `/press/` (HTTP 200) | ✅ |
| /press "ממליצים" quotes (5 recommendations, named) | staging `/press/` | ✅ |
| /about/moksha narrative (full prose) | staging `/about/moksha/` (HTTP 200) | ✅ |
| Brand tokens, all 17 atom patterns | D-14 ea-tokens.css + ea-atoms.css | ✅ |

## Eyal-needed assets
| # | Asset | Used by | AC | Status | Notes |
|---|-------|---------|----|--------|-------|
| A1 | **Eyal portrait** (4:5, high-res) | /about bio-block | **AC-B2 (blocking)** | 🔴 | The acceptance criterion is explicit: bio block must be a REAL portrait, not a placeholder avatar. Mockup shows a `--ea-sand` placeholder with `role="img"` until delivered. |
| A2 | **Studio photos** (≥4: חצר/מרחב טיפול/עצי פרי/שבילי עץ) | /about media gallery | AC-B1 (review quality) | 🔴 | Gallery atom expects 1 hero (16:7) + 3 (4:3). Currently grey placeholders. |
| A3 | **Moksha portrait / archival photo** | /about/moksha bio-block | AC-B1 | 🔴 | Portrait of מוקש דהימן (or India/workshop archival). Placeholder otherwise. |
| A4 | **Publication logos** (Eventer, ynet, Headstart, mako, הארץ, וואלה, צוותא, Wikipedia) | /press clips | — | 🟡 | OPTIONAL. Default /press composition is text-only (publication names as labels) and ships with zero asset blockers. Logos are an enhancement; many are third-party marks with usage constraints. |
| A5 | WhatsApp number + correct `wa.me` deep-link | whatsapp-float, CTA | AC-B1 | 🔴 | Mockup uses placeholder `https://wa.me/`. Confirm number / message prefill. |

## Notes for S3 (team_10)
- /press is the only route with NO blocking asset gap → can be built first.
- Recommendation avatars deliberately use the atom's circle placeholder (`__avatar-placeholder`) — NOT counted as an asset gap (matches deployed atom behavior).
- All placeholders in the mockup are clearly labeled so Eyal evaluates layout, not missing imagery.
