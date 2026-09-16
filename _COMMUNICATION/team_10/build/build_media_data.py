#!/usr/bin/env python3
"""M-09 data prep: hash all media, dedupe by content, cross-reference the slot picker."""
import hashlib
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
        })

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
    page_assignments = defaultdict(list)
    for s in slots:
        page = s.get("page", "")
        cur_rel = s.get("current")
        cur_id = resolve_path_to_id(cur_rel) if cur_rel else None
        if cur_rel and not cur_id:
            missing.append(cur_rel)
        page_assignments[page].append({
            "slotId": s["id"],
            "section": s.get("section", ""),
            "role": s.get("role", ""),
            "currentImageId": cur_id,
        })

    print(f"\ncurrent-path resolve failures: {len(missing)}")
    for mpath in missing[:10]:
        print("  MISSING:", mpath)

    out = {
        "images": images,
        "pageAssignments": {p: rows for p, rows in page_assignments.items()},
    }
    out_path = Path(__file__).parent / "media_data.json"
    out_path.write_text(json.dumps(out, ensure_ascii=False), encoding="utf-8")
    print(f"\nWrote {out_path} ({out_path.stat().st_size} bytes)")
    print(f"images: {len(images)}")


if __name__ == "__main__":
    main()
