#!/bin/sh
# Regenerate every page derived from the map (run after tools/build.py). From the canon-map directory.
set -e
cd "$(dirname "$0")/.."
python3 tools/grid_proof.py ea-canon-map.html grid-proof.html
python3 tools/palette_check.py ea-canon-map.html palette-check.html
python3 tools/merge_view.py ea-canon-map.html merge.html
python3 tools/shared_view.py ea-canon-map.html shared.html
python3 tools/grids_view.py ea-canon-map.html grids.html
