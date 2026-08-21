#!/usr/bin/env python3
"""S006 temporary review form for Eyal.

SSOT is EA-CONTENT-TRACKER.xlsx. This page is regenerated from the tracker
snapshot each round: only items still waiting on Eyal or Nimrod.
Fields match the 19.8 Excel shape (free-text answer + page notes).
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
EXPORT_SCHEMA = "excel-v2"
ROUND1_SHEET = "סבב-1-ליבה"
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
    "R1-01": "גל 1 עלה 21.8. ציר הזמן ירד. וידאו בפרק 3 נשאר פלייסהולדר (H-06 לשלב 2/3).",
    "R1-02": "כתובת אחת /treatment/. ההשוואה ?compare=eyal כבויה. סרטון מפגש לשלב מדיה.",
    "R1-03": "גל 3 עלה 21.8: כותרת «עדויות והמלצות», כפתור לכל ההמלצות → /testimonials/. גל 5: קרוסלת חצים ידנית.",
    "R1-04": "גל 1 עלה 21.8. קישור הריון כפי שנתת. מקום לווידאו שמור.",
    "R1-05": "גל 4 עלה 21.8: בלוק אודות לפני CTA. שלד וידאו ב«איך זה עובד». גל 5: קרוסלת חצים ידנית.",
    "R1-10": "בתור גל 6 — כולל פיצול רשת הכלים. תמונות לשלב מאוחר.",
    "R1-11": "בתור גל 6. תמונות לשלב הבא; בלוק ההמלצות בתיקון יימחק לפי תשובתך.",
    "R1-12": "אין אקסל נפרד. הוראות חיות ב«עמוד קטלוג ראשי». בתור גל 6.",
    "R1-13": "בתור גל 6. תמונות לשלב הבא; 6 תמונות מהאתר הישן; bleed נשאר.",
    "R1-14": "בתור גל 6. באקסל נכתבו מזהי FLR בטעות — התשובות על סטנדים לאחסון.",
    "R1-15": "האקסל ריק. לא מנחשים. בתור גל 6 אחרי הכרעה.",
    "R1-16": "בתור גל 7. תמונות להשאיר; תמונת חבילה בהמשך. ניווט ספרים בגל 7.",
    "R1-17": "בתור גל 7.",
    "R1-18": "בתור גל 7. שני URL מנדלה — לא בוחרים בלי שורה.",
    "R1-19": "בתור גל 7. שורת גלריה תויגה כ-VKT-01 שוב.",
    "R1-21": "גל 2 עלה 21.8. עמוד אחד מ«אודות אייל עמית - סופי מאוחד.md». תמונות נשארו.",
    "R1-22": "בתור גל 8.",
    "R1-25": "בתור גל 9. FAQ-04 בלי תשובה באקסל — עדיין אצלך.",
    "R1-26": "גל 5 עלה 21.8: כותרת «עדויות והמלצות». נוסח דן הוחזר. קרוסלת חצים ידנית בעמודי השירות. תמונות פרופיל וסרטונים בהמשך.",
    "R1-28": "בתור גל 9. שני JPG בתיקייה. SNR-04 בלי תשובה באקסל — עדיין אצלך.",
}

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
    for path in sorted(SNAPDIR.glob("r1-*-items.json")):
        m = re.match(r"r1-(\d+)-items", path.name, re.I)
        page_key = f"R1-{int(m.group(1)):02d}" if m else ""
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


def is_action_item(row: dict) -> bool:
    ask = _cell(row, "מה נדרש ממך")
    if not ask or ask == "—":
        return False
    waiter = _cell(row, "הכרעה נדרשת מ")
    status = _cell(row, "סטטוס סעיף")
    if waiter not in HUMAN_WAITERS:
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
        if not page_key.startswith("R1-") or not is_action_item(row):
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
        if not items:
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

    eyal_n = sum(1 for it in open_items if it["waiter"] == "אייל")
    nimrod_n = sum(1 for it in open_items if it["waiter"] == "נימרוד")
    return {
        "pages": pages,
        "openItems": open_items,
        "needItems": open_items,
        "recurring": recurring,
        "inventory": inventory,
        "counts": {
            "pages": len(pages),
            "openItems": len(open_items),
            "eyal": eyal_n,
            "nimrod": nimrod_n,
        },
        "itemIds": [it["id"] for it in open_items],
        "pageByKey": page_by_key,
    }


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
    "R1-08": "חבילת תוכן להרצאות ב-content 13.8.26.",
    "R1-09": "חבילת תוכן לסדנאות ב-content 13.8.26.",
    "R1-20": "חבילת תוכן לארכיון הבלוג. 54 הפוסטים עצמם מתוכננים לסבב 2.",
    "R1-24": "מקור באנגלית שאישרת. בלי זה אין תרגום.",
    "R1-27": "תוכן עמוד לגלריות (טקסט או סקירה). קובץ zip של תמונות אינו מקור עמוד.",
    "R1-29": "יעד אמיתי לפריט «קורסים» בתפריט, או חבילת תוכן. כרגע מצביע ל-#. עמוד /learning/courses-external/ שייך לסבב 2.",
}


def thaw_needed_he(rec: dict) -> str:
    return THAW_HE.get(rec.get("key") or "") or (
        "חבילת חומר ב-content 13.8.26 (טקסט ו/או סקירה). בלי מקור ממך לא נפתח."
    )


def _round_today_html() -> str:
    """Dated banner for the 21.8.2026 content round. Keep above the original intro."""
    return (
        '<section class="s006-round-today" aria-label="סבב 21.8.2026">\n'
        '<p class="s006-round-today__date">סבב 21.8.2026</p>\n'
        "<h2>מה עלה היום באתר הבדיקה</h2>\n"
        "<p>זה <strong>סבב התשובות מ-19.8</strong> — יישום באתר הבדיקה בתאריך "
        "<strong>21.8.2026</strong>. לא מחליף את סבב 1 המקורי, וגם לא פותח עדיין "
        "את סבב 2 (בלוג/QR) או סבב 3 (מובייל) שבטבלה למטה.</p>\n"
        "<ul>\n"
        "<li><strong>בית, טיפול, שיעורים</strong> — גל 1 עלה. "
        "קישור מאמר ההריון בשיעורים תואם לכתובת שנתת.</li>\n"
        "<li><strong>אודות אייל עמית</strong> — גל 2: עמוד אחד מ"
        "«אודות אייל עמית - סופי מאוחד.md». שתי הגרסאות הקודמות ירדו. "
        '<a href="' + STAGING_ORIGIN + '/eyal-amit/" target="_blank" rel="noopener">'
        "לעמוד באתר הבדיקה</a>.</li>\n"
        "<li><strong>השיטה</strong> — גל 3 עלה: כותרת אחת «עדויות והמלצות», "
        "בלי כפילות שם-פרק קטן, כפתור לכל ההמלצות → /testimonials/. "
        "קרוסלת חצים ידנית. "
        '<a href="' + STAGING_ORIGIN + '/method/" target="_blank" rel="noopener">'
        "לעמוד השיטה</a>.</li>\n"
        "<li><strong>סאונד הילינג</strong> — גל 4 עלה: בלוק אודות לפני יצירת קשר, "
        "שלד וידאו ב«איך זה עובד». התמונות נשארו. "
        '<a href="' + STAGING_ORIGIN + '/sound-healing/" target="_blank" rel="noopener">'
        "לעמוד סאונד הילינג</a>.</li>\n"
        "<li><strong>עדויות והמלצות</strong> — גל 5 עלה: כותרת העמוד, נוסח דן, "
        "קרוסלת חצים ידנית (בלי גלילה אוטומטית). תמונות פרופיל וסרטונים בהמשך. "
        '<a href="' + STAGING_ORIGIN + '/testimonials/" target="_blank" rel="noopener">'
        "לעמוד העדויות</a>.</li>\n"
        "</ul>\n"
        "<p><strong>הטופס נגזר מהטרקר בכל סבב.</strong> "
        "השדות הם תשובה חופשית + הערות לדף (כמו האקסל), לא רדיו בלבד. "
        "סעיף שכבר נענה ב-19.8 עודכן בטרקר (בוצע / בעבודה / הוקפא) ואינו נשאל שוב.</p>\n"
        "<p>ייצוא בסוף העמוד הוא JSON במבנה האקסל (עמוד → תשובות + הערות דף). "
        "הגיליון המלא נשאר ב-EA-CONTENT-TRACKER.xlsx בדרייב.</p>\n"
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
        "(בלי גרסה כפולה). קישור לכל עמוד מופיע ליד השאלה, לא רק בראש העמוד.</p>\n"
    )
    html += (
        f"<p><strong>מוכנים לעיונך באתר הבדיקה ({len(submitted)}):</strong></p>\n"
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
        "<li>אתה עובר על השאלות למטה (או מאשר עמוד אחרי עמוד באתר הבדיקה). "
        "אפשר למלא חלק, לייצא JSON, ולחזור.</li>\n"
        "<li>אנחנו מיישמים את הבחירות באתר הבדיקה וחוזרים אליך רק אם נפתח משהו חדש.</li>\n"
        "<li>סבב 1 נסגר כשאתה כותב שהעמוד אושר — או כשהוא מוקפא עם סיבה. "
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
        "<li>חסרה תמונה, וידאו או כתובת — <strong>שואלים אותך</strong>, לא ממציאים.</li>\n"
        "<li>באתר מוצג רק מה שתקין. רשומה בלי תוכן נשארת בגיליון, לא ככרטיס ריק.</li>\n"
        "<li>קישור שכתבת במסמך ואינו קיים באתר נשאר כמו שכתבת, עד שתבחר כתובת אחרת או להסיר.</li>\n"
        "</ul>\n"
    )
    html += "</section>\n"
    return html


def _page_html(page: dict) -> str:
    need_n = page.get("openCount") or 0
    bits = [
        f'<section class="s006-page" id="page-{escape(page["key"])}">\n',
        '<header class="s006-page__head">\n',
        f'<h2 class="s006-page__title">{escape(page["title"])}</h2>\n',
        f'<p class="s006-page__meta">{escape(page["key"])} · {need_n} שאלות מהטרקר</p>\n',
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
    for it in page["items"]:
        bits.append(_item_html(it))
    bits.append(
        '<div class="s006-field s006-field--page-notes">\n'
        f'<label class="s006-label" for="pagenotes-{escape(page["key"])}">'
        "הערות תוכן נוספות לגבי הדף (כמו עמודה E באקסל)</label>\n"
        f'<textarea class="s006-input" id="pagenotes-{escape(page["key"])}" rows="4" '
        f'placeholder="כל מה ששייך לדף ולא לסעיף בודד"></textarea>\n'
        "</div>\n"
    )
    bits.append("</section>\n")
    return "".join(bits)


def page_s006_review(*, head, nav, foot, generated_iso: str, default_respondent: str) -> str:
    model = load_model()
    c = model["counts"]
    html = head(
        "שאלות לסגירה — סבב 21.8.2026 — אייל עמית",
        extra_scripts='<link rel="stylesheet" href="assets/hub.css?v=s006w7">\n',
    )
    html += nav("s006-review")
    html += '<div class="wrap s006-wrap">\n'
    html += "<h1>שאלות לסגירה — סבב 21.8.2026</h1>\n"
    html += _round_today_html()
    html += _context_html(model)

    who = []
    if c["eyal"]:
        who.append(f'{c["eyal"]} לאייל')
    if c["nimrod"]:
        who.append(f'{c["nimrod"]} לנימרוד')
    html += (
        f'<p class="subtitle">{c["openItems"]} שאלות פתוחות מהטרקר על {c["pages"]} עמודים'
        + (f' ({" · ".join(who)})' if who else "")
        + ". תשובה חופשית + הערות לדף. בסוף — ייצוא JSON.</p>\n"
    )
    html += '<p class="s006-section-kicker">השאלות הפתוחות בטרקר</p>\n'
    html += (
        '<p class="s006-tracker-ref">מזהה הסעיף זהה לגיליון '
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

    html += '<nav class="s006-toc" aria-label="עמודים עם שאלות מהטרקר">\n<ul>\n'
    for page in model["pages"]:
        html += (
            f'<li><a href="#page-{escape(page["key"])}">{escape(page["title"])} '
            f'({page["openCount"]})</a></li>\n'
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
    html += "</div>\n</div>\n"

    cfg = {
        "exportType": EXPORT_TYPE,
        "schema": EXPORT_SCHEMA,
        "items": [{"id": it["id"], "domId": it["domId"], "pageKey": it["pageKey"]} for it in model["needItems"]],
        "pages": [{"key": p["key"]} for p in model["pages"] if p.get("needItems")],
        "defaultRespondent": default_respondent,
        "generatedAt": generated_iso,
    }
    html += f'<script>window.S006_CONFIG={json.dumps(cfg, ensure_ascii=False)};</script>\n'
    html += '<script src="assets/s006-review.js"></script>\n'
    html += foot(generated_iso)
    return html


def copy_tracker_snapshots(dist_dir: Path) -> None:
    dest = dist_dir / "files" / "s006"
    dest.mkdir(parents=True, exist_ok=True)
    src = SNAPDIR / "latest-items.csv"
    if src.is_file():
        dest.joinpath("latest-items.csv").write_text(src.read_text(encoding="utf-8"), encoding="utf-8")
    r19 = SNAPDIR / "r19-eyal-answers.json"
    if r19.is_file():
        dest.joinpath("r19-eyal-answers.json").write_text(r19.read_text(encoding="utf-8"), encoding="utf-8")
