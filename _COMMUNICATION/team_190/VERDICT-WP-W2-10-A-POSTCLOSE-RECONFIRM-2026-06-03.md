---
id: VERDICT-WP-W2-10-A-POSTCLOSE-RECONFIRM-2026-06-03
from: team_190 (POST-CLOSE_RECONFIRM)
to: team_100, team_10, team_00
type: QA_VERDICT
gate: POST-CLOSE_RECONFIRM
date: 2026-06-03
engine: cursor-composer (cross-engine; IR#5)
verdict: PASS
blocking_findings: 0
cluster: Service (A) — /treatment, /method, /sound-healing, /lessons
wp: WP-W2-10-A (S003 Track-2)
branch: main
worktree_head: 2068938c900a168aa4f5d6b72b1670bc34b5f6c5
change_commit: d79c23e
decision_ref: _COMMUNICATION/team_00/DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md (D2)
prior_validate: _COMMUNICATION/team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03-rev2.md
archive_addendum: _archive/WP-W2-10-A/ARCHIVE_MANIFEST.md (post-closure addendum)
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-W2-10-A Service cluster | POST-CLOSE re-confirm (D2)

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | WP-W2-10-A — Service cluster (4 routes, `tpl-service`) |
| Gate | POST-CLOSE_RECONFIRM (lightweight; CSS relocation D2) |
| Change | Composition CSS → `w2-10-service.css` (commit `d79c23e`) |
| Prior validate | **PASS** rev2 — composition locked |
| Verdict | **PASS** |
| Blocking (P0/P1) | **0** |
| Cluster status | **DONE / LOD500_LOCKED** — post-closure state **affirmed** |

---

## §1 Change under review (D2)

Per team_00 DECISION 2: service composition rules relocated from shared `ea-atoms.css` into dedicated `assets/css/w2-10-service.css`, enqueued only on the 4 service routes via `ea_wave2_service_composition_assets()` (`wave2-w2-04.php`). Pure move — zero new tokens/hex/keyframes.

---

## §2 Check matrix

| Check | Verdict | Evidence |
|-------|---------|----------|
| A1 CSS sheet loads (4/4) | **PASS** | `link[href*="w2-10-service.css"]` in DOM; HTTP **200** (http URL) all routes |
| A2 Computed-style parity (`/treatment/`) | **PASS** | kicker = `--ea-sand`; `--steps` grid **4 cols**; disclaimer = `--ea-muted`; ink CTA bg = `--ea-ink` |
| A3 Composition spine unchanged vs rev2 | **PASS** | 4/4 routes: hero → intro → breath-divider-1 → content-section → method-pillars×2 → bio → service-comparison → testimonials-row → faq-mini → disclaimer → contact-cta (excl. topnav/footer-social); no `entry-content` stub |
| A4 Portrait / asset regression guard | **PASS** | `wp-w2-10-asset-smoke.cjs` 4/4 — HTTP 200, H1=1, portrait `ea-eyalamit` 200, consoleErr=0 |
| A5 a11y | **PASS** | `http-qa-axe.cjs` 4/4 crit=0 serious=0 |
| A6 `ea-atoms.css` no A composition rules | **PASS** | Repo grep: absent `.ea-hero__kicker`, `.ea-pillars-grid--steps`, `.ea-service-comparison__col--active`, `.ea-service-comparison__tag`, `.ea-disclaimer*`, `.ea-section--cta--ink`, base `.ea-bio-block__portrait` layout rule. Allowed: reduced-motion `.ea-bio-block__portrait` override only (line 33) |

---

## §3 Regression vs rev2

Composition **unchanged** after CSS relocation. Block spine, portrait rendering, cbDIDG 4-step + 5-tile grids, disclaimer, and ink CTA band match rev2 validated state. Only delta: stylesheet source moved to cluster sheet `w2-10-service.css` (B/E/F convention). F-W2-10-A-02 (atoms relocation) **closed** by this change.

---

## §4 Validator reproduction (2026-06-03)

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/scripts/qa"
node http-qa-axe.cjs /treatment/ /method/ /sound-healing/ /lessons/
node wp-w2-10-asset-smoke.cjs /treatment/ /method/ /sound-healing/ /lessons/
node wp-w2-10-postclose-reconfirm.cjs
curl -sI "http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/css/w2-10-service.css" | head -1
```

| Command / artifact | Exit / result |
|--------------------|---------------|
| axe (4 routes) | **0** |
| asset-smoke (4 routes) | **0** |
| postclose probe (cluster A) | **0** — `reports/wp-w2-10-a-postclose-computed-proof.json` |
| axe report | `reports/axe-http-2026-06-02.json` |

---

## §5 Routing

| Verdict | Route |
|---------|-------|
| **PASS** | Cluster A remains **DONE / LOD500_LOCKED**; archive addendum pending note cleared |

---

*Issued by team_190 · POST-CLOSE re-confirm · WP-W2-10-A · 2026-06-03 · Cursor Composer cross-engine.*
