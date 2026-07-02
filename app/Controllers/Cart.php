<?php

namespace App\Controllers;

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

    // Tombol (+) Tambah kuantitas — sekarang berbasis variant_id
    public function add()
    {
        $variantId = $this->request->getPost('variant_id');

        if (!$variantId) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Varian tidak valid']);
            }
            return redirect()->back();
        }

        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += 1;
        } else {
            $db = \Config\Database::connect();

            // Ambil data varian + info menu induknya (nama, gambar)
            $variant = $db->table('menu_variants')
                ->select('menu_variants.*, menus.menu_name, menus.image_path')
                ->join('menus', 'menus.id = menu_variants.menu_id')
                ->where('menu_variants.id', $variantId)
                ->get()
                ->getRowArray();

            if ($variant) {
                $cart[$variantId] = [
                    'id'           => $variant['id'],           // id varian (dipakai sebagai key keranjang)
                    'menu_id'      => $variant['menu_id'],
                    'menu_name'    => $variant['menu_name'],
                    'variant_name' => $variant['variant_name'],
                    'price'        => $variant['price'],
                    'image'        => $variant['image_path'],
                    'image_path'   => $variant['image_path'],
                    'quantity'     => 1
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

        // Total qty semua varian milik menu yang sama (dipakai untuk badge di kartu menu)
        $menuId = $cart[$variantId]['menu_id'] ?? null;
        $menuQty = 0;
        if ($menuId) {
            foreach ($cart as $ci) {
                if ($ci['menu_id'] == $menuId) {
                    $menuQty += $ci['quantity'];
                }
            }
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success'   => true,
                'cartCount' => $cartCount,
                'cartTotal' => $cartTotal,
                'itemQty'   => $cart[$variantId]['quantity'] ?? 0,
                'menuQty'   => $menuQty,
                'menuId'    => $menuId,
            ]);
        }

        $returnUrl = $this->request->getPost('return_url');
        $target = !empty($returnUrl) ? $returnUrl : base_url('menu');
        return redirect()->to($target)->with('success', 'Menu ditambahkan!');
    }

    // Tombol (-) Kurangi kuantitas biasa (menggunakan redirect ke halaman cart) — berbasis variant_id
    public function decrease($variantId)
    {
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$variantId])) {
            if ($cart[$variantId]['quantity'] > 1) {
                $cart[$variantId]['quantity'] -= 1;
            } else {
                unset($cart[$variantId]);
            }
        }

        $this->session->set('cart', $cart);
        return redirect()->to(base_url('cart'));
    }

    // Kurangi qty via AJAX di halaman beranda/menu — berbasis variant_id
    public function decrease_ajax()
    {
        $variantId = $this->request->getPost('variant_id');

        if (!$variantId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Varian tidak valid']);
        }

        $cart = $this->session->get('cart') ?? [];
        $menuId = $cart[$variantId]['menu_id'] ?? null;

        if (isset($cart[$variantId])) {
            if ($cart[$variantId]['quantity'] > 1) {
                $cart[$variantId]['quantity'] -= 1;
            } else {
                unset($cart[$variantId]);
            }
        }

        $this->session->set('cart', $cart);

        $cartCount = 0;
        $cartTotal = 0;
        foreach ($cart as $ci) {
            $cartCount += $ci['quantity'];
            $cartTotal += $ci['price'] * $ci['quantity'];
        }

        $menuQty = 0;
        if ($menuId) {
            foreach ($cart as $ci) {
                if ($ci['menu_id'] == $menuId) {
                    $menuQty += $ci['quantity'];
                }
            }
        }

        return $this->response->setJSON([
            'success'   => true,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
            'itemQty'   => isset($cart[$variantId]) ? $cart[$variantId]['quantity'] : 0,
            'menuQty'   => $menuQty,
            'menuId'    => $menuId,
        ]);
    }

    // Tombol (Hapus) menghilangkan item dari keranjang — berbasis variant_id
    public function remove($variantId)
    {
        $cart = $this->session->get('cart') ?? [];

        if (isset($cart[$variantId])) {
            unset($cart[$variantId]);
        }

        $this->session->set('cart', $cart);
        return redirect()->to(base_url('cart'))->with('success', 'Menu dihapus dari keranjang.');
    }

    public function checkout()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to(base_url('cart'))->with('error', 'Keranjang belanja masih kosong!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $db = \Config\Database::connect();
        $tables = $db->table('tables')->where('status', 'Tersedia')->get()->getResultArray();
        $data = [
            'cart'     => $cart,
            'subtotal' => $subtotal,
            'tables'   => $tables,
            'title'    => 'Checkout - FO\'Orders'
        ];

        return view('pelanggan/checkout', $data);
    }

    public function process()
    {
        $session = session();
        $cart = $session->get('cart');

        if (empty($cart)) {
            return redirect()->to(base_url('cart'))->with('error', 'Keranjang kosong!');
        }

        $db = \Config\Database::connect();

        $total_price = 0;
        foreach ($cart as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        $customerName = $this->request->getPost('customer_name');
        $tableId      = $this->request->getPost('table_id');
        $notes        = $this->request->getPost('notes');

        $orderNumber = 'OR' . strtoupper(substr(uniqid(), -8));

        $db->transStart();

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

        $orderId = $db->insertID();

        // variant_id dari key keranjang disertakan supaya detail pesanan tahu varian apa yang dipesan
        $orderItems = [];
        foreach ($cart as $variantId => $item) {
            $orderItems[] = [
                'order_id'       => $orderId,
                'menu_id'        => $item['menu_id'],
                'variant_id'     => $variantId,
                'quantity'       => $item['quantity'],
                'price_at_order' => $item['price'],
                'subtotal'       => $item['price'] * $item['quantity'],
            ];
        }
        $db->table('order_items')->insertBatch($orderItems);

        $db->table('tables')->where('id', $tableId)->update(['status' => 'Terisi']);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            $error = $db->error();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan. DEBUG: ' . $error['message'] . ' (code: ' . $error['code'] . ')');
        }

        $session->remove('cart');

        $myOrders = $session->get('my_orders') ?? [];
        $myOrders[] = $orderId;
        $session->set('my_orders', $myOrders);

        $session->setFlashdata('pesan_sukses', 'Yey! Pesanan kamu berhasil dibuat.');

        return redirect()->to(base_url('pelanggan'));
    }
}