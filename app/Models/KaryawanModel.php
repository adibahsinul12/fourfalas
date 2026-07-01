<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table            = 'karyawan';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'nama',
        'bidang',
        'no_hp',
        'email',
        'alamat',
        'foto',
        'status',
        'tanggal_masuk',
        'gaji',
    ];

    /**
     * Daftar bidang tetap yang dipakai di FO'orders.
     * Dipisah biar urutan tampilan di dashboard selalu konsisten,
     * termasuk kalau ada bidang yang belum punya karyawan sama sekali.
     */
    public const BIDANG_LIST = ['Waiters', 'Barista', 'Asisten Koki', 'Koki'];

    /**
     * Hitung total & jumlah aktif karyawan per bidang.
     * Hasil: ['Waiters' => ['total' => 2, 'aktif' => 2], ...]
     */
    public function countByBidang(): array
    {
        $rows = $this->select('bidang, COUNT(*) as total, SUM(CASE WHEN status = "Aktif" THEN 1 ELSE 0 END) as aktif')
                     ->groupBy('bidang')
                     ->findAll();

        // Susun berdasarkan bidang biar gampang diakses di view
        $result = [];
        foreach (self::BIDANG_LIST as $bidang) {
            $result[$bidang] = ['total' => 0, 'aktif' => 0];
        }
        foreach ($rows as $row) {
            $result[$row['bidang']] = [
                'total' => (int) $row['total'],
                'aktif' => (int) $row['aktif'],
            ];
        }

        return $result;
    }
}