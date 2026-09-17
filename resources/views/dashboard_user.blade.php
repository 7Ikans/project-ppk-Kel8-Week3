<!DOCTYPE html>
<html>
<head><title>Dashboard User</title></head>
<body>
    <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
    <p>Ini adalah halaman utama sistem untuk pengguna biasa.</p>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>