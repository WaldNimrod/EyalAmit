#!/bin/bash
STG="https://eyalamit-co-il-2026.s887.upress.link"
DIR="$1"; u="$2"
safe=$(echo "$u" | tr '/' '_')
HDR="$DIR/parts/$safe.h"
DCODE=$(curl -k -s -o /dev/null -D "$HDR" -w '%{http_code}' --max-time 25 "$STG$u")
LOC=$(grep -iE '^location:' "$HDR" | head -1 | tr -d '\r' | sed 's/^[Ll]ocation: *//')
[ -z "$LOC" ] && LOC="-"
read FCODE NRED UEFF < <(curl -k -s -L -o /dev/null -w '%{http_code} %{num_redirects} %{url_effective}' --max-time 25 "$STG$u")
V="PASS"; { [ "$DCODE" != "200" ] || [ "$LOC" != "-" ]; } && V="FAIL"
printf '%s\t%s\t%s\t%s\t%s\t%s\t%s\n' "$u" "$DCODE" "$LOC" "$FCODE" "$NRED" "$UEFF" "$V" > "$DIR/parts/$safe.row"
rm -f "$HDR"
