<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .auth-card form input[type="text"],
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

        .login-link {
            margin-top: 10px;
            text-align: right;
            font-size: 0.875rem;
            color: #4a5568;
        }

        .login-link a {
            color: #4299e1;
            text-decoration: none;
        }

        .login-link a:hover {
            color: #2b6cb0;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <h1>Register</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-control">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
            </div>

            <div class="form-control">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username">
            </div>

            <div class="form-control">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
            </div>

            <div class="form-control">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            <a href="{{ route('login') }}">Already registered? Login</a>
        </div>
    </div>
</body>
</html>
