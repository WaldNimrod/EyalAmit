/* =============================================================
   ea-mobile-nav.js — drives the server-rendered mobile drawer for ea-topnav
   team_35 design · WP-W2-14-A. No deps. Behaviour ONLY:
   - open/close the side-sheet drawer, morph the burger
   - inline-accordion submenus (toggles aria-expanded; CSS animates 0fr->1fr)
   - focus trap, Esc, scrim / outside-tap close, restore focus, resize auto-close
   - body scroll lock; dir-aware slide axis computed from (dir, side)
   - sound pills toggle (visual only until the audio asset arrives)

   PORT NOTE: the source mockup JS also built the nav/footer markup from a
   locked JS model and listened to a harness over postMessage. Both are dropped
   here — in WP the nav, drawer and footer are rendered server-side from the
   site-tree SSoT (block-topnav.php / block-footer-social.php). This file no
   longer creates any menu nodes; it only queries and drives them.
   ============================================================= */
(function () {
  "use strict";

  var doc = document;
  var html = doc.documentElement;
  var dir = (html.getAttribute("dir") || "rtl").toLowerCase();

  var topnav = doc.querySelector(".ea-topnav");
  var drawer = doc.getElementById("ea-mnav-drawer");
  var scrim = doc.querySelector(".ea-mnav-scrim");
  if (!topnav || !drawer || !scrim) return; // degrade to no-op if chrome absent

  var burger = topnav.querySelector(".ea-mnav-burger");
  var closeBtn = drawer.querySelector(".ea-mnav-close");
  var sounds = Array.prototype.slice.call(doc.querySelectorAll(".ea-mnav-sound"));
  var openLabel = burger ? burger.getAttribute("aria-label") : "";
  var closeLabel = (closeBtn && closeBtn.getAttribute("aria-label")) || openLabel;

  /* ---- slide axis : physical sign from (dir, side) ---- */
  function applySide(side) {
    drawer.setAttribute("data-side", side);
    var physicalLeft = (side === "start" && dir === "ltr") || (side === "end" && dir === "rtl");
    html.style.setProperty("--ea-mnav-tx", physicalLeft ? "-100%" : "100%");
  }
  applySide(drawer.getAttribute("data-side") || "end"); // default: opens from the burger's side

  /* ---- open / close + focus trap ---- */
  var lastFocus = null;
  function focusables() {
    return Array.prototype.filter.call(
      drawer.querySelectorAll('a[href],button:not([disabled]),[tabindex]:not([tabindex="-1"])'),
      function (n) { return n.offsetParent !== null || n === doc.activeElement; }
    );
  }
  function isOpen() { return html.classList.contains("ea-mnav-open"); }

  function openDrawer() {
    if (isOpen()) return;
    lastFocus = doc.activeElement;
    html.classList.add("ea-mnav-open");
    if (burger) { burger.setAttribute("aria-expanded", "true"); burger.setAttribute("aria-label", closeLabel); }
    scrim.removeAttribute("aria-hidden");
    setTimeout(function () { if (closeBtn) closeBtn.focus(); }, 60);
    doc.addEventListener("keydown", onKey, true);
  }
  function closeDrawer() {
    if (!isOpen()) return;
    html.classList.remove("ea-mnav-open");
    if (burger) { burger.setAttribute("aria-expanded", "false"); burger.setAttribute("aria-label", openLabel); }
    scrim.setAttribute("aria-hidden", "true");
    doc.removeEventListener("keydown", onKey, true);
    if (lastFocus && lastFocus.focus) lastFocus.focus();
  }
  function onKey(e) {
    if (e.key === "Escape") { e.preventDefault(); closeDrawer(); return; }
    if (e.key === "Tab") {
      var f = focusables();
      if (!f.length) return;
      var first = f[0], last = f[f.length - 1];
      if (e.shiftKey && doc.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && doc.activeElement === last) { e.preventDefault(); first.focus(); }
    }
  }

  if (burger) burger.addEventListener("click", function () { isOpen() ? closeDrawer() : openDrawer(); });
  if (closeBtn) closeBtn.addEventListener("click", closeDrawer);
  scrim.addEventListener("click", closeDrawer);

  /* ---- inline-accordion submenus (toggle aria-expanded; CSS animates) ---- */
  Array.prototype.forEach.call(drawer.querySelectorAll(".ea-mnav-acc__btn"), function (btn) {
    btn.addEventListener("click", function () {
      var open = btn.getAttribute("aria-expanded") === "true";
      btn.setAttribute("aria-expanded", String(!open));
    });
  });

  /* ---- tapping a real navigation target closes the drawer ---- */
  drawer.addEventListener("click", function (e) {
    var a = e.target.closest && e.target.closest("a");
    if (!a) return;
    if (a.classList.contains("ea-mnav-sublink") ||
        a.classList.contains("ea-mnav-link") ||
        a.classList.contains("ea-mnav-drawer__brand") ||
        a.closest(".ea-mnav-foot__links")) {
      closeDrawer();
    }
  });

  /* ---- sound toggle (visual only — audio asset is a graceful Eyal-gap) ---- */
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

  /* ---- close if resized back to desktop ---- */
  var mq = window.matchMedia("(min-width:1024px)");
  (mq.addEventListener ? mq.addEventListener.bind(mq, "change") : mq.addListener.bind(mq))(function () {
    if (mq.matches) closeDrawer();
  });
})();
