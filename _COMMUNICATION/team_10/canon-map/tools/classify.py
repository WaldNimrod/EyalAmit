"""Reset classification (team_00, 2026-09-28, «2 מאושר»): every row of every live page gets a proposed canon type and
variant, and a colour — green (follows from the rules), yellow (the rules allow several forms: team_00 picks by
picture), red (no type fits). Page templates (blog posts, QR pages) switch automatically and are counted, not listed.

    python3 tools/classify.py            # fetch the live pages, write tools/reset-rows.json
    python3 tools/classify.py --cached   # reuse the fetched pages in the scratch cache

The decision page is written by tools/reset_view.py.
"""
import json, os, re, sys, time, urllib.parse
from bs4 import BeautifulSoup
from census import population, get, STAGE

HERE = os.path.dirname(os.path.abspath(__file__))
CACHE = os.environ.get("RESET_CACHE", "/private/tmp/claude-501/-Users-nimrod-Documents-AOS-V5-EyalAmit-co-il-2026/253e5e9b-2806-414b-8efa-bd0839571a6b/scratchpad/reset-cache")
G, Y, R = "green", "yellow", "red"


def words(main):
    m = BeautifulSoup(str(main), "lxml")
    for x in m.select("script,style,nav,header.phero,header.hero,footer,.ea-toc,.ea-crumb-bar"):
        x.decompose()
    return len(re.findall(r"\w+", m.get_text(" ")))


def has(el, css):
    return el.select_one(css) is not None or el.matches(css) if hasattr(el, "matches") else el.select_one(css) is not None


def classify(el):
    """(new type, variant text, colour, question id or None, note) for one direct child of <main>."""
    cls = " ".join(el.get("class", []))
    q = lambda css: el.select_one(css) is not None or any(c in el.get("class", []) for c in css.strip(".").split("."))
    if el.name == "header" and ("phero" in cls or "hero" in cls):
        return "T-01", "הירו", Y, "hero", "גובה (גדול / בינוני / קטן) ומיקום הכפתור"
    if el.select_one(".ea-crumb") or "ea-crumb-bar" in cls:
        return None
    if "cta-band" in cls or el.select_one("section.cta-band"):
        band = el if "cta-band" in cls else el.select_one("section.cta-band")
        full = band.select_one(".cta-band__h") and band.select_one(".cta-band__p")
        tone = "חול" if "cta-band--sand" in " ".join(band.get("class", [])) else "כהה"
        if not full:
            return "T-08", f"פס קריאה לפעולה · רקע {tone}", R, "cta", "חסרים כותרת או טקסט — הכלל: תמיד כותרת + טקסט + כפתור"
        return "T-08", f"פס קריאה לפעולה · רקע {tone}", G, None, ""
    if el.select_one(".ea-toc") or "ea-toc" in cls:
        return "T-23", "תוכן עניינים", G, None, ""
    if el.select_one(".whom"):
        return "T-09", "כרטיסים · בולטים עם תמונות (למי מתאים)", Y, "k4", "חלוקה לארבעה: 2+2 / גדול-שניים-גדול / גדול ושלושה"
    if el.select_one(".ea-now"):
        return "T-09", "כרטיסים · שורת זרקור", Y, "k4now", "חלוקה לארבעה: 2+2 / גדול ושלושה"
    if el.select_one(".point-cards"):
        return "T-09", "כרטיסים → בולטים", Y, "bul", "בולטים: מספרים או לוגו"
    for css, name in ((".cmp", "כרטיסים · השוואה בין שניים (3+3)"), ("section.start", "כרטיסים · שלושה צעדים"),
                      (".bookcards", "כרטיסים · ספרים ומוצרים"), ("article.ea-blog-card", "כרטיסים · בלוג (רשימה פתוחה, 3 בשורה)")):
        if el.select_one(css) or (css.startswith("section.") and css.split(".")[1] in cls):
            return "T-09", name, G, None, ""
    if el.select_one(".gallery"):
        n = len(el.select(".gallery > *"))
        if n > 10:
            return "T-11", f"רשת תמונות · {n} תמונות — רשימה פתוחה, 3 בשורה, שורה לכל צורה", G, None, ""
        if n in (1, 2, 3, 4, 5):
            return "T-11", f"רשת תמונות · {n} תמונות", Y, f"k{n}", f"חלוקה ל-{n} מהרשימה הנעולה"
        return "T-11", f"רשת תמונות · {n} תמונות — מורכב משורות מהרשימה", Y, "k6plus", "איך לחלק"
    if el.select_one(".split2") or el.select_one(".mokesh-portrait"):
        sp = el.select_one(".split2")
        c = " ".join(sp.get("class", [])) if sp else ""
        fig = sp.select_one(".split2__m") if sp else None
        figc = " ".join(fig.get("class", [])) if fig else ""
        shape = "לאורך — טקסט 4, תמונה 2" if "figr--p" in figc else "לרוחב — 3+3"
        side = "ימין" if "split2--rev" in c else "שמאל"
        fit = " · מילוי בגובה הטקסט" if "split2--cover" in c else ""
        return "T-06", f"טקסט ותמונה · {shape} · צד התמונה {side}{fit}", G, None, ""
    if el.select_one(".collage") or "collage" in cls:
        return "T-06", "טקסט ותמונה · תצרף שלוש תמונות", R, "draw", "הוריאנט עוד לא שורטט"
    if el.select_one(".studio") or "studio" in cls:
        return "T-06", "טקסט ותמונה · טור כהה עם כפתור", R, "draw", "הוריאנט עוד לא שורטט"
    if "photo-band" in cls or "bleed" in cls:
        return "T-10", "פס תמונה ברוחב מלא", R, "draw", "הטיפוס עוד לא שורטט"
    if el.select_one(".testi-mq"):
        return "T-18", "המלצות · גלילה", G, None, ""
    if el.select_one(".testi-grid"):
        return "T-18", "המלצות · רשת (רשימה פתוחה, 3 בשורה)", G, None, ""
    if "ea-testi-cards" in cls:
        return "T-18", "המלצות · בתוך הקריאה", G, None, ""
    if "ea-faq-list" in cls or "ea-faq-mini-section" in cls or el.select_one(".ea-faq-list, .ea-faq-mini-section"):
        return "T-21", "אקורדיון · שאלות (העיצוב — בסבב הבא)", G, None, ""
    if el.select_one("div.dd"):
        return "T-21", "אקורדיון · מונחים (העיצוב — בסבב הבא)", G, None, ""
    if el.select_one("ol.tl"):
        return "T-29", "רשימת שנים · ציר זמן", G, None, ""
    if "ea-press" in cls:
        return "T-29", "רשימת שנים · עיתונות", G, None, ""
    if el.select_one(".videoblk"):
        pend = el.select_one(".ea-pending-approval")
        return ("S-1" if pend else "T-26"), ("ממתין לתוכן · סרטון" if pend else "וידאו · עם כותרת וטקסט"), G, None, ""
    if el.select_one(".fbgrid"):
        return "T-28", "פוסטים מפייסבוק · 2 טורים חופשיים", G, None, ""
    if el.select_one(".ea-photo-slot"):
        return "S-1", "ממתין לתוכן · תמונה", G, None, ""
    if "ea-wave2-contact" in cls:
        return "T-31", "יצירת קשר", G, None, ""
    if el.select_one(".prose-fold"):
        return "T-04", "פסקת טקסט · מקופלת", G, None, ""
    if el.select_one("iframe[src*=youtu]"):
        return "T-26", "וידאו · בתוך הקריאה", G, None, ""
    if el.select_one(".intro-body") or el.select_one(".h2"):
        note = "עם תמונה צפה (גודל אחד — השלב הבא)" if el.select_one(".pfloat") else ""
        tone = "רקע כהה" if "sec--dark" in cls else ("רקע שמנת (היה חלופי)" if "sec--alt" in cls else "רקע שמנת")
        return "T-04", f"פסקת טקסט · {tone}", G, None, note
    return "?", "לא זוהה", R, "none", f"<{el.name} class=\"{cls[:60]}\">"


def main():
    cached = "--cached" in sys.argv
    os.makedirs(CACHE, exist_ok=True)
    urls = population()
    pages, templates = [], {"posts": 0, "qr": 0}
    for n, u in enumerate(urls, 1):
        path = urllib.parse.unquote(urllib.parse.urlparse(u).path)
        fn = os.path.join(CACHE, re.sub(r"[^\w]+", "_", path).strip("_") or "home") + ".html"
        if cached and os.path.exists(fn):
            body = open(fn, "rb").read()
        else:
            st, body = get(u)
            if st != 200:
                continue
            open(fn, "wb").write(body)
            time.sleep(0.3)
        s = BeautifulSoup(body, "lxml")
        if s.select_one("body.single-post"):
            templates["posts"] += 1
            continue
        if s.select_one("body.ea-qr") or path.startswith("/qr/"):
            templates["qr"] += 1
            continue
        main_el = s.find("main")
        if not main_el:
            continue
        title = (s.title.get_text() if s.title else path).split(" - ")[0].strip()
        rows = []
        for i, el in enumerate([c for c in main_el.children if getattr(c, "name", None)], 1):
            r = classify(el)
            if r is None:
                continue
            t, var, col, qid, note = r
            rows.append({"n": len(rows) + 1, "type": t, "variant": var, "color": col, "q": qid, "note": note,
                         "html": str(el) if col != G else ""})
        wc = words(main_el)
        if wc > 1400 and not any(r["type"] == "T-23" for r in rows):
            rows.insert(1, {"n": 0, "type": "T-23", "variant": f"תוכן עניינים — שורה חדשה ({wc} מילים)", "color": G,
                            "q": None, "note": "כלל D55", "html": ""})
        pages.append({"path": path, "title": title, "words": wc, "rows": rows})
        if n % 25 == 0:
            print(f"  {n}/{len(urls)}", file=sys.stderr)
    for p in pages:
        for k, r in enumerate(p["rows"], 1):
            r["id"] = f'{p["path"].strip("/").replace("/", "-") or "home"}.{k}'
    count = {c: sum(1 for p in pages for r in p["rows"] if r["color"] == c) for c in (G, Y, R)}
    out = {"_meta": {"date": time.strftime("%Y-%m-%d"), "pages": len(pages), "templates": templates, "count": count}, "pages": pages}
    json.dump(out, open(os.path.join(HERE, "reset-rows.json"), "w", encoding="utf-8"), ensure_ascii=False, indent=1)
    print(json.dumps(out["_meta"], ensure_ascii=False))


if __name__ == "__main__":
    main()
