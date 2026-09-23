# S007 derivation control audit — 2026-09-21

## Verdict

FAIL — renderer derivation PASS, but one SSOT-content consistency defect remains around `/services/` E3 versus A1.

No renderer bug was found. No FTP was run. No SSOT edit was made. `scripts/s007_render_work_ssot.py` was not patched.

## Scope

- SSOT: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`
- Renderer: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/s007_render_work_ssot.py`
- SSOT helper: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/s007_work_ssot.py`
- Derived form: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`
- Derived board: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html`
- Hub copy: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/hub/dist/s007-content-gaps.html`
- Live form: `http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/s007-content-gaps.html`

## Renderer re-derivation

Method: imported `render_form()` and `render_board()` from `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/s007_render_work_ssot.py`, loaded the SSOT via `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/s007_work_ssot.py`, and rendered to `/var/folders/by/1t6ry0bj14dfqjz3bk86v_pw0000gn/T/s007-derivation-audit-5efgyoxs/` using the current derived `generatedAt` stamp to avoid timestamp-only churn.

- SSOT sha12: `c4779ffde949`
- Existing generated stamp used for byte comparison: `2026-09-21T18:09Z`
- Form byte diff: PASS, no diff.
- Board byte diff: PASS, no diff.
- Hub copy equals current form: PASS.
- Hub copy equals temp-rendered form: PASS.

Relevant git status after the audit still shows these pre-existing tracked changes versus HEAD:

- `M /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/FORM-EYAL-CONTENT-GAPS-2026-09-20.html`
- `M /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html`
- `M /Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/s007_render_work_ssot.py`

The temp derivation matches the current working-tree content, so the current FORM/GALLERY are derived from the current SSOT and renderer despite being dirty versus HEAD.

## Assertion checks

1. Locked SSOT rules present: PASS. The `rules` object includes `rulingWritesSsot`, `eyalFormAndBoardAreDerived`, and `derivedHtmlMustNotBeHandEdited`.

2. No invented item status text in FORM/GALLERY: PASS for item-level status stamps. Every rendered `.st` / `.tag` status chip text is present in an item `stampHe` in `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`. The form’s aggregate table headers such as `ממתין לך` are renderer chrome, not per-item invented status.

3. N1 in form under `חלק ט`: PASS. `data-id="N1"` is present, section title `חלק ט · כותרת מובייל` is present, and SSOT N1 is `status=waiting`, `waitingOn=eyal`. The recommendation reasoning is sourced from N1 `summaryHe`, `form.now`, and `form.need`.

4. `questions[]` empty: PASS. SSOT `questions` is `[]`, and the board does not list `Q-DA-NAV-BRIEF` as an open question.

5. Wait tables: PASS for requested rows. The form `ממתין לך` table includes `N1`, `C1`, `C3`, `Q-HERO-ASK`, and `A5`; it does not include closed `A1`. SSOT also includes additional waiting/Eyal items `A3`, `B2`, `B3`, and `DA-NAV-01`.

6. Slim P/Q behavior: PASS. There are 102 slim P/Q items, and none render as full form cards. They render as slim rows plus summary lines rather than flooding Eyal’s form.

7. E3 closed stamp vs A1: FAIL, SSOT defect, not renderer defect. The form does not literally say `/services/` is live 200, but E3 still contains stale `/services/` state relative to A1:
   - A1 says `/services/` is closed and live check is `2026-09-21 GET 404 no Location`.
   - E3 says live check is `2026-09-21 canonical nav has no /services/; GET /services/ still 200 until unpublish`.
   - E3 `form.now` says the page is empty and not in menu; E3 `form.need` still asks whether it should enter the menu when it has content.
   - Independent no-follow GET with browser UA to `http://eyalamit-co-il-2026.s887.upress.link/services/` returned `404` with no `Location`.

   This is stale SSOT wording/data faithfully rendered by the script. It should be fixed in `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/S007-WORK-SSOT.json`, not in `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/s007_render_work_ssot.py`.

8. Live Hub form GET: PASS. GET with browser UA returned HTTP `200`.
   - Live page content sha12: `cd8c9d59b44c`
   - Embedded `ssotSha12`: `c4779ffde949`
   - Expected/current SSOT sha12: `c4779ffde949`
   - `data-id="N1"` present: yes
   - `חלק ט` present: yes

## Mismatch list

1. SSOT-content defect: E3 stale `/services/` live/check/form wording conflicts with A1 and current live no-follow HTTP result. Renderer is behaving correctly by deriving the stale E3 fields.

No renderer mismatch found.
