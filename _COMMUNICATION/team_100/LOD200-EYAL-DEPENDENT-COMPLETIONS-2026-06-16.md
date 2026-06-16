# LOD200 — Eyal-Dependent Completions (materials + decisions pending)

**WP (proposed):** `S004-P001-WP004` (milestone S004 *Launch Readiness*) · **Author:** team_100
**Date:** 2026-06-16 · **lod_status:** LOD200 · **Track:** A (Standard) · **Profile:** L0 · **Priority:** MEDIUM
**status: BLOCKED** (`blocked_by:` Eyal materials/decisions)

## 1. Problem statement (LOD100 confirmed)
Everything advanceable **without** Eyal is built. A bounded set of completions remain blocked on materials or
confirmations only **Eyal** can supply. They are real, small, and well-scoped — but cannot proceed until delivered.
Registering them as one tracked, canonical, BLOCKED work package makes the launch-blocking "what we still need from Eyal"
explicit, mapped to the live surfaces, and ready to integrate per-item on arrival. The client-facing list already lives
in the hub (`materials-intake`, items I1–I6 + confirmations); this WP is its engineering counterpart.

## 2. Solution concept
One BLOCKED WP whose items each carry: what's needed, the target page/feature, the hub material-code, and the integration
+ validation step. Items unblock independently as Eyal delivers; each then routes through normal build → dual-PASS.

## 3. Major components (the pending item set)
- **Mokesh memorial** (page `/eyal-amit/mokesh-dahiman/`): **bio intro** (hub I3), **birth/death dates** confirm `1950–2020` (I4), **3 memorial photos** (I5), **brand spelling** `jungel vibes`→`Jungle Vibes` confirm (I6), and **Eyal's final edit** of the verbatim page.
- **Testimonials** (carousel): **more curated testimonials** — quote + name, ≥5–10 (hub I1, D-EYAL-TESTIMONIALS-14 "more later").
- **Analytics**: **GA4 measurement ID + Microsoft Clarity project ID** (currently `__PENDING_EYAL__` in `hub/data/analytics-config.json`) — also needed by the geo/SEO WP.
- **Contact/NAP**: confirm **WhatsApp** `+972 52-482-2842`, the **studio address/hours** in פרדס חנה (needed for `LocalBusiness` schema + contact).
- **Nav placeholder**: the **external "קורסים" (courses) URL** — currently `#` placeholder in the top-nav, pending Eyal/team_00.
- **Re-check confirmation** (hub I2): Eyal confirms the already-closed feedback items (#1/#4/#5/#7/#9) after cache refresh.

## 4. Primary flow (happy path)
Eyal delivers item → team_100 maps to target surface → builder integrates (verbatim/asset) → content-diff / overflow /
axe re-verify → item closed; repeat until the set is empty → mokesh + analytics gate the production cutover.

## 5. Actors / systems
**Eyal** (source of all items) · team_00 (relay, sends the drafted hub update) · team_100 (mapping) · builder (integrate) · team_50 + team_190 (validate) · the hub `materials-intake` (client-facing tracker).

## 6. Open decisions (explicit)
- **D-EYDEP-1 — Launch-blocking subset:** which items block the production cutover (proposed: analytics IDs + NAP + mokesh final edit) vs which can land post-launch (more testimonials, extra photos)? *(team_00)*
- **D-EYDEP-2 — Structure:** keep as one bundled WP, or split the launch-blockers into their own WP from the nice-to-haves? *(team_00)*
- **D-EYDEP-3 — Courses URL:** is the external courses link Eyal-sourced, or a team_00 decision (keep hidden vs placeholder)?

## 7. Dependencies & constraints
Entirely gated on **Eyal deliverables** (the WP's defining constraint). Constraint: content remains verbatim; assets
subject to Eyal's approval + content sensitivity (memorial photos especially).

## 8. Initial success criteria (directional)
Every item has a clear target + integration path; the hub list (I1–I6 + confirmations) stays current; on delivery each
integrates verbatim/with-asset and re-passes its gate; the **launch-blocking subset** (analytics, NAP, mokesh final) is
closed before production cutover; Eyal's mokesh final edit is applied + re-validated.

## 9. Out of scope
Any work advanceable without Eyal (other S004 WPs); content rewriting; chasing/relationship management (team_00 owns Eyal comms).

## 10. Risk classification
**Low (engineering) / timeline-dependent.** Each item is small and well-understood; the only real risk is schedule —
the launch date is a function of Eyal's responsiveness. Mokesh photos carry a content-sensitivity flag.

## 11. Track declaration
**Track A (Standard).** Items are concrete integrations; LOD400 will enumerate each item's acceptance criteria + the
per-item target/asset spec. Stays `BLOCKED` until the first item arrives, then advances per-item.
