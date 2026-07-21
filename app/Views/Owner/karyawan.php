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
html{ scrollbar-gutter: stable; }
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
body{ background:var(--cream); display:flex; min-height:100vh; }

.sidebar{
    width:260px; background:var(--brown); color:#fff;
    display:flex; flex-direction:column; padding:24px 18px; flex-shrink:0;
    position:sticky; top:0; height:100vh; overflow-y:auto;
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

.main{ flex:1; padding:28px 32px; min-width:0; overflow-x:hidden; }

/* ===== Hamburger & overlay (khusus layar kecil) ===== */
.topbar-mobile{ display:none; align-items:center; margin-bottom:14px; }
.hamburger{
    display:none; background:#fff; border:1px solid var(--border);
    width:38px; height:38px; border-radius:8px; align-items:center;
    justify-content:center; font-size:16px; color:var(--brown); cursor:pointer;
}
.sidebar-overlay{
    display:none; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:40;
}
.sidebar-overlay.show{ display:block; }

.page-head{
    display:flex; align-items:flex-start; justify-content:space-between;
    gap:16px; margin-bottom:20px; flex-wrap:wrap;
}
h1{ font-size:20px; color:#333; margin-bottom:4px; }
.subtitle{ font-size:13px; color:var(--text-muted); }

.btn-add{
    background:var(--green); color:#fff; border:none; padding:11px 20px;
    border-radius:10px; font-size:13px; font-weight:600; cursor:pointer;
    display:flex; align-items:center; gap:8px; white-space:nowrap;
    font-family:'Poppins',sans-serif; transition:.15s;
}
.btn-add:hover{ background:#43A047; }

.flash-msg{
    background:#E8F5E9; color:#2E7D32; border:1px solid #C8E6C9;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:18px;
}
.flash-errors{
    background:#FFEBEE; color:#C62828; border:1px solid #FFCDD2;
    padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:18px;
}
.flash-errors ul{ margin:4px 0 0 18px; }

.filters{ display:flex; gap:8px; margin-bottom:18px; flex-wrap:wrap; }
.filter-chip{
    padding:8px 16px; border-radius:20px; font-size:13px; text-decoration:none;
    color:#555; background:#fff; border:1px solid var(--border);
    white-space:nowrap;
}
.filter-chip.active{ background:var(--green); color:#fff; border-color:var(--green); font-weight:600; }

.table-wrap{
    background:#fff; border-radius:14px; padding:8px 20px;
    box-shadow:0 4px 14px rgba(0,0,0,.03);
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}
table{ width:100%; min-width:820px; border-collapse:collapse; font-size:13px; }
th{
    text-align:left; padding:14px 10px; color:var(--text-muted);
    font-weight:600; font-size:11px; text-transform:uppercase;
    border-bottom:1px solid var(--border); white-space:nowrap;
}
td{ padding:14px 10px; border-bottom:1px solid var(--border); color:#333; white-space:nowrap; }
tr:last-child td{ border-bottom:none; }

.badge{
    padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;
}
.badge.aktif{ background:#E8F5E9; color:#2E7D32; }
.badge.nonaktif{ background:#FFEBEE; color:#C62828; }

.action-group{ display:flex; gap:6px; flex-wrap:nowrap; }

.btn-toggle{
    border:none; padding:7px 14px; border-radius:8px; font-size:12px;
    font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif;
}
.btn-toggle.to-nonaktif{ background:#FFEBEE; color:#C62828; }
.btn-toggle.to-aktif{ background:#E8F5E9; color:#2E7D32; }
.btn-toggle.edit-btn{ background:#FFF3E0; color:#E65100; }
.btn-toggle.delete-btn{ background:#FCE4EC; color:#AD1457; }

.empty-note{ text-align:center; color:#aaa; font-size:13px; padding:30px 0; }

.scroll-hint{
    display:none; font-size:11px; color:var(--text-muted); margin-bottom:10px;
    align-items:center; gap:6px;
}

/* ===== TABLET (<=1100px) ===== */
@media (max-width: 1100px){
    .sidebar{ width:220px; }
}

/* ===== TABLET KECIL / HP LANDSCAPE (<=900px) ===== */
@media (max-width: 900px){
    .sidebar{
        position:fixed; left:0; top:0; width:240px; height:100vh; z-index:50;
        transform:translateX(-100%); transition:transform .25s ease;
    }
    .sidebar.open{ transform:translateX(0); }
    .main{ padding:20px 18px; width:100%; }
    .topbar-mobile{ display:flex; }
    .hamburger{ display:flex; }
    .scroll-hint{ display:flex; }
}

/* ===== HP (<=600px) ===== */
@media (max-width: 600px){
    main.main{ padding:16px 14px; }
    h1{ font-size:18px; }
    .table-wrap{ padding:8px 12px; }
    .filter-chip{ padding:7px 12px; font-size:12px; }
    .btn-add{ width:100%; justify-content:center; }
}

/* ===== MODAL KONFIRMASI (nonaktif/aktif/hapus) ===== */
.modal-overlay{
    display:none; position:fixed; inset:0; background:rgba(0,0,0,.45);
    z-index:200; align-items:center; justify-content:center; padding:16px;
}
.modal-overlay.show{ display:flex; }

.modal-box{
    background:#fff; border-radius:16px; width:100%; max-width:360px;
    padding:26px 24px 22px; text-align:center;
    box-shadow:0 10px 40px rgba(0,0,0,.2);
    animation:modalPop .18s ease;
}
@keyframes modalPop{
    from{ transform:scale(.92); opacity:0; }
    to{ transform:scale(1); opacity:1; }
}

.modal-icon{
    width:52px; height:52px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 14px; font-size:22px;
}
.modal-icon.warn{ background:#FFEBEE; color:#C62828; }
.modal-icon.ok{ background:#E8F5E9; color:#2E7D32; }

.modal-title{ font-size:16px; font-weight:600; color:#333; margin-bottom:6px; }
.modal-text{ font-size:13px; color:var(--text-muted); margin-bottom:22px; line-height:1.5; }

.modal-actions{ display:flex; gap:10px; }
.modal-btn{
    flex:1; border:none; padding:11px 0; border-radius:10px;
    font-size:13px; font-weight:600; cursor:pointer; transition:.15s;
    font-family:'Poppins',sans-serif;
}
.modal-btn.cancel{ background:#F2F2F2; color:#555; }
.modal-btn.cancel:hover{ background:#e6e6e6; }
.modal-btn.confirm-danger{ background:#C62828; color:#fff; }
.modal-btn.confirm-danger:hover{ background:#B71C1C; }
.modal-btn.confirm-ok{ background:var(--green); color:#fff; }
.modal-btn.confirm-ok:hover{ background:#43A047; }

/* ===== MODAL FORM (Tambah / Edit) ===== */
.form-modal-overlay{
    display:none; position:fixed; inset:0; background:rgba(0,0,0,.45);
    z-index:200; align-items:center; justify-content:center; padding:16px;
}
.form-modal-overlay.show{ display:flex; }

.form-modal-box{
    background:#fff; border-radius:16px; width:100%; max-width:460px;
    max-height:90vh; overflow-y:auto;
    box-shadow:0 10px 40px rgba(0,0,0,.2);
    animation:modalPop .18s ease;
}
.form-modal-head{
    display:flex; align-items:center; justify-content:space-between;
    padding:20px 24px; border-bottom:1px solid var(--border);
}
.form-modal-head h3{ font-size:16px; color:#333; }
.form-modal-close{
    background:none; border:none; font-size:18px; color:#999; cursor:pointer;
    width:30px; height:30px; border-radius:50%;
}
.form-modal-close:hover{ background:#f2f2f2; color:#333; }

.form-modal-body{ padding:20px 24px; }
.form-group{ margin-bottom:16px; }
.form-group label{
    display:block; font-size:12px; font-weight:600; color:#555; margin-bottom:6px;
}
.form-group input, .form-group select{
    width:100%; padding:10px 12px; border:1px solid var(--border);
    border-radius:8px; font-size:13px; font-family:'Poppins',sans-serif; color:#333;
}
.form-group input:focus, .form-group select:focus{
    outline:none; border-color:var(--green);
}
.form-row{ display:flex; gap:12px; }
.form-row .form-group{ flex:1; }

.form-modal-foot{
    display:flex; gap:10px; padding:16px 24px 22px;
}
.form-modal-foot .modal-btn.save{ background:var(--green); color:#fff; }
.form-modal-foot .modal-btn.save:hover{ background:#43A047; }
</style>
</head>
<body>

<aside class="sidebar">
    <div class="logo"><i class="fa-solid fa-mug-saucer"></i> FO'orders</div>

       <?php $current = uri_string(); ?>

            <a href="<?= base_url('owner') ?>"
            class="nav-item <?= $current === 'owner' ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge"></i> Dashboard
            </a>

            <a href="<?= base_url('owner/menu-approval') ?>"
            class="nav-item <?= str_starts_with($current, 'owner/menu-approval') ? 'active' : '' ?>">
            <i class="fa-solid fa-bowl-food"></i> Persetujuan Menu
            </a>

            <a href="<?= base_url('owner/karyawan') ?>"
            class="nav-item <?= str_starts_with($current, 'owner/karyawan') ? 'active' : '' ?>">
            <i class="fa-solid fa-users"></i> Tenaga Kerja
            </a>

            <a href="<?= base_url('owner/rating') ?>"
            class="nav-item <?= str_starts_with($current, 'owner/rating') ? 'active' : '' ?>">
            <i class="fa-solid fa-star"></i> Rating & Ulasan
            </a>

            <a href="<?= base_url('owner/laporan') ?>"
            class="nav-item <?= str_starts_with($current, 'owner/laporan') ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-line"></i> Laporan Keuangan
            </a>

            <a href="<?= base_url('owner/pengaturan') ?>"
            class="nav-item <?= str_starts_with($current, 'owner/pengaturan') ? 'active' : '' ?>">
            <i class="fa-solid fa-gear"></i> Pengaturan
            </a>

    <div class="nav-bottom">
        <a href="<?= base_url('logout') ?>" class="nav-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<main class="main">
    <div class="topbar-mobile">
        <button type="button" class="hamburger" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
    </div>

    <div class="page-head">
        <div>
            <h1>Tenaga Kerja</h1>
            <div class="subtitle">Pantau &amp; kelola status aktif staf per bidang</div>
        </div>
        <button type="button" class="btn-add" id="btnOpenAdd">
            <i class="fa-solid fa-plus"></i> Tambah Karyawan
        </button>
    </div>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="flash-msg"><?= esc(session()->getFlashdata('msg')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="flash-errors">
            Terjadi kesalahan pada input:
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
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

    <div class="scroll-hint"><i class="fa-solid fa-arrows-left-right"></i> Geser tabel ke samping untuk melihat semua kolom</div>

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
                                <div class="action-group">
                                    <!-- Edit -->
                                    <button type="button" class="btn-toggle edit-btn"
                                            data-id="<?= esc($k['id']) ?>"
                                            data-nama="<?= esc($k['nama']) ?>"
                                            data-bidang="<?= esc($k['bidang']) ?>"
                                            data-no_hp="<?= esc($k['no_hp'] ?? '') ?>"
                                            data-email="<?= esc($k['email'] ?? '') ?>"
                                            data-alamat="<?= esc($k['alamat'] ?? '') ?>"
                                            data-tanggal_masuk="<?= esc($k['tanggal_masuk']) ?>"
                                            data-gaji="<?= esc($k['gaji']) ?>">
                                        Edit
                                    </button>

                                    <!-- Toggle status -->
                                    <form action="<?= base_url('owner/karyawan/update-status/' . $k['id']) ?>" method="post" class="js-toggle-form">
                                        <input type="hidden" name="bidang" value="<?= esc($bidang_aktif ?? '') ?>">
                                        <?php if (strtolower($k['status']) === 'aktif') : ?>
                                            <button type="button" class="btn-toggle to-nonaktif" data-nama="<?= esc($k['nama']) ?>" data-mode="nonaktif">Nonaktifkan</button>
                                        <?php else : ?>
                                            <button type="button" class="btn-toggle to-aktif" data-nama="<?= esc($k['nama']) ?>" data-mode="aktif">Aktifkan</button>
                                        <?php endif; ?>
                                    </form>

                                    <!-- Hapus -->
                                    <form action="<?= base_url('owner/karyawan/delete/' . $k['id']) ?>" method="post" class="js-delete-form">
                                        <input type="hidden" name="bidang" value="<?= esc($bidang_aktif ?? '') ?>">
                                        <button type="button" class="btn-toggle delete-btn" data-nama="<?= esc($k['nama']) ?>" data-mode="hapus">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Modal Konfirmasi (nonaktif / aktif / hapus) -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <div class="modal-icon" id="confirmIcon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div class="modal-title" id="confirmTitle">Konfirmasi</div>
        <div class="modal-text" id="confirmText">Apakah kamu yakin?</div>
        <div class="modal-actions">
            <button type="button" class="modal-btn cancel" id="confirmCancelBtn">Batal</button>
            <button type="button" class="modal-btn confirm-danger" id="confirmOkBtn">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<!-- Modal Form Tambah / Edit -->
<div class="form-modal-overlay" id="formModal">
    <div class="form-modal-box">
        <div class="form-modal-head">
            <h3 id="formModalTitle">Tambah Karyawan</h3>
            <button type="button" class="form-modal-close" id="formModalClose"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="karyawanForm" method="post" action="<?= base_url('owner/karyawan/store') ?>">
            <div class="form-modal-body">
                <input type="hidden" name="bidang_filter" value="<?= esc($bidang_aktif ?? '') ?>">

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" id="f_nama" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Bidang</label>
                        <select name="bidang" id="f_bidang" required>
                            <?php foreach ($bidang_list as $b) : ?>
                                <option value="<?= esc($b) ?>"><?= esc($b) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" id="f_no_hp" placeholder="0812xxxxxxx">
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="f_email" placeholder="opsional">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="f_alamat" placeholder="opsional">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" id="f_tanggal_masuk" required>
                    </div>
                    <div class="form-group">
                        <label>Gaji (Rp)</label>
                        <input type="number" name="gaji" id="f_gaji" min="0" step="1000" required>
                    </div>
                </div>
            </div>

            <div class="form-modal-foot">
                <button type="button" class="modal-btn cancel" id="formModalCancel">Batal</button>
                <button type="submit" class="modal-btn save" id="formModalSubmit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSidebar(){
    document.querySelector('.sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}

/* ===== Modal Konfirmasi: nonaktif / aktif / hapus ===== */
(function(){
    const overlay   = document.getElementById('confirmModal');
    const iconBox   = document.getElementById('confirmIcon');
    const titleEl   = document.getElementById('confirmTitle');
    const textEl    = document.getElementById('confirmText');
    const okBtn     = document.getElementById('confirmOkBtn');
    const cancelBtn = document.getElementById('confirmCancelBtn');

    let pendingForm = null;

    function openModal(form, mode, nama){
        pendingForm = form;

        if (mode === 'nonaktif') {
            iconBox.className = 'modal-icon warn';
            iconBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>';
            titleEl.textContent = 'Nonaktifkan Staf';
            textEl.textContent  = 'Nonaktifkan ' + nama + '? Staf ini tidak akan bisa mengakses sistem.';
            okBtn.className = 'modal-btn confirm-danger';
            okBtn.textContent = 'Ya, Nonaktifkan';
        } else if (mode === 'aktif') {
            iconBox.className = 'modal-icon ok';
            iconBox.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
            titleEl.textContent = 'Aktifkan Staf';
            textEl.textContent  = 'Aktifkan kembali ' + nama + '?';
            okBtn.className = 'modal-btn confirm-ok';
            okBtn.textContent = 'Ya, Aktifkan';
        } else if (mode === 'hapus') {
            iconBox.className = 'modal-icon warn';
            iconBox.innerHTML = '<i class="fa-solid fa-trash"></i>';
            titleEl.textContent = 'Hapus Karyawan';
            textEl.textContent  = 'Hapus data ' + nama + ' secara permanen? Tindakan ini tidak bisa dibatalkan.';
            okBtn.className = 'modal-btn confirm-danger';
            okBtn.textContent = 'Ya, Hapus';
        }

        overlay.classList.add('show');
    }

    function closeModal(){
        overlay.classList.remove('show');
        pendingForm = null;
    }

    document.querySelectorAll('.js-toggle-form .btn-toggle, .js-delete-form .btn-toggle').forEach(function(btn){
        btn.addEventListener('click', function(){
            const form = btn.closest('form');
            openModal(form, btn.dataset.mode, btn.dataset.nama);
        });
    });

    okBtn.addEventListener('click', function(){
        if (pendingForm) pendingForm.submit();
        closeModal();
    });

    cancelBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function(e){ if (e.target === overlay) closeModal(); });
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeModal(); });
})();

/* ===== Modal Form: Tambah / Edit ===== */
(function(){
    const overlay   = document.getElementById('formModal');
    const titleEl   = document.getElementById('formModalTitle');
    const form      = document.getElementById('karyawanForm');
    const submitBtn = document.getElementById('formModalSubmit');

    const baseUrl   = "<?= base_url('owner/karyawan') ?>";

    const fNama          = document.getElementById('f_nama');
    const fBidang         = document.getElementById('f_bidang');
    const fNoHp           = document.getElementById('f_no_hp');
    const fEmail          = document.getElementById('f_email');
    const fAlamat         = document.getElementById('f_alamat');
    const fTanggalMasuk   = document.getElementById('f_tanggal_masuk');
    const fGaji           = document.getElementById('f_gaji');

    function openAdd(){
        titleEl.textContent = 'Tambah Karyawan';
        submitBtn.textContent = 'Simpan';
        form.action = baseUrl + '/store';
        form.reset();
        overlay.classList.add('show');
    }

    function openEdit(btn){
        titleEl.textContent = 'Edit Karyawan';
        submitBtn.textContent = 'Perbarui';
        form.action = baseUrl + '/update/' + btn.dataset.id;

        fNama.value        = btn.dataset.nama || '';
        fBidang.value        = btn.dataset.bidang || '';
        fNoHp.value           = btn.dataset.no_hp || '';
        fEmail.value          = btn.dataset.email || '';
        fAlamat.value         = btn.dataset.alamat || '';
        fTanggalMasuk.value   = btn.dataset.tanggal_masuk || '';
        fGaji.value           = btn.dataset.gaji || '';

        overlay.classList.add('show');
    }

    function closeModal(){
        overlay.classList.remove('show');
    }

    document.getElementById('btnOpenAdd').addEventListener('click', openAdd);
    document.querySelectorAll('.edit-btn').forEach(function(btn){
        btn.addEventListener('click', function(){ openEdit(btn); });
    });

    document.getElementById('formModalClose').addEventListener('click', closeModal);
    document.getElementById('formModalCancel').addEventListener('click', closeModal);
    overlay.addEventListener('click', function(e){ if (e.target === overlay) closeModal(); });
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && overlay.classList.contains('show')) closeModal(); });
})();
</script>

</body>
</html>