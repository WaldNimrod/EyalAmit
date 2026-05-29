Engine: native Codex/GPT-5 (OpenAI Codex), not Claude builder (team_10) and not team_50 QA (cursor-composer).

# VERDICT — WP-W2-07 L-GATE_VALIDATE

date: 2026-05-29
timezone: Asia/Jerusalem
validator: team_190 (constitutional Final Validator, IR#5)
worktree: `/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-07`
branch: `feature/w2-07-heritage`
comms_HEAD: `ff4f7da`
build_commit (validated): **`c7dc34a`**
mandate: `_COMMUNICATION/team_190/MANDATE-TEAM190-W2-07-L-GATE-VALIDATE-2026-05-29.md`
L-GATE_BUILD trigger: `_COMMUNICATION/team_50/VERDICT-W2-07-L-GATE-BUILD-2026-05-29.md` — PASS_WITH_FINDINGS, 5/5 ACs, 0 P0/P1
spec: `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md`
staging: `http://eyalamit-co-il-2026.s887.upress.link` (all HTTP checks cache-busted: `?cb=$(date +%s)$RANDOM`)

## Verdict Box

| Field | Value |
|-------|-------|
| WP | WP-W2-07 — Press + Moksha + 48 QR pages + FB Top-5 testimonials |
| Gate | L-GATE_VALIDATE |
| Verdict | **PASS** |
| Blocking findings | None |
| QR page count (SSoT re-confirm) | **48** — not a defect (49th inventory row = parent `/qr/`) |
| Non-blocking carry-forwards | 28 omitted QR images (team_40 recovery); FB avatars = grey placeholder (spec F05) |
| One-line next step | **team_100** executes WP Closure Protocol (roadmap COMPLETE / LOD500_LOCKED; team_191 archive; merge `feature/w2-07-heritage` → main on team_00 go), then re-handoff. |

## Fresh-tree Proof

| Required proof | Result |
|----------------|--------|
| `git rev-parse HEAD` | `ff4f7da0550d21b5e3e15cb8eddc81f1fc1d3bdc` — comms-doc tip after build ✓ |
| Build commit (validated) | **`c7dc34a17dbe3a1c3bdc233380fd0ee85e60a55b`** — `WP-W2-07 Heritage: 48 QR pages + /press + moksha + FB Top-5` |
| `git merge-base --is-ancestor c7dc34a HEAD` | **YES** ✓ |
| Base main | `8270d98` ✓ |
| `git diff --name-only c7dc34a..HEAD` | **3 files only** — zero theme/mu-plugin/CSS delta ✓ |
| | `_COMMUNICATION/team_190/MANDATE-TEAM190-W2-07-L-GATE-VALIDATE-2026-05-29.md` |
| | `_COMMUNICATION/team_50/MANDATE-TEAM50-W2-07-L-GATE-BUILD-2026-05-29.md` |
| | `scripts/_w2_07_image_resolution.json` |
| Tree `style.css` Version | **1.4.5** |
| Deployed `style.css` Version | **1.4.5** (cache-busted curl on staging) ✓ |
| Local `validate_aos.sh` | **30 PASS / 18 SKIP / 0 FAIL** ✓ |

Conclusion: validation run against **build state `c7dc34a`**; HEAD `ff4f7da` adds comms/evidence only — no stale-build risk.

## QR Count SSoT Re-confirm (mandate §3.1 — REQUIRED)

| Source | Count | Notes |
|--------|-------|-------|
| `QR-URL-INVENTORY.csv` distinct `qr/qrN` rows | **48** | Row 2 = parent `qr` (not a content page) |
| `ea-w2-07-qr-content-data.php` keys | **48** | `qr1`..`qr48` |
| Live staging `/qr/qr1/`..`/qr/qr48/` HTTP 200 | **48/48** | Independent loop, cache-busted |

**Re-confirm: QR page count = 48. This is NOT a defect.**

## Eight-check Validation

| Check | Scope | Result | Evidence / Notes |
|-------|-------|--------|------------------|
| C-1 | Cross-engine chain (IR#1) | **PASS** | Builder = team_10 (`claude-*`); L-GATE_BUILD = team_50 (`cursor-composer`, non-Claude) PASS_WITH_FINDINGS 5/5; this L-GATE_VALIDATE = **native Codex/GPT-5**. |
| C-2 | Fresh tree + scope-additions safe | **PASS** | Build frozen at `c7dc34a`; `ea-w2-07-qr-seed-once.php`: ABSPATH guard, option `ea_w2_07_qr_seeded_v3`, transient lock, `init@28`, KSES removed only-if-active + restored in `finally`, no `wp-load` re-require. Deploy list includes both mu-plugins (`ftp_deploy_site_wp_content.py` L68–69, L116–117). `tpl-qr` in `ea_wave2_is_active_view` (`wave2-stage-b.php` L53). `/press` via `the_content` injection in `wave2-w2-07.php`; moksha page 181 REST-updated (seeder creates parent `qr` + 48 children + root `press` only). |
| C-3 | Static hygiene | **PASS** | `php -l` clean on `wave2-w2-07.php`, `tpl-qr.php`, `ea-w2-07-qr-seed-once.php`, `ea-w2-07-qr-content-data.php`. D-14: no raw hex in `w2-07-heritage.css`. Repo grep `localhost:9090` under `site/wp-content/`: **0 matches**. |
| C-4 | AC-01 — 48 QR pages live | **PASS** | Cache-busted loop: **48/48 → HTTP 200**. Full-page localhost scan 48/48: **0 leaks**. Samples: qr2/qr12 iframe=1 (YouTube); qr21 imgs=6 (Flickr rehost); qr28 imgs=2; omitted-image pages qr1/qr48 imgs=0, text preserved. |
| C-5 | AC-02 — /about/moksha | **PASS** | HTTP 200; heading "ומה היום" present; rehosted image under `uploads/ea-legacy/moksha/`; back-link to `/about/` present. |
| C-6 | AC-03 — /press (≥5 articles, new-tab) | **PASS** | HTTP 200; **26** `ea-press` external links; **26/26** `target="_blank"` + `rel` contains `noopener`. |
| C-7 | AC-04 — FB Top-5 testimonials | **PASS** | On `/press/`: `ea-fb-testimonials` block; **5** `<details class="ea-testimonial-acc">` cards (שרון לוסקי, לירן קלינה, רוית יונה בניהו, הילה יניב, רתם פרץ); text + **5× grey placeholder avatar** + FB footer links `target="_blank"`. |
| C-8 | AC-05 — validate_aos + shell/version | **PASS** | `validate_aos.sh` → **0 FAIL**. Deployed `style.css` **1.4.5**. Press + testimonial external links new-tab verified (C-6/C-7). |

## AC-01..AC-05 Live Re-verify

| AC | Description | Verdict | Independent evidence (team_190, 2026-05-29) |
|----|-------------|---------|---------------------------------------------|
| AC-01 | 48 QR URLs active; 0 localhost leak; body migrated | **PASS** | 48/48 HTTP 200 vs inventory CSV (48 `qrN` rows); 0 `localhost:9090` in any QR HTML; content keys 48 in seed data; YouTube iframes + 12 rehosted images render on samples. |
| AC-02 | Moksha content + image + link to about | **PASS** | `/about/moksha/` 200; "ומה היום", `ea-legacy/moksha` image, `/about/` back-link. |
| AC-03 | `/press` ≥5 (26) articles, external new-tab | **PASS** | 26 press article links; 26/26 new-tab + noopener. |
| AC-04 | FB Top-5 text + image/placeholder + link | **PASS** | 5 accordion cards with text, grey placeholder avatars, FB links new-tab. |
| AC-05 | External links new-tab; validate_aos 0 FAIL; D-14 only | **PASS** | Press 26/26 + testimonial FB links new-tab; validate_aos 0 FAIL; no raw hex in W2-07 CSS. |

## Live Evidence Summary

```text
Cache-bust: independent per request (?cb=timestamp+random)
AC-01 QR loop: NON200_COUNT=0 / 48; LOCALHOST_LEAK_COUNT=0 / 48
AC-01 samples: qr1(200,0img) qr2(200,iframe) qr12(200,iframe) qr21(200,6img) qr28(200,2img) qr48(200,0img)
Deployed style.css Version: 1.4.5
```

```text
/about/moksha/?cb=…
HTTP 200 | heading "ומה היום": yes | ea-legacy/moksha: yes | back-link /about/: yes
```

```text
/press/?cb=…
HTTP 200 | ea-press links: 26 | target="_blank": 26/26 | noopener: 26/26
FB Top-5: 5 testimonial accordions | 5 placeholders | names verified
```

```text
validate_aos.sh (local tree):
RESULT: 30 PASS / 18 SKIP / 0 FAIL
```

## Findings

| ID | Severity | Status | Finding | evidence-by-path | route_recommendation |
|----|----------|--------|---------|------------------|----------------------|
| T190-W2-07-CF-001 | P3 / NON-BLOCKING | CARRY_FORWARD | 28 distinct QR images omitted — legacy localhost:9090 source permanently offline; `<img>` gracefully removed, text intact, no broken URLs live. | `scripts/_w2_07_image_resolution.json`; mandate §4; live qr1/qr2/qr12 samples imgs=0, localhost=0 | Carry to team_40 image recovery; do not block W2-07 closure. |
| T190-W2-07-CF-002 | P3 / NON-BLOCKING | CARRY_FORWARD | FB testimonial avatars render as grey placeholders (spec F05 best-effort). | live `/press/` — 5× `ea-testimonial-card__avatar-placeholder`; `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md` F05 | Accept per spec; Eyal may supply photos later. |
| T190-W2-07-INFO-003 | INFO | CONFIRMED | QR count = **48** (corrected from 49). Inventory parent row `/qr/` is not a content page. | `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` (48 qrN rows + 1 parent); LOD400_spec correction note | **Not a defect.** No action required. |

## Final Routing

WP-W2-07 **passes L-GATE_VALIDATE**. There are no blocking P0/P1/P2 defects. Known P3 carry-forwards are accepted as non-blocking per mandate §4.

**team_100** may execute WP Closure Protocol: roadmap COMPLETE / LOD500_LOCKED (re-probe API first; PRECONDITION#1 disposition-A interim if needed), **team_191** archive, merge `feature/w2-07-heritage` → `main` on **team_00** go, then re-handoff to next WP.

*team_190 — constitutional validator — 2026-05-29*
