<!DOCTYPE html>
<html>
<head>
    <title>Manajemen User (SRS-08)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        .btn-add { background-color: blue; color: white; padding: 10px; text-decoration: none; border-radius: 5px; }
        .btn-back { background-color: gray; color: white; padding: 10px; text-decoration: none; border-radius: 5px; margin-left: 10px; }
        .btn-delete { background-color: red; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer; }
        .alert-success { color: green; font-weight: bold; margin-bottom: 10px; }
        .alert-error { color: red; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Daftar Pengguna Sistem</h2>
    
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.users.create') }}" class="btn-add">+ Tambah Akun Baru</a>
        <a href="/dashboard-admin" class="btn-back">Kembali ke Dashboard</a>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ strtoupper($user->role) }}</td>
                <td>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>