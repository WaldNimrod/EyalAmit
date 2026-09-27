"""Build the canon map: real rendered markup copied from live pages, grouped, labelled."""
import copy, datetime, hashlib, re, sys
from bs4 import BeautifulSoup, Comment

STAGE = "http://eyalamit-co-il-2026.s887.upress.link"
OUT = sys.argv[1]

PAGES = {"home": "/", "method": "/method/", "repair": "/repair/", "contact": "/contact/", "books": "/books/",
         "kushi": "/books/kushi-blantis/", "snoring": "/snoring-sleep-apnea/", "lessons": "/lessons/",
         "testimonials": "/testimonials/", "learning": "/learning/", "mokesh": "/eyal-amit/mokesh-dahiman/",
         "press": "/press/", "qr1": "/qr/qr1/", "bags": "/bags/", "blog": "/blog/",
         "post": "/%d7%a4%d7%95%d7%93%d7%a7%d7%90%d7%a1%d7%98-%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%95-%d7%a0%d7%a9%d7%99%d7%9e%d7%94-%d7%90%d7%99%d7%99%d7%9c-%d7%a2%d7%9e%d7%99%d7%aa-2/"}
SOUP = {k: BeautifulSoup(open(k + ".html", encoding="utf-8").read(), "lxml") for k in PAGES}


def top(el):
    while el.parent is not None and el.parent.name != "main":
        el = el.parent
    return el


def grab(page, css, idx=0, pred=None):
    els = SOUP[page].select(css)
    if pred:
        els = [e for e in els if pred(e)]
    return copy.copy(top(els[idx]))




# (id, name, part, inputs, [(variant label | None, page, css, idx, pred, trim)])
G = []
def group(title): G.append(("GROUP", title))
def t(tid, name, part, inputs, caps, note=None): G.append((tid, name, part, inputs, caps, note))

group("פתיחות")
t("T-01", "הירו עמוד", "phero", "chap · title · sub · lede · media · media_alt · cta_label · cta_url · dark · mod",
  [("עם תמונה — הגובה הנפוץ", "method", "header.phero--media", 0, None, None),
   ("גרסה: קומפקטי", "repair", "header.phero--compact", 0, None, None),
   ("גרסה: חצי גובה", "contact", "header.phero--half", 0, None, None),
   ("גרסה: בלי תמונה", "bags", "main > header.phero", 0, None, None)])
t("T-02", "הירו וידאו — דף הבית", "hero", "hero_video · hero_poster · hero_trust · hero_title · hero_subtitle · hero_cta_label · hero_cta_url",
  [(None, "home", "header.hero", 0, None, None)])
t("T-03", "הירו וידאו — מוקש", "mokesh-hero", "chap · title · sub · media · media_alt · yt_id",
  [(None, "mokesh", "header.mokesh-hero", 0, None, None)])

group("קריאה")
t("T-04", "פסקת קריאה", "prose", "chap · title · body · center · alt · dark · id",
  [(None, "method", "main > section.sec", 0, None, None),
   ("גרסה: רקע כהה", "lessons", "main > section.sec--dark", 0, None, None)])
t("T-05", "פסקה מקופלת", "prose (collapsible)", "collapsible · preview_lines · toggle_label + שדות פסקת הקריאה",
  [(None, "kushi", ".prose-fold", 0, None, None)])
t("T-07", "תמונה צפה בתוך הטקסט", "prose (float_*)", "float_image · float_alt · float_zoom · float_side · float_mod",
  [(None, "snoring", ".pfloat", 0, None, None), ("גרסה: עומדת, גדולה", "repair", ".pfloat--standing", 0, None, None)])

group("תמונה וטקסט")
t("T-06", "טקסט ותמונה זה לצד זה", "split", "chap · title · body · image · alt · figr · reversed · soft · cover · zoom",
  [(None, "method", ".split2", 0, None, None), ("גרסה: תמונה ממלאת", "repair", ".split2--cover", 0, None, None)])
t("T-10", "פס תמונה עם טקסט", "photo-band", "title · body · image · alt · cta_label · cta_url",
  [(None, "repair", "section.photo-band", 0, None, None)])
t("T-12", "ציטוט על תמונה", "bleed", "image · alt · quote · attrib",
  [(None, "bags", "section.bleed", 0, None, None)])
t("T-16", "אודות עם קולאז׳", "about (דף הבית)", "about_chap · about_title · about_body · about_img1-3 + alt",
  [(None, "home", "section#about", 0, None, None)])
t("T-17", "סטודיו", "studio (דף הבית)", "studio_image · studio_alt · studio_chap · studio_title · studio_body · studio_cta_label · studio_cta_url",
  [(None, "home", "section#studio", 0, None, None)])

group("רשתות וכרטיסים")
t("T-09", "כרטיסי נקודות", "point-cards", "chap · title · lead · after · items[title, text]",
  [(None, "repair", ".point-cards", 0, None, None)])
t("T-13", "למי מתאים", "whom (דף הבית)", "whom_chap · whom_title · whom_lead · whom_items[image, alt, text]",
  [(None, "home", "section#whom", 0, None, None)])
t("T-14", "השוואה בין שניים", "cmp (דף הבית)", "cmp_chap · cmp_title · cmp_lead · cmp_a_* · cmp_b_* (image, alt, title, text, cta, url)",
  [(None, "home", "section#compare", 0, None, None)])
t("T-24", "כרטיסי ספרים ומוצרים", "bookcard", "chap · title · lead · cta_label · items[cover, title, blurb, url, meta, cta]",
  [(None, "books", "section#books", 0, None, None)])
t("T-25", "שורת זרקור", "ea-now", "cards[image, title, line1, line2, url]",
  [(None, "home", "section#ea-now", 0, None, None)])
t("T-11", "רשת תמונות", "gallery", "chap · title · lead · alt · portraits · items[image, alt, cap, pending]",
  [(None, "kushi", ".gallery", 0, None, None), ("גרסה: דיוקנאות", "repair", ".gallery--portraits", 0, None, None)])
t("T-35", "כרטיס בלוג", "ea-blog-card", "פוסט: כותרת · קישור · תמונה · תאריך",
  [(None, "blog", "article.ea-blog-card", 0, None, ("article.ea-blog-card", 3))])

group("קולות")
t("T-18", "המלצות בגלילה", "testimonials (marquee)", "chap · title · lead · items[text, name, href]",
  [(None, "method", ".testi-mq", 0, None, None)])
t("T-19", "רשת המלצות", "testimonials (grid)", "chap · title · lead · items[text, name, href] · layout",
  [(None, "testimonials", ".testi-grid", 0, None, None)])
t("T-20", "כרטיסי ציטוט", "testi-cards", "quotes[] · alt",
  [(None, "snoring", "section.ea-testi-cards", 0, None, None)])

group("שאלות ומבנה")
t("T-21", "שאלות נפוצות", "faq", "chap · title · cat/cats או items[q, a] · cards · open_first",
  [(None, "method", "section.ea-faq-list", 0, None, None),
   ("גרסה: כרטיסים", "repair", "section.ea-faq-list--cards", 0, None, None),
   ("גרסה: מקוצר, דף הבית", "home", "section.ea-faq-mini-section", 0, None, None)])
t("T-22", "אקורדיון הגדרות", "dd", "chap · title · lead · dark · items[tag, title, body, active]",
  [(None, "lessons", "div.dd", 0, None, None)])
t("T-23", "תוכן עניינים", "toc", "heading · items[id, label]",
  [(None, "snoring", "div.ea-toc", 0, None, None)])
t("T-29", "ציר זמן", "timeline", "chap · title · lead · items[year, text]",
  [(None, "mokesh", "ol.tl", 0, None, None)])

group("מדיה")
t("T-26", "וידאו", "videoblk", "chap · title · body · poster · video · cap",
  [(None, "home", "section#video", 0, None, None)])
t("T-27", "תיבת וידאו ממתינה", "videoblk-placeholder", "chap · title · body · box",
  [(None, "lessons", ".ea-pending-approval", 0, None, None)])
t("T-28", "הטמעות פייסבוק", "fbembeds", "chap · title · lead · items[href, title]",
  [(None, "mokesh", "div.fbgrid", 0, None, None)])
t("T-30", "מקום שמור לתמונה", "photo-slot", "label",
  [(None, "learning", "section#learning-photo-lessons", 0, None, None)])
t("T-36", "וידאו מוקש", "mokesh-video", "yt_id · title",
  [(None, "mokesh", "main > section.sec iframe", 0, lambda e: "fbgrid__frame" not in e.get("class", []), None)])

group("פעולה")
t("T-08", "פס קריאה לפעולה", "cta", "title · body · cta_label · cta_url · sand · btn",
  [(None, "method", "section.cta-band", 0, None, None)],
  note="מוצג בצורה המלאה בלבד — כפתור בלי כותרת ותת־כותרת אסור לפי החלטה סגורה.")
t("T-15", "איך מתחילים", "start (דף הבית)", "start_bg · start_chap · start_title · start_steps[title, text] · start_cta_label · start_cta_url",
  [(None, "home", "section#start", 0, None, None)])
t("T-31", "יצירת קשר", "contact", "אין שדות — טופס, פס וואטסאפ ופרטי קשר קבועים",
  [(None, "contact", "section.ea-wave2-contact", 0, None, None),
   (None, "contact", "section.ea-wave2-contact__cta", 0, None, None),
   (None, "contact", "section.ea-wave2-contact__nap", 0, None, None)])

group("מעטפות")
t("T-32", "רשימת עיתונות", "ea-press", "רשימה קבועה: שנה · מקור · קישור · כותרת",
  [(None, "press", "section.ea-press", 0, None, None)])
t("T-33", "מעטפת עמוד קוד מודפס", "tpl-chapters-qr", "הפוסט: כותרת · תמונה ראשית · תוכן חופשי",
  [(None, "qr1", "main > header.phero", 0, None, None), (None, "qr1", "main > section.sec", 0, None, None)])
t("T-34", "פוסט בלוג — ארכיון", "tpl-chapters-blog-single", "הפוסט: כותרת · קטגוריה · תאריך · תמונה ראשית · תוכן חופשי",
  [(None, "post", "main > header.phero", 0, None, None), (None, "post", "main > section.sec", 0, None, ("__BODY__", 6))])
t("T-37", "פוסט בלוג — תבנית חדשה", "ea-post-v1 (JSON)", "hero · media[] · video · rows[part, bg, …]", [],
  note="אין מופע חי באתר. התבנית אושרה בסקיצה ולא נבנתה — חסרה הוכחת היתכנות.")

HOST_RX = re.compile(r"https?:(?:\\?/){2}eyalamit-co-il-2026\.s887\.upress\.link")


def rel(html):
    return HOST_RX.sub("", html)


def clean(el):
    for s in el.find_all(["script", "noscript"]):
        s.decompose()
    for c in el.find_all(string=lambda x: isinstance(x, Comment)):
        c.extract()
    for f in el.find_all("form"):
        f["action"] = "#"
        f["onsubmit"] = "return false"
    return el


ver = re.search(r"ver=(1\.5\.\d+)", open("method.html", encoding="utf-8").read()).group(1)
today = datetime.date.today().isoformat()

# stylesheets: union across pages, method's order first; extras slotted before chapters.css
links, seen = [], set()
for k in ["method", "home", "press", "blog", "post", "contact"]:
    for l in SOUP[k].head.select("link[rel=stylesheet]"):
        h = rel(l.get("href", ""))
        key = h.split("?")[0]
        if key in seen:
            continue
        seen.add(key)
        links.append(h)
chap = [h for h in links if "/chapters.css" in h or "/ea-open-round.css" in h]
links = [h for h in links if h not in chap] + chap
styles, seen_s = [], set()
for k in ["method", "home"]:
    for s in SOUP[k].head.find_all("style"):
        txt = s.get_text()
        hsh = hashlib.md5(txt.encode()).hexdigest()
        if hsh in seen_s:
            continue
        seen_s.add(hsh)
        styles.append(rel(txt))

body_cls = " ".join(SOUP["method"].body.get("class", []))

parts, toc = [], []
gi = 0
for item in G:
    if item[0] == "GROUP":
        gi += 1
        toc.append(f'<a href="#g{gi}">{item[1]}</a>')
        parts.append(f'<div class="cm-group" id="g{gi}"><span>קבוצה {gi}</span><h2>{item[1]}</h2></div>')
        continue
    tid, name, part, inputs, caps, note = item
    srcs = []
    for c in caps:
        if PAGES[c[1]] not in srcs:
            srcs.append(PAGES[c[1]])
    proof = " · ".join(f'<a href="{p}" target="_blank">{p if len(p) < 40 else "פוסט בבלוג"}</a>' for p in srcs) or "—"
    parts.append(
        f'<div class="cm-type" id="{tid}"><div class="cm-type__head"><b class="cm-id">{tid}</b>'
        f'<span class="cm-name">{name}</span><code class="cm-part">{part}</code></div>'
        f'<div class="cm-meta"><span><i>שדות</i> <code>{inputs}</code></span>'
        f'<span><i>הוכחת היתכנות</i> {proof}</span>'
        f'<span><i>נלכד</i> {today} · תמה {ver}</span></div>'
        + (f'<div class="cm-note">{note}</div>' if note else "") + "</div>")
    for label, page, css, idx, pred, tr in caps:
        el = grab(page, css, idx, pred)
        cut = False
        if tr:
            sel, keep = tr
            if sel == "__BODY__":
                box = el.select_one(".ea-post-content") or el.select_one(".wrap")
                kids = [c for c in box.children if getattr(c, "name", None)]
                for c in kids[keep:]:
                    c.decompose()
                cut = len(kids) > keep
            else:
                cards = el.select(sel)
                for c in cards[keep:]:
                    c.decompose()
                cut = len(cards) > keep
        el = clean(el)
        if label:
            parts.append(f'<div class="cm-variant">{label}</div>')
        parts.append('<div class="cm-spec">' + rel(str(el)) + '</div>')
        if cut:
            parts.append('<div class="cm-cut">— קוצר כאן לצורך המפה. ההמשך בעמוד המקור —</div>')

CM_CSS = """
.cm-spec{transform:translateZ(0)}
.r,.r2,.r3,.r--fade,[class*="ea-entrance"]{opacity:1!important;transform:none!important;animation:none!important}
.cm-top{background:#1d140d;color:#f3ece2;padding:28px 24px 22px;font-family:Heebo,sans-serif}
.cm-top h1{margin:0 0 6px;font-size:1.6rem;font-weight:500;color:#f3ece2}
.cm-top p{margin:0 0 4px;font-size:.9rem;opacity:.8}
.cm-toc{display:flex;flex-wrap:wrap;gap:6px 14px;margin-top:12px;font-size:.9rem}
.cm-toc a{color:#d9a47f;text-decoration:none}
.cm-group{background:#9a4f2b;color:#fff;padding:22px 24px 18px;margin-top:56px;font-family:Heebo,sans-serif}
.cm-group span{font-size:.75rem;letter-spacing:2px;opacity:.85}
.cm-group h2{margin:4px 0 0;font-size:1.5rem;font-weight:500;color:#fff}
.cm-type{background:#efe7dc;border-top:3px solid #9a4f2b;padding:14px 24px;margin-top:40px;font-family:Heebo,sans-serif;font-size:.85rem;color:#2f2013}
.cm-type__head{display:flex;flex-wrap:wrap;align-items:baseline;gap:4px 12px}
.cm-id{font-size:1rem;color:#9a4f2b}
.cm-name{font-size:1.1rem;font-weight:600}
.cm-part,.cm-meta code{font-family:ui-monospace,Menlo,monospace;font-size:.78rem;direction:ltr;unicode-bidi:isolate;background:#fff8;padding:1px 5px;border-radius:3px}
.cm-meta{display:flex;flex-direction:column;gap:3px;margin-top:8px}
.cm-meta i{font-style:normal;opacity:.65;margin-inline-end:6px}
.cm-meta a{color:#9a4f2b}
.cm-note{margin-top:8px;padding:6px 10px;background:#fff3d6;border-inline-start:3px solid #c98a2b}
.cm-variant{font-family:Heebo,sans-serif;font-size:.8rem;color:#9a4f2b;padding:10px 24px 4px;border-top:1px dashed #9a4f2b55;margin-top:18px}
.cm-cut{font-family:Heebo,sans-serif;font-size:.8rem;text-align:center;color:#8a7a6a;padding:8px}
@media(max-width:600px){.cm-type,.cm-group,.cm-top,.cm-variant{padding-inline:16px}}
"""

html = f"""<!doctype html>
<html lang="he" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>מפת הקאנון — טיפוסי התוכן</title>
<!-- The ONE place the site host appears. Change this line at the domain cutover. -->
<base href="{STAGE}/">
{chr(10).join(f'<link rel="stylesheet" href="{h}">' for h in links)}
{chr(10).join(f'<style>{s}</style>' for s in styles)}
<style>{CM_CSS}</style>
</head>
<body class="{body_cls}">
<header class="cm-top">
<h1>מפת הקאנון — טיפוסי התוכן</h1>
<p>שלד ראשון. כל דוגמה הועתקה כלשונה, מבנה ותוכן, מהעמוד החי שמצוין מעליה — והעמוד הזה הוא הוכחת ההיתכנות שלה.</p>
<p>נלכד {today} · גרסת תמה {ver} · עוצב בגיליונות הסגנון האמיתיים של האתר.</p>
<nav class="cm-toc">{" ".join(toc)}</nav>
</header>
<main class="chapters-main">
{chr(10).join(parts)}
</main>
</body>
</html>
"""
open(OUT, "w", encoding="utf-8").write(html)
print("types:", sum(1 for x in G if x[0] != "GROUP"), "groups:", gi, "bytes:", len(html),
      "host occurrences:", html.count("s887.upress.link"))
