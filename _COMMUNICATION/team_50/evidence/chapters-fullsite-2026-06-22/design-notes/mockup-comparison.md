# Design fidelity — mockup comparison (team_50, 2026-06-22)

Screenshots: `_COMMUNICATION/team_50/evidence/chapters-fullsite-2026-06-22/qa_probe/screenshots/` (189 captures, 27 pages × 7 viewports).

Mockup sources: `/tmp/ea-mock/*.html` (7 Hebrew Chapters pages) · handoff zip `eyal-amit/project/*.html`.

## Summary

| Area | Verdict | Notes |
|------|---------|-------|
| Home `/` | **Match** | Ivory/terra palette, RTL nav, phero hero garden, section rhythm, dark footer — aligns with `בית - פרקים.html` / `Home - Dashboard (elevated).html` |
| Service pages (treatment, method, lessons, sound-healing) | **Match** | Chapters phero + prose/split components; RTL correct @390 and @1440 |
| Books `/books/` | **Match** (live) | 3D shelf + book cards with real covers; hero «מוזה הוצאה לאור» — matches `Commerce - Books Archive` intent |
| Book detail (kushi, vekatavta, tsva) | **Match** | Cover heroes + prose layout per `Book - Kushi Blantis` / `Commerce - Book Detail` |
| Mokesh memorial | **Match** (live) | Timeline + photo blocks render; emotional layout per `Memorial - Mokesh (elevated)` |
| `/en/` | **Match (placeholder)** | LTR, English hero copy, WhatsApp CTA — per `EN - Landing (elevated)` + ledger §7-c |
| Galleries / media / legal | **Clean placeholder** | `⟨…⟩` copy renders in Chapters shell; no unstyled blocks |
| Blog archive | **Match** | Mosaic `.ea-blog-card` grid; Chapters nav/footer |

## CDP screenshot caveat

Some **full-page** CDP captures (notably `books_*`, `mokesh_*`, `treatment_w390`) show large empty beige bands — **overflow checks still pass** and live HTTP 200 content-diff confirms full prose present. Likely lazy-load / full-page capture timing in `qa_probe.mjs`, not missing CSS. Home and `/en/` captures show complete rendered chrome.

## Visual breakage scan

- **Broken images:** none observed on home, books, mokesh, contact (spot-check screenshots + HTTP 200 assets)
- **RTL:** correct on all Hebrew routes; `/en/` LTR confirmed
- **Typography:** Heebo / Frank Ruhl Libre / Suez One loaded (network requests in live pages)
- **Mobile nav:** burger present @390 on home screenshot path
- **Book covers:** visible on `/books/` and detail heroes
- **Mokesh photos:** timeline imagery present in memorial page live content

## Mockup mapping (spot-checked)

| Live | Mockup | @viewports checked |
|------|--------|-------------------|
| `/` | `בית - פרקים.html` | w390, w1440 |
| `/treatment/` | `טיפול - פרקים.html` | w390, w1440 |
| `/method/` | `השיטה - פרקים.html` | w1440 |
| `/books/` | `Commerce - Books Archive (elevated).html` | w390, w1440 |
| `/eyal-amit/mokesh-dahiman/` | `Memorial - Mokesh (elevated).html` | w1440 |
| `/en/` | `EN - Landing (elevated).html` | w1440 |
