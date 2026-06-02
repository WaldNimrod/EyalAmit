---
id: PROMPT-TEAM190-WP-W2-12-REVALIDATE-CORRECTED-CURSOR-2026-06-02
from_team: team_100
to_team: team_190 — RUN IN CURSOR / Composer
date: 2026-06-02
wp: WP-W2-12 (S003 DS-Hygiene) — RE-VALIDATE with corrected AC-01 proof
supersedes_proof_method_in: VERDICT-WP-W2-12-L-GATE-VALIDATE-2026-06-02.md (FAIL was a proof-method artifact)
context: _COMMUNICATION/team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md
---

# Corrected re-validate prompt — WP-W2-12 (run in Cursor)

**Why corrected:** the prior FAIL required observing the entrance stagger delays at runtime, but a PRE-EXISTING
top-level `.ea-entrance{animation:none !important}` in `ea-atoms.css` globally disables ALL entrance animations
(confirmed: `matchMedia('(prefers-reduced-motion: reduce)')` = false yet computed `animation-name: none`). That
condition predates WP-W2-12 and is unrelated to it. AC-01 ("pixel-identical") must therefore be proven by
**rendering / computed-style equivalence**, not by observing an animation that is globally off.

```
ROLE: team_190 — constitutional L-GATE_VALIDATE RE-RUN for WP-W2-12 (S003 DS-Hygiene), in Cursor/Composer
(cross-engine vs Claude DS builder team_80; team_00-approved). Repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026 .

Read first: _COMMUNICATION/team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md and
_aos/work_packages/S003/WP-W2-12/LOD400_spec.md .

AC-01 is "pixel-identical rendering after de-inlining" — prove it by EQUIVALENCE, NOT by observing the entrance
animation (which is globally disabled site-wide by a pre-existing ea-atoms.css `.ea-entrance{animation:none!important}`;
verify this yourself: matchMedia reduce=false on / yet computed animation-name=none on .ea-entrance elements).

Required AC-01 proof (all must hold):
1) COMPUTED-STYLE EQUIVALENCE on / for every element whose inline style="" was removed — the live computed value
   equals the original inline value (team_100 already measured; reproduce independently):
     .ea-block-cta-end            -> margin-top: 48px (=--ea-space-6), text-align: right
     .ea-service-comparison__note -> font-size: 12.48px (0.78rem), font-weight: 200, color: rgb(111,99,90) (#6F635A=--ea-muted), margin-bottom: 32px (=--ea-space-4)
     .ea-contact-form__note--cta  -> margin-top: 32px (=--ea-space-4)
   And the formerly-inline animation-delays are equally inert pre/post (computed animation:none, opacity:1) due to
   the pre-existing global kill — i.e., no rendering effect either way.
2) NO inline style="" remains in the 6 blocks (source + served HTML): method-pillars, treatment-overview,
   testimonials-row, books-row, services-row, contact-cta -> grep = 0.
3) VISUAL SANITY: screenshot / at desktop + mobile; confirm the homepage is intact/unbroken (layout, spacing,
   the 4 pillars / 3 testimonials / 3 books / 2 comparison cols / contact two-col all present and correctly spaced).
4) The token --ea-stagger-step:0.05s + nth-of-type calc rules are present in deployed CSS and arithmetic-correct
   (x2=0.10 x3=0.15 x4=0.20 x6=0.30) — i.e., the de-inlining is faithful and WOULD stagger correctly if/when the
   global animation:none is lifted (separate WP).

Also re-confirm: node scripts/qa/http-qa-axe.cjs /  (0 crit/serious); bash scripts/qa/http-qa-lighthouse.sh /
(a11y 100, mobile perf >=85 median); bash _aos/lean-kit/.../validate_aos.sh .  (0 FAIL).

Issue PASS/FAIL with rationale to:
  _COMMUNICATION/team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-REV2-2026-06-0X.md
Do NOT edit theme/_aos files — validate only.
```

## team_100 reference evidence (independently reproduced via puppeteer, no-preference)
- `:root` tokens: --ea-space-6=48px, --ea-space-4=32px, --ea-muted=#6F635A, --ea-stagger-step=0.05s.
- `.ea-block-cta-end` → marginTop 48px, textAlign right ✓
- `.ea-service-comparison__note` → fontSize 12.48px, fontWeight 200, color rgb(111,99,90), marginBottom 32px ✓
- `.ea-contact-form__note--cta` → marginTop 32px ✓
- `.ea-pillar:nth-of-type(2)` → animationName none, animationDelay 0s, opacity 1 (inert pre/post) ✓
All match the documented original inline values → de-inlining is rendering-equivalent (pixel-identical).
