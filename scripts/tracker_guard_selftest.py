#!/usr/bin/env python3
"""Regression test for tracker_guard.py — proves the two-permission lock is real.

Each case mutates a scratch copy of the tracker and asserts the guard's verdict.
Run from the repo root:  python3 scripts/tracker_guard_selftest.py

Reject artifacts produced by the failing cases are cleaned up at the end,
so a passing run leaves the repo exactly as it found it.
"""
import shutil
import subprocess
import sys
import tempfile
from pathlib import Path

from openpyxl import load_workbook

REPO = Path(__file__).resolve().parent.parent
SRC = REPO / 'EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx'
BASE = REPO / '_COMMUNICATION/team_100/S006/tracker/latest.csv'
SHEET = 'סבב-1-ליבה'
COL = {'#': 1, 'סטטוס מכונה': 8, 'הערות סוכן': 11, 'סטטוס אישור': 12,
       'הערות נימרוד': 13}

tmp = Path(tempfile.mkdtemp())
results = []


def run(path, mode='verify'):
    p = subprocess.run(
        [sys.executable, str(REPO / 'scripts/tracker_guard.py'),
         '--mode', mode, '--file', str(path), '--baseline', str(BASE)],
        capture_output=True, text=True, cwd=REPO)
    return p.returncode, (p.stdout + p.stderr)


def case(name, mutate, expect_rc, mode='verify', expect_text=None):
    path = tmp / f'{name}.xlsx'
    shutil.copy(SRC, path)
    wb = load_workbook(path)
    mutate(wb)
    wb.save(path)
    rc, out = run(path, mode)
    ok = (rc == expect_rc) and (expect_text is None or expect_text in out)
    results.append((name, ok, rc, expect_rc, out.strip().splitlines()[:3]))
    return ok


# a) agent writes a human-only approval status
case('a_agent_sets_eyal_approval',
     lambda wb: wb[SHEET].cell(3, COL['סטטוס אישור'], 'אושר ע״י אייל'),
     1, expect_text='עמודה בבעלות אנוש')

# b) agent writes into a human notes column
case('b_agent_writes_nimrod_notes',
     lambda wb: wb[SHEET].cell(3, COL['הערות נימרוד'], 'טקסט שהסוכן המציא'),
     1, expect_text='עמודה בבעלות אנוש')

# c) illegal machine transition: טרם נבדק -> הוגש לבדיקה (skips בעבודה)
case('c_illegal_transition',
     lambda wb: wb[SHEET].cell(3, COL['סטטוס מכונה'], 'הוגש לבדיקה'),
     1, expect_text='מעבר סטטוס אסור')

# d) frozen without a written reason
case('d_frozen_without_reason',
     lambda wb: wb[SHEET].cell(3, COL['סטטוס מכונה'], 'הוקפא'),
     1, expect_text='ללא סיבה כתובה')

# e) row deletion
case('e_row_deleted', lambda wb: wb[SHEET].delete_rows(3), 1,
     expect_text='שורות נמחקו')

# f) header renamed
case('f_header_renamed',
     lambda wb: wb[SHEET].cell(1, COL['סטטוס אישור'], 'סטטוס'),
     1, expect_text='FAIL — מבנה')

# g) invalid status value entirely
case('g_bogus_status',
     lambda wb: wb[SHEET].cell(3, COL['סטטוס מכונה'], 'בערך מוכן'),
     1, expect_text='ערך לא חוקי')


# h) LEGAL agent flow: טרם נבדק -> בעבודה
def legal(wb):
    wb[SHEET].cell(3, COL['סטטוס מכונה'], 'בעבודה')
    wb[SHEET].cell(3, COL['הערות סוכן'], 'התחלנו מול סקירה דף הבית.xlsx')


case('h_legal_agent_progress', legal, 0)


# i) LEGAL frozen WITH a reason
def frozen_ok(wb):
    wb[SHEET].cell(3, COL['סטטוס מכונה'], 'הוקפא')
    wb[SHEET].cell(3, COL['הערות סוכן'], 'חסר חומר מאייל לפרק הווידאו')


case('i_legal_frozen_with_reason', frozen_ok, 0)

# j) human edit under ingest mode is accepted and surfaced as work
case('j_human_edit_ingest',
     lambda wb: wb[SHEET].cell(3, COL['סטטוס אישור'], 'חזר לתיקונים'),
     0, mode='ingest', expect_text='קלט אנושי')

# k) same human edit under verify mode is a violation
case('k_human_edit_verify',
     lambda wb: wb[SHEET].cell(3, COL['סטטוס אישור'], 'חזר לתיקונים'),
     1, mode='verify')

print('\n' + '=' * 74)
passed = sum(1 for _, ok, *_ in results if ok)
for name, ok, rc, exp, head in results:
    print(f'{"PASS" if ok else "FAIL"}  {name:34} rc={rc} (expected {exp})')
    if not ok:
        for line in head:
            print(f'        {line}')
print('=' * 74)
print(f'{passed}/{len(results)} cases passed')
shutil.rmtree(tmp, ignore_errors=True)
for stray in (REPO / '_COMMUNICATION/team_100/S006').glob('TRACKER-GUARD-REJECT-*.md'):
    stray.unlink()
sys.exit(0 if passed == len(results) else 1)
