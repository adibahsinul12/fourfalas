<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table         = 'rating';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    protected $allowedFields = [
        'id_pesanan',
        'nama_pelanggan',
        'rating',
        'komentar',
        'tanggal',
    ];

    /**
     * Rata-rata rating dibulatkan 1 angka desimal. 0 kalau belum ada data.
     */
    public function getAverageRating(): float
    {
        $result = $this->selectAvg('rating', 'avg_rating')->first();
        return round((float) ($result['avg_rating'] ?? 0), 1);
    }

    /**
     * Rating terbaru untuk ditampilkan di dashboard.
     */
    public function getRecent(int $limit = 5): array
    {
        return $this->orderBy('tanggal', 'DESC')->findAll($limit);
    }
}