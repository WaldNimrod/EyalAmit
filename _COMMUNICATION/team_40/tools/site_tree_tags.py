#!/usr/bin/env python3
"""
מיפוי heuristi מ־site_hooks / נושאים בעברית / נתיב לגסי לצמתי עץ האתר (site-tree.json).
"""
from __future__ import annotations

import json
from dataclasses import dataclass
from html import escape
from pathlib import Path
from typing import Any, Optional


# site_hook (מ־semantic_enrich_clip) → רשימת node_id (מוגבל כדי לא להציף)
HOOK_TO_NODES: dict[str, list[str]] = {
    "muzeh": ["st-books"],
    "books": ["st-books"],
    "didgeridoo": ["st-svc-treatment", "st-svc-lessons", "st-didg-gear-hub"],
    "services": ["st-svc-treatment", "st-svc-lessons"],
    "therapy": ["st-svc-treatment"],
    "wellness": ["st-svc-treatment"],
    "workshops": ["st-svc-workshops"],
    "craft": ["st-svc-workshops", "st-svc-handmade"],
    "courses": ["st-courses"],
    "lectures": ["st-svc-lectures"],
    "events": ["st-svc-lectures", "st-blog"],
    "music": ["st-svc-lectures", "st-blog"],
    "studio": ["st-learning-hub"],
    "about": ["st-eyal-hub"],
    "bio": ["st-eyal-hub"],
    "personal": ["st-eyal-hub"],
    "press": ["st-eyal-hub"],
    "testimonials": ["st-media"],
    "travel": ["st-home", "st-blog"],
    "atmosphere": ["st-home", "st-blog"],
    "culture": ["st-galleries-catalog"],
    "product": ["st-svc-handmade"],
    "detail": ["st-svc-handmade"],
    "legal": ["st-privacy"],
    "legacy": [],
    "ui": [],
}


def _topics_blob(entry: dict[str, Any]) -> str:
    sem = entry.get("semantic_content") or {}
    parts = list(sem.get("topics_he_union") or [])
    return " ".join(parts)


def _legacy_lower(entry: dict[str, Any]) -> str:
    return (entry.get("legacy_relative") or "").lower()


def refine_wellness_nodes(entry: dict[str, Any]) -> list[tuple[str, str]]:
    """יוגה / מדיטציה → סאונד הילינג בנוסף לטיפול."""
    blob = _topics_blob(entry)
    out: list[tuple[str, str]] = []
    if any(k in blob for k in ("יוגה", "מדיטציה")):
        out.append(("st-svc-sound", "topic:יוגה/מדיטציה"))
    return out


def refine_book_nodes(entry: dict[str, Any]) -> list[tuple[str, str]]:
    """החלפת/הוספת דפי ספר ספציפיים לפי טקסט או נתיב."""
    blob = _topics_blob(entry)
    leg = _legacy_lower(entry)
    out: list[tuple[str, str]] = []
    if any(x in blob for x in ("כושי", "בלאנטיס")) or "kushi" in leg or "blantis" in leg:
        out.append(("st-book-kushi", "topic:כושי"))
    if "צבע" in blob and "כחול" in blob:
        out.append(("st-book-tsva", "topic:צבע+כחול"))
    if "וכתבת" in blob or "vekatavt" in leg:
        out.append(("st-book-vekatavt", "topic:וכתבת"))
    return out


@dataclass
class SiteTreeContext:
    nodes_by_id: dict[str, dict[str, Any]]
    _path_cache: dict[str, str]

    @classmethod
    def load(cls, site_tree_path: Path) -> SiteTreeContext:
        data = json.loads(site_tree_path.read_text(encoding="utf-8"))
        nodes = {n["id"]: n for n in data.get("nodes", []) if n.get("id")}
        return cls(nodes_by_id=nodes, _path_cache={})

    def path_he(self, node_id: str) -> str:
        if node_id in self._path_cache:
            return self._path_cache[node_id]
        titles: list[str] = []
        cur: Optional[str] = node_id
        seen: set[str] = set()
        while cur and cur not in seen:
            seen.add(cur)
            n = self.nodes_by_id.get(cur)
            if not n:
                break
            titles.append(str(n.get("titleHe") or cur))
            pid = n.get("parentId")
            cur = pid if isinstance(pid, str) else None
        titles.reverse()
        s = " › ".join(titles) if titles else node_id
        self._path_cache[node_id] = s
        return s

    def tag_dict(self, node_id: str, source: str) -> Optional[dict[str, Any]]:
        n = self.nodes_by_id.get(node_id)
        if not n:
            return None
        return {
            "node_id": node_id,
            "title_he": str(n.get("titleHe") or node_id),
            "slug": str(n.get("slug") or ""),
            "path_he": self.path_he(node_id),
            "source": source,
        }


def collect_hook_nodes(hooks: list[str]) -> list[tuple[str, str]]:
    seen_hooks: set[str] = set()
    out: list[tuple[str, str]] = []
    for h in sorted(hooks):
        if h in seen_hooks:
            continue
        seen_hooks.add(h)
        for nid in HOOK_TO_NODES.get(h, []):
            out.append((nid, f"hook:{h}"))
    return out


def tags_for_entry(entry: dict[str, Any], ctx: SiteTreeContext) -> list[dict[str, Any]]:
    """מחזיר רשימת תגיות עץ ממוינת ויציבה (לפי path_he)."""
    sem = entry.get("semantic_content") or {}
    hooks = list(sem.get("site_hooks_union") or [])

    pairs: list[tuple[str, str]] = []
    pairs.extend(collect_hook_nodes(hooks))
    pairs.extend(refine_book_nodes(entry))
    pairs.extend(refine_wellness_nodes(entry))

    # דה-דופליקציה: node_id ראשון שמופיע נשמר
    by_id: dict[str, str] = {}
    for nid, src in pairs:
        if nid not in by_id:
            by_id[nid] = src

    tags: list[dict[str, Any]] = []
    for nid, src in by_id.items():
        d = ctx.tag_dict(nid, src)
        if d:
            tags.append(d)

    tags.sort(key=lambda x: (x.get("path_he") or "", x.get("node_id") or ""))
    return tags


def default_site_tree_path() -> Path:
    """מ־.../team_40/tools/thisfile.py → תיקיית מאגר EyalAmit.co.il-2026."""
    here = Path(__file__).resolve().parent
    hub_root = here.parent.parent.parent
    return hub_root / "hub" / "data" / "site-tree.json"


def build_filter_chip_list(entries: list[dict[str, Any]]) -> list[tuple[str, str]]:
    """(node_id, תווית לצ'יפ) ממוינים לפי path_he."""
    labels: dict[str, str] = {}
    for e in entries:
        for t in e.get("site_tree_tags") or []:
            nid = t.get("node_id")
            if not nid or nid in labels:
                continue
            labels[str(nid)] = str(t.get("path_he") or t.get("title_he") or nid)
    return sorted(labels.items(), key=lambda x: (x[1], x[0]))


def render_gallery_html(
    catalog_entries: list[dict[str, Any]],
    *,
    relevance_threshold: float,
    included_count: int,
) -> str:
    """גלריה עם סינון לפי node_id והעתקה ללוח בלחיצה."""
    chips = build_filter_chip_list(catalog_entries)
    rows: list[str] = []
    for e in catalog_entries:
        pid = e.get("public_id", "")
        fn = e.get("media_filename", "")
        st = e.get("short_title", pid)
        rs = e.get("relevance_score", 0)
        leg = e.get("legacy_relative", "") or ""
        tags = e.get("site_tree_tags") or []
        node_ids = [str(t.get("node_id")) for t in tags if t.get("node_id")]
        data_nodes_attr = escape(" ".join(node_ids), quote=True)
        tag_labels = " · ".join(
            escape(str(t.get("title_he") or t.get("node_id"))) for t in tags[:5]
        )
        if len(tags) > 5:
            tag_labels += " …"
        topics = ", ".join((e.get("semantic_content") or {}).get("topics_he_union", [])[:6])
        topics_esc = escape(topics)
        cap = (
            f'<span class="pid">{escape(str(pid))}</span> · {escape(str(st))}<br/>'
            f'<small>r={escape(str(rs))} · {topics_esc}</small>'
        )
        if tag_labels:
            cap += f'<br/><span class="tree-tags" title="שיוך לעץ האתר (היוריסטי)">{tag_labels}</span>'
        rows.append(
            f"""<figure class="card" tabindex="0" role="button" id="{escape(str(pid), quote=True)}"
  data-public-id="{escape(str(pid), quote=True)}"
  data-media-filename="{escape(str(fn), quote=True)}"
  data-legacy-rel="{escape(str(leg), quote=True)}"
  data-node-ids="{data_nodes_attr}">
  <img loading="lazy" src="./media/{escape(str(fn), quote=True)}" alt="{escape(str(st))}" width="320" />
  <figcaption>{cap}</figcaption>
</figure>"""
        )

    chip_html: list[str] = [
        '<button type="button" class="filter-chip" data-filter-id="" aria-pressed="true">הכל</button>'
    ]
    for nid, lab in chips:
        chip_html.append(
            f'<button type="button" class="filter-chip" data-filter-id="{escape(nid, quote=True)}" '
            f'aria-pressed="false">{escape(lab)}</button>'
        )

    return f"""<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>גלריית מדיה — קטלוג לגסי</title>
  <style>
    body {{ font-family: system-ui, sans-serif; margin: 1rem; background: #faf8f5; color: #222; }}
    h1 {{ font-size: 1.2rem; }}
    .filters {{ display: flex; flex-wrap: wrap; gap: 0.35rem; margin: 0.75rem 0 1rem; align-items: center; }}
    .filter-chip {{ font: inherit; padding: 0.25rem 0.6rem; border-radius: 999px; border: 1px solid #c9bfb2;
      background: #fff; cursor: pointer; }}
    .filter-chip[aria-pressed="true"] {{ background: #2c5c4e; color: #fff; border-color: #2c5c4e; }}
    .tree-tags {{ font-size: 0.78rem; color: #3d4f47; }}
    #toast {{ position: fixed; bottom: 1rem; left: 50%; transform: translateX(-50%); background: #222;
      color: #fff; padding: 0.4rem 0.9rem; border-radius: 6px; font-size: 0.9rem; opacity: 0; pointer-events: none;
      transition: opacity 0.2s; z-index: 99; }}
    #toast.show {{ opacity: 1; }}
    .grid {{ display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; }}
    .card {{ background: #fff; border: 1px solid #e0d8ce; border-radius: 6px; padding: 0.5rem; cursor: pointer; }}
    .card:focus {{ outline: 2px solid #2c5c4e; outline-offset: 2px; }}
    .card img {{ width: 100%; height: auto; display: block; border-radius: 4px; pointer-events: none; }}
    .pid {{ font-weight: bold; font-family: ui-monospace, monospace; }}
    figcaption {{ font-size: 0.85rem; margin-top: 0.35rem; }}
    small {{ color: #555; }}
  </style>
</head>
<body>
  <h1>מדיה מלגסי — {included_count} קבצים (רלוונטיות ≥ {relevance_threshold})</h1>
  <p>מזהה לכל תמונה בפורמט <code>EA-XXXXXX</code>. קובץ אינדקס: <code>catalog.json</code>.
    לחיצה על כרטיס מעתיקה ללוח: <code>מזהה | קובץ</code> ושורת legacy.</p>
  <div class="filters" role="toolbar" aria-label="סינון לפי עץ אתר">
    {"".join(chip_html)}
  </div>
  <div id="toast" role="status" aria-live="polite"></div>
  <div class="grid" id="gallery-grid">
{chr(10).join(rows)}
  </div>
  <script>
(function() {{
  var grid = document.getElementById("gallery-grid");
  var toast = document.getElementById("toast");
  var chips = document.querySelectorAll(".filter-chip");
  var activeFilter = "";

  function showToast(msg) {{
    toast.textContent = msg;
    toast.classList.add("show");
    clearTimeout(showToast._t);
    showToast._t = setTimeout(function() {{ toast.classList.remove("show"); }}, 1600);
  }}

  function applyFilter(id) {{
    activeFilter = id;
    var figs = grid.querySelectorAll("figure.card");
    figs.forEach(function(fig) {{
      var raw = fig.getAttribute("data-node-ids") || "";
      var ids = raw.split(/\\s+/).filter(Boolean);
      var show = !id || ids.indexOf(id) >= 0;
      fig.style.display = show ? "" : "none";
    }});
    chips.forEach(function(c) {{
      var cid = c.getAttribute("data-filter-id") || "";
      c.setAttribute("aria-pressed", cid === id ? "true" : "false");
    }});
  }}

  chips.forEach(function(c) {{
    c.addEventListener("click", function() {{
      applyFilter(c.getAttribute("data-filter-id") || "");
    }});
  }});

  grid.addEventListener("click", function(ev) {{
    var fig = ev.target.closest("figure.card");
    if (!fig || !grid.contains(fig)) return;
    var pid = fig.getAttribute("data-public-id") || "";
    var fn = fig.getAttribute("data-media-filename") || "";
    var leg = fig.getAttribute("data-legacy-rel") || "";
    var text = pid + " | " + fn + "\\nlegacy: " + leg;
    if (navigator.clipboard && navigator.clipboard.writeText) {{
      navigator.clipboard.writeText(text).then(function() {{
        showToast("הועתק ללוח");
      }}).catch(function() {{
        prompt("העתק:", text);
      }});
    }} else {{
      prompt("העתק:", text);
    }}
  }});
}})();
  </script>
</body>
</html>"""
