#!/usr/bin/env python3
"""
Canonical schema for the S006 content tracker (EA-CONTENT-TRACKER.xlsx).

Single definition of columns, ownership, legal status values and legal
transitions. tracker_build.py, tracker_guard.py and tracker_snapshot.py all
import from here so the file, the enforcement and the audit trail can never
drift apart.

Milestone: S006 — «דיוק תוכן מלא מול חומרי אייל»
Authority: _COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md
"""
from __future__ import annotations

TRACKER_VERSION = '1.0.0'

# ── Workbook layout ────────────────────────────────────────────────────────
SHEET_README = 'README'
SHEET_STATE = 'מצב'
SHEET_ROUND1 = 'סבב-1-ליבה'
SHEET_ROUND2 = 'סבב-2'
SHEET_LOG = 'LOG'

DATA_SHEETS = (SHEET_ROUND1, SHEET_ROUND2)

# ── Column ownership ───────────────────────────────────────────────────────
AGENT = 'AGENT'
HUMAN = 'HUMAN'

# (header, owner). Order is significant — the guard compares the header row
# verbatim and rejects any add / remove / rename / reorder.
COLUMNS: tuple[tuple[str, str], ...] = (
    ('#',                   AGENT),
    ('סוג',                 AGENT),
    ('נתיב',                AGENT),
    ('כותרת',               AGENT),
    ('קובץ תוכן',           AGENT),
    ('מקור חומר (אייל)',    AGENT),
    ('WP קשור',             AGENT),
    ('סטטוס מכונה',         AGENT),
    ('תאריך עבודה אחרון',   AGENT),
    ('ראיות QA',            AGENT),
    ('הערות סוכן',          AGENT),
    ('סטטוס אישור',         HUMAN),
    ('הערות נימרוד',        HUMAN),
    ('הערות אייל',          HUMAN),
    ('תאריך אישור',         HUMAN),
)

HEADERS = tuple(h for h, _ in COLUMNS)
OWNER_OF = {h: o for h, o in COLUMNS}
AGENT_COLUMNS = tuple(h for h, o in COLUMNS if o == AGENT)
HUMAN_COLUMNS = tuple(h for h, o in COLUMNS if o == HUMAN)

COL_KEY = '#'
COL_MACHINE_STATUS = 'סטטוס מכונה'
COL_APPROVAL_STATUS = 'סטטוס אישור'
COL_AGENT_NOTES = 'הערות סוכן'
COL_PATH = 'נתיב'

# ── Status vocabularies ────────────────────────────────────────────────────
# Machine status — the agent owns this column outright.
ST_UNKNOWN = 'לא ידוע'
ST_NOT_CHECKED = 'טרם נבדק'
ST_IN_WORK = 'בעבודה'
ST_SUBMITTED = 'הוגש לבדיקה'
ST_FROZEN = 'הוקפא'

MACHINE_STATUSES = (ST_UNKNOWN, ST_NOT_CHECKED, ST_IN_WORK, ST_SUBMITTED, ST_FROZEN)

# Approval status — humans only. The agent may read it and must react to it,
# but may never write it.
AP_NONE = '—'
AP_RETURNED = 'חזר לתיקונים'
AP_NIMROD = 'אושר ע״י נימרוד'
AP_EYAL = 'אושר ע״י אייל'
AP_FROZEN = 'הוקפא'

APPROVAL_STATUSES = (AP_NONE, AP_RETURNED, AP_NIMROD, AP_EYAL, AP_FROZEN)

# Legal machine-status transitions. Anything not listed is rejected.
MACHINE_TRANSITIONS: dict[str, set[str]] = {
    ST_UNKNOWN:     {ST_UNKNOWN, ST_NOT_CHECKED, ST_FROZEN},
    ST_NOT_CHECKED: {ST_NOT_CHECKED, ST_IN_WORK, ST_FROZEN},
    ST_IN_WORK:     {ST_IN_WORK, ST_SUBMITTED, ST_NOT_CHECKED, ST_FROZEN},
    # returned-for-fixes sends a submitted row back into work
    ST_SUBMITTED:   {ST_SUBMITTED, ST_IN_WORK, ST_FROZEN},
    ST_FROZEN:      {ST_FROZEN, ST_NOT_CHECKED, ST_IN_WORK},
}

# «הוקפא» always requires a written reason in the agent-notes column.
STATUS_REQUIRING_REASON = (ST_FROZEN,)

# ── Row types ──────────────────────────────────────────────────────────────
TYPE_PAGE = 'עמוד'
TYPE_POST = 'פוסט'
TYPE_QR = 'QR'
TYPE_LEGACY = 'legacy/301'
TYPE_EXTERNAL = 'קישור חיצוני'
ROW_TYPES = (TYPE_PAGE, TYPE_POST, TYPE_QR, TYPE_LEGACY, TYPE_EXTERNAL)

# ── Round 1 (core) seed ────────────────────────────────────────────────────
# path -> (content file under inc/chapters/defaults/ or a template note,
#          Eyal material folder under «content 13.8.26/» or '' when none)
#
# Derived from: the live primary menu on staging (21 items, probed 2026-08-17)
# plus every page Eyal supplied material for in «content 13.8.26/».
ROUND1_SEED: tuple[tuple[str, str, str], ...] = (
    ('/',                              'home-defaults.php',                'דף הבית'),
    ('/treatment/',                    'treatment-defaults.php',           "טיפול בדיג'רידו"),
    ('/method/',                       'method-defaults.php',              'השיטה'),
    ('/lessons/',                      'lessons-defaults.php',             'שיעורי נגינה'),
    ('/sound-healing/',                'sound-healing-defaults.php',       'סאונדהילינג'),
    ('/learning/',                     'learning-defaults.php',            ''),
    ('/learning/therapist-training/',  'therapist-training-defaults.php',  ''),
    ('/learning/lectures/',            'lectures-defaults.php',            ''),
    ('/learning/workshops/',           'workshops-defaults.php',           ''),
    ('/shop/',                         'shop-defaults.php',                'כלים למכירה'),
    ('/repair/',                       'repair-defaults.php',              "תיקון כלי דיג'רידו"),
    ('/didgeridoos/',                  'didgeridoos-defaults.php',         'כלים למכירה'),
    ('/bags/',                         'bags-defaults.php',                "תיקים לדיג'רידו"),
    ('/stands-storage/',               'stands-storage-defaults.php',      "סטנדים לדיג'רידו לאחסון"),
    ('/stand-floor/',                  'stand-floor-defaults.php',         'סטנד רצפתי לנגינה בישיבה נמוכה'),
    ('/books/',                        'muzza-defaults.php',               'מוזה הוצאה לאור - ספרים'),
    ('/books/kushi-blantis/',          'kushi-blantis-defaults.php',       'כושי בלאנטיס'),
    ('/books/tsva-bekahol/',           'tsva-bekahol-defaults.php',        'צבע בכחול וזרוק לים'),
    ('/books/vekatavta/',              'vekatavta-defaults.php',           'וכתבת'),
    ('/blog/',                         'tpl-blog-archive.php (תבנית)',     ''),
    ('/eyal-amit/',                    'about-defaults.php',               'אודות - אייל עמית'),
    ('/eyal-amit/mokesh-dahiman/',     'mokesh-defaults.php',              'מוקש - דף הנחצחה לזרכו ופועלו'),
    ('/contact/',                      'contact-defaults.php',             ''),
    ('/en/',                           'en-defaults.php',                  ''),
    ('/faq/',                          'faq-defaults.php',                 'דף FAQ'),
    ('/media/',                        'media-defaults.php',               "ריכוז כל ההמלצות - טיפול בדיג'רידו, שיעורי נגינה, סאונדהילינג,"),
    ('/galleries/',                    'galleries-defaults.php',           ''),
    ('/snoring-sleep-apnea/',          'snoring-sleep-apnea-defaults.php', 'נחירות ודום נשימה'),
)

# WPs frozen under S006 whose subject matter belongs to a specific row. The
# reference is planted so the WP is re-examined when we reach that row.
WP_BY_PATH: dict[str, str] = {
    '/':                          'S002-P001-WP002 (ON_HOLD)',
    '/eyal-amit/':                'S002-P001-WP001 (ON_HOLD)',
    '/books/':                    'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/books/kushi-blantis/':      'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/books/tsva-bekahol/':       'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/books/vekatavta/':          'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/didgeridoos/':              'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/bags/':                     'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/stands-storage/':           'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/stand-floor/':              'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/repair/':                   'WP-EI-01, WP-EI-02 (ON_HOLD)',
    '/snoring-sleep-apnea/':      'WP-EI-03 (ON_HOLD)',
    '/eyal-amit/mokesh-dahiman/': 'WP-EI-04 (ON_HOLD)',
    '/en/':                       'WP-EI-06 (ON_HOLD)',
    '/media/':                    'WP-EI-07 (ON_HOLD)',
}

# ── Paths ──────────────────────────────────────────────────────────────────
TRACKER_FILENAME = 'EA-CONTENT-TRACKER.xlsx'
TRACKER_DIR = 'EyalAmit_Site_GoogleDrive_Sync'
SNAPSHOT_DIR = '_COMMUNICATION/team_100/S006/tracker'
STAGING_BASE = 'http://eyalamit-co-il-2026.s887.upress.link'
EYAL_MATERIAL_ROOT = (
    '~/Library/CloudStorage/GoogleDrive-nimrod@mezoo.co/My Drive/Eyal Amit/content 13.8.26'
)
