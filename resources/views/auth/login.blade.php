<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/app.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .auth-card {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .auth-card h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .auth-card form {
            display: flex;
            flex-direction: column;
        }
        .auth-card form .form-control {
            margin-bottom: 15px;
        }
        .auth-card form label {
            font-size: 0.875rem;
            margin-bottom: 5px;
            color: #4a5568;
        }
        .auth-card form input[type="email"],
        .auth-card form input[type="password"]{
            padding: 10px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            font-size: 1rem;
            width: 90%;
        }
        .auth-card form button {
            padding: 12px 20px;
            background-color: #4299e1;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        .auth-card form button:hover {
            background-color: #3182ce;
        }
        .forgot-password {
            margin-top: 10px;
            text-align: right;
            font-size: 0.875rem;
            color: #4a5568;
        }
        .forgot-password a {
            color: #4299e1;
            text-decoration: none;
            font-size: 0.875rem;
        }
        .forgot-password a:hover {
            color: #2b6cb0;
        }
        .register-link {
            margin-top: 10px;
            text-align: left;
            font-size: 0.875rem;
        }
        .register-link a {
            color: #4299e1;
            text-decoration: none;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <h1>Login</h1>

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 text-green-500">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-control">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <div class="form-control">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>

            <div class="form-control">
                <input type="checkbox" id="remember_me" name="remember">
                <label for="remember_me">Remember me</label>
            </div>

            <button type="submit">Log in</button>
        </form>

       <div class="login_bottom">
            <div class="register-link">
                @if (Route::has('register'))
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                @endif
            </div>
            @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>
            @endif
       </div>
    </div>
</body>
</html>
