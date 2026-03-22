const state = {
  xp: 260,
  level: 4,
  streak: 7,
  mode: 'blocks',
  commands: [],
  missionIndex: 0,
  missions: [
    { title: 'Robotu hedefe ulaştır', goal: { x: 3, y: 2 }, hint: 'Sag don ve 1 adim ileri dene.' },
    { title: 'Engelden kac ve hedefe git', goal: { x: 5, y: 4 }, hint: 'Once asagi inip saga acil.' },
    { title: 'repeat kullanarak bitir', goal: { x: 1, y: 5 }, hint: 'Tekrarlayan hareketleri repeat ile kisalt.' }
  ],
  badges: [
    { id: 'loop', name: 'Loop Master', icon: '🔁', unlocked: true },
    { id: 'debug', name: 'Debug Hero', icon: '🛠', unlocked: false },
    { id: 'robot', name: 'Robot Commander', icon: '🤖', unlocked: false }
  ],
  robot: { x: 0, y: 0, dir: 1 },
  obstacles: [{ x: 2, y: 1 }, { x: 2, y: 2 }, { x: 4, y: 3 }],
  grid: 6
};

const statsData = [
  { label: 'Son Kod', value: 'forward()' },
  { label: 'Basarili Gorev', value: '12' },
  { label: 'Debug Orani', value: '%81' },
  { label: 'Robot Calistirma', value: '47' }
];

const $ = (s) => document.querySelector(s);
const $$ = (s) => [...document.querySelectorAll(s)];
const canvas = $('#sim-canvas');
const ctx = canvas.getContext('2d');
const cell = 70;
let running = false;

function renderTop() {
  $('#xp').textContent = state.xp;
  $('#level').textContent = state.level;
  $('#streak').textContent = state.streak;
  $('#xp-bar').style.width = `${Math.min(100, (state.xp % 1000) / 10)}%`;
  $('#daily-mission').textContent = `Bugunku Gorev: ${state.missions[state.missionIndex].title}`;
}

function renderStats() {
  $('#stats-cards').innerHTML = statsData.map(s => `<article class="soft-card"><div class="label">${s.label}</div><div class="value">${s.value}</div></article>`).join('');
}

function renderBadges() {
  $('#badges').innerHTML = state.badges.map(b => `<div class="badge ${b.unlocked ? 'on' : ''}">${b.icon} ${b.name}</div>`).join('');
}

function renderMissions() {
  $('#missions').innerHTML = state.missions.map((m, i) => `
    <button class="mission ${i === state.missionIndex ? 'active' : ''}" data-mission="${i}">
      <strong>${i + 1}. ${m.title}</strong>
    </button>
  `).join('');

  $$('.mission').forEach(btn => btn.onclick = () => {
    state.missionIndex = Number(btn.dataset.mission);
    resetRobot();
    renderMissions();
    renderTop();
    draw();
  });
}

function resetRobot() {
  state.robot = { x: 0, y: 0, dir: 1 };
  $('#sim-status').textContent = 'Hazir';
  $('#output').textContent = 'Cikti: Robot bekliyor...';
}

function drawGrid() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  for (let y = 0; y < state.grid; y++) {
    for (let x = 0; x < state.grid; x++) {
      ctx.fillStyle = '#0f172a';
      ctx.fillRect(x * cell, y * cell, cell - 2, cell - 2);
    }
  }
}

function drawEntities() {
  const g = state.missions[state.missionIndex].goal;
  ctx.fillStyle = '#22c55e';
  ctx.fillRect(g.x * cell + 14, g.y * cell + 14, cell - 28, cell - 28);

  state.obstacles.forEach(o => {
    ctx.fillStyle = '#ef4444';
    ctx.fillRect(o.x * cell + 10, o.y * cell + 10, cell - 20, cell - 20);
  });

  const r = state.robot;
  ctx.fillStyle = '#38bdf8';
  ctx.beginPath();
  ctx.arc(r.x * cell + cell / 2, r.y * cell + cell / 2, 18, 0, Math.PI * 2);
  ctx.fill();
}

function draw() {
  drawGrid();
  drawEntities();
}

function parseCode(raw) {
  const lines = raw.split('\n').map(l => l.trim()).filter(Boolean);
  const cmds = [];
  for (const line of lines) {
    if (line.startsWith('forward')) cmds.push('forward');
    else if (line.startsWith('left')) cmds.push('left');
    else if (line.startsWith('right')) cmds.push('right');
    else if (line.startsWith('repeat')) {
      const m = line.match(/repeat\((\d+),\s*(forward|left|right)\)/);
      if (m) {
        const n = Number(m[1]);
        for (let i = 0; i < n; i++) cmds.push(m[2]);
      }
    }
  }
  return cmds;
}

function moveForward() {
  const d = state.robot.dir;
  if (d === 0) state.robot.y -= 1;
  if (d === 1) state.robot.x += 1;
  if (d === 2) state.robot.y += 1;
  if (d === 3) state.robot.x -= 1;
}

function turnLeft() { state.robot.dir = (state.robot.dir + 3) % 4; }
function turnRight() { state.robot.dir = (state.robot.dir + 1) % 4; }

function outOfBounds() {
  return state.robot.x < 0 || state.robot.y < 0 || state.robot.x >= state.grid || state.robot.y >= state.grid;
}

function hitObstacle() {
  return state.obstacles.some(o => o.x === state.robot.x && o.y === state.robot.y);
}

function goalReached() {
  const g = state.missions[state.missionIndex].goal;
  return state.robot.x === g.x && state.robot.y === g.y;
}

async function runCommands(commands) {
  if (running) return;
  running = true;
  resetRobot();
  $('#sim-status').textContent = 'Calisiyor';

  for (const c of commands) {
    if (c === 'forward') moveForward();
    if (c === 'left') turnLeft();
    if (c === 'right') turnRight();

    draw();
    await new Promise(r => setTimeout(r, 360));

    if (outOfBounds() || hitObstacle()) {
      $('#sim-status').textContent = 'Hata';
      $('#output').textContent = 'Cikti: Robot duvara/engele carpti.';
      $('#hint-box').textContent = `Ipucu: ${state.missions[state.missionIndex].hint}`;
      running = false;
      return;
    }
  }

  if (goalReached()) {
    state.xp += 40;
    if (state.xp % 200 < 40) state.level += 1;
    state.badges.find(b => b.id === 'robot').unlocked = true;
    $('#sim-status').textContent = 'Basarili';
    $('#output').textContent = 'Cikti: Hedefe ulasildi! +40 XP';
    renderTop();
    renderBadges();
  } else {
    $('#sim-status').textContent = 'Eksik';
    $('#output').textContent = 'Cikti: Kod calisti ama hedefe ulasilmadi.';
    $('#hint-box').textContent = `Ipucu: ${state.missions[state.missionIndex].hint}`;
  }
  running = false;
}

function wire() {
  $$('.mode-btn').forEach(btn => btn.onclick = () => {
    $$('.mode-btn').forEach(x => x.classList.remove('active'));
    btn.classList.add('active');
    state.mode = btn.dataset.mode;
    $('#blocks-panel').classList.toggle('hidden', state.mode !== 'blocks');
    $('#code-panel').classList.toggle('hidden', state.mode !== 'code');
  });

  $$('.cmd-btn').forEach(btn => btn.onclick = () => {
    const c = btn.dataset.cmd;
    if (c === 'loop2') state.commands.push('forward', 'forward');
    else state.commands.push(c);
    $('#block-seq').textContent = state.commands.join(' -> ');
  });

  $('#run-btn').onclick = () => {
    const cmds = state.mode === 'blocks' ? state.commands.slice() : parseCode($('#code-input').value);
    runCommands(cmds);
  };

  $('#reset-btn').onclick = () => {
    state.commands = [];
    $('#block-seq').textContent = '';
    resetRobot();
    draw();
  };

  $('#btn-continue').onclick = () => {
    const next = (state.missionIndex + 1) % state.missions.length;
    state.missionIndex = next;
    renderMissions();
    renderTop();
    resetRobot();
    draw();
  };

  const modal = $('#live-panel-modal');
  $('#btn-open-live-panel').onclick = () => modal.classList.remove('hidden');
  $('#btn-close-live-panel').onclick = () => modal.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
  renderTop();
  renderStats();
  renderBadges();
  renderMissions();
  wire();
  draw();
  startLegacyBridge();
});

function textFrom(doc, id, fallback = '') {
  return doc.getElementById(id)?.textContent?.trim() || fallback;
}

function cloneListItems(doc, sourceId, targetId) {
  const src = doc.getElementById(sourceId);
  const dst = document.getElementById(targetId);
  if (!src || !dst) return;
  const items = [...src.querySelectorAll('.list-item')].slice(0, 6);
  if (!items.length) {
    dst.innerHTML = '<div class="text-slate-400 text-sm">Veri bekleniyor...</div>';
    return;
  }
  dst.innerHTML = items.map((el) => `<div class="bridge-item">${el.innerHTML}</div>`).join('');
}

function syncFromLegacy(doc) {
  const name = textFrom(doc, 'user-fullname', '').replace(/^Hos geldin,?\s*/i, '').trim();
  if (name) document.getElementById('live-name').textContent = name;

  const xpRaw = textFrom(doc, 'student-hero-total-xp', '');
  const levelRaw = textFrom(doc, 'student-hero-level', '');
  const streakRaw = textFrom(doc, 'student-hero-streak', '');
  const xp = Number(String(xpRaw).replace(/[^\d]/g, ''));
  const level = Number(String(levelRaw).replace(/[^\d]/g, ''));
  const streak = Number(String(streakRaw).replace(/[^\d]/g, ''));
  if (Number.isFinite(xp) && xp > 0) state.xp = xp;
  if (Number.isFinite(level) && level > 0) state.level = level;
  if (Number.isFinite(streak) && streak >= 0) state.streak = streak;
  renderTop();

  const avatarImg = doc.querySelector('#user-menu-trigger img, .top-student-avatar img, #leaderboard-list .top-student-avatar img');
  if (avatarImg?.src) document.getElementById('live-avatar').src = avatarImg.src;

  cloneListItems(doc, 'list-student-homework-pending', 'live-homework-pending');
  cloneListItems(doc, 'list-student-homework-completed', 'live-homework-completed');
  cloneListItems(doc, 'list-student-apps-pending', 'live-apps-pending');
  cloneListItems(doc, 'list-student-apps-completed', 'live-apps-completed');
}

function startLegacyBridge() {
  const frame = document.getElementById('legacy-bridge-frame');
  if (!frame) return;
  frame.addEventListener('load', () => {
    const tick = () => {
      try {
        const doc = frame.contentDocument || frame.contentWindow?.document;
        if (doc) syncFromLegacy(doc);
      } catch {}
    };
    tick();
    setInterval(tick, 2500);
  });
}
