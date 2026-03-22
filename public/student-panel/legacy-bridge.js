(function () {
  if (!window.STUDENT_PANEL_MODE) return;

  const CARD_IDS = [
    'student-hero-panel',
    'student-homework-shell',
    'student-apps-shell',
    'leaderboard-section',
    'student-stats-bar'
  ];

  function styleCard(el) {
    if (!el) return;
    el.style.background = '#ffffff';
    el.style.border = '1px solid #dbeafe';
    el.style.borderRadius = '22px';
    el.style.boxShadow = '0 14px 34px rgba(30,41,59,0.14)';
    el.style.padding = el.id === 'student-hero-panel' ? '14px' : (el.style.padding || '12px');
  }

  function applyBridge() {
    const app = document.getElementById('app-screen');
    if (!app || !app.classList.contains('student-view')) return;

    app.style.maxWidth = '1280px';
    app.style.margin = '0 auto';
    app.style.padding = '14px';
    app.style.gap = '14px';

    const header = app.querySelector('.app-header');
    if (header) {
      header.style.background = '#fff';
      header.style.border = '1px solid #e2e8f0';
      header.style.borderRadius = '18px';
      header.style.boxShadow = '0 10px 24px rgba(15,23,42,.10)';
      header.style.padding = '10px 14px';
    }

    CARD_IDS.forEach((id) => styleCard(document.getElementById(id)));

    app.querySelectorAll('.tabs').forEach((tabs) => {
      tabs.style.background = '#eff6ff';
      tabs.style.border = '1px solid #dbeafe';
      tabs.style.borderRadius = '14px';
      tabs.style.padding = '6px';
    });

    app.querySelectorAll('.tab-btn').forEach((btn) => {
      btn.style.borderRadius = '10px';
      btn.style.fontWeight = '800';
      btn.style.padding = '10px 12px';
    });

    app.querySelectorAll('.tab-btn.active').forEach((btn) => {
      btn.style.background = 'linear-gradient(135deg,#7c4dff,#2b90ff)';
      btn.style.color = '#fff';
      btn.style.borderBottomColor = 'transparent';
    });

    app.querySelectorAll('.list-item, .top-student-row').forEach((item) => {
      item.style.borderRadius = '14px';
      item.style.border = '1px solid #e2e8f0';
      item.style.boxShadow = '0 6px 16px rgba(15,23,42,.06)';
    });

    app.querySelectorAll('.btn.btn-primary').forEach((btn) => {
      btn.style.background = 'linear-gradient(135deg,#ff9f43,#ff6b4a)';
      btn.style.borderColor = 'transparent';
      btn.style.color = '#fff';
      btn.style.borderRadius = '12px';
      btn.style.fontWeight = '800';
    });

    app.querySelectorAll('.btn.btn-success').forEach((btn) => {
      btn.style.background = 'linear-gradient(135deg,#2ecc71,#16a34a)';
      btn.style.borderColor = 'transparent';
      btn.style.color = '#fff';
      btn.style.borderRadius = '12px';
      btn.style.fontWeight = '800';
    });
  }

  let runs = 0;
  const timer = setInterval(() => {
    applyBridge();
    runs += 1;
    if (runs > 40) clearInterval(timer);
  }, 250);

  const observer = new MutationObserver(() => applyBridge());
  observer.observe(document.documentElement, { childList: true, subtree: true });

  window.addEventListener('load', applyBridge);
  document.addEventListener('DOMContentLoaded', applyBridge);
})();
