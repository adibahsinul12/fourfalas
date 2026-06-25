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
        // Inisialisasi model-model yang sudah ada di folder Models kamu
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->tableModel     = new TableModel();
        $this->menuModel      = new MenuModel();
    }

    // Menampilkan daftar pesanan masuk (Dashboard Admin/Kasir)
    public function index()
    {
        // Join ke tabel tables untuk mendapatkan nomor meja pelanggan
        $data['orders'] = $this->orderModel->select('orders.*, tables.table_number, tables.type as table_type')
                                           ->join('tables', 'tables.id = orders.table_id')
                                           ->orderBy('orders.created_at', 'DESC')
                                           ->findAll();

        return view('admin/orders/index', $data);
    }

    // Melihat detail item menu yang dipesan di dalam satu struk/order
    public function detail($orderId)
    {
        $data['order'] = $this->orderModel->select('orders.*, tables.table_number, tables.type as table_type')
                                          ->join('tables', 'tables.id = orders.table_id')
                                          ->find($orderId);

        if (!$data['order']) {
            return redirect()->to(base_url('admin'))->with('error', 'Pesanan tidak ditemukan.');
        }

        // Ambil semua makanan/minuman yang dibeli berdasarkan order_id
        $data['items'] = $this->orderItemModel->select('order_items.*, menus.menu_name')
                                              ->join('menus', 'menus.id = order_items.menu_id')
                                              ->where('order_id', $orderId)
                                              ->findAll();

        return view('admin/orders/detail', $data);
    }

    // Update status pesanan (Menunggu -> Diproses -> Siap Diantar -> Selesai)
    public function updateStatus($orderId)
    {
        $status = $this->request->getPost('order_status');
        
        // Validasi isi enum sesuai database fourfalas
        $validStatus = ['Menunggu', 'Diproses', 'Siap Diantar', 'Selesai', 'Dibatalkan'];
        if (!in_array($status, $validStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->orderModel->update($orderId, ['order_status' => $status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // Kasir memproses pembayaran transaksi
    public function processPayment($orderId)
    {
        $paymentMethod = $this->request->getPost('payment_method'); // Tunai, QRIS, Debit
        $amountPaid    = (float) $this->request->getPost('amount_paid');
        $totalPayment  = (float) $this->request->getPost('total_payment');

        $amountChange = 0;
        if ($paymentMethod === 'Tunai') {
            if ($amountPaid < $totalPayment) {
                return redirect()->back()->with('error', 'Uang pembayaran kurang!');
            }
            $amountChange = $amountPaid - $totalPayment;
        } else {
            // Jika non-tunai (QRIS/Debit) dianggap uang pas
            $amountPaid = $totalPayment;
        }

        // Simpan ke database dan set status otomatis ke 'Selesai'
        $this->orderModel->update($orderId, [
            'payment_method' => $paymentMethod,
            'amount_paid'    => $amountPaid,
            'amount_change'  => $amountChange,
            'order_status'   => 'Selesai'
        ]);

        return redirect()->to(base_url('admin/detail/' . $orderId))->with('success', 'Pembayaran sukses diproses!');
    }
}