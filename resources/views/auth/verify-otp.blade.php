<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi OTP</title>
</head>
<body>
    <h2>Masukkan OTP</h2>

    <form method="POST" action="{{ route('password.otp.verify') }}">
        @csrf
        <input type="text" name="otp" placeholder="Kode OTP" required>
        <button type="submit">Verifikasi</button>
    </form>
</body>
</html>