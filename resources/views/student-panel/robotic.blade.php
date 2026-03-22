<!doctype html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CodeBot Arena</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Nunito:wght@500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('student-panel/robotic.css') }}">
</head>
<body class="app-bg text-slate-100">
  <div class="max-w-[1400px] mx-auto p-4 md:p-6 space-y-4">
    <header class="glass rounded-3xl p-4 md:p-5 flex items-center justify-between gap-3">
      <div>
        <h1 class="title text-2xl md:text-3xl">CodeBot Arena</h1>
        <p class="text-slate-300">Kodla. Çalıştır. Robotu hedefe ulaştır.</p>
      </div>
      <div class="flex gap-2 md:gap-3 text-sm">
        <div class="chip">🔥 <span id="streak">7</span> Gün</div>
        <div class="chip">🏅 Lv.<span id="level">4</span></div>
        <div class="chip">⚡ <span id="xp">260</span> XP</div>
      </div>
    </header>

    <section class="grid lg:grid-cols-3 gap-4">
      <div class="glass rounded-3xl p-4 lg:col-span-2">
        <div class="flex items-center justify-between gap-2 mb-3">
          <h2 class="text-xl font-bold">Bugünkü Görev</h2>
          <div class="flex gap-2">
            <button id="btn-open-live-panel" class="muted-btn">Tum Akis</button>
            <button id="btn-continue" class="neon-btn">Devam Et</button>
          </div>
        </div>
        <p id="daily-mission" class="text-cyan-300 font-semibold">Robotu hedefe ulaştır (Misyon 1)</p>
        <div class="mt-3 bg-slate-800/60 rounded-full h-3 overflow-hidden">
          <div id="xp-bar" class="h-full xp-bar" style="width: 26%"></div>
        </div>
        <div class="grid md:grid-cols-4 gap-3 mt-4" id="stats-cards"></div>
      </div>
      <div class="glass rounded-3xl p-4">
        <div class="flex items-center gap-3 mb-3">
          <img id="live-avatar" src="{{ asset('avatars/3d/robot.png') }}" alt="avatar" class="w-12 h-12 rounded-xl border border-cyan-400/40 object-cover">
          <div>
            <h3 id="live-name" class="font-bold text-lg leading-none">Ogrenci</h3>
            <p class="text-xs text-slate-400">Canli profil</p>
          </div>
        </div>
        <h3 class="font-bold text-lg mb-3">Rozetler</h3>
        <div id="badges" class="space-y-2"></div>
      </div>
    </section>

    <section class="grid xl:grid-cols-5 gap-4">
      <aside class="glass rounded-3xl p-4 xl:col-span-1">
        <h3 class="font-bold text-lg mb-3">Misyonlar</h3>
        <div id="missions" class="space-y-2"></div>
      </aside>

      <main class="xl:col-span-4 grid lg:grid-cols-2 gap-4">
        <div class="glass rounded-3xl p-4 space-y-3">
          <div class="flex gap-2">
            <button class="mode-btn active" data-mode="blocks">Blok Modu</button>
            <button class="mode-btn" data-mode="code">Kod Modu</button>
          </div>

          <div id="blocks-panel" class="space-y-2">
            <p class="text-sm text-slate-300">Komutları sırayla ekle:</p>
            <div class="grid grid-cols-2 gap-2">
              <button class="cmd-btn" data-cmd="forward">⬆ Ileri</button>
              <button class="cmd-btn" data-cmd="right">↪ Saga Don</button>
              <button class="cmd-btn" data-cmd="left">↩ Sola Don</button>
              <button class="cmd-btn" data-cmd="loop2">🔁 2x Ileri</button>
            </div>
            <div id="block-seq" class="min-h-[76px] codebox"></div>
          </div>

          <div id="code-panel" class="hidden space-y-2">
            <p class="text-sm text-slate-300">Basit komutlar: <code>forward()</code>, <code>left()</code>, <code>right()</code>, <code>repeat(2, forward)</code></p>
            <textarea id="code-input" class="code-editor" spellcheck="false">forward();
forward();
right();
forward();</textarea>
          </div>

          <div class="flex gap-2">
            <button id="run-btn" class="neon-btn">Calistir</button>
            <button id="reset-btn" class="muted-btn">Sifirla</button>
          </div>
          <div id="hint-box" class="hint-box">Ipucu: Hedefe giderken once x eksenini hizala.</div>
        </div>

        <div class="glass rounded-3xl p-4">
          <div class="flex items-center justify-between mb-2">
            <h3 class="font-bold text-lg">Robot Simulasyonu</h3>
            <span id="sim-status" class="text-sm text-cyan-300">Hazir</span>
          </div>
          <canvas id="sim-canvas" width="420" height="420" class="w-full rounded-2xl border border-cyan-500/30 bg-slate-950"></canvas>
          <p id="output" class="mt-2 text-sm text-slate-300">Cikti: Robot bekliyor...</p>
        </div>
      </main>
    </section>

    <section class="grid lg:grid-cols-2 gap-4">
      <article class="glass rounded-3xl p-4">
        <h3 class="font-bold text-lg mb-2">Odevler (Canli Veri)</h3>
        <div class="grid md:grid-cols-2 gap-3">
          <div>
            <h4 class="text-cyan-300 font-semibold mb-2">Bekleyen</h4>
            <div id="live-homework-pending" class="space-y-2"></div>
          </div>
          <div>
            <h4 class="text-emerald-300 font-semibold mb-2">Tamamlanan</h4>
            <div id="live-homework-completed" class="space-y-2"></div>
          </div>
        </div>
      </article>
      <article class="glass rounded-3xl p-4">
        <h3 class="font-bold text-lg mb-2">Uygulama Odevleri (Canli Veri)</h3>
        <div class="grid md:grid-cols-2 gap-3">
          <div>
            <h4 class="text-cyan-300 font-semibold mb-2">Bekleyen</h4>
            <div id="live-apps-pending" class="space-y-2"></div>
          </div>
          <div>
            <h4 class="text-emerald-300 font-semibold mb-2">Tamamlanan</h4>
            <div id="live-apps-completed" class="space-y-2"></div>
          </div>
        </div>
      </article>
    </section>
  </div>

  <iframe id="legacy-bridge-frame" src="{{ url('/legacy-home') }}" class="hidden"></iframe>
  <div id="live-panel-modal" class="hidden fixed inset-0 z-50 bg-slate-950/80 p-3 md:p-6">
    <div class="w-full h-full rounded-2xl overflow-hidden border border-cyan-400/40 bg-slate-900">
      <div class="p-2 border-b border-slate-700 flex justify-end">
        <button id="btn-close-live-panel" class="muted-btn">Kapat</button>
      </div>
      <iframe src="{{ url('/legacy-home') }}" class="w-full h-[calc(100%-48px)]"></iframe>
    </div>
  </div>
  <script src="{{ asset('student-panel/robotic.js') }}"></script>
</body>
</html>
