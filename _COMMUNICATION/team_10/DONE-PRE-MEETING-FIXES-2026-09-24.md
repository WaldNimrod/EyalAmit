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
