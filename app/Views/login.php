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
}

.login-card{
    width:500px;
    background:#fff;
    border-radius:25px;
    padding:35px 40px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}

.logo{
    text-align:center;
    margin-bottom:10px;
}

.logo img{
    width:220px;
    height:auto;
}

.brand{
    text-align:center;
    font-size:52px;
    font-weight:700;
    color:#4A2812;
}

.brand span{
    color:var(--green);
}

.subtitle{
    text-align:center;
    color:#444;
    margin-top:10px;
    margin-bottom:30px;
    line-height:1.8;
}

.form-group{
    position:relative;
    margin-bottom:20px;
}

.left-icon{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:#999;
}

.eye{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    color:#999;
    cursor:pointer;
}

.form-control{
    width:100%;
    height:60px;
    border:1px solid var(--border);
    border-radius:15px;
    padding-left:45px;
    padding-right:45px;
    font-size:15px;
    outline:none;
}

.form-control:focus{
    border-color:var(--green);
}

.option{
    display:flex;
    justify-content:space-between;
    margin-bottom:20px;
    font-size:14px;
}

.option input{
    accent-color:var(--green);
}

.option a{
    text-decoration:none;
    color:#666;
}

.btn-login{
    width:100%;
    height:60px;
    border:none;
    border-radius:15px;
    background:var(--green);
    color:#fff;
    font-size:18px;
    font-weight:600;
    cursor:pointer;
}

.btn-login:hover{
    background:#43a047;
}

.register{
    text-align:center;
    margin-top:20px;
}

.register a{
    color:var(--green);
    text-decoration:none;
    font-weight:600;
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

    <form action="<?= base_url('login/auth') ?>" method="post">

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

            <a href="#">Lupa password?</a>
        </div>

        <button type="submit" class="btn-login">
            Masuk
        </button>

    </form>

    <div class="register">
        Belum punya akun?
        <a href="#">Daftar di sini</a>
    </div>

</div>

<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function () {

    const type = password.getAttribute('type') === 'password'
        ? 'text'
        : 'password';

    password.setAttribute('type', type);

    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
</script>

</body>
</html>