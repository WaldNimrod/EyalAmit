# MANDATE — team_110 → team_190 · FINAL validation: Mukesh memorial page

**Issued:** 2026-06-21 (authorized by Nimrod/team_00) · **Mechanism:** file-transport (hub DB offline, ADR043 §4/§5)
**From:** team_110 (BUILDER) · **To:** team_190 (FINAL VALIDATION OWNER — Iron Rule #5, constitutional, cross-engine, immutable)

## Subject
Final, independent validation of the rebuilt Mukesh memorial page (full verbatim memorial + media). **Builder ≠ validator (Iron Rule #1)** — use a different engine than the build; re-run, do not trust the builder's numbers.

- **Route:** `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/`
- **Theme:** 1.4.16 · **Branch:** `mokesh-content` (uncommitted; off `wave1b-seo-geo`)
- **Full build detail + builder evidence:** `_COMMUNICATION/team_110/MOKESH-BUILD-COMPLETE-DUALPASS-REQUEST-2026-06-21.md`

## Acceptance criteria (all must hold)
1. **content-diff** (mokesh): sectionCov ≥ 95, sentenceCov ≥ 90, inventedSections = 0.
2. **axe**: 0 critical / 0 serious on the route.
3. **qa_probe** (CDP): no horizontal overflow mobile+desktop; title present.
4. **Redirects**: `/about/moksha/`, `/mokesh/`, `/mokesh-dahiman/` → single 301 hop → canonical 200; canonical tag + VideoObject @ `/eyal-amit/mokesh-dahiman/`.
5. **Verbatim fidelity & dignity**: all 11 doc sections present and byte-verbatim; «Jungle Vibes» spelling; hero trailer (muted autoplay + unmute, motion-gated); 19 media-library photos in order; full-film placeholder; 4 FB embeds.

## Accepted, non-blocking flags
Legacy Hebrew-slug 2-hop (generated `w209`, deferred to SEO/GEO redirect-regen); VideoObject `uploadDate` unknown; full-film placeholder pending Eyal's link; «בתחתית העמוד» promo line kept verbatim though trailer moved to hero. See build-complete doc §Open flags.

## Deliverable
`_COMMUNICATION/team_190/VERDICT_MOKESH_…_2026-06-21.md` (PASS/FAIL + evidence). Constitutional final sign-off. No "ready" to Eyal until team_50 AND team_190 both PASS.
