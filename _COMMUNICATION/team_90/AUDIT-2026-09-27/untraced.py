
import re, io, os, json, glob, unicodedata
S = "/private/tmp/claude-501/-Users-nimrod-Documents-AOS-V5-EyalAmit-co-il-2026/69cc2ac0-b7aa-41fb-87c6-b673a694b602/scratchpad/"
ROOT = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/"
LO, HI = chr(0x0590), chr(0x05FF)

def norm(t):
    t = unicodedata.normalize("NFKC", t)
    for ch in (chr(0x200e), chr(0x200f), chr(0x00a0)):
        t = t.replace(ch, " ")
    t = re.sub("[^\\w" + LO + "-" + HI + "]+", " ", t)
    return re.sub("\\s+", " ", t).strip()

# Everything traceable to Eyal: what he delivered, what he answered, AND the legacy site export
# (his own older writing, imported as blog posts).
parts = []
n = 0
for r in (ROOT + "docs/project/eyal-ceo-submissions-and-responses/from-eyal",
          ROOT + "docs/project/eyal-ssot", ROOT + "hub/ssot"):
    for dp, dn, fn in os.walk(r):
        for f in fn:
            if f.lower().endswith((".md", ".txt", ".json", ".csv", ".html")):
                try:
                    parts.append(norm(io.open(os.path.join(dp, f), encoding="utf-8", errors="replace").read())); n += 1
                except Exception: pass
for f in glob.glob(ROOT + "site/exports/*.wxr"):
    try:
        parts.append(norm(io.open(f, encoding="utf-8", errors="replace").read())); n += 1
    except Exception: pass
EYAL = " ".join(parts)
print("traceable-to-Eyal sources:", n, "files ·", len(EYAL), "chars (includes the legacy site export)")

corpus = json.load(open(S + "livecorpus.json", encoding="utf-8"))
report = json.load(open(S + "seeded_report.json", encoding="utf-8"))

print()
print("For every phrase our own scripts contain AND that is live on the site:")
print("does that phrase also exist in something Eyal gave us?")
print()
print("%-50s %6s %8s %10s" % ("script", "live", "from Eyal", "UNTRACED"))
print("-" * 80)
flagged = []
for r in report:
    if not r["live"]:
        continue
    traced = untraced = 0
    mine = []
    for phrase, where in r["hits"].items():
        if phrase in EYAL:
            traced += 1
        else:
            untraced += 1
            mine.append((phrase, where))
    mark = "   <-- review" if untraced else ""
    print("%-50s %6d %8d %10d%s" % (r["file"][:50], r["live"], traced, untraced, mark))
    if untraced:
        flagged.append((r["file"], mine))

print()
for f, mine in flagged:
    print("===", f)
    for phrase, where in mine[:8]:
        pages = ", ".join(w.replace("http://eyalamit-co-il-2026.s887.upress.link", "")[:34] for w in where[:3])
        print("   ", phrase)
        print("      on:", pages)
json.dump([{"file": f, "items": [{"phrase": p, "pages": w} for p, w in m]} for f, m in flagged],
          open(S + "untraced.json", "w"), ensure_ascii=False, indent=1)
