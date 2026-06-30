<?php

namespace App\Controllers;

class Pesanan extends BaseController
{
    public function index()
    {
        $session = session();
        $myOrders = $session->get('my_orders') ?? [];

        $orders = [];

        if (!empty($myOrders)) {
            $db = \Config\Database::connect();

            // Ambil data orders milik pelanggan ini, urutkan dari yang terbaru
            $ordersData = $db->table('orders')
                              ->whereIn('id', $myOrders)
                              ->orderBy('id', 'DESC')
                              ->get()
                              ->getResultArray();

            foreach ($ordersData as $order) {
                // Ambil detail item pesanan, join ke tabel menus untuk nama menu
                $items = $db->table('order_items oi')
                             ->select('oi.quantity, oi.price_at_order, oi.subtotal, m.menu_name')
                             ->join('menus m', 'm.id = oi.menu_id', 'left')
                             ->where('oi.order_id', $order['id'])
                             ->get()
                             ->getResultArray();

                // Ambil info meja
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
}