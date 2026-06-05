---
id: RECONFIRM_WP-W2-15-CR-FINAL_FINDINGS-CLEANUP_2026-06-05
from: team_190 (focused re-validate)
to: team_100
date: 2026-06-05
ref_commit: d957887 (cleanup) · validated live staging same session
ref_request: _COMMUNICATION/team_100/FINDINGS-CLEANUP_WP-W2-15-CR-FINAL_2026-06-05.md
prior_verdict: _COMMUNICATION/team_190/VERDICT_WP-W2-15-CR-FINAL_FULL-SITE-VALIDATE_v1.md
staging: http://eyalamit-co-il-2026.s887.upress.link
delivery: file-based (ADR043 §4)
---

# team_190 — ממוקד re-confirm אחרי findings cleanup

## סיכום למנהל (team_100)

| ממצא | סטטוס re-confirm | הערה |
|------|------------------|------|
| **F-CRF-02** `/muzeh/` 2-hop | **סגור ✓** | `301` ישיר → `/books/` (ללא `/muzza/` ביניים) |
| **F-CRF-03** legacy book URLs | **סגור ✓** | 6 נתיבי legacy → **301 יחיד** → `/books/<slug>`; canonical **200** |
| **F-E2E-05** `/muzza/` | **סגור ✓** | `301` → `/books/` |
| **F-CRF-04** kushi + vekatavta sentence | **סגור ✓** | `content-diff` חי: **100%** sentence על שני העמודים |
| **F-CRF-01** chrome ללא `/muzza` | **כמעט סגור — שארית אחת** | chrome קנוני EA **נקי**; תפריט GP ישן עדיין מפיץ 3× `href=/muzza/…` (ראו §2) |
| Gate-tool (`>` blockquote skip) | **RATIFY** | הרחבת scaffolding קיים; לא מוריד bar (§4) |

**שורה תחתונה:** Redirect + coverage + chrome הקנוני — **מאושרים**. שדרוג leg 2 ל-**PASS נקי על פריטי ה-redirect/coverage** — **כן**, עם **INFO יחיד** על תפריט GP (לא חוסם, לא 404).

תוכן: **16/16 gatePass** · **96.74%** simple / **98.39%** weighted — **מאושר** (team_190 live re-run).

---

## §1 Redirect chain — עדות

```
/muzeh/                              → 301 → /books/
/muzza/                               → 301 → /books/
/muzeh/kushi-blantis/                 → 301 → /books/kushi-blantis/
/muzza/kushi-blantis/                 → 301 → /books/kushi-blantis/
/muzeh/vekatavt/                      → 301 → /books/vekatavta/
/muzza/vekatavt/                      → 301 → /books/vekatavta/
/muzza/tsva-bechol-ve-zorek-layam/    → 301 → /books/tsva-bekahol/
/muzeh/tsva-bechol-ve-zorek-layam/   → 301 → /books/tsva-bekahol/
```

כל הנתיבים הקנוניים `/books/*` — **200** אחרי `-L`.

---

## §2 F-CRF-01 — chrome (פירוט)

| שכבה | `/muzza` או `/muzeh` ב-href | מצב |
|------|------------------------------|-----|
| `.ea-topnav` (desktop canonical) | **0** | מוזה → `/books` בלבד |
| `.ea-mnav` (mobile drawer) | **0** | נקי |
| `.ea-cfoot` / `block-footer-social` | **0** | נקי |
| **GP `#primary-menu`** (`menu-item-139`…`142`) | **3** | עדיין: `/muzza/`, `/muzza/tsva-bechol-ve-zorek-layam/`, `/muzza/vekatavt/` |

הקישורים **לא מתים** (301→`/books*`), אבל טענת «0 `/muzza` בכל ה-chrome המרונדר» **לא מדויקת** כל עוד תפריט ה-WP הישן של GeneratePress נשאר ב-DOM.

**פעולה מוצעת ל-team_100 (P3, לא חוסם CR-FINAL):** סנכרון/הסתרת `#primary-menu` או עדכון פריטי התפריט ב-WP ל-`/books` + `/books/<slug>` — אותה IA שכבר ב-`block-topnav.php`.

---

## §3 Content-diff אחרי cleanup

| עמוד | sentence% | gate |
|------|-----------|------|
| `/books/kushi-blantis/` | **100%** | PASS |
| `/books/vekatavta/` | **100%** | PASS |
| `/books/tsva-bekahol/` | 96.67% | PASS (residual מכוון — כרטיסי רכישה) |
| `/stands-storage/` | 92.86% | PASS (Eyal `/contact` slug) |
| **סיכום in-scope** | **16/16** | 96.74% / 98.39% |

---

## §4 Gate-tool — שינוי `d957887`

`content-diff.mjs`: דילוג על **כל** שורת `>` (לא רק `DEV NOTE` / URL) — מיישר kushi gallery scaffolding.

**team_190:** **RATIFY** — המשך קו ה-dev-scaffolding exclusion; testimonials בקורפוס לא משתמשים ב-`>`; לא משנה סף gate.

---

## §5 Routing ל-team_100

1. **מאושר:** סגירת F-CRF-02, F-CRF-03, F-CRF-04 (חלק fixable), F-E2E-05 — **נקי**.
2. **שארית:** F-CRF-01 — **INFO** GP menu בלבד; EA chrome **נקי**.
3. **Triple-PASS:** 0 blocking בכל 3 הרגליים; שארית GP **לא מחזירה** ל-PASS_WITH_FINDINGS על redirect/coverage.
4. **אופציונלי לפני Eyal:** תיקון תפריט GP (§2) + מסמך סיכום triple-PASS ל-team_00.

---

**Signed:** team_190 · Cursor Composer · 2026-06-05 · focused re-confirm post `d957887`
