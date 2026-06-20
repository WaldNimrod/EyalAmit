/*
 * EA — Mokesh memorial hero trailer (WP-W2-14-E, team_110 2026-06-21).
 *
 * Plays the documentary TRAILER (kf4NKSdYi9E) as a muted, looping hero background
 * via the YouTube IFrame Player API — the same autoplay/muted/unmute pattern as the
 * home hero (D-EYAL-VIDEO-13), adapted for YouTube (block-hero.php is self-hosted-
 * <video> only, so it cannot host a YouTube embed with an unmute control).
 *
 * - Respects prefers-reduced-motion: if reduced, the player is NOT created and the
 *   dignified gradient hero remains (the markup is complete without the video).
 * - Muted autoplay (browser policy); a custom button toggles sound.
 * - youtube-nocookie host; minimal chrome.
 */
(function () {
  'use strict';

  var mount = document.getElementById('ea-mokesh-trailer');
  if (!mount) {
    return;
  }
  var videoId = mount.getAttribute('data-ytid');
  if (!videoId) {
    return;
  }

  // Reduced motion → keep the static gradient hero, no autoplay, no API load.
  var reduceMotion =
    window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduceMotion) {
    return;
  }

  var hero = mount.closest('.ea-mem-hero');
  var unmuteBtn = hero ? hero.querySelector('[data-ea-mokesh-unmute]') : null;
  var player = null;

  function wireUnmute() {
    if (!unmuteBtn) {
      return;
    }
    unmuteBtn.hidden = false;
    var label = unmuteBtn.querySelector('.ea-mem-hero__unmute-label');
    unmuteBtn.addEventListener('click', function () {
      if (!player || typeof player.isMuted !== 'function') {
        return;
      }
      if (player.isMuted()) {
        player.unMute();
        if (typeof player.setVolume === 'function') {
          player.setVolume(100);
        }
        unmuteBtn.setAttribute('aria-pressed', 'true');
        unmuteBtn.classList.add('is-on');
        if (label) {
          label.textContent = 'השתקת קול';
        }
      } else {
        player.mute();
        unmuteBtn.setAttribute('aria-pressed', 'false');
        unmuteBtn.classList.remove('is-on');
        if (label) {
          label.textContent = 'הפעלת קול';
        }
      }
    });
  }

  function createPlayer() {
    /* global YT */
    player = new YT.Player(mount, {
      videoId: videoId,
      host: 'https://www.youtube-nocookie.com',
      playerVars: {
        autoplay: 1,
        mute: 1,
        controls: 0,
        loop: 1,
        playlist: videoId, // loop requires an explicit single-item playlist
        playsinline: 1,
        rel: 0,
        modestbranding: 1,
        disablekb: 1,
        fs: 0,
        iv_load_policy: 3,
        cc_load_policy: 0,
      },
      events: {
        onReady: function (e) {
          try {
            e.target.mute();
            e.target.playVideo();
          } catch (err) {
            /* autoplay policy may block; poster/gradient remains */
          }
          if (hero) {
            hero.classList.add('ea-mem-hero--playing');
          }
          wireUnmute();
        },
      },
    });
  }

  function loadApiThenCreate() {
    if (window.YT && window.YT.Player) {
      createPlayer();
      return;
    }
    // Chain any existing onYouTubeIframeAPIReady (don't clobber other embeds).
    var prev = window.onYouTubeIframeAPIReady;
    window.onYouTubeIframeAPIReady = function () {
      if (typeof prev === 'function') {
        try {
          prev();
        } catch (err) {
          /* ignore other handlers' errors */
        }
      }
      createPlayer();
    };
    if (!document.getElementById('ea-youtube-iframe-api')) {
      var tag = document.createElement('script');
      tag.id = 'ea-youtube-iframe-api';
      tag.src = 'https://www.youtube.com/iframe_api';
      var first = document.getElementsByTagName('script')[0];
      first.parentNode.insertBefore(tag, first);
    }
  }

  loadApiThenCreate();
})();
