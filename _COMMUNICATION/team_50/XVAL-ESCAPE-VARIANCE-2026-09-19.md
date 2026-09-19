---
id: XVAL_ESCAPE_VARIANCE_2026-09-19
schema_version: aos_v1_team_messaging
type: CROSS-ENGINE INVESTIGATION RESULT (team_50 line → team_100)
from: team_50 (cross-engine line, cursor-grok-4.6-high)
to: team_100
cc: [team_00, team_10]
date: 2026-09-19
prompt: tmp/qa/xval-2026-09-19/E-escape-variance.txt
verdict: ROOT CAUSE FOUND — the variable is the CDP dispatch, not the browser
status: BINDING for every future keyboard measurement on this project
---

# The Escape variance, resolved: it was never the browser

**The rule, in one line: a modal `<dialog>` closes only on a TRUSTED `keydown` whose
`key === "Escape"` AND whose `keyCode === 27`. Omit `windowsVirtualKeyCode` from the CDP
call and `keyCode` arrives as 0, the page still receives the keydown, and nothing closes.**

Chrome 152 — the version this project recorded as "does not close" — closes correctly when
the event is complete, headed and headless. Chrome 153, chrome-headless-shell 149 (this
project's own QA binary), and the live lightbox all split exactly the same way. Version,
headed vs headless, and window focus were each tested and ruled out.

## What this costs us if ignored

An incomplete dispatch produces a **false defect**, not a false pass — the inverse of every
other trap in this project's harness record. It cost one line a COULD NOT MEASURE verdict and
came within one step of being reported as a real accessibility failure in a published
statement's scope.

## The control every keyboard line must run

Read the **page-side keydown**, never only `dialog.open`:

- trusted, key `Escape`, `keyCode` **27**, then `cancel` → control passed. A dialog still open
  after that is a genuine product finding.
- trusted, key `Escape`, `keyCode` **0** → the harness omitted `windowsVirtualKeyCode`.
  **COULD NOT MEASURE.** Never a site defect.
- no keydown at all → the host or the OS swallowed Escape. Also **COULD NOT MEASURE**.

## Operational note that is NOT in the line's report

This run launched headed **Chrome for Testing** binaries, including downloading 152. On macOS
a headed Chromium asks the login keychain for "Chromium Safe Storage" on first launch, and
that modal landed on team_00's screen mid-session. **Any future headed automation launch on
this machine must pass `--use-mock-keychain` and `--password-store=basic`** so it never
touches the keychain. Denying the prompt is harmless; the profile is disposable.

> Raw output follows verbatim.

I’ll treat this as a measurement problem, not a code change: hold one variable at a time, use a bare native `<dialog>`, and only then see whether the site lightbox follows. First I’ll inventory the binaries, existing probes, and prior measurements so the runs are comparable.AOS is online. Next I’ll pull today’s Escape measurements and inventory every Chrome binary on this machine so the runs can be compared apples-to-apples.Chrome 153 and several Puppeteer binaries are here; 152 is not. I’ll read the prior CDP script and Chromium CloseWatcher notes, then run a matrix on a bare dialog.Release notes don’t mention a 152→153 dialog change. I’ll instrument a bare dialog and run a matrix across binaries, headless vs headed, dispatch params, and focus — including whether `Emulation.setFocusEmulationEnabled` is what actually fires CloseWatcher.Chromium’s CloseWatcher handler only fires on a **trusted keydown** whose `keyCode` is 27. I’ll measure that contract across binaries and dispatch shapes, including a download of Chrome 152 if it exists.Chrome 152 for Testing downloaded. The first 153/149 runs already close the dialog even with `document.hasFocus() === false`; I’ll wait out the rest of the matrix and then put 152 on the same dispatch.The matrix already isolates the contract: a trusted keydown must have both `key === "Escape"` and `keyCode === 27`. Next I’ll run that same pair on Chrome 152 and on the live lightbox.The variable is not the browser. It is whether the dispatched event arrives as a **trusted `keydown` whose `key` is `"Escape"` and whose `keyCode` is `27`**. Blink closes a modal `<dialog>` only when both of those fields are set. A trusted Escape with `keyCode: 0` reaches the page and does nothing.

That is Chromium’s CloseWatcher path, measured, not inferred. Current Blink:

- `KeyboardEventManager` only runs the Escape default handler on **`keydown`** when `event.key() == "Escape"`.
- `CloseWatcher::WatcherStack::EscapeKeyHandler` then requires `isTrusted` **and** `keyCode() == VKEY_ESCAPE` (27).

Miss either field and `cancel` never fires. The dialog stays open. The page still sees a keydown. That is the same picture both prior lines recorded, just with opposite dispatch shapes.

## The pair that isolates it

Same binary, same headed/headless mode, same bare `<dialog showModal()>`, only the CDP fields change.

**Chrome for Testing 152.0.7977.76** (the version that previously “failed”):

| Dispatch | Resulting keydown | Dialog |
|---|---|---|
| `rawKeyDown`+`keyUp`, `key: "Escape"`, `code: "Escape"`, `windowsVirtualKeyCode: 27` | trusted, key Escape, **keyCode 27** | **closed** (`cancel` fired) |
| same, **omit** `windowsVirtualKeyCode` | trusted, key Escape, **keyCode 0** | **stayed open** |

Headed and `--headless=new` on 152 both do this. Version 152 closes a native dialog when the event is complete.

**Chrome 153.0.8010.53** headed, and **chrome-headless-shell 149.0.7827.22** (this project’s QA binary): the identical pair. Incomplete event stays open; complete event closes.

The site lightbox on [http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/](http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/) follows the same rule under shell 149: complete dispatch closed `dialog.ea-lb` (keydown landed on `.ea-lb__x`, `keyCode` 27); omit vk 27 and it stayed open (`keyCode` 0). Staging failed to load for the 152 site shots (`PAGE DID NOT LOAD`); the 152 result therefore rests on the bare dialog, which is the right instrument.

## What actually has to be on the CDP call

Required, together:

- a keydown (`type: "rawKeyDown"` or `"keyDown"`; keyUp alone never closes)
- `key: "Escape"` exactly (`"Esc"` is dropped by CDP and arrives as `key: ""`)
- `windowsVirtualKeyCode: 27` (this is what becomes `event.keyCode`)

Not required: `code`, `text`, a following `keyUp`, `nativeVirtualKeyCode` 53 (Mac Escape). `code: "Escape"` + vk 27 with **no** `key` still fails (`key` arrives empty). Mac native 53 without the Windows vk still yields `keyCode: 0`.

Untrusted `new KeyboardEvent('keydown', {key:'Escape', keyCode:27})` never closes, anywhere. Settled, as you said.

## Candidates, tested, not reasoned

1. **Chrome version 152 vs 153.** Ruled out. CFT 152.0.7977.76 headed and headless close on the complete event and stay open on the incomplete one, same as 153.
2. **Headed vs headless vs chrome-headless-shell.** Ruled out for this dispatch. 153 headed, 153 `--headless=new`, 153 `--headless`, CFT 149 headed/headless, and shell 149/147/144/139/131 all close on the complete event. Chromium 112 headless also closed (CloseWatcher was not even a constructor there; `cancel` still fired).
3. **Dispatch parameters.** This **is** the variable. See above. Reproduced on 152, 153, and shell 149.
4. **Where the event is aimed / window focus.** Ruled out for CDP. `document.hasFocus()` was `false` on most headed runs that still closed. `window.blur()`, `Page.bringToFront`, and `Emulation.setFocusEmulationEnabled` on or off did not change the outcome. An empty dialog (focus on the `<dialog>` itself) and a dialog with an inner button behaved the same. Incomplete events still delivered a keydown to the focused node; they just had `keyCode: 0`.
5. **Embedding host (Claude desktop in-app browser).** Not driven here. I cannot speak to that host from a run. What I can say: the 152 “stayed open” symptom is reproduced on **the same Chrome 152 build, headed**, by omitting `windowsVirtualKeyCode`. If that host’s CDP wrapper sent `key: "Escape"` without vk 27, that is sufficient. If it sent the complete event and the page never saw a trusted keydown, the host ate Escape. Distinguishing those two needs that host’s page-side keydown log.
6. **Feature flags.** `--disable-features=CloseWatcher` and `DialogCloseWatcher` on 153 headed still closed. Those flag names are not a kill-switch for this path on this build. Not the variance.

Older full Chrome-for-Testing 147/144/139/131 did not accept a CDP port in this session (launch failure, stderr empty). That is not a dialog result. Their matching `-shell` builds did launch and did close.

Raw runs: [file:///tmp/ea_escape_dialog_matrix/report.json](file:///tmp/ea_escape_dialog_matrix/report.json), [file:///tmp/ea_escape_dialog_matrix/followup.json](file:///tmp/ea_escape_dialog_matrix/followup.json).

## Rule for a future QA line here

Use any of: Chrome 153, CFT 152, CFT 149, or **chrome-headless-shell 149** (`~/.cache/puppeteer`). Headed or headless does not matter for this.

Dispatch exactly:

```js
Input.dispatchKeyEvent({ type: 'rawKeyDown', key: 'Escape', code: 'Escape', windowsVirtualKeyCode: 27, nativeVirtualKeyCode: 27 })
Input.dispatchKeyEvent({ type: 'keyUp',     key: 'Escape', code: 'Escape', windowsVirtualKeyCode: 27, nativeVirtualKeyCode: 27 })
```

Then **read the page-side keydown**, not only `dialog.open`:

- trusted, `key === "Escape"`, `keyCode === 27`, then `cancel` → the control passed; a still-open dialog is a real product finding.
- trusted, `key === "Escape"`, **`keyCode === 0`** → the harness omitted `windowsVirtualKeyCode`. Report **COULD NOT MEASURE**. Do not call it a site defect.
- no keydown at all → the host or OS ate Escape. Same: **COULD NOT MEASURE**.

Do not use page-script `KeyboardEvent`. Do not treat `key: "Escape"` alone as a real Escape. Playwright/Puppeteer `keyboard.press('Escape')` usually sets vk 27; raw CDP often does not. This project’s `qa_probe.mjs` does not dispatch keys today; if a line adds Escape, the control above is the gate, not the binary.Those three background runs finished cleanly and are what the finding rests on.

Chrome 152 headed and headless both **close** a native `<dialog>` when CDP sends `key: "Escape"` **and** `windowsVirtualKeyCode: 27`, and both **leave it open** when vk 27 is omitted (`keyCode` arrives as 0). Chrome 153, chrome-headless-shell 149, and the live lightbox follow the same split. Version, headed/headless, and window focus are not the variable.