<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 50px;">
    <h2>Silakan Login</h2>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div style="margin-bottom: 10px;">
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>