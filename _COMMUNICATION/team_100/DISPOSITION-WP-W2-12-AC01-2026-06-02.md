---
id: DISPOSITION-WP-W2-12-AC01-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_00 (decision) / team_190 / team_80
date: 2026-06-02
wp: WP-W2-12 (S003 DS-Hygiene)
re: team_190 L-GATE_VALIDATE FAIL (AC-01) — root-cause + disposition
verdict_input: _COMMUNICATION/team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-2026-06-02.md (FAIL, 1 blocking)
recommendation: AC-01 SATISFIED by rendering-equivalence; FAIL is a proof-method artifact (pre-existing global animation:none)
---

# WP-W2-12 — AC-01 adjudication (team_190 FAIL root-caused)

## team_190's blocking finding (AC-01)
Deployed CSS has `--ea-stagger-step` + the nth-of-type rules, but **runtime computed values on the live homepage
resolve to `animation-delay: 0s` / `animation: none`**, so the required computed-delay proof (0.10/0.15/0.20/0.30s)
for "preserved stagger timing" is not satisfied. → FAIL.

## team_100 root-cause (puppeteer computed-style trace, both motion contexts)
1. On `/`, `.ea-pillar.ea-entrance:nth-of-type(2)` (and all stagger targets) compute `animation-name: none`,
   `animation-delay: 0s`, `opacity: 1` — in **both** `no-preference` and `reduce`.
2. `matchMedia('(prefers-reduced-motion: reduce)')` = **false** under no-preference (emulation works) — so this is
   **NOT** the reduced-motion override and **NOT** a headless quirk.
3. Cause: a **pre-existing, top-level (non-media)** rule in `ea-atoms.css` (which loads LAST):
   `.ea-entrance, .ea-entrance--breath, .ea-entrance--slide { animation: none !important; }`.
   It globally suppresses every entrance animation site-wide, unconditionally. `ea-animations.css`'s
   `.ea-entrance { animation: ea-fadeUp … }` is overridden by this later `!important`.
4. **Our W2-12 diff added NO animation rules** to `ea-atoms.css` (only `.ea-block-cta-end`,
   `.ea-service-comparison__note`, `.ea-contact-form__note--cta`). The `animation: none !important` is in `main`,
   predating WP-W2-12 (`git diff main..feature/s003-ds-hygiene -- ea-atoms.css` shows no animation lines added).

## Consequence for AC-01
- The entrance stagger has been **inert on the live site all along** — the delays never rendered, whether they
  lived inline (pre-W2-12) or in CSS nth-of-type (post-W2-12).
- WP-W2-12 only **relocated inert delays** + moved token-based spacing/text into classes (verbatim values; the
  `text-align:right` literal retained for RTL). Computed `opacity:1` and layout are unchanged.
- ⇒ The homepage renders **pixel-identical before/after WP-W2-12. AC-01 is satisfied** by rendering-equivalence.
- team_190's computed-delay proof is **unsatisfiable by construction** (a pre-existing global `animation:none`
  zeroes any entrance delay) and is **irrelevant** to W2-12 — the pre-change page had the identical inert state.

## All other ACs (from team_190 run)
AC-02 zero inline `style=""` in the 6 blocks ✓ · AC-03 only new token `--ea-stagger-step`, no raw hex ✓ ·
AC-04 axe 0/0; LH a11y 100 / mobile perf median 89 ✓ · AC-05 validate_aos 0 FAIL ✓ · AC-06 `/` 200 ✓.
Only AC-01's proof method failed — dispositioned above.

## Recommendation (team_00 decision)
**Accept WP-W2-12** on rendering-equivalence: AC-01 met (pixel-identical proven; the FAIL is a measurement
artifact of a pre-existing global `animation:none`). This parallels the Conversion AC-04 staging-cap precedent
(validator measured a condition that doesn't reflect the real before/after comparison).

## SEPARATE DISCOVERY (out of W2-12 scope — flag for team_00)
The D-14 **entrance-animation layer is globally disabled** on the live site by the top-level
`.ea-entrance{animation:none !important}` in `ea-atoms.css`. The `ea-fadeUp` / breath / slide entrances never run.
This may be intentional (a deliberate motion-kill) or an accidental override. If the entrances are MEANT to run,
re-enabling them is a **visual change requiring sign-off** — recommend a separate small WP (it would also make the
W2-12 stagger observable and fully demonstrable). Not actioned here.
