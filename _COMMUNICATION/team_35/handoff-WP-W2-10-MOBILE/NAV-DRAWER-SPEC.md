# NAV-DRAWER — interaction spec (WP-W2-10 mobile)

team_35 → team_10 · D-14 verbatim. Source of truth for the mobile menu. Implementation files: `mockups/assets/ea-mobile-nav.{css,js}`.

---

## 1. Closed state — the top bar (`ea-topnav`, dark, fixed, 64px)

Layout (RTL): **brand pinned to inline-end (right)**, control cluster at **inline-start (left)**. The control cluster's internal order is fixed LTR so it reads the same regardless of page direction:

```
[ ☰ burger ] [ ♪ שמע ] [ EN ]            … brand →
```

- **Burger** `.ea-mnav-burger` — 44×44, 1px hairline border, 3-bar glyph that morphs to an X when open. `aria-label` toggles open↔close, `aria-expanded`, `aria-controls="ea-mnav-drawer"`, `aria-haspopup`.
- **Sound** `.ea-mnav-sound` — pill, ≥44px tall, `♪ שמע`; `aria-pressed` toggles to `משמיע` and fills with `--ea-sand`. **Visual only** until the audio asset arrives (Eyal-gap).
- **EN** `.ea-mnav-lang` — pill linking to `/en` (on `/en` it reads `עברית` → `/`). `lang` + descriptive `aria-label`.
- Desktop nav links (`.ea-topnav__links`) are **hidden ≤1023px** (`.ea-topnav .ea-topnav__links{display:none}` — 2-class specificity beats the page's own `display:flex`).

All three controls are ≥44×44 with visible `:focus-visible` rings.

## 2. Open state — side sheet

- **Type:** full-height **side sheet**, `inline-size: min(86vw, 360px)`, anchored to the burger's edge (inline-end in RTL). Dark gradient on `--ea-ink` to match the bar.
- **Slide:** `transform: translateX(var(--ea-mnav-tx))` → `0`. `--ea-mnav-tx` is the **only physical value**, computed once from `(dir, side)`:
  - RTL + side `end` → `+100%` (off to the right); RTL + `start` → `-100%`; mirror for LTR.
- **Scrim** `.ea-mnav-scrim` — fixed full-bleed `rgba(46,43,40,.55)` + 2px blur, fades in; click closes.
- **Transitions:** `--ea-dur-mid` / `--ea-ease-enter`. Disabled under `prefers-reduced-motion`.
- **Body scroll lock** while open (`overflow:hidden` on `html,body`); drawer has `overscroll-behavior:contain`.

### Open / close triggers
| Action | Result |
|---|---|
| Tap burger | toggle |
| Tap ✕ (`.ea-mnav-close`, 44×44, in drawer header) | close |
| Tap scrim | close |
| `Esc` | close |
| Tap any real nav link / sublink / brand / footer link | close (then navigate) |
| Resize ≥1024px | auto-close |

### Focus management (a11y)
- `role="dialog"`, `aria-modal="true"`, `aria-label` = "תפריט" / "Mobile menu".
- On open: remember `document.activeElement`, move focus to the ✕ after the slide.
- **Focus trap:** Tab / Shift-Tab cycle within the drawer's focusable set only.
- On close: restore focus to the element that opened it.

## 3. The menu (locked to `site-tree.json`, Eyal-approved 2026-04-06)

Order inside the drawer (`.ea-mnav-list`):

1. בית
2. טיפול בדיג׳רידו
3. השיטה
4. שיעורי דיג׳רידו
5. סאונד הילינג
6. **לימוד והכשרה** ▸ *(accordion)* → הכשרות למטפלים · קורסים `(חיצוני ↗)` · הרצאות · סדנאות
7. **כלים ואביזרים** ▸ *(accordion)* → כלים בעבודת יד ואביזרים · תיקון וחידוש כלים
8. מוזה הוצאה לאור
9. בלוג דיג׳רידו
10. **אייל עמית** ▸ *(accordion)* → מוקש דהימן — לזכרו
11. צור קשר

**Drawer footer** (`.ea-mnav-foot`): sound + EN utilities repeated, then the secondary links — שאלות נפוצות · גלריות · המלצות · מדיניות פרטיות · הצהרת נגישות · תקנון.

> The mockup JS counts: **8 top-level links + 3 accordions** (= 11 menu items) and **7 sub-links**. The active route gets `aria-current="page"` + a terracotta marker.

## 4. Submenu pattern — inline accordion

- Parent is a `<button class="ea-mnav-acc__btn">` with `aria-expanded` + `aria-controls`, a label, and a `⌄` caret that rotates 180° when open.
- Panel uses the **`grid-template-rows: 0fr → 1fr`** technique (animates height with no magic numbers; collapses cleanly for reduced-motion).
- First sub-item is the parent's **overview** link (e.g. "לימוד והכשרה — עמוד ראשי") so the landing page is reachable; then the children.
- External item (קורסים) shows a `חיצוני ↗` affordance.
- Multiple accordions may be open at once (no forced single-open).

## 5. Desktop (≥1024px) — canonical dropdowns (uniformity fix)

The same locked model renders the desktop nav so **every template is identical**:
- 10 top-level links; the 3 parents become **hover/focus dropdown menus** (`.ea-topnav__sub`, fade+rise, `focus-within` accessible, caret rotates).
- This replaces each page's previous ad-hoc link subset — the explicit review blocker.

## 6. EN `/en` — LTR mirror

Same component, `dir="ltr"`: slide axis flips, drawer anchors to the burger (right), English menu (**Home · The Method · Services · Books · Testimonials**), "עברית" pill → `/`, English footer + utilities. No separate code path — logical properties + the computed slide sign handle it.

## 7. Harness bridge (mockup only)
`ea-mobile-nav.js` listens for `postMessage({ns:"ea-mnav", …})`: `open` / `close`, `side` (`end`|`start`), and `variant` (sets `data-compare|shop|testi` on `<html>`). It also posts `{evt:"ready"}` so the harness can replay state after each iframe load. **Drop this listener when porting to WP** — it exists only to drive `Mobile UI.html`.
