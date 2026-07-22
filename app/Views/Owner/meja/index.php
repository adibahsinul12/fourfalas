<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen Meja - FO'orders</title>

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
html{ scrollbar-gutter: stable; }
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
body{ background:var(--cream); display:flex; min-height:100vh; }

/* ===== Sidebar (sama persis dengan dashboard.php) ===== */
.sidebar{
    width:260px;
    background:var(--brown);
    color:#fff;
    display:flex;
    flex-direction:column;
    padding:24px 18px;
    flex-shrink:0;
    position:sticky;
    top:0;
    height:100vh;
    overflow-y:auto;
}
.sidebar .logo{
    display:flex; align-items:center; gap:10px;
    font-size:20px; font-weight:700; margin-bottom:32px; padding-left:6px;
}
.sidebar .logo i{ color:var(--green); font-size:22px; }
.nav-item{
    display:flex; align-items:center; gap:12px;
    padding:11px 14px; border-radius:8px;
    color:#e8ded6; text-decoration:none; font-size:14px;
    margin-bottom:4px; transition:.15s;
}
.nav-item i{ width:18px; text-align:center; }
.nav-item:hover{ background:rgba(255,255,255,.08); }
.nav-item.active{ background:var(--green); color:#fff; font-weight:600; }
.nav-bottom{ margin-top:auto; }

/* ===== Main content ===== */
.main{ flex:1; padding:28px 32px; min-width:0; overflow-x:hidden; }
.topbar{
    display:flex; justify-content:space-between; align-items:center;
    gap:16px; margin-bottom:24px; flex-wrap:wrap;
}
.topbar h2{ font-size:20px; color:#333; }
.topbar .actions{ display:flex; gap:10px; flex-wrap:wrap; }

.btn{
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 18px; border-radius:8px;
    font-size:13px; font-weight:600;
    border:none; cursor:pointer; text-decoration:none;
    transition:.15s;
}
.btn-primary{ background:var(--green); color:#fff; }
.btn-primary:hover{ background:#3e9142; }
.btn-outline{ background:#fff; border:1px solid var(--border); color:var(--brown); }
.btn-outline:hover{ border-color:var(--brown); }
.btn-danger{ background:#fff; border:1px solid #f1b0b0; color:#c0392b; }
.btn-danger:hover{ background:#fdecec; }
.btn-sm{ padding:6px 12px; font-size:12px; }

.flash-msg{
    background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:20px;
}

/* ===== Panel & Tabel ===== */
.panel{
    background:#fff; border-radius:14px; padding:20px;
    box-shadow:0 4px 14px rgba(0,0,0,.03);
}
table{ width:100%; border-collapse:collapse; }
thead th{
    text-align:left; font-size:12px; color:var(--text-muted);
    padding:10px 12px; border-bottom:1px solid var(--border);
}
tbody td{
    padding:12px; font-size:13px; color:#333;
    border-bottom:1px solid var(--border);
}
tbody tr:last-child td{ border-bottom:none; }

.badge{
    display:inline-block; padding:4px 10px; border-radius:20px;
    font-size:11px; font-weight:600;
}
.badge-tersedia{ background:#E8F5E9; color:#2E7D32; }
.badge-terisi{ background:#F5F5F5; color:#777; }

.empty-note{ text-align:center; padding:30px 0; color:#aaa; font-size:13px; }

/* ===== Modal (custom, tanpa Bootstrap JS) ===== */
.modal-backdrop{
    display:none;
    position:fixed; inset:0;
    background:rgba(0,0,0,.45);
    z-index:100;
    align-items:center; justify-content:center;
}
.modal-backdrop.show{ display:flex; }
.modal-box{
    background:#fff; border-radius:14px;
    width:360px; max-width:90vw;
    padding:24px;
}
.modal-box h3{ font-size:16px; color:#333; margin-bottom:18px; }
.form-group{ margin-bottom:14px; }
.form-group label{ display:block; font-size:12px; color:var(--text-muted); margin-bottom:6px; }
.form-group input, .form-group select{
    width:100%; padding:10px 12px; border-radius:8px;
    border:1px solid var(--border); font-size:13px;
    font-family:'Poppins',sans-serif;
}
.modal-footer{ display:flex; justify-content:flex-end; gap:10px; margin-top:18px; }

@media (max-width: 900px){
    .sidebar{
        position:fixed; left:0; top:0; width:240px; height:100vh; z-index:50;
        transform:translateX(-100%); transition:transform .25s ease;
    }
    .sidebar.open{ transform:translateX(0); }
    .main{ padding:20px 18px; width:100%; }
}
@media (max-width: 600px){
    table{ font-size:12px; }
    .topbar{ flex-direction:column; align-items:flex-start; }
}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="logo"><i class="fa-solid fa-mug-saucer"></i> FO'orders</div>

    <a href="<?= base_url('owner') ?>" class="nav-item"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="<?= base_url('owner/menu-approval') ?>" class="nav-item"><i class="fa-solid fa-bowl-food"></i> Persetujuan Menu</a>
    <a href="<?= base_url('owner/karyawan') ?>" class="nav-item"><i class="fa-solid fa-users"></i> Tenaga Kerja</a>
    <a href="<?= base_url('owner/meja') ?>" class="nav-item active"><i class="fa-solid fa-chair"></i> Meja</a>
    <a href="<?= base_url('owner/rating') ?>" class="nav-item"><i class="fa-solid fa-star"></i> Rating & Ulasan</a>
    <a href="<?= base_url('owner/laporan') ?>" class="nav-item"><i class="fa-solid fa-chart-line"></i> Laporan Keuangan</a>
    <a href="<?= base_url('owner/pengaturan') ?>" class="nav-item"><i class="fa-solid fa-gear"></i> Pengaturan</a>

    <div class="nav-bottom">
        <a href="<?= base_url('logout') ?>" class="nav-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <h2>Manajemen Meja</h2>
        <div class="actions">
            <a href="<?= base_url('owner/qrcode') ?>" target="_blank" class="btn btn-outline">
                <i class="fa-solid fa-print"></i> Cetak QR Semua Meja
            </a>
            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                <i class="fa-solid fa-plus"></i> Tambah Meja
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="flash-msg"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <div class="panel">
        <?php if (empty($meja)) : ?>
            <div class="empty-note">Belum ada data meja. Klik "Tambah Meja" untuk menambahkan.</div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>No. Meja</th>
                        <th>Kapasitas</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($meja as $m) : ?>
                        <tr>
                            <td>Meja <?= esc($m['table_number']) ?></td>
                            <td><?= esc($m['capacity']) ?> orang</td>
                            <td><?= esc($m['type']) ?></td>
                            <td>
                                <span class="badge <?= $m['status'] === 'Tersedia' ? 'badge-tersedia' : 'badge-terisi' ?>">
                                    <?= esc($m['status']) ?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <button type="button" class="btn btn-outline btn-sm"
                                    onclick='openEditModal(<?= json_encode($m) ?>)'>
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                                <a href="<?= base_url('owner/meja/hapus/' . $m['id']) ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin hapus meja ini?')">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<!-- Modal Tambah -->
<div class="modal-backdrop" id="modalAdd">
    <div class="modal-box">
        <h3>Tambah Meja Baru</h3>
        <form action="<?= base_url('owner/meja/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>No. Meja</label>
                <input type="text" name="table_number" placeholder="cth: 11" required>
            </div>
            <div class="form-group">
                <label>Kapasitas</label>
                <input type="number" name="capacity" placeholder="cth: 4" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeModals()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit (satu modal dipakai ulang, form action & value diisi via JS) -->
<div class="modal-backdrop" id="modalEdit">
    <div class="modal-box">
        <h3>Edit Meja</h3>
        <form id="formEdit" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>No. Meja</label>
                <input type="text" name="table_number" id="editTableNumber" required>
            </div>
            <div class="form-group">
                <label>Kapasitas</label>
                <input type="number" name="capacity" id="editCapacity" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="editStatus">
                    <option value="Tersedia">Tersedia</option>
                    <option value="Terisi">Terisi</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeModals()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal(){
    document.getElementById('modalAdd').classList.add('show');
}
function openEditModal(meja){
    document.getElementById('formEdit').action = "<?= base_url('owner/meja/update') ?>/" + meja.id;
    document.getElementById('editTableNumber').value = meja.table_number;
    document.getElementById('editCapacity').value = meja.capacity;
    document.getElementById('editStatus').value = meja.status;
    document.getElementById('modalEdit').classList.add('show');
}
function closeModals(){
    document.getElementById('modalAdd').classList.remove('show');
    document.getElementById('modalEdit').classList.remove('show');
}
// Klik di luar box, modal ikut nutup
document.querySelectorAll('.modal-backdrop').forEach(function(bd){
    bd.addEventListener('click', function(e){
        if (e.target === bd) closeModals();
    });
});
</script>

</body>
</html>