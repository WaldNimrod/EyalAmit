---
id: MANDATE-TEAM90-WP-S5-06-BUILD-2026-07-16
from_team: team_00
authored_by: team_110 (under ADR045 execution_authority: full)
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-06
milestone: S005
gate: L-GATE_BUILD
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-06-LOD400-2026-07-16.md
target_execution: _COMMUNICATION/team_110/VERDICT-WP-S5-06-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-06/
staging_base: http://eyalamit-co-il-2026.s887.upress.link
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S5-06-BUILD-2026-07-16.md
---

# MANDATE — team_90 cross-engine validation: WP-S5-06 (QR embed facade, L-GATE_BUILD)

You are the **cross-engine validator** (`composer-2.5`, non-Claude). WP-S5-06 delivers the click-to-load facade
that makes real the commitment `loading="lazy"` never kept: 42 QR pages were pulling **~1.06 MB** of YouTube
player on load, before the reader asked to watch. The audience scans a QR **printed in Eyal's book** — usually on
mobile data. The builder (team_110, `claude-opus-4-8`) reports 6/6 ACs met on staging.

Iron Rule #1 requires an independent non-Claude engine to **reproduce the ACs** before this can feed the
WP-S5-05 cutover gate. **Independently reproduce each AC from the modified code + live staging + the evidence —
do not merely re-read the builder's report.**

## Sources of truth

| What | Path |
|---|---|
| Spec (ratified, cycle-2 clean PASS) | `_COMMUNICATION/team_100/S005/WP-S5-06-LOD400-2026-07-16.md` |
| Builder's result + findings | `_COMMUNICATION/team_110/VERDICT-WP-S5-06-BUILD-2026-07-16.md` |
| Evidence root | `_COMMUNICATION/team_110/evidence/s5-06/` |
| Authority (facade mandatory) | `_COMMUNICATION/team_110/ADDENDUM-TEAM100-WP-S5-06-FACADE-MANDATORY-2026-07-16.md` |
| Live staging | `http://eyalamit-co-il-2026.s887.upress.link` |

## Acceptance criterion (the bar the builder claims to meet)

LOD400 §6 AC-1, AC-1b, AC-2, AC-3, AC-4, AC-5 all PASS on live staging with evidence.
**AC-2 FAIL ⇒ STOP** (it would mean the forbidden reseed route was taken).

## Checks — reproduce each, cite concrete evidence (URL + code location + observed value)

1. **AC-2 — the regression guard. Do this FIRST.** Parse the live JSON-LD on `/qr/qr1/`, `/qr/qr2/`, `/qr/qr10/`,
   `/qr/qr48/`. `VideoObject` count MUST be **qr1=0, qr2=1, qr10=3, qr48=0**; `Article` present on all 4;
   `<meta name="description">` non-empty and identical to the `*_BEFORE.html` captures. Confirm from the code
   that `post_content` was **not** modified: the build adds a `the_content` filter only, and
   `mu-plugins/ea-w2-seo-schema.php:266` still regexes the raw column. Confirm the seed file
   `ea-w2-07-qr-content-data.php`, both QR seeders, and the DB are untouched (`git diff`).
2. **AC-1** — with `scripts/qa/qr_facade_probe.mjs`, confirm player `0 req` **and** `0 bytes` on `/qr/qr2/` and
   `/qr/qr10/`, down from the §1 baseline (~8-9 req / ~1.05 MB). Baseline `/qr/qr48/` stays 0. **Read check 7
   before running the probe.**
3. **AC-1b** — `thumbReq ≤ videoCount` and `thumbBytes ≤ 20480 × videoCount` (qr2 ≤1/20 KB; qr10 ≤3/60 KB).
4. **AC-3** — clicking `.ea-qr-facade` loads the player: `playerReq > 0`, host `www.youtube-nocookie.com`
   observed, an iframe replaces the button. **Zero** requests to bare `youtube.com` on any route (§5.2 — a
   regression to `youtube.com` is a FAIL even if the player works).
5. **AC-4** — `facades == videoCount` (qr2=1, qr10=3, qr1=0, qr48=0). LCP: no regression beyond **+20%** vs §1
   (band is wide **deliberately**; §1 records LCP as noisy — do not FAIL on LCP alone; re-run first).
   a11y: `node scripts/qa/http-qa-axe.cjs /qr/qr2/ /qr/qr10/` — **see F-01 below before judging.**
   RTL: `qa_probe.mjs` PASS mobile+desktop, 0 horizontal overflow.
6. **AC-5** — `php -l` clean on `chapters-qr-facade.php` + `chapters-bootstrap.php`. Scoping: **0** occurrences of
   `ea-qr-facade` and **0** loads of `ea-qr-facade.js` on `/`, `/method/`, `/faq/`, `/repair/`, `/blog/`,
   `/contact/`; present on `/qr/qr2/`. `Version: 1.5.7` in `style.css` and live as `?ver=1.5.7` on **both**
   `chapters.css` and `ea-qr-facade.js`.
7. **Completeness of the filter regex** — run the §4.A regex against the seed file: it must match **60/60**
   iframes (**not 46** — the spec's §8 correction #1), yielding 60 unique ids, and must **not** touch the single
   `ea-qr-embed--link` Facebook anchor at `ea-w2-07-qr-content-data.php:584`.

## 🔴 Adjudicate the two builder-raised findings

The builder raised these itself. Judge them independently — confirm, reject, or re-severity them.

- **F-01 — AC-4's axe threshold is unsatisfiable as written.** The pre-facade baseline is already non-zero:
  `/qr/qr2/` serious=2 (`color-contrast`, `link-name`), `/qr/qr10/` serious=1 (`color-contrast`) → axe exit 1.
  Both rules are pre-existing and outside §4's contract (`link-name` is an empty `<a>` to a book page; the
  facade creates no anchors). The builder executed AC-4's **stated intent** — «אפס נסיגה» / zero regression:
  no new or worsened violations, verified per rule id and node count. Both raw reports are in
  `evidence/s5-06/a11y-rtl/`. **Verify both readings yourself and rule.**
- **F-02 — the AC harness can be silently blind.** Chrome **site isolation** puts the cross-origin YouTube
  embed out-of-process (OOPIF); the page target's CDP `Network` domain then sees none of its traffic, so a full
  Chrome measures the player as **0 requests whether or not the facade works** — a false PASS on AC-1. Verified
  live: `chrome-headless-shell` → 8 req / 1050 KB; full Google Chrome → 1 req / 0 KB. The harness now prefers
  `chrome-headless-shell` and forces `--disable-features=IsolateOrigins,site-per-process`.
  **Confirm the mitigation holds, and satisfy yourself that your own AC-1 measurement is not blind** — the
  simplest proof is that your AC-3 click DOES register player requests on the same instrument.

## Guardrails — DO NOT flag these as defects (environment / ratified; documented in the spec + builder report)

- **Expired TLS on staging** — invalid **by design** on the uPress dev host; `curl -k` /
  `--ignore-certificate-errors` is the correct dev-only bypass. **Not a finding.**
- **Site-wide `x-robots-tag: noindex`** — host-conditional staging plugin `ea-staging-noindex.php` (keys on
  `upress.link`), not route-specific editorial noindex; absent on production. **Not a finding.**
- **Transient `curl 000` — and `503`.** Under concurrent probing the shared uPress host throttles. Measured this
  session: 4 QR routes returned `503` in a batch and **all 4 returned `200` re-probed serially**. This is a
  transport/throttle artifact, **never** a redirect and never a defect. **Probe sequentially before marking any
  route FAIL.**
- **`ea-w2-07b-qr-reseed-once.php` still present** — **ratified in spec §5.3: leave it.** It is a flag-locked
  no-op; deleting it would touch the seed path that AC-2 exists to protect. **Not debt, not a finding here.**
- **VideoObject `uploadDate` omitted** — ratified in WP-S5-02 spec §2.2. Not this WP's scope.
- **Transcripts absent / no transcript placeholder** — **excluded by explicit team_00 instruction** (§5.5);
  bundling them would make the WP permanently Eyal-blocked. **Not a gap.**
- **Poster localisation not done (60 posters served from `i.ytimg.com`)** — ratified §5.1 for v1, with measured
  justification (`maxresdefault` 404s in 3/4; 0 `Set-Cookie` on the thumb CDN). Recorded as a possible
  post-cutover improvement, **not blocking debt**.
- **`/qr/` prod 302** — WP-S5-05 scope, out of scope here.
- **Pre-existing `validate_aos.sh` Check-32 drift** — team_00/team_100 scope, unrelated to this WP.
- ⚠ **Do NOT carry forward the WP-S5-02 guardrail «native lazy-load already meets the CWV bar».** It is
  **SUPERSEDED** (roadmap L2402-2426: *"factually wrong as a mechanism"*). This WP exists precisely because it
  was wrong. The measured proof: the iframe sits **below** the fold and ~1.06 MB loaded anyway.

## Required output

Write `_COMMUNICATION/team_90/VERDICT-WP-S5-06-BUILD-2026-07-16.md`:
- Frontmatter mirroring the S5-01/02 verdicts (incl. `mandate_ref`, `validator_engine`, `iron_rule_1`,
  `builder_verdict_ref`, `evidence_root_builder`).
- `## Verdict flag` — one of `PASS` / `PASS_WITH_FINDINGS` / `FAIL`.
- `## Iron Rule #1` — role/engine/team table incl. "Distinct vendors | satisfied".
- `## Per-item results` — one row per check above, each citing URL + HTTP code + code `file:line` + the value
  you observed (not the value you were told).
- `## F-01 / F-02 adjudication` — your independent ruling on each.
- `## route_recommendation` — explicit. If PASS, say `L-GATE_BUILD PASS`.

**Do not** open WP-S5-05. **Do not** re-open the facade-vs-lazy decision (team_00 ruled; §3.2 reversal is final).
