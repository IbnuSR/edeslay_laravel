<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Banjardowo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ===== BODY ===== */
        body.login-body {
            min-height: 100vh;
            margin: 0;
            background: url('{{ asset("assets/images/bg_login.svg") }}') no-repeat center;
            background-size: cover;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ===== HEADER ===== */
        .login-header {
            position: absolute;
            top: 20px;
            left: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .login-header img { width: 45px; }
        .login-header h1 { font-size: 16px; margin: 0; }
        .login-header p { font-size: 12px; margin: 0; }

        /* ===== LOGIN BOX ===== */
        .login-box {
            width: 100%;
            max-width: 360px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 30px 25px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            margin-top: 40px;
        }

        /* ===== TITLE ===== */
        .login-box h2 { font-size: 26px; color: #174087; margin-bottom: 10px; }
        .login-box p { font-size: 13px; color: #333; margin-bottom: 25px; line-height: 1.5; }

        /* ===== ALERT ERROR ===== */
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-error i { font-size: 16px; }

        /* ===== ALERT SUCCESS ===== */
        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ===== FORM ===== */
        .login-form { width: 100%; }

        /* ===== FORM GROUP ===== */
        .form-group {
            width: 100%;
            margin-bottom: 4px;
            text-align: left;
        }
        .form-group label {
            font-size: 13px;
            margin-bottom: 5px;
            display: block;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-sizing: border-box;
            margin-bottom: 5px;
            transition: border-color 0.2s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #79A6F2;
            box-shadow: 0 0 0 3px rgba(121, 166, 242, 0.1);
        }
        .form-group input.is-invalid {
            border-color: #dc2626;
            background-color: #fef2f2;
        }
        .error-message {
            color: #dc2626;
            font-size: 11px;
            margin-top: 3px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .error-message i { font-size: 12px; }

        /* ===== BUTTON ===== */
        .btn-login {
            width: 50%;
            padding: 10px;
            background: linear-gradient(135deg, #79A6F2, #174087);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(23, 64, 135, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(23, 64, 135, 0.4);
        }
        .btn-login:active { transform: translateY(0); }

        /* ===== LINK ===== */
        .forgot-link {
            display: block;
            margin-top: 15px;
            font-size: 12px;
            color: #0a77e4;
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #174087; text-decoration: underline; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .login-box { max-width: 300px; padding: 25px 20px; }
        }
    </style>
</head>
<body class="login-body">

    <!-- HEADER -->
    <header class="login-header">
        <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo">
        <div>
            <h1>Desa Banjardowo</h1>
            <p>Kecamatan Lengkong, Kabupaten Nganjuk</p>
        </div>
    </header>

    <!-- LOGIN BOX -->
    <div class="login-box">
        <h2>LOGIN ADMIN</h2>
        <p>MASUK UNTUK MENGELOLA DATA DAN LAYANAN DESA BANJARDOWO</p>

        {{-- ✅ TAMPILKAN ERROR GLOBAL --}}
        @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ TAMPILKAN SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form" novalidate>
            @csrf

            {{-- Username --}}
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username"
                    name="username" 
                    placeholder="Masukkan Username" 
                    value="{{ old('username') }}"
                    class="@error('username') is-invalid @enderror"
                    required
                    autofocus
                >
                @error('username')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Masukkan Password"
                    class="@error('password') is-invalid @enderror"
                    required
                >
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
            <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
        </form>
    </div>

    {{-- Auto-hide alert after 5 seconds --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-success, .alert-error');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>

</body>
</html>
