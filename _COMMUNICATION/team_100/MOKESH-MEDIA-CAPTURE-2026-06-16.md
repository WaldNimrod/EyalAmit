# Mokesh page — media capture (photos + FB embeds) · 2026-06-16

**Decision (Eyal, 2026-06-16):** the mokesh page uses **the SAME photos as the original live page, in the SAME order**,
and adds **all the Facebook post embeds at the bottom**. Source page:
`https://www.eyalamit.co.il/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/מוקש-דהימן-מאסטר-דיגרידו-דף-להנצחת-זכ/`
Captured by team_100 (WebFetch for images, raw-HTML grep for FB embeds). Resolves intake **I5 (photos)**.

## Photos — 19, in document order
Filenames are stable on the live site (`/wp-content/uploads/2021/10/` except #14 `2025/08/`). Most are already in the
legacy-media mirror under `_COMMUNICATION/team_40/legacy-media-index-50…/mirror/2021/10/` — prefer local copies; the
URLs below are the authoritative order + identity. (Base slug: `nukesh-dhiman-jungel-vibes-rishikesh-india-didgeridoo-מוקש-רישיקש-דיגרידו-<NN>`.)

| # | file # | URL |
|---|---|---|
| 1 | 39 | `…/2021/10/…דיגרידו-39-450x450.jpeg` (alt: מוקש דהימן רישיקש mukesh dhiman rishikesh) |
| 2 | 45 | `…/2021/10/…דיגרידו-45-450x450.jpeg` |
| 3 | 54 | `…/2021/10/…דיגרידו-54-450x338.jpeg` |
| 4 | 101 | `…/2021/10/…דיגרידו-101-450x319.jpeg` |
| 5 | 97 | `…/2021/10/…דיגרידו-97-450x253.jpeg` |
| 6 | 48 | `…/2021/10/…דיגרידו-48.jpeg` |
| 7 | 44 | `…/2021/10/…דיגרידו-44-400x400.jpeg` |
| 8 | 156 | `…/2021/10/…דיגרידו-156-450x253.jpeg` |
| 9 | 166 | `…/2021/10/…דיגרידו-166-450x338.jpeg` |
| 10 | 57 | `…/2021/10/…דיגרידו-57-338x450.jpeg` |
| 11 | 123 | `…/2021/10/…דיגרידו-123-450x253.jpeg` |
| 12 | 176 | `…/2021/10/…דיגרידו-176-450x253.jpeg` |
| 13 | 66 | `…/2021/10/…דיגרידו-66-450x338.jpeg` (alt: מוקש דימן mukesh dhiman jungle vibes) |
| 14 | 159 | `…/**2025/08**/…דיגרידו-159-600x338.jpeg` |
| 15 | 151 | `…/2021/10/…דיגרידו-151-450x338.jpeg` |
| 16 | 149 | `…/2021/10/…דיגרידו-149-450x338.jpeg` |
| 17 | 41 | `…/2021/10/…דיגרידו-41-248x450.jpeg` |
| 18 | 40 | `…/2021/10/…דיגרידו-40-330x650.jpeg` |
| 19 | 43 | `…/2021/10/…דיגרידו-43-330x650.jpeg` |

> NB filenames carry `jungel` (typo) — that's the **filename only**; do not "correct" file paths. Per **D-SPELLING**,
> fix only **visible brand text** to `Jungle Vibes` (the img #13/#14 alt text already reads "jungle vibes").

## Facebook post embeds — add ALL at the page bottom (4)
Rendered on the original via `facebook.com/plugins/post.php?href=…&show_text=true&width=500`. Original post URLs:
1. `https://www.facebook.com/IsraelDidgCenter/posts/pfbid02G6viGTqgqTHFv36najD6n9T6yskVpC5UfWx1RzrbNTqNMfTYRKrJkzkqHH2taffXl`
2. `https://www.facebook.com/eyal.amit.muzza/posts/pfbid033bDz4Wj8Pc6K3nF58VuXBUHkfoNKPZa4wTsxhPSUVHANHwZT3rAqj1oUAGXzwTm6l`
3. `https://www.facebook.com/eyal.amit.muzza/posts/pfbid0zekNyNV6dztxGnwQKaLg9GhSAwSsjMWR2jaqQtAkZMLAHWNhKem12AknNrsCAJZRl`
4. `https://www.facebook.com/gemma.calaf/posts/pfbid0gsUdiLtCCghgQp9RuyPncdb4NRojZ3k5LdxMqfeNPinvQd9x6Y7j6Jrp9VUThqiEl`

**Build notes:** lazy-load the FB SDK (`connect.facebook.net/he_IL/sdk.js`) or use `plugins/post.php` iframes to avoid a
performance hit (Core-Web-Vitals — see the SEO/GEO plan); RTL/he locale; embeds go **below** the YouTube trailer.
Related FB pages referenced on the page (not embeds): `didgeridoo.studio.eyal.amit`, `eyal.amit.show`,
`mukesh.the.art.of.shanti.living.the.movie` (the film's page).

## Video + page composition (DECIDED by Nimrod, 2026-06-19)
- **HERO (top of page):** the **trailer** (`kf4NKSdYi9E`) as a hero video — **autoplays on load, muted by default, with an unmute control — exactly like the home-page hero** (the D-EYAL-VIDEO-13 pattern; reuse `block-hero.php` + `ea-hero.js`).
- **Body order:** memorial text (full doc, verbatim, `Jungle Vibes`) → **19 photos in the order above** → **THE FULL FILM** (on-demand full viewing, further down the page) → **4 Facebook post embeds** (very bottom).
- ⚠ **Full-film link is NOT public** — verified 2026-06-19: only the *trailer* is on YouTube; the **1-hour film** ("MUKESH – The Art of Shanti Living", by **Eyal & Guy Amit**) lives on the [FB movie page](https://www.facebook.com/mukesh.the.art.of.shanti.living.the.movie/) / screenings, not a public video URL. **Need the full-film link from Eyal** (likely an unlisted YouTube/Vimeo) — or embed the FB movie page. Until provided: ship the hero trailer + a clearly-marked full-film placeholder; page stays launch-valid.
- **Schema:** `VideoObject` JSON-LD for both clips (name, embedUrl, thumbnailUrl) — feeds the SEO/GEO video surface (see LOD400 plan).
