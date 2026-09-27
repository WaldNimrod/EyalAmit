
import re, io, glob, os, json, html, unicodedata, urllib.request, time
from concurrent.futures import ThreadPoolExecutor
S = "/private/tmp/claude-501/-Users-nimrod-Documents-AOS-V5-EyalAmit-co-il-2026/69cc2ac0-b7aa-41fb-87c6-b673a694b602/scratchpad/"
ROOT = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/"
HEB_LO, HEB_HI = chr(0x0590), chr(0x05FF)

def norm(t):
    t = unicodedata.normalize("NFKC", t)
    for ch in (chr(0x200e), chr(0x200f), chr(0x00a0)):
        t = t.replace(ch, " ")
    t = re.sub("[^\\w" + HEB_LO + "-" + HEB_HI + "]+", " ", t)
    return re.sub("\\s+", " ", t).strip()

def strip(h):
    h = re.sub("<(script|style)[^>]*>.*?</\\1>", "", h, flags=re.S | re.I)
    return norm(html.unescape(re.sub("<[^>]+>", " ", h)))

cache = S + "livecorpus.json"
if os.path.exists(cache):
    corpus = json.load(open(cache, encoding="utf-8"))
else:
    live = [l.split("\t")[1] for l in open(S + "nofollow.txt") if l.startswith("200\t")]
    def f(u):
        for _ in range(3):
            try:
                return u, urllib.request.urlopen(u, timeout=45).read().decode("utf-8", "replace")
            except Exception:
                time.sleep(2)
        return u, ""
    corpus = {}
    with ThreadPoolExecutor(max_workers=3) as ex:
        for u, h in ex.map(f, live):
            if h:
                corpus[u] = strip(h)
    json.dump(corpus, open(cache, "w"), ensure_ascii=False)
print("live pages in corpus:", len(corpus))
print()

PHRASE = re.compile("[" + HEB_LO + "-" + HEB_HI + "][" + HEB_LO + "-" + HEB_HI + "\\s]{24,}")
rows = []
files = sorted(glob.glob(ROOT + "site/wp-content/mu-plugins/*.php")) + [ROOT + "scripts/update_moksha_page.py"]
for f in files:
    try:
        src = io.open(f, encoding="utf-8").read()
    except Exception:
        continue
    phrases = set()
    for m in PHRASE.finditer(src):
        p = norm(m.group(0))
        if len(p.split()) >= 5:
            phrases.add(" ".join(p.split()[:7]))
    if not phrases:
        continue
    hits = {}
    for p in phrases:
        where = [u for u, t in corpus.items() if p in t]
        if where:
            hits[p] = where
    rows.append((os.path.basename(f), len(phrases), len(hits), hits))

rows.sort(key=lambda r: -r[2])
print("%-52s %8s %6s" % ("seeder script", "phrases", "LIVE"))
print("-" * 70)
for name, n, live_n, hits in rows:
    flag = "   <-- machine text is on the site" if live_n else ""
    print("%-52s %8d %6d%s" % (name, n, live_n, flag))
json.dump([{"file": r[0], "phrases": r[1], "live": r[2], "hits": r[3]} for r in rows],
          open(S + "seeded_report.json", "w"), ensure_ascii=False, indent=1)
