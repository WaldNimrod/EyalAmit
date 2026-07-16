#!/usr/bin/env node
/**
 * qr_facade_probe.mjs — WP-S5-06 acceptance harness for the QR click-to-load facade.
 *
 * Promoted from _COMMUNICATION/team_110/evidence/s5-02-facade-cwv/qr_cwv_probe.mjs
 * (WP-S5-06 LOD400 §4.F). It lives HERE, not under evidence/, because Iron Rule #15
 * archives the per-team _COMMUNICATION trees on WP closure — a harness an AC depends
 * on must survive the archive, and WP-S5-05 §7 re-measures CWV with it.
 *
 * What it proves (LOD400 §6):
 *   AC-1  player payload on load  == 0 requests AND 0 bytes  (from ~9 req / ~1061 KB)
 *   AC-1b thumbnail budget        <= 1 req and <= 20 KB per video
 *   AC-3  click loads the REAL nocookie player (and never bare youtube.com)
 *   AC-4  facade count == video count; LCP no worse than +20% vs the §1 baseline
 *
 * Method: headless Chrome over raw CDP (pattern from
 *   _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs). No deps.
 *   Node 22+ (global WebSocket). --ignore-certificate-errors is DEV-ONLY: the
 *   staging cert is expired BY DESIGN on the uPress dev host (not a finding).
 *
 * Usage:
 *   node scripts/qa/qr_facade_probe.mjs [--base https://host] [--json]
 * Exit: 0 if every AC assertion passes, 1 otherwise.
 */
import { spawn, execSync } from 'node:child_process';

/**
 * 🔴 MEASUREMENT VALIDITY — do not "modernise" this to prefer full Chrome.
 *
 * A YouTube embed is cross-origin. Under Chrome's site isolation it renders in an
 * OUT-OF-PROCESS iframe (OOPIF), and the page target's CDP Network domain then sees
 * NONE of its requests. Measured live 2026-07-16 on the pre-facade staging build:
 *   chrome-headless-shell (no site isolation) : /qr/qr2/ = 9 req / 1060 KB   ← matches LOD400 §1
 *   full Google Chrome    (site isolation on) : /qr/qr2/ = 1 req /    0 KB   ← BLIND
 * Using full Chrome would make AC-1 ("player == 0 req / 0 bytes") pass trivially
 * whether or not the facade works — a FALSE PASS on the WP's whole point.
 *
 * So: prefer chrome-headless-shell (the binary that produced the ratified §1 baseline),
 * and if a full Chrome must be used, force iframes back in-process via
 * --disable-features=IsolateOrigins,site-per-process (applied below).
 * EA_CHROME is honoured LAST, as an explicit operator override only.
 *
 * The click phase (AC-3) doubles as the instrument check: if the probe cannot see the
 * player even after the click, playerReq stays 0 and AC-3 FAILs — a blind instrument
 * can never be mistaken for a pass.
 */
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
  if (process.env.EA_CHROME) return process.env.EA_CHROME;
  throw new Error('No Chrome binary found');
}

const argv = process.argv.slice(2);
const baseIdx = argv.indexOf('--base');
const BASE = baseIdx !== -1 ? argv[baseIdx + 1] : 'https://eyalamit-co-il-2026.s887.upress.link';
const JSON_ONLY = argv.includes('--json');

// LOD400 §1 measured baseline (pre-facade), used for the AC-4 LCP regression band.
const PAGES = [
  { name: 'qr48 (0 videos — baseline)', path: '/qr/qr48/', videos: 0, baseLcp: 1688 },
  { name: 'qr1  (0 videos — control)',  path: '/qr/qr1/',  videos: 0, baseLcp: null },
  { name: 'qr2  (1 video)',             path: '/qr/qr2/',  videos: 1, baseLcp: 1108 },
  { name: 'qr10 (3 videos)',            path: '/qr/qr10/', videos: 3, baseLcp: 1532 },
];

// SPLIT HOSTS (LOD400 §4.F item 1 + §8 correction #2). The original probe counted
// ytimg.com inside ytBytes, which makes an "0 bytes" AC impossible once posters exist.
// Player = the ~1 MB we are eliminating. MUST be 0 on load.
const YT_PLAYER = /(^|\.)(youtube\.com|youtube-nocookie\.com|googlevideo\.com)/i;
// Thumbnail CDN = accepted for v1 (LOD400 §5.1). Budgeted, not forbidden.
const YT_THUMB  = /(^|\.)ytimg\.com/i;
// Privacy regression guard (§5.2): bare youtube.com must never be contacted.
const YT_BARE   = /(^|\.)youtube\.com$/i;

const hostOf = (u) => { try { return new URL(u).host; } catch { return ''; } };
const SETTLE_MS = 9000;
const CLICK_WAIT_MS = 6000;

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
  const reqs = new Map();   // requestId -> {url}
  const bytes = new Map();  // requestId -> encodedDataLength

  ws.addEventListener('message', (e) => {
    const m = JSON.parse(e.data);
    if (m.id && pend[m.id]) { pend[m.id](m); return; }
    if (m.method === 'Network.requestWillBeSent') {
      reqs.set(m.params.requestId, { url: m.params.request.url });
    } else if (m.method === 'Network.loadingFinished') {
      bytes.set(m.params.requestId, m.params.encodedDataLength || 0);
    }
  });
  await new Promise(r => ws.addEventListener('open', r));
  const send = (method, params = {}) => new Promise(res => { const i = ++id; pend[i] = res; ws.send(JSON.stringify({ id: i, method, params })); });

  await send('Page.enable'); await send('Runtime.enable'); await send('Network.enable');
  // Cold cache per page — otherwise page 2/3 reuses page 1's player JS and the
  // byte count collapses into a meaningless number.
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
      facades: document.querySelectorAll('.ea-qr-facade').length,
      thumbs: document.querySelectorAll('.ea-qr-facade__thumb').length,
      facadeScriptLoaded: !!document.querySelector('script[src*="ea-qr-facade.js"]')
    })`, returnByValue: true,
  });
  const v = JSON.parse(ev.result.result.value);

  const tally = (filterFn) => {
    let req = 0, b = 0; const hosts = new Set();
    for (const [rid, r] of reqs) {
      if (!filterFn(r.url)) continue;
      req++; b += bytes.get(rid) || 0; hosts.add(hostOf(r.url));
    }
    return { req, bytes: b, hosts: [...hosts] };
  };
  const onLoad = {
    player: tally(u => YT_PLAYER.test(hostOf(u))),
    thumb:  tally(u => YT_THUMB.test(hostOf(u))),
    bare:   tally(u => YT_BARE.test(hostOf(u))),
  };

  // ── Phase 2: the click (AC-3). Only meaningful where a facade exists.
  let afterClick = null;
  if (v.facades > 0) {
    const before = reqs.size;
    await send('Runtime.evaluate', {
      expression: `(() => { const b = document.querySelector('.ea-qr-facade'); if (b) { b.click(); return true; } return false; })()`,
      returnByValue: true,
    });
    await new Promise(r => setTimeout(r, CLICK_WAIT_MS));
    let pReq = 0, pBytes = 0; const pHosts = new Set(); let i = 0;
    for (const [rid, r] of reqs) {
      if (i++ < before) continue;                       // only post-click traffic
      if (!YT_PLAYER.test(hostOf(r.url))) continue;
      pReq++; pBytes += bytes.get(rid) || 0; pHosts.add(hostOf(r.url));
    }
    const ev2 = await send('Runtime.evaluate', {
      expression: `JSON.stringify({
        facadesLeft: document.querySelectorAll('.ea-qr-facade').length,
        iframes: document.querySelectorAll('iframe').length,
        nocookieIframes: document.querySelectorAll('iframe[src*="youtube-nocookie.com"]').length
      })`, returnByValue: true,
    });
    afterClick = { playerReq: pReq, playerBytes: pBytes, playerHosts: [...pHosts], ...JSON.parse(ev2.result.result.value) };
  }

  ws.close(); await fetch(`http://127.0.0.1:${chromePort}/json/close/${t.id}`).catch(() => {});
  return { ...pg, ...v, onLoad, afterClick };
}

const chrome = findChrome();
const port = 9400 + Math.floor(Math.random() * 400);
const proc = spawn(chrome, ['--headless', '--disable-gpu', '--no-sandbox',
  `--remote-debugging-port=${port}`, '--ignore-certificate-errors', '--hide-scrollbars',
  // Keep cross-origin iframes IN-process so their network traffic is visible to the
  // page target's CDP Network domain. Without this, a full Chrome measures the player
  // as 0 requests whether or not the facade works — see findChrome()'s note.
  '--disable-features=IsolateOrigins,site-per-process',
  ], { stdio: 'ignore' });
process.stderr.write(`chrome: ${chrome}\n`);
await new Promise(r => setTimeout(r, 2000));

const out = [];
try {
  for (const pg of PAGES) {
    process.stderr.write(`probing ${pg.path} ...\n`);
    try { out.push(await probe(port, pg)); }
    catch (e) { out.push({ ...pg, error: String(e) }); }
  }
} finally { proc.kill(); }

// ── AC assertions ───────────────────────────────────────────────────────────
const THUMB_BUDGET = 20480; // 20 KB per video (LOD400 AC-1b)
const fails = [];
const note = [];
for (const r of out) {
  if (r.error) { fails.push(`${r.path}: probe error ${r.error}`); continue; }

  // AC-1 — zero player on load. Absolute, on every page.
  if (r.onLoad.player.req !== 0 || r.onLoad.player.bytes !== 0) {
    fails.push(`AC-1 ${r.path}: player on load = ${r.onLoad.player.req} req / ${r.onLoad.player.bytes} B (must be 0/0) hosts=${r.onLoad.player.hosts.join(',')}`);
  }
  // AC-1b — thumbnail budget.
  if (r.onLoad.thumb.req > r.videos) fails.push(`AC-1b ${r.path}: thumbReq ${r.onLoad.thumb.req} > videoCount ${r.videos}`);
  if (r.onLoad.thumb.bytes > THUMB_BUDGET * r.videos) fails.push(`AC-1b ${r.path}: thumbBytes ${r.onLoad.thumb.bytes} > ${THUMB_BUDGET * r.videos}`);
  // §5.2 — bare youtube.com is a privacy regression even if it "works".
  if (r.onLoad.bare.req > 0) fails.push(`§5.2 ${r.path}: ${r.onLoad.bare.req} request(s) to bare youtube.com`);
  // AC-4 — facade count must equal video count.
  if (r.facades !== r.videos) fails.push(`AC-4 ${r.path}: facades ${r.facades} != videoCount ${r.videos}`);
  // AC-4 — LCP regression band (wide by design; LCP is noisy, §1).
  if (r.baseLcp && r.lcp > r.baseLcp * 1.2) {
    note.push(`AC-4 ${r.path}: LCP ${r.lcp}ms vs baseline ${r.baseLcp}ms (>+20%) — re-run before calling it a regression (§1: LCP is noisy)`);
  }
  // AC-3 — the click must load the real nocookie player.
  if (r.videos > 0) {
    if (!r.afterClick) fails.push(`AC-3 ${r.path}: no facade to click`);
    else {
      if (r.afterClick.playerReq <= 0) fails.push(`AC-3 ${r.path}: click produced ${r.afterClick.playerReq} player requests (must be > 0)`);
      if (!r.afterClick.playerHosts.some(h => /youtube-nocookie\.com$/i.test(h))) {
        fails.push(`AC-3 ${r.path}: www.youtube-nocookie.com not observed after click (hosts=${r.afterClick.playerHosts.join(',') || 'none'})`);
      }
      if (r.afterClick.nocookieIframes < 1) fails.push(`AC-3 ${r.path}: no nocookie iframe replaced the button`);
    }
  }
}

if (!JSON_ONLY) {
  const kb = (n) => (n / 1024).toFixed(1) + ' KB';
  console.log('\n=== WP-S5-06 QR facade probe (mobile 375x812, cold cache, staging) ===\n');
  console.log('page                      | vids | facades | PLAYER on load | THUMBS on load  | LCP    | click -> player');
  console.log('--------------------------|------|---------|----------------|-----------------|--------|------------------');
  for (const r of out) {
    if (r.error) { console.log(`${r.name.padEnd(25)} | ERROR ${r.error}`); continue; }
    const click = r.afterClick ? `${r.afterClick.playerReq} req / ${kb(r.afterClick.playerBytes)}` : '(no facade)';
    console.log(
      `${r.name.padEnd(25)} | ${String(r.videos).padStart(4)} | ${String(r.facades).padStart(7)} | ${String(r.onLoad.player.req).padStart(3)} req / ${kb(r.onLoad.player.bytes).padStart(7)} | ${String(r.onLoad.thumb.req).padStart(2)} req / ${kb(r.onLoad.thumb.bytes).padStart(7)} | ${String(r.lcp + 'ms').padStart(6)} | ${click}`
    );
  }
  console.log('\n--- AC verdict ---');
  for (const n of note) console.log('  NOTE  ' + n);
  if (fails.length === 0) console.log('  PASS  AC-1 (player 0/0) · AC-1b (thumb budget) · AC-3 (click) · AC-4 (facade counts)');
  else for (const f of fails) console.log('  FAIL  ' + f);
  console.log('');
}
console.log(JSON.stringify({ base: BASE, generated_by: 'scripts/qa/qr_facade_probe.mjs', pass: fails.length === 0, fails, note, pages: out }, null, 2));
process.exit(fails.length === 0 ? 0 : 1);
