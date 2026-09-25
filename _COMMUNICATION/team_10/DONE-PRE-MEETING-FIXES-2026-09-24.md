# Pre-meeting fixes — builder return — 2026-09-24

Builder: Team 110. Auditor: Team 90. This file is a claim. Team 90 re-measures.
Work plan followed, in its order: `/Users/nimrod/.cursor/plans/pre-meeting_fix_round_806172ab.plan.md`.
That plan's own rule: a step whose live measurement contradicts the task is not implemented.
Staging base: `http://eyalamit-co-il-2026.s887.upress.link`. Fetches below do not follow redirects.
Theme version on the pages that were checked: `1.5.116`.
Contrast (`G-12` / `G-13`, `CONTRAST-MAP-2026-09-24.md`) was not built. Tokens were not changed.

## 1 · G-11 · Contact WhatsApp

- URL: `http://eyalamit-co-il-2026.s887.upress.link/contact/` — HTTP 200.
- Measurement: two `href` values, both exactly `https://wa.me/972524822842?text=` plus the same encoded sentence. `href="#contact"` is absent.
- A real activation from the hero link reached WhatsApp on the contact `972524822842`. Nimrod confirmed the contact is the right one.

## 2 · G-01 · Mukesh, one image set

- Short URL `/mokesh-dahiman/` — HTTP 301 to `/eyal-amit/mokesh-dahiman/`. Not used as the page.
- URL: `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/` — HTTP 200, body 93772 bytes.
- Measurement: `assets/images/mokesh/` occurs 0 times. `mokesh-gallery/` occurs 26 times. `mokesh-14.jpeg` is in the gallery with alt `מוקש דהימן`.
- Image alts on that page do not contain `אייל עמית חוזר`, `טקס הפרידה`, or `בית המלאכה של מוקש`.
- The work plan's pass line for this step asks the page to contain none of `2026`, `בית המלאכה... ברישיקש`, or `עם משפחתו, תיעוד נדיר`. That search still hits page prose, the footer copyright line, and the hostname. It does not hit an image alt. The sentence beginning `בשנת 2026, שש שנים לאחר פטירתו` was left in place. Deleting it would remove page copy, which the same plan forbids.
- The June files are in the repo at `site/wp-content/themes/ea-eyalamit/assets/images/_archive/mokesh-june-replaced-august/` with `README.txt`. That archive folder was not uploaded. The old remote directory was not deleted. The live page does not reference it.

## 5 · G-02 · Breadcrumbs — refused, already true

No code change. Team 90's markup claim did not survive a later fetch.

- `/books/tsva-bekahol/` HTTP 200. After layout, `nav.ea-crumb` is `display:block`, `visibility:visible`, height `22.1796875`, width `1104`. Links inside it: `בית`, `ספרים`.
- `/learning/lectures/` HTTP 200. Markup contains `nav.ea-crumb` and the text `בית לימוד והכשרה הרצאות`.
- `/repair/` HTTP 200. Markup contains `nav.ea-crumb` and the text `בית כלים ואביזרים תיקון וחידוש כלי דיג׳רידו`.
- Painted height was read on the book page only. The other two are markup, not a settled box.

## 6 · G-03 · Shows page

- URL: `http://eyalamit-co-il-2026.s887.upress.link/shows-heritage/` — HTTP 200.
- Visible body text is `ניווט משני.` The word `placeholder` is not in that body. `og:description` is `ניווט משני.`
- No new page copy was written. Closed status of A2 and E4 was not changed. Recorded as `Q-SHOWS`, waiting on Nimrod, on both surfaces.

## 7 · G-14 · Repair alts

- URL: `http://eyalamit-co-il-2026.s887.upress.link/repair/` — HTTP 200.
- Measurement: 9 `img` tags, 7 with `alt=""`. No new caption was written. Empty alts with no source sentence stay empty.
- Recorded as `Q-REPAIR-ALT`, waiting on Eyal, on both surfaces. The live form heading is `כיתוב לחמש תמונות בעמוד התיקון`.

## 8 · G-16 · Dropdowns

- URL: `http://eyalamit-co-il-2026.s887.upress.link/` — HTTP 200.
- Measurement: five `.nav__dd` openers. All five carry `aria-haspopup="true"` and `aria-expanded="false"`.
- Three remain links and keep their href: `/treatment/`, `/shop/`, `/books/`. Two remain buttons (learning, Eyal). Parent hrefs were not removed.

## 9 · G-15 · Sound button

- URL: `http://eyalamit-co-il-2026.s887.upress.link/` — HTTP 200.
- Measurement: the accessible name string `שמע — הפעלת קול בסרטון` is in the page. The visible word `שמע` is the start of that string. The visible label was not replaced.

## 10 · G-10 · Homepage FAQ — not built

Nimrod has not said how many of the 133 existing questions, or which. No new question was written. Recorded as `Q-FAQ-HOME` on both surfaces.

## 11 · G-09 · og:description

Each URL HTTP 200. `og:description` equals `meta name="description"` on that same page. No new sentence was written.

| URL | equal | length |
|---|---|---|
| `/press/` | yes | 105 |
| `/qr/` | yes | 104 |
| `/qr/qr20/` | yes | 12 |
| `/qr/qr29/` | yes | 10 |
| `/qr/qr39/` | yes | 11 |
| `/historical-articles/` | yes | 122 |

## 12 · G-08 · Canonical

- URL: `http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/` — HTTP 200, no redirect followed.
- Measurement: exactly one `<link rel="canonical" href="http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/" />`. `noindex` is still present.

## 13 · G-18 · Accessibility statement — not touched

Held until the contrast map is approved and Nimrod approves wording. Recorded as `Q-A11Y-STMT` on both surfaces.

## 14 · G-17 · The 44px sentence

No site change. The sentence in `_COMMUNICATION/team_50/R3-AA-SIGNOFF-REQUEST-2026-09-24.md` now says the drawer footer was measured at 19px, not 44px, and that the WCAG 2.2 spacing exception holds. The separate CF7 `min-height: 44px` sentence was left as it is.

## 15 · G-05 · Form persistence

- URL: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html` — HTTP 200.
- Measurement: the page states `ssotSha12 5935e526bd5d` and theme `1.5.116`. A typed note survived a full reload in the browser. The storage key is `ea-s007-form-` plus that signature.
- A probe string `PROBE-0939 שמירהX` was typed into the QR-images note in this browser, then cleared. After a reload that field is empty. The other saved notes in the same browser are still there.

## 16 · G-NEW · Contact mail — not closed

Stored recipient domain at the end of this round: `eyalamit.co.il`. Form markup still contains `your-name` (content length 707). The destination was not left on Nimrod.

| step | what was measured | receipt |
|---|---|---|
| Empty required fields | form class `invalid`. Banner: `קיימת שגיאה בשדה אחד או יותר. נא לבדוק ולנסות שוב.` Tips `נא למלא שדה זה.` on name, email, subject, each with `aria-invalid=true` and `aria-describedby` pointing at the tip. Phone and message were not required. | n/a |
| First send, while the stored recipient domain was `mezoo.co` | browser landed on `/thank-you/`. | Nimrod's phone, 2026-09-24 13:47, Inbox. Subject `אחר — פניה מטופס צור קשר באתר`. Body ends with `יעד ראשון`. From display `Eyal Amit`, to him. |
| Second send, after the stored recipient domain was `eyalamit.co.il` | browser landed on `/thank-you/` again. Message text was `בדיקת שליחה לפני הפגישה 24.9 — יעד שני`. | inbox not confirmed |

The first receipt is the phone screenshot. The second receipt, `יעד שני` at `info@eyalamit.co.il`, is still open. There is no mail-log API on this site.

## Recorded, not built, not decided

These are on both surfaces. They are Nimrod's calls.

- `Q-G04` — `/stand-floor/` and `/books/` have no work item.
- `Q-G06` — the work-data build has no separate verification.
- `Q-G07` — the 17 notes of 18.9 11:58 are not archived.
- `Q-TALK-8` — the eight talk items stay on Eyal's form (`חלק י · לשיחה — 8`). Whether to remove them is not decided.
- `Q-MOKESH-OLD` — the old Mukesh page. Drift from the start of the work. Not deleted and not rewritten. Eyal's final word is the meeting item. Nimrod approved recording it on 2026-09-24, which closes the gap.

The live form also shows the heading `לפגישה, לא למילוי` with those Nimrod rows and no inputs under them.

## Supplement — three gaps from the re-measurement

Theme header on the server file `style.css` is `1.5.117`. Asset links on `/thank-you/` carry `?ver=1.5.117`. Fetches do not follow redirects. Team 90 re-measures. This is not a sign-off.

### 17 · Double navigation on `/thank-you/`

Before the patch, `/thank-you/` was HTTP 200, body class `page-template-default`, and contained two `<nav class="nav" id="nav"`. The first sat after the skip link. The second sat immediately after the first `</nav>`.

After the patch, one request prints that partial once. Counts of `<nav class="nav" id="nav"`:

| URL | status | count |
|---|---|---|
| `http://eyalamit-co-il-2026.s887.upress.link/thank-you/` | 200 | 1 |
| `http://eyalamit-co-il-2026.s887.upress.link/contact/` | 200 | 1 |
| `http://eyalamit-co-il-2026.s887.upress.link/` | 200 | 1 |
| `http://eyalamit-co-il-2026.s887.upress.link/repair/` | 200 | 1 |
| `http://eyalamit-co-il-2026.s887.upress.link/shows-heritage/` | 200 | 1 |

Nav items, order, and `ea-canonical-nav.php` were not changed. The footer drawer is a different partial.

### 18 · Meeting rows, links and titles

`ssotSha12` is `dc9545689ecb`. The form was uploaded: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html` — HTTP 200, contains `id="Q-SHOWS"` and that signature. No new input fields.

The board file is `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html`. Each meeting question is its own `<section class="item" id="Q-…">`.

- `Q-SHOWS` links to `http://eyalamit-co-il-2026.s887.upress.link/shows-heritage/`. The bare ids are now the existing titles `הופעות ומורשת מופע` and `הופעות ומורשת מופע — מקום בתפריט`.
- `Q-FAQ-HOME` links to `/` and `/faq/`.
- `Q-A11Y-STMT` links to `/accessibility/`.
- `Q-G04` links to `/stand-floor/` and `/books/`.
- `Q-G06` has no page. No page was invented. The row stays without a page link.
- `Q-G07` links only to `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-24/MASTER-PRE-MEETING-AUDIT-2026-09-24.md`. The list of 17 notes is not in the repo.
- `Q-TALK-8` names the existing titles for M1, M2, M3, M5, M6, M7, M8, M9, each with the path already on that item. M4 stays closed and is not in the list.
- `Q-MOKESH-OLD` links to `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/`.

### 19 · Share card on `/shows-heritage/`

- URL: `http://eyalamit-co-il-2026.s887.upress.link/shows-heritage/` — HTTP 200.
- `og:description` and `meta name="description"` are the same string: `מורשת והופעות — הופעות, מופעי דיג׳רידו וסיפור המורשת של אייל עמית והמרכז לטיפול בנשימה בפרדס חנה.`
- `ניווט משני` is not in the share value. Publish status and noindex were not changed. No second `og:description` tag was added.

### Doubts — measured, recorded, not fixed

- `mokesh-eyal.jpg` on `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/` (HTTP 200) has alt `מוקש דהימן עם אייל עמית ברישיקש, הודו`.
- The same file on `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/` (HTTP 200) has alt `אייל עמית עם המאסטר מוקש דהימן ברישיקש, הודו`.
- Neither sentence was rewritten. Recorded as `Q-MOKESH-EYAL-ALT` on the form and on the board.
- `http://eyalamit-co-il-2026.s887.upress.link/services/` — HTTP 404, redirect not followed.
- The slug `services` is still in `ea_nav_drawer_orphan_slugs()` and therefore still in `ea_open_round_chrome_slugs()`. It was not removed. Recorded as `Q-SERVICES-404` on both surfaces.

## 20 · Contrast map on the board — not a build

No colour, token, scrim, or CSS was changed. Numbers were copied from `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-24/CONTRAST-MAP-2026-09-24.md`. They were not re-measured.

Board: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html#contrast`.

Contrast sections rendered: 12 addressable rows (`Q-C01`–`Q-C12`) plus the index section `id="contrast"`. Nine are the failures, worst first. Three more are what passes, borderline, and not measurable.

Representative fetches, redirects not followed:

| URL | status |
|---|---|
| `http://eyalamit-co-il-2026.s887.upress.link/sound-healing/` | 200 |
| `http://eyalamit-co-il-2026.s887.upress.link/contact/` | 200 |

Also fetched, same rule: `/press/` 200, `/lessons/` 200.

Eyal's form has one line, `Q-CONTRAST`, under «לפגישה, לא למילוי», with no input. It points at the board. The twelve rows are not on the form. Live form `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html` — HTTP 200, `ssotSha12 219df6879ce9`, contains `id="Q-CONTRAST"`, does not contain `Q-C01`.

Two figure notes, copied from the map rather than from the dispatch's shorter wording:

- Row 5 current-page range in the map is `2.43–12.71:1`. The dispatch wrote `2.43–12:1`. The board uses `12.71`.
- The map's opening sentence numbers the missing `dark` argument as item 2. The map body and this dispatch put that bug on row 3 (`/press/`, `wave2-w2-07.php:940`). The board follows the body. The bug was not fixed.

## 21 · Meeting rows left the form

team_00: the form is only what Eyal finishes alone at home. Meeting rows stay on the board.

Live form `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html` — HTTP 200, `ssotSha12 fdff72aef859`. The heading `לפגישה, לא למילוי` is absent. `data-id="M1"` is absent.

The eleven rows on that form, each with at least one option that hands something over:

`A3`, `A5`, `B2`, `B3`, `C1`, `C3`, `P037`, `Q-HERO-ASK`, `Q-REPAIR-ALT`, `M8`, `M9`.

`M8` still offers `אשלח סרטונים או קישורים`. `M9` still offers `אשלח את קובץ המוזיקה`. They sit under `קבצים לשליחה`, not under `לשיחה`.

`M1`, `M2`, `M3`, `M5`, `M6`, `M7` are off the form. They are still sections on `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html`. Wording, options, `waitingOn`, and status were not changed. Nothing was marked closed.

The same board still has the meeting questions, including `Q-SHOWS`, `Q-FAQ-HOME`, `Q-A11Y-STMT`, `Q-G04`, `Q-G06`, `Q-G07`, `Q-TALK-8`, `Q-MOKESH-OLD`, `Q-MOKESH-EYAL-ALT`, `Q-SERVICES-404`, and the twelve contrast rows. `Q-CONTRAST` is on the board only.

Two gaps that were defined and had no row are now on the board only:

- `Q-IOS-ZOOM` — form fields are 13.6px; iPhone zooms a field under 16px. The type canon locks the token. Not a build.
- `Q-MAIL-2` — the first test arrived. The second, to `info@eyalamit.co.il`, has no confirmed receipt. The recipient was not changed and no further test was sent.

## 22 · Two controls that could not carry the answer

`Q-REPAIR-ALT` stays on the form. It now shows five photographs and five empty text fields, one per file: `EA-000239`, `EA-000298`, `EA-000214`, `EA-000238`, `EA-000220`. No caption was written, including no placeholder. Two of the files fetched live: `EA-000239.jpeg` HTTP 200, `EA-000298.jpg` HTTP 200.

`P037` stays on the form. Its old options were `מאושר` / `יש הערה`, which cannot say "I will send one" or "there isn't one". The title was not rewritten. The options are now `אשלח תמונה` and `אין תמונה`, taken from the existing stamp `אייל ישלח אם יש`.

## `/services/` is not a meeting item

The 404 is the close from 2026-09-21. Eyal chose delete. Nimrod approved unpublish with no redirect. `Q-SERVICES-404` was removed from the board. It was not a decision.

The leftover was the slug `services` still named in `ea_nav_drawer_orphan_slugs()` and the fallback list in `ea_open_round_chrome_slugs()`. That slug is gone. Theme header on the server is `1.5.118`.

Re-measured, redirects not followed:

- `http://eyalamit-co-il-2026.s887.upress.link/services/` — HTTP 404, no `Location`.
- `http://eyalamit-co-il-2026.s887.upress.link/services/didgeridoo-lessons/` — HTTP 301 to `/lessons/`. The child redirect was left as it was.
