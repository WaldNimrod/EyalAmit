# Composition Notes — WP-W2-10-B (Editorial cluster)

**team_35 (Design Studio / claude-design) · S1 · 2026-05-31 v1**
Primary mockup: `../mockup/editorial-about.html` (route `/about`).
Composition-only. Every block reuses an existing D-14 atom (ea-atoms.css) and D-14 tokens (ea-tokens.css). No new atoms / no new token values.

## Editorial archetype (layout DNA)
Per LOD400 §Composition contract: **portrait/bio block + rich body + pullquotes + media gallery + related**. All 3 routes (`/about`, `/press`, `/about/moksha`) are instantiations of this single DNA on `tpl-content.php`. The DNA, top→bottom:

`topnav → section-intro (page header) → bio-block (portrait+lede) → breath-divider → content-section (rich body) + pullquote → breath-divider → content-section--alt (rich body) + media-gallery → services-grid (related routes) → contact-section (closing CTA) → footer-social → whatsapp-float`

## /about — screen-by-screen (flagship)

| # | Block | D-14 atom (ea-atoms.css) | Tokens / rationale |
|---|-------|--------------------------|--------------------|
| Nav | Sticky top nav | `atom-nav-topnav` (`.ea-topnav`) | `--ea-z-sticky`, `--ea-nav-height`. `aria-current="page"` on אודות. Skip-link first per atom contract. |
| 1 | Page header | `atom-structure-section-intro` (`.ea-section-intro`) | H1 = real title "אודות אייל עמית"; lede = real opening line ("…מאז 1999…"). `--ea-type-h2` weight 200, body-lg 1.05rem. Top padding offsets fixed nav (`--ea-nav-height` + `--ea-space-10`). |
| 2 | Bio + portrait | `atom-content-bio-block` (`.ea-bio-block`) | The AC-B2 block. 1fr/320px grid; figure `order:2` desktop, reflows above text on mobile (atom's own media query). Portrait = **placeholder until Eyal asset** — marked `role="img"` + `aria-label`. Body = real "המרכז לטיפול…" + "cbDIDG" paragraphs. bg `--ea-bg-alt`. |
| – | Divider | `atom-structure-breath-divider` (`.ea-breath-divider`) | `--ea-line`, `aria-hidden`. Rhythm between long-form sections. |
| 3 | הדרך (journey) | `atom-structure-content-section` (`.ea-content-section`) | Real "הדרך" body verbatim. + **pullquote** composed from D-14 type tokens (weight 200 / 1.4rem) + `--ea-terracotta` inline-start border — no new atom, a token-level composition of existing primitives. |
| 4 | הסטודיו + gallery | `content-section--alt` + `atom-content-book-gallery` (`.ea-book-gallery`) | Real "הסטודיו" body. Gallery reuses the book-gallery grid (first item full-bleed 16/7, rest 4/3) as the **media-gallery** required by the archetype. **Photos = asset gap**, grey placeholders with explanatory note. |
| 5 | Related | services-grid + `atom-service-tile` (`.ea-service-tile`) | "להמשך הקריאה" — two tiles linking the sibling editorial routes `/about/moksha` and `/press`. This is the archetype's **related** slot, reusing the existing tile atom rather than a bespoke card. |
| 6 | Closing CTA | `atom-feedback-cta-pill` (`.ea-cta-pill--primary`) inside `.ea-contact-section` | Real CTA copy "לתיאום שיחת היכרות" (verbatim from /about). centered contact-section variant. |
| Foot | Footer | `atom-data-display-footer-social` (`.ea-footer`) | Brand + פרדס חנה location + nav. |
| Float | WhatsApp | `atom-interaction-whatsapp-cta` (`.ea-whatsapp-float`) | Persistent conversion affordance; `inset-inline-start` (RTL-correct). |

Motion atoms (breathe / fadeUp) are intentionally NOT animated in the static mockup so Eyal evaluates composition, not motion (matches the `prefers-reduced-motion` disable block at top of ea-atoms.css).

## /press — reuses the same DNA
Same skeleton; the **rich-body** slot becomes a **press-clips list** and the **related/testimonials** slot becomes the "ממליצים" (recommendations) row.

- Header: `atom-structure-section-intro` → H1 "עיתונות" + real intro "אזכורים, כתבות וראיונות לאורך השנים. הקישורים נפתחים בלשונית חדשה."
- Press clips: render each clip as a row composed from the **`atom-service-tile`** pattern grouped under year sub-headings (2016 … 2009), publication name as `.ea-service-tile__label`, clip title as `__title`, with `↗` + `target="_blank" rel="noopener"`. Years (Eventer, ויקיפדיה, ynet, Headstart, mako, הארץ, וואלה, צוותא) come through verbatim. Reuses tile atom — no new "press-card".
- ממליצים (recommendations): reuse `atom-content-testimonial-card` (`.ea-testimonial-card`) in the 3-col `.ea-testimonials-grid`. Real quotes already on staging (שרון לוסקי, לירן קלינה, רוית יונה בניהו, הילה יניב, רתם פרץ). Avatars use the atom's `__avatar-placeholder` (no portraits needed → not an asset gap).
- Asset gap for /press: **publication logos** (optional enhancement) — see manifest. Default composition is text-only, so /press has zero hard asset blockers.
- Closing CTA + footer + whatsapp: identical atoms to /about.

## /about/moksha — reuses the same DNA
The most prose-heavy instance; **pullquote-forward**.

- Header: `atom-structure-section-intro` → H1 "מוקש דהימן — על השם".
- Body: `atom-structure-content-section` (alternating `--alt`) for the long narrative ("ומה היום", the 2026 India trip, the Ganges flood, the jungel vibes branch declaration). Break the heavy text with 1–2 **pullquotes** (same composed pullquote pattern) on the emotional lines, e.g. "לילדים חלום משל עצמם… תם עידן מוקש" — high-impact, candidate pullquote.
- Portrait slot → **Moksha portrait / archival photo** via `atom-content-bio-block` (asset gap; placeholder otherwise).
- Related slot (`atom-service-tile`): one tile back to `/about` ("חזרה לעמוד אודות אייל עמית", verbatim back-link) — matches the existing `the_content()` back-link and the template's `.ea-about-sub-link` cross-link from /about → /about/moksha.
- Closing CTA + footer + whatsapp: identical atoms.

## Accessibility / a11y=100 + axe 0/0 (designed toward)
- One `<h1>` per route; `<h2>`/`<h3>` strictly descending; every `<section>` `aria-labelledby` its heading.
- `dir="rtl" lang="he"`; logical props (`inset-inline-start`, `padding-inline-start`) throughout — no hard left/right that would break RTL.
- Skip-link is first focusable; visible focus rings (`:focus-visible` 2px terracotta) on every interactive atom.
- Decorative dividers `aria-hidden`; portrait placeholders carry `role="img"` + descriptive `aria-label`; external press links get `rel="noopener"` + an `.ea-sr-only` "נפתח בלשונית חדשה" hint at S3.
- Contrast: body copy uses `--ea-text-body` (#5A3826) — the AA-audited body color — on cream bgs; muted labels use `--ea-muted` (#6F635A, AA-fixed). No raw greys.

## S3 hand-down notes (team_10)
- Wire the three routes onto `tpl-content.php` via `the_content()` blocks; the `/about` template already emits the `/about/moksha` sub-link — keep it.
- Replace portrait/gallery placeholders with real media once Eyal delivers (see asset manifest).
- Press clips + recommendations should be data-driven (W2-07 content), not hardcoded.
