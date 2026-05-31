#!/usr/bin/env node
/**
 * HTTP QA runner — axe-core (WCAG 2A/2AA) across the eyalamit staging routes.
 *
 * uPress staging is HTTP-only by design (no public SSL cert — docs/project/EYAL_ENV_VARS_REFERENCE.md §44),
 * so this runner uses http:// and Chrome with --ignore-certificate-errors. It is the reusable S5 a11y gate.
 *
 * Usage:
 *   node scripts/qa/http-qa-axe.cjs                      # default route set, default base
 *   node scripts/qa/http-qa-axe.cjs --base http://host   # override base
 *   node scripts/qa/http-qa-axe.cjs /treatment/ /faq/    # explicit routes (positional)
 *
 * Output: prints a per-route table + writes scripts/qa/reports/axe-http-<date>.json
 * Exit code: 0 if every route has 0 critical AND 0 serious violations (the S5 bar); else 1.
 */
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');
const axeSource = fs.readFileSync(require.resolve('axe-core/axe.min.js'), 'utf8');

const CHROME =
  process.env.EA_CHROME ||
  '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const args = process.argv.slice(2);
let base = 'http://eyalamit-co-il-2026.s887.upress.link';
const routes = [];
for (let i = 0; i < args.length; i++) {
  if (args[i] === '--base') { base = args[++i]; continue; }
  routes.push(args[i]);
}
if (routes.length === 0) {
  routes.push(
    '/', '/treatment/', '/method/', '/sound-healing/', '/lessons/',
    '/about/', '/press/', '/about/moksha/', '/contact/', '/faq/',
    '/books/', '/shop/', '/blog/', '/en/'
  );
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox', '--ignore-certificate-errors', '--allow-running-insecure-content'],
  });

  const results = [];
  for (const route of routes) {
    const url = base.replace(/\/$/, '') + route;
    const row = { route, url, http: null, critical: 0, serious: 0, moderate: 0, minor: 0, violations: [], error: null };
    const page = await browser.newPage();
    try {
      const resp = await page.goto(url, { waitUntil: 'networkidle2', timeout: 90000 });
      row.http = resp ? resp.status() : null;
      await page.evaluate(axeSource);
      const out = await page.evaluate(async () => {
        return await window.axe.run(document, { runOnly: { type: 'tag', values: ['wcag2a', 'wcag2aa'] } });
      });
      for (const v of out.violations) {
        const impact = v.impact || 'minor';
        if (row[impact] !== undefined) row[impact] += v.nodes.length;
        row.violations.push({ id: v.id, impact, help: v.help, nodes: v.nodes.length });
      }
    } catch (e) {
      row.error = String(e.message || e);
    } finally {
      await page.close();
    }
    results.push(row);
    const flag = row.error ? 'ERR' : (row.critical + row.serious === 0 ? 'PASS' : 'FAIL');
    console.log(
      `${flag.padEnd(4)} ${String(row.http || '---').padEnd(4)} ${route.padEnd(20)} ` +
      `crit=${row.critical} serious=${row.serious} mod=${row.moderate} minor=${row.minor}` +
      (row.error ? `  (${row.error})` : '')
    );
  }
  await browser.close();

  const blocking = results.filter(r => r.error || r.critical > 0 || r.serious > 0);
  const reportsDir = path.join(__dirname, 'reports');
  fs.mkdirSync(reportsDir, { recursive: true });
  const stamp = new Date().toISOString().slice(0, 10);
  const outPath = path.join(reportsDir, `axe-http-${stamp}.json`);
  fs.writeFileSync(outPath, JSON.stringify({ base, generated: new Date().toISOString(), results }, null, 2));

  console.log('\n' + '='.repeat(60));
  console.log(`Routes: ${results.length} · clean(0 crit/serious): ${results.length - blocking.length} · blocking: ${blocking.length}`);
  console.log(`Report: ${outPath}`);
  console.log(blocking.length === 0
    ? 'RESULT: PASS — 0 critical / 0 serious across all routes (S5 a11y bar met).'
    : `RESULT: FAIL — ${blocking.length} route(s) with critical/serious violations or errors.`);
  process.exit(blocking.length === 0 ? 0 : 1);
})().catch(e => { console.error('FATAL:', e); process.exit(2); });
