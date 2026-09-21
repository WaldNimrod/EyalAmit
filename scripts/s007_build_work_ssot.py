#!/usr/bin/env python3
"""One-shot ingest: assemble S007-WORK-SSOT.json from the five sources.

The JSON it writes is the SSOT. This script is provenance, not a second
source of status. After the first lock, edit the JSON (or re-run only with
care). Renderer and live retest never write status without an explicit check.
"""
from __future__ import annotations

import json
import re
import sys
from copy import deepcopy
from datetime import datetime, timezone
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent))
import s007_work_ssot as S  # noqa: E402

REPO = S.REPO
FORM = REPO / "_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html"
UNION = REPO / "_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/WORKING-UNION-FROM-C.json"
SRC_C = REPO / "docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/SOURCE-C-2026-09-21T1001Z--from-eyal.json"
OUT = S.SSOT_PATH
JERUSALEM_DATE = "2026-09-21"
STAGING = S.STAGING

VERIFY = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EYAL-IMMEDIATE-VERIFY-2026-09-21.md"
ASMADE = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/EYAL-IMMEDIATE-ASMADE-2026-09-21.md"
ATTACK = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/DEEP-AUDIT-ATTACK-2026-09-21.md"
MANDATE100 = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/HANDOFF_SELF_100_S007_CLOSE_2026-09-20_v1.md"
WAVE_A = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-A-COMPOSER-ADJUDICATION-2026-09-20.md"
WAVE_B = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-B-INDEPENDENT-VERIFY-2026-09-21.md"
TINT = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-B-TINT-VERIFY-2026-09-21.md"
CHECKPOINT = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/CHECKPOINT-EYAL-IMMEDIATE-2026-09-21.md"
TRACKER_CSV = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/EA-CONTENT-TRACKER-2026-09-20.csv"
SRC_C_FILE = "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/SOURCE-C-2026-09-21T1001Z--from-eyal.json"


def text(el: str) -> str:
    el = re.sub(r"<br\s*/?>", "\n", el, flags=re.I)
    el = re.sub(r"<[^>]+>", "", el)
    return html_unescape(el).strip()


def html_unescape(s: str) -> str:
    import html as h
    return h.unescape(s)


def parse_form_items(html: str) -> dict[str, dict]:
    chunks = re.split(r"(?=<div class=\"item)", html)
    out: dict[str, dict] = {}
    for ch in chunks:
        m = re.match(
            r'<div class="item( item--slim)?" data-id="([^"]+)" data-page="([^"]+)" data-path="([^"]+)"',
            ch,
        )
        if not m:
            continue
        slim = bool(m.group(1))
        iid, page, path = m.group(2), m.group(3), m.group(4)
        body = ch
        h3 = re.search(r"<h3>(.*?)</h3>", body, re.S)
        slink = re.search(r'<a class="slink"[^>]*>(.*?)</a>', body, re.S)
        title = text(h3.group(1)) if h3 else (text(slink.group(1)) if slink else iid)
        now_m = re.search(
            r'<div class="now"><span class="lbl">([^<]*)</span>(.*?)</div>', body, re.S
        )
        need_m = re.search(
            r'<div class="need"><span class="lbl">([^<]*)</span>(.*?)</div>', body, re.S
        )
        opts = [
            {"value": v, "label": text(lab)}
            for v, lab in re.findall(
                r'<input type="radio" name="[^"]+" value="([^"]+)"><span>(.*?)</span>',
                body,
                re.S,
            )
        ]
        dt = re.search(r'<span class="dt">([^<]+)</span>', body)
        out[iid] = {
            "slim": slim,
            "page": page,
            "path": path,
            "title": title,
            "nowLabel": text(now_m.group(1)) if now_m else "",
            "now": text(now_m.group(2)) if now_m else "",
            "needLabel": text(need_m.group(1)) if need_m else "",
            "need": text(need_m.group(2)) if need_m else "",
            "options": opts,
            "dateHint": dt.group(1) if dt else "",
        }
    return out


def live(path: str, check: str, date: str = JERUSALEM_DATE) -> dict:
    return {"url": S.live_url(path), "check": check, "date": date}


def item(**kw) -> dict:
    it = {
        "id": kw["id"],
        "formId": kw.get("formId", kw["id"] if kw.get("surface") in ("eyal_form", "both") else None),
        "trackerRow": kw.get("trackerRow"),
        "titleHe": kw["titleHe"],
        "path": kw.get("path") or "",
        "kind": kw["kind"],
        "surface": kw["surface"],
        "status": kw["status"],
        "waitingOn": kw["waitingOn"],
        "stampHe": kw.get("stampHe") or "",
        "summaryHe": kw.get("summaryHe") or "",
        "live": kw.get("live"),
        "eyal": kw.get("eyal"),
        "nimrod": kw.get("nimrod"),
        "form": kw.get("form"),
        "sources": kw.get("sources") or [],
        "section": kw.get("section") or "",
    }
    if it["status"] == "closed" and not it.get("live"):
        it["live"] = live(it["path"], "queued", JERUSALEM_DATE)
    if it["status"] != "closed" and it.get("live") is None and it.get("path"):
        it["live"] = {"url": S.live_url(it["path"]), "check": "", "date": ""}
    return it


# --- status overlay for the 129 form ids ---------------------------------
# Defaults: waiting / nimrod / both (content still in play).
# Immediate pack and explicit closes override.

CLOSED = {
    "A4": (
        "נסגר באתר הבדיקה · נוסח אייל חי",
        "שתי השורות חיים ב-/thank-you/. הפניית CF7 אחרי שליחה עדיין רק ב-JS — ראו EI-A4-E2E.",
        "VERIFY GET /thank-you/ two Eyal lines 2026-09-21",
    ),
    "B1": (
        "נסגר באתר הבדיקה — הסרטון מוטמע",
        "YouTube wDQoJauqsRM בפרק 03. אין Lorem.",
        "VERIFY iframe youtube.com/embed/wDQoJauqsRM 2026-09-21",
    ),
    "C2": (
        "נסגר — אישרת את הטקסט כמו שהוא",
        "אין שינוי נוסח. הקישור מהשאלות הנפוצות חובר (D3). העמוד עדיין טיוטת צוות מבחינת עומק תוכן.",
        "VERIFY /learning/therapist-training/ 200 2026-09-21",
    ),
    "D1": (
        "נסגר — סקשן ההמלצות ירד",
        "אין קרוסלת המלצות ואין CTA לכל העדויות ב-/didgeridoos/.",
        "VERIFY no testimonials section /didgeridoos/ 2026-09-21",
    ),
    "D2": (
        "נסגר — נשארו חמש־עשרה",
        "אין פעולה. 15 המלצות בדף הבית נשארו.",
        "VERIFY 15 testimonials home 2026-09-21",
    ),
    "D3": (
        "נסגר — הקישור מוביל להכשרות",
        "FAQ general-12 → /learning/therapist-training/. אין cbDidg-therapy-training.",
        "VERIFY FAQ href therapist-training 2026-09-21",
    ),
    "E6": (
        "נסגר — מחוץ לתפריט, אחרי טופס בלבד",
        "כפי שסימנת. העמוד חי בנוסח שלך.",
        "VERIFY /thank-you/ not in canonical nav 2026-09-21",
    ),
    "F3": (
        "נסגר — אסתמה בתי״ו",
        "אסתמה ב-defaults חיים. לא נוגעים בציטוטי לקוח / asthma.",
        "VERIFY אסתמה in home+method; no אסטמה 2026-09-21",
    ),
    "L1": (
        "נסגר — אושר, באנר הטיוטה ירד",
        "נוסח 18.9. רכז עדיין בטלפון בלי שם אדם.",
        "VERIFY /accessibility/ no pending-note 2026-09-21",
    ),
    "L2": (
        "נסגר — אושר ולהשאיר מדידה",
        "באנר ירד. Google מאחורי CMP.",
        "VERIFY /privacy/ no pending-note; measurement kept 2026-09-21",
    ),
    "L3": (
        "נסגר — אושר, באנר הטיוטה ירד",
        "נוסח 20.9.",
        "VERIFY /terms/ no pending-note 2026-09-21",
    ),
    "P016": (
        "נסגר — הפוסט ירד, הכתובת מפנה לבלוג",
        "GET בלי follow = 301 אל /blog/.",
        "VERIFY P016 301 /blog/ 2026-09-21",
    ),
    "P045": (
        "נסגר — הפוסט ירד, הכתובת מפנה לבלוג",
        "GET בלי follow = 301 אל /blog/.",
        "VERIFY P045 301 /blog/ 2026-09-21",
    ),
}

WAITING = {
    "A1": ("nimrod", "ממתין לנימרוד — אישרת מחיקה; חסרה שיטת 301 / 410 / ביטול פרסום"),
    "A2": ("nimrod", "ממתין לנימרוד — כן, ארכיון ולא לגולש מהתפריט. לא נבקש ממך טקסט שיווקי"),
    "A3": ("eyal", "ממתין לך — כתבות מהאתר הישן אחרי הסריקה שהבטחת"),
    "A5": ("nimrod", "ממתין לנימרוד על התפריט, ולך על קישור כשיהיה קורס באוויר"),
    "B2": ("eyal", "ממתין לך — דחית לכלי סינון המדיה 939"),
    "B3": ("eyal", "ממתין לך — אותו כלי 939"),
    "C1": ("nimrod", "הטקסט אושר. שלוש תמונות חסרות. חיבור לתפריט — שיחת נימרוד"),
    "C3": ("nimrod", "הנוסח שלך הגיע. ממתין לנימרוד: לפרסם עכשיו או לחכות לתמונות"),
    "E1": ("nimrod", "מחוץ לתפריט כפי שסימנת. סריקת האתר הישן לארכיון — ממתין לנימרוד"),
    "E2": ("nimrod", "תפריט — נימרוד ידבר איתך. לא נגענו בסרגל"),
    "E3": ("nimrod", "ממתין לנימרוד יחד עם מחיקת העמוד"),
    "E4": ("nimrod", "ממתין לנימרוד — מדיניות ארכיון"),
    "E5": ("nimrod", "ממתין לנימרוד — מדיניות ארכיון; החומר ממך אחרי סריקה"),
    "E7": ("nimrod", "תפריט — נימרוד ידבר איתך. אין קורס באוויר"),
    "F1": ("nimrod", "ממתין לנימרוד — מה קורה לכתובת הקצרה /about/"),
    "F2": ("nimrod", "ממתין לנימרוד יחד עם מיזוג האודות — להעביר שנת 2000 לארוך"),
}

EXCEPTIONS_DONE_HERO_OPEN = {
    "P002": "חריג קישורים נסגר. תמונת הירו מהמקור עדיין ממתינה לנימרוד",
    "P006": "חריג קישורים נסגר. תמונת הירו מהמקור עדיין ממתינה לנימרוד",
    "P008": "חריג תמונות נשים נסגר. תמונת הירו מהמקור עדיין ממתינה לנימרוד",
    "P048": "חריג קישור כושי בלאנטיס נסגר. תמונת הירו מהמקור עדיין ממתינה לנימרוד",
}


def overlay_for(iid: str, choice: str, note: str) -> tuple[str, str, str, str]:
    """→ status, waitingOn, stampHe, summaryHe"""
    if iid in CLOSED:
        stamp, summary, _chk = CLOSED[iid]
        return "closed", "none", stamp, summary
    if iid in WAITING:
        wo, stamp = WAITING[iid]
        return "waiting", wo, stamp, stamp
    if iid in EXCEPTIONS_DONE_HERO_OPEN:
        return "waiting", "nimrod", EXCEPTIONS_DONE_HERO_OPEN[iid], EXCEPTIONS_DONE_HERO_OPEN[iid]
    if iid.startswith("P") or iid.startswith("Q"):
        stamp = (
            "ממתין לנימרוד — העתקת תמונת הירו מהאתר המקורי, באצווה"
            if iid.startswith("P")
            else "ממתין לנימרוד — הירו מהמקור. כתובת הקוד לא משתנה"
        )
        return "waiting", "nimrod", stamp, stamp
    return "waiting", "nimrod", "ממתין לנימרוד", ""


def extra_items() -> list[dict]:
    closed_visual = lambda iid, title, summary, check, src, path="/": item(
        id=iid,
        formId=None,
        trackerRow=None,
        titleHe=title,
        path=path,
        kind="visual",
        surface="nimrod_board",
        status="closed",
        waitingOn="none",
        stampHe="נסגר באתר הבדיקה",
        summaryHe=summary,
        live=live(path, check),
        sources=src,
        section="waves",
        nimrod={"decision": "אושר ליישום", "note": ""},
    )
    return [
        item(
            id="T-NAV-HOLD",
            formId=None,
            titleHe="חרגת תפריט ראשי",
            path="/",
            kind="nav",
            surface="nimrod_board",
            status="waiting",
            waitingOn="nimrod",
            stampHe="ממתין לנימרוד — שיחה מול אייל לפני קוד סרגל",
            summaryHe="לא נוגעים ב-ea-canonical-nav.php / drawer / section-nav. T1/T2/T3/E2/E7/A5-תפריט.",
            nimrod={"decision": "חרגה עד שיחה עם אייל", "note": ""},
            sources=[CHECKPOINT, MANDATE100],
            section="nav",
        ),
        item(
            id="T-IA-SPOTLIGHT",
            titleHe="סקיצת «עכשיו באתר» בדף הבית",
            path="/",
            kind="nav",
            surface="nimrod_board",
            status="waiting",
            waitingOn="nimrod",
            stampHe="ממתין לנימרוד — סקיצה, לא קוד",
            summaryHe="ארבעה כרטיסים אחרי פרק הווידאו. אופציה ג (10 L1 ללא שינוי + רצועה). לא מממשים עד אישור.",
            sources=["file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html#spotlight"],
            section="nav",
        ),
        item(
            id="T-SERVICES-METHOD",
            formId="A1",
            trackerRow="R2-017",
            titleHe="שיטת מחיקת /services/",
            path="/services/",
            kind="ops",
            surface="nimrod_board",
            status="waiting",
            waitingOn="nimrod",
            stampHe="ממתין לנימרוד — 301 / 410 / ביטול פרסום",
            summaryHe="אייל: למחוק. אין קוד עד הכרעת שיטה.",
            eyal={"choice": "למחוק", "note": ""},
            sources=[SRC_C_FILE, TRACKER_CSV],
            section="gates",
        ),
        item(
            id="T-ABOUT-PERMALINK",
            formId="F1",
            trackerRow="R2-001",
            titleHe="/about/ מול /eyal-amit/",
            path="/about/",
            kind="ops",
            surface="nimrod_board",
            status="waiting",
            waitingOn="nimrod",
            stampHe="ממתין לנימרוד — permalink / QR",
            summaryHe="אייל: להשאיר את הארוך; להעביר שנת 2000. חסר מה קורה לכתובת הקצרה.",
            eyal={"choice": "להשאיר את הארוך בלבד", "note": ""},
            sources=[SRC_C_FILE],
            section="gates",
        ),
        item(
            id="T-EN-NOW",
            formId="C3",
            trackerRow="R1-24",
            titleHe="/en/ — טקסט עכשיו או אחרי תמונות",
            path="/en/",
            kind="content_gap",
            surface="nimrod_board",
            status="waiting",
            waitingOn="nimrod",
            stampHe="ממתין לנימרוד",
            summaryHe="נוסח אייל מלא הגיע. הערה אליך: לשלב תמונות. באנר Draft עדיין חי.",
            sources=[SRC_C_FILE, VERIFY],
            section="gates",
        ),
        item(
            id="T-HERO-BATCH",
            formId=None,
            trackerRow="R1-20",
            titleHe="באצ׳ הירו בלוג + QR",
            path="/blog/",
            kind="ops",
            surface="nimrod_board",
            status="waiting",
            waitingOn="nimrod",
            stampHe="ממתין לנימרוד — העתקה מהמקור בלי סקיצה לכל URL?",
            summaryHe="דפוס אחד. permalinks של QR לא זזים. חריגי גוף נפרדים (חלקם כבר ב-T19).",
            sources=[SRC_C_FILE],
            section="gates",
        ),
        item(
            id="T-LEARNING-PHOTOS",
            formId="C1",
            trackerRow="R1-06",
            titleHe="שלוש תמונות ב-/learning/",
            path="/learning/",
            kind="content_gap",
            surface="nimrod_board",
            status="waiting",
            waitingOn="nimrod",
            stampHe="ממתין לנימרוד — לחכות ל-939 או להציע שלוש",
            summaryHe="אייל אישר טקסט וביקש תמונה לכל אחד משלושת הבלוקים.",
            sources=[SRC_C_FILE],
            section="gates",
        ),
        item(
            id="T-AUDIT-SCOPE",
            titleHe="שיירי ביקורת עומק — בסבב הבא?",
            path="/",
            kind="a11y",
            surface="nimrod_board",
            status="waiting",
            waitingOn="nimrod",
            stampHe="ממתין לנימרוד — וואטסאפ צף, lang ב-EN, st3, כותרת מובייל",
            summaryHe="ATTACK P0 אין. DA-P1-01 Lorem נסגר ב-B1. השאר P2. DA-NAV סותר בריף ישן של גל א.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="EI-A4-E2E",
            formId="A4",
            trackerRow="R2-023",
            titleHe="הפניית טופס צור-קשר אל /thank-you/ — שליחה חיה",
            path="/contact/",
            kind="ops",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — העמוד חי; שליחת טופס אמיתית לא נבדקה",
            summaryHe="wpcf7mailsent ב-JS בלבד. VERIFY PARTIAL.",
            live={"url": S.live_url("/contact/"), "check": "not E2E", "date": JERUSALEM_DATE},
            sources=[VERIFY, ASMADE],
            section="ops",
        ),
        item(
            id="DA-WA-01",
            titleHe="כפתור וואטסאפ צף",
            path="/",
            kind="visual",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — נמדד בביקורת 21.9",
            summaryHe="left:22px, 54×54, מתחרה ב-CTA במובייל. לא WCAG 2.0.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-P2-A2",
            titleHe="/en/ — שפה של קטעים בעברית",
            path="/en/",
            kind="a11y",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — SC 3.1.2",
            summaryHe="html lang=en תקין. ריצות עברית בלי lang=he (תפריט/וואטסאפ).",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-P2-A3",
            titleHe="סמלי צעדים st3 בלי aria-hidden",
            path="/",
            kind="a11y",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — SC 1.1.1",
            summaryHe="שלושה SVG דקורטיביים בלי aria-hidden.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-P2-A4",
            titleHe="צעדי «איך מתחילים» לא כרשימה",
            path="/",
            kind="a11y",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — SC 1.3.1",
            summaryHe="שלושה DIV אחים, לא ul/ol.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-NAV-01",
            titleHe="צדדי כותרת מובייל (לוגו/תפריט)",
            path="/",
            kind="visual",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — קריאת בעלים 21.9 סותרת בריף גל א מיוני",
            summaryHe="עברית חיה: המבורגר משמאל, לוגו מימין. בעלים ביקש הפוך. לא מכריעים בשקט.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-NAV-02",
            titleHe="כותרת מובייל אחת לכל המשפחות",
            path="/",
            kind="visual",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — ארבע טביעות כותרת חיות",
            summaryHe="Chapters מול GP about/press מול קורסים חיצוניים מול EN. לא נעלם מהתור.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-NAV-03",
            titleHe="כפתור EN בתוך התפריט, לא בצ׳יפ כותרת",
            path="/",
            kind="nav",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — כפילות header + מגירה",
            summaryHe="`.nav__en` חי בכותרת; במגירה כבר יש `.ea-nd__pill`. חרגת תפריט חלה עד שיחה.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-LOGO-01",
            titleHe="לוגו = סימן בלבד, לא «eyal amit»",
            path="/about/",
            kind="visual",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — סותר WA-P03 שעבר בגל א",
            summaryHe="GP about/press: טקסט מותג בלי סימן. EN: «Eyal Amit» בלי סימן.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-P1-01",
            titleHe="Lorem בדף הבית",
            path="/",
            kind="content_gap",
            surface="nimrod_board",
            status="closed",
            waitingOn="none",
            stampHe="נסגר ב-B1",
            summaryHe="הטקסט המזויף והמקום השמור ירדו עם הטמעת היוטיוב.",
            live=live("/", "VERIFY no Lorem on home after B1 2026-09-21"),
            sources=[ATTACK, VERIFY],
            section="audit",
        ),
        item(
            id="DA-P2-05",
            titleHe="כותרת עמוד החנות (איכות, לא 2.4.2)",
            path="/shop/",
            kind="ops",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — «עמוד קטלוג ראשי»",
            summaryHe="לא כישל WCAG. H1 «כלים בעבודת יד ואביזרים».",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="DA-P2-06",
            titleHe="שני wa.me בעמוד פוסט",
            path="/2228-2/",
            kind="visual",
            surface="nimrod_board",
            status="open",
            waitingOn="nimrod",
            stampHe="פתוח — קישור בפוסט + כפתור צף",
            summaryHe="אח של WAF-03. לא נעלם מהתור.",
            sources=[ATTACK],
            section="audit",
        ),
        item(
            id="WA-SOUND",
            titleHe="כפתור שמע על הסרט",
            path="/",
            kind="visual",
            surface="nimrod_board",
            status="closed",
            waitingOn="none",
            stampHe="נסגר — אושר נימרוד",
            summaryHe="רק כשיש <video>, על ההירו, 44px, aria.",
            live=live("/", "HANDOFF row 1 CDP 74.57×44 on video"),
            nimrod={"decision": "אושר", "note": "שמע בדף הבית נראה סבבה"},
            sources=["file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/DONE-SOUND-TOGGLE-2026-09-22.md"],
            section="waves",
        ),
        closed_visual(
            "WA-A",
            "גל א — לוגו, פוטר, וואטסאפ צור-קשר, תווית תיקון, הירו שיעורים, פופ יידוע",
            "1.5.96 ואז תיקוני WAF 1.5.97. נימרוד אישר לממש את ה-WAF.",
            "WAVE-A hotfix CDP 390 overflow closed 2026-09-20",
            [WAVE_A],
        ),
        closed_visual(
            "WA-B",
            "גל ב — פירורים, contact ivory, nowrap, סרגל 56, CMP, href ישנים, טינט עדין",
            "תמה 1.5.99. אימות נפרד PASS. טינט ~10% terra wash.",
            "WAVE-B independent verify 1.5.99 + tint 2026-09-21",
            [WAVE_B, TINT],
        ),
        item(
            id="M13-ONE-NAV",
            titleHe="ניווט אחד לכל האתר",
            path="/",
            kind="nav",
            surface="internal",
            status="closed",
            waitingOn="none",
            stampHe="נסגר 20.9 — מנדט צוות 100",
            summaryHe="ea_canonical_nav_items בכל ה-URL. 137 CPT singles יצאו מפרסום, התוכן לא נמחק.",
            live=live("/", "157-URL one-nav accepted 2026-09-20; still 10 L1 on 1.5.100"),
            sources=[MANDATE100],
            section="ops",
        ),
        item(
            id="TYPO-CANON",
            titleHe="קנון טיפוגרפיה — טוקנים בלבד",
            path="/",
            kind="ops",
            surface="internal",
            status="closed",
            waitingOn="none",
            stampHe="נעול — team_00 2026-09-18",
            summaryHe="שנים-עשר --fs-* + שישה --fw-*. אסור font-size בקומפוננטה.",
            live=live("/", "theme tokens in ea-tokens.css; not retested this pack"),
            sources=["file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md"],
            section="ops",
        ),
    ]


def main() -> int:
    union = json.loads(UNION.read_text(encoding="utf-8"))
    form_items = parse_form_items(FORM.read_text(encoding="utf-8"))
    answers = {a["id"]: a for a in union["contentAnswers"]}
    if set(answers) != set(form_items):
        missing = set(form_items) ^ set(answers)
        raise SystemExit(f"form/union id mismatch: {sorted(missing)[:20]}")

    items: list[dict] = []
    for iid, fi in form_items.items():
        ans = answers[iid]
        st, wo, stamp, summary = overlay_for(iid, ans.get("choice") or "", ans.get("note") or "")
        chk = CLOSED[iid][2] if iid in CLOSED else ""
        it = item(
            id=iid,
            formId=iid,
            trackerRow=fi["page"],
            titleHe=fi["title"] or ans.get("title") or iid,
            path=ans.get("path") or fi["path"],
            kind="content_gap",
            surface="both",
            status=st,
            waitingOn=wo,
            stampHe=stamp,
            summaryHe=summary,
            live=live(ans.get("path") or fi["path"], chk) if st == "closed" else {
                "url": S.live_url(ans.get("path") or fi["path"]),
                "check": "",
                "date": "",
            },
            eyal={"choice": ans.get("choice") or "", "note": ans.get("note") or ""},
            form={
                "slim": fi["slim"],
                "nowLabel": fi["nowLabel"],
                "now": fi["now"],
                "needLabel": fi["needLabel"],
                "need": fi["need"],
                "options": fi["options"],
                "dateHint": fi["dateHint"],
            },
            sources=[SRC_C_FILE, VERIFY if iid in CLOSED else TRACKER_CSV],
            section=iid[0] if not iid.startswith("P") and not iid.startswith("Q") else iid[0],
        )
        items.append(it)

    items.extend(extra_items())

    doc = {
        "schema": S.SCHEMA,
        "isWorkSsot": True,
        "titleHe": "תור העבודה S007",
        "updated": JERUSALEM_DATE,
        "themeLive": "1.5.100",
        "staging": STAGING,
        "rules": {
            "status": list(S.STATUSES),
            "waitingOn": list(S.WAITING_ON),
            "surface": list(S.SURFACES),
            "kind": list(S.KINDS),
            "closedRequiresLiveCheck": True,
            "eyalFieldsImmutableExceptIngest": True,
            "nimrodFieldsOnlyFromBoard": True,
            "derivedHtmlMustNotInventStatus": True,
            "excelTracker": "archive as of 2026-09-20 — not live status",
            "handoff": "inter-team conversation — not SSOT",
        },
        "archives": {
            "tracker": {
                "role": "archive",
                "asOf": "2026-09-20",
                "csv": TRACKER_CSV,
                "xlsx": "EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx",
                "note": "May derive historical items and requirements. Must not write live status, waiting-on, or machine status for the S007 work queue.",
            },
            "workingUnionFormer": {
                "paths": [
                    "_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/WORKING-UNION-FROM-C.json",
                    "docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-21--content-gaps--from-eyal/WORKING-UNION-FROM-C.json",
                ],
                "now": "stubs pointing here",
            },
        },
        "provenance": {
            "eyalC": union["provenance"]["C"],
            "unionIngestedAt": union.get("ingestedAt"),
            "doNotIngestAsPageApprovals": True,
            "builtAt": datetime.now(timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ"),
        },
        "questions": [
            {
                "id": "Q-SERVICES-METHOD",
                "waitingOn": "nimrod",
                "promptHe": "אייל סימן למחוק את /services/. איך סוגרים: 301 לבית, 410, או ביטול פרסום בלי הפניה?",
            },
            {
                "id": "Q-ABOUT-PERMALINK",
                "waitingOn": "nimrod",
                "promptHe": "אייל משאיר את /eyal-amit/ ומעביר שנת 2000. מה קורה ל-/about/ בגלל קודי QR מודפסים?",
            },
            {
                "id": "Q-EN-NOW",
                "waitingOn": "nimrod",
                "promptHe": "הנוסח האנגלי הגיע. מפרסמים עכשיו בלי תמונות, או מחכים?",
            },
            {
                "id": "Q-HERO-BATCH",
                "waitingOn": "nimrod",
                "promptHe": "העתקת הירו מהמקור לכל P/Q בלי סקיצה לכל URL — מאשרים באצווה?",
            },
            {
                "id": "Q-LEARNING-PHOTOS",
                "waitingOn": "nimrod",
                "promptHe": "שלוש תמונות ב-/learning/: מחכים ל-939 של אייל, או מציעים שלוש מהמדיה?",
            },
            {
                "id": "Q-AUDIT-NEXT",
                "waitingOn": "nimrod",
                "promptHe": "שיירי ATTACK (וואטסאפ צף, כותרת מובייל, lang ב-EN, st3) — נכנסים לסבב הבא או נשארים אחרי ההשקה?",
            },
            {
                "id": "Q-DA-NAV-BRIEF",
                "waitingOn": "nimrod",
                "promptHe": "DA-NAV-01: ב-21.9 ביקשת המבורגר מימין ולוגו משמאל. בריף גל א מיוני היה הפוך. איזה בריף חי?",
            },
            {
                "id": "Q-COURSES-NAV",
                "waitingOn": "nimrod",
                "promptHe": "E7: אייל רוצה קורסים בתפריט כשיהיה קורס. אין קורס באוויר וחרגת תפריט בתוקף. משאירים מחוץ לתפריט עד השיחה?",
            },
        ],
        "items": items,
    }

    errors = S.validate(doc)
    if errors:
        print("\n".join(errors[:50]), file=sys.stderr)
        return 1
    OUT.write_text(json.dumps(doc, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    print(f"wrote {OUT} · {len(items)} items · sha12 {S.sha12_path(OUT)}")
    by = {}
    for it in items:
        by.setdefault(f"{it['status']}/{it['waitingOn']}", 0)
        by[f"{it['status']}/{it['waitingOn']}"] += 1
    for k, n in sorted(by.items()):
        print(f"  {k:24} {n}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
