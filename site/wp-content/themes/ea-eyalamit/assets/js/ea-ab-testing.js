/**
 * B3 WhatsApp CTA A/B — variants form_only (form visible, WA hidden),
 * dual (both WA and form visible), wa_only (WA visible, form hidden).
 * Per-session assignment; GA4 event when gtag available.
 * Canonical key: eyal_cta_variant (MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0)
 */
(function () {
  'use strict';
  var KEY = 'eyal_cta_variant';
  var variants = ['form_only', 'dual', 'wa_only'];
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
    if (stored === 'form_only') {
      wa.style.display = 'none';
    }
    wa.addEventListener('click', function () {
      track('whatsapp_cta_click', { variant_label: stored });
    });
  }

  var formWrap = document.querySelector('.ea-contact-form--cf7, .ea-contact-section .ea-contact-form');
  if (formWrap) {
    formWrap.setAttribute('data-wa-variant', stored);
    if (stored === 'wa_only') {
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
