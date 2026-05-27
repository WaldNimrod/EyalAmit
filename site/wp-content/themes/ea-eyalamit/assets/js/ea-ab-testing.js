/**
 * B3 WhatsApp CTA A/B — variants A (form-only), B (dual), C (WA-only).
 * Per-session assignment; GA4 event when gtag available.
 */
(function () {
  'use strict';
  var KEY = 'ea_wa_ab_variant';
  var variants = ['A', 'B', 'C'];
  var stored = sessionStorage.getItem(KEY);
  if (!stored || variants.indexOf(stored) === -1) {
    stored = variants[Math.floor(Math.random() * variants.length)];
    sessionStorage.setItem(KEY, stored);
  }

  function track(eventName, params) {
    if (typeof window.gtag === 'function') {
      window.gtag('event', eventName, params || {});
    }
  }

  track('wa_ab_assignment', { variant_label: stored, non_interaction: true });

  var wa = document.querySelector('.ea-whatsapp-float[data-ea-ab]');
  if (wa) {
    wa.setAttribute('data-variant', stored);
    if (stored === 'A') {
      wa.style.display = 'none';
    }
    wa.addEventListener('click', function () {
      track('whatsapp_cta_click', { variant_label: stored });
    });
  }

  var formWrap = document.querySelector('.ea-contact-form--cf7, .ea-contact-section .ea-contact-form');
  if (formWrap) {
    formWrap.setAttribute('data-wa-variant', stored);
    if (stored === 'C') {
      formWrap.style.display = 'none';
    }
  }

  document.querySelectorAll('.ea-footer__social-link').forEach(function (link) {
    link.addEventListener('click', function () {
      var platform = 'social';
      var href = link.getAttribute('href') || '';
      if (href.indexOf('facebook') !== -1) {
        platform = 'facebook';
      } else if (href.indexOf('instagram') !== -1) {
        platform = 'instagram';
      } else if (href.indexOf('youtube') !== -1) {
        platform = 'youtube';
      }
      track('outbound_click', { link_url: href, link_platform: platform });
    });
  });
})();
