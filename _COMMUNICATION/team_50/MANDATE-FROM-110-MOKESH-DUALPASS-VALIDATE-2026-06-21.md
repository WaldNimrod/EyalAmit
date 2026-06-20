# MANDATE — team_110 → team_50 · Independent validation: Mukesh memorial page

**Issued:** 2026-06-21 (authorized by Nimrod/team_00) · **Mechanism:** file-transport (hub DB offline, ADR043 §4/§5)
**From:** team_110 (BUILDER) · **To:** team_50 (VALIDATOR) · **Iron Rule #1:** builder engine ≠ validator engine — use a different engine than the build.

## Subject
team_110 rebuilt the Mukesh memorial page from ~6% to the FULL verbatim memorial + media and deployed it to staging. **Validate independently — do not trust the builder's run; re-run the gates yourself.**

- **Route:** `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/`
- **Theme:** 1.4.16 · **Branch:** `mokesh-content` (uncommitted; off `wave1b-seo-geo`)
- **Full build detail + builder evidence:** `_COMMUNICATION/team_110/MOKESH-BUILD-COMPLETE-DUALPASS-REQUEST-2026-06-21.md`

## Required validations (re-run independently; all must PASS)
1. **Content accuracy:** `node scripts/qa/content-diff.mjs` → mokesh row must show **sectionCov ≥ 95, sentenceCov ≥ 90, inventedSections = 0** (builder saw 100/100/0).
2. **Accessibility:** `node scripts/qa/http-qa-axe.cjs /eyal-amit/mokesh-dahiman/` → **0 critical / 0 serious**.
3. **Layout/overflow (CDP, not curl):** `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /eyal-amit/mokesh-dahiman/` → no horizontal overflow (mobile+desktop), title non-empty.
4. **Redirect single-hop:** `/about/moksha/`, `/mokesh/`, `/mokesh-dahiman/` each → 301 → `/eyal-amit/mokesh-dahiman/` (200) in **one hop**.
5. **Content/visual review:** 11 doc sections present & verbatim; «Jungle Vibes» (no `jungel`); hero trailer autoplays muted + unmute works; 19 photos in order; full-film placeholder; 4 FB embeds; dignified on mobile.

## Known/accepted flags (NOT failures — see build-complete doc §Open flags)
Legacy Hebrew-slug 2-hop deferred to SEO/GEO redirect-regen; VideoObject has no `uploadDate`; full-film is a placeholder; the «בתחתית העמוד» promo line is kept verbatim though the trailer is in the hero (Eyal-review).

## Deliverable
Write your verdict to `_COMMUNICATION/team_50/VERDICT_MOKESH_…_2026-06-21.md` (PASS/FAIL + evidence). team_110 will NOT declare "ready" to Eyal until **both team_50 AND team_190** PASS.
