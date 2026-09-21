#!/usr/bin/env python3
"""Derive Nimrod board + Eyal form from S007-WORK-SSOT.json.

No status string is written that is not already on the JSON item.
Usage (repo root):
  python3 scripts/s007_render_work_ssot.py
  python3 scripts/s007_render_work_ssot.py --ftp
"""
from __future__ import annotations

import argparse
import html
import json
import shutil
import sys
from datetime import datetime, timezone
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent))
import s007_work_ssot as S  # noqa: E402

BOARD_PATH = (
    S.REPO / "_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html"
)
FORM_PATH = S.REPO / "_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html"
HUB_COPY = S.REPO / "hub/dist/s007-content-gaps.html"
SSOT_FILE_URL = (
    "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/"
    "_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json"
)
BOARD_FILE_URL = (
    "file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/"
    "_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html"
)
FORM_LIVE = "http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html"

FORM_HEADS = {
    "A": (
        "חלק א · עמודים שאין בהם תוכן כלל",
        "בכל אחד מהם המילה שמופיעה באתר היום היא סימון פנימי שלנו, לא טקסט לגולש.",
    ),
    "B": ("חלק ב · סקשנים בתוך עמודים חיים שמחכים לחומר", ""),
    "C": ("חלק ג · עמודים שחיים בטקסט שהצוות כתב, לא בחומר שלך", ""),
    "D": ("חלק ד · פריטים בודדים חסרים בתוך עמודים עובדים", ""),
    "E": ("חלק ה · עמודים שאינם מופיעים בתפריט", ""),
    "F": ("חלק ו · שני עמודים על אייל — איזה מהם נשאר", ""),
    "L": ("חלק ח · שלושה עמודים משפטיים לאישור סופי", ""),
    "P": ("חלק ז · פוסטי בלוג, אחד־אחד", "תמונת הירו מהאתר המקורי — באצווה. permalinks לא זזים."),
    "Q": ("חלק ז־ב · עמודי קודים מודפסים", "אין לשבור permalink של QR."),
}


def esc(s: str | None) -> str:
    return html.escape(s or "", quote=True)


def stamp_class(it: dict) -> str:
    if it["status"] == "closed":
        return "st-done"
    wo = it.get("waitingOn")
    if wo == "eyal":
        return "st-wait-eyal"
    if wo == "nimrod":
        return "st-wait-nim"
    if wo == "team10":
        return "st-wait-t10"
    if it["status"] == "open":
        return "st-part"
    return "st-hold"


def tag_class(it: dict) -> str:
    if it["status"] == "closed":
        return "done"
    if it.get("waitingOn") == "eyal":
        return "hold"
    if it.get("kind") == "nav" or it["id"].startswith("T-NAV") or it["id"].startswith("DA-NAV"):
        return "nav"
    if it["status"] == "open":
        return "q"
    return "waitn"


def form_items(data: dict) -> list[dict]:
    return [it for it in data["items"] if it["surface"] in ("eyal_form", "both")]


def board_items(data: dict) -> list[dict]:
    return [it for it in data["items"] if it["surface"] in ("nimrod_board", "both", "internal")]


def counts(items: list[dict]) -> dict[str, int]:
    out: dict[str, int] = {}
    for it in items:
        k = f"{it['status']}/{it['waitingOn']}"
        out[k] = out.get(k, 0) + 1
    return out


def radios(it: dict) -> str:
    choice = ((it.get("eyal") or {}).get("choice") or "").strip()
    opts = (it.get("form") or {}).get("options") or []
    if not opts:
        opts = [
            {"value": "מאושר", "label": "מאושר"},
            {"value": "יש הערה", "label": "יש הערה"},
        ]
    bits = []
    for o in opts:
        val = o.get("value") or ""
        lab = o.get("label") or val
        chk = " checked" if choice and choice == val else ""
        bits.append(
            f'<label class="opt"><input type="radio" name="{esc(it["id"])}" '
            f'value="{esc(val)}"{chk}><span>{esc(lab)}</span></label>'
        )
    return "\n".join(bits)


def slim_radios(it: dict) -> str:
    choice = ((it.get("eyal") or {}).get("choice") or "").strip()
    opts = (it.get("form") or {}).get("options") or [
        {"value": "מאושר", "label": "מאושר"},
        {"value": "יש הערה", "label": "יש הערה"},
    ]
    bits = []
    for o in opts:
        val = o.get("value") or ""
        lab = o.get("label") or val
        chk = " checked" if choice and choice == val else ""
        bits.append(
            f'<label class="mini"><input type="radio" name="{esc(it["id"])}" '
            f'value="{esc(val)}"{chk}><span>{esc(lab)}</span></label>'
        )
    return "".join(bits)


FORM_CSS = """
  :root{
    --ink:#16130f; --muted:#6b6257; --line:#e3ddd3; --paper:#fbf9f5; --card:#fff;
    --accent:#8a5a2b; --warn:#9c3b1e; --ok:#3f6b42;
    --r:12px;
  }
  *{box-sizing:border-box}
  body{margin:0;background:var(--paper);color:var(--ink);
       font-family:"Heebo","Assistant","Arial Hebrew",Arial,sans-serif;
       font-size:17px;line-height:1.65}
  .wrap{max-width:860px;margin:0 auto;padding:28px 18px 90px}
  header{border-bottom:2px solid var(--ink);padding-bottom:18px;margin-bottom:8px}
  h1{font-size:1.9rem;margin:0 0 6px;line-height:1.25}
  .date{font-weight:700;color:var(--accent)}
  .lede{color:var(--muted);margin:10px 0 0}
  .note{background:#fff5e8;border:1px solid #e8d3b4;border-radius:var(--r);
        padding:14px 16px;margin:18px 0}
  .note strong{color:var(--warn)}
  h2{font-size:1.32rem;margin:38px 0 4px;padding-top:18px;border-top:1px solid var(--line)}
  h2 .cnt{font-size:.8rem;color:var(--muted);font-weight:400}
  .sub{color:var(--muted);margin:0 0 16px}
  .item{background:var(--card);border:1px solid var(--line);border-radius:var(--r);
        padding:16px 18px;margin:14px 0}
  .item h3{margin:0 0 2px;font-size:1.1rem}
  .path{font-size:.86rem;color:var(--muted);margin:0 0 10px}
  .path a{color:var(--accent)}
  .now,.need{margin:8px 0;padding:9px 12px;border-radius:8px;font-size:.95rem}
  .now{background:#f4f1ea;border-right:3px solid var(--muted)}
  .need{background:#eef4ee;border-right:3px solid var(--ok)}
  .lbl{font-weight:700;display:block;margin-bottom:2px;font-size:.82rem;
       letter-spacing:.02em;color:var(--muted)}
  .need .lbl{color:var(--ok)}
  .quote{font-style:italic}
  fieldset{border:0;margin:12px 0 0;padding:0}
  legend{font-weight:700;font-size:.9rem;margin-bottom:6px}
  .opt{display:flex;align-items:flex-start;gap:9px;padding:8px 10px;margin:4px 0;
       border:1px solid var(--line);border-radius:8px;cursor:pointer;background:#fff}
  .opt:hover{background:#f7f4ee}
  .opt input{margin:4px 0 0;width:19px;height:19px;flex:none;accent-color:var(--accent)}
  .opt span{flex:1}
  textarea{width:100%;min-height:62px;margin-top:8px;padding:9px 11px;
           border:1px solid var(--line);border-radius:8px;font:inherit;font-size:.95rem;
           background:#fff;resize:vertical}
  .bar{position:sticky;bottom:0;background:var(--paper);border-top:2px solid var(--ink);
       padding:14px 0 10px;margin-top:34px}
  button{font:inherit;font-weight:700;padding:12px 20px;border-radius:10px;
         border:1px solid var(--ink);background:var(--ink);color:#fff;cursor:pointer;
         min-height:48px}
  button.ghost{background:#fff;color:var(--ink)}
  #out{width:100%;min-height:150px;margin-top:12px;font-family:ui-monospace,Menlo,monospace;
       font-size:12px;direction:ltr;text-align:left;display:none}
  .done{color:var(--ok);font-weight:700;margin-inline-start:10px}
  footer{margin-top:26px;color:var(--muted);font-size:.85rem;border-top:1px solid var(--line);
         padding-top:14px}
  .item--slim{padding:9px 12px;margin:5px 0}
  .slim{display:flex;align-items:center;gap:9px;flex-wrap:wrap}
  .slink{flex:1 1 300px;min-width:0;color:var(--accent);font-size:.95rem}
  .dt{font-size:.8rem;color:var(--muted);white-space:nowrap}
  .mini{display:inline-flex;align-items:center;gap:5px;font-size:.87rem;
        border:1px solid var(--line);border-radius:999px;padding:5px 11px;cursor:pointer;min-height:38px}
  .mini:hover{background:#f7f4ee}
  .mini input{width:17px;height:17px;margin:0;accent-color:var(--accent)}
  .item--slim textarea{min-height:38px;flex:1 1 180px;margin-top:0}
  .board{background:#fff;border:2px solid var(--ink);border-radius:var(--r);padding:16px 18px;margin:18px 0}
  .board h2{border:0;margin:0 0 8px;padding:0;font-size:1.22rem}
  .board .lede{margin:0 0 12px}
  .board table{width:100%;border-collapse:collapse;font-size:.92rem;margin:8px 0 14px}
  .board th,.board td{border:1px solid var(--line);padding:7px 9px;text-align:right;vertical-align:top}
  .board th{background:#f4f1ea}
  .st{display:inline-block;font-size:.78rem;font-weight:700;padding:3px 10px;border-radius:999px;margin:6px 0 4px;line-height:1.35}
  .st-done{background:#e7f2e8;color:#3f6b42}
  .st-wait-eyal{background:#fff5e8;color:#9c3b1e}
  .st-wait-nim{background:#e8eef8;color:#2c4a6e}
  .st-wait-t10{background:#efe6f4;color:#5a3a6e}
  .st-hold{background:#f4f1ea;color:#6b6257}
  .st-part{background:#efe6d8;color:#6b4420}
  .meta{font-size:.82rem;color:var(--muted)}
  @media print{.bar,button,#out{display:none}.item{break-inside:avoid}}
"""

BOARD_CSS = """
  :root{
    --ivory:#fffffa; --ivory-2:#efeae1; --dark:#0E0905;
    --terra:#B5663D; --terra-dk:#9A4F2B; --ink:#2f2013; --body:#67482d;
    --sand:#D8C7B5; --ok:#dce9d4; --wait:#fff3d6; --ask:#f3e4d6;
    --bf:Heebo,-apple-system,Arial,sans-serif;
  }
  *{box-sizing:border-box}
  body{margin:0;background:#f3eee6;color:var(--ink);font:16px/1.55 var(--bf)}
  header.page{padding:28px 32px;background:var(--dark);color:#fff}
  header.page h1{margin:0 0 8px;font-size:22px;font-weight:600}
  header.page p{margin:0 0 6px;color:rgba(255,255,255,.78);max-width:86ch}
  header.page a{color:#E8C4A8}
  .wait{background:#fff3d6;border:1px solid #e0c36a;padding:14px 18px;border-radius:10px;margin:18px 32px}
  nav.toc{display:flex;flex-wrap:wrap;gap:8px;padding:8px 32px 20px;background:#fff;border-bottom:1px solid var(--sand)}
  nav.toc a{color:var(--terra);text-decoration:none;border:1px solid var(--sand);padding:6px 12px;border-radius:999px;font-size:13px}
  section.item{padding:28px 32px;border-bottom:8px solid #e4d8c8}
  section.item h2{margin:0 0 4px}
  .path{margin:0 0 14px;color:var(--body);font-size:14px}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
  @media(max-width:900px){.grid{grid-template-columns:1fr}}
  .box{background:#fff;border:1px solid var(--sand);border-radius:12px;padding:14px 16px}
  .box h3{margin:0 0 8px;font-size:14px;color:var(--terra-dk)}
  .box p,.box li{margin:0 0 8px}
  .box ul{margin:0;padding:0 18px 0 0}
  .eyal{background:#fff}
  .us{background:#f7f3ed}
  table{width:100%;border-collapse:collapse;background:#fff;font-size:14px;margin:12px 0}
  th,td{border:1px solid var(--sand);padding:8px 10px;text-align:right;vertical-align:top}
  th{background:var(--ivory-2)}
  .tag{display:inline-block;font-size:12px;padding:2px 8px;border-radius:999px;background:var(--ivory-2);margin-left:6px}
  .tag.go{background:var(--ok)}
  .tag.done{background:#cfe8c8}
  .tag.hold{background:var(--wait)}
  .tag.q{background:#f4d4c4}
  .tag.waitn{background:#dce6f4}
  .tag.nav{background:#e8d0c4;color:#5a2e18}
  .hold-nav{background:#f4e4d8;border:1px solid #c98962;padding:14px 18px;border-radius:10px;margin:18px 32px}
  .nav-bar{display:flex;align-items:center;gap:10px;height:56px;padding:0 18px;background:rgba(20,14,9,.96);color:#fff;border-radius:10px 10px 0 0;overflow:hidden;font-size:13px}
  .nav-bar .brand{font-weight:650;margin-left:8px;white-space:nowrap}
  .nav-bar .l1{display:flex;gap:8px;flex-wrap:nowrap;overflow:hidden;opacity:.95}
  .nav-bar .l1 span{white-space:nowrap;padding:4px 2px}
  .nav-bar .l1 .dd::after{content:" ▾";font-size:9px;opacity:.7}
  .tree{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px}
  .branch{background:#fff;border:1px solid var(--sand);border-radius:12px;padding:12px 14px}
  .branch h3{margin:0 0 8px;font-size:14px}
  .branch ul{margin:0;padding:0 16px 0 0;color:var(--body);font-size:13px}
  .branch .muted{color:#a08068;font-size:12px}
  .ia-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
  @media(max-width:1000px){.ia-grid{grid-template-columns:1fr}}
  .ia-card{background:#fff;border:1px solid var(--sand);border-radius:12px;overflow:hidden}
  .ia-card.rec{border-color:var(--terra);box-shadow:0 0 0 1px var(--terra)}
  .ia-card .hd{background:var(--dark);color:#fff;padding:10px 14px;font-size:14px;font-weight:650}
  .ia-card .bd{padding:12px 14px}
  .ia-card .count{font-size:12px;color:var(--terra-dk);margin:0 0 8px}
  .pill-row{display:flex;flex-wrap:wrap;gap:6px;margin:8px 0 12px}
  .pill{background:var(--ivory-2);border-radius:999px;padding:4px 10px;font-size:12px}
  .home-flow{display:flex;flex-direction:column;gap:8px;max-width:720px}
  .home-row{border-radius:10px;padding:12px 16px;background:#fff;border:1px dashed var(--sand);color:var(--body);font-size:13px}
  .home-row.hi{border:2px solid var(--terra);background:#fff8f2;color:var(--ink)}
  .home-row.dark{background:#1a120c;color:#fff;border:0}
  .spot{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:8px}
  @media(max-width:800px){.spot{grid-template-columns:repeat(2,1fr)}}
  .scard{background:#fff;border:1px solid var(--sand);border-radius:10px;overflow:hidden}
  .scard .ph{height:88px;background:linear-gradient(160deg,#2A1A0C,#9A4F2B)}
  .scard .tx{padding:8px 10px}
  .scard h4{margin:0 0 4px;font-size:13px}
  .scard p{margin:0;font-size:12px;color:var(--body)}
  pre{white-space:pre-wrap;font:13px/1.45 ui-monospace,Menlo,monospace;margin:0;max-height:220px;overflow:auto;background:var(--ivory-2);padding:10px;border-radius:8px}
  .filters{display:flex;flex-wrap:wrap;gap:8px;padding:0 32px 12px}
  .filters button{font:inherit;font-size:13px;padding:6px 12px;border-radius:999px;border:1px solid var(--sand);background:#fff;cursor:pointer}
  .filters button.on{background:var(--dark);color:#fff;border-color:var(--dark)}
"""

SKETCH = r"""
<section class="item" id="navtree">
  <h2>עץ האתר כפי שהוא בתפריט היום</h2>
  <p class="path">סקיצה לשיחה — לא אתר חי. מקור: ea_canonical_nav_items(). דסקטופ אחרי גלילה = 56px. עשרה כפתורי L1. «קורסים» = /learning/courses-external/ («יעלה בקרוב»).</p>
  <div class="nav-bar" aria-hidden="true">
    <span class="brand">אייל עמית</span>
    <div class="l1">
      <span class="dd">טיפול בדיג׳רידו</span>
      <span>השיטה</span>
      <span>שיעורי דיג׳רידו</span>
      <span>סאונד הילינג</span>
      <span class="dd">לימוד והכשרה</span>
      <span class="dd">כלים ואביזרים</span>
      <span class="dd">ספרים</span>
      <span>בלוג דיג׳רידו</span>
      <span class="dd">אייל עמית</span>
      <span>צור קשר</span>
    </div>
  </div>
  <div class="tree" style="margin-top:14px">
    <div class="branch"><h3>בית</h3><p class="muted">לוגו בלבד בדסקטופ. במגירה — שורה «בית».</p></div>
    <div class="branch"><h3>טיפול בדיג׳רידו</h3><ul><li>טיפול בדיג׳רידו</li><li>נחירות ודום נשימה בשינה</li></ul></div>
    <div class="branch"><h3>השיטה</h3><p class="muted">עמוד בודד /method/</p></div>
    <div class="branch"><h3>שיעורי דיג׳רידו</h3><p class="muted">עמוד בודד /lessons/</p></div>
    <div class="branch"><h3>סאונד הילינג</h3><p class="muted">עמוד בודד /sound-healing/</p></div>
    <div class="branch"><h3>לימוד והכשרה</h3><p class="muted">כפתור, בלי קישור לאב</p><ul><li>הכשרות למטפלים</li><li>קורסים → /learning/courses-external/ — יעלה בקרוב</li><li>הרצאות</li><li>סדנאות</li></ul></div>
    <div class="branch"><h3>כלים ואביזרים</h3><ul><li>כלים בעבודת יד ואביזרים</li><li>תיקון וחידוש</li><li>כלי דיג׳רידו למכירה</li><li>תיקים</li><li>סטנדים לאחסון</li><li>סטנד רצפתי לנגינה</li></ul></div>
    <div class="branch"><h3>ספרים</h3><ul><li>מבצעים</li><li>צבע בכחול וזרוק לים</li><li>כושי בלאנטיס</li><li>וכתבת</li></ul></div>
    <div class="branch"><h3>בלוג דיג׳רידו</h3><p class="muted">עמוד בודד /blog/</p></div>
    <div class="branch"><h3>אייל עמית</h3><p class="muted">כפתור, בלי קישור לאב</p><ul><li>אודות אייל → /eyal-amit/</li><li>מוקש דהימן — לזכרו</li></ul></div>
    <div class="branch"><h3>צור קשר</h3><p class="muted">עמוד בודד /contact/</p></div>
  </div>
  <div class="ia-grid" style="margin-top:16px">
    <div class="ia-card"><div class="hd">אופציה א — ארבעה פתחים</div><div class="bd">
      <p class="count">4 כפתורי L1 במקום 10</p>
      <div class="pill-row"><span class="pill">טיפול ועבודה</span><span class="pill">ללמוד</span><span class="pill">חנות</span><span class="pill">אייל</span></div>
      <p>הכי ברור לאורח חדש. דורש הרגל מחדש.</p>
    </div></div>
    <div class="ia-card"><div class="hd">אופציה ב — שישה</div><div class="bd">
      <p class="count">6 כפתורי L1 — קיצוץ מתון</p>
      <div class="pill-row"><span class="pill">טיפול ▾</span><span class="pill">שיעורים</span><span class="pill">סאונד</span><span class="pill">לימוד ▾</span><span class="pill">חנות ▾</span><span class="pill">אייל ▾</span></div>
      <p>שומר על שלושת שירותי הליבה בשורה.</p>
    </div></div>
    <div class="ia-card rec"><div class="hd">אופציה ג — לחץ מהבית · מומלץ עכשיו</div><div class="bd">
      <p class="count">התפריט נשאר כמו שהוא</p>
      <div class="pill-row"><span class="pill">10 L1 ללא שינוי</span><span class="pill">+ רצועת «עכשיו באתר»</span></div>
      <p>ברירת מחדל כל עוד אין שיחת תפריט.</p>
    </div></div>
  </div>
</section>
<section class="item" id="spotlight">
  <h2>סקיצה — רצועת «עכשיו באתר» בדף הבית</h2>
  <p class="path">לא «חדשות». ארבעה יעדים שאייל בוחר. לא מממשים עד אישור.</p>
  <div class="home-flow">
    <div class="home-row dark">01 הירו — כותרת + וידאו רקע (קיים)</div>
    <div class="home-row">02 מה זה טיפול בנשימה (קיים)</div>
    <div class="home-row">03 וידאו YouTube (חבילת מיידי)</div>
    <div class="home-row hi">
      <strong>חדש — «עכשיו באתר»</strong>
      <div class="spot">
        <div class="scard"><div class="ph"></div><div class="tx"><h4>כלי דיג׳רידו למכירה</h4><p>עמוד חנות פנימי</p></div></div>
        <div class="scard"><div class="ph"></div><div class="tx"><h4>כושי בלאנטיס</h4><p>ספר</p></div></div>
        <div class="scard"><div class="ph"></div><div class="tx"><h4>הכשרות למטפלים</h4><p>עמוד לימוד</p></div></div>
        <div class="scard"><div class="ph"></div><div class="tx"><h4>פוסט מהבלוג</h4><p>אייל מחליף</p></div></div>
      </div>
    </div>
    <div class="home-row">04 טיפול או סאונד הילינג (קיים)</div>
  </div>
</section>
"""


def render_form_item(it: dict) -> str:
    stamp = S.stamp_he(it)
    live = (it.get("live") or {}).get("url") or S.live_url(it.get("path") or "/")
    slim = bool((it.get("form") or {}).get("slim"))
    note = ((it.get("eyal") or {}).get("note") or "")
    if slim:
        dt = esc((it.get("form") or {}).get("dateHint") or "")
        dt_html = f'<span class="dt">{dt}</span>' if dt else ""
        return f"""
<div class="item item--slim" data-id="{esc(it['id'])}" data-page="{esc(it.get('trackerRow') or '')}" data-path="{esc(it.get('path') or '')}" data-status="{esc(it['status'])}" data-waiting="{esc(it['waitingOn'])}">
  <div class="slim">
    <a class="slink" href="{esc(live)}" target="_blank" rel="noopener">{esc(it['titleHe'])}</a>
    {dt_html}
    {slim_radios(it)}
    <textarea name="note-{esc(it['id'])}" placeholder="הערה">{esc(note)}</textarea>
  </div>
  <div class="st {stamp_class(it)}">{esc(stamp)}</div>
</div>"""
    form = it.get("form") or {}
    now_html = ""
    if form.get("now"):
        now_html = (
            f'<div class="now"><span class="lbl">{esc(form.get("nowLabel") or "מה מוצג היום")}</span>'
            f'<span class="quote">{esc(form["now"])}</span></div>'
        )
    need_html = ""
    if form.get("need"):
        need_html = (
            f'<div class="need"><span class="lbl">{esc(form.get("needLabel") or "מה חסר")}</span>'
            f"{esc(form['need'])}</div>"
        )
    return f"""
<div class="item" data-id="{esc(it['id'])}" data-page="{esc(it.get('trackerRow') or '')}" data-path="{esc(it.get('path') or '')}" data-status="{esc(it['status'])}" data-waiting="{esc(it['waitingOn'])}">
  <h3>{esc(it['titleHe'])}</h3>
  <div class="st {stamp_class(it)}">{esc(stamp)}</div>
  <p class="path"><a href="{esc(live)}" target="_blank" rel="noopener">פתיחת העמוד באתר הבדיקה</a></p>
  {now_html}
  {need_html}
  <fieldset><legend>הסימון שלך (מ־21 בספטמבר)</legend>
    {radios(it)}
  </fieldset>
  <textarea name="note-{esc(it['id'])}" placeholder="הערה">{esc(note)}</textarea>
</div>"""


def render_form(data: dict, sha: str, generated: str) -> str:
    items = form_items(data)
    by: dict[str, list[dict]] = {}
    for it in items:
        sec = (it.get("id") or "?")[0]
        by.setdefault(sec, []).append(it)
    closed = [it for it in items if it["status"] == "closed"]
    wait_e = [it for it in items if it["status"] == "waiting" and it["waitingOn"] == "eyal"]
    wait_n = [it for it in items if it["waitingOn"] == "nimrod" and it["status"] != "closed"]
    parts = []
    for letter in ("A", "B", "C", "D", "E", "F", "L", "P", "Q"):
        chunk = by.get(letter) or []
        if not chunk:
            continue
        title, sub = FORM_HEADS.get(letter, (letter, ""))
        parts.append(f'<h2>{esc(title)} <span class="cnt">— {len(chunk)}</span></h2>')
        if sub:
            parts.append(f'<p class="sub">{esc(sub)}</p>')
        parts.extend(render_form_item(it) for it in chunk)

    def rows(lst: list[dict]) -> str:
        if not lst:
            return "<tr><td colspan='2'>אין</td></tr>"
        return "".join(
            f"<tr><td>{esc(it['id'])} · {esc(it['titleHe'])}</td><td>{esc(S.stamp_he(it))}</td></tr>"
            for it in lst
            if not ((it.get("form") or {}).get("slim") and it["status"] != "closed")
        )

    slim_closed = [it for it in closed if (it.get("form") or {}).get("slim")]
    slim_wait = [it for it in items if (it.get("form") or {}).get("slim") and it["status"] != "closed"]
    return f"""<!doctype html>
<html lang="he" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>השלמת תוכן — 20 בספטמבר 2026 — אייל עמית</title>
<style>{FORM_CSS}</style>
</head>
<body>
<div class="wrap">
<header>
  <h1>איפה נדרשת השלמת תוכן</h1>
  <p class="date">אייל עמית · טופס השלמות · 20 בספטמבר 2026</p>
  <p class="lede">נגזר מ־תור העבודה S007. אין לערוך סטטוס כאן — הסטטוס מגיע רק מקובץ העבודה.</p>
  <p class="meta">generatedAt {esc(generated)} · ssotSha12 {esc(sha)} · תמה חיה {esc(data.get('themeLive') or '')}</p>
</header>
<div class="note"><strong>האתר עדיין לא באוויר.</strong> הקישורים הם לאתר הבדיקה. אין לערוך סטטוס ביד בטופס הזה.</div>
<div class="board" id="status-board">
  <h2>מצב נגזר</h2>
  <p class="lede">תפריט ראשי לא נגענו. נימרוד ידבר איתך על זה בנפרד.</p>
  <table>
    <tr><th>נסגר באתר הבדיקה ({len(closed)})</th><th>תווית מהתור</th></tr>
    {rows([it for it in closed if not (it.get("form") or {}).get("slim")])}
    {f"<tr><td colspan='2'>ועוד {len(slim_closed)} פוסטים/קודים שירדו או נסגרו (P016, P045 וכו׳).</td></tr>" if slim_closed else ""}
  </table>
  <table>
    <tr><th>ממתין לך ({len(wait_e)})</th><th>תווית</th></tr>
    {rows(wait_e)}
  </table>
  <table>
    <tr><th>ממתין לנימרוד ({len(wait_n)})</th><th>תווית</th></tr>
    {rows([it for it in wait_n if not (it.get("form") or {}).get("slim")])}
    {f"<tr><td colspan='2'>{len(slim_wait)} פריטי בלוג/QR ממתינים להעתקת הירו מהמקור.</td></tr>" if slim_wait else ""}
  </table>
</div>
{''.join(parts)}
<div class="bar">
  <button type="button" id="save">שמירת JSON</button>
  <button type="button" class="ghost" id="copy">העתקה</button>
  <span class="done" id="msg"></span>
  <textarea id="out" readonly></textarea>
</div>
<footer>מקור אמת: תור העבודה S007. ייצוא זה הוא תשובות תוכן בלבד, לא אישורי עמוד.</footer>
</div>
<script>
(function(){{
  function collect(){{
    var items=[].slice.call(document.querySelectorAll('.item'));
    return {{
      exportType:"eyal-content-gaps",
      exportSchema:"content-gaps-v1",
      formDate:"2026-09-20",
      ssotSha12:{json.dumps(sha)},
      exportTimestamp:new Date().toISOString(),
      note:"Content answers only. These are NOT page approvals. Status lives only in S007-WORK-SSOT.json.",
      contentAnswers: items.map(function(el){{
        var name=el.getAttribute('data-id');
        var picked=el.querySelector('input[name="'+name+'"]:checked');
        var ta=el.querySelector('textarea');
        return {{
          id:name,
          pageKey:el.getAttribute('data-page'),
          path:el.getAttribute('data-path'),
          title:(el.querySelector('h3')||el.querySelector('.slink')||{{}}).textContent||"",
          choice:picked?picked.value:"",
          note:ta?ta.value.trim():""
        }};
      }})
    }};
  }}
  function jsonTxt(){{ return JSON.stringify(collect(),null,2); }}
  function flash(t){{ var m=document.getElementById('msg'); m.textContent=t;
                     setTimeout(function(){{m.textContent='';}},4000); }}
  document.getElementById('save').addEventListener('click',function(){{
    var txt=jsonTxt();
    try{{
      var b=new Blob([txt],{{type:'application/json'}});
      var a=document.createElement('a');
      a.href=URL.createObjectURL(b);
      a.download='eyal-content-gaps-2026-09-20.json';
      document.body.appendChild(a); a.click(); a.remove();
      flash('נשמר');
    }}catch(e){{
      var o=document.getElementById('out'); o.style.display='block'; o.value=txt; o.select();
      flash('לא ניתן לשמור — הטקסט מוצג למטה להעתקה');
    }}
  }});
  document.getElementById('copy').addEventListener('click',function(){{
    var txt=jsonTxt(), o=document.getElementById('out');
    o.style.display='block'; o.value=txt; o.select();
    try{{ document.execCommand('copy'); flash('הועתק'); }}
    catch(e){{ flash('בחר את הטקסט למטה והעתק ידנית'); }}
  }});
}})();
</script>
</body>
</html>
"""


def render_board_card(it: dict) -> str:
    stamp = S.stamp_he(it)
    live = (it.get("live") or {}).get("url") or S.live_url(it.get("path") or "/")
    eyal = it.get("eyal") or {}
    choice = (eyal.get("choice") or "").strip()
    note = (eyal.get("note") or "").strip()
    eyal_html = "<p>אין שורת טופס.</p>"
    if choice or note:
        eyal_html = f"<p><strong>{esc(choice) or '—'}</strong></p>"
        if note:
            eyal_html += f"<pre>{esc(note)}</pre>"
    check = ((it.get("live") or {}).get("check") or "").strip()
    check_html = f"<p class='path'>live.check: {esc(check)}</p>" if check else ""
    return f"""
<section class="item" id="{esc(it['id'])}" data-status="{esc(it['status'])}" data-waiting="{esc(it['waitingOn'])}" data-kind="{esc(it['kind'])}" data-surface="{esc(it['surface'])}">
  <h2>{esc(it['id'])} — {esc(it['titleHe'])} <span class="tag {tag_class(it)}">{esc(stamp)}</span></h2>
  <p class="path"><a href="{esc(live)}">{esc(it.get('path') or live)}</a> · {esc(it['kind'])} · {esc(it['surface'])}</p>
  {check_html}
  <div class="grid">
    <div class="box eyal"><h3>אייל</h3>{eyal_html}</div>
    <div class="box us"><h3>סיכום מהתור</h3><p>{esc(it.get('summaryHe') or '')}</p></div>
  </div>
</section>"""


def render_board(data: dict, sha: str, generated: str) -> str:
    items = board_items(data)
    qs = data.get("questions") or []
    q_html = "".join(
        f"<li><span class='tag waitn'>{esc(q.get('waitingOn'))}</span> {esc(q.get('promptHe'))}</li>"
        for q in qs
    )
    c = counts(items)
    c_rows = "".join(f"<tr><td>{esc(k)}</td><td>{n}</td></tr>" for k, n in sorted(c.items()))
    extras = [it for it in items if it["surface"] != "both"]
    both = [it for it in items if it["surface"] == "both" and not (it.get("form") or {}).get("slim")]
    slim = [it for it in items if it["surface"] == "both" and (it.get("form") or {}).get("slim")]
    slim_rows = "".join(
        f"<tr><td>{esc(it['id'])}</td><td>{esc(it['titleHe'][:80])}</td>"
        f"<td><span class='tag {tag_class(it)}'>{esc(S.stamp_he(it))}</span></td></tr>"
        for it in slim
    )
    return f"""<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>לוח עבודה S007</title>
<style>{BOARD_CSS}</style>
</head>
<body>
<header class="page">
  <h1>לוח עבודה S007</h1>
  <p>נגזר מ־תור העבודה. אין לערוך סטטוס כאן. generatedAt {esc(generated)} · ssotSha12 {esc(sha)} · תמה {esc(data.get('themeLive') or '')}</p>
  <p>מקור: <a href="{SSOT_FILE_URL}">S007-WORK-SSOT.json</a>
   · טופס אייל: <a href="{FORM_LIVE}">s007-content-gaps.html</a></p>
</header>
<p class="wait"><strong>אין לערוך סטטוס בלוח הזה.</strong> סתירה מול קובץ העבודה — הקובץ מנצח. אקסל 20.9 הוא ארכיון. HANDOFF הוא שיחה.</p>
<p class="hold-nav"><strong>חרגת תפריט:</strong> לא נוגעים ב־ea-canonical-nav.php / drawer / section-nav עד שיחת נימרוד–אייל.</p>
<nav class="toc">
  <a href="#q">שאלות</a>
  <a href="#navtree">עץ ותפריט</a>
  <a href="#spotlight">עכשיו באתר</a>
  <a href="#extra">תור פנימי</a>
  <a href="#both">סעיפי טופס</a>
  <a href="#slim">בלוג ו-QR</a>
</nav>
<section class="item" id="q">
  <h2>שאלות פתוחות אליך</h2>
  <p class="path">לא הכרעה שקטה. עד תשובה — waiting/nimrod בתור.</p>
  <ol>{q_html}</ol>
  <table><tr><th>status/waitingOn</th><th>כמה בלוח</th></tr>{c_rows}</table>
</section>
{SKETCH}
<section class="item" id="extra">
  <h2>סעיפים שאינם שאלת טופס</h2>
  <p class="path">גלים, ביקורת, חרגת תפריט, ops.</p>
</section>
{''.join(render_board_card(it) for it in extras)}
<section class="item" id="both">
  <h2>סעיפי הטופס (לא slim)</h2>
</section>
{''.join(render_board_card(it) for it in both)}
<section class="item" id="slim">
  <h2>בלוג ו-QR</h2>
  <table>
    <tr><th>id</th><th>כותרת</th><th>סטטוס מהתור</th></tr>
    {slim_rows}
  </table>
</section>
<p class="wait">ssotSha12 {esc(sha)} · {esc(generated)}</p>
</body>
</html>
"""


def ftp_one_form(local: Path) -> None:
    sys.path.insert(0, str(S.REPO / "scripts"))
    from upress_ftp_env import (  # noqa: WPS433
        connect_ftp,
        eyal_hub_relative_path,
        ftp_cwd_to_wordpress_root,
        ftp_ensure_cwd,
        ftp_upload_file,
    )

    ftp, remote_rr = connect_ftp(timeout=120)
    hub = eyal_hub_relative_path()
    ftp.cwd("/")
    ftp_cwd_to_wordpress_root(ftp, remote_rr)
    ftp_ensure_cwd(ftp, hub)
    ftp_upload_file(ftp, local, "s007-content-gaps.html")
    ftp.quit()
    print(f"FTP OK {hub}/s007-content-gaps.html")


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument("--ftp", action="store_true", help="upload the form file only (no hub rebuild)")
    args = ap.parse_args()
    data = S.load_ssot()
    sha = S.sha12_path(S.SSOT_PATH)
    generated = datetime.now(timezone.utc).strftime("%Y-%m-%dT%H:%MZ")
    board = render_board(data, sha, generated)
    form = render_form(data, sha, generated)
    BOARD_PATH.write_text(board, encoding="utf-8")
    FORM_PATH.write_text(form, encoding="utf-8")
    HUB_COPY.parent.mkdir(parents=True, exist_ok=True)
    shutil.copyfile(FORM_PATH, HUB_COPY)
    print(f"board {BOARD_PATH}")
    print(f"form  {FORM_PATH}")
    print(f"hub   {HUB_COPY}")
    print(f"ssotSha12 {sha}")
    if args.ftp:
        ftp_one_form(FORM_PATH)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
