#!/usr/bin/env node
/**
 * WP-S4-05 team_50 — UI-driven wp-admin edit cycle (CDP only).
 * Edits s1_title via ACF metabox input, saves via Update button, verifies front-end.
 */
import { spawn, execSync } from 'node:child_process';
import { readFileSync, writeFileSync } from 'node:fs';
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

async function runCdpUiCycle(base, user, pass) {
  const chrome = findChrome();
  const port = 9600 + Math.floor(Date.now() % 200);
  const proc = spawn(chrome, [
    '--headless', '--disable-gpu', '--no-sandbox',
    `--remote-debugging-port=${port}`,
    '--ignore-certificate-errors',
    '--window-size=1400,2000',
  ], { stdio: 'ignore' });
  await new Promise((r) => setTimeout(r, 1800));

  const result = {
    loginOk: false,
    acfUi: {},
    uiEdit: {},
    uiClear: {},
  };

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
    const evalJs = async (expression) => {
      const r = await send('Runtime.evaluate', { expression, returnByValue: true, awaitPromise: true });
      const v = r.result?.result?.value;
      if (typeof v === 'string' && (v.startsWith('{') || v.startsWith('['))) {
        try { return JSON.parse(v); } catch { return v; }
      }
      return v;
    };

    await new Promise((r) => ws.addEventListener('open', r));
    await send('Page.enable');

    await send('Page.navigate', { url: `${base}/wp-login.php` });
    await new Promise((r) => setTimeout(r, 2500));
    await evalJs(`(() => {
      document.querySelector('#user_login').value = ${JSON.stringify(user)};
      document.querySelector('#user_pass').value = ${JSON.stringify(pass)};
      document.querySelector('#loginform').submit();
      return true;
    })()`);
    await new Promise((r) => setTimeout(r, 4000));
    const loginProbe = await evalJs(`JSON.stringify({ onAdmin: location.href.includes('wp-admin') && !location.href.includes('wp-login'), url: location.href })`);
    result.loginOk = loginProbe.onAdmin;
    if (!result.loginOk) return result;

    await send('Page.navigate', { url: `${base}/wp-admin/post.php?post=${PAGE_ID}&action=edit` });
    await new Promise((r) => setTimeout(r, 5000));

    result.acfUi = await evalJs(`JSON.stringify({
      hasAcfField: !!document.querySelector('.acf-field'),
      hasS1Title: !!document.querySelector('[data-name="${FIELD_NAME}"]'),
      hasFieldKey: !!document.querySelector('[data-key="${FIELD_KEY}"]'),
      acfFieldCount: document.querySelectorAll('.acf-field').length,
      groupVisible: !!document.querySelector('#acf-group_chapters_treatment'),
    })`);

    // Scroll to s1_title and set via UI
    const setUi = await evalJs(`(() => {
      const wrap = document.querySelector('[data-name="${FIELD_NAME}"]');
      if (!wrap) return JSON.stringify({ ok: false, reason: 'no s1_title field' });
      wrap.scrollIntoView({ block: 'center' });
      const input = wrap.querySelector('input[type="text"], textarea');
      if (!input) return JSON.stringify({ ok: false, reason: 'no input in s1_title' });
      input.focus();
      input.value = ${JSON.stringify(TEST_VALUE)};
      input.dispatchEvent(new Event('input', { bubbles: true }));
      input.dispatchEvent(new Event('change', { bubbles: true }));
      if (window.acf && acf.getField) {
        const field = acf.getField(wrap);
        if (field && field.val) field.val(${JSON.stringify(TEST_VALUE)});
      }
      return JSON.stringify({ ok: true, value: input.value });
    })()`);
    result.uiEdit.setField = setUi;

    const capBeforeSave = await send('Page.captureScreenshot', { format: 'png', captureBeyondViewport: true });
    if (capBeforeSave.result?.data) writeFileSync(join(OUT, '03-ui-field-set.png'), Buffer.from(capBeforeSave.result.data, 'base64'));

    const saveUi = await evalJs(`(async () => {
      const tryClassic = () => {
        const btn = document.querySelector('#publish') || document.querySelector('input[name="save"]');
        if (btn) { btn.click(); return { ok: true, method: 'classic', clicked: btn.id || btn.name }; }
        return null;
      };
      const tryGutenberg = () => {
        const btn = document.querySelector('.editor-post-publish-button')
          || document.querySelector('button.editor-post-publish-button__button')
          || Array.from(document.querySelectorAll('button')).find(b => /עדכון|Update|שמור|Save/i.test(b.textContent || ''));
        if (btn) { btn.click(); return { ok: true, method: 'gutenberg-button', clicked: btn.className }; }
        return null;
      };
      const classic = tryClassic();
      if (classic) return JSON.stringify(classic);
      const gut = tryGutenberg();
      if (gut) return JSON.stringify(gut);
      if (window.wp && wp.data && wp.data.dispatch) {
        await wp.data.dispatch('core/editor').savePost();
        return JSON.stringify({ ok: true, method: 'wp.data.savePost' });
      }
      return JSON.stringify({ ok: false, reason: 'no save path' });
    })()`);
    result.uiEdit.saveClick = saveUi;
    await new Promise((r) => setTimeout(r, 8000));

    const capAfterSave = await send('Page.captureScreenshot', { format: 'png', captureBeyondViewport: true });
    if (capAfterSave.result?.data) writeFileSync(join(OUT, '04-after-ui-save.png'), Buffer.from(capAfterSave.result.data, 'base64'));

    result.uiEdit.frontAfterSet = await frontProbe(base);

    // Reload edit screen and clear field via UI
    await send('Page.navigate', { url: `${base}/wp-admin/post.php?post=${PAGE_ID}&action=edit` });
    await new Promise((r) => setTimeout(r, 5000));

    const clearUi = await evalJs(`(() => {
      const wrap = document.querySelector('[data-name="${FIELD_NAME}"]');
      if (!wrap) return JSON.stringify({ ok: false, reason: 'no s1_title on reload' });
      const input = wrap.querySelector('input[type="text"], textarea');
      if (!input) return JSON.stringify({ ok: false, reason: 'no input' });
      input.value = '';
      input.dispatchEvent(new Event('input', { bubbles: true }));
      input.dispatchEvent(new Event('change', { bubbles: true }));
      return JSON.stringify({ ok: true, value: input.value });
    })()`);
    result.uiClear.clearField = clearUi;

    const saveClear = await evalJs(`(async () => {
      const btn = document.querySelector('.editor-post-publish-button')
        || document.querySelector('#publish')
        || document.querySelector('input[name="save"]');
      if (btn) { btn.click(); return JSON.stringify({ ok: true, method: btn.className || btn.id }); }
      if (window.wp && wp.data && wp.data.dispatch) {
        await wp.data.dispatch('core/editor').savePost();
        return JSON.stringify({ ok: true, method: 'wp.data.savePost' });
      }
      return JSON.stringify({ ok: false, reason: 'no save path' });
    })()`);
    result.uiClear.saveClick = saveClear;
    await new Promise((r) => setTimeout(r, 8000));

    result.uiClear.frontAfterClear = await frontProbe(base);

    const capCleanup = await send('Page.captureScreenshot', { format: 'png', captureBeyondViewport: true });
    if (capCleanup.result?.data) writeFileSync(join(OUT, '05-after-cleanup.png'), Buffer.from(capCleanup.result.data, 'base64'));

    ws.close();
  } finally {
    proc.kill('SIGTERM');
  }
  return result;
}

const env = loadEnv();
const BASE = (env.UPRESS_PUBLIC_BASE || 'http://eyalamit-co-il-2026.s887.upress.link').replace(/\/$/, '');
const USER = env.UPRESS_WP_ADMIN_USER;
const PASS = env.UPRESS_WP_ADMIN_PASS;

const out = {
  generatedAt: new Date().toISOString(),
  tester_engine: 'composer-2.5',
  wp: 'WP-S4-05',
  mode: 'ui-driven-cdp',
  page: { id: PAGE_ID, slug: PAGE_SLUG },
  field: { name: FIELD_NAME, key: FIELD_KEY, testValue: TEST_VALUE },
  defaultSnippet: DEFAULT_SNIPPET,
  envKeys: ['UPRESS_WP_ADMIN_USER', 'UPRESS_WP_ADMIN_PASS'],
  userLogin: USER,
};

out.cdpUi = await runCdpUiCycle(BASE, USER, PASS);

const acfUiRendered = out.cdpUi.acfUi?.hasAcfField && out.cdpUi.acfUi?.hasS1Title;
const uiSetOk = out.cdpUi.uiEdit?.setField?.ok === true;
const uiSaveOk = out.cdpUi.uiEdit?.saveClick?.ok === true;
const acEditOk = out.cdpUi.uiEdit?.frontAfterSet?.hasTestValue === true;
const acFallbackOk = out.cdpUi.uiClear?.frontAfterClear?.hasTestValue === false
  && out.cdpUi.uiClear?.frontAfterClear?.hasDefault === true
  && !out.cdpUi.uiClear?.frontAfterClear?.whiteScreen;
const cleanupOk = !out.cdpUi.uiClear?.frontAfterClear?.hasTestValue;

let verdict = 'FAIL';
if (!out.cdpUi.loginOk) verdict = 'BLOCKED';
else if (acfUiRendered && uiSetOk && uiSaveOk && acEditOk && acFallbackOk && cleanupOk) verdict = 'PASS';
else if (!acfUiRendered) verdict = 'FAIL';

out.verdict = verdict;
out.summary = { loginOk: out.cdpUi.loginOk, acfUiRendered, uiSetOk, uiSaveOk, acEditOk, acFallbackOk, cleanupOk };

writeFileSync(join(OUT, 'e2e-ui-results.json'), JSON.stringify(out, null, 2));
console.log(JSON.stringify(out.summary, null, 2));
console.log('verdict:', verdict);
