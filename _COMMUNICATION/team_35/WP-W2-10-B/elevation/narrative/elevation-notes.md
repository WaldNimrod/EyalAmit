# Elevation Notes — WP-W2-10-B · Editorial (`tpl-content`)

**Primary route:** `/about`. Shares `tpl-content` with `/press`, `/about/moksha`.
**S1 source:** `_COMMUNICATION/team_35/WP-W2-10-B/mockup/editorial-about.html`.

## Changes vs S1 (zero new tokens/atoms)
| # | Section | What changed | D-14 atoms |
|---|---|---|---|
| 1 | Hero | S1 used a plain section-intro header. **Elevated to a dark editorial hero** (Ink bg) with kicker + H1 + lead + **real portrait** in a 1fr/300px split (reuses bio-block grid logic). | `section-intro` tokens recomposed on `--ea-ink`, `cta-pill` |
| 2 | Meta strip | NEW scannable strip (פועל מאז / שיטה / סטודיו / ספרים) built from caption + body tokens. | type tokens only |
| 3 | Long-form intro | Kept, set as readable measure (65ch). | `section-intro` |
| 4 | "המרכז" | Kept; first paragraph promoted to `.lead` (1.15rem). | `content-section` |
| 5 | **Journey timeline (NEW)** | Promoted the bio into a **6-cell dated timeline** using `.ea-pillar` atoms (label=year). Gives long-form reading + structure. | `content-section--alt`, `.ea-pillar`×6 |
| 6 | **Mokesh memorial (elevated)** | S1 had a pullquote only. Elevated to a **dedicated section** with a circular memorial disc (1950–2020) + pullquote — honors the "dedicated block, not just a link" requirement. | `content-section`, `pullquote` (composed: `border-inline-start` + terracotta), memorial disc (composed from line + type tokens) |
| 7 | Studio + gallery | Swapped one gallery cell to **real studio photo**; rest graceful gaps. | `book-gallery` atom pattern |
| 8 | Books cross-link | Added **real cover row** (3 covers) above the services-grid tiles → links to /about/moksha + /books. | `services-grid`, `service-tile` |
| 9 | CTA | Kept (Ink contact band). | `contact-section`, `cta-pill` |

## Hierarchy
Single H1 (hero). Timeline + memorial give "long-form reading + biography" depth (AC-E1 Editorial intent).
Reading measures capped 65–72ch. AA contrast holds on both `--ea-bg` and `--ea-ink` surfaces.

## GCR flags
**None.** Memorial disc + meta strip + timeline are compositions of existing tokens/atoms (line, type, space, `.ea-pillar`). No new atom defined.

## Route fan-out (S3)
`/press` = same shell, swap body to press clippings + testimonials grid (reuse `service-tile`/gallery).
`/about/moksha` = same shell, lead with the memorial disc + long-form Mokesh biography.
