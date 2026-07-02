<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\TableModel;
use App\Models\MenuModel;
use App\Models\VariantModel; 

class Admin extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $tableModel;
    protected $menuModel;
    protected $variantModel; 

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->tableModel     = new TableModel();
        $this->menuModel      = new MenuModel();
        $this->variantModel   = new VariantModel(); 
    }

    // ================= DASHBOARD =================
    public function index()
    {
        $data['orders'] = $this->orderModel
            ->select('orders.*, tables.table_number, tables.type as table_type')
            ->join('tables', 'tables.id = orders.table_id')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

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

        $db = \Config\Database::connect();
        $data['order_items'] = $db->table('order_items')
            ->select('order_items.*, menus.menu_name, menu_variants.variant_name')
            ->join('menus', 'menus.id = order_items.menu_id')
            ->join('menu_variants', 'menu_variants.id = order_items.variant_id', 'left')
            ->where('order_items.order_id', $orderId)
            ->get()
            ->getResultArray();

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
    //                      MENU (CRUD + VARIANT)
    // =====================================================

    public function menu()
    {
        $data['daftar_menu'] = $this->menuModel->findAll();
        return view('admin/menu/index', $data);
    }

    // FIXED TAMBAH MENU: Menggunakan Query Builder Murni agar kebal dari error Unknown Column 'price'
    public function add()
    {
        $gambar = $this->request->getFile('gambar');
        $namaFile = '';

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaFile = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/menus', $namaFile);
        }

        $isRecommended = $this->request->getPost('is_recommended') ?? 0;

        $db = \Config\Database::connect();
        
        // Menggunakan insert builder langsung ke tabel menus tanpa lewat model logic
        $db->table('menus')->insert([
            'category_id'    => $this->request->getPost('category_id'),
            'menu_name'      => $this->request->getPost('menu_name'),
            'description'    => '',
            'image_path'     => $namaFile,
            'is_recommended' => $isRecommended, 
            'is_active'      => 1
        ]);

        $menuId = $db->insertID(); 

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

        return redirect()->to(base_url('admin/menu'));
    }

    // FIXED EDIT MENU: Menggunakan Query Builder Murni agar kebal dari sisa data request price/stock
    public function edit($id)
    {
        $isRecommended = $this->request->getPost('is_recommended') ?? 0;

        $menuData = [
            'category_id'    => $this->request->getPost('category_id'),
            'menu_name'      => $this->request->getPost('menu_name'),
            'is_recommended' => $isRecommended
        ];

        $gambar = $this->request->getFile('gambar');

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaFile = $gambar->getRandomName();
            $gambar->move(ROOTPATH.'public/uploads/menus', $namaFile);
            $menuData['image_path'] = $namaFile;
        }

        $db = \Config\Database::connect();
        
        // Update paksa tabel menus murni
        $db->table('menus')->where('id', $id)->update($menuData);

        // Reset dan re-insert tabel varian menu
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

        return redirect()->to(base_url('admin/menu'));
    }

    public function delete($id)
    {
        $this->menuModel->delete($id);
        return redirect()->to(base_url('admin/menu'));
    }
}