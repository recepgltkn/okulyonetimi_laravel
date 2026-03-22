const defaultState = {
  student: {
    name: 'Deniz',
    level: 12,
    xp: 830,
    xpTarget: 1000,
    streak: 9,
    totalXp: 18420,
    rank: 14,
    avatar: '/avatars/3d/astronaut.png'
  },
  tasks: [
    { id: 1, title: '1 Matematik mini quiz', reward: 40, done: false },
    { id: 2, title: '2 video dersi tamamla', reward: 60, done: true },
    { id: 3, title: 'Fen görev kartı çöz', reward: 50, done: false }
  ],
  lessons: [
    { title: 'Matematik', topic: 'Kesirler', stars: 3, progress: 92, locked: false },
    { title: 'Fen Bilimleri', topic: 'Elektrik Devresi', stars: 2, progress: 61, locked: false },
    { title: 'İngilizce', topic: 'Simple Present', stars: 1, progress: 30, locked: false },
    { title: 'Kodlama', topic: 'Döngüler', stars: 0, progress: 0, locked: true }
  ],
  badges: [
    { icon: '🔥', name: 'Streak Ustası', unlocked: true },
    { icon: '⚡', name: 'Hızlı Çözücü', unlocked: true },
    { icon: '🎯', name: 'Tam İsabet', unlocked: true },
    { icon: '🧠', name: 'Zihin Şampiyonu', unlocked: false },
    { icon: '🚀', name: 'Level Atlası', unlocked: false },
    { icon: '🏆', name: 'Haftanın Lideri', unlocked: false }
  ],
  quiz: {
    question: 'Bir üçgenin iç açılar toplamı kaç derecedir?',
    options: ['90°', '120°', '180°', '360°'],
    correct: 2
  }
};

const state = {
  ...defaultState,
  ...(window.STUDENT_PANEL_DATA || {}),
  student: {
    ...defaultState.student,
    ...((window.STUDENT_PANEL_DATA && window.STUDENT_PANEL_DATA.student) || {})
  }
};

const $ = (sel) => document.querySelector(sel);
const $$ = (sel) => [...document.querySelectorAll(sel)];
const baseUrl = String(window.STUDENT_PANEL_BASE_URL || '').replace(/\/$/, '');
const withBase = (path) => {
  if (!path) return path;
  if (!path.startsWith('/')) return path;
  return `${baseUrl}${path}`;
};

function animateXP() {
  const bar = $('[data-xp-bar]');
  if (!bar) return;
  const ratio = Math.min(100, Math.round((state.student.xp / state.student.xpTarget) * 100));
  requestAnimationFrame(() => { bar.style.width = ratio + '%'; });
}

function renderShared() {
  if (state.student && state.student.avatar) {
    state.student.avatar = withBase(state.student.avatar);
  }
  $$('[data-student-name]').forEach(el => el.textContent = state.student.name);
  $$('[data-level]').forEach(el => el.textContent = state.student.level);
  $$('[data-xp]').forEach(el => el.textContent = state.student.xp);
  $$('[data-xp-target]').forEach(el => el.textContent = state.student.xpTarget);
  $$('[data-streak]').forEach(el => el.textContent = state.student.streak);
  $$('[data-total-xp]').forEach(el => el.textContent = state.student.totalXp.toLocaleString('tr-TR'));
}

function renderTasks() {
  const host = $('[data-task-list]');
  if (!host) return;
  host.innerHTML = state.tasks.map(task => `
    <label class="task-item">
      <span>
        <input type="checkbox" ${task.done ? 'checked' : ''} data-task-id="${task.id}" /> ${task.title}
      </span>
      <strong>+${task.reward} XP</strong>
    </label>
  `).join('');

  host.addEventListener('change', (e) => {
    if (!(e.target instanceof HTMLInputElement)) return;
    if (!e.target.matches('[data-task-id]')) return;
    const id = Number(e.target.getAttribute('data-task-id'));
    const task = state.tasks.find(t => t.id === id);
    if (!task) return;
    task.done = e.target.checked;
  });
}

function renderLessons() {
  const host = $('[data-lesson-list]');
  if (!host) return;
  host.innerHTML = state.lessons.map(lesson => `
    <article class="lesson-card ${lesson.locked ? 'locked' : ''}">
      <h3>${lesson.title}</h3>
      <p class="subtle">${lesson.topic}</p>
      <div class="stars">${'★'.repeat(lesson.stars)}${'☆'.repeat(3 - lesson.stars)}</div>
      <p class="subtle">%${lesson.progress} tamamlandı ${lesson.locked ? ' • Kilitli' : ''}</p>
    </article>
  `).join('');
}

function renderBadges() {
  const host = $('[data-badges]');
  if (!host) return;
  host.innerHTML = state.badges.map(badge => `
    <article class="badge-item" style="opacity:${badge.unlocked ? 1 : .45}">
      <h3>${badge.icon} ${badge.name}</h3>
      <p class="subtle">${badge.unlocked ? 'Kazanıldı' : 'Henüz kilitli'}</p>
    </article>
  `).join('');
}

function renderQuiz() {
  const q = $('[data-quiz-question]');
  const host = $('[data-quiz-options]');
  const result = $('[data-quiz-result]');
  if (!q || !host || !result) return;

  q.textContent = state.quiz.question;
  host.innerHTML = state.quiz.options.map((opt, i) => `
    <button class="option" data-option="${i}">${opt}</button>
  `).join('');

  host.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-option]');
    if (!btn) return;
    const index = Number(btn.getAttribute('data-option'));
    $$('.option').forEach(o => o.classList.remove('correct', 'wrong'));
    if (index === state.quiz.correct) {
      btn.classList.add('correct');
      result.textContent = 'Doğru! +30 XP kazandın.';
      result.style.color = '#10b981';
    } else {
      btn.classList.add('wrong');
      $(`.option[data-option="${state.quiz.correct}"]`)?.classList.add('correct');
      result.textContent = 'Yaklaştın! Doğru cevap işaretlendi.';
      result.style.color = '#ef4444';
    }
  });
}

function renderAvatars() {
  const host = $('[data-avatar-list]');
  if (!host) return;
  const avatars = [
    withBase('/avatars/3d/astronaut.png'),
    withBase('/avatars/3d/man-astronaut.png'),
    withBase('/avatars/3d/robot.png'),
    withBase('/avatars/3d/ninja.png'),
    withBase('/avatars/3d/woman-superhero.png')
  ];
  host.innerHTML = avatars.map(url => `
    <button class="avatar-choice ${state.student.avatar === url ? 'active' : ''}" data-avatar="${url}">
      <img src="${url}" alt="avatar" />
    </button>
  `).join('');

  host.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-avatar]');
    if (!btn) return;
    const next = btn.getAttribute('data-avatar');
    state.student.avatar = next;
    $('[data-current-avatar]').src = next;
    $$('.avatar-choice').forEach(x => x.classList.remove('active'));
    btn.classList.add('active');
  });
}

document.addEventListener('DOMContentLoaded', () => {
  renderShared();
  animateXP();
  renderTasks();
  renderLessons();
  renderBadges();
  renderQuiz();
  renderAvatars();
});

