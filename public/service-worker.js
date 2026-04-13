const SW_VERSION = "v1.2.0";
const RUNTIME_CACHE = `runtime-${SW_VERSION}`;
const SHELL_CACHE = `shell-${SW_VERSION}`;
const SCOPE_PATH = new URL(self.registration.scope).pathname.replace(/\/+$/, "");
const withScope = (path) => `${SCOPE_PATH}/${String(path || "").replace(/^\/+/, "")}`;
const OFFLINE_URL = withScope("offline.html");

const SHELL_ASSETS = [
  `${SCOPE_PATH}/`,
  OFFLINE_URL,
  withScope("manifest.json"),
  withScope("pwa-init.js"),
  withScope("logo192.png"),
  withScope("logo512.png"),
  withScope("logo.png"),
  withScope("script.js"),
  withScope("style.css")
];

const AUTH_PATH_PREFIXES = [
  withScope("api/"),
  withScope("sanctum/"),
];

const AUTH_EXACT_PATHS = new Set([
  withScope("login"),
  withScope("logout"),
]);

function isAuthRequest(url) {
  const path = String(url.pathname || "");
  if (AUTH_EXACT_PATHS.has(path)) return true;
  return AUTH_PATH_PREFIXES.some((prefix) => path.startsWith(prefix));
}

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(SHELL_CACHE).then((cache) => cache.addAll(SHELL_ASSETS)).then(() => self.skipWaiting())
  );
});

self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys
          .filter((key) => key !== SHELL_CACHE && key !== RUNTIME_CACHE)
          .map((key) => caches.delete(key))
      )
    ).then(async () => {
      if ("navigationPreload" in self.registration) {
        await self.registration.navigationPreload.enable();
      }
      await self.clients.claim();
    })
  );
});

self.addEventListener("fetch", (event) => {
  const request = event.request;
  if (request.method !== "GET") return;

  const url = new URL(request.url);
  if (url.origin !== self.location.origin) return;
  if (isAuthRequest(url)) {
    event.respondWith(fetch(request));
    return;
  }

  if (request.mode === "navigate") {
    event.respondWith(
      (async () => {
        try {
          const preload = await event.preloadResponse;
          if (preload) return preload;

          return await fetch(request);
        } catch (_error) {
          const cachedShell = await caches.match(withScope(""));
          if (cachedShell) return cachedShell;
          return caches.match(OFFLINE_URL);
        }
      })()
    );
    return;
  }

  if (request.destination === "script" || request.destination === "style" || request.destination === "image" || request.destination === "font") {
    event.respondWith(
      (async () => {
        try {
          const response = await fetch(request);
          if (response && response.ok) {
            const copy = response.clone();
            caches.open(RUNTIME_CACHE).then((cache) => cache.put(request, copy)).catch(() => {});
          }
          return response;
        } catch (_error) {
          const cached = await caches.match(request);
          return cached || fetch(request);
        }
      })()
    );
  }
});

function normalizeNotificationPayload(payload = {}) {
  const title = String(payload.title || "Yeni Bildirim").trim() || "Yeni Bildirim";
  const body = String(payload.body || "").trim();
  const url = String(payload.url || payload.link || `${SCOPE_PATH}/`).trim() || `${SCOPE_PATH}/`;
  const tag = String(payload.tag || `system-notification-${Date.now()}`).trim();
  return {
    title,
    options: {
      body,
      tag,
      renotify: true,
      icon: withScope("logo192.png"),
      badge: withScope("logo192.png"),
      data: {
        url,
      },
    },
  };
}

self.addEventListener("message", (event) => {
  const data = event.data || {};
  if (data?.type !== "SHOW_NOTIFICATION") return;
  const payload = normalizeNotificationPayload(data.payload || {});
  event.waitUntil(self.registration.showNotification(payload.title, payload.options));
});

self.addEventListener("push", (event) => {
  const raw = event.data ? event.data.json() : {};
  const payload = normalizeNotificationPayload(raw || {});
  event.waitUntil(self.registration.showNotification(payload.title, payload.options));
});

self.addEventListener("notificationclick", (event) => {
  event.notification.close();
  const targetUrl = String(event.notification?.data?.url || `${SCOPE_PATH}/`).trim() || `${SCOPE_PATH}/`;
  event.waitUntil(
    clients.matchAll({ type: "window", includeUncontrolled: true }).then((windowClients) => {
      for (const client of windowClients) {
        const clientUrl = new URL(client.url);
        if (clientUrl.pathname === new URL(targetUrl, self.location.origin).pathname && "focus" in client) {
          return client.focus();
        }
      }
      if (clients.openWindow) {
        return clients.openWindow(targetUrl);
      }
      return undefined;
    })
  );
});
