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
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F7F3EE;
            color: #333333;
            margin: 0; padding: 0;
            overflow-x: hidden;
        }

        /* ── SIDEBAR ──────────────────────────────── */
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

        /* Close button — hidden on desktop */
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

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-overlay.show { display: block; }

        /* ── MAIN CONTENT ─────────────────────────── */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* ── TOPBAR ───────────────────────────────── */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 12px;
            flex-wrap: wrap;
        }
        .topbar-left { display: flex; align-items: center; gap: 10px; flex: 1; min-width: 0; }

        /* Hamburger — hidden on desktop */
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

        .search-box { position: relative; width: 300px; max-width: 100%; }
        .search-box input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border-radius: 12px;
            border: 1px solid #E5E5E5;
            background-color: #FFFFFF;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-box input:focus { border-color: #6B3A1E; }
        .search-box i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #888888; font-size: 13px; }

        .admin-profile { display: flex; align-items: center; gap: 16px; flex-shrink: 0; }
        .notif-btn {
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #6B3A1E;
        }
        .profile-card {
            background: #FFFFFF;
            padding: 6px 16px 6px 6px;
            border-radius: 30px;
            border: 1px solid #E5E5E5;
            display: flex; align-items: center; gap: 10px;
        }
        .profile-avatar {
            width: 32px; height: 32px;
            background-color: #F7F3EE;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #6B3A1E;
        }

        /* ── WIDGET CARD ──────────────────────────── */
        .widget-card {
            background-color: #FFFFFF;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(229,229,229,0.5);
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        /* ── FORM STYLES ──────────────────────────── */
        .form-control, .form-select {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            border-radius: 8px;
            border: 1px solid #E5E5E5;
            transition: border-color 0.2s;
        }
        .form-control:focus { border-color: #6B3A1E; box-shadow: 0 0 0 3px rgba(107,58,30,0.08); }
        .form-label { font-size: 12px; font-weight: 600; }
        .btn { font-family: 'Poppins', sans-serif; font-size: 13px; }
        .section-divider { border-top: 1px solid #F0EBE5; margin: 20px 0; }

        /* Password toggle */
        .pw-wrap { position: relative; }
        .pw-wrap .form-control { padding-right: 42px; }
        .pw-toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #888; cursor: pointer;
            font-size: 14px; padding: 0;
        }
        .pw-toggle:hover { color: #6B3A1E; }

        /* Alert */
        .alert { border-radius: 10px; font-size: 13px; }

        /* ── TABLET + MOBILE: off-canvas sidebar ─── */
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

        /* ── TABLET (768px–991px): dua kolom tetap sejajar tapi lebih rapat ─ */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .widget-card { padding: 20px; }
            .search-box { width: 220px; }
        }

        @media (max-width: 767.98px) {
            .main-content { padding: 16px; }
            .topbar { margin-bottom: 20px; }
            .search-box { flex: 1; width: auto; }
            .admin-profile { gap: 10px; }
            .profile-card .small { display: none; }
            .profile-card { padding: 4px; border-radius: 50%; }

            /* Stack the two setting columns */
            .row.g-4 .col-lg-5,
            .row.g-4 .col-lg-7 { width: 100%; }

            h4 { font-size: 1rem !important; }

            .widget-card { padding: 18px; }
            h5 { font-size: 14px !important; }

            /* Jam operasional: kecilkan label di input-group biar gak kepepet */
            .input-group-text { padding: 8px 8px; font-size: 11px !important; }
            .input-group .form-control[type="time"] { font-size: 12px; padding-left: 8px; padding-right: 8px; }
        }

        @media (max-width: 479.98px) {
            .main-content { padding: 12px; }
            .widget-card { padding: 16px; }

            /* Di HP kecil, tumpuk Buka/Tutup vertikal biar gak sesak */
            .jam-operasional .col-6 { width: 100%; flex: 0 0 100%; max-width: 100%; }
            .jam-operasional .col-6:first-child { margin-bottom: 8px; }

            .btn { font-size: 12px; }
            .notif-btn, .menu-toggle-btn { width: 36px; height: 36px; }
        }

        @media (max-width: 359.98px) {
            .search-box input { font-size: 12px; padding-left: 36px; }
            .profile-avatar { width: 28px; height: 28px; }
        }


        /* Warna tombol Update Password (Coklat Kopi Resmi) */
        .btn-update-password {
            background-color: #6B3A1E !important; /* Coklat Kopi Utama FO'Orders */
            color: #FFFFFF !important;
            border: none !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-update-password:hover {
            background-color: #552e18 !important; /* Warna coklat agak gelap saat didekati mouse */
        }

        /* Warna tombol Update Password & Simpan Konfigurasi (Coklat Kopi Resmi) */
        .btn-update-password, .btn-simpan-toko {
            background-color: #6B3A1E !important; /* Coklat Kopi Utama FO'Orders */
            color: #FFFFFF !important;
            border: none !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-update-password:hover, .btn-simpan-toko:hover {
            background-color: #552e18 !important; /* Warna coklat agak gelap saat di-hover */
        }
    </style>
</head>
<body>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ── SIDEBAR ──────────────────────────────────── -->
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
                <a href="<?= base_url('admin/laporan') ?>" class="sidebar-link" title="Laporan">
                    <i class="fa-solid fa-chart-line"></i> <span>Laporan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('admin/pengaturan') ?>" class="sidebar-link active" title="Pengaturan">
                    <i class="fa-solid fa-gear"></i> <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>
    <a href="<?= base_url('logout') ?>" class="sidebar-logout" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
    </a>
</div>

<!-- ── MAIN CONTENT ─────────────────────────────── -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle-btn" id="menuToggleBtn" aria-label="Buka menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Cari sesuatu...">
            </div>
        </div>
        <div class="admin-profile">
            <div class="notif-btn"><i class="fa-solid fa-bell"></i></div>
            <div class="profile-card">
                <div class="profile-avatar"><i class="fa-solid fa-user-tie"></i></div>
                <div class="small">
                    <div class="fw-bold" style="font-size:12px;">Admin</div>
                    <span class="text-muted" style="font-size:10px;">Administrator</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">⚙️ Pengaturan Sistem & Profil Kafe</h4>
    </div>

    <!-- Flash message -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Content Grid -->
    <div class="row g-4">

        <!-- ── KOLOM KIRI: Profil & Password ──── -->
        <div class="col-lg-5 col-12">
            <div class="widget-card h-100">

                <!-- Profil Akun -->
                <h5 class="fw-bold mb-1">
                    <i class="fa-solid fa-user-gear text-success me-2"></i>Profil Akun Admin
                </h5>
                <div class="section-divider"></div>

                <div class="mb-3">
                    <label class="form-label text-muted">USERNAME</label>
                    <input type="text" class="form-control bg-light" value="admin" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">LEVEL AKSES</label>
                    <input type="text" class="form-control bg-light" value="Super Administrator Utama" readonly>
                </div>

                <!-- Ganti Password -->
                <h5 class="fw-bold mb-1 mt-4">
                    <i class="fa-solid fa-key text-warning me-2"></i>Ganti Password Keamanan
                </h5>
                <div class="section-divider"></div>

                <form action="<?= base_url('admin/pengaturan/update-password') ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <div class="pw-wrap">
                            <input type="password" name="password_lama" class="form-control" placeholder="••••••••" required id="pwLama">
                            <button type="button" class="pw-toggle" onclick="togglePw('pwLama', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <div class="pw-wrap">
                            <input type="password" name="password_baru" class="form-control" placeholder="Masukkan password baru" required id="pwBaru">
                            <button type="button" class="pw-toggle" onclick="togglePw('pwBaru', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning text-white btn-sm w-100 mt-1 py-2 btn-update-password" style="border-radius:8px;">
                        <i class="fa-solid fa-lock me-2"></i>Update Password
                    </button>
                </form>
            </div>
        </div>

        <!-- ── KOLOM KANAN: Konfigurasi Kafe ─── -->
        <div class="col-lg-7 col-12">
            <div class="widget-card h-100">
                <h5 class="fw-bold mb-1">
                    <i class="fa-solid fa-store text-success me-2"></i>Konfigurasi Informasi Kafe
                </h5>
                <div class="section-divider"></div>

                <form action="<?= base_url('admin/pengaturan/update-settings') ?>" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nama Bisnis / Kafe</label>
                        <input type="text" name="cafe_name" class="form-control" value="FO'Orders Coffee & Eatery" required>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="mb-3">
                        <label class="form-label">Jam Operasional</label>
                        <div class="row g-2 jam-operasional">
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text" style="font-size:12px;">Buka</span>
                                    <input type="time" name="operating_hours_open" class="form-control" value="09:00" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <span class="input-group-text" style="font-size:12px;">Tutup</span>
                                    <input type="time" name="operating_hours_close" class="form-control" value="22:00" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak & Alamat -->
                    <div class="mb-4">
                        <label class="form-label">Kontak & Alamat Kafe</label>
                        <textarea name="contact_info" class="form-control" rows="3" required>Jl. Pendidikan No. 04, Sambas, Kalimantan Barat.</textarea>
                    </div>

                    <button type="submit" class="btn btn-sm w-100 py-2 btn-simpan-toko" style="border-radius:8px;">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Konfigurasi Toko
                    </button>
                </form>
            </div>
        </div>

    </div><!-- /row -->
</div><!-- /main-content -->

<!-- ── SCRIPTS ─────────────────────────────────── -->
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

    /* Show / hide password */
    function togglePw(inputId, btn) {
        const el = document.getElementById(inputId);
        const isText = el.type === 'text';
        el.type = isText ? 'password' : 'text';
        btn.querySelector('i').className = isText ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
    }
</script>
</body>
</html>