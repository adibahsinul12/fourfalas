<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - FO'Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; min-height: 100vh; }
        .sidebar { background: #212529; min-height: 100vh; color: #fff; }
        .sidebar .nav-link { color: rgba(255,255,255,.75); padding: 12px 15px; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.1); }
        .sidebar .nav-link.active { color: #fff; background: #0d6efd; }
        .navbar { background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,.08); }
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
            <div class="d-flex align-items-center mb-4 px-2">
                <i class="fa-solid fa-box-open fa-lg me-2 text-primary"></i>
                <h5 class="m-0 fw-bold">FO'Orders</h5>
            </div>
            <hr>
            <ul class="nav flex-column gap-1">
                <li class="nav-item">
                    <a class="nav-link active rounded" href="#">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded" href="#">
                        <i class="fa-solid fa-cart-shopping me-2"></i> Pesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded" href="#">
                        <i class="fa-solid fa-boxes-stacked me-2"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded" href="#">
                        <i class="fa-solid fa-users me-2"></i> Pelanggan
                    </a>
                </li>
            </ul>
            <hr class="mt-5">
            <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100 mt-2">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
            </a>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            <nav class="navbar navbar-expand-lg px-4 py-3 mb-4">
                <div class="container-fluid justify-content-between">
                    <span class="navbar-brand mb-0 h1 fs-5 fw-bold text-secondary">Sistem Manajemen Kelola</span>
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-user-gear me-2 text-primary"></i>
                        <span class="fw-semibold text-capitalize text-dark"><?= session()->get('username') ?></span>
                    </div>
                </div>
            </nav>

            <div class="px-4">
                <div class="p-5 mb-4 bg-white rounded-3 border card-custom">
                    <div class="container-fluid py-2">
                        <h1 class="display-6 fw-bold text-dark">Selamat Datang, Admin!</h1>
                        <p class="col-md-8 fs-6 text-muted">Ini adalah halaman utama dashboard FO'Orders kamu. Sistem otentikasi berbasis session telah berhasil memproteksi halaman ini dengan aman.</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card p-4 border-0 shadow-sm bg-primary text-white card-custom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-white-50">Total Pesanan</h6>
                                    <h3 class="mb-0 fw-bold">0</h3>
                                </div>
                                <i class="fa-solid fa-bag-shopping fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>