#!/usr/bin/env python3
"""S006 temporary review form for Eyal.

SSOT is EA-CONTENT-TRACKER.xlsx. Round 1 closes when Eyal marks each submitted
page approved (or returned with a note). The form is regenerated from the
tracker snapshot: 23 submitted pages as an approval board, plus any leftover
content questions still waiting on Eyal. Frozen media is not re-asked.
"""
from __future__ import annotations

import csv
import json
import re
from collections import Counter, defaultdict
from html import escape
from pathlib import Path

REPO = Path(__file__).resolve().parent.parent
SNAPDIR = REPO / "_COMMUNICATION" / "team_100" / "S006" / "tracker"
STAGING_ORIGIN = "http://eyalamit-co-il-2026.s887.upress.link"
EXPORT_TYPE = "eyal-s006-tracker-answers"
EXPORT_SCHEMA = "round1-approval-v1"
ASSET_CACHE = "s006r2nav3"
ROUND1_SHEET = "סבב-1-ליבה"
ROUND2_SHEET = "סבב-2"
ROUND3_SHEET = "סבב-3"
EXPORT_TYPE_R2 = "eyal-s006-r2-answers"
EXPORT_SCHEMA_R2 = "round2-approval-v2"
WAVE_ASSIGN = SNAPDIR / "R2-WAVE-ASSIGN-2026-08-24.csv"
SHOP_KEYS = frozenset({"R2-024", "R2-025", "R2-026"})
R2_CHAPTER_META: tuple[tuple[str, str, str], ...] = (
    ("core", "ליבה שאושרה בסבב 1", "עמודים שכבר נסגרו בסבב 1 — כאן רק לניווט, בלי אישור מחדש"),
    ("w5", "ארכיון ושאלות מבנה", "עמודים חיים בלי חבילת 13.8 — שאלות לאייל תחת כל עמוד"),
    ("shop", "חנות, כלים למכירה, תיקון", "שני עולמות חיים בסבב 1, ועמודים ישנים שמפנים אליהם"),
    ("w4", "נגישות, פרטיות, תקנון", "טיוטות מחקר — ממתין לנימרוד לפני הדבקה"),
    ("w1", "הפניות מכתובות ישנות", "רק לוודא שהכתובת הישנה מגיעה ליעד החדש"),
    ("w3", "פוסטים בבלוג", "54 פוסטים כמו שהם חיים באתר הבדיקה"),
    ("w2", "QR מודפסים", "שער + קודים מודפסים — אין לשבור permalink"),
    ("other", "עמודים נוספים", "לא שויכו לגל"),
    ("r3", "סבב 3 — מתוכנן", "מובייל, קידום, ועמודים חדשים שעוד לא קיימים"),
)
R3_PLANNED: tuple[dict, ...] = (
    {
        "key": "R3-PLAN-MOBILE",
        "title": "מובייל ורספונסיב — כל האתר כיחידה אחת",
        "path": "",
        "liveUrl": "",
        "machine": "טרם נבדק",
        "inForm": False,
        "openCount": 0,
        "chapter": "r3",
        "kind": "מתוכנן",
        "round": 3,
    },
    {
        "key": "R3-PLAN-SEO",
        "title": "תיאורי תמונות, כותרות לחיפוש, קידום ואופטימיזציה",
        "path": "",
        "liveUrl": "",
        "machine": "טרם נבדק",
        "inForm": False,
        "openCount": 0,
        "chapter": "r3",
        "kind": "מתוכנן",
        "round": 3,
    },
    {
        "key": "R3-PLAN-NEW",
        "title": "עמודים חדשים שעוד לא קיימים באתר",
        "path": "",
        "liveUrl": "",
        "machine": "טרם נבדק",
        "inForm": False,
        "openCount": 0,
        "chapter": "r3",
        "kind": "מתוכנן",
        "round": 3,
    },
)
R19_ANSWERS = SNAPDIR / "r19-eyal-answers.json"

# Catalog waves — used on the form so Eyal sees *when* an already-given
# 19.8 answer will land, instead of being asked the same radio again.
PAGE_WAVE: dict[str, int] = {
    "R1-01": 1,
    "R1-02": 1,
    "R1-04": 1,
    "R1-21": 2,
    "R1-03": 3,
    "R1-05": 4,
    "R1-26": 5,
    "R1-10": 6,
    "R1-11": 6,
    "R1-12": 6,
    "R1-13": 6,
    "R1-14": 6,
    "R1-15": 6,
    "R1-16": 7,
    "R1-17": 7,
    "R1-18": 7,
    "R1-19": 7,
    "R1-22": 8,
    "R1-25": 9,
    "R1-28": 9,
    "R1-08": 10,
    "R1-09": 10,
}

PAGE_LIVE: dict[str, str] = {
    "R1-01": "גל 1 עלה. ציר הזמן ירד. וידאו בפרק 3 נשאר פלייסהולדר (לשלב 2/3).",
    "R1-02": "כתובת אחת /treatment/. ההשוואה ?compare=eyal כבויה. סרטון מפגש לשלב מדיה.",
    "R1-03": "גל 3+5 עלו: כותרת «עדויות והמלצות», כפתור לכל ההמלצות, קרוסלת חצים ידנית.",
    "R1-04": "גל 1 עלה. קישור הריון כפי שנתת. מקום לווידאו שמור.",
    "R1-05": "גל 4+5 עלו: בלוק אודות לפני יצירת קשר, שלד וידאו, קרוסלת חצים ידנית.",
    "R1-08": "גל 10 עלה. נבנה מהמסמך. בלי בלוק המלצות (אין עדויות הרצאה).",
    "R1-09": "גל 10 עלה. נבנה מהמסמך. כרגע אין מועד לסדנה פתוחה.",
    "R1-10": "גל 6 עלה. שער עם חמש קוביות. תמונות לשלב מאוחר.",
    "R1-11": "גל 6 עלה. בלוק ההמלצות בתיקון ירד. תמונות לשלב הבא.",
    "R1-12": "גל 6 עלה. נשאר בכתובת /didgeridoos/. תמונות לשלב מאוחר.",
    "R1-13": "גל 6 עלה. שש תמונות מהאתר הישן; bleed נשאר. תמונות הירו לשלב הבא.",
    "R1-14": "גל 6 עלה. תוכן אחסון יושם על /stands-storage/ (באקסל נכתבו מזהי FLR). תמונות לשלב הבא.",
    "R1-15": "גל 6: האקסל ריק (= אין הערות). העמוד החי לא שונה.",
    "R1-16": "גל 7 עלה. הכותרת «מוזה הוצאה לאור - ספרים». תמונות להשאיר; תמונת חבילה בהמשך.",
    "R1-17": "גל 7 עלה. גלריה מהאתר הישן. כתבות בהמשך.",
    "R1-18": "גל 7 עלה. קישור מנדלה החי נשאר (נבדק 200). כתבות בהמשך.",
    "R1-19": "גל 7 עלה. גלריה מהאתר הישן.",
    "R1-21": "גל 2 עלה. עמוד אחד מ«אודות אייל עמית - סופי מאוחד.md». תמונות נשארו.",
    "R1-22": "גל 8 עלה. שם באנגלית, ציר עם תחנת קורונה, גלריה מהאתר הישן.",
    "R1-23": "אין קובץ 19.8. הוגש כפי שהוא ב-18.8.",
    "R1-25": "גל 9+10: בלוק 2 ירד, קישורי ספרים ל-/books/, לשוניות הרצאות/סדנאות/נחירות. שאלה אחת פתוחה: קישור ההכשרות.",
    "R1-26": "גל 5 + הכרעת נימרוד 23.8: כרטיס בלי תוכן לא מוצג; מה שיש גוף — מוצג. תמונות פרופיל וסרטונים בהמשך.",
    "R1-28": "גל 9 עלה. צילום מכבי והתכתבות יוני. באנר ההמתנה ירד. אין מקור שלישי (תא ריק).",
}

# Round-2 map, 23.8 — closed questions for Nimrod only. Not tracker codes on screen.
NIMROD_DECISIONS: tuple[dict, ...] = (
    {
        "id": "R2-N-A",
        "itemKey": "א",
        "pageKey": "R2-MAP",
        "title": "א. אודות מול אייל עמית",
        "ask": (
            "אודות חי ליד אייל עמית, אותה חבילת דרייב. "
            "מה עושים עם אודות?"
        ),
        "path": "/about/",
        "picks": (
            "301 אל אייל עמית (מומלץ)",
            "הקפאה של אודות",
            "להשאיר שני עמודים",
        ),
        "needsFill": True,
    },
    {
        "id": "R2-N-B",
        "itemKey": "ב",
        "pageKey": "R2-MAP",
        "title": "ב. מוקש-על-השם מול מוקש-לזכרו",
        "ask": "שני עמודי מוקש חיים. מה עושים עם מוקש-על-השם?",
        "path": "/about/moksha/",
        "picks": (
            "301 אל מוקש לזכרו (מומלץ)",
            "הקפאה של מוקש-על-השם",
            "להשאיר שני עמודים",
        ),
        "needsFill": True,
    },
    {
        "id": "R2-N-C",
        "itemKey": "ג",
        "pageKey": "R2-MAP",
        "title": "ג. כלים / תיקון הישנים מול חנות + תיקון דיג'רידו",
        "ask": (
            "שלושה עמודים חיים: כלים ואביזרים, כלים בעבודת יד, תיקון כלים. "
            "יש גם 301 משירותים הישן אל כלים בעבודת יד. "
            "מה עושים עם השלושה?"
        ),
        "path": "/tools-and-accessories/",
        "picks": (
            "301 ליעדי סבב 1: שער→חנות, כלים-בעבודת-יד→כלים למכירה, תיקון-כלים→תיקון דיג'רידו (מומלץ)",
            "הקפאה של השלושה",
            "להשאיר כמו שהם",
        ),
        "needsFill": True,
    },
    {
        "id": "R2-N-D",
        "itemKey": "ד",
        "pageKey": "R2-MAP",
        "title": "ד. קורסים-בקרוב → קורסים חיצוניים",
        "ask": (
            "ה-301 חי אל קורסים חיצוניים, שעדיין סבב 2 בלי חבילה "
            "(ובסבב 1 פריט התפריט מוקפא). לאשר ולהקפיא את היעד?"
        ),
        "path": "/courses-soon/",
        "picks": ("כן — לאשר 301 ולהקפיא את היעד (מומלץ)", "אחר — לפרט בהערה"),
        "needsFill": True,
    },
    {
        "id": "R2-N-E",
        "itemKey": "ה",
        "pageKey": "R2-MAP",
        "title": "ה. 54 הפוסטים",
        "ask": "הקפאה כארכיון חי אחד, בלי רשימה לאייל, עד שתגיע חבילה?",
        "path": "",
        "picks": ("כן — הקפאה כארכיון חי (מומלץ)", "אחר — לפרט בהערה"),
        "needsFill": True,
    },
    {
        "id": "R2-N-F",
        "itemKey": "ו",
        "pageKey": "R2-MAP",
        "title": "ו. שער QR + 48 הקודים",
        "ask": "אותה הקפאה כארכיון חי, בלי רשימה לאייל?",
        "path": "/qr/",
        "picks": ("כן — הקפאה כארכיון חי (מומלץ)", "אחר — לפרט בהערה"),
        "needsFill": True,
    },
    {
        "id": "R2-N-G",
        "itemKey": "ז",
        "pageKey": "R2-MAP",
        "title": "ז. תשעת עמודי הליגל/ארכיון",
        "ask": (
            "נגישות, כתבות, קורסים חיצוניים, עיתונות, פרטיות, שירותים, "
            "הופעות, תקנון, תודה: הקפאה אחת עד חבילה, בלי טופס לאייל?"
        ),
        "path": "",
        "picks": ("כן — הקפאה אחת עד חבילה (מומלץ)", "אחר — לפרט בהערה"),
        "needsFill": True,
    },
)

# Page-level close for Round 1. Values are what Eyal sees; status maps to the
# tracker human column «סטטוס אישור» on ingest (agents never write that column).
APPROVE_PICKS: tuple[dict, ...] = (
    {
        "label": "אושר למסך מחשב",
        "value": "אושר למסך מחשב",
        "status": "אושר ע״י אייל",
        "hint": "העמוד תקין לסבב 1",
    },
    {
        "label": "יש תיקון",
        "value": "יש תיקון",
        "status": "חזר לתיקונים",
        "hint": "כתבו בתיבה מה לשנות",
    },
    {
        "label": "עדיין לא בדקתי",
        "value": "עדיין לא בדקתי",
        "status": "—",
        "hint": "",
    },
)

# Pages with more than one live copy Eyal must compare. SSOT for form links
# (the tracker «אפשרויות לבחירה» text is not rendered as links today).
PAGE_VERSIONS: dict[str, dict] = {
    "R1-02": {
        "layout": "one-url",
        "intro": (
            "כתובת אחת: /treatment/. ההשוואה ?compare=eyal כבויה מאז 21.8.2026. "
            "רצועת התמונה והשאלות על נחירות/CPAP יטופלו בשלב מדיה נפרד (T-02)."
        ),
        "versions": [
            {
                "label": "טיפול בדיג'רידו",
                "url": STAGING_ORIGIN + "/treatment/",
                "note": "העמוד החי היחיד",
            },
        ],
    },
    "R1-21": {
        "layout": "one-url",
        "intro": (
            "עמוד אחד, גרסה אחת — נבנה ב-21.8.2026 מ«אודות אייל עמית - סופי מאוחד.md». "
            "שתי הגרסאות הקודמות (א׳ המסמך / ב׳ SEO) ירדו."
        ),
        "versions": [
            {
                "label": "אודות אייל עמית",
                "url": STAGING_ORIGIN + "/eyal-amit/",
                "note": "הגרסה המאוחדת מ-19.8, פרוסה 21.8.2026",
            },
        ],
    },
}

HUMAN_WAITERS = frozenset({"אייל", "נימרוד"})
NEED_STATUSES = frozenset({"ממתין לאייל", "ממתין להכרעת נימרוד", "פתוח"})

PATTERN_DEFS: tuple[tuple[str, str, tuple[str, ...]], ...] = (
    ("version-choice", "בחירת גרסה", ("גרסה", "מוצע מול", "שתיהן")),
    ("broken-link", "קישור שבור", ("404", "לא קיים", "/muse", "/about/", "pregnancy-didgeridoo", "cbDidg-therapy")),
    ("media-video", "חסר וידאו", ("וידאו", "סרטון")),
    ("media-bleed", "תמונות bleed", ("bleed",)),
    ("media-press", "עיתונות", ("עיתונות",)),
    ("media-gallery", "חסרה גלריה", ("גלרי",)),
    ("media-hero", "חסרה תמונה", ("הירו", "תמונ", "מדיה", "jpg", "רקע")),
    ("approval", "אישור", ("אשר ", "לאשר", "אישור")),
)

GROUP_HINTS = (
    ("pregnancy-article", "אותו מאמר הריון", ("pregnancy-didgeridoo", "הריון")),
    ("muse-books", "אותו קישור /muse", ("/muse",)),
    ("training-href", "אותו קישור הכשרה", ("cbDidg-therapy", "הכשרת מטפל")),
)


def _cell(row: dict, key: str) -> str:
    return str(row.get(key) or "").strip()


def _read_csv(path: Path) -> list[dict[str, str]]:
    with path.open(encoding="utf-8-sig", newline="") as fh:
        return [{k: (v or "").strip() for k, v in r.items()} for r in csv.DictReader(fh)]


def _load_picks() -> dict[tuple[str, str], list[str]]:
    out: dict[tuple[str, str], list[str]] = {}
    specs = (
        (r"r1-(\d+)-items", "R1", 2),
        (r"r2-(\d+)-items", "R2", 3),
    )
    for path in sorted(SNAPDIR.glob("r*-items.json")):
        page_key = ""
        for pat, prefix, width in specs:
            m = re.match(pat, path.name, re.I)
            if m:
                page_key = f"{prefix}-{int(m.group(1)):0{width}d}"
                break
        if not page_key:
            continue
        try:
            data = json.loads(path.read_text(encoding="utf-8"))
        except (OSError, json.JSONDecodeError):
            continue
        if not isinstance(data, list):
            continue
        for it in data:
            if not isinstance(it, dict):
                continue
            iid = str(it.get("#") or "").strip()
            picks = it.get("_picks")
            if iid and isinstance(picks, list) and picks:
                out[(page_key, iid)] = [str(p).strip() for p in picks if str(p).strip()]
    return out


def _canon_item_id(raw: str) -> str:
    s = (raw or "").strip()
    m = re.match(r"^([A-Za-z]+)-?0*(\d+)([a-zA-Z]?)$", s)
    if m:
        return f"{m.group(1).upper()}-{int(m.group(2)):02d}{m.group(3)}"
    return s


def load_r19() -> dict:
    """19.8 Excel answers (column D) + page notes (column E)."""
    empty: dict = {"by_page": {}, "lookup": {}}
    if not R19_ANSWERS.is_file():
        return empty
    try:
        data = json.loads(R19_ANSWERS.read_text(encoding="utf-8"))
    except (OSError, json.JSONDecodeError):
        return empty
    lookup: dict[tuple[str, str], list[dict]] = {}
    by_page: dict[str, dict] = {}
    for pg in data.get("pages") or []:
        if not isinstance(pg, dict):
            continue
        key = str(pg.get("pageKey") or "").strip()
        if not key:
            continue
        recs: dict[str, list[dict]] = defaultdict(list)
        for ans in pg.get("answers") or []:
            iid = _canon_item_id(str(ans.get("id") or ""))
            if not iid:
                continue
            recs[iid].append(ans)
            lookup.setdefault((key, iid), []).append(ans)
        by_page[key] = {
            "file": pg.get("file") or "",
            "pageNotes": [str(n) for n in (pg.get("pageNotes") or []) if str(n).strip()],
            "by_id": recs,
        }
    # Id mix-ups in the 19.8 files (remap the label only — do not invent copy).
    if lookup.get(("R1-05", "SH-01"), []):
        sh = lookup[("R1-05", "SH-01")]
        if len(sh) >= 2:
            lookup[("R1-05", "SH-02")] = [sh[1]]
    if lookup.get(("R1-19", "VKT-01"), []):
        vkt = lookup[("R1-19", "VKT-01")]
        if len(vkt) >= 2:
            lookup[("R1-19", "VKT-02")] = [vkt[1]]
    if lookup.get(("R1-14", "FLR-01")):
        lookup[("R1-14", "STN-01")] = lookup[("R1-14", "FLR-01")]
    if lookup.get(("R1-14", "FLR-02")):
        lookup[("R1-14", "STN-02")] = lookup[("R1-14", "FLR-02")]
    return {"by_page": by_page, "lookup": lookup}


def r19_for_item(r19: dict, page_key: str, item_id: str) -> dict | None:
    recs = r19.get("lookup", {}).get((page_key, item_id)) or []
    return recs[0] if recs else None


def classify_pattern(item: dict) -> tuple[str, str]:
    blob = " ".join(
        [
            _cell(item, "#"),
            _cell(item, "הסעיף"),
            _cell(item, "מה נדרש ממך"),
            _cell(item, "הכשל"),
            _cell(item, "אפשרויות לבחירה"),
        ]
    ).lower()
    for pid, label, keys in PATTERN_DEFS:
        if any(k.lower() in blob for k in keys):
            return pid, label
    return "other", ""


def classify_group(item: dict) -> str:
    blob = " ".join(
        [_cell(item, "הכשל"), _cell(item, "מה נדרש ממך"), _cell(item, "הסעיף")]
    ).lower()
    for gid, _label, keys in GROUP_HINTS:
        if any(k.lower() in blob for k in keys):
            return gid
    return ""


def split_picks(text: str) -> list[str]:
    raw = (text or "").strip()
    if not raw:
        return []
    parts = [p.strip(" .") for p in re.split(r"\s*[·|/]\s*", raw) if p.strip()]
    if 2 <= len(parts) <= 6 and all(8 <= len(p) <= 48 for p in parts):
        return parts
    return []


def split_picks_r2(text: str) -> list[str]:
    """Round-2 options include short tokens such as HOLD-W4 / לאחד."""
    raw = (text or "").strip()
    if not raw:
        return []
    parts = [p.strip(" .") for p in re.split(r"\s*[·|/]\s*", raw) if p.strip()]
    if 2 <= len(parts) <= 8 and all(3 <= len(p) <= 80 for p in parts):
        return parts
    return []


def needs_fill(row: dict, pattern_id: str, picks: list[str]) -> bool:
    hint = _cell(row, "אפשרויות לבחירה") + " " + _cell(row, "התוכן הדרוש")
    if "מילוי" in hint or "קישור" in hint or "שם קובץ" in hint:
        return True
    return pattern_id in {"broken-link", "media-hero", "media-video", "media-gallery", "media-press", "media-bleed"}


def staging_url(path: str) -> str:
    p = (path or "/").strip() or "/"
    if p.startswith("http://") or p.startswith("https://"):
        return p
    if not p.startswith("/"):
        p = "/" + p
    return STAGING_ORIGIN.rstrip("/") + p


def is_action_item(row: dict, *, waiter: str | None = None) -> bool:
    ask = _cell(row, "מה נדרש ממך")
    if not ask or ask == "—":
        return False
    who = _cell(row, "הכרעה נדרשת מ")
    status = _cell(row, "סטטוס סעיף")
    if who not in HUMAN_WAITERS:
        return False
    if waiter and who != waiter:
        return False
    if status not in NEED_STATUSES:
        return False
    return True


def load_model() -> dict:
    pages_rows = [r for r in _read_csv(SNAPDIR / "latest.csv") if r.get("__sheet__") == ROUND1_SHEET]
    page_by_key = {_cell(r, "#"): r for r in pages_rows}
    picks_map = _load_picks()

    open_items: list[dict] = []
    for row in _read_csv(SNAPDIR / "latest-items.csv"):
        page_key = _cell(row, "__page__")
        if not page_key.startswith("R1-") or not is_action_item(row, waiter="אייל"):
            continue
        item_id = _cell(row, "#")
        pattern_id, pattern_label = classify_pattern(row)
        picks = picks_map.get((page_key, item_id)) or split_picks(_cell(row, "אפשרויות לבחירה"))
        open_items.append(
            {
                "pageKey": page_key,
                "itemKey": item_id,
                "id": f"{page_key}/{item_id}",
                "domId": f"{page_key}__{item_id}",
                "ask": _cell(row, "מה נדרש ממך"),
                "title": _cell(row, "הסעיף") or item_id,
                "waiter": _cell(row, "הכרעה נדרשת מ"),
                "picks": picks,
                "needsFill": needs_fill(row, pattern_id, picks),
                "patternId": pattern_id,
                "patternLabel": pattern_label,
                "groupId": classify_group(row),
                "versions": PAGE_VERSIONS.get(page_key) if pattern_id == "version-choice" else None,
                "wave": PAGE_WAVE.get(page_key),
            }
        )

    by_page: dict[str, list[dict]] = defaultdict(list)
    for it in open_items:
        by_page[it["pageKey"]].append(it)

    group_members: dict[str, list[str]] = defaultdict(list)
    for it in open_items:
        if it["groupId"]:
            group_members[it["groupId"]].append(it["itemKey"])
    group_label = {gid: lab for gid, lab, _ in GROUP_HINTS}
    for it in open_items:
        members = group_members.get(it["groupId"] or "") or []
        peers = [x for x in members if x != it["itemKey"]]
        it["groupPeers"] = peers
        it["groupLabel"] = group_label.get(it["groupId"], "") if len(members) > 1 else ""

    pattern_counts = Counter(it["patternId"] for it in open_items if it["patternId"] != "other")
    recurring = [
        {"id": pid, "label": lab, "count": pattern_counts[pid]}
        for pid, lab, _ in PATTERN_DEFS
        if pattern_counts.get(pid, 0) >= 2
    ]

    pages = []
    inventory: dict[str, list[dict]] = {"הוגש לבדיקה": [], "הוקפא": [], "טרם נבדק": []}
    for row in pages_rows:
        key = _cell(row, "#")
        path = _cell(row, "נתיב") or "/"
        items = by_page.get(key, [])
        rec = {
            "key": key,
            "title": _cell(row, "כותרת") or key,
            "path": path,
            "liveUrl": staging_url(path) if path.startswith("/") else "",
            "machine": _cell(row, "סטטוס מכונה"),
            "openCount": len(items),
            "agentNotes": _cell(row, "הערות סוכן"),
            "eyalSource": _cell(row, "מקור חומר (אייל)"),
            "versions": PAGE_VERSIONS.get(key),
            "liveState": PAGE_LIVE.get(key, ""),
            "wave": PAGE_WAVE.get(key),
        }
        inventory.setdefault(rec["machine"], []).append(rec)
        if rec["machine"] != "הוגש לבדיקה":
            continue
        pages.append(
            {
                "key": key,
                "title": rec["title"],
                "path": path,
                "liveUrl": rec["liveUrl"],
                "openCount": rec["openCount"],
                "versions": rec.get("versions"),
                "liveState": rec["liveState"],
                "wave": rec["wave"],
                "items": items,
                "needItems": items,
            }
        )

    eyal_n = len(open_items)
    nimrod_items = _nimrod_form_items()
    return {
        "pages": pages,
        "openItems": open_items,
        "needItems": open_items,
        "nimrodItems": nimrod_items,
        "recurring": recurring,
        "inventory": inventory,
        "counts": {
            "pages": len(pages),
            "openItems": eyal_n,
            "eyal": eyal_n,
            "nimrod": len(nimrod_items),
            "submitted": len(inventory.get("הוגש לבדיקה") or []),
            "frozen": len(inventory.get("הוקפא") or []),
        },
        "itemIds": [it["id"] for it in open_items],
        "pageByKey": page_by_key,
    }


def _nimrod_form_items() -> list[dict]:
    out: list[dict] = []
    for d in NIMROD_DECISIONS:
        path = str(d.get("path") or "")
        iid = str(d["id"])
        out.append(
            {
                "id": iid,
                "pageKey": str(d["pageKey"]),
                "itemKey": str(d.get("itemKey") or iid),
                "domId": f"nimrod__{iid}",
                "title": str(d["title"]),
                "ask": str(d["ask"]),
                "path": path,
                "liveUrl": staging_url(path) if path.startswith("/") else "",
                "picks": list(d.get("picks") or []),
                "needsFill": bool(d.get("needsFill")),
            }
        )
    return out


def _badge(text: str, kind: str) -> str:
    return f'<span class="s006-badge s006-badge--{escape(kind)}">{escape(text)}</span>'


def _item_html(it: dict) -> str:
    return _item_need_html(it)


def _item_need_html(it: dict) -> str:
    dom = it["domId"]
    bits = [
        f'<article class="s006-item s006-item--need" id="item-{escape(dom)}" ',
        f'data-id="{escape(it["id"])}" data-pattern="{escape(it["patternId"])}" ',
        f'data-waiter="{escape(it["waiter"])}" data-mode="need">\n',
        '<header class="s006-item__head">\n',
        f'<span class="s006-item__id">{escape(it["itemKey"])}</span>\n',
        f'<h3 class="s006-item__title">{escape(it["title"])}</h3>\n',
        '<span class="s006-item__badges">\n',
    ]
    bits.append(_badge("עדיין אצלך", "need") + "\n")
    if it["waiter"] == "נימרוד":
        bits.append(_badge("אצל נימרוד", "nimrod") + "\n")
    if it["patternLabel"]:
        bits.append(_badge(it["patternLabel"], "pattern") + "\n")
    bits.append("</span>\n</header>\n")
    bits.append(f'<p class="s006-item__ask">{escape(it["ask"])}</p>\n')
    if it.get("versions"):
        bits.append(_versions_html(it["versions"], compact=True))
    if it.get("groupLabel") and it.get("groupPeers"):
        bits.append(
            f'<p class="s006-item__twin">{escape(it["groupLabel"])} — גם {escape(" · ".join(it["groupPeers"]))}</p>\n'
        )
    bits.append('<div class="s006-fields">\n')
    bits.append(
        '<div class="s006-field s006-field--answer">\n'
        f'<label class="s006-label" for="answer-{escape(dom)}">תשובה (כמו עמודה D באקסל)</label>\n'
        f'<textarea class="s006-input" id="answer-{escape(dom)}" rows="4" '
        f'placeholder="כתבו כאן את התשובה — לא חייבים לבחור מהרשימה"></textarea>\n'
        "</div>\n"
    )
    if it["needsFill"]:
        bits.append(
            '<div class="s006-field">\n'
            f'<label class="s006-label" for="fill-{escape(dom)}">קישור, שם קובץ, או חומר מצורף</label>\n'
            f'<input class="s006-input" type="text" id="fill-{escape(dom)}" '
            f'placeholder="רק אם התשובה דורשת קובץ או כתובת">\n'
            "</div>\n"
        )
    if it.get("picks"):
        field = f"choice-{dom}"
        bits.append('<fieldset class="s006-choices">\n<legend>אם נוח — בחירה קצרה (רשות)</legend>\n')
        for i, pick in enumerate(it["picks"]):
            pid = f"{field}-{i}"
            bits.append(
                f'<label class="s006-choice" for="{escape(pid)}">'
                f'<input type="radio" name="{escape(field)}" id="{escape(pid)}" '
                f'value="{escape(pick)}"> {escape(pick)}</label>\n'
            )
        bits.append("</fieldset>\n")
    bits.append("</div>\n</article>\n")
    return "".join(bits)


def _page_chip(rec: dict) -> str:
    path = rec["path"] if rec["path"].startswith("/") else ""
    label = escape(rec["title"])
    versions = rec.get("versions") or {}
    vers = versions.get("versions") or []
    unique_urls = []
    seen = set()
    for v in vers:
        u = (v.get("url") or "").strip()
        if u and u not in seen:
            seen.add(u)
            unique_urls.append((v.get("label") or "גרסה", u))
    if len(unique_urls) >= 2:
        links = " · ".join(
            f'<a href="{escape(u)}" target="_blank" rel="noopener">{escape(lab)}</a>'
            f' <span dir="ltr" class="s006-path">{escape(_path_of(u))}</span>'
            for lab, u in unique_urls
        )
        return f"{label} — {links}"
    if rec.get("liveUrl") and path:
        return (
            f'<a href="{escape(rec["liveUrl"])}" target="_blank" rel="noopener">'
            f"{label}</a>"
            f' <span dir="ltr" class="s006-path">{escape(path)}</span>'
        )
    extra = f' <span dir="ltr" class="s006-path">{escape(path)}</span>' if path else ""
    return label + extra


def _path_of(url: str) -> str:
    u = url.replace(STAGING_ORIGIN, "") or "/"
    return u if u.startswith("/") else "/" + u


def _versions_html(block: dict, *, compact: bool = False) -> str:
    vers = block.get("versions") or []
    if not vers:
        return ""
    cls = "s006-versions" + (" s006-versions--compact" if compact else "")
    bits = [f'<div class="{cls}">\n']
    intro = block.get("intro") or ""
    if intro:
        bits.append(f'<p class="s006-versions__intro">{escape(intro)}</p>\n')
    bits.append('<ul>\n')
    seen_url: set[str] = set()
    for v in vers:
        url = (v.get("url") or "").strip()
        lab = v.get("label") or "גרסה"
        note = v.get("note") or ""
        dup = url in seen_url
        seen_url.add(url)
        bits.append("<li>")
        if url and not dup:
            bits.append(
                f'<a href="{escape(url)}" target="_blank" rel="noopener">{escape(lab)}</a>'
                f' <span dir="ltr" class="s006-path">{escape(_path_of(url))}</span>'
            )
        else:
            bits.append(f"<strong>{escape(lab)}</strong>")
            if dup:
                bits.append(" — באותו עמוד, גלול לתווית הזו")
        if note:
            bits.append(f'<span class="s006-versions__note">{escape(note)}</span>')
        bits.append("</li>\n")
    bits.append("</ul>\n</div>\n")
    return "".join(bits)


def freeze_reason_he(notes: str) -> str:
    s = notes or ""
    s = re.sub(r"הוקפא\s*\d{1,2}\.\d{1,2}\.\d{2,4}:\s*", "", s)
    s = re.sub(r"\s*לא ממציאים[^.]*\.?", "", s)
    s = re.sub(r"\s*אין להמציא[^.]*\.?", "", s)
    s = re.sub(r"\s*לא הומצא[^.]*\.?", "", s)
    s = re.sub(r"\s*WP-EI-\d+[^.]*\.?", "", s)
    s = re.sub(r",?\s*אין blog-defaults\.php", "", s)
    s = s.replace("החי PLACEHOLDER", "החי עדיין טיוטה")
    s = s.replace("zip מדיה אינו md", "קובץ התמונות אינו מקור עמוד")
    s = re.sub(r"\s*ילדים מחוץ לגל\.?", "", s)
    s = re.sub(r"\s*אב /learning/ לא נפתח\.?", "", s)
    return " ".join(s.split()).strip(" .")


THAW_HE = {
    "R1-06": "תיקיית חומר או קובץ סקירה לשער «לימוד והכשרה» ב-content 13.8.26.",
    "R1-07": "חבילת תוכן להכשרות למטפלים ב-content 13.8.26 (לא טיוטת צוות). גם השער /learning/ מוקפא.",
    "R1-20": "חבילת תוכן לארכיון הבלוג. 54 הפוסטים עצמם מתוכננים לסבב 2.",
    "R1-24": "מקור באנגלית שאישרת. בלי זה אין תרגום.",
    "R1-27": "תוכן עמוד לגלריות (טקסט או סקירה). קובץ zip של תמונות אינו מקור עמוד.",
    "R1-29": "יעד אמיתי לפריט «קורסים» בתפריט, או חבילת תוכן. כרגע מצביע ל-#. עמוד /learning/courses-external/ שייך לסבב 2.",
}


def thaw_needed_he(rec: dict) -> str:
    return THAW_HE.get(rec.get("key") or "") or (
        "חבילת חומר ב-content 13.8.26 (טקסט ו/או סקירה). בלי מקור ממך לא נפתח."
    )


def _status_for_eyal_html(model) -> str:
    """Plain-language status at the very top of the form.

    team_00: Eyal opens the form and must immediately understand what changed
    since his last review and what is being asked of him — client-facing, no
    row keys, no file names, no version numbers. Everything here is written from
    the tracker and from what is actually live, so it cannot drift from the
    pages he is about to look at.
    """
    o = STAGING_ORIGIN
    n = (model.get("counts") or {}).get("eyal") or 0
    return (
        '<section class="s006-round-today" aria-label="מה השתנה מאז ההערות שלך">\n'
        '<p class="s006-round-today__date">עדכון מצב · 8.9.2026</p>\n'
        "<h2>מה השתנה מאז ההערות שלך</h2>\n"
        "<p>קיבלנו את ההערות ששלחת ועברנו על כולן. ארבעה עמודים תוקנו ועלו לאתר "
        "הבדיקה, בעמוד נוסף תיקנו חלק וחלק שינינו קצת אחרת ממה שביקשת, ובשני נושאים גילינו שמה שביקשת כבר "
        "קיים ועובד — כדאי שתסתכל שוב לפני שתסמן.</p>\n"
        "<h3>תוקן ועלה לאתר</h3>\n"
        "<ul>\n"
        '<li><strong><a href="' + o + '/shop/" target="_blank" rel="noopener">חנות</a></strong>'
        " — הטקסט שביקשת עבר לראש העמוד מתחת לכותרת, והבלוק שחזר על עצמו הוסר.</li>\n"
        '<li><strong><a href="' + o + '/eyal-amit/mokesh-dahiman/" target="_blank" rel="noopener">'
        "מוקש דהימן</a></strong> — נוסף נגן של הסרט ליד טקסט הפתיחה, נוסף הכיתוב "
        "מתחת לתמונה, והבלוק «תחנות בדרכו של מוקש» ירד לתחתית העמוד מתחת לגלריה.</li>\n"
        '<li><strong><a href="' + o + '/faq/" target="_blank" rel="noopener">שאלות נפוצות</a>'
        "</strong> — כשלוחצים על נושא בראש העמוד, הכותרת כבר לא מוסתרת.</li>\n"
        '<li><strong><a href="' + o + '/snoring-sleep-apnea/" target="_blank" rel="noopener">'
        "נחירות ודום נשימה</a></strong> — שתי התמונות הוגדלו יותר מפי שניים, ומוצגות "
        "במלואן בלי חיתוך.</li>\n"
        "</ul>\n"
        "<h3>שינוי אחד שלא ביקשת — ורצינו שתדע</h3>\n"
        "<ul>\n"
        '<li><strong><a href="' + o + '/contact/" target="_blank" rel="noopener">צור קשר</a>'
        "</strong> — ביקשת להסיר את שדה «נושא הפנייה». נימרוד הכריע אחרת, ובלשונו: "
        "«לא טוב בלי נושא בכלל.» השדה נשאר, אבל <strong>כרשימה נפתחת</strong> במקום כתיבה "
        "חופשית, וכותרת המייל שמגיע אליך נבנית מהנושא שנבחר. <strong>וגם צדקת לגבי שני "
        "כפתורי הוואטסאפ</strong> — הכפתור הצף הוסר מהעמוד הזה, ונשאר אחד. יש למטה "
        "שאלה עם רשימת הנושאים המוצעת — נשמח שתאשר אותה או תתקן.</li>\n"
        "</ul>\n"
        "<h3>שני דברים שכבר היו תקינים</h3>\n"
        "<ul>\n"
        "<li><strong>החצים בקרוסלת ההמלצות</strong> — ביקשת חצים שיאפשרו לעצור ולהזיז "
        "ידנית במקום תנועה אוטומטית. הם קיימים ועובדים בכל העמודים, כבר מלפני ההערות "
        "שלך. סביר שראית גרסה ישנה של האתר.</li>\n"
        "<li><strong>מספר ההמלצות</strong> — בטיפול, בשיעורים ובסאונד הילינג המספר כבר "
        "בדיוק מה שביקשת. בדף הבית מוצגות 15 מתוך 16, ובעמוד הכלים 3 — שתי אלה מופיעות "
        "למטה כשאלה.</li>\n"
        "</ul>\n"
        f"<p><strong>מה מחכה לך כאן:</strong> {n} סעיפים לסימון. ברובם רק לבחור "
        "אפשרות מהרשימה; רק במעטים צריך להוסיף טקסט או קובץ. אין צורך לענות על הכול "
        "בבת אחת — התשובות נשמרות במחשב שלך.</p>\n"
        "</section>\n"
    )


def _round_today_html() -> str:
    """Dated banner for the 21.8.2026 content round. Keep above the original intro."""
    o = STAGING_ORIGIN
    return (
        '<section class="s006-round-today" aria-label="סבב 21.8.2026">\n'
        '<p class="s006-round-today__date">סבב 21.8.2026 · 11 גלים הושלמו · טופס אישור עמודים 23.8.2026</p>\n'
        "<h2>מה עלה באתר הבדיקה</h2>\n"
        "<p>זה <strong>סבב התשובות מ-19.8</strong> — יישום באתר הבדיקה. לא מחליף את סבב 1 "
        "המקורי, וגם לא פותח עדיין את סבב 2 (בלוג/QR) או סבב 3 (מובייל) שבטבלה למטה.</p>\n"
        "<ul>\n"
        "<li><strong>בית, טיפול, שיעורים</strong> — גל 1. "
        '<a href="' + o + '/" target="_blank" rel="noopener">בית</a> · '
        '<a href="' + o + '/treatment/" target="_blank" rel="noopener">טיפול</a> · '
        '<a href="' + o + '/lessons/" target="_blank" rel="noopener">שיעורים</a>.</li>\n'
        "<li><strong>אודות</strong> — גל 2, עמוד אחד מהמסמך המאוחד. "
        '<a href="' + o + '/eyal-amit/" target="_blank" rel="noopener">לעמוד</a>.</li>\n'
        "<li><strong>השיטה</strong> — גל 3. "
        '<a href="' + o + '/method/" target="_blank" rel="noopener">לעמוד</a>.</li>\n'
        "<li><strong>סאונד הילינג</strong> — גל 4. "
        '<a href="' + o + '/sound-healing/" target="_blank" rel="noopener">לעמוד</a>.</li>\n'
        "<li><strong>עדויות והמלצות</strong> — גל 5, קרוסלת חצים ידנית. "
        '<a href="' + o + '/testimonials/" target="_blank" rel="noopener">לעמוד</a>.</li>\n'
        "<li><strong>קטלוג וכלים</strong> — גל 6, שער עם חמש קוביות. "
        '<a href="' + o + '/shop/" target="_blank" rel="noopener">שער</a>.</li>\n'
        "<li><strong>ספרים</strong> — גל 7. "
        '<a href="' + o + '/books/" target="_blank" rel="noopener">שער ספרים</a>.</li>\n'
        "<li><strong>מוקש דהימן</strong> — גל 8. "
        '<a href="' + o + '/eyal-amit/mokesh-dahiman/" target="_blank" rel="noopener">לעמוד</a>.</li>\n'
        "<li><strong>שאלות נפוצות ונחירות</strong> — גל 9. "
        '<a href="' + o + '/faq/" target="_blank" rel="noopener">FAQ</a> · '
        '<a href="' + o + '/snoring-sleep-apnea/" target="_blank" rel="noopener">נחירות</a>.</li>\n'
        "<li><strong>הרצאות וסדנאות</strong> — גל 10. "
        '<a href="' + o + '/learning/lectures/" target="_blank" rel="noopener">הרצאות</a> · '
        '<a href="' + o + '/learning/workshops/" target="_blank" rel="noopener">סדנאות</a>.</li>\n'
        "<li><strong>מדיה לשלב הבא</strong> — גל 11 ניירת: תמונות/וידאו שנדחו נשארו באתר כמו שהם, "
        "בלי המצאות. תא ריק באקסל = אין הערות.</li>\n"
        "</ul>\n"
        "<p><strong>מה סוגר את סבב 1:</strong> אישור 23 העמודים שהוגשו, למסך מחשב. "
        "תשובות 19.8 כבר יושמו. מדיה חסרה (תמונות, וידאו) לא חוסמת — היא לשלב הבא. "
        "שאלה אחת נשארה בשאלות נפוצות (קישור הכשרות). תא ריק באקסל לא נשאל.</p>\n"
        "<p>הגיליון המלא נשאר ב-EA-CONTENT-TRACKER.xlsx בדרייב.</p>\n"
        "</section>\n"
    )


def _context_html(model: dict) -> str:
    inv = model.get("inventory") or {}
    submitted = inv.get("הוגש לבדיקה") or []
    frozen = inv.get("הוקפא") or []
    pending = inv.get("טרם נבדק") or []
    html = '<section class="s006-context" aria-label="קונטקסט">\n'

    html += "<h2>מה כבר עבר אצלנו — ואיך נבחרו העמודים</h2>\n"
    html += (
        "<p>סבב 1 הוא <strong>עמודי התפריט הראשי שכבר חיים באתר הבדיקה</strong>, "
        "ועמודים ששלחת להם חומר בתיקיית <strong>content 13.8.26</strong> בדרייב. "
        "ב-19.8.26 שלחת תשובות והערות נוספות; הן מיושמות עכשיו באתר (ראו סבב "
        "<strong>21.8.2026</strong> בראש העמוד). "
        "הבדיקה וההגשה הן <strong>למסך מחשב בלבד</strong> — מובייל יטופל בסבב נפרד.</p>\n"
        "<p>עמוד בלי חבילת חומר ממך לא קיבל תוכן שהמצאנו. הוא מוקפא עד שיהיה מקור.</p>\n"
        "<p>טיפול בדיג'רידו ואודות מוצגים עכשיו <strong>בכתובת אחת לכל עמוד</strong> "
        "(בלי גרסה כפולה).</p>\n"
    )
    html += (
        f"<p><strong>מוכנים לאישור באתר הבדיקה ({len(submitted)}):</strong> "
        "לכל עמוד קישור למטה, ואז סימון אושר / יש תיקון.</p>\n"
        '<ul class="s006-context-list s006-context-list--pages">\n'
    )
    for rec in submitted:
        note = f' — {escape(rec["liveState"])}' if rec.get("liveState") else (
            " — הוגש כפי שהוא, בלי שאלה פתוחה" if rec["openCount"] == 0 else ""
        )
        html += f"<li>{_page_chip(rec)}{note}</li>\n"
    html += "</ul>\n"
    if frozen:
        html += (
            f"<h2>מוקפאים ({len(frozen)}) — למה, ומה דרוש להפשרה</h2>\n"
            "<p>אין שאלה למלא כאן. ההפשרה היא חבילת חומר ממך בתיקייה, לא ניחוש שלנו.</p>\n"
            '<table class="s006-frozen">\n<thead><tr>'
            "<th>עמוד</th><th>למה הוקפא</th><th>מה דרוש להפשרה</th>"
            "</tr></thead>\n<tbody>\n"
        )
        for rec in frozen:
            reason = freeze_reason_he(rec.get("agentNotes") or "") or "אין חבילת חומר ממך לעמוד."
            html += "<tr>\n"
            html += (
                f"<td>{escape(rec['title'])}<br>"
                f'<span dir="ltr" class="s006-path">{escape(rec["path"])}</span></td>\n'
            )
            html += f"<td>{escape(reason)}</td>\n"
            html += f"<td>{escape(thaw_needed_he(rec))}</td>\n"
            html += "</tr>\n"
        html += "</tbody></table>\n"
    if pending:
        html += "<p><strong>עדיין לא נפתח אצלנו:</strong> "
        html += " · ".join(escape(r["title"]) for r in pending)
        html += " (פריט תפריט בלי יעד ברור).</p>\n"

    html += "<h2>מה השלבים הבאים</h2>\n"
    html += (
        '<ol class="s006-context-ol">\n'
        "<li>לכל עמוד שהוגש: פותחים את הקישור באתר הבדיקה, מסמנים "
        "<strong>אושר למסך מחשב</strong> או <strong>יש תיקון</strong> עם הערה. "
        "אפשר למלא חלק, לייצא JSON, ולחזור.</li>\n"
        "<li>שאלה אחת נשארה בשאלות נפוצות (קישור הכשרות). מדיה חסרה לא נשאלת כאן.</li>\n"
        "<li>סבב 1 נסגר כשכל העמודים שהוגשו מסומנים אושר — או הוחזרו לתיקון. "
        "רק אז נפתח סבב 2.</li>\n"
        "</ol>\n"
    )

    html += "<h2>סבב 2 וסבב 3 — מה בפנים</h2>\n"
    html += (
        "<p>סבב 1 (עכשיו) הוא הליבה: תפריט ראשי + עמודים ששלחת להם חומר. "
        "שני הסבבים הבאים:</p>\n"
        '<table class="s006-frozen s006-frozen--rounds">\n'
        "<thead><tr><th>סבב</th><th>מה בפנים</th><th>מתי</th></tr></thead>\n"
        "<tbody>\n"
        "<tr>\n"
        "<td>2</td>\n"
        "<td>\n"
        "<p>כל מה שכבר קיים באתר לגולש, ולא נכנס לסבב 1. שוב מסך מחשב בלבד. "
        "בלי להמציא תוכן.</p>\n"
        '<ul class="s006-round-bits">\n'
        "<li><strong>54 פוסטים</strong> בבלוג "
        "(הארכיון עצמו מוקפא בסבב 1 עד שתשלח חבילה).</li>\n"
        "<li><strong>49 עמודי QR</strong> — הדפים מאחורי הקודים המודפסים, "
        "כולל שער הקודים.</li>\n"
        "<li><strong>14 עמודים</strong> שקיימים באתר ולא בתפריט הראשי של סבב 1: "
        "אודות, מוקש דהימן, הצהרת נגישות, כתבות היסטוריות, קורסים חיצוניים, "
        "עיתונות, מדיניות פרטיות, שירותים, הופעות, תקנון, תודה, "
        "כלים ואביזרים, כלים בעבודת יד, תיקון כלים.</li>\n"
        "<li><strong>12 כתובות ישנות</strong> — רק לוודא שהן מפנות לכתובת החדשה, "
        "בלי לכתוב תוכן חדש.</li>\n"
        "</ul>\n"
        "</td>\n"
        "<td>נפתח רק אחרי שסבב 1 נסגר.</td>\n"
        "</tr>\n"
        "<tr>\n"
        "<td>3</td>\n"
        "<td>\n"
        "<p>תוכן תומך ועמודים שעוד לא קיימים. לא חלק מהליבה.</p>\n"
        '<ul class="s006-round-bits">\n'
        "<li><strong>מובייל</strong> — כל האתר כיחידה אחת. "
        "אישור בסבבים 1–2 הוא למסך מחשב.</li>\n"
        "<li>תיאורי תמונות, כותרות לחיפוש, קידום ואופטימיזציה.</li>\n"
        "<li>עמודים חדשים שעוד לא קיימים באתר.</li>\n"
        "</ul>\n"
        "</td>\n"
        "<td>שלב נפרד אחרי סבב 2. ייתכן שנעלה לאוויר לפניו.</td>\n"
        "</tr>\n"
        "</tbody></table>\n"
    )

    html += "<h2>על מה התבססנו — ואיך התייחסנו למה ששלחת</h2>\n"
    html += (
        '<ul class="s006-context-principles">\n'
        "<li>המקור הוא תיקיית <strong>content 13.8.26</strong> בדרייב, ואחריה תיקיית "
        "<strong>הערות של אייל לאחר סבב שלב 1 - 19.8.26</strong>. לא כתבנו מזיכרון וממסמכים ישנים.</li>\n"
        "<li>הטקסט שלך נכנס <strong>מילה במילה</strong>. בלי ניסוח מחדש, בלי «שיפור», "
        "ובלי השלמת פערים.</li>\n"
        "<li>בסקירה: אם מה שראית תואם למה שרצית ואין הערה — <strong>לא נגענו</strong>.</li>\n"
        "<li>חסרה תמונה, וידאו או כתובת — <strong>לא ממציאים</strong>. "
        "תא ריק = אין הערות. מדיה שנדחתה לשלב הבא נשארת בגיליון, לא בטופס.</li>\n"
        "<li>באתר מוצג רק מה שתקין. רשומה בלי תוכן נשארת בגיליון, לא ככרטיס ריק.</li>\n"
        "<li>קישור שכתבת במסמך ואינו קיים באתר נשאר כמו שכתבת, עד שתבחר כתובת אחרת או להסיר.</li>\n"
        "</ul>\n"
    )
    html += "</section>\n"
    return html


def _approve_html(page_key: str) -> str:
    field = f"approve-{page_key}"
    bits = [
        '<fieldset class="s006-approve">\n',
        "<legend>אישור העמוד למסך מחשב</legend>\n",
        '<div class="s006-choices s006-choices--approve">\n',
    ]
    for i, pick in enumerate(APPROVE_PICKS):
        pid = f"{field}-{i}"
        hint = f' — {escape(pick["hint"])}' if pick.get("hint") else ""
        bits.append(
            f'<label class="s006-choice" for="{escape(pid)}">'
            f'<input type="radio" name="{escape(field)}" id="{escape(pid)}" '
            f'value="{escape(pick["value"])}" '
            f'data-status="{escape(pick["status"])}"> '
            f'{escape(pick["label"])}{hint}</label>\n'
        )
    bits.append("</div>\n</fieldset>\n")
    return "".join(bits)


def _page_html(page: dict, *, with_filename: bool = False) -> str:
    need_n = page.get("openCount") or 0
    if need_n:
        meta = f"שאלה פתוחה אחת בעמוד הזה" if need_n == 1 else f"{need_n} שאלות פתוחות בעמוד הזה"
    else:
        meta = "אין שאלת תוכן פתוחה — רק אישור או תיקון"
    bits = [
        f'<section class="s006-page" id="page-{escape(page["key"])}">\n',
        '<header class="s006-page__head">\n',
        f'<h2 class="s006-page__title">{escape(page["title"])}</h2>\n',
        f'<p class="s006-page__meta">{escape(meta)}</p>\n',
    ]
    if page.get("liveUrl"):
        bits.append(
            f'<p class="s006-page__link"><a href="{escape(page["liveUrl"])}" '
            f'target="_blank" rel="noopener">העמוד באתר הבדיקה'
            f' <span dir="ltr">{escape(page["path"])}</span></a></p>\n'
        )
    if page.get("liveState"):
        bits.append(f'<p class="s006-page__state">{escape(page["liveState"])}</p>\n')
    if page.get("versions"):
        bits.append(_versions_html(page["versions"]))
    bits.append("</header>\n")
    if page.get("skipApproval"):
        bits.append(
            '<p class="s006-page__state">עדיין בעבודה — אין אישור אייל עד שיושלם המחקר. '
            "אפשר הערה ושם קובץ.</p>\n"
        )
    else:
        bits.append(_approve_html(page["key"]))
    for it in page.get("items") or []:
        bits.append(_item_html(it))
    bits.append(
        '<div class="s006-field s006-field--page-notes">\n'
        f'<label class="s006-label" for="pagenotes-{escape(page["key"])}">'
        "הערה לעמוד (חובה אם סימנת «יש תיקון»)</label>\n"
        f'<textarea class="s006-input" id="pagenotes-{escape(page["key"])}" rows="3" '
        f'placeholder="מה לשנות, או הערה חופשית"></textarea>\n'
        "</div>\n"
    )
    if with_filename:
        key = page["key"]
        bits.append(
            '<div class="s006-field s006-filewrap">\n'
            f'<label class="s006-label" for="pagefile-{escape(key)}">'
            "קובץ מצורף — נשמר רק שם הקובץ (הקובץ עצמו יסופק בדרייב בנפרד)</label>\n"
            f'<input class="s006-input" type="text" id="pagefile-{escape(key)}" '
            'placeholder="למשל: הערות-עמוד-אודות.pdf" autocomplete="off">\n'
            f'<label class="s006-filepick-lab" for="pagefilepick-{escape(key)}">'
            "בחירת קובץ כדי להעתיק את השם</label>\n"
            f'<input type="file" class="s006-filepick" id="pagefilepick-{escape(key)}" '
            f'data-target="pagefile-{escape(key)}">\n'
            "</div>\n"
        )
    bits.append("</section>\n")
    return "".join(bits)


def _nimrod_item_html(it: dict) -> str:
    dom = it["domId"]
    bits = [
        f'<article class="s006-item s006-item--nimrod" id="item-{escape(dom)}" ',
        f'data-id="{escape(it["id"])}" data-mode="nimrod">\n',
        '<header class="s006-item__head">\n',
        f'<span class="s006-item__id">{escape(it["itemKey"])}</span>\n',
        f'<h3 class="s006-item__title">{escape(it["title"])}</h3>\n',
        '<span class="s006-item__badges">\n',
        _badge("הכרעת נימרוד", "nimrod") + "\n",
        "</span>\n</header>\n",
    ]
    if it.get("liveUrl"):
        bits.append(
            f'<p class="s006-page__link"><a href="{escape(it["liveUrl"])}" '
            f'target="_blank" rel="noopener">העמוד באתר הבדיקה'
            f' <span dir="ltr">{escape(it["path"])}</span></a></p>\n'
        )
    bits.append(f'<p class="s006-item__ask">{escape(it["ask"])}</p>\n')
    bits.append('<div class="s006-fields">\n')
    bits.append(
        '<div class="s006-field s006-field--answer">\n'
        f'<label class="s006-label" for="answer-{escape(dom)}">הכרעה / הערה</label>\n'
        f'<textarea class="s006-input" id="answer-{escape(dom)}" rows="3" '
        f'placeholder="בחירה מהרשימה או ניסוח חופשי"></textarea>\n'
        "</div>\n"
    )
    if it.get("needsFill"):
        bits.append(
            '<div class="s006-field">\n'
            f'<label class="s006-label" for="fill-{escape(dom)}">קישור, ציטוט, או חומר מצורף</label>\n'
            f'<input class="s006-input" type="text" id="fill-{escape(dom)}" '
            f'placeholder="רק אם נדרש">\n'
            "</div>\n"
        )
    if it.get("picks"):
        field = f"choice-{dom}"
        bits.append('<fieldset class="s006-choices">\n<legend>בחירה</legend>\n')
        for i, pick in enumerate(it["picks"]):
            pid = f"{field}-{i}"
            bits.append(
                f'<label class="s006-choice" for="{escape(pid)}">'
                f'<input type="radio" name="{escape(field)}" id="{escape(pid)}" '
                f'value="{escape(pick)}"> {escape(pick)}</label>\n'
            )
        bits.append("</fieldset>\n")
    bits.append("</div>\n</article>\n")
    return "".join(bits)


def _nimrod_section_html(items: list[dict], *, variant: str = "r1-map") -> str:
    if not items:
        return ""
    if variant == "r2-live":
        kicker = "פנימי · נימרוד ממלא כאן עכשיו · לא למילוי אייל"
        title = "השלמות נדרשות מנימרוד"
        intro = (
            "כל סעיף שממתין להכרעת נימרוד בטרקר. "
            "סמנו בחירה או כתבו הערה — התשובות נשמרות במחשב זה. "
            "ייצוא נפרד בסוף הסקשן."
        )
    else:
        kicker = "פנימי · לא למילוי אייל · מקומי בלבד"
        title = "שאלות לנימרוד — סבב 2"
        intro = (
            "שבע הכרעות מהמיפוי (23.8). סמנו בחירה; הערה רק אם צריך. "
            "בסוף — ייצוא. יופיע קישור: תקבלו קובץ תשובות מלא "
            "(כל השבע בקובץ אחד, גם אם חלק ריק)."
        )
    bits = [
        '<section class="s006-nimrod-board" id="nimrod-decisions" aria-label="שאלות לנימרוד">\n',
        f'<p class="s006-nimrod-board__kicker">{escape(kicker)}</p>\n',
        f"<h2>{escape(title)}</h2>\n",
        f"<p>{escape(intro)}</p>\n",
    ]
    for it in items:
        bits.append(_nimrod_item_html(it))
    bits.append(
        '<div class="s006-toolbar s006-toolbar--nimrod">\n'
        '<span class="s006-progress" id="s006-nimrod-progress"></span>\n'
        '<button class="btn-export" type="button" id="btn-export-nimrod">'
        "ייצוא קובץ תשובות מלא</button>\n"
        "</div>\n"
        '<p class="s006-nimrod-file" id="s006-nimrod-file" hidden>\n'
        '<a id="s006-nimrod-file-a" download>תקבלו קובץ תשובות מלא</a>\n'
        "</p>\n"
        "</section>\n"
    )
    return "".join(bits)


def page_s006_review(*, head, nav, foot, generated_iso: str, default_respondent: str) -> str:
    model = load_model()
    c = model["counts"]
    submitted_n = c.get("submitted") or 0
    html = head(
        "אישור עמודים — סבב 1 — אייל עמית",
        extra_scripts=f'<link rel="stylesheet" href="assets/hub.css?v={ASSET_CACHE}">\n',
    )
    html += nav("s006-review")
    html += '<div class="wrap s006-wrap">\n'
    html += "<h1>אישור עמודים — סבב 1</h1>\n"
    html += _status_for_eyal_html(model)
    html += _round_today_html()
    html += _context_html(model)
    if model.get("nimrodItems"):
        html += (
            '<p class="s006-nimrod-jump"><a href="#nimrod-decisions">'
            "נימרוד · שבע הכרעות לסבב 2 (פנימי, לא לאייל)</a></p>\n"
        )

    html += '<p class="s006-section-kicker">החלק של אייל — זה סוגר את סבב 1</p>\n'
    html += (
        f'<p class="subtitle">{submitted_n} עמודים שהוגשו לאתר הבדיקה. '
        "לכל עמוד: פותחים, מסמנים אושר למסך מחשב או יש תיקון. "
        "מדיה חסרה לא חוסמת. "
    )
    if c["eyal"]:
        html += (
            f'שאלה פתוחה אחת נשארה בשאלות נפוצות. '
            "בסוף — ייצוא JSON.</p>\n"
        )
    else:
        html += "בסוף — ייצוא JSON.</p>\n"
    html += (
        '<p class="s006-tracker-ref">הגיליון המלא: '
        "<strong>EA-CONTENT-TRACKER.xlsx</strong> בדרייב · "
        '<a href="files/s006/latest-items.csv">CSV סעיפים</a></p>\n'
    )
    if model["recurring"]:
        html += '<div class="s006-patterns"><ul>\n'
        for p in model["recurring"]:
            html += (
                f'<li><button type="button" class="s006-chip" data-filter="{escape(p["id"])}">'
                f'{escape(p["label"])} · {p["count"]}</button></li>\n'
            )
        html += '<li><button type="button" class="s006-chip s006-chip--all" data-filter="">הכל</button></li>\n'
        html += "</ul></div>\n"
    html += '<nav class="s006-toc" aria-label="עמודים לאישור">\n<ul>\n'
    for page in model["pages"]:
        extra = f' · {page["openCount"]}' if page.get("openCount") else ""
        html += (
            f'<li><a href="#page-{escape(page["key"])}">{escape(page["title"])}'
            f"{extra}</a></li>\n"
        )
    html += "</ul></nav>\n"
    html += '<div class="s006-toolbar" id="s006-toolbar">\n'
    html += '<span class="s006-progress" id="s006-progress"></span>\n'
    html += (
        f'<label class="s006-resp">שם '
        f'<input type="text" id="respondent" value="{escape(default_respondent)}"></label>\n'
    )
    html += '<button class="btn-export" type="button" id="btn-export-s006">ייצוא תשובות ל-JSON</button>\n'
    html += "</div>\n"
    html += '<div id="s006-pages">\n'
    for page in model["pages"]:
        html += _page_html(page)
    html += "</div>\n"
    html += (
        '<div class="s006-field s006-field--page-notes">\n'
        '<label class="s006-label" for="pagenotes-GENERAL">'
        "הערות כלליות (רשות)</label>\n"
        '<textarea class="s006-input" id="pagenotes-GENERAL" rows="3" '
        'placeholder="אם יש הערה שלא שייכת לעמוד בודד"></textarea>\n'
        "</div>\n"
    )

    html += _nimrod_section_html(model.get("nimrodItems") or [])
    html += "</div>\n"

    cfg = {
        "exportType": EXPORT_TYPE,
        "schema": EXPORT_SCHEMA,
        "items": [{"id": it["id"], "domId": it["domId"], "pageKey": it["pageKey"]} for it in model["needItems"]],
        "pages": [{"key": p["key"], "path": p.get("path") or "", "title": p.get("title") or ""} for p in model["pages"]]
        + [{"key": "GENERAL", "path": "", "title": "הערות כלליות"}],
        "nimrodItems": [
            {
                "id": it["id"],
                "domId": it["domId"],
                "pageKey": it["pageKey"],
                "title": it.get("title") or "",
                "ask": it.get("ask") or "",
                "path": it.get("path") or "",
            }
            for it in (model.get("nimrodItems") or [])
        ],
        "defaultRespondent": default_respondent,
        "generatedAt": generated_iso,
        "storageKey": "ea-s006-review-v2",
        "exportFilePrefix": "eyal-s006-excel-answers-",
    }
    html += f'<script>window.S006_CONFIG={json.dumps(cfg, ensure_ascii=False)};</script>\n'
    html += f'<script src="assets/s006-review.js?v={ASSET_CACHE}"></script>\n'
    html += foot(generated_iso)
    return html


def _r2_chapter_id(wave: str, key: str) -> str:
    if key in SHOP_KEYS:
        return "shop"
    w = (wave or "").upper()
    if w.startswith("W5"):
        return "w5"
    if w.startswith("W4"):
        return "w4"
    if w.startswith("W3"):
        return "w3"
    if w.startswith("W2"):
        return "w2"
    if w.startswith("W1"):
        return "w1"
    return "other"


FORM_IA_META: tuple[tuple[str, str, str], ...] = (
    ("archive", "אודות וארכיון", "עמודים חיים בלי חבילת 13.8 — שאלות תחת כל עמוד"),
    ("shop", "חנות והפניות כלים", "שער החנות בסבב 1, וכתובות ישנות שמפנות אליו"),
    ("learn", "לימוד והפניות", "הרצאות, סדנאות, קורסים, והפניות ישנות"),
    ("books", "ספרים והפניות", "שער הספרים והכתובות הישנות של מוזה"),
    ("legal", "נגישות, פרטיות, תקנון", "ממתין לדוחות מחקר — בלי הדבקה"),
    ("blog", "פוסטים בבלוג", "54 פוסטים כמו שהם חיים"),
    ("qr", "QR מודפסים", "שער + קודים מודפסים — אין לשבור permalink"),
    ("legacy", "הפניות אחרות", "כתובות ישנות ליעדי סבב 1"),
)


def _form_ia_id(page: dict) -> str:
    ch = page.get("chapter") or ""
    path = page.get("path") or ""
    if page.get("key") in SHOP_KEYS or path.startswith("/tools-and-accessories"):
        return "shop"
    if ch == "w5" or path.startswith("/about"):
        return "archive"
    if ch == "w4":
        return "legal"
    if ch == "w3":
        return "blog"
    if ch == "w2":
        return "qr"
    if path.startswith("/muzeh") or path.startswith("/muzza"):
        return "books"
    if (
        path.startswith("/learning")
        or "courses" in path
        or path.startswith("/hashita")
        or "didgeridoo-lessons" in path
        or "didgeridoo-treatment" in path
    ):
        return "learn"
    return "legacy"


def _load_wave_assign() -> dict[str, str]:
    out: dict[str, str] = {}
    if not WAVE_ASSIGN.is_file():
        return out
    for row in _read_csv(WAVE_ASSIGN):
        key = _cell(row, "מזהה")
        if key:
            out[key] = _cell(row, "גל")
    return out


def _r2_item_from_row(row: dict, picks_map: dict[tuple[str, str], list[str]]) -> dict:
    page_key = _cell(row, "__page__")
    item_id = _cell(row, "#")
    pattern_id, pattern_label = classify_pattern(row)
    picks = picks_map.get((page_key, item_id)) or split_picks_r2(_cell(row, "אפשרויות לבחירה"))
    return {
        "pageKey": page_key,
        "itemKey": item_id,
        "id": f"{page_key}/{item_id}",
        "domId": f"{page_key}__{item_id}",
        "ask": _cell(row, "מה נדרש ממך"),
        "title": _cell(row, "הסעיף") or item_id,
        "waiter": _cell(row, "הכרעה נדרשת מ"),
        "picks": picks,
        "needsFill": needs_fill(row, pattern_id, picks),
        "patternId": pattern_id,
        "patternLabel": pattern_label,
        "groupId": "",
        "versions": None,
        "mark": _cell(row, "סקשן אצל אייל"),
        "path": "",
        "liveUrl": "",
    }


def _nest_paths(nodes: list[dict]) -> tuple[list[str], dict[str, list[str]]]:
    by_path = {n["path"]: n["key"] for n in nodes if (n.get("path") or "").startswith("/")}
    children: dict[str, list[str]] = defaultdict(list)
    claimed: set[str] = set()
    for path in sorted(by_path, key=len, reverse=True):
        parts = path.rstrip("/").split("/")
        parent = ""
        for i in range(len(parts) - 1, 0, -1):
            cand = "/".join(parts[:i]) + "/"
            if cand in by_path and cand != path:
                parent = cand
                break
        if parent:
            children[parent].append(path)
            claimed.add(path)
    roots = [p for p in sorted(by_path, key=lambda x: (x.count("/"), x)) if p not in claimed]
    for kids in children.values():
        kids.sort()
    return roots, children


def load_r2_model() -> dict:
    wave_map = _load_wave_assign()
    picks_map = _load_picks()
    pages_rows = [r for r in _read_csv(SNAPDIR / "latest.csv") if r.get("__sheet__") == ROUND2_SHEET]
    r1_rows = [r for r in _read_csv(SNAPDIR / "latest.csv") if r.get("__sheet__") == ROUND1_SHEET]

    eyal_items: list[dict] = []
    nimrod_items: list[dict] = []
    items_by_page: dict[str, list[dict]] = defaultdict(list)
    nimrod_by_page: dict[str, list[dict]] = defaultdict(list)
    for row in _read_csv(SNAPDIR / "latest-items.csv"):
        page_key = _cell(row, "__page__")
        if not page_key.startswith("R2-"):
            continue
        if is_action_item(row, waiter="אייל"):
            it = _r2_item_from_row(row, picks_map)
            eyal_items.append(it)
            items_by_page[page_key].append(it)
        elif is_action_item(row, waiter="נימרוד"):
            it = _r2_item_from_row(row, picks_map)
            it["domId"] = f"nimrod__{page_key}__{it['itemKey']}"
            nimrod_items.append(it)
            nimrod_by_page[page_key].append(it)

    all_pages: list[dict] = []
    for row in pages_rows:
        key = _cell(row, "#")
        path = _cell(row, "נתיב") or "/"
        machine = _cell(row, "סטטוס מכונה")
        items = items_by_page.get(key, [])
        live = staging_url(path) if path.startswith("/") else ""
        rec = {
            "key": key,
            "title": _cell(row, "כותרת") or key,
            "path": path,
            "liveUrl": live,
            "machine": machine,
            "inForm": machine == "הוגש לבדיקה",
            "skipApproval": machine != "הוגש לבדיקה",
            "hasCard": machine in {"הוגש לבדיקה", "בעבודה"},
            "openCount": len(items),
            "items": items,
            "nimrodItems": nimrod_by_page.get(key, []),
            "liveState": _cell(row, "הערות סוכן"),
            "wave": wave_map.get(key, ""),
            "chapter": _r2_chapter_id(wave_map.get(key, ""), key),
            "kind": _cell(row, "סוג"),
            "round": 2,
            "versions": None,
        }
        all_pages.append(rec)
        for it in items + rec["nimrodItems"]:
            it["path"] = path
            it["liveUrl"] = live

    form_pages = [p for p in all_pages if p["inForm"]]
    card_pages = [p for p in all_pages if p.get("hasCard")]
    by_chapter: dict[str, list[dict]] = defaultdict(list)
    for p in card_pages:
        by_chapter[_form_ia_id(p)].append(p)

    r1_pages = []
    for row in r1_rows:
        key = _cell(row, "#")
        path = _cell(row, "נתיב") or "/"
        machine = _cell(row, "סטטוס מכונה")
        r1_pages.append(
            {
                "key": key,
                "title": _cell(row, "כותרת") or key,
                "path": path,
                "liveUrl": staging_url(path) if path.startswith("/") else "",
                "machine": machine,
                "inForm": False,
                "hasCard": machine == "הוגש לבדיקה",
                "r1Card": machine == "הוגש לבדיקה",
                "openCount": 0,
                "chapter": "core",
                "kind": "סבב-1",
                "round": 1,
            }
        )

    r3_rows = [r for r in _read_csv(SNAPDIR / "latest.csv") if r.get("__sheet__") == ROUND3_SHEET]
    r3_pages = []
    for row in r3_rows:
        key = _cell(row, "#")
        path = _cell(row, "נתיב") or ""
        r3_pages.append(
            {
                "key": key,
                "title": _cell(row, "כותרת") or key,
                "path": path,
                "liveUrl": staging_url(path) if path.startswith("/") else "",
                "machine": _cell(row, "סטטוס מכונה"),
                "inForm": False,
                "openCount": 0,
                "chapter": "r3",
                "kind": _cell(row, "סוג") or "סבב-3",
                "round": 3,
            }
        )
    if not r3_pages:
        r3_pages = [dict(x) for x in R3_PLANNED]

    return {
        "pages": form_pages,
        "cardPages": card_pages,
        "allPages": all_pages,
        "r1Pages": r1_pages,
        "r3Pages": r3_pages,
        "needItems": eyal_items,
        "nimrodItems": nimrod_items,
        "byChapter": by_chapter,
        "counts": {
            "submitted": len(form_pages),
            "eyal": len(eyal_items),
            "nimrod": len(nimrod_items),
            "rows": len(pages_rows),
            "r3": len(r3_pages),
        },
    }


def _r2_node_badges(node: dict) -> str:
    bits = []
    if node.get("openCount"):
        n = node["openCount"]
        bits.append(_badge(f"{n} שאלות" if n != 1 else "שאלה", "need"))
    if node.get("nimrodItems"):
        bits.append(_badge("נימרוד", "nimrod"))
    if (node.get("kind") or "").find("301") >= 0 or (node.get("wave") or "").startswith("W1"):
        if node.get("chapter") == "w1" or node.get("key") in SHOP_KEYS:
            bits.append(_badge("הפניה", "pattern"))
    machine = node.get("machine") or ""
    if machine == "הוקפא" or machine.startswith("הוקפא"):
        bits.append(_badge("מוקפא", "pattern"))
    if machine == "בעבודה":
        bits.append(_badge("בעבודה", "nimrod"))
    mark = ""
    for it in (node.get("items") or []) + (node.get("nimrodItems") or []):
        m = (it.get("mark") or "").strip()
        if m.startswith("E-R2"):
            mark = m.split()[0]
            break
    if mark:
        bits.append(_badge(mark, "need"))
    return " ".join(bits)


def _r2_card_href(node: dict, *, on_form: bool) -> str:
    key = node.get("key") or ""
    if node.get("r1Card"):
        return f"s006-review.html#page-{escape(key)}"
    if node.get("hasCard") and str(key).startswith("R2-"):
        return f"#page-{escape(key)}" if on_form else f"s006-r2-review.html#page-{escape(key)}"
    if node.get("nimrodItems"):
        return "#nimrod-decisions" if on_form else "s006-r2-review.html#nimrod-decisions"
    return ""


LIVE_ICON_SVG = (
    '<svg class="s006-sitemap__icon" viewBox="0 0 16 16" width="14" height="14" '
    'aria-hidden="true" focusable="false">'
    '<path fill="currentColor" d="M6.5 2H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h10a1 1 0 0 0 '
    "1-1V9.5h-1.5V13H3V3h3.5V2zm3-1H15v5.5h-1.5V3.56L7.53 9.53 6.47 8.47l5.97-5.97H9.5V1z\"/>"
    "</svg>"
)

BACK_TOP_HTML = (
    '<a class="s006-backtop" href="#s006-top" id="s006-backtop">'
    "חזרה למעלה</a>\n"
)


def _r2_round_chip(node: dict) -> str:
    rnd = int(node.get("round") or 0)
    if rnd not in (1, 2, 3):
        return ""
    labels = {1: "סבב 1", 2: "סבב 2", 3: "סבב 3"}
    return (
        f'<span class="s006-round-chip" title="{escape(labels[rnd])}" '
        f'aria-label="{escape(labels[rnd])}">{rnd}</span>'
    )


def _r2_round_legend_html() -> str:
    return (
        '<ul class="s006-round-legend" aria-label="מקרא סבבים">\n'
        '<li class="s006-round s006-round--1">'
        '<span class="s006-round-chip" aria-hidden="true">1</span> '
        "סבב 1 — ליבה</li>\n"
        '<li class="s006-round s006-round--2">'
        '<span class="s006-round-chip" aria-hidden="true">2</span> '
        "סבב 2 — קיים לגולש, לא בליבה</li>\n"
        '<li class="s006-round s006-round--3">'
        '<span class="s006-round-chip" aria-hidden="true">3</span> '
        "סבב 3 — מתוכנן</li>\n"
        "</ul>\n"
    )


def _r2_page_li(node: dict, *, on_form: bool, children_html: str = "") -> str:
    title = escape(node.get("title") or node.get("key") or "")
    path = node.get("path") or ""
    url = node.get("liveUrl") or ""
    rnd = int(node.get("round") or 0)
    cls = f' class="s006-round s006-round--{rnd}"' if rnd in (1, 2, 3) else ""
    bits = [f"<li{cls}>"]
    chip = _r2_round_chip(node)
    if chip:
        bits.append(chip + " ")
    card = _r2_card_href(node, on_form=on_form)
    if card:
        bits.append(f'<a class="s006-sitemap__card" href="{card}">{title}</a>')
    else:
        bits.append(f"<span class=\"s006-sitemap__name\">{title}</span>")
    if url and path.startswith("/"):
        bits.append(
            f'<a class="s006-sitemap__live" href="{escape(url)}" target="_blank" rel="noopener" '
            f'title="העמוד באתר הבדיקה" aria-label="העמוד באתר הבדיקה: {title}">'
            f"{LIVE_ICON_SVG}</a>"
        )
    if path.startswith("/"):
        bits.append(f' <span dir="ltr" class="s006-path">{escape(path)}</span>')
    badges = _r2_node_badges(node)
    if badges:
        bits.append(" " + badges)
    if children_html:
        bits.append(children_html)
    bits.append("</li>\n")
    return "".join(bits)


def _r2_nested_list(nodes: list[dict], *, on_form: bool) -> str:
    by_path = {n["path"]: n for n in nodes if (n.get("path") or "").startswith("/")}
    roots, children = _nest_paths(nodes)

    def render_path(path: str) -> str:
        node = by_path[path]
        kids = children.get(path) or []
        inner = ""
        if kids:
            inner = "<ul>\n" + "".join(render_path(k) for k in kids) + "</ul>\n"
        return _r2_page_li(node, on_form=on_form, children_html=inner)

    leftover = [n for n in nodes if n.get("path") not in by_path]
    html = "<ul>\n"
    for path in roots:
        html += render_path(path)
    for n in leftover:
        html += _r2_page_li(n, on_form=on_form)
    html += "</ul>\n"
    return html


def _pick_path(nodes: list[dict], path: str) -> dict | None:
    for n in nodes:
        if n.get("path") == path:
            return n
    return None


def _take_matching(pool: list[dict], pred) -> list[dict]:
    taken, rest = [], []
    for n in pool:
        (taken if pred(n) else rest).append(n)
    pool[:] = rest
    return taken


def _branch_details(title: str, hint: str, inner: str, *, open_it: bool) -> str:
    open_attr = " open" if open_it else ""
    return (
        f'<li><details class="s006-sitemap__branch"{open_attr}>\n'
        f"<summary><strong>{escape(title)}</strong>"
        f'<span class="s006-sitemap__hint">{escape(hint)}</span></summary>\n'
        f"{inner}</details></li>\n"
    )


def _r2_ia_tree_html(model: dict, *, on_form: bool) -> str:
    """Site tree by menu / logical IA. Round colour is a marker, not the grouping."""
    pool = list(model.get("r1Pages") or []) + list(model.get("allPages") or [])
    r3 = list(model.get("r3Pages") or [])

    def pfx(*prefixes: str):
        return lambda n: any((n.get("path") or "").startswith(x) for x in prefixes)

    def exact(*paths: str):
        return lambda n: (n.get("path") or "") in paths

    bits = ["<ul class=\"s006-sitemap__tree\">\n"]

    def take_path(path: str) -> dict | None:
        node = _pick_path(pool, path)
        if node:
            pool[:] = [n for n in pool if n.get("path") != path]
        return node

    def take_key(key: str) -> dict | None:
        for n in pool:
            if n.get("key") == key:
                pool[:] = [x for x in pool if x.get("key") != key]
                return n
        return None

    def li(path: str, children_html: str = "") -> str:
        node = take_path(path)
        if not node:
            return children_html
        return _r2_page_li(node, on_form=on_form, children_html=children_html)

    def lis(paths: list[str]) -> str:
        return "".join(li(p) for p in paths)

    bits.append("<li><details class=\"s006-sitemap__branch\" open>\n")
    bits.append(
        "<summary><strong>תפריט ראשי</strong>"
        '<span class="s006-sitemap__hint">אותו סדר כמו בניווט החי בסטייג\'ינג</span></summary>\n'
        "<ul>\n"
    )
    bits.append(li("/"))
    snoring = li("/snoring-sleep-apnea/")
    bits.append(li("/treatment/", f"<ul>\n{snoring}</ul>\n" if snoring else ""))
    bits.append(lis(["/method/", "/lessons/", "/sound-healing/"]))

    learn_menu = lis(
        [
            "/learning/therapist-training/",
            "/learning/lectures/",
            "/learning/workshops/",
        ]
    )
    courses_item = take_key("R1-29")
    if courses_item:
        learn_menu += _r2_page_li(courses_item, on_form=on_form)
    learn_extra = _take_matching(
        pool,
        lambda n: (n.get("path") or "").startswith("/learning")
        or (n.get("path") or "").startswith("/courses-soon")
        or (n.get("path") or "").startswith("/hashita")
        or "didgeridoo-lessons" in (n.get("path") or "")
        or "didgeridoo-treatment" in (n.get("path") or ""),
    )
    if learn_extra:
        learn_menu += _branch_details(
            "שער לימוד והפניות ישנות",
            "לא כולם שורה בתפריט — שער + הפניות 301",
            _r2_nested_list(learn_extra, on_form=on_form),
            open_it=False,
        )
    bits.append(
        _branch_details(
            "לימוד והכשרה",
            "כמו בתפריט: הכשרות, קורסים, הרצאות, סדנאות",
            f"<ul>\n{learn_menu}</ul>\n" if learn_menu else "",
            open_it=True,
        )
    )

    shop_menu = lis(
        [
            "/shop/",
            "/repair/",
            "/didgeridoos/",
            "/bags/",
            "/stands-storage/",
            "/stand-floor/",
        ]
    )
    shop_extra = _take_matching(
        pool,
        lambda n: (n.get("path") or "").startswith("/tools-and-accessories")
        or "handmade-instruments" in (n.get("path") or ""),
    )
    if shop_extra:
        shop_menu += _branch_details(
            "כתובות ישנות לחנות",
            "הפניות לשער / לכלים / לתיקון",
            _r2_nested_list(shop_extra, on_form=on_form),
            open_it=False,
        )
    bits.append(
        _branch_details(
            "כלים ואביזרים",
            "כמו בתפריט החי — שער, תיקון, מכירה, תיקים, סטנדים",
            f"<ul>\n{shop_menu}</ul>\n" if shop_menu else "",
            open_it=True,
        )
    )

    book_menu = lis(
        [
            "/books/",
            "/books/tsva-bekahol/",
            "/books/kushi-blantis/",
            "/books/vekatavta/",
        ]
    )
    book_extra = _take_matching(
        pool,
        lambda n: (n.get("path") or "").startswith("/books")
        or (n.get("path") or "").startswith("/muzeh")
        or (n.get("path") or "").startswith("/muzza"),
    )
    if book_extra:
        book_menu += _branch_details(
            "הפניות מוזה / ספרים ישנים",
            "כתובות ישנות מקוננות",
            _r2_nested_list(book_extra, on_form=on_form),
            open_it=False,
        )
    bits.append(
        _branch_details(
            "ספרים",
            "כמו בתפריט: שער + שלושת הספרים",
            f"<ul>\n{book_menu}</ul>\n" if book_menu else "",
            open_it=True,
        )
    )

    blog_hub = take_path("/blog/")
    posts = _take_matching(
        pool,
        lambda n: (n.get("kind") or "").find("פוסט") >= 0 or n.get("chapter") == "w3",
    )
    blog_inner = "<ul>\n"
    if blog_hub:
        blog_inner += _r2_page_li(blog_hub, on_form=on_form)
    if posts:
        blog_inner += _branch_details(
            "54 פוסטים",
            "נפתח לפי הצורך — כל שם מוביל לכרטיס",
            _r2_nested_list(posts, on_form=on_form),
            open_it=False,
        )
    blog_inner += "</ul>\n"
    bits.append(_branch_details("בלוג דיג׳רידו", "כמו בתפריט · הפוסטים מקופלים", blog_inner, open_it=True))

    mokesh = take_path("/eyal-amit/mokesh-dahiman/")
    about_short = take_path("/about/")
    about_rest = _take_matching(
        pool,
        lambda n: (n.get("path") or "").startswith("/about")
        or (
            (n.get("path") or "").startswith("/eyal-amit")
            and (n.get("path") or "") != "/eyal-amit/"
        ),
    )
    eyal_kids = ""
    for n in [mokesh, about_short, *about_rest]:
        if n:
            eyal_kids += _r2_page_li(n, on_form=on_form)
    bits.append(
        li("/eyal-amit/", f"<ul>\n{eyal_kids}</ul>\n" if eyal_kids else "")
    )
    bits.append(lis(["/contact/", "/en/"]))
    bits.append("</ul></details></li>\n")

    more = _take_matching(pool, exact("/faq/", "/testimonials/", "/galleries/"))
    bits.append(
        _branch_details(
            "עמודים חיים מחוץ לתפריט הראשי",
            "FAQ, המלצות, גלריות — קיימים באתר, לא בשורת הניווט",
            _r2_nested_list(more, on_form=on_form) if more else "",
            open_it=True,
        )
    )

    archive = _take_matching(
        pool,
        exact(
            "/historical-articles/",
            "/press/",
            "/services/",
            "/shows-heritage/",
            "/thank-you/",
        ),
    )
    bits.append(
        _branch_details(
            "ארכיון חי (לא בתפריט)",
            "כתבות, עיתונות, שירותים, הופעות, תודה",
            _r2_nested_list(archive, on_form=on_form) if archive else "",
            open_it=True,
        )
    )

    legal = _take_matching(pool, exact("/accessibility/", "/privacy/", "/terms/"))
    bits.append(
        _branch_details(
            "משפטי",
            "נגישות, פרטיות, תקנון",
            _r2_nested_list(legal, on_form=on_form) if legal else "",
            open_it=True,
        )
    )

    qr = _take_matching(pool, pfx("/qr"))
    bits.append(
        _branch_details(
            "QR מודפסים",
            "שער + קודים — permalink נעול",
            _r2_nested_list(qr, on_form=on_form) if qr else "",
            open_it=False,
        )
    )

    leftover = [n for n in pool if (n.get("path") or "").startswith("/") or n.get("key")]
    if leftover:
        bits.append(
            _branch_details(
                "כתובות ישנות נוספות",
                "הפניות ליעדי סבב 1",
                _r2_nested_list(leftover, on_form=on_form),
                open_it=False,
            )
        )

    if r3:
        bits.append(
            _branch_details(
                "סבב 3 — מתוכנן",
                "מובייל, קידום, עמודים חדשים",
                _r2_nested_list(r3, on_form=on_form),
                open_it=False,
            )
        )

    bits.append("</ul>\n")
    return "".join(bits)


def _r2_sitemap_html(model: dict, *, on_form: bool) -> str:
    bits = [
        '<section class="s006-sitemap" id="s006-tree" aria-label="עץ אתר מלא">\n',
        "<h2>עץ האתר — לפי התפריט החי</h2>\n",
        "<p>הסדר למעלה כמו בניווט בסטייג'ינג. "
        "<strong>השם</strong> מוביל לכרטיס האישור וההערות. "
        "האיקון ליד השם פותח את העמוד באתר. "
        "צבע ומספר 1/2/3 הם רק סימון באיזה סבב העמוד בוצע או מתוכנן.</p>\n",
        _r2_round_legend_html(),
        _r2_ia_tree_html(model, on_form=on_form),
        "</section>\n",
    ]
    return "".join(bits)


def _r2_chapters_html(model: dict) -> str:
    by_ch = model.get("byChapter") or {}
    bits = ['<div id="s006-pages" class="s006-chapters">\n']
    for ch_id, title, hint in FORM_IA_META:
        pages = by_ch.get(ch_id) or []
        if not pages:
            continue
        qn = sum(p.get("openCount") or 0 for p in pages)
        extra = f"{len(pages)} עמודים"
        if qn:
            extra += f" · {qn} שאלות לאייל"
        if any(p.get("skipApproval") for p in pages):
            extra += " · בעבודה"
        open_attr = " open" if qn or ch_id in {"archive", "shop", "legal"} else ""
        bits.append(
            f'<details class="s006-chapter" data-chapter="{escape(ch_id)}" id="chapter-{escape(ch_id)}"{open_attr}>\n'
            f"<summary>{escape(title)} <span>{escape(extra)} — {escape(hint)}</span></summary>\n"
        )
        if ch_id == "shop":
            o = STAGING_ORIGIN
            bits.append(
                '<p class="s006-chapter__intro">העמודים החיים בסבב 1 (לא לאישור מחדש כאן): '
                f'<a href="{escape(o + "/shop/")}" target="_blank" rel="noopener">חנות</a> · '
                f'<a href="{escape(o + "/didgeridoos/")}" target="_blank" rel="noopener">כלים למכירה</a> · '
                f'<a href="{escape(o + "/repair/")}" target="_blank" rel="noopener">תיקון</a>. '
                "השאלה על איחוד מופיעה תחת ההפניה מ«כלים ואביזרים».</p>\n"
            )
        for page in pages:
            bits.append(_page_html(page, with_filename=True))
        bits.append("</details>\n")
    bits.append("</div>\n")
    return "".join(bits)


def page_s006_r2_review(*, head, nav, foot, generated_iso: str, default_respondent: str) -> str:
    model = load_r2_model()
    c = model["counts"]
    html = head(
        "אישור עמודים — סבב 2 — אייל עמית",
        extra_scripts=f'<link rel="stylesheet" href="assets/hub.css?v={ASSET_CACHE}">\n',
    )
    html += nav("s006-r2-review")
    html += '<div class="wrap s006-wrap s006-wrap--r2">\n'
    html += '<h1 id="s006-top">אישור עמודים — סבב 2</h1>\n'
    html += (
        '<p class="s006-section-kicker">טופס נפרד — לא מחליף את אישור סבב 1 · '
        "אין קישור בתפריט הראשי</p>\n"
        '<p class="subtitle">למעלה: עץ לפי התפריט החי בסטייג\'ינג. '
        "השם פותח את כרטיס האישור; האיקון לידו פותח את העמוד באתר. "
        "כפתור «חזרה למעלה» נשאר בזמן גלילה. "
        "שאלות תחת העמוד, הערה ושם קובץ לכל עמוד. "
        "הקובץ עצמו יסופק בדרייב; כאן נשמר רק השם. "
        '<a href="s006-r2-tree.html">עץ בחלון נפרד</a>.</p>\n'
        f'<p class="s006-tracker-ref">נגזר מטאב <strong>סבב-2</strong> בטרקר · '
        f'{c["submitted"]} הוגשו מתוך {c["rows"]} שורות · '
        f'{c["eyal"]} שאלות לאייל · {c["nimrod"]} לנימרוד.</p>\n'
    )
    html += _r2_sitemap_html(model, on_form=True)
    html += _nimrod_section_html(model.get("nimrodItems") or [], variant="r2-live")
    if not model["pages"]:
        html += (
            '<p class="s006-empty">טרם הוגשו עמודי סבב 2. '
            "הטופס יתמלא אוטומטית מהטרקר אחרי גלים 1–5 "
            "(סטטוס מכונה = הוגש לבדיקה).</p>\n"
        )
    else:
        html += '<p class="s006-section-kicker">החלק של אייל — לפי פרקים</p>\n'
        html += '<div class="s006-toolbar" id="s006-toolbar">\n'
        html += '<span class="s006-progress" id="s006-progress"></span>\n'
        html += (
            f'<label class="s006-resp">שם '
            f'<input type="text" id="respondent" value="{escape(default_respondent)}"></label>\n'
        )
        html += '<button class="btn-export" type="button" id="btn-export-s006">ייצוא תשובות ל-JSON</button>\n'
        html += "</div>\n"
        html += _r2_chapters_html(model)
        html += (
            '<div class="s006-field s006-field--page-notes">\n'
            '<label class="s006-label" for="pagenotes-GENERAL">'
            "הערות כלליות (רשות)</label>\n"
            '<textarea class="s006-input" id="pagenotes-GENERAL" rows="3" '
            'placeholder="אם יש הערה שלא שייכת לעמוד בודד"></textarea>\n'
            "</div>\n"
        )
    html += BACK_TOP_HTML
    html += "</div>\n"
    cfg = {
        "exportType": EXPORT_TYPE_R2,
        "schema": EXPORT_SCHEMA_R2,
        "storageKey": "ea-s006-r2-review-v2",
        "exportFilePrefix": "eyal-s006-r2-answers-",
        "items": [{"id": it["id"], "domId": it["domId"], "pageKey": it["pageKey"]} for it in model["needItems"]],
        "pages": [
            {
                "key": p["key"],
                "path": p.get("path") or "",
                "title": p.get("title") or "",
                "skipApproval": bool(p.get("skipApproval")),
            }
            for p in (model.get("cardPages") or model["pages"])
        ]
        + [{"key": "GENERAL", "path": "", "title": "הערות כלליות", "skipApproval": True}],
        "nimrodItems": [
            {
                "id": it["id"],
                "domId": it["domId"],
                "pageKey": it["pageKey"],
                "title": it.get("title") or "",
                "ask": it.get("ask") or "",
                "path": it.get("path") or "",
            }
            for it in (model.get("nimrodItems") or [])
        ],
        "defaultRespondent": default_respondent,
        "generatedAt": generated_iso,
    }
    html += f'<script>window.S006_CONFIG={json.dumps(cfg, ensure_ascii=False)};</script>\n'
    html += f'<script src="assets/s006-review.js?v={ASSET_CACHE}"></script>\n'
    html += foot(generated_iso)
    return html


def page_s006_r2_tree(*, head, nav, foot, generated_iso: str) -> str:
    """Full nested sitemap. Not in HUB_NAV_ITEMS."""
    model = load_r2_model()
    html = head(
        "עץ אתר — סבב 2 — אייל עמית",
        extra_scripts=f'<link rel="stylesheet" href="assets/hub.css?v={ASSET_CACHE}">\n',
    )
    html += nav("s006-r2-tree")
    html += '<div class="wrap s006-wrap s006-wrap--r2">\n'
    html += '<h1 id="s006-top">עץ האתר — לפי התפריט החי</h1>\n'
    html += (
        '<p class="s006-section-kicker">לא בתפריט הראשי · אודות לא 301 · '
        "איחוד חנות+תיקון לא מיושם ב-PHP</p>\n"
        '<p class="subtitle">אותו עץ כמו בראש '
        '<a href="s006-r2-review.html">טופס סבב 2</a>. '
        "השם פותח את כרטיס האישור; האיקון לידו פותח את העמוד באתר. "
        "כפתור «חזרה למעלה» נשאר בזמן גלילה.</p>\n"
    )
    html += _r2_sitemap_html(model, on_form=False)
    html += BACK_TOP_HTML
    html += "</div>\n"
    html += foot(generated_iso)
    return html


def copy_tracker_snapshots(dist_dir: Path) -> None:
    dest = dist_dir / "files" / "s006"
    dest.mkdir(parents=True, exist_ok=True)
    for name in ("latest-items.csv", "latest.csv"):
        src = SNAPDIR / name
        if src.is_file():
            dest.joinpath(name).write_text(src.read_text(encoding="utf-8"), encoding="utf-8")
    r19 = SNAPDIR / "r19-eyal-answers.json"
    if r19.is_file():
        dest.joinpath("r19-eyal-answers.json").write_text(r19.read_text(encoding="utf-8"), encoding="utf-8")
