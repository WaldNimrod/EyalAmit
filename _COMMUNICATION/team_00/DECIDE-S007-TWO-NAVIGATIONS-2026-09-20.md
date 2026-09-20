---
id: DECIDE_S007_TWO_NAVIGATIONS_2026-09-20
schema_version: aos_v1_team_messaging
type: DECISION REQUEST (team_100 → team_00)
from: team_100
to: team_00
cc: [team_10]
date: 2026-09-20
found_during: M-12 (one mobile drawer)
blocking: no — the drawer is being built from the richer list meanwhile
---

# שני תפריטים חיים באתר, והם לא מסכימים

**נמצא הלילה בזמן בניית המגירה, ולא חיפשנו אותו.** אין כאן דחיפות — המגירה נבנית מהרשימה
המלאה יותר — **אבל זו הכרעת תוכן ולכן היא שלך.**

## מה קיים

**תפריט אחד כתוב ישירות בקוד** ומשרת את רוב האתר. **תפריט שני הוא תפריט וורדפרס אמיתי**,
כזה שאפשר לערוך מלוח הבקרה, **והוא מה שמוגש בששת עמודי תבנית האב ובעמודי הגל השני.**

**הם נפרדו במשך חודשים ואף אחד לא שם לב.**

## מה שיש באחד ואין בשני

**בתפריט שבקוד ולא בתפריט וורדפרס — תשעה פריטים:** **כל עץ החנות** — כלים למכירה, תיקים,
סטנדים לאחסון, סטנד רצפתי, וכלים בעבודת יד. **עמוד הנחירות ודום הנשימה**, שעבדנו עליו כל
הלילה. **המבצעים בספרים. והמעבר לאנגלית.**

**בתפריט וורדפרס ולא בזה שבקוד — ארבעה:** לימוד והכשרה כעמוד ראשי, הקורסים החיצוניים,
וכלים ואביזרים על שתי רמותיו.

## מה זה אומר למבקר

**מי שנוחת היום באחד מששת עמודי תבנית האב לא יכול להגיע מהתפריט לחנות ולא לעמוד הנחירות,
ואין לו בכלל מעבר לאנגלית.** זה לא הוחלט — **זה מה ששתי מערכות ניווט שנפרדות נראות כמו.**

## ופריט אחד שהוא תקלה ולא הכרעה

**בתפריט שבקוד יש פריט «קורסים» שלא מוביל לשום מקום** — הקישור שלו ריק. **הוא כבר רשום
אצלנו כתקלת נגישות ידועה, וזו הפעם השנייה שהוא צף.**

**הוצאתי אותו מהמגירה הנבנית.** **פריט שלא עושה כלום גרוע מפריט חסר, כי לוחצים עליו** —
ולשכפל אותו לכל עמוד באתר היה להכפיל תקלה במקום לסגור אותה.

## מה אני צריך ממך

**איזו רשימה היא הנכונה, ומה אמור להיות בתפריט.**

**ההמלצה שלי:** **תפריט וורדפרס אחד לכל האתר**, שמכיל את מה שיש היום בקוד פלוס ארבעת
הפריטים שרק בו — **כדי שתוכל ואייל תוכלו לערוך את התפריט בלי פריסה.** היום עריכה בלוח
הבקרה לא משנה כלום ברוב האתר, וזה בעצמו מלכודת.

**וזה שינוי שדורש בדיקה זהירה ולא לילה אחד** — ולכן הבאתי אותו כהכרעה ולא כמשימה שסגרתי.

---

## ✅ הכרעת team_00 — 20 בספטמבר 2026

**מקור — לשונו של נימרוד:**

> «כל העמודים ללא יוצא מהכלל חייבים להציג אותו תפריט מדוייק ונכון. בכל סביבה ובכל מסך.
> עמודים שלא נמצאים בטפריט - להעלות לאייל בטופס.»

**Canonical ruling (English — binding for all teams):**

1. **ONE navigation. Every published URL, no exceptions, desktop and mobile alike.** Identical
   item set, identical labels, identical targets. "Every environment and every screen" is the
   owner's own wording and is not satisfied by a shared mobile drawer over two different
   desktop navs.
2. **Pages that are not in the menu go to Eyal in the form** — he decides whether each one
   joins the menu, stays out, or is deleted. No team decides that silently.
3. This supersedes the "six GeneratePress orphan pages" framing that M-12 Phase B was scoped
   against. The measurement below replaces it.

## Live measurement against 1.5.88 — 2026-09-20, all published URLs

**279 published URLs across the five sitemaps.** Which navigation each one renders:

- **135 render the Chapters nav** — the code-written one, 28 links. This is the canonical list.
- **143 render the WordPress menu** — a different, disagreeing set of 21 links.
- **1 renders no navigation at all: `/en/`.**

**The 143 are not six pages.** They are six real pages — `/historical-articles/`,
`/learning/courses-external/`, `/press/`, `/services/`, `/shows-heritage/`, `/thank-you/` —
plus **133 `faq-item` singles, 2 `gallery-item` singles and 2 `testimonial-item` singles**.
The custom-post-type singles were missed by every earlier sweep because every earlier sweep
read `page-sitemap.xml` only. 24 of 24 randomly sampled `faq-item` URLs render the WP menu.

**Correctness, not only consistency:** the WP menu links to `/tools-and-accessories/`,
`/tools-and-accessories/instruments/` and `/tools-and-accessories/repair/`, and all three are
**301s** to `/shop/`, `/didgeridoos/` and `/repair/`. So those 143 URLs currently offer
visitors menu links that bounce. The same three redirecting URLs are also sitting in
`page-sitemap.xml`, which is a separate defect and is ours, not Eyal's.

**`/press/` is the last page still carrying Wave2's `ea-mnav` markup.**

## Pages not in the menu — what went to Eyal

Seven, now filed as part ה׳ of the dated form
(`_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`): `/press/`,
`/learning/`, `/services/`, `/shows-heritage/`, `/historical-articles/`, `/thank-you/`,
`/learning/courses-external/`. The 48 printed-QR-code pages plus their index are deliberately
out of the menu and were excluded — their permalinks must not change.

**`/press/` is the one that matters most:** a complete, finished page with real content that
no menu in any template links to. A visitor cannot reach it at all.

## A correction to the placeholder count filed earlier today

**Nine placeholder URLs, not five.** The four custom-post-type seed singles —
`ea-m3-seed-gallery-1`, `ea-m3-seed-gallery-2`, `ea-m3-seed-testimonial-1`,
`ea-m3-seed-testimonial-2` — are published, in the sitemap, carry no robots meta, and their
visible body is our own internal build notes («בלי אישור 100», «לפי החלטת 100»). They are a
**different category** from the five pages: they are our own test fixtures, not pages awaiting
Eyal's content, so nothing about them is being asked of him. **Open for team_00: are they to be
deleted outright, and should the 133 `faq-item` singles be public URLs at all, given the same
content is already served by `/faq/`?**

**Status:** RULED. Implementation mandated to team_10 as M-13.
