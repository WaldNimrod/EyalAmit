# DONE — board rebuild, 2026-09-25

Mandate: `_COMMUNICATION/team_90/AUDIT-2026-09-24/MANDATE-BOARD-REBUILD-2026-09-25.md`
Executed by team_10 (builder). Report in English, code comments in English, per the mandate's own
language line (the global Hebrew-report rule is superseded here by that explicit instruction).

## Starting state

- Branch `main`. **Five commits sitting unpushed** (`b8f44ec` … `4ff6fdc`) — confirmed via
  `git status -sb` (`ahead 5`) before touching anything. Did not attempt to push, did not rewrite
  history. This round's changes sit on top of them as two more unstaged edits, exactly as
  instructed.
- The working tree already carried uncommitted edits to `S007-WORK-SSOT.json`,
  `content-gaps-2026-09-21/GALLERY.html` and `scripts/s007_render_work_ssot.py` from the prior
  "S007 closing round" work (the old multi-section board, already updated to the post-21-card
  state but not yet rebuilt into the two-section shape). I built on top of that, not on a clean
  file.
- Confirmed the live Eyal form (`FORM-EYAL-CONTENT-GAPS-2026-09-20.html`) carries exactly the 21
  ids the mandate lists (`grep -o 'data-id="[A-Z0-9-]*"'` → 21 unique matches, exact set match).

## A finding that changes how this file should be read: the render pipeline is stale

`scripts/s007_render_work_ssot.py`'s `render_form()` and `render_board()` still generate content
from `S007-WORK-SSOT.json`'s `items[]` array (179 legacy items, ids `A1..F3`, `L1..L3`, `P001..`,
`Q001..`, `M1..M9`, `T-*`, `DA-*`, `WA-*`). **None of those ids match the 21 ids on the live,
hand-rebuilt form.** The form was rebuilt directly as static HTML in the prior round (commit
`ef41d2d`), bypassing the script entirely. That means the script is currently a landmine: if
anyone runs `python3 scripts/s007_render_work_ssot.py` now, it silently overwrites both the live
form **and** the board I just built with the old, stale, JSON-driven output. I did not fix this
(out of the mandate's scope and I did not want to touch team_100-owned pipeline code
speculatively) but flagging it here so it doesn't cost someone a rebuild.

**Because of this, I followed the same precedent as the form rebuild: `GALLERY.html` is hand-authored
static HTML, not run through `render_board()`.** I did not modify the Python script.

## What was built

`_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html` — full rewrite. Two sections
only, in this order: **ממתין לנימרוד** (A1–A13), then **ממתין לצוותים** (B1–B8). No status table,
no derived-state block, no counters. The page opens with a short header (title, one lede sentence,
three source links) and then A1 immediately — no dashboard above it. Every card names its page(s)
in the heading or the path line, links the live URL(s), and ends with an explicit "נדרש" line.

**Every one of the 16 distinct live URLs used in the 21 cards was checked live today**
(`curl -s -o /dev/null -w '%{http_code}' --max-redirs 0`) — **all return 200**, no redirects
followed. `/about/moksha/` (referenced inside A6's note, not as a card URL) returns 301 to
`/eyal-amit/mokesh-dahiman/`, which is the point of that note.

### Fresh measurements done for this round (not just transcribed from the mandate)

The mandate explicitly assigned two live re-measurements to this round (A9, B2), plus one code
verification (B8). All three were done fresh, live, today, methodology below.

**A9 — touch navigation.** Tested live in the Browser pane at two widths:
- **≤1180px (the drawer):** `ea-nav-drawer.js` wires `.ea-nd__acc-btn` with a real `click`
  listener. Live test: tapping «ספרים» expands its submenu (does not navigate); tapping a child
  («כושי בלאנטיס») inside it navigates correctly to `/books/kushi-blantis/`. All four book pages
  reachable by touch through the drawer, in two taps.
- **>1180px (the desktop nav-bar, relevant for tablets/touch laptops):** inspected the live DOM —
  «ספרים» renders as `<a href="/books/" aria-haspopup="true">`, not a button. Read
  `ea-chapters.js`'s own code comment: the submenu opens only on `mouseenter`/`focusin`, and the
  comment states outright "Deliberately NOT done: no click … handling." A first tap there is a
  plain navigation to `/books/`, exactly the bug the card describes — confirmed, not assumed.
  Then fetched `/books/` and confirmed (string match on the raw HTML) it contains inline links to
  all four child pages (`tsva-bekahol`, `kushi-blantis`, `vekatavta`, `#books-bundle`), so the four
  pages remain reachable at that width too — one extra tap, via the landing page, not via the
  flyout. Both findings are on the card, not just the bug.

**B2 — caption-on-bright-image contrast.** Identified the element (`.phero .chap`) and page
(`/learning/`) from team_10's own prior report (`DONE-FINAL-FORM-2026-09-24.md`), which is where
this finding first surfaced. Re-measured live today with a from-scratch canvas pixel sample: drew
the actual rendered photo (`studio-didgs.jpg`) onto a canvas matching its `object-fit:cover` box,
sampled every pixel (stride 2) inside the `.chap` element's bounding rect (9,384 samples), and for
each one composited the real `.phero__sc` scrim gradient at that pixel's exact vertical position
(the gradient's alpha varies by y, interpolated from its three declared stops) against the actual
photo pixel, then computed the WCAG contrast ratio against the text's computed color
(`rgb(154,87,45)`). **Worst case: ≈1.00:1** at image pixel `rgb(219,183,146)` composited under
scrim alpha 0.469, against a 4.5:1 floor. This is a fuller re-measurement than the prior "around
1.9:1" estimate (which sampled one point, not the full text box) and shows a worse gap, not a
better one.

**B8 — mail recipient.** Read `site/wp-content/mu-plugins/ea-w2-15-cf7-contact-form-once.php`
directly: `'recipient' => 'info@eyalamit.co.il'` (line 83), matching what Eyal confirmed in the
meeting. No live send test was performed — the card says so and asks for one.

Other cards restate what Team 90 or team_10 already measured (A1's shows-heritage body text was
re-checked live via `curl` and is exactly «ניווט משני.»; A2's 133-question count was re-checked
against `ea-faq-seed.json`; A11's numbers were checked against
`OLD-SITE-MIGRATION-AUDIT-2026-09-24.md`; B6 was checked with a repo-wide grep for
`get_template_part`/`include`/`require` on `block-topnav.php`, none found; B7 was checked with a
live grep of the three pages' rendered HTML for `main-navigation` markup, present on all three)
rather than re-deriving new numbers — content law says restate, and those numbers were already
solid.

## Governing-rule cross-check (both directions)

**Eyal's 21 form cards do not appear as open items on the board:** checked topic-by-topic. None
of the 21 (blog column 41, 4 book-purchase links, learning/English/2012-post/gallery-dup photo
asks, QR-hero images, repair captions, carousel/music files, 3 legal docs, 5 old-site content
classes) overlap any A/B card. A11 *mentions* that the five old-site decision classes live on
Eyal's form, as context for the deletion-sequence question — it does not re-ask them.

**Nothing on the board duplicates or is missing relative to the form:** all 13 Section-A and all 8
Section-B items from the mandate are present, none altered in substance, none dropped.

## Removed rows — full mapping

### Explicitly named in the mandate

| Row | Verified today | Disposition |
|---|---|---|
| `Q-TALK-8` | `questions[]`, was `status:"open", waitingOn:"nimrod"` | **Resolved.** 6 of its 8 linked topics (nav order, post template, header shift, mokesh video work, stands example, hero titles) were decided live in the 2026-09-24 meeting and are closed — no card anywhere. The remaining 2 (carousel, music) are **not** talk items anymore; they became the plain file-request cards `HW-VIDEO` and `HW-MUSIC` on the rebuilt Eyal form. Updated the JSON (`status: resolved`, `waitingOn: none`, `answerHe` added) to match — it was genuinely stale, not just unrendered. |
| `Q-CONTRAST` | same, `open`/`nimrod` | **Resolved.** Both contrast decisions from the map were approved and built (`.chap` now 5.55:1 on a flat background). Only 2 of the original ~12 rows are still open work, not the whole map: `B2` and `B3`. Updated the JSON to `resolved`. |
| `Q-MAIL-2` | same, `open`/`nimrod` | **Resolved.** Eyal confirmed the second recipient in the meeting. Downgraded from a decision to a verification — `B8` on the new board. Updated the JSON to `resolved`. |
| `Q-EYAL-BATCH`, `Q-COLOR` | already `status:"resolved"` in the JSON | Unchanged — already correct, already excluded from any board rendering. |
| **99 `waitingOn:"team10"` rows** (the `P0xx` blog-post catalog and `Q0xx` QR-page catalog) | counted live: `Counter((status,waitingOn) for items)` → exactly 99 at `("waiting","team10")` | **Not rendered as cards**, per the mandate. **I looked at whether the flag is wrong, and concluded it is not**: team10 genuinely owes this work and nothing blocks it, which is exactly what `waiting/team10` means — that's correct data, not stale data. What would be wrong is rendering it as 99 separate decisions; it's really two template rollouts (post template, then QR template), which is how it was already being described in the old board's slim table. I did not rewrite the flag. |
| **60 closed items** | counted live: 60 at `("closed","none")` | **Not rendered as cards.** These are the administrative `T-*`/`DA-*`/`WA-*`/`EI-*`/`N1`/`M13-ONE-NAV`/`TYPO-CANON` rows plus a handful of closed `P`/`Q` catalog entries. All genuinely closed; none reopened. |

### Not named explicitly, but also dropped because the board's shape changed (traced here for completeness)

The old board rendered two other pools that no longer exist as such: the `questions[]` array's
still-open entries, and the prior board's `T-*`/`M*` "waiting" cards. Every one is accounted for:

| Old id | Was | Now |
|---|---|---|
| `Q-SHOWS` | open/nimrod | → **A1** |
| `Q-FAQ-HOME` | open/nimrod | → **A2** |
| `Q-G04` | open/nimrod | → **A3** |
| `Q-G06` | open/nimrod | → **A4** |
| `Q-G07` | open/nimrod | → **A5** |
| `Q-MOKESH-OLD` | open/nimrod | → **A6** |
| `Q-MOKESH-EYAL-ALT` | open/nimrod | → **A7** |
| `Q-IOS-ZOOM` | open/nimrod | → **A8** |
| `Q-A11Y-STMT` | open/nimrod | → **B5** (reclassified: contrast is decided now, so this is drafting work, not a Nimrod decision) |
| `T-NAV-HOLD` | items[], waiting/nimrod, "talk-then-close-M1" | Resolved by the 2026-09-24 meeting per `Q-TALK-8`'s own ruling (nav order M1 was one of the six decided live) — not carried forward as a card. I did not independently re-verify every detail of that closure beyond confirming the live nav order has no "קורסים" item and matches the sequence described; flagging that limit rather than asserting more than I checked. |
| `M1,M2,M3,M5,M6,M7` | items[], waiting/eyal | Same six meeting-decided topics as above — closed, no card. |
| `M8` | items[], open/eyal (carousel) | → `HW-VIDEO` on Eyal's form |
| `M9` | items[], open/eyal (music) | → `HW-MUSIC` on Eyal's form |
| `Q-REPAIR-ALT` | items[], open/eyal | → `HW-REPAIR-ALT` on Eyal's form (same topic, same "REPAIR-ALT" suffix) |
| `T-GALLERY-ASSIGNED` | items[], waiting/eyal | → `HW-B2-GALLERY-DUP` on Eyal's form (same galleries-page topic) |
| `T-BLOG-HERO-OLD` | items[], waiting/eyal | Folded into the blog-catalog work (the 99 `team10` rows) — it's sourcing images for posts in that same catalog, not an independent open question |

**One honest limit on this mapping:** the JSON's `items[]` array (179 entries, ids `A1..N1`) is
the *stale* pool described above — it predates the hand-rebuilt 21-card form and none of its ids
match it. I traced every entry that was `waiting`/`open` (20 of them) and every closed one is
covered by the 60-count. I did **not** attempt a speculative field-by-field remap of the three
remaining letter-scheme entries whose topic wasn't obvious at a glance (old `A3` "כתבות היסטוריות",
old `A5` "קורסים", old `B3` "בחירת התמונות לגלריה הראשית") beyond confirming they were never
rendered on the actual board (their `surface` is `eyal_form`, and the board only ever rendered
`nimrod_board`/`both`/`internal`) — so dropping them changes nothing observable. Saying this
plainly rather than inventing a mapping I don't have evidence for.

## Not touched

- `_aos/` — not touched.
- `local/` — not opened.
- `scripts/save_legacy_wp_app_password.py` — left alone, untracked, unstaged.
- No `git add -A` was run; nothing was staged or committed (not asked to).
- Did not push, did not rewrite history.
- `S007-WORK-SSOT.json`: only touched `themeLive` (was stale at `1.5.121`, live site serves
  `1.5.126` — checked via `curl ... | grep ver=`) and the three `questions[]` entries listed above.
  The `items[]` array itself was left untouched.

## Success criteria — self-check against the mandate's list

- Two sections only, no status block: yes — verified by reading the rendered page's text end to
  end.
- Every card names its page(s) and carries live URLs that return 200, redirects not followed: yes
  — all 16 distinct URLs checked with `curl --max-redirs 0` today, all 200.
- Every card states what is required: yes — every card ends with a `נדרש:` line.
- Zero cards for anything on Eyal's 21: yes, cross-checked both directions above.
- Zero cards for the 99 locked rows and the 60 closed ones: yes.
- Every A1–A13/B1–B8 item is present: yes, all 21.
- Mapping of every removed row reported: yes, tables above.

## Board

[GALLERY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html)
