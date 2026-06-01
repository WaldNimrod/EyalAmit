---
id: MANDATE-TEAM190-BUGFIX-QA-L-GATE-VALIDATE-2026-06-01
title: team_190 mandate — L-GATE_VALIDATE (constitutional, cross-engine) for the bug-fix sweep + HTTP QA
status: ACTIVE — ROUND 2 (re-validate; round-1 FAILed on triage completeness, now remediated)
date: 2026-06-01
from_team: team_100 (Chief System Architect)
to_team: team_190 (L-GATE_VALIDATE — native Codex / non-Claude)
deliverable: known-bug fix sweep (NOW 5 fixes) + reusable HTTP QA tooling
branch: fix/f-w2-05-01-nav-repair
head_commit: 3d57422
base_main: d359850
staging: http://eyalamit-co-il-2026.s887.upress.link
report_ref: _COMMUNICATION/team_100/BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01.md
build_gate_ref: _COMMUNICATION/team_50/VERDICT-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md
---

# מנדט team_190 — L-GATE_VALIDATE (חוקתי, cross-engine) / Bug-fix sweep + HTTP QA

## ⟳ ROUND 2 (2026-06-01) — מה תוקן מאז ה-FAIL שלך
ה-VALIDATE שלך ב-round 1 **נכשל בצדק** על שלמות-triage: **F-W2-05-01** (פריט ניווט→`/tools-and-accessories/repair/`
legacy במקום `/repair/` קנוני) הושמט מהדוח. תוקן ב-HEAD `3d57422`: mu-plugin חדש מפנה את ה-menu לדף הקנוני
(אומת חי: menu→`/repair/`, legacy=0), והדוח עודכן (F-W2-05-01 נוסף לתיקונים; §6 דף-כפול legacy + Yoast author-slug
כ-P3; §7 הערת-תהליך על ההחמצה). אמת ש**team_50 round-2 = PASS** (כולל AC-08) לפני שתתחיל, ואז אמת מחדש כולל
שלמות-triage (הפעם השלמה).

## 0. Cross-engine chain (IR#1 + IR#5) — חובה
builder = **Claude** ≠ L-GATE_BUILD = **team_50 (non-Claude)** ≠ L-GATE_VALIDATE = **team_190 (native Codex)**.
אמת ששלוש החוליות שונות. validate חוקתי הוא ה-gate הסופי (IR#5) — בדיקה עצמאית, cache-busted, HTTP בלבד.

## 1. תנאי כניסה
רוץ רק אחרי **team_50 L-GATE_BUILD = PASS** (`VERDICT-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md`). HEAD `016de33`.

## 2. מה לאמת (חוקתי + עצמאי)
1. **שרשרת cross-engine** תקינה (builder≠50≠190) — מתועדת בוורדיקטים.
2. **שחזור עצמאי** של 4 התיקונים החיים (B1 blog `[vc_`=0, B2 `/en` ללא `ea-blog-archive-view` + `/blog` כן, B3 override LTR, B4 byline "אייל עמית") — cache-busted, HTTP.
3. **שחזור QA**: `node scripts/qa/http-qa-axe.cjs` → 14/14 0 critical/0 serious; Lighthouse כמדווח.
4. **תקינות קוד** (code review של ה-diff `90cf695`):
   - regex ב-`ea-blog-shortcode-cleanup.php` — אין catastrophic backtracking / הסרת תוכן לגיטימי; guard `is_singular`/`get_post_type`.
   - `ea-w2-10-author-displayname-once.php` — idempotent (option flag), `wp_update_user` בטוח, לא רץ כל בקשה.
   - `wave2-w2-06.php` — תנאי ה-body class נכון (לא מסיר יתר על המידה; `/blog` עדיין מקבל).
   - override CSS scoped ל-`body.ea-en-landing` (לא דולף ל-RTL).
5. **שלמות ה-triage**: ודא שאף פריט FIXABLE-NOW לא נשמט מהדוח (`BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01.md`), וש-NEEDS-EYAL/NEEDS-DECISION סווגו נכון.
6. **TLS**: ודא שההחלטה (staging HTTP-only, EYAL_ENV_VARS_REFERENCE §44) נכונה ושאין הסתמכות על https.

## 3. ורדיקט
`_COMMUNICATION/team_190/VERDICT-BUGFIX-QA-L-GATE-VALIDATE-2026-06-01.md` — שורה 1 = מנוע (native Codex);
PASS/FAIL לכל סעיף 2.1–2.6 + ראיה; כל P0/P1 חוסם. **PASS = אישור להתקדם ל-S3** (team_10 refine, לכל אשכול לאחר sign-off S2 של אייל).

---

## 📋 PROMPT מוכן-להדבקה (team_190 — הדביקו ב-Codex/מנוע שאינו Claude ושאינו מנוע team_50)

```
אתה team_190, מאמת L-GATE_VALIDATE חוקתי (native Codex/GPT — חייב להיות שונה מ-builder=Claude ומ-team_50).
ריפו: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026 · branch chore/bugfix-qa-http · HEAD 016de33.
תנאי כניסה: team_50 L-GATE_BUILD = PASS (_COMMUNICATION/team_50/VERDICT-BUGFIX-QA-L-GATE-BUILD-2026-06-01.md).
משימה: validate חוקתי של תיקוני הבאגים + QA לפי
_COMMUNICATION/team_190/MANDATE-TEAM190-BUGFIX-QA-L-GATE-VALIDATE-2026-06-01.md.

עשה:
1) אמת שרשרת cross-engine: builder=Claude ≠ team_50 ≠ אתה.
2) שחזר עצמאית (HTTP, cache-bust) את 4 התיקונים B1-B4 (פירוט בסעיף 2.2 של המנדט).
3) הרץ `node scripts/qa/http-qa-axe.cjs` (0 critical/0 serious, 14×200) + Lighthouse על / /treatment/ /blog/ /en/.
4) קרא את ה-diff של commit 90cf695 ובצע code review: regex strip בטוח, once-plugin idempotent + wp_update_user בטוח, תנאי body-class נכון, CSS scoped ל-body.ea-en-landing.
5) ודא שלמות ה-triage בדוח BUGFIX-SWEEP-AND-HTTP-QA-2026-06-01.md (אף FIXABLE-NOW לא נשמט).
6) staging = HTTP בלבד.
כתוב verdict ל-_COMMUNICATION/team_190/VERDICT-BUGFIX-QA-L-GATE-VALIDATE-2026-06-01.md: שורה 1 = מנוע;
PASS/FAIL לכל 2.1-2.6 עם ראיה. PASS = אישור להתקדם ל-S3. אל תשנה קוד; אל תעשה commit/push.
```

*team_100 → team_190 | L-GATE_VALIDATE חוקתי. PASS → מתקדמים ל-S3 (team_10 refine).*
