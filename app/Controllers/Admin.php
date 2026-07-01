<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\TableModel;
use App\Models\MenuModel;

class Admin extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $tableModel;
    protected $menuModel;

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->tableModel     = new TableModel();
        $this->menuModel      = new MenuModel();
    }

    // ================= DASHBOARD =================
    public function index()
    {
        $data['orders'] = $this->orderModel
            ->select('orders.*, tables.table_number, tables.type as table_type')
            ->join('tables', 'tables.id = orders.table_id')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

        // BENERIN DI SINI: Diarahkan ke folder 'pesanan' bawaan lu cok!
        return view('admin/pesanan/index', $data);
    }

    // ================= DETAIL PESANAN =================
    public function detail($orderId)
    {
        $data['order'] = $this->orderModel
            ->select('orders.*, tables.table_number, tables.type as table_type')
            ->join('tables', 'tables.id = orders.table_id')
            ->find($orderId);

        if (!$data['order']) {
            return redirect()->to(base_url('admin'));
        }

        // BENERIN DI SINI: Key diganti 'order_items' biar kebaca sama file detail.php lu!
        $data['order_items'] = $this->orderItemModel
            ->select('order_items.*, menus.menu_name')
            ->join('menus', 'menus.id=order_items.menu_id')
            ->where('order_id', $orderId)
            ->findAll();

        // BENERIN DI SINI: Diarahkan ke folder 'pesanan' juga!
        return view('admin/pesanan/detail', $data);
    }

    // ================= UPDATE STATUS =================
    public function updateStatus($orderId)
    {
        $status = $this->request->getPost('order_status') ?? 'Diproses';

        $this->orderModel->update($orderId, [
            'order_status' => $status
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah');
    }

    // ================= PEMBAYARAN =================
    public function pay($orderId)
    {
        return $this->processPayment($orderId);
    }

    public function processPayment($orderId)
    {
        // FIX KUNCI UTAMA: Kita ganti ke getVar() murni untuk memaksa CI4 melacak value dropdown apa pun kondisinya!
        $paymentMethod = $this->request->getVar('payment_method') ?? 'Tunai';
        $amountPaid    = $this->request->getPost('amount_paid');
        $totalPayment  = $this->request->getPost('total_payment');

        if (empty($totalPayment)) {
            $orderData = $this->orderModel->find($orderId);
            $totalPayment = $orderData['total_payment'] ?? 0;
        }

        $change = 0;

        if ($paymentMethod == 'Tunai') {
            if (!empty($amountPaid)) {
                $change = $amountPaid - $totalPayment;
            } else {
                $amountPaid = $totalPayment;
            }
        } else {
            $amountPaid = $totalPayment;
        }

        $this->orderModel->update($orderId, [
            'payment_method' => $paymentMethod,
            'amount_paid'    => $amountPaid,
            'amount_change'  => $change,
            'order_status'   => 'Selesai'
        ]);

        return redirect()->to(base_url('admin/pesanan'))->with('success', 'Pembayaran berhasil dicatat!');
    }

    // ================= BATALKAN PESANAN =================
    public function batalkan($orderId)
    {
        $order = $this->orderModel->find($orderId);

        if ($order) {
            $db = \Config\Database::connect();
            $db->transStart();

            $this->orderModel->update($orderId, [
                'order_status' => 'Batal'
            ]);

            $db->table('tables')->where('id', $order['table_id'])->update([
                'status' => 'Tersedia'
            ]);

            $db->transComplete();

            return redirect()->to(base_url('admin/pesanan'))->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->to(base_url('admin/pesanan'))->with('error', 'Data tidak ditemukan.');
    }

    // =====================================================
    //                      MENU
    // =====================================================

    // Halaman Menu
    public function menu()
    {
        $data['daftar_menu'] = $this->menuModel->findAll();

        return view('admin/menu/index', $data);
    }

    // Tambah Menu
    public function add()
    {
        $gambar = $this->request->getFile('gambar');
        $namaFile = '';

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaFile = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/menus', $namaFile);
        }

        $this->menuModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'menu_name' => $this->request->getPost('menu_name'),
            'description' => '',
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'image_path' => $namaFile,
            'is_recommended' => 0,
            'is_active' => 1
        ]);

        return redirect()->to(base_url('admin/menu'));
    }

    // Edit Menu
    public function edit($id)
    {
        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'menu_name' => $this->request->getPost('menu_name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock')
        ];

        $gambar = $this->request->getFile('gambar');

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaFile = $gambar->getRandomName();
            $gambar->move(ROOTPATH.'public/uploads/menus', $namaFile);
            $data['image_path'] = $namaFile;
        }

        $this->menuModel->update($id,$data);

        return redirect()->to(base_url('admin/menu'));
    }

    // Hapus Menu
    public function delete($id)
    {
        $this->menuModel->delete($id);

        return redirect()->to(base_url('admin/menu'));
    }
}