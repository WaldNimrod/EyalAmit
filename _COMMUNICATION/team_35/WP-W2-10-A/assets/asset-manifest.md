# Asset Manifest — WP-W2-10-A (Service cluster)

**Team:** team_35 · **Stage:** S1 · **Date:** 2026-05-31
Scope: assets referenced by the service archetype across /treatment, /method, /sound-healing, /lessons.

---

## A. Real assets PRESENT (theme repo)

| Asset | Path (theme-relative) | Used in mockup? | Notes |
|-------|------------------------|-----------------|-------|
| Eyal portrait (hero crop) | `assets/home/eyal-portrait-hero.jpg` | ✅ `.ea-bio-block__portrait` ("איך נראה מפגש") | Real photo; reusable across all 4 routes' bio-block. Confirm crop/orientation suits 4:5. |
| Workshop thumb | `assets/home/workshop-thumb.jpg` | — | Available; candidate for a future studio/space figure. |
| Books hero / studio | `assets/images/books-hero.jpg`, `assets/images/books-hero-studio.jpg` | — | Commerce-cluster assets; studio shot *could* seed a sound-healing hero but is not service-specific. |
| Brand logo | `assets/images/ea-logo.jpg` | — | Topnav uses text brand, not logo image. |
| Social icons (FB/IG/YT/TikTok) | inline SVG in `block-footer-social.php` | ✅ footer | No raster needed. |

Real media in `wp-content/uploads/2026/04/` are **book covers + Kushi gallery** (commerce/blog), not service-page imagery.

---

## B. Assets Eyal must still PROVIDE (gaps)

| Gap | Where it bites | Current placeholder | Priority |
|-----|----------------|---------------------|----------|
| **Per-route hero media** (photo or short video/loop) for treatment / method / sound-healing / lessons | Hero on all 4 routes | `atom-structure-hero-video` **variant_placeholder** CSS gradient (`.ea-hero__gradient-bg`) — valid fallback, no 404 | HIGH — biggest visual lift; gradient is intentionally generic |
| **Testimonial author avatars** (treatment ×3, sound-healing ×5, lessons ×5) | Testimonials grid | `.ea-testimonial-card__avatar-placeholder` (sand circle) | MED — design works without; photos add trust |
| **Studio / space photography** (Pardes Hanna garden, tipi, studio interior) | bio-block "איך נראה מפגש"; sound-healing "איך זה עובד" describes tipi/studio/hammocks vividly | reuse `eyal-portrait-hero.jpg` / none | MED-HIGH — sound-healing copy is highly visual and currently has no matching imagery |
| **Didgeridoo ambient audio** (`assets/audio/didgeridoo-ambient.mp3`) | `atom-interaction-sound-toggle` (topnav) | Toggle renders; `<audio>` omitted until file present (per block-topnav.php logic) | LOW |
| **Canonical WhatsApp number** | `.ea-whatsapp-float` href + any wa.me CTA | placeholder `wa.me/972000000000` | HIGH (functional) — easy to supply |
| **Hero video for home** (cluster G) | not this cluster | — | tracked separately (BLOCKED) |

---

## C. Decisions for Eyal / team_10 (S3)
1. Approve **gradient hero** as the standing treatment for service routes until media is delivered, OR commit to supplying per-route hero photos before build.
2. Confirm `eyal-portrait-hero.jpg` is acceptable for the bio-block across routes, or supply a dedicated treatment/lessons portrait.
3. Avatar photos: provide, or accept the sand-circle placeholder as the shipped design.
4. Supply the real WhatsApp number + confirm /contact is the correct CTA destination.
