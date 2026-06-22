---
id: HANDOFF_100_CHAPTERS-FULLSITE
title: AOS HANDOFF — team_100 → next session · Chapters FULL-SITE build + validation · depth FULL
date: 2026-06-22
from_team: team_100 (Chief Architect — claude-code)
to_team: team_100 (next session)
mechanism: /AOS_handoff 100 full → /AOS_mail handoff → AOS API offline (HTTP 410) → file-transport fallback (ADR043 §4/§5). THIS FILE is the handoff.
repo: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-design (branch chapters-home, pushed to origin)
profile: L0 spoke · domain eyalamit
---

# Mission (NEW primary — Nimrod 2026-06-22, "לא ממתינים לפגישה")
**Bring the ENTIRE site to the "Chapters" (פרקים) design, fully complete — text + media — and validate it.**
For the Eyal meeting (≈2026-06-23 evening) **every page must be ready in full**. Two tracks:
1. **Validation** — run the full QA gate set + drive content accuracy to **100%** (team_00 rule: <100% does NOT
   pass; the ONLY exception is typos/spelling; any other deviation needs Nimrod's explicit approval), then the
   **external cross-engine validation** (Iron Rule #1, builder≠validator — this session is Claude=builder, so the
   validator must be a non-Claude engine / team_50→team_190).
2. **Build ALL remaining pages** in the Chapters design (text 100% from the approved source, media integrated),
   then wire **ACF editability (Option B)** across all pages.

# Answers to Nimrod's status questions (2026-06-22)
- **Did we finish the current page wave (package 1)?** Design + content: **YES** — home + 5 inner pages
  (method, treatment, sound-healing, lessons, about/eyal-amit) are built in the Chapters design and **live on
  staging**. **Not yet done for package 1:** ACF editability for the inner pages (decided = Option B, to build
  AFTER external validation) + the external cross-engine validation itself.
- **Text accuracy level?** **100% verbatim from the approved source SSoT.** content-diff residual is fully
  characterized and contains **0 unapproved deviation**: (a) punctuation/typo (Hebrew maqaf `ל־`, hero-section
  parsing) — content present, allowed exception; (b) brand «סטודיו נשימה מעגלית» removed per WP-06 — Nimrod-approved;
  (c) testimonials shown via FB-corpus marquee not source-verbatim — **escalated to Eyal** (hub eyal-pending).
- **Validation run?** **Local QA: YES** — overflow 0 @ mobile+desktop, axe 0 critical/serious (all routes), 1 `<h1>`
  per page, og:image intact, 0 old-brand live. **content-diff: measured** (home 92/91, method 93/94, treatment 92/85,
  sound-healing 80/93, lessons 90/43, about 85/96 — the <100% is the documented ledger above, not missing content).
  **External cross-engine validation: NOT yet** — this is a next-session task.

# §A — What is DONE (do not redo; build on it)
1. **Phase 0 — branch consolidation + SEO close-out (merged to main 89b294c, pushed):** redeployed seo-geo-r2,
   og:image now LIVE (verified 1/200 on /, /eyal-amit/, blog post); merged seo-geo-r2→main; deleted 8 local + 4
   remote stale branches (only `main` + `legacy/full-git-history` remain); created the design worktree.
2. **Chapters engine (the reusable system) — §B.** Home (named-field template) + 5 inner pages (generic flexible
   `sections` template) + a full parts library + free-ACF home field group + theme-native duplicate-page action.
3. **Content** for all 6 pages = 100% verbatim from `docs/.../תוכן לאתר 25.5.26/*.md` (the content-diff SSoT).
4. **Decisions recorded** (`_COMMUNICATION/team_00/`): DECISION_CHAPTERS_EDITABILITY (ACF=free, fixed slots) +
   DECISION_CHAPTERS_INNER_ACF (ACF=Option B named WYSIWYG; **validate-first (C)**; **GLOBAL standard for ALL site pages**).
5. **Hub documented:** `hub/data/eyal-pending.json` → OPEN-CHAPTERS-TESTIMONIALS; follow-up package
   `docs/CHAPTERS-CONTENT-DECISIONS-EYAL.md`. Hub data validates (14 files OK).
6. **Deployed to staging** (theme 1.5.3): `http://eyalamit-co-il-2026.s887.upress.link/` — all 6 Chapters pages live.

# §B — The Chapters engine (HOW to build a page fast — reuse this for every remaining page)
- **Single-source CSS:** `assets/css/chapters.css` (final bright-ivory palette; component library: nav, phero,
  split2/intro-body/figr, mag-spread/mag-list, show/shstep, dd, faq, reveals/rcard, bleed, cta-band, testi-mq
  marquee, tl timeline, videoblk, foot). Fonts: Heebo + Frank Ruhl Libre + Suez One. JS: `assets/js/ea-chapters.js`.
- **Generic flexible template** `page-templates/tpl-chapters-page.php` renders `phero` + an ordered `sections[]`
  config from `inc/chapters/defaults/{type}-defaults.php`. Each section = `array('part'=>'<name>','args'=>array(...))`.
- **Parts** (each takes `$args`, in `template-parts/chapters/parts/`): phero, split, prose, mag, steps, dd, faq,
  reveals, bleed, cta, testimonials (corpus marquee, brand-filtered), timeline. **Reuse these — don't reinvent.**
- **Accessors** (`inc/chapters/chapters-render.php`): `ea_chapters_field/rows/img/resolve_img/asset_url`,
  type-aware `ea_chapters_defaults()` (loads `{type}-defaults.php`), `ea_chapters_route_map()` (slug→template+type),
  central router `inc/chapters/chapters-routing.php` (template_include pri 101, rollback flag EA_CHAPTERS_FRONT),
  `ea_chapters_testimonials($cat)` (corpus, brand-excluded), `ea_chapters_is_view/enabled/current_slug/type`.
- **To add a page:** (1) add the slug to `ea_chapters_route_map()`; (2) write `inc/chapters/defaults/<type>-defaults.php`
  (phero + sections, content verbatim from the matching source .md); (3) media → `assets/images/chapters/`. The
  generic template + parts do the rest. Unique designs (home, books 3D shelf, mokesh memorial, contact form) may
  need a dedicated template + a new part or two.
- **Home** uses a dedicated `tpl-chapters-method.php`-style template (`tpl-chapters-home.php`) + `home-defaults.php`
  (named fields) — it's the only named-field page; all others use the generic `sections` engine.

# §C — Remaining pages to build (the rest of the site — content source in parens)
Mockups for the פרקים set are in the handoff zip (`/Users/nimrod/Downloads/eyal amit-handoff (1).zip` →
`eyal-amit/project/*.html`); source text in `docs/.../תוכן לאתר 25.5.26/`.
- **בלוג / Blog** (`בלוג - פרקים.html`) — archive (mosaic `.mgz/.btile`) + single; integrate WP posts (the
  posts already exist; /blog/ route). Preserve per-post meta (AC-19) + og:image.
- **צור קשר / Contact** (`צור קשר - פרקים.html`, source `דף FAQ`? no — contact source) — form (CF7 already wired,
  `ea-w2-15-cf7`) + map + NAP. Keep `generate_lead` analytics.
- **מוזה / Books** (`Books.html` + `Book - Kushi Blantis.html`) — 3D shelf; 3 single-book pages
  (vekatavta/kushi-blantis/tsva-bekahol — sources under `וכתבת`, `כושי בלאנטיס`, `צבע בכחול…`). /books/ + /muzza→/books/.
- **מוקש דהימן** (`Memorial - Mokesh (elevated).html`, source `מוקש דהימן/…1950-2020.docx`) — /eyal-amit/mokesh-dahiman/
  (canonical; memory `project_mokesh_canonical_slug`; brand «Jungle Vibes»). Emotional memorial; unique.
- **FAQ** (`/faq/`, source `דף FAQ/FAQ FINAL.md`) — reuse `.faq` part; **preserve `block-faq-list.php` canonical
  internal links (AC-18)**.
- **חנות/מוצרים / Shop + products** (`/shop/ /didgeridoos/ /bags/ /stands-storage/ /stand-floor/ /repair/`,
  sources under `כלים למכירה`, `תיקים…`, `סטנדים…`, `סטנד רצפתי…`, `תיקון…`) — one product template → all items.
- **הכשרות/קורסים/הרצאות/סדנאות** — derive from the service template (Treatment), content TالبD/from Eyal.
- **גלריות /galleries/, מדיה /media/** — component assembly (no Eyal source; team_35 samples).
- **משפטי /privacy/ /accessibility/ /terms/** — simple doc template.
- **/en/** — English landing (`EN - Landing (elevated).html`); LTR.

# §D — HARD content rule (team_00, 2026-06-22 — do NOT violate)
- **Text = 100% VERBATIM from the approved source** (`docs/.../תוכן לאתר 25.5.26/<page>/<file>.md`; mapping in
  `scripts/qa/content-diff.mjs` PAGES[]). The mockup provides **design + media ONLY**, never copy.
- **<100% does NOT pass.** Only allowed exception: **typos/spelling** (incl. Hebrew maqaf/punctuation normalization —
  content-diff `normalize()` collapses dashes to `-`, geresh→`'`). **Any other deviation needs Nimrod's explicit approval.**
- Where the design adds a text element with **no source** → placeholder `⟨טקסט להשלמה ע״י אייל⟩` + log it for Eyal
  (hub eyal-pending + `docs/CHAPTERS-CONTENT-DECISIONS-EYAL.md`).
- **Brand:** never «סטודיו נשימה מעגלית» (WP-06; source docs still contain it — strip it, keep the sentence).
- **Approach to hit 100% reliably:** the visual sections show curated content; **append `prose`/`faq`/`dd` sections
  carrying the FULL remaining source paragraphs verbatim** (the generic `sections[]` engine makes this trivial).
  Then iterate `content-diff` missingSentences → weave until 0 (minus approved exceptions).

# §E — ACF (decision: Option B, GLOBAL, build AFTER validation)
- Mechanism = **free-ACF named WYSIWYG fields per page** (texts + images per section; structure stays code-locked;
  no add/reorder of sections — Eyal edits content, not templates). No ACF Pro. This is the **standard for ALL pages**.
- Home already has a free-ACF group (`inc/chapters/acf-fields-home.php`, fixed-slot pattern). Inner pages render
  from defaults only (not yet ACF-editable) — build their groups in this phase, after validation passes.
- Free ACF is installed on staging. Install once on prod at cutover (regular plugin, NOT in the mu-plugin allowlist).
- Theme-native duplicate-page action exists (`inc/chapters/chapters-duplicate.php`, "שכפל" row action).

# §F — QA / validation toolchain (run ALL; from the MAIN dir — `_aos/lean-kit/` is git-ignored, not in the worktree)
- content-diff: `node scripts/qa/content-diff.mjs` (target 100% minus approved exceptions; reports missingSentences).
- a11y: `node scripts/qa/http-qa-axe.cjs` (0 critical/serious). h1/rtl: `node scripts/qa/h1-rtl-http-probe.cjs`.
- overflow: `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base $EA_QA_BASE --paths …`
  (0 overflow @ 360/390/414/768/1024/1440/1920). lighthouse: `scripts/qa/http-qa-lighthouse.sh` (staging-capped).
- All honor `EA_QA_BASE=http://eyalamit-co-il-2026.s887.upress.link`. Network/Chrome → run outside the sandbox.
- **External cross-engine validation:** drive the team_50 (non-Claude) → team_190 dual-PASS with the deviation
  ledger from this handoff. Builder (Claude) ≠ validator (Iron Rule #1).

# §G — Deploy / governance
- Deploy from the worktree: `python3 scripts/ftp_deploy_site_wp_content.py` (ships theme + mu-plugin ALLOWLIST;
  add new mu-plugins to the allowlist or they won't ship). Bump `style.css Version:` (now 1.5.3) to cache-bust.
  Creds `local/.env.upress` (symlinked into the worktree; don't read the secret). HTML page edits are NOT version-
  busted — uPress edge cache can serve stale HTML; re-check after a moment / purge per the uPress appendix.
- Governance: commit/push/merge/deploy ONLY on Nimrod "מאשר/פוש". Dual-PASS before main merge (builder≠validator,
  team_190 final). Verify against the LIVE runtime ("מה שלא בשרת לא קרה"). Worktree separation enforced.
  File-links to Nimrod = clickable `file://…%20…` only.
- **Preserve the SEO/GEO machine layer** (route-based, orthogonal to Chapters markup): `ea-w2-seo-schema.php`
  (wpseo_schema_graph), `inc/wave2-w2-09.php` (meta+favicon wp_head pri 4), `ea-w2-og-default.php`,
  `ea-w209-legacy-301-redirects.php`, `block-faq-list.php` canonical links, `generate_lead` in `ea-ab-testing.js`,
  NAP/brand. Keep exactly one `<h1>` per page. Re-run SEO QA after each page.

# §H — Repo / branch / worktree state
- `main @ 89b294c` (validated trunk: Wave-1/1b + Phase-2 + mokesh + SEO Round-2). `chapters-home @ 4ad5b1c`
  (this work; pushed to origin). `legacy/full-git-history` (archival). No other branches.
- Worktrees: main dir = `EyalAmit.co.il-2026` [main]; design = `EyalAmit-design` [chapters-home]. 2 recoverable
  stashes hold transient QA artifacts (pre-consolidation).
- Local preview harness: `/tmp/ea_render2.php` (stub-WP render of any chapters template by type) + screenshots via
  headless Chrome (see this session's transcript). Mockups extracted at `/tmp/ea-mock/`.

# §I — Activation prompt
> You are **team_100 (Chief Architect)**, Claude Code, on EyalAmit.co.il-2026, in worktree `../EyalAmit-design`
> (branch `chapters-home`). Read THIS handoff + `_COMMUNICATION/team_00/DECISION_CHAPTERS_*` +
> `docs/CHAPTERS-CONTENT-DECISIONS-EYAL.md`. **Mission:** bring the WHOLE site to the Chapters design, fully
> complete (text 100% verbatim from the approved source SSoT + media), build ACF (Option B) across all pages, and
> run the full QA + external cross-engine validation — all ready for the Eyal meeting (not waiting for it). Use the
> Chapters engine (§B) to build each remaining page (§C) fast; obey the HARD content rule (§D, 100% or Nimrod-approved
> exception only); preserve the SEO machine (§G). Present every decision; when told "run", run to the next validation
> boundary then report. Deploy/merge/push only on Nimrod "מאשר/פוש". Un-deployed = not integrated.
