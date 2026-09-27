#!/bin/sh
# Regenerate every page from map-source.html (run tools/build.py first). From the canon-map directory.
set -e
cd "$(dirname "$0")/.."
python3 tools/canon_view.py map-source.html ea-canon-map.html
python3 tools/open_view.py map-source.html open.html
python3 tools/grids_view.py map-source.html grids.html
python3 tools/grid_proof.py map-source.html grid-proof.html
python3 tools/palette_check.py map-source.html palette-check.html
