#!/usr/bin/env python3
"""Emit WordPress WXR 1.2 seed for M2 shell pages (team 10). Run from repo root."""

from __future__ import annotations

from pathlib import Path

OUT = Path(__file__).resolve().parent.parent / "site" / "exports" / "m2-pages-seed.wxr"
BASE = "https://eyalamit-co-il-2026.s887.upress.link"

# (post_id, title, slug, parent_id, body_he)
PAGES: list[tuple[int, str, str, int, str]] = [
    (500, "בית", "home", 0, "עמוד בית — placeholder ל־M2."),
    (501, "השיטה", "hashita", 0, "תוכן יגיע לפי אפיון — placeholder."),
    (502, "שירותים", "services", 0, "עמוד הורה לשירותים — placeholder."),
    (503, "שיעורי דיג'רידו / נגינה", "didgeridoo-lessons", 502, "שירות — placeholder."),
    (504, "טיפול בדיג'רידו / נשימה", "didgeridoo-treatment-breath", 502, "שירות — placeholder."),
    (505, "סאונד הילינג / מדיטציית דיג'רידו", "sound-healing", 502, "שירות — placeholder."),
    (506, "סדנאות", "workshops", 502, "שירות — placeholder."),
    (507, "תיקון וחידוש כלים", "instrument-repair", 502, "שירות — placeholder."),
    (508, "כלים בעבודת יד ואביזרים", "handmade-instruments", 502, "מידע + קישור סליקה חיצונית — placeholder."),
    (509, "הרצאות", "lectures", 502, "שירות — placeholder."),
    (510, "אייל עמית", "eyal-amit", 0, "אודות — placeholder."),
    (511, "בלוג", "blog", 0, "ארכיון בלוג — placeholder."),
    (512, "המלצות ומדיה", "testimonials-media", 0, "placeholder."),
    (513, "ספרים", "books", 0, "placeholder."),
    (514, "הכשרות למטפלים", "therapist-training", 0, "יעלה בקרוב — placeholder."),
    (515, "צור קשר", "contact", 0, "טופס יוגדר בתוסף טפסים — placeholder."),
    (516, "הופעות / מורשת מופע", "shows-heritage", 0, "ניווט משני — placeholder."),
    (517, "כתבות היסטוריות", "historical-articles", 0, "אופציונלי — placeholder."),
    (518, "English", "en", 0, "EN landing — placeholder."),
    (519, "הצהרת נגישות", "accessibility-statement", 0, "placeholder."),
    (520, "תקנון", "terms", 0, "placeholder."),
    (521, "עמוד קטלוג ראשי", "shop", 0, "קטלוג ראשי — שימור slug shop לפי §7 M2."),
    (522, "מוקש דהימן — לזכרו", "moked-dehiman", 510, "עמוד ייעודי — placeholder; 301 מ־legacy במיגרציה."),
    (523, "תודה", "thank-you", 0, "דף תודה אחרי טפסים — אם בשימוש."),
    (524, "קורסים — בקרוב", "courses-soon", 0, "פנימי ל־T3 עד קישור סקולר אמיתי (F11-b)."),
]


def item_block(
    post_id: int,
    title: str,
    slug: str,
    parent: int,
    body: str,
) -> str:
    link = f"{BASE}/{slug}/"
    guid = f"{BASE}/?p={post_id}"
    return f"""	<item>
		<title><![CDATA[{title}]]></title>
		<link>{link}</link>
		<pubDate>Tue, 01 Apr 2026 12:00:00 +0000</pubDate>
		<dc:creator><![CDATA[admin]]></dc:creator>
		<guid isPermaLink="false">{guid}</guid>
		<description></description>
		<content:encoded><![CDATA[<p>{body}</p>]]></content:encoded>
		<excerpt:encoded><![CDATA[]]></excerpt:encoded>
		<wp:post_id>{post_id}</wp:post_id>
		<wp:post_date>2026-04-01 12:00:00</wp:post_date>
		<wp:post_date_gmt>2026-04-01 12:00:00</wp:post_date_gmt>
		<wp:comment_status>closed</wp:comment_status>
		<wp:ping_status>closed</wp:ping_status>
		<wp:post_name>{slug}</wp:post_name>
		<wp:status>publish</wp:status>
		<wp:post_parent>{parent}</wp:post_parent>
		<wp:menu_order>0</wp:menu_order>
		<wp:post_type>page</wp:post_type>
		<wp:post_password></wp:post_password>
		<wp:is_sticky>0</wp:is_sticky>
	</item>
"""


def main() -> None:
    parts = [
        '<?xml version="1.0" encoding="UTF-8" ?>',
        '<rss version="2.0"',
        '\txmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"',
        '\txmlns:content="http://purl.org/rss/1.0/modules/content/"',
        '\txmlns:wfw="http://wellformedweb.org/CommentAPI/"',
        '\txmlns:dc="http://purl.org/dc/elements/1.1/"',
        '\txmlns:wp="http://wordpress.org/export/1.2/"',
        ">",
        "<channel>",
        f"\t<title><![CDATA[Eyal Amit M2 page seed]]></title>",
        f"\t<link>{BASE}</link>",
        "\t<description><![CDATA[M2 shell — team 10]]></description>",
        "\t<pubDate>Tue, 01 Apr 2026 12:00:00 +0000</pubDate>",
        "\t<language>he-IL</language>",
        "\t<wp:wxr_version>1.2</wp:wxr_version>",
        f"\t<wp:base_site_url>{BASE}</wp:base_site_url>",
        f"\t<wp:base_blog_url>{BASE}</wp:base_blog_url>",
    ]
    for row in PAGES:
        parts.append(item_block(*row))
    parts.append("</channel>")
    parts.append("</rss>")
    OUT.parent.mkdir(parents=True, exist_ok=True)
    OUT.write_text("\n".join(parts) + "\n", encoding="utf-8")
    print(f"Wrote {OUT}")


if __name__ == "__main__":
    main()
