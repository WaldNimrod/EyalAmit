---
id: VERDICT-WP-S5-03-BUILD-2026-07-16
from_team: team_90
to_team: team_110
date: 2026-07-16
type: cross-engine-validation-result
wp: WP-S5-03
milestone: S005
gate: L-GATE_VALIDATE
mandate_ref: MANDATE-TEAM90-WP-S5-03-BUILD-2026-07-16
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-03-LOD400-2026-07-16.md
builder_verdict_ref: _COMMUNICATION/team_110/VERDICT-WP-S5-03-BUILD-2026-07-16.md
evidence_root_builder: _COMMUNICATION/team_110/evidence/s5-03/
evidence_root_validator: independent recount + regen diff + serial live probes (2026-07-16)
staging_base: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-S5-03 BUILD (team_90 cross-engine validation)

## Verdict flag

**PASS_WITH_FINDINGS**

All mandated AC-3..AC-7 checks independently reproduced **PASS** on live staging (`curl -sk`, serial probes with 0.4–0.5s spacing) plus repo recount, SSoT inspection, and generator stability diff. No blockers. Builder `PASS_WITH_FINDINGS` confirmed. Iron Rule #1 satisfied (Anthropic builder ≠ Cursor validator).

---

## Iron Rule #1

| Role | Engine | Team |
|------|--------|------|
| Builder | claude-opus-4-8 (Claude Code, Anthropic) | team_110 |
| Independent validator | composer-2.5 (Cursor) | team_90 |
| Distinct vendors | **satisfied** | |

---

## Per-item results

| # | Check | Result | Evidence reproduced (URL + code + observed) |
|---|-------|--------|-----------------------------------------------|
| **AC-3 triage** | **PASS** (with F-01) | **GSC raw count:** 9 files under `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/דפים שלא אונדקסו/` → **406** URL rows (`awk 'NR>1 && NF'`, validator recount 2026-07-16). Spec §1 table claims **400**; `tail -n +2 \| wc -l` yields **397** (all 9 files lack trailing newline — last line dropped per file). **Triage:** `_COMMUNICATION/team_110/evidence/s5-03/triage-400/triage.csv` = **368** data rows = **368** unique normalised paths; **0** empty `verdict` cells. Denominator is unique paths after normalisation (406 raw → 368 unique), not the spec's stale 400. |
| **AC-3 Pattern A (2nd prefix)** | **PASS** | SSoT: `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` entries for `/דיגרידו-סטודיו-נשימה-מעגלית-אייל-עמית-2/*` (4 decisions, e.g. L1642+). Artifact: `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php` L67–70. Live: `/דיגרידו-סטודיו-נשימה-מעגלית-אייל-עמית-2/תיקון-דיגרידו/` → **301** `Location: …/repair/`, `X-EA-Redirect: w209-301`, **follow=200**. |
| **AC-3 Pattern A (3rd prefix `/פרדס-חנה/`)** | **PASS** | Not named in spec §3.2; present in SSoT (4 decisions, e.g. L1690+, `decided_note` cites WP-S5-03 extended triage). Artifact L71–74. Live: `/פרדס-חנה/תיקון-דיגרידו/` → **301** → `/repair/`, **follow=200**, `X-EA=w209-301`. |
| **AC-3 Pattern B (`/shop/books/*`)** | **PASS** | SSoT: 6 `/shop/books/<slug>` → `/books/<latin-slug>` decisions (L1736+). Artifact L75–80. Live: `/shop/books/צבע-בכחול-וזרוק-לים/` → **301** → `/books/tsva-bekahol/`, **follow=200**; `/shop/books/כושי-בלנטיס/` → **301** → `/books/kushi-blantis/`, **follow=200**. Hebrew slug targets **404** as expected: `/books/צבע-בכחול-וזרוק-לים/` **404**; `/books/כושי-בלאנטיס/` **404**; Latin `/books/tsva-bekahol/` **200**; `/books/kushi-blantis/` **200**. |
| **AC-3 regen / no hand-edit** | **PASS** | `python3 scripts/gen_htaccess_301_from_decisions.py` → **47×301 + 13×410** emitted; `diff` against pre-run `ea-w209-legacy-301-redirects.php` = **stable (no diff)**. SSoT `total_items: 165`. Generator order fix at `scripts/gen_htaccess_301_from_decisions.py` L324–343; artifact mirrors at `ea-w209-legacy-301-redirects.php` L91–110. |
| **AC-4 fold-or-drop** | **PASS** | **105** `/Blog/` URLs in triage (authoritative GSC set; spec's "54" is quarantined W2-06 export count). **4 FOLD** — exact SSoT decisions + live single-hop to renamed targets (`X-EA=w209-301`, not catch-all): `/Blog/הכל-אודות-ריברסינג-נשימה-מעגלית-ו-דיג/` → `/ריברסינג-נשימה-מעגלית-דיגרידו/` **follow=200**, title *"הכל אודות ריברסינג, נשימה מעגלית ו- דיג'רידו…"*; `/Blog/נשים-מנגנות-בדיגרידו-אישה-מנגנת-בדיג-2/` → **follow=200**, title *"האם לנשים מותר לנגן בדיג'רידו?…"*; `/Blog/סדנה-קבוצתית-מקיפה-וייחודית-לנשימה-מע/` → **follow=200**; `/Blog/את-הספר-החדש-שלי-לא-תמצאו-בחנויות-הספרי/` → **follow=200**, title *"את הספר החדש שלי לא תמצאו ברשתות הספרים…"*. **Catch-all regression (KEEP):** `/Blog/23-הטור-של-אייל-עמית-לציית-או-לחשוב/` **301** `X-EA=w209-blog`, **follow=200** (2 hops); `/Blog/32-הטור-של-אייל-עמית-אם-אין-אני-לי-מי-לי/` **follow=200**; `/Blog/ריברסינג-נשימה-מעגלית-דיגרידו/` **follow=200**. **DROP rationale verified:** `/Blog/tag/בייס-גאמפ/feed/` → **301** catch-all → **follow=404** (feed junk); `/Blog/portfolio_page/stockholm-fashion-destination/` → **301** → **follow=404** (theme demo). Per-slug ledger: `_COMMUNICATION/team_110/evidence/s5-03/blog-54/AC-4-blog-fold-or-drop.txt` + `SUMMARY.txt` (4 FOLD · 27 KEEP · 74 DROP). |
| **AC-5 orphans → 410** | **PASS** | All 11 paths in artifact `$gone` (`ea-w209-legacy-301-redirects.php` L20–34) return **410** + `X-EA-Redirect: w209-410` live: `/adi/`, `/רני/`, `/רני-2/`, `/גבי-2/`, `/סיני-יוני-09-154/`, `/איל-מישה-איטליה-כושי-בלאנטיס-1/`, `/איל-מישה-איטליה-כושי-בלאנטיס-3/`, `/איל-מישה-איטליה-כושי-בלאנטיס-4/` (in map), `/שלושת-הספרים-אלקטרוני2/`, `/דיגרידו-המרכז-לטיפול-בדיגרידו-סטודי/studio-bunner/` — validator probed each serially 2026-07-16. |
| **AC-6 out-of-staging-scope** | **PASS** (doc nit) | Mandate guardrail: **do not FAIL** on absent staging verification for www/scheme + orphaned-destination. Triage has **14** `http://www.eyalamit.co.il` source URLs classified (`covered` / `false-positive` / `needs-410`); literal verdict string `out-of-staging-scope` **not** present in `triage.csv` (0 rows) — documentation gap only, not a staging defect. Orphaned-destination DROP `/Blog/*` chains documented in §4 evidence; prod review deferred to WP-S5-05 per spec §6. |
| **AC-7 hazards** | **PASS** | Spec §7 + `_COMMUNICATION/team_110/evidence/s5-03/DEPLOY-MANIFEST.txt` L16–18: `deploy_htaccess_301.py` **NOT RUN** (uploads inert `.htaccess` on nginx). Script exists at `_COMMUNICATION/team_100/tools/deploy_htaccess_301.py` (FTP `.htaccess` deployer). Live mechanism = SSoT JSON → generator → mu-plugin only. |

---

## F-01 / F-02 / F-03 + deviation adjudication

### F-01 — spec §1 row count is wrong (confirmed)

| Source | Count | Validator observation |
|--------|-------|----------------------|
| Spec §1 table | 400 | Undercounts |
| `tail -n +2 \| wc -l` on 9 GSC files | **397** | Drops last line of **every** file (no trailing newline; validator verified `last_byte` ≠ `0a` on all 9) |
| `awk 'NR>1 && NF'` (correct) | **406** | **Authoritative raw row count** |
| `triage.csv` unique paths | **368** | All classified; 406 raw → 368 after `trailingslashit` dedup |

**Adjudication:** Builder F-01 **confirmed**. Recommend team_100 correct spec §1 table and AC-3 denominator language (unique paths from 406 raw, not "400/400").

### F-02 — DROP `/Blog/` URLs still 301→404 (confirmed, non-blocking)

Live: feed and `portfolio_page` samples above. Mechanism change (regex tightening) outside §3.4 "add decisions + regenerate" contract. **Not blocking** per mandate guardrails.

### F-03 — `/qr/qr2/` broken book link (confirmed, out of scope)

Not re-probed live (out of WP-S5-03 scope per mandate). Builder evidence `OBSERVED-LIVE-BOOK-SLUGS.txt` accepted; route to team_100 stands.

### Declared deviation — generator `$map` before `/Blog/` regex

**Claim:** §3.4 forbids hand-editing the **artifact**; 4 FOLD `/Blog/<slug>` decisions were **unreachable** when regex ran first and `exit()`ed.

**Validator reproduction:**

1. **Artifact not hand-edited:** `python3 scripts/gen_htaccess_301_from_decisions.py` → **zero diff** on `ea-w209-legacy-301-redirects.php`.
2. **Generator change is minimal and documented:** `scripts/gen_htaccess_301_from_decisions.py` L324–343; artifact L91–110 — `$map` populated first; regex guarded by `! isset( $map[ $norm ] )`; exact map wins with `X-EA-Redirect: w209-301`.
3. **Behaviour verified live:** 4 FOLD posts now **301 single-hop → 200** to **renamed** slugs (title match, not slug similarity). Pre-fix triage rows still show `follow=404` (stale snapshot before deploy); live probes supersede.
4. **No regression:** KEEP `/Blog/` slugs still use catch-all (`X-EA=w209-blog`, 2-hop → 200).

**Adjudication:** **Legitimate SSoT-first fix.** The unreachable-decision bug made "add decisions + regenerate" insufficient for renamed posts; changing emission order in the **generator** (not the artifact) is the correct minimal repair and honours AC-3's "no real legacy content dropped." **Not** an out-of-contract hand-edit.

---

## route_recommendation

**`L-GATE_BUILD` → PASS.** No return to team_110. Findings F-01 (spec table correction), F-02 (optional regex tightening → team_100), F-03 (QR seed link → team_100) are **minor / non-blocking**. **Do not start WP-S5-05** until team_00 routes cutover.
