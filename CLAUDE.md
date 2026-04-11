# CLAUDE.md — EyalAmit.co.il 2026

**AOS Profile:** L0 | **Lean-kit:** 3.1.3 | **Active milestone:** S001

---

## Mandatory Startup Sequence

Read these files at every session start, in order:

1. `_aos/roadmap.yaml` — active WPs and gate status
2. `_aos/context/PROJECT_CONTEXT.md` — project overview
3. `_aos/context/ACTIVATION_ARCH.md` — architecture agent role (this is your default role)
4. `hub/data/calendar-anchor.txt` — current date (last ISO line)

---

## Project Identity

| Field | Value |
|-------|-------|
| Project | Eyal Amit — EyalAmit.co.il 2026 |
| Client | Eyal Amit (musician, sound healer, author) |
| Stack | WordPress 6.9.4 + GeneratePress + `ea-eyalamit` child theme |
| Hosting | uPress (Israeli WP hosting) |
| Staging | `http://eyalamit-co-il-2026.s887.upress.link` |
| Repo | github.com/WaldNimrod/EyalAmit |
| AOS profile | L0 (governance-only, no engine) |

---

## Default Agent Role

You are **eyalamit_arch** — Architecture Agent (Team 100), engine: claude-code.

For implementation tasks (WordPress PHP, scripts): activate **eyalamit_build** (Team 110, Cursor).
For validation: activate **eyalamit_val** (Team 190, OpenAI).

---

## Team Model

| Slot | ID | Engine | Role |
|------|----|--------|------|
| Team 00 | eyalamit_sd | human | Nimrod — system designer, final authority |
| Team 100 | eyalamit_arch | claude-code | Architecture, specs, roadmap (default) |
| Team 110 | eyalamit_build | cursor-composer | WordPress + scripts implementation |
| Team 190 | eyalamit_val | openai | Constitutional validator (L-GATE_V) |

---

## Iron Rules (Project-Level)

1. **Cross-engine validation** — builder (cursor-composer) ≠ validator (openai). Constitutional.
2. **Physical lean-kit** — `_aos/lean-kit/` is always a physical copy, never a symlink.
3. **Repo-internal specs** — `spec_ref` paths in roadmap.yaml never leave this repo.
4. **Single-writer roadmap** — eyalamit_arch holds write authority on `_aos/roadmap.yaml`.
5. **L-GATE_V independence** — always eyalamit_val (openai), immutable, non-delegatable.
6. **Client output format** — all output to Eyal Amit: Word (.docx) or PDF. Never Markdown.
7. **Hub deploy mandatory** — after any `hub/data/*.json` change: run build + FTP publish.
8. **No user manual steps** — agents run scripts directly; no "please run X" instructions.
9. **Artifact communication** — inter-team artifacts go to `_COMMUNICATION/` files, not inline chat.

---

## Key Paths

| Path | Purpose |
|------|---------|
| `_aos/roadmap.yaml` | WP state registry (SSoT) |
| `_aos/governance/` | Team contracts |
| `_aos/context/` | Activation files |
| `_aos/work_packages/` | LOD specs |
| `_COMMUNICATION/` | AOS inter-team artifacts |
| `_communication/` | Legacy project team comms (unchanged) |
| `hub/data/` | JSON data for Hub system |
| `scripts/` | Build, deploy, intake scripts |
| `site/wp-content/themes/ea-eyalamit/` | Active WP child theme |
| `docs/PROJECT-ENTRY.md` | Full project entry for new team members |
| `docs/sop/SSOT.md` | Legacy single source of truth |

---

## Gate Model (Track A)

```
L-GATE_E  →  L-GATE_S  →  L-GATE_B  →  L-GATE_V
  (arch)        (arch)       (builder)    (validator)
```

Validation command (run before L-GATE_B):
```bash
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
```

---

## Client Contact

Eyal Amit — WhatsApp only: `972-524822842`
Content sync via Google Drive (auto). WhatsApp = notification only.
End of content intake: send brief WhatsApp (titles only, no technical details).

---

## Calendar

Always read `hub/data/calendar-anchor.txt` (last ISO line) for current date.
Run `python3 scripts/check_hub_calendar.py` to verify.
