<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - FO'Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F7F3EE;
            color: #333333;
            margin: 0; padding: 0;
            overflow-x: hidden;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: #6B3A1E;
            position: fixed;
            top: 0; left: 0;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 1050;
            transition: left 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar-brand {
            color: #FFFFFF;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 12px;
            margin-bottom: 30px;
            white-space: nowrap;
        }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; flex-grow: 1; }
        .sidebar-item { margin-bottom: 8px; }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #FFFFFF;
            opacity: 0.7;
            padding: 12px 16px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .sidebar-link i { min-width: 18px; text-align: center; }
        .sidebar-link:hover { opacity: 1; background-color: rgba(255,255,255,0.08); color: #FFFFFF; }
        .sidebar-link.active { opacity: 1; background-color: #4CAF50; color: #FFFFFF; font-weight: 600; }
        .sidebar-logout {
            color: #FFFFFF; opacity: 0.7;
            padding: 12px 16px;
            text-decoration: none;
            font-size: 14px;
            display: flex; align-items: center; gap: 14px;
            border-radius: 10px;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .sidebar-logout:hover { opacity: 1; background-color: rgba(244,67,54,0.15); color: #FFCDD2; }
        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: #FFFFFF;
            font-size: 1.2rem;
            position: absolute;
            top: 20px;
            right: 16px;
            cursor: pointer;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-overlay.show { display: block; }
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 12px;
            flex-wrap: wrap;
        }
        .topbar-left { display: flex; align-items: center; gap: 10px; }
        .menu-toggle-btn {
            display: none;
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            width: 40px; height: 40px;
            border-radius: 50%;
            align-items: center; justify-content: center;
            color: #6B3A1E;
            font-size: 1rem;
            flex-shrink: 0;
            cursor: pointer;
        }
        .admin-profile { display: flex; align-items: center; gap: 16px; flex-shrink: 0; }
        .profile-card {
            background: #FFFFFF;
            padding: 6px 16px 6px 6px;
            border-radius: 30px;
            border: 1px solid #E5E5E5;
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; color: inherit;
        }
        .profile-avatar {
            width: 32px; height: 32px;
            background-color: #F7F3EE;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #6B3A1E;
        }
        .widget-card {
            background-color: #FFFFFF;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(229,229,229,0.5);
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
        .mini-box { border-left: 4px solid #4CAF50; padding-left: 15px; }
        .filter-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 22px 24px;
            border: 1px solid rgba(229,229,229,0.5);
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            margin-bottom: 24px;
        }
        .filter-card h6 { font-weight: 700; color: #888; margin-bottom: 16px; }
        .custom-table { width: 100%; border-collapse: collapse; }
        .custom-table th {
            font-size: 12px;
            text-transform: uppercase;
            color: #888888;
            font-weight: 600;
            padding: 13px 16px;
            border-bottom: 2px solid #F7F3EE;
            background: #FDFAF7;
            white-space: nowrap;
        }
        .custom-table td {
            font-size: 13px;
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #F7F3EE;
        }
        .custom-table tbody tr:last-child td { border-bottom: none; }
        .custom-table tbody tr:hover { background: #FDFAF7; }
        .lap-card-list { display: none; }
        .lap-card {
            padding: 16px 18px;
            border-bottom: 1px solid #F0EBE5;
        }
        .lap-card:last-child { border-bottom: none; }
        .lap-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .lap-card-nota { font-weight: 700; font-size: 14px; color: #4CAF50; }
        .lap-card-time { font-size: 11px; color: #888; margin-top: 2px; }
        .lap-card-amount { font-size: 15px; font-weight: 700; }
        .lap-card-body { display: flex; flex-direction: column; gap: 6px; }
        .lap-card-row { display: flex; justify-content: space-between; font-size: 13px; }
        .lap-card-label { color: #888888; font-size: 12px; }
        .empty-state { text-align: center; padding: 40px 20px; color: #888; font-size: 13px; }
        @media print {
            .sidebar, .menu-toggle-btn, .sidebar-overlay,
            .filter-card, .topbar .admin-profile { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; }
            .lap-card-list { display: none !important; }
            .table-responsive { display: block !important; }
        }
        @media (max-width: 991.98px) {
            .sidebar {
                left: -280px;
                box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            }
            .sidebar.show { left: 0; }
            .sidebar-close-btn { display: block; }
            .main-content { margin-left: 0; padding: 20px; }
            .menu-toggle-btn { display: flex; }
        }
        @media (max-width: 767.98px) {
            .main-content { padding: 16px; }
            .topbar { margin-bottom: 20px; }
            .admin-profile { gap: 10px; }
            .profile-card .small { display: none; }
            .profile-card { padding: 4px; border-radius: 50%; }
            .table-responsive { display: none; }
            .lap-card-list { display: block; }
            .row.g-3 .col-sm-6 { width: 100%; }
            .filter-card .row .col-md-4 { width: 100%; }
            h4 { font-size: 1rem !important; }
            .d-flex.justify-content-between { flex-wrap: wrap; gap: 10px; }
        }
        @media (max-width: 479.98px) {
            .main-content { padding: 12px; }
        }
        .btn-tampilkan-laporan {
            background-color: #4CAF50 !important;
            border-color: #4CAF50 !important;
            color: #FFFFFF !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500;
            padding: 8px 24px;
            transition: background-color 0.2s;
        }
        .btn-tampilkan-laporan:hover {
            background-color: #3e9c43 !important;
            border-color: #3e9c43 !important;
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebar">
    <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup menu">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div>
        <a href="<?= base_url('admin') ?>" class="sidebar-brand">
            <i class="fa-solid fa-mug-hot text-success"></i> <span>FO'Orders</span>
        </a>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="<?= base_url('admin') ?>" class="sidebar-link" title="Dashboard">
                    <i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('admin/pesanan') ?>" class="sidebar-link" title="Pesanan">
                    <i class="fa-solid fa-utensils"></i> <span>Pesanan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('admin/menu') ?>" class="sidebar-link" title="Menu">
                    <i class="fa-solid fa-bowl-food"></i> <span>Menu</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('admin/meja') ?>" class="sidebar-link" title="Meja">
                    <i class="fa-solid fa-chair"></i> <span>Meja</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('admin/pelanggan') ?>" class="sidebar-link" title="Member">
                    <i class="fa-solid fa-users"></i> <span>Member</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('admin/transaksi') ?>" class="sidebar-link" title="Transaksi">
                    <i class="fa-solid fa-file-invoice-dollar"></i> <span>Transaksi</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('admin/laporan') ?>" class="sidebar-link active" title="Laporan">
                    <i class="fa-solid fa-chart-line"></i> <span>Laporan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('admin/pengaturan') ?>" class="sidebar-link" title="Pengaturan">
                    <i class="fa-solid fa-gear"></i> <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>
    <a href="<?= base_url('logout') ?>" class="sidebar-logout" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
    </a>
</div>

<div class="main-content">

    <div class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle-btn" id="menuToggleBtn" aria-label="Buka menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h4 class="fw-bold m-0">📈 Laporan Keuangan & Penjualan</h4>
        </div>
        <div class="admin-profile d-flex align-items-center">
        <div class="notif-btn bg-white border d-flex align-items-center justify-content-center rounded-circle me-1" style="width: 40px; height: 40px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <i class="fa-solid fa-bell" style="color: #6B3A1E;"></i>
        </div>
            <a href="<?= base_url('admin/pengaturan') ?>" class="profile-card">
                <div class="profile-avatar"><i class="fa-solid fa-user-tie"></i></div>
                <div class="small">
                    <div class="fw-bold" style="font-size:12px;">Admin</div>
                    <span class="text-muted" style="font-size:10px;">Administrator</span>
                </div>
            </a>
        </div>
    </div>

    <div class="filter-card">
        <h6><i class="fa-solid fa-filter text-success me-2"></i>Filter Rentang Waktu Omzet</h6>
        <form action="<?= base_url('admin/laporan') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4 col-12">
                <label class="form-label small">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>">
            </div>
            <div class="col-md-4 col-12">
                <label class="form-label small">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai; ?>">
            </div>
            <div class="col-md-4 col-12">
                <button type="submit" class="btn btn-tampilkan-laporan" style="border-radius: 8px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Tampilkan Laporan
                </button>
            </div>
        </form>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="widget-card mini-box h-100" style="border-left-color:#4CAF50;">
                <small class="text-muted fw-semibold d-block">TOTAL OMZET BRUTO</small>
                <h4 class="fw-bold text-dark m-0 mt-1">Rp <?= number_format($total_omzet, 0, ',', '.'); ?></h4>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="widget-card mini-box h-100" style="border-left-color:#6B3A1E;">
                <small class="text-muted fw-semibold d-block">TOTAL TRANSAKSI SUKSES</small>
                <h4 class="fw-bold text-dark m-0 mt-1"><?= $total_transaksi; ?> Nota Lunas</h4>
            </div>
        </div>
    </div>

    <div class="widget-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-muted m-0">
                <i class="fa-solid fa-list-check text-success me-2"></i>Rincian Penjualan Terarsip
            </h6>
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                <i class="fa-solid fa-print me-1"></i> Cetak Dokumen
            </button>
        </div>

        <!-- Desktop Table -->
        <div class="table-responsive">
            <table class="table custom-table m-0">
                <thead>
                    <tr>
                        <th>Waktu Transaksi</th>
                        <th>No. Nota</th>
                        <th>Pelanggan</th>
                        <th class="text-end">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($laporan_penjualan)): ?>
                        <?php foreach($laporan_penjualan as $row): ?>
                            <?php
                                // Fallback aman: kalau kolom total_amount tidak ada,
                                // anggap pajak = 0 (total_payment dipakai sebagai dasar, bukan dikurangi).
                                $totalPayment = $row['total_payment'] ?? 0;
                                $totalAmount  = $row['total_amount'] ?? $totalPayment;
                                $pajak        = $totalPayment - $totalAmount;
                            ?>
                            <tr>
                                <td><?= date('d M Y, H:i', strtotime($row['created_at'])); ?> WIB</td>
                                <td class="fw-bold text-success">#<?= $row['order_number'] ?? $row['id']; ?></td>
                                <td><?= $row['customer_name'] ?? 'Pelanggan'; ?></td>
                                <td class="text-end fw-bold">Rp <?= number_format($totalPayment, 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Tidak ada data omzet penjualan pada rentang tanggal ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="lap-card-list">
            <?php if(!empty($laporan_penjualan)): ?>
                <?php foreach($laporan_penjualan as $row): ?>
                    <?php
                        $totalPayment = $row['total_payment'] ?? 0;
                        $totalAmount  = $row['total_amount'] ?? $totalPayment;
                        $pajak        = $totalPayment - $totalAmount;
                    ?>
                    <div class="lap-card">
                        <div class="lap-card-header">
                            <div>
                                <div class="lap-card-nota">#<?= $row['order_number'] ?? $row['id']; ?></div>
                                <div class="lap-card-time">
                                    <i class="fa-regular fa-clock fa-xs me-1"></i>
                                    <?= date('d M Y, H:i', strtotime($row['created_at'])); ?> WIB
                                </div>
                            </div>
                            <div class="lap-card-amount">Rp <?= number_format($totalPayment, 0, ',', '.'); ?></div>
                        </div>
                        <div class="lap-card-body">
                            <div class="lap-card-row">
                                <span class="lap-card-label"><i class="fa-solid fa-user fa-xs me-1"></i>Pelanggan</span>
                                <span><?= $row['customer_name'] ?? 'Pelanggan'; ?></span>
                            </div>
                            <div class="lap-card-row">
                                <span class="lap-card-label"><i class="fa-solid fa-receipt fa-xs me-1"></i>Pajak Resto</span>
                                <span class="text-muted">Rp <?= number_format($pajak, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    Tidak ada data omzet penjualan pada rentang tanggal ini.
                </div>
            <?php endif; ?>
        </div>

    </div><!-- /widget-card -->
</div><!-- /main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar         = document.getElementById('sidebar');
    const overlay         = document.getElementById('sidebarOverlay');
    const menuToggleBtn   = document.getElementById('menuToggleBtn');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

    function openSidebar() {
        sidebar.classList.add('show');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    menuToggleBtn.addEventListener('click', openSidebar);
    sidebarCloseBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) closeSidebar();
    });
</script>
</body>
</html>