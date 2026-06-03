/**
 * Hero sound toggle + mobile nav burger (POC parity).
 */
(function () {
  'use strict';
  var btn = document.querySelector('.ea-sound-toggle');
  if (btn) {
    var audio = btn.querySelector('.ea-sound-toggle__audio');
    btn.addEventListener('click', function () {
      var on = btn.getAttribute('data-on') === 'true';
      if (on && audio) {
        audio.pause();
        btn.setAttribute('data-on', 'false');
        btn.setAttribute('aria-pressed', 'false');
        btn.setAttribute('aria-label', "שמע — הפעל צליל דיג'רידו");
      } else if (audio) {
        audio.play().catch(function () {});
        btn.setAttribute('data-on', 'true');
        btn.setAttribute('aria-pressed', 'true');
        btn.setAttribute('aria-label', 'שמע — השתק צליל');
      }
    });
  }
  var burger = document.querySelector('.ea-topnav__burger');
  var links = document.querySelector('.ea-topnav__links');
  if (burger && links) {
    burger.addEventListener('click', function () {
      var open = burger.getAttribute('aria-expanded') === 'true';
      burger.setAttribute('aria-expanded', open ? 'false' : 'true');
      links.style.display = open ? '' : 'flex';
      if (!open && window.matchMedia('(max-width: 767px)').matches) {
        links.style.flexDirection = 'column';
        links.style.position = 'absolute';
        links.style.top = 'var(--ea-nav-height)';
        links.style.right = '0';
        links.style.left = '0';
        links.style.background = 'rgba(46,43,40,0.95)';
        links.style.padding = 'var(--ea-space-3)';
      }
    });
  }

  /* Dropdown groups (approved menu): click/touch + keyboard toggle of
     aria-expanded. Desktop hover/focus-within is handled in CSS; this adds
     explicit click support, outside-click + Escape close, for mobile and
     pointer users. */
  var toggles = document.querySelectorAll('.ea-topnav__dropdown-toggle');
  if (toggles.length) {
    var closeAll = function (except) {
      for (var i = 0; i < toggles.length; i++) {
        if (toggles[i] !== except) {
          toggles[i].setAttribute('aria-expanded', 'false');
        }
      }
    };
    for (var t = 0; t < toggles.length; t++) {
      (function (toggle) {
        toggle.addEventListener('click', function () {
          var open = toggle.getAttribute('aria-expanded') === 'true';
          closeAll(toggle);
          toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
        });
      })(toggles[t]);
    }
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' || e.key === 'Esc') {
        closeAll(null);
      }
    });
    document.addEventListener('click', function (e) {
      if (!e.target.closest('.ea-topnav__item--has-submenu')) {
        closeAll(null);
      }
    });
  }
})();
