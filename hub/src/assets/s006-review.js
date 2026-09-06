/**
 * S006 review form — page approvals (Round 1 close) + leftover Excel answers.
 * schema round1-approval-v1 · local draft in localStorage.
 */
(function () {
  "use strict";
  var cfg = window.S006_CONFIG || {};
  var LS = cfg.storageKey || "ea-s006-review-v2";
  var items = cfg.items || [];
  var pages = cfg.pages || [];
  var DECIDED = { "אושר למסך מחשב": 1, "יש תיקון": 1 };

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

  function basename(name) {
    return String(name || "").replace(/^.*[\\/]/, "").trim();
  }

  function readPageNotes(key) {
    var el = $("pagenotes-" + key);
    return el ? String(el.value || "").trim() : "";
  }

  function readPageFile(key) {
    var el = $("pagefile-" + key);
    return el ? basename(el.value) : "";
  }

  function readApproval(page) {
    var key = page.key;
    var name = "approve-" + key;
    var radios = document.getElementsByName(name);
    var choice = "";
    var status = "";
    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) {
        choice = radios[i].value;
        status = radios[i].getAttribute("data-status") || "";
        break;
      }
    }
    return {
      pageKey: key,
      path: page.path || "",
      title: page.title || "",
      choice: choice,
      approvalStatus: status,
      notes: readPageNotes(key),
      pageFileName: readPageFile(key),
    };
  }

  function applyApproval(page, rec) {
    if (!rec) return;
    if (rec.choice) {
      var radios = document.getElementsByName("approve-" + page.key);
      for (var i = 0; i < radios.length; i++) {
        radios[i].checked = radios[i].value === rec.choice;
      }
    }
    var fileEl = $("pagefile-" + page.key);
    if (fileEl && (rec.pageFileName || rec.fileName)) {
      fileEl.value = basename(rec.pageFileName || rec.fileName);
    }
  }

  var nimrodItems = cfg.nimrodItems || [];

  function readNimrod(it) {
    return readItem(it);
  }

  function snapshot() {
    var out = {
      respondent: ($("respondent") && $("respondent").value) || "",
      answers: {},
      pageNotes: {},
      pageFiles: {},
      pageApprovals: {},
      nimrodAnswers: {},
    };
    items.forEach(function (it) {
      out.answers[it.id] = readItem(it);
    });
    pages.forEach(function (p) {
      out.pageNotes[p.key] = readPageNotes(p.key);
      out.pageFiles[p.key] = readPageFile(p.key);
      if (p.key !== "GENERAL") {
        out.pageApprovals[p.key] = readApproval(p);
      }
    });
    nimrodItems.forEach(function (it) {
      out.nimrodAnswers[it.id] = readNimrod(it);
    });
    return out;
  }

  function nimrodAnsweredCount() {
    var n = 0;
    nimrodItems.forEach(function (it) {
      var rec = readNimrod(it);
      if (rec.answer || rec.choice || rec.fill) n += 1;
    });
    return n;
  }

  function refreshNimrodProgress() {
    var el = $("s006-nimrod-progress");
    if (!el) return;
    el.textContent = nimrodAnsweredCount() + " מתוך " + nimrodItems.length + " הכרעות";
  }

  function persist() {
    save(snapshot());
    refreshProgress();
    refreshNimrodProgress();
  }

  var nimrodFileUrl = "";

  function exportNimrodJson() {
    var recs = [];
    var decided = 0;
    nimrodItems.forEach(function (it) {
      var rec = readNimrod(it);
      if (rec.answer || rec.choice || rec.fill) decided += 1;
      recs.push({
        id: it.id,
        pageKey: rec.pageKey || it.pageKey || "",
        title: it.title || "",
        ask: it.ask || "",
        path: it.path || "",
        answer: rec.answer,
        choice: rec.choice,
        fill: rec.fill,
      });
    });
    if (!nimrodItems.length) {
      alert("אין שאלות לנימרוד בטופס");
      return;
    }
    var payload = {
      schemaVersion: 2,
      exportType: "nimrod-s006-decisions",
      round: "s006-r2-map",
      complete: true,
      exportTimestamp: new Date().toISOString(),
      sourceGeneratedAt: cfg.generatedAt || "",
      decidedCount: decided,
      total: nimrodItems.length,
      decisions: recs,
    };
    var blob = new Blob([JSON.stringify(payload, null, 2)], {
      type: "application/json;charset=utf-8",
    });
    var filename = "nimrod-s006-answers-complete-" + isoStamp() + ".json";
    if (nimrodFileUrl) {
      URL.revokeObjectURL(nimrodFileUrl);
    }
    nimrodFileUrl = URL.createObjectURL(blob);
    var a = document.createElement("a");
    a.href = nimrodFileUrl;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    var wrap = $("s006-nimrod-file");
    var link = $("s006-nimrod-file-a");
    if (wrap && link) {
      link.href = nimrodFileUrl;
      link.download = filename;
      link.textContent = "תקבלו קובץ תשובות מלא";
      wrap.hidden = false;
    }
  }

  function approvalPages() {
    return pages.filter(function (p) {
      return p.key !== "GENERAL" && !p.skipApproval;
    });
  }

  function notePages() {
    return pages.filter(function (p) {
      return p.key !== "GENERAL";
    });
  }

  function decidedCount() {
    var n = 0;
    approvalPages().forEach(function (p) {
      var rec = readApproval(p);
      if (DECIDED[rec.choice]) n += 1;
    });
    return n;
  }

  function itemAnsweredCount() {
    var n = 0;
    items.forEach(function (it) {
      var rec = readItem(it);
      if (rec.answer || rec.choice || rec.fill) n += 1;
    });
    return n;
  }

  function refreshProgress() {
    var el = $("s006-progress");
    if (!el) return;
    var ap = approvalPages();
    var text = decidedCount() + " מתוך " + ap.length + " עמודים סומנו";
    if (items.length) {
      text += " · " + itemAnsweredCount() + " מתוך " + items.length + " שאלות תוכן";
    }
    el.textContent = text;
  }

  function isoStamp() {
    return new Date().toISOString().replace(/\.\d{3}Z$/, "Z").replace(/:/g, "-");
  }

  function exportJson() {
    var byPage = {};
    var pageApprovals = [];
    notePages().forEach(function (p) {
      var rec = readApproval(p);
      if (rec.choice || rec.notes || rec.pageFileName) {
        pageApprovals.push(rec);
        byPage[p.key] = {
          pageKey: p.key,
          path: rec.path,
          title: rec.title,
          approval: rec.choice,
          approvalStatus: rec.approvalStatus,
          items: [],
          pageNotes: rec.notes,
          pageFileName: rec.pageFileName || "",
        };
      }
    });
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
    var generalNotes = readPageNotes("GENERAL");
    if (generalNotes) {
      if (!byPage.GENERAL) byPage.GENERAL = { pageKey: "GENERAL", items: [], pageNotes: "" };
      byPage.GENERAL.pageNotes = generalNotes;
    }
    var pageList = Object.keys(byPage).map(function (k) {
      return byPage[k];
    });
    if (!pageList.length) {
      alert("אין תשובות לייצוא — סמנו לפחות עמוד אחד, או כתבו הערה.");
      return;
    }
    var flat = [];
    pageList.forEach(function (pg) {
      (pg.items || []).forEach(function (it) {
        flat.push(it);
      });
    });
    var payload = {
      schemaVersion: 3,
      schema: cfg.schema || "round1-approval-v1",
      exportType: cfg.exportType || "eyal-s006-tracker-answers",
      exportTimestamp: new Date().toISOString(),
      respondent: ($("respondent") && $("respondent").value.trim()) || cfg.defaultRespondent || "",
      sourceGeneratedAt: cfg.generatedAt || "",
      decidedPages: decidedCount(),
      submittedPages: approvalPages().length,
      pageApprovals: pageApprovals,
      pages: pageList,
      answers: flat,
    };
    var blob = new Blob([JSON.stringify(payload, null, 2)], {
      type: "application/json;charset=utf-8",
    });
    var a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = (cfg.exportFilePrefix || "eyal-s006-excel-answers-") + isoStamp() + ".json";
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
    document.querySelectorAll(".s006-chapter").forEach(function (ch) {
      var any = false;
      ch.querySelectorAll(".s006-page").forEach(function (page) {
        if (!page.hidden) any = true;
      });
      ch.hidden = pid ? !any : false;
    });
    document.querySelectorAll(".s006-chip").forEach(function (btn) {
      btn.classList.toggle("is-on", (btn.getAttribute("data-filter") || "") === pid);
    });
  }

  function onFormChange(ev) {
    var t = ev && ev.target;
    if (t && t.classList && t.classList.contains("s006-filepick")) {
      var dest = $(t.getAttribute("data-target") || "");
      if (dest && t.files && t.files[0]) {
        dest.value = basename(t.files[0].name);
      }
      t.value = "";
    }
    persist();
  }

  document.addEventListener("change", onFormChange);
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
    var fileEl = $("pagefile-" + p.key);
    if (fileEl && stored.pageFiles && stored.pageFiles[p.key]) {
      fileEl.value = basename(stored.pageFiles[p.key]);
    }
    applyApproval(p, stored.pageApprovals && stored.pageApprovals[p.key]);
  });
  nimrodItems.forEach(function (it) {
    applyItem(it, stored.nimrodAnswers && stored.nimrodAnswers[it.id]);
  });
  refreshProgress();
  refreshNimrodProgress();

  var btn = $("btn-export-s006");
  if (btn) btn.addEventListener("click", exportJson);
  var nbtn = $("btn-export-nimrod");
  if (nbtn) nbtn.addEventListener("click", exportNimrodJson);

  document.querySelectorAll(".s006-chip").forEach(function (btn) {
    btn.addEventListener("click", function () {
      filterPattern(btn.getAttribute("data-filter") || "");
    });
  });

  function openAncestors(el) {
    var p = el;
    while (p) {
      if (p.tagName === "DETAILS") p.open = true;
      p = p.parentElement;
    }
  }

  function scrollWindowTo(y) {
    var top = Math.max(0, y);
    if (window.scrollTo) {
      try {
        window.scrollTo({ top: top, left: 0, behavior: "auto" });
      } catch (e) {
        window.scrollTo(0, top);
      }
    }
    if (document.documentElement) document.documentElement.scrollTop = top;
    if (document.body) document.body.scrollTop = top;
  }

  function revealTarget(el) {
    if (!el) return;
    openAncestors(el);
    function go() {
      if (el.id === "s006-top") {
        scrollWindowTo(0);
        return;
      }
      var offset = 96;
      var y = el.getBoundingClientRect().top + (window.scrollY || window.pageYOffset || 0) - offset;
      scrollWindowTo(y);
    }
    go();
    if (window.requestAnimationFrame) {
      window.requestAnimationFrame(function () {
        window.requestAnimationFrame(go);
      });
    }
  }

  function revealHash() {
    var id = (location.hash || "").replace(/^#/, "");
    if (!id) return;
    revealTarget(document.getElementById(id));
  }

  document.addEventListener("click", function (ev) {
    var t = ev.target;
    var a = t && t.closest ? t.closest("a.s006-sitemap__card, a.s006-backtop") : null;
    if (!a) return;
    var href = a.getAttribute("href") || "";
    if (href.charAt(0) !== "#") return;
    var el = document.getElementById(href.slice(1));
    if (!el) return;
    ev.preventDefault();
    if (location.hash !== href) {
      if (history.pushState) history.pushState(null, "", href);
      else location.hash = href;
    }
    revealTarget(el);
  });
  window.addEventListener("hashchange", revealHash);
  revealHash();
})();
