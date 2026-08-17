# REVIEW — HANDOFF-TEMPLATE-GENERIC — LENS A (operational truth) — PASS_WITH_FINDINGS

Repo root used: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`. AOS health: `db.status=online`. Builder of the doc was Claude; this pass is Grok/Cursor.

## Claim-by-claim

- `HANDOFF-CURRENT-S006.md` exists — **CONFIRMED** as `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md`. **REFUTED** as a repo-root basename (`MISSING` from CWD).
- `S006-MILESTONE-CHARTER.md` exists — **CONFIRMED** at `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md`. **REFUTED** as a repo-root basename.
- `CODE-BLOCKED-REGISTER.md` exists — **CONFIRMED** at `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/CODE-BLOCKED-REGISTER.md`. **REFUTED** as a repo-root basename.
- `EA-CONTENT-TRACKER.xlsx` in the synced folder exists — **CONFIRMED** on disk: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx` (55170 bytes, 17 Aug 20:19). Gitignored via `.gitignore:66` `/EyalAmit_Site_GoogleDrive_Sync/`. Template does **not** name that folder (CURRENT/charter do).
- `_aos/roadmap.yaml` — **CONFIRMED** at repo root. `project.notes` end (lines 229–265) is the S006 freeze note.
- `python3 scripts/tracker_guard.py --mode ingest` — **CONFIRMED**. Exit 0: `PASS · 158 שורות · 0 חדשות` / `אין קלט אנושי חדש.`
- `python3 scripts/tracker_update.py --refresh-waiting` — **CONFIRMED**. Exit 0: `«ממתין ל» רוענן — 0 שורות השתנו`.
- `git status --porcelain` must be empty — **CONFIRMED** as a working check; this tree was empty before and after the read-only/refresh/snapshot runs.
- Stage 1 = 29 rows — **CONFIRMED**. `latest.csv` and the live xlsx: `סבב-1-ליבה` R1-01..R1-29 (29 unique keys).
- Stage 2 = 129 rows — **CONFIRMED**. `latest.csv` and the live xlsx: `סבב-2` R2-001..R2-129 (129 unique keys). Types: 54 פוסט, 49 QR, 14 עמוד, 12 legacy/301.
- `WP-S6-01` — **CONFIRMED** in `_aos/roadmap.yaml` L3050 (`status: IN_PROGRESS`, label cites 29 rows).
- `WP-S6-02` blocked on stage 1 — **CONFIRMED** L3075–3090 (`status: PLANNED`, `blocked_by: WP-S6-01`).
- Stage 3 = `S007` as a separate milestone — **CONFIRMED** as a name in `project.notes` L230/L254 and `S002-P001-WP004.milestone_ref: S007`. **REFUTED** as a first-class YAML object: no `- id: S007` anywhere under `_aos/`.
- `tracker_page_tab.py --create <ROW> --items items.json` — **CONFIRMED** flags exist (`--create`, `--items`). Incomplete if typed without `python3 scripts/` or without a real ROW/JSON.
- `python3 scripts/ftp_deploy_site_wp_content.py` — **CONFIRMED** script exists. `--help` and `--dry-run` exit 0 (dry-run listed theme + mu-plugins; no upload). Bare invoke **would deploy** — the template does not say `--dry-run`.
- `--update` · `tracker_update.py` · `--mode verify` · `tracker_snapshot.py` (א.4 §7) — **CONFIRMED** as pieces: `tracker_page_tab.py --update PAGE ITEM`, `tracker_update.py`, `tracker_guard.py --mode verify` (exit 0: `PASS · 158 שורות`), `python3 scripts/tracker_snapshot.py` (exit 0: 158 rows / 23 items). **REFUTED** as typed: `--update` and `--mode verify` are not standalone commands.
- `tracker_page_tab.py --hide <ROW>` — **CONFIRMED** flag exists. Not executed.
- `tracker_page_tab.py --list` — **CONFIRMED**. Exit 0: `עמוד · בית [visible]` and `עמוד · המלצות — קטלוג מרכזי (ומ [visible]`.
- א.8 `tracker_guard.py --mode verify` + `tracker_snapshot.py` (no `python3 scripts/`) — **REFUTED**. From repo root: `command not found: tracker_guard.py` / `command not found: tracker_snapshot.py`.
- `agents-os/core/config/routing_policy.yaml` — **CONFIRMED** on the sibling hub: `/Users/nimrod/Documents/AOS_V5/agents-os/core/config/routing_policy.yaml`. **REFUTED** from this repo: `agents-os/core/config/routing_policy.yaml` is MISSING; the working relative path is `../agents-os/core/config/routing_policy.yaml`.
- `routing_policy.py::resolve()` — **CONFIRMED** at `/Users/nimrod/Documents/AOS_V5/agents-os/core/modules/management/routing_policy.py` L193 `def resolve(`. Template gives no path.
- `cursor-agent --list-models` — **CONFIRMED**. Binary `/Users/nimrod/.local/bin/cursor-agent`; command runs.
- Named Cursor bank `auto` / `composer` / `grok` — **auto PRESENT**; **composer-2.5 PRESENT** (also `composer-2.5-fast`); **`grok` ABSENT** (family is `cursor-grok-4.5-*` / `cursor-grok-4.6-*`).
- Validator candidates Grok / Composer / Gemini — **CONFIRMED** as families (`cursor-grok-*`, `composer-2.5`, `gemini-3.7-flash-high` and other gemini ids).
- Decisive GPT-5.x / Opus — **CONFIRMED** as families (`gpt-5.1`…`gpt-5.6-*`, many `claude-opus-*`).
- “Never a `-fast` variant” — **CONFIRMED** that `-fast` ids exist (`composer-2.5-fast`, `cursor-grok-4.5-high-fast`, many others).
- routing_policy.yaml model ids vs `cursor-agent --list-models`: **PRESENT** `cursor-grok-4.5-high`, `composer-2.5`. **ABSENT as exact ids** `claude-opus-4-8`, `gpt-5.5`, `claude-sonnet-4-6` (suffix/parameterized forms exist; tip mentions `claude-opus-4-8[context=1m,effort=high,fast=false]`).
- uPress IP link `https://my.upress.co.il/account/websites/eyalamit-co-il-2026.s887.upress.link?tab=development` — **CONFIRMED** well-formed; `curl -sI` → HTTP/2 302 `location: https://my.upress.co.il/account` (login). Hostname matches staging. That `tab=development` is the IP-allowlist control — **not verified** (unauthenticated).
- Staging URL — **not stated** in this template. Live check of the hostname in that link: `http://eyalamit-co-il-2026.s887.upress.link/` → HTTP 200. `https://` → curl rc 60 `SSL certificate problem: certificate has expired`; `-k` → HTTP/2 200. TLS-expired-by-design — **CONFIRMED**.
- mu-plugin “script enumerates files one-by-one; add to the list” — **CONFIRMED**. `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/ftp_deploy_site_wp_content.py` hardcodes each mu-plugin (L56–159).
- `qa_probe` fails **OPEN** and “only checks horizontal overflow” — **REFUTED**. `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` verdict is `PASS`/`FAIL` (L137); it also fails on forbidden substrings and empty title (L13–17, L36).
- `--mode plan`/`ask` do not run shell; `AOS_VALIDATOR_MODE` is file-analysis only — **CONFIRMED** against `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/run_cross_engine_validator.sh` L46–51.
- Bump `Version` in `style.css` — file has `Version: 1.5.9`. Cache-bust effect — **not independently verified**.
- Carousel prints every card twice — **not verified** this pass.
- FTP timeout = IP lock — **not verified** this pass (no timeout reproduced).

## Findings

1. **major — א.1 L38–43.** Four of five “open this file” names are basenames. From the mandated workspace root they do not exist. Sibling `HANDOFF-CURRENT-S006.md` already uses repo-root paths (`_COMMUNICATION/team_100/S006/...`, `EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`). A session that `cd`s into S006 to open the files then breaks א.2 (`python3 scripts/...`). No single CWD satisfies both blocks as written.
2. **major — א.8 L122.** Close-session commands are bare `tracker_guard.py` / `tracker_snapshot.py`. Literal run: `command not found`. א.2 has the working form.
3. **major — א.4 L73–80.** Cycle steps are fragments (`--create`, `--update`, `--mode verify`), not copy-pasteable commands. `--update` needs `PAGE_KEY ITEM_KEY`. `--mode verify` is `tracker_guard.py`, not `tracker_update.py`.
4. **major — א.7 L111.** `agents-os/core/config/routing_policy.yaml` does not resolve from this repo. Required: `/Users/nimrod/Documents/AOS_V5/agents-os/core/config/routing_policy.yaml` or `../agents-os/core/config/routing_policy.yaml`.
5. **major — א.7 L111–115.** Policy file ids `claude-opus-4-8`, `gpt-5.5`, `claude-sonnet-4-6` are **not** exact `cursor-agent --list-models` ids. Template says “read live ids, don’t hardcode,” then points at a file whose ids don’t match the live list. Exact id `grok` is absent.
6. **minor — א.3 L64.** `S007` is a note + `milestone_ref`, not a roadmap object. A session grepping `- id: S007` will find nothing.
7. **minor — א.6 L97.** `qa_probe` / `OPEN` / “overflow only” is wrong vs the runner. Copied into every validator brief, it will hide title/forbidden-text failures and invent a status the tool does not emit.
8. **minor — א.4 L78.** Bare `python3 scripts/ftp_deploy_site_wp_content.py` deploys. Fine as the real step; a fresh session has no `--dry-run` guard in the template (only this review was told to use it).
9. **minor — א.6 L106–107.** uPress URL is well-formed and 302s to login. Template never gives the staging site URL a session needs for QA (`http://eyalamit-co-il-2026.s887.upress.link`).

## Could not verify

- That `?tab=development` is the IP-allowlist control (login wall).
- Ingest semantics as “the work list” beyond this run’s `0 חדשות`.
- Carousel double-render; CSS `Version` cache-bust; FTP timeout ⇒ IP lock.
- Whether `items.json` shape is documented anywhere the template points to (template does not show a schema).
- `cursor-agent` `--mode plan`/`ask` shell lock, except as stated in `run_cross_engine_validator.sh` comments (not re-probed live).

**Fix before reuse:** give every path from repo root (copy CURRENT’s table); prefix every script with `python3 scripts/`; write full `--create`/`--update`/`--mode verify` lines; point routing at `../agents-os/core/config/routing_policy.yaml` and tell sessions to copy **live** `cursor-agent --list-models` ids, not the YAML’s stale slugs.
