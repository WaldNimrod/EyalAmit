#!/usr/bin/env python3
"""M-09 data prep: hash all media, dedupe by content, cross-reference the slot picker."""
import hashlib
import html
import json
import re
from pathlib import Path
from collections import defaultdict

REPO = Path("/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026")
DIST = REPO / "hub" / "dist"
THEME_SRC = REPO / "site" / "wp-content" / "themes" / "ea-eyalamit"
MU_SRC = REPO / "site" / "wp-content" / "mu-plugins"

# Nimrod, 2026-09-16: three groups, explicitly separated, each with a scope rule
# he gave directly (not inferred):
#   old-site   -> already-filtered legacy media. Approved as-is, no rework.
#   aviv       -> the "ea-dok-web-thumbs" collection. Confirmed by cross-checking
#                 _COMMUNICATION/team_110/build/gallery-eyal/README.txt (582 "DOK-WEB"
#                 photos, byte-identical by sha256 spot-check) against every detail
#                 he gave: new, high-quality, arrived via Drive in one day, not from
#                 the old site, already shown to Eyal in a prior gallery.
#   live-theme -> site-theme-images, but ONLY files actually referenced by path in
#                 the current theme + mu-plugins source (259 of 291) — he explicitly
#                 excluded the other 32 ("additional suggestions ... not relevant"),
#                 which are staged candidate galleries (chapters/kushi/kush-0N.*,
#                 chapters/tsva/tsva-0N.*, chapters/vekatavta/veka-0N.*) plus unused
#                 mokesh/kushi extras, never wired into any template.
ROOTS = [
    ("old-site", DIST / "files" / "team40" / "ea-legacy-curated" / "media"),
    ("aviv", DIST / "files" / "team40" / "ea-dok-web-thumbs"),
    ("live-theme", DIST / "files" / "team40" / "site-theme-images"),
]

GROUP_LABELS_HE = {
    "old-site": "אתר ישן",
    "aviv": "חבילת אביב",
    "live-theme": "משולב באתר כרגע",
}

# Nimrod, 2026-09-16: "כל העמודים הקיימים בתפריט הראשי" — pulled live from the
# rendered <nav> on the actual site (including dropdown children), not from
# hub/data/site-tree.json, which turned out to be a stale, hand-annotated
# planning doc (41 nodes, "לא בתפריט ראשי" notes baked into free-text fields —
# not a live reflection of the current menu). Excludes "קורסים" (href="#", no
# real page yet, frozen per WAIT-WAVE) and "מבצעים" (a same-page anchor on
# /books/, not a separate page).
MAIN_MENU_PAGES = [
    ("בית", "/"),
    ("אודות אייל", "/eyal-amit/"),
    ("מוקש דהימן — לזכרו", "/eyal-amit/mokesh-dahiman/"),
    ("טיפול בדיג'רידו", "/treatment/"),
    ("השיטה", "/method/"),
    ("שיעורי דיג'רידו", "/lessons/"),
    ("סאונד הילינג", "/sound-healing/"),
    ("הכשרות למטפלים", "/learning/therapist-training/"),
    ("הרצאות", "/learning/lectures/"),
    ("סדנאות", "/learning/workshops/"),
    ("כלים ואביזרים (שער)", "/shop/"),
    ("תיקון וחידוש כלים", "/repair/"),
    ("כלי דיג'רידו למכירה", "/didgeridoos/"),
    ("תיקים לדיג'רידו", "/bags/"),
    ("סטנדים לאחסון דיג'רידו", "/stands-storage/"),
    ("סטנד רצפתי לנגינה", "/stand-floor/"),
    ("ספרים (שער)", "/books/"),
    ("צבע בכחול וזרוק לים", "/books/tsva-bekahol/"),
    ("כושי בלאנטיס", "/books/kushi-blantis/"),
    ("וכתבת", "/books/vekatavta/"),
    ("בלוג דיג'רידו", "/blog/"),
    ("דיג׳רידו, נחירות ודום נשימה בשינה", "/snoring-sleep-apnea/"),
    ("צור קשר", "/contact/"),
    ("EN", "/en/"),
]

# slot-picker "page" string -> canonical title above. All 10 verified to map
# cleanly (checked by hand, not fuzzy-matched — only 10 to check).
SLOT_PAGE_TO_CANONICAL = {
    "בית - פרקים.html": "בית",
    "אודות - פרקים.html": "אודות אייל",
    "Memorial - Mokesh (elevated).html": "מוקש דהימן — לזכרו",
    "טיפול - פרקים.html": "טיפול בדיג'רידו",
    "השיטה - פרקים.html": "השיטה",
    "שיעורים - פרקים.html": "שיעורי דיג'רידו",
    "סאונד הילינג - פרקים.html": "סאונד הילינג",
    "בלוג - פרקים.html": "בלוג דיג'רידו",
    "צור קשר - פרקים.html": "צור קשר",
    "Book - Kushi Blantis.html": "כושי בלאנטיס",
}

IMG_EXT = {".jpg", ".jpeg", ".png", ".gif", ".webp", ".tif", ".tiff"}


def find_live_theme_used_files(images_dir: Path) -> set[str]:
    """Relative paths (posix, under images_dir) actually referenced by literal
    string in theme/mu-plugin source. No glob()/scandir() dynamic loading exists
    in this theme (checked), so a literal-string scan is exhaustive, not a guess."""
    src_exts = {".php", ".css", ".js", ".json", ".html"}
    blob_parts = []
    for root in (THEME_SRC, MU_SRC):
        if not root.is_dir():
            continue
        for p in root.rglob("*"):
            if p.is_file() and p.suffix.lower() in src_exts and images_dir not in p.parents:
                try:
                    blob_parts.append(p.read_text(encoding="utf-8", errors="ignore"))
                except Exception:
                    pass
    blob = "\n".join(blob_parts)
    used = set()
    for p in images_dir.rglob("*"):
        if p.is_file():
            rel = p.relative_to(images_dir).as_posix()
            if rel.split("/")[-1] in blob or rel in blob:
                used.add(rel)
    return used


def sha256_of(path: Path) -> str:
    h = hashlib.sha256()
    with open(path, "rb") as f:
        for chunk in iter(lambda: f.read(1 << 20), b""):
            h.update(chunk)
    return h.hexdigest()



# M-10, 2026-09-18 (team_10 -> team_100): site-wide image register, keyed by the
# same sha256 id as the M-09 pool. Reuses the hashing already done for the
# live-theme collection; adds where each image actually renders (defaults file
# + page), its current alt, and — for the three book galleries this mandate
# closed plus the home #peek gallery — a structured `people` identification
# and any open accessibility question for Eyal. Written straight onto the
# matching M-09 `images[]` entries so the tool never carries two parallel
# schemas for "the same photo".
DEFAULTS_DIR = THEME_SRC / "inc" / "chapters" / "defaults"

# defaults-file stem -> chapters `type` -> canonical page path, hand-mapped
# (31 files, not worth a fuzzy match). Files with no live page of their own
# (media/qr/qr-hub) map to None and are skipped for "renderedAt".
DEFAULTS_FILE_TO_PAGE = {
    "about": "/eyal-amit/", "accessibility": "/accessibility/", "bags": "/bags/",
    "contact": "/contact/", "didgeridoos": "/didgeridoos/", "en": "/en/",
    "faq": "/faq/", "galleries": None, "home": "/", "kushi-blantis": "/books/kushi-blantis/",
    "learning": "/learning/", "lectures": "/learning/lectures/", "lessons": "/lessons/",
    "media": None, "method": "/method/", "mokesh": "/eyal-amit/mokesh-dahiman/",
    "muzza": "/muzza/", "privacy": "/privacy/", "qr": None, "qr-hub": None,
    "repair": "/repair/", "shop": "/shop/", "snoring-sleep-apnea": "/snoring-sleep-apnea/",
    "sound-healing": "/sound-healing/", "stand-floor": "/stand-floor/",
    "stands-storage": "/stands-storage/", "terms": "/terms/",
    "therapist-training": "/learning/therapist-training/", "treatment": "/treatment/",
    "treatment-eyal": None, "tsva-bekahol": "/books/tsva-bekahol/",
    "vekatavta": "/books/vekatavta/", "workshops": "/learning/workshops/",
}

def sha256_of_theme_file(rel: str) -> str | None:
    p = THEME_SRC / rel
    if not p.is_file():
        return None
    return sha256_of(p)


def build_m10_register(images: list, hash_to_id: dict) -> dict:
    id_to_image = {im["id"]: im for im in images}

    # Every 'image'=>path[,'alt'=>text] and 'media'=>path,'media_alt'=>text
    # pair, with which defaults file (-> page) it came from.
    pat_img = re.compile(r"'image'\s*=>\s*'([^']+)'(?:\s*,\s*'alt'\s*=>\s*'((?:[^'\\]|\\.)*)')?")
    pat_media = re.compile(r"'media'\s*=>\s*'([^']+)'\s*,\s*'media_alt'\s*=>\s*'((?:[^'\\]|\\.)*)'")

    rendered_by_hash: dict[str, list[dict]] = defaultdict(list)
    alt_by_hash: dict[str, str] = {}
    for f in sorted(DEFAULTS_DIR.glob("*.php")):
        stem = f.stem.removesuffix("-defaults")
        page = DEFAULTS_FILE_TO_PAGE.get(stem, "?")
        txt = f.read_text(encoding="utf-8")
        for pat in (pat_img, pat_media):
            for m in pat.finditer(txt):
                rel, alt = m.group(1), (m.group(2) or "").replace("\\'", "'")
                digest = sha256_of_theme_file(rel)
                if not digest:
                    continue
                rendered_by_hash[digest].append({"page": page, "defaultsFile": f.name})
                if alt.strip():
                    # Longest wins on conflict — same policy as the PHP alt
                    # helper's map (chapters-render.php M-10), for the same
                    # reason: the fuller, freshly-authored description beats
                    # an older terse one for the same photo.
                    if digest not in alt_by_hash or len(alt) > len(alt_by_hash[digest]):
                        alt_by_hash[digest] = alt

    people_path = Path(__file__).parent / "m10" / "people.json"
    people_by_abspath = json.loads(people_path.read_text(encoding="utf-8")) if people_path.is_file() else {}
    people_by_hash = {}
    for abspath, info in people_by_abspath.items():
        try:
            rel = str(Path(abspath).relative_to(THEME_SRC))
        except ValueError:
            continue
        digest = sha256_of_theme_file(rel)
        if digest and info.get("people"):
            people_by_hash[digest] = info

    questions_by_hash = {}
    for batch_file in sorted((Path(__file__).parent / "m10").glob("batch_*.json")) if (Path(__file__).parent / "m10").is_dir() else []:
        for e in json.loads(batch_file.read_text(encoding="utf-8")):
            if "question" not in e:
                continue
            try:
                rel = str(Path(e["path"]).relative_to(THEME_SRC))
            except ValueError:
                continue
            digest = sha256_of_theme_file(rel)
            if digest:
                questions_by_hash[digest] = e["question"]

    covered = 0
    live_theme_hashes = {im["sha256"] for im in images if "live-theme" in im["collections"]}
    for digest in live_theme_hashes:
        im = id_to_image[hash_to_id[digest]]
        rendered_pairs = sorted(
            {(r["page"] or "", r["defaultsFile"]) for r in rendered_by_hash.get(digest, [])}
        )
        im["renderedAt"] = [{"page": p, "defaultsFile": d} for p, d in rendered_pairs]
        im["currentAlt"] = alt_by_hash.get(digest, "")
        pinfo = people_by_hash.get(digest)
        im["people"] = pinfo["people"] if pinfo else []
        im["peopleConfidence"] = pinfo["confidence"] if pinfo else None
        im["questionForEyal"] = questions_by_hash.get(digest)
        if im["renderedAt"] or im["currentAlt"] or im["questionForEyal"]:
            covered += 1

    return {
        "liveThemeTotal": len(live_theme_hashes),
        "liveThemeCovered": covered,
    }


def main():
    total_files = 0
    by_hash: dict[str, list[dict]] = defaultdict(list)
    for coll_name, root in ROOTS:
        if not root.is_dir():
            raise SystemExit(f"Missing root: {root}")
        live_theme_used = find_live_theme_used_files(root) if coll_name == "live-theme" else None
        n = 0
        n_skipped = 0
        for f in sorted(root.rglob("*")):
            if f.is_file() and f.suffix.lower() in IMG_EXT:
                rel_to_root = f.relative_to(root).as_posix()
                if live_theme_used is not None and rel_to_root not in live_theme_used:
                    n_skipped += 1
                    continue
                n += 1
                total_files += 1
                digest = sha256_of(f)
                rel = f.relative_to(DIST).as_posix()
                by_hash[digest].append({
                    "collection": coll_name,
                    "rel": rel,
                    "filename": f.name,
                })
        extra = f" ({n_skipped} excluded: unused suggestions, not wired into any template)" if n_skipped else ""
        print(f"[{coll_name}] {n} files under {root}{extra}")

    print(f"TOTAL files scanned: {total_files}")
    print(f"UNIQUE by content (sha256): {len(by_hash)}")
    multi = sum(1 for v in by_hash.values() if len({e['collection'] for e in v}) > 1)
    print(f"Appear in >1 collection: {multi}")

    # 12-char id collision check
    ids = [h[:12] for h in by_hash.keys()]
    assert len(ids) == len(set(ids)), "12-char id collision!"
    print("12-char id collisions: none")

    images = []
    hash_to_id = {}
    for digest, entries in sorted(by_hash.items()):
        iid = digest[:12]
        hash_to_id[digest] = iid
        canonical = sorted(entries, key=lambda e: (e["collection"] != "live-theme", e["rel"]))[0]
        collections = sorted({e["collection"] for e in entries})
        images.append({
            "id": iid,
            "sha256": digest,
            "src": canonical["rel"],
            "collections": collections,
            "groupLabels": [GROUP_LABELS_HE[c] for c in collections],
            "paths": [{"collection": e["collection"], "rel": e["rel"], "filename": e["filename"]} for e in entries],
            # M-09 mandate, "מה לא בונים עכשיו": old-site enrichment (which page it
            # appeared on, what its alt text was) is explicitly out of scope for this
            # build — the old-site API's page-id -> readable-name lookup didn't hold
            # up under team_100's own test. But the mandate requires the *shape* to
            # exist now so a later enrichment pass fills these in-place rather than
            # migrating every stored record. Never read by this build; always present.
            "oldSitePages": [],
            "oldSiteAlt": None,
            "oldSiteMeta": None,
        })

    # --- join old-site SEO metadata, per Nimrod (2026-09-16): import all of it,
    # not just alt/page, and let it be approved or edited per chosen image.
    # match_old_site_media.py keys its output by entry_id (public_id/media_filename
    # are only populated in catalog.json, the curated 315-entry subset — NOT in
    # catalog.all.json, which is what that script iterates for search terms). So
    # the join goes through catalog.json's media_filename -> entry_id, not
    # media_filename -> public_id directly. ---
    catalog_curated = json.loads(
        (DIST / "files" / "team40" / "ea-legacy-curated" / "catalog.json").read_text(encoding="utf-8")
    )
    filename_to_entry_id = {e["media_filename"]: e.get("entry_id") for e in catalog_curated["entries"] if e.get("media_filename")}
    matched_path = Path(__file__).parent / "old_site_metadata_matched.json"
    if matched_path.is_file():
        matched_data = json.loads(matched_path.read_text(encoding="utf-8"))
        entry_id_to_meta = matched_data["matched"]
        joined = 0
        for im in images:
            if "old-site" not in im["collections"]:
                continue
            for p in im["paths"]:
                if p["collection"] != "old-site":
                    continue
                eid = filename_to_entry_id.get(p["filename"])
                meta = entry_id_to_meta.get(eid) if eid else None
                if meta:
                    im["oldSiteMeta"] = {
                        "wp_id": meta["wp_id"],
                        "title": html.unescape(meta["title"] or ""),
                        "alt_text": html.unescape(meta["alt_text"] or ""),
                        "caption": html.unescape(meta["caption"] or ""),
                        "description": html.unescape(meta["description"] or ""),
                    }
                    joined += 1
                    break
        print(f"\nold-site metadata joined onto {joined} of {sum(1 for i in images if 'old-site' in i['collections'])} old-site images")
    else:
        print(f"\n[old-site metadata not yet fetched — {matched_path.name} not found; oldSiteMeta left null for all images]")

    # --- cross-reference the slot picker ---
    picker_html = (REPO / "_COMMUNICATION" / "team_110" / "build" / "image-picker.html").read_text(encoding="utf-8")
    m = re.search(r"const SLOTS = (\[.*?\]);", picker_html, re.DOTALL)
    slots = json.loads(m.group(1))
    print(f"\nslot rows (raw): {len(slots)}")
    print(f"unique slot ids (role/type): {len(set(s['id'] for s in slots))}")
    pages = sorted(set(s.get("page", "") for s in slots))
    print(f"unique pages: {len(pages)}")
    for p in pages:
        print("  PAGE:", p)
    total_cands = sum(len(s.get("cands", [])) for s in slots)
    with_current = sum(1 for s in slots if s.get("current"))
    print(f"total candidate entries (sum of cands[]): {total_cands}")
    print(f"slots with a current value: {with_current}")
    print(f"cands + current tiles (424 reconciliation check): {total_cands + with_current}")

    def resolve_path_to_id(rel_path: str) -> str | None:
        full = DIST / rel_path
        if not full.is_file():
            return None
        digest = sha256_of(full)
        return hash_to_id.get(digest)

    missing = []
    # Every canonical menu page gets an entry, including the 14 that have no
    # slot-picker data at all (empty list — Nimrod assigns images to them fresh
    # through the tool, per his instruction that the page list must be complete).
    page_assignments: dict[str, list] = {title: [] for title, _path in MAIN_MENU_PAGES}
    unmapped_slot_pages = set()
    for s in slots:
        raw_page = s.get("page", "")
        canonical = SLOT_PAGE_TO_CANONICAL.get(raw_page)
        if not canonical:
            unmapped_slot_pages.add(raw_page)
            continue
        cur_rel = s.get("current")
        cur_id = resolve_path_to_id(cur_rel) if cur_rel else None
        if cur_rel and not cur_id:
            missing.append(cur_rel)
        page_assignments[canonical].append({
            "slotId": s["id"],
            "section": s.get("section", ""),
            "role": s.get("role", ""),
            "currentImageId": cur_id,
        })

    print(f"\ncurrent-path resolve failures: {len(missing)}")
    for mpath in missing[:10]:
        print("  MISSING:", mpath)
    if unmapped_slot_pages:
        print(f"\nWARNING — slot-picker pages with no canonical mapping (dropped): {unmapped_slot_pages}")
    print(f"\ncanonical menu pages: {len(MAIN_MENU_PAGES)}")

    m10_stats = build_m10_register(images, hash_to_id)
    print(f"\nM-10 register: {m10_stats['liveThemeCovered']} of {m10_stats['liveThemeTotal']} "
          f"live-theme images carry a renderedAt/currentAlt/question entry")

    out = {
        "images": images,
        "pages": [{"title": t, "path": p} for t, p in MAIN_MENU_PAGES],
        "pageAssignments": page_assignments,
    }
    out_path = Path(__file__).parent / "media_data.json"
    out_path.write_text(json.dumps(out, ensure_ascii=False), encoding="utf-8")
    print(f"\nWrote {out_path} ({out_path.stat().st_size} bytes)")
    print(f"images: {len(images)}")


if __name__ == "__main__":
    main()
