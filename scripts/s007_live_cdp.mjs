#!/usr/bin/env node
/**
 * CDP spot-check for closed S007 SSOT rows. GET-no-follow is the census;
 * this confirms rendered home/thank-you/didgeridoos/faq/legal.
 * Chrome --ignore-certificate-errors is DEV-ONLY (staging TLS invalid by design).
 */
import { spawn, execSync } from 'node:child_process';

const BASE = 'http://eyalamit-co-il-2026.s887.upress.link';
const UA = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';

function findChrome() {
  const p = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
  execSync(`test -x "${p}"`);
  return p;
}

async function evalPage(port, path, expression) {
  const url = BASE + path + '?nc=' + Date.now();
  const t = await (await fetch(`http://127.0.0.1:${port}/json/new?about:blank`, { method: 'PUT' })).json();
  const ws = new WebSocket(t.webSocketDebuggerUrl);
  let id = 0; const pend = {};
  ws.addEventListener('message', (e) => {
    const m = JSON.parse(e.data);
    if (m.id && pend[m.id]) pend[m.id](m);
  });
  await new Promise((r) => ws.addEventListener('open', r));
  const send = (method, params = {}) => new Promise((res) => {
    const i = ++id; pend[i] = res; ws.send(JSON.stringify({ id: i, method, params }));
  });
  await send('Page.enable');
  await send('Runtime.enable');
  await send('Network.setUserAgentOverride', { userAgent: UA });
  await send('Emulation.setDeviceMetricsOverride', { width: 1280, height: 800, deviceScaleFactor: 1, mobile: false });
  await send('Page.navigate', { url });
  await new Promise((r) => setTimeout(r, 4500));
  const ev = await send('Runtime.evaluate', { expression, returnByValue: true });
  ws.close();
  await fetch(`http://127.0.0.1:${port}/json/close/${t.id}`).catch(() => {});
  const v = ev?.result?.result?.value;
  return typeof v === 'string' ? JSON.parse(v) : v;
}

const PAGES = [
  {
    id: 'B1',
    path: '/',
    expr: `JSON.stringify({
      yt: !!document.querySelector('iframe[src*="youtube.com/embed/wDQoJauqsRM"]'),
      lorem: /Lorem ipsum/.test(document.body.innerText),
      astmaBad: document.body.innerText.includes('אסטמה'),
      astmaOk: document.body.innerText.includes('אסתמה'),
      cookie: !!document.getElementById('ea-cookie-notice')
    })`,
    ok: (v) => v.yt && !v.lorem,
  },
  {
    id: 'A4',
    path: '/thank-you/',
    expr: `JSON.stringify({
      t1: document.body.innerText.includes('תודה שפנית אליי'),
      t2: document.body.innerText.includes('הפרטים התקבלו ואחזור אליך בהקדם')
    })`,
    ok: (v) => v.t1 && v.t2,
  },
  {
    id: 'D1',
    path: '/didgeridoos/',
    expr: `JSON.stringify({
      testi: !!document.querySelector('.ea-testimonials, .testimonials, [data-ea-testimonials]'),
      allCta: document.body.innerText.includes('כל העדויות')
    })`,
    ok: (v) => !v.testi && !v.allCta,
  },
  {
    id: 'D3',
    path: '/faq/',
    expr: `JSON.stringify({
      href: !!document.querySelector('a[href*="/learning/therapist-training/"]'),
      old: !!document.querySelector('a[href*="cbDidg-therapy-training"]')
    })`,
    ok: (v) => v.href && !v.old,
  },
  {
    id: 'L1',
    path: '/accessibility/',
    expr: `JSON.stringify({
      pending: !!document.querySelector('.ea-pending-note') || document.body.innerText.includes('טיוטה לאישור')
    })`,
    ok: (v) => !v.pending,
  },
];

const chrome = findChrome();
const port = 9410 + Math.floor(Math.random() * 80);
const proc = spawn(chrome, [
  '--headless=new', '--disable-gpu', '--no-sandbox',
  `--remote-debugging-port=${port}`,
  '--ignore-certificate-errors',
  '--hide-scrollbars',
], { stdio: 'ignore' });

await new Promise((r) => setTimeout(r, 1800));
const out = [];
let fail = 0;
try {
  for (const pg of PAGES) {
    try {
      const v = await evalPage(port, pg.path, pg.expr);
      const pass = pg.ok(v);
      if (!pass) fail++;
      out.push({ id: pg.id, path: pg.path, pass, v });
      console.error(`${pass ? 'PASS' : 'FAIL'} CDP ${pg.id} ${JSON.stringify(v)}`);
    } catch (e) {
      fail++;
      out.push({ id: pg.id, path: pg.path, pass: false, error: String(e) });
      console.error(`FAIL CDP ${pg.id} ${e}`);
    }
  }
} finally {
  proc.kill();
}

console.log(JSON.stringify({ pass: fail === 0, fail, pages: out }, null, 2));
process.exit(fail === 0 ? 0 : 1);
