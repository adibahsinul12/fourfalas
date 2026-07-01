<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rating & Ulasan - FO'orders</title>

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
html{
    scrollbar-gutter: stable;
}
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
body{ background:var(--cream); display:flex; min-height:100vh; }

/* ===== Sidebar ===== */
.sidebar{
    width:260px;
    background:var(--brown);
    color:#fff;
    display:flex;
    flex-direction:column;
    padding:24px 18px;
    flex-shrink:0;
    position:sticky;
    top:0;
    height:100vh;
    overflow-y:auto;
}
.sidebar .logo{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:20px;
    font-weight:700;
    margin-bottom:32px;
    padding-left:6px;
}
.sidebar .logo i{ color:var(--green); font-size:22px; }
.nav-item{
    display:flex;
    align-items:center;
    gap:12px;
    padding:11px 14px;
    border-radius:8px;
    color:#e8ded6;
    text-decoration:none;
    font-size:14px;
    margin-bottom:4px;
    transition:.15s;
}
.nav-item i{ width:18px; text-align:center; }
.nav-item:hover{ background:rgba(255,255,255,.08); }
.nav-item.active{ background:var(--green); color:#fff; font-weight:600; }
.nav-bottom{ margin-top:auto; }

/* ===== Main content ===== */
.main{
    flex:1;
    padding:28px 32px;
    min-width:0;
    overflow-x:hidden;
}
.topbar{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:16px;
    margin-bottom:24px;
}
.owner-chip{
    display:flex;
    align-items:center;
    gap:10px;
    background:#fff;
    padding:8px 14px;
    border-radius:10px;
    font-size:13px;
}
.owner-chip i{
    background:var(--brown);
    color:#fff;
    padding:8px;
    border-radius:50%;
}
.owner-chip .role{ color:var(--text-muted); font-size:11px; }

.flash-msg{
    background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:20px;
}

/* ===== Ringkasan rating ===== */
.rating-wrapper{
    display:flex;
    gap:20px;
    margin-bottom:24px;
    flex-wrap:wrap;
}
.rating-summary-card{
    background:#fff;
    border-radius:14px;
    padding:24px;
    box-shadow:0 4px 14px rgba(0,0,0,.03);
    flex:1;
    min-width:220px;
    text-align:center;
}
.rating-summary-card .angka{
    font-size:48px;
    font-weight:700;
    color:#E58A00;
    line-height:1;
}
.rating-summary-card .bintang{
    color:#F5A623;
    font-size:20px;
    margin:8px 0;
}
.rating-summary-card .total{
    color:var(--text-muted);
    font-size:13px;
}

.distribusi-card{
    background:#fff;
    border-radius:14px;
    padding:24px;
    box-shadow:0 4px 14px rgba(0,0,0,.03);
    flex:2;
    min-width:280px;
}
.distribusi-card h3{ font-size:15px; color:#333; margin-bottom:16px; }
.distribusi-row{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:10px;
    font-size:13px;
}
.distribusi-row .label{ width:44px; color:#555; }
.distribusi-row .bar-bg{
    flex:1;
    background:var(--cream);
    border-radius:6px;
    height:10px;
    overflow:hidden;
}
.distribusi-row .bar-fill{
    background:#F5A623;
    height:100%;
    border-radius:6px;
}
.distribusi-row .jumlah{ width:28px; text-align:right; color:#555; }

/* ===== Panel daftar ulasan ===== */
.panel{
    background:#fff;
    border-radius:14px;
    padding:20px;
    box-shadow:0 4px 14px rgba(0,0,0,.03);
    margin-bottom:20px;
}
.panel h3{ font-size:15px; color:#333; margin-bottom:16px; }

.filter-bar{ margin-bottom:16px; }
.filter-bar a{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    background:var(--cream);
    color:#555;
    text-decoration:none;
    font-size:12px;
    margin-right:8px;
    margin-bottom:8px;
    border:1px solid var(--border);
}
.filter-bar a.active{
    background:var(--green);
    color:#fff;
    border-color:var(--green);
}

.rating-item{
    padding:14px 0;
    border-bottom:1px solid var(--border);
}
.rating-item:last-child{ border-bottom:none; }
.rating-item .head{ display:flex; justify-content:space-between; margin-bottom:4px; }
.rating-item .name{ font-size:13px; font-weight:600; color:#333; }
.rating-item .stars{ color:#F5A623; font-size:12px; }
.rating-item .comment{ font-size:12px; color:#666; margin-bottom:2px; }
.rating-item .date{ font-size:10px; color:#aaa; }
.empty-note{ font-size:12px; color:#aaa; text-align:center; padding:30px 0; }

/* ===== Hamburger ===== */
.hamburger{
    display:none;
    background:#fff;
    border:1px solid var(--border);
    width:38px; height:38px;
    border-radius:8px;
    align-items:center;
    justify-content:center;
    font-size:16px;
    color:var(--brown);
    cursor:pointer;
    margin-right:auto;
}
.sidebar-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    z-index:40;
}
.sidebar-overlay.show{ display:block; }

/* ===== TABLET (<=1100px) ===== */
@media (max-width: 1100px){
    .sidebar{ width:220px; }
}

/* ===== TABLET KECIL / HP LANDSCAPE (<=900px) ===== */
@media (max-width: 900px){
    .sidebar{
        position:fixed;
        left:0; top:0;
        width:240px;
        height:100vh;
        z-index:50;
        transform:translateX(-100%);
        transition:transform .25s ease;
    }
    .sidebar.open{ transform:translateX(0); }
    .main{ padding:20px 18px; width:100%; }
    .hamburger{ display:flex; }
    .topbar{ justify-content:space-between; }
    .rating-wrapper{ flex-direction:column; }
}

/* ===== HP (<=600px) ===== */
@media (max-width: 600px){
    .rating-summary-card, .distribusi-card, .panel{ padding:16px; }
    .owner-chip{ padding:6px 10px; font-size:12px; }
    .owner-chip .role{ font-size:10px; }
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

    <h2 style="margin-bottom:20px; color:#333;">Rating &amp; Ulasan</h2>

    <!-- Ringkasan -->
    <div class="rating-wrapper">
        <div class="rating-summary-card">
            <div class="angka"><?= esc($rata_rating) ?></div>
            <div class="bintang">
                <?php
                    $bulat = round($rata_rating);
                    echo str_repeat('★', (int) $bulat) . str_repeat('☆', 5 - (int) $bulat);
                ?>
            </div>
            <div class="total"><?= esc($total_rating) ?> ulasan</div>
        </div>

        <div class="distribusi-card">
            <h3>Distribusi Bintang</h3>
            <?php for ($bintang = 5; $bintang >= 1; $bintang--) : ?>
                <?php
                    $jumlah = $distribusi[$bintang] ?? 0;
                    $persen = $total_rating > 0 ? round(($jumlah / $total_rating) * 100) : 0;
                ?>
                <div class="distribusi-row">
                    <div class="label"><?= $bintang ?> ★</div>
                    <div class="bar-bg">
                        <div class="bar-fill" style="width: <?= $persen ?>%;"></div>
                    </div>
                    <div class="jumlah"><?= $jumlah ?></div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Daftar ulasan -->
    <div class="panel">
        <h3>Daftar Ulasan</h3>

        <div class="filter-bar">
            <a href="<?= base_url('owner/rating') ?>" class="<?= empty($filter_bintang) ? 'active' : '' ?>">Semua</a>
            <?php for ($b = 5; $b >= 1; $b--) : ?>
                <a href="<?= base_url('owner/rating?rating=' . $b) ?>" class="<?= (string) $filter_bintang === (string) $b ? 'active' : '' ?>">
                    <?= $b ?> ★
                </a>
            <?php endfor; ?>
        </div>

        <?php if (empty($daftar_ulasan)) : ?>
            <div class="empty-note">Belum ada ulasan untuk ditampilkan.</div>
        <?php else : ?>
            <?php foreach ($daftar_ulasan as $r) : ?>
                <div class="rating-item">
                    <div class="head">
                        <span class="name"><?= esc($r['nama_pelanggan'] ?? 'Pelanggan') ?></span>
                        <span class="stars">
                            <?= str_repeat('★', (int) $r['rating']) . str_repeat('☆', 5 - (int) $r['rating']) ?>
                        </span>
                    </div>
                    <?php if (! empty($r['komentar'])) : ?>
                        <div class="comment"><?= esc($r['komentar']) ?></div>
                    <?php endif; ?>
                    <div class="date"><?= esc(date('d M Y H:i', strtotime($r['tanggal']))) ?></div>
                </div>
            <?php endforeach; ?>
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