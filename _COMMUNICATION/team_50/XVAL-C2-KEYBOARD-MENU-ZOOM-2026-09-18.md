Independent C2 check on a different engine. Nothing was changed. Tab was real: on every page focus started on `BODY` and the first Tab moved it off. Viewport was asserted **390×844** before any judgement. All four pages loaded (HTTP 200, HTML 50k–159k bytes, `.ea-skiplink` + `main#main` present). `html[dir=rtl]` on all four.

Full write-up: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-C2-KEYBOARD-MENU-ZOOM-2026-09-18.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_50/XVAL-C2-KEYBOARD-MENU-ZOOM-2026-09-18.md)

---

### `/` home

**1. Tab / RTL (measured).** Skip (x=290.7, top-right) → brand (236) → **burger (44, far left)** → שמע (153) → EN (96). Visual RTL of that bar is brand → שמע → EN → burger. Tab after the brand jumps to the left edge, then back right. That contradicts visual order. Stop **12** `a.tlink` “לתיאום שיחת היכרות” in `#peek` took focus at **y=2252** in an 844-tall viewport (`onScreen=false`). Footer socials tab leftward (RTL).

**2. Skip (measured).** First stop **is** `a.ea-skiplink`. Enter: `hash=#main`, focus = `main#main` (`tabindex=-1`). `scrollY` stayed **0**; `#main` was already at y=0. Focus moved into main; the viewport did **not** scroll. Space was **not** pressed.

**3. Menu (measured).** Tab 3 is the burger. Enter opens (`data-menu=1`). Focus stays on the burger; **continuing Tab does enter** `.nav__l`. Escape closes; focus returns to the burger. Closed menu: **in the DOM** (28 controls), **not** `display:none`, **`visibility:hidden`** (all 28 `innerText=""` while `textContent` still has labels), **0** of them hit by real Tab. Open panel visually overlaps and clips submenu text on the left — that is paint, not a Tab-reach failure.

**4. 200% text.** Document overflow **0 px**. That number is not “no clip”: skip peeks ~24px over the brand (overlap 99×22); `h1.hero__h` sits at **y=−150**. CSS `zoom:2` overflow is also 0 (metric collapses) but burger is **151.6 px** off the left, EN **107.6 px** off.

---

### `/contact/`

**1.** Same header jump: brand → burger → EN vs visual brand → EN → burger. 29 stops, wrapped to skip. No fully off-screen focused control.

**2.** First stop is the skip (activation not re-run).

**3.** Same as home: Tab into open menu, Escape back to burger. Closed: 28 DOM / 0 `display:none` / 28 `visibility:hidden` / 0 Tab hits.

**4.** Overflow **0 px**. Skip peeks over the brand. Heading “צור קשר” stayed in-viewport.

---

### `/faq/`

**1.** Same header contradiction. Topic chips tab RTL along the row, then **six chips take focus while hanging off the left** (up to **87.5 px** off). Chrome did not scroll them fully into view. Walk capped at **55** stops, still inside FAQ summaries — **end of this page’s tab order COULD NOT MEASURE**.

**2.** First stop is the skip.

**3.** Same menu facts as home.

**4.** Overflow **0 px**. Heading “שאלות נפוצות” overlaps the nav. A 1×1 `ea-faq-toc__label` “נושאים:” is a visually-minified span, not body clipping.

---

### `/shop/`

**1.** Same header jump. Cards are a single column (no row-wise RTL to judge). 26 stops, ended on `BODY` after WhatsApp, no wrap. No off-screen focused control.

**2.** First stop is the skip.

**3.** Same menu facts.

**4.** Overflow **0 px**. Skip peeks over the brand. Heading in-viewport. WhatsApp float covers the last letters of the lead in the shot (overlay, not document overflow).

---

**Could not measure:** Space on the skip link; rest of `/faq/` after stop 55; OS-level text zoom; CSS-`zoom` overflow as a pixel budget (always 0). Tab was moving real document focus on all four pages. No scanner.
