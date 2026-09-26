#!/usr/bin/env node
// measure_chap.mjs — measure real rendered contrast of .phero .chap eyebrow labels.
// Methodology (see task spec):
//   1. Real headless Chrome via CDP (chrome-headless-shell), load + settle + 2 rAF, dismiss
//      the #ea-cookie-notice <dialog>.
//   2. Locate every .chap element inside .phero via DOM query.
//   3. Get REAL glyph rects via Range.getClientRects() over the text node (not the block box).
//   4. Screenshot A = page as rendered (text + text-shadow visible).
//   5. Inject `color:transparent !important` on that one element only (text-shadow is a
//      separate paint operation keyed off its own declared rgba, NOT currentColor here, so it
//      keeps rendering) -> screenshot B = the real local background (photo + scrim + shadow
//      halo) with no glyph ink at all, pixel-for-pixel aligned with A (no reflow).
//   6. For each pixel inside the glyph rects, filter to ones near the element's OWN solid
//      computed color in screenshot A (the true ink, excluding anti-aliased blend pixels).
//   7. For each such (x,y), composite(fg_rgba, B(x,y)) -> effective foreground actually shown,
//      compute WCAG contrast against B(x,y). Worst (min) ratio across samples = page result.
//   8. Confirm via elementFromPoint that the .chap span is the topmost element at a sample.
//
// Usage: node measure_chap.mjs <urls.json> <outdir> [concurrency]
import { spawn, execSync } from 'node:child_process';
import { mkdirSync, writeFileSync, readFileSync, existsSync } from 'node:fs';
import path from 'node:path';

function findChrome() {
  try {
    const home = process.env.HOME;
    const out = execSync(
      `find "${home}/.cache/puppeteer" -name chrome-headless-shell -type f 2>/dev/null | sort -V | tail -1`,
      { encoding: 'utf8' }
    ).trim();
    if (out) return out;
  } catch {}
  throw new Error('No chrome-headless-shell found');
}

const CHROME = findChrome();

function launchChrome(port) {
  return spawn(CHROME, [
    '--headless', '--disable-gpu', '--no-sandbox',
    `--remote-debugging-port=${port}`,
    '--ignore-certificate-errors', // DEV ONLY — staging cert invalid by design
    '--hide-scrollbars',
    '--window-size=1440,1200',
  ], { stdio: 'ignore' });
}

async function cdpConnect(port) {
  const t = await (await fetch(`http://127.0.0.1:${port}/json/new?about:blank`, { method: 'PUT' })).json();
  const ws = new WebSocket(t.webSocketDebuggerUrl);
  let id = 0; const pend = {};
  ws.addEventListener('message', e => {
    const m = JSON.parse(e.data);
    if (m.id && pend[m.id]) { pend[m.id](m); delete pend[m.id]; }
  });
  await new Promise(r => ws.addEventListener('open', r));
  const send = (method, params = {}) => new Promise((res, rej) => {
    const i = ++id;
    const timer = setTimeout(() => { delete pend[i]; rej(new Error('cdp timeout ' + method)); }, 20000);
    pend[i] = (m) => { clearTimeout(timer); res(m); };
    ws.send(JSON.stringify({ id: i, method, params }));
  });
  return { ws, send, targetId: t.id, port };
}

async function closeTab({ ws, targetId, port }) {
  try { ws.close(); } catch {}
  try { await fetch(`http://127.0.0.1:${port}/json/close/${targetId}`); } catch {}
}

async function evalJSOnce(conn, expression, awaitPromise = false) {
  const r = await conn.send('Runtime.evaluate', { expression, returnByValue: true, awaitPromise });
  if (r.error) throw new Error('CDP error: ' + JSON.stringify(r.error));
  if (r.result && r.result.exceptionDetails) {
    throw new Error('JS error: ' + JSON.stringify(r.result.exceptionDetails.exception?.description || r.result.exceptionDetails));
  }
  if (!r.result || !('result' in r.result)) throw new Error('CDP evaluate returned no result (context likely destroyed)');
  return r.result.result.value;
}

async function evalJS(conn, expression, awaitPromise = false, retries = 3) {
  let lastErr;
  for (let i = 0; i <= retries; i++) {
    try { return await evalJSOnce(conn, expression, awaitPromise); }
    catch (e) { lastErr = e; await new Promise(r => setTimeout(r, 350)); }
  }
  throw lastErr;
}

async function fetchWithRetry(url, opts = {}, retries = 3) {
  for (let i = 0; i <= retries; i++) {
    try {
      const r = await fetch(url, { ...opts, redirect: 'manual' });
      if (r.status === 502 && i < retries) { await new Promise(res => setTimeout(res, 800 * (i + 1))); continue; }
      return r;
    } catch (e) {
      if (i === retries) throw e;
      await new Promise(res => setTimeout(res, 800 * (i + 1)));
    }
  }
}

async function measurePage(port, url, outdir, tag, viewport) {
  const vp = viewport || { width: 1440, height: 1100, mobile: false };
  const conn = await cdpConnect(port);
  try {
    await conn.send('Page.enable');
    await conn.send('Runtime.enable');
    await conn.send('Emulation.setDeviceMetricsOverride', { width: vp.width, height: vp.height, deviceScaleFactor: 1, mobile: vp.mobile });

    let httpStatus = null;
    let crashed = false;
    conn.ws.addEventListener('message', e => {
      const m = JSON.parse(e.data);
      if (m.method === 'Network.responseReceived' && m.params.type === 'Document') {
        httpStatus = m.params.response.status;
      }
      if (m.method === 'Inspector.targetCrashed') crashed = true;
    });
    await conn.send('Network.enable');
    await conn.send('Inspector.enable');
    // Third-party video embeds (YouTube etc.) on some hero/lower-page sections were
    // observed to crash chrome-headless-shell's renderer minutes into a run (tab
    // silently reverts to about:blank, wiping the DOM before our later evaluates
    // run). They are unrelated to .phero .chap layout/paint, so block them outright
    // for measurement stability — this is a QA-harness choice, not a site change.
    await conn.send('Network.setBlockedURLs', { urls: [
      '*youtube.com*', '*youtube-nocookie.com*', '*ytimg.com*',
      '*vimeo.com*', '*vimeocdn.com*',
      '*doubleclick.net*', '*google-analytics.com*', '*googletagmanager.com*',
      '*facebook.net*', '*connect.facebook.net*', '*hotjar.com*', '*clarity.ms*',
    ] });

    const targetPath = new URL(url).pathname;
    let navErr = null;
    for (let attempt = 0; attempt < 5; attempt++) {
      httpStatus = null;
      // wait for the CDP loadEventFired event (robust vs. racing an in-page evaluate
      // against a context that navigation is still tearing down/rebuilding).
      let loadResolve;
      const loadPromise = new Promise(res => { loadResolve = res; });
      const onMsg = (e) => {
        const m = JSON.parse(e.data);
        if (m.method === 'Page.loadEventFired') loadResolve(true);
      };
      conn.ws.addEventListener('message', onMsg);
      await conn.send('Page.navigate', { url: url });
      const timedOut = await Promise.race([
        loadPromise.then(() => false),
        new Promise(res => setTimeout(() => res(true), 18000)),
      ]);
      conn.ws.removeEventListener('message', onMsg);
      if (httpStatus === 502) { navErr = 502; await new Promise(r => setTimeout(r, 1500)); continue; }
      if (timedOut) { navErr = 'timeout'; await new Promise(r => setTimeout(r, 1000)); continue; }
      // A fresh tab starts at about:blank, and a NEW target's implicit lifecycle
      // events (fired when Page domain is enabled against already-settled state)
      // can occasionally satisfy the loadEventFired wait above for the WRONG
      // document. Verify the committed URL/readyState before trusting the load.
      let verified = false;
      try {
        const state = await evalJS(conn, `JSON.stringify({rs: document.readyState, path: location.pathname, blen: document.body ? document.body.innerHTML.length : 0})`, false, 1);
        const st = JSON.parse(state);
        verified = st.rs === 'complete' && st.blen > 200 && (st.path === targetPath || st.path === targetPath.replace(/\/$/, ''));
      } catch (e) { verified = false; }
      if (!verified) { navErr = 'unverified'; await new Promise(r => setTimeout(r, 900)); continue; }
      navErr = null;
      break;
    }

    // Settle: 2 rAF (retry the evaluate itself in case the context is momentarily
    // unstable right after load), then dismiss the cookie dialog.
    for (let i = 0; i < 5; i++) {
      try {
        await evalJS(conn, `new Promise(r => requestAnimationFrame(() => requestAnimationFrame(() => r(true))))`, true);
        break;
      } catch (e) { await new Promise(r => setTimeout(r, 400)); }
    }
    for (let i = 0; i < 3; i++) {
      try {
        await evalJS(conn, `
          (function(){
            try {
              const d = document.getElementById('ea-cookie-notice');
              if (d && typeof d.close === 'function' && d.open) d.close();
              const btn = document.querySelector('#ea-cookie-notice [data-accept], #ea-cookie-notice .accept, #ea-cookie-notice button');
              if (btn) btn.click();
            } catch(e) {}
            return true;
          })()
        `);
        break;
      } catch (e) { await new Promise(r => setTimeout(r, 300)); }
    }
    await new Promise(r => setTimeout(r, 500));

    const title = await evalJS(conn, `document.title`);
    const bodyLen = await evalJS(conn, `document.body ? document.body.innerHTML.length : 0`);
    // The canonical primary nav is template-parts/chapters/section-nav.php's
    // <nav id="nav">, printed through a "mark once per request" guard
    // (ea_chapters_nav_mark_once) specifically so it can only ever appear once;
    // header.php's separate .ea-shell-nav markup is not what chapters-template
    // pages (the ones with .phero) actually render. The canonical footer is
    // inc/ea-canonical-nav.php's ea_render_unified_footer(), <footer
    // role="contentinfo" class="ea-ftr">, likewise documented as "this ONE
    // footer renders identically regardless of" caller.
    const navCount = await evalJS(conn, `document.querySelectorAll('nav#nav').length`);
    const footerCount = await evalJS(conn, `document.querySelectorAll('footer[role="contentinfo"]').length`);
    const phpErr = await evalJS(conn, `/Fatal error|Parse error|Warning:\\s*\\S+ in |Notice:\\s*\\S+ in |Uncaught Error/.test(document.body ? document.body.innerText : '')`);

    // Find .chap elements inside .phero, gather rect + style data.
    const chaps = await evalJS(conn, `
      (function(){
        const els = Array.from(document.querySelectorAll('.phero .chap'));
        return els.map((el, idx) => {
          const cs = getComputedStyle(el);
          const phero = el.closest('.phero');
          const rect = el.getBoundingClientRect();
          // real glyph rects via Range over the text content
          const range = document.createRange();
          const tn = Array.from(el.childNodes).find(n => n.nodeType === 3 && n.textContent.trim().length);
          let rects = [];
          if (tn) {
            range.selectNodeContents(tn);
            rects = Array.from(range.getClientRects()).map(r => ({x:r.x,y:r.y,width:r.width,height:r.height}));
          }
          el.setAttribute('data-probe-idx', String(idx));
          return {
            idx, color: cs.color, textShadow: cs.textShadow, fontSize: cs.fontSize, fontWeight: cs.fontWeight,
            isMedia: !!(phero && phero.classList.contains('phero--media')),
            blockRect: {x:rect.x,y:rect.y,width:rect.width,height:rect.height},
            rects, text: el.textContent
          };
        });
      })()
    `);

    if (!chaps || chaps.length === 0) {
      return { url, httpStatus, navErr, title, bodyLen, navCount, footerCount, phpErr, chapCount: 0, results: [] };
    }

    // Screenshot A (as rendered)
    const capA = await conn.send('Page.captureScreenshot', { format: 'png' });
    const pathA = path.join(outdir, `${tag}_A.png`);
    writeFileSync(pathA, Buffer.from(capA.result.data, 'base64'));

    // Hide ink only (color: transparent) on ALL probed .chap elements; text-shadow stays.
    await evalJS(conn, `
      document.querySelectorAll('.phero .chap[data-probe-idx]').forEach(el => {
        el.style.setProperty('color', 'transparent', 'important');
      });
    `);
    await evalJS(conn, `new Promise(r=>requestAnimationFrame(()=>requestAnimationFrame(r)))`, true);
    const capB = await conn.send('Page.captureScreenshot', { format: 'png' });
    const pathB = path.join(outdir, `${tag}_B.png`);
    writeFileSync(pathB, Buffer.from(capB.result.data, 'base64'));

    // elementFromPoint sanity check at the first rect's center of each chap
    const topmostChecks = await evalJS(conn, `
      Array.from(document.querySelectorAll('.phero .chap[data-probe-idx]')).map(el => {
        const r = el.getBoundingClientRect();
        const cx = r.x + r.width/2, cy = r.y + r.height/2;
        const top = document.elementFromPoint(cx, cy);
        return { idx: el.getAttribute('data-probe-idx'), topIsSelf: top === el || el.contains(top) || (top && top.closest && top.closest('.chap') === el) };
      })
    `);

    return { url, httpStatus, navErr, title, bodyLen, navCount, footerCount, phpErr, chapCount: chaps.length, chaps, pathA, pathB, topmostChecks };
  } finally {
    await closeTab(conn);
  }
}

async function main() {
  const [,, urlsFile, outdir, concurrencyArg] = process.argv;
  const concurrency = parseInt(concurrencyArg || '3', 10);
  mkdirSync(outdir, { recursive: true });
  const urls = JSON.parse(readFileSync(urlsFile, 'utf8'));

  const port = 9222 + Math.floor(Math.random() * 500);
  const proc = launchChrome(port);
  await new Promise(r => setTimeout(r, 1500));
  // Warm-up: the very first CDP navigation after a cold Chrome launch races the
  // renderer process pool spinning up (observed: first page's loadEventFired listener
  // can be attached after the event already fired, or the target's first commit is
  // still mid-flight) and silently short-circuits with an apparently-loaded-but-empty
  // DOM. Burn one throwaway navigation before starting the real queue.
  try {
    const warm = await cdpConnect(port);
    await warm.send('Page.enable');
    await warm.send('Page.navigate', { url: 'about:blank' });
    await new Promise(r => setTimeout(r, 400));
    await warm.send('Page.navigate', { url: urls[0].link });
    await new Promise(r => setTimeout(r, 3000));
    await closeTab(warm);
  } catch (e) { /* best-effort warm-up; real queue still runs */ }

  const results = [];
  let cursor = 0;
  async function worker(workerIdx) {
    while (cursor < urls.length) {
      const i = cursor++;
      const item = urls[i];
      const tag = `p${i}_${workerIdx}`;
      let res;
      // Whole-page-attempt retry: a legitimately loaded page never has an empty
      // title/body. Whatever caused an empty read this time (renderer hiccup,
      // in-page transition JS, a stray about:blank race) is not diagnosable per
      // page at this scale, so treat "empty after settle" as fully retryable —
      // close the tab and start that page over from a clean one.
      for (let outerAttempt = 0; outerAttempt < 3; outerAttempt++) {
        try {
          res = await measurePage(port, item.link, outdir, tag, item.viewport);
        } catch (e) {
          res = { url: item.link, error: String(e && e.message || e) };
        }
        const emptyRead = !res.error && (!res.title || res.bodyLen === 0);
        if (!emptyRead) break;
        res.retriedEmpty = (res.retriedEmpty || 0) + 1;
        await new Promise(r => setTimeout(r, 500));
      }
      res.meta = item;
      results.push(res);
      if (results.length % 10 === 0) process.stderr.write(`progress: ${results.length}/${urls.length}\n`);
    }
  }
  await Promise.all(Array.from({length: concurrency}, (_,i) => worker(i)));
  proc.kill();
  writeFileSync(path.join(outdir, 'results.json'), JSON.stringify(results, null, 1));
  console.log('DONE', results.length);
}
main().catch(e => { console.error('FATAL', e); process.exit(1); });
