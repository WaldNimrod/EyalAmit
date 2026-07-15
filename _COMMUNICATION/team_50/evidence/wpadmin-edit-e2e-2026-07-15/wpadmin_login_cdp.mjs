#!/usr/bin/env node
/** CDP capture — wp-login attempt screenshot for team_50 E2E evidence. */
import { spawn, execSync } from 'node:child_process';
import { mkdirSync, writeFileSync } from 'node:fs';
import { readFileSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const __dir = dirname(fileURLToPath(import.meta.url));
const OUT = __dir;

function loadEnv() {
  const envPath = join(__dir, '../../../../local/.env.upress');
  const text = readFileSync(envPath, 'utf8');
  const env = {};
  for (const line of text.split('\n')) {
    const t = line.trim();
    if (!t || t.startsWith('#')) continue;
    const i = t.indexOf('=');
    if (i < 0) continue;
    env[t.slice(0, i)] = t.slice(i + 1);
  }
  return env;
}

function findChrome() {
  try {
    const home = process.env.HOME;
    const out = execSync(
      `find "${home}/.cache/puppeteer" -name chrome-headless-shell -type f 2>/dev/null | sort -V | tail -1`,
      { encoding: 'utf8' }
    ).trim();
    if (out) return out;
  } catch {}
  throw new Error('chrome-headless-shell not found');
}

const env = loadEnv();
const BASE = (env.UPRESS_PUBLIC_BASE || 'http://eyalamit-co-il-2026.s887.upress.link').replace(/\/$/, '');
const USER = env.UPRESS_WP_ADMIN_USER || '';
const PASS = env.UPRESS_WP_ADMIN_PASS || '';
const loginUrl = `${BASE}/wp-login.php`;

const chrome = findChrome();
const port = 9400 + Math.floor(Date.now() % 200);
const proc = spawn(chrome, [
  '--headless', '--disable-gpu', '--no-sandbox',
  `--remote-debugging-port=${port}`,
  '--ignore-certificate-errors',
  '--window-size=1280,900',
], { stdio: 'ignore' });
await new Promise((r) => setTimeout(r, 1800));

const result = { loginUrl, user: USER, loginOk: false, hasAcfOnEdit: false };

try {
  const t = await (await fetch(`http://127.0.0.1:${port}/json/new?about:blank`, { method: 'PUT' })).json();
  const ws = new WebSocket(t.webSocketDebuggerUrl);
  let id = 0;
  const pend = {};
  ws.addEventListener('message', (e) => {
    const m = JSON.parse(e.data);
    if (m.id && pend[m.id]) pend[m.id](m);
  });
  const send = (method, params = {}) => new Promise((res) => {
    const i = ++id;
    pend[i] = res;
    ws.send(JSON.stringify({ id: i, method, params }));
  });
  await new Promise((r) => ws.addEventListener('open', r));
  await send('Page.enable');
  await send('Runtime.enable');
  await send('Page.navigate', { url: loginUrl });
  await new Promise((r) => setTimeout(r, 2500));

  await send('Runtime.evaluate', {
    expression: `(() => {
      const u = document.querySelector('#user_login');
      const p = document.querySelector('#user_pass');
      if (u) u.value = ${JSON.stringify(USER)};
      if (p) p.value = ${JSON.stringify(PASS)};
      const f = document.querySelector('#loginform');
      if (f) f.submit();
      return !!(u && p);
    })()`,
  });
  await new Promise((r) => setTimeout(r, 3500));

  const probe = await send('Runtime.evaluate', {
    expression: `JSON.stringify({
      url: location.href,
      title: document.title,
      loginError: (document.querySelector('#login_error')||{}).innerText || '',
      onAdmin: location.href.includes('wp-admin') && !location.href.includes('wp-login'),
    })`,
    returnByValue: true,
  });
  const v = JSON.parse(probe.result.result.value);
  result.afterLogin = v;
  result.loginOk = v.onAdmin;

  const cap = await send('Page.captureScreenshot', { format: 'png' });
  if (cap.result?.data) {
    writeFileSync(join(OUT, 'wp-login-after-submit.png'), Buffer.from(cap.result.data, 'base64'));
  }

  if (result.loginOk) {
    await send('Page.navigate', { url: `${BASE}/wp-admin/post.php?post=54&action=edit` });
    await new Promise((r) => setTimeout(r, 4000));
    const probe2 = await send('Runtime.evaluate', {
      expression: `JSON.stringify({
        hasAcf: !!document.querySelector('.acf-field'),
        hasS1Title: document.body.innerHTML.includes('s1_title'),
        groupTitle: document.body.innerHTML.includes('group_chapters_treatment') || document.body.innerHTML.includes('פרקים'),
      })`,
      returnByValue: true,
    });
    result.editScreen = JSON.parse(probe2.result.result.value);
    result.hasAcfOnEdit = result.editScreen.hasAcf;
    const cap2 = await send('Page.captureScreenshot', { format: 'png', captureBeyondViewport: true });
    if (cap2.result?.data) {
      writeFileSync(join(OUT, 'wp-edit-screen.png'), Buffer.from(cap2.result.data, 'base64'));
    }
  }

  ws.close();
} finally {
  proc.kill('SIGTERM');
}

writeFileSync(join(OUT, 'cdp-login-result.json'), JSON.stringify(result, null, 2));
console.log(JSON.stringify(result, null, 2));
