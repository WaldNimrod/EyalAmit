#!/usr/bin/env python3
"""Drive contrast_sample.py over every page-load in a measure_chap.mjs results.json,
aggregate per (path, viewport) worst ratio, and print a full report + JSON summary."""
import sys, json, subprocess, os

def main():
    results_path = sys.argv[1]
    out_json = sys.argv[2] if len(sys.argv) > 2 else None
    results = json.load(open(results_path, encoding='utf-8'))
    rows = []
    for r in results:
        meta = r.get('meta', {})
        vp = meta.get('viewport', {})
        vpname = 'mobile' if vp.get('mobile') else 'desktop'
        path = meta.get('path', r.get('url'))
        row = {
            'path': path, 'url': r.get('url'), 'viewport': vpname,
            'httpStatus': r.get('httpStatus'), 'navErr': r.get('navErr'),
            'title': r.get('title'), 'navCount': r.get('navCount'),
            'footerCount': r.get('footerCount'), 'phpErr': r.get('phpErr'),
            'chapCount': r.get('chapCount', 0),
        }
        if not r.get('chaps'):
            row['worstRatio'] = None
            row['sampleCount'] = 0
            rows.append(row)
            continue
        job = {'a': r['pathA'], 'b': r['pathB'], 'chaps': r['chaps']}
        try:
            out = subprocess.run(['python3', os.path.join(os.path.dirname(__file__), 'contrast_sample.py')],
                                  input=json.dumps(job), capture_output=True, text=True, timeout=120)
            data = json.loads(out.stdout)
        except Exception as e:
            row['error'] = str(e)
            rows.append(row)
            continue
        worst = None
        totalSamples = 0
        for c in data['chaps']:
            totalSamples += c.get('sampleCount', 0)
            if c.get('worstRatio') is not None:
                if worst is None or c['worstRatio'] < worst:
                    worst = c['worstRatio']
        row['worstRatio'] = worst
        row['sampleCount'] = totalSamples
        row['chapsDetail'] = data['chaps']
        rows.append(row)

    # Summary
    total = len(rows)
    with_chap = [r for r in rows if r['chapCount'] and r['chapCount'] > 0]
    failing = [r for r in with_chap if r['worstRatio'] is not None and r['worstRatio'] < 4.5]
    zero_sample = [r for r in with_chap if not r.get('sampleCount')]
    bad_http = [r for r in rows if r.get('httpStatus') not in (200,) ]
    nav_bad = [r for r in rows if r.get('navCount') != 1]
    footer_bad = [r for r in rows if r.get('footerCount') != 1]
    php_bad = [r for r in rows if r.get('phpErr')]

    print(f"TOTAL page-loads: {total}")
    print(f"page-loads with .phero .chap: {len(with_chap)}")
    print(f"FAILING (<4.5:1): {len(failing)}")
    for r in sorted(failing, key=lambda x: x['worstRatio']):
        print(f"  FAIL {r['worstRatio']:.3f} n={r['sampleCount']} {r['viewport']:8s} {r['path']}")
    print(f"zero-sample chap pages (need review): {len(zero_sample)}")
    for r in zero_sample:
        print(f"  ZERO-SAMPLE {r['viewport']:8s} {r['path']}")
    print(f"bad HTTP: {len(bad_http)}")
    for r in bad_http:
        print(f"  HTTP={r.get('httpStatus')} navErr={r.get('navErr')} {r['viewport']:8s} {r['path']}")
    print(f"nav!=1: {len(nav_bad)}")
    for r in nav_bad:
        print(f"  nav={r.get('navCount')} {r['viewport']:8s} {r['path']}")
    print(f"footer!=1: {len(footer_bad)}")
    for r in footer_bad:
        print(f"  footer={r.get('footerCount')} {r['viewport']:8s} {r['path']}")
    print(f"php errors: {len(php_bad)}")
    for r in php_bad:
        print(f"  {r['viewport']:8s} {r['path']}")

    if with_chap:
        worst_overall = min((r for r in with_chap if r['worstRatio'] is not None), key=lambda x: x['worstRatio'])
        print(f"\nWORST OVERALL: {worst_overall['worstRatio']:.3f} n={worst_overall['sampleCount']} {worst_overall['viewport']} {worst_overall['path']}")

    if out_json:
        json.dump(rows, open(out_json, 'w', encoding='utf-8'), ensure_ascii=False, indent=1)

if __name__ == '__main__':
    main()
