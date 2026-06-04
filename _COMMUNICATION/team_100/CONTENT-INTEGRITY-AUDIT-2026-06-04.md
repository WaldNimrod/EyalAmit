# Content-integrity audit — live text vs Eyal's source (2026-06-04)

**Trigger:** Eyal reviewed the site and found many texts are invented / not what he provided.
**Method:** verbatim presence of Eyal's own content sentences (12 distinctive sentences/page, exact match) on each live staging page vs his source `.md`. Indicative sample, not exhaustive — but the signal is unambiguous.

## Q1 — The latest / canonical Eyal content source
**`docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/`** — submitted **2026-05-25** ("הגשת תוכן ישירה מאייל … אחרי הפסקת הפעילות באפריל"). Per-page files (15 `.md` + the memorial `.docx`), authoritative map: **`INDEX-CONTENT-2026-05-25.md`**. This **supersedes** the April packages (`CONTENT/EYAL-CONTENT-PKG-2026-04-*`, `CONTENT 10/12/13.4.26`). The only newer files in the folder are the 26.5 meeting-decisions/open-questions (process, not page copy).

| Page | Eyal source file (25.5.26) |
|---|---|
| `/` | `דף הבית/homepage1-3 v2.md` |
| `/method` | `השיטה/method.md` |
| `/treatment` | `טיפול בדיג'רידו/treatment.md` |
| `/sound-healing` | `סאונדהילינג/sound_healing_final.md` |
| `/lessons` | `שיעורי נגינה/lesons.md` |
| `/faq` | `דף FAQ/FAQ FINAL.md` |
| `/muzza` (books) | `מוזה הוצאה לאור - ספרים/MUZZA.md` |
| books detail ×3 | `וכתבת/vekatavta.md` · `כושי בלאנטיס/kushi_full.md` · `צבע בכחול וזרוק לים/eyal_tsva_FINAL.md` |
| shop ×5 | `כלים למכירה/buy didgeridoo.md` · `תיקים/bags for didg.md` · `סטנדים/stend for hanging.md` · `סטנד רצפתי/stend for playing.md` · `תיקון/build didg.md` |
| memorial (background) | `מוקש דהימן/ומה היום.docx` — *classified as background, not page copy* |

## Q2 — Pages with inaccurate / invented text
Verbatim Eyal-sentence presence on the live page (higher = more faithful):

| Page | Eyal text present | Verdict |
|---|---|---|
| `/method` | **0%** | INVENTED — built from mockup copy; 11/14 of Eyal's sections absent (מהי cbDIDG · לא כל עבודה עם דיג'רידו · עקרונות השיטה · מה מייחד · איך נולדה השיטה · אודות אייל · איך נראה מפגש · שאלות נפוצות · מה אנשים חווים · מבט קדימה) |
| `/muzza` (books) | **0%** | INVENTED — not `MUZZA.md` |
| `/treatment` | ~25% | mostly invented vs `treatment.md` |
| `/sound-healing` | ~25% | mostly invented vs `sound_healing_final.md` |
| `/lessons` | ~25% | mostly invented vs `lesons.md` |
| `/faq` | ~41% | partial — some real, much divergent |
| `/` (home) | ~66% | mostly Eyal's; some invented blocks |
| `/galleries`, `/media` | n/a | team_35 mockup samples (no Eyal source) |
| book-detail ×3, shop ×5 | not yet sampled | likely same pattern — **reconcile required** |

## Root cause
The elevated pages were implemented from the **team_35 mockups' placeholder/representative copy**. The package's own README states the mockups are *"design references … not drop-in production content."* The implementation (team_10, across WP-W2-04 / WP-W2-10 / WP-W2-14) used that sample text instead of wiring Eyal's real `.md` content. The mobile tier (WP-W2-14) inherited the same text; the F1–F9 content audit caught the new pages (memorial/galleries/media) but not the pre-existing service/content pages.

## Severity & recommendation
- **Severity: P0 content-integrity** — most primary content pages do not carry Eyal's approved copy. The build/structure is sound; the **text content is wrong**.
- **Remediation = a dedicated content-reconciliation pass** (team_10), page-by-page, wiring each page's body to its `25.5.26` source file (verbatim sections per `method.md` etc.), then a team_50 content-diff re-verify per page. This is content-fill into the existing (locked) structure — no structural rework.
- **Scope to reconcile (priority order):** method (0%), muzza/books (0%), treatment/sound-healing/lessons (~25%), faq (~41%), home (~66% — fix the invented blocks), then book-detail ×3 + shop ×5 (sample/verify), galleries/media (await Eyal real content), memorial (per H1).
- **This is bigger than the WP-W2-14 group-H follow-up** — it is a site-wide content correction. Recommend a new tracked WP (e.g. `WP-W2-15 — Content reconciliation vs Eyal 25.5.26`).

*team_100 — 2026-06-04. Indicative sample audit; a full per-page reconciliation is the remediation.*
