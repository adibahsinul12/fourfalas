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

        .action-buttons { display: flex; gap: 6px; justify-content: center; flex-wrap: nowrap; }

        .action-buttons .btn-edit {
            background-color: #4CAF50;
            color: #FFFFFF;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        .action-buttons .btn-edit:hover { background-color: #3e9c43; }

        .action-buttons .btn-delete {
            background-color: #6B3A1E;
            color: #FFFFFF;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        .action-buttons .btn-delete:hover { background-color: #552e18; }

        /* ===== MODAL ===== */
        .modal-dialog { 
            max-width: 550px; 
            margin: 1.75rem auto; 
        }
        .modal-body {
            max-height: 75vh;
            overflow-y: auto;
        }
        .modal-content { border-radius: 14px; }

        button, input, select, textarea, .btn {
            font-family: 'Poppins', sans-serif !important;
        }

        .btn-tambah { 
            background-color: #4CAF50 !important;
            border-color: #4CAF50 !important;
            color: #FFFFFF !important;
        }
        .btn-tambah:hover {
            background-color: #3e9c43 !important;
            border-color: #3e9c43 !important;
        }

        /* Styling area pengelolaan varian di form */
        .variant-box {
            background-color: #FDFBF9;
            border: 1px dashed #DDD1C7;
            border-radius: 10px;
            padding: 14px;
        }

        @media (max-width: 991.98px) {
            .sidebar { left: -280px; width: 260px; box-shadow: 4px 0 20px rgba(0,0,0,0.15); }
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
            .widget-card { padding: 16px; border-radius: 14px; }
            .custom-table th, .custom-table td { padding: 10px 12px; font-size: 12px; }
            .action-buttons { flex-direction: column; gap: 6px; }
            .action-buttons .btn, .action-buttons a { width: 100%; }
            .modal-dialog { margin: 0.75rem; }
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
                        <th>Varian & Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Menampung HTML seluruh modal Edit agar dicetak SETELAH </table>.
                        // Ini memperbaiki bug: <div class="modal"> tidak boleh berada langsung
                        // di dalam <tbody>, karena browser akan otomatis memindahkannya
                        // (foster-parenting) dan itu bisa merusak perilaku JavaScript.
                        $modalsHtml = '';
                    ?>
                    <?php if(!empty($daftar_menu)): ?>
                        <?php 
                        $db = \Config\Database::connect();
                        foreach($daftar_menu as $row): 
                            // Ambil list data varian dari menu ini langsung dari DB untuk ditampilkan di list tabel
                            $variants = $db->table('menu_variants')->where('menu_id', $row['id'])->get()->getResultArray();
                        ?>
                            <tr>
                                <td>
                                    <?php if (!empty($row['image_path'])): ?>
                                        <img src="<?= base_url('uploads/menus/'.$row['image_path']) ?>" width="60" height="60" style="object-fit:cover;border-radius:8px;">
                                    <?php else: ?>
                                        <img src="<?= base_url('uploads/menus/default_menus.jpg') ?>" width="60" height="60" style="object-fit:cover;border-radius:8px;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <b><?= $row['menu_name']; ?></b>
                                    <?php if($row['is_recommended'] == 1): ?>
                                        <span class="badge bg-warning text-dark ms-1" style="font-size: 10px;"><i class="fa-solid fa-star"></i> Best Seller</span>
                                    <?php endif; ?>
                                </td>
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
                                <td>
                                    <?php if(!empty($variants)): ?>
                                        <ul class="list-unstyled m-0" style="font-size: 12px;">
                                            <?php foreach($variants as $v): ?>
                                                <li>
                                                    🔹 <?= $v['variant_name']; ?>: 
                                                    <span class="text-success fw-bold">Rp <?= number_format($v['price'], 0, ',', '.'); ?></span> 
                                                    <small class="text-muted">(Stok: <?= $v['stock']; ?>)</small>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <span class="text-danger small"><i class="fa-solid fa-triangle-exclamation"></i> Belum ada varian!</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>" style="font-size: 11px; border-radius: 6px;">Edit</button>
                                        <a href="<?= base_url('admin/menu/delete/'.$row['id']) ?>" class="btn btn-sm btn-delete" style="font-size: 11px; border-radius: 6px;" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>

                            <?php
                                // === Susun HTML modal edit ke dalam variabel, BUKAN dicetak di sini ===
                                ob_start();
                            ?>
                            <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('admin/menu/edit/'.$row['id']) ?>" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header"><h5>✏️ Edit Menu & Varian</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                            <div class="modal-body">
                                                <div class="mb-3"><label class="form-label fw-semibold">Nama Menu</label><input type="text" name="menu_name" class="form-control" value="<?= $row['menu_name'] ?>" required></div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Kategori</label>
                                                    <select name="category_id" class="form-select kategori-select">
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

                                                <div class="mb-3 deskripsi-paket-wrapper" style="<?= $row['category_id'] == 8 ? '' : 'display:none;' ?>">
                                                    <label class="form-label fw-semibold text-primary">📦 Deskripsi Isi Paket</label>
                                                    <textarea name="description" class="form-control" rows="3" placeholder="Contoh: 1 Nasi Goreng + 1 Es Teh Manis + 1 Puding Coklat"><?= $row['description'] ?? '' ?></textarea>
                                                    <small class="text-muted">Jelaskan apa saja isi paket ini. Hanya muncul untuk kategori "Paket Menu".</small>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-primary">⚙️ Atur Ulang Varian Menu <span class="variant-optional-note text-muted fw-normal" style="display:none; font-size:11px;">(opsional untuk Paket Menu)</span></label>
                                                    <div class="variant-box edit-variant-container" data-menu-id="<?= $row['id']; ?>">
                                                        <?php if(!empty($variants)): ?>
                                                            <?php foreach($variants as $index => $v): ?>
                                                                <div class="row g-2 mb-2 variant-row">
                                                                    <div class="col-md-5">
                                                                        <input type="text" name="variant_name[]" class="form-control form-control-sm" value="<?= $v['variant_name']; ?>" placeholder="Nama Varian" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="number" name="variant_price[]" class="form-control form-control-sm" value="<?= $v['price']; ?>" placeholder="Harga" required>
                                                                    </div>
                                                                    <div class="col-md-3 d-flex gap-1">
                                                                        <input type="number" name="variant_stock[]" class="form-control form-control-sm" value="<?= $v['stock']; ?>" placeholder="Stok" required>
                                                                        <?php if($index > 0): ?>
                                                                            <button type="button" class="btn btn-danger btn-sm btn-remove-variant"><i class="fa-solid fa-trash"></i></button>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div class="row g-2 mb-2 variant-row">
                                                                <div class="col-md-5"><input type="text" name="variant_name[]" class="form-control form-control-sm" placeholder="Nama Varian" required></div>
                                                                <div class="col-md-4"><input type="number" name="variant_price[]" class="form-control form-control-sm" placeholder="Harga" required></div>
                                                                <div class="col-md-3"><input type="number" name="variant_stock[]" class="form-control form-control-sm" placeholder="Stok" required></div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <button type="button" class="btn btn-xs btn-outline-primary mt-2 btn-add-edit-variant" style="font-size:11px;"><i class="fa-solid fa-plus"></i> Tambah Varian</button>
                                                </div>

                                                <div class="mb-3 form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_recommended" value="1" id="editRekomendasi<?= $row['id'] ?>" <?= $row['is_recommended'] == 1 ? 'checked' : '' ?>>
                                                    <label class="form-check-label fw-semibold text-warning" for="editRekomendasi<?= $row['id'] ?>">
                                                        ⭐ Tandai sebagai Menu Rekomendasi (Best Seller)
                                                    </label>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Foto Saat Ini</label><br>
                                                    <?php if (!empty($row['image_path'])): ?>
                                                        <img src="<?= base_url('uploads/menus/'.$row['image_path']) ?>" width="100" class="img-thumbnail mb-2">
                                                    <?php else: ?>
                                                        <img src="<?= base_url('uploads/menus/default_menus.jpg') ?>" width="100" class="img-thumbnail mb-2">
                                                    <?php endif; ?>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Ganti Foto Menu</label>
                                                    <input type="file" name="gambar" class="form-control" accept="image/*">
                                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-warning btn-sm text-white">Simpan Perubahan</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                                $modalsHtml .= ob_get_clean();
                            ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data menu di database.</td></tr>
                    <?php endif; ?>  
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    // Cetak semua modal Edit DI SINI, di luar <table>.
    echo $modalsHtml;
?>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <form action="<?= base_url('admin/menu/add') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header"><h5>➕ Tambah Menu Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label fw-semibold">Nama Menu</label><input type="text" name="menu_name" class="form-control" placeholder="Masukkan nama makanan/minuman" required></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select kategori-select">
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

                    <div class="mb-3 deskripsi-paket-wrapper" style="display:none;">
                        <label class="form-label fw-semibold text-primary">📦 Deskripsi Isi Paket</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Contoh: 1 Nasi Goreng + 1 Es Teh Manis + 1 Puding Coklat"></textarea>
                        <small class="text-muted">Jelaskan apa saja isi paket ini. Hanya muncul untuk kategori "Paket Menu".</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-success">📋 Masukkan Varian Rasa / Ukuran / Level <span class="variant-optional-note text-muted fw-normal" style="display:none; font-size:11px;">(opsional untuk Paket Menu)</span></label>
                        <div class="variant-box" id="tambah-variant-container">
                            <div class="row g-2 mb-2 variant-row">
                                <div class="col-md-5">
                                    <input type="text" name="variant_name[]" class="form-control form-control-sm" placeholder="Nama Varian (e.g., Ice / Large / Level 1)" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="variant_price[]" class="form-control form-control-sm" placeholder="Harga (Rp)" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="variant_stock[]" class="form-control form-control-sm" placeholder="Stok" value="20" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-success mt-2" id="btn-add-tambah-variant" style="font-size: 11px;"><i class="fa-solid fa-plus"></i> Tambah Baris Varian</button>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_recommended" value="1" id="checkRekomendasi">
                        <label class="form-check-label fw-semibold text-warning" for="checkRekomendasi">
                            ⭐ Tandai sebagai Menu Rekomendasi (Best Seller)
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Menu</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-success btn-sm">Simpan Data</button></div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Handle Sidebar Responsive
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuToggleBtn = document.getElementById('menuToggleBtn');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

    function openSidebar() { sidebar.classList.add('show'); overlay.classList.add('show'); }
    function closeSidebar() { sidebar.classList.remove('show'); overlay.classList.remove('show'); }

    if(menuToggleBtn) menuToggleBtn.addEventListener('click', openSidebar);
    if(sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', closeSidebar);
    if(overlay) overlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) { closeSidebar(); }
    });

    // ========================================================
    // JAVASCRIPT DINAMIS UNTUK PENGELOLAAN DATA BANYAK VARIAN
    // ========================================================
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Dinamis di Modal Tambah Menu
        const tambahContainer = document.getElementById('tambah-variant-container');
        const btnAddTambah = document.getElementById('btn-add-tambah-variant');

        if(btnAddTambah && tambahContainer) {
            btnAddTambah.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'row g-2 mb-2 variant-row';
                newRow.innerHTML = `
                    <div class="col-md-5"><input type="text" name="variant_name[]" class="form-control form-control-sm" placeholder="Nama Varian" required></div>
                    <div class="col-md-4"><input type="number" name="variant_price[]" class="form-control form-control-sm" placeholder="Harga (Rp)" required></div>
                    <div class="col-md-3 d-flex gap-1">
                        <input type="number" name="variant_stock[]" class="form-control form-control-sm" placeholder="Stok" value="20" required>
                        <button type="button" class="btn btn-danger btn-sm btn-remove-variant"><i class="fa-solid fa-trash"></i></button>
                    </div>
                `;
                tambahContainer.appendChild(newRow);

                // Baris baru harus ikut aturan wajib/opsional sesuai kategori yang sedang dipilih
                const form = tambahContainer.closest('form');
                const catSelect = form ? form.querySelector('.kategori-select') : null;
                if (catSelect) applyKategoriRules(catSelect);
            });
        }

        // 2. Dinamis di Banyak Modal Edit Menu Sekaligus
        document.querySelectorAll('.btn-add-edit-variant').forEach(button => {
            button.addEventListener('click', function() {
                const modalBody = this.closest('.modal-body');
                const editContainer = modalBody.querySelector('.edit-variant-container');
                
                if(editContainer) {
                    const newRow = document.createElement('div');
                    newRow.className = 'row g-2 mb-2 variant-row';
                    newRow.innerHTML = `
                        <div class="col-md-5"><input type="text" name="variant_name[]" class="form-control form-control-sm" placeholder="Nama Varian" required></div>
                        <div class="col-md-4"><input type="number" name="variant_price[]" class="form-control form-control-sm" placeholder="Harga" required></div>
                        <div class="col-md-3 d-flex gap-1">
                            <input type="number" name="variant_stock[]" class="form-control form-control-sm" placeholder="Stok" value="20" required>
                            <button type="button" class="btn btn-danger btn-sm btn-remove-variant"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    `;
                    editContainer.appendChild(newRow);

                    // Baris baru harus ikut aturan wajib/opsional sesuai kategori yang sedang dipilih
                    const form = this.closest('form');
                    const catSelect = form ? form.querySelector('.kategori-select') : null;
                    if (catSelect) applyKategoriRules(catSelect);
                }
            });
        });

        // 3. Fungsi Global untuk Aksi Hapus Baris Varian (Berlaku di Modal Tambah & Edit)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove-variant')) {
                e.target.closest('.variant-row').remove();
            }
        });

        // 4. Aturan khusus untuk kategori "Paket Menu" (value 8), berlaku di modal
        //    Tambah maupun semua modal Edit:
        //    - Tampilkan field "Deskripsi Isi Paket"
        //    - Field varian (nama/harga/stok) jadi OPSIONAL, tidak wajib diisi
        const PAKET_MENU_VALUE = '8';

        function applyKategoriRules(selectEl) {
            const form = selectEl.closest('form');
            if (!form) return;

            const isPaket = selectEl.value === PAKET_MENU_VALUE;

            // Toggle field deskripsi paket
            const wrapper = form.querySelector('.deskripsi-paket-wrapper');
            if (wrapper) {
                wrapper.style.display = isPaket ? '' : 'none';
            }

            // Toggle label penanda opsional
            const note = form.querySelector('.variant-optional-note');
            if (note) {
                note.style.display = isPaket ? '' : 'none';
            }

            // Toggle wajib/tidaknya semua input varian di form ini (termasuk baris yang baru ditambah)
            form.querySelectorAll('input[name="variant_name[]"], input[name="variant_price[]"], input[name="variant_stock[]"]').forEach(input => {
                input.required = !isPaket;
            });
        }

        document.querySelectorAll('.kategori-select').forEach(select => {
            // Set kondisi awal saat halaman/modal dimuat
            applyKategoriRules(select);
            // Update setiap kali kategori diganti
            select.addEventListener('change', function() {
                applyKategoriRules(this);
            });
        });
    });
</script>
</body>
</html>