# Asset Manifest — WP-W2-10-F (/en)

**Date:** 2026-05-31 · team_35 · S1

## Present (no Eyal action needed)
| Asset | Path | Role | Status |
|-------|------|------|--------|
| Hero portrait | `site/wp-content/themes/ea-eyalamit/assets/home/eyal-portrait-hero.jpg` (708 KB) | Hero background (`.ea-en-hero` background-image, referenced by `ea_w2_08_render()`) | ✅ Present. Mockup uses a token gradient/ink fallback so it renders standalone; production wires this JPG. |
| Social icons (FB/IG/YT/TikTok) | Inline SVG (`currentColor`) in `block-footer-social.php` | Footer social row | ✅ Inline, no file dependency. |
| WhatsApp icon | Inline SVG | `.ea-whatsapp-float` | ✅ Inline. |

## Gaps / Eyal decisions required
| Item | Gap | Needed for |
|------|-----|-----------|
| WhatsApp number | Mockup uses placeholder `wa.me/972000000000` | Real E.164 number for the float CTA (confirm same as HE site). |
| Contact CTA target | All 4 CTAs point to `#contact` in mockup; production = `/contact?lang=en` (`ea_w2_08_cta_url()`) | Confirm `/contact` accepts `?lang=en` and pre-sets the EN subject. |
| Hero image optimization | 708 KB JPG | Perf ≥85 (AC-U2): recommend responsive `srcset` / WebP + `loading`/`fetchpriority` at S3 — flag, not an S1 fix. |
| EN testimonial avatars | None used (text-only `<figure>`) | Optional — RTL site testimonial atom has avatar slot; /en omits by design. Confirm acceptable. |

## Notes
- No new image atoms introduced. Optional book covers were deliberately omitted from the EN page (books are described in prose, not the RTL `atom-content-book-card` grid) to keep the EN page a single-scroll summary per W2-08 spec ("English summary, not a full translation").
