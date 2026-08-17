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
SHEET_ROUND3 = 'סבב-3'
SHEET_LOG = 'LOG'

DATA_SHEETS = (SHEET_ROUND1, SHEET_ROUND2, SHEET_ROUND3)

# Every round sheet states its own scope, so anyone opening it knows what the
# round covers and when it opens without reading the charter.
ROUND_DEFINITIONS: dict[str, dict[str, str]] = {
    SHEET_ROUND1: {
        'title': 'סבב 1 — ליבה  ·  דסקטופ בלבד',
        'scope': 'עמודי התפריט הראשי החי (21 פריטים) + כל עמוד שאייל סיפק לו חומר '
                 'ב-«content 13.8.26». ⚠ ההיקף הוא דסקטופ בלבד — כל נושא מובייל/רספונסיב '
                 'עובר לסבב 3 (החלטת team_00 17.8.26, לייעול).',
        'opens': 'פעיל מ-17.8.26 · WP-S6-01',
        'exit': 'כל שורה «אושר ע״י אייל» בדסקטופ, או «הוקפא» עם סיבה שנימרוד קיבל.',
    },
    SHEET_ROUND2: {
        'title': 'סבב 2 — כל שאר העמודים הקיימים  ·  דסקטופ בלבד',
        'scope': 'כל עמוד שזמין לגולש וכבר קיים ואינו בסבב 1: 54 פוסטים, 48 עמודי QR, '
                 'עמודי legal, /thank-you, /404, וכפילויות legacy (אימות 301 בלבד — '
                 'לא עריכת תוכן). ⚠ דסקטופ בלבד, כמו סבב 1.',
        'opens': '⚠ לא פעיל. נפתח רק בסגירת סבב 1 — WP-S6-02 חסומה על WP-S6-01. '
                 'הרשימה מגובה כאן מראש כדי ששום עמוד לא ייפול בין הכיסאות.',
        'exit': 'כל שורה «אושר ע״י אייל» בדסקטופ, או «הוקפא» עם סיבה שנימרוד קיבל.',
    },
    SHEET_ROUND3: {
        'title': 'סבב 3 — מובייל, תוכן תומך ואופטימיזציה',
        'scope': '**כל נושא המובייל והרספונסיב של האתר כולו** (החלטת team_00 17.8.26) + '
                 'טקסטים חלופיים (alt), meta titles/descriptions, OG, קידום ואופטימיזציה, '
                 'והשלמת עמודים חדשים שאינם קיימים עדיין.',
        'opens': '⚠ לא פעיל. **אבן דרך נפרדת — S007**, לא חלק מ-S006. ייתכן מאוד שנעלה '
                 'לאוויר לפניה; ההחלטה תתקבל בין סבב 2 לסבב 3.',
        'exit': 'ייקבע עם פתיחת S007. נכון להיום: S002-P001-WP004 (meta לכל האתר) + '
                 'מלוא נושא המובייל.',
    },
}

# ── Column ownership ───────────────────────────────────────────────────────
AGENT = 'AGENT'
HUMAN = 'HUMAN'

# Data grids carry NO legend row: the header is row 1 (page tabs: row 3) and
# data begins immediately after. A legend row inside the grid would be dragged
# around by any header sort and would sit inside the autofilter range.
# Ownership is shown by header colour instead, and spelled out in README.
ROUND_HEADER_ROW = 1
ROUND_FIRST_DATA_ROW = 2
PAGE_HEADER_ROW = 3
PAGE_FIRST_DATA_ROW = 4

# (header, owner). Order is significant — the guard compares the header row
# verbatim and rejects any add / remove / rename / reorder.
# Status and responsibility lead, per team_00 2026-08-17.
COLUMNS: tuple[tuple[str, str], ...] = (
    ('#',                   AGENT),
    ('סטטוס מכונה',         AGENT),
    ('סטטוס אישור',         HUMAN),
    ('ממתין ל',             AGENT),
    ('נתיב',                AGENT),
    ('כותרת',               AGENT),
    ('סוג',                 AGENT),
    ('קובץ תוכן',           AGENT),
    ('מקור חומר (אייל)',    AGENT),
    ('WP קשור',             AGENT),
    ('תאריך עבודה אחרון',   AGENT),
    ('ראיות QA',            AGENT),
    ('הערות סוכן',          AGENT),
    ('הערות נימרוד',        HUMAN),
    ('הערות אייל',          HUMAN),
    ('תאריך אישור',         HUMAN),
)

COL_WAITING_ON = 'ממתין ל'
COL_QA = 'ראיות QA'

# Who must act next on this page. Derived from the page's items and statuses —
# this is the column that answers «what is actually stuck, and on whom».
W_NONE = '—'
W_TEAM100 = 'team_100'
W_BUILDER = 'סוכן בנייה'
W_NIMROD = 'נימרוד'
W_EYAL = 'אייל'
WAITING_ON = (W_NONE, W_TEAM100, W_BUILDER, W_NIMROD, W_EYAL)

# Round-sheet free text is a HEADLINE, not the record. Detail lives in the
# page tab. Two lines, hard-capped so the index stays scannable.
SUMMARY_MAX_LINES = 2
SUMMARY_MAX_CHARS = 180
SUMMARY_COLUMNS = ('ראיות QA', 'הערות סוכן')


def summarize(text: str) -> str:
    """Clamp round-sheet free text to at most two short lines."""
    s = ' '.join(str(text or '').split())
    if not s:
        return ''
    if len(s) <= SUMMARY_MAX_CHARS:
        return s
    cut = s[:SUMMARY_MAX_CHARS]
    sp = cut.rfind(' ')
    return (cut[:sp] if sp > 40 else cut).rstrip(' ,.;·—-') + ' …'


def derive_waiting_on(machine: str, approval: str, item_statuses=()) -> str:
    """Who must act next. Item-level blockers outrank page-level state."""
    items = tuple(item_statuses)
    if IT_WAIT_EYAL in items:
        return W_EYAL
    if IT_WAIT_NIMROD in items:
        return W_NIMROD
    if approval == AP_EYAL:
        return W_NONE
    if approval == AP_RETURNED:
        return W_BUILDER
    if approval == AP_NIMROD:
        return W_EYAL
    if machine == ST_SUBMITTED:
        return W_NIMROD
    if machine == ST_FROZEN:
        return W_NIMROD
    if machine == ST_IN_WORK:
        return W_BUILDER
    return W_TEAM100

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

# ── Per-page tabs ──────────────────────────────────────────────────────────
# team_00 rule (2026-08-17): every page IN WORK gets its own tab listing that
# page's individual items. When the page is approved, the tab is HIDDEN (never
# deleted — the record survives). The round tabs remain the page-level index.

PAGE_TAB_PREFIX = 'עמוד · '

# (header, owner) — the item-level grid.
# Status and responsibility lead here too (team_00 2026-08-17).
ITEM_COLUMNS: tuple[tuple[str, str], ...] = (
    ('#',                  AGENT),   # e.g. H-01, immutable
    ('סטטוס סעיף',         AGENT),
    ('הכרעה נדרשת מ',      AGENT),   # — / נימרוד / אייל
    ('סיווג',              AGENT),   # ברור / לא ברור
    ('הסעיף',              AGENT),   # what this item is
    ('סקשן אצל אייל',      AGENT),   # SECTION 07 / —
    ('הכשל',               AGENT),   # what is wrong today
    ('התוכן הדרוש',        AGENT),   # what it must become, and from which source
    ('התיקון',             AGENT),   # the concrete change
    ('נתיב קוד',           AGENT),
    ('אפשרויות לבחירה',    AGENT),   # populated when escalating
    ('הערות סוכן',         AGENT),
    ('בחירה',              HUMAN),   # Nimrod's or Eyal's pick
    ('הערות נימרוד',       HUMAN),
    ('הערות אייל',         HUMAN),
    ('תאריך הכרעה',        HUMAN),
)

ITEM_HEADERS = tuple(h for h, _ in ITEM_COLUMNS)
ITEM_OWNER_OF = {h: o for h, o in ITEM_COLUMNS}

COL_ITEM_STATUS = 'סטטוס סעיף'
COL_ITEM_CLASS = 'סיווג'
COL_ITEM_DECIDER = 'הכרעה נדרשת מ'
COL_ITEM_CHOICE = 'בחירה'
COL_ITEM_NOTES = 'הערות סוכן'

# Classification — the team_00 work-layer rule, made a data value.
CLS_CLEAR = 'ברור'        # defect + required content + fix all clear → execute
CLS_UNCLEAR = 'לא ברור'   # anything missing → escalate
ITEM_CLASSES = (CLS_CLEAR, CLS_UNCLEAR)

IT_OPEN = 'פתוח'
IT_IN_WORK = 'בעבודה'
IT_DONE = 'בוצע'
IT_WAIT_NIMROD = 'ממתין להכרעת נימרוד'
IT_WAIT_EYAL = 'ממתין לאייל'
IT_FROZEN = 'הוקפא'
ITEM_STATUSES = (IT_OPEN, IT_IN_WORK, IT_DONE,
                 IT_WAIT_NIMROD, IT_WAIT_EYAL, IT_FROZEN)

DECIDERS = ('—', 'נימרוד', 'אייל')

# An item that needs a decision must name who decides and offer the options.
ITEM_STATUS_REQUIRING_DECIDER = (IT_WAIT_NIMROD, IT_WAIT_EYAL)
ITEM_STATUS_REQUIRING_REASON = (IT_FROZEN,)


def page_tab_name(path: str, title: str = '') -> str:
    """Excel caps sheet names at 31 chars and forbids : \\ / ? * [ ]."""
    label = (title or path).strip()
    name = PAGE_TAB_PREFIX + label
    for ch in ':\\/?*[]':
        name = name.replace(ch, '-')
    return name[:31]


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
