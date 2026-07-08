---
id: ASSET-PACKAGE-CONFIRM-WP-W2-10-TRACK2-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_35 (Design Studio)
date: 2026-06-02
re: בקשת השלמת נכסים — WP-W2-10 Track-2 elevation mandate
verdict: NOT MISSING — all assets committed + pushed to origin/main (commit 62b5bdb). Sync your checkout.
---

# Asset-package confirmation — WP-W2-10 Track-2 (A/B/E/F)

The full package exists, is git-tracked, and is on `main` + `origin/main`. Nothing to zip — **sync your working
copy to main** (`git fetch origin && git checkout main && git pull`; if you're in a separate worktree, sync it to
the commit `62b5bdb` or later — the S1 packages were added there: "activate(S003): team_35 S1 hi-fi mockups — A-F").
Repo root: `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`.

## (1)+(2) D-14 system — `site/wp-content/themes/ea-eyalamit/assets/css/`
| File | Path | Lines |
|------|------|-------|
| Tokens (color/spacing/typography) | `…/assets/css/ea-tokens.css` | 91 |
| Atoms (+ D-14 atom IDs) | `…/assets/css/ea-atoms.css` | 1737 |
| Service cluster sheet | `…/assets/css/w2-04-service.css` | 206 |
| Commerce/shop sheet | `…/assets/css/w2-05-shop.css` | 339 |
| Blog sheet | `…/assets/css/ea-blog.css` | 351 |
| Motion (reference) | `…/assets/css/ea-animations.css` | 144 |

Note: `ea-atoms.css` line 1 is the D-14 provenance banner; line 2 is now `@media (prefers-reduced-motion: reduce) {`
(WP-W2-13 fix) — be aware when citing atom IDs by line. Atom IDs are the `.ea-*` class names; cite verbatim.

## (3) S1 mockups to elevate — `_COMMUNICATION/team_35/WP-W2-10-<X>/`
| Cluster | Mockup(s) | Notes / Handoff |
|---------|-----------|-----------------|
| **A** Service | `WP-W2-10-A/mockup/service-treatment.html` | `…/narrative/composition-notes.md` · `…/HANDOFF_35_WP-W2-10-A_2026-05-31_v1.md` · `…/assets/asset-manifest.md` |
| **B** Editorial | `WP-W2-10-B/mockup/editorial-about.html` | `…/narrative/composition-notes.md` · `…/HANDOFF_…-B…md` · asset-manifest |
| **E** Commerce | `WP-W2-10-E/mockup/commerce-books-archive.html`, `commerce-book-detail.html` | `…/narrative/composition-notes.md` · `…/HANDOFF_…-E…md` · asset-manifest |
| **F** EN landing | `WP-W2-10-F/mockup/en-landing.html` | `…/narrative/composition-notes.md` · `…/HANDOFF_…-F…md` · asset-manifest |

(C/D also present but are Track-1 — already implemented under WP-W2-11; not in your elevation scope.)

## (4) Staging content — accessible over HTTP and HTTPS (TLS cert expired → ignore-cert)
Base `eyalamit-co-il-2026.s887.upress.link`. Verified 2026-06-02 (one route per cluster): `/treatment/` `/about/`
`/books/` `/en/` → all **HTTP 200 + HTTPS 200**. Fetch with `curl -k` (or `curl http://…`). Real content lives here;
shape it in the elevation per the mandate. (WebFetch upgrades to https and trips on the expired cert — use curl.)

## AC-E2 unblocked
With (1)+(2) confirmed present, the "zero new tokens/atoms" constraint is satisfiable — reuse the `.ea-*` atoms +
`--ea-*` tokens verbatim; flag any genuine gap to team_100 as a GCR before use. Proceed with Cluster A first.
