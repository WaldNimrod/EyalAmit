VERDICT: PASS

**מאמת:** team_90 · Composer (`composer-2.5`) · 2026-08-21  
**בנאי הגל:** Cursor Grok 4.6 · Iron Rule #1 (validator ≠ builder)  
**בסיס:** http://eyalamit-co-il-2026.s887.upress.link/ · `curl -sk` · דסקטופ  
**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-S006-W1-HOME-2026-08-21.md`  
**מקורות:** `homepage1-3 v2.md` · Excel דף הבית (Eyal notes 19.8.26)

## בדיקות

| # | בדיקה | תוצאה | ראיה |
|---|--------|--------|------|
| **1** | אין תווית `פרק 02`…`פרק 11`; `.chap` ריק; H2 נשארות | **CONFIRMED** | `rg 'פרק 0[2-9]|פרק 1[01]'` → 0 · אין `<span class="chap">` · 10 כותרות H2 חיות (מה זה… · וידאו · השוואה · למי · איך מתחילים · מפגש · סטודיו · הצצה · עדויות · אייל עמית) |
| **2** | `#what` — פסקת «יש דרכים שונות לעבוד עם הנשימה…» | **CONFIRMED** | `<section id="what">` · `<p>יש דרכים שונות לעבוד עם הנשימה, והדיג'רידו מציע דרך אחרת…</p>` — תואם `homepage1-3 v2.md` SECTION 02 |
| **3** | `#compare` — אין `cmp_lead` (אותה פסקה); כרטיסי השוואה נשארים | **CONFIRMED** | אחרי H2 יש ישר `<div class="cmp">` · שני `.cmpc` (דיג'רידו + סאונד הילינג) · `יש דרכים שונות` בתוך `#compare`: false |
| **4** | `#whom` — אין `whom_lead` מעל הרשימה | **CONFIRMED** | H2 «למי מתאים התהליך» → `<div class="whom">` · ארבע `.whom__i` · אין intro-body/lead בין כותרת לרשימה |
| **5** | `#about` — קישור «לקריאה נוספת אודות אייל עמית» → `/eyal-amit/`; אין «לעמוד אייל עמית»; אין `.tl` | **CONFIRMED** | `<a class="tlink" href="/eyal-amit/">לקריאה נוספת אודות אייל עמית</a>` · `לעמוד אייל עמית`: 0 · `.tl` / timeline: 0 |
| **6** | `#peek` — גלריה מ-`home-peek/`; לא hotlink ל-eyalamit.co.il; H-06 פלייסהולדר וידאו נשאר | **CONFIRMED** | 30 `<img>` תחת `…/assets/images/chapters/home-peek/peek-*.jpeg|jpg` · `eyalamit.co.il` בתוך `#peek`: 0 · `#video`: `<div class="videoblk">` + «כאן ייכנס וידאו 16:9» (H-06) |
| **7** | פרק 10 — CTA «לכל ההמלצות» → `/testimonials/`; 15 עדויות מה-md | **CONFIRMED** | `<a class="btn btn--gd" href="/testimonials/">לכל ההמלצות</a>` · `/media/`: 0 · 15 שמות ייחודיים בקרוסלה (חיה עזריה … רתם פרץ) — תואם SECTION 10; שכפול DOM ל-marquee (30 `<figure class="tmq">`) — לא עדות 16 |

## היקף בנאי (לא נבדק כ-FAIL)

| פריט | הערה |
|------|------|
| `ea-testimonials.js` · `videoblk.php` | גבול scope לבנאי (גל 1) — לא כשל תוכן חי; JS קיים מטעמי marquee · `videoblk` = פלייסהולדר H-06 ב-`#video` |
| קבצים dirty מלפני הגל | מוחרגים במנדט — לא נבדקו |

## סיכום

שבע הבדיקות החיות של גל 1 · בית עברו על הסטייג'ינג. HTML לא ריק (80,688 B). ממתין לאייל (מחוץ להיקף): H-06 קישור וידאו אמיתי · H-07 מדיה (גלריה `#peek` כבר מנכסי תמה).
