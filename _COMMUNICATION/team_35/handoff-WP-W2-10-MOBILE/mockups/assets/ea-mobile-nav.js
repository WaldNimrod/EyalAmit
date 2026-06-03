/* =============================================================
   ea-mobile-nav.js — builds + drives the mobile drawer for ea-topnav
   team_35 · WP-W2-10 mobile. No deps. Token-pure markup.
   - Injects the closed-bar controls (burger · sound · language)
   - Injects the side-sheet drawer with the FULL approved menu
   - Inline-accordion submenus (aria-expanded), focus trap, Esc,
     scrim / outside-tap close, restore focus, resize auto-close
   - Mirrors RTL↔LTR; slide axis computed from (dir, side)
   - Listens for harness postMessage (drawer side, open, variants)
   ============================================================= */
(function () {
  "use strict";

  var doc = document;
  var html = doc.documentElement;
  var isEN = (html.getAttribute("lang") || "he").toLowerCase().indexOf("en") === 0;
  var dir = (html.getAttribute("dir") || "rtl").toLowerCase();

  /* ---- menu model (locked to hub/data/site-tree.json) ---- */
  var MENU_HE = {
    brand: "אייל עמית",
    home: { label: "בית", short: "בית", href: "Home - Dashboard (elevated).html" },
    items: [
      { label: "טיפול בדיג׳רידו", short: "טיפול", href: "Service - Treatment (elevated).html" },
      { label: "השיטה", short: "השיטה", href: "Method (elevated).html" },
      { label: "שיעורי דיג׳רידו", short: "שיעורים", href: "#lessons" },
      { label: "סאונד הילינג", short: "סאונד הילינג", href: "#sound-healing" },
      { label: "לימוד והכשרה", short: "לימוד והכשרה", href: "#learning", children: [
        { label: "הכשרות למטפלים", href: "#therapist-training" },
        { label: "קורסים", href: "#courses", ext: "חיצוני ↗" },
        { label: "הרצאות", href: "#lectures" },
        { label: "סדנאות", href: "#workshops" }
      ]},
      { label: "כלים ואביזרים", short: "כלים ואביזרים", href: "#tools", children: [
        { label: "כלים בעבודת יד ואביזרים", href: "#instruments" },
        { label: "תיקון וחידוש כלים", href: "#repair" }
      ]},
      { label: "מוזה הוצאה לאור", short: "מוזה", href: "Commerce - Books Archive (elevated).html" },
      { label: "בלוג דיג׳רידו", short: "בלוג", href: "#blog" },
      { label: "אייל עמית", short: "אייל עמית", href: "Editorial - About (elevated).html", children: [
        { label: "מוקש דהימן — לזכרו", href: "Memorial - Mokesh (elevated).html" }
      ]},
      { label: "צור קשר", short: "צור קשר", href: "#contact" }
    ],
    footLinks: [
      { label: "שאלות נפוצות", href: "#faq" },
      { label: "גלריות", href: "Galleries Catalog (elevated).html" },
      { label: "המלצות", href: "Media Catalog (elevated).html" },
      { label: "מדיניות פרטיות", href: "#privacy" },
      { label: "הצהרת נגישות", href: "#accessibility" },
      { label: "תקנון", href: "#terms" }
    ],
    social: [
      { label: "פייסבוק", href: "#facebook" },
      { label: "אינסטגרם", href: "#instagram" },
      { label: "יוטיוב", href: "#youtube" }
    ],
    tagline: "המרכז לטיפול בנשימה באמצעות דיג׳רידו · סטודיו נשימה מעגלית",
    location: "פרדס חנה · ישראל",
    footNavHead: "ניווט", footInfoHead: "מידע ותקנון", footFollowHead: "עקבו",
    copy: "© 2026 אייל עמית · כל הזכויות שמורות",
    sound: "שמע", soundOn: "משמיע", close: "סגירת תפריט", open: "פתיחת תפריט",
    menuLabel: "תפריט", lang: "EN", langHref: "EN - Landing (elevated).html",
    langAria: "English — switch to English"
  };

  var MENU_EN = {
    brand: "Eyal Amit",
    home: { label: "Home", href: "#hero" },
    items: [
      { label: "The Method", href: "#method" },
      { label: "Services", href: "#services" },
      { label: "Books", href: "#books" },
      { label: "Testimonials", href: "#testimonials" }
    ],
    footLinks: [
      { label: "Contact", href: "#contact" },
      { label: "Privacy", href: "#privacy" },
      { label: "Accessibility", href: "#accessibility" }
    ],
    social: [
      { label: "Facebook", href: "#facebook" },
      { label: "Instagram", href: "#instagram" },
      { label: "YouTube", href: "#youtube" }
    ],
    tagline: "The Center for Breath Therapy through the Didgeridoo",
    location: "Pardes Hanna · Israel",
    footNavHead: "Navigate", footInfoHead: "Info", footFollowHead: "Follow",
    copy: "© 2026 Eyal Amit — The Center for Breath Therapy through the Didgeridoo. All rights reserved.",
    sound: "Sound", soundOn: "Playing", close: "Close menu", open: "Open menu",
    menuLabel: "Mobile menu", lang: "עברית", langHref: "Home - Dashboard (elevated).html",
    langAria: "עברית — switch to Hebrew"
  };

  var M = isEN ? MENU_EN : MENU_HE;

  /* ---- helpers ---- */
  function el(tag, cls, attrs) {
    var n = doc.createElement(tag);
    if (cls) n.className = cls;
    if (attrs) for (var k in attrs) { if (attrs[k] != null) n.setAttribute(k, attrs[k]); }
    return n;
  }
  function here() {
    var p = decodeURIComponent(location.pathname.split("/").pop() || "");
    return p;
  }

  var topnav = doc.querySelector(".ea-topnav");
  if (!topnav) return;

  /* =========================================================
     1) closed-bar controls : burger · sound · language
     ========================================================= */
  var controls = el("div", "ea-mnav-controls");

  var burger = el("button", "ea-mnav-tap ea-mnav-burger", {
    type: "button", "aria-label": M.open, "aria-expanded": "false",
    "aria-controls": "ea-mnav-drawer", "aria-haspopup": "true"
  });
  var bars = el("span", "ea-mnav-burger__bars", { "aria-hidden": "true" });
  bars.appendChild(el("span")); bars.appendChild(el("span")); bars.appendChild(el("span"));
  burger.appendChild(bars);

  var sound = el("button", "ea-mnav-tap ea-mnav-pill ea-mnav-sound", {
    type: "button", "aria-pressed": "false",
    "aria-label": isEN ? "Toggle didgeridoo sound" : "הפעלת צליל דיג׳רידו"
  });
  var soundIcon = el("span", null, { "aria-hidden": "true" }); soundIcon.textContent = "♪";
  var soundTxt = el("span"); soundTxt.textContent = M.sound;
  sound.appendChild(soundIcon); sound.appendChild(soundTxt);

  var lang = el("a", "ea-mnav-tap ea-mnav-pill ea-mnav-lang", {
    href: M.langHref, lang: isEN ? "he" : "en", "aria-label": M.langAria
  });
  lang.textContent = M.lang;

  controls.appendChild(burger);
  controls.appendChild(sound);
  controls.appendChild(lang);
  topnav.appendChild(controls);

  /* =========================================================
     2) scrim + drawer
     ========================================================= */
  var scrim = el("div", "ea-mnav-scrim", { "aria-hidden": "true" });

  var drawer = el("aside", "ea-mnav-drawer", {
    id: "ea-mnav-drawer", role: "dialog", "aria-modal": "true",
    "aria-label": M.menuLabel, "data-side": "end", tabindex: "-1"
  });

  // header
  var head = el("div", "ea-mnav-drawer__head");
  var dbrand = el("a", "ea-mnav-drawer__brand", { href: M.home.href });
  dbrand.textContent = M.brand;
  var close = el("button", "ea-mnav-close", { type: "button", "aria-label": M.close });
  close.innerHTML = "&times;";
  head.appendChild(dbrand); head.appendChild(close);
  drawer.appendChild(head);

  // list
  var list = el("ul", "ea-mnav-list", { role: "list" });
  var current = here();
  var accId = 0;

  function makeLink(item) {
    var a = el("a", "ea-mnav-link", { href: item.href });
    var span = el("span"); span.textContent = item.label; a.appendChild(span);
    if (item.ext) { var x = el("span", "ea-mnav-link__ext"); x.textContent = item.ext; a.appendChild(x); }
    if (item.href && current && item.href === current) a.setAttribute("aria-current", "page");
    return a;
  }

  function addLeaf(item) {
    var li = el("li", "ea-mnav-list__item");
    li.appendChild(makeLink(item));
    list.appendChild(li);
  }

  function addAccordion(item) {
    accId++;
    var li = el("li", "ea-mnav-list__item");
    var panelId = "ea-mnav-acc-" + accId;
    var btn = el("button", "ea-mnav-acc__btn", {
      type: "button", "aria-expanded": "false", "aria-controls": panelId
    });
    var lbl = el("span"); lbl.textContent = item.label; btn.appendChild(lbl);
    var caret = el("span", "ea-mnav-acc__caret", { "aria-hidden": "true" }); caret.textContent = "⌄";
    btn.appendChild(caret);

    var panel = el("div", "ea-mnav-acc__panel", { id: panelId });
    var inner = el("div", "ea-mnav-acc__panel-inner");
    var sub = el("ul", "ea-mnav-sublist", { role: "list" });
    // parent landing link first
    var parentItem = { label: item.label + (isEN ? " — overview" : " — עמוד ראשי"), href: item.href };
    item.children.forEach(function (c) {
      var sli = el("li");
      var sa = el("a", "ea-mnav-sublink", { href: c.href });
      var s1 = el("span"); s1.textContent = c.label; sa.appendChild(s1);
      if (c.ext) { var xx = el("span", "ea-mnav-link__ext"); xx.textContent = c.ext; sa.appendChild(xx); }
      sli.appendChild(sa); sub.appendChild(sli);
    });
    inner.appendChild(sub); panel.appendChild(inner);

    btn.addEventListener("click", function () {
      var open = btn.getAttribute("aria-expanded") === "true";
      btn.setAttribute("aria-expanded", String(!open));
    });

    li.appendChild(btn); li.appendChild(panel);
    list.appendChild(li);
  }

  if (M.home) addLeaf(M.home);
  M.items.forEach(function (it) {
    if (it.children && it.children.length) addAccordion(it);
    else addLeaf(it);
  });
  drawer.appendChild(list);

  // footer (utility + secondary catalog/legal links)
  var foot = el("div", "ea-mnav-foot");
  var utils = el("div", "ea-mnav-foot__utils");
  var fsound = el("button", "ea-mnav-tap ea-mnav-pill ea-mnav-sound", {
    type: "button", "aria-pressed": "false",
    "aria-label": isEN ? "Toggle didgeridoo sound" : "הפעלת צליל דיג׳רידו"
  });
  var fsi = el("span", null, { "aria-hidden": "true" }); fsi.textContent = "♪";
  var fst = el("span"); fst.textContent = M.sound;
  fsound.appendChild(fsi); fsound.appendChild(fst);
  var flang = el("a", "ea-mnav-tap ea-mnav-pill ea-mnav-lang", {
    href: M.langHref, lang: isEN ? "he" : "en", "aria-label": M.langAria
  });
  flang.textContent = M.lang;
  utils.appendChild(fsound); utils.appendChild(flang);
  foot.appendChild(utils);

  if (M.footLinks && M.footLinks.length) {
    var flinks = el("div", "ea-mnav-foot__links");
    M.footLinks.forEach(function (f) {
      var a = el("a", null, { href: f.href }); a.textContent = f.label; flinks.appendChild(a);
    });
    foot.appendChild(flinks);
  }
  drawer.appendChild(foot);

  doc.body.appendChild(scrim);
  doc.body.appendChild(drawer);

  /* =========================================================
     2b) CANONICAL DESKTOP NAV — uniform across every template
         (one source of truth = the approved site-tree menu).
         Shown >=1024px; 3 parents get hover/focus dropdowns.
     ========================================================= */
  function buildDesktopNav() {
    var ul = topnav.querySelector(".ea-topnav__links");
    if (!ul) { ul = el("ul", "ea-topnav__links", { role: "list" }); topnav.insertBefore(ul, topnav.firstChild.nextSibling); }
    ul.setAttribute("role", "list");
    ul.innerHTML = "";
    function deskLink(item, extraCls) {
      var a = el("a", "ea-topnav__link" + (extraCls ? " " + extraCls : ""), { href: item.href });
      a.appendChild(doc.createTextNode(item.short || item.label));
      if (item.href && current && item.href === current) a.setAttribute("aria-current", "page");
      return a;
    }
    M.items.forEach(function (it) {
      var hasSub = it.children && it.children.length;
      var li = el("li", "ea-topnav__item" + (hasSub ? " ea-topnav__has-sub" : ""));
      if (hasSub) {
        var a = deskLink(it);
        var caret = el("span", "ea-topnav__caret", { "aria-hidden": "true" }); caret.textContent = "⌄";
        a.appendChild(caret);
        var sub = el("ul", "ea-topnav__sub", { role: "list" });
        it.children.forEach(function (c) {
          var sli = el("li");
          var sa = el("a", "ea-topnav__sublink", { href: c.href });
          sa.appendChild(doc.createTextNode(c.label));
          if (c.ext) { var x = el("span", "ea-topnav__ext"); x.textContent = c.ext; sa.appendChild(x); }
          sli.appendChild(sa); sub.appendChild(sli);
        });
        li.appendChild(a); li.appendChild(sub);
      } else {
        li.appendChild(deskLink(it));
      }
      ul.appendChild(li);
    });
  }

  /* =========================================================
     2c) CANONICAL FOOTER — uniform brand + nav + info + social
         + copyright on every template.
     ========================================================= */
  function buildFooter() {
    var inner = doc.querySelector(".ea-footer .ea-footer__inner") || doc.querySelector(".ea-footer__inner");
    if (!inner) return;
    inner.innerHTML = "";
    var grid = el("div", "ea-cfoot");

    // brand column
    var bcol = el("div", "ea-cfoot__brandcol");
    var bn = el("p", "ea-cfoot__brand"); bn.textContent = M.brand; bcol.appendChild(bn);
    var tg = el("p", "ea-cfoot__tag"); tg.textContent = M.tagline; bcol.appendChild(tg);
    var lc = el("p", "ea-cfoot__loc"); lc.textContent = M.location; bcol.appendChild(lc);
    grid.appendChild(bcol);

    // primary nav column
    function linkCol(head, items, mapper) {
      var col = el("nav", "ea-cfoot__col", { "aria-label": head });
      var h = el("p", "ea-cfoot__head"); h.textContent = head; col.appendChild(h);
      var list = el("ul", "ea-cfoot__list", { role: "list" });
      items.forEach(function (it) {
        var li = el("li");
        var a = el("a", null, { href: it.href }); a.textContent = mapper ? mapper(it) : it.label;
        li.appendChild(a); list.appendChild(li);
      });
      col.appendChild(list); return col;
    }
    grid.appendChild(linkCol(M.footNavHead, M.items, function (it) { return it.short || it.label; }));
    grid.appendChild(linkCol(M.footInfoHead, M.footLinks));

    // follow column
    if (M.social && M.social.length) {
      grid.appendChild(linkCol(M.footFollowHead, M.social));
    }
    inner.appendChild(grid);

    var hr = el("hr", "ea-cfoot__divider", { "aria-hidden": "true" });
    inner.appendChild(hr);
    var cp = el("p", "ea-cfoot__copy"); cp.textContent = M.copy;
    inner.appendChild(cp);
  }

  buildDesktopNav();
  buildFooter();

  /* =========================================================
     3) slide axis : compute physical sign from (dir, side)
     ========================================================= */
  function applySide(side) {
    drawer.setAttribute("data-side", side);
    var physicalLeft = (side === "start" && dir === "ltr") || (side === "end" && dir === "rtl");
    html.style.setProperty("--ea-mnav-tx", physicalLeft ? "-100%" : "100%");
  }
  applySide("end"); // default: opens from the burger's side

  /* =========================================================
     4) open / close + focus trap
     ========================================================= */
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
    burger.setAttribute("aria-expanded", "true");
    burger.setAttribute("aria-label", M.close);
    scrim.removeAttribute("aria-hidden");
    setTimeout(function () { close.focus(); }, 60);
    doc.addEventListener("keydown", onKey, true);
  }
  function closeDrawer() {
    if (!isOpen()) return;
    html.classList.remove("ea-mnav-open");
    burger.setAttribute("aria-expanded", "false");
    burger.setAttribute("aria-label", M.open);
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

  burger.addEventListener("click", function () { isOpen() ? closeDrawer() : openDrawer(); });
  close.addEventListener("click", closeDrawer);
  scrim.addEventListener("click", closeDrawer);

  // tapping a real navigation target closes the drawer
  drawer.addEventListener("click", function (e) {
    var a = e.target.closest && e.target.closest("a");
    if (a && a.classList.contains("ea-mnav-sublink") ||
        (a && a.classList.contains("ea-mnav-link")) ||
        (a && a.classList.contains("ea-mnav-drawer__brand")) ||
        (a && a.closest(".ea-mnav-foot__links"))) {
      closeDrawer();
    }
  });

  // sound toggle (visual only — audio asset is a graceful Eyal-gap)
  [sound, fsound].forEach(function (b) {
    b.addEventListener("click", function () {
      var on = b.getAttribute("aria-pressed") === "true";
      [sound, fsound].forEach(function (x) {
        x.setAttribute("aria-pressed", String(!on));
        x.querySelector("span:last-child").textContent = !on ? M.soundOn : M.sound;
      });
    });
  });

  // close if resized back to desktop
  var mq = window.matchMedia("(min-width:1024px)");
  (mq.addEventListener ? mq.addEventListener.bind(mq, "change") : mq.addListener.bind(mq))(function () {
    if (mq.matches) closeDrawer();
  });

  /* =========================================================
     5) harness bridge (postMessage) — drawer side, open, variants
     ========================================================= */
  window.addEventListener("message", function (e) {
    var d = e.data;
    if (!d || d.ns !== "ea-mnav") return;
    if (d.cmd === "open") openDrawer();
    if (d.cmd === "close") closeDrawer();
    if (d.cmd === "side") applySide(d.value === "start" ? "start" : "end");
    if (d.cmd === "variant" && d.key) {
      if (d.value == null) html.removeAttribute("data-" + d.key);
      else html.setAttribute("data-" + d.key, d.value);
    }
  });
  // announce readiness so the harness can replay current state
  try { if (window.parent !== window) window.parent.postMessage({ ns: "ea-mnav", evt: "ready", page: here() }, "*"); } catch (err) {}
})();
