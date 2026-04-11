#!/usr/bin/env python3
"""
Scan from-eyal/ directories and update hub/data/content-index.json.

Detects new content packages, unpackaged dirs, loose assets, and legacy media.
Appends new items (status=pending) and updates indexedAt for modified items.

Usage (repo root):
  python3 scripts/scan_eyal_content_index.py
  python3 scripts/scan_eyal_content_index.py --dry-run
  python3 scripts/scan_eyal_content_index.py --build
"""
from __future__ import annotations

import argparse
import json
import os
import subprocess
import sys
import tempfile
from datetime import datetime, timezone
from pathlib import Path

REPO_ROOT = Path(__file__).resolve().parent.parent
FROM_EYAL = REPO_ROOT / "docs/project/eyal-ceo-submissions-and-responses/from-eyal"
CONTENT_DIR = FROM_EYAL / "CONTENT"
LEGACY_MEDIA = REPO_ROOT / "_communication/team_40"
INDEX_PATH = REPO_ROOT / "hub/data/content-index.json"

# Dirs under FROM_EYAL that are known special — not unpackaged content
KNOWN_SPECIAL_DIRS = {
    "CONTENT",
    "LOGO",
    "canonical_update_pack_2026-04-06",
    "poc_st-book-kushi_2026-04-06",
    "poc_st-book-kushi_2026-04-06 2",
    "CONTENT EYAL 10.4.26",  # ארוז ל-EYAL-CONTENT-PKG-2026-04-10-st-method ב-2026-04-11; ספרייה נמחקה
}

MTIME_THRESHOLD_SECONDS = 60


def now_iso() -> str:
    return datetime.now(timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ")


def path_mtime_iso(p: Path) -> str:
    ts = p.stat().st_mtime
    return datetime.fromtimestamp(ts, tz=timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ")


def iso_to_ts(iso: str) -> float:
    """Parse ISO 8601 UTC string → float timestamp. Returns 0.0 on error."""
    try:
        dt = datetime.strptime(iso, "%Y-%m-%dT%H:%M:%SZ").replace(tzinfo=timezone.utc)
        return dt.timestamp()
    except Exception:
        return 0.0


def repo_rel(p: Path) -> str:
    """Return path relative to REPO_ROOT as POSIX string."""
    try:
        return p.relative_to(REPO_ROOT).as_posix()
    except ValueError:
        return str(p)


def load_index() -> dict:
    with open(INDEX_PATH, encoding="utf-8") as f:
        return json.load(f)


def save_index(data: dict, dry_run: bool) -> None:
    content = json.dumps(data, ensure_ascii=False, indent=2) + "\n"
    if dry_run:
        return
    tmp = INDEX_PATH.with_suffix(".json.tmp")
    tmp.write_text(content, encoding="utf-8")
    tmp.replace(INDEX_PATH)


# ---------------------------------------------------------------------------
# Scanner functions
# ---------------------------------------------------------------------------

def scan_content_packages(index_map: dict[str, dict]) -> list[dict]:
    """Walk CONTENT/ — dirs that contain PACKAGE-MANIFEST.json."""
    new_items: list[dict] = []
    if not CONTENT_DIR.is_dir():
        return new_items
    for child in sorted(CONTENT_DIR.iterdir()):
        if not child.is_dir():
            continue
        manifest = child / "PACKAGE-MANIFEST.json"
        if not manifest.exists():
            continue
        pkg_id = child.name
        rel = repo_rel(child)
        if pkg_id in index_map:
            # Check mtime
            existing = index_map[pkg_id]
            indexed_ts = iso_to_ts(existing.get("indexedAt", ""))
            dir_mtime = child.stat().st_mtime
            existing["_scanned"] = True
            existing["_path"] = child
            if dir_mtime - indexed_ts > MTIME_THRESHOLD_SECONDS:
                existing["_modified"] = True
        else:
            # New package — auto-add
            try:
                with open(manifest, encoding="utf-8") as f:
                    mf = json.load(f)
            except Exception:
                mf = {}
            item = {
                "id": pkg_id,
                "category": "content_package",
                "status": "pending",
                "titleHe": mf.get("noteHe", f"חבילת תוכן — {pkg_id}"),
                "repoPath": rel,
                "indexedAt": now_iso(),
                "receivedDate": mf.get("ingestedDate", pkg_id[len("EYAL-CONTENT-PKG-"):len("EYAL-CONTENT-PKG-") + 10] if pkg_id.startswith("EYAL-CONTENT-PKG-") else ""),
                "packageId": pkg_id,
                "pageIds": mf.get("pageIds", []),
                "templateIds": mf.get("templateIds", []),
                "packageRole": mf.get("packageRole", ""),
                "noteHe": f"נוסף אוטומטית ע״י סורק — יש לאמת ולהגדיר status.",
                "_scanned": True,
                "_new": True,
            }
            index_map[pkg_id] = item
            new_items.append(item)
    return new_items


def scan_unpackaged_dirs(index_map: dict[str, dict]) -> tuple[list[dict], list[str]]:
    """Top-level dirs under FROM_EYAL not in KNOWN_SPECIAL_DIRS and no PACKAGE-MANIFEST.json."""
    new_items: list[dict] = []
    review_paths: list[str] = []
    if not FROM_EYAL.is_dir():
        return new_items, review_paths
    for child in sorted(FROM_EYAL.iterdir()):
        if not child.is_dir():
            continue
        if child.name in KNOWN_SPECIAL_DIRS:
            continue
        if child.name.startswith("."):
            continue
        # Check if it has a manifest
        if (child / "PACKAGE-MANIFEST.json").exists():
            continue
        rel = repo_rel(child)
        # Find if any existing item covers this path
        matched = any(
            item.get("repoPath", "") == rel or item.get("repoPath", "").startswith(rel)
            for item in index_map.values()
        )
        if matched:
            # Mark scanned
            for item in index_map.values():
                if item.get("repoPath", "") == rel:
                    item["_scanned"] = True
                    p = FROM_EYAL / child.name
                    if p.is_dir():
                        mtime = p.stat().st_mtime
                        indexed_ts = iso_to_ts(item.get("indexedAt", ""))
                        if mtime - indexed_ts > MTIME_THRESHOLD_SECONDS:
                            item["_modified"] = True
            continue
        # Unknown unpackaged dir — needs review
        review_paths.append(f"from-eyal/{child.name}  (תיקייה לא ממוסדת — אין PACKAGE-MANIFEST.json)")
    return new_items, review_paths


def scan_loose_assets(index_map: dict[str, dict]) -> list[dict]:
    """Scan loose PSD, PDF, docx, md files under FROM_EYAL top level."""
    new_items: list[dict] = []
    if not FROM_EYAL.is_dir():
        return new_items
    for f in sorted(FROM_EYAL.iterdir()):
        if not f.is_file():
            continue
        if f.suffix.lower() in {".psd", ".pdf", ".docx"}:
            rel = repo_rel(f)
            matched = any(item.get("repoPath", "") == rel for item in index_map.values())
            if matched:
                for item in index_map.values():
                    if item.get("repoPath", "") == rel:
                        item["_scanned"] = True
                        mtime = f.stat().st_mtime
                        indexed_ts = iso_to_ts(item.get("indexedAt", ""))
                        if mtime - indexed_ts > MTIME_THRESHOLD_SECONDS:
                            item["_modified"] = True
            # Files tracked loosely — don't auto-add without review
    return new_items


def scan_legacy_media(index_map: dict[str, dict]) -> list[dict]:
    """Scan ea-legacy-curated-* dirs in team_40 for catalog.json."""
    new_items: list[dict] = []
    if not LEGACY_MEDIA.is_dir():
        return new_items
    for child in sorted(LEGACY_MEDIA.iterdir()):
        if not child.is_dir():
            continue
        if not child.name.startswith("ea-legacy-curated-"):
            continue
        catalog = child / "catalog.json"
        rel = repo_rel(child)
        matched_id = None
        for item_id, item in index_map.items():
            if item.get("repoPath", "") == rel or item.get("repoPath", "").startswith(rel):
                matched_id = item_id
                break
        if matched_id:
            item = index_map[matched_id]
            item["_scanned"] = True
            if catalog.exists():
                mtime = catalog.stat().st_mtime
                indexed_ts = iso_to_ts(item.get("indexedAt", ""))
                if mtime - indexed_ts > MTIME_THRESHOLD_SECONDS:
                    item["_modified"] = True
        else:
            # Auto-add
            media_count = 0
            if catalog.exists():
                try:
                    with open(catalog, encoding="utf-8") as f:
                        cat_data = json.load(f)
                    media_count = len(cat_data.get("images", cat_data if isinstance(cat_data, list) else []))
                except Exception:
                    pass
            synthetic_id = f"EYAL-ASSET-LEGACY-MEDIA-{child.name.replace('ea-legacy-curated-', '')}"
            item = {
                "id": synthetic_id,
                "category": "media_ref",
                "status": "pending",
                "titleHe": f"קטלוג מדיה לגסי — {child.name}",
                "repoPath": rel,
                "indexedAt": now_iso(),
                "receivedDate": "",
                "mediaCount": media_count,
                "actionNeededHe": "מיפוי siteNodeId לתמונות — כרגע תגיות היוריסטיות בלבד.",
                "noteHe": "נוסף אוטומטית ע״י סורק.",
                "_scanned": True,
                "_new": True,
            }
            index_map[synthetic_id] = item
            new_items.append(item)
    return new_items


# ---------------------------------------------------------------------------
# Main
# ---------------------------------------------------------------------------

def main() -> None:
    ap = argparse.ArgumentParser(description="Scan from-eyal/ and update content-index.json")
    ap.add_argument("--dry-run", action="store_true", help="Print changes without writing")
    ap.add_argument("--build", action="store_true", help="Run build_eyal_client_hub.py after update")
    args = ap.parse_args()

    if not INDEX_PATH.exists():
        print(f"[ERROR] Index not found: {INDEX_PATH}", file=sys.stderr)
        sys.exit(1)

    data = load_index()
    items_list: list[dict] = data.get("items", [])

    # Build working map: id -> item (shallow copy, we'll mutate in place)
    index_map: dict[str, dict] = {item["id"]: item for item in items_list}
    # Clear _scanned flags
    for item in index_map.values():
        item.pop("_scanned", None)
        item.pop("_modified", None)
        item.pop("_new", None)
        item.pop("_path", None)

    # Run scanners
    new_pkg = scan_content_packages(index_map)
    new_unpack, review_paths = scan_unpackaged_dirs(index_map)
    scan_loose_assets(index_map)
    new_media = scan_legacy_media(index_map)

    all_new = new_pkg + new_unpack + new_media
    modified = [item for item in index_map.values() if item.get("_modified")]

    # Count unchanged
    unchanged = len(index_map) - len(all_new) - len(modified)

    # Print report
    print(f"[OK]       {max(0, unchanged)} items unchanged")
    print(f"[NEW]       {len(all_new)} items auto-added (status: pending)")
    print(f"[MODIFIED]  {len(modified)} items with newer mtime")
    if review_paths:
        print(f"[REVIEW]    {len(review_paths)} paths need manual classification")
        for rp in review_paths:
            print(f"  → {rp}")

    if args.dry_run:
        if all_new:
            print("\nWould add:")
            for item in all_new:
                print(f"  + {item['id']}  ({item['repoPath']})")
        if modified:
            print("\nWould update indexedAt for:")
            for item in modified:
                print(f"  ~ {item['id']}")
        return

    changed = False

    # Apply modifications
    now = now_iso()
    for item in modified:
        item["indexedAt"] = now
        changed = True

    # Append new items (strip internal flags)
    for item in all_new:
        for k in ("_scanned", "_new", "_modified", "_path"):
            item.pop(k, None)
        if item["id"] not in {i["id"] for i in items_list}:
            items_list.append(item)
            changed = True

    # Strip scan flags from all items
    for item in items_list:
        for k in ("_scanned", "_modified", "_new", "_path"):
            item.pop(k, None)

    if changed:
        data["generatedAt"] = now
        changelog = data.setdefault("changelog", [])
        entry: dict = {"at": now, "event": "scan_update"}
        parts = []
        if all_new:
            parts.append(f"{len(all_new)} פריטים חדשים")
        if modified:
            parts.append(f"{len(modified)} עודכנו (mtime)")
        entry["noteHe"] = " | ".join(parts) if parts else "סריקה ללא שינויים"
        changelog.insert(0, entry)
        data["items"] = items_list
        save_index(data, dry_run=False)
        print(f"\n[SAVED] {INDEX_PATH}")
    else:
        print("\n[SAVED] No changes — index not modified.")

    if args.build:
        build_script = REPO_ROOT / "scripts/build_eyal_client_hub.py"
        print(f"\n[BUILD] Running {build_script.name}...")
        result = subprocess.run([sys.executable, str(build_script)], cwd=REPO_ROOT)
        sys.exit(result.returncode)


if __name__ == "__main__":
    main()
