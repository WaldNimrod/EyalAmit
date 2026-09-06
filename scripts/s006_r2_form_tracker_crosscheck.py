#!/usr/bin/env python3
"""Bidirectional S006 Round-2 form ↔ tracker snapshot cross-check."""
from __future__ import annotations

import argparse
import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent))
from s006_review_form import (  # noqa: E402
    NEED_STATUSES,
    ROUND2_SHEET,
    SNAPDIR,
    _cell,
    _read_csv,
    is_action_item,
    load_r2_model,
)

REPO = Path(__file__).resolve().parent.parent


def _sets_report(label: str, left: set[str], right: set[str]) -> list[str]:
    missing = sorted(left - right)
    extra = sorted(right - left)
    lines = []
    if missing:
        lines.append(f"FAIL {label}: missing in form ({len(missing)}): {missing[:20]}")
    if extra:
        lines.append(f"FAIL {label}: extra in form ({len(extra)}): {extra[:20]}")
    if not missing and not extra:
        lines.append(f"PASS {label}: {len(left)} ↔ {len(right)}")
    return lines


def run_check(*, html_path: Path | None = None) -> tuple[int, str]:
    model = load_r2_model()
    pages_rows = [r for r in _read_csv(SNAPDIR / "latest.csv") if r.get("__sheet__") == ROUND2_SHEET]
    items_rows = [r for r in _read_csv(SNAPDIR / "latest-items.csv") if _cell(r, "__page__").startswith("R2-")]

    tracker_all = {_cell(r, "#") for r in pages_rows if _cell(r, "#")}
    tracker_submitted = {
        _cell(r, "#") for r in pages_rows if _cell(r, "סטטוס מכונה") == "הוגש לבדיקה"
    }
    tracker_eyal = {
        f"{_cell(r, '__page__')}/{_cell(r, '#')}"
        for r in items_rows
        if is_action_item(r, waiter="אייל")
    }
    tracker_nimrod = {
        f"{_cell(r, '__page__')}/{_cell(r, '#')}"
        for r in items_rows
        if is_action_item(r, waiter="נימרוד")
    }
    tracker_wait_any = {
        f"{_cell(r, '__page__')}/{_cell(r, '#')}"
        for r in items_rows
        if _cell(r, "סטטוס סעיף") in NEED_STATUSES and _cell(r, "הכרעה נדרשת מ") in {"אייל", "נימרוד"}
    }

    form_pages = {p["key"] for p in model["pages"]}
    form_all = {p["key"] for p in model["allPages"]}
    form_eyal = {it["id"] for it in model["needItems"]}
    form_nimrod = {it["id"] for it in model["nimrodItems"]}

    lines: list[str] = []
    lines.extend(_sets_report("submitted pages", tracker_submitted, form_pages))
    lines.extend(_sets_report("all R2 rows in sitemap", tracker_all, form_all))
    lines.extend(_sets_report("waiting Eyal items", tracker_eyal, form_eyal))
    lines.extend(_sets_report("waiting Nimrod items", tracker_nimrod, form_nimrod))

    orphan_wait = sorted(tracker_wait_any - (tracker_eyal | tracker_nimrod))
    if orphan_wait:
        lines.append(f"FAIL waiting items not classified: {orphan_wait}")
    else:
        lines.append(f"PASS every waiting human item is Eyal or Nimrod ({len(tracker_wait_any)})")

    if html_path and html_path.is_file():
        html = html_path.read_text(encoding="utf-8")
        html_fail = []
        if 'class="s006-sitemap"' not in html:
            html_fail.append("missing sitemap")
        if "לפי התפריט החי" not in html:
            html_fail.append("sitemap not grouped by live menu")
        if "s006-sitemap__card" not in html:
            html_fail.append("missing card links in tree")
        if "s006-sitemap__live" not in html:
            html_fail.append("missing live-page icons in tree")
        if "s006-backtop" not in html:
            html_fail.append("missing back-to-top")
        for rnd in ("s006-round--1", "s006-round--2", "s006-round--3"):
            if rnd not in html:
                html_fail.append(f"missing {rnd}")
        if "s006-round-legend" not in html:
            html_fail.append("missing round legend")
        if 'id="nimrod-decisions"' not in html and tracker_nimrod:
            html_fail.append("missing Nimrod section")
        if 'class="s006-chapters"' not in html:
            html_fail.append("missing chapter accordions")
        for key in sorted(form_pages):
            if f'id="page-{key}"' not in html:
                html_fail.append(f"missing page-{key}")
            if f'id="pagefile-{key}"' not in html:
                html_fail.append(f"missing pagefile-{key}")
        for it in model["needItems"]:
            if f'id="item-{it["domId"]}"' not in html:
                html_fail.append(f"missing item {it['id']}")
        for it in model["nimrodItems"]:
            if f'id="item-{it["domId"]}"' not in html:
                html_fail.append(f"missing nimrod item {it['id']}")
        if 'storageKey": "ea-s006-r2-review-v2"' not in html and "ea-s006-r2-review-v2" not in html:
            html_fail.append("missing R2 storage key v2")
        if html_fail:
            lines.append(f"FAIL HTML ({len(html_fail)}): {html_fail[:25]}")
        else:
            lines.append(
                f"PASS HTML {html_path.name}: sitemap + chapters + {len(form_pages)} pagefile + "
                f"{len(form_eyal)} Eyal items + {len(form_nimrod)} Nimrod items"
            )
    elif html_path:
        lines.append(f"FAIL HTML missing: {html_path}")

    failed = any(x.startswith("FAIL") for x in lines)
    report = "\n".join(lines)
    return (1 if failed else 0), report


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument("--html", type=Path, default=REPO / "hub" / "dist" / "s006-r2-review.html")
    args = ap.parse_args()
    rc, report = run_check(html_path=args.html if args.html else None)
    print(report)
    return rc


if __name__ == "__main__":
    raise SystemExit(main())
