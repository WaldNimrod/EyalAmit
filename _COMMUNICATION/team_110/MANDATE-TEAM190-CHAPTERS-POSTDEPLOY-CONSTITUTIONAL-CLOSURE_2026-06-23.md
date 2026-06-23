---
id: MANDATE-TEAM190-CHAPTERS-POSTDEPLOY-CONSTITUTIONAL-CLOSURE_2026-06-23
from_team: team_110
to_team: team_190 (FINAL VALIDATION OWNER)
cc: team_00, team_100, team_50
date: 2026-06-23
type: POST_DEPLOY_CONSTITUTIONAL_CLOSURE
scope: Chapters full-site — F110-01 live closure + mandate gap completion
staging: http://eyalamit-co-il-2026.s887.upress.link
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home)
engine_validator: NON-CLAUDE (different from team_50 cursor-composer if possible)
mechanism: file-transport (ADR043 §4/§5)
parent_mandate: _COMMUNICATION/team_100/MANDATE-TEAM190-CHAPTERS-FULLSITE-FINAL-2026-06-22.md
gap_analysis: _COMMUNICATION/team_110/GAP-ANALYSIS_CHAPTERS-FULLSITE-MANDATE-COVERAGE_2026-06-23.md
inputs:
  - _COMMUNICATION/team_100/CLOSEOUT_CHAPTERS-FULLSITE_POSTFIX_DEPLOY_E2E_2026-06-23.md
  - _COMMUNICATION/team_100/evidence/chapters-postdeploy-2026-06-23/
  - _COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_2026-06-22.md
status: ISSUED
---

# Mandate — team_190 — Post-deploy constitutional closure (2026-06-23)

## 0) Purpose

team_100 deployed the F110-01 fix to live staging and ran a **regression suite**. This mandate requires team_190 to:

1. **Close F110-01 on live** (independent probe).
2. **Complete mandate gaps** not covered by the post-deploy regression (see gap analysis §6).
3. Issue an **updated constitutional verdict** upgrading overall status if all criteria hold.

**Do NOT** edit, commit, merge, or deploy. Measure and report only.

---

## 1) Inputs (read first)

| Document | Role |
|----------|------|
| [CLOSEOUT team_100](../team_100/CLOSEOUT_CHAPTERS-FULLSITE_POSTFIX_DEPLOY_E2E_2026-06-23.md) | Deploy + regression summary |
| [GAP analysis](GAP-ANALYSIS_CHAPTERS-FULLSITE-MANDATE-COVERAGE_2026-06-23.md) | What was / wasn't re-validated |
| [Prior verdict 2026-06-22](../team_190/VERDICT_CHAPTERS-FULLSITE_2026-06-22.md) | Baseline PASS_WITH_FINDINGS |
| [scope.json](../team_190/evidence/chapters-fullsite-2026-06-22/scope.json) | Frozen 26 routes + ledger |

Evidence root (team_190 write): `_COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/`

---

## 2) Phase A — F110-01 live closure (blocking)

**Independent** re-run (do not trust team_100 numbers):

```bash
node scripts/qa/seo-head-probe.mjs \
  --out _COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/seo \
  /books/vekatavta/ /eyal-amit/mokesh-dahiman/ /en/
```

**Pass:** `metaDescriptionCount: 1` on all three routes; canonical + yoastGraph unchanged; copy matches [`team_110/.../seo_head_expected_post_deploy.json`](../team_110/evidence/chapters-fullsite-fixround-2026-06-23/seo/seo_head_expected_post_deploy.json).

---

## 3) Phase B — Full mandate gap completion

Re-run **yourself** against live staging (`?nc=<random>`). Prior 2026-06-22 evidence may be **cited** only where the post-deploy change was head-only and your re-probe confirms no regression.

### B1 — Content accuracy (priority)

```bash
node scripts/qa/content-diff.mjs \
  --out _COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/content
```

**Bar:** 17 gated pages @ 100% minus ledger; 0 invented sections.  
**Plus:** eyeball ≥3 pages (live vs source `.md`) — minimum: `/treatment/`, `/books/vekatavta/`, `/eyal-amit/mokesh-dahiman/`.

### B2 — a11y — ALL mandate routes (not just 5)

```bash
node scripts/qa/http-qa-axe.cjs --base http://eyalamit-co-il-2026.s887.upress.link \
  / /method/ /treatment/ /sound-healing/ /lessons/ /eyal-amit/ /faq/ \
  /didgeridoos/ /bags/ /stands-storage/ /stand-floor/ /repair/ /books/ \
  /books/vekatavta/ /books/kushi-blantis/ /books/tsva-bekahol/ \
  /eyal-amit/mokesh-dahiman/ /contact/ /blog/ /galleries/ /media/ \
  /privacy/ /accessibility/ /terms/ /en/ /blog/page/2/
```

**Bar:** 0 critical / 0 serious on every route.

### B3 — h1 + dir — ALL mandate routes

```bash
EA_H1_OUT=_COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/h1-rtl/h1-rtl-http-probe.json \
node scripts/qa/h1-rtl-http-probe.cjs <same 26 routes as B2>
```

**Bar:** 26/26 — `h1=1`; `dir=rtl` except `/en/` → `ltr`.

### B4 — Layout overflow (CDP)

Either re-affirm team_100 post-deploy `qa_probe_result.json` (182 checks, 0 failures) **or** independent re-run:

```bash
node "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs" \
  --config _COMMUNICATION/team_190/evidence/chapters-fullsite-2026-06-22/qa_probe/qa_probe_config.json \
  --out _COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/qa_probe
```

**Bar:** 0 overflow; forbidden terms absent on Chapters-built pages (blog archive brand = F110-02 closed).

### B5 — Structure/SEO (beyond F110-01)

- **301 one-hop:** `/muzza/`→`/books/`; `/about/moksha/` `/mokesh/`→`/eyal-amit/mokesh-dahiman/` (reuse or re-run `wave1-redirect-probes.mjs`).
- **Blog:** pagination page 2 ≠ page 1; representative single-post canonical + og:image + meta.
- **Head spot-check:** Yoast `@graph` + single `og:image` on representative routes (not only F110-01 three).

### B6 — Design fidelity + media (browser — mandatory)

Per parent mandate §5 — **in the browser**, not git:

| Check | Pages |
|-------|-------|
| Mockup comparison | `/`, `/method/`, `/treatment/`, `/books/vekatavta/`, `/eyal-amit/mokesh-dahiman/` |
| Book covers visible | `/books/`, `/books/vekatavta/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/` |
| Mokesh memorial photos in order | `/eyal-amit/mokesh-dahiman/` |
| EN LTR layout | `/en/` |
| No broken CSS/images/RTL | Any page with visual breakage from qa_probe screenshots |

Deliver: `design/eyeball-spot-checks.md` + PNG samples under evidence root. Mockup refs: `/tmp/ea-mock/` or handoff zip per team_50 mandate §5.

### B7 — Function

| Check | Method |
|-------|--------|
| CF7 form present | Live `/contact/` DOM |
| WhatsApp CTA + `generate_lead` | Click probe or network log |
| Blog pagination | Compare post permalinks page 1 vs `/blog/page/2/` |

Evidence: `function/contact_whatsapp_probe.json`, `seo/blog_pagination_posts.json` (or equivalent).

---

## 4) Approved ledger (do not fail)

Unchanged from parent mandate §7 / `scope.json` — retired brand, provisional testimonials, placeholder pages, contact/blog not content-gated.

---

## 5) Deliverables

1. **Verdict addendum or superseding verdict:**  
   `_COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md`

   Verdict box: **PASS / PASS_WITH_FINDINGS / BLOCK**

   Must state per parent mandate criterion (§1–§6) PASS/FAIL and whether F110-01 is **CLOSED (live)**.

2. **Evidence:** `_COMMUNICATION/team_190/evidence/chapters-postdeploy-closure-2026-06-23/`

3. **Route to team_00 / team_100** — merge `chapters-home`→`main` gated on **PASS** from this addendum + prior team_50 PASS.

---

## 6) Exit criteria for overall PASS

- F110-01 **CLOSED (live)** on independent probe.
- No regression vs 2026-06-22 on content, axe, overflow, h1, function.
- Design/media eyeball **PASS** on key pages (or documented ledger/placeholder scope).
- SEO criterion upgraded: **PASS_WITH_FINDINGS → PASS**.

---

*team_110 — 2026-06-23 — canonical post-deploy constitutional closure mandate for team_190.*
