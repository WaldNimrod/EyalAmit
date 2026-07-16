---
id: VERDICT-WP-S5-06-BUILD-2026-07-16
from_team: team_90
to_team: team_110
cc: [team_00, team_100]
date: 2026-07-16
type: cross-engine-validation-result
wp: WP-S5-06
milestone: S005
gate: L-GATE_BUILD
mandate_ref: MANDATE-TEAM90-WP-S5-06-BUILD-2026-07-16
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-06-LOD400-2026-07-16.md
builder_verdict_ref: _COMMUNICATION/team_110/VERDICT-WP-S5-06-BUILD-2026-07-16.md
evidence_root_builder: _COMMUNICATION/team_110/evidence/s5-06/
evidence_root_validator: tmp/team90_s5_06_*.py + tmp/team90_s5_06_probe.out + scripts/qa/reports/axe-http-2026-07-16.json
staging_base: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-S5-06 BUILD (team_90 cross-engine validation)

## Verdict flag

**`PASS_WITH_FINDINGS`**

All 6 ACs independently reproduced **PASS** on live staging (serial probes, 2026-07-16) plus repo code inspection. **AC-2 regression guard holds** — VideoObject schema intact; no seed/reseed/DB path taken. **0 blockers · 0 major · 2 minor** (F-01, F-02 — spec/tooling findings, not build defects). Builder self-verdict confirmed on substance; Iron Rule #1 satisfied.

---

## Iron Rule #1

| Role | Engine | Team |
|------|--------|------|
| Builder | claude-opus-4-8 (Claude Code, Anthropic) | team_110 |
| Independent validator | composer-2.5 (Cursor) | team_90 |
| Distinct vendors | **satisfied** | |

---

## Per-item results

| # | Check | Result | Evidence reproduced (URL + HTTP + code + observed value) |
|---|-------|--------|----------------------------------------------------------|
| **1 — AC-2** (FIRST — regression guard) | **PASS** | **Live JSON-LD** (`curl -sk`, serial, 2026-07-16): **`/qr/qr1/`** HTTP **200** — `VideoObject=0`, `Article=1`, `<meta name="description">` non-empty and **byte-identical** to `schema-regression/qr1_BEFORE.html`. **`/qr/qr2/`** HTTP **200** — `VideoObject=1`, `Article=1`, meta identical to `qr2_BEFORE.html`. **`/qr/qr10/`** HTTP **200** — `VideoObject=3`, `Article=1`, meta identical to `qr10_BEFORE.html`. **`/qr/qr48/`** HTTP **200** — `VideoObject=0`, `Article=1`, meta identical to `qr48_BEFORE.html`. **Code — render-filter only:** `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-qr-facade.php:88` — `add_filter( 'the_content', …, 20 )`; no `post_content` mutation. **Schema still regexes raw column:** `site/wp-content/mu-plugins/ea-w2-seo-schema.php:266` — `preg_match_all( …, (string) $qr_obj->post_content, … )`. **Seed/seeders untouched:** `git diff` empty on `ea-w2-07-qr-content-data.php`, `ea-w2-07-qr-seed-once.php`, `ea-w2-07b-qr-reseed-once.php`. Bootstrap wires module only: `chapters-bootstrap.php:19`. |
| **2 — AC-1** | **PASS** | `node scripts/qa/qr_facade_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link` → exit **0**. Chrome binary: `chrome-headless-shell` (not full Chrome). **`/qr/qr2/`** — player on load **0 req / 0.0 KB** (was ~8–9 req / ~1050 KB per §1). **`/qr/qr10/`** — player on load **0 req / 0.0 KB**. **`/qr/qr48/`** baseline — **0 req / 0.0 KB**. Harness: `scripts/qa/qr_facade_probe.mjs:47–62` (`findChrome()` prefers headless-shell). |
| **3 — AC-1b** | **PASS** | Same probe run: **`/qr/qr2/`** (1 video) — `thumbReq=1`, `thumbBytes=9612` (9.4 KB) ≤ budget **1 req / 20 KB**. **`/qr/qr10/`** (3 videos) — `thumbReq=1`, `thumbBytes=13696` (13.4 KB) ≤ budget **3 req / 60 KB**. Host: `i.ytimg.com` only. |
| **4 — AC-3** | **PASS** | Probe click phase on **`/qr/qr2/`**: `playerReq=14`, `playerBytes=2563007` (~2503 KB), hosts `www.youtube-nocookie.com` + `googlevideo.com`, `nocookieIframes=1`, `facadesLeft=0`, `iframes=1`. **`/qr/qr10/`**: `playerReq=14`, `playerBytes=1611338`, `nocookieIframes=1`, `facadesLeft=2` (only clicked facade loads). **`bare youtube.com` requests: 0** on all routes (`onLoad.bare.req=0`, `afterClick` hosts exclude bare `youtube.com`). JS: `site/wp-content/themes/ea-eyalamit/assets/js/ea-qr-facade.js` — nocookie embed URL preserved. |
| **5 — AC-4** | **PASS** | **Facade counts:** qr2=1, qr10=3, qr1=0, qr48=0 (`facades == videos` on all 4). **LCP** (probe, mobile 375×812): qr2 **968 ms** vs §1 baseline 1108 ms (−12.6%); qr10 **1540 ms** vs 1532 ms (+0.5%); qr48 **1396 ms** vs 1688 ms (−17.3%) — all within **+20%** band; no LCP-only FAIL. **RTL:** `_aos/lean-kit/.../qa_probe.mjs` on `/qr/qr2/`, `/qr/qr10/` → **PASS**, `overflow: false` mobile+desktop (4/4). **a11y:** see F-01 — literal axe `exit 1`, but **zero regression** vs builder BEFORE baseline (rule ids + node counts unchanged). |
| **6 — AC-5** | **PASS** | `php -l` clean: `chapters-qr-facade.php`, `chapters-bootstrap.php`. **Scoping** (live HTML, HTTP 200 unless noted): `/`, `/method/`, `/faq/`, `/repair/`, `/contact/` — **0** `ea-qr-facade`, **0** `ea-qr-facade.js`. `/blog/` — transient `curl 000` on first fetch; **re-probe serial → HTTP 200**, `ea-qr-facade=0` (per guardrail). **`/qr/qr2/`** — `ea-qr-facade` present (5 occurrences incl. classes), `ea-qr-facade.js` loaded. **Version:** `style.css` L7 `Version: 1.5.7`; live **`chapters.css?ver=1.5.7`** and **`ea-qr-facade.js?ver=1.5.7`** on `/qr/qr2/`. |
| **7 — Regex completeness** | **PASS** | PHP seed regex from §4.A run against `site/wp-content/mu-plugins/ea-w2-07-qr-content-data.php`: **60/60** iframe matches, **60** unique video ids. `ea-qr-embed--link` at **L584** — **not** matched by regex. Facade regex in code: `chapters-qr-facade.php:59–60`. |

---

## F-01 / F-02 adjudication

### F-01 — AC-4 axe threshold unsatisfiable as written

**Ruling: CONFIRM (minor — spec/tooling, not a build defect).**

Independent reproduction:

```
node scripts/qa/http-qa-axe.cjs /qr/qr2/ /qr/qr10/  →  exit 1
/qr/qr2/   HTTP 200  crit=0 serious=2  color-contrast(1), link-name(1)
/qr/qr10/  HTTP 200  crit=0 serious=1  color-contrast(1)
```

Compared to builder BEFORE capture (`evidence/s5-06/a11y-rtl/axe-BEFORE.json`) and AFTER (`axe-AFTER.json`): **identical** — same rules, same node counts, **0 new, 0 worsened**. The facade replaces `<iframe>` with `<button>` and does not introduce anchors; `link-name` is a pre-existing empty book link on qr2; `color-contrast` is a pre-existing theme token issue.

**AC-4 a11y on stated intent («אפס נסיגה»): PASS.** Literal LOD400 §6 wording (`exit 0` before and after) remains unsatisfiable on this staging baseline. **Disposition:** team_100 to amend AC-4 threshold to "no new/worsened violations vs recorded baseline"; pre-existing serious violations → separate hygiene WP (not S5-06-blocking, not S5-05-blocking).

### F-02 — AC harness site-isolation blindness

**Ruling: CONFIRM (minor — mitigated in harness; not a false PASS).**

Independent reproduction:

- Probe selected **`chrome-headless-shell`** (`scripts/qa/qr_facade_probe.mjs` L47–54), not full Chrome — matches ratified §1 measurement path.
- **`--disable-features=IsolateOrigins,site-per-process`** documented in harness L38–40.
- **Instrument not blind:** AC-3 click on same run registers **`playerReq=14`** to `www.youtube-nocookie.com` — a blind instrument would report `playerReq=0` after click and FAIL AC-3.
- AC-1 on-load **0/0** is therefore credible, not a site-isolation false PASS.

**Disposition:** keep harness as-is; validators must not override with `EA_CHROME` pointing at full Chrome (mandate guardrail restated).

---

## Validator notes (non-blocking)

- **Staging TLS expired** — dev-only `curl -k` / `--ignore-certificate-errors`; not a finding.
- **Site-wide `x-robots-tag: noindex`** — host-conditional staging plugin; not route-specific; not a finding.
- **Transient transport:** `/blog/` returned `curl 000` once; **200** on serial re-probe. All AC routes probed **serially** per mandate.
- **`ea-w2-07b-qr-reseed-once.php` present** — ratified §5.3; not debt here.
- **Poster CDN (`i.ytimg.com`)** — ratified §5.1 v1; not blocking.
- **External Rich Results validator** — not run on staging (cert + noindex); structural AC-2 validated via live JSON-LD parse.

---

## route_recommendation

**`L-GATE_BUILD PASS`**

WP-S5-06 facade build is validated on staging. All ACs met; AC-2 regression guard holds (forbidden reseed route not taken). F-01 and F-02 are confirmed minor spec/tooling findings — neither blocks gate progression. **No route back to team_110 for remediation.** WP-S5-05 remains out of scope for this verdict.
