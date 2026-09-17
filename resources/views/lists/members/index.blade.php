<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Member — {{ $list->name }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: #f3f4f6; min-height: 100vh; padding: 2rem; }
        .container { max-width: 700px; margin: 0 auto; }
        h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem; }
        .subtitle { color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem; }
        .card { background: #fff; border-radius: 0.5rem; box-shadow: 0 1px 4px rgba(0,0,0,0.08); padding: 1.5rem; margin-bottom: 1.5rem; }
        .card h2 { font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #374151; }
        .alert { padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.9rem; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error   { background: #fee2e2; color: #991b1b; }
        /* Form tambah member */
        .form-row { display: flex; gap: 0.75rem; }
        select { flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9rem; background: #fff; }
        .btn { padding: 0.5rem 1.25rem; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.9rem; font-weight: 500; }
        .btn-primary { background: #3b82f6; color: #fff; }
        .btn-primary:hover { background: #2563eb; }
        .btn-danger  { background: #ef4444; color: #fff; font-size: 0.8rem; padding: 0.35rem 0.75rem; }
        .btn-danger:hover { background: #dc2626; }
        /* Tabel member */
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th { text-align: left; padding: 0.5rem 0.75rem; color: #6b7280; font-weight: 600; border-bottom: 1px solid #e5e7eb; }
        td { padding: 0.65rem 0.75rem; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        .avatar { width: 32px; height: 32px; border-radius: 50%; background: #3b82f6; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; margin-right: 0.5rem; }
        .name-cell { display: flex; align-items: center; }
        .empty { color: #9ca3af; text-align: center; padding: 1.5rem 0; font-size: 0.9rem; }
        .back-link { display: inline-block; margin-bottom: 1rem; color: #3b82f6; text-decoration: none; font-size: 0.9rem; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <a href="#" class="back-link">← Kembali ke List</a>

        <h1>Kelola Member</h1>
        <p class="subtitle">List: <strong>{{ $list->name }}</strong></p>

        {{-- Pesan sukses / error --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        {{-- SRS-06: Form tambah member --}}
        <div class="card">
            <h2>Tambah Member Baru</h2>
            @if ($availableUsers->isEmpty())
                <p class="empty">Tidak ada user lain yang tersedia untuk ditambahkan.</p>
            @else
                <form method="POST" action="{{ route('lists.members.store', $list) }}">
                    @csrf
                    <div class="form-row">
                        <select name="user_id" required>
                            <option value="" disabled selected>-- Pilih User --</option>
                            @foreach ($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Tambah Member</button>
                    </div>
                </form>
            @endif
        </div>

        {{-- SRS-06: Daftar member saat ini --}}
        <div class="card">
            <h2>Member Saat Ini ({{ $members->count() }} orang)</h2>
            @if ($members->isEmpty())
                <p class="empty">Belum ada member. Tambahkan member di atas.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td>
                                    <div class="name-cell">
                                        <span class="avatar">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                        {{ $member->name }}
                                    </div>
                                </td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    <form method="POST"
                                          action="{{ route('lists.members.destroy', [$list, $member]) }}"
                                          onsubmit="return confirm('Hapus {{ $member->name }} dari list ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>
