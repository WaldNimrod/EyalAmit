#!/usr/bin/env python3
"""Build image-picker v2: legacy (315) + DOK-WEB new (582) candidates.

Output: hub/dist/image-picker.html
"""
import json, os, re, math

PROJ     = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026"
IMAP     = "/Users/nimrod/Downloads/image-map.json"
LEGACY   = f"{PROJ}/_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/catalog.json"
DOK_IMG  = f"{PROJ}/_COMMUNICATION/team_110/build/catalogs/ea-dok-web/catalog-images.json"
OUT      = f"{PROJ}/_COMMUNICATION/team_110/build/image-picker.html"

# Relative paths from hub/dist/image-picker.html (served from dist root — see
# copy_team110_picker_assets() in scripts/build_eyal_client_hub.py, which mirrors
# the DOK _sm thumbs + theme images into these dist paths so the picker also
# renders live on the published hub, not just when opened as a local file).
LEGACY_BASE = "files/team40/ea-legacy-curated/media/"
DOK_BASE    = "files/team40/ea-dok-web-thumbs/"
THEME_BASE  = "files/team40/site-theme-images/"

# ── Mappings ─────────────────────────────────────────────────────────────────

PAGE_HOOKS = {
    "בית":        ["st-home", "services", "atmosphere", "didgeridoo"],
    "השיטה":      ["about", "atmosphere", "didgeridoo", "st-method"],
    "טיפול":      ["st-svc-treatment", "therapy", "wellness"],
    "סאונד הילינג": ["st-svc-sound", "wellness", "atmosphere"],
    "שיעורים":    ["st-svc-lessons", "didgeridoo", "music"],
    "אודות":      ["st-eyal-hub", "about", "bio"],
    "בלוג":       ["st-blog", "atmosphere"],
    "מוקש":       ["st-eyal-hub", "about"],
    "ספר":        ["st-books", "muzeh", "books"],
}

ROLE_HOOKS = {
    "hero":     ["atmosphere", "services", "didgeridoo"],
    "portrait": ["פורטרט", "bio", "about"],
    "studio":   ["studio", "atmosphere"],
    "workshop": ["workshops", "therapy", "קהילה"],
    "cover":    ["כריכה", "books"],
    "reveal":   ["פורטרט", "bio"],
    "split":    ["studio", "atmosphere"],
    "gallery":  ["atmosphere"],
}

# extract page key from page title
def page_key(page_title):
    for k in PAGE_HOOKS:
        if k in page_title:
            return k
    return None

# extract role hooks from role string
def role_key(role_str):
    r = role_str.lower()
    for k in ROLE_HOOKS:
        if k in r:
            return k
    return None

# crop ratio target from crop string
def crop_ar(crop_str):
    c = crop_str.lower()
    if "16:9" in c or "landscape" in c:
        return 16/9
    if "4:5" in c or "portrait" in c:
        return 4/5
    if "1:1" in c or "square" in c:
        return 1.0
    if "2:3" in c:
        return 2/3
    if "4:3" in c:
        return 4/3
    if "3:4" in c:
        return 3/4
    # look for ratio pattern like "0.75" or "1.5"
    m = re.search(r'(\d+\.?\d*)', c)
    if m:
        return float(m.group(1))
    return None

def orientation_bonus(ar_image, crop_str):
    target = crop_ar(crop_str)
    if target is None:
        return 0.0
    # portrait: ar < 1, landscape: ar > 1
    if target < 1 and ar_image < 1:
        return 0.20
    if target > 1 and ar_image > 1:
        return 0.20
    if abs(target - 1.0) < 0.1 and abs(ar_image - 1.0) < 0.15:
        return 0.12  # square bonus
    return 0.0

# current image → hub path
def current_hub_path(current):
    if not current:
        return None
    if isinstance(current, list):
        imgs = [p for p in current if re.search(r'\.(jpg|jpeg|png|webp)$', p, re.I)]
        return current_hub_path(imgs[0]) if imgs else None
    if re.search(r'\.(mp4|webm|mov)$', current, re.I):
        return None
    fn = current.split("/")[-1]
    # theme images are in assets/photos, assets/covers, etc.
    subdir = current.split("/")[-2] if "/" in current else "photos"
    if subdir in ("photos", "covers", "gallery"):
        return THEME_BASE + f"chapters/{fn}"
    return THEME_BASE + fn


# ── Load data ────────────────────────────────────────────────────────────────

def load_legacy():
    with open(LEGACY) as f:
        raw = json.load(f)
    entries = raw.get("entries", raw) if isinstance(raw, dict) else raw
    result = []
    for e in entries:
        if not e.get("public_id"):
            continue
        tc   = e.get("semantic_content", {})
        tech = e.get("technical", {})
        result.append({
            "pid":    e["public_id"],
            "fn":     e.get("media_filename", e["public_id"] + ".jpg"),
            "ar":     tech.get("aspect_ratio", 1.0),
            "topics": tc.get("topics_he_union", []),
            "hooks":  tc.get("site_hooks_union", []),
            "score":  e.get("relevance_score", 0.5),
            "source": "legacy",
        })
    return result

def load_dok():
    with open(DOK_IMG) as f:
        entries = json.load(f)
    result = []
    for e in entries:
        result.append({
            "pid":    e["id"],
            "fn":     e["sm"],   # use small thumb for picker
            "ar":     e["ar"],
            "topics": [],
            "hooks":  [],
            "score":  0.50,      # base score for new content
            "source": "dok",
            "date":   e.get("dt", ""),
        })
    return result

def load_imap():
    with open(IMAP) as f:
        return json.load(f)


# ── Scoring ───────────────────────────────────────────────────────────────────

def score_candidate(cand, page_title, role_str, crop_str, global_freq):
    base = cand["score"]

    if cand["source"] == "legacy":
        ph = PAGE_HOOKS.get(page_key(page_title), [])
        rk = role_key(role_str)
        rh = ROLE_HOOKS.get(rk, [])

        hook_bonus  = 0.12 * sum(1 for h in cand["hooks"] if h in ph)
        role_bonus  = 0.15 * sum(1 for h in cand["hooks"] if h in rh)
        topic_bonus = 0.20 * sum(1 for t in cand["topics"] if t in rh)

        eyal_bonus = 0.38 if "eyal" in cand["fn"].lower() else 0.0
        book_bonus = 0.30 if ("ספר" in page_title or "כריכה" in cand["topics"]) else 0.0

        base += hook_bonus + role_bonus + topic_bonus + eyal_bonus + book_bonus

    base += orientation_bonus(cand["ar"], crop_str)
    base -= global_freq.get(cand["pid"], 0) * 0.04

    return base


# ── Select candidates per slot ────────────────────────────────────────────────

def select_candidates(all_legacy, all_dok, slots_all, max_per_slot=5, max_dok=2):
    global_freq = {}

    # collect all slots first for freq tracking
    all_slots = []
    for page_data in slots_all:
        page_title = page_data["title"]
        for slot in page_data["slots"]:
            if slot.get("type") == "video":
                continue
            all_slots.append((page_title, slot))

    result = {}

    for page_title, slot in all_slots:
        sid = slot["id"]
        crop = slot.get("crop", "")
        role = slot.get("role", "")

        # score legacy
        scored_leg = sorted(
            [(score_candidate(c, page_title, role, crop, global_freq), c)
             for c in all_legacy],
            key=lambda x: -x[0]
        )[:max_per_slot + 10]  # extra buffer for dedup

        # score dok
        scored_dok = sorted(
            [(score_candidate(c, page_title, role, crop, global_freq), c)
             for c in all_dok],
            key=lambda x: -x[0]
        )[:max_dok + 5]

        # pick: max_dok from dok + rest from legacy, no dups
        chosen = []
        chosen_pids = set()

        for _, c in scored_dok[:max_dok]:
            chosen.append(c)
            chosen_pids.add(c["pid"])
            global_freq[c["pid"]] = global_freq.get(c["pid"], 0) + 1

        remaining = max_per_slot - len(chosen)
        for _, c in scored_leg:
            if c["pid"] not in chosen_pids and len(chosen) < max_per_slot:
                chosen.append(c)
                chosen_pids.add(c["pid"])
                global_freq[c["pid"]] = global_freq.get(c["pid"], 0) + 1

        result[sid] = chosen

    return result


# ── Path builders ─────────────────────────────────────────────────────────────

def img_path(cand):
    if cand["source"] == "legacy":
        return LEGACY_BASE + cand["fn"]
    else:  # dok
        return DOK_BASE + cand["fn"]


# ── Generate HTML ──────────────────────────────────────────────────────────────

def build_html(imap, candidates):
    pages = imap["pages"]

    # build slot data for JS
    all_js_slots = []
    for page_data in pages:
        page_file  = page_data["file"]
        page_title = page_data["title"]
        for slot in page_data.get("slots", []):
            if slot.get("type") == "video":
                continue
            sid    = slot["id"]
            curr   = current_hub_path(slot.get("current"))
            cands  = candidates.get(sid, [])
            js_cands = [{"pid": c["pid"], "src": img_path(c), "src_type": c["source"]} for c in cands]
            all_js_slots.append({
                "id":       sid,
                "page":     page_file,
                "section":  slot.get("section", ""),
                "role":     slot.get("role", ""),
                "crop":     slot.get("crop", ""),
                "current":  curr,
                "cands":    js_cands,
            })

    slots_json = json.dumps(all_js_slots, ensure_ascii=False)

    # build page accordion HTML
    accordions_html = ""
    for page_data in pages:
        page_file  = page_data["file"]
        page_title = page_data["title"]
        img_slots  = [s for s in page_data.get("slots", []) if s.get("type") != "video"]
        if not img_slots:
            continue

        slot_cards = ""
        for slot in img_slots:
            sid   = slot["id"]
            cands = candidates.get(sid, [])
            curr  = current_hub_path(slot.get("current"))

            cand_cards = ""
            if curr:
                cand_cards += f'''<div class="cc cur" data-slot="{sid}" data-pid="__current__" data-src="{curr}" data-d="keep" onclick="pick(this)">
  <img src="{curr}" alt="" loading="lazy" onerror="this.src=''">
  <div class="cl">שמור נוכחי</div>
</div>'''

            for c in cands:
                src = img_path(c)
                badge = '<span class="badge-dok">חדש</span>' if c["source"] == "dok" else ""
                cand_cards += f'''<div class="cc" data-slot="{sid}" data-pid="{c['pid']}" data-src="{src}" data-d="{c['source']}" onclick="pick(this)">
  <img src="{src}" alt="{c['pid']}" loading="lazy" onerror="this.src=''">
  <div class="cl">{c['pid']}{badge}</div>
</div>'''

            slot_cards += f'''<div class="sc" id="sc-{sid}">
  <div class="sh"><span class="ss">{slot.get('section','')}</span><span class="sr">{slot.get('role','')}</span><span class="scp">{slot.get('crop','')}</span></div>
  <div class="cr">{cand_cards}</div>
</div>'''

        safe_id = re.sub(r'[^\w]', '-', page_file)
        accordions_html += f'''<details class="ps" id="pg-{safe_id}">
<summary class="psh">{page_title}</summary>
<div class="psb">{slot_cards}</div>
</details>'''

    total_img_slots = sum(
        1 for p in pages for s in p.get("slots", []) if s.get("type") != "video"
    )

    return f"""<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>בוחר תמונות — אייל עמית</title>
<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;700&family=Frank+Ruhl+Libre:wght@400;700&display=swap" rel="stylesheet">
<style>
:root{{--terra:#a44e2b;--sand:#d8c7b5;--ink:#2e2b28;--cream:#f5f0ea;--muted:#8a7e74;--bg:#faf7f3;--green:#3a7d44}}
*{{box-sizing:border-box;margin:0;padding:0}}
body{{font-family:Heebo,sans-serif;background:var(--bg);color:var(--ink)}}
header{{background:var(--ink);color:#fff;padding:16px 20px;display:flex;align-items:center;gap:16px;flex-wrap:wrap;position:sticky;top:0;z-index:20}}
header h1{{font-family:'Frank Ruhl Libre',serif;font-size:1.4rem}}
header .sub{{color:var(--sand);font-size:.85rem}}
.prog-wrap{{display:flex;align-items:center;gap:10px;margin-right:auto}}
.prog-bar{{width:180px;height:8px;background:#555;border-radius:4px;overflow:hidden}}
.prog-fill{{height:100%;background:var(--terra);border-radius:4px;transition:.3s}}
.prog-txt{{color:var(--sand);font-size:.82rem;min-width:70px}}
.actions{{display:flex;gap:8px}}
.btn{{padding:8px 16px;border:none;border-radius:6px;font-family:inherit;font-size:.85rem;cursor:pointer;font-weight:500}}
.btn-exp{{background:var(--terra);color:#fff}}
.btn-clr{{background:none;border:1px solid #666;color:var(--sand)}}
/* Accordions */
.ps{{border-bottom:1px solid var(--sand);background:#fff}}
.psh{{list-style:none;padding:14px 20px;font-weight:600;font-size:1rem;cursor:pointer;display:flex;align-items:center;gap:8px}}
.psh::after{{content:'▾';font-size:.8rem;color:var(--muted);margin-right:auto}}
details[open] .psh::after{{content:'▴'}}
.psb{{padding:0 16px 16px}}
/* Slot cards */
.sc{{margin:10px 0;background:var(--cream);border-radius:8px;overflow:hidden}}
.sh{{display:flex;gap:8px;padding:8px 12px;background:rgba(0,0,0,.04);font-size:.8rem;align-items:center;flex-wrap:wrap}}
.ss{{font-weight:600;color:var(--ink)}}
.sr{{color:var(--muted)}}
.scp{{font-family:monospace;font-size:.75rem;background:var(--sand);padding:1px 6px;border-radius:3px;color:var(--ink);margin-right:auto}}
.cr{{display:flex;flex-wrap:wrap;gap:8px;padding:10px 12px}}
/* Candidate cards */
.cc{{width:130px;flex:0 0 130px;border-radius:6px;overflow:hidden;border:3px solid transparent;cursor:pointer;transition:.15s;position:relative;background:#ddd}}
.cc:hover{{border-color:var(--sand)}}
.cc.selected,.cc.top{{border-color:var(--terra)}}
.cc.cur{{border-style:dashed;border-color:var(--muted)}}
.cc img{{width:100%;height:100px;object-fit:cover;display:block}}
.cl{{padding:3px 5px;font-size:.68rem;font-family:monospace;text-align:left;direction:ltr;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;background:rgba(255,255,255,.85)}}
.cc.selected .cl,.cc.top .cl{{background:var(--terra);color:#fff}}
.check{{position:absolute;top:4px;right:4px;width:20px;height:20px;background:var(--terra);border-radius:50%;display:none;align-items:center;justify-content:center;color:#fff;font-size:.8rem}}
.cc.selected .check,.cc.top .check{{display:flex}}
.badge-dok{{background:#1a6b3c;color:#fff;border-radius:3px;padding:0 4px;font-size:.6rem;font-family:sans-serif;margin-right:4px}}
/* Sticky export bar */
.export-bar{{position:fixed;bottom:0;left:0;right:0;background:var(--ink);padding:10px 20px;display:flex;align-items:center;gap:12px;z-index:20}}
.export-bar .prog-bar{{width:200px}}
.export-bar .prog-txt{{color:var(--sand)}}
</style>
</head>
<body>
<header>
  <h1>בוחר תמונות</h1>
  <span class="sub">אייל עמית · {total_img_slots} מיקומים</span>
  <div class="prog-wrap">
    <div class="prog-bar"><div class="prog-fill" id="pf" style="width:0%"></div></div>
    <span class="prog-txt" id="pt">0 / {total_img_slots}</span>
  </div>
  <div class="actions">
    <button class="btn btn-exp" onclick="doExport()">ייצוא JSON ⬇</button>
    <button class="btn btn-clr" onclick="clearAll()">אפס הכל</button>
  </div>
</header>

{accordions_html}

<div class="export-bar">
  <div class="prog-bar"><div class="prog-fill" id="pf2" style="width:0%"></div></div>
  <span class="prog-txt" id="pt2">0 / {total_img_slots}</span>
  <button class="btn btn-exp" onclick="doExport()">ייצוא JSON ⬇</button>
</div>

<script>
const TOTAL = {total_img_slots};
const SLOTS = {slots_json};
const KEY   = 'ea-image-picker-v2';

function pick(card) {{
  const slot = card.dataset.slot;
  // deselect others in same slot
  document.querySelectorAll(`.cc[data-slot="${{slot}}"]`).forEach(c => {{
    c.classList.remove('selected','top');
  }});
  card.classList.add('selected');
  save(slot, card.dataset.pid, card.dataset.src, card.dataset.d);
  updateProgress();
}}

function save(sid, pid, src, decision) {{
  const store = JSON.parse(localStorage.getItem(KEY) || '{{}}');
  store[sid] = {{pid, src, decision, ts: Date.now()}};
  localStorage.setItem(KEY, JSON.stringify(store));
}}

function loadSaved() {{
  const store = JSON.parse(localStorage.getItem(KEY) || '{{}}');
  Object.entries(store).forEach(([sid, val]) => {{
    const card = document.querySelector(`.cc[data-slot="${{sid}}"][data-pid="${{val.pid}}"]`);
    if (card) card.classList.add('selected');
  }});
  updateProgress();
}}

function updateProgress() {{
  const store = JSON.parse(localStorage.getItem(KEY) || '{{}}');
  const n = Object.keys(store).length;
  const pct = Math.round(n / TOTAL * 100);
  document.getElementById('pf').style.width  = pct + '%';
  document.getElementById('pf2').style.width = pct + '%';
  document.getElementById('pt').textContent  = n + ' / ' + TOTAL;
  document.getElementById('pt2').textContent = n + ' / ' + TOTAL;
}}

function doExport() {{
  const store = JSON.parse(localStorage.getItem(KEY) || '{{}}');
  const selections = SLOTS
    .filter(s => store[s.id])
    .map(s => {{
      const v = store[s.id];
      const isLegacy = v.decision === 'legacy';
      const isDok    = v.decision === 'dok';
      return {{
        slot_id:     s.id,
        page_file:   s.page,
        section:     s.section,
        role:        s.role,
        crop:        s.crop,
        decision:    v.decision === 'keep' ? 'keep_current' : v.decision,
        current_src: s.current || null,
        selected: {{
          public_id: v.pid === '__current__' ? null : v.pid,
          src:       v.src,
          source:    v.pid === '__current__' ? 'current_theme' : (isDok ? 'dok_web' : 'legacy_catalog'),
        }},
      }};
    }});
  const out = {{
    generated:   new Date().toISOString().slice(0,10),
    version:     '2.0',
    tool:        'image-picker v2 — צוות 110',
    total_slots: TOTAL,
    decided:     selections.length,
    undecided:   TOTAL - selections.length,
    selections,
  }};
  const blob = new Blob([JSON.stringify(out, null, 2)], {{type:'application/json'}});
  const a    = document.createElement('a');
  a.href     = URL.createObjectURL(blob);
  a.download = 'ea-image-selections-' + new Date().toISOString().slice(0,10) + '.json';
  a.click();
}}

function clearAll() {{
  if (!confirm('לאפס את כל הבחירות?')) return;
  localStorage.removeItem(KEY);
  document.querySelectorAll('.cc.selected,.cc.top').forEach(c => c.classList.remove('selected','top'));
  updateProgress();
}}

loadSaved();

// scroll to hash slot on page load (gallery deep-link)
(function() {{
  const h = location.hash.replace('#','');
  if (!h) return;
  const el = document.getElementById(h);
  if (!el) return;
  const details = el.closest('details');
  if (details) details.open = true;
  setTimeout(() => {{
    el.scrollIntoView({{behavior:'smooth', block:'center'}});
    el.style.outline = '3px solid #a44e2b';
    el.style.borderRadius = '6px';
    setTimeout(() => {{ el.style.outline = ''; }}, 2500);
  }}, 150);
}})();
</script>
</body>
</html>"""


# ── Main ──────────────────────────────────────────────────────────────────────

def main():
    print("Loading image-map...")
    imap = load_imap()
    pages = imap["pages"]
    img_slots = sum(1 for p in pages for s in p.get("slots",[]) if s.get("type") != "video")
    print(f"  {len(pages)} pages, {img_slots} image slots")

    print("Loading legacy catalog...")
    legacy = load_legacy()
    print(f"  {len(legacy)} entries")

    print("Loading DOK-WEB catalog...")
    dok = load_dok()
    print(f"  {len(dok)} entries")

    print("Scoring candidates...")
    candidates = select_candidates(legacy, dok, pages)
    total_cands = sum(len(v) for v in candidates.values())
    print(f"  {total_cands} total candidate assignments across {len(candidates)} slots")

    # Export slot-candidates index for gallery reverse lookup
    SLOTS_JSON = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/slot-candidates.json"
    slot_index = {}
    for page_data in pages:
        page_file  = page_data["file"]
        page_title = page_data["title"]
        for slot in page_data.get("slots", []):
            if slot.get("type") == "video":
                continue
            sid = slot["id"]
            if sid not in candidates:
                continue
            for c in candidates[sid]:
                pid = c["pid"]
                if pid not in slot_index:
                    slot_index[pid] = []
                slot_index[pid].append({
                    "slotId":   sid,
                    "page":     page_title,
                    "section":  slot.get("section", ""),
                    "role":     slot.get("role", ""),
                })
    with open(SLOTS_JSON, "w", encoding="utf-8") as f:
        json.dump(slot_index, f, ensure_ascii=False, separators=(',', ':'))
    print(f"Wrote {SLOTS_JSON} ({len(slot_index)} images with slots)")

    print("Building HTML...")
    html = build_html(imap, candidates)
    with open(OUT, "w", encoding="utf-8") as f:
        f.write(html)
    size_kb = os.path.getsize(OUT) // 1024
    print(f"Wrote {OUT} ({size_kb} KB)")
    print("\nDone.")

if __name__ == "__main__":
    main()
