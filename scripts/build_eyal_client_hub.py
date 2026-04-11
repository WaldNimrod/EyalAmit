#!/usr/bin/env python3
"""Build static Eyal Amit 2026 client hub from hub/data (Client Hub Standard v1.1).

Usage (repo root):
    python3 scripts/build_eyal_client_hub.py
    python3 scripts/build_eyal_client_hub.py --out hub/dist
    python3 scripts/build_eyal_client_hub.py --mirror-docs
    python3 scripts/build_eyal_client_hub.py --mirror-docx   # alias for --mirror-docs

Output: hub/dist/ (index, roadmap, site-tree, content-intake, tasks, pending redirect, assets/, files/team40/…)
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
from zoneinfo import ZoneInfo

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
DEFAULT_HUB_VIEW_VERSION = "1.1.0"
TZ_JERUSALEM = ZoneInfo("Asia/Jerusalem")


def hub_view_version(path: Path) -> str:
    data = load_json_optional(path)
    if data and str(data.get("hubVersion", "")).strip():
        return str(data["hubVersion"]).strip()
    return DEFAULT_HUB_VIEW_VERSION


def format_build_time_displays(generated_iso: str) -> tuple[str, str]:
    """(display Israel, display UTC) for the same build instant."""
    dt_utc = datetime.fromisoformat(generated_iso.replace("Z", "+00:00"))
    dt_il = dt_utc.astimezone(TZ_JERUSALEM)
    return (
        dt_il.strftime("%d.%m.%Y %H:%M"),
        dt_utc.strftime("%d.%m.%Y %H:%M"),
    )


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
    """Sort by ISO date desc, then id desc (tie-break) so 'עדכונים אחרונים' is stable."""
    items = list(updates.get("items", []))
    items.sort(key=lambda x: (x.get("date", ""), x.get("id", "")), reverse=True)
    return items


def deliverables_items_newest_first(deliverables: dict) -> list:
    items = list(deliverables.get("items", []))
    items.sort(key=lambda x: (x.get("date", ""), x.get("id", "")), reverse=True)
    return items


# מוקאפים בכניסה: סבב תאריך + קישור להחלטות (tasks.html)
MOCKUP_INDEX_SECTIONS: list[dict] = [
    {
        "titleHe": "2026-04-06 · נעול ליישום — אישור אייל (עץ + דף בית)",
        "subtitleHe": "אין לשנות מבנה IA או שלד בית בלי סבב אישור מחדש. מקור עץ: site-tree.html · מוקאף חוזי מאושר למטה.",
        "items": [
            {
                "href": "site-tree.html",
                "labelHe": "עץ האתר (נעול)",
                "decisionIds": ["D-EYAL-SITE-07", "D-EYAL-IA-MENU-08"],
            },
            {
                "href": "mockups/wireframes/home-visual-sketch-final-rtl.html",
                "labelHe": "דף בית — מוקאף מאושר (סקיצה סופית)",
                "decisionIds": ["D-EYAL-HOME-01", "D-EYAL-MENU-BRAND-10"],
            },
        ],
    },
    {
        "titleHe": "2026-03-29 · סגירת IA: עץ אתר לוגי + ווירפריים דף בית (מאייל)",
        "subtitleHe": "מסמך HTML אחד לפגישה — תפריט §6.1, תתי־עמודים, עמודים מחוץ לתפריט, יישור §7.1 מול wireframe v2; קובץ הווירפריים מועתק מ־from-eyal.",
        "items": [
            {
                "href": "mockups/sitemap-logical-closure.html",
                "labelHe": "סגירת IA — תרשים תפריט, טבלאות מיפוי, עץ היררכי",
                "decisionIds": ["D-EYAL-SITE-07", "D-EYAL-IA-MENU-08", "D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/wireframes/eyal_homepage_wireframe_rtl_arial_v2.html",
                "labelHe": "דף בית — ווירפריים RTL Arial v2 (מאייל)",
                "decisionIds": ["D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/wireframes/home-visual-sketch-final-rtl.html",
                "labelHe": "דף בית — סקיצה ויזואלית (מיושרת לווירפריים מאייל + תפריט §6.1)",
                "decisionIds": ["D-EYAL-HOME-01", "D-EYAL-IA-MENU-08"],
            },
        ],
    },
    {
        "titleHe": "2026-04-06 · סבב מסמך מפתח אייל (GEO/AEO/SEO) + יישור Hub",
        "subtitleHe": "דף בית 12 בלוקים, השוואת תפריט §6.1 מול v2.3, השוואת Hero §8.2 — מעודכן עם מסמך from-eyal.",
        "items": [
            {
                "href": "mockups/home-dashboard/index.html",
                "labelHe": "דף בית — דשבורד (מבחר אופציות; התחילו מאופציה ב׳)",
                "decisionIds": ["D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/home-dashboard/home-dashboard-option-b.html",
                "labelHe": "דף בית — אופציה ב׳ (wireframe לפי §7.1–§8)",
                "decisionIds": ["D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/home-dashboard/home-dashboard-option-a.html",
                "labelHe": "דף בית — אופציה א׳ (היסטורי, צפיפות)",
                "decisionIds": ["D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/home-dashboard/home-dashboard-option-c.html",
                "labelHe": "דף בית — אופציה ג׳ (היסטורי, SEO)",
                "decisionIds": ["D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/ia-compare/README.txt",
                "labelHe": "השוואת IA — README (איך להשתמש)",
                "decisionIds": ["D-EYAL-SITE-07", "D-EYAL-IA-MENU-08", "D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/ia-compare/menu-v23-services-hub.html",
                "labelHe": "תפריט — רוח v2.3 (שירותים כהאב)",
                "decisionIds": ["D-EYAL-SITE-07", "D-EYAL-IA-MENU-08"],
            },
            {
                "href": "mockups/ia-compare/menu-eyal-flat-11.html",
                "labelHe": "תפריט — §6.1 שטוח (11 פריטים)",
                "decisionIds": ["D-EYAL-SITE-07", "D-EYAL-IA-MENU-08"],
            },
            {
                "href": "mockups/ia-compare/hero-dashboard-vs-brief.html",
                "labelHe": "Hero — דשבורד קודם מול נוסח §8.2",
                "decisionIds": ["D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/page-types/tpl-home.html",
                "labelHe": "טיפוס עמוד — בית (קליטת תוכן)",
                "decisionIds": ["D-EYAL-HOME-01"],
            },
        ],
    },
    {
        "titleHe": "2026-03–04 · סבב M2 — מוקאפים נקודתיים (EN, KMD, קורסים, כיווני בית)",
        "subtitleHe": "לא עודכנו במסגרת סבב מסמך המפתח; קשורים להחלטות נפרדות.",
        "items": [
            {
                "href": "mockups/home-directions-visual.html",
                "labelHe": "דף בית — כיוונים חזותיים A/B/C (היסטורי)",
                "decisionIds": ["D-EYAL-HOME-01"],
            },
            {
                "href": "mockups/en-landing-page-preview.html",
                "labelHe": "עמוד EN",
                "decisionIds": ["D-EYAL-EN-BODY-02"],
            },
            {
                "href": "mockups/kmd-inventory-prototype.html",
                "labelHe": "KMD — Keep / Merge / Drop",
                "decisionIds": ["D-EYAL-KMD-04"],
            },
            {
                "href": "mockups/mockups/mockup-digital-course.html",
                "labelHe": "קורס דיגיטלי (דמה)",
                "decisionIds": ["D-EYAL-COURSES-05"],
            },
            {
                "href": "mockups/mockups/mockup-lectures.html",
                "labelHe": "הרצאות (דמה)",
                "decisionIds": ["D-EYAL-COURSES-05"],
            },
        ],
    },
    {
        "titleHe": "2026-04-06 · קליטת תוכן — נוהל חבילות + POC (צוות 100)",
        "subtitleHe": "עדכון מצוות אייל: canonical_update_pack · דף דמה st-book-kushi.",
        "items": [
            {
                "href": "mockups/poc/poc-kushi-blantis-st-book-kushi-2026-04-06.html",
                "labelHe": "POC — כושי בלאנטיס (st-book-kushi · tpl-secondary + Morning)",
                "decisionIds": ["D-EYAL-GREEN-UX-06"],
            },
        ],
    },
    {
        "titleHe": "מוזה הוצאה לאור — שער ספרים ודף ספר לדוגמה",
        "subtitleHe": "תבנית tpl-books + עמוד מלא ל«כושי בלאנטיס» (אותו נתיב כמו בעץ: pageMockupHref).",
        "items": [
            {
                "href": "mockups/page-types/tpl-books.html",
                "labelHe": "תבנית שער ספרים (מדור מוזה)",
                "decisionIds": [],
            },
            {
                "href": "mockups/poc/poc-kushi-blantis-st-book-kushi-2026-04-06.html",
                "labelHe": "דף ספר — כושי בלאנטיס · st-book-kushi",
                "decisionIds": ["D-EYAL-GREEN-UX-06"],
            },
        ],
    },
]


def html_mockup_index_sections() -> str:
    parts: list[str] = ['<h2 id="mockups">מוקאפים</h2>\n']
    for sec in MOCKUP_INDEX_SECTIONS:
        parts.append('<div class="mockup-round">\n')
        parts.append(f'<h3 class="mockup-round__title">{escape(sec["titleHe"])}</h3>\n')
        if sec.get("subtitleHe"):
            parts.append(f'<p class="mockup-round__sub">{escape(sec["subtitleHe"])}</p>\n')
        parts.append("<ul>\n")
        for it in sec["items"]:
            href = it["href"]
            label = it["labelHe"]
            ids = it.get("decisionIds") or []
            dec_part = ""
            if ids:
                dec_links = " · ".join(
                    f'<a href="tasks.html" class="mockup-decision-link">{escape(x)}</a>' for x in ids
                )
                dec_part = f' <span class="mockup-decisions">({dec_links})</span>'
            parts.append(f'<li><a href="{escape(href)}">{escape(label)}</a>{dec_part}</li>\n')
        parts.append("</ul>\n</div>\n")
    return "".join(parts)


STATUS_BADGE = {
    "approved": '<span class="badge badge-done">אושר · נעול</span>',
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
        ("purchase-links.html", "קישורי רכישה"),
        ("content-index.html", "אינדקס תוכן"),
        ("meeting-checklist.html", "צ׳קליסט פגישה"),
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
        lst.sort(
            key=lambda x: (
                x.get("treeOrder") if isinstance(x.get("treeOrder"), int) else 999,
                x.get("titleHe") or "",
                x.get("id") or "",
            )
        )
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


LIFECYCLE_STAGE_LABELS_HE: dict[str, str] = {
    "planned": "מתוכנן",
    "content": "תוכן / POC",
    "deployed": "מותמע באתר",
    "approved": "אושר סופית",
}

LIFECYCLE_LEGEND_LINES_HE: list[tuple[str, str]] = [
    ("planned", "עדיין ללא קליטת תוכן או ללא מוצר מקושר."),
    ("content", "התקבל תוכן או הוכן מוקאפ/POC — טרם פריסה סופית."),
    ("deployed", "גרסה חיה או מוטמעת בסביבת אתר (קישור חיצוני או staging)."),
    (
        "approved",
        "חתימה סופית על מסמך/מוקאפ לפני או במקביל לפריסה — לא אותו דבר כמו עמוד חי בוורדפרס; לגרסה חיה השתמשו ב«מותמע באתר».",
    ),
]


def _normalize_lifecycle_stage(raw: object) -> str:
    allowed = frozenset(LIFECYCLE_STAGE_LABELS_HE)
    s = str(raw or "").strip().lower()
    if s in allowed:
        return s
    return "planned"


def _lifecycle_pill_html(stage: str) -> str:
    label = LIFECYCLE_STAGE_LABELS_HE.get(stage, LIFECYCLE_STAGE_LABELS_HE["planned"])
    return (
        f'<span class="lifecycle-pill lifecycle-pill--{escape(stage)}" '
        f'title="{escape(label)}">{escape(label)}</span>'
    )


def _default_product_href_label_he(href: str) -> str:
    h = href.strip()
    if h.lower().startswith(("http://", "https://")):
        return "פתח באתר / קישור חיצוני"
    return "מוקאפ / תצוגה ב־Hub"


def _product_href_anchor(href: str, label_he: str, new_tab: bool) -> str:
    esc_h = escape(href)
    esc_l = escape(label_he)
    tgt = ' target="_blank" rel="noopener noreferrer"' if new_tab else ""
    return f'<a class="site-tree-product-link" href="{esc_h}"{tgt}>{esc_l}</a>'


def _render_product_block(product_href: str, label_he: str) -> str:
    href = product_href.strip()
    if not href:
        return ""
    new_tab = href.lower().startswith(("http://", "https://"))
    lab = label_he.strip() if label_he else _default_product_href_label_he(href)
    return (
        f'<p class="site-tree-meta site-tree-meta--product">'
        f"<strong>מוצר עדכני:</strong> "
        f"{_product_href_anchor(href, lab, new_tab)}"
        f"</p>\n"
    )


def _node_overview_links_html(node: dict) -> str:
    """קישורי מוצר/מוקאפ בשורת המפה המקוצרת (לא רק בתוך details מקוננים)."""
    ph = str(node.get("productHref") or "").strip()
    pm = str(node.get("pageMockupHref") or "").strip()
    if not ph and not pm:
        return ""
    bits: list[str] = []
    if ph:
        lab = str(node.get("productHrefLabelHe") or "").strip() or _default_product_href_label_he(ph)
        nt = ph.lower().startswith(("http://", "https://"))
        bits.append(_product_href_anchor(ph, lab, nt))
    if pm and pm != ph:
        bits.append(f'<a class="sto-mini-link" href="{escape(pm)}">מוקאפ עמוד</a>')
    inner = " · ".join(bits)
    return f' <span class="sto-inline-links"><span class="sto-inline-links__inner">{inner}</span></span>'


def _render_site_tree_deliverables_panel(nodes: list) -> str:
    """בלוק בולט לכל עמוד שיש לו productHref או pageMockupHref — נראות מיידית מעל המבנה המפורט."""
    rows: list[str] = []
    keyed: list[tuple[str, dict]] = []
    for n in nodes:
        ph = str(n.get("productHref") or "").strip()
        pm = str(n.get("pageMockupHref") or "").strip()
        if ph or pm:
            keyed.append((n.get("pageRef") or n.get("id", ""), n))
    keyed.sort(key=lambda x: x[0])
    for _k, n in keyed:
        pref = escape(n.get("pageRef", ""))
        title = escape(n.get("titleHe", ""))
        nid = escape(n["id"])
        ph = str(n.get("productHref") or "").strip()
        pm = str(n.get("pageMockupHref") or "").strip()
        link_bits: list[str] = []
        if ph:
            lab = str(n.get("productHrefLabelHe") or "").strip() or _default_product_href_label_he(ph)
            nt = ph.lower().startswith(("http://", "https://"))
            link_bits.append(_product_href_anchor(ph, lab, nt))
        if pm and pm != ph:
            link_bits.append(f'<a href="{escape(pm)}">מוקאפ עמוד (Hub)</a>')
        if not link_bits and pm:
            link_bits.append(f'<a href="{escape(pm)}">מוקאפ עמוד (Hub)</a>')
        row_links = " · ".join(link_bits)
        rows.append(
            f'<li><a class="sto-deliverable-jump" href="#{nid}">{pref}</a> '
            f'<span class="sto-deliverable-title">{title}</span> — {row_links}</li>'
        )
    if not rows:
        return ""
    return (
        '<div class="site-tree-deliverables-panel" role="region" aria-label="מוצרים ומוקאפים">'
        "<p><strong>מוצרים ומוקאפים — קישורים מהירים</strong> "
        "(כל מה שיש לו קובץ מוכן ב־Hub או עמוד חי; <code>EA-XX</code> מקשר לעוגן במבנה המפורט למטה).</p>"
        '<ul class="site-tree-deliverables-list">\n'
        + "\n".join(rows)
        + "\n</ul></div>\n"
    )


def _render_site_tree_overview(roots: list, by_parent: dict, ref_by_id: dict[str, str]) -> str:
    parts = [
        '<div class="site-tree-overview" role="region" aria-label="מפת עץ מקוצרת">',
        "<p class=\"sto-lead\"><strong>מבט על כל העץ</strong> — מזהה <code>EA-XX</code> לתקשורת עקבית; "
        "ליד חלק מהשורות מופיעים <strong>קישורי מוצר</strong> (מוקאפ / אתר חי). "
        "לפרטים מלאים והערות גללו ל־<strong>מבנה מפורט</strong> למטה.</p>",
        '<div class="sto-cols">\n',
    ]
    for r in roots:
        rid = r["id"]
        pref = escape(ref_by_id.get(rid, ""))
        title = escape(r.get("titleHe", ""))
        parts.append('<div class="sto-col">')
        parts.append(
            f'<div class="sto-root"><span class="sto-ref">{pref}</span> {title}'
            f"{_node_overview_links_html(r)}</div>"
        )
        kids = by_parent.get(rid, [])
        if kids:
            parts.append('<ul class="sto-subs">')
            for ch in kids:
                cid = ch["id"]
                cpref = escape(ref_by_id.get(cid, ""))
                ctitle = escape(ch.get("titleHe", ""))
                parts.append(
                    f'<li><span class="sto-ref">{cpref}</span> {ctitle}'
                    f"{_node_overview_links_html(ch)}"
                )
                gkids = by_parent.get(cid, [])
                if gkids:
                    parts.append('<ul class="sto-gc">')
                    for g in gkids:
                        gpref = escape(ref_by_id.get(g["id"], ""))
                        gtitle = escape(g.get("titleHe", ""))
                        parts.append(
                            f"<li><span class=\"sto-ref\">{gpref}</span> {gtitle}"
                            f"{_node_overview_links_html(g)}</li>"
                        )
                    parts.append("</ul>")
                parts.append("</li>")
            parts.append("</ul>")
        parts.append("</div>\n")
    parts.append("</div></div>")
    return "".join(parts)


def _render_site_tree_lifecycle_legend() -> str:
    parts = [
        '<div class="site-tree-lifecycle-legend" role="region" aria-label="מקרא שלבי מוצר">',
        "<p><strong>מקרא שלבים בעץ:</strong> לכל צומת ניתן לציין שלב (תג צבע בשורת הכותרת) "
        "וקישור <strong>מוצר עדכני</strong> — מוקאפ יחסי ב־Hub או URL מלא לאתר החי.</p>",
        '<ul class="lifecycle-legend-list">\n',
    ]
    for stage, desc in LIFECYCLE_LEGEND_LINES_HE:
        lab = LIFECYCLE_STAGE_LABELS_HE[stage]
        parts.append(
            f'<li><span class="lifecycle-pill lifecycle-pill--{escape(stage)}">{escape(lab)}</span> '
            f'<span class="lifecycle-legend-desc">{escape(desc)}</span></li>\n'
        )
    parts.append("</ul></div>\n")
    return "".join(parts)


def _render_site_tree_node(
    node: dict,
    by_parent: dict,
    tpl_names: dict[str, str],
    mockup_by_tpl: dict[str, str],
    ref_by_id: dict[str, str],
    depth: int = 0,
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
    tree_note = node.get("treeNoteHe") or ""
    if tree_note:
        meta_parts.append(f"<br><strong>הערת עץ:</strong> {escape(tree_note)}")
    if legacy:
        meta_parts.append(
            f'<br><strong>עמוד במקור (אתר ישן):</strong> '
            f'<a class="legacy-short-link" href="{escape(legacy)}" target="_blank" rel="noopener" '
            f'title="{escape(legacy)}">פתח באתר הישן</a>'
        )
    if leg_note:
        meta_parts.append(f"<br><strong>הערת מיגרציה:</strong> {escape(leg_note)}")
    morning_url = str(node.get("morningCheckoutUrl") or "").strip()
    if morning_url:
        meta_parts.append(
            "<br><strong>קישור סליקה Morning (אושר):</strong> "
            f'<a href="{escape(morning_url)}" target="_blank" rel="noopener noreferrer">'
            f"{escape(morning_url)}</a>"
        )

    mock_href = mockup_by_tpl.get(tid, "")
    mock_link = ""
    if mock_href:
        mock_link = f'<p class="site-tree-meta"><a href="{escape(mock_href)}">מוקאפ תבנית</a></p>\n'
    page_mock = str(node.get("pageMockupHref") or "").strip()
    if page_mock:
        mock_link += (
            f'<p class="site-tree-meta site-tree-meta--page-mockup">'
            f'<a href="{escape(page_mock)}">מוקאפ עמוד (תוכן לדוגמה)</a>'
            f" — דף מלא לפי קליטת תוכן / POC</p>\n"
        )

    product_href = str(node.get("productHref") or "").strip()
    product_label = str(node.get("productHrefLabelHe") or "").strip()
    product_block = _render_product_block(product_href, product_label) if product_href else ""

    raw_stage = node.get("lifecycleStage")
    has_explicit_stage = "lifecycleStage" in node and str(raw_stage or "").strip()
    if has_explicit_stage:
        lifecycle_stage = _normalize_lifecycle_stage(raw_stage)
    elif product_href:
        lifecycle_stage = "content"
    else:
        lifecycle_stage = "planned"
    show_lifecycle_pill = bool(has_explicit_stage or product_href)
    pill = _lifecycle_pill_html(lifecycle_stage) if show_lifecycle_pill else ""
    sum_lifecycle = f'<span class="site-tree-sum-lifecycle">{pill}</span>' if pill else ""

    body = f'<div class="site-tree-node-body">\n'
    body += f'<p class="site-tree-meta">{"".join(meta_parts)}</p>\n'
    body += mock_link
    body += product_block
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
            body += _render_site_tree_node(
                ch, by_parent, tpl_names, mockup_by_tpl, ref_by_id, depth + 1
            )
        body += "</ul>\n"
    body += "</div>\n"

    sum_ref = escape(page_ref)
    d = min(depth, 6)
    depth_cls = f" site-tree-depth-{d}"
    return (
        f'<li class="site-tree-node{depth_cls}" id="{escape(nid)}">\n<details><summary><span class="sto-ref sto-ref-sum">{sum_ref}</span>'
        f'<span class="site-tree-sum-title"> — {escape(title)}</span> '
        f'<span class="d-id">{escape(nid)}</span>'
        f"{sum_lifecycle}</summary>\n{body}</details>\n</li>\n"
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
    html += (
        "<p><strong>תפריט ראשי (11 + לוגו):</strong> לוגו→בית (ללא כפתור «בית») · טיפול · שיטה · שיעורים · סאונד · לימוד והכשרה · "
        "כלים ואביזרים · מוזה הוצאה לאור · בלוג דיג׳רידו (מקום 9) · אייל עמית · צור קשר (עמוד אחד). "
        "<strong>אנגלית</strong> — איקון קטן בהדר בלבד, לא בתפריט. <strong>המלצות ומדיה</strong> — לא בשורת התפריט (פוטר/פנימי). "
        "ענף <strong>עמודים נוספים</strong>: FAQ (פוטר בלבד; שזירה בעמודים כמו גלריות), ניהול גלריות, 404, מדיניות פרטיות, נגישות, תקנון, תודה, מפת אתר, legacy.</p>\n"
    )
    html += (
        "<p>מזהה <code>EA-XX</code> מיועד לתקשורת עקבית (מיילים, משימות) ללא תלות בתרגום כותרות. "
        "לכל צומת ניתן להוסיף הערות; בעמודי legacy ניתן לסמן KMD. ייצוא JSON — ל־<code>from-eyal</code> / צוות לפי הנוהל.</p>\n"
    )

    html += _render_site_tree_overview(roots, by_parent, ref_by_id)
    html += _render_site_tree_deliverables_panel(nodes)

    html += f'<script type="application/json" id="hub-site-tree-meta">{meta_json}</script>\n'

    html += '<div class="feedback-field"><label for="site-tree-general-notes">הערות כלליות על העץ</label>\n'
    html += '<textarea id="site-tree-general-notes" rows="3" placeholder="הערות כלליות, סטיות מבוקשות, אישורים…"></textarea></div>\n'

    html += "<h2>מבנה מפורט</h2>\n"
    html += _render_site_tree_lifecycle_legend()
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
    def _node_meta_lifecycle(n: dict) -> str:
        ph = str(n.get("productHref") or "").strip()
        if "lifecycleStage" in n and str(n.get("lifecycleStage") or "").strip():
            return _normalize_lifecycle_stage(n.get("lifecycleStage"))
        if ph:
            return "content"
        return ""

    nodes_meta = [
        {
            "id": n["id"],
            "pageRef": n.get("pageRef", ""),
            "lifecycleStage": _node_meta_lifecycle(n),
            "productHref": str(n.get("productHref") or "").strip(),
            "productHrefLabelHe": str(n.get("productHrefLabelHe") or "").strip(),
        }
        for n in nodes
    ]
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


def page_content_index(content_index: dict, generated_iso: str) -> str:
    """עמוד אינדקס תוכן — כל הנכסים שהתקבלו מאייל."""
    items = content_index.get("items", [])
    changelog = content_index.get("changelog", [])

    STATUS_BADGE = {
        "ingested": '<span class="badge badge-done">✓ נקלט</span>',
        "pending": '<span class="badge badge-pending">⚠ ממתין</span>',
        "blocked": '<span class="badge badge-blocked">✗ חסום</span>',
        "proposed": '<span class="badge badge-run">ℹ מוצע</span>',
        "reference": '<span class="badge">עיון</span>',
    }
    CAT_LABEL = {
        "content_package": "חבילת תוכן",
        "spec_doc": "מסמך מפרט",
        "logo_asset": "לוגו/נכס",
        "media_ref": "מדיה",
        "deliverable_sent": "נשלח ללקוח",
    }
    CATS_ORDER = ["content_package", "spec_doc", "logo_asset", "media_ref", "deliverable_sent"]

    # stats
    total = len(items)
    by_status: dict[str, int] = {}
    by_cat: dict[str, list] = {}
    for item in items:
        s = item.get("status", "reference")
        by_status[s] = by_status.get(s, 0) + 1
        c = item.get("category", "spec_doc")
        by_cat.setdefault(c, []).append(item)

    html = head("אינדקס תוכן — אייל עמית")
    html += nav("content-index")
    html += '<div class="wrap">\n'
    html += "<h1>אינדקס תוכן — כל הנכסים מאייל</h1>\n"
    html += f'<p class="subtitle">סה״כ {total} פריטים מתועדים | {by_status.get("ingested", 0)} נקלטו · {by_status.get("pending", 0)} ממתינים · {by_status.get("blocked", 0)} חסומים · {by_status.get("proposed", 0)} מוצעים</p>\n'

    # summary cards
    html += '<div class="cards">\n'
    for stat_key, label, badge_cls in [
        ("ingested", "נקלטו", "badge-done"),
        ("pending", "ממתינים", "badge-pending"),
        ("blocked", "חסומים", "badge-blocked"),
        ("proposed", "מוצעים", "badge-run"),
        ("reference", "עיון", ""),
    ]:
        cnt = by_status.get(stat_key, 0)
        badge = f'<span class="badge {badge_cls}">{cnt}</span>' if badge_cls else f'<span class="badge">{cnt}</span>'
        html += f'<div class="card"><h3>{escape(label)}</h3><p style="font-size:2rem;margin:0">{badge}</p></div>\n'
    html += "</div>\n"

    # table per category
    for cat in CATS_ORDER:
        cat_items = by_cat.get(cat, [])
        if not cat_items:
            continue
        cat_label = CAT_LABEL.get(cat, cat)
        html += f'<details open><summary><strong>{escape(cat_label)}</strong> ({len(cat_items)})</summary>\n'
        html += '<table class="data">\n'
        html += "<thead><tr><th>מזהה</th><th>תיאור</th><th>סטטוס</th><th>תאריך</th><th>פעולה נדרשת</th></tr></thead>\n"
        html += "<tbody>\n"
        for item in cat_items:
            item_id = escape(item.get("id", ""))
            title = escape(item.get("titleHe", ""))
            status = item.get("status", "reference")
            badge = STATUS_BADGE.get(status, f'<span class="badge">{escape(status)}</span>')
            date = escape(item.get("receivedDate", item.get("indexedAt", "")[:10]))
            action = item.get("actionNeededHe", "")
            action_cell = f'<span style="color:#b05b00;font-weight:600">{escape(action)}</span>' if action else "—"
            note = item.get("noteHe", "")
            note_cell = f'<br><small style="color:#666">{escape(note)}</small>' if note else ""
            html += f"<tr><td><code style='font-size:.75rem'>{item_id}</code></td><td>{title}{note_cell}</td><td>{badge}</td><td>{date}</td><td>{action_cell}</td></tr>\n"
        html += "</tbody></table>\n</details>\n"

    # changelog
    if changelog:
        html += '<details><summary><strong>יומן שינויים</strong></summary>\n'
        html += '<table class="data"><thead><tr><th>תאריך</th><th>אירוע</th><th>הערה</th></tr></thead><tbody>\n'
        for entry in changelog:
            at = escape(entry.get("at", "")[:10])
            event = escape(entry.get("event", ""))
            note = escape(entry.get("noteHe", ""))
            html += f"<tr><td>{at}</td><td><code>{event}</code></td><td>{note}</td></tr>\n"
        html += "</tbody></table>\n</details>\n"

    html += "</div>\n"
    html += foot(generated_iso)
    return html


def page_purchase_links(site_tree: dict, generated_iso: str) -> str:
    """עמוד קישורי רכישה — אייל ממלא URL לכל ספר, ייצוא JSON."""
    # Collect book-related nodes (tpl-book-detail) + books hub (tpl-books)
    BOOK_TEMPLATES = {"tpl-book-detail", "tpl-books", "tpl-lecture-product", "tpl-external-menu"}
    nodes = [
        n for n in (site_tree.get("nodes") or [])
        if n.get("templateId") in BOOK_TEMPLATES or n.get("id") in {"st-books"}
    ]

    html = head("קישורי רכישה — אייל עמית")
    html += nav("purchase-links")
    html += '<div class="wrap">\n'
    html += "<h1>קישורי רכישה</h1>\n"
    html += '<p class="subtitle">מלא את כתובות הרכישה לכל ספר ולחץ <strong>ייצוא JSON</strong>. שלח את הקובץ שיורד לצוות.</p>\n'

    html += '<div id="pl-form">\n'

    if not nodes:
        html += '<p class="subtitle">לא נמצאו עמודי ספר בעץ האתר.</p>\n'
    else:
        for node in nodes:
            node_id = node.get("id", "")
            title = node.get("titleHe", node_id)
            slug = node.get("slug", "")
            html += f'<div class="card" style="margin-bottom:1.5rem">\n'
            html += f'<h3 style="margin-top:0">{escape(title)}</h3>\n'
            html += f'<p class="subtitle" style="margin:0 0 .75rem">{escape(slug)}</p>\n'
            html += f'<div class="feedback-field"><label for="pl-url1-{escape(node_id)}">קישור רכישה ראשי (מודפס / morning.to)</label>\n'
            html += f'<input type="url" id="pl-url1-{escape(node_id)}" data-page="{escape(node_id)}" data-field="primaryUrl" placeholder="https://..."></div>\n'
            html += f'<div class="feedback-field"><label for="pl-url2-{escape(node_id)}">קישור רכישה משני (אלקטרוני, אופציונלי)</label>\n'
            html += f'<input type="url" id="pl-url2-{escape(node_id)}" data-page="{escape(node_id)}" data-field="secondaryUrl" placeholder="https://..."></div>\n'
            html += f'<div class="feedback-field"><label for="pl-platform-{escape(node_id)}">פלטפורמה (לדוגמה: morning.to, steimatzky, amazon)</label>\n'
            html += f'<input type="text" id="pl-platform-{escape(node_id)}" data-page="{escape(node_id)}" data-field="platform" placeholder="morning.to"></div>\n'
            html += '</div>\n'

    html += '<div class="respondent-field feedback-field">\n'
    html += '<label for="pl-respondent">שם הממלא</label>\n'
    html += f'<input type="text" id="pl-respondent" value="{escape("אייל עמית")}" placeholder="שם..."></div>\n'
    html += '<div class="export-section"><button class="btn-export" type="button" id="btn-export-purchase-links">ייצוא קישורי רכישה JSON</button></div>\n'
    html += '</div>\n'  # pl-form

    # Inline JS for export
    nodes_json = json.dumps([
        {"id": n.get("id"), "titleHe": n.get("titleHe"), "slug": n.get("slug", "")}
        for n in nodes
    ], ensure_ascii=False)
    html += f"""<script>
(function() {{
  var nodes = {nodes_json};
  document.getElementById('btn-export-purchase-links').addEventListener('click', function() {{
    var respondent = (document.getElementById('pl-respondent') || {{}}).value || '';
    var books = nodes.map(function(n) {{
      function v(field) {{
        var el = document.getElementById('pl-' + field + '-' + n.id);
        return el ? el.value.trim() : '';
      }}
      return {{
        pageId: n.id,
        titleHe: n.titleHe,
        slug: n.slug,
        primaryUrl: v('url1'),
        secondaryUrl: v('url2'),
        platform: v('platform')
      }};
    }});
    var payload = {{
      schemaVersion: 1,
      exportType: 'eyal-purchase-links',
      exportTimestamp: new Date().toISOString(),
      respondent: respondent,
      books: books
    }};
    var blob = new Blob([JSON.stringify(payload, null, 2)], {{type: 'application/json;charset=utf-8'}});
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'eyal-purchase-links-' + new Date().toISOString().slice(0,10) + '.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(a.href);
  }});
}})();
</script>\n"""

    html += "</div>\n"
    html += foot(generated_iso)
    return html


def html_eyal_pending_block(eyal_pending: Optional[dict]) -> str:
    """מסלול עבודה + טבלת מידע חסר — לעמוד משימות והחלטות בלבד."""
    if not eyal_pending or not isinstance(eyal_pending, dict):
        return ""
    html = ""
    html += '<div class="card eyal-pending-intro">\n'
    html += f"<h2>{escape(eyal_pending.get('titleHe', 'מסלול עבודה לאייל'))}</h2>\n"
    if eyal_pending.get("introHe"):
        html += f'<p class="subtitle">{escape(eyal_pending["introHe"])}</p>\n'
    if eyal_pending.get("lockedSummaryHe"):
        html += (
            f'<p class="subtitle eyal-pending-locked">{escape(eyal_pending["lockedSummaryHe"])}</p>\n'
        )
    html += "<ol>\n"
    for step in eyal_pending.get("stepsHe") or []:
        if isinstance(step, str) and step.strip():
            html += f"<li>{escape(step.strip())}</li>\n"
    html += "</ol>\n"
    html += "</div>\n"

    items = eyal_pending.get("items") or []
    if items:
        html += "<h2>מידע חסר / צעדים הבאים</h2>\n"
        html += '<div class="table-wrap"><table class="data">\n'
        html += "<thead><tr><th>נושא</th><th>בעלים</th><th>איפה ב־Hub</th><th>הערה</th></tr></thead>\n<tbody>\n"
        for it in items:
            if not isinstance(it, dict):
                continue
            title = escape(str(it.get("titleHe", "")))
            owner = escape(str(it.get("owner", "")))
            note = escape(str(it.get("noteHe", "")))
            wh = _eyal_pending_where_html(
                str(it.get("hubAction", "")),
                str(it.get("decisionId", "")),
            )
            html += "<tr>"
            html += f"<td>{title}</td><td>{owner}</td><td>{wh}</td><td>{note}</td>"
            html += "</tr>\n"
        html += "</tbody></table></div>\n"
    return html


def _eyal_pending_where_html(hub_action: str, decision_id: str) -> str:
    ha = (hub_action or "").strip()
    if ha == "decision":
        return f'<a href="tasks.html">tasks.html</a> ({escape(decision_id)})' if decision_id else '<a href="tasks.html">tasks.html</a>'
    if ha == "content-intake":
        return '<a href="content-intake.html">content-intake.html</a>'
    if ha == "site-tree":
        return '<a href="site-tree.html">site-tree.html</a>'
    if ha == "drive-only":
        return "Drive / from-eyal / מאגר (אין קישור ישיר)"
    return escape(ha or "—")


def _intake_workflow_button_and_modal() -> str:
    """כפתור + מודל נוהלי קליטה ושליחה — פרומטים לסוכן עם כפתורי העתקה."""
    EYAL_PHONE = "972-524822842"

    PROMPT_INTAKE = (
        "קלוט תוכן חדש מאייל: "
        "סרוק את תיקיות Drive המסונכרנות (from-eyal/), "
        "עדכן את content-index.json, בנה Hub ופרסם ל-staging. "
        "החזר רשימת מה נקלט — כותרות בלבד, ללא פרטים טכניים."
    )

    PROMPT_SEND = (
        "שלח לאייל עמית עדכון על חומר שהועבר אליו ב-Drive. "
        "הכן הודעת וואטסאפ קצרה: שם החומר, שם התיקייה בDrive, הסבר משפטי אחד. "
        "מספר אייל: {phone}. "
        "אל תשלח קבצים — רק הודעת טקסט."
    ).format(phone=EYAL_PHONE)

    return f"""
<style>
#iw-btn {{
  display:inline-flex;align-items:center;gap:.55rem;
  background:var(--eyal-terracotta,#a44e2b);color:#fff;
  border:none;border-radius:7px;padding:.65rem 1.3rem;
  font-family:inherit;font-size:1rem;font-weight:700;
  cursor:pointer;margin:.75rem 0 1.1rem;letter-spacing:.01em;
  box-shadow:0 2px 8px rgba(164,78,43,.28);transition:background .15s;
}}
#iw-btn:hover{{background:#8c3e1f}}
#iw-overlay {{
  display:none;position:fixed;inset:0;background:rgba(46,43,40,.58);
  z-index:900;align-items:flex-start;justify-content:center;
  overflow-y:auto;padding:2.5rem 1rem;
}}
#iw-overlay.open{{display:flex}}
#iw-modal {{
  background:#fffdfb;border-radius:10px;padding:2rem 2rem 1.5rem;
  max-width:640px;width:100%;position:relative;
  box-shadow:0 8px 36px rgba(0,0,0,.2);direction:rtl;font-family:inherit;
}}
#iw-close {{
  position:absolute;top:.8rem;left:.8rem;background:none;border:none;
  font-size:1.4rem;cursor:pointer;color:#999;line-height:1;
  padding:.2rem .4rem;border-radius:4px;
}}
#iw-close:hover{{background:#f0ece6;color:#2e2b28}}
.iw-section{{margin:1.4rem 0 0;padding-top:1rem;border-top:1px solid #e8e0d5}}
.iw-section:first-of-type{{border-top:none;margin-top:.6rem;padding-top:0}}
.iw-section h3{{
  margin:0 0 .5rem;font-size:1rem;font-weight:700;
  color:var(--eyal-ink,#2e2b28);
}}
.iw-desc{{font-size:.9rem;color:#555;margin:0 0 .6rem;line-height:1.6}}
.iw-prompt-wrap{{
  background:#f5f1ec;border-radius:7px;padding:.7rem .8rem;
  border:1px solid #ddd6cc;position:relative;
}}
.iw-prompt-text{{
  font-size:.88rem;line-height:1.65;color:#3a3734;
  white-space:pre-wrap;word-break:break-word;margin:0;
  font-family:inherit;
}}
.iw-copy-btn{{
  margin-top:.55rem;background:var(--eyal-olive,#6e6f4a);color:#fff;
  border:none;border-radius:5px;padding:.35rem .85rem;
  font-size:.85rem;font-weight:600;cursor:pointer;font-family:inherit;
  transition:background .12s;
}}
.iw-copy-btn:hover{{background:#565740}}
.iw-copy-btn.copied{{background:#2e7d32}}
.iw-phone-row{{
  display:flex;align-items:center;gap:.6rem;margin:.5rem 0 .2rem;
}}
.iw-phone{{
  font-size:1rem;direction:ltr;font-weight:700;
  color:var(--eyal-chocolate,#5c3a2e);letter-spacing:.03em;
}}
.iw-note{{font-size:.82rem;color:#888;margin:.5rem 0 0;}}
.iw-links{{margin-top:1.2rem;font-size:.88rem;}}
.iw-links a{{margin-left:.9rem;color:var(--eyal-terracotta,#a44e2b);}}
</style>

<button id="iw-btn" type="button">&#9654;&nbsp; קליטה ושליחת תוכן</button>

<div id="iw-overlay" role="dialog" aria-modal="true" aria-labelledby="iw-modal-title">
<div id="iw-modal">
  <button id="iw-close" aria-label="סגור">&#x2715;</button>
  <h2 id="iw-modal-title" style="margin:0 0 .3rem;font-size:1.15rem">קליטה ושליחת תוכן</h2>
  <p style="font-size:.85rem;color:#888;margin:0">העתק את הפרומט הרלוונטי ושלח לסוכן — הוא יבצע ויחזיר מה חדש.</p>

  <div class="iw-section">
    <h3>📥 קליטה — אייל שלח תוכן חדש</h3>
    <p class="iw-desc">Drive מסנכרן אוטומטית. כשאייל מודיע — שלח לסוכן:</p>
    <div class="iw-prompt-wrap">
      <p class="iw-prompt-text" id="prompt-intake">{escape(PROMPT_INTAKE)}</p>
      <button class="iw-copy-btn" data-target="prompt-intake">העתק פרומט</button>
    </div>
    <p class="iw-note">הסוכן יסרוק, יעדכן אינדקס, יבנה Hub, יפרסם ל-staging, ויחזיר רשימת ״מה חדש״.</p>
  </div>

  <div class="iw-section">
    <h3>📤 שליחה — אנחנו שלחנו חומר לאייל</h3>
    <p class="iw-desc">לאחר העלאת הקבצים ל-Drive — שלח לסוכן להכנת הודעת וואטסאפ:</p>
    <div class="iw-prompt-wrap">
      <p class="iw-prompt-text" id="prompt-send">{escape(PROMPT_SEND)}</p>
      <button class="iw-copy-btn" data-target="prompt-send">העתק פרומט</button>
    </div>
    <div class="iw-phone-row">
      <span style="font-size:.85rem;color:#666">מספר אייל:</span>
      <span class="iw-phone">{escape(EYAL_PHONE)}</span>
      <button class="iw-copy-btn" data-copy="{escape(EYAL_PHONE)}" style="margin:0">העתק</button>
    </div>
    <p class="iw-note">אין צורך לשלוח קבצים — רק וואטסאפ עם שם הקובץ ושם התיקייה בDrive.</p>
  </div>

  <div class="iw-links">
    <a href="purchase-links.html">קישורי רכישה</a>
    <a href="content-index.html">אינדקס תוכן</a>
    <a href="content-intake.html">קליטת תוכן לעמוד</a>
  </div>
</div>
</div>

<script>
(function(){{
  var btn=document.getElementById('iw-btn');
  var overlay=document.getElementById('iw-overlay');
  var closeBtn=document.getElementById('iw-close');
  function openModal(){{overlay.classList.add('open');closeBtn.focus();}}
  function closeModal(){{overlay.classList.remove('open');btn.focus();}}
  btn.addEventListener('click',openModal);
  closeBtn.addEventListener('click',closeModal);
  overlay.addEventListener('click',function(e){{if(e.target===overlay)closeModal();}});
  document.addEventListener('keydown',function(e){{
    if(e.key==='Escape'&&overlay.classList.contains('open'))closeModal();
  }});
  function copyText(text,el){{
    var orig=el.textContent;
    function done(){{el.textContent='✓ הועתק';el.classList.add('copied');
      setTimeout(function(){{el.textContent=orig;el.classList.remove('copied');}},1800);}}
    if(navigator.clipboard){{navigator.clipboard.writeText(text).then(done).catch(function(){{
      var ta=document.createElement('textarea');ta.value=text;
      document.body.appendChild(ta);ta.select();document.execCommand('copy');
      document.body.removeChild(ta);done();
    }});}}else{{
      var ta=document.createElement('textarea');ta.value=text;
      document.body.appendChild(ta);ta.select();document.execCommand('copy');
      document.body.removeChild(ta);done();
    }}
  }}
  document.querySelectorAll('.iw-copy-btn').forEach(function(b){{
    b.addEventListener('click',function(){{
      if(b.dataset.copy){{copyText(b.dataset.copy,b);return;}}
      var el=document.getElementById(b.dataset.target||'');
      if(el)copyText(el.textContent||el.innerText||'',b);
    }});
  }});
}})();
</script>
"""


def page_index(
    updates: dict,
    roadmap: dict,
    tasks: dict,
    deliverables: Optional[dict],
    generated_iso: str,
    hub_version: str = DEFAULT_HUB_VIEW_VERSION,
) -> str:
    milestones = roadmap.get("milestones", [])
    done_count = sum(1 for m in milestones if m["status"] == "completed")
    total_count = len(milestones)

    all_tasks = []
    for sec in tasks.get("sections", []):
        all_tasks.extend(sec.get("tasks", []))
    tasks_done = sum(1 for t in all_tasks if t.get("status") == "completed")
    tasks_total = len(all_tasks)

    time_il, time_utc = format_build_time_displays(generated_iso)

    html = head("אייל עמית — ממשק מצב עבודה")
    html += nav("index")
    html += '<div class="wrap">\n'
    html += '<div class="hub-build-meta" role="status" aria-label="גרסה ומועד בנייה">\n'
    html += f'<p class="hub-build-meta__line"><span class="hub-build-meta__k">גרסת Hub</span> '
    html += f'<span class="hub-build-meta__v">{escape(hub_version)}</span></p>\n'
    html += '<p class="hub-build-meta__line"><span class="hub-build-meta__k">עדכון אחרון (בנייה)</span> '
    html += f'<time class="hub-build-meta__time" datetime="{escape(generated_iso)}">'
    html += f'{escape(time_il)} (שעון ישראל) · {escape(time_utc)} UTC'
    html += "</time></p>\n"
    html += "</div>\n"
    html += "<h1>אייל עמית — ממשק מצב עבודה</h1>\n"
    html += f'<p class="subtitle">{escape(roadmap.get("summaryHe", ""))}</p>\n'
    html += (
        f'<p class="subtitle"><a href="meeting-checklist.html">צ׳קליסט פגישה (החלטות לפי סדר)</a>'
        f' · <a href="tasks.html">משימות, ייצוא JSON</a>'
        f' · <a href="site-tree.html">עץ אתר</a>'
        f' · <a href="content-intake.html">קליטת תוכן</a>'
        f' · <a href="files/team40/ea-legacy-curated/gallery.html">גלריית מדיה לגסי</a></p>\n'
    )

    html += _intake_workflow_button_and_modal()

    html += '<div class="stats-row">\n'
    html += f'<div class="stat-card"><div class="stat-number">{done_count}/{total_count}</div><div class="stat-label">אבני דרך הושלמו</div></div>\n'
    html += f'<div class="stat-card"><div class="stat-number">{tasks_done}/{tasks_total}</div><div class="stat-label">משימות הושלמו</div></div>\n'

    current = roadmap.get("currentFocusId", "")
    current_ms = next((m for m in milestones if m["id"] == current), None)
    current_label = escape(current_ms["titleHe"]) if current_ms else "\u2014"
    html += f'<div class="stat-card"><div class="stat-number" style="font-size:1.2rem">{escape(current)}</div><div class="stat-label">מוקד נוכחי: {current_label}</div></div>\n'
    html += "</div>\n"

    html += (
        '<p class="subtitle index-scope-note">תמונת מצב כללית בכניסה. '
        '<strong>מסלול עבודה, מידע חסר והחלטות</strong> — ב־'
        '<a href="tasks.html">משימות והחלטות</a>.</p>\n'
    )

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
        html += "<ul class=\"deliverables-list\">\n"
        for it in deliverables_items_newest_first(deliverables):
            href = it.get("href") or "#"
            html += "<li>\n"
            html += (
                f'<a href="{escape(href)}">{escape(it.get("titleHe", ""))}</a> — '
                f'{escape(it.get("date", ""))} <span class="d-id">{escape(it.get("id", ""))}</span>\n'
            )
            if it.get("noteHe"):
                html += f'<div class="deliverable-note">{escape(it["noteHe"])}</div>\n'
            html += "</li>\n"
        html += "</ul>\n"

    html += html_mockup_index_sections()

    html += "</div>\n"
    html += foot(generated_iso)
    return html


M2_ROADMAP_TECHNICAL_GROUP_ORDER: list[str] = [
    "תשתית, תנאים וסביבה",
    "מבנה האתר בתוך WordPress",
    "תיעוד מפעיל, בדיקות וסגירה",
]

M2_ROADMAP_TECHNICAL_GROUP_BY_SECTION: dict[str, str] = {
    "M2-SEC-PLAN-G0G1": "תשתית, תנאים וסביבה",
    "M2-SEC-G2-STACK": "תשתית, תנאים וסביבה",
    "M2-SEC-G2-IA": "מבנה האתר בתוך WordPress",
    "M2-SEC-FORMS": "מבנה האתר בתוך WordPress",
    "M2-SEC-EYAL-DEV-BRIEF": "מבנה האתר בתוך WordPress",
    "M2-SEC-G3": "תיעוד מפעיל, בדיקות וסגירה",
    "M2-SEC-G4-QA": "תיעוד מפעיל, בדיקות וסגירה",
}


def html_roadmap_eyal_narrative(en: dict) -> str:
    if not en or not isinstance(en, dict) or not en.get("topics"):
        return ""
    html = '<section class="roadmap-eyal-track" aria-labelledby="roadmap-eyal-h">\n'
    html += f'<h2 id="roadmap-eyal-h">{escape(en.get("titleHe", "נטיב אייל"))}</h2>\n'
    if en.get("introHe"):
        html += f'<p class="roadmap-eyal-intro">{escape(en["introHe"])}</p>\n'
    for topic in en.get("topics") or []:
        if not isinstance(topic, dict):
            continue
        html += '<article class="roadmap-topic-card">\n'
        html += f'<h3 class="roadmap-topic-card__title">{escape(topic.get("titleHe", ""))}</h3>\n'
        if topic.get("timingHe"):
            html += f'<p class="roadmap-topic-card__timing"><strong>מתי:</strong> {escape(topic["timingHe"])}</p>\n'
        req = topic.get("requiredHe") or []
        if req:
            html += "<p><strong>מה נדרש ממך</strong></p>\n<ul>\n"
            for line in req:
                if isinstance(line, str) and line.strip():
                    html += f"<li>{escape(line.strip())}</li>\n"
            html += "</ul>\n"
        if topic.get("outcomeHe"):
            html += f'<p class="roadmap-topic-card__outcome"><strong>מה התוצאה:</strong> {escape(topic["outcomeHe"])}</p>\n'
        refs = topic.get("hubRefs") or []
        if refs:
            html += '<p class="roadmap-topic-card__refs"><strong>איפה ב־Hub:</strong> '
            parts = []
            for r in refs:
                if not isinstance(r, dict):
                    continue
                parts.append(f'<a href="{escape(r.get("href", "#"))}">{escape(r.get("labelHe", ""))}</a>')
            html += " · ".join(parts)
            html += "</p>\n"
        html += "</article>\n"
    html += "</section>\n"
    return html


def _render_focus_section_table(section: dict) -> str:
    html = '<div class="focus-section">\n'
    html += f"<h4 class=\"focus-section__title\">{escape(section['titleHe'])}</h4>\n"
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
    return html


def page_roadmap(roadmap: dict, generated_iso: str) -> str:
    milestones = roadmap.get("milestones", [])
    current_id = roadmap.get("currentFocusId", "")

    html = head("מפת דרכים — אייל עמית")
    html += nav("roadmap")
    html += '<div class="wrap">\n'
    html += "<h1>מפת דרכים</h1>\n"
    html += f'<p class="subtitle">{escape(roadmap.get("summaryHe", ""))}</p>\n'
    html += (
        '<p class="roadmap-dual-hint">שני מסלולים: <strong>נטיב אייל</strong> (תוכן ואישורים) '
        "ולמטה <strong>נטיב צוות</strong> (ביצוע טכני עם מזהי משימה).</p>\n"
    )

    html += "<h2>אבני דרך (סקירה)</h2>\n"
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

    html += html_roadmap_eyal_narrative(roadmap.get("eyalNarrative") or {})

    cob = roadmap.get("clientObligationsHe")
    if cob and isinstance(cob, list):
        html += '<details class="roadmap-obligations-more">\n'
        html += "<summary>תזכורת נוספת — רשימה קצרה (מסונכרנת למאגר)</summary>\n<ul>\n"
        for line in cob:
            if isinstance(line, str) and line.strip():
                html += f"<li>{escape(line.strip())}</li>\n"
        html += "</ul>\n"
        html += (
            "<p class=\"subtitle\">פירוט מלא: "
            "<code>docs/project/EYAL-CLIENT-OBLIGATIONS-BY-PHASE.md</code></p>\n"
        )
        html += "</details>\n"

    breakdown = roadmap.get("currentFocusBreakdown")
    if breakdown and breakdown.get("milestoneId") == current_id:
        html += '<section class="roadmap-technical-track" aria-labelledby="roadmap-tech-h">\n'
        html += '<h2 id="roadmap-tech-h">נטיב צוות — ביצוע טכני (פנימי)</h2>\n'
        html += f"<h3 class=\"roadmap-tech-milestone\">{escape(breakdown['titleHe'])}</h3>\n"
        html += f'<p class="roadmap-tech-intro">{escape(breakdown.get("introHe", ""))}</p>\n'
        html += (
            "<p class=\"subtitle\">מזהי <span class=\"d-id\">M2-T-*</span> למעקב צוות; "
            'לאייל: העיקר ב<a href="#roadmap-eyal-h">נטיב אייל</a> למעלה.</p>\n'
        )

        sections = breakdown.get("sections", [])
        by_group: dict[str, list] = {}
        for section in sections:
            sid = str(section.get("id", ""))
            g = M2_ROADMAP_TECHNICAL_GROUP_BY_SECTION.get(sid, "אחר")
            by_group.setdefault(g, []).append(section)

        for group_title in M2_ROADMAP_TECHNICAL_GROUP_ORDER:
            secs = by_group.get(group_title)
            if not secs:
                continue
            html += f'<div class="roadmap-tech-group">\n<h3 class="roadmap-tech-group__title">{escape(group_title)}</h3>\n'
            for section in secs:
                html += _render_focus_section_table(section)
            html += "</div>\n"

        for g_title, secs in by_group.items():
            if g_title in M2_ROADMAP_TECHNICAL_GROUP_ORDER:
                continue
            html += f'<div class="roadmap-tech-group">\n<h3 class="roadmap-tech-group__title">{escape(g_title)}</h3>\n'
            for section in secs:
                html += _render_focus_section_table(section)
            html += "</div>\n"

        html += "</section>\n"

    html += "</div>\n"
    html += foot(generated_iso)
    return html


MEETING_CHECKLIST_DECISION_ORDER: list[str] = [
    "D-EYAL-SITE-07",
    "D-EYAL-IA-MENU-08",
    "D-EYAL-HOME-01",
    "D-EYAL-CONTENT-MODEL-09",
    "D-EYAL-MENU-BRAND-10",
    "D-EYAL-EN-BODY-02",
    "D-EYAL-GALLERY-03",
    "D-EYAL-KMD-04",
    "D-EYAL-COURSES-05",
    "D-EYAL-ENTITY-CATALOG-12",
    "D-EYAL-GREEN-UX-06",
]


def split_options_for_display(options_he: str) -> list[str]:
    """מפרק מחרוזת אופציות (מפריד נפוץ ·) לרשימת שורות."""
    t = (options_he or "").strip()
    if not t:
        return []
    if " · " in t:
        return [x.strip() for x in t.split(" · ") if x.strip()]
    if " | " in t:
        return [x.strip() for x in t.split(" | ") if x.strip()]
    return [t]


def _html_meeting_decision_section(
    d: dict,
    step_i: Optional[int],
    step_total: Optional[int],
    *,
    reference_mode: bool = False,
) -> str:
    """בלוק צ׳קליסט לפריט החלטה אחד (פתוח או נעול לייחוס)."""
    did = d["id"]
    html = f'<section class="meeting-item{" meeting-item--reference" if reference_mode else ""}" id="{escape(did)}">\n'
    html += '<header class="meeting-item__header">\n'
    if step_i is not None and step_total is not None:
        html += f'<span class="meeting-item__num" aria-hidden="true">{step_i}</span>\n'
    else:
        html += (
            '<span class="meeting-item__num meeting-item__num--lockedref" aria-hidden="true" '
            'title="נעול">✓</span>\n'
        )
    html += '<div class="meeting-item__headtext">\n'
    if step_i is not None and step_total is not None:
        html += (
            f'<h2 class="meeting-item__title"><span class="meeting-item__step">שלב {step_i} מתוך {step_total}</span> '
            f'{escape(d.get("titleHe", ""))}</h2>\n'
        )
    else:
        html += f'<h2 class="meeting-item__title">{escape(d.get("titleHe", ""))}</h2>\n'
    html += f'<p class="meeting-item__id"><span class="d-id">{escape(did)}</span></p>\n'
    html += "</div>\n"
    html += "</header>\n"

    html += '<div class="meeting-panel">\n'
    html += '<h3 class="meeting-panel__h">הקשר</h3>\n'
    html += f'<div class="meeting-panel__body">{escape(d.get("contextHe", ""))}</div>\n'
    html += "</div>\n"

    opts = split_options_for_display(d.get("optionsHe", ""))
    html += '<div class="meeting-panel meeting-panel--options">\n'
    html += '<h3 class="meeting-panel__h">אופציות</h3>\n'
    html += '<ol class="meeting-options-list">\n'
    for opt in opts:
        html += f"<li>{escape(opt)}</li>\n"
    html += "</ol>\n"
    html += "</div>\n"

    html += '<div class="meeting-panel">\n'
    html += '<h3 class="meeting-panel__h">השלכות</h3>\n'
    html += f'<div class="meeting-panel__body">{escape(d.get("implicationsHe", ""))}</div>\n'
    html += "</div>\n"

    html += '<div class="meeting-panel meeting-panel--rec">\n'
    html += '<h3 class="meeting-panel__h">המלצת צוות</h3>\n'
    html += f'<div class="meeting-panel__body">{escape(d.get("recommendationHe", ""))}</div>\n'
    html += "</div>\n"

    if d.get("mockupHref"):
        html += (
            '<div class="meeting-mockup">'
            f'<a class="meeting-mockup__link" href="{escape(d["mockupHref"])}">פתח מוקאפ</a>'
            "</div>\n"
        )

    if d.get("status") == "deferred" and d.get("resolutionHe"):
        html += '<div class="meeting-panel meeting-panel--deferred">\n'
        html += '<h3 class="meeting-panel__h">סטטוס: נדחה לשלב מאוחר</h3>\n'
        html += f'<div class="meeting-panel__body">{escape(d["resolutionHe"])}</div>\n'
        html += "</div>\n"
        html += (
            '<div class="meeting-decision-line meeting-decision-line--locked" role="note">\n'
            "<p><strong>החלטה:</strong> רשומה למעלה — לא לפגישה כעת.</p>\n"
            "</div>\n"
        )
    elif d.get("status") == "approved" and d.get("resolutionHe"):
        html += '<div class="meeting-panel meeting-panel--locked">\n'
        html += '<h3 class="meeting-panel__h">סטטוס: נעול</h3>\n'
        html += f'<div class="meeting-panel__body">{escape(d["resolutionHe"])}</div>\n'
        html += "</div>\n"
        html += (
            '<div class="meeting-decision-line meeting-decision-line--locked" role="note">\n'
            "<p><strong>החלטה בפגישה:</strong> רשומה למעלה — אין צורך למלא שוב.</p>\n"
            "</div>\n"
        )
    else:
        html += '<div class="meeting-decision-line" role="region" aria-label="רישום החלטה בפגישה">\n'
        html += "<p><strong>החלטה בפגישה (לרשום בקצרה):</strong></p>\n"
        html += '<div class="meeting-decision-line__ruled" contenteditable="true" spellcheck="true"></div>\n'
        html += "</div>\n"

    html += "</section>\n"
    return html


def _html_meeting_supplement_section(it: dict, step_i: int, step_total: int) -> str:
    """פריט תוכן / חומר משלין (לא מזהה D-EYAL בטופס)."""
    sid = str(it.get("id", "supplement"))
    title = str(it.get("titleHe", ""))
    note = str(it.get("noteHe", ""))
    owner = str(it.get("owner", ""))
    hub_action = str(it.get("hubAction", ""))
    decision_id = str(it.get("decisionId", ""))
    where = _eyal_pending_where_html(hub_action, decision_id)

    html = f'<section class="meeting-item meeting-item--supplement" id="{escape(sid)}">\n'
    html += '<header class="meeting-item__header">\n'
    html += f'<span class="meeting-item__num meeting-item__num--supplement" aria-hidden="true">{step_i}</span>\n'
    html += '<div class="meeting-item__headtext">\n'
    html += (
        f'<h2 class="meeting-item__title"><span class="meeting-item__step">שלב {step_i} מתוך {step_total}</span> '
        f"{escape(title)}</h2>\n"
    )
    html += f'<p class="meeting-item__id"><span class="d-id">{escape(sid)}</span>'
    if owner:
        html += f' · בעלים: {escape(owner)}'
    html += "</p>\n"
    html += "</div>\n"
    html += "</header>\n"

    html += '<div class="meeting-panel">\n'
    html += '<h3 class="meeting-panel__h">מה נדרש</h3>\n'
    html += f'<div class="meeting-panel__body">{escape(note)}</div>\n'
    html += "</div>\n"

    html += '<div class="meeting-panel meeting-panel--where">\n'
    html += '<h3 class="meeting-panel__h">איפה מזינים אחרי הפגישה</h3>\n'
    html += f'<div class="meeting-panel__body meeting-panel__body--html">{where}</div>\n'
    html += "</div>\n"

    html += (
        '<div class="meeting-decision-line" role="region" aria-label="סיכום מה התקבל בפגישה">\n'
        "<p><strong>מה התקבל בפגישה (לרשום בקצרה):</strong></p>\n"
        '<div class="meeting-decision-line__ruled" contenteditable="true" spellcheck="true"></div>\n'
        "</div>\n"
    )
    html += "</section>\n"
    return html


def page_meeting_checklist(
    decisions_data: dict,
    generated_iso: str,
    eyal_pending: Optional[dict] = None,
) -> str:
    by_id = {d["id"]: d for d in decisions_data.get("decisions", []) if "id" in d}
    ordered: list[dict] = []
    for did in MEETING_CHECKLIST_DECISION_ORDER:
        if did in by_id:
            ordered.append(by_id[did])
    for d in decisions_data.get("decisions", []):
        if d["id"] not in MEETING_CHECKLIST_DECISION_ORDER:
            ordered.append(d)

    pending_list = [d for d in ordered if d.get("status") == "pending"]
    deferred_list = [d for d in ordered if d.get("status") == "deferred"]
    approved_list = [d for d in ordered if d.get("status") == "approved"]

    supplement_items: list[dict] = []
    for it in (eyal_pending or {}).get("items") or []:
        if not isinstance(it, dict):
            continue
        if (it.get("hubAction") or "").strip() == "decision":
            continue
        supplement_items.append(it)

    total_active = len(pending_list) + len(supplement_items)

    intro = decisions_data.get("meetingChecklistIntroHe", "")
    part_a = decisions_data.get("meetingChecklistPartAIntroHe", "")
    part_b = decisions_data.get("meetingChecklistPartBIntroHe", "")
    part_c = decisions_data.get("meetingChecklistPartCIntroHe", "")

    html = head("צ׳קליסט פגישה — מול אייל")
    html += nav("meeting-checklist")
    html += '<div class="wrap meeting-checklist-wrap">\n'
    html += "<h1>צ׳קליסט פגישה — מה עוד חסר מאייל</h1>\n"
    if intro:
        html += f'<p class="meeting-checklist-lead">{escape(intro)}</p>\n'
    html += (
        '<p class="subtitle meeting-checklist-tools">'
        '<a href="tasks.html">משימות והחלטות</a> (ייצוא JSON) · '
        '<a href="content-intake.html">קליטת תוכן</a> · '
        '<a href="site-tree.html">עץ אתר</a>'
        "</p>\n"
    )

    html += '<h2 class="meeting-checklist-section-h" id="part-a">חלק א׳ — החלטות שדורשות קלט בפגישה</h2>\n'
    if part_a:
        html += f'<p class="meeting-checklist-section-lead">{escape(part_a)}</p>\n'
    if not pending_list:
        html += (
            '<p class="meeting-checklist-section-lead">אין כרגע פריטים במצב «ממתין». '
            "נדחו — חלק ג׳; נעולות — חלק ד׳.</p>\n"
        )
    step_n = 1
    for d in pending_list:
        html += _html_meeting_decision_section(d, step_n, total_active if total_active else 1)
        step_n += 1

    html += '<h2 class="meeting-checklist-section-h" id="part-b">חלק ב׳ — תוכן וחומר משלים</h2>\n'
    if part_b:
        html += f'<p class="meeting-checklist-section-lead">{escape(part_b)}</p>\n'
    if not supplement_items:
        html += '<p class="meeting-checklist-section-lead">אין פריטי תוכן נוספים ברשימת ה־Hub — ראו eyal-pending.json.</p>\n'
    for it in supplement_items:
        html += _html_meeting_supplement_section(it, step_n, total_active if total_active else 1)
        step_n += 1

    if deferred_list:
        html += '<details class="meeting-locked-block meeting-locked-block--deferred">\n'
        html += (
            '<summary class="meeting-locked-block__summary">'
            "חלק ג׳ — נדחו לשלב מאוחר (ייחוס)</summary>\n"
        )
        html += (
            '<p class="meeting-checklist-section-lead meeting-checklist-section-lead--inside">'
            "לא דורש קלט בפגישה נוכחית.</p>\n"
        )
        for d in deferred_list:
            html += _html_meeting_decision_section(
                d, None, None, reference_mode=True
            )
        html += "</details>\n"

    html += '<details class="meeting-locked-block">\n'
    html += (
        '<summary class="meeting-locked-block__summary">'
        "חלק ד׳ — החלטות נעולות (ייחוס בלבד)</summary>\n"
    )
    if part_c:
        html += f'<p class="meeting-checklist-section-lead meeting-checklist-section-lead--inside">{escape(part_c)}</p>\n'
    for d in approved_list:
        html += _html_meeting_decision_section(
            d, None, None, reference_mode=True
        )
    html += "</details>\n"

    html += "</div>\n"
    html += foot(generated_iso)
    return html


def _html_task_page_decision_block(d: dict, ssot_answers: dict[str, dict]) -> str:
    did = d["id"]
    ssot = ssot_answers.get(did, {})
    if d.get("status") == "approved":
        effective_status = "approved"
    elif d.get("status") == "deferred":
        effective_status = "deferred"
    elif ssot.get("choice") or ssot.get("notes"):
        effective_status = "answered"
    else:
        effective_status = d.get("status", "pending")
    ssot_choice = ssot.get("choice", "")
    ssot_notes = ssot.get("notes", "")

    html = '<details class="decision-detail">\n'
    html += f'<summary><span class="d-id">{escape(did)}</span> {escape(d["titleHe"])} {status_html(effective_status)}</summary>\n'
    html += '<div class="decision-content">\n'
    html += f"<dt>הקשר</dt><dd>{escape(d.get('contextHe', ''))}</dd>\n"
    html += f"<dt>אפשרויות</dt><dd>{escape(d.get('optionsHe', ''))}</dd>\n"
    if d.get("implicationsHe"):
        html += f"<dt>משמעות</dt><dd>{escape(d['implicationsHe'])}</dd>\n"
    html += f"<dt>המלצה</dt><dd>{escape(d.get('recommendationHe', ''))}</dd>\n"
    if d.get("resolutionHe"):
        html += f"<dt>רזולוציה</dt><dd>{escape(d['resolutionHe'])}</dd>\n"
    if d.get("mockupHref"):
        html += f'<p><a href="{escape(d["mockupHref"])}">פתח מוקאפ</a></p>\n'

    html += f'<div class="feedback-field"><label for="choice-{escape(did)}">בחירה</label>'
    html += f'<input type="text" id="choice-{escape(did)}" value="{escape(ssot_choice)}" placeholder="הקלד בחירה..."></div>\n'

    html += f'<div class="feedback-field"><label for="notes-{escape(did)}">הערות</label>'
    html += f'<textarea id="notes-{escape(did)}" placeholder="הערות נוספות...">{escape(ssot_notes)}</textarea></div>\n'

    html += "</div>\n</details>\n"
    return html


def page_tasks(
    tasks_data: dict,
    decisions_data: dict,
    ssot_answers: dict[str, dict],
    generated_iso: str,
    eyal_pending: Optional[dict] = None,
) -> str:
    decisions = decisions_data.get("decisions", [])
    decision_ids = [d["id"] for d in decisions]
    pending_decisions = [d for d in decisions if d.get("status") == "pending"]
    deferred_decisions = [d for d in decisions if d.get("status") == "deferred"]
    locked_decisions = [d for d in decisions if d.get("status") == "approved"]

    scripts = '<script src="assets/feedback.js"></script>'
    html = head("משימות והחלטות — אייל עמית")
    html += nav("tasks")
    html += '<div class="wrap">\n'
    html += "<h1>משימות והחלטות</h1>\n"
    html += html_eyal_pending_block(eyal_pending)

    for section in tasks_data.get("sections", []):
        html += f"<h2>{escape(section['titleHe'])}</h2>\n"
        for task in section.get("tasks", []):
            priority = task.get("priorityHe", "")
            priority_html = PRIORITY_BADGE.get(priority, "")
            html += '<div class="task-row">\n'
            html += f'<div class="task-title">{status_html(task.get("status", "not_started"))} {escape(task["titleHe"])} {priority_html}</div>\n'
            html += f'<div class="task-state">{escape(task.get("stateHe", ""))}</div>\n'
            html += "</div>\n"

    html += "<h2>החלטות — דורשות קלט או אישור נוסף</h2>\n"
    if decisions_data.get("introHe"):
        html += f'<p class="subtitle">{escape(decisions_data["introHe"])}</p>\n'
    if not pending_decisions:
        html += (
            '<p class="subtitle">אין כרגע החלטות בסטטוס «ממתין» בקובץ הנתונים — '
            "ראו מקטעים למטה (נדחו / נעול).</p>\n"
        )
    for d in pending_decisions:
        html += _html_task_page_decision_block(d, ssot_answers)

    if deferred_decisions:
        html += "<h2>החלטות — נדחו לשלב מאוחר</h2>\n"
        html += (
            '<p class="subtitle">לא דורשות קלט כעת; רזולוציה למטה בכל פריט.</p>\n'
        )
        for d in deferred_decisions:
            html += _html_task_page_decision_block(d, ssot_answers)

    html += "<h2>החלטות נעולות (ייחוס)</h2>\n"
    html += (
        '<p class="subtitle">אושרו ונסגרו; השדות למטה לייצוא היסטוריית תשובות אם נדרש.</p>\n'
    )
    for d in locked_decisions:
        html += _html_task_page_decision_block(d, ssot_answers)

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
            suf = f.suffix.lower()
            if suf not in (".docx", ".txt", ".pdf"):
                if suf == ".zip" and "CONTENT" in f.parts:
                    pass
                else:
                    continue
            rel = f.relative_to(base)
            dest = dest_root / base.name / rel
            dest.parent.mkdir(parents=True, exist_ok=True)
            shutil.copy2(f, dest)


def copy_team40_legacy_curated(repo_root: Path, dist_dir: Path, skip: bool) -> None:
    """מעתיק קטלוג מדיה לגסי (גלריה + JSON + media/) ל־dist/files/team40/ea-legacy-curated/."""
    if skip:
        print(
            "[INFO] Skipping team40 legacy curated (--skip-team40-legacy-media)",
            flush=True,
        )
        return
    src = repo_root / "_communication" / "team_40" / "ea-legacy-curated-2026-04-11"
    if not src.is_dir():
        print(f"[WARN] Legacy curated folder missing (skip): {src}", flush=True)
        return
    dest = dist_dir / "files" / "team40" / "ea-legacy-curated"
    dest.parent.mkdir(parents=True, exist_ok=True)
    if dest.exists():
        shutil.rmtree(dest)
    shutil.copytree(src, dest)
    print(f"[INFO] Copied legacy media catalog → {dest.relative_to(dist_dir)}", flush=True)


def copy_hub_reference_files(repo_root: Path, dist_dir: Path) -> None:
    """מסמכי מקור מהמאגר (Markdown וכו׳) ל־dist/files/reference/ — קישור מ־deliverables."""
    pairs = [
        (
            "_communication/team_100/DELTA-EYAL-DEV-BRIEF-GEO-AEO-SEO-VS-SSOT-2026-04-10.md",
            "DELTA-EYAL-DEV-BRIEF-GEO-AEO-SEO-VS-SSOT-2026-04-10.md",
        ),
    ]
    dest_dir = dist_dir / "files" / "reference"
    dest_dir.mkdir(parents=True, exist_ok=True)
    for rel, name in pairs:
        src = repo_root / rel
        if src.is_file():
            shutil.copy2(src, dest_dir / name)
            print(f"[INFO] Copied reference → files/reference/{name}", flush=True)
        else:
            print(f"[WARN] Missing reference file (skip): {src}", flush=True)


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

    poc_src = SRC_DIR / "mockups/poc"
    if poc_src.is_dir():
        poc_dest = dest / "poc"
        poc_dest.mkdir(parents=True, exist_ok=True)
        for f in poc_src.iterdir():
            if f.is_file():
                shutil.copy2(f, poc_dest / f.name)
            elif f.is_dir():
                shutil.copytree(f, poc_dest / f.name)


def build(dist_dir: Path, mirror_docs_flag: bool, skip_team40_legacy: bool = False) -> None:
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
    eyal_pending = load_json_optional(DATA_DIR / "eyal-pending.json")
    hub_ver = hub_view_version(DATA_DIR / "hub-version.json")
    site_tree = enrich_site_tree_page_refs(load_json(DATA_DIR / "site-tree.json"))
    page_templates = load_json(DATA_DIR / "page-templates.json")
    legacy_unmapped = load_json_optional(DATA_DIR / "legacy-unmapped.json")
    content_index = load_json_optional(DATA_DIR / "content-index.json")
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
    copy_hub_reference_files(root, dist_dir)
    copy_team40_legacy_curated(root, dist_dir, skip_team40_legacy)
    if mirror_docs_flag:
        mirror_docs(eyal_ceo, dist_dir)

    inc_src = SRC_DIR / "incoming"
    if inc_src.is_dir():
        inc_dest = dist_dir / "incoming"
        shutil.copytree(inc_src, inc_dest)

    (dist_dir / "index.html").write_text(
        page_index(
            updates,
            roadmap,
            tasks,
            deliverables,
            generated_iso,
            hub_ver,
        ),
        encoding="utf-8",
    )
    (dist_dir / "roadmap.html").write_text(page_roadmap(roadmap, generated_iso), encoding="utf-8")
    (dist_dir / "meeting-checklist.html").write_text(
        page_meeting_checklist(decisions, generated_iso, eyal_pending), encoding="utf-8"
    )
    (dist_dir / "site-tree.html").write_text(
        page_site_tree(site_tree, page_templates, legacy_unmapped, generated_iso), encoding="utf-8"
    )
    (dist_dir / "content-intake.html").write_text(
        page_content_intake(site_tree, page_templates, generated_iso), encoding="utf-8"
    )
    (dist_dir / "purchase-links.html").write_text(
        page_purchase_links(site_tree, generated_iso), encoding="utf-8"
    )
    if content_index:
        (dist_dir / "content-index.html").write_text(
            page_content_index(content_index, generated_iso), encoding="utf-8"
        )
    (dist_dir / "tasks.html").write_text(
        page_tasks(tasks, decisions, ssot_answers, generated_iso, eyal_pending), encoding="utf-8"
    )
    (dist_dir / "pending.html").write_text(page_pending_redirect(), encoding="utf-8")

    (dist_dir / "robots.txt").write_text("User-agent: *\nDisallow: /\n", encoding="utf-8")

    metadata = {
        "generatedAt": generated_iso,
        "hubVersion": hub_ver,
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
        "content-index.json",
        "eyal-pending.json",
        "hub-version.json",
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
    parser.add_argument(
        "--skip-team40-legacy-media",
        action="store_true",
        help="Do not copy _communication/team_40/ea-legacy-curated-* to dist/files/team40/",
    )
    args = parser.parse_args()

    out = Path(args.out) if args.out else DEFAULT_DIST
    build(
        out,
        mirror_docs_flag=bool(args.mirror_docs or args.mirror_docx),
        skip_team40_legacy=bool(args.skip_team40_legacy_media),
    )
