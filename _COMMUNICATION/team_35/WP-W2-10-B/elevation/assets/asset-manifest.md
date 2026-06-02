# Asset Manifest — WP-W2-10-B · Editorial

## Real assets used (`shared-assets/`)
| Asset | Mockup path | Notes |
|---|---|---|
| Eyal portrait | `assets/eyal-portrait-hero.jpg` | Hero split. Final → high-res studio portrait. |
| Studio photo | `assets/hero-wide-studio.jpg` | Studio gallery, first cell. |
| 3 book covers | `assets/covers/*.jpg` | Books cross-link row. |

## Eyal-gap placeholders (flagged)
| Placeholder | Location | Required asset | Swap path | Ratio |
|---|---|---|---|---|
| Studio gallery cells ×3 | Studio section | Real studio photos (חצר, מרחב טיפול, שבילי עץ) | `.ea-book-gallery__item` → `<img>` | 4:3 |
| Mokesh portrait | Memorial disc (text-only now) | Optional Mokesh photo/painting | `.ea-mokesh-disc` → add `<img>` round-cropped | 1:1 |

## Swap instructions (S3)
- Memorial disc is intentionally text-only and dignified; only add a Mokesh image if Eyal approves (sensitive content).
- Studio gallery: fill remaining 3 cells from Eyal's studio photo set; keep the 16:7 lead cell.
