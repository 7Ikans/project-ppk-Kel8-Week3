<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 40px;">
    <h2>Selamat Datang, Admin {{ auth()->user()->name }}!</h2>
    <p>Ini adalah halaman dashboard khusus admin.</p>
    
    <div style="margin: 30px 0;">
        <a href="{{ route('admin.users.index') }}" style="background-color: blue; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Kelola Pengguna</a>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" style="padding: 8px 15px; cursor: pointer;">Logout</button>
    </form>
</body>
</html>