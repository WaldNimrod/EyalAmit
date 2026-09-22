---
id: ALIGN-SWEEP-DONE-2026-09-21
schema_version: aos_v1_team_messaging
type: DONE (team_10)
from: team_10
to: [team_100, team_110]
cc: [team_00]
date: 2026-09-22
status: DONE
theme: 1.5.106
worktree: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep
branch: build/s007-align-sweep
validate: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-VALIDATE-2026-09-21.md
---

# Align-sweep DONE

אונבורד צוות 10 הושלם. Worktree: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep`. Home `/` not edited.

Map: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-MAP-2026-09-21.md`  
Patterns: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-2026-09-21.md`  
Validate (gpt-5.2 ≠ builder): `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ALIGN-SWEEP-PATTERNS-VALIDATE-2026-09-21.md` — **PASS**  
JSON: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/tmp/qa/align-sweep/`

FTP from worktree: `--allow-dirty "align-sweep on isolated 1.5.105 baseline"`. Theme **1.5.106**. No commit. No `git add -A`.

---

## Implemented (VALIDATE PASS)

### P-BLOG-SINGLE — deleted class `ea-wave2-blog-single` from Chapters `main`

- PHP: `tpl-chapters-blog-single.php` → `<main class="chapters-main">`
- CSS: removed `max-width: var(--ea-prose-width)` / auto-margin / padding cage on `.ea-wave2-blog-single`
- N: 52 live posts
- Why canon: dual class put Wave2 960 on the same `main` as Chapters wrap/phero. `classList.remove` already released 960→1440 / wrap 896→1200 / phero 896→1440 without a third wrapper.

`/2228-2/` live after FTP @1440:

| metric | before | after | canon |
|---|---:|---:|---:|
| main class | `chapters-main ea-wave2-blog-single` | `chapters-main` | chapters-main |
| mainW / max | 960 / 960px | 1440 / none | 1440 / none |
| wrap | 896 | 1200 | 1200 |
| phero | 896 | 1440 | 1440 |
| H1 | 786.6 start | 786.6 start | 32ch start |

Second URL (women/didgeridoo post): same after numbers. overflow 390 = 0. Class gone from DOM.

### P-POST-66CH — `.ea-post-content` 66ch → 82ch

- CSS only: `max-width: 82ch; margin-inline: auto` (same as `.intro-body` / `.prose`)
- Proof it was separate: after dual-class remove, post stayed 624. After FTP: **775.3**. Mobile 390: post **294** (same as snoring intro inner).

### P-BLOG-ARCHIVE — deleted class `ea-wave2-blog-archive` from Chapters `main`

- PHP: `tpl-chapters-blog-archive.php` → `<main class="chapters-main">`
- CSS: removed `max-width: var(--ea-content-width)` cage
- `/blog/` after @1440: main 1440 none, wrap 1200, phero 1440. Class gone. overflow 390 = 0.

---

## Home `/` regression

GET `/` before vs after (CDP 1440 + 390). **Unchanged.**

| metric | before | after |
|---|---:|---:|
| desktop wrap | 1200 | 1200 |
| desktop intro | 775.3 | 775.3 |
| desktop H1 | 716.5 center | 716.5 center |
| mobile wrap / intro / H1 | 390 / 294 / 310 center | 390 / 294 / 310 center |
| overflow | 0 | 0 |

No edit to `tpl-chapters-home.php` / `section-home-*`.

Baseline: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/tmp/qa/align-sweep/home-baseline.json`  
After: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-align-sweep/tmp/qa/align-sweep/after-ftp.json`

---

## Rejected at VALIDATE (not implemented)

| id | why |
|---|---|
| P-PRESS | `classList.remove('ea-wave2-editorial')` did not release; no wrap. Inventing Chapters would be new layout. |
| P-GP | `site-main` 820, no dual Wave2 class. `/services/` is HTTP 404. |
| P-FAQ-820 | already `chapters-main` full 1440; 820 is a local list, not a hero cage. |
| P-60CH-LEAD | lives on the locked snoring page; home-lede risk. |
| P-ORPHAN-PROSE | leftover `--ea-prose-width` / 65ch on unused Wave2 sheets + press. |
| P-TYPE-BLOG-H3 | `font: var(--ea-type-h3)` = 15.3px, not a width cage. |

---

## Still open (explicit)

- `/press/`, `/historical-articles/`, `/shows-heritage/`, `/faq/` 820, GP 820 — not dual-class cages.
- `--ea-prose-width: 960px` token still declared; no longer applied to live Chapters `main`.
- Legacy `tpl-blog-single.php` / `tpl-blog-archive.php` still carry Wave2 classes but are not the winning router (priority 105 → Chapters templates).
- Two TSV posts 301 to `/blog/` (already merged). QR permalinks untouched. L1 untouched.
- New post template (`POST-TEMPLATE-SETTINGS.md`) still waiting team_00.

---

## Classes deleted after live proof

1. **`ea-wave2-blog-single`** from live Chapters post `main` (52 URLs)
2. **`ea-wave2-blog-archive`** from live `/blog/` `main`
