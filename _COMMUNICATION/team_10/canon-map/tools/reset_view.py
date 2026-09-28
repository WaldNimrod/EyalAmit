"""The reset decision page (team_00, 2026-09-28): per page, green rows approved in one click, yellow rows chosen by
picture, red rows given a direction. Choices stay in the browser; «העתק תשובות» copies them as short lines to paste
into the chat.

    python3 tools/reset_view.py map-source.html reset.html
"""
import json, os, sys, html as H
from bs4 import BeautifulSoup
from proofnav import keep_nav

SRC, OUT = sys.argv[1], sys.argv[2]
HERE = os.path.dirname(os.path.abspath(__file__))
D = json.load(open(os.path.join(HERE, "reset-rows.json"), encoding="utf-8"))


def boxes(spans, tall=()):
    """A small drawing of a composition on six columns: spans = column spans in order; tall = indexes two rows high."""
    cells = "".join(f'<i style="grid-column:span {c};grid-row:span {2 if k in tall else 1}"></i>' for k, c in enumerate(spans))
    return f'<span class="rv-k">{cells}</span>'


def hero(h, top=False):
    return (f'<span class="rv-h" style="height:{h}px"><span class="rv-h__t"></span>'
            f'<span class="rv-h__b" style="{"top:8px" if top else "bottom:8px"}"></span></span>')


# question kind -> [(code, label, drawing, recommended?)]
OPTS = {
    "hero": [("L", "גדול, כפתור למטה", hero(46), False), ("LT", "גדול, כפתור למעלה", hero(46, True), False),
             ("M", "בינוני", hero(34), True), ("S", "קטן", hero(24), False)],
    "k4": [("A", "2+2", boxes([3, 3, 3, 3]), True), ("B", "גדול, שניים זה מעל זה, גדול", boxes([2, 2, 2, 2], (0, 3)), False),
           ("C", "גדול ושלושה", boxes([3, 1, 1, 1]), False)],
    "k4now": [("A", "2+2", boxes([3, 3, 3, 3]), False), ("C", "גדול ושלושה — טקסט בתחתית, מילוי", boxes([3, 1, 1, 1]), True)],
    "bul": [("N", "מספרים", '<span class="rv-bul">1<br>2<br>3</span>', True), ("L", "סמל הלוגו", '<span class="rv-bul">◎<br>◎<br>◎</span>', False)],
    "k3": [("A", "שלושה שווים", boxes([2, 2, 2]), True), ("B", "גבוה מימין ושניים", boxes([2, 4, 4], (0,)), False),
           ("C", "גבוה משמאל ושניים", boxes([4, 2, 4], (1,)), False)],
    "k5": [("A", "גדול וארבעה בשורה", boxes([2, 1, 1, 1, 1]), False), ("B", "גבוה ורביעייה", boxes([2, 2, 2, 2, 2], (0,)), True)],
    "k6plus": [("A", "שלוש בשורה", boxes([2, 2, 2, 2, 2, 2]), True), ("B", "שתיים בשורה", boxes([3, 3, 3, 3]), False)],
    "cta": [("F", "להשלים כותרת וטקסט (תוכן מאייל)", "", True), ("X", "להסיר את הפס", "", False), ("K", "להשאיר כפתור בלבד — חריגה", "", False)],
    "draw": [("D", "לשרטט בסבב הבא ולהחליט אז", "", True), ("S", "להמיר לטקסט ותמונה כמו שהוא", "", False)],
    "none": [("P", "פסקת טקסט", "", False), ("Y", "רשימה (שנים / עיתונות)", "", False), ("T", "המלצות", "", False),
             ("X", "להסיר", "", False), ("?", "לבדוק איתי", "", True)],
}
OPTS["k4"][0] = OPTS["k4"][0]
OPTS["k4gal"] = [("A", "2+2", boxes([3, 3, 3, 3]), False), ("B", "גדול, שניים זה מעל זה, גדול", boxes([2, 2, 2, 2], (0, 3)), True),
                 ("C", "גדול ושלושה", boxes([3, 1, 1, 1]), False)]
OPTS["hero"][0] = OPTS["hero"][0]


def mini(markup):
    return f'<span class="rv-mini"><span class="rv-mini__in">{markup}</span></span>' if markup else ""


m = D["_meta"]
blocks = []
for p in sorted(D["pages"], key=lambda p: (p["path"] != "/", p["path"])):
    greens = [r for r in p["rows"] if r["color"] == "green"]
    others = [r for r in p["rows"] if r["color"] != "green"]
    pid = p["path"].strip("/").replace("/", "-") or "home"
    gl = "".join(f'<li><b>{r["id"]}</b> {H.escape(r["variant"])}{(" · " + H.escape(r["note"])) if r["note"] else ""}</li>' for r in greens)
    body = (f'<section class="rv-page" id="{pid}"><h3><a href="{p["path"]}" target="_blank">{H.escape(p["title"])}</a> '
            f'<small>{p["path"]} · {p["words"]} מילים</small></h3>'
            f'<div class="rv-green"><label><input type="checkbox" class="rv-okall" data-page="{pid}" data-ids="{" ".join(r["id"] for r in greens)}" checked> '
            f'<span class="rv-dot g"></span>{len(greens)} שורות ירוקות — מאושרות</label>'
            f'<details><summary>להציג</summary><ul>{gl}</ul></details></div>')
    for r in others:
        qk = r["q"]
        if qk == "k4" and r["type"] == "T-11":
            qk = "k4gal"
        opts = OPTS.get(qk, OPTS["none"])
        name = r["id"]
        radios = "".join(
            f'<label class="rv-o"><input type="radio" name="{name}" value="{c}"{" checked" if rec else ""}>'
            f'{d}<span>{t}{" (מומלץ)" if rec else ""}</span></label>' for c, t, d, rec in opts)
        body += (f'<div class="rv-row rv-{r["color"]}"><div class="rv-id"><b>{r["id"]}</b><span>{H.escape(r["variant"])}</span>'
                 f'<small>{H.escape(r["note"])}</small></div>{mini(r["html"])}<div class="rv-opts">{radios}</div></div>')
    blocks.append(body + "</section>")

head = (f'<div class="cm-proof-head"><h1>איפוס — טיפוס לכל שורה</h1>'
        f'<p>{m["pages"]} עמודים, {sum(m["count"].values())} שורות: '
        f'<span class="rv-dot g"></span><b>{m["count"]["green"]} ירוקות</b> (נובעות מהכללים, מסומנות כמאושרות), '
        f'<span class="rv-dot y"></span><b>{m["count"]["yellow"]} צהובות</b> (בחירה בתמונה — הבחירה המומלצת כבר מסומנת), '
        f'<span class="rv-dot r"></span><b>{m["count"]["red"]} אדומות</b> (אין טיפוס מתאים — בוחרים כיוון). '
        f'תבניות עמוד שעוברות אוטומטית: {m["templates"]["posts"]} פוסטים, {m["templates"]["qr"]} עמודי QR.</p>'
        '<p>הבחירות נשמרות בדפדפן. בסוף — «העתק תשובות» ומדביקים בצ׳אט. אפשר לעצור ולהמשיך מאוחר יותר.</p>'
        '<p><button id="rv-copy" type="button">העתק תשובות</button> <span id="rv-done"></span></p></div>')

s = BeautifulSoup(open(SRC, encoding="utf-8").read(), "lxml")
keep_nav(s, "reset.html")
main = s.find("main")
main.clear()
main.append(BeautifulSoup(head + "".join(blocks), "lxml").body)
main.body.unwrap()
js = s.new_tag("script")
js.string = """
(function(){
  var KEY='ea-reset-choices';
  var saved={}; try{saved=JSON.parse(localStorage.getItem(KEY)||'{}')}catch(e){}
  document.querySelectorAll('.rv-opts input[type=radio]').forEach(function(r){
    if(saved[r.name]){r.checked=(saved[r.name]===r.value)}
    r.addEventListener('change',function(){saved[r.name]=r.value;try{localStorage.setItem(KEY,JSON.stringify(saved))}catch(e){}});
  });
  document.querySelectorAll('.rv-okall').forEach(function(c){
    var k='ok:'+c.dataset.page; if(saved[k]==='0')c.checked=false;
    c.addEventListener('change',function(){saved[k]=c.checked?'1':'0';try{localStorage.setItem(KEY,JSON.stringify(saved))}catch(e){}});
  });
  document.getElementById('rv-copy').addEventListener('click',function(){
    var out=[];
    document.querySelectorAll('.rv-okall').forEach(function(c){ if(!c.checked) out.push(c.dataset.page+' ירוקות=לא'); });
    var seen={};
    document.querySelectorAll('.rv-opts input[type=radio]:checked').forEach(function(r){ if(!seen[r.name]){seen[r.name]=1; out.push(r.name+'='+r.value);} });
    var txt='איפוס:\\n'+out.join('\\n');
    (navigator.clipboard?navigator.clipboard.writeText(txt):Promise.reject()).then(function(){
      document.getElementById('rv-done').textContent='הועתק — '+out.length+' שורות. להדביק בצ׳אט.';
    },function(){ var t=document.createElement('textarea');t.value=txt;document.body.appendChild(t);t.select();document.execCommand('copy');
      document.getElementById('rv-done').textContent='הועתק — '+out.length+' שורות.'; });
  });
})();
"""
s.body.append(js)
css = s.new_tag("style")
css.string = """
.cm-proof-head{font-family:Heebo,sans-serif;background:#1d140d;color:#f3ece2;padding:20px 24px}
.cm-proof-head h1{margin:0 0 6px;font-size:1.4rem;font-weight:500;color:#f3ece2}
.cm-proof-head p{margin:0 0 6px;font-size:.95rem;max-width:130ch}
#rv-copy{font:600 1rem Heebo,sans-serif;background:#D08A5E;color:#1d140d;border:0;border-radius:100px;padding:9px 22px;cursor:pointer}
.rv-dot{display:inline-block;width:11px;height:11px;border-radius:50%;margin-inline:4px;vertical-align:-1px}
.rv-dot.g{background:#3f8a52}.rv-dot.y{background:#e0a526}.rv-dot.r{background:#c0392b}
main{font-family:Heebo,sans-serif;background:#f3ece2;padding:14px}
.rv-page{background:#fff;border:1px solid #e6dccf;border-radius:6px;padding:12px 16px;margin:0 0 14px}
.rv-page h3{margin:0 0 8px;font-size:1.1rem}.rv-page h3 small{color:#6b5f55;font-weight:400;margin-inline-start:8px;direction:ltr;unicode-bidi:isolate}
.rv-green{padding:6px 0 8px;border-bottom:1px solid #eee;margin-bottom:8px}
.rv-green details{display:inline-block;margin-inline-start:12px}.rv-green ul{margin:6px 0;font-size:.9rem}
.rv-green li b,.rv-id b{font-family:ui-monospace,Menlo,monospace;direction:ltr;unicode-bidi:isolate}
.rv-row{display:grid;grid-template-columns:200px 260px 1fr;gap:14px;align-items:center;padding:10px;border-radius:6px;margin-top:8px}
.rv-yellow{background:#fffaf0;border-inline-start:6px solid #e0a526}.rv-red{background:#fdf2f0;border-inline-start:6px solid #c0392b}
.rv-id span{display:block;font-size:.9rem}.rv-id small{display:block;color:#6b5f55;font-size:.8rem}
.rv-mini{display:block;width:250px;height:140px;overflow:hidden;position:relative;border:1px solid #ddd;border-radius:4px;background:#fffffa}
.rv-mini__in{position:absolute;top:0;right:0;width:1440px;transform:scale(.1736);transform-origin:top right;pointer-events:none}
.rv-opts{display:flex;gap:10px;flex-wrap:wrap}
.rv-o{display:flex;flex-direction:column;align-items:center;gap:4px;padding:8px;border:1px solid #e6dccf;border-radius:6px;cursor:pointer;min-width:110px;background:#fff;font-size:.85rem;text-align:center}
.rv-o:has(input:checked){outline:3px solid #3f7a52;background:#f1f8f3}
.rv-o input{margin:0}
.rv-k{display:grid;grid-template-columns:repeat(6,12px);grid-auto-rows:12px;gap:2px}
.rv-k i{background:#9A4F2B;border-radius:1px}
.rv-h{position:relative;display:block;width:96px;background:#2A1A0C;border-radius:3px}
.rv-h__t{position:absolute;right:8px;bottom:8px;width:52px;height:6px;background:#f3ece2}
.rv-h__b{position:absolute;left:8px;width:22px;height:7px;background:#D08A5E;border-radius:4px}
.rv-bul{font:600 .8rem/1.3 Heebo,sans-serif;color:#9A4F2B}
@media(max-width:760px){.rv-row{grid-template-columns:1fr}}
"""
s.head.append(css)
open(OUT, "w", encoding="utf-8").write(str(s))
print("pages:", len(D["pages"]), "rows needing a choice:", sum(1 for p in D["pages"] for r in p["rows"] if r["color"] != "green"))
