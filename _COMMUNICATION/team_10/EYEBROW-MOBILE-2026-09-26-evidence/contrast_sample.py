#!/usr/bin/env python3
"""Sample real glyph-rect pixels from two screenshots (A = as-rendered, B = same page with the
label's ink hidden via color:transparent, shadow still painted) and compute worst-case WCAG
contrast at pixels that are genuinely covered by glyph ink in A (filtered by proximity to the
element's own solid computed color), using the background recovered from B at that same pixel.

Reads a JSON job on stdin:
{
  "a": "<path to screenshot A png>",
  "b": "<path to screenshot B png>",
  "chaps": [ { "idx":0, "color":"rgb(r,g,b)"|"rgba(r,g,b,a)", "rects":[{x,y,width,height},...] } ]
}
Writes JSON to stdout: { "chaps": [ {idx, sampleCount, worstRatio, worstPoint, worstA, worstB, fg} ] }
"""
import sys, json, re, math
from PIL import Image

def parse_color(s):
    m = re.match(r'rgba?\(([^)]+)\)', s.strip())
    if not m:
        return (0, 0, 0, 1.0)
    parts = [p.strip() for p in m.group(1).split(',')]
    r, g, b = float(parts[0]), float(parts[1]), float(parts[2])
    a = float(parts[3]) if len(parts) > 3 else 1.0
    return (r, g, b, a)

def srgb_to_linear(c):
    c = c / 255.0
    return c / 12.92 if c <= 0.04045 else ((c + 0.055) / 1.055) ** 2.4

def rel_lum(rgb):
    r, g, b = rgb
    return 0.2126 * srgb_to_linear(r) + 0.7152 * srgb_to_linear(g) + 0.0722 * srgb_to_linear(b)

def contrast(rgb1, rgb2):
    l1, l2 = rel_lum(rgb1), rel_lum(rgb2)
    lighter, darker = max(l1, l2), min(l1, l2)
    return (lighter + 0.05) / (darker + 0.05)

def composite(fg, alpha, bg):
    return tuple(fg[i] * alpha + bg[i] * (1 - alpha) for i in range(3))

def analyze(pathA, pathB, chaps, thresh=45.0):
    imgA = Image.open(pathA).convert('RGB')
    imgB = Image.open(pathB).convert('RGB')
    W, H = imgA.size
    pxA = imgA.load()
    pxB = imgB.load()

    out = {'chaps': []}
    THRESH = thresh  # euclidean RGB distance to count as "solid ink" (excludes AA edge blends)

    for chap in chaps:
        fg_r, fg_g, fg_b, fg_a = parse_color(chap['color'])
        fg = (fg_r, fg_g, fg_b)
        samples = []
        for rect in chap.get('rects', []):
            x0 = max(0, int(math.floor(rect['x'])))
            y0 = max(0, int(math.floor(rect['y'])))
            x1 = min(W, int(math.ceil(rect['x'] + rect['width'])))
            y1 = min(H, int(math.ceil(rect['y'] + rect['height'])))
            for y in range(y0, y1):
                for x in range(x0, x1):
                    a_px = pxA[x, y]
                    dist = math.sqrt(sum((a_px[i] - fg[i]) ** 2 for i in range(3)))
                    if dist <= THRESH:
                        b_px = pxB[x, y]
                        eff_fg = composite(fg, fg_a, b_px)
                        ratio = contrast(eff_fg, b_px)
                        samples.append({'x': x, 'y': y, 'ratio': ratio, 'a': a_px, 'b': b_px})
        if not samples:
            out['chaps'].append({'idx': chap['idx'], 'sampleCount': 0, 'worstRatio': None, 'fg': fg, 'note': 'no ink-proximate pixels found (label may be off-viewport or threshold too tight)'})
            continue
        samples.sort(key=lambda s: s['ratio'])
        worst = samples[0]
        # also report 5th percentile to show it's not a single outlier
        p5 = samples[max(0, int(len(samples) * 0.05))]
        out['chaps'].append({
            'idx': chap['idx'],
            'sampleCount': len(samples),
            'worstRatio': round(worst['ratio'], 3),
            'worstPoint': {'x': worst['x'], 'y': worst['y']},
            'worstA': worst['a'], 'worstB': worst['b'],
            'p5Ratio': round(p5['ratio'], 3),
            'fg': fg, 'fgAlpha': fg_a,
        })
    return out

def main():
    job = json.load(sys.stdin)
    print(json.dumps(analyze(job['a'], job['b'], job['chaps'])))

if __name__ == '__main__':
    main()
