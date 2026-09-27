"""Shared top bar for the temporary sketch pages: the map's own group tabs and page links, re-pointed.

Keeps the map's sticky nav on every sketch page (team_00: the top bar is what makes the map usable).
A group tab opens that group in the map; the page links switch between the map and the sketch pages.
"""


def keep_nav(s, page):
    s.select_one("header.cm-top").decompose()  # the sketch page's own heading replaces the map's
    for t in s.select(".cm-tab"):
        t["data-href"] = "ea-canon-map.html#" + t["data-g"]
        t["class"] = [c for c in t.get("class", []) if c != "is-on"]
    for b in s.select(".cm-pg"):
        b["class"] = ["cm-pg"] + (["is-on"] if b["data-href"] == page else [])
    js = s.find("script").string
    for x in s.select("script"):
        x.decompose()
    tag = s.new_tag("script")
    tag.string = js.split("(function(){")[0]  # page-link handler only, not the map's tab panels
    s.body.append(tag)
