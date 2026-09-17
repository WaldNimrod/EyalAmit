#!/usr/bin/env node
/**
 * WS-3B task 1 — submenu aria-expanded truthfulness proof (team_10 BUILD line).
 * Mandate: _COMMUNICATION/team_10/A11Y-FIX-2026-09-18/00-BRIEF-SHARED-FIX.md
 * Report:  _COMMUNICATION/team_10/A11Y-FIX-2026-09-18/05-DONE-ARIA-AND-FORM-LANG.md
 *
 * Proves the ea-chapters.js fix against the LIVE staging page WITHOUT deploying:
 * request-intercepts the exact ea-chapters.js URL the page requests and serves
 * this repo's local (edited) file instead — same "prove the fix live, no deploy"
 * technique as ws-2-1-focus-contrast-proof.cjs uses via addStyleTag, adapted for
 * JS via response substitution instead (addScriptTag would run a SECOND copy of
 * the IIFE alongside the live one and double every listener).
 *
 * Real Chrome, real mouse hover (page.hover -> native mouseenter/mouseleave) and
 * real keyboard Tab (page.keyboard.press('Tab'), not element.focus()), asserted
 * non-zero viewport, and an explicit check that Tab actually moves focus off
 * BODY before any focus-based assertion is trusted (charter measurement traps).
 *
 * Usage:
 *   node ws-3b-nav-dd-aria-proof.cjs
 *
 * Env overrides: EA_CHROME, EA_QA_BASE (see ws-2-1-focus-contrast-proof.cjs).
 */
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const BASE = process.env.EA_QA_BASE || 'http://eyalamit-co-il-2026.s887.upress.link';
const LOCAL_JS_PATH = path.join(
  __dirname,
  '..', '..',
  'site/wp-content/themes/ea-eyalamit/assets/js/ea-chapters.js'
);
const OUT = path.join(__dirname, 'reports', 'ws-3b-nav-dd-aria-proof.json');
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

const localJsSrc = fs.readFileSync(LOCAL_JS_PATH, 'utf8');
const report = { base: BASE, localJsBytes: Buffer.byteLength(localJsSrc, 'utf8'), interceptHits: 0 };

async function tabWalk(page, maxTabs, onStep, settleMs) {
  await page.evaluate(() => { if (document.activeElement) document.activeElement.blur(); });
  const log = [];
  for (let i = 0; i < maxTabs; i++) {
    await page.keyboard.press('Tab');
    if (settleMs) await sleep(settleMs);
    const snap = await page.evaluate(() => {
      const el = document.activeElement;
      if (!el || el === document.body || el === document.documentElement) return { isBody: true };
      const navL = document.querySelector('.nav__l');
      const btn = el.closest && el.closest('.nav__dd[aria-haspopup="true"]');
      return {
        isBody: false,
        tag: el.tagName,
        cls: el.className || '',
        text: (el.textContent || '').trim().slice(0, 30),
        inNavL: !!(navL && navL.contains(el)),
        isDDButton: !!btn,
        ddExpanded: btn ? btn.getAttribute('aria-expanded') : null,
      };
    });
    log.push(snap);
    if (onStep) onStep(i, snap);
  }
  return log;
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors'],
  });
  const page = await browser.newPage();

  await page.setRequestInterception(true);
  page.on('request', (req) => {
    if (req.url().indexOf('/assets/js/ea-chapters.js') !== -1) {
      report.interceptHits++;
      req.respond({ status: 200, contentType: 'application/javascript; charset=utf-8', body: localJsSrc });
    } else {
      req.continue();
    }
  });

  // ================= DESKTOP PASS =================
  await page.setViewport({ width: 1440, height: 900 });
  const resp = await page.goto(BASE.replace(/\/$/, '') + '/', { waitUntil: 'networkidle2', timeout: 90000 });
  const html = await page.content();
  report.desktop = { httpStatus: resp ? resp.status() : null, htmlBytes: Buffer.byteLength(html, 'utf8') };
  if (!resp || !resp.ok() || report.desktop.htmlBytes < 5000) {
    report.desktop.pageLoadOk = false;
  } else {
    report.desktop.pageLoadOk = true;
  }

  const viewport = await page.evaluate(() => ({ w: window.innerWidth, h: window.innerHeight }));
  report.desktop.viewport = viewport;
  report.desktop.viewportNonZero = viewport.w > 0 && viewport.h > 0;

  // confirm the intercepted (local, fixed) script is the one that actually ran —
  // not by trusting the network log alone, but by a behavioural marker the OLD
  // live script cannot produce: a `.nav__dd[aria-haspopup]` button whose
  // aria-expanded attribute changes at all in response to hover.
  const ddSelectors = await page.evaluate(() =>
    Array.prototype.map.call(
      document.querySelectorAll('.nav__l > li > .nav__dd[aria-haspopup="true"]'),
      (el, i) => ({ i, text: (el.textContent || '').trim().slice(0, 20), initialExpanded: el.getAttribute('aria-expanded') })
    )
  );
  report.desktop.ddButtonsFound = ddSelectors.length;
  report.desktop.ddButtonsInitial = ddSelectors;

  // the three <a class="nav__dd"> real links must carry NO aria-expanded at all
  const ddAnchors = await page.evaluate(() =>
    Array.prototype.map.call(document.querySelectorAll('a.nav__dd'), (el) => ({
      href: el.getAttribute('href'),
      hasAriaExpanded: el.hasAttribute('aria-expanded'),
      hasAriaHaspopup: el.hasAttribute('aria-haspopup'),
    }))
  );
  report.desktop.ddAnchors = ddAnchors;

  // ---- hover test on each of the 2 buttons ----
  report.desktop.hoverTests = [];
  const btnHandles = await page.$$('.nav__l > li > .nav__dd[aria-haspopup="true"]');
  for (let i = 0; i < btnHandles.length; i++) {
    const before = await page.evaluate((el) => el.getAttribute('aria-expanded'), btnHandles[i]);
    await btnHandles[i].hover();
    await sleep(150);
    const duringHover = await page.evaluate((el) => el.getAttribute('aria-expanded'), btnHandles[i]);
    await page.mouse.move(5, 5);
    await sleep(150);
    const afterMoveAway = await page.evaluate((el) => el.getAttribute('aria-expanded'), btnHandles[i]);
    report.desktop.hoverTests.push({ index: i, before, duringHover, afterMoveAway });
  }

  // ---- real keyboard focus-within test on button index 1 ("אייל עמית", later in tab order) ----
  let sawOffBody = false;
  let sawExpandedTrueOnButton = false;
  let sawExpandedTrueWhileInSubmenuLink = false;
  let sawExpandedFalseAfterLeavingLi = false;
  let targetLiExpandedHistory = [];
  await tabWalk(page, 90, (i, snap) => {
    if (!snap.isBody && i === 0) sawOffBody = true;
    if (snap.isDDButton && snap.text && snap.text.indexOf('אייל עמית') !== -1) {
      sawExpandedTrueOnButton = snap.ddExpanded === 'true';
      targetLiExpandedHistory.push({ where: 'button', expanded: snap.ddExpanded, tag: snap.tag });
    } else if (targetLiExpandedHistory.length && snap.inNavL && !snap.isDDButton) {
      // could be a submenu link still inside the same li, or the next top-level item
      targetLiExpandedHistory.push({ where: snap.tag, text: snap.text, inNavL: snap.inNavL });
    }
  });
  report.desktop.keyboardWalk = { sawOffBody, targetLiExpandedHistorySample: targetLiExpandedHistory.slice(0, 8) };

  // re-derive the focus-within assertions directly via a fresh, targeted tab walk
  // that reads the SECOND dd button's own aria-expanded at each step (cleaner
  // signal than reconstructing it from the generic walk above).
  await page.evaluate(() => { if (document.activeElement) document.activeElement.blur(); });
  let steps2 = [];
  for (let i = 0; i < 90; i++) {
    await page.keyboard.press('Tab');
    await sleep(60);
    const snap = await page.evaluate(() => {
      const el = document.activeElement;
      const btns = document.querySelectorAll('.nav__l > li > .nav__dd[aria-haspopup="true"]');
      const target = btns[1]; // "אייל עמית"
      const li = target ? target.closest('li') : null;
      return {
        isBody: !el || el === document.body,
        focusedIsTarget: el === target,
        focusedInTargetLi: !!(li && el && li.contains(el)),
        targetExpanded: target ? target.getAttribute('aria-expanded') : null,
        focusedTag: el ? el.tagName : null,
        focusedText: el ? (el.textContent || '').trim().slice(0, 24) : null,
      };
    });
    steps2.push(snap);
    if (snap.focusedIsTarget) sawExpandedTrueOnButton = snap.targetExpanded === 'true';
    if (snap.focusedInTargetLi && !snap.focusedIsTarget && snap.targetExpanded === 'true') {
      sawExpandedTrueWhileInSubmenuLink = true;
    }
    if (!snap.focusedInTargetLi && !snap.isBody) {
      // once we've entered the li at least once and then left it, confirm it dropped
      const enteredBefore = steps2.slice(0, -1).some((s) => s.focusedInTargetLi);
      if (enteredBefore && !sawExpandedFalseAfterLeavingLi) {
        sawExpandedFalseAfterLeavingLi = snap.targetExpanded === 'false';
      }
    }
  }
  report.desktop.focusWithinAssertions = {
    sawExpandedTrueOnButton,
    sawExpandedTrueWhileInSubmenuLink,
    sawExpandedFalseAfterLeavingLi,
  };

  // ================= MOBILE PASS (390px, per brief) =================
  await page.setViewport({ width: 390, height: 844 });
  const respM = await page.goto(BASE.replace(/\/$/, '') + '/', { waitUntil: 'networkidle2', timeout: 90000 });
  const htmlM = await page.content();
  report.mobile = { httpStatus: respM ? respM.status() : null, htmlBytes: Buffer.byteLength(htmlM, 'utf8') };
  const viewportM = await page.evaluate(() => ({ w: window.innerWidth, h: window.innerHeight }));
  report.mobile.viewport = viewportM;
  report.mobile.viewportNonZero = viewportM.w > 0 && viewportM.h > 0;

  // ---- closed-drawer tab count (expect 0 inside .nav__l) ----
  let closedOffBody = false;
  let closedInNavLCount = 0;
  const closedLog = await tabWalk(page, 60, (i, snap) => {
    if (i === 0 && !snap.isBody) closedOffBody = true;
    if (snap.inNavL) closedInNavLCount++;
  }, 40);
  report.mobile.closed = { offBody: closedOffBody, inNavLCount: closedInNavLCount };

  // ---- open the drawer via a real click, confirm burger + both dd buttons flip ----
  await page.evaluate(() => { if (document.activeElement) document.activeElement.blur(); });
  await page.click('.nav__burger');
  await sleep(450);
  const openState = await page.evaluate(() => {
    const nav = document.getElementById('nav');
    const burger = nav.querySelector('.nav__burger');
    const dds = Array.prototype.map.call(
      document.querySelectorAll('.nav__l > li > .nav__dd[aria-haspopup="true"]'),
      (el) => el.getAttribute('aria-expanded')
    );
    return { dataMenu: nav.getAttribute('data-menu'), burgerExpanded: burger.getAttribute('aria-expanded'), ddExpanded: dds };
  });
  report.mobile.afterOpenClick = openState;

  // ---- open-drawer tab count (expect 28 inside .nav__l, per brief) ----
  let openInNavLCount = 0;
  await tabWalk(page, 45, (i, snap) => { if (snap.inNavL) openInNavLCount++; }, 40);
  report.mobile.open = { inNavLCount: openInNavLCount };

  // ---- Escape closes it; both dd buttons must revert to false ----
  await page.keyboard.press('Escape');
  await sleep(450);
  const afterEscape = await page.evaluate(() => {
    const nav = document.getElementById('nav');
    const burger = nav.querySelector('.nav__burger');
    const dds = Array.prototype.map.call(
      document.querySelectorAll('.nav__l > li > .nav__dd[aria-haspopup="true"]'),
      (el) => el.getAttribute('aria-expanded')
    );
    return { dataMenu: nav.getAttribute('data-menu'), burgerExpanded: burger.getAttribute('aria-expanded'), ddExpanded: dds };
  });
  report.mobile.afterEscape = afterEscape;

  // ---- re-verify closed count after close (regression guard on commit 57883f8) ----
  let reClosedInNavLCount = 0;
  await tabWalk(page, 60, (i, snap) => { if (snap.inNavL) reClosedInNavLCount++; }, 40);
  report.mobile.reClosedAfterEscape = { inNavLCount: reClosedInNavLCount };

  fs.mkdirSync(path.dirname(OUT), { recursive: true });
  fs.writeFileSync(OUT, JSON.stringify(report, null, 2));
  console.log(JSON.stringify(report, null, 2));
  console.log('\nWrote', OUT);

  await browser.close();
})().catch((err) => {
  console.error('FATAL', err);
  process.exit(1);
});
