# M3 — אימות **G5–G7** בסטייג’ינג (צוות **10**)

**תאריך:** 2026-04-08  
**מנדט:** [`M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md`](./M3-G5G7-R1R4-EXECUTION-MANDATE-TEAM10-2026-04-08.md)  
**סביבה:** `https://eyalamit-co-il-2026.s887.upress.link` — לבדיקות HTTP מומלץ `curl -kL` (ראו [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)).

---

## מה שונה במאגר

| רכיב | קובץ |
|------|------|
| טיוטה לכפילי `page` + הורה קנוני | [`ea-m3-g5g7-q16-rest-dedupe-once.php`](../../site/wp-content/mu-plugins/ea-m3-g5g7-q16-rest-dedupe-once.php) |
| 301 `/lectures/`, `/workshops/` → תחת `learning` | [`ea-m2-site-tree-lock-sync-once.php`](../../site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) — `ea_m2_st_canonical_path_redirects` |

**איפוס ריצה (רק סטייג’ינג / בדיקה):** `delete_option('ea_m3_g5g7_q16_v1');`

---

## פקודות בדיקה (REST)

לכל slug — **מצופה מערך באורך 1** ב־`GET /wp-json/wp/v2/pages?slug=…&_fields=id,slug,parent,status`.

```bash
BASE='https://eyalamit-co-il-2026.s887.upress.link'
for s in lectures workshops sound-healing; do
  echo "=== $s ==="
  curl -ksS "${BASE}/wp-json/wp/v2/pages?slug=${s}&_fields=id,slug,parent,status" | head -c 2000
  echo
done
```

**פרשנות צפויה (אחרי ריצת MU):**

- `lectures`, `workshops`: `parent` = מזהה עמוד `learning` (מספר חיובי).
- `sound-healing`: `parent` = 0.

---

## פקודות בדיקה (301)

```bash
BASE='https://eyalamit-co-il-2026.s887.upress.link'
curl -ksSI "${BASE}/lectures/" | head -n 5
curl -ksSI "${BASE}/workshops/" | head -n 5
curl -ksSI "${BASE}/services/lectures/" | head -n 5
```

**מצופה:** `301` + `Location` לנתיב תחת `/learning/…` או קנוני מלא.

---

## פלט בפועל (2026-04-08)

**פריסה:** `python3 scripts/ftp_deploy_site_wp_content.py` — הועלו כולל `ea-m3-g5g7-q16-rest-dedupe-once.php`, `ea-m3-r2-featured-sample-once.php`, עדכון `ea-m2-site-tree-lock-sync-once.php`.

**REST (`wp/v2/pages`, `_fields=id,slug,parent,status`):**

- `lectures` → `[{"id":61,"slug":"lectures","status":"publish","parent":58}]` (מערך באורך 1)
- `workshops` → `[{"id":62,"slug":"workshops","status":"publish","parent":58}]`
- `sound-healing` → `[{"id":57,"slug":"sound-healing","status":"publish","parent":0}]`

**301 (כותרות תגובה):**

- `GET /lectures/` → `301` · `Location: …/learning/lectures/`
- `GET /workshops/` → `301` · `Location: …/learning/workshops/`

**R2 (דגימה):** `ea_gallery` — `ea-m3-seed-gallery-1` עם `featured_media: 121`, `ea-m3-seed-gallery-2` עם `featured_media: 122`; מטא מדיה `filesize` מקור ≈ **3553** בתים (מתחת ל־150KB); `alt_text` מלא בעברית (REST `wp/v2/media/121`, `122`).

---

*צוות 10 — ארטיפקט אימות G5–G7 / Q1-6*
