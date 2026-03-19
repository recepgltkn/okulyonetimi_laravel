export async function liveQuizApi(path, method = 'GET', body = null) {
  const metaBaseUrl = String(
    document.querySelector('meta[name="app-base-url"]')?.content || ''
  ).trim().replace(/\/+$/, '');
  const currentPath = String(window.location.pathname || '');
  const publicIdx = currentPath.toLowerCase().indexOf('/public/');
  const inferredPublicBase = publicIdx >= 0
    ? `${window.location.origin}${currentPath.slice(0, publicIdx + '/public'.length)}`
    : (currentPath.toLowerCase().endsWith('/public') ? `${window.location.origin}${currentPath}` : '');
  const appBase = (inferredPublicBase || metaBaseUrl || `${window.location.origin}/public`).replace(/\/+$/, '');
  const apiBase = String(window.__MYSQL_CLIENT_API_BASE__ || `${appBase}/api/client`).replace(/\/+$/, '');
  const url = `${apiBase}/live-quiz${path}`;
  const userRaw = localStorage.getItem('mysql_auth_user');
  const user = userRaw ? JSON.parse(userRaw) : null;
  const headers = { 'Content-Type': 'application/json' };
  if (user?.uid || user?.id) headers['X-Client-Uid'] = String(user.uid || user.id);
  if (user?.token) {
    headers['X-Client-Token'] = String(user.token);
    headers['Authorization'] = `Bearer ${user.token}`;
  }
  const res = await fetch(url, {
    method,
    headers,
    body: body ? JSON.stringify(body) : null,
  });
  const json = await res.json().catch(() => ({}));
  if (!res.ok) {
    const err = new Error(json?.message || `HTTP ${res.status}`);
    err.status = res.status;
    throw err;
  }
  return json;
}

export const liveQuizClient = {
  createQuiz: (payload) => liveQuizApi('/quizzes', 'POST', payload),
  listMyQuizzes: () => liveQuizApi('/quizzes', 'GET'),
  updateQuiz: (quizId, payload) => liveQuizApi(`/quizzes/${encodeURIComponent(quizId)}`, 'PUT', payload),
  deleteQuiz: (quizId) => liveQuizApi(`/quizzes/${encodeURIComponent(quizId)}`, 'DELETE'),
  startSession: (payload) => liveQuizApi('/sessions', 'POST', payload),
  getActiveTeacherSession: () => liveQuizApi('/sessions/active/teacher', 'GET'),
  getActiveStudentSession: () => liveQuizApi('/sessions/active/student', 'GET'),
  getSession: (sessionId) => liveQuizApi(`/sessions/${encodeURIComponent(sessionId)}`, 'GET'),
  submitAnswer: (sessionId, payload) => liveQuizApi(`/sessions/${encodeURIComponent(sessionId)}/answer`, 'POST', payload),
  lock: (sessionId) => liveQuizApi(`/sessions/${encodeURIComponent(sessionId)}/lock`, 'POST'),
  unlock: (sessionId) => liveQuizApi(`/sessions/${encodeURIComponent(sessionId)}/unlock`, 'POST'),
  next: (sessionId) => liveQuizApi(`/sessions/${encodeURIComponent(sessionId)}/next`, 'POST'),
  finish: (sessionId) => liveQuizApi(`/sessions/${encodeURIComponent(sessionId)}/finish`, 'POST'),
  leaderboard: (sessionId) => liveQuizApi(`/sessions/${encodeURIComponent(sessionId)}/leaderboard`, 'GET'),
};
