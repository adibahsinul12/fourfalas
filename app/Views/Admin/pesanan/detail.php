<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #<?= $order['order_number'] ?? $order['id']; ?> - FO'Orders</title>
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
            top: 0;
            left: 0;
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

        /* ===== TOP ACTION BAR (tombol kembali + toggle menu) ===== */
        .top-action-bar { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
        .menu-toggle-btn {
            display: none;
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            color: #6B3A1E;
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* ===== WIDGET ===== */
        .widget-card { background-color: #FFFFFF; border-radius: 16px; padding: 24px; border: 1px solid rgba(229, 229, 229, 0.5); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01); }
        .badge-status { padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 12px; display: inline-block; white-space: nowrap; }
        .status-selesai { background-color: #E8F5E9; color: #4CAF50; }
        .status-diproses { background-color: #FFF3E0; color: #FF9800; }
        .status-menunggu { background-color: #ECEFF1; color: #607D8B; }
        .status-dibatalkan { background-color: #FFEBEE; color: #F44336; }
        .item-table th { font-size: 12px; text-transform: uppercase; color: #888888; border-bottom: 2px solid #F7F3EE; padding: 12px; white-space: nowrap; }
        .item-table td { font-size: 14px; padding: 14px 12px; vertical-align: middle; border-bottom: 1px solid #F7F3EE; }
        .table-responsive { -webkit-overflow-scrolling: touch; }

        /* Header widget (judul + badge status) */
        .widget-header { flex-wrap: wrap; gap: 10px; }

        /* Panel eksekusi (tombol aksi staf) */
        .action-panel-buttons { display: flex; gap: 8px; flex-wrap: wrap; width: 100%; }
        .action-panel-buttons > * { flex: 1 1 220px; }

        /* =========================================================
            BREAKPOINTS RESPONSIF
           ========================================================= */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -280px;
                width: 260px;
                box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            }
            .sidebar.show { left: 0; }
            .sidebar-close-btn { display: block; }
            .main-content { margin-left: 0; padding: 20px; }
            .menu-toggle-btn { display: flex; }
        }

        @media (max-width: 767.98px) {
            .main-content { padding: 16px; }
            .widget-card { padding: 16px; border-radius: 14px; }
            .widget-card.mb-4 { margin-bottom: 16px !important; }
            .item-table th, .item-table td { padding: 10px 8px; font-size: 12px; }
            .action-panel-buttons > * { flex: 1 1 100%; }
            .widget-card h5 { font-size: 14px; }
        }

        @media (max-width: 479.98px) {
            .sidebar-brand span { font-size: 1.2rem; }
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
        <a href="<?= base_url('admin') ?>" class="sidebar-brand"><i class="fa-solid fa-mug-hot text-success"></i> <span>FO'Orders</span></a>
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
    <div class="top-action-bar">
        <button class="menu-toggle-btn" id="menuToggleBtn" aria-label="Buka menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a href="<?= base_url('admin/pesanan'); ?>" class="btn btn-sm btn-secondary" style="border-radius: 8px;"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Antrean</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="widget-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3 widget-header">
                    <h5 class="fw-bold m-0">🛒 Rincian Item Pesanan</h5>
                    <?php 
                        $status = $order['order_status'] ?? 'Menunggu';
                        if ($status == 'Menunggu') echo '<span class="badge-status status-menunggu">Menunggu Pembayaran</span>';
                        elseif ($status == 'Diproses') echo '<span class="badge-status status-diproses">Sedang Dimasak Dapur</span>';
                        elseif ($status == 'Selesai') echo '<span class="badge-status status-selesai">Selesai & Lunas</span>';
                        else echo '<span class="badge-status status-dibatalkan">Batal</span>';
                    ?>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table item-table m-0">
                        <thead>
                            <tr>
                                <th>Menu Makanan / Minuman</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($order_items)) : ?>
                                <?php foreach ($order_items as $item) : ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark"><?= $item['menu_name']; ?></span>
                                            <?php if (!empty($item['notes'])) : ?>
                                                <small class="d-block text-danger mt-1">📝 Catatan: "<?= $item['notes']; ?>"</small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">Rp <?= number_format($item['price_at_order'], 0, ',', '.'); ?></td>
                                        <td class="text-center fw-bold">x<?= $item['quantity']; ?></td>
                                        <td class="text-end fw-semibold">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada item pada pesanan ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="widget-card">
                <h5 class="fw-bold mb-3">⚡ Panel Eksekusi Staf Kafe</h5>
                <hr>
                <div class="action-panel-buttons">
                    <?php if ($status == 'Menunggu') : ?>
                        <form action="<?= base_url('admin/pay/' . $order['id']); ?>" method="POST" class="w-100">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted mb-1">METODE PEMBAYARAN KASIR</label>
                                <select name="payment_method" class="form-select fw-semibold" style="border-radius: 8px; padding: 10px; border: 1px solid #ccc;" required>
                                    <option value="Tunai" selected>💵 Tunai (Cash)</option>
                                    <option value="QRIS">📱 QRIS / E-Wallet (Dana/OVO/Gopay)</option>
                                    <option value="Transfer Bank">🏦 Transfer Bank</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100 p-2 fw-semibold" style="border-radius: 10px;"><i class="fa-solid fa-cash-register me-2"></i>Terima Uang Kasir (Lunas)</button>
                        </form>
                    <?php elseif ($status == 'Diproses') : ?>
                        <form action="<?= base_url('admin/update-status/' . $order['id']); ?>" method="POST" class="w-100">
                            <button type="submit" class="btn btn-warning text-white w-100 p-2 fw-semibold" style="border-radius: 10px;"><i class="fa-solid fa-utensils me-2"></i>Masakan Selesai (Sajikan)</button>
                        </form>
                    <?php else : ?>
                        <button class="btn btn-secondary w-100 p-2 fw-semibold" style="border-radius: 10px;" disabled><i class="fa-solid fa-circle-check me-2"></i>Transaksi Selesai Diarsip</button>
                    <?php endif; ?>
                    
                    <?php if ($status != 'Selesai' && $status != 'Batal') : ?>
                        <form action="<?= base_url('admin/batalkan/' . $order['id']); ?>" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan kafe ini?')" class="w-100 mt-2">
                            <button type="submit" class="btn btn-outline-danger w-100 p-2 fw-semibold" style="border-radius: 10px;"><i class="fa-solid fa-ban me-2"></i>Batalkan Pesanan</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="widget-card">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-receipt text-success me-2"></i>Nota Tagihan #<?= $order['order_number']; ?></h5>
                <hr>
                <div class="mb-3">
                    <small class="text-muted d-block font-weight-semibold">NAMA PELANGGAN</small>
                    <span class="fw-bold text-dark" style="font-size: 15px;"><?= $order['customer_name']; ?></span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">LOKASI ANTRIAN</small>
                    <span class="badge bg-secondary fw-bold">Meja <?= $order['table_id']; ?></span>
                </div>
                <div class="mb-4">
                    <small class="text-muted d-block">WAKTU MASUK</small>
                    <span class="small text-muted fw-semibold"><i class="fa-regular fa-clock me-1"></i> <?= $order['created_at']; ?></span>
                </div>
                <hr>
                
                <div class="d-flex justify-content-between mb-2 small text-muted">
                    <span>Total Item (Subtotal)</span>
                    <span>Rp <?= number_format($order['subtotal'], 0, ',', '.'); ?></span>
                </div>
               
                <hr style="border-style: dashed;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold" style="font-size: 14px;">Total Akhir Tagihan</span>
                    <span class="fw-bold text-success" style="font-size: 20px;">Rp <?= number_format($order['total_payment'], 0, ',', '.'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuToggleBtn = document.getElementById('menuToggleBtn');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

    function openSidebar() {
        sidebar.classList.add('show');
        overlay.classList.add('show');
    }
    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }

    if(menuToggleBtn) menuToggleBtn.addEventListener('click', openSidebar);
    if(sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', closeSidebar);
    if(overlay) overlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) {
            closeSidebar();
        }
    });

    // ========================================================
    // SOLUSI TOTAL KASIR: PAKSA SUNTIK VALUE DROPDOWN KE FORM SEBELUM SUBMIT
    // ========================================================
    document.addEventListener('DOMContentLoaded', function() {
        const payForm = document.querySelector('form[action*="pay"]');
        if (payForm) {
            payForm.addEventListener('submit', function(e) {
                const selectPayment = document.querySelector('select[name="payment_method"]');
                if (selectPayment) {
                    let hiddenInput = payForm.querySelector('input[name="payment_method"]');
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'payment_method';
                        payForm.appendChild(hiddenInput);
                    }
                    hiddenInput.value = selectPayment.value;
                }
            });
        }
    });
</script>
</body>
</html>