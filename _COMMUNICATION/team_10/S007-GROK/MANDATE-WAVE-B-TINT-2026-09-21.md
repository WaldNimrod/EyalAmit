# מנדט צוות 10 — גל ב סעיף 3 טינט · 2026-09-21

**מזמין:** מנהל מבצע.  
**מבצע:** צוות 10 — Composer.  
**מאמת:** המנוע הזה אחרי FTP.  
**אישור נימרוד (2026-09-21, אחה״צ):** «מאשר שינויי גוונים». זו הסקיצה המתוקנת (~10% terra על `--dark-grad`), **לא** מילוי `--terra-dk`.

סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link  
תמה חיה **1.5.98** → bump ל־**1.5.99** אחרי קריאת Version.  
FTP `python3 scripts/ftp_deploy_site_wp_content.py`. בלי `git add -A`, בלי `local/`, בלי `_aos/`. בלי `--fs-*`. בלי L1. בלי נוסח.

סקיצה: [SKETCH-GALLERY.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-GALLERY.html) `#s3` — השכבה:

```
linear-gradient(160deg, rgba(154,79,43,.10), rgba(154,79,43,.08)),
linear-gradient(160deg, #0B0703 0%, #1C1109 55%, #2A1A0C 82%, #0B0703 100%)
```

`--terra-dk` הוא `#9A4F2B` = `154,79,43`. לא ממציאים אחוז אחר.

---

## לעשות — קובץ אחד עיקרי

`site/wp-content/themes/ea-eyalamit/assets/css/chapters.css`

1. **לא** לשנות את ערכי `--dark` / `--dark-grad` / `--terra-dk`.
2. להוסיף שכבת טינט מעל הגרדיאנט הקיים ב:
   - `.cta-band`
   - `.sec--dark`
   - `.start` (היום `background:var(--dark)` — זהה לפוטר; לעבור לטינט+`--dark-grad`, לא להישאר `--dark`)
3. דרך מומלצת — טוקן מקומי ב־`:root` של chapters (לא ב־`ea-tokens.css`):

```css
--ea-dark-warm-wash: linear-gradient(160deg, rgba(154,79,43,.10), rgba(154,79,43,.08));
```

ואז `background-image: var(--ea-dark-warm-wash), var(--dark-grad);` על שלושת הסלקטורים. לא `background: var(--terra-dk)`.

## אסור לגעת

- `.foot` — נשאר `background:var(--dark)` = `#0E0905`, בלי שטיפה.
- `.phero` / גיבור עליון — בלי טינט נוסף.
- `.nav`
- `.ea-contact-foot-gap` (32px שנהב כבר אושר וחי)
- טוקני `--fs-*`
- מילוי טרה-קוטה שנדחה

## הצלחה

- `/repair/` `.cta-band`: computed background-image מכיל את שכבת `rgba(154, 79, 43` **וגם** את `--dark-grad`. לא `background-color` טרה אטום.
- `/` `.start`: לא אותו `background-color` כמו `.foot`.
- `/contact/` `.foot` עדיין `#0E0905` / `rgb(14, 9, 5)`. מרווח השנהב 32px נשאר.
- `/lessons/` `.phero` בלי שכבת הטינט.

## מסירה

`_COMMUNICATION/team_10/S007-GROK/WAVE-B-TINT-ASMADE-2026-09-21.md`: קבצים, 1.5.99, קומיט, שורת FTP.  
commit רק CSS + style.css Version + as-made + המנדט הזה.
