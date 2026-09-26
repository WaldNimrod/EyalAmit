# DONE — `.phero .chap` eyebrow contrast: closed properly this time

**Team:** team_10 (builder) · **Date:** 2026-09-26 · **Theme:** 1.5.138 → **1.5.141**
**Staging:** http://eyalamit-co-il-2026.s887.upress.link (plain HTTP, invalid cert by design — not a defect)
**File touched:** `site/wp-content/themes/ea-eyalamit/assets/css/chapters.css` (+ `style.css` version line only)
**`ea-tokens.css` and `S007-TYPOGRAPHY-CANON.md`:** byte-unchanged (verified via `git diff` against every commit below)
**Commits:** `f1994c8`, `7edde52`, `c6280f4` (all on `main`)

## TL;DR

The comment in `chapters.css` that flagged `/sound-healing/` as a near-miss and was never
acted on is real, and acting on it surfaced a second, bigger bug: the 2026-09-24 fix's
non-photo color (`#9A572D`) was failing on **every single one of the 52 live pages that use
it** — not a near-miss, a uniform 3.12–3.20:1 fail — because its own justifying comment ("many
hero instances render near-white") is contradicted by the CSS one line above it
(`.phero{background:var(--dark-grad)}`, the *only* background rule `.phero` ever gets). Fixed
in three steps, each driven by a real measurement that moved the goalposts:

1. Unify `.phero .chap` to one rule, always white — fixes the 52 flat/dark pages outright and
   deletes the specificity-fragility bug structurally (one rule, nothing to race against).
2. Strengthen the shadow .55 → .70 → **.85** alpha — a 306-page-load sweep (153 pages × 1440 +
   390 viewports) caught two photo pages that passed at desktop and failed at mobile, because
   `object-fit:cover` shows a different crop of the same photo at a narrower width.
3. Add a small dark pill backing on photo heroes only (pre-approved fallback lever) — one
   hero's photo has a near-white press-clipping graphic baked into it, and no amount of
   shadow alpha has a path through a background that's already white.

**Final state, verified 2026-09-26, both viewports, all 112 live pages that render
`.phero .chap`: worst measured ratio 10.84:1. Zero pages below 4.5:1.**

---

## 1. What was actually wrong (read this before the numbers)

The 2026-09-24 commit (`a3fef7e` and the one before it) split `.chap` inside `.phero` into two
colors:

```css
.phero .chap{color:#9A572D}                                                    /* flat heroes */
.phero.phero--media .chap{color:var(--ea-on-dark);text-shadow:0 1px 3px rgba(0,0,0,.55)}  /* photo heroes */
```

The comment justified `#9A572D` (a dark terra tone) with: *"near-white background many hero
instances actually render."* That's the premise the whole task brief and I both inherited. It
is false. `chapters.css` line 416 is the **only** rule that ever sets `.phero`'s background,
ever: `.phero{background:var(--dark-grad)}` — a near-black gradient
(`#0B0703 → #1C1109 → #2A1A0C → #0B0703`). Nothing later in the file overrides it (checked with
`grep` across every rule touching `.phero`'s background — one hit, itself). Every non-media
`.phero` on this site renders that dark gradient, never near-white.

I measured all 52 currently-live pages that hit the non-media rule — every `/qr/qr1/`…
`/qr/qr48/` short link, `/qr/` itself, `/courses-soon/`, `/learning/courses-external/`, and one
blog post — and **100% of them fail**, 3.12–3.20:1, real glyph rects, painted pixels, sample
counts 36–111 per page. Not a near-miss population: a uniform, unconditional fail. See
`crop_qr1.png`-style evidence in the working notes; visually the "QR" eyebrow is genuinely hard
to read on-screen, matching the number.

This is why "the minimum visual change" here is not a scrim tweak on the photo side alone — the
flat side was broken worse, and by a bigger population (52 pages vs. the 4 named in the brief).

## 2. The four named pages, before → after

Real Chrome (chrome-headless-shell), full load + settle + 2 rAF, cookie dialog dismissed,
`Range.getClientRects()` for the actual glyph boxes (not the line box), painted pixels from
`Page.captureScreenshot`, filtered to pixels near the element's own solid computed color,
background recovered by re-screenshotting the same frame with only that element's fill set to
`color:transparent` (text-shadow is a separate paint keyed to its own declared rgba, not
`currentColor`, so it stays visible — this gives the *exact* local background including the
shadow's contribution, no CSS lookup, no compositing guesswork), worst ratio = minimum across
all surviving samples. Desktop viewport 1440×1100, mobile 390×844.

| Page | Brief's figure | My "before" (desktop, current-shipped state) | My "after" (desktop) | My "after" (mobile) |
|---|---|---|---|---|
| `/learning/` | 8.05:1 pass | **10.24:1** (n=32) | 14.91:1 (n=30) | 15.83:1 (n=31) |
| `/learning/therapist-training/` | 4.42:1 fail | **7.33:1** (n=14) | 14.06:1 (n=10) | 13.62:1 (n=10) |
| `/contact/` | 3.96:1 fail | **6.59:1** (n=27) | 14.64:1 (n=26) | 14.37:1 (n=27) |
| `/sound-healing/` | disputed 4.52 / 3.80 | **4.96:1** (n=53, desktop) / not yet failing at mobile pre-fix | 12.70:1 (n=47) | 13.70:1 (n=45) |

**On the /sound-healing/ dispute specifically:** my measurement, with sample count stated as
the task asked, is **4.96:1 at n=53** before this round's changes — passing, not failing,
against my methodology at 1440×1100. This does not match either of the two disputed numbers
(4.52 or 3.80), and I want to be direct about that rather than pretend a third number settles a
dispute I can't fully reconstruct: I don't know what viewport or exact glyph-sampling approach
produced 4.52 or 3.80. What I can state with confidence: the shadow that shipped in `a3fef7e`
already had `/sound-healing/` at a real (if unremarked-on) margin at 1440px by my method, and
the two live failures I *did* find by testing both viewports were on different pages entirely
(`/2228-2/` and one other post, both failing only at 390px, not at 1440px — see §4). I'd treat
4.52/3.80 as most likely a viewport or sampling-method difference rather than an error in either
measurement, and it's moot now regardless: `/sound-healing/` is 12.70–13.70:1 in the shipped
state.

**On the brief's `/learning/therapist-training/` (4.42) and `/contact/` (3.96):** same
situation — my numbers for the *already-shipped* `a3fef7e` shadow (.55 alpha) were comfortably
over 4.5 at both viewports I tested. I flag this as a genuine discrepancy rather than silently
overriding it: possibly a different viewport, possibly the block-box/anti-aliased-edge pitfalls
the task itself warns about, possibly timing (measured before the shared scrim's gradient
finished painting). It doesn't change what needed doing — the flat-page population was
definitively broken regardless, and the fix strengthens photo-hero margins regardless of which
of us is right about the pre-existing number.

## 3. The 52 flat-hero pages, before → after (this is the part the brief didn't know about)

Every one of these renders `.phero` **without** `.phero--media` — dark gradient background, no
photo — and was hitting `#9A572D`, 100% failing:

| Pages | Before | After (desktop) | After (mobile) |
|---|---|---|---|
| `/qr/qr1/` … `/qr/qr48/` (48 individual short links) | 3.12:1 (n=36 each) | 18.38:1 (n=22) | 16.36–17.49:1 (n=23) |
| `/qr/` | 3.16:1 (n=36) | 18.53:1 (n=22) | 17.49:1 (n=23) |
| `/courses-soon/` | 3.16:1 (n=76) | 18.53:1 (n=28) | 16.91:1 (n=28) |
| `/learning/courses-external/` | 3.16:1 (n=76) | 18.53:1 (n=28) | 16.91:1 (n=28) |
| one blog post (דיגרידו-פרדס-חנה…) | 3.20:1 (n=111) | 18.58:1 (n=54) | 18.53:1 (n=54) |

Per-URL numbers for all 48 `/qr/qrN/` pages are in
`EYEBROW-CONTRAST-2026-09-26-evidence/per-page-before-after.json` (identical template, so
identical measurements — collapsed here for readability).

## 4. The rest of the 112 live pages that render `.phero .chap`

Full before/desktop-after/mobile-after table, every page, sorted worst-to-best by the
"before" number:

| Page | Before | After (desktop) | After (mobile) |
|---|---|---|---|
| /courses-soon/ | 3.16:1 (n=76) | 18.53:1 (n=28) | 16.91:1 (n=28) |
| /learning/courses-external/ | 3.16:1 (n=76) | 18.53:1 (n=28) | 16.91:1 (n=28) |
| /qr/ | 3.16:1 (n=36) | 18.53:1 (n=22) | 17.49:1 (n=23) |
| /דיגרידו-פרדס-חנה-סטודיו-לבנייה-ונגינ/ | 3.20:1 (n=111) | 18.58:1 (n=54) | 18.53:1 (n=54) |
| /sound-healing/ | 4.96:1 (n=53) | 12.70:1 (n=47) | 13.70:1 (n=45) |
| /2228-2/ | 5.02:1 (n=179) | 12.31:1 (n=145) | 10.96:1 (n=155) |
| /הטור-של-אייל-עמית-הספר-החדש-שלי-זקוק-ל/ | 5.08:1 (n=208) | 12.33:1 (n=182) | 16.60:1 (n=146) |
| /מופע-הסיפורים-של-אייל-עמית-כתבה-מאת-רו/ | 5.15:1 (n=162) | 12.38:1 (n=142) | 10.96:1 (n=151) |
| /שני-תאריכים-קרובים-למופע-הסיפורים-של-א/ | 5.16:1 (n=176) | 12.30:1 (n=145) | 12.41:1 (n=152) |
| /סרטים-מהחיים-מופע-הסיפורים-של-אייל-עמי/ | 5.44:1 (n=152) | 11.84:1 (n=136) | 12.75:1 (n=146) |
| /כתבה-אודות-אייל-עמית-מורה-ומטפל-בדיגרי/ | 5.47:1 (n=28) | 12.71:1 (n=25) | 11.65:1 (n=24) |
| /כתבה-על-תופעת-יחיד-ב-המקומון-גבעתיים-ר/ | 5.57:1 (n=161) | 12.75:1 (n=142) | 14.56:1 (n=141) |
| /100-100-100-תודה/ | 5.98:1 (n=159) | 13.14:1 (n=162) | 13.01:1 (n=144) |
| /דף-פייסבוק-חדש-למופע-הזמנה-לשני-המופעי/ | 6.36:1 (n=135) | 13.12:1 (n=131) | 11.56:1 (n=149) |
| /אייל-עמית-תופעת-יחיד-מופע-סיפורים-spoken-stories-15/ | 6.53:1 (n=149) | 13.70:1 (n=139) | 12.85:1 (n=145) |
| /contact/ | 6.59:1 (n=27) | 14.64:1 (n=26) | 14.37:1 (n=27) |
| /עכשיו-מופע-הסיפורים-של-אייל-עמית-15-11-14-בת/ | 6.86:1 (n=152) | 13.91:1 (n=134) | 13.66:1 (n=143) |
| /ביקורות-גולשים-אודות-עכשיו-מופע-הסיפ/ | 6.87:1 (n=140) | 14.20:1 (n=133) | 12.36:1 (n=148) |
| /שנה-לחוק-הספרים-צניחה-של-35-במכירות-של-ספ/ | 7.08:1 (n=90) | 13.89:1 (n=81) | 13.13:1 (n=80) |
| /learning/therapist-training/ | 7.33:1 (n=14) | 14.06:1 (n=10) | 13.62:1 (n=10) |
| /תלמידים-ומטופלים-ממליצים-על-המרכז-לטי/ | 7.54:1 (n=25) | 14.36:1 (n=23) | 13.12:1 (n=23) |
| /נשים-מנגנות-בדיגרידו-אישה-מנגנת-בדיג/ | 7.60:1 (n=28) | 14.59:1 (n=24) | 13.76:1 (n=25) |
| /en/ | 8.00:1 (n=165) | 14.45:1 (n=156) | 11.83:1 (n=158) |
| /42-הטור-של-אייל-עמית-אחד-בספטמבר/ | 8.03:1 (n=17) | 14.18:1 (n=16) | 14.72:1 (n=16) |
| /טיפול-בנשימה-באמצעות-דיגרידו-ללמוד-ל/ | 8.10:1 (n=54) | 14.07:1 (n=54) | 11.18:1 (n=53) |
| /עוד-רגע-מחייו-של-מורה-לדיגרידו/ | 8.21:1 (n=55) | 15.78:1 (n=54) | 14.07:1 (n=54) |
| /23-הטור-של-אייל-עמית-לציית-או-לחשוב/ | 8.42:1 (n=18) | 15.21:1 (n=16) | 14.21:1 (n=16) |
| /הטור-של-אייל-עמית-איך-התחלתי-לכתוב-ולספ/ | 8.69:1 (n=250) | 15.22:1 (n=241) | 12.70:1 (n=233) |
| /מופע-הסיפורים-של-אייל-עמית-שישי-23-10-15-בתיא/ | 8.76:1 (n=131) | 13.88:1 (n=131) | 12.77:1 (n=146) |
| /את-הספר-החדש-שלי-לא-תמצאו-ברשתות-הספרים/ | 8.77:1 (n=131) | 14.97:1 (n=123) | 12.49:1 (n=130) |
| /לא-בעוד-רגע-לא-בעוד-שנייה-ע-כ-ש-י-ו/ | 8.89:1 (n=17) | 15.30:1 (n=16) | 17.51:1 (n=16) |
| /blog/ | 9.04:1 (n=19) | 15.55:1 (n=16) | 16.47:1 (n=11) |
| /accessibility/ | 9.28:1 (n=43) | 15.66:1 (n=38) | 16.41:1 (n=38) |
| /privacy/ | 9.28:1 (n=43) | 15.66:1 (n=38) | 16.41:1 (n=38) |
| /terms/ | 9.28:1 (n=43) | 15.66:1 (n=38) | 18.53:1 (n=38) |
| /נשימה-מעגלית-בדיגרידו-טיפול-ריפוי-עצ/ | 9.53:1 (n=55) | 15.33:1 (n=54) | 13.37:1 (n=55) |
| /learning/ | 10.24:1 (n=32) | 14.91:1 (n=30) | 15.83:1 (n=31) |
| /36-הטור-של-אייל-עמית-שיטת-השקשוקה/ | 10.65:1 (n=17) | 16.32:1 (n=16) | 19.21:1 (n=16) |
| /מוקש-דהימן-מאסטר-דיגרידו-ציור-מקורי-ח/ | 10.94:1 (n=24) | 16.29:1 (n=24) | 14.98:1 (n=23) |
| /60-הטור-של-אייל-עמית-איי-אם-בק/ | 11.15:1 (n=84) | 16.46:1 (n=77) | 12.62:1 (n=78) |
| /מורה-לדיגרידו-מודה-למוריו-תלמידיו-ומט/ | 11.72:1 (n=17) | 16.60:1 (n=16) | 15.77:1 (n=16) |
| /49-הטור-של-אייל-עמית-קומיק-רליף/ | 12.35:1 (n=16) | 16.83:1 (n=16) | 14.13:1 (n=16) |
| /סדנת-דיגרידו-קבוצתית-מקיפה-וייחודית-ל/ | 12.50:1 (n=55) | 16.66:1 (n=55) | 12.94:1 (n=54) |
| /טיפול-בפוסט-טראומה-לחייל-משוחרר-מגולנ/ | 12.55:1 (n=55) | 16.85:1 (n=54) | 13.62:1 (n=55) |
| /34-הטור-של-אייל-עמית-הלב/ | 12.87:1 (n=16) | 17.23:1 (n=16) | 16.79:1 (n=16) |
| /עמית-ביָדִית-מופע-הסיפורים-של-אייל-עמי/ | 13.17:1 (n=129) | 18.34:1 (n=130) | 11.47:1 (n=150) |
| /51-הטור-של-אייל-עמית-אקסטרים-זה-נעים/ | 13.25:1 (n=16) | 17.22:1 (n=16) | 17.26:1 (n=16) |
| /43-הטור-של-אייל-עמית-אדון-סליחות/ | 13.52:1 (n=16) | 17.56:1 (n=16) | 17.68:1 (n=16) |
| /29-הטור-של-אייל-עמית-רייב-שבוע-הספר/ | 13.54:1 (n=16) | 16.94:1 (n=16) | 17.86:1 (n=16) |
| /ריברסינג-נשימה-מעגלית-דיגרידו/ | 13.61:1 (n=55) | 17.54:1 (n=54) | 12.26:1 (n=54) |
| /עכשיו-הופעה-במוצש-הקרוב-13-9-14-בפרדס-חנה/ | 13.81:1 (n=134) | 17.76:1 (n=131) | 16.31:1 (n=142) |
| /47-הטור-של-אייל-עמית-זמן-חלום/ | 14.64:1 (n=16) | 18.76:1 (n=16) | 13.57:1 (n=16) |
| /פודקאסט-דיגרידו-ו-נשימה-אייל-עמית/ | 14.66:1 (n=54) | 15.94:1 (n=54) | 11.60:1 (n=55) |
| /פודקאסט-דיגרידו-ו-נשימה-אייל-עמית-2/ | 15.04:1 (n=24) | 18.20:1 (n=23) | 17.63:1 (n=23) |
| /27-הטור-של-אייל-עמית-חכמת-הפרצוף/ | 15.84:1 (n=16) | 18.27:1 (n=16) | 15.40:1 (n=16) |
| /45-הטור-של-אייל-עמית-פרופורציות/ | 16.82:1 (n=16) | 18.59:1 (n=16) | 15.46:1 (n=16) |
| /40-הטור-של-אייל-עמית-פרסומת-אחת-וחזרנו/ | 17.18:1 (n=16) | 17.60:1 (n=16) | 16.03:1 (n=16) |
| /הזמנה-להשקת-הספר-החדש-וכתבתָ-אייל-עמ/ | 17.68:1 (n=131) | 18.63:1 (n=129) | 16.37:1 (n=128) |
| /עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע/ | 18.20:1 (n=129) | 14.70:1 (n=130) | 10.84:1 (n=147) |
| /2-8-מופע-בצוותא-20-מהמקומות-באולם-חינם-לתוש/ | 18.69:1 (n=131) | 19.34:1 (n=131) | 17.71:1 (n=141) |
| /18-הטור-של-אייל-עמית-מסך-הברזל/ | 19.07:1 (n=16) | 19.78:1 (n=16) | 17.94:1 (n=16) |
| /הטור-של-אייל-עמית-24-ילד-אסור-ילד-מותר/ | 19.18:1 (n=16) | 19.46:1 (n=16) | 11.72:1 (n=17) |
| /32-הטור-של-אייל-עמית-אם-אין-אני-לי-מי-לי/ | 19.46:1 (n=16) | 19.52:1 (n=16) | 12.51:1 (n=16) |
| /וסיפרתָּ-מופע-הספוקן-סטוריז-של-אייל-עמ/ | 19.52:1 (n=16) | 19.62:1 (n=16) | 15.87:1 (n=16) |

**Population-wide, both viewports, final deployed state (306 page-loads = 153 pages × {1440,
390}): 0 pages below 4.5:1. Minimum observed ratio: 10.84:1** (that low point is
`/עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע/` at 390px — still comfortably over the bar).

Full machine-readable data for all three sweeps (before, after-desktop, after-mobile) is in
`_COMMUNICATION/team_10/EYEBROW-CONTRAST-2026-09-26-evidence/`.

## 5. The two viewport-only failures the desktop-only sweep missed

The first fix I shipped (shadow at .70 alpha, single unified white rule) measured **zero
failures across all 153 pages at 1440px**. Before declaring done, I re-ran the same 153 pages at
390px (mobile) as a sanity check, because `object-fit:cover` crops a *different* slice of the
same photo at a narrower viewport — the whole premise of this task is that the ground varies,
and viewport is one more axis it varies on. That check found two real failures:

- `/2228-2/` — 4.00:1 at 390px (was 5.02 at 1440px)
- one Hebrew-slug post ("ha-sefer ha-chadash…") — 4.47:1 at 390px (was 5.08 at 1440px)

Bumping the shadow to .85 alpha fixed the second one but not `/2228-2/` (still 4.16:1 at
390px): that hero's photo is a hand-and-chair shot with a **near-white press-clipping graphic
baked into the image itself**, and the mobile crop lands the eyebrow directly on that panel. A
blur-based shadow has a floor against a background that's already near-white — especially at
this letter-spacing/weight, where the strokes are thinner than the blur radius, so the shadow's
peak density under the stroke is already diluted below its nominal alpha before it even reaches
the pixel.

That's what pushed the fix to a second, independent lever (§7) rather than an ever-larger
shadow alpha, which would eventually stop being "subtle" and still not have a guaranteed floor
against literal white.

## 6. The specificity fragility — gone structurally, not just re-ordered

Before, in source order:

```css
.phero .chap{color:#9A572D}                                                    /* (0,2,0) */
.phero.phero--media .chap{color:var(--ea-on-dark);text-shadow:...}             /* (0,3,0) */
```

`(0,3,0) > (0,2,0)` regardless of order, so this particular pair was already safe by the time I
got here — but that's exactly the kind of thing a rule inserted between them, at the wrong
specificity, could have silently broken again, because two selectors sharing a decision this
important is one selector too many. There is now exactly one rule:

```css
.phero .chap{color:var(--ea-on-dark);text-shadow:0 1px 3px rgba(0,0,0,.85)}
.phero--media .chap{display:inline-block;padding:3px 12px;background:rgba(20,14,9,.55);border-radius:100px}
```

`color`/`text-shadow` are set by exactly one selector; the second rule sets **only**
`display`/`padding`/`background`/`border-radius` — properties the first rule never touches — so
there is no shared property for source order to arbitrate between. Nothing can silently revert
the color or shadow by being inserted in the wrong place, because there's nothing left to
override.

## 7. The lever chosen, and why, at each step

1. **Unify color to one rule (white/`--ea-on-dark`).** Forced by data: `#9A572D` failed 100% of
   its 52 live pages, `--ea-on-dark` was already correct for every photo page. Not really a
   "choice" — the flat-page population needed exactly what the photo population already had.
2. **Strengthen `text-shadow` alpha, .55 → .70 → .85.** The task's own first-listed, most
   pre-approved lever ("a subtle text-shadow… the narrowest lever and the most likely answer").
   Reused the exact recipe already live four times in this file (`0 1px 3px rgba(0,0,0,X)`);
   only `X` moved, and .85 is not a new value in this theme — `.bleed__q` already uses .85 (at
   an 8px blur, for a full pull-quote over a full-bleed photo, so precedent for "this is still
   the theme's idea of subtle" is strong).
3. **Small dark pill backing, photo heroes only.** Second pre-approved lever ("a small local
   backing behind the label only — not a scrim over the whole hero"), reached only because step
   2 hit a real floor on one page. Reuses this theme's own existing pattern for a dark control
   over unpredictable photo content — `.hero__sound` and `.mokesh-hero__unmute` already use the
   identical `rgba(20,14,9,.5–.6)` ink and `border-radius:100px` pill shape for exactly this
   situation (a small dark chip that has to stay legible over any photo). Scoped to
   `.phero--media` only — flat/dark-grad pages were already 6–18:1 with color alone, so a pill
   there would be pure decoration for no measured reason. It composites *under* the shadow, not
   instead of it (background → shadow → opaque glyph, standard CSS paint order for a text
   element's own background vs. its text-shadow vs. its fill), so the two levers stack rather
   than compete.
4. **Not used, and why:** a per-page `mod` scrim override (task explicitly discourages a
   page-by-page fix, and the population size here — 52 flat pages, several photo pages — argued
   against it even before that instruction); darkening the shared `.phero__sc` scrim globally
   (explicitly forbidden — repaints every photo hero including the home page); any
   `ea-tokens.css` edit (explicitly forbidden, and unnecessary — `#9A572D`/`--terra-lt` are
   read, not written, by this fix); any font-size/font-weight change (S007 canon locks both,
   untouched, verified below).

## 8. Full regression, final deployed state (theme 1.5.141)

306 page-loads (153 live objects — 101 pages + 52 posts, matching the ~153/136 the brief
expected — × 1440 and 390 viewports), 3 concurrent, retried on 502 (none hit):

- **HTTP 200:** 306/306
- **`.phero .chap` contrast ≥ 4.5:1:** 224/224 page-loads that render it (112 unique pages × 2
  viewports) — **0 failures**, min 10.84:1, max 19.78:1
- **Exactly one primary nav** (`nav#nav`, the `section-nav.php` output gated by
  `ea_chapters_nav_mark_once()` so it can only ever print once — not `header.php`'s separate,
  unused-by-chapters-templates `.ea-shell-nav` markup, which I initially grepped and had to
  correct against the live DOM): 306/306
- **Exactly one footer** (`footer[role="contentinfo"]`, `ea_render_unified_footer()` — "this ONE
  footer renders identically regardless of" caller, per its own docblock): 306/306
- **Zero PHP error strings** (`Fatal error`, `Parse error`, `Warning: … in`, `Notice: … in`,
  `Uncaught Error`) in rendered body text: 306/306
- **Zero titleless page-loads:** 306/306
- **`ea-tokens.css` / `S007-TYPOGRAPHY-CANON.md`:** `git diff 7fd4020..HEAD --` on both paths —
  0 lines, confirmed against every commit in this round

## 9. Deploy record

Deployed via `python3 scripts/ftp_deploy_site_wp_content.py` three times (once per commit
below — each verified live via `curl` against the deployed `chapters.css`/`style.css` before
moving to the next measurement round). Entries appended by the script itself to
`_COMMUNICATION/team_100/S006/DEPLOY-LOG.md`:

```
2026-09-26T21:58:59+03:00 · f1994c8d05a7 · main · theme 1.5.139 · 725 files
2026-09-26T22:11:25+03:00 · 7edde5277c05 · main · theme 1.5.140 · 725 files
2026-09-26T22:17:22+03:00 · c6280f487bbb · main · theme 1.5.141 · 725 files
```

Commits (in order):

- `f1994c8` — unify `.phero .chap` to one always-white rule (fixes the 52 flat-hero pages,
  removes the specificity fragility)
- `7edde52` — strengthen the shadow .70 → .85 alpha (fixes the two mobile-only photo failures
  found by the dual-viewport sweep, one fully)
- `c6280f4` — add the small dark pill backing on photo heroes (fixes the one page the shadow
  alone couldn't reach — a near-white graphic baked into the source photo)

## PROPOSALS (not implemented — flagging for the owner)

1. **The `--terra-lt` alternative for flat heroes.** Instead of unifying flat heroes to white, I
   considered keeping an accent-colored kicker (consistent with `.sec--dark`/`.studio__t`/
   `.start`, which all use `--terra-lt` for their `.chap` on the same dark-gradient family of
   backgrounds). I measured it: `--terra-lt` (#D08A5E) gives 6.18:1 against the gradient's
   darkest sampled point but only 3.43:1 against a lighter point in the same gradient (it's a
   160deg linear gradient, not flat) — i.e. it would reproduce exactly the "looks fine on the
   page I tested, fails on the page I didn't" pattern this whole task exists to close. I did not
   implement it. If the owner wants the flat pages' kicker to read as brand-accent rather than
   plain white (a real, if minor, loss of visual distinction from the H1), `--terra-lt` is
   available but is not reliably safe across the gradient's full range the way white is —
   worth a design call, not an engineering one.
2. **The discrepancy between the brief's stated pre-fix numbers (4.42, 3.96, 4.52/3.80) and my
   measurements of the same already-shipped state (7.33, 6.59, 4.96)** — see §2. I don't have
   enough information to say which methodology produced the brief's numbers, so I'm not
   asserting they were wrong, only that I can't reproduce them with the methodology this task
   specified in detail, and that whatever gap exists doesn't change what needed fixing (the
   52-page flat-hero failure was unambiguous and un-disputed, and the shadow/pill strengthening
   only widens margins on the photo side regardless of which "before" number was right).
3. **Mobile spot-checks beyond the two failing pages found** were not re-run at every
   intermediate breakpoint (e.g. 768px tablet) — only 1440 and 390 were swept for all 153 pages,
   per the task's implicit two-viewport convention (matching `qa_probe.mjs`'s own default
   viewport pair). Given `object-fit:cover` demonstrably shows different crops at different
   widths, a tablet-width sweep is a reasonable next check if Team 90's own re-measurement uses
   a different viewport and finds anything I didn't.

## Hard-rule compliance checklist

- Content law: no visible text changed.
- Gentle: 3 concurrent requests throughout; zero 502s encountered (none to retry).
- No `git add -A` — every commit staged explicit paths only.
- `local/` never opened (only `ls`'d for existence, to confirm the FTP env file was present
  before running the deploy script — no credential contents read).
- `_aos/` untouched. `scripts/s007_render_work_ssot.py` not run (its pre-existing uncommitted
  state, present before this session started, was left exactly as found and never staged).
  `scripts/save_legacy_wp_app_password.py` never opened.
- `_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html` and `hub/dist/` never
  touched.
- Deployed only via `scripts/ftp_deploy_site_wp_content.py`, three times, each against a clean
  `site/` (the deploy script's own guard — never forced past it). No `git push`.

Co-Authored-By: Claude Sonnet 5 <noreply@anthropic.com>
