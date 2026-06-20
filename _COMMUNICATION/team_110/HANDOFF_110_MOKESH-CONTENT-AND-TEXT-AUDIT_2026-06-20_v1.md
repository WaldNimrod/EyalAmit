# AOS HANDOFF — team_100 → team_110 · depth: FULL

**Mechanism:** `/AOS_handoff 110 full` → `/AOS_mail handoff` → hub API; hub DB **offline** → file-transport fallback (ADR043 §4/§5). This file IS the handoff artifact, delivered to team_110's inbox.
**From:** team_100 (Chief Architect) · **To:** team_110 · **Generated:** 2026-06-20 · **Profile:** L0
**Repo:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026` · **Staging:** `http://eyalamit-co-il-2026.s887.upress.link` (theme `1.4.14`)
**Build on a feature branch** (e.g. `mokesh-content`), off `main @ 817e05b` (or off `wave1b-seo-geo` after it merges). `.htaccess` is INERT (nginx); deploy via `scripts/ftp_deploy_site_wp_content.py`.

## Mission — two tasks
1. **Fix/COMPLETE the Mukesh page content.**
2. **Then:** a TEXT-ONLY scan + comparison between **Eyal's latest documents** and the **actual live site**, mapping **every** difference → a summary report.

---

## TASK 1 — Complete the Mukesh memorial page (verbatim)
**The problem (verified 2026-06-20):** the live page holds **~2,000 chars (1 section: «ומה היום»)** but Eyal's full doc is **~32,000 chars / 73 paras / ~12 sections** — the page has **~6% of what Eyal wrote**. Nothing is wrong with Eyal's content; the page was built (16-E) from a FRAGMENT before the full doc arrived. **This is a COMPLETION (add the missing 94% verbatim), not a redo.**

- **Source (verbatim):** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/מוקש דהימן – מאסטר דיג'רידו – דף להנצחת זכרו ופועלו 1950-2020.docx` (extract: `textutil -stdout -convert txt "<path>"`). Sections: מי היה מוקש דהימן? · היכרותו עם הדיג'רידו (הביטלס/רישיקש) · בית המלאכה ברישיקש · Dream Time · קוטלי (הסטודיו) · הגשמת החלום · תפנית חדה (קורונה) · פרידה · ומה היום · דברי הספד (אייל) · Om Mukesh Ji.
- **Renderer:** `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-14e.php` → `ea_w2_14e_render_memorial()` (hooked at `template_include` **priority 102** — supersedes the editorial route at 101; do NOT edit `wave2-w2-07.php`'s moksha route — that's dead code).
- **Spelling:** render `Jungle Vibes` (fix any `jungel`). Bio + dates **1950–2020** (death 11.10.2020) are real content (no longer placeholders). Family: אשתו אניטה, 4 בנים, בת גיני, נכדה פריטי.
- **Media (all captured):** `_COMMUNICATION/team_100/MOKESH-MEDIA-CAPTURE-2026-06-16.md` — **19 photos in the original order** (source: legacy-media mirror `_COMMUNICATION/team_40/legacy-media-index-…/mirror/` or the old-site URLs), **4 Facebook post embeds** at the very bottom, **trailer in HERO** (`kf4NKSdYi9E`, autoplay/muted/unmute — reuse `block-hero.php`+`ea-hero.js`), **full film LOWER** = placeholder until EYL-2 (link not public; only the trailer is).
  - Composition: HERO trailer → memorial text (full, verbatim, Jungle Vibes) → 19 photos → full-film slot (placeholder) → 4 FB embeds.
- **Slug:** the LIVE page is **`/eyal-amit/mokesh-dahiman/` (HTTP 200)**; `/about/moksha/` returns 301. The 301 mu-plugin maps the legacy Hebrew slug → `/about/moksha/`. **Reconcile the slug** (mokesh/moksha/mukesh inconsistency, flagged by the SEO critic): pick ONE canonical, make the 301 target + the page + any schema agree. Confirm with team_100/Nimrod before changing the live slug.
- **Gate:** re-point the content-diff PAGE_MAP for mokesh from `ومה היום.docx` → the **full** memorial doc (it's restored locally), then `node scripts/qa/content-diff.mjs` must clear (sectionCov≥95, sentenceCov≥90, inventedSections=0); + axe + overflow on the route. Bump `style.css` Version. Deploy → **dual-PASS (team_50 + team_190)** — you are the BUILDER, so a different engine validates (Iron Rule #1).

## TASK 2 — Text-only audit: Eyal's latest docs vs the live site
**Goal:** find EVERY text difference between what Eyal actually wrote and what's live, and report it.
- **Eyal's latest docs** (text sources): `docs/project/eyal-ceo-submissions-and-responses/from-eyal/` — especially `תוכן לאתר 25.5.26/` (mokesh full doc, `ממליצים מהפייסבוק.docx`), `CONTENT 12.4.26/` (`sound_healing_canonical.docx`, `site_updates.docx`), `CONTENT EYAL 10.4.26/` (`final_st-method…`), the st-book/muzeh content packs, `seo-content from eyal 2-4.md`, `eyal_amit_dev_brief_GEO_AEO_SEO.md`. Extract docx via `textutil`/the content-diff docx parser (per-`<w:p>` extraction — naive `<w:t>` joins split Hebrew words).
- **Live site:** the staging pages (home, /treatment, /sound-healing, /lessons, /eyal-amit, /eyal-amit/mokesh-dahiman, /faq, /books*, /shop*, /blog, /contact). Fetch + strip tags → visible text.
- **Method:** TEXT-ONLY (ignore markup/SEO/schema). Per page: map (a) content in Eyal's doc but MISSING on the page, (b) content CHANGED/paraphrased vs verbatim, (c) content on the page with NO Eyal source (invented). Start from `scripts/qa/content-diff.mjs` (it already does per-route source↔live coverage with sectionCov/sentenceCov/inventedSections + the geresh≡apostrophe normalization) but EXTEND it to cover ALL the latest docs↔pages, not just its current PAGE_MAP.
- **Output:** a summary report in `_COMMUNICATION/team_110/` — a per-page table (source doc · % covered · missing sections · changed lines · invented) + an executive summary ranking the biggest gaps (mokesh will top it pre-Task-1). Present it to Nimrod.

## Inputs / context
- Content-accuracy gate + docx parser: `scripts/qa/content-diff.mjs` (the per-`<w:p>` docx fix is on main; it's the canonical text-extraction).
- Mokesh evidence + decisions: `_COMMUNICATION/team_100/INTAKE-EYAL-SUPPLEMENTARY-2026-06-16.md`, `MOKESH-MEDIA-CAPTURE-2026-06-16.md`, the handoff `HANDOFF_SELF_100_POST-INTAKE-IMPLEMENTATION_2026-06-16_v1.md` (T1).
- Decisions locked: D-MOKESH = complete verbatim; D-SPELLING = Jungle Vibes; D-TESTIMONIALS = integrate all + Eyal-review; D-FILM = trailer in hero + full film lower.

## Standing rules (HARD)
1. Builder ≠ validator (Iron #1) — after Task 1 build, route through team_50 + team_190 dual-PASS.
2. Commit/push/merge only on Nimrod's explicit ask; no main merge / origin push without it.
3. No "ready" to Eyal until dual-PASS; Eyal messages are team_00's.
4. Don't edit `_aos/`. Don't extract secrets from env/.env.
5. Present every decision/question (esp. the mokesh slug) to Nimrod.
6. File-links to Nimrod = clickable `file:///…%20…` markdown only.

## Activation prompt
> You are **team_110** on EyalAmit.co.il-2026 (`/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`, AOS L0; staging `http://eyalamit-co-il-2026.s887.upress.link`, theme 1.4.14). Read this handoff fully. **TASK 1:** complete the Mukesh memorial page to the FULL verbatim doc (it currently has ~6% of Eyal's content) — renderer `inc/wave2-w2-14e.php::ea_w2_14e_render_memorial()` (priority 102), source doc + media per the handoff, Jungle Vibes spelling, hero trailer + 19 photos + 4 FB embeds + full-film placeholder; re-point the content-diff PAGE_MAP to the full doc, deploy, and route through team_50+team_190 dual-PASS (you build, they validate). Reconcile the mokesh/moksha slug with Nimrod first. **TASK 2 (after):** run a TEXT-ONLY audit of Eyal's latest from-eyal docs vs the live pages (extend `scripts/qa/content-diff.mjs`), map every missing/changed/invented difference, and deliver a summary report to `_COMMUNICATION/team_110/` + present to Nimrod. Present every decision; don't merge/push without explicit approval.
