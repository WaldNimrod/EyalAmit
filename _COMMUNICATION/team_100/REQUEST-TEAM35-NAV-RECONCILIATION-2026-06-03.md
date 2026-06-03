# REQUEST → team_35 — Navigation reconciliation (WP-W2-10 mockups vs approved site-tree)

**Date:** 2026-06-03 · **From:** team_100 · **To:** team_35 (design / elevation) · **Priority:** P1 · **WP:** WP-W2-10 (A/B/E/F + chrome)

## Issue
Your Track-2 elevation mockups (`service-treatment.html`, `editorial-about.html`, `commerce-books-archive.html`, `commerce-book-detail.html`, `en-landing.html`) all depict a **reduced ~7-item top navigation**:
> בית · השיטה · טיפול · סאונד הילינג · שיעורים · ספרים · צור קשר (+ "שמע" toggle)

This does **not** match the **approved primary menu** locked from `hub/data/site-tree.json` (Eyal-approved **2026-04-06**) and `M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md`, which has **11 primary positions with dropdowns + an EN header icon + 6 footer links**.

The build faithfully implemented your mockups → the live nav is missing ~6 hub pages/submenus, mislabels ספרים↔מוזה, and wrongly places FAQ in the primary nav. **All target pages exist live (HTTP 200)** — so this is purely a nav-design gap, not a content gap. Per team_00: **every page must be reachable from the menu.**

## What we need from you
1. **Re-render the mockup navigation** (header + footer) to the approved menu below — single nav bar with dropdowns for the two hub groups, EN icon in the header, and a footer link row. Keep the elevated dark `ea-topnav` visual style.
2. Confirm the **hover/expand pattern** for the two dropdown groups (לימוד והכשרה, כלים ואביזרים) in the dark nav, RTL.
3. Confirm **mobile** nav pattern (hamburger / drawer) for an 11-item menu with submenus.
4. Confirm label/slug: **מוזה הוצאה לאור (`muzza`)** as the books hub (reconcile vs the `/books` archive the build produced).

## Approved menu to render (SSoT)
**Primary:** (logo→home) · טיפול בדיג׳רידו `/treatment` · השיטה `/method` · שיעורי דיג׳רידו `/lessons` · סאונד הילינג `/sound-healing` · **לימוד והכשרה `/learning`** ▾ [הכשרות למטפלים `/therapist-training`, קורסים (חיצוני), הרצאות `/lectures`, סדנאות `/workshops`] · **כלים ואביזרים `/tools-and-accessories`** ▾ [כלים בעבודת יד `/instruments`, תיקון וחידוש `/repair`] · מוזה הוצאה לאור `/muzza` · בלוג דיג׳רידו `/blog` · אייל עמית `/eyal-amit` ▾ [מוקש דהימן `/mokesh-dahiman`] · צור קשר `/contact` · **[EN]** icon → `/en`
**Footer row:** שאלות נפוצות `/faq` · גלריות `/galleries` · המלצות `/media` · מדיניות פרטיות `/privacy` · הצהרת נגישות `/accessibility` · תקנון `/terms`

## Related defect (team_100 handling, not team_35)
The wave2 footer currently renders **mis-placed at the page top-left** beside the hero (GP column-layout collision). team_100 fixes the chrome layout (full-width + footer→bottom) in parallel; your deliverable is the **nav/footer composition**, ours is the **layout/wiring**.

## Refs
`_COMMUNICATION/team_100/NAV-IA-GAP-ANALYSIS-2026-06-03.md` · `_COMMUNICATION/team_100/VISUAL-FIDELITY-AUDIT-WP-W2-10-2026-06-03.md` · `hub/data/site-tree.json`
