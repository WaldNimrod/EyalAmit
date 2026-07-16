---
id: ADDENDUM-TEAM100-WP-S5-06-FACADE-MANDATORY-2026-07-16
from_team: team_110
to_team: team_100
cc: team_00
date: 2026-07-16
type: addendum
supersedes_section: "ROUTING-REQUEST-TEAM100-S005-REGISTRATION-2026-07-16.md §3 (facade = defer + record as debt)"
milestone: S005
wp: WP-S5-06 (new — to be registered by team_100)
blocks: WP-S5-05
authorized_by: "team_00 (נמרוד) 2026-07-16 — «משנה את ההגדרה שלי בהתאם להמלצה - ליזי מחוייב... ולחייב לממש את כל ההשלכות»; scope ruling: new WP-S5-06, same session as WP-S5-03; transcripts EXCLUDED"
---

# ADDENDUM — §3.2 ruling REVERSED: facade is MANDATORY, register as WP-S5-06

## ⚠ This supersedes §3 of the routing request

`ROUTING-REQUEST-TEAM100-S005-REGISTRATION-2026-07-16.md` §3 asked you to register the facade as
**deferred debt**. **team_00 has since reversed that ruling.** Do **not** register it as debt.

**New ruling (team_00, 2026-07-16):** the lazy-load commitment is **binding** (`ליזי מחוייב`). team_110's
measurement proved the commitment is **not actually delivered** — so the facade must be **built**, with all
implications implemented. Register it as a **new work package: WP-S5-06**.

**Scope ruling (team_00):** WP-S5-06 is its **own WP with its own LOD400 + own ACs + own team_90 mandate +
own gate** — deliberately NOT folded into WP-S5-03 (legacy/301), whose ACs and cross-engine verdict must stay
uncontaminated. team_00 will route **both S5-03 and S5-06 to the same team_110 session**.

**Transcripts: EXCLUDED** (team_00 ruling). 60 videos of transcript text is an Eyal content task, not code;
bundling it would make the WP permanently Eyal-blocked and thus block the cutover gate. Track separately if wanted.

## Requested of team_100

1. **Register `WP-S5-06`** in `_aos/roadmap.yaml`: label *"QR embed facade — click-to-load (deliver the
   lazy-load commitment)"*; `milestone_ref: S005`; `blocked_by: []`; `next_wp: WP-S5-05`;
   `assigned_builder: team_10/110`; `assigned_validator: team_90 (cross-engine, Iron Rule #1)`.
2. **Add `WP-S5-06` to `WP-S5-05`'s `blocked_by`** list (cutover gate now depends on it).
3. **Author its LOD400** to the same bar as WP-S5-01/02/03 (buildable by a fresh agent with no guesses),
   then cross-engine validate it (team_90) as you did for the S005 package. **§4 below is the evidence and
   the full implications list — it is the input to that LOD400, not a substitute for it.**

## 1. Why the ruling reversed — the measurement (not an assertion)

Evidence: `_COMMUNICATION/team_110/evidence/s5-02-facade-cwv/` — reproducible via `qr_cwv_probe.mjs`
(headless Chrome/CDP, mobile 375×812, cold cache, staging).

| page | 1st iframe vs fold | LCP | **YouTube payload on load** |
|---|---|---|---|
| `/qr/qr48/` (0 video, baseline) | — | 1372–1680 ms | **0 KB** |
| `/qr/qr2/` (1 video) | 958px vs 812px → below fold | 1104–1312 ms | **~1039–1062 KB** / 9 req |
| `/qr/qr10/` (3 videos) | 848px vs 812px → below fold | 1076–1328 ms | **~1063–1064 KB** / 9 req |

- **`loading="lazy"` does NOT defer the first embed.** It sits *below* the fold, yet ~1.06 MB of YouTube
  loads anyway — Chrome's lazy threshold (≈1250px from viewport) swallows it. The recorded justification
  *"native lazy-load already meets the CWV bar"* is **false as a mechanism** and must not survive in any artifact.
- **Lazy DOES work further down:** qr10 (3 videos) pulls the *same* 9 requests / ~1.06 MB as qr2 (1 video) —
  videos 2+ are genuinely deferred. **Cost = ~1.06 MB for the FIRST embed only, × 42 pages.**
- **Scope:** 48 QR pages / 60 embeds — 6 pages have 0 videos (untouched), 27×1, 12×2, 3×3 → **42 pages in scope**.
- **No CWV penalty measured** (LCP on the 1-video page beats the 0-video baseline; load flat). The win is
  **data-transfer + privacy**, not LCP. Audience: pages reached by scanning a QR code **printed in a book** →
  mobile, often cellular, where ~1 MB is a real cost.
- **Not measured:** TBT / main-thread. The LOD400 may want it as a secondary AC.

## 2. 🔴 THE CRITICAL IMPLICATION — the facade MUST be a render filter, NOT a reseed

**This is the single highest-risk item and must be stated normatively in the LOD400.**

`site/wp-content/mu-plugins/ea-w2-seo-schema.php` **L266** emits the QR VideoObject nodes by regexing the
**raw `post_content` DB field** — *not* the rendered output:

```php
preg_match_all( '#youtube(?:-nocookie)?\.com/embed/([A-Za-z0-9_-]{6,})#', (string) $qr_obj->post_content, $qr_m )
```

The 46 iframes live in the **seed data** (`ea-w2-07-qr-content-data.php`) → seeded into DB `post_content`.

- ✅ **Facade as a `the_content` RENDER FILTER** → `post_content` untouched → regex still matches →
  **VideoObject nodes survive**.
- ❌ **Facade via seed-data change + reseed** (the obvious route — it is exactly how §3.1 was just done) →
  the literal `youtube-nocookie.com/embed/<id>` leaves `post_content` → `preg_match_all` returns 0 →
  **every VideoObject node silently disappears from all 42 QR pages**, destroying the WP-S5-02 build that
  just earned a clean team_90 cross-engine PASS. A silent SEO regression with no error.

**Mandate: implement as a `the_content` filter. Explicitly forbid the reseed route in the LOD400.**

## 3. Remaining implications to fold into the LOD400

1. **Filter priority.** Existing `the_content` filters: `ea_strip_legacy_blog_shortcodes_content` @1,
   `ea_wave2_suppress_legacy_editorial_content` @8, `ea_w2_08_inject_content` @9, `ea_w2_07_inject_press` @9,
   `ea_m2_contact_fluent_the_content_fix` @12. The facade must run **after** content injection (suggest ≥20)
   and must not fight the Wave2 suppressor. Scope the filter to QR pages only (hub + `/qr/qrN/` children) —
   mirror the gating already used at `ea-w2-seo-schema.php` L239-246 / `seo-head-fallbacks.php` L67-84.
2. **Preserve `youtube-nocookie`.** Click-to-load must instantiate the **nocookie** domain (privacy is half the
   point). Do not regress to `youtube.com`.
3. **Thumbnail decision.** `i.ytimg.com/vi/<id>/hqdefault.jpg` is still third-party (~10–30 KB vs ~1 MB ≈ **97%
   win**). Either accept it for v1, or localize 60 thumbnails for full privacy. **Recommend: accept for v1**,
   localization as a later enhancement — but the LOD400 must *decide*, not leave it open.
4. **Accessibility — do not regress.** The site holds Lighthouse a11y **100** (Wave2, axe 0 violations). The
   facade's play control needs a real accessible name, keyboard operability, and focus management on activation.
5. **RTL.** Hebrew site — the facade overlay/button must be correct in RTL.
6. **`prefers-reduced-motion`** — Wave2 precedent (entrance animations were made transform-only for this).
7. **Reseed drop-in cleanup.** `ea-w2-07b-qr-reseed-once.php` is a self-guarded no-op. With the filter route,
   no reseed is needed → it can be removed. Fold that decision in.
8. **Keep `loading="lazy"`** on the real iframe once swapped in (belt and braces for embeds 2+).

## 4. Acceptance criteria (measurable — the tooling already exists)

The probe from §1 is the AC harness; reuse it rather than inventing one:
`_COMMUNICATION/team_110/evidence/s5-02-facade-cwv/qr_cwv_probe.mjs`

- **AC-1 (the point):** YouTube payload on load → **~0 KB / 0 requests** on `/qr/qr2/` and `/qr/qr10/`
  (from ~1.06 MB). Baseline `/qr/qr48/` stays 0 KB.
- **AC-2 (the regression guard — non-negotiable):** VideoObject node counts **unchanged**: `/qr/qr2/`=1,
  `/qr/qr10/`=3 (unique ids), `/qr/qr1/`=0, `/qr/qr48/`=0; Article nodes and meta-descriptions unchanged.
  This is what proves the §2 collision was avoided.
- **AC-3:** clicking the facade loads the real player from `youtube-nocookie.com` and it plays.
- **AC-4:** no LCP regression vs the numbers in §1; a11y (axe 0 violations) and RTL hold.
- **AC-5:** `php -l` clean; scoped to QR routes only — zero effect on any non-QR page.

## 5. Validation

team_90 cross-engine (Iron Rule #1 — builder Claude ≠ validator composer-2.5). Mirror
`_COMMUNICATION/team_90/MANDATE-TEAM90-WP-S5-0{1,2}-*.md`, **including their Guardrails section** — it
demonstrably prevented false-positive FAILs (staging expired TLS `curl -k`, host-conditional `noindex`,
transient `curl-000` = transport timeout not a redirect → probe low-concurrency).

Runner: `bash scripts/run_cross_engine_validation.sh team_90 . <mandate>` (`--dry-run` first). Requires team_00
to authorize `cursor-agent -p --force --trust` **with that literal phrasing** — generic approval is rejected.
