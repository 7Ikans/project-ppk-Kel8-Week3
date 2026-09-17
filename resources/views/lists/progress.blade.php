<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress — {{ $list->name }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: #f3f4f6; min-height: 100vh; padding: 2rem; }
        .container { max-width: 600px; margin: 0 auto; }
        h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem; }
        .subtitle { color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem; }
        .card { background: #fff; border-radius: 0.5rem; box-shadow: 0 1px 4px rgba(0,0,0,0.08); padding: 1.5rem; margin-bottom: 1.25rem; }
        .card h2 { font-size: 1rem; font-weight: 600; margin-bottom: 1.25rem; color: #374151; }
        /* Progress bar */
        .percentage-label { font-size: 2.5rem; font-weight: 800; color: #3b82f6; text-align: center; margin-bottom: 0.5rem; }
        .progress-bar-wrap { background: #e5e7eb; border-radius: 9999px; height: 18px; overflow: hidden; margin-bottom: 0.75rem; }
        .progress-bar-fill { height: 100%; border-radius: 9999px; background: linear-gradient(90deg, #3b82f6, #06b6d4); transition: width 0.6s ease; }
        .progress-note { font-size: 0.85rem; color: #6b7280; text-align: center; }
        /* Stat cards */
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 1.25rem; }
        .stat { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1rem; text-align: center; }
        .stat-value { font-size: 1.75rem; font-weight: 700; }
        .stat-label { font-size: 0.78rem; color: #6b7280; margin-top: 0.25rem; }
        .stat.total   .stat-value { color: #374151; }
        .stat.done    .stat-value { color: #10b981; }
        .stat.pending .stat-value { color: #f59e0b; }
        /* Completed badge */
        .badge-done { display: inline-block; background: #d1fae5; color: #065f46; border-radius: 9999px; padding: 0.35rem 1rem; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem; }
        .badge-inprogress { display: inline-block; background: #dbeafe; color: #1e40af; border-radius: 9999px; padding: 0.35rem 1rem; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem; }
        .badge-empty { display: inline-block; background: #f3f4f6; color: #6b7280; border-radius: 9999px; padding: 0.35rem 1rem; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem; }
        .text-center { text-align: center; }
        .back-link { display: inline-block; margin-bottom: 1rem; color: #3b82f6; text-decoration: none; font-size: 0.9rem; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <a href="#" class="back-link">← Kembali ke List</a>

        <h1>Monitoring Progress</h1>
        <p class="subtitle">List: <strong>{{ $list->name }}</strong></p>

        {{-- SRS-07: Progress bar utama --}}
        <div class="card">
            <h2>Progress Penyelesaian Tugas</h2>

            @if ($totalTasks === 0)
                <p class="text-center" style="color:#9ca3af; padding: 1rem 0;">
                    Belum ada tugas dalam list ini.
                </p>
                <div class="text-center">
                    <span class="badge-empty">Belum ada tugas</span>
                </div>
            @else
                <div class="percentage-label">{{ $percentage }}%</div>

                <div class="progress-bar-wrap">
                    <div class="progress-bar-fill" style="width: {{ $percentage }}%"></div>
                </div>

                <p class="progress-note">
                    {{ $completedTasks }} dari {{ $totalTasks }} tugas selesai
                </p>

                <div class="text-center" style="margin-top: 0.75rem;">
                    @if ($percentage === 100)
                        <span class="badge-done">✓ Semua tugas selesai!</span>
                    @elseif ($percentage > 0)
                        <span class="badge-inprogress">Sedang dikerjakan</span>
                    @else
                        <span class="badge-empty">Belum ada yang selesai</span>
                    @endif
                </div>

                {{-- Statistik detail --}}
                <div class="stats">
                    <div class="stat total">
                        <div class="stat-value">{{ $totalTasks }}</div>
                        <div class="stat-label">Total Tugas</div>
                    </div>
                    <div class="stat done">
                        <div class="stat-value">{{ $completedTasks }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                    <div class="stat pending">
                        <div class="stat-value">{{ $pendingTasks }}</div>
                        <div class="stat-label">Belum Selesai</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
