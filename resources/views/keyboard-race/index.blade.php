<!doctype html>
<html lang="tr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Klavye Hız Yarışması</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
</head>
<body class="race-ui min-h-screen bg-slate-950 text-slate-100">
<div class="absolute inset-0 -z-10 race-bg"></div>
<div class="mx-auto max-w-6xl p-4 md:p-8">
    <div class="glass-panel p-6 md:p-8">
        <h1 class="text-3xl md:text-5xl font-black tracking-tight neon-title">Klavye Hız Yarışması</h1>
        <p class="mt-2 text-slate-300">Gerçek zamanlı yarış: oda oluştur, katıl, yaz ve zirveye çık.</p>

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            <input id="userName" type="text" placeholder="Kullanıcı adın" class="race-input" />
            <input id="roomCode" type="text" placeholder="Oda kodu" class="race-input uppercase" />
            <div class="flex gap-2">
                <button id="createRoomBtn" class="race-btn race-btn-primary w-full">Oda Oluştur</button>
                <button id="joinRoomBtn" class="race-btn w-full">Katıl</button>
            </div>
        </div>

        <div id="roomMeta" class="mt-6 hidden rounded-xl border border-cyan-400/30 bg-slate-900/70 p-4"></div>

        <div class="mt-6 flex flex-wrap items-center gap-3">
            <button id="startRaceBtn" class="race-btn race-btn-primary" disabled>Yarışı Başlat</button>
            <button id="endRaceBtn" class="race-btn" disabled>Yarışı Bitir ve Rapor Al</button>
            <div id="countdown" class="text-5xl font-black text-cyan-300"></div>
            <div id="raceTimer" class="text-2xl font-black text-amber-300"></div>
            <div id="statusText" class="text-sm text-slate-300"></div>
        </div>

        <div class="mt-8">
            <div id="typingText" class="rounded-xl bg-slate-900/70 p-4 leading-8 text-lg"></div>
            <textarea id="typingInput" rows="3" class="race-input mt-3" placeholder="Yarış başlayınca buraya yaz..." disabled></textarea>
        </div>

        <div class="mt-6">
            <div class="mb-2 flex items-center justify-between text-sm">
                <span>İlerlemen</span>
                <span id="selfStats">0% | 0 WPM | 100% ACC</span>
            </div>
            <div class="h-3 w-full overflow-hidden rounded-full bg-slate-800">
                <div id="selfBar" class="h-full w-0 bg-gradient-to-r from-cyan-400 to-fuchsia-500 transition-all duration-300"></div>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold">Canlı Rakipler</h2>
            <div id="opponents" class="mt-3 grid gap-3 md:grid-cols-2"></div>
        </div>

        <div id="leaderboardWrap" class="mt-8 hidden">
            <h2 class="text-2xl font-black">Sonuçlar</h2>
            <div id="winnerText" class="mt-2 text-2xl font-black text-emerald-300"></div>
            <div id="leaderboard" class="mt-3 space-y-2"></div>
        </div>
    </div>
</div>

<script>
(() => {
    const API_BASE_CANDIDATES = [
        '{{ url('api/race') }}',
        '{{ url('index.php/api/race') }}',
        '{{ url('public/api/race') }}',
    ];
    let activeApiBase = API_BASE_CANDIDATES[0];
    const SOCKET_URL = '{{ env('SOCKET_SERVER_URL', 'http://localhost:3001') }}';
    const params = new URLSearchParams(window.location.search);
    const actorRole = (params.get('role') || 'student').toLowerCase() === 'teacher' ? 'teacher' : 'student';
    const actorUserId = Number(params.get('uid') || 0) || null;

    const state = {
        socket: null,
        roomCode: '',
        roomText: '',
        userName: '',
        startedAtMs: null,
        startHandled: false,
        raceDurationSeconds: 120,
        raceEndsAtMs: null,
        raceTimerInterval: null,
        isSpectator: false,
        myProgress: 0,
        opponents: new Map(),
        finished: false,
        roomPollTimer: null,
    };

    const el = {
        userName: document.getElementById('userName'),
        roomCode: document.getElementById('roomCode'),
        createRoomBtn: document.getElementById('createRoomBtn'),
        joinRoomBtn: document.getElementById('joinRoomBtn'),
        startRaceBtn: document.getElementById('startRaceBtn'),
        endRaceBtn: document.getElementById('endRaceBtn'),
        countdown: document.getElementById('countdown'),
        raceTimer: document.getElementById('raceTimer'),
        statusText: document.getElementById('statusText'),
        typingText: document.getElementById('typingText'),
        typingInput: document.getElementById('typingInput'),
        selfStats: document.getElementById('selfStats'),
        selfBar: document.getElementById('selfBar'),
        opponents: document.getElementById('opponents'),
        leaderboardWrap: document.getElementById('leaderboardWrap'),
        leaderboard: document.getElementById('leaderboard'),
        winnerText: document.getElementById('winnerText'),
        roomMeta: document.getElementById('roomMeta'),
    };

    const raceSample = 'Hizli yazan kazanir. Dikkatini topla, hatasiz ve ritimli yaz. Her harf puanina etki eder.';

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function authHeaders() {
        return {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        };
    }

    async function api(path, options = {}) {
        let lastError = null;
        for (const base of API_BASE_CANDIDATES) {
            const res = await fetch(`${base}${path}`, {
                ...options,
                headers: {
                    ...authHeaders(),
                    ...(options.headers || {}),
                },
            });

            const data = await res.json().catch(() => ({}));
            if (res.ok) {
                activeApiBase = base;
                return data;
            }

            if (res.status !== 404 && res.status < 500) {
                throw new Error(data.message || 'API istegi basarisiz.');
            }

            lastError = data.message || `API istegi basarisiz. (${res.status})`;
        }
        throw new Error(lastError || 'API istegi basarisiz.');
    }

    function connectSocket() {
        if (state.socket) return;

        state.socket = io(SOCKET_URL, {
            transports: ['websocket', 'polling'],
            reconnection: true,
            reconnectionAttempts: 20,
            reconnectionDelay: 500,
            reconnectionDelayMax: 5000,
        });

        state.socket.on('connect', () => {
            if (state.roomCode && state.userName) {
                state.socket.emit('join_room', {
                    roomCode: state.roomCode,
                    userName: state.userName,
                });
            }
        });

        state.socket.on('room_joined', (payload) => {
            if (typeof payload.spectator === 'boolean') {
                state.isSpectator = payload.spectator;
                if (state.isSpectator) {
                    setStatus('Yaris baslamis. Spectator modundasin.');
                    el.typingInput.disabled = true;
                }
            }
        });

        state.socket.on('room_presence', (payload) => {
            if (!payload?.userName || payload.userName === state.userName) return;
            upsertOpponent(payload.userName, payload.progress || 0, payload.wpm || 0, payload.accuracy || 100);
        });

        state.socket.on('race_started', async (payload) => {
            await handleRaceStarted({
                text: payload?.text || state.roomText,
                durationSeconds: Number(payload?.durationSeconds || state.raceDurationSeconds || 120),
                endsAt: payload?.endsAt || null,
            });
        });

        state.socket.on('typing_progress', (payload) => {
            if (!payload?.userName || payload.userName === state.userName) return;
            upsertOpponent(payload.userName, payload.progress, payload.wpm, payload.accuracy);
        });

        state.socket.on('race_finished', (payload) => {
            if (Array.isArray(payload?.leaderboard)) {
                renderLeaderboard(payload.leaderboard);
            }
        });
    }

    function startRoomPolling() {
        if (state.roomPollTimer || !state.roomCode) return;
        state.roomPollTimer = setInterval(syncRoomSnapshot, 2000);
        syncRoomSnapshot();
    }

    function stopRoomPolling() {
        if (!state.roomPollTimer) return;
        clearInterval(state.roomPollTimer);
        state.roomPollTimer = null;
    }

    function stopRaceTimer() {
        if (state.raceTimerInterval) {
            clearInterval(state.raceTimerInterval);
            state.raceTimerInterval = null;
        }
    }

    function updateRaceTimerLabel() {
        if (!state.startedAtMs) {
            el.raceTimer.textContent = '';
            return;
        }
        const elapsed = Math.max(0, Math.floor((Date.now() - state.startedAtMs) / 1000));
        const remaining = state.raceEndsAtMs ? Math.max(0, Math.floor((state.raceEndsAtMs - Date.now()) / 1000)) : 0;
        el.raceTimer.textContent = `Kalan: ${remaining}s | Süren: ${elapsed}s`;
    }

    function startRaceTimer() {
        stopRaceTimer();
        updateRaceTimerLabel();
        state.raceTimerInterval = setInterval(() => {
            updateRaceTimerLabel();
            if (state.raceEndsAtMs && Date.now() >= state.raceEndsAtMs) {
                stopRaceTimer();
                if (!state.finished && !state.isSpectator) {
                    const input = el.typingInput.value;
                    const stats = computeStats(input);
                    finishRace(stats).catch((err) => setStatus(err.message));
                }
            }
        }, 500);
    }

    function renderOpponentsFromResults(results = []) {
        state.opponents.clear();
        for (const row of results) {
            const name = String(row?.user_name || '').trim();
            if (!name || name === state.userName || row?.is_spectator) continue;
            upsertOpponent(name, Number(row?.progress || 0), Number(row?.wpm || 0), Number(row?.accuracy || 100));
        }
    }

    async function handleRaceStarted({ text = '', durationSeconds = 120, endsAt = null } = {}) {
        if (state.startHandled) return;
        state.startHandled = true;
        state.roomText = text || state.roomText;
        state.raceDurationSeconds = Math.max(30, Number(durationSeconds || 120));
        renderTypingText('', state.roomText);
        await startCountdown();
        state.startedAtMs = Date.now();
        state.raceEndsAtMs = endsAt ? new Date(endsAt).getTime() : (state.startedAtMs + state.raceDurationSeconds * 1000);
        state.finished = false;
        startRaceTimer();
        if (!state.isSpectator) {
            el.typingInput.disabled = false;
            el.typingInput.focus();
        }
        setStatus('Yaris basladi. Yazmaya baslayin.');
    }

    async function syncRoomSnapshot() {
        if (!state.roomCode) return;
        try {
            const data = await api(`/rooms/${state.roomCode}`);
            const room = data?.room;
            if (!room) return;

            if (room.text && !state.roomText) {
                state.roomText = room.text;
                renderTypingText('', state.roomText);
            }

            renderRoomMeta(state.roomCode, room.status || 'waiting');
            renderOpponentsFromResults(Array.isArray(room.race_results) ? room.race_results : []);

            if (room.status === 'active') {
                await handleRaceStarted({
                    text: room.text || state.roomText,
                    durationSeconds: state.raceDurationSeconds || 120,
                    endsAt: room.started_at ? new Date(new Date(room.started_at).getTime() + (state.raceDurationSeconds || 120) * 1000).toISOString() : null,
                });
            }

            if (room.status === 'finished') {
                const board = (Array.isArray(room.race_results) ? room.race_results : [])
                    .filter((x) => !x.is_spectator)
                    .sort((a, b) => {
                        if ((b.progress || 0) !== (a.progress || 0)) return (b.progress || 0) - (a.progress || 0);
                        if ((b.wpm || 0) !== (a.wpm || 0)) return (b.wpm || 0) - (a.wpm || 0);
                        return (b.accuracy || 0) - (a.accuracy || 0);
                    })
                    .map((x) => ({
                        userName: x.user_name,
                        progress: Number(x.progress || 0),
                        wpm: Number(x.wpm || 0),
                        accuracy: Number(x.accuracy || 0),
                    }));
                if (board.length > 0) renderLeaderboard(board);
                stopRaceTimer();
                stopRoomPolling();
            }
        } catch (_) {}
    }

    function setStatus(text) {
        el.statusText.textContent = text;
    }

    function renderRoomMeta(code, status) {
        el.roomMeta.classList.remove('hidden');
        el.roomMeta.innerHTML = `<div class="flex flex-wrap gap-4 text-sm"><span>Oda: <b>${code}</b></span><span>Durum: <b>${status}</b></span></div>`;
    }

    async function createRoom() {
        if (actorRole !== 'teacher') return setStatus('Sadece öğretmen oda oluşturabilir.');
        const userName = el.userName.value.trim();
        if (!userName) return setStatus('Kullanici adini gir.');

        state.userName = userName;
        const roomName = `${userName} Odasi`;
        const data = await api('/rooms', {
            method: 'POST',
            body: JSON.stringify({
                name: roomName,
                text: raceSample,
                user_name: userName,
                user_id: actorUserId,
                actor_role: actorRole,
            }),
        });

        state.roomCode = data.room.code;
        state.roomText = data.room.text;
        state.startHandled = false;
        el.roomCode.value = state.roomCode;
        renderRoomMeta(state.roomCode, data.room.status);
        connectSocket();
        state.socket.emit('join_room', { roomCode: state.roomCode, userName: state.userName });
        startRoomPolling();
        el.startRaceBtn.disabled = false;
        el.endRaceBtn.disabled = false;
        setStatus('Oda olusturuldu. Yaris baslatilabilir.');
    }

    async function joinRoom() {
        if (actorRole !== 'student') return setStatus('Öğretmen odaya katılamaz, sadece oluşturur.');
        const userName = el.userName.value.trim();
        const roomCode = el.roomCode.value.trim().toUpperCase();
        if (!userName || !roomCode) return setStatus('Kullanici adi ve oda kodu gerekli.');

        state.userName = userName;
        state.roomCode = roomCode;
        state.startHandled = false;

        const data = await api(`/rooms/${roomCode}/join`, {
            method: 'POST',
            body: JSON.stringify({ user_name: userName, user_id: actorUserId, actor_role: actorRole }),
        });

        state.roomText = data.race_text;
        state.isSpectator = !!data.user.spectator;
        renderRoomMeta(roomCode, data.status);
        renderTypingText('', state.roomText);
        connectSocket();
        state.socket.emit('join_room', { roomCode, userName });
        startRoomPolling();
        el.startRaceBtn.disabled = data.status !== 'waiting';
        setStatus(state.isSpectator ? 'Yarisa izleyici olarak katildin.' : 'Odaya katildin.');
    }

    async function startRace() {
        if (!state.roomCode) return;
        await api(`/rooms/${state.roomCode}/start`, {
            method: 'POST',
            body: JSON.stringify({ actor_role: actorRole }),
        });
        syncRoomSnapshot();
        setStatus('Yaris tetiklendi. Geri sayim bekleniyor...');
    }

    function buildRaceReportHtml(report) {
        const rows = Array.isArray(report?.participants) ? report.participants : [];
        const list = rows.map((r, idx) => `
            <tr>
                <td>${idx + 1}</td>
                <td>${r.userName || '-'}</td>
                <td>${Number(r.progress || 0).toFixed(1)}%</td>
                <td>${Number(r.wpm || 0).toFixed(1)}</td>
                <td>${Number(r.accuracy || 0).toFixed(1)}%</td>
                <td>${r.completionSeconds ?? '-'}</td>
                <td>${r.elapsedSeconds ?? 0}</td>
                <td>${r.xpEarned ?? 0}</td>
            </tr>
        `).join('');
        return `
<!doctype html>
<html lang="tr"><head><meta charset="UTF-8"><title>Klavye Yarışı Raporu</title>
<style>body{font-family:Arial,sans-serif;padding:16px}table{border-collapse:collapse;width:100%}th,td{border:1px solid #ddd;padding:8px;font-size:13px}th{background:#f3f4f6;text-align:left}</style>
</head><body>
<h2>Klavye Yarışı Raporu</h2>
<p><b>Oda:</b> ${report?.roomCode || '-'} | <b>Ad:</b> ${report?.roomName || '-'}</p>
<p><b>Başlangıç:</b> ${report?.startedAt || '-'} | <b>Bitiş:</b> ${report?.finishedAt || '-'} | <b>Toplam Süre:</b> ${report?.durationSeconds ?? '-'} sn</p>
<table><thead><tr><th>#</th><th>Öğrenci</th><th>İlerleme</th><th>WPM</th><th>Doğruluk</th><th>Bitiriş (sn)</th><th>Geçen Süre (sn)</th><th>XP</th></tr></thead><tbody>${list}</tbody></table>
<script>window.onload=()=>window.print();<\/script>
</body></html>`;
    }

    async function endRaceAndDownloadReport() {
        if (!state.roomCode) return;
        const data = await api(`/rooms/${state.roomCode}/end`, {
            method: 'POST',
            body: JSON.stringify({ actor_role: actorRole }),
        });
        stopRaceTimer();
        el.typingInput.disabled = true;
        if (Array.isArray(data?.leaderboard)) renderLeaderboard(data.leaderboard);
        const report = data?.report || null;
        if (report) {
            const win = window.open('', '_blank', 'noopener,noreferrer,width=1100,height=800');
            if (win) {
                win.document.open();
                win.document.write(buildRaceReportHtml(report));
                win.document.close();
            }
        }
        setStatus('Yaris ogretmen tarafindan sonlandirildi.');
    }

    async function startCountdown() {
        const seq = ['3', '2', '1', 'Basla!'];
        for (const tick of seq) {
            el.countdown.textContent = tick;
            el.countdown.classList.remove('countdown-pop');
            void el.countdown.offsetWidth;
            el.countdown.classList.add('countdown-pop');
            await new Promise((r) => setTimeout(r, 750));
        }
        el.countdown.textContent = '';
    }

    function computeStats(inputText) {
        const target = state.roomText;
        const typed = inputText.length;
        const matched = [...inputText].filter((char, i) => char === target[i]).length;
        const progress = Math.min(100, (typed / target.length) * 100);
        const accuracy = typed === 0 ? 100 : (matched / typed) * 100;
        const elapsedMinutes = Math.max((Date.now() - (state.startedAtMs || Date.now())) / 60000, 1 / 60);
        const words = inputText.trim().length ? inputText.trim().split(/\s+/).length : 0;
        const wpm = words / elapsedMinutes;

        return {
            progress: Number(progress.toFixed(2)),
            accuracy: Number(accuracy.toFixed(2)),
            wpm: Number(wpm.toFixed(2)),
        };
    }

    function renderTypingText(input, target) {
        const chars = target.split('').map((char, i) => {
            if (i >= input.length) return `<span class="text-slate-500">${escapeHtml(char)}</span>`;
            return input[i] === char
                ? `<span class="text-emerald-400">${escapeHtml(char)}</span>`
                : `<span class="text-rose-400">${escapeHtml(char)}</span>`;
        });
        el.typingText.innerHTML = chars.join('');
    }

    function escapeHtml(value) {
        return value
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function upsertOpponent(userName, progress, wpm, accuracy) {
        state.opponents.set(userName, { progress, wpm, accuracy });
        const entries = [...state.opponents.entries()];
        el.opponents.innerHTML = entries.map(([name, stats]) => `
            <div class="rounded-xl border border-fuchsia-400/30 bg-slate-900/60 p-3">
                <div class="mb-1 flex items-center justify-between text-sm">
                    <span>${name}</span>
                    <span>${Number(stats.progress).toFixed(1)}%</span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-slate-800">
                    <div class="h-full bg-gradient-to-r from-fuchsia-500 to-cyan-400 transition-all duration-300" style="width:${Math.min(100, Math.max(0, stats.progress))}%"></div>
                </div>
                <div class="mt-2 text-xs text-slate-300">${Number(stats.wpm).toFixed(1)} WPM | ${Number(stats.accuracy).toFixed(1)}% ACC</div>
            </div>
        `).join('');
    }

    async function finishRace(stats) {
        if (state.finished || state.isSpectator) return;
        state.finished = true;
        el.typingInput.disabled = true;

        const result = await api(`/rooms/${state.roomCode}/finish`, {
            method: 'POST',
            body: JSON.stringify({
                user_name: state.userName,
                user_id: actorUserId,
                progress: stats.progress,
                wpm: stats.wpm,
                accuracy: stats.accuracy,
                elapsed_seconds: Math.max(0, Math.floor((Date.now() - (state.startedAtMs || Date.now())) / 1000)),
                completion_seconds: stats.progress >= 100 ? Math.max(0, Math.floor((Date.now() - (state.startedAtMs || Date.now())) / 1000)) : null,
                xp_earned: Math.max(0, Math.round((stats.progress * 0.4) + (stats.wpm * 1.2) + (stats.accuracy * 0.6))),
                is_spectator: false,
            }),
        });

        renderLeaderboard(result.leaderboard || []);
    }

    function renderLeaderboard(leaderboard) {
        el.leaderboardWrap.classList.remove('hidden');
        el.leaderboard.classList.add('result-fade');
        el.leaderboard.innerHTML = leaderboard.map((row, index) => `
            <div class="rounded-xl border border-cyan-400/30 bg-slate-900/70 p-3 flex items-center justify-between">
                <div><span class="font-black text-cyan-300">#${index + 1}</span> ${row.userName}</div>
                <div class="text-sm text-slate-200">${Number(row.progress).toFixed(1)}% | ${Number(row.wpm).toFixed(1)} WPM | ${Number(row.accuracy).toFixed(1)}%</div>
            </div>
        `).join('');

        const winner = leaderboard[0]?.userName;
        if (winner) {
            el.winnerText.textContent = winner === state.userName
                ? '🎉 Tebrikler! En Hızlı Klavyeşör Sensin!'
                : `Kazanan: ${winner}`;
        }

        if (winner === state.userName && typeof confetti === 'function') {
            confetti({
                particleCount: 180,
                spread: 90,
                origin: { y: 0.6 },
            });
        }
    }

    function onTyping() {
        if (!state.roomText || state.isSpectator || !state.startedAtMs) return;

        const input = el.typingInput.value;
        renderTypingText(input, state.roomText);

        const stats = computeStats(input);
        state.myProgress = stats.progress;

        el.selfBar.style.width = `${stats.progress}%`;
        el.selfStats.textContent = `${stats.progress.toFixed(1)}% | ${stats.wpm.toFixed(1)} WPM | ${stats.accuracy.toFixed(1)}% ACC`;

        state.socket?.emit('typing_progress', {
            roomCode: state.roomCode,
            userName: state.userName,
            ...stats,
        });

        if (input.length >= state.roomText.length) {
            finishRace(stats).catch((err) => setStatus(err.message));
        }
    }

    el.createRoomBtn.addEventListener('click', () => createRoom().catch((err) => setStatus(err.message)));
    el.joinRoomBtn.addEventListener('click', () => joinRoom().catch((err) => setStatus(err.message)));
    el.startRaceBtn.addEventListener('click', () => startRace().catch((err) => setStatus(err.message)));
    el.endRaceBtn.addEventListener('click', () => endRaceAndDownloadReport().catch((err) => setStatus(err.message)));
    el.typingInput.addEventListener('input', onTyping);

    if (params.get('name')) {
        el.userName.value = params.get('name');
    }
    if (params.get('room')) {
        el.roomCode.value = params.get('room').toUpperCase();
    }

    if (actorRole === 'teacher') {
        el.joinRoomBtn.disabled = true;
        el.joinRoomBtn.title = 'Öğretmen yalnızca oda oluşturur.';
        el.endRaceBtn.disabled = true;
        setStatus('Öğretmen modu: oda oluşturup yarışı başlatabilirsiniz.');
    } else {
        el.createRoomBtn.disabled = true;
        el.createRoomBtn.title = 'Öğrenci oda oluşturamaz.';
        el.startRaceBtn.disabled = true;
        el.endRaceBtn.disabled = true;
        setStatus('Öğrenci modu: oda kodu ile katılın.');
        if (params.get('room')) {
            if (!el.userName.value.trim()) {
                el.userName.value = `Ogrenci-${Math.floor(100 + Math.random() * 900)}`;
            }
            joinRoom().catch((err) => setStatus(err.message));
        }
    }

    window.addEventListener('beforeunload', () => {
        stopRoomPolling();
        stopRaceTimer();
    });
    renderTypingText('', raceSample);
})();
</script>
</body>
</html>

