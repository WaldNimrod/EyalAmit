#!/usr/bin/env python3
"""Validate hub/data/*.json structure (Eyal Client Hub).

Usage (repo root):
    python3 scripts/hub_validate_hub_data.py

Exit 0 if all checks pass; non-zero on first error.
"""

from __future__ import annotations

import json
import sys
from pathlib import Path

HUB_DATA = Path(__file__).resolve().parent.parent / "hub" / "data"

# Required top-level keys per file (minimal contract for build).
REQUIRED: dict[str, list[str]] = {
    "decisions.json": ["schemaVersion", "decisions"],
    "tasks.json": ["schemaVersion", "sections"],
    "roadmap.json": ["schemaVersion", "currentFocusId"],
    "updates.json": ["schemaVersion", "items"],
    "deliverables.json": ["schemaVersion", "items"],
    "site-tree.json": ["schemaVersion", "nodes"],
    "hub-version.json": ["schemaVersion", "hubVersion"],
    "page-templates.json": ["schemaVersion", "templates"],
    "content-index.json": ["schemaVersion"],
    "eyal-pending.json": ["schemaVersion", "items"],
    "legacy-unmapped.json": ["schemaVersion"],
    "links.json": ["schemaVersion", "categories"],
    "questions-prompts.json": ["schemaVersion", "formFields", "exportType"],
    "meeting-brief.json": ["schemaVersion", "meetingDate", "titleHe"],
}


def check_file(name: str, required_keys: list[str]) -> list[str]:
    path = HUB_DATA / name
    errors: list[str] = []
    if not path.exists():
        errors.append(f"Missing file: {path}")
        return errors
    try:
        data = json.loads(path.read_text(encoding="utf-8"))
    except json.JSONDecodeError as e:
        return [f"{name}: invalid JSON — {e}"]
    if not isinstance(data, dict):
        return [f"{name}: root must be an object"]
    for k in required_keys:
        if k not in data:
            errors.append(f"{name}: missing key {k!r}")
    return errors


def main() -> int:
    all_errors: list[str] = []
    for fname, keys in REQUIRED.items():
        all_errors.extend(check_file(fname, keys))
    if all_errors:
        print("[hub_validate_hub_data] FAIL", file=sys.stderr)
        for e in all_errors:
            print(f"  {e}", file=sys.stderr)
        return 1
    print("[hub_validate_hub_data] OK —", len(REQUIRED), "data files")
    return 0


if __name__ == "__main__":
    sys.exit(main())
