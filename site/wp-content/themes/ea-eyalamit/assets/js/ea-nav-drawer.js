/* =============================================================
   ea-nav-drawer.js — the ONE mobile nav drawer's behaviour. S007 M-12.

   The drawer itself is a native <dialog> opened with showModal(): focus
   trap, Escape-to-close, background inertness and focus-return to the
   opener are the browser's job and are NOT reimplemented here (see
   _COMMUNICATION/team_00/DECISION-S007-MOBILE-NAV-MECHANISM-2026-09-19.md).
   This file only wires: any trigger carrying [data-ea-nav-trigger] opens
   the shared #ea-nav-drawer; accordion submenus (CSS animates 0fr->1fr);
   tapping a real link closes the drawer before navigating; a sound pill
   toggles aria-pressed; resize back to desktop force-closes it; and a
   body flag is set while open so the existing WhatsApp-float hide rule
   (style.css, keyed off body.nav-locked) keeps working unchanged.
   ============================================================= */
(function () {
  "use strict";

  var doc = document;
  var dialog = doc.getElementById("ea-nav-drawer");
  if (!dialog || typeof dialog.showModal !== "function") return; // no native <dialog> support: nothing to wire

  var triggers = Array.prototype.slice.call(doc.querySelectorAll("[data-ea-nav-trigger]"));
  if (!triggers.length) return;

  function open() {
    if (dialog.open) return;
    dialog.showModal();
    doc.body.classList.add("nav-locked");
    triggers.forEach(function (t) { t.setAttribute("aria-expanded", "true"); });
  }
  function close() {
    if (!dialog.open) return;
    dialog.close();
  }
  dialog.addEventListener("close", function () {
    doc.body.classList.remove("nav-locked");
    triggers.forEach(function (t) { t.setAttribute("aria-expanded", "false"); });
  });

  triggers.forEach(function (t) {
    t.setAttribute("aria-expanded", "false");
    t.setAttribute("aria-controls", "ea-nav-drawer");
    t.addEventListener("click", function () { dialog.open ? close() : open(); });
  });

  var closeBtn = dialog.querySelector(".ea-nd__close");
  if (closeBtn) closeBtn.addEventListener("click", close);

  /* true backdrop click == the dialog element itself, not a child */
  dialog.addEventListener("click", function (e) {
    if (e.target === dialog) close();
  });

  /* accordion submenus */
  Array.prototype.forEach.call(dialog.querySelectorAll(".ea-nd__acc-btn"), function (btn) {
    btn.addEventListener("click", function () {
      var isOpen = btn.getAttribute("aria-expanded") === "true";
      btn.setAttribute("aria-expanded", String(!isOpen));
    });
  });

  /* a real navigation tap closes the drawer, then the link navigates */
  dialog.addEventListener("click", function (e) {
    var a = e.target.closest && e.target.closest("a[href]");
    if (a && dialog.contains(a)) close();
  });

  /* sound pill: visual toggle only — see nav__tg on Chapters pages for the
     one place this is actually wired to a video's audio track */
  Array.prototype.forEach.call(dialog.querySelectorAll(".ea-nd__sound"), function (b) {
    b.addEventListener("click", function () {
      var on = b.getAttribute("aria-pressed") === "true";
      b.setAttribute("aria-pressed", String(!on));
      var lbl = b.querySelector("span:last-child");
      if (lbl) lbl.textContent = !on ? "משמיע" : "שמע";
    });
  });

  var mq = window.matchMedia("(min-width:1024px)");
  (mq.addEventListener ? mq.addEventListener.bind(mq, "change") : mq.addListener.bind(mq))(function () {
    if (mq.matches) close();
  });
})();
