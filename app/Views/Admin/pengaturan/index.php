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
        /* ── RESET & BASE ─────────────────────────── */
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
            z-index: 300;
            transition: transform 0.28s ease;
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

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 299;
        }
        .sidebar-overlay.show { display: block; }

        /* ── MAIN CONTENT ─────────────────────────── */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            transition: margin-left 0.28s ease;
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

        .hamburger-btn {
            display: none;
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            width: 40px; height: 40px;
            border-radius: 10px;
            align-items: center; justify-content: center;
            color: #6B3A1E;
            font-size: 17px;
            cursor: pointer;
            flex-shrink: 0;
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

        /* ── TABLET ───────────────────────────────── */
        @media (max-width: 1024px) and (min-width: 769px) {
            .sidebar { width: 70px; }
            .sidebar-brand span,
            .sidebar-link span,
            .sidebar-logout span { display: none; }
            .sidebar-brand { padding-left: 8px; justify-content: center; }
            .sidebar-link { justify-content: center; padding: 12px; gap: 0; }
            .sidebar-logout { justify-content: center; padding: 12px; gap: 0; }
            .main-content { margin-left: 70px; }
            .search-box { width: 200px; }
        }

        /* ── MOBILE ───────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }

            .main-content { margin-left: 0; padding: 18px 14px 36px; }
            .hamburger-btn { display: flex; }

            .search-box { flex: 1; width: auto; }
            .topbar { margin-bottom: 18px; }

            /* profile: avatar only */
            .profile-card .small { display: none; }
            .profile-card { padding: 4px; border-radius: 50%; }

            /* stack the two setting columns */
            .row.g-4 .col-lg-5,
            .row.g-4 .col-lg-7 { width: 100%; }

            /* jam buka/tutup side by side still */
            .row.g-4 .col-lg-7 .row .col-md-6 { width: 50%; }

            h4 { font-size: 1rem !important; }
        }

        @media (max-width: 480px) {
            /* jam buka/tutup stack on very small */
            .row.g-4 .col-lg-7 .row .col-md-6 { width: 100%; }
        }

        @media (max-width: 420px) {
            .main-content { padding: 12px 10px 32px; }
        }
    </style>
</head>
<body>

<!-- Mobile overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ── SIDEBAR ──────────────────────────────────── -->
<div class="sidebar" id="sidebar">
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
                <a href="<?= base_url('admin/pelanggan') ?>" class="sidebar-link" title="Pelanggan">
                    <i class="fa-solid fa-users"></i> <span>Pelanggan</span>
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
            <button class="hamburger-btn" onclick="toggleSidebar()" aria-label="Buka menu">
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
                    <button type="submit" class="btn btn-warning text-white btn-sm w-100 mt-1 py-2" style="border-radius:8px;">
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
                        <div class="row g-2">
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

                    <!-- Pajak -->
                    <div class="mb-3">
                        <label class="form-label">Pajak Layanan / PPN (%)</label>
                        <div class="input-group" style="max-width:200px;">
                            <input type="number" name="service_tax_percent" class="form-control" value="10" min="0" max="100" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="text-muted" style="font-size:11px;">Nilai ini dipakai otomatis untuk kalkulasi PPN di setiap transaksi.</small>
                    </div>

                    <!-- Kontak & Alamat -->
                    <div class="mb-4">
                        <label class="form-label">Kontak & Alamat Kafe</label>
                        <textarea name="contact_info" class="form-control" rows="3" required>Jl. Pendidikan No. 04, Sambas, Kalimantan Barat.</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm w-100 py-2" style="border-radius:8px;">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Konfigurasi Toko
                    </button>
                </form>
            </div>
        </div>

    </div><!-- /row -->
</div><!-- /main-content -->

<!-- ── SCRIPTS ─────────────────────────────────── -->
<script>
    /* Sidebar toggle */
    function toggleSidebar() {
        const s = document.getElementById('sidebar');
        const o = document.getElementById('sidebarOverlay');
        const open = s.classList.toggle('open');
        o.classList.toggle('show', open);
        document.body.style.overflow = open ? 'hidden' : '';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
        document.body.style.overflow = '';
    }

    /* Show / hide password */
    function togglePw(inputId, btn) {
        const el = document.getElementById(inputId);
        const isText = el.type === 'text';
        el.type = isText ? 'password' : 'text';
        btn.querySelector('i').className = isText ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>