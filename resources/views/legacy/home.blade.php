<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="app-base-url" content="{{ rtrim(url('/'), '/') }}">
    <meta name="theme-color" content="#2563eb">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Egitim Portali">
    <title>Eğitim Portalı | Tam Sürüm</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo192.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@500;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4a90e2;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --bg: #f4f7f6;
            --app-font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        * , *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; width: 100%; touch-action: pan-x pan-y; }
        html {
            font-size: 85%;
            -webkit-text-size-adjust: 100%;
            text-size-adjust: 100%;
        }
        body,
        body :not(code):not(pre):not(kbd):not(samp) {
            font-family: var(--app-font-family) !important;
        }
        body { background: #f2f2f6; margin: 0; overflow-x: hidden; width: 100vw; }
        #app-screen { background: #f2f2f6; border-radius: 16px; padding: 12px; width: 100%; max-width: 100%; overflow-x: hidden; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); align-items: start; }
        #app-screen > .app-header,
        #app-screen > #home-overview-strip,
        #app-screen > #student-stats-bar,
        #app-screen > #teacher-analytics { grid-column: 1 / -1; }
        #app-screen > .card { margin-bottom: 0; min-width: 0; }
        #teacher-home-sections-host {
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
            min-height: 0;
        }
        #teacher-home-sections-host .embedded-home-card {
            box-shadow: none;
            border: none;
            margin: 0;
            height: 100% !important;
            min-height: 0;
        }
        #teacher-home-sections-host .embedded-home-card .tab-content,
        #teacher-home-sections-host .embedded-home-card #quiz-list,
        #teacher-home-sections-host .embedded-home-card #quiz-list-pending,
        #teacher-home-sections-host .embedded-home-card #quiz-list-completed {
            min-height: 0;
            overflow: auto;
        }
        #teacher-home-tabs {
            display: none;
        }
        #app-screen > * { min-width: 0; max-width: 100%; }
        #app-screen.teacher-view #student-homework-shell,
        #app-screen.teacher-view #block-homework-section {
            align-self: stretch;
        }
        #app-screen.teacher-view #teacher-home-sections-host {
            margin-top: 0 !important;
        }
        #app-screen.teacher-view #teacher-stats,
        #app-screen.teacher-view #activities-teacher-stats,
        #app-screen.teacher-view #lessons-teacher-stats,
        #app-screen.teacher-view #block-homework-teacher-stats,
        #app-screen.teacher-view #compute-homework-teacher-stats {
            margin-top: 0 !important;
        }
        #app-screen.teacher-view #teacher-home-tabs {
            margin-top: 4px !important;
            margin-bottom: 0 !important;
            min-height: 58px;
            align-items: stretch;
        }
        #app-screen.teacher-view #block-homework-assign-tabs {
            margin-top: 4px !important;
            margin-bottom: 10px !important;
            min-height: 54px;
            align-items: stretch;
        }
        #app-screen.teacher-view #teacher-home-tabs .tab-btn,
        #app-screen.teacher-view #block-homework-assign-tabs .tab-btn {
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
        #app-screen.teacher-view #top-students-card {
            order: 99;
        }
        .card, .list-item, .student-list-item, .tabs, .filter-bar, .tab-content { min-width: 0; max-width: 100%; }
        .home-overview-strip {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 2px;
        }
        .home-overview-card {
            background: linear-gradient(160deg, #ffffff, #f8fafc);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 12px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .home-overview-title {
            font-size: 0.78rem;
            color: #475569;
            margin-bottom: 4px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .home-overview-value {
            font-size: 1.18rem;
            font-weight: 800;
            color: #1d4ed8;
            line-height: 1.1;
        }
        .home-overview-meta {
            margin-top: 3px;
            font-size: 0.72rem;
            color: #64748b;
            text-align: center;
        }
        #app-screen.student-view {
            position: relative;
            background:
                radial-gradient(circle at top left, rgba(255, 209, 102, 0.38), transparent 28%),
                radial-gradient(circle at top right, rgba(34, 211, 238, 0.22), transparent 24%),
                linear-gradient(180deg, #fffaf0 0%, #f6fbff 40%, #eef7ff 100%);
            gap: 18px;
            padding: 18px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            justify-content: center;
        }
        #app-screen.student-view::before,
        #app-screen.student-view::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            filter: blur(10px);
            pointer-events: none;
            opacity: 0.65;
        }
        #app-screen.student-view::before {
            width: 140px;
            height: 140px;
            top: 72px;
            right: 28px;
            background: rgba(59, 130, 246, 0.14);
            animation: studentFloat 9s ease-in-out infinite;
        }
        #app-screen.student-view::after {
            width: 120px;
            height: 120px;
            left: 24px;
            bottom: 48px;
            background: rgba(251, 146, 60, 0.14);
            animation: studentFloat 11s ease-in-out infinite reverse;
        }
        #app-screen.student-view > * {
            position: relative;
            z-index: 1;
        }
        #app-screen.student-view .app-header,
        #app-screen.teacher-view .app-header {
            z-index: 50;
        }
        #user-menu {
            z-index: 120;
        }
        #user-dropdown {
            z-index: 130 !important;
        }
        #app-screen.student-view #home-overview-strip {
            display: none;
        }
        #app-screen.student-view #student-stats-bar {
            background: transparent;
            padding: 0;
            border: none;
            box-shadow: none;
        }
        #app-screen.student-view #student-stats-bar .stats-grid {
            display: none;
        }
        #student-hero-panel {
            display: none;
        }
        #app-screen.student-view #student-hero-panel {
            display: grid;
            grid-column: 1 / -1;
            grid-template-columns: minmax(0, 1.9fr) minmax(240px, 0.8fr);
            gap: 16px;
            align-items: start;
            /* ensure hero panel aligns vertically with main student sections */
            min-height: 520px;
            height: 520px;
            overflow: hidden;
        }
        .student-hero-main,
        .student-hero-side,
        .student-spark-card,
        .student-quick-card {
            border-radius: 26px;
            overflow: hidden;
        }
        .student-hero-main,
        .student-hero-side {
            height: 100%;
            min-height: 0;
            box-sizing: border-box;
        }
        .student-hero-main {
            position: relative;
            padding: 24px;
            color: #132238;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.92), transparent 24%),
                linear-gradient(135deg, #ffd166 0%, #ff9f68 30%, #6ecbf5 72%, #3b82f6 100%);
            box-shadow: 0 20px 45px rgba(59, 130, 246, 0.18);
            isolation: isolate;
        }
        .student-hero-main::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 15% 18%, rgba(255,255,255,0.36), transparent 18%),
                radial-gradient(circle at 88% 18%, rgba(255,255,255,0.18), transparent 16%);
            z-index: -1;
        }
        .student-hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(10px);
            font-size: 0.78rem;
            font-weight: 700;
            color: #0f3d91;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .student-hero-title {
            margin: 14px 0 10px;
            font-family: "Unbounded", sans-serif;
            font-size: clamp(1.5rem, 3vw, 2.4rem);
            line-height: 1.12;
            color: #0f172a;
        }
        .student-hero-message {
            max-width: 64ch;
            font-size: 0.98rem;
            line-height: 1.6;
            color: rgba(15, 23, 42, 0.82);
            margin: 0;
        }
        .student-hero-alert {
            margin-top: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            border: 2px solid #dc2626;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #7f1d1d;
            box-shadow: 0 10px 24px rgba(220, 38, 38, 0.22);
            display: none;
        }
        .student-hero-alert-title {
            font-size: 0.92rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .student-hero-alert-text {
            font-size: 0.88rem;
            font-weight: 700;
        }
        .student-hero-stats {
            margin-top: 18px;
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 10px;
        }
        .student-hero-stat {
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.35);
        }
        .student-hero-stat-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
        }
        .student-hero-stat-value {
            font-family: "Unbounded", sans-serif;
            font-size: 1.05rem;
            color: #0f172a;
        }
        .student-hero-progress {
            margin-top: 16px;
            padding: 16px 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.82);
        }
        .student-hero-progress-head {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            margin-bottom: 10px;
            font-weight: 700;
            color: #1e293b;
        }
        .student-hero-progress-track {
            height: 14px;
            border-radius: 999px;
            overflow: hidden;
            background: rgba(148, 163, 184, 0.2);
        }
        .student-hero-progress-fill {
            width: 0%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #22c55e 0%, #14b8a6 50%, #3b82f6 100%);
            transition: width 0.45s ease;
        }
        .student-hero-progress-note {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #334155;
        }
        .student-hero-side {
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-self: stretch;
            width: 100%;
        }
        .student-hero-side-bottom {
            grid-column: 1 / -1;
        }
        .student-hero-main {
            align-self: start;
        }
        .student-spark-card,
        .student-quick-card,
        #app-screen.student-view #student-homework-shell,
        #app-screen.student-view #student-apps-shell,
        #app-screen.student-view #leaderboard-section {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(14px);
        }
        .student-spark-card {
            padding: 18px;
        }
        .student-spark-title {
            font-family: "Unbounded", sans-serif;
            font-size: 1rem;
            margin: 0 0 6px;
            color: #132238;
        }
        .student-spark-sub {
            margin: 0;
            color: #475569;
            font-size: 0.88rem;
            line-height: 1.5;
        }
        .student-rank-pill {
            margin-top: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1d4ed8;
            font-weight: 700;
        }
        .student-quick-card {
            padding: 18px;
        }
        .student-quick-title {
            margin: 0 0 12px;
            font-family: "Unbounded", sans-serif;
            font-size: 0.96rem;
            color: #0f172a;
        }
        .student-quick-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
        .student-quick-btn {
            border: none;
            border-radius: 18px;
            padding: 14px 12px;
            text-align: left;
            cursor: pointer;
            color: #0f172a;
            font-weight: 700;
            background: linear-gradient(135deg, #fff7ed, #ffedd5);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .student-quick-btn:nth-child(2) { background: linear-gradient(135deg, #ecfeff, #cffafe); }
        .student-quick-btn:nth-child(3) { background: linear-gradient(135deg, #eff6ff, #dbeafe); }
        .student-quick-btn:nth-child(4) { background: linear-gradient(135deg, #f5f3ff, #ede9fe); }
        .student-quick-btn:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 10px 24px rgba(59, 130, 246, 0.12);
        }
        .student-quick-btn span {
            display: block;
            font-size: 0.78rem;
            font-weight: 500;
            color: #475569;
            margin-top: 4px;
        }

        /* Make leaderboard medal/texts take less horizontal space by placing them on a separate line */
        #top-students-list .top-student-medal,
        #leaderboard-list .top-student-medal {
            margin-left: 0;
            display: block;
            margin-top: 6px;
            font-size: 0.82rem;
        }
        .student-mini-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
            grid-column: 1 / -1;
        }
        .student-mini-card {
            padding: 16px;
            border-radius: 22px;
            color: #0f172a;
            background: rgba(255,255,255,0.78);
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
        }
        .student-mini-card:nth-child(1) { background: linear-gradient(135deg, #fff7ed, #ffedd5); }
        .student-mini-card:nth-child(2) { background: linear-gradient(135deg, #fef3c7, #fde68a); }
        .student-mini-card:nth-child(3) { background: linear-gradient(135deg, #ecfeff, #bae6fd); }
        .student-mini-card:nth-child(4) { background: linear-gradient(135deg, #eef2ff, #c7d2fe); }
        .student-mini-card:nth-child(5) { background: linear-gradient(135deg, #ecfccb, #bbf7d0); }
        .student-mini-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }
        .student-mini-value {
            font-family: "Unbounded", sans-serif;
            font-size: 1.18rem;
        }
        .student-mini-meta {
            margin-top: 6px;
            font-size: 0.8rem;
            color: #475569;
        }
        .badges-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            justify-content: flex-start;
        }
        .badge-card {
            padding: 12px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            display: grid;
            gap: 6px;
            text-align: center;
            justify-items: center;
        }
        .badge-card[data-tooltip] { position: relative; cursor: help; }
        .badge-card[data-tooltip]::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 50%;
            bottom: calc(100% + 8px);
            transform: translateX(-50%);
            background: #111827;
            color: #fff;
            padding: 8px 10px;
            border-radius: 10px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.2);
            z-index: 30;
        }
        .badge-card[data-tooltip]:hover::after { opacity: 1; }
        .badge-card .badge-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #dbeafe, #f0f9ff);
            display: grid;
            place-items: center;
            font-size: 24px;
            margin: 0 auto;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.18);
        }
        .badge-card .badge-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.92rem;
        }
        .badge-card .badge-desc {
            font-size: 0.8rem;
            color: #64748b;
        }
        .badge-card .badge-progress-row {
            display: grid;
            gap: 6px;
        }
        .badge-card .badge-progress-track {
            height: 8px;
            width: 100%;
            max-width: 280px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(148, 163, 184, 0.25), rgba(148, 163, 184, 0.15));
            overflow: hidden;
        }
        .badge-card .badge-progress-track span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #22c55e, #0ea5e9);
        }
        .badge-card .badge-progress-text {
            font-size: 0.82rem;
            color: #64748b;
        }
        .badge-card.earned {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-color: #86efac;
        }
        .badge-card.earned .badge-icon {
            background: #22c55e;
            color: #ffffff;
        }
        #badges-modal .badges-grid {
            gap: 16px;
        }
        #badges-modal .badge-card {
            padding: 14px;
            gap: 8px;
        }
        #badges-modal .badge-card .badge-icon {
            width: 54px;
            height: 54px;
            font-size: 30px;
            border-radius: 14px;
        }
        #badges-modal .badge-card .badge-name {
            font-size: 1.1rem;
        }
        #badges-modal .badge-card .badge-progress-text {
            font-size: 0.98rem;
        }
        #my-stats-modal .badges-grid {
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 240px));
            justify-content: flex-start;
            width: fit-content;
            max-width: 100%;
        }
        #my-stats-modal .badge-card {
            padding: 14px;
            gap: 8px;
        }
        #my-stats-modal .badge-card .badge-icon {
            width: 54px;
            height: 54px;
            font-size: 30px;
            border-radius: 14px;
        }
        #my-stats-modal .badge-card .badge-name {
            font-size: 1.1rem;
        }
        #my-stats-modal .badge-card .badge-progress-text {
            font-size: 0.98rem;
        }
        #app-screen.student-view #student-homework-shell,
        #app-screen.student-view #student-apps-shell,
        #app-screen.student-view #leaderboard-section {
            border-radius: 28px;
            padding: 18px;
        }
        #app-screen.student-view .student-shell-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        #app-screen.student-view .student-shell-head h3 {
            margin: 0;
            font-family: "Unbounded", sans-serif;
            font-size: 1.18rem;
            color: #0f172a;
        }
        #app-screen.student-view .student-shell-head p {
            margin: 6px 0 0;
            max-width: 58ch;
            color: #475569;
            line-height: 1.5;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #app-screen.student-view .student-combined-wrap .tabs {
            display: inline-flex !important;
            flex-wrap: wrap;
            gap: 8px;
            padding: 8px;
            border-radius: 999px;
            background: #edf4ff;
            margin-top: 0;
            width: fit-content;
        }
        #app-screen.student-view .student-combined-wrap .tab-btn {
            border-radius: 999px;
            padding: 10px 16px;
            border: none;
            background: transparent;
            font-weight: 700;
            color: #33507a;
        }
        #app-screen.student-view .student-combined-wrap .tab-btn.active {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            color: #fff;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
        }
        #app-screen.teacher-view #teacher-home-tabs,
        #app-screen.teacher-view #block-homework-assign-tabs {
            display: flex !important;
            flex-wrap: nowrap;
            gap: 8px;
            padding: 8px;
            border-radius: 999px;
            background: #eef2f6;
            width: 100%;
            margin-top: 0 !important;
            margin-bottom: 8px !important;
            align-self: stretch;
            justify-content: space-between;
        }
        #app-screen.teacher-view #teacher-home-tabs .tab-btn,
        #app-screen.teacher-view #block-homework-assign-tabs .tab-btn {
            border-radius: 999px;
            padding: 10px 16px;
            border: none;
            background: #eef2f6;
            font-weight: 700;
            color: #475569;
            height: auto;
            flex: 1 1 0;
            min-width: 0;
        }
        #app-screen.teacher-view #teacher-home-tabs .tab-btn.active,
        #app-screen.teacher-view #block-homework-assign-tabs .tab-btn.active {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            color: #fff;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
        }
        #app-screen.student-view .status-split {
            gap: 14px;
            margin-top: 0;
        }
        #app-screen.student-view .status-split .tab-content {
            padding: 14px;
            border-radius: 22px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border: 1px solid #e5eefc;
        }
        #app-screen.student-view #student-homework-shell .list-item,
        #app-screen.student-view #student-apps-shell .list-item {
            border-left: 0;
            padding: 14px 16px;
            margin-bottom: 10px;
            border-radius: 18px;
            background: linear-gradient(135deg, #ffffff, #f8fbff);
            box-shadow: 0 8px 20px rgba(148, 163, 184, 0.1);
        }
        #app-screen.student-view #student-homework-shell .list-item:hover,
        #app-screen.student-view #student-apps-shell .list-item:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #ffffff, #eef6ff);
        }
        #app-screen.student-view #leaderboard-section h3 {
            margin: 0;
            font-family: "Unbounded", sans-serif;
            color: #0f172a;
        }
        /* Keep leaderboard height from stretching the level map */
        #app-screen.student-view #student-hero-panel #leaderboard-section {
            height: 100%;
            max-height: 520px;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        #app-screen.student-view #student-hero-panel #leaderboard-list {
            flex: 1;
            min-height: 0;
            overflow: auto;
        }
        #app-screen.student-view #leaderboard-list {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        #app-screen.student-view #leaderboard-list .top-student-row {
            min-height: 54px;
            padding: 6px 8px;
            gap: 6px;
            border-radius: 12px;
            border: 1px solid #dbeafe;
            background: rgba(255,255,255,0.96);
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        /* Force student leaderboard typography to match teacher list */
        #app-screen.student-view #leaderboard-list .top-student-name {
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
            font-size: 0.98rem;
            font-family: "Inter", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            letter-spacing: -0.01em;
            text-align: left;
        }
        #app-screen.student-view #leaderboard-list .top-student-meta {
            color: #64748b;
            font-size: 0.8rem;
            margin-top: 0;
        }
        #app-screen.student-view #leaderboard-list .top-student-xp {
            font-weight: 800;
            color: #047857;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 999px;
            padding: 4px 6px;
            font-size: 0.82rem;
            white-space: nowrap;
        }
        @keyframes studentFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @media (max-width: 980px) {
            #app-screen.student-view #student-hero-panel {
                grid-template-columns: 1fr;
                height: auto;
                min-height: 0;
            }
            #app-screen.student-view {
                grid-template-columns: 1fr;
            }
            .student-hero-stats,
            .student-mini-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .student-hero-main,
            .student-hero-side {
                height: auto;
                min-height: 0;
            }
            #app-screen.student-view #student-hero-panel #leaderboard-section {
                max-height: none;
                height: auto;
            }
            #app-screen.student-view #student-hero-panel #leaderboard-list {
                overflow: visible;
            }
        }
        @media (max-width: 640px) {
            #app-screen.student-view {
                padding: 12px;
                gap: 14px;
            }
            .student-hero-main,
            .student-spark-card,
            .student-quick-card,
            #app-screen.student-view #student-homework-shell,
            #app-screen.student-view #student-apps-shell,
            #app-screen.student-view #leaderboard-section {
                border-radius: 22px;
                padding: 14px;
            }
            .student-hero-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .student-quick-grid,
            #app-screen.student-view .status-split {
                grid-template-columns: 1fr;
            }
            .student-mini-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                width: 100%;
                justify-items: center;
            }
            .student-mini-card:last-child {
                grid-column: 1 / -1;
            }
            .student-mini-card {
                width: 100%;
            }
            #app-screen.student-view #student-hero-panel {
                display: flex;
                flex-direction: column;
                gap: 14px;
            }
            #app-screen.student-view #student-hero-panel .student-hero-main {
                order: 1;
            }
            #app-screen.student-view #student-hero-panel .student-mini-grid {
                order: 2;
            }
            #app-screen.student-view #student-hero-panel .student-hero-side {
                order: 3;
            }
            #app-screen.student-view .student-combined-wrap .tabs {
                width: 100%;
            }
            #app-screen.student-view .student-combined-wrap .tab-btn {
                flex: 1 1 auto;
                text-align: center;
            }
        }
        /* Align leaderboard height with level map and keep list inside */
        #app-screen.student-view #student-hero-panel #leaderboard-section {
            height: 100% !important;
            max-height: 520px !important;
            min-height: 0 !important;
            display: flex;
            flex-direction: column;
        }
        #app-screen.student-view #student-hero-panel #leaderboard-list {
            flex: 1;
            min-height: 0;
            overflow: auto;
            padding-right: 4px;
        }
        #teacher-hero-panel {
            display: none;
        }
        #app-screen.teacher-view {
            position: relative;
            background:
                radial-gradient(circle at top left, rgba(148, 163, 184, 0.18), transparent 25%),
                linear-gradient(180deg, #f6f8fb 0%, #eef3f8 100%);
            gap: 16px;
            padding: 16px;
        }
        #app-screen.teacher-view > * {
            position: relative;
            z-index: 1;
        }
        #app-screen.teacher-view > .app-header {
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            margin-bottom: 0;
            border-radius: 22px;
            background: rgba(255,255,255,0.82);
            border: 1px solid rgba(148, 163, 184, 0.2);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(10px);
        }
        #app-screen.teacher-view #user-fullname,
        #app-screen.teacher-view #header-center-logo {
            display: none;
        }
        #app-screen.teacher-view #user-welcome {
            display: none !important;
        }
        #app-screen.teacher-view #header-center-logo {
            display: inline-flex !important;
            grid-column: 2;
            justify-self: center;
        }
        #app-screen.teacher-view #theme-toggle-app {
            grid-column: 3;
            justify-self: end;
        }
        #app-screen.teacher-view #user-menu {
            grid-column: 4;
            justify-self: end;
        }
        #app-screen.teacher-view #theme-toggle-app,
        #app-screen.teacher-view #user-menu-trigger {
            min-height: 42px;
            border-radius: 14px;
            border: 1px solid #d9e2ec;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
        }
        #app-screen.teacher-view #user-menu-trigger {
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            color: #0f172a;
            font-weight: 700;
            padding: 10px 16px;
        }
        #app-screen.teacher-view #open-menu {
            position: static !important;
            width: 46px;
            height: 46px;
            padding: 0 !important;
            border-radius: 14px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 8px 0 0;
            flex: 0 0 46px;
        }
        #app-screen.teacher-view #teacher-hero-panel {
            display: grid;
            grid-column: 1 / -1;
            grid-template-columns: minmax(0, 1.45fr) minmax(320px, 0.95fr);
            gap: 16px;
        }
        .teacher-hero-main,
        .teacher-hero-side,
        .teacher-hero-quick,
        .teacher-hero-metric {
            border-radius: 24px;
        }
        .teacher-hero-main,
        .teacher-hero-quick,
        .teacher-hero-side,
        #app-screen.teacher-view #teacher-analytics,
        #app-screen.teacher-view #top-students-card,
        #app-screen.teacher-view #student-homework-shell,
        #app-screen.teacher-view #block-homework-section {
            background: rgba(255,255,255,0.88);
            border: 1px solid rgba(148, 163, 184, 0.2);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(12px);
        }
        .teacher-hero-main {
            padding: 22px 24px;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.7), transparent 22%),
                linear-gradient(145deg, #f8fafc 0%, #e8eef6 100%);
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(59, 130, 246, 0.22);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        }
        #app-screen.teacher-view {
            background:
                radial-gradient(circle at 12% 8%, rgba(59, 130, 246, 0.08), transparent 32%),
                radial-gradient(circle at 88% 14%, rgba(16, 185, 129, 0.08), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        }
        .teacher-hero-main::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            top: -46px;
            right: -20px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.22), rgba(96, 165, 250, 0) 68%);
            pointer-events: none;
            animation: teacherOrbFloat 7s ease-in-out infinite;
        }
        .teacher-hero-kicker {
            display: inline-flex;
            align-items: center;
            padding: 10px 12px;
            border-radius: 999px;
            background: #e2e8f0;
            color: #334155;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .teacher-hero-title {
            margin: 14px 0 10px;
            font-family: "Unbounded", sans-serif;
            font-size: clamp(1.35rem, 2.7vw, 2.2rem);
            line-height: 1.14;
            color: #0f172a;
        }
        .teacher-hero-text {
            margin: 0;
            color: #475569;
            line-height: 1.5;
            max-width: 38ch;
            font-size: 0.92rem;
        }
        .teacher-hero-topline {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) 220px;
            gap: 18px;
            align-items: center;
        }
        .teacher-hero-metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-top: 18px;
        }
        .teacher-hero-metric {
            padding: 14px 15px;
            background: rgba(255,255,255,0.86);
            border: 1px solid rgba(148, 163, 184, 0.14);
        }
        .teacher-hero-metric-label {
            font-size: 0.76rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .teacher-hero-metric-value {
            font-family: "Unbounded", sans-serif;
            font-size: 1rem;
            color: #0f172a;
        }
        .teacher-hero-visual {
            position: relative;
            min-height: 190px;
            border-radius: 24px;
            background: linear-gradient(180deg, #f8fafc, #eef2f7);
            border: 1px solid rgba(148, 163, 184, 0.2);
            overflow: hidden;
            padding: 22px 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 12px;
        }
        .teacher-hero-visual::before {
            content: none;
        }
        .teacher-hero-core {
            position: absolute;
            inset: 50% auto auto 50%;
            width: 54px;
            height: 54px;
            margin-left: -27px;
            margin-top: -27px;
            border-radius: 16px;
            background: linear-gradient(135deg, #38bdf8, #2563eb);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.22);
        }
        .teacher-hero-core::before,
        .teacher-hero-core::after {
            content: none;
        }
        .teacher-hero-dot {
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 6px;
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.18);
            transform: rotate(45deg);
            border: 1px solid rgba(148, 163, 184, 0.32);
        }
        .teacher-hero-dot.dot-a { top: 24px; left: 40px; background: #38bdf8; animation: teacherDotFloat 4.8s ease-in-out infinite; }
        .teacher-hero-dot.dot-b { right: 30px; top: 58px; background: #f59e0b; animation: teacherDotFloat 5.6s ease-in-out infinite reverse; }
        .teacher-hero-dot.dot-c { left: 66px; bottom: 26px; background: #22c55e; animation: teacherDotFloat 5.2s ease-in-out infinite; }
        .teacher-hero-rail {
            position: absolute;
            left: 28px;
            right: 28px;
            bottom: 24px;
            display: grid;
            gap: 10px;
        }
        .teacher-hero-rail.is-summary {
            position: static;
            left: auto;
            right: auto;
            bottom: auto;
            gap: 12px;
        }
        .teacher-hero-summary-title {
            font-family: "Unbounded", sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
        }
        .teacher-hero-summary-sub {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: -4px;
        }
        .teacher-hero-rail-item {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 10px;
            align-items: center;
            font-size: 0.78rem;
            color: #475569;
            font-weight: 700;
        }
        .teacher-hero-rail-track {
            height: 8px;
            border-radius: 999px;
            background: rgba(148, 163, 184, 0.18);
            border: 1px solid rgba(148, 163, 184, 0.35);
            overflow: hidden;
        }
        .teacher-hero-rail-fill {
            width: 0%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #22d3ee, #2563eb);
            transition: width 0.45s ease;
        }
        .teacher-hero-signal-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px;
        }
        .teacher-hero-signal {
            border-radius: 18px;
            padding: 14px 16px;
            background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(248,250,252,0.88));
            border: 1px solid rgba(148, 163, 184, 0.16);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.05);
        }
        .teacher-hero-signal-kicker {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 8px;
        }
        .teacher-hero-signal-title {
            font-size: 0.98rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.3;
            margin-bottom: 6px;
        }
        .teacher-hero-signal-text {
            color: #475569;
            font-size: 0.78rem;
            line-height: 1.45;
        }
        .teacher-hero-side {
            display: grid;
            gap: 16px;
        }
        .teacher-hero-side .panel-accent {
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 20px;
            padding: 10px;
            background: linear-gradient(135deg, rgba(224, 231, 255, 0.4), rgba(240, 253, 250, 0.65));
        }
        .teacher-hero-side .panel-accent h4 {
            margin: 0 0 6px;
            font-size: 0.9rem;
            color: #1e3a8a;
            font-weight: 800;
        }
        .teacher-hero-side .panel-accent .mini-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 6px;
        }
        @media (max-width: 900px) {
            .teacher-hero-side .panel-accent .mini-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        .teacher-hero-side .panel-accent .mini-card {
            border-radius: 14px;
            padding: 8px;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.06);
        }
        .teacher-hero-side .panel-accent .mini-card:nth-child(1) {
            background: linear-gradient(135deg, rgba(219, 234, 254, 0.9), #ffffff);
            border-color: rgba(59, 130, 246, 0.35);
        }
        .teacher-hero-side .panel-accent .mini-card:nth-child(2) {
            background: linear-gradient(135deg, rgba(209, 250, 229, 0.9), #ffffff);
            border-color: rgba(16, 185, 129, 0.35);
        }
        .teacher-hero-side .panel-accent .mini-card:nth-child(3) {
            background: linear-gradient(135deg, rgba(254, 243, 199, 0.9), #ffffff);
            border-color: rgba(245, 158, 11, 0.35);
        }
        .teacher-hero-side .panel-accent .mini-card:nth-child(4) {
            background: linear-gradient(135deg, rgba(237, 233, 254, 0.9), #ffffff);
            border-color: rgba(139, 92, 246, 0.35);
        }
        .teacher-hero-side .panel-accent .mini-card .k {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
        }
        .teacher-hero-side .panel-accent .mini-card .v {
            font-size: 0.9rem;
            font-weight: 800;
            color: #0f172a;
        }
        .teacher-hero-side .panel-accent .mini-card .s {
            font-size: 0.68rem;
            color: #475569;
        }
        .teacher-hero-quick {
            padding: 20px;
        }
        .teacher-hero-quick h3,
        .teacher-hero-side h3 {
            margin: 0 0 10px;
            font-family: "Unbounded", sans-serif;
            font-size: 1rem;
            color: #0f172a;
        }
        .teacher-hero-side p {
            margin: 0;
            color: #475569;
            line-height: 1.55;
        }
        .teacher-quick-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
        .teacher-info-card {
            border: 1px solid #dbe3ed;
            border-radius: 18px;
            padding: 14px;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            color: #0f172a;
            min-height: 92px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            animation: teacherCardFloat 6.5s ease-in-out infinite;
        }
        .teacher-quick-grid .teacher-info-card:nth-child(1) { box-shadow: inset 4px 0 0 rgba(59, 130, 246, 0.35); }
        .teacher-quick-grid .teacher-info-card:nth-child(2) { box-shadow: inset 4px 0 0 rgba(16, 185, 129, 0.35); }
        .teacher-quick-grid .teacher-info-card:nth-child(3) { box-shadow: inset 4px 0 0 rgba(245, 158, 11, 0.35); }
        .teacher-quick-grid .teacher-info-card:nth-child(4) { box-shadow: inset 4px 0 0 rgba(139, 92, 246, 0.35); }
        .teacher-info-card:nth-child(2) { animation-delay: -1.6s; }
        .teacher-info-card:nth-child(3) { animation-delay: -3.1s; }
        .teacher-info-card:nth-child(4) { animation-delay: -4.4s; }
        .teacher-info-kicker {
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #64748b;
        }
        .teacher-info-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
        }
        .teacher-info-text {
            color: #475569;
            font-size: 0.72rem;
            line-height: 1.35;
        }
        .teacher-info-bar {
            height: 7px;
            border-radius: 999px;
            background: rgba(148, 163, 184, 0.22);
            overflow: hidden;
        }
        .teacher-info-bar > span {
            display: block;
            width: 0%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #60a5fa, #2563eb);
            transition: width 0.45s ease;
            position: relative;
            overflow: hidden;
        }
        .teacher-info-bar > span::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0) 100%);
            transform: translateX(-120%);
            animation: teacherBarShine 3.2s ease-in-out infinite;
        }
        .teacher-hero-rail-fill {
            position: relative;
            overflow: hidden;
        }
        .teacher-hero-rail-fill::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.45) 50%, rgba(255,255,255,0) 100%);
            transform: translateX(-120%);
            animation: teacherBarShine 3.6s ease-in-out infinite;
        }
        @keyframes teacherCardFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        @keyframes teacherBarShine {
            0% { transform: translateX(-120%); }
            60% { transform: translateX(120%); }
            100% { transform: translateX(120%); }
        }
        #app-screen.teacher-view #teacher-analytics,
        #app-screen.teacher-view #top-students-card,
        #app-screen.teacher-view #student-homework-shell,
        #app-screen.teacher-view #block-homework-section {
            border-radius: 26px;
            padding: 18px;
        }
        #app-screen.teacher-view #teacher-home-tabs,
        #app-screen.teacher-view #block-homework-assign-tabs,
        #app-screen.teacher-view #student-tabs,
        #app-screen.teacher-view #activities-tabs,
        #app-screen.teacher-view #lessons-tabs,
        #app-screen.teacher-view #quiz-tabs,
        #app-screen.teacher-view #block-homework-tabs,
        #app-screen.teacher-view #compute-homework-tabs {
            gap: 8px;
            padding: 8px;
            border-radius: 18px;
            background: #eef3f8;
            border: 1px solid #dce4ee;
        }
        #app-screen.teacher-view #teacher-home-tabs,
        #app-screen.teacher-view #block-homework-assign-tabs {
            background: transparent;
            border-color: transparent;
        }
        #app-screen.teacher-view .tab-btn {
            border: 0;
            border-bottom: 0;
            border-radius: 14px;
            min-height: 42px;
            padding: 10px 14px;
            font-size: 0.92rem;
            font-weight: 700;
            color: #475569;
        }
        #app-screen.teacher-view .tab-btn.active {
            color: #0f172a;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        }
        #app-screen.teacher-view #tasks-section .list-item,
        #app-screen.teacher-view #activities-section .list-item,
        #app-screen.teacher-view #lessons-section .list-item,
        #app-screen.teacher-view #block-homework-section .list-item,
        #app-screen.teacher-view #quiz-section .list-item {
            padding: 14px 16px;
            border-radius: 18px;
            border-left: 0;
            border: 1px solid #e2e8f0;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.05);
        }
        #app-screen.teacher-view #tasks-section .list-item:hover,
        #app-screen.teacher-view #activities-section .list-item:hover,
        #app-screen.teacher-view #lessons-section .list-item:hover,
        #app-screen.teacher-view #block-homework-section .list-item:hover,
        #app-screen.teacher-view #quiz-section .list-item:hover {
            transform: translateY(-1px);
            background: linear-gradient(180deg, #ffffff, #f2f7fc);
        }
        #app-screen.teacher-view .teacher-app-stats {
            padding: 10px;
            border-radius: 18px;
            background: linear-gradient(180deg, #f8fbff, #eef4fb);
            border: 1px solid #dce6f2;
        }
        #app-screen.teacher-view .teacher-app-stats-tile,
        #app-screen.teacher-view .teacher-app-stats-btn-tile {
            border-radius: 14px;
            border: 1px solid #dbe6f3;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            box-shadow: none;
        }
        #app-screen.teacher-view #teacher-analytics #stats-content > .card {
            padding: 0;
            background: transparent;
            box-shadow: none;
            border: 0;
        }
        #app-screen.teacher-view #teacher-analytics h4,
        #app-screen.teacher-view #top-students-card h4 {
            margin: 0 0 14px;
            font-family: "Unbounded", sans-serif;
            font-size: 1.04rem;
            color: #0f172a;
        }
        #app-screen.teacher-view .stats-summary-grid .stat-card,
        #app-screen.teacher-view .teacher-mini-stats-grid .stat-card {
            border-radius: 18px;
            border: 1px solid #dbe4ef;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.05);
        }
        #app-screen.teacher-view .stat-number {
            font-family: "Unbounded", sans-serif;
            font-size: 1.08rem;
            color: #0f172a;
        }
        #app-screen.teacher-view .stat-label {
            color: #64748b;
            font-weight: 700;
        }
        #app-screen.teacher-view #teacher-analytics .teacher-type-panel,
        #app-screen.teacher-view #teacher-analytics .teacher-pie-panel {
            border-radius: 22px;
            background: linear-gradient(180deg, #f8fbff, #eef4fb);
            border: 1px solid #dbe5f0;
            box-shadow: none;
        }
        #app-screen.teacher-view .btn,
        #app-screen.student-view .btn {
            min-height: 42px;
            border-radius: 14px;
            font-weight: 700;
            letter-spacing: 0.01em;
        }
        #app-screen.teacher-view .btn.btn-primary {
            background: linear-gradient(180deg, #2563eb, #1d4ed8);
            border: 0;
            box-shadow: 0 10px 18px rgba(37, 99, 235, 0.2);
        }
        #app-screen.student-view .btn.btn-primary {
            box-shadow: 0 10px 18px rgba(59, 130, 246, 0.18);
        }
        body.dark-mode #app-screen.student-view {
            background:
                radial-gradient(circle at top left, rgba(245, 158, 11, 0.14), transparent 24%),
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.16), transparent 22%),
                linear-gradient(180deg, #0b1220 0%, #111827 100%) !important;
        }
        body.dark-mode #app-screen.student-view #student-hero-panel,
        body.dark-mode #app-screen.teacher-view #teacher-hero-panel {
            color: #e5e7eb;
        }
        body.dark-mode .student-hero-main {
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.08), transparent 22%),
                linear-gradient(145deg, #1e293b 0%, #0f3b66 48%, #1d4ed8 100%) !important;
            box-shadow: 0 20px 40px rgba(2, 6, 23, 0.38);
        }
        body.dark-mode .student-hero-kicker,
        body.dark-mode .teacher-hero-kicker {
            background: rgba(15, 23, 42, 0.65);
            color: #dbeafe;
        }
        body.dark-mode .student-hero-title,
        body.dark-mode .teacher-hero-title,
        body.dark-mode .student-spark-title,
        body.dark-mode .student-quick-title,
        body.dark-mode .teacher-hero-quick h3,
        body.dark-mode .teacher-hero-side h3 {
            color: #f8fafc !important;
        }
        body.dark-mode .student-hero-message,
        body.dark-mode .student-hero-progress-note,
        body.dark-mode .student-spark-sub,
        body.dark-mode .teacher-hero-text,
        body.dark-mode .teacher-hero-side p,
        body.dark-mode .teacher-quick-btn span,
        body.dark-mode .student-quick-btn span,
        body.dark-mode .student-mini-meta {
            color: #cbd5e1 !important;
        }
        body.dark-mode .student-hero-stat,
        body.dark-mode .student-mini-card,
        body.dark-mode .student-spark-card,
        body.dark-mode .student-quick-card,
        body.dark-mode .teacher-hero-main,
        body.dark-mode .teacher-hero-quick,
        body.dark-mode .teacher-hero-side,
        body.dark-mode .teacher-hero-metric {
            border-color: #334155 !important;
        }
        body.dark-mode .student-hero-stat,
        body.dark-mode .teacher-hero-metric,
        body.dark-mode .student-mini-card {
            background: rgba(15, 23, 42, 0.72) !important;
            color: #e5e7eb !important;
        }
        body.dark-mode .student-hero-stat-label,
        body.dark-mode .teacher-hero-metric-label,
        body.dark-mode .student-mini-label {
            color: #94a3b8 !important;
        }
        body.dark-mode .student-hero-stat-value,
        body.dark-mode .teacher-hero-metric-value,
        body.dark-mode .student-mini-value,
        body.dark-mode .student-rank-pill {
            color: #f8fafc !important;
        }
        body.dark-mode .student-hero-alert {
            border-color: #ef4444 !important;
            background: linear-gradient(135deg, rgba(127, 29, 29, 0.9), rgba(153, 27, 27, 0.8)) !important;
            color: #fee2e2 !important;
            box-shadow: 0 12px 28px rgba(239, 68, 68, 0.28) !important;
        }
        body.dark-mode .student-rank-pill {
            background: linear-gradient(135deg, #1e3a8a, #1d4ed8) !important;
        }
        body.dark-mode .student-quick-btn {
            background: linear-gradient(180deg, #111827, #0f172a) !important;
            border-color: #334155 !important;
            color: #e5e7eb !important;
            box-shadow: none !important;
        }
        body.dark-mode .teacher-hero-quick {
            background: linear-gradient(180deg, #111827, #0f172a) !important;
            border-color: #334155 !important;
            box-shadow: 0 8px 18px rgba(2, 6, 23, 0.22) !important;
        }
        body.dark-mode .teacher-hero-side {
            background: linear-gradient(180deg, #111827, #0f172a) !important;
            border-color: #334155 !important;
            box-shadow: 0 8px 18px rgba(2, 6, 23, 0.22) !important;
            padding: 12px;
            gap: 12px;
        }
        body.dark-mode .teacher-info-card {
            background: linear-gradient(180deg, #162033, #0f172a) !important;
            border-color: #42506a !important;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.05);
        }
        body.dark-mode .teacher-info-kicker {
            color: #93c5fd !important;
        }
        body.dark-mode .teacher-info-title {
            color: #f8fafc !important;
        }
        body.dark-mode .teacher-info-text {
            color: #cbd5e1 !important;
        }
        body.dark-mode #app-screen.teacher-view {
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.12), transparent 24%),
                linear-gradient(180deg, #0b1220 0%, #111827 100%) !important;
        }
        body.dark-mode .teacher-hero-main {
            background:
                radial-gradient(circle at top right, rgba(96, 165, 250, 0.12), transparent 20%),
                linear-gradient(145deg, #162033 0%, #0f172a 58%, #0b1220 100%) !important;
            box-shadow: 0 18px 36px rgba(2, 6, 23, 0.34) !important;
        }
        body.dark-mode .teacher-hero-visual {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.98), rgba(2, 6, 23, 0.96)) !important;
            border-color: rgba(148, 163, 184, 0.22) !important;
        }
        body.dark-mode .teacher-hero-core {
            background: linear-gradient(135deg, #38bdf8, #2563eb);
        }
        body.dark-mode .teacher-hero-summary-title {
            color: #f8fafc;
        }
        body.dark-mode .teacher-hero-summary-sub {
            color: #94a3b8;
        }
        body.dark-mode .teacher-hero-rail-item {
            color: #cbd5e1 !important;
        }
        body.dark-mode .teacher-hero-rail-track {
            background: rgba(71, 85, 105, 0.46);
            border: 1px solid rgba(148, 163, 184, 0.28);
        }
        body.dark-mode .teacher-hero-main .teacher-hero-text,
        body.dark-mode .teacher-hero-main .teacher-hero-title,
        body.dark-mode .teacher-hero-main .teacher-hero-kicker {
            position: relative;
            z-index: 1;
        }
        body.dark-mode .teacher-hero-text {
            color: #cbd5e1 !important;
        }
        body.dark-mode .teacher-hero-metrics {
            gap: 12px;
        }
        body.dark-mode .teacher-hero-metric {
            background: linear-gradient(180deg, #1e293b, #172033) !important;
            border-color: #475569 !important;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.06);
        }
        body.dark-mode .teacher-hero-metric-label {
            color: #93c5fd !important;
        }
        body.dark-mode .teacher-hero-metric-value {
            color: #f8fafc !important;
        }
        body.dark-mode .teacher-hero-signal {
            background: linear-gradient(180deg, #162033, #101827) !important;
            border-color: #42506a !important;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.04);
        }
        body.dark-mode .teacher-hero-signal-kicker {
            color: #93c5fd !important;
        }
        body.dark-mode .teacher-hero-signal-title {
            color: #f8fafc !important;
        }
        body.dark-mode .teacher-hero-signal-text {
            color: #cbd5e1 !important;
        }
        body.dark-mode .teacher-info-bar {
            background: rgba(71, 85, 105, 0.46);
        }
        body.dark-mode #app-screen.teacher-view > .app-header {
            background: rgba(15, 23, 42, 0.88) !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 24px rgba(2, 6, 23, 0.34) !important;
        }
        body.dark-mode #app-screen.teacher-view #user-welcome,
        body.dark-mode #app-screen.teacher-view #user-menu-trigger {
            color: #f8fafc !important;
        }
        body.dark-mode #app-screen.teacher-view #user-menu-trigger,
        body.dark-mode #app-screen.teacher-view #theme-toggle-app {
            background: #111827 !important;
            border-color: #334155 !important;
            box-shadow: none !important;
        }
        body.dark-mode #app-screen.teacher-view #teacher-analytics,
        body.dark-mode #app-screen.teacher-view #top-students-card,
        body.dark-mode #app-screen.teacher-view #student-homework-shell,
        body.dark-mode #app-screen.teacher-view #block-homework-section {
            background: linear-gradient(180deg, #0f172a, #111827) !important;
        }
        body.dark-mode #app-screen.teacher-view #teacher-home-tabs,
        body.dark-mode #app-screen.teacher-view #block-homework-assign-tabs,
        body.dark-mode #app-screen.teacher-view #student-tabs,
        body.dark-mode #app-screen.teacher-view #activities-tabs,
        body.dark-mode #app-screen.teacher-view #lessons-tabs,
        body.dark-mode #app-screen.teacher-view #quiz-tabs,
        body.dark-mode #app-screen.teacher-view #block-homework-tabs,
        body.dark-mode #app-screen.teacher-view #compute-homework-tabs {
            background: #0f1b33 !important;
            border-color: #334155 !important;
        }
        body.dark-mode #app-screen.teacher-view .tab-btn {
            color: #cbd5e1 !important;
        }
        body.dark-mode #app-screen.teacher-view .tab-btn.active {
            background: linear-gradient(180deg, #1e293b, #0f172a) !important;
            color: #f8fafc !important;
            box-shadow: none !important;
        }
        body.dark-mode #app-screen.teacher-view .teacher-app-stats,
        body.dark-mode #app-screen.teacher-view .teacher-type-panel,
        body.dark-mode #app-screen.teacher-view .teacher-pie-panel,
        body.dark-mode #app-screen.teacher-view .stats-summary-grid .stat-card,
        body.dark-mode #app-screen.teacher-view .teacher-mini-stats-grid .stat-card,
        body.dark-mode #app-screen.teacher-view .teacher-app-stats-tile,
        body.dark-mode #app-screen.teacher-view .teacher-app-stats-btn-tile,
        body.dark-mode #app-screen.teacher-view .list-item {
            background: linear-gradient(180deg, #111827, #0f172a) !important;
            border-color: #334155 !important;
            box-shadow: none !important;
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.85), rgba(15, 23, 42, 0.95));
            border-color: #334155;
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent h4 {
            color: #e2e8f0;
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent .mini-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(30, 41, 59, 0.9));
            border-color: rgba(71, 85, 105, 0.6);
            box-shadow: none;
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent .mini-card:nth-child(1) {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.35), rgba(15, 23, 42, 0.9));
            border-color: rgba(59, 130, 246, 0.55);
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent .mini-card:nth-child(2) {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.35), rgba(15, 23, 42, 0.9));
            border-color: rgba(16, 185, 129, 0.55);
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent .mini-card:nth-child(3) {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(15, 23, 42, 0.9));
            border-color: rgba(245, 158, 11, 0.55);
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent .mini-card:nth-child(4) {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.35), rgba(15, 23, 42, 0.9));
            border-color: rgba(139, 92, 246, 0.55);
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent .mini-card .k {
            color: #cbd5f5;
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent .mini-card .v {
            color: #f8fafc;
        }
        body.dark-mode #app-screen.teacher-view .teacher-hero-side .panel-accent .mini-card .s {
            color: #cbd5e1;
        }
        @media (max-width: 1100px) {
            #app-screen.teacher-view #teacher-hero-panel {
                grid-template-columns: 1fr;
            }
            .teacher-hero-metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .teacher-hero-topline,
            .teacher-hero-signal-grid {
                grid-template-columns: 1fr;
            }
        }
        @keyframes teacherOrbFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(8px); }
        }
        @keyframes teacherPulseRing {
            0% { opacity: 0.72; transform: scale(0.92); }
            100% { opacity: 0; transform: scale(1.18); }
        }
        @keyframes teacherDotFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @media (max-width: 720px) {
            #app-screen.teacher-view > .app-header {
                grid-template-columns: minmax(0, 1fr) auto auto;
                gap: 10px;
                padding: 12px 14px;
                align-items: start;
            }
            #app-screen.teacher-view #theme-toggle-app {
                grid-column: 2;
                grid-row: 1;
                justify-self: end;
            }
            #app-screen.teacher-view #user-menu {
                grid-column: 3;
                grid-row: 1;
                justify-self: end;
                align-self: start;
                justify-content: flex-end;
                width: auto;
            }
            #app-screen.teacher-view #user-welcome {
                display: none !important;
            }
            #app-screen.teacher-view #user-menu-trigger {
                padding: 8px 12px;
                min-height: 38px;
                font-size: 0.85rem;
            }
            .teacher-hero-metrics,
            .teacher-quick-grid,
            .teacher-hero-signal-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .teacher-hero-metrics > *,
            .teacher-quick-grid > *,
            .teacher-hero-signal-grid > * {
                grid-column: auto;
            }
        }
        /* Anasayfa kartlarını esnek tut */
        #tasks-section,
        #activities-section,
        #quiz-section,
        #block-homework-section,
        #compute-homework-section,
        #lessons-section,
        #leaderboard-section,
        #top-students-card {
            display: flex;
            flex-direction: column;
            min-height: 0;
        }
        #student-homework-shell,
        #student-apps-shell {
            display: contents;
        }
        .student-shell-head {
            display: none;
        }
        .student-combined-wrap {
            display: none;
        }
        #app-screen.student-view .student-combined-wrap {
            display: flex;
            flex-direction: column;
            min-height: 0;
            flex: 1;
        }
        .student-combined-wrap .tabs {
            margin-top: 10px;
        }
        .student-combined-wrap .tab-content {
            margin-top: 10px;
            min-height: 0;
            overflow: auto;
            flex: 1;
        }
        #app-screen.student-view .student-combined-wrap .tabs {
            margin-top: 0 !important;
        }
        #app-screen.student-view .student-combined-wrap .tab-content {
            margin-top: 0 !important;
        }
        .student-shell-body {
            display: contents;
        }
        #tasks-section .tab-content,
        #activities-section .tab-content,
        #block-homework-section .tab-content,
        #compute-homework-section .tab-content,
        #lessons-section .tab-content {
            flex: 1;
            min-height: 0;
            overflow: auto;
        }
        /* Bekleyen/Tamamlanan kutularini yanyana goster */
        .status-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            min-height: 0;
        }
        .status-split-head {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 6px 0 8px;
        }
        .status-split-head .col-title {
            font-size: 0.84rem;
            font-weight: 700;
            color: #475569;
            text-align: center;
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
        }
        #block-homework-section .status-split .tab-content,
        #compute-homework-section .status-split .tab-content,
        #app-screen.teacher-view #student-homework-combined .status-split .tab-content,
        #app-screen.teacher-view #student-apps-combined .status-split .tab-content {
            display: block !important;
            min-height: 0;
        }
        #student-homework-tabs,
        #student-apps-tabs {
            display: none !important;
        }
        .teacher-app-stats {
            margin: 6px 0 4px;
            padding: 2px 8px;
            min-height: 0;
            background: #f0f7ff;
            border-radius: 8px;
        }
        .teacher-app-stats-title {
            font-size: 12px;
            margin-bottom: 1px;
            text-align: center;
            min-height: 0;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .teacher-app-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
            align-items: stretch;
        }
        #teacher-stats .teacher-app-stats-grid,
        #activities-teacher-stats .teacher-app-stats-grid,
        #lessons-teacher-stats .teacher-app-stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            justify-content: stretch;
        }
        .teacher-app-stats-tile {
            background: #ffffff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 5px 6px;
            min-height: 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .teacher-app-stats-btn-tile {
            background: #ffffff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 0;
            min-height: 36px;
            display: flex;
            align-items: stretch;
            justify-content: stretch;
        }
        .teacher-app-stats-tile > div {
            text-align: center;
        }
        .teacher-app-stats-btn-tile .btn {
            width: 100% !important;
            height: 100% !important;
            min-height: 36px !important;
            margin: 0 !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 0 8px !important;
        }
        /* Kart başlık/tabs hizasını eşitle */
        #activities-section > h3,
        #lessons-section > h3 {
            margin: 0;
        }
        #tasks-section > h3 {
            margin: 0;
        }
        #student-tabs {
            margin-top: 10px;
        }
        #activities-tabs {
            margin-top: 10px;
        }
        /* Öğretmen kartlarında metin/öge sıkışmasını azalt */
        #app-screen.teacher-view #tasks-section,
        #app-screen.teacher-view #activities-section,
        #app-screen.teacher-view #lessons-section {
            gap: 12px;
        }
        #app-screen.teacher-view #tasks-section > h3,
        #app-screen.teacher-view #activities-section > h3,
        #app-screen.teacher-view #lessons-section > h3 {
            margin: 2px 0 0 !important;
            line-height: 1.25;
            letter-spacing: 0.1px;
        }
        #app-screen.teacher-view #teacher-filters,
        #app-screen.teacher-view #activity-filters {
            margin-bottom: 4px;
        }
        #app-screen.teacher-view #teacher-stats,
        #app-screen.teacher-view #activities-teacher-stats,
        #app-screen.teacher-view #lessons-teacher-stats {
            margin-top: 2px !important;
            margin-bottom: 6px !important;
            padding: 12px 14px !important;
            line-height: 1.35;
        }
        #app-screen.teacher-view #block-homework-teacher-stats,
        #app-screen.teacher-view #compute-homework-teacher-stats {
            margin-top: 2px !important;
            margin-bottom: 10px !important;
            padding: 12px 14px !important;
            line-height: 1.35;
        }
        #app-screen.teacher-view #tasks-section .tab-content,
        #app-screen.teacher-view #activities-section .tab-content,
        #app-screen.teacher-view #lessons-section .tab-content,
        #app-screen.teacher-view #quiz-section .tab-content {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        #app-screen.teacher-view #tasks-section .tab-content.active,
        #app-screen.teacher-view #activities-section .tab-content.active,
        #app-screen.teacher-view #lessons-section .tab-content.active,
        #app-screen.teacher-view #quiz-section .tab-content.active {
            display: flex;
            flex-direction: column;
            min-height: 0;
            flex: 1;
            height: 100%;
        }
        #app-screen.teacher-view #tasks-section .tab-content.active > ul,
        #app-screen.teacher-view #activities-section .tab-content.active > ul,
        #app-screen.teacher-view #lessons-section .tab-content.active > ul,
        #app-screen.teacher-view #quiz-list-pending,
        #app-screen.teacher-view #quiz-list-completed {
            min-height: 0;
            flex: 1;
            overflow: auto;
        }
        /* Sol panelde okla gösterilen iç kart çerçevesini kaldır */
        #app-screen.teacher-view #student-homework-shell #tasks-section {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
        #app-screen.teacher-view #tasks-section #btn-show-all-tasks,
        #app-screen.teacher-view #activities-section #btn-show-all-activities,
        #app-screen.teacher-view #lessons-section #btn-show-all-lessons {
            margin-top: auto !important;
        }
        /* Ödevler sekmesinde üstteki istatistik kutusu sekmelerden daha ayrık dursun */
        #app-screen.teacher-view #tasks-section #teacher-stats {
            margin-top: 16px !important;
        }
        /* Sol paneldeki iç kart kenarlıklarını kaldır (Ödevler/Etkinlikler/Dersler) */
        #app-screen.teacher-view #student-homework-shell #activities-section,
        #app-screen.teacher-view #student-homework-shell #lessons-section {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
        #app-screen.teacher-view #tasks-title,
        #app-screen.teacher-view #activities-title,
        #app-screen.teacher-view #lessons-title {
            display: none !important;
        }
        #app-screen.teacher-view #block-homework-pending .list-item,
        #app-screen.teacher-view #block-homework-completed .list-item,
        #app-screen.teacher-view #compute-homework-pending .list-item,
        #app-screen.teacher-view #compute-homework-completed .list-item {
            margin-left: 6px;
            margin-right: 6px;
            width: calc(100% - 12px);
            box-sizing: border-box;
            padding: 12px 14px;
            min-height: 78px;
            margin-bottom: 10px;
        }
        #app-screen.teacher-view #tasks-section .list-item,
        #app-screen.teacher-view #activities-section .list-item,
        #app-screen.teacher-view #lessons-section .list-item,
        #app-screen.teacher-view #block-homework-pending .list-item,
        #app-screen.teacher-view #block-homework-completed .list-item,
        #app-screen.teacher-view #compute-homework-pending .list-item,
        #app-screen.teacher-view #compute-homework-completed .list-item {
            padding: 12px 14px;
            min-height: 78px;
            margin-bottom: 10px;
            border-radius: 10px;
            line-height: 1.25;
            margin-left: 6px;
            margin-right: 6px;
            width: calc(100% - 12px);
            box-sizing: border-box;
        }
        #app-screen.teacher-view #tasks-section .list-item .badge,
        #app-screen.teacher-view #activities-section .list-item .badge,
        #app-screen.teacher-view #lessons-section .list-item .completion-badge,
        #app-screen.teacher-view #block-homework-section .list-item .badge,
        #app-screen.teacher-view #block-homework-section .list-item .completion-badge {
            white-space: nowrap;
        }
        #app-screen.teacher-view #block-homework-assign-tabs .tab-btn {
            min-height: 42px;
            padding: 0 10px;
            line-height: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #leaderboard-list,
        #top-students-list,
        #quiz-list {
            flex: 1;
            min-height: 0;
            overflow: auto;
        }
        #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card {
            height: 100% !important;
            min-height: 0 !important;
        }
        #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card .tab-content.active > .empty-state {
            flex: 1;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        #app-screen.student-view #student-homework-shell,
        #app-screen.student-view #student-apps-shell {
            display: flex;
            flex-direction: column;
            gap: 12px;
            height: 520px;
            min-height: 520px;
            width: 100%;
            justify-self: stretch;
        }
        #app-screen.student-view .student-shell-head {
            display: block;
            margin: 0;
        }
        #app-screen.student-view .student-shell-head h3 {
            margin: 0;
            font-size: 1.06rem;
            text-align: center;
        }
        #app-screen.student-view .student-shell-head p {
            margin: 10px 0 0 0;
            color: #64748b;
            font-size: 0.82rem;
            text-align: center;
        }
        #app-screen.student-view #student-homework-shell .student-shell-body,
        #app-screen.student-view #student-apps-shell .student-shell-body {
            display: none;
        }
        #app-screen.student-view #leaderboard-section {
            height: 520px;
            min-height: 0;
        }
        #teacher-analytics {
            height: 430px;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        #teacher-analytics #stats-content {
            flex: 1;
            min-height: 0;
            overflow: hidden;
        }
        #teacher-analytics #stats-content > .card {
            height: 100%;
            min-height: 0;
            margin-bottom: 0;
            overflow: visible;
            display: flex;
            flex-direction: column;
        }
        #teacher-analytics .teacher-top-wrap {
            flex: 1;
            min-height: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            align-items: stretch;
            overflow: visible;
        }
        #teacher-analytics .teacher-top-wrap > .chart-container {
            min-height: 360px;
            height: auto !important;
            display: flex;
            align-items: stretch;
            overflow: visible !important;
        }
        #teacher-analytics .teacher-type-chart {
            height: auto !important;
            min-height: 0 !important;
            margin: 0 !important;
        }
        #teacher-analytics .teacher-main-chart {
            height: auto !important;
            min-height: 360px !important;
            margin: 0 !important;
            display: flex;
            align-items: stretch;
            justify-content: stretch;
            align-self: stretch;
            overflow: visible !important;
        }
        #teacher-analytics .teacher-type-panel,
        #teacher-analytics .teacher-pie-panel {
            width: 100%;
            height: 100%;
            min-height: 360px;
            border: 1px solid #dbeafe;
            border-radius: 14px;
            background: linear-gradient(145deg, #ffffff, #f8fbff);
            padding: 6px 10px 12px;
            display: grid;
            grid-template-rows: auto minmax(170px, 1fr);
            gap: 4px;
            align-content: stretch;
            overflow: visible;
        }
        #teacher-analytics .teacher-pie-panel {
            grid-template-rows: auto 1fr auto;
            padding: 6px 10px 20px;
        }
        #teacher-analytics .teacher-type-title,
        #teacher-analytics .teacher-pie-title {
            text-align: center;
            font-weight: 500;
            color: #4b5563;
            font-size: 0.94rem;
            line-height: 1.1;
        }
        #teacher-analytics .teacher-type-wrap,
        #teacher-analytics .teacher-pie-wrap {
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 0;
            padding-bottom: 0;
            height: auto;
            min-height: 110px;
            flex: 1 1 auto;
        }
        #teacher-analytics .teacher-type-wrap canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 240px;
        }
        #teacher-analytics .teacher-pie-wrap canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 130px;
        }
        #teacher-analytics .teacher-pie-wrap {
            padding-top: 18px !important;
            padding-bottom: 0 !important;
        }
        #teacher-analytics #class-chart-summary {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 6px;
            margin-top: 0 !important;
            align-self: end;
            min-height: 52px;
            padding-top: 0;
            margin-bottom: 26px;
        }
        #teacher-analytics .pie-summary-item {
            border-radius: 10px;
            padding: 3px 4px;
            text-align: center;
            border: 1px solid #e2e8f0;
            background: #fff;
            min-height: 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        #teacher-analytics .pie-summary-item.completed { border-color: #86efac; background: #f0fdf4; }
        #teacher-analytics .pie-summary-item.pending { border-color: #fca5a5; background: #fff1f2; }
        #teacher-analytics .pie-summary-item.total { border-color: #bfdbfe; background: #eff6ff; }
        #teacher-analytics .pie-summary-val {
            font-weight: 800;
            font-size: 0.82rem;
            color: #0f172a;
            line-height: 1.1;
        }
        #teacher-analytics .pie-summary-label {
            margin-top: 1px;
            font-size: 0.58rem;
            color: #475569;
            line-height: 1.1;
        }
        #teacher-analytics .teacher-mini-stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }
        #teacher-analytics .teacher-mini-stats-grid .stat-card {
            padding: 6px;
        }
        #teacher-analytics .teacher-mini-stats-grid .stat-number {
            font-size: 1.16rem;
        }
        #teacher-analytics .teacher-mini-stats-grid .stat-label {
            font-size: 0.78rem;
            margin-top: 2px;
        }
        #teacher-analytics .stats-summary-grid {
            margin-bottom: 8px !important;
            gap: 6px !important;
        }
        #teacher-analytics .stats-summary-grid .stat-card {
            padding: 6px;
        }
        #teacher-analytics .stats-summary-grid .stat-number {
            font-size: 1.28rem;
        }
        #teacher-analytics .stats-summary-grid .stat-label {
            font-size: 0.82rem;
            margin-top: 1px;
        }
        #teacher-analytics #stats-content > .card > h4 {
            margin: 0 0 8px 0;
            font-size: 1.18rem;
        }
        #top-students-card {
            position: relative;
            overflow: hidden;
            border: 1px solid #bfdbfe;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.95), rgba(219,234,254,0.88)),
                linear-gradient(140deg, #eff6ff, #f8fafc);
        }
        #top-students-card::before {
            content: "";
            position: absolute;
            top: -48px;
            right: -30px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(59,130,246,0.25) 0%, rgba(59,130,246,0) 72%);
            pointer-events: none;
        }
        #top-students-card h4 {
            margin-top: 0;
            color: #1e3a8a;
            letter-spacing: 0.2px;
        }
        #student-top-students-card {
            position: relative;
            overflow: hidden;
            border: 1px solid #bfdbfe;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.95), rgba(219,234,254,0.88)),
                linear-gradient(140deg, #eff6ff, #f8fafc);
            height: 100%;
            max-height: 520px;
            min-height: 0;
            display: flex;
            flex-direction: column;
            flex: 1;
            height: 520px !important;
            row-gap: 0;
            margin-bottom: 0;
            padding-bottom: 0;
            box-sizing: border-box;
            width: 100%;
            align-self: stretch;
        }
        #student-top-students-card::before {
            content: "";
            position: absolute;
            top: -48px;
            right: -30px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(59,130,246,0.25) 0%, rgba(59,130,246,0) 72%);
            pointer-events: none;
        }
        #student-top-students-card h4 {
            margin-top: 0;
            color: #1e3a8a;
            letter-spacing: 0.2px;
        }
        #student-top-students-list {
            max-height: none;
            overflow: auto;
            display: flex;
            flex-direction: column;
            gap: 2px !important;
            white-space: normal;
            flex: 1;
            min-height: 0;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        #top-students-list {
            gap: 6px !important;
        }
        #student-top-students-list .top-student-row {
            min-height: 48px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 12px;
            margin: 0 !important;
            border-radius: 10px;
            border: 1px solid #dbeafe;
            background: rgba(255,255,255,0.96);
            font-weight: 700;
            color: #0f172a;
            line-height: 1.56;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
            box-sizing: border-box;
        }
        #student-top-students-list .top-student-meta,
        #top-students-list .top-student-meta {
            margin-top: 0 !important;
            line-height: 1;
        }
        #student-top-students-card * {
            margin-top: 0;
            margin-bottom: 0;
        }
        #student-top-students-list .top-student-row + .top-student-row {
            margin-top: 0 !important;
        }
        #student-top-students-list .top-student-row > div:nth-child(3) {
            flex: 1;
            min-width: 0;
        }
        #student-top-students-list .top-rank-badge {
            min-width: 30px;
            height: 30px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.75rem;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        #student-top-students-list .top-student-row.rank-1 .top-rank-badge { background: linear-gradient(135deg, #f59e0b, #d97706); }
        #student-top-students-list .top-student-row.rank-2 .top-rank-badge { background: linear-gradient(135deg, #94a3b8, #64748b); }
        #student-top-students-list .top-student-row.rank-3 .top-rank-badge { background: linear-gradient(135deg, #f97316, #ea580c); }
        #student-top-students-list .top-student-name {
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
            font-size: 0.98rem;
            font-family: "Inter", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            letter-spacing: -0.01em;
            text-align: left;
            white-space: nowrap;
        }
        #student-top-students-list .top-student-meta {
            color: #64748b;
            font-size: 0.8rem;
            margin-top: 0;
            white-space: nowrap;
        }
        #student-top-students-list .top-student-xp {
            font-weight: 800;
            color: #047857;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 999px;
            padding: 4px 6px;
            font-size: 0.82rem;
            white-space: nowrap;
        }
        #student-top-students-list .top-student-avatar {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        #student-top-students-list .top-student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        #student-top-students-list .top-student-medal {
            margin-left: 6px;
            font-size: 0.82rem;
            display: inline-block;
            vertical-align: middle;
            white-space: nowrap;
        }
        #top-students-list .top-student-row,
        #leaderboard-list .top-student-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            border: 1px solid #dbeafe;
            background: rgba(255,255,255,0.96);
            font-weight: 700;
            color: #0f172a;
            line-height: 1.05;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        #top-students-list .top-student-row > div:nth-child(3),
        #leaderboard-list .top-student-row > div:nth-child(3) {
            flex: 1;
            min-width: 0;
        }
        #top-students-list .top-rank-badge,
        #leaderboard-list .top-rank-badge {
              min-width: 30px;
              height: 30px;
              border-radius: 999px;
              display: flex;
              align-items: center;
              justify-content: center;
              color: #fff;
              font-weight: 700;
              font-size: 0.75rem; /* smaller */
              background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        #top-students-list .top-student-row.rank-1 .top-rank-badge,
        #leaderboard-list .top-student-row.rank-1 .top-rank-badge { background: linear-gradient(135deg, #f59e0b, #d97706); }
        #top-students-list .top-student-row.rank-2 .top-rank-badge,
        #leaderboard-list .top-student-row.rank-2 .top-rank-badge { background: linear-gradient(135deg, #94a3b8, #64748b); }
        #top-students-list .top-student-row.rank-3 .top-rank-badge,
        #leaderboard-list .top-student-row.rank-3 .top-rank-badge { background: linear-gradient(135deg, #f97316, #ea580c); }
        #top-students-list .top-student-name,
        #leaderboard-list .top-student-name {
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
            font-size: 0.98rem;
            font-family: "Inter", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            letter-spacing: -0.01em;
            text-align: left;
        }
        #top-students-list .top-student-meta,
        #leaderboard-list .top-student-meta {
            color: #64748b;
            font-size: 0.8rem;
            margin-top: 0;
        }
        #top-students-list .top-student-xp,
        #leaderboard-list .top-student-xp {
            font-weight: 800;
            color: #047857;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 999px;
            padding: 4px 6px;
            font-size: 0.82rem;
            white-space: nowrap;
        }

        /* Teacher & student top lists should match */
        #top-students-list,
        #leaderboard-list {
            max-height: none;
            overflow: visible;
            display: flex;
            flex-direction: column;
            gap: 4px;
            white-space: normal;
        }
        #leaderboard-list .top-student-row,
        #top-students-list .top-student-row {
            width: 100%;
        }

        #top-students-list .top-student-row,
        #leaderboard-list .top-student-row {
            min-height: 48px;
        }

        /* Leaderboard (student view) — follow teacher list layout */
        #leaderboard-list {
            align-items: center;
        }

        /* Make each leaderboard item a horizontal card: avatar | name/meta | xp */
        #leaderboard-list .top-student-row {
            flex-direction: row;
        }

        /* Rank badge and avatar sizing */
        #leaderboard-list .top-rank-badge { font-size: 0.9rem; width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; border-radius:999px; background:#f1f5f9; }
        #leaderboard-list .top-student-avatar { margin-right: 6px; }
        #leaderboard-list .top-student-avatar img {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            object-fit: cover;
            border: 1px solid rgba(203, 213, 225, 0.6);
        }

        /* Ensure the name/meta column uses available space and aligns correctly */
        #leaderboard-list .top-student-row > div:nth-child(3) {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center !important;
            flex: 1 1 auto;
            min-width: 0; /* allow ellipsis to work */
            gap: 2px;
        }

        #leaderboard-list .top-student-name { font-size: 1.06rem; font-weight: 700; margin:0; display:block; width:100%; overflow: hidden; text-overflow: ellipsis; }
        #leaderboard-list .top-student-meta { font-size: 0.82rem; color:#64748b; margin-top:2px; }

        /* XP badge aligns to the right and doesn't shrink */
        #leaderboard-list .top-student-xp { font-size: 0.98rem; padding: 6px 10px; border-radius: 999px; background:#ecfdf5; color:#047857; font-weight:800; margin-left: 12px; flex: 0 0 auto; }

        /* Align student apps panel and leaderboard vertically and give them matching padding */
        #app-screen.student-view > #student-apps-shell,
        #app-screen.student-view > #leaderboard-section,
        #app-screen.student-view > #student-homework-shell {
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            box-sizing: border-box;
            align-self: start;
        }
        #top-students-list .top-student-avatar,
        #leaderboard-list .top-student-avatar {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #top-students-list .top-student-avatar img,
        #leaderboard-list .top-student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        #top-students-list .top-student-medal,
        #leaderboard-list .top-student-medal {
            margin-left: 6px;
            font-size: 0.82rem;
            display: inline-block;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Ensure avatars are visible in leaderboard rows */
        #top-students-list .top-student-avatar,
        #leaderboard-list .top-student-avatar {
            display: inline-flex;
        }

        /* Prevent name/meta/xp from wrapping to the next line */
        #top-students-list .top-student-name,
        #leaderboard-list .top-student-name,
        #top-students-list .top-student-meta,
        #leaderboard-list .top-student-meta,
        #top-students-list .top-student-xp,
        #leaderboard-list .top-student-xp {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .container { width: 100%; max-width: 1440px; margin: 12px auto; padding: 12px; overflow-x: hidden; }
        .form-control { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn { padding: 12px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-success { background: var(--success); color: white; }
        .btn-danger { background: var(--danger); color: white; }
        .btn-warning { background: var(--warning); color: white; }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .card { background: white; padding: 14px; border-radius: 12px; box-shadow: 0 3px 6px rgba(0,0,0,0.08); margin-bottom: 12px; }
        
        .sidebar { height: 100%; width: 0; position: fixed; z-index: 1000; top: 0; left: 0; background: #ffffff; border-right: 1px solid #e5e7eb; box-shadow: 10px 0 32px rgba(15,23,42,0.12); overflow-x: hidden; overflow-y: auto; transition: 0.5s; padding-top: 20px; display: flex; flex-direction: column; }
        .sidebar button { padding: 15px; font-size: 18px; color: #334155; display: block; background: none; border: none; width: 100%; text-align: left; cursor: pointer; }
        .sidebar button:hover { color: #0f172a; background: #f8fafc; }
        .sidebar button.active { color: #1d4ed8; background: #eaf2ff; }
        .sidebar-logo-wrap { display:flex; justify-content:center; align-items:center; padding: 2px 0 10px; }
        .sidebar-logo { width: 119px; height: auto; border-radius: 0; border: none; background: transparent; }
        .sidebar-group-toggle {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            font-weight: 400;
            color: #1f2937 !important;
            border-top: 1px solid #eef2f7;
            margin-top: 4px;
            padding-top: 13px !important;
            padding-bottom: 13px !important;
        }
        .sidebar-group-toggle .arrow { font-size: 12px; opacity: 0.9; }
        .sidebar-submenu { display: none; padding: 0 0 6px; }
        .sidebar-submenu.open { display: block; }
        .sidebar-submenu .submenu-item {
            padding-left: 28px !important;
            font-size: 16px !important;
            color: #475569 !important;
        }
        .sidebar-submenu .submenu-item:hover { color: #0f172a !important; background: #f8fafc; }
        .sidebar-footer {
            margin-top: auto;
            padding: 10px 12px 14px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .sidebar-footer-title {
            font-size: 0.78rem;
            color: #64748b;
            text-align: center;
            font-weight: 500;
        }
        .sidebar-footer #student-total-time {
            width: 100%;
            justify-content: center;
        }
        #side-menu.student-minimal #btn-toggle-tasks-menu,
        #side-menu.student-minimal #btn-toggle-add-menu,
        #side-menu.student-minimal #btn-toggle-apps-menu,
        #side-menu.student-minimal #btn-toggle-student-data-menu,
        #side-menu.student-minimal #btn-open-lessons,
        #side-menu.student-minimal #btn-open-create,
        #side-menu.student-minimal #btn-open-tasks,
        #side-menu.student-minimal #btn-open-approvals,
        #side-menu.student-minimal #btn-open-content,
        #side-menu.student-minimal #btn-open-books,
        #side-menu.student-minimal #btn-open-add-student,
        #side-menu.student-minimal #btn-open-class-sections,
        #side-menu.student-minimal #btn-open-students,
        #side-menu.student-minimal #btn-open-classes,
        #side-menu.student-minimal #btn-open-reports,
        #side-menu.student-minimal #btn-open-login-cards,
        #side-menu.student-minimal #btn-open-teacher-certificates,
        #side-menu.student-minimal #btn-open-block-runner-menu,
        #side-menu.student-minimal #btn-open-block-3d-menu,
        #side-menu.student-minimal #btn-open-compute-it-menu,
        #side-menu.student-minimal #btn-open-flowchart-app,
        #side-menu.student-minimal #btn-open-live-quiz,
        #side-menu.student-minimal #btn-open-live-quiz-start,
        #side-menu.student-minimal #btn-open-live-quiz-results,
        #side-menu.student-minimal #submenu-tasks,
        #side-menu.student-minimal #submenu-add,
        #side-menu.student-minimal #submenu-apps,
        #side-menu.student-minimal #submenu-student-data {
            display: none !important;
        }
        #side-menu.student-minimal #btn-open-home,
        #side-menu.student-minimal #btn-open-my-stats,
        #side-menu.student-minimal #btn-open-certificates,
        #side-menu.student-minimal #btn-logout-side {
            display: block !important;
        }
        
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; z-index: 2000; }
        #student-detail-modal { z-index: 14000; }
        #confirm-modal { z-index: 26000 !important; }
        #info-modal { z-index: 26001 !important; }
        #task-students-modal { z-index: 12000; }
        .modal-content { background: white; padding: 25px; border-radius: 15px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto; }
        .modal-large { max-width: 1020px; }
        #task-modal .modal-content {
            width: 95vw;
            max-width: 1200px;
            max-height: 92vh;
        }
        #content-modal .modal-content {
            width: 96vw;
            max-width: 1320px;
            max-height: 92vh;
        }
        #students-modal .modal-content { max-width: 1320px; width: 98vw; }
        #students-modal .student-row {
            display: flex;
            flex-wrap: nowrap;
            gap: 8px;
            align-items: center;
            overflow-x: auto;
            padding-bottom: 2px;
        }
        #students-modal .student-input { flex: 0 0 140px; min-width: 110px; }
        #students-modal .student-input.input-first { flex-basis: 140px; }
        #students-modal .student-input.input-last { flex-basis: 140px; }
        #students-modal .student-input.input-username { flex-basis: 170px; }
        #students-modal .student-input.input-pass { flex-basis: 150px; }
        #students-modal .student-input.input-class { flex-basis: 90px; }
        #students-modal .student-input.input-section { flex-basis: 80px; }
        #students-modal .student-actions { display: flex; gap: 6px; flex-wrap: nowrap; margin-left: auto; flex: 0 0 auto; }
        #students-modal .student-actions .btn { padding: 6px 10px; font-size: 0.85rem; }
        #flowchart-modal {
            z-index: 25011;
            align-items: stretch;
            justify-content: stretch;
            padding: 0;
        }
        #flowchart-modal .modal-content.flowchart-shell {
            width: 100vw !important;
            max-width: 100vw !important;
            height: 100vh !important;
            max-height: none;
            margin: 0;
            padding: 0;
            border-radius: 0;
            border: 1px solid #b5b5b5;
            background: #dcdcdc;
            display: grid;
            grid-template-rows: 56px 1fr;
            overflow: hidden;
        }
        .flowchart-toolbar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-bottom: 1px solid #bfbfbf;
            background: #e7e7e7;
        }
        .flowchart-assignment-timer {
            margin-left: auto;
            border: 1px solid #a8a8a8;
            background: #f8fafc;
            color: #0f172a;
            border-radius: 6px;
            padding: 7px 10px;
            font-weight: 700;
            min-width: 120px;
            text-align: center;
        }
        .flowchart-btn {
            border: 1px solid #a8a8a8;
            background: #f5f5f5;
            color: #1f2937;
            border-radius: 4px;
            padding: 7px 10px;
            font-weight: 700;
            cursor: pointer;
        }
        .flowchart-btn.active {
            border-color: #2563eb;
            background: #dbeafe;
            color: #1d4ed8;
        }
        .flowchart-btn.run {
            border-color: #059669;
            background: #10b981;
            color: #fff;
        }
        .flowchart-btn.stop {
            border-color: #dc2626;
            background: #ef4444;
            color: #fff;
        }
        .flowchart-main {
            min-height: 0;
            display: grid;
            grid-template-columns: 130px 1fr 340px;
            gap: 0;
        }
        .flowchart-palette {
            border-right: 1px solid #bfbfbf;
            background: #ececec;
            padding: 10px 8px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .flowchart-tool {
            border: 1px solid #9ca3af;
            background: #fafafa;
            border-radius: 4px;
            height: 56px;
            display: grid;
            place-items: center;
            cursor: pointer;
            font-weight: 700;
            color: #1f2937;
            padding: 4px;
            overflow: hidden;
        }
        .flowchart-tool.active {
            border-color: #2563eb;
            box-shadow: inset 0 0 0 2px rgba(37, 99, 235, 0.22);
            background: #eff6ff;
        }
        .flow-tool-shape {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 34px;
            border: 2px solid #111827;
            color: #111827;
            background: #fff;
            font-weight: 700;
            font-size: 0.86rem;
            user-select: none;
        }
        .flow-tool-shape.start,
        .flow-tool-shape.end {
            border-radius: 999px;
        }
        .flow-tool-shape.input,
        .flow-tool-shape.output {
            clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);
        }
        .flow-tool-shape.decision {
            width: 42px;
            height: 42px;
            transform: rotate(45deg);
            padding: 0;
        }
        .flow-tool-shape.decision > span {
            transform: rotate(-45deg);
            display: inline-block;
            font-size: 0.74rem;
        }
        .flowchart-canvas-wrap {
            position: relative;
            background: #ddd;
            overflow: auto;
        }
        #flowchart-canvas {
            position: relative;
            min-width: 1200px;
            min-height: 900px;
            background: #dedede;
        }
        #flowchart-svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: auto;
        }
        .flow-node {
            position: absolute;
            min-width: 130px;
            max-width: 240px;
            min-height: 50px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border: 2px solid #1f2937;
            background: #fff;
            color: #111827;
            font-weight: 700;
            user-select: none;
            cursor: move;
            white-space: pre-line;
        }
        .flow-node.selected { box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3); }
        .flow-node.connect-source { box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.45); }
        .flow-node.running { box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.45); }
        .flow-node.start, .flow-node.end { border-radius: 999px; }
        .flow-node.input, .flow-node.output {
            clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);
            padding-left: 18px;
            padding-right: 18px;
        }
        .flow-node.decision {
            width: 130px;
            height: 130px;
            min-width: 130px;
            min-height: 130px;
            transform: rotate(45deg);
            padding: 0;
        }
        .flow-node.decision > span {
            transform: rotate(-45deg);
            width: 90px;
            display: inline-block;
        }
        .flowchart-right {
            border-left: 1px solid #bfbfbf;
            background: #f3f4f6;
            display: grid;
            grid-template-rows: auto auto 1fr;
        }
        .flowchart-right-head {
            padding: 8px 10px;
            border-bottom: 1px solid #cbd5e1;
            font-weight: 800;
            color: #111827;
        }
        .flowchart-help {
            padding: 8px 10px;
            border-bottom: 1px solid #d1d5db;
            color: #4b5563;
            font-size: 0.82rem;
            line-height: 1.4;
        }
        .flow-target-mini {
            width: 100%;
            min-height: 120px;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: auto;
        }
        #flowchart-output {
            margin: 0;
            padding: 10px;
            background: #000;
            color: #fff;
            overflow: auto;
            font-family: Consolas, "Courier New", monospace;
            font-size: 13px;
            line-height: 1.42;
            white-space: pre-wrap;
        }
        body.dark-mode #flowchart-modal .modal-content.flowchart-shell {
            background: #0f172a;
            border-color: #334155;
        }
        body.dark-mode .flowchart-toolbar {
            background: #111827;
            border-bottom-color: #1f2937;
            color: #e5e7eb;
        }
        body.dark-mode .flowchart-palette {
            background: #0f172a;
            border-right-color: #1f2937;
        }
        body.dark-mode .flowchart-tool {
            background: #111827;
            color: #e5e7eb;
            border-color: #334155;
        }
        body.dark-mode .flow-tool-shape {
            border-color: #93c5fd;
            color: #e5e7eb;
            background: #1e293b;
        }
        body.dark-mode .flowchart-canvas-wrap,
        body.dark-mode #flowchart-canvas { background: #111827; }
        body.dark-mode .flow-node {
            border-color: #93c5fd;
            background: #1e293b;
            color: #e5e7eb;
        }
        body.dark-mode .flowchart-right {
            background: #0f172a;
            border-left-color: #1f2937;
        }
        body.dark-mode .flowchart-right-head,
        body.dark-mode .flowchart-help {
            color: #e5e7eb;
            border-bottom-color: #1f2937;
        }
        body.dark-mode .flow-target-mini {
            background: #111827;
            border-color: #334155;
        }
        #flow-node-editor-modal .modal-content { max-width: 520px; }
        .flow-node-editor-form { display: grid; gap: 10px; }
        .flow-node-editor-row { display: grid; gap: 8px; grid-template-columns: 1fr 1fr; }
        .flow-node-editor-row.three { grid-template-columns: 1fr auto 1fr; align-items: end; }
        .flow-node-editor-label { font-size: 0.84rem; color: #4b5563; font-weight: 600; margin-bottom: 4px; }
        #flow-runtime-input-modal .modal-content { max-width: 430px; }
        body.dark-mode .flow-node-editor-label { color: #cbd5e1; }
        .confirm-shell {
            max-width: 440px !important;
            border-radius: 18px !important;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background:
                radial-gradient(circle at 0% 0%, rgba(239, 68, 68, 0.2), rgba(255,255,255,0) 36%),
                radial-gradient(circle at 100% 0%, rgba(59, 130, 246, 0.16), rgba(255,255,255,0) 36%),
                linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 28px 56px rgba(15, 23, 42, 0.28);
            animation: confirmPopIn 180ms ease-out;
        }
        .confirm-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        .confirm-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            box-shadow: 0 8px 18px rgba(239, 68, 68, 0.22);
        }
        .confirm-title {
            margin: 0;
            font-size: 1.08rem;
            letter-spacing: 0.2px;
        }
        .confirm-message {
            margin-bottom: 16px;
            color: #374151;
            line-height: 1.4;
        }
        .confirm-actions {
            display: flex;
            gap: 10px;
        }
        .confirm-actions .btn {
            border-radius: 12px;
            transition: transform 0.16s ease, box-shadow 0.16s ease, filter 0.16s ease;
        }
        .confirm-actions .btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.02);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.16);
        }
        .info-shell {
            max-width: 460px !important;
            border-radius: 18px !important;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background:
                radial-gradient(circle at 0% 0%, rgba(59, 130, 246, 0.16), rgba(255,255,255,0) 42%),
                radial-gradient(circle at 100% 0%, rgba(16, 185, 129, 0.14), rgba(255,255,255,0) 40%),
                linear-gradient(150deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.24);
        }
        #btn-info-continue.btn-continue-play {
            border: 1px solid #f59e0b;
            background: linear-gradient(135deg, #f59e0b, #ea580c) !important;
            color: #fff !important;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow: 0 10px 18px rgba(234, 88, 12, 0.28);
        }
        #btn-info-continue.btn-continue-play:hover {
            transform: translateY(-1px);
            filter: brightness(1.03);
            box-shadow: 0 14px 22px rgba(234, 88, 12, 0.34);
        }
        #btn-info-continue.btn-continue-play .play-ico {
            font-size: 1rem;
            line-height: 1;
        }
        .completion-info-card {
            border: 1px solid #dbeafe;
            background: linear-gradient(135deg, #f8fbff 0%, #eef8ff 100%);
            border-radius: 14px;
            padding: 12px;
            margin-bottom: 12px;
        }
        .completion-info-title {
            font-size: 0.96rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .completion-info-subtitle {
            font-size: 0.88rem;
            color: #0f766e;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .completion-info-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }
        .completion-info-item {
            background: #ffffff;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            padding: 8px;
            text-align: center;
        }
        .completion-info-item .k {
            font-size: 0.72rem;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .completion-info-item .v {
            font-size: 0.88rem;
            color: #0f172a;
            font-weight: 800;
        }
        .homework-assign-shell {
            max-width: 600px !important;
            border-radius: 18px !important;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background:
                radial-gradient(circle at 0% 0%, rgba(59, 130, 246, 0.12), rgba(255,255,255,0) 42%),
                radial-gradient(circle at 100% 0%, rgba(20, 184, 166, 0.11), rgba(255,255,255,0) 40%),
                linear-gradient(150deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 22px 45px rgba(15, 23, 42, 0.2);
        }
        .homework-assign-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 10px 12px;
            border-radius: 12px;
            background: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 52%, #ecfeff 100%);
            border: 1px solid #bfdbfe;
        }
        .homework-assign-head h3 {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.2px;
        }
        .homework-assign-close {
            background: #e2e8f0 !important;
            color: #334155 !important;
            border: 1px solid #cbd5e1 !important;
        }
        .homework-assign-save {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%) !important;
            color: #fff !important;
            border: 1px solid #1d4ed8 !important;
            font-weight: 700;
        }
        .homework-assign-save:hover {
            transform: translateY(-1px);
            filter: brightness(1.03);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.24);
        }
        .homework-assign-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: #fff !important;
            border: 1px solid #b91c1c !important;
            font-weight: 700;
        }
        .homework-assign-hint {
            display: block;
            color: #475569;
            margin: 4px 0 12px;
            font-size: 0.83rem;
            background: #f1f5f9;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 8px 10px;
        }
        .homework-assign-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .homework-assign-actions .btn {
            min-width: 170px;
        }
        @keyframes confirmPopIn {
            from { opacity: 0; transform: translateY(8px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        body.dark-mode .confirm-shell {
            border-color: #334155;
            background:
                radial-gradient(circle at 0% 0%, rgba(239, 68, 68, 0.22), rgba(2,6,23,0) 34%),
                radial-gradient(circle at 100% 0%, rgba(59, 130, 246, 0.2), rgba(2,6,23,0) 34%),
                linear-gradient(150deg, #0f172a 0%, #111827 100%);
        }
        body.dark-mode .confirm-title { color: #e5e7eb; }
        body.dark-mode .confirm-message { color: #cbd5e1; }
        body.dark-mode .confirm-icon {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.25), rgba(190, 24, 93, 0.25));
            color: #fecaca;
        }
        body.dark-mode .info-shell {
            border-color: #334155;
            background:
                radial-gradient(circle at 0% 0%, rgba(59, 130, 246, 0.2), rgba(2,6,23,0) 42%),
                radial-gradient(circle at 100% 0%, rgba(16, 185, 129, 0.18), rgba(2,6,23,0) 40%),
                linear-gradient(150deg, #0f172a 0%, #111827 100%);
            box-shadow: 0 24px 50px rgba(2, 6, 23, 0.5);
        }
        body.dark-mode .completion-info-card {
            border-color: #1e3a8a;
            background: linear-gradient(135deg, #0f172a 0%, #111827 100%);
        }
        body.dark-mode .completion-info-title { color: #e2e8f0; }
        body.dark-mode .completion-info-subtitle { color: #67e8f9; }
        body.dark-mode .completion-info-item {
            background: #0b1220;
            border-color: #1e3a8a;
        }
        body.dark-mode .completion-info-item .k { color: #94a3b8; }
        body.dark-mode .completion-info-item .v { color: #e2e8f0; }
        body.dark-mode .homework-assign-shell {
            border-color: #334155;
            background:
                radial-gradient(circle at 0% 0%, rgba(59, 130, 246, 0.2), rgba(2,6,23,0) 42%),
                radial-gradient(circle at 100% 0%, rgba(20, 184, 166, 0.16), rgba(2,6,23,0) 40%),
                linear-gradient(150deg, #0f172a 0%, #111827 100%);
            box-shadow: 0 24px 46px rgba(2, 6, 23, 0.55);
        }
        body.dark-mode .homework-assign-head {
            background: linear-gradient(135deg, rgba(30,58,138,0.45) 0%, rgba(3,105,161,0.35) 100%);
            border-color: #1d4ed8;
        }
        body.dark-mode .homework-assign-head h3 { color: #e2e8f0; }
        body.dark-mode .homework-assign-close {
            background: #1f2937 !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }
        body.dark-mode .homework-assign-hint {
            color: #cbd5e1;
            background: #0b1220;
            border-color: #334155;
        }
        @media (max-width: 540px) {
            .completion-info-grid { grid-template-columns: 1fr; }
        }
        .list-item { background: white; padding: 10px 12px; margin-bottom: 8px; border-radius: 10px; border-left: 4px solid var(--primary); cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; transition: 0.3s; }
        #reports-list .list-item:hover { transform: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        #reports-list .list-item { padding: 6px 8px; font-size: 0.9rem; }
        #reports-list .list-item small { font-size: 0.75rem; }
        .list-item.completed { border-left-color: var(--success); background: #f0fff4; opacity: 0.85; cursor: default; }
        .list-item.completed:hover { transform: none; box-shadow: none; }
        .list-item.expired { border-left-color: var(--danger); opacity: 0.7; }
        
        .tabs { display: flex; gap: 10px; margin-bottom: 15px; border-bottom: 2px solid #eee; align-items: flex-end; width: 100%; }
        .tab-btn { flex: 1; padding: 12px; border: none; background: none; cursor: pointer; font-weight: bold; color: #666; border-bottom: 3px solid transparent; transition: 0.3s; }
        .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }
        .tab-btn:focus,
        .tab-btn:focus-visible {
            outline: none;
            box-shadow: none;
        }
        #block-homework-assign-tabs .tab-btn[data-assign-type="computeit"] {
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            box-shadow: none !important;
        }
        #student-tabs,
        #activities-tabs,
        #block-homework-tabs,
        #compute-homework-tabs,
        #lessons-tabs {
            margin-top: 10px !important;
            margin-bottom: 15px;
            align-items: stretch;
            width: 100%;
            max-width: 100%;
        }
        #student-tabs .tab-btn,
        #activities-tabs .tab-btn,
        #block-homework-tabs .tab-btn,
        #compute-homework-tabs .tab-btn,
        #lessons-tabs .tab-btn,
        #quiz-tabs .tab-btn,
        #block-homework-assign-tabs .tab-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            padding: 0 12px;
            line-height: 1;
            box-sizing: border-box;
            margin: 0;
            vertical-align: middle;
        }
        #app-screen.teacher-view #student-tabs,
        #app-screen.teacher-view #activities-tabs,
        #app-screen.teacher-view #lessons-tabs,
        #app-screen.teacher-view #quiz-tabs,
        #app-screen.teacher-view #block-homework-tabs,
        #app-screen.teacher-view #compute-homework-tabs,
        #app-screen.teacher-view #student-homework-tabs,
        #app-screen.teacher-view #student-apps-tabs {
            display: none !important;
        }
        #app-screen.teacher-view #block-homework-split-head,
        #app-screen.teacher-view #compute-homework-split-head {
            display: none !important;
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .home-tabs { display:none !important; }
        .home-tab-btn { display:none !important; }

        /* Öğrenci panelindeki sekmelerin görünmesini zorla (student-view altında) */
        #app-screen.student-view #student-tabs,
        #app-screen.student-view #student-apps-tabs,
        #app-screen.student-view #student-homework-tabs,
        #app-screen.student-view #student-homework-combined .tabs {
            display: flex !important;
        }
        #app-screen.student-view #student-homework-combined .status-split,
        #app-screen.student-view #student-apps-combined .status-split {
            display: block;
        }
        #app-screen.student-view #student-homework-combined .status-split .tab-content,
        #app-screen.student-view #student-apps-combined .status-split .tab-content {
            display: none;
        }
        #app-screen.student-view #student-homework-combined .status-split .tab-content.active,
        #app-screen.student-view #student-apps-combined .status-split .tab-content.active {
            display: block;
        }
        /* Listelenen ögelerin aynı boyutta gözükmesi için sabit min-height */
        .tab-content .list-item,
        .tab-content .student-list-item,
        .tab-content ul > li {
            min-height: 56px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .filter-bar { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; }
        .filter-btn { padding: 8px 15px; border: 1px solid #ddd; background: white; border-radius: 20px; cursor: pointer; font-size: 0.9rem; transition: 0.3s; }
        .filter-btn.active { background: var(--primary); color: white; border-color: var(--primary); }
        
        .app-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; position: relative; min-height: 44px; }
        #app-screen.student-view .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            column-gap: 8px;
        }
        #app-screen.student-view #student-total-time { justify-self: start; order: 1; }
        #app-screen.student-view #user-fullname { display: none; }
        #app-screen.student-view #open-menu { justify-self: start; order: 1; }
        #app-screen.student-view #header-center-logo { order: 2; }
        #app-screen.student-view #user-menu { justify-self: end; order: 3; margin-left: auto; }
        #app-screen.student-view #user-welcome { display: none; }
        #app-screen.teacher-view .app-header { justify-content: flex-end; gap: 8px; }
        #open-menu {
            background: #ffffff;
            color: #0f172a;
            border: 1px solid #dbe5f1;
            box-shadow: 0 8px 24px rgba(15,23,42,0.12);
            padding: 0;
            border-radius: 14px;
            cursor: pointer;
            font-size: 20px;
            width: 46px;
            height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        #app-screen.teacher-view #user-fullname { display: none; }
        #app-screen.teacher-view #user-welcome { margin-right: 4px; }
        #header-center-logo {
            display: none;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            align-items: center;
            justify-content: center;
            width: 134px;
            height: 134px;
            pointer-events: none;
            z-index: 2;
        }
        #header-center-logo::before {
            content: "";
            position: absolute;
            inset: 6px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, 0.95);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.45),
                0 0 16px rgba(255, 255, 255, 0.48),
                0 0 28px rgba(255, 255, 255, 0.34);
            filter: blur(1.2px);
            z-index: -1;
            pointer-events: none;
            opacity: 0;
        }
        #header-center-logo::after {
            content: "";
            position: absolute;
            inset: -18px;
            border-radius: 999px;
            background: radial-gradient(circle, rgba(255,255,255,0.55) 0%, rgba(255,255,255,0.28) 45%, rgba(255,255,255,0.05) 72%, rgba(255,255,255,0) 100%);
            filter: blur(13px);
            z-index: -2;
            pointer-events: none;
            opacity: 0;
        }
        #header-center-logo img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(15, 23, 42, 0.18));
        }
        #app-screen.teacher-view #header-center-logo,
        #app-screen.student-view #header-center-logo { display: inline-flex; }
        body.dark-mode #header-center-logo::before {
            border-color: rgba(255, 255, 255, 0.98);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.5),
                0 0 16px rgba(255, 255, 255, 0.72),
                0 0 30px rgba(255, 255, 255, 0.45);
            filter: blur(1.8px);
            opacity: 1;
        }
        body.dark-mode #header-center-logo::after {
            background: radial-gradient(circle, rgba(255,255,255,0.75) 0%, rgba(255,255,255,0.38) 48%, rgba(255,255,255,0.09) 74%, rgba(255,255,255,0) 100%);
            filter: blur(15px);
            opacity: 1;
        }
        body.dark-mode #header-center-logo img {
            filter:
                drop-shadow(0 0 8px rgba(255, 255, 255, 0.9))
                drop-shadow(0 0 18px rgba(255, 255, 255, 0.55));
        }
        #user-header-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: radial-gradient(circle at 30% 30%, #fef3c7, #f59e0b);
            overflow: hidden;
            cursor: pointer;
        }
        #user-header-avatar.visible { display: inline-flex; }
        #user-header-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        #user-menu-trigger {
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        #user-menu-trigger:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.12);
        }
        #app-screen.teacher-view #user-menu-trigger {
            background: linear-gradient(135deg, #dbeafe, #e9d5ff);
            border-color: #c4b5fd;
            color: #312e81;
        }
        #app-screen.student-view #user-menu-trigger {
            background: linear-gradient(135deg, #dcfce7, #d1fae5);
            border-color: #86efac;
            color: #14532d;
        }
        .time-widget {
            display: inline-flex;
            gap: 6px;
            align-items: center;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border: 1px solid #dbe4ef;
            border-radius: 999px;
            padding: 5px 8px;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
            max-width: 100%;
            flex-wrap: wrap;
        }
        .time-block {
            display: inline-flex;
            align-items: baseline;
            gap: 3px;
            min-width: 0;
            padding: 2px 6px;
            border-radius: 999px;
            background: #eef2ff;
            border: 1px solid #dbeafe;
        }
        .time-val { font-weight: 500; color: #1d4ed8; font-size: 0.84rem; line-height: 1; }
        .time-label { font-size: 0.68rem; color: #475569; letter-spacing: 0; text-transform: none; font-weight: 400; }
        .avatar-shop-modal-content {
            width: min(980px, 94vw);
            max-height: 88vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 12px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background:
                radial-gradient(circle at 12% 6%, rgba(34, 197, 94, 0.2), rgba(255,255,255,0) 30%),
                radial-gradient(circle at 100% 0%, rgba(59, 130, 246, 0.18), rgba(255,255,255,0) 36%),
                linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.28);
        }
        .avatar-shop-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            padding: 2px 2px 6px;
        }
        .avatar-shop-xp {
            background: #ecfdf5;
            border: 1px solid #86efac;
            color: #166534;
            font-weight: 700;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 0.92rem;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.22);
        }
        .avatar-shop-grid {
            overflow: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 12px;
            padding-right: 2px;
            padding-bottom: 6px;
        }
        .avatar-card {
            background: linear-gradient(160deg, #ffffff, #f8fafc);
            border: 1px solid #dbe7f5;
            border-radius: 14px;
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }
        .avatar-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.15);
        }
        .avatar-card.owned { border-color: #86efac; background: #f0fdf4; }
        .avatar-card.selected {
            border-color: #34d399;
            box-shadow: 0 10px 24px rgba(16, 185, 129, 0.22);
        }
        .avatar-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            margin: 0 auto;
            font-size: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255,255,255,0.9);
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.2);
        }
        .avatar-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            transform: scale(1.03);
        }
        .avatar-card h4 {
            margin: 0;
            font-size: 0.95rem;
            text-align: center;
        }
        .avatar-cost {
            text-align: center;
            color: #475569;
            font-size: 0.84rem;
            font-weight: 600;
        }
        .edu-ai-fab {
            position: fixed;
            right: 18px;
            bottom: 18px;
            width: 78px;
            height: 78px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.7);
            background:
                radial-gradient(circle at 30% 22%, rgba(255,255,255,0.95), rgba(255,255,255,0) 42%),
                linear-gradient(145deg, #34d399, #3b82f6 58%, #2563eb);
            color: #fff;
            box-shadow: 0 20px 42px rgba(15, 23, 42, 0.3), inset 0 -8px 14px rgba(37, 99, 235, 0.35);
            cursor: pointer;
            z-index: 21020;
            display: none;
            padding: 0;
            overflow: visible;
            backdrop-filter: blur(6px);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .edu-ai-fab::before {
            content: "";
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid rgba(147, 197, 253, 0.45);
            animation: aiGlowPulse 1.8s ease-in-out infinite;
            z-index: 0;
        }
        .edu-ai-fab:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 26px 52px rgba(15, 23, 42, 0.34), inset 0 -8px 14px rgba(37, 99, 235, 0.45);
        }
        .edu-ai-core {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 52px;
            height: 52px;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.95);
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(2, 6, 23, 0.28), inset 0 0 0 1px rgba(255,255,255,0.6);
            z-index: 3;
            background: #fff;
        }
        .edu-ai-core img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transform: scale(1.04);
        }
        .edu-ai-wing {
            position: absolute;
            top: 50%;
            width: 32px;
            height: 40px;
            border-radius: 70% 30% 70% 25%;
            background:
                linear-gradient(180deg, #ffffff 0%, #f1f5f9 62%, #dbeafe 100%);
            border: 1px solid #cbd5e1;
            box-shadow: 0 10px 16px rgba(15, 23, 42, 0.2);
            z-index: 1;
            transform-origin: center;
        }
        .edu-ai-wing.left {
            left: -15px;
            transform: translateY(-50%) rotate(-16deg);
            animation: aiWingLeft 2.1s ease-in-out infinite;
        }
        .edu-ai-wing.right {
            right: -15px;
            transform: translateY(-50%) rotate(16deg) scaleX(-1);
            animation: aiWingRight 2.1s ease-in-out infinite;
        }
        @keyframes aiGlowPulse {
            0%, 100% { opacity: 0.55; transform: scale(1); }
            50% { opacity: 0.15; transform: scale(1.08); }
        }
        @keyframes aiWingLeft {
            0%, 100% { transform: translateY(-50%) rotate(-16deg); }
            50% { transform: translateY(-50%) rotate(-7deg); }
        }
        @keyframes aiWingRight {
            0%, 100% { transform: translateY(-50%) rotate(16deg) scaleX(-1); }
            50% { transform: translateY(-50%) rotate(7deg) scaleX(-1); }
        }
        .edu-ai-panel {
            position: fixed;
            right: 18px;
            bottom: 94px;
            width: min(430px, calc(100vw - 24px));
            height: min(560px, calc(100vh - 140px));
            border-radius: 16px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.24);
            z-index: 21021;
            display: none;
            flex-direction: column;
            overflow: hidden;
        }
        .edu-ai-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 12px 14px;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #dcfce7, #dbeafe);
        }
        .edu-ai-panel-title {
            margin: 0;
            font-size: 0.98rem;
            font-weight: 800;
            color: #1f2937;
        }
        .edu-ai-panel-sub {
            margin: 2px 0 0;
            font-size: 0.78rem;
            color: #334155;
        }
        .edu-ai-close {
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #1f2937;
            border-radius: 10px;
            width: 34px;
            height: 34px;
            cursor: pointer;
            font-size: 18px;
        }
        .edu-ai-messages {
            flex: 1;
            overflow: auto;
            padding: 12px;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .edu-ai-msg {
            max-width: 88%;
            border-radius: 12px;
            padding: 8px 10px;
            font-size: 0.88rem;
            line-height: 1.4;
            white-space: pre-wrap;
        }
        .edu-ai-msg.user {
            align-self: flex-end;
            background: #dbeafe;
            color: #1e3a8a;
            border: 1px solid #bfdbfe;
        }
        .edu-ai-msg.bot {
            align-self: flex-start;
            background: #ecfeff;
            color: #0f172a;
            border: 1px solid #bae6fd;
        }
        .edu-ai-input-wrap {
            border-top: 1px solid #e5e7eb;
            background: #ffffff;
            padding: 10px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 8px;
        }
        .edu-ai-input {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 10px;
            font-size: 0.9rem;
            outline: none;
        }
        .edu-ai-input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .edu-ai-send {
            border: 1px solid #16a34a;
            border-radius: 10px;
            background: #22c55e;
            color: #fff;
            font-weight: 700;
            padding: 0 14px;
            cursor: pointer;
        }
        .edu-ai-quick {
            border-top: 1px dashed #cbd5e1;
            padding: 8px 10px;
            background: #f8fafc;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .edu-ai-quick button {
            border: 1px solid #cbd5e1;
            border-radius: 999px;
            background: #fff;
            color: #334155;
            font-size: 0.76rem;
            padding: 4px 9px;
            cursor: pointer;
        }
        
        .game-question { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 15px; }
        .game-option { display: block; width: 100%; padding: 12px; margin-bottom: 8px; border: 2px solid #ddd; border-radius: 8px; background: white; cursor: pointer; text-align: left; }
        .game-option:hover { border-color: var(--primary); background: #f0f7ff; }
        .game-option.correct { border-color: var(--success); background: #d4edda; }
        .game-option.wrong { border-color: var(--danger); background: #f8d7da; }
        .progress-bar { width: 100%; height: 8px; background: #eee; border-radius: 4px; margin-bottom: 20px; overflow: hidden; }
        .progress-fill { height: 100%; background: var(--primary); transition: width 0.3s; }
        
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: bold; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-info { background: #cce5ff; color: #004085; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-progress { background: #dbeafe; color: #1d4ed8; }
        .badge-mid { background: #ffedd5; color: #9a3412; }
        
        .edit-section { background: #f8f9fa; padding: 15px; border-radius: 10px; margin-top: 15px; border: 1px solid #dee2e6; }
        .question-edit-item { background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #ddd; }
        
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px; }
        .stat-card { background: white; padding: 10px; border-radius: 10px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        .stats-summary-grid .stat-card { min-width: 0; }
        .stat-number { font-size: 1.5rem; font-weight: bold; color: var(--primary); }
        .stat-label { color: #666; font-size: 0.82rem; margin-top: 4px; }
        #my-stats-content .stats-grid {
            grid-template-columns: repeat(8, minmax(0, 1fr));
            gap: 8px;
        }
        #my-stats-modal .modal-content {
            width: min(98vw, 1700px);
            max-width: 1700px;
        }
        #my-stats-content .stat-card {
            padding: 8px 6px;
            min-height: 78px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(145deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #bfdbfe;
            box-shadow: 0 3px 10px rgba(30, 64, 175, 0.12);
        }
        #my-stats-content .stat-number {
            font-size: 1rem;
            line-height: 1.15;
            color: #1e3a8a;
            font-weight: 800;
        }
        #my-stats-content .stat-label {
            font-size: 0.74rem;
            color: #334155;
        }
        #my-stats-content .my-stats-charts {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 8px;
            align-items: start;
            justify-items: center;
        }
        #my-stats-content .chart-container.my-stats-charts {
            height: auto;
            min-height: 0;
            margin: 6px 0 0;
        }
        #my-stats-content .my-chart-card {
            min-width: 0;
            width: 100%;
            max-width: 260px;
            display: grid;
            grid-template-rows: 40px 150px;
            align-items: stretch;
            background: linear-gradient(145deg, #f8fafc 0%, #eef2ff 100%);
            border: 1px solid #dbeafe;
            border-radius: 10px;
            padding: 6px;
        }
        #my-stats-content .my-chart-title {
            font-weight: 600;
            margin-bottom: 0;
            text-align: center;
            font-size: 0.92rem;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.2;
            white-space: nowrap;
        }
        #my-stats-content .my-chart-card canvas {
            width: 100% !important;
            height: 150px !important;
            display: block;
        }
        
        .student-list-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: white; margin-bottom: 8px; border-radius: 10px; cursor: pointer; transition: 0.3s; border-left: 4px solid var(--primary); font-size: 0.9rem; }
        .student-list-item:hover { background: #f0f7ff; transform: translateX(3px); }
        #task-students-list .student-list-item { padding: 8px 10px; margin-bottom: 6px; }
        #task-students-list .student-list-item:hover { transform: none; }
        #task-students-list .student-list-item small { font-size: 0.75rem; }
        .chart-container { position: relative; height: 200px; margin: 10px 0; }
        .stat-detail-grid { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 15px; margin: 20px 0; }
        .stat-detail-item { background: #f8f9fa; padding: 15px; border-radius: 10px; text-align: center; }
        .stat-detail-value { font-size: 1.5rem; font-weight: bold; color: var(--primary); }
        .stat-detail-label { color: #666; font-size: 0.85rem; margin-top: 5px; }
        #student-detail-badges.badges-grid {
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        }

        .content-layout { display: grid; grid-template-columns: 280px 1fr; gap: 12px; }
        .content-left { background: #f8f9ff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 10px; max-height: 75vh; overflow: auto; }
        .content-right { background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 0; height: 100%; overflow: hidden; width: 100%; display: flex; flex-direction: column; }
        .content-viewer-wrap { height: 100%; width: 100%; display: grid; grid-template-columns: 300px 1fr; gap: 12px; }
        .content-left-pane { display: block; overflow: auto; max-height: 100%; padding: 12px; }
        .content-right-pane { height: 100%; width: 100%; display: flex; flex-direction: column; min-width: 0; }
        .app-workspace { border: 0; border-radius: 0; overflow: hidden; background: #fff; display: flex; flex-direction: column; width: 100%; height: 100%; }
        .app-topbar { position: sticky; top: 0; z-index: 2; display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 10px 12px; background: #f8fafc; border-bottom: 1px solid #e5e7eb; }
        .app-topbar-left { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; min-width: 0; }
        .app-title { font-weight: 700; }
        .app-link { font-size: 12px; color: #6b7280; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .app-timer { font-size: 12px; color: #374151; background: #eef2ff; padding: 4px 8px; border-radius: 999px; }
        .app-topbar-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .app-btn { border: none; border-radius: 8px; padding: 6px 10px; font-weight: 600; cursor: pointer; }
        .app-btn.primary { background: #2563eb; color: #fff; }
        .app-btn.warn { background: #f59e0b; color: #fff; }
        .app-btn.danger { background: #dc2626; color: #fff; }
        .app-frame-area { flex: 1; min-height: 0; background: #fff; }
        .app-frame-area iframe { width: 100%; height: 100%; border: 0; }
        .app-workspace.fullscreen { position: fixed; inset: 0; z-index: 4000; border-radius: 0; background: #fff; }
        .app-workspace.fullscreen .app-frame-area { height: 100vh; }
        .activity-layout { display: grid; grid-template-columns: 300px 1fr; gap: 12px; height: 100%; }
        .activity-left { border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px; background: #f8fafc; display: flex; flex-direction: column; gap: 10px; }
        .activity-title { font-weight: 700; font-size: 18px; }
        .activity-link { font-size: 12px; color: #6b7280; word-break: break-all; }
        .activity-timer { font-size: 12px; color: #374151; background: #eef2ff; padding: 6px 8px; border-radius: 999px; display: inline-block; }
        .activity-actions { display: flex; flex-direction: column; gap: 8px; }
        .activity-right { border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; background: #fff; height: 100%; position: relative; }
        .activity-right iframe { width: 100%; height: 100%; border: 0; }
        .activity-frame-status {
            position: absolute;
            top: 12px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            background: rgba(219, 234, 254, 0.94);
            border: 1px solid #93c5fd;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.15);
            display: none;
            max-width: min(92%, 640px);
            text-align: center;
            pointer-events: none;
        }
        .activity-frame-status.warn {
            color: #7c2d12;
            background: rgba(254, 243, 199, 0.95);
            border-color: #fcd34d;
        }
        .activity-frame-status.error {
            color: #7f1d1d;
            background: rgba(254, 226, 226, 0.95);
            border-color: #fca5a5;
        }
        #activity-modal .activity-layout { flex: 1; min-height: 0; }
        #activity-modal .activity-right { min-height: 0; }
        .activity-header-actions { display: none; align-items: center; gap: 8px; flex-wrap: wrap; justify-content: flex-end; }
        .activity-header-actions .app-btn { padding: 7px 10px; }
        #block-runner-timer { min-width: 120px; text-align: center; }
        #activity-modal.block-runner-mode .activity-layout { grid-template-columns: 1fr; }
        #activity-modal.block-runner-mode .activity-left { display: none; }
        #activity-modal.block-runner-mode .activity-header-actions { display: flex; }
        #activity-modal.teacher-block-runner .activity-header-actions { display: flex !important; }
        #activity-modal.block-runner-mode #btn-activity-exit { display: none !important; }
        #activity-modal.block-runner-mode { background: rgba(2, 6, 23, 0.96); }
        #activity-modal.block-runner-mode .modal-content {
            width: 100vw !important;
            max-width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
            border-radius: 0 !important;
            padding: 10px 12px !important;
            margin: 0 !important;
        }
        #activity-modal.block-runner-mode .modal-header { margin-bottom: 8px !important; }
        #activity-modal.block-runner-mode #btn-close-activity {
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: 999px;
            background: #fee2e2 !important;
            color: #b91c1c;
            font-size: 20px;
            line-height: 1;
            font-weight: 700;
        }
        .activity-fullbar { display: none; position: fixed; top: 0; left: 0; right: 0; z-index: 5000; background: #e9f0ff; color: #111827; padding: 8px 12px; gap: 10px; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
        .activity-fullbar .left { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .activity-fullbar .right { display: flex; gap: 8px; align-items: center; }
        .activity-fullbar .btn { background: #2563eb; color: #fff; border: none; border-radius: 8px; padding: 6px 10px; font-weight: 600; }
        .activity-fullbar .btn.exit { background: #dc2626; }
        .activity-fullbar .btn.exit.line-trace-close-btn {
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: 999px;
            font-size: 20px;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #ef4444, #dc2626);
            box-shadow: 0 8px 16px rgba(127, 29, 29, 0.35);
        }
        .app-btn.paused, .activity-fullbar .btn.paused { background: #f97316 !important; color: #fff !important; }
        .activity-right.paused #activity-iframe { filter: blur(3px); }
        .activity-right.paused { position: relative; }
        .activity-right.paused .activity-pause-overlay { display: flex; }
        .activity-pause-overlay { display: none; position: absolute; inset: 0; background: rgba(15, 23, 42, 0.35); align-items: center; justify-content: center; z-index: 10; }
        .activity-pause-card { background: #fff; padding: 16px 18px; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); display: flex; flex-direction: column; align-items: center; gap: 8px; }
        .activity-pause-card .btn { background: #2563eb; color: #fff; border: none; border-radius: 10px; padding: 8px 16px; font-weight: 600; }
        #activity-modal.block-runner-mode .activity-pause-card {
            border-radius: 999px;
            padding: 20px;
            width: 120px;
            height: 120px;
            justify-content: center;
            gap: 6px;
            background: rgba(255,255,255,0.96);
        }
        #activity-modal.block-runner-mode .activity-pause-card .btn {
            width: 84px;
            height: 84px;
            border-radius: 999px;
            padding: 0;
            font-size: 34px;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f59e0b, #ea580c) !important;
            color: #fff !important;
            border: 1px solid #f59e0b;
            box-shadow: 0 12px 24px rgba(234, 88, 12, 0.4);
        }
        #activity-modal.block-runner-mode .activity-pause-card .btn:hover {
            transform: translateY(-1px) scale(1.02);
            filter: brightness(1.03);
        }
        #activity-modal.block-runner-mode .activity-pause-card .pause-title {
            font-size: 11px;
            font-weight: 700;
            color: #1f2937;
            letter-spacing: 0.3px;
        }
        #activity-modal.fullscreen .activity-layout { grid-template-columns: 1fr; }
        #activity-modal.fullscreen .activity-left { display: none; }
        #activity-modal.fullscreen .modal-header { display: none; }
        #activity-modal.fullscreen {
            padding: 0 !important;
            align-items: stretch !important;
            justify-content: stretch !important;
        }
        #activity-modal.fullscreen .activity-layout {
            gap: 0 !important;
            height: 100vh !important;
        }
        #activity-modal.block-3d-mode .activity-layout { grid-template-columns: 1fr !important; }
        #activity-modal.block-3d-mode .activity-left { display: none !important; }
        #activity-modal.block-3d-mode .modal-header { display: none !important; }
        #activity-modal.block-3d-mode .modal-content {
            width: 100vw !important;
            max-width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        #activity-modal.fullscreen .modal-content {
            width: 100vw !important;
            max-width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        #activity-modal.fullscreen .activity-right {
            border-radius: 0 !important;
            border: 0 !important;
            overflow: hidden !important;
        }
        #activity-modal.fullscreen #activity-iframe {
            width: 100% !important;
            height: 100% !important;
            border: 0 !important;
            overflow: hidden !important;
        }
        #content-modal.fullscreen .modal-content { width: 98vw; max-width: 98vw; height: 90vh; max-height: 90vh; padding: 12px; }
        #content-modal.fullscreen .content-layout { height: 100%; }
        #content-modal.fullscreen .content-right { height: 100%; }
        #content-modal.fullscreen .content-viewer-wrap { height: 100%; grid-template-columns: 300px 1fr; }
        .content-item { padding: 10px; border-radius: 10px; background: #fff; border: 1px solid #e5e7eb; margin-bottom: 8px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .content-item.active { border-color: var(--primary); background: #eef6ff; }
        .content-tag { font-size: 11px; color: #555; background: #eef2ff; padding: 2px 6px; border-radius: 999px; }
        .content-editor-item { border: 1px dashed #cbd5e1; border-radius: 10px; padding: 10px; margin-bottom: 10px; background: #f8fafc; }
        .drag-handle { cursor: grab; font-weight: bold; margin-right: 8px; }
        .progress-mini { height: 6px; background: #e5e7eb; border-radius: 999px; overflow: hidden; margin-top: 6px; }
        .progress-mini > div { height: 100%; background: linear-gradient(90deg, #2563eb, #22c55e); }
        #student-stats-bar { display: block; }
        #student-stats-bar .stats-grid { display: grid; grid-template-columns: 1fr; gap: 8px; }
        #student-stats-bar .stat-card { min-width: 0; margin: 0; display: flex; flex-direction: column; justify-content: center; }
        #student-stats-bar .stat-number { font-size: 1.3rem; }
        #student-stats-bar .stat-label { font-size: 0.78rem; margin-top: 2px; }
        #student-stats-bar .completed-card { background: #e8f7ee; border: 1px solid #b7ebc6; }
        #student-stats-bar .completed-card .stat-label { color: #166534; }
        #student-stats-bar .completed-card .completed-summary .item { background: #f3fcf6; border-color: #cfeeda; }
        #student-stats-bar .completed-card .completed-summary .item .k { color: #166534; }
        #student-stats-bar .completed-card .completed-summary .item .v { color: #15803d; }
        .completed-summary { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; overflow: visible; }
        .completed-summary .item { flex: 1 1 92px; min-width: 86px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 9px; padding: 6px; text-align: center; }
        .completed-summary .item .k { font-size: 0.7rem; color: #64748b; }
        .completed-summary .item .v { font-size: 0.96rem; font-weight: 600; color: #2563eb; margin-top: 1px; }
        .completed-summary .item.xp-item .k { color: #0f5132; }
        .completed-summary .item.xp-item .v { color: var(--success); }
        .login-cards-modal-content {
            width: min(1120px, 96vw);
            max-height: 92vh;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .login-cards-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }
        .login-cards-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            max-height: 72vh;
            overflow: auto;
            padding-right: 4px;
        }
        .login-card-item {
            position: relative;
            border: 1px solid #c4b5fd;
            border-radius: 16px;
            background:
                linear-gradient(165deg, rgba(255,255,255,0.94) 0%, rgba(250,245,255,0.96) 42%, rgba(243,232,255,0.98) 100%);
            box-shadow: 0 10px 22px rgba(76, 29, 149, 0.18);
            padding: 12px 12px 14px 22px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-height: 154px;
            overflow: hidden;
        }
        .login-card-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 104px;
            background:
                linear-gradient(90deg, rgba(76,29,149,0.95), rgba(109,40,217,0.8));
            border-bottom: 1px solid #ddd6fe;
            pointer-events: none;
        }
        .login-card-item::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 20px;
            background:
                linear-gradient(180deg, rgba(76,29,149,0.98), rgba(124,58,237,0.9));
            clip-path: polygon(0 0, 100% 0, 72% 100%, 0 100%);
            pointer-events: none;
        }
        .login-card-accent {
            position: absolute;
            right: -22px;
            bottom: -16px;
            width: 110px;
            height: 58px;
            border-radius: 40px;
            transform: rotate(-12deg);
            background: linear-gradient(90deg, rgba(147,51,234,0.18), rgba(167,139,250,0.1));
            pointer-events: none;
        }
        .login-card-head {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: flex-start;
            align-items: center !important;
            gap: 10px;
            padding-top: 2px;
        }
        .login-card-logo {
            width: 92px;
            height: 92px;
            border-radius: 14px;
            border: 1px solid #ddd6fe;
            background: #fff;
            object-fit: contain;
            padding: 4px;
            box-shadow: 0 6px 16px rgba(76, 29, 149, 0.24);
            flex: 0 0 auto;
        }
        .login-card-title-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            gap: 8px;
            min-height: 92px;
            min-width: 0;
            padding-top: 4px;
        }
        .login-card-title {
            display: flex;
            align-items: baseline;
            gap: 8px;
            flex: 1 1 auto;
            font-size: 1.42rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.1;
            letter-spacing: 0.01em;
            text-shadow: 0 2px 4px rgba(49, 46, 129, 0.42);
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .login-card-title .name {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .login-card-meta {
            font-size: 1.14rem;
            font-weight: 600;
            color: #f5f3ff;
            text-shadow: 0 1px 2px rgba(49, 46, 129, 0.35);
            max-width: 48%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            line-height: 1.2;
            margin-top: 0;
        }
        .login-card-fields {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 8px;
            margin-top: 4px;
        }
        .login-card-foot {
            position: relative;
            z-index: 1;
            margin-top: auto;
            text-align: right;
            font-size: 1rem;
            font-weight: 700;
            color: #6d28d9;
        }
        .login-card-field {
            display: grid;
            grid-template-columns: 110px 1fr;
            border: 1px solid #ddd6fe;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.92);
            overflow: hidden;
        }
        .login-card-field .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.73rem;
            font-weight: 700;
            color: #4c1d95;
            background: #ede9fe;
            border-right: 1px solid #ddd6fe;
            white-space: nowrap;
        }
        .login-card-field .val {
            padding: 7px 10px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #312e81;
            letter-spacing: 0.01em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .login-card-field.password-field {
            border-color: #d8b4fe;
            background: rgba(250, 232, 255, 0.6);
        }
        .login-card-field.password-field .icon {
            background: #f3e8ff;
            border-right-color: #d8b4fe;
            color: #6b21a8;
            font-weight: 800;
        }
        .login-card-field.password-field .val {
            color: #581c87;
            font-weight: 800;
            font-size: 1.02rem;
        }
        .login-cards-empty {
            text-align: center;
            padding: 24px;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            color: #64748b;
            background: #f8fafc;
        }
        .teacher-top-wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; align-items: center; }
        #lesson-builder-modal {
            z-index: 24050;
            background: rgba(8, 15, 31, 0.88);
            align-items: stretch;
            justify-content: stretch;
        }
        .lesson-builder-shell {
            width: 100vw !important;
            max-width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
            margin: 0 !important;
            border-radius: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            display: grid;
            grid-template-rows: 64px 1fr;
            background:
                radial-gradient(circle at top right, rgba(59,130,246,0.18), rgba(255,255,255,0) 38%),
                linear-gradient(180deg, #f8fbff 0%, #f1f5f9 100%);
        }
        .lesson-builder-topbar {
            display: grid;
            grid-template-columns: auto minmax(280px, 620px) auto;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-bottom: 1px solid #dbe2ef;
            background: #ffffff;
        }
        .lesson-builder-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #0f172a;
            font-weight: 700;
            letter-spacing: 0.2px;
            white-space: nowrap;
        }
        .lesson-builder-brand .dot {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(120deg, #2563eb, #22c55e);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.16);
        }
        .lesson-title-wrap { display: flex; align-items: center; gap: 8px; min-width: 0; }
        .lesson-title-wrap .lesson-main-input {
            margin: 0;
            height: 42px;
            border-radius: 10px;
            font-size: 1.02rem;
            font-weight: 700;
            background: #f8fafc;
            border-color: #d6deec;
        }
        .lesson-builder-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .lesson-builder-main {
            min-height: 0;
            display: grid;
            grid-template-columns: 240px 1fr 300px;
            gap: 10px;
            padding: 10px;
        }
        .lesson-panel {
            background: #ffffff;
            border: 1px solid #d4deee;
            border-radius: 14px;
            min-height: 0;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.08);
        }
        .lesson-panel.left {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .lesson-left-top {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: space-between;
        }
        .lesson-left-top .title {
            font-weight: 800;
            color: #0f172a;
            font-size: 0.9rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        #lesson-slide-list {
            overflow: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 10px;
        }
        .lesson-frame-item {
            width: 100%;
            border: 1px solid #d9e1ef;
            border-radius: 12px;
            background: #f8fafc;
            color: #0f172a;
            text-align: left;
            padding: 10px;
            cursor: pointer;
            transition: all .18s ease;
        }
        .lesson-frame-item:hover { border-color: #93c5fd; background: #eff6ff; }
        .lesson-frame-item.active {
            border-color: #2563eb;
            background: linear-gradient(160deg, #eaf2ff, #dbeafe);
            box-shadow: inset 0 0 0 1px rgba(37,99,235,0.18);
        }
        .lesson-frame-title { font-weight: 700; font-size: 0.92rem; line-height: 1.3; }
        .lesson-frame-meta { margin-top: 4px; color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .lesson-panel.center {
            display: flex;
            flex-direction: column;
            min-height: 0;
            padding: 10px;
            gap: 8px;
        }
        .lesson-toolbar {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            border: 1px solid #d1d9e8;
            border-radius: 10px;
            padding: 6px;
            background: #f8fafc;
        }
        .lesson-toolbar .btn {
            margin: 0;
            background: #fff;
            color: #334155;
            padding: 7px 10px;
            border: 1px solid #d5dde9;
            font-weight: 700;
            min-width: 40px;
            border-radius: 8px;
        }
        .lesson-quick-tools {
            display: flex;
            flex-wrap: nowrap;
            gap: 8px;
            margin-top: 2px;
        }
        .lesson-quick-tools .btn {
            margin: 0;
            font-weight: 700;
            border-radius: 10px;
            flex: 1 1 0;
            min-width: 0;
        }
        .lesson-editor-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin: 0 0 6px;
            font-size: 0.8rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 800;
        }
        #lesson-builder-modal.lesson-question-mode #slide-content-editor,
        #lesson-builder-modal.lesson-question-mode #slide-media-row {
            display: none !important;
        }
        #lesson-builder-modal.lesson-question-mode #lesson-content-head {
            display: none !important;
        }
        .lesson-frame-item.drag-over {
            border-color: #2563eb;
            background: #dbeafe;
            transform: translateY(-1px);
        }
        .lesson-frame-item.dragging { opacity: .7; }
        .lesson-question-card {
            position: relative;
            border-radius: 16px;
            padding: 16px;
            border: 1px solid rgba(148, 163, 184, .45);
            backdrop-filter: blur(6px);
            box-shadow: 0 12px 30px rgba(15, 23, 42, .18);
            overflow: hidden;
        }
        .lesson-question-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 0% 0%, rgba(96, 165, 250, .26), transparent 45%);
            pointer-events: none;
        }
        .lesson-question-head {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 8px;
        }
        .lesson-question-tag {
            font-size: 11px;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-weight: 800;
            padding: 5px 10px;
            border-radius: 999px;
            border: 1px solid rgba(59, 130, 246, .35);
            background: rgba(219, 234, 254, .85);
            color: #1e3a8a;
        }
        .lesson-question-xp {
            font-size: 12px;
            font-weight: 900;
            padding: 5px 10px;
            border-radius: 999px;
            color: #166534;
            border: 1px solid rgba(34, 197, 94, .35);
            background: rgba(220, 252, 231, .88);
        }
        .lesson-question-timer {
            margin-top: 12px;
            position: relative;
            z-index: 1;
        }
        .lesson-question-timer-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .02em;
            color: #334155;
        }
        .lesson-question-timer-track {
            width: 100%;
            height: 10px;
            border-radius: 999px;
            overflow: hidden;
            background: rgba(148, 163, 184, .25);
            border: 1px solid rgba(148, 163, 184, .35);
        }
        .lesson-question-timer-fill {
            height: 100%;
            width: 0%;
            border-radius: 999px;
            background: linear-gradient(90deg, #22c55e 0%, #f59e0b 55%, #ef4444 100%);
            transition: width .1s linear;
        }
        .lesson-question-builder {
            display: grid;
            gap: 8px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
        }
        .lesson-question-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .lesson-question-options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .lesson-side-help {
            font-size: 11px;
            color: #64748b;
            line-height: 1.4;
        }
        .lesson-question-title { margin: 0 0 6px; position: relative; z-index: 1; }
        .lesson-question-layout {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-height: 0;
            max-height: 52vh;
        }
        .lesson-question-prompt {
            border: 1px solid rgba(148,163,184,.35);
            border-radius: 14px;
            padding: 16px;
            background: rgba(255,255,255,.08);
            display: flex;
            align-items: center;
        }
        .lesson-question-text {
            margin: 0;
            opacity: .98;
            font-size: clamp(14px, 2.1vw, 20px);
            line-height: 1.35;
            font-weight: 600;
            letter-spacing: .01em;
            position: relative;
            z-index: 1;
        }
        .lesson-q-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            align-content: stretch;
        }
        .lesson-q-option {
            width: 100%;
            text-align: left;
            margin: 0;
            border-radius: 12px;
            border: 1px solid #dbe3f0;
            background: linear-gradient(160deg, #ffffff 0%, #f8fbff 100%);
            padding: 14px;
            display: grid;
            grid-template-columns: 38px 1fr;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            min-height: 108px;
            transition: transform .16s ease, box-shadow .18s ease, background .18s ease, border-color .18s ease;
        }
        .lesson-q-option:hover { transform: translateX(2px); box-shadow: 0 8px 18px rgba(15, 23, 42, .12); }
        .lesson-q-option .opt-key {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 900;
            color: #1e3a8a;
            background: #dbeafe;
            border: 1px solid #93c5fd;
        }
        .lesson-q-option .opt-text {
            line-height: 1.35;
            color: #ffffff;
            font-size: 28px;
            font-weight: 900;
            text-shadow: 0 1px 2px rgba(0,0,0,.18);
        }
        .lesson-q-option.q-a { background: linear-gradient(145deg, #ef4444 0%, #dc2626 100%); border-color: #b91c1c; }
        .lesson-q-option.q-b { background: linear-gradient(145deg, #2563eb 0%, #1d4ed8 100%); border-color: #1e40af; }
        .lesson-q-option.q-c { background: linear-gradient(145deg, #f59e0b 0%, #d97706 100%); border-color: #b45309; }
        .lesson-q-option.q-d { background: linear-gradient(145deg, #22c55e 0%, #16a34a 100%); border-color: #15803d; }
        .lesson-q-option.q-t { background: linear-gradient(145deg, #22c55e 0%, #16a34a 100%); border-color: #15803d; }
        .lesson-q-option.q-f { background: linear-gradient(145deg, #ef4444 0%, #dc2626 100%); border-color: #b91c1c; }
        .lesson-q-option.is-correct {
            background: #dcfce7 !important;
            border-color: #22c55e !important;
            color: #166534 !important;
            animation: lessonPulseCorrect .48s ease;
        }
        .lesson-q-option.is-correct .opt-key { background: #16a34a; border-color: #15803d; color: #fff; }
        .lesson-q-option.is-wrong {
            background: #fee2e2 !important;
            border-color: #ef4444 !important;
            color: #991b1b !important;
            animation: lessonShakeWrong .42s ease;
        }
        .lesson-q-option.is-wrong .opt-key { background: #dc2626; border-color: #b91c1c; color: #fff; }
        .lesson-q-option.is-reveal-correct {
            background: #ecfccb !important;
            border-color: #84cc16 !important;
            color: #365314 !important;
        }
        .lesson-q-option.is-correct .opt-text,
        .lesson-q-option.is-wrong .opt-text,
        .lesson-q-option.is-reveal-correct .opt-text { color: inherit; text-shadow: none; }
        .lesson-q-option.is-reveal-correct .opt-key { background: #65a30d; border-color: #4d7c0f; color: #fff; }
        .lesson-dd-board {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 8px;
        }
        .lesson-dd-bank,
        .lesson-dd-targets {
            border: 1px dashed #93c5fd;
            border-radius: 10px;
            padding: 8px;
            min-height: 120px;
            background: rgba(255,255,255,.6);
        }
        .lesson-dd-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin: 4px;
            padding: 10px 14px;
            border-radius: 999px;
            border: 1px solid #93c5fd;
            background: #eff6ff;
            color: #1e3a8a;
            cursor: grab;
            font-weight: 800;
            font-size: 18px;
        }
        .lesson-dd-drop {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 8px;
            background: #fff;
        }
        .lesson-dd-drop.drag-over {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59,130,246,.2);
            background: #eff6ff;
        }
        .lesson-dd-drop .drop-answer {
            margin-top: 6px;
            padding: 10px 12px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            color: #334155;
            min-height: 64px;
            display: flex;
            align-items: center;
            font-size: 18px;
            font-weight: 700;
        }
        .kahoot-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 10px;
        }
        .kahoot-option {
            position: relative;
            display: grid;
            grid-template-columns: 54px 1fr;
            align-items: center;
            gap: 12px;
            min-height: 108px;
            border-radius: 14px;
            padding: 16px 18px;
            border: 2px solid #dbe3f0;
            background: linear-gradient(165deg, #ffffff 0%, #f8fbff 100%);
            color: #0f172a;
            cursor: pointer;
            font-weight: 800;
            transition: transform .14s ease, box-shadow .18s ease, border-color .18s ease, filter .18s ease;
        }
        .kahoot-option:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(15,23,42,.14); }
        .kahoot-option.is-selected {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.22), 0 10px 24px rgba(37,99,235,.18);
            filter: saturate(1.08);
        }
        .kahoot-option .k-key {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 900;
            color: #fff;
        }
        .kahoot-option .k-text {
            font-size: 26px;
            line-height: 1.2;
            color: #0f172a;
        }
        .kahoot-option.k-a .k-key { background: #ef4444; }
        .kahoot-option.k-b .k-key { background: #2563eb; }
        .kahoot-option.k-c .k-key { background: #eab308; color: #111827; }
        .kahoot-option.k-d .k-key { background: #22c55e; }
        .kahoot-option.k-t .k-key { background: #22c55e; }
        .kahoot-option.k-f .k-key { background: #ef4444; }
        .kahoot-option input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
        .lesson-answer-status {
            margin-top: 10px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .02em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            border-radius: 999px;
            border: 1px solid transparent;
            animation: lessonStatusIn .28s ease;
        }
        .lesson-answer-status.is-correct { color: #166534; background: #dcfce7; border-color: #86efac; }
        .lesson-answer-status.is-wrong { color: #991b1b; background: #fee2e2; border-color: #fca5a5; }
        #lesson-player-stage.lesson-answer-fx-correct .lesson-question-card { animation: lessonPulseCorrect .42s ease; }
        #lesson-player-stage.lesson-answer-fx-wrong .lesson-question-card { animation: lessonShakeWrong .38s ease; }
        @keyframes lessonPulseCorrect {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34, 197, 94, .0); }
            45% { transform: scale(1.012); box-shadow: 0 0 0 8px rgba(34, 197, 94, .16); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34, 197, 94, .0); }
        }
        @keyframes lessonShakeWrong {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-4px); }
            40% { transform: translateX(4px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
        }
        @keyframes lessonStatusIn {
            from { opacity: 0; transform: translateY(-3px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .lesson-editor-scroll {
            flex: 1;
            min-height: 0;
            overflow: auto;
            border: 1px solid #dbe3f0;
            border-radius: 12px;
            background: #ffffff;
            padding: 10px;
        }
        .lesson-content-block {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            padding: 10px;
            margin-top: 8px;
        }
        #slide-content-editor {
            min-height: 220px !important;
            border: 1px solid #d4deee !important;
            border-radius: 10px !important;
            background: #fff !important;
            padding: 10px !important;
        }
        #lesson-slide-preview {
            margin-top: 10px;
            border: 1px solid #dbe3f0 !important;
            border-radius: 10px !important;
            padding: 10px !important;
            background: #f8fafc !important;
            min-height: 320px !important;
        }
        .lesson-panel.right {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-height: 0;
            overflow: auto;
            padding: 10px;
        }
        .lesson-side-title {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #64748b;
            margin: 2px 0 0;
        }
        .lesson-side-block {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            padding: 8px;
        }
        .lesson-theme-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            margin-top: 6px;
        }
        .lesson-theme-item {
            border: 1px solid #d6deec;
            border-radius: 10px;
            background: #fff;
            padding: 8px;
            cursor: pointer;
            text-align: left;
        }
        .lesson-theme-item.active {
            border-color: #2563eb;
            box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.2);
            background: #eff6ff;
        }
        .lesson-theme-name { font-size: 0.82rem; font-weight: 700; color: #0f172a; }
        .lesson-theme-swatch {
            margin-top: 6px;
            height: 28px;
            border-radius: 8px;
            border: 1px solid rgba(15, 23, 42, 0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
        }
        .lesson-theme-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 8px;
        }
        #lesson-text-modal { z-index: 26002 !important; }
        #lesson-player-modal {
            z-index: 24080 !important;
            padding: 0 !important;
            align-items: stretch !important;
            justify-content: stretch !important;
        }
        .lesson-player-shell {
            width: 100vw !important;
            max-width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
            display: flex;
            flex-direction: column;
            padding: 10px 12px !important;
            border-radius: 0 !important;
            margin: 0 !important;
            overflow: hidden !important;
            position: relative;
            padding-bottom: 64px !important;
        }
        .lesson-player-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }
        .lesson-player-left-controls,
        .lesson-player-right-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .lesson-nav-toggle-btn {
            background: #e2e8f0;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            font-weight: 700;
        }
        .lesson-player-shell.is-nav-collapsed .lesson-nav-toggle-btn {
            background: #dbeafe;
            border-color: #93c5fd;
        }
        .lesson-player-grid {
            display: grid;
            grid-template-columns: 220px minmax(0, 1fr);
            gap: 12px;
            flex: 1;
            min-height: 0;
        }
        .lesson-player-shell.is-nav-collapsed .lesson-player-grid {
            grid-template-columns: minmax(0, 1fr);
            grid-template-rows: minmax(0, 1fr);
        }
        #lesson-player-nav {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px;
            overflow: auto;
            background: #fcfdff;
        }
        .lesson-player-shell.is-nav-collapsed #lesson-player-nav {
            display: none;
        }
        #lesson-player-stage {
            border: 1px solid #dbe3f0;
            border-radius: 14px;
            padding: 12px 14px;
            overflow: auto;
            background: #f8fafc;
            min-height: 0;
            overscroll-behavior: contain;
        }
        .lesson-player-page {
            will-change: transform, opacity;
            min-height: 100%;
            height: auto;
            display: flex;
            flex-direction: column;
        }
        .lesson-player-page-zoom {
            width: 100%;
            min-height: 100%;
            flex: 1 1 auto;
            word-break: break-word;
            overflow-wrap: anywhere;
        }
        .lesson-content-zoom {
            transform-origin: top left;
            transform: scale(var(--lesson-player-zoom, 1));
            width: calc(100% / var(--lesson-player-zoom, 1));
            min-height: 100%;
            will-change: transform;
        }
        #lesson-player-stage.lesson-code-layout .lesson-player-page,
        #lesson-player-stage.lesson-code-layout .lesson-player-page-zoom {
            height: 100%;
        }
        #lesson-player-stage.lesson-code-layout .lesson-content-zoom {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        #lesson-player-stage.lesson-code-layout .lesson-player-page-zoom {
            display: flex;
            flex-direction: column;
        }
        .lesson-code-card {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
        }
        .lesson-code-body {
            flex: 1;
            min-height: 0;
        }
        .lesson-code-frame-wrap {
            border: 1px solid #334155;
            border-radius: 12px;
            overflow: hidden;
            background: #0f172a;
            height: 100%;
            min-height: 420px;
            display: flex;
            flex-direction: column;
        }
        .lesson-code-frame {
            width: 100%;
            height: 100%;
            flex: 1;
            min-height: 360px;
            border: 0;
            background: #fff;
        }
        .lesson-page-enter-next {
            animation: lessonPageSlideNext .32s cubic-bezier(.22,.61,.36,1);
        }
        .lesson-page-enter-prev {
            animation: lessonPageSlidePrev .32s cubic-bezier(.22,.61,.36,1);
        }
        @keyframes lessonPageSlideNext {
            from { opacity: .24; transform: translateX(36px) scale(.985); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes lessonPageSlidePrev {
            from { opacity: .24; transform: translateX(-36px) scale(.985); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }
        .lesson-player-footer {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        .lesson-player-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .lesson-nav-btn {
            min-width: 130px;
            height: 48px;
            border: 0;
            border-radius: 12px;
            font-weight: 800;
            letter-spacing: 0.01em;
            transition: transform .16s ease, box-shadow .16s ease, filter .16s ease, opacity .16s ease;
        }
        .lesson-nav-btn:hover:not(:disabled) {
            transform: translateY(-1px);
            filter: saturate(1.06);
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.18);
        }
        .lesson-nav-btn:disabled {
            opacity: .55;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }
        #btn-lesson-prev.lesson-nav-btn {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #0f172a;
            border: 1px solid #cbd5e1;
        }
        #btn-lesson-next.lesson-nav-btn {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: #fff;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.28);
        }
        #btn-lesson-next.lesson-nav-btn.is-end {
            background: linear-gradient(135deg, #0ea5e9 0%, #22c55e 100%);
            box-shadow: 0 10px 20px rgba(34, 197, 94, 0.25);
        }
        .lesson-player-zoom-controls {
            position: absolute;
            left: 12px;
            bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid #dbe3f0;
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);
            z-index: 2;
        }
        .lesson-zoom-btn {
            min-width: 36px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #fff;
            font-weight: 800;
            color: #0f172a;
        }
        #lesson-zoom-reset {
            min-width: 58px;
            font-size: 12px;
            font-weight: 700;
        }
        
        .time-badge { background: #e3f2fd; color: var(--primary); padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: bold; }
        .live-quiz-invite-card {
            border: 2px solid #fb923c;
            box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.55);
            animation: liveInvitePulse 1.15s infinite;
        }
        .live-quiz-builder {
            display: grid;
            grid-template-columns: 240px 1fr 300px;
            gap: 12px;
            flex: 1;
            min-height: 0;
        }
        .live-quiz-sidebar {
            border: 1px solid #d8d8dd;
            border-radius: 12px;
            background: #ffffff;
            padding: 10px 10px 12px;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }
        .live-quiz-sidebar-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        .live-quiz-sidebar-head .title {
            font-size: 0.9rem;
            font-weight: 800;
            color: #111827;
        }
        #live-quiz-question-list {
            overflow: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding-right: 2px;
        }
        .live-quiz-question-row {
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 12px;
            text-align: left;
            padding: 8px 10px;
            cursor: pointer;
            transition: 0.2s ease;
        }
        .live-quiz-question-row.active {
            border-color: #2563eb;
            box-shadow: inset 0 0 0 1px rgba(37,99,235,0.2);
            background: #eef4ff;
        }
        .live-quiz-question-row:hover { transform: translateX(2px); }
        .live-quiz-question-row .meta {
            color: #64748b;
            font-size: 12px;
            margin-top: 3px;
        }
        .live-quiz-canvas {
            border: 1px solid #d6ccff;
            border-radius: 14px;
            padding: 14px;
            overflow: auto;
            background:
                linear-gradient(180deg, rgba(80, 41, 166, 0.84), rgba(45, 23, 94, 0.88)),
                radial-gradient(circle at top left, rgba(255,255,255,0.16), rgba(255,255,255,0.04) 56%);
        }
        .live-quiz-global {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 12px;
        }
        .live-quiz-editor-card {
            border: 1px solid rgba(255,255,255,0.34);
            border-radius: 12px;
            padding: 12px;
            background: rgba(243, 240, 255, 0.92);
        }
        .live-quiz-main-question {
            height: 64px;
            font-size: 1.1rem;
            border-radius: 10px;
            text-align: center;
            font-weight: 700;
        }
        .live-quiz-media-drop {
            margin-top: 10px;
            border: 2px dashed #b6a2e9;
            border-radius: 12px;
            background: rgba(255,255,255,0.75);
            padding: 10px;
            text-align: center;
        }
        .live-quiz-media-drop input[type="file"] {
            display: none;
        }
        .live-quiz-media-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #5b21b6;
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .live-quiz-media-preview {
            margin-top: 8px;
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 0.85rem;
        }
        .live-quiz-media-preview img {
            max-width: 100%;
            max-height: 180px;
            border-radius: 8px;
            border: 1px solid #ddd6fe;
            object-fit: cover;
        }
        .live-quiz-options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 8px;
        }
        .live-quiz-option-input {
            border-radius: 10px !important;
            color: #fff !important;
            border: none !important;
            font-weight: 600;
            min-height: 54px;
            font-size: 1rem;
        }
        #live-q-a { background: #ef4444 !important; }
        #live-q-b { background: #2563eb !important; }
        #live-q-c { background: #eab308 !important; color: #1f2937 !important; }
        #live-q-d { background: #16a34a !important; }
        #live-q-a::placeholder, #live-q-b::placeholder, #live-q-c::placeholder, #live-q-d::placeholder { color: rgba(255,255,255,0.92); }
        #live-q-c::placeholder { color: rgba(31,41,55,0.85); }
        .live-q-correct-mark {
            width: 44px;
            height: 44px;
            min-width: 44px;
            padding: 0 !important;
            border-radius: 999px !important;
            border: 2px solid #16a34a !important;
            background: linear-gradient(180deg, #86efac 0%, #22c55e 100%) !important;
            color: #064e3b !important;
            font-size: 24px !important;
            font-weight: 900 !important;
            line-height: 1 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.4);
            transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
            opacity: 0.9;
        }
        .live-q-correct-mark:hover {
            transform: translateY(-1px) scale(1.03);
            filter: saturate(1.18);
            box-shadow: 0 12px 26px rgba(22, 163, 74, 0.5);
        }
        .live-q-correct-mark.btn-success {
            border-color: #15803d !important;
            background: linear-gradient(180deg, #4ade80 0%, #16a34a 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 14px 30px rgba(22, 163, 74, 0.58);
            opacity: 1;
        }
        .lesson-question-builder {
            border: 1px solid #dbeafe;
            border-radius: 14px;
            padding: 12px;
            background: linear-gradient(145deg, #f8fbff 0%, #eef4ff 100%);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
        }
        .lesson-question-builder .form-control {
            border-radius: 10px;
        }
        .lesson-option-row {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 8px;
            align-items: center;
        }
        .lesson-option-tick {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 2px solid rgba(148,163,184,0.6);
            background: #fff;
            color: #0f172a;
            font-weight: 800;
            cursor: pointer;
        }
        .lesson-option-row.is-correct .lesson-option-tick {
            background: #22c55e;
            border-color: #16a34a;
            color: #fff;
        }
        .lesson-quiz-option {
            border-radius: 10px !important;
            color: #fff !important;
            border: none !important;
            font-weight: 600;
            min-height: 52px;
            font-size: 0.98rem;
        }
        #slide-option-0 { background: #ef4444 !important; }
        #slide-option-1 { background: #2563eb !important; }
        #slide-option-2 { background: #eab308 !important; color: #1f2937 !important; }
        #slide-option-3 { background: #16a34a !important; }
        #slide-option-0::placeholder, #slide-option-1::placeholder, #slide-option-2::placeholder, #slide-option-3::placeholder { color: rgba(255,255,255,0.92); }
        #slide-option-2::placeholder { color: rgba(31,41,55,0.85); }
        #lesson-player-stage .lesson-question-card {
            background: linear-gradient(145deg, rgba(25,20,53,0.92) 0%, rgba(73,38,143,0.88) 100%) !important;
            border: 1px solid rgba(255,255,255,0.16) !important;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.32);
            min-height: min(78vh, 560px);
            max-height: min(88vh, 660px);
            overflow: hidden;
            padding-bottom: 18px;
        }
        #lesson-player-stage .lesson-question-title {
            font-size: 1rem;
            font-weight: 700;
            color: #fff !important;
        }
        #lesson-player-stage .lesson-question-tag {
            background: rgba(255,255,255,0.16) !important;
            border-color: rgba(255,255,255,0.25) !important;
            color: #fff !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        #lesson-player-stage .lesson-question-xp {
            background: rgba(34,197,94,0.24) !important;
            border-color: rgba(34,197,94,0.45) !important;
            color: #bbf7d0 !important;
            font-weight: 800;
        }
        #lesson-player-stage .lesson-question-text {
            color: #fff !important;
        }
        #lesson-player-stage .lesson-question-layout {
            max-height: min(62vh, 450px);
        }
        #lesson-player-stage .lesson-question-layout > div {
            min-height: 0;
        }
        #lesson-player-stage .lesson-q-options {
            max-height: min(32vh, 250px);
            overflow: hidden;
        }
        .lesson-question-image-thumb {
            width: 400px;
            max-width: 100%;
            height: auto;
            object-fit: contain;
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.25);
            cursor: zoom-in;
            display: block;
            margin: 0 auto;
        }
        #lesson-image-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.75);
            z-index: 27000;
        }
        #lesson-image-modal .lesson-image-modal-content {
            position: relative;
            max-width: 92vw;
            max-height: 92vh;
        }
        #lesson-image-modal img {
            max-width: 92vw;
            max-height: 92vh;
            border-radius: 12px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.45);
        }
        #lesson-image-modal .lesson-image-modal-close {
            position: absolute;
            top: -12px;
            right: -12px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #dc2626;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(220,38,38,0.45);
        }
        #lesson-player-stage .lesson-q-option {
            border-radius: 10px !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
            font-weight: 700 !important;
            color: #fff !important;
            min-height: 56px;
        }
        #lesson-player-stage .lesson-q-option.q-a { background: #ef4444 !important; }
        #lesson-player-stage .lesson-q-option.q-b { background: #2563eb !important; }
        #lesson-player-stage .lesson-q-option.q-c { background: #eab308 !important; color: #1f2937 !important; }
        #lesson-player-stage .lesson-q-option.q-d { background: #16a34a !important; }
        #lesson-player-stage .lesson-q-option .opt-key {
            background: rgba(255,255,255,0.2) !important;
            border-color: rgba(255,255,255,0.35) !important;
            color: #fff !important;
        }
        .live-quiz-preview {
            margin-top: 10px;
            border-radius: 12px;
            border: 1px dashed rgba(255,255,255,0.4);
            background: linear-gradient(145deg, rgba(25,20,53,0.82) 0%, rgba(73,38,143,0.76) 100%);
            padding: 12px;
            color: #fff;
        }
        .live-quiz-right-panel {
            border: 1px solid #dddfe6;
            border-radius: 12px;
            background: #fff;
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-height: 0;
        }
        .live-quiz-right-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #111827;
        }
        .live-quiz-right-block {
            border-top: 1px solid #eceff3;
            padding-top: 10px;
            display: grid;
            gap: 8px;
        }
        .live-quiz-right-block .label {
            font-size: 0.85rem;
            color: #374151;
            font-weight: 700;
        }
        .live-quiz-actions-footer {
            margin-top: auto;
            border-top: 1px solid #eceff3;
            padding-top: 10px;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }
        @media (max-width: 1180px) {
            .live-quiz-builder { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .live-quiz-global,
            .live-quiz-options-grid,
            .live-quiz-preview-grid { grid-template-columns: 1fr; }
        }
        .live-quiz-preview-q { font-size: 1.03rem; font-weight: 700; margin-bottom: 8px; }
        .live-quiz-preview-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .live-quiz-preview-item {
            border-radius: 10px;
            padding: 9px 10px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.15);
            font-weight: 600;
            font-size: 0.9rem;
        }
        #live-quiz-modal {
            z-index: 24060;
            align-items: stretch;
            justify-content: stretch;
            background: rgba(8, 15, 31, 0.9);
        }
        #live-quiz-modal .modal-content {
            width: 100vw !important;
            max-width: 100vw !important;
            height: 100vh !important;
            max-height: 100vh !important;
            margin: 0 !important;
            border-radius: 0 !important;
            padding: 10px !important;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        #teacher-lessons-modal.fullscreen {
            position: fixed !important;
            inset: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 24040;
            align-items: stretch;
            justify-content: stretch;
            background: rgba(8, 15, 31, 0.9);
        }
        #teacher-lessons-modal.fullscreen .modal-content {
            width: 100vw !important;
            max-width: none !important;
            height: 100vh !important;
            max-height: none !important;
            margin: 0 !important;
            border-radius: 0 !important;
            padding: 12px !important;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .live-player-option {
            border-radius: 10px !important;
            border: 1px solid #d1d5db !important;
            text-align: left !important;
            font-weight: 700 !important;
            transition: 0.18s ease !important;
        }
        .live-player-shell {
            max-width: 1040px !important;
            width: 96vw;
            border-radius: 18px;
            border: 1px solid #c7d2fe;
            background:
                radial-gradient(circle at 85% 0%, rgba(79, 70, 229, 0.18), rgba(79, 70, 229, 0) 34%),
                linear-gradient(145deg, #f8fbff 0%, #eef4ff 100%);
            padding: 14px;
        }
        .live-player-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }
        #live-player-title {
            margin: 0;
            font-size: 1.32rem;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: 0.2px;
        }
        .live-player-timer {
            min-width: 130px;
            text-align: center;
            padding: 10px 14px;
            border-radius: 999px;
            background: linear-gradient(135deg, #1d4ed8, #4f46e5);
            color: #fff;
            font-size: 1.04rem;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.25);
            border: 1px solid rgba(255,255,255,0.5);
        }
        .live-player-timer.warn {
            background: linear-gradient(135deg, #f59e0b, #ea580c);
            box-shadow: 0 10px 24px rgba(234, 88, 12, 0.25);
        }
        .live-player-timer.danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            box-shadow: 0 10px 24px rgba(185, 28, 28, 0.3);
        }
        .live-player-question {
            margin-top: 12px;
            font-size: 1.18rem;
            font-weight: 800;
            color: #fff;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.28);
            background: linear-gradient(140deg, #334155 0%, #1e3a8a 55%, #4f46e5 100%);
            padding: 14px 16px;
            line-height: 1.35;
        }
        .live-player-options {
            margin-top: 12px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .live-player-option {
            min-height: 58px;
            border: none !important;
            color: #fff !important;
            padding: 12px 14px !important;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.2);
            display: flex !important;
            align-items: center;
            gap: 10px;
            font-size: 1rem !important;
        }
        .live-player-option.opt-a { background: linear-gradient(135deg, #ef4444, #dc2626) !important; }
        .live-player-option.opt-b { background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important; }
        .live-player-option.opt-c { background: linear-gradient(135deg, #f59e0b, #d97706) !important; }
        .live-player-option.opt-d { background: linear-gradient(135deg, #22c55e, #15803d) !important; }
        .live-player-option.tf-true { background: linear-gradient(135deg, #16a34a, #15803d) !important; }
        .live-player-option.tf-false { background: linear-gradient(135deg, #dc2626, #b91c1c) !important; }
        .live-player-option .opt-key {
            min-width: 28px;
            height: 28px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.22);
            border: 1px solid rgba(255,255,255,0.35);
            font-weight: 800;
            font-size: 0.86rem;
        }
        .live-player-option .opt-text {
            font-weight: 700;
            line-height: 1.2;
        }
        .live-player-option.selected {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.28), inset 0 0 0 2px rgba(255,255,255,0.75);
        }
        .live-player-option.selected.correct {
            box-shadow: 0 14px 30px rgba(22, 163, 74, 0.35), inset 0 0 0 2px rgba(236, 253, 245, 0.95);
        }
        .live-player-option.selected.wrong {
            box-shadow: 0 14px 30px rgba(220, 38, 38, 0.35), inset 0 0 0 2px rgba(254, 226, 226, 0.95);
        }
        .live-player-info {
            margin-top: 10px;
            font-size: 0.95rem;
            color: #334155;
            font-weight: 600;
            background: #f8fafc;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            padding: 8px 10px;
        }
        .live-match-board {
            margin-top: 12px;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            background: #f8fbff;
            padding: 10px;
        }
        .live-match-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .live-match-col-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: #475569;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .live-match-left-item,
        .live-match-dropzone,
        .live-match-chip {
            border-radius: 10px;
            padding: 9px 10px;
            font-weight: 700;
            line-height: 1.25;
        }
        .live-match-left-item {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            color: #1e3a8a;
            margin-bottom: 8px;
        }
        .live-match-dropzone {
            background: #fff;
            border: 2px dashed #bfdbfe;
            color: #475569;
            min-height: 44px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .live-match-dropzone.filled {
            border-style: solid;
            border-color: #60a5fa;
            background: #eff6ff;
            color: #1e3a8a;
        }
        .live-match-chip-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .live-match-chip {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.35);
            cursor: grab;
            user-select: none;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.2);
        }
        .live-match-chip.used {
            opacity: 0.35;
            cursor: not-allowed;
        }
        .live-match-submit {
            margin-top: 8px;
            width: 100%;
        }
        @media (max-width: 900px) {
            .live-player-options { grid-template-columns: 1fr; }
            .live-match-grid { grid-template-columns: 1fr; }
            .live-player-timer { min-width: 106px; font-size: 0.96rem; padding: 8px 10px; }
            #live-player-title { font-size: 1.1rem; }
            .live-player-question { font-size: 1.03rem; padding: 12px; }
        }
        #teacher-live-monitor-modal {
            z-index: 26050;
            background: rgba(2, 6, 23, 0.84);
            backdrop-filter: blur(3px);
        }
        .teacher-live-monitor-shell {
            width: 98vw;
            height: 94vh;
            max-width: 1480px;
            border-radius: 18px;
            border: 1px solid #cbd5e1;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.22), rgba(255,255,255,0) 35%),
                linear-gradient(145deg, #f8fbff 0%, #eef4ff 100%);
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            overflow: hidden;
        }
        .teacher-live-monitor-head {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
        }
        .teacher-live-monitor-title {
            font-size: 1.18rem;
            font-weight: 800;
            color: #1e3a8a;
        }
        .teacher-live-monitor-sub {
            font-size: 0.9rem;
            color: #475569;
            margin-top: 2px;
        }
        .teacher-live-monitor-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .teacher-live-monitor-metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
        }
        .teacher-live-metric {
            border: 1px solid #dbeafe;
            border-radius: 12px;
            background: #ffffff;
            padding: 8px 10px;
        }
        .teacher-live-metric .k {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }
        .teacher-live-metric .v {
            font-size: 1.16rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 2px;
        }
        #teacher-live-monitor-list {
            flex: 1;
            min-height: 0;
            overflow: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 10px;
            align-content: start;
            padding-right: 2px;
        }
        .teacher-live-student-card {
            border: 1px solid #dbeafe;
            border-radius: 14px;
            background: #fff;
            padding: 10px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
            animation: liveCardIn 0.24s ease;
        }
        .teacher-live-student-card.answered {
            border-color: #86efac;
            box-shadow: 0 10px 22px rgba(22, 163, 74, 0.14);
        }
        .teacher-live-student-card.pending {
            border-color: #fca5a5;
        }
        .teacher-live-student-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 8px;
        }
        .teacher-live-student-name {
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }
        .teacher-live-student-rank {
            min-width: 34px;
            height: 34px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1e3a8a;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .teacher-live-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 999px;
            padding: 4px 8px;
            margin-bottom: 6px;
        }
        .teacher-live-status::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            display: inline-block;
            animation: livePulse 1.2s infinite;
        }
        .teacher-live-status.answered {
            background: #dcfce7;
            color: #166534;
        }
        .teacher-live-status.answered::before { background: #16a34a; }
        .teacher-live-status.pending {
            background: #fee2e2;
            color: #991b1b;
        }
        .teacher-live-status.pending::before { background: #dc2626; }
        .teacher-live-student-meta {
            font-size: 0.86rem;
            color: #334155;
            display: grid;
            gap: 3px;
        }
        @keyframes liveCardIn {
            from { opacity: 0; transform: translateY(6px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes livePulse {
            0% { box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.35); }
            100% { box-shadow: 0 0 0 8px rgba(22, 163, 74, 0); }
        }
        .certificate-shell {
            max-width: 1180px !important;
            width: 96vw;
            background: linear-gradient(165deg, #eef4fb 0%, #ffffff 100%);
            border: 1px solid #d2dcea;
        }
        .certificate-modal-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        .student-certificate {
            position: relative;
            overflow: hidden;
            width: 100%;
            min-height: 640px;
            border-radius: 24px;
            border: 1px solid #c9d9e8;
            background:
                radial-gradient(circle at 10% 12%, rgba(30, 64, 175, 0.08), transparent 38%),
                radial-gradient(circle at 90% 88%, rgba(3, 105, 161, 0.09), transparent 40%),
                #ffffff;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
            padding: 42px 44px 34px;
            display: grid;
            align-content: start;
            justify-items: center;
            gap: 12px;
            text-align: center;
        }
        .student-certificate::before {
            content: "";
            position: absolute;
            inset: 20px;
            border: 2px solid #0f4c81;
            border-radius: 14px;
            pointer-events: none;
        }
        .student-certificate::after {
            content: "";
            position: absolute;
            inset: 33px;
            border: 1px solid rgba(15, 76, 129, 0.22);
            border-radius: 10px;
            pointer-events: none;
        }
        .certificate-badge {
            width: 88px;
            height: 88px;
            border-radius: 999px;
            border: 3px solid #d4af37;
            background: radial-gradient(circle at 30% 30%, #fff7d2 0%, #e8b84e 72%);
            display: grid;
            place-items: center;
            color: #6f4b00;
            font-size: 2rem;
            box-shadow: 0 8px 20px rgba(111, 75, 0, 0.2);
            margin-top: 4px;
        }
        .certificate-logo {
            width: 188px;
            height: auto;
            margin-top: 4px;
            margin-bottom: 0;
            filter: drop-shadow(0 4px 10px rgba(15, 23, 42, 0.15));
        }
        .certificate-title {
            font-family: "Cinzel", "Times New Roman", Georgia, serif;
            font-size: 3.1rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #0f355d;
            margin: 0;
            font-weight: 700;
        }
        .certificate-student-name {
            font-family: "Brush Script MT", "Segoe Script", "Times New Roman", Georgia, serif;
            font-size: 4rem;
            line-height: 1.1;
            color: #0b5fa0;
            font-weight: 700;
            margin: 0;
            padding: 0 16px 10px;
            border-bottom: 2px solid rgba(11, 95, 160, 0.35);
        }
        .certificate-text {
            max-width: 920px;
            font-size: 1.14rem;
            line-height: 1.75;
            color: #374151;
            margin: 0;
        }
        .certificate-meta-row {
            margin-top: 6px;
            width: 100%;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }
        .certificate-meta-item {
            border: 1px solid #d1dbe7;
            background: linear-gradient(180deg, #ffffff 0%, #f6f9fc 100%);
            border-radius: 10px;
            padding: 10px 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .certificate-meta-item .k {
            font-size: 0.7rem;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: #1d4f7a;
            font-weight: 700;
        }
        .certificate-meta-item .v {
            font-size: 1.02rem;
            color: #0f355d;
            font-weight: 700;
        }
        .certificate-footer-note {
            margin-top: 8px;
            width: 100%;
        }
        .certificate-sign-row {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .certificate-sign-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }
        .certificate-sign-line {
            width: 78%;
            border-bottom: 1.7px solid #264f77;
            height: 24px;
        }
        .certificate-sign-role {
            font-size: 0.74rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #1d4f7a;
            font-weight: 700;
        }
        .certificate-sign-name {
            font-size: 1rem;
            color: #0f355d;
            font-weight: 700;
        }
        .teacher-cert-toolbar {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
            margin-bottom: 10px;
            align-items: end;
        }
        .teacher-cert-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }
        .teacher-cert-note {
            margin: 0 0 8px;
            font-size: 0.9rem;
            color: #475569;
        }
        @media (max-width: 900px) {
            .student-certificate {
                min-height: 0;
                padding: 24px 16px 18px;
            }
            .certificate-badge {
                width: 68px;
                height: 68px;
                font-size: 1.45rem;
            }
            .certificate-logo {
                width: 130px;
            }
            .certificate-title {
                font-size: 1.8rem;
            }
            .certificate-text {
                font-size: 0.98rem;
            }
            .certificate-student-name {
                font-size: 2.5rem;
            }
            .certificate-meta-row {
                grid-template-columns: 1fr 1fr;
            }
            .certificate-sign-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .teacher-cert-toolbar {
                grid-template-columns: 1fr 1fr;
            }
        }
        @keyframes liveInvitePulse {
            0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.55); }
            70% { box-shadow: 0 0 0 14px rgba(249, 115, 22, 0); }
            100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
        }
        .deadline-badge { background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 12px; font-size: 0.75rem; }
        .deadline-expired { background: #f8d7da; color: #721c24; }
        
        .activity-history-item { padding: 12px; background: #f8f9fa; margin-bottom: 8px; border-radius: 8px; border-left: 3px solid var(--success); }
        
        .empty-state { text-align: center; padding: 40px 20px; color: #888; }
        .empty-state-icon { font-size: 3rem; margin-bottom: 10px; }
        /* Dersler: liste boşsa empty-state otomatik görünsün (JS aksasa bile) */
        #lessons-pending #list-lessons-pending:empty + #no-lessons-pending,
        #lessons-completed #list-lessons-completed:empty + #no-lessons-completed {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .loading { text-align: center; padding: 20px; color: var(--primary); }
        
        .date-input { font-family: inherit; }
        .login-screen {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: stretch;
            justify-content: center;
            padding: 0;
            background: linear-gradient(135deg, #090f1f 0%, #0f1f44 45%, #132a60 100%);
            z-index: 3000;
            min-height: 100svh;
            height: 100svh;
            width: 100vw;
        }
        .login-screen.hidden { display: none !important; }
        .login-screen .login-card { position: relative; top: auto; left: auto; transform: none; margin: 0; pointer-events: auto; }
        .login-card {
            width: 100%;
            min-height: 100svh;
            border-radius: 0;
            border: 0;
            background: transparent;
            box-shadow: none;
            overflow: hidden;
            padding: 0;
        }
        .login-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(460px, 0.8fr);
            min-height: 100svh;
        }
        .login-left {
            position: relative;
            padding: clamp(28px, 4vw, 56px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
            isolation: isolate;
            overflow: hidden;
            background:
                radial-gradient(700px 420px at 15% 12%, rgba(147, 197, 253, 0.46), transparent 65%),
                radial-gradient(560px 300px at 88% 82%, rgba(186, 230, 253, 0.42), transparent 70%),
                linear-gradient(135deg, #e7f0ff 0%, #dbeafe 55%, #e0f2fe 100%);
        }
        .login-left-top {
            text-align: center;
            max-width: 560px;
            z-index: 3;
            width: 100%;
            margin: 0 auto;
        }
        .login-scene {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 9;
            display: block !important;
        }
        .scene-item {
            position: absolute;
            opacity: 1;
            color: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.65);
            background: rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            padding: 8px 13px;
            backdrop-filter: blur(2px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.22);
            font-weight: 800;
            letter-spacing: 0.45px;
            filter: none;
            z-index: 10;
            text-shadow: 0 2px 8px rgba(15, 23, 42, 0.55);
            animation-timing-function: ease-in-out;
            animation-iteration-count: infinite;
        }
        .scene-rocket { font-size: clamp(16px, 1.55vw, 22px); animation-name: rocketFly; animation-duration: 4.8s; }
        .scene-robot { font-size: clamp(16px, 1.55vw, 22px); animation-name: robotFloat; animation-duration: 3.4s; }
        .scene-code { font-family: "JetBrains Mono", monospace; font-size: clamp(14px, 1.3vw, 18px); animation-name: codeDrift; animation-duration: 4.1s; }
        .scene-rocket.r1 { top: 10%; left: 9%; animation-delay: -1s; }
        .scene-rocket.r2 { top: 64%; left: 64%; animation-delay: -5s; }
        .scene-robot.b1 { top: 18%; right: 10%; animation-delay: -2s; }
        .scene-robot.b2 { top: 76%; right: 24%; animation-delay: -4s; }
        .scene-code.c1 { top: 36%; left: 14%; animation-delay: -3s; }
        .scene-code.c2 { top: 52%; right: 13%; animation-delay: -6s; }
        .login-scene::before,
        .login-scene::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .login-scene::before {
            background-image:
                radial-gradient(circle, rgba(255,255,255,0.82) 1.2px, transparent 1.2px),
                radial-gradient(circle, rgba(255,255,255,0.6) 1px, transparent 1px);
            background-size: 84px 84px, 56px 56px;
            background-position: 0 0, 20px 10px;
            opacity: 0.5;
            animation: starDrift 18s linear infinite;
        }
        .login-scene::after {
            background: radial-gradient(500px 220px at 50% 40%, rgba(255,255,255,0.16), transparent 70%);
            opacity: 0.7;
        }
        .scene-dot {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.2);
            animation: dotFloat 4.8s ease-in-out infinite;
            z-index: 9;
        }
        .scene-dot.d1 { top: 20%; left: 44%; animation-delay: -1s; }
        .scene-dot.d2 { top: 46%; left: 74%; animation-delay: -3s; }
        .scene-dot.d3 { top: 72%; left: 36%; animation-delay: -5s; }
        .login-left::before,
        .login-left::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
            z-index: 0;
            filter: blur(40px);
            opacity: 0.85;
        }
        .login-left::before {
            width: 340px;
            height: 340px;
            top: -120px;
            left: -90px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.42) 0%, rgba(191, 219, 254, 0.18) 55%, transparent 80%);
            animation: loginFloatA 9s ease-in-out infinite alternate;
        }
        .login-left::after {
            width: 300px;
            height: 300px;
            right: -90px;
            bottom: -120px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.32) 0%, rgba(125, 211, 252, 0.14) 56%, transparent 82%);
            animation: loginFloatB 11s ease-in-out infinite alternate;
        }
        .login-left > * { position: relative; }
        @keyframes loginFloatA {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(18px, 14px) scale(1.08); }
        }
        @keyframes loginFloatB {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-16px, -18px) scale(1.06); }
        }
        .login-left-top h2 {
            margin: 0;
            font-size: clamp(1.95rem, 3.4vw, 2.7rem);
            line-height: 1.08;
            color: #0f172a;
            letter-spacing: -0.7px;
        }
        .login-left-top p {
            margin: 12px 0 0;
            color: #334155;
            font-size: clamp(0.95rem, 1.2vw, 1.06rem);
            line-height: 1.5;
        }
        .login-hero-logo {
            max-width: 520px;
            width: 100%;
            margin: 2px auto;
            display: block;
            filter: drop-shadow(0 16px 32px rgba(2, 6, 23, 0.55));
            z-index: 3;
            position: relative;
            left: 0;
            right: 0;
        }
        .login-slogan {
            margin: 6px 0 0;
            color: #0f172a;
            font-size: 0.98rem;
            letter-spacing: 0.32px;
            font-weight: 700;
            text-align: center;
            z-index: 3;
            width: 100%;
        }
        .login-right {
            position: relative;
            padding: clamp(24px, 3vw, 40px) clamp(22px, 2.6vw, 42px);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(170deg, #f8fbff 0%, #eef4ff 100%);
        }
        .login-form-wrap {
            width: 100%;
            max-width: 430px;
            display: grid;
            gap: 12px;
            padding: 28px;
            border-radius: 22px;
            border: 1px solid #dbe5f4;
            background: #ffffff;
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.12);
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .login-form-wrap h3 {
            margin: 0;
            font-size: clamp(1.62rem, 2.4vw, 2rem);
            color: #0f172a;
            letter-spacing: -0.4px;
        }
        .login-form-wrap .login-sub {
            margin: 0 0 8px;
            color: #475569;
            font-size: 0.97rem;
            line-height: 1.45;
        }
        .login-form-wrap label {
            color: #334155;
            font-weight: 600;
            margin-top: 2px;
            font-size: 0.92rem;
            text-align: center;
        }
        .login-title-bar { position: relative; display: flex; align-items: center; justify-content: center; margin-bottom: 2px; min-height: 36px; }
        .login-title-bar h3 { margin: 0; }
        .theme-toggle-inline {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #1f2937;
            font-size: 17px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        .theme-toggle-inline:hover { background: #f8fafc; }
        .theme-toggle {
            position: absolute;
            right: 18px;
            top: 18px;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #1f2937;
            font-size: 17px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        .theme-toggle:hover { background: #f8fafc; }
        #login-screen .form-control {
            max-width: 100%;
            box-sizing: border-box;
            height: 50px;
            border-radius: 12px;
            border: 1px solid #d7e0ef;
            background: #f8fbff;
            padding: 0 14px;
            color: #0f172a;
            font-weight: 500;
        }
        #login-screen .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.11); outline: none; background: #ffffff; }
        #login-screen .btn { max-width: 100%; box-sizing: border-box; }
        .login-logo { width: 110px; height: auto; display: block; margin: 0 auto 10px; }
        .login-actions { display: flex; gap: 10px; }
        .login-actions .btn { flex: 1 1 0; min-width: 0; }
        #btn-login {
            margin-top: 8px;
            height: 50px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            background: linear-gradient(90deg, #2563eb 0%, #1d4ed8 52%, #1e40af 100%);
            border: 0;
            letter-spacing: 0.2px;
        }
        @keyframes rocketFly {
            0% { transform: translate(0, 0) rotate(-6deg); opacity: 0.85; }
            50% { transform: translate(52px, -30px) rotate(-2deg); opacity: 1; }
            100% { transform: translate(96px, -62px) rotate(4deg); opacity: 0.9; }
        }
        @keyframes robotFloat {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-18px) scale(1.04); }
        }
        @keyframes codeDrift {
            0% { transform: translateY(20px); opacity: 0.65; }
            20% { opacity: 1; }
            100% { transform: translateY(-74px); opacity: 0.75; }
        }
        @keyframes starDrift {
            0% { transform: translateY(0); }
            100% { transform: translateY(-32px); }
        }
        @keyframes dotFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-18px); }
        }

        body.dark-mode { background: #0b1220 !important; color: #e5e7eb; }
        body.dark-mode #app-screen { background: #0f172a !important; }
        body.dark-mode .card,
        body.dark-mode .modal-content,
        body.dark-mode .home-overview-card,
        body.dark-mode .list-item,
        body.dark-mode .student-list-item,
        body.dark-mode .stat-card,
        body.dark-mode .tab-content,
        body.dark-mode .content-item,
        body.dark-mode .kpi,
        body.dark-mode .info-pill {
            background: #111827 !important;
            color: #e5e7eb !important;
            border-color: #374151 !important;
            box-shadow: none !important;
        }
        body.dark-mode .form-control,
        body.dark-mode select,
        body.dark-mode textarea,
        body.dark-mode input {
            background: #0b1220 !important;
            color: #e5e7eb !important;
            border-color: #334155 !important;
        }
        body.dark-mode .tabs,
        body.dark-mode .filter-bar,
        body.dark-mode .chart-container {
            background: #111827 !important;
            border-color: #334155 !important;
        }
        body.dark-mode .tab-btn,
        body.dark-mode .filter-btn,
        body.dark-mode .btn {
            color: #e5e7eb;
            border-color: #334155;
        }
        body.dark-mode .tab-btn:not(.active),
        body.dark-mode .filter-btn:not(.active),
        body.dark-mode .btn:not(.btn-primary):not(.btn-success):not(.btn-danger):not(.btn-warning) {
            background: #1f2937 !important;
        }
        body.dark-mode #side-menu { background-color: #020617; border-right: none; }
        body.dark-mode #side-menu .sidebar-footer { border-top-color: #1f2937; }
        body.dark-mode .sidebar-footer-title { color: #94a3b8; }
        body.dark-mode #side-menu button { color: #cbd5e1; }
        body.dark-mode #side-menu button:hover { background: #111827; color: #e5e7eb; }
        body.dark-mode #side-menu button.active { background: #1e293b; color: #93c5fd; }
        body.dark-mode #side-menu .sidebar-group-toggle { color: #cbd5e1 !important; border-top-color: #1f2937; }
        body.dark-mode #side-menu .sidebar-submenu .submenu-item { color: #94a3b8 !important; }
        body.dark-mode #side-menu .sidebar-submenu .submenu-item:hover { background: #111827; color: #e2e8f0 !important; }
        body.dark-mode #side-menu .sidebar-logo { border: none; background: transparent; }
        body.dark-mode #user-dropdown { background: #0f172a !important; border-color: #334155 !important; }
        body.dark-mode #user-menu-trigger,
        body.dark-mode #user-welcome,
        body.dark-mode #user-fullname {
            color: #e5e7eb !important;
        }
        body.dark-mode #user-menu-trigger {
            background: #1f2937 !important;
            border-color: #334155 !important;
        }
        body.dark-mode #user-header-avatar {
            border-color: #0f172a;
            box-shadow: 0 6px 14px rgba(2, 6, 23, 0.55);
        }
        body.dark-mode .avatar-shop-modal-content {
            background: #0f172a !important;
            border-color: #334155 !important;
        }
        body.dark-mode .avatar-card {
            background: linear-gradient(160deg, #111827, #0b1220);
            border-color: #334155;
        }
        body.dark-mode .avatar-card.owned { background: #052e21; border-color: #10b981; }
        body.dark-mode .avatar-cost { color: #cbd5e1; }
        body.dark-mode .avatar-shop-xp {
            background: #052e21;
            border-color: #10b981;
            color: #d1fae5;
        }
        body.dark-mode .edu-ai-panel {
            background: #0f172a;
            border-color: #334155;
        }
        body.dark-mode .edu-ai-fab {
            background:
                radial-gradient(circle at 32% 20%, rgba(255,255,255,0.25), rgba(255,255,255,0) 40%),
                linear-gradient(145deg, #0f172a, #1e3a8a 58%, #2563eb);
            border-color: rgba(148, 163, 184, 0.55);
        }
        body.dark-mode .edu-ai-core {
            border-color: #cbd5e1;
            box-shadow: 0 10px 20px rgba(2, 6, 23, 0.48), inset 0 0 0 1px rgba(255,255,255,0.2);
        }
        body.dark-mode .edu-ai-wing {
            background: linear-gradient(180deg, #f8fafc, #cbd5e1 62%, #94a3b8);
            border-color: #64748b;
        }
        body.dark-mode .edu-ai-panel-head {
            background: linear-gradient(130deg, #0b1220, #1e293b);
            border-bottom-color: #334155;
        }
        body.dark-mode .edu-ai-panel-title { color: #e2e8f0; }
        body.dark-mode .edu-ai-panel-sub { color: #94a3b8; }
        body.dark-mode .edu-ai-messages { background: #111827; }
        body.dark-mode .edu-ai-msg.user {
            background: #1e3a8a;
            color: #dbeafe;
            border-color: #1d4ed8;
        }
        body.dark-mode .edu-ai-msg.bot {
            background: #0b3a4a;
            color: #bae6fd;
            border-color: #155e75;
        }
        body.dark-mode .edu-ai-input-wrap,
        body.dark-mode .edu-ai-quick {
            background: #0f172a;
            border-top-color: #334155;
        }
        body.dark-mode .edu-ai-input {
            background: #111827;
            color: #e5e7eb;
            border-color: #334155;
        }
        body.dark-mode .edu-ai-quick button {
            background: #1f2937;
            color: #cbd5e1;
            border-color: #334155;
        }
        body.dark-mode #login-screen {
            background:
                radial-gradient(900px 440px at 0% 0%, rgba(30, 64, 175, 0.28), transparent 64%),
                radial-gradient(900px 440px at 100% 100%, rgba(14, 116, 144, 0.24), transparent 62%),
                linear-gradient(145deg, #0f172a 0%, #020617 100%) !important;
        }
        body.dark-mode .login-card {
            background: rgba(2, 6, 23, 0.9) !important;
            border-color: #334155 !important;
            box-shadow: 0 26px 70px rgba(0, 0, 0, 0.45) !important;
        }
        body.dark-mode #login-screen .login-left {
            background:
                radial-gradient(760px 380px at 10% 0%, rgba(37, 99, 235, 0.3), transparent 62%),
                linear-gradient(165deg, #1e293b 0%, #0f172a 100%) !important;
            border-right: 1px solid #334155;
        }
        body.dark-mode #login-screen .login-left::before {
            background: radial-gradient(circle, rgba(59, 130, 246, 0.34) 0%, rgba(37, 99, 235, 0.2) 56%, transparent 82%);
        }
        body.dark-mode #login-screen .login-left::after {
            background: radial-gradient(circle, rgba(14, 165, 233, 0.28) 0%, rgba(2, 132, 199, 0.16) 56%, transparent 82%);
        }
        body.dark-mode #login-screen .login-right { background: #0f172a !important; }
        body.dark-mode #login-screen .login-form-wrap {
            background: #111827 !important;
            border-color: #334155 !important;
            box-shadow: 0 18px 42px rgba(2, 6, 23, 0.42) !important;
        }
        body.dark-mode #login-screen .login-left-top h2,
        body.dark-mode #login-screen .login-form-wrap h3 { color: #f8fafc !important; }
        body.dark-mode #login-screen .login-left-top p,
        body.dark-mode #login-screen .login-sub { color: #cbd5e1 !important; }
        body.dark-mode #login-screen .login-form-wrap label,
        body.dark-mode #login-screen .login-slogan { color: #dbeafe !important; }
        body.dark-mode #login-screen .form-control {
            background: #0b1220 !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        body.dark-mode #login-screen .form-control::placeholder { color: #94a3b8 !important; }
        body.dark-mode #login-screen .form-control:focus {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.28) !important;
        }
        body.dark-mode #login-screen #btn-login {
            background: linear-gradient(90deg, #3b82f6, #2563eb) !important;
            border-color: transparent !important;
            color: #ffffff !important;
        }
        body.dark-mode .login-slogan { color: #cbd5e1 !important; }
        body.dark-mode .theme-toggle { background: #1f2937; border-color: #334155; color: #e5e7eb; }
        body.dark-mode .theme-toggle-inline { background: #1f2937; border-color: #334155; color: #e5e7eb; }
        body.dark-mode #my-stats-content .stat-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%) !important;
            border-color: #334155 !important;
            box-shadow: none !important;
        }
        body.dark-mode #my-stats-content .stat-number { color: #93c5fd !important; }
        body.dark-mode #my-stats-content .stat-label { color: #cbd5e1 !important; }
        body.dark-mode #my-stats-content .my-chart-card {
            background: linear-gradient(145deg, #111827 0%, #0f172a 100%) !important;
            border-color: #334155 !important;
        }
        body.dark-mode #my-stats-content .my-chart-title { color: #e2e8f0 !important; }
        body.dark-mode #task-modal .modal-content {
            background: #0f172a !important;
            border: 1px solid #334155 !important;
        }
        body.dark-mode #task-modal #modal-display-title { color: #f8fafc !important; }
        body.dark-mode #task-modal #modal-display-desc { color: #cbd5e1 !important; }
        body.dark-mode #task-modal #modal-deadline {
            background: #3a2f15 !important;
            border: 1px solid #7c5c13 !important;
            color: #fde68a !important;
        }
        body.dark-mode #task-modal #modal-stats {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode #task-modal #modal-stats span,
        body.dark-mode #task-modal #modal-stats strong {
            color: #e5e7eb !important;
        }
        body.dark-mode #task-modal #book-approval-section,
        body.dark-mode #task-modal #book-task-actions {
            background: #111827 !important;
            border-color: #334155 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode #task-modal #book-task-status,
        body.dark-mode #task-modal #book-task-note {
            color: #cbd5e1 !important;
        }
        body.dark-mode #task-modal #completed-info {
            background: #14532d !important;
            border: 1px solid #166534 !important;
        }
        body.dark-mode #task-modal #completed-info p,
        body.dark-mode #task-modal #completed-score,
        body.dark-mode #task-modal #completed-time {
            color: #dcfce7 !important;
        }
        body.dark-mode [style*="background:#fff3cd"],
        body.dark-mode [style*="background: #fff3cd"] {
            background: #3a2f15 !important;
            border-color: #7c5c13 !important;
            color: #fde68a !important;
        }
        body.dark-mode [style*="background:#d4edda"],
        body.dark-mode [style*="background: #d4edda"] {
            background: #14532d !important;
            border-color: #166534 !important;
            color: #dcfce7 !important;
        }
        body.dark-mode [style*="background:#e3f2fd"],
        body.dark-mode [style*="background: #e3f2fd"] {
            background: #1e3a8a !important;
            border-color: #2563eb !important;
            color: #dbeafe !important;
        }
        body.dark-mode [style*="background:#f8fafc"],
        body.dark-mode [style*="background: #f8fafc"] {
            background: #111827 !important;
            border-color: #334155 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode [style*="color:#155724"],
        body.dark-mode [style*="color: #155724"] {
            color: #dcfce7 !important;
        }
        body.dark-mode .teacher-live-monitor-shell {
            border-color: #374151;
            background:
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.2), rgba(17,24,39,0) 35%),
                linear-gradient(140deg, #0f172a 0%, #111827 100%);
        }
        body.dark-mode .teacher-live-monitor-title { color: #dbeafe; }
        body.dark-mode .teacher-live-monitor-sub { color: #94a3b8; }
        body.dark-mode .teacher-live-metric,
        body.dark-mode .teacher-live-student-card {
            background: #111827;
            border-color: #334155;
            color: #e5e7eb;
            box-shadow: none;
        }
        body.dark-mode .teacher-live-metric .k { color: #94a3b8; }
        body.dark-mode .teacher-live-metric .v,
        body.dark-mode .teacher-live-student-name { color: #e5e7eb; }
        body.dark-mode .teacher-live-student-meta { color: #cbd5e1; }
        body.dark-mode .teacher-live-student-rank {
            background: #1d4ed8;
            color: #dbeafe;
        }
        body.dark-mode .live-quiz-sidebar {
            border-color: #334155;
            background: #0b1220;
        }
        body.dark-mode .live-quiz-sidebar-head .title { color: #dbeafe; }
        body.dark-mode .live-quiz-question-row {
            background: #111827;
            border-color: #334155;
            color: #e5e7eb;
        }
        body.dark-mode .live-quiz-question-row.active {
            background: #1e293b;
            border-color: #3b82f6;
        }
        body.dark-mode .live-quiz-canvas {
            border-color: #43326b;
        }
        body.dark-mode .live-quiz-editor-card {
            background: rgba(17,24,39,0.88);
            border-color: #334155;
        }
        body.dark-mode .live-quiz-right-panel {
            background: #111827;
            border-color: #334155;
        }
        body.dark-mode .live-quiz-right-title,
        body.dark-mode .live-quiz-right-block .label {
            color: #e5e7eb;
        }
        body.dark-mode .live-quiz-media-drop {
            background: rgba(15,23,42,0.75);
            border-color: #5b4a87;
        }
        body.dark-mode .live-quiz-media-preview {
            color: #cbd5e1;
        }
        body.dark-mode .live-player-shell {
            border-color: #334155;
            background:
                radial-gradient(circle at 85% 0%, rgba(96, 165, 250, 0.25), rgba(96, 165, 250, 0) 35%),
                linear-gradient(145deg, #0f172a 0%, #111827 100%);
        }
        body.dark-mode #live-player-title { color: #dbeafe !important; }
        body.dark-mode .live-player-question {
            border-color: #334155;
            background: linear-gradient(140deg, #0b1220 0%, #1e293b 58%, #1e40af 100%);
            color: #e5e7eb;
        }
        body.dark-mode .live-player-info {
            background: #0f172a;
            border-color: #334155;
            color: #cbd5e1;
        }
        body.dark-mode .live-player-option { color: #f8fafc !important; }
        body.dark-mode .live-match-board { background: #0f172a; border-color: #334155; }
        body.dark-mode .live-match-left-item { background: #1e293b; border-color: #334155; color: #dbeafe; }
        body.dark-mode .live-match-dropzone { background: #111827; border-color: #334155; color: #94a3b8; }
        body.dark-mode .live-match-dropzone.filled { background: #1e3a8a; border-color: #3b82f6; color: #e0ecff; }
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode label,
        body.dark-mode small,
        body.dark-mode .stat-label,
        body.dark-mode .stat-detail-label,
        body.dark-mode .home-overview-title,
        body.dark-mode .home-overview-meta,
        body.dark-mode .top-student-meta,
        body.dark-mode .lesson-meta-note,
        body.dark-mode .lesson-slide-mini-head,
        body.dark-mode .time-label {
            color: #cbd5e1 !important;
        }
        body.dark-mode .home-overview-value,
        body.dark-mode .stat-number,
        body.dark-mode .stat-detail-value,
        body.dark-mode .top-student-name,
        body.dark-mode .pie-summary-val {
            color: #e2e8f0 !important;
        }
        body.dark-mode .activity-fullbar,
        body.dark-mode .app-topbar,
        body.dark-mode .activity-left,
        body.dark-mode .activity-right,
        body.dark-mode .app-workspace,
        body.dark-mode .app-frame-area,
        body.dark-mode .content-left,
        body.dark-mode .content-right,
        body.dark-mode .content-tag,
        body.dark-mode .question-edit-item,
        body.dark-mode .edit-section,
        body.dark-mode .stat-detail-item,
        body.dark-mode .activity-history-item,
        body.dark-mode .completed-summary .item,
        body.dark-mode .lesson-panel,
        body.dark-mode .lesson-slide-mini,
        body.dark-mode .lesson-editor-main,
        body.dark-mode .lesson-toolbar,
        body.dark-mode .lesson-toolbar .btn,
        body.dark-mode .lesson-quick-tools .btn,
        body.dark-mode .pie-summary-item,
        body.dark-mode .time-widget {
            background: #111827 !important;
            color: #e5e7eb !important;
            border-color: #334155 !important;
        }
        body.dark-mode .time-block {
            background: #1e293b !important;
            border-color: #334155 !important;
        }
        body.dark-mode .time-val { color: #93c5fd !important; }
        body.dark-mode .time-label { color: #cbd5e1 !important; }
        body.dark-mode .lesson-builder-shell { background: linear-gradient(180deg, #0b1220 0%, #0f172a 100%) !important; }
        body.dark-mode .lesson-builder-topbar { background: #111827 !important; border-bottom-color: #1f2937 !important; }
        body.dark-mode .lesson-builder-brand,
        body.dark-mode .lesson-frame-title,
        body.dark-mode .lesson-side-title { color: #e5e7eb !important; }
        body.dark-mode .lesson-title-wrap .lesson-main-input,
        body.dark-mode .lesson-frame-item,
        body.dark-mode .lesson-side-block,
        body.dark-mode #slide-content-editor,
        body.dark-mode #lesson-slide-preview,
        body.dark-mode .lesson-content-block,
        body.dark-mode .lesson-editor-scroll {
            background: #0f172a !important;
            border-color: #334155 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode .lesson-frame-item:hover,
        body.dark-mode .lesson-frame-item.active {
            background: #1e293b !important;
            border-color: #60a5fa !important;
        }
        body.dark-mode .lesson-theme-item { background: #0f172a !important; border-color: #334155 !important; }
        body.dark-mode .lesson-theme-item.active { background: #1e293b !important; border-color: #60a5fa !important; }
        body.dark-mode .lesson-theme-name { color: #e2e8f0 !important; }
        body.dark-mode .lesson-q-option { border-color: #334155 !important; color: #e2e8f0 !important; background: #0f172a !important; }
        body.dark-mode .lesson-question-tag { background: rgba(30, 58, 138, .35); border-color: rgba(96, 165, 250, .45); color: #bfdbfe; }
        body.dark-mode .lesson-question-xp { background: rgba(22, 163, 74, .24); border-color: rgba(134, 239, 172, .45); color: #bbf7d0; }
        body.dark-mode .lesson-question-timer-head { color: #cbd5e1; }
        body.dark-mode .lesson-question-timer-track { background: rgba(15, 23, 42, .55); border-color: rgba(100, 116, 139, .55); }
        body.dark-mode .lesson-question-builder { border-top-color: #334155; }
        body.dark-mode .lesson-side-help { color: #94a3b8; }
        body.dark-mode .lesson-question-prompt { background: rgba(15,23,42,.35); border-color: rgba(148,163,184,.28); }
        body.dark-mode .lesson-q-option .opt-key { background: #1e3a8a; border-color: #3b82f6; color: #e0ecff; }
        body.dark-mode .lesson-q-option .opt-text { color: #e2e8f0; }
        body.dark-mode .kahoot-option { background: #0f172a !important; border-color: #334155 !important; color: #e2e8f0 !important; }
        body.dark-mode .kahoot-option .k-text { color: #e2e8f0 !important; }
        body.dark-mode .kahoot-option.is-selected { border-color: #60a5fa !important; box-shadow: 0 0 0 3px rgba(96,165,250,.22), 0 10px 24px rgba(96,165,250,.14) !important; }
        body.dark-mode .lesson-dd-bank,
        body.dark-mode .lesson-dd-targets,
        body.dark-mode .lesson-dd-drop { background: #0f172a !important; border-color: #334155 !important; color: #e2e8f0 !important; }
        body.dark-mode .lesson-dd-chip { background: #1e293b; border-color: #60a5fa; color: #dbeafe; }
        body.dark-mode .lesson-answer-status.is-correct { color: #bbf7d0; background: rgba(22, 163, 74, .22); border-color: rgba(134, 239, 172, .5); }
        body.dark-mode .lesson-answer-status.is-wrong { color: #fecaca; background: rgba(220, 38, 38, .22); border-color: rgba(252, 165, 165, .5); }
        body.dark-mode #lesson-player-nav,
        body.dark-mode #lesson-player-stage {
            background: #111827 !important;
            border-color: #374151 !important;
        }
        body.dark-mode #btn-lesson-prev.lesson-nav-btn {
            background: linear-gradient(135deg, #1f2937 0%, #334155 100%) !important;
            border-color: #475569 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode #btn-lesson-next.lesson-nav-btn {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%) !important;
        }
        body.dark-mode #btn-lesson-next.lesson-nav-btn.is-end {
            background: linear-gradient(135deg, #0284c7 0%, #16a34a 100%) !important;
        }
        body.dark-mode .lesson-nav-toggle-btn {
            background: #1e293b;
            border-color: #334155;
            color: #e2e8f0;
        }
        body.dark-mode .lesson-player-zoom-controls {
            background: rgba(15, 23, 42, 0.94);
            border-color: #334155;
        }
        body.dark-mode .lesson-zoom-btn {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }
        body.dark-mode .badge-success { background: #14532d !important; color: #dcfce7 !important; }
        body.dark-mode .badge-pending { background: #78350f !important; color: #fde68a !important; }
        body.dark-mode .badge-info,
        body.dark-mode .badge-progress { background: #1e3a8a !important; color: #dbeafe !important; }
        body.dark-mode .badge-danger { background: #7f1d1d !important; color: #fee2e2 !important; }
        body.dark-mode .badge-mid { background: #7c2d12 !important; color: #ffedd5 !important; }
        body.dark-mode [style*="color:#666"],
        body.dark-mode [style*="color: #666"],
        body.dark-mode [style*="color:#475569"],
        body.dark-mode [style*="color: #475569"],
        body.dark-mode [style*="color:#64748b"],
        body.dark-mode [style*="color: #64748b"],
        body.dark-mode [style*="color:#111827"],
        body.dark-mode [style*="color: #111827"],
        body.dark-mode [style*="color:#0f172a"],
        body.dark-mode [style*="color: #0f172a"] {
            color: #cbd5e1 !important;
        }
        body.dark-mode [style*="background:#eee"],
        body.dark-mode [style*="background: #eee"],
        body.dark-mode [style*="background:#f0f7ff"],
        body.dark-mode [style*="background: #f0f7ff"],
        body.dark-mode [style*="background:#e9f0ff"],
        body.dark-mode [style*="background: #e9f0ff"],
        body.dark-mode [style*="background:#f8f9fa"],
        body.dark-mode [style*="background: #f8f9fa"],
        body.dark-mode [style*="background:#fff"],
        body.dark-mode [style*="background: #fff"],
        body.dark-mode [style*="background:white"],
        body.dark-mode [style*="background: white"] {
            background: #1f2937 !important;
            border-color: #334155 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode #tasks-section,
        body.dark-mode #activities-section,
        body.dark-mode #quiz-section,
        body.dark-mode #block-homework-section,
        body.dark-mode #compute-homework-section,
        body.dark-mode #lessons-section,
        body.dark-mode #student-homework-shell,
        body.dark-mode #student-apps-shell,
        body.dark-mode #leaderboard-section,
        body.dark-mode #top-students-card,
        body.dark-mode #teacher-analytics {
            background: linear-gradient(160deg, #0f172a 0%, #111827 100%) !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 10px 26px rgba(2, 6, 23, 0.45) !important;
        }
        body.dark-mode #tasks-section h3,
        body.dark-mode #activities-section h3,
        body.dark-mode #quiz-section h3,
        body.dark-mode #block-homework-section h3,
        body.dark-mode #compute-homework-section h3,
        body.dark-mode #lessons-section h3,
        body.dark-mode .student-shell-head h3,
        body.dark-mode #leaderboard-section h3,
        body.dark-mode #top-students-card h4,
        body.dark-mode #teacher-analytics h4 {
            color: #e2e8f0 !important;
        }
        body.dark-mode .student-shell-head p {
            color: #94a3b8 !important;
        }
        body.dark-mode #tasks-section .tabs,
        body.dark-mode #activities-section .tabs,
        body.dark-mode #block-homework-section .tabs,
        body.dark-mode #compute-homework-section .tabs,
        body.dark-mode #lessons-section .tabs,
        body.dark-mode #teacher-filters,
        body.dark-mode #activity-filters,
        body.dark-mode #block-homework-filters,
        body.dark-mode #compute-homework-filters {
            background: rgba(15, 23, 42, 0.55) !important;
            border: 1px solid #334155 !important;
            border-radius: 12px;
            padding: 6px;
        }
        body.dark-mode #tasks-section .tab-content,
        body.dark-mode #activities-section .tab-content,
        body.dark-mode #block-homework-section .tab-content,
        body.dark-mode #compute-homework-section .tab-content,
        body.dark-mode #lessons-section .tab-content,
        body.dark-mode #leaderboard-list,
        body.dark-mode #quiz-list,
        body.dark-mode #top-students-list {
            background: transparent !important;
        }
        body.dark-mode #teacher-stats,
        body.dark-mode #activities-teacher-stats,
        body.dark-mode #block-homework-teacher-stats,
        body.dark-mode #compute-homework-teacher-stats,
        body.dark-mode #lessons-teacher-stats,
        body.dark-mode #class-chart-summary .pie-summary-item {
            background: rgba(30, 41, 59, 0.9) !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        body.dark-mode .teacher-app-stats {
            background: #0f1b33 !important;
            border: 1px solid #334155 !important;
        }
        body.dark-mode .teacher-app-stats-title {
            color: #e2e8f0 !important;
        }
        body.dark-mode .teacher-app-stats-tile,
        body.dark-mode .teacher-app-stats-btn-tile {
            background: #111827 !important;
            border-color: #334155 !important;
        }
        body.dark-mode .teacher-app-stats-tile > div:first-child {
            color: #94a3b8 !important;
        }
        body.dark-mode #teacher-block-homework-completed-students,
        body.dark-mode #teacher-compute-homework-completed-students {
            color: #93c5fd !important;
        }
        body.dark-mode #teacher-block-homework-avg-progress,
        body.dark-mode #teacher-compute-homework-avg-progress {
            color: #5eead4 !important;
        }
        body.dark-mode #teacher-block-homework-total-xp,
        body.dark-mode #teacher-compute-homework-total-xp {
            color: #fbbf24 !important;
        }
        body.dark-mode #top-students-list .top-student-row,
        body.dark-mode #leaderboard-list .top-student-row,
        body.dark-mode #quiz-list .list-item {
            background: rgba(30, 41, 59, 0.9) !important;
            border-color: #334155 !important;
            box-shadow: none !important;
        }
        body.dark-mode #teacher-analytics .teacher-type-panel,
        body.dark-mode #teacher-analytics .teacher-pie-panel {
            background: linear-gradient(160deg, #0f172a 0%, #111827 100%) !important;
            border-color: #334155 !important;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.08);
        }
        body.dark-mode #teacher-analytics .teacher-type-wrap,
        body.dark-mode #teacher-analytics .teacher-pie-wrap {
            background: rgba(30, 41, 59, 0.45) !important;
            border-radius: 12px;
        }
        body.dark-mode #teacher-analytics .teacher-type-title,
        body.dark-mode #teacher-analytics .teacher-pie-title,
        body.dark-mode #teacher-analytics .pie-summary-label {
            color: #cbd5e1 !important;
        }
        body.dark-mode #student-stats-bar .completed-card .stat-label,
        body.dark-mode #student-stats-bar .completed-summary .item .k,
        body.dark-mode #student-stats-bar .completed-summary .item .v,
        body.dark-mode #student-stats-bar .completed-summary .item.xp-item .k,
        body.dark-mode #student-stats-bar .completed-summary .item.xp-item .v {
            color: #ffffff !important;
        }
        body.dark-mode #student-stats-bar .completed-card .stat-label,
        body.dark-mode #student-stats-bar .completed-summary .item .k,
        body.dark-mode #student-stats-bar .completed-summary .item.xp-item .k {
            font-size: 115% !important;
        }
        body.dark-mode #student-stats-bar .completed-summary .item .v,
        body.dark-mode #student-stats-bar .completed-summary .item.xp-item .v {
            font-size: 115% !important;
        }
        body.dark-mode #app-screen.student-view #student-homework-shell,
        body.dark-mode #app-screen.student-view #student-apps-shell,
        body.dark-mode #app-screen.student-view #leaderboard-section,
        body.dark-mode #app-screen.student-view .student-spark-card,
        body.dark-mode #app-screen.student-view .student-quick-card,
        body.dark-mode #app-screen.student-view .student-mini-card,
        body.dark-mode #app-screen.student-view .status-split .tab-content {
            background: linear-gradient(180deg, #111827, #0f172a) !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 24px rgba(2, 6, 23, 0.34) !important;
        }
        body.dark-mode #app-screen.student-view #student-top-students-card {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.96), rgba(2, 6, 23, 0.98)) !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 24px rgba(2, 6, 23, 0.34) !important;
        }
        body.dark-mode #app-screen.student-view #student-top-students-card::before {
            background: radial-gradient(circle, rgba(59,130,246,0.18) 0%, rgba(59,130,246,0) 72%);
        }
        body.dark-mode #app-screen.student-view #student-top-students-card h4 {
            color: #e2e8f0 !important;
        }
        body.dark-mode #app-screen.student-view #student-top-students-list .top-student-row {
            background: #0f172a !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
            box-shadow: none !important;
        }
        body.dark-mode #app-screen.student-view #student-top-students-list .top-student-name {
            color: #e2e8f0 !important;
        }
        body.dark-mode #app-screen.student-view #student-top-students-list .top-student-meta {
            color: #94a3b8 !important;
        }
        body.dark-mode #app-screen.student-view #student-top-students-list .top-student-xp {
            background: #0b1220 !important;
            border-color: #334155 !important;
            color: #93c5fd !important;
        }
        body.dark-mode .badge-card {
            background: #0f172a;
            border-color: #334155;
        }
        body.dark-mode .badge-card .badge-icon {
            background: linear-gradient(135deg, #1e293b, #0b1220);
            color: #e2e8f0;
            box-shadow: 0 10px 20px rgba(2, 6, 23, 0.5);
        }
        body.dark-mode .badge-card .badge-name {
            color: #e2e8f0;
        }
        body.dark-mode .badge-card .badge-desc {
            color: #94a3b8;
        }
        body.dark-mode .badge-card .badge-progress-text {
            color: #94a3b8;
        }
        body.dark-mode .badge-card .badge-progress-track {
            background: linear-gradient(90deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.7));
        }
        body.dark-mode .badge-card .badge-progress-track span {
            background: linear-gradient(90deg, #22c55e, #38bdf8);
        }
        body.dark-mode .badge-card.earned {
            background: #052e21;
            border-color: #10b981;
        }
        body.dark-mode .badge-card.earned .badge-icon {
            background: #10b981;
            color: #052e21;
        }
        body.dark-mode #app-screen.student-view .student-combined-wrap .tabs {
            background: #0f1b33 !important;
            border-color: #334155 !important;
        }
        body.dark-mode #app-screen.student-view .student-combined-wrap .tab-btn {
            color: #cbd5e1 !important;
        }
        body.dark-mode #app-screen.student-view .student-combined-wrap .tab-btn.active {
            background: linear-gradient(135deg, #2563eb, #0ea5e9) !important;
            color: #ffffff !important;
            box-shadow: none !important;
        }
        body.dark-mode #app-screen.teacher-view #teacher-analytics #stats-content > .card,
        body.dark-mode #app-screen.teacher-view #top-students-card,
        body.dark-mode #app-screen.teacher-view #student-homework-shell,
        body.dark-mode #app-screen.teacher-view #block-homework-section {
            box-shadow: 0 14px 28px rgba(2, 6, 23, 0.36) !important;
        }
        body.dark-mode #app-screen.teacher-view .stat-number,
        body.dark-mode #app-screen.teacher-view h4,
        body.dark-mode #app-screen.teacher-view .teacher-app-stats-title,
        body.dark-mode #app-screen.teacher-view .top-student-name {
            color: #f8fafc !important;
        }
        body.dark-mode #app-screen.teacher-view .stat-label,
        body.dark-mode #app-screen.teacher-view .top-student-meta,
        body.dark-mode #app-screen.teacher-view .teacher-type-title,
        body.dark-mode #app-screen.teacher-view .teacher-pie-title {
            color: #cbd5e1 !important;
        }
        body.dark-mode #app-screen.teacher-view .top-student-xp {
            color: #93c5fd !important;
        }
        body.dark-mode #app-screen.teacher-view .btn.btn-primary {
            background: linear-gradient(180deg, #3b82f6, #2563eb) !important;
            color: #ffffff !important;
        }

        /* Mobil uyumluluk */
        img, canvas { max-width: 100%; height: auto; }
        .modal-content { width: 92vw; max-width: 500px; }
        .modal-large { max-width: 92vw; }
        #open-menu { top: 12px; left: 12px; }
        #side-menu { max-width: 80vw; }
        #side-menu button { font-size: 16px; }
        .student-list-item { flex-wrap: wrap; gap: 8px; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .stat-detail-grid { grid-template-columns: 1fr 1fr; }
          .chart-container { height: 180px; }
          #myTaskChart, #myActivityChart, #myBlockChart, #myComputeChart { width: 100% !important; max-width: 100% !important; height: 140px !important; display: block; }

        @media (max-width: 768px) {
            .container { width: 100%; max-width: 100%; margin: 0 auto; padding: 12px; overflow-x: hidden; }
            body { overflow-x: hidden !important; }
            #app-screen { width: 100%; max-width: 100%; overflow-x: hidden; }
            #app-screen.teacher-view #header-center-logo {
                display: none !important;
            }
            #open-menu {
                position: static !important;
                width: 42px;
                height: 42px;
                padding: 0 !important;
                border-radius: 14px !important;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 8px 0 0;
                flex: 0 0 42px;
            }
            #app-screen.student-view > .app-header,
            #app-screen.teacher-view > .app-header {
                padding-left: 14px !important;
            }
            .card { border-radius: 10px; padding: 12px; }
            .tabs { flex-direction: column; }
            .tab-btn { width: 100%; }
            #student-homework-tabs,
            #student-apps-tabs {
                flex-direction: row !important;
            }
            #student-homework-tabs .tab-btn,
            #student-apps-tabs .tab-btn {
                width: auto !important;
                flex: 1 1 0;
            }
            .filter-bar { flex-direction: column; }
            .filter-btn { width: 100%; }
            .sidebar button { font-size: 16px; }
            .app-header { gap: 10px; flex-wrap: wrap; }
            #header-center-logo { display: none !important; }
            .time-widget {
                width: 100%;
                justify-content: center;
                gap: 4px;
                padding: 4px 6px;
            }
            .time-block { padding: 1px 5px; }
            .time-val { font-size: 0.78rem; font-weight: 500; }
            .time-label { font-size: 0.64rem; font-weight: 400; }
            .login-card { width: 86vw; }
            .login-logo { width: 105px; }
            #students-modal .student-actions { margin-left: auto; width: auto; }
            
            .content-right-pane { min-width: 0; }
            #student-stats-bar { gap: 6px; }
            .teacher-top-wrap { grid-template-columns: 1fr; }
            .home-overview-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .lesson-builder-topbar { grid-template-columns: 1fr; }
            .lesson-builder-main { grid-template-columns: 1fr; }
            .lesson-quick-tools { grid-template-columns: 1fr; }
            #lesson-slide-preview { min-height: 220px !important; }
            .lesson-player-shell {
                width: 100vw !important;
                height: 100vh !important;
                border-radius: 0 !important;
                padding: 8px !important;
            }
            .lesson-player-grid {
                grid-template-columns: 1fr;
                grid-template-rows: 180px 1fr;
            }
            #lesson-player-nav { max-height: 34vh; }
            .lesson-player-footer { align-items: stretch; }
            .lesson-player-actions { width: 100%; }
            .lesson-nav-btn { flex: 1; }
            .lesson-player-zoom-controls {
                left: 8px;
                bottom: 8px;
            }
            #tasks-section,
            #activities-section,
            #quiz-section,
            #block-homework-section,
            #compute-homework-section,
            #lessons-section,
            #student-homework-shell,
            #student-apps-shell,
            #teacher-analytics,
            #leaderboard-section,
            #top-students-card {
                height: auto;
            }
            #app-screen.student-view > #student-homework-shell,
            #app-screen.student-view > #student-apps-shell,
            #app-screen.student-view > #leaderboard-section {
                height: auto;
                min-height: 0;
                overflow: visible;
            }
            #app-screen.student-view #student-homework-combined .tab-content,
            #app-screen.student-view #student-apps-combined .tab-content,
            #app-screen.student-view #leaderboard-list {
                overflow: auto !important;
            }
            #student-stats-bar .stats-grid { grid-template-columns: 1fr; }
            .completed-summary { display: flex; flex-wrap: wrap; gap: 6px; }
            .completed-summary .item { flex: 1 1 calc(50% - 6px); min-width: 110px; }
            #my-stats-content .my-stats-charts { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
            #my-stats-content .stats-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            #teacher-stats .teacher-app-stats-grid,
            #activities-teacher-stats .teacher-app-stats-grid,
            #lessons-teacher-stats .teacher-app-stats-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                justify-content: stretch;
                gap: 6px;
            }
            #teacher-stats .teacher-app-stats-tile,
            #activities-teacher-stats .teacher-app-stats-tile,
            #lessons-teacher-stats .teacher-app-stats-tile {
                min-width: 0;
                padding: 6px 4px;
            }
            #teacher-stats .teacher-app-stats-tile > div:first-child,
            #activities-teacher-stats .teacher-app-stats-tile > div:first-child,
            #lessons-teacher-stats .teacher-app-stats-tile > div:first-child {
                font-size: 10px !important;
                line-height: 1.15;
            }
            #teacher-stats .teacher-app-stats-tile > div:last-child,
            #activities-teacher-stats .teacher-app-stats-tile > div:last-child,
            #lessons-teacher-stats .teacher-app-stats-tile > div:last-child {
                font-size: 14px !important;
                line-height: 1.1;
            }
            /* Mobilde Ödev/Etkinlik/Ders kutuları sekme çizgisine yaklaşmasın */
            #app-screen.teacher-view #tasks-section #teacher-stats,
            #app-screen.teacher-view #activities-section #activities-teacher-stats,
            #app-screen.teacher-view #lessons-section #lessons-teacher-stats {
                margin-top: 10px !important;
            }

            /* Mobil/ogretmen: kart yuksekligi dengeli, liste satirlari tek satir */
            #app-screen.teacher-view #block-homework-assign-tabs {
                gap: 4px;
                margin-bottom: 10px;
            }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn {
                flex: 0 0 auto;
                min-height: 38px;
                padding: 8px 10px;
                font-size: 0.96rem;
                line-height: 1.2;
            }
            #app-screen.teacher-view #block-homework-section #block-homework-split,
            #app-screen.teacher-view #block-homework-section #compute-homework-split {
                display: block;
                min-height: 0;
            }
            #app-screen.teacher-view #block-homework-section #block-homework-pending,
            #app-screen.teacher-view #block-homework-section #block-homework-completed,
            #app-screen.teacher-view #block-homework-section #compute-homework-pending,
            #app-screen.teacher-view #block-homework-section #compute-homework-completed {
                min-height: 0;
            }
            #app-screen.teacher-view #block-homework-section .teacher-app-stats-title {
                font-size: 11px;
            }
            #app-screen.teacher-view #block-homework-section .teacher-app-stats-tile > div:first-child {
                font-size: 10px !important;
            }
            #app-screen.teacher-view #block-homework-section .teacher-app-stats-tile > div:last-child {
                font-size: 16px !important;
            }
            #app-screen.teacher-view #block-homework-section .list-item {
                font-size: 0.88rem;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: space-between;
                flex-wrap: nowrap;
                gap: 12px;
                padding: 12px 12px;
                min-height: 82px;
                margin-bottom: 10px;
            }
            #app-screen.teacher-view #block-homework-section .list-item > div:first-child {
                flex: 1 1 auto;
                min-width: 0;
                overflow: hidden;
            }
            #app-screen.teacher-view #block-homework-section .list-item > div:first-child > div {
                flex-wrap: nowrap !important;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #app-screen.teacher-view #block-homework-section .list-item > div:first-child > small {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #app-screen.teacher-view #block-homework-section .list-item .badge {
                white-space: nowrap;
                font-size: 0.86rem !important;
                padding: 6px 10px !important;
            }
            #app-screen.teacher-view #tasks-section .list-item,
            #app-screen.teacher-view #activities-section .list-item,
            #app-screen.teacher-view #lessons-section .list-item {
                font-size: 0.88rem;
                flex-direction: row !important;
                align-items: center !important;
                justify-content: space-between;
                flex-wrap: nowrap;
                gap: 8px;
            }
            #app-screen.teacher-view #tasks-section .list-item > div:first-child,
            #app-screen.teacher-view #activities-section .list-item > div:first-child,
            #app-screen.teacher-view #lessons-section .list-item > div:first-child {
                flex: 1 1 auto;
                min-width: 0;
                overflow: hidden;
            }
            #app-screen.teacher-view #tasks-section .list-item > div:first-child > div,
            #app-screen.teacher-view #activities-section .list-item > div:first-child > div,
            #app-screen.teacher-view #lessons-section .list-item > div:first-child > div {
                flex-wrap: nowrap !important;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #app-screen.teacher-view #tasks-section .list-item > div:first-child > small,
            #app-screen.teacher-view #activities-section .list-item > div:first-child > small,
            #app-screen.teacher-view #lessons-section .list-item > div:first-child > small {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #app-screen.teacher-view #tasks-section .list-item .badge,
            #app-screen.teacher-view #activities-section .list-item .badge,
            #app-screen.teacher-view #lessons-section .list-item .badge {
                white-space: nowrap;
                font-size: 0.86rem !important;
                padding: 6px 10px !important;
            }

            /* Mobil/ogretmen: odevler-etkinlikler-dersler secenekleri tek satir */
            #app-screen.teacher-view #teacher-home-tabs,
            #app-screen.teacher-view #block-homework-assign-tabs,
            #app-screen.teacher-view #student-tabs,
            #app-screen.teacher-view #activities-tabs,
            #app-screen.teacher-view #lessons-tabs {
                flex-direction: row !important;
                gap: 6px;
                overflow-x: auto;
                overflow-y: hidden;
                flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
            }
            #app-screen.teacher-view #teacher-home-tabs .tab-btn,
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn,
            #app-screen.teacher-view #student-tabs .tab-btn,
            #app-screen.teacher-view #activities-tabs .tab-btn,
            #app-screen.teacher-view #lessons-tabs .tab-btn {
                width: auto !important;
                flex: 1 1 0;
                min-width: 0;
                min-height: 38px;
                padding: 8px 10px;
                font-size: 0.88rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            /* Kodlama sekmeleri mobilde kisaltilmis etiketlerle gosterilir */
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn {
                font-size: 0;
            }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn::after {
                font-size: 0.86rem;
                font-weight: 700;
                line-height: 1.1;
            }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="block2d"]::after { content: "Blok"; }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="block3d"]::after { content: "3DBlok"; }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="silentteacher"]::after { content: "Python"; }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="lightbot"]::after { content: "RobotCode"; }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="computeit"]::after { content: "Comp.it"; }

            /* Mobilde kart/liste sabit yukseklige kilitlenmesin, icerige gore uzasin */
            #app-screen.teacher-view #student-homework-shell,
            #app-screen.teacher-view #block-homework-section {
                height: auto !important;
                min-height: 0 !important;
                max-height: none !important;
                overflow: visible !important;
            }
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card .tab-content.active,
            #app-screen.teacher-view #block-homework-section #block-homework-pending,
            #app-screen.teacher-view #block-homework-section #compute-homework-pending {
                min-height: 0 !important;
                max-height: none !important;
                height: auto !important;
                overflow: visible !important;
            }
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card .tab-content.active > ul,
            #app-screen.teacher-view #block-homework-section #block-homework-pending > ul,
            #app-screen.teacher-view #block-homework-section #compute-homework-pending > ul {
                min-height: 0;
                overflow: visible !important;
            }
        }

        /* Öğretmen ana sayfa: üstte 2 kolon, altta 3 kolon */
        @media (min-width: 1024px) {
            #app-screen.teacher-view {
                grid-template-columns: repeat(10, minmax(0, 1fr));
                gap: 12px;
                align-items: stretch;
            }
            #app-screen.teacher-view > .app-header {
                grid-column: 1 / -1;
            }
            #app-screen.teacher-view #teacher-analytics {
                grid-column: 1 / -1;
                margin-bottom: 0;
            }
            #app-screen.teacher-view #top-students-card {
                grid-column: 1 / -1;
                height: auto;
                min-height: 0;
                margin-bottom: 0;
                order: 99;
            }
            #app-screen.teacher-view #tasks-section,
            #app-screen.teacher-view #activities-section,
            #app-screen.teacher-view #quiz-section,
            #app-screen.teacher-view #block-homework-section,
            #app-screen.teacher-view #lessons-section {
                grid-column: span 1;
                height: auto;
                min-height: 0;
            }
            #app-screen.teacher-view #student-homework-shell {
                grid-column: 1 / 6;
                height: auto;
                min-height: 0;
                max-height: none;
                width: 100%;
                align-self: stretch;
            }
            #app-screen.teacher-view #block-homework-section {
                grid-column: 6 / 11;
                height: auto;
                min-height: 0;
                max-height: none;
                width: 100%;
                align-self: stretch;
            }
            /* Öğretmen ana sayfası kart sırası: Quiz ve Dersler yer değiştirildi */
            #app-screen.teacher-view #tasks-section { order: 1; }
            #app-screen.teacher-view #activities-section { order: 2; }
            #app-screen.teacher-view #lessons-section { order: 3; }
            #app-screen.teacher-view #block-homework-section { order: 4; }
            #app-screen.teacher-view #quiz-section { order: 5; }
            #app-screen.teacher-view #student-homework-shell {
                display: flex;
                flex-direction: column;
                min-height: 0;
                overflow: hidden;
            }
            #app-screen.teacher-view #student-apps-shell { display: contents; }
            #app-screen.teacher-view .student-shell-head {
                display: none;
            }
            #app-screen.teacher-view #teacher-home-sections-host {
                display: block;
                flex: 0 0 auto;
                min-height: 0;
                margin-top: 0 !important;
            }
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card {
                display: flex;
                flex-direction: column;
                flex: 0 0 auto;
                min-height: 0;
                height: auto !important;
            }
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card .tab-content,
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card #quiz-list,
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card #quiz-list-pending,
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card #quiz-list-completed {
                flex: 1;
                min-height: 0;
                overflow: auto;
            }
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card .tab-content.active {
                display: flex;
                flex-direction: column;
                min-height: 0;
            }
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card .tab-content.active > ul {
                flex: 1;
                min-height: 0;
                overflow: auto;
            }
            #app-screen.teacher-view #block-homework-section {
                display: flex;
                flex-direction: column;
                min-height: 0;
                overflow: hidden;
            }
            #app-screen.teacher-view #block-homework-title {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #app-screen.teacher-view #block-homework-teacher-stats,
            #app-screen.teacher-view #compute-homework-teacher-stats {
                min-height: 72px;
            }
            #app-screen.teacher-view #block-homework-teacher-stats > div:first-child,
            #app-screen.teacher-view #compute-homework-teacher-stats > div:first-child {
                min-height: 18px;
                line-height: 18px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #app-screen.teacher-view #compute-homework-section {
                display: flex;
                flex-direction: column;
                flex: 1;
                min-height: 0;
            }
            #app-screen.teacher-view #block-homework-split-head,
            #app-screen.teacher-view #compute-homework-split-head {
                min-height: 34px;
                margin-top: 0;
                margin-bottom: 4px;
            }
            #app-screen.teacher-view #block-homework-section #block-homework-split,
            #app-screen.teacher-view #block-homework-section #compute-homework-split {
                flex: 1;
                min-height: 0;
            }
            #app-screen.teacher-view #block-homework-section #block-homework-pending,
            #app-screen.teacher-view #block-homework-section #block-homework-completed,
            #app-screen.teacher-view #block-homework-section #compute-homework-pending,
            #app-screen.teacher-view #block-homework-section #compute-homework-completed {
                height: 100%;
                min-height: 0;
                overflow: auto;
            }
            #app-screen.teacher-view #block-homework-section .status-split {
                display: block;
            }
            #app-screen.teacher-view #block-homework-section .status-split-head {
                display: none;
            }
            #app-screen.teacher-view #block-homework-section .status-split .tab-content {
                display: none !important;
            }
            #app-screen.teacher-view #block-homework-section .status-split .tab-content.active {
                display: flex !important;
                flex-direction: column;
            }
            /* Uygulamalarım sekme kapsayıcı kenarlıklarını kaldır */
            #app-screen.teacher-view #block-homework-assign-tabs,
            #app-screen.teacher-view #block-homework-tabs,
            #app-screen.teacher-view #compute-homework-tabs {
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
            }
            /* Uygulamalarım sekmesine soldaki gibi alt ayırıcı çizgi */
            #app-screen.teacher-view #block-homework-assign-tabs {
                border-bottom: 2px solid #dbe3ef !important;
            }
            /* Compute It panelindeki iç çerçeveyi kaldır */
            #app-screen.teacher-view #block-homework-section #compute-homework-split,
            #app-screen.teacher-view #block-homework-section #compute-homework-pending,
            #app-screen.teacher-view #block-homework-section #compute-homework-completed {
                border: none !important;
                outline: none !important;
                box-shadow: none !important;
                background: transparent !important;
            }
            /* Sol ve sağ ana kart alt çizgileri masaüstünde birebir aynı hizaya gelsin */
            #app-screen.teacher-view #student-homework-shell,
            #app-screen.teacher-view #block-homework-section {
                height: clamp(560px, 66vh, 780px) !important;
                min-height: clamp(560px, 66vh, 780px) !important;
            }
            /* Sağ/sol panel hizası tamamen aynı kalsın */
            #app-screen.teacher-view #student-homework-shell,
            #app-screen.teacher-view #block-homework-section {
                display: flex !important;
                flex-direction: column !important;
                gap: 12px !important;
                padding: 14px !important;
            }
            #app-screen.teacher-view #teacher-home-tabs,
            #app-screen.teacher-view #block-homework-assign-tabs {
                display: flex !important;
                margin: 0 0 12px 0 !important;
                padding: 0 !important;
                height: 44px !important;
                min-height: 44px !important;
                align-items: stretch !important;
                gap: 10px !important;
            }
            #app-screen.teacher-view #teacher-home-tabs .tab-btn,
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                height: 44px !important;
                min-height: 44px !important;
                padding: 0 12px !important;
                line-height: 1 !important;
                margin: 0 !important;
                box-sizing: border-box !important;
            }
            /* Sol sekme satırını sağ panelle aynı düşeye getir */
            #app-screen.teacher-view #teacher-home-tabs {
                margin-top: 12px !important;
            }
            #app-screen.teacher-view #tasks-section #teacher-stats,
            #app-screen.teacher-view #activities-section #activities-teacher-stats,
            #app-screen.teacher-view #lessons-section #lessons-teacher-stats {
                margin-top: 0 !important;
            }
            #app-screen.teacher-view #block-homework-teacher-stats,
            #app-screen.teacher-view #compute-homework-teacher-stats {
                margin-top: 12px !important;
            }
            /* Sağ panel sekme/istatistik başlangıcı soldakiyle aynı hizaya gelsin */
            #app-screen.teacher-view #block-homework-teacher-stats,
            #app-screen.teacher-view #compute-homework-teacher-stats {
                margin-top: 0 !important;
            }
            #app-screen.teacher-view #teacher-home-sections-host,
            #app-screen.teacher-view #compute-homework-section {
                flex: 1 1 auto !important;
                min-height: 0 !important;
            }
            /* Compute It iç alandaki kalan çerçeveyi tamamen kaldır */
            #app-screen.teacher-view #compute-homework-section,
            #app-screen.teacher-view #compute-homework-split,
            #app-screen.teacher-view #compute-homework-pending,
            #app-screen.teacher-view #compute-homework-completed,
            #app-screen.teacher-view #compute-homework-pending.tab-content.active,
            #app-screen.teacher-view #compute-homework-completed.tab-content.active {
                border: none !important;
                outline: none !important;
                box-shadow: none !important;
                background: transparent !important;
            }
            #teacher-analytics .stats-summary-grid {
                grid-template-columns: repeat(5, minmax(82px, 1fr)) !important;
                gap: 8px !important;
            }
            #teacher-analytics .stats-summary-grid .stat-card {
                padding: 8px;
            }
            #teacher-analytics .stats-summary-grid .stat-number {
                font-size: 1.32rem;
            }
            #teacher-analytics .stats-summary-grid .stat-label {
                font-size: 0.84rem;
            }
            #teacher-analytics .teacher-main-chart {
                height: 246px !important;
                min-height: 246px !important;
            }

            #app-screen.student-view {
                grid-template-columns: minmax(0, 1.25fr) minmax(0, 1.25fr) minmax(220px, 0.75fr);
                gap: 12px;
            }
            #app-screen.student-view > .app-header,
            #app-screen.student-view > #home-overview-strip,
            #app-screen.student-view > #student-stats-bar {
                grid-column: 1 / -1;
            }
            #app-screen.student-view > #student-homework-shell {
                grid-column: span 1;
                order: 1;
                height: 520px;
                min-height: 520px;
            }
            #app-screen.student-view > #student-apps-shell {
                grid-column: span 1;
                order: 2;
                height: 520px;
                min-height: 520px;
            }
            #app-screen.student-view > #leaderboard-section {
                grid-column: span 1;
                order: 3;
                height: 520px;
                min-height: 520px;
                justify-self: end;
                width: 100%;
            }
            #app-screen.student-view > .card {
                overflow: hidden;
            }
            #app-screen.student-view #student-homework-shell .tab-content,
            #app-screen.student-view #student-apps-shell .tab-content,
            #app-screen.student-view #leaderboard-list,
            #app-screen.student-view #quiz-list,
            #app-screen.student-view #top-students-list {
                overflow: hidden !important;
            }
        }

        @media (min-width: 1400px) {
            #app-screen.student-view {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            #app-screen.student-view > #student-homework-shell,
            #app-screen.student-view > #student-apps-shell {
                width: 100%;
                justify-self: stretch;
            }
            #app-screen.teacher-view #teacher-analytics {
                grid-column: 1 / 8;
            }
            #app-screen.teacher-view #top-students-card {
                grid-column: 8 / 11;
                order: 0;
            }
        }

        @media (min-width: 900px) and (max-width: 1023px) {
            #app-screen.teacher-view #student-homework-shell,
            #app-screen.teacher-view #block-homework-section {
                min-height: 0;
                max-height: none;
                height: auto;
                align-self: stretch;
            }
        }

        @media (min-width: 769px) and (max-width: 899px) {
            #app-screen.teacher-view #student-homework-shell,
            #app-screen.teacher-view #block-homework-section {
                min-height: 0;
                max-height: none;
                height: auto;
                align-self: stretch;
            }
        }

        @media (min-width: 769px) and (max-width: 900px) {
            #app-screen.teacher-view #teacher-home-tabs {
                gap: 2px;
                margin-bottom: 0;
            }
            #app-screen.teacher-view #block-homework-assign-tabs {
                gap: 2px;
                margin-bottom: 8px;
            }
            #app-screen.teacher-view #teacher-home-tabs .tab-btn {
                min-width: 0;
                min-height: 34px;
                padding: 6px 4px;
                font-size: 0.78rem;
                line-height: 1;
                letter-spacing: 0;
                white-space: nowrap;
            }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn {
                min-width: 0;
                min-height: 34px;
                padding: 6px 4px;
                font-size: 0;
                letter-spacing: 0;
            }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn::after {
                font-size: 0.78rem;
                font-weight: 700;
                line-height: 1;
                white-space: nowrap;
            }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="block2d"]::after { content: "Blok"; }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="block3d"]::after { content: "3DBlok"; }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="silentteacher"]::after { content: "Python"; }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="lightbot"]::after { content: "RobotCode"; }
            #app-screen.teacher-view #block-homework-assign-tabs .tab-btn[data-assign-type="computeit"]::after { content: "Comp.it"; }
        }

        @media (min-width: 900px) {
            #app-screen.teacher-view {
                --teacher-row-height: 78px;
            }
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card .tab-content.active,
            #app-screen.teacher-view #block-homework-section .status-split .tab-content.active {
                min-height: 0 !important;
                max-height: none !important;
                height: auto !important;
                flex: 1 1 auto !important;
                overflow: auto !important;
            }
            #app-screen.teacher-view #teacher-home-sections-host .embedded-home-card .tab-content.active > .empty-state,
            #app-screen.teacher-view #block-homework-section .status-split .tab-content.active > .empty-state {
                min-height: 100%;
                max-height: none;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
        }
        

        @media (max-width: 480px) {
            .container { padding: 12px; }
            .form-control { font-size: 0.9rem; padding: 8px; }
            .btn { padding: 7px 9px; font-size: 0.85rem; }
            .list-item { flex-direction: column; align-items: flex-start; }
            #app-screen.teacher-view #tasks-section .list-item,
            #app-screen.teacher-view #activities-section .list-item,
            #app-screen.teacher-view #lessons-section .list-item,
            #app-screen.teacher-view #block-homework-section .list-item {
                flex-direction: row !important;
                align-items: center !important;
            }
            #app-screen.student-view #tasks-section .list-item,
            #app-screen.student-view #activities-section .list-item,
            #app-screen.student-view #lessons-section .list-item,
            #app-screen.student-view #block-homework-section .list-item,
            #app-screen.student-view #compute-homework-section .list-item,
            #app-screen.student-view #student-homework-shell .list-item,
            #app-screen.student-view #student-apps-shell .list-item {
                flex-direction: row !important;
                align-items: center !important;
                justify-content: space-between !important;
                flex-wrap: nowrap !important;
                gap: 8px;
            }
            #app-screen.student-view #tasks-section .list-item > div:first-child,
            #app-screen.student-view #activities-section .list-item > div:first-child,
            #app-screen.student-view #lessons-section .list-item > div:first-child,
            #app-screen.student-view #block-homework-section .list-item > div:first-child,
            #app-screen.student-view #compute-homework-section .list-item > div:first-child,
            #app-screen.student-view #student-homework-shell .list-item > div:first-child,
            #app-screen.student-view #student-apps-shell .list-item > div:first-child {
                flex: 1 1 auto;
                min-width: 0;
                overflow: hidden;
            }
            #app-screen.student-view #tasks-section .list-item > div:first-child > div,
            #app-screen.student-view #activities-section .list-item > div:first-child > div,
            #app-screen.student-view #lessons-section .list-item > div:first-child > div,
            #app-screen.student-view #block-homework-section .list-item > div:first-child > div,
            #app-screen.student-view #compute-homework-section .list-item > div:first-child > div,
            #app-screen.student-view #student-homework-shell .list-item > div:first-child > div,
            #app-screen.student-view #student-apps-shell .list-item > div:first-child > div,
            #app-screen.student-view #tasks-section .list-item > div:first-child > small,
            #app-screen.student-view #activities-section .list-item > div:first-child > small,
            #app-screen.student-view #lessons-section .list-item > div:first-child > small,
            #app-screen.student-view #block-homework-section .list-item > div:first-child > small,
            #app-screen.student-view #compute-homework-section .list-item > div:first-child > small,
            #app-screen.student-view #student-homework-shell .list-item > div:first-child > small,
            #app-screen.student-view #student-apps-shell .list-item > div:first-child > small {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #app-screen.student-view #tasks-section .list-item > div:last-child,
            #app-screen.student-view #activities-section .list-item > div:last-child,
            #app-screen.student-view #lessons-section .list-item > div:last-child,
            #app-screen.student-view #block-homework-section .list-item > div:last-child,
            #app-screen.student-view #compute-homework-section .list-item > div:last-child,
            #app-screen.student-view #student-homework-shell .list-item > div:last-child,
            #app-screen.student-view #student-apps-shell .list-item > div:last-child {
                white-space: nowrap;
                display: flex;
                align-items: center;
                gap: 8px;
                flex: 0 0 auto;
            }
            .student-list-item { flex-direction: column; align-items: flex-start; }
            .stats-grid { grid-template-columns: 1fr; }
            .home-overview-strip { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
            .home-overview-card { width: auto; }
            .home-overview-card:last-child { grid-column: 1 / -1 !important; }
            .student-hero-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .student-hero-stat:last-child { grid-column: auto; }
            .stat-detail-grid { grid-template-columns: 1fr; }
            .chart-container { height: 170px; }
            .completed-summary .item { flex: 1 1 calc(50% - 6px); min-width: 96px; }
            #my-stats-content .my-stats-charts { grid-template-columns: 1fr !important; }
            #my-stats-content .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .login-screen { padding: 0; }
            .login-card { width: 100%; min-height: 100svh; border-radius: 0; }
            .login-layout { grid-template-columns: 1fr; min-height: auto; }
            .login-left {
                padding: 20px 16px 12px;
                gap: 12px;
                border-radius: 0;
            }
            .login-left::before { width: 220px; height: 220px; top: -80px; left: -70px; filter: blur(32px); }
            .login-left::after { width: 190px; height: 190px; right: -70px; bottom: -80px; filter: blur(32px); }
            .login-left-top h2 { font-size: 1.45rem; }
            .login-left-top p { font-size: 0.88rem; margin-top: 8px; }
            .login-hero-logo { max-width: 260px; margin-top: 2px; }
            .login-slogan { font-size: 0.84rem; margin-top: 2px; }
            .login-right {
                padding: 14px 14px 18px;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                justify-content: flex-start;
            }
            .theme-toggle {
                position: static;
                align-self: flex-end;
                margin: 0 6px 10px 0;
                z-index: 3;
            }
            .login-form-wrap { max-width: 100%; gap: 10px; padding: 18px 14px; border-radius: 16px; }
            .login-form-wrap h3 { font-size: 1.3rem; }
            .login-form-wrap .login-sub { font-size: 0.88rem; margin-bottom: 6px; }
            #login-screen .form-control, #btn-login { height: 46px; }
            #login-screen .btn { width: 100%; }
            .login-scene { display: block !important; }
        }
        @media (max-width: 360px) {
            .login-left-top h2 { font-size: 1.25rem; }
            .login-hero-logo { max-width: 150px; }
            .login-slogan { font-size: 0.8rem; }
            .login-form-wrap h3 { font-size: 1.16rem; }
        }
        #login-mini-game-modal .login-mini-game-content {
            width: min(960px, 94vw) !important;
            max-width: 94vw !important;
        }
        #login-mini-game-canvas {
            width: 100% !important;
            max-height: 56vh !important;
        }
        @media (max-width: 768px) {
            #app-screen.teacher-view #home-overview-strip {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                grid-auto-flow: row dense;
            }
            #app-screen.teacher-view #home-overview-strip .home-overview-card {
                grid-column: auto !important;
            }
            #app-screen.teacher-view #home-overview-strip .home-overview-card:nth-last-child(1):nth-child(odd) {
                grid-column: 1 / -1 !important;
            }
        }
        @media (max-width: 1200px) {
            .stat-detail-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
        @media (max-width: 720px) {
            .stat-detail-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        .apps-hub-modal-content {
            width: min(1400px, 96vw);
            max-width: none;
            max-height: 92vh;
            overflow: auto;
            border-radius: 20px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
        }
        .apps-hub-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 14px;
        }
        .apps-hub-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }
        @media (max-width: 1360px) {
            .apps-hub-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
        @media (max-width: 980px) {
            .apps-hub-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 620px) {
            .apps-hub-grid {
                grid-template-columns: 1fr;
            }
        }
        .apps-hub-card {
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 18px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-height: 330px;
        }
        .apps-hub-card-image {
            width: 100%;
            max-height: 140px;
            aspect-ratio: 16 / 9;
            object-fit: contain;
            border-radius: 14px;
            background: #f1f5f9;
            margin-bottom: 10px;
        }
        .apps-hub-card h4 {
            margin: 2px 0 8px;
            font-size: 26px;
            line-height: 1.1;
            color: #111827;
        }
        .apps-hub-card p {
            margin: 0 0 14px;
            color: #6b7280;
        }
        .apps-hub-start-btn {
            width: 100%;
            margin-top: auto;
            border-radius: 12px;
        }
        /* Student panel release polish */
        #app-screen.student-view {
            align-items: start;
        }
        #app-screen.student-view > .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 18px;
            margin-bottom: 0;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.84);
            border: 1px solid rgba(219, 234, 254, 0.96);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(14px);
            position: relative;
        }
        #app-screen.student-view #student-total-time {
            justify-self: start;
            align-self: center;
        }
        #app-screen.student-view #open-menu {
            justify-self: start;
            align-self: center;
            display: inline-flex !important;
            position: static !important;
            margin: 0;
        }
        #app-screen.student-view #theme-toggle-app,
        #app-screen.student-view #user-menu-trigger {
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        #app-screen.student-view #theme-toggle-app {
            width: 46px;
            height: 46px;
            padding: 0;
        }
        #app-screen.student-view #user-menu {
            align-items: center;
            gap: 10px;
            justify-self: end;
            margin-left: auto;
        }
        #app-screen.student-view #theme-toggle-app { order: 1; }
        #app-screen.student-view #user-header-avatar { order: 2; }
        #app-screen.student-view #user-menu-trigger { order: 3; }
        #app-screen.student-view #user-menu-trigger {
            padding: 10px 18px;
            text-align: center;
            white-space: nowrap;
        }
        #app-screen.student-view #student-hero-panel,
        #app-screen.student-view .student-hero-main,
        #app-screen.student-view .student-spark-card,
        #app-screen.student-view .student-quick-card,
        #app-screen.student-view .student-mini-card,
        #app-screen.student-view .student-shell-head,
        #app-screen.student-view #leaderboard-section {
            text-align: center;
        }
        #app-screen.student-view .student-hero-main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100%;
        }
        #app-screen.student-view .student-hero-message,
        #app-screen.student-view .student-hero-progress-note,
        #app-screen.student-view .student-shell-head p {
            margin-left: auto;
            margin-right: auto;
        }
        #app-screen.student-view .student-hero-stats,
        #app-screen.student-view .student-mini-grid,
        #app-screen.student-view .student-quick-grid {
            align-items: stretch;
        }
        #app-screen.student-view .student-hero-stat,
        #app-screen.student-view .student-mini-card,
        #app-screen.student-view .student-quick-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        #app-screen.student-view .student-hero-progress {
            width: 100%;
            max-width: 680px;
        }
        #app-screen.student-view .student-hero-progress-head {
            justify-content: center;
            text-align: center;
        }
        #app-screen.student-view .student-hero-progress-head span,
        #app-screen.student-view .student-hero-progress-head strong {
            flex: 0 0 auto;
        }
        #app-screen.student-view .student-rank-pill {
            justify-content: center;
        }
        #app-screen.student-view #student-homework-shell,
        #app-screen.student-view #student-apps-shell,
        #app-screen.student-view #leaderboard-section {
            height: auto !important;
            min-height: clamp(360px, 42vh, 520px) !important;
            overflow: hidden;
        }
        #app-screen.student-view #student-homework-shell,
        #app-screen.student-view #student-apps-shell {
            display: flex !important;
            flex-direction: column;
            gap: 14px;
        }
        #app-screen.student-view .student-shell-head {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin: 0;
        }
        #app-screen.student-view .student-shell-head h3 {
            text-align: center;
            line-height: 1.2;
        }
        #app-screen.student-view .student-shell-head p {
            max-width: 62ch;
            font-size: 0.9rem;
            line-height: 1.6;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #app-screen.student-view .student-combined-wrap {
            display: flex !important;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            gap: 0;
        }
        #app-screen.student-view .student-combined-wrap .tabs {
            align-self: center;
            justify-content: center;
        }
        #app-screen.student-view .status-split {
            align-items: stretch;
        }
        #app-screen.student-view .status-split .tab-content {
            display: flex;
            flex-direction: column;
            min-height: 250px;
        }
        #app-screen.student-view .status-split .tab-content > ul,
        #app-screen.student-view #leaderboard-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }
        #app-screen.student-view #student-homework-shell .list-item,
        #app-screen.student-view #student-apps-shell .list-item {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 14px;
        }
        #app-screen.student-view #student-homework-shell .list-item > :first-child,
        #app-screen.student-view #student-apps-shell .list-item > :first-child {
            min-width: 0;
            text-align: left;
        }
        #app-screen.student-view #student-homework-shell .list-item > :last-child,
        #app-screen.student-view #student-apps-shell .list-item > :last-child {
            justify-self: end;
        }
        #app-screen.student-view #leaderboard-section .card-header,
        #app-screen.student-view #leaderboard-section h3,
        #app-screen.student-view #leaderboard-section p {
            text-align: center;
        }
        #app-screen.student-view #leaderboard-list .top-student-row {
            align-items: center;
        }
        body.dark-mode #app-screen.student-view > .app-header {
            background: rgba(15, 23, 42, 0.88) !important;
            border-color: #334155 !important;
            box-shadow: 0 14px 30px rgba(2, 6, 23, 0.34) !important;
        }
        body.dark-mode #app-screen.student-view #theme-toggle-app,
        body.dark-mode #app-screen.student-view #user-menu-trigger {
            background: #111827 !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
            box-shadow: none !important;
        }
        body.dark-mode #app-screen.student-view .student-hero-progress {
            background: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid rgba(71, 85, 105, 0.45);
        }
        body.dark-mode #app-screen.student-view .student-hero-progress-head,
        body.dark-mode #app-screen.student-view .student-hero-progress-note {
            color: #e2e8f0 !important;
        }
        body.dark-mode #app-screen.student-view .student-hero-progress-track {
            background: rgba(71, 85, 105, 0.48) !important;
        }
        body.dark-mode #app-screen.student-view #student-homework-shell .list-item,
        body.dark-mode #app-screen.student-view #student-apps-shell .list-item,
        body.dark-mode #app-screen.student-view #leaderboard-list .top-student-row {
            background: linear-gradient(180deg, #162033, #0f172a) !important;
            border: 1px solid #334155 !important;
            box-shadow: none !important;
        }
        @media (max-width: 900px) {
            #app-screen.student-view > .app-header {
                grid-template-columns: auto 1fr auto auto;
                padding: 12px 14px;
                gap: 10px;
            }
            #app-screen.student-view #header-center-logo {
                display: none;
            }
            #app-screen.student-view #student-homework-shell,
            #app-screen.student-view #student-apps-shell,
            #app-screen.student-view #leaderboard-section {
                min-height: 0 !important;
            }
        }
        @media (max-width: 640px) {
            #app-screen.student-view .student-hero-progress-head {
                flex-direction: column;
                gap: 6px;
            }
            #app-screen.student-view #student-homework-shell .list-item,
            #app-screen.student-view #student-apps-shell .list-item {
                grid-template-columns: 1fr;
                justify-items: center;
                text-align: center;
            }
            #app-screen.student-view #student-homework-shell .list-item > :first-child,
            #app-screen.student-view #student-apps-shell .list-item > :first-child,
            #app-screen.student-view #student-homework-shell .list-item > :last-child,
            #app-screen.student-view #student-apps-shell .list-item > :last-child {
                text-align: center;
                justify-self: center;
            }
            #app-screen.student-view .student-shell-head p,
            #app-screen.student-view .student-hero-message,
            #app-screen.student-view .student-spark-sub,
            #app-screen.student-view .student-quick-btn span,
            #app-screen.student-view .student-mini-meta {
                max-width: 28ch;
            }
        }
        body.dark-mode .apps-hub-modal-content { background: #0f172a; border-color: #334155; }
        body.dark-mode .apps-hub-card { background: #111827; border-color: #334155; }
        body.dark-mode .apps-hub-card-image { background: #0b1220; }
        body.dark-mode .apps-hub-card h4 { color: #f8fafc; }
        body.dark-mode .apps-hub-card p { color: #cbd5e1; }
        body.teacher-lessons-modal-open #app-screen.teacher-view #lessons-section {
            display: none !important;
        }
    </style>
</head>
<body class="{{ !empty($studentPanelMode) ? 'student-panel-mode' : '' }}">
    @if (!empty($studentPanelMode))
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;700;800&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('student-panel/legacy-bridge.css') }}">
        <script>
            window.STUDENT_PANEL_MODE = true;
            window.STUDENT_PANEL_PAGE = @json($studentPanelPage ?? 'dashboard');
        </script>
        <script defer src="{{ asset('student-panel/legacy-bridge.js') }}"></script>
    @endif

    <div id="side-menu" class="sidebar">
        <button id="close-menu" style="font-size: 30px; margin-bottom: 20px;">×</button>
        <div class="sidebar-logo-wrap">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="sidebar-logo">
        </div>
        <button id="btn-open-home" onclick="showPage('home')" class="nav-btn active" data-page="home">🏠 Anasayfa</button>
        <button id="btn-open-lessons" class="nav-btn" style="display: none;">📚 Derslerim</button>
        <button id="btn-toggle-apps-menu" class="nav-btn sidebar-group-toggle" style="display: none;">🧠 Uygulamalarım</button>
        <div id="submenu-apps" class="sidebar-submenu" style="display:none;"></div>
        <button id="btn-toggle-tasks-menu" class="nav-btn sidebar-group-toggle" style="display: none;">🗂️ Ödevler <span class="arrow">▸</span></button>
        <div id="submenu-tasks" class="sidebar-submenu">
            <button id="btn-open-create" class="nav-btn submenu-item" style="display: none;">➕ Ödev Ekle</button>
            <button id="btn-open-tasks" class="nav-btn submenu-item" style="display: none;">🗂️ Ödevler</button>
            <button id="btn-open-approvals" class="nav-btn submenu-item" style="display: none;">✅ Ödev Onayları</button>
        </div>
        <button id="btn-toggle-add-menu" class="nav-btn sidebar-group-toggle" style="display: none;">➕ Ekle <span class="arrow">▸</span></button>
        <div id="submenu-add" class="sidebar-submenu">
            <button id="btn-open-content" class="nav-btn submenu-item" style="display: none;">🧩 Etkinlik Ekle</button>
            <button id="btn-open-books" class="nav-btn submenu-item" style="display: none;">📚 Kitap Ekle</button>
            <button id="btn-open-add-student" class="nav-btn submenu-item" style="display: none;">👤 Öğrenci Ekle</button>
            <button id="btn-open-class-sections" class="nav-btn submenu-item" style="display: none;">🏫 Sınıf/Şube Ekle</button>
        </div>
        <button id="btn-toggle-student-data-menu" class="nav-btn sidebar-group-toggle" style="display: none;">👥 Öğrenci Verileri <span class="arrow">▸</span></button>
        <div id="submenu-student-data" class="sidebar-submenu">
            <button id="btn-open-students" class="nav-btn submenu-item" style="display: none;">👥 Öğrencilerim</button>
            <button id="btn-open-classes" class="nav-btn submenu-item" style="display: none;">🏫 Sınıflarım</button>
            <button id="btn-open-reports" class="nav-btn submenu-item" style="display: none;">🧾 Raporlar</button>
            <button id="btn-open-login-cards" class="nav-btn submenu-item" style="display: none;">🪪 Giriş Kartları</button>
            <button id="btn-open-teacher-certificates" class="nav-btn submenu-item" style="display: none;">🏅 Sertifika Yönetimi</button>
        </div>
        <button id="btn-open-my-stats" class="nav-btn" style="display: none;">📈 İstatistiklerim</button>
        <button id="btn-open-badges" class="nav-btn" style="display: none;">🏅 Rozetlerim</button>
        <button id="btn-open-certificates" class="nav-btn" style="display: none;">🎓 Sertifikalarım</button>
        <button id="btn-open-avatar-shop" class="nav-btn" style="display: none;">🛍️ Avatar Al</button>
        <div class="sidebar-footer">
            <div class="sidebar-footer-title">Sitede Geçen Süren</div>
            <div id="student-total-time" class="time-widget" style="display:none;">
                <div class="time-block">
                    <div id="time-days" class="time-val">0</div>
                    <div class="time-label">Gün</div>
                </div>
                <div class="time-block">
                    <div id="time-hours" class="time-val">0</div>
                    <div class="time-label">Saat</div>
                </div>
                <div class="time-block">
                    <div id="time-mins" class="time-val">0</div>
                    <div class="time-label">Dk</div>
                </div>
                <div class="time-block">
                    <div id="time-secs" class="time-val">0</div>
                    <div class="time-label">Sn</div>
                </div>
            </div>
            <button id="btn-logout-side" class="nav-btn" style="color:#b91c1c;">🚪 Çıkış Yap</button>
        </div>
    </div>

    <div id="apps-hub-modal" class="modal-overlay" style="display:none; z-index:26000;">
        <div class="modal-content apps-hub-modal-content">
            <div class="apps-hub-head">
                <h3 style="margin:0;">Uygulamalarım</h3>
                <button id="btn-close-apps-hub" class="btn" style="background:#e2e8f0;">Kapat</button>
            </div>
            <div class="apps-hub-grid">
                <article class="apps-hub-card">
                    <img src="{{ asset('blok-kodlama.png') }}" alt="Blok Kodlama" class="apps-hub-card-image">
                    <h4>Blok Kodlama</h4>
                    <p>Bloklarla temel kodlama becerilerini geliştir.</p>
                    <button id="btn-apps-hub-open-block2d" class="btn btn-primary apps-hub-start-btn">Uygulamaya Başla</button>
                </article>
                <article class="apps-hub-card">
                    <img src="{{ asset('3d-blok-kodlama.png') }}" alt="3D Blok Kodlama" class="apps-hub-card-image">
                    <h4>3D Blok Kodlama</h4>
                    <p>3 boyutlu sahnede kodlamayı deneyimle.</p>
                    <button id="btn-apps-hub-open-block3d" class="btn btn-primary apps-hub-start-btn">Uygulamaya Başla</button>
                </article>
                <article class="apps-hub-card">
                    <img src="{{ asset('compute-it.png') }}" alt="Compute It" class="apps-hub-card-image">
                    <h4>Compute It</h4>
                    <p>Algoritma ve problem çözme becerini güçlendir.</p>
                    <button id="btn-apps-hub-open-compute" class="btn btn-primary apps-hub-start-btn">Uygulamaya Başla</button>
                </article>
                <article class="apps-hub-card">
                    <img src="{{ asset('python.png') }}" alt="Python Quiz Lab" class="apps-hub-card-image">
                    <h4>Python Quiz Lab</h4>
                    <p>Python temelinden zora giden 3 bolumde soru ve mini konu anlatimi.</p>
                    <button id="btn-apps-hub-open-silent-teacher" class="btn btn-primary apps-hub-start-btn">Uygulamaya Başla</button>
                </article>
                <article class="apps-hub-card" id="apps-hub-card-live-quiz" style="display:none;">
                    <img src="{{ asset('quiz.png') }}" alt="Canlı Quiz" class="apps-hub-card-image">
                    <h4>Canlı Quiz</h4>
                    <p>Quiz oluştur, başlat ve sonuçları yönet.</p>
                    <button id="btn-apps-hub-open-live-quiz" class="btn btn-primary apps-hub-start-btn">Quiz Yönet</button>
                </article>
                <article class="apps-hub-card">
                    <img src="{{ asset('code-robot.png') }}" alt="Code Robot Lab" class="apps-hub-card-image">
                    <h4>Code Robot Lab</h4>
                    <p>Lightbot mantiginda komutlarla robotu yonet, kolaydan zora bolumleri gec.</p>
                    <button id="btn-apps-hub-open-lightbot" class="btn btn-primary apps-hub-start-btn">Uygulamaya Başla</button>
                </article>
                <article class="apps-hub-card">
                    <img src="{{ asset('flowchart.png') }}" alt="Flowchart" class="apps-hub-card-image">
                    <h4>Flowchart</h4>
                    <p>Akış şeması ile mantıksal düşünmeyi pekiştir.</p>
                    <button id="btn-apps-hub-open-flowchart" class="btn btn-primary apps-hub-start-btn">Uygulamaya Başla</button>
                </article>
                <article class="apps-hub-card">
                    <img src="{{ asset('cizgi-oyunu.png') }}" alt="Çizgi Oyunu" class="apps-hub-card-image">
                    <h4>Çizgi Oyunu</h4>
                    <p>Refleks ve dikkat becerilerini eğlenceli şekilde test et.</p>
                    <button id="btn-apps-hub-open-line-trace" class="btn btn-primary apps-hub-start-btn">Uygulamaya Başla</button>
                </article>
            </div>
        </div>
    </div>

    <div id="avatar-shop-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content avatar-shop-modal-content">
            <div class="avatar-shop-top">
                <h3 style="margin: 0;">Avatar Al</h3>
                <div id="avatar-shop-current-xp" class="avatar-shop-xp">XP: 0</div>
            </div>
            <div id="avatar-shop-grid" class="avatar-shop-grid"></div>
            <div style="display:flex; justify-content:flex-end;">
                <button id="btn-close-avatar-shop" class="btn btn-warning">Kapat</button>
            </div>
        </div>
    </div>
    <button id="student-ai-fab" class="edu-ai-fab" title="Yapay Zeka Asistanı">
        <span class="edu-ai-wing left" aria-hidden="true"></span>
        <span class="edu-ai-core"><img src="{{ asset('logo.png') }}" alt="Asistan Avatar"></span>
        <span class="edu-ai-wing right" aria-hidden="true"></span>
    </button>
    <div id="student-ai-panel" class="edu-ai-panel">
        <div class="edu-ai-panel-head">
            <div>
                <h4 class="edu-ai-panel-title">Akıllı Öğrenci Asistanı</h4>
                <p class="edu-ai-panel-sub">Sadece platform içerikleri için cevap verir.</p>
            </div>
            <button id="student-ai-close" class="edu-ai-close" title="Kapat">×</button>
        </div>
        <div id="student-ai-messages" class="edu-ai-messages"></div>
        <div class="edu-ai-quick">
            <button type="button" data-ai-quick="Bugün hangi ödevlerim var?">Ödevlerim</button>
            <button type="button" data-ai-quick="Blok kodlama ödev durumum nedir?">Blok Durumu</button>
            <button type="button" data-ai-quick="Compute it ödevlerimi özetle">Compute Özet</button>
            <button type="button" data-ai-quick="Ders içeriklerimde hangi konular var?">Ders Konuları</button>
        </div>
        <div class="edu-ai-input-wrap">
            <input id="student-ai-input" class="edu-ai-input" type="text" placeholder="Sorunu yaz...">
            <button id="student-ai-send" class="edu-ai-send" type="button">Gönder</button>
        </div>
    </div>

    <!-- Giriş Ekranı -->
    <div id="login-screen" class="login-screen">
        <div class="card login-card">
            <div class="login-layout">
                <section class="login-left">
                    <div class="login-scene" aria-hidden="true">
                        <span class="scene-item scene-rocket r1">ROCKET</span>
                        <span class="scene-item scene-rocket r2">LAUNCH</span>
                        <span class="scene-item scene-robot b1">ROBOT</span>
                        <span class="scene-item scene-robot b2">BOT LAB</span>
                        <span class="scene-item scene-code c1">&lt;/&gt; CODE</span>
                        <span class="scene-item scene-code c2">if(win){login()}</span>
                        <span class="scene-dot d1"></span>
                        <span class="scene-dot d2"></span>
                        <span class="scene-dot d3"></span>
                    </div>
                    <div class="login-left-top">
                        <h2>Dijital Bilişim Eğitim Platformu</h2>
                        <p>Kısa, odaklı ve uygulamalı içeriklerle öğrenme sürecini hızlandır.</p>
                    </div>
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="login-hero-logo">
                    <div class="login-slogan">Özelsin Çünkü Gelecek Sensin</div>
                </section>
                <section class="login-right">
                    <button id="theme-toggle-login" class="theme-toggle" type="button" title="Karanlık Mod">🌙</button>
                    <div class="login-form-wrap">
                        <div class="login-title-bar">
                            <h3>Giriş Yap</h3>
                        </div>
                        <p class="login-sub">Paneline devam etmek için kullanıcı bilgilerini gir.</p>
                        <label for="email">Kullanıcı Adı / E-posta</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="E-posta veya Kullanıcı Adı">
                        <label for="password">Şifre</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Şifre">
                        <div class="login-actions">
                            <button id="btn-login" type="button" class="btn btn-success" style="flex: 1;">Giriş Yap</button>
                        </div>
                        <button id="btn-login-mini-game" type="button" class="btn" style="background:linear-gradient(90deg,#0ea5e9,#2563eb);color:#fff;border:none;height:44px;border-radius:12px;font-weight:700;">🎮 Mini Oyunla Şifresiz Giriş</button>
                        <div id="login-mini-game-wrap" style="display:none;"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="login-mini-game-modal" class="modal-overlay" style="display:none; z-index:31000;">
        <div class="modal-content login-mini-game-content" style="width:min(960px,94vw); max-width:94vw; padding:16px; border-radius:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <h3 style="margin:0;">Kanatlı Kahraman Oyunu</h3>
                <button id="btn-close-login-mini-game" class="btn" style="background:#eee;">Kapat</button>
            </div>
            <div style="font-size:14px; color:#334155; margin-bottom:8px;">Bilgi: Ok tuşları ile oyna. 3 yıldız toplayıp hedefe çıkınca giriş yapılır.</div>
            <canvas id="login-mini-game-canvas" width="1100" height="550" style="width:100%; height:auto; border-radius:14px; background:#0f172a; border:1px solid #1e293b;"></canvas>
            <div style="display:flex; justify-content:space-between; margin-top:8px; font-size:13px; color:#475569;">
                <span>Kontrol: `←` `→` hareket, `↑` zıpla</span>
                <span id="login-mini-game-status">Hazır</span>
            </div>
        </div>
    </div>

        <!-- Block Runner Reports Modal (Teacher) -->
        <div id="block-reports-modal" class="modal-overlay" style="display:none;">
            <div class="modal-content modal-large">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 style="margin:0;">Blok Kodlama Raporları</h3>
                    <button id="btn-close-block-reports" class="btn" style="background:#eee;">Kapat</button>
                </div>
                <div style="margin-top:12px;">
                    <div id="block-reports-loading" class="loading">Yükleniyor...</div>
                    <div id="block-reports-list" style="display:none; max-height:60vh; overflow:auto; margin-top:8px;"></div>
                </div>
            </div>
        </div>

    <div class="container">

        <!-- Ana Uygulama Ekranı -->
        <div id="app-screen" style="display: none;">
            <div class="app-header">
                <div id="user-fullname" style="min-width: 160px; font-family: 'Poppins', sans-serif; font-weight: 600; color: #2c2c2c;"></div>
                <button id="open-menu" style="display:none;">☰</button>
                <div id="header-center-logo"><img src="{{ asset('logo.png') }}" alt="Logo" style="transform: scale(1.95); transform-origin: center; display:block;"></div>
                <h3 id="user-welcome" style="margin: 0; display:none;">Hoş geldin!</h3>
                <div id="user-menu" style="position: relative; display: flex; align-items: center; gap: 8px;">
                    <button id="theme-toggle-app" class="theme-toggle-inline" type="button" title="Karanlık Mod">🌙</button>
                    <div id="user-header-avatar" aria-hidden="true"></div>
                    <button id="user-menu-trigger" class="btn">Hoş geldin</button>
                    <div id="user-dropdown" style="position: absolute; top: 44px; right: 0; background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; box-shadow: 0 10px 24px rgba(0,0,0,0.12); min-width: 160px; display: none; z-index: 12000;">
                        <button id="btn-open-profile-menu" class="btn" style="width: 100%; text-align: left; background: transparent; border: none; padding: 10px 12px;">👤 Profil</button>
                        <button id="btn-logout-menu" class="btn" style="width: 100%; text-align: left; background: transparent; border: none; padding: 10px 12px; color: #b91c1c;">🚪 Çıkış Yap</button>
                    </div>
                </div>
            </div>
            <div id="home-overview-strip" class="home-overview-strip">
                <div class="home-overview-card">
                    <div class="home-overview-title">Ödev</div>
                    <div id="home-overview-tasks" class="home-overview-value">0</div>
                    <div id="home-overview-tasks-meta" class="home-overview-meta">Yükleniyor...</div>
                </div>
                <div class="home-overview-card">
                    <div class="home-overview-title">Etkinlik</div>
                    <div id="home-overview-activities" class="home-overview-value">0</div>
                    <div id="home-overview-activities-meta" class="home-overview-meta">Yükleniyor...</div>
                </div>
                <div class="home-overview-card">
                    <div class="home-overview-title">Blok Kodlama</div>
                    <div id="home-overview-block" class="home-overview-value">0</div>
                    <div id="home-overview-block-meta" class="home-overview-meta">Yükleniyor...</div>
                </div>
                <div class="home-overview-card">
                    <div class="home-overview-title">Compute It</div>
                    <div id="home-overview-compute" class="home-overview-value">0</div>
                    <div id="home-overview-compute-meta" class="home-overview-meta">Yükleniyor...</div>
                </div>
                <div class="home-overview-card">
                    <div class="home-overview-title">Ders</div>
                    <div id="home-overview-lessons" class="home-overview-value">0</div>
                    <div id="home-overview-lessons-meta" class="home-overview-meta">Yükleniyor...</div>
                </div>
            </div>
            <div id="student-hero-panel">
                <div class="student-hero-main">
                    <div class="student-hero-kicker">Seviye haritan hazır</div>
                    <h2 id="student-hero-greeting" class="student-hero-title">Bugün neyi tamamlamak istersin?</h2>
                    <p id="student-hero-message" class="student-hero-message">Bekleyen görevlerini seç, ilerlemeni artır ve yeni puanlar kazan.</p>
                    <div id="student-hero-pending-alert" class="student-hero-alert">
                        <div class="student-hero-alert-title">Bekleyen çalışmaların var</div>
                        <div id="student-hero-pending-alert-text" class="student-hero-alert-text">Ödev, etkinlik ve ders bekleyenlerin bitene kadar bu uyarı kalır.</div>
                    </div>
                    <div class="student-hero-stats">
                        <div class="student-hero-stat">
                            <div class="student-hero-stat-label">Toplam XP</div>
                            <div id="student-hero-xp" class="student-hero-stat-value">0 XP</div>
                        </div>
                        <div class="student-hero-stat">
                            <div class="student-hero-stat-label">Tamamlanan</div>
                            <div id="student-hero-completed" class="student-hero-stat-value">0</div>
                        </div>
                        <div class="student-hero-stat">
                            <div class="student-hero-stat-label">Bekleyen</div>
                            <div id="student-hero-pending" class="student-hero-stat-value">0</div>
                        </div>
                        <div class="student-hero-stat">
                            <div class="student-hero-stat-label">Quiz Puanı</div>
                            <div id="student-hero-quiz" class="student-hero-stat-value">0</div>
                        </div>
                        <div class="student-hero-stat">
                            <div class="student-hero-stat-label">Sınıf Sıralaması</div>
                            <div id="student-hero-class-rank" class="student-hero-stat-value">—</div>
                        </div>
                        <div class="student-hero-stat">
                            <div class="student-hero-stat-label">Okul Sıralaması</div>
                            <div id="student-hero-school-rank" class="student-hero-stat-value">—</div>
                        </div>
                    </div>
                    <div class="student-hero-progress">
                        <div class="student-hero-progress-head">
                            <span>Genel ilerleme</span>
                            <strong id="student-hero-progress-text">%0</strong>
                        </div>
                        <div class="student-hero-progress-track">
                            <div id="student-hero-progress-fill" class="student-hero-progress-fill"></div>
                        </div>
                        <div id="student-hero-progress-note" class="student-hero-progress-note">Hedeflerini tamamladikca bar dolacak.</div>
                    </div>
                    <!-- removed old spark-card; class ranking now shown as a hero stat -->
                </div>
                <div class="student-hero-side">
                    <div class="student-quick-card" style="display:none;">&nbsp;</div>
                    <div class="card" id="student-top-students-card">
                        <h4>Öğrenci Başarı Listesi (İlk 7)</h4>
                        <div id="student-top-students-list"></div>
                    </div>
                </div>
                <div class="student-mini-grid">
                    <div class="student-mini-card">
                        <div class="student-mini-label">Ödevler</div>
                        <div id="student-mini-tasks" class="student-mini-value">0</div>
                        <div id="student-mini-tasks-meta" class="student-mini-meta">0 bekleyen</div>
                    </div>
                    <div class="student-mini-card">
                        <div class="student-mini-label">Etkinlikler</div>
                        <div id="student-mini-activities" class="student-mini-value">0</div>
                        <div id="student-mini-activities-meta" class="student-mini-meta">0 bekleyen</div>
                    </div>
                    <div class="student-mini-card">
                        <div class="student-mini-label">Blok Kodlama</div>
                        <div id="student-mini-block" class="student-mini-value">0</div>
                        <div id="student-mini-block-meta" class="student-mini-meta">0 bekleyen</div>
                    </div>
                    <div class="student-mini-card">
                        <div class="student-mini-label">Compute It</div>
                        <div id="student-mini-compute" class="student-mini-value">0</div>
                        <div id="student-mini-compute-meta" class="student-mini-meta">0 bekleyen</div>
                    </div>
                    <div class="student-mini-card">
                        <div class="student-mini-label">Dersler</div>
                        <div id="student-mini-lessons" class="student-mini-value">0</div>
                        <div id="student-mini-lessons-meta" class="student-mini-meta">0 bekleyen</div>
                    </div>
                </div>
            </div>
            <!-- Öğrenci İstatistikleri -->
            <div id="student-stats-bar" style="display: none;">
                <div class="stats-grid" style="margin-bottom: 12px;">
                    <div class="stat-card completed-card">
                        <div class="stat-label" style="font-size:0.92rem;font-weight:700;color:#1f2937;">Tamamlananlar</div>
                        <div class="completed-summary">
                            <div class="item">
                                <div class="k">Ödev</div>
                                <div class="v" id="stat-completed">0</div>
                            </div>
                            <div class="item">
                                <div class="k">Etkinlik</div>
                                <div class="v" id="stat-activity-completed">0</div>
                            </div>
                            <div class="item">
                                <div class="k">Blok Kod</div>
                                <div class="v" id="stat-block-level-completed">0</div>
                            </div>
                            <div class="item">
                                <div class="k">Compute It</div>
                                <div class="v" id="stat-compute-level-completed">0</div>
                            </div>
                            <div class="item">
                                <div class="k">3D Blok</div>
                                <div class="v" id="stat-block3d-completed">0</div>
                            </div>
                            <div class="item">
                                <div class="k">Flowchart</div>
                                <div class="v" id="stat-flowchart-completed">0</div>
                            </div>
                            <div class="item">
                                <div class="k">Python</div>
                                <div class="v" id="stat-python-completed">0</div>
                            </div>
                            <div class="item">
                                <div class="k">Derslerim</div>
                                <div class="v" id="stat-lessons-completed">0</div>
                            </div>
                            <div class="item">
                                <div class="k">Quiz Puanı</div>
                                <div class="v" id="stat-quiz-points">0 Puan</div>
                            </div>
                            <div class="item xp-item">
                                <div class="k">Toplam XP</div>
                                <div class="v" id="user-xp">0 XP</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:8px;">
                    <!-- central student open button removed per UI change -->
                </div>
            </div>
            <div id="teacher-hero-panel">
                <div class="teacher-hero-main">
                    <div class="teacher-hero-kicker">Öğretmen kontrol merkezi</div>
                    <div class="teacher-hero-topline">
                        <div>
                            <h2 id="teacher-hero-title" class="teacher-hero-title">Sınıf akışı hazır.</h2>
                            <p id="teacher-hero-text" class="teacher-hero-text">Kısa sinyallerle sınıfın ritmini anında okuyun.</p>
                        </div>
                        <div class="teacher-hero-visual" aria-hidden="true">
                            <div class="teacher-hero-summary-title">Sınıf Özeti</div>
                            <div class="teacher-hero-summary-sub">Katılım ve ilerleme oranları</div>
                            <div class="teacher-hero-rail is-summary">
                                <div class="teacher-hero-rail-item">
                                    <span>Katılım</span>
                                    <div class="teacher-hero-rail-track"><div id="teacher-rail-attendance" class="teacher-hero-rail-fill"></div></div>
                                    <strong id="teacher-rail-attendance-text">%0</strong>
                                </div>
                                <div class="teacher-hero-rail-item">
                                    <span>İlerleme</span>
                                    <div class="teacher-hero-rail-track"><div id="teacher-rail-progress" class="teacher-hero-rail-fill"></div></div>
                                    <strong id="teacher-rail-progress-text">%0</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="teacher-hero-metrics">
                        <div class="teacher-hero-metric">
                            <div class="teacher-hero-metric-label">Toplam Öğrenci</div>
                            <div id="teacher-hero-total-students" class="teacher-hero-metric-value">0</div>
                        </div>
                        <div class="teacher-hero-metric">
                            <div class="teacher-hero-metric-label">Aktif Öğrenci</div>
                            <div id="teacher-hero-active-students" class="teacher-hero-metric-value">0</div>
                        </div>
                        <div class="teacher-hero-metric">
                            <div class="teacher-hero-metric-label">Ort. Tamamlama</div>
                            <div id="teacher-hero-avg-completion" class="teacher-hero-metric-value">%0</div>
                        </div>
                        <div class="teacher-hero-metric">
                            <div class="teacher-hero-metric-label">Toplam XP</div>
                            <div id="teacher-hero-total-xp" class="teacher-hero-metric-value">0</div>
                        </div>
                    </div>
                    <div class="teacher-hero-signal-grid">
                        <div class="teacher-hero-signal">
                            <div class="teacher-hero-signal-kicker">Odak</div>
                            <div id="teacher-hero-focus-title" class="teacher-hero-signal-title">Hazırlanıyor</div>
                            <div id="teacher-hero-focus-text" class="teacher-hero-signal-text">Bugünün ilk sinyali.</div>
                        </div>
                        <div class="teacher-hero-signal">
                            <div class="teacher-hero-signal-kicker">Güç</div>
                            <div id="teacher-hero-strong-title" class="teacher-hero-signal-title">Hazırlanıyor</div>
                            <div id="teacher-hero-strong-text" class="teacher-hero-signal-text">Öne çıkan kategori.</div>
                        </div>
                        <div class="teacher-hero-signal">
                            <div class="teacher-hero-signal-kicker">Ritim</div>
                            <div id="teacher-hero-rhythm-title" class="teacher-hero-signal-title">Hazırlanıyor</div>
                            <div id="teacher-hero-rhythm-text" class="teacher-hero-signal-text">Üretim temposu sinyali.</div>
                        </div>
                    </div>
                    <div style="display:none;">
                        <span id="stats-task-completions">0</span>
                        <span id="stats-activity-completions">0</span>
                        <span id="stats-block-completions">0</span>
                        <span id="stats-compute-completions">0</span>
                    </div>
                </div>
                <div class="teacher-hero-side">
                    <div class="teacher-hero-quick">
                        <h3>Sınıf sinyalleri</h3>
                        <div class="teacher-quick-grid">
                            <div class="teacher-info-card">
                                <div class="teacher-info-kicker">Destek</div>
                                <div id="teacher-info-support-title" class="teacher-info-title">Takip önerisi hazırlanıyor</div>
                                <div class="teacher-info-bar"><span id="teacher-info-support-bar"></span></div>
                                <div id="teacher-info-support-text" class="teacher-info-text">Destek sinyali.</div>
                            </div>
                            <div class="teacher-info-card">
                                <div class="teacher-info-kicker">Motivasyon</div>
                                <div id="teacher-info-motivation-title" class="teacher-info-title">Başarı özeti hazırlanıyor</div>
                                <div class="teacher-info-bar"><span id="teacher-info-motivation-bar"></span></div>
                                <div id="teacher-info-motivation-text" class="teacher-info-text">Üretim ve başarı.</div>
                            </div>
                            <div class="teacher-info-card">
                                <div class="teacher-info-kicker">Günün Odağı</div>
                                <div id="teacher-info-focus-title" class="teacher-info-title">Kısa plan önerisi</div>
                                <div class="teacher-info-bar"><span id="teacher-info-focus-bar"></span></div>
                                <div id="teacher-info-focus-text" class="teacher-info-text">3 kısa görev + 1 derin çalışma önerisi.</div>
                            </div>
                            <div class="teacher-info-card">
                                <div class="teacher-info-kicker">Durum Notu</div>
                                <div id="teacher-info-status-title" class="teacher-info-title">Sınıf akışı</div>
                                <div class="teacher-info-bar"><span id="teacher-info-status-bar"></span></div>
                                <div id="teacher-hero-status-note" class="teacher-info-text">Akış özeti hazırlanıyor.</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-accent">
                        <h4>Haftalık özet</h4>
                        <div class="mini-grid">
                            <div class="mini-card">
                                <div class="k">En Aktif</div>
                                <div id="teacher-mini-top-active" class="v">-</div>
                                <div id="teacher-mini-top-active-sub" class="s">Aktiflik oranı</div>
                            </div>
                            <div class="mini-card">
                                <div class="k">En İyi Tamamlama</div>
                                <div id="teacher-mini-top-completion" class="v">-</div>
                                <div id="teacher-mini-top-completion-sub" class="s">Ortalama tamamlama</div>
                            </div>
                            <div class="mini-card">
                                <div class="k">XP Lideri</div>
                                <div id="teacher-mini-top-xp" class="v">-</div>
                                <div id="teacher-mini-top-xp-sub" class="s">Ort. XP/öğrenci</div>
                            </div>
                            <div class="mini-card">
                                <div class="k">Düşük Aktiflik</div>
                                <div id="teacher-mini-low-active" class="v">-</div>
                                <div id="teacher-mini-low-active-sub" class="s">Öncelik önerisi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Öğretmen İstatistikleri ve Öğrenci Listesi -->
            <div id="teacher-analytics" style="display: none;">
                <div id="stats-loading" class="loading">Yükleniyor...</div>
                <div id="stats-content" style="display: none;">
                    <div class="card">
                        <h4>Sınıf Genel İstatistikleri</h4>
                        <div class="stats-grid stats-summary-grid" style="grid-template-columns: repeat(auto-fit, minmax(110px,1fr)); gap:10px; margin-bottom:12px;">
                            <div class="stat-card">
                                <div class="stat-number" id="stats-total-students">0</div>
                                <div class="stat-label">Toplam Öğrenci</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number" id="stats-active-students">0</div>
                                <div class="stat-label">Aktif Öğrenci</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number" id="stats-avg-completion">0%</div>
                                <div class="stat-label">Ortalama Tamamlama</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number" id="stats-total-completions">0</div>
                                <div class="stat-label">Toplam Tamamlama</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-number" id="stats-total-xp">0</div>
                                <div class="stat-label">Toplam XP</div>
                            </div>
                        </div>
                        <div class="teacher-top-wrap">
                            <div class="chart-container teacher-type-chart" style="margin: 0;">
                                <div class="teacher-type-panel">
                                    <div class="teacher-type-title">Kategori Bazlı Tamamlama Oranı</div>
                                    <div class="teacher-type-wrap">
                                        <canvas id="classTypeChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container teacher-main-chart" style="margin: 0;">
                                <div class="teacher-pie-panel">
                                    <div class="teacher-pie-title">Ödev Tamamlanma Analizi</div>
                                    <div class="teacher-pie-wrap">
                                        <canvas id="classChart"></canvas>
                                    </div>
                                    <div id="class-chart-summary"></div>
                                </div>
                            </div>
                        </div>
                            <!-- teacher homepage block reports button removed (reports available in student reports view) -->
                    </div>
                    
                </div>
            </div>

            <!-- Öğrenci Başarı Listesi (Öğretmen) -->
            <div class="card" id="top-students-card" style="display: none;">
                <h4>Öğrenci Başarı Listesi (İlk 7)</h4>
                <div id="top-students-list" style="display: flex; flex-direction: column; gap: 8px;"></div>
            </div>

            <div class="card" id="student-homework-shell">
                <div class="student-shell-head">
                    <div>
                        <h3>📚 Görev Merkezi</h3>
                        <p>Ödev, etkinlik ve derslerini tek ekranda takip et. Önce bekleyenleri bitir, sonra tamamladıklarını kontrol et.</p>
                    </div>
                </div>
                <div id="teacher-home-tabs" class="tabs" style="display:none; margin-top:10px;">
                    <button class="tab-btn active" data-home-tab="tasks" onclick="switchTeacherHomeTab('tasks')">Ödevler</button>
                    <button class="tab-btn" data-home-tab="activities" onclick="switchTeacherHomeTab('activities')">Etkinlikler</button>
                    <button class="tab-btn" data-home-tab="lessons" onclick="switchTeacherHomeTab('lessons')">Dersler</button>
                </div>
                <div id="teacher-home-sections-host" style="display:none; margin-top:12px;"></div>
                <div id="student-homework-combined" class="student-combined-wrap">
                    <div id="student-homework-tabs" class="tabs">
                        <button class="tab-btn active" onclick="switchStudentCombinedTab('homework','pending')">Bekleyen</button>
                        <button class="tab-btn" onclick="switchStudentCombinedTab('homework','completed')">Tamamlanan</button>
                    </div>
                    <div class="status-split">
                        <div id="student-homework-pending" class="tab-content active">
                            <ul id="list-student-homework-pending" style="padding:0; margin:0; list-style:none;"></ul>
                            <div id="no-student-homework-pending" class="empty-state" style="display:none;">
                                <div class="empty-state-icon">📚</div>
                                Bekleyen içerik yok.
                            </div>
                        </div>
                        <div id="student-homework-completed" class="tab-content">
                            <ul id="list-student-homework-completed" style="padding:0; margin:0; list-style:none;"></ul>
                            <div id="no-student-homework-completed" class="empty-state" style="display:none;">
                                <div class="empty-state-icon">✅</div>
                                Tamamlanan içerik yok.
                            </div>
                        </div>
                    </div>
                    <button id="btn-show-all-student-homework" class="btn btn-primary" style="width:100%; display:none; margin-top:10px;">Daha Fazla Göster</button>
                </div>
                <div class="student-shell-body">
            <!-- Verilen Ödevler / Ödevlerim -->
            <div class="card" id="tasks-section">
                <h3 id="tasks-title">📚 Ödevlerim</h3>
                
                <!-- Filtreleme (Öğretmen için) -->
                <div id="teacher-filters" class="filter-bar" style="display: none;">
                </div>
                
                <!-- Öğrenci için sekmeler -->
                <div id="student-tabs" class="tabs" style="display: none;">
                    <button class="tab-btn active" onclick="switchTab('pending')">Bekleyen</button>
                    <button class="tab-btn" onclick="switchTab('completed')">Tamamlanan</button>
                </div>
                
                <!-- Öğretmen için istatistikler -->
                <div id="teacher-stats" class="teacher-app-stats" style="display:none;">
                    <div class="teacher-app-stats-title">Verilen Toplam Ödev: <strong id="teacher-task-count">0</strong></div>
                    <div class="teacher-app-stats-grid">
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Tamamlayan Öğrenci</div>
                            <div id="teacher-task-completed-students" style="font-size:18px; font-weight:700; color:#1e3a8a;">0</div>
                        </div>
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Ortalama İlerleme</div>
                            <div id="teacher-task-avg-progress" style="font-size:18px; font-weight:700; color:#0f766e;">%0</div>
                        </div>
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Toplam XP</div>
                            <div id="teacher-task-total-xp" style="font-size:18px; font-weight:700; color:#b45309;">0</div>
                        </div>
                    </div>
                </div>
                
                <div id="tab-pending" class="tab-content active">
                    <ul id="list-pending" style="padding: 0; margin: 0; list-style: none;"></ul>
                    <div id="no-pending" class="empty-state" style="display: none;">
                        <div class="empty-state-icon">⏳</div>
                        <div>Bekleyen ödev yok!</div>
                    </div>
                </div>
                
                <div id="tab-completed" class="tab-content">
                    <ul id="list-completed" style="padding: 0; margin: 0; list-style: none;"></ul>
                    <div id="no-completed" class="empty-state" style="display: none;">
                        <div class="empty-state-icon">📚</div>
                        <div>Henüz tamamlanan ödev yok.</div>
                    </div>
                </div>
                <button id="btn-show-all-tasks" class="btn btn-primary" style="width: 100%; display: none; margin-top: 10px;">Daha Fazla Göster</button>
            </div>

            <!-- Etkinliklerim / Verilen Etkinlikler -->
            <div class="card" id="activities-section">
                <h3 id="activities-title">🎯 Etkinliklerim</h3>

                <!-- Filtreleme (Öğretmen için) -->
                <div id="activity-filters" class="filter-bar" style="display: none;">
                </div>
                
                <div id="activities-tabs" class="tabs" style="display: none;">
                    <button class="tab-btn active" onclick="switchActivityTab('pending')">Bekleyen</button>
                    <button class="tab-btn" onclick="switchActivityTab('completed')">Tamamlanan</button>
                </div>
                
                <div id="activities-teacher-stats" class="teacher-app-stats" style="display:none;">
                    <div class="teacher-app-stats-title">Verilen Toplam Etkinlik: <strong id="teacher-activity-count">0</strong></div>
                    <div class="teacher-app-stats-grid">
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Tamamlayan Öğrenci</div>
                            <div id="teacher-activity-completed-students" style="font-size:18px; font-weight:700; color:#1e3a8a;">0</div>
                        </div>
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Ortalama İlerleme</div>
                            <div id="teacher-activity-avg-progress" style="font-size:18px; font-weight:700; color:#0f766e;">%0</div>
                        </div>
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Toplam XP</div>
                            <div id="teacher-activity-total-xp" style="font-size:18px; font-weight:700; color:#b45309;">0</div>
                        </div>
                    </div>
                </div>

                <div id="activity-pending" class="tab-content active">
                    <ul id="list-activity-pending" style="padding: 0; margin: 0; list-style: none;"></ul>
                    <div id="no-activity-pending" class="empty-state" style="display: none;">
                        <div class="empty-state-icon">🎯</div>
                        Bekleyen etkinlik yok.
                    </div>
                </div>
                
                <div id="activity-completed" class="tab-content">
                    <ul id="list-activity-completed" style="padding: 0; margin: 0; list-style: none;"></ul>
                    <div id="no-activity-completed" class="empty-state" style="display: none;">
                        <div class="empty-state-icon">✅</div>
                        Tamamlanan etkinlik yok.
                    </div>
                </div>
                <button id="btn-show-all-activities" class="btn btn-primary" style="width: 100%; display: none; margin-top: 10px;">Daha Fazla Göster</button>
            </div>
            
            <!-- Dersler -->
            <div class="card" id="lessons-section">
                <h3 id="lessons-title">📑 Derslerim</h3>
                <div id="lessons-tabs" class="tabs" style="display:none; margin-top:10px;">
                    <button class="tab-btn active" onclick="switchLessonTab('pending')">Bekleyen</button>
                    <button class="tab-btn" onclick="switchLessonTab('completed')">Tamamlanan</button>
                </div>
                <div id="lessons-teacher-stats" class="teacher-app-stats" style="display:none;">
                    <div class="teacher-app-stats-title">Verilen Toplam Ders: <strong id="teacher-lesson-count">0</strong></div>
                    <div class="teacher-app-stats-grid">
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Tamamlayan Öğrenci</div>
                            <div id="teacher-lesson-completed-students" style="font-size:18px; font-weight:700; color:#1e3a8a;">0</div>
                        </div>
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Ortalama İlerleme</div>
                            <div id="teacher-lesson-avg-progress" style="font-size:18px; font-weight:700; color:#0f766e;">%0</div>
                        </div>
                        <div class="teacher-app-stats-tile">
                            <div style="font-size:11px; color:#64748b;">Toplam XP</div>
                            <div id="teacher-lesson-total-xp" style="font-size:18px; font-weight:700; color:#b45309;">0</div>
                        </div>
                    </div>
                </div>
                <div id="lessons-pending" class="tab-content active">
                    <ul id="list-lessons-pending" style="padding:0; margin:0; list-style:none;"></ul>
                    <div id="no-lessons-pending" class="empty-state" style="display:none;">
                        <div class="empty-state-icon">📖</div>
                        Bekleyen ders yok.
                    </div>
                </div>
                <div id="lessons-completed" class="tab-content">
                    <ul id="list-lessons-completed" style="padding:0; margin:0; list-style:none;"></ul>
                    <div id="no-lessons-completed" class="empty-state" style="display:none;">
                        <div class="empty-state-icon">✅</div>
                        Tamamlanan ders yok.
                    </div>
                </div>
                <button id="btn-show-all-lessons" class="btn btn-primary" style="width: 100%; display: none; margin-top: 10px;">Daha Fazla Göster</button>
            </div>
                </div>
            </div>

            <!-- Quizler (Öğretmen) -->
            <div class="card" id="quiz-section" style="display:none;">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;">
                    <h3 style="margin:0;">🧠 Verilen Quizler</h3>
                    <button id="btn-open-live-quiz-home" class="btn btn-primary">Quiz Yönet</button>
                </div>
                <div id="quiz-tabs" class="tabs" style="display:none; margin-top:10px;">
                    <button class="tab-btn active" onclick="switchTeacherQuizTab('pending')">Bekleyen</button>
                    <button class="tab-btn" onclick="switchTeacherQuizTab('completed')">Tamamlanan</button>
                </div>
                <div style="margin:10px 0 15px; padding:10px; background:#f0f7ff; border-radius:8px; text-align:center;">
                    <small>Toplam Quiz: <strong id="teacher-quiz-count">0</strong></small>
                </div>
                <div id="quiz-pending" class="tab-content active">
                    <div id="quiz-list-pending" style="display:flex;flex-direction:column;gap:8px;"></div>
                    <div id="no-quiz-pending" class="empty-state" style="display:none;">
                        <div class="empty-state-icon">🧠</div>
                        Bekleyen quiz yok.
                    </div>
                </div>
                <div id="quiz-completed" class="tab-content">
                    <div id="quiz-list-completed" style="display:flex;flex-direction:column;gap:8px;"></div>
                    <div id="no-quiz-completed" class="empty-state" style="display:none;">
                        <div class="empty-state-icon">✅</div>
                        Tamamlanan quiz yok.
                    </div>
                </div>
            </div>

            <div class="card" id="student-apps-shell">
                <div class="student-shell-head">
                    <div>
                        <h3>🧩 Uygulama Atölyesi</h3>
                        <p>Blok Kodlama, 3D Blok, Python Quiz Lab, Code Robot ve Compute It çalışmalarını burada aç.</p>
                    </div>
                </div>
                <div id="student-apps-combined" class="student-combined-wrap">
                    <div id="student-apps-tabs" class="tabs">
                        <button class="tab-btn active" onclick="switchStudentCombinedTab('apps','pending')">Bekleyen</button>
                        <button class="tab-btn" onclick="switchStudentCombinedTab('apps','completed')">Tamamlanan</button>
                    </div>
                    <div class="status-split">
                        <div id="student-apps-pending" class="tab-content active">
                            <ul id="list-student-apps-pending" style="padding:0; margin:0; list-style:none;"></ul>
                            <div id="no-student-apps-pending" class="empty-state" style="display:none;">
                                <div class="empty-state-icon">🧩</div>
                                Bekleyen uygulama içeriği yok.
                            </div>
                        </div>
                        <div id="student-apps-completed" class="tab-content">
                            <ul id="list-student-apps-completed" style="padding:0; margin:0; list-style:none;"></ul>
                            <div id="no-student-apps-completed" class="empty-state" style="display:none;">
                                <div class="empty-state-icon">✅</div>
                                Tamamlanan uygulama içeriği yok.
                            </div>
                        </div>
                    </div>
                    <button id="btn-show-all-student-apps" class="btn btn-primary" style="width:100%; display:none; margin-top:10px;">Daha Fazla Göster</button>
                </div>
                <div class="student-shell-body">
            <!-- Blok Kodlama Ödevi -->
            <div class="card" id="block-homework-section">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;">
                    <h3 id="block-homework-title" style="margin:0;"></h3>
                </div>
                <div id="block-homework-assign-tabs" class="tabs" style="display:none; margin-top:10px;">
                    <button class="tab-btn active" data-assign-type="block2d" onclick="switchBlockAssignTab('block2d')">Blok Kodlama</button>
                    <button class="tab-btn" data-assign-type="block3d" onclick="switchBlockAssignTab('block3d')">3D Blok Kodlama</button>
                    <button class="tab-btn" data-assign-type="silentteacher" onclick="switchBlockAssignTab('silentteacher')">Python Quiz Lab</button>
                    <button class="tab-btn" data-assign-type="lightbot" onclick="switchBlockAssignTab('lightbot')">Code Robot Lab</button>
                    <button class="tab-btn" data-assign-type="computeit" onclick="switchBlockAssignTab('computeit')">Compute It</button>
                </div>
                <div id="block-homework-tabs" class="tabs" style="display:none; margin-top:10px;">
                    <button class="tab-btn active" onclick="switchBlockHomeworkTab('pending')">Bekleyen</button>
                    <button class="tab-btn" onclick="switchBlockHomeworkTab('completed')">Tamamlanan</button>
                </div>
                <div id="block-homework-teacher-stats" class="teacher-app-stats" style="display:none;">
                    <div class="teacher-app-stats-title"><span id="teacher-block-homework-label">Verilen Toplam Blok Ödevi</span>: <strong id="teacher-block-homework-count">0</strong></div>
                    <div class="teacher-app-stats-grid">
                            <div class="teacher-app-stats-tile">
                                <div style="font-size:11px; color:#64748b;">Tamamlayan Öğrenci</div>
                                <div id="teacher-block-homework-completed-students" style="font-size:18px; font-weight:700; color:#1e3a8a;">0</div>
                            </div>
                            <div class="teacher-app-stats-tile">
                                <div style="font-size:11px; color:#64748b;">Ortalama İlerleme</div>
                                <div id="teacher-block-homework-avg-progress" style="font-size:18px; font-weight:700; color:#0f766e;">%0</div>
                            </div>
                            <div id="teacher-block-homework-xp-tile" class="teacher-app-stats-tile">
                                <div style="font-size:11px; color:#64748b;">Toplam XP</div>
                                <div id="teacher-block-homework-total-xp" style="font-size:18px; font-weight:700; color:#b45309;">0</div>
                            </div>
                            <div class="teacher-app-stats-btn-tile">
                                <button id="btn-create-block-homework-inline" class="btn btn-primary" style="width:100%; height:100%; min-height:45px; white-space:nowrap; font-size:14px; padding:8px 12px; display:none;">Ödev Ver</button>
                            </div>
                    </div>
                </div>
                <div id="block-homework-filters" class="filter-bar" style="display:none;">
                </div>
                <div id="block-homework-split-head" class="status-split-head">
                    <div class="col-title">Bekleyen</div>
                    <div class="col-title">Tamamlanan</div>
                </div>
                <div id="block-homework-split" class="status-split">
                    <div id="block-homework-pending" class="tab-content active">
                        <ul id="list-block-homework-pending" style="padding:0; margin:0; list-style:none;"></ul>
                        <div id="no-block-homework-pending" class="empty-state" style="display:none;">
                            <div class="empty-state-icon">🧩</div>
                            Bekleyen blok kodlama ödevi yok.
                        </div>
                    </div>
                    <div id="block-homework-completed" class="tab-content">
                        <ul id="list-block-homework-completed" style="padding:0; margin:0; list-style:none;"></ul>
                        <div id="no-block-homework-completed" class="empty-state" style="display:none;">
                            <div class="empty-state-icon">✅</div>
                            Tamamlanan blok kodlama ödevi yok.
                        </div>
                    </div>
                </div>
                <button id="btn-show-all-block-homework" class="btn btn-primary" style="width: 100%; display: none; margin-top: 10px;">Daha Fazla Göster</button>
                <div id="compute-homework-section" style="margin-top:0; padding-top:0; border-top:none;">
                    <h3 id="compute-homework-title" style="display:none; margin:0;">🧠 Compute It Ödevi</h3>
                    <div id="compute-homework-tabs" class="tabs" style="display:none; margin-top:10px;">
                        <button class="tab-btn active" onclick="switchComputeHomeworkTab('pending')">Bekleyen</button>
                        <button class="tab-btn" onclick="switchComputeHomeworkTab('completed')">Tamamlanan</button>
                    </div>
                    <div id="compute-homework-teacher-stats" class="teacher-app-stats" style="display:none;">
                        <div class="teacher-app-stats-title">Verilen Toplam Compute It Ödevi: <strong id="teacher-compute-homework-count">0</strong></div>
                        <div class="teacher-app-stats-grid">
                            <div class="teacher-app-stats-tile">
                                <div style="font-size:11px; color:#64748b;">Tamamlayan Öğrenci</div>
                                <div id="teacher-compute-homework-completed-students" style="font-size:18px; font-weight:700; color:#1e3a8a;">0</div>
                            </div>
                            <div class="teacher-app-stats-tile">
                                <div style="font-size:11px; color:#64748b;">Ortalama İlerleme</div>
                                <div id="teacher-compute-homework-avg-progress" style="font-size:18px; font-weight:700; color:#0f766e;">%0</div>
                            </div>
                            <div class="teacher-app-stats-tile">
                                <div style="font-size:11px; color:#64748b;">Toplam XP</div>
                                <div id="teacher-compute-homework-total-xp" style="font-size:18px; font-weight:700; color:#b45309;">0</div>
                            </div>
                            <div class="teacher-app-stats-btn-tile">
                                <button id="btn-create-compute-homework-inline" class="btn btn-primary" style="width:100%; height:100%; min-height:45px; white-space:nowrap; font-size:14px; padding:8px 12px; display:none;">Ödev Ver</button>
                            </div>
                        </div>
                    </div>
                    <div id="compute-homework-filters" class="filter-bar" style="display:none;">
                    </div>
                    <div id="compute-homework-split-head" class="status-split-head">
                        <div class="col-title">Bekleyen</div>
                        <div class="col-title">Tamamlanan</div>
                    </div>
                    <div id="compute-homework-split" class="status-split">
                        <div id="compute-homework-pending" class="tab-content active">
                            <ul id="list-compute-homework-pending" style="padding:0; margin:0; list-style:none;"></ul>
                            <div id="no-compute-homework-pending" class="empty-state" style="display:none;">
                                <div class="empty-state-icon">🧠</div>
                                Bekleyen Compute It ödevi yok.
                            </div>
                        </div>
                        <div id="compute-homework-completed" class="tab-content">
                            <ul id="list-compute-homework-completed" style="padding:0; margin:0; list-style:none;"></ul>
                            <div id="no-compute-homework-completed" class="empty-state" style="display:none;">
                                <div class="empty-state-icon">✅</div>
                                Tamamlanan Compute It ödevi yok.
                            </div>
                        </div>
                    </div>
                    <button id="btn-show-all-compute-homework" class="btn btn-primary" style="width: 100%; display: none; margin-top: 10px;">Daha Fazla Göster</button>
                </div>
            </div>
                </div>
            </div>

            <div id="teacher-lessons-modal" class="modal-overlay" style="display:none; z-index:23000;">
                <div class="modal-content modal-large" style="width:min(96vw,1400px); height:92vh; max-width:none; display:flex; flex-direction:column;">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:10px; margin-bottom:10px;">
                        <h2 style="margin:0;">📖 Derslerim</h2>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <button id="btn-open-lesson-builder-from-modal" class="btn btn-primary">Ders Oluştur</button>
                            <button id="btn-close-teacher-lessons-modal" class="btn" style="background:#e2e8f0;">Kapat</button>
                        </div>
                    </div>
                    <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px;">
                        <button id="btn-teacher-lessons-filter-all" class="btn btn-primary" type="button">Tümü</button>
                        <button id="btn-teacher-lessons-filter-draft" class="btn" type="button" style="background:#fff7ed;color:#9a3412;">Taslak</button>
                        <button id="btn-teacher-lessons-filter-published" class="btn" type="button" style="background:#dcfce7;color:#166534;">Yayında</button>
                    </div>
                    <div id="teacher-lessons-modal-meta" style="font-size:13px;color:#64748b;margin-bottom:8px;"></div>
                    <div style="flex:1;min-height:0;overflow:auto;">
                        <ul id="teacher-lessons-modal-list" style="padding:0; margin:0; list-style:none; display:flex; flex-direction:column; gap:8px;"></ul>
                        <div id="teacher-lessons-modal-empty" class="empty-state" style="display:none;">
                            <div class="empty-state-icon">📌</div>
                            Ders bulunamadı.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liderlik Tablosu (Öğrenci) - moved into hero side -->
            <!-- (original instance removed, moved into hero-side earlier) -->

        </div>

        <div id="leaderboard-modal" class="modal-overlay" style="display:none; z-index:21000;">
            <div class="modal-content modal-large" style="max-width:980px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <h2 style="margin:0;">Başarı Listesi</h2>
                    <button id="btn-close-leaderboard-modal" class="btn" style="background:#eee;">Kapat</button>
                </div>
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px;">
                    <select id="leaderboard-filter-class" class="form-control" style="max-width:170px;">
                        <option value="">Tüm Sınıflar</option>
                    </select>
                    <select id="leaderboard-filter-section" class="form-control" style="max-width:170px;">
                        <option value="">Tüm Şubeler</option>
                    </select>
                </div>
                <div id="leaderboard-modal-list" style="max-height:520px; overflow:auto; display:flex; flex-direction:column; gap:8px;"></div>
            </div>
        </div>

        <!-- Aktivite Detay Ekranı -->
        <div id="activity-detail" style="display: none;" class="card">
            <button id="btn-back" class="btn btn-primary" style="margin-bottom: 20px;">↩️ Vazgeç ve Geri Dön</button>
            <div class="progress-bar"><div id="game-progress" class="progress-fill" style="width: 0%"></div></div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h2 id="detail-title" style="margin: 0;"></h2>
                <span class="time-badge" id="game-timer">⏱️ 00:00</span>
            </div>
            <div id="dynamic-game-container"></div>
            <div id="game-results" style="display: none; text-align: center; padding: 20px;">
                <h3 style="color: var(--success);">🎉 Tebrikler!</h3>
                <p id="result-text"></p>
                <div id="time-result" style="margin-top: 15px; padding: 10px; background: #e3f2fd; border-radius: 8px;"></div>
            </div>
            <button id="btn-complete" class="btn btn-success" style="width: 100%; display: none; margin-top: 20px;">Kaydet ve Bitir</button>
        </div>
    </div>

    <!-- Görev Modal -->
    <div id="task-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2 id="modal-display-title"></h2>
            <p id="modal-display-desc"></p>
            
            <div id="modal-deadline" style="display: none; margin: 10px 0; padding: 8px; background: #fff3cd; border-radius: 8px; text-align: center; font-size: 0.9rem;">
                <strong>Son Teslim:</strong> <span id="modal-deadline-text"></span>
            </div>
            
            <div id="modal-stats" style="display: none; background: #f8f9fa; padding: 10px; border-radius: 8px; margin: 15px 0; font-size: 0.9rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span>Tamamlayan: <strong id="modal-completed-count">0</strong> öğrenci</span>
                    <span>Ortalama Başarı: <strong id="modal-avg-score">0%</strong></span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Ortalama Süre: <strong id="modal-avg-time">0 dk</strong></span>
                    <span>En Hızlı: <strong id="modal-best-time">-</strong></span>
                </div>
            </div>
            
            <div id="teacher-actions" style="display: none; gap: 10px; margin-bottom: 10px;">
                <button id="btn-edit-task" class="btn btn-primary" style="flex: 1;">✏️ Düzenle</button>
                <button id="btn-delete-task" class="btn btn-danger" style="flex: 1;">🗑️ Sil</button>
            </div>
            <div id="book-approval-section" style="display:none; margin-bottom:10px; padding:10px; background:#f8fafc; border-radius:8px; border:1px solid #e5e7eb;">
                <div id="book-approval-title" style="font-weight:600; margin-bottom:6px;">📘 Kitap/Test Ödevi Onayı</div>
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:8px;">
                    <select id="book-approve-class" class="form-control" style="max-width:160px;">
                        <option value="">Sınıf</option>
                    </select>
                    <select id="book-approve-section" class="form-control" style="max-width:160px;">
                        <option value="">Şube</option>
                    </select>
                </div>
                <div id="book-approval-list" style="max-height:220px; overflow-y:auto;"></div>
                <button id="btn-book-approve" class="btn btn-success" style="width:100%; margin-top:8px;">Seçilenleri Onayla</button>
            </div>
            
            <div id="edit-section" class="edit-section" style="display: none;">
                <h4>Ödevi Düzenle</h4>
                <input type="text" id="edit-title" class="form-control" placeholder="Yeni Başlık">
                <input type="text" id="edit-desc" class="form-control" placeholder="Yeni Açıklama">
                <div style="display:flex; gap:10px; margin-bottom:10px;">
                    <div style="flex:1;">
                        <label><small>Kitap (Opsiyonel):</small></label>
                        <select id="edit-book" class="form-control">
                            <option value="">Kitap seçiniz</option>
                        </select>
                    </div>
                    <div style="flex:1;">
                        <label><small>Test (Opsiyonel):</small></label>
                        <select id="edit-book-test" class="form-control" disabled>
                            <option value="">Test seçiniz</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="date" id="edit-deadline" class="form-control date-input">
                    <input type="time" id="edit-deadline-time" class="form-control date-input">
                </div>
                
                <h5 style="margin-top: 15px; margin-bottom: 10px;">Sorular</h5>
                <div id="edit-questions-list" style="max-height: 300px; overflow-y: auto; margin-bottom: 15px;"></div>
                
                <button id="btn-add-new-question" class="btn btn-warning" style="width: 100%; margin-bottom: 10px;">➕ Yeni Soru Ekle</button>
                
                <div style="display: flex; gap: 10px;">
                    <button id="btn-save-edit" class="btn btn-success" style="flex: 1;">💾 Tüm Değişiklikleri Kaydet</button>
                    <button id="btn-cancel-edit" class="btn" style="flex: 1; background: #eee;">İptal</button>
                </div>
            </div>
            
            <div id="student-actions" style="display: none;">
                <button id="btn-start-activity" class="btn btn-success" style="width: 100%;">Hadi Başlayalım!</button>
                <div id="completed-info" style="display: none; margin-top: 15px; padding: 15px; background: #d4edda; border-radius: 8px; text-align: center;">
                    <p style="margin: 0; color: #155724;">✅ Bu ödevi tamamladınız!</p>
                    <p id="completed-score" style="margin: 5px 0 0 0; font-weight: bold; color: var(--success);"></p>
                    <p id="completed-time" style="margin: 5px 0 0 0; font-size: 0.9rem; color: #666;"></p>
                </div>
                <div id="book-task-actions" style="display:none; margin-top: 12px; padding: 12px; background:#f8fafc; border-radius:10px; border:1px solid #e5e7eb;">
                    <div id="book-task-title" style="font-weight:600; margin-bottom:6px;">📗 Kitap/Test Ödevi</div>
                    <div id="book-task-status" style="color:#666; font-size:0.9rem; margin-bottom:8px;">Durum: Başlanmadı</div>
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <button id="btn-book-started" class="btn btn-primary" style="flex:1;">Yapmaya Başladım</button>
                        <button id="btn-book-finished" class="btn btn-success" style="flex:1;">Bitirdim</button>
                    </div>
                    <small id="book-task-note" style="display:block; margin-top:8px; color:#888;">Not: Bitirdim dediğinizde öğretmen onayı gerekir.</small>
                </div>
            </div>
            
            <button id="close-task-modal" class="btn" style="width: 100%; margin-top: 10px; background: #eee;">Kapat</button>
        </div>
    </div>

    <!-- Ödev Oluştur Modal -->
    <div id="create-task-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="margin: 0;">Yeni Ödev Oluştur</h2>
                <button id="btn-close-create" class="btn" style="background: #eee;">Kapat</button>
            </div>
            <div id="teacher-panel" class="card" style="display: none;">
                <h3>🧪 Yeni Karma Ödev Oluştur</h3>
                <input type="text" id="task-title" placeholder="Ödev Başlığı" class="form-control">
                <input type="text" id="task-desc" placeholder="Ödev Açıklaması (Opsiyonel)" class="form-control">
                <select id="task-target" class="form-control">
                    <option value="all">Tüm Sınıflar</option>
                </select>
                <div style="display:flex; gap:10px; margin-bottom:10px;">
                    <div style="flex:1;">
                        <label><small>Sınıf:</small></label>
                        <select id="task-target-class" class="form-control">
                            <option value="">Sınıf</option>
                        </select>
                    </div>
                    <div style="flex:1;">
                        <label><small>Şube:</small></label>
                        <select id="task-target-section" class="form-control">
                            <option value="">Şube</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; color: #666; font-size: 0.9rem;"><small>Son Teslim Tarihi:</small></label>
                        <input type="date" id="task-deadline" class="form-control date-input" style="margin-bottom: 0;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; color: #666; font-size: 0.9rem;"><small>Saat (Opsiyonel):</small></label>
                        <input type="time" id="task-deadline-time" class="form-control date-input" style="margin-bottom: 0;">
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-bottom:10px;">
                    <div style="flex:1;">
                        <label><small>Kitap (Opsiyonel):</small></label>
                        <select id="task-book" class="form-control">
                            <option value="">Kitap seçiniz</option>
                        </select>
                    </div>
                    <div style="flex:1;">
                        <label><small>Test (Opsiyonel):</small></label>
                        <select id="task-book-test" class="form-control" disabled>
                            <option value="">Test seçiniz</option>
                        </select>
                    </div>
                </div>
                
                <button id="btn-save-task" class="btn btn-success" style="width: 100%;">ÖDEVİ YAYINLA</button>
            </div>
        </div>
    </div>

    <!-- İçerik Ekle / İçerikler -->
    <div id="content-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large" style="max-width: 1280px; width: 96vw; height: 90vh; margin: 0 auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
                <h2 style="margin:0;">İçerikler</h2>
                <button id="btn-close-content" class="btn" style="background:#eee;">Kapat</button>
            </div>
            <div class="content-layout" style="margin-top:12px;">
                <div class="content-left">
                    <div style="display:flex; gap:8px; margin-bottom:10px;">
                        <button id="btn-new-content" class="btn btn-primary" style="flex:1;">Yeni İçerik</button>
                    </div>
                    <div id="content-list"></div>
                </div>
                <div class="content-right">
                    <!-- Öğretmen düzenleme alanı -->
                    <div id="content-editor" style="display:none;">
                        <div class="card" style="margin-bottom:10px;">
                            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                <input id="content-title" class="form-control" placeholder="İçerik Başlığı">
                                <input id="content-desc" class="form-control" placeholder="Kısa Açıklama">
                                <input id="content-target-class" class="form-control" placeholder="Hedef Sınıf (örn: 9)">
                                <input id="content-target-section" class="form-control" placeholder="Hedef Şube (örn: A)">
                            </div>
                        </div>
                        <div class="card" style="margin-bottom:10px;">
                            <div style="font-weight:600; margin-bottom:8px;">İçerik Öğeleri</div>
                            <div id="content-items"></div>
                            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:8px;">
                                <button id="btn-add-heading" class="btn btn-primary">Başlık</button>
                                <button id="btn-add-paragraph" class="btn btn-primary">Metin</button>
                                <button id="btn-add-image" class="btn btn-primary">Görsel</button>
                                <button id="btn-add-video" class="btn btn-primary">Video</button>
                                <button id="btn-add-quiz" class="btn btn-primary">Çoktan Seçmeli</button>
                                <button id="btn-add-truefalse" class="btn btn-primary">Doğru/Yanlış</button>
                                <button id="btn-add-short" class="btn btn-primary">Kısa Cevap</button>
                                <button id="btn-add-app" class="btn btn-primary">Uygulama</button>
                                <button id="btn-add-line-trace-app" class="btn btn-warning">Çizgi Oyunu</button>
                                <button id="btn-add-sample" class="btn btn-warning">Örnek İçerik</button>
                            </div>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <button id="btn-save-content" class="btn btn-success" style="flex:1;">Kaydet</button>
                            <button id="btn-preview-content" class="btn btn-primary" style="flex:1;">Önizleme</button>
                        </div>
                        <div style="display:flex; gap:8px; margin-top:8px;">
                            <button id="btn-assign-content" class="btn btn-warning" style="flex:1;">Ödev Olarak Ver</button>
                        </div>
                        <div style="display:flex; gap:8px; margin-top:8px;">
                            <button id="btn-delete-content" class="btn btn-danger" style="flex:1;">İçeriği Sil</button>
                        </div>
                        <div style="display:flex; gap:8px; margin-top:8px; flex-wrap:wrap;">
                            <input id="content-assign-deadline" type="date" class="form-control date-input" placeholder="Son tarih">
                            <input id="content-assign-deadline-time" type="time" class="form-control date-input" placeholder="Saat">
                        </div>
                    </div>
                    <!-- Öğrenci görüntüleme alanı -->
                    <div id="content-viewer" style="display:none;">
                        <div class="content-viewer-wrap">
                            <div class="content-left-pane">
                                <div id="content-viewer-header" class="card" style="margin-bottom:10px;"></div>
                                <div id="content-viewer-body"></div>
                            </div>
                            <div class="content-right-pane">
                                <div class="app-workspace" id="app-workspace">
                                    <div class="app-topbar">
                                        <div class="app-topbar-left">
                                            <div id="app-title" class="app-title">Uygulama</div>
                                            <div id="app-link" class="app-link">Uygulama linki yok</div>
                                            <div id="app-timer" class="app-timer">⏱️ 0 dk 0 sn</div>
                                        </div>
                                        <div class="app-topbar-actions">
                                            <button id="btn-app-open" class="app-btn primary">Başlat</button>
                                            <button id="btn-app-fullscreen" class="app-btn primary">Tam Ekran</button>
                                            <button id="btn-app-save" class="app-btn warn">Kaydet</button>
                                            <button id="btn-app-stop" class="app-btn danger">Durdur</button>
                                            <button id="btn-app-exit" class="app-btn danger">Çık</button>
                                        </div>
                                    </div>
                                    <div class="app-frame-area">
                                        <iframe id="content-app-iframe" src="about:blank"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="content-empty" class="empty-state" style="display:none;">
                        İçerik seçiniz.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Etkinlik Görüntüle Modal (Öğrenci) -->
    <div id="activity-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large" style="max-width: 1400px; width: 98vw; height: 96vh; margin: 0 auto; display:flex; flex-direction:column;">
            <div id="activity-fullbar" class="activity-fullbar">
                <div class="left">
                    <span id="activity-full-title">Uygulama</span>
                    <span id="activity-full-timer">⏱️ 0 dk 0 sn</span>
                </div>
                <div class="right">
                    <button id="btn-activity-full-start" class="btn">Başlat</button>
                    <button id="btn-activity-full-save" class="btn">Kaydet</button>
                    <button id="btn-activity-full-exit" class="btn exit">Tam Ekrandan Çık</button>
                </div>
            </div>
            <div class="modal-header" style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:10px;">
                <h2 style="margin:0;">Etkinlik</h2>
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; justify-content:flex-end;">
                    <div class="activity-header-actions" id="activity-header-actions">
                        <button id="btn-activity-head-add-level" class="app-btn primary">Seviye Ekle</button>
                        <button id="btn-activity-head-edit-level" class="app-btn warn">Seviye Düzenle</button>
                        <button id="btn-activity-head-delete-level" class="app-btn danger">Seviye Sil</button>
                        <button id="btn-activity-head-start" class="app-btn primary">Başlat</button>
                        <button id="btn-activity-head-save" class="app-btn warn">Kaydet</button>
                        <button id="btn-activity-head-exit" class="app-btn danger">Çık</button>
                        <span id="block-runner-timer" class="app-timer">⏱️ 0 dk 0 sn</span>
                    </div>
                    <button id="btn-close-activity" class="btn" style="background:#eee;">Kapat</button>
                </div>
            </div>
                <div class="activity-layout">
                    <div class="activity-left">
                    <div id="activity-title" class="activity-title">Uygulama</div>
                    <div id="activity-link" class="activity-link">Link yok</div>
                    <div class="activity-timer" id="activity-timer">⏱️ 0 dk 0 sn</div>
                    <div class="activity-actions">
                        <button id="btn-activity-start" class="app-btn primary">Başlat</button>
                        <button id="btn-activity-fullscreen" class="app-btn primary">Tam Ekran</button>
                        <button id="btn-activity-save" class="app-btn warn">Kaydet</button>
                        <button id="btn-activity-exit" class="app-btn danger">Çık</button>
                    </div>
                    </div>
                    <div class="activity-right">
                        <div id="activity-frame-status" class="activity-frame-status"></div>
                        <div class="activity-pause-overlay">
                            <div class="activity-pause-card">
                                <div id="activity-pause-title" class="pause-title" style="font-weight:700;">Duraklatıldı</div>
                                <button id="btn-activity-resume" class="btn btn-play-resume" title="Devam Et" aria-label="Devam Et">▶</button>
                            </div>
                        </div>
                        <iframe id="activity-iframe" src="about:blank" scrolling="no"></iframe>
                    </div>
                </div>
                <div id="external-app-overlay" class="modal-overlay" style="display:none;">
                    <div class="modal-content" style="max-width:420px; text-align:center;">
                        <h3 style="margin-top:0;">Uygulama Yeni Sekmede Açıldı</h3>
                        <p style="color:#666;">Paneline döndüğünde ilerlemeni kaydedebilirsin.</p>
                        <button id="btn-external-open" class="btn btn-primary" style="width:100%;">Uygulamayı Yeni Sekmede Aç</button>
                        <button id="btn-external-save" class="btn btn-success" style="width:100%; margin-top:8px;">Kaydet ve Bitir</button>
                        <button id="btn-external-close" class="btn" style="width:100%; margin-top:10px; background:#eee;">Kapat</button>
                    </div>
                </div>
        </div>
    </div>

    <!-- Etkinlik Düzenle Modal -->
    <div id="assignment-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
                <h2 style="margin:0;">Etkinlik Düzenle</h2>
                <button id="btn-close-assignment" class="btn" style="background:#eee;">Kapat</button>
            </div>
            <input id="assignment-title" class="form-control" placeholder="Etkinlik Başlığı">
            <input id="assignment-desc" class="form-control" placeholder="Açıklama">
            <input id="assignment-class" class="form-control" placeholder="Hedef Sınıf (örn: 9)">
            <input id="assignment-section" class="form-control" placeholder="Hedef Şube (örn: A)">
            <div style="display:flex; gap:8px;">
                <input id="assignment-deadline" type="date" class="form-control date-input">
                <input id="assignment-deadline-time" type="time" class="form-control date-input">
            </div>
            <div style="display:flex; gap:8px; margin-top:8px;">
                <button id="btn-save-assignment" class="btn btn-success" style="flex:1;">Kaydet</button>
                <button id="btn-delete-assignment" class="btn btn-danger" style="flex:1;">Sil</button>
            </div>
            <div id="assignment-students-section" style="margin-top:12px; padding:10px; background:#f8fafc; border-radius:10px; border:1px solid #e5e7eb; display:none;">
                <div style="font-weight:600; margin-bottom:6px;">👥 Öğrenci Durumu</div>
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:8px;">
                    <select id="assignment-filter-class" class="form-control" style="max-width:160px;">
                        <option value="">Sınıf</option>
                    </select>
                    <select id="assignment-filter-section" class="form-control" style="max-width:160px;">
                        <option value="">Şube</option>
                    </select>
                </div>
                <div id="assignment-students-list" style="max-height:220px; overflow-y:auto;"></div>
            </div>
        </div>
    </div>

    <!-- Silme Onay Modal -->
    <div id="confirm-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content confirm-shell">
            <div class="confirm-head">
                <div class="confirm-icon">!</div>
                <h3 class="confirm-title">Onay Gerekli</h3>
            </div>
            <div id="confirm-message" class="confirm-message">Silmek istiyor musunuz?</div>
            <div class="confirm-actions">
                <button id="btn-confirm-yes" class="btn btn-danger" style="flex:1;">Evet, Sil</button>
                <button id="btn-confirm-no" class="btn" style="flex:1; background:#eee;">Vazgeç</button>
            </div>
        </div>
    </div>

      <!-- Bilgi Modal -->
      <div id="info-modal" class="modal-overlay" style="display: none;">
          <div id="info-modal-shell" class="modal-content info-shell" style="max-width:460px;">
              <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                  <div id="info-icon" style="width:36px; height:36px; border-radius:12px; background:#e0f2fe; color:#0284c7; display:flex; align-items:center; justify-content:center; font-weight:700;">i</div>
                  <h3 id="info-title" style="margin:0;">Bilgi</h3>
              </div>
              <div id="info-message" style="margin-bottom:16px; color:#374151;">Bilgi mesajı</div>
              <div style="display:flex; gap:8px;">
                  <button id="btn-info-ok" class="btn btn-primary" style="flex:1;">Tamam</button>
                  <button id="btn-info-continue" class="btn btn-continue-play" style="flex:1; display:none;" title="Devam Et" aria-label="Devam Et"><span class="play-ico">▶</span></button>
              </div>
          </div>
      </div>

    <!-- Öğrenci Detay Modal -->
    <div id="student-detail-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
                <h2 id="student-detail-name" style="margin:0;">Öğrenci Detayı</h2>
                <div style="display:flex; gap:8px; align-items:center;">
                    <button id="btn-download-student-pdf" class="btn btn-primary">PDF İndir</button>
                    <button onclick="closeStudentDetail()" class="btn" style="background: #eee;">Kapat</button>
                </div>
            </div>
            
            <div class="stat-detail-grid">
                <div class="stat-detail-item">
                    <div class="stat-detail-value" id="detail-total-tasks">0</div>
                    <div class="stat-detail-label">Toplam Ödev</div>
                </div>
                <div class="stat-detail-item">
                    <div class="stat-detail-value" id="detail-completed">0</div>
                    <div class="stat-detail-label">Tamamlanan</div>
                </div>
                <div class="stat-detail-item">
                    <div class="stat-detail-value" id="detail-success-rate">0%</div>
                    <div class="stat-detail-label">Başarı Oranı</div>
                </div>
                <div class="stat-detail-item">
                    <div class="stat-detail-value" id="detail-avg-time">0 dk</div>
                    <div class="stat-detail-label">Sistemde Geçen Süre</div>
                </div>
                <div class="stat-detail-item">
                    <div class="stat-detail-value" id="detail-total-xp">0</div>
                    <div class="stat-detail-label">Toplam XP</div>
                </div>
                <div class="stat-detail-item">
                    <div class="stat-detail-value" id="detail-rank">-</div>
                    <div class="stat-detail-label">Sıralama</div>
                </div>
            </div>

            <div style="margin: 8px 0 16px;">
                <h4 style="margin: 0 0 8px 0;">Kazanılan Rozetler</h4>
                <div id="student-detail-badges" class="badges-grid"></div>
            </div>
            
            <div class="chart-container">
                <canvas id="studentChart"></canvas>
            </div>
            
            <div style="display: flex; gap: 16px; flex-wrap: wrap; margin-top: 20px;">
                <div style="flex: 1; min-width: 260px;">
                    <h4 style="margin: 0 0 8px 0;">Ödev Geçmişi</h4>
                    <div id="student-activity-history" style="max-height: 300px; overflow-y: auto;"></div>
                </div>
                <div style="flex: 1; min-width: 260px;">
                    <h4 style="margin: 0 0 8px 0;">Etkinlik Geçmişi</h4>
                    <div id="student-content-history" style="max-height: 300px; overflow-y: auto;"></div>
                </div>
                <div style="flex: 1; min-width: 260px;">
                    <h4 style="margin: 0 0 8px 0;">Quiz Geçmişi</h4>
                    <div class="chart-container" style="height:180px; margin-bottom:8px;">
                        <canvas id="studentQuizChart"></canvas>
                    </div>
                    <div id="student-quiz-history" style="max-height: 300px; overflow-y: auto;"></div>
                </div>
                <div style="flex: 1 1 100%; margin-top: 12px;">
                    <h4 style="margin: 0 0 8px 0;">Blok Kodlama</h4>
                    <div id="student-blockrun-report" style="background:#fff; border:1px solid #e5e7eb; padding:12px; border-radius:10px; max-height:220px; overflow:auto;">
                        <div id="blockrun-summary">Veri yükleniyor...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Öğrencilerim Modal -->
    <div id="students-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="margin: 0;">Öğrencilerim</h2>
                <div style="display:flex; gap:8px; align-items:center;">
                    <button id="btn-delete-all-students" class="btn btn-danger">Tüm Öğrencileri Sil</button>
                    <button id="btn-reset-all-students-passwords" class="btn btn-warning">Tüm Şifreleri 123456 Yap</button>
                    <button id="btn-close-students" class="btn" style="background: #eee;">Kapat</button>
                </div>
            </div>
            <div class="filter-bar" style="margin-bottom: 10px;">
                <select id="students-filter-scope" class="form-control" style="max-width: 200px;">
                    <option value="all">Tüm Öğrenciler</option>
                    <option value="class">Sınıfa Göre</option>
                </select>
                <select id="students-filter-class" class="form-control" style="max-width: 120px;">
                    <option value="">Sınıf</option>
                </select>
                <select id="students-filter-section" class="form-control" style="max-width: 120px;">
                    <option value="">Şube</option>
                </select>
            </div>
            <div id="students-list" style="max-height: 500px; overflow-y: auto;"></div>
        </div>
    </div>
    <div id="login-cards-modal" class="modal-overlay" style="display:none; z-index:23010;">
        <div class="modal-content login-cards-modal-content">
            <div class="login-cards-toolbar">
                <div>
                    <h3 style="margin:0;">🪪 Giriş Kartları</h3>
                    <small id="login-cards-summary" style="color:#64748b;">Öğrenciler yükleniyor...</small>
                </div>
                <div style="display:flex; gap:8px;">
                    <button id="btn-print-login-cards" class="btn btn-primary">Yazdır</button>
                    <button id="btn-close-login-cards" class="btn" style="background:#eee;">Kapat</button>
                </div>
            </div>
            <div id="login-cards-grid" class="login-cards-grid"></div>
        </div>
    </div>

    <!-- Blok Kodlama Ödevi Ver Modal -->
    <div id="block-homework-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content homework-assign-shell">
            <div class="homework-assign-head">
                <h3 id="block-homework-modal-title" style="margin:0;">Blok Kodlama Ödevi Ver</h3>
                <button id="btn-close-block-homework-modal" class="btn homework-assign-close">Kapat</button>
            </div>
            <input id="block-hw-assignment-type" type="hidden" value="block2d">
            <div class="form-group">
                <label>Ödev Başlığı</label>
                <input id="block-hw-title" class="form-control" type="text" placeholder="Örn: Blok Kodlama Ödevi - 1">
            </div>
            <div class="form-group">
                <label>Sınıf (boş = tümü)</label>
                <input id="block-hw-class" class="form-control" type="text" placeholder="Örn: 5A">
            </div>
            <div class="form-group">
                <label>Şube (opsiyonel)</label>
                <input id="block-hw-section" class="form-control" type="text" placeholder="Örn: A">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                <div class="form-group">
                    <label>Son Tarih</label>
                    <input id="block-hw-deadline" class="form-control" type="date">
                </div>
                <div class="form-group">
                    <label>Saat</label>
                    <input id="block-hw-deadline-time" class="form-control" type="time" value="23:59">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                <div class="form-group">
                    <label>Başlangıç Seviye</label>
                    <input id="block-hw-level-start" class="form-control" type="number" min="1" value="1">
                </div>
                <div class="form-group">
                    <label>Bitiş Seviye</label>
                    <input id="block-hw-level-end" class="form-control" type="number" min="1" value="1">
                </div>
            </div>
            <small class="homework-assign-hint">Sadece seçtiğiniz seviye aralığı öğrenciye açık olur.</small>
            <div class="homework-assign-actions">
                <button id="btn-save-block-homework" class="btn homework-assign-save">Kaydet</button>
                <button id="btn-delete-block-homework" class="btn homework-assign-delete" style="display:none;">Sil</button>
            </div>
        </div>
    </div>

    <!-- Compute It Ödevi Ver Modal -->
    <div id="compute-homework-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content homework-assign-shell">
            <div class="homework-assign-head">
                <h3 style="margin:0;">Compute It Ödevi Ver</h3>
                <button id="btn-close-compute-homework-modal" class="btn homework-assign-close">Kapat</button>
            </div>
            <div class="form-group">
                <label>Ödev Başlığı</label>
                <input id="compute-hw-title" class="form-control" type="text" placeholder="Örn: Compute It Ödevi - 1">
            </div>
            <div class="form-group">
                <label>Sınıf (boş = tümü)</label>
                <input id="compute-hw-class" class="form-control" type="text" placeholder="Örn: 5A">
            </div>
            <div class="form-group">
                <label>Şube (opsiyonel)</label>
                <input id="compute-hw-section" class="form-control" type="text" placeholder="Örn: A">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                <div class="form-group">
                    <label>Son Tarih</label>
                    <input id="compute-hw-deadline" class="form-control" type="date">
                </div>
                <div class="form-group">
                    <label>Saat</label>
                    <input id="compute-hw-deadline-time" class="form-control" type="time" value="23:59">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                <div class="form-group">
                    <label>Başlangıç Seviye</label>
                    <input id="compute-hw-level-start" class="form-control" type="number" min="1" value="1">
                </div>
                <div class="form-group">
                    <label>Bitiş Seviye</label>
                    <input id="compute-hw-level-end" class="form-control" type="number" min="1" value="1">
                </div>
            </div>
            <small class="homework-assign-hint">Sadece seçtiğiniz seviye aralığı öğrenciye açık olur.</small>
            <div class="homework-assign-actions">
                <button id="btn-save-compute-homework" class="btn homework-assign-save">Kaydet</button>
                <button id="btn-delete-compute-homework" class="btn homework-assign-delete" style="display:none;">Sil</button>
            </div>
        </div>
    </div>

    <!-- Öğrenci Ekle Modal -->
    <div id="add-student-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="margin: 0;">Öğrenci Ekle</h2>
                <button id="btn-close-add-student" class="btn" style="background: #eee;">Kapat</button>
            </div>

            <h4 style="margin: 10px 0;">Tekli Kayıt</h4>
            <div style="display:flex; gap:10px;">
                <input type="text" id="add-student-firstname" class="form-control" placeholder="Ad">
                <input type="text" id="add-student-lastname" class="form-control" placeholder="Soyad">
            </div>
            <input type="text" id="add-student-username" class="form-control" placeholder="Kullanıcı Adı (e-posta olabilir)">
            <input type="password" id="add-student-password" class="form-control" placeholder="Şifre (en az 6 karakter)">
            <div style="display:flex; gap:10px;">
                <select id="add-student-class" class="form-control">
                    <option value="">Sınıf seçin</option>
                </select>
                <select id="add-student-section" class="form-control">
                    <option value="">Şube seçin</option>
                </select>
            </div>
            <button id="btn-add-student-save" class="btn btn-success" style="width: 100%; margin-top: 8px;">Kaydet</button>

            <hr style="margin: 18px 0;">

            <h4 style="margin: 10px 0;">Toplu Kayıt (CSV)</h4>
            <small style="color:#666; display:block; margin-bottom:6px;">
                Satır formatı: Ad, Soyad, Kullanıcı Adı, Şifre, Sınıf, Şube
            </small>
            <div style="display:flex; gap:10px; flex-wrap: wrap; margin-bottom:8px;">
                <button id="btn-download-student-template" class="btn btn-primary" style="flex:1;">⬇️ Örnek Excel (CSV) İndir</button>
                <input type="file" id="bulk-students-file" class="form-control" accept=".csv,.xlsx,.xls" style="flex:1;">
            </div>
            <textarea id="bulk-students-input" class="form-control" rows="6" placeholder="Örn:
Ali, Veli, ali, 123456, 9, A
Ayşe, Yılmaz, ayse, 123456, 9, B"></textarea>
            <input type="password" id="bulk-default-password" class="form-control" placeholder="Varsayılan Şifre (boş olanlar için)">
            <button id="btn-bulk-student-save" class="btn btn-primary" style="width: 100%; margin-top: 8px;">Toplu Kayıt</button>
        </div>
    </div>

    <!-- Kitap Ekle Modal -->
    <div id="books-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:10px;">
                <h2 style="margin:0;">Kitap Ekle</h2>
                <button id="btn-close-books" class="btn" style="background:#eee;">Kapat</button>
            </div>
            <h4 style="margin: 10px 0;">Tekli Kayıt</h4>
            <input type="text" id="book-name" class="form-control" placeholder="Kitap Adı">
            <input type="text" id="book-tests" class="form-control" placeholder="Testler (virgülle ayırın)">
            <button id="btn-save-book" class="btn btn-success" style="width:100%; margin-top:8px;">Kaydet</button>

            <hr style="margin: 18px 0;">

            <h4 style="margin: 10px 0;">Toplu Kayıt (CSV / Excel)</h4>
            <small style="color:#666; display:block; margin-bottom:6px;">
                Satır formatı: Kitap Adı, Testler (Test1|Test2|Test3)
            </small>
            <div style="display:flex; gap:10px; flex-wrap: wrap; margin-bottom:8px;">
                <button id="btn-download-book-template" class="btn btn-primary" style="flex:1;">⬇️ Örnek Şablon İndir</button>
                <input type="file" id="bulk-books-file" class="form-control" accept=".csv,.xlsx,.xls" style="flex:1;">
            </div>
            <hr style="margin: 18px 0;">
            <h4 style="margin: 10px 0;">Kayıtlı Kitaplar</h4>
            <div style="display:flex; gap:10px; flex-wrap: wrap;">
                <select id="books-list" class="form-control" style="flex:1;">
                    <option value="">Kitap seçiniz</option>
                </select>
                <button id="btn-clear-book" class="btn btn-danger">Temizle</button>
            </div>
            <select id="books-tests" class="form-control" style="margin-top:8px;" disabled>
                <option value="">Testler</option>
            </select>
        </div>
    </div>

    <!-- Ödev Onayları Modal -->
    <div id="approvals-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:10px;">
                <h2 style="margin:0;">Ödev Onayları</h2>
                <button id="btn-close-approvals" class="btn" style="background:#eee;">Kapat</button>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:8px;">
                <select id="approvals-task-select" class="form-control" style="flex:1;">
                    <option value="">Kitap/Test ödevi seçiniz</option>
                </select>
                <select id="approvals-class" class="form-control" style="max-width:160px;">
                    <option value="">Sınıf</option>
                </select>
                <select id="approvals-section" class="form-control" style="max-width:160px;">
                    <option value="">Şube</option>
                </select>
            </div>
            <div id="approvals-list" style="max-height:320px; overflow-y:auto;"></div>
            <button id="btn-approvals-approve" class="btn btn-success" style="width:100%; margin-top:8px;">Seçilenleri Onayla</button>
        </div>
    </div>

    <!-- Raporlar Modal -->
    <div id="reports-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="margin: 0;">Raporlar</h2>
                <button id="btn-close-reports" class="btn" style="background: #eee;">Kapat</button>
            </div>
            <div id="reports-list" style="max-height: 500px; overflow-y: auto;"></div>
        </div>
    </div>

    <!-- Ödevler Modal -->
    <div id="tasks-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="margin: 0;">Ödevler</h2>
                <button id="btn-close-tasks" class="btn" style="background: #eee;">Kapat</button>
            </div>
            <div class="filter-bar" style="margin-bottom: 10px;">
                <input id="tasks-filter-name" class="form-control" style="max-width: 240px;" placeholder="Ödev ismi">
                <input id="tasks-filter-from" class="form-control date-input" type="date" style="max-width: 160px;">
                <input id="tasks-filter-to" class="form-control date-input" type="date" style="max-width: 160px;">
            </div>
            <div style="display:flex; gap:14px; align-items:center; margin:0 0 10px 2px; flex-wrap:wrap;">
                <label style="display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input id="tasks-filter-active" type="checkbox" checked>
                    <span>Aktif Ödevler</span>
                </label>
                <label style="display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input id="tasks-filter-archived" type="checkbox" checked>
                    <span>Arşivlenen Ödevler</span>
                </label>
            </div>
            <div id="tasks-list" style="max-height: 500px; overflow-y: auto;"></div>
        </div>
    </div>

    <!-- Sınıf/Şube Yönetimi Modal -->
    <div id="classes-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="margin: 0;">Sınıf/Şube Yönetimi</h2>
                <button id="btn-close-classes" class="btn" style="background: #eee;">Kapat</button>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr auto auto auto; gap:8px; margin-bottom:10px;">
                <input id="class-manager-class" class="form-control" placeholder="Sınıf">
                <input id="class-manager-section" class="form-control" placeholder="Şube">
                <button id="btn-class-add" class="btn btn-success">Ekle</button>
                <button id="btn-class-update" class="btn btn-primary">Güncelle</button>
                <button id="btn-class-delete" class="btn btn-danger">Sil</button>
            </div>
            <textarea id="class-manager-bulk" class="form-control" rows="4" placeholder="Toplu sınıf ekleme: her satıra Sınıf,Şube veya Sınıf/Şube yazın"></textarea>
            <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                <button id="btn-class-bulk-add" class="btn btn-primary">Toplu Ekle</button>
            </div>
            <div id="classes-list" style="max-height: 420px; overflow-y: auto;"></div>
        </div>
    </div>

    <!-- Tüm Ödevler Modal -->
    <div id="all-tasks-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 id="all-items-title" style="margin: 0;">Tüm İçerikler</h2>
                <button id="btn-close-all-tasks" class="btn" style="background: #eee;">Kapat</button>
            </div>
            <div id="all-tasks-list" style="max-height: 500px; overflow-y: auto;"></div>
        </div>
    </div>

    <!-- Ödev Öğrenci Durum Modal -->
    <div id="task-students-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 id="task-students-title" style="margin: 0;">Ödev Durumu</h2>
                <button id="btn-close-task-students" class="btn" style="background: #eee;">Kapat</button>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:8px;">
                <select id="task-students-filter-class" class="form-control" style="max-width:160px;">
                    <option value="">Sınıf</option>
                </select>
                <select id="task-students-filter-section" class="form-control" style="max-width:160px;">
                    <option value="">Şube</option>
                </select>
            </div>
            <div id="task-students-list" style="max-height: 500px; overflow-y: auto;"></div>
        </div>
    </div>

    <!-- Şifre Değiştir Modal -->
    <div id="password-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2 style="margin-top: 0;">Şifre Değiştir</h2>
            <input type="password" id="password-new" class="form-control" placeholder="Yeni Şifre (en az 6 karakter)">
            <button id="btn-password-save" class="btn btn-success" style="width: 100%;">Kaydet</button>
            <button id="btn-password-cancel" class="btn" style="width: 100%; margin-top: 10px; background: #eee;">İptal</button>
        </div>
    </div>

    <!-- Profil Modal -->
    <div id="profile-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large" style="max-width: 760px;">
            <h2 style="margin-top: 0;">Profil Bilgileri</h2>
            <div style="display:flex; gap:10px;">
                <input type="text" id="profile-firstname" class="form-control" placeholder="Ad">
                <input type="text" id="profile-lastname" class="form-control" placeholder="Soyad">
            </div>
            <input type="text" id="profile-username" class="form-control" placeholder="Kullanıcı Adı">
            <input type="text" id="profile-branch" class="form-control" placeholder="Branş (sadece öğretmen)">
            <input type="password" id="profile-password" class="form-control" placeholder="Yeni Şifre (en az 6 karakter)">
            <button id="btn-profile-save" class="btn btn-success" style="width: 100%;">Güncelle</button>
            <div id="profile-teacher-tools" style="display:none;">
                <button id="btn-profile-delete" class="btn btn-danger" style="width: 100%; margin-top: 10px;">Hesabımı Sil</button>
                <div id="profile-change-approvals-wrap" style="display:none; margin-top:12px;">
                    <hr style="margin: 12px 0;">
                    <h4 style="margin: 6px 0;">Onay Bekleyenler</h4>
                    <div id="profile-change-approvals-list" style="max-height:220px; overflow:auto; border:1px solid #e5e7eb; border-radius:10px; padding:8px; background:#fff;"></div>
                </div>
                <hr style="margin: 16px 0;">
                <h3 style="margin: 0 0 10px 0;">Öğretmen Ekle</h3>
                <h4 style="margin: 6px 0;">Tekli Kayıt</h4>
                <div style="display:flex; gap:10px;">
                    <input type="text" id="add-teacher-firstname" class="form-control" placeholder="Ad">
                    <input type="text" id="add-teacher-lastname" class="form-control" placeholder="Soyad">
                </div>
                <input type="text" id="add-teacher-username" class="form-control" placeholder="Kullanıcı Adı (e-posta olabilir)">
                <input type="text" id="add-teacher-branch" class="form-control" placeholder="Branş (ör. Matematik)">
                <input type="text" id="add-teacher-class-sections" class="form-control" placeholder="Atanan sınıf/şube (ör. 5/A, 6/B)">
                <input type="password" id="add-teacher-password" class="form-control" placeholder="Şifre (en az 6 karakter)">
                <button id="btn-add-teacher-save" class="btn btn-primary" style="width: 100%; margin-top: 8px;">Öğretmen Kaydet</button>
            </div>
            <button id="btn-profile-cancel" class="btn" style="width: 100%; margin-top: 10px; background: #eee;">Kapat</button>
        </div>
    </div>

    <!-- Öğrenci İstatistik Modal -->
    <div id="my-stats-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content modal-large">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2 style="margin: 0;">İstatistiklerim</h2>
                <div style="display:flex; gap:8px; align-items:center;">
                    <button id="btn-my-stats-report" class="btn btn-primary">Raporu Aç</button>
                    <button id="btn-close-my-stats" class="btn" style="background: #eee; border-radius:50%; width:34px; height:34px; padding:0; font-size:18px; line-height:1;">×</button>
                </div>
            </div>
            <div id="my-stats-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number" id="my-task-summary">0/0 • %0</div>
                        <div class="stat-label">Ödev</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="my-activity-summary">0/0 • %0</div>
                        <div class="stat-label">Etkinlik</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="my-lesson-summary">0/0 • %0</div>
                        <div class="stat-label">Dersler</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="my-block2d-summary">0/0 • %0</div>
                        <div class="stat-label">Blok Kodlama</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="my-block3d-summary">0/0 • %0</div>
                        <div class="stat-label">3D Blok Kodlama</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="my-compute-summary">0/0 • %0</div>
                        <div class="stat-label">Compute It</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="my-python-quiz-summary">0 • %0</div>
                        <div class="stat-label">Python Quiz</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="my-total-xp">0</div>
                        <div class="stat-label">Toplam XP</div>
                    </div>
                </div>
                <div class="chart-container my-stats-charts">
                    <div class="my-chart-card">
                        <div class="my-chart-title">Ödev İstatistik</div>
                        <canvas id="myTaskChart" height="140" style="max-width:100%;"></canvas>
                    </div>
                    <div class="my-chart-card">
                        <div class="my-chart-title">Etkinlik İstatistik</div>
                        <canvas id="myActivityChart" height="140" style="max-width:100%;"></canvas>
                    </div>
                    <div class="my-chart-card">
                        <div class="my-chart-title">Dersler</div>
                        <canvas id="myLessonChart" height="140" style="max-width:100%;"></canvas>
                    </div>
                    <div class="my-chart-card">
                        <div class="my-chart-title">Blok Kodlama (2D)</div>
                        <canvas id="myBlockChart" height="140" style="max-width:100%;"></canvas>
                    </div>
                    <div class="my-chart-card">
                        <div class="my-chart-title">3D Blok Kodlama</div>
                        <canvas id="myBlock3DChart" height="140" style="max-width:100%;"></canvas>
                    </div>
                    <div class="my-chart-card">
                        <div class="my-chart-title">Compute It</div>
                        <canvas id="myComputeChart" height="140" style="max-width:100%;"></canvas>
                    </div>
                    <div class="my-chart-card">
                        <div class="my-chart-title">Python Quiz</div>
                        <canvas id="myPythonQuizChart" height="140" style="max-width:100%;"></canvas>
                    </div>
                </div>
                <div style="margin-top:16px;">
                    <h4 style="margin:0 0 10px;">🏅 Rozetler</h4>
                    <div id="my-badges-grid" class="badges-grid"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="badges-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content modal-large">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h3 style="margin:0;">🏅 Rozetlerim</h3>
                <button id="btn-close-badges" class="btn" style="background:#eee;">Kapat</button>
            </div>
            <div style="margin-top:12px;">
                <div id="badges-grid" class="badges-grid"></div>
            </div>
        </div>
    </div>

    <!-- Ders Oluştur Modal (Öğretmen) -->
    <div id="lesson-builder-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content modal-large lesson-builder-shell">
            <div class="lesson-builder-topbar">
                <div class="lesson-builder-brand">
                    <span class="dot"></span>
                    <span>Ders Oluşturucu</span>
                </div>
                <div class="lesson-title-wrap">
                    <input id="lesson-title" class="form-control lesson-main-input" placeholder="Ders başlığı">
                </div>
                <div class="lesson-builder-actions">
                    <button id="btn-preview-lesson" class="btn" style="background:#dbeafe;color:#1d4ed8;">Önizleme</button>
                    <button id="btn-save-lesson" class="btn btn-success">Dersi Kaydet</button>
                    <button id="btn-delete-slide" class="btn btn-danger">Slide Sil</button>
                    <button id="btn-delete-lesson" class="btn" style="background:#ef4444;color:#fff;">Dersi Sil</button>
                    <button id="btn-close-lesson-builder" class="btn" style="background:#e2e8f0;">Kapat</button>
                </div>
            </div>
            <div class="lesson-builder-main">
                <aside class="lesson-panel left">
                    <div class="lesson-left-top">
                        <span class="title">Ders Sayfaları</span>
                        <button id="btn-add-lesson-slide" class="btn btn-primary">+ Sayfa Ekle</button>
                    </div>
                    <div id="lesson-slide-list"></div>
                </aside>

                <section class="lesson-panel center">
                    <div class="lesson-quick-tools">
                        <button id="btn-lesson-quick-text" type="button" class="btn btn-primary">📝 Yazı Ekle</button>
                        <button id="btn-lesson-quick-image" type="button" class="btn">🖼️ Görsel Ekle</button>
                        <button id="btn-lesson-quick-code" type="button" class="btn" style="background:#dbeafe;color:#1d4ed8;">&lt;/&gt; Kod Ekle</button>
                        <button id="btn-lesson-quick-question" type="button" class="btn" style="background:#ecfeff;color:#0f766e;">❓ Soru Ekle</button>
                    </div>
                    <div class="lesson-toolbar">
                        <button type="button" class="btn" data-lesson-cmd="bold" title="Kalın">T</button>
                        <button type="button" class="btn" data-lesson-cmd="createLink" title="Link">🔗</button>
                        <button type="button" id="btn-lesson-insert-image" class="btn" title="Görsel">🖼️</button>
                        <button type="button" class="btn" data-lesson-cmd="insertUnorderedList" title="Liste">•</button>
                        <button type="button" class="btn" data-lesson-cmd="justifyLeft" title="Sola">⬅</button>
                        <button type="button" class="btn" data-lesson-cmd="justifyCenter" title="Ortala">↔</button>
                        <button type="button" class="btn" data-lesson-cmd="justifyRight" title="Sağa">➡</button>
                        <button type="button" id="btn-add-canvas-text" class="btn" title="Metin kutusu">T+</button>
                        <button type="button" id="btn-add-canvas-image" class="btn" title="Görsel kutusu">🖼️+</button>
                        <button type="button" id="btn-delete-selected-canvas-text" class="btn" title="Seçili metni sil">🗑️T</button>
                        <button type="button" id="btn-delete-all-canvas-text" class="btn" title="Tüm metinleri sil">🗑️TT</button>
                    </div>
                    <div class="lesson-editor-scroll">
                        <div class="lesson-editor-head" id="lesson-content-head">
                            <span>İçerik Alanı</span>
                            <small>Yazı ve görsel içeriğini buradan düzenleyin</small>
                        </div>
                        <textarea id="lesson-desc" class="form-control" rows="2" placeholder="Ders açıklaması"></textarea>
                        <div id="slide-content-area" class="lesson-content-block">
                        <div id="slide-content-editor" contenteditable="true"></div>
                        <div id="slide-media-row" style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:8px;">
                            <input id="slide-image-url" class="form-control" placeholder="Slide görsel URL">
                            <input id="slide-image-file" type="file" class="form-control" accept="image/*">
                        </div>
                            <div id="slide-code-editor" style="display:none; margin-top:10px; border:1px solid #cbd5e1; border-radius:10px; padding:10px; background:#f8fafc;">
                                <div style="font-size:12px;color:#475569;margin-bottom:6px;">HTML, CSS ve JS kodlarını girin. Önizleme altta canlı güncellenir.</div>
                                <div style="display:grid;grid-template-columns:1fr;gap:8px;">
                                    <textarea id="slide-code-input" class="form-control" rows="12" placeholder="HTML, CSS ve JS kodlarını tek kutuya yazın.&#10;&#10;Örnek:&#10;<div id='app'>Merhaba</div>&#10;<style>#app{color:#2563eb;font-weight:700;}</style>&#10;<script>console.log('hazır')</script>" style="font-family:Consolas, 'Courier New', monospace;"></textarea>
                                </div>
                            </div>
                            <div id="slide-canvas-editor" style="margin-top:10px;display:none;">
                                <div style="font-size:12px;color:#64748b;margin-bottom:4px;">Sürükle-bırak yerleşim alanı</div>
                                <div id="lesson-canvas-stage" style="position:relative;height:300px;border:1px dashed #94a3b8;border-radius:10px;background:#fff;overflow:hidden;"></div>
                            </div>
                            <div id="lesson-question-builder-host" style="margin-top:10px;display:none;"></div>
                        </div>
                        <div class="lesson-editor-head" style="margin-top:10px;">
                            <span>Canlı Önizleme</span>
                        </div>
                        <div id="lesson-slide-preview"></div>
                    </div>
                </section>

                <aside class="lesson-panel right">
                    <div class="lesson-side-title">Sayfa Ayarları</div>
                    <div class="lesson-side-block" id="lesson-question-side">
                        <input id="slide-title" class="form-control" placeholder="Slide başlığı">
                        <select id="slide-type" class="form-control">
                            <option value="content">Konu Anlatım</option>
                            <option value="question">Soru Sayfası</option>
                            <option value="mixed">Konu + Soru</option>
                        </select>
                        <select id="slide-layout" class="form-control">
                            <option value="text">Düz Metin</option>
                            <option value="split">Sol Metin / Sağ Görsel</option>
                            <option value="cover">Tam Görsel Üstü Metin</option>
                            <option value="canvas">Serbest Yerleşim</option>
                            <option value="code">HTML/CSS/JS Kod Önizleme</option>
                        </select>
                        <div id="lesson-question-builder" class="lesson-question-builder" style="display:none;">
                            <select id="slide-question-type" class="form-control">
                                <option value="multiple">Çoktan Seçmeli</option>
                                <option value="boolean">Doğru / Yanlış</option>
                                <option value="dragdrop">Sürükle Bırak</option>
                            </select>
                            <textarea id="slide-question-text" class="form-control" rows="3" placeholder="Soru metni"></textarea>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                                <input id="slide-question-image-url" class="form-control" placeholder="Soru görsel URL">
                                <input id="slide-question-image-file" type="file" class="form-control" accept="image/*">
                            </div>
                            <div class="lesson-question-grid-2">
                                <input id="slide-question-xp" type="number" min="0" max="100" class="form-control" placeholder="Soru XP">
                            </div>
                            <div id="lesson-question-multiple-fields" style="display:none;">
                                <div class="lesson-question-options-grid">
                                    <div class="lesson-option-row" data-opt-row="0">
                                        <button type="button" class="lesson-option-tick" data-correct-idx="0">✓</button>
                                        <input id="slide-option-0" class="form-control lesson-quiz-option" placeholder="A şıkkı">
                                    </div>
                                    <div class="lesson-option-row" data-opt-row="1">
                                        <button type="button" class="lesson-option-tick" data-correct-idx="1">✓</button>
                                        <input id="slide-option-1" class="form-control lesson-quiz-option" placeholder="B şıkkı">
                                    </div>
                                    <div class="lesson-option-row" data-opt-row="2">
                                        <button type="button" class="lesson-option-tick" data-correct-idx="2">✓</button>
                                        <input id="slide-option-2" class="form-control lesson-quiz-option" placeholder="C şıkkı">
                                    </div>
                                    <div class="lesson-option-row" data-opt-row="3">
                                        <button type="button" class="lesson-option-tick" data-correct-idx="3">✓</button>
                                        <input id="slide-option-3" class="form-control lesson-quiz-option" placeholder="D şıkkı">
                                    </div>
                                </div>
                                <input id="slide-correct-choice" type="hidden" value="0">
                            </div>
                            <div id="lesson-question-boolean-fields" style="display:none;">
                                <select id="slide-correct-boolean" class="form-control">
                                    <option value="dogru">Doğru</option>
                                    <option value="yanlis">Yanlış</option>
                                </select>
                            </div>
                            <div id="lesson-question-dragdrop-fields" style="display:none;">
                                <textarea id="slide-dragdrop-pairs" class="form-control" rows="4" placeholder="Her satıra bir eşleştirme yazın. Örn: Elma:Meyve"></textarea>
                            </div>
                            <div class="lesson-side-help">Doğru cevabı şıkların yanındaki tik ile işaretleyin.</div>
                        </div>
                    </div>
                    <div class="lesson-side-title">Kullanım</div>
                    <div class="lesson-side-block" style="font-size:12px;color:#64748b;line-height:1.5;">
                        1) Soldan sayfa ekleyin.
                        2) Ortada yazı, görsel ve kod içeriğini hazırlayın.
                        3) Değişiklikler otomatik kaydedilir.
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <div id="lesson-text-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content" style="max-width:520px;">
            <h3 id="lesson-text-modal-title" style="margin-top:0;">Metin</h3>
            <textarea id="lesson-text-modal-input" class="form-control" rows="6" placeholder="Metin girin"></textarea>
            <div style="display:flex;gap:8px;margin-top:10px;">
                <button id="btn-lesson-text-ok" class="btn btn-primary" style="flex:1;">Kaydet</button>
                <button id="btn-lesson-text-cancel" class="btn" style="flex:1;background:#eee;">Vazgeç</button>
            </div>
        </div>
    </div>
    <div id="lesson-image-modal">
        <div class="lesson-image-modal-content">
            <button id="btn-close-lesson-image-modal" class="lesson-image-modal-close" type="button">×</button>
            <img id="lesson-image-modal-img" src="" alt="">
        </div>
    </div>

    <!-- Ders Oynatıcı Modal (Öğrenci) -->
    <div id="lesson-player-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content modal-large lesson-player-shell">
            <div class="lesson-player-topbar">
                <div class="lesson-player-left-controls">
                    <button id="btn-lesson-nav-toggle" class="btn lesson-nav-toggle-btn" type="button">☰ Konular</button>
                    <h2 id="lesson-player-title" style="margin:0;">Ders</h2>
                </div>
                <div class="lesson-player-right-controls">
                    <button id="btn-lesson-prev" class="btn lesson-nav-btn">◀ Önceki</button>
                    <button id="btn-lesson-next" class="btn lesson-nav-btn btn-primary">Sonraki ▶</button>
                    <button id="btn-close-lesson-player" class="btn" style="background:#eee;">Kapat</button>
                </div>
            </div>
            <div class="lesson-player-grid">
                <div id="lesson-player-nav"></div>
                <div id="lesson-player-stage"></div>
            </div>
            <div class="lesson-player-footer">
                <div id="lesson-player-progress" style="font-weight:600;color:#475569;">%0 tamamlandı • 0 XP</div>
                <div id="lesson-player-counter" style="color:#64748b;font-weight:600;">1 / 1</div>
            </div>
            <div id="lesson-player-track" style="margin-top:8px;display:flex;gap:6px;align-items:center;overflow:auto;"></div>
            <div class="lesson-player-zoom-controls">
                <button id="lesson-zoom-out" class="lesson-zoom-btn" type="button">−</button>
                <button id="lesson-zoom-reset" class="lesson-zoom-btn" type="button">100%</button>
                <button id="lesson-zoom-in" class="lesson-zoom-btn" type="button">+</button>
            </div>
        </div>
    </div>

    <!-- Canlı Quiz (Öğretmen) -->
    <div id="live-quiz-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content modal-large">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <h2 id="live-quiz-modal-title" style="margin:0;">Canlı Quiz</h2>
                <button id="btn-close-live-quiz" class="btn" style="background:#eee;">Kapat</button>
            </div>
            <div class="tabs" style="margin-bottom:8px;">
                <button id="tab-live-quiz-create" class="tab-btn active">Quiz Oluştur</button>
                <button id="tab-live-quiz-start" class="tab-btn">Quiz Başlat</button>
                <button id="tab-live-quiz-results" class="tab-btn">Quiz Sonuçları</button>
            </div>

            <div id="live-quiz-create-pane" class="live-quiz-builder" style="display:grid;">
                <div class="live-quiz-sidebar">
                    <div class="live-quiz-sidebar-head">
                        <span class="title">Soru Listesi</span>
                        <button id="btn-add-live-quiz-question" class="btn btn-primary">+ Soru Ekle</button>
                    </div>
                    <div id="live-quiz-question-list"></div>
                </div>
                <div class="live-quiz-canvas">
                    <div class="live-quiz-global">
                        <input id="live-quiz-title" class="form-control" placeholder="Quiz başlığı">
                        <input id="live-quiz-class" class="form-control" placeholder="Sınıf (boş=tümü)">
                        <input id="live-quiz-section" class="form-control" placeholder="Şube (opsiyonel)">
                    </div>
                    <div id="live-quiz-editor" class="live-quiz-editor-card">
                        <input id="live-q-text" class="form-control live-quiz-main-question" placeholder="Sorunu girmeye başla">
                        <div class="live-quiz-media-drop">
                            <label for="live-q-image" class="live-quiz-media-label">+ Medya Ekle</label>
                            <input id="live-q-image" type="file" accept="image/*">
                            <div id="live-q-image-preview" class="live-quiz-media-preview">Soruya görsel ekleyebilirsin.</div>
                            <button id="btn-live-q-image-clear" type="button" class="btn" style="margin-top:8px;background:#fee2e2;color:#991b1b;">Görseli Kaldır</button>
                        </div>
                        <div class="live-quiz-options-grid">
                            <div style="display:flex;gap:8px;align-items:center;">
                                <button type="button" class="btn live-q-correct-mark" data-correct-option="A">✓</button>
                                <input id="live-q-a" class="form-control live-quiz-option-input" placeholder="A seçeneği">
                            </div>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <button type="button" class="btn live-q-correct-mark" data-correct-option="B">✓</button>
                                <input id="live-q-b" class="form-control live-quiz-option-input" placeholder="B seçeneği">
                            </div>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <button type="button" class="btn live-q-correct-mark" data-correct-option="C">✓</button>
                                <input id="live-q-c" class="form-control live-quiz-option-input" placeholder="C seçeneği">
                            </div>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <button type="button" class="btn live-q-correct-mark" data-correct-option="D">✓</button>
                                <input id="live-q-d" class="form-control live-quiz-option-input" placeholder="D seçeneği">
                            </div>
                        </div>
                        <textarea id="live-q-match-pairs" class="form-control" rows="4" style="display:none;margin-top:8px;" placeholder="Her satır: Sol İfade = Sağ İfade&#10;Ör: CPU = İşlemci"></textarea>
                    </div>
                    <div id="live-quiz-preview" class="live-quiz-preview">
                        <div id="live-quiz-preview-q" class="live-quiz-preview-q">Soru önizlemesi burada görünecek.</div>
                        <div id="live-quiz-preview-grid" class="live-quiz-preview-grid"></div>
                    </div>
                </div>
                <aside class="live-quiz-right-panel">
                    <div class="live-quiz-right-title">Question properties</div>
                    <div class="live-quiz-right-block">
                        <div class="label">Soru türü</div>
                        <select id="live-q-type" class="form-control">
                            <option value="multiple">Quiz</option>
                            <option value="truefalse">Doğru / Yanlış</option>
                            <option value="matching">Sürükle Bırak Eşleştirme</option>
                        </select>
                    </div>
                    <div class="live-quiz-right-block">
                        <div class="label">Zaman sınırı</div>
                        <select id="live-q-duration" class="form-control">
                            <option value="auto">Otomatik</option>
                            <option value="10">10 sn</option>
                            <option value="15">15 sn</option>
                            <option value="20">20 sn</option>
                            <option value="25">25 sn</option>
                            <option value="30" selected>30 sn</option>
                            <option value="35">35 sn</option>
                            <option value="40">40 sn</option>
                            <option value="45">45 sn</option>
                            <option value="50">50 sn</option>
                            <option value="55">55 sn</option>
                            <option value="60">60 sn</option>
                        </select>
                    </div>
                    <div class="live-quiz-right-block">
                        <div class="label">Puanlar</div>
                        <select id="live-q-xp" class="form-control">
                            <option value="5">5 XP</option>
                            <option value="10" selected>10 XP</option>
                            <option value="15">15 XP</option>
                            <option value="20">20 XP</option>
                            <option value="25">25 XP</option>
                            <option value="30">30 XP</option>
                            <option value="35">35 XP</option>
                            <option value="40">40 XP</option>
                            <option value="45">45 XP</option>
                            <option value="50">50 XP</option>
                        </select>
                        <label style="display:flex;align-items:center;gap:8px;margin-top:8px;font-size:13px;color:#334155;">
                            <input id="live-q-double-xp" type="checkbox">
                            2 kat puan
                        </label>
                    </div>
                    <div class="live-quiz-right-block">
                        <button id="btn-save-live-quiz-question" class="btn btn-primary" style="width:100%;margin-top:6px;">Soruyu Kaydet / Güncelle</button>
                    </div>
                    <div class="live-quiz-actions-footer">
                        <button id="btn-save-live-quiz" class="btn btn-success">Quizi Kaydet</button>
                        <button id="btn-delete-live-quiz" class="btn btn-danger">Quizi Sil</button>
                    </div>
                </aside>
            </div>

            <div id="live-quiz-start-pane" style="display:none;flex:1;min-height:0;overflow:auto;">
                <div id="live-quiz-list" style="display:grid;gap:8px;"></div>
                <hr style="border:none;border-top:1px solid #eee;margin:10px 0;">
                <div class="card" style="margin:0;">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
                        <div>
                            <strong id="live-session-title">Canlı oturum yok</strong>
                            <div id="live-session-meta" style="font-size:12px;color:#666;"></div>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <button id="btn-open-teacher-live-monitor" class="btn" style="background:#eff6ff;color:#1d4ed8;">Tam Ekran Takip</button>
                            <button id="btn-live-session-lock" class="btn btn-warning">Soruyu Kilitle</button>
                            <button id="btn-live-session-next" class="btn btn-primary">Sonraki Soru</button>
                            <button id="btn-live-session-end" class="btn btn-danger">Bitir</button>
                        </div>
                    </div>
                    <div style="margin-top:10px;">
                        <h4 style="margin:0 0 8px;">Canlı Sıralama</h4>
                        <div id="live-session-rank" style="max-height:260px;overflow:auto;"></div>
                    </div>
                    <div style="margin-top:12px;">
                        <h4 style="margin:0 0 8px;">Anlık Cevaplar</h4>
                        <div id="live-session-answer-stats" style="margin-bottom:8px;"></div>
                        <div id="live-session-answer-feed" style="max-height:180px;overflow:auto;"></div>
                    </div>
                </div>
            </div>
            <div id="live-quiz-results-pane" style="display:none;flex:1;min-height:0;overflow:auto;">
                <div class="card" style="margin-top:10px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:6px;">
                        <div style="font-weight:700; color:#1f2937;">Quiz Sonuçları</div>
                        <div style="display:flex;gap:6px;">
                            <button id="btn-download-teacher-quiz-results-modal" class="btn" style="background:#dbeafe;color:#1d4ed8;padding:6px 10px;">Rapor Al</button>
                            <button id="btn-clear-teacher-quiz-results-modal" class="btn" style="background:#eef2ff;color:#1e3a8a;padding:6px 10px;">Liste Temizle</button>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;align-items:center;margin-bottom:8px;">
                        <select id="teacher-quiz-session-select-modal" class="form-control" style="max-width:100%;">
                            <option value="">Yapılan quiz seçin</option>
                        </select>
                        <button id="btn-view-teacher-quiz-session-modal" class="btn btn-primary" style="white-space:nowrap;">Listele</button>
                    </div>
                    <div id="teacher-quiz-results-meta-modal" style="font-size:12px;color:#64748b;margin-bottom:6px;"></div>
                    <div id="teacher-quiz-results-list-modal" style="display:flex;flex-direction:column;gap:6px; max-height:260px; overflow:auto;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Canlı Quiz Davet (Öğrenci) -->
    <div id="live-quiz-invite" class="modal-overlay" style="display:none;z-index:25000;">
        <div class="modal-content live-quiz-invite-card" style="max-width:460px;">
            <h3 style="margin-top:0;color:#ea580c;">🟧 Canlı Quize Katıl</h3>
            <p id="live-quiz-invite-text" style="margin:8px 0 14px;">Öğretmen canlı quiz başlattı.</p>
            <div style="display:flex;gap:8px;">
                <button id="btn-join-live-quiz" class="btn btn-warning" style="flex:1;">Katıl</button>
            </div>
        </div>
    </div>

    <!-- Canlı Quiz Oyuncu (Öğrenci) -->
    <div id="live-quiz-player" class="modal-overlay" style="display:none;z-index:24000;">
        <div class="modal-content modal-large live-player-shell">
            <div class="live-player-head">
                <h3 id="live-player-title">Canlı Quiz</h3>
                <div id="live-player-timer" class="live-player-timer">00 sn</div>
            </div>
            <div id="live-player-question" class="live-player-question"></div>
            <div id="live-player-options" class="live-player-options"></div>
            <div id="live-player-info" class="live-player-info"></div>
            <button id="btn-close-live-player" class="btn" style="margin-top:12px;width:100%;background:#eee;">Kapat</button>
        </div>
    </div>

    <!-- Canlı Quiz Tam Ekran Takip (Öğretmen) -->
    <div id="teacher-live-monitor-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content teacher-live-monitor-shell">
            <div class="teacher-live-monitor-head">
                <div>
                    <div id="teacher-live-monitor-title" class="teacher-live-monitor-title">Canlı Quiz Takip</div>
                    <div id="teacher-live-monitor-sub" class="teacher-live-monitor-sub">Canlı oturum bekleniyor...</div>
                </div>
                <div class="teacher-live-monitor-actions">
                    <button id="btn-teacher-live-monitor-refresh" class="btn btn-primary">Yenile</button>
                    <button id="btn-close-teacher-live-monitor" class="btn" style="background:#e2e8f0;">Kapat</button>
                </div>
            </div>
            <div id="teacher-live-monitor-metrics" class="teacher-live-monitor-metrics"></div>
            <div id="teacher-live-monitor-list"></div>
        </div>
    </div>

    <div id="flowchart-modal" class="modal-overlay" style="display:none;">
        <div class="modal-content flowchart-shell">
            <div class="flowchart-toolbar">
                <button id="flow-run" class="flowchart-btn run">▶ Çalıştır</button>
                <button id="flow-stop" class="flowchart-btn stop">¦ Durdur</button>
                <button id="flow-assign" class="flowchart-btn" style="display:none;">Ödev Ver</button>
                <button id="flow-delete-assignment" class="flowchart-btn stop" style="display:none;">Ödevi Sil</button>
                <button id="flow-submit-assignment" class="flowchart-btn run" style="display:none;">Cevabı Kontrol Et</button>
                <button id="flow-auto" class="flowchart-btn">Bağla Modu</button>
                <button id="flow-delete" class="flowchart-btn">Sil</button>
                <button id="flow-delete-edge" class="flowchart-btn">Bağlantı Sil</button>
                <button id="flow-clear" class="flowchart-btn">Temizle</button>
                <div id="flow-assignment-timer" class="flowchart-assignment-timer" style="display:none;">⏱️ 0 dk 0 sn</div>
                <button id="flow-close" class="flowchart-btn">Kapat</button>
            </div>
            <div class="flowchart-main">
                <aside class="flowchart-palette" id="flowchart-palette">
                    <button class="flowchart-tool active" data-tool="start" draggable="true"><span class="flow-tool-shape start">start</span></button>
                    <button class="flowchart-tool" data-tool="process" draggable="true"><span class="flow-tool-shape">act</span></button>
                    <button class="flowchart-tool" data-tool="input" draggable="true"><span class="flow-tool-shape input">in</span></button>
                    <button class="flowchart-tool" data-tool="output" draggable="true"><span class="flow-tool-shape output">out</span></button>
                    <button class="flowchart-tool" data-tool="decision" draggable="true"><span class="flow-tool-shape decision"><span>if</span></span></button>
                    <button class="flowchart-tool" data-tool="end" draggable="true"><span class="flow-tool-shape end">end</span></button>
                </aside>
                <section class="flowchart-canvas-wrap">
                    <div id="flowchart-canvas">
                        <svg id="flowchart-svg" xmlns="http://www.w3.org/2000/svg"></svg>
                    </div>
                </section>
                <aside class="flowchart-right">
                    <div class="flowchart-right-head">Çıktı</div>
                    <div id="flowchart-help-text" class="flowchart-help">İpucu: Soldan şekli sürükleyip bırak. "Bağla Modu" ile iki düğümü seçip bağlantı kur. Şekle çift tıklayıp metin düzenle.</div>
                    <div id="flowchart-target-preview" class="flowchart-help" style="display:none; max-height:240px; overflow:auto;"></div>
                    <pre id="flowchart-output">Flowchart çıktısı burada görünecek.</pre>
                </aside>
            </div>
        </div>
    </div>
    <div id="flowchart-assignment-modal" class="modal-overlay" style="display:none; z-index:25032;">
        <div class="modal-content" style="max-width:560px;">
            <h3 style="margin:0 0 10px 0;">Flowchart Ödevi Ver</h3>
            <input id="flow-assignment-title" class="form-control" type="text" placeholder="Ödev başlığı">
            <textarea id="flow-assignment-question" class="form-control" rows="3" placeholder="Soru metni"></textarea>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                <input id="flow-assignment-class" class="form-control" type="text" placeholder="Sınıf (boş=tümü)">
                <input id="flow-assignment-section" class="form-control" type="text" placeholder="Şube (opsiyonel)">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                <input id="flow-assignment-deadline" class="form-control" type="date">
                <input id="flow-assignment-time" class="form-control" type="time" value="23:59">
            </div>
            <input id="flow-assignment-xp" class="form-control" type="number" min="0" max="20" step="1" value="20" placeholder="XP">
            <div style="display:flex; justify-content:flex-end; gap:8px;">
                <button id="btn-delete-flow-assignment" class="btn btn-danger" style="display:none;">Sil</button>
                <button id="btn-close-flow-assignment" class="btn" style="background:#e5e7eb;">İptal</button>
                <button id="btn-save-flow-assignment" class="btn btn-primary">Ödevi Yayınla</button>
            </div>
        </div>
    </div>
    <div id="flow-node-editor-modal" class="modal-overlay" style="display:none; z-index:25030;">
        <div class="modal-content">
            <h3 id="flow-node-editor-title" style="margin:0 0 10px 0;">Düğüm Düzenle</h3>
            <div class="flow-node-editor-form">
                <div id="flow-node-editor-readonly" style="display:none; background:#f8fafc; border:1px solid #e5e7eb; border-radius:10px; padding:10px; color:#334155;">Bu düğüm sabittir.</div>
                <div id="flow-node-editor-input" style="display:none;">
                    <div class="flow-node-editor-label">Değişken Adı</div>
                    <input id="flow-edit-input-var" class="form-control" type="text" placeholder="ornek: x">
                    <div class="flow-node-editor-label">Mesaj</div>
                    <input id="flow-edit-input-msg" class="form-control" type="text" placeholder="ornek: Bir değer girin">
                </div>
                <div id="flow-node-editor-output" style="display:none;">
                    <div class="flow-node-editor-label">Değişken Adı (opsiyonel)</div>
                    <select id="flow-edit-output-var" class="form-control">
                        <option value="">(Değişken seçilmedi)</option>
                    </select>
                    <div class="flow-node-editor-label">Mesaj / Çıktı</div>
                    <input id="flow-edit-output-msg" class="form-control" type="text" placeholder='ornek: Sonuç'>
                </div>
                <div id="flow-node-editor-process" style="display:none;">
                    <div class="flow-node-editor-row three">
                        <div>
                            <div class="flow-node-editor-label">Sonuç Değişkeni</div>
                            <input id="flow-edit-proc-result" class="form-control" type="text" placeholder="sonuc">
                        </div>
                        <div class="flow-node-editor-label" style="margin:0 0 10px 0; text-align:center;">=</div>
                        <div></div>
                    </div>
                    <div class="flow-node-editor-row three">
                        <div>
                            <div class="flow-node-editor-label">1. Değişken</div>
                            <input id="flow-edit-proc-left" class="form-control" type="text" placeholder="a">
                        </div>
                        <div>
                            <div class="flow-node-editor-label">İşlem</div>
                            <select id="flow-edit-proc-op" class="form-control">
                                <option value="+">+</option>
                                <option value="-">-</option>
                                <option value="*">*</option>
                                <option value="/">/</option>
                            </select>
                        </div>
                        <div>
                            <div class="flow-node-editor-label">2. Değişken</div>
                            <input id="flow-edit-proc-right" class="form-control" type="text" placeholder="b">
                        </div>
                    </div>
                </div>
                <div id="flow-node-editor-decision" style="display:none;">
                    <div class="flow-node-editor-row three">
                        <div>
                            <div class="flow-node-editor-label">Değişken</div>
                            <input id="flow-edit-if-left" class="form-control" type="text" placeholder="x">
                        </div>
                        <div>
                            <div class="flow-node-editor-label">Koşul</div>
                            <select id="flow-edit-if-op" class="form-control">
                                <option value="==">==</option>
                                <option value="!=">!=</option>
                                <option value=">">&gt;</option>
                                <option value="<">&lt;</option>
                                <option value=">=">&gt;=</option>
                                <option value="<=">&lt;=</option>
                            </select>
                        </div>
                        <div>
                            <div class="flow-node-editor-label">Veri</div>
                            <input id="flow-edit-if-right" class="form-control" type="number" step="any" placeholder="10">
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:12px;">
                <button id="btn-flow-node-cancel" class="btn" style="background:#e5e7eb;">İptal</button>
                <button id="btn-flow-node-save" class="btn btn-primary">Kaydet</button>
            </div>
        </div>
    </div>
    <div id="flow-runtime-input-modal" class="modal-overlay" style="display:none; z-index:25031;">
        <div class="modal-content">
            <h3 style="margin:0 0 10px 0;">Veri Girişi</h3>
            <div id="flow-runtime-input-question" style="margin-bottom:8px; color:#334155;">Değer girin</div>
            <input id="flow-runtime-input-value" class="form-control" type="text" placeholder="Değer">
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:10px;">
                <button id="btn-flow-runtime-input-cancel" class="btn" style="background:#e5e7eb;">İptal</button>
                <button id="btn-flow-runtime-input-ok" class="btn btn-primary">Tamam</button>
            </div>
        </div>
    </div>

    <!-- Öğrenci Sertifikaları -->
    <div id="certificates-modal" class="modal-overlay" style="display:none;z-index:23000;">
        <div class="modal-content modal-large certificate-shell">
            <div class="certificate-modal-head">
                <h2 style="margin:0;">Sertifikalarım</h2>
                <div style="display:flex;gap:8px;">
                    <button id="btn-download-certificate" class="btn btn-primary">Önizle</button>
                    <button id="btn-download-certificate-pdf" class="btn btn-primary">PDF İndir</button>
                    <button id="btn-close-certificates" class="btn" style="background:#eee;">Kapat</button>
                </div>
            </div>
            <div id="student-certificate-card" class="student-certificate">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="certificate-logo">
                <div class="certificate-badge">✦</div>
                <div class="certificate-title">BAŞARI SERTİFİKASI</div>
                <div id="certificate-student-name" class="certificate-student-name">Öğrenci Adı Soyadı</div>
                <p id="certificate-award-text" class="certificate-text">
                    Bu sertifika, Bilişim, Kodlama, Yazılım ve Robotik alanlarındaki eğitim çalışmalarında gösterilen başarı nedeniyle verilmiştir.
                </p>
                <div class="certificate-meta-row">
                    <div class="certificate-meta-item">
                        <span class="k">Sınıf / Şube</span>
                        <span id="certificate-class" class="v">-</span>
                    </div>
                    <div class="certificate-meta-item">
                        <span class="k">Toplam XP</span>
                        <span id="certificate-xp" class="v">0 XP</span>
                    </div>
                    <div class="certificate-meta-item">
                        <span class="k">Tamamlama</span>
                        <span id="certificate-completion" class="v">%0</span>
                    </div>
                    <div class="certificate-meta-item">
                        <span class="k">Veriliş Tarihi</span>
                        <span id="certificate-date" class="v">-</span>
                    </div>
                </div>
                <div class="certificate-footer-note">
                    <div class="certificate-sign-row">
                        <div class="certificate-sign-col">
                            <div class="certificate-sign-line"></div>
                            <div class="certificate-sign-role">Ders Öğretmeni</div>
                            <div id="certificate-teacher-name" class="certificate-sign-name">Ders Öğretmeni</div>
                        </div>
                        <div class="certificate-sign-col">
                            <div class="certificate-sign-line"></div>
                            <div class="certificate-sign-role">Okul Müdürü</div>
                            <div id="certificate-principal-name" class="certificate-sign-name">Okul Müdürü</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="teacher-certificates-modal" class="modal-overlay" style="display:none;z-index:23000;">
        <div class="modal-content modal-large certificate-shell">
            <div class="certificate-modal-head">
                <h2 style="margin:0;">Sertifika Yönetimi</h2>
                <button id="btn-close-teacher-certificates" class="btn" style="background:#eee;">Kapat</button>
            </div>
            <p class="teacher-cert-note">Sınıf ve şube seçerek tek öğrenci sertifikası veya tüm sınıf sertifikalarını tek dosya halinde oluşturabilirsiniz.</p>
            <div class="teacher-cert-toolbar">
                <div>
                    <label>Sınıf</label>
                    <select id="teacher-cert-class" class="form-control">
                        <option value="">Tümü</option>
                    </select>
                </div>
                <div>
                    <label>Şube</label>
                    <select id="teacher-cert-section" class="form-control">
                        <option value="">Tümü</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label>Öğrenci</label>
                    <select id="teacher-cert-student" class="form-control">
                        <option value="">Öğrenci seçin</option>
                    </select>
                </div>
            </div>
            <div class="teacher-cert-actions">
                <button id="btn-download-selected-certificate" class="btn btn-primary">Seçili Öğrenciyi Önizle</button>
                <button id="btn-download-class-certificates" class="btn btn-success">Filtredeki Tümünü Önizle</button>
            </div>
            <div id="teacher-certificate-card" class="student-certificate">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="certificate-logo">
                <div class="certificate-badge">✦</div>
                <div class="certificate-title">BAŞARI SERTİFİKASI</div>
                <div id="teacher-certificate-student-name" class="certificate-student-name">Öğrenci Adı Soyadı</div>
                <p id="teacher-certificate-award-text" class="certificate-text">
                    Bu sertifika, Bilişim, Kodlama, Yazılım ve Robotik alanlarındaki eğitim çalışmalarında gösterilen başarı nedeniyle verilmiştir.
                </p>
                <div class="certificate-meta-row">
                    <div class="certificate-meta-item">
                        <span class="k">Sınıf / Şube</span>
                        <span id="teacher-certificate-class" class="v">-</span>
                    </div>
                    <div class="certificate-meta-item">
                        <span class="k">Toplam XP</span>
                        <span id="teacher-certificate-xp" class="v">0 XP</span>
                    </div>
                    <div class="certificate-meta-item">
                        <span class="k">Tamamlama</span>
                        <span id="teacher-certificate-completion" class="v">%0</span>
                    </div>
                    <div class="certificate-meta-item">
                        <span class="k">Veriliş Tarihi</span>
                        <span id="teacher-certificate-date" class="v">-</span>
                    </div>
                </div>
                <div class="certificate-footer-note">
                    <div class="certificate-sign-row">
                        <div class="certificate-sign-col">
                            <div class="certificate-sign-line"></div>
                            <div class="certificate-sign-role">Ders Öğretmeni</div>
                            <div id="teacher-certificate-teacher-name" class="certificate-sign-name">Ders Öğretmeni</div>
                        </div>
                        <div class="certificate-sign-col">
                            <div class="certificate-sign-line"></div>
                            <div class="certificate-sign-role">Okul Müdürü</div>
                            <div id="teacher-certificate-principal-name" class="certificate-sign-name">Okul Müdürü</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('pwa-init.js') }}?v={{ filemtime(public_path('pwa-init.js')) }}" defer></script>
    <script type="module" src="{{ asset('script.js') }}?v={{ filemtime(public_path('script.js')) }}"></script>
</body>
</html>

