<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Persetujuan Menu - FO'orders</title>

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

.sidebar{
    width:260px; background:var(--brown); color:#fff;
    display:flex; flex-direction:column; padding:24px 18px; flex-shrink:0;
    position:sticky; top:0; height:100vh; overflow-y:auto;
}
.sidebar .logo{
    display:flex; align-items:center; gap:10px;
    font-size:20px; font-weight:700; margin-bottom:32px; padding-left:6px;
}
.sidebar .logo i{ color:var(--green); font-size:22px; }
.nav-item{
    display:flex; align-items:center; gap:12px; padding:11px 14px;
    border-radius:8px; color:#e8ded6; text-decoration:none; font-size:14px;
    margin-bottom:4px; transition:.15s;
}
.nav-item i{ width:18px; text-align:center; }
.nav-item:hover{ background:rgba(255,255,255,.08); }
.nav-item.active{ background:var(--green); color:#fff; font-weight:600; }
.nav-bottom{ margin-top:auto; }

.main{ flex:1; padding:28px 32px; min-width:0; overflow-x:hidden; }

.topbar-mobile{ display:none; align-items:center; margin-bottom:14px; }
.hamburger{
    display:none; background:#fff; border:1px solid var(--border);
    width:38px; height:38px; border-radius:8px; align-items:center;
    justify-content:center; font-size:16px; color:var(--brown); cursor:pointer;
}
.sidebar-overlay{
    display:none; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:40;
}
.sidebar-overlay.show{ display:block; }

h1{ font-size:20px; color:#333; margin-bottom:4px; }
.subtitle{ font-size:13px; color:var(--text-muted); margin-bottom:20px; }

.flash-msg{
    background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:18px;
}

.table-wrap{
    background:#fff; border-radius:14px; padding:8px 20px;
    box-shadow:0 4px 14px rgba(0,0,0,.03);
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}
table{ width:100%; min-width:720px; border-collapse:collapse; font-size:13px; }
th{
    text-align:left; padding:14px 10px; color:var(--text-muted);
    font-weight:600; font-size:11px; text-transform:uppercase;
    border-bottom:1px solid var(--border); white-space:nowrap;
}
td{ padding:14px 10px; border-bottom:1px solid var(--border); color:#333; }
tr:last-child td{ border-bottom:none; }

.menu-photo{ width:56px; height:56px; object-fit:cover; border-radius:8px; }

.badge{
    padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;
    background:#FFF3CD; color:#856404;
}

.btn-toggle{
    border:none; padding:7px 14px; border-radius:8px; font-size:12px;
    font-weight:600; cursor:pointer; margin-right:6px;
}
.btn-toggle.to-aktif{ background:#E8F5E9; color:#2E7D32; }
.btn-toggle.to-nonaktif{ background:#FFEBEE; color:#C62828; }

.empty-note{ text-align:center; color:#aaa; font-size:13px; padding:30px 0; }

.scroll-hint{
    display:none; font-size:11px; color:var(--text-muted); margin-bottom:10px;
    align-items:center; gap:6px;
}

@media (max-width: 1100px){
    .sidebar{ width:220px; }
}

@media (max-width: 900px){
    .sidebar{
        position:fixed; left:0; top:0; width:240px; height:100vh; z-index:50;
        transform:translateX(-100%); transition:transform .25s ease;
    }
    .sidebar.open{ transform:translateX(0); }
    .main{ padding:20px 18px; width:100%; }
    .topbar-mobile{ display:flex; }
    .hamburger{ display:flex; }
    .scroll-hint{ display:flex; }
}

@media (max-width: 600px){
    main.main{ padding:16px 14px; }
    h1{ font-size:18px; }
    .table-wrap{ padding:8px 12px; }
}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="logo"><i class="fa-solid fa-mug-saucer"></i> FO'orders</div>

    <?php $current = uri_string(); ?>

    <a href="<?= base_url('owner') ?>"
       class="nav-item <?= $current === 'owner' ? 'active' : '' ?>">
       <i class="fa-solid fa-gauge"></i> Dashboard
    </a>

    <a href="<?= base_url('owner/menu-approval') ?>"
       class="nav-item <?= str_starts_with($current, 'owner/menu-approval') ? 'active' : '' ?>">
       <i class="fa-solid fa-bowl-food"></i> Persetujuan Menu
    </a>

    <a href="<?= base_url('owner/karyawan') ?>"
       class="nav-item <?= str_starts_with($current, 'owner/karyawan') ? 'active' : '' ?>">
       <i class="fa-solid fa-users"></i> Tenaga Kerja
    </a>

    <a href="<?= base_url('owner/meja') ?>"
       class="nav-item <?= str_starts_with($current, 'owner/meja') ? 'active' : '' ?>">
       <i class="fa-solid fa-chair"></i> Meja
    </a>

    <a href="<?= base_url('owner/rating') ?>"
       class="nav-item <?= str_starts_with($current, 'owner/rating') ? 'active' : '' ?>">
       <i class="fa-solid fa-star"></i> Rating & Ulasan
    </a>

    <a href="<?= base_url('owner/laporan') ?>"
       class="nav-item <?= str_starts_with($current, 'owner/laporan') ? 'active' : '' ?>">
       <i class="fa-solid fa-chart-line"></i> Laporan Keuangan
    </a>

    <a href="<?= base_url('owner/pengaturan') ?>"
       class="nav-item <?= str_starts_with($current, 'owner/pengaturan') ? 'active' : '' ?>">
       <i class="fa-solid fa-gear"></i> Pengaturan
    </a>

    <div class="nav-bottom">
        <a href="<?= base_url('logout') ?>" class="nav-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<main class="main">
    <div class="topbar-mobile">
        <button type="button" class="hamburger" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
    </div>

    <h1>Persetujuan Menu</h1>
    <div class="subtitle">Tinjau dan setujui menu baru yang diajukan admin</div>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="flash-msg"><?= esc(session()->getFlashdata('msg')) ?></div>
    <?php endif; ?>

    <div class="scroll-hint"><i class="fa-solid fa-arrows-left-right"></i> Geser tabel ke samping untuk melihat semua kolom</div>

    <div class="table-wrap">
        <?php if (empty($pendingMenus)) : ?>
            <div class="empty-note">Tidak ada permintaan menu baru.</div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Diajukan Oleh</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendingMenus as $menu) : ?>
                        <tr>
                            <td>
                                <?php if (!empty($menu['image_path'])) : ?>
                                    <img src="<?= base_url('uploads/menus/'.$menu['image_path']) ?>" class="menu-photo">
                                <?php else : ?>
                                    <img src="<?= base_url('uploads/menus/default_menus.jpg') ?>" class="menu-photo">
                                <?php endif; ?>
                            </td>
                            <td><?= esc($menu['menu_name']) ?></td>
                            <td>
                                <?php
                                    switch ($menu['category_id']) {
                                        case 1: echo 'Snack'; break;
                                        case 2: echo 'Teh & Susu'; break;
                                        case 3: echo 'Ayam & Seafood'; break;
                                        case 4: echo 'Aneka Mie'; break;
                                        case 5: echo 'Dessert / Es Krim'; break;
                                        case 6: echo 'Aneka Nasi'; break;
                                        case 7: echo 'Western Food'; break;
                                        case 8: echo 'Paket Menu'; break;
                                        case 9: echo 'Sup & Berkuah'; break;
                                        case 10: echo 'Minuman Segar'; break;
                                        case 11: echo 'Signature Drink'; break;
                                        case 12: echo 'Frappe Series'; break;
                                        case 13: echo 'Minuman Tradisional'; break;
                                        default: echo 'Lainnya'; break;
                                    }
                                ?>
                            </td>
                            <td>Admin #<?= esc($menu['requested_by']) ?></td>
                            <td><span class="badge">⏳ Pending</span></td>
                            <td>
                                <form action="<?= base_url('owner/menu-approval/approve/'.$menu['id']) ?>" method="post" style="display:inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-toggle to-aktif"
                                            onclick="return confirm('Setujui menu <?= esc($menu['menu_name']) ?>?')">
                                        Approve
                                    </button>
                                </form>
                                <form action="<?= base_url('owner/menu-approval/reject/'.$menu['id']) ?>" method="post" style="display:inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-toggle to-nonaktif"
                                            onclick="return confirm('Tolak menu <?= esc($menu['menu_name']) ?>?')">
                                        Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
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