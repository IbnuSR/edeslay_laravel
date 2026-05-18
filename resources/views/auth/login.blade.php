<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Banjardowo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ===== RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body.login-body {
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: url('{{ asset("assets/img/bg-login-main.png") }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* ===== HEADER LOGO ===== */
        .login-header {
            position: relative;
            z-index: 2;
            text-align: center;
            margin-bottom: 25px;
        }
      .login-header img {
    width: 50px;
    height: auto; /* Otomatis menyesuaikan aspect ratio asli */
    margin-bottom: 5px;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
}
        .login-header h1 {
            font-size: 20px;
            color: #fff;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }
        .login-header p {
            font-size: 11px;
            color: #e0e0e0;
            text-shadow: 0 1px 5px rgba(0,0,0,0.5);
        }

        /* ===== LOGIN CARD CONTAINER ===== */
        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 950px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            background: white;
            min-height: 500px;
        }

        /* ===== LEFT SIDE - WELCOME (VARIASI 1: WAVE LINES) ===== */
        .login-welcome-section {
            flex: 1;
            background: url('{{ asset("assets/img/foto-desa.png") }}') no-repeat center center;
            background-size: cover;
            position: relative;
            padding: 50px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
        }

        /* Overlay dengan gradient mesh + pattern */
/* Overlay Biru Transparan (Foto Desa Tetap Terlihat) */
.login-welcome-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* Opacity 0.55 = Biru cukup terasa, foto desa tetap jelas di belakangnya */
    background: 
        linear-gradient(125deg, rgba(8, 20, 70, 0.55) 0%, rgba(15, 40, 120, 0.50) 50%, rgba(10, 30, 100, 0.55) 100%),
        repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.02) 35px, rgba(255,255,255,.02) 70px);
    z-index: 1;
}

        /* Wave decoration - atas */
        .wave-top {
            position: absolute;
            top: -100px;
            left: -50%;
            width: 200%;
            height: 300px;
            background: radial-gradient(ellipse at center, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
            transform: rotate(-5deg);
            z-index: 2;
            pointer-events: none;
        }

        /* Wave decoration - bawah */
        .wave-bottom {
            position: absolute;
            bottom: -80px;
            right: -30%;
            width: 160%;
            height: 250px;
            background: radial-gradient(ellipse at center, rgba(121, 166, 242, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            transform: rotate(3deg);
            z-index: 2;
            pointer-events: none;
        }

        /* Corner accent - kiri atas */
        .corner-accent {
            position: absolute;
            top: 0;
            left: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, rgba(121, 166, 242, 0.4) 0%, transparent 100%);
            border-radius: 0 0 100% 0;
            z-index: 2;
            pointer-events: none;
        }

        /* Corner accent - kanan bawah */
        .corner-accent-2 {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: linear-gradient(315deg, rgba(121, 166, 242, 0.3) 0%, transparent 100%);
            border-radius: 100% 0 0 0;
            z-index: 2;
            pointer-events: none;
        }

        /* Grid pattern overlay */
        .grid-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: 2;
            pointer-events: none;
        }

        /* Floating circles */
        .floating-circle {
    position: absolute;
    /* GANTI: Warna solid tipis, bukan gradasi transparan */
    background: rgba(255, 255, 255, 0.06);
    /* GANTI: Border lebih tegas & jelas */
    border: 2px solid rgba(255, 255, 255, 0.45);
    border-radius: 50%;
    z-index: 2;
    pointer-events: none;
    
    /* Kalau mau diam total (gak gerak), HAPUS baris di bawah ini */
    animation: float 6s ease-in-out infinite;
}
        .circle-1 { top: 10%; right: 10%; width: 200px; height: 200px; }
        .circle-2 { bottom: 20%; left: 5%; width: 120px; height: 120px; animation-delay: 1s; }
        .circle-3 { top: 50%; right: 5%; width: 80px; height: 80px; animation-delay: 2s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
            50% { transform: translateY(-20px) scale(1.05); opacity: 0.9; }
        }

        .welcome-content {
            position: relative;
            z-index: 3;
            width: 100%;
        }

        .welcome-icon {
            width: 65px;
            height: 65px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .welcome-icon i { font-size: 30px; color: white; }

.welcome-content h2 {
    font-size: 34px;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    
    /* WAJIB TAMBAH INI: */
    display: inline-block;
    border-right: 3px solid rgba(255,255,255,0.8);
    animation: kedipKursor 0.8s step-end infinite;
}

@keyframes kedipKursor {
    0%, 100% { border-color: rgba(255,255,255,0.8); }
    50% { border-color: transparent; }
}
        .welcome-content p {
            font-size: 16px;
            margin-bottom: 5px;
            opacity: 0.9;
            font-weight: 400;
        }
        .welcome-content .brand-name {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #fff;
            letter-spacing: 0.5px;
        }
        .divider {
            width: 80px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            margin-bottom: 25px;
            border-radius: 2px;
        }
        .tagline {
            font-size: 15px;
            line-height: 1.6;
            opacity: 0.85;
            font-style: italic;
        }

        /* ===== RIGHT SIDE - FORM (PUTIH) ===== */
        .login-form-section {
            flex: 1;
            padding: 50px 40px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-form-section h2 {
            font-size: 30px;
            color: #1e3a8a;
            margin-bottom: 8px;
            font-weight: 700;
        }
        .login-form-section .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 35px;
        }
        

        /* ===== ALERT BOXES ===== */
        .alert-error, .alert-success {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        .alert-error ul { margin: 0; padding-left: 20px; }
        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
        }

        /* ===== FORM GROUP ===== */
        .form-group { margin-bottom: 22px; }
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .input-wrapper { position: relative; }
        .input-wrapper i.input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            z-index: 2;
        }
        .form-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
            background: #f9fafb;
        }
        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .form-group input.is-invalid {
            border-color: #dc2626;
            background: #fef2f2;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            font-size: 16px;
            transition: color 0.2s;
            z-index: 2;
        }
        .toggle-password:hover { color: #3b82f6; }
        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* ===== BUTTON ===== */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
            margin-top: 10px;
            letter-spacing: 0.5px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.4);
        }
        .btn-login:active { transform: translateY(0); }

        /* ===== FORGOT PASSWORD ===== */
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        .forgot-password a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.2s;
        }
        .forgot-password a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        /* ===== FOOTER ===== */
        .login-footer {
            position: relative;
            z-index: 2;
            margin-top: 20px;
            text-align: center;
            color: rgba(255,255,255,0.8);
            font-size: 12px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .login-header h1 { font-size: 24px; }
            .login-header img { width: 55px; height: 55px; }
            .login-wrapper { max-width: 100%; margin: 0 10px; }
            .login-welcome-section { display: none; }
            .login-form-section {
                padding: 35px 25px;
                border-radius: 20px;
            }
            .login-form-section h2 { font-size: 26px; }
        }
    </style>
</head>
<body class="login-body">

    <!-- HEADER LOGO -->
    <header class="login-header">
        <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo Desa Banjardowo">
        <h1>DESA BANJARDOWO</h1>
        <p>KECAMATAN LENGKONG, KABUPATEN NGANJUK</p>
    </header>

    <!-- LOGIN CARD -->
    <div class="login-wrapper">
        
        <!-- LEFT: WELCOME (VARIASI 1: WAVE LINES) -->
        <div class="login-welcome-section">
            <!-- Dekorasi Wave Lines -->
            <div class="wave-top"></div>
            <div class="wave-bottom"></div>
            <div class="corner-accent"></div>
            <div class="corner-accent-2"></div>
            <div class="grid-pattern"></div>
            <div class="floating-circle circle-1"></div>
            <div class="floating-circle circle-2"></div>
            <div class="floating-circle circle-3"></div>
            
            <!-- Konten Welcome -->
            <div class="welcome-content">
                <div class="welcome-icon">
                    <i class="fas fa-university"></i>
                </div>
                <h2>Selamat Datang</h2>
                <p>di Sistem Informasi</p>
                <p class="brand-name">Desa Banjardowo</p>
                <div class="divider"></div>
                <p class="tagline">
                    Melayani dengan transparan,<br>
                    membangun desa dengan hati.
                </p>
            </div>
        </div>

        <!-- RIGHT: FORM (PUTIH) -->
        <div class="login-form-section">
            <h2>Login</h2>
            <p class="subtitle">Masuk untuk mengakses sistem</p>

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

            @if (session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="username" name="username" 
                            placeholder="Masukkan username" value="{{ old('username') }}"
                            class="@error('username') is-invalid @enderror" required autofocus>
                    </div>
                    @error('username')
                        <div class="error-message">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" 
                            placeholder="Masukkan password"
                            class="@error('password') is-invalid @enderror" required>
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Masuk</button>
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Lupa Password?</a>
                </div>
            </form>
        </div>

    </div>

    <!-- FOOTER -->
    <footer class="login-footer">
        <p>&copy; {{ date('Y') }} Desa Banjardowo. All rights reserved.</p>
    </footer>

    {{-- SCRIPTS --}}
    <script>
    // Toggle Password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Auto-hide alerts
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

    // 🎯 ANIMASI MENGETIK LOOPING (TIPE → JEDA 2 DETIK → HAPUS → ULANG)
    const judulElemen = document.querySelector('.welcome-content h2');
    const teksAsli = judulElemen.textContent.trim(); // Simpan teks asli
    judulElemen.textContent = ''; // Kosongkan awal

    let indeks = 0;
    let isDeleting = false;
    let waktuDelay = 80;

    function efekKetikLoop() {
        if (!isDeleting) {
            // Sedang mengetik
            if (indeks < teksAsli.length) {
                judulElemen.textContent = teksAsli.substring(0, indeks + 1);
                indeks++;
                waktuDelay = 80; // Kecepatan ketik normal
            } else {
                // Teks selesai, JEDA 2 DETIK sebelum menghapus
                isDeleting = true;
                waktuDelay = 2000; // ← INI KONTROL JEDA 2 DETIK
            }
        } else {
            // Sedang menghapus (backspace)
            if (indeks > 0) {
                judulElemen.textContent = teksAsli.substring(0, indeks - 1);
                indeks--;
                waktuDelay = 50; // Hapus lebih cepat biar smooth
            } else {
                // Selesai hapus, jeda sebentar lalu ketik ulang
                isDeleting = false;
                waktuDelay = 600; // Jeda sebelum mulai ngetik lagi
            }
        }
        setTimeout(efekKetikLoop, waktuDelay);
    }

    // Mulai animasi setelah halaman siap
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(efekKetikLoop, 800);
    });
</script>
</body>
</html>