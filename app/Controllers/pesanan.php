<?php

namespace App\Controllers;

use App\Models\RatingModel;

class Pesanan extends BaseController
{
    public function index()
    {
        $session = session();
        $myOrders = $session->get('my_orders') ?? [];

        $orders = [];

        if (!empty($myOrders)) {
            $db = \Config\Database::connect();

            $ordersData = $db->table('orders')
                              ->whereIn('id', $myOrders)
                              ->whereNotIn('order_status', ['Selesai', 'Dibatalkan'])
                              ->orderBy('id', 'DESC')
                              ->get()
                              ->getResultArray();

            foreach ($ordersData as $order) {
                $items = $db->table('order_items oi')
                             ->select('oi.quantity, oi.price_at_order, oi.subtotal, m.menu_name')
                             ->join('menus m', 'm.id = oi.menu_id', 'left')
                             ->where('oi.order_id', $order['id'])
                             ->get()
                             ->getResultArray();

                $table = $db->table('tables')
                             ->where('id', $order['table_id'])
                             ->get()
                             ->getRowArray();

                $order['items'] = $items;
                $order['table_number'] = $table['table_number'] ?? '-';

                $orders[] = $order;
            }
        }

        $data['orders'] = $orders;

        return view('pelanggan/pesanan', $data);
    }

    public function riwayat()
    {
        $session = session();

        $myOrders = $session->get('my_orders') ?? [];
        $orders = [];

        if (!empty($myOrders)) {
            $db = \Config\Database::connect();

            $today = date('Y-m-d');

            $ordersData = $db->table('orders')
                      ->whereIn('id', $myOrders)
                      ->whereIn('order_status', ['Selesai', 'Dibatalkan'])
                      ->where('created_at >=', $today . ' 00:00:00')
                      ->where('created_at <=', $today . ' 23:59:59')
                      ->orderBy('id', 'DESC')
                      ->get()
                      ->getResultArray();

            $ratingModel = new RatingModel();

            foreach ($ordersData as $order) {
                $items = $db->table('order_items oi')
                             ->select('oi.quantity, oi.price_at_order, oi.subtotal, m.menu_name')
                             ->join('menus m', 'm.id = oi.menu_id', 'left')
                             ->where('oi.order_id', $order['id'])
                             ->get()
                             ->getResultArray();

                $table = $db->table('tables')
                             ->where('id', $order['table_id'])
                             ->get()
                             ->getRowArray();

                $order['items'] = $items;
                $order['table_number'] = $table['table_number'] ?? '-';

                // Cek apakah pesanan ini sudah pernah dirating
                $order['rating'] = $ratingModel->where('id_pesanan', $order['id'])->first();

                $orders[] = $order;
            }
        }

        $data['orders'] = $orders;

        return view('pelanggan/riwayat', $data);
    }

    /**
     * Simpan rating dari pelanggan untuk sebuah pesanan.
     * Hanya boleh untuk pesanan milik pelanggan itu sendiri (dicek via session my_orders),
     * hanya untuk pesanan berstatus 'Selesai', dan hanya sekali per pesanan.
     */
    public function simpanRating($orderId)
    {
        $session  = session();
        $myOrders = $session->get('my_orders') ?? [];

        // Pastikan pesanan ini memang milik pelanggan (via session)
        if (!in_array($orderId, $myOrders)) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $db = \Config\Database::connect();
        $order = $db->table('orders')
                    ->where('id', $orderId)
                    ->where('order_status', 'Selesai')
                    ->get()
                    ->getRowArray();

        // Hanya pesanan berstatus Selesai yang boleh dirating
        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan belum selesai atau tidak valid.');
        }

        $ratingModel = new RatingModel();

        // Cegah rating ganda untuk pesanan yang sama
        $sudahAda = $ratingModel->where('id_pesanan', $orderId)->first();
        if ($sudahAda) {
            return redirect()->back()->with('error', 'Pesanan ini sudah pernah diberi rating.');
        }

        $ratingValue = (int) $this->request->getPost('rating');
        $komentar    = $this->request->getPost('komentar');

        if ($ratingValue < 1 || $ratingValue > 5) {
            return redirect()->back()->with('error', 'Silakan pilih bintang terlebih dahulu.');
        }

        $ratingModel->insert([
            'id_pesanan'     => $orderId,
            'nama_pelanggan' => $order['customer_name'],
            'rating'         => $ratingValue,
            'komentar'       => $komentar,
            'tanggal'        => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('pesanan/riwayat'))->with('success', 'Terima kasih atas penilaian Anda!');
    }
}