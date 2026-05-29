---
id: MANDATE-TEAM190-W2-04-L-GATE-VALIDATE-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_190 (Senior Constitutional Validator — L-GATE_VALIDATE)
wp: WP-W2-04 — Sound Healing + Lessons (2 service pages)
date: 2026-05-29
gate: L-GATE_VALIDATE (constitutional, final — IR#5)
status: READY TO DISPATCH (awaiting team_00 go)
spec_ref: _aos/work_packages/S002/WP-W2-04/LOD400_spec.md
report_ref: _COMMUNICATION/team_100/W2-04-COMPLETION-REPORT-2026-05-29.md
preverdict_ref: _COMMUNICATION/team_50/PREVERDICT_WP-W2-04_L-GATE_BUILD_2026-05-29.md
engine_constraint: NATIVE CODEX / GPT-5 (builder=Claude team_10, L-GATE_BUILD=cursor-composer team_50 → IR#1)
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-04 (branch feature/w2-04-services)
---

# L-GATE_VALIDATE Mandate — WP-W2-04 (team_190, native Codex)

## Constitutional role (IR#5)
You own final validation. It is **constitutional, cross-engine, and immutable**. Builder ran on
Claude (team_10); L-GATE_BUILD ran on cursor-composer (team_50). You **MUST run on native
Codex / GPT-5** — a third distinct engine. Confirm your engine first. Validate independently;
the team_50 PASS is input, not proof.

## Validate AC-01..06 on the LIVE staging pages
Host `http://eyalamit-co-il-2026.s887.upress.link` — cache-bust every fetch (`?cb=<epoch><rand>`).
- **AC-01** `/sound-healing/`, `/lessons/` → 200 (no redirect chain).
- **AC-02** H1 + body 1:1 with sources (`סאונדהילינג/sound_healing_final.md`,
  `שיעורי נגינה/lesons.md`) under the normalization rule (clear typos fixed, Eyal's voice/slang
  preserved). Spot-check H1 + several body paragraphs per page against source.
- **AC-03** FAQ view-only (no chips/select), ONLY the page's own category
  (`sound-healing` / `lessons`), zero leakage; `/faq` full filterable list intact (regression).
- **AC-04** testimonials Top-5 accordion: text + image + link. **W2-07 is OPEN** (roadmap
  `block_reason: pending hard inputs`) → per spec F02 the **placeholder images are an accepted,
  declared carry-forward** — do NOT fail AC-04 on placeholder images. Confirm text + FB link present.
- **AC-05** CTA A/B: `[data-ea-ab]` block; all three variants in markup; form →
  `/contact?subject=<slug>`, WhatsApp → `https://wa.me/972524822842`; canonical
  `eyal_cta_variant` sessionStorage drives visibility; GA4 `cta_click {variant_label,page}` wired.
- **AC-06** `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → 0 FAIL;
  mobile responsive (≤600px CTA stacking, hero clamp); no raw hex (D-14 tokens only).

## Inputs already verified upstream (confirm, don't assume)
- team_100 independent: URLs 200, validate 0 FAIL, AC-03 zero leakage, 0 raw hex, style.css 1.4.3,
  `.env` untracked, surgical commits ad53e47/00c488b/8de07c2.
- team_50 (cursor-composer): PASS 6/6, preverdict fad7e1e (50 FAQ items on /faq + #ea-faq-cat select).

## Carry-forwards / flags (non-blocking)
1. Internal slug normalization (`/method-cbdidg`→`/method`, `/didgeridoo-treatment`→`/treatment`) — technical.
2. lessons pregnancy FAQ `/blog/pregnancy-didgeridoo` link in source `.md` but not in canonical
   FAQ dataset — builder used canonical dataset; pending team_00 decision (does not affect AC pass).
3. Testimonial placeholder images — W2-07 carry-forward (W2-07 open).

## Verdict
Write `VERDICT-W2-04-L-GATE-VALIDATE-2026-05-29.md` to `_COMMUNICATION/team_190/` with PASS/FAIL
per AC + evidence + engine attestation. On PASS, WP-W2-04 is cleared for closure
(roadmap COMPLETE/LOD500_LOCKED via offline-fallback pending hub PRECONDITION#1 decision) +
team_191 archive. Surgical commits only; never `git add -A`.

*team_100 — 2026-05-29 — READY TO DISPATCH on team_00 go.*
