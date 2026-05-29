---
id: INFO-HANDOFF-TO-W2-04-SESSION-2026-05-29
from_team: team_100 (Chief System Architect — W2-03 session)
to_team: team_100 (next session — W2-04)
wp: WP-W2-04 — Sound Healing + Lessons (2 service pages)
date: 2026-05-29
status: READY TO DISPATCH
---

# Handoff → WP-W2-04 session

WP-W2-03 is **CLOSED** (COMPLETE / LOD500_LOCKED; team_190 L-GATE_VALIDATE PASS) and **merged to main** (`fa70059`). This handoff seeds the next WP in the Wave2 loop.

## Git state (already set up for you)
- main @ `fa70059` (W2-03 merge). **main is 10 commits ahead of origin — not pushed** (team_00 hasn't requested push).
- Branch **`feature/w2-04-services`** created off main.
- Isolated worktree: **`/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-04`** — run ALL W2-04 work there. The shared `EyalAmit.co.il-2026` tree stays on main.
- `local/.env.upress` already copied into the worktree (gitignored — never commit it).

## What to build (spec: `_aos/work_packages/S002/WP-W2-04/LOD400_spec.md`, lod_status LOD400)
- 2 pages on **`tpl-service.php`** (reuse W2-02 infra): `/sound-healing` (source `סאונדהילינג/sound_healing_final.md`), `/lessons` (source `שיעורי נגינה/lesons.md`).
- Block contract (each, 10): hero · what-it-is · how-it-works/benefits · who-it's-for · FAQ (view-only, filtered to page category) · testimonials (Top-5 + accordion; text+image+link, image=placeholder until W2-07) · CTA (A/B variant).
- Route via slug `template_include` router — extend W2-02 pattern or add `inc/wave2-w2-04.php`; set `ea_wave2_shell`; `ea-wave2-shell` body class; D-14 tokens (NO raw hex — use `--ea-*`, incl. new `--ea-on-dark`); coordinate next `style.css` version slot (W2-03 left it at 1.4.2 → use 1.4.3).
- **A/B CTA (F01, from W2-01 `ea-ab-testing.js`):** variant_A=form only; B=form+WhatsApp; C=WhatsApp only. form → `/contact?subject=<page-slug>`; WhatsApp → `https://wa.me/972524822842`. GA4 `cta_click` {variant_label, page}. All three wired; random per-session assignment live.

## Acceptance criteria (gate against)
AC-01 2 URLs 200 · AC-02 H1+body 1:1 with 25.5.26 source · AC-03 FAQ filter = page category only · AC-04 testimonials text+image+link (placeholder OK until W2-07) · AC-05 every CTA active (form+WhatsApp per A/B) · AC-06 validate_aos 0 FAIL + mobile responsive.

## Dependencies / carry-forwards
- depends_on WP-W2-02 (COMPLETE — `tpl-service.php` exists). Soft-dep WP-W2-07 (final testimonial images) — **non-blocking**: placeholders OK for BUILD; for VALIDATE, placeholders OK only if W2-07 still open (declared carry-forward), else final images required.
- No W2-04 team_10 mandate authored yet — author one (mirror `MANDATE-TEAM10-W2-03-BOOKS`) before/at dispatch.

## The loop (same as W2-03)
build (team_10 Claude sub-agent) → deploy via `scripts/ftp_deploy_site_wp_content.py` (cache-bust `?cb=$(date +%s)$RANDOM`) → **L-GATE_BUILD team_50 (NON-Claude)** → **L-GATE_VALIDATE team_190 (native Codex)** → canonical checks → closure (roadmap COMPLETE/LOD500_LOCKED, team_191 archive, merge on team_00 go) → re-handoff to **WP-W2-05**.

## Standing team_00 directives (carry forward — DO NOT drop)
1. **Fix what you find** — remediate findings yourself, don't just flag (e.g. W2-03 F-W2-03-01 hex fix).
2. **Always present team_00 a paste-ready dispatch prompt** for the team_50 + team_190 non-Claude gate sessions.
3. Commit surgically by file — **never `git add -A`**. IR#1 cross-engine chain is immutable.

## ⛔ PRECONDITION #1 — Resolve the roadmap-mutation infra gap BEFORE closing W2-04
**Two distinct servers — do not conflate:**
- **uPress** (`eyalamit-co-il-2026.s887.upress.link`) — hosts the live/staging **WordPress site** (the product). Deploy via FTP (`scripts/ftp_deploy_site_wp_content.py`). This is the ONLY place Eyal's website needs to live.
- **Home server `waldhomeserver`** (Tailscale `100.125.98.56`) — runs **AOS governance infra only**: the API (port 8090) + Postgres DB-as-SSoT (port 5434). It governs ALL spokes' roadmap/gate state. It does **NOT** host Eyal's website and does not need the site content.

**The gap:** hub `_aos/projects.yaml` registers eyalamit with `local_path: /Users/nimrod/.../EyalAmit.co.il-2026` (this Mac) and `server_path: /data/projects/eyalamit` **marked "unverified — team_60 verifies during build"** — i.e. the server-side checkout was **never created**. So when the DB-as-SSoT API runs `deploy_cascade()` to write `roadmap.yaml` back, it can't find the project root on the server, and `GET /api/l0/eyalamit/roadmap` → 404 "Project root not found". The local API (`127.0.0.1:8090`) is a retired 410 stub.
**Why this matters:** IR#7/ADR034 require API-only structured mutations when DB online; right now that's impossible for this spoke, so W2-02/06/03 all closed via the ADR034 offline-fallback (direct `roadmap.yaml` edit on a named branch).
**Action for next session (precondition to W2-04 closure):** open with team_00 + team_60 to decide ONE of:
(a) team_60 creates + keeps-in-sync the `/data/projects/eyalamit` server checkout (verify `server_path`), OR
(b) point the API at the Mac `local_path` over Tailscale, OR
(c) formally ratify the offline-fallback (named-branch file edit) as the canonical path for this Mac-only spoke and update CLAUDE.md/ADR034 accordingly.
Until decided, continue the offline-fallback for W2-04 closure (precedent W2-02/06/03) — but **must be closed at session start**.

## ⛔ PRECONDITION #2 — Close the AC-05 source-spelling decision BEFORE building W2-04
**What it is:** AC-05 requires page copy to match Eyal's 25.5.26 source `.md` files **1:1 verbatim**. Those sources contain inconsistent/likely-erroneous spellings, now reproduced LIVE on the W2-03 book pages (closed verbatim). Concrete flagged items in `inc/wave2-w2-03-content.php`:
- **היקוקומורי vs היקוקמורי** (line ~59) — same word (hikikomori), spelled two ways in one paragraph.
- **"השארו עמי"** (line ~54) — likely typo for **"הישארו עמי"**.
- (Varanasi "וראנסי" is consistent — no issue.)
**What the approval means:** editing an author's published text is editorially sensitive — that's why the spec says *flag, don't fix without approval*. The decision (logged as aos_decide):
- **A) Keep strictly verbatim** — preserve Eyal's exact text incl. inconsistencies; matches source 1:1; lowest risk; any typo stays live. (Current state; both gates PASSED this way.)
- **B) Normalize obvious typos** — team corrects clear errors (e.g. הישארו עמי; unify היקוקומורי), deviating from strict 1:1 to improve quality; ideally confirm each item with Eyal.
**Action for next session:** this decision must be **resolved at session start** and applied retroactively to W2-03 pages if B is chosen (redeploy + re-verify), and prospectively to W2-04 copy. Carry team_00's aos_decide verdict into the W2-04 build mandate. team_00 was presented this as an aos_decide on 2026-05-29 — record the answer here before building.

*team_100 (W2-03 session) — 2026-05-29*
