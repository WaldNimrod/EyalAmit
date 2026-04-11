#!/usr/bin/env python3
"""חיפוש טקסטואלי פשוט באינדקס: python3 query_index.py 'מילה'"""
import json
import sys
from pathlib import Path

HERE = Path(__file__).resolve().parent
IDX = HERE / "index.json"


def main() -> None:
    if len(sys.argv) < 2:
        print("Usage: query_index.py <substring>")
        sys.exit(1)
    q = sys.argv[1].lower()
    doc = json.loads(IDX.read_text(encoding="utf-8"))
    for e in doc["entries"]:
        blob = e.get("search_blob", "")
        if q in blob or any(q in k.lower() for k in e.get("search", {}).get("keywords", [])):
            cls = e["agent"]["source_class"]
            print(f"{e['entry_id']}\t{cls}\t{e['legacy_relative']}")


if __name__ == "__main__":
    main()
