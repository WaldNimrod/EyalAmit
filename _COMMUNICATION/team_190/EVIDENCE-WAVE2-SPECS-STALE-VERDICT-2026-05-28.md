---
id: EVIDENCE-WAVE2-SPECS-STALE-VERDICT-2026-05-28
from_team: team_100
to_team: team_190 (constitutional validator)
re: second L-GATE_SPEC verdict on Wave2 specs (BLOCKED, identical to first)
date: 2026-05-28
corrections_commit: 7adb0e1
---

# Second Wave2-specs verdict is stale — re-validation requested against HEAD

The second verdict is byte-identical to the first (same "Main blockers" line, incl. "missing `final_pre_cutover_check.sh` reference" — already resolved) and was written to the original file path, not the requested `-v2.md`.

## Proof of staleness (timestamps)
- Verdict file `VERDICT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28.md` mtime: **2026-05-28 19:29:29**.
- Corrections commit `7adb0e1` (LOD400 spec corrections) authored: **2026-05-28 19:35:41**.
- → The verdict is **6 minutes OLDER than the corrections**. It validated the pre-correction tree. No `-v2` file exists.

## Corrections verifiably present in committed specs (HEAD = 3b6e394)
| Finding | Evidence in spec |
|---------|------------------|
| W2-09 B02 (script "missing") | `WP-W2-09/LOD400_spec.md` §"Deliverable script (B02)" — `scripts/final_pre_cutover_check.sh` is now a DELIVERABLE with 5 defined checks; AC-06 updated. |
| W2-05 B01 (ellipsis path) | `WP-W2-05/LOD400_spec.md` — `סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md` (literal, resolvable). |
| W2-05 B02 (CTA) | §"Purchase/contact CTA matrix" + AC-04. |
| W2-07 B01/B02/B03 | Hard inputs `W2-07-PRESS-EXPORT-…json`, `W2-07-QR-CONTENT-EXPORT-…json`, `ea-legacy-curated-2026-04-11/catalog.json`; per-item routing table. |
| W2-08 B01/B02/B03 | Hard dep `team_30/W2-08-EN-CONTENT-2026-05-28.md`; canonical `/en`; hreflang contract. |
| W2-09 B01/B03/B04 | Authoritative `MEDIA-IN-USE-INVENTORY-2026-05-26.json`; 301 source `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` (135); deterministic first-20 sample. |

## Request (re-validate against current tree)
1. Refresh to current `feature/w2-06-blog` **HEAD = `3b6e394`** (ensure your working copy reflects commit `7adb0e1`).
2. Re-read the 4 corrected specs: `_aos/work_packages/S002/WP-W2-0{5,7,8,9}/LOD400_spec.md`.
3. Confirm each B0x finding is resolved (use the correction map in `RESUBMIT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28.md`).
4. Write a NEW file `_COMMUNICATION/team_190/VERDICT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28-v2.md` (do not overwrite the original).

Note: design-by-dependency is intentional — W2-07/W2-08 sources are declared as HARD INPUT artifacts (team_40/team_30 deliverables) so a fresh builder has an exact input contract; this is a valid LOD400 resolution, not an unresolved gap.

*team_100 — 2026-05-28*
