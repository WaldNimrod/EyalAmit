/**
 * D-14 §2.2 — IntersectionObserver entrance (.ea-entrance).
 */
(function () {
  'use strict';
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('.ea-entrance, .ea-entrance--breath, .ea-entrance--slide').forEach(function (el) {
      el.style.opacity = '1';
      el.style.transform = 'none';
    });
    return;
  }
  if (!('IntersectionObserver' in window)) {
    return;
  }
  var io = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('ea-entrance--visible');
          io.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );
  document.querySelectorAll('.ea-entrance, .ea-entrance--breath, .ea-entrance--slide').forEach(function (el) {
    io.observe(el);
  });
})();
