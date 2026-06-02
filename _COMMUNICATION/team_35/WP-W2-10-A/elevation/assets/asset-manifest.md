# Asset Manifest — WP-W2-10-A · Service

## Real assets used (in package `shared-assets/`)
| Asset | Mockup path | Source | Notes |
|---|---|---|---|
| Eyal portrait | `assets/eyal-portrait-hero.jpg` | legacy `to-eyal/_shared-assets/home-preview/` | Session section. Final swap → high-res studio portrait. |

## Eyal-gap placeholders (graceful, flagged — NOT faked)
| Placeholder | Location | Required asset | Swap path | Target ratio |
|---|---|---|---|---|
| Testimonial avatars | Testimonials band ×3 | Real participant photos OR keep neutral sand circle | `.ea-testimonial-card__avatar-placeholder` → `<img>` | 48×48 circle |
| Hero background | Hero (gradient now) | Optional: studio/breath video or still (G cluster blocked) | `.ea-hero__gradient-bg` → media | 16:9 |

## Swap instructions for S3
- Replace `assets/eyal-portrait-hero.jpg` with the theme media-library URL.
- Avatar placeholders may stay as the neutral sand circle (design-acceptable) or take real photos when Eyal supplies them.
- Do not introduce shadows/gradients beyond the existing gradient hero (D-14 discipline).
