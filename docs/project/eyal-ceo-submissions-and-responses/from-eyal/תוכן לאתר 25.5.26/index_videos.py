#!/usr/bin/env python3
"""
DOK Video Index — builds _INDEX_VIDEOS.csv with rich attributes.
Run AFTER process_videos.sh. Pairs each source MOV with its 720p MP4 output.
"""
import csv, json, subprocess
from pathlib import Path

BASE = (Path.home() / "Documents" / "Eyal Amit" / "EyalAmit.co.il-2026"
        / "docs" / "project" / "eyal-ceo-submissions-and-responses"
        / "from-eyal" / "תוכן לאתר 25.5.26")
SRC = BASE / "תמונות וסרטונים DOK אביב"
WEB = BASE / "DOK-WEB" / "videos"
INDEX = BASE / "DOK-WEB" / "_INDEX_VIDEOS.csv"


def probe(path: Path) -> dict:
    try:
        r = subprocess.run(
            ["ffprobe", "-v", "quiet", "-print_format", "json",
             "-show_format", "-show_streams", str(path)],
            capture_output=True, text=True, timeout=60)
        return json.loads(r.stdout)
    except Exception:
        return {}


def vinfo(d: dict) -> dict:
    info = {}
    for s in d.get("streams", []):
        if s.get("codec_type") == "video":
            info["width"] = s.get("width")
            info["height"] = s.get("height")
            info["codec"] = s.get("codec_name")
            fr = s.get("r_frame_rate", "0/1")
            try:
                num, den = fr.split("/")
                info["fps"] = round(int(num) / int(den), 1) if int(den) else None
            except Exception:
                info["fps"] = fr
        if s.get("codec_type") == "audio":
            info["audio_codec"] = s.get("codec_name")
    fmt = d.get("format", {})
    info["duration_sec"] = round(float(fmt["duration"]), 1) if fmt.get("duration") else None
    tags = fmt.get("tags", {})
    info["creation_time"] = (tags.get("creation_time")
                             or tags.get("com.apple.quicktime.creationdate", ""))
    info["location"] = tags.get("com.apple.quicktime.location.ISO6709", "")
    return info


def main():
    sources = sorted(f for f in SRC.glob("*")
                     if f.suffix.lower() in {".mov", ".mp4"})
    rows = []
    tot_in = tot_out = 0
    for n, src in enumerate(sources, 1):
        dst = WEB / (src.stem + ".mp4")
        si = src.stat().st_size
        so = dst.stat().st_size if dst.exists() else 0
        tot_in += si
        tot_out += so
        sm = vinfo(probe(src))
        dm = vinfo(probe(dst)) if dst.exists() else {}
        rows.append({
            "n": n,
            "source_name":   src.name,
            "output_name":   dst.name if dst.exists() else "MISSING",
            "status":        "ok" if dst.exists() and so > 0 else "MISSING",
            "orig_size_mb":  round(si / 1048576, 1),
            "web_size_mb":   round(so / 1048576, 1) if so else "",
            "saved_pct":     round((1 - so / si) * 100, 1) if si and so else "",
            "duration_sec":  sm.get("duration_sec", ""),
            "orig_res":      f'{sm.get("width","")}x{sm.get("height","")}',
            "web_res":       f'{dm.get("width","")}x{dm.get("height","")}' if dm else "",
            "orig_fps":      sm.get("fps", ""),
            "orig_codec":    sm.get("codec", ""),
            "web_codec":     dm.get("codec", ""),
            "creation_time": sm.get("creation_time", ""),
            "location":      sm.get("location", ""),
        })
        if n % 50 == 0:
            print(f"  אינדקס: {n}/{len(sources)}")

    if rows:
        with open(INDEX, "w", newline="", encoding="utf-8-sig") as f:
            w = csv.DictWriter(f, fieldnames=list(rows[0].keys()))
            w.writeheader()
            w.writerows(rows)

    missing = [r for r in rows if r["status"] == "MISSING"]
    print(f"\nאינדקס נכתב: {INDEX}")
    print(f"סה\"כ: {len(rows)} | חסרים: {len(missing)}")
    print(f"נפח מקור: {tot_in/1073741824:.1f}GB | נפח web: {tot_out/1073741824:.2f}GB")
    if tot_in:
        print(f"חיסכון: {(tot_in-tot_out)/1073741824:.1f}GB ({round((1-tot_out/tot_in)*100,1)}%)")
    if missing:
        print("חסרים:", [r["source_name"] for r in missing[:15]])


if __name__ == "__main__":
    main()
