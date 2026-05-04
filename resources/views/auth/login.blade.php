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

        .login-header img {
            width: 45px;
        }

        .login-header h1 {
            font-size: 16px;
            margin: 0;
        }

        .login-header p {
            font-size: 12px;
            margin: 0;
        }

        /* ===== LOGIN BOX ===== */
        .login-box {
            width: 100%;
            max-width: 360px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 16px;
            padding: 30px 25px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            backdrop-filter: blur(8px);
            margin-top: 40px;
        }

        /* ===== TITLE ===== */
        .login-box h2 {
            font-size: 26px;
            color: #174087;
            margin-bottom: 10px;
        }

        .login-box p {
            font-size: 13px;
            color: #333;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        /* ===== FORM ===== */
        .login-form {
            width: 100%;
        }

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
            margin-bottom: 20px;
        }

        /* ===== BUTTON ===== */
        .btn-login {
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
        }

        /* ===== LINK ===== */
        .forgot-link {
            display: block;
            margin-top: 12px;
            font-size: 12px;
            color: #0a77e4;
            text-decoration: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .login-box {
                max-width: 300px;
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body class="login-body">

    <!-- HEADER -->
    <header class="login-header">
        <img src="{{ asset('assets/images/logo-nganjuk.png') }}">
        <div>
            <h1>Desa Banjardowo</h1>
            <p>Kecamatan Lengkong, Kabupaten Nganjuk</p>
        </div>
    </header>

    <!-- LOGIN BOX -->
    <div class="login-box">
        <h2>LOGIN ADMIN</h2>
        <p>MASUK UNTUK MENGELOLA DATA DAN LAYANAN DESA BANJARDOWO</p>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
            <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
        </form>
    </div>

</body>
</html>