<!DOCTYPE html>
<html>
<head>
    <title>Tambah User Baru</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        input, select { padding: 8px; width: 300px; }
        .btn-save { background-color: green; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px; }
        .btn-cancel { text-decoration: none; color: black; margin-left: 10px; padding: 10px 15px; background-color: #ddd; border-radius: 5px; }
        .error-list { color: red; }
    </style>
</head>
<body>
    <h2>Form Tambah Akun Baru</h2>
    
    @if ($errors->any())
        <div class="error-list">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label>Role / Peran:</label>
            <select name="role" required>
                <option value="user">User Biasa</option>
                <option value="admin">Administrator</option>
            </select>
        </div>
        
        <button type="submit" class="btn-save">Simpan Akun</button>
        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
    </form>
</body>
</html>