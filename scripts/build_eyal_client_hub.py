#!/usr/bin/env python3
"""Build static Eyal Amit 2026 client hub from hub/data (Client Hub Standard v1.1).

Usage (repo root):
    python3 scripts/build_eyal_client_hub.py
    python3 scripts/build_eyal_client_hub.py --out hub/dist
    python3 scripts/build_eyal_client_hub.py --mirror-docs
    python3 scripts/build_eyal_client_hub.py --mirror-docx   # alias for --mirror-docs

Output: hub/dist/ (index, roadmap, site-tree, content-intake, tasks, pending redirect, assets/)
"""

from __future__ import annotations

import argparse
import copy
import json
import shutil
import subprocess
import sys
from datetime import datetime, timezone
from html import escape
from pathlib import Path
from typing import Optional

HUB_ROOT = Path(__file__).resolve().parent.parent / "hub"
DATA_DIR = HUB_ROOT / "data"
SRC_DIR = HUB_ROOT / "src"
SSOT_DIR = HUB_ROOT / "ssot"
DEFAULT_DIST = HUB_ROOT / "dist"

WHATSAPP_URL = "https://wa.me/972547776770"
BRAND_TEXT = "Agents OS @ nimrod.bio"
EXPORT_TYPE = "eyal-feedback"
EXPORT_TYPE_SITE_TREE = "eyal-site-tree-feedback"
EXPORT_TYPE_CONTENT_INTAKE = "eyal-page-content-intake"
DEFAULT_RESPONDENT = "Eyal Amit"
PROJECT_META = "EyalAmit2026"


def load_json(path: Path) -> dict:
    if not path.exists():
        print(f"[ERROR] Missing data file: {path}")
        sys.exit(1)
    return json.loads(path.read_text(encoding="utf-8"))


def load_json_optional(path: Path) -> dict | None:
    if path.exists():
        return json.loads(path.read_text(encoding="utf-8"))
    return None


def updates_items_newest_first(updates: dict) -> list:
    """Sort by ISO date descending so index 'עדכונים אחרונים' is chronological even if JSON order drifts."""
    items = list(updates.get("items", []))
    items.sort(key=lambda x: x.get("date", ""), reverse=True)
    return items


STATUS_BADGE = {
    "completed": '<span class="badge badge-done">הושלם</span>',
    "in_progress": '<span class="badge badge-run">בביצוע</span>',
    "not_started": '<span class="badge badge-todo">לא התחיל</span>',
    "blocked": '<span class="badge badge-blocked">חסום</span>',
    "qa": '<span class="badge badge-qa">QA</span>',
    "pending": '<span class="badge badge-pending">ממתין</span>',
    "answered": '<span class="badge badge-done">הוגש</span>',
    "deferred": '<span class="badge badge-blocked">נדחה</span>',
}

PRIORITY_BADGE = {
    "גבוהה": '<span class="badge badge-high">גבוהה</span>',
    "בינונית": '<span class="badge badge-medium">בינונית</span>',
    "נמוכה": '<span class="badge badge-low">נמוכה</span>',
}

# Browser hint; שרת — ראו hub/src/hub-no-cache.htaccess → dist/.htaccess
_HTML_NO_CACHE_META = """<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
"""


def load_ssot_answers() -> dict[str, dict]:
    responses_dir = SSOT_DIR / "responses"
    if not responses_dir.exists():
        return {}
    answers: dict[str, dict] = {}
    for f in sorted(responses_dir.glob("*.json")):
        if f.name.startswith("."):
            continue
        try:
            data = json.loads(f.read_text(encoding="utf-8"))
        except (json.JSONDecodeError, OSError):
            continue
        export = data.get("sourceExport", data)
        for a in export.get("answers", []):
            if a.get("id"):
                answers[a["id"]] = a
    return answers


def head(title: str, extra_scripts: str = "") -> str:
    return f"""<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>{escape(title)}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Frank+Ruhl+Libre:wght@700&family=Heebo:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/hub-base.css">
<link rel="stylesheet" href="assets/hub.css">
{extra_scripts}
</head>
<body>
"""


def nav(active: str) -> str:
    items = [
        ("index.html", "כניסה"),
        ("roadmap.html", "מפת דרכים"),
        ("site-tree.html", "עץ אתר"),
        ("content-intake.html", "קליטת תוכן"),
        ("tasks.html", "משימות והחלטות"),
    ]
    parts = ["<nav>"]
    for href, label in items:
        page_key = href.replace(".html", "")
        if page_key == active:
            parts.append(f"<strong>{escape(label)}</strong>")
        else:
            parts.append(f'<a href="{href}">{escape(label)}</a>')
    parts.append("</nav>")
    return "\n".join(parts)


def foot(generated_iso: str) -> str:
    return f"""<footer class="project-foot">
ממשק תקשורת ומצב עבודה — Eyal Amit 2026<br>
נוצר אוטומטית: {escape(generated_iso)}<br>
ממשק זה אינו מחליף תיעוד רשמי — לשימוש פנימי ותיאום מול הלקוח.
</footer>
<div class="hub-brand">
<a href="{WHATSAPP_URL}" target="_blank" rel="noopener">{BRAND_TEXT}</a>
</div>
</body>
</html>"""


def status_html(status: str) -> str:
    return STATUS_BADGE.get(status, f'<span class="badge">{escape(status)}</span>')


def _site_tree_children_map(nodes: list) -> dict:
    by_parent: dict[Optional[str], list] = {}
    for n in nodes:
        pid = n.get("parentId")
        by_parent.setdefault(pid, []).append(n)
    for lst in by_parent.values():
        lst.sort(key=lambda x: (x.get("titleHe") or "", x.get("id") or ""))
    return by_parent


def _preorder_page_refs(nodes: list) -> dict[str, str]:
    """Stable EA-01… codes for client comms (same order as site-tree UI)."""
    by_parent = _site_tree_children_map(nodes)
    out: dict[str, str] = {}
    i = 0

    def walk(pid: Optional[str]) -> None:
        nonlocal i
        for n in by_parent.get(pid, []):
            i += 1
            out[n["id"]] = f"EA-{i:02d}"
            walk(n["id"])

    walk(None)
    return out


def enrich_site_tree_page_refs(site_tree: dict) -> dict:
    data = copy.deepcopy(site_tree)
    nodes = data.get("nodes", [])
    auto = _preorder_page_refs(nodes)
    for n in nodes:
        n["pageRef"] = (n.get("pageRef") or "").strip() or auto.get(n["id"], "")
    return data


def _render_site_tree_overview(roots: list, by_parent: dict, ref_by_id: dict[str, str]) -> str:
    parts = [
        '<div class="site-tree-overview" role="region" aria-label="מפת עץ מקוצרת">',
        "<p class=\"sto-lead\"><strong>מבט על כל העץ</strong> — מזהה <code>EA-XX</code> לתקשורת עקבית; "
        "לפרטים מלאים והערות גללו ל־<strong>מבנה מפורט</strong> למטה.</p>",
        '<div class="sto-cols">\n',
    ]
    for r in roots:
        rid = r["id"]
        pref = escape(ref_by_id.get(rid, ""))
        title = escape(r.get("titleHe", ""))
        parts.append('<div class="sto-col">')
        parts.append(f'<div class="sto-root"><span class="sto-ref">{pref}</span> {title}</div>')
        kids = by_parent.get(rid, [])
        if kids:
            parts.append('<ul class="sto-subs">')
            for ch in kids:
                cid = ch["id"]
                cpref = escape(ref_by_id.get(cid, ""))
                ctitle = escape(ch.get("titleHe", ""))
                parts.append(f'<li><span class="sto-ref">{cpref}</span> {ctitle}')
                gkids = by_parent.get(cid, [])
                if gkids:
                    parts.append('<ul class="sto-gc">')
                    for g in gkids:
                        gpref = escape(ref_by_id.get(g["id"], ""))
                        gtitle = escape(g.get("titleHe", ""))
                        parts.append(f"<li><span class=\"sto-ref\">{gpref}</span> {gtitle}</li>")
                    parts.append("</ul>")
                parts.append("</li>")
            parts.append("</ul>")
        parts.append("</div>\n")
    parts.append("</div></div>")
    return "".join(parts)


def _template_lookup(page_templates: dict) -> tuple[dict[str, str], dict[str, str]]:
    name_by_id: dict[str, str] = {}
    mockup_by_id: dict[str, str] = {}
    for t in page_templates.get("templates", []):
        tid = t.get("id", "")
        if tid:
            name_by_id[tid] = t.get("nameHe", tid)
            mh = t.get("mockupHref")
            if isinstance(mh, str) and mh.strip():
                mockup_by_id[tid] = mh.strip()
    return name_by_id, mockup_by_id


def _render_site_tree_node(
    node: dict,
    by_parent: dict,
    tpl_names: dict[str, str],
    mockup_by_tpl: dict[str, str],
    ref_by_id: dict[str, str],
) -> str:
    nid = node["id"]
    title = node.get("titleHe", "")
    slug = node.get("slug", "")
    tid = node.get("templateId", "")
    tpl_label = tpl_names.get(tid, tid or "—")
    legacy = node.get("legacyUrl") or ""
    leg_note = node.get("legacyNoteHe") or ""
    menu_hint = node.get("menuHint") or ""
    page_ref = ref_by_id.get(nid, node.get("pageRef", ""))
    has_legacy = bool(str(legacy).strip() or str(leg_note).strip())

    meta_parts = [
        f"<strong>מזהה לתקשורת:</strong> <code class=\"page-ref-code\">{escape(page_ref)}</code>",
        f" · <strong>מזהה טכני:</strong> <code>{escape(nid)}</code>",
        f"<br><strong>slug:</strong> <code>{escape(slug)}</code>",
        f" · <strong>תבנית:</strong> {escape(tpl_label)}",
    ]
    if menu_hint:
        meta_parts.append(f" · <strong>תפריט:</strong> {escape(menu_hint)}")
    if legacy:
        meta_parts.append(
            f'<br><strong>עמוד במקור (אתר ישן):</strong> '
            f'<a class="legacy-short-link" href="{escape(legacy)}" target="_blank" rel="noopener" '
            f'title="{escape(legacy)}">פתח באתר הישן</a>'
        )
    if leg_note:
        meta_parts.append(f"<br><strong>הערת מיגרציה:</strong> {escape(leg_note)}")

    mock_href = mockup_by_tpl.get(tid, "")
    mock_link = ""
    if mock_href:
        mock_link = f'<p class="site-tree-meta"><a href="{escape(mock_href)}">מוקאפ תבנית</a></p>\n'

    body = f'<div class="site-tree-node-body">\n'
    body += f'<p class="site-tree-meta">{"".join(meta_parts)}</p>\n'
    body += mock_link
    body += f'<div class="feedback-field"><label for="site-tree-notes-{escape(nid)}">הערות (אייל / צוות)</label>\n'
    body += f'<textarea id="site-tree-notes-{escape(nid)}" rows="2" placeholder="הערות לצומת זה…"></textarea></div>\n'

    if has_legacy:
        body += f'<div class="site-tree-kmd feedback-field">\n'
        body += f'<label class="kmd-check"><input type="checkbox" id="site-tree-kmd-{escape(nid)}"> '
        body += "סמן ל־KMD / מלאי תוכן (מיגרציה מ־legacy)</label>\n"
        body += f'<label for="site-tree-kmd-notes-{escape(nid)}">הערות KMD</label>\n'
        body += f'<textarea id="site-tree-kmd-notes-{escape(nid)}" rows="2" placeholder="מיקום ב־KMD, מקור, הערות…"></textarea>\n'
        body += "</div>\n"

    kids = by_parent.get(nid, [])
    if kids:
        body += '<ul class="site-tree-children">\n'
        for ch in kids:
            body += _render_site_tree_node(ch, by_parent, tpl_names, mockup_by_tpl, ref_by_id)
        body += "</ul>\n"
    body += "</div>\n"

    sum_ref = escape(page_ref)
    return (
        f'<li class="site-tree-node">\n<details><summary><span class="sto-ref sto-ref-sum">{sum_ref}</span>'
        f'<span class="site-tree-sum-title"> — {escape(title)}</span> '
        f'<span class="d-id">{escape(nid)}</span></summary>\n{body}</details>\n</li>\n'
    )


def page_site_tree(
    site_tree: dict,
    page_templates: dict,
    legacy_unmapped: Optional[dict],
    generated_iso: str,
) -> str:
    nodes = site_tree.get("nodes", [])
    by_parent = _site_tree_children_map(nodes)
    tpl_names, mockup_by_tpl = _template_lookup(page_templates)
    roots = by_parent.get(None, [])
    ref_by_id = {n["id"]: n.get("pageRef", "") for n in nodes}

    meta_obj = {
        "treeApprovedDocRef": site_tree.get("treeApprovedDocRef", ""),
        "liveSiteBase": site_tree.get("liveSiteBase", ""),
    }
    meta_json = json.dumps(meta_obj, ensure_ascii=False)

    html = head("עץ אתר — אייל עמית")
    html += nav("site-tree")
    html += '<div class="wrap">\n'
    html += "<h1>עץ האתר (IA)</h1>\n"
    html += f'<p class="subtitle">מקור קנוני במסמך: {escape(site_tree.get("treeApprovedDocRef", ""))}</p>\n'
    html += "<p>מזהה <code>EA-XX</code> מיועד לתקשורת עקבית (מיילים, משימות) ללא תלות בתרגום כותרות. "
    "לכל צומת ניתן להוסיף הערות; בעמודי legacy ניתן לסמן KMD. ייצוא JSON — ל־<code>from-eyal</code> / צוות לפי הנוהל.</p>\n"

    html += _render_site_tree_overview(roots, by_parent, ref_by_id)

    html += f'<script type="application/json" id="hub-site-tree-meta">{meta_json}</script>\n'

    html += '<div class="feedback-field"><label for="site-tree-general-notes">הערות כלליות על העץ</label>\n'
    html += '<textarea id="site-tree-general-notes" rows="3" placeholder="הערות כלליות, סטיות מבוקשות, אישורים…"></textarea></div>\n'

    html += "<h2>מבנה מפורט</h2>\n"
    html += '<p class="subtitle">ברירת מחדל: כל הסעיפים סגורים — לחצו לפתיחה.</p>\n'
    html += '<ul class="site-tree">\n'
    for r in roots:
        html += _render_site_tree_node(r, by_parent, tpl_names, mockup_by_tpl, ref_by_id)
    html += "</ul>\n"

    legacy_rows_meta: list[dict] = []
    if legacy_unmapped and legacy_unmapped.get("items"):
        html += "<h2>עמודי legacy שלא ממופים ל־legacyUrl בעץ (publish)</h2>\n"
        html += f'<p class="subtitle">{escape(legacy_unmapped.get("generatedNoteHe", ""))}</p>\n'
        html += '<div class="table-wrap"><table class="unmapped-table">\n'
        html += (
            "<thead><tr><th>כותרת</th><th>wp id</th><th>קישור</th>"
            "<th>KMD</th><th>הערות KMD</th></tr></thead><tbody>\n"
        )
        for idx, it in enumerate(legacy_unmapped["items"][:200]):
            wpid = str(it.get("wpId", "")).strip()
            row_key = wpid if wpid.isalnum() else f"idx{idx}"
            legacy_rows_meta.append({"wpId": wpid, "domKey": row_key})
            wid_esc = escape(wpid)
            lu = it.get("legacyUrl", "")
            html += "<tr>"
            html += f'<td class="unmapped-title-cell">{escape(it.get("titleHe", ""))}</td>'
            html += f"<td>{wid_esc}</td>"
            html += (
                f'<td class="unmapped-link-cell">'
                f'<a href="{escape(lu)}" target="_blank" rel="noopener" title="{escape(lu)}">'
                f"פתח בעמוד הישן</a></td>"
            )
            html += (
                f'<td class="unmapped-kmd-cell">'
                f'<label class="kmd-check"><input type="checkbox" id="legacy-kmd-wp-{escape(row_key)}"> סמן</label></td>'
            )
            html += (
                f'<td class="unmapped-notes-cell">'
                f'<textarea id="legacy-kmd-notes-wp-{escape(row_key)}" rows="2" '
                f'placeholder="הערות KMD…"></textarea></td>'
            )
            html += "</tr>\n"
        html += "</tbody></table></div>\n"
        if len(legacy_unmapped["items"]) > 200:
            html += f'<p class="subtitle">מוצגות 200 ראשונות מתוך {len(legacy_unmapped["items"])}.</p>\n'

    html += '<div class="respondent-field feedback-field">\n'
    html += '<label for="respondent">שם המשיב</label>\n'
    html += f'<input type="text" id="respondent" value="{escape(DEFAULT_RESPONDENT)}" placeholder="שם...">\n'
    html += "</div>\n"
    html += '<div class="export-section">\n'
    html += '<p>ייצוא JSON — <code>eyal-site-tree-feedback</code></p>\n'
    html += '<button class="btn-export" type="button" id="btn-export-site-tree">ייצוא הערות עץ</button>\n'
    html += "</div>\n"

    html += "</div>\n"
    node_ids = [n["id"] for n in nodes]
    ids_json = json.dumps(node_ids, ensure_ascii=False)
    nodes_meta = [{"id": n["id"], "pageRef": n.get("pageRef", "")} for n in nodes]
    nodes_meta_json = json.dumps(nodes_meta, ensure_ascii=False)
    legacy_rows_json = json.dumps(legacy_rows_meta, ensure_ascii=False)
    html += '<script src="assets/site-tree-export.js"></script>\n'
    html += f"""<script>
SiteTreeFeedback.init({{
  exportType: {json.dumps(EXPORT_TYPE_SITE_TREE)},
  defaultRespondent: {json.dumps(DEFAULT_RESPONDENT)},
  nodeIds: {ids_json},
  nodesMeta: {nodes_meta_json},
  legacyRows: {legacy_rows_json}
}});
</script>\n"""
    html += foot(generated_iso)
    return html


def page_content_intake(
    site_tree: dict,
    page_templates: dict,
    generated_iso: str,
) -> str:
    tree_json = json.dumps(site_tree, ensure_ascii=False)
    tpl_json = json.dumps(page_templates, ensure_ascii=False)

    html = head("קליטת תוכן לעמוד — אייל עמית")
    html += nav("content-intake")
    html += '<div class="wrap">\n'
    html += "<h1>קליטת תוכן לעמוד</h1>\n"
    html += "<p>בחרו עמוד מהעץ. השדות משתנים לפי <strong>תבנית העמוד</strong>. קבצים גדולים — העלו ל־Drive ורשמו כאן <strong>שם קובץ או קישור</strong> בלבד.</p>\n"

    html += f'<script type="application/json" id="hub-data-site-tree">{tree_json}</script>\n'
    html += f'<script type="application/json" id="hub-data-page-templates">{tpl_json}</script>\n'

    html += '<div class="feedback-field"><label for="page-select">עמוד</label>\n'
    html += '<select id="page-select"></select></div>\n'
    html += '<div id="intake-fields"></div>\n'

    html += '<div class="feedback-field"><label for="drive-refs">קישור / שם קובץ ב־Drive (שורה לכל פריט)</label>\n'
    html += '<textarea id="drive-refs" rows="3" placeholder="לדוגמה: 2026-03-29--home-copy--from-eyal.docx או קישור Google Drive"></textarea></div>\n'

    html += '<div class="respondent-field feedback-field">\n'
    html += '<label for="respondent">שם המשיב</label>\n'
    html += f'<input type="text" id="respondent" value="{escape(DEFAULT_RESPONDENT)}" placeholder="שם...">\n'
    html += "</div>\n"
    html += '<div class="export-section">\n'
    html += '<p>ייצוא JSON — <code>eyal-page-content-intake</code></p>\n'
    html += '<button class="btn-export" type="button" id="btn-export-content-intake">ייצוא קליטת תוכן</button>\n'
    html += "</div>\n"
    html += "</div>\n"

    html += '<script src="assets/content-intake.js"></script>\n'
    html += f"""<script>
ContentIntake.init({{
  exportType: {json.dumps(EXPORT_TYPE_CONTENT_INTAKE)},
  defaultRespondent: {json.dumps(DEFAULT_RESPONDENT)}
}});
</script>\n"""
    html += foot(generated_iso)
    return html


def page_index(
    updates: dict,
    roadmap: dict,
    tasks: dict,
    deliverables: Optional[dict],
    generated_iso: str,
) -> str:
    milestones = roadmap.get("milestones", [])
    done_count = sum(1 for m in milestones if m["status"] == "completed")
    total_count = len(milestones)

    all_tasks = []
    for sec in tasks.get("sections", []):
        all_tasks.extend(sec.get("tasks", []))
    tasks_done = sum(1 for t in all_tasks if t.get("status") == "completed")
    tasks_total = len(all_tasks)

    html = head("אייל עמית — ממשק מצב עבודה")
    html += nav("index")
    html += '<div class="wrap">\n'
    html += "<h1>אייל עמית — ממשק מצב עבודה</h1>\n"
    html += f'<p class="subtitle">{escape(roadmap.get("summaryHe", ""))}</p>\n'
    html += (
        f'<p class="subtitle"><a href="tasks.html">משימות, החלטות פתוחות וייצוא JSON</a>'
        f' · <a href="site-tree.html">עץ אתר</a>'
        f' · <a href="content-intake.html">קליטת תוכן</a></p>\n'
    )

    html += '<div class="stats-row">\n'
    html += f'<div class="stat-card"><div class="stat-number">{done_count}/{total_count}</div><div class="stat-label">אבני דרך הושלמו</div></div>\n'
    html += f'<div class="stat-card"><div class="stat-number">{tasks_done}/{tasks_total}</div><div class="stat-label">משימות הושלמו</div></div>\n'

    current = roadmap.get("currentFocusId", "")
    current_ms = next((m for m in milestones if m["id"] == current), None)
    current_label = escape(current_ms["titleHe"]) if current_ms else "\u2014"
    html += f'<div class="stat-card"><div class="stat-number" style="font-size:1.2rem">{escape(current)}</div><div class="stat-label">מוקד נוכחי: {current_label}</div></div>\n'
    html += "</div>\n"

    html += "<h2>עדכונים אחרונים</h2>\n"
    for item in updates_items_newest_first(updates)[:5]:
        html += '<div class="card">\n'
        html += f'<div class="card-date">{escape(item["date"])}</div>\n'
        html += f'<div class="card-title">{escape(item["titleHe"])}</div>\n'
        html += f'<div class="card-body">{escape(item["bodyHe"])}</div>\n'
        html += "</div>\n"

    if deliverables and deliverables.get("items"):
        html += "<h2>חומרים (קבצים)</h2>\n"
        if deliverables.get("noteHe"):
            html += f'<p class="subtitle">{escape(deliverables["noteHe"])}</p>\n'
        html += "<ul>\n"
        for it in deliverables["items"]:
            href = it.get("href") or "#"
            html += (
                f'<li><a href="{escape(href)}">{escape(it.get("titleHe", ""))}</a> — '
                f'{escape(it.get("date", ""))} <span class="d-id">{escape(it.get("id", ""))}</span></li>\n'
            )
        html += "</ul>\n"

    html += "<h2>מוקאפים</h2>\n<ul>\n"
    mock_links = [
        ("mockups/page-types/tpl-home.html", "טיפוסי עמוד — מוקאפים תחת mockups/page-types/"),
        ("mockups/home-directions-visual.html", "דף בית — כיוונים A/B/C"),
        ("mockups/home-dashboard/index.html", "דף בית — דשבורד מלא"),
        ("mockups/mockups/mockup-digital-course.html", "קורס דיגיטלי (דמה)"),
        ("mockups/mockups/mockup-lectures.html", "הרצאות (דמה)"),
        ("mockups/kmd-inventory-prototype.html", "KMD"),
        ("mockups/en-landing-page-preview.html", "עמוד EN"),
    ]
    for href, label in mock_links:
        html += f'<li><a href="{escape(href)}">{escape(label)}</a></li>\n'
    html += "</ul>\n"

    html += "</div>\n"
    html += foot(generated_iso)
    return html


def page_roadmap(roadmap: dict, generated_iso: str) -> str:
    milestones = roadmap.get("milestones", [])
    current_id = roadmap.get("currentFocusId", "")

    html = head("מפת דרכים — אייל עמית")
    html += nav("roadmap")
    html += '<div class="wrap">\n'
    html += "<h1>מפת דרכים</h1>\n"
    html += f'<p class="subtitle">{escape(roadmap.get("summaryHe", ""))}</p>\n'

    html += '<div class="table-wrap"><table class="data">\n'
    html += "<thead><tr><th>קוד</th><th>אבן דרך</th><th>סטטוס</th><th>פרטים</th></tr></thead>\n"
    html += "<tbody>\n"
    for m in milestones:
        row_class = ' class="current"' if m["id"] == current_id else ""
        html += f"<tr{row_class}>"
        html += f"<td><strong>{escape(m['code'])}</strong></td>"
        html += f"<td>{escape(m['titleHe'])}</td>"
        html += f"<td>{status_html(m['status'])}</td>"
        html += f"<td>{escape(m.get('detailHe', ''))}</td>"
        html += "</tr>\n"
    html += "</tbody></table></div>\n"

    cob = roadmap.get("clientObligationsHe")
    if cob and isinstance(cob, list):
        html += "<h2>מה נדרש מאייל (תזכורת)</h2>\n<ul>\n"
        for line in cob:
            if isinstance(line, str) and line.strip():
                html += f"<li>{escape(line.strip())}</li>\n"
        html += "</ul>\n"
        html += (
            "<p class=\"subtitle\">פירוט מלא לפי שלב: מסמך "
            "<code>docs/project/EYAL-CLIENT-OBLIGATIONS-BY-PHASE.md</code> במאגר.</p>\n"
        )

    breakdown = roadmap.get("currentFocusBreakdown")
    if breakdown and breakdown.get("milestoneId") == current_id:
        html += '<div class="focus-breakdown">\n'
        html += f"<h2>{escape(breakdown['titleHe'])}</h2>\n"
        html += f"<p>{escape(breakdown.get('introHe', ''))}</p>\n"

        for section in breakdown.get("sections", []):
            html += '<div class="focus-section">\n'
            html += f"<h3>{escape(section['titleHe'])}</h3>\n"
            html += '<div class="table-wrap"><table class="data">\n'
            html += "<thead><tr><th>מזהה</th><th>משימה</th><th>סטטוס</th><th>מצב</th></tr></thead>\n"
            html += "<tbody>\n"
            for task in section.get("tasks", []):
                st = task.get("status", "not_started")
                if st == "awaiting_qa":
                    st = "qa"
                html += "<tr>"
                html += f'<td><span class="d-id">{escape(task["id"])}</span></td>'
                html += f"<td>{escape(task['titleHe'])}</td>"
                html += f"<td>{status_html(st)}</td>"
                html += f"<td>{escape(task.get('stateHe', ''))}</td>"
                html += "</tr>\n"
            html += "</tbody></table></div>\n"
            html += "</div>\n"

        html += "</div>\n"

    html += "</div>\n"
    html += foot(generated_iso)
    return html


def page_tasks(
    tasks_data: dict,
    decisions_data: dict,
    ssot_answers: dict[str, dict],
    generated_iso: str,
) -> str:
    decisions = decisions_data.get("decisions", [])
    decision_ids = [d["id"] for d in decisions]

    scripts = '<script src="assets/feedback.js"></script>'
    html = head("משימות והחלטות — אייל עמית")
    html += nav("tasks")
    html += '<div class="wrap">\n'
    html += "<h1>משימות והחלטות פתוחות</h1>\n"

    for section in tasks_data.get("sections", []):
        html += f"<h2>{escape(section['titleHe'])}</h2>\n"
        for task in section.get("tasks", []):
            priority = task.get("priorityHe", "")
            priority_html = PRIORITY_BADGE.get(priority, "")
            html += '<div class="task-row">\n'
            html += f'<div class="task-title">{status_html(task.get("status", "not_started"))} {escape(task["titleHe"])} {priority_html}</div>\n'
            html += f'<div class="task-state">{escape(task.get("stateHe", ""))}</div>\n'
            html += "</div>\n"

    html += "<h2>החלטות פתוחות</h2>\n"
    if decisions_data.get("introHe"):
        html += f'<p class="subtitle">{escape(decisions_data["introHe"])}</p>\n'

    for d in decisions:
        did = d["id"]
        ssot = ssot_answers.get(did, {})
        effective_status = (
            "answered" if ssot.get("choice") or ssot.get("notes") else d.get("status", "pending")
        )
        ssot_choice = ssot.get("choice", "")
        ssot_notes = ssot.get("notes", "")

        html += '<details class="decision-detail">\n'
        html += f'<summary><span class="d-id">{escape(did)}</span> {escape(d["titleHe"])} {status_html(effective_status)}</summary>\n'
        html += '<div class="decision-content">\n'
        html += f"<dt>הקשר</dt><dd>{escape(d.get('contextHe', ''))}</dd>\n"
        html += f"<dt>אפשרויות</dt><dd>{escape(d.get('optionsHe', ''))}</dd>\n"
        if d.get("implicationsHe"):
            html += f"<dt>משמעות</dt><dd>{escape(d['implicationsHe'])}</dd>\n"
        html += f"<dt>המלצה</dt><dd>{escape(d.get('recommendationHe', ''))}</dd>\n"
        if d.get("mockupHref"):
            html += f'<p><a href="{escape(d["mockupHref"])}">פתח מוקאפ</a></p>\n'

        html += f'<div class="feedback-field"><label for="choice-{escape(did)}">בחירה</label>'
        html += f'<input type="text" id="choice-{escape(did)}" value="{escape(ssot_choice)}" placeholder="הקלד בחירה..."></div>\n'

        html += f'<div class="feedback-field"><label for="notes-{escape(did)}">הערות</label>'
        html += f'<textarea id="notes-{escape(did)}" placeholder="הערות נוספות...">{escape(ssot_notes)}</textarea></div>\n'

        html += "</div>\n</details>\n"

    html += '<div class="respondent-field feedback-field">\n'
    html += '<label for="respondent">שם המשיב</label>\n'
    html += f'<input type="text" id="respondent" value="{escape(DEFAULT_RESPONDENT)}" placeholder="שם...">\n'
    html += "</div>\n"

    html += '<div class="export-section">\n'
    html += '<p>ייצוא כל התשובות לקובץ JSON להעברה לצוות</p>\n'
    html += '<button class="btn-export" id="btn-export-json">ייצוא תשובות</button>\n'
    html += "</div>\n"

    html += "</div>\n"

    html += f"{scripts}\n"
    ids_json = json.dumps(decision_ids, ensure_ascii=False)
    html += f"""<script>
HubFeedback.init({{
  exportType: {json.dumps(EXPORT_TYPE)},
  defaultRespondent: {json.dumps(DEFAULT_RESPONDENT)},
  decisionIds: {ids_json}
}});
</script>\n"""

    html += foot(generated_iso)
    return html


def page_pending_redirect() -> str:
    return """<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="refresh" content="0; url=tasks.html">
<title>מעבר לעמוד משימות והחלטות</title>
<link rel="canonical" href="tasks.html">
</head>
<body>
<p>מעביר ל־<a href="tasks.html">משימות והחלטות</a>…</p>
</body>
</html>"""


def mirror_docs(eyal_ceo: Path, dist: Path) -> None:
    to_eyal = eyal_ceo / "to-eyal"
    from_eyal = eyal_ceo / "from-eyal"
    dest_root = dist / "files"
    for base in (to_eyal, from_eyal):
        if not base.is_dir():
            continue
        for f in base.rglob("*"):
            if not f.is_file():
                continue
            if "\n" in f.name or "\r" in f.name or "\n" in str(f) or "\r" in str(f):
                print(f"WARN: skip mirror (newline in path): {f}", flush=True)
                continue
            if f.suffix.lower() not in (".docx", ".txt", ".pdf"):
                continue
            rel = f.relative_to(base)
            dest = dest_root / base.name / rel
            dest.parent.mkdir(parents=True, exist_ok=True)
            shutil.copy2(f, dest)


def copy_mockups(shared: Path, dist: Path) -> None:
    dest = dist / "mockups"
    if dest.exists():
        shutil.rmtree(dest)
    if not shared.is_dir():
        dest.mkdir(parents=True)
        (dest / "README.txt").write_text(
            "Mockups missing — ensure docs/project/eyal-ceo-submissions-and-responses/to-eyal/_shared-assets exists.\n",
            encoding="utf-8",
        )
    else:
        shutil.copytree(shared, dest)

    page_types_src = SRC_DIR / "mockups/page-types"
    if page_types_src.is_dir():
        pt_dest = dest / "page-types"
        pt_dest.mkdir(parents=True, exist_ok=True)
        for f in page_types_src.iterdir():
            if f.is_file():
                shutil.copy2(f, pt_dest / f.name)


def build(dist_dir: Path, mirror_docs_flag: bool) -> None:
    if dist_dir.exists():
        shutil.rmtree(dist_dir)
    dist_dir.mkdir(parents=True)

    root = HUB_ROOT.parent
    eyal_ceo = root / "docs/project/eyal-ceo-submissions-and-responses"
    shared = eyal_ceo / "to-eyal/_shared-assets"

    roadmap = load_json(DATA_DIR / "roadmap.json")
    updates = load_json(DATA_DIR / "updates.json")
    tasks = load_json(DATA_DIR / "tasks.json")
    decisions = load_json(DATA_DIR / "decisions.json")
    deliverables = load_json_optional(DATA_DIR / "deliverables.json")
    site_tree = enrich_site_tree_page_refs(load_json(DATA_DIR / "site-tree.json"))
    page_templates = load_json(DATA_DIR / "page-templates.json")
    legacy_unmapped = load_json_optional(DATA_DIR / "legacy-unmapped.json")
    ssot_answers = load_ssot_answers()

    if ssot_answers:
        print(f"[INFO] Loaded {len(ssot_answers)} SSOT answers")

    chk = Path(__file__).resolve().parent / "check_hub_calendar.py"
    proc = subprocess.run([sys.executable, str(chk)], cwd=HUB_ROOT.parent)
    if proc.returncode != 0:
        print("[ERROR] Hub calendar check failed — fix hub/data/updates.json (or machine date/TZ).", file=sys.stderr)
        sys.exit(proc.returncode)

    generated_iso = datetime.now(timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ")

    assets_dir = dist_dir / "assets"
    assets_dir.mkdir()
    for asset_name in (
        "hub-base.css",
        "hub.css",
        "feedback.js",
        "site-tree-export.js",
        "content-intake.js",
    ):
        src = SRC_DIR / "assets" / asset_name
        if src.exists():
            shutil.copy2(src, assets_dir / asset_name)
        else:
            print(f"[WARN] Asset not found: {src}")

    copy_mockups(shared, dist_dir)
    if mirror_docs_flag:
        mirror_docs(eyal_ceo, dist_dir)

    inc_src = SRC_DIR / "incoming"
    if inc_src.is_dir():
        inc_dest = dist_dir / "incoming"
        shutil.copytree(inc_src, inc_dest)

    (dist_dir / "index.html").write_text(
        page_index(updates, roadmap, tasks, deliverables, generated_iso), encoding="utf-8"
    )
    (dist_dir / "roadmap.html").write_text(page_roadmap(roadmap, generated_iso), encoding="utf-8")
    (dist_dir / "site-tree.html").write_text(
        page_site_tree(site_tree, page_templates, legacy_unmapped, generated_iso), encoding="utf-8"
    )
    (dist_dir / "content-intake.html").write_text(
        page_content_intake(site_tree, page_templates, generated_iso), encoding="utf-8"
    )
    (dist_dir / "tasks.html").write_text(
        page_tasks(tasks, decisions, ssot_answers, generated_iso), encoding="utf-8"
    )
    (dist_dir / "pending.html").write_text(page_pending_redirect(), encoding="utf-8")

    (dist_dir / "robots.txt").write_text("User-agent: *\nDisallow: /\n", encoding="utf-8")

    metadata = {
        "generatedAt": generated_iso,
        "schemaVersion": 1,
        "project": PROJECT_META,
        "mirrorDocs": bool(mirror_docs_flag),
    }
    (dist_dir / "metadata.json").write_text(
        json.dumps(metadata, indent=2, ensure_ascii=False), encoding="utf-8"
    )

    data_out = dist_dir / "data"
    data_out.mkdir()
    for name in (
        "roadmap.json",
        "updates.json",
        "tasks.json",
        "decisions.json",
        "deliverables.json",
        "page-templates.json",
        "legacy-unmapped.json",
    ):
        src = DATA_DIR / name
        if src.exists():
            shutil.copy2(src, data_out / name)
    (data_out / "site-tree.json").write_text(
        json.dumps(site_tree, ensure_ascii=False, indent=2) + "\n",
        encoding="utf-8",
    )
    anchor_src = DATA_DIR / "calendar-anchor.txt"
    if anchor_src.exists():
        shutil.copy2(anchor_src, data_out / "calendar-anchor.txt")

    print(f"[OK] Hub built → {dist_dir}")
    print(f"     Generated: {generated_iso}")
    file_count = sum(1 for _ in dist_dir.rglob("*") if _.is_file())
    print(f"     Files: {file_count}")


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Build Eyal Amit client hub (v1.1)")
    parser.add_argument("--out", type=str, default=None, help="Output directory")
    parser.add_argument(
        "--mirror-docs",
        action="store_true",
        help="Copy docx/txt/pdf from to-eyal and from-eyal into dist/files/",
    )
    parser.add_argument(
        "--mirror-docx",
        action="store_true",
        help="Alias for --mirror-docs",
    )
    args = parser.parse_args()

    out = Path(args.out) if args.out else DEFAULT_DIST
    build(out, mirror_docs_flag=bool(args.mirror_docs or args.mirror_docx))
