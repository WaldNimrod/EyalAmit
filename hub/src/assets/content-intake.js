/**
 * Per-page content intake export — Eyal Hub (eyal-page-content-intake).
 */
(function () {
  "use strict";
  var SCHEMA_VERSION = 1;

  function $(id) {
    return document.getElementById(id);
  }

  function parseJsonScript(id) {
    var el = $(id);
    if (!el || !el.textContent) return null;
    try {
      return JSON.parse(el.textContent);
    } catch (e) {
      return null;
    }
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
    a.download = (prefix || "eyal-content-intake") + "-" + safeTimestamp() + ".json";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(a.href);
  }

  function buildTemplateIndex(templatesDoc) {
    var byId = {};
    (templatesDoc.templates || []).forEach(function (t) {
      byId[t.id] = t;
    });
    return byId;
  }

  function renderFields(container, tpl) {
    container.innerHTML = "";
    if (!tpl) {
      container.innerHTML =
        "<p class=\"subtitle\">\u05d0\u05d9\u05df \u05ea\u05d1\u05e0\u05d9\u05ea \u05de\u05e7\u05d5\u05e9\u05e8\u05ea \u05dc\u05e2\u05de\u05d5\u05d3 \u05d6\u05d4.</p>";
      return;
    }
    var p = document.createElement("p");
    p.className = "subtitle";
    p.textContent = tpl.descriptionHe || "";
    container.appendChild(p);
    if (tpl.mockupHref) {
      var linkP = document.createElement("p");
      var a = document.createElement("a");
      a.href = tpl.mockupHref;
      a.target = "_blank";
      a.rel = "noopener";
      a.textContent = "\u05e4\u05ea\u05d7 \u05de\u05d5\u05e7\u05d0\u05e4 \u05ea\u05d1\u05e0\u05d9\u05ea";
      linkP.appendChild(a);
      container.appendChild(linkP);
    }
    (tpl.fields || []).forEach(function (f) {
      var wrap = document.createElement("div");
      wrap.className = "feedback-field";
      var lab = document.createElement("label");
      lab.setAttribute("for", "intake-f-" + f.id);
      lab.textContent = f.labelHe || f.id;
      wrap.appendChild(lab);
      var input;
      if (f.type === "textarea") {
        input = document.createElement("textarea");
        input.rows = 4;
      } else {
        input = document.createElement("input");
        input.type = f.type === "url" ? "url" : "text";
      }
      input.id = "intake-f-" + f.id;
      input.dataset.fieldId = f.id;
      wrap.appendChild(input);
      container.appendChild(wrap);
    });
  }

  window.ContentIntake = {
    init: function (config) {
      config = config || {};
      var tree = parseJsonScript("hub-data-site-tree");
      var templatesDoc = parseJsonScript("hub-data-page-templates");
      if (!tree || !templatesDoc || !tree.nodes) return;

      var byTpl = buildTemplateIndex(templatesDoc);
      var sel = $("page-select");
      var fieldsEl = $("intake-fields");
      var btn = $("btn-export-content-intake");
      if (!sel || !fieldsEl || !btn) return;

      tree.nodes
        .slice()
        .sort(function (a, b) {
          return (a.titleHe || "").localeCompare(b.titleHe || "", "he");
        })
        .forEach(function (n) {
          var o = document.createElement("option");
          o.value = n.id;
          var pref = (n.pageRef || "").trim();
          var label =
            (pref ? "[" + pref + "] " : "") +
            (n.titleHe || "") +
            " — " +
            (n.slug || n.id);
          o.textContent = label;
          sel.appendChild(o);
        });

      function currentNode() {
        var id = sel.value;
        for (var i = 0; i < tree.nodes.length; i++) {
          if (tree.nodes[i].id === id) return tree.nodes[i];
        }
        return null;
      }

      function refresh() {
        var node = currentNode();
        var tid = node && node.templateId;
        renderFields(fieldsEl, tid ? byTpl[tid] : null);
      }

      sel.addEventListener("change", refresh);
      refresh();

      btn.addEventListener("click", function () {
        var node = currentNode();
        if (!node) return;
        var tpl = node.templateId ? byTpl[node.templateId] : null;
        var fieldValues = {};
        if (tpl && tpl.fields) {
          tpl.fields.forEach(function (f) {
            var el = $("intake-f-" + f.id);
            if (el) fieldValues[f.id] = el.value.trim();
          });
        }
        var driveEl = $("drive-refs");
        var driveRaw = driveEl ? driveEl.value.trim() : "";
        var driveRefs = driveRaw
          ? driveRaw.split(/\n+/).map(function (s) {
              return s.trim();
            }).filter(Boolean)
          : [];

        var hasContent =
          driveRefs.length > 0 ||
          Object.keys(fieldValues).some(function (k) {
            return fieldValues[k].length > 0;
          });
        if (!hasContent) {
          alert(
            "\u05d0\u05d9\u05df \u05ea\u05d5\u05db\u05df \u05dc\u05d9\u05d9\u05e6\u05d5\u05d0 \u2014 \u05de\u05dc\u05d0 \u05dc\u05e4\u05d7\u05d5\u05ea \u05e9\u05d3\u05d4 \u05d0\u05d7\u05d3 \u05d0\u05d5 \u05e7\u05d9\u05e9\u05d5\u05e8/\u05e9\u05dd \u05e7\u05d5\u05d1\u05e5 \u05d1\u05beDrive."
          );
          return;
        }

        var payload = {
          schemaVersion: SCHEMA_VERSION,
          exportType: config.exportType || "eyal-page-content-intake",
          exportTimestamp: new Date().toISOString(),
          respondent:
            ($("respondent") && $("respondent").value.trim()) ||
            config.defaultRespondent ||
            "",
          pageId: node.id,
          pageRef: (node.pageRef || "").trim(),
          pageTitleHe: node.titleHe,
          slug: node.slug,
          templateId: node.templateId || "",
          fieldValues: fieldValues,
          driveRefs: driveRefs.length ? driveRefs : driveRaw,
        };
        downloadJson(payload, config.exportType || "eyal-page-content-intake");
      });
    },
  };
})();
