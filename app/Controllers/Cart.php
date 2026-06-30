<?php

namespace App\Controllers;

use App\Models\MenuModel;

class Cart extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    // Menampilkan halaman keranjang belanja
    public function index()
    {
        $data['cart'] = $this->session->get('cart') ?? [];
        
        // Hitung total harga belanjaan sementara
        $data['subtotal'] = 0;
        foreach ($data['cart'] as $item) {
            $data['subtotal'] += $item['price'] * $item['quantity'];
        }

        return view('pelanggan/keranjang', $data);
    }

    // Tombol (+) Tambah kuantitas
    public function add()
    {
        $menuId = $this->request->getPost('menu_id');

        if (!$menuId) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Menu tidak valid']);
            }
            return redirect()->back();
        }

        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] += 1;
        } else {
            $menuModel = new MenuModel();
            $menu = $menuModel->find($menuId);

            if ($menu) {
                $cart[$menuId] = [
                    'id'         => $menu['id'],
                    'menu_name'  => $menu['menu_name'],
                    'price'      => $menu['price'],
                    // BENERIN DI SINI COK: Diarahkan ke image_path bawaan tabel database kamu agar tidak error key "image"
                    'image'      => $menu['image_path'], 
                    'image_path' => $menu['image_path'],
                    'quantity'   => 1
                ];
            }
        }

        $this->session->set('cart', $cart);

        // Hitung ulang jumlah item & total harga keranjang
        $cartCount = 0;
        $cartTotal = 0;
        foreach ($cart as $ci) {
            $cartCount += $ci['quantity'];
            $cartTotal += $ci['price'] * $ci['quantity'];
        }

        // Kalau request datang dari AJAX (fetch), balikin JSON, JANGAN redirect
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success'   => true,
                'cartCount' => $cartCount,
                'cartTotal' => $cartTotal,
            ]);
        }

        // Fallback: kalau bukan AJAX (misal JS browser dimatikan), tetap redirect seperti biasa
        $returnUrl = $this->request->getPost('return_url');
        $target = !empty($returnUrl) ? $returnUrl : base_url('menu');
        return redirect()->to($target)->with('success', 'Menu ditambahkan!');
    }

    // Tombol (-) Kurangi kuantitas
    public function decrease($menuId)
    {
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$menuId])) {
            if ($cart[$menuId]['quantity'] > 1) {
                $cart[$menuId]['quantity'] -= 1;
            } else {
                // Jika sisa 1 lalu dikurangi, otomatis hapus dari keranjang
                unset($cart[$menuId]);
            }
        }

        $this->session->set('cart', $cart);
        return redirect()->to(base_url('cart'));
    }

    // Tombol (Hapus) menghilangkan item dari keranjang
    public function remove($menuId)
    {
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$menuId])) {
            unset($cart[$menuId]);
        }

        $this->session->set('cart', $cart);
        return redirect()->to(base_url('cart'))->with('success', 'Menu dihapus dari keranjang.');
    }

    public function checkout()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        // Kalau keranjang kosong, kembalikan ke halaman keranjang
        if (empty($cart)) {
            return redirect()->to(base_url('cart'))->with('error', 'Keranjang belanja masih kosong!');
        }

        // Hitung subtotal pesanan
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Ambil data meja yang statusnya 'Tersedia' dari database
        $db = \Config\Database::connect();
        $tables = $db->table('tables')->where('status', 'Tersedia')->get()->getResultArray();

        $data = [
            'cart'     => $cart,
            'subtotal' => $subtotal,
            'tables'   => $tables,
            'title'    => 'Checkout - FO\'Orders'
        ];

        // Memanggil file view checkout.php
        return view('pelanggan/checkout', $data); 
    }

    public function process()
    {
        $session = session();
        $cart = $session->get('cart');

        // Proteksi ganda: cegah checkout kalau keranjang kosong
        if (empty($cart)) {
            return redirect()->to(base_url('cart'))->with('error', 'Keranjang kosong!');
        }

        $db = \Config\Database::connect();
        
        // 1. Hitung total harga
        $total_price = 0;
        foreach ($cart as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        // 2. Ambil data inputan dari form checkout
        $customerName = $this->request->getPost('customer_name');
        $tableId      = $this->request->getPost('table_id');
        $notes        = $this->request->getPost('notes');

        // Generate nomor order unik, max 10 karakter (sesuai kolom order_number char(10))
        $orderNumber = 'OR' . strtoupper(substr(uniqid(), -8));

        // Gunakan Transaction agar jika terjadi error di tengah jalan, database dibatalkan (aman)
        $db->transStart();

        // 3. Masukkan data ke tabel `orders` utama (disesuaikan dengan struktur tabel asli)
        $orderData = [
            'order_number'   => $orderNumber,
            'table_id'       => $tableId,
            'customer_name'  => $customerName,
            'notes'          => $notes,
            'order_status'   => 'Menunggu',
            'subtotal'       => $total_price,
            'total_payment'  => $total_price,
        ];
        $db->table('orders')->insert($orderData);
        
        // Dapatkan ID Pesanan yang baru saja dibuat
        $orderId = $db->insertID(); 

        // 4. Masukkan data detail menu ke tabel `order_items` (disesuaikan, ada kolom subtotal wajib diisi)
        $orderItems = [];
        foreach ($cart as $id => $item) {
            $orderItems[] = [
                'order_id'       => $orderId,
                'menu_id'        => $id,
                'quantity'       => $item['quantity'],
                'price_at_order' => $item['price'],
                'subtotal'       => $item['price'] * $item['quantity'],
            ];
        }
        $db->table('order_items')->insertBatch($orderItems);

        // 5. Ubah status meja menjadi 'Terisi'
        $db->table('tables')->where('id', $tableId)->update(['status' => 'Terisi']);

        // Selesaikan transaksi
        $db->transComplete();

        // Cek apakah penyimpanan berhasil
        if ($db->transStatus() === FALSE) {
            $error = $db->error();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan. DEBUG: ' . $error['message'] . ' (code: ' . $error['code'] . ')');
        }

        // 6. Jika sukses, kosongkan keranjang dari session
        $session->remove('cart');

        // 6b. Simpan order ID ke riwayat pesanan pelanggan di session
        $myOrders = $session->get('my_orders') ?? [];
        $myOrders[] = $orderId;
        $session->set('my_orders', $myOrders);

        // 7. BENERIN DI SINI COK: Set flashdata tunggal yang sinkron dan buang redirect bawaan lama (.with)
        $session->setFlashdata('pesan_sukses', 'Yey! Pesanan kamu berhasil dibuat.');
        
        return redirect()->to(base_url('pelanggan'));
    }
}