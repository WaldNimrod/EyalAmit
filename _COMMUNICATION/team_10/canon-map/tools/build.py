"""Build the canon map: real rendered markup copied from live pages, grouped, labelled."""
import copy, datetime, hashlib, re, sys
from bs4 import BeautifulSoup, Comment

STAGE = "http://eyalamit-co-il-2026.s887.upress.link"
OUT = sys.argv[1]

PAGES = {"home": "/", "method": "/method/", "repair": "/repair/", "contact": "/contact/", "books": "/books/",
         "kushi": "/books/kushi-blantis/", "snoring": "/snoring-sleep-apnea/", "lessons": "/lessons/",
         "testimonials": "/testimonials/", "learning": "/learning/", "mokesh": "/eyal-amit/mokesh-dahiman/",
         "press": "/press/", "eyal": "/eyal-amit/", "qr1": "/qr/qr1/", "bags": "/bags/", "blog": "/blog/",
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
t("T-01", "הירו", "phero", "גובה · מדיה (תמונה / סרטון / ללא) · תווית · כותרת · תת-כותרת · כפתור",
  [("מאושר — גדול, עם סרטון: הטקסט בטורים 1–4, הכפתור בטורים 5–6 בשורה אחת, מיושר לתחתית. כמעט מסך מלא עם סרגלי הדפדפן פתוחים (92% מהגובה הנראה)", "method", "header.phero--media", 0, None, ("__APPROVED_VIDEO__", "cm-h-l")),
   ("מאושר — גדול, עם תמונה (92%)", "method", "header.phero--media", 0, None, ("__APPROVED__", "cm-h-l")),
   ("מאושר — אותו הירו, הכפתור למעלה: ראש הכפתור בקו אחד עם ראש הכותרת (למשל דף הבית). בוחרים לפי הטקסט והתמונה", "method", "header.phero--media", 0, None, ("__APPROVED__", "cm-h-l cm-btn-top")),
   ("מאושר — בינוני (66%)", "method", "header.phero--media", 0, None, ("__APPROVED__", "cm-h-m")),
   ("מאושר — קטן: 44%, גובה מינימלי — טקסט ארוך מגדיל אותו. מוצג עם התוכן הקצר של עמוד יצירת הקשר", "contact", "header.phero--half", 0, None, ("__APPROVED__", "cm-h-s")),
   ("היום באתר — דף הבית (סרטון, כותרת ממורכזת)", "home", "header.hero", 0, None, None),
   ("היום באתר — עמוד מוקש (סרטון יוטיוב)", "mokesh", "header.mokesh-hero", 0, None, None),
   ("היום באתר — עמוד פנימי עם תמונה (88%)", "method", "header.phero--media", 0, None, None),
   ("היום באתר — קומפקטי (78%)", "repair", "header.phero--compact", 0, None, None),
   ("היום באתר — חצי גובה (44%)", "contact", "header.phero--half", 0, None, None),
   ("היום באתר — בלי תמונה", "bags", "main > header.phero", 0, None, None)],
  note="טיפוס אחד לכל פתיחות העמודים, כולל דף הבית ועמוד מוקש (נימרוד, 27.9: «הירו — מאשר. ואז לא צריך גם במפה סקשן נפרד»). "
       "T-02 ו-T-03 אוחדו לכאן והמספרים שלהם לא ישמשו שוב. המדיה היא שדה: תמונה, סרטון או ללא. "
       "הכפילות בקוד (שני קבצי הירו וידאו) — בטיפול צוות 90.")

group("טקסט")
t("T-04", "פסקת קריאה", "prose", "chap · title · body · center · alt · dark · id",
  [("היום באתר", "method", "main > section.sec", 1, None, None),
   ("היום באתר — רקע כהה", "home", "section#session", 0, None, None),
   ("מאושר — הכותרת בטורים 1–6, הטקסט הרץ בטורים 2–5", "method", "main > section.sec", 1, None, ("__APPROVED__", "cm-pr-c")),
   ("מאושר — אותו דבר על רקע כהה", "home", "section#session", 0, None, ("__APPROVED__", "cm-pr-c")),
   ("מאושר — גוון 1 מתוך 5: שמנת (הרקע הרגיל) — קישור בטרקוטה", "method", "main > section.sec", 1, None, ("__APPROVED__", "cm-pr-c cm-bg cm-bg-ivory")),
   ("מאושר — גוון 2 מתוך 5: חול — טקסט חום כהה, קישור בחלודה", "method", "main > section.sec", 1, None, ("__APPROVED__", "cm-pr-c cm-bg cm-bg-sand")),
   ("מאושר — גוון 3 מתוך 5: זית (דרגה אחת כהה יותר) — טקסט לבן, כותרת שמנת, קישור זהב", "method", "main > section.sec", 1, None, ("__APPROVED__", "cm-pr-c cm-bg cm-bg-olive")),
   ("מאושר — גוון 4 מתוך 5: טרקוטה (דרגה אחת כהה יותר מצבע המותג) — טקסט לבן, כותרת שמנת, קישור זהב", "method", "main > section.sec", 1, None, ("__APPROVED__", "cm-pr-c cm-bg cm-bg-terra-dk")),
   ("מאושר — גוון 5 מתוך 5: כהה (כמו היום) — כותרת שמנת, קישור טרקוטה בהיר", "method", "main > section.sec", 1, None, ("__APPROVED__", "cm-pr-c cm-bg cm-bg-dark"))])
t("T-05", "פסקה מקופלת", "prose (collapsible)", "collapsible · preview_lines · toggle_label + שדות פסקת הקריאה",
  [(None, "kushi", ".prose-fold", 0, None, None),
   ("מאושר — הקטע המקופל הוא כרטיס במסגרת עדינה בטורים 2–5; רואים פסקה של ממש (כעשר שורות) שדוהה בתחתית, וכפתור קטן ועדין «להמשך קריאה» משמאל", "kushi", ".prose-fold", 0, None, ("__APPROVED__", "cm-pr-c cm-fold"))])
t("T-07", "תמונה צפה בתוך הטקסט", "prose (float_*)", "float_image · float_alt · float_zoom · float_side · float_mod",
  [(None, "snoring", ".pfloat", 0, None, None), ("וריאנט: עומדת, גדולה", "repair", ".pfloat--standing", 0, None, None)])

group("תמונה וטקסט")
t("T-06", "טקסט ותמונה זה לצד זה", "split", "chap · title · body · image · alt · figr · reversed · soft · cover · zoom",
  [(None, "method", ".split2", 0, None, None), ("וריאנט: תמונה ממלאת", "repair", ".split2--cover", 0, None, None),
   ("היום באתר — תמונה לאורך", "eyal", ".split2", 0, None, None),
   ("מאושר — תמונה לרוחב (5:4), צד התמונה שמאל: טקסט בטורים 1–3, תמונה בטורים 4–6. טקסט קצר — הטקסט ממורכז לגובה התמונה", "method", ".split2", 0, None, ("__APPROVED__", "cm-sp")),
   ("מאושר — תמונה לרוחב, צד התמונה ימין: תמונה בטורים 1–3, טקסט בטורים 4–6. טקסט ארוך — התמונה מיושרת למעלה", "eyal", ".split2", 1, None, ("__APPROVED__", "cm-sp")),
   ("מאושר — אותו דבר, עם שדה «המשך טקסט»: חלק מהטקסט הארוך עבר לטורים 2–5 מתחת לזוג", "eyal", ".split2", 1, None, ("__APPROVED__", "cm-sp cm-sp-more")),
   ("מאושר — תמונה לאורך (4:5), צד התמונה שמאל: טקסט בטורים 1–4, תמונה בטורים 5–6", "eyal", ".split2", 0, None, ("__APPROVED__", "cm-sp")),
   ("מאושר — תמונה לאורך, צד התמונה ימין: תמונה בטורים 1–2, טקסט בטורים 3–6", "mokesh", ".split2", 5, None, ("__APPROVED__", "cm-sp"))])
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
  [(None, "kushi", ".gallery", 0, None, None), ("וריאנט: דיוקנאות", "repair", ".gallery--portraits", 0, None, None)])
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
   ("מאושר — בטורים 2–5, כמו טקסט רץ (העיצוב — בסבב הבא)", "method", "section.ea-faq-list", 0, None, ("__APPROVED__", "cm-25")),
   ("וריאנט: כרטיסים", "repair", "section.ea-faq-list--cards", 0, None, None),
   ("וריאנט: מקוצר, דף הבית", "home", "section.ea-faq-mini-section", 0, None, None)])
t("T-22", "אקורדיון הגדרות", "dd", "chap · title · lead · dark · items[tag, title, body, active]",
  [(None, "lessons", "div.dd", 0, None, None)])
t("T-23", "תוכן עניינים", "toc", "heading · items[id, label]",
  [(None, "snoring", "div.ea-toc", 0, None, None),
   ("מאושר — בטורים 2–5; מופיע בכל עמוד של יותר מ-1,400 מילים", "snoring", "div.ea-toc", 0, None, ("__APPROVED__", "cm-25"))])
t("T-29", "ציר זמן", "timeline", "chap · title · lead · items[year, text]",
  [(None, "mokesh", "ol.tl", 0, None, None),
   ("מאושר — בטורים 2–5, כמו טקסט רץ (העיצוב — בסבב הבא)", "mokesh", "ol.tl", 0, None, ("__APPROVED__", "cm-25"))])

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

group("קריאה לפעולה")
t("T-08", "פס קריאה לפעולה", "cta", "title · body · cta_label · cta_url · sand · btn",
  [("היום באתר — רקע חול", "method", "section.cta-band", 0, None, None),
   ("היום באתר — רקע כהה", "repair", "section.cta-band", 0, None, None),
   ("מאושר — רקע חול: פס נמוך יותר, הלוגו גדול ודהוי ברקע, צמוד לקצה המסך, הטקסט בטורים 1–4, הכפתור בטורים 5–6, בשורה אחת, מיושר לתחתית", "method", "section.cta-band", 0, None, ("__APPROVED__", "cm-cta-p")),
   ("מאושר — רקע כהה: אותו מבנה", "repair", "section.cta-band", 0, None, ("__APPROVED__", "cm-cta-p"))],
  note="מוצג בצורה המלאה בלבד — כפתור בלי כותרת ותת־כותרת אסור לפי החלטה סגורה.")
t("T-15", "איך מתחילים", "start (דף הבית)", "start_bg · start_chap · start_title · start_steps[title, text] · start_cta_label · start_cta_url",
  [(None, "home", "section#start", 0, None, None)])
t("T-31", "יצירת קשר", "contact", "אין שדות — טופס, פס וואטסאפ ופרטי קשר קבועים",
  [(None, "contact", "section.ea-wave2-contact", 0, None, None),
   (None, "contact", "section.ea-wave2-contact__cta", 0, None, None),
   (None, "contact", "section.ea-wave2-contact__nap", 0, None, None)])

group("מעטפות")
t("T-32", "רשימת עיתונות", "ea-press", "רשימה קבועה: שנה · מקור · קישור · כותרת",
  [(None, "press", "section.ea-press", 0, None, None),
   ("מאושר — בטורים 2–5, כמו טקסט רץ", "press", "section.ea-press", 0, None, ("__APPROVED__", "cm-25"))])
t("T-33", "מעטפת עמוד קוד מודפס", "tpl-chapters-qr", "הפוסט: כותרת · תמונה ראשית · תוכן חופשי",
  [(None, "qr1", "main > header.phero", 0, None, None), (None, "qr1", "main > section.sec", 0, None, None),
   ("מאושר — גוף העמוד כמו פסקת טקסט: כותרת 1–6, טקסט 2–5", "qr1", "main > section.sec", 0, None, ("__APPROVED__", "cm-25"))])
t("T-34", "פוסט בלוג — ארכיון", "tpl-chapters-blog-single", "הפוסט: כותרת · קטגוריה · תאריך · תמונה ראשית · תוכן חופשי",
  [(None, "post", "main > header.phero", 0, None, None), (None, "post", "main > section.sec", 0, None, ("__BODY__", 6)),
   ("מאושר — גוף הפוסט כמו פסקת טקסט: כותרת 1–6, טקסט 2–5", "post", "main > section.sec", 0, None, ("__APPROVED__", "cm-25"))])
D = ("__DUMMY__", 0)
t("T-37", "פוסט בלוג — תבנית חדשה", "ea-post-v1 (JSON)", "hero · media[] · video · rows[part, bg, …]",
  [("שורה: hero", "method", "header.phero--media", 0, None, D),
   ("שורה: prose", "method", "main > section.sec", 1, None, D),
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


# Grid-discipline proposals (team_00, 2026-09-27: «אם הגריד שלנו הוא 6 — חלוקה ל-4 לא אפשרית… תמיד לפי הגריד, זה
# המשמעת שלו. אין אלמנט לא מיושר לגריד»). Every divided element: 1, 2, 3 or 6 per row on the six columns and the
# 10px gutter; four items are 2+2 rows, 2 small + 2 large, or 1 large + 3 small. Cards get a thin frame on the grid
# with the content padded inside. Appended to each type's examples as green proposals.
P = "__PROPOSAL__"
GRID_PROPOSALS = {
    "T-11": [("מאושר — כותרת מימין עם תת-כותרת, תמונה ראשית ברוחב מלא; אחריה שורות של 3 תמונות לרוחב (4:3), ובסוף שורות של 3 תמונות לאורך (3:4) — כל שורה בצורה אחת (תת-הכותרת — תוכן דמה)", "kushi", ".gallery", 0, None, ("__APPROVED__", "cm-g6 cm-hs cm-gal")),
             ("מאושר — ארבעה דיוקנאות (K-4.2): גדול, שניים זה מעל זה, גדול — בלוק אחד, במילוי", "repair", ".gallery--portraits", 0, None, ("__APPROVED__", "cm-g6 cm-k42"))],
    "T-09": [("מאושר — בולטים, וריאנט מספרים: רשימה סדורה בטורים 2–5, לכל בולט מספר, כותרת וטקסט", "repair", ".point-cards", 0, None, ("__APPROVED__", "cm-g6 cm-pl")),
             ("מאושר — בולטים, וריאנט לוגו: אותה רשימה, ולכל בולט סמל הלוגו במקום מספר", "repair", ".point-cards", 0, None, ("__APPROVED__", "cm-g6 cm-pl cm-pl-logo"))],
    "T-13": [("מאושר — בולטים עם תמונות: הטקסט גדול והתמונה רקע שלו (כמו במקור, reveals.php); כותרת מימין עם תת-כותרת (דמה); שתי שורות של 2", "home", "section#whom", 0, None, ("__APPROVED__", "cm-g6 cm-g4-22 cm-hs cm-bul")),
             ("מאושר — בולטים עם תמונות, הטקסט גדול על התמונה; K-4.2: גדול, שני קטנים זה מעל זה, גדול — בלוק אחד", "home", "section#whom", 0, None, ("__APPROVED__", "cm-g6 cm-g4-2112 cm-hs cm-bul")),
             ("מאושר — בולטים עם תמונות, הטקסט גדול על התמונה; K-4.3: 1 גדול ו-3 קטנים (3+1+1+1), במילוי", "home", "section#whom", 0, None, ("__APPROVED__", "cm-g6 cm-g4-3111 cm-hs cm-bul"))],
    "T-14": [("מאושר — 2 בשורה על הרשת; טקסט ממורכז ביישור בלוק (השורה האחרונה במרכז)", "home", "section#compare", 0, None, ("__APPROVED__", "cm-g6"))],
    "T-15": [("מאושר — 3 בשורה ברוחב התוכן; כותרת גדולה יותר", "home", "section#start", 0, None, ("__APPROVED__", "cm-g6"))],
    "T-24": [("מאושר — 3 בשורה, כרטיס במסגרת דקה", "books", "section#books", 0, None, ("__APPROVED__", "cm-g6 cm-frame"))],
    "T-25": [("מאושר — ארבעה כרטיסים: 1 גדול ו-3 קטנים (3+1+1+1), במסגרת דקה; הטקסט מיושר לתחתית, התמונה ממלאת את כל האזור שמעליו — רק מילוי בטיפוס הזה", "home", "section#ea-now", 0, None, ("__APPROVED__", "cm-g6 cm-g4-3111 cm-frame")),
             ("מאושר — ארבעה כרטיסים: שתי שורות של 2", "home", "section#ea-now", 0, None, ("__APPROVED__", "cm-g6 cm-g4-22 cm-frame"))],
    "T-35": [("מאושר — 3 בשורה על הרשת, כרטיס במסגרת דקה", "blog", "article.ea-blog-card", 0, None, ("__APPROVED__", "cm-g6 cm-frame"))],
    "T-18": [("מאושר — כותרת כמו בפסקת טקסט; שלושה כרטיסים שלמים ברוחב התוכן; חצים עדינים בלי מסגרת במרכז, צמודים מעל הכרטיסים, נקודות בשורה למטה; בראש הכרטיס עיגול, שם ותאריך", "method", ".testi-mq", 0, None, ("__APPROVED__", "cm-g6 cm-frame cm-tq"))],
    "T-19": [("מאושר — 3 בשורה על הרשת; בראש הכרטיס עיגול קטן, שם ותאריך", "testimonials", ".testi-grid", 0, None, ("__APPROVED__", "cm-g6 cm-frame cm-tq"))],
    "T-20": [("מאושר — ציטוט: ריווח קטן ומסגרת דקה בלבד (G-12.1), 2 בשורה על הרשת", "snoring", "section.ea-testi-cards", 0, None, ("__APPROVED__", "cm-g6 cm-q cm-q-frame"))],
    "T-28": [("מאושר — 2 טורים על הרשת, כל טור רץ בלי סנכרון לשני (הפוסט הבא מתחיל איפה שהקודם נגמר, לא טבלה); כל פוסט בכרטיס עדין: תאריך וכותרת שלנו, ומתחתם הפוסט בתוך מסגרת פנימית (כותרות ותאריכים — תוכן דמה)", "mokesh", "div.fbgrid", 0, None, ("__APPROVED__", "cm-g6 cm-fb"))],
    "T-31": [("מאושר — יצירת קשר בשורה אחת על הרשת, נכנסת במסך אחד. טורים 1–4: הטופס (שדות בזוגות, בלי תוויות, כפתור שליחה משמאל) ומתחתיו אזור הוואטסאפ הכהה עם שלוש הנקודות ככותרות; טורים 5–6: התמונה של אייל עם השפופרת ופרטי הקשר. שלושה אזורים נפרדים, כמו שאייל ביקש", "contact", "section.ea-wave2-contact", 0, None, ("__APPROVED__", "cm-ct"))],
    "T-27": [("מאושר — כמו כל פסקה: כותרת בטורים 1–6, הטקסט בטורים 2–5, הסרטון ברוחב מלא", "lessons", ".ea-pending-approval", 0, None, ("__APPROVED__", "cm-g6 cm-vd"))],
}
for item in G:
    if item[0] in GRID_PROPOSALS:
        item[4].extend(GRID_PROPOSALS[item[0]])


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
        elif sel in ("__PROPOSAL__", "__PROPOSAL_VIDEO__", "__APPROVED__", "__APPROVED_VIDEO__"):
            el["class"] = el.get("class", []) + keep.split()
            if "cm-tq" in keep.split():  # proposal: heading like a paragraph; quiet arrows centred above, dots below
                for w in el.select(".wrap.center"):
                    w["class"] = [c for c in w["class"] if c != "center"]
                for card in el.select(".tmq"):  # a small link at the bottom, in addition to the name link
                    a = card.select_one("a.tmq__nl")
                    if a and a.get("href"):
                        more = BeautifulSoup(f'<a class="cm-tq__more" href="{a["href"]}" target="_blank" rel="noopener">לקריאה במקור ›</a>', "lxml").a
                        card.append(more)
                mq = el.select_one(".testi-mq")
                if mq:
                    nav = BeautifulSoup('<div class="cm-tq__nav"></div>', "lxml").div
                    for b in mq.select(".testi-mq__btn"):
                        nav.append(b.extract())
                    mq.insert_before(nav)
                    pages = max(1, -(-len(mq.select(".tmq")) // 3))
                    mq.insert_after(BeautifulSoup('<div class="cm-tq__dots" aria-hidden="true">'
                                                  + "".join(f'<i{" class=on" if k == 0 else ""}></i>' for k in range(pages))
                                                  + "</div>", "lxml").div)
            if "cm-gal" in keep.split():  # proposal: one shape per row — landscapes first, portraits last
                import os
                from PIL import Image
                site = os.path.join(os.path.dirname(os.path.abspath(__file__)), "..", "..", "..", "..", "site")
                g = el.select_one(".gallery")
                # team_00: the book-cover files (white margins, front+back spread) are not gallery photos — out of the example.
                for f in [f for f in g.children if getattr(f, "name", None)]:
                    im = f.select_one("img")
                    if im and im["src"].rsplit("/", 1)[-1] in ("kush-04.jpg", "kush-05.jpg"):
                        f.decompose()
                figs = [f for f in g.children if getattr(f, "name", None)]
                def portrait(f):
                    im = f.select_one("img")
                    fp = os.path.normpath(site + "/wp-content" + im["src"].split("?")[0].split("/wp-content", 1)[-1]) if im else ""
                    try:
                        w, h = Image.open(fp).size
                        return h > w * 1.05
                    except Exception:
                        return False
                por = [f for f in figs if portrait(f)]
                for f in por:
                    f["class"] = f.get("class", []) + ["cm-por"]
                    g.append(f.extract())
            if "cm-hs" in keep.split():  # proposal: heading on the right with a subtitle (dummy when the content has none)
                w = el.select_one(".wrap.center") or el.select_one(".wrap")
                if w and "center" in w.get("class", []):
                    w["class"] = [c for c in w["class"] if c != "center"]
                h = w.select_one("h2") if w else None
                if h and not (h.find_next_sibling() and "lead" in (h.find_next_sibling().get("class") or [])):
                    h.insert_after(BeautifulSoup('<p class="lead cm-sub">תת-כותרת — שורה אחת שמסבירה את הבלוק (תוכן דמה)</p>', "lxml").p)
            if "cm-ct" in keep.split():  # proposal: the contact page's three rows become one row on the grid
                row = el.select_one(".ea-contact-form-row")
                side = BeautifulSoup('<aside class="cm-ct__side"></aside>', "lxml").aside
                por = row.select_one(".ea-contact-portrait")
                if por:
                    side.append(por.extract())
                nap = SOUP["contact"].select_one(".ea-contact-nap")
                if nap:
                    side.append(copy.copy(nap))
                cta = SOUP["contact"].select_one(".ea-contact-cta")
                if cta:
                    row.select_one(".ea-entrance").append(copy.copy(cta))  # WhatsApp under the form, same column
                row.append(side)
            if "cm-fb" in keep.split():  # proposal: each embedded post gets our own date and title above it (dummy)
                for n, it in enumerate(el.select(".fbgrid__item"), 1):
                    it.insert(0, BeautifulSoup(f'<div class="cm-fb__h"><span class="cm-fb__d">תאריך</span>'
                                               f'<h3 class="cm-fb__t">כותרת שלנו לפוסט {n}</h3></div>', "lxml").div)
            if "cm-sp-more" in keep.split():  # proposal: split's «המשך טקסט» field, full reading width under the pair
                body = el.select_one(".split2 .intro-body")
                kids = [c for c in body.children if getattr(c, "name", None)]
                more = BeautifulSoup('<div class="cm-sp-after"><div class="intro-body"></div></div>', "lxml").div
                for c in kids[3:]:
                    more.div.append(c.extract())
                el.select_one(".split2").insert_after(more)
            if sel in ("__PROPOSAL_VIDEO__", "__APPROVED_VIDEO__"):
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
        ap = bool(c[5]) and c[5][0] in ("__APPROVED__", "__APPROVED_VIDEO__")
        body.append(f'<div class="cm-spec{" cm-dummy" if dm else ""}{" cm-prop" if pr else ""}{" cm-appr" if ap else ""}">'
                    + ('<span class="cm-dummy__badge">תוכן דמה — לא מופיע באתר</span>' if dm else "")
                    + ('<span class="cm-dummy__badge cm-prop__badge">הצעה לאישור — עדיין לא באתר</span>' if pr else "")
                    + ('<span class="cm-dummy__badge cm-appr__badge">מאושר — ייושם באתר בסבב האיפוס</span>' if ap else "")
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
/* Buttons (team_00, all buttons): less padding around the label. Applied to approved and proposed examples. */
:root{--cm-btn-pad-block:9px;--cm-btn-pad-inline:18px}
.cm-appr .btn,.cm-prop .btn{padding:var(--cm-btn-pad-block) var(--cm-btn-pad-inline)!important}
/* The six-column grid's gutter — one value (team_00: 24 → 4 → 10px). */
:root{--cm-gap:10px}
.cm-spec{transform:translateZ(0);position:relative}
.r,.r2,.r3,.r--fade,[class*="ea-entrance"]{opacity:1!important;transform:none!important;animation:none!important}
body{background:#f7f2ea}
.cm-top{background:#1d140d;color:#f3ece2;padding:24px 24px 18px;font-family:Heebo,sans-serif}
.cm-top h1{margin:0 0 6px;font-size:1.5rem;font-weight:500;color:#f3ece2}
.cm-top p{margin:0 0 3px;font-size:.85rem;opacity:.8}
.cm-tabs{position:sticky;top:0;z-index:200;display:flex;gap:4px;overflow-x:auto;background:#2a1d12;padding:8px 12px;font-family:Heebo,sans-serif;box-shadow:0 2px 8px #0003}
.cm-tab{flex:0 0 auto;color:#e9dccb;background:none;border:0;font:inherit;font-size:.9rem;padding:7px 12px;border-radius:4px;cursor:pointer}
.cm-tab:hover,.cm-pg:hover{background:#ffffff14}
.cm-pgs{display:flex;gap:4px;margin-inline-start:auto;padding-inline-start:12px;border-inline-start:1px solid #ffffff2e}
.cm-pg{flex:0 0 auto;color:#e9dccb;background:none;border:1px dashed #ffffff40;font:inherit;font-size:.85rem;padding:6px 10px;border-radius:4px;cursor:pointer}
.cm-pg.is-on{background:#e9dccb;color:#1d140d;border-style:solid}
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
.cm-appr{outline:3px solid #2d5f8a;outline-offset:-3px}
.cm-dummy__badge.cm-appr__badge{background:#2d5f8a;color:#fff}
.cm-dummy__badge.cm-prop__badge{background:#3f7a52;color:#fff}
header.phero.cm-h-l{min-height:92svh!important}
header.phero.cm-h-m{min-height:66svh!important}
header.phero.cm-h-s{min-height:44svh!important}
/* Approved (team_00, CTA): less height; the logo is atmosphere, not a column — large, faded, behind the text;
   text columns 1-4, button spans columns 5-6 on one line, bottom-aligned; the logo is pinned to the screen edge; same six-column grid as the approved hero. */
section.cta-band.cm-cta-p{padding-block:clamp(40px,4vw,56px);position:relative;overflow:hidden}
section.cta-band.cm-cta-p .cta-band__in{direction:rtl;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:var(--cm-gap);align-items:end;position:relative}
section.cta-band.cm-cta-p .cta-band__logo.cta-band__logo--side{position:absolute;grid-column:auto;grid-row:auto;inset-block:50% auto;inset-inline-start:calc((100% - 100vw) / 2);
  width:min(52%,520px);height:auto;aspect-ratio:1;min-height:0;transform:translateY(-50%);z-index:0;opacity:.16;
  -webkit-mask-image:linear-gradient(to left,#000 35%,transparent 90%);mask-image:linear-gradient(to left,#000 35%,transparent 90%)}
section.cta-band.cm-cta-p .cta-band__txt{grid-column:1/5;grid-row:1;position:relative;z-index:1;align-self:end}
section.cta-band.cm-cta-p .cta-band__act{grid-column:5/7;grid-row:1;position:relative;z-index:1;align-self:end;justify-content:flex-start}
section.cta-band.cm-cta-p .cta-band__act .btn{width:100%;box-sizing:border-box;padding-inline:12px;white-space:nowrap;text-align:center;justify-content:center}
/* Approved (T-04), per team_00's earlier definition (POST-TEMPLATE-SETTINGS §1): heading and eyebrow in columns 1-6;
   running text in columns 2-5 (team_00 corrected 2-6). */
section.sec.cm-pr-c>.wrap{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:var(--cm-gap)}
section.sec.cm-pr-c>.wrap>*{grid-column:1/-1}
section.sec.cm-pr-c>.wrap>.intro-body,section.sec.cm-pr-c>.wrap>.lead{grid-column:2/6;max-width:none;margin-inline:0}
section.sec.cm-pr-c>.wrap>.h2,section.sec.cm-pr-c>.wrap>.chap{text-align:start}
/* Approved (T-04 backgrounds, team_00 D34-D35): five distinct palette tones. team_00: each tone has its own full text set — the link
   colour always differs from the running text, and the heading colour suits the background. Every role clears WCAG AA
   with a 10% margin (tools/palette_check.py, FIVE). Olive and terracotta are one step darker than the palette swatch:
   at the swatch value no link colour can differ from white text and still pass. */
section.sec.cm-bg{background:var(--bg)!important;background-image:none!important}
section.sec.cm-bg .chap{color:var(--t-eb)!important}
section.sec.cm-bg .h2{color:var(--t-h)!important}
section.sec.cm-bg .intro-body p,section.sec.cm-bg .intro-body li,section.sec.cm-bg .lead{color:var(--t-b)!important}
section.sec.cm-bg .intro-body a,section.sec.cm-bg .tlink{color:var(--t-a)!important;border-bottom-color:currentColor!important}
section.sec.cm-bg-ivory{--bg:#fffffa;--t-eb:#9A4F2B;--t-h:#2f2013;--t-b:#67482d;--t-a:#9A4F2B}
section.sec.cm-bg-sand{--bg:#D8C7B5;--t-eb:#7A3418;--t-h:#2f2013;--t-b:#4a3220;--t-a:#7A3418}
section.sec.cm-bg-olive{--bg:#575838;--t-eb:#F6D38A;--t-h:#FFE8C2;--t-b:#fff;--t-a:#F6D38A}
section.sec.cm-bg-terra-dk{--bg:#874321;--t-eb:#F6D38A;--t-h:#FFE8C2;--t-b:#fff;--t-a:#F6D38A}
section.sec.cm-bg-dark{--bg:#2A1A0C;--t-eb:#D08A5E;--t-h:#FFE8C2;--t-b:#EBEBEA;--t-a:#D08A5E}
/* Approved (T-06 split, rule D30: «כל ה-6 בחלוקה לפי התוכן וכיוון התמונה»): text and image share the six columns,
   split by the image's shape. Landscape and cover: 3 + 3. Portrait: text 4, image 2. Reversed mirrors the sides.
   The text keeps a breathing space on the side facing the image, inside its own columns. */
section.cm-sp .split2{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:var(--cm-gap);--sp-air:clamp(16px,3vw,40px)}
section.cm-sp .split2>:not(.split2__m){grid-column:1/4;grid-row:1;padding-inline-end:var(--sp-air)}
section.cm-sp .split2>.split2__m{grid-column:4/7;grid-row:1}
section.cm-sp .split2.split2--rev>:not(.split2__m){grid-column:4/7;padding-inline-end:0;padding-inline-start:var(--sp-air)}
section.cm-sp .split2.split2--rev>.split2__m{grid-column:1/4}
section.cm-sp .split2:has(>.figr--p)>:not(.split2__m){grid-column:1/5}
section.cm-sp .split2:has(>.figr--p)>.split2__m{grid-column:5/7}
section.cm-sp .split2.split2--rev:has(>.figr--p)>:not(.split2__m){grid-column:3/7}
section.cm-sp .split2.split2--rev:has(>.figr--p)>.split2__m{grid-column:1/3}
section.cm-sp .split2 .intro-body{max-width:none}
/* team_00: a long text never leaves the image floating mid-height — the image sits at the top; a short text is
   centred against the image. Optional «המשך טקסט» field: running text under the pair, columns 2-5 like a paragraph. */
section.cm-sp .split2{align-items:start}
section.cm-sp .split2>:not(.split2__m){align-self:center}
section.cm-sp .cm-sp-after{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:var(--cm-gap);margin-top:clamp(28px,3vw,44px)}
section.cm-sp .cm-sp-after>.intro-body{grid-column:2/6;max-width:none;margin:0}
/* Approved (team_00, D37): running text is block-justified in RTL, always, across the whole site — last line to the start
   (right). Shown on every approved and proposed example; the "today" examples stay as the site is. */
.cm-appr p,.cm-appr li,.cm-prop p,.cm-prop li{text-align:justify;text-align-last:start}
/* Approved (team_00, A-1): every example in the map and the sketches sits on the nearest canonical tone — the map only,
   not the site. ivory-2 #efeae1 and the near-white #faf8f5 -> ivory; the dark gradients -> dark #2A1A0C.
   Card surfaces (white cards) and backgrounds behind images are not section tones and stay. */
.cm-spec :is(.sec--alt,.ea-faq-mini-section,.ea-press){background:#fffffa!important;background-image:none!important}
.cm-spec :is(.sec--dark,.cta-band:not(.cta-band--sand),section.start,.videoblk,.studio__t){background:#2A1A0C!important;background-image:none!important}
/* Approved (team_00, A-5): one "waiting for content" state for every image or video, in one bold colour that can never
   be mistaken for content. */
.cm-spec :is(.ph,.ea-pending-approval){background:repeating-linear-gradient(135deg,#FFE4F0 0 14px,#FFD1E6 14px 28px)!important;
  border:3px dashed #D6006F!important;box-shadow:none!important;color:#8A0047!important}
.cm-spec :is(.ph span,.ea-pending-approval__badge){background:#D6006F!important;color:#fff!important;box-shadow:none!important;
  font-weight:600;border-radius:100px;padding:6px 14px}
.cm-spec :is(.ea-pending-approval__title,.ea-pending-approval__note){color:#8A0047!important}
/* Approved (T-05 fold, team_00: «ההמשך קריאה לא מזמין ולא ממוקם טוב לעברית… כפתור קטן ועדין ומשמאל, מסגרת שזה
   ייצר כרטיס»): the folded text is a framed card in the paragraph's text columns; the peek fades out at the bottom;
   a small outline pill at the card's left (end) edge opens it. */
section.sec.cm-pr-c.cm-fold>.wrap>.prose-fold{grid-column:2/6;border:1px solid #d9c9b6;border-radius:12px;background:#fffffa;
  padding:clamp(20px,2.4vw,32px) clamp(20px,2.6vw,36px) 16px}
section.cm-fold .prose-fold__peek{display:block!important;-webkit-line-clamp:unset!important;line-clamp:unset!important;max-height:15em;overflow:hidden;-webkit-mask-image:linear-gradient(#000 55%,transparent);mask-image:linear-gradient(#000 55%,transparent)}
section.cm-fold .prose-acc{border:0;display:flex;flex-direction:column}
section.cm-fold .prose-acc__t{align-self:flex-end;display:inline-flex;gap:8px;padding:5px 14px!important;margin-top:6px;
  border:1px solid #9A4F2B;border-radius:100px;font-family:Heebo,sans-serif;font-size:.85rem;font-weight:500;color:#9A4F2B}
section.cm-fold .prose-acc__t:hover{background:#9A4F2B;color:#fff}
section.cm-fold .prose-acc__t::after{width:6px;height:6px;border-color:currentColor;margin-top:-3px}
section.cm-fold .prose-acc[open] .prose-acc__t{order:2;margin-top:14px}
section.cm-fold .prose-acc .intro-body{padding-bottom:0}
/* Approved (grid discipline): the section's content box is the six columns; text blocks in 2-5 like a paragraph. */
.cm-g6 .wrap{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:var(--cm-gap)}
.cm-g6 .wrap:has(>.ea-now){padding-inline:48px!important}
.cm-g6 .wrap>*{grid-column:1/-1}
.cm-g6 :is(.point-cards,.cm-vd .wrap>div:not([class])){display:contents}
.cm-g6 .wrap :is(.intro-body,.lead,.point-cards__lead,.point-cards__after){grid-column:2/6;max-width:none;margin-inline:0}
.cm-g6.cm-vd .wrap h2{grid-column:1/-1}
.cm-g6 :is(.gallery,.point-cards__grid,.whom,.cmp,.steps3,.bookcards,.ea-now,.ea-blog-grid,.testi-grid,.ea-testi-cards__list,.fbgrid){
  display:grid!important;grid-template-columns:repeat(6,minmax(0,1fr))!important;gap:var(--cm-gap)!important;grid-column:1/-1;max-width:none!important;width:auto!important;margin-inline:0!important}
.cm-g6 :is(.gallery,.steps3,.bookcards,.ea-blog-grid,.testi-grid)>*{grid-column:span 2!important;flex:none!important;width:auto!important;max-width:none!important;margin:0!important}
.cm-g6 :is(.point-cards__grid,.cmp,.ea-testi-cards__list,.fbgrid)>*{grid-column:span 3!important;width:auto!important;max-width:none!important;margin:0!important}
.cm-g6.cm-g4-22 :is(.whom,.ea-now)>*{grid-column:span 3!important}
/* O-11 (team_00: «טקסט מיושר לחלק התחתון, תמונה חייבת למלא את כל האזור שלה — רק fill לטיפוס זה»). */
.cm-g6.cm-g4-3111 .ea-now{grid-auto-rows:400px}
.cm-g6.cm-g4-3111 .ea-now__card{display:flex!important;flex-direction:column;height:100%;box-sizing:border-box}
.cm-g6.cm-g4-3111 .ea-now__ph{flex:1 1 auto;min-height:0;aspect-ratio:auto!important}
.cm-g6.cm-g4-3111 .ea-now__ph img{height:100%;object-fit:cover}
.cm-g6.cm-g4-3111 .ea-now__tx{flex:none;padding:10px 0 0}
/* K-4.2 (team_00: «שני הקטנים צריכים להיות אחד מעל השני, לא ליד השני, שזה יתיישר לבלוק»): large, two small stacked, large. */
.cm-g6.cm-g4-2112 :is(.whom,.ea-now)>:nth-child(1){grid-column:1/3!important;grid-row:1/3}
.cm-g6.cm-g4-2112 :is(.whom,.ea-now)>:nth-child(2){grid-column:3/5!important;grid-row:1}
.cm-g6.cm-g4-2112 :is(.whom,.ea-now)>:nth-child(3){grid-column:3/5!important;grid-row:2}
.cm-g6.cm-g4-2112 :is(.whom,.ea-now)>:nth-child(4){grid-column:5/7!important;grid-row:1/3}
.cm-g6.cm-g4-3111 :is(.whom,.ea-now)>:nth-child(1){grid-column:span 3!important}
.cm-g6.cm-g4-3111 :is(.whom,.ea-now)>:not(:nth-child(1)){grid-column:span 1!important}
.cm-g6 :is(.whom,.ea-now)>*{width:auto!important;max-width:none!important;margin:0!important}
.cm-g6 .whom__m{width:100%!important;height:auto!important;aspect-ratio:1}
/* Fill mode (team_00: one image-sizing mode per composition; in fill every row is one clean block). */
.cm-g6[class*="cm-g4-"] .whom{grid-auto-rows:minmax(0,300px)}
.cm-g6.cm-g4-2112 .whom{grid-auto-rows:240px}
.cm-g6[class*="cm-g4-"] .whom__i{display:flex!important;flex-direction:column;min-height:0}
.cm-g6[class*="cm-g4-"] .whom__m{flex:1 1 auto;min-height:0;aspect-ratio:auto!important;margin-bottom:8px}
.cm-g6[class*="cm-g4-"] .whom__p{margin:0;flex:none}
/* One-row compositions: image and caption rows shared across the row (subgrid), so every image ends on one line. */
.cm-g6.cm-g4-3111 .whom{grid-template-rows:280px auto;grid-auto-rows:auto;row-gap:8px}
.cm-g6.cm-g4-3111 .whom__i{display:grid!important;grid-row:1/3;grid-template-rows:subgrid;row-gap:8px}
.cm-g6.cm-g4-3111 .whom__m{margin:0;height:100%!important}
.cm-g6 .whom__m img{width:100%;height:100%;object-fit:cover}
.cm-g6 .cmpc :is(p,li){text-align:justify;text-align-last:center}
.cm-g6.start .start__in{width:min(1104px,100% - 32px);margin-inline:auto;padding-inline:0}
.cm-g6 .start__h{font-size:var(--fs-h1)!important}
/* Locked compositions applied (D46): K-4.2 and K-5.3. */
.cm-k42 .gallery{grid-template-rows:220px 220px}
.cm-k42 .gallery>:nth-child(1){grid-column:1/3!important;grid-row:1/3}
.cm-k42 .gallery>:nth-child(2){grid-column:3/5!important;grid-row:1}
.cm-k42 .gallery>:nth-child(3){grid-column:3/5!important;grid-row:2}
.cm-k42 .gallery>:nth-child(4){grid-column:5/7!important;grid-row:1/3}
.cm-k42 .gallery .gfig{height:100%}.cm-k42 .gallery .gfig img{width:100%;height:100%;aspect-ratio:auto!important;object-fit:cover}
.cm-k53 .point-cards__grid{grid-auto-flow:row dense}
.cm-k53 .point-cards__grid>:first-child{grid-column:span 2!important;grid-row:span 2}
.cm-k53 .point-cards__grid>:not(:first-child){grid-column:span 2!important}
/* Heading like the gallery (team_00: «הכותרת מימין — כולל תת-כותרת»). */
.cm-hs .wrap{text-align:start}
.cm-hs .wrap>.h2{margin-bottom:8px!important}
.cm-hs .cm-sub{grid-column:1/-1!important;margin:0;color:#67482d;font-size:var(--fs-lead);max-width:none;text-align:start}
/* O-2 gallery: a main image across the six columns, then three per row. */
/* The main image is a photo (the first item here is a book cover, which cannot fill a wide frame). */
.cm-gal .gallery>:first-child{grid-column:1/-1!important}
.cm-gal .gallery>:first-child img{aspect-ratio:auto!important;width:100%!important;height:480px;object-fit:cover!important}
/* O-2: one shape per row (team_00: a portrait in a landscape row breaks it). */
.cm-gal .gallery .cm-por img{aspect-ratio:3/4!important;width:100%;height:auto;object-fit:cover}
/* O-4 logo variant: the logo mark instead of the number. */
.cm-pl-logo .point-cards__card::before{content:""!important;background:url(/wp-content/themes/ea-eyalamit/assets/images/ea-logo-mark.png) center/contain no-repeat transparent!important;border-radius:0!important;width:26px!important;height:26px!important;top:6px!important;inset-inline-start:5px!important}
/* O-4 (team_00: «זה נקודות — רשימה סדורה, בולטים»): the point cards become an ordered list in columns 2-5. */
.cm-pl .point-cards__grid{display:block!important;grid-column:2/6!important;counter-reset:pl;margin-block:8px!important}
.cm-pl .point-cards__card{counter-increment:pl;position:relative;border:0!important;background:transparent!important;box-shadow:none!important;
  padding:0 0 14px!important;padding-inline-start:52px!important;margin:0 0 14px!important;border-bottom:1px solid #e6dccf!important}
.cm-pl .point-cards__card::before{content:counter(pl);position:absolute;inset-inline-start:0;top:0;width:36px;height:36px;border-radius:50%;
  background:#9A4F2B;color:#fff;display:flex;align-items:center;justify-content:center;font:600 var(--fs-sm)/1 Heebo,sans-serif}
.cm-pl .point-cards__card h3{margin:4px 0 4px;font-size:var(--fs-h3)}
.cm-pl .point-cards__card p{margin:0}
/* O-5/6/7 (team_00: «יחס חשיבות הפוך — הטקסט גדול, והתמונות הן רקע… כל בולט מקבל תמונה»; the original part reveals.php
   put the title on the image). Each item: its image fills the cell, the text sits large on it. */
.cm-bul .whom{grid-template-rows:none!important;grid-auto-rows:260px!important}
.cm-bul.cm-g4-2112 .whom{grid-auto-rows:200px!important}
.cm-bul.cm-g4-3111 .whom{grid-auto-rows:380px!important}
.cm-bul .whom__i{position:relative!important;display:block!important;border-radius:6px;overflow:hidden;grid-template-rows:none!important}
.cm-bul.cm-g4-3111 .whom__i{grid-row:auto!important}
.cm-bul .whom__m{position:absolute!important;inset:0;height:100%!important;margin:0!important;border-radius:0;box-shadow:none}
.cm-bul .whom__i::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(29,20,13,0) 30%,rgba(29,20,13,.82))}
.cm-bul .whom__p{position:absolute;inset-inline:0;bottom:0;z-index:1;margin:0;padding:18px;color:#fff!important;
  font-family:Heebo,sans-serif;font-size:var(--fs-h3)!important;font-weight:500;line-height:1.4;text-align:start!important;text-align-last:auto!important}
/* Card frame (team_00: «מסגרת דקה, שיושבת בדיוק על הגריד, ואז התוכן מרווח מעט פנימה»). */
.cm-frame :is(.point-cards__card,.bookcard,.ea-now__card,.ea-blog-card,.tmq,.ea-testi-cards__card){
  border:1px solid #cdbba6!important;border-radius:4px!important;box-shadow:none!important;background:transparent!important;
  padding:14px!important;box-sizing:border-box;transform:none!important}
.cm-frame :is(.bookcard,.ea-now__card,.ea-blog-card) img{border-radius:2px}
/* Testimonials: whole cards on the grid, never cut; a small round avatar with name and date on top. */
.cm-tq .testi-mq{display:block;position:relative}
/* team_00: «הכפתורים לא יפים ומפריעים בצדדים — במקום זה נקודות בשורה למטה, וחצים עדינים בלי מסגרת לשני הצדדים, במרכז, מעל». */
.cm-tq .wrap>.h2{text-align:start}
.cm-tq__nav{grid-column:1/-1;display:flex;justify-content:center;gap:28px;margin:32px 0 -2px}
.cm-tq .testi-mq{margin-top:0!important}
.cm-tq__nav .testi-mq__btn{position:static!important;transform:none!important;border:0!important;background:none!important;box-shadow:none!important;
  width:auto!important;height:auto!important;padding:4px 8px!important;color:#9A4F2B;font-size:1.6rem;line-height:1;cursor:pointer;opacity:.75}
.cm-tq__nav .testi-mq__btn:hover{opacity:1}
.cm-tq__dots{grid-column:1/-1;display:flex;justify-content:center;gap:8px;margin-top:16px}
.cm-tq__dots i{width:7px;height:7px;border-radius:50%;background:#cdbba6}
.cm-tq__dots i.on{background:#9A4F2B}
.cm-tq .testi-mq__viewport{container-type:inline-size;overflow:hidden;direction:rtl}
.cm-tq .testi-mq__track{display:grid!important;grid-auto-flow:column;grid-auto-columns:calc((100cqw - 2 * var(--cm-gap)) / 3);
  gap:var(--cm-gap)!important;width:auto!important;transform:none!important;direction:rtl}
.cm-tq .tmq{display:grid!important;grid-template-columns:40px 1fr;grid-template-areas:"av n" "q q";column-gap:10px;row-gap:12px;align-content:start;flex:none!important;width:auto!important}
.cm-tq .tmq__avatar{grid-area:av;width:40px!important;height:40px;aspect-ratio:1!important;border-radius:50%!important}
.cm-tq .tmq__avatar svg{width:20px;height:20px}
.cm-tq .tmq{grid-template-areas:"av n" "q q" "m m"!important;grid-template-rows:auto 1fr auto;align-content:stretch!important}
.cm-tq .tmq__n{grid-area:n;margin:0!important;align-self:center;text-align:start!important;letter-spacing:.2px;font-size:var(--fs-sm)!important;font-weight:600!important;color:#2f2013!important}
.cm-tq .tmq__n a{color:#2f2013!important}
.cm-tq__more{grid-area:m;justify-self:end;font:500 var(--fs-2xs)/1.4 Heebo,sans-serif;color:#9A4F2B;text-decoration:none;border-bottom:1px solid currentColor}
.cm-tq .tmq__n::before{display:none}
.cm-tq .tmq__n::after{content:"· תאריך";margin-inline-start:6px;opacity:.7}
.cm-tq .tmq__q{grid-area:q;margin:0}
/* Approved (T-20 quote, team_00: «פחות padding, מסגרת, רקע או משהו עדין אחר שיפריד»): three quiet separators. */
.cm-q .ea-testi-cards__card{padding:12px 16px!important;border:0!important;background:transparent!important;border-radius:4px}
.cm-q-frame .ea-testi-cards__card{border:1px solid #cdbba6!important}
.cm-q-bg .ea-testi-cards__card{background:#f3ece2!important}
.cm-q-line .ea-testi-cards__card{border-inline-start:2px solid #9A4F2B!important;border-radius:0;padding-block:4px!important}
/* Approved (T-28, team_00: «לכל רשומה כותרת שלנו, תאריך, ואז הפוסט בתוך מסגרת — קצת יותר עדין ומיוחד, לא סתם על הדף»). */
/* team_00: «2 בשורה שיהיה בגריד. כל עמודה רצה בלי סינכרון לשנייה — הבא מתחיל איפה שהקודם נגמר, ולא טבלה». */
.cm-g6.cm-fb .fbgrid{display:block!important;columns:2;column-gap:var(--cm-gap)}
.cm-fb .fbgrid__item{break-inside:avoid;margin:0 0 var(--cm-gap)!important;width:100%!important;border:1px solid #cdbba6;border-radius:4px;background:#fbf6ee;padding:16px;box-sizing:border-box;display:flex;flex-direction:column;gap:12px}
.cm-fb__h{display:flex;flex-direction:column;gap:2px;text-align:start}
.cm-fb__d{font:500 var(--fs-2xs)/1.4 Heebo,sans-serif;letter-spacing:.4px;color:#9A4F2B}
.cm-fb__t{margin:0;font-size:var(--fs-h3);font-weight:500;color:#2f2013}
.cm-fb .fbgrid__frame{margin-inline:auto;background:#fff;border:1px solid #e6dccf!important;border-radius:4px;max-width:100%}
/* Approved (T-31 contact, team_00: «לסדר חכם יותר, שייכנס במסך אחד ויעמוד בבקשות של אייל, וגם בגריד»): one row on the six
   columns — the form in 1-4 with its fields paired, a side column in 5-6 with the portrait, WhatsApp and the details. */
.cm-ct .ea-contact-form-row{max-width:none!important;display:grid!important;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:var(--cm-gap);align-items:stretch}
/* team_00: «בלוק חום מימין — ליישר למטה לעמודה שמאל — שיסתיים למטה בקו ישר». */
.cm-ct .ea-contact-form-row>.ea-entrance{display:flex;flex-direction:column}
.cm-ct .ea-contact-form-row>.ea-entrance>.ea-contact-cta{margin-top:auto!important}
.cm-ct .cm-ct__side .ea-contact-nap{flex:1 1 auto}
.cm-ct .ea-contact-form-row>.ea-entrance{grid-column:1/5;padding-inline-end:clamp(16px,3vw,40px)}
.cm-ct .cm-ct__side{grid-column:5/7;display:flex;flex-direction:column;gap:14px}
.cm-ct .cm-ct__side .ea-contact-portrait{display:block;width:100%;margin:0}
.cm-ct .cm-ct__side .ea-contact-portrait img{width:100%;aspect-ratio:3/2;object-fit:cover;border-radius:4px;display:block}
.cm-ct :is(.ea-contact-cta,.ea-contact-nap){border:1px solid #cdbba6;border-radius:4px;padding:14px;text-align:start;background:transparent;color:#2f2013;max-width:none;margin:0}
.cm-ct :is(.ea-contact-cta .ea-contact-section__heading,.ea-contact-nap__h){font-size:var(--fs-h3)!important;margin:0 0 6px;color:#2f2013}
.cm-ct :is(.ea-contact-cta .ea-contact-section__body,.ea-contact-nap__row,.ea-contact-points li){font-size:var(--fs-sm)!important;margin:0 0 4px;color:#67482d}
.cm-ct .ea-contact-cta{margin:18px 0 0!important;width:auto!important;max-width:none!important;box-sizing:border-box;display:grid;grid-template-columns:1fr auto;column-gap:16px;align-items:center}
.cm-ct .ea-contact-cta>*{grid-column:1}
.cm-ct .ea-contact-cta .ea-cta-ab{grid-column:2;grid-row:1/span 2;margin:0}
.cm-ct .ea-contact-points{grid-column:1/-1;display:flex!important;flex-direction:row!important;flex-wrap:wrap;gap:4px 18px!important;margin:10px 0 0!important;padding:0!important;list-style:none}
.cm-ct .ea-contact-points li{margin:0!important}
.cm-ct .ea-cta-pill{padding:var(--cm-btn-pad-block) var(--cm-btn-pad-inline)!important;white-space:nowrap}
.cm-ct .ea-cf7{display:grid;grid-template-columns:1fr 1fr;column-gap:var(--cm-gap);row-gap:10px}
.cm-ct .ea-cf7>*{grid-column:1/-1;margin:0!important}
.cm-ct .ea-cf7>.ea-cf7-row:has(input[type=text],input[type=tel],input[type=email],select){grid-column:auto}
.cm-ct .ea-cf7 textarea{min-height:96px;height:96px}
.cm-ct :is(.ea-contact-form,.ea-contact-form--cf7,.wpcf7,.wpcf7-form){max-width:none!important;width:auto!important}
.cm-ct .ea-cf7-submit{display:flex;justify-content:flex-end}
.cm-ct.sec{padding-block:clamp(40px,4vw,56px)!important}
/* Eyal (2026-09-17): the page is built from visually separated parts, the WhatsApp part dark; the trust points read as
   headlines; placeholder-only fields; submit on the left. Kept — as zones on one grid row, in canonical tones. */
.cm-ct .ea-contact-cta{background:#2A1A0C!important;border:0!important}
.cm-ct .ea-contact-cta .ea-contact-section__heading{color:#FFE8C2!important}
.cm-ct .ea-contact-cta .ea-contact-section__body{color:#EBEBEA!important}
.cm-ct .ea-contact-cta .ea-cta-pill{background:#D08A5E!important;color:#1d140d!important;border-color:#D08A5E!important}
.cm-ct .ea-contact-points li{text-align:start!important;text-align-last:auto!important;color:#fff!important;font-size:var(--fs-body)!important;font-weight:var(--fw-medium)}
/* Approved (D49, D55): reading blocks in columns 2-5 — accordion, TOC, year lists, press, template bodies. */
section.cm-25 .wrap,.cm-25>.wrap,.cm-25 .wrap.center{display:grid!important;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:var(--cm-gap);text-align:start}
.cm-25 .wrap>*{grid-column:2/6!important;max-width:none!important;margin-inline:0!important}
.cm-25 .wrap>:is(.h2,.chap,h2){grid-column:1/-1!important;text-align:start!important}
/* The FAQ list and the press list have their own inner box instead of .wrap: the same six columns on 1104. */
.cm-25:is(.ea-faq-list,.ea-press){max-width:none!important;margin:0!important;background:#fffffa;padding-block:clamp(40px,5vw,72px)}
.cm-25 :is(.ea-faq-list__inner,.ea-section__inner){display:grid!important;grid-template-columns:repeat(6,minmax(0,1fr));column-gap:var(--cm-gap);
  width:min(1104px,calc(100% - 96px))!important;max-width:none!important;margin-inline:auto!important;padding-inline:0!important;text-align:start}
.cm-25 :is(.ea-faq-list__inner,.ea-section__inner)>*{grid-column:2/6!important;max-width:none!important;margin-inline:0!important}
.cm-25 :is(.ea-faq-list__inner,.ea-section__inner)>:is(.h2,.chap,h2){grid-column:1/-1!important;text-align:start!important}
/* The TOC's floating rail, button and sheet are page chrome, not the block — hidden in the map example. */
.cm-spec .ea-toc :is(.rail,.toc-fab,dialog){display:none!important}
/* Year numbers on ivory in the approved link colour (the live #B5663D measures 4.24 — fails). */
.cm-25 .tl__y{color:#9A4F2B!important}
/* Text on image: a deeper scrim so every line passes over any photo. */
.cm-bul .whom__i::after{background:linear-gradient(180deg,rgba(29,20,13,.05) 20%,rgba(29,20,13,.9) 75%)!important}
/* Validation fixes (D63). */
header.phero[class*="cm-h-"] .phero__s{max-width:none!important}
header.phero.cm-h-s .chap{display:none}
.cm-g6.start .start__in{max-width:none!important;width:min(1104px,calc(100% - 96px))!important;padding-inline:0!important;box-sizing:border-box}
/* Q-3 B: the CTA band on the content width 1104, the site grid. */
section.cta-band.cm-cta-p .cta-band__in{max-width:1104px!important;width:min(1104px,calc(100% - 96px))!important;padding-inline:0!important;margin-inline:auto!important;box-sizing:border-box}
/* Q-2b B: the CTA paragraph is running text — justified. Q-2a A: text on images is display text — start. */
section.cta-band.cm-cta-p .cta-band__p{text-align:justify;text-align-last:start}
/* Approved (team_00): the hero button has two positions — bottom (default) or top, its top level with the title's top. */
header.phero.cm-btn-top[class*="cm-h-"] .phero__cta{align-self:start}
header.phero.cm-btn-top[class*="cm-h-"] .phero__in:has(>.chap) .phero__cta{grid-row:2/span 3}
/* Approved (team_00): hero text cols 1-4; the button spans columns 5-6 on one line (team_00 corrected from one cell), bottom-aligned. */
header.phero[class*="cm-h-"] .phero__in{display:grid;grid-template-columns:repeat(6,1fr);column-gap:var(--cm-gap);align-items:end}
header.phero[class*="cm-h-"] .phero__in>:not(.phero__cta){grid-column:1/5}
header.phero[class*="cm-h-"] .phero__cta{grid-column:5/7;grid-row:1/span 4;align-self:end;justify-content:flex-start;margin-top:0}
header.phero[class*="cm-h-"] .phero__cta .btn{width:100%;box-sizing:border-box;padding-inline:12px;white-space:nowrap;text-align:center;justify-content:center}
.cm-dummy__badge{position:absolute;top:10px;inset-inline-end:10px;z-index:30;background:#c98a2b;color:#1d140d;font:600 .8rem Heebo,sans-serif;padding:4px 10px;border-radius:3px}
.cm-vid{display:block;position:relative;width:100%;aspect-ratio:16/9;overflow:hidden;background:#1d140d}
.hero .cm-vid,.mokesh-hero__yt .cm-vid{height:100%;aspect-ratio:auto}
.phero .cm-vid.phero__media{position:absolute;inset:0;height:100%;aspect-ratio:auto}
/* The home hero's video fills the whole banner (theme: .hero__media absolute) — the placeholder must too, or the
   hero's flex row puts it beside the text and squeezes the text into a column (team_00 caught it). */
.hero .cm-vid.hero__media{position:absolute;inset:0;width:100%;height:100%;aspect-ratio:auto;z-index:0}
.hero .cm-vid__yt{display:none}.hero .cm-vid__lbl{bottom:auto;top:20px;inset-inline-start:60px}
.cm-vid__bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.cm-vid::after{content:"";position:absolute;inset:0;z-index:0;background:linear-gradient(180deg,rgba(29,20,13,.35),rgba(154,79,43,.6))}
.cm-vid__ic,.cm-vid__yt,.cm-vid__lbl{position:absolute;z-index:1}
.cm-vid__yt{top:50%;left:50%;transform:translate(-50%,-50%);width:76px}
.cm-vid__ic{top:14px;inset-inline-start:16px;width:32px;color:#f3ece2}
.cm-vid__lbl{bottom:14px;inset-inline-start:16px;color:#f3ece2;font:500 .9rem Heebo,sans-serif}
@media(max-width:760px){
 .cm-thead{display:none}
 .cm-cols{grid-template-columns:1fr}.cm-uses{columns:1}
 /* Narrow screens (team_00): the hero and CTA button always sits on the left. */
 header.phero[class*="cm-h-"] .phero__in{display:block}
 section.sec.cm-pr-c>.wrap{display:block}
 section.cm-sp .split2{grid-template-columns:minmax(0,1fr);row-gap:36px}
 section.cm-sp .cm-sp-after{display:block}
 .cm-g6 .wrap{display:block}
 .cm-g6 :is(.gallery,.point-cards__grid,.whom,.cmp,.steps3,.bookcards,.ea-now,.ea-blog-grid,.testi-grid,.ea-testi-cards__list,.fbgrid){grid-template-columns:minmax(0,1fr)!important}
 .cm-g6 :is(.gallery,.whom)>:nth-child(n),.cm-g6[class*="cm-g4"] :is(.whom,.ea-now)>:nth-child(n){grid-column:span 1!important}
 .cm-g6 .gallery{grid-template-columns:repeat(2,minmax(0,1fr))!important}
 .cm-g6 :is(.point-cards__grid,.cmp,.steps3,.bookcards,.ea-now,.ea-blog-grid,.testi-grid,.ea-testi-cards__list,.fbgrid)>*{grid-column:1!important}
 .cm-tq .testi-mq__track{grid-auto-columns:100cqw}
 .cm-tq__nav{display:none}
 .cm-g6.cm-fb .fbgrid{columns:1}
 .cm-g6[class*="cm-g4-"] .whom{grid-template-rows:none!important;grid-auto-rows:auto!important}
 .cm-g6.cm-g4-3111 .ea-now{grid-auto-rows:auto}.cm-g6.cm-g4-3111 .ea-now__ph{aspect-ratio:3/2!important}
 .cm-g6[class*="cm-g4-"] .whom>.whom__i:nth-child(n){grid-column:1/-1!important;grid-row:auto!important;display:flex!important}
 .cm-g6[class*="cm-g4-"] .whom__m{flex:none;aspect-ratio:4/3!important;height:auto!important}
 .cm-pl .point-cards__card{padding-inline-start:46px!important}
 .cm-bul .whom{grid-auto-rows:220px!important}
 .cm-gal .gallery>:first-child img{height:240px}
 .cm-bul .whom>.whom__i{min-height:220px}
 .cm-gal .gallery>:first-child{grid-column:1/-1!important}

 .cm-25 .wrap>*,.cm-25 :is(.ea-faq-list__inner,.ea-section__inner)>*{grid-column:1/-1!important}
 .cm-25 :is(.ea-faq-list__inner,.ea-section__inner){width:auto!important;padding-inline:16px!important}
 .cm-g6.start .start__in{width:auto!important;padding-inline:16px!important}
 .cm-k42 .gallery{grid-template-rows:none}.cm-k42 .gallery>:nth-child(n){grid-column:span 1!important;grid-row:auto}.cm-k42 .gallery .gfig{height:220px}
 .cm-k42 .gallery>.gfig:is(:nth-child(1),:nth-child(4)){grid-column:1/-1!important}.cm-k42 .gallery>.gfig:is(:nth-child(1),:nth-child(4)){height:300px}
 .cm-k53 .point-cards__grid>:nth-child(n){grid-column:1!important;grid-row:auto}
 .cm-ct .ea-contact-form-row{display:block!important}
 .cm-ct .cm-ct__side{margin-top:24px}
 .cm-ct .ea-cf7{grid-template-columns:1fr}
 .cm-ct .ea-contact-form-row>.ea-entrance{padding-inline-end:0;display:block}
 .cm-ct .ea-contact-form-row>.ea-entrance>.ea-contact-cta{margin-top:18px!important}
 .cm-ct .ea-contact-cta{grid-template-columns:1fr}
 .cm-ct .ea-contact-cta .ea-cta-ab{grid-column:1;grid-row:auto;margin-top:10px;display:flex;justify-content:flex-end}
 section.cm-sp .split2>*,section.cm-sp .split2.split2--rev>*,section.cm-sp .split2:has(>.figr--p)>*,section.cm-sp .split2.split2--rev:has(>.figr--p)>*{grid-column:1!important;grid-row:auto!important;padding-inline:0!important}
 section.cta-band.cm-cta-p .cta-band__in{grid-template-columns:minmax(0,1fr)}
 section.cta-band.cm-cta-p .cta-band__txt,section.cta-band.cm-cta-p .cta-band__act{grid-column:1}
 section.cta-band.cm-cta-p .cta-band__act{grid-row:2;justify-content:flex-end}
 section.cta-band.cm-cta-p .cta-band__logo.cta-band__logo--side{width:min(80%,320px)}
 header.phero[class*="cm-h-"] .phero__cta{margin-top:28px;justify-content:flex-end}
 header.phero[class*="cm-h-"] .phero__cta .btn,section.cta-band.cm-cta-p .cta-band__act .btn{width:auto;padding-inline:36px}
 .cm-sum{grid-template-columns:1fr 112px;grid-template-areas:"id thumb" "name thumb" "desc thumb" "use use";gap:4px 12px;padding:12px 16px}
 .c-id{grid-area:id}.c-name{grid-area:name}.c-desc{grid-area:desc;font-size:.82rem}.c-use{grid-area:use}.c-thumb{grid-area:thumb}
 .cm-mini{width:112px;height:80px}.cm-mini__in{transform:scale(.0875)}
 .cm-row[open]>.cm-sum{position:static}
 .cm-type,.cm-group,.cm-top,.cm-variant{padding-inline:16px}
}
"""

# The map and its temporary sketch pages share one top bar: the group tabs plus these page links.
# Buttons, not <a>: the page's <base> would send a relative link to the staging host.
PROOF_PAGES = [("ea-canon-map.html", "המפה"), ("open.html", "הצעות פתוחות"), ("grids.html", "חלוקות"), ("decisions.html", "החלטות"), ("grid-proof.html", "מה אושר — רשת"), ("palette-check.html", "בדיקת גוונים")]
PAGES_NAV = ('<span class="cm-pgs">' + "".join(
    f'<button type="button" class="cm-pg{" is-on" if i == 0 else ""}" data-href="{h}">{n}</button>'
    for i, (h, n) in enumerate(PROOF_PAGES)) + '</span>')
PG_JS = """
document.querySelectorAll('.cm-pg,.cm-tab[data-href]').forEach(function(b){b.addEventListener('click',function(){
  location.href=location.href.split('#')[0].replace(/[^\\/]*$/,'')+b.dataset.href;});});
"""
CM_JS = PG_JS + """
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
<p>נלכד {today} · גרסת תמה {ver} · מעוצב בגיליונות הסגנון האמיתיים של האתר. הרקעים בכל הדוגמאות יושרו לגוון הקאנוני הקרוב, ו«ממתין לתוכן» מוצג במראה האחיד — במפה בלבד, לא באתר.</p>
</header>
<nav class="cm-tabs" aria-label="קבוצות">{"".join(tabs)}{PAGES_NAV}</nav>
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
