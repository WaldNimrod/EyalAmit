#!/usr/bin/env python3
"""Ingest what Eyal sends back from the three approval surfaces.

Written 2026-09-27, before any file arrived, because "ready to receive the new information"
means the reader exists and has been run — not that we will write one when the file lands.
The two ingesters already in the repo cannot read these payloads: ingest_eyal_feedback_json.py
demands the April 2026 hub schema and exits on a missing `schemaVersion`, and
tracker_ingest_approvals.py reads `pageApprovals`, which none of these three emit.

Handles all three schemas:

  final-form-v2 / v1      eyal-final-form-2026-09-24.json     the 43-card form
  alt-corrections-v2      alt-corrections-<sig>.json          image description corrections
  redirects-approval-v1   eyal-redirects-approval.json        the 301 map and the two name calls

What it does NOT do: decide anything. It normalises, validates against what we actually
published, files the payload where the previous round's answers live, and prints what is
answered, what is still blank, and anything it does not recognise. Acting on the answers is a
separate, human-reviewed step — content law applies to every one of them.

Usage
  python3 scripts/ingest_eyal_final_form.py <file.json> [more.json ...]
  python3 scripts/ingest_eyal_final_form.py --dry-run <file.json>

Exit codes: 0 ingested · 1 a payload was rejected · 2 bad invocation.
"""
from __future__ import annotations

import argparse
import hashlib
import json
import re
import sys
from datetime import datetime, timezone
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
INTAKE = ROOT / "docs/project/eyal-ceo-submissions-and-responses/from-eyal"

FORM_SRC = ROOT / "_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html"
ALT_SRC = ROOT / "_COMMUNICATION/team_100/EYAL-WORKSPACE/ea-alt-approval.html"
REDIR_SRC = ROOT / "_COMMUNICATION/team_90/AUDIT-2026-09-26/EYAL-REDIRECTS-APPROVAL-2026-09-26.html"


def published_form_ids() -> tuple[set[str], str]:
    """The card ids and signature actually published, read from the form, not from memory."""
    src = FORM_SRC.read_text(encoding="utf-8")
    block = re.search(r"var CARD_IDS\s*=\s*\[(.*?)\];", src, re.S)
    ids = set(re.findall(r"'([^']+)'", block.group(1))) if block else set()
    sig = re.search(r"var FORM_SIG\s*=\s*'([^']+)'", src)
    return ids, (sig.group(1) if sig else "")


def published_alt_ids() -> tuple[set[str], str]:
    src = ALT_SRC.read_text(encoding="utf-8")
    sig = re.search(r'const SIG\s*=\s*"([^"]+)"', src)
    data = re.search(r"const DATA\s*=\s*(\[.*?\]);", src, re.S)
    ids: set[str] = set()
    if data:
        try:
            ids = {row["id"] for row in json.loads(data.group(1)) if row.get("id")}
        except (json.JSONDecodeError, TypeError, KeyError):
            ids = set()
    return ids, (sig.group(1) if sig else "")


def published_redirect_ids() -> set[str]:
    src = REDIR_SRC.read_text(encoding="utf-8")
    return set(re.findall(r'class="item"[^>]*data-id="([^"]+)"', src))


def _answered(value: str | None) -> bool:
    return bool(value and value.strip())


def handle_final_form(payload: dict) -> tuple[list[str], list[str]]:
    """Returns (problems, report_lines)."""
    problems, report = [], []
    known, sig = published_form_ids()

    got_sig = payload.get("formSig", "")
    if got_sig != sig:
        problems.append(
            f"form signature is {got_sig!r} but the published form is {sig!r} — this export "
            f"came from a different version of the form and must not be merged blindly"
        )

    answers = payload.get("contentAnswers") or []
    ids = [a.get("id", "") for a in answers]
    unknown = sorted(set(ids) - known)
    missing = sorted(known - set(ids))
    if unknown:
        problems.append(f"{len(unknown)} answer id(s) not in the published form: {unknown[:5]}")
    if missing:
        report.append(f"cards absent from the export entirely: {len(missing)} {missing[:5]}")

    chose = [a for a in answers if _answered(a.get("choice"))]
    noted = [a for a in answers if _answered(a.get("note"))]
    blank = sorted(a.get("id", "") for a in answers
                   if not _answered(a.get("choice")) and not _answered(a.get("note")))

    per_field = sum(len(a.get("fields") or {}) for a in answers)
    if payload.get("exportSchema") == "final-form-v1":
        report.append("schema v1: per-field answers were flattened into one note per card by the "
                      "exporting page; per-image attribution is NOT recoverable from this file")
    else:
        report.append(f"per-field answers preserved: {per_field}")

    report.append(f"cards: {len(answers)} · with a choice: {len(chose)} · with a note: {len(noted)}")
    report.append(f"still blank: {len(blank)}" + (f" {blank[:8]}" if blank else ""))

    rows = payload.get("notesTable") or []
    filled = [r for r in rows if any(_answered(v) for v in r.values())]
    report.append(f"free notes table rows filled: {len(filled)}")
    return problems, report


def handle_alt_corrections(payload: dict) -> tuple[list[str], list[str]]:
    problems, report = [], []
    known, sig = published_alt_ids()

    got_sig = payload.get("contentSig", "")
    if got_sig != sig:
        problems.append(
            f"content signature is {got_sig!r} but the published page is {sig!r} — the image set "
            f"changed since Eyal filled this in, so corrections may not line up"
        )

    corrections = payload.get("corrections") or []
    unknown = sorted({c.get("id", "") for c in corrections} - known)
    if unknown:
        problems.append(f"{len(unknown)} correction(s) for unknown image id(s): {unknown[:5]}")

    total = payload.get("totalImages")
    report.append(f"images on the page: {total} · corrections returned: {len(corrections)}")
    report.append(f"approved as written (no correction): "
                  f"{(total - len(corrections)) if isinstance(total, int) else 'unknown'}")
    for c in corrections[:5]:
        report.append(f"  {c.get('page','')[-40:]} :: {c.get('current','')[:40]} -> {c.get('correction','')[:40]}")
    return problems, report


def handle_redirects(payload: dict) -> tuple[list[str], list[str]]:
    problems, report = [], []
    known = published_redirect_ids()
    answers = payload.get("answers") or []
    unknown = sorted({a.get("id", "") for a in answers} - known)
    if unknown:
        problems.append(f"{len(unknown)} answer(s) for unknown group id(s): {unknown[:5]}")
    chose = [a for a in answers if _answered(a.get("choice"))]
    blank = sorted(a.get("id", "") for a in answers if not _answered(a.get("choice")))
    report.append(f"groups: {len(answers)} · decided: {len(chose)} · undecided: {len(blank)}")
    if blank:
        report.append(f"  still open: {blank}")
    return problems, report


HANDLERS = {
    "final-form-v2": handle_final_form,
    "final-form-v1": handle_final_form,
    "alt-corrections-v2": handle_alt_corrections,
    "redirects-approval-v1": handle_redirects,
}


def ingest(path: Path, dry_run: bool) -> bool:
    print(f"\n=== {path.name}")
    try:
        payload = json.loads(path.read_text(encoding="utf-8"))
    except Exception as exc:  # noqa: BLE001
        print(f"  REJECTED: not readable JSON — {exc}")
        return False

    schema = payload.get("exportSchema", "")
    handler = HANDLERS.get(schema)
    if not handler:
        print(f"  REJECTED: unknown exportSchema {schema!r}. Known: {sorted(HANDLERS)}")
        return False

    print(f"  schema     {schema}")
    print(f"  exported   {payload.get('exportTimestamp', 'unstated')}")

    problems, report = handler(payload)
    for line in report:
        print(f"  {line}")

    if problems:
        print("  PROBLEMS:")
        for p in problems:
            print(f"    ! {p}")

    if dry_run:
        print("  dry run — nothing written")
        return not problems

    stamp = datetime.now(timezone.utc).strftime("%Y-%m-%dT%H%M%SZ")
    digest = hashlib.sha256(path.read_bytes()).hexdigest()[:12]
    out_dir = INTAKE / f"{stamp[:10]}--{schema}--from-eyal"
    out_dir.mkdir(parents=True, exist_ok=True)
    out = out_dir / f"{stamp}--{digest}.json"
    if out.exists():
        print(f"  REJECTED: {out} already exists — refusing to overwrite an intake file")
        return False
    out.write_text(json.dumps(payload, ensure_ascii=False, indent=1), encoding="utf-8")
    print(f"  filed      {out.relative_to(ROOT)}")
    print(f"  sha256/12  {digest}")
    return not problems


def main() -> None:
    ap = argparse.ArgumentParser(description=__doc__,
                                 formatter_class=argparse.RawDescriptionHelpFormatter)
    ap.add_argument("files", nargs="+", type=Path)
    ap.add_argument("--dry-run", action="store_true", help="validate and report, write nothing")
    args = ap.parse_args()

    missing = [f for f in args.files if not f.is_file()]
    if missing:
        ap.error(f"no such file: {missing[0]}")

    ok = all(ingest(f, args.dry_run) for f in args.files)
    print("\nAll payloads clean." if ok else "\nAt least one payload had problems — read them above "
          "before merging anything.")
    sys.exit(0 if ok else 1)


if __name__ == "__main__":
    main()
