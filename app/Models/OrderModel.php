<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $allowedFields    = [
        'order_number', 
        'table_id', 
        'customer_name', 
        'customer_phone', 
        'notes', 
        'order_status', 
        'payment_method', 
        'subtotal', 
        'tax_amount', 
        'total_payment', 
        'amount_paid', 
        'amount_change',
        'created_at' // Kolom ini ada di SQL, opsional diisi manual jika tidak pakai default DB
    ];

    // Total penjualan per bulan untuk tahun tertentu (default: tahun berjalan)
    // Dipakai untuk grafik penjualan di dashboard owner
    public function getMonthlySales($year = null)
    {
        $year = $year ?? date('Y');

        return $this->select("MONTH(created_at) as bulan, SUM(total_payment) as total, COUNT(*) as jumlah_pesanan")
            ->where('YEAR(created_at)', $year)
            ->groupBy('MONTH(created_at)')
            ->orderBy('bulan', 'ASC')
            ->findAll();
    }
}