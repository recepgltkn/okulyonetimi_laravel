(function () {
  const INSTALL_BUTTON_ID = "pwa-install-btn";
  const INSTALL_SLOT_ID = "login-install-slot";
  const INSTALL_WRAP_ID = "login-install-wrap";
  const INSTALL_STATUS_ID = "login-install-status";
  const INSTALLED_FLAG_KEY = "pwa-installed-flag";
  let deferredPrompt = null;

  function createInstallButton() {
    let button = document.getElementById(INSTALL_BUTTON_ID);
    if (button) return button;

    button = document.createElement("button");
    button.id = INSTALL_BUTTON_ID;
    button.className = "login-install-btn";
    button.type = "button";
    button.textContent = "Uygulamayi Kur";
    button.setAttribute("aria-label", "Uygulamayi cihaza ekle");
    button.style.display = "none";

    const installSlot = document.getElementById(INSTALL_SLOT_ID);
    if (installSlot) {
      installSlot.appendChild(button);
    } else {
      document.body.appendChild(button);
      button.style.position = "fixed";
      button.style.right = "16px";
      button.style.bottom = "16px";
      button.style.zIndex = "9999";
      button.style.padding = "10px 14px";
      button.style.border = "0";
      button.style.borderRadius = "999px";
      button.style.fontWeight = "700";
      button.style.cursor = "pointer";
      button.style.background = "linear-gradient(135deg,#2563eb,#0ea5e9)";
      button.style.color = "#fff";
      button.style.boxShadow = "0 10px 24px rgba(37,99,235,.35)";
    }

    button.addEventListener("click", async () => {
      if (!deferredPrompt) return;
      deferredPrompt.prompt();
      try {
        await deferredPrompt.userChoice;
      } finally {
        deferredPrompt = null;
        button.style.display = "none";
      }
    });

    return button;
  }

  function getInstallStatusElement() {
    return document.getElementById(INSTALL_STATUS_ID);
  }

  function setInstallState(installed, message = "") {
    const button = document.getElementById(INSTALL_BUTTON_ID) || createInstallButton();
    const installWrap = document.getElementById(INSTALL_WRAP_ID);
    const statusEl = getInstallStatusElement();

    if (installWrap) installWrap.style.display = "block";

    if (installed) {
      button.style.display = "none";
      if (statusEl) {
        statusEl.textContent = "Uygulamaniz zaten kurulu.";
        statusEl.classList.add("login-install-status-ok");
        statusEl.style.display = "block";
      }
      return;
    }

    if (statusEl) {
      statusEl.textContent = message || "";
      statusEl.classList.remove("login-install-status-ok");
      statusEl.style.display = message ? "block" : "none";
    }
  }

  function registerServiceWorker() {
    if (!("serviceWorker" in navigator)) return;
    window.addEventListener("load", () => {
      const scriptUrl = (() => {
        try {
          if (document.currentScript && document.currentScript.src) {
            return new URL(document.currentScript.src, window.location.href);
          }
        } catch (_) {}
        try {
          const scripts = Array.from(document.scripts || []);
          const found = scripts.find((s) => String(s.src || "").includes("/pwa-init.js"));
          if (found && found.src) return new URL(found.src, window.location.href);
        } catch (_) {}
        return null;
      })();

      const candidates = (() => {
        const list = [];
        if (scriptUrl) {
          list.push(new URL("service-worker.js", scriptUrl).toString());
        }
        const metaBaseUrl = String(
          document.querySelector('meta[name="app-base-url"]')?.content || ""
        ).trim().replace(/\/+$/, "");
        if (metaBaseUrl) {
          try {
            const parsed = new URL(metaBaseUrl, window.location.origin);
            const root = `${parsed.origin}${parsed.pathname}`.replace(/\/+$/, "");
            list.push(`${root}/service-worker.js`);
            list.push(`${root}/public/service-worker.js`);
          } catch (_) {}
        }
        list.push(`${window.location.origin}/service-worker.js`);
        list.push(`${window.location.origin}/public/service-worker.js`);
        return Array.from(new Set(list));
      })();

      (async () => {
        try {
          const registrations = await navigator.serviceWorker.getRegistrations();
          await Promise.all(
            registrations
              .filter((registration) => {
                const scope = String(registration.scope || "");
                const activeScript = String(registration.active?.scriptURL || registration.waiting?.scriptURL || registration.installing?.scriptURL || "");
                return scope.includes("/public/") || activeScript.includes("/public/service-worker.js");
              })
              .map((registration) => registration.unregister())
          );
        } catch (_) {}

        for (const swUrl of candidates) {
          try {
            const registration = await navigator.serviceWorker.register(swUrl);
            window.__APP_SW_REGISTRATION__ = registration;
            return;
          } catch (_) {}
        }
      })();
    });
  }

  function setupInstallPrompt() {
    const button = createInstallButton();
    const installWrap = document.getElementById(INSTALL_WRAP_ID);
    const installed = supportsPwaContext() || localStorage.getItem(INSTALLED_FLAG_KEY) === "1";

    if (installed) {
      setInstallState(true);
      return;
    }

    setInstallState(false);
    button.style.display = "inline-flex";
    button.style.alignItems = "center";
    button.style.gap = "8px";
    if (installWrap) installWrap.style.display = "block";

    if (isIos()) {
      button.addEventListener("click", function () {
        setInstallState(false, 'iPhone/iPad: Safari > Paylas > "Ana Ekrana Ekle".');
      });
      return;
    }

    window.addEventListener("beforeinstallprompt", (event) => {
      deferredPrompt = event;
      setInstallState(false);
    });

    button.addEventListener("click", function () {
      if (!deferredPrompt) {
        setInstallState(false, 'Tarayici menusu > "Ana ekrana ekle" adimini kullanin.');
      }
    });

    window.addEventListener("appinstalled", () => {
      deferredPrompt = null;
      try { localStorage.setItem(INSTALLED_FLAG_KEY, "1"); } catch (_) {}
      setInstallState(true);
    });
  }

  function isIos() {
    return /iphone|ipad|ipod/i.test(window.navigator.userAgent);
  }

  function supportsPwaContext() {
    const standaloneMedia = window.matchMedia && window.matchMedia("(display-mode: standalone)").matches;
    const iosStandalone = window.navigator.standalone === true;
    return standaloneMedia || iosStandalone;
  }

  registerServiceWorker();

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", function () {
      setupInstallPrompt();
    });
  } else {
    setupInstallPrompt();
  }
})();
