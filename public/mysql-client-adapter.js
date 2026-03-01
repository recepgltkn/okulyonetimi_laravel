const API_BASE = "/api/client";
const AUTH_KEY = "mysql_auth_user";
const WATCH_INTERVAL_MS = 2500;

let currentUser = null;
const authListeners = new Set();
const watchRegistry = new Map();
const authInstances = new Set();

try {
  const raw = localStorage.getItem(AUTH_KEY);
  if (raw) currentUser = JSON.parse(raw);
} catch {}

function persistAuthUser(user) {
  currentUser = user || null;
  for (const auth of authInstances) {
    auth.currentUser = currentUser;
  }
  try {
    if (currentUser) localStorage.setItem(AUTH_KEY, JSON.stringify(currentUser));
    else localStorage.removeItem(AUTH_KEY);
  } catch {}
  for (const cb of authListeners) {
    try { cb(currentUser); } catch {}
  }
}

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

function makeDocSnapshot(docPayloadOrNull) {
  return {
    id: docPayloadOrNull?.id || "",
    exists() { return !!docPayloadOrNull; },
    data() { return docPayloadOrNull ? { ...(docPayloadOrNull.data || {}) } : undefined; },
  };
}

function makeQuerySnapshot(docs) {
  const list = Array.isArray(docs) ? docs : [];
  const wrapped = list.map((d) => makeDocSnapshot(d));
  wrapped.forEach((w, i) => { w.id = list[i]?.id || ""; });
  return {
    docs: wrapped,
    size: wrapped.length,
    empty: wrapped.length === 0,
    forEach(cb) { wrapped.forEach(cb); },
  };
}

function serializeTarget(target) {
  if (target?.type === "doc") return `doc:${target.path}`;
  if (target?.type === "collection") return `collection:${target.path}`;
  if (target?.type === "collectionGroup") return `collectionGroup:${target.name}`;
  if (target?.type === "query") return `query:${JSON.stringify(target)}`;
  return `unknown:${JSON.stringify(target || {})}`;
}

async function fetchTarget(target) {
  if (target?.type === "doc") {
    const path = encodeURIComponent(target?.path || "");
    const res = await api(`/docs/get?path=${path}`, "GET");
    return { kind: "doc", snapshot: makeDocSnapshot(res?.exists ? res.doc : null) };
  }
  const snap = await getDocs(target);
  return { kind: "query", snapshot: snap };
}

function subscribeWatch(target, cb) {
  const key = serializeTarget(target);
  let watcher = watchRegistry.get(key);
  if (!watcher) {
    watcher = { target, cbs: new Set(), timer: null, lastSig: "" };
    watchRegistry.set(key, watcher);
  }
  watcher.cbs.add(cb);

  const tick = async () => {
    if (!watchRegistry.has(key)) return;
    try {
      const result = await fetchTarget(target);
      const sig = result.kind === "doc"
        ? JSON.stringify(result.snapshot.data() || null)
        : JSON.stringify((result.snapshot.docs || []).map((d) => d.data()));
      if (sig !== watcher.lastSig) {
        watcher.lastSig = sig;
        for (const fn of watcher.cbs) {
          try { fn(result.snapshot); } catch {}
        }
      }
    } catch {}
    watcher.timer = setTimeout(tick, WATCH_INTERVAL_MS);
  };

  if (!watcher.timer) tick();

  return () => {
    const current = watchRegistry.get(key);
    if (!current) return;
    current.cbs.delete(cb);
    if (current.cbs.size === 0) {
      if (current.timer) clearTimeout(current.timer);
      watchRegistry.delete(key);
    }
  };
}

export function initializeApp(config, name = "default") { return { config, name }; }
export function getAuth(app) {
  const auth = { app, kind: "auth", currentUser };
  authInstances.add(auth);
  return auth;
}
export function getStore(app) { return { app, kind: "db" }; }
export function getFunctions(app) { return { app, kind: "functions" }; }
export function serverTimestamp() { return { __op: "serverTimestamp" }; }
export function increment(by) { return { __op: "increment", by: Number(by || 0) }; }
export function doc(_db, ...segments) { return { type: "doc", path: segments.map((s) => String(s || "").trim()).filter(Boolean).join("/") }; }
export function collection(_db, ...segments) { return { type: "collection", path: segments.map((s) => String(s || "").trim()).filter(Boolean).join("/") }; }
export function collectionGroup(_db, name) { return { type: "collectionGroup", name: String(name || "").trim() }; }
export function where(field, op, value) { return { type: "where", field, op, value }; }
export function orderBy(field, direction = "asc") { return { type: "orderBy", field, direction }; }
export function limit(count) { return { type: "limit", count: Number(count || 0) }; }
export function query(source, ...constraints) { return { type: "query", source, constraints: constraints.filter(Boolean) }; }

export async function setDoc(docRef, data, options = {}) {
  await api("/docs/set", "POST", { path: docRef?.path || "", data: data || {}, merge: !!options?.merge });
}
export async function updateDoc(docRef, data) {
  await api("/docs/update", "POST", { path: docRef?.path || "", data: data || {} });
}
export async function getDoc(docRef) {
  const path = encodeURIComponent(docRef?.path || "");
  const res = await api(`/docs/get?path=${path}`, "GET");
  return makeDocSnapshot(res?.exists ? res.doc : null);
}
export async function deleteDoc(docRef) {
  await api("/docs/delete", "POST", { path: docRef?.path || "" });
}
export async function addDoc(collectionRef, data) {
  const res = await api("/docs/add", "POST", { collectionPath: collectionRef?.path || "", data: data || {} });
  const d = res?.doc || {};
  return { id: d.id, path: d.path, type: "doc" };
}

export async function getDocs(input) {
  if (input?.type === "collection") {
    const res = await api("/docs/query", "POST", { source: { type: "collection", path: input.path }, constraints: [] });
    return makeQuerySnapshot(res?.docs || []);
  }
  if (input?.type === "query") {
    const source = input.source?.type === "collectionGroup"
      ? { type: "collectionGroup", name: input.source.name }
      : { type: "collection", path: input.source?.path || "" };
    const res = await api("/docs/query", "POST", { source, constraints: input.constraints || [] });
    return makeQuerySnapshot(res?.docs || []);
  }
  if (input?.type === "collectionGroup") {
    const res = await api("/docs/query", "POST", { source: { type: "collectionGroup", name: input.name }, constraints: [] });
    return makeQuerySnapshot(res?.docs || []);
  }
  return makeQuerySnapshot([]);
}

export function onSnapshot(input, cb) {
  return subscribeWatch(input, cb);
}

export function writeBatch(_db) {
  const ops = [];
  return {
    set(ref, data, options = {}) { ops.push({ kind: "set", path: ref?.path || "", data: data || {}, merge: !!options?.merge }); },
    update(ref, data) { ops.push({ kind: "update", path: ref?.path || "", data: data || {} }); },
    delete(ref) { ops.push({ kind: "delete", path: ref?.path || "" }); },
    async commit() { await api("/docs/batch", "POST", { ops }); },
  };
}

export async function signInWithEmailAndPassword(_auth, email, password) {
  const res = await api("/auth/login", "POST", { identifier: email, password });
  const user = res?.user || null;
  if (!user) throw new Error("Login failed");
  persistAuthUser(user);
  return { user };
}
export async function createUserWithEmailAndPassword(_auth, email, password) {
  const res = await api("/auth/register", "POST", { email, password });
  const user = res?.user || null;
  if (!user) throw new Error("Register failed");
  return { user };
}
export async function updatePassword(user, newPassword) { await api("/auth/update-password", "POST", { uid: user?.uid || user?.id, newPassword }); }
export async function deleteUser(user) { await api("/auth/delete-user", "POST", { uid: user?.uid || user?.id }); }
export function onAuthStateChanged(_auth, cb) { authListeners.add(cb); setTimeout(() => cb(currentUser), 0); return () => authListeners.delete(cb); }
export async function signOut(_auth) { persistAuthUser(null); }
export function httpsCallable(_functions, name) {
  return async (data = {}) => {
    const res = await api(`/callable/${encodeURIComponent(String(name || ""))}`, "POST", { data });
    return { data: res?.data };
  };
}


