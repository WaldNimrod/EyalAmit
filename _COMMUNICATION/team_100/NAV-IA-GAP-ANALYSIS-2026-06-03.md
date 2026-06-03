# NAV / IA GAP ANALYSIS — team_100 → team_00 — v1.0

**Date:** 2026-06-03
**Sources of truth:** `hub/data/site-tree.json` (ApprovedDocRef, **Eyal-approved 2026-04-06**) + `_COMMUNICATION/team_10/M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md` (locked primary menu).
**Checked against:** live `ea-topnav` (the wave2 single nav) + the team_35 mockup nav + live page existence.

## TL;DR
The implemented `ea-topnav` (and the team_35 mockups it mirrors) list only **~7 items** and **omit most of the approved menu**. The GeneratePress white menu — which I earlier mis-labeled "legacy" — is in fact the **approved** menu. **All approved pages exist live (HTTP 200)**, so every missing link can be wired now; nothing is blocked on page creation. **"All pages clickable from the menu" is currently violated.**

## Approved PRIMARY menu (11 positions) vs current ea-topnav
| # | Approved label | Slug | Exists live | In ea-topnav? |
|---|---|---|---|---|
| 1 | (logo → home) | `home` | 200 | ✓ (as בית) |
| 2 | טיפול בדיג׳רידו | `treatment` | 200 | ✓ (as טיפול) |
| 3 | השיטה | `method` | 200 | ✓ |
| 4 | שיעורי דיג׳רידו | `lessons` | 200 | ✓ (as שיעורים) |
| 5 | סאונד הילינג | `sound-healing` | 200 | ✓ |
| 6 | **לימוד והכשרה** | `learning` | 200 | ✗ **MISSING** |
| 6a | הכשרות למטפלים (noindex) | `therapist-training` | 200 | ✗ MISSING |
| 6b | קורסים (סקולר / חיצוני) | external URL | — | ✗ MISSING |
| 6c | הרצאות | `lectures` | 200 | ✗ MISSING |
| 6d | סדנאות | `workshops` | 200 | ✗ MISSING |
| 7 | **כלים ואביזרים** | `tools-and-accessories` | 200 | ✗ **MISSING** |
| 7a | כלים בעבודת יד ואביזרים | `instruments` | 200 | ✗ MISSING |
| 7b | תיקון וחידוש כלים | `repair` | 200 | ✗ MISSING |
| 8 | מוזה הוצאה לאור | `muzza` | 200 | ⚠ ea-topnav has **ספרים → /books** (label+slug mismatch) |
| 9 | **בלוג דיג׳רידו** | `blog` | 200 | ✗ **MISSING** |
| 10 | **אייל עמית** | `eyal-amit` | 200 | ✗ **MISSING** |
| 10a | מוקש דהימן — לזכרו | `mokesh-dahiman` | 200 | ✗ MISSING |
| 11 | צור קשר | `contact` | 200 | ✓ |
| hdr | **EN icon** (header only) | `/en` | 200 | ✗ MISSING |

## ea-topnav items that are WRONG
- **שאלות נפוצות (faq)** is in the primary nav — the approved IA puts FAQ in the **footer**, not primary.

## Approved FOOTER links (mandatory; NOT in primary) — currently absent from a wave2 footer
`faq` (200), `galleries` (200), `media` (200), `privacy` (200), `accessibility` (200), `terms` (200).
(And see the separate layout defect: the wave2 footer currently renders mis-placed at the top-left of the page, not at the bottom.)

## Net "missing links" list (organized — to add to the single nav)
**Primary (add):** לימוד והכשרה (`learning`) + submenu [הכשרות למטפלים `therapist-training`, קורסים external, הרצאות `lectures`, סדנאות `workshops`]; כלים ואביזרים (`tools-and-accessories`) + submenu [כלים בעבודת יד `instruments`, תיקון וחידוש `repair`]; בלוג דיג׳רידו (`blog`); אייל עמית (`eyal-amit`) + מוקש דהימן (`mokesh-dahiman`); **EN icon** in header.
**Fix label/slug:** ספרים/`books` → מוזה הוצאה לאור/`muzza` (reconcile /books vs /muzza — both exist live).
**Move to footer:** שאלות נפוצות (`faq`).
**Add footer block (at bottom):** faq, galleries, media, privacy, accessibility, terms.

## Conflict to resolve (routed to team_35)
The team_35 elevation mockups (service-treatment, editorial-about, en-landing, commerce-*) all depict a **reduced 7-item nav** that does **not** match the approved `site-tree.json` menu. Either the mockups must be updated to the approved 11-item menu (with dropdowns), or team_00/Eyal must re-approve a simplified menu. **The approved sitemap is the SSoT** → default action is to build the nav to the approved menu and update the mockups. See `REQUEST-TEAM35-NAV-RECONCILIATION-2026-06-03.md`.

## Implementation note (separate from this analysis)
Two code changes follow once the menu set is confirmed: (1) **remove the mis-placed footer from the page top** + render the wave2 chrome full-width (closes the "black element next to the hero"); (2) **rebuild the single nav** to the approved menu (incl. dropdowns + EN icon + footer links) so every page is reachable. Both reopen the LOD500_LOCKED A/B/E/F as post-closure remediation.
