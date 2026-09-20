# HANDOFF TO TEAM 100 — S007-GROK four items · 2026-09-22

**Builder:** this Grok line, team 10, working with Nimrod (team_00).  
**Attacker (reports):** a separate GPT-5.2 session, 2026-09-20. Builder engine ≠ validator engine.  
**Audit Tuesday:** a separate Claude line.  
**Staging:** http://eyalamit-co-il-2026.s887.upress.link (HTTP; TLS invalid by design).  
**Theme after legal paste:** 1.5.94.

Silent gaps are the failure mode this file exists to prevent.

---

## TASK 4 — sound toggle

**Status:** shipped, re-measured, **approved by Nimrod in his own words.**

**Nimrod, verbatim, 2026-09-20:** «שמע בדף הבית נראה סבבה, יש לוודא שהוא מופיע רק היכן שיש וידאו או סאונד.»  
Earlier defect ruling: «לא תקין - צריך להופיע רק כשיש סרט ותמיד על הסרט או צמוד אליו.»

**Live re-measure after that ruling (GET, no follow-redirect, 156 sitemap URLs, all 200):**

| Marker | Count | Where |
|---|---|---|
| `<video>` | 1 | `/` |
| `#soundtg` / `.hero__sound` | 1 | `/` (on the hero video) |
| `.nav__tg` / `.ea-nd__sound` / `.ea-sound-toggle` | 0 | — |
| `.mokesh-hero__unmute` | 2 | `/about/moksha/`, `/eyal-amit/mokesh-dahiman/` (YouTube on the hero) |
| `<audio>` | 0 | Wave2 ambient file is not in the theme |

QR pages have YouTube iframes with the player’s own controls — not our שמע button.

Evidence file: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/DONE-SOUND-TOGGLE-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/DONE-SOUND-TOGGLE-2026-09-22.md)

---

## TASKS 1–3 — legal reports, attack cycle, then paste

**Nimrod, 2026-09-20, process change (verbatim intent):** validation against an attacking sub-session, correction until approved, **then paste to the site** and send to Eyal for final approval **by adding a section to the form sent today** — the last active form, not old addenda.

**Attacker verdict (GPT-5.2, live GET):**

- Accessibility page: **APPROVE-PASTE** = keep the 18.9 live statement. Do not paste the research HTML.
- Privacy: **REJECT** July text (GA4 as “may”, GDPR-like deletion, checkout language).
- Terms: **REJECT** Green Invoice as fact + «מחוז המרכז».

**What was pasted (theme 1.5.94), banner WP-EI-05 kept until Eyal:**

- `/accessibility/` — unchanged 18.9 text.
- `/privacy/` — new defaults: operator אייל עמית; GA4 `G-MRXESK7QJF` named; Google Fonts noted; rights = §§13–14 only; no cart.
- `/terms/` — new defaults: no checkout; דיני ישראל without a district; no blanket body-injury waiver.

Reports (updated after the attack):

- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-ACCESSIBILITY-2026-09-22.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-ACCESSIBILITY-2026-09-22.html)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-PRIVACY-2026-09-22.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-PRIVACY-2026-09-22.html)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-TERMS-2026-09-22.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-TERMS-2026-09-22.html)

---

## Form sent to Eyal (the active one, not an old addendum)

**Source:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html)

**Live:** http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html

Added **חלק ח** — L1 `/accessibility/`, L2 `/privacy/`, L3 `/terms/`. Existing item IDs unchanged. Not `s006-review.html` (round 1) and not `s006-r2-review.html`.

Hub publish of this file is a **single-file upload**. Full `build_eyal_client_hub.py` would strip the three home-page links (see the form README).

---

## What this line did not do

- Did not name an accessibility coordinator without Eyal’s OK.
- Did not invent a cookie-banner statute or a GDPR erasure right.
- Did not open or commit `local/`. Did not edit `_aos/`. Did not `git add -A`.
- Did not run a full hub rebuild (would drop the form’s hub-home links).

---

## Ownership of the next step

- **Eyal:** mark L1/L2/L3 on the live form.
- **This builder:** after his JSON — remove banners only where he said אושר; apply any correction notes.
- **Team 100 / Claude Tuesday:** read this file first.
