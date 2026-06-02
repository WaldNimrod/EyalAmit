# HANDOFF INDEX — WP-W2-10 Track-2 ELEVATION (S1.5)

**From:** team_35 (Design Studio)  
**To:** team_10 (WordPress implementation) · cc team_100 (architect), team_00 (co-design)  
**Date:** 2026-06-02  
**Mandate:** `MANDATE-TEAM35-W2-10-TRACK2-ELEVATION-2026-06-02.md`  
**Stage gate reached:** **READY_FOR_S2** (Eyal sign-off). HALT — no template edits, no deploy, no self-validation (S5 = team_50 + team_190).

---

## What this package contains

Elevated (S1.5 precision-pass) hi-fi mockups for the four high-visual clusters, built **verbatim** on the
D-14 design system (`ea-tokens.css` + `ea-atoms.css`) pulled from `WaldNimrod/EyalAmit @ main`.
**AC-E2 holds: zero new tokens, zero new atoms.** Any genuinely-new need is GCR-flagged in the per-cluster notes
(none were required — all elevation was achieved by recomposing existing atoms).

| Cluster | Route(s) | Folder | Mockup file(s) |
|---|---|---|---|
| **A · Service** | `/treatment` (primary) + `/method`, `/sound-healing`, `/lessons` share `tpl-service` | `WP-W2-10-A/elevation/` | `mockup/service-treatment.html` |
| **B · Editorial** | `/about` (primary) + `/press`, `/about/moksha` share `tpl-content` | `WP-W2-10-B/elevation/` | `mockup/editorial-about.html` |
| **E · Commerce** | `/books` + 3 detail pages, `/shop` + 5 items | `WP-W2-10-E/elevation/` | `mockup/commerce-books-archive.html`, `mockup/commerce-book-detail.html` |
| **F · EN landing** | `/en` (LTR mirror of RTL system) | `WP-W2-10-F/elevation/` | `mockup/en-landing.html` |

> **G (Hero video)** — OUT OF SCOPE, BLOCKED on Eyal's video asset.

---

## Folder structure

```
handoff-WP-W2-10-Track2/
├── README-HANDOFF-INDEX.md                  ← you are here
├── shared-assets/                           ← real images used across mockups
│   ├── ea-logo.jpg
│   ├── eyal-portrait-hero.jpg
│   ├── hero-wide-studio.jpg
│   ├── covers/ (kushi-blantis, tsva-bechol, vekatavt)
│   └── gallery/ (kushi-02-eyal-italy, kushi-04-sinai)
├── WP-W2-10-A/elevation/
│   ├── mockup/service-treatment.html
│   ├── narrative/elevation-notes.md
│   ├── assets/asset-manifest.md
│   └── HANDOFF_35_W2-10-A-ELEVATION_2026-06-02_v1.md
├── WP-W2-10-B/elevation/ (same shape)
├── WP-W2-10-E/elevation/ (same shape, 2 mockups)
└── WP-W2-10-F/elevation/ (same shape)
```

---

## How team_10 should consume this

1. **Read the per-cluster `HANDOFF_35_…_v1.md` first** — it lists the block order, the D-14 atom mapping
   per section, and the exact template/route binding.
2. **`narrative/elevation-notes.md`** explains every change vs S1 (cite atom IDs) so the implementation is a
   faithful translation, not a re-interpretation.
3. **`assets/asset-manifest.md`** is the Eyal-gap inventory: every placeholder, its required real asset, the
   exact swap path, and target dimensions/aspect-ratio.
4. The mockups reference images at `assets/...` paths — in this package those real files live in
   `shared-assets/`. Re-point to the theme's media library (`/wp-content/themes/ea-eyalamit/assets/images/`
   or WP uploads) at build time.

## Image path note (important)

Each mockup HTML references assets with **relative `assets/...` paths** (e.g. `assets/covers/kushi-blantis-cover.jpg`,
`assets/eyal-portrait-hero.jpg`). The real files are in **`shared-assets/`** in this package. To preview a mockup
locally with images, copy `shared-assets/` next to the mockup as `assets/`, or rewrite the paths to the WP media
library during S3 implementation.

---

## Compliance summary (elevation-stage ACs)

- **AC-E1** — each cluster is flagship-grade (clear hierarchy, hero treatment, shaped real content). ✅
- **AC-E2** — strict D-14 fidelity, zero new tokens/atoms (0 GCRs raised). ✅
- **AC-E3** — RTL correct; F is LTR mirror via logical properties; AA contrast (`--ea-text-body` on `--ea-bg`);
  single H1 per page; graceful Eyal-gap placeholders. ✅
- **AC-E4** — HANDOFF per cluster, status `READY_FOR_S2`, halted (no template edits, no self-validate). ✅
