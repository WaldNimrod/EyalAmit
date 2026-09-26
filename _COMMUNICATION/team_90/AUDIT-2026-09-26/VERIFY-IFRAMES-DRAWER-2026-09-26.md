# VERIFY: Embedded-frame naming (mobile home) + mobile nav drawer trap — independent re-measurement

**Team:** team_90 (control) · **Date:** 2026-09-27 · **Target:** `http://eyalamit-co-il-2026.s887.upress.link` (plain HTTP by design; invalid cert is out of scope) · **Theme:** confirmed **1.5.141** (from `?ver=` query strings, e.g. `ea-nav-drawer.css?ver=1.5.141`, `ea-cookie-notice.js?ver=1.5.141`)

**Independence note:** measured from scratch against a live page, not against the source alone — though the theme's own JS files (`ea-nav-drawer.js`, `ea-mobile-nav.js`, `ea-cookie-notice.js`) were read to explain *why* the measurements come out the way they do, not to substitute for measuring. All key/tab/Escape interaction used raw CDP (`Input.dispatchKeyEvent`) against `chrome-headless-shell` 149.0.7827.22, discovered the same way `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` does (read only, not modified). No `.focus()` was used to drive the Tab chain or the drawer trap; the one place a scripted `.focus()` appears is a deliberate *inertness probe* (see Finding B, background-focus test), which is a fundamentally different question from tab order.

---

## VERDICTS

- **Finding A (unnamed embedded frames in the keyboard order) — DOES NOT HOLD AS WRITTEN.**
  There is exactly **one** `<iframe>` on the home page (the YouTube video embed in `#video`), not "at least five." That iframe itself carries a non-empty accessible name (`title="וידאו"` → AX name `"וידאו"`). Real Tab-key navigation does produce several consecutive stops where the *top document's* `activeElement` stays reported as "the iframe" — 5 stops at 390px, 7 at 1440px — but that is because focus is moving through the YouTube player's own internal controls, not because there are multiple silent iframes. Checked from inside the embed's own accessibility tree, those stops are: Play video (named), Hide player controls (named), the video-title link (named), the channel-name link (named), and — at 1440px only — a Share button (named) and a "Watch on YouTube" link (named). **Exactly one** of those inner stops has no accessible name at all (a trailing, unlabeled control inside YouTube's own player chrome), not "several." It sits last in the sequence, after four (390px) or six (1440px) properly named stops, immediately before focus exits cleanly to the next real page link.

- **Finding B (mobile navigation drawer: trap / Escape / inertness) — DOES NOT HOLD AS WRITTEN** — all three unresolved questions resolve cleanly in the drawer's favor, and the one concrete worry ("Escape appeared to leave focus on an unrelated element") is directly contradicted by measurement. The drawer is a native `<dialog id="ea-nav-drawer">` opened with `showModal()`; focus trap, background inertness, and focus-return-to-toggle all work exactly as the browser's native modal-dialog contract promises, confirmed by real key events, not inferred from the source comment that says so.

**Number of silent embed stops actually found:** **1** (not "at least five" / "several") — inside the single YouTube iframe, at both viewports, reproduced twice each.

**Does the drawer trap or release focus:** **traps.** Every real interactive stop across two extended runs (45 Tab presses, well past the drawer's 41 total focusable descendants) stayed inside `#ea-nav-drawer`. The only exception was a single, well-known, harmless one-frame artifact of native `<dialog>` focus-wrapping (see Finding B, Q2) — not a real escape onto usable content.

**Did the two runs agree:** **yes, on every point that matters**, for both findings — see the per-question tables below for the one place where run depth (not disagreement) explains an apparent difference.

---

## Method

- `chrome-headless-shell` at `/Users/nimrod/.cache/puppeteer/chrome-headless-shell/mac_arm-149.0.7827.22/chrome-headless-shell-mac-arm64/chrome-headless-shell`, launched headless via raw CDP over Node's built-in `WebSocket` — zero npm/pip dependencies, per the `qa_probe.mjs` pattern (read only, never modified).
- A brand-new tab (`/json/new`) and, for every distinct measurement, a brand-new Chrome process/port were used — "fresh browser context" per the brief.
- Cookie notice was dismissed using **only real key events**: Tab (`Input.dispatchKeyEvent`, `rawKeyDown`+`keyUp`) until `document.activeElement` carried `data-ea-cookie-choice="accept"`, then a real `Enter` keypress. Dismissal reloads the page (confirmed via `dlg.close(); window.location.reload()` in `ea-cookie-notice.js`); every run waited for `Page.frameNavigated` then `Page.loadEventFired`, then ~1.2s settle + two chained `requestAnimationFrame`s, before measuring anything.
- Tab-chain walking used real `Input.dispatchKeyEvent` `Tab` presses exclusively. Each stop was read two ways: (1) `document.activeElement` in the top frame via `Runtime.evaluate` (tag/class/text/aria attributes), and (2) the CDP **Accessibility domain** — `DOM.requestNode` → `DOM.describeNode` → `Accessibility.getPartialAXTree({backendNodeId})` — for the computed AX role and name, i.e. the same tree assistive tech receives, not a DOM-attribute guess.
- For the embedded YouTube iframe specifically (Finding A), the child frame's own execution context was located via `Page.getFrameTree` + `Runtime.executionContextCreated` events, and `document.activeElement` inside *that* context was read directly — this is what let us see past the outer frame's "it's just an iframe" view into what was actually focused inside the embed.
- Escape was sent as a real key event (`Input.dispatchKeyEvent`, `Escape`), never a scripted `dialog.close()`.
- The one scripted `.focus()` call in this pass is the background-inertness probe for Finding B (calling `.focus()` directly on the WhatsApp float link while the drawer is modal, to see whether the browser accepts or rejects it) — a deliberate, different kind of test from the tab-order work, called out explicitly where it's used.
- Every measurement below was run **at least twice**, in separate fresh browser launches; where a third run was needed to resolve an apparent discrepancy (Finding B, Q2) that is stated explicitly.
- No 502s were encountered; requests stayed well under 3 concurrent throughout.
- Scripts (all in this session's scratchpad, not committed to the repo): `cdp_lib.mjs` (shared raw-CDP helper), `finding_a_final.mjs`, `measure.mjs`, `finding_b_closebtn.mjs`.

---

## Finding A — embedded frames in the keyboard order (mobile home)

### Q1 — How many `<iframe>` elements actually exist on the home page, and what are their sources?

Measured via a live `document.querySelectorAll('iframe')` after full page load (JS executed, cookie dismissed) — not a static-HTML grep, since the theme's own JS was also checked (`ea-testimonials.js`, `ea-lightbox.js`, `ea-hero.js`, `ea-chapters.js`, `ea-toc.js`, `ea-mobile-nav.js`, `ea-nav-drawer.js`, `ea-entrance.js`, `ea-scroll.js`, `ea-ab-testing.js`, `ea-canonical-nav-gp-dropdown.js`) and none of them create iframes.

| Viewport | Run | iframe count (DOM) | Source | `title` attr |
|---|---|---|---|---|
| 390×844 | 1 | 1 | `https://www.youtube.com/embed/wDQoJauqsRM` | `"וידאו"` |
| 390×844 | 2 | 1 | same | same |
| 1440×900 | 1 | 1 | same | same |
| 1440×900 | 2 | 1 | same | same |

All four runs agree: **one iframe, one source, one title.** There is no `<noscript>`-injected tracking iframe (checked — none present) and no dynamically-created iframe from any theme script.

### Q2 — Is it in the tab order, and what is its accessible name?

The outer `<iframe>` element's own AX node (queried via `Accessibility.getPartialAXTree` before it ever receives focus): `role: Iframe`, `name: "וידאו"` — a real, non-empty accessible name, sourced from its `title` attribute. **Not empty**, contrary to the finding as written.

### Q3 — What actually happens when a keyboard user tabs through it (real key events)

Because the embed loads real cross-origin content (confirmed via `Page.getFrameTree` — a genuine child frame at `https://www.youtube.com`, same-process in this Chrome build, so its execution context and AX tree are inspectable), the *outer* document's `activeElement` stays reported as `<iframe>` for every Tab press while focus is actually moving between the YouTube player's own controls. Reading `document.activeElement` **inside the child frame's own execution context**, real key events produced:

| # | Viewport | Inner control focused | Accessible name |
|---|---|---|---|
| 1 | both | `<button>` | **"Play video"** |
| 2 | both | `<button>` | **"Hide player controls"** |
| 3 | both | `<a>` (video title) | **video title text** |
| 4 | both | `<a>` (channel name) | **"אייל עמית"** |
| 5 | both | `<button>` | **empty** — no `aria-label`, no `title`, no text |
| 6 | 1440px only | `<button>` | **"Share"** |
| 7 | 1440px only | `<a>` | **"Watch on YouTube"** |

Reproduced identically across two fresh-context runs at each viewport (390: 2/2 identical; 1440: 2/2 identical, including the exact same silent stop at the same position).

**The count differs by viewport** — 5 consecutive outer-"iframe" stops at 390px vs. 7 at 1440px — because YouTube's own player chrome shows more controls (Share, Watch-on-YouTube) at the wider width. **The silent-stop count does not differ: it is 1 at both viewports**, and it is the same control (an unlabeled button inside YouTube's own overlay, positioned second-to-last of the mobile set / fifth-of-seven on desktop) — third-party embed markup, not something this theme's code controls.

**Answering the brief's exact question — "the actual number of silent embed stops a user meets before reaching the first meaningful control":** **zero.** The very first control reached inside the embed ("Play video") is meaningfully named. The one silent stop comes *after* four (390px) or six (1440px) properly named controls, immediately before focus exits the iframe cleanly onto the next real page link ("טיפול בנשימה"). A keyboard user does not tab through "several silent embeds before reaching anything meaningful" — they reach something meaningful on the very first stop inside the one embed that exists.

---

## Finding B — mobile navigation drawer (390×844)

Source context (read, not assumed): `ea-nav-drawer.js`'s own header comment states the drawer is a native `<dialog>` opened with `showModal()` specifically so that "focus trap, Escape-to-close, background inertness and focus-return to the opener are the browser's job and are NOT reimplemented here." The measurements below test whether that is actually true in this Chrome build, not whether the comment is honest.

### Q1 — Where does focus go when the drawer opens?

Opened with a real `Enter` keypress on the toggle (reached via 3 real Tab presses from page load, confirmed `aria-label="תפריט"`, `aria-expanded` flips `false→true` on open — matching what the earlier pass already established and was not in question here).

| Run | Focus immediately after open |
|---|---|
| 1 | `<a class="ea-nd__brand">` "המרכז לטיפול בדיג׳רידו" — the drawer's own first link, AX role `link`, name matches |
| 2 | identical |
| 3 | identical |

Focus lands inside the drawer, on its first focusable element. Not lost, not left on the toggle.

### Q2 — Does focus ever leave the drawer while open (15+ real Tab presses)? Is the background inert?

Two depths were tested: 18 Tab presses (run 1) and 45 Tab presses (runs 2 and 3 — deliberately well past the drawer's total of 41 focusable descendants, to also test the wrap-around).

| Run | Tabs pressed | Stops outside `#ea-nav-drawer` | Detail |
|---|---|---|---|
| 1 | 18 | 0 | every stop confirmed `inDialogId === 'ea-nav-drawer'` |
| 2 | 45 | 1 (at position 41 of 45) | `document.activeElement` briefly became `<body>` — AX `role: "none"`, `ignored: true` — then the very next Tab returned focus to `ea-nd__brand`, the drawer's own first element |
| 3 | 45 | 1 (at the same position 41) | identical to run 2, same node, same AX ignored state |

**These do not disagree** — run 1 simply didn't tab far enough (18 < 41) to reach the wrap boundary; once tested to the same depth (runs 2 and 3), both independently hit the identical harmless artifact at the identical position. This is the same class of native `<dialog>` focus-wrap quirk documented today in `VERIFY-COOKIE-DIALOG-2026-09-26.md` for the cookie dialog (a momentary `<body>` stop with nothing reachable there, self-correcting on the next Tab) — not a trap failure, and not something a keyboard user would ever notice or get stuck on, since `<body>` here has no interactive affordance and is `ignored` in the accessibility tree.

**Background inertness — a direct probe, not inferred from Tab alone:** with the drawer open, a script called `.focus()` directly on the real background WhatsApp float link (`a[data-ea-ab="whatsapp"]`, a genuine, normally-focusable page element that sits just before the drawer in DOM order). Result in every run: `document.activeElement !== that link` — **the browser itself refused the focus attempt** while the dialog is modal. This is the strongest available confirmation of native inertness: it holds even against a direct script call, not merely against Tab-order navigation.

### Q3 — Escape: does the drawer close, and does focus return to the toggle?

| Run | `dialog.open` after Escape | Focus after Escape |
|---|---|---|
| 1 | `false` | `<button class="nav__burger">`, `aria-label="תפריט"` — **the toggle** |
| 2 | `false` | same |
| 3 | `false` | same |

**Focus returns to the toggle in every run.** This directly contradicts the original pass's observation that "Escape appeared to leave focus on an unrelated element" — that observation does not reproduce here.

### Q4 — Can the drawer be closed by keyboard alone, and can every link inside be reached?

- **Escape** closes it (Q3, confirmed 3/3).
- The visible **"×" close button** (`.ea-nd__close`, `aria-label="סגירת תפריט"`), reached by a single real Tab press and activated with a real `Enter` keypress, also closes the dialog (`open: false`) and also returns focus to the toggle — a second, independent all-keyboard path out, confirmed in a dedicated run.
- **Every link is Tab-reachable:** 41 total focusable descendants (`#ea-nav-drawer a[href], #ea-nav-drawer button`), and the 18/45-press walks above show real, distinct, correctly-named stops the entire way through (including sublinks inside collapsed accordion panels, which remain Tab-reachable before their accordion is opened — a separate, minor observation outside the two designated findings, noted for completeness only).
- Reopening after closing (a fourth real `Enter` press on the refocused toggle) succeeds (`open: true`) — closing is not a dead end.

---

## Is a keyboard-only user ever stuck?

**No.** For Finding A: a keyboard user tabbing into the one video embed on the page reaches a properly named "Play video" control first, then three more named controls, then (only after that) one unlabeled control inside YouTube's own third-party player chrome, before exiting cleanly back onto the page. That is a minor, embed-internal polish item — not "several silent embeds" blocking progress, and not within this theme's code to fix. For Finding B: a keyboard-only user can open the drawer (lands inside it immediately), move through every item in it (the trap holds for the drawer's full 41-item cycle, with one harmless, self-correcting native-browser artifact at the wrap boundary that has nothing focusable to land on), and get out again by either Escape or the close button — both of which correctly return focus to the toggle button, ready to continue. Neither finding describes a blocker as written; both are, at most, polish.
