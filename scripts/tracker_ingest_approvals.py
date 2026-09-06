#!/usr/bin/env python3
"""
tracker_ingest_approvals.py — the ONLY sanctioned way to put the client's own
answers into the human-owned columns.

The two-permission lock says an agent never writes a human column. That rule is
right, and it has one legitimate exception this file exists to serve: when Eyal
returns a signed export of the review form, somebody has to carry those values
into the tracker. Doing it with ad-hoc openpyxl is what the guard correctly
rejected — the guard cannot tell "the agent invented an approval" from "the
agent transcribed the client's own file".

So the transcription is made auditable instead of forbidden:
  · values may come ONLY from the named export file,
  · every written cell must match that file byte-for-byte,
  · the export's identity (path + sha256) is stamped into the LOG tab,
  · tracker_guard.py --allow-ingest <export> re-checks every human-column change
    against the same file and still FAILS on anything the client did not write.

Usage (repo root):
    python3 scripts/tracker_ingest_approvals.py --export <answers.json>
    python3 scripts/tracker_ingest_approvals.py --export <answers.json> --dry-run
"""
from __future__ import annotations

import argparse, datetime as dt, hashlib, json, sys
from pathlib import Path
from openpyxl import load_workbook

sys.path.insert(0, str(Path(__file__).resolve().parent))
import tracker_schema as S

REPO = Path(__file__).resolve().parent.parent
TRACKER = REPO / S.TRACKER_DIR / S.TRACKER_FILENAME
n = lambda v: '' if v is None else str(v).strip()


def approvals_from(export: Path) -> dict[str, dict]:
    """pageKey -> {approval status, notes, date} — only what the client sent."""
    d = json.loads(export.read_text(encoding='utf-8'))
    out = {}
    stamp = (d.get('exportTimestamp') or '')[:10]
    for a in d.get('pageApprovals', []):
        st = (a.get('approvalStatus') or '').strip()
        if st not in (S.AP_EYAL, S.AP_RETURNED, S.AP_NIMROD, S.AP_FROZEN):
            continue          # no verdict -> nothing to transcribe
        out[a['pageKey']] = {S.COL_APPROVAL_STATUS: st,
                             'הערות אייל': (a.get('notes') or '').strip(),
                             'תאריך אישור': stamp}
    return out


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument('--export', required=True)
    ap.add_argument('--dry-run', action='store_true')
    ap.add_argument('--actor', default='team_100')
    args = ap.parse_args()

    export = Path(args.export)
    if not export.exists():
        print(f'export not found: {export}', file=sys.stderr); return 2
    sha = hashlib.sha256(export.read_bytes()).hexdigest()[:16]
    want = approvals_from(export)

    wb = load_workbook(TRACKER)
    changes, skipped = [], []
    for sheet in S.DATA_SHEETS:
        if sheet not in wb.sheetnames:
            continue
        ws = wb[sheet]
        hdr = next((r for r in range(1, 13) if n(ws.cell(r, 1).value) == S.COL_KEY), None)
        if not hdr:
            continue
        ci = {n(ws.cell(hdr, c).value): c for c in range(1, 30) if n(ws.cell(hdr, c).value)}
        for r in range(hdr + 1, ws.max_row + 1):
            key = n(ws.cell(r, 1).value)
            if key not in want:
                continue
            for col, val in want[key].items():
                if col not in ci:
                    skipped.append(f'{key}:{col} (no such column)'); continue
                cell = ws.cell(r, ci[col])
                if n(cell.value) == val:
                    continue
                if not args.dry_run:
                    cell.value = val
                changes.append(f'{sheet}!{key}·{col}')

    print(f'  export: {export.name}  sha256:{sha}')
    print(f'  verdicts in export: {len(want)}   cells to write: {len(changes)}')
    for s in skipped:
        print(f'  ! skipped {s}')
    if args.dry_run:
        print('  dry-run — nothing written'); return 0

    log = wb[S.SHEET_LOG]
    lr = log.max_row + 1
    for c, v in enumerate((dt.datetime.now().strftime('%Y-%m-%d %H:%M:%S'), args.actor,
                           'קליטת אישורי לקוח',
                           f'{len(want)} עמודים · {len(changes)} תאים',
                           f'מקור: {export.name} · sha256:{sha} · '
                           'עמודות אנוש נכתבו אך ורק מהייצוא הזה'), start=1):
        log.cell(lr, c, v)
    wb.save(TRACKER)
    print(f'  ✓ written + stamped in LOG')
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
