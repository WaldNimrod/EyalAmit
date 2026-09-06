#!/usr/bin/env python3
"""
tracker_snapshot.py — write the git-tracked audit trail of EA-CONTENT-TRACKER.xlsx.

The xlsx in the Drive-synced folder is the SSOT and is gitignored. This script
mirrors it to CSV inside the repo so that:
  · every session leaves a diffable record of what changed and who changed it,
  · tracker_guard.py has a baseline to compare the next edit against.

The CSV is never written back into the xlsx. It is a photograph, not a source.

Two different things are written here, and they follow different rules:

  · the DATED snapshot is evidence. It records the workbook as it actually is,
    violations included, and is always written.
  · `latest.csv` is the BASELINE — what every future check is measured against.
    Advancing it over a failing workbook does not fix a violation, it erases it:
    the next run compares against the bad state and reports clean. That is how
    126 illegal סבב-2 transitions survived unnoticed from 23.8 to 6.9. So the
    baseline moves only over a clean read, or over violations that are written
    down and committed (--accept-drift).

Usage (repo root):
    python3 scripts/tracker_snapshot.py                 # dated snapshot + latest.csv
    python3 scripts/tracker_snapshot.py --baseline-only # refresh latest.csv only
    python3 scripts/tracker_snapshot.py --accept-drift <file>   # known debt, enumerated
Exit codes: 0 = baseline advanced · 1 = baseline held back (evidence still written)
"""
from __future__ import annotations

import argparse
import csv
import datetime as dt
import subprocess
import sys
from pathlib import Path

from openpyxl import load_workbook

sys.path.insert(0, str(Path(__file__).resolve().parent))
import tracker_schema as S  # noqa: E402
import tracker_guard as G  # noqa: E402

REPO = Path(__file__).resolve().parent.parent
TRACKER = REPO / S.TRACKER_DIR / S.TRACKER_FILENAME
SNAPDIR = REPO / S.SNAPSHOT_DIR

FIELDS = ('__sheet__',) + S.HEADERS
ITEM_FIELDS = ('__sheet__', '__page__') + S.ITEM_HEADERS


def norm(v) -> str:
    return '' if v is None else str(v).strip()


def rows() -> list[dict[str, str]]:
    wb = load_workbook(TRACKER, data_only=True)
    out = []
    for sheet in S.DATA_SHEETS:
        if sheet not in wb.sheetnames:
            continue
        ws = wb[sheet]
        hdr = next((r for r in range(1, min(ws.max_row, 12) + 1)
                    if norm(ws.cell(r, 1).value) == S.COL_KEY), 1)
        for r in range(hdr + 1, ws.max_row + 1):
            if not norm(ws.cell(r, 1).value):
                continue
            rec = {'__sheet__': sheet}
            rec.update({h: norm(ws.cell(r, c).value)
                        for c, h in enumerate(S.HEADERS, start=1)})
            out.append(rec)
    return out


def item_rows() -> list[dict[str, str]]:
    """Per-page item grids. These carry the actual decisions — what was found,
    what was decided, and by whom — so they belong in the audit trail just as
    much as the page-level index does."""
    import re
    wb = load_workbook(TRACKER, data_only=True)
    out = []
    for name in wb.sheetnames:
        if not name.startswith(S.PAGE_TAB_PREFIX):
            continue
        ws = wb[name]
        m = re.search(r'שורת אב (\S+)', norm(ws.cell(1, 1).value))
        page = m.group(1) if m else name
        for r in range(S.PAGE_FIRST_DATA_ROW, ws.max_row + 1):
            if not norm(ws.cell(r, 1).value):
                continue
            rec = {'__sheet__': name, '__page__': page}
            rec.update({h: norm(ws.cell(r, c).value)
                        for c, h in enumerate(S.ITEM_HEADERS, start=1)})
            out.append(rec)
    return out


def is_history(path: Path) -> bool:
    """True once a snapshot is committed — from then on it is evidence, not a file.

    A dated snapshot records what the tracker looked like on that date. Rewriting
    one destroys the only record of a state, and it happened: the 18.8 photograph
    was found carrying R1-29 as «הוקפא» — a status set weeks later. An uncommitted
    same-day file is still today's work and may be rewritten freely.
    """
    try:
        out = subprocess.run(['git', 'ls-files', '--', str(path)],
                             cwd=REPO, capture_output=True, text=True, timeout=10)
        return bool(out.stdout.strip())
    except Exception:
        return False        # cannot tell → do not block the session


def write_csv(path: Path, data: list[dict[str, str]], fields=FIELDS) -> None:
    path.parent.mkdir(parents=True, exist_ok=True)
    with path.open('w', encoding='utf-8-sig', newline='') as fh:
        w = csv.DictWriter(fh, fieldnames=fields)
        w.writeheader()
        w.writerows(data)


def read_accepted(path: Path | None) -> set[str]:
    """Violations someone decided, in writing, to carry as known debt.

    The file is committed, so accepting drift shows up in a diff with a name on
    it. Blank lines and «#» comments are ignored; everything else must match a
    guard message exactly — a near-miss does not silently widen the exemption.
    """
    if path is None:
        return set()
    if not path.exists():
        raise SystemExit(f'--accept-drift: הקובץ לא נמצא — {path}')
    return {ln.strip() for ln in path.read_text(encoding='utf-8').splitlines()
            if ln.strip() and not ln.lstrip().startswith('#')}


def outstanding(accepted: set[str]) -> tuple[list[str], list[str]]:
    """-> (blocking, already_accepted). Intrinsic rules + row deletion only.

    Human-column ownership is the guard's job at verify time, where the client
    export is available to sanction it. Here we check what is wrong regardless
    of who did it — precisely the class that the 126 belonged to.
    """
    cur = G.read_workbook()
    base = G.read_baseline()
    problems = G.intrinsic_violations(cur, base)
    if base is not None:
        _, _, deleted = G.diff(cur, base)
        if deleted:
            problems.append(
                'שורות נמחקו מהטרקר: ' + ', '.join(f'{s}!{k}' for s, k in deleted))
    known = [p for p in problems if p in accepted]
    return [p for p in problems if p not in accepted], known


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument('--baseline-only', action='store_true')
    ap.add_argument('--accept-drift', metavar='FILE',
                    help='text file enumerating known violations to carry as debt')
    args = ap.parse_args()

    if not TRACKER.exists():
        print(f'הטרקר לא נמצא: {TRACKER}', file=sys.stderr)
        return 2

    data = rows()
    items = item_rows()

    # Evidence first, and unconditionally — a failing workbook is exactly the
    # state worth having a dated photograph of.
    if not args.baseline_only:
        stamp = dt.date.today().isoformat()
        pairs = ((SNAPDIR / f'EA-CONTENT-TRACKER-{stamp}.csv', data, FIELDS),
                 (SNAPDIR / f'EA-CONTENT-ITEMS-{stamp}.csv', items, ITEM_FIELDS))
        sealed = [q for q, _, _ in pairs if is_history(q)]
        if sealed:
            print('  התצלום של היום כבר נשמר בגיט ולא נכתב מחדש: '
                  + ', '.join(q.name for q in sealed))
        for q, d, f in pairs:
            if q not in sealed:
                write_csv(q, d, f)
        if len(sealed) < len(pairs):
            print(f'  snapshot: EA-CONTENT-TRACKER-{stamp}.csv + EA-CONTENT-ITEMS-{stamp}.csv')

    blocking, known = outstanding(read_accepted(
        Path(args.accept_drift) if args.accept_drift else None))
    if known:
        print(f'  חוב ידוע שאושר בכתב: {len(known)} הפרות (ראה {args.accept_drift})')

    if blocking:
        print(f'\n  הבסיס לא הוזז — {len(blocking)} הפרות פתוחות:', file=sys.stderr)
        for x in blocking[:15]:
            print(f'    · {x}', file=sys.stderr)
        if len(blocking) > 15:
            print(f'    … ועוד {len(blocking) - 15}', file=sys.stderr)
        print('\n  latest.csv נשאר על המצב הקודם בכוונה. הזזתו עכשיו הייתה מוחקת את\n'
              '  ההפרות מכל בדיקה עתידית. לתקן — או להביא ל-team_00 ולרשום ב־--accept-drift.',
              file=sys.stderr)
        return 1

    write_csv(SNAPDIR / 'latest.csv', data)
    write_csv(SNAPDIR / 'latest-items.csv', items, ITEM_FIELDS)
    print(f'  baseline: {SNAPDIR.relative_to(REPO)}/latest.csv ({len(data)} שורות)')
    print(f'  items:    {SNAPDIR.relative_to(REPO)}/latest-items.csv ({len(items)} סעיפים)')
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
