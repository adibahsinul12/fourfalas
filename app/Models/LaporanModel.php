<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'orders';

    /**
     * Total pendapatan (hanya order yang statusnya Selesai)
     */
    public function getTotalPendapatan(string $start, string $end)
    {
        $row = $this->selectSum('total_payment')
            ->where('order_status', 'Selesai')
            ->where('DATE(created_at) >=', $start)
            ->where('DATE(created_at) <=', $end)
            ->first();

        return $row['total_payment'] ?? 0;
    }

    /**
     * Jumlah transaksi yang berhasil (Selesai)
     */
    public function getTotalTransaksi(string $start, string $end): int
    {
        return $this->where('order_status', 'Selesai')
            ->where('DATE(created_at) >=', $start)
            ->where('DATE(created_at) <=', $end)
            ->countAllResults();
    }

    /**
     * Jumlah order yang dibatalkan (buat konteks, bukan dihitung ke pendapatan)
     */
    public function getTotalDibatalkan(string $start, string $end): int
    {
        return $this->where('order_status', 'Dibatalkan')
            ->where('DATE(created_at) >=', $start)
            ->where('DATE(created_at) <=', $end)
            ->countAllResults();
    }

    /**
     * Pendapatan per hari, buat grafik bar sederhana
     */
    public function getPendapatanHarian(string $start, string $end): array
    {
        $result = $this->select('DATE(created_at) as tanggal, SUM(total_payment) as total')
            ->where('order_status', 'Selesai')
            ->where('DATE(created_at) >=', $start)
            ->where('DATE(created_at) <=', $end)
            ->groupBy('DATE(created_at)')
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $data = [];
        foreach ($result as $row) {
            $data[$row['tanggal']] = (float) $row['total'];
        }

        return $data;
    }

    /**
     * Pendapatan per metode pembayaran (Tunai / QRIS / Debit)
     */
    public function getPendapatanPerMetode(string $start, string $end): array
    {
        $result = $this->select('payment_method, SUM(total_payment) as total, COUNT(*) as jumlah')
            ->where('order_status', 'Selesai')
            ->where('DATE(created_at) >=', $start)
            ->where('DATE(created_at) <=', $end)
            ->groupBy('payment_method')
            ->findAll();

        $data = [];
        foreach ($result as $row) {
            $metode = $row['payment_method'] ?? 'Belum diketahui';
            $data[$metode] = [
                'total'  => (float) $row['total'],
                'jumlah' => (int) $row['jumlah'],
            ];
        }

        return $data;
    }

    /**
     * Menu terlaris berdasarkan jumlah quantity terjual
     */
    public function getMenuTerlaris(string $start, string $end, int $limit = 5): array
    {
        $db = $this->db;

        $builder = $db->table('order_items oi');
        $builder->select('menus.menu_name, SUM(oi.quantity) as total_terjual, SUM(oi.subtotal) as total_omzet');
        $builder->join('orders', 'orders.id = oi.order_id');
        $builder->join('menus', 'menus.id = oi.menu_id');
        $builder->where('orders.order_status', 'Selesai');
        $builder->where('DATE(orders.created_at) >=', $start);
        $builder->where('DATE(orders.created_at) <=', $end);
        $builder->groupBy('oi.menu_id');
        $builder->orderBy('total_terjual', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }

    /**
     * Daftar transaksi lengkap dalam rentang tanggal (semua status, buat tabel riwayat)
     */
    public function getDaftarTransaksi(string $start, string $end): array
    {
        return $this->select('id, order_number, customer_name, order_status, payment_method, total_payment, created_at')
            ->where('DATE(created_at) >=', $start)
            ->where('DATE(created_at) <=', $end)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}