#!/usr/bin/env node
/**
 * WP-S4-05 team_50 — full wp-admin editability E2E (CDP + form POST corroboration).
 * Does NOT log secrets. Writes JSON + screenshots to evidence dir.
 */
import { spawn, execSync } from 'node:child_process';
import { readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const __dir = dirname(fileURLToPath(import.meta.url));
const OUT = __dir;
const PAGE_ID = 54;
const PAGE_SLUG = 'treatment';
const FIELD_NAME = 's1_title';
const FIELD_KEY = 'f_treatment_s1_title';
const TEST_VALUE = '__E2E_EDIT_2026-07-15__';
const DEFAULT_SNIPPET = 'משהו בנשימה שלך מבקש תשומת לב';

function loadEnv() {
  const text = readFileSync(join(__dir, '../../../../local/.env.upress'), 'utf8');
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
  const home = process.env.HOME;
  const out = execSync(
    `find "${home}/.cache/puppeteer" -name chrome-headless-shell -type f 2>/dev/null | sort -V | tail -1`,
    { encoding: 'utf8' }
  ).trim();
  if (!out) throw new Error('chrome-headless-shell not found');
  return out;
}

async function frontProbe(base) {
  const url = `${base}/${PAGE_SLUG}/?nc=${Date.now()}`;
  const r = await fetch(url);
  const body = await r.text();
  return {
    url,
    status: r.status,
    hasTestValue: body.includes(TEST_VALUE),
    hasDefault: body.includes(DEFAULT_SNIPPET),
    bodyLen: body.length,
    whiteScreen: body.length < 500,
  };
}

async function cdpProbe(base, user, pass) {
  const chrome = findChrome();
  const port = 9500 + Math.floor(Date.now() % 200);
  const proc = spawn(chrome, [
    '--headless', '--disable-gpu', '--no-sandbox',
    `--remote-debugging-port=${port}`,
    '--ignore-certificate-errors',
    '--window-size=1400,1200',
  ], { stdio: 'ignore' });
  await new Promise((r) => setTimeout(r, 1800));

  const result = { loginOk: false, acfUi: { hasAcfField: false, hasS1Title: false, hasGroupTitle: false, waitedMs: 0 } };

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

    await send('Page.navigate', { url: `${base}/wp-login.php` });
    await new Promise((r) => setTimeout(r, 2500));
    await send('Runtime.evaluate', {
      expression: `(() => {
        document.querySelector('#user_login').value = ${JSON.stringify(user)};
        document.querySelector('#user_pass').value = ${JSON.stringify(pass)};
        document.querySelector('#loginform').submit();
        return true;
      })()`,
    });
    await new Promise((r) => setTimeout(r, 4000));
    const loginProbe = await send('Runtime.evaluate', {
      expression: `JSON.stringify({ onAdmin: location.href.includes('wp-admin') && !location.href.includes('wp-login'), url: location.href })`,
      returnByValue: true,
    });
    result.loginOk = JSON.parse(loginProbe.result.result.value).onAdmin;

    const capLogin = await send('Page.captureScreenshot', { format: 'png' });
    if (capLogin.result?.data) writeFileSync(join(OUT, '01-after-login.png'), Buffer.from(capLogin.result.data, 'base64'));

    if (!result.loginOk) return result;

    await send('Page.navigate', { url: `${base}/wp-admin/post.php?post=${PAGE_ID}&action=edit` });
    const maxWait = 45000;
    const step = 3000;
    let waited = 0;
    while (waited <= maxWait) {
      await new Promise((r) => setTimeout(r, step));
      waited += step;
      const probe = await send('Runtime.evaluate', {
        expression: `JSON.stringify({
          hasAcfField: !!document.querySelector('.acf-field'),
          hasS1Title: !!document.querySelector('[data-name="s1_title"]'),
          hasFieldKey: !!document.querySelector('[data-key="f_treatment_s1_title"]'),
          hasGroupTitle: document.body.innerText.includes('פרקים — treatment') || document.body.innerText.includes('פרקים —'),
          acfFieldCount: document.querySelectorAll('.acf-field').length,
        })`,
        returnByValue: true,
      });
      const v = JSON.parse(probe.result.result.value);
      result.acfUi = { ...v, waitedMs: waited };
      if (v.hasAcfField || v.hasS1Title || v.hasFieldKey) break;
    }

    const capEdit = await send('Page.captureScreenshot', { format: 'png', captureBeyondViewport: true });
    if (capEdit.result?.data) writeFileSync(join(OUT, '02-edit-screen.png'), Buffer.from(capEdit.result.data, 'base64'));

    ws.close();
  } finally {
    proc.kill('SIGTERM');
  }
  return result;
}

async function wpAdminSaveCycle(base, user, pass) {
  const jar = {};
  const store = (res) => {
    const sc = res.headers.getSetCookie?.() || [];
    for (const c of sc) {
      const [kv] = c.split(';');
      const [k, v] = kv.split('=');
      jar[k] = v;
    }
  };
  const cookieHeader = () => Object.entries(jar).map(([k, v]) => `${k}=${v}`).join('; ');

  const loginRes = await fetch(`${base}/wp-login.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded', Cookie: 'wordpress_test_cookie=WP+Cookie+check' },
    body: new URLSearchParams({
      log: user, pwd: pass, 'wp-submit': 'Log In',
      redirect_to: `${base}/wp-admin/`, testcookie: '1',
    }),
    redirect: 'manual',
  });
  store(loginRes);

  const editRes = await fetch(`${base}/wp-admin/post.php?post=${PAGE_ID}&action=edit`, {
    headers: { Cookie: cookieHeader() },
  });
  store(editRes);
  const html = await editRes.text();
  writeFileSync(join(OUT, 'edit-screen-fetch.html'), html.slice(0, 500000));

  const grab = (name) => {
    const m = html.match(new RegExp(`(?:name|id)="${name}"[^>]*value="([^"]+)"`));
    return m?.[1] || null;
  };
  const wpnonce = grab('_wpnonce');
  const acfNonce = grab('_acf_nonce');
  const acfDataMatch = html.match(/acf\.data\s*=\s*(\{[\s\S]*?\});/);
  const hasAcfDataGroup = html.includes('group_chapters_treatment') || html.includes(FIELD_KEY);

  async function savePost(fieldValue) {
    const body = new URLSearchParams({
      post_ID: String(PAGE_ID),
      post_type: 'page',
      originalaction: 'editpost',
      action: 'editpost',
      post_status: 'publish',
      comment_status: 'closed',
      ping_status: 'closed',
      _wpnonce: wpnonce,
      _acf_screen: 'post',
      _acf_post_id: String(PAGE_ID),
      _acf_validation: '1',
      _acf_nonce: acfNonce,
      _acf_changed: '1',
      post_title: "טיפול בדיג'רידו",
      content: '',
      [`acf[${FIELD_KEY}]`]: fieldValue,
    });
    const r = await fetch(`${base}/wp-admin/post.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded', Cookie: cookieHeader() },
      body,
      redirect: 'manual',
    });
    store(r);
    return { status: r.status, location: r.headers.get('location') };
  }

  const baseline = await frontProbe(base);
  const setRes = await savePost(TEST_VALUE);
  await new Promise((r) => setTimeout(r, 2000));
  const afterSet = await frontProbe(base);
  const clearRes = await savePost('');
  await new Promise((r) => setTimeout(r, 2000));
  const afterClear = await frontProbe(base);

  return {
    nonces: { wpnonce: !!wpnonce, acfNonce: !!acfNonce },
    acfJsConfigHasGroup: hasAcfDataGroup,
    acfDataSnippet: acfDataMatch ? acfDataMatch[1].slice(0, 500) : null,
    baseline,
    acEdit: { save: setRes, front: afterSet, pass: afterSet.hasTestValue },
    acFallback: { save: clearRes, front: afterClear, pass: !afterClear.hasTestValue && afterClear.hasDefault && !afterClear.whiteScreen },
    cleanup: { pass: !afterClear.hasTestValue, front: afterClear },
  };
}

const env = loadEnv();
const BASE = (env.UPRESS_PUBLIC_BASE || 'http://eyalamit-co-il-2026.s887.upress.link').replace(/\/$/, '');
const USER = env.UPRESS_WP_ADMIN_USER;
const PASS = env.UPRESS_WP_ADMIN_PASS;

const out = {
  generatedAt: new Date().toISOString(),
  tester_engine: 'composer-2.5',
  wp: 'WP-S4-05',
  page: { id: PAGE_ID, slug: PAGE_SLUG },
  field: { name: FIELD_NAME, key: FIELD_KEY, testValue: TEST_VALUE },
  defaultSnippet: DEFAULT_SNIPPET,
  envKeys: ['UPRESS_WP_ADMIN_USER', 'UPRESS_WP_ADMIN_PASS'],
  userLogin: USER,
};

out.cdp = await cdpProbe(BASE, USER, PASS);
out.wpAdminSave = await wpAdminSaveCycle(BASE, USER, PASS);

const acfUiRendered = out.cdp.acfUi?.hasAcfField || out.cdp.acfUi?.hasS1Title || out.cdp.acfUi?.hasFieldKey;
const acEditOk = out.wpAdminSave.acEdit.pass;
const acFallbackOk = out.wpAdminSave.acFallback.pass;
const cleanupOk = out.wpAdminSave.cleanup.pass;
const loginOk = out.cdp.loginOk;

let verdict = 'FAIL';
if (!loginOk) verdict = 'BLOCKED';
else if (acfUiRendered && acEditOk && acFallbackOk && cleanupOk) verdict = 'PASS';
else if (!acfUiRendered && acEditOk && acFallbackOk && cleanupOk) verdict = 'FAIL'; // render path works, UI missing
else if (!acEditOk) verdict = 'FAIL';

out.verdict = verdict;
out.summary = { loginOk, acfUiRendered, acEditOk, acFallbackOk, cleanupOk };

writeFileSync(join(OUT, 'e2e-full-results.json'), JSON.stringify(out, null, 2));
console.log(JSON.stringify(out.summary, null, 2));
console.log('verdict:', verdict);
