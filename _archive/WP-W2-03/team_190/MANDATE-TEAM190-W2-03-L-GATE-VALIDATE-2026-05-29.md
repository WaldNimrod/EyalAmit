---
id: MANDATE-TEAM190-W2-03-L-GATE-VALIDATE-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
wp: WP-W2-03 — Muzza Publishing catalog + 3 book-detail pages
date: 2026-05-29
gate: L-GATE_VALIDATE
build_commit: 528fa3d
branch: feature/w2-03-books
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-03
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# L-GATE_VALIDATE Mandate — WP-W2-03 (Books)

## §0 — Engine constraint (IR#1)
team_190 MUST run on **native Codex / OpenAI / GPT-5** (≠ claude builder team_10, ≠ team_50 QA). Confirm engine in line 1 of your verdict.

## §0.1 — Worktree (isolation)
W2-03 is in a **dedicated worktree**: `/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-03` (branch `feature/w2-03-books`). The shared `EyalAmit.co.il-2026` tree is on `main` — do NOT validate there.

## §1 — Prior gate state
- **L-GATE_BUILD: PASS_WITH_FINDINGS** (team_50, non-Claude) — **6/6 ACs PASS**, no P0/P1.
  - Verdict: `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-03-L-GATE-BUILD-2026-05-29.md`
  - P3 findings: F-W2-03-01 (3× raw `#fff` D-14 drift) — **REMEDIATED** in commit `528fa3d` (new `--ea-on-dark` token; verify no raw hex remains in W2-03 CSS). F-W2-03-02 (unused `purchase_url` keys — intentional contact fallback). F-W2-03-03 (source spelling preserved verbatim — informational). F-W2-03-04 (gallery/press/cover placeholders — expected until Eyal supplies assets).
- **L-GATE_SPEC:** PASS_WITH_FINDINGS (team_190 Codex v2, 2026-05-28; corrections applied).

## §2 — Proof-of-HEAD (require before validating — W2-02/W2-06 both produced stale verdicts first)
- `git -C "/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-03" rev-parse HEAD` → **`528fa3d`** (tip).
- Build lineage: `2e3f23c` (catalog + 3 detail pages) → `22d6109` (`/books`→`/muzza` 301 hijack removed) → `528fa3d` (F-W2-03-01 hex fix).
- Deployed theme `style.css` Version = **1.4.2**; deployed `ea-tokens.css` contains `--ea-on-dark: #FFFFFF`.
- **CACHE-BUST every HTTP check:** append `?cb=$(date +%s)$RANDOM`.

## §3 — Scope
Validate against LOD400 spec `_aos/work_packages/S002/WP-W2-03/LOD400_spec.md` (AC-01..AC-06). Apply your 8-check validation + LOD400 precision gate. Independently re-verify live (cache-busted):
- AC-01: 4 URLs → 200, no redirect: `/books`, `/books/vekatavta`, `/books/kushi-blantis`, `/books/tsva-bekahol`.
- AC-02: catalog renders the 12-block contract; each book renders the 14-block contract (תקציר · קטע · על הספר · gallery · purchase · למי מתאים · FAQ מסונן · press · closing CTA).
- AC-03: purchase opens Green Invoice in new tab + GA4 `book_purchase_click`(book_slug); **individual-book links absent → fallback `/contact?subject=book-<slug>` (same tab) + GA4** is the CORRECT state. Bundle link `https://mrng.to/MTUiO3vkIg` opens new tab.
- AC-04: `/books` shows 3 cards + inline bundle; each card links to its `/books/<slug>`.
- AC-05: H1 + body copy match the 25.5.26 sources 1:1 (MUZZA.md, vekatavta.md, kushi_full.md, eyal_tsva_FINAL.md). Source spelling preserved verbatim per spec — flag, do not block.
- AC-06: `validate_aos.sh` → 0 FAIL; mobile responsive (3-up desktop / stacked mobile); body class `ea-wave2-shell`.

## §4 — Known non-blocking (do NOT block)
Individual Green Invoice links + book cover images are Eyal-dependent (contact-fallback + grey placeholder are spec-sanctioned). Legacy `/muzza` page tree coexists — explicitly out of W2-03 scope (slated for a separate IA-cleanup WP).

## §5 — Deliverable
Verdict → `_COMMUNICATION/team_190/VERDICT-WP-W2-03-L-GATE-VALIDATE-2026-05-29.md` (PASS / BLOCKED), with Verdict Box + Fresh-tree Proof (HEAD `528fa3d`) + 8-check table.
- On **PASS** → team_100 executes WP Closure Protocol (roadmap COMPLETE / LOD500_LOCKED via API; team_191 archive; merge `feature/w2-03-books` → main), then re-hands-off to WP-W2-04.
- On **BLOCKED** → team_100 routes remediation to team_10.

*team_100 — 2026-05-29*
