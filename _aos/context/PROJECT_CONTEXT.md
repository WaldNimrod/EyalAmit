# PROJECT_CONTEXT.md — EyalAmit.co.il 2026

**Read this file at every session start.** It is the minimal context needed before reading activation files.

---

## What This Project Is

A full WordPress 2026 refresh of **eyalamit.co.il** — the personal-professional site of **Eyal Amit**,
musician, sound healer, and author (Muse publisher). Hosted on **uPress** (Israeli WordPress hosting).

**Stack:** WordPress 6.9.4 + GeneratePress parent + `ea-eyalamit` child theme + ACF fields.
**Staging:** `http://eyalamit-co-il-2026.s887.upress.link` (FTP credentials in `local/.env.upress`)
**Repo:** `https://github.com/WaldNimrod/EyalAmit`

---

## AOS Status

| Field | Value |
|-------|-------|
| Profile | L0 (governance-only, no engine) |
| Active milestone | S001 — AOS Canonization |
| Lean-kit version | 3.1.3+3e4164e |
| Canonized | 2026-04-11 |

---

## Pre-AOS History (completed)

| Phase | Period | Summary |
|-------|--------|---------|
| M2 | 2026-03-29 – 04-04 | uPress infra, Docker local, WP seed, FTP |
| M3 | 2026-04-04 – 04-10 | Content packages (books, treatment, method), Hub v1, QA |
| M4 | 2026-04-10 – 04-11 | Hub v2 (purchase-links, content-index, workflow button), books v2 push |

---

## Key Paths

| Path | Purpose |
|------|---------|
| `_aos/roadmap.yaml` | WP state registry — read this first |
| `_aos/governance/` | Team contracts |
| `_aos/context/ACTIVATION_*.md` | Per-role activation prompts |
| `_aos/work_packages/` | LOD specs |
| `hub/data/content-index.json` | Content received from Eyal |
| `hub/data/site-tree.json` | IA — page hierarchy |
| `hub/data/roadmap.json` | Project phases + task tracking (legacy, pre-AOS) |
| `docs/PROJECT-ENTRY.md` | Full project entry for new team members |
| `docs/sop/SSOT.md` | Single source of truth (legacy governance) |
| `_COMMUNICATION/README.md` | Team communication index |
| `scripts/intake_new_content.py` | Content intake trigger script |

---

## Team Model (this project)

| Slot | ID | Engine | Role |
|------|----|--------|------|
| Team 00 | eyalamit_sd | human | Nimrod Wald — system designer, final authority |
| Team 100 | eyalamit_arch | claude-code | Architecture, specs, roadmap |
| Team 110 | eyalamit_build | cursor-composer | WordPress + scripts implementation |
| Team 190 | eyalamit_val | openai | Constitutional validator (L-GATE_V) |

---

## Client

**Eyal Amit** — contact via WhatsApp only: `972-524822842`
- Content delivery: Google Drive (auto-sync)
- All output to client: Word (.docx) or PDF — never Markdown

---

## Validation

```bash
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
```

Run before any L-GATE_B declaration.

---

## New Team Member Onboarding Order

1. Read this file (PROJECT_CONTEXT.md)
2. Read your activation file (`ACTIVATION_ARCH.md` / `ACTIVATION_BUILDER.md` / `ACTIVATION_VALIDATOR.md`)
3. Read `_aos/roadmap.yaml` — find active WPs
4. Read `_aos/work_packages/S001/S001-P001-WP00X/LOD400_spec.md` for your assigned WP
5. Confirm with Team 00 (Nimrod) before starting
