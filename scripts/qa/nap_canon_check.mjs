#!/usr/bin/env node
/**
 * nap_canon_check.mjs — WP-S5-07 §4.H. The guard that makes the NAP canon enforceable
 * by CODE rather than by document.
 *
 * Without this, DECISION-NAP-CANON-2026-07-16.md is just a document: the NAP was never
 * missing — it sat in a self-declared SSoT (ea-w2-seo-schema.php) that nothing could
 * consume, so every surface hard-coded its own copy and drifted into 6 phone variants
 * and 3 apostrophe variants. That drift is what made WP-S4-07's AC-10 ("NAP byte-identical
 * FAQ <-> footer") unsatisfiable. ea_nap() gives PHP surfaces one source; this script
 * covers what ea_nap() cannot reach — JSON/HTML seeds, which can't call PHP.
 *
 * Fails (exit 1) if any non-canonical variant exists inside the scan scope.
 *
 * 🔴 BOUNDED MATCHING IS MANDATORY. `052-482284` is a SUBSTRING of the canonical
 * `052-4822842`. A naive grep reports ~6 files "with the wrong phone" when there is
 * exactly ONE. team_100 fell for this on its first scan. Every rule below uses
 * lookarounds; do not "simplify" them.
 *
 * Usage: node scripts/qa/nap_canon_check.mjs [--verbose]
 * Exit:  0 = canon clean · 1 = violations found
 */
import { readdirSync, readFileSync, statSync } from 'node:fs';
import { join, relative, sep } from 'node:path';

const ROOT = process.cwd();
const SCAN_DIRS = ['site/wp-content', 'scripts'];
const SKIP_DIRS = new Set(['node_modules', 'reports', '.git']);

// §5.3 — verbatim testimonials. The two numbers in here are EYAL'S OWN phone, quoted
// inside recommendations attributed to real, named people (Navit Tzuf Strauss; Alon
// Garzon Raz). NOTE: the input DECISION's stated reason ("they're the authors' numbers")
// is factually WRONG — but the exclusion is RIGHT, and for a stronger reason: normalising
// a number inside a quotation changes what a real person actually wrote. Do not touch.
const EXCLUDE_FILES = new Set([
  'site/wp-content/themes/ea-eyalamit/inc/data/ea-testimonials-fb.json',
]);
// Legacy WXR export — a frozen historical dump, not a live surface.
const EXCLUDE_PREFIXES = ['site/exports/'];

const RULES = [
  {
    id: 'phone-truncated',
    // The 9-digit unreachable number. Lookarounds keep it from matching inside 052-4822842.
    re: /(?<![\d-])052-482284(?![\d])/g,
    why: 'truncated 9-digit phone — an unreachable number (canonical: 052-4822842)',
  },
  {
    id: 'phone-extra-hyphen',
    re: /(?<![\d-])052-482-2842(?![\d])/g,
    why: 'non-canonical display form (canonical: 052-4822842)',
  },
  {
    id: 'phone-u2011',
    // U+2011 non-breaking hyphen — a homoglyph that silently breaks byte-matching,
    // copy-paste and click-to-call parsers. Use CSS white-space:nowrap instead.
    re: /052‑\d{7}/g,
    why: 'U+2011 non-breaking hyphen in phone — use U+002D + CSS white-space:nowrap',
  },
  {
    id: 'address-u05f3',
    // ONLY the NAP tokens. דיג׳רידו is the BRAND word and legitimately keeps U+05F3
    // (the footer __tag writes it that way too) — matching it would create new drift.
    re: /(?:רח׳|עמל 8 ב׳)/g,
    why: 'U+05F3 geresh in the ADDRESS (canonical: U+0027). The brand word דיג׳רידו is NOT in scope.',
  },
];

const verbose = process.argv.includes('--verbose');
const files = [];
function walk(dir) {
  let entries;
  try { entries = readdirSync(dir); } catch { return; }
  for (const e of entries) {
    if (SKIP_DIRS.has(e)) continue;
    const p = join(dir, e);
    let st;
    try { st = statSync(p); } catch { continue; }
    if (st.isDirectory()) walk(p);
    else if (st.isFile()) files.push(p);
  }
}
for (const d of SCAN_DIRS) walk(join(ROOT, d));

const violations = [];
let scanned = 0;
for (const abs of files) {
  const rel = relative(ROOT, abs).split(sep).join('/');
  if (EXCLUDE_FILES.has(rel)) continue;
  if (EXCLUDE_PREFIXES.some((p) => rel.startsWith(p))) continue;
  // This guard itself carries the variants as literals — exempt it, or it always fails.
  if (rel === 'scripts/qa/nap_canon_check.mjs') continue;
  let txt;
  try { txt = readFileSync(abs, 'utf8'); } catch { continue; }
  scanned++;
  for (const rule of RULES) {
    rule.re.lastIndex = 0;
    const hits = [...txt.matchAll(rule.re)];
    for (const h of hits) {
      const line = txt.slice(0, h.index).split('\n').length;
      violations.push({ rule: rule.id, why: rule.why, file: rel, line, match: h[0] });
    }
  }
}

console.log(`nap_canon_check — scanned ${scanned} files under ${SCAN_DIRS.join(', ')}`);
console.log(`excluded: ${[...EXCLUDE_FILES].join(', ')} (§5.3 verbatim testimonials), ${EXCLUDE_PREFIXES.join(', ')} (frozen legacy export)`);
if (verbose) {
  console.log('\ncanon (DECISION-NAP-CANON-2026-07-16, RATIFIED):');
  console.log("  address display : רח' עמל 8 ב', פרדס חנה-כרכור   (U+0027 x2, U+002D)");
  console.log('  phone display   : 052-4822842                    (U+002D, no country code)');
  console.log('  phone tel: href : +972524822842');
  console.log('  phone schema    : +972-52-482-2842');
}
if (violations.length === 0) {
  console.log('\nRESULT: PASS — 0 non-canonical NAP variants in scope.');
  process.exit(0);
}
console.log(`\nRESULT: FAIL — ${violations.length} non-canonical variant(s):\n`);
for (const v of violations) console.log(`  [${v.rule}] ${v.file}:${v.line}  ${JSON.stringify(v.match)}\n      ${v.why}`);
process.exit(1);
