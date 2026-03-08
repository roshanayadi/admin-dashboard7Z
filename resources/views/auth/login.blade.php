<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DAS Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 25%, #047857 50%, #059669 75%, #10b981 100%);
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.08), transparent);
            top: -200px; right: -200px;
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.05), transparent);
            bottom: -150px; left: -100px;
            border-radius: 50%;
        }

        .login-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-logo .icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #059669, #10b981);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin-bottom: 16px;
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.35);
        }
        .login-logo h1 {
            font-size: 24px;
            font-weight: 800;
            color: #1f2937;
        }
        .login-logo p {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 15px;
        }
        .input-wrapper input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            background: white;
        }
        .input-wrapper input:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
            margin-top: 8px;
        }
        .login-btn:hover {
            background: linear-gradient(135deg, #047857, #065f46);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
            transform: translateY(-1px);
        }

        .error-msg {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <div class="icon"><i class="fas fa-leaf"></i></div>
            <h1>DAS Admin</h1>
            <p>Dynamic Agriculture System</p>
        </div>

        @if($errors->any())
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Enter your username" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="login-btn">
                <span>Login</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="footer-text">
            &copy; {{ date('Y') }} Dynamic Agriculture System
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
