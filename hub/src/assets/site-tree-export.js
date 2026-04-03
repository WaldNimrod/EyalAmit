/**
 * Site tree feedback export — Eyal Hub (eyal-site-tree-feedback).
 * schemaVersion 2: pageRef, per-node KMD, legacy-unmapped KMD rows.
 */
(function () {
  "use strict";
  var SCHEMA_VERSION = 2;

  function $(id) {
    return document.getElementById(id);
  }

  function safeTimestamp() {
    return new Date()
      .toISOString()
      .replace(/\.\d{3}Z$/, "Z")
      .replace(/:/g, "-");
  }

  function downloadJson(obj, prefix) {
    var blob = new Blob([JSON.stringify(obj, null, 2)], {
      type: "application/json;charset=utf-8",
    });
    var a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = (prefix || "eyal-site-tree") + "-" + safeTimestamp() + ".json";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(a.href);
  }

  function readMeta() {
    var el = $("hub-site-tree-meta");
    if (!el || !el.textContent) return {};
    try {
      return JSON.parse(el.textContent);
    } catch (e) {
      return {};
    }
  }

  function buildNodesPayload(config) {
    var metaMap = {};
    (config.nodesMeta || []).forEach(function (m) {
      if (m && m.id) metaMap[m.id] = m.pageRef || "";
    });
    var out = [];
    (config.nodeIds || []).forEach(function (id) {
      var notesEl = $("site-tree-notes-" + id);
      var notes = notesEl ? notesEl.value.trim() : "";
      var kcb = $("site-tree-kmd-" + id);
      var kta = $("site-tree-kmd-notes-" + id);
      var hasKmd = kcb && kta;
      var kmdTracked = hasKmd ? !!kcb.checked : false;
      var kmdNotes = hasKmd && kta.value.trim() ? kta.value.trim() : "";
      out.push({
        id: id,
        pageRef: metaMap[id] || "",
        notes: notes,
        kmdTracked: kmdTracked,
        kmdNotes: kmdNotes,
      });
    });
    return out;
  }

  function buildLegacyPayload(config) {
    var out = [];
    (config.legacyRows || []).forEach(function (row) {
      if (!row || !row.domKey) return;
      var dk = row.domKey;
      var kcb = $("legacy-kmd-wp-" + dk);
      var kta = $("legacy-kmd-notes-wp-" + dk);
      var hasKmd = kcb && kta;
      var kmdTracked = hasKmd ? !!kcb.checked : false;
      var kmdNotes = hasKmd && kta.value.trim() ? kta.value.trim() : "";
      out.push({
        wpId: row.wpId || "",
        kmdTracked: kmdTracked,
        kmdNotes: kmdNotes,
      });
    });
    return out;
  }

  function hasAnythingToExport(generalNotes, nodes, legacyRows) {
    if (generalNotes) return true;
    var i;
    for (i = 0; i < nodes.length; i++) {
      var n = nodes[i];
      if (n.notes) return true;
      if (n.kmdTracked) return true;
      if (n.kmdNotes) return true;
    }
    for (i = 0; i < legacyRows.length; i++) {
      var L = legacyRows[i];
      if (L.kmdTracked) return true;
      if (L.kmdNotes) return true;
    }
    return false;
  }

  window.SiteTreeFeedback = {
    init: function (config) {
      config = config || {};
      var btn = $("btn-export-site-tree");
      if (!btn) return;
      btn.addEventListener("click", function () {
        var meta = readMeta();
        var generalEl = $("site-tree-general-notes");
        var generalNotes = generalEl ? generalEl.value.trim() : "";
        var nodes = buildNodesPayload(config);
        var legacyUnmappedKmd = buildLegacyPayload(config);
        if (!hasAnythingToExport(generalNotes, nodes, legacyUnmappedKmd)) {
          alert(
            "\u05d0\u05d9\u05df \u05ea\u05d5\u05db\u05df \u05dc\u05d9\u05d9\u05e6\u05d5\u05d0 \u2014 \u05de\u05dc\u05d0 \u05d4\u05e2\u05e8\u05d4 \u05db\u05dc\u05dc\u05d9\u05ea, \u05d4\u05e2\u05e8\u05d4 \u05dc\u05e6\u05d5\u05de\u05ea, \u05d0\u05d5 \u05e1\u05d9\u05de\u05d5\u05df / \u05d4\u05e2\u05e8\u05d5\u05ea KMD."
          );
          return;
        }
        var payload = {
          schemaVersion: SCHEMA_VERSION,
          exportType: config.exportType || "eyal-site-tree-feedback",
          exportTimestamp: new Date().toISOString(),
          respondent:
            ($("respondent") && $("respondent").value.trim()) ||
            config.defaultRespondent ||
            "",
          treeVersion: meta.treeApprovedDocRef || "",
          liveSiteBase: meta.liveSiteBase || "",
          generalNotes: generalNotes,
          nodes: nodes,
          legacyUnmappedKmd: legacyUnmappedKmd,
        };
        downloadJson(payload, config.exportType || "eyal-site-tree-feedback");
      });
    },
  };
})();
