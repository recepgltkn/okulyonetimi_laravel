const META_BASE_URL = String(
  document.querySelector('meta[name="app-base-url"]')?.content || ""
).trim().replace(/\/+$/, "");
const currentDirBase = `${window.location.origin}${String(window.location.pathname || "").replace(/\/+$/, "")}`;
const inferredPublicBase = (() => {
  const path = String(window.location.pathname || "");
  const idx = path.toLowerCase().indexOf("/public/");
  if (idx >= 0) return `${window.location.origin}${path.slice(0, idx + "/public".length)}`;
  if (path.toLowerCase().endsWith("/public")) return `${window.location.origin}${path}`;
  return "";
})();
const metaHasPublic = /\/public$/i.test(META_BASE_URL);
const fallbackPublicBase = /\/public$/i.test(currentDirBase) ? currentDirBase : `${currentDirBase}/public`;
const APP_BASE_URL = (inferredPublicBase || (metaHasPublic ? META_BASE_URL : "") || fallbackPublicBase || window.location.origin).replace(/\/+$/, "");
const API_BASE = `${APP_BASE_URL}/api/client`;

async function api(path, method = "GET", body = null) {
  const res = await fetch(`${API_BASE}${path}`, {
    method,
    headers: { "Content-Type": "application/json" },
    body: body ? JSON.stringify(body) : null,
  });
  const json = await res.json().catch(() => ({}));
  if (!res.ok) throw new Error(json?.message || `HTTP ${res.status}`);
  return json;
}

export async function saveGameState(userId, payload) {
  if (!userId) return;
  await api("/docs/set", "POST", {
    path: `gameStates/${String(userId)}`,
    data: { updatedAt: new Date().toISOString(), payload },
    merge: true,
  });
}

export async function loadGameState(userId) {
  if (!userId) return null;
  const res = await api(`/docs/get?path=${encodeURIComponent(`gameStates/${String(userId)}`)}`, "GET");
  if (!res?.exists) return null;
  return res?.doc?.data?.payload || null;
}

export async function saveStudentReport(userId, report) {
  if (!userId) return;
  await api("/docs/set", "POST", {
    path: `studentReports/${String(userId)}`,
    data: { updatedAt: new Date().toISOString(), ...report },
    merge: true,
  });
}

export function getAuthInstance() {
  return null;
}

export default { saveGameState, loadGameState, saveStudentReport, getAuthInstance };
