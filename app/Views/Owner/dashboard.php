<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Owner - FO'orders</title>

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
.main{ flex:1; padding:28px 32px; }
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

/* ===== Cards ===== */
.cards{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:18px;
    margin-bottom:24px;
}
.card{
    background:#fff;
    border-radius:14px;
    padding:18px;
    box-shadow:0 4px 14px rgba(0,0,0,.03);
    display:flex;
    gap:14px;
}
.card .icon{
    width:44px; height:44px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-size:18px; color:#fff; flex-shrink:0;
}
.card .label{ font-size:12px; color:var(--text-muted); margin-bottom:4px; }
.card .value{ font-size:20px; font-weight:700; color:#333; }
.card .note{ font-size:11px; color:var(--green); margin-top:4px; font-weight:500; }
.card .note.dummy{ color:#E58A00; }

.bg-green{ background:var(--green); }
.bg-brown{ background:var(--brown); }
.bg-amber{ background:#E58A00; }
.bg-blue{ background:#3B82F6; }

/* ===== Panels ===== */
.panels{
    display:grid;
    grid-template-columns:1.3fr 1fr;
    gap:20px;
}
.panel{
    background:#fff;
    border-radius:14px;
    padding:20px;
    box-shadow:0 4px 14px rgba(0,0,0,.03);
    margin-bottom:20px;
}
.panel h3{ font-size:15px; color:#333; margin-bottom:16px; }

.chart-placeholder{
    height:220px;
    border:1px dashed var(--border);
    border-radius:10px;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    color:var(--text-muted); gap:8px; font-size:13px;
}
.chart-placeholder i{ font-size:26px; color:var(--green); }
.chart-placeholder span.small{ font-size:11px; color:#bbb; }

/* Bidang grid */
.bidang-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}
.bidang-card{
    border:1px solid var(--border);
    border-radius:10px;
    padding:14px;
    text-decoration:none;
    color:inherit;
    display:block;
    transition:.15s;
}
.bidang-card:hover{ border-color:var(--green); background:#FAFFFA; }
.bidang-card .top{ display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
.bidang-card .name{ font-size:13px; font-weight:600; color:#333; }
.bidang-card i{ color:var(--brown); }
.bidang-card .count{ font-size:22px; font-weight:700; color:var(--green); }
.bidang-card .count small{ font-size:11px; font-weight:400; color:var(--text-muted); }

/* Rating list */
.rating-item{
    padding:12px 0;
    border-bottom:1px solid var(--border);
}
.rating-item:last-child{ border-bottom:none; }
.rating-item .head{ display:flex; justify-content:space-between; margin-bottom:4px; }
.rating-item .name{ font-size:13px; font-weight:600; color:#333; }
.rating-item .stars{ color:#F5A623; font-size:12px; }
.rating-item .comment{ font-size:12px; color:#666; margin-bottom:2px; }
.rating-item .date{ font-size:10px; color:#aaa; }
.empty-note{ font-size:12px; color:#aaa; text-align:center; padding:20px 0; }

@media (max-width: 1100px){
    .cards{ grid-template-columns:repeat(2,1fr); }
    .panels{ grid-template-columns:1fr; }
}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="logo"><i class="fa-solid fa-mug-saucer"></i> FO'orders</div>

    <a href="<?= base_url('owner') ?>" class="nav-item active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="<?= base_url('owner/karyawan') ?>" class="nav-item"><i class="fa-solid fa-users"></i> Tenaga Kerja</a>
    <a href="#" class="nav-item"><i class="fa-solid fa-star"></i> Rating &amp; Ulasan</a>
    <a href="#" class="nav-item"><i class="fa-solid fa-chart-line"></i> Laporan Keuangan</a>
    <a href="#" class="nav-item"><i class="fa-solid fa-gear"></i> Pengaturan</a>

    <div class="nav-bottom">
        <a href="<?= base_url('logout') ?>" class="nav-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
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

    <!-- Ringkasan -->
    <div class="cards">
        <div class="card">
            <div class="icon bg-green"><i class="fa-solid fa-sack-dollar"></i></div>
            <div>
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                <div class="note dummy">Data dummy (menunggu tabel transaksi)</div>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-brown"><i class="fa-solid fa-receipt"></i></div>
            <div>
                <div class="label">Total Pesanan</div>
                <div class="value"><?= number_format($total_pesanan) ?></div>
                <div class="note dummy">Data dummy</div>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-amber"><i class="fa-solid fa-star"></i></div>
            <div>
                <div class="label">Rata-rata Rating</div>
                <div class="value"><?= $rata_rating ?> / 5</div>
                <div class="note">Dari <?= $total_rating ?> ulasan</div>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-blue"><i class="fa-solid fa-user-group"></i></div>
            <div>
                <div class="label">Total Karyawan</div>
                <div class="value"><?= $total_karyawan ?></div>
                <div class="note">Data real-time</div>
            </div>
        </div>
    </div>

    <div class="panels">
        <div>
            <div class="panel">
                <h3>Grafik Penjualan</h3>
                <div class="chart-placeholder">
                    <i class="fa-solid fa-chart-area"></i>
                    Grafik Penjualan Real-time
                    <span class="small">Akan aktif otomatis setelah tabel transaksi tersedia</span>
                </div>
            </div>

            <div class="panel">
                <h3>Tenaga Kerja per Bidang</h3>
                <div class="bidang-grid">
                    <?php
                    $icons = [
                        'Waiters'      => 'fa-bell-concierge',
                        'Barista'      => 'fa-mug-hot',
                        'Asisten Koki' => 'fa-utensils',
                        'Koki'         => 'fa-kitchen-set',
                    ];
                    ?>
                    <?php foreach ($per_bidang as $bidang => $jumlah) : ?>
                        <a href="<?= base_url('owner/karyawan?bidang=' . urlencode($bidang)) ?>" class="bidang-card">
                            <div class="top">
                                <span class="name"><?= esc($bidang) ?></span>
                                <i class="fa-solid <?= $icons[$bidang] ?? 'fa-user' ?>"></i>
                            </div>
                            <div class="count"><?= $jumlah['total'] ?> <small>orang</small></div>
                            <div class="note" style="margin-top:4px;"><?= $jumlah['aktif'] ?> aktif</div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="panel">
            <h3>Rating &amp; Ulasan Terbaru</h3>
            <?php if (empty($rating_terbaru)) : ?>
                <div class="empty-note">Belum ada ulasan masuk.</div>
            <?php else : ?>
                <?php foreach ($rating_terbaru as $r) : ?>
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
    </div>
</main>

</body>
</html>