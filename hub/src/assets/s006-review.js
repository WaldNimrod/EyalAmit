/**
 * S006 review form — local draft + JSON export (eyal-s006-tracker-answers).
 */
(function () {
  "use strict";
  var LS = "ea-s006-review-v1";
  var cfg = window.S006_CONFIG || {};
  var items = cfg.items || [];

  function $(id) {
    return document.getElementById(id);
  }

  function load() {
    try {
      return JSON.parse(localStorage.getItem(LS) || "{}") || {};
    } catch (e) {
      return {};
    }
  }

  function save(state) {
    try {
      localStorage.setItem(LS, JSON.stringify(state));
    } catch (e) {
      /* ignore quota */
    }
  }

  function readItem(it) {
    var name = "choice-" + it.domId;
    var chosen = "";
    var radios = document.getElementsByName(name);
    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) {
        chosen = radios[i].value;
        break;
      }
    }
    var fillEl = $("fill-" + it.domId);
    var notesEl = $("notes-" + it.domId);
    return {
      id: it.id,
      choice: chosen,
      fill: fillEl ? String(fillEl.value || "").trim() : "",
      notes: notesEl ? String(notesEl.value || "").trim() : "",
    };
  }

  function applyItem(it, rec) {
    if (!rec) return;
    if (rec.choice) {
      var radios = document.getElementsByName("choice-" + it.domId);
      for (var i = 0; i < radios.length; i++) {
        radios[i].checked = radios[i].value === rec.choice;
      }
    }
    var fillEl = $("fill-" + it.domId);
    var notesEl = $("notes-" + it.domId);
    if (fillEl && rec.fill) fillEl.value = rec.fill;
    if (notesEl && rec.notes) notesEl.value = rec.notes;
  }

  function snapshot() {
    var out = { respondent: ($("respondent") && $("respondent").value) || "", answers: {} };
    items.forEach(function (it) {
      out.answers[it.id] = readItem(it);
    });
    return out;
  }

  function answeredCount() {
    var n = 0;
    items.forEach(function (it) {
      var rec = readItem(it);
      if (rec.choice || rec.fill || rec.notes) n += 1;
    });
    return n;
  }

  function refreshProgress() {
    var el = $("s006-progress");
    if (!el) return;
    el.textContent = answeredCount() + " / " + items.length + " נענו";
  }

  function persist() {
    save(snapshot());
    refreshProgress();
  }

  function isoStamp() {
    return new Date().toISOString().replace(/\.\d{3}Z$/, "Z").replace(/:/g, "-");
  }

  function exportJson() {
    var answers = [];
    items.forEach(function (it) {
      var rec = readItem(it);
      if (rec.choice || rec.fill || rec.notes) {
        answers.push({
          id: rec.id,
          choice: rec.choice,
          fill: rec.fill,
          notes: rec.notes,
        });
      }
    });
    if (!answers.length) {
      alert("אין תשובות לייצוא");
      return;
    }
    var payload = {
      schemaVersion: 1,
      exportType: cfg.exportType || "eyal-s006-tracker-answers",
      exportTimestamp: new Date().toISOString(),
      respondent: ($("respondent") && $("respondent").value.trim()) || cfg.defaultRespondent || "",
      sourceGeneratedAt: cfg.generatedAt || "",
      answers: answers,
    };
    var blob = new Blob([JSON.stringify(payload, null, 2)], {
      type: "application/json;charset=utf-8",
    });
    var a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = "eyal-s006-tracker-answers-" + isoStamp() + ".json";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(a.href);
  }

  function filterPattern(pid) {
    var pages = document.querySelectorAll(".s006-page");
    pages.forEach(function (page) {
      var cards = page.querySelectorAll(".s006-item");
      var visible = 0;
      cards.forEach(function (card) {
        var show = !pid || card.getAttribute("data-pattern") === pid;
        card.hidden = !show;
        if (show) visible += 1;
      });
      page.hidden = visible === 0;
    });
    document.querySelectorAll(".s006-chip").forEach(function (btn) {
      btn.classList.toggle("is-on", (btn.getAttribute("data-filter") || "") === pid);
    });
  }

  document.addEventListener("change", persist);
  document.addEventListener("input", persist);

  var stored = load();
  if (stored.respondent && $("respondent")) {
    $("respondent").value = stored.respondent;
  }
  items.forEach(function (it) {
    applyItem(it, stored.answers && stored.answers[it.id]);
  });
  refreshProgress();

  var btn = $("btn-export-s006");
  if (btn) btn.addEventListener("click", exportJson);

  document.querySelectorAll(".s006-chip").forEach(function (btn) {
    btn.addEventListener("click", function () {
      filterPattern(btn.getAttribute("data-filter") || "");
    });
  });
})();
