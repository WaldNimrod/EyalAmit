---
id: MANDATE-TEAM50-W2-04-L-GATE-BUILD-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_50 (QA — L-GATE_BUILD)
wp: WP-W2-04 — Sound Healing + Lessons (2 service pages)
date: 2026-05-29
gate: L-GATE_BUILD
status: READY TO DISPATCH (awaiting team_00 go)
spec_ref: _aos/work_packages/S002/WP-W2-04/LOD400_spec.md
report_ref: _COMMUNICATION/team_100/W2-04-COMPLETION-REPORT-2026-05-29.md
engine_constraint: NON-CLAUDE (builder team_10 was Claude → IR#1 cross-engine: validator MUST differ)
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-04 (branch feature/w2-04-services)
---

# L-GATE_BUILD Mandate — WP-W2-04 (team_50, NON-Claude)

## Cross-engine (IR#1 — immutable)
Builder = team_10 on **Claude**. You (team_50) **MUST run on a non-Claude engine**
(cursor-composer / codex). Do not perform this gate on a Claude model.

## What to verify (against LOD400 spec AC-01..06, on the LIVE staging pages)
Live host: `http://eyalamit-co-il-2026.s887.upress.link`. Always cache-bust: append
`?cb=<epoch><rand>` to every fetch.

- **AC-01** `/sound-healing/` and `/lessons/` → HTTP 200.
- **AC-02** H1 + body match the 25.5.26 sources 1:1 under the normalization rule
  (`סאונדהילינג/sound_healing_final.md`, `שיעורי נגינה/lesons.md`). Normalization rule:
  clear typos normalized, Eyal's voice/slang preserved. Spot-check H1s + 2-3 body paragraphs/page.
- **AC-03** FAQ block on each page is **view-only** (no filter chips/select) and shows **only**
  that page's category (`sound-healing` resp. `lessons`) — zero items from treatment/method/general.
  `/faq` must still render the full filterable list (regression check).
- **AC-04** testimonials: Top-5 accordion, each with text + image + link. Images are **grey
  placeholders** (W2-07 carry-forward) — ACCEPTABLE at this gate. Confirm text + FB link present.
- **AC-05** CTA A/B active: in-page `[data-ea-ab]` CTA block; form → `/contact?subject=<slug>`,
  WhatsApp → `https://wa.me/972524822842`. Confirm all three variants exist in markup and the
  canonical `eyal_cta_variant` sessionStorage key drives visibility; GA4 `cta_click` wired.
- **AC-06** `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → 0 FAIL;
  mobile responsive (check ≤600px: CTA stacking, hero clamp, prose width). No raw hex (D-14 tokens).

## team_100 pre-verification (already done — confirm independently, don't just trust)
URLs 200 · validate 30 PASS/0 FAIL · AC-03 zero cross-category leakage (live HTML category attrs) ·
0 raw-hex in committed CSS/PHP · style.css 1.4.3 · `.env` untracked · 3 surgical commits
(ad53e47, 00c488b, 8de07c2).

## Known carry-forwards / flags (NON-blocking for this gate)
1. Internal-link slugs normalized to live routes (`/method-cbdidg`→`/method`,
   `/didgeridoo-treatment`→`/treatment`) — technical, not voice.
2. lessons FAQ "pregnancy" `/blog/pregnancy-didgeridoo` link exists in source `.md` but not in the
   canonical FAQ dataset — builder used the canonical dataset (no link). Pending team_00 decision.
3. Testimonial images = placeholders (W2-07).

## Verdict
Write `PREVERDICT_WP-W2-04_L-GATE_BUILD_2026-05-29.md` (or VERDICT) to `_COMMUNICATION/team_50/`
with PASS/FAIL per AC + evidence (HTTP codes, FAQ category counts, validate tail). On PASS, the WP
advances to L-GATE_VALIDATE (team_190, native Codex). Surgical commits only; never `git add -A`.

*team_100 — 2026-05-29 — READY TO DISPATCH on team_00 go.*
