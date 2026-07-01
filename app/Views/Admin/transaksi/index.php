<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - FO'Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F7F3EE; color: #333333; margin: 0; padding: 0; overflow-x: hidden; }

        /* ===== SIDEBAR ===== */
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
        }
        .sidebar-brand { color: #FFFFFF; font-size: 1.5rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 10px; padding-left: 12px; margin-bottom: 30px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; flex-grow: 1; }
        .sidebar-item { margin-bottom: 8px; }
        .sidebar-link { display: flex; align-items: center; gap: 14px; color: #FFFFFF; opacity: 0.7; padding: 12px 16px; text-decoration: none; font-size: 14px; font-weight: 500; border-radius: 10px; transition: all 0.2s ease; }
        .sidebar-link:hover { opacity: 1; background-color: rgba(255, 255, 255, 0.05); color: #FFFFFF; }
        .sidebar-link.active { opacity: 1; background-color: #4CAF50; color: #FFFFFF; font-weight: 600; }
        .sidebar-logout { color: #FFFFFF; opacity: 0.7; padding: 12px 16px; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 14px; }
        .sidebar-logout:hover { opacity: 1; background-color: rgba(244, 67, 54, 0.15); color: #FFCDD2; }

        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: #FFFFFF;
            font-size: 1.2rem;
            position: absolute;
            top: 20px;
            right: 16px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-overlay.show { display: block; }

        /* ===== MAIN CONTENT ===== */
        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; transition: margin-left 0.3s ease; }

        /* ===== TOPBAR ===== */
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 12px; flex-wrap: wrap; }
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
        }
        .search-box { position: relative; width: 300px; flex: 1 1 200px; max-width: 300px; }
        .search-box input { width: 100%; padding: 10px 16px 10px 40px; border-radius: 12px; border: 1px solid #E5E5E5; background-color: #FFFFFF; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; }
        .search-box input:focus { border-color: #6B3A1E; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #888888; }
        .admin-profile { display: flex; align-items: center; gap: 20px; flex-shrink: 0; }
        .notif-btn { background: #FFFFFF; border: 1px solid #E5E5E5; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6B3A1E; flex-shrink: 0; }
        .profile-card { background: #FFFFFF; padding: 6px 16px 6px 6px; border-radius: 30px; border: 1px solid #E5E5E5; display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit; }
        .profile-avatar { width: 32px; height: 32px; background-color: #F7F3EE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6B3A1E; flex-shrink: 0; }

        /* ===== WIDGET / TABLE ===== */
        .widget-card { background-color: #FFFFFF; border-radius: 16px; border: 1px solid rgba(229,229,229,0.5); box-shadow: 0 4px 12px rgba(0,0,0,0.04); overflow: hidden; }
        .custom-table th { font-size: 12px; text-transform: uppercase; color: #888888; font-weight: 600; padding: 12px 16px; border-bottom: 2px solid #F7F3EE; background: #FDFAF7; white-space: nowrap; }
        .custom-table td { font-size: 13px; padding: 14px 16px; vertical-align: middle; border-bottom: 1px solid #F7F3EE; }
        .custom-table tbody tr:last-child td { border-bottom: none; }
        .custom-table tbody tr:hover { background: #FDFAF7; }
        .table-responsive { -webkit-overflow-scrolling: touch; }

        .badge-status { padding: 4px 12px; border-radius: 6px; font-weight: 600; font-size: 11px; display: inline-block; background-color: #E8F5E9; color: #4CAF50; }
        .method-pill { background: #EEF2FF; color: #5C6BC0; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600; }

        /* ===== MOBILE CARD LIST ===== */
        .tx-card-list { display: none; }
        .tx-card { padding: 16px 18px; border-bottom: 1px solid #F0EBE5; }
        .tx-card:last-child { border-bottom: none; }
        .tx-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }
        .tx-card-id { font-weight: 700; font-size: 14px; }
        .tx-card-order { color: #4CAF50; font-weight: 600; font-size: 12px; margin-top: 2px; }
        .tx-card-body { display: flex; flex-direction: column; gap: 6px; }
        .tx-card-row { display: flex; justify-content: space-between; font-size: 13px; }
        .tx-card-label { color: #888888; font-size: 12px; }
        .tx-card-amount { font-weight: 700; font-size: 15px; margin-top: 4px; }
        .empty-state { text-align: center; padding: 48px 20px; color: #888; }
        .empty-state i { font-size: 2rem; color: #ccc; display: block; margin-bottom: 10px; }

        /* =========================================================
           BREAKPOINTS — sama persis seperti halaman Pelanggan
           >= 992px  : Desktop  -> sidebar always visible
           < 992px   : Tablet + Mobile -> sidebar off-canvas
           < 768px   : Mobile   -> card list, layout 1 kolom
           ========================================================= */

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
            .search-box { order: 3; width: 100%; max-width: 100%; flex: 1 1 100%; }
            .admin-profile { gap: 10px; }
            .profile-card .small { display: none; }

            /* Sembunyikan tabel, tampilkan kartu */
            .table-responsive { display: none; }
            .tx-card-list { display: block; }

            .custom-table th, .custom-table td { padding: 10px 12px; font-size: 12px; }
            .widget-card { border-radius: 14px; }
        }

        @media (max-width: 479.98px) {
            .main-content { padding: 12px; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar" id="sidebar">
    <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup menu">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <div>
        <a href="<?= base_url('admin') ?>" class="sidebar-brand">
            <i class="fa-solid fa-mug-hot text-success"></i> <span>FO'Orders</span>
        </a>
        <ul class="sidebar-menu">
            <li class="sidebar-item"><a href="<?= base_url('admin') ?>" class="sidebar-link"><i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pesanan') ?>" class="sidebar-link"><i class="fa-solid fa-utensils"></i> <span>Pesanan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/menu') ?>" class="sidebar-link"><i class="fa-solid fa-bowl-food"></i> <span>Menu</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/meja') ?>" class="sidebar-link"><i class="fa-solid fa-chair"></i> <span>Meja</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pelanggan') ?>" class="sidebar-link"><i class="fa-solid fa-users"></i> <span>Member</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/transaksi') ?>" class="sidebar-link active"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Transaksi</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/laporan') ?>" class="sidebar-link"><i class="fa-solid fa-chart-line"></i> <span>Laporan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pengaturan') ?>" class="sidebar-link"><i class="fa-solid fa-gear"></i> <span>Pengaturan</span></a></li>
        </ul>
    </div>
    <a href="<?= base_url('logout') ?>" class="sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <button class="menu-toggle-btn" id="menuToggleBtn" aria-label="Buka menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchTx" placeholder="Cari nomor pesanan/nama...">
        </div>
        <div class="admin-profile">
            <div class="notif-btn"><i class="fa-solid fa-bell"></i></div>
            <a href="<?= base_url('admin/pengaturan') ?>" class="profile-card">
                <div class="profile-avatar"><i class="fa-solid fa-user-tie"></i></div>
                <div class="small">
                    <div class="fw-bold" style="font-size: 12px;">Admin</div>
                    <span class="text-muted" style="font-size: 10px;">Administrator</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Page title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>💰 Riwayat Kasir & Transaksi</h4>
    </div>

    <!-- Widget Card -->
    <div class="widget-card">

        <!-- DESKTOP TABLE -->
        <div class="table-responsive">
            <table class="table custom-table m-0">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>No. Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Bayar</th>
                        <th>Metode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="txTableBody">
                    <?php if(!empty($daftar_transaksi)): ?>
                        <?php foreach($daftar_transaksi as $row): ?>
                            <tr
                                data-order="<?= esc(strtolower($row['order_number'] ?? $row['id'])) ?>"
                                data-cust="<?= esc(strtolower($row['customer_name'] ?? 'pelanggan')) ?>"
                            >
                                <td><b>#TX-<?= 1000 + $row['id']; ?></b></td>
                                <td class="text-success fw-semibold order-num">#<?= esc($row['order_number'] ?? $row['id']); ?></td>
                                <td class="cust-name"><?= esc($row['customer_name'] ?? 'Pelanggan'); ?></td>
                                <td>Rp <?= number_format($row['total_payment'], 0, ',', '.'); ?></td>
                                <td><span class="method-pill"><?= esc($row['payment_method'] ?? 'Tunai'); ?></span></td>
                                <td><span class="badge-status">Lunas</span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fa-solid fa-receipt mb-2 d-block" style="font-size:2rem;color:#ccc;"></i>
                                Belum ada riwayat transaksi masuk di database.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARD LIST -->
        <div class="tx-card-list" id="txCardList">
            <?php if(!empty($daftar_transaksi)): ?>
                <?php foreach($daftar_transaksi as $row): ?>
                    <div class="tx-card"
                         data-order="<?= esc(strtolower($row['order_number'] ?? $row['id'])) ?>"
                         data-cust="<?= esc(strtolower($row['customer_name'] ?? 'pelanggan')) ?>">
                        <div class="tx-card-header">
                            <div>
                                <div class="tx-card-id">#TX-<?= 1000 + $row['id']; ?></div>
                                <div class="tx-card-order">#<?= esc($row['order_number'] ?? $row['id']); ?></div>
                            </div>
                            <span class="badge-status">Lunas</span>
                        </div>
                        <div class="tx-card-body">
                            <div class="tx-card-row">
                                <span class="tx-card-label"><i class="fa-solid fa-user fa-xs me-1"></i>Pelanggan</span>
                                <span><?= esc($row['customer_name'] ?? 'Pelanggan'); ?></span>
                            </div>
                            <div class="tx-card-row">
                                <span class="tx-card-label"><i class="fa-solid fa-money-bill fa-xs me-1"></i>Metode</span>
                                <span class="method-pill"><?= esc($row['payment_method'] ?? 'Tunai'); ?></span>
                            </div>
                            <div class="tx-card-amount">Rp <?= number_format($row['total_payment'], 0, ',', '.'); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fa-solid fa-receipt"></i>
                    Belum ada riwayat transaksi masuk di database.
                </div>
            <?php endif; ?>
        </div>

    </div><!-- /widget-card -->
</div><!-- /main-content -->

<!-- ===== SCRIPTS ===== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar        = document.getElementById('sidebar');
    const overlay        = document.getElementById('sidebarOverlay');
    const menuToggleBtn  = document.getElementById('menuToggleBtn');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

    function openSidebar() {
        sidebar.classList.add('show');
        overlay.classList.add('show');
    }
    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }

    menuToggleBtn.addEventListener('click', openSidebar);
    sidebarCloseBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) closeSidebar();
    });

    /* Search: filter tabel & kartu mobile sekaligus */
    document.getElementById('searchTx').addEventListener('keyup', function () {
        const q = this.value.toLowerCase().trim();

        document.querySelectorAll('#txTableBody tr[data-order]').forEach(row => {
            row.style.display = (!q || row.dataset.order.includes(q) || row.dataset.cust.includes(q)) ? '' : 'none';
        });

        document.querySelectorAll('#txCardList .tx-card').forEach(card => {
            card.style.display = (!q || card.dataset.order.includes(q) || card.dataset.cust.includes(q)) ? '' : 'none';
        });
    });
</script>
</body>
</html>