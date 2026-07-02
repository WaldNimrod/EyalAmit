---
id: EN-REFRESH-DRAFT-WP-W2-17-2026-07-03
title: "/en/ single-page refresh — DRAFT copy (Mukesh lineage + cbDIDG intro + contact CTA)"
date: 2026-07-03
prepared_by: team_110 (builder)
status: DRAFT — NOT APPROVED — NOT DEPLOYED
work_package: WP-W2-17, Task T9
decision_ref: _COMMUNICATION/team_100/DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md — D13 (t00)
spec_ref: _COMMUNICATION/team_100/WP-W2-17-CRFINAL-SEO-REMEDIATION-PROGRAM-2026-07-03.md — T9 / AC-009
hard_gate: "Nothing in this file is published to /en/ until Eyal approves the copy. This is copy-only; no template, theme, or live-page file was touched to produce it."
sources_adapted_from:
  - site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/mokesh-defaults.php (live Hebrew Mukesh Dahiman memorial narrative — substance basis for the lineage paragraph, English-adapted, no invented facts)
  - site/wp-content/themes/ea-eyalamit/inc/wave2-w2-04-content.php (live Hebrew /method/ page — cbDIDG intro, 3-principle framing, origin-with-Mukesh paragraph — substance basis for the method section)
  - site/wp-content/themes/ea-eyalamit/inc/wave2-w2-08.php + page-templates/tpl-en-landing.php (current LIVE /en/ page — the actually-deployed 8-block EN composition; this draft is a refresh of that page, not a replacement of it)
  - NAP: EA_WAVE2_WHATSAPP_E164 = 972524822842 (site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php:14); tel:+972524822842 / "052-4822842" (page-templates/tpl-chapters-en.php:95, tpl-contact.php:139)
---

# /en/ single-page refresh — DRAFT

**Status: DRAFT ONLY. Not published. Not wired into any template. Awaiting Eyal's review and approval per D13.**

This is a copy draft for the two sections D13 authorizes adding depth to — the Mukesh Dahiman lineage and the cbDIDG method — plus a refreshed closing contact CTA, written to slot into the existing live `/en/` page (which already has Hero → About → Method → Services → Books → Testimonials → Contact blocks; see `wave2-w2-08.php`). Nothing here removes or contradicts what's already live; it deepens two sections that are currently thin (the current live Method block only gives Mukesh Dahiman a single sentence, and there is no lineage/heritage section at all on `/en/` today — that content exists only on the Hebrew `/eyal-amit/mokesh-dahiman/` memorial page, which has no English counterpart).

Voice notes: written directly in English for an international/diaspora reader (not machine-translated from Hebrew), matching the register already live on `/en/` (short declarative sentences, second person for the CTA, restrained tone for the memorial material). No new biographical facts, dates, or claims are introduced beyond what the Hebrew source pages already state.

---

## A. New section — "The Lineage" (Mukesh Dahiman)

*Suggested placement: a new block between the existing "About" (Block 3) and "The Method" (Block 4) sections of `wave2-w2-08.php`, or as a standalone anchor `#lineage`. Adapts the substance of the full Hebrew memorial page (`mokesh-defaults.php`) into a short-form English passage — it is explicitly NOT a full translation of that page (the memorial is long-form and emotionally detailed; an English reader arriving from `/en/` needs the throughline, not the full eulogy). A "read the full story" link can point to the Hebrew memorial page for now, or to a future English memorial page if Eyal wants one built later (out of scope for this draft).*

> ### The Lineage
>
> Eyal's approach to the didgeridoo carries the influence of one teacher in particular: **Mukesh Dahiman**, a craftsman, didgeridoo-maker, and teacher from Rishikesh, India, who spent decades building instruments by hand on the banks of the Ganges and teaching thousands of travelers from around the world how to breathe, build, and listen through the instrument.
>
> Eyal met Mukesh in 2000 and studied with him over the following years, becoming one of his close students. What Eyal carries forward isn't a formal technique so much as a way of working — patient, hands-on, and rooted in listening to the breath rather than performing with it. Mukesh passed away in October 2020; his workshop and his teaching live on through the students who continue his approach, Eyal among them.
>
> *[Full memorial page in Hebrew: /eyal-amit/mokesh-dahiman/ — link only if Eyal confirms it's appropriate to surface to English visitors as-is.]*

**YMYL/accuracy guardrails applied:** no invented biographical detail (craft, location, meeting year, "close student" status, and date of passing are all stated plainly on the live Hebrew page); no claim that Mukesh trained or endorsed a "method" by name (the Hebrew source doesn't make that claim either — `cbDIDG` is presented elsewhere as Eyal's own later synthesis, inspired by the apprenticeship, not authored or certified by Mukesh); nothing here frames Mukesh or the lineage as a credential, license, or medical qualification.

---

## B. Refreshed "The Method" section (cbDIDG intro)

*Suggested placement: replaces/extends the existing Block 4 ("The Method") copy in `wave2-w2-08.php`, which currently gives the method in one paragraph plus a 3-bullet list. This draft keeps that same 3-principle structure (faithful to the Hebrew `/method/` page's "three principles" framing) but writes the intro paragraph with a bit more of the origin context that `/method/`'s Hebrew "how the method was born" section carries, condensed for a landing page.*

> ### The Method — cbDIDG
>
> **cbDIDG** is a structured way of working with the breath through the didgeridoo, guided one-on-one. The instrument itself isn't the point — it's the tool that makes your everyday breathing visible and workable: something you can strengthen, steady, and bring back under your own control.
>
> The method took shape gradually, over years of practice with hundreds of students, and draws on three things: Eyal's own long study of breath and circular breathing (originally motivated by his own experience with severe asthma), an ongoing apprenticeship with the didgeridoo master Mukesh Dahiman that began in 2000, and later study of related body-breath disciplines including tai chi, qigong, yoga, and mindfulness.
>
> **Three principles shape the work:**
>
> - **Active, not passive.** Unlike a sound-healing session, where you rest and receive, here you actively build control over your own breath — through playing and consistent practice.
> - **Playing is the practice tool, not the goal.** The circular-breathing technique used while playing the didgeridoo is distinct from everyday breathing. The aim is a lasting change in how you breathe day to day — and while you sleep.
> - **A process, not a single session.** This is gradual, cumulative work built on repetition and depth, not a one-time experience.
>
> *(Wellness framing, not medical treatment — see guardrail note below.)*

**YMYL/accuracy guardrails applied:**
- No cure/treatment/diagnosis language. "cbDIDG" is presented as a *practice method* / *wellness approach* for working with breathing, never as a medical treatment, therapy in the clinical sense, or substitute for medical care.
- The Hebrew `/method/` FAQ does reference a real Swiss BMJ study on didgeridoo playing and sleep-apnea/snoring symptoms, but frames it carefully ("may reduce symptoms," "no uniform guarantee," "always via a sleep-lab diagnosis and physician's approval"). This draft does **not** import that clinical claim into the `/en/` refresh at all — it is safer to leave snoring/sleep-apnea claims off the international landing page entirely and let a visitor who wants that detail reach it via the (separately gated) `/method/` FAQ or a future dedicated EN methodology page, rather than repeating a medical-adjacent claim on a page with less surrounding context.
- No lineage-as-license framing (Mukesh is described as an influence and teacher, not a certifying body for cbDIDG).
- No superlative/absolute claims ("cures," "guaranteed," "heals") — kept to "may help you work with," "supports," "aims to."

---

## C. Refreshed contact / closing CTA

*Suggested placement: replaces the closing CTA text in Block 7 of `wave2-w2-08.php` (currently: "If you've read this far... Schedule an introductory call" + a single WhatsApp button). This draft keeps the WhatsApp-first pattern (already the ratified EN contact path per the team_00 2026-06-03 decision closing F-W2-10-F-01) and adds an explicit phone/WhatsApp number in text — useful for international visitors who may not immediately recognize a `wa.me` link as a phone contact, and for basic NAP consistency between `/en/` and the rest of the site.*

> ### Get in touch
>
> If something here speaks to you, the next step is a short conversation — not a commitment. An introductory call is the easiest way to find out whether this approach fits what you're looking for, and how a personal process would start.
>
> **WhatsApp / phone:** [+972-52-482-2842](https://wa.me/972524822842) *(tap to message on WhatsApp, or call/text directly — Israel time zone)*
>
> [Schedule an introductory call →] *(existing WhatsApp CTA button/link, unchanged: `https://wa.me/972524822842?text=...`)*

**NAP consistency check:** matches the number used site-wide — `EA_WAVE2_WHATSAPP_E164 = 972524822842` (`wave2-stage-b.php:14`) and the `tel:+972524822842` / "052-4822842" display format used on `/contact/` (`tpl-contact.php:139`) and the (unused) `tpl-chapters-en.php:95` footer. This draft renders the same number in international format `+972-52-482-2842` for an English/international reader, consistent with the E.164 value already in use.

---

## What this draft deliberately does NOT do

- Does not touch, rewrite, or restructure the existing Hero, About, Services, Books, or Testimonials blocks already live on `/en/` — those are out of scope for T9 and read fine as-is.
- Does not invent a full English translation of the Mukesh memorial page — that would be a much larger, separate content project (and D13 explicitly scopes this to a single-page refresh, not a new EN memorial page).
- Does not add any medical/diagnostic claim (snoring, sleep apnea, asthma-cure, or otherwise) to the `/en/` page.
- Does not modify `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-08.php`, `page-templates/tpl-en-landing.php`, `page-templates/tpl-chapters-en.php`, or any other live template/theme file. Nothing under `site/wp-content/` was edited to produce this draft.
- Does not publish to `/en/`. Publication is gated on Eyal's explicit approval per D13 and the T9 hard gate.

## Open questions for Eyal / team_100 before any build-out

1. Should "The Lineage" link out to the full Hebrew memorial page (`/eyal-amit/mokesh-dahiman/`) for English readers, or should it stay self-contained with no outbound link until/unless an English memorial page exists?
2. Is the level of biographical detail here (met in 2000, "close student," Mukesh's passing in 2020) the right amount for a landing-page reader, or should it be trimmed further/expanded?
3. OK to add the literal `+972-52-482-2842` phone/WhatsApp text next to the CTA button, or keep the button-only pattern that's currently live?
4. Placement preference: insert "The Lineage" as its own new block, or fold it into the existing "About" or "Method" blocks to avoid growing the page to 9 sections?
