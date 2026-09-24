VERDICT: PASS

# Team 90 — meeting embarrassment audit — 2026-09-24

**Control pass, read-only.** Builder of the claims under test: Team 110 (Cursor Grok). The builder
did not audit itself. Scope is the single question the mandate asks — will Eyal or Nimrod be shown,
in the meeting, something that contradicts what Eyal already wrote or what live staging serves? No
accessibility sign-off, no Lighthouse, no fix applied.

**39 candidate rows across five mandatory probes — P1 18, P2 6, P3 6, P4 4, P5 5. Every row REFUTED
by a live quote. Zero confirmed. Zero hunt gaps.**

Method: every page fetched as a full GET with redirects **not** followed; `alt` read from the `img`
whose own `src` carries the filename, never a neighbour; entities decoded with `html.unescape`
before comparing, so `&#039;` and `'` count as the same character per the mandate; set claims
compared in both directions, never by length. 18 distinct URLs fetched, all HTTP 200 with
substantive bodies. The form was fetched three times and is byte-identical (md5
`0ec4b39f903572c3928767c30ccd4d04`), so no row rests on a moving target.

## Probe table

| Probe | Candidate | Refutation attempted | Result | Live URL | Live quote | His quote |
|---|---|---|---|---|---|---|
| P1 | `mokesh-13.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | זו ג'מה הספרדייה, תלמידה ותיקה של מוקש | זו ג'מה הספרדייה, תלמידה ותיקה של מוקש |
| P1 | `mokesh-14.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | אניטה אשתו של מוקש | אניטה אשתו של מוקש |
| P1 | `mokesh-15.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | הבנים של מוקש ואני | הבנים של מוקש ואני |
| P1 | `mokesh-11.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | תמונה של מוקש עם ענת אשתי והילדים מ 2018 | תמונה של מוקש עם ענת אשתי והילדים מ 2018 |
| P1 | `mokesh-03.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | אני , גיא אח שלי ומוקש | אני , גיא אח שלי ומוקש |
| P1 | `mokesh-10.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | מוקש משקיף על הגנגס סמוך לקוטלי | מוקש משקיף על הגנגס סמוך לקוטלי |
| P1 | `mokesh-08.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | זה השלד של הסטודיו החדש בקוטלי. ככה עמד 6 שנים עד שאני הגעתי | זה השלד של הסטודיו החדש בקוטלי. ככה עמד 6 שנים עד שאני הגעתי |
| P1 | `mokesh-09.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | הביקתה בקוטלי | הביקתה בקוטלי |
| P1 | `mokesh-04.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | בחצר אצל מוקש | בחצר אצל מוקש |
| P1 | `peek-21.jpeg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ | אני ומוקש | אני ומוקש |
| P1 | `peek-29.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ | זה הדיג' שנגנב. צילום אחרון שלו בבית המלאכה אצל מוקש 2003. אחרי האירוע כל מסלול חיי הוסת והתחלתי לעסוק בדיג'רידו | זה הדיג' שנגנב. צילום אחרון שלו בבית המלאכה אצל מוקש 2003. אחרי האירוע כל מסלול חיי הוסת והתחלתי לעסוק בדיג'רידו |
| P1 | `tsva-13.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | שנת 2003 - מוקש אוחז בספר הראשון שלי שראה אור ב 2001 | שנת 2003 - מוקש אוחז בספר הראשון שלי שראה אור ב 2001 |
| P1 | `stand-01.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/stands-storage/ | סטנד רצפתי | סטנד רצפתי |
| P1 | `stand-02.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/stands-storage/ | זה סטנד רצפתי | זה סטנד רצפתי |
| P1 | `stand-03.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/stands-storage/ | סטנד רצפתי | סטנד רצפתי |
| P1 | `stand-04.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/stands-storage/ | סטנד רצפתי | סטנד רצפתי |
| P1 | `stand-05.jpg` may carry a shorter or older sentence than Eyal wrote | Read the alt on the img whose src carries this filename, decoded entities, compared byte-for-byte to his note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/stands-storage/ | סטנד לתלייה על הקיר | סטנד לתלייה על הקיר |
| P1 | The nine gallery files with no identity note may have had a sentence invented for them | Read all nine alts on the live page and compared each to the export note, which is empty for all nine | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/ | מוקש דהימן (identical on mokesh-01, 02, 05, 06, 07, 12, 16, 17, 18) | (no identity note in the export — note field is empty for all nine) |
| P2 | `tsva-05.jpg` — his hero placement note may have been written onto the image as its caption | Read the live alt for that exact img and compared it to the placement note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ | גב הספר עם טקסט תקציר וברקוד | לשים בהירו |
| P2 | `kush-05.jpg` — his hero placement note may have been written onto the image as its caption | Read the live alt for that exact img and compared it to the placement note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/ | כריכת הספר פרושה, צד קדמי ואחורי עם טקסט | לשים בהירו |
| P2 | `veka-83.jpg` — his gallery at the bottom note may have been written onto the image as its caption | Read the live alt for that exact img and compared it to the placement note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | קערת דובדבנים טריים לצד עותק הספר וכתבת | להוסיף לגלריה הכללית בתחתית הדף |
| P2 | `veka-07.jpg` — his article assignment + archive note may have been written onto the image as its caption | Read the live alt for that exact img and compared it to the placement note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | כתבת עיתון עם תמונת השחקן שי אביבי בישיבה בחוץ | כתבה אודות מופע הסיפורים שלי. לשים בדף הארכיון. כתבות היסטוריות |
| P2 | `veka-06.jpg` — his archive placement note may have been written onto the image as its caption | Read the live alt for that exact img and compared it to the placement note | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/ | כתבת עיתון על אייל עמית עם תמונתו בתנוחת הופעה | להוסיף לארכיון. כתבות היסטוריות |
| P2 | The child-with-phone image on the contact page may have been given an invented alt | Enumerated both img tags on /contact/ and read the alt on the one whose src is eyal-child-phone.jpg | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/contact/ | (alt is present and empty: alt="") | (no note in the export — must stay empty) |
| P3 | The form may still carry a closed-items table | Parsed every <table> in the live form; there is exactly one, headed for items waiting on Eyal | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html | one table only, header: ממתין לך (16) | (closed items must not be tabled) |
| P3 | The form may carry a table of items waiting on Nimrod | Same table parse plus a text scan for נימרוד: one prose sentence, no table | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html | מה שנסגר, ומה שממתין לנימרוד, לא מופיעים כאן | (one sentence is allowed; a table is not) |
| P3 | The form may show an item that is not one of the sixteen, or omit one | Set equality in both directions between the live data-id values and the mandated sixteen | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html | A3 A5 B2 B3 C1 C3 M1 M2 M3 M5 M6 M7 M8 M9 P037 Q-HERO-ASK — expected-minus-got empty, got-minus-expected empty | (exactly these sixteen) |
| P3 | A3 may still say the placeholder line is in the body | Read the whole A3 block text on the live form | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html | הארכיון חי ומחוץ לסרגל: מופע הסיפורים, בעיתונות, המלצות. שורת מציין-המקום ירדה מהעמוד ומהשיתוף. מה חסר: הקטלוג המלא של שאר הכתבות, אחרי הסריקה שהבטחת | (archive live, placeholder gone, remaining wait is his catalog) |
| P3 | The historical page may still contain אופציונלי | Fetched the page and searched the visible body with markup and scripts stripped; also checked every literal 'placeholder' hit | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/historical-articles/ | visible body contains neither אופציונלי nor placeholder; all 11 'placeholder' hits are CSS class names such as ea-testimonial-card__avatar-placeholder | (the placeholder line must be gone) |
| P3 | Already-decided topics may be re-asked as open questions | Scanned the form for burger, press, shows, historical and courses; burger absent entirely, the others appear only as settled context | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html | מקום בסרגל כבר הוכרע: מחוץ לתפריט — and A5: העמוד בתפריט תחת «לימוד והכשרה ← קורסים», ועליו כתוב «יעלה בקרוב» | (decided items must not be re-asked; A5 waiting for links is legitimate) |
| P4 | T-NAV-HOLD may be missing from the board or not marked as waiting on Nimrod | Parsed the opening tag of the section whose id is T-NAV-HOLD, not a text window around it | REFUTED | _COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html | <section class="item" id="T-NAV-HOLD" data-status="waiting" data-waiting="nimrod" …> | (must be present and waiting on Nimrod) |
| P4 | T-GALLERY-ASSIGNED and T-BLOG-HERO-OLD may be missing, or their absence from the form may be a real gap | Read both opening tags on the board, then checked the form carries M6 and P037 which hold those same waits | REFUTED | _COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html | both id=… data-waiting="eyal"; the form carries M6 and P037 | (board items; their absence from the form is REFUTED by M6 and P037) |
| P4 | The optimization section may say the identity notes are still awaiting a decision | Read the image-text row of the optimization table in full | REFUTED | _COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html | המשפטים עלו לאתר הבדיקה … הערות מיקום לא נכתבו על התמונות | (it must say the sentences are on staging and placement notes were not written onto images) |
| P4 | A5 may be missing from the board | Enumerated all 76 board item ids with their data-waiting values | REFUTED | _COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html | id="A5" data-waiting="eyal" present among 76 board items | (A5 must be present) |
| P5 | One of the nine repair files may not be in live-theme, or may not name /repair/ in renderedAt | Parsed MEDIA_DATA out of the 716k page and checked collections and renderedAt per file, matching on src not a bare filename key | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/media-filter.html | all nine: collections ["live-theme","old-site"], renderedAt [{"page": "/repair/", "defaultsFile": "repair-defaults.php"}] | (all nine integrated into the repair page) |
| P5 | The chooser may claim integration the live theme does not show | Fetched the live repair page and matched each of the nine on the img src; also fetched one image as binary | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/repair/ | 9 of 9 render on the live page; EA-000161.jpg returns HTTP 200, 219215 bytes, image/jpeg 960x717 | (chooser and live theme must agree) |
| P5 | mokesh-13.jpg currentAlt in the chooser may differ from the Gemma sentence | Read currentAlt from the parsed MEDIA_DATA entry whose src carries mokesh-13.jpg | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/media-filter.html | זו ג'מה הספרדייה, תלמידה ותיקה של מוקש | זו ג'מה הספרדייה, תלמידה ותיקה של מוקש |
| P5 | EYAL_LOOSE_NEED may not be 179, or may not equal status=need with an empty assignedPage | Recomputed the set from the 851-item export and compared both directions, not by length; an id was not dropped for already sitting on a page | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/media-filter.html | 179 ids; gallery-minus-recomputed empty, recomputed-minus-gallery empty | (exactly that set) |
| P5 | The unassigned page may not show 179 | Fetched the page and read its title, h1 and img count | REFUTED | http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/media-filter-unassigned-need.html | title: נחוץ בלי עמוד — 179 · h1: 179 תמונות שסומנו נחוץ בלי שם עמוד · 179 img tags | (title count must be 179) |
## Confirmed

None. No candidate survived its refutation, so there is nothing to correct before the meeting.

## Hunt gaps

None. All five sources named in the mandate exist and were read; all 18 live URLs returned 200.

## Three things worth recording, none of them findings

Method notes, not embarrassments. None changes the verdict.

**Four P1 filenames are not in the export under those names.** `mokesh-09.jpg`, `peek-21.jpeg`,
`peek-29.jpg` and `tsva-13.jpg` appear in the export as `EA-000310.jpeg`, `EA-000198.jpeg`,
`EA-000160.jpg` and `EA-000013.jpg` — the theme serves them renamed. Their notes are identical to
the mandate's quotes, so every row still rests on his words; a filename-keyed lookup alone would
have reported four false differences.

**The form's byte count differs by reading.** 55,493 bytes on the wire, 47,358 characters decoded —
Hebrew is multi-byte in UTF-8. Not a discrepancy.

**Nine of the eleven images on the live repair page carry an empty `alt`,** including seven of the
nine files P5 names. That is an accessibility question and it belongs to Team 50, not to this pass.
It is recorded only so it is not mistaken for something this audit cleared. It is not an
embarrassment under any of the six definitions: no note of Eyal's is contradicted, and the chooser
gallery's integration claim matches the live page.
