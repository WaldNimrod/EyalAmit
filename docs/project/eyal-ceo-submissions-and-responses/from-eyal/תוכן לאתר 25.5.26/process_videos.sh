#!/bin/bash
# DOK Video Processor — MOV/MP4 -> 720p H.264 MP4 (web-ready)
# Hardware-accelerated (VideoToolbox), parallel via xargs, robust against hangs.
#
# Usage:
#   bash process_videos.sh           # all videos
#   bash process_videos.sh 5         # first 5 only (test)
set -uo pipefail

BASE="$HOME/Documents/Eyal Amit/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26"
SRC="$BASE/תמונות וסרטונים DOK אביב"
WEB="$BASE/DOK-WEB/videos"
LOG="$BASE/DOK-WEB/_videos_run.log"

LIMIT="${1:-0}"     # 0 = all
PARALLEL=3          # concurrent encodes
BITRATE="2500k"     # 720p web sweet spot
MAXRATE="4000k"
FPS=30

mkdir -p "$WEB"
: > "$LOG"

encode_one() {
  local src="$1"
  local name; name="$(basename "$src")"
  local stem="${name%.*}"
  local dst="$WEB/${stem}.mp4"

  if [ -f "$dst" ] && [ -s "$dst" ]; then
    echo "[skip] $name (קיים)" | tee -a "$LOG"
    return 0
  fi

  if ffmpeg -nostdin -hwaccel videotoolbox -i "$src" \
      -vf "scale='min(1280,iw)':'min(1280,ih)':force_original_aspect_ratio=decrease:force_divisible_by=2,fps=$FPS" \
      -c:v h264_videotoolbox -b:v "$BITRATE" -maxrate "$MAXRATE" -bufsize 6000k \
      -c:a aac -b:a 128k -movflags +faststart -map_metadata 0 \
      "$dst" -y >/dev/null 2>&1 && [ -s "$dst" ]; then
    local osz nsz
    osz=$(stat -f%z "$src"); nsz=$(stat -f%z "$dst")
    printf "[ok] %-22s %5.1fMB -> %5.1fMB\n" "$name" "$(echo "$osz/1048576"|bc -l)" "$(echo "$nsz/1048576"|bc -l)" | tee -a "$LOG"
  else
    echo "[ERR] $name" | tee -a "$LOG"
    rm -f "$dst" 2>/dev/null
  fi
}
export -f encode_one
export WEB LOG BITRATE MAXRATE FPS

# build file list (newline-delimited; paths have no internal newlines)
LIST=$(find "$SRC" -maxdepth 1 \( -iname '*.mov' -o -iname '*.mp4' \) | sort)
if [ "$LIMIT" -gt 0 ] 2>/dev/null; then
  LIST=$(echo "$LIST" | head -n "$LIMIT")
fi
TOTAL=$(echo "$LIST" | grep -c . || echo 0)

echo "מקור:  $SRC"   | tee -a "$LOG"
echo "יעד:   $WEB"   | tee -a "$LOG"
echo "סרטונים: $TOTAL | במקביל: $PARALLEL | יעד 720p @ ${BITRATE}" | tee -a "$LOG"
echo "------------------------------------------------------------" | tee -a "$LOG"

START=$(date +%s)
echo "$LIST" | grep . | xargs -P "$PARALLEL" -I {} bash -c 'encode_one "$@"' _ {}
END=$(date +%s)

OK=$(grep -c '^\[ok\]' "$LOG"); OK=${OK:-0}
SK=$(grep -c '^\[skip\]' "$LOG"); SK=${SK:-0}
ER=$(grep -c '^\[ERR\]' "$LOG"); ER=${ER:-0}
echo "------------------------------------------------------------" | tee -a "$LOG"
echo "הושלם: $OK | דולג: $SK | שגיאות: $ER | זמן: $(( (END-START)/60 ))ד׳ $(( (END-START)%60 ))ש׳" | tee -a "$LOG"
echo "DONE" | tee -a "$LOG"
