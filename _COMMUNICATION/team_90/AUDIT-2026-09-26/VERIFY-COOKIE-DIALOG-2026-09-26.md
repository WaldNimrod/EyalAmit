# VERIFY: Cookie-notice dialog accessibility — independent re-measurement

**Team:** team_90 (control) · **Date:** 2026-09-26 · **Target:** `http://eyalamit-co-il-2026.s887.upress.link` · **Theme:** confirmed **1.5.141** (from `?ver=` query strings, e.g. `ea-tokens.css?ver=1.5.141`)

**Independence note:** this pass did not read `SCREEN-READER-AUDIT-2026-09-26.md`. It was measured from scratch, per the brief, using raw CDP (`Accessibility.getFullAXTree`, real `Input.dispatchKeyEvent`/`dispatchMouseEvent`) against `chrome-headless-shell` 149.0.7827.22, launched fresh (new `--user-data-dir` per test, no reused profile) for every single run so no run ever carried stored consent from a previous one.

---

## VERDICT

**No — a screen-reader or keyboard user is not blocked or stranded on a first visit.** The dialog is a native `<dialog id="ea-cookie-notice">` opened with `showModal()`. It behaves like a correctly-implemented modal: the page background is genuinely made inert while it is open (confirmed in the accessibility tree, not just visually), both buttons are reachable and operable by keyboard alone, and Escape closes it. There is one real but inconsequential technicality in the tab cycle (documented below) and one minor UX nit in initial focus placement — neither strands or blocks anyone.

**Does focus escape the dialog while it's open?** Literally yes, in the narrow sense that `document.activeElement` becomes `<body>` for one Tab press in every cycle — but it never lands on any actual, reachable, interactive piece of page content. The entire backdrop is inert (see AX evidence below), so there is nothing behind the dialog for focus to go *to*. The next Tab press returns straight to the dialog's own first focusable element. Full detail under Q2.

**What does the tree contain while the dialog is open?** Only the dialog's own content: its two paragraphs, its "privacy policy" link, and its two buttons (147 AX nodes at 1440px / 111 at 390px). `main`, `navigation`, and every heading are **absent** from the exposed tree — all real page content is marked `ignored: true`. This is what a properly modal dialog should do, not a defect.

**Did the two runs at each configuration agree?** Yes, in every measurement, at both viewports, across all repeats. No disagreements to report.

---

## Method

- `chrome-headless-shell` at `/Users/nimrod/.cache/puppeteer/chrome-headless-shell/mac_arm-149.0.7827.22/…`, discovered the same way `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` does (read only, not modified), launched via raw CDP over Node's built-in `WebSocket` — no extra dependencies.
- **Every run** used a brand-new `--user-data-dir` (a fresh `mkdtemp` directory), so every "first visit" was genuinely first — no reused profile, no carried-over `ea_cookie_cmp` cookie/localStorage.
- Waited for `Page.navigate` to settle (~2.8–3.2s), then two chained `requestAnimationFrame`s, then verified `document.getElementById('ea-cookie-notice').open === true` before measuring anything.
- Tab presses used real `Input.dispatchKeyEvent` (`rawKeyDown` + `keyUp`, code/key `Tab`), 14 presses per trace — never a scripted `.focus()`.
- Button activation used real `Input.dispatchMouseEvent` (`mouseMoved` → `mousePressed` → `mouseReleased`) at the button's actual `getBoundingClientRect()` center — never `element.click()`.
- Tested at both **1440×900** and **390×844**. Every measurement was run **twice**, in separate fresh contexts, at both viewports.
- No 502s were encountered during this run; the retry-on-502 path in the harness was present but never triggered.
- Scripts used: `cookie_probe.mjs` (main harness) and `diag_accept.mjs` (a follow-up timing diagnostic, described under Q4), both in this session's scratchpad — not committed to the repo.

---

## Q1 — What exists in the accessibility tree while the dialog is open

Measured via `Accessibility.getFullAXTree()` immediately after confirming `dialog.open === true`, before any key presses.

| Viewport | Run | Total AX nodes | Exposed (non-ignored) roles |
|---|---|---|---|
| 1440×900 | A | 147 | `RootWebArea`(1), `dialog`(1), `paragraph`(2), `button`(2), `link`(1), `StaticText`(6), `InlineTextBox`(10) |
| 1440×900 | B | 147 | identical |
| 390×844 | A | 111 | same exposed set (fewer inert background nodes at mobile layout) |
| 390×844 | B | 111 | identical |

- **`main`: absent** in every run (`axHasMain: false`).
- **Navigation regions: absent** in every run (`axHasNavigation: false`).
- **Headings: absent** — heading count is 0 in every run.
- **Page body content: absent from the exposed tree.** The 124 (1440px) / 88 (390px) remaining nodes are all role `none` with `ignored: true` — this is the entire rest of the page (header, nav, hero, body content) rendered genuinely inert by the native `showModal()` call, confirmed by CDP, not inferred from the DOM alone.

**Plainly:** on a first visit, before dismissing the notice, a screen-reader user can reach **only** the cookie notice's own title, its two paragraphs (one containing the privacy-policy link), and its two buttons. They cannot reach `main`, any navigation landmark, any heading, or any other page content — none of it is exposed to the accessibility tree at all while the dialog is open. This is exactly what a correctly modal dialog should do; it is not being reported as a defect.

---

## Q2 — Where the keyboard actually goes (14 real Tab presses, both viewports, both runs)

All four traces (1440×900 A/B, 390×844 A/B) produced the **identical** cycle:

```
press 1  BUTTON .ea-cookie__ack     "אישור"              inside dialog
press 2  BUTTON .ea-cookie__reject  "דחייה"               inside dialog
press 3  BODY   (document default)  —                     OUTSIDE dialog
press 4  A      .ea-cookie__link    "מדיניות הפרטיות"     inside dialog
press 5  BUTTON .ea-cookie__ack     "אישור"              inside dialog
press 6  BUTTON .ea-cookie__reject  "דחייה"               inside dialog
press 7  BODY                       —                     OUTSIDE dialog
press 8  A      .ea-cookie__link    "מדיניות הפרטיות"     inside dialog
... repeats identically through press 14
```

**Does focus ever land outside the dialog while it's open? Yes — on every 3rd/4th press (3, 7, 11), `document.activeElement` is `<body>`, which is outside `#ea-cookie-notice`.**

This needs the same care the brief asks for on the other two disputed findings, so here is the full picture rather than a bare yes/no:

- `<body>` has no `tabindex` and is not itself an interactive control. Per the DOM spec, `document.activeElement` falls back to `<body>` whenever nothing else is focused — this is what happens in a normal browser when Tab moves focus out of the page entirely (e.g., to the address bar), which doesn't exist in headless Chrome, so it collapses to `<body>` instead.
- Crucially, the Q1 measurement already established that **every other element on the page is `ignored`/inert** while the dialog is open. So this is not focus escaping *into* usable background content — there is no reachable background content for it to escape into. The very next Tab press (4, 8, 12) returns focus straight back into the dialog, to its first focusable element (the privacy-policy link), because that link is the first focusable node in the whole document once the backdrop is inert.
- Net effect: a keyboard user pressing Tab repeatedly cycles endlessly through `[accept → reject → (momentary body) → link → accept → reject → ...]` and never reaches, never mind operates, any piece of real page content. They are not stranded; they are not able to interact with anything hidden behind the dialog either.
- This is a real, reproducible technicality — the tab cycle does not loop cleanly from the last dialog element straight back to the first one, it detours through the neutral "nothing focused" state for one press — but it has no practical consequence for the user, since nothing is reachable there and the next Tab recovers immediately.

Verified identically in both runs at both viewports — 4/4 agreement, no discrepancy.

---

## Q3 — Initial focus on open

Measured before any key press, immediately after confirming `dialog.open === true`.

| Viewport | Run | Initial `document.activeElement` |
|---|---|---|
| 1440×900 | A | `<a class="ea-cookie__link">` — "מדיניות הפרטיות" (the privacy-policy link, inside the dialog body text) |
| 1440×900 | B | identical |
| 390×844 | A | identical |
| 390×844 | B | identical |

**Plainly:** on open, focus does **not** go to the dialog element itself, and does **not** go to either button (in particular, not to "אישור"/accept, which is the DOM's first button). It goes to the privacy-policy link that sits inside the notice's body paragraph, because that is the first focusable element in DOM order inside the dialog and the browser autofocuses it per `showModal()`'s default. It is a legitimate, operable, correctly-labelled link — this is not a screen-reader access failure — but placing initial focus on a secondary in-body link rather than a primary action button is a minor, defensible UX nit worth a mention, not a blocker.

---

## Q4 — On dismissal (accept, then reject, separate fresh contexts)

Reading `site/wp-content/themes/ea-eyalamit/assets/js/ea-cookie-notice.js` (read-only) confirms both buttons run the same `choose(val)` path: write `localStorage`/cookie → `dlg.close()` → **`window.location.reload()`**. So "on dismissal" here really means "after a full page reload."

First pass at a 400ms post-click wait genuinely mismeasured this: it caught the page mid-reload (`readyState: "loading"`, ~2 AX nodes, dialog briefly not in the DOM at all). That was a timing artifact in this harness, not a site defect — flagged and corrected rather than reported as a finding. A timing diagnostic (`diag_accept.mjs`) confirmed the reload completes (`readyState: "complete"`) well within ~600ms, so the harness was re-run waiting ~1.8s + two animation frames after the click before measuring. Results below are from the corrected runs, twice per action per viewport:

| Action | Viewport | Dialog after reload | AX nodes after | `main`/`nav`/headings after | Focus after |
|---|---|---|---|---|---|
| Accept | 1440×900 (×2) | exists, `open: false` | 1174 (×2, identical) | present / present / 24 headings | `<body>` (default, not inside dialog) |
| Accept | 390×844 (×2) | exists, `open: false` | 1331 (×2, identical) | present / present / 24 headings | `<body>` |
| Reject | 1440×900 (×2) | exists, `open: false` | 1168 (×2, identical) | present / present / 24 headings | `<body>` |
| Reject | 390×844 (×2) | exists, `open: false` | 1328 (×2, identical) | present / present / 24 headings | `<body>` |

- **Dialog closes:** yes, in every run, both actions, both viewports.
- **Page content reappears in the accessibility tree:** yes, in every run — `main`, navigation, and a full set of headings are all present again after the reload, confirming the earlier "content vanishes" reading was the harness's own timing bug, not a real defect. Once the timing was corrected, both repeats agreed exactly at every viewport/action combination (accept and reject settle to slightly different node counts from each other, which is expected — the two choices load different consent-gated scripts, e.g. accept fires Google Analytics — but each action's own two repeats matched to the node).
- **Where focus lands after dismissal:** `<body>`, in every run, both actions, both viewports. This is not a defect specific to the cookie dialog — it is the same place focus starts on any ordinary fresh page load (this reload is functionally a normal navigation), and it is consistent with, not worse than, standard browser behavior after any `location.reload()`.
- **Cookie/localStorage persistence:** confirmed set immediately (`ea_cookie_cmp=accept` in `document.cookie` and in `localStorage`) before the reload fires; on reload the dialog stays closed (`open: false`), i.e., consent is honored and the notice does not reopen. (Escape, by contrast — see Q5 — closes the dialog without running `choose()`, so it does not write consent; that is expected given it's the native "cancel" path, not a bug, but is worth knowing operationally: an Escape dismissal will show the notice again on the next real navigation within the same session, since no reload happens to persist anything either way in this test.)

---

## Q5 — Does it matter in practice?

- **Can a keyboard user reach and operate both buttons without a mouse?** Yes. Tab press 1 reaches "אישור" (accept), Tab press 2 reaches "דחייה" (reject), both are real `<button>` elements with accessible names, both are inside the dialog, both were confirmed operable (real mouse-dispatch activation closed the dialog and completed the site's consent flow correctly in Q4; the tab trace independently confirms both are keyboard-reachable in 1–2 presses from open).
- **Does Escape close it?** Yes — confirmed in 4/4 runs (1440×900 ×2, 390×844 ×2): `dialogAfterEscape: {"exists": true, "open": false}` every time, with real `Input.dispatchKeyEvent` for the Escape key (native dialog `cancel`/close behavior, no JS reload triggered).
- **Severity judgement:** This is a dialog that is fully operable, not one that stops or strands anyone. A keyboard-only user reaches either action button within two Tab presses of the dialog opening, both buttons work, and Escape is also available as an immediate exit. A screen-reader user is, correctly, given access only to the dialog's own content while it is modal — which is the intended, spec-compliant behavior of a native `<dialog>` opened with `showModal()`, not an accessibility failure. The two things worth a low-priority ticket, not an urgent fix, are: (1) the tab cycle detours through the DOM's neutral "nothing focused" state for one press per lap instead of looping directly from the last dialog element back to the first — invisible in practice since nothing reachable exists at that detour point; and (2) initial autofocus lands on the in-body privacy-policy link rather than on the primary "accept" button, which is a debatable UX choice, not a screen-reader access defect. Neither rises to "blocked" or "stranded."

---

## Raw evidence

Probe scripts and per-run JSON captures are in this session's scratchpad (not committed): `cookie_probe.mjs`, `diag_accept.mjs`, and one JSON file per run — traces: `1440_trace_A/B.json`, `390_trace_A/B.json`; dismissal (corrected timing): `1440_accept_A2/B2.json`, `390_accept_A2/B2.json`, `1440_reject_A2/B2.json`, `390_reject_A2/B2.json`; escape: `1440_escape_A/B.json`, `390_escape_A/B.json`. (An earlier, superseded pair of accept/reject runs at the original 400ms wait is also in the scratchpad, kept only to document the timing-bug diagnosis in Q4 — the A2/B2 files are the ones this report's Q4 table is built from.) Available on request if a durable copy is wanted in the repo.
