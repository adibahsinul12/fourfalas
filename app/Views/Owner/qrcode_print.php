<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak QR Code - FO'Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #FAF6EB;
            margin: 0;
            padding: 24px;
        }
        .toolbar {
            margin-bottom: 24px;
        }
        .toolbar button {
            background-color: #6B3A1E;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
        }
        .qr-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .qr-card {
            background: #fff;
            border: 1px solid #F0EAE2;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            width: 220px;
            box-sizing: border-box;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .qr-card img {
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 12px;
        }
        .qr-card h3 {
            margin: 0;
            font-size: 15px;
            color: #6B3A1E;
        }
        .qr-card p {
            margin: 4px 0 0;
            font-size: 11px;
            color: #999;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none; }
            .qr-card { box-shadow: none; border: 1px solid #ccc; }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <button onclick="window.print()">🖨️ Print Semua QR</button>
    </div>

    <div class="qr-grid">
        <div class="qr-card">
            <img src="<?= $qrUmum; ?>" alt="QR Umum">
            <h3>QR Umum</h3>
            <p>Masuk halaman pelanggan (tanpa meja)</p>
        </div>

        <?php foreach ($qrMeja as $nomor => $qr): ?>
            <div class="qr-card">
                <img src="<?= $qr; ?>" alt="QR Meja <?= $nomor; ?>">
                <h3>Meja <?= $nomor; ?></h3>
                <p>Tempel di meja nomor <?= $nomor; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>