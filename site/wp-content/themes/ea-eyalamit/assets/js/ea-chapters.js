/* ============================================================
 * ea-chapters.js — Chapters (פרקים) design system runtime
 * Ported from the mockup's inline script + a self-contained mobile nav.
 * - nav scroll-state (data-s)
 * - scroll-reveal (.r -> .in) via IntersectionObserver, reduced-motion safe
 * - mobile hamburger (data-menu + body lock)
 * - sound toggle: mute/unmute the hero background video
 * No build step, no dependencies.
 * ============================================================ */
(function () {
  'use strict';

  /* ---- nav scroll-state ---- */
  var nav = document.getElementById('nav');
  if (nav) {
    var setState = function () {
      nav.setAttribute('data-s', window.scrollY > 40 ? '1' : '0');
    };
    setState();
    window.addEventListener('scroll', setState, { passive: true });
  }

  /* ---- scroll reveal ---- */
  var reveals = document.querySelectorAll('.r');
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reveals.length && 'IntersectionObserver' in window && !reduce) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) {
          en.target.classList.add('in');
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -7% 0px' });
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    /* reduced motion or no IO: show everything */
    reveals.forEach(function (el) { el.classList.add('in'); });
  }

  /* Old-site uncover: the footer sits under the page and is revealed at the end.
     Skip when the footer is taller than the viewport, or when motion is reduced. */
  var foot = document.querySelector('footer.foot.uncover');
  var mainEl = document.getElementById('main');
  var sizeUncover = function () {
    if (!foot || !mainEl) return;
    var tooTall = foot.offsetHeight > window.innerHeight * 0.85;
    if (reduce || tooTall) {
      foot.classList.remove('is-uncover');
      mainEl.style.marginBottom = '';
      return;
    }
    foot.classList.add('is-uncover');
    mainEl.style.marginBottom = foot.offsetHeight + 'px';
  };
  if (foot && mainEl) {
    sizeUncover();
    window.addEventListener('resize', sizeUncover);
  }

  /* ---- submenu disclosure state (WS-3B / A11Y-FIX-2026-09-18) ----
   * The two `.nav__dd` <button>s (section-nav.php:42,73 — "לימוד והכשרה",
   * "אייל עמית") ship with a hardcoded aria-expanded="false" that never
   * changes: zero occurrences of `nav__dd` existed in any theme JS file
   * before this. SC 4.1.2 Name, Role, Value. Source: A11Y-INTERACT-03.
   *
   * Desktop (>1180px — chapters.css:527/657 breakpoint) reveals each
   * button's sibling `.nav__sub` on real CSS `:hover`/`:focus-within`
   * (chapters.css:522) — there is no click-driven open state to mirror here
   * (unlike the dead ea-hero.js:47-75 reference, whose ea-atoms.css keys
   * visibility off `[aria-expanded="true"] + .nav__submenu`; chapters.css
   * has zero `aria-expanded` selectors, confirmed by grep, so this nav's
   * visibility is driven purely by native hover/focus). So instead of
   * porting that click-toggle logic, this listens for the same native
   * mouseenter/mouseleave/focusin/focusout events CSS itself reacts to and
   * re-reads `li.matches(':hover' )`/`:focus-within')` live — the attribute
   * mirrors the true rendered state and can never drift from it.
   *
   * At <=1180px the submenu has no per-item state at all to mirror:
   * chapters.css:679-683 deliberately makes every `.nav__sub` inline and
   * permanently expanded together inside the open drawer ("the submenu is
   * always expanded inside the drawer" — chapters.css:679-680 comment), and
   * chapters.css:691-692 neutralises hover/focus-within there on purpose
   * (defeating them was the fix for the 18-focusable-links-behind-a-closed-
   * drawer bug in commit 57883f8). So below that width this instead tracks
   * the single drawer flag (`nav[data-menu]`) that the burger handler below
   * already owns — see the two syncDrawerExpanded() calls added to it.
   *
   * Deliberately NOT done (see 05-DONE-ARIA-AND-FORM-LANG.md for the full
   * justification): no click/Escape/outside-click handling added for these
   * two buttons — this hover/focus-within-driven popover already closes
   * itself the instant hover/focus leaves, so there is no "stuck open"
   * state for Escape to solve (unlike the dead nav's click-toggle, which
   * needed one). The three `.nav__dd` <a> elements (section-nav.php:32,52,63)
   * are left without aria-haspopup/aria-expanded — they are primary
   * navigation links, not disclosure controls, and were not part of the
   * measured defect (which is specifically the two buttons' hardcoded
   * state); see the report for the full reasoning. */
  if (nav) {
    var ddToggles = nav.querySelectorAll('.nav__dd[aria-haspopup="true"]');
    var narrowMQ = window.matchMedia
      ? window.matchMedia('(max-width: 1180px)')
      : { matches: false, addEventListener: function () {}, addListener: function () {} };

    var syncDesktopOne = function (toggle) {
      var li = toggle.closest('li');
      var open = !!li && (li.matches(':hover') || li.matches(':focus-within'));
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    /* mobile: every `.nav__dd` submenu is expanded together, exactly when
       the drawer is open — see the block comment above. */
    var syncDrawerExpanded = function () {
      var open = nav.getAttribute('data-menu') === '1';
      ddToggles.forEach(function (toggle) {
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    };

    if (ddToggles.length) {
      ddToggles.forEach(function (toggle) {
        var li = toggle.closest('li');
        if (!li) return;
        var onHoverFocusChange = function () {
          if (!narrowMQ.matches) syncDesktopOne(toggle);
        };
        li.addEventListener('mouseenter', onHoverFocusChange);
        li.addEventListener('mouseleave', onHoverFocusChange);
        li.addEventListener('focusin', onHoverFocusChange);
        li.addEventListener('focusout', onHoverFocusChange);
      });

      /* crossing the breakpoint mid-session (resize/orientation/devtools):
         re-settle every toggle under whichever rule now governs it. */
      var onNarrowChange = function () {
        if (narrowMQ.matches) {
          syncDrawerExpanded();
        } else {
          ddToggles.forEach(syncDesktopOne);
        }
      };
      if (narrowMQ.addEventListener) narrowMQ.addEventListener('change', onNarrowChange);
      else if (narrowMQ.addListener) narrowMQ.addListener(onNarrowChange); /* Safari <14 */

      if (narrowMQ.matches) syncDrawerExpanded();
    }
  }

  /* ---- mobile hamburger ----
   * S007 M-12 (2026-09-20): the burger no longer opens .nav__l as an
   * off-canvas panel — chapters.css hides .nav__l entirely at <=1180px now,
   * and ea-nav-drawer.js opens the one shared <dialog> instead (the burger
   * carries data-ea-nav-trigger, added in section-nav.php, which that script
   * auto-wires). data-menu/nav-locked on this element are therefore dead;
   * removed rather than left half-wired. See
   * _COMMUNICATION/team_00/DECISION-S007-MOBILE-NAV-MECHANISM-2026-09-19.md. */

  /* ---- hero video: deferred, reduced-motion-safe autoplay (Core Web Vitals) ----
   * Markup ships with no `autoplay` and `preload="none"` so the video never competes
   * with the poster (LCP) or other critical assets during initial load. Start it only
   * after `window.load`, and only when the visitor hasn't requested reduced motion —
   * reduced-motion users keep the static poster frame. */
  var deferredHeroVid = document.querySelector('.hero__media');
  if (deferredHeroVid && deferredHeroVid.tagName === 'VIDEO' && !reduce) {
    window.addEventListener('load', function () {
      deferredHeroVid.load();
      var p = deferredHeroVid.play();
      if (p && p.catch) p.catch(function () {});
    });
  }

  /* ---- sound toggle: mute/unmute the hero video (button is markup-only when a <video> exists) ---- */
  var sndBtn = document.getElementById('soundtg');
  var heroVid = document.querySelector('.hero__media');
  if (sndBtn && heroVid && heroVid.tagName === 'VIDEO') {
    sndBtn.addEventListener('click', function () {
      heroVid.muted = !heroVid.muted;
      var on = !heroVid.muted;
      sndBtn.setAttribute('aria-pressed', on ? 'true' : 'false');
      if (on) {
        /* a user gesture is required to play with sound — ensure it plays */
        var p = heroVid.play();
        if (p && p.catch) p.catch(function () {});
      }
    });
  }

  /* ---- dedicated video block: click to play ---- */
  document.querySelectorAll('.videoblk__play').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var block = btn.closest('.videoblk');
      if (!block) return;
      var vid = block.querySelector('.videoblk__v');
      var poster = block.querySelector('.videoblk__poster');
      if (!vid) return;
      vid.style.display = 'block';
      if (poster) poster.style.display = 'none';
      btn.style.display = 'none';
      vid.muted = false;
      var p = vid.play();
      if (p && p.catch) p.catch(function () { vid.muted = true; vid.play(); });
    });
  });
})();
