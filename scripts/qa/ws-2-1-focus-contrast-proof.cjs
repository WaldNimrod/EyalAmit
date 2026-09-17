#!/usr/bin/env node
/**
 * WS-2.1 — focus-contrast cascade-collision proof (team_10 BUILD line).
 * Mandate: _COMMUNICATION/team_10/A11Y-FIX-2026-09-18/00-BRIEF-SHARED-FIX.md
 *
 * Reproduces team_100's live measurement (skip link + nav EN toggle losing
 * contrast on :focus because GeneratePress's own inline `a:hover,a:focus,
 * a:active{color:var(--contrast)}` (specificity 0,1,1) beats the child
 * theme's single-class colour rules (0,1,0)), then — if run in "fixed" mode —
 * injects the proposed fix CSS into the LIVE page via addStyleTag and
 * re-measures, proving the fix without deploying anything.
 *
 * Real Chrome, real keyboard Tab events (not synthetic .focus()), asserted
 * non-zero viewport, WCAG relative-luminance contrast to 2 decimals.
 *
 * Methodology notes (read before trusting the numbers):
 * - The header nav's dark background is toggled by JS: ea-chapters.js:17
 *   sets `nav[data-s]` to "1" once `window.scrollY > 40`, else "0". At
 *   data-s="0" the nav's visible dark tint comes from a CSS gradient
 *   (chapters.css:695, `linear-gradient(...)`) layered over whatever page
 *   content sits behind it (a photo, in the hero) — that is not a single
 *   flat colour and is not reliably samplable via getComputedStyle. This
 *   script deliberately scrolls past the 40px threshold and asserts
 *   `data-s="1"` before measuring any nav-hosted component, so the
 *   background it reads is the well-defined flat `rgba(20,14,9,.95)` —
 *   the same "dark nav" team_100's own measurement describes. This does
 *   NOT affect whether the bug exists: the colliding rule sets `color`
 *   unconditionally on `:focus`, independent of scroll position — only the
 *   exact ratio number is scroll-state-dependent, not the collapse itself.
 * - Effective background = the FOCUSED element's own computed
 *   background-color if opaque, else the first opaque background-color
 *   found walking up ancestors. If none is found (e.g. a gradient-only
 *   ancestor with no solid colour anywhere above it), this is reported as
 *   bgFound:false / "COULD NOT MEASURE" — never silently defaulted to white.
 * - GeneratePress's main.min.css puts `transition: color .1s ease-in-out`
 *   on every <a>; chapters.css adds longer transitions on some nav items.
 *   Reading getComputedStyle() immediately after the Tab keypress that
 *   moves focus catches the colour mid-animation (verified: one early run
 *   of this script read rgba(89,86,84,.965) for a focused link — the exact
 *   algebraic midpoint between its resting and collapsed colours at ~79%
 *   transition progress, not a real third colour). SETTLE_MS waits past
 *   the longest transition in this codebase before every read.
 *
 * Usage:
 *   node ws-2-1-focus-contrast-proof.cjs baseline   # unmodified live cascade
 *   node ws-2-1-focus-contrast-proof.cjs fixed      # + injected fix CSS
 */
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const BASE = process.env.EA_QA_BASE || 'http://eyalamit-co-il-2026.s887.upress.link';
const MODE = (process.argv[2] || 'baseline').trim(); // 'baseline' | 'fixed'
const MAX_TABS = parseInt(process.env.EA_MAX_TABS || '160', 10);
// GeneratePress's own main.min.css puts `transition: color .1s ease-in-out`
// on every <a> (and chapters.css adds its own .2s transitions on some nav
// items). Reading getComputedStyle() immediately after a Tab press catches
// the colour mid-animation — confirmed by reproducing an in-flight blend
// (rgba(89,86,84,.965), exactly the algebraic midpoint between the resting
// and collapsed colours at ~79% progress). Wait past the longest transition
// in this codebase before trusting any focused-colour reading.
const SETTLE_MS = parseInt(process.env.EA_SETTLE_MS || '450', 10);
const OUT = path.join(__dirname, 'reports', `ws-2-1-focus-contrast-${MODE}.json`);
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

// ---- the exact fix CSS this line is proposing (kept in one place so the
// "fixed" run injects precisely what will be committed to the real files) ----
const FIX_CSS = `
/* WS-2.1 injected proof — mirrors edits proposed for:
   ea-atoms.css:88-96, chapters.css:657 (.ea-skiplink)
   chapters.css:103-104 (.nav__en, new rule)
   chapters.css:93-94 (.nav__b, new rule)
   chapters.css:78-79 (.btn--terra / .btn--gw, new rules alongside .btn:focus-visible)
   NOT included (checked, found NOT in this failure class — see report):
   .nav__dd / .nav__l a / .nav__sub a (already tied-and-later-wins via
   ".nav__l a"/".nav__sub a", confirmed unchanged live); .foot a / .foot__base a
   (already has its own :focus-visible{color:#fff}); .btn--gd (focus makes it
   MORE readable, dark-ink-on-light); .ea-whatsapp-float (collapse is real but
   invisible — label is display:none and the icon has its own pinned color) */
.ea-skiplink:focus,
.ea-skiplink:focus-visible {
  color: #fff;
}
.nav__en:focus,
.nav__en:focus-visible {
  color: #fff;
  border-color: #fff;
}
.nav__b:focus,
.nav__b:focus-visible {
  color: #fff;
}
.btn--terra:focus-visible {
  color: #fff;
}
.btn--gw:focus-visible {
  color: #fff;
}
`;

function parseColor(str) {
  if (!str) return null;
  const m = String(str).match(
    /rgba?\(\s*([\d.]+)\s*,\s*([\d.]+)\s*,\s*([\d.]+)\s*(?:,\s*([\d.]+)\s*)?\)/i
  );
  if (!m) return null;
  return {
    r: parseFloat(m[1]),
    g: parseFloat(m[2]),
    b: parseFloat(m[3]),
    a: m[4] !== undefined ? parseFloat(m[4]) : 1,
  };
}
function composite(fg, bg) {
  const a = fg.a == null ? 1 : fg.a;
  return {
    r: a * fg.r + (1 - a) * bg.r,
    g: a * fg.g + (1 - a) * bg.g,
    b: a * fg.b + (1 - a) * bg.b,
  };
}
function relLum({ r, g, b }) {
  const chan = [r, g, b]
    .map((v) => v / 255)
    .map((c) => (c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4)));
  return 0.2126 * chan[0] + 0.7152 * chan[1] + 0.0722 * chan[2];
}
function ratio(fgStr, bgStr) {
  const fg = parseColor(fgStr);
  const bg = parseColor(bgStr);
  if (!fg || !bg) return null;
  const comp = composite(fg, bg);
  const L1 = relLum(comp);
  const L2 = relLum(bg);
  const lighter = Math.max(L1, L2);
  const darker = Math.min(L1, L2);
  return Math.round(((lighter + 0.05) / (darker + 0.05)) * 100) / 100;
}

// ---- in-page helpers (stringified so they can be evaluated verbatim) ----

// Effective-background walker: element's OWN background first, then
// ancestors. Returns {bg, bgFound, bgNode} — never guesses.
const BG_WALKER_SRC = `
function eaFindBg(el) {
  let node = el, hop = 0;
  while (node && node.nodeType === 1) {
    const s = getComputedStyle(node);
    const c = s.backgroundColor;
    if (c && c !== 'rgba(0, 0, 0, 0)' && c !== 'transparent') {
      return { bg: c, bgFound: true, bgNode: (hop === 0 ? '(self)' : node.tagName + '.' + String(node.className).split(' ').join('.')) };
    }
    node = node.parentElement;
    hop++;
  }
  return { bg: null, bgFound: false, bgNode: null };
}
`;

function snapshotOf(el) {
  // NOTE: executed in-page; el is a live DOM element.
  if (!el || el === document.body || el === document.documentElement) {
    return { isBody: true };
  }
  const cs = getComputedStyle(el);
  const bgInfo = eaFindBg(el);
  return {
    isBody: false,
    tag: el.tagName,
    cls: el.className || '',
    id: el.id || '',
    href: el.getAttribute ? el.getAttribute('href') || '' : '',
    text: (el.textContent || '').trim().slice(0, 40),
    color: cs.color,
    ownBg: cs.backgroundColor,
    bg: bgInfo.bg,
    bgFound: bgInfo.bgFound,
    bgNode: bgInfo.bgNode,
    outlineStyle: cs.outlineStyle,
    outlineColor: cs.outlineColor,
    outlineWidth: cs.outlineWidth,
    inNavL: !!el.closest('.nav__l'),
    inNavSub: !!el.closest('.nav__sub'),
    inFootBase: !!el.closest('.foot__base'),
    inFoot: !!el.closest('.foot'),
  };
}

const TARGET_SELECTORS = {
  skiplink: '.ea-skiplink',
  nav_en: '.nav__en',
  nav_b: '.nav__b',
  nav_dd_first: 'a.nav__dd',
  nav_l_first: '.nav__l > li > a:not(.nav__dd):not(.nav__en)',
  foot_link: '.foot a',
  foot_base_link: '.foot__base a',
  tlink: '.tlink',
  btn_terra: '.btn--terra',
  btn_gw: '.btn--gw',
  btn_gd: '.btn--gd',
  whatsapp: '.ea-whatsapp-float',
};

function classify(snap) {
  if (!snap || snap.isBody) return null;
  if (snap.tag !== 'A' && snap.tag !== 'BUTTON') return null;
  const cls = (snap.cls || '').split(/\s+/);
  const has = (c) => cls.includes(c);
  if (has('ea-skiplink')) return 'skiplink';
  if (has('nav__en')) return 'nav_en';
  if (has('nav__b')) return 'nav_b';
  if (has('nav__dd') && snap.tag === 'A') return 'nav_dd_first';
  if (has('btn--terra')) return 'btn_terra';
  if (has('btn--gw')) return 'btn_gw';
  if (has('btn--gd')) return 'btn_gd';
  if (has('ea-whatsapp-float')) return 'whatsapp';
  if (snap.inFootBase) return 'foot_base_link';
  if (snap.tag === 'A' && snap.inNavL && !snap.inNavSub && !has('nav__dd') && !has('nav__en'))
    return 'nav_l_first';
  if (snap.tag === 'A' && snap.inNavSub) return 'nav_sub_first';
  if (snap.tag === 'A' && snap.inFoot && !snap.inFootBase) return 'foot_link';
  if (has('tlink')) return 'tlink';
  return null;
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 900 });

  await page.evaluateOnNewDocument(BG_WALKER_SRC);

  const resp = await page.goto(BASE.replace(/\/$/, '') + '/', {
    waitUntil: 'networkidle2',
    timeout: 90000,
  });

  const viewport = await page.evaluate(() => ({ w: window.innerWidth, h: window.innerHeight }));

  let injected = false;
  if (MODE === 'fixed') {
    await page.addStyleTag({ content: FIX_CSS });
    injected = true;
  }

  // ---- force + verify the deterministic "scrolled" nav state (data-s="1")
  // BEFORE any measurement, so unfocused and focused readings are taken
  // against the same, well-defined, non-gradient background. See header
  // comment for why. ----
  await page.evaluate(() => window.scrollTo(0, 400));
  let navScrolledState = null;
  try {
    await page.waitForFunction(
      () => {
        const nav = document.querySelector('.nav');
        return nav && nav.getAttribute('data-s') === '1';
      },
      { timeout: 5000 }
    );
    navScrolledState = true;
  } catch (e) {
    navScrolledState = false;
  }

  // ---- unfocused baseline (resting state, no key events needed) ----
  const unfocused = {};
  for (const [key, sel] of Object.entries(TARGET_SELECTORS)) {
    unfocused[key] = await page.evaluate(
      (s) => {
        const el = document.querySelector(s);
        if (!el) return { found: false };
        return Object.assign({ found: true }, (function (el) {
          // inline copy of snapshotOf's core so we don't depend on
          // activeElement — this reads the resting (non-focused) state.
          const cs = getComputedStyle(el);
          const bgInfo = eaFindBg(el);
          return {
            tag: el.tagName,
            cls: el.className || '',
            color: cs.color,
            bg: bgInfo.bg,
            bgFound: bgInfo.bgFound,
            outlineStyle: cs.outlineStyle,
          };
        })(el));
      },
      sel
    );
  }

  // ---- real keyboard Tab walk from the top of DOM order ----
  await page.evaluate(() => {
    if (document.activeElement) document.activeElement.blur();
  });

  const tabLog = [];
  const focused = {}; // key -> first snapshot seen while focused
  let firstTabMovedFocus = false;

  for (let i = 0; i < MAX_TABS; i++) {
    await page.keyboard.press('Tab');
    await sleep(SETTLE_MS); // let any color/background-color transition finish — see SETTLE_MS comment above
    const snap = await page.evaluate(() => {
      const el = document.activeElement;
      if (!el || el === document.body || el === document.documentElement) return { isBody: true };
      const cs = getComputedStyle(el);
      const bgInfo = eaFindBg(el);
      return {
        isBody: false,
        tag: el.tagName,
        cls: el.className || '',
        id: el.id || '',
        href: el.getAttribute ? el.getAttribute('href') || '' : '',
        text: (el.textContent || '').trim().slice(0, 40),
        color: cs.color,
        bg: bgInfo.bg,
        bgFound: bgInfo.bgFound,
        bgNode: bgInfo.bgNode,
        outlineStyle: cs.outlineStyle,
        outlineColor: cs.outlineColor,
        outlineWidth: cs.outlineWidth,
        inNavL: !!el.closest('.nav__l'),
        inNavSub: !!el.closest('.nav__sub'),
        inFootBase: !!el.closest('.foot__base'),
        inFoot: !!el.closest('.foot'),
      };
    });
    tabLog.push({ i, snap });
    if (i === 0 && !snap.isBody) firstTabMovedFocus = true;
    if (snap.isBody) continue;
    const key = classify(snap);
    if (key && !focused[key]) focused[key] = snap;
  }

  // re-verify nav scroll state wasn't lost during the walk (fixed elements
  // shouldn't trigger page auto-scroll, but confirm rather than assume)
  const navStateAfterWalk = await page.evaluate(() => {
    const nav = document.querySelector('.nav');
    return nav ? nav.getAttribute('data-s') : null;
  });

  await page.evaluate(() => {
    if (document.activeElement) document.activeElement.blur();
  });

  const report = {
    mode: MODE,
    date: new Date().toISOString(),
    base: BASE,
    injected,
    viewport,
    viewportNonZero: viewport.w > 0 && viewport.h > 0,
    httpStatus: resp ? resp.status() : null,
    firstTabMovedFocusOffBody: firstTabMovedFocus,
    navForcedToScrolledState: navScrolledState,
    navDataSAfterWalk: navStateAfterWalk,
    maxTabsWalked: MAX_TABS,
    components: {},
  };

  function addComponent(key, label, uSnap, fSnap) {
    const u =
      uSnap && uSnap.found
        ? { color: uSnap.color, bg: uSnap.bg, bgFound: uSnap.bgFound, ratio: uSnap.bgFound ? ratio(uSnap.color, uSnap.bg) : null }
        : { measured: false, note: 'selector not found on page' };
    const f = fSnap
      ? {
          color: fSnap.color,
          bg: fSnap.bg,
          bgFound: fSnap.bgFound,
          outlineStyle: fSnap.outlineStyle,
          ratio: fSnap.bgFound ? ratio(fSnap.color, fSnap.bg) : null,
        }
      : { measured: false, note: 'not reached via real Tab within maxTabsWalked' };
    report.components[key] = { label, unfocused: u, focused: f };
  }

  addComponent('skiplink', '.ea-skiplink', unfocused.skiplink, focused.skiplink);
  addComponent('nav_en', '.nav__en (language toggle)', unfocused.nav_en, focused.nav_en);
  addComponent('nav_b', '.nav__b (logo link)', unfocused.nav_b, focused.nav_b);
  addComponent('nav_dd_first', 'a.nav__dd (nav dropdown item that is itself a link)', unfocused.nav_dd_first, focused.nav_dd_first);
  addComponent('nav_l_first', '.nav__l plain nav item', unfocused.nav_l_first, focused.nav_l_first);
  addComponent('nav_sub_first', '.nav__sub dropdown submenu item', unfocused.nav_sub_first || { found: false }, focused.nav_sub_first);
  addComponent('foot_link', '.foot a (footer nav link)', unfocused.foot_link, focused.foot_link);
  addComponent('foot_base_link', '.foot__base a (legal/copyright link)', unfocused.foot_base_link, focused.foot_base_link);
  addComponent('tlink', '.tlink (inline text link)', unfocused.tlink, focused.tlink);
  addComponent('btn_terra', '.btn--terra (CTA button, e.g. Contact)', unfocused.btn_terra, focused.btn_terra);
  addComponent('btn_gw', '.btn--gw (ghost-white CTA button)', unfocused.btn_gw, focused.btn_gw);
  addComponent('btn_gd', '.btn--gd (ghost-dark CTA button)', unfocused.btn_gd, focused.btn_gd);
  addComponent('whatsapp', '.ea-whatsapp-float', unfocused.whatsapp, focused.whatsapp);

  fs.mkdirSync(path.dirname(OUT), { recursive: true });
  fs.writeFileSync(OUT, JSON.stringify({ report, tabLog }, null, 2));

  console.log(JSON.stringify(report, null, 2));
  console.log('Full tab log + report written to:', OUT);

  await browser.close();
})();
