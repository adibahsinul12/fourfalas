<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Karyawan - Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Kelola Tenaga Kerja</h3>
        <a href="/owner/karyawan/create" class="btn btn-primary">+ Tambah Karyawan</a>
    </div>

    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Bidang</th>
                <th>No. HP</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($karyawan as $k): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($k['nama']) ?></td>
                <td><span class="badge bg-info text-dark"><?= esc($k['bidang']) ?></span></td>
                <td><?= esc($k['no_hp']) ?></td>
                <td>
                    <?php if ($k['status'] === 'Aktif'): ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Nonaktif</span>
                    <?php endif; ?>
                </td>
                <td><?= esc($k['tanggal_masuk']) ?></td>
                <td>
                    <a href="/owner/karyawan/edit/<?= $k['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/owner/karyawan/delete/<?= $k['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus karyawan ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>

            <?php if (empty($karyawan)): ?>
            <tr>
                <td colspan="7" class="text-center">Belum ada data karyawan.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="/owner" class="btn btn-outline-secondary">← Kembali ke Dashboard</a>

</div>
</body>
</html>