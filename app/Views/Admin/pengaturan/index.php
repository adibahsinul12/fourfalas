<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - FO'Orders</title>
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
            <li class="sidebar-item"><a href="<?= base_url('admin/laporan') ?>" class="sidebar-link"><i class="fa-solid fa-chart-line"></i> <span>Laporan</span></a></li>
            <li class="sidebar-item"><a href="<?= base_url('admin/pengaturan') ?>" class="sidebar-link active"><i class="fa-solid fa-gear"></i> <span>Pengaturan</span></a></li>
        </ul>
    </div>
    <a href="<?= base_url('logout') ?>" class="sidebar-logout"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="search-box"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari sesuatu..."></div>
        <div class="admin-profile">
            <div class="notif-btn"><i class="fa-solid fa-bell"></i></div>
            <div class="profile-card">
                <div class="profile-avatar"><i class="fa-solid fa-user-tie"></i></div>
                <div class="small"><div class="fw-bold" style="font-size: 12px;">Admin</div><span class="text-muted" style="font-size: 10px;">Administrator</span></div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>⚙️ Pengaturan Sistem & Profil Kafe</h4>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
            <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="widget-card h-100">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-user-gear text-success me-2"></i>Profil Akun Admin</h5>
                <hr>
                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">USERNAME</label>
                    <input type="text" class="form-control bg-light" value="admin" readonly>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold">LEVEL AKSES</label>
                    <input type="text" class="form-control bg-light" value="Super Administrator Utama" readonly>
                </div>
                
                <h5 class="fw-bold mb-3 mt-4"><i class="fa-solid fa-key text-warning me-2"></i>Ganti Password Keamanan</h5>
                <hr>
                <form action="<?= base_url('admin/pengaturan/update-password') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label small">Password Lama</label>
                        <input type="password" name="password_lama" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Password Baru</label>
                        <input type="password" name="password_baru" class="form-control" placeholder="Masukkan password baru" required>
                    </div>
                    <button type="submit" class="btn btn-warning text-white btn-sm w-100 mt-2" style="border-radius: 8px;">Update Password</button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="widget-card h-100">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-store text-success me-2"></i>Konfigurasi Informasi Kafe</h5>
                <hr>
                <form action="<?= base_url('admin/pengaturan/update-settings') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label small">Nama Bisnis / Kafe</label>
                        <input type="text" name="cafe_name" class="form-control" value="FO'Orders Coffee & Eatery" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small">Jam Buka Kafe</label>
                            <input type="time" name="operating_hours_open" class="form-control" value="09:00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Jam Tutup Kafe</label>
                            <input type="time" name="operating_hours_close" class="form-control" value="22:00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Pajak Layanan / PPN (%)</label>
                        <div class="input-group">
                            <input type="number" name="service_tax_percent" class="form-control" value="10" required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small">Kontak & Alamat Kafe</label>
                        <textarea name="contact_info" class="form-control" rows="3" required>Jl. Pendidikan No. 04, Sambas, Kalimantan Barat.</textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm w-100" style="border-radius: 8px;"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan Konfigurasi Toko</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>