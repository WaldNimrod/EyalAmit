# As-made — DA-NAV-01 burger/drawer chrome flip (recommendation B)

**Team:** 10 (implementation)  
**Date:** 2026-09-21  
**Theme version:** 1.5.103  
**Scope:** T-NAV-HOLD chrome sides only — no L1 restructure, no DA-NAV-02/03/LOGO beyond overlap padding.

## What changed

| Surface | Burger edge | Drawer anchor | Logo |
|---------|-------------|---------------|------|
| Chapters (≤1180px) | inline-start (`order:-1`) | shared `dialog.ea-nd` inline-start | inline-end (`order:2; margin-inline-start:auto`) |
| Wave2 (≤1023px) | inline-start cluster (`order:-1`; RTL `row-reverse`) | same shared drawer | inline-end (`order:2`) |
| GP orphans + /en/ | standalone fixed inline-start | same shared drawer | GP: `.inside-header` pad; /en/: `.ea-en-head` pad |

## Files touched

1. `site/wp-content/themes/ea-eyalamit/assets/css/chapters.css` — mobile burger/logo order
2. `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-nav.php` — WS-2.2 comment only
3. `site/wp-content/themes/ea-eyalamit/assets/css/ea-nav-drawer.css` — slide sign, dialog anchor, standalone burger, GP orphan pad
4. `site/wp-content/themes/ea-eyalamit/assets/css/ea-mobile-nav.css` — Wave2 cluster/brand order
5. `site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-en.php` — EN header start padding
6. `site/wp-content/themes/ea-eyalamit/style.css` — Version 1.5.103

## Not changed

- `ea_canonical_nav_items()`, L1 labels/hrefs, DOM order on desktop
- EN chip not moved into drawer (DA-NAV-03)
- No GP/Chapters/EN header unification (DA-NAV-02)
- No SSOT/FORM/GALLERY, no FTP, no commit

## Ops notes

- Bump cache after FTP; verify at 390px: Chapters RTL burger physical right; Wave2 same; /en/ LTR burger physical left; drawer slides from same edge.
- Tab order on Chapters mobile: logo link → burger (DOM order unchanged).
