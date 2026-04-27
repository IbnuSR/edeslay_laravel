<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Desa Banjardowo</title>

    <style>
        /* ===== CSS ASLI KAMU (TETAP SAMA) ===== */
        body.login-body {
            min-height: 100vh; margin: 0;
            background: url('{{ asset("assets/images/bg_login.jpg") }}') no-repeat center center fixed;
            background-size: cover; font-family: 'Segoe UI', Arial, sans-serif;
        }
        .login-header {
            width: 100%; padding: 18px 32px; display: flex;
            align-items: center; background: transparent; gap: 15px;
        }
        .logo-kabupaten { height: 55px; flex-shrink: 0; }
        .desa-info {
            display: flex; flex-direction: column; justify-content: center;
            margin: 0; padding-left: 10px; flex-grow: 0; flex-basis: auto;
        }
        .desa-info h1 {
            margin: 0; font-size: 26px; color: #174087; font-weight: bold;
        }
        .desa-info p {
            margin: 2px 0 0 0; font-size: 17px; color: #174087; font-weight: 500;
        }
        .login-container {
            display: flex; max-width: 1000px; min-height: 530px;
            margin: 36px auto; border-radius: 14px;
            background: rgba(255,255,255,0.80);
            box-shadow: 0 8px 48px rgba(66,150,200,0.10); overflow: hidden;
        }
        .login-left {
            width: 50%; position: relative; background: #e5f4fd;
            display: flex; align-items: center;
        }
        .img-bg-left {
            width: 100%; height: 100%; object-fit: cover; position: absolute;
        }
        .left-overlay-content {
            position: relative; padding: 60px 40px 0 45px; z-index: 2;
        }
        .logo-desa {
            position: absolute; top: -95px; left: 0px;
            width: 150px; height: auto; z-index: 10;
        }
        .left-overlay-content h2 {
            font-size: 42px; font-weight: bold; color: #002550; margin-top: 48px;
        }
        .left-overlay-content p {
            margin-top: 28px; color: #082b4f; font-size: 17px;
            width: 90%; line-height: 27px;
        }
        .login-right {
            width: 50%; padding: 40px 38px; display: flex;
            flex-direction: column; align-items: center;
        }
        .icon-user {
            width: 110px; height: 110px; border-radius: 50%;
            background: linear-gradient(135deg, #99baf9 40%, #4782b1 100%);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 26px; box-shadow: 0 5px 20px rgba(110,180,255,0.16);
        }
        .icon-user svg { width: 60px; height: 60px; fill: #fff; }
        .login-form { width: 100%; max-width: 340px; }
        .form-group { margin-bottom: 17px; }
        .form-group label { font-weight: 500; margin-bottom: 6px; }
        .form-group input {
            width: 100%; padding: 13px 12px 13px 40px; border-radius: 7px;
            border: 1px solid #b2b5ca; background: #f7faff; font-size: 16px;
        }
        .form-group input:focus { border: 1.8px solid #4782b1; }
        .btn-login {
            width: 120px; height: 38px; background: #36a3ff; color: #fff;
            font-weight: 700; font-size: 15px; border: none; border-radius: 8px;
            cursor: pointer; display: block; margin: 25px auto 0; text-align: center;
        }
        .btn-login:hover { background: #0a77e4; }
        .forgot-password {
            position: relative; left: 283px; top: -5px;
            color: #085b9c; font-size: 14px; text-decoration: none;
        }
        .forgot-password:hover { text-decoration: underline; }
        .message {
            padding: 9px 17px; border-radius: 6px; margin-bottom: 15px; font-size: 13px;
        }
        .message.error {
            background: #fee2e2; border: 1px solid #fecaca; color: #991b1b;
        }
        .message.success {
            background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46;
        }
        .form-group { position: relative; }
        .icon-input {
            position: absolute; left: 13px; top: 34px;
            z-index: 2; pointer-events: none;
        }
        .input-icon-image { width: 22px; height: 22px; display: block; opacity: 0.88; }
        .form-group input { padding-left: 48px; }
        .password-group { position: relative; }
        .password-group input { padding-right: 12px; }
        .toggle-password {
            position: absolute; right: -35px; top: 34px; cursor: pointer;
        }
        .toggle-password-icon { width: 22px; height: 22px; opacity: 0.9; }
        @media(max-width: 900px) {
            .login-container { flex-direction: column; }
            .login-left, .login-right { width: 100%; }
            .login-left { min-height: 220px; }
        }
    </style>
</head>

<body class="login-body">

<!-- Header -->
<header class="login-header">
    <img src="{{ asset('assets/images/logo-nganjuk.png') }}" class="logo-kabupaten">
    <div class="desa-info">
        <h1>Desa Banjardowo</h1>
        <p>Kecamatan Lengkong, Kabupaten Nganjuk</p>
    </div>
</header>

<!-- Login Container -->
<div class="login-container">

    <!-- Left Side (Image) -->
    <div class="login-left">
        <img src="{{ asset('assets/images/bg_sayap.jpg') }}" class="img-bg-left">
        <div class="left-overlay-content">
            <img src="{{ asset('assets/images/logo-big.png') }}" class="logo-desa">
            <h2>Hello,<br>Welcome!</h2>
            <p>Masuk untuk mengelola data dan layanan Desa Banjardowo.</p>
        </div>
    </div>

    <!-- Right Side (Form) -->
    <div class="login-right">
        <div class="icon-user">
            <svg viewBox="0 0 60 60">
                <circle cx="30" cy="22" r="14"/>
                <ellipse cx="30" cy="44" rx="18" ry="11"/>
            </svg>
        </div>

        {{-- ERROR / SUCCESS MESSAGES --}}
        @if(session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif
        @if(session('status'))
            <div class="message success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="message error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        {{-- LOGIN FORM --}}
        <form method="POST" action="{{ route('login') }}" class="login-form" autocomplete="off">
            @csrf
            
            {{-- USERNAME FIELD --}}
            <div class="form-group">
                <label for="username">Username</label>
                <span class="icon-input">
                    <img src="{{ asset('assets/icons/user.png') }}" alt="User" class="input-icon-image">
                </span>
                <input 
                    type="text" 
                    id="username"
                    name="username" 
                    value="{{ old('username') }}" 
                    required 
                    placeholder="Masukkan Username"
                    autocomplete="username"
                >
            </div>

            {{-- PASSWORD FIELD (Optional for Dev Mode) --}}
            <div class="form-group password-group">
                <label for="password">
                    Password 
                    <small style="color:#9ca3af;font-weight:normal;">(Opsional untuk testing)</small>
                </label>
                <span class="icon-input">
                    <img src="{{ asset('assets/icons/icon_kunci.png') }}" alt="Lock" class="input-icon-image">
                </span>
                <input 
                    type="password" 
                    id="passwordInput" 
                    name="password" 
                    placeholder="Boleh dikosongkan (Dev Mode)"
                    autocomplete="current-password"
                >
                <span class="toggle-password" onclick="togglePassword()">
                    <img src="{{ asset('assets/icons/mata_buka.png') }}" alt="Show Password" class="toggle-password-icon" id="eyeIcon">
                </span>
            </div>

            {{-- FORGOT PASSWORD LINK --}}
            <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
            
            {{-- LOGIN BUTTON --}}
            <button type="submit" class="btn-login">LOGIN</button>
        </form>
    </div>
</div>

{{-- JAVASCRIPT: Toggle Password Visibility --}}
<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const eye = document.getElementById('eyeIcon');
    
    if (!input || !eye) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        eye.src = '{{ asset("assets/icons/mata_tutup.png") }}';
        eye.alt = 'Hide Password';
    } else {
        input.type = 'password';
        eye.src = '{{ asset("assets/icons/mata_buka.png") }}';
        eye.alt = 'Show Password';
    }
}

// Auto-focus username field on load
document.addEventListener('DOMContentLoaded', function() {
    const usernameInput = document.getElementById('username');
    if (usernameInput) {
        usernameInput.focus();
    }
});
</script>

</body>
</html>