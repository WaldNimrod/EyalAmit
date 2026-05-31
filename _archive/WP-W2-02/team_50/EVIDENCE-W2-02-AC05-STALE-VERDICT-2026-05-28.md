---
id: EVIDENCE-W2-02-AC05-STALE-VERDICT-2026-05-28
from_team: team_100 (Chief System Architect)
to_team: team_50 (QA / L-GATE_BUILD)
wp: WP-W2-02
date: 2026-05-28
re: second L-GATE_BUILD FAIL verdict (AC-05)
fix_commit: ebb6101
status: VERDICT DISPUTED — re-test requested
---

# AC-05 — second FAIL verdict appears stale; re-test requested

The second verdict is **byte-identical** to the first (same AC notes, same P3 list, and it still states "WP-W2-06 — held per mandate (no GO-SIGNAL yet)" — but the W2-06 GO-SIGNAL was posted before this re-QA). This indicates the AC-05 check was **not** re-run against the remediated build (commit `ebb6101`, redeployed to staging).

## team_100 live evidence (cache-busted; staging sends `Cache-Control: no-store` → no page cache)

CF7 asset tags (`<link>`/`<script>` referencing contact-form-7):

| Page | CF7 asset tags | Raw "contact-form-7" string |
|------|----------------|-----------------------------|
| `/method/` | **0** | **0** |
| `/treatment/` | **0** | — |
| `/faq/` | **0** | — |
| `/about/` | **0** | — |
| `/` (home) | **0** | — |
| `/contact/` | **5** (kept) | 10 |

No `wp-content/plugins/contact-form-7/...` asset URL appears on `/method/`.

## Reproduce (please run against current staging, cache-busted)
```bash
BASE="http://eyalamit-co-il-2026.s887.upress.link"; TS=$(date +%s)
for p in method/ treatment/ faq/ about/ "" contact/; do
  echo "/${p:-home}: $(curl -sk "$BASE/${p}?cb=$TS$RANDOM" | grep -coE "<(link|script)[^>]*contact-form-7[^>]*>") CF7 asset tags"
done
```
Expected: 0 on all non-contact pages, 5 on `/contact/`.

## Fix summary (commit ebb6101, deployed)
1. `wave2-w2-02.php` — set `ea_wave2_shell` query var on force-routed pages (activates `ea_wave2_is_active_view()`).
2. `wave2-stage-b.php` — `is_page('contact')` detection + CF7 native `wpcf7_load_css`/`wpcf7_load_js` filters.

## Request
Re-run AC-05 against current staging with cache-busting. If you reproduce 0/5 as above, please flip AC-05 → PASS and issue an updated verdict. If you still observe CF7 assets on a non-contact page, capture the exact URL + the offending `<link>`/`<script>` tag so team_100 can investigate a caching layer on your side.

*team_100 — 2026-05-28*
