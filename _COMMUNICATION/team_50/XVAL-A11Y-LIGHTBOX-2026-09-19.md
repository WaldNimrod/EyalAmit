---
id: XVAL_A11Y_LIGHTBOX_2026-09-19
schema_version: aos_v1_team_messaging
type: CROSS-ENGINE VALIDATION RESULT (team_50 line → team_100)
from: team_50 (cross-engine line, cursor-grok-4.6-high)
to: team_100
cc: [team_00, team_10]
date: 2026-09-19
theme_under_test: 1.5.66 (start and end — no drift)
prompt: tmp/qa/xval-2026-09-19/A3c-lightbox.txt
verdict: all 7 sub-claims CONFIRMED, and the Escape control question is resolved: Chrome 153 headed CDP closes a native dialog
---

> Builder engine was Claude Opus 5. Validator engine is Grok — Iron Rule #1 at engine level.
> This line is one third of an accessibility brief that timed out empty twice at 900s; the
> fix on this project is to split the measurement work, never to raise the timeout. Raw
> output follows verbatim.

I'll treat this as a falsification campaign, not a confirmation. First I'll capture the live `ea-tokens.css` `?ver=` and check how this staging host and the lightbox actually behave, including the Escape control test before any Escape verdict.Start version is `1.5.66`. Next I’ll read the lightbox implementation and the QA harness, then run a live keyboard test with the Escape control first.I’ll fetch the live page structure, then run a headed Chrome CDP campaign: load assertion first, Escape control on a bare dialog, then the lightbox keyboard checks.Chrome 153 is available. I’ll run a headed CDP script on that one page: load check, bare-dialog Escape control, then Tab/name/focus/close/backdrop/inert.The open dialog leaves the header and WhatsApp FAB visible. I’ll probe whether those background controls still take clicks, which would falsify inert.Independent verifier, Chrome **153.0.8010.53** headed, CDP. Page loaded before any verdict: rendered HTML **77570** bytes, `#main` present, **2** `button.zoom`, one `dialog.ea-lb` from the theme script. Curl at end: **93797** bytes, still two zooms.

I did not find a defect in the sub-claims below. That is a measurement on this page at 1440×900, not a site-wide pass.

## Escape control (required before any Escape verdict)

Bare `<dialog id="ea-ref-dlg-control">` appended to the document, **no site lightbox code**, `showModal()`.

| Method | Reference dialog closed? |
|---|---|
| CDP `Input.dispatchKeyEvent` `rawKeyDown`+`keyUp` Escape (vk 27) | **yes — qualified** |
| same, `keyDown`+`keyUp` | yes |
| same, `rawKeyDown`+`char`+`keyUp` | yes |
| untrusted JS `KeyboardEvent('keydown', {key:'Escape'})` | **no** (disqualified, as expected) |
| osascript System Events `key code 53` to the Chrome pid | **no** (spawn timeout; disqualified) |

Chrome 153 headed CDP **does** close a native dialog. That is the opposite of the Chrome 152 CDP result this project already recorded. Because the control passed, the real lightbox Escape result below counts.

Real `dialog.ea-lb`: same qualified CDP Escape → **closed**, focus back on the opener.

## Sub-claims

**1. Each trigger reachable by real Tab** — **CONFIRMED**  
CDP Tab actually moved document focus (first stop `a.nav__b`). `button.zoom[0]` at Tab **28**, `button.zoom[1]` at Tab **33**.

**2. Each trigger has an accessible name** — **CONFIRMED**  
No `aria-label`. AX tree names from contents (img `alt` + `.zoom__hint`):  
- `מתוך אתר מכבי: … לדום נשימה חסימתי בשינה להגדלה — לחצו על התמונה`  
- `התכתבות עם מטופל … מטושטש להגדלה — לחצו על התמונה`  
`focusable: true`, `ignored: false`.

**3. Opening moves focus into the dialog** — **CONFIRMED**  
CDP Enter on the focused trigger opened it (`openedHow: cdp-Enter`). `document.activeElement` became `button.ea-lb__x` (`aria-label="סגירה"`) inside `dialog.ea-lb` for both triggers. Screenshots: `/tmp/ea_lightbox_kb_verify/02-open-zoom0.png`, `/tmp/ea_lightbox_kb_verify/03-open-zoom1.png`.

**4. Close button works** — **CONFIRMED**  
`elementFromPoint(124, 92)` is `button.ea-lb__x`. CDP click there → `dialog.open === false`.

**5. Backdrop click works** — **CONFIRMED**  
Click at (8, 98), left of the dialog box (`x=120, w=1200`) → closed. Follow-up: `elementFromPoint` on header / WhatsApp FAB / EN region all hit `DIALOG.ea-lb`, not those controls; those clicks close the dialog and do not navigate.

**6. Focus returns to the opener** — **CONFIRMED**  
Close after zoom0 → `activeIsZoom0`. Close after zoom1 → `activeIsZoom1`. Backdrop close after zoom0 → zoom0. Escape after zoom0 → zoom0.

**7. Background inert while open** — **CONFIRMED** (behavioral; see limit)  
While open: `skip.focus()` and `zoom.focus()` did not steal focus; Tab did not land on nav / skip / zoom. Header and `.ea-whatsapp-float` (z-index 60) lose hit-testing to the top-layer dialog.  
Limit: `document.querySelectorAll('[inert]').length === 0` and `.inert` is false on `main` / zoom — Chrome is not setting the HTML `inert` attribute. Two of six CDP Tabs while open reported `activeElement === body` then returned to `.ea-lb__x`; no background control was reached. That is not a demonstrated click-through or tab-through of the page chrome.

## Theme `ea-tokens.css?ver=`

- **Start:** `1.5.66`  
- **End:** `1.5.66` (in-page link and a fresh HTTP fetch of `/snoring-sleep-apnea/`)