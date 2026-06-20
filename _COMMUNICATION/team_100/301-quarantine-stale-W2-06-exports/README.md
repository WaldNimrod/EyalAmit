# QUARANTINED — stale W2-06 301 exports (do NOT deploy)

**Quarantined by:** team_100 · **Date:** 2026-06-20 · **Why:** these two files are a cutover-SEO risk.

## What these are
W2-06 blog-migration exports (generated 2026-05-28), moved here from `site/`:
- `blog-301-rules.htaccess.QUARANTINED` — was `site/blog-301-rules.htaccess`
- `blog-301-redirection-plugin.json.QUARANTINED` — was `site/blog-301-redirection-plugin.json`

## Why quarantined (not deployed)
1. **Wrong page targets** — they carry ~26 page-level rules with **lazy `/` targets** that DISAGREE with the
   authoritative live map in **14 places**, e.g. `/צור-קשר/ → /` (correct: `/contact/`), the studio sub-pages
   `→ /` (correct: `/lessons/`, `/repair/`, `/sound-healing/`…), and `/shop/* → /books/` (which would even break the
   new live `/shop/`). Full table: `../301-MAP-RECONCILIATION-2026-06-20.md`.
2. **Inert anyway** — `.htaccess` RewriteRules are ignored on the uPress **nginx** stack (`AllowOverride None`).
3. **Superseded** — the single source of truth is the generated PHP mu-plugin (see below).

## The single source of truth (SSoT)
`hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` (135 decisions)
→ `scripts/gen_htaccess_301_from_decisions.py`
→ **`site/wp-content/themes/…/mu-plugins/ea-w209-legacy-301-redirects.php`** (LIVE 301/410 mechanism)
   + `_COMMUNICATION/team_100/tools/htaccess_301_block.txt` (documentation copy).
**Never hand-edit the mu-plugin; regenerate from the JSON.**

## Preserved, not deleted — one OPEN item
These files are the **only** record of the `/Blog/ (capital B) → /blog/` blog-post migration (catch-all + 54
per-slug 301s). That migration is **NOT live anywhere** (it was only ever a manual "copy into .htaccess / import to
Redirection plugin" step, both inert/absent on this stack). **Before cutover:** fold the needed `/Blog/*` blog-post
redirects into the decisions JSON → mu-plugin SSoT (tracked in `../301-MAP-RECONCILIATION-2026-06-20.md` + execution
plan WP-12). Kept here so that mapping isn't lost.
