const API_BASE = "/api/client";

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

