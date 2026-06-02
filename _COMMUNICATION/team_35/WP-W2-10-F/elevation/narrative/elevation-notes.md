# Elevation Notes — WP-W2-10-F · EN landing (`tpl-en-landing`)

**Route:** `/en`. LTR mirror of the RTL design system.
**S1 source:** `_COMMUNICATION/team_35/WP-W2-10-F/mockup/en-landing.html`.

## Changes vs S1 (zero new tokens/atoms)
| # | Section | Change | Atoms / mirror |
|---|---|---|---|
| 1 | Hero | Added `ea-en-hero__kicker` + layered **gradient treatment** (was flat dark) + 2 breath-lines. Title tightened. | `ea-en-hero`, `cta-pill --ghost-white` |
| 2 | About | Added section label; kept real EN copy. | `ea-en-section` |
| 3 | Method | Principles kept as a scannable `ea-en-list`; tightened. | `ea-en-section--alt`, `ea-en-list` |
| 4 | Services | Condensed to the 3 paths (therapy/sound/lessons) for scannability. | `ea-en-section` |
| 5 | **Books** | Added **real cover row** (3 covers) for credibility before the prose. | `ea-en-books-row` (composed) |
| 6 | Testimonials | Kept 4 strongest translated quotes (was 8 → tightened for pacing) + closing CTA. | `ea-en-testimonial` grid |
| 7 | Footer | Social row + nav, LTR. | `footer-social` |

## LTR mirror correctness (AC-E3)
- `body{direction:ltr;text-align:left}` (RTL system is rtl/right).
- Logical properties flip automatically: `inset-inline-start` (skiplink, whatsapp), `padding-inline-start` (list bullets → left), `justify-content:flex-start` (footer nav/social).
- `lang="en" dir="ltr"` on root + main; language pill links back to Hebrew `/`.
- Type tokens use the D-14 `--ea-type-*` shorthands verbatim.

## GCR flags
**None.** Cover row + kicker + gradient hero are recompositions of existing tokens.

## Note for S3
Content is VERBATIM EN from `inc/wave2-w2-08.php` (team_30). If team_30 revises EN copy, re-sync.
Testimonials trimmed 8→4 for pacing — full set remains available in the W2-08 source if Eyal prefers all.
