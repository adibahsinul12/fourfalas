<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MemberModel;
use App\Models\SettingsModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Hitung Total Pendapatan (SUM dari kolom total_payment di tabel orders yang statusnya 'Selesai')
        $pendapatanQuery = $db->table('orders')
                             ->selectSum('total_payment')
                             ->where('order_status', 'Selesai')
                             ->get()
                             ->getRowArray();
        $data['total_pendapatan'] = $pendapatanQuery['total_payment'] ?? 0;

        // 2. Hitung Total Pesanan (COUNT semua baris yang ada di tabel orders)
        $data['total_pesanan'] = $db->table('orders')->countAllResults();

        // 3. Hitung Total Pelanggan (sekarang dari tabel members, bukan orders lagi)
        $data['total_pelanggan'] = $db->table('members')->countAllResults();

        // 4. Hitung Total Menu (COUNT semua menu makanan & minuman yang aktif dari tabel menus)
        $data['total_menu'] = $db->table('menus')->where('is_active', 1)->countAllResults();

       // 5. Ambil 5 data Antrean Pesanan Terbaru
$data['orders'] = $db->table('orders')
    ->orderBy('id', 'DESC')
    ->limit(5)
    ->get()
    ->getResultArray();

$namaBulan = [
    'Jan','Feb','Mar','Apr','Mei','Jun',
    'Jul','Agu','Sep','Okt','Nov','Des'
];

$data['grafik_bulan'] = $namaBulan;
$data['grafik_total'] = array_fill(0, 12, 0);

$grafik = $db->query("
    SELECT MONTH(created_at) AS bulan,
           SUM(total_payment) AS total
    FROM orders
    WHERE order_status='Selesai'
    GROUP BY MONTH(created_at)
")->getResultArray();

foreach ($grafik as $row) {
    $data['grafik_total'][$row['bulan'] - 1] = (int)$row['total'];
}
$data['waiters'] = $db->table('karyawan')
    ->where('bidang', 'Waiters')
    ->where('status', 'Aktif')
    ->countAllResults();

$data['barista'] = $db->table('karyawan')
    ->where('bidang', 'Barista')
    ->where('status', 'Aktif')
    ->countAllResults();

$data['asisten_koki'] = $db->table('karyawan')
    ->where('bidang', 'Asisten Koki')
    ->where('status', 'Aktif')
    ->countAllResults();

$data['koki'] = $db->table('karyawan')
    ->where('bidang', 'Koki')
    ->where('status', 'Aktif')
    ->countAllResults();
return view('admin/dashboard_utama', $data);
    }

    public function pesanan()
    {
        $db = \Config\Database::connect();

        // Tangkap status dari link URL yang diklik
        $statusFilter = $this->request->getGet('status');

        $builder = $db->table('orders')
                      ->select('orders.*, tables.table_number')
                      ->join('tables', 'tables.id = orders.table_id', 'left');

        // Jika status diklik (tidak kosong), filter datanya berdasarkan status tersebut
        if (!empty($statusFilter)) {
            $builder->where('order_status', $statusFilter);
        }

        $data['orders'] = $builder->orderBy('orders.id', 'DESC')->get()->getResultArray();

        return view('admin/pesanan/index', $data);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();

        // 1. Ambil data utama pesanan berdasarkan ID yang diklik (JOIN ke tables biar dapat nomor meja asli)
        $data['order'] = $db->table('orders')
                            ->select('orders.*, tables.table_number')
                            ->join('tables', 'tables.id = orders.table_id', 'left')
                            ->where('orders.id', $id)
                            ->get()
                            ->getRowArray();

        // 2. Ambil semua item makanan/minuman yang dibeli di dalam pesanan tersebut
        $data['order_items'] = $db->table('order_items')
                                  ->select('order_items.*, menus.menu_name')
                                  ->join('menus', 'menus.id = order_items.menu_id')
                                  ->where('order_id', $id)
                                  ->get()
                                  ->getResultArray();

        // Tampilkan halaman detail yang barusan kita buat
        return view('admin/pesanan/detail', $data);
    }

    public function processPayment($id)
    {
        log_message('error', '=== processPayment DIPANGGIL, id=' . $id);
        $db = \Config\Database::connect();

        // 1. Ambil dulu data pesanan yang mau dibayar, supaya tahu total_payment-nya
        $order = $db->table('orders')->where('id', $id)->get()->getRowArray();
        log_message('error', '=== order table_id: ' . json_encode($order['table_id'] ?? 'TIDAK ADA'));

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan'))->with('error', 'Pesanan tidak ditemukan!');
        }

        // 2. Ambil uang yang dibayarkan kasir dari form (kalau form belum ada inputnya, dianggap pas/sesuai tagihan)
        $amountPaid = $this->request->getPost('amount_paid') ?? $order['total_payment'];
        $amountChange = $amountPaid - $order['total_payment'];

        // 2b. Tangkap metode pembayaran dari dropdown kasir (Tunai/QRIS/Debit dll), default 'Tunai' kalau kosong
        $paymentMethod = $this->request->getPost('payment_method') ?? 'Tunai';

        // 3. Update status pesanan jadi Selesai/Lunas, simpan juga uang dibayar, kembalian, dan metode pembayaran
        $db->table('orders')->where('id', $id)->update([
            'order_status'   => 'Selesai',
            'amount_paid'    => $amountPaid,
            'amount_change'  => $amountChange,
            'payment_method' => $paymentMethod,
        ]);

        // 4. Kembalikan status meja jadi "Tersedia" karena pesanan sudah lunas
        if (!empty($order['table_id'])) {
            $db->table('tables')->where('id', $order['table_id'])->update([
                'status' => 'Tersedia',
            ]);
        }

        return redirect()->to(base_url('admin/detail/' . $id))->with('success', 'Pembayaran berhasil dicatat. Pesanan lunas!');
    }

    public function updateStatus($id)
    {
        $db = \Config\Database::connect();

        // Ambil dulu data order-nya (butuh table_id sebelum status diubah)
        $order = $db->table('orders')->where('id', $id)->get()->getRowArray();

        // Update status pesanan dari "Diproses" jadi "Selesai" (misal: masakan selesai disajikan)
        $db->table('orders')->where('id', $id)->update([
            'order_status' => 'Selesai',
        ]);

        // Kembalikan status meja jadi "Tersedia" karena pesanan sudah selesai
        if ($order && !empty($order['table_id'])) {
            $db->table('tables')->where('id', $order['table_id'])->update([
                'status' => 'Tersedia',
            ]);
        }

        return redirect()->to(base_url('admin/detail/' . $id))->with('success', 'Status pesanan diperbarui!');
    }

    public function batalkan($id)
    {
        $db = \Config\Database::connect();

        // Ambil dulu data order-nya (butuh table_id sebelum status diubah)
        $order = $db->table('orders')->where('id', $id)->get()->getRowArray();

        // Update status pesanan jadi Dibatalkan (disamakan penulisannya dengan bagian lain)
        $db->table('orders')->where('id', $id)->update([
            'order_status' => 'Dibatalkan',
        ]);

        // Kembalikan status meja jadi "Tersedia" karena pesanan batal
        if ($order && !empty($order['table_id'])) {
            $db->table('tables')->where('id', $order['table_id'])->update([
                'status' => 'Tersedia',
            ]);
        }

        return redirect()->to(base_url('admin/detail/' . $id))->with('success', 'Pesanan dibatalkan.');
    }

    public function menu()
    {
        $db = \Config\Database::connect();

        // Menggabungkan tabel menus dan categories berdasarkan ID kategorinya
        // Hanya tampilkan menu yang masih aktif (is_active = 1), supaya menu
        // yang sudah "dihapus" (soft delete) tidak muncul lagi di list.
        $query = $db->table('menus')
                    ->select('menus.*, categories.category_name')
                    ->join('categories', 'categories.id = menus.category_id', 'left')
                    ->where('menus.is_active', 1)
                    ->get();

        $data['daftar_menu'] = $query->getResultArray();

        return view('admin/menu/index', $data);
    }

    public function meja()
    {
        // 1. Panggil TableModel yang mengarah ke tabel 'tables'
        $tableModel = new \App\Models\TableModel();

        // 2. Ambil semua data dan urutkan berdasarkan nomor meja terkecil
        $data['meja'] = $tableModel->orderBy('table_number', 'ASC')->findAll();

        // 3. Kirim data ke view index meja
        // (Pastikan 'admin/meja/index' ini sudah sesuai dengan lokasi file index mejamu)
        return view('admin/meja/index', $data);
    }

    // ==========================================
    // PROSES CRUD MEJA KAFE (Disesuaikan dengan TableModel)
    // ==========================================
    public function simpanMeja()
    {
        // 1. Ambil input dari form (misal user ngetik "Meja 02" atau "2")
        $inputMeja = $this->request->getPost('table_number');
        $kapasitas = $this->request->getPost('capacity');

        // 2. Bersihkan input: ambil angka-angkanya saja agar pas dengan tipe INT di database
        $nomorMejaAngka = preg_replace('/[^0-9]/', '', $inputMeja);

        // Jika user cuma ketik huruf tanpa angka, beri default angka 0
        if (empty($nomorMejaAngka)) {
            $nomorMejaAngka = 0;
        }

        // 3. Bungkus data untuk dikirim ke database
        $data = [
            'table_number' => $nomorMejaAngka,     // Sekarang isinya murni angka (cth: 2)
            'capacity'     => $kapasitas,          // Simpan angka kapasitas saja tanpa text tambahan
            'type'         => 'Reguler',
            'status'       => 'Tersedia'           // Disamakan dengan status yang dicek di Cart::checkout()
        ];

        $tableModel = new \App\Models\TableModel();
        $tableModel->insert($data);

        return redirect()->to(base_url('admin/meja'))->with('success', 'Meja baru berhasil ditambahkan!');
    }

    // ==========================================
    // PROSES UPDATE MEJA KAFE
    // ==========================================
    public function updateMeja($id)
    {
        $tableModel = new \App\Models\TableModel();

        $data = [
            'table_number' => $this->request->getPost('table_number'),
            'capacity'     => $this->request->getPost('capacity'),
            'status'       => $this->request->getPost('status')
        ];

        $tableModel->update($id, $data);
        return redirect()->to(base_url('admin/meja'))->with('success', 'Data meja berhasil diperbarui!');
    }

    // ==========================================
    // PROSES HAPUS MEJA KAFE
    // ==========================================
    public function deleteMeja($id)
    {
        $tableModel = new \App\Models\TableModel();
        $tableModel->delete($id);

        return redirect()->to(base_url('admin/meja'))->with('success', 'Meja berhasil dihapus!');
    }

    // ==========================================
    // MANAJEMEN MEMBER / PELANGGAN
    // ==========================================
    public function pelanggan()
    {
        $memberModel = new MemberModel();

        // Ambil semua member, terbaru dulu
        $data['members'] = $memberModel->orderBy('tanggal_gabung', 'DESC')->findAll();

        return view('admin/pelanggan/index', $data);
    }

    public function pelanggan_tambah()
    {
        $memberModel = new MemberModel();

        $nama  = $this->request->getPost('nama');
        $noHp  = $this->request->getPost('no_hp');
        $email = $this->request->getPost('email');

        if (empty($nama) || empty($noHp)) {
            return redirect()->to(base_url('admin/pelanggan'))->with('error', 'Nama dan No HP wajib diisi.');
        }

        if ($memberModel->findByPhone($noHp)) {
            return redirect()->to(base_url('admin/pelanggan'))->with('error', 'No HP sudah terdaftar sebagai member.');
        }

        $memberModel->insert([
            'nama'           => $nama,
            'no_hp'          => $noHp,
            'email'          => $email ?: null,
            'tanggal_gabung' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/pelanggan'))->with('success', 'Member baru berhasil ditambahkan.');
    }

    public function pelanggan_hapus($id)
    {
        $memberModel = new MemberModel();
        $memberModel->delete($id);

        return redirect()->to(base_url('admin/pelanggan'))->with('success', 'Member berhasil dihapus.');
    }

    public function transaksi()
    {
        $db = \Config\Database::connect();

        // Menarik data transaksi/pesanan yang sudah selesai atau lunas dari database
        $data['daftar_transaksi'] = $db->table('orders')
                                       ->where('order_status', 'Selesai')
                                       ->orderBy('id', 'DESC')
                                       ->get()
                                       ->getResultArray();

        // Mengirim data ke halaman riwayat transaksi
        return view('admin/transaksi/index', $data);
    }

    public function laporan()
    {
        $db = \Config\Database::connect();

        // 1. Ambil filter tanggal dari inputan (jika ada)
        $tgl_mulai = $this->request->getGet('tgl_mulai') ?? date('Y-m-01');
        $tgl_selesai = $this->request->getGet('tgl_selesai') ?? date('Y-m-d');

        // 2. Query menghitung ringkasan total omzet kotor (SUM dari total_payment)
        $ringkasan = $db->table('orders')
                        ->selectSum('total_payment', 'omzet')
                        ->where('order_status', 'Selesai')
                        ->where('DATE(created_at) >=', $tgl_mulai)
                        ->where('DATE(created_at) <=', $tgl_selesai)
                        ->get()
                        ->getRowArray();

        $data['total_omzet'] = $ringkasan['omzet'] ?? 0;

        // 3. Menghitung Pajak Resto / PPN 10% langsung lewat matematika PHP (Biar aman dari eror struktur database)
        // Rumus: Total Pajak = Omzet Kotor * 10%
        $data['total_pajak'] = $data['total_omzet'] * 0.1;

        // 4. Hitung jumlah total nota lunas
        $data['total_transaksi'] = $db->table('orders')
                                      ->where('order_status', 'Selesai')
                                      ->where('DATE(created_at) >=', $tgl_mulai)
                                      ->where('DATE(created_at) <=', $tgl_selesai)
                                      ->countAllResults();

        // 5. Ambil data rincian baris transaksi untuk tabel laporan omzet
        $data['laporan_penjualan'] = $db->table('orders')
                                        ->where('order_status', 'Selesai')
                                        ->where('DATE(created_at) >=', $tgl_mulai)
                                        ->where('DATE(created_at) <=', $tgl_selesai)
                                        ->orderBy('id', 'DESC')
                                        ->get()
                                        ->getResultArray();

        // Masukkan data filter tanggal agar tetap nempel di form view
        $data['tgl_mulai'] = $tgl_mulai;
        $data['tgl_selesai'] = $tgl_selesai;

        return view('admin/laporan/index', $data);
    }

    // ==========================================
    // PENGATURAN SISTEM & PROFIL KAFE (DIPERBAIKI)
    // ==========================================

    public function pengaturan()
    {
        // Ambil data settings yang tersimpan di database lewat SettingsModel
        // Kalau baris settings belum pernah dibuat, getSettings() otomatis
        // mengembalikan nilai default sehingga form tidak error/kosong.
        $settingsModel = new SettingsModel();
        $data['settings'] = $settingsModel->getSettings();

        return view('admin/pengaturan/index', $data);
    }

    public function updateSettings()
    {
        // Menggunakan SettingsModel::saveSettings() yang otomatis:
        // - UPDATE baris yang sudah ada, ATAU
        // - INSERT baris baru (id = 1) kalau baris settings belum pernah dibuat
        // Ini memperbaiki bug sebelumnya di mana query "WHERE id = 1" tidak
        // mengubah apa pun kalau baris dengan id=1 belum ada di tabel settings,
        // sehingga notifikasi sukses muncul padahal data tidak benar-benar tersimpan.
        $settingsModel = new SettingsModel();

        $settingsModel->saveSettings([
            'cafe_name'             => $this->request->getPost('cafe_name'),
            'operating_hours_open'  => $this->request->getPost('operating_hours_open'),
            'operating_hours_close' => $this->request->getPost('operating_hours_close'),
            'service_tax_percent'   => $this->request->getPost('service_tax_percent'),
            'contact_info'          => $this->request->getPost('contact_info'),
        ]);

        return redirect()->to(base_url('admin/pengaturan'))->with('success', 'Konfigurasi kafe berhasil diperbarui!');
    }

    // ==========================================
    // PROSES CRUD MANAJEMEN MENU KAFE (DENGAN VARIAN)
    // ==========================================

    public function addMenu()
    {
        $db = \Config\Database::connect();

        $image = $this->request->getFile('image');
        $namaGambar = 'default_menus.jpg';

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $namaGambar = $image->getRandomName();
            $image->move(FCPATH . 'uploads/menus/', $namaGambar);
        }

        // Checkbox HTML hanya terkirim ke $_POST kalau dicentang.
        // Kalau tidak dicentang, field ini tidak ada sama sekali -> defaultkan ke 0.
        $isRecommended = $this->request->getPost('is_recommended') ? 1 : 0;

        // 1. Insert data menu utama ke tabel 'menus' (TANPA price & stock,
        //    karena kolom itu hanya ada di tabel 'menu_variants')
        $db->table('menus')->insert([
            'menu_name'      => $this->request->getPost('menu_name'),
            'category_id'    => $this->request->getPost('category_id'),
            'image_path'     => $namaGambar,
            'is_recommended' => $isRecommended,
            'is_active'      => 1
        ]);

        $menuId = $db->insertID();

        // 2. Insert data varian (nama varian, harga, stok) ke tabel 'menu_variants'
        $variantNames  = $this->request->getPost('variant_name');
        $variantPrices = $this->request->getPost('variant_price');
        $variantStocks = $this->request->getPost('variant_stock');

        if (!empty($variantNames)) {
            foreach ($variantNames as $index => $name) {
                if (!empty($name)) {
                    $db->table('menu_variants')->insert([
                        'menu_id'      => $menuId,
                        'variant_name' => $name,
                        'price'        => $variantPrices[$index] ?? 0,
                        'stock'        => $variantStocks[$index] ?? 0
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/menu'))->with('success', 'Menu berhasil ditambahkan');
    }

    public function updateMenu($id)
    {
        $db = \Config\Database::connect();

        // Checkbox HTML hanya terkirim ke $_POST kalau dicentang.
        // Kalau tidak dicentang, field ini tidak ada sama sekali -> defaultkan ke 0.
        $isRecommended = $this->request->getPost('is_recommended') ? 1 : 0;

        // 1. Update data menu utama (TANPA price & stock)
        $data = [
            'menu_name'      => $this->request->getPost('menu_name'),
            'category_id'    => $this->request->getPost('category_id'),
            'is_recommended' => $isRecommended,
        ];

        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $namaGambar = $image->getRandomName();
            $image->move(FCPATH . 'uploads/menus/', $namaGambar);
            $data['image_path'] = $namaGambar;
        }

        $db->table('menus')
           ->where('id', $id)
           ->update($data);

        // 2. Hapus varian lama, lalu insert ulang varian baru
        $db->table('menu_variants')->where('menu_id', $id)->delete();

        $variantNames  = $this->request->getPost('variant_name');
        $variantPrices = $this->request->getPost('variant_price');
        $variantStocks = $this->request->getPost('variant_stock');

        if (!empty($variantNames)) {
            foreach ($variantNames as $index => $name) {
                if (!empty($name)) {
                    $db->table('menu_variants')->insert([
                        'menu_id'      => $id,
                        'variant_name' => $name,
                        'price'        => $variantPrices[$index] ?? 0,
                        'stock'        => $variantStocks[$index] ?? 0
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/menu'))->with('success', 'Menu berhasil diperbarui');
    }

    public function deleteMenu($id)
    {
        $db = \Config\Database::connect();

        // Nonaktifkan menu (soft delete), BUKAN benar-benar hapus row.
        // Kalau row menu ini dihapus permanen dari tabel 'menus', MySQL akan
        // menolak (foreign key constraint) selama menu_id ini masih dipakai
        // di tabel order_items pada riwayat transaksi lama. Solusinya:
        // tandai saja is_active = 0 supaya menu hilang dari daftar tapi
        // riwayat pesanan lama tetap aman/valid.
        $db->table('menus')
           ->where('id', $id)
           ->update(['is_active' => 0]);

        return redirect()->to(base_url('admin/menu'))->with('success', 'Menu berhasil dinonaktifkan!');
    }

    public function updatePassword()
    {
        $db = \Config\Database::connect();
        $passwordBaru = $this->request->getPost('password_baru');

        // Mengamankan password baru dengan enkripsi hash (Bcrypt) bawaan PHP sebelum masuk SQL
        $passwordHash = password_hash($passwordBaru, PASSWORD_BCRYPT);

        $db->table('admins')->where('username', 'admin')->update([
            'password_hash' => $passwordHash
        ]);

        return redirect()->to(base_url('admin/pengaturan'))->with('success', 'Password berhasil diperbarui!');
    }

    public function grafikRealtime()
    {
        $db = \Config\Database::connect();

        $bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $total = array_fill(0,12,0);

        $query = $db->query("
            SELECT MONTH(created_at) bulan,
                   SUM(total_payment) total
            FROM orders
            WHERE order_status='Selesai'
            GROUP BY MONTH(created_at)
        ")->getResultArray();

        foreach ($query as $row) {
            $total[$row['bulan'] - 1] = (int)$row['total'];
        }

        return $this->response->setJSON([
            'bulan' => $bulan,
            'total' => $total
        ]);
    }
}