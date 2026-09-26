#!/usr/bin/env python3
"""Dry-run / apply derived alt text into WP post content via REST."""
import json, re, sys, html
sys.path.insert(0, 'scripts')
import wp_rest_client as W

S='/private/tmp/claude-501/-Users-nimrod-Documents-AOS-V5-EyalAmit-co-il-2026/8a34018b-bb57-45a0-b464-69539609f78a/scratchpad/'
APPLY = '--apply' in sys.argv
items=[i for i in json.load(open(S+'alt_merged.json')) if i.get('derived')]
by_page={}
for i in items: by_page.setdefault(i['page'],[]).append(i)

def find_object(url):
    slug=[p for p in url.rstrip('/').split('/') if p][-1]
    for kind in ('pages','posts'):
        try:
            r=W._request('GET', f'/wp/v2/{kind}?slug={slug}&status=publish&context=edit&per_page=5')
        except Exception:
            continue
        if isinstance(r,list):
            for o in r:
                if o.get('link','').rstrip('/')==url.rstrip('/'): return kind,o
            if len(r)==1: return kind,r[0]
    return None,None

tot=matched=changed=0; misses=[]; plan=[]
for page, group in by_page.items():
    kind,obj = find_object(page)
    if not obj:
        misses.append(('no-object',page,len(group))); tot+=len(group); continue
    raw = obj.get('content',{}).get('raw','')
    new = raw; local=0
    for it in group:
        tot+=1
        src=it['src']; alt=it['derived'].replace('"','&quot;')
        tail=src.split('/')[-1]
        # locate the <img ...> whose src ends with this filename
        pat=re.compile(r'<img\b[^>]*?'+re.escape(tail)+r'[^>]*?>', re.I)
        m=pat.search(new)
        if not m: misses.append(('no-img-in-raw',page,tail)); continue
        tag=m.group(0)
        if re.search(r'\balt\s*=\s*"[^"]+"', tag): continue   # already described
        if re.search(r'\balt\s*=', tag):
            newtag=re.sub(r'\balt\s*=\s*(["\'])\s*\1', f'alt="{alt}"', tag, count=1)
        else:
            newtag=tag[:-1].rstrip()+f' alt="{alt}">'
        if newtag!=tag:
            new=new[:m.start()]+newtag+new[m.end():]
            matched+=1; local+=1
    if local and new!=raw:
        plan.append((kind,obj['id'],page,local))
        if APPLY:
            W._request('POST', f'/wp/v2/{kind}/{obj["id"]}', {'content': new})
            changed+=local
print(f"{'APPLIED' if APPLY else 'DRY RUN'}  items with text: {len(items)}  inspected: {tot}  would change: {matched}")
print(f"pages to edit: {len(plan)}")
for k,i,p,n in plan[:40]: print(f"   {n:3d}  {k}/{i}  {p[:90]}")
if misses:
    print(f"\nmisses: {len(misses)}")
    from collections import Counter
    print(' ', Counter(m[0] for m in misses))
    for m in misses[:12]: print('   ',m)
