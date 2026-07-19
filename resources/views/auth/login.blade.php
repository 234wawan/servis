<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Bengkel Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 1.5rem;
            text-align: center;
            position: relative;
        }
        .login-header .icon-wrap {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: #fff;
        }
        .login-header h4 {
            color: #fff;
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem;
        }
        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0.25rem 0 0;
            font-size: 0.9rem;
        }
        .login-body {
            padding: 2rem 2rem 1.5rem;
            background: #fff;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.7rem 2.8rem 0.7rem 2.5rem;
            border: 2px solid #e9ecef;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        .input-group-text {
            border: none;
            background: transparent;
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            padding: 0;
            color: #adb5bd;
            font-size: 1.2rem;
        }
        .input-wrap {
            position: relative;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            color: #fff;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .register-link {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }
        .register-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            left: auto;
            top: 50%;
            transform: translateY(-50%);
            z-index: 6;
            padding: 0;
            color: #adb5bd;
            font-size: 1.2rem;
            cursor: pointer;
            border: none;
            background: transparent;
        }
        .password-toggle:hover {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="login-card">
                    <div class="login-header">
                        <div class="icon-wrap">
                            <img src="{{ asset('img/motor.svg') }}" alt="Motor" height="40">
                        </div>
                        <h4>Bengkel Motor</h4>
                        <p>Masuk ke akun Anda</p>
                    </div>
                    <div class="login-body">
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span>{{ $errors->first('email') }}</span>
                            </div>
                        @endif
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="mb-3 input-wrap">
                                <i class="bi bi-envelope-fill input-group-text"></i>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
                            </div>
                            <div class="mb-3 input-wrap">
                                <i class="bi bi-lock-fill input-group-text"></i>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                <span class="input-group-text password-toggle" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                </span>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <button type="submit" class="btn btn-login w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </button>
                        </form>
                        <p class="text-center mt-4 mb-0">
                            Belum punya akun? <a href="{{ route('admin.register') }}" class="register-link">Daftar</a>
                        </p>
                    </div>
                </div>
                <p class="text-center text-white-50 mt-3" style="font-size: 0.85rem;">
                    &copy; {{ date('Y') }} Bengkel Motor. All rights reserved.
                </p>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>