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
        body { font-family: 'Poppins', sans-serif; background-color: #F7F3EE; color: #333333; margin: 0; padding: 0; overflow-x: hidden; }
        .sidebar { width: 260px; height: 100vh; background-color: #6B3A1E; position: fixed; top: 0; left: 0; padding: 24px 16px; display: flex; flex-direction: column; justify-content: space-between; z-index: 100; }
        .sidebar-brand { color: #FFFFFF; font-size: 1.5rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; padding-left: 12px; margin-bottom: 30px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; flex-grow: 1; }
        .sidebar-item { margin-bottom: 8px; }
        .sidebar-link { display: flex; align-items: center; gap: 14px; color: #FFFFFF; opacity: 0.7; padding: 12px 16px; text-decoration: none; font-size: 14px; font-weight: 500; border-radius: 10px; transition: all 0.2s ease; }
        .sidebar-link:hover { opacity: 1; background-color: rgba(255, 255, 255, 0.05); color: #FFFFFF; }
        .sidebar-link.active { opacity: 1; background-color: #4CAF50; color: #FFFFFF; font-weight: 600; }
        .sidebar-logout { color: #FFFFFF; opacity: 0.7; padding: 12px 16px; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 14px; }
        .sidebar-logout:hover { opacity: 1; background-color: rgba(244, 67, 54, 0.15); color: #FFCDD2; }
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .widget-card { background-color: #FFFFFF; border-radius: 16px; padding: 24px; border: 1px solid rgba(229, 229, 229, 0.5); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01); }
        
        .mini-box { border-left: 4px solid #4CAF50; padding-left: 15px; }
        .custom-table th { font-size: 12px; text-transform: uppercase; color: #888888; font-weight: 600; padding: 12px 16px; border-bottom: 2px solid #F7F3EE; }
        .custom-table td { font-size: 13px; padding: 14px 16px; vertical-align: middle; border-bottom: 1px solid #F7F3EE; }
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <a href="<?= base_url('admin') ?>" class="sidebar-brand">
            <i class="fa-solid fa-mug-hot text-success"></i> <span>FO'Orders</span>
        </a>
        <ul class="sidebar-menu">
            <li class="sidebar-item"><a href="<?= base_url('admin') ?>" class="sidebar-link"><i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pesanan') ?>" class="sidebar-link"><i class="fa-solid fa-utensils"></i> <span>Pesanan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/menu') ?>" class="sidebar-link"><i class="fa-solid fa-bowl-food"></i> <span>Menu</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/meja') ?>" class="sidebar-link"><i class="fa-solid fa-chair"></i> <span>Meja</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pelanggan') ?>" class="sidebar-link"><i class="fa-solid fa-users"></i> <span>Pelanggan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/transaksi') ?>" class="sidebar-link"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Transaksi</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/laporan') ?>" class="sidebar-link active"><i class="fa-solid fa-chart-line"></i> <span>Laporan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pengaturan') ?>" class="sidebar-link"><i class="fa-solid fa-gear"></i> <span>Pengaturan</span></a></li>
        </ul>
    </div>
    <a href="<?= base_url('logout') ?>" class="sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a>
</div>

<div class="main-content">
    <div class="topbar">
        <div><h4 class="fw-bold m-0">📈 Laporan Keuangan & Penjualan</h4></div>
        <div class="admin-profile">
            <div class="profile-card">
                <div class="profile-avatar"><i class="fa-solid fa-user-tie"></i></div>
                <div class="small"><div class="fw-bold" style="font-size: 12px;">Admin</div><span class="text-muted" style="font-size: 10px;">Administrator</span></div>
            </div>
        </div>
    </div>

    <div class="widget-card mb-4">
        <h6 class="fw-bold text-muted mb-3"><i class="fa-solid fa-filter text-success me-2"></i>Filter Rentang Waktu Omzet</h6>
        <form action="<?= base_url('admin/laporan') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai; ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100 p-2 fw-semibold" style="border-radius: 8px;"><i class="fa-solid fa-magnifying-glass me-2"></i>Tampilkan Laporan</button>
            </div>
        </form>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="widget-card mini-box" style="border-left-color: #4CAF50;">
                <small class="text-muted fw-semibold d-block">TOTAL OMZET BRUTO</small>
                <h4 class="fw-bold text-dark m-0 mt-1">Rp <?= number_format($total_omzet, 0, ',', '.'); ?></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-card mini-box" style="border-left-color: #FF9800;">
                <small class="text-muted fw-semibold d-block">TOTAL SETORAN PAJAK PPN</small>
                <h4 class="fw-bold text-dark m-0 mt-1">Rp <?= number_format($total_pajak, 0, ',', '.'); ?></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-card mini-box" style="border-left-color: #6B3A1E;">
                <small class="text-muted fw-semibold d-block">TOTAL TRANSAKSI SUKSES</small>
                <h4 class="fw-bold text-dark m-0 mt-1"><?= $total_transaksi; ?> Nota Lunas</h4>
            </div>
        </div>
    </div>

    <div class="widget-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-muted m-0"><i class="fa-solid fa-list-check text-success me-2"></i>Rincian Penjualan Terarsip</h6>
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;"><i class="fa-solid fa-print me-1"></i> Cetak Dokumen</button>
        </div>
        <div class="table-responsive">
            <table class="table custom-table m-0">
                <thead>
                    <tr>
                        <th>Waktu Transaksi</th>
                        <th>No. Nota</th>
                        <th>Pelanggan</th>
                        <th class="text-end">Pajak Resto</th>
                        <th class="text-end">Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($laporan_penjualan)): ?>
                        <?php foreach($laporan_penjualan as $row): ?>
                            <tr>
                                <td><?= date('d M Y, H:i', strtotime($row['created_at'])); ?> WIB</td>
                                <td class="fw-bold text-success">#<?= $row['order_number'] ?? $row['id']; ?></td>
                                <td><?= $row['customer_name'] ?? 'Pelanggan'; ?></td>
                                <td class="text-end text-muted">Rp <?= number_format(($row['total_payment'] - $row['total_amount']), 0, ',', '.'); ?></td>
                                <td class="text-end fw-bold">Rp <?= number_format($row['total_payment'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data omzet penjualan pada rentang tanggal ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>