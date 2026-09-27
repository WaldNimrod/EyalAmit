"""Where each canon type is used on the live site — a census, not a sample.

Enumerates every published page and post from the REST API, fetches each once
(sequentially, without following redirects), and records which types appear.
Writes uses.json next to this file: {"T-01": ["/method/", ...], ...}.
"""
import json, os, re, sys, time, urllib.parse, urllib.request
from bs4 import BeautifulSoup

STAGE = "http://eyalamit-co-il-2026.s887.upress.link"
HERE = os.path.dirname(os.path.abspath(__file__))


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, *a, **k):
        return None


OPENER = urllib.request.build_opener(NoRedirect)


def get(url, tries=3):
    for i in range(tries):
        try:
            with OPENER.open(urllib.request.Request(url, headers={"User-Agent": "canon-census/1"}), timeout=25) as r:
                return r.status, r.read()
        except urllib.error.HTTPError as e:
            if e.code in (301, 302, 307, 308, 400, 404):
                return e.code, b""
            if e.code == 502 and i < tries - 1:
                time.sleep(3)
                continue
            raise
        except Exception:
            if i == tries - 1:
                raise
            time.sleep(3)


def population():
    urls = []
    for kind in ("pages", "posts"):
        page = 1
        while True:
            st, body = get(f"{STAGE}/wp-json/wp/v2/{kind}?per_page=100&page={page}&_fields=link,status")
            if st != 200:
                break
            items = json.loads(body)
            urls += [i["link"] for i in items if i.get("status") == "publish"]
            if len(items) < 100:
                break
            page += 1
    return urls


def in_main(s, css):
    m = s.find("main")
    return m.select(css) if m else []


DETECT = {
    # One hero type since 2026-09-27: the inner hero, the home video hero and the memorial hero.
    "T-01": lambda s: bool(in_main(s, "header.phero, header.hero")),
    "T-04": lambda s: (not s.select_one("body.ea-qr")) and any(
        not e.find_parent(class_=["split2", "point-cards", "prose-fold"]) for e in in_main(s, "section.sec .intro-body")),
    "T-05": lambda s: bool(in_main(s, ".prose-fold")),
    "T-06": lambda s: bool(in_main(s, ".split2")),
    "T-07": lambda s: bool(in_main(s, ".pfloat")),
    "T-08": lambda s: bool(in_main(s, "section.cta-band")),
    "T-09": lambda s: bool(in_main(s, ".point-cards")),
    "T-10": lambda s: bool(in_main(s, "section.photo-band")),
    "T-11": lambda s: bool(in_main(s, ".gallery")),
    "T-12": lambda s: bool(in_main(s, "section.bleed")),
    "T-13": lambda s: bool(in_main(s, ".whom")),
    "T-14": lambda s: bool(in_main(s, ".cmp")),
    "T-15": lambda s: bool(in_main(s, "section.start")),
    "T-16": lambda s: bool(in_main(s, ".collage")),
    "T-17": lambda s: bool(in_main(s, ".studio")),
    "T-18": lambda s: bool(in_main(s, ".testi-mq")),
    "T-19": lambda s: bool(in_main(s, ".testi-grid")),
    "T-20": lambda s: bool(in_main(s, "section.ea-testi-cards")),
    "T-21": lambda s: bool(in_main(s, "section.ea-faq-list, section.ea-faq-mini-section")),
    "T-22": lambda s: bool(in_main(s, "div.dd")),
    "T-23": lambda s: bool(in_main(s, "div.ea-toc")),
    "T-24": lambda s: bool(in_main(s, ".bookcards")),
    "T-25": lambda s: bool(in_main(s, ".ea-now")),
    "T-26": lambda s: any(not v.select_one(".ea-pending-approval") for v in in_main(s, ".videoblk")),
    "T-27": lambda s: any(v.select_one(".ea-pending-approval") for v in in_main(s, ".videoblk")),
    "T-28": lambda s: bool(in_main(s, ".fbgrid")),
    "T-29": lambda s: bool(in_main(s, "ol.tl")),
    "T-30": lambda s: bool(in_main(s, ".ea-photo-slot")),
    "T-31": lambda s: bool(in_main(s, "section.ea-wave2-contact")),
    "T-32": lambda s: bool(in_main(s, "section.ea-press")),
    "T-33": lambda s: bool(s.select_one("body.ea-qr")),
    "T-34": lambda s: bool(s.select_one("body.single-post")) and bool(in_main(s, ".ea-post-content")),
    "T-35": lambda s: bool(in_main(s, "article.ea-blog-card")),
    # A YouTube iframe pasted into a post's free text is post content, not this type.
    "T-36": lambda s: not s.select_one("body.single-post, body.ea-qr") and any(
        not f.find_parent(class_=["fbgrid", "phero", "videoblk", "ea-post-content"]) and re.search(r"youtu", f.get("src", ""))
        for f in in_main(s, "section.sec iframe")),
    "T-37": lambda s: False,
}


def main():
    urls = population()
    uses = {k: [] for k in DETECT}
    live, redirects, theme = 0, 0, None
    for n, u in enumerate(urls, 1):
        st, body = get(u)
        if st != 200:
            redirects += 1
            continue
        live += 1
        theme = theme or re.search(rb"ver=(1\.5\.\d+)", body)
        s = BeautifulSoup(body, "lxml")
        path = urllib.parse.unquote(urllib.parse.urlparse(u).path)
        for k, f in DETECT.items():
            if f(s):
                uses[k].append(path)
        if n % 25 == 0:
            print(f"  {n}/{len(urls)}", file=sys.stderr)
        time.sleep(0.3)
    out = {"_meta": {"objects": len(urls), "live": live, "not_200": redirects,
                     "theme": theme.group(1).decode() if theme else None,
                     "date": time.strftime("%Y-%m-%d")}, **uses}
    json.dump(out, open(os.path.join(HERE, "uses.json"), "w", encoding="utf-8"), ensure_ascii=False, indent=1)
    print(json.dumps(out["_meta"]), {k: len(v) for k, v in uses.items()})


if __name__ == "__main__":
    main()
