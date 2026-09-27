"""Shared top bar for the temporary sketch pages: the map's own group tabs and page links, re-pointed.

Keeps the map's sticky nav on every sketch page (team_00: the top bar is what makes the map usable).
A group tab opens that group in the map; the page links switch between the map and the sketch pages.
"""


def keep_nav(s, page):
    s.select_one("header.cm-top").decompose()  # the sketch page's own heading replaces the map's
    from canon_types import GROUPS  # the map's current groups, not the capture source's old ones
    nav = s.select_one("nav.cm-tabs")
    for t in nav.select(".cm-tab"):
        t.decompose()
    for gi, (gname, _) in reversed(list(enumerate(GROUPS, 1))):
        b = s.new_tag("button", attrs={"type": "button", "class": "cm-tab", "data-href": f"ea-canon-map.html#g{gi}"})
        b.string = gname
        nav.insert(0, b)
    for b in s.select(".cm-pg"):
        b["class"] = ["cm-pg"] + (["is-on"] if b["data-href"] == page else [])
    js = s.find("script").string
    for x in s.select("script"):
        x.decompose()
    tag = s.new_tag("script")
    tag.string = js.split("(function(){")[0]  # page-link handler only, not the map's tab panels
    s.body.append(tag)
