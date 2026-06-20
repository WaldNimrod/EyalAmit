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

→ **14 sources disagree** = **10** where the stale export uses a lazy `/` (live mu-plugin correct) **+ 4** `/shop/*` that
the stale export wrongly 301s to `/books/` while the live mu-plugin correctly does **not** redirect them (`/shop/` is a
live page). In all 14 the stale exports are wrong. Deploying either stale export would 301 high-value pages to the
homepage (lost link-equity + wrong UX) and break the live `/shop/`.

## 4. Critical finding — a generator/SSoT bug (caught by adversarial verification, corrected)
The committed mu-plugin had `/מוזה-הוצאה-לאור/ → /books/`. My **first** regeneration (commit `13d9b1a`) changed it to
`→ /muzza/`, because the generator's `EMPTY_TARGET_MAP` still mapped that slug to `/muzza/`. **That was a regression**,
refuted by adversarial verification with converging evidence:
- **`/muzza/` is itself a PERMANENT 301 to `/books/`** — `themes/ea-eyalamit/functions.php:587 ea_eyalamit_muzza_to_books_redirect()` runs at `template_redirect` **priority 0** (docblock: WP-W2-15-CR F-CRF-02 / F-W2-15-CA-01 — "/books is the canonical Muzza archive; /muzza is a PERMANENT 301 to it"). So `/מוזה-הוצאה-לאור/ → /muzza/` is a **2-hop chain**; the correct single-hop target is **`/books/` direct**.
- `/books/` was the **deliberate** value set by WP-W2-15-CR-FINAL (2026-06-05) precisely to kill that 2-hop; the `EMPTY_TARGET_MAP` was never updated to match (its sibling `kushi-blantis` entry WAS corrected 2026-05-30; the parent slug was missed).
**Root-cause fix:** updated `scripts/gen_htaccess_301_from_decisions.py` → `EMPTY_TARGET_MAP[מוזה slug] = "/books/"`
(fixing the generator, **not** hand-editing the mu-plugin, so future regens stay correct) + regenerated. The mu-plugin now
has `/מוזה-הוצאה-לאור/ → /books/` (single hop). **No live impact:** `13d9b1a` was repo-only (never deployed); the wrong
value was corrected before any cutover. Final repo state restores the intended `/books/`.

## 5. Resolution (decisions taken by team_100)
1. **SSoT enforced + generator bug fixed** — corrected `EMPTY_TARGET_MAP[מוזה]` → `/books/` (§4) and regenerated the
   mu-plugin from the decisions JSON. The mu-plugin is now byte-faithful to the SSoT and idempotent on re-run.
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

**Root cause is deeper than "not folded in yet" (verification finding):** the generator writes the `/Blog/` catch-all
ONLY into the inert `.htaccess` block; the PHP-emit path uses exact-match `isset($map[...])` and **structurally cannot
express a regex prefix**, so it never emits the catch-all into the live mu-plugin. Also all 54 `/Blog/<slug>` decisions
are `decided_status=keep` (delegated to the catch-all). **Re-running the current generator will NOT close the gap** — it
must be taught to emit a PHP `preg_match('#^/Blog/(.+)#i') → 301` (or per-slug entries). **Dead harness:**
`scripts/final_pre_cutover_check.sh` *skips* pattern rules and `scripts/verify-301-blog.sh` probes `/Blog/` expecting a
301 that is inert on nginx — neither would catch this; fix the harness when the gap is closed.

## 7. Verification
- **SSoT faithfulness:** after the §4 generator fix, `python3 scripts/gen_htaccess_301_from_decisions.py` is idempotent — the mu-plugin emits `/מוזה-…/ → /books/` and re-running yields a clean diff.
- **Diff:** percent-decoded structured comparison of all three maps — 14 disagreements (10 lazy-`/` + 4 `/shop/*` drops), all resolved in the SSoT's favor.
- **Blast radius (verified sound):** repo-wide grep → 1 active script (fixed) + 4 `_archive/` historical docs (left). No CI/Makefile/.htaccess in any deploy path; main deploy ships `site/wp-content/` only.
- **`/muzza/` is a 301 hop (not a stable page):** `functions.php` 301s `/muzza/ → /books/` at priority 0 — so the legacy slug must target `/books/` directly (single hop). This is why the §4 `/muzza/` value was wrong.

## 8. Verification outcome (adversarial workflow wke96yn42)
- **Blast-radius lens → SOUND.** The quarantine + deploy-script fix were correct; nothing else can deploy the stale maps.
- **Refute lens → CAUGHT the §4 `/muzza/` regression** in `13d9b1a` (repo-only, never deployed; corrected at the generator before cutover) **and** surfaced the §6 blog-gap root cause + the dead harness.
- Net: quarantine + deploy-script fix held the first time; the `/מוזה/` target was wrong and is now fixed at source; the `/Blog/` migration is an open generator-level gap for cutover. *Adversarial verification earned its keep here.*
