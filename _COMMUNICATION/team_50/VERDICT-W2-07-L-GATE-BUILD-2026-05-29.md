---
verdict: PASS_WITH_FINDINGS
wp: WP-W2-07
date: 2026-05-29
head_verified: c7dc34a
validator_engine: cursor-composer
branch: feature/w2-07-heritage
tip_commit: ff4f7da
staging: http://eyalamit-co-il-2026.s887.upress.link
mandate: _COMMUNICATION/team_50/MANDATE-TEAM50-W2-07-L-GATE-BUILD-2026-05-29.md
spec_ref: _aos/work_packages/S002/WP-W2-07/LOD400_spec.md
status: ISSUED
criteria_total: 5
criteria_pass: 5
criteria_fail: 0
findings_blocker: 0
findings_major: 0
findings_minor: 2
---

# L-GATE_BUILD Verdict — WP-W2-07 Heritage

## Result

**PASS_WITH_FINDINGS** — all five acceptance criteria pass; no P0/P1 blockers.

| Field | Value |
|-------|-------|
| WP | WP-W2-07 — Press + Moksha + 48 QR pages + FB Top-5 testimonials |
| Gate | L-GATE_BUILD |
| Verdict | **PASS_WITH_FINDINGS** |
| ACs passed | **5 of 5** |
| Blocking AC | none |
| One-line next step | Notify **team_100** + **team_00** → route **team_190 (Codex) L-GATE_VALIDATE** |

---

## Proof-of-HEAD

| Check | Result |
|-------|--------|
| Branch | `feature/w2-07-heritage` |
| Tip commit | `ff4f7da` — docs: L-GATE mandates + image-resolution evidence |
| **Build commit (verified)** | **`c7dc34a`** — `WP-W2-07 Heritage: 48 QR pages + /press + moksha + FB Top-5` |
| Ancestry | `c7dc34a` is ancestor of HEAD ✓ |
| Working tree | clean at QA time |
| Tree `style.css` Version | **1.4.5** |
| Deployed `style.css` Version | **1.4.5** (cache-busted curl on staging) ✓ |

All HTTP checks used cache-bust: `?cb=$(date +%s)$RANDOM`.

---

## Engine Declaration (Iron Rule #1)

| Field | Value |
|-------|-------|
| Builder | claude-sonnet (team_10) |
| Validator | **cursor-composer** (non-Claude) ✓ |
| Attestation | This verdict is issued by Cursor Composer, not a Claude engine. |

---

## §3A Static Code Checks

| Check | Method | Result |
|-------|--------|--------|
| PHP syntax (4 files) | `php -l` on `wave2-w2-07.php`, `tpl-qr.php`, `ea-w2-07-qr-seed-once.php`, `ea-w2-07-qr-content-data.php` | **PASS** — no syntax errors |
| D-14 CSS (no raw hex) | `grep -nE "#[0-9a-fA-F]{3,6}" w2-07-heritage.css` | **PASS** — empty (no matches) |
| Version bump | `grep ^Version: style.css` | **PASS** — `1.4.5` |
| localhost leak (repo) | `grep -r "localhost:9090" site/wp-content/` | **PASS** — 0 matches |
| `require_once` router | `grep wave2-w2-07 functions.php` | **PASS** — single line L802 |
| `tpl-qr` in active views | `grep tpl-qr wave2-stage-b.php` | **PASS** — L53 |
| QR content keys | Python parse `ea-w2-07-qr-content-data.php` | **PASS** — 48 unique keys `qr1`..`qr48` |
| Press data count | `w2-07-press.json` | **PASS** — 26 items |
| `validate_aos.sh` | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` | **PASS** — 30 PASS / 18 SKIP / **0 FAIL** |

---

## §3A Scope-Additions Review

| Item | Evidence | Result |
|------|----------|--------|
| **3A.1** Two mu-plugins + deploy | `ea-w2-07-qr-seed-once.php` L14 `ABSPATH`; L92–93 option `ea_w2_07_qr_seeded_v3`; L101–104 transient lock; L155 `init@28`; no `wp-load` re-require. Deploy: `ftp_deploy_site_wp_content.py` L68–69, L94–97, L116–117 | **PASS** |
| **3A.2** KSES handling 1:1 | L110–113 conditional `kses_remove_filters()`; L147–150 `finally` restores via `kses_init_filters()` when active + deletes transient; early returns inside `try` still hit `finally` | **PASS** |
| **3A.3** Moksha page 181 (no duplicate) | Seeder creates only `qr` parent + 48 children + root `press` (0 refs to `moksha` in seeder). Staging `/about/moksha/` → 200; heading "ומה היום", rehosted image under `uploads/ea-legacy/moksha/`, back-link to `/about/` | **PASS** |
| **3A.4** 28 omitted QR images | `scripts/_w2_07_image_resolution.json`: 41 refs → 12 rehosted, 29 omitted refs = **28 distinct paths**. Sample rehosted: qr14/qr21/qr28 imgs HTTP 200; omitted pages qr1/qr2/qr12: 0 `<img>` tags, 0 localhost leak, text preserved | **PASS** (carry-forward noted — see F-W2-07-01) |

---

## §3B Staging HTTP Checks

### AC-01 — 48 QR pages

```bash
BASE="http://eyalamit-co-il-2026.s887.upress.link"
for n in $(seq 1 48); do
  CB=$(date +%s)$RANDOM
  printf "qr%s %s\n" "$n" "$(curl -s -o /dev/null -w '%{http_code}' -L "$BASE/qr/qr$n/?cb=$CB")"
done
```

**Output (team_50, 2026-05-29):** 48/48 → **200** (first full loop: non-200 count = 0).

```bash
curl -s -L "$BASE/qr/qr1/?cb=…" | grep -c "localhost:9090"   # → 0
```

**Spot checks:**

| Page | HTTP | iframe | rehosted imgs | localhost |
|------|------|--------|---------------|-----------|
| qr2 | 200 | 1 | 0 (images omitted) | 0 |
| qr12 | 200 | 1 | 0 (images omitted) | 0 |
| qr21 | 200 | 0 | 6 (Flickr rehost) | 0 |
| qr14 | 200 | — | 1 (mongabay) | 0 |
| qr28 | 200 | — | 1 | 0 |

Rehosted asset sample: `/wp-content/uploads/ea-legacy/qr/mongabay_braz_defor_88-05.jpg` → **200**.

### AC-02 — /about/moksha

```
moksha HTTP code: 200
heading "ומה היום": present
rehosted image (uploads/ea-legacy/moksha): present
back-link to /about/: present
ea-wave2-shell: 1
```

### AC-03 — /press (26 articles, external new-tab)

```
/press HTTP code: 200
ea-press__link count: 26
target="_blank": 26/26
rel="noopener noreferrer": 26/26
ea-wave2-shell: 1
```

### AC-04 — FB Top-5 testimonials on /press

```
ea-testimonial-acc elements: 5
ea-testimonial-acc__name: 5 (שרון לוסקי, לירן קלינה, רוית יונה בניהו, הילה יניב, רתם פרץ)
ea-testimonial-card__text blocks: 5
ea-testimonial-card__avatar-placeholder: 5 (grey placeholders — spec F05)
facebook.com links with target="_blank": 5/5 testimonial footer links
```

### AC-05 — external new-tab + validate_aos

Press links: 26/26 new-tab + noopener (see AC-03). Testimonial FB links: 5/5 new-tab. `validate_aos.sh`: **0 FAIL** (see §5).

---

## AC Results

| AC | Description | Verdict | Evidence |
|----|-------------|---------|----------|
| AC-01 | 48 QR `/qr/qrN/` → 200; 0 localhost leak | **PASS** | §3B loop 48/48; grep localhost=0; inventory CSV 48 qrN rows |
| AC-02 | /about/moksha content + image + link to /about | **PASS** | §3B moksha checks; page 181 updated via REST (not recreated) |
| AC-03 | /press ≥5 (26) articles, external new-tab | **PASS** | 26/26 links; all `target="_blank" rel="noopener noreferrer"` |
| AC-04 | FB Top-5 testimonials text + image/placeholder + link | **PASS** | 5 accordion cards; text + placeholder avatar + FB link new-tab |
| AC-05 | external new-tab + `validate_aos.sh` 0 FAIL | **PASS** | §3B + §5 |

---

## Findings

### F-W2-07-01 — **P3** — 28 distinct QR images omitted (carry-forward)

**Source:** `scripts/_w2_07_image_resolution.json` — 29 omitted refs across 28 distinct legacy paths; source absent locally (localhost:9090 offline permanently).

**Live behaviour:** Omitted `<img>` tags stripped from seeded content; surrounding text preserved; **no broken image URLs** and **no localhost leak** on staging.

**Not blocking** — mandate §4 note (b): carry-forward to team_40 image recovery.

---

### F-W2-07-02 — **P3** — FB testimonial avatars = grey placeholder (F05)

**Evidence:** `/press/` renders 5× `ea-testimonial-card__avatar-placeholder`; no rehosted profile photos.

**Not blocking** — spec F05/F04 acceptable; FB fetch best-effort fallback.

---

### F-W2-07-03 — **Advisory** — QR count 49→48 correction

**Note:** Inventory has 48 content pages (`qr1`..`qr48`) + parent `/qr/` row. Spec correction documented; **team_190 re-confirm** at L-GATE_VALIDATE — not a defect.

**Not blocking.**

---

## §5 validate_aos.sh

```
validate_aos.sh — running up to 47 checks on ./_aos (active_modules: filter, context: spoke)
=================================================
[PASS] Check 1: YAML files parse correctly
[PASS] Check 2: Cross-engine Iron Rule satisfied
[SKIP] Check 3: skipped — required module 09 not in active_modules
[PASS] Check 4: All spec_refs resolve to existing files
[PASS] Check 5: All required fields present
[PASS] Check 6: metadata.yaml complete
[PASS] Check 7: All team IDs match slug regex
[PASS] Check 8: All team suffixes are reserved
[PASS] Check 9: Profile enum valid and consistent
[SKIP] Check 10: skipped — required module 05 not in active_modules
[PASS] Check 11: Governance directory complete (definition.yaml + 19 team files)
[PASS] Check 12: Cross-project boundary OK (project=eyalamit, 0 forbidden patterns found)
[PASS] Check 13: All definition.yaml teams have governance files
[PASS] Check 14: Not a hub project — additionalDirectories check skipped
[PASS] Check 15: No stale artifacts for completed WPs in _COMMUNICATION/
[SKIP] Check 16: not hub — validate_aos_commands.sh skipped (spoke/minimal)
[SKIP] Check 17: not hub — PROJECT_CONTEXT schema check skipped (roll out per spoke)
[PASS] Check 18: _aos/ write authority: all non-governance team contracts correctly restrict _aos/ writes
[PASS] Check 19: API-only mutations: all team contracts include Iron Rule #7 API-only clause
[SKIP] Check 19: Unified DB checker not found at scripts/db/check_db_connectivity.py (hub-only component; skip on spokes)
[PASS] Check 20: mcp_profile='none' — no .cursor/mcp.json required
[SKIP] Check 21: validate_gates.sh: gate structure advisories found (pre-V318 data debt; run validate_gates.sh manually)
[SKIP] Check 22: validate_lod.sh: LOD400+ advisories found (pre-V318 schema debt; run validate_lod.sh --all --min-lod 400 manually)
[PASS] Check 23: validate_verdicts.sh: verdict schema PASS
[SKIP] Check 24: port-registry.yaml not found (spoke project — hub canon does not apply)
[PASS] Check 25: No pending offline DB sync (PENDING_DB_SYNC.yaml absent)
[PASS] Check 26: LOD400 CS citations — no suspected bare [CS-N] lines (ADR037)
[PASS] Check 27: CLAUDE.md canonical invariants present (DB-probe + AOS authority/identity — ADR040)
[PASS] Check 28: .cursorrules canonical invariants present (DB-probe + AOS startup section)
[SKIP] Check 29: hub LEAN_KIT_VERSION.md not reachable — set AOS_HUB_ROOT or start AOS API
[SKIP] Check 30: .claude/commands/ dir not present (non-Claude-Code repo or spoke without local commands)
[SKIP] Check 31: .claude/commands/ dir not present (skip)
[PASS] Check 32: _aos/ tree committed (no propagation drift) — IR#11
[PASS] Check 33: MSG file naming under _COMMUNICATION/ — no unexpected MSG-*.md patterns
[SKIP] Check 34: .claude/commands/AOS_handoff.md not present — skip
[PASS] Check 35: QA_REQUEST enum lint — all values valid (or no QA_REQUEST files found)
[PASS] Check 36: MSG branch independence — all send/read commands wired to msg_preflight.sh + msg_deliver_file (ADR043 v1.1.0 §4/§5)
[PASS] Check 37: Multi-domain routing wired — server threads project_id, routes accept X-Project-Id, helper auto-detects spoke (ADR043 v1.1.0 §6)
[PASS] Check 38: ADR043 v1.2.0 §6+§7 published, archive endpoint wired end-to-end (AOS-MSG-FOLLOWUPS-WP001)
[PASS] Check 39: MSG-LOG operational: AOS API healthy at http://100.125.98.56:8090
[SKIP] Check 40: MSG-HARDENING: spoke msg_precommit_hook.sh snapshot present but pre-commit hook not installed — acceptable (operator choice)
[SKIP] Check 41: auto-activation/ directory absent — acceptable pre-W6
[PASS] Check 42: Sprint discipline: all active WPs within ≤3 sprint cap
[SKIP] Check 43: Milestone completeness gate: _aos/milestones/ absent — no milestone definitions to check against (acceptable pre-MS001)
[PASS] Check 44: Track+Effort metadata: all WP metadata.yaml files have valid track: and effort: fields
[SKIP] Check 45: WAN dual-stack status absent — API not reachable and local file missing
[SKIP] Check 46: not hub — _aos/projects.yaml absent (spokes skip registry SSoT drift check)
[SKIP] Check 47: not hub — _aos/projects.yaml absent (spokes skip definition snapshot drift check)

=================================================
RESULT: 30 PASS / 18 SKIP / 0 FAIL
=================================================
L-GATE_BUILD EXIT CRITERION: SATISFIED
```

---

## Recommendation

| Verdict | Route |
|---------|-------|
| **PASS_WITH_FINDINGS** (no P0/P1) | **team_100** + **team_00** — proceed to **team_190 (Codex) L-GATE_VALIDATE** for WP-W2-07 |

Do **not** route to team_10 (no rework required).

Carry-forward: team_40 may recover 28 omitted QR images when originals become available; Eyal may supply FB profile photos later (F05).

---

*team_50 — L-GATE_BUILD Validator — Cursor Composer (non-Claude) — 2026-05-29*
