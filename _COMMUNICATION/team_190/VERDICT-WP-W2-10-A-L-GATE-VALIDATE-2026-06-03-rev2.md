---
id: VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03-rev2
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_50, team_10
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-03
round: 2
engine: cursor-composer (cross-engine; IR#1 + IR#5)
verdict: PASS
blocking_findings: 0
cluster: Service (A) — /treatment, /method, /sound-healing, /lessons
wp: WP-W2-10-A (S003 Track-2)
branch: main
worktree_head: c231b21effb16877900bd02cb6867aa3d30053fa
fix_commit: 407965a
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S003/WP-W2-10-A/LOD400_IMPL_spec.md §7
elevation_ssot: _COMMUNICATION/team_35/WP-W2-10-A/elevation/
token_gate_ref: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md
build_gate_ref: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03-rev2.md
prior_validate: _COMMUNICATION/team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03.md (round-1 FAIL)
fix_ref: _COMMUNICATION/team_100/FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md
mandate_ref: _COMMUNICATION/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md
---

# VERDICT — WP-W2-10-A Service cluster | L-GATE_VALIDATE (rev2)

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | WP-W2-10-A — Service cluster (4 routes, `tpl-service`) |
| Gate | L-GATE_VALIDATE re-validate (post P0 portrait-URI fix) |
| Predecessor | team_50 L-GATE_BUILD **PASS** (`QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03-rev2.md`) |
| Prior round-1 | **FAIL** (P0 portrait 404) — **closed** in this run |
| Verdict | **PASS** |
| Blocking (P0/P1) | **0** |
| Non-blocking | F-W2-10-A-01 (mobile perf median 87 — bar met); F-W2-10-A-02 (composition CSS in `ea-atoms.css` — team_80 noted) |
| Cluster close | **APPROVED** — cluster A may close; return to team_100 |

---

## §1 Gate chain

| Step | Artifact | Status |
|------|----------|--------|
| P0 fix | `FIX-WP-W2-10-PORTRAIT-URI-2026-06-03.md` · commit `407965a` | Applied |
| S5 re-pass | `QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03-rev2.md` | **PASS** (confirmed) |
| S5 validate | this document | **PASS** |

---

## §2 P0 closure (round-1 → rev2)

| Check | Round-1 | Rev2 |
|-------|---------|------|
| Portrait `src` theme | `generatepress` → **404** | `ea-eyalamit` → **200** |
| Portrait **renders** (`naturalWidth > 0`) | **FAIL** | **PASS** (566×1024 after scroll/eager load) |
| Asset smoke (4 routes) | N/A | **PASS** — 1 img/route, `assetPass=true` |

Rendered src (sample `/treatment/`):  
`http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/images/eyal-portrait-hero.jpg`

---

## §3 Acceptance criteria

| AC | Verdict | Evidence |
|----|---------|----------|
| AC-A2 | **PASS** | Block spine on 4 routes: `hero` → `intro` → `breath-divider-1` → `content-section` → `method-pillars`×2 (4-step + 5-tile) → `bio` → `service-comparison` → `testimonials-row` → `faq-mini` → `disclaimer` → `contact-cta`; no `entry-content` stub |
| AC-A3 | **PASS** | team_80 PASS carried; `ea-tokens.css` diff vs `b52b062` empty |
| AC-A4 | **PASS** | `http-qa-axe.cjs` 4/4 routes crit=0 serious=0 |
| AC-A5 | **PASS** | Independent mobile ×3: `/treatment/` median perf **87** a11y **100**; `/method/` median **87** a11y **100** (≥85 bar) |
| AC-A6 | **PASS** | Portrait live; sand-circle avatars ×3; gradient hero; 0 console errors |
| AC-A7 | **PASS** | HTTP 200 all routes; H1=1; RTL `html dir=rtl`; `validate_aos.sh` 0 FAIL |

**Cluster specifics:** cbDIDG 4-step + 5-tile ✓ · comparison active-state + tag “הדף הזה” ✓ · disclaimer verbatim ✓ · portrait **renders** ✓.

---

## §4 Validator reproduction (2026-06-03)

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/scripts/qa"
node http-qa-axe.cjs /treatment/ /method/ /sound-healing/ /lessons/
node wp-w2-10-asset-smoke.cjs /treatment/ /method/ /sound-healing/ /lessons/
# Mobile LH ×3: reports/lh-mobile-t190-w2-10-a_{treatment,method}_run{1,2,3}.json
bash ../scripts/qa/http-qa-lighthouse.sh /treatment/ /method/   # supplemental desktop
```

| Command | Exit |
|---------|------|
| axe (4 routes) | **0** |
| asset-smoke (4 routes) | **0** |
| `validate_aos.sh` | **0** |

---

## §5 Routing

| Verdict | Route |
|---------|-------|
| **PASS** | Cluster A **CLOSE** → team_100 (WP-W2-10 roll-up; B/E/F validated separately in this batch) |

---

*Issued by team_190 · L-GATE_VALIDATE rev2 · WP-W2-10-A · 2026-06-03 · Cursor Composer cross-engine.*
