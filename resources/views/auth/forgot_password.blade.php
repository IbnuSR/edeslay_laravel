<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - E-Deslay</title>
    <style>
        /* ===== PASTE CSS ASLI KAMU DI SINI ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body {
            background: url('{{ asset("assets/images/bg-bulu.jpeg") }}') no-repeat center center fixed;
            background-size: cover;
            display: flex; align-items: center; justify-content: center;
            min-height: 100vh; padding: 20px; background-color: #f0f5fa; position: relative;
        }
        .header-logo {
            position: absolute; top: 20px; left: 20px;
            display: flex; align-items: center; gap: 10px; z-index: 10;
        }
        .header-logo img { width: 50px; }
        .header-logo h1 { font-size: 16px; color: #2c3e50; line-height: 1.4; }
        .header-logo p { font-size: 14px; color: #7f8c8d; }
        .form-card {
            background: white; padding: 40px; border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 400px;
            width: 100%; text-align: center;
        }
        .form-card img.logo-e-deslay { height: 40px; margin-bottom: 20px; }
        .form-card h2 { font-size: 20px; color: #2c3e50; margin: 15px 0; line-height: 1.4; }
        .form-group { display: flex; flex-direction: column; gap: 8px; margin: 20px 0; }
        .form-group label { font-size: 14px; color: #34495e; font-weight: 500; text-align: left; }
        .form-group input {
            padding: 12px 16px; border: 1px solid #bdc3c7; border-radius: 8px;
            font-size: 14px; transition: border-color 0.2s;
        }
        .form-group input:focus { outline: none; border-color: #3498db; }
        .send-code-btn {
            background: none; border: none; color: #0531f8ff; font-size: 15px;
            cursor: pointer; text-align: right; display: block;
            width: fit-content; margin-left: auto; margin-top: 10px;
        }
        .btn-primary {
            padding: 12px 20px; background: #3498db; color: white;
            border: none; border-radius: 8px; font-size: 16px;
            cursor: pointer; transition: background-color 0.2s ease;
            width: 100%; margin: 10px 0;
        }
        .btn-primary:hover { background: #2980b9; }
        .back-link { font-size: 14px; }
        .back-link a { color: #3498db; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
        .alert { padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; text-align: center; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6da; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        @media (max-width: 768px) {
            .form-card { padding: 30px 20px; }
            .header-logo { top: 15px; left: 15px; }
        }
    </style>
</head>
<body>
    <!-- Header Logo -->
    <div class="header-logo">
        <img src="{{ asset('assets/images/logo-nganjuk.png') }}" alt="Logo Desa">
        <div>
            <h1>Desa Banjardowo</h1>
            <p>Kecamatan Lengkong</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <img src="{{ asset('assets/images/logo-big.png') }}" alt="E-Deslay Logo" class="logo-e-deslay">
        <h2>Kode OTP akan dikirimkan ke email Anda</h2>

        {{-- Tampilkan pesan status --}}
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if(session('debug_otp'))
            <div class="alert alert-success">🔧 Development Mode: OTP = {{ session('debug_otp') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        {{-- Form kirim OTP --}}
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Masukkan Email" required
                       value="{{ old('email') }}">
            </div>
            <button type="submit" name="kirim_otp" class="btn-primary">Kirim Kode OTP</button>
        </form>

        {{-- Link jika sudah dapat OTP, lanjut verifikasi --}}
        @if(session('status'))
            <div class="mt-4">
                <a href="{{ route('password.verify') }}" class="btn-primary" style="background:#28a745">
                    Lanjut Verifikasi OTP →
                </a>
            </div>
        @endif

        <div class="back-link">
            <a href="{{ route('login') }}">Kembali ke Halaman Login</a>
        </div>
    </div>
</body>
</html>