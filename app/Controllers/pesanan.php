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

    // === TAMBAHAN: pindah ke SINI, masih di dalam class ===
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

    return view('pelanggan/riwayat', $data);
}
    // === SAMPAI SINI ===

} // <- kurung tutup class, HARUS paling akhir file