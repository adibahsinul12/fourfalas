<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table         = 'rating';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['id_pesanan', 'nama_pelanggan', 'rating', 'komentar', 'tanggal'];
    protected $useTimestamps = false;
    protected $returnType    = 'array';

    // =========================================================
    // METHOD LAMA — dipakai di Owner\Dashboard::index()
    // Tetap dipertahankan biar Dashboard tidak error.
    // =========================================================

    public function getAverageRating()
    {
        $row = $this->selectAvg('rating')->first();
        return $row['rating'] ? round($row['rating'], 1) : 0;
    }

    public function getRecent(int $jumlah = 5)
    {
        return $this->orderBy('tanggal', 'DESC')
                     ->findAll($jumlah);
    }

    // =========================================================
    // METHOD BARU — dipakai di Owner\Rating::index()
    // =========================================================

    public function getRataRating()
    {
        $row = $this->selectAvg('rating')->first();
        return $row['rating'] ?? 0;
    }

    public function getTotalRating()
    {
        return $this->countAllResults();
    }

    public function getDistribusiBintang()
    {
        $distribusi = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        $result = $this->select('rating, COUNT(*) as jumlah')
                        ->groupBy('rating')
                        ->findAll();

        foreach ($result as $row) {
            $bintang = (int) $row['rating'];
            if (isset($distribusi[$bintang])) {
                $distribusi[$bintang] = (int) $row['jumlah'];
            }
        }

        return $distribusi;
    }

    public function getUlasan($filterBintang = null)
    {
        $builder = $this->orderBy('tanggal', 'DESC');

        if ($filterBintang !== null && $filterBintang !== '') {
            $builder = $builder->where('rating', (int) $filterBintang);
        }

        return $builder->findAll();
    }
}