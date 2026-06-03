# CHROME + NAV REMEDIATION — DONE — team_100 → team_00 — v1.0

**Date:** 2026-06-03 · **Branch:** `main` (pushed, `5165686`) · **Deployed to staging** · team_00 directive ("do it all now").

## Problem (team_00 caught it; gates had missed it)
Live pages didn't look like the mockups. Two systemic defects, invisible to axe/Lighthouse/block-presence:
1. **Black element at the page top next to the hero** = the wave2 `FOOTER.ea-footer` rendered as a 364px **left column at the top** (GP `.site-content` is `display:flex;row`), which also squeezed the hero to 836px.
2. **Doubled navigation** — GP legacy header (the *approved* menu, white) shown above the wave2 `ea-topnav` (an *incomplete* 7-item menu).
3. The `ea-topnav` omitted most approved pages → "all pages clickable" violated.

## Fix (verified live on staging)
**A. Chrome/layout (`ea-atoms.css`, commit `1db8c97`):** hide GP `.site-header`; `.ea-wave2-shell .site-content`/`.grid-container` → block + full-bleed. Result (measured live, all pages): GP header hidden, hero full-width (1280/left 0), footer at the **bottom** full-width. Black element gone.
**B. Single nav = approved site-tree (`block-topnav.php` `6924089`, CSS `f7d101a`, JS `ccff1cc`):** rebuilt `ea-topnav` to the **approved menu** (`site-tree.json`, Eyal 2026-04-06): טיפול בדיג׳רידו · השיטה · שיעורי דיג׳רידו · סאונד הילינג · **לימוד והכשרה▾**[הכשרות למטפלים, קורסים(חיצוני), הרצאות, סדנאות] · **כלים ואביזרים▾**[כלים בעבודת יד, תיקון וחידוש] · מוזה הוצאה לאור · בלוג דיג׳רידו · **אייל עמית▾**[מוקש דהימן] · צור קשר · **EN pill** + שמע toggle. Accessible dropdowns (button+aria-expanded, hover/:focus-within/JS), RTL, mobile disclosure. **All approved pages reachable.**
**C. Footer (`block-footer-social.php` `5165686`):** added the approved footer-only links row — שאלות נפוצות, גלריות, המלצות, מדיניות פרטיות, הצהרת נגישות, תקנון. **FAQ moved out of primary** into the footer per the approved IA.

## Verification (live, staging)
- Single clean dark nav (no white GP menu, no black footer-column); full-width hero — **matches the mockup chrome**. Dropdown opens correctly (screenshot evidence in `scripts/qa/reports/visual-audit/`).
- Nav fits at 1280 (links 939px, no overflow); EN pill present; all 11 primary + 6 footer routes via `home_url()` (all exist live, 200).
- **axe 0 critical / 0 serious** on /treatment, /about, /books, /en. **LH /treatment mobile perf 97 / a11y 100.**
- D-14 clean: zero new tokens/hex/inline/keyframes; `ea-tokens.css` unchanged.

## Open / follow-ups
- **External courses URL** (קורסים): `#` placeholder + comment, `target=_blank` — needs the canonical Scholar/external URL from team_00/Eyal.
- **team_35 mockups** still depict the old 7-item nav — `REQUEST-TEAM35-NAV-RECONCILIATION-2026-06-03.md` asks them to update mockups + refine the dropdown/mobile visual to the now-fuller (approved) menu.
- **Per-page composition gaps** from the visual audit remain (B `/about` hero split; E book-detail over-length; Heebo vs Rubik font) — separate from chrome/nav.
- **Cross-engine:** this reopened the LOD500_LOCKED A/B/E/F (global chrome/nav) → should get a **team_190 re-confirm** (incl. a visual check, now part of QA).
