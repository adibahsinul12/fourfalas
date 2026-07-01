<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaturan - FO'orders</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root{
    --brown:#6B3A1E;
    --green:#4CAF50;
    --cream:#FAF6EB;
    --border:#E5E5E5;
    --text-muted:#8a8a8a;
}
html{ scrollbar-gutter: stable; }
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
body{ background:var(--cream); display:flex; min-height:100vh; }

/* ===== Sidebar ===== */
.sidebar{
    width:260px; background:var(--brown); color:#fff;
    display:flex; flex-direction:column; padding:24px 18px;
    flex-shrink:0; position:sticky; top:0; height:100vh; overflow-y:auto;
}
.sidebar .logo{
    display:flex; align-items:center; gap:10px; font-size:20px; font-weight:700;
    margin-bottom:32px; padding-left:6px;
}
.sidebar .logo i{ color:var(--green); font-size:22px; }
.nav-item{
    display:flex; align-items:center; gap:12px; padding:11px 14px; border-radius:8px;
    color:#e8ded6; text-decoration:none; font-size:14px; margin-bottom:4px; transition:.15s;
}
.nav-item i{ width:18px; text-align:center; }
.nav-item:hover{ background:rgba(255,255,255,.08); }
.nav-item.active{ background:var(--green); color:#fff; font-weight:600; }
.nav-bottom{ margin-top:auto; }

/* ===== Main content ===== */
.main{ flex:1; padding:28px 32px; min-width:0; overflow-x:hidden; }
.topbar{ display:flex; justify-content:flex-end; align-items:center; gap:16px; margin-bottom:24px; }
.owner-chip{ display:flex; align-items:center; gap:10px; background:#fff; padding:8px 14px; border-radius:10px; font-size:13px; }
.owner-chip i{ background:var(--brown); color:#fff; padding:8px; border-radius:50%; }
.owner-chip .role{ color:var(--text-muted); font-size:11px; }

.flash-msg{
    background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:20px;
}
.flash-error{
    background:#FFEBEE; color:#C62828; border:1px solid #FFCDD2;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:20px;
}
.error-list{
    background:#FFEBEE; color:#C62828; border:1px solid #FFCDD2;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:20px;
}
.error-list ul{ margin:4px 0 0 18px; }

/* ===== Panels ===== */
.panels{ display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start; }
.panel{
    background:#fff; border-radius:14px; padding:24px; box-shadow:0 4px 14px rgba(0,0,0,.03); margin-bottom:20px;
}
.panel h3{ font-size:15px; color:#333; margin-bottom:6px; }
.panel .sub{ font-size:12px; color:var(--text-muted); margin-bottom:20px; }

.field{ margin-bottom:16px; }
.field label{ display:block; font-size:13px; color:#444; margin-bottom:6px; font-weight:500; }
.field input[type="text"],
.field input[type="time"],
.field input[type="number"],
.field input[type="password"]{
    width:100%; padding:10px 12px; border:1px solid var(--border); border-radius:8px;
    font-size:13px; font-family:inherit;
}
.field input:focus{ outline:none; border-color:var(--green); }
.field .hint{ font-size:11px; color:var(--text-muted); margin-top:4px; }

.field-row{ display:grid; grid-template-columns:1fr 1fr; gap:14px; }

.logo-preview{
    display:flex; align-items:center; gap:14px; margin-bottom:16px;
}
.logo-preview img{
    width:64px; height:64px; border-radius:10px; object-fit:cover; border:1px solid var(--border);
}
.logo-preview .placeholder{
    width:64px; height:64px; border-radius:10px; border:1px dashed var(--border);
    display:flex; align-items:center; justify-content:center; color:var(--text-muted); font-size:20px;
}

.btn-submit{
    background:var(--green); color:#fff; border:none; padding:11px 24px;
    border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; margin-top:6px;
}
.btn-submit:hover{ opacity:.9; }
.btn-submit.brown{ background:var(--brown); }

/* ===== Hamburger ===== */
.hamburger{
    display:none; background:#fff; border:1px solid var(--border); width:38px; height:38px;
    border-radius:8px; align-items:center; justify-content:center; font-size:16px; color:var(--brown);
    cursor:pointer; margin-right:auto;
}
.sidebar-overlay{ display:none; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:40; }
.sidebar-overlay.show{ display:block; }

@media (max-width: 1100px){
    .panels{ grid-template-columns:1fr; }
    .sidebar{ width:220px; }
}
@media (max-width: 900px){
    .sidebar{
        position:fixed; left:0; top:0; width:240px; height:100vh; z-index:50;
        transform:translateX(-100%); transition:transform .25s ease;
    }
    .sidebar.open{ transform:translateX(0); }
    .main{ padding:20px 18px; width:100%; }
    .hamburger{ display:flex; }
    .topbar{ justify-content:space-between; }
}
@media (max-width: 600px){
    .panel{ padding:18px; }
    .field-row{ grid-template-columns:1fr; }
    main.main{ padding:16px 14px; }
}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="logo"><i class="fa-solid fa-mug-saucer"></i> FO'orders</div>

    <a href="<?= base_url('owner') ?>" class="nav-item active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="<?= base_url('owner/karyawan') ?>" class="nav-item"><i class="fa-solid fa-users"></i> Tenaga Kerja</a>
    <a href="<?= base_url('owner/rating') ?>" class="nav-item"><i class="fa-solid fa-star"></i> Rating & Ulasan</a>
    <a href="<?= base_url('owner/laporan') ?>" class="nav-item"><i class="fa-solid fa-chart-line"></i> Laporan Keuangan</a>
    <a href="<?= base_url('owner/pengaturan') ?>" class="nav-item"><i class="fa-solid fa-gear"></i> Pengaturan</a>


    <div class="nav-bottom">
        <a href="<?= base_url('logout') ?>" class="nav-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <button type="button" class="hamburger" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
        <div class="owner-chip">
            <i class="fa-solid fa-user-tie"></i>
            <div>
                <div><?= esc(session()->get('username') ?? 'Owner') ?></div>
                <div class="role">Owner</div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="flash-msg"><?= esc(session()->getFlashdata('msg')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('msg_error')) : ?>
        <div class="flash-error"><?= esc(session()->getFlashdata('msg_error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="error-list">
            <strong>Ada yang perlu diperbaiki:</strong>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <h2 style="margin-bottom:20px; color:#333;">Pengaturan</h2>

    <div class="panels">
        <!-- Info Cafe -->
        <div class="panel">
            <h3>Info Cafe</h3>
            <div class="sub">Pengaturan umum yang tampil di halaman pelanggan</div>

            <form method="post" action="<?= base_url('owner/pengaturan/update-settings') ?>" enctype="multipart/form-data">

                <div class="logo-preview">
                    <?php if (! empty($settings['logo_path'])) : ?>
                        <img src="<?= base_url($settings['logo_path']) ?>" alt="Logo cafe">
                    <?php else : ?>
                        <div class="placeholder"><i class="fa-solid fa-mug-saucer"></i></div>
                    <?php endif; ?>
                    <div class="field" style="margin-bottom:0; flex:1;">
                        <label>Ganti Logo (opsional)</label>
                        <input type="file" name="logo" accept="image/*">
                    </div>
                </div>

                <div class="field">
                    <label>Nama Cafe</label>
                    <input type="text" name="cafe_name" value="<?= esc(old('cafe_name', $settings['cafe_name'])) ?>" required>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label>Jam Buka</label>
                        <input type="time" name="operating_hours_open"
                               value="<?= esc(old('operating_hours_open', substr($settings['operating_hours_open'], 0, 5))) ?>" required>
                    </div>
                    <div class="field">
                        <label>Jam Tutup</label>
                        <input type="time" name="operating_hours_close"
                               value="<?= esc(old('operating_hours_close', substr($settings['operating_hours_close'], 0, 5))) ?>" required>
                    </div>
                </div>


                <div class="field">
                    <label>Kontak (No. HP / Email)</label>
                    <input type="text" name="contact_info" value="<?= esc(old('contact_info', $settings['contact_info'])) ?>">
                </div>

                <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan</button>
            </form>
        </div>

        <!-- Ubah Password -->
        <div class="panel">
            <h3>Ubah Password</h3>
            <div class="sub">Gunakan password baru yang kuat dan mudah kamu ingat</div>

            <form method="post" action="<?= base_url('owner/pengaturan/update-password') ?>">
                <div class="field">
                    <label>Password Lama</label>
                    <input type="password" name="password_lama" required>
                </div>
                <div class="field">
                    <label>Password Baru</label>
                    <input type="password" name="password_baru" required>
                    <div class="hint">Minimal 6 karakter</div>
                </div>
                <div class="field">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_konfirmasi" required>
                </div>

                <button type="submit" class="btn-submit brown"><i class="fa-solid fa-key"></i> Ubah Password</button>
            </form>
        </div>
    </div>
</main>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<script>
function toggleSidebar(){
    document.querySelector('.sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
</script>

</body>
</html>