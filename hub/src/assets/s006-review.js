/**
 * S006 review form — Excel-shaped answers (column D) + page notes (column E).
 * schema excel-v2 · local draft in localStorage.
 */
(function () {
  "use strict";
  var LS = "ea-s006-review-v2";
  var cfg = window.S006_CONFIG || {};
  var items = cfg.items || [];
  var pages = cfg.pages || [];

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
    var answerEl = $("answer-" + it.domId);
    return {
      id: it.id,
      pageKey: it.pageKey || "",
      answer: answerEl ? String(answerEl.value || "").trim() : "",
      choice: chosen,
      fill: fillEl ? String(fillEl.value || "").trim() : "",
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
    var answerEl = $("answer-" + it.domId);
    if (fillEl && rec.fill) fillEl.value = rec.fill;
    if (answerEl && (rec.answer || rec.notes)) {
      answerEl.value = rec.answer || rec.notes;
    }
  }

  function readPageNotes(key) {
    var el = $("pagenotes-" + key);
    return el ? String(el.value || "").trim() : "";
  }

  function snapshot() {
    var out = {
      respondent: ($("respondent") && $("respondent").value) || "",
      answers: {},
      pageNotes: {},
    };
    items.forEach(function (it) {
      out.answers[it.id] = readItem(it);
    });
    pages.forEach(function (p) {
      out.pageNotes[p.key] = readPageNotes(p.key);
    });
    return out;
  }

  function answeredCount() {
    var n = 0;
    items.forEach(function (it) {
      var rec = readItem(it);
      if (rec.answer || rec.choice || rec.fill) n += 1;
    });
    pages.forEach(function (p) {
      if (readPageNotes(p.key)) n += 1;
    });
    return n;
  }

  function refreshProgress() {
    var el = $("s006-progress");
    if (!el) return;
    el.textContent = answeredCount() + " מילויים בטופס";
  }

  function persist() {
    save(snapshot());
    refreshProgress();
  }

  function isoStamp() {
    return new Date().toISOString().replace(/\.\d{3}Z$/, "Z").replace(/:/g, "-");
  }

  function exportJson() {
    var byPage = {};
    items.forEach(function (it) {
      var rec = readItem(it);
      if (!(rec.answer || rec.choice || rec.fill)) return;
      var key = rec.pageKey || it.pageKey || "unknown";
      if (!byPage[key]) byPage[key] = { pageKey: key, items: [], pageNotes: "" };
      byPage[key].items.push({
        id: rec.id,
        answer: rec.answer,
        choice: rec.choice,
        fill: rec.fill,
      });
    });
    pages.forEach(function (p) {
      var notes = readPageNotes(p.key);
      if (!notes) return;
      if (!byPage[p.key]) byPage[p.key] = { pageKey: p.key, items: [], pageNotes: "" };
      byPage[p.key].pageNotes = notes;
    });
    var pageList = Object.keys(byPage).map(function (k) {
      return byPage[k];
    });
    if (!pageList.length) {
      alert("אין תשובות לייצוא");
      return;
    }
    var flat = [];
    pageList.forEach(function (pg) {
      pg.items.forEach(function (it) {
        flat.push(it);
      });
    });
    var payload = {
      schemaVersion: 2,
      schema: cfg.schema || "excel-v2",
      exportType: cfg.exportType || "eyal-s006-tracker-answers",
      exportTimestamp: new Date().toISOString(),
      respondent: ($("respondent") && $("respondent").value.trim()) || cfg.defaultRespondent || "",
      sourceGeneratedAt: cfg.generatedAt || "",
      pages: pageList,
      answers: flat,
    };
    var blob = new Blob([JSON.stringify(payload, null, 2)], {
      type: "application/json;charset=utf-8",
    });
    var a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = "eyal-s006-excel-answers-" + isoStamp() + ".json";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(a.href);
  }

  function filterPattern(pid) {
    var pageEls = document.querySelectorAll(".s006-page");
    pageEls.forEach(function (page) {
      var cards = page.querySelectorAll(".s006-item--need");
      var visible = 0;
      cards.forEach(function (card) {
        var show = !pid || card.getAttribute("data-pattern") === pid;
        card.hidden = !show;
        if (show) visible += 1;
      });
      if (pid) {
        page.hidden = visible === 0;
      } else {
        page.hidden = false;
      }
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
  pages.forEach(function (p) {
    var el = $("pagenotes-" + p.key);
    if (el && stored.pageNotes && stored.pageNotes[p.key]) {
      el.value = stored.pageNotes[p.key];
    }
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
