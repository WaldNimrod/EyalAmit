---
id: A11Y-LEGAL-AUDIT-2026-09-17
line: team_10 (Sonnet) · prefix A11Y-LEGAL
mandate: _COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/00-BRIEF-SHARED.md
scope: the accessibility statement, the Israeli regulatory duties, the plugin question, documentation vs. reality
status: READ-ONLY AUDIT — no site/ files touched. Not legal advice.
---

# A11Y-LEGAL — Statement, Regulatory Duties, the Plugin Question, and the Documentation Gap

**This is not legal advice.** It is a technical/documentary audit of what the Israeli accessibility
framework appears to require, and how the current site and project records measure up against it. Before
relying on this for a launch decision, the regulations and their exemptions should be confirmed with a
lawyer or accessibility professional against the current official text — this report tells you where to
look and what it found, not what a court would rule.

## 1. Scope and what I actually ran

**Environment:** staging `http://eyalamit-co-il-2026.s887.upress.link` (HTTP 200; TLS invalid by design,
not a defect). Production `https://www.eyalamit.co.il/` (HTTP 200 for `/`, **404** for `/accessibility/` —
reconfirmed live with `curl -s -o /dev/null -w '%{http_code}'` at 2026-09-17). Repo branch at audit time:
`s006/tracker-integrity` (theme `style.css:7` → `Version: 1.5.37`).

**Commands / tools used, in order:**
- `git log`, `git show`, `git diff`, `git merge-base --is-ancestor`, `git rev-list --count`, `git branch --contains` — repeatedly, against `HEAD`, `main`, `origin/main`, `feat/s006-a11y-close`, `origin/feat/s006-a11y-close`, and specific commits (`07c65b5`, `fabd106`, `887d270`, `e480ba8`) — all on 2026-09-17.
- `grep -rn` / `find` across `site/wp-content/themes/ea-eyalamit/`, `_COMMUNICATION/`, `docs/` for the statement source, the skip-link/footer/contrast CSS, the CF7 template, and every prior accessibility-related report and mandate.
- `curl -s -o /dev/null -w '%{http_code}'` against the four URLs above — 2026-09-17.
- Live browser (Claude Browser pane, isolated tab `tab-1` after discovering the shared "seed" tab was being driven by a concurrent session — see §9): `read_page`, `get_page_text`, `javascript_tool` (DOM/CSS/computed-style queries — headings, `alt` coverage, landmark counts, contrast-ratio computation, live skip-link focus test), `computer` (screenshot, click, key), all against `/`, `/accessibility/`, `/contact/`, and `https://www.eyalamit.co.il/` — 2026-09-17, viewport confirmed non-zero (1024×768) before trusting any measurement.
- `WebSearch` / `WebFetch` against nevo.co.il, kolzchut.org.il, gov.il, sii.org.il, isoc.org.il, w3.org, overlayfactsheet.com, and several commercial accessibility-vendor blogs (flagged as such throughout) — all read 2026-09-17.

**Page set actually touched:** `/`, `/contact/`, `/accessibility/`, and (read-only, DOM/JS checks) the production home page. I did not run the full page-set matrix (`/treatment/`, `/faq/`, `/shop/`, `/blog/`, `/en/`, `/qr/`, a book page) myself — my mandate is the statement/legal/plugin/docs axis, not a page-by-page WCAG sweep, and other lines are covering that ground. Where I generalize beyond what I directly measured, I say so.

---

## 2. Master findings table

Severity is tied to a named WCAG 2.0 success criterion where one applies; where the issue is a regulatory
or documentation-integrity matter rather than a WCAG failure, it is labelled **"not a 2.0 AA failure —
regulatory/documentation issue"** per the brief's rule 4.

| ID | Severity | WCAG 2.0 SC / nature | Measured / inferred | Evidence | User / owner impact |
|---|---|---|---|---|---|
| A11Y-LEGAL-01 | High | not a 2.0 AA failure — statement-integrity issue | Measured | `accessibility-defaults.php:34` + `:37-43` (quoted §4.2) | A visitor (or regulator) reads a flat, unqualified compliance-style claim with no disclosure that no independent audit has ever signed it off |
| A11Y-LEGAL-02 | Medium-High | not a 2.0 AA failure — reg. 35ה completeness | Measured | `accessibility-defaults.php:58` (quoted §4.2) | No named human to contact; only a phone number under a generic title |
| A11Y-LEGAL-03 | High (blocks everything else) | not a 2.0 AA failure — reg. 35ה validity | Measured (live DOM, `region[status]` banner) | live `/accessibility/`, WP-EI-05 banner text (quoted §4.2) | The page that exists today is a draft, not a statement with legal force |
| A11Y-LEGAL-04 | Low / informational | not a 2.0 AA failure | Measured | `git log -1 --format=%ad -- .../accessibility-defaults.php` → `Wed Jul 15 16:43:28 2026` | The "July 2026" date is accurate to file history, but several of its claims were asserted before the code that makes them true actually shipped (see §4.3) |
| A11Y-LEGAL-05 | — (found correct) | reg. 35ה "prominent place" | Measured (3 pages sampled) + inferred (shared template) | footer link present on `/`, `/contact/`, `/accessibility/` via shared `section-footer.php` | Statement is reachable, not buried |
| A11Y-LEGAL-06 | High, but **pre-launch only** | not a 2.0 AA failure — reg. 35ה existence | Measured | `curl` → production `/accessibility/` = 404, 2026-09-17 | Zero live exposure today; full exposure the moment content goes to production as-is |
| A11Y-LEGAL-07 | Medium | not a 2.0 AA failure — reg. 35ד / round-3 DoD item 6 | Measured | `accessibility-defaults.php:45-51` (quoted §4.2) — no caption/media policy sentence anywhere in the file | Visitor relying on captions for embedded video gets a vague "we keep improving," not a stated policy |
| A11Y-LEGAL-08 | — (found correct) | not a 2.0 AA failure — reg. 35ו discipline | Measured | full text of `accessibility-defaults.php` read in full — no exemption/turnover language anywhere | Correctly avoids a claim nobody can currently support |
| A11Y-LEGAL-09 | — (found correct) | 1.3.1 Info and Relationships / 2.4.6 Headings and Labels | Measured (live DOM, home + statement page) | `h1→h2→h3→h2…` on `/`, single `h1` + ordered `h2`s on `/accessibility/` — no skipped levels | Statement's "heading hierarchy" claim holds on the pages tested |
| A11Y-LEGAL-10 | — (found correct, with a quality caveat) | 1.1.1 Non-text Content | Measured (live DOM, `/`) | 42/42 `<img>` have an `alt` attribute; 41 carry real Hebrew text; the 1 empty one sits inside `aria-hidden="true"` | Statement's "alt text" claim holds; but 30 of the 41 (the `#peek` gallery) share the identical string "הצצה לחוויה בסטודיו" — technically compliant, weak in practice |
| A11Y-LEGAL-11 | — (found correct, sampled only) | 1.4.3 Contrast (Minimum) | Measured (live, computed) | `.foot__disc` (`section-footer.php:48`) → **7.74:1**; `.foot__col-title` → **~7.06:1**, both against resolved background `rgb(14,9,5)` | The one contrast pair with a documented history of trouble now passes comfortably; I did not audit contrast site-wide or on mobile (see §7) |
| A11Y-LEGAL-12 | — (found correct, after correcting my own false negative) | 2.1.1 Keyboard / 2.4.7 Focus Visible / 2.4.1 Bypass Blocks | Measured (live, after fixing methodology — see §9) | `.ea-skiplink` is the first focusable element; `href="#main"` resolves to `header.php:75`; once the document genuinely has focus, `:focus`/`:focus-visible` correctly render `position:fixed;top:12px;z-index:100000` (`ea-atoms.css:88-89`, `chapters.css:656-657`) | A real keyboard user gets a working, visible skip link. My first measurement attempt wrongly said otherwise — see §9, a trap worth naming for the other lines |
| A11Y-LEGAL-13 | Low (documentation gap, not a defect found) | 1.3.1 Info and Relationships / 4.1.2 Name, Role, Value | Measured landmarks; **could not measure** screen-reader usability | live accessibility tree: exactly one `main`, `nav`, `header/banner`, `footer/contentinfo` on the pages sampled | Landmark structure is sound; nobody has actually driven this with VoiceOver or NVDA — the statement's "screen-reader support" clause is unverified, not falsified |
| A11Y-LEGAL-14 | — (found correct) | 2.4.1 Bypass Blocks | Measured | live DOM query for any element whose text matches `/דלג\|skip/i` on `/accessibility/` → exactly one match (`.ea-skiplink`) | The historical duplicate-skip-link defect (two competing "skip to content" links) is gone |
| A11Y-LEGAL-15 | Low (corrects a documentation assumption) | not a 2.0 AA failure — factual correction | Measured | live `window.wpa` config object, `/accessibility/`: `skiplinks.enabled:false` | WP Accessibility is active but its *own* skip-link feature is switched off; the working skip link is 100% custom theme code, not the plugin — several internal docs imply otherwise |
| A11Y-LEGAL-16 | High (recommendation-level) | not a 2.0 AA failure — conformance-method question | Inferred from external evidence + one live example on Eyal's own production site | FTC v. accessiBe (2025); Overlay Fact Sheet (1,031+ signatories); W3C WAI list discussion; live production `eyalamit.co.il` running "WP Accessibility Helper" v1.0.0/0.5.9.4 (screenshot + DOM, §5.2) | Installing an overlay/toolbar would not create IS 5568/WCAG 2.0 AA conformance and could increase legal exposure if the statement leaned on it |
| A11Y-LEGAL-17 | — (found correct, contradicts a plausible fear) | not a 2.0 AA failure — process/governance | Measured (git) | `git merge-base --is-ancestor 07c65b5 HEAD` → yes; commit `887d270` + merge `e480ba8`, 2026-09-06 | The `feat/s006-a11y-close` accessibility work is **not** stranded — it is live in the current tree today |
| A11Y-LEGAL-18 | High (live, present-tense risk) | not a 2.0 AA failure — deployment-safety issue | Measured (git) | `main`/`origin/main` `style.css:7` → `Version: 1.5.15`; `git rev-list --count main..HEAD` → 57; `git merge-base --is-ancestor e480ba8 main` → no | `main` still lacks every accessibility fix made since 26.8. A deploy from `main` today would silently regress the live site |
| A11Y-LEGAL-19 | Low (documentation-accuracy flag) | not a 2.0 AA failure — record accuracy | Measured (git) vs. quoted doc | `HANDOFF-CURRENT-S006.md` line asserting "ענף `origin/feat/s006-a11y-close` **1.5.20**" vs. `git show feat/s006-a11y-close:.../style.css` → `1.5.17` | Immaterial today (the substance was captured elsewhere), but the state doc's own claim about branch version does not hold up |
| A11Y-LEGAL-20 | — (found correct, closes an open W4-draft concern) | 1.3.1 / 4.1.2 | Measured (live DOM, `/contact/`) | exactly one `<form>` on the live page, `class="wpcf7-form ea-contact-form__form"` | The CF7-vs-native duplicate-form concern raised in `DRAFT-R2-003-ACCESSIBILITY-2026-08-25.md` §2 no longer reproduces |
| A11Y-LEGAL-21 | Medium (documentation gap) | not a 2.0 AA failure — round-3 DoD tracking | Measured (repo search) | see §6.4 — no WCAG matrix, no VoiceOver/NVDA session log, no mobile-contrast evidence, and only the *brief* (not the report) exists in `_COMMUNICATION/team_50/` | Four of the round-3 Definition-of-Done's nine items have no evidence anywhere in the repo |

---

## 3. Part 1 — What the regulations actually require of this business

**Framework, named:** Equal Rights for Persons with Disabilities Law, 5758-1998 (חוק שוויון זכויות
לאנשים עם מוגבלות, התשנ"ח-1998) is the parent statute. The operative subsidiary legislation for a
website is the Equal Rights for Persons with Disabilities (Accessibility Adjustments to Service)
Regulations, 5773-2013 (תקנות שוויון זכויות לאנשים עם מוגבלות (התאמות נגישות לשירות),
התשע"ג-2013), whose internet-service provisions (§§35א–35ו) were substituted/added by the 5778-2017
amendment. Binding technical standard: **IS 5568, level AA = WCAG 2.0 AA** — confirmed independently
(not just taken on the brief's word) from the Standards Institution's own publication and the
government's own hosted copy of the standard:
- [ת"י 5568 חלק 1 — קווים מנחים לנגישות תכנים באינטרנט (gov.il, hosted PDF)](https://www.gov.il/BlobFolder/legalinfo/israeli_accessibility_standards_pdf/he/sitedocs_si-5568-1-september-2023.pdf) — read 2026-09-17 (linked from search; I read the search index's description of the standard's scope and WCAG-2.0-AA basis, not the full PDF body).
- [ת"י 5568 חלק 2 (sii.org.il, Standards Institution of Israel)](https://www.sii.org.il/media/2491/si-5568-2.pdf) — read 2026-09-17, same caveat.
- Corroborated by [tabnav.com's guide](https://tabnav.com/he/info-center/accessibility-standard-5568-israel-law) (read 2026-09-17) — **flagged as a commercial accessibility-widget vendor**, used here only as a secondary corroboration of a point already established by the two links above, never as the primary source.

I was not able to open the full text of either gov.il/sii.org.il PDF inside this session (only their
titles and the search engine's description of their contents came back); this is a "verify further"
flag, not a claim that I read the standard cover to cover. **Nothing in this audit found any conflict**
on the AA-level/WCAG-2.0 point — every source, official and commercial alike, agrees. The brief's
premise that WCAG 2.1/2.2 are testing tools, not the Israeli legal minimum, is correct on this evidence and
I found nothing to contradict it.

### 3.1 The core internet-service duty (regulation 35א)

The primary legal-database source for the regulation text — [nevo.co.il, תקנות שוויון זכויות לאנשים עם
מוגבלות (התאמות נגישות לשירות), תשע"ג-2013](https://www.nevo.co.il/law_html/law01/500_865.htm), read
2026-09-17 (fetched and summarized in this session; Nevo is Israel's standard consolidated-legislation
database used throughout the legal profession, but it is a private company's product, not the
government's own Reshumot gazette — treat it as highly reliable secondary text, not the primary
official instrument) — gives regulation 35א(א) as, in substance: a duty-bearer ("חייב") must supply
accessibility adjustments to an internet service, and must meet WCAG-AA per IS 5568 ("תקן נגישות
אינטרנט"), operative from **26 October 2017**.

"חייב" (duty-bearer) is the term the parent 2013 regulations use for anyone providing a service to the
public — which on its face covers essentially **any business with a public-facing website**, this one
included. There is no floor built into 35א itself; the floor comes only from the specific exemptions in
35ו (§3.3 below). **A small private business running an informational site is, by default, inside the
duty — not outside it — unless a specific exemption applies and is properly established.**

### 3.2 What regulation 35ה requires the statement to contain

From the same Nevo text, regulation 35ה requires the duty-bearer to state, at a **prominent place** on
the site, an accessibility statement that includes:
1. the accessibility adjustments actually carried out ("התאמות נגישות שביצע");
2. the details of the accessibility coordinator and how to reach them, **if the duty-bearer is
   independently required to appoint one under law** ("פרטי רכז נגישות ודרכי ההתקשרות עמו... אם חייב
   במינויו לפי דין" — this is a conditional clause, see §3.5);
3. a way to contact the business specifically to report an absence of accessibility adjustments.

This is corroborated (not contradicted) by [kolzchut.org.il — הנגשת אתרי אינטרנט ואפליקציות לאנשים עם
מוגבלות (הליך)](https://www.kolzchut.org.il/he/%D7%94%D7%A0%D7%92%D7%A9%D7%AA_%D7%90%D7%AA%D7%A8%D7%99_%D7%90%D7%99%D7%A0%D7%98%D7%A8%D7%A0%D7%98_%D7%95%D7%90%D7%A4%D7%9C%D7%99%D7%A7%D7%A6%D7%99%D7%95%D7%AA_%D7%9C%D7%90%D7%A0%D7%A9%D7%99%D7%9D_%D7%A2%D7%9D_%D7%9E%D7%95%D7%92%D7%91%D7%9C%D7%95%D7%AA), read
2026-09-17 — **kolzchut is a respected nonprofit legal-rights information service (כל-זכות), not a
government body and not a commercial accessibility vendor**; I am treating it as a reliable
secondary/plain-language source, one notch below Nevo's regulation text and well above a vendor blog.
Kolzchut's summary matches Nevo on the statement's required content but is less precise about the AA
level (it names IS 5568 Part 1 without stating "AA" explicitly) — where the two differ in precision,
I have followed the more specific and more authoritative one (Nevo's regulation text plus the standard's
own AA labelling), consistent with the brief's instruction to prefer official sources over general
summaries.

### 3.3 Why we cannot rely on a 35ו exemption

Regulation 35ו carries two size-based carve-outs, both confirmed via Nevo and independently corroborated
by [kolzchut.org.il — פטור מחובת הנגשה לאתרי אינטרנט ואפליקציות](https://www.kolzchut.org.il/he/%D7%A4%D7%98%D7%95%D7%A8_%D7%9E%D7%97%D7%95%D7%91%D7%AA_%D7%94%D7%A0%D7%92%D7%A9%D7%94_%D7%9C%D7%90%D7%AA%D7%A8%D7%99_%D7%90%D7%99%D7%A0%D7%98%D7%A8%D7%A0%D7%98_%D7%95%D7%90%D7%A4%D7%9C%D7%99%D7%A7%D7%A6%D7%99%D7%95%D7%AA) (read
2026-09-17):

- **35ו(ז):** a duty-bearer who is a VAT-exempt dealer ("עוסק פטור", a defined small-business tax status
  under the VAT Law 5735-1975) **or** whose average annual turnover does not exceed **100,000 NIS** is
  exempt from the internet-service adjustments entirely.
- **35ו(ט):** a duty-bearer whose average turnover does not exceed **1,000,000 NIS** is exempt, but
  **only** for a website that was already operating **before** the 2017 amendment took effect, and only
  if the business publishes accessible contact details; this exemption must be renewed every three years.

**Neither exemption can be invoked here, on the facts I have.** I have no turnover figure for Eyal's
business from any source in this repo, and none was supplied to me. The brief is explicit that I must
never assume one, and I have not. Separately, even if a turnover figure existed and supported 35ו(ט), it
would only reach the *old* production site (live since roughly 2001, per its own footer) — **not** the
new 2026 build, which is a new website and therefore falls outside 35ו(ט) by its own "before the 2017
amendment" test regardless of turnover. This matches the conclusion team_100 already reached internally
(`SUMMARY-S006-ACCESSIBILITY-2026-08-26.md`, "דין ישראלי" section) — I independently verified it against
Nevo rather than simply trusting that document, and it holds up.

**Practical bottom line for Part 1's exemption question:** the honest, defensible statement is that no
exemption is currently known to apply, not that one has been ruled out by calculation — those are
different claims, and only the first is currently true.

### 3.4 Does the video-captioning duty (35ד) reach this business?

Nevo's text of 35ד(א) ties the captioning duty to **either** being a public authority ("רשות ציבורית")
**or** having an average turnover **exceeding 5,000,000 NIS**. Kolzchut's page on internet accessibility
independently names the same 5-million-NIS figure for video, which is a useful cross-check since it is
a different source repeating the same number.

Every internal project document describes this as a small private treatment/service business (a single
named practitioner, "המרכז לטיפול בדיג'רידו"). Nothing in the repo suggests turnover anywhere near
5,000,000 NIS, and nothing suggests it is a public authority. **On the facts available, 35ד's captioning
duty is very unlikely to reach this business** — but this is an inference from the business's apparent
scale, not a confirmed number, and I flag it as such rather than asserting it outright. What *is*
confirmed is that the statement should not promise captions it has no duty (and, per the "מגבלות" section
it already writes for itself, no settled plan) to provide — see A11Y-LEGAL-07.

### 3.5 The accessibility-coordinator duty

There appear to be **two distinct duties** here and conflating them would overstate what applies:

1. **A general organizational duty to appoint an accessibility coordinator** (רכז/מורשה נגישות), which
   multiple sources — consistently — tie to organizations with **25 or more employees**:
   [aisrael.org — קורס רכזי נגישות: חובה לכל ארגון המונה 25 עובדים ומעלה](https://www.aisrael.org/?CategoryID=877&ArticleID=67266)
   and [biznagish.co.il](https://biznagish.co.il/%D7%A8%D7%9B%D7%96-%D7%A0%D7%92%D7%99%D7%A9%D7%95%D7%AA/), both
   read 2026-09-17. **Both of these are commercial vendors that sell accessibility-coordinator training
   courses or coordinator services** — I am flagging that conflict of interest explicitly, per the
   brief's instruction, even though the specific "25 employees" figure they cite is a plausible, oft-repeated
   reading of the general regulations and I found no source disputing it. I could not independently
   confirm the exact clause number for this general appointment duty against Nevo in this session
   (it sits in a different part of the regulatory scheme than the internet-service sections I fetched) —
   **this specific threshold should be treated as inferred/secondary-sourced, not primary-verified.**
2. **The narrower, conditional duty inside regulation 35ה itself** (§3.2 above): the *statement* must
   name a coordinator and contact method **only if** the business is independently required to appoint
   one under law. If duty (1) does not attach — which is likely for what every project record describes
   as a single-practitioner operation, though I have no confirmed headcount — then the statement is not
   legally required to name a formal "רכז נגישות" in the coordinator sense. It is, however, still required
   to give "פרטים לפנייה" — a real contact channel for reporting an accessibility problem — regardless of
   organization size, and that duty is unconditional under 35ה.

**What this means for the current statement:** the phone-only "רכז נגישות" section (`accessibility-defaults.php:53-59`)
may be *more* than what 35ה strictly requires if the coordinator-appointment duty doesn't attach at
all — but it is also *less* than best practice, since it presents itself as identifying a coordinator
without naming one. The clean fix, which several team_100 drafts already proposed and never pasted, is
to either name Eyal explicitly as the contact (with his consent) or drop the "coordinator" framing and
keep it as a plain "contact us about accessibility" channel — either is defensible; leaving a named role
with no name is not.

### 3.6 Distinguishing official from commercial sources — summary

| Source | Type | Used for |
|---|---|---|
| nevo.co.il | Private, but the standard consolidated-legislation database used by the Israeli legal profession | Primary regulation text (35א, 35ד, 35ה, 35ו) |
| gov.il (hosted IS 5568 PDFs) | Official government hosting of the Standards Institution's own publication | Confirming IS 5568 = WCAG 2.0 AA |
| sii.org.il | The Standards Institution of Israel itself | Same |
| gov.il (Ministry of Justice — Commission for Equal Rights of Persons with Disabilities landing page, `moj_disability_rights`) | Official government body | Identifying the correct regulator/complaint channel; I did not extract page-specific operative guidance text from it in this session |
| kolzchut.org.il | Nonprofit legal-rights information service, no commercial stake in accessibility remediation | Secondary corroboration of the statement-content and exemption rules |
| aisrael.org, biznagish.co.il, tabnav.com | **Commercial** accessibility vendors/trainers | Used only for points already established elsewhere, with the conflict of interest flagged; never as sole authority |

---

## 4. Part 2 — The statement, line by line against reality

### 4.1 Source and live status

Source: `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/accessibility-defaults.php` (70 lines,
read in full). Live at `http://eyalamit-co-il-2026.s887.upress.link/accessibility/` — confirmed HTTP 200,
2026-09-17. Production `https://www.eyalamit.co.il/accessibility/` — confirmed HTTP 404, 2026-09-17.
**Every finding below is a before-launch finding on staging** — production carries none of this content
today (A11Y-LEGAL-06).

### 4.2 The text, and what it actually asserts

The file's own top comment (`accessibility-defaults.php:2-5`) calls it a "PLACEHOLDER" whose final
wording is "pending Eyal / legal review" — that framing is honest. What is published to the browser,
though, does not carry that same hedge in the same words; it carries a separate, narrower "draft" banner
(next point).

**The draft banner (WP-EI-05), `accessibility-defaults.php:22-28`,** live text (quoted verbatim, Hebrew,
via `read_page`):
> "ממתין לאישור" / "נוסח משפטי — טיוטת צוות, טרם אושרה סופית" / "הנוסח שלהלן נכתב על ידי הצוות כטיוטה
> עניינית ושמישה. הוא ממתין לבדיקה ולאישור סופיים של אייל / ייעוץ משפטי לפני שייחשב מחייב (WP-EI-05)."

This is doing real legal work: it is the thing that currently makes the page a draft rather than a
binding 35ה statement (A11Y-LEGAL-03). **Do not remove it** — the brief already prohibits this and I
agree with the prohibition on the evidence: removing it would convert an internal draft into what reads
as a final, approved legal statement without anyone having actually approved it.

**The commitment paragraph, `accessibility-defaults.php:34`:**
> "המרכז לטיפול בדיג׳רידו רואה חשיבות רבה במתן שירות שוויוני לכלל הלקוחות, ופועל להנגיש את האתר כך שיהיה
> זמין ונוח לשימוש גם עבור אנשים עם מוגבלות. הנגשת האתר נעשית בהתאם לתקנות שוויון זכויות לאנשים עם
> מוגבלות (התאמות נגישות לשירות), התשע״ג-2013, ולתקן הישראלי ת״י 5568 המבוסס על הנחיות WCAG 2.0 ברמת AA."

This names the correct regulation and the correct standard (both verified independently in Part 1) — that
part is accurate. The verb is "פועל להנגיש" (works to make accessible) and "נעשית" (is being done) —
process language, not "עומדים בתקן" (we conform). That is the right register for a business with no
completed independent audit, and it is *better* than the flat conformance claim the round-3 plan
(`PLAN-S006-A11Y-DEPTH-NOW-AND-R3-2026-08-26.md`) worried the team might accidentally publish.

**The "what has been made accessible" list, `accessibility-defaults.php:37-43`** — this is where the
audit does real per-item work, because unlike the paragraph above, each bullet is phrased as a completed
fact:

| Bullet (Hebrew, quoted) | Verdict | Evidence |
|---|---|---|
| "מבנה כותרות היררכי ותקין... לתמונות" (heading structure + alt) | **TRUE** (heading part), **TRUE with caveat** (alt part) | A11Y-LEGAL-09, A11Y-LEGAL-10 |
| "ניגודיות צבעים מותאמת וטקסט הניתן להגדלה..." (contrast + resizable text) | **TRUE, sampled only** | A11Y-LEGAL-11; resizable text not independently tested by me — no `viewport` max-scale lock found in the plugin config (`window.wpa.viewport:"1"`, meaning WP Accessibility's own pinch-zoom unlock is *on*), which supports but doesn't fully prove the claim |
| "אפשרות ניווט מלאה באמצעות מקלדת וסימון פוקוס נראה" (full keyboard nav + visible focus) | **TRUE, after correcting my own measurement error** | A11Y-LEGAL-12 |
| "תמיכה בקוראי מסך וסימון אזורי תוכן (landmarks) ו-ARIA" (screen-reader support + landmarks/ARIA) | **landmarks: TRUE (measured). Full screen-reader support: UNVERIFIED — could not measure** | A11Y-LEGAL-13 |
| "קישור «דלג לתוכן» בראש כל עמוד" (skip link on every page) | **TRUE on pages sampled** | A11Y-LEGAL-14 |

None of these five bullets is currently false on the evidence I gathered — which is itself worth saying
plainly, because **the single most serious exposure the brief warned about (a statement asserting an
adjustment that was never made) did not materialize on inspection.** What *is* still a real problem is the
mode of assertion: every bullet reads as a flat, present-tense, audited-sounding fact, with no footnote
that it reflects the team's own testing and not a signed third-party or team_50 conformance audit. That
gap between "true when we checked it, today, on the pages we checked" and "true, full stop, as published"
is A11Y-LEGAL-01, and it is the one I would not want closed by just deleting the list — the underlying
claims are largely earned; they are just overclaimed in tone.

**The limitations section, `accessibility-defaults.php:45-51`:**
> "...ייתכן שיימצאו חלקים שטרם הונגשו במלואם, בפרט תכנים של צד שלישי (כגון הטמעות וידאו או מפות)..."

This correctly flags third-party embeds as a known gap area, but it stops short of a **policy** — it
does not say what happens when a visitor needs captions, and does not commit to (or correctly disclaim)
anything specific. That is A11Y-LEGAL-07, and it maps to round-3 DoD item 6.

**The coordinator section, `accessibility-defaults.php:53-59`:**
> "ניתן לפנות לרכז הנגישות של המרכז לטיפול בדיג׳רידו: טלפון 052-4822842, או דרך עמוד יצירת הקשר."

No person is named — A11Y-LEGAL-02, discussed in its legal context at §3.5.

**The date section, `accessibility-defaults.php:61-67`:** "עודכנה לאחרונה ביולי 2026." Verified via
`git log -1 --format=%ad -- .../accessibility-defaults.php` → **`Wed Jul 15 16:43:28 2026`**. The date is
accurate to the file's own history (A11Y-LEGAL-04) — I had initially assumed it was stale, given how much
of the site changed after July, and that assumption was wrong; git shows the file itself simply hasn't
been touched since, so "July 2026" is honest as a statement about the *file*. The genuine nuance is
different: several of the code-level facts the July text asserts (the skip-link target actually
resolving, home-page content carrying real alt text) were **not yet true in the code** when this file was
last edited — they became true only in August, after `07c65b5`/`fabd106`/`887d270`. The statement's
wording happened to get ahead of the implementation and the implementation later caught up to it, rather
than the more defensible order (implement, verify, then publish the claim). By today's date the specific
items I tested hold, so this is a process note, not a live falsehood.

### 4.3 What the statement does not need to say (and correctly doesn't)

The statement never mentions turnover, "עוסק פטור," or any exemption (A11Y-LEGAL-08) — correct, given
§3.3. It also never claims the coordinator is legally mandated — it just presents one, which is
defensible under either reading of §3.5.

---

## 5. Part 3 — The plugin question, answered with evidence

### 5.1 What WP Accessibility is actually doing on this site, right now

Confirmed live (not just from the repo's own records) via the plugin's own JS config object, read
directly from the live `/accessibility/` page on 2026-09-17:

```
script: wp-content/plugins/wp-accessibility/js/wp-accessibility.min.js?ver=2.3.5
style:  wp-content/plugins/wp-accessibility/css/wpa-style.css?ver=2.3.5
window.wpa = {
  skiplinks: { enabled: false, output: "" },
  target: "1", tabindex: "1",
  underline: { enabled: false, target: "a" },
  videos: "", dir: "rtl", viewport: "1", lang: "he-IL",
  titles: "1", labels: "1", alt: "",
  ...
}
```

This plugin (Joe Dolson's **WP Accessibility**, v2.3.5, from wordpress.org — the same one named in
`_COMMUNICATION/team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md`) is active. But its **own
skip-link feature is switched off** (`skiplinks.enabled:false`). Every skip-link behavior verified in
this audit (A11Y-LEGAL-12, -14) comes entirely from **custom theme code** —
`site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php:422` and `header.php:24/75` — not from the
plugin. What the plugin *is* actually contributing, based on the config above: `viewport:"1"` (removes
any pinch-zoom lock, a genuine small WCAG 1.4.4-adjacent win), `titles`/`tabindex` toggles, and a
`labels`/`ldType` feature aimed at the *default* WordPress comment and search forms — which this theme
does not appear to use for its actual contact form (Contact Form 7 already carries native `<label>`
elements, per `template-parts/chapters/parts/contact.php:39-58`), so that particular plugin feature is
largely inert here. **This corrects an assumption in several internal docs** (e.g.
`docs/project/team-100-preplanning/LEGAL-ACCESSIBILITY-ISRAEL-SPEC.md:41`, "נבחר... כלי עזר — למשל דילוג
לתוכן") that treats the plugin as *the* skip-link mechanism — on the live, current configuration, it
is not (A11Y-LEGAL-15). None of this is a defect; it is a documentation correction. WP Accessibility is,
correctly, a helper — it does not and cannot certify IS 5568/WCAG 2.0 AA conformance by itself, and
nothing in the project's own records claims otherwise.

### 5.2 What the uPress-bundled "Enable Accessibility" offering is

The project's own architecture record —
`_COMMUNICATION/team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md:57` — categorizes it
precisely: "שכבת נגישות UI (מנוי חיצוני)" (a UI accessibility layer, external subscription), **not
recommended by default**, requiring a `waiver` from team_100 plus an accessibility audit if ever chosen,
explicitly distinguished from WP Accessibility ("לא אותו מוצר"). I was not able to independently confirm
from public sources which exact vendor uPress bundles under that name — a WordPress.org-listed plugin
literally titled "Enable Accessibility" exists (a generic toolbar/overlay plugin: font resize, contrast
toggle, a registration-gated "key"), and this appears consistent with the category the internal doc
describes, but I could not verify vendor identity beyond the category with certainty in this session —
**COULD NOT MEASURE**, flagged in §7.

What I *could* verify directly is a live, running example of exactly this category of product, on Eyal's
own **current production site** (`https://www.eyalamit.co.il/`), read 2026-09-17: a plugin called
**"WP Accessibility Helper (WAH)"** (`wp-content/plugins/wp-accessibility-helper/`, JS `?ver=1.0.0`, CSS
`?ver=0.5.9.4`), visible as a blue circular wheelchair icon fixed to the page (screenshot taken), which
opens a floating panel (`div#wp_access_helper_container.accessability_container`) offering font
resize (`wah_font_resize`, smaller/larger buttons) and a cookie-clearing toggle. This is a textbook
overlay/toolbar widget — cosmetic, client-side, style-only controls layered on top of the page, not a
change to the page's own markup, semantics, or keyboard behavior. It is a fair, concrete stand-in for
what installing the uPress-bundled product on the new site would look and behave like, since it is the
same product category, already running, already familiar to Eyal as "the accessibility thing on the
site."

### 5.3 Do overlay/toolbar widgets create IS 5568 / WCAG 2.0 AA conformance?

**No — and this is not a close call in the current evidence base.** In descending order of how neutral
the source is:

- **[W3C's own Web Accessibility Initiative mailing-list discussion of AI-based overlays](https://lists.w3.org/Archives/Public/w3c-wai-ig/2025AprJun/0011.html)** (April 2025, read 2026-09-17) — the standards body's own community is openly skeptical; WCAG conformance is defined against the delivered markup/rendered accessibility tree, and an overlay sits on top of that, not inside it.
- **[The Overlay Fact Sheet](https://overlayfactsheet.com/en/)** (read 2026-09-17) — an open declaration, not a vendor's marketing page, signed by **over 1,000 individuals**, including W3C ARIA working-group members, in-house accessibility staff from Google, Microsoft, Apple, Shopify and others, university accessibility coordinators, disability-rights lawyers, and JAWS/NVDA contributors. Its core technical point: full conformance requires the delivered page to satisfy every criterion; an overlay's own documented failure modes (unreliable auto-generated alt text, unreliable keyboard-access repair, no ability to fix framework-driven dynamic content) mean it structurally cannot get there, and some overlays additionally collect assistive-technology usage signals that raise their own privacy questions.
- **U.S. FTC v. accessiBe** (finalized April 2025; [FTC's own case page](https://www.ftc.gov/legal-library/browse/cases-proceedings/2223156-accessibe-inc), read 2026-09-17) — a **$1 million** settlement against an **Israeli-founded** overlay vendor for misrepresenting that its widget made customer websites WCAG-compliant. This is a regulator, not a commentator, and it is squarely on point: it is the government enforcement answer to "can we say an overlay makes us compliant," and the answer was a fine.
- **Israeli-specific commentary:** [אינטרנט ישראל / ISOC-IL — "שימו לב: תוספי נגישות לא יעזרו לאתר שלכם להיות נגיש"](https://internet-israel.com/%D7%A8%D7%A9%D7%AA-%D7%94%D7%90%D7%99%D7%A0%D7%98%D7%A8%D7%A0%D7%98/%D7%91%D7%A0%D7%99%D7%99%D7%AA-%D7%90%D7%AA%D7%A8%D7%99-%D7%90%D7%99%D7%A0%D7%98%D7%A8%D7%A0%D7%98-%D7%9C%D7%90%D7%A0%D7%A9%D7%99-%D7%A2%D7%A1%D7%A7%D7%99%D7%9D/%D7%A9%D7%99%D7%9E%D7%95-%D7%9C%D7%91-%D7%AA%D7%95%D7%A1%D7%A4%D7%99-%D7%A0%D7%92%D7%99%D7%A9%D7%95%D7%AA-%D7%9C%D7%90-%D7%99%D7%A2%D7%96%D7%A8%D7%95-%D7%9C%D7%90%D7%AA%D7%A8-%D7%A9%D7%9C%D7%9B%D7%9D/), read 2026-09-17 — **the Israel Internet Association, a nonprofit, not a widget vendor** — makes the same point for the Israeli market specifically: accessibility requires code-level, human-judgment work; a button does not substitute for it, and some overlays actively conflict with real assistive software.

**The fair counter-argument, stated plainly rather than dismissed:** overlay vendors and some site owners
argue a widget is fast, cheap, gives *some* users genuinely useful controls (font size, cursor helpers)
even if those duplicate OS/browser features, and signals visible good-faith effort while real fixes are
scheduled — better than nothing while a proper remediation is underway. That argument has some force for
a resource-constrained small business. It does not, on any source I found — commercial, nonprofit, or
governmental — extend to **claiming conformance** because the widget is installed. The 2025 UsableNet
litigation data cited by [TestParty](https://testparty.ai/blog/accessibility-widget-lawsuits) (read
2026-09-17, **a commercial accessibility-testing vendor — flagged**) reports the *opposite* correlation:
sites running overlays showed up in a rising share of accessibility lawsuits, not a falling one. I cannot
independently verify UsableNet's underlying methodology from this session, so I am citing it as
directionally consistent with everything else above, not as a stand-alone proof.

### 5.4 Recommendation

This is Nimrod's decision, not mine to make — but here is what the evidence supports, plainly:

- **Keep WP Accessibility as-is.** It is a legitimate helper, already installed, doing a few small,
  correct things (pinch-zoom unlock, title/tabindex tidy-ups). Nothing here counsels removing or
  replacing it.
- **Do not install "Enable Accessibility" (or any similar overlay/toolbar) as a compliance measure.**
  Every source in §5.3 — including a fresh $1M U.S. regulatory settlement against an Israeli company for
  exactly this claim — says installing a widget does not create IS 5568/WCAG 2.0 AA conformance, and the
  statement must never say or imply that it does.
- **If installed at all, install as a cosmetic helper only**, never mentioned in the accessibility
  statement as evidence of anything, and understood by everyone on the project as buying zero credit
  toward the round-3 WCAG matrix, the keyboard/screen-reader testing, or the mobile-contrast work that
  still needs doing regardless. Given the site already runs one legitimate helper plugin and the owner's
  own prior architecture decision (§5.2) already reasoned through this and said no, I see no case *for*
  adding a second, cosmetic-only layer — but that trade-off (a small UX nicety some visitors might like,
  against a second plugin's weight and a very literal legal risk if anyone ever describes it in the
  statement) is the owner's to weigh, not mine.

---

## 6. Part 4 — Documentation versus reality

### 6.1 The `feat/s006-a11y-close` branch: not stranded

Traced with `git log`/`git show`/`git diff`/`git merge-base`, not assumed from any status doc:

1. **2026-08-26** — team_10's "A11Y-NOW" work (skip-link target fix, EN skip label, home-page alt text)
   was deployed to staging by FTP but never committed to git — it sat as uncommitted changes in a shared
   worktree (per `DONE-S006-A11Y-NOW-TEAM10-2026-08-26.md` and confirmed by commit `fabd106`'s own
   message).
2. **2026-08-31** — a second, fully isolated clone (`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-a11y-close`,
   branch `feat/s006-a11y-close`) was created to do the "A11Y-CLOSE" W1–W3 work (footer heading semantics,
   `.foot__disc` contrast token, CF7 de-duplication, extended `alt`-helper coverage, and the
   skip-link-visible-on-focus CSS fix). Only **one** of that wave's commits was ever pushed to
   `origin/feat/s006-a11y-close` — `07c65b5`, "make the first skip link visible on keyboard focus"
   (2026-08-31), which bumped `style.css` to **1.5.17**. Confirmed directly: `git show
   feat/s006-a11y-close:site/wp-content/themes/ea-eyalamit/style.css` → `Version: 1.5.17`, **today**,
   2026-09-17 — not 1.5.20.
3. **2026-09-06** — commit `fabd106` ("rescue the A11Y-NOW work, which has been uncommitted since 26.8")
   commits the 26.8 batch onto the shared lineage directly. Its own commit message asserts that the
   *rest* of the a11y-close work "is safe on `origin/feat/s006-a11y-close` at 1.5.20" — **that specific
   claim does not hold up under direct inspection** (see A11Y-LEGAL-19 below); the actual W1–W3 work was
   still sitting only as uncommitted, deployed-to-staging files in the isolated clone at that moment.
4. **Same day**, commit `887d270` ("save the work that was deployed to staging but never committed")
   captures those files — 28 theme files plus mandates/evidence — directly onto the shared branch. Its
   message is explicit: *"Nothing is merged: the branch stays separate until Eyal's Round-1 gate."* This
   was authorized by team_00's decision `DECISION_S006_R1_CLOSE_2026-09-06_v1.md`, item **D-1**: squash
   the 28 files onto the branch and push; "the merge to `main` stays a separate gate."
5. **Same day, later**, merge commit `e480ba8` ("Merge feat/s006-a11y-close — staging's live accessibility
   work was about to be overwritten") formally merges the branch's ancestry into the **working branch**
   (what is now `s006/tracker-integrity`) — resolving 13 conflicts, all in the a11y-close side's favor,
   including fixing a genuine duplicate-skip-link defect across eight templates. This merge is what
   makes `git merge-base --is-ancestor 07c65b5 HEAD` return true today.

**Conclusion, directly verified against the live tree, not the docs:** none of the A11Y-CLOSE work is
stranded. `.foot__col-title` (`template-parts/chapters/section-footer.php:19,26`), `.foot__disc`
(same file, line 48, contrast confirmed 7.74:1 in §2), and the skip-link `position:fixed;z-index:100000`
rules (`assets/css/ea-atoms.css:88-89`, `assets/css/chapters.css:656-657`) are all present in the current
`s006/tracker-integrity` tree today, at theme `Version: 1.5.37`.

### 6.2 But `main` is a live regression risk, right now

This is the one governance fact I would put at the top of anyone's list. Verified 2026-09-17:

```
main / origin/main   → style.css:7 → Version: 1.5.15
git rev-list --count main..HEAD        → 57
git merge-base --is-ancestor e480ba8 main → NO
```

`main` has received **none** of the S006 work — not the accessibility fixes, not anything else from the
last several weeks. This is by explicit design (D-1: "the merge to `main` stays a separate gate"), not an
accident, and it is documented in the tracker per D-1's own mandatory instruction. But it means that,
today, a deploy sourced from `main` instead of the current working lineage would silently reintroduce
every accessibility defect this and the earlier team_10 line already fixed — the broken skip-link target,
the missing `id="main"`, the empty `alt` on home-page content photos, the unreadable footer disclaimer,
the invisible-on-focus skip link. **This is not a historical note — it is a standing landmine as of the
date of this report**, and the mitigation already exists (don't deploy from `main`; deploy from the
lineage that has 57 more commits than it), but only if whoever deploys next knows to check.

### 6.3 A documentation-accuracy correction

`HANDOFF-CURRENT-S006.md` (line 27, 2026-09-06 revision) states: "ענף `origin/feat/s006-a11y-close`
**1.5.20** (לא ממוזג, בהוראת D-1)." Checked directly: `git show
feat/s006-a11y-close:site/wp-content/themes/ea-eyalamit/style.css` → **`Version: 1.5.17`**, both on
2026-09-06 (per the commit history) and today. The branch ref itself was never advanced past `07c65b5`;
1.5.20 was the *live, deployed, uncommitted* state on disk in the isolated clone, not the git branch's
own version. This is immaterial to anyone's actual work today (the substance was captured by `887d270`
regardless of which git ref it technically sits on), but it is a factual error in a document whose entire
job is to be the state-of-truth SSOT, and I'd rather flag a small one now than have it compound later.

### 6.4 Prior claims verified against current code

| Claimed (source) | Verdict | Evidence |
|---|---|---|
| Single working skip link to `#main` (`DONE-S006-A11Y-NOW-TEAM10-2026-08-26.md`) | **TRUE, live today** | `header.php:24,75`; live DOM query on `/accessibility/` found exactly one skip-link-like anchor |
| EN skip label (same report) | **Could not directly re-verify on `/en/`** — I did not load that page this session; I did confirm the mechanism (`inc/wave2-stage-b.php:422`, language-conditional label) is still present in code | file inspection only |
| Content `alt` on home page (same report) | **TRUE, live today, and now more complete than the original 5** | 41/42 home-page images carry real alt text (§2, A11Y-LEGAL-10); the original report only claimed 5 |
| Footer heading semantics `h4→p.foot__col-title` (`MANDATE-S006-A11Y-CLOSE-W1...`) | **TRUE, live today** | `section-footer.php:19,26`; `chapters.css:236` |
| Footer contrast token `.foot__disc` (same mandate) | **TRUE, live today, passes 7.74:1** | `section-footer.php:48`; computed contrast, §2 |
| CF7-vs-native duplicate form (`DRAFT-R2-003-ACCESSIBILITY-2026-08-25.md` §2) | **No longer reproduces** | live DOM on `/contact/`: exactly one `<form>`, `class="wpcf7-form..."` |

### 6.5 Round-3 Definition-of-Done items with no evidence anywhere in the repo

Checked by searching `_COMMUNICATION/` and `docs/` for each, not assumed absent:

1. **A WCAG 2.0 AA matrix (A+AA) across the named page set** (DoD item 1) — no such file found.
2. **A VoiceOver or NVDA screen-reader session** (DoD item 3) — every hit for "VoiceOver"/"NVDA" in the
   repo is a Lighthouse (automated tool) report; Lighthouse is not a screen-reader test. No manual
   screen-reader session log exists.
3. **Mobile contrast verification** (DoD item 4, "desktop **and mobile**") — `OPT-R3-REGISTER.md` itself
   defers all mobile work to round 3 ("mobile viewport: OPT-R3-05... qa_probe mobile + fixes"); no mobile
   contrast measurement exists yet.
4. **A media/caption policy written into the statement** (DoD item 6) — confirmed absent, §4.2/A11Y-LEGAL-07.
5. **team_50's signed verdict** (DoD item 8, `M2-ACCESSIBILITY-QA-REPORT` / `S006-A11Y-R3-AUDIT-TEAM50`) —
   only the *mandate* (`BRIEF-S006-A11Y-R3-AUDIT-TEAM50-2026-08-26.md`) and the *spot-check request*
   (`REQUEST-S006-A11Y-NOW-SPOTCHECK-TEAM50-2026-08-26.md`) exist in `_COMMUNICATION/team_50/` — no
   completed report with a verdict.

DoD items 2 (keyboard/focus/one-skip-per-template) and 5 (meaningful alt HE/EN) have partial evidence —
mine, and team_10's earlier report — but not the independent team_50 verification the charter calls for.
DoD item 7 (approved statement) is squarely unmet per Part 2. DoD item 9 is procedural and simply hasn't
happened yet — this audit round is presumably part of getting there.

---

## 7. COULD NOT MEASURE

- **Whether the underlying business would actually qualify for any 35ו exemption.** No turnover figure
  exists in this repo or was given to me; I was told not to assume one, and did not. This can only be
  resolved by Eyal or his accountant supplying an actual number, which is then a legal, not a technical,
  determination.
- **Whether the general 25-employee accessibility-coordinator-appointment duty attaches.** No headcount
  figure for the business exists in the repo. Every record describes a single-practitioner operation,
  which makes the duty unlikely to attach, but "unlikely" is an inference from scale, not a headcount.
- **The exact vendor/product behind uPress's bundled "Enable Accessibility" offering.** I could not
  independently confirm this beyond the category the internal architecture doc already assigns it
  (external-subscription UI accessibility layer); I found a same-named generic WordPress.org plugin that
  fits the category but could not confirm it is specifically what uPress bundles.
- **Full screen-reader usability of the statement or any other page.** No VoiceOver/NVDA session was run
  by me or found anywhere in the repo (§6.5). Landmark roles are present and correct; that is a necessary
  but not sufficient condition for actual screen-reader usability.
- **Site-wide or mobile color contrast.** I measured two specific, previously-flagged elements and both
  passed comfortably; I did not enumerate every text/background pair on every template, and mobile was
  out of scope for every round before this one by explicit charter decision.
- **Resizable-text-without-loss-of-content**, claimed in the statement's bullet list — I did not test
  browser zoom/reflow behavior; I only noted that the plugin's pinch-zoom unlock is enabled, which is
  necessary but not sufficient evidence for the claim.
- **EN-page skip label**, re-verified against current code structurally but not reloaded live in the
  browser this session (see §6.4).
- **Video captioning on any actually-embedded video** (e.g. the YouTube embed on `/eyal-amit/mokesh-dahiman/`
  referenced in `OPT-R3-REGISTER.md`) — I did not load that page or inspect that embed; my finding on
  captions (A11Y-LEGAL-07) is about the *statement's missing policy language*, not a direct measurement of
  any specific video's actual captions.

---

## 8. Recommended fixes, ordered by user/owner impact

1. **Do not paste the statement into production, or approve it as final, until the draft banner comes off
   for real reasons — a named coordinator contact and an explicit media-policy sentence — not just because
   round 3 is running.** File: `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/accessibility-defaults.php`
   (lines 53-59 for the coordinator, 45-51 for a media-policy addition). This is the one item that gates
   everything else in Part 2.
2. **Add one sentence disclosing that the "what we've done" list reflects the team's own testing and has
   not been independently audited**, immediately after `accessibility-defaults.php:43`'s closing `</ul>`.
   This single sentence converts A11Y-LEGAL-01 from a real exposure into a defensible, honest statement,
   without having to touch or weaken any of the five underlying claims — all of which currently hold.
3. **Fix the record before the next session repeats the archaeology I just did**: correct
   `HANDOFF-CURRENT-S006.md`'s branch-version line (A11Y-LEGAL-19) and add one explicit warning line that
   `main` is 57 commits behind and must not be used as a deploy source until the S006 gate closes.
   File: `_COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md`.
4. **Close the round-3 DoD gaps that currently have zero evidence** (§6.5): a real WCAG 2.0 AA matrix, one
   actual VoiceOver or NVDA pass on home + contact, and mobile contrast — these are pre-existing gaps, not
   new work this report invents, but nothing above waives them.
5. **Vary the 30 identical `alt` strings on the home-page `#peek` gallery** (`inc/chapters/chapters-render.php`'s
   `ea_chapters_content_img_alt()` mapping, or the gallery's own loop) if any of those 30 photos are
   actually distinguishable content rather than a single repeated scene — low severity, but cheap to fix
   and currently the weakest link in an otherwise solid `alt`-text story.
6. **When the owner decides the plugin question (§5.4), record the decision in the statement's wording
   choice, not as a new claim** — if a cosmetic helper widget is ever added, the statement must not cite
   its presence as evidence of anything.

---

## 9. Anything I believe the other lines will get wrong

**A shared Browser pane is not an isolated one.** Mid-audit, my browser tab silently navigated itself to
pages I had not requested (`/contact/`, then the staging home page) and I found a system note that
"another Claude session set" a 375×812 mobile viewport on the default tab. Multiple team_10 lines are
running this same audit round concurrently, and — at least in this environment — the Browser pane's tabs
are not cleanly isolated per agent session. **Any line doing live browser QA right now should open its
own tab with `tabs_create` before trusting a single measurement, and should not assume a viewport or
navigation state it did not just set itself.** This is a new trap, not one of the six the brief already
named, and it is exactly the shape of the "confident wrong answer" problem the brief is worried about.

**`element.focus()` from JavaScript is not the same as a real keyboard focus, and testing `:focus`-driven
CSS with it will produce a false negative in this harness.** I initially measured the skip-link-visible-on-focus
fix as *broken* — `document.activeElement` correctly moved to the link, but its `:focus`/`:focus-visible`
CSS never applied, leaving it stuck off-screen. The actual cause was that `document.hasFocus()` was
`false` for the whole tab (a property of this automation environment, not the site), and `:focus`/
`:focus-visible` do not match while the document itself lacks focus, no matter what `document.activeElement`
says. A single, harmless `Escape` keypress (real, trusted, via the `computer` tool — no click, no
navigation risk) was enough to flip `document.hasFocus()` to `true`, after which the identical test passed
cleanly: `position:fixed; top:12px; z-index:100000`, fully on-screen. **Any line that tests focus-visible
styling, focus traps, or `:focus`-gated CSS by calling `.focus()` from a script and reading
`getComputedStyle()` immediately afterward is at real risk of reporting a fix as broken when it is not.**
Trigger a real input event first (a key press is enough and carries no side effects), and only then trust
a `:focus`-dependent measurement.

**Assuming "the repo" has a fix, without checking which branch, will produce the opposite error in the
other direction.** `s006/tracker-integrity` (this session's checked-out branch, and what staging actually
runs) has every accessibility fix discussed in this report. `main` does not — it is 57 commits and one
un-run merge behind, by deliberate design (§6.2). A line that checks out `main` fresh, or that greps a
different clone of this repo pointed at `main`, will get a *genuinely different, worse* answer than one
checking `s006/tracker-integrity` — and both would be measuring correctly; they would just be measuring
different branches. Say which branch backs any code claim.

**The statement's five "what we've done" bullets are, on my testing, mostly true right now** — a line that
assumes the brief's warning about a "published statement asserting an adjustment we have not made" means
it *found* such a false claim should double-check against live measurement before reporting it as a
violation; on the specific claims I tested (heading structure, alt text, contrast, keyboard/focus,
landmarks, skip link), the gap is in the *unqualified, audited-sounding tone* of the claims (A11Y-LEGAL-01),
not in any one of them being outright false today.
