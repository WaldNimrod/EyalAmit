#!/usr/bin/env python3
"""
WP-W2-07 — Build the QR-page seed-data PHP file from the team_40 content export.

Reads  : _COMMUNICATION/team_40/W2-07-QR-CONTENT-EXPORT-2026-05-28.json (48 pages)
Writes : site/wp-content/mu-plugins/ea-w2-07-qr-content-data.php
         (a `return array(...)` map slug => [title, html] consumed by the seeder)

Migration rules (1:1 text migration; layout/embed normalisation only):
  - Strip WPBakery layout shortcodes: [vc_row] [vc_column] [vc_column_text]
    [vc_empty_space] and their closers.
  - [vc_video link="URL"]            -> responsive YouTube/Vimeo/FB embed (iframe),
                                        else a plain external link (new tab).
  - [caption ...]<img ...>txt[/caption] -> the inner content unwrapped (figure-less);
                                        images then follow the <img> rules below.
  - [envira-gallery id=".."]          -> removed (legacy gallery; no source).
  - <img src=http://localhost:9090/wp-content/uploads/REL>:
        REL present in the legacy uploads dir  -> rewrite src to the rehosted
            relative path  wp-content/uploads/ea-legacy/qr/<basename>
        REL absent                              -> the <img> tag is removed
            (surrounding text preserved). Tracked as OMITTED.
  - external <img> (flickr/mongabay)  -> rewrite to the rehosted relative path
        wp-content/uploads/ea-legacy/qr/<rehost-name> (downloaded by deploy step).

Also emits a JSON resolution report to scripts/_w2_07_image_resolution.json so the
build report can table every image.
"""
from __future__ import annotations

import json
import os
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SRC = ROOT / "_COMMUNICATION" / "team_40" / "W2-07-QR-CONTENT-EXPORT-2026-05-28.json"
OUT_PHP = ROOT / "site" / "wp-content" / "mu-plugins" / "ea-w2-07-qr-content-data.php"
OUT_REPORT = ROOT / "scripts" / "_w2_07_image_resolution.json"
LEGACY_UPLOADS = Path("/Users/nimrod/Documents/Eyal Amit/eyalamit.co.il-legacy/wp-content/uploads")

REHOST_DIR = "wp-content/uploads/ea-legacy/qr"

# External URL -> rehosted basename (downloaded by the deploy step).
EXTERNAL_MAP = {
    "http://photos.mongabay.com/06/braz_defor_88-05-lrg.jpg": "mongabay_braz_defor_88-05.jpg",
    "http://farm3.static.flickr.com/2493/4030994475_0e448a9a2a_o.jpg": "flickr_4030994475.jpg",
    "http://farm3.static.flickr.com/2802/4030995601_b810dc2be2_o.jpg": "flickr_4030995601.jpg",
    "http://farm3.static.flickr.com/2489/4030994831_f2580f6cd5_o.jpg": "flickr_4030994831.jpg",
    "http://farm4.static.flickr.com/3269/4030995255_41e95c43d0_o.jpg": "flickr_4030995255.jpg",
    "http://farm3.static.flickr.com/2656/4030995031_e867ff2aec_o.jpg": "flickr_4030995031.jpg",
    "http://farm3.static.flickr.com/2738/4031748522_e19ab1e48e_o.jpg": "flickr_4031748522.jpg",
}

resolution = []  # rows: qr, src, kind, disposition, rehost_path


def yt_id(url: str) -> str | None:
    m = re.search(r"(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([A-Za-z0-9_-]{6,})", url)
    return m.group(1) if m else None


def vimeo_id(url: str) -> str | None:
    m = re.search(r"vimeo\.com/(\d+)", url)
    return m.group(1) if m else None


def render_video(url: str) -> str:
    url = url.strip()
    yid = yt_id(url)
    if yid:
        return (
            '<div class="ea-qr-embed ea-qr-embed--video">'
            f'<iframe src="https://www.youtube.com/embed/{yid}" '
            'title="YouTube video" loading="lazy" frameborder="0" '
            'allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" '
            'allowfullscreen></iframe></div>'
        )
    vid = vimeo_id(url)
    if vid:
        return (
            '<div class="ea-qr-embed ea-qr-embed--video">'
            f'<iframe src="https://player.vimeo.com/video/{vid}" '
            'title="Vimeo video" loading="lazy" frameborder="0" '
            'allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>'
        )
    # Fallback (e.g. facebook video) -> external link, new tab.
    return (
        '<p class="ea-qr-embed ea-qr-embed--link">'
        f'<a href="{url}" target="_blank" rel="noopener noreferrer">צפייה בסרטון ↗</a></p>'
    )


def rewrite_img(tag: str, qr: int) -> str:
    m = re.search(r'src="([^"]+)"', tag)
    if not m:
        return ""
    src = m.group(1)
    alt_m = re.search(r'alt="([^"]*)"', tag)
    alt = alt_m.group(1) if alt_m else ""

    # Already-rehosted img (produced by the Flash-object step) -> keep as-is.
    if f"/{REHOST_DIR}/" in src:
        return tag

    if "localhost:9090" in src and "/wp-content/uploads/" in src:
        rel = src.split("/wp-content/uploads/", 1)[1]
        if (LEGACY_UPLOADS / rel).is_file():
            base = os.path.basename(rel)
            new = f"/{REHOST_DIR}/{base}"
            resolution.append({"qr": qr, "src": src, "kind": "legacy-uploads",
                               "disposition": "rehosted", "rehost": new})
            return f'<img class="ea-qr-img" src="{new}" alt="{alt}" loading="lazy" />'
        resolution.append({"qr": qr, "src": src, "kind": "legacy-uploads",
                           "disposition": "OMITTED (source absent)", "rehost": ""})
        return ""

    if src in EXTERNAL_MAP:
        new = f"/{REHOST_DIR}/{EXTERNAL_MAP[src]}"
        resolution.append({"qr": qr, "src": src, "kind": "external",
                           "disposition": "rehosted (downloaded)", "rehost": new})
        return f'<img class="ea-qr-img" src="{new}" alt="{alt}" loading="lazy" />'

    # Unknown external (shouldn't happen) -> omit, flag.
    resolution.append({"qr": qr, "src": src, "kind": "external-unknown",
                       "disposition": "OMITTED (unmapped)", "rehost": ""})
    return ""


def replace_flash_object(block: str, qr: int) -> str:
    """Legacy Flickr Flash slideshow <object>...</object> -> rehosted <img>s."""
    urls = []
    for u in re.findall(r'value="([^"]+\.jpg)"', block) + re.findall(r'src="([^"]+\.jpg)"', block):
        if u in EXTERNAL_MAP and u not in urls:
            urls.append(u)
    if not urls:
        resolution.append({"qr": qr, "src": "(flash-object)", "kind": "flash",
                           "disposition": "OMITTED (no mapped image)", "rehost": ""})
        return ""
    out = []
    for u in urls:
        new = f"/{REHOST_DIR}/{EXTERNAL_MAP[u]}"
        resolution.append({"qr": qr, "src": u, "kind": "external-flash",
                           "disposition": "rehosted (downloaded)", "rehost": new})
        out.append(f'<img class="ea-qr-img" src="{new}" alt="" loading="lazy" />')
    return "".join(out)


def clean_body(html: str, qr: int) -> str:
    # 0. legacy Flickr Flash slideshows -> rehosted <img>s
    html = re.sub(r'<object\b.*?</object>',
                  lambda m: replace_flash_object(m.group(0), qr), html, flags=re.DOTALL)
    # any stray <embed> not inside an <object>
    html = re.sub(r'<embed\b[^>]*>', "", html)

    # 1. vc_video -> embed
    html = re.sub(r'\[vc_video[^\]]*\blink="([^"]+)"[^\]]*\]',
                  lambda m: render_video(m.group(1)), html)
    html = re.sub(r'\[vc_video[^\]]*\]', "", html)  # any without link

    # 2. caption -> unwrap (keep inner img + text)
    html = re.sub(r'\[caption[^\]]*\]', "", html)
    html = re.sub(r'\[/caption\]', "", html)

    # 3. envira gallery -> drop
    html = re.sub(r'\[envira-gallery[^\]]*\]', "", html)

    # 4. images
    html = re.sub(r'<img[^>]*>', lambda m: rewrite_img(m.group(0), qr), html)

    # 5. strip remaining WPBakery layout shortcodes
    html = re.sub(r'\[/?vc_[a-z_]+[^\]]*\]', "", html)
    html = re.sub(r'\[/?vc_[a-z_]+\]', "", html)

    # 5b. legacy internal links http://localhost:9090/PATH -> site-relative /PATH
    #     (never leave a dead localhost URL live; these resolve on the new host).
    html = re.sub(r'https?://localhost:9090(/[^"\'\s]*)', r'\1', html)

    # 6. tidy: collapse 3+ newlines, drop empty <p> </p>
    html = re.sub(r'<p>\s*</p>', "", html)
    html = re.sub(r'\n{3,}', "\n\n", html).strip()
    return html


def main() -> None:
    data = json.loads(SRC.read_text(encoding="utf-8"))
    pages = {}
    for p in data:
        slug = p["slug"]            # e.g. "qr/qr1"
        title = p["title"].strip()
        body = clean_body(p["body_html"], p["qr_n"])
        pages[slug] = {"title": title, "html": body, "qr_n": p["qr_n"]}

    # Emit PHP data file.
    lines = ["<?php", "/**",
             " * WP-W2-07 — QR page seed data (generated by scripts/build_w2_07_qr_data.py).",
             " * DO NOT EDIT BY HAND. Regenerate from the team_40 content export.",
             " * Map: child-slug => array( 'title' => str, 'html' => str ).",
             " */", "defined( 'ABSPATH' ) || exit;", "", "return array("]
    for slug in sorted(pages, key=lambda s: pages[s]["qr_n"]):
        child = slug.split("/", 1)[1]   # "qr1"
        title = pages[slug]["title"].replace("'", "\\'")
        html = pages[slug]["html"].replace("\\", "\\\\").replace("'", "\\'")
        lines.append(f"\t'{child}' => array(")
        lines.append(f"\t\t'title' => '{title}',")
        lines.append(f"\t\t'html'  => '{html}',")
        lines.append("\t),")
    lines.append(");")
    OUT_PHP.write_text("\n".join(lines) + "\n", encoding="utf-8")

    OUT_REPORT.write_text(json.dumps(resolution, ensure_ascii=False, indent=2), encoding="utf-8")

    rehosted = sum(1 for r in resolution if "rehosted" in r["disposition"])
    omitted = sum(1 for r in resolution if "OMITTED" in r["disposition"])
    print(f"Wrote {OUT_PHP.relative_to(ROOT)} ({len(pages)} pages)")
    print(f"Image refs: {len(resolution)} | rehosted: {rehosted} | omitted: {omitted}")


if __name__ == "__main__":
    main()
