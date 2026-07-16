#!/usr/bin/env node
/**
 * qr_cwv_probe.mjs — measure the REAL cost of the QR YouTube embeds.
 *
 * Question being answered (WP-S5-02 §3.2 facade decision):
 *   Does `loading="lazy"` actually defer the first (above-fold) YouTube embed,
 *   or does the full player payload load anyway? If it loads, a click-to-load
 *   facade would prevent it; if not, the facade is unnecessary.
 *
 * Method: headless Chrome over raw CDP (pattern reused from
 *   _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs).
 *   --ignore-certificate-errors is DEV-ONLY (staging cert invalid by design).
 *
 * Measures per page, at mobile 375x812 (the real QR audience — scanned from a book):
 *   - requests + transferred bytes, split youtube/ytimg vs rest
 *   - LCP (PerformanceObserver, largest-contentful-paint)
 *   - load event timing
 */
import { spawn, execSync } from 'node:child_process';

function findChrome() {
  try {
    const home = process.env.HOME;
    const out = execSync(
      `find "${home}/.cache/puppeteer" -name chrome-headless-shell -type f 2>/dev/null | sort -V | tail -1`,
      { encoding: 'utf8' }
    ).trim();
    if (out) return out;
  } catch {}
  for (const p of [
    '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
    '/usr/bin/chromium', '/usr/bin/google-chrome',
  ]) { try { execSync(`test -x "${p}"`); return p; } catch {} }
  throw new Error('No Chrome binary found');
}

const BASE = 'https://eyalamit-co-il-2026.s887.upress.link';
const PAGES = [
  { name: 'qr48 (0 videos — baseline)', path: '/qr/qr48/', videos: 0 },
  { name: 'qr2  (1 video)',             path: '/qr/qr2/',  videos: 1 },
  { name: 'qr10 (3 videos)',            path: '/qr/qr10/', videos: 3 },
];
// ONLY real YouTube-embed hosts. fonts.gstatic.com is Google Fonts (site-wide,
// unrelated to the embeds) — counting it would fake a payload on the 0-video baseline.
const YT = /(^|\.)(youtube\.com|youtube-nocookie\.com|ytimg\.com|googlevideo\.com)/i;
const ytHost = (u) => { try { return YT.test(new URL(u).host); } catch { return false; } };
const SETTLE_MS = 9000;

const LCP_SCRIPT = `
window.__lcp = 0; window.__lcpEl = '';
try {
  new PerformanceObserver((l) => {
    for (const e of l.getEntries()) { window.__lcp = e.startTime; window.__lcpEl = (e.element && e.element.tagName) || ''; }
  }).observe({ type: 'largest-contentful-paint', buffered: true });
} catch (e) {}
`;

async function probe(chromePort, pg) {
  const url = BASE + pg.path + '?nc=' + Date.now();
  const t = await (await fetch(`http://127.0.0.1:${chromePort}/json/new?about:blank`, { method: 'PUT' })).json();
  const ws = new WebSocket(t.webSocketDebuggerUrl);
  let id = 0; const pend = {};
  const reqs = new Map();     // requestId -> {url, type}
  const bytes = new Map();    // requestId -> encodedDataLength

  ws.addEventListener('message', (e) => {
    const m = JSON.parse(e.data);
    if (m.id && pend[m.id]) { pend[m.id](m); return; }
    if (m.method === 'Network.requestWillBeSent') {
      reqs.set(m.params.requestId, { url: m.params.request.url, type: m.params.type });
    } else if (m.method === 'Network.loadingFinished') {
      bytes.set(m.params.requestId, m.params.encodedDataLength || 0);
    } else if (m.method === 'Network.responseReceived') {
      const r = reqs.get(m.params.requestId);
      if (r) r.type = m.params.type || r.type;
    }
  });
  await new Promise(r => ws.addEventListener('open', r));
  const send = (method, params = {}) => new Promise(res => { const i = ++id; pend[i] = res; ws.send(JSON.stringify({ id: i, method, params })); });

  await send('Page.enable'); await send('Runtime.enable'); await send('Network.enable');
  // Cold cache per page — otherwise the 2nd/3rd page reuses the player JS the 1st
  // page already fetched and its byte count collapses to a meaningless number.
  await send('Network.setCacheDisabled', { cacheDisabled: true });
  await send('Network.clearBrowserCache');
  await send('Network.clearBrowserCookies');
  await send('Emulation.setDeviceMetricsOverride', { width: 375, height: 812, deviceScaleFactor: 2, mobile: true });
  await send('Page.addScriptToEvaluateOnNewDocument', { source: LCP_SCRIPT });
  await send('Page.navigate', { url });
  await new Promise(r => setTimeout(r, SETTLE_MS));

  const ev = await send('Runtime.evaluate', {
    expression: `JSON.stringify({
      lcp: Math.round(window.__lcp||0), lcpEl: window.__lcpEl||'',
      load: Math.round((performance.timing.loadEventEnd - performance.timing.navigationStart)||0),
      iframes: document.querySelectorAll('iframe').length,
      lazyIframes: document.querySelectorAll('iframe[loading="lazy"]').length,
      firstIframeTop: (() => { const f=document.querySelector('iframe'); if(!f) return null;
        const r=f.getBoundingClientRect(); return Math.round(r.top + window.scrollY); })(),
      viewportH: window.innerHeight
    })`, returnByValue: true,
  });
  const v = JSON.parse(ev.result.result.value);

  let ytReq = 0, ytBytes = 0, otherReq = 0, otherBytes = 0;
  const ytHosts = new Set();
  for (const [rid, r] of reqs) {
    const b = bytes.get(rid) || 0;
    if (ytHost(r.url)) { ytReq++; ytBytes += b; try { ytHosts.add(new URL(r.url).host); } catch {} }
    else { otherReq++; otherBytes += b; }
  }
  ws.close(); await fetch(`http://127.0.0.1:${chromePort}/json/close/${t.id}`).catch(() => {});
  return { ...pg, ...v, ytReq, ytBytes, otherReq, otherBytes, ytHosts: [...ytHosts] };
}

const chrome = findChrome();
const port = 9400 + Math.floor(Math.random() * 400);
const proc = spawn(chrome, ['--headless', '--disable-gpu', '--no-sandbox',
  `--remote-debugging-port=${port}`, '--ignore-certificate-errors', '--hide-scrollbars'], { stdio: 'ignore' });
await new Promise(r => setTimeout(r, 2000));

const out = [];
try {
  for (const pg of PAGES) {
    process.stderr.write(`probing ${pg.path} ...\n`);
    try { out.push(await probe(port, pg)); }
    catch (e) { out.push({ ...pg, error: String(e) }); }
  }
} finally { proc.kill(); }

const kb = (n) => (n / 1024).toFixed(0) + ' KB';
console.log('\n=== QR page CWV / embed-payload probe (mobile 375x812, staging) ===\n');
console.log('page                      | iframes lazy | 1st iframe top vs fold | LCP    | load   | YouTube reqs / bytes | other');
console.log('--------------------------|--------------|------------------------|--------|--------|----------------------|--------');
for (const r of out) {
  if (r.error) { console.log(`${r.name.padEnd(25)} | ERROR ${r.error}`); continue; }
  const fold = r.firstIframeTop === null ? 'no iframe'
    : `${r.firstIframeTop}px vs ${r.viewportH}px ${r.firstIframeTop < r.viewportH ? '→ ABOVE FOLD' : '→ below'}`;
  console.log(
    `${r.name.padEnd(25)} | ${String(r.iframes).padStart(2)} / ${String(r.lazyIframes).padStart(2)} lazy | ${fold.padEnd(22)} | ${String(r.lcp + 'ms').padStart(6)} | ${String(r.load + 'ms').padStart(6)} | ${String(r.ytReq).padStart(3)} / ${kb(r.ytBytes).padStart(8)} | ${kb(r.otherBytes)}`
  );
}
const base = out.find(r => r.videos === 0), one = out.find(r => r.videos === 1), three = out.find(r => r.videos === 3);
console.log('\n=== Deltas vs 0-video baseline (= what a facade would prevent) ===');
for (const r of [one, three]) {
  if (!r || !base || r.error || base.error) continue;
  console.log(`  ${r.name}: +${kb(r.ytBytes)} YouTube payload, +${r.ytReq} requests, LCP ${base.lcp}ms → ${r.lcp}ms (${r.lcp - base.lcp >= 0 ? '+' : ''}${r.lcp - base.lcp}ms)`);
}
console.log('\nYouTube hosts contacted:', [...new Set(out.flatMap(r => r.ytHosts || []))].join(', ') || '(none)');
console.log('\nVERDICT: if YouTube bytes > 0 on a page whose iframe is ABOVE FOLD,');
console.log('         then loading="lazy" is NOT deferring it → a facade would prevent that payload.\n');
console.log(JSON.stringify(out, null, 2));
