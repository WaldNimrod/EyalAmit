/* =============================================================
   ea-canonical-nav-gp-dropdown.js — keyboard access for the two
   href-less category buttons ("לימוד והכשרה", "אייל עמית") that
   inc/ea-canonical-nav.php's wp_nav_menu_items filter renders into
   GeneratePress's own header. S007 M-13 (2026-09-20).

   GeneratePress's own dropdown reveal only reacts to :hover — measured
   live, focusing the old href="#" link never showed its submenu, and a
   real Tab walk could not reach the submenu's own items at all. This
   sets the submenu's inline display style directly on activation, which
   wins the cascade regardless of what GP's own (unvendored) hover CSS
   actually does, and clears it back to '' on close so mouse/:hover
   behaviour is unaffected. Native <button> gets Enter/Space activation
   from the browser for free — no key handling needed here.
   ============================================================= */
(function () {
  "use strict";

  Array.prototype.forEach.call(document.querySelectorAll(".ea-gp-dd-toggle"), function (btn) {
    var li = btn.closest("li");
    var sub = li ? li.querySelector(":scope > .sub-menu") : null;
    if (!sub) return;

    function close() {
      btn.setAttribute("aria-expanded", "false");
      sub.style.display = "";
    }
    function open() {
      btn.setAttribute("aria-expanded", "true");
      sub.style.display = "block";
    }

    btn.addEventListener("click", function () {
      if (btn.getAttribute("aria-expanded") === "true") close();
      else open();
    });

    li.addEventListener(
      "focusout",
      function () {
        setTimeout(function () {
          if (!li.contains(document.activeElement)) close();
        }, 0);
      },
      true
    );

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && btn.getAttribute("aria-expanded") === "true") {
        close();
        btn.focus();
      }
    });
  });
})();
