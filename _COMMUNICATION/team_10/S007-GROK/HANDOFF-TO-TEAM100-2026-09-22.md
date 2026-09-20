# HANDOFF TO TEAM 100 — S007-GROK four items · 2026-09-22

**Builder:** this Grok line, team 10, working with Nimrod (team_00).  
**Audit:** a separate Claude line, Tuesday night 2026-09-22. Builder engine ≠ validator engine.  
**Staging:** http://eyalamit-co-il-2026.s887.upress.link (HTTP; TLS invalid by design).  
**Theme after this work:** 1.5.93 · commit `69dea0a` (sound) then this handoff commit.

**If a task is incomplete, it is said here.** Silent gaps are the failure mode this file exists to prevent.

---

## TASK 4 — sound toggle

**Status:** code shipped and re-measured live. **Nimrod has not yet approved it in his own words in this session.** Asked in chat. Until that quote exists, do not treat the ruling as closed on the human side.

**What changed:** `id="soundtg"` left the nav and the mobile drawer. It now renders only on the home hero, and only when that hero has a `<video>`. Files, before/after counts, box-model numbers, and the 157-URL sweep are in:

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/DONE-SOUND-TOGGLE-2026-09-22.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/DONE-SOUND-TOGGLE-2026-09-22.md)

**Live evidence (this session, GET, no follow-redirect):**

- http://eyalamit-co-il-2026.s887.upress.link/ — 200, one `<video>`, one `#soundtg` as `.hero__sound`, not inside `nav`, JS 1.5.93.
- http://eyalamit-co-il-2026.s887.upress.link/method/ — 200, zero `#soundtg`, zero `.ea-nd__sound`.
- Same zero on `/accessibility/`, `/privacy/`, `/terms/`.
- Sitemap TSV 157 paths: `<video>` and `#soundtg` only on `/`. 141 × 200. 16 × 301 (legacy aliases already in the TSV — recorded as 301, not dressed as 200).

**Rendered (CDP after layout, not a pre-layout zero):** desktop 74.57×44 px, phone 375 74.57×44 px, inside the video, no overlap with H1/CTA/cue spans, `aria-pressed` flips on click, Tab shows a visible `:focus-visible` ring.

**Nimrod, verbatim, so far:** the defect ruling of 2026-09-20 — «לא תקין - צריך להופיע רק כשיש סרט ותמיד על הסרט או צמוד אליו.» Approval of the *fix* is still outstanding.

**Deliberately not done:** Wave2 `.ea-sound-toggle` (ambient audio, not live in nav); mokesh unmute (already on its media); no `--allow-dirty`; no paste to legal pages; no claim that extra `<nav>` counts on `/press/` `/about/` `/faq/` are this change.

---

## TASKS 1–3 — three legal research reports (R2-003, R2-016, R2-022)

**Status:** the three HTML files exist. **Nothing was pasted into the live legal pages.** That is a pass/fail gate and it passed: `/accessibility/`, `/privacy/`, `/terms/` still carry the WP-EI-05 draft banner; privacy/terms still say «יולי 2026»; accessibility still says «פועלים לפי» from the 18.9 statement, which this session did not edit.

**Files:**

- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-ACCESSIBILITY-2026-09-22.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-ACCESSIBILITY-2026-09-22.html)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-PRIVACY-2026-09-22.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-PRIVACY-2026-09-22.html)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-TERMS-2026-09-22.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/REPORT-TERMS-2026-09-22.html)

**Live evidence used in the reports (2026-09-20, GET, no follow-redirect):**

| URL | status | what was observed |
|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/accessibility/ | 200 | H1 הצהרת נגישות; «פועלים לפי»; באנר טיוטה; רכז בלי שם; WP Accessibility טעון; GA4 `G-MRXESK7QJF` |
| http://eyalamit-co-il-2026.s887.upress.link/privacy/ | 200 | באנר טיוטה; «יולי 2026»; «עשוי… Google Analytics» while GA4 is actually on; no cookie banner; no Set-Cookie |
| http://eyalamit-co-il-2026.s887.upress.link/terms/ | 200 | באנר טיוטה; «חשבונית ירוקה» + «מחוז המרכז»; no checkout on `/shop/` |
| http://eyalamit-co-il-2026.s887.upress.link/contact/ | 200 | one CF7 form: name, phone, email, subject, message; no reCAPTCHA |
| http://eyalamit-co-il-2026.s887.upress.link/shop/ | 200 | catalogue, no WooCommerce / add-to-cart |
| http://eyalamit-co-il-2026.s887.upress.link/learning/courses-external/ | 200 | placeholder, no purchase URL |

**Nimrod's approval of the reports:** not yet. Sequence remains: research → his feedback → (implementation = revise the reports, not the site) → his approval → only then Eyal. **No `GO-W4-PASTE`.**

**Plugin recommendation (accessibility):** keep WP Accessibility (already installed). Not an overlay. Not Enable Accessibility. Not a from-scratch widget. Stated in the accessibility report with sources.

---

## What this line did not do, on purpose

- Did not paste a sentence, heading, or FTP of `accessibility-defaults.php` / `privacy-defaults.php` / `terms-defaults.php`.
- Did not open or commit `local/`.
- Did not edit `_aos/`.
- Did not `git add -A`.
- Did not invent Eyal copy.
- Did not wait for a cross-engine self-audit (Claude does that Tuesday).
- Did not invent Nimrod's approval quotes. Where he has not spoken, the file says so.

---

## Ownership of the next step

- **Nimrod:** (1) approve or reject the live sound button in his own words; (2) read the three HTML reports and give feedback. Still no paste.
- **This builder:** revise reports against that feedback if he gives it before Tuesday; paste only on an explicit `GO-W4-PASTE`.
- **Team 100 / Claude audit Tuesday:** read this file first.
