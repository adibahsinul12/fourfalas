<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu - FO'Orders</title>
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

        /* ===== TOPBAR ===== */
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 12px; flex-wrap: wrap; }
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
        .search-box { position: relative; width: 300px; flex: 1 1 200px; max-width: 300px; }
        .search-box input { width: 100%; padding: 10px 16px 10px 40px; border-radius: 12px; border: 1px solid #E5E5E5; background-color: #FFFFFF; font-size: 13px; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #888888; }
        .admin-profile { display: flex; align-items: center; gap: 20px; flex-shrink: 0; }
        .notif-btn { background: #FFFFFF; border: 1px solid #E5E5E5; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6B3A1E; flex-shrink: 0; }
        .profile-card { background: #FFFFFF; padding: 6px 16px 6px 6px; border-radius: 30px; border: 1px solid #E5E5E5; display: flex; align-items: center; gap: 10px; }
        .profile-avatar { width: 32px; height: 32px; background-color: #F7F3EE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6B3A1E; flex-shrink: 0; }

        /* ===== PAGE HEADER ===== */
        .page-header { flex-wrap: wrap; gap: 12px; }
        .page-header h4 { font-size: 1.15rem; margin: 0; }

        /* ===== WIDGET / TABLE ===== */
        .widget-card { background-color: #FFFFFF; border-radius: 16px; padding: 24px; border: 1px solid rgba(229, 229, 229, 0.5); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01); }
        .custom-table th { font-size: 12px; text-transform: uppercase; color: #888888; font-weight: 600; padding: 12px 16px; border-bottom: 2px solid #F7F3EE; white-space: nowrap; }
        .custom-table td { font-size: 13px; padding: 14px 16px; vertical-align: middle; border-bottom: 1px solid #F7F3EE; }
        .badge-status { padding: 4px 12px; border-radius: 6px; font-weight: 600; font-size: 11px; display: inline-block; white-space: nowrap; }
        .status-tersedia { background-color: #E8F5E9; color: #4CAF50; }
        .status-habis { background-color: #FFEBEE; color: #F44336; }
        .table-responsive { -webkit-overflow-scrolling: touch; }

        /* Tombol aksi (Edit/Hapus) supaya rapi & tidak bertumpuk aneh di kolom sempit */
        .action-buttons { display: flex; gap: 6px; justify-content: center; flex-wrap: nowrap; }

        /* ===== TAMBAHAN WARNA TOMBOL EDIT DAN HAPUS SESUAI PALET ===== */
        .action-buttons .btn-edit {
            background-color: #4CAF50; /* Hijau Daun (Primary Green) */
            color: #FFFFFF;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .action-buttons .btn-edit:hover {
            background-color: #3e9c43; /* Warna hijau sedikit lebih gelap saat di-hover */
        }

        .action-buttons .btn-delete {
            background-color: #6B3A1E; /* Coklat Kopi (Secondary Button / Primary Brown) */
            color: #FFFFFF;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .action-buttons .btn-delete:hover {
            background-color: #552e18; /* Warna coklat sedikit lebih gelap saat di-hover */
        }

        /* ===== MODAL (Tambah / Edit Menu) ===== */
        /* Update atau tambahkan ini di bagian CSS */
        .modal-dialog { 
            max-width: 500px; /* Atur lebar modal di sini */
            margin: 1.75rem auto; 
        }

        /* Biarkan body modal bisa di-scroll jika kepanjangan */
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
        .modal-content { border-radius: 14px; }

        /* ===== TAMBAHAN FONT & WARNA TOMBOL TAMBAH BARU ===== */
        /* Memaksa elemen button menggunakan font Poppins */
        button, input, select, textarea, .btn {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Mengubah warna tombol + Tambah Menu Baru */
        .btn-tambah { 
            background-color: #4CAF50 !important; /* Hijau Daun Utama */
            border-color: #4CAF50 !important;
            color: #FFFFFF !important;
        }

        .btn-tambah:hover {
            background-color: #3e9c43 !important; /* Hijau agak gelap saat di-hover */
            border-color: #3e9c43 !important;
        }


        /* =========================================================
           BREAKPOINTS RESPONSIF
           >= 992px (lg)  : Desktop / PC -> sidebar selalu tampil
           768-991px (md) : Tablet       -> sidebar off-canvas
           < 768px (sm/xs): Mobile / HP  -> sidebar off-canvas, layout 1 kolom
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
            .topbar { margin-bottom: 20px; }
            .search-box { order: 3; width: 100%; max-width: 100%; flex: 1 1 100%; }
            .admin-profile { gap: 10px; }
            .profile-card .small { display: none; }

            .page-header h4 { font-size: 1.05rem; width: 100%; }
            .page-header .btn { width: 100%; justify-content: center; }
            .page-header { display: flex; }
            .page-header .btn-success { display: flex; align-items: center; gap: 6px; }

            .widget-card { padding: 16px; border-radius: 14px; }
            .custom-table th, .custom-table td { padding: 10px 12px; font-size: 12px; }

            .action-buttons { flex-direction: column; gap: 6px; }
            .action-buttons .btn, .action-buttons a { width: 100%; }

            /* Modal full-width nyaman di HP, tetap ada jarak tipis di tepi */
            .modal-dialog { margin: 0.75rem; }
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
            <li class="sidebar-item"><a href="<?= base_url('admin/pesanan') ?>" class="sidebar-link"><i class="fa-solid fa-utensils"></i> <span>Pesanan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/menu') ?>" class="sidebar-link active"><i class="fa-solid fa-bowl-food"></i> <span>Menu</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/meja') ?>" class="sidebar-link"><i class="fa-solid fa-chair"></i> <span>Meja</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pelanggan') ?>" class="sidebar-link"><i class="fa-solid fa-users"></i> <span>Member</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/transaksi') ?>" class="sidebar-link"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Transaksi</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/laporan') ?>" class="sidebar-link"><i class="fa-solid fa-chart-line"></i> <span>Laporan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pengaturan') ?>" class="sidebar-link"><i class="fa-solid fa-gear"></i> <span>Pengaturan</span></a></li>
        </ul>
    </div>
    <a href="<?= base_url('logout') ?>" class="sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a>
</div>

<div class="main-content">
    <div class="topbar">
        <button class="menu-toggle-btn" id="menuToggleBtn" aria-label="Buka menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="search-box"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari sesuatu..."></div>
        <div class="admin-profile">
            <div class="notif-btn"><i class="fa-solid fa-bell"></i></div>
            <div class="profile-card">
                <div class="profile-avatar"><i class="fa-solid fa-user-tie"></i></div>
                <div class="small"><div class="fw-bold" style="font-size: 12px;">Admin</div><span class="text-muted" style="font-size: 10px;">Administrator</span></div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 page-header">
        <h4>📋 Manajemen Menu Makanan & Minuman</h4>
        <button class="btn btn-success btn-sm btn-tambah" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fa-solid fa-plus"></i> Tambah Menu Baru</button>
    </div>

    <div class="widget-card">
        <div class="table-responsive">
            <table class="table custom-table m-0">
               <thead>
    <tr>
        <th>Foto</th>
        <th>Nama Menu</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Status</th>
        <th class="text-center">Aksi</th>
    </tr>
</thead>
                <tbody>
                    <?php if(!empty($daftar_menu)): ?>
                        <?php foreach($daftar_menu as $row): ?>
                            <tr>
                                <td>
    <?php if (!empty($row['image_path'])): ?>
        <img src="<?= base_url('uploads/menus/'.$row['image_path']) ?>"
             width="60"
             height="60"
             style="object-fit:cover;border-radius:8px;">
    <?php else: ?>
        <img src="<?= base_url('uploads/menus/default_menus.jpg') ?>"
             width="60"
             height="60"
             style="object-fit:cover;border-radius:8px;">
    <?php endif; ?>
</td>
                                <td><b><?= $row['menu_name']; ?></b></td>
                                <td>
                                    <?php 
                                        switch($row['category_id']) {
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
                                <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if ($row['is_active'] == 1 && $row['stock'] > 0): ?>
                                        <span class="badge-status status-tersedia">Tersedia (<?= $row['stock']; ?>)</span>
                                    <?php else: ?>
                                        <span class="badge-status status-habis">Habis</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>" style="font-size: 11px; border-radius: 6px;">Edit</button>
                                        
                                        <a href="<?= base_url('admin/menu/delete/'.$row['id']) ?>" class="btn btn-sm btn-delete" style="font-size: 11px; border-radius: 6px;" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                       <form action="<?= base_url('admin/menu/edit/'.$row['id']) ?>" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header"><h5>✏️ Edit Menu</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                            <div class="modal-body">
                                                <div class="mb-3"><label class="form-label">Nama Menu</label><input type="text" name="menu_name" class="form-control" value="<?= $row['menu_name'] ?>" required></div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kategori</label>
                                                    <select name="category_id" class="form-select">
                                                        <option value="1" <?= $row['category_id'] == 1 ? 'selected' : '' ?>>Snack</option>
                                                        <option value="2" <?= $row['category_id'] == 2 ? 'selected' : '' ?>>Teh & Susu</option>
                                                        <option value="3" <?= $row['category_id'] == 3 ? 'selected' : '' ?>>Ayam & Seafood</option>
                                                        <option value="4" <?= $row['category_id'] == 4 ? 'selected' : '' ?>>Aneka Mie</option>
                                                        <option value="5" <?= $row['category_id'] == 5 ? 'selected' : '' ?>>Dessert / Es Krim</option>
                                                        <option value="6" <?= $row['category_id'] == 6 ? 'selected' : '' ?>>Aneka Nasi</option>
                                                        <option value="7" <?= $row['category_id'] == 7 ? 'selected' : '' ?>>Western Food</option>
                                                        <option value="8" <?= $row['category_id'] == 8 ? 'selected' : '' ?>>Paket Menu</option>
                                                        <option value="9" <?= $row['category_id'] == 9 ? 'selected' : '' ?>>Sup & Berkuah</option>
                                                        <option value="10" <?= $row['category_id'] == 10 ? 'selected' : '' ?>>Minuman Segar</option>
                                                        <option value="11" <?= $row['category_id'] == 11 ? 'selected' : '' ?>>Signature Drink</option>
                                                        <option value="12" <?= $row['category_id'] == 12 ? 'selected' : '' ?>>Frappe Series</option>
                                                        <option value="13" <?= $row['category_id'] == 13 ? 'selected' : '' ?>>Minuman Tradisional</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3"><label class="form-label">Harga (Rp)</label><input type="number" name="price" class="form-control" value="<?= (int)$row['price'] ?>" required></div>
                                                <div class="mb-3"><label class="form-label">Stok</label><input type="number" name="stock" class="form-control" value="<?= $row['stock'] ?>" required></div>

                                                <div class="mb-3">
                                                    <label class="form-label">Harga (Rp)</label>
                                                    <input type="number" name="price" class="form-control" value="<?= (int)$row['price'] ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Stok</label>
                                                    <input type="number" name="stock" class="form-control" value="<?= $row['stock'] ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                <label class="form-label">Foto Saat Ini</label><br>

                                                <?php if (!empty($row['image_path'])): ?>
                                                    <img src="<?= base_url('uploads/menus/'.$row['image_path']) ?>"
                                                        width="100"
                                                        class="img-thumbnail mb-2">
                                                <?php else: ?>
                                                    <img src="<?= base_url('uploads/menus/default_menus.jpg') ?>"
                                                        width="100"
                                                        class="img-thumbnail mb-2">
                                                <?php endif; ?>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Ganti Foto Menu</label>
                                                <input type="file" name="image" class="form-control" accept="image/*">
                                                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                                            </div>

                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-warning btn-sm text-white">Simpan Perubahan</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data menu di database.</td></tr>
                    <?php endif; ?>  
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <form action="<?= base_url('admin/menu/add') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header"><h5>➕ Tambah Menu Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nama Menu</label><input type="text" name="menu_name" class="form-control" placeholder="Masukkan nama makanan/minuman" required></div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="1">Snack</option>
                            <option value="2">Teh & Susu</option>
                            <option value="3">Ayam & Seafood</option>
                            <option value="4">Aneka Mie</option>
                            <option value="5">Dessert / Es Krim</option>
                            <option value="6">Aneka Nasi</option>
                            <option value="7">Western Food</option>
                            <option value="8">Paket Menu</option>
                            <option value="9">Sup & Berkuah</option>
                            <option value="10">Minuman Segar</option>
                            <option value="11">Signature Drink</option>
                            <option value="12">Frappe Series</option>
                            <option value="13">Minuman Tradisional</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Harga (Rp)</label><input type="number" name="price" class="form-control" placeholder="Contoh: 15000" required></div>
                    <div class="mb-3"><label class="form-label">Stok Awal</label><input type="number" name="stock" class="form-control" value="20" required></div>
                    <div class="mb-3">
    <label class="form-label">Foto Menu</label>
    <input type="file" name="image" class="form-control" accept="image/*">
</div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success btn-sm">Simpan Data</button></div>
            </form>
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

    menuToggleBtn.addEventListener('click', openSidebar);
    sidebarCloseBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) {
            closeSidebar();
        }
    });
</script>
</body>
</html>