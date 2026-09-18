The live statement loaded (HTTP 200, 51 989 bytes, title and `h1` `הצהרת נגישות`). Full write-up: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-C3-STATEMENT-VS-REALITY-2026-09-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-C3-STATEMENT-VS-REALITY-2026-09-18.md). Nothing was changed. No scanner.

**Screen reader:** none used here, and none of XVAL-A / B1 / B2 / B3 / C1 / C2 used one either. A DOM or accessibility tree is not that.

Disagreement with the prompt’s B2 paraphrase: B2 did **not** fail an “active FAQ tag chip”. That fail is `/treatment/` `.dd__tag` “תהליך אישי” at **4.2573:1**. The live FAQ selected topic chip **passes** (this line: **5.6709:1**).

---

### Status chrome
| Claim | Verdict | Evidence |
|---|---|---|
| «ממתין לאישור» / “Waiting for approval” | **TRUE** (as displayed) | This line: visible badge, `innerText` non-empty |
| «טיוטת צוות, טרם אושרה סופית» / team draft, not finally approved | **TRUE** as displayed; Eyal/legal state **UNVERIFIED** | This line |
| Awaits Eyal/legal before binding `(WP-EI-05)` | Wording **TRUE**; actual review state **UNVERIFIED** | This line |

### Commitment
| Claim | Verdict | Evidence |
|---|---|---|
| We work to make the site accessible to everyone / equal service | **UNVERIFIED** | Intent |
| We operate per the 2013 regulations and SI 5568 (WCAG 2.0 AA) | Citation **TRUE**; conformance **FALSE** | SI 5568 *is* WCAG 2.0 AA; remaining live fails below |
| No independent external audit, so we do not claim certified conformance | Process **UNVERIFIED**; the page does disclaim certification | This line (reading) |

### Adaptations “done on twelve central pages in September 2026”
Which twelve, and whether they measured: **UNVERIFIED**. Results:

| Claim | Verdict | Evidence |
|---|---|---|
| One `h1`, no skipped heading levels | **TRUE** on the 12 | **XVAL-C1** |
| Every image has a description except marked decorative and a few unidentified | **TRUE** as qualified | **XVAL-A:** 216 / 208 / 8 empty; 2 decorative in `aria-hidden`; 6 missing on `/books/vekatavta/` only |
| Skip link «דלג לתוכן» at the top of every page, moves focus to main | **TRUE** on 11 Hebrew URLs; **FALSE** as quoted on `/en/` (`Skip to content`). Enter→`#main` measured on `/` only | Presence: C1 + this line. Activation: **B1, C2** on `/` |
| Full keyboard nav including narrow-screen menu, visible focus on every control | **FALSE** as a blanket | **C2:** mobile Tab order contradicts visual RTL (burger); off-screen focus on `/` and `/faq/`. Menu *is* operable (Enter/Escape). **B1:** focus rings **1.06 / 2.90 / 2.54 / 1.65 :1** (need 3:1). **B3:** skip clip has no distinct ring |
| 200% text, no clipping, no horizontal scroll | **FALSE** on C2’s four pages; **UNVERIFIED** on the other eight | **C2:** overflow 0 px, but skip overlaps brand, home `h1` at y=−150, FAQ heading overlaps nav, zoom:2 burger 151.6 px off-screen |
| One main, named navs, unique IDs | **TRUE** on 11 Hebrew pages; `/en/` has **0** `<nav>`. No duplicate IDs on all 12 | **XVAL-C1** |
| Contrast adapted for text and UI, including keyboard focus | **FALSE** | **B1** focus rings; **B2** footer **4.4867:1** and treatment chip **4.2573:1** |

### Known limitations
| Claim | Verdict | Evidence |
|---|---|---|
| No screen-reader test; suitable SR marking; auto+manual tools | SR-not-run today: **TRUE** for this campaign. Marking / their tool use: **UNVERIFIED** | This line + all siblings. No SR anywhere |
| Some book-gallery images awaiting ID, left undescribed | Missing alts **TRUE** on vekatavta only; motive **UNVERIFIED**. Plural “galleries” overstates | **XVAL-A:** 6 files; tsva/kushi have 0 empty |
| **One** UI component — selected **topic tag** — still fails contrast | **FALSE** | This line: FAQ `is-active` chip **5.6709:1 PASS**. Real fail is treatment `.dd__tag`, plus footer, plus focus rings — not “one”, not that chip |
| Third-party content including video embeds not fully in our control | **TRUE** for the site; **FALSE** on the 12 | This line: 12 pages = 0 iframes. Mokesh (outside the 12) has YouTube + Facebook iframes |
| Automated tools do not prove conformance | **TRUE** (method) | Charter §8א; not a DOM fact |
| A scanner said «zero issues» on pages with **162** undescribed content images | **UNVERIFIED** | Historical. Not reproduced. Live today is 8 empty (**XVAL-A**), not 162. No scanner run |
| Therefore all checks above were also done manually | **UNVERIFIED** | Process |
| We continue to improve accessibility | **UNVERIFIED** | Intent |

### Video / contact / date
| Claim | Verdict | Evidence |
|---|---|---|
| External videos are embedded on the site | **TRUE** site-wide (mokesh YouTube); **FALSE** on the 12 | This line. Only video in the 12: first-party muted hero mp4, **0** `<track>` |
| We do not guarantee captions for every video | **TRUE** as a non-promise | Home video has no tracks. YouTube captions: **UNVERIFIED** |
| Contact us and we will provide a transcript/summary/call | **UNVERIFIED** | Service promise, not exercised |
| Accessibility coordinator: **052-4822842** or the contact page | **TRUE** for those two channels. Whether a coordinator answers: **UNVERIFIED**. No personal name claimed | This line: `tel:+972524822842`; `/contact/` HTTP 200, `h1` צור קשר |
| Last updated September 2026 after tests and fixes | Visible month **TRUE**. “After tests and fixes” as a complete picture **UNVERIFIED** (fails still live). WP `dateModified` is still **2026-04-07** | This line |

### True on some of the 12, false on others
- Skip label «דלג לתוכן»: 11 Hebrew pages; `/en/` is English.
- Named `<nav>`: 11 Hebrew pages; `/en/` has none.
- Undescribed book images: vekatavta only; the other two book pages are clean.
- Header Tab vs visual RTL: holds on desktop `/` and `/contact/` (**B3**); fails at 390 px on `/` `/contact/` `/faq/` `/shop/` (**C2**).
- Off-screen focus: `/` and `/faq/` (**C2**); not found on `/contact/` `/shop/` in that walk.
- External video: none of the 12; yes on mokesh (outside the set).

**Owner of next step:** Team 10/100 if the statement is to be rewritten. This line does not fix it.
