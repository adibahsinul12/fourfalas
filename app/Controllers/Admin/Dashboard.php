<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

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

        // 3. Hitung Total Pelanggan (COUNT semua pelanggan unik dari tabel orders/pelanggan)
        // Jika kelompokmu punya tabel khusus 'customers', ganti 'orders' menjadi 'customers'
        $data['total_pelanggan'] = $db->table('orders')->distinct()->select('customer_name')->countAllResults();

        // 4. Hitung Total Menu (COUNT semua menu makanan & minuman yang aktif dari tabel menus)
        $data['total_menu'] = $db->table('menus')->where('is_active', 1)->countAllResults();

        // 5. Ambil 5 data Antrean Pesanan Terbaru untuk dipajang di tabel dashboard
        $data['orders'] = $db->table('orders')
                             ->orderBy('id', 'DESC')
                             ->limit(5)
                             ->get()
                             ->getResultArray();

        // Kirim semua bungkusan data SQL di atas ke dalam halaman dashboard_utama
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

        // 1. Ambil data utama pesanan berdasarkan ID yang diklik
        $data['order'] = $db->table('orders')->where('id', $id)->get()->getRowArray();

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
        $db = \Config\Database::connect();

        // 1. Ambil dulu data pesanan yang mau dibayar, supaya tahu total_payment-nya
        $order = $db->table('orders')->where('id', $id)->get()->getRowArray();

        if (!$order) {
            return redirect()->to(base_url('admin/pesanan'))->with('error', 'Pesanan tidak ditemukan!');
        }

        // 2. Ambil uang yang dibayarkan kasir dari form (kalau form belum ada inputnya, dianggap pas/sesuai tagihan)
        $amountPaid = $this->request->getPost('amount_paid') ?? $order['total_payment'];
        $amountChange = $amountPaid - $order['total_payment'];

        // 3. Update status pesanan jadi Selesai/Lunas, simpan juga uang dibayar & kembalian
        $db->table('orders')->where('id', $id)->update([
            'order_status' => 'Selesai',
            'amount_paid'  => $amountPaid,
            'amount_change' => $amountChange,
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
        $query = $db->table('menus')
                    ->select('menus.*, categories.category_name')
                    ->join('categories', 'categories.id = menus.category_id', 'left')
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

    public function pelanggan()
    {
        return view('admin/pelanggan/index');
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

    public function pengaturan()
    {
        return view('admin/pengaturan/index');
    }

    // ==========================================
    // PROSES CRUD MANAJEMEN MENU KAFE
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

    $db->table('menus')->insert([
        'menu_name'   => $this->request->getPost('menu_name'),
        'category_id' => $this->request->getPost('category_id'),
        'price'       => $this->request->getPost('price'),
        'stock'       => $this->request->getPost('stock'),
        'image_path'  => $namaGambar,
        'is_active'   => 1
    ]);

    return redirect()->to(base_url('admin/menu'))->with('success','Menu berhasil ditambahkan');
}
   public function updateMenu($id)
{
    $db = \Config\Database::connect();

    $data = [
        'menu_name'   => $this->request->getPost('menu_name'),
        'category_id' => $this->request->getPost('category_id'),
        'price'       => $this->request->getPost('price'),
        'stock'       => $this->request->getPost('stock')
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

    return redirect()->to(base_url('admin/menu'))->with('success','Menu berhasil diperbarui');
}

    public function deleteMenu($id)
    {
        $db = \Config\Database::connect();
        $db->table('menus')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/menu'));
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

    public function updateSettings()
    {
        $db = \Config\Database::connect();

        // Memperbarui baris data tabel settings berdasarkan kolom di SQL kamu
        $db->table('settings')->where('id', 1)->update([
            'cafe_name'             => $this->request->getPost('cafe_name'),
            'operating_hours_open'  => $this->request->getPost('operating_hours_open'),
            'operating_hours_close' => $this->request->getPost('operating_hours_close'),
            'service_tax_percent'   => $this->request->getPost('service_tax_percent'),
            'contact_info'          => $this->request->getPost('contact_info'),
        ]);

        return redirect()->to(base_url('admin/pengaturan'))->with('success', 'Konfigurasi kafe berhasil diperbarui!');
    }

    
}