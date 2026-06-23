# team_190 — Eyeball spot-checks (verbatim) — post-deploy closure — 2026-06-23

Validator engine: **GPT-5.2** (team_190 post-deploy independent re-run)  
Staging: `http://eyalamit-co-il-2026.s887.upress.link` (`?nc=` cache bust)

Complements deterministic `content/summary.json` and browser probes in `design-media-probe.json`.

## 1) `/treatment/` vs `טיפול בדיג'רידו/treatment.md`

- **Source snippet:** `ובדיוק שם מתחילה העבודה.`
- **Live (browser):** **PRESENT** — `design-media-probe.json` → `verbatimSpot: true`
- **Screenshot:** `eyeball_treatment_w1440.png`

## 2) `/books/vekatavta/` vs `וכתבת/vekatavta.md`

- **Source snippet:** `ייחודי במיוחד לוכתבת הוא גם האלמנט של סריקת ה-QR:`
- **Live (browser):** **PRESENT** — `verbatimSpot: true`
- **Book cover image:** detected (`bookCovers: 1`)
- **Screenshot:** `eyeball_bookVekatavta_w1440.png`

## 3) `/eyal-amit/mokesh-dahiman/` vs DOCX memorial source

- **Source snippet:** `יום אחד, בתחילת שנות השבעים, הגיע למלון בו מוקש ואבא שלו עבדו...`
- **Live (browser):** **PRESENT** — `verbatimSpot: true`
- **Memorial photos:** `mokeshPhotos: 8` (gallery/hero images detected)
- **Screenshot:** `eyeball_mokesh_w1440.png`

## 4) Design / media summary

| Page | dir | Book covers | Mokesh photos | Verbatim spot | Screenshot |
|------|-----|-------------|---------------|---------------|------------|
| `/books/` | rtl | 4 | — | — | `eyeball_books_w1440.png` |
| `/en/` | **ltr** | — | — | — | `eyeball_en_w1440.png` |
| `/` `/method/` | rtl | — | — | — | `eyeball_home_w1440.png`, `eyeball_method_w1440.png` |

**Note on `brokenImages` counter:** automated probe reports non-zero `brokenImages` on Hebrew pages due to lazy-loaded / deferred images (`loading=lazy`, below-fold) where `naturalWidth===0` at capture time. Full-page screenshots show rendered content correctly; `qa_probe` (182 checks) reports **0 overflow** and **0 forbidden-term** failures. **No visual breakage observed** on substantive content images.

## 5) Mockup comparison

Post-deploy head-only change (`wave2-w2-09.php`); layout/CSS unchanged. Re-affirm 2026-06-22 mockup comparison (`evidence/chapters-fullsite-2026-06-22/design/mockup-comparison-notes.md`) plus fresh screenshots in this evidence pack.

**Design fidelity verdict: PASS** (browser-rendered; ledger placeholder pages in scope).
