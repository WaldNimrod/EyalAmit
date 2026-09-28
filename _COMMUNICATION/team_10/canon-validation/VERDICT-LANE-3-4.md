# Canon map validation — lanes 3 and 4: VERDICT

**Run:** 2026-09-28 15:28 · checker `_COMMUNICATION/team_10/canon-validation/check_map.py` (re-runnable) · mandate `LANE-3-4-RULES-AND-COMPLETENESS.md` · map theme stamp 1.5.150.

Rules from the written canon only («Canon terms and site-wide rules», «Grid rules» in CONTENT-TYPES-CANON.md) and the locked compositions as they render in `canon-map/grids.html`. Nothing learned from `tools/build.py`'s CSS. Measured in headless Chromium (CDP) at 1440×900 and 375×812 on the committed `ea-canon-map.html`, every row opened, every tab panel shown, lazy images forced eager and loaded (assets come from the staging host via `<base href>`).

## Method, in short

- **Grid lines** at 1440: content box 168–1272, six columns of 175.67px, gutter 10; tolerance ±1.5px. Layout children = children of each content wrapper, descending through full-width wrappers; items of a side-by-side container stop the descent (card interiors are not layout). Absolutely-positioned decorations (aria-hidden / media / empty) and media wider than the content box are the canon's full-bleed exception. Controls (arrows, dots, filter chips, pagination) are listed, not graded.
- **Compositions**: every side-by-side container's items are mapped to (column-from, column-to, row-from, row-to) and compared with the same mapping of each K-n.m rendered in grids.html. Open lists (gallery, blog, testimonials, masonry, or >10) are checked for one per-row count in {1,2,3,6}.
- **Text**: p/li that are not headings, eyebrows, buttons or controls = running text. Outside cards/items it must sit in columns 2–5 (353.7–1086.3); in the hero and CTA band, columns 1–4 (their locked placement). Justification = computed `text-align: justify` with `text-align-last` start/auto/center.
- **Contrast**: every text run's colour against the actual pixels beneath it — a second screenshot with all text made transparent, sampled inside each line box; the graded value is the 5th percentile (worst 5% of the background under the glyphs), threshold 4.5:1, or 3:1 at ≥24px / ≥18.66px bold. Median and worst pixel are reported too.
- **Phone**: document scrollWidth, every unclipped descendant outside 0–375, and side-by-side items per container.

## Summary

- Approved examples measured: **45** in 12 rows (S-1, S-2, T-01, T-04, T-06, T-08, T-09, T-11, T-18, T-26, T-28, T-31).
- Locked compositions recognised from grids.html: K-1.1, K-1.2, K-2.1, K-2.2, K-2.3, K-3.1, K-3.2, K-3.3, K-4.1, K-4.2, K-4.3, K-4.4, K-5.1, K-5.2, K-5.3, K-5.4.
- Contrast @1440: 486 text runs sampled; closest to the threshold: T-28 #1 «מהקהילה» 4.61:1 (needs 4.5); T-08 #2 «לתיאום בדיקה לכלי» 4.63:1 (needs 4.5); T-08 #1 «לתיאום שיחת היכרות» 4.63:1 (needs 4.5); T-09 #7 «לתיאום שיחת היכרות» 4.63:1 (needs 4.5).
- Contrast @375: 471 text runs sampled; closest to the threshold: T-01 #4 «שיטה לעבודה עם הנשימה » 4.6:1 (needs 4.5); T-28 #1 «מהקהילה» 4.61:1 (needs 4.5); T-08 #2 «לתיאום בדיקה לכלי» 4.63:1 (needs 4.5); T-08 #1 «לתיאום שיחת היכרות» 4.63:1 (needs 4.5).
- Page scrollWidth: 1440 at 1440, 375 at 375. Images: {'images': 149, 'broken': []}.
- Rebuild: pre-fetched pages copied from /private/tmp/claude-501/-Users-nimrod-Documents-AOS-V5-EyalAmit-co-il-2026/253e5e9b-2806-414b-8efa-bd0839571a6b/scratchpad/canon; build: types: 35 groups: 9 bytes: 520203 host occurrences: 1; `map-source.html` byte-identical; `ea-canon-map.html` byte-identical; `open.html` byte-identical; `grids.html` byte-identical; `grid-proof.html` byte-identical; `palette-check.html` byte-identical; `tools/open_ids.json` byte-identical.
- Rebuild from a fresh fetch (informational): fresh fetch.py run: ok; build: types: 35 groups: 9 bytes: 520203 host occurrences: 1; `map-source.html` byte-identical; `ea-canon-map.html` byte-identical; `open.html` byte-identical; `grids.html` byte-identical; `grid-proof.html` byte-identical; `palette-check.html` byte-identical; `tools/open_ids.json` byte-identical.
- Paths: 239 mentions checked — 141 resolve directly, 90 by file name elsewhere in the repo (bare theme/document names), 8 are stated as retired/deleted/scratchpad in the same line, 0 are fetch.py outputs; 0 unresolved.
- Findings: lane 3 **27**, lane 4 **4** (blocker 1, fix 13, note 17).

### Compositions matched

- T-06 #1 «מאושר — תמונה לרוחב (5:4), צד התמונה שמאל: טקסט בטורים 1–3, תמונה בטורים 4–6. טקסט קצר —…»: K-2.1
- T-06 #2 «מאושר — תמונה לרוחב, צד התמונה ימין: תמונה בטורים 1–3, טקסט בטורים 4–6. טקסט ארוך — התמו…»: K-2.1
- T-06 #3 «מאושר — אותו דבר, עם שדה «המשך טקסט»: חלק מהטקסט הארוך עבר לטורים 2–5 מתחת לזוג»: K-2.1
- T-06 #4 «מאושר — תמונה לאורך (4:5), צד התמונה שמאל: טקסט בטורים 1–4, תמונה בטורים 5–6»: K-2.2
- T-06 #5 «מאושר — תמונה לאורך, צד התמונה ימין: תמונה בטורים 1–2, טקסט בטורים 3–6»: K-2.3
- T-11 #2 «מאושר — ארבעה דיוקנאות (K-4.2): גדול, שניים זה מעל זה, גדול — בלוק אחד, במילוי»: K-4.2
- T-09 #3 «מאושר — בולטים עם תמונות: הטקסט גדול והתמונה רקע שלו (כמו במקור, reveals.php); כותרת מימ…»: K-4.1
- T-09 #4 «מאושר — בולטים עם תמונות, הטקסט גדול על התמונה; K-4.2: גדול, שני קטנים זה מעל זה, גדול —…»: K-4.2
- T-09 #5 «מאושר — בולטים עם תמונות, הטקסט גדול על התמונה; K-4.3: 1 גדול ו-3 קטנים (3+1+1+1), במילוי»: K-4.3
- T-09 #6 «מאושר — 2 בשורה על הרשת; טקסט ממורכז ביישור בלוק (השורה האחרונה במרכז)»: K-2.1
- T-09 #8 «מאושר — 3 בשורה, כרטיס במסגרת דקה»: K-3.1
- T-09 #9 «מאושר — ארבעה כרטיסים: 1 גדול ו-3 קטנים (3+1+1+1), במסגרת דקה; הטקסט מיושר לתחתית, התמונ…»: K-4.3
- T-09 #10 «מאושר — ארבעה כרטיסים: שתי שורות של 2»: K-4.1
- T-18 #3 «מאושר — ציטוט: ריווח קטן ומסגרת דקה בלבד (G-12.1), 2 בשורה על הרשת»: K-2.1
- T-31 #1 «מאושר — יצירת קשר בשורה אחת על הרשת, נכנסת במסך אחד. טורים 1–4: הטופס (שדות בזוגות, בלי …»: K-2.2

### Lane 4 — per current type

- T-01 «הירו» (מאושר) — old T-01; uses union 134, map says 134, lists 134; examples 6; summary «134 עמודים»
- T-04 «פסקת טקסט» (מאושר בחלקו) — old T-04, T-05, T-07; uses union 26, map says 26, lists 26; examples 11; summary «26 עמודים»
- T-21 «אקורדיון» (מאושר בחלקו) — old T-21, T-22; uses union 17, map says 17, lists 17; examples 2; summary «17 עמודים»
- T-29 «רשימת שנים» (מאושר בחלקו) — old T-29, T-32; uses union 3, map says 3, lists 3; examples 2; summary «3 עמודים»
- T-23 «תוכן עניינים» (מאושר) — old T-23; uses union 1, map says 1, lists 1; examples 1; summary «עמוד אחד»
- T-06 «טקסט ותמונה» (מאושר בחלקו) — old T-06, T-16, T-17; uses union 9, map says 9, lists 9; examples 8; summary «9 עמודים»
- T-10 «פס תמונה ברוחב מלא» (פתוח) — old T-10, T-12; uses union 5, map says 5, lists 5; examples 2; summary «5 עמודים»
- T-11 «רשת תמונות» (מאושר) — old T-11; uses union 11, map says 11, lists 11; examples 3; summary «11 עמודים»
- T-09 «כרטיסים» (מאושר) — old T-09, T-13, T-14, T-15, T-24, T-25, T-35; uses union 58, map says 58, lists 58; examples 18; summary «58 עמודים»
- T-18 «המלצות» (מאושר) — old T-18, T-19, T-20; uses union 7, map says 7, lists 7; examples 6; summary «7 עמודים»
- T-28 «פוסטים מפייסבוק» (מאושר) — old T-28; uses union 1, map says 1, lists 1; examples 2; summary «עמוד אחד»
- T-26 «וידאו» (מאושר) — old T-26, T-36, T-27; uses union 5, map says 5, lists 5; examples 4; summary «5 עמודים»
- T-08 «פס קריאה לפעולה» (מאושר) — old T-08; uses union 19, map says 19, lists 19; examples 3; summary «19 עמודים»
- T-31 «יצירת קשר» (מאושר) — old T-31; uses union 1, map says 1, lists 1; examples 2; summary «עמוד אחד»
- P-1 «עמוד קוד מודפס (QR)» (מאושר) — old T-33; uses union 48, map says 48, lists 48; examples 1; summary «48 עמודים»
- P-2 «פוסט בלוג» (מאושר) — old T-34, T-37; uses union 52, map says 52, lists 52; examples 2; summary «52 עמודים»
- S-2 «כפתורים» (מאושר) — old —; uses union 0, map says None, lists 0; examples 5; summary «כרגע לא בשימוש»
- S-1 «ממתין לתוכן» (מאושר) — old T-30, T-27; uses union 5, map says 5, lists 5; examples 3; summary «5 עמודים»

## Lane 3 findings

### L3-1 · blocker · defect

- **Where:** T-09 #3 «מאושר — בולטים עם תמונות: הטקסט גדול והתמונה רקע שלו (כמו במקור, reveals.php); כותרת מימ…» @375 (and 2 more: T-09 #4; T-09 #5)
- **Rule:** Phone/desktop — the content of every approved example is visible (Grid §8, one column on phones)
- **Measured:** 4 text runs are ≥50% cut away by `div.whom__i.r`, e.g. «מתאים למי שסובל מסימפטומים» (100% hidden); «למי שמבין שמדובר בתהליך אי» (100% hidden); «למי שרוצה לעבוד עם הנשימה » (100% hidden). Cause: `div.whom__i.r` is 0px tall with 209px of content, `div.whom__i.r.r2` is 0px tall with 209px of content, `div.whom__i.r.r3` is 0px tall with 209px of content, `div.whom__i.r.r4` is 0px tall with 209px of content

### L3-2 · fix · defect

- **Where:** T-01 #1 «מאושר — גדול, עם סרטון: הטקסט בטורים 1–4, הכפתור בטורים 5–6 בשורה אחת, מיושר לתחתית. כמע…» (and 3 more: T-01 #2; T-01 #3; T-01 #4)
- **Rule:** Grid §1 — every element's edges on a column line (±1.5px)
- **Measured:** `p.phero__s` «שיטה לעבודה עם הנשימה באמצעות » 586.8px wide: left edge 685.2 (nearest line 715.0, off 29.8px)

### L3-3 · fix · defect

- **Where:** T-01 #5 «מאושר — קטן: 44%, גובה מינימלי — טקסט ארוך מגדיל אותו. מוצג עם התוכן הקצר של עמוד יצירת …»
- **Rule:** Grid §1 — every element's edges on a column line (±1.5px)
- **Measured:** `p.phero__s` «ניתן ליצור קשר לתיאום שיחת היכ» 586.8px wide: left edge 685.2 (nearest line 715.0, off 29.8px)

### L3-4 · fix · defect

- **Where:** T-01 #5 «מאושר — קטן: 44%, גובה מינימלי — טקסט ארוך מגדיל אותו. מוצג עם התוכן הקצר של עמוד יצירת …»
- **Rule:** Grid §7 — an eyebrow never repeats its heading
- **Measured:** eyebrow «צור קשר» = heading

### L3-5 · fix · defect

- **Where:** T-09 #3 «מאושר — בולטים עם תמונות: הטקסט גדול והתמונה רקע שלו (כמו במקור, reveals.php); כותרת מימ…»
- **Rule:** Canon terms — running text block-justified (justify; last line start, or centre when centred)
- **Measured:** `p.whom__p` «מתאים למי שסובל מסימפטומים ב» 3 lines, text-align start/auto; `p.whom__p` «למי שמבין שמדובר בתהליך אישי» 2 lines, text-align start/auto; `p.whom__p` «למי שרוצה לעבוד עם הנשימה בצ» 2 lines, text-align start/auto; `p.whom__p` «למי שמעוניין לבדוק כיוון אחר» 2 lines, text-align start/auto
- **Note:** Large bullet text set on an image; the canon's rule is «paragraphs and list items … always, site-wide», so it is graded — downgrade only if team_00 rules image bullets are display text.

### L3-6 · fix · defect

- **Where:** T-09 #4 «מאושר — בולטים עם תמונות, הטקסט גדול על התמונה; K-4.2: גדול, שני קטנים זה מעל זה, גדול —…»
- **Rule:** Canon terms — running text block-justified (justify; last line start, or centre when centred)
- **Measured:** `p.whom__p` «מתאים למי שסובל מסימפטומים ב» 3 lines, text-align start/auto; `p.whom__p` «למי שמבין שמדובר בתהליך אישי» 3 lines, text-align start/auto; `p.whom__p` «למי שרוצה לעבוד עם הנשימה בצ» 3 lines, text-align start/auto; `p.whom__p` «למי שמעוניין לבדוק כיוון אחר» 3 lines, text-align start/auto
- **Note:** Large bullet text set on an image; the canon's rule is «paragraphs and list items … always, site-wide», so it is graded — downgrade only if team_00 rules image bullets are display text.

### L3-7 · fix · defect

- **Where:** T-09 #5 «מאושר — בולטים עם תמונות, הטקסט גדול על התמונה; K-4.3: 1 גדול ו-3 קטנים (3+1+1+1), במילוי»
- **Rule:** Canon terms — running text block-justified (justify; last line start, or centre when centred)
- **Measured:** `p.whom__p` «מתאים למי שסובל מסימפטומים ב» 3 lines, text-align start/auto; `p.whom__p` «למי שמבין שמדובר בתהליך אישי» 5 lines, text-align start/auto; `p.whom__p` «למי שרוצה לעבוד עם הנשימה בצ» 6 lines, text-align start/auto; `p.whom__p` «למי שמעוניין לבדוק כיוון אחר» 5 lines, text-align start/auto
- **Note:** Large bullet text set on an image; the canon's rule is «paragraphs and list items … always, site-wide», so it is graded — downgrade only if team_00 rules image bullets are display text.

### L3-8 · fix · defect

- **Where:** T-09 #7 «מאושר — 3 בשורה ברוחב התוכן; כותרת גדולה יותר»
- **Rule:** Grid §1 — every element's edges on a column line (±1.5px)
- **Measured:** `div.start__in.center` «איך מתחילים שיחת היכרות אפשר ל» 1100px wide: right edge 1270 (nearest line 1272.0, off 2.0px); left edge 170 (nearest line 168.0, off 2.0px)

### L3-9 · fix · defect

- **Where:** T-08 #1 «מאושר — רקע חול: פס נמוך יותר, הלוגו גדול ודהוי ברקע, צמוד לקצה המסך, הטקסט בטורים 1–4, …» (and 1 more: T-08 #2)
- **Rule:** Grid §1 — six columns on the 1104px content box
- **Measured:** `div.cta-band__in` content box is 160–1280 (1120px), not 168–1272 (1104px); its columns are 178.33px, the site's are 175.67px. Consequence — its children sit on its own lines, not the site's: `div.cta-band__txt` right edge 1280 (nearest line 1272.0, off 8.0px); left edge 536.7 (nearest line 539.3, off 2.6px) · `div.cta-band__act` right edge 526.7 (nearest line 529.3, off 2.6px); left edge 160 (nearest line 168.0, off 8.0px); running text at 536.7–1280 instead of columns 1–4 (539.3–1272)

### L3-10 · fix · defect

- **Where:** T-08 #1 «מאושר — רקע חול: פס נמוך יותר, הלוגו גדול ודהוי ברקע, צמוד לקצה המסך, הטקסט בטורים 1–4, …»
- **Rule:** Canon terms — running text block-justified (justify; last line start, or centre when centred)
- **Measured:** `p.cta-band__p` «ייתכן שאתם מחפשים שינוי בנשי» 3 lines, text-align right/start

### L3-11 · fix · defect

- **Where:** T-11 #1 «מאושר — כותרת מימין עם תת-כותרת, תמונה ראשית ברוחב מלא; אחריה שורות של 3 תמונות לרוחב (4…» @375
- **Rule:** Grid §8 — phone: an item ≥3 columns wide or tall takes both columns
- **Measured:** `div.gallery.r` item 1 of 19 (desktop columns 1–6, 1 row(s) tall) is 134.5px of the 279px column pair

### L3-12 · fix · defect

- **Where:** T-11 #2 «מאושר — ארבעה דיוקנאות (K-4.2): גדול, שניים זה מעל זה, גדול — בלוק אחד, במילוי» @375
- **Rule:** Grid §8 — phone: an item ≥3 columns wide or tall takes both columns
- **Measured:** `div.gallery.gallery--portraits.r` item 1 of 4 (desktop columns 1–2, 2 row(s) tall) is 134.5px of the 279px column pair

### L3-13 · fix · defect

- **Where:** T-11 #2 «מאושר — ארבעה דיוקנאות (K-4.2): גדול, שניים זה מעל זה, גדול — בלוק אחד, במילוי» @375
- **Rule:** Grid §8 — phone: an item ≥3 columns wide or tall takes both columns
- **Measured:** `div.gallery.gallery--portraits.r` item 4 of 4 (desktop columns 5–6, 2 row(s) tall) is 134.5px of the 279px column pair

### L3-14 · note · rule conflict

- **Where:** T-06 #1 «מאושר — תמונה לרוחב (5:4), צד התמונה שמאל: טקסט בטורים 1–3, תמונה בטורים 4–6. טקסט קצר —…»
- **Rule:** Grid §1 «no element off the grid» vs the type's own inner margin — needs a ruling
- **Measured:** `div.r` spans 725–1272 on the grid, but its visible content spans 765–1272 (inset 0px right, 40px left) — the visible text edge is off the grid
- **Note:** An unframed text column has no visible box; the reader sees the text edge. If the canon means the cell and allows an inner breathing margin (T-06 rule «מרווח נשימה בצד הטקסט שפונה לתמונה»), this is compliant; if it means the visible text, the text is off the grid. Rule conflict, not graded as a defect.

### L3-15 · note · rule conflict

- **Where:** T-06 #2 «מאושר — תמונה לרוחב, צד התמונה ימין: תמונה בטורים 1–3, טקסט בטורים 4–6. טקסט ארוך — התמו…»
- **Rule:** Grid §1 «no element off the grid» vs the type's own inner margin — needs a ruling
- **Measured:** `div.r` spans 168–715 on the grid, but its visible content spans 168–675 (inset 40px right, 0px left) — the visible text edge is off the grid
- **Note:** An unframed text column has no visible box; the reader sees the text edge. If the canon means the cell and allows an inner breathing margin (T-06 rule «מרווח נשימה בצד הטקסט שפונה לתמונה»), this is compliant; if it means the visible text, the text is off the grid. Rule conflict, not graded as a defect.

### L3-16 · note · rule conflict

- **Where:** T-06 #3 «מאושר — אותו דבר, עם שדה «המשך טקסט»: חלק מהטקסט הארוך עבר לטורים 2–5 מתחת לזוג»
- **Rule:** Grid §1 «no element off the grid» vs the type's own inner margin — needs a ruling
- **Measured:** `div.r` spans 168–715 on the grid, but its visible content spans 168–675 (inset 40px right, 0px left) — the visible text edge is off the grid
- **Note:** An unframed text column has no visible box; the reader sees the text edge. If the canon means the cell and allows an inner breathing margin (T-06 rule «מרווח נשימה בצד הטקסט שפונה לתמונה»), this is compliant; if it means the visible text, the text is off the grid. Rule conflict, not graded as a defect.

### L3-17 · note · rule conflict

- **Where:** T-06 #4 «מאושר — תמונה לאורך (4:5), צד התמונה שמאל: טקסט בטורים 1–4, תמונה בטורים 5–6»
- **Rule:** Grid §1 «no element off the grid» vs the type's own inner margin — needs a ruling
- **Measured:** `div.r` spans 539.3–1272 on the grid, but its visible content spans 579.3–1272 (inset 0px right, 40.0px left) — the visible text edge is off the grid
- **Note:** An unframed text column has no visible box; the reader sees the text edge. If the canon means the cell and allows an inner breathing margin (T-06 rule «מרווח נשימה בצד הטקסט שפונה לתמונה»), this is compliant; if it means the visible text, the text is off the grid. Rule conflict, not graded as a defect.

### L3-18 · note · rule conflict

- **Where:** T-06 #5 «מאושר — תמונה לאורך, צד התמונה ימין: תמונה בטורים 1–2, טקסט בטורים 3–6»
- **Rule:** Grid §1 «no element off the grid» vs the type's own inner margin — needs a ruling
- **Measured:** `div.r` spans 168–900.7 on the grid, but its visible content spans 168–860.7 (inset 40.0px right, 0px left) — the visible text edge is off the grid
- **Note:** An unframed text column has no visible box; the reader sees the text edge. If the canon means the cell and allows an inner breathing margin (T-06 rule «מרווח נשימה בצד הטקסט שפונה לתמונה»), this is compliant; if it means the visible text, the text is off the grid. Rule conflict, not graded as a defect.

### L3-19 · note · interpretation

- **Where:** T-11 #1 «מאושר — כותרת מימין עם תת-כותרת, תמונה ראשית ברוחב מלא; אחריה שורות של 3 תמונות לרוחב (4…»
- **Rule:** Canon terms — is a sub-heading/lede running text? (canon: «paragraphs and list items»)
- **Measured:** `lead.cm-sub` «תת-כותרת — שורה אחת שמסבירה » 1 lines, start/start

### L3-20 · note · interpretation

- **Where:** T-09 #3 «מאושר — בולטים עם תמונות: הטקסט גדול והתמונה רקע שלו (כמו במקור, reveals.php); כותרת מימ…» (and 2 more: T-09 #4; T-09 #5)
- **Rule:** Canon terms — is a sub-heading/lede running text? (canon: «paragraphs and list items»)
- **Measured:** `lead.cm-sub` «תת-כותרת — שורה אחת שמסבירה » 1 lines, start/start

### L3-21 · note · rule conflict

- **Where:** T-09 #6 «מאושר — 2 בשורה על הרשת; טקסט ממורכז ביישור בלוק (השורה האחרונה במרכז)»
- **Rule:** Grid §1 «no element off the grid», applied to buttons
- **Measured:** «למידע נוסף על טיפול בדיג'רידו» 888.7–1108.3 (219.6px); «למידע נוסף על סאונד הילינג» 339–544 (205px)
- **Note:** Buttons sized to their label («ריווח מצומצם סביב הטקסט», S-2) are not on column lines; the hero/CTA buttons fill columns 5–6. Whether §1 binds a free-standing button needs a ruling.

### L3-22 · note · rule conflict

- **Where:** T-09 #7 «מאושר — 3 בשורה ברוחב התוכן; כותרת גדולה יותר»
- **Rule:** Grid §1 «no element off the grid», applied to buttons
- **Measured:** «לתיאום שיחת היכרות» 637.3–802.7 (165.4px)
- **Note:** Buttons sized to their label («ריווח מצומצם סביב הטקסט», S-2) are not on column lines; the hero/CTA buttons fill columns 5–6. Whether §1 binds a free-standing button needs a ruling.

### L3-23 · note · no visible effect

- **Where:** T-08 #2 «מאושר — רקע כהה: אותו מבנה»
- **Rule:** Canon terms — running text block-justified (single-line blocks: no visible effect)
- **Measured:** 1 one-line p/li not justify, e.g. «גם אם לא בטוחים בדיקה קצ» right/start

### L3-24 · note · rule conflict

- **Where:** T-31 #1 «מאושר — יצירת קשר בשורה אחת על הרשת, נכנסת במסך אחד. טורים 1–4: הטופס (שדות בזוגות, בלי …»
- **Rule:** Grid §1 «no element off the grid» vs the type's own inner margin — needs a ruling
- **Measured:** `div.ea-entrance` spans 539.3–1272 on the grid, but its visible content spans 579.3–1272 (inset 0px right, 40.0px left) — the visible text edge is off the grid
- **Note:** An unframed text column has no visible box; the reader sees the text edge. If the canon means the cell and allows an inner breathing margin (T-06 rule «מרווח נשימה בצד הטקסט שפונה לתמונה»), this is compliant; if it means the visible text, the text is off the grid. Rule conflict, not graded as a defect.

### L3-25 · note · no visible effect

- **Where:** T-31 #1 «מאושר — יצירת קשר בשורה אחת על הרשת, נכנסת במסך אחד. טורים 1–4: הטופס (שדות בזוגות, בלי …»
- **Rule:** Canon terms — running text block-justified (single-line blocks: no visible effect)
- **Measured:** 3 one-line p/li not justify, e.g. «שיחת היכרות ראשונית ללא » start/auto; «ליווי אישי, אחד על אחד» start/auto; «מענה אישי תוך יום עסקים » start/auto

### L3-26 · note · rule conflict

- **Where:** S-2 #1 «מאושר — כפתורים על רקע שמנת» (and 4 more: S-2 #2; S-2 #3; S-2 #4; S-2 #5)
- **Rule:** Grid §1 «no element off the grid», applied to buttons
- **Measured:** «כפתור מלא» 1167.1–1272 (104.9px); «כפתור מתאר» 1037.6–1153.1 (115.5px)
- **Note:** Buttons sized to their label («ריווח מצומצם סביב הטקסט», S-2) are not on column lines; the hero/CTA buttons fill columns 5–6. Whether §1 binds a free-standing button needs a ruling.

### L3-27 · note · artefact

- **Where:** T-18 #3 «מאושר — ציטוט: ריווח קטן ומסגרת דקה בלבד (G-12.1), 2 בשורה על הרשת» @375
- **Rule:** Map furniture — the «מאושר» badge must not cover the example
- **Measured:** the badge overlaps text: «"בדיקת השינה לא הדגימה ת»
- **Note:** Map-only overlay; contrast under it is sampled with the badge hidden.

## Lane 4 findings

### L4-1 · fix · defect

- **Where:** tools/canon_types.py
- **Rule:** Each of the 35 old IDs appears in exactly one current type
- **Measured:** T-27 appears in 2 current types: ['T-26', 'S-1']
- **Note:** Probably deliberate (the pending-video look is both a video variant and the shared «waiting for content» state), but it breaks the one-home rule and double-counts T-27's pages in two rows. Either the rule gets an exception or one listing goes.

### L4-2 · note · data gap

- **Where:** ea-canon-map.html S-2 «כפתורים»
- **Rule:** Uses: a type with no old ID cannot be counted by the census
- **Measured:** the row says «כרגע לא בשימוש» because no old type feeds it — yet it is a shared element present on most pages

### L4-3 · note · doc drift

- **Where:** canon-map/README.md «Structure»
- **Rule:** README agrees with tools/canon_types.py
- **Measured:** README says 17 rows; canon_types.py has 18 (P-1, P-2, S-2, S-1 besides the T-types)

### L4-4 · note · doc drift

- **Where:** canon-map/README.md
- **Rule:** README agrees with the retired-ID set (T-02, T-03 retired → 35 old IDs)
- **Measured:** README says «36 types remain»; with T-02 and T-03 retired there are 35 old type IDs

## Measurement artefacts neutralised (not findings)

- The map's «מאושר» badge sits over each example; it is hidden while sampling contrast (its overlap is reported as a map-only note).
- Carousel cards waiting off-stage (fully clipped by the carousel viewport) are not graded for grid edges.
- Text truncated by a line-clamp on its own block (blog excerpts) and the fold's deliberate fade are not «hidden content».
- Absolutely-positioned, aria-hidden decorations (the hero `.arcs`, scrims, the CTA logo) are the canon's full-bleed exception.
- Controls (carousel arrows and dots, blog filter chips, pagination) are listed but not graded against column lines.
- Single-line p/li that are not justified have no visible effect; they are notes, not fixes.

(n) counts blockers and fixes; notes are listed above but not counted.

VERDICT: FINDINGS (14)
