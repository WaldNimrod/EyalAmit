#!/usr/bin/env python3
"""docx_paragraph_index.py — a stable address for every paragraph in a .docx.

The charter's Provenance format wants a cell or a line number. A .docx has
neither: paragraph numbering depends on whatever opened the file, so «paragraph
17» means nothing until one tool defines the count. Gate 5 verifies quoted bytes
against their source, and without an agreed address it fails on all 44
testimonials at once rather than on any real defect.

So this is the tool that defines the count. It reads word/document.xml directly
— no dependency to install, and no reformatting between the source and the
number — and emits, for each non-empty paragraph in document order:

    idx    1-based position in document order. This is the citable address.
    sha256 of the text AS THIS TOOL EMITS IT.

**The tool's output is the canonical text, not the raw .docx.** A .docx splits a
sentence across runs at arbitrary points and carries whatever whitespace the
author typed, so the bytes are normalised here: runs joined, w:br/w:cr to \n,
w:tab to \t, runs of spaces and tabs collapsed to one, ends stripped. That makes
the text quotable — but it also means a validator that greps the raw .docx for a
quoted string can miss it on a double space and report a defect that is not one.
So the match is `sha256` against this output, never a search of the document.

Scope notes, both deliberate: w:p is walked recursively, so paragraphs inside
tables are indexed in document order like any other. Tracked deletions are NOT
indexed — deleted text lives in w:delText and only w:t is read — so an accepted
or rejected revision does not shift the numbering of anything else.

Cite as:  /* S006 · מקור: <file> · פסקה <idx> */

Usage:
    python3 scripts/docx_paragraph_index.py <file.docx> [--json out.json]
    python3 scripts/docx_paragraph_index.py <file.docx> --find "<quoted text>"
"""
from __future__ import annotations

import argparse
import hashlib
import json
import re
import sys
import zipfile
from pathlib import Path

W = '{http://schemas.openxmlformats.org/wordprocessingml/2006/main}'


def paragraphs(path: Path) -> list[str]:
    import xml.etree.ElementTree as ET
    with zipfile.ZipFile(path) as z:
        root = ET.fromstring(z.read('word/document.xml'))
    out = []
    for p in root.iter(f'{W}p'):
        # w:t holds the runs; w:br and w:tab carry spacing that would otherwise
        # silently glue two words together and change the bytes being quoted.
        buf = []
        for node in p.iter():
            if node.tag == f'{W}t':
                buf.append(node.text or '')
            elif node.tag in (f'{W}br', f'{W}cr'):
                buf.append('\n')
            elif node.tag == f'{W}tab':
                buf.append('\t')
        text = re.sub(r'[ \t]+', ' ', ''.join(buf)).strip()
        if text:
            out.append(text)
    return out


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument('docx')
    ap.add_argument('--json', help='write the full index here')
    ap.add_argument('--find', metavar='TEXT',
                    help='resolve a quoted string back to its פסקה index, by '
                         'sha256 of the normalised form — the gate-5 check')
    args = ap.parse_args()

    path = Path(args.docx)
    if not path.is_file():
        print(f'לא נמצא: {path}', file=sys.stderr)
        return 2

    paras = paragraphs(path)
    index = [{'idx': i,
              'sha256': hashlib.sha256(t.encode('utf-8')).hexdigest(),
              'chars': len(t),
              'text': t}
             for i, t in enumerate(paras, start=1)]

    if args.find:
        # Normalise the candidate exactly as a paragraph is normalised, so the
        # comparison is the same one the index was built with.
        want = re.sub(r'[ \t]+', ' ', args.find).strip()
        digest = hashlib.sha256(want.encode('utf-8')).hexdigest()
        hit = next((r for r in index if r['sha256'] == digest), None)
        if hit:
            print(f"  התאמה · פסקה {hit['idx']} · {hit['sha256'][:12]}")
            return 0
        near = [r for r in index if want and want in r['text']]
        print('  אין התאמה מדויקת.', file=sys.stderr)
        for r in near[:3]:
            print(f"    מוכל בפסקה {r['idx']} — הציטוט אינו פסקה שלמה",
                  file=sys.stderr)
        return 1

    if args.json:
        Path(args.json).write_text(
            json.dumps({'source': path.name, 'paragraphs': index},
                       ensure_ascii=False, indent=2), encoding='utf-8')
        print(f'  {len(index)} פסקאות → {args.json}')
    else:
        print(f'  {path.name}: {len(index)} פסקאות')
        for r in index:
            print(f"    {r['idx']:>3}  {r['sha256'][:8]}  {r['chars']:>4} תווים  "
                  f"{r['text'][:60]}")
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
