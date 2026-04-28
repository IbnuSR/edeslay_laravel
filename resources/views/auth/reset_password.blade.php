<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password</title>

<style>
/* ===== BODY ===== */
body {
    min-height: 100vh;
    margin: 0;

    background: url('assets/images/bg_login.svg') no-repeat center;
    background-size: cover;

    font-family: 'Segoe UI', Arial, sans-serif;

    display: flex;
    justify-content: center;
    align-items: center;
}

/* ===== HEADER (SAMA SEMUA) ===== */
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
    max-width: 360px;

    background: rgba(255,255,255,0.7); /* 🔥 transparan */
    border-radius: 16px;

    padding: 30px 25px;
    text-align: center;

    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    backdrop-filter: blur(8px);

    margin-top: 40px;
}

/* ===== LOGO ===== */
.logo-e-deslay {
    height: 65px;
    margin-bottom: 10px;
}

/* ===== TITLE ===== */
.form-card h2 {
    font-size: 22px;
    color: #174087;
    margin-bottom: 5px;
}

.subtitle {
    font-size: 13px;
    color: #333;
    margin-bottom: 20px;
}

/* ===== FORM ===== */
.form-group {
    width: 100%;
    margin-bottom: 10px;
    text-align: left;
    position: relative;
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
    margin-bottom: 15px;
}

/* ===== EYE ICON ===== */
.toggle-password {
    position: absolute;
    right: 12px;
    top: 70%;
    transform: translateY(-50%);
    cursor: pointer;
}

.eye-icon {
    width: 20px;
}

/* ===== BUTTON (SAMA KAYAK LOGIN) ===== */
.btn-primary {
    width: 50%;
    padding: 7px;

    background: #79A6F2;
    color: #fff;

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
    margin: 10px auto 0;
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

/* ===== LINK ===== */
.back-link {
    margin-top: 15px;
    font-size: 12px;
}

.back-link a {
    color: #0a77e4;
    text-decoration: none;
}

/* ===== ALERT ===== */
.alert {
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 13px;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 480px) {
    .form-card {
        max-width: 300px;
        padding: 25px 20px;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header-logo">
    <img src="assets/images/logo-nganjuk.png">
    <div>
        <h1>Desa Banjardowo</h1>
        <p>Kecamatan Lengkong, Kabupaten Nganjuk</p>
    </div>
</div>

<!-- CARD -->
<div class="form-card">

    <img src="assets/images/logo-big.png" class="logo-e-deslay">

    <h2>RESET PASSWORD</h2>
    <p class="subtitle">Password minimal 8 karakter</p>

    <?php if ($message): ?>
        <?= $message ?>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" id="password" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">
                <img src="assets/icons/mata_buka.png" class="eye-icon">
            </span>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <span class="toggle-password" onclick="togglePassword('confirm_password', this)">
                <img src="assets/icons/mata_buka.png" class="eye-icon">
            </span>
        </div>

        <button type="submit" name="reset" class="btn-primary">
            SIMPAN
        </button>

        <div class="back-link">
            <a href="lupa_password.php">← Kembali ke OTP</a>
        </div>

    </form>
</div>

<script>
function togglePassword(id, el) {
    const input = document.getElementById(id);
    const img = el.querySelector("img");

    if (input.type === "password") {
        input.type = "text";
        img.src = "assets/icons/mata_tutup.png";
    } else {
        input.type = "password";
        img.src = "assets/icons/mata_buka.png";
    }
}
</script>

</body>
</html>