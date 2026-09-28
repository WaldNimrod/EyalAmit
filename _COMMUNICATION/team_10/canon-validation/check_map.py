#!/usr/bin/env python3
"""Canon map validation, lanes 3 and 4 — a re-runnable checker.

Mandate: _COMMUNICATION/team_10/canon-validation/LANE-3-4-RULES-AND-COMPLETENESS.md

The rules come from the written canon only (CONTENT-TYPES-CANON.md, «Canon terms and site-wide rules» and «Grid rules»)
and from the locked compositions as they RENDER in canon-map/grids.html. The map's build code is not read to learn
what the map intends; lane 3 measures what renders in a real browser (headless Chromium over CDP, via node).
tools/canon_types.py and tools/uses.json are read as DATA for lane 4.

Usage (from anywhere):
    python3 _COMMUNICATION/team_10/canon-validation/check_map.py [--pages DIR] [--work DIR] [--no-rebuild] [--fetch]

  --pages DIR   directory holding the pages fetched by tools/fetch.py (default: fetch them into the work dir)
  --work DIR    scratch directory (default: a new temp dir). Nothing is written into canon-map/.
  --fetch       ignore --pages and run tools/fetch.py into the work dir
  --no-rebuild  skip the byte-for-byte rebuild check

Writes VERDICT-LANE-3-4.md next to this file. Needs: node 18+, a chrome-headless-shell (env CHROME or the
ms-playwright cache), python3 with bs4 + lxml (the map's own tools need them).
"""
import argparse, glob, html, importlib.util, json, os, re, shutil, subprocess, sys, tempfile, datetime

HERE = os.path.dirname(os.path.abspath(__file__))
REPO = os.environ.get("EA_REPO") or os.path.abspath(os.path.join(HERE, "..", "..", ".."))
CM = os.path.join(REPO, "_COMMUNICATION", "team_10", "canon-map")
TOOLS = os.path.join(CM, "tools")
CANON = os.path.join(REPO, "_COMMUNICATION", "team_100", "EYAL-WORKSPACE", "CONTENT-TYPES-CANON.md")
STATE = os.path.join(REPO, "_COMMUNICATION", "team_10", "CANON-STAGE-A-STATE.md")
README = os.path.join(CM, "README.md")
VERDICT = os.path.join(HERE, "VERDICT-LANE-3-4.md")

# ---- the canon's grid (Grid rules §1): six equal columns on the 1104px content width at 1440, gutter 10, col 1 = right
VW, VH, PW, PH = 1440, 900, 375, 812
CBX, CBR, GAP = 168.0, 1272.0, 10.0
COLW = (CBR - CBX - 5 * GAP) / 6
TOL = 1.5
RIGHT = {k: CBR - (k - 1) * (COLW + GAP) for k in range(1, 7)}
LEFT = {k: RIGHT[k] - COLW for k in range(1, 7)}
LINES = sorted(list(RIGHT.values()) + list(LEFT.values()))


def near_line(x):
    d = min(abs(x - l) for l in LINES)
    return d, min(LINES, key=lambda l: abs(x - l))


def col_right(x):
    for k, v in RIGHT.items():
        if abs(v - x) <= TOL:
            return k
    return None


def col_left(x):
    for k, v in LEFT.items():
        if abs(v - x) <= TOL:
            return k
    return None


L3LIB = r'''(() => {
// Lane-3 measurement library. Runs inside the rendered map page. Pure measurement: no rule knowledge beyond
// the canon's content-box width (1104 at 1440) used to decide what counts as "wider than the content box".
const L = {};
const R1 = v => Math.round(v * 10) / 10;
const isMedia = el => /^(IMG|VIDEO|IFRAME|PICTURE|SVG|CANVAS)$/i.test(el.tagName) ||
  (el.classList && (el.classList.contains('cm-vid'))) ||
  ((el.tagName === 'FIGURE' || el.tagName === 'SPAN' || el.tagName === 'DIV') && !el.textContent.trim() && el.querySelectorAll('img,video,iframe').length === 1);
const hasOwnText = el => [...el.childNodes].some(n => n.nodeType === 3 && n.textContent.trim());
const isControl = el => el.tagName === 'NAV' || /(^|[\s_-])(nav|dots|pagination|filter)([\s_-]|$)/.test(el.className && typeof el.className === 'string' ? el.className : '');
const cls = el => (el.className && typeof el.className === 'string') ? el.className.trim().split(/\s+/).join('.') : '';
const name = el => el.tagName.toLowerCase() + (cls(el) ? '.' + cls(el) : '');
const TEXTTAG = /^(H1|H2|H3|H4|H5|H6|P|LI|BLOCKQUOTE|FIGCAPTION|DT|DD|SUMMARY|LABEL|A|BUTTON|SPAN|STRONG|B|EM|SMALL|TIME|CITE)$/;

L.prepare = async () => {
  document.querySelectorAll('details.cm-row').forEach(d => d.open = true);
  document.querySelectorAll('.cm-panel').forEach(p => p.classList.add('is-on'));
  document.querySelectorAll('img[loading]').forEach(i => i.loading = 'eager');
  window.scrollTo(0, 0);
  const t0 = Date.now();
  while (Date.now() - t0 < 20000) {
    const pend = [...document.images].filter(i => !i.complete && getComputedStyle(i).display !== 'none');
    if (!pend.length) break;
    await new Promise(r => setTimeout(r, 250));
  }
  try { await document.fonts.ready; } catch (e) {}
  await new Promise(r => setTimeout(r, 1200));
  return { images: document.images.length, broken: [...document.images].filter(i => i.complete && i.naturalWidth === 0 && getComputedStyle(i).display !== 'none').map(i => i.getAttribute('src')).slice(0, 20) };
};

function clipsX(el) { const o = getComputedStyle(el); return /(hidden|clip|auto|scroll)/.test(o.overflowX); }

L.measure = () => {
  const V = document.documentElement.clientWidth;
  const CBW = 1104; // canon: content width at 1440 (used only to recognise wrappers wider than the content box)
  const out = { viewport: V, scrollWidth: document.documentElement.scrollWidth, clientWidth: V, specs: [] };
  const specs = [...document.querySelectorAll('.cm-spec.cm-appr')];
  specs.forEach((spec, si) => {
    const row = spec.closest('.cm-row');
    const lab = spec.previousElementSibling && /cm-variant|av-ex/.test(spec.previousElementSibling.className) ? spec.previousElementSibling.textContent.trim() : '';
    const kid = spec.previousElementSibling && spec.previousElementSibling.id || '';
    const sr = spec.getBoundingClientRect();
    const bdg = spec.querySelector('.cm-appr__badge');
    const S = { badge: bdg ? (() => { const r = bdg.getBoundingClientRect(); return { x: r.left, y: r.top + scrollY, w: r.width, h: r.height }; })() : null, i: si, row: row ? row.id : null, kid, label: lab, top: R1(sr.top + scrollY), left: R1(sr.left), width: R1(sr.width), height: R1(sr.height),
      wraps: [], boxes: [], containers: [], controls: [], decos: [], texts: [], overflow: [] };
    let nid = 0;
    const domKey = el => { const k = []; let e = el; while (e && e !== spec) { k.unshift([...e.parentElement.children].indexOf(e)); e = e.parentElement; } return k.join('.'); };
    const idOf = el => { if (!el.dataset.l3) el.dataset.l3 = si + ':' + (nid++); return el.dataset.l3; };
    const rect = el => { const r = el.getBoundingClientRect(); return { x: R1(r.left), r: R1(r.right), t: R1(r.top + scrollY), b: R1(r.bottom + scrollY), w: R1(r.width), h: R1(r.height) }; };
    const visKids = el => {
      const res = [];
      for (const c of el.children) {
        const cs = getComputedStyle(c);
        if (cs.display === 'none' || cs.visibility === 'hidden') continue;
        if (c.classList.contains('cm-appr__badge')) continue;
        if (cs.display === 'contents') { res.push(...visKids(c)); continue; }
        const r = c.getBoundingClientRect();
        if (r.width < 1 || r.height < 1) continue;
        res.push(c);
      }
      return res;
    };
    // the content-box band of the nearest wrapper (padding removed)
    const contentBox = el => { const cs = getComputedStyle(el); const r = el.getBoundingClientRect();
      return { x: R1(r.left + parseFloat(cs.paddingLeft) + parseFloat(cs.borderLeftWidth)), r: R1(r.right - parseFloat(cs.paddingRight) - parseFloat(cs.borderRightWidth)) }; };
    // fraction of an element's box that its clipping ancestors (inside the spec) cut away, and the clipper
    const clipInfo = (q, from) => {
      let p = from, cut = 0, who = null;
      const area = Math.max(1, q.w * q.h);
      while (p && p !== spec.parentElement) {
        const pc = getComputedStyle(p);
        if (/(hidden|clip|auto|scroll)/.test(pc.overflowX + ' ' + pc.overflowY)) {
          const pr = p.getBoundingClientRect();
          const ix = Math.max(0, Math.min(q.x + q.w, pr.right) - Math.max(q.x, pr.left));
          const iy = Math.max(0, Math.min(q.y + q.h - scrollY, pr.bottom) - Math.max(q.y - scrollY, pr.top));
          const c2 = 1 - (ix * iy) / area;
          if (c2 > cut) { cut = c2; who = name(p); }
        }
        p = p.parentElement;
      }
      return { cut: Math.round(cut * 100) / 100, who };
    };
    const clippedOut = el => { const r = el.getBoundingClientRect(); if (r.width < 1 || r.height < 1) return false;
      return clipInfo({ x: r.left, y: r.top + scrollY, w: r.width, h: r.height }, el.parentElement).cut >= 0.99; };
    function walk(el, ctx) {
      const kids = visKids(el);
      const layoutKids = [];
      for (const c of kids) {
        const cs = getComputedStyle(c);
        const r = c.getBoundingClientRect();
        const abs = cs.position === 'absolute' || cs.position === 'fixed';
        const path = ctx.path + ' > ' + name(c);
        if (abs && (c.getAttribute('aria-hidden') === 'true' || isMedia(c) || !c.textContent.trim())) {
          S.decos.push({ id: idOf(c), path, ...rect(c), media: !!isMedia(c) });
          continue;
        }
        if (isControl(c)) { S.controls.push({ id: idOf(c), path, ...rect(c), n: visKids(c).length }); continue; }
        const wide = V >= 1200 ? r.width > CBW + 3 : r.width >= V - 1;
        if (wide) {
          if (isMedia(c)) { S.decos.push({ id: idOf(c), path, ...rect(c), media: true, fullbleed: true }); continue; }
          const cb = contentBox(c);
          S.wraps.push({ id: idOf(c), path, ...rect(c), cbx: cb.x, cbr: cb.r, cbw: R1(cb.r - cb.x) });
          walk(c, { ...ctx, path, wrapCB: cb });
          continue;
        }
        layoutKids.push(c);
      }
      const recs = layoutKids.map(c => ({ c, r: rect(c) }));
      // side-by-side = two children overlapping vertically
      let sideBySide = false;
      for (let a = 0; a < recs.length; a++) for (let b = a + 1; b < recs.length; b++) {
        const A = recs[a].r, B = recs[b].r;
        if (Math.min(A.b, B.b) - Math.max(A.t, B.t) > 2 && (A.r <= B.x + 2 || B.r <= A.x + 2)) sideBySide = true;
      }
      const textKids = layoutKids.some(c => /^(H1|H2|H3|H4|H5|H6|P)$/.test(c.tagName));
      const ecs = getComputedStyle(el);
      const colCount = ecs.columnCount !== 'auto' ? +ecs.columnCount : 0;
      let cont = null;
      if (layoutKids.length >= 2 && sideBySide) {
        cont = { id: idOf(el), key: domKey(el), path: ctx.path, ...rect(el), display: ecs.display, columns: colCount, textGrid: textKids, items: [] };
        S.containers.push(cont);
      }
      for (const { c, r } of recs) {
        const path = ctx.path + ' > ' + name(c);
        const cs = getComputedStyle(c);
        const bw = parseFloat(cs.borderTopWidth) + parseFloat(cs.borderRightWidth) + parseFloat(cs.borderLeftWidth);
        const bg = cs.backgroundColor, bgi = cs.backgroundImage;
        const framed = bw > 0 || (bg && !/rgba\(0, 0, 0, 0\)|transparent/.test(bg)) || cs.boxShadow !== 'none' || bgi !== 'none' ||
          [...c.children].some(k => { const kc = getComputedStyle(k); return (kc.position === 'absolute') && (isMedia(k) || kc.backgroundImage !== 'none') && k.getBoundingClientRect().width >= r.w - 2 && k.getBoundingClientRect().height >= r.h - 2; });
        const media = !!isMedia(c) || (c.tagName === 'FIGURE' && !!c.querySelector('img,video,iframe'));
        const im = c.matches('img,video') ? c : c.querySelector('img,video');
        const box = { id: idOf(c), key: domKey(c), fit: im ? getComputedStyle(im).objectFit : null, path, tag: c.tagName.toLowerCase(), cls: cls(c), ...r, isItem: !!cont, framed, media, text: c.textContent.trim().replace(/\s+/g, ' ').slice(0, 50) };
        // first-level visible content edges (for unframed items: does the visible content reach the item edge?)
        if (cont && !framed && !media) {
          const inner = visKids(c).filter(k => { const kc = getComputedStyle(k); return kc.position !== 'absolute' && !/^inline/.test(kc.display); }).map(rect);
          if (inner.length) { box.innerX = Math.min(...inner.map(q => q.x)); box.innerR = Math.max(...inner.map(q => q.r)); }
        }
        box.hidden = clippedOut(c);
        if (c.dataset) c.dataset.l3item = cont ? '1' : '';
        S.boxes.push(box);
        if (cont) cont.items.push({ id: box.id, key: box.key, fit: box.fit, x: r.x, r: r.r, t: r.t, b: r.b, w: r.w, h: r.h, tag: box.tag, cls: box.cls, media, text: box.text.slice(0, 20),
          img: !!c.querySelector('img,video,iframe,.cm-vid') || media, clippedBy: null });
        // descend into full-width containers only (items stop the walk)
        const cb = ctx.wrapCB;
        const fullWidth = cb ? (Math.abs(r.x - cb.x) <= 4 && Math.abs(r.r - cb.r) <= 4) : false;
        const hasBlockKids = visKids(c).some(k => !/^(inline|inline-block|inline-flex)$/.test(getComputedStyle(k).display));
        const leafTag = /^(H1|H2|H3|H4|H5|H6|P|UL|OL|FIGURE|ARTICLE|A|LI|BLOCKQUOTE|ASIDE|IFRAME)$/.test(c.tagName);
        const phone = V < 1200;
        if (!framed && !media && !leafTag && hasBlockKids && !cont && (fullWidth || phone)) walk(c, { ...ctx, path, wrapCB: phone ? contentBox(c) : ctx.wrapCB });
        // carousels: a track wider than a clipping viewport
        if (clipsX(c) && c.scrollWidth > c.clientWidth + 2) box.clipsTrack = true;
      }
    }
    const root = spec;
    const firstSec = visKids(root)[0];
    // spec itself is full-bleed (1440). Treat the section as the first wrapper.
    walk(root, { path: 'spec', wrapCB: null });

    // items clipped by a carousel viewport
    for (const cont of S.containers) {
      const el = document.querySelector(`[data-l3="${cont.id}"]`);
      let p = el, clip = null;
      while (p && p !== spec) { if (clipsX(p)) { clip = p.getBoundingClientRect(); break; } p = p.parentElement; }
      if (clip) for (const it of cont.items) {
        if (it.r <= clip.left + 1 || it.x >= clip.right - 1) it.clippedBy = 'hidden';
        else if (it.x < clip.left - 1 || it.r > clip.right + 1) it.clippedBy = 'partial';
      }
    }

    // text blocks
    const walker = document.createTreeWalker(spec, NodeFilter.SHOW_TEXT);
    const seen = new Map();
    let n;
    while ((n = walker.nextNode())) {
      if (!n.textContent.trim()) continue;
      const pe = n.parentElement;
      if (!pe || pe.closest('.cm-appr__badge,script,style,noscript,svg')) continue;
      const pcs = getComputedStyle(pe);
      if (pcs.display === 'none' || pcs.visibility === 'hidden') continue;
      if (pe.closest('details:not([open]) > :not(summary)')) continue;
      let blk = pe;
      while (blk !== spec && /^inline/.test(getComputedStyle(blk).display) && blk.parentElement) blk = blk.parentElement;
      const range = document.createRange(); range.selectNodeContents(n);
      const rects = [...range.getClientRects()].filter(q => q.width > 0.5 && q.height > 0.5).map(q => ({ x: R1(q.left), y: R1(q.top + scrollY), w: R1(q.width), h: R1(q.height) }));
      if (!rects.length) continue;
      // opacity chain
      let op = 1, q = pe; while (q && q !== document.body) { op *= parseFloat(getComputedStyle(q).opacity); q = q.parentElement; }
      const fs = parseFloat(pcs.fontSize), fw = parseInt(pcs.fontWeight, 10) || 400;
      const key = idOf(blk);
      if (!seen.has(key)) {
        const bcs = getComputedStyle(blk);
        const br = rect(blk);
        const lh = parseFloat(bcs.lineHeight) || fs * 1.5;
        const inItem = !!blk.closest('[data-l3item="1"]') && blk.closest('[data-l3item="1"]') !== null;
        let card = null; let p2 = blk;
        while (p2 && p2 !== spec) { const c2 = getComputedStyle(p2); if (p2 !== blk && (parseFloat(c2.borderTopWidth) > 0 || parseFloat(c2.borderRightWidth) > 0) && !/^(SECTION|HEADER)$/.test(p2.tagName)) { card = name(p2); break; } p2 = p2.parentElement; }
        seen.set(key, { id: key, tag: blk.tagName.toLowerCase(), cls: cls(blk), path: name(blk.parentElement) + ' > ' + name(blk), x: br.x, r: br.r, t: br.t, h: br.h,
          lines: Math.max(1, Math.round(br.h / lh)), ta: bcs.textAlign, tal: bcs.textAlignLast, dir: bcs.direction,
          inItem, card, hero: !!blk.closest('.phero,.hero'), cta: !!blk.closest('.cta-band'), btn: !!pe.closest('.btn,button,.ea-blog-filter__item,.page-numbers,summary'), ctrl: !!pe.closest('nav,[class*="__nav"],[class*="dots"],[class*="pagination"],[class*="filter"]'),
          chap: !!blk.closest('.chap'), heading: /^H[1-6]$/.test(blk.tagName) || !!blk.closest('h1,h2,h3,h4,h5,h6'),
          text: blk.textContent.trim().replace(/\s+/g, ' ').slice(0, 60), runs: [] });
      }
      // share of the run's line boxes cut away by clipping ancestors (a line-clamp on the text's own block is truncation by design)
      const clampEl = pe.closest('*') && [pe, blk].find(e => { const c = getComputedStyle(e); return c.webkitLineClamp && c.webkitLineClamp !== 'none'; });
      const ci = rects.map(q => clipInfo(q, clampEl ? clampEl.parentElement : pe));
      const tot = rects.reduce((a, q) => a + q.w * q.h, 0) || 1;
      const cutW = ci.reduce((a, c, k) => a + c.cut * rects[k].w * rects[k].h, 0) / tot;
      const cutMax = Math.max(...ci.map(c => c.cut));
      seen.get(key).runs.push({ clip: Math.round(cutW * 100) / 100, clamp: !!clampEl, clipper: (ci.find(c => c.cut === cutMax) || {}).who || null, color: pcs.color, op: R1(op * 100) / 100, fs, fw, rects: rects.slice(0, 40), txt: n.textContent.trim().slice(0, 30), shadow: pcs.textShadow !== 'none' });
    }
    S.texts = [...seen.values()];
    S.collapsed = [...spec.querySelectorAll('*')].filter(e => { const r = e.getBoundingClientRect(); return r.width > 20 && r.height < 1 && e.scrollHeight > 20 && getComputedStyle(e).display !== 'none'; })
      .slice(0, 6).map(e => ({ path: name(e), w: Math.round(e.getBoundingClientRect().width), sh: e.scrollHeight }));
    S.buttons = [...spec.querySelectorAll('.btn')].filter(b => b.getBoundingClientRect().width > 0).map(b => ({ ...rect(b), text: b.textContent.trim().slice(0, 30), hero: !!b.closest('.phero'), cta: !!b.closest('.cta-band') }));

    // overflow at any width: descendants outside [0, V] not clipped by an ancestor inside the spec
    spec.querySelectorAll('*').forEach(e => {
      const r = e.getBoundingClientRect();
      if (r.width < 1 || r.height < 1) return;
      if (r.right <= V + 0.5 && r.left >= -0.5) return;
      let p = e.parentElement, clipped = false;
      while (p && p !== document.body) { if (clipsX(p)) { const pr = p.getBoundingClientRect(); if (pr.left >= -0.5 && pr.right <= V + 0.5) { clipped = true; break; } } p = p.parentElement; }
      if (!clipped) S.overflow.push({ path: name(e.parentElement || e) + ' > ' + name(e), x: R1(r.left), r: R1(r.right) });
    });
    S.overflow = S.overflow.slice(0, 15);
    out.specs.push(S);
  });
  return out;
};

L.hideText = async () => {
  const st = document.createElement('style');
  st.textContent = '*,*::before,*::after{color:transparent!important;-webkit-text-fill-color:transparent!important;text-shadow:none!important;transition:none!important;caret-color:transparent!important;text-decoration-color:transparent!important}.cm-appr__badge{visibility:hidden!important}';
  document.head.appendChild(st);
  await new Promise(r => setTimeout(r, 400));
  return true;
};

// contrast of each text run against the pixels under it, from a text-free screenshot of the spec
const lin = c => { c /= 255; return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4); };
const lum = (r, g, b) => 0.2126 * lin(r) + 0.7152 * lin(g) + 0.0722 * lin(b);
const parseC = s => { const m = s.match(/rgba?\(([^)]+)\)/); if (!m) return null; const p = m[1].split(/[ ,\/]+/).filter(Boolean).map(parseFloat); return { r: p[0], g: p[1], b: p[2], a: p.length > 3 ? p[3] : 1 }; };
L.sample = async (dataUrl, ox, oy, runs) => {
  const img = new Image(); img.src = dataUrl; await img.decode();
  const cv = document.createElement('canvas'); cv.width = img.width; cv.height = img.height;
  const cx = cv.getContext('2d', { willReadFrequently: true }); cx.drawImage(img, 0, 0);
  const res = [];
  for (const rn of runs) {
    const fg = parseC(rn.color); if (!fg) { res.push(null); continue; }
    const a = fg.a * rn.op;
    const crs = []; let bgSum = [0, 0, 0];
    for (const q of rn.rects) {
      const x0 = Math.max(0, Math.floor(q.x - ox)), y0 = Math.max(0, Math.floor(q.y - oy));
      const w = Math.min(cv.width - x0, Math.ceil(q.w)), h = Math.min(cv.height - y0, Math.ceil(q.h));
      if (w < 1 || h < 1) continue;
      const d = cx.getImageData(x0, y0, w, h).data;
      const step = Math.max(1, Math.floor(Math.sqrt((w * h) / 600)));
      for (let yy = 0; yy < h; yy += step) for (let xx = 0; xx < w; xx += step) {
        const k = (yy * w + xx) * 4; const br = d[k], bgc = d[k + 1], bb = d[k + 2];
        const fr = fg.r * a + br * (1 - a), fgg = fg.g * a + bgc * (1 - a), fb = fg.b * a + bb * (1 - a);
        const L1 = lum(fr, fgg, fb), L2 = lum(br, bgc, bb);
        crs.push((Math.max(L1, L2) + 0.05) / (Math.min(L1, L2) + 0.05)); bgSum[0] += br; bgSum[1] += bgc; bgSum[2] += bb;
      }
    }
    if (!crs.length) { res.push(null); continue; }
    const n = crs.length; const sorted = crs.slice().sort((x, y) => x - y);
    res.push({ n, min: +sorted[0].toFixed(2), p5: +sorted[Math.floor(n * 0.05)].toFixed(2), p50: +sorted[Math.floor(n * 0.5)].toFixed(2),
      bg: bgSum.map(v => Math.round(v / n)) });
  }
  return res;
};
window.__L3 = L;
return 'ok';
})()
'''
DRIVER = r'''// node drive.mjs <url> <width> <height> <lib.js> <out.json> [contrast]
import { spawn } from 'node:child_process';
import { readFileSync, writeFileSync, mkdtempSync } from 'node:fs';
import { tmpdir } from 'node:os';
const [url, W, H, libPath, outPath, doContrast] = process.argv.slice(2);
const chrome = process.env.CHROME;
const port = 9300 + Math.floor(Math.random() * 600);
const udd = mkdtempSync((process.env.TMPDIR || tmpdir()) + '/l3udd-');
const proc = spawn(chrome, ['--headless', '--disable-gpu', '--no-sandbox', `--remote-debugging-port=${port}`, '--hide-scrollbars', '--user-data-dir=' + udd, '--force-color-profile=srgb'], { stdio: 'ignore' });
const sleep = ms => new Promise(r => setTimeout(r, ms));
let t;
for (let i = 0; i < 75; i++) { try { t = await (await fetch(`http://127.0.0.1:${port}/json/new?about:blank`, { method: 'PUT' })).json(); break; } catch { await sleep(200); } }
const ws = new WebSocket(t.webSocketDebuggerUrl);
let id = 0; const pend = {};
ws.addEventListener('message', e => { const m = JSON.parse(e.data); if (m.id && pend[m.id]) { pend[m.id](m); delete pend[m.id]; } });
await new Promise(r => ws.addEventListener('open', r));
const send = (method, params = {}) => new Promise(res => { const i = ++id; pend[i] = res; ws.send(JSON.stringify({ id: i, method, params })); });
const ev = async (expr) => { const r = await send('Runtime.evaluate', { expression: expr, returnByValue: true, awaitPromise: true }); if (r.result.exceptionDetails) throw new Error(JSON.stringify(r.result.exceptionDetails).slice(0, 1500)); return r.result.result.value; };
try {
  await send('Page.enable'); await send('Runtime.enable');
  await send('Emulation.setDeviceMetricsOverride', { width: +W, height: +H, deviceScaleFactor: 1, mobile: +W < 768 });
  await send('Page.navigate', { url });
  for (let i = 0; i < 150; i++) { if ((await ev('document.readyState')) === 'complete') break; await sleep(200); }
  await ev(readFileSync(libPath, 'utf8'));
  const prep = await ev('window.__L3.prepare()');
  const m = await ev('window.__L3.measure()');
  m.prepare = prep;
  if (doContrast) {
    await ev('window.__L3.hideText()');
    for (const S of m.specs) {
      const runs = []; for (const tx of S.texts) for (const rn of tx.runs) runs.push(rn);
      if (!runs.length) continue;
      const clip = { x: 0, y: S.top, width: +W, height: Math.max(1, S.height), scale: 1 };
      const cap = await send('Page.captureScreenshot', { format: 'png', clip, captureBeyondViewport: true });
      const data = 'data:image/png;base64,' + cap.result.data;
      const res = await ev(`window.__L3.sample(${JSON.stringify(data)}, 0, ${S.top}, ${JSON.stringify(runs.map(r => ({ color: r.color, op: r.op, rects: r.rects })))})`);
      let k = 0; for (const tx of S.texts) for (const rn of tx.runs) rn.cr = res[k++];
    }
  }
  writeFileSync(outPath, JSON.stringify(m));
} finally { ws.close(); proc.kill(); }
'''


def find_chrome():
    if os.environ.get("CHROME") and os.path.exists(os.environ["CHROME"]):
        return os.environ["CHROME"]
    home = os.path.expanduser("~")
    pref = os.path.join(home, "Library/Caches/ms-playwright/chromium_headless_shell-1208/chrome-headless-shell-mac-arm64/chrome-headless-shell")
    if os.path.exists(pref):
        return pref
    c = sorted(glob.glob(os.path.join(home, "Library/Caches/ms-playwright/chromium_headless_shell-*/*/chrome-headless-shell")) +
               glob.glob(os.path.join(home, ".cache/ms-playwright/chromium_headless_shell-*/*/chrome-headless-shell")))
    if c:
        return c[-1]
    sys.exit("no chrome-headless-shell found; set CHROME")


def render(work, page, w, h, contrast):
    lib = os.path.join(work, "l3lib.js")
    drv = os.path.join(work, "drive.mjs")
    open(lib, "w").write(L3LIB)
    open(drv, "w").write(DRIVER)
    out = os.path.join(work, f"measure-{os.path.basename(page)}-{w}.json")
    env = dict(os.environ, CHROME=find_chrome(), TMPDIR=work)
    r = subprocess.run(["node", drv, "file://" + page, str(w), str(h), lib, out] + (["1"] if contrast else []),
                       env=env, capture_output=True, text=True, timeout=600)
    if r.returncode != 0:
        sys.exit(f"render failed for {page} at {w}: {r.stderr[-2000:]}")
    return json.load(open(out))


# ------------------------------------------------------------------------------------------------ findings
FIND = []


def add(lane, sev, where, rule, measured, kind="defect", note=""):
    FIND.append(dict(lane=lane, sev=sev, where=where, rule=rule, measured=measured, kind=kind, note=note))


def ex_name(S):
    lab = re.sub(r"\s+", " ", S["label"]).strip()
    lab = lab if len(lab) <= 90 else lab[:88] + "…"
    return f'{S["row"]} #{S["n"]} «{lab}»'


# ------------------------------------------------------------------------------------------------ compositions
def cells(items):
    """items -> set of (c0, c1, r0, r1): RTL columns 1..6 (1 = right) and row lines; None if an edge is off the grid."""
    # rows by vertical overlap, so an item centred in its cell (a short text beside an image) stays in that row.
    # An item is tall when it overlaps two items that do not overlap each other.
    ov = lambda a, b: min(a["b"], b["b"]) - max(a["t"], b["t"]) > 2
    tall = set()
    for i, a in enumerate(items):
        o = [b for j, b in enumerate(items) if j != i and ov(a, b)]
        if any(not ov(x, y) for x in o for y in o if x is not y):
            tall.add(i)
    slots = []  # clusters of non-tall items
    for i, a in sorted(((i, a) for i, a in enumerate(items) if i not in tall), key=lambda p: p[1]["t"]):
        for sl in slots:
            if any(ov(a, items[k]) for k in sl):
                sl.append(i)
                break
        else:
            slots.append([i])
    slots.sort(key=lambda sl: min(items[k]["t"] for k in sl))
    out = []
    for i, it in enumerate(items):
        c0, c1 = col_right(it["r"]), col_left(it["x"])
        if c0 is None or c1 is None:
            return None
        rows = [n for n, sl in enumerate(slots) if (i in sl) or any(ov(it, items[k]) for k in sl)]
        if not rows:
            rows = [len(slots)]
        out.append((c0, c1, min(rows), max(rows) + 1))
    return out


def norm(cs):
    m = min(c[2] for c in cs)
    return tuple(sorted((a, b, r0 - m, r1 - m) for a, b, r0, r1 in cs))


def bands(cs):
    """split cells into horizontal bands no item crosses"""
    rows = sorted(set(c[2] for c in cs))
    groups, cur, end = [], [], -1
    for r in rows:
        members = [c for c in cs if c[2] == r]
        if cur and r >= end:
            groups.append(cur)
            cur = []
        cur += members
        end = max([end] + [c[3] for c in members])
    if cur:
        groups.append(cur)
    return groups


def lane3(work):
    mapf = os.path.join(CM, "ea-canon-map.html")
    gridf = os.path.join(CM, "grids.html")
    G = render(work, gridf, VW, VH, False)
    D = render(work, mapf, VW, VH, True)
    P = render(work, mapf, PW, PH, True)
    # fail closed: an empty or partial render must never read as a pass
    if not D["specs"] or len(D["specs"]) != len(P["specs"]) or not G["specs"]:
        sys.exit(f"render incomplete: {len(D['specs'])} examples at 1440, {len(P['specs'])} at 375, {len(G['specs'])} grids")
    if D.get("prepare", {}).get("broken"):
        add(3, "note", "ea-canon-map.html", "Measurement precondition — every image loads", f"broken images: {D['prepare']['broken']}", kind="artefact")

    # locked compositions, as rendered
    K = {}
    for S in G["specs"]:
        if not S["kid"].startswith("K-"):
            continue
        cont = S["containers"]
        if cont:
            cs = cells(cont[0]["items"])
            K[norm(cs)] = S["kid"]
        else:
            b = [x for x in S["boxes"] if x["media"] or "kg" in x["cls"]]
            # single item: K-1.1 full / K-1.2 cols 2-5
            K[((1, 6, 0, 1),)] = "K-1.1"
            K[((2, 5, 0, 1),)] = "K-1.2"
    stats = dict(examples=len(D["specs"]), grids_K=sorted(set(K.values())), prepare=D.get("prepare"), page_sw_1440=D["scrollWidth"],
                 page_sw_375=P["scrollWidth"], rows=sorted(set(S["row"] for S in D["specs"])))
    # example numbering within its row
    cnt = {}
    for S in D["specs"] + P["specs"]:
        pass
    for S in D["specs"]:
        cnt[S["row"]] = cnt.get(S["row"], 0) + 1
        S["n"] = cnt[S["row"]]
    for S, S2 in zip(D["specs"], P["specs"]):
        S2["n"] = S["n"]

    # ---------------------------------------------------------------- desktop: content box, edges, compositions
    for S in D["specs"]:
        ex = ex_name(S)
        badwraps = []
        for w in S["wraps"]:
            if 1000 <= w["cbw"] <= 1200 and (abs(w["cbx"] - CBX) > TOL or abs(w["cbr"] - CBR) > TOL):
                badwraps.append(w)
        conseq = {w["path"]: [] for w in badwraps}
        def under_bad(path):
            for w in badwraps:
                if path.startswith(w["path"] + " > "):
                    return w["path"]
            return None
        tg_items = {i["id"] for c in S["containers"] if c["textGrid"] for i in c["items"]}
        for b in S["boxes"]:
            if b.get("hidden"):
                continue  # fully clipped (a carousel card waiting off-stage)
            dx, lx = near_line(b["x"])
            dr, lr = near_line(b["r"])
            if dx > TOL or dr > TOL:
                what = []
                if dr > TOL:
                    what.append(f'right edge {b["r"]} (nearest line {round(lr, 1)}, off {round(dr, 1)}px)')
                if dx > TOL:
                    what.append(f'left edge {b["x"]} (nearest line {round(lx, 1)}, off {round(dx, 1)}px)')
                ub = under_bad(b["path"])
                if ub:
                    conseq[ub].append(f'`{b["path"].split(" > ")[-1].split(".")[0] + "." + b["path"].split(" > ")[-1].split(".")[1]}` ' + "; ".join(what))
                else:
                    add(3, "fix", ex, "Grid §1 — every element's edges on a column line (±1.5px)",
                        f'`{b["path"].split(" > ")[-1]}` «{b["text"][:30]}» {b["w"]}px wide: ' + "; ".join(what))
            if b.get("isItem") and not b["framed"] and "innerX" in b and b["id"] not in tg_items:
                ins_r, ins_l = round(b["r"] - b["innerR"], 1), round(b["innerX"] - b["x"], 1)
                if ins_r > TOL or ins_l > TOL:
                    add(3, "note", ex, "Grid §1 «no element off the grid» vs the type's own inner margin — needs a ruling",
                        f'`{b["path"].split(" > ")[-1]}` spans {b["x"]}–{b["r"]} on the grid, but its visible content spans '
                        f'{b["innerX"]}–{b["innerR"]} (inset {ins_r}px right, {ins_l}px left) — the visible text edge is off the grid',
                        note="An unframed text column has no visible box; the reader sees the text edge. If the canon means "
                             "the cell and allows an inner breathing margin (T-06 rule «מרווח נשימה בצד הטקסט שפונה לתמונה»), this is "
                             "compliant; if it means the visible text, the text is off the grid. Rule conflict, not graded as a defect.",
                        kind="rule conflict")
        for w in badwraps:
            add(3, "fix", ex, "Grid §1 — six columns on the 1104px content box",
                f'`{w["path"].split(" > ")[-1]}` content box is {w["cbx"]}–{w["cbr"]} ({w["cbw"]}px), not 168–1272 (1104px); '
                f'its columns are {round((w["cbw"] - 50) / 6, 2)}px, the site\'s are {round(COLW, 2)}px. Consequence — its children sit on '
                f'its own lines, not the site\'s: ' + " · ".join(conseq[w["path"]]) +
                ("; running text at 536.7–1280 instead of columns 1–4 (539.3–1272)" if "cta" in w["path"] else ""))
        for c in S["containers"]:
            if c["textGrid"]:
                continue
            items = [i for i in c["items"] if i.get("clippedBy") != "hidden"]
            fits = sorted(set(i["fit"] for i in items if i["fit"]))
            if len(fits) > 1:
                add(3, "fix", ex, "Grid §3 — one image-sizing mode per composition",
                    f'`{c["path"].split(" > ")[-1]}` mixes object-fit {fits}')
            clsname = c["path"].split(" > ")[-1]
            # the canon's open lists (Grid §3: blog, gallery, testimonials) and anything over 10 items
            open_list = (("gallery" in clsname and "gallery--portraits" not in clsname) or
                         bool(re.search(r"blog-grid|testi-grid|testi-mq__track|fbgrid", clsname)) or len(items) > 10)
            if c["columns"]:
                ws = sorted(set(round(i["w"]) for i in items))
                if len(ws) > 1:
                    add(3, "fix", ex, "Grid §3 — free-running columns of one width", f"column item widths {ws}")
                continue
            partial = [i for i in c["items"] if i.get("clippedBy") == "partial"]
            if partial:
                add(3, "fix", ex, "T-18 approved rule «whole cards, never cut» / Grid §1",
                    f'{len(partial)} carousel card(s) cut by the viewport')
            cs = cells(items)
            if cs is None:
                continue  # edges already reported above
            if open_list:
                rows = {}
                for (c0, c1, r0, r1), it in zip(cs, items):
                    rows.setdefault(r0, []).append((c0, c1, r1 - r0, it))
                keys = sorted(rows)
                lead = keys and len(rows[keys[0]]) == 1 and rows[keys[0]][0][0] == 1 and rows[keys[0]][0][1] == 6 and "gallery" in clsname
                body = keys[1:] if lead else keys
                counts = [len(rows[k]) for k in body]
                full = counts[:-1] if len(counts) > 1 else counts
                bad = [n for n in set(full) if n not in (1, 2, 3, 6)]
                if len(set(full)) > 1 or bad:
                    add(3, "fix", ex, "Grid §3 — open list: one per-row count of 1, 2, 3 or 6",
                        f'`{clsname}` per-row counts {counts}' + (" (after a full-width lead image)" if lead else ""))
                for k in body:
                    hs = sorted(set(round(r[3]["h"]) for r in rows[k]))
                    if len(hs) > 1 and max(hs) - min(hs) > 1.5:
                        add(3, "note", ex, "Grid §3 — row height uniform within a composition",
                            f'`{clsname}` row {k + 1}: item heights {hs}')
                continue
            sig = norm(cs)
            if len(items) <= 5:
                kid = K.get(sig)
                if not kid:
                    add(3, "fix", ex, "Grid §3 — a known list of 1–10 uses a locked composition K-1.1…K-5.4",
                        f'`{clsname}` {len(items)} items, cells (col-from,col-to,row-from,row-to) {list(sig)} match no K-n.m')
                else:
                    S.setdefault("K", []).append(kid)
            else:
                parts = []
                for bnd in bands(list(sig)):
                    parts.append(K.get(norm(bnd)))
                if None in parts:
                    add(3, "fix", ex, "Grid §3 — 6–10 items are built from locked rows", f'`{clsname}` {len(items)} items, bands {parts}')
                else:
                    S.setdefault("K", []).append("+".join(parts))
            # uniform row height inside a known composition
            hs = {}
            for (c0, c1, r0, r1), it in zip(cs, items):
                if it["media"] or it["img"] or re.search(r"card|__i\b|cmpc|tmq|now", it["cls"]):
                    hs.setdefault(r1 - r0, set()).add(round(it["h"]))
            singles = sorted(hs.get(1, []))
            if singles and max(singles) - min(singles) > 1.5:
                add(3, "fix", ex, "Grid §3 — row height uniform within a composition",
                    f'`{clsname}` one-row item heights {singles}px')

        # ------------------------------------------------------------ text: placement, justification, contrast
        off25, offhero, notjust, notjust1, ledes = [], [], [], [], []
        for t in S["texts"]:
            running = t["tag"] in ("p", "li") and not t["heading"] and not t["btn"] and not t["chap"] and not t.get("ctrl")
            lede = running and re.search(r"(^|\.)(lead|cm-sub|[\w-]+__s)(\.|$)", t["cls"] or "")
            if running and not lede:
                if t["hero"] or t["cta"]:
                    if t["x"] < LEFT[4] - TOL or t["r"] > RIGHT[1] + TOL:
                        offhero.append(t)
                elif not t["inItem"] and not t["card"]:
                    if t["x"] < LEFT[5] - TOL or t["r"] > RIGHT[2] + TOL:
                        off25.append(t)
                ok = t["ta"] == "justify" and t["tal"] in ("start", "auto", "right", "center")
                if not ok:
                    (notjust if t["lines"] >= 2 else notjust1).append(t)
            elif lede:
                ok = t["ta"] == "justify" and t["tal"] in ("start", "auto", "right", "center")
                if not ok:
                    ledes.append(t)
            if (t["heading"] or t["chap"]) and not t["inItem"] and not t["card"] and not t["hero"] and not t["cta"]:
                if t["x"] < CBX - TOL or t["r"] > CBR + TOL:
                    add(3, "fix", ex, "Grid §2 — eyebrow and heading in columns 1–6", f'«{t["text"][:40]}» at {t["x"]}–{t["r"]}')
        # Grid §7 — an eyebrow never repeats its heading
        heads = {re.sub(r"\s+", " ", t["text"]).strip() for t in S["texts"] if t["heading"]}
        for t in S["texts"]:
            if t["chap"] and re.sub(r"\s+", " ", t["text"]).strip() in heads:
                add(3, "fix", ex, "Grid §7 — an eyebrow never repeats its heading", f'eyebrow «{t["text"][:40]}» = heading')
        # Grid §1 read literally for buttons (the button's own sizing rule is outside the two canon sections → note)
        offb = [b for b in S.get("buttons", []) if (near_line(b["x"])[0] > TOL or near_line(b["r"])[0] > TOL) and not (b["cta"] and badwraps)]
        if offb:
            add(3, "note", ex, "Grid §1 «no element off the grid», applied to buttons",
                "; ".join(f'«{b["text"]}» {b["x"]}–{b["r"]} ({b["w"]}px)' for b in offb[:3]) + (f" (+{len(offb) - 3})" if len(offb) > 3 else ""),
                note="Buttons sized to their label («ריווח מצומצם סביב הטקסט», S-2) are not on column lines; the hero/CTA buttons fill columns 5–6. "
                     "Whether §1 binds a free-standing button needs a ruling.", kind="rule conflict")
        if off25:
            add(3, "fix", ex, "Grid §2 — running text in columns 2–5 (353.7–1086.3)",
                "; ".join(f'`{t["tag"]}.{t["cls"]}` «{t["text"][:30]}» at {t["x"]}–{t["r"]}' for t in off25[:4]) + (f" (+{len(off25) - 4})" if len(off25) > 4 else ""))
        if offhero and not badwraps:
            add(3, "fix", ex, "T-01/T-08 locked placement — text in columns 1–4 (539.3–1272)",
                "; ".join(f'«{t["text"][:30]}» at {t["x"]}–{t["r"]}' for t in offhero[:4]))
        if notjust:
            onimg = all("whom" in t["cls"] for t in notjust)
            add(3, "fix", ex, "Canon terms — running text block-justified (justify; last line start, or centre when centred)",
                "; ".join(f'`{t["tag"]}.{t["cls"] or ""}` «{t["text"][:28]}» {t["lines"]} lines, text-align {t["ta"]}/{t["tal"]}' for t in notjust[:4]) +
                (f" (+{len(notjust) - 4} more blocks)" if len(notjust) > 4 else ""),
                note="Large bullet text set on an image; the canon's rule is «paragraphs and list items … always, site-wide», "
                     "so it is graded — downgrade only if team_00 rules image bullets are display text." if onimg else "")
        if notjust1:
            add(3, "note", ex, "Canon terms — running text block-justified (single-line blocks: no visible effect)",
                f'{len(notjust1)} one-line p/li not justify, e.g. ' + "; ".join(f'«{t["text"][:24]}» {t["ta"]}/{t["tal"]}' for t in notjust1[:3]),
                kind="no visible effect")
        if ledes:
            add(3, "note", ex, "Canon terms — is a sub-heading/lede running text? (canon: «paragraphs and list items»)",
                "; ".join(f'`{t["cls"]}` «{t["text"][:28]}» {t["lines"]} lines, {t["ta"]}/{t["tal"]}' for t in ledes[:3]), kind="interpretation")

    # contrast at both widths
    stats["contrast"] = {}
    for label, M in (("1440", D), ("375", P)):
        allr = []
        for S in M["specs"]:
            ex = ex_name(S)
            bad = []
            clipped = []
            for t in S["texts"]:
                for rn in t["runs"]:
                    if rn.get("clip", 0) >= 0.5 and not re.search(r"prose-fold|testi-mq__viewport", rn.get("clipper") or ""):
                        clipped.append((t, rn))
                        continue
                    b = S.get("badge")
                    if b and any(q["x"] < b["x"] + b["w"] and q["x"] + q["w"] > b["x"] and q["y"] < b["y"] + b["h"] and q["y"] + q["h"] > b["y"] for q in rn["rects"]):
                        S.setdefault("badge_over", []).append(rn["txt"][:24])
                    cr = rn.get("cr")
                    if not cr:
                        continue
                    big = rn["fs"] >= 24 or (rn["fs"] >= 18.66 and rn["fw"] >= 700)
                    thr = 3.0 if big else 4.5
                    allr.append((round(cr["p5"] / thr, 2), cr["p5"], thr, rn["txt"][:22], S["row"], S["n"]))
                    if cr["p5"] < thr:
                        bad.append((t, rn, cr, thr))
            stats["contrast"][label] = allr
            if clipped:
                add(3, "blocker", f"{ex} @{label}", "Phone/desktop — the content of every approved example is visible (Grid §8, one column on phones)",
                    f'{len(clipped)} text runs are ≥50% cut away by `{clipped[0][1]["clipper"]}`, e.g. ' +
                    "; ".join(f'«{rn["txt"][:26]}» ({round(rn["clip"] * 100)}% hidden)' for t, rn in clipped[:3]) +
                    (". Cause: " + ", ".join(f'`{c["path"]}` is 0px tall with {c["sh"]}px of content' for c in S.get("collapsed", [])[:4])
                     if S.get("collapsed") else ""))
            if S.get("badge_over"):
                add(3, "note", f"{ex} @{label}", "Map furniture — the «מאושר» badge must not cover the example",
                    f'the badge overlaps text: «{S["badge_over"][0]}»' + (f" (+{len(S['badge_over']) - 1})" if len(S["badge_over"]) > 1 else ""),
                    kind="artefact", note="Map-only overlay; contrast under it is sampled with the badge hidden.")
            seen = set()
            for t, rn, cr, thr in bad:
                k = (rn["txt"][:20], rn["color"])
                if k in seen:
                    continue
                seen.add(k)
                art = rn["op"] < 1
                sev = "note" if art else ("blocker" if cr["p50"] < thr else "fix")
                add(3, sev, f"{ex} @{label}", f"Contrast ≥ {thr}:1 against the effective background",
                    f'«{rn["txt"][:28]}» ({t["tag"]}.{t["cls"] or ""}) {rn["color"]} {rn["fs"]}px/{rn["fw"]} over bg≈rgb{tuple(cr["bg"])}: '
                    f'5th-percentile {cr["p5"]}:1, median {cr["p50"]}:1, worst pixel {cr["min"]}:1',
                    kind="artefact" if art else "defect",
                    note=("opacity < 1 in the chain (reveal animation state) — measurement artefact" if art else
                          ("over a photo: only part of the text fails" if cr["p50"] >= thr else "")))

    # ---------------------------------------------------------------- phone
    if P["scrollWidth"] > P["clientWidth"] + 0.5:
        add(3, "blocker", "ea-canon-map.html @375", "Phone — no horizontal overflow", f'document scrollWidth {P["scrollWidth"]} > {P["clientWidth"]}')
    dmap = {S["i"]: S for S in D["specs"]}
    for S in P["specs"]:
        ex = ex_name(S) + " @375"
        if S["overflow"]:
            add(3, "blocker", ex, "Phone — no horizontal overflow",
                "; ".join(f'`{o["path"].split(" > ")[-1]}` {o["x"]}–{o["r"]}' for o in S["overflow"][:3]))
        dS = dmap[S["i"]]
        dItems = {}
        for c in dS["containers"]:
            cs = cells([i for i in c["items"]]) or []
            for it, cc in zip(c["items"], cs):
                dItems[it["key"]] = cc
        for c in S["containers"]:
            items = [i for i in c["items"] if i.get("clippedBy") != "hidden"]
            rows = {}
            for it in items:
                rows.setdefault(round(it["t"] / 4), []).append(it)
            # group by vertical overlap
            grp = []
            for it in sorted(items, key=lambda i: i["t"]):
                for g in grp:
                    if min(g[0]["b"], it["b"]) - max(g[0]["t"], it["t"]) > 2:
                        g.append(it)
                        break
                else:
                    grp.append([it])
            maxn = max(len(g) for g in grp) if grp else 1
            if maxn <= 1:
                continue
            clsname = c["path"].split(" > ")[-1]
            imgs = all(i["img"] and not re.search(r"card|__i\b|cmpc|tmq", i["cls"]) for i in items)
            if c["textGrid"] or not imgs or maxn > 2:
                add(3, "fix", ex, "Grid §8 — phone: every type in one column (image grids may use two)",
                    f'`{clsname}` has {maxn} items side by side at 375px' + (" (text grid)" if c["textGrid"] else ""))
            else:
                for n_it, it in enumerate(items):
                    cc = dItems.get(it["key"])
                    if cc and ((cc[1] - cc[0] + 1) >= 3 or (cc[3] - cc[2]) >= 2) and it["w"] < c["w"] - 2:
                        add(3, "fix", ex, "Grid §8 — phone: an item ≥3 columns wide or tall takes both columns",
                            f'`{clsname}` item {n_it + 1} of {len(items)} (desktop columns {cc[0]}–{cc[1]}, {cc[3] - cc[2]} row(s) tall) is {it["w"]}px of the {c["w"]}px column pair')
    # composition summary for the verdict
    comp = []
    for S in D["specs"]:
        comp.append((ex_name(S), ", ".join(S.get("K", [])) or "—"))
    stats["compositions"] = comp
    return stats


# ------------------------------------------------------------------------------------------------ lane 4
def load_types():
    spec = importlib.util.spec_from_file_location("canon_types_data", os.path.join(TOOLS, "canon_types.py"))
    m = importlib.util.module_from_spec(spec)
    spec.loader.exec_module(m)
    return m


def lane4(work, pages, do_rebuild, do_fetch, fetch_too=False):
    st = {}
    ct = load_types()
    uses = json.load(open(os.path.join(TOOLS, "uses.json"), encoding="utf-8"))
    types = [t for _, ts in ct.GROUPS for t in ts]
    st["types"] = len(types)
    # 4a — every old ID in exactly one current type
    old_ids = [f"T-{n:02d}" for n in range(1, 38) if n not in (2, 3)]
    where = {}
    for t in types:
        for o, _ in t[2]:
            where.setdefault(o, []).append(t[0])
    for o in old_ids:
        w = where.get(o, [])
        if len(w) != 1:
            add(4, "fix" if len(w) > 1 else "blocker", "tools/canon_types.py",
                "Each of the 35 old IDs appears in exactly one current type",
                f"{o} appears in {len(w)} current types: {w}" if w else f"{o} appears in no current type",
                note="Probably deliberate (the pending-video look is both a video variant and the shared «waiting for content» state), "
                     "but it breaks the one-home rule and double-counts T-27's pages in two rows. Either the rule gets an exception or one listing goes." if len(w) > 1 else "")
    for o in where:
        if o not in old_ids:
            add(4, "fix", "tools/canon_types.py", "Retired IDs T-02/T-03 are never reused", f"{o} listed in {where[o]}")
    # 4b — each current type: definition, example, uses, fields, rules; page count = union of old uses
    from bs4 import BeautifulSoup
    soup = BeautifulSoup(open(os.path.join(CM, "ea-canon-map.html"), encoding="utf-8").read(), "lxml")
    rows = {d.get("id"): d for d in soup.select("details.cm-row")}
    st["rows"] = len(rows)
    for t in types:
        tid, name, olds, status, definition, variants, fields, rules = t
        union = set()
        for o, _ in olds:
            union |= set(uses.get(o, []))
        miss = []
        if not (definition or "").strip():
            miss.append("definition")
        if not (fields or "").strip():
            miss.append("fields")
        if not rules:
            miss.append("rules")
        row = rows.get(tid)
        if row is None:
            add(4, "blocker", f"ea-canon-map.html {tid}", "Every current type has a row in the map", "no row")
            continue
        full = row.select_one(".cm-full")
        nex = len(full.select(".cm-spec")) if full else 0
        if nex == 0:
            miss.append("example")
        txt = row.get_text(" ", strip=True)
        m = re.search(r"שימושים באתר\s*[—-]\s*(\d+\s*עמודים|עמוד אחד)", txt)
        listed = len(full.select("ul.cm-uses > li")) if full else 0
        c_use = row.select_one(".c-use")
        c_use_t = c_use.get_text(" ", strip=True) if c_use else ""
        stated = (1 if "אחד" in m.group(1) else int(re.match(r"\d+", m.group(1)).group(0))) if m else None
        if not union:
            if "כרגע לא בשימוש" not in txt:
                miss.append("uses (none, and no «כרגע לא בשימוש»)")
        else:
            if stated != len(union) or listed != len(union):
                add(4, "fix", f"ea-canon-map.html {tid} «{name}»", "Pages listed = union of its old types' uses in tools/uses.json",
                    f"union {len(union)} pages; heading says {stated}; list has {listed} items; summary «{c_use_t}»")
        if not olds and "כרגע לא בשימוש" in txt:
            add(4, "note", f"ea-canon-map.html {tid} «{name}»", "Uses: a type with no old ID cannot be counted by the census",
                "the row says «כרגע לא בשימוש» because no old type feeds it — yet it is a shared element present on most pages",
                kind="data gap")
        if miss:
            add(4, "fix", f"{tid} «{name}»", "Each current type has definition, example, use, fields, rules", "missing: " + ", ".join(miss))
        st.setdefault("per_type", []).append((tid, name, status, [o for o, _ in olds], len(union), stated, listed, nex, c_use_t))
    # 4b' — the README's own counts agree with the data (documentation drift, graded as notes)
    rd = open(README, encoding="utf-8").read()
    m = re.search(r"One row per current type\*\*\s*\((\d+)", rd)
    if m and int(m.group(1)) != len(types):
        add(4, "note", "canon-map/README.md «Structure»", "README agrees with tools/canon_types.py", kind="doc drift", measured=
            f"README says {m.group(1)} rows; canon_types.py has {len(types)} ({', '.join(t[0] for t in types if t[0][0] != 'T')} besides the T-types)")
    for m in re.finditer(r"(\d+) types (?:remain|,)", rd):
        if int(m.group(1)) != len(old_ids):
            add(4, "note", "canon-map/README.md", "README agrees with the retired-ID set (T-02, T-03 retired → 35 old IDs)", kind="doc drift", measured=
                f"README says «{m.group(0)}»; with T-02 and T-03 retired there are {len(old_ids)} old type IDs")
    if re.search(r"\*\*Retired: `T-03`\*\*", rd) and "T-02" not in re.search(r"\*\*Retired:.*", rd).group(0):
        add(4, "note", "canon-map/README.md «Identifiers»", "README agrees with the retired-ID set",
            "README lists only T-03 as retired; T-02 was retired into T-01 (state file D18, D-table)")
    # 4c — rebuild
    if do_rebuild:
        st["rebuild"] = rebuild(work, pages, do_fetch)
        if fetch_too and pages and not do_fetch:
            # informational: does today's staging still reproduce the committed map? (a difference = the capture is stale, not a build defect)
            st["rebuild_fresh"] = rebuild(work, None, True, tag="rebuild-fresh", informational=True)
    # 4d — every file path resolves
    st["paths"] = check_paths()
    return st


STAMP = re.compile(r"20\d\d-\d\d-\d\d|\b\d{1,2}\.\d{1,2}\.20\d\d\b|1\.5\.\d+")


def rebuild(work, pages, do_fetch, tag="rebuild", informational=False):
    R = os.path.join(work, tag)
    shutil.rmtree(R, ignore_errors=True)
    src, out = os.path.join(R, "pages"), os.path.join(R, "out")
    os.makedirs(src)
    shutil.copytree(TOOLS, os.path.join(out, "tools"), ignore=shutil.ignore_patterns("__pycache__"))
    info = {}
    if do_fetch or not pages:
        r = subprocess.run([sys.executable, os.path.join(TOOLS, "fetch.py")], cwd=src, capture_output=True, text=True, timeout=900)
        info["fetch"] = "fresh fetch.py run: " + ("ok" if r.returncode == 0 else "FAILED " + r.stderr[-300:])
    else:
        for f in glob.glob(os.path.join(pages, "*.html")):
            shutil.copy(f, src)
        info["fetch"] = f"pre-fetched pages copied from {pages}"
    # build.py must be the repo's own (it resolves ../../../../site from its own location); it reads tools/uses.json next to OUT
    r = subprocess.run([sys.executable, os.path.join(TOOLS, "build.py"), os.path.join(out, "map-source.html")], cwd=src,
                       capture_output=True, text=True, timeout=900)
    info["build"] = (r.stdout.strip().splitlines() or [""])[-1] if r.returncode == 0 else "FAILED " + r.stderr[-500:]
    if r.returncode != 0:
        add(4, "blocker", "tools/build.py", "Rebuild from a clean scratch dir", info["build"])
        return info
    # the view scripts are run as copies: open_view.py rewrites tools/open_ids.json next to itself
    views = [("canon_view.py", "ea-canon-map.html"), ("open_view.py", "open.html"), ("grids_view.py", "grids.html"),
             ("grid_proof.py", "grid-proof.html"), ("palette_check.py", "palette-check.html")]
    for scr, o in views:
        r = subprocess.run([sys.executable, os.path.join("tools", scr), "map-source.html", o], cwd=out, capture_output=True, text=True, timeout=600)
        if r.returncode != 0:
            add(4, "blocker", f"tools/{scr}", "Rebuild the views (rebuild_views.sh)", r.stderr[-400:])
    res = {}
    for f in ["map-source.html"] + [o for _, o in views] + ["tools/open_ids.json"]:
        a, b = os.path.join(out, f), os.path.join(CM, f)
        if not os.path.exists(a):
            res[f] = "not produced"
            continue
        A, B = open(a, encoding="utf-8").read(), open(b, encoding="utf-8").read()
        if A == B:
            res[f] = "byte-identical"
        elif STAMP.sub("§", A) == STAMP.sub("§", B):
            res[f] = "identical except date/version stamps"
        else:
            import difflib
            la, lb = STAMP.sub("§", A).replace(">", ">\n").splitlines(), STAMP.sub("§", B).replace(">", ">\n").splitlines()
            d = [x for x in difflib.unified_diff(lb, la, lineterm="", n=0) if x[:1] in "+-" and x[:3] not in ("+++", "---")]
            res[f] = f"DIFFERS ({len(d)} changed lines), first: " + " | ".join(x[:120] for x in d[:4])
            if informational:
                add(4, "note", f"canon-map/{f}", "Freshness — a rebuild from TODAY's staging pages matches the committed capture",
                    res[f], kind="stale capture", note="Not a reproducibility defect: the committed map reproduces from the pages it was captured from; "
                    "the live pages have moved on since.")
            else:
                add(4, "fix", f"canon-map/{f}", "Rebuild reproduces the committed HTML (except capture stamps)", res[f])
    info["files"] = res
    return info


PATH_RE = re.compile(r"(?<![\w/.:%-])((?:file://)?(?:[\w.~@-]+/)*[\w.@-]+\.(?:md|html|py|json|tsv|css|php|js|mjs|sh|yaml|yml|txt|png|jpe?g|webp|svg|xlsx|csv|pdf|mp4))(?![\w/])")


def check_paths():
    files = [CANON, STATE, README] + sorted(glob.glob(os.path.join(TOOLS, "*.py"))) + [os.path.join(TOOLS, "rebuild_views.sh")]
    idx = {}
    for d, ds, fs in os.walk(REPO):
        ds[:] = [x for x in ds if x not in (".git", "node_modules", "__pycache__")]
        for f in fs:
            idx.setdefault(f, []).append(os.path.join(d, f))
    fetched = set()
    fp = open(os.path.join(TOOLS, "fetch.py"), encoding="utf-8").read()
    fetched = {k + ".html" for k in re.findall(r'"(\w+)":"/', fp)}
    out = {"checked": 0, "exact": 0, "by_name": 0, "retired": 0, "generated": 0, "unresolved": []}
    for f in files:
        text = open(f, encoding="utf-8").read()
        lines = text.splitlines()
        bases = [os.path.dirname(f), REPO, os.path.join(REPO, "_COMMUNICATION"), os.path.join(REPO, "_COMMUNICATION", "team_10"), CM, TOOLS,
                 os.path.join(REPO, "_COMMUNICATION", "team_100"), os.path.join(REPO, "_COMMUNICATION", "team_100", "EYAL-WORKSPACE"),
                 os.path.join(REPO, "site"), os.path.join(REPO, "site", "wp-content", "themes", "ea-eyalamit")]
        seen = set()
        for ln, line in enumerate(lines, 1):
            for m in PATH_RE.finditer(line):
                t = m.group(1)
                if (t, f) in seen or t.startswith("http") or "<" in t or "*" in t:
                    continue
                seen.add((t, f))
                out["checked"] += 1
                p = t.replace("file://", "").replace("%20", " ")
                if p.startswith("/"):
                    ok = os.path.exists(p) or os.path.exists(os.path.join(REPO, "site") + p)
                else:
                    ok = any(os.path.exists(os.path.join(b, p)) for b in bases)
                if ok:
                    out["exact"] += 1
                    continue
                base = os.path.basename(p)
                if base in idx and (("/" not in p) or any(q.endswith(p) for q in idx[base])):
                    out["by_name"] += 1
                    continue
                if re.search(r"retired|deleted|removed|gone|פורש|למחוק|scratchpad", line, re.I):
                    out["retired"] += 1
                    continue
                if f.endswith(".py") and base in fetched:
                    out["generated"] += 1
                    continue
                rel = os.path.relpath(f, REPO)
                out["unresolved"].append(f"{rel}:{ln} → {t}")
    for u in out["unresolved"]:
        add(4, "fix", u.split(" → ")[0], "Every file path mentioned resolves to an existing file", u.split(" → ")[1] + " — not found in the repo")
    return out


# ------------------------------------------------------------------------------------------------ verdict
def write_verdict(s3, s4, args):
    order = {"blocker": 0, "fix": 1, "note": 2}
    # merge identical (rule, measured) findings across examples of one row
    merged = []
    for f in FIND:
        key = (f["lane"], f["sev"], f["rule"], re.sub(r"#\d+ «[^»]*»", "", f["where"]).split(" @")[0] if f["lane"] == 3 else f["where"], f["measured"])
        for g in merged:
            if g["key"] == key:
                g["where"].append(f["where"])
                break
        else:
            merged.append(dict(f, key=key, where=[f["where"]]))
    merged.sort(key=lambda f: (f["lane"], order[f["sev"]]))
    n3 = n4 = 0
    L = []
    L.append("# Canon map validation — lanes 3 and 4: VERDICT\n")
    vm = re.search(r"ver=(1\.5\.\d+)", open(os.path.join(CM, "ea-canon-map.html"), encoding="utf-8").read())
    ver = vm.group(1) if vm else "?"
    L.append(f"**Run:** {datetime.datetime.now().strftime('%Y-%m-%d %H:%M')} · checker `_COMMUNICATION/team_10/canon-validation/check_map.py` "
             f"(re-runnable) · mandate `LANE-3-4-RULES-AND-COMPLETENESS.md` · map theme stamp {ver}.\n")
    L.append("Rules from the written canon only («Canon terms and site-wide rules», «Grid rules» in CONTENT-TYPES-CANON.md) "
             "and the locked compositions as they render in `canon-map/grids.html`. Nothing learned from `tools/build.py`'s CSS. "
             "Measured in headless Chromium (CDP) at 1440×900 and 375×812 on the committed `ea-canon-map.html`, every row opened, "
             "every tab panel shown, lazy images forced eager and loaded (assets come from the staging host via `<base href>`).\n")
    L.append("## Method, in short\n")
    L.append(f"- **Grid lines** at 1440: content box 168–1272, six columns of {COLW:.2f}px, gutter 10; tolerance ±1.5px. "
             "Layout children = children of each content wrapper, descending through full-width wrappers; items of a "
             "side-by-side container stop the descent (card interiors are not layout). Absolutely-positioned decorations "
             "(aria-hidden / media / empty) and media wider than the content box are the canon's full-bleed exception. "
             "Controls (arrows, dots, filter chips, pagination) are listed, not graded.")
    L.append("- **Compositions**: every side-by-side container's items are mapped to (column-from, column-to, row-from, row-to) and "
             "compared with the same mapping of each K-n.m rendered in grids.html. Open lists (gallery, blog, testimonials, masonry, or >10) "
             "are checked for one per-row count in {1,2,3,6}.")
    L.append("- **Text**: p/li that are not headings, eyebrows, buttons or controls = running text. Outside cards/items it must sit in "
             "columns 2–5 (353.7–1086.3); in the hero and CTA band, columns 1–4 (their locked placement). Justification = computed "
             "`text-align: justify` with `text-align-last` start/auto/center.")
    L.append("- **Contrast**: every text run's colour against the actual pixels beneath it — a second screenshot with all text made "
             "transparent, sampled inside each line box; the graded value is the 5th percentile (worst 5% of the background under "
             "the glyphs), threshold 4.5:1, or 3:1 at ≥24px / ≥18.66px bold. Median and worst pixel are reported too.")
    L.append("- **Phone**: document scrollWidth, every unclipped descendant outside 0–375, and side-by-side items per container.\n")
    for f in merged:
        if f["lane"] == 3:
            n3 += 1
        else:
            n4 += 1
    L.append("## Summary\n")
    L.append(f"- Approved examples measured: **{s3['examples']}** in {len(s3['rows'])} rows ({', '.join(s3['rows'])}).")
    L.append(f"- Locked compositions recognised from grids.html: {', '.join(s3['grids_K'])}.")
    for lab, allr in s3.get("contrast", {}).items():
        low = sorted(allr)[:4]
        L.append(f"- Contrast @{lab}: {len(allr)} text runs sampled; closest to the threshold: " +
                 "; ".join(f"{r[4]} #{r[5]} «{r[3]}» {r[1]}:1 (needs {r[2]})" for r in low) + ".")
    L.append(f"- Page scrollWidth: {s3['page_sw_1440']} at 1440, {s3['page_sw_375']} at 375. Images: {s3['prepare']}.")
    if "rebuild" in s4:
        rb = s4["rebuild"]
        L.append(f"- Rebuild: {rb.get('fetch')}; build: {rb.get('build')}; " +
                 "; ".join(f"`{k}` {v}" for k, v in rb.get("files", {}).items()) + ".")
    if "rebuild_fresh" in s4:
        rb = s4["rebuild_fresh"]
        L.append(f"- Rebuild from a fresh fetch (informational): {rb.get('fetch')}; build: {rb.get('build')}; " +
                 "; ".join(f"`{k}` {v[:60]}" for k, v in rb.get("files", {}).items()) + ".")
    pth = s4["paths"]
    L.append(f"- Paths: {pth['checked']} mentions checked — {pth['exact']} resolve directly, {pth['by_name']} by file name elsewhere in the repo (bare theme/document names), "
             f"{pth['retired']} are stated as retired/deleted/scratchpad in the same line, {pth['generated']} are fetch.py outputs; "
             f"{len(pth['unresolved'])} unresolved.")
    L.append(f"- Findings: lane 3 **{n3}**, lane 4 **{n4}** "
             f"(blocker {sum(1 for f in merged if f['sev'] == 'blocker')}, fix {sum(1 for f in merged if f['sev'] == 'fix')}, "
             f"note {sum(1 for f in merged if f['sev'] == 'note')}).\n")
    L.append("### Compositions matched\n")
    for ex, k in s3["compositions"]:
        if k != "—":
            L.append(f"- {ex}: {k}")
    L.append("")
    L.append("### Lane 4 — per current type\n")
    for tid, name, status, olds, nu, stated, listed, nex, cuse in s4.get("per_type", []):
        L.append(f"- {tid} «{name}» ({status}) — old {', '.join(olds) or '—'}; uses union {nu}, map says {stated}, lists {listed}; "
                 f"examples {nex}; summary «{cuse}»")
    L.append("")
    for lane in (3, 4):
        L.append(f"## Lane {lane} findings\n")
        k = 0
        for f in merged:
            if f["lane"] != lane:
                continue
            k += 1
            w = f["where"]
            ws = w[0] if len(w) == 1 else f"{w[0]} (and {len(w) - 1} more: " + "; ".join(x.split(' «')[0] for x in w[1:]) + ")"
            L.append(f"### L{lane}-{k} · {f['sev']} · {f['kind']}\n")
            L.append(f"- **Where:** {ws}")
            L.append(f"- **Rule:** {f['rule']}")
            L.append(f"- **Measured:** {f['measured']}")
            if f["note"]:
                L.append(f"- **Note:** {f['note']}")
            L.append("")
        if k == 0:
            L.append("None.\n")
    L.append("## Measurement artefacts neutralised (not findings)\n")
    L.append("- The map's «מאושר» badge sits over each example; it is hidden while sampling contrast (its overlap is reported as a map-only note).")
    L.append("- Carousel cards waiting off-stage (fully clipped by the carousel viewport) are not graded for grid edges.")
    L.append("- Text truncated by a line-clamp on its own block (blog excerpts) and the fold's deliberate fade are not «hidden content».")
    L.append("- Absolutely-positioned, aria-hidden decorations (the hero `.arcs`, scrims, the CTA logo) are the canon's full-bleed exception.")
    L.append("- Controls (carousel arrows and dots, blog filter chips, pagination) are listed but not graded against column lines.")
    L.append("- Single-line p/li that are not justified have no visible effect; they are notes, not fixes.\n")
    n = sum(1 for f in merged if f["sev"] in ("blocker", "fix"))
    L.append(f"(n) counts blockers and fixes; notes are listed above but not counted.\n")
    L.append("VERDICT: PASS" if n == 0 else f"VERDICT: FINDINGS ({n})")
    body = "\n".join(L)
    return body, merged


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--pages")
    ap.add_argument("--work")
    ap.add_argument("--fetch", action="store_true")
    ap.add_argument("--no-rebuild", action="store_true")
    ap.add_argument("--fetch-too", action="store_true", help="with --pages: also rebuild from a fresh fetch (informational)")
    ap.add_argument("--out", default=VERDICT)
    a = ap.parse_args()
    work = a.work or tempfile.mkdtemp(prefix="lane34-")
    os.makedirs(work, exist_ok=True)
    s3 = lane3(work)
    s4 = lane4(work, a.pages, not a.no_rebuild, a.fetch, a.fetch_too)
    body, merged = write_verdict(s3, s4, a)
    json.dump(dict(s3=s3, s4=s4, findings=FIND), open(os.path.join(work, "check_map.json"), "w"), ensure_ascii=False, indent=1, default=str)
    open(a.out, "w", encoding="utf-8").write(body + "\n")
    print(f"work dir: {work}\nverdict: {a.out}\nfindings: {len(merged)}")


if __name__ == "__main__":
    main()
