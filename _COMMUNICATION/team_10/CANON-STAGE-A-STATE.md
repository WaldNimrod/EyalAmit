# Canon stage A — state, decisions, and what runs next

**Updated 2026-09-27 (checkpoint before compaction), theme 1.5.150. Entry point for any session continuing canon stage A.**
Read this, then the map's [README](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/canon-map/README.md),
then open the [map](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/canon-map/ea-canon-map.html).
Do not work from memory of the mandate: several of its assumptions were superseded today (§6).

- **Who:** team_10 builds, working directly with team_00 (Nimrod). Team_90 validates —
  **its session is `90- הכנה לעלייה לאוויר אייל עמית` [418028].** A session titled
  `team_90 (Validator)` [822397] is **TikTrack's**, not this project's; it was addressed by
  mistake today and asked to purge what it received. Verify identity before trusting any
  "team_90" ruling.
- **Mandate:** [MANDATE-CANON-STAGE-A-2026-09-27.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-27/MANDATE-CANON-STAGE-A-2026-09-27.md).
- **Pushing:** team_90 pushes after validation. Everything up to 3530e67 is on origin/main;
  later stage-A commits are local until team_90 pushes them.

---

## 1 · What stage A produces — team_00, 2026-09-27

> «המטרה של הסשן שלנו — לייצר את הקאנון המיטבי.» · «לייצר את תבנית הקאנון לא לתקן את האתר!!!»
> · «אנחנו עוסקים רק בui ובעיצוב ובנראות!!!» · «מובייל — גם ידרש התייחסות ובדיקה לכל האלמנטים.»

**Deliverable 1 — the canon map.** One document: every type in logical order, grouped with
headed separators, each with its identifier and properties; live examples, dummy content
only where nothing live exists. **Plus a feasibility proof per type:** at least one element
on a public page implementing it exactly. Built: see the map and its README.

**Deliverable 2 — the text canon.** On the existing canon infrastructure, text documents
with the general rules and the way of working derived from the types and the method, for
every future session including the stage-B reset lanes. **Not started** (§5).

**Users, and why the canon is dual** (team_00): «1 — אני ואייל, עובדים עם העיניים.
2 — סוכנים שממשים את סבב האיפוס או כל עבודה עתידית במערכת.» Nimrod approves and refines
by eye from a sketch; sessions read text. **Start from a visual sketch — a site page or an
artifact, builder's choice; deriving definitions and text from it is the builders' job and
needs validation.**

**Map structure** (team_00): each group in its own tab; floating navigation between groups;
first a table — **one row per type** — with a few user-relevant properties and a thumbnail;
a click shows the full description and the full-size example. «משהו פשוט ליישום, לא עוד
אתר… נוח גם לבנות גם לתחזק וגם להשתמש.»

## 2 · Where stage A sits relative to the launch

Nothing joined these two before; this section does. It cites, it does not restate.

- **Canon stages** — [SESSION-STATE-2026-09-24.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-24/SESSION-STATE-2026-09-24.md),
  «שלושת השלבים של הקאנון», lines 98–110: **א** Nimrod refines the canon (this) · **ב** a
  site-wide reset round against the corrected canon · **ג** the deviations and no-type areas
  are adjudicated visually **as part of א**, not after it.
- **Launch sequence** — [CUTOVER-LIST-2026-09-27.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-27/CUTOVER-LIST-2026-09-27.md),
  §ז «סדר הביצוע, ומי מבצע כל שלב» (line 101) and §ח «בדיקות קבלה אחרי המעבר» (line 133).
  The gate, in team_00's words: **«האתר לא יעלה לפני 301 של אייל וזה מה שיעקב.»**
- **The join:** stage A does not block the launch and the launch does not block stage A —
  stage A changes no page. **Stage B changes pages, so it must not run inside the launch
  window** (between «בדיקות סופיות» and the post-launch acceptance checks) without team_00
  deciding that explicitly. The map carries one host line; changing it is one item on the
  cutover list (team_90 added it). At cutover the map becomes admin-only (§3).

## 3 · Decisions, in team_00's words

| # | Topic | Ruling | Status |
|---|---|---|---|
| D1 | Map visibility | «העמוד כרגע ציבורי — בחיתוך לעלייה יהפוך להיות למנהל בלבד.» Plus a version for Eyal in a repo he can work against without logging in. | Map is a repo file today, **not yet hosted** — see O1. |
| D2 | How the map is built | «לבחור לכל טיפוס מייצג הכי קרוב באתר. להעתיק — מבנה כולל תוכן של האלמנט הקיים למפה.» Then fix «אחד אחד או דפוסים רוחביים עד שכל הקאנון וכל הדוגמאות מאושרות». | Done — 36 types (T-03 merged), 16 source pages. |
| D3 | Types with no live instance | Show with dummy content, clearly marked; mark «כרגע לא בשימוש» instead of the proof link; propose an example to implement, for approval. | Done for T-37. Proposal in §4. |
| D4 | Videos in the map | A placeholder is fine, even preferred — image with a film icon, YouTube logo, our atmosphere background; the same for every video; map only. | Done. |
| D5 | Hero heights (T-01) | «שני הקצוות מתקבלים — אבל לא כל גודל מתקבל.» Exactly three: large, medium, small. Large: «כמעט מסך מלא בפרופורציה נפוצה, כשיש סרגלים פתוחים». Small: the existing small end. Medium: from what is common/average on the site. **Every page aligns to one of the three.** | Proposal shown in the map: 92svh / 66svh / 44svh (min). **Awaiting approval.** |
| D6 | CTA band (T-08) | Less vertical padding. The logo is not a content column — a large, partly transparent background with a fade («רק אווירה, לא תוכן»). Button aligned to the bottom, not the centre. Wider middle column. | Proposal in the map on a light and a dark band, on the same six-column grid as the approved hero (text 1–4, button 5–6). Measured 1440: light 423→235px tall, text column 357→739px, button bottom level with the text; dark 288→182px. Phone: button under the text, no sideways scroll. **Awaiting approval.** |
| D7 | Six-column grid (system-wide) | Content width (not screen width) is divided into six equal parts; every alignment, column split and table sits on that grid by default — 3+3, 2+2+2, 1+5 — «כאילו יש סרגל קבוע מלמעלה למטה». | Principle recorded. Scope open — O3. |
| D8 | Videos on pages | «כל עמוד מקבל סרט משלו.» Check what already exists before asking Eyal anything. | Lessons, sound healing: Eyal said a video is coming (r19 LSN-02, SH-01); delivery tracked by form cards PH-LESSONS-VIDEO / PH-SOUND-HEALING-VIDEO. **Treatment: Eyal deferred it to phase 2–3 (r19 T-02)** — update card PH-TREATMENT-VIDEO to show that and ask his final choice. See O2. |
| D9 | Memorial-page examples | T-02 (its memorial instance), T-28, T-29, T-36 come from `/eyal-amit/mokesh-dahiman/`: «כרגע להשאיר — זה זמני — נגיע אליהם.» | Kept, to revisit. |
| D10 | `/books/` CTA outline button | It is Green-Invoice card 4 of 4, pending Eyal's link — not a design variance. Split the stage-A review row: the button-only bands stay a decision; `/books/` becomes «operationally pending Eyal». | Split to be applied in the canon text with deliverable 2. |
| D11 | Closed rules, not to reopen | From [00-MAINTENANCE.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/repair-sketch-2026-09-23/handoff-110/canon/00-MAINTENANCE.md): no button without a heading and sub-heading; no empty hero on a main page; the dead-space rules DEAD-01..04; palette decisions marked closed. | Map shows the CTA in full form only. |
| D13 | Video heroes | «זה כפילות — לשלוח לצוות 90, זה לטיפול שלהם — מבחינתנו זה תבנית אחת ושני העמודים צריכים לעמוד בה.» | T-03 merged into T-02 and retired. Code duplication scoped by team_90 (82e8723). Census: two pages (`/`, the memorial). Which alignment (centred vs start) — open, O7. |
| D14 | What an opened type shows | «מאפיינים — רשימה סדורה, שיהיה קל לקרוא מהר. שדות — רשימה עם סוג השדה, אחרת זה לא אומר לאייל כלום. הוכחות → שימושים באתר.» And for the hero: the three heights must be obvious. | Done: nine fixed properties, typed field table, full uses list from a census of all 136 live pages. Hero height is a visible field. |
| D15 | Hero review order | «נתחיל מגבהי ההירו וגם איחוד של הוידאו הירו לטיפוס אחד.» | Shown in the map under T-01: 92svh / 66svh / 44svh (min), plus the same hero with a video in place of the image. Measured: desktop 1440×900 → 92% / 66% / 45%; phone 375×812 → 92% / 73% / 51% — on a phone the text wraps and sets the lower two heights. **Awaiting approval.** |
| D16 | Hero button | «בהירו — הכפתור — לא שורה מתחת — אלא שמאלה לטור 3 בערך, ואז כל הטקסט יורד למטה.» | Shown on all four T-01 proposals: text in grid columns 1–4 (right), button in 5–6 (left), button bottom level with the last text line; the button row below is gone, so the text sits lower. Phone: button returns below the text. Measured 1440×900 and 375×812. **Awaiting approval.** |
| D17 | Hero approved; tab names | «מאשר את הגבהים ואת הכפתור.» And the tab «קריאה» (text paragraphs) read as «קריאה לפעולה» — «שוב דריפט תרגום». | Heights 92/66/44svh (min) and the button rule approved and written into CONTENT-TYPES-CANON.md type 1. Tabs renamed: «קריאה» → «טקסט», «פעולה» → «קריאה לפעולה». The video-as-media merge is not yet ruled on. |
| D18 | Hero merge | «הירו — מאשר. ואז לא צריך גם במפה סקשן נפרד — לאחד עם שאר הכלליים והוא יהיה הראשי הראשון.» | T-02 retired into T-01 (T-03 earlier). One map row, approved design first, today's six instances after it; uses 134 pages. O7 (alignment) closes: the approved hero is start-aligned with the button left. |
| D19 | CTA approved | «CTA יותר טוב, לא מדויק. כל הטקסט צריך לזוז יותר לשמאל.» then «מאשר גם להוסיף לטקסט עוד שבירת שורה.» | Text moved to grid columns 2–4 (a narrower column, so one more line break); approved and written into CONTENT-TYPES-CANON.md type 8. |
| D20 | Grid proof on every sketch | «מבקש מעכשיו — בסקיצות כולן — לסמן את הגריד של החלוקה ל-6, להוכיח לי שהעיצוב עומד בגריד. אולי נכון יותר לייצר ארטיפקט זמני ייעודי לנושא זה. כרגע ליישם רק על האלמנטים עליהם עבדנו.» | Temporary `canon-map/grid-proof.html`, generated by `tools/grid_proof.py` from the map (no second copy of the markup): the six columns drawn over each element's own grid. Now: T-01 and T-08. Measured: hero text in columns 1–4, button 5–6; CTA text 2–4, button in 5–6. **One exception, O8.** |
| D21 | Buttons are one cell | «יישור בעברית = לימין, לא לשמאל. בכפתור — שיתפוס רוחב בדיוק של תא, מיושר לימין ולא חורג מאיזור התוכן. הטקסט 4 בהירו. מעבר לזה ההירו מאושר.» · CTA: «שוב כפתור בגודל תא אחד בדיוק, מיושר לימין. טקסט 2–4.» | Hero: text 1–4, button = column 5 exactly. CTA: text 2–4, button = column 5 exactly. Measured: button edges equal column 5's edges in all six examples. Hero fully approved. Closes O8. |
| D22 | Grid gutter | «מרווח בין עמודות — הרבה יותר קטן… ממש מינימלי… אפילו 4.» (was 24px) | **4px**, one variable (`--cm-gap`) used by the elements and by the grid overlay. The principle, in his words: «זה גריד חלוקת שטח, לא כרטיסים של תוכן» — the grid is a ruler that divides the space, so the overlay draws only the column edges. |
| D23 | CTA corrections | «הטקסט חייב לקבל גם את תא 1. הלוגו — להצמיד לקצה המסך.» | CTA text columns 1–4; logo pinned to the screen's edge. Canon type 8 updated. |
| D24 | Button width, corrected | «הכפתור — מתקן את עצמי — שיהיה 5+6 ושורה אחת.» (supersedes the one-cell part of D21) | Hero and CTA: button fills exactly columns 5–6, one line. Measured edge for edge. |
| D25 | Button padding, all buttons | «פחות ריווח סביב הטקסט בכל הכפתורים. זה בכל מקרה.» | 9px / 18px instead of 15px / 36px → 44px tall instead of ~56. Canon Tier-2 "Buttons" updated. |
| D26 | T-04 text paragraph — two grid proposals | (shown, not yet ruled) | A: heading and text on columns 2–5 (centred, closest to today); B: columns 1–4 (right, on the hero's text line). Also fixed: the map's T-04 example was a split block by mistake (the first section on `/method/`); now a real text paragraph. |
| D27 | Hero button, two positions | «צריך לאפשר שני מיקומים לכפתור — כמו עכשיו, למטה — או למעלה, הראש שלו מיושר לראש הכותרת. למשל דף הבית צריך את הכפתור למעלה. זה תלוי בטקסט ובתמונה.» | A field on T-01: bottom (default) or top. Measured: top variant — button top = title top (0px); bottom — button bottom = last text line (0px). |
| D28 | Gutter, corrected | «טוב, צדקתם — צמצמנו מדי את המרווח בין העמודות — נחזור ל-10.» | **10px** (supersedes D22's 4px). One variable; measured in all nine grid-proof elements. |
| D29 | Text paragraph approved | «לדעתי הגדרנו פעם כותרת ב-1, טקסט רץ אחריה ב-2.» then «הכותרת היא 1–6, הטקסט הוא 2–6 — זה בפסקה כמו שהצגתם לי.» | Replaces D26's A/B. Heading and eyebrow columns 1–6, text 2–6; measured edge for edge. Matches POST-TEMPLATE-SETTINGS §1 (lines 41–42). Canon type 4 updated. Two wrong T-04 captures fixed; full audit of all 65 map examples: clean. |
| D30 | Image beside text (for T-06, next) | «כשיש תמונה ליד טקסט — כל ה-6 בחלוקה לפי התוכן וכיוון התמונה.» | Rule recorded; to be shown when T-06 is reviewed. |
| D31 | Narrow screens | «במסך צר — הירו + CTA — כפתור תמיד מיושר לשמאל.» | Measured at 375: every hero and CTA button's left edge on the content's left edge. Canon types 1 and 8 updated. |
| D32 | Paragraph text, corrected | «פסקה: טקסט — 2-5. לא 2-6. מתקן.» | Text columns 2–5 (supersedes D29's 2–6). Heading stays 1–6. |
| D33 | Paragraph backgrounds | «יש לאפשר מספר גוונים קאנוניים מתוך המניפה, ולוודא יחס טקסט-רקע העומד בנגישות והקונטקסט הדרוש לכולם. מה שעושה בעיות — פשוט להגדיר כאסור. תציגו לי לכמה הגענו טובים עם המניפה הקיימת.» | Measured all 13 tones of both palettes (Chapters + Eyal's) × 4 roles (eyebrow/body/link ≥4.5, heading ≥3). With today's two text sets: **3 of 13** pass. With two added text sets (chocolate eyebrow+link on light tones; all-white on saturated): **11 of 13**. Forbidden: terra-lt, terra. **Latent, not live** (team_90 census of all 136 pages: zero eyebrows or links sit on ivory-2 or sand today — all 111 eyebrows are in heroes): ivory-2 would fail an eyebrow (3.86), sand an eyebrow (2.81) and links (3.62). Routed to this canon round, not the defect queue (`CONTRAST-FINDINGS-VERDICT-2026-09-27.md`). Marginal passes flagged amber in the check: eyebrow on ivory 4.61, sand band's terra button 4.63. `palette-check.html`. **Resolved by D34–D35** (five tones, per-tone text sets). |
| D34 | Five paragraph tones | «אני רוצה לפסקת הטקסט לייצר כ-4–5 גוונים טובים ומובחנים. תבחרו את הטובים ביותר ותציגו לי בסקיצה לאישור.» → «מאשר את חמשת הגוונים» | Five distinct tones chosen from the 11 allowed: ivory, sand, olive, terracotta, dark (dropped as too close to one of these: ivory-2, brick, terracotta-Eyal, earth, chocolate, ink). **Tones approved.** |
| D35 | Per-tone text colours | «ברקע גוון 5 קישורים הם בצבע שונה — חובה לכל הגווני רקע צבע קישורים בהתאם, לא כמו הטקסט.» · «גם צבע לכותרת צריך להיות בהתאם לרקע כמובן.» | Each tone gets its own full text set; link ≠ body colour; heading tuned per tone. ivory: link/eyebrow #9A4F2B; sand: body #4a3220, link/eyebrow #7A3418; olive and terracotta: body white, heading #FFE8C2, link/eyebrow gold #F6D38A — **both tones one step darker** (#575838, #874321), because at the swatch value no link colour distinct from white text passes; dark: heading #FFE8C2, link #D08A5E. All roles ≥10% above threshold (asserted in `tools/palette_check.py` FIVE). **Approved** — «מאשר את צבעי הטקסט». In `CONTENT-TYPES-CANON.md` type 4. |
| D12 | Maintenance model (already defined — plan to it, don't reopen) | Eyal works against an environment in free language and does not deploy; its output is a request «שורה מטיפוס A עם תוכן B בעמוד C במיקום X», with his text marked apart from drafted text ([README-INDEX](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/EYAL-WORKSPACE/README-INDEX.md)). A page is an ordered list of rows, each a type plus its fields ([POST-TEMPLATE-SETTINGS](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md) §6). | The map's permanent IDs are the "type A". |

## 4 · Type status

**Legend:** captured = live copy in the map, not yet reviewed · proposal = a change is shown
for approval · ruled = team_00 gave direction, not yet shown · approved = done for stage A.

| ID | Type | Status |
|---|---|---|
| T-01 | Hero — the one opening type | **approved** (D5, D15, D16, D18): three heights, button left, media = image / video / none |
| ~~T-02~~ | retired — merged into T-01 (D18) | — |
| ~~T-03~~ | retired — merged into T-02 (D13) | — |
| T-04 | Prose row | **approved** (D29, D32): heading 1–6, text 2–5. Backgrounds: five tones approved (D34); per-tone text sets approved (D35) |
| T-05 | Prose fold | captured |
| T-06 | Split | **proposal** (rule D30): six-column split by image shape — landscape and cover 3+3, portrait text 4 + image 2, reversed mirrors; text keeps breathing space facing the image; one column below 760px. Five examples in the map and grid proof |
| T-07 | Floated figure | captured |
| T-08 | CTA band | **approved** (D6, D19): text cols 2–4, button 5–6, logo as background, lower band |
| T-09 | Point cards | captured |
| T-10 | Photo band | captured |
| T-11 | Gallery | captured |
| T-12 | Bleed quote | captured |
| T-13 | Whom cards | captured |
| T-14 | Compare pair | captured |
| T-15 | How to start | captured |
| T-16 | Portrait collage | captured |
| T-17 | Studio split | captured |
| T-18 | Testimonial marquee | captured |
| T-19 | Testimonial grid | captured |
| T-20 | Testimonial cards | captured |
| T-21 | FAQ | captured |
| T-22 | Definition accordion | captured |
| T-23 | Table of contents | captured |
| T-24 | Book / product cards | captured |
| T-25 | Spotlight row | captured |
| T-26 | Video block | **ruled** (D8) — own video per page |
| T-27 | Video placeholder | **ruled** (D8) |
| T-28 | Facebook embeds | captured (D9) |
| T-29 | Timeline | captured (D9) |
| T-30 | Photo slot | captured |
| T-31 | Contact rows | captured |
| T-32 | Press list | captured |
| T-33 | QR article shell | captured |
| T-34 | Blog — archive post | captured |
| T-35 | Blog card | captured |
| T-36 | Mokesh video embed | captured (D9) |
| T-37 | Blog — new post | dummy, «כרגע לא בשימוש». **Proposal:** the first new post Eyal publishes is built in this template — not a conversion of an old post (old posts stay as-is in the archive). No delivered material is waiting for such a post today. |

## 5 · Open items

- **O1 · Hosting the map.** It is a repo file; team_00 ruled it public now and admin-only at
  cutover. Simplest known path: publish it the way the old artifact is published (team_90's
  `hub/dist/` + `scripts/ftp_publish_eyal_client_hub.py`). Team_90 also documented a
  WordPress-page route and the `private` status mechanism. **Team_00 to choose.**
- **O2 · Treatment video card.** Proposed wording (Hebrew, for Eyal): «באוגוסט ציינת שסרטון
  למפגש טיפול יידחה לשלב שני או שלישי. בדקנו ולא מצאנו עדכון מאז. האם זה עדיין נכון מבחינתך,
  או שברצונך לספק סרטון כבר עכשיו? אם כן, איך תעדיף למסור אותו — קובץ להעלאה, קישור ליוטיוב,
  שיחה על זה, או משהו אחר.» The form lives under `_COMMUNICATION/team_100/S007/` — off-limits
  to team_10, signature `wave1-20260925` frozen, additive only. **Team_00 to name who applies it.**
- **O3 · Six-column grid scope.** Apply it now to the CTA redesign (D6), or record it as a
  principle and apply it to every component in stage B? **Team_00.**
- **O4 · The old artifact — CLOSED.** team_00, 2026-09-27: «זה לא יפה ולא שימושי» / «זה בכיוון» (the map), then «פורש — המפה מחליפה אותו!!! למחוק». `ea-content-types.html` is deleted from the workspace; `CONTENT-TYPES-CANON.md` is now paired with the map; `README-INDEX.md` updated. The published copy in `hub/dist/` and references in team_90's and team_100's live files are team_90's to remove (handed over). **Still open from its era:** the canon file's nine Tier-2 elements and its orphans list are not in the map yet.
- **O5 · Deliverable 2** — not started. Its inputs: the approved types, D7, D11, D12, and the
  map README's working loop.
- **O7 · Video-hero alignment — CLOSED by D18.** One template for both pages: centred (home today) or start-aligned (memorial and every inner hero today)? Team_90's census note: the memorial hero is already the standard inner hero plus a video layer — the home hero is the outlier. **Team_00.**
- **O8 · Buttons off-grid — CLOSED by D21.** Was: A button (~200px) is wider than one column (~165px at 1440) and narrower than two, so it starts on the outer grid line but ends in the gutter. Options: the button fills both columns exactly (~357px), or fits in one column (text may wrap). **Team_00.**
- **O9 · One content width for the grid.** The hero's content box is 1104px (1200 minus 48px padding each side) and the CTA band's is 1120px, so their six columns differ by ~2px at 1440. D7 defines the grid on «100% of the content width» — the site has at least two. **Team_00:** one content width for every component?
- **O6 · Direct deploys.** The harness's auto-mode classifier refuses the FTP deploy as a
  "Production Deploy"; team_00 has been running it by hand and wants that to stop.
  A settings change on his side — not worked around.

## 6 · Where the mandate turned out wrong, or was superseded (mandate §9)

- **§4.3 "one live example".** The attempted example (`/books/`, MUZZA.md §03.5) re-added a
  section that Eyal had removed on purpose in his 19.8 notes (commit 4bc5f5c); it was
  reverted the same day (47f405b) and the file's stale "verbatim" claim corrected.
  **Lesson: a cited source document is not the authority once Eyal has issued a later
  instruction — check the file's history before calling an absence a gap.** Team_00 then
  redefined the proof: **a feasibility proof per type**, which the map provides.
- **"The eight deviation pages"** (§4.3) do not exist as a list — Table A has eight *types*
  naming 13 URLs.
- **The artifact as the paired visual document** is superseded by the map (O4).
- **Map vs. site edits:** stage A changes no page (§1). The theme is touched only in stage B.

## 7 · Where we stopped, and how the next session runs

**Checkpoint, 2026-09-27 (team_00: «אחרי הפסקה נגדיר נקודת עצירה, תיעוד, שמירת מצב, דחיסה ואז נמשיך»).**

- **Approved:** T-01 hero (D5, D15–D18, D21, D24, D27, D31), T-08 CTA band (D6, D19, D23–D25, D31),
  T-04 text paragraph layout (D29, D32), all-button padding (D25), grid gutter 10px (D28).
- **Resolved after the checkpoint:** D33 → D34–D35 (five paragraph tones, each with its own text set; approved). Open items O1–O3, O5, O6, O9 below.
- **Next type:** T-06 split (text beside image), under rule D30 — «כל ה-6 בחלוקה לפי התוכן וכיוון
  התמונה». Show today's split and grid proposals by image orientation (landscape / portrait /
  cover), with the grid overlay, desktop and phone.
- **Working files:** `canon-map/ea-canon-map.html` (the map), `grid-proof.html` and
  `palette-check.html` (temporary, generated). Build sources: `tools/` — `build.py` is the spec
  and CSS; `type-defs.json` the texts, properties and fields; `uses.json` the census.
  **The builder is edited in the session scratchpad as `build_head.py` + `build_tail.py` and
  concatenated into `tools/build.py`; after compaction edit `tools/build.py` directly** (the
  scratchpad copy will be gone). `fetch.py` must be re-run first to recreate the source pages.
- **How we work (settled):** Nimrod judges by eye; every change is shown in the map (and the
  grid proof) before it is recorded; his words go into §3; approved rules go into
  `CONTENT-TYPES-CANON.md` in the same commit (pairing rule); team_90 measures. Short turns,
  images sent directly (`SendUserFile`), because the map file he has open is a snapshot.

Go type by type or by cross-cutting pattern, in the order team_00 chooses. For each: follow the
loop in the map README, record the ruling here in his words, update the map and
`CONTENT-TYPES-CANON.md` together, hand to team_90. Update §4's status and this file's date in
the same commit.
