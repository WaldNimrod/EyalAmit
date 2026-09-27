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
   ("גרסה: בלי תמונה", "bags", "main > header.phero", 0, None, None),
   ("הצעה — גדול: כמעט מסך מלא עם סרגלי הדפדפן פתוחים (92% מהגובה הנראה)", "method", "header.phero--media", 0, None, ("__PROPOSAL__", "cm-h-l")),
   ("הצעה — בינוני: באמצע בין שני הקצוות (66% מהגובה הנראה)", "method", "header.phero--media", 0, None, ("__PROPOSAL__", "cm-h-m")),
   ("הצעה — קטן: 44% מהגובה הנראה. זה גובה מינימלי — טקסט ארוך מגדיל אותו. מוצג כאן עם התוכן הקצר של עמוד יצירת הקשר", "contact", "header.phero--half", 0, None, ("__PROPOSAL__", "cm-h-s")),
   ("הצעה — אותו באנר עם סרטון במקום תמונה (גדול). כך הירו הווידאו הופך לאותו טיפוס — המדיה היא שדה", "method", "header.phero--media", 0, None, ("__PROPOSAL_VIDEO__", "cm-h-l"))])
t("T-02", "הירו וידאו", "hero / mokesh-hero", "וידאו · תמונת פתיחה · כותרת · תת-כותרת · כפתור",
  [("מופע היום: דף הבית", "home", "header.hero", 0, None, None),
   ("מופע היום: עמוד מוקש", "mokesh", "header.mokesh-hero", 0, None, None)],
  note="הצעה: לאחד לתוך T-01 — אותו באנר, כשהמדיה היא סרטון במקום תמונה (ראו את ההצעה האחרונה ב-T-01). אחרי אישור, T-02 יוצא משימוש. "
       "עד אז: תבנית אחת (נימרוד, 27.9: «זה כפילות… מבחינתנו זו תבנית אחת ושני העמודים צריכים לעמוד בה»). "
       "T-03 אוחד לכאן והמספר שלו לא ישמש שוב. שני הקבצים הכפולים בקוד — בטיפול צוות 90. "
       "היום שני המופעים שונים: בדף הבית הכותרת ממורכזת, בעמוד מוקש לימין — איזה יישור מקבלת התבנית טרם הוכרע.")

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
D = ("__DUMMY__", 0)
t("T-37", "פוסט בלוג — תבנית חדשה", "ea-post-v1 (JSON)", "hero · media[] · video · rows[part, bg, …]",
  [("שורה: hero", "method", "header.phero--media", 0, None, D),
   ("שורה: prose", "method", "main > section.sec", 0, None, D),
   ("שורה: split", "method", ".split2", 0, None, D),
   ("שורה: gallery", "kushi", ".gallery", 0, None, D),
   ("שורה: video", "home", "section#video", 0, None, D),
   ("שורה: cta", "method", "section.cta-band", 0, None, D)],
  note="אין מופע חי באתר — מוצג בתוכן דמה, בנוי מהחלקים האמיתיים של האתר לפי סדר השורות בסכימה המאושרת. "
       "הצעה להוכחת היתכנות: הפוסט החדש הראשון שאייל יפרסם — בתבנית הזו, ולא המרה של פוסט קיים (פוסטים ישנים נשארים בארכיון כמות שהם). "
       "כרגע אין בחומרים שאייל מסר תוכן שממתין לפוסט כזה.")

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


FILM = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 5v14M17 5v14M3 9h4M3 15h4M17 9h4M17 15h4"/></svg>'
YT = '<svg viewBox="0 0 68 48"><path d="M66.5 7.5a8.5 8.5 0 0 0-6-6C55.2 0 34 0 34 0S12.8 0 7.5 1.5a8.5 8.5 0 0 0-6 6C0 12.8 0 24 0 24s0 11.2 1.5 16.5a8.5 8.5 0 0 0 6 6C12.8 48 34 48 34 48s21.2 0 26.5-1.5a8.5 8.5 0 0 0 6-6C68 35.2 68 24 68 24s0-11.2-1.5-16.5z" fill="#f00"/><path d="M27 34l18-10-18-10z" fill="#fff"/></svg>'
POSTER = "/wp-content/themes/ea-eyalamit/assets/video/ea-home-hero-poster.jpg"


def vph(orig=None):
    cls = " ".join((orig.get("class", []) if orig else []))
    sty = (orig.get("style", "") if orig else "")
    h = (f'<div class="cm-vid {cls}" style="{sty}" role="img" aria-label="מקום לסרטון">'
         f'<img class="cm-vid__bg" src="{POSTER}" alt=""><span class="cm-vid__ic">{FILM}</span>'
         f'<span class="cm-vid__yt">{YT}</span><span class="cm-vid__lbl">מקום לסרטון</span></div>')
    return BeautifulSoup(h, "lxml").div


def videos(el):
    for v in el.find_all("video"):
        v.replace_with(vph(v))
    for f in el.find_all("iframe"):
        if re.search(r"youtube|youtu\.be", f.get("src", "") + f.get("data-src", "")):
            f.replace_with(vph(f))
    for yt in el.select(".mokesh-hero__yt"):
        yt.clear()
        yt.append(vph())
    return el


def dummy(el):
    for p in el.find_all(["p", "li", "figcaption"]):
        p.string = "פסקת דמה. כאן יופיע גוף הטקסט של הפוסט."
    for h in el.find_all(["h1", "h2", "h3", "h4"]):
        h.string = "כותרת — תוכן דמה"
    for e in el.select(".chap"):
        e.string = "תווית"
    for e in el.select(".phero__s, .phero__lede, .gfig__cap, .cta-band__p"):
        e.string = "שורת משנה — תוכן דמה"
    for a in el.find_all("a"):
        a["href"] = "#"
    for b in el.select(".btn"):
        b.string = "כפתור — דמה"
    for i in el.find_all("img"):
        i["alt"] = "תמונת דמה"
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

import json, os

USES = json.load(open(os.path.join(os.path.dirname(os.path.abspath(OUT)), "tools", "uses.json"), encoding="utf-8"))
DEFS = {int(k): v for k, v in json.load(open(os.path.join(os.path.dirname(os.path.abspath(OUT)), "tools", "type-defs.json"),
                                               encoding="utf-8")).items()}


def specimen(label, page, css, idx, pred, tr):
    """Return (html, cut) for one captured example, rewritten for the map."""
    el = grab(page, css, idx, pred)
    cut = False
    if tr:
        sel, keep = tr
        if sel == "__DUMMY__":
            el = dummy(el)
        elif sel in ("__PROPOSAL__", "__PROPOSAL_VIDEO__"):
            el["class"] = el.get("class", []) + [keep]
            if sel == "__PROPOSAL_VIDEO__":
                for img in el.select("img.phero__media"):
                    img.replace_with(vph(img))
        elif sel == "__BODY__":
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
    return videos(clean(el)), cut


def mini(el):
    """A live, scaled-down copy of the first example — no ids, no links, lazy images."""
    m = copy.copy(el)
    for x in m.find_all(True):
        x.attrs.pop("id", None)
        if x.name == "img":
            x["loading"] = "lazy"
    return rel(str(m))


panels, tabs = [], []
gi, rows = 0, None
for item in G + [("GROUP", None)]:
    if item[0] == "GROUP":
        if rows is not None:
            panels.append(
                f'<section class="cm-panel" id="g{gi}" data-group="{gtitle}">'
                f'<div class="cm-group"><span>קבוצה {gi} מתוך 9</span><h2>{gtitle}</h2></div>'
                f'<div class="cm-table" role="table"><div class="cm-thead" role="row">'
                f'<span>מזהה</span><span>שם</span><span>תיאור</span><span>שימושים באתר</span><span>תצוגה</span></div>'
                + "".join(rows) + "</div></section>")
        if item[1] is None:
            break
        gi += 1
        gtitle = item[1]
        tabs.append(f'<button type="button" class="cm-tab" data-g="g{gi}">{gtitle}</button>')
        rows = []
        continue
    tid, name, part, inputs, caps, note = item
    d = DEFS.get(int(tid[2:]), {})
    used = USES.get(tid, [])
    n = len(used)
    count = f"{n} עמודים" if n > 1 else ("עמוד אחד" if n == 1 else '<span class="cm-unused">כרגע לא בשימוש באתר</span>')
    link = lambda p: f'<a href="{p}" target="_blank">{p}</a>'
    if n == 0:
        uses_html = '<span class="cm-unused">כרגע לא בשימוש באתר</span>'
    elif n <= 10:
        uses_html = "<ul class=\"cm-uses\">" + "".join(f"<li>{link(p)}</li>" for p in used) + "</ul>"
    else:
        uses_html = ("<ul class=\"cm-uses\">" + "".join(f"<li>{link(p)}</li>" for p in used[:10]) + "</ul>"
                     f'<details class="cm-more"><summary>ועוד {n - 10}</summary><ul class="cm-uses">'
                     + "".join(f"<li>{link(p)}</li>" for p in used[10:]) + "</ul></details>")
    body, first = [], None
    for c in caps:
        el, cut = specimen(*c)
        if first is None:
            first = el
        if c[0]:
            body.append(f'<div class="cm-variant">{c[0]}</div>')
        dm = bool(c[5]) and c[5][0] == "__DUMMY__"
        pr = bool(c[5]) and c[5][0] in ("__PROPOSAL__", "__PROPOSAL_VIDEO__")
        body.append(f'<div class="cm-spec{" cm-dummy" if dm else ""}{" cm-prop" if pr else ""}">'
                    + ('<span class="cm-dummy__badge">תוכן דמה — לא מופיע באתר</span>' if dm else "")
                    + ('<span class="cm-dummy__badge cm-prop__badge">הצעה לאישור — עדיין לא באתר</span>' if pr else "")
                    + rel(str(el)) + "</div>")
        if cut:
            body.append('<div class="cm-cut">— קוצר כאן לצורך המפה. ההמשך בעמוד המקור —</div>')
    short = d.get("def", "").split(". ")[0].rstrip(".") + "."
    flag = f'<small class="cm-flag">{d["flag"]}</small>' if d.get("flag") else ""
    props = "".join(f"<dt>{a}</dt><dd>{b}</dd>" for a, b in d.get("props", []))
    fields = d.get("fields", [])
    fields_html = ("<table class=\"cm-fields\"><thead><tr><th>שדה</th><th>סוג</th><th>שם בקוד</th></tr></thead><tbody>"
                   + "".join(f"<tr><td>{a}</td><td>{b}</td><td><code>{c}</code></td></tr>" for a, b, c in fields)
                   + "</tbody></table>") if fields else '<p class="cm-muted">אין שדות לעריכה — התוכן קבוע.</p>'
    tech = d.get("technical") or []
    rows.append(
        f'<details class="cm-row" id="{tid}"><summary class="cm-sum" role="row">'
        f'<span class="c-id">{tid}</span><span class="c-name">{name}{flag}</span>'
        f'<span class="c-desc">{short}</span><span class="c-use">{count}</span>'
        f'<span class="c-thumb"><span class="cm-mini"><span class="cm-mini__in">{mini(first)}</span></span></span>'
        f'</summary><div class="cm-full"><div class="cm-type">'
        f'<p class="cm-def">{d.get("def", "")}</p>'
        + (f'<p class="cm-def cm-def--note">{d["note"]}</p>' if d.get("note") else "")
        + (f'<div class="cm-note">{note}</div>' if note else "")
        + f'<div class="cm-cols"><section><h3>מאפיינים</h3><dl class="cm-props">{props}</dl></section>'
        f'<section><h3>שדות</h3>{fields_html}'
        + (f'<p class="cm-muted">שדות טכניים שהעורך לא ממלא: <code>{" · ".join(tech)}</code></p>' if tech else "")
        + f'</section></div>'
        f'<section><h3>שימושים באתר — {count}</h3>{uses_html}</section>'
        f'<p class="cm-muted">טיפוס בקוד: <code>{part}</code> · נלכד {today} · תמה {ver} · '
        f'ספירת השימושים: כל {USES["_meta"]["live"]} העמודים החיים, {USES["_meta"]["date"]}</p></div>'
        + "".join(body) + "</div></details>")

CM_CSS = """
.cm-spec{transform:translateZ(0);position:relative}
.r,.r2,.r3,.r--fade,[class*="ea-entrance"]{opacity:1!important;transform:none!important;animation:none!important}
body{background:#f7f2ea}
.cm-top{background:#1d140d;color:#f3ece2;padding:24px 24px 18px;font-family:Heebo,sans-serif}
.cm-top h1{margin:0 0 6px;font-size:1.5rem;font-weight:500;color:#f3ece2}
.cm-top p{margin:0 0 3px;font-size:.85rem;opacity:.8}
.cm-tabs{position:sticky;top:0;z-index:200;display:flex;gap:4px;overflow-x:auto;background:#2a1d12;padding:8px 12px;font-family:Heebo,sans-serif;box-shadow:0 2px 8px #0003}
.cm-tab{flex:0 0 auto;color:#e9dccb;background:none;border:0;font:inherit;font-size:.9rem;padding:7px 12px;border-radius:4px;cursor:pointer}
.cm-tab:hover{background:#ffffff14}
.cm-tab.is-on{background:#9a4f2b;color:#fff}
.cm-panel{display:none}
.cm-panel.is-on{display:block}
.cm-group{background:#9a4f2b;color:#fff;padding:18px 24px 14px;font-family:Heebo,sans-serif}
.cm-group span{font-size:.75rem;letter-spacing:2px;opacity:.85}
.cm-group h2{margin:4px 0 0;font-size:1.4rem;font-weight:500;color:#fff}
.cm-table{font-family:Heebo,sans-serif;color:#2f2013;background:#fff}
.cm-thead,.cm-sum{display:grid;grid-template-columns:64px 200px 1fr 120px 176px;gap:14px;align-items:center;padding:10px 20px}
.cm-thead{background:#efe7dc;font-size:.75rem;font-weight:600;color:#6b5f55;position:sticky;top:48px;z-index:150}
.cm-row{border-bottom:1px solid #e6dccf}
.cm-sum{cursor:pointer;list-style:none;font-size:.88rem}
.cm-sum::-webkit-details-marker{display:none}
.cm-sum:hover{background:#faf6f0}
.cm-row[open]>.cm-sum{background:#efe7dc;position:sticky;top:48px;z-index:140}
.c-id{font-weight:700;color:#9a4f2b}
.c-name{font-weight:600}
.cm-flag{display:block;font-weight:400;font-size:.72rem;color:#8a5a12}
.c-desc{color:#4b3e33;line-height:1.5}
.c-use{font-size:.8rem;word-break:break-word}
.c-use a,.cm-meta a{color:#9a4f2b}
.cm-mini{display:block;width:176px;height:110px;overflow:hidden;position:relative;border:1px solid #e6dccf;border-radius:4px;background:#f7f2ea}
.cm-mini__in{position:absolute;top:0;right:0;width:1280px;transform:scale(.1375);transform-origin:top right;pointer-events:none}
.cm-full{border-top:3px solid #9a4f2b}
.cm-type{background:#f3ede4;padding:16px 24px;font-size:.88rem;color:#2f2013}
.cm-def{margin:0 0 8px;font-size:.95rem;line-height:1.65;max-width:80ch}
.cm-def--note{font-size:.85rem;color:#6b5f55}
.cm-part,.cm-meta code{font-family:ui-monospace,Menlo,monospace;font-size:.78rem;direction:ltr;unicode-bidi:isolate;background:#fff9;padding:1px 5px;border-radius:3px}
.cm-meta{display:flex;flex-direction:column;gap:3px;margin-top:10px}
.cm-type h3{font-size:.95rem;font-weight:600;margin:16px 0 6px;color:#9a4f2b}
.cm-cols{display:grid;grid-template-columns:1fr 1.2fr;gap:28px}
.cm-props{display:grid;grid-template-columns:max-content 1fr;gap:4px 14px;margin:0}
.cm-props dt{font-weight:600;color:#6b5f55}
.cm-props dd{margin:0}
.cm-fields{border-collapse:collapse;width:100%;font-size:.84rem;background:#fff}
.cm-fields th,.cm-fields td{border:1px solid #e6dccf;padding:4px 8px;text-align:start;vertical-align:top}
.cm-fields th{background:#efe7dc;font-weight:600}
.cm-fields code,.cm-muted code{font-family:ui-monospace,Menlo,monospace;font-size:.76rem;direction:ltr;unicode-bidi:isolate}
.cm-uses{margin:0;padding-inline-start:18px;columns:2;font-size:.84rem}
.cm-uses a{color:#9a4f2b}
.cm-more summary{cursor:pointer;color:#9a4f2b;font-size:.84rem;margin-top:4px}
.cm-muted{color:#8a7a6a;font-size:.8rem;margin:10px 0 0}
.cm-meta i{font-style:normal;opacity:.65;margin-inline-end:6px}
.cm-note{margin:8px 0;padding:6px 10px;background:#fff3d6;border-inline-start:3px solid #c98a2b;max-width:80ch}
.cm-unused{background:#fff3d6;color:#8a5a12;padding:1px 8px;border-radius:3px;font-weight:600}
.cm-variant{font-family:Heebo,sans-serif;font-size:.8rem;color:#9a4f2b;padding:10px 24px 4px;border-top:1px dashed #9a4f2b55;margin-top:18px}
.cm-cut{font-family:Heebo,sans-serif;font-size:.8rem;text-align:center;color:#8a7a6a;padding:8px}
.cm-dummy{outline:3px dashed #c98a2b;outline-offset:-3px}
.cm-prop{outline:3px solid #3f7a52;outline-offset:-3px}
.cm-dummy__badge.cm-prop__badge{background:#3f7a52;color:#fff}
header.phero.cm-h-l{min-height:92svh!important}
header.phero.cm-h-m{min-height:66svh!important}
header.phero.cm-h-s{min-height:44svh!important}
.cm-dummy__badge{position:absolute;top:10px;inset-inline-end:10px;z-index:30;background:#c98a2b;color:#1d140d;font:600 .8rem Heebo,sans-serif;padding:4px 10px;border-radius:3px}
.cm-vid{display:block;position:relative;width:100%;aspect-ratio:16/9;overflow:hidden;background:#1d140d}
.hero .cm-vid,.mokesh-hero__yt .cm-vid{height:100%;aspect-ratio:auto}
.phero .cm-vid.phero__media{position:absolute;inset:0;height:100%;aspect-ratio:auto}
.cm-vid__bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.cm-vid::after{content:"";position:absolute;inset:0;z-index:0;background:linear-gradient(180deg,rgba(29,20,13,.35),rgba(154,79,43,.6))}
.cm-vid__ic,.cm-vid__yt,.cm-vid__lbl{position:absolute;z-index:1}
.cm-vid__yt{top:50%;left:50%;transform:translate(-50%,-50%);width:76px}
.cm-vid__ic{top:14px;inset-inline-start:16px;width:32px;color:#f3ece2}
.cm-vid__lbl{bottom:14px;inset-inline-start:16px;color:#f3ece2;font:500 .9rem Heebo,sans-serif}
@media(max-width:760px){
 .cm-thead{display:none}
 .cm-cols{grid-template-columns:1fr}.cm-uses{columns:1}
 .cm-sum{grid-template-columns:1fr 112px;grid-template-areas:"id thumb" "name thumb" "desc thumb" "use use";gap:4px 12px;padding:12px 16px}
 .c-id{grid-area:id}.c-name{grid-area:name}.c-desc{grid-area:desc;font-size:.82rem}.c-use{grid-area:use}.c-thumb{grid-area:thumb}
 .cm-mini{width:112px;height:80px}.cm-mini__in{transform:scale(.0875)}
 .cm-row[open]>.cm-sum{position:static}
 .cm-type,.cm-group,.cm-top,.cm-variant{padding-inline:16px}
}
"""

CM_JS = """
(function(){
  // Tabs are buttons, not #links: the page's <base> would send a #link to the staging host.
  var tabs=[].slice.call(document.querySelectorAll('.cm-tab')), panels=[].slice.call(document.querySelectorAll('.cm-panel'));
  function show(g,row){
    if(!document.getElementById(g)) g=panels[0].id;
    panels.forEach(function(p){p.classList.toggle('is-on',p.id===g)});
    tabs.forEach(function(t){var on=t.dataset.g===g;t.classList.toggle('is-on',on);if(on&&t.scrollIntoView)t.scrollIntoView({block:'nearest',inline:'nearest'});});
    if(row){row.open=true;row.scrollIntoView();} else window.scrollTo(0,0);
    try{history.replaceState(null,'',location.pathname+location.search+'#'+(row?row.id:g));}catch(e){}
  }
  tabs.forEach(function(t){t.addEventListener('click',function(){show(t.dataset.g);});});
  var h=location.hash.slice(1), el=h&&document.getElementById(h);
  if(el&&el.classList.contains('cm-row')) show(el.closest('.cm-panel').id,el); else show(h);
})();
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
<p>שורה לכל טיפוס. לחיצה על שורה פותחת את התיאור המלא ואת הדוגמה בגודל מלא.</p>
<p>כל דוגמה הועתקה כלשונה מהעמוד החי שמצוין בשורה — והעמוד הזה הוא הוכחת ההיתכנות שלה. דוגמה בתוכן דמה מסומנת במסגרת מקווקוות. כל סרטון מוצג כמקום שמור קבוע; בעמודים עצמם מוצג הסרטון האמיתי.</p>
<p>נלכד {today} · גרסת תמה {ver} · מעוצב בגיליונות הסגנון האמיתיים של האתר.</p>
</header>
<nav class="cm-tabs" aria-label="קבוצות">{"".join(tabs)}</nav>
<main class="chapters-main">
{chr(10).join(panels)}
</main>
<script>{CM_JS}</script>
</body>
</html>
"""
open(OUT, "w", encoding="utf-8").write(html)
print("types:", sum(1 for x in G if x[0] != "GROUP"), "groups:", gi, "bytes:", len(html),
      "host occurrences:", html.count("s887.upress.link"))
