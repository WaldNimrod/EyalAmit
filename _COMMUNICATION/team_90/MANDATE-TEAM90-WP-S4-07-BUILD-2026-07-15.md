---
id: MANDATE-TEAM90-WP-S4-07-BUILD-2026-07-15
from_team: team_100
to_team: team_90
date: 2026-07-15
type: cross-engine-validation-mandate
wp: WP-S4-07
builder_engine: sonnet (anthropic, team_10/team_30)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S4-07-BUILD-2026-07-15.md
---

# MANDATE — team_90 cross-engine validation: WP-S4-07 (SEO/GEO drafts)

You are the **cross-engine validator** (composer-2.5). **Independently reproduce** the ACs from the spec + `content-proposals.json` + built files. Do NOT trust the builder report.

## Sources of truth
- Spec: `_COMMUNICATION/team_100/S004/WP-S4-07-LOD400-2026-07-15.md` (§2 AF, §3 FAQ, §4 BLOG, §5 BN, §6 EN, §7 ACs).
- Verbatim source: `hub/data/content-proposals.json`.
- Built files: `inc/chapters/defaults/{treatment,method,sound-healing,lessons}-defaults.php`; `template-parts/blocks/block-footer-social.php`; `mu-plugins/ea-w2-seo-schema.php`; `page-templates/tpl-chapters-en.php`; FAQ seed (`mu-plugins/ea-faq-seed*.php` / `inc/data/ea-faq-seed.json`); new blog seed mu-plugin.
- Staging: `http://eyalamit-co-il-2026.s887.upress.link`

## Checks — reproduce each, cite evidence
- **AC-1/AC-3** — AF-01..04: the answer-first `<p>` (verbatim from content-proposals.json / spec §2.2–2.5) is the FIRST paragraph of the target section body, immediately under the H2, on `/treatment/ /method/ /sound-healing/ /lessons/`.
- **AC-2** — each AF block is **40–60 words** (hard cap 60).
- **AC-4** — FAQ-01/02/03 questions present in the `ea_faq` seed with correct category (`treatment`/`method`/`general`); note which pre-existed vs were added.
- **AC-5** — FAQ answers 40–70 words.
- **AC-6** — each `[EYAL-SIGN-OFF]` claim (AF-01 «מאז 1999»; AF-02 cbDIDG decode+Mokesh; FAQ-01#2 CPAP; FAQ-02#1 rebirthing; FAQ-03#3 price) carries a glow marker (interim `.ea-pending-approval`).
- **AC-7** — BLOG-01..04 exist as `post_status => 'draft'` in the seed mu-plugin; **0 published** (no live archive/sitemap entry).
- **AC-8** — «סטודיו נשימה מעגלית» removed from live brand copy: `grep -rn` across theme → remaining hits are ONLY historical/testimonial-data/exclusion-filter, not rendered brand copy.
- **AC-9** — 6 routes (`/treatment /method /sound-healing /lessons /eyal-amit` + pillar) have unique cbDIDG-leading `<title>` + meta description (curl the rendered `<title>`/`meta[name=description]`).
- **AC-10** — NAP consistency: address «עמל 8 ב'» + phone `052-482-2842` identical byte-for-byte across FAQ-03 + footer.
- **AC-11** — medical disclaimer present in health-claim blocks (pillar / CPAP FAQ).
- Layout (qa_probe) validated by team_100 separately; reference `_COMMUNICATION/team_90/evidence/wp-s4-07-2026-07-15/` if present.

## Required output
Write **`_COMMUNICATION/team_90/VERDICT-WP-S4-07-BUILD-2026-07-15.md`**: frontmatter (`validator_engine: composer-2.5`, `wp: WP-S4-07`, `iron_rule_1: satisfied`); top-level flag (`PASS`/`PASS_WITH_FINDINGS`/`CONCERNS`/`FAIL`); per-AC table with PASS/FAIL + evidence; distinguish environmental/by-design (draft blogs, [EYAL-SIGN-OFF] pending) from real defects; `route_recommendation` for any FAIL.

## team_100 runtime observations (2026-07-15, post-deploy on staging)
- AF-01..04 answer-first blocks RENDER on `/treatment/ /method/ /sound-healing/ /lessons/` (grep-verbatim confirmed); qa_probe 10/10 PASS (0 overflow).
- BN-01: visible footer carries «…דיג׳רידו · … שיטת cbDIDG, מאז 1999» (cbDIDG present).
- BN-02: «סטודיו נשימה מעגלית» = 0 live brand-copy occurrences (already clean from prior work).
- BN-03: pages are post_type=page (ids resolve); the `_yoast_wpseo_title` seed is in place, but the NEW cbDIDG-leading titles are **[EYAL-SIGN-OFF]** (§5.1) AND 5 service pages already carry Eyal-APPROVED 07-12 descriptions — so by design they are NOT force-activated pre-sign-off; current titles are unique per-route (Yoast auto). Treat AC-9's cbDIDG-wording as sign-off-deferred (→ M-EYAL-INPUTS), not a build defect. Judge whether that framing is sound.
- FAQ answers are verbatim from content-proposals.json — several under the 40-word target; builder preserved source rather than padding (flag as source finding, not fabricate).
