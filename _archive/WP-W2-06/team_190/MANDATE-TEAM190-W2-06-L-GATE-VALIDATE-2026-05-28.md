---
id: MANDATE-TEAM190-W2-06-L-GATE-VALIDATE-2026-05-28
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
wp: WP-W2-06 — Blog Migration
date: 2026-05-28
gate: L-GATE_VALIDATE
build_commit: 78edf9d
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# L-GATE_VALIDATE Mandate — WP-W2-06 (Blog Migration)

## §0 — Engine constraint (IR#1)
team_190 MUST run on **native Codex / OpenAI / GPT-5** (≠ claude builder, ≠ cursor QA). Confirm engine in line 1.

## §1 — Prior gate state
- **L-GATE_BUILD: PASS_WITH_FINDINGS** (team_50 cursor-composer) — 8/8 ACs PASS. AC-04 (archive routing) FAILed then remediated (commit `78edf9d`: `ea_w2_06_template_include` routes is_home→tpl-blog-archive + is_singular(post)→tpl-blog-single + `ea_wave2_shell`), re-QA PASS.
  - Verdict: `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-06-L-GATE-BUILD-2026-05-28.md`
  - Findings: **P3 only** — F-W2-06-03 ([vc_row] in archive excerpts → IDEA-006); F-W2-06-05 (2 orphaned 404 upload refs in REST content, not rendered → IDEA-007). No P0/P1.
- **L-GATE_SPEC:** PASS_WITH_FINDINGS (your v2 verdict, 2026-05-28).

## §2 — Scope
Validate the blog migration against the LOD400 spec `_aos/work_packages/S002/WP-W2-06/LOD400_spec.md`: 54 posts at root `/%postname%/`, 6 categories + 47 tags, Wave2 archive (`/blog/`) + single templates, media localized to new site (relative links; 6 dead-at-source excluded), `/Blog/`→301→root. Apply 8-check validation + LOD400 precision gate. Independently re-verify live (cache-busted): post 200s at root, `/blog/` Wave2 archive renders, `/Blog/`→301→root, images load from new site.

## §3 — Known non-blocking (do NOT block)
P3 carry-forwards IDEA-006 (excerpt [vc_row]) + IDEA-007 (2 orphaned 404 refs). The 6 dead-at-source media (muzza DNS / namaste 404 / mailchimp 403 / 1 legacy 404) were broken pre-migration.

## §4 — Deliverable
Verdict → `_COMMUNICATION/team_190/VERDICT-WP-W2-06-L-GATE-VALIDATE-2026-05-28.md` (PASS / BLOCKED).
- On **PASS** → team_100 executes WP Closure Protocol for W2-06, then merges `feature/w2-06-blog` → main (closes BOTH W2-02 + W2-06, which share the branch).
- On **BLOCKED** → team_100 routes remediation.

*team_100 — 2026-05-28*
