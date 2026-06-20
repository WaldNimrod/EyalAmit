# 301 redirect-map reconciliation — resolution (2026-06-20)

**Author:** team_100 · **Trigger:** three disagreeing representations of the legacy→new 301 map (cutover-SEO risk).
**Outcome:** single source of truth confirmed + enforced; stale exports quarantined; one live drift fixed; deploy-script
instruction corrected; one open gap flagged. Verified deterministically (regenerate-diff, structured parse, exhaustive grep).

## 1. The single source of truth (SSoT) — confirmed
```
hub/data/decisions/redirects-301-eyal-final-2026-05-27.json   (135 decisions: 27×301, 1×410, 103 keep, 3 manual)
  → scripts/gen_htaccess_301_from_decisions.py
     → site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php   ← LIVE 301/410 mechanism (PHP; nginx-safe)
     → _COMMUNICATION/team_100/tools/htaccess_301_block.txt          ← documentation copy (.htaccess is INERT on nginx)
```
The generator resolves empty targets via `EMPTY_TARGET_MAP` (never lazy `/`) and drops canonical-collision sources
(e.g. `/shop/*`, since `/shop/` is a live new page). The live mu-plugin holds **25 page-301 + 2×410**; the other
301-decisions are dropped as canonical collisions (expected, not drift). **Rule: never hand-edit the mu-plugin — regenerate.**

## 2. The three representations — verdict
| # | File | Role | Verdict |
|---|---|---|---|
| 1 | `site/wp-content/.../ea-w209-legacy-301-redirects.php` | LIVE PHP mu-plugin (generated) | **AUTHORITATIVE** (after the §4 drift fix) |
| 2 | `site/blog-301-rules.htaccess` | W2-06 blog export (.htaccess) | **STALE + wrong + inert → QUARANTINED** |
| 3 | `site/blog-301-redirection-plugin.json` | W2-06 blog export (Redirection plugin, 81 entries) | **STALE + wrong → QUARANTINED** |

Files 2 & 3 are W2-06 *blog-migration* exports (2026-05-28). They carry the `/Blog/→/blog/` migration **plus** ~26
page rules with **lazy `/` targets** that disagree with the SSoT.

## 3. Page-target disagreements — LIVE (SSoT) is correct in all 14
Confirmed by deterministic, percent-decoded diff (stale slugs were percent-encoded, hence earlier Hebrew greps showed 0):

| Legacy source | LIVE / SSoT (correct) | Stale htaccess + json (WRONG) |
|---|---|---|
| `/צור-קשר/` | **`/contact/`** | `/` |
| `/דיגרידו-…/שיעורי-נגינה-בדיגרידו/` | `/lessons/` | `/` |
| `/דיגרידו-…/סדנאות-בנייה-עצמית-דיגרידו/` | `/lessons/` | `/` |
| `/דיגרידו-…/תיקון-דיגרידו/` | `/repair/` | `/` |
| `/דיגרידו-…/סאונד-הילינג-…מדיטציית/` | `/sound-healing/` | `/` |
| `/הופעות/` | `/shows/` | `/` |
| `/אייל-עמית-אודות/` | `/about/` | `/` |
| `/מוזה-הוצאה-לאור/` | `/muzza/` *(see §4)* | `/` |
| `/מוזה-הוצאה-לאור/וכתבת-…/` | `/books/vekatavta/` | `/` |
| `/מוזה-הוצאה-לאור/כושי-בלאנטיס-…/` | `/books/kushi-blantis/` | `/` |
| `/shop/`, `/shop/cart/`, `/shop/checkout/`, `/shop/my-account/` | *not redirected (live `/shop/` is a real page)* | `/books/` (would break the live shop) |

→ **14 sources** where a stale export disagrees with the live SSoT; in **every case the live mu-plugin is correct**.
Deploying either stale export would 301 high-value pages to the homepage (lost link-equity + wrong UX) and break `/shop/`.

## 4. Bonus finding — the LIVE mu-plugin itself had drifted (now fixed)
Regenerating from the SSoT produced a **1-line change**: `/מוזה-הוצאה-לאור/` was committed as `→ /books/` but the
SSoT (`EMPTY_TARGET_MAP`) resolves it to **`→ /muzza/`**. `/muzza/` is a **real live page** (in `hub/data/site-tree.json`
+ seeded by `ea-w2-02-core-pages-seed-once.php`). The committed value was stale drift; the regenerated `/muzza/` is
authoritative and is now committed. **Live-behavior change:** `/מוזה-הוצאה-לאור/` now 301s to `/muzza/` (not `/books/`).

## 5. Resolution (decisions taken by team_100)
1. **SSoT enforced** — regenerated the mu-plugin from the decisions JSON; committed (fixes the §4 `/muzza/` drift). The
   mu-plugin is byte-faithful to the SSoT going forward.
2. **Quarantine (chose 4a, not regenerate-in-place)** — moved both stale exports to
   `_COMMUNICATION/team_100/301-quarantine-stale-W2-06-exports/*.QUARANTINED` with a README. Rationale: the generator
   already emits the correct htaccess copy (`tools/htaccess_301_block.txt`); maintaining parallel page-map exports
   invites exactly this drift; and quarantine (vs delete) preserves their `/Blog/` migration record (§6).
3. **Deploy-script fixed** — `scripts/ftp_deploy_w2_06_blog.py` (lines 97-98) **instructed deploying the stale files**
   ("copy blog-301-rules.htaccess into .htaccess / import the redirection json"). Rewrote those lines to point at the
   live mu-plugin SSoT + note the quarantine + the open blog gap. (This instruction was the real live cutover risk.)
4. **Archived references left as-is** — 4 historical W2-06 reports under `_archive/WP-W2-06/` reference the old filenames;
   they are a historical record (and `_archive/` is team_191's area) — not edited.

## 6. OPEN item (flag) — the `/Blog/ → /blog/` blog-post migration is not live
The quarantined files are the only record of the `/Blog/` (capital-B) → `/blog/` catch-all + **54 per-slug** blog-post
301s. That migration is **not live anywhere** — it was only ever a manual ".htaccess / Redirection-plugin" step, both
inert/absent on this nginx stack. The 135-decision SSoT covers *pages*, not these legacy blog-post URLs. **Before
production cutover (execution-plan WP-12):** decide whether the old `/Blog/*` URLs carry equity worth preserving and, if
so, fold the needed redirects into `redirects-301-eyal-final-*.json` (or a dedicated decisions file) so the generator
emits them into the live mu-plugin. Until then they are preserved in quarantine, not lost.

## 7. Verification
- **SSoT faithfulness:** `python3 scripts/gen_htaccess_301_from_decisions.py` → `git diff` = only the §4 `/muzza/` line (now committed). Re-running now yields a clean diff.
- **Diff:** percent-decoded structured comparison of all three maps (14 disagreements, all resolved in the SSoT's favor).
- **Blast radius:** repo-wide grep for `blog-301-rules` / `blog-301-redirection-plugin` → 1 active script (fixed) + 4 `_archive/` historical docs (left). No CI/deploy path ships `site/`-root files (main deploy ships `site/wp-content/` only).
- **`/muzza/` live:** present in `hub/data/site-tree.json` + core-pages seeder.
