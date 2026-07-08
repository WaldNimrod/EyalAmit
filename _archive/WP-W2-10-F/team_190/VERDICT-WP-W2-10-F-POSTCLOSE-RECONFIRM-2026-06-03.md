---
id: VERDICT-WP-W2-10-F-POSTCLOSE-RECONFIRM-2026-06-03
from: team_190 (POST-CLOSE_RECONFIRM)
to: team_100, team_10, team_00
type: QA_VERDICT
gate: POST-CLOSE_RECONFIRM
date: 2026-06-03
engine: cursor-composer (cross-engine; IR#5)
verdict: PASS
blocking_findings: 0
cluster: EN landing (F) — /en
wp: WP-W2-10-F (S003 Track-2)
branch: main
worktree_head: 2068938c900a168aa4f5d6b72b1670bc34b5f6c5
change_commit: d79c23e
decision_ref: _COMMUNICATION/team_00/DECISION_WP-W2-10-POST-CLOSURE_2026-06-03_v1.md (D1)
prior_validate: _COMMUNICATION/team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03-rev2.md
archive_addendum: _archive/WP-W2-10-F/ARCHIVE_MANIFEST.md (post-closure addendum)
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-W2-10-F EN landing cluster | POST-CLOSE re-confirm (D1)

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | WP-W2-10-F — EN landing (`tpl-en-landing`, 1 route) |
| Gate | POST-CLOSE_RECONFIRM (lightweight; WhatsApp CTA D1) |
| Change | All 3 composition CTAs → `wa.me/972524822842` + external link attrs (commit `d79c23e`) |
| Prior validate | **PASS** rev2 — shell + LTR locked |
| Verdict | **PASS** |
| Blocking (P0/P1) | **0** |
| Non-blocking | F-W2-10-F-02 — browser-parsed DOM drops `target="_blank"` on CTAs (wpautop-corrupted `the_content` markup); server HTML retains `target="_blank"` ×3 |
| Cluster status | **DONE / LOD500_LOCKED** — post-closure state **affirmed** |

---

## §1 Change under review (D1)

Per team_00 DECISION 1: `ea_w2_08_cta_url()` returns `https://wa.me/` + `EA_WAVE2_WHATSAPP_E164` (`972524822842`). All 3 “Schedule an introductory call” CTAs (hero, services, closing) retargeted from `/contact?lang=en`. Closes carry-forward **F-W2-10-F-01**.

---

## §2 Check matrix

| Check | Verdict | Evidence |
|-------|---------|----------|
| F1 All 3 CTAs → WhatsApp | **PASS** | DOM: 3× `a.ea-cta-pill` → `https://wa.me/972524822842`; server HTML: 3× `Schedule an introductory call</a>` with wa.me href |
| F2 External link attrs | **PASS** | Server HTML: 3× `wa.me/972524822842" target="_blank"`; DOM: `rel="noopener noreferrer"` on all 3; aria-label mentions WhatsApp on all 3 |
| F3 No `/contact?lang=en` | **PASS** | `curl` grep count **0**; DOM scan **0** |
| F4 LTR intact | **PASS** | `<html lang="en" dir="ltr">`; `<main … lang="en" dir="ltr">`; EN topnav + `ea-footer` present (rev2 shell unchanged) |
| F5 a11y + structure | **PASS** | axe `/en/` crit=0 serious=0; asset-smoke H1=1 HTTP 200 consoleErr=0 |

---

## §3 Regression vs rev2

8-block EN composition, LTR shell, copy, and testimonials ×4 **unchanged**. Only declared delta: CTA hrefs and external-link semantics per D1. **F-W2-10-F-01 closed** (no `/contact?lang=en` refs remain).

---

## §4 Non-blocking observation (F-W2-10-F-02)

Server-rendered HTML includes `target="_blank"` on all 3 composition CTAs. After browser parse (wpautop-wrapped `the_content` injection), live DOM `getAttribute('target')` is null on those anchors — href, rel, and aria-label remain correct. Not introduced by D1; recommend team_10 consider `wpautop` bypass on EN render if new-tab behavior must match DOM. Not scored blocking for this post-closure re-confirm.

---

## §5 Validator reproduction (2026-06-03)

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/scripts/qa"
node http-qa-axe.cjs /en/
node wp-w2-10-asset-smoke.cjs /en/
node wp-w2-10-postclose-reconfirm.cjs
curl -s "http://eyalamit-co-il-2026.s887.upress.link/en/" | grep -c 'contact?lang=en'   # expect 0
curl -s "http://eyalamit-co-il-2026.s887.upress.link/en/" | grep -c 'wa.me/972524822842" target="_blank"'  # expect 3
```

| Command / artifact | Exit / result |
|--------------------|---------------|
| axe `/en/` | **0** |
| asset-smoke `/en/` | **0** |
| postclose probe (cluster F) | **0** — `reports/wp-w2-10-f-postclose-cta-proof.json` |
| contact?lang=en count | **0** |

---

## §6 Routing

| Verdict | Route |
|---------|-------|
| **PASS** | Cluster F remains **DONE / LOD500_LOCKED**; archive addendum pending note cleared |

---

*Issued by team_190 · POST-CLOSE re-confirm · WP-W2-10-F · 2026-06-03 · Cursor Composer cross-engine.*
