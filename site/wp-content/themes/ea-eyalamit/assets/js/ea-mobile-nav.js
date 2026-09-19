/* =============================================================
   ea-mobile-nav.js — the Wave2 mobile bar's OWN remaining behaviour.
   team_35 design · WP-W2-14-A.

   S007 M-12 (2026-09-20): the drawer this file used to open (focus-trap,
   Escape, scrim, dir-aware slide, accordion — all hand-rolled) is gone.
   .ea-mnav-burger now carries data-ea-nav-trigger and ea-nav-drawer.js
   wires it to the one shared native <dialog>, which gets focus-trap/
   Escape/inertness from the browser for free. See
   _COMMUNICATION/team_00/DECISION-S007-MOBILE-NAV-MECHANISM-2026-09-19.md.

   What is left here is bar-only and unrelated to the drawer: the sound
   pill's visual toggle (no audio asset wired yet — a graceful Eyal-gap,
   same as before).
   ============================================================= */
(function () {
  "use strict";

  var topnav = document.querySelector(".ea-topnav");
  if (!topnav) return; // degrade to no-op if this page's chrome is absent

  var sounds = Array.prototype.slice.call(document.querySelectorAll(".ea-mnav-sound"));
  sounds.forEach(function (b) {
    b.addEventListener("click", function () {
      var on = b.getAttribute("aria-pressed") === "true";
      sounds.forEach(function (x) {
        x.setAttribute("aria-pressed", String(!on));
        var lbl = x.querySelector("span:last-child");
        if (lbl) lbl.textContent = !on ? "משמיע" : "שמע";
      });
    });
  });
})();
