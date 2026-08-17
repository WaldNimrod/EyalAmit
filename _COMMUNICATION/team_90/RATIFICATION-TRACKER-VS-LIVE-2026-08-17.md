# RATIFICATION — tracker vs live — PASS_WITH_FINDINGS

Measured 2026-08-17 against `http://eyalamit-co-il-2026.s887.upress.link` (`curl -k`, no `-L`, `--max-time 8`). Source: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest.csv](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/latest.csv)

## 1. Sheet row counts — PASS
- `סבב-1-ליבה` = **29** (expected 29)
- `סבב-2` = **129** (expected 129)
- total data rows = **158** (2 sheets only)

## 2. Round-1 live HTTP — PASS
- URL rows (path starts with `/`): **28** probed
- ignored non-URL: **1** — R1-29 `(תפריט) קורסים`
- **200: 28 / 28**
- not-200: **none**

## 3. Testimonials path + `/media/` — PASS
- R1-26 `נתיב` field = `/testimonials/`
- `/testimonials/` → **200**
- `/media/` → **301**

## 4. Round-2 spot-check (first 15 + last 15) — PASS
- probed: **30**
- **200 or 301: 30 / 30** (200=21, 301=9)
- 404 or 5xx: **none**
- first-15 301s (expected legacy redirects): `/courses-soon/`, `/hashita/`, `/muzeh/`, `/muzeh/kushi-blantis/`, `/muzeh/tsva-bechol-ve-zorek-layam/`, `/muzeh/vekatavt/`, `/muzza/`, `/muzza/tsva-bechol-ve-zorek-layam/`, `/muzza/vekatavt/`
- last-15 (`/qr/qr4/` … `/qr/qr9/`): **15/15 = 200**

## 5. Working tree — FINDING
- `git status --porcelain` is **not empty**
- 1 line: ` M scripts/run_cross_engine_validator.sh`

Tracker vs live: no HTTP mismatches in the measured set. Sole finding is the dirty tree (unrelated to path/status).Tracker vs live is **PASS_WITH_FINDINGS**.

Rounds 1–2 match the CSV (29 + 129). All 28 round-1 URL paths returned **200**. `/testimonials/` is **200**; `/media/` is **301**. The 30 round-2 spot-checks were all **200 or 301** (no 404/5xx).

The only finding: the working tree is dirty — `scripts/run_cross_engine_validator.sh` is modified.
