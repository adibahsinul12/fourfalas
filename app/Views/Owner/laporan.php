<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Keuangan - FO'orders</title>

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

/* ===== Filter tanggal ===== */
.filter-form{
    background:#fff; border-radius:14px; padding:18px 20px;
    box-shadow:0 4px 14px rgba(0,0,0,.03); margin-bottom:24px;
    display:flex; align-items:end; gap:14px; flex-wrap:wrap;
}
.filter-form .field{ display:flex; flex-direction:column; gap:6px; }
.filter-form label{ font-size:12px; color:var(--text-muted); }
.filter-form input[type="date"]{
    padding:8px 12px; border:1px solid var(--border); border-radius:8px; font-size:13px; font-family:inherit;
}
.filter-form button{
    background:var(--green); color:#fff; border:none; padding:9px 20px;
    border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;
}
.filter-form button:hover{ opacity:.9; }
.filter-form .info-batal{
    font-size:12px; color:#E58A00; margin-left:auto;
}

/* ===== Cards ===== */
.cards{ display:grid; grid-template-columns:repeat(4, 1fr); gap:18px; margin-bottom:24px; }
.card{
    background:#fff; border-radius:14px; padding:18px; box-shadow:0 4px 14px rgba(0,0,0,.03);
    display:flex; gap:14px;
}
.card .icon{
    width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center;
    font-size:18px; color:#fff; flex-shrink:0;
}
.card .label{ font-size:12px; color:var(--text-muted); margin-bottom:4px; }
.card .value{ font-size:19px; font-weight:700; color:#333; }
.card .note{ font-size:11px; color:var(--green); margin-top:4px; font-weight:500; }
.card .note.warn{ color:#E14848; }

.bg-green{ background:var(--green); }
.bg-brown{ background:var(--brown); }
.bg-amber{ background:#E58A00; }
.bg-red{ background:#E14848; }

/* ===== Panels ===== */
.panels{ display:grid; grid-template-columns:1.3fr 1fr; gap:20px; }
.panel{
    background:#fff; border-radius:14px; padding:20px; box-shadow:0 4px 14px rgba(0,0,0,.03); margin-bottom:20px;
}
.panel h3{ font-size:15px; color:#333; margin-bottom:16px; }

/* Grafik bar harian (CSS only) */
.bar-chart{
    display:flex; align-items:flex-end; gap:8px; height:200px; padding-top:10px;
    border-bottom:1px solid var(--border);
}
.bar-chart .bar-col{
    flex:1; display:flex; flex-direction:column; align-items:center; justify-content:flex-end; height:100%;
}
.bar-chart .bar{
    width:100%; max-width:34px; background:var(--green); border-radius:4px 4px 0 0;
    transition:.2s;
}
.bar-chart .bar-col:hover .bar{ background:var(--brown); }
.bar-chart .bar-label{ font-size:10px; color:var(--text-muted); margin-top:6px; text-align:center; }
.empty-note{ font-size:12px; color:#aaa; text-align:center; padding:30px 0; }

/* Metode pembayaran */
.metode-row{
    display:flex; justify-content:space-between; align-items:center;
    padding:12px 0; border-bottom:1px solid var(--border); font-size:13px;
}
.metode-row:last-child{ border-bottom:none; }
.metode-row .nama{ font-weight:600; color:#333; }
.metode-row .jumlah{ color:var(--text-muted); font-size:11px; }
.metode-row .total{ color:var(--green); font-weight:600; }

/* Menu terlaris */
.menu-row{
    display:flex; justify-content:space-between; align-items:center;
    padding:10px 0; border-bottom:1px solid var(--border); font-size:13px;
}
.menu-row:last-child{ border-bottom:none; }
.menu-row .nama{ color:#333; font-weight:500; }
.menu-row .qty{ color:var(--text-muted); font-size:11px; }
.menu-row .omzet{ color:var(--brown); font-weight:600; font-size:12px; }

/* Tabel transaksi */
.table-wrap{ overflow-x:auto; }
table.transaksi{ width:100%; border-collapse:collapse; font-size:13px; }
table.transaksi th{
    text-align:left; padding:10px 12px; color:var(--text-muted); font-weight:600;
    border-bottom:2px solid var(--border); font-size:11px; text-transform:uppercase; white-space:nowrap;
}
table.transaksi td{ padding:10px 12px; border-bottom:1px solid var(--border); white-space:nowrap; }
table.transaksi tr:last-child td{ border-bottom:none; }

.status-badge{
    display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;
}
.status-Selesai{ background:#E8F5E9; color:#2E7D32; }
.status-Menunggu{ background:#FFF3E0; color:#E58A00; }
.status-Diproses{ background:#E3F2FD; color:#1565C0; }
.status-SiapDiantar{ background:#EDE7F6; color:#5E35B1; }
.status-Dibatalkan{ background:#FFEBEE; color:#C62828; }

/* ===== Hamburger ===== */
.hamburger{
    display:none; background:#fff; border:1px solid var(--border); width:38px; height:38px;
    border-radius:8px; align-items:center; justify-content:center; font-size:16px; color:var(--brown);
    cursor:pointer; margin-right:auto;
}
.sidebar-overlay{ display:none; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:40; }
.sidebar-overlay.show{ display:block; }

@media (max-width: 1100px){
    .cards{ grid-template-columns:repeat(2,1fr); }
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
    .cards{ grid-template-columns:1fr; }
    .card{ padding:16px; }
    .panel{ padding:16px; }
    .filter-form{ flex-direction:column; align-items:stretch; }
    .filter-form .info-batal{ margin-left:0; }
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

    <h2 style="margin-bottom:20px; color:#333;">Laporan Keuangan</h2>

    <!-- Filter tanggal -->
    <form class="filter-form" method="get" action="<?= base_url('owner/laporan') ?>">
        <div class="field">
            <label>Dari Tanggal</label>
            <input type="date" name="start" value="<?= esc($tanggal_mulai) ?>">
        </div>
        <div class="field">
            <label>Sampai Tanggal</label>
            <input type="date" name="end" value="<?= esc($tanggal_selesai) ?>">
        </div>
        <button type="submit"><i class="fa-solid fa-filter"></i> Terapkan</button>
        <span class="info-batal">*Hanya pesanan berstatus "Selesai" yang dihitung sebagai pendapatan</span>
    </form>

    <!-- Ringkasan -->
    <div class="cards">
        <div class="card">
            <div class="icon bg-green"><i class="fa-solid fa-sack-dollar"></i></div>
            <div>
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                <div class="note">Order berstatus Selesai</div>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-brown"><i class="fa-solid fa-receipt"></i></div>
            <div>
                <div class="label">Total Transaksi</div>
                <div class="value"><?= number_format($total_transaksi) ?></div>
                <div class="note">Dalam rentang tanggal ini</div>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-amber"><i class="fa-solid fa-calculator"></i></div>
            <div>
                <div class="label">Rata-rata / Transaksi</div>
                <div class="value">Rp <?= number_format($rata_rata_transaksi, 0, ',', '.') ?></div>
                <div class="note">Rata-rata nilai order</div>
            </div>
        </div>
        <div class="card">
            <div class="icon bg-red"><i class="fa-solid fa-ban"></i></div>
            <div>
                <div class="label">Order Dibatalkan</div>
                <div class="value"><?= number_format($total_dibatalkan) ?></div>
                <div class="note warn">Tidak dihitung ke pendapatan</div>
            </div>
        </div>
    </div>

    <div class="panels">
        <div>
            <!-- Grafik pendapatan harian -->
            <div class="panel">
                <h3>Pendapatan Harian</h3>
                <?php if (empty($pendapatan_harian)) : ?>
                    <div class="empty-note">Belum ada transaksi Selesai pada rentang tanggal ini.</div>
                <?php else : ?>
                    <?php $max = max($pendapatan_harian) ?: 1; ?>
                    <div class="bar-chart">
                        <?php foreach ($pendapatan_harian as $tanggal => $total) : ?>
                            <?php $tinggi = max(4, round(($total / $max) * 100)); ?>
                            <div class="bar-col" title="Rp <?= number_format($total, 0, ',', '.') ?>">
                                <div class="bar" style="height: <?= $tinggi ?>%;"></div>
                                <div class="bar-label"><?= esc(date('d/m', strtotime($tanggal))) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tabel daftar transaksi -->
            <div class="panel">
                <h3>Daftar Transaksi</h3>
                <?php if (empty($daftar_transaksi)) : ?>
                    <div class="empty-note">Belum ada transaksi pada rentang tanggal ini.</div>
                <?php else : ?>
                    <div class="table-wrap">
                        <table class="transaksi">
                            <thead>
                                <tr>
                                    <th>No. Order</th>
                                    <th>Pelanggan</th>
                                    <th>Status</th>
                                    <th>Metode</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($daftar_transaksi as $t) : ?>
                                    <tr>
                                        <td><?= esc($t['order_number']) ?></td>
                                        <td><?= esc($t['customer_name']) ?></td>
                                        <td>
                                            <span class="status-badge status-<?= str_replace(' ', '', $t['order_status']) ?>">
                                                <?= esc($t['order_status']) ?>
                                            </span>
                                        </td>
                                        <td><?= esc($t['payment_method'] ?? '-') ?></td>
                                        <td>Rp <?= number_format($t['total_payment'] ?? 0, 0, ',', '.') ?></td>
                                        <td><?= esc(date('d M Y H:i', strtotime($t['created_at']))) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <!-- Pendapatan per metode -->
            <div class="panel">
                <h3>Pendapatan per Metode Pembayaran</h3>
                <?php if (empty($per_metode)) : ?>
                    <div class="empty-note">Belum ada data.</div>
                <?php else : ?>
                    <?php foreach ($per_metode as $metode => $info) : ?>
                        <div class="metode-row">
                            <div>
                                <div class="nama"><?= esc($metode) ?></div>
                                <div class="jumlah"><?= $info['jumlah'] ?> transaksi</div>
                            </div>
                            <div class="total">Rp <?= number_format($info['total'], 0, ',', '.') ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Menu terlaris -->
            <div class="panel">
                <h3>Menu Terlaris</h3>
                <?php if (empty($menu_terlaris)) : ?>
                    <div class="empty-note">Belum ada data penjualan menu.</div>
                <?php else : ?>
                    <?php foreach ($menu_terlaris as $m) : ?>
                        <div class="menu-row">
                            <div>
                                <div class="nama"><?= esc($m['menu_name']) ?></div>
                                <div class="qty"><?= $m['total_terjual'] ?> terjual</div>
                            </div>
                            <div class="omzet">Rp <?= number_format($m['total_omzet'], 0, ',', '.') ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
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