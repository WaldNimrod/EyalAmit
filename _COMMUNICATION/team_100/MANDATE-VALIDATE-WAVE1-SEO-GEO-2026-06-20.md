# MANDATE — Wave-1 SEO/GEO validation (team_100 → team_50 + team_190)

**Issued:** 2026-06-20 · **From:** team_100 (builder engine = Claude Code) · **To:** team_50 (L-GATE_BUILD verdict, cross-engine) + team_190 (L-GATE_VALIDATE, final). **Iron Rule #1:** builder ≠ validator — a DIFFERENT engine must run these gates.
**WP:** `S004-P001-WP000` (SEO/GEO finalization) — Wave-1 subset. **Branch:** `wave1-seo-geo`. **Env:** staging `http://eyalamit-co-il-2026.s887.upress.link` (theme `1.4.14`).

## 1. What was built (Wave-1 — the un-blocked subset)
| Item | Change | Commit |
|---|---|---|
| W1-01 | Lead-leak fix: WhatsApp+form shown to all (A/B no longer hides a channel); GA4 fires independently of Clarity; `G-MRXESK7QJF` live | `0ce1f41` |
| W1-13 | GA4 `generate_lead` conversion event (WhatsApp click + `wpcf7mailsent`) | `5d83a9a` |
| W1-01t | `wa.me` click-to-chat pre-fill (`ea_wave2_wa_url()` helper, 4 sites) | `f7e40b9` |
| W1-02 | Extend Yoast `@graph` (mu-plugin `ea-w2-seo-schema.php`): Person+sameAs, ProfessionalService+NAP, Service/route | `5f4110f` |
| W1-08 | Product/Offer schema (numeric-price only) in the same filter | `0f25cd7` |
| W1-06 | `/Blog/ → /blog/` 301 (PHP regex-prefix in the legacy-301 mu-plugin) | `48676f4` |
| W1-07 | sitemap canonical = `/sitemap_index.xml` (Yoast) — verified, no change needed | — |
| docs | Yoast-reality correction (Appendix B on the canonical WP) | `430e88e` |

**Deferred (not in this batch):** W1-05 (WebP/LCP — needs image tooling), W1-09 (route audit — largely covered by Yoast meta; verify), W1-03 (sleep-apnea pillar URL mechanism — content-gated on CP-01), W1-04 robots allow-list (cutover-gated). Eyal-blocked items per the completion register §1.

**Pre-deploy local checks (team_100, build-time — NOT the cross-engine gate):** `php -l` clean on all touched PHP; `node --check` clean on `ea-ab-testing.js`; JSON valid. _(local QA results vs staging appended in §4 after deploy.)_

## 2. Validation gates to run (cross-engine)
1. **content-diff** — `node scripts/qa/content-diff.mjs` on all 17 routes: gatePass = sectionCov ≥ 95 AND sentenceCov ≥ 90 AND inventedSections = 0. (Wave-1 is schema/JS/analytics — must show NO content regression.)
2. **axe a11y** — `node scripts/qa/http-qa-axe.cjs` across the route set: 0 serious/critical.
3. **overflow/responsive** — `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` @360/390/414/768: 0 horizontal overflow.
4. **Schema** — Google **Rich Results Test** + **Schema.org validator** on home + a service page + a product page: the `@graph` must include the new **Person / ProfessionalService / Service / Product** nodes, `@id`-connected, no errors; confirm a SINGLE graph (no duplicate/second schema engine).
5. **Analytics** — view-source on staging: `gtag/js?id=G-MRXESK7QJF` present in `<head>`; GA4 fires without Clarity; `generate_lead` wired (WhatsApp click + `wpcf7mailsent`).
6. **Redirects** — `curl -I` a `/Blog/<slug>` URL → `301` to `/blog/<slug>`; `/מוזה-הוצאה-לאור/` → `/books/` (single hop); spot-check the 14 reconciled page targets.
7. **WhatsApp** — `wa.me/972524822842?text=…` (pre-filled) on home/service/shop/EN.
8. **Regression** — no PHP notices/errors; existing pages render unchanged.

## 3. Cross-engine sequence
1. **team_50** (different engine) runs §2, records a verdict (`VERDICT_WP-S004-P001-WP000-WAVE1` in `_COMMUNICATION/team_50/`).
2. **team_190** runs the final L-GATE_VALIDATE after team_50's verdict is on disk (predecessor-present), records PASS/FAIL.
3. Dual-PASS → team_100 merges `wave1-seo-geo` (on Nimrod's explicit approval) + the production cutover (Track B, separate) carries the rest.

## 4. Local QA vs staging (team_100, post-deploy 2026-06-20) — GREEN
Deployed to staging (theme `1.4.14`, mu-plugins incl. `ea-w2-seo-schema.php`). team_100 build-time checks:
- **content-diff:** 16/16 sourced routes **ACCURATE** (no regression). 3 N/A: `/eyal-amit/mokesh-dahiman/` (gate PAGE_MAP still points at the superseded `ומה היום.docx` — update when mokesh rebuilds), `/galleries/` + `/media/` (no Eyal source). ✓
- **GA4:** `gtag/js?id=G-MRXESK7QJF` in `<head>` (×2: js+config) — **fires; independent of the still-pending Clarity.** ✓
- **Schema (single graph):** home `@graph` = `Person` + `ProfessionalService` + Yoast `WebPage/WebSite/BreadcrumbList` in **one** JSON-LD block; service page adds the `Service` node; Product/Offer on product pages. No second schema engine. ✓
- **Redirect:** `/Blog/test-slug/` → **301** → `/blog/test-slug/` ✓; `/מוזה-הוצאה-לאור/` → `/books/` single hop ✓.
- **WhatsApp:** `wa.me/972524822842?text=…` pre-fill live on home/service. ✓
- **Cache-bust:** `ver=1.4.14` on theme assets. ✓
> These are the builder's self-checks — team_50 must re-run §2 independently (Iron Rule #1).

## 5. External-tool validation (needs a session with browser/account access)
- **Google Rich Results Test** (https://search.google.com/test/rich-results) on the 3 page types — schema validity + the new nodes.
- **Lighthouse / CrUX** for CWV — note: staging perf scores are artifacts (noindex/edge); re-measure on production at cutover.
- **GSC** (coverage, URL inspection, sitemap submit) — **cutover-time only** (staging is `noindex`); not part of this gate.

---

### Activation prompt — validator session (paste to start team_50, a non-Claude engine)
> You are **team_50**, the cross-engine BUILD-gate validator for EyalAmit.co.il-2026 (AOS L0 spoke, repo
> `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`). team_100 (Claude Code) built the **Wave-1 SEO/GEO** batch on
> branch `wave1-seo-geo`, deployed to staging `http://eyalamit-co-il-2026.s887.upress.link` (theme 1.4.14). Read the
> mandate `_COMMUNICATION/team_100/MANDATE-VALIDATE-WAVE1-SEO-GEO-2026-06-20.md` in full. Run **every gate in §2**
> (content-diff, axe, overflow, schema via Rich-Results + Schema.org validator, GA4 `G-MRXESK7QJF` in head + generate_lead,
> `/Blog/→/blog/` 301, wa.me pre-fill, regression). You are a DIFFERENT engine than the builder (Iron Rule #1) — do not
> trust team_100's self-QA; re-run independently. Record a verdict file `VERDICT_WP-S004-P001-WP000-WAVE1_v1.md` in
> `_COMMUNICATION/team_50/` with PASS/FAIL per gate + evidence. On PASS, hand off to **team_190** for the final
> L-GATE_VALIDATE. Surface any FAIL to team_100 with the exact failing route/gate + output.
