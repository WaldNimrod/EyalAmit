---
id: VERDICT-WP-S4-07-BUILD-2026-07-15
from_team: team_90
to_team: team_100
date: 2026-07-15
type: validation-result
wp: WP-S4-07
builder_engine: sonnet (anthropic, team_10/team_30)
validator_engine: composer-2.5
iron_rule_1: satisfied
mandate_ref: MANDATE-TEAM90-WP-S4-07-BUILD-2026-07-15
spec_ref: _COMMUNICATION/team_100/S004/WP-S4-07-LOD400-2026-07-15.md
---

# VERDICT — WP-S4-07 BUILD (team_90 cross-engine validation)

## Verdict flag

**PASS_WITH_FINDINGS**

Core deliverables (AF-01..04 answer-first blocks, BN-01 footer reframe, FAQ/blog/meta seed artifacts) are present in built repo files and AF blocks render on staging. Findings are a mix of **source-length gaps** (FAQ answers verbatim from JSON under 40 words — not padded), **incomplete FAQ-03 coverage** in seed, **missing `[EYAL-SIGN-OFF]` glow on one FAQ-02 claim**, **NAP not byte-identical FAQ↔footer**, **BN-03 cbDIDG titles seeded but not live** (by-design sign-off deferral — team_100 framing accepted), and **staging DB seed lag** (new FAQ strings absent from rendered `/faq/` at validation time).

---

## Iron Rule #1

| Check | Result |
|-------|--------|
| Builder | sonnet / anthropic / team_10 · team_30 |
| Validator | composer-2.5 / cursor / team_90 |
| Distinct vendors | **satisfied** |

---

## Per-AC results

| AC | Result | Evidence | route_recommendation |
|----|--------|----------|----------------------|
| **AC-1** | **PASS** | AF verbatim blocks present as first `<p>` in target section bodies: `treatment-defaults.php` L45 (`id=>what`), `method-defaults.php` L32–34 (`split_body`), `sound-healing-defaults.php` L41, `lessons-defaults.php` L40. Staging curl `/treatment/`: first `<p>` after H2 «מה זה טיפול…» = answer-first lede (independent Python fetch 2026-07-15). AF snippets confirmed on `/method/`, `/sound-healing/`, `/lessons/` (same fetch). | — |
| **AC-2** | **PASS** | Independent word count (Hebrew whitespace tokens) on verbatim `content-proposals.json` AF text: AF-01 **53**, AF-02 **48**, AF-03 **55**, AF-04 **50** — all within 40–60 (hard cap 60). | — |
| **AC-3** | **PASS** | In defaults, answer-first `<p>` precedes expansion paragraphs (e.g. `treatment-defaults.php` L45: AF `<p>` then `.ea-pending-approval` then legacy `<p>טיפול בדיג׳רידו…`). Staging `/treatment/` first body `<p>` under target section = AF lede (curl). | — |
| **AC-4** | **PASS_WITH_FINDINGS** | **Repo seed (`ea-faq-seed.json`):** FAQ-01 five questions added `treatment-16..20` (category `treatment`) — **new**. FAQ-02 Q2/Q3 added `method-08`, `method-09` — **new**. FAQ-02 Q1 **pre-existed** as `method-02` («…בריברסינג» vs spec verbatim «…לבין ריברסינג (rebirthing)?» — semantic match, wording drift). FAQ-03 Q2/Q4 added `general-16`, `general-17` — **new**. **Gaps:** FAQ-03 Q1 «איפה מתקיימים המפגשים?» — `general-01` pre-exists but answer lacks «עמל 8 ב'» (spec §3.3 verbatim). FAQ-03 Q3 «כמה עולה טיפול / שיעור?» — **absent** from seed (only legacy `general-05` «כמה זה עולה?»). **Staging:** curl `/faq/`, `/treatment/`, `/method/` — **0/5** new WP-S4-07 question strings found in HTML (seed likely not re-run post-deploy). | **team_10:** after FTP deploy of `ea-faq-seed.json` + mu-plugin, reset/re-run FAQ seed on staging; add missing FAQ-03 Q3 (+ update Q1 answer with «עמל 8 ב'» verbatim). |
| **AC-5** | **PASS_WITH_FINDINGS** (source finding) | Word counts on WP-S4-07 seed answers (HTML stripped): `treatment-16` **38**, `treatment-17` **63**, `treatment-18` **24**, `treatment-19` **24**, `treatment-20` **28**, `method-08` **23**, `method-09` **25**, `general-16` **20**, `general-17` **19**. Seven of nine new answers **below 40-word floor**; all **≤70** ceiling. Text matches `content-proposals.json` verbatim — builder preserved source rather than padding. **Not a fabricate defect**; flag to team_100/Eyal whether to expand at sign-off. | **M-EYAL-INPUTS / team_30:** optional copy expansion at Eyal review — do not auto-pad without approval. |
| **AC-6** | **PASS_WITH_FINDINGS** | **Present:** AF-01 «מאז 1999» → `.ea-pending-approval` in `treatment-defaults.php` L45; staging `/treatment/` renders pending + «מאז 1999». AF-02 cbDIDG decode + Mokesh → `.ea-pending-approval` in `method-defaults.php` L34; staging `/method/` shows `circular-breathing` (2×). FAQ-01#2 CPAP → `.ea-pending-approval` in `ea-faq-seed.json` `treatment-17`. **Missing:** FAQ-02#1 rebirthing differentiation — `method-02` (pre-existing) has **no** `.ea-pending-approval` despite `[EYAL-SIGN-OFF]` in spec §3.2. FAQ-03#3 price — question not seeded; no glow. | **team_30:** add `.ea-pending-approval` adjacent to `method-02` rebirthing answer (or new FAQ-02#1 seed row); add FAQ-03 Q3 with price-policy glow. |
| **AC-7** | **PASS** (by-design + code) | `ea-s407-blog-spokes-seed-once.php`: four spokes, each `post_status => 'draft'` L185; idempotent `_ea_s407_blog_seed_key` meta. Staging `/blog/` archive: no S407 slug/title hints (`bmj-didgeridoo`, `what-is-cbdidg`, etc.) — **0 published** consistent with draft-only. **Note:** BLOG-03 creates new draft rather than upgrading legacy rebirthing post (documented in mu-plugin docblock L14–20) — process debt, not AC-7 fail. | **team_10/100:** reconcile BLOG-03 vs legacy rebirthing post before publish. |
| **AC-8** | **PASS** | Theme grep «סטודיו נשימה מעגלית»: hits only in `chapters-render.php` L337–343 (exclusion filter), `section-05-testimonials.php` L6–14 (historical testimonial exclusion), `ea-testimonials-fb.json` (raw FB quotes — not edited). **0** rendered brand-copy hits. Footer tagline = «…דיג׳רידו · cbDIDG» (`block-footer-social.php` L64). Staging `/treatment/`: retired string **False**, `cbDIDG` **True**. | — |
| **AC-9** | **PASS_WITH_FINDINGS** (by-design deferral) | **Repo:** `ea-s407-bn03-titles-metadesc-seed-once.php` defines six cbDIDG-leading title/description pairs (L84–108); sets `_yoast_wpseo_title` / `_yoast_wpseo_metadesc` only when empty (never clobbers Eyal-approved 2026-07-12 descriptions). **Staging curl (6 routes):** all titles **unique** (6/6); **none** cbDIDG-leading (`Any cbDIDG in title: False`); pattern «{page H1} - eyal amit». Descriptions are route-specific (Eyal 07-12 set on service pages). **team_100 framing accepted:** cbDIDG BN-03 wording is `[EYAL-SIGN-OFF]` / M-EYAL-INPUTS — not a build defect to force pre-sign-off; current live titles satisfy uniqueness, not BN-03 verbatim lead. | **team_00/Eyal:** activate BN-03 titles post M-EYAL-INPUTS; optional description swap vs 07-12 set. |
| **AC-10** | **FAIL** | Spec §3.3 / AC-10: NAP «עמל 8 ב'» + `052-482-2842` byte-identical in FAQ-03 + footer. **FAQ:** `general-17` has phone `052-482-2842` (`ea-faq-seed.json` L859) — **PASS phone in FAQ**. **Missing:** no FAQ seed row with «עמל 8 ב'» in answer (FAQ-03 Q1 not updated). **Footer:** `block-footer-social.php` L64–65 — tagline + «פרדס חנה · ישראל» only; **no** address or phone. Staging: «עמל 8» appears via schema/contact elsewhere (1× on service pages) but **not** footer and **not** FAQ-03 verbatim pair. | **team_30:** update FAQ-03 Q1 answer with «עמל 8 ב'»; decide D1 NAP footer line per BN-01 recommendation; then re-check byte match. |
| **AC-11** | **PASS** | Pillar disclaimer verbatim in `snoring-sleep-apnea-defaults.php` L273 («אינו מהווה ייעוץ רפואי…»). Staging `/snoring-sleep-apnea/`: «ייעוץ רפואי» present. CPAP FAQ answer (`treatment-17`) includes medical guardrails («לא… CPAP… בליווי רופא»). Blog seed injects standard disclaimer via `ea_s407_blog_disclaimer()` L37–38. | — |

---

## Layout / qa_probe (reference)

Independent read of `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/wp-s4-07-2026-07-15/qa_probe_result.json`: **10/10 PASS**, 0 overflow (AF routes + `/eyal-amit/`). Layout not re-run by team_90 this session; evidence corroborates team_100 observation.

---

## Environmental / by-design (non-defect)

| Item | Classification |
|------|----------------|
| Blog spokes remain `draft` | **By design** — AC-7; not in live archive/sitemap |
| `[EYAL-SIGN-OFF]` `.ea-pending-approval` on AF-01/AF-02/CPAP | **By design** — interim glow until Eyal sign-off |
| BN-03 cbDIDG titles not in live `<title>` | **By design / sign-off-deferred** — seed in repo; Eyal 07-12 descriptions retained; team_100 framing sound |
| FAQ answers under 40 words | **Source finding** — verbatim from `content-proposals.json`; not builder fabrication |
| New FAQ not visible on staging `/faq/` yet | **Environmental / deploy** — re-seed after mu-plugin + JSON deploy |
| BLOG-03 new draft vs legacy rebirthing upgrade | **Process note** — spec §4 refine vs insert-only seed mechanism |

---

## route_recommendation (summary)

1. **Before L-GATE_BUILD closeout:** fix **AC-10** (NAP FAQ-03 ↔ footer) and **AC-6** gap (rebirthing FAQ glow); complete **AC-4** FAQ-03 Q3 + Q1 geo answer in seed.
2. **team_10:** confirm staging deploy includes `ea-s407-*` mu-plugins + updated `ea-faq-seed.json`; re-run FAQ seed so AC-4 items render live.
3. **No block on M-EYAL-INPUTS track** for BN-03 title activation or FAQ length expansion — route those to Eyal sign-off queue.
4. **team_50:** E2E after above fixes + staging seed confirmation.

---

## Validator methodology

Independent reproduction: read LOD400 §2–§7 + `hub/data/content-proposals.json`; inspect built defaults, footer, FAQ seed JSON, S407 mu-plugins; Python word-count + staging curl (TLS bypass dev-only, `http://eyalamit-co-il-2026.s887.upress.link`); theme grep for retired brand string; read qa_probe evidence (did not trust builder report). Builder engine ≠ validator engine (Iron Rule #1).
