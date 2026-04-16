/**
 * Hub — generic form exports (eyal-questions, eyal-drive-intake, eyal-meeting-snapshot).
 */
(function () {
  "use strict";
  var SCHEMA_VERSION = 1;

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
    a.download = (prefix || "hub-export") + "-" + safeTimestamp() + ".json";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(a.href);
  }

  function respondentVal() {
    var el = $("respondent");
    return el && el.value ? String(el.value).trim() : "";
  }

  window.HubFormExports = {
    initQuestions: function (config) {
      config = config || {};
      var btn = $("btn-export-questions");
      if (!btn) return;
      btn.addEventListener("click", function () {
        var fields = config.formFields || [];
        var answers = [];
        for (var i = 0; i < fields.length; i++) {
          var f = fields[i];
          var fid = f.id;
          if (!fid) continue;
          var el = $("q-field-" + fid);
          if (!el) continue;
          var v;
          if (f.type === "checkbox") {
            v = el.checked;
          } else {
            v = String(el.value || "").trim();
          }
          answers.push({ fieldId: fid, value: v });
        }
        var payload = {
          schemaVersion: SCHEMA_VERSION,
          exportType: config.exportType || "eyal-questions",
          exportTimestamp: new Date().toISOString(),
          respondent: respondentVal(),
          answers: answers,
        };
        downloadJson(payload, config.exportType || "eyal-questions");
      });
    },

    initDriveIntake: function (config) {
      config = config || {};
      var btn = $("btn-export-drive-intake");
      if (!btn) return;
      btn.addEventListener("click", function () {
        var payload = {
          schemaVersion: SCHEMA_VERSION,
          exportType: config.exportType || "eyal-drive-intake",
          exportTimestamp: new Date().toISOString(),
          respondent: respondentVal(),
          driveFileName: ($("drive-field-name") && $("drive-field-name").value.trim()) || "",
          contextHe: ($("drive-field-context") && $("drive-field-context").value.trim()) || "",
          dateOptional: ($("drive-field-date") && $("drive-field-date").value.trim()) || "",
        };
        downloadJson(payload, config.exportType || "eyal-drive-intake");
      });
    },

    initMeetingSnapshot: function (config) {
      config = config || {};
      var btn = $("btn-export-meeting-snapshot");
      if (!btn) return;
      btn.addEventListener("click", function () {
        var rawEl = $("hub-meeting-brief-data");
        var sourceFields = {};
        try {
          if (rawEl && rawEl.textContent) {
            sourceFields = JSON.parse(rawEl.textContent);
          }
        } catch (e) {
          sourceFields = {};
        }
        var bodyEl = $("meeting-snapshot-body");
        var snapshotBodyHe = bodyEl ? String(bodyEl.value || "").trim() : "";
        var payload = {
          schemaVersion: SCHEMA_VERSION,
          exportType: config.exportType || "eyal-meeting-snapshot",
          exportTimestamp: new Date().toISOString(),
          respondent: respondentVal(),
          meetingDate: sourceFields.meetingDate || "",
          snapshotBodyHe: snapshotBodyHe,
          sourceFields: sourceFields,
        };
        downloadJson(payload, config.exportType || "eyal-meeting-snapshot");
      });
    },
  };
})();
