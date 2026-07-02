#!/usr/bin/env python3
"""
DOK Media Processor
MOV → MP4 (H.264 VideoToolbox, 30fps, web-ready)
HEIC → JPG (sips, 85% quality, EXIF preserved)
PNG/JPG → copy as-is
AAE → skip (Apple Photos metadata, useless without Photos.app)
Generates INDEX.json + INDEX.csv with rich attributes.
Idempotent: re-run after download completes to pick up new files.
"""

import os, json, csv, subprocess, sys, shutil, time
from pathlib import Path
from datetime import datetime
from concurrent.futures import ThreadPoolExecutor, as_completed
import threading

SOURCE = (
    Path.home() / "Documents" / "Eyal Amit" / "EyalAmit.co.il-2026"
    / "docs" / "project" / "eyal-ceo-submissions-and-responses"
    / "from-eyal" / "תוכן לאתר 25.5.26" / "תמונות וסרטונים DOK אביב"
)
DEST        = SOURCE.parent / "DOK-WEB"
INDEX_JSON  = DEST / "_INDEX.json"
INDEX_CSV   = DEST / "_INDEX.csv"
LOG_FILE    = DEST / "_process.log"
PARALLEL    = 5   # workers (5 of 10 cores — rest for system + ongoing download)

SKIP_EXTS   = {".aae", ".icon"}
VIDEO_EXTS  = {".mov", ".mp4"}
HEIC_EXTS   = {".heic"}
COPY_EXTS   = {".jpg", ".jpeg", ".png", ".gif", ".webp", ".pdf"}

_log_lock = threading.Lock()


def log(msg: str, also_print=True):
    ts = datetime.now().strftime("%H:%M:%S")
    line = f"[{ts}] {msg}"
    if also_print:
        try:
            print(line, flush=True)
        except (BrokenPipeError, OSError):
            pass
    with _log_lock:
        with open(LOG_FILE, "a", encoding="utf-8") as f:
            f.write(line + "\n")


def run(cmd, timeout=600):
    return subprocess.run(
        cmd, capture_output=True, text=True, timeout=timeout
    )


def get_video_meta(path: Path) -> dict:
    meta = {"media_type": "video"}
    try:
        r = run(["ffprobe", "-v", "quiet", "-print_format", "json",
                 "-show_format", "-show_streams", str(path)])
        d = json.loads(r.stdout)
        for s in d.get("streams", []):
            if s.get("codec_type") == "video":
                meta["width"]         = s.get("width")
                meta["height"]        = s.get("height")
                meta["video_codec"]   = s.get("codec_name")
                meta["fps"]           = s.get("r_frame_rate")
                raw_dur = s.get("duration") or d.get("format", {}).get("duration")
                meta["duration_sec"]  = round(float(raw_dur), 2) if raw_dur else None
            if s.get("codec_type") == "audio":
                meta["audio_codec"]   = s.get("codec_name")
                meta["audio_channels"]= s.get("channels")
        fmt  = d.get("format", {})
        tags = fmt.get("tags", {})
        meta["creation_time"] = (tags.get("creation_time")
                                  or tags.get("com.apple.quicktime.creationdate"))
        meta["location"]      = tags.get("com.apple.quicktime.location.ISO6709")
        meta["original_bitrate_kbps"] = (
            round(int(fmt["bit_rate"]) / 1000) if fmt.get("bit_rate") else None
        )
    except Exception as e:
        meta["meta_error"] = str(e)
    return meta


def get_image_meta(path: Path) -> dict:
    meta = {"media_type": "image"}
    try:
        r = run(["mdls",
                 "-name", "kMDItemPixelWidth",
                 "-name", "kMDItemPixelHeight",
                 "-name", "kMDItemContentCreationDate",
                 "-name", "kMDItemGPSLatitude",
                 "-name", "kMDItemGPSLongitude",
                 "-name", "kMDItemColorSpace",
                 "-name", "kMDItemBitsPerSample",
                 "-name", "kMDItemAcquisitionMake",
                 "-name", "kMDItemAcquisitionModel",
                 "-name", "kMDItemExposureTimeSeconds",
                 "-name", "kMDItemFNumber",
                 "-name", "kMDItemISOSpeed",
                 str(path)], timeout=15)
        for line in r.stdout.splitlines():
            if "=" not in line:
                continue
            k, v = line.split("=", 1)
            k, v = k.strip(), v.strip().strip('"')
            if v in ("(null)", ""):
                continue
            mapping = {
                "kMDItemPixelWidth":            ("width", int),
                "kMDItemPixelHeight":           ("height", int),
                "kMDItemContentCreationDate":   ("creation_time", str),
                "kMDItemGPSLatitude":           ("gps_lat", float),
                "kMDItemGPSLongitude":          ("gps_lon", float),
                "kMDItemColorSpace":            ("color_space", str),
                "kMDItemBitsPerSample":         ("bits_per_sample", int),
                "kMDItemAcquisitionMake":       ("camera_make", str),
                "kMDItemAcquisitionModel":      ("camera_model", str),
                "kMDItemExposureTimeSeconds":   ("exposure_sec", float),
                "kMDItemFNumber":               ("f_number", float),
                "kMDItemISOSpeed":              ("iso_speed", int),
            }
            if k in mapping:
                field, cast = mapping[k]
                try:
                    meta[field] = cast(v)
                except Exception:
                    pass
    except Exception as e:
        meta["meta_error"] = str(e)
    return meta


def convert_video(src: Path, dst: Path) -> tuple[bool, str]:
    dst.parent.mkdir(parents=True, exist_ok=True)
    if dst.exists() and dst.stat().st_size > 0:
        return True, "skipped"
    tmp = dst.with_suffix(".tmp.mp4")
    r = run([
        "ffmpeg", "-i", str(src),
        "-vf", "fps=30",
        "-c:v", "h264_videotoolbox",
        "-profile:v", "high",
        "-b:v", "5M", "-maxrate", "8M", "-bufsize", "12M",
        "-c:a", "aac", "-b:a", "128k",
        "-movflags", "+faststart",
        "-map_metadata", "0",
        "-y", str(tmp)
    ], timeout=1200)
    if r.returncode == 0 and tmp.exists() and tmp.stat().st_size > 0:
        tmp.rename(dst)
        return True, "converted"
    if tmp.exists():
        tmp.unlink()
    return False, f"ffmpeg error: {r.stderr[-300:] if r.stderr else 'unknown'}"


def convert_heic(src: Path, dst: Path) -> tuple[bool, str]:
    dst.parent.mkdir(parents=True, exist_ok=True)
    if dst.exists() and dst.stat().st_size > 0:
        return True, "skipped"
    r = run([
        "sips", "-s", "format", "jpeg",
        "-s", "formatOptions", "85",
        str(src), "--out", str(dst)
    ], timeout=60)
    return (r.returncode == 0 and dst.exists(), "converted" if r.returncode == 0 else f"sips error: {r.stderr}")


def copy_file(src: Path, dst: Path) -> tuple[bool, str]:
    dst.parent.mkdir(parents=True, exist_ok=True)
    if dst.exists() and dst.stat().st_size > 0:
        return True, "skipped"
    shutil.copy2(str(src), str(dst))
    return True, "copied"


def process_file(src: Path, counter: dict) -> dict:
    ext  = src.suffix.lower()
    rel  = src.relative_to(SOURCE)

    entry = {
        "source_path":          str(src),
        "source_name":          src.name,
        "relative_folder":      str(rel.parent),
        "original_ext":         ext,
        "size_bytes_original":  src.stat().st_size,
    }

    if ext in SKIP_EXTS:
        entry["status"] = "skipped_aae"
        return entry

    if ext in VIDEO_EXTS:
        entry.update(get_video_meta(src))
        dst = DEST / rel.parent / (src.stem + ".mp4")
        ok, status = convert_video(src, dst)

    elif ext in HEIC_EXTS:
        entry.update(get_image_meta(src))
        dst = DEST / rel.parent / (src.stem + ".jpg")
        ok, status = convert_heic(src, dst)

    elif ext in COPY_EXTS:
        entry.update(get_image_meta(src))
        dst = DEST / rel
        ok, status = copy_file(src, dst)

    else:
        dst = DEST / rel
        ok, status = copy_file(src, dst)
        entry["media_type"] = "other"

    entry["output_path"]         = str(dst)
    entry["output_name"]         = dst.name
    entry["status"]              = status if ok else "error"
    entry["size_bytes_output"]   = dst.stat().st_size if dst.exists() else 0
    if ok and entry["size_bytes_original"] > 0 and entry.get("size_bytes_output"):
        ratio = entry["size_bytes_output"] / entry["size_bytes_original"]
        entry["compression_ratio"] = round(ratio, 3)

    with _log_lock:
        counter["done"] = counter.get("done", 0) + (1 if ok and status != "skipped" else 0)
        counter["skip"] = counter.get("skip", 0) + (1 if status == "skipped" else 0)
        counter["err"]  = counter.get("err",  0) + (1 if not ok else 0)
        n = counter.get("n", 0) + 1
        counter["n"] = n
        total = counter.get("total", "?")
        flag  = "✓" if ok else "✗"
        log(f"[{n}/{total}] {flag} {status:12s}  {rel}")

    return entry


def save_index(index: list):
    with open(INDEX_JSON, "w", encoding="utf-8") as f:
        json.dump(index, f, ensure_ascii=False, indent=2, default=str)
    if index:
        all_keys = []
        seen = set()
        for e in index:
            for k in e.keys():
                if k not in seen:
                    all_keys.append(k)
                    seen.add(k)
        with open(INDEX_CSV, "w", newline="", encoding="utf-8-sig") as f:
            w = csv.DictWriter(f, fieldnames=all_keys, extrasaction="ignore")
            w.writeheader()
            for e in index:
                w.writerow({k: e.get(k, "") for k in all_keys})


def load_existing_index() -> tuple[list, set]:
    if INDEX_JSON.exists():
        with open(INDEX_JSON, encoding="utf-8") as f:
            data = json.load(f)
        processed = {e["source_path"] for e in data if e.get("status") not in ("error", None)}
        return data, processed
    return [], set()


def main():
    DEST.mkdir(parents=True, exist_ok=True)
    log("=" * 60)
    log(f"מקור:  {SOURCE}")
    log(f"יעד:   {DEST}")
    log(f"workers: {PARALLEL}")

    index, already_done = load_existing_index()
    log(f"כבר עובדו קודם: {len(already_done)} קבצים")

    all_files = [f for f in sorted(SOURCE.rglob("*")) if f.is_file()]
    pending   = [f for f in all_files if str(f) not in already_done]

    log(f"סה\"כ בתיקייה: {len(all_files)}  |  לעיבוד עכשיו: {len(pending)}")

    if not pending:
        log("אין קבצים חדשים לעיבוד.")
        save_index(index)
        return

    counter = {"total": len(pending), "done": 0, "skip": 0, "err": 0, "n": 0}

    with ThreadPoolExecutor(max_workers=PARALLEL) as ex:
        futures = {ex.submit(process_file, f, counter): f for f in pending}
        for fut in as_completed(futures):
            try:
                entry = fut.result()
                with _log_lock:
                    index.append(entry)
                    if counter["n"] % 50 == 0:
                        save_index(index)
            except Exception as e:
                log(f"שגיאה בלתי צפויה: {e}")

    save_index(index)

    log("=" * 60)
    log(f"סיכום: עובדו {counter['done']} | דולגו {counter['skip']} | שגיאות {counter['err']}")
    log(f"אינדקס JSON: {INDEX_JSON}")
    log(f"אינדקס CSV:  {INDEX_CSV}")

    if counter["err"] > 0:
        errors = [e for e in index if e.get("status") == "error"]
        log(f"\nקבצים שנכשלו ({len(errors)}):")
        for e in errors:
            log(f"  ✗ {e['source_name']}: {e.get('status_detail', '')}")


if __name__ == "__main__":
    main()
