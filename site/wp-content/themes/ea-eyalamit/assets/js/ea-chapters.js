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

  /* ---- mobile hamburger ---- */
  if (nav) {
    var burger = nav.querySelector('.nav__burger');
    if (burger) {
      var closeMenu = function () {
        nav.removeAttribute('data-menu');
        burger.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-locked');
      };
      burger.addEventListener('click', function () {
        var open = nav.getAttribute('data-menu') === '1';
        if (open) { closeMenu(); return; }
        nav.setAttribute('data-menu', '1');
        burger.setAttribute('aria-expanded', 'true');
        document.body.classList.add('nav-locked');
      });
      /* close when a real link (not a dropdown toggle) is tapped */
      nav.querySelectorAll('.nav__l a').forEach(function (a) {
        a.addEventListener('click', closeMenu);
      });
      window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && nav.getAttribute('data-menu') === '1') closeMenu();
      });
    }
  }

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

  /* ---- sound toggle: mute/unmute the hero video ---- */
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
  } else if (sndBtn && !heroVid) {
    /* no hero video on this page: keep the button inert but non-misleading */
    sndBtn.setAttribute('hidden', '');
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
