/**
 * D-14 — scroll progress bar (#ea-scroll-progress).
 */
(function () {
  'use strict';
  var bar = document.getElementById('ea-scroll-progress');
  if (!bar || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }
  function update() {
    var doc = document.documentElement;
    var scrollTop = doc.scrollTop || document.body.scrollTop;
    var height = doc.scrollHeight - doc.clientHeight;
    var pct = height > 0 ? (scrollTop / height) * 100 : 0;
    bar.style.width = pct + '%';
  }
  window.addEventListener('scroll', update, { passive: true });
  update();
})();
