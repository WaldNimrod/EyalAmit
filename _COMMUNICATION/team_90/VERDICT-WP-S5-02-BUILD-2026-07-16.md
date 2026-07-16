---
id: VERDICT-WP-S5-02-BUILD-2026-07-16
from_team: team_90
to_team: team_110
date: 2026-07-16
type: cross-engine-validation-result
wp: WP-S5-02
milestone: S005
gate: L-GATE_VALIDATE
mandate_ref: MANDATE-TEAM90-WP-S5-02-BUILD-2026-07-16
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-02-LOD400-2026-07-16.md
builder_verdict_ref: _COMMUNICATION/team_110/VERDICT-WP-S5-02-BUILD-2026-07-16.md
evidence_root_builder: _COMMUNICATION/team_110/evidence/s5-02/
evidence_root_validator: tmp/team90_wp_s5_02_validate.py (probe script) + tmp/t90_*.html (live captures)
staging_base: https://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-S5-02 BUILD (team_90 cross-engine validation)

## Verdict flag

**PASS**

All 9 mandated checks independently reproduced **PASS** on live staging (`curl -sk`, sequential low-concurrency probes 2026-07-16) plus repo code inspection. The route-completeness schema/meta build (§2), QR reseed (§3.1), Offer gate (§4), harness (§5), and regression set hold. No blockers. Builder self-verdict confirmed; Iron Rule #1 satisfied (Anthropic builder ≠ Cursor validator).

---

## Iron Rule #1

| Role | Engine | Team |
|------|--------|------|
| Builder / self-verifier | claude-opus-4-8 (Claude Code) | team_110 |
| Independent validator | composer-2.5 (Cursor) | team_90 |
| Distinct vendors | **satisfied** | |

---

## Per-check results

| # | Check | Result | Evidence reproduced (URL + code + observed) |
|---|-------|--------|-----------------------------------------------|
| 1 | **AC-2.1** — page-specific node + non-empty meta on every gapped route class | **PASS** | Live staging (`curl -sk`, 2026-07-16): **`/qr/qr1/`** — `Article` `@id=…/#/schema/article/qr/qr1`; meta non-empty (trimmed post_content: "זה פשוט מאוד. 46 סיפורים…"). **`/qr/qr2/`** — `Article` + **1** `VideoObject` `embedUrl=https://www.youtube-nocookie.com/embed/ng9q5-xkNmE`; meta non-empty. **`/qr/qr10/`** — `Article` + **3** `VideoObject` nodes (`bdJQOIeQBig`, `kQjtK32mGJQ`, `BlqT-V_CTcg`), all nocookie embedUrls; meta non-empty. **`/qr/qr48/`** — `Article` only, **0** `VideoObject`; meta non-empty; **0** iframes. **`/qr/`** hub — `Article` `@id=…/#/schema/article/qr/qr`; meta = dedicated copy prefix **"עמודי ה-QR של אייל עמית"** (not generic phero.sub). **`/press/`** — `CollectionPage` `@id=…/#/schema/CollectionPage/press`, `isPartOf→…/#website`; meta = `$map['press']` copy. **`/shows-heritage/`** — `CollectionPage` `@id=…/#/schema/CollectionPage/shows-heritage`; meta = `$map['shows-heritage']` copy. Code: QR branch `site/wp-content/mu-plugins/ea-w2-seo-schema.php` L235–291; press/shows L294–331; meta `$map` + QR branch `site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php` L51–53, L67–84. Builder snapshots align: `_COMMUNICATION/team_110/evidence/s5-02/route-schema/*.jsonld`, `META-AFTER.txt`. |
| 2 | **AC-2.2** — `/shows/` → 301 → `/shows-heritage/` | **PASS** | `curl -sk -I https://eyalamit-co-il-2026.s887.upress.link/shows/` → **HTTP 301**, `Location: …/shows-heritage/`, `X-Redirect-By: WordPress`. Not 200, not 404. |
| 3 | **AC-2.3** — QR video conditionality (nocookie embedUrl; dedup; no empty VideoObject) | **PASS** | Code: regex + dedup loop `ea-w2-seo-schema.php` L262–291 (`preg_match_all` + `in_array` dedup; `embedUrl` forced to `youtube-nocookie.com` L283). Live: **qr2** — 1 iframe `src="https://www.youtube-nocookie.com/embed/ng9q5-xkNmE"` + 1 matching `VideoObject`; **qr10** — 3 iframes (nocookie) + 3 unique `VideoObject` nodes; **qr1**/**qr48** — `Article` only, 0 `VideoObject`, 0 YouTube iframes. No placeholder/empty `VideoObject` on text-only pages. `uploadDate` omitted on QR VideoObjects — **ratified per spec §2.2** (not flagged). |
| 4 | **§3.1** — QR reseed (nocookie + lazy iframes; self-guarded drop-in) | **PASS** | Live samples: **qr2**, **qr10** iframes include `youtube-nocookie.com/embed/…` **and** `loading="lazy"` (e.g. qr2: `<iframe src="https://www.youtube-nocookie.com/embed/ng9q5-xkNmE" … loading="lazy"`). **qr48** — 0 iframes (text-only). Builder AFTER captures match: `_COMMUNICATION/team_110/evidence/s5-02/qr-reseed/qr2_AFTER.html`, `qr10_AFTER.html`. Drop-in self-guard: `site/wp-content/mu-plugins/ea-w2-07b-qr-reseed-once.php` L21–30 — early return when `ea_w2_07b_qr_reseed_done === 'done'`; clears `ea_w2_07_qr_seeded_v3` once then sets done flag (single-fire). |
| 5 | **§4** — Offer/price rule holds (`is_numeric` gate) | **PASS** | Code gate: `ea-w2-seo-schema.php` L135 `if ( is_numeric( $price ) )` before emitting `Offer`. Live JSON-LD parse on 5 product pages — **Product=0, Offer=0** on `/repair/`, `/bags/`, `/stand-floor/`, `/stands-storage/`, `/didgeridoos/`; `"מחיר לפי התאמה"` present ×1 on each. Matches builder `offer-rule/offer-check.txt`. |
| 6 | **Early QR meta ordering** — hub dedicated copy wins over Chapters `phero.sub` | **PASS** | Code order: QR branch **L67–84** runs **before** Chapters `is_view` block **L86–92** in `seo-head-fallbacks.php`. Live `/qr/` meta = **"עמודי ה-QR של אייל עמית — סרטוני הדרכה…"** (dedicated `$map['qr']`), not generic hub sub. Confirms team_00-approved reconciliation; matches `route-schema/META-AFTER.txt` hub line. |
| 7 | **§5** — `seo_probe.config.json` harness (+3 routes, valid JSON) | **PASS** | `python3 -c "import json; json.load(open('scripts/qa/seo_probe.config.json'))"` → OK. Routes present: `press`, `shows-heritage`, `qr-qr2` with expectedTypes including `CollectionPage` / `Article`+`VideoObject` per WP-S5-02 notes (L93–109). |
| 8 | **`php -l`** on modified PHP files | **PASS** | `php -l site/wp-content/mu-plugins/ea-w2-seo-schema.php` → no syntax errors. `php -l site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php` → no syntax errors. `php -l site/wp-content/mu-plugins/ea-w2-07b-qr-reseed-once.php` → no syntax errors. |
| 9 | **No regression** on previously-covered routes | **PASS** | Live staging: **`/repair/`** — non-empty meta + `FAQPage` node (`#/schema/faqpage/repair`); **`/bags/`** — meta + `FAQPage`; **`/books/vekatavta/`** — meta + `Book` (`#/schema/book/vekatavta`) + `FAQPage`; **`/eyal-amit/mokesh-dahiman/`** — meta + `Person` (`#/schema/person/mokesh-dahiman`) + `VideoObject` (`embedUrl=https://www.youtube-nocookie.com/embed/kf4NKSdYi9E`). QR/press/shows changes did not remove or corrupt prior nodes. |

---

## Findings

| Severity | Finding | Route recommendation |
|----------|---------|---------------------|
| — | **None.** All ACs met; ratified guardrails respected (uploadDate omission, Yoast `WebSite` `@id` resolution, staging noindex/TLS, §3.2 facade deferred, `/qr/` prod 302 out of scope). | n/a |

---

## Validator notes (non-blocking)

- **Staging transport:** intermittent `curl` timeout (`HTTP 000`) on the shared uPress host during batch probes; resolved with sequential fetches + retry (per mandate guardrail). All sample routes eventually returned HTTP 200 with full payloads.
- **External Rich Results / Schema.org validator:** not re-run on staging (cert + site-wide `noindex` artifacts documented in spec/self-verdict). Structural shape validated via live JSON-LD parse + builder `STRUCTURAL-VALIDATION.txt`; authoritative external run remains prod/cutover (WP-S5-05).
- **Builder refinement accepted:** `CollectionPage.isPartOf` → Yoast real `…/#website` (graph scan L305–322) — correct, not a defect vs spec literal.

---

## Summary for gate routing

WP-S5-02 **L-GATE_VALIDATE: PASS.** Route-completeness schema/meta gap is closed on staging; QR reseed applied; Offer gate intact; harness updated; no regressions on the regression set. **No `route_recommendation` back to team_110.** Proceed to WP-S5-05 cutover gate per roadmap when team_00 routes.
