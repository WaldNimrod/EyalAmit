#!/usr/bin/env python3
"""Reproduces the FALSE-FAILURE artifact the task brief warned about: sampling the
.chap element's whole un-inset bounding RECTANGLE in the recovered-background image
(screenshot B), instead of the real glyph-ink rects filtered to solid-ink pixels.

This drags in the pill's rounded-corner-to-photo blend pixels (several px from any
actual glyph — no reader ever sees them) and produces an artificially low ratio,
in the same range as this task's stated "3.77" / "4.11" failing numbers, on pages
that the correct method (measure_chap.mjs + contrast_sample.py, matching the task's
own detailed methodology) measures at 10.68-12.41:1 on the same screenshots.

Usage: python3 naive_bbox_artifact_repro.py <diag/results.json>
"""
import sys, json, math
from PIL import Image

def srgb_to_linear(c):
    c = c / 255.0
    return c / 12.92 if c <= 0.04045 else ((c + 0.055) / 1.055) ** 2.4

def rel_lum(rgb):
    r, g, b = rgb
    return 0.2126 * srgb_to_linear(r) + 0.7152 * srgb_to_linear(g) + 0.0722 * srgb_to_linear(b)

def contrast(rgb1, rgb2):
    l1, l2 = rel_lum(rgb1), rel_lum(rgb2)
    return (max(l1, l2) + 0.05) / (min(l1, l2) + 0.05)

def main():
    res = json.load(open(sys.argv[1], encoding='utf-8'))
    for r in res:
        imgB = Image.open(r['pathB']).convert('RGB')
        pxB = imgB.load()
        for c in r['chaps']:
            br = c['blockRect']
            x0, y0 = int(br['x']), int(br['y'])
            x1, y1 = int(br['x'] + br['width']), int(br['y'] + br['height'])
            worst = None
            for y in range(y0, y1):
                for x in range(x0, x1):
                    b = pxB[x, y]
                    ratio = contrast((255, 255, 255), b)
                    if worst is None or ratio < worst[0]:
                        worst = (ratio, x, y, b)
            print(f"{r['url']}\n  naive whole-bbox worst (NO radius inset, NO ink filter): "
                  f"{worst[0]:.3f} at ({worst[1]},{worst[2]}) bg={worst[3]}")

if __name__ == '__main__':
    main()
