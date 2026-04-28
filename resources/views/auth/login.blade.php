@extends('layouts.app')

@section('content')
<style>
    body.login-body{min-height:100vh;margin:0;background:url('{{ asset("assets/images/bg_login.jpg") }}') no-repeat center center fixed;background-size:cover;font-family:'Segoe UI',Arial,sans-serif}
    .login-header{width:100%;padding:18px 32px;display:flex;align-items:center;background:transparent;gap:15px}
    .logo-kabupaten{height:55px;flex-shrink:0}
    .desa-info{display:flex;flex-direction:column;justify-content:center;margin:0;padding-left:10px}
    .desa-info h1{margin:0;font-size:26px;color:#174087;font-weight:bold}
    .desa-info p{margin:2px 0 0 0;font-size:17px;color:#174087;font-weight:500}
    .login-container{display:flex;max-width:1000px;min-height:530px;margin:36px auto;border-radius:14px;background:rgba(255,255,255,0.80);box-shadow:0 8px 48px rgba(66,150,200,0.10);overflow:hidden}
    .login-left{width:50%;position:relative;background:#e5f4fd;display:flex;align-items:center}
    .img-bg-left{width:100%;height:100%;object-fit:cover;position:absolute}
    .left-overlay-content{position:relative;padding:60px 40px 0 45px;z-index:2}
    .logo-desa{position:absolute;top:-95px;left:0px;width:150px;height:auto;z-index:10}
    .left-overlay-content h2{font-size:42px;font-weight:bold;color:#002550;margin-top:48px}
    .left-overlay-content p{margin-top:28px;color:#082b4f;font-size:17px;width:90%;line-height:27px}
    .login-right{width:50%;padding:40px 38px;display:flex;flex-direction:column;align-items:center}
    .icon-user{width:110px;height:110px;border-radius:50%;background:linear-gradient(135deg,#99baf9 40%,#4782b1 100%);display:flex;align-items:center;justify-content:center;margin-bottom:26px;box-shadow:0 5px 20px rgba(110,180,255,0.16)}
    .icon-user svg{width:60px;height:60px;fill:#fff}
    .login-form{width:100%;max-width:340px}
    .form-group{margin-bottom:17px}
    .form-group label{font-weight:500;margin-bottom:6px}
    .form-group input{width:100%;padding:13px 12px 13px 40px;border-radius:7px;border:1px solid #b2b5ca;background:#f7faff;font-size:16px}
    .form-group input:focus{border:1.8px solid #4782b1}
    .btn-login{width:120px;height:38px;background:#36a3ff;color:#fff;font-weight:700;font-size:15px;border:none;border-radius:8px;cursor:pointer;display:block;margin:25px auto 0;text-align:center}
    .btn-login:hover{background:#0a77e4}
    .message.error{background:#ffe7e7;border:1px solid #ffa5a5;color:#da3535;padding:9px 17px;border-radius:6px;margin-bottom:15px}
    .form-group{position:relative}
    .icon-input{position:absolute;left:13px;top:34px;z-index:2;pointer-events:none}
    .input-icon-image{width:22px;height:22px;display:block;opacity:0.88}
    .form-group input{padding-left:48px}
</style>

<body class="login-body">
    <header class="login-header">
        <img src="{{ asset('assets/images/logo-nganjuk.png') }}" class="logo-kabupaten">
        <div class="desa-info">
            <h1>Desa Banjardowo</h1>
            <p>Kecamatan Lengkong, Kabupaten Nganjuk</p>
        </div>
    </header>

    <div class="login-container">
        <div class="login-left">
            <img src="{{ asset('assets/images/bg_sayap.jpg') }}" class="img-bg-left">
            <div class="left-overlay-content">
                <img src="{{ asset('assets/images/logo-big.png') }}" class="logo-desa">
                <h2>Hello,<br>Welcome!</h2>
                <p>Masuk untuk mengelola data dan layanan Desa Banjardowo.</p>
            </div>
        </div>

        <div class="login-right">
            <div class="icon-user">
                <svg viewBox="0 0 60 60"><circle cx="30" cy="22" r="14"/><ellipse cx="30" cy="44" rx="18" ry="11"/></svg>
            </div>

            @if($errors->any())<div class="message error">{{ $errors->first() }}</div>@endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <span class="icon-input"><img src="{{ asset('assets/icons/user.png') }}" alt="User" class="input-icon-image"></span>
                    <input type="text" name="username" value="{{ old('username') }}" required placeholder="Masukkan Username">
                </div>
                <button type="submit" class="btn-login">LOGIN</button>
            </form>
        </div>
    </div>
</body>
@endsection