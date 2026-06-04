# Eyal feedback triage — 2026-06-04 (WhatsApp 14:23)

Maps Eyal's 9 points to status + action. Confirms the content-integrity audit (`CONTENT-INTEGRITY-AUDIT-2026-06-04.md`). Canonical source: `from-eyal/תוכן לאתר 25.5.26/` (latest, 2026-05-25).

| # | Eyal's point | Type | Status / finding | Action · owner |
|---|---|---|---|---|
| 1 | Per-page FAQ shows only **3 questions**; his docs have more | bug/feature | FAQ blocks truncated to 3 | Render all FAQ items per his source; team_10 |
| 2 | **Testimonials only 3** per page; wants **more + a left-right carousel** | feature | Truncated to 3; home has 1-up rotator (14-C) but not the requested multi-item L-R carousel; other pages static 3 | Build a moving testimonials carousel (more items) site-wide; team_35 design + team_10 |
| 3 | **Full FAQ page**: needs clear section separation + **top TOC menu** that jumps to sections (sound-healing/treatment/method/books…) | feature | Current FAQ nav unclear | Add anchored TOC + section dividers on `/faq`; team_35 + team_10 |
| 4 | **`/muzza`** content ≠ what he sent | content | **CONFIRMED 0%** vs `MUZZA.md` | Rewrite from `MUZZA.md`; team_10 |
| 5 | **3 books** (צבע בכחול / כושי בלאנטיס / וכתבת) didn't use his content | content | Likely same (sources exist: `eyal_tsva_FINAL.md`, `kushi_full.md`, `vekatavta.md`) | Rewrite each book-detail from source; team_10 |
| 6 | **Blog pagination broken** — pages 2/3/4/5 show no new content (only page 1) | **bug (P0)** | **CONFIRMED** — only ~12 unique posts across all pages; `/blog/page/N/` ignores `paged` (force-route renders page-1 query). 54 posts exist | Fix the blog archive paged query; team_10 (blog WP) |
| 7 | **`/eyal-amit` (About)** missing / full content in his docs | content | Renders **placeholder** elevated blocks (editorial-hero/intro/pillars/memorial/studio), NOT his About copy. **About source doc not in folder yet** — Eyal is adding it | Build from About source **once Eyal uploads it**; team_10 |
| 8 | **Mokesh page** invented content | content | Memorial currently uses `ומה היום.docx` (classified as *background*, not page copy) — ties to **H1**. Eyal says it's not what he sent | Confirm correct memorial source w/ Eyal (H1); rebuild; team_10 |
| 9 | **More pages not built**: stand, floor-stand, repair, tool-sales (+ re-review full doc list) | content/build | Sources EXIST in 25.5.26 (`buy didgeridoo.md`, `bags for didg.md`, `stend for hanging.md`, `stend for playing.md`, `build didg.md`) but pages **not built/wired** | Build the 5 shop/repair pages from source; team_10 |

## Operational flag — Drive sync is NOT working as Eyal assumes
Eyal: "תקיית הדרייב מסונכרנת לכם אוטומטית למקומי". **Reality on this Mac:** Google Drive is mounted (`~/Library/CloudStorage/GoogleDrive-nimrod@mezoo.co`) but **`My Drive` contains only `TikTrack`**, and `Shared drives` is empty. Eyal's folder (`drive/folders/1dQsLA5hhNVagXFSTdz2hs5ilkMLKfCsA`) is **"Shared with me"**, which Drive-for-Desktop does **not** sync to the local filesystem. So new uploads (e.g. the About page) will **not** appear automatically.
**Fix options:** (a) Eyal/Nimrod add the shared folder to "My Drive" (Add shortcut → it then syncs), or (b) keep the manual copy into the repo `from-eyal/` (refreshed today). Until then, we work from the repo copy + Eyal sends new docs explicitly.

## Recommended remediation — open **WP-W2-15 (Content reconciliation + fixes)**
Structure is locked & sound; this is content-fill + targeted fixes — no structural rework.
**Priority:** (P0 bugs first) blog pagination #6 → (content) method (0%) → muzza #4 + books #5 → treatment/sound-healing/lessons → faq #1+#3 → testimonials carousel #2 → about #7 (await doc) → mokesh #8 (await H1) → 5 missing shop pages #9. Each page: rewrite body from its 25.5.26 source → team_50 content-diff verify.

*team_100 — 2026-06-04.*
