#!/usr/bin/env node
/**
 * CONTENT-ACCURACY self-check (WP-W2-15 CR program) — WP-free local proxy for
 * the authoritative live gate in content-diff.mjs.
 *
 * WHY: content-diff.mjs fetches the deployed staging URL. A page sub-agent
 * working in an isolated worktree cannot run WordPress, so it cannot measure
 * its render before deploy. This tool extracts the *content text* a PHP render
 * file emits — both inline-HTML regions (outside `<?php ... ?>`) AND PHP string
 * literals (data arrays / concatenated HTML), excluding PHP code and comments —
 * and runs it through content-diff's EXACT `analyzePage`. Because the gate is a
 * verbatim-substring presence test of Eyal's source sentences, the extracted
 * literal/HTML text is a faithful predictor of the live result for these pages.
 *
 * Faithful for: section coverage + sentence coverage (the PASS bar).
 * Proxy only for: invented-section detection (authoritative on real <main> HTML
 *   at the team_100 live pre-flight). A clean self-check here does NOT waive the
 *   live content-diff run after deploy — it just lets a sub-agent iterate to PASS.
 *
 * Usage:
 *   node scripts/qa/content-selfcheck.mjs --page /muzza/ --php inc/wave2-w2-05.php [--php more.php ...]
 *   node scripts/qa/content-selfcheck.mjs --page / --php inc/wave2-stage-b.php --php template-parts/blocks/block-x.php
 *
 * Exit code 0 on gatePass, 1 otherwise (so a build agent can loop until PASS).
 */
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import {
  PAGE_MAP,
  DEFAULT_CONTENT_ROOT,
  readSource,
  parseMarkdownSource,
  parseDocxSections,
  normalize,
  analyzePage,
} from './content-diff.mjs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const REPO_ROOT = path.resolve(__dirname, '../..');

function parseArgs(argv) {
  const opts = { page: null, php: [], contentRoot: DEFAULT_CONTENT_ROOT, json: false };
  for (let i = 2; i < argv.length; i++) {
    if (argv[i] === '--page') opts.page = argv[++i];
    else if (argv[i] === '--php') opts.php.push(argv[++i]);
    else if (argv[i] === '--content-root') opts.contentRoot = argv[++i];
    else if (argv[i] === '--json') opts.json = true;
  }
  return opts;
}

/**
 * Extract the content TEXT a PHP file emits: inline-HTML regions (template
 * mode, outside `<?php ... ?>`) plus PHP string-literal bodies (single/double
 * quoted + heredoc/nowdoc). PHP code, line/block comments, and variable
 * expressions are dropped. Returns one concatenated string (HTML-ish).
 */
function extractPhpEmittedText(src) {
  const out = [];
  const n = src.length;
  let i = 0;
  // PHP files start in HTML (template) mode.
  let mode = 'HTML';

  function pushUnescaped(body, quote) {
    let s = body;
    if (quote === "'") {
      s = s.replace(/\\(['\\])/g, '$1');
    } else if (quote === '"') {
      s = s
        .replace(/\\n/g, ' ')
        .replace(/\\t/g, ' ')
        .replace(/\\r/g, ' ')
        .replace(/\\(["\\$])/g, '$1');
    }
    out.push(s);
  }

  while (i < n) {
    if (mode === 'HTML') {
      const open = src.indexOf('<?', i);
      if (open === -1) {
        out.push(src.slice(i));
        break;
      }
      out.push(src.slice(i, open));
      // Determine open tag length: <?php , <?= , <?
      if (src.startsWith('<?php', open)) i = open + 5;
      else if (src.startsWith('<?=', open)) i = open + 3;
      else i = open + 2;
      mode = 'PHP';
      continue;
    }

    // mode === 'PHP'
    const ch = src[i];
    const two = src.substr(i, 2);

    if (two === '?>') {
      i += 2;
      mode = 'HTML';
      continue;
    }
    if (two === '//') {
      const nl = src.indexOf('\n', i);
      // a line comment also ends at a ?> on the same line
      const close = src.indexOf('?>', i);
      let end = nl === -1 ? n : nl;
      if (close !== -1 && close < end) end = close;
      i = end;
      continue;
    }
    if (ch === '#' && two !== '#[') {
      const nl = src.indexOf('\n', i);
      const close = src.indexOf('?>', i);
      let end = nl === -1 ? n : nl;
      if (close !== -1 && close < end) end = close;
      i = end;
      continue;
    }
    if (two === '/*') {
      const end = src.indexOf('*/', i + 2);
      i = end === -1 ? n : end + 2;
      continue;
    }
    if (ch === "'" || ch === '"') {
      const quote = ch;
      let j = i + 1;
      let body = '';
      while (j < n) {
        if (src[j] === '\\') {
          body += src[j] + (src[j + 1] ?? '');
          j += 2;
          continue;
        }
        if (src[j] === quote) break;
        body += src[j];
        j += 1;
      }
      pushUnescaped(body, quote);
      i = j + 1;
      continue;
    }
    if (src.startsWith('<<<', i)) {
      // heredoc / nowdoc
      let k = i + 3;
      while (k < n && /[ \t]/.test(src[k])) k += 1;
      let nowdoc = false;
      let q = '';
      if (src[k] === "'" || src[k] === '"') {
        nowdoc = src[k] === "'";
        q = src[k];
        k += 1;
      }
      let label = '';
      while (k < n && /[A-Za-z0-9_]/.test(src[k])) {
        label += src[k];
        k += 1;
      }
      if (q && src[k] === q) k += 1;
      // skip to end of line
      const bodyStart = src.indexOf('\n', k);
      if (!label || bodyStart === -1) {
        i = k;
        continue;
      }
      // find closing label line (PHP 7.3+ allows indentation)
      const closeRe = new RegExp('^[ \\t]*' + label + '\\b', 'm');
      const rest = src.slice(bodyStart + 1);
      const m = closeRe.exec(rest);
      const body = m ? rest.slice(0, m.index) : rest;
      pushUnescaped(body.replace(/\n[ \t]*$/, ''), nowdoc ? "'" : '"');
      i = m ? bodyStart + 1 + m.index + m[0].length : n;
      continue;
    }
    i += 1;
  }
  return out.join(' ');
}

async function main() {
  const opts = parseArgs(process.argv);
  if (!opts.page || opts.php.length === 0) {
    console.error(
      'Usage: node scripts/qa/content-selfcheck.mjs --page <path> --php <file> [--php <file> ...]'
    );
    process.exit(2);
  }

  const entry =
    PAGE_MAP.find((p) => p.path === opts.page) ||
    PAGE_MAP.find((p) => p.label === opts.page);
  if (!entry) {
    console.error(`No PAGE_MAP entry for page "${opts.page}". Known paths:`);
    console.error(PAGE_MAP.map((p) => `  ${p.path}${p.label ? ` (${p.label})` : ''}`).join('\n'));
    process.exit(2);
  }
  if (entry.na || !entry.source) {
    console.error(`Page ${opts.page} has no Eyal source (na) — nothing to self-check.`);
    process.exit(2);
  }

  // Concatenate emitted text from all provided render files.
  let emitted = '';
  for (const rel of opts.php) {
    const full = path.isAbsolute(rel) ? rel : path.join(REPO_ROOT, rel);
    if (!fs.existsSync(full)) {
      console.error(`PHP file not found: ${full}`);
      process.exit(2);
    }
    emitted += '\n' + extractPhpEmittedText(fs.readFileSync(full, 'utf8'));
  }

  const src = await readSource(entry.source, entry.sourceType, opts.contentRoot);
  if (src.error || !src.text) {
    console.error(`Source error: ${src.error}`);
    process.exit(2);
  }
  const sections =
    src.format === 'docx' ? parseDocxSections(src.text) : parseMarkdownSource(src.text);

  const live = { text: normalize(emitted) };
  const analysis = analyzePage({ sections, live, htmlMain: emitted });

  const report = {
    page: opts.page,
    source: entry.source,
    phpFiles: opts.php,
    mode: 'LOCAL_SELFCHECK (proxy for live content-diff)',
    sectionCoveragePct: analysis.sectionCoveragePct,
    sentenceCoveragePct: analysis.sentenceCoveragePct,
    pageAccuracyPct: analysis.pageAccuracyPct,
    sectionsFound: analysis.sectionsFound,
    sectionsTotal: analysis.sectionsTotal,
    sentencesFound: analysis.sentencesFound,
    sentencesTotal: analysis.sentencesTotal,
    missingSections: analysis.missingSections,
    missingSentences: analysis.missingSentences,
    inventedSections_proxy: analysis.inventedSections,
    gatePass: analysis.gatePass,
  };

  if (opts.json) {
    console.log(JSON.stringify(report, null, 2));
  } else {
    console.log(JSON.stringify(report, null, 2));
    console.log(
      `\n${report.gatePass ? 'PASS' : 'FAIL'} — section ${report.sectionCoveragePct}% (need ≥95) · ` +
        `sentence ${report.sentenceCoveragePct}% (need ≥90) · ` +
        `missing ${report.missingSections.length} sections / ${report.sentencesTotal - report.sentencesFound} sentences`
    );
  }
  process.exit(report.gatePass ? 0 : 1);
}

main().catch((err) => {
  console.error(err);
  process.exit(2);
});
