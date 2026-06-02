---
id: VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_50, team_10
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-03
round: 1
engine: cursor-composer (cross-engine; IR#1 + IR#5)
verdict: FAIL
blocking_findings: 1
cluster: Service (A) — /treatment, /method, /sound-healing, /lessons
wp: WP-W2-10-A (S003 Track-2)
branch: main
worktree_head: 1d0e925a15c7c15987a5f08872011bcb6960d772
staging: http://eyalamit-co-il-2026.s887.upress.link
spec_ref: _aos/work_packages/S003/WP-W2-10-A/LOD400_IMPL_spec.md §7
elevation_ssot: _COMMUNICATION/team_35/WP-W2-10-A/elevation/
token_gate_ref: _COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md
build_gate_ref: _COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03.md
mandate_ref: _COMMUNICATION/team_190/MANDATE-TEAM190-WP-W2-10-L-GATE-VALIDATE-2026-06-03.md
---

# VERDICT — WP-W2-10-A Service cluster | L-GATE_VALIDATE

## §0 Verdict box

| Field | Value |
|-------|-------|
| WP | WP-W2-10-A — Service cluster (4 routes, `tpl-service`) |
| Gate | L-GATE_VALIDATE (team_190 — constitutional, immutable) |
| Predecessor | team_50 L-GATE_BUILD **PASS** (`QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03.md`) |
| Verdict | **FAIL** |
| Blocking (P0) | **1** — bio-block portrait 404 on staging (wrong theme URI) |
| Non-blocking | F-W2-10-A-01 (mobile perf median 87 — bar met); F-W2-10-A-02 (composition CSS in shared `ea-atoms.css` — team_80 noted, relocatable) |
| Cluster close | **BLOCKED** — return to **team_10** for portrait URI fix + redeploy; re-run team_50 → team_190 |

---

## §1 Gate chain (IR#1 / IR#5)

| Step | Team | Engine | Artifact | Status |
|------|------|--------|----------|--------|
| S4 tokens | team_80 | — | `TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md` | **PASS** (carried) |
| S5 build | team_50 | Cursor Composer | `QA-VERDICT-WP-W2-10-A-L-GATE-BUILD-2026-06-03.md` | **PASS** — confirmed before this run |
| S5 validate | team_190 | Cursor Composer | this document | **FAIL** |

team_50 PASS reproduced for axe/LH/HTTP/H1; team_50 explicitly did **not** re-verify AC-A2 composition parity or AC-A6 real-portrait wiring (see team_50 §4 out-of-scope note). This validator independently exercised the full A/C boundary per mandate.

---

## §2 Blocking finding (P0)

### T190-W2-10-A-P0-01 — Bio portrait not loaded (AC-A6 / cluster A)

| Field | Value |
|-------|-------|
| AC | AC-A6 · mandate cluster A “real portrait” |
| Symptom | `<img class="ea-bio-block__portrait">` present on all 4 routes but **`naturalWidth === 0`** (broken image) |
| Rendered `src` (staging) | `http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/generatepress/assets/images/eyal-portrait-hero.jpg` → **HTTP 404** |
| Correct asset (staging) | `http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/images/eyal-portrait-hero.jpg` → **HTTP 200** (173 KB) |
| Root cause (repo) | `inc/wave2-w2-04.php` L513 uses `get_template_directory_uri()` (parent **GeneratePress**) instead of `get_stylesheet_directory_uri()` (child **ea-eyalamit**) where the file lives |
| Remediation | One-line fix + FTP deploy `assets/images/eyal-portrait-hero.jpg` path unchanged; re-smoke portrait HTTP 200 + `naturalWidth > 0` on `/treatment/` |

**Routing:** team_10 (S3 surgical fix) → team_50 L-GATE_BUILD re-pass → team_190 L-GATE_VALIDATE re-run.

---

## §3 Acceptance criteria matrix

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-A1 | S2 Eyal sign-off | **N/A** (pre-recorded; not re-audited) | LOD400 §1 READY_FOR_S2 |
| AC-A2 | Full 14-block composition; no `the_content()` fallback; mockup parity | **PASS** | Puppeteer block order on all 4 routes: `hero` → `intro` → `breath-divider-1` → `content-section` → `method-pillars`×2 (4-step `--steps` + 5-tile who) → `bio` → `service-comparison` → `testimonials-row` → `faq-mini` → `disclaimer` → `contact-cta`; no `main .entry-content`; vs `elevation/mockup/service-treatment.html` |
| AC-A3 | Zero D-14 drift | **PASS** | team_80 PASS; `git diff 305d4fa -- ea-tokens.css` empty (0 lines); validator: 0 inline `style=` in `main` on all routes |
| AC-A4 | axe 0 critical / 0 serious (4 routes) | **PASS** | `node scripts/qa/http-qa-axe.cjs /treatment/ /method/ /sound-healing/ /lessons/` → exit **0**; 4/4 crit=0 serious=0 |
| AC-A5 | LH https mobile: a11y **100**; perf median **≥85** (`/treatment/` + `/method/`) | **PASS** | Independent ×3 mobile runs — `/treatment/`: perf **87/87/87** median **87**, a11y **100**×3; `/method/`: perf **87/87/87** median **87**, a11y **100**×3. Reports: `scripts/qa/reports/lh-mobile-t190-w2-10-a_{treatment,method}_run{1,2,3}.json`. Supplemental desktop: `http-qa-lighthouse.sh` perf **98** a11y **100** both |
| AC-A6 | Graceful Eyal-gaps; **real portrait live**; no console errors | **FAIL** | Sand-circle avatars ×3 ✓; hero gradient + 3 breath-lines ✓; **portrait 404** ✗ (P0-01). Console/page errors: **0** on all routes |
| AC-A7 | HTTP 200; single H1; RTL; landmarks; `validate_aos` 0 FAIL | **PASS** (portrait sub-item fails AC-A6, not structural AC-A7) | curl 200 all 4 routes; H1=1 each; `html dir=rtl` `lang=he-IL`; landmarks present; `validate_aos.sh` → **30 PASS / 18 SKIP / 0 FAIL** |

**Summary:** **6/7 PASS**, **1 FAIL** (AC-A6 portrait wiring). Constitutional gate = **FAIL**.

---

## §4 Cluster-specific checks (mandate)

| Check | Result | Evidence |
|-------|--------|----------|
| cbDIDG 4-step grid | **PASS** | `.ea-pillars-grid--steps .ea-pillar` count = **4** all routes |
| “למי מתאים” 5-tile grid | **PASS** | non-steps pillar grid count = **5** all routes |
| Service-comparison active state | **PASS** | `/treatment/`: active col “טיפול בדיג'רידו” + tag “הדף הזה”; `/method/`: active col treatment (per spec); `/sound-healing/`: active “סאונד הילינג…”; `/lessons/`: active “שיעורי נגינה…” |
| Disclaimer verbatim | **PASS** | Live text matches mockup + `ea_wave2_service_disclaimer_text()` exactly |
| Hero kicker + CTA pair + 3 breath-lines | **PASS** | kicker present; 2 CTAs; 3 `.ea-hero__breath-line` |
| Testimonials ×3 + sand avatars | **PASS** | 3 cards; 3 `.ea-testimonial-card__avatar-placeholder` |
| FAQ-mini ×3 | **PASS** | 3 `.ea-faq-item` |
| Real portrait in bio-block | **FAIL** | P0-01 |
| RTL logical props (Hebrew) | **PASS** | `dir=rtl`; 0 inline styles in `main`; pre-existing `text-align:right` in `ea-atoms.css` is legacy POC literal per team_80 — not introduced by WP-W2-10-A |

---

## §5 Validator reproduction (2026-06-03)

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026"
node scripts/qa/http-qa-axe.cjs /treatment/ /method/ /sound-healing/ /lessons/
bash scripts/qa/http-qa-lighthouse.sh /treatment/ /method/
# Mobile AC-A5: https LH ×3 — reports scripts/qa/reports/lh-mobile-t190-w2-10-a_*.json
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
curl -s -o /dev/null -w "%{http_code}" \
  "http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/images/eyal-portrait-hero.jpg"
# → 200
curl -s -o /dev/null -w "%{http_code}" \
  "http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/generatepress/assets/images/eyal-portrait-hero.jpg"
# → 404
```

| Command | Exit code |
|---------|-----------|
| `http-qa-axe.cjs` (4 routes) | **0** |
| `http-qa-lighthouse.sh` `/treatment/` `/method/` | **0** |
| `validate_aos.sh` | **0** |
| Composition probe (Puppeteer, `scripts/qa/`) | **1** (portrait load) |

---

## §6 Routing recommendation

| Verdict | Route |
|---------|-------|
| **FAIL** | **team_10** — fix `get_stylesheet_directory_uri()` for portrait in `wave2-w2-04.php` L513 (mirror `block-topnav.php` / W2-08 pattern); redeploy; confirm staging portrait 200 + visible |
| Re-gate | **team_50** L-GATE_BUILD → **team_190** L-GATE_VALIDATE (this cluster only) |
| On PASS | **team_100** closure → ADR042: team_191 ARCHIVE_MANIFEST → roadmap DONE/LOD500_LOCKED |

Clusters **B / E / F** — not validated in this run (await team_50 PASS per cluster).

---

*Issued by team_190 · L-GATE_VALIDATE · WP-W2-10-A · 2026-06-03 · Cursor Composer cross-engine.*
