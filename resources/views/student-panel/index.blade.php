<!doctype html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Öğrenci Paneli - {{ ucfirst($page) }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;700;800&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('student-panel/styles.css') }}" />
</head>
<body>
  <div class="shell">
    <header class="topbar">
      <div class="brand"><span class="brand-badge">🎮</span> EduQuest</div>
      <nav class="nav">
        <a class="{{ $page === 'dashboard' ? 'active' : '' }}" href="{{ url('/ogrenci-paneli/dashboard') }}">Dashboard</a>
        <a class="{{ $page === 'dersler' ? 'active' : '' }}" href="{{ url('/ogrenci-paneli/dersler') }}">Dersler</a>
        <a class="{{ $page === 'quiz' ? 'active' : '' }}" href="{{ url('/ogrenci-paneli/quiz') }}">Quiz</a>
        <a class="{{ $page === 'basarilar' ? 'active' : '' }}" href="{{ url('/ogrenci-paneli/basarilar') }}">Başarılar</a>
        <a class="{{ $page === 'profil' ? 'active' : '' }}" href="{{ url('/ogrenci-paneli/profil') }}">Profil</a>
      </nav>
    </header>

    @if ($page === 'dashboard')
      <section class="card hero">
        <p class="pill">🔥 <span data-streak></span> günlük seri</p>
        <h1>Merhaba <span data-student-name></span>, bugün çok güçlüsün!</h1>
        <p>Level <span data-level></span> • <span data-xp></span>/<span data-xp-target></span> XP</p>
        <div class="progress-wrap"><div class="progress" data-xp-bar></div></div>
        <div style="margin-top:14px;"><button class="btn btn-primary">Bugün Devam Et</button></div>
      </section>

      <section class="grid cols-2" style="margin-top:16px;">
        <article class="card">
          <h2 class="title">Günlük Görevler</h2>
          <p class="subtle">Mini görevleri bitir, anında XP topla.</p>
          <div data-task-list style="margin-top:10px;" class="grid"></div>
        </article>

        <article class="card">
          <h2 class="title">Anlık Durum</h2>
          <div class="grid">
            <div class="stat"><strong>Toplam XP:</strong> <span data-total-xp></span></div>
            <div class="stat"><strong>Seviye:</strong> <span data-level></span></div>
            <div class="stat"><strong>Streak:</strong> <span data-streak></span> gün</div>
            <div class="stat"><strong>Bugün:</strong> +120 XP hedef</div>
          </div>
        </article>
      </section>
    @endif

    @if ($page === 'dersler')
      <section class="card">
        <h1 class="title">Dersler ve Konular</h1>
        <p class="subtle">Açık seviyeleri bitir, yeni ünitelerin kilidini aç.</p>
        <div class="lesson-grid" data-lesson-list style="margin-top:14px;"></div>
      </section>
    @endif

    @if ($page === 'quiz')
      <section class="card hero">
        <p class="pill">⚡ Hızlı Tur</p>
        <h1 data-quiz-question></h1>
        <p>Doğru cevabı bul, anında ödülü kap.</p>
        <div class="quiz-options" data-quiz-options></div>
        <p data-quiz-result style="font-weight:800; margin-top:12px; color:#fff;">Bir seçenek seç.</p>
      </section>
    @endif

    @if ($page === 'basarilar')
      <section class="card">
        <h1 class="title">Rozet Galerisi</h1>
        <p class="subtle">Her başarı yeni bir rozet ve daha yüksek motivasyon.</p>
        <div class="badges-grid" data-badges style="margin-top:14px;"></div>
      </section>
    @endif

    @if ($page === 'profil')
      <section class="grid cols-2">
        <article class="card">
          <h1 class="title">Profil</h1>
          <p class="subtle"><span data-student-name></span> • Level <span data-level></span></p>
          <div style="margin-top:12px; display:flex; align-items:center; gap:14px;">
            <img data-current-avatar src="/avatars/3d/astronaut.png" alt="avatar" style="width:88px;height:88px;border-radius:24px;box-shadow:var(--shadow);" />
            <div>
              <div class="pill" style="background:linear-gradient(135deg,var(--green),#20c997); color:#fff;">✨ Toplam XP: <span data-total-xp></span></div>
              <p class="subtle" style="margin-top:10px;">Streak: <span data-streak></span> gün</p>
            </div>
          </div>
        </article>

        <article class="card">
          <h2 class="title">Avatar Özelleştirme</h2>
          <p class="subtle">Karakterini seç, profile enerji kat.</p>
          <div class="avatar-row" data-avatar-list style="margin-top:12px;"></div>
        </article>
      </section>
    @endif
  </div>

  <script>
    window.STUDENT_PANEL_BASE_URL = "{{ rtrim(url('/'), '/') }}";
    window.STUDENT_PANEL_DATA = @json($panelData);
  </script>
  <script src="{{ asset('student-panel/app.js') }}"></script>
</body>
</html>
