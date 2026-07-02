<?php ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Akun - FO'orders</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root{
    --brown:#6B3A1E;
    --green:#4CAF50;
    --green-deep:#3d8c40;
    --cream:#FAF6EB;
    --border:#E5E5E5;
    --text-muted:#8a8a8a;
}
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
body{
    background:var(--cream);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.auth-box{
    background:#fff;
    border-radius:16px;
    padding:36px 32px;
    width:100%;
    max-width:400px;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
}

.logo{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-size:22px;
    font-weight:700;
    color:var(--brown);
    margin-bottom:6px;
}
.logo i{ color:var(--green); font-size:24px; }

.subtitle{
    text-align:center;
    font-size:13px;
    color:var(--text-muted);
    margin-bottom:20px;
}

.role-note{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    margin-bottom:20px;
    background:#F1F8F1;
    color:var(--green-deep);
    font-size:11.5px;
    font-weight:500;
    padding:8px 12px;
    border-radius:20px;
    text-align:center;
}

.flash-msg{
    background:#FFEBEE;
    color:#C62828;
    border:1px solid #FFCDD2;
    padding:10px 14px;
    border-radius:8px;
    font-size:13px;
    margin-bottom:18px;
    text-align:center;
}

.field{ margin-bottom:16px; }
.field label{
    display:block;
    font-size:13px;
    color:#444;
    margin-bottom:6px;
    font-weight:500;
}

.input-wrap{ position:relative; }
.input-wrap i{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#b7a89b;
    font-size:14px;
}
.input-wrap input{
    width:100%;
    padding:11px 12px 11px 40px;
    border:1px solid var(--border);
    border-radius:8px;
    font-size:13px;
    font-family:inherit;
}
.input-wrap input::placeholder{ color:#c7c7c7; }
.input-wrap input:focus{
    outline:none;
    border-color:var(--green);
    box-shadow:0 0 0 3px rgba(76,175,80,.12);
}

.btn-submit{
    width:100%;
    background:var(--green);
    color:#fff;
    border:none;
    padding:12px;
    border-radius:8px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    margin-top:6px;
}
.btn-submit:hover{ background:var(--green-deep); }

.switch-link{
    text-align:center;
    font-size:13px;
    color:var(--text-muted);
    margin-top:20px;
}
.switch-link a{
    color:var(--green);
    font-weight:600;
    text-decoration:none;
}
.switch-link a:hover{ text-decoration:underline; }
</style>
</head>
<body>

<div class="auth-box">
    <div class="logo"><i class="fa-solid fa-mug-saucer"></i> FO'orders</div>
    <div class="subtitle">Buat akun baru untuk mengakses sistem</div>
    <div class="role-note"><i class="fa-solid fa-circle-info"></i> Akun baru otomatis terdaftar sebagai Kasir</div>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="flash-msg"><?= esc(session()->getFlashdata('msg')) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('register/store') ?>">

        <div class="field">
            <label>Username</label>
            <div class="input-wrap">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" placeholder="Masukkan username" value="<?= esc(old('username')) ?>" required>
            </div>
        </div>

        <div class="field">
            <label>Password</label>
            <div class="input-wrap">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required>
            </div>
        </div>

        <div class="field">
            <label>Konfirmasi Password</label>
            <div class="input-wrap">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="confirm_password" placeholder="Ulangi password" required>
            </div>
        </div>

        <button type="submit" class="btn-submit"><i class="fa-solid fa-user-plus"></i> Daftar</button>
    </form>

    <div class="switch-link">
        Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a>
    </div>
</div>

</body>
</html>