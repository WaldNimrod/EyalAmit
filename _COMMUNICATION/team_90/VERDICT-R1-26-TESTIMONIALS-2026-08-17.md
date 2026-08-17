# VERDICT — R1-26 /testimonials — PASS

**מאמת:** team_90 · Composer (`composer-2.5`, Cursor) · **בנאי:** Claude (Anthropic) — Iron Rule #1 מקוים.
**תאריך:** 2026-08-17 · **היקף:** דסקטופ בלבד (החלטת team_00) · **ראיות:** `_COMMUNICATION/team_90/evidence-R1-26/`

הורץ בשלושה ליינים נפרדים — ראו «הערה תפעולית» בסוף.

## ליין 1 — תוכן /testimonials

# VERDICT — /testimonials content — PASS

1. **CONFIRMED** — 48 `<figure class="tmq">` cards (expected 48).
2. **CONFIRMED** — category `<h2>` headings in order: טיפול בדיג'רידו=17, סאונד הילינג=9, שיעורי נגינה בדיג'רידו=22 (expected 17/9/22).
3. **CONFIRMED** — name links=48, `facebook.com/share/` in href=48, `target="_blank"`=48, `rel` with noopener=48 (expected 48 each).
4. **CONFIRMED** — empty/missing quote=4: דן ארליכמן, דרור מצליח, קרן אברשי, שיילי פיינברג (אמא של אלון פיינברג) (expected exactly 4).
5. **CONFIRMED** — `/media/` hrefs=0 (none found anywhere in the capture).

## ליין 2 — הפניה 301 + דף הבית

# VERDICT — redirect + home — PASS

1. **GET /media/ → 301 → /testimonials/** — CONFIRMED — `headers.txt` lines 4–5 `HTTP/1.1 301 Moved Permanently`, line 15 `Location: http://eyalamit-co-il-2026.s887.upress.link/testimonials/`
2. **/testimonials/ 200; /testimonials-media/ single-hop (not double 301)** — CONFIRMED — `/testimonials/` lines 20 `HTTP/1.1 200 OK`; `/testimonials-media/` lines 37–38 `301` → line 47 `Location: .../testimonials/` (terminal 200 on `/testimonials/`, no chained 301)
3. **15 distinct testimonial people on home** — CONFIRMED — 30 `<figure class="tmq">` (marquee duplicate set); 15 distinct names/quotes (e.g. חיה עזריה … רתם פרץ, then repeat)
4. **CTA «לכל ההמלצות» href=/testimonials/** — CONFIRMED — `home.html` line 323: `<a class="btn btn--gd r" href="/testimonials/">לכל ההמלצות</a>` (not `/media/`)
5. **Remaining links to /media/** — CONFIRMED none — no `href` to `/media/` in `home.html` (only CSS `media='all'` attrs and WP REST `wp-json/wp/v2/media` in JS config, not page path)

## ליין 3 — רגרסיה בעמודי השירות

# VERDICT — service-page regression — PASS

treatment.html — CONFIRMED (expected 13): raw figures 26, distinct 13
sound-healing.html — CONFIRMED (expected 8): raw figures 16, distinct 8
lessons.html — CONFIRMED (expected 9): raw figures 18, distinct 9

/media/ links: none on any of the three pages (no `href` to `/media/`).


## סיכום

| נבדק | תוצאה |
|---|---|
| 48 המלצות ב-17/9/22 לפי הכותרות של אייל | ✅ CONFIRMED |
| 48 קישורי FB, target=_blank, rel=noopener | ✅ CONFIRMED |
| /media/ → 301 → /testimonials/ בקפיצה אחת | ✅ CONFIRMED |
| /testimonials-media/ ללא קפיצה כפולה | ✅ CONFIRMED |
| CTA «לכל ההמלצות» → /testimonials/ | ✅ CONFIRMED |
| אפס קישורים שנותרו ל-/media/ | ✅ CONFIRMED |
| רגרסיה: treatment 13 · sound-healing 8 · lessons 9 · בית 15 | ✅ CONFIRMED |

**ממצא פתוח (לא חוסם):** 4 המלצות מרנדרות שם וקישור ללא טקסט — דן ארליכמן · דרור מצליח ·
קרן אברשי · שיילי פיינברג. אומת עצמאית ע"י המאמת. מנוהל כסעיף M-01, ממתין לאייל.

## הערה תפעולית — איך מריצים ליין קומפוזר כאן

1. `cursor-agent` רץ ב-`--mode plan` ולכן **אינו יכול להריץ shell**. אין לבקש ממנו `curl`.
   team_100 לוכד את הראיות לקבצים, והקומפוזר מנתח אותן.
2. מנדט שדרש קריאת ~400KB HTML מחמישה קבצים החזיר **פלט ריק פעמיים**. פיצול לליין לכל
   נושא — קובץ אחד או שניים — עבד מיד. **ליין ממוקד לכל נושא.**
3. העטיפה `run_cross_engine_validator.sh` זיהתה את הפלט הריק ונכשלה בקול (exit 3) במקום
   להיקרא כ-PASS ללא ממצאים. המנגנון הזה עשה בדיוק את עבודתו — אין לעקוף אותו.
