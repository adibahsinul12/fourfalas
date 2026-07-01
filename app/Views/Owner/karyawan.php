<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tenaga Kerja - FO'orders</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root{
    --brown:#6B3A1E;
    --green:#4CAF50;
    --cream:#FAF6EB;
    --border:#E5E5E5;
    --text-muted:#8a8a8a;
}
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
body{ background:var(--cream); display:flex; min-height:100vh; }

.sidebar{
    width:260px; background:var(--brown); color:#fff;
    display:flex; flex-direction:column; padding:24px 18px; flex-shrink:0;
}
.sidebar .logo{
    display:flex; align-items:center; gap:10px;
    font-size:20px; font-weight:700; margin-bottom:32px; padding-left:6px;
}
.sidebar .logo i{ color:var(--green); font-size:22px; }
.nav-item{
    display:flex; align-items:center; gap:12px; padding:11px 14px;
    border-radius:8px; color:#e8ded6; text-decoration:none; font-size:14px;
    margin-bottom:4px; transition:.15s;
}
.nav-item i{ width:18px; text-align:center; }
.nav-item:hover{ background:rgba(255,255,255,.08); }
.nav-item.active{ background:var(--green); color:#fff; font-weight:600; }
.nav-bottom{ margin-top:auto; }

.main{ flex:1; padding:28px 32px; }

h1{ font-size:20px; color:#333; margin-bottom:4px; }
.subtitle{ font-size:13px; color:var(--text-muted); margin-bottom:20px; }

.flash-msg{
    background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:18px;
}

.filters{ display:flex; gap:8px; margin-bottom:18px; flex-wrap:wrap; }
.filter-chip{
    padding:8px 16px; border-radius:20px; font-size:13px; text-decoration:none;
    color:#555; background:#fff; border:1px solid var(--border);
}
.filter-chip.active{ background:var(--green); color:#fff; border-color:var(--green); font-weight:600; }

.table-wrap{
    background:#fff; border-radius:14px; padding:8px 20px;
    box-shadow:0 4px 14px rgba(0,0,0,.03); overflow-x:auto;
}
table{ width:100%; border-collapse:collapse; font-size:13px; }
th{
    text-align:left; padding:14px 10px; color:var(--text-muted);
    font-weight:600; font-size:11px; text-transform:uppercase;
    border-bottom:1px solid var(--border);
}
td{ padding:14px 10px; border-bottom:1px solid var(--border); color:#333; }
tr:last-child td{ border-bottom:none; }

.badge{
    padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;
}
.badge.aktif{ background:#E8F5E9; color:#2E7D32; }
.badge.nonaktif{ background:#FFEBEE; color:#C62828; }

.btn-toggle{
    border:none; padding:7px 14px; border-radius:8px; font-size:12px;
    font-weight:600; cursor:pointer;
}
.btn-toggle.to-nonaktif{ background:#FFEBEE; color:#C62828; }
.btn-toggle.to-aktif{ background:#E8F5E9; color:#2E7D32; }

.empty-note{ text-align:center; color:#aaa; font-size:13px; padding:30px 0; }
</style>
</head>
<body>

<aside class="sidebar">
    <div class="logo"><i class="fa-solid fa-mug-saucer"></i> FO'orders</div>

    <a href="<?= base_url('owner') ?>" class="nav-item"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="<?= base_url('owner/karyawan') ?>" class="nav-item active"><i class="fa-solid fa-users"></i> Tenaga Kerja</a>
    <a href="#" class="nav-item"><i class="fa-solid fa-star"></i> Rating &amp; Ulasan</a>
    <a href="#" class="nav-item"><i class="fa-solid fa-chart-line"></i> Laporan Keuangan</a>
    <a href="#" class="nav-item"><i class="fa-solid fa-gear"></i> Pengaturan</a>

    <div class="nav-bottom">
        <a href="<?= base_url('logout') ?>" class="nav-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<main class="main">
    <h1>Tenaga Kerja</h1>
    <div class="subtitle">Pantau &amp; kelola status aktif staf per bidang</div>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="flash-msg"><?= esc(session()->getFlashdata('msg')) ?></div>
    <?php endif; ?>

    <div class="filters">
        <a href="<?= base_url('owner/karyawan') ?>" class="filter-chip <?= empty($bidang_aktif) ? 'active' : '' ?>">Semua</a>
        <?php foreach ($bidang_list as $b) : ?>
            <a href="<?= base_url('owner/karyawan?bidang=' . urlencode($b)) ?>"
               class="filter-chip <?= $bidang_aktif === $b ? 'active' : '' ?>">
                <?= esc($b) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="table-wrap">
        <?php if (empty($karyawan)) : ?>
            <div class="empty-note">Belum ada data karyawan untuk bidang ini.</div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Bidang</th>
                        <th>No. HP</th>
                        <th>Tanggal Masuk</th>
                        <th>Gaji</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($karyawan as $k) : ?>
                        <tr>
                            <td><?= esc($k['nama']) ?></td>
                            <td><?= esc($k['bidang']) ?></td>
                            <td><?= esc($k['no_hp'] ?? '-') ?></td>
                            <td><?= esc(date('d M Y', strtotime($k['tanggal_masuk']))) ?></td>
                            <td>Rp <?= number_format((float) $k['gaji'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge <?= strtolower($k['status']) === 'aktif' ? 'aktif' : 'nonaktif' ?>">
                                    <?= esc($k['status']) ?>
                                </span>
                            </td>
                            <td>
                                <form action="<?= base_url('owner/karyawan/update-status/' . $k['id']) ?>" method="post">
                                    <input type="hidden" name="bidang" value="<?= esc($bidang_aktif ?? '') ?>">
                                    <?php if (strtolower($k['status']) === 'aktif') : ?>
                                        <button type="submit" class="btn-toggle to-nonaktif"
                                                onclick="return confirm('Nonaktifkan <?= esc($k['nama']) ?>?')">
                                            Nonaktifkan
                                        </button>
                                    <?php else : ?>
                                        <button type="submit" class="btn-toggle to-aktif"
                                                onclick="return confirm('Aktifkan kembali <?= esc($k['nama']) ?>?')">
                                            Aktifkan
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

</body>
</html>