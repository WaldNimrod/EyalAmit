# DONE — Meeting answers, 2026-09-24

Builder: Team 10. Theme live on staging: **1.5.121**. Commits on `main` (not pushed): `b44e91f`, `5b330f0`.
Both record surfaces share `ssotSha12 ec5382616e13`. Form uploaded: `FTP OK ea-eyal-hub/s007-content-gaps.html`.

Staging base: `http://eyalamit-co-il-2026.s887.upress.link`. Status codes below are without following redirects.

`ea-tokens.css` is byte-identical to HEAD (`e2319b564c941517813c3c699d5847c82038e1b71c381a792ab1029a0f748f98`). No colour token was edited.

A parallel uncommitted footer-social edit was already in the working tree. It was held aside so the deploy guard could see a clean `site/`, then put back. It is not on staging.

## Task 1 — Courses out of the menu

Page: `http://eyalamit-co-il-2026.s887.upress.link/learning/courses-external/`
Status: **200**, no `Location` header. Body still contains «יעלה בקרוב». Theme stylesheet `ver=1.5.121`.

The only edit in the canonical tree was removing the `courses-external` child from `site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php`.

Before the PHP upload, `#nav` on `/`, `/learning/`, `/historical-articles/`, `/galleries/`, `/contact/`, and the courses page contained **28** anchors, and the courses URL was inside that nav.

After theme 1.5.121, the same six pages:

| URL | Status | `#nav` count | Anchors inside `#nav` | `courses-external` in `#nav` |
|---|---|---|---|---|
| `/` | 200 | 1 | 27 | 0 |
| `/learning/` | 200 | 1 | 27 | 0 |
| `/historical-articles/` | 200 | 1 | 27 | 0 |
| `/galleries/` | 200 | 1 | 27 | 0 |
| `/contact/` | 200 | 1 | 27 | 0 |
| `/learning/courses-external/` | 200 | 1 | 27 | 0 |

The drop is exactly one. Pages other than the courses page contain zero occurrences of `courses-external`. On the courses page the remaining occurrences are the page's own canonical, breadcrumb JSON-LD, and post identity, not a menu item.

`/historical-articles/` also emits the GeneratePress `mobile-menu-control-wrapper` and `site-navigation` navs, plus the footer legal nav. That was already true in the pre-upload HTML (`id="nav"` was already 1). This round did not add a second primary nav.

`/about/` returned **301** to `/eyal-amit/` and was not followed.

## Task 2 — Historical articles, transfer only

Page: `http://eyalamit-co-il-2026.s887.upress.link/historical-articles/`
Status: **200**, no redirect. Canonical: `http://eyalamit-co-il-2026.s887.upress.link/historical-articles/`. Not in `#nav` (verified on the six pages above, and the page's own HTML has zero menu href to itself as a nav item). It was already live and already outside the canonical menu; this round filled it, it did not create it.

Sources:

- Shows: `https://www.eyalamit.co.il/הופעות/` (saved response 200).
- Visitor comments: `https://www.eyalamit.co.il/תגובות-גולשים-אודות-״מופע-הסיפורים-של/` (saved response 200).

Visible text is the text-node content of those pages: tags removed, `&nbsp;` collapsed to a space, double-encoded entities unescaped twice. Testimonial cards on the old page wrap the sentence in backtick characters; the stored sentence is the inner text.

### Transferred from the shows page

| Source | On the new page |
|---|---|
| Six body paragraphs, including the director credit `(בימוי: יניב קלדרון)` and the books sentence | yes |
| Press paragraphs under «הביקורות מפרגנות» (2) | yes, as the full paragraph |
| Named reviews, 11, in source order, including מיכל ליבדינסקי (she was missing from the previous archive) | yes, under the source heading «ביקורות נוספות על המופע» |
| Link sentence «ביקורות גולשים על מופע הסיפורים» | yes, as that sentence, immediately before the comments |
| Nine LayerSlider stage backgrounds (`ls-bg`) plus the full `אייל-עמית6.jpg` from the portrait `srcset` | yes, `assets/images/archive/stage-01.jpg` … `stage-10.jpg` |

### Transferred from the visitor-comments page

170 non-empty blocks (headings, quotes, names, and the source `*` separators), after the lead sentence above. Footer chrome «אייל עמית 052-4822842» was not copied. Asterisk lines are in the source, so they were kept.

### Not transferred

| Source piece | Why |
|---|---|
| Shows-page «גלריה» / `[rev_slider alias="HpGallery"]` | The frames are not in the HTML. Left empty. Recorded on the form and the board. |
| Blog-title list that the previous archive called `blogAlreadyOnStaging` | Those titles are not paragraphs of either source page, so the section is not rendered. |
| Two clipping alts «אייל עמית - מופע הסיפורים - ידיעות אחרונות» | The images were already on this page from the press-clippings page, which is a third source. The alt is not a sentence on the two named pages, so the alt is empty and kept as `altDropped`. The images stay. |

Heading sequence on the rendered page, no skipped level: H1 «כתבות היסטוריות» → H2 «מופע הסיפורים של אייל עמית» → H3 «הביקורות מפרגנות» → H4 «ביקורות נוספות על המופע» → the visitor headings (H3, then H4, then H2). Invented headings «בעיתונות», «המלצות על המופע», and «כתבות בבלוג» are absent.

The recommendations block is the 11 source reviews. It was not left empty, and no recommendation sentence was written.

## Task 3 — Readability, layout only

Measured in headless Chrome after `document.fonts.ready`, with `getBoundingClientRect` / line-box height, on the rendered page.

Horizontal overflow (`scrollWidth - clientWidth`) is **0** at 320, 375, 768, 1280, and 1440.

Column capacity of the body paragraphs (13.6px, the locked `--fs-xs` rung, not a new `font-size`):

| Viewport | First-line characters on the long body paragraphs | Press quotes (17px) |
|---|---|---|
| 320 | 34–37 | 26 |
| 375 | 42–46 | 32 |
| 768, 1280, 1440 | 62–66 | 62 |

At 768 and wider the line is inside 45–75. At 320 and 375 it is under 45. Reaching 45 on the 17px press quotes would need a smaller font or horizontal overflow. The type size was left alone. This gap is on both record surfaces (A3 `form.need` and `summaryHe`).

Short source lines such as `(בימוי: יניב קלדרון)` and «אייל» are the whole sentence, not the column width.

## Task 4 — Galleries from the old homepage gallery

Page: `http://eyalamit-co-il-2026.s887.upress.link/galleries/`
Status: **200**, no redirect. Canonical points at itself.

Source: Envira gallery `envira-gallery-wrap-17793` at the bottom of `https://www.eyalamit.co.il/`. **149** links, in that order.

| Check | Result |
|---|---|
| Images on the page | 149, all `old-home-gallery/g001` … `g149` |
| Each image URL | **200** (149/149) |
| sha256 of the live bytes vs the downloaded source bytes | **0 mismatches** |
| Sample/demo filenames (`studio-mosaic`, `studio-interior`, `garden.jpg`, `studio-didgs`, `eyal-playing`, `group-session-garden`, `eyal-workshop`) | **0** |
| Figcaptions | 149, none empty, each equal to the source attachment `title` |
| `data-envira-caption` on the source | empty on all 149, so no written caption existed |

The caption is the attachment title (double-unescaped, so `&#8211;` became an en dash). It was not composed. Galleries is on the seeded-defaults list so an ACF slot cannot put the six sample images back. The page H1 is the existing name «גלריות».

Overflow on `/galleries/` was 0 at 320, 375, 768, 1280, and 1440 before the measure-cap redeploy. The gallery markup did not change in 1.5.121.

## Task 5 — Record the eleven answers

Export: signature `371f7341103d`, `2026-09-24T18:07:50.249Z`, file `eyal-content-gaps-2026-09-20 (3).json`.
`choice` and `note` on all eleven rows were checked equal to that export, including «לכלסס» and «תרם נבדק» (the C1/C3 note, twice).

| Id | Mark | Status field |
|---|---|---|
| A3, A5, B3 | נענה | waiting (not closed) |
| B2, P037 | ממתין להכרעה בפגישה | waiting (not closed) |
| C1, C3, Q-HERO-ASK, Q-REPAIR-ALT, M8, M9 | פתוח | open |

Zero of these eleven have `status=closed`. The form has 11 `data-mark` attributes and zero `data-status="closed"`. C1 and C3 stayed open because the note wins over the choice. P037 was not built. B2 was not decided.

Surfaces, same hash `ec5382616e13`:

- Form: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`
- Board: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html`
- Hub copy: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/hub/dist/s007-content-gaps.html`

## Gaps left on the record

- HpGallery slider frames are not in the old shows HTML.
- Two ידיעות אחרונות clipping alts are blank because they are not on the two named source pages.
- Blog titles from the previous archive are not rendered.
- At 320px and 375px the locked type size cannot reach 45 characters per line without overflow.
- Gallery captions are attachment titles because the Envira caption field was empty.
- B2 and P037 wait for the meeting. The 2012 post hero was not built.
- Still open for Eyal at home: C1, C3, Q-HERO-ASK, Q-REPAIR-ALT, M8, M9.

Not touched: the learning page, the English page, contrast, the accessibility statement, the homepage FAQ, the second contact-mail receipt, the old Mukesh directory.

Next measurement belongs to Team 90.
