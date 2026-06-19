# AOS HANDOFF — team_100 (Chief Architect) → fresh session · depth: FULL

**Engine:** team_100 (Claude Code) · **Generated:** 2026-06-16 · **Profile:** L0 spoke
**Repo:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026` · **Hub:** `/Users/nimrod/Documents/agents-os`
**git state:** `main @ ce99c80` (== origin/main; WP-W2-16 merged + pushed, dual-PASS) · planning branch
`roadmap/forward-planning-2026-06-16 @ 10cc220` (current; intake + LOD200 specs + this handoff) · theme live `1.4.13`.

> **WHY THIS HANDOFF EXISTS:** the prior session is context-full. Nimrod's directive (2026-06-16):
> *"לתעד את כל המידע החדש וההחלטות והמשימה המדויקת כפי שהוגדרה ולהכין aos_handoff 100 full לסשן חדש שיממש את כל
> העדכונים הדרושים."* This document IS that record. A fresh team_100 session executes §D. **No implementation was done
> this session beyond documentation** — the build work below is all yours.

---

## §A — What the prior session accomplished (state you inherit)
1. **WP-W2-16 (post-content completion, batches 16-A…F)** — built, staged, QA'd per batch, **dual-PASS** (team_50 PASS + team_190 v2 PASS), **merged to `main` (ce99c80)** and **pushed to origin**. Covers: hero muted full-length video loop (D-13=ב), testimonials carousel (D-14=א), FAQ topic-TOC, `/eyal-amit` canonical about + redirects (D-15=ב), mokesh memorial v1 (D-16), shop nav children.
2. **content-diff docx-parser bug FIXED on main (88160bd)** — per-`<w:p>` extraction (was `texts.join(' ')` splitting words across `<w:t>` runs). This is the authoritative gate; it now scores verbatim Hebrew correctly.
3. **Forward governance drafted (planning branch):** 4 LOD200 specs (`LOD200-SEO-GEO-OPTIMIZATION`, `-DESIGN-QA-UI-RESPONSIVE`, `-PRODUCTION-CUTOVER`, `-EYAL-DEPENDENT-COMPLETIONS`), a team_110 request for the hub actor-key + DB-migration enablement, and the canonical-ID mapping (WP-W2-* → SNNN-PNNN-WPNNN).
4. **Hub updated + live** (roadmap M5 in_progress, materials-needed cluster I).
5. **Eyal supplementary materials INGESTED + ANALYZED** → `INTAKE-EYAL-SUPPLEMENTARY-2026-06-16.md`; GA4 wired into `hub/data/analytics-config.json`; Eyal WhatsApp drafted (`MSG-TO-EYAL-WHATSAPP-OPEN-ITEMS-2026-06-16.md`).

---

## §B — The new materials + Nimrod's DECISIONS (canonical record)

### B.1 Materials received from Eyal (2026-06-16) — all already in repo
| Item | Path / value |
|---|---|
| **Mokesh FULL memorial doc** (72 paras — the complete page) | `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/מוקש דהימן – …1950-2020.docx` (Drive `…/document/d/14YpaQMmS_zfJ-oFqp5iBhw08V0ChuR8h`) |
| **FB testimonials doc** (48 testimonials, 3 categories) | `docs/.../from-eyal/תוכן לאתר 25.5.26/ממליצים מהפייסבוק.docx` (Drive `…/document/d/1ki6eWeZlf5hlmryLuoA8CiyO4s02wLip`) |
| **GA4** | `G-MRXESK7QJF` (already in `hub/data/analytics-config.json`) |
| **WhatsApp** | `+972524822842` (already == theme `EA_WAVE2_WHATSAPP_E164`) |

### B.2 DECISIONS (Nimrod, 2026-06-16) — these are LOCKED, implement them
- **D-MOKESH-REBUILD = REBUILD from exact content.** Rebuild the mokesh page from the FULL memorial doc, **verbatim** ("לבנות מחדש לפי התוכן המדויק"). The full doc *supersedes* `ומה היום.docx` (which is only its §"ומה היום").
- **D-SPELLING = always correct.** *"לתקן תמיד לאיות הנכון."* Standardize the brand to **`Jungle Vibes`** everywhere (Eyal's doc itself mixes `jungle vibes` ¶64 / `jungel vibes` ¶75; 16-E currently carries `jungel vibes` verbatim — fix it). **NB the verbatim↔spelling tension** (see §E.3).
- **D-TESTIMONIALS = integrate ALL + Eyal-review-options in hub.** *"לשלב הכול - ולרשום לאייל לבדוק ולהחליט אופציות בנושא - לרשום בהאב."* Integrate all 48; let Eyal review/choose via the hub.
- **D-FILM = embed the documentary from YouTube.** Nimrod: *"הסרט התיעודי - למה לא כל הסרט אמבד מיוטיוב?"* → embed at the mokesh page bottom. **URL provided 2026-06-16:** `https://youtu.be/kf4NKSdYi9E` (id `kf4NKSdYi9E`). **VERIFIED via oEmbed** — title *"MUKESH - The Art of Shanti Living | Official Trailer"*, channel **Kuthli Studio** (= קוטלי, Eyal/family's studio). ⚠ This is the **official TRAILER/promo**, NOT the full ~60-min film (which may not be public on YouTube). Eyal's memorial doc itself says to embed the *promo clip* at the bottom (¶41), so the trailer fits. **OPEN — surfaced to Nimrod:** embed this trailer [recommended; matches the doc] vs await a separate full-film link. Use `youtube-nocookie.com/embed/kf4NKSdYi9E`; VideoObject schema `name` = the verified title.

---

## §C — Mission for the fresh session
Implement every update the new materials + decisions require, through the normal lean gates + cross-engine dual-PASS,
then refresh the client hub to represent reality and hand the Eyal WhatsApp to team_00. **Present every question/decision
to Nimrod as part of the process** (his standing rule) — do not self-approve scope, deploys, pushes, or Eyal-facing sends.

---

## §D — Execution plan (the precise tasks)

### T1 — Mokesh page REBUILD (16-E v2) · [D-MOKESH-REBUILD, D-SPELLING, D-FILM] · BUILD
- **Renderer:** `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-14e.php` → `ea_w2_14e_render_memorial()` (hooked at `template_include` **priority 102**, which supersedes the editorial route at 101 — *do not* edit the editorial 'moksha' route in `wave2-w2-07.php`; that was the prior session's dead-end). Page: `/eyal-amit/mokesh-dahiman/`.
- **Content:** rebuild to the **full** memorial — all ~10 sections of the doc, **verbatim**: *מי היה מוקש דהימן · היכרות עם הדיג'רידו (סיפור הביטלס/רישיקש) · בית המלאכה ברישיקש · Dream-Time · קוטלי (הסטודיו) · הגשמת החלום · תפנית חדה (קורונה 2020) · פרידה · ומה היום · דברי הספד*. Bio intro + dates **1950–2020** (death 11.10.2020) are now real content (no longer placeholders). Family: אשתו אניטה, 4 בנים, בת גיני, נכדה פריטי.
- **Spelling (D-SPELLING):** render `Jungle Vibes` (fix the existing `jungel vibes`).
- **Film (D-FILM):** embed at the bottom (responsive 16:9, lazy, `youtube-nocookie.com/embed/kf4NKSdYi9E`). **URL:** `https://youtu.be/kf4NKSdYi9E` — VERIFIED as *"MUKESH - The Art of Shanti Living | Official Trailer"* (Kuthli Studio). ⚠ It is the **trailer/promo**, not the full film — consistent with Eyal's doc (¶41 "embed the promo clip"). Pending Nimrod's confirm (trailer-only vs a separate full-film link). Add a `VideoObject` JSON-LD (name = verified title, embedUrl, thumbnailUrl `https://img.youtube.com/vi/kf4NKSdYi9E/maxresdefault.jpg`) — also feeds the SEO/GEO video schema.
- **Photos:** sources = `_COMMUNICATION/team_40/legacy-media-index-50…/mirror/` (e.g. `2021/10/…rishikesh…`, `2024/08/mukesh-dhiman-…`) + Eyal's own footage — **selection/approval is Eyal's** (memorial sensitivity). Placeholders until approved.
- **Cache-bust:** bump `style.css` `Version:` (→ `1.4.14`).
- **Gate:** re-point the content-diff source for mokesh from `ومه היום.docx` to the **full** memorial doc (see §E.3 for the verbatim↔spelling handling), then `node scripts/qa/content-diff.mjs` must clear (sectionCov≥95, sentenceCov≥90, inventedSections=0); plus overflow + axe on the route.

### T2 — Testimonials: integrate all 48 · [D-TESTIMONIALS] · BUILD
- **Source:** `ממליצים מהפייסבוק.docx` — 48 testimonials in 3 categories matching the service pages: **טיפול בדיג'רידו · סאונד הילינג · שיעורי נגינה בדיג'רידו** (each = name + FB link + full quote).
- **Where the data lives now:** `ea_w2_07_fb_testimonials()` (FB Top-5) in `inc/wave2-w2-07.php`; the home 15-item set in `inc/wave2-stage-b.php`; service-specific via `ea_wave2_service_testimonials($slug)` in `inc/wave2-w2-04.php` (service pages render service-specific FIRST then FB-appended+deduped — **keep this order**; reversing it dropped /lessons/ to 75.68% last time, see §E.2).
- **Build:** curate a snippet per testimonial (full quotes are too long for the marquee), feed **per-category** testimonials to the matching service page carousel + a broad set to the home carousel. The carousel atom already exists: `template-parts/blocks/block-testimonials-carousel.php` + `assets/css/testimonials-carousel.css`.
- **Eyal-review (D-TESTIMONIALS):** record the full 48 + the curated selection as **options in the hub** for Eyal to confirm/adjust (a hub data file + a materials-intake surface). 
- **Gate:** content-diff must still clear on every service route (testimonials are additive; don't displace service-specific content).

### T3 — Analytics wiring · [GA4 received] · BUILD
- GA4 `G-MRXESK7QJF` is in `hub/data/analytics-config.json`. **Split** `ea_wave2_print_analytics_head()` so **GA4 fires independently of Clarity** (currently gated on BOTH being present). Clarity `project_id` still `__PENDING_EYAL__` — leave its block dormant. Folds into the SEO/GEO WP.

### T4 — Hub refresh (represent reality) · [Nimrod: "חובה לעדכן את האב הלקוח שייצג נכון את המידע"]
- `hub/data/materials-needed.json`: mark **I1 (testimonials), I3 (bio), I4 (dates)** received; keep/clarify **I5 (mokesh photos), I6 (spelling→done)**; **add** new pending: **Clarity ID, studio address+hours, YouTube film URL, mokesh-photos selection**, and the **testimonials-review options** (T2).
- `hub/data/roadmap.json`: reflect the mokesh-rebuild + testimonials + analytics progress under M5/M7.
- `hub/data/decisions.json` (if present): record D-MOKESH-REBUILD / D-SPELLING / D-TESTIMONIALS / D-FILM.
- Rebuild + targeted upload: `python3 scripts/build_eyal_client_hub.py` then upload `materials-intake.html` + `roadmap.html` (+ data) to `ea-eyal-hub` (see §E.4 toolchain). Verify live via FTP SIZE.

### T5 — Eyal WhatsApp (team_00 sends) · [Nimrod: "להכין לאייל הודעת וואטסאפ עם מה שפתוח ודחוף"]
- Draft is ready: `MSG-TO-EYAL-WHATSAPP-OPEN-ITEMS-2026-06-16.md` (urgent: YouTube film URL, mokesh photos, Clarity, address/hours; + testimonials selection in hub). **team_00 sends** — not team_100, not until Nimrod approves. Update it if T1–T4 change the open set.

### T6 — DB reconciliation + roadmap lock · [BLOCKED on team_110 actor key]
- Pending `REQUEST-TEAM110-HUB-API-KEY-AND-DB-MIGRATION-2026-06-16.md` returning the team_100 `X-Actor-Api-Key`. **Do NOT extract secrets from env/.env** (classifier-denied; do not work around — Nimrod's hard rule).
- On key arrival: run the **50-WP DB reconciliation** to canonical IDs (mapping in the team_110 request: Wave2 launch → `S002-P001-WP005…016`; program → `S003-P001-WP001…038`, with **WP-W2-16 → `S003-P001-WP032`**), **lock WP-W2-16 COMPLETE/LOD500_LOCKED**, and register the 4 forward WPs under **S004** (the LOD200 specs are written). Hub API: `http://100.125.98.56:8090`, writes need `X-Actor-Api-Key`. DB schema accepts only `SNNN-PNNN-WPNNN` or `NB-Vn-WP-*` (the prior 422/400 were WP-W2-* being schema-invalid).

### T7 — Forward WPs (S004) · after T1–T6
- Advance the LOD200 specs (SEO/GEO, Design-QA+Responsive, Production-Cutover, Eyal-Dependent) to LOD400 → build → dual-PASS. SEO/GEO absorbs T3 analytics. Cutover is Track B (gated on Eyal launch-blockers: analytics, NAP, mokesh final edit).

---

## §E — Context, gotchas, toolchain (read before building)

### E.1 Routing / theme
Child theme `ea-eyalamit` (GeneratePress parent). Blocks in `template-parts/blocks/`. Routing in `inc/wave2-w2-*.php` + `inc/wave2-stage-b.php` via `template_include` priorities (**102 mokesh memorial > 101 editorial**). Assets are `?ver={style.css Version}` → bump Version to cache-bust every deploy.

### E.2 Gate discipline (LESSON LEARNED)
**Run `scripts/qa/content-diff.mjs` after ANY content change — not just overflow+axe.** Last session a testimonials swap silently dropped /lessons/ content-coverage to 75.68% and was only caught two batches later. The authoritative pass: `gatePass = sectionCov≥95 AND sentenceCov≥90 AND inventedSections=0`. Gate normalizes geresh `׳` ≡ apostrophe `'` (content-diff.mjs ~L107). The docx parser fix (per-`<w:p>`) is on main.

### E.3 Verbatim ↔ spelling tension (DECIDE + SURFACE)
D-MOKESH-REBUILD says *verbatim*; D-SPELLING says *fix to `Jungle Vibes`*. The content-diff gate is verbatim against the source docx. After re-pointing the gate to the full memorial doc, the spelling-corrected token(s) will mismatch the source. Resolve by **normalizing `jungel`→`jungle` in the gate's normalizer** (cleanest — mirrors the geresh normalization) OR documenting an approved deviation. **Surface this to Nimrod** rather than silently choosing.

### E.4 Deploy + hub toolchain
- **Theme deploy (staging):** `python3 scripts/ftp_deploy_site_wp_content.py` (whole theme + mu-plugins → uPress staging over FTP/TLS; env via `scripts/upress_ftp_env.py`, `UPRESS_SFTP_HOST=ftp.s887.upress.link:21`).
- **Hub build+publish:** `python3 scripts/build_eyal_client_hub.py` → targeted upload to `ea-eyal-hub`. Verify with FTP `SIZE` (a flaky truncated READ once showed 48386 vs 59280 — confirm via SIZE, not READ length).
- **uPress FTP quirks:** transient timeouts happen; the outbound IP must be uPress-whitelisted (Nimrod opens new IPs on request — e.g. `147.235.79.250`, `79.177.137.188`). Live site/hub base: `http://eyalamit-co-il-2026.s887.upress.link` (hub at `/ea-eyal-hub/`).
- **DB writes when online:** API-only (Iron Rule #7), `X-Actor-Api-Key` per team. Application Passwords are HTTP-blocked on staging — use the documented credential locations, not mu-plugins (see `[[feedback_wp_staging_toolchain]]`).

### E.5 Source content extraction
Both new docx are real `.docx` (Word XML). To read verbatim text, extract per-`<w:p>` joining `<w:t>` runs (same logic as the content-diff fix) — naive `<w:t>` concatenation splits Hebrew words across runs. Mokesh photos also in the legacy-media mirror under team_40.

---

## §F — Standing rules (HARD — carry forward)
1. **Cross-engine builder ≠ validator** (Iron #1); **team_190 owns final validation** (#5); comms via `_COMMUNICATION/<team>/` artifacts (#6).
2. **No "ready"/"done" to Eyal until dual-PASS.** The Eyal message is **team_00's to send**, never team_100.
3. **Commit/push only when Nimrod explicitly asks.** Pushing to `main` needs explicit authorization ("מאשר פוש ומיזוג"-level) — the classifier blocks default-branch pushes otherwise, correctly.
4. **Do NOT extract secrets/keys from env/.env** — classifier-denied; do not work around. Route through the team_110 request.
5. **Present every question/decision to Nimrod as part of the process** ("כל שאלה או החלטה יש להציג לי"). Don't self-approve scope.
6. **File-links to Nimrod = clickable markdown only:** `[label](file:///Users/nimrod/Documents/Eyal%20Amit/…)` — full absolute path, spaces as `%20`, no bare/relative paths, no raw `file://` line alongside it. (`[[user_pref_file_links]]`)
7. Every new WP must be **LOD200-characterized per the canon** before build.

---

## §G — Activation prompt (paste to start the fresh session)
> You are **team_100 (Chief Architect)**, a Claude Code engine on the **EyalAmit.co.il-2026** WordPress rebuild (AOS L0
> spoke, repo `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`). Read this handoff
> (`_COMMUNICATION/team_100/HANDOFF_SELF_100_POST-INTAKE-IMPLEMENTATION_2026-06-16_v1.md`) and
> `INTAKE-EYAL-SUPPLEMENTARY-2026-06-16.md` in full. State `main @ ce99c80` (WP-W2-16 dual-PASS, merged+pushed); planning
> branch `roadmap/forward-planning-2026-06-16`. Execute **§D T1→T7**, honoring decisions **D-MOKESH-REBUILD / D-SPELLING
> / D-TESTIMONIALS / D-FILM** (§B.2) and the standing rules (§F). Start by **surfacing to Nimrod**: (a) the verbatim↔
> spelling resolution (§E.3), (b) the YouTube film URL gap (§D-T1), (c) a build order for T1–T4. Build on a feature
> branch, deploy to staging, **run content-diff + overflow + axe per change** (§E.2), then route through team_50 +
> team_190 dual-PASS before any merge/push (only on Nimrod's explicit approval). Then refresh the hub (T4) and hand the
> Eyal WhatsApp to team_00 (T5). Present every decision to Nimrod as part of the process.
