# Asset Manifest — WP-W2-10-C (Conversion cluster)

**Team:** team_35 · **Stage:** S1 · **Date:** 2026-05-31
Composition-only: the conversion routes are **text + form + CTA**; they carry almost no media. Nothing is asset-gated for sign-off.

## Assets used in the mockups
| Asset | Type | Source / status |
|-------|------|-----------------|
| Heebo webfont | font | D-14 `--ea-font` stack; system fallback in mockup (no external load → perf-clean) |
| WhatsApp / chevron glyphs | inline text (`⟢ ▾ ✓`) | typographic placeholders, `aria-hidden`. No icon files. team_10 may swap for the D-14 icon set at S3. |
| Colors / spacing / radii | D-14 tokens | inlined verbatim from `ea-tokens.css` |

## Assets Eyal must still provide (open)
| Need | For | Blocking? |
|------|-----|-----------|
| **CF7 form created in wp-admin** | `/contact` real form (resolves `form_id=0`) | **Blocks AC-C2**, not S1 sign-off. See HANDOFF Q1. |
| Real WhatsApp number / wa.me link + variant copy approval | `/contact` WhatsApp A/B CTAs (placeholder `wa.me/0000000000`) | Not blocking; copy is mockup-drafted from FAQ tone. |
| Phone / email / address (if to be shown on /contact) | optional contact-details block | Not in current template; only add if Eyal wants it. See HANDOFF Q3. |
| Published Q&A for 5 empty FAQ categories (bags, stands-storage, stand-floor, repair, general) | `/faq` completeness | Not blocking; shown as "תוכן בהכנה". See HANDOFF Q2. |

No images, video, or downloadable media are required for this cluster.
