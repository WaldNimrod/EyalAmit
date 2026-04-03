#!/usr/bin/env python3
"""Validate hub/data/updates.json item dates against the real calendar.

Uses Asia/Jerusalem as project default. Exits with code 1 if any update date
is strictly after "today" (catches common model typos / wrong session year).

Optionally reads hub/data/calendar-anchor.txt: warns if the anchor date lags
behind today (stale file) or is in the future relative to today.

Usage (repo root):
    python3 scripts/check_hub_calendar.py
"""

from __future__ import annotations

import json
import sys
from datetime import date, datetime
from pathlib import Path
from zoneinfo import ZoneInfo

TZ = ZoneInfo("Asia/Jerusalem")


def hub_data_dir() -> Path:
    return Path(__file__).resolve().parent.parent / "hub" / "data"


def parse_anchor_last_iso(anchor_path: Path) -> date | None:
    if not anchor_path.exists():
        return None
    body = anchor_path.read_text(encoding="utf-8")
    candidates: list[str] = []
    for raw in body.splitlines():
        line = raw.strip()
        if not line or line.startswith("#"):
            continue
        candidates.append(line)
    if not candidates:
        return None
    return date.fromisoformat(candidates[-1])


def main() -> int:
    ddir = hub_data_dir()
    updates_path = ddir / "updates.json"
    anchor_path = ddir / "calendar-anchor.txt"
    today = datetime.now(TZ).date()

    if not updates_path.exists():
        print(f"[ERROR] Missing {updates_path}", file=sys.stderr)
        return 1

    anchor = parse_anchor_last_iso(anchor_path)
    if anchor is not None:
        if anchor < today:
            print(
                f"[WARN] calendar-anchor.txt ends with {anchor}, today is {today} — bump the last ISO line.",
                file=sys.stderr,
            )
        elif anchor > today:
            print(
                f"[WARN] calendar-anchor.txt ends with {anchor}, after today {today}.",
                file=sys.stderr,
            )

    data = json.loads(updates_path.read_text(encoding="utf-8"))
    bad: list[tuple[str, str, str]] = []
    for item in data.get("items", []):
        ds = item.get("date", "")
        iid = str(item.get("id", "?"))
        try:
            d = date.fromisoformat(ds)
        except ValueError:
            bad.append((iid, ds, "not YYYY-MM-DD"))
            continue
        if d > today:
            bad.append((iid, ds, f"after today ({today}, {TZ.key})"))

    if bad:
        print(
            "[ERROR] hub/data/updates.json has item date(s) after today's calendar date:",
            file=sys.stderr,
        )
        for iid, ds, msg in bad:
            print(f"  {iid} date={ds!r} ({msg})", file=sys.stderr)
        return 1

    print(f"[OK] Hub update dates ≤ {today} ({TZ.key})")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
