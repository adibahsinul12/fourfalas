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

        return view('admin/orders/index', $data);
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

        $data['items'] = $this->orderItemModel
            ->select('order_items.*, menus.menu_name')
            ->join('menus', 'menus.id=order_items.menu_id')
            ->where('order_id', $orderId)
            ->findAll();

        return view('admin/orders/detail', $data);
    }

    // ================= UPDATE STATUS =================
    public function updateStatus($orderId)
    {
        $status = $this->request->getPost('order_status');

        $this->orderModel->update($orderId, [
            'order_status' => $status
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah');
    }

    // ================= PEMBAYARAN =================
    public function processPayment($orderId)
    {
        $paymentMethod = $this->request->getPost('payment_method');
        $amountPaid    = $this->request->getPost('amount_paid');
        $totalPayment  = $this->request->getPost('total_payment');

        $change = 0;

        if ($paymentMethod == 'Tunai') {
            $change = $amountPaid - $totalPayment;
        } else {
            $amountPaid = $totalPayment;
        }

        $this->orderModel->update($orderId, [
            'payment_method' => $paymentMethod,
            'amount_paid'    => $amountPaid,
            'amount_change'  => $change,
            'order_status'   => 'Selesai'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil');
    }

    // =====================================================
    //                    MENU
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