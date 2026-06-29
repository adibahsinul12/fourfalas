<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan - FO'Orders</title>
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
        .search-box { position: relative; width: 300px; }
        .search-box input { width: 100%; padding: 10px 16px 10px 40px; border-radius: 12px; border: 1px solid #E5E5E5; background-color: #FFFFFF; font-size: 13px; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #888888; }
        .admin-profile { display: flex; align-items: center; gap: 20px; }
        .notif-btn { background: #FFFFFF; border: 1px solid #E5E5E5; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6B3A1E; }
        .profile-card { background: #FFFFFF; padding: 6px 16px 6px 6px; border-radius: 30px; border: 1px solid #E5E5E5; display: flex; align-items: center; gap: 10px; }
        .profile-avatar { width: 32px; height: 32px; background-color: #F7F3EE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6B3A1E; }
        .widget-card { background-color: #FFFFFF; border-radius: 16px; padding: 24px; border: 1px solid rgba(229, 229, 229, 0.5); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01); }
        
        /* TAB FILTER DESIGN */
        .nav-tabs-custom { display: flex; gap: 10px; border-bottom: 2px solid #E5E5E5; padding-bottom: 10px; margin-bottom: 24px; }
        .nav-link-custom { color: #888888; text-decoration: none; font-size: 13px; font-weight: 500; padding: 8px 16px; border-radius: 8px; transition: all 0.2s; }
        .nav-link-custom:hover { color: #6B3A1E; background-color: rgba(107, 58, 30, 0.05); }
        .nav-link-custom.active { color: #6B3A1E; background-color: #FFFFFF; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #E5E5E5; }

        .custom-table th { font-size: 12px; text-transform: uppercase; color: #888888; font-weight: 600; padding: 12px 16px; border-bottom: 2px solid #F7F3EE; }
        .custom-table td { font-size: 13px; padding: 14px 16px; vertical-align: middle; border-bottom: 1px solid #F7F3EE; }
        
        .badge-status { padding: 4px 12px; border-radius: 6px; font-weight: 600; font-size: 11px; display: inline-block; }
        .status-selesai { background-color: #E8F5E9; color: #4CAF50; }
        .status-diproses { background-color: #FFF3E0; color: #FF9800; }
        .status-menunggu { background-color: #ECEFF1; color: #607D8B; }
        .status-dibatalkan { background-color: #FFEBEE; color: #F44336; }
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
            <li class="sidebar-item"><a href="<?= base_url('admin/pesanan') ?>" class="sidebar-link active"><i class="fa-solid fa-utensils"></i> <span>Pesanan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/menu') ?>" class="sidebar-link"><i class="fa-solid fa-bowl-food"></i> <span>Menu</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/meja') ?>" class="sidebar-link"><i class="fa-solid fa-chair"></i> <span>Meja</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pelanggan') ?>" class="sidebar-link"><i class="fa-solid fa-users"></i> <span>Pelanggan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/transaksi') ?>" class="sidebar-link"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Transaksi</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/laporan') ?>" class="sidebar-link"><i class="fa-solid fa-chart-line"></i> <span>Laporan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pengaturan') ?>" class="sidebar-link"><i class="fa-solid fa-gear"></i> <span>Pengaturan</span></a></li>
        </ul>
    </div>
    <a href="<?= base_url('logout') ?>" class="sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="search-box"><i class="fa-solid fa-magnifying-glass"></i><input type="text" id="searchOrder" placeholder="Cari nomor pesanan/nama..."></div>
        <div class="admin-profile">
            <div class="notif-btn"><i class="fa-solid fa-bell"></i></div>
            <div class="profile-card">
                <div class="profile-avatar"><i class="fa-solid fa-user-tie"></i></div>
                <div class="small"><div class="fw-bold" style="font-size: 12px;">Admin</div><span class="text-muted" style="font-size: 10px;">Administrator</span></div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>📋 Daftar Antrean Pesanan Kafe</h4>
    </div>

    <?php $current_status = request()->getGet('status'); ?>
    <div class="nav-tabs-custom">
        <a href="<?= base_url('admin/pesanan') ?>" class="nav-link-custom <?= empty($current_status) ? 'active' : '' ?>">Semua</a>
        <a href="<?= base_url('admin/pesanan?status=Menunggu') ?>" class="nav-link-custom <?= $current_status == 'Menunggu' ? 'active' : '' ?>">Menunggu</a>
        <a href="<?= base_url('admin/pesanan?status=Diproses') ?>" class="nav-link-custom <?= $current_status == 'Diproses' ? 'active' : '' ?>">Diproses</a>
        <a href="<?= base_url('admin/pesanan?status=Selesai') ?>" class="nav-link-custom <?= $current_status == 'Selesai' ? 'active' : '' ?>">Selesai</a>
        <a href="<?= base_url('admin/pesanan?status=Batal') ?>" class="nav-link-custom <?= $current_status == 'Batal' ? 'active' : '' ?>">Batal</a>
    </div>

    <div class="widget-card">
        <div class="table-responsive">
            <table class="table custom-table m-0">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Nomor Meja</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Tagihan</th>
                        <th>Status Antrean</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    <?php if(!empty($orders)): ?>
                        <?php foreach($orders as $row): ?>
                            <tr>
                                <td class="fw-bold order-num" style="color: #6B3A1E;">#<?= $row['order_number'] ?? $row['id']; ?></td>
                                <td>Meja <?= $row['table_number'] ?? '-'; ?></td>
                                <td class="cust-name"><?= $row['customer_name'] ?? 'Pelanggan'; ?></td>
                                <td class="fw-semibold">Rp <?= number_format($row['total_payment'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                        $status = $row['order_status'] ?? 'Menunggu';
                                        if ($status == 'Menunggu') echo '<span class="badge-status status-menunggu">Menunggu</span>';
                                        elseif ($status == 'Diproses') echo '<span class="badge-status status-diproses">Diproses</span>';
                                        elseif ($status == 'Selesai') echo '<span class="badge-status status-selesai">Selesai</span>';
                                        else echo '<span class="badge-status status-dibatalkan">Batal</span>';
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/detail/'.$row['id']) ?>" class="btn btn-sm btn-success" style="font-size: 12px; border-radius: 8px; padding: 6px 14px;">
                                        <i class="fa-solid fa-money-bill-wave me-1"></i> Proses / Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fa-solid fa-folder-open mb-2 d-block" style="font-size: 2rem; color: #888888;"></i>
                                Saat ini tidak ada antrean pesanan yang cocok.
                            </td>
                        </tr>
                    <?php endif; ?>  
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('searchOrder').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#orderTableBody tr');
    
    rows.forEach(row => {
        let orderNum = row.querySelector('.order-num')?.textContent.toLowerCase() || '';
        let custName = row.querySelector('.cust-name')?.textContent.toLowerCase() || '';
        
        if (orderNum.includes(filter) || custName.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>