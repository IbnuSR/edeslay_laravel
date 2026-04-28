@extends('layouts.app')

@section('content')
<style>
/* ===== BODY ===== */
body.forgot-body {
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
.header-logo {
    position: absolute;
    top: 20px;
    left: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-logo img {
    width: 45px;
}

.header-logo h1 {
    font-size: 16px;
    margin: 0;
}

.header-logo p {
    font-size: 12px;
    margin: 0;
}

/* ===== CARD ===== */
.form-card {
    width: 100%;
    max-width: 350px;

    background: rgba(255,255,255,0.7); /* 🔥 transparan 70% */
    border-radius: 16px;

    padding: 30px 25px;
    text-align: center;

    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    backdrop-filter: blur(8px);
}

/* ===== TITLE ===== */
.form-card h2 {
    font-size: 15px;
    color: #174087;
    margin-bottom: 30px;
    line-height: 1.4;
}

/* ===== LOGO ===== */
.logo-e-deslay {
    height: 70px;   /* 🔥 dari 40 → 60 */
    margin-bottom: 5px;
}

/* ===== FORM ===== */
.form-group {
    width: 100%;
    margin-bottom: 16px;
    text-align: left;
}

.form-group label {
    font-size: 13px;
    margin-bottom: 10px;
    display: block;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

/* ===== BUTTON ===== */
/* ===== BUTTON (SAMA KAYAK LOGIN) ===== */
.btn-primary {
    width: 50%;
    padding: 7px;

    background: #79A6F2;
    color: #ffffff;

    border: none;
    border-radius: 10px;

    font-size: 12px;
    font-weight: 600;

    cursor: pointer;

    box-shadow: 
        0 1px 0 #000000,
        0 5px 5px #79A6F2;

    transition: 0.2s;

    display: block;
    margin: 10px auto 0; /* 🔥 biar center */
}

.btn-primary:active {
    transform: translateY(2px);
    box-shadow: 
        0 0px 0 #000000,
        0 3px 3px #79A6F2;
}

.btn-primary:hover {
    opacity: 0.9;
}

/* BUTTON LANJUT OTP */
.btn-success {
    display: block;
    width: 100%;
    padding: 12px;
    margin-top: 12px;

    background: #28a745;
    color: #fff;

    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

/* ===== ALERT ===== */
.alert {
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 13px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
}

/* ===== LINK ===== */
.back-link {
    margin-top: 15px;
    font-size: 13px;
}

.back-link a {
    color: #0a77e4;
    text-decoration: none;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 480px) {
    .form-card {
        max-width: 300px;
        padding: 25px 20px;
    }
}
</style>

<body class="forgot-body">

<!-- HEADER -->
<div class="header-logo">
    <img src="{{ asset('assets/images/logo-nganjuk.png') }}">
    <div>
        <h1>Desa Banjardowo</h1>
        <p>Kecamatan Lengkong, Kabupaten Nganjuk</p>
    </div>
</div>

<!-- CARD -->
<div class="form-card">

    <img src="{{ asset('assets/images/logo-big.png') }}" class="logo-e-deslay">

    <h2>KODE OTP AKAN DIKIRIM KE EMAIL ANDA</h2>

    {{-- ALERT --}}
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if(session('debug_otp'))
        <div class="alert alert-success">OTP: {{ session('debug_otp') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    {{-- FORM --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan Email" required value="{{ old('email') }}">
        </div>

        <button type="submit" class="btn-primary">Kirim Kode OTP</button>
    </form>

    {{-- LANJUT OTP --}}
    @if(session('status'))
        <a href="{{ route('password.verify') }}" class="btn-success">
            Lanjut Verifikasi OTP →
        </a>
    @endif

    <div class="back-link">
        <a href="{{ route('login') }}">← Kembali ke Login</a>
    </div>

</div>

</body>
@endsection