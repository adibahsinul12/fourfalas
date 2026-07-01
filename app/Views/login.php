<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FO'orders Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root{
    --brown:#6B3A1E;
    --green:#4CAF50;
    --cream:#FAF6EB;
    --border:#E5E5E5;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:var(--cream);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding: 12px; 
}

.login-card{
    width: 100%;
    max-width: 320px; /* Ukuran diperkecil agar pas di HP terkecil sekalipun */
    background:#fff;
    border-radius:16px;
    padding:22px 20px; /* Padding dipadatkan */
    box-shadow:0 8px 20px rgba(0,0,0,.04);
    transition: all 0.3s ease;
}

.logo{
    text-align:center;
    margin-bottom:4px;
}

.logo img{
    width:100%;
    max-width:85px; /* Logo diperkecil agar lebih estetik */
    height:auto;
}

.brand{
    text-align:center;
    font-size:22px; /* Ukuran teks judul diperkecil */
    font-weight:700;
    color:#4A2812;
    line-height: 1.2;
}

.brand span{
    color:var(--green);
}

.subtitle{
    text-align:center;
    color:#666;
    margin-top:2px;
    margin-bottom:18px;
    line-height:1.4;
    font-size: 11px; /* Subtitle dibuat mini */
}

.form-group{
    position:relative;
    margin-bottom:12px; /* Jarak antar input lebih rapat */
}

.left-icon{
    position:absolute;
    left:12px;
    top:50%;
    transform:translateY(-50%);
    color:#a0a0a0;
    font-size: 13px;
}

.eye{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    color:#a0a0a0;
    cursor:pointer;
    font-size: 13px;
}

.form-control{
    width:100%;
    height:40px; /* Tinggi kolom input diturunkan ke ukuran standar minimalis (40px) */
    border:1px solid var(--border);
    border-radius:8px;
    padding-left:36px;
    padding-right:36px;
    font-size:13px;
    outline:none;
    color: #333;
}

.form-control:focus{
    border-color:var(--green);
}

.option{
    display:flex;
    justify-content:space-between;
    align-items: center;
    margin-bottom:18px;
    font-size:11px; /* Teks opsi diperkecil */
}

.option label {
    display: flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    color: #555;
}

.option input{
    accent-color:var(--green);
    width: 12px;
    height: 12px;
    cursor: pointer;
}

.option a{
    text-decoration:none;
    color:#666;
}

.btn-login{
    width:100%;
    height:40px; /* Seimbang dengan tinggi kolom input */
    border:none;
    border-radius:8px;
    background:var(--green);
    color:#fff;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
}

.btn-login:hover{
    background:#43a047;
}

/* ==================== RESPONSIVE MEDIA QUERIES ==================== */

/* HP Layar Sangat Kecil (Lebar di bawah 320px) */
@media (max-width: 320px) {
    .login-card {
        padding: 18px 15px;
    }
    .option {
        flex-direction: column;
        gap: 6px;
        align-items: flex-start;
    }
}
</style>
</head>
<body>

<div class="login-card">

    <div class="logo">
        <img src="<?= base_url('assets/img/logo-pattern.png') ?>" alt="Logo Fourfalas">
    </div>

    <div class="brand">
        FO<span>'</span>orders
    </div>

    <div class="subtitle">
        Sistem Pemesanan &amp; Manajemen<br>
        Café Fourfalas
    </div>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div style="background-color: #FFEBEE; color: #F44336; padding: 8px 10px; border-radius: 6px; font-size: 11px; margin-bottom: 12px; text-align: center; font-weight: 500; border: 1px solid #FFCDD2;">
            <i class="fa-solid fa-circle-exclamation" style="margin-right: 4px;"></i>
            <?= session()->getFlashdata('msg'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post">

        <div class="form-group">
            <i class="fa-regular fa-user left-icon"></i>
            <input type="text"
                   name="username"
                   class="form-control"
                   placeholder="Username"
                   required>
        </div>

        <div class="form-group">
            <i class="fa-solid fa-lock left-icon"></i>

            <input type="password"
                   name="password"
                   id="password"
                   class="form-control"
                   placeholder="Password"
                   required>

            <i class="fa-regular fa-eye eye"
               id="togglePassword"></i>
        </div>

        <div class="option">
            <label>
                <input type="checkbox">
                Ingat saya
            </label>

            <a href="#" id="btnLupaPassword">Lupa password?</a>
        </div>

        <button type="submit" class="btn-login">
            Masuk
        </button>

        <div style="text-align:center; margin-top:14px; font-size:12px; color:#666;">
            Belum punya akun?
            <a href="<?= base_url('register') ?>" style="color:var(--green); font-weight:600; text-decoration:none;">
                Daftar di sini
            </a>
        </div>

    </form>

</div>

<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});

document.querySelector('#btnLupaPassword').addEventListener('click', function (e) {
    e.preventDefault(); 

    let konfirmasi = confirm("Apakah Anda adalah Administrator Utama sistem FO'orders?");

    if (konfirmasi) {
        alert("PENGAMANAN SISTEM:\n\nSebagai Administrator Utama, jika Anda lupa password, silakan buka phpMyAdmin -> database 'fourfalas' -> tabel 'admins', lalu perbarui field 'password_hash' Anda secara manual demi menjaga keamanan internal sistem.");
    } else {
        alert("Silakan hubungi Administrator Utama Café Fourfalas di ruang IT untuk mereset kata sandi akun staff Anda.");
    }
});
</script>

</body>
</html>