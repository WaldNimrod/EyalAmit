# TASK 2 — Text-only content audit: Eyal's latest docs vs the live site

**By:** team_110 · **Date:** 2026-06-21 · **Base:** `http://eyalamit-co-il-2026.s887.upress.link` (theme 1.4.16)
**Method:** TEXT-ONLY (visible page text vs source docs; markup/SEO/schema ignored). Reuses the deterministic `scripts/qa/content-diff.mjs` engine (per-`<w:p>` docx extraction; geresh≡apostrophe + dash + Jungle-Vibes normalization; sentence = ≥40 Hebrew chars). Extended via `scripts/qa/content-audit.mjs` to cover the supplementary/earlier docs too.
**Evidence:** `_COMMUNICATION/team_110/evidence/mokesh-content-2026-06-21/` (primary) · `…/content-audit-2026-06-21/audit.json` (supplementary).

---

## Executive summary — biggest gaps, ranked

1. **48 Facebook testimonials are NOT on the site (≈220 sentences, 0% coverage).** `ממליצים מהפייסבוק.docx` (the full testimonials corpus) is not integrated — `/media/` shows only 6 mockup samples. This is the single largest body of Eyal-written text absent from the live site. It is a **known, intentional pending task (D-TESTIMONIALS = integrate all 48 + Eyal-review)**, not an accidental drop. → schedule the testimonials integration.
2. **Mokesh memorial — now CLOSED.** Was ~6% (the top gap in any prior audit); after the team_110 rebuild it is **100% / 100% / ACCURATE** (full verbatim, «Jungle Vibes»).
3. **Two trivial CTA-only mismatches** (cosmetic, not missing content): `/books/tsva-bekahol/` (2 sentences) and `/stands-storage/` (1) — purchase/contact lines the page renders as buttons/links rather than verbatim prose. Optional polish.
4. **No invented prose anywhere** — 0 invented sections across all 17 measured pages; nothing on the site lacks an Eyal source.

**Bottom line:** against Eyal's **latest canonical content (the 25.5.26 pack), the live site is ~99.6% faithful — all 17 measured pages ACCURATE, 0 invented.** The only substantive missing body of content is the testimonials (a separate, planned task).

---

## A. Primary content — the canonical 25.5.26 pack vs live (the authoritative comparison)

| Page | sec% | sent% | missing | invented | verdict |
|---|---|---|---|---|---|
| / | 100 | 100 | 0 | 0 | ACCURATE |
| /method/ | 100 | 100 | 0 | 0 | ACCURATE |
| /treatment/ | 100 | 100 | 0 | 0 | ACCURATE |
| /sound-healing/ | 100 | 100 | 0 | 0 | ACCURATE |
| /lessons/ | 100 | 100 | 0 | 0 | ACCURATE |
| /faq/ | 100 | 100 | 0 | 0 | ACCURATE |
| /muzza | 100 | 100 | 0 | 0 | ACCURATE |
| /eyal-amit | 100 | 100 | 0 | 0 | ACCURATE |
| /books/vekatavta/ | 100 | 100 | 0 | 0 | ACCURATE |
| /books/kushi-blantis/ | 100 | 100 | 0 | 0 | ACCURATE |
| /books/tsva-bekahol/ | 100 | 96.67 | 2 (CTA) | 0 | ACCURATE |
| /didgeridoos/ | 100 | 100 | 0 | 0 | ACCURATE |
| /bags/ | 100 | 100 | 0 | 0 | ACCURATE |
| /stands-storage/ | 100 | 92.86 | 1 (CTA) | 0 | ACCURATE |
| /stand-floor/ | 100 | 100 | 0 | 0 | ACCURATE |
| /repair/ | 100 | 100 | 0 | 0 | ACCURATE |
| **/eyal-amit/mokesh-dahiman** | **100** | **100** | **0** | **0** | **ACCURATE (rebuilt)** |
| /galleries/ | — | — | — | — | N/A (no Eyal source — mockup) |
| /media/ | — | — | — | — | N/A (no Eyal source — mockup) |

**Site accuracy: simple avg 99.63% · source-char-weighted 99.78% · pages <90%: 0 · gate-pass: 17/17.**

The 3 "missing" lines are CTA/link text the template renders as buttons (e.g. «… צרו קשר», «… לרכישת הספר הדיגיטלי במנדלי», «פונים דרך /contact …») — the content is present as interactive elements; only the verbatim-sentence match misses. Not content loss.

## B. Supplementary / earlier docs vs live

| Source doc (date) | vs page | verbatim sent% | reading |
|---|---|---|---|
| `ממליצים מהפייסבוק.docx` (testimonials) | /media | 0% (0/220) | **Real gap — not integrated** (D-TESTIMONIALS pending). |
| `sound_healing_canonical.docx` (12.4) | /sound-healing | 14% (2/14) | Superseded draft — rewritten into the May `sound_healing_final.md` (live at 100%). |
| `final_st-method…SINGLE.md` (10.4) | /method, /treatment | 0% (0/47) | Superseded draft — concepts (cbDIDG, circular breathing, Mukesh lineage) are on the live pages **reworded**, not verbatim. Rewritten into the May `method.md`/`treatment.md` (live at 100%). |

**Interpretation:** low verbatim overlap of the April docs reflects the **April→May revision**, not dropped content — the May 25.5.26 pack supersedes them and the site renders the May pack at ~100%. No unique April content was found that is absent from both the May pack and the site (other than the testimonials).

## C. Spec / reference docs (not page-prose — out of text-coverage scope)

`eyal_amit_dev_brief_GEO_AEO_SEO.md`, `seo-content from eyal 2-4.md`, `CONTENT 12.4.26/site_updates.docx`, `CANONICAL-CONTENT-SUBMISSION-FROM-EYAL.md` define titles, meta-descriptions, URL/IA structure and build instructions — not visible page prose. A text-coverage % against page bodies would be meaningless. These belong to the **SEO/GEO workstream (wave1b)**; they are not content-drop candidates and were reviewed qualitatively only.

## D. Recommended actions
1. **Integrate the 48 FB testimonials** (D-TESTIMONIALS) — the one substantive content gap; per-category to service pages + a curated home set, with Eyal-review options in the hub.
2. *(Optional polish)* render the 3 CTA lines on `/books/tsva-bekahol/` + `/stands-storage/` as text (or accept as buttons).
3. No action needed on the April drafts (superseded) or the spec docs (SEO/GEO scope).

## E. Method & caveats
- Verbatim substring match after normalization; a paraphrase reads as "missing" even when the meaning is present (see §B — April drafts). The audit measures **verbatim fidelity to the latest pack**, which is the right bar for "is the site what Eyal wrote."
- docx sentence extraction is per-`<w:p>` (avoids mid-word splits). Supplementary docs use flat (structure-agnostic) extraction so the comparison is valid regardless of doc shape.
- `/galleries/` `/media/` have no Eyal text source (mockup sample copy) → N/A.
