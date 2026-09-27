"""Shared-canon sketches (team_00's answers to the merge findings, 2026-09-27): buttons on the canonical palette (A-4),
the one "waiting for content" state (A-5), every grid side by side for review (A-7), and the one-page types (A-8).
Every block is numbered so a reply can point at it. Takes the map's own examples; no second copy of the markup.

    python3 tools/shared_view.py ea-canon-map.html shared.html
"""
import sys
from bs4 import BeautifulSoup
from proofnav import keep_nav

SRC, OUT = sys.argv[1], sys.argv[2]


def rgb(h):
    h = h.lstrip("#")
    return tuple(int(h[i:i + 2], 16) for i in (0, 2, 4))


def ratio(a, b):
    def lum(c):
        f = lambda v: (v / 255) / 12.92 if v / 255 <= 0.03928 else ((v / 255 + 0.055) / 1.055) ** 2.4
        return 0.2126 * f(c[0]) + 0.7152 * f(c[1]) + 0.0722 * f(c[2])
    la, lb = lum(rgb(a)), lum(rgb(b))
    return (max(la, lb) + 0.05) / (min(la, lb) + 0.05)


# A-4: the button takes its tone's link colour — filled (text in the tone's contrast colour) or outline.
BUTTONS = [  # (id, tone, bg, heading colour, button colour, text on filled)
    ("B-1", "שמנת", "#fffffa", "#2f2013", "#9A4F2B", "#ffffff"),
    ("B-2", "חול", "#D8C7B5", "#2f2013", "#7A3418", "#ffffff"),
    ("B-3", "זית", "#575838", "#FFE8C2", "#F6D38A", "#2f2013"),
    ("B-4", "טרקוטה", "#874321", "#FFE8C2", "#F6D38A", "#2f2013"),
    ("B-5", "כהה", "#2A1A0C", "#FFE8C2", "#D08A5E", "#1d140d"),
]
PENDING = [("W-1", "T-30", "מקום שמור לתמונה"), ("W-2", "T-27", "מסגרת וידאו ממתינה")]
GRIDS = [("T-11", 0), ("T-11", 1), ("T-09", 0), ("T-13", 0), ("T-14", 0), ("T-15", 0), ("T-24", 0), ("T-25", 0),
         ("T-35", 0), ("T-18", 0), ("T-19", 0), ("T-20", 0), ("T-28", 0)]
SINGLE = ["T-23", "T-28", "T-31"]

s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
rows = {r["id"]: r for r in s.select(".cm-row")}
name = lambda t: next(rows[t].select_one(".c-name").stripped_strings)
uses = lambda t: rows[t].select_one(".c-use").get_text()
today = lambda t: rows[t].select(".cm-full > .cm-spec:not(.cm-appr):not(.cm-prop)")
img = s.select_one("img.phero__media")["src"]


def ruler(parent):
    g = s.new_tag("div", attrs={"class": "cm-grid", "aria-hidden": "true"})
    for n in range(1, 7):
        i = s.new_tag("i")
        i.string = str(n)
        g.append(i)
    parent.append(g)


blocks = ['<div class="cm-group" id="B"><span>A-4 · מאושר — מוצג במניפה</span><h2>כפתורים על חמשת הגוונים</h2></div>'
          '<div class="av-card"><p class="mv-note">הכפתור לוקח את צבע הקישור של הגוון שעליו הוא יושב — מלא (הטקסט בצבע הניגוד של הגוון) '
          'או מתאר. שני הסגנונות הם וריאנט משותף לכל טיפוס שיש בו כפתור. כל יחס נמדד; הסף 4.5 לטקסט הכפתור ו-3 לגבול הכפתור מול הרקע. '
          'לשם השוואה: הכפתור הטרקוטה של היום (לבן על #B5663D) נותן 4.26 — <b>נכשל</b>.</p></div>']
for bid, tone, bg, h, b, t in BUTTONS:
    r_fill, r_edge = ratio(t, b), ratio(b, bg)
    blocks.append(
        f'<div class="av-ex" id="{bid}"><b>{bid}</b> רקע: {tone} · מלא: טקסט {r_fill:.2f} · מתאר וגבול: {r_edge:.2f}</div>'
        f'<div class="cm-spec cm-prop"><section class="sec" style="background:{bg}"><div class="wrap sv-btns">'
        f'<h2 class="h2" style="color:{h};margin:0 0 20px">כותרת לדוגמה על רקע {tone}</h2>'
        f'<p><a class="btn" style="background:{b};color:{t};border:1.5px solid {b}">כפתור מלא</a>'
        f'<a class="btn" style="background:transparent;color:{b};border:1.5px solid {b}">כפתור מתאר</a></p></div></section></div>')
blocks.append(
    f'<div class="av-ex" id="B-6"><b>B-6</b> על תמונה (הירו, פס תמונה) · מלא: טרקוטה {ratio("#ffffff", "#9A4F2B"):.2f} · מתאר: לבן</div>'
    f'<div class="cm-spec cm-prop"><section class="sec sv-img" style="background:linear-gradient(90deg,rgba(29,20,13,.25),rgba(29,20,13,.75)),url({img}) center/cover">'
    '<div class="wrap sv-btns"><h2 class="h2" style="color:#fff;margin:0 0 20px">כותרת על תמונה</h2>'
    '<p><a class="btn" style="background:#9A4F2B;color:#fff;border:1.5px solid #9A4F2B">כפתור מלא</a>'
    '<a class="btn" style="background:transparent;color:#fff;border:1.5px solid #fff">כפתור מתאר</a></p></div></section></div>')

blocks.append('<div class="cm-group" id="W"><span>A-5 · מאושר</span><h2>ממתין לתוכן — מראה אחד</h2></div>'
              '<div class="av-card"><p class="mv-note">כל תמונה או סרטון שעוד לא הגיעו: פסים ורודים, מסגרת מקווקוות ותגית בולטת. '
              'צבע שאינו במניפה, כדי שאי אפשר יהיה לטעות ולחשוב שזה תוכן.</p></div>')
for wid, tid, what in PENDING:
    blocks.append(f'<div class="av-ex" id="{wid}"><b>{wid}</b> {what} — היה {tid} «{name(tid)}»</div>' + str(today(tid)[0]))

blocks.append('<div class="cm-group" id="G"><span>A-7 · לבדיקה</span><h2>כל הרשתות זו לצד זו</h2></div>'
              '<div class="av-card"><p class="mv-note">כל רשת באתר היום, עם ששת הטורים של האתר מצוירים על רוחב התוכן. בפס של כל דוגמה — '
              'מה נמדד בדפדפן: כמה פריטים בשורה, הרווח ביניהם ורוחב פריט. כך רואים אילו רשתות יושבות על ששת הטורים ואילו לא.</p>'
              '<p class="mv-note"><b>מה עולה מהמדידה (1440):</b> 13 רשתות, <b>שישה רווחים שונים</b> בין פריטים — 12, 16, 20, 24, 28 ו-40 פיקסלים. '
              'שתיים חורגות מרוחב התוכן: שורת הזרקור רחבה ממנו (1168 מול 1104), ושלושת הצעדים צרה ממנו (953). '
              '<b>ארבעה בשורה אינו יושב על ששה טורים</b> (טור וחצי לפריט) — רשת הדיוקנאות, «למי מתאים» ושורת הזרקור. '
              'על ששה טורים יושבים רק 2 בשורה (3 טורים לפריט), 3 בשורה (2 טורים) או 6 בשורה (טור אחד).</p></div>')
for k, (tid, idx) in enumerate(GRIDS, 1):
    spec = today(tid)[idx]
    for w in spec.select("section > .wrap")[:1] or spec.select(".wrap")[:1]:
        w["style"] = (w.get("style", "") + ";position:relative").lstrip(";")
        ruler(w)
    blocks.append(f'<div class="av-ex sv-g" id="G-{k}"><b>G-{k}</b> {tid} «{name(tid)}» · {uses(tid)} · <span class="sv-m">…</span></div>'
                  + str(spec))

blocks.append('<div class="cm-group" id="U"><span>A-8 · לבדיקה</span><h2>טיפוסים של עמוד אחד</h2></div>'
              '<div class="av-card"><p class="mv-note">שלושה טיפוסים שאין להם אח. אחרי הבדיקה מחליטים: להשאיר, לאחד או לוותר.</p></div>')
for k, tid in enumerate(SINGLE, 1):
    blocks.append(f'<div class="av-ex" id="U-{k}"><b>U-{k}</b> {tid} «{name(tid)}» · {uses(tid)}</div>'
                  + "".join(str(x) for x in today(tid)))

head = ('<div class="cm-proof-head"><h1>קאנון משותף — כפתורים, ממתין לתוכן, רשתות וטיפוסים בודדים</h1>'
        '<p>תשובות לחריגות מעמוד האיחוד. לכל בלוק מזהה (B, W, G, U) — אפשר להפנות אליו ישירות. במפה בלבד, לא באתר.</p></div>')

keep_nav(s, "shared.html")
main = s.find("main")
main.clear()
main.append(BeautifulSoup(head + "".join(blocks), "lxml").body)
main.body.unwrap()
js = s.new_tag("script")
js.string = """
// Measure each grid as the browser lays it out: items per row, gap and item width.
// The ruler covers the content box only: pull it in by the container's own padding.
document.querySelectorAll('.cm-grid').forEach(function(g){var cs=getComputedStyle(g.parentElement);
  g.style.left=cs.paddingLeft;g.style.right=cs.paddingRight;});
document.querySelectorAll('.sv-g').forEach(function(lab){
  var spec=lab.nextElementSibling, best=null;
  spec.querySelectorAll('*').forEach(function(e){
    if(e.classList.contains('cm-grid'))return;
    var d=getComputedStyle(e).display; if(d!=='grid'&&d!=='flex')return;
    var k=[].filter.call(e.children,function(c){var r=c.getBoundingClientRect(); return r.width>150&&r.height>60&&!c.classList.contains('cm-grid')});
    if(k.length<2||e.getBoundingClientRect().width<400)return;
    var w=e.getBoundingClientRect().width; if(!best||w>best.w+1||(Math.abs(w-best.w)<=1&&k.length>best.k.length))best={e:e,k:k,w:w};
  });
  var m=lab.querySelector('.sv-m');
  if(!best){m.textContent='לא נמצאה רשת';return;}
  var t0=best.k[0].getBoundingClientRect().top, row=best.k.filter(function(c){return Math.abs(c.getBoundingClientRect().top-t0)<6});
  var cs=getComputedStyle(best.e), w=Math.round(best.k[0].getBoundingClientRect().width);
  var xs=row.map(function(c){return c.getBoundingClientRect()}).sort(function(a,b){return a.left-b.left});
  var gap=xs.length>1?Math.round(xs[1].left-xs[0].right):0;
  m.textContent=row.length+' בשורה · רווח '+gap+' פיקסלים · פריט '+w+' פיקסלים · רוחב הרשת '+Math.round(best.e.getBoundingClientRect().width);
});
"""
s.body.append(js)
css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0;font-size:.9rem;opacity:.9;max-width:100ch}
.av-card{font-family:Heebo,sans-serif;background:#fbf6ee;color:#2f2013;padding:12px 24px;border-bottom:1px solid #e6dccf}
.mv-note{margin:0;font-size:.95rem;max-width:110ch}
.cm-group span{letter-spacing:0!important}
.av-ex{font-family:Heebo,sans-serif;background:#3f7a52;color:#fff;padding:9px 24px;font-size:.95rem;margin-top:18px}
.av-ex b{background:#fff;color:#3f7a52;padding:1px 8px;border-radius:3px;margin-inline-end:8px;font-family:ui-monospace,Menlo,monospace;direction:ltr;unicode-bidi:isolate}
.sv-btns p{display:flex;gap:14px;flex-wrap:wrap;margin:0}
.sv-btns .btn{padding:var(--cm-btn-pad-block) var(--cm-btn-pad-inline)!important;box-shadow:none}
.sv-img{padding-block:72px}
.cm-grid{position:absolute;inset:0;padding:0!important;display:grid;grid-template-columns:repeat(6,minmax(0,1fr));
  column-gap:var(--cm-gap);direction:rtl;pointer-events:none;z-index:50}
.cm-grid i{border-inline:1px solid rgba(230,30,110,.8);font:600 .75rem/1 Heebo,sans-serif;font-style:normal;
  color:#e61e6e;text-align:center;padding-top:4px;text-shadow:0 0 3px #fff}
@media(max-width:760px){.cm-grid{display:none}}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print("blocks:", len(blocks))
