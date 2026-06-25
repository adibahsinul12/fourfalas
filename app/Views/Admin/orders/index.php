<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - FO'Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif;
            background-color: #F7F3EE; /* Cream Background sesuai desain */
            color: #333333;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* SIDEBAR STYLING */
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: #6B3A1E; /* FIX: Sudah diganti ke warna cokelat terang pilihanmu */
            position: fixed;
            top: 0;
            left: 0;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 100;
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
            text-transform: none; /* FIX: Memaksa huruf besar 'O' muncul sesuai ketikan asli */
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }
        .sidebar-item {
            margin-bottom: 8px;
        }
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
        }
        .sidebar-link:hover {
            opacity: 1;
            background-color: rgba(255, 255, 255, 0.05);
            color: #FFFFFF;
        }
        .sidebar-link.active {
            opacity: 1;
            background-color: #4CAF50; /* Primary Green Aktif */
            color: #FFFFFF;
            font-weight: 600;
        }
        .sidebar-logout {
            color: #FFFFFF;
            opacity: 0.7;
            padding: 12px 16px;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* MAIN CONTENT STYLING */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        /* TOPBAR STYLING */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .search-box {
            position: relative;
            width: 300px;
        }
        .search-box input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border-radius: 12px;
            border: 1px solid #E5E5E5;
            background-color: #FFFFFF;
            font-size: 13px;
        }
        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #888888;
        }
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .notif-btn {
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6B3A1E; /* FIX: Icon notifikasi disesuaikan ke cokelat terang */
            cursor: pointer;
        }
        .profile-card {
            background: #FFFFFF;
            padding: 6px 16px 6px 6px;
            border-radius: 30px;
            border: 1px solid #E5E5E5;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .profile-avatar {
            width: 32px;
            height: 32px;
            background-color: #F7F3EE;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6B3A1E; /* FIX: Icon avatar disesuaikan ke cokelat terang */
        }

        /* STATISTIC CARDS STYLING */
        .stat-card {
            background-color: #FFFFFF;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(229, 229, 229, 0.5);
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #FFFFFF;
        }
        .stat-title {
            font-size: 11px;
            color: #888888;
            margin-bottom: 2px;
            font-weight: 500;
        }
        .stat-value {
            font-size: 18px;
            font-weight: 700;
            color: #333333;
            margin: 0;
        }
        .stat-desc {
            font-size: 11px;
            margin-top: 4px;
            margin-bottom: 0;
        }

        /* WIDGET CARDS (CHART & TABLES) */
        .widget-card {
            background-color: #FFFFFF;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(229, 229, 229, 0.5);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
            height: 100%;
        }
        .widget-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .widget-title {
            font-size: 15px;
            font-weight: 700;
            color: #333333;
            margin: 0;
        }

        /* TABLE DESIGN */
        .custom-table th {
            font-size: 12px;
            text-transform: uppercase;
            color: #888888;
            font-weight: 600;
            padding: 12px 16px;
            border-bottom: 2px solid #F7F3EE;
        }
        .custom-table td {
            font-size: 13px;
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #F7F3EE;
        }

        /* STATUS BADGES FROM DESIGN */
        .badge-status {
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 11px;
            display: inline-block;
        }
        .status-selesai { background-color: #E8F5E9; color: #4CAF50; }
        .status-diproses { background-color: #FFF3E0; color: #FF9800; }
        .status-menunggu { background-color: #ECEFF1; color: #607D8B; }
        .status-dibatalkan { background-color: #FFEBEE; color: #F44336; }

        .btn-view-all {
            color: #4CAF50;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
        }
        .btn-action-green {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-action-green:hover {
            background-color: #43A047;
            color: white;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <a href="#" class="sidebar-brand">
            <i class="fa-solid fa-mug-hot text-success"></i>
            <span>FO'Orders</span>
        </a>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link active">
                    <i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-utensils"></i> <span>Pesanan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-bowl-food"></i> <span>Menu</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-chair"></i> <span>Meja</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-users"></i> <span>Pelanggan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-file-invoice-dollar"></i> <span>Transaksi</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-chart-line"></i> <span>Laporan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="fa-solid fa-gear"></i> <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>
    
    <a href="#" class="sidebar-logout">
        <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
    </a>
</div>

<div class="main-content">
    
    <div class="topbar">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Cari sesuatu...">
        </div>
        <div class="admin-profile">
            <div class="notif-btn">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div class="profile-card">
                <div class="profile-avatar">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="small">
                    <div class="fw-bold" style="font-size: 12px; line-height: 1.2;">Admin</div>
                    <span class="text-muted" style="font-size: 10px;">Administrator</span>
                </div>
                <i class="fa-solid fa-angle-down ms-2 text-muted" style="font-size: 11px;"></i>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card h-100">
                <div class="stat-icon" style="background-color: #4CAF50; flex-shrink: 0;"><i class="fa-solid fa-wallet"></i></div>
                <div class="flex-grow-1">
                    <div class="stat-title">Total Pendapatan</div>
                    <h3 class="stat-value">Rp 12.540.000</h3>
                    <p class="stat-desc text-success fw-semibold m-0"><i class="fa-solid fa-arrow-up"></i> +12% dari kemarin</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card h-100">
                <div class="stat-icon" style="background-color: #6B3A1E; flex-shrink: 0;"><i class="fa-solid fa-scroll"></i></div>
                <div class="flex-grow-1">
                    <div class="stat-title">Total Pesanan</div>
                    <h3 class="stat-value">156</h3>
                    <p class="stat-desc text-success fw-semibold m-0"><i class="fa-solid fa-arrow-up"></i> +8% dari kemarin</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card h-100">
                <div class="stat-icon" style="background-color: #4CAF50; flex-shrink: 0;"><i class="fa-solid fa-users"></i></div>
                <div class="flex-grow-1">
                    <div class="stat-title">Total Pelanggan</div>
                    <h3 class="stat-value">89</h3>
                    <p class="stat-desc text-success fw-semibold m-0"><i class="fa-solid fa-arrow-up"></i> +5% dari kemarin</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card h-100">
                <div class="stat-icon" style="background-color: #6B3A1E; flex-shrink: 0;"><i class="fa-solid fa-mug-saucer"></i></div>
                <div class="flex-grow-1">
                    <div class="stat-title">Total Menu</div>
                    <h3 class="stat-value">34</h3>
                    <p class="stat-desc text-success fw-semibold m-0"><i class="fa-solid fa-arrow-up"></i> +2% dari kemarin</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="widget-card">
                <div class="widget-header">
                    <h5 class="widget-title">Grafik Penjualan</h5>
                    <select class="form-select form-select-sm" style="width: auto; font-size: 11px; border-radius: 8px;">
                        <option>Mingguan</option>
                    </select>
                </div>
                <div class="d-flex align-items-center justify-content-center text-muted" style="height: 240px; background-color: #FAFAFA; border-radius: 12px; border: 1px dashed #E5E5E5;">
                    <div class="text-center">
                        <i class="fa-solid fa-chart-line mb-2" style="font-size: 2rem; color: #4CAF50;"></i>
                        <div class="small">Area Chart Penjualan Real-time</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="widget-card">
                <div class="widget-header">
                    <h5 class="widget-title">Pesanan Terbaru</h5>
                    <a href="#" class="btn-view-all">Lihat semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table custom-table m-0">
                        <thead>
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Meja</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders) && is_array($orders)) : ?>
                                <?php foreach (array_slice($orders, 0, 5) as $row) : ?>
                                    <tr>
                                        <td class="fw-bold" style="color: #6B3A1E;">#<?= $row['order_number']; ?></td>
                                        <td>Meja <?= $row['table_number']; ?></td>
                                        <td class="fw-semibold">Rp <?= number_format($row['total_payment'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php 
                                            $status = $row['order_status'];
                                            if ($status == 'Menunggu') echo '<span class="badge-status status-menunggu">Menunggu</span>';
                                            elseif ($status == 'Diproses') echo '<span class="badge-status status-diproses">Diproses</span>';
                                            elseif ($status == 'Selesai') echo '<span class="badge-status status-selesai">Selesai</span>';
                                            else echo '<span class="badge-status status-dibatalkan">Batal</span>';
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/detail/' . $row['id']); ?>" class="btn-action-green">
                                                Proses
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada pesanan masuk.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>