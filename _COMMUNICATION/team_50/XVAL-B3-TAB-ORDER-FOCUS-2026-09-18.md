Independent verifier, different engine from the builders. Nothing was changed. No scanner.

Both pages **loaded** (HTTP 200, HTML 78,205 / 50,642 bytes, `.ea-skiplink` + `#main` present). Viewport **1440×900**. `html` direction **rtl**. Initial focus **BODY**. First real Tab on each page moved focus **off BODY** onto `a.ea-skiplink`, and every stop matched `:focus-visible` — the key events are real.

Method (measured unless marked inferred): Chrome + `page.keyboard.press('Tab')`, **800 ms settle**, no `element.focus()`, no CSS injection. Indicator = computed `outline` / `box-shadow` on the focused node vs the **same node after the next Tab**. On-screen = rect intersects the viewport after settle. RTL judged in **document** coordinates (`scrollY + rect`); viewport Y going “up” after auto-scroll is a harness artifact.

Live CSS: `ea-atoms.css?ver=1.5.39`, `chapters.css?ver=1.5.39`.

Full write-up: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-B3-TAB-ORDER-FOCUS-2026-09-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-B3-TAB-ORDER-FOCUS-2026-09-18.md)  
Raw JSON: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/b3-taborder.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/b3-taborder.json)

Walked **40 stops per page** (≥25). Neither page wrapped; this is **not** the end of the document.

---

## `/` home

Top-level nav Tabs run **right-to-left** (decreasing `x`), matching the visual RTL bar. Submenus open downward; the next top-level item after a submenu is to the **left** of the previous trigger. After `EN`, order proceeds **down** the document.

| # | Element | Focus indicator | On screen | RTL |
|---:|---|---|---|---|
| 1 | `a.ea-skiplink` דלג לתוכן | computed **yes** (`auto 1px rgb(0,95,204)`; unfocused `none`). Clip: **no distinct ring** on terracotta | yes (top-right after focus) | first; skip is out-of-flow |
| 2 | `a.nav__b` אייל עמית — דף הבית | **yes** UA auto; clip **shows blue ring** | yes | left of skip |
| 3 | `a.nav__dd` טיפול בדיג׳רידו ▾ | yes UA; clip yes | yes | left along nav |
| 4 | `a` טיפול בדיג׳רידו | yes UA | yes | down into submenu |
| 5 | `a` נחירות ודום נשימה בשינה | yes UA | yes | down |
| 6 | `a` השיטה | yes UA | yes | back to nav, **left** of 3 |
| 7 | `a` שיעורי דיג׳רידו | yes UA | yes | left |
| 8 | `a` סאונד הילינג | yes UA | yes | left |
| 9 | `button.nav__dd` לימוד והכשרה ▾ | yes UA | yes | left |
| 10 | `a` הכשרות למטפלים | yes UA | yes | down |
| 11 | `a` קורסים | yes UA | yes | down |
| 12 | `a` הרצאות | yes UA | yes | down |
| 13 | `a` סדנאות | yes UA | yes | down |
| 14 | `a.nav__dd` כלים ואביזרים ▾ | yes UA | yes | back to nav, left of 9 |
| 15 | `a` כלים בעבודת יד ואביזרים | yes UA | yes | down |
| 16 | `a` תיקון וחידוש כלים | yes UA | yes | down |
| 17 | `a` כלי דיג׳רידו למכירה | yes UA | yes | down |
| 18 | `a` תיקים לדיג׳רידו | yes UA | yes | down |
| 19 | `a` סטנדים לאחסון דיג׳רידו | yes UA | yes | down |
| 20 | `a` סטנד רצפתי לנגינה | yes UA | yes | down |
| 21 | `a.nav__dd` ספרים ▾ | yes UA | yes | back to nav, left of 14 |
| 22 | `a` מבצעים | yes UA | yes | down |
| 23 | `a` צבע בכחול וזרוק לים | yes UA | yes | down |
| 24 | `a` כושי בלאנטיס | yes UA | yes | down |
| 25 | `a` וכתבת | yes UA | yes | down |
| 26 | `a` בלוג דיג׳רידו | yes UA | yes | back to nav, left of 21 |
| 27 | `button.nav__dd` אייל עמית ▾ | yes UA | yes | left |
| 28 | `a` אודות אייל | yes UA | yes | down |
| 29 | `a` מוקש דהימן — לזכרו | yes UA | yes | down |
| 30 | `a` צור קשר | yes UA | yes | back to nav, left of 27 |
| 31 | `button.nav__tg` הפעלת קול בסרטון | yes UA | yes | left |
| 32 | `a.nav__en` EN | yes UA; clip **obvious blue ring** | yes | left of 31 |
| 33 | `a.btn.btn--terra` לתיאום שיחת היכרות | **yes** author `solid 2px rgb(208,138,94)` offset 3px; ring vs fill is **weak** in the clip | yes | down into hero |
| 34 | `a.btn.btn--gw` למידע נוסף על טיפול בדיג'רידו | computed yes 2px; **painted COULD NOT MEASURE** (screenshot 0-height after scroll) | yes | down (`doc y≈3569`), right card |
| 35 | `a.btn.btn--gw` למידע נוסף על סאונד הילינג | computed yes 2px; painted **COULD NOT MEASURE** | yes | same band, **left** of 34 — matches RTL |
| 36 | `a.btn.btn--terra` לתיאום שיחת היכרות | computed yes 2px; painted **COULD NOT MEASURE** | yes | down |
| 37 | `a.tlink` למידע נוסף על טיפול בדיג'רידו | computed yes 2px; painted **COULD NOT MEASURE** | yes | down |
| 38 | `a.btn.btn--gw` למידע נוסף על סאונד הילינג | computed yes 2px; painted **COULD NOT MEASURE** | yes | down |
| 39 | `a.tlink` לתיאום שיחת היכרות | computed yes `solid 2px rgb(154,79,43)`; painted **COULD NOT MEASURE** | yes | down |
| 40 | `a.tmq__nl` חיה עזריה | computed yes UA auto; painted **COULD NOT MEASURE** | yes | down; still in testimonials, **not** the footer |

`box-shadow` was `none` on every home stop. Nav does **not** use the author 2px terracotta outline; it uses Chrome’s UA ring.

---

## `/contact/`

Same skip + RTL nav as home, except there is **no** sound-toggle: stop 31 is `EN`. Then the page, then the form top-to-bottom.

| # | Element | Focus indicator | On screen | RTL |
|---:|---|---|---|---|
| 1 | `a.ea-skiplink` דלג לתוכן | computed yes UA auto; clip **no distinct ring** | yes | first; top-right |
| 2 | `a.nav__b` אייל עמית — דף הבית | yes UA; clip **blue ring** | yes | left of skip |
| 3 | `a.nav__dd` טיפול בדיג׳רידו ▾ | yes UA | yes | left |
| 4 | `a` טיפול בדיג׳רידו | yes UA | yes | down |
| 5 | `a` נחירות ודום נשימה בשינה | yes UA | yes | down |
| 6 | `a` השיטה | yes UA | yes | back to nav, left of 3 |
| 7 | `a` שיעורי דיג׳רידו | yes UA | yes | left |
| 8 | `a` סאונד הילינג | yes UA | yes | left |
| 9 | `button.nav__dd` לימוד והכשרה ▾ | yes UA | yes | left |
| 10 | `a` הכשרות למטפלים | yes UA | yes | down |
| 11 | `a` קורסים | yes UA | yes | down |
| 12 | `a` הרצאות | yes UA | yes | down |
| 13 | `a` סדנאות | yes UA | yes | down |
| 14 | `a.nav__dd` כלים ואביזרים ▾ | yes UA | yes | back to nav, left of 9 |
| 15 | `a` כלים בעבודת יד ואביזרים | yes UA | yes | down |
| 16 | `a` תיקון וחידוש כלים | yes UA | yes | down |
| 17 | `a` כלי דיג׳רידו למכירה | yes UA | yes | down |
| 18 | `a` תיקים לדיג׳רידו | yes UA | yes | down |
| 19 | `a` סטנדים לאחסון דיג׳רידו | yes UA | yes | down |
| 20 | `a` סטנד רצפתי לנגינה | yes UA | yes | down |
| 21 | `a.nav__dd` ספרים ▾ | yes UA | yes | back to nav, left of 14 |
| 22 | `a` מבצעים | yes UA | yes | down |
| 23 | `a` צבע בכחול וזרוק לים | yes UA | yes | down |
| 24 | `a` כושי בלאנטיס | yes UA | yes | down |
| 25 | `a` וכתבת | yes UA | yes | down |
| 26 | `a` בלוג דיג׳רידו | yes UA | yes | back to nav, left of 21 |
| 27 | `button.nav__dd` אייל עמית ▾ | yes UA | yes | left |
| 28 | `a` אודות אייל | yes UA | yes | down |
| 29 | `a` מוקש דהימן — לזכרו | yes UA | yes | down |
| 30 | `a` צור קשר | yes UA | yes | back to nav, left of 27 |
| 31 | `a.nav__en` EN | yes UA; clip **blue ring** | yes | left (no `nav__tg` on this page) |
| 32 | `a.btn.btn--gw` דברו איתי בוואטסאפ | yes author 2px `rgb(208,138,94)`; clip **shows a lighter ring** | yes | down, right column |
| 33 | `input` שם מלא | yes author 2px `rgb(164,78,43)`; painted **COULD NOT MEASURE** (0-height) | yes | down into the form |
| 34 | `input` טלפון | yes author 2px; clip not a usable field shot | yes | down, same x |
| 35 | `input` אימייל | yes author 2px; clip is the **photo** — painted **COULD NOT MEASURE** | yes | down |
| 36 | `select` נושא | yes author 2px; painted **COULD NOT MEASURE** | yes | down |
| 37 | `textarea` הודעה | yes author 2px; painted **COULD NOT MEASURE** | **yes, partial** (intersects; bottom past 900) | down |
| 38 | `input.wpcf7-submit` שליחה | yes author 2px; painted **COULD NOT MEASURE** | yes | down; narrower control, not a same-row LTR jump |
| 39 | `a.ea-cta-pill` דברו איתי בוואטסאפ (נפתח בחלון חדש) | yes author 2px; painted **COULD NOT MEASURE** | yes | down |
| 40 | `a` 052-4822842 | yes UA auto; painted **COULD NOT MEASURE** | yes | down, footer NAP; later footer links not walked |

---

## What this falsifies / does not prove

Nav Tab order **matches** visual RTL. I will not call submenu-exit (up to the next top-level, then left) a reading-order break.

A computed outline **does** appear on every recorded stop, and it is **absent** when that node is unfocused. That is not the same as a **perceptible** ring: the skip-link terracotta clip does not show one. Nav/EN do. Author 2px on `.btn` / CF7 / `.tlink` is measured in computed style; I could not screenshot-confirm it after auto-scroll.

Nav never got the author `2px solid` rule that buttons and fields use — only Chrome `auto 1px rgb(0,95,204)`.

**Could not measure:** end of either document; painted rings on scrolled stops (Puppeteer `0 height`); pixel-diff focused vs unfocused clips (unfocused clips not taken); ring contrast; mobile tab order. No scanner.
