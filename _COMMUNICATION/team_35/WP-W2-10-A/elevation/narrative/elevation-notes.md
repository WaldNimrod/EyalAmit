# Elevation Notes — WP-W2-10-A · Service (`tpl-service`)

**Primary route elevated:** `/treatment`. Shares `tpl-service` with `/method`, `/sound-healing`, `/lessons`.
**S1 source:** `_COMMUNICATION/team_35/WP-W2-10-A/mockup/service-treatment.html`.

## Changes vs S1 (all via existing D-14 atoms — zero new tokens/atoms)

| # | Section | What changed | D-14 atoms used |
|---|---|---|---|
| 1 | Hero | Added `ea-hero__kicker` line ("המרכז לטיפול בדיג׳רידו · פרדס חנה") + a `ea-hero__trust` line + **CTA pair** (primary + ghost-white). Kept 3 breath-lines. | `atom-structure-hero-video` (gradient bg variant), `atom-feedback-cta-pill` (`--primary`, `--ghost-white`) |
| 2 | Intro | Kept; tightened body rhythm using `--ea-space-3` paragraph gaps. | `atom-structure-section-intro` |
| 3 | "מה זה" | Unchanged structurally. | `atom-structure-content-section` |
| 4 | **cbDIDG method (NEW emphasis)** | Promoted the method into a **4-step grid** (אבחון→תרגול→שליטה→הטמעה) so the flagship route shows the process, not just prose. Built from `.ea-pillar` atoms in a 4-col `--steps` modifier (composed with existing grid token values; no new atom). | `atom-structure-content-section--alt`, `.ea-pillar` ×4 |
| 5 | "למי מתאים" | Promoted "who it's for" into a 5-tile pillar grid for scannability/conversion. | `.ea-pillar` ×5 |
| 6 | Session | Swapped the portrait **placeholder → real photo** (`eyal-portrait-hero.jpg`). | `atom-content-bio-block` |
| 7 | Comparison | Kept (treatment vs sound-healing vs lessons), marks current page active. | `service-comparison` |
| 8 | Testimonials | Kept 3 real quotes (proof band). | `testimonials-section`, `testimonial-card` (avatar placeholder = Eyal gap) |
| 9 | FAQ-mini + disclaimer + CTA | Kept verbatim; disclaimer is legally required content from staging. | `faq-mini`, `disclaimer`, `section--cta` |

## Rhythm / hierarchy notes
- Section pacing uses `--ea-section-padding` (=`--ea-space-15`, 120px) on desktop, `--ea-space-10` (80px) mobile — deliberate breath between blocks.
- One H1 (`ea-hero__title`), all section titles are H2; pillars use H3/`.ea-pillar__title`. AA contrast preserved.

## GCR flags
**None.** All elevation achieved by recomposing existing atoms. The 4-step `--steps` grid modifier reuses
existing grid + `--ea-space` tokens; it does **not** introduce a new token value or a new atom definition.

## Route fan-out for S3 (team_10)
`/method`, `/sound-healing`, `/lessons` use the same `tpl-service` shell — reuse this elevated composition,
swapping section copy from each route's staging content. The cbDIDG 4-step block is most relevant to `/treatment`
and `/method`; for `/lessons` swap to a musical-progression framing, for `/sound-healing` to a passive-session framing.
