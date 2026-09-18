Cross-engine gate for team_00's requirement before mobile work begins: "run full QA/validation checks and CSS canon accuracy cross-engine, to be sure the desktop layer is fully accurate with no exceptions." Three focused Grok lines (`cursor-grok-4.6-high`, one topic each, serial with a pause, `AOS_VALIDATOR_TIMEOUT=900`), per `_COMMUNICATION/team_50/XVAL-BRIEF-S007-DESKTOP-CANON-2026-09-18.md`. None were given conclusions — each got the claim, the traps, and told to falsify, not confirm.

Prompts: `tmp/qa/xval-2026-09-18/T{1,2,3}-*.txt` (gitignored, same convention as prior waves). Raw per-line outputs: `tmp/qa/xval-2026-09-18/T{1,2,3}.out.md` (also gitignored).

**Live theme was 1.5.58 throughout all three lines, not the 1.5.56 named in the brief** — the site moved again during this exact verification window, same pattern as the earlier accessibility and typography waves today. This session's own local git checkout independently advanced to 1.5.58 mid-batch (commit `52d6a2d`) without any action from this session, confirming the version drift was real and not a measurement artifact.

## Verdicts

| Claim | Verdict | Rests on |
|---|---|---|
| C1 — 12 rungs, nothing else | **FALSIFIED** | Dozens of hardcoded off-scale `font-size` declarations, live, in `chapters.css`/`ea-atoms.css`/`ea-blog.css` — see below |
| C2 — 5 rungs match team_00's approved numbers exactly | **CONFIRMED** | `:root` computed on 5 pages; `--fw-h3:600` correctly not flagged (per brief) |
| C3 — nothing off-scale renders on any family | **FALSIFIED** on 2 of 15 sampled families | `span.ea-topnav__caret` = 8.568px on `/press/` and `/about/`, no matching rung |
| C4 — rem units, resize works | **CONFIRMED**, with scope caveats | Live root-doubling + reflow re-read on 4 templates; OS text-zoom and 11 other families not checked |
| C5 — heading hierarchy intact | **FALSIFIED** on 1 of 15 sampled families | `/about/` renders two `<h1 class="ea-page-title">`, same text, in document order |

Bonus, not one of the five claims: **the site groups into 15 CSS-plus-template families, not 16.**

## C1 — the twelve rungs are real; "nothing else" is not

`ea-tokens.css` genuinely defines exactly the 12 claimed `--fs-*` rungs and 6 `--fw-*` weights, and nothing 13th. That much holds. It is the rest of the claim — that no other live stylesheet declares an off-scale `font-size` outside the three named exemptions (`.nav__caret`, `.testi-mq__btn`, a CF7 `label`) — that does not survive: the line found those three present and correctly winning, then found a fourth, and kept finding more. The full list (~50 selectors, mostly in `chapters.css`, some in `ea-atoms.css` and `ea-blog.css`) is in `T1.out.md`; representative examples: `.st3::after` (24px, no matching rung), `.ea-topnav__caret` (8.568px, unannotated — see C3), `.tcard__q`/`.tcard__n`/`.post__t`/`.post__meta`/`.feat__t` (card and post meta copy across several component families), `.fstep__t`/`.mag-list__t`/`.btile__t` (the same display-font components flagged in the earlier typography xval wave). This is not three exceptions plus noise — it is a second, parallel, hardcoded scale still live alongside the tokenized one. GeneratePress's own `main.min.css` (`h1{font-size:42px}` etc.) is also live but currently loses the cascade to `body h1` on every page checked — present but inert, not a live C1 hit by itself.

## C2 — confirmed exactly

`--fs-body:1.0625rem`, `--fs-nav:1.1475rem`, `--fs-h3:1.16875rem`, `--fs-h2:1.540625rem`, `--fs-h1:2.7625rem` — all five match `body 17px anchor, ×1.08/1.10/1.45/2.60 over a 16px root` to every decimal place, live, and they win the cascade on the elements checked (home, `/contact/`, `/services/`). `--fw-h3` ships as `600`; per the brief this is a deliberate later instruction, not drift, and was not reported as an error.

## C3 / C5 — the site-map re-derivation, and what it found

Told explicitly to derive the family grouping itself rather than trust the committed TSV's categorization (the TSV's raw 157-URL list was used only as the set of URLs to consider), the line grouped by each URL's own enqueued-stylesheet signature plus template class and found **15 families, not 16** — full breakdown with URL counts in `T2.out.md`. The six previously-orphaned URLs (`/services/`, `/shows-heritage/`, `/historical-articles/`, `/thank-you/`, `/courses-soon/`, `/learning/courses-external/`) all landed in one family (F05, "tokens-only default") and were confirmed to now carry the full token set live — that fix held.

Sampling 1-2 representative URLs from every one of the 15 families (26 pages total, full coverage, no family skipped):

- **C3 held on 13 of 15 families.** It failed on **F11 (`/press/`) and F13 (`/about/`)** — both load `ea-atoms.css` without the `chapters.css` shell, so their visible nav dropdown glyph is `span.ea-topnav__caret` (`ea-atoms.css:268`, `font-size:0.7em`, unannotated), not the already-exempted `.nav__caret`. Computed live: **8.568px**, nearest rung `--fs-3xs` at 11.05px, Δ −2.48px. This is the same selector T1 already flagged from a pure source read, now independently confirmed rendering off-scale on two live pages — two different lines, two different methods, same finding.
- **C5 held on 14 of 15 families.** It failed on **F13 (`/about/`)**: two visible `<h1 class="ea-page-title">` elements, identical text ("אודות אייל עמית"), in document order — one directly under `main.ea-wave2-editorial`, a duplicate inside the following `section.ea-content-section`. Not a skipped level; a doubled top level.

## C4 — confirmed, with honest scope limits

All three sub-claims held on what was checked: every rung is declared in `rem` (source and live, byte-identical); doubling the live root font size (via a direct DOM/CSS change, re-read after forced reflow, not calculated from source) scaled every one of the 12 rungs by exactly 2.000 with zero error; and `document.documentElement.scrollWidth === innerWidth` (zero horizontal overflow) held at 1440×900, 1280×800 and 1024×768 on four templates (home, `tpl-service`, `tpl-content`, `page-template-default`) after the resize. Not checked: real OS/browser text-only zoom (only a JS root-size double was used); the other 11 of 15 families for the horizontal-scroll sub-claim; `/en/`'s result would need care since that template sets `html,body{overflow-x:hidden}`, which would hide a real overflow rather than prove its absence.

## What changed since the brief was written

The brief's own theme version (1.5.56) was already one version behind live by the time the first line ran, and two behind by the time this report was written. Nothing here should be read as this session's own conclusion beyond what is stated above — re-measure before citing any of these numbers later, per the standing rule already on this project.
